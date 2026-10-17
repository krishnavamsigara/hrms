-- ====================================================================
-- HRMS Stored Procedures for Payroll, Attendance & Salary Structures
-- Generated for CodeIgniter Controller & Model Stored Procedure Architecture
-- ====================================================================

DELIMITER $$

-- 1. sp_get_payroll_attendance_summary_stats
DROP PROCEDURE IF EXISTS `sp_get_payroll_attendance_summary_stats`$$
CREATE PROCEDURE `sp_get_payroll_attendance_summary_stats`(
    IN p_month INT,
    IN p_year INT
)
BEGIN
    SELECT 
        is_finalized, 
        COUNT(*) as emp_count, 
        SUM(present_days) as total_present, 
        SUM(paid_days) as total_paid, 
        SUM(unpaid_days) as total_unpaid
    FROM payroll_attendance_summary
    WHERE payroll_month = p_month
      AND payroll_year = p_year
    GROUP BY is_finalized;
END$$

-- 2. sp_get_attendance_punch_stats
DROP PROCEDURE IF EXISTS `sp_get_attendance_punch_stats`$$
CREATE PROCEDURE `sp_get_attendance_punch_stats`(
    IN p_start_date DATE,
    IN p_end_date DATE
)
BEGIN
    SELECT 
        COUNT(*) as total_punches,
        COUNT(DISTINCT emp_id) as active_punched_emps,
        COUNT(CASE WHEN UPPER(TRIM(status)) = 'PRESENT' THEN 1 END) as present_count,
        COUNT(CASE WHEN UPPER(TRIM(status)) = 'WFH' THEN 1 END) as wfh_count,
        COUNT(CASE WHEN UPPER(TRIM(status)) IN ('LEAVE', 'PL', 'SL', 'CL', 'ML') THEN 1 END) as leave_count,
        COUNT(CASE WHEN UPPER(TRIM(status)) IN ('ABSENT', 'A', 'LOP') THEN 1 END) as absent_count
    FROM attendance
    WHERE attendance_date BETWEEN p_start_date AND p_end_date;
END$$

-- 3. sp_get_annual_attendance_matrix
DROP PROCEDURE IF EXISTS `sp_get_annual_attendance_matrix`$$
CREATE PROCEDURE `sp_get_annual_attendance_matrix`(
    IN p_year INT,
    IN p_cycle_start_day INT,
    IN p_start_filter DATE,
    IN p_end_filter DATE
)
BEGIN
    SELECT 
        t.calc_month AS p_month,
        t.calc_year AS p_year,
        COUNT(*) AS raw_count,
        COUNT(DISTINCT t.emp_id) AS emp_count
    FROM (
        SELECT 
            emp_id,
            CASE 
                WHEN DAY(attendance_date) >= p_cycle_start_day THEN 
                    CASE WHEN MONTH(attendance_date) = 12 THEN 1 ELSE MONTH(attendance_date) + 1 END
                ELSE MONTH(attendance_date)
            END AS calc_month,
            CASE 
                WHEN DAY(attendance_date) >= p_cycle_start_day AND MONTH(attendance_date) = 12 THEN YEAR(attendance_date) + 1
                ELSE YEAR(attendance_date)
            END AS calc_year
        FROM attendance
        WHERE attendance_date >= p_start_filter AND attendance_date <= p_end_filter
    ) t
    GROUP BY t.calc_year, t.calc_month;
END$$

-- 4. sp_get_annual_payroll_summary
DROP PROCEDURE IF EXISTS `sp_get_annual_payroll_summary`$$
CREATE PROCEDURE `sp_get_annual_payroll_summary`(
    IN p_year INT
)
BEGIN
    SELECT 
        payroll_month, 
        is_finalized, 
        COUNT(*) as emp_count
    FROM payroll_attendance_summary
    WHERE payroll_year = p_year
    GROUP BY payroll_month, is_finalized;
END$$

-- 5. sp_get_raw_attendance_punch_counts
DROP PROCEDURE IF EXISTS `sp_get_raw_attendance_punch_counts`$$
CREATE PROCEDURE `sp_get_raw_attendance_punch_counts`(
    IN p_start_date DATE,
    IN p_end_date DATE
)
BEGIN
    SELECT 
        COUNT(*) as raw_punches, 
        COUNT(DISTINCT emp_id) as raw_emps
    FROM attendance
    WHERE attendance_date BETWEEN p_start_date AND p_end_date;
