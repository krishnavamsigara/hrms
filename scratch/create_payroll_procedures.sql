-- Procedure 1: sp_create_payroll_run
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

    -- Validate parameters
    IF p_payroll_month < 1 OR p_payroll_month > 12 THEN
        SET p_run_id = 0;
        SET p_status = 'ERROR';
        SET p_message = 'Invalid payroll month (must be 1-12)';
    ELSEIF p_payroll_year < 2000 THEN
        SET p_run_id = 0;
        SET p_status = 'ERROR';
        SET p_message = 'Invalid payroll year';
    ELSE
        -- Read cutoff cycle days from company_settings
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

        -- Check if payroll run already exists
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

-- Procedure 2: sp_calculate_employee_payroll
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

    DECLARE v_structure_id BIGINT;
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
            esc.monthly_amount,
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
        -- 2. Find approved salary structure
        SELECT salary_structure_id, monthly_ctc
        INTO v_structure_id, v_monthly_ctc
        FROM employee_salary_structure
        WHERE emp_id = p_emp_id
          AND payroll_status = 'APPROVED'
          AND effective_from <= v_period_end
          AND (effective_to IS NULL OR effective_to >= v_period_start)
        ORDER BY structure_version DESC, effective_from DESC
        LIMIT 1;

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

            -- 5. Upsert payroll_employee record
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

            -- 8. Final update on payroll_employee
            UPDATE payroll_employee
            SET gross_earnings = v_gross_earnings,
                lop_deduction = v_lop_deduction,
                other_deductions = v_other_deductions,
                employer_contributions = v_employer_contributions,
                net_salary = v_net_salary,
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

-- Procedure 3: sp_calculate_monthly_payroll
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

    -- Cursor over active employees
    DECLARE cur_emp CURSOR FOR
        SELECT emp_id
        FROM user_details
        WHERE LOWER(profisional_details_status) = 'active'
        ORDER BY emp_id ASC;

    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;

    SET p_processed_count = 0;
    SET p_error_count = 0;

    -- Validate payroll run
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

        -- Update payroll run summary
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

-- Procedure 4: sp_validate_payroll_run
DROP PROCEDURE IF EXISTS sp_validate_payroll_run;
DELIMITER //
CREATE PROCEDURE sp_validate_payroll_run(
    IN p_run_id BIGINT
)
BEGIN
    DECLARE v_month INT;
    DECLARE v_year INT;

    SELECT payroll_month, payroll_year INTO v_month, v_year
    FROM payroll_run WHERE payroll_run_id = p_run_id;

    -- Result Set 1: Overall Run Metrics & Validation Flags
    SELECT 
        pr.payroll_run_id,
        pr.payroll_month,
        pr.payroll_year,
        pr.period_start,
        pr.period_end,
        pr.salary_day_basis,
        pr.payroll_status,
        COUNT(pe.payroll_employee_id) AS total_employees,
        SUM(CASE WHEN pe.calculation_status = 'CALCULATED' THEN 1 ELSE 0 END) AS successful_count,
        SUM(CASE WHEN pe.calculation_status = 'ERROR' THEN 1 ELSE 0 END) AS error_count,
        SUM(pe.monthly_ctc) AS total_monthly_ctc,
        SUM(pe.gross_earnings) AS total_gross_earnings,
        SUM(pe.lop_deduction) AS total_lop_deductions,
        SUM(pe.other_deductions) AS total_employee_deductions,
        SUM(pe.employer_contributions) AS total_employer_contributions,
        SUM(pe.net_salary) AS total_net_salary,
        (
            SELECT COUNT(*) 
            FROM payroll_attendance_summary 
            WHERE payroll_month = v_month AND payroll_year = v_year AND is_finalized != 'Y'
        ) AS unfinalized_attendance_count,
        CASE 
            WHEN SUM(CASE WHEN pe.calculation_status = 'ERROR' THEN 1 ELSE 0 END) = 0 
                 AND COUNT(pe.payroll_employee_id) > 0 
            THEN 1 
            ELSE 0 
        END AS is_ready_for_approval
    FROM payroll_run pr
    LEFT JOIN payroll_employee pe ON pr.payroll_run_id = pe.payroll_run_id
    WHERE pr.payroll_run_id = p_run_id
    GROUP BY pr.payroll_run_id;

    -- Result Set 2: Employee Exception List (Errors or unfinalized attendance)
    SELECT 
        pe.payroll_employee_id,
        pe.emp_id,
        u.emp_name,
        pe.calculation_status,
        pe.calculation_message,
        pe.net_salary,
        pas.is_finalized AS attendance_finalized
    FROM payroll_employee pe
    LEFT JOIN user_details u ON pe.emp_id = u.emp_id
    LEFT JOIN payroll_attendance_summary pas ON pe.attendance_summary_id = pas.summary_id
    WHERE pe.payroll_run_id = p_run_id
      AND (pe.calculation_status = 'ERROR' OR pe.net_salary < 0 OR pas.is_finalized != 'Y')
    ORDER BY pe.emp_id ASC;
