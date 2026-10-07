<?php

namespace App\Controllers;

use App\Models\EmployeeModel;
use App\Models\AdminModel; //Admin Model
use App\Models\ManagerModel; //ManagerModel
use App\Models\SalaryModel; //SalaryModel
use App\Models\HomeModel; //HomeModel

class EmployeeController extends BaseController
{


    // Employee Dashboard
    public function emp_dash()
    {
        $session = session();
        if (!$session->get('logged_in')) {
        return redirect()->to(base_url('/'));
        } 
        $Model = new AdminModel();
        // $model = new HomeModel();
        $empmodel = new EmployeeModel();

        $data['holiday'] = $Model->getholidaylist();
        
        $data['birthday'] = $Model->get_birthday();
     
        $emp_id = $session->get('emp_id');
       
        $data['empdash'] = $empmodel-> get_emp_dash($emp_id);
       
       
        
        return view('Layouts/Header')
            . view('Layouts/Sidebar')
            . view('employee/Emp_dashboard', $data)
            . view('Layouts/Footer');
    }

    public function emp_pi_po()
    {
        $session = session();

        $emp_id = $session->get('emp_id');
        $punch_type = $this->request->getPost('punch_type');
        $ip_address = $this->request->getPost('ip_address');

        $empmodel = new EmployeeModel();

        $result = $empmodel->employee_attendance_punch(
            $emp_id,
            $ip_address,
            $punch_type
        );

        if ($result) {

        // Take status and remarks directly from backend
        $status  = $result[0]['status'] ?? 'N';
        $remarks = $result[0]['remarks'] ?? 'Attendance punch failed.';

        $session->setFlashdata('status', $status);
        $session->setFlashdata('remarks', $remarks);

    } else {

        $session->setFlashdata('status', 'N');
        $session->setFlashdata(
            'remarks',
            'Failed to record attendance punch.'
        );
    }
        return redirect()->to(base_url('employee/Emp_dashboard'));
    }