END$$

-- 6. sp_get_all_payroll_attendance_summaries
DROP PROCEDURE IF EXISTS `sp_get_all_payroll_attendance_summaries`$$
CREATE PROCEDURE `sp_get_all_payroll_attendance_summaries`()
BEGIN
    SELECT 
        payroll_month, 
        payroll_year, 
        is_finalized, 
        COUNT(*) as cnt
    FROM payroll_attendance_summary
    GROUP BY payroll_month, payroll_year, is_finalized;
END$$

-- 7. sp_get_emp_attendance_summary
DROP PROCEDURE IF EXISTS `sp_get_emp_attendance_summary`$$
CREATE PROCEDURE `sp_get_emp_attendance_summary`(
    IN p_emp_id VARCHAR(50),
    IN p_month INT,
    IN p_year INT
)
BEGIN
    SELECT *
    FROM payroll_attendance_summary
    WHERE emp_id = p_emp_id
      AND payroll_month = p_month
      AND payroll_year = p_year
    LIMIT 1;
END$$

-- 8. sp_get_all_payroll_cycles
DROP PROCEDURE IF EXISTS `sp_get_all_payroll_cycles`$$
CREATE PROCEDURE `sp_get_all_payroll_cycles`()
BEGIN
    SELECT *
    FROM payroll_cycles
    ORDER BY id DESC;
END$$

-- 9. sp_get_payroll_cycle_by_id
DROP PROCEDURE IF EXISTS `sp_get_payroll_cycle_by_id`$$
CREATE PROCEDURE `sp_get_payroll_cycle_by_id`(
    IN p_cycle_id INT
)
BEGIN
    SELECT *
    FROM payroll_cycles
    WHERE id = p_cycle_id
    LIMIT 1;
END$$

-- 10. sp_get_payroll_cycle_by_period
DROP PROCEDURE IF EXISTS `sp_get_payroll_cycle_by_period`$$
CREATE PROCEDURE `sp_get_payroll_cycle_by_period`(
    IN p_period_start DATE,
    IN p_period_end DATE
)
BEGIN
    SELECT *
    FROM payroll_cycles
    WHERE period_start = p_period_start
      AND period_end = p_period_end
    LIMIT 1;
END$$

-- 11. sp_get_payroll_cycle_by_code
DROP PROCEDURE IF EXISTS `sp_get_payroll_cycle_by_code`$$
CREATE PROCEDURE `sp_get_payroll_cycle_by_code`(
    IN p_payroll_code VARCHAR(50)
)
BEGIN
    SELECT *
    FROM payroll_cycles
    WHERE payroll_code = p_payroll_code
    LIMIT 1;
END$$

-- 12. sp_delete_payroll_cycle
DROP PROCEDURE IF EXISTS `sp_delete_payroll_cycle`$$
CREATE PROCEDURE `sp_delete_payroll_cycle`(
    IN p_cycle_id INT
)
BEGIN
    DELETE FROM payroll_calculation_histories WHERE payroll_cycle_id = p_cycle_id;
    DELETE FROM payroll_employees WHERE payroll_cycle_id = p_cycle_id;
    DELETE FROM payroll_attendances WHERE payroll_cycle_id = p_cycle_id;
    DELETE FROM payroll_adjustments WHERE payroll_cycle_id = p_cycle_id;
    DELETE FROM payroll_cycles WHERE id = p_cycle_id;
END$$

