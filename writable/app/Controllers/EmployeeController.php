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
       
        //  echo '<pre>';
        // print_r($data['empdash']);
        // exit;
        
        return view('Layouts/Header')
            . view('Layouts/Sidebar')
            . view('employee/Emp_dashboard', $data)
            . view('Layouts/Footer');
    }

    public function cal()
    {
        $session = session();
        if (!$session->get('logged_in')) {
        return redirect()->to(base_url('/'));
        } 
        $Model = new AdminModel();
        $data['holiday'] = $Model->getholidaylist();
        // echo '<pre>';
        // print_r($data['holiday']);
        // exit;
        // dd($data['holiday']);
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
        return view('Layouts/Header')
            . view('Layouts/Sidebar')
            . view('employee/my_attendance')
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
        // echo '<pre>';
        // print_r($data['leave']);
        // exit;
        $data['leavetype'] = $model->get_leave_type();
        // echo '<pre>';
        // print_r($data['leavetype']);
        // exit;
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

        // dd($data['content']);
        // echo '<pre>';
        // print_r($data['content']);
        // exit;
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
        // dd($data['requests']);
        // echo '<pre>';
        // print_r($data['requests']);
        // echo '<pre>';
        // exit;
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
    // echo '<pre>';
    // print_r($result);
    // exit;
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
        $data['leave_requests'] = $managerModel->leave_history($empid, $user_category, NULL, NULL, NULL);

        $data['employee'] = $managerModel->employee_details($empid, $user_category, 'ALL');
        // dd($data['employee']);
        $data['requests'] = $model->leave_request($empid);
 
        return view('Layouts/Header')
            . view('Layouts/Sidebar')
            . view('employee/myteammgr', $data)
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
        // echo '<pre>';
        // print_r($data['history']);
        // exit;
        return view('Layouts/Header')
            . view('Layouts/Sidebar')
            . view('employee/leave_history', $data)
            . view('Layouts/Footer');
    }

    public function leave_decision()
    {
        $session = session();
        $session = session();
        if (!$session->get('logged_in')) {
        return redirect()->to(base_url('/'));
        }
        $empid = $session->get('emp_id');
        $user_category = $session->get('user_category');

        // Will be "Approved", "Reject", or "cancel"
        $decision = $this->request->getPost('decision');
        $leave_id = $this->request->getPost('leave_id');
        $reason = $this->request->getPost('reason') ?? null;

        // HR approval remarks mandatory
        if (
            $user_category == 'HR' &&
            strtolower($decision) == 'approved' &&
            empty($reason)
        ) {
            return redirect()->back()->with('error', 'Approval remarks are required.');
        }
        $model = new EmployeeModel();

        $model->leave_decision($leave_id, $decision, $empid, $reason);


        if (strtolower($decision) === 'cancel') {
            $message = 'Your leave request has been cancelled successfully.';
            $redirectUrl = 'employee/leave_history';
        } else {
            $status_text = (strtolower($decision) === 'approved') ? 'approved' : 'rejected';
            $message = 'Leave request has been ' . $status_text . '.';

            $redirectUrl = 'admin/leave_requ/' . $leave_id;
        }

        return redirect()->to(base_url($redirectUrl))->with('success', $message);
    }

   
}
