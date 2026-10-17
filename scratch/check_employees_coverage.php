<?php
$mysqli = new mysqli("localhost", "root", "vamsi123", "hrmsdevtest");

$resActive = $mysqli->query("SELECT COUNT(*) FROM user_details WHERE LOWER(profisional_details_status) = 'active'");
echo "Active employees in user_details: " . $resActive->fetch_row()[0] . "\n";

$resStruct = $mysqli->query("SELECT COUNT(DISTINCT emp_id) FROM employee_salary_structure WHERE payroll_status = 'APPROVED'");
echo "Employees with approved employee_salary_structure: " . $resStruct->fetch_row()[0] . "\n";

$resMissing = $mysqli->query("SELECT u.emp_id, u.emp_name FROM user_details u WHERE LOWER(u.profisional_details_status) = 'active' AND u.emp_id NOT IN (SELECT emp_id FROM employee_salary_structure WHERE payroll_status = 'APPROVED')");
echo "Active employees WITHOUT approved employee_salary_structure: " . $resMissing->num_rows . "\n";
while ($r = $resMissing->fetch_assoc()) {
    echo " - {$r['emp_id']}: {$r['emp_name']}\n";
}