-- 13. sp_get_payroll_cycle_employees
DROP PROCEDURE IF EXISTS `sp_get_payroll_cycle_employees`$$
CREATE PROCEDURE `sp_get_payroll_cycle_employees`(
    IN p_cycle_id INT
)
BEGIN
    SELECT 
        pe.*, 
        IFNULL(dm.department_name, 'General') as department, 
        IFNULL(dsm.designation_name, 'Employee') as designation,
        IFNULL(ud.email, '') as email,
        IFNULL(ud.mobile, '') as mobile,
        IFNULL(ud.bank_account_no, '') as bank_account_no,
        IFNULL(ud.bank_name, '') as bank_name,
        IFNULL(ud.ifsc, '') as ifsc,
        IFNULL(es.`basic @ 50%`, ROUND(pe.salary_basis * 0.50, 2)) as basic_calc,
        IFNULL(es.`hra @ 20%`, ROUND(pe.salary_basis * 0.20, 2)) as hra_calc,
        IFNULL(es.`medical @ 5%`, ROUND(pe.salary_basis * 0.05, 2)) as medical_calc,
        IFNULL(es.`conveyance @ 8%`, ROUND(pe.salary_basis * 0.08, 2)) as conveyance_calc,
        IFNULL(es.`others @ 17%`, 0) as others_calc,
        IFNULL(es.NPS, 0) as employer_nps,
        IFNULL(es.pf_employer_contribution, LEAST(ROUND(ROUND(pe.salary_basis * 0.50, 2) * 0.12, 2), 1800.00)) as pf_employer,
        IFNULL(es.admin_charges, 75.00) as admin_charges,
        IFNULL(es.esi_employer_contribution, CASE WHEN pe.gross_salary <= 21000 THEN ROUND(pe.gross_salary * 0.0325, 2) ELSE 0 END) as esi_employer,
        IFNULL(es.pt, 200.00) as pt_calc,
        IFNULL(es.pf_employee_contribution, LEAST(ROUND(ROUND(pe.salary_basis * 0.50, 2) * 0.12, 2), 1800.00)) as pf_employee,
        IFNULL(es.esi_employee_contribution, CASE WHEN pe.gross_salary <= 21000 THEN ROUND(pe.gross_salary * 0.0075, 2) ELSE 0 END) as esi_employee,
        IFNULL(es.`advances/ other_deductions`, 0) as advances_deduction,
        IFNULL(es.tds, 0) as tds_calc,
        IFNULL(eadv.adv_amt, 0) as advance_amount,
        IFNULL(eadv.bal_amt, 0) as bal_advance
    FROM payroll_employees pe
    LEFT JOIN user_details ud ON ud.emp_id = pe.emp_id
    LEFT JOIN department_master dm ON dm.department_id = ud.department
    LEFT JOIN designation_master dsm ON dsm.designation_id = ud.designation
    LEFT JOIN (
        SELECT s1.* 
        FROM employee_salary s1
        INNER JOIN (
            SELECT EMP_ID, MAX(id) as max_id 
            FROM employee_salary 
            GROUP BY EMP_ID
        ) s2 ON s1.id = s2.max_id
    ) es ON es.EMP_ID = pe.emp_id
    LEFT JOIN (
        SELECT emp_id, SUM(advance_amount) as adv_amt, SUM(balance_amount) as bal_amt
        FROM employee_advances
        WHERE UPPER(status) IN ('ACTIVE', 'APPROVED')
        GROUP BY emp_id
    ) eadv ON eadv.emp_id = pe.emp_id
    WHERE pe.payroll_cycle_id = p_cycle_id
    ORDER BY pe.emp_id ASC;
END$$

-- 14. sp_get_employee_payroll_details
DROP PROCEDURE IF EXISTS `sp_get_employee_payroll_details`$$
CREATE PROCEDURE `sp_get_employee_payroll_details`(
    IN p_cycle_id INT,
    IN p_emp_id VARCHAR(50)
)
BEGIN
    SELECT *
    FROM payroll_employees
    WHERE payroll_cycle_id = p_cycle_id
      AND emp_id = p_emp_id
    LIMIT 1;
END$$

-- 15. sp_get_payroll_calculation_history
DROP PROCEDURE IF EXISTS `sp_get_payroll_calculation_history`$$
CREATE PROCEDURE `sp_get_payroll_calculation_history`(
    IN p_cycle_id INT,
    IN p_emp_id VARCHAR(50)
)
BEGIN
    SELECT *
    FROM payroll_calculation_histories
    WHERE payroll_cycle_id = p_cycle_id
      AND emp_id = p_emp_id
    ORDER BY id DESC;
END$$

