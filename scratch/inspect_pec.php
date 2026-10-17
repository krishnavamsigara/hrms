<?php
$mysqli = new mysqli("localhost", "root", "vamsi123", "hrmsdevtest");
$res = $mysqli->query("DESCRIBE payroll_employee_component");
echo "=== payroll_employee_component columns ===\n";
while ($r = $res->fetch_assoc()) {
    echo "{$r['Field']} - {$r['Type']}\n";
}

$resData = $mysqli->query("SELECT pec.*, scm.component_code, scm.component_name 
    FROM payroll_employee_component pec 
    JOIN salary_component_master scm ON pec.component_id = scm.component_id 
    WHERE pec.payroll_employee_id = 1");
echo "\n=== Sample Components for Employee 1 (BS00001) in Run 1 ===\n";
while ($r = $resData->fetch_assoc()) {
    print_r($r);
}
