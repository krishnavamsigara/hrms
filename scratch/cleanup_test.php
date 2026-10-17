<?php
$mysqli = new mysqli("localhost", "root", "vamsi123", "hrmsdevtest");
$mysqli->query("DELETE FROM employee_salary_component WHERE salary_structure_id IN (119, 120)");
$mysqli->query("DELETE FROM employee_salary_structure WHERE salary_structure_id IN (119, 120)");
$mysqli->query("UPDATE employee_salary_structure SET effective_to = NULL, payroll_status = 'APPROVED' WHERE emp_id = 'BS00003' AND salary_structure_id = 2");

$res = $mysqli->query("SELECT * FROM employee_salary_structure WHERE emp_id = 'BS00003'");
while ($r = $res->fetch_assoc()) {
    print_r($r);
}
echo "Cleaned up!\n";
