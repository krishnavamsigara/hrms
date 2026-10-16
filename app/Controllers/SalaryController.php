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

        $data['salary']        = $model->get_view_salary();
        $data['latest_salary'] = $model->get_latest_salary($empid);

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
            $settingsModel = new \App\Models\CompanySettingsModel();
            $data['company'] = $settingsModel->get_settings();

            if ($empid == '') {
                $empid = $session->get('emp_id');
            }

            if ($month == '') {
                $month = date('F');
            }

            if ($year == '') {
                $year = date('Y');
            }

            // Version selector: ?version=v1 (Legacy Table/Procedure) or ?version=v2 (New Engine) or default auto
            $requested_version = $this->request->getGet('version'); // 'v1' or 'v2'
            $active_version = 'v2';

            if ($requested_version === 'v1') {
                // Explicit legacy procedure fetch
                $data['content']    = $model->get_emp_payslip($empid, $month, $year);
                $data['earnings']   = $model->get_emp_allowance($empid, $month, $year);
                $data['deductions'] = $model->get_emp_deductions($empid, $month, $year);
                $active_version     = 'v1';
            } else {
                // Try New Engine frozen payslip first
                $frozen = $payrollModel->get_employee_frozen_payslip($empid, $month, $year);

                if ($frozen && !empty($frozen['content'])) {
                    $data['content']    = $frozen['content'];
                    $data['earnings']   = $frozen['earnings'];
                    $data['deductions'] = $frozen['deductions'];
                    $active_version     = 'v2';
                } else {
                    // Fallback to legacy procedure
                    $data['content']    = $model->get_emp_payslip($empid, $month, $year);
                    $data['earnings']   = $model->get_emp_allowance($empid, $month, $year);
                    $data['deductions'] = $model->get_emp_deductions($empid, $month, $year);
                    $active_version     = 'v1';
                }
            }

            $data['active_version']    = $active_version;
            $data['requested_version'] = $requested_version;
            $data['empid_param']       = $empid;
            $data['month_param']       = $month;
            $data['year_param']        = $year;

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
