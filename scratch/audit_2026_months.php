<?php
$pdo = new PDO('mysql:host=localhost;dbname=hrmsdevtest;charset=utf8mb4', 'root', 'vamsi123');

$settings = $pdo->query("SELECT * FROM company_settings LIMIT 1")->fetch(PDO::FETCH_ASSOC);
$startDay = (int)($settings['payroll_cycle_start_day'] ?? 25);
$endDay   = (int)($settings['payroll_cycle_end_day'] ?? 24);

echo "Company cut-off settings: $startDay th to $endDay th\n\n";

$year = 2026;
echo "=== 2026 ALL 12 MONTHS ATTENDANCE AUDIT ===\n";
echo str_pad("Month", 12) . " | " . str_pad("Cut-off Range", 25) . " | " . str_pad("Raw Att Rows", 14) . " | " . str_pad("Emps", 6) . " | Payroll Att Status\n";
echo str_repeat("-", 85) . "\n";

for ($m = 1; $m <= 12; $m++) {
    $monthName = date('F', mktime(0, 0, 0, $m, 10, $year));
    
    if ($m == 1) {
        $pStart = sprintf('%04d-12-%02d', $year - 1, $startDay);
    } else {
        $pStart = sprintf('%04d-%02d-%02d', $year, $m - 1, $startDay);
    }
    $pEnd = sprintf('%04d-%02d-%02d', $year, $m, $endDay);
    $rangeLabel = "$pStart to $pEnd";

    // Raw attendance count in cut-off range
    $stmt = $pdo->prepare("SELECT COUNT(*) as cnt, COUNT(DISTINCT emp_id) as emps FROM attendance WHERE attendance_date BETWEEN ? AND ?");
    $stmt->execute([$pStart, $pEnd]);
    $raw = $stmt->fetch(PDO::FETCH_ASSOC);

    // Also raw attendance in calendar month
    $stmtCal = $pdo->prepare("SELECT COUNT(*) as cnt, COUNT(DISTINCT emp_id) as emps FROM attendance WHERE YEAR(attendance_date) = ? AND MONTH(attendance_date) = ?");
    $stmtCal->execute([$year, $m]);
    $cal = $stmtCal->fetch(PDO::FETCH_ASSOC);

    // Payroll summary status
    $stmtSum = $pdo->prepare("SELECT is_finalized, COUNT(*) as cnt FROM payroll_attendance_summary WHERE payroll_month = ? AND payroll_year = ? GROUP BY is_finalized");
    $stmtSum->execute([$m, $year]);
    $sum = $stmtSum->fetch(PDO::FETCH_ASSOC);

    $payrollStatus = "Not Generated";
    if ($sum) {
        $payrollStatus = ($sum['is_finalized'] == 'Y' ? "FINALIZED (Y)" : "Pending (N)") . " [" . $sum['cnt'] . " emps]";
    }

    $rawInfo = $raw['cnt'] . " (cal: " . $cal['cnt'] . ")";
    echo str_pad($monthName, 12) . " | " . str_pad($rangeLabel, 25) . " | " . str_pad($rawInfo, 14) . " | " . str_pad($raw['emps'], 6) . " | " . $payrollStatus . "\n";
}