-- 16. sp_get_payroll_cycle_emp_attendances
DROP PROCEDURE IF EXISTS `sp_get_payroll_cycle_emp_attendances`$$
CREATE PROCEDURE `sp_get_payroll_cycle_emp_attendances`(
    IN p_cycle_id INT,
    IN p_emp_id VARCHAR(50)
)
BEGIN
    SELECT *
    FROM payroll_attendances
    WHERE payroll_cycle_id = p_cycle_id
      AND emp_id = p_emp_id
    ORDER BY attendance_date ASC;
END$$

-- 17. sp_get_cycle_attendance_matrix
DROP PROCEDURE IF EXISTS `sp_get_cycle_attendance_matrix`$$
CREATE PROCEDURE `sp_get_cycle_attendance_matrix`(
    IN p_cycle_id INT
)
BEGIN
    SELECT 
        pa.*, 
        IFNULL(ud.emp_name, CONCAT('Employee ', pa.emp_id)) as emp_name
    FROM payroll_attendances pa
    LEFT JOIN user_details ud ON ud.emp_id = pa.emp_id
    WHERE pa.payroll_cycle_id = p_cycle_id
    ORDER BY pa.emp_id ASC, pa.attendance_date ASC;
END$$

-- 18. sp_get_salary_components
DROP PROCEDURE IF EXISTS `sp_get_salary_components`$$
CREATE PROCEDURE `sp_get_salary_components`()
BEGIN
    SELECT *
    FROM salary_components
    ORDER BY display_order ASC;
END$$

-- 19. sp_get_latest_salary
DROP PROCEDURE IF EXISTS `sp_get_latest_salary`$$
CREATE PROCEDURE `sp_get_latest_salary`(
    IN p_emp_id VARCHAR(50)
)
BEGIN
    SELECT 
        s.*, 
        pc.payroll_code, 
        pc.period_start, 
        pc.period_end
    FROM salaries s
    LEFT JOIN payroll_cycles pc ON pc.id = s.payroll_cycle_id
    WHERE s.emp_id = p_emp_id
    ORDER BY s.id DESC
    LIMIT 1;
END$$

-- 20. sp_get_all_emp_salary_structures
DROP PROCEDURE IF EXISTS `sp_get_all_emp_salary_structures`$$
CREATE PROCEDURE `sp_get_all_emp_salary_structures`()
BEGIN
    SELECT 
        ud.emp_id, 
        ud.emp_name, 
        IFNULL(dm.department_name, '') as department, 
        ud.bank_name, 
        ud.bank_account_no, 
        ud.ifsc, 
        ud.mobile,
        es.salary,
        es.leaves,
        es.Leave_salary_deduction,
        es.other_earnings,
        es.ctc1,
        es.gross,
        es.`basic @ 50%` as basic_50,
        es.`hra @ 20%` as hra_20,
        es.`medical @ 5%` as medical_5,
        es.`conveyance @ 8%` as conveyance_8,
        es.`others @ 17%` as others_17,
        es.NPS,
        es.pf_employer_contribution,
        es.admin_charges,
        es.esi_employer_contribution,
        es.pt,
        es.pf_employee_contribution,
        es.esi_employee_contribution,
        es.`advances/ other_deductions` as advances_deductions,
        es.tds,
        es.total_deductions,
        es.net_pay,
        str.latest_effective_from,
        str.struct_amount_sum
    FROM user_details ud
    LEFT JOIN department_master dm ON dm.department_id = ud.department
    LEFT JOIN (
        SELECT s1.* 
        FROM employee_salary s1
        INNER JOIN (
            SELECT EMP_ID, MAX(id) as max_id 
            FROM employee_salary 
            GROUP BY EMP_ID
        ) s2 ON s1.id = s2.max_id
    ) es ON es.EMP_ID = ud.emp_id
    LEFT JOIN (
        SELECT 
            emp_id, 
            MAX(effective_from) as latest_effective_from,
            SUM(amount) as struct_amount_sum
        FROM emp_salary_structures
        GROUP BY emp_id
    ) str ON str.emp_id = ud.emp_id
    ORDER BY ud.emp_id ASC;
END$$

