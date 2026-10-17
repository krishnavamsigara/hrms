<?php
$mysqli = new mysqli("localhost", "root", "vamsi123", "hrmsdevtest");
$res = $mysqli->query("SELECT payroll_month, payroll_year, is_finalized, COUNT(*) as cnt FROM payroll_attendance_summary GROUP BY payroll_month, payroll_year, is_finalized");
echo "=== PAYROLL ATTENDANCE SUMMARY STATUSES ===\n";
while ($r = $res->fetch_assoc()) {
    print_r($r);
}

$resRuns = $mysqli->query("SELECT payroll_run_id, payroll_month, payroll_year, period_start, period_end, payroll_status, employee_count FROM payroll_run");
echo "\n=== EXISTING PAYROLL RUNS ===\n";
while ($r = $resRuns->fetch_assoc()) {
    print_r($r);
}
