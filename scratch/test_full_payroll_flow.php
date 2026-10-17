<?php
$mysqli = new mysqli("localhost", "root", "vamsi123", "hrmsdevtest");

echo "=== 1. TEST ATTENDANCE FINALIZATION CHECKS ===\n";
function checkAtt($mysqli, $m, $y) {
    $res = $mysqli->query("CALL sp_check_attendance_finalized($m, $y)");
    $row = $res->fetch_assoc();
    $mysqli->next_result();
    return [
        'count' => (int)($row['cnt'] ?? 0),
        'finalized' => ((int)($row['is_finalized'] ?? 0) === 1)
    ];
}

$attOct = checkAtt($mysqli, 10, 2026);
echo "Oct 2026: cnt={$attOct['count']}, finalized=" . ($attOct['finalized'] ? 'YES' : 'NO') . "\n";

$attMar = checkAtt($mysqli, 3, 2026);
echo "Mar 2026: cnt={$attMar['count']}, finalized=" . ($attMar['finalized'] ? 'YES' : 'NO') . "\n";

$attNov = checkAtt($mysqli, 11, 2026);
echo "Nov 2026: cnt={$attNov['count']}, finalized=" . ($attNov['finalized'] ? 'YES' : 'NO') . "\n";

echo "\n=== 2. CREATE PAYROLL RUN FOR OCT 2026 (FINALIZED) ===\n";
// Let's create run for Oct 2026
$mysqli->query("CALL sp_create_payroll_run(10, 2026, 'FIXED_30', 'ADMIN', @p_run_id, @p_status, @p_message)");
$resRun = $mysqli->query("SELECT @p_run_id as run_id, @p_status as status, @p_message as msg");
$runInfo = $resRun->fetch_assoc();
print_r($runInfo);
$runId = (int)$runInfo['run_id'];

echo "\n=== 3. CALCULATE PAYROLL RUN ===\n";
$mysqli->query("CALL sp_calculate_monthly_payroll({$runId}, 'ADMIN', @p_processed, @p_errors, @p_status, @p_message)");
$resCalc = $mysqli->query("SELECT @p_processed as processed, @p_errors as errors, @p_status as status, @p_message as msg");
print_r($resCalc->fetch_assoc());

echo "\n=== 4. TEST 29 REFERENCE COLUMNS FOR RUN {$runId} ===\n";
$sql = "SELECT 
            pe.*, 
            ud.emp_name, 
            ud.bank_account_no, 
            ud.bank_name, 
            ud.ifsc, 
            ud.mobile
        FROM payroll_employee pe
        LEFT JOIN user_details ud ON pe.emp_id = ud.emp_id
        WHERE pe.payroll_run_id = {$runId}
        ORDER BY pe.emp_id ASC LIMIT 2";
$resPe = $mysqli->query($sql);

$compSql = "SELECT pec.* 
            FROM payroll_employee_component pec
            JOIN payroll_employee pe ON pec.payroll_employee_id = pe.payroll_employee_id
            WHERE pe.payroll_run_id = {$runId}";
$resComp = $mysqli->query($compSql);
$compMap = [];
while ($c = $resComp->fetch_assoc()) {
    $compMap[$c['payroll_employee_id']][$c['component_code']] = $c;
}

while ($e = $resPe->fetch_assoc()) {
    $peId = $e['payroll_employee_id'];
    $comps = $compMap[$peId] ?? [];
    echo "--------------------------------------------------------\n";
    echo "Employee ID:               " . $e['emp_id'] . "\n";
    echo "Name:                      " . $e['emp_name'] . "\n";
    echo "Salary:                    " . $e['monthly_ctc'] . "\n";
    echo "Leaves:                    " . $e['lop_days'] . "\n";
    echo "Working days:              " . $e['working_days'] . "\n";
    echo "Leave salary deduction:    " . $e['lop_deduction'] . "\n";
    echo "Other Earnings:            0.00\n";
    echo "CTC1:                      " . $e['monthly_ctc'] . "\n";
    echo "Gross:                     " . $e['gross_earnings'] . "\n";
    echo "Basic @ 50%:               " . ($comps['BASIC']['payable_amount'] ?? 0) . "\n";
    echo "HRA @ 20%:                 " . ($comps['HRA']['payable_amount'] ?? 0) . "\n";
    echo "Medical @ 5%:              " . ($comps['MEDICAL']['payable_amount'] ?? 0) . "\n";
    echo "Conveyance @ 8%:           " . ($comps['CONVEYANCE']['payable_amount'] ?? 0) . "\n";
    echo "Others @ 17%:              " . ($comps['SPECIAL_ALLOWANCE']['payable_amount'] ?? 0) . "\n";
    echo "Employer NPS contribution: " . ($comps['NPS']['payable_amount'] ?? 0) . "\n";
    echo "PF Employer Contribution:  " . ($comps['PF_EMPLOYER']['payable_amount'] ?? 0) . "\n";
    echo "Admin Charges:             75.00\n";
    echo "ESI Employer Contribution: " . ($comps['ESI_EMPLOYER']['payable_amount'] ?? 0) . "\n";
    echo "PT:                        " . ($comps['PROF_TAX']['payable_amount'] ?? 200.00) . "\n";
    echo "PF Employee Contribution:  " . ($comps['PF_EMPLOYEE']['payable_amount'] ?? 0) . "\n";
    echo "ESI Employee Contribution: " . ($comps['ESI_EMPLOYEE']['payable_amount'] ?? 0) . "\n";
    echo "Advances/ Other Deductions:0.00\n";
    echo "TDS:                       0.00\n";
    echo "Total Deductions:          " . $e['other_deductions'] . "\n";
    echo "Net Pay:                   " . $e['net_salary'] . "\n";
    echo "Bank A/c No:               " . $e['bank_account_no'] . "\n";
    echo "BANK NAME:                 " . $e['bank_name'] . "\n";
    echo "IFSC:                      " . $e['ifsc'] . "\n";
    echo "Mobile No:                 " . $e['mobile'] . "\n";
}

echo "\n=== 5. TEST FINALIZE RUN {$runId} ===\n";
$mysqli->query("CALL sp_finalize_payroll_run({$runId}, 'ADMIN', @p_status, @p_message)");
$resFin = $mysqli->query("SELECT @p_status as status, @p_message as msg");
print_r($resFin->fetch_assoc());

$resRunAfter = $mysqli->query("SELECT payroll_run_id, payroll_status, employee_count, finalized_by, finalized_at FROM payroll_run WHERE payroll_run_id = {$runId}");
print_r($resRunAfter->fetch_assoc());
