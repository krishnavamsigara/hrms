<?php

namespace App\Controllers;

use App\Models\SalaryModel;
use App\Models\PayrollModel;

class SalaryController extends BaseController
{
    public function pay_roll()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to(base_url('/'));
        }
        $model = new SalaryModel();
        $payrollModel = new PayrollModel();

        $empid = $session->get('emp_id');

        // Check if new payroll cycles exist
        $db = \Config\Database::connect();
        $latest_salary = $db->table('salaries s')
            ->select('s.*, pc.payroll_code, pc.period_start, pc.period_end')
            ->join('payroll_cycles pc', 'pc.id = s.payroll_cycle_id', 'left')
            ->where('s.emp_id', $empid)
            ->orderBy('s.id', 'DESC')
            ->get()->getRowArray();

        $data['salary']        = $model->get_view_salary();
        $data['latest_salary'] = $latest_salary;

        return view('Layouts/Header')
            . view('Layouts/Sidebar')
            . view('admin/pay_roll', $data)
            . view('Layouts/Footer');
    }

    public function emp_payslip($empid = '', $month = '', $year = '')
    {
        try {
            $session = session();
            if (!$session->get('logged_in')) {
                return redirect()->to(base_url('/'));
            }
            $model = new SalaryModel();
            $payrollModel = new PayrollModel();

            if ($empid == '') {
                $empid = $session->get('emp_id');
            }

            if ($month == '') {
                $month = date('F');
            }

            if ($year == '') {
                $year = date('Y');
            }

            // Attempt to get frozen payslip from new Payroll Processing Engine
            $frozen = $payrollModel->get_employee_frozen_payslip($empid, $month, $year);

            if ($frozen && !empty($frozen['header'])) {
                $hdr = $frozen['header'];
                $data['content'] = [[
                    'month'            => $month,
                    'year'             => $year,
                    'emp_id'           => $hdr['emp_id'],
                    'emp_name'         => $hdr['emp_name'] ?? '',
                    'department'       => $hdr['department'] ?? '',
                    'designation'      => $hdr['designation'] ?? '',
                    'pan_no'           => $hdr['pan_no'] ?? '',
                    'bank_account_no'  => $hdr['bank_account_no'] ?? '',
                    'ifsc_code'        => $hdr['ifsc_code'] ?? '',
                    'ctc'              => $hdr['gross_amount'],
                    'total_deductions' => $hdr['total_deductions'],
                    'net_salary'       => $hdr['net_amount'],
                    'working_days'     => $hdr['paid_days'] + $hdr['lop_days'],
                    'present_days'     => $hdr['paid_days'],
                    'lop_days'         => $hdr['lop_days'],
                    'payroll_code'     => $hdr['payroll_code'] ?? '',
                    'period_start'     => $hdr['period_start'] ?? '',
                    'period_end'       => $hdr['period_end'] ?? '',
                ]];
                $data['earnings']   = $frozen['earnings'];
                $data['deductions'] = $frozen['deductions'];
            } else {
                // Fallback to legacy procedure caller
                $data['content']    = $model->get_emp_payslip($empid, $month, $year);
                $data['earnings']   = $model->get_emp_allowance($empid, $month, $year);
                $data['deductions'] = $model->get_emp_deductions($empid, $month, $year);
            }

            // Check DB response for error status
            if (isset($data['content'][0]['status']) && $data['content'][0]['status'] == 'N') {
                $referer = request()->getServer('HTTP_REFERER');
                if (!empty($referer)) {
                    return redirect()->back()->with(
                        'error',
                        $data['content'][0]['remarks']
                    );
                }
                return redirect()->to(base_url('admin/pay_roll'))->with(
                    'error',
                    $data['content'][0]['remarks']
                );
            }

            return view('Layouts/Header')
                . view('Layouts/Sidebar')
                . view('employee/new_emp_payslip', $data)
                . view('Layouts/Footer');
        } catch (\Throwable $e) {
            log_message('error', 'emp_payslip Error: ' . $e->getMessage());
            $referer = request()->getServer('HTTP_REFERER');
            $errorMessage = 'Payslip error: ' . $e->getMessage();
            if (!empty($referer)) {
                return redirect()->back()->with('error', $errorMessage);
            }
            return redirect()->to(base_url('admin/pay_roll'))->with('error', $errorMessage);
        }
    }

    public function Sal_invoice()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to(base_url('/'));
        }
        return view('Layouts/Header')
            . view('Layouts/Sidebar')
            . view('employee/salaryinvoice')
            . view('Layouts/Footer');
    }
}
