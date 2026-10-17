<?php
define('FCPATH', dirname(__DIR__) . '/public/');
require dirname(__DIR__) . '/app/Config/Paths.php';

$mysqli = new mysqli("localhost", "root", "vamsi123", "hrmsdevtest");

// Let's test the query for check_attendance_finalized
$row = $mysqli->query("SELECT COUNT(*) as cnt, MAX(CASE WHEN UPPER(TRIM(is_finalized)) = 'Y' THEN 1 ELSE 0 END) as is_finalized FROM payroll_attendance_summary WHERE payroll_month = 10 AND payroll_year = 2026")->fetch_assoc();
print_r($row);

$row2 = $mysqli->query("SELECT COUNT(*) as cnt, MAX(CASE WHEN UPPER(TRIM(is_finalized)) = 'Y' THEN 1 ELSE 0 END) as is_finalized FROM payroll_attendance_summary WHERE payroll_month = 3 AND payroll_year = 2026")->fetch_assoc();
print_r($row2);

$row3 = $mysqli->query("SELECT COUNT(*) as cnt, MAX(CASE WHEN UPPER(TRIM(is_finalized)) = 'Y' THEN 1 ELSE 0 END) as is_finalized FROM payroll_attendance_summary WHERE payroll_month = 11 AND payroll_year = 2026")->fetch_assoc();
print_r($row3);
