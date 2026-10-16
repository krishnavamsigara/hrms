<?php
$pdo = new PDO('mysql:host=localhost;dbname=hrmsdevtest;charset=utf8mb4', 'root', 'vamsi123');
$pdo->exec("DROP PROCEDURE IF EXISTS finalize_payroll_attendance_proc");
$pdo->exec("
CREATE PROCEDURE `finalize_payroll_attendance_proc`(
    IN p_emp_id VARCHAR(20),
    IN p_month INT,
    IN p_year INT
)
BEGIN
    DECLARE v_user_category VARCHAR(20);
    
    SELECT UPPER(user_category) INTO v_user_category 
    FROM user_login_details 
    WHERE emp_id = p_emp_id LIMIT 1;
    
    IF v_user_category IN ('ADMIN', 'HR', 'SUPERADMIN') THEN
        UPDATE payroll_attendance_summary 
        SET is_finalized = 'Y' 
        WHERE payroll_month = p_month AND payroll_year = p_year;
    END IF;
END
");
echo "finalize_payroll_attendance_proc updated successfully.\n";
