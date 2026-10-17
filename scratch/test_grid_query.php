<?php
$mysqli = new mysqli("localhost", "root", "vamsi123", "hrmsdevtest");

$runId = 1;
// Fetch employees with user_details and their components
$sql = "SELECT 
            pe.*, 
            ud.emp_name,
            ud.bank_account_no, 
            ud.bank_name, 
            ud.ifsc, 
            ud.mobile,
            dm.department_name,
            dsm.designation_name
        FROM payroll_employee pe
        LEFT JOIN user_details ud ON pe.emp_id = ud.emp_id
        LEFT JOIN department_master dm ON ud.department = dm.department_id
        LEFT JOIN designation_master dsm ON ud.designation = dsm.designation_id
        WHERE pe.payroll_run_id = {$runId}
        ORDER BY pe.emp_id ASC";

$res = $mysqli->query($sql);
echo "Total employees in run {$runId}: " . $res->num_rows . "\n";

// Fetch all components for this run indexed by payroll_employee_id and component_code
$compSql = "SELECT pec.* 
            FROM payroll_employee_component pec
            JOIN payroll_employee pe ON pec.payroll_employee_id = pe.payroll_employee_id
            WHERE pe.payroll_run_id = {$runId}";
$resComp = $mysqli->query($compSql);
$compMap = [];
while ($c = $resComp->fetch_assoc()) {
    $compMap[$c['payroll_employee_id']][$c['component_code']] = $c;
}
echo "Total component records in run {$runId}: " . $resComp->num_rows . "\n";

// Print first employee mapped columns
$e = $res->fetch_assoc();
$c = $compMap[$e['payroll_employee_id']] ?? [];

$basic = $c['BASIC']['payable_amount'] ?? 0;
$hra   = $c['HRA']['payable_amount'] ?? 0;
$med   = $c['MEDICAL']['payable_amount'] ?? 0;
$conv  = $c['CONVEYANCE']['payable_amount'] ?? 0;
$others= $c['SPECIAL_ALLOWANCE']['payable_amount'] ?? 0;
$nps   = $c['NPS']['payable_amount'] ?? 0;
$pfEmplr = $c['PF_EMPLOYER']['payable_amount'] ?? 0;
$adminChg = $c['ADMIN_CHARGES']['payable_amount'] ?? 75.00;
$esiEmplr = $c['ESI_EMPLOYER']['payable_amount'] ?? 0;
$pt = $c['PROF_TAX']['payable_amount'] ?? 200.00;
$pfEmp = $c['PF_EMPLOYEE']['payable_amount'] ?? 0;
$esiEmp = $c['ESI_EMPLOYEE']['payable_amount'] ?? 0;
$advances = $c['ADVANCES']['payable_amount'] ?? 0;
$tds = $c['TDS']['payable_amount'] ?? 0;

echo "\nSample Mapped Output for {$e['emp_id']}:\n";
echo "Employee ID: {$e['emp_id']}\n";
echo "Name: {$e['emp_name']}\n";
echo "Salary: {$e['monthly_ctc']}\n";
echo "Leaves: {$e['lop_days']}\n";
echo "Working days: 30\n";
echo "Leave salary deduction: {$e['lop_deduction']}\n";
echo "Other Earnings: 0.00\n";
echo "CTC1: {$e['monthly_ctc']}\n";
echo "Gross: {$e['gross_earnings']}\n";
echo "Basic @ 50%: {$basic}\n";
echo "HRA @ 20%: {$hra}\n";
echo "Medical @ 5%: {$med}\n";
echo "Conveyance @ 8%: {$conv}\n";
echo "Others @ 17%: {$others}\n";
echo "Employer NPS contribution: {$nps}\n";
echo "PF Employer Contribution: {$pfEmplr}\n";
echo "Admin Charges: {$adminChg}\n";
echo "ESI Employer Contribution: {$esiEmplr}\n";
echo "PT: {$pt}\n";
echo "PF Employee Contribution: {$pfEmp}\n";
echo "ESI Employee Contribution: {$esiEmp}\n";
echo "Advances/ Other Deductions: {$advances}\n";
echo "TDS: {$tds}\n";
echo "Total Deductions: {$e['other_deductions']}\n";
echo "Net Pay: {$e['net_salary']}\n";
echo "Bank A/c No: {$e['bank_account_no']}\n";
echo "BANK NAME: {$e['bank_name']}\n";
echo "IFSC: {$e['ifsc']}\n";
echo "Mobile No: {$e['mobile']}\n";