END //
DELIMITER ;

-- Procedure 5: sp_approve_payroll_run
DROP PROCEDURE IF EXISTS sp_approve_payroll_run;
DELIMITER //
CREATE PROCEDURE sp_approve_payroll_run(
    IN p_run_id BIGINT,
    IN p_admin_emp_id VARCHAR(20),
    OUT p_status VARCHAR(10),
    OUT p_message VARCHAR(255)
)
BEGIN
    DECLARE v_status VARCHAR(20);
    DECLARE v_error_count INT;

    SELECT payroll_status INTO v_status
    FROM payroll_run
    WHERE payroll_run_id = p_run_id;

    IF v_status IS NULL THEN
        SET p_status = 'ERROR';
        SET p_message = 'Payroll run not found';
    ELSEIF v_status NOT IN ('CALCULATED', 'DRAFT') THEN
        SET p_status = 'ERROR';
        SET p_message = CONCAT('Cannot approve run in status: ', v_status);
    ELSE
        -- Check if any error records exist
        SELECT COUNT(*) INTO v_error_count
        FROM payroll_employee
        WHERE payroll_run_id = p_run_id AND calculation_status = 'ERROR';

        IF v_error_count > 0 THEN
            SET p_status = 'ERROR';
            SET p_message = CONCAT('Cannot approve: ', v_error_count, ' employees have calculation errors');
        ELSE
            UPDATE payroll_run
            SET payroll_status = 'APPROVED',
                approved_by = p_admin_emp_id,
                approved_at = NOW()
            WHERE payroll_run_id = p_run_id;

            SET p_status = 'SUCCESS';
            SET p_message = 'Payroll run approved successfully';
        END IF;
    END IF;
END //
DELIMITER ;

-- Procedure 6: sp_finalize_payroll_run
DROP PROCEDURE IF EXISTS sp_finalize_payroll_run;
DELIMITER //
CREATE PROCEDURE sp_finalize_payroll_run(
    IN p_run_id BIGINT,
    IN p_admin_emp_id VARCHAR(20),
    OUT p_status VARCHAR(10),
    OUT p_message VARCHAR(255)
)
BEGIN
    DECLARE v_status VARCHAR(20);
    DECLARE v_error_count INT;
    DECLARE v_gen_count INT DEFAULT 0;
    DECLARE v_gen_status VARCHAR(10);
    DECLARE v_gen_msg VARCHAR(255);

    -- Lock payroll run row for update
    SELECT payroll_status INTO v_status
    FROM payroll_run
    WHERE payroll_run_id = p_run_id
    FOR UPDATE;

    IF v_status IS NULL THEN
        SET p_status = 'ERROR';
        SET p_message = 'Payroll run not found';
    ELSEIF v_status = 'FINALIZED' THEN
        SET p_status = 'ERROR';
        SET p_message = 'Payroll run is already finalized';
    ELSEIF v_status NOT IN ('APPROVED', 'CALCULATED') THEN
        SET p_status = 'ERROR';
        SET p_message = CONCAT('Run must be CALCULATED or APPROVED before finalization. Current: ', v_status);
    ELSE
        SELECT COUNT(*) INTO v_error_count
        FROM payroll_employee
        WHERE payroll_run_id = p_run_id AND calculation_status = 'ERROR';

        IF v_error_count > 0 THEN
            SET p_status = 'ERROR';
            SET p_message = CONCAT('Cannot finalize: ', v_error_count, ' employees have calculation errors');
        ELSE
            UPDATE payroll_run
            SET payroll_status = 'FINALIZED',
                finalized_by = p_admin_emp_id,
                finalized_at = NOW()
            WHERE payroll_run_id = p_run_id;

            -- Auto-generate payslips for finalized run
            CALL sp_generate_payslips(p_run_id, p_admin_emp_id, v_gen_count, v_gen_status, v_gen_msg);

            SET p_status = 'SUCCESS';
            SET p_message = CONCAT('Payroll finalized and ', v_gen_count, ' payslips generated successfully');
        END IF;
    END IF;
