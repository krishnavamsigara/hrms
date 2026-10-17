<?php
$mysqli = new mysqli("localhost", "root", "vamsi123", "hrmsdevtest");

$procs = [
    'sp_get_salary_components',
    'sp_salary_component_cud',
    'sp_get_emp_salary_structure',
    'sp_save_emp_salary_structure',
    'sp_get_all_emp_salary_structures',
    'sp_calculate_employee_payroll',
    'sp_calculate_monthly_payroll',
    'sp_create_payroll_cycle',
    'sp_create_payroll_run',
    'sp_finalize_payroll_run',
    'sp_generate_payslips'
];

$out = "";
foreach ($procs as $p) {
    $res = $mysqli->query("SHOW CREATE PROCEDURE `$p`");
    if ($res && $row = $res->fetch_assoc()) {
        $out .= "=====================================\n";
        $out .= "PROCEDURE: $p\n";
        $out .= "=====================================\n";
        $out .= $row['Create Procedure'] . "\n\n";
    } else {
        $out .= "PROCEDURE $p NOT FOUND: " . $mysqli->error . "\n";
    }
}
file_put_contents(__DIR__ . '/inspect_procs.txt', $out);
echo "Written " . strlen($out) . " bytes\n";
