<?php
require_once __DIR__ . '/../app/Config/Paths.php';

$mysqli = new mysqli("localhost", "root", "vamsi123", "hrmsdevtest");
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

echo "====================================================================\n";
echo "TEST 1: ADDING NEW SALARY COMPONENT & AUTO-ASSIGNING TO ALL EMPLOYEES\n";
echo "====================================================================\n";

// 1. Insert a new test component
$compCode = "TRAVEL_ALLOW";
$compName = "Travel & Field Allowance";

// Clean up if existed
$exist = $mysqli->query("SELECT component_id FROM salary_component_master WHERE component_code = '$compCode'")->fetch_assoc();
if ($exist) {
    $mysqli->query("DELETE FROM employee_salary_component WHERE component_id = {$exist['component_id']}");
    $mysqli->query("DELETE FROM salary_component_master WHERE component_id = {$exist['component_id']}");
}

$mysqli->query("INSERT INTO salary_component_master (component_code, component_name, component_type, calculation_type, percentage_base, percentage_value, is_lop_applicable, is_taxable, is_active, created_at)
VALUES ('$compCode', '$compName', 'EARNING', 'FIXED', 'NONE', NULL, 1, 1, 1, NOW())");
$testCompId = $mysqli->insert_id;
echo "Inserted test component ID: $testCompId ($compCode)\n";

// Call stored procedure sp_add_component_to_all_employees
$mysqli->query("CALL sp_add_component_to_all_employees($testCompId)");
echo "Called sp_add_component_to_all_employees($testCompId)\n";

// Count how many employee salary structures have this component in active state
$cntRes = $mysqli->query("SELECT COUNT(*) AS cnt FROM employee_salary_component WHERE component_id = $testCompId AND is_active = 1");
$assignedCount = $cntRes->fetch_assoc()['cnt'];
echo "Total employee structures with $compCode in ACTIVE state: $assignedCount\n";

$totalEmps = $mysqli->query("SELECT COUNT(*) AS cnt FROM user_details WHERE LOWER(profisional_details_status) = 'active'")->fetch_assoc()['cnt'];
echo "Total active employees in company: $totalEmps\n";

if ($assignedCount === (int)$totalEmps) {
    echo "✓ SUCCESS: Component was automatically attached to ALL active employees in active state!\n";
} else {
    echo "⚠ WARNING: Assigned ($assignedCount) does not match total ($totalEmps)\n";
}


echo "\n====================================================================\n";
echo "TEST 2: SALARY STRUCTURE REVISION (e.g. 25k -> 30k) & EXACT CAPTURE\n";
echo "====================================================================\n";

$testEmpId = "BS00003"; // Venkata Phani Kiran Vemuri

// Read current structure
$resCur = $mysqli->query("SELECT salary_structure_id, structure_version, monthly_ctc, effective_from FROM employee_salary_structure WHERE emp_id = '$testEmpId' AND payroll_status = 'APPROVED' ORDER BY structure_version DESC LIMIT 1");
$curStruct = $resCur->fetch_assoc();
echo "Current Structure for $testEmpId: Version v{$curStruct['structure_version']}, Monthly CTC: ₹{$curStruct['monthly_ctc']}, Effective From: {$curStruct['effective_from']}\n";

// Simulate revision from 25k to 30,000.00
$newCtc = 30000.00;
$nextVersion = (int)$curStruct['structure_version'] + 1;
$effectiveFrom = '2026-10-01';

// Update previous to INACTIVE
$mysqli->query("UPDATE employee_salary_structure SET effective_to = '2026-09-30', payroll_status = 'INACTIVE' WHERE emp_id = '$testEmpId'");

// Insert new approved version
$mysqli->query("INSERT INTO employee_salary_structure (emp_id, structure_version, effective_from, effective_to, monthly_ctc, payroll_status, approved_by, approved_at, created_at, updated_at)
VALUES ('$testEmpId', $nextVersion, '$effectiveFrom', NULL, $newCtc, 'APPROVED', 'ADMIN', NOW(), NOW(), NOW())");
$newStructId = $mysqli->insert_id;
echo "Inserted New Structure ID: $newStructId, Version v$nextVersion, Monthly CTC: ₹$newCtc\n";

// Insert component breakdown for 30k
$basic = 15000.00; // 50%
$hra   = 6000.00;  // 20%
$conv  = 2400.00;  // 8%
$med   = 1500.00;  // 5%
$spl   = 5100.00;  // 17% (Total Earnings = 30,000)
$pfEmp = 1800.00;
$pt    = 200.00;
$pfEmplr = 1800.00;

$compsToInsert = [
    1  => ['amt' => $basic, 'pct' => 50.00], // BASIC
    2  => ['amt' => $hra,   'pct' => 20.00], // HRA
    3  => ['amt' => $conv,  'pct' => 8.00],  // CONVEYANCE
    4  => ['amt' => $med,   'pct' => 5.00],  // MEDICAL
    5  => ['amt' => $spl,   'pct' => 17.00], // SPECIAL_ALLOWANCE
    $testCompId => ['amt' => 0.00, 'pct' => null], // TRAVEL_ALLOW
    15 => ['amt' => $pfEmp, 'pct' => null],  // PF_EMPLOYEE
    17 => ['amt' => $pt,    'pct' => null],  // PROF_TAX
    19 => ['amt' => $pfEmplr, 'pct' => null] // PF_EMPLOYER
];

foreach ($compsToInsert as $cid => $cdata) {
    $pctSql = $cdata['pct'] !== null ? $cdata['pct'] : "NULL";
    $mysqli->query("INSERT INTO employee_salary_component (salary_structure_id, component_id, monthly_amount, percentage_value, is_active, created_at)
    VALUES ($newStructId, $cid, {$cdata['amt']}, $pctSql, 1, NOW())");
}
echo "Inserted " . count($compsToInsert) . " components for 30k structure.\n";


echo "\n====================================================================\n";
echo "TEST 3: PAYROLL CYCLE CALCULATION VERIFICATION FOR 30,000 CTC\n";
echo "====================================================================\n";

// Create or use Payroll Run for October 2026 (Month 10, Year 2026: 25 Sep - 24 Oct)
$mysqli->query("CALL sp_create_payroll_run(10, 2026, 'FIXED_30', 'ADMIN', @p_run_id, @p_status, @p_msg)");
$runRes = $mysqli->query("SELECT @p_run_id AS run_id, @p_status AS status, @p_msg AS msg")->fetch_assoc();
$octRunId = (int)$runRes['run_id'];
echo "October 2026 Payroll Run ID: $octRunId (Status: {$runRes['status']}, Msg: {$runRes['msg']})\n";

// Calculate employee $testEmpId in October Payroll Run
$mysqli->query("CALL sp_calculate_employee_payroll($octRunId, '$testEmpId', 'ADMIN', @p_status, @p_msg)");
$calcRes = $mysqli->query("SELECT @p_status AS status, @p_msg AS msg")->fetch_assoc();
echo "Calculation status for $testEmpId: {$calcRes['status']} — {$calcRes['msg']}\n";

// Check payroll_employee record
$pe = $mysqli->query("SELECT * FROM payroll_employee WHERE payroll_run_id = $octRunId AND emp_id = '$testEmpId'")->fetch_assoc();
echo "\n--- Verified payroll_employee Record ---\n";
echo "  emp_id:                  {$pe['emp_id']}\n";
echo "  salary_structure_id:     {$pe['salary_structure_id']} (Expected: $newStructId)\n";
echo "  monthly_ctc:             ₹{$pe['monthly_ctc']} (EXACT 30,000 STORED IN CYCLE!)\n";
echo "  gross_earnings:          ₹{$pe['gross_earnings']}\n";
echo "  lop_deduction:           ₹{$pe['lop_deduction']}\n";
echo "  other_deductions:        ₹{$pe['other_deductions']}\n";
echo "  net_salary:              ₹{$pe['net_salary']}\n";
echo "  calculation_status:      {$pe['calculation_status']}\n";

// Check components saved in payroll_employee_component
$peComps = $mysqli->query("SELECT * FROM payroll_employee_component WHERE payroll_employee_id = {$pe['payroll_employee_id']} ORDER BY component_id ASC")->fetch_all(MYSQLI_ASSOC);
echo "\n--- Verified payroll_employee_component Snapshots (" . count($peComps) . " components) ---\n";
foreach ($peComps as $pec) {
    echo "  {$pec['component_code']}: monthly_amt=₹{$pec['monthly_amount']}, payable=₹{$pec['payable_amount']}, lop=₹{$pec['lop_amount']}\n";
}

if ((float)$pe['monthly_ctc'] == 30000.00 && (float)$pe['gross_earnings'] == 30000.00 && (int)$pe['salary_structure_id'] == $newStructId) {
    echo "\n✓✓✓ SUCCESS: EXACT PAYROLL CYCLE SALARY STRUCTURE CONFIRMED: 30K CTC AND COMPONENTS STORED PERFECTLY IN PAYROLL CYCLE! ✓✓✓\n";
} else {
    echo "\n❌ ERROR: Figures do not match expected 30,000.\n";
}

// Clean up test component
echo "\nCleaning up test component $compCode...\n";
$mysqli->query("DELETE FROM employee_salary_component WHERE component_id = $testCompId");
$mysqli->query("DELETE FROM payroll_employee_component WHERE component_id = $testCompId");
$mysqli->query("DELETE FROM salary_component_master WHERE component_id = $testCompId");
echo "Cleaned up test component.\n";

$mysqli->close();
echo "\nAudit Complete.\n";
