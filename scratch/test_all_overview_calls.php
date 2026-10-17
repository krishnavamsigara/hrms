<?php
define('FCPATH', dirname(__DIR__) . '/public/');
require dirname(__DIR__) . '/app/Config/Paths.php';
$paths = new Config\Paths();
require $paths->systemDirectory . '/Boot.php';
// Boot CI4 CLI
CodeIgniter\Boot::bootTest($paths);

$model = new \App\Models\AdminModel();
$admin_emp_id = 'BS00001';
$startDate = '2026-09-25';
$endDate = '2026-10-24';
$searchParam = '';
$month = 10;
$year = 2026;
$cycleStartDay = 25;
$cycleEndDay = 24;
$startFilter = '2025-12-25';
$endFilter = '2026-12-24';

echo "1. Testing get_attendance_overview...\n";
$emps = $model->get_attendance_overview($admin_emp_id, $startDate, $endDate, $searchParam);
echo "Count: " . count($emps) . "\n";

echo "2. Testing get_payroll_attendance_summary_stats...\n";
$stats = $model->get_payroll_attendance_summary_stats($month, $year);
print_r($stats);

echo "3. Testing get_attendance_punch_stats...\n";
$pstats = $model->get_attendance_punch_stats($startDate, $endDate);
print_r($pstats);

echo "4. Testing get_annual_attendance_matrix...\n";
$mat = $model->get_annual_attendance_matrix($year, $cycleStartDay, $startFilter, $endFilter);
echo "Matrix Count: " . count($mat) . "\n";

echo "5. Testing get_annual_payroll_summary...\n";
$paysum = $model->get_annual_payroll_summary($year);
echo "Payroll Summary Count: " . count($paysum) . "\n";

echo "\nALL 5 CALLS COMPLETED WITH ZERO ERRORS!\n";
