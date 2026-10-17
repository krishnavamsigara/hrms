-- ====================================================================
-- HRMS PAYROLL PROCEDURES REBUILD & SYNCHRONIZATION
-- Guarantees exact salary structure capture (e.g. 25k -> 30k) in payroll cycles
-- Automatically adds new salary components to all active employees
-- ====================================================================

-- 1. sp_create_payroll_run
DROP PROCEDURE IF EXISTS sp_create_payroll_run;
DELIMITER //
CREATE PROCEDURE sp_create_payroll_run(
    IN p_payroll_month INT,
    IN p_payroll_year INT,
    IN p_salary_day_basis VARCHAR(20),
    IN p_admin_emp_id VARCHAR(20),
    OUT p_run_id BIGINT,
    OUT p_status VARCHAR(10),
    OUT p_message VARCHAR(255)
)
BEGIN
    DECLARE v_start_day INT DEFAULT 25;
    DECLARE v_end_day INT DEFAULT 24;
    DECLARE v_prev_month INT;
    DECLARE v_prev_year INT;
    DECLARE v_period_start DATE;
    DECLARE v_period_end DATE;
    DECLARE v_existing_id BIGINT;
    DECLARE v_day_basis VARCHAR(20) DEFAULT 'FIXED_30';

    IF p_payroll_month < 1 OR p_payroll_month > 12 THEN
        SET p_run_id = 0;
        SET p_status = 'ERROR';
        SET p_message = 'Invalid payroll month (must be 1-12)';
    ELSEIF p_payroll_year < 2000 THEN
        SET p_run_id = 0;
        SET p_status = 'ERROR';
        SET p_message = 'Invalid payroll year';
    ELSE
        SELECT IFNULL(payroll_cycle_start_day, 25), IFNULL(payroll_cycle_end_day, 24)
        INTO v_start_day, v_end_day
        FROM company_settings
        LIMIT 1;

        IF v_start_day > v_end_day THEN
            IF p_payroll_month = 1 THEN
                SET v_prev_month = 12;
                SET v_prev_year = p_payroll_year - 1;
            ELSE
                SET v_prev_month = p_payroll_month - 1;
                SET v_prev_year = p_payroll_year;
            END IF;
            SET v_period_start = STR_TO_DATE(CONCAT(v_prev_year, '-', LPAD(v_prev_month, 2, '0'), '-', LPAD(v_start_day, 2, '0')), '%Y-%m-%d');
            SET v_period_end   = STR_TO_DATE(CONCAT(p_payroll_year, '-', LPAD(p_payroll_month, 2, '0'), '-', LPAD(v_end_day, 2, '0')), '%Y-%m-%d');
        ELSE
            SET v_period_start = STR_TO_DATE(CONCAT(p_payroll_year, '-', LPAD(p_payroll_month, 2, '0'), '-', LPAD(v_start_day, 2, '0')), '%Y-%m-%d');
            SET v_period_end   = STR_TO_DATE(CONCAT(p_payroll_year, '-', LPAD(p_payroll_month, 2, '0'), '-', LPAD(v_end_day, 2, '0')), '%Y-%m-%d');
        END IF;

        IF p_salary_day_basis IS NOT NULL AND p_salary_day_basis != '' THEN
            SET v_day_basis = p_salary_day_basis;
        END IF;

        SELECT payroll_run_id INTO v_existing_id
        FROM payroll_run
        WHERE payroll_month = p_payroll_month AND payroll_year = p_payroll_year
        LIMIT 1;

        IF v_existing_id IS NOT NULL THEN
            SET p_run_id = v_existing_id;
            SET p_status = 'EXISTING';
            SET p_message = CONCAT('Payroll run already exists for this period (Run ID: ', v_existing_id, ')');
        ELSE
            INSERT INTO payroll_run (
                payroll_month, payroll_year, period_start, period_end,
                salary_day_basis, payroll_status, employee_count,
                created_by, created_at
            ) VALUES (
                p_payroll_month, p_payroll_year, v_period_start, v_period_end,
                v_day_basis, 'DRAFT', 0,
                p_admin_emp_id, NOW()
            );

            SET p_run_id = LAST_INSERT_ID();
            SET p_status = 'SUCCESS';
            SET p_message = 'Payroll run created successfully';
        END IF;
    END IF;
