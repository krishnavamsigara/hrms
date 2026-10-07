<?php
$mysqli = new mysqli("localhost", "root", "vamsi123", "hrmsdevtest");

if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}

$query = "
CREATE PROCEDURE get_attendance_overview_data(
    IN p_emp_id VARCHAR(20),
    IN p_start_date DATE,
    IN p_end_date DATE,
    IN p_search VARCHAR(255)
)
BEGIN
    DECLARE v_user_category VARCHAR(20);
    
    SELECT user_category INTO v_user_category 
    FROM user_login_details 
    WHERE emp_id = p_emp_id LIMIT 1;
    
    IF v_user_category = 'ADMIN' THEN
        SELECT 
            u.emp_id, 
            u.emp_name, 
            u.department, 
            u.designation, 
            u.reporting, 
            m.emp_name as manager_name,
            COUNT(CASE WHEN a.status IN ('PRESENT', 'WFH') THEN 1 END) as total_present,
            COUNT(CASE WHEN a.status = 'LEAVE' THEN 1 END) as total_leaves,
            COUNT(CASE WHEN a.status = 'WFH' THEN 1 END) as total_wfh,
            COUNT(CASE WHEN a.status = 'HOLIDAY' THEN 1 END) as total_holidays,
            IFNULL(SUM(TIMESTAMPDIFF(MINUTE, a.punch_in, a.punch_out)), 0) as total_work_mins
        FROM user_details u
        LEFT JOIN user_details m ON u.reporting = m.emp_id
        LEFT JOIN attendance a ON u.emp_id = a.emp_id AND a.attendance_date BETWEEN p_start_date AND p_end_date
        WHERE (p_search = '' OR u.emp_id LIKE CONCAT('%', p_search, '%') OR u.emp_name LIKE CONCAT('%', p_search, '%'))
        GROUP BY u.emp_id, u.emp_name, u.department, u.designation, u.reporting, m.emp_name;
    ELSE
        SELECT 'UNAUTHORIZED' as error_msg;
    END IF;
END;
";

if ($mysqli->query("DROP PROCEDURE IF EXISTS get_attendance_overview_data")) {
    echo "Dropped old procedure if existed.\n";
}

if ($mysqli->query($query)) {
    echo "Procedure created successfully.\n";
} else {
    echo "Error creating procedure: " . $mysqli->error . "\n";
}

$mysqli->close();
?>
