<?php
$pdo = new PDO('mysql:host=localhost;dbname=hrmsdevtest;charset=utf8mb4', 'root', 'vamsi123', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

$tablesToCheck = [
    'salary_component_master',
    'employee_salary_structure',
    'employee_salary_component',
    'payroll_run',
    'payroll_employee',
    'payroll_employee_component',
    'payslip',
    'payslips',
    'salary_components',
    'emp_salary_structures',
    'payroll_cycles',
    'payroll_employees',
    'payroll_attendance_summary',
    'user_details',
    'user_login_details'
];

foreach ($tablesToCheck as $t) {
    $exists = $pdo->query("SHOW TABLES LIKE '$t'")->rowCount();
    echo str_pad($t, 32) . ": " . ($exists ? "EXISTS" : "NOT FOUND") . "\n";
    if ($exists && in_array($t, ['salary_component_master', 'employee_salary_structure', 'employee_salary_component', 'payroll_run', 'payroll_employee', 'payroll_employee_component', 'payslip'])) {
        $cols = $pdo->query("DESCRIBE `$t`")->fetchAll(PDO::FETCH_ASSOC);
        foreach ($cols as $c) {
            echo "   " . $c['Field'] . " (" . $c['Type'] . ")\n";
        }
    }
}