END //
DELIMITER ;


-- 2. sp_calculate_employee_payroll (Robust salary structure & cycle capture)
DROP PROCEDURE IF EXISTS sp_calculate_employee_payroll;
DELIMITER //
CREATE PROCEDURE sp_calculate_employee_payroll(
    IN p_run_id BIGINT,
    IN p_emp_id VARCHAR(20),
    IN p_admin_emp_id VARCHAR(20),
    OUT p_status VARCHAR(10),
    OUT p_message VARCHAR(255)
)
BEGIN
    DECLARE v_month INT;
    DECLARE v_year INT;
    DECLARE v_period_start DATE;
    DECLARE v_period_end DATE;
    DECLARE v_day_basis VARCHAR(20);
    DECLARE v_run_status VARCHAR(20);

    DECLARE v_structure_id BIGINT DEFAULT NULL;
    DECLARE v_monthly_ctc DECIMAL(12,2) DEFAULT 0.00;

    DECLARE v_summary_id BIGINT DEFAULT NULL;
    DECLARE v_total_days DECIMAL(6,2) DEFAULT 30.00;
    DECLARE v_working_days DECIMAL(6,2) DEFAULT 22.00;
    DECLARE v_present_days DECIMAL(6,2) DEFAULT 22.00;
    DECLARE v_wfh_days DECIMAL(6,2) DEFAULT 0.00;
    DECLARE v_leave_days DECIMAL(6,2) DEFAULT 0.00;
    DECLARE v_holiday_days DECIMAL(6,2) DEFAULT 0.00;
    DECLARE v_weekly_off_days DECIMAL(6,2) DEFAULT 0.00;
    DECLARE v_unpaid_days DECIMAL(6,2) DEFAULT 0.00;
    DECLARE v_paid_days DECIMAL(6,2) DEFAULT 30.00;
    DECLARE v_lop_days DECIMAL(6,2) DEFAULT 0.00;

    DECLARE v_denominator DECIMAL(6,2) DEFAULT 30.00;
    DECLARE v_gross_earnings DECIMAL(12,2) DEFAULT 0.00;
    DECLARE v_lop_deduction DECIMAL(12,2) DEFAULT 0.00;
    DECLARE v_other_deductions DECIMAL(12,2) DEFAULT 0.00;
    DECLARE v_employer_contributions DECIMAL(12,2) DEFAULT 0.00;
    DECLARE v_net_salary DECIMAL(12,2) DEFAULT 0.00;

    DECLARE v_pe_id BIGINT;

    -- Component cursor variables
    DECLARE done INT DEFAULT FALSE;
    DECLARE c_comp_id BIGINT;
    DECLARE c_comp_code VARCHAR(30);
    DECLARE c_comp_name VARCHAR(100);
    DECLARE c_comp_type VARCHAR(30);
    DECLARE c_calc_type VARCHAR(30);
    DECLARE c_monthly_amt DECIMAL(12,2);
    DECLARE c_pct_val DECIMAL(7,4);
    DECLARE c_lop_app TINYINT(1);
    DECLARE c_calc_amt DECIMAL(12,2);
    DECLARE c_lop_amt DECIMAL(12,2);
    DECLARE c_payable_amt DECIMAL(12,2);

    DECLARE cur_comp CURSOR FOR
        SELECT 
            m.component_id,
            m.component_code,
            m.component_name,
            m.component_type,
            m.calculation_type,
            IFNULL(esc.monthly_amount, 0.00),
            esc.percentage_value,
            m.is_lop_applicable
        FROM employee_salary_component esc
        JOIN salary_component_master m ON esc.component_id = m.component_id
        WHERE esc.salary_structure_id = v_structure_id
          AND esc.is_active = 1
          AND m.is_active = 1
        ORDER BY m.component_type ASC, m.component_id ASC;

    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;

    -- 1. Validate payroll run
    SELECT payroll_month, payroll_year, period_start, period_end, salary_day_basis, payroll_status
    INTO v_month, v_year, v_period_start, v_period_end, v_day_basis, v_run_status
    FROM payroll_run
    WHERE payroll_run_id = p_run_id
    LIMIT 1;

    IF v_month IS NULL THEN
        SET p_status = 'ERROR';
        SET p_message = 'Payroll run not found';
    ELSEIF v_run_status = 'FINALIZED' THEN
        SET p_status = 'ERROR';
        SET p_message = 'Cannot recalculate a finalized payroll run';
    ELSE
        -- 2. Find exact approved salary structure
        -- A: Primary lookup by period match
        SELECT salary_structure_id, monthly_ctc
        INTO v_structure_id, v_monthly_ctc
        FROM employee_salary_structure
        WHERE emp_id = p_emp_id
          AND payroll_status IN ('APPROVED', 'ACTIVE')
          AND effective_from <= v_period_end
          AND (effective_to IS NULL OR effective_to >= v_period_start)
        ORDER BY structure_version DESC, effective_from DESC
        LIMIT 1;

        -- B: Fallback lookup - pick the latest approved/active structure if exact period window has gap
        IF v_structure_id IS NULL THEN
            SELECT salary_structure_id, monthly_ctc
            INTO v_structure_id, v_monthly_ctc
            FROM employee_salary_structure
            WHERE emp_id = p_emp_id
              AND payroll_status IN ('APPROVED', 'ACTIVE')
            ORDER BY structure_version DESC, salary_structure_id DESC
            LIMIT 1;
        END IF;

        IF v_structure_id IS NULL THEN
            -- Record error in payroll_employee
            INSERT INTO payroll_employee (
                payroll_run_id, emp_id, salary_structure_id,
                calculation_status, calculation_message, created_at, updated_at
            ) VALUES (
                p_run_id, p_emp_id, 0,
                'ERROR', 'No approved salary structure found for period', NOW(), NOW()
            ) ON DUPLICATE KEY UPDATE
                calculation_status = 'ERROR',
                calculation_message = 'No approved salary structure found for period',
                updated_at = NOW();

            SET p_status = 'ERROR';
            SET p_message = 'No approved salary structure found';
        ELSE
            -- 3. Read attendance summary
            SELECT summary_id, total_days, working_days, present_days, wfh_days, leave_days, holiday_days, weekly_off_days, unpaid_days, paid_days
            INTO v_summary_id, v_total_days, v_working_days, v_present_days, v_wfh_days, v_leave_days, v_holiday_days, v_weekly_off_days, v_unpaid_days, v_paid_days
            FROM payroll_attendance_summary
            WHERE emp_id = p_emp_id AND payroll_month = v_month AND payroll_year = v_year
            LIMIT 1;

            IF v_summary_id IS NOT NULL THEN
                SET v_lop_days = IFNULL(v_unpaid_days, 0.00);
            ELSE
                SET v_total_days = 30.00;
                SET v_working_days = 22.00;
                SET v_paid_days = 30.00;
                SET v_lop_days = 0.00;
            END IF;

            -- 4. Determine salary basis denominator
            IF v_day_basis = 'FIXED_30' THEN
                SET v_denominator = 30.00;
            ELSEIF v_day_basis = 'CALENDAR_DAYS' THEN
                SET v_denominator = DATEDIFF(v_period_end, v_period_start) + 1;
            ELSEIF v_day_basis = 'WORKING_DAYS' THEN
                SET v_denominator = IF(v_working_days > 0, v_working_days, 30.00);
            ELSE
                SET v_denominator = 30.00;
            END IF;

            IF v_denominator <= 0 THEN
                SET v_denominator = 30.00;
            END IF;

            -- 5. Upsert payroll_employee record with EXACT monthly_ctc (e.g. 30k)
            INSERT INTO payroll_employee (
                payroll_run_id, emp_id, salary_structure_id, attendance_summary_id,
                total_days, working_days, paid_days, lop_days,
                monthly_ctc, calculation_status, calculation_message,
                created_at, updated_at
            ) VALUES (
                p_run_id, p_emp_id, v_structure_id, v_summary_id,
                v_total_days, v_working_days, v_paid_days, v_lop_days,
                v_monthly_ctc, 'CALCULATED', 'Calculation in progress',
                NOW(), NOW()
            ) ON DUPLICATE KEY UPDATE
                salary_structure_id = v_structure_id,
                attendance_summary_id = v_summary_id,
                total_days = v_total_days,
                working_days = v_working_days,
                paid_days = v_paid_days,
                lop_days = v_lop_days,
                monthly_ctc = v_monthly_ctc,
                calculation_status = 'CALCULATED',
                calculation_message = 'Calculation in progress',
                updated_at = NOW();

            SELECT payroll_employee_id INTO v_pe_id
            FROM payroll_employee
            WHERE payroll_run_id = p_run_id AND emp_id = p_emp_id;

            -- Clear existing component snapshots for recalculation
            DELETE FROM payroll_employee_component WHERE payroll_employee_id = v_pe_id;

            -- 6. Loop over salary components
            SET done = FALSE;
            SET v_gross_earnings = 0.00;
            SET v_lop_deduction = 0.00;
            SET v_other_deductions = 0.00;
            SET v_employer_contributions = 0.00;

            OPEN cur_comp;
            comp_loop: LOOP
                FETCH cur_comp INTO c_comp_id, c_comp_code, c_comp_name, c_comp_type, c_calc_type, c_monthly_amt, c_pct_val, c_lop_app;
                IF done THEN
                    LEAVE comp_loop;
                END IF;

                SET c_calc_amt = c_monthly_amt;
                SET c_lop_amt = 0.00;
                SET c_payable_amt = c_monthly_amt;

                IF c_comp_type = 'EARNING' THEN
                    IF c_lop_app = 1 AND v_lop_days > 0 THEN
                        SET c_lop_amt = ROUND((c_monthly_amt / v_denominator) * v_lop_days, 2);
                        SET c_payable_amt = GREATEST(0, c_monthly_amt - c_lop_amt);
                    ELSE
                        SET c_lop_amt = 0.00;
                        SET c_payable_amt = c_monthly_amt;
                    END IF;

                    SET v_gross_earnings = v_gross_earnings + c_payable_amt;
                    SET v_lop_deduction = v_lop_deduction + c_lop_amt;

                ELSEIF c_comp_type = 'DEDUCTION' THEN
                    SET c_lop_amt = 0.00;
                    SET c_payable_amt = c_monthly_amt;
                    SET v_other_deductions = v_other_deductions + c_payable_amt;

                ELSEIF c_comp_type = 'EMPLOYER_CONTRIBUTION' THEN
                    SET c_lop_amt = 0.00;
                    SET c_payable_amt = c_monthly_amt;
                    SET v_employer_contributions = v_employer_contributions + c_payable_amt;
                END IF;

                -- Insert component snapshot
                INSERT INTO payroll_employee_component (
                    payroll_employee_id, component_id, component_code, component_name, component_type,
                    monthly_amount, calculated_amount, lop_amount, payable_amount, calculation_details,
                    created_at
                ) VALUES (
                    v_pe_id, c_comp_id, c_comp_code, c_comp_name, c_comp_type,
                    c_monthly_amt, c_calc_amt, c_lop_amt, c_payable_amt,
                    JSON_OBJECT(
                        'denominator', v_denominator,
                        'lop_days', v_lop_days,
                        'is_lop_applicable', c_lop_app,
                        'percentage_value', c_pct_val
                    ),
                    NOW()
                );
            END LOOP;
            CLOSE cur_comp;

            -- 7. Net salary calculation
            SET v_net_salary = GREATEST(0, v_gross_earnings - v_other_deductions);

            -- 8. Final update on payroll_employee with exact calculated figures
            UPDATE payroll_employee
            SET gross_earnings = v_gross_earnings,
                lop_deduction = v_lop_deduction,
                other_deductions = v_other_deductions,
                employer_contributions = v_employer_contributions,
                net_salary = v_net_salary,
                monthly_ctc = v_monthly_ctc,
                calculation_status = 'CALCULATED',
                calculation_message = 'Calculated successfully',
                updated_at = NOW()
            WHERE payroll_employee_id = v_pe_id;

            SET p_status = 'SUCCESS';
            SET p_message = 'Employee payroll calculated successfully';
        END IF;
    END IF;
