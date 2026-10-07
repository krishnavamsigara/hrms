<?php

namespace App\Controllers;

use App\Models\PayrollModel;
use App\Models\AdminModel;

class PayrollAdminController extends BaseController
{
    protected $payrollModel;

    public function __construct()
    {
        $this->payrollModel = new PayrollModel();
    }

    private function checkAuth()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return false;
        }
        $role = $session->get('active_role') ?? $session->get('user_category');
        return in_array(strtoupper($role), ['ADMIN', 'HR', 'SUPERADMIN']);
    }

    public function index()
    {
        if (!$this->checkAuth()) {
            return redirect()->to(base_url('/'));
        }

        $data['cycles'] = $this->payrollModel->get_all_cycles();

        return view('Layouts/Header')
            . view('Layouts/Sidebar')
            . view('admin/payroll/dashboard', $data)
            . view('Layouts/Footer');
    }

    public function create_cycle()
    {
        if (!$this->checkAuth()) {
            return redirect()->to(base_url('/'));
        }

        $payroll_code = $this->request->getPost('payroll_code');
        $period_start = $this->request->getPost('period_start');
        $period_end   = $this->request->getPost('period_end');
        $pay_date     = $this->request->getPost('pay_date');

        if (empty($payroll_code) || empty($period_start) || empty($period_end)) {
            return redirect()->back()->with('error', 'Please fill all required cycle fields.');
        }

        $session = session();
        $actor   = $session->get('emp_id') ?? 'ADMIN';

        $cycle_id = $this->payrollModel->create_payroll_cycle([
            'payroll_code' => $payroll_code,
            'period_start' => $period_start,
            'period_end'   => $period_end,
            'pay_date'     => $pay_date,
            'created_by'   => $actor,
        ]);

        // Auto-populate live attendance snapshot for all active employees from user_login_details
        $this->payrollModel->populate_attendance_snapshot($cycle_id);

        // Auto-run initial payroll calculation
        $this->payrollModel->calculate_payroll_cycle($cycle_id, $actor);

        return redirect()->to(base_url('admin/payroll/view/' . $cycle_id))->with('success', 'Payroll cycle created & draft calculated successfully for active employees!');
    }

    public function view_cycle($cycle_id)
    {
        if (!$this->checkAuth()) {
            return redirect()->to(base_url('/'));
        }

        $data['cycle'] = $this->payrollModel->get_cycle_by_id($cycle_id);
        if (!$data['cycle']) {
            return redirect()->to(base_url('admin/payroll'))->with('error', 'Payroll cycle not found.');
        }

        $db = \Config\Database::connect();
        $data['employees'] = $db->table('payroll_employees pe')
            ->select('pe.*, dm.department_name as department, dsm.designation_name as designation')
            ->join('user_details ud', 'ud.emp_id = pe.emp_id', 'left')
            ->join('department_master dm', 'dm.department_id = ud.department', 'left')
            ->join('designation_master dsm', 'dsm.designation_id = ud.designation', 'left')
            ->where('pe.payroll_cycle_id', $cycle_id)
            ->get()->getResultArray();

        $data['adjustments']        = $this->payrollModel->get_payroll_adjustments($cycle_id);
        $data['components']         = $this->payrollModel->get_salary_components();
        $data['attendance_matrix']  = $this->payrollModel->get_cycle_attendance_matrix($cycle_id);

        return view('Layouts/Header')
            . view('Layouts/Sidebar')
            . view('admin/payroll/view_cycle', $data)
            . view('Layouts/Footer');
    }

    public function import_attendance($cycle_id)
    {
        if (!$this->checkAuth()) {
            return redirect()->to(base_url('/'));
        }

        $cycle = $this->payrollModel->get_cycle_by_id($cycle_id);
        if (!$cycle) {
            return redirect()->to(base_url('admin/payroll'))->with('error', 'Payroll cycle not found.');
        }

        $file = $this->request->getFile('excel_file');

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $filePath = $file->getTempName();

            $attendance_rows = [];
            $handle = fopen($filePath, "r");
            if ($handle !== FALSE) {
                $header = fgetcsv($handle, 2000, ",");
                while (($row = fgetcsv($handle, 2000, ",")) !== FALSE) {
                    if (count($row) >= 3) {
                        $attendance_rows[] = [
                            'emp_id'          => trim($row[0]),
                            'attendance_date' => trim($row[1]),
                            'status'          => trim($row[2]),
                            'worked_hours'    => isset($row[3]) ? trim($row[3]) : 8.0,
                        ];
                    }
                }
                fclose($handle);
            }

            if (!empty($attendance_rows)) {
                $this->payrollModel->import_excel_attendance($cycle_id, $attendance_rows);
                return redirect()->to(base_url('admin/payroll/view/' . $cycle_id))
                    ->with('success', count($attendance_rows) . ' attendance records imported successfully!');
            }
        }

        // Fallback: Populate attendance snapshot automatically from user_details
        $db = \Config\Database::connect();
        $users = $db->table('user_details')->select('emp_id')->get()->getResultArray();

        $period_start = new \DateTime($cycle['period_start']);
        $period_end   = new \DateTime($cycle['period_end']);
        $period_end->modify('+1 day');
        $daterange = new \DatePeriod($period_start, new \DateInterval('P1D'), $period_end);

        $attendance_rows = [];
        foreach ($users as $u) {
            foreach ($daterange as $date) {
                $dt = $date->format('Y-m-d');
                $attendance_rows[] = [
                    'emp_id'          => $u['emp_id'],
                    'attendance_date' => $dt,
                    'status'          => 'P',
                    'worked_hours'    => 8.0,
                ];
            }
        }

        $this->payrollModel->import_excel_attendance($cycle_id, $attendance_rows);

        return redirect()->to(base_url('admin/payroll/view/' . $cycle_id))
            ->with('success', 'Attendance snapshot automatically generated from user directory!');
    }

    public function calculate_cycle($cycle_id)
    {
        if (!$this->checkAuth()) {
            return redirect()->to(base_url('/'));
        }

        $session = session();
        $actor = $session->get('emp_id') ?? 'HR_ADMIN';

        $success = $this->payrollModel->calculate_payroll_cycle($cycle_id, $actor);
        if ($success) {
            return redirect()->to(base_url('admin/payroll/view/' . $cycle_id))
                ->with('success', 'Payroll calculation completed successfully!');
        }

        return redirect()->to(base_url('admin/payroll/view/' . $cycle_id))
            ->with('error', 'Failed to calculate payroll.');
    }

    public function add_adjustment()
    {
        if (!$this->checkAuth()) {
            return redirect()->to(base_url('/'));
        }

        $cycle_id = $this->request->getPost('payroll_cycle_id');
        $emp_id   = $this->request->getPost('emp_id');
        $comp_id  = $this->request->getPost('component_id');
        $type     = $this->request->getPost('adjustment_type');
        $amount   = (float)$this->request->getPost('amount');
        $reason   = $this->request->getPost('reason');

        if (empty($cycle_id) || empty($emp_id) || empty($amount) || empty($reason)) {
            return redirect()->back()->with('error', 'Missing required fields for HR adjustment.');
        }

        $session = session();
        $this->payrollModel->add_payroll_adjustment([
            'payroll_cycle_id' => $cycle_id,
            'emp_id'           => $emp_id,
            'component_id'     => $comp_id ?: null,
            'adjustment_type'  => $type,
            'amount'           => $amount,
            'reason'           => $reason,
            'created_by'       => $session->get('emp_id') ?? 'HR_ADMIN',
        ]);

        $this->payrollModel->calculate_payroll_cycle($cycle_id, $session->get('emp_id') ?? 'HR_ADMIN');

        return redirect()->to(base_url('admin/payroll/view/' . $cycle_id))
            ->with('success', 'HR adjustment saved and payroll recalculated!');
    }

    public function update_status()
    {
        if (!$this->checkAuth()) {
            return redirect()->to(base_url('/'));
        }

        $cycle_id = $this->request->getPost('payroll_cycle_id');
        $status   = $this->request->getPost('status');

        if (empty($cycle_id) || empty($status)) {
            return redirect()->back()->with('error', 'Invalid status update parameters.');
        }

        $session = session();
        $actor   = $session->get('emp_id') ?? 'HR_ADMIN';

        $this->payrollModel->update_cycle_status($cycle_id, $status, $actor);

        $msg = 'Payroll status updated to ' . $status;
        if ($status == 'LOCKED') {
            $msg = 'Payroll cycle locked successfully! Payslips & salary records are now permanently frozen.';
        }

        return redirect()->to(base_url('admin/payroll/view/' . $cycle_id))->with('success', $msg);
    }

    public function save_employee_draft()
    {
        if (!$this->checkAuth()) {
            return redirect()->to(base_url('/'));
        }

        $cycle_id     = $this->request->getPost('payroll_cycle_id');
        $emp_id       = $this->request->getPost('emp_id');
        $present_days = $this->request->getPost('present_days');
        $lop_days     = $this->request->getPost('lop_days');
        $adj_earning  = $this->request->getPost('manual_earnings_adj');
        $adj_deduct   = $this->request->getPost('manual_deductions_adj');
        $reason       = $this->request->getPost('reason') ?: 'HR Draft Adjustment';

        if (empty($cycle_id) || empty($emp_id)) {
            return redirect()->back()->with('error', 'Invalid parameters for employee draft update.');
        }

        $this->payrollModel->save_employee_payroll_draft([
            'payroll_cycle_id'      => $cycle_id,
            'emp_id'                => $emp_id,
            'present_days'          => $present_days,
            'lop_days'              => $lop_days,
            'manual_earnings_adj'   => $adj_earning,
            'manual_deductions_adj' => $adj_deduct,
            'reason'                => $reason,
        ]);

        return redirect()->to(base_url('admin/payroll/view/' . $cycle_id))
            ->with('success', "Draft salary & LOP updated successfully for Employee {$emp_id}!");
    }

    public function employee_detail($cycle_id, $emp_id)
    {
        if (!$this->checkAuth()) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Unauthorized']);
        }

        $db = \Config\Database::connect();
        $emp_payroll = $db->table('payroll_employees')
            ->where('payroll_cycle_id', $cycle_id)
            ->where('emp_id', $emp_id)
            ->get()->getRowArray();

        $adjustments = $this->payrollModel->get_payroll_adjustments($cycle_id, $emp_id);
        $histories   = $db->table('payroll_calculation_histories')
            ->where('payroll_cycle_id', $cycle_id)
            ->where('emp_id', $emp_id)
            ->orderBy('id', 'DESC')
            ->get()->getResultArray();

        $attendances = $db->table('payroll_attendances')
            ->where('payroll_cycle_id', $cycle_id)
            ->where('emp_id', $emp_id)
            ->orderBy('attendance_date', 'ASC')
            ->get()->getResultArray();

        return $this->response->setJSON([
            'status'      => 'success',
            'payroll'     => $emp_payroll,
            'adjustments' => $adjustments,
            'histories'   => $histories,
            'attendances' => $attendances,
        ]);
    }

    public function components()
    {
        if (!$this->checkAuth()) {
            return redirect()->to(base_url('/'));
        }

        if (strtolower($this->request->getMethod()) === 'post' || !empty($this->request->getPost('component_code'))) {
            return $this->save_component();
        }

        $data['components'] = $this->payrollModel->get_salary_components();

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

        $id    = $this->request->getPost('id');
        $code  = strtoupper(trim($this->request->getPost('component_code')));
        $name  = trim($this->request->getPost('component_name'));
        $type  = $this->request->getPost('component_type');
        $calc  = $this->request->getPost('calculation_type');
        $val   = (float)($this->request->getPost('value') ?? 0);
        $base  = $this->request->getPost('based_on');
        $stat  = (int)($this->request->getPost('is_statutory') ?? 0);
        $emp   = (int)($this->request->getPost('is_employer_contribution') ?? 0);
        $order = (int)($this->request->getPost('display_order') ?? 1);

        if (empty($code) || empty($name)) {
            return redirect()->to(base_url('admin/payroll/components'))->with('error', 'Component code and name are required.');
        }

        $this->payrollModel->save_salary_component([
            'id'                       => $id ?: null,
            'component_code'           => $code,
            'component_name'           => $name,
            'component_type'           => $type,
            'calculation_type'         => $calc,
            'value'                    => $val,
            'based_on'                 => $base,
            'is_statutory'             => $stat,
            'is_employer_contribution' => $emp,
            'display_order'            => $order,
        ]);

        return redirect()->to(base_url('admin/payroll/components'))->with('success', 'Salary component saved successfully!');
    }

    public function delete_component($id)
    {
        if (!$this->checkAuth()) {
            return redirect()->to(base_url('/'));
        }

        $this->payrollModel->delete_salary_component($id);
        return redirect()->to(base_url('admin/payroll/components'))->with('success', 'Salary component deleted successfully!');
    }

    public function toggle_component($id)
    {
        if (!$this->checkAuth()) {
            return redirect()->to(base_url('/'));
        }

        $this->payrollModel->toggle_salary_component($id);
        return redirect()->to(base_url('admin/payroll/components'))->with('success', 'Salary component status toggled!');
    }

    public function structures()
    {
        if (!$this->checkAuth()) {
            return redirect()->to(base_url('/'));
        }

        $db = \Config\Database::connect();
        $data['employees'] = $db->table('user_details ud')
            ->select('ud.emp_id, ud.emp_name, dm.department_name as department')
            ->join('department_master dm', 'dm.department_id = ud.department', 'left')
            ->get()->getResultArray();

        foreach ($data['employees'] as &$e) {
            $sal = $db->table('employee_salary')
                ->where('EMP_ID', $e['emp_id'])
                ->orderBy('id', 'DESC')
                ->get()->getRowArray();

            $structRow = $db->table('emp_salary_structures')
                ->where('emp_id', $e['emp_id'])
                ->where('effective_from IS NOT NULL')
                ->orderBy('id', 'DESC')
                ->get()->getRowArray();

            $effDate = (!empty($structRow['effective_from']) && !in_array($structRow['effective_from'], ['0000-00-00', '1970-01-01'])) ? $structRow['effective_from'] : null;
            $e['effective_from'] = $effDate ?? ((!empty($sal['effective_date']) && !in_array($sal['effective_date'], ['0000-00-00', '1970-01-01'])) ? $sal['effective_date'] : null);

            if (!empty($sal['ctc1']) && (float)$sal['ctc1'] > 0) {
                $e['ctc'] = (float)$sal['ctc1'];
            } elseif (!empty($sal['salary']) && (float)$sal['salary'] > 0) {
                $e['ctc'] = (float)$sal['salary'];
            } else {
                $structSum = $db->table('emp_salary_structures es')
                    ->selectSum('es.amount')
                    ->join('salary_components sc', 'sc.id = es.component_id')
                    ->where('es.emp_id', $e['emp_id'])
                    ->whereIn('sc.component_type', ['EARNING', 'STATUTORY'])
                    ->get()->getRowArray();

                if (!empty($structSum['amount']) && (float)$structSum['amount'] > 0) {
                    $e['ctc'] = (float)$structSum['amount'];
                } else {
                    $e['ctc'] = 50000.00;
                }
            }
        }

        $data['components'] = $this->payrollModel->get_salary_components();

        return view('Layouts/Header')
            . view('Layouts/Sidebar')
            . view('admin/payroll/structures', $data)
            . view('Layouts/Footer');
    }

    public function get_emp_structure($emp_id)
    {
        if (!$this->checkAuth()) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Unauthorized']);
        }

        $db = \Config\Database::connect();
        $emp = $db->table('user_details')
            ->where('emp_id', $emp_id)
            ->get()->getRowArray();

        $sal = $db->table('employee_salary')
            ->where('EMP_ID', $emp_id)
            ->orderBy('id', 'DESC')
            ->get()->getRowArray();

        if (!empty($sal['ctc1']) && (float)$sal['ctc1'] > 0) {
            $ctc = (float)$sal['ctc1'];
        } elseif (!empty($sal['salary']) && (float)$sal['salary'] > 0) {
            $ctc = (float)$sal['salary'];
        } else {
            $structSum = $db->table('emp_salary_structures es')
                ->selectSum('es.amount')
                ->join('salary_components sc', 'sc.id = es.component_id')
                ->where('es.emp_id', $emp_id)
                ->whereIn('sc.component_type', ['EARNING', 'STATUTORY'])
                ->get()->getRowArray();

            if (!empty($structSum['amount']) && (float)$structSum['amount'] > 0) {
                $ctc = (float)$structSum['amount'];
            } else {
                $ctc = 50000.00;
            }
        }

        $structures = $this->payrollModel->get_emp_salary_structure($emp_id);
        $components = $this->payrollModel->get_salary_components();

        $effective_from = null;
        if (!empty($structures)) {
            foreach ($structures as $st) {
                if (!empty($st['effective_from']) && !in_array($st['effective_from'], ['0000-00-00', '1970-01-01'])) {
                    $effective_from = $st['effective_from'];
                    break;
                }
            }
        }
        if (empty($effective_from)) {
            $effective_from = (!empty($sal['effective_date']) && !in_array($sal['effective_date'], ['0000-00-00', '1970-01-01'])) ? $sal['effective_date'] : date('Y-m-01');
        }

        return $this->response->setJSON([
            'status'         => 'success',
            'emp_id'         => $emp_id,
            'emp_name'       => $emp['emp_name'] ?? ('Employee ' . $emp_id),
            'ctc'            => $ctc,
            'effective_from' => $effective_from,
            'structures'     => $structures,
            'components'     => $components,
        ]);
    }

    public function save_structure()
    {
        if (!$this->checkAuth()) {
            return redirect()->to(base_url('/'));
        }

        $emp_id         = $this->request->getPost('emp_id');
        $ctc            = (float)$this->request->getPost('ctc');
        $effective_from = $this->request->getPost('effective_from') ?: date('Y-m-01');
        $components_in  = $this->request->getPost('components') ?? [];

        if (empty($emp_id)) {
            return redirect()->back()->with('error', 'Invalid employee specified.');
        }

        $db = \Config\Database::connect();
        $compMasterRaw = $db->table('salary_components')->get()->getResultArray();
        $compMasterMap = [];
        foreach ($compMasterRaw as $cm) {
            $compMasterMap[$cm['id']] = $cm;
        }

        $components_data = [];
        $gross_amount    = 0.00;
        $total_deduct    = 0.00;
        $pf_employer     = 0.00;
        $pf_employee     = 0.00;
        $pt_amount       = 0.00;

        foreach ($components_in as $comp_id => $cdata) {
            if (!isset($cdata['amount']) && !isset($cdata['value'])) continue;
            if ($cdata['amount'] === '' && $cdata['value'] === '') continue;

            $calc_type = strtoupper(trim($cdata['calculation_type'] ?? 'FIXED'));
            if (!in_array($calc_type, ['PERCENTAGE', 'FIXED', 'SLAB'])) {
                $calc_type = 'FIXED';
            }

            $amt = (float)($cdata['amount'] ?? 0);
            $val = (float)($cdata['value'] ?? 0);

            $components_data[] = [
                'component_id'     => (int)$comp_id,
                'calculation_type' => $calc_type,
                'value'            => $val,
                'amount'           => $amt,
                'effective_from'   => $effective_from,
            ];

            $compInfo = $compMasterMap[$comp_id] ?? null;
            if ($compInfo) {
                $cType = $compInfo['component_type'];
                $cCode = $compInfo['component_code'];

                if ($cType === 'EARNING') {
                    $gross_amount += $amt;
                } elseif ($cType === 'DEDUCTION') {
                    $total_deduct += $amt;
                    if ($cCode === 'EPF_EMPLOYEE') $pf_employee = $amt;
                    elseif ($cCode === 'PT') $pt_amount = $amt;
                } elseif ($cType === 'STATUTORY') {
                    if ($cCode === 'EPF_EMPLOYER') $pf_employer = $amt;
                }
            }
        }

        $this->payrollModel->save_emp_salary_structure($emp_id, $components_data);

        $net_pay = max(0, $gross_amount - $total_deduct);

        $existing = $db->table('employee_salary')->where('EMP_ID', $emp_id)->get()->getResultArray();
        $salUpdate = [
            'ctc1'                     => $ctc,
            'salary'                   => $ctc,
            'gross'                    => $gross_amount,
            'pf_employer_contribution' => $pf_employer,
            'pf_employee_contribution' => $pf_employee,
            'pt'                       => $pt_amount,
            'total_deductions'         => $total_deduct,
            'net_pay'                  => $net_pay,
        ];

        if (!empty($existing)) {
            $db->table('employee_salary')->where('EMP_ID', $emp_id)->update($salUpdate);
        } else {
            $salUpdate['EMP_ID'] = $emp_id;
            $db->table('employee_salary')->insert($salUpdate);
        }

        return redirect()->to(base_url('admin/payroll/structures'))->with('success', 'Salary structure saved successfully for ' . $emp_id . ' (₹' . number_format($ctc, 2) . ')!');
    }
}
