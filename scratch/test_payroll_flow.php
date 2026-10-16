<?php
$mysqli = new mysqli("localhost", "root", "vamsi123", "hrmsdevtest");
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

echo "=== STEP 1: CREATE PAYROLL RUN ===\n";
$mysqli->query("CALL sp_create_payroll_run(9, 2026, 'FIXED_30', 'BS00001', @run_id, @status, @message)");
while ($mysqli->next_result()) { /* flush */ }
$res = $mysqli->query("SELECT @run_id AS run_id, @status AS status, @message AS message")->fetch_assoc();
print_r($res);
$runId = (int)$res['run_id'];

echo "\n=== STEP 2: CALCULATE MONTHLY PAYROLL ===\n";
$mysqli->query("CALL sp_calculate_monthly_payroll($runId, 'BS00001', @processed, @errors, @status, @message)");
while ($mysqli->next_result()) { /* flush */ }
$calcRes = $mysqli->query("SELECT @processed AS processed, @errors AS errors, @status AS status, @message AS message")->fetch_assoc();
print_r($calcRes);

echo "\n=== STEP 3: INSPECT CALCULATED EMPLOYEE (BS00001) ===\n";
$pe = $mysqli->query("SELECT * FROM payroll_employee WHERE payroll_run_id = $runId AND emp_id = 'BS00001'")->fetch_assoc();
print_r($pe);

echo "\n=== STEP 4: INSPECT COMPONENTS FOR BS00001 ===\n";
$comps = $mysqli->query("SELECT component_code, component_name, component_type, monthly_amount, calculated_amount, lop_amount, payable_amount FROM payroll_employee_component WHERE payroll_employee_id = " . $pe['payroll_employee_id'])->fetch_all(MYSQLI_ASSOC);
print_r($comps);

echo "\n=== STEP 5: APPROVE RUN ===\n";
$mysqli->query("CALL sp_approve_payroll_run($runId, 'BS00001', @status, @message)");
while ($mysqli->next_result()) { /* flush */ }
$appRes = $mysqli->query("SELECT @status AS status, @message AS message")->fetch_assoc();
print_r($appRes);

echo "\n=== STEP 6: FINALIZE RUN & GENERATE PAYSLIPS ===\n";
$mysqli->query("CALL sp_finalize_payroll_run($runId, 'BS00001', @status, @message)");
while ($mysqli->next_result()) { /* flush */ }
$finRes = $mysqli->query("SELECT @status AS status, @message AS message")->fetch_assoc();
print_r($finRes);

echo "\n=== STEP 7: INSPECT GENERATED PAYSLIP RECORD ===\n";
$ps = $mysqli->query("SELECT * FROM payslip WHERE payroll_employee_id = " . $pe['payroll_employee_id'])->fetch_assoc();
print_r($ps);

$mysqli->close();