END //
DELIMITER ;


-- 3. sp_calculate_monthly_payroll
DROP PROCEDURE IF EXISTS sp_calculate_monthly_payroll;
DELIMITER //
CREATE PROCEDURE sp_calculate_monthly_payroll(
    IN p_run_id BIGINT,
    IN p_admin_emp_id VARCHAR(20),
    OUT p_processed_count INT,
    OUT p_error_count INT,
    OUT p_status VARCHAR(10),
    OUT p_message VARCHAR(255)
)
BEGIN
    DECLARE v_run_status VARCHAR(20);
    DECLARE done INT DEFAULT FALSE;
    DECLARE v_emp_id VARCHAR(20);
    DECLARE v_emp_status VARCHAR(10);
    DECLARE v_emp_msg VARCHAR(255);

    DECLARE cur_emp CURSOR FOR
        SELECT emp_id
        FROM user_details
        WHERE LOWER(profisional_details_status) = 'active'
        ORDER BY emp_id ASC;

    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;

    SET p_processed_count = 0;
    SET p_error_count = 0;

    SELECT payroll_status INTO v_run_status
    FROM payroll_run
    WHERE payroll_run_id = p_run_id;

    IF v_run_status IS NULL THEN
        SET p_status = 'ERROR';
        SET p_message = 'Payroll run not found';
    ELSEIF v_run_status = 'FINALIZED' THEN
        SET p_status = 'ERROR';
        SET p_message = 'Cannot recalculate a finalized payroll run';
    ELSE
        OPEN cur_emp;
        emp_loop: LOOP
            FETCH cur_emp INTO v_emp_id;
            IF done THEN
                LEAVE emp_loop;
            END IF;

            CALL sp_calculate_employee_payroll(p_run_id, v_emp_id, p_admin_emp_id, v_emp_status, v_emp_msg);

            IF v_emp_status = 'SUCCESS' THEN
                SET p_processed_count = p_processed_count + 1;
            ELSE
                SET p_error_count = p_error_count + 1;
            END IF;
        END LOOP;
        CLOSE cur_emp;

        UPDATE payroll_run
        SET employee_count = p_processed_count,
            payroll_status = 'CALCULATED',
            calculated_by = p_admin_emp_id,
            calculated_at = NOW()
        WHERE payroll_run_id = p_run_id;

        IF p_error_count > 0 THEN
            SET p_status = 'PARTIAL';
            SET p_message = CONCAT('Payroll calculated with ', p_error_count, ' errors. Processed: ', p_processed_count);
        ELSE
            SET p_status = 'SUCCESS';
            SET p_message = CONCAT('Payroll calculation completed successfully for ', p_processed_count, ' employees');
        END IF;
    END IF;
