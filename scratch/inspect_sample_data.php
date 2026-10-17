<?php
$mysqli = new mysqli("localhost", "root", "vamsi123", "hrmsdevtest");

echo "=== PAYROLL RUNS ===\n";
$resRuns = $mysqli->query("SELECT * FROM payroll_run");
while ($r = $resRuns->fetch_assoc()) {
    print_r($r);
}

echo "\n=== SAMPLE EMPLOYEE STRUCTURE (BS00001) ===\n";
$resStruct = $mysqli->query("SELECT * FROM employee_salary_structure WHERE emp_id = 'BS00001'");
while ($r = $resStruct->fetch_assoc()) {
    print_r($r);
}

echo "\n=== SAMPLE PAYROLL EMPLOYEE (BS00001 in Run 1) ===\n";
$resPe = $mysqli->query("SELECT * FROM payroll_employee WHERE emp_id = 'BS00001'");
while ($r = $resPe->fetch_assoc()) {
    print_r($r);
}