-- 21. sp_get_emp_structure_overview
DROP PROCEDURE IF EXISTS `sp_get_emp_structure_overview`$$
CREATE PROCEDURE `sp_get_emp_structure_overview`(
    IN p_emp_id VARCHAR(50)
)
BEGIN
    SELECT 
        ud.emp_id,
        ud.emp_name,
        es.ctc1,
        es.salary,
        str.struct_amount_sum
    FROM user_details ud
    LEFT JOIN (
        SELECT s1.* 
        FROM employee_salary s1
        INNER JOIN (
            SELECT EMP_ID, MAX(id) as max_id 
            FROM employee_salary 
            WHERE EMP_ID = p_emp_id
            GROUP BY EMP_ID
        ) s2 ON s1.id = s2.max_id
    ) es ON es.EMP_ID = ud.emp_id
    LEFT JOIN (
        SELECT 
            emp_id, 
            SUM(amount) as struct_amount_sum
        FROM emp_salary_structures
        WHERE emp_id = p_emp_id
        GROUP BY emp_id
    ) str ON str.emp_id = ud.emp_id
    WHERE ud.emp_id = p_emp_id
    LIMIT 1;
END$$

-- 22. sp_save_employee_salary
DROP PROCEDURE IF EXISTS `sp_save_employee_salary`$$
CREATE PROCEDURE `sp_save_employee_salary`(
    IN p_emp_id VARCHAR(40),
    IN p_ctc DECIMAL(12,2),
    IN p_gross DECIMAL(12,2),
    IN p_basic DECIMAL(12,2),
    IN p_hra DECIMAL(12,2),
    IN p_medical DECIMAL(12,2),
    IN p_conveyance DECIMAL(12,2),
    IN p_others DECIMAL(12,2),
    IN p_other_earnings DECIMAL(12,2),
    IN p_nps DECIMAL(12,2),
    IN p_pf_employer DECIMAL(12,2),
    IN p_admin_charges DECIMAL(12,2),
    IN p_esi_employer DECIMAL(12,2),
    IN p_pt DECIMAL(12,2),
    IN p_pf_employee DECIMAL(12,2),
    IN p_esi_employee DECIMAL(12,2),
    IN p_advance DECIMAL(12,2),
    IN p_tds DECIMAL(12,2),
    IN p_total_deductions DECIMAL(12,2),
    IN p_net_pay DECIMAL(12,2)
)
BEGIN
    DECLARE v_exists INT DEFAULT 0;
    
    SELECT COUNT(*) INTO v_exists 
    FROM employee_salary 
    WHERE EMP_ID = p_emp_id;
    
    IF v_exists > 0 THEN
        UPDATE employee_salary SET 
            ctc1 = p_ctc,
            salary = p_ctc,
            gross = p_gross,
            `basic @ 50%` = p_basic,
            `hra @ 20%` = p_hra,
            `medical @ 5%` = p_medical,
            `conveyance @ 8%` = p_conveyance,
            `others @ 17%` = p_others,
            other_earnings = p_other_earnings,
            NPS = p_nps,
            pf_employer_contribution = p_pf_employer,
            admin_charges = p_admin_charges,
            esi_employer_contribution = p_esi_employer,
            pt = p_pt,
            pf_employee_contribution = p_pf_employee,
            esi_employee_contribution = p_esi_employee,
            `advances/ other_deductions` = p_advance,
            tds = p_tds,
            total_deductions = p_total_deductions,
            net_pay = p_net_pay
        WHERE EMP_ID = p_emp_id;
    ELSE
        INSERT INTO employee_salary (
            EMP_ID, ctc1, salary, gross,
            `basic @ 50%`, `hra @ 20%`, `medical @ 5%`, `conveyance @ 8%`, `others @ 17%`,
            other_earnings, NPS, pf_employer_contribution, admin_charges, esi_employer_contribution,
            pt, pf_employee_contribution, esi_employee_contribution, `advances/ other_deductions`,
            tds, total_deductions, net_pay
        ) VALUES (
            p_emp_id, p_ctc, p_ctc, p_gross,
            p_basic, p_hra, p_medical, p_conveyance, p_others,
            p_other_earnings, p_nps, p_pf_employer, p_admin_charges, p_esi_employer,
            p_pt, p_pf_employee, p_esi_employee, p_advance,
            p_tds, p_total_deductions, p_net_pay
        );
    END IF;
