<?php
$mysqli = new mysqli("localhost", "root", "vamsi123", "hrmsdevtest");
$tables = [
    'payroll_run', 'payroll_cycle', 'payroll_cycles', 'payroll_employee', 'payroll_employees',
    'payroll_employee_component', 'employee_salary_structure', 'employee_salary_component',
    'emp_salary_structure', 'emp_salary_structures', 'salary_component_master', 'salary_components',
    'salary_component', 'employee_salary', 'salary', 'salary_details'
];

foreach ($tables as $t) {
    $res = $mysqli->query("SHOW TABLES LIKE '$t'");
    if ($res && $res->num_rows > 0) {
        $cntRes = $mysqli->query("SELECT COUNT(*) FROM `$t`");
        $cnt = $cntRes ? $cntRes->fetch_row()[0] : 'err';
        echo "$t: $cnt rows\n";
    } else {
        echo "$t: DOES NOT EXIST\n";
    }
}
