<?php
$pdo = new PDO('mysql:host=localhost;dbname=hrmsdevtest;charset=utf8mb4', 'root', 'vamsi123', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

// 1. Seed salary_component_master
$components = [
    [
        'code' => 'BASIC',
        'name' => 'Basic Salary',
        'type' => 'EARNING',
        'calc' => 'PERCENTAGE',
        'base' => 'CTC',
        'val'  => 50.0000,
        'lop'  => 1,
        'tax'  => 1
    ],
    [
        'code' => 'HRA',
        'name' => 'House Rent Allowance',
        'type' => 'EARNING',
        'calc' => 'PERCENTAGE',
        'base' => 'CTC',
        'val'  => 20.0000,
        'lop'  => 1,
        'tax'  => 1
    ],
    [
        'code' => 'CONVEYANCE',
        'name' => 'Conveyance Allowance',
        'type' => 'EARNING',
        'calc' => 'PERCENTAGE',
        'base' => 'CTC',
        'val'  => 8.0000,
        'lop'  => 1,
        'tax'  => 1
    ],
    [
        'code' => 'MEDICAL',
        'name' => 'Medical Allowance',
        'type' => 'EARNING',
        'calc' => 'PERCENTAGE',
        'base' => 'CTC',
        'val'  => 5.0000,
        'lop'  => 1,
        'tax'  => 1
    ],
    [
        'code' => 'SPECIAL_ALLOWANCE',
        'name' => 'Special Allowance',
        'type' => 'EARNING',
        'calc' => 'PERCENTAGE',
        'base' => 'CTC',
        'val'  => 17.0000,
        'lop'  => 1,
        'tax'  => 1
    ],
    [
        'code' => 'BONUS',
        'name' => 'Performance Bonus',
        'type' => 'EARNING',
        'calc' => 'FIXED',
        'base' => 'NONE',
        'val'  => null,
        'lop'  => 0,
        'tax'  => 1
    ],
    [
        'code' => 'OVERTIME',
        'name' => 'Overtime Allowance',
        'type' => 'EARNING',
        'calc' => 'FIXED',
        'base' => 'NONE',
        'val'  => null,
        'lop'  => 0,
        'tax'  => 1
    ],
    [
        'code' => 'PF_EMPLOYEE',
        'name' => 'Provident Fund (Employee)',
        'type' => 'DEDUCTION',
        'calc' => 'FIXED',
        'base' => 'BASIC',
        'val'  => null,
        'lop'  => 0,
        'tax'  => 0
    ],
    [
        'code' => 'ESI_EMPLOYEE',
        'name' => 'ESI (Employee)',
        'type' => 'DEDUCTION',
        'calc' => 'PERCENTAGE',
        'base' => 'GROSS',
        'val'  => 0.7500,
        'lop'  => 0,
        'tax'  => 0
    ],
    [
        'code' => 'PROF_TAX',
        'name' => 'Professional Tax',
        'type' => 'DEDUCTION',
        'calc' => 'FIXED',
        'base' => 'NONE',
        'val'  => null,
        'lop'  => 0,
        'tax'  => 0
    ],
    [
        'code' => 'TDS',
        'name' => 'Tax Deducted at Source (TDS)',
        'type' => 'DEDUCTION',
        'calc' => 'FIXED',
        'base' => 'NONE',
        'val'  => null,
        'lop'  => 0,
        'tax'  => 0
    ],
    [
        'code' => 'PF_EMPLOYER',
        'name' => 'Provident Fund (Employer)',
        'type' => 'EMPLOYER_CONTRIBUTION',
        'calc' => 'FIXED',
        'base' => 'BASIC',
        'val'  => null,
        'lop'  => 0,
        'tax'  => 0
    ],
    [
        'code' => 'ESI_EMPLOYER',
        'name' => 'ESI (Employer)',
        'type' => 'EMPLOYER_CONTRIBUTION',
        'calc' => 'PERCENTAGE',
        'base' => 'GROSS',
        'val'  => 3.2500,
        'lop'  => 0,
        'tax'  => 0
    ]
];

$stmtComp = $pdo->prepare("
    INSERT INTO salary_component_master 
    (component_code, component_name, component_type, calculation_type, percentage_base, percentage_value, is_lop_applicable, is_taxable, is_active)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, 1)
    ON DUPLICATE KEY UPDATE 
    component_name = VALUES(component_name),
    component_type = VALUES(component_type),
    calculation_type = VALUES(calculation_type),
    percentage_base = VALUES(percentage_base),
    percentage_value = VALUES(percentage_value),
    is_lop_applicable = VALUES(is_lop_applicable),
    is_taxable = VALUES(is_taxable)
");

foreach ($components as $c) {
    $stmtComp->execute([$c['code'], $c['name'], $c['type'], $c['calc'], $c['base'], $c['val'], $c['lop'], $c['tax']]);
}
echo "Seeded " . count($components) . " master components successfully.\n";

// Map component codes to component_id
$compMap = [];
foreach ($pdo->query("SELECT component_id, component_code FROM salary_component_master") as $r) {
    $compMap[$r['component_code']] = $r['component_id'];
}

// 2. Fetch active employees
$users = $pdo->query("SELECT emp_id, emp_name FROM user_details WHERE LOWER(profisional_details_status) = 'active'")->fetchAll(PDO::FETCH_ASSOC);
echo "Found " . count($users) . " active employees in user_details.\n";

$stmtInsertStruct = $pdo->prepare("
    INSERT INTO employee_salary_structure 
    (emp_id, structure_version, effective_from, effective_to, monthly_ctc, payroll_status, approved_by, approved_at)
    VALUES (?, 1, '2026-04-01', NULL, ?, 'APPROVED', 'BS00001', NOW())
    ON DUPLICATE KEY UPDATE monthly_ctc = VALUES(monthly_ctc), payroll_status = 'APPROVED'
");

$stmtInsertComp = $pdo->prepare("
    INSERT INTO employee_salary_component
    (salary_structure_id, component_id, monthly_amount, percentage_value, is_active)
    VALUES (?, ?, ?, ?, 1)
    ON DUPLICATE KEY UPDATE monthly_amount = VALUES(monthly_amount), percentage_value = VALUES(percentage_value)
");

$assignedCount = 0;
foreach ($users as $u) {
    $empId = $u['emp_id'];

    // Try to get monthly CTC from old tables
    $oldSal = $pdo->query("SELECT salary FROM employee_salary WHERE emp_id = " . $pdo->quote($empId) . " ORDER BY id DESC LIMIT 1")->fetch(PDO::FETCH_ASSOC);
    $monthlyCtc = 0;
    if ($oldSal && (float)$oldSal['salary'] > 0) {
        $monthlyCtc = (float)$oldSal['salary'];
    } else {
        $oldEss = $pdo->query("SELECT SUM(amount) as s FROM emp_salary_structures WHERE emp_id = " . $pdo->quote($empId) . " AND component_id IN (1,2,3,4,5)")->fetch(PDO::FETCH_ASSOC);
        if ($oldEss && (float)$oldEss['s'] > 0) {
            $monthlyCtc = (float)$oldEss['s'];
        } else {
            $monthlyCtc = 30000.00;
        }
    }

    $stmtInsertStruct->execute([$empId, $monthlyCtc]);
    $structId = $pdo->query("SELECT salary_structure_id FROM employee_salary_structure WHERE emp_id = " . $pdo->quote($empId) . " AND structure_version = 1")->fetchColumn();

    // Standard breakdown
    $basic = round($monthlyCtc * 0.50, 2);
    $hra   = round($monthlyCtc * 0.20, 2);
    $med   = round($monthlyCtc * 0.05, 2);
    $conv  = round($monthlyCtc * 0.08, 2);
    $spl   = max(0, round($monthlyCtc - ($basic + $hra + $med + $conv), 2));

    $pfEmp = min(round($basic * 0.12, 2), 1800.00);
    $esiEmp = ($monthlyCtc <= 21000) ? round($monthlyCtc * 0.0075, 2) : 0.00;
    $pt    = ($monthlyCtc >= 20000) ? 200.00 : (($monthlyCtc >= 15000) ? 150.00 : 0.00);

    $pfEmplr = min(round($basic * 0.12, 2), 1800.00);
    $esiEmplr = ($monthlyCtc <= 21000) ? round($monthlyCtc * 0.0325, 2) : 0.00;

    // Insert earnings
    $stmtInsertComp->execute([$structId, $compMap['BASIC'], $basic, 50.0000]);
    $stmtInsertComp->execute([$structId, $compMap['HRA'], $hra, 20.0000]);
    $stmtInsertComp->execute([$structId, $compMap['CONVEYANCE'], $conv, 8.0000]);
    $stmtInsertComp->execute([$structId, $compMap['MEDICAL'], $med, 5.0000]);
    $stmtInsertComp->execute([$structId, $compMap['SPECIAL_ALLOWANCE'], $spl, 17.0000]);

    // Insert deductions
    $stmtInsertComp->execute([$structId, $compMap['PF_EMPLOYEE'], $pfEmp, null]);
    $stmtInsertComp->execute([$structId, $compMap['ESI_EMPLOYEE'], $esiEmp, 0.7500]);
    $stmtInsertComp->execute([$structId, $compMap['PROF_TAX'], $pt, null]);

    // Insert employer contributions
    $stmtInsertComp->execute([$structId, $compMap['PF_EMPLOYER'], $pfEmplr, null]);
    $stmtInsertComp->execute([$structId, $compMap['ESI_EMPLOYER'], $esiEmplr, 3.2500]);

    $assignedCount++;
}

echo "Created and assigned approved structures for $assignedCount employees successfully!\n";
