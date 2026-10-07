<?php
$mysqli = new mysqli("localhost", "root", "vamsi123", "hrmsdevtest");

if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}

$query1 = <<<'SQL'
CREATE PROCEDURE `get_payroll_attendance_data_proc`(
    IN p_emp_id VARCHAR(20),
    IN p_month INT,
    IN p_year INT
)
BEGIN
    DECLARE v_user_category VARCHAR(20);
    
    SELECT user_category INTO v_user_category 
    FROM user_login_details 
    WHERE emp_id = p_emp_id LIMIT 1;
    
    IF v_user_category = 'ADMIN' THEN
        SELECT p.*, e.emp_name, 
               IFNULL(d.department_name, 'N/A') AS department, 
               IFNULL(dg.designation_name, 'N/A') AS designation 
        FROM payroll_attendance_summary p
        JOIN user_details e ON p.emp_id = e.emp_id
        LEFT JOIN department_master d ON e.department = d.department_id
        LEFT JOIN designation_master dg ON e.designation = dg.designation_id
        WHERE p.payroll_month = p_month AND p.payroll_year = p_year
        ORDER BY p.emp_id ASC;
    ELSE
        SELECT 'UNAUTHORIZED' AS error_msg;
    END IF;
END;
SQL;

$query2 = <<<'SQL'
CREATE PROCEDURE `finalize_payroll_attendance_proc`(
    IN p_emp_id VARCHAR(20),
    IN p_month INT,
    IN p_year INT
)
BEGIN
    DECLARE v_user_category VARCHAR(20);
    
    SELECT user_category INTO v_user_category 
    FROM user_login_details 
    WHERE emp_id = p_emp_id LIMIT 1;
    
    IF v_user_category = 'ADMIN' THEN
        UPDATE payroll_attendance_summary 
        SET is_finalized = 'Y' 
        WHERE payroll_month = p_month AND payroll_year = p_year;
    END IF;
END;
SQL;

$mysqli->query("DROP PROCEDURE IF EXISTS get_payroll_attendance_data_proc");
$mysqli->query("DROP PROCEDURE IF EXISTS finalize_payroll_attendance_proc");

if ($mysqli->query($query1)) {
    echo "Procedure get_payroll_attendance_data_proc created successfully.\n";
} else {
    echo "Error creating procedure 1: " . $mysqli->error . "\n";
}

if ($mysqli->query($query2)) {
    echo "Procedure finalize_payroll_attendance_proc created successfully.\n";
} else {
    echo "Error creating procedure 2: " . $mysqli->error . "\n";
}

$mysqli->close();
?>