END //
DELIMITER ;


-- 4. sp_add_component_to_all_employees
-- Ensures when a new component is added, it is attached to all active employees in active state
DROP PROCEDURE IF EXISTS sp_add_component_to_all_employees;
DELIMITER //
CREATE PROCEDURE sp_add_component_to_all_employees(
    IN p_component_id INT
)
BEGIN
    DECLARE done INT DEFAULT FALSE;
    DECLARE v_structure_id BIGINT;
    DECLARE v_monthly_ctc DECIMAL(12,2);
    DECLARE v_calc_type VARCHAR(30);
    DECLARE v_pct_base VARCHAR(30);
    DECLARE v_pct_val DECIMAL(7,4);
    DECLARE v_amt DECIMAL(12,2) DEFAULT 0.00;
    DECLARE v_basic_amt DECIMAL(12,2) DEFAULT 0.00;

    DECLARE cur_struct CURSOR FOR
        SELECT ess.salary_structure_id, ess.monthly_ctc
        FROM employee_salary_structure ess
        JOIN user_details u ON ess.emp_id = u.emp_id
        WHERE LOWER(u.profisional_details_status) = 'active'
          AND ess.payroll_status IN ('APPROVED', 'ACTIVE')
          AND ess.salary_structure_id = (
              SELECT MAX(ess2.salary_structure_id)
              FROM employee_salary_structure ess2
              WHERE ess2.emp_id = ess.emp_id AND ess2.payroll_status IN ('APPROVED', 'ACTIVE')
          );

    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;

    SELECT calculation_type, IFNULL(percentage_base, 'NONE'), percentage_value
    INTO v_calc_type, v_pct_base, v_pct_val
    FROM salary_component_master
    WHERE component_id = p_component_id;

    OPEN cur_struct;
    struct_loop: LOOP
        FETCH cur_struct INTO v_structure_id, v_monthly_ctc;
        IF done THEN
            LEAVE struct_loop;
        END IF;

        SET v_amt = 0.00;
        IF v_calc_type = 'PERCENTAGE' AND v_pct_val IS NOT NULL AND v_pct_val > 0 THEN
            IF v_pct_base = 'BASIC' THEN
                SELECT IFNULL(monthly_amount, 0.00) INTO v_basic_amt
                FROM employee_salary_component esc
                JOIN salary_component_master scm ON esc.component_id = scm.component_id
                WHERE esc.salary_structure_id = v_structure_id AND scm.component_code = 'BASIC'
                LIMIT 1;

                SET v_amt = ROUND((v_basic_amt * v_pct_val) / 100, 2);
            ELSE
                SET v_amt = ROUND((v_monthly_ctc * v_pct_val) / 100, 2);
            END IF;
        END IF;

        -- Insert or activate for this structure
        INSERT INTO employee_salary_component (
            salary_structure_id, component_id, monthly_amount, percentage_value, is_active, created_at
        ) VALUES (
            v_structure_id, p_component_id, v_amt, v_pct_val, 1, NOW()
        ) ON DUPLICATE KEY UPDATE
            is_active = 1,
            percentage_value = v_pct_val;

    END LOOP;
    CLOSE cur_struct;
END //
DELIMITER ;


-- 5. sp_sync_all_active_components
-- Synchronizes all active salary components into all active employee structures
DROP PROCEDURE IF EXISTS sp_sync_all_active_components;
DELIMITER //
CREATE PROCEDURE sp_sync_all_active_components()
BEGIN
    DECLARE done INT DEFAULT FALSE;
    DECLARE v_comp_id INT;

    DECLARE cur_all_comps CURSOR FOR
        SELECT component_id
        FROM salary_component_master
        WHERE is_active = 1
        ORDER BY component_id ASC;

    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;

    OPEN cur_all_comps;
    comp_sync_loop: LOOP
        FETCH cur_all_comps INTO v_comp_id;
        IF done THEN
            LEAVE comp_sync_loop;
        END IF;

        CALL sp_add_component_to_all_employees(v_comp_id);
    END LOOP;
    CLOSE cur_all_comps;
END //
DELIMITER ;
