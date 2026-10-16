<?php
$pdo = new PDO('mysql:host=localhost;dbname=hrmsdevtest;charset=utf8mb4', 'root', 'vamsi123');
$res = $pdo->query("SHOW FULL COLUMNS FROM payroll_attendance_summary WHERE Field = 'emp_id'")->fetch(PDO::FETCH_ASSOC);
print_r($res);
$tbl = $pdo->query("SHOW TABLE STATUS WHERE Name = 'payroll_attendance_summary'")->fetch(PDO::FETCH_ASSOC);
echo "payroll_attendance_summary Collation: " . $tbl['Collation'] . "\n";
