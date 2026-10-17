<?php

namespace App\Controllers;

use App\Models\PayrollModel;
use App\Models\AdminModel;
use App\Models\CompanySettingsModel;

class PayrollAdminController extends BaseController
{
    protected $payrollModel;
    protected $settingsModel;

    public function __construct()
    {
        $this->payrollModel  = new PayrollModel();
        $this->settingsModel = new CompanySettingsModel();
    }

    private function checkAuth()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return false;
        }
        $role = $session->get('active_role') ?? $session->get('current_user_cat') ?? $session->get('user_category');
        return in_array(strtoupper((string)$role), ['ADMIN', 'HR', 'SUPERADMIN']);
    }

    private function getAdminId(): string
    {
        return session()->get('emp_id') ?? 'ADMIN';
    }

    /**
     * 1. PAYROLL DASHBOARD
     */
    public function index()
    {
        if (!$this->checkAuth()) {
            return redirect()->to(base_url('/'));
        }

        $settings = $this->settingsModel->getSettings();
        $runs = $this->payrollModel->get_all_runs();

        // Cutoff cycle days from company_settings
        $cycleStartDay = (int)($settings['payroll_cycle_start_day'] ?? 25);
        $cycleEndDay   = (int)($settings['payroll_cycle_end_day'] ?? 24);

        // Fetch attendance summaries map for FY 2026-27
        $attSummaries = $this->payrollModel->get_all_payroll_attendance_summaries();
        $attStatusMap = [];
        foreach ($attSummaries as $as) {
            $key = sprintf('%04d-%02d', (int)$as['payroll_year'], (int)$as['payroll_month']);
            $attStatusMap[$key] = [
                'finalized' => (strtoupper(trim((string)$as['is_finalized'])) === 'Y'),
                'count'     => (int)$as['cnt'],
            ];
        }

        // Map existing runs by YYYY-MM
        $runMap = [];
        foreach ($runs as $r) {
            $key = sprintf('%04d-%02d', (int)$r['payroll_year'], (int)$r['payroll_month']);
            $runMap[$key] = $r;
        }

        // Selected FY (default 2026-27)
        $selectedFY = $this->request->getVar('fy') ?: '2026-27';
        $fyStartYear = (int)substr($selectedFY, 0, 4);
        $fyEndYear   = $fyStartYear + 1;

        $fyMonths = [];
        for ($m = 4; $m <= 12; $m++) {
            $fyMonths[] = ['month' => $m, 'year' => $fyStartYear];
        }
        for ($m = 1; $m <= 3; $m++) {
            $fyMonths[] = ['month' => $m, 'year' => $fyEndYear];
        }

        $fyMatrix = [];
        foreach ($fyMonths as $fm) {
            $m = $fm['month'];
            $y = $fm['year'];
            $key = sprintf('%04d-%02d', $y, $m);

            if ($cycleStartDay > $cycleEndDay) {
                $prevM = ($m == 1) ? 12 : ($m - 1);
                $prevY = ($m == 1) ? ($y - 1) : $y;
                $pStart = sprintf('%04d-%02d-%02d', $prevY, $prevM, $cycleStartDay);
                $pEnd   = sprintf('%04d-%02d-%02d', $y, $m, $cycleEndDay);
            } else {
                $pStart = sprintf('%04d-%02d-%02d', $y, $m, $cycleStartDay);
                $pEnd   = sprintf('%04d-%02d-%02d', $y, $m, $cycleEndDay);
            }

            $att = $attStatusMap[$key] ?? null;
            $run = $runMap[$key] ?? null;

            $fyMatrix[] = [
                'month'         => $m,
                'year'          => $y,
                'month_name'    => date('F', mktime(0, 0, 0, $m, 10)),
                'period_start'  => $pStart,
                'period_end'    => $pEnd,
                'period_label'  => date('d M', strtotime($pStart)) . ' - ' . date('d M Y', strtotime($pEnd)),
                'att_exists'    => !empty($att),
                'att_finalized' => !empty($att['finalized']),
                'staff_count'   => !empty($att['count']) ? $att['count'] : 0,
                'run'           => $run,
            ];
        }

        // Summary Statistics
        $totalActiveEmps = count($this->payrollModel->get_all_employee_structures());
        $finalizedRunsCount = 0;
        $totalDisbursed = 0;
        foreach ($runs as $r) {
            if ($r['payroll_status'] === 'FINALIZED') {
                $finalizedRunsCount++;
                $totalDisbursed += (float)$r['total_net_payout'];
            }
        }

        $data = [
            'title'            => 'Payroll Dashboard',
            'settings'         => $settings,
            'runs'             => $runs,
            'fyMatrix'         => $fyMatrix,
            'selectedFY'       => $selectedFY,
            'totalActiveEmps'  => $totalActiveEmps,
            'finalizedRuns'    => $finalizedRunsCount,
            'totalDisbursed'   => $totalDisbursed,
            'suggestedMonth'   => 9, // September 2026 current default
            'suggestedYear'    => 2026,
            'cycleStartDay'    => $cycleStartDay,
            'cycleEndDay'      => $cycleEndDay,
        ];

        return view('Layouts/Header')
            . view('Layouts/Sidebar')
            . view('admin/payroll/dashboard', $data)
            . view('Layouts/Footer');
    }

    /**
     * 2. CREATE PAYROLL RUN (USES sp_create_payroll_run)
     */
    public function create_run()
    {
        if (!$this->checkAuth()) {
            return redirect()->to(base_url('/'));
        }

        $month    = (int)$this->request->getPost('payroll_month');
        $year     = (int)$this->request->getPost('payroll_year');
        $dayBasis = $this->request->getPost('salary_day_basis') ?: 'FIXED_30';
        $adminId  = $this->getAdminId();

        if ($month < 1 || $month > 12 || $year < 2000) {
            return redirect()->back()->with('error', 'Please select a valid payroll month and year.');
        }

        $monthName = date('F', mktime(0, 0, 0, $month, 10, $year));

        // 1. Verify payroll attendance summary exists and is finalized for this month & year
        $attCheck = $this->payrollModel->check_attendance_finalized($month, $year);
        if (!$attCheck['exists']) {
            return redirect()->back()->with('error', "Cannot create payroll cycle: Attendance summary has NOT been generated for {$monthName} {$year}. Please generate attendance first in the Attendance Finalize module.");
        }

        if (!$attCheck['finalized']) {
            return redirect()->back()->with('error', "Cannot create payroll cycle: Attendance for {$monthName} {$year} is NOT finalized ({$attCheck['count']} staff pending lock). You must finalize and lock attendance in the Attendance Finalize module before creating a payroll cycle.");
        }

        // 2. Attendance is verified and finalized. Proceed with cycle creation.
        // sp_create_payroll_run automatically calculates period_start and period_end using company_settings
        $res = $this->payrollModel->sp_create_payroll_run($month, $year, $dayBasis, $adminId);

        if (!empty($res['run_id'])) {
            $runId = (int)$res['run_id'];

            // 3. Auto-calculate all active employees using locked attendance & approved salary structures
            $calcRes = $this->payrollModel->sp_calculate_monthly_payroll($runId, $adminId);

            // 4. Synchronize legacy tables (payroll_cycles & payroll_employees)
            $this->payrollModel->sync_legacy_payroll_cycle($runId);

            $msg = $res['status'] === 'EXISTING' 
                ? "Payroll run for {$monthName} {$year} already existed. Recalculated {$calcRes['processed']} employees using finalized attendance."
                : "Payroll run created & calculated successfully for {$calcRes['processed']} employees using finalized attendance!";

            return redirect()->to(base_url("admin/payroll/run/{$runId}"))->with('success', $msg);
        }

        return redirect()->back()->with('error', $res['message'] ?? 'Failed to create payroll run.');
    }

    /**
     * 3. PAYROLL RUNS LIST / HISTORY
     */
    public function runs()
    {
        if (!$this->checkAuth()) {
            return redirect()->to(base_url('/'));
        }

        $runs = $this->payrollModel->get_all_runs();
        $settings = $this->settingsModel->getSettings();

        // Fetch attendance summaries map to evaluate finalized status per month
        $attSummaries = $this->payrollModel->get_all_payroll_attendance_summaries();
        $attStatusMap = [];
        foreach ($attSummaries as $as) {
            $key = sprintf('%04d-%02d', (int)$as['payroll_year'], (int)$as['payroll_month']);
            $attStatusMap[$key] = [
                'finalized' => (strtoupper(trim((string)$as['is_finalized'])) === 'Y'),
                'count'     => (int)$as['cnt'],
            ];
        }

        $data = [
            'title'        => 'Payroll Processing & Runs',
            'runs'         => $runs,
            'settings'     => $settings,
            'attStatusMap' => $attStatusMap,
        ];

        return view('Layouts/Header')
            . view('Layouts/Sidebar')
            . view('admin/payroll/runs', $data)
            . view('Layouts/Footer');
    }

    /**
     * 4. PAYROLL RUN WORKBENCH / DETAIL (Deep view of a run with all components)
     */
    public function run_detail(int $runId)
    {
        if (!$this->checkAuth()) {
            return redirect()->to(base_url('/'));
        }

        $run = $this->payrollModel->get_run_by_id($runId);
        if (!$run) {
            return redirect()->to(base_url('admin/payroll/runs'))->with('error', 'Payroll run not found.');
        }

        $search = trim((string)$this->request->getGet('search'));
        $status = trim((string)$this->request->getGet('status'));

        // Load all employees with mapped statutory components, banking info, and LOP deductions
        $employees  = $this->payrollModel->get_run_employees_with_components($runId, $search, $status);
        $validation = $this->payrollModel->sp_validate_payroll_run($runId);
        $settings   = $this->settingsModel->getSettings();

        $data = [
            'title'      => 'Payroll Run #' . $runId . ' — ' . date('F Y', mktime(0, 0, 0, (int)$run['payroll_month'], 10, (int)$run['payroll_year'])),
            'run'        => $run,
            'employees'  => $employees,
            'validation' => $validation,
            'settings'   => $settings,
            'search'     => $search,
            'status'     => $status,
        ];

        return view('Layouts/Header')
            . view('Layouts/Sidebar')
            . view('admin/payroll/run_detail', $data)
            . view('Layouts/Footer');
    }

    /**
     * 5. RECALCULATE RUN (sp_calculate_monthly_payroll)
     */
    public function calculate_run(int $runId)
    {
        if (!$this->checkAuth()) {
            return redirect()->to(base_url('/'));
        }

        $adminId = $this->getAdminId();
        $res = $this->payrollModel->sp_calculate_monthly_payroll($runId, $adminId);

        if ($res['status'] === 'SUCCESS' || $res['status'] === 'PARTIAL') {
            return redirect()->to(base_url("admin/payroll/run/{$runId}"))
                ->with('success', "Payroll calculation completed! Processed: {$res['processed']}, Errors: {$res['errors']}.");
        }

        return redirect()->to(base_url("admin/payroll/run/{$runId}"))
            ->with('error', $res['message'] ?? 'Failed to calculate payroll.');
    }

    /**
     * 6. RECALCULATE SINGLE EMPLOYEE
     */
    public function calculate_employee(int $runId, string $empId)
    {
        if (!$this->checkAuth()) {
            return $this->response->setJSON(['status' => 'ERROR', 'message' => 'Unauthorized']);
        }

        $adminId = $this->getAdminId();
        $res = $this->payrollModel->sp_calculate_employee_payroll($runId, $empId, $adminId);

        return $this->response->setJSON($res);
    }

    /**
     * 7. GET EMPLOYEE RUN COMPONENTS (AJAX Modal)
     */
    public function get_employee_run_components_ajax()
    {
        if (!$this->checkAuth()) {
            return $this->response->setJSON(['status' => 'ERROR', 'message' => 'Unauthorized']);
        }

        $peId = (int)$this->request->getPost('payroll_employee_id');
        if (!$peId) {
            return $this->response->setJSON(['status' => 'ERROR', 'message' => 'Invalid employee reference']);
        }

        $components = $this->payrollModel->get_employee_run_components($peId);
        return $this->response->setJSON(['status' => 'SUCCESS', 'components' => $components]);
    }

    /**
     * 8. VALIDATE RUN (AJAX)
     */
    public function validate_run(int $runId)
    {
        if (!$this->checkAuth()) {
            return $this->response->setJSON(['status' => 'ERROR', 'message' => 'Unauthorized']);
        }

        $report = $this->payrollModel->sp_validate_payroll_run($runId);
        return $this->response->setJSON(['status' => 'SUCCESS', 'report' => $report]);
    }

    /**
     * 9. APPROVE RUN (sp_approve_payroll_run)
     */
    public function approve_run(int $runId)
    {
        if (!$this->checkAuth()) {
            return redirect()->to(base_url('/'));
        }

        $adminId = $this->getAdminId();
        $res = $this->payrollModel->sp_approve_payroll_run($runId, $adminId);

        if ($res['status'] === 'SUCCESS') {
            return redirect()->to(base_url("admin/payroll/run/{$runId}"))
                ->with('success', 'Payroll run approved successfully! Ready for finalization.');
        }

        return redirect()->to(base_url("admin/payroll/run/{$runId}"))
            ->with('error', $res['message'] ?? 'Failed to approve payroll run.');
    }

    /**
     * 10. FINALIZE RUN & GENERATE PAYSLIPS (sp_finalize_payroll_run)
     */
    public function finalize_run(int $runId)
    {
        if (!$this->checkAuth()) {
            return redirect()->to(base_url('/'));
        }

        $adminId = $this->getAdminId();
        $res = $this->payrollModel->sp_finalize_payroll_run($runId, $adminId);

        if ($res['status'] === 'SUCCESS') {
            $this->payrollModel->sync_legacy_payroll_cycle($runId);
            return redirect()->to(base_url("admin/payroll/run/{$runId}"))
                ->with('success', $res['message']);
        }

        return redirect()->to(base_url("admin/payroll/run/{$runId}"))
            ->with('error', $res['message'] ?? 'Failed to finalize payroll run.');
    }

    /**
     * 11. REOPEN RUN (sp_reopen_payroll_run)
     */
    public function reopen_run(int $runId)
    {
        if (!$this->checkAuth()) {
            return redirect()->to(base_url('/'));
        }

        $adminId = $this->getAdminId();
        $reason  = $this->request->getPost('reason') ?: 'Admin request for payroll correction';

        $res = $this->payrollModel->sp_reopen_payroll_run($runId, $adminId, $reason);

        if ($res['status'] === 'SUCCESS') {
            return redirect()->to(base_url("admin/payroll/run/{$runId}"))
                ->with('warning', $res['message']);
        }

        return redirect()->to(base_url("admin/payroll/run/{$runId}"))
            ->with('error', $res['message'] ?? 'Failed to reopen payroll run.');
    }

    /**
     * 12. SALARY COMPONENTS MASTER
     */
    public function components()
    {
        if (!$this->checkAuth()) {
            return redirect()->to(base_url('/'));
        }

        $components = $this->payrollModel->get_salary_component_master();

        $data = [
            'title'      => 'Salary Component Master',
            'components' => $components,
        ];

        return view('Layouts/Header')
            . view('Layouts/Sidebar')
            . view('admin/payroll/components', $data)
            . view('Layouts/Footer');
    }

    public function save_component()
    {
        if (!$this->checkAuth()) {
            return redirect()->to(base_url('/'));
        }

        $id        = $this->request->getPost('component_id');
        $code      = strtoupper(trim((string)$this->request->getPost('component_code')));
        $name      = trim((string)$this->request->getPost('component_name'));
        $type      = $this->request->getPost('component_type');
        $calcType  = $this->request->getPost('calculation_type');
        $pctBase   = $this->request->getPost('percentage_base') ?: 'NONE';
        $pctVal    = $this->request->getPost('percentage_value');
        $defaultAmt= (float)($this->request->getPost('default_monthly_amount') ?: 0);
        $isLop     = (int)($this->request->getPost('is_lop_applicable') ? 1 : 0);
        $isTaxable = (int)($this->request->getPost('is_taxable') ? 1 : 0);
        $isActive  = (int)($this->request->getPost('is_active') ? 1 : 0);

        if (empty($code) || empty($name)) {
            return redirect()->back()->with('error', 'Component code and name are required.');
        }

        $data = [
            'component_code'    => $code,
            'component_name'    => $name,
            'component_type'    => $type,
            'calculation_type'  => $calcType,
            'percentage_base'   => $pctBase,
            'percentage_value'  => ($calcType === 'PERCENTAGE' && is_numeric($pctVal)) ? (float)$pctVal : null,
            'is_lop_applicable' => $isLop,
            'is_taxable'        => $isTaxable,
            'is_active'         => $isActive,
        ];
        if (!empty($id)) {
            $data['component_id'] = (int)$id;
        }

        $savedId = $this->payrollModel->save_salary_component_master($data);

        if (empty($id)) {
            // New component added: automatically add to all active employees in active state!
            $count = $this->payrollModel->add_component_to_all_active_employees($savedId, $defaultAmt);
            $msg = "Salary component '{$name}' created and successfully attached to all {$count} active employees in Active state!";
        } else {
            $count = $this->payrollModel->add_component_to_all_active_employees((int)$id, $defaultAmt);
            $msg = "Salary component '{$name}' updated and synced across all employee structures!";
        }

        return redirect()->to(base_url('admin/payroll/components'))->with('success', $msg);
    }

    public function toggle_component(int $id)
    {
        if (!$this->checkAuth()) {
            return redirect()->to(base_url('/'));
        }

        $this->payrollModel->toggle_salary_component_master($id);
        return redirect()->to(base_url('admin/payroll/components'))->with('success', 'Component status toggled!');
    }

    public function delete_component(int $id)
    {
        if (!$this->checkAuth()) {
            return redirect()->to(base_url('/'));
        }

        try {
            $this->payrollModel->delete_salary_component_master($id);
            return redirect()->to(base_url('admin/payroll/components'))->with('success', 'Component deleted successfully!');
        } catch (\Throwable $e) {
            return redirect()->to(base_url('admin/payroll/components'))->with('error', 'Cannot delete component because it is referenced in employee structures or payroll history.');
        }
    }

    /**
     * 13. EMPLOYEE SALARY STRUCTURES DIRECTORY
     */
    public function structures()
    {
        if (!$this->checkAuth()) {
            return redirect()->to(base_url('/'));
        }

        $structures = $this->payrollModel->get_all_employee_structures();
        $masterComponents = $this->payrollModel->get_salary_component_master();

        $data = [
            'title'            => 'Employee Salary Structures',
            'structures'       => $structures,
            'masterComponents' => $masterComponents,
        ];

        return view('Layouts/Header')
            . view('Layouts/Sidebar')
            . view('admin/payroll/structures', $data)
            . view('Layouts/Footer');
    }

    public function get_structure(string $empId)
    {
        if (!$this->checkAuth()) {
            return $this->response->setJSON(['status' => 'ERROR', 'message' => 'Unauthorized']);
        }

        $data = $this->payrollModel->get_employee_structure_full($empId);
        $masterComps = $this->payrollModel->get_salary_component_master();

        return $this->response->setJSON([
            'status'     => 'SUCCESS',
            'data'       => $data,
            'master'     => $masterComps,
        ]);
    }

    public function save_structure()
    {
        if (!$this->checkAuth()) {
            return redirect()->to(base_url('/'));
        }

        $empId         = trim((string)$this->request->getPost('emp_id'));
        $monthlyCtc    = (float)$this->request->getPost('monthly_ctc');
        $effectiveFrom = $this->request->getPost('effective_from') ?: date('Y-m-01');
        $components    = $this->request->getPost('components') ?: [];
        $adminId       = $this->getAdminId();

        if (empty($empId) || $monthlyCtc <= 0) {
            return redirect()->back()->with('error', 'Invalid employee or monthly CTC amount.');
        }

        $this->payrollModel->save_employee_structure_full($empId, $monthlyCtc, $components, $effectiveFrom, $adminId);

        $formattedCtc = number_format($monthlyCtc, 2);
        return redirect()->to(base_url('admin/payroll/structures'))->with('success', "Salary structure revision saved and approved for {$empId}! Monthly CTC updated to ₹{$formattedCtc}. Active payroll cycle synchronized.");
    }

    /**
     * 14. PAYSLIP MANAGEMENT CENTER
     */
    public function payslips()
    {
        if (!$this->checkAuth()) {
            return redirect()->to(base_url('/'));
        }

        $month  = (int)($this->request->getGet('month') ?: 0);
        $year   = (int)($this->request->getGet('year') ?: 0);
        $runId  = (int)($this->request->getGet('run_id') ?: 0);
        $search = trim((string)$this->request->getGet('search'));

        $payslips = $this->payrollModel->get_all_payslips(
            $runId ?: null,
            $month ?: null,
            $year ?: null,
            $search
        );
        $runs = $this->payrollModel->get_all_runs();

        $data = [
            'title'    => 'Payslip Management Center',
            'payslips' => $payslips,
            'runs'     => $runs,
            'month'    => $month,
            'year'     => $year,
            'runId'    => $runId,
            'search'   => $search,
        ];

        return view('Layouts/Header')
            . view('Layouts/Sidebar')
            . view('admin/payroll/payslips', $data)
            . view('Layouts/Footer');
    }

    /**
     * 15. DIGITAL & PRINTABLE PAYSLIP VIEW
     */
    public function view_payslip(int $runId, string $empId)
    {
        if (!$this->checkAuth()) {
            return redirect()->to(base_url('/'));
        }

        $payslipData = $this->payrollModel->sp_get_employee_payslip($runId, $empId);
        if (!$payslipData || empty($payslipData['header'])) {
            return redirect()->to(base_url('admin/payroll/payslips'))->with('error', 'Payslip not found for this employee and period.');
        }

        $netSalary = (float)$payslipData['header']['net_salary'];
        $netWords = $this->numberToWordsIndian($netSalary);

        $data = [
            'title'    => 'Payslip — ' . $payslipData['header']['payslip_number'],
            'payslip'  => $payslipData,
            'netWords' => $netWords,
        ];

        return view('Layouts/Header')
            . view('Layouts/Sidebar')
            . view('admin/payroll/payslip_view', $data)
            . view('Layouts/Footer');
    }

    /**
     * 16. REPORTS & BANK RECONCILIATION
     */
    public function reports()
    {
        if (!$this->checkAuth()) {
            return redirect()->to(base_url('/'));
        }

        $runs = $this->payrollModel->get_all_runs();
        $selectedRunId = (int)($this->request->getGet('run_id') ?: ($runs[0]['payroll_run_id'] ?? 0));

        $activeRun = null;
        $employees = [];
        if ($selectedRunId) {
            $activeRun = $this->payrollModel->get_run_by_id($selectedRunId);
            $employees = $this->payrollModel->get_run_employees($selectedRunId);
        }

        $data = [
            'title'         => 'Payroll Reports & Bank Transfer',
            'runs'          => $runs,
            'selectedRunId' => $selectedRunId,
            'activeRun'     => $activeRun,
            'employees'     => $employees,
        ];

        return view('Layouts/Header')
            . view('Layouts/Sidebar')
            . view('admin/payroll/reports', $data)
            . view('Layouts/Footer');
    }

    /**
     * 17. EXPORT BANK TRANSFER CSV (NEFT / RTGS)
     */
    public function export_bank_csv(int $runId)
    {
        if (!$this->checkAuth()) {
            return redirect()->to(base_url('/'));
        }

        $run = $this->payrollModel->get_run_by_id($runId);
        if (!$run) {
            return redirect()->back()->with('error', 'Run not found.');
        }

        $employees = $this->payrollModel->get_run_employees($runId);
        $monthName = date('F_Y', strtotime($run['period_end']));
        $filename  = "Bank_Transfer_Export_{$monthName}.csv";

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        $out = fopen('php://output', 'w');
        fputs($out, "\xEF\xBB\xBF"); // UTF-8 BOM

        fputcsv($out, ['Emp ID', 'Beneficiary Name', 'Bank Name', 'Account Number', 'IFSC Code', 'Amount (INR)', 'Remarks']);

        foreach ($employees as $e) {
            fputcsv($out, [
                $e['emp_id'],
                $e['emp_name'],
                $e['bank_name'] ?: 'N/A',
                $e['bank_account_no'] ?: 'N/A',
                $e['ifsc'] ?: 'N/A',
                number_format((float)$e['net_salary'], 2, '.', ''),
                "Salary " . date('M Y', strtotime($run['period_end']))
            ]);
        }

        fclose($out);
        exit;
    }

    /**
     * 18. EXPORT 35-COLUMN MASTER PAYROLL REGISTER CSV
     */
    public function export_register_csv(int $runId)
    {
        if (!$this->checkAuth()) {
            return redirect()->to(base_url('/'));
        }

        $run = $this->payrollModel->get_run_by_id($runId);
        if (!$run) {
            return redirect()->back()->with('error', 'Run not found.');
        }

        $employees = $this->payrollModel->get_run_employees_with_components($runId);
        $monthName = date('F_Y', mktime(0, 0, 0, (int)$run['payroll_month'], 10, (int)$run['payroll_year']));
        $filename  = "Payroll_Register_{$monthName}.csv";

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Pragma: no-cache');
        header('Expires: 0');

        $out = fopen('php://output', 'w');
        // UTF-8 BOM so Microsoft Excel opens cleanly with proper encoding
        fputs($out, "\xEF\xBB\xBF");

        // Exactly the reference columns requested by the user
        $headers = [
            'Employee ID',
            'Name',
            'Salary',
            'Leaves',
            'Working days',
            'Leave salary deduction',
            'Other Earnings',
            'CTC1',
            'Gross',
            'Basic @ 50%',
            'HRA @ 20%',
            'Medical @ 5%',
            'Conveyance @ 8%',
            'Others @ 17%',
            'Employer NPS contribution',
            'PF Employer Contribution',
            'Admin Charges',
            'ESI Employer Contribution',
            'PT',
            'PF Employee Contribution',
            'ESI Employee Contribution',
            'Advances/ Other Deductions',
            'TDS',
            'Total Deductions',
            'Net Pay',
            'Bank A/c No',
            'BANK NAME',
            'IFSC',
            'Mobile No',
        ];
        fputcsv($out, $headers);

        foreach ($employees as $e) {
            fputcsv($out, [
                $e['emp_id'],
                $e['emp_name'],
                number_format((float)$e['salary'], 2, '.', ''),
                number_format((float)$e['leaves'], 1, '.', ''),
                $e['working_days'],
                number_format((float)$e['leave_deduction'], 2, '.', ''),
                number_format((float)$e['other_earnings'], 2, '.', ''),
                number_format((float)$e['ctc1'], 2, '.', ''),
                number_format((float)$e['gross_earnings'], 2, '.', ''),
                number_format((float)$e['basic'], 2, '.', ''),
                number_format((float)$e['hra'], 2, '.', ''),
                number_format((float)$e['medical'], 2, '.', ''),
                number_format((float)$e['conveyance'], 2, '.', ''),
                number_format((float)$e['others'], 2, '.', ''),
                number_format((float)$e['employer_nps'], 2, '.', ''),
                number_format((float)$e['pf_employer_contribution'], 2, '.', ''),
                number_format((float)$e['admin_charges'], 2, '.', ''),
                number_format((float)$e['esi_employer_contribution'], 2, '.', ''),
                number_format((float)$e['pt'], 2, '.', ''),
                number_format((float)$e['pf_employee_contribution'], 2, '.', ''),
                number_format((float)$e['esi_employee_contribution'], 2, '.', ''),
                number_format((float)$e['advances_deduction'], 2, '.', ''),
                number_format((float)$e['tds'], 2, '.', ''),
                number_format((float)$e['total_deductions'], 2, '.', ''),
                number_format((float)$e['net_pay'], 2, '.', ''),
                "'" . ($e['bank_account_no'] ?? ''),
                $e['bank_name'] ?? '',
                $e['ifsc'] ?? '',
                $e['mobile'] ?? '',
            ]);
        }

        fclose($out);
        exit;
    }

    /**
     * Helper: Number to Indian currency words
     */
    private function numberToWordsIndian(float $amount): string
    {
        $amount = round($amount, 2);
        $rupees = (int)floor($amount);
        $paise  = (int)round(($amount - $rupees) * 100);

        if ($rupees === 0 && $paise === 0) {
            return "Zero Rupees Only";
        }

        $ones = [
            0 => '', 1 => 'One', 2 => 'Two', 3 => 'Three', 4 => 'Four', 5 => 'Five',
            6 => 'Six', 7 => 'Seven', 8 => 'Eight', 9 => 'Nine', 10 => 'Ten',
            11 => 'Eleven', 12 => 'Twelve', 13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
            16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen', 19 => 'Nineteen'
        ];
        $tens = [
            2 => 'Twenty', 3 => 'Thirty', 4 => 'Forty', 5 => 'Fifty',
            6 => 'Sixty', 7 => 'Seventy', 8 => 'Eighty', 9 => 'Ninety'
        ];

        $convertGroup = function($n) use ($ones, $tens) {
            $str = '';
            if ($n >= 100) {
                $str .= $ones[(int)floor($n / 100)] . ' Hundred ';
                $n %= 100;
            }
            if ($n >= 20) {
                $str .= $tens[(int)floor($n / 10)] . ' ';
                $n %= 10;
            }
            if ($n > 0) {
                $str .= $ones[$n] . ' ';
            }
            return trim($str);
        };

        $parts = [];
        // Crores (>= 10,000,000)
        if ($rupees >= 10000000) {
            $crores = (int)floor($rupees / 10000000);
            $parts[] = $convertGroup($crores) . ' Crore';
            $rupees %= 10000000;
        }
        // Lakhs (>= 100,000)
        if ($rupees >= 100000) {
            $lakhs = (int)floor($rupees / 100000);
            $parts[] = $convertGroup($lakhs) . ' Lakh';
            $rupees %= 100000;
        }
        // Thousands (>= 1,000)
        if ($rupees >= 1000) {
            $thousands = (int)floor($rupees / 1000);
            $parts[] = $convertGroup($thousands) . ' Thousand';
            $rupees %= 1000;
        }
        // Hundreds & remaining
        if ($rupees > 0) {
            $parts[] = $convertGroup($rupees);
        }

        $result = implode(' ', $parts) . ' Rupees';
        if ($paise > 0) {
            $result .= ' and ' . $convertGroup($paise) . ' Paise';
        }
        return trim($result) . ' Only';
    }
}