END$$

-- 23. sp_get_payroll_export_data
DROP PROCEDURE IF EXISTS `sp_get_payroll_export_data`$$
CREATE PROCEDURE `sp_get_payroll_export_data`(
    IN p_cycle_id INT,
    IN p_month VARCHAR(45),
    IN p_year VARCHAR(45)
)
BEGIN
    DECLARE v_count INT DEFAULT 0;
    
    SELECT COUNT(*) INTO v_count 
    FROM employee_salary es
    WHERE LOWER(es.month) = LOWER(p_month)
      AND es.year = p_year;
      
    IF v_count > 0 THEN
        SELECT 
            es.*, 
            IFNULL(ud.bank_account_no, '') as bank_account_no, 
            IFNULL(ud.bank_name, '') as bank_name, 
            IFNULL(ud.ifsc, '') as ifsc
        FROM employee_salary es
        LEFT JOIN user_details ud ON ud.emp_id = es.EMP_ID
        WHERE LOWER(es.month) = LOWER(p_month)
          AND es.year = p_year
        ORDER BY es.EMP_ID ASC;
    ELSE
        SELECT 
            pe.emp_id as EMP_ID,
            pe.employee_name as name,
            pe.salary_basis as salary,
            pe.lop_days as leaves,
            30 as Working_days,
            pe.leave_deduction as Leave_salary_deduction,
            pe.other_earnings,
            pe.ctc1,
            pe.gross_salary as gross,
            pe.total_deductions,
            pe.net_salary as net_pay,
            IFNULL(ud.bank_account_no, '') as bank_account_no, 
            IFNULL(ud.bank_name, '') as bank_name, 
            IFNULL(ud.ifsc, '') as ifsc,
            IFNULL(es.ctc1, 0) as legacy_ctc
        FROM payroll_employees pe
        LEFT JOIN user_details ud ON ud.emp_id = pe.emp_id
        LEFT JOIN (
            SELECT s1.* 
            FROM employee_salary s1
            INNER JOIN (
                SELECT EMP_ID, MAX(id) as max_id 
                FROM employee_salary 
                GROUP BY EMP_ID
            ) s2 ON s1.id = s2.max_id
        ) es ON es.EMP_ID = pe.emp_id
        WHERE pe.payroll_cycle_id = p_cycle_id
        ORDER BY pe.emp_id ASC;
    END IF;
END$$

-- 24. sp_get_frozen_payslip
DROP PROCEDURE IF EXISTS `sp_get_frozen_payslip`$$
CREATE PROCEDURE `sp_get_frozen_payslip`(
    IN p_emp_id VARCHAR(50),
    IN p_month VARCHAR(20),
    IN p_year INT
)
BEGIN
    SELECT 
        s.*, 
        p.payslip_number, 
        p.month as ps_month, 
        p.year as ps_year, 
        pc.payroll_code, 
        pc.period_start, 
        pc.period_end, 
        ud.emp_name, 
        ud.bank_name, 
        ud.bank_account_no, 
        ud.ifsc, 
        ud.pan, 
        ud.location, 
        ud.joining_date, 
        ud.pf_account_no, 
        ud.esic_no, 
        ud.uan, 
        IFNULL(dm.department_name, '') as department_name, 
        IFNULL(dsm.designation_name, '') as designation_name
    FROM salaries s
    INNER JOIN payslips p ON p.salary_id = s.id
    LEFT JOIN payroll_cycles pc ON pc.id = s.payroll_cycle_id
    LEFT JOIN user_details ud ON ud.emp_id = s.emp_id
    LEFT JOIN department_master dm ON dm.department_id = ud.department
    LEFT JOIN designation_master dsm ON dsm.designation_id = ud.designation
    WHERE s.emp_id = p_emp_id
      AND LOWER(TRIM(p.month)) = LOWER(TRIM(p_month))
      AND p.year = p_year
    LIMIT 1;
END$$

