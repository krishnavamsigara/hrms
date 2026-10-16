<?php
$pdo = new PDO('mysql:host=localhost;dbname=hrmsdevtest;charset=utf8mb4', 'root', 'vamsi123', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

$sql = file_get_contents(__DIR__ . '/create_payroll_tables.sql');
$pdo->exec($sql);
echo "All 7 tables created successfully!\n";

$tables = [
    'salary_component_master',
    'employee_salary_structure',
    'employee_salary_component',
    'payroll_run',
    'payroll_employee',
    'payroll_employee_component',
    'payslip'
];

foreach ($tables as $t) {
    $c = $pdo->query("SHOW TABLES LIKE '$t'")->rowCount();
    echo "  $t: " . ($c ? "OK" : "MISSING") . "\n";
}