END //
DELIMITER ;

-- Procedure 7: sp_generate_payslips
DROP PROCEDURE IF EXISTS sp_generate_payslips;
DELIMITER //
CREATE PROCEDURE sp_generate_payslips(
    IN p_run_id BIGINT,
    IN p_admin_emp_id VARCHAR(20),
    OUT p_generated_count INT,
    OUT p_status VARCHAR(10),
    OUT p_message VARCHAR(255)
)
BEGIN
    DECLARE v_status VARCHAR(20);
    DECLARE v_month INT;
    DECLARE v_year INT;
    DECLARE v_prefix VARCHAR(20) DEFAULT 'PS-';

    DECLARE done INT DEFAULT FALSE;
    DECLARE v_pe_id BIGINT;
    DECLARE v_emp_id VARCHAR(20);
    DECLARE v_payslip_num VARCHAR(50);

    DECLARE cur_pe CURSOR FOR
        SELECT payroll_employee_id, emp_id
        FROM payroll_employee
        WHERE payroll_run_id = p_run_id
          AND calculation_status = 'CALCULATED';

    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;

    SET p_generated_count = 0;

    SELECT payroll_status, payroll_month, payroll_year
    INTO v_status, v_month, v_year
    FROM payroll_run
    WHERE payroll_run_id = p_run_id;

    IF v_status IS NULL THEN
        SET p_status = 'ERROR';
        SET p_message = 'Payroll run not found';
    ELSEIF v_status != 'FINALIZED' THEN
        SET p_status = 'ERROR';
        SET p_message = 'Payslips can only be generated for FINALIZED payroll runs';
    ELSE
        -- Get prefix from company_settings
        SELECT IFNULL(payslip_prefix, 'PS-') INTO v_prefix
        FROM company_settings LIMIT 1;

        OPEN cur_pe;
        pe_loop: LOOP
            FETCH cur_pe INTO v_pe_id, v_emp_id;
            IF done THEN
                LEAVE pe_loop;
            END IF;

            SET v_payslip_num = CONCAT(v_prefix, v_year, LPAD(v_month, 2, '0'), '-', v_emp_id);

            INSERT INTO payslip (
                payroll_employee_id, payslip_number, payslip_status, generated_at
            ) VALUES (
                v_pe_id, v_payslip_num, 'GENERATED', NOW()
            ) ON DUPLICATE KEY UPDATE
                payslip_status = 'GENERATED';

            SET p_generated_count = p_generated_count + 1;
        END LOOP;
        CLOSE cur_pe;

        SET p_status = 'SUCCESS';
        SET p_message = CONCAT('Generated ', p_generated_count, ' payslips successfully');
    END IF;
END //
DELIMITER ;