-- 25. sp_get_frozen_payslip_details
DROP PROCEDURE IF EXISTS `sp_get_frozen_payslip_details`$$
CREATE PROCEDURE `sp_get_frozen_payslip_details`(
    IN p_salary_id INT
)
BEGIN
    SELECT *
    FROM salary_details
    WHERE salary_id = p_salary_id
    ORDER BY id ASC;
END$$

-- 26. sp_get_payroll_adjustments
DROP PROCEDURE IF EXISTS `sp_get_payroll_adjustments`$$
CREATE PROCEDURE `sp_get_payroll_adjustments`(
    IN p_cycle_id INT,
    IN p_emp_id VARCHAR(50)
)
BEGIN
    IF p_emp_id IS NOT NULL AND p_emp_id != '' THEN
        SELECT pa.*, sc.component_name, sc.component_code
        FROM payroll_adjustments pa
        LEFT JOIN salary_components sc ON sc.id = pa.component_id
        WHERE pa.payroll_cycle_id = p_cycle_id
          AND pa.emp_id = p_emp_id
        ORDER BY pa.id ASC;
    ELSE
        SELECT pa.*, sc.component_name, sc.component_code
        FROM payroll_adjustments pa
        LEFT JOIN salary_components sc ON sc.id = pa.component_id
        WHERE pa.payroll_cycle_id = p_cycle_id
        ORDER BY pa.id ASC;
    END IF;
END$$

-- 27. sp_save_payroll_adjustment
DROP PROCEDURE IF EXISTS `sp_save_payroll_adjustment`$$
CREATE PROCEDURE `sp_save_payroll_adjustment`(
    IN p_cycle_id INT,
    IN p_emp_id VARCHAR(50),
    IN p_component_id INT,
    IN p_adj_type VARCHAR(20),
    IN p_amount DECIMAL(12,2),
    IN p_reason VARCHAR(255),
    IN p_created_by VARCHAR(50)
)
BEGIN
    INSERT INTO payroll_adjustments (
        payroll_cycle_id, emp_id, component_id, adjustment_type,
        amount, reason, created_by, status, created_at, updated_at
    ) VALUES (
        p_cycle_id, p_emp_id, p_component_id, p_adj_type,
        p_amount, p_reason, p_created_by, 'PENDING', NOW(), NOW()
    );
END$$

-- 28. sp_delete_emp_salary_structure
DROP PROCEDURE IF EXISTS `sp_delete_emp_salary_structure`$$
CREATE PROCEDURE `sp_delete_emp_salary_structure`(
    IN p_emp_id VARCHAR(50)
)
BEGIN
    DELETE FROM emp_salary_structures WHERE emp_id = p_emp_id;
END$$

-- 29. sp_get_active_employees_for_payroll
DROP PROCEDURE IF EXISTS `sp_get_active_employees_for_payroll`$$
CREATE PROCEDURE `sp_get_active_employees_for_payroll`()
BEGIN
    SELECT 
        uld.emp_id, 
        IFNULL(ud.emp_name, CONCAT('Employee ', uld.emp_id)) as emp_name, 
        IFNULL(dm.department_name, '') as department, 
        IFNULL(dsm.designation_name, '') as designation
    FROM user_login_details uld
    LEFT JOIN user_details ud ON ud.emp_id = uld.emp_id
    LEFT JOIN department_master dm ON dm.department_id = ud.department
    LEFT JOIN designation_master dsm ON dsm.designation_id = ud.designation
    WHERE UPPER(uld.status) = 'ACTIVE'
    ORDER BY uld.emp_id ASC;
END$$

-- 30. sp_check_attendance_finalized
DROP PROCEDURE IF EXISTS `sp_check_attendance_finalized`$$
CREATE PROCEDURE `sp_check_attendance_finalized`(
    IN p_month INT,
    IN p_year INT
)
BEGIN
    SELECT 
        COUNT(*) as cnt,
        MAX(CASE WHEN UPPER(TRIM(is_finalized)) = 'Y' THEN 1 ELSE 0 END) as is_finalized
    FROM payroll_attendance_summary
    WHERE payroll_month = p_month
      AND payroll_year = p_year;
END$$

