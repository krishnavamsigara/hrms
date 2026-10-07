<?php
$pdo = new PDO('mysql:host=localhost;dbname=hrmsdevtest;charset=utf8mb4', 'root', 'vamsi123');
$stmt = $pdo->query("
    SELECT u.emp_id, u.emp_name, u.email, u.mobile, u.joining_date,
           d.department_name, des.designation_name,
           m.emp_name AS reporting_manager
    FROM user_details u
    LEFT JOIN department_master d ON u.department = d.department_id
    LEFT JOIN designation_master des ON u.designation = des.designation_id
    LEFT JOIN user_details m ON u.reporting = m.emp_id
    ORDER BY u.emp_id ASC
");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo "Users:\n";
print_r($users);