-- Procedure 8: sp_get_employee_payslip
DROP PROCEDURE IF EXISTS sp_get_employee_payslip;
DELIMITER //
CREATE PROCEDURE sp_get_employee_payslip(
    IN p_run_id BIGINT,
    IN p_emp_id VARCHAR(20)
)
BEGIN
    DECLARE v_pe_id BIGINT;

    SELECT payroll_employee_id INTO v_pe_id
    FROM payroll_employee
    WHERE payroll_run_id = p_run_id AND emp_id = p_emp_id
    LIMIT 1;

    -- Result Set 1: Header, Company, Employee & Summary Info
    SELECT 
        pr.payroll_run_id,
        pr.payroll_month,
        pr.payroll_year,
        pr.period_start,
        pr.period_end,
        pr.salary_day_basis,
        pr.payroll_status,
        pe.payroll_employee_id,
        pe.emp_id,
        u.emp_name,
        u.email,
        u.mobile,
        u.joining_date,
        u.pan,
        u.aadhaar,
        u.uan,
        u.bank_holder_name,
        u.bank_name,
        u.bank_branch,
        u.bank_account_no,
        u.ifsc,
        d.department_name AS department,
        des.designation_name AS designation,
        pe.total_days,
        pe.working_days,
        pe.paid_days,
        pe.lop_days,
        pe.monthly_ctc,
        pe.gross_earnings,
        pe.lop_deduction,
        pe.other_deductions,
        pe.employer_contributions,
        pe.net_salary,
        p.payslip_id,
        p.payslip_number,
        p.payslip_status,
        p.generated_at,
        cs.company_name,
        cs.brand_title_primary,
        cs.brand_title_secondary,
        cs.company_address,
        cs.city,
        cs.state,
        cs.pincode,
        cs.pan_number,
        cs.tan_number,
        cs.gstin,
        cs.pf_establishment_code,
        cs.esic_code,
        cs.cin,
        cs.logo_url,
        cs.payslip_signatory_title,
        cs.payslip_footer_disclaimer
    FROM payroll_employee pe
    JOIN payroll_run pr ON pe.payroll_run_id = pr.payroll_run_id
    LEFT JOIN payslip p ON pe.payroll_employee_id = p.payroll_employee_id
    LEFT JOIN user_details u ON pe.emp_id = u.emp_id
    LEFT JOIN department_master d ON u.department = d.department_id
    LEFT JOIN designation_master des ON u.designation = des.designation_id
    LEFT JOIN company_settings cs ON 1=1
    WHERE pe.payroll_employee_id = v_pe_id
    LIMIT 1;

    -- Result Set 2: Earnings
    SELECT 
        payroll_employee_component_id,
        component_code,
        component_name,
        monthly_amount,
        calculated_amount,
        lop_amount,
        payable_amount
    FROM payroll_employee_component
    WHERE payroll_employee_id = v_pe_id
      AND component_type = 'EARNING'
    ORDER BY component_id ASC;

    -- Result Set 3: Deductions
    SELECT 
        payroll_employee_component_id,
        component_code,
        component_name,
        monthly_amount,
        calculated_amount,
        payable_amount
    FROM payroll_employee_component
    WHERE payroll_employee_id = v_pe_id
      AND component_type = 'DEDUCTION'
    ORDER BY component_id ASC;

    -- Result Set 4: Employer Contributions
    SELECT 
        payroll_employee_component_id,
        component_code,
        component_name,
        monthly_amount,
        calculated_amount,
        payable_amount
    FROM payroll_employee_component
    WHERE payroll_employee_id = v_pe_id
      AND component_type = 'EMPLOYER_CONTRIBUTION'
    ORDER BY component_id ASC;
END //
DELIMITER ;

-- Procedure 9: sp_reopen_payroll_run
DROP PROCEDURE IF EXISTS sp_reopen_payroll_run;
DELIMITER //
CREATE PROCEDURE sp_reopen_payroll_run(
    IN p_run_id BIGINT,
    IN p_admin_emp_id VARCHAR(20),
    IN p_reason VARCHAR(255),
    OUT p_status VARCHAR(10),
    OUT p_message VARCHAR(255)
)
BEGIN
    DECLARE v_status VARCHAR(20);

    SELECT payroll_status INTO v_status
    FROM payroll_run
    WHERE payroll_run_id = p_run_id;

    IF v_status IS NULL THEN
        SET p_status = 'ERROR';
        SET p_message = 'Payroll run not found';
    ELSE
        -- Update payslips to VOID if any existed
        UPDATE payslip p
        JOIN payroll_employee pe ON p.payroll_employee_id = pe.payroll_employee_id
        SET p.payslip_status = 'VOID'
        WHERE pe.payroll_run_id = p_run_id;

        -- Reopen run to CALCULATED
        UPDATE payroll_run
        SET payroll_status = 'CALCULATED',
            finalized_at = NULL,
            finalized_by = NULL
        WHERE payroll_run_id = p_run_id;

        SET p_status = 'SUCCESS';
        SET p_message = 'Payroll run reopened for corrections. Existing payslips voided.';
    END IF;
END //
DELIMITER ;