-- 31. sp_create_payroll_cycle
DROP PROCEDURE IF EXISTS `sp_create_payroll_cycle`$$
CREATE PROCEDURE `sp_create_payroll_cycle`(
    IN p_payroll_code VARCHAR(100),
    IN p_period_start DATE,
    IN p_period_end DATE,
    IN p_pay_date DATE,
    IN p_created_by VARCHAR(100)
)
BEGIN
    INSERT INTO payroll_cycles (payroll_code, period_start, period_end, pay_date, status, created_by, created_at, updated_at)
    VALUES (p_payroll_code, p_period_start, p_period_end, p_pay_date, 'DRAFT', p_created_by, NOW(), NOW());
    
    SELECT LAST_INSERT_ID() AS cycle_id;
END$$

-- 32. sp_update_cycle_status
DROP PROCEDURE IF EXISTS `sp_update_cycle_status`$$
CREATE PROCEDURE `sp_update_cycle_status`(
    IN p_cycle_id INT,
    IN p_status VARCHAR(50),
    IN p_actor VARCHAR(100)
)
BEGIN
    IF p_status = 'APPROVED' THEN
        UPDATE payroll_cycles
        SET status = p_status,
            approved_by = p_actor,
            approved_at = NOW(),
            updated_at = NOW()
        WHERE id = p_cycle_id;
    ELSEIF p_status = 'LOCKED' THEN
        UPDATE payroll_cycles
        SET status = p_status,
            locked_by = p_actor,
            locked_at = NOW(),
            updated_at = NOW()
        WHERE id = p_cycle_id;
    ELSE
        UPDATE payroll_cycles
        SET status = p_status,
            updated_at = NOW()
        WHERE id = p_cycle_id;
    END IF;
    SELECT ROW_COUNT() AS affected_rows;
END$$

-- 33. sp_update_attendance_override
DROP PROCEDURE IF EXISTS `sp_update_attendance_override`$$
CREATE PROCEDURE `sp_update_attendance_override`(
    IN p_id INT,
    IN p_new_status VARCHAR(20),
    IN p_is_paid TINYINT,
    IN p_reason VARCHAR(255),
    IN p_hr_user_id VARCHAR(100)
)
BEGIN
    UPDATE payroll_attendances
    SET original_status = IFNULL(original_status, status),
        status = p_new_status,
        is_paid = p_is_paid,
        is_hr_overridden = 1,
        override_reason = p_reason,
        updated_at = NOW()
    WHERE id = p_id;
    SELECT ROW_COUNT() AS affected_rows;
END$$

-- 34. sp_get_cycle_attendance_summaries
DROP PROCEDURE IF EXISTS `sp_get_cycle_attendance_summaries`$$
CREATE PROCEDURE `sp_get_cycle_attendance_summaries`(
    IN p_month INT,
    IN p_year INT
)
BEGIN
    SELECT *
    FROM payroll_attendance_summary
    WHERE payroll_month = p_month
      AND payroll_year = p_year;
END$$

-- 35. sp_get_pt_slabs
DROP PROCEDURE IF EXISTS `sp_get_pt_slabs`$$
CREATE PROCEDURE `sp_get_pt_slabs`(
    IN p_rule_code VARCHAR(50)
)
BEGIN
    SELECT ss.*
    FROM statutory_slabs ss
    JOIN statutory_rules sr ON sr.id = ss.rule_id
    WHERE sr.rule_code = p_rule_code;
END$$

-- 36. sp_get_mail_recipients_candidates
DROP PROCEDURE IF EXISTS `sp_get_mail_recipients_candidates`$$
CREATE PROCEDURE `sp_get_mail_recipients_candidates`()
BEGIN
    SELECT ref_id AS refid, emp_name, email, mobile
    FROM candidate_details
    WHERE email IS NOT NULL AND email != '';
END$$

-- 37. sp_get_mail_recipients_employees
DROP PROCEDURE IF EXISTS `sp_get_mail_recipients_employees`$$
CREATE PROCEDURE `sp_get_mail_recipients_employees`()
BEGIN
    SELECT emp_id, emp_name, email, mobile
    FROM user_details
    WHERE (at_blooms = 1 OR at_blooms IS NULL) AND email IS NOT NULL AND email != '';
END$$

DELIMITER ;