    public function cal()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to(base_url('/'));
        }
        $Model = new AdminModel();
        $empmodel = new EmployeeModel();
        $emp_id = $session->get('emp_id');
 
        $data['holiday'] = $Model->getholidaylist();
        $leaves['leave_history'] = $empmodel->get_emp_leave_history($emp_id);
        $data = array_merge($data, $leaves);
 
        return view('Layouts/Header')
            . view('Layouts/Sidebar')
            . view('employee/calender', $data)
            . view('Layouts/Footer');
    }

    public function team()
    {
        $session = session();
        if (!$session->get('logged_in')) {
        return redirect()->to(base_url('/'));
        } 
        return view('Layouts/Header')
            . view('Layouts/Sidebar')
            . view('employee/team')
            . view('Layouts/Footer');
    }

    public function attendence()
    {
        $session = session();

        if (!$session->get('logged_in')) {
            return redirect()->to(base_url('/'));
        }

        /*
        * Company Attendance Cycle
        *
        * 25th July  -> 24th August   = August
        * 25th August -> 24th September = September
        * 25th September -> 24th October = October
        */

        // If user selected Month + Year from dropdown
        $selectedMonth = $this->request->getVar('month');
        $selectedYear  = $this->request->getVar('year');

        if (!empty($selectedMonth) && !empty($selectedYear)) {

            // Use selected values
            $data['selectedMonth'] = str_pad($selectedMonth, 2, '0', STR_PAD_LEFT);
            $data['selectedYear']  = $selectedYear;

        } else {

            // Default company attendance cycle
            $today = new \DateTime();

            $day = (int)$today->format('d');
            $month = (int)$today->format('m');
            $year = (int)$today->format('Y');

            if ($day >= 25) {

                // 25th onwards belongs to NEXT month
                $month++;

                if ($month > 12) {
                    $month = 1;
                    $year++;
                }
            }

            $data['selectedMonth'] = str_pad($month, 2, '0', STR_PAD_LEFT);
            $data['selectedYear']  = $year;
        }

        $month = (int)$data['selectedMonth'];
        $year  = (int)$data['selectedYear'];

        $empmodel = new EmployeeModel();
        $Model = new AdminModel();

        $empid = session()->get('emp_id');

        $data['attendance'] = $empmodel->get_emp_Attendance($empid, $month, $year);

        $attendSummary = $empmodel->get_emp_summary($empid, $month, $year);
        $data['attend'] = $attendSummary[0] ?? [];

        $data['holiday'] = $Model->getholidaylist();
        // echo '<pre>';
        // print_r($data['holiday']);
        // exit;

        return view('Layouts/Header')
            . view('Layouts/Sidebar')
            . view('employee/my_attendance', $data)
            . view('Layouts/Footer');
    }

    public function leave()
    {
        $session = session();
        if (!$session->get('logged_in')) {
        return redirect()->to(base_url('/'));
        } 
        $Model = new AdminModel();
        $model = new EmployeeModel();

        $data['holiday'] = $Model->getholidaylist();

        // get from session correctly
        $empid = $session->get('emp_id');

        $year = date('Y');

        $data['leave'] = $model->get_emp_leave($empid, $year);
        
        $data['leavetype'] = $model->get_leave_type();
      
        return view('Layouts/Header')
            . view('Layouts/Sidebar')
            . view('employee/apply_leave1', $data)
            . view('Layouts/Footer');
    }

    public function leave_apply_submit()
    {
        $session = session();
        if (!$session->get('logged_in')) {
        return redirect()->to(base_url('/'));
        } 
        $model = new EmployeeModel();

        $empid = $session->get('emp_id');

        $leave_code = $this->request->getPost('leave_type');
        $fromdate   = $this->request->getPost('from_date');
        $todate     = $this->request->getPost('to_date');
        $reason     = $this->request->getPost('reason');

        // CALL PROCEDURE
        $result = $model->leave_apply($empid, $leave_code, $fromdate, $todate, $reason);
        // dd($result);

        return redirect()->to(base_url('employee/leave'))
                ->with('status', $result[0]['status'])
                ->with('remarks', $result[0]['remarks']);
    }

    public function Sal()
    {
        $session = session();
        if (!$session->get('logged_in')) {
        return redirect()->to(base_url('/'));
        }

        $model = new SalaryModel();
        $empmodel = new EmployeeModel();
        $empid = $session->get('emp_id');
        $month = $this->request->getGet('month') ?: 'ALL';
        $year  = $this->request->getGet('year') ?: date('Y');

        $data['selectedMonth'] = $month;
        $data['selectedYear']  = $year;


        $data['content'] = $model->get_emp_payslip($empid, $month, $year);

            $data['error'] = '';
            if (
                isset($data['content'][0]['status']) &&
                $data['content'][0]['status'] == 'N'
            ) {
                $data['error'] = $data['content'][0]['remarks'];
                $data['content'] = [];
            }

           
        $data['empdash'] = $empmodel-> get_emp_dash($empid);

        if (!empty($data['empdash']) && !empty($data['empdash'][0]['ctc'])) {
            $session->set('monthly_ctc', $data['empdash'][0]['ctc']);
        }

        $data['displayMonthlyCTC'] = $session->get('monthly_ctc') ?? 0;

      
        return view('Layouts/Header')
            . view('Layouts/Sidebar')
            . view('employee/pay_roll',$data)
            . view('Layouts/Footer');
    }

    public function req()
    {
        $session = session();
        if (!$session->get('logged_in')) {
        return redirect()->to(base_url('/'));
        }
        $empid = $session->get('emp_id');
        $model = new EmployeeModel();
        $data['requests'] = $model->leave_request($empid);
        $data['request_types'] = $model->get_request_types();
       
        return view('Layouts/Header')
            . view('Layouts/Sidebar')
            . view('employee/requests',$data)
            . view('Layouts/Footer');
    }

    public function submit_request()
    {
    $session = session();
    if (!$session->get('logged_in')) {
        return redirect()->to(base_url('/'));
        }
    $model = new EmployeeModel();

    $empid = $session->get('emp_id');

    $category    = $this->request->getPost('category');
    $subject     = $this->request->getPost('subject');
    $description = $this->request->getPost('description');

    $attachmentPath = '';

    $file = $this->request->getFile('attachment');

    if ($file && $file->isValid() && !$file->hasMoved()) {

        $newName = $file->getRandomName();

        $file->move(FCPATH . 'uploads/attachments', $newName);

        $attachmentPath = '/uploads/attachments/' . $newName;
    }

    $result = $model->update_requests('INSERT', null, $empid,$category,$subject, $description,
    $attachmentPath, null, null);

    // Notify Reporting Manager
    try {
        $db = \Config\Database::connect();
        $userRow = $db->table('user_details')->select('reporting, emp_name')->where('emp_id', $empid)->get()->getRowArray();
        if (!empty($userRow['reporting'])) {
            $notifModel = new \App\Models\NotificationModel();
            $notifModel->create_notification(
                'REQUEST',
                'New Request: ' . $subject,
                ($userRow['emp_name'] ?? $empid) . ' submitted a new ' . $category . ' request.',
                'USER',
                null,
                $userRow['reporting'],
                $empid,
                null
            );
        }
    } catch (\Throwable $e) {}
   
    return redirect()->to(base_url('employee/requests'))
    ->with('status', 'Y')
    ->with('remarks', 'Request Submitted Successfully');
   }

    public function cancel_request($request_id)
    {
        $session = session();
        if (!$session->get('logged_in')) {
        return redirect()->to(base_url('/'));
        }
        $model = new EmployeeModel();

        $empid = $session->get('emp_id');

        $reason = 'Cancelled by Employee';

        $result = $model->update_requests('CANCEL', $request_id, $empid, null,null,null, null, null,$reason);

        return redirect()->to(base_url('employee/requests'))
            ->with('status', 'Y')
            ->with('remarks', 'Request Cancelled Successfully');
    }

    public function complete_request()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to(base_url('/'));
        }

        $model = new EmployeeModel();
        $request_id = $this->request->getPost('request_id');
        $empid      = $session->get('emp_id');

        $result = $model->update_requests('COMPLETE', $request_id, $empid,NULL,NULL, NULL,
            NULL,NULL, NULL);

        return redirect()->back()
            ->with('status', 'Y')
            ->with('remarks', 'Request Completed Successfully');
    }

    public function teammgr()
    {
        $session = session();

        if (!$session->get('logged_in')) {
            return redirect()->to(base_url('/'));
        }

        $managerModel = new ManagerModel();
        $model = new EmployeeModel();

        $empid = $session->get('emp_id');
        $user_category = $session->get('user_category');

        // Employees
        $data['employee'] = $managerModel->employee_details($empid, $user_category,'ALL');

        // Leave Requests
        $data['leave_requests'] = $managerModel->leave_history($empid,$user_category,NULL,NULL,NULL);

        // Employee Requests
        $data['requests'] = $model->leave_request($empid);

        /*
            * ==========================================
            * COMPANY ATTENDANCE MONTH
            * ==========================================
            *
            * August   = 25 Jul - 24 Aug
            * September = 25 Aug - 24 Sep
            * October  = 25 Sep - 24 Oct
            */

            $today = new \DateTime();

            $currentDay   = (int) $today->format('d');
            $currentMonth = (int) $today->format('m');
            $currentYear  = (int) $today->format('Y');

            /*
            * Default company month
            */
            if ($currentDay >= 25) {

                $defaultMonth = $currentMonth + 1;
                $defaultYear  = $currentYear;

                if ($defaultMonth > 12) {
                    $defaultMonth = 1;
                    $defaultYear++;
                }

            } else {

                $defaultMonth = $currentMonth;
                $defaultYear  = $currentYear;
            }

            /*
            * ==========================================
            * GET SELECTED MONTH / YEAR
            * ==========================================
            */

            $postMonth = $this->request->getPost('month');
            $postYear  = $this->request->getPost('year');

            /*
            * If user selected a month, use it.
            * Otherwise use current company month.
            */
            $month = !empty($postMonth)
                ? (int) $postMonth
                : $defaultMonth;

            $year = !empty($postYear)
                ? (int) $postYear
                : $defaultYear;

                

            /*
            * Keep selected values for the view
            */
            $data['selectedMonth'] = str_pad($month, 2, '0', STR_PAD_LEFT);
            $data['selectedYear']  = $year;

            /*
            * ==========================================
            * ATTENDANCE REPORT
            * ==========================================
            */

            $data['report'] = $model->get_emp_report($empid,$month,$year);
            // echo '<pre>';
            // print_r($data['report']);
            // exit;
            $data['summary'] = $model->get_emp_summary($empid,$month,$year);

            return view('Layouts/Header')
                . view('Layouts/Sidebar')
                . view('employee/myteammgr', $data)
                . view('Layouts/Footer');
    }


    public function emp_attendance()
    {
        $session = session();

        if (!$session->get('logged_in')) {
            return redirect()->to(base_url('/'));
        }

        $model = new EmployeeModel();
        $empid = $session->get('emp_id');
    

        $data['selectedMonth'] = $this->request->getGet('month') ?? date('m');
        $data['selectedYear']  = $this->request->getGet('year') ?? date('Y');

        $month = (int)$data['selectedMonth'];
        $year  = (int)$data['selectedYear'];

        $data['report'] = $model->get_emp_report($empid, $month, $year);

        return view('Layouts/Header')
            . view('Layouts/Sidebar')
            . view('employee/emp_attendance', $data)
            . view('Layouts/Footer');
    }

    public function view_history_emp()
    {
        $session = session();
        $session = session();
        if (!$session->get('logged_in')) {
        return redirect()->to(base_url('/'));
        }
        $model = new EmployeeModel();

        $empid = $session->get('emp_id');
        $user_category = $session->get('user_category');

        $data['history'] = $model->get_emp_leave_history($empid);
        
        return view('Layouts/Header')
            . view('Layouts/Sidebar')
            . view('employee/leave_history', $data)
            . view('Layouts/Footer');
    }

    public function leave_decision()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to(base_url('/'));
        }
        $empid = $session->get('emp_id');
        $user_category = $session->get('user_category');

        $decision = $this->request->getPost('decision');
        $leave_id = $this->request->getPost('leave_id');
        $reason   = $this->request->getPost('reason') ?? null;

        $norm_decision = strtoupper(trim((string)$decision));

        // HR approval remarks mandatory check
        if (
            $user_category === 'HR' &&
            in_array($norm_decision, ['APPROVE', 'APPROVED', 'ACCEPT', 'ACCEPTED']) &&
            empty($reason)
        ) {
            return redirect()->back()->with('error', 'Approval remarks are required.');
        }

        // Map variations to canonical action names
        if (in_array($norm_decision, ['APPROVED', 'ACCEPT', 'ACCEPTED'])) {
            $norm_decision = 'APPROVE';
        } elseif (in_array($norm_decision, ['REJECTED'])) {
            $norm_decision = 'REJECT';
        } elseif (in_array($norm_decision, ['CANCELLED'])) {
            $norm_decision = 'CANCEL';
        }

        $model = new EmployeeModel();
        $result = $model->leave_decision($leave_id, $norm_decision, $empid, $reason);

        $status  = $result[0]['status'] ?? 'N';
        $remarks = $result[0]['remarks'] ?? 'Leave action processed.';

        if ($status === 'Y') {
            return redirect()->back()->with('success', $remarks);
        } else {
            return redirect()->back()->with('error', $remarks);
        }
    }
}
