<?php

namespace App\Controllers;

use App\Models\SalaryModel;


class SalaryController extends BaseController
{

 public function pay_roll()
 {
        $session = session();
        if (!$session->get('logged_in')) {
        return redirect()->to(base_url('/'));
        }
        $model = new SalaryModel();
    
        $empid = $session->get('emp_id');
        $month = date('F');
        $year = date('Y');

        // Payslip
        $data['salary'] = $model->get_view_salary();
        // $data['content'] = $model->get_emp_payslip($empid, $month, $year);
        //   dd($data['salary']);
        //    dd($data['content']);
        return  view('Layouts/Header')
            . view('Layouts/Sidebar')
            . view('admin/pay_roll',$data)
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

            // If no values come from URL, use current logged-in employee and current month/year
            if ($empid == '') {
                $empid = $session->get('emp_id');
            }

            if ($month == '') {
                $month = date('F');
            }

            if ($year == '') {
                $year = date('Y');
            }

            // Payslip
            $data['content'] = $model->get_emp_payslip($empid, $month, $year);

            // Check DB response
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

            // Earnings
            $data['earnings'] = $model->get_emp_allowance($empid, $month, $year);

            // Deductions
            $data['deductions'] = $model->get_emp_deductions($empid, $month, $year);

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
