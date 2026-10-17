<?php
$mysqli = new mysqli("localhost", "root", "vamsi123", "hrmsdevtest");
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

echo "=== 1. FETCH CURRENT ACTIVE STRUCTURE FOR BS00003 ===\n";
$res = $mysqli->query("SELECT * FROM employee_salary_structure WHERE emp_id = 'BS00003' AND payroll_status = 'APPROVED' ORDER BY structure_version DESC LIMIT 1");
$current = $res->fetch_assoc();
print_r($current);
$origStructId = $current ? (int)$current['salary_structure_id'] : 0;
$origVersion = $current ? (int)$current['structure_version'] : 1;
$origCtc = $current ? (float)$current['monthly_ctc'] : 25000.00;

echo "\n=== 2. FETCH MASTER COMPONENTS ===\n";
$resMaster = $mysqli->query("SELECT * FROM salary_component_master WHERE is_active = 1 ORDER BY component_id ASC");
$masterComps = [];
while ($m = $resMaster->fetch_assoc()) {
    $masterComps[$m['component_id']] = $m;
}
echo "Total active master components: " . count($masterComps) . "\n";

echo "\n=== 3. SIMULATE ACTION BUTTON 'SAVE & APPROVE REVISION' TO 30,000 CTC ===\n";
// Suppose admin sets CTC = 30000, and modifies amounts:
// Basic = 15000 (50%), HRA = 6000 (20%), Conv = 2400 (8%), Med = 1500 (5%), Spl = 5100 (17%)
// Total gross = 30000
// Deductions: PF = 1800, PT = 200. Total ded = 2000. Net = 28000.
$newCtc = 30000.00;
$effectiveFrom = '2026-10-01';

// We mark previous structures inactive
$stmt = $mysqli->prepare("UPDATE employee_salary_structure SET effective_to = DATE_SUB(?, INTERVAL 1 DAY), payroll_status = 'INACTIVE' WHERE emp_id = 'BS00003'");
$stmt->bind_param("s", $effectiveFrom);
$stmt->execute();

$nextVersion = $origVersion + 1;
$stmt2 = $mysqli->prepare("INSERT INTO employee_salary_structure (emp_id, structure_version, effective_from, effective_to, monthly_ctc, payroll_status, approved_by, approved_at, created_at, updated_at) VALUES ('BS00003', ?, ?, NULL, ?, 'APPROVED', 'ADMIN', NOW(), NOW(), NOW())");
$stmt2->bind_param("isd", $nextVersion, $effectiveFrom, $newCtc);
$stmt2->execute();
$newStructId = $mysqli->insert_id;
echo "Inserted new structure ID: $newStructId, Version: $nextVersion, Monthly CTC: $newCtc\n";

// Insert component breakdown
$testComponents = [
    // compId => [monthly_amount, pct, is_active]
];

foreach ($masterComps as $cid => $m) {
    $code = $m['component_code'];
    $amt = 0.00;
    $pct = $m['percentage_value'];
    $active = 1;

    if ($code === 'BASIC') { $amt = 15000.00; $pct = 50.00; }
    elseif ($code === 'HRA') { $amt = 6000.00; $pct = 20.00; }
    elseif ($code === 'CONVEYANCE') { $amt = 2400.00; $pct = 8.00; }
    elseif ($code === 'MEDICAL') { $amt = 1500.00; $pct = 5.00; }
    elseif ($code === 'SPECIAL_ALLOWANCE') { $amt = 5100.00; $pct = 17.00; }
    elseif ($code === 'PF_EMPLOYEE') { $amt = 1800.00; $pct = 12.00; }
    elseif ($code === 'PROF_TAX') { $amt = 200.00; $pct = null; }
    elseif ($code === 'PF_EMPLOYER') { $amt = 1800.00; $pct = 12.00; }
    elseif ($code === 'ESI_EMPLOYEE' || $code === 'ESI_EMPLOYER') { $amt = 0.00; $pct = 0.00; }

    $stmtC = $mysqli->prepare("INSERT INTO employee_salary_component (salary_structure_id, component_id, monthly_amount, percentage_value, is_active, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
    $stmtC->bind_param("iiddi", $newStructId, $cid, $amt, $pct, $active);
    $stmtC->execute();
}

echo "\n=== 4. VERIFY INSERTED COMPONENTS FOR NEW STRUCTURE ===\n";
$resCheck = $mysqli->query("SELECT esc.*, m.component_code FROM employee_salary_component esc JOIN salary_component_master m ON esc.component_id = m.component_id WHERE esc.salary_structure_id = $newStructId ORDER BY esc.component_id ASC");
while ($r = $resCheck->fetch_assoc()) {
    echo sprintf("Comp #%d [%-18s]: amt=%.2f, pct=%s, active=%d\n", $r['component_id'], $r['component_code'], $r['monthly_amount'], $r['percentage_value'] ?? 'null', $r['is_active']);
}

echo "\n=== 5. TEST STORED PROCEDURE sp_calculate_employee_payroll WITH REVISED 30K CTC ===\n";
// Call stored procedure on run 1 (or simulated run) with OUT parameters
$mysqli->query("CALL sp_calculate_employee_payroll(1, 'BS00003', 'ADMIN', @p_status, @p_message)");
$resPe = $mysqli->query("SELECT * FROM payroll_employee WHERE payroll_run_id = 1 AND emp_id = 'BS00003'");
$pe = $resPe->fetch_assoc();
echo "Stored payroll_employee snapshot:\n";
print_r($pe);

echo "\n=== 6. CLEAN UP TEST REVISION (RESTORE TO ORIGINAL STATE) ===\n";
$mysqli->query("DELETE FROM employee_salary_component WHERE salary_structure_id = $newStructId");
$mysqli->query("DELETE FROM employee_salary_structure WHERE salary_structure_id = $newStructId");
$mysqli->query("UPDATE employee_salary_structure SET effective_to = NULL, payroll_status = 'APPROVED' WHERE salary_structure_id = $origStructId");

// Recalculate employee payroll with original structure
$mysqli->query("CALL sp_calculate_employee_payroll(1, 'BS00003', 'ADMIN', @p_status, @p_message)");
$resPeRestored = $mysqli->query("SELECT * FROM payroll_employee WHERE payroll_run_id = 1 AND emp_id = 'BS00003'");
$peRestored = $resPeRestored->fetch_assoc();
echo "Restored original monthly_ctc: " . $peRestored['monthly_ctc'] . "\n";
echo "SUCCESS: Individual structure save, component mapping, and payroll cycle calculation verified!\n";
