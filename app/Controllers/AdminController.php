<?php

namespace App\Controllers;

use App\Models\AdminModel;
use App\Models\OnboardingModel; //Onbarding Model
use App\Models\ManagerModel; //ManagerModel
use App\Models\EmployeeModel;//EmployeeModel
use App\Models\HomeModel;//HomeModel

class AdminController extends BaseController
{

    //Admin Dashboard
    public function admin_dash()
    {
        $session = session();
        if (!$session->get('logged_in')) {
        return redirect()->to(base_url('/'));
        }
        $Model = new AdminModel();
        $emp_id = $session->get('emp_id');
        $user_category = $session->get('user_category');
        $data['holiday'] = $Model->getholidaylist();
       
        $data['adm_dash'] = $Model->get_adm_dash($emp_id, $user_category);
       
        $data['birthday'] = $Model->get_birthday();
        
        return  view('Layouts/Header')
            . view('Layouts/Sidebar')
            . view('admin/adm_dashboard', $data)
            . view('Layouts/Footer');
    }

    public function adm_cal()
    {
        $session = session();
        if (!$session->get('logged_in')) {
        return redirect()->to(base_url('/'));
        }
        $Model = new AdminModel();
        $data['holiday'] = $Model->getholidaylist();
        return  view('Layouts/Header')
            . view('Layouts/Sidebar')
            . view('admin/calender', $data)
            . view('Layouts/Footer');
    }

    public function adm_dep()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to(base_url('/'));
        }
        $Model = new AdminModel();
        $data['departments'] = $Model->get_departments();
        
        return view('Layouts/Header')
            . view('Layouts/Sidebar')
            . view('admin/deparment', $data)
            . view('Layouts/Footer');
    }

    public function save_department()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Unauthorized']);
        }

        $mode = $this->request->getPost('mode') ?? 'INSERT';
        $dept_id = $this->request->getPost('department_id') ?: null;
        $dept_name = $this->request->getPost('department_name');
        $status = $this->request->getPost('status') ?? '1';

        $model = new AdminModel();
        $result = $model->save_department($mode, $dept_id, $dept_name, $status);

        if (!empty($result) && isset($result[0])) {
            $row = $result[0];
            return $this->response->setJSON([
                'status'  => ($row['status'] === 'Y') ? 'success' : 'error',
                'message' => $row['remarks'] ?? 'Operation completed'
            ]);
        }

        return $this->response->setJSON(['status' => 'error', 'message' => 'Failed to execute procedure']);
    }

    public function adm_designation()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to(base_url('/'));
        }

        $model = new AdminModel();
        $data['designations'] = $model->get_designations();

        return view('Layouts/Header')
            . view('Layouts/Sidebar')
            . view('admin/designation', $data)
            . view('Layouts/Footer');
    }

    public function save_designation()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Unauthorized']);
        }

        $mode = $this->request->getPost('mode') ?? 'INSERT';
        $desg_id = $this->request->getPost('designation_id') ?: null;
        $desg_name = $this->request->getPost('designation_name');
        $status = $this->request->getPost('status') ?? '1';

        $model = new AdminModel();
        $result = $model->save_designation($mode, $desg_id, $desg_name, $status);

        if (!empty($result) && isset($result[0])) {
            $row = $result[0];
            return $this->response->setJSON([
                'status'  => ($row['status'] === 'Y') ? 'success' : 'error',
                'message' => $row['remarks'] ?? 'Operation completed'
            ]);
        }

        return $this->response->setJSON(['status' => 'error', 'message' => 'Failed to execute procedure']);
    }

    public function leave_types()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to(base_url('/'));
        }

        $model = new AdminModel();
        $data['leave_types'] = $model->get_leave_types();

        return view('Layouts/Header')
            . view('Layouts/Sidebar')
            . view('admin/leave_types', $data)
            . view('Layouts/Footer');
    }

    public function save_leave_type()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Unauthorized']);
        }

        $mode = $this->request->getPost('mode') ?? 'INSERT';
        $id = $this->request->getPost('leave_type_id') ?: null;
        $code = $this->request->getPost('leave_code');
        $name = $this->request->getPost('leave_name');
        $year = $this->request->getPost('year') ?? date('Y');
        $quota = $this->request->getPost('yearly_quota') ?? 0.00;
        $carry_forward = $this->request->getPost('carry_forward_flag') ?? 'N';
        $max_carry = $this->request->getPost('max_carry_forward') ?? 0.00;
        $encashment = $this->request->getPost('encashment_flag') ?? 'N';
        $requires_approval = $this->request->getPost('requires_approval') ?? 'Y';
        $affects_salary = $this->request->getPost('affects_salary') ?? 'N';
        $gender = $this->request->getPost('gender_applicable') ?? '';
        $status = $this->request->getPost('status') ?? 'A';
        $is_accrual = $this->request->getPost('is_accrual') ?? 'N';

        $model = new AdminModel();
        $result = $model->save_leave_type(
            $mode, $id, $code, $name, $year, $quota,
            $carry_forward, $max_carry, $encashment, $requires_approval,
            $affects_salary, $gender, $status, $is_accrual
        );

        if (!empty($result) && isset($result[0])) {
            $row = $result[0];
            return $this->response->setJSON([
                'status'  => ($row['status'] === 'Y') ? 'success' : 'error',
                'message' => $row['remarks'] ?? 'Operation completed'
            ]);
        }

        return $this->response->setJSON(['status' => 'error', 'message' => 'Failed to execute procedure']);
    }

    public function generate_leave_balances()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Unauthorized']);
        }

        $year = (int)($this->request->getPost('year') ?? date('Y'));

        $model = new AdminModel();
        $result = $model->generate_leave_balances($year);

        if (!empty($result) && isset($result[0])) {
            $row = $result[0];
            return $this->response->setJSON([
                'status'  => ($row['status'] === 'Y') ? 'success' : 'error',
                'message' => $row['remarks'] ?? 'Leave balances generated successfully'
            ]);
        }

        return $this->response->setJSON(['status' => 'error', 'message' => 'Failed to generate leave balances']);
    }

    public function adm_emp()
    {
        $session = session();
        if (!$session->get('logged_in')) {
        return redirect()->to(base_url('/'));
        }
        $managerModel = new ManagerModel();
        $empid = $session->get('emp_id');
        // $user_category = $session->get('user_category');
        $user_category = $session->get('current_user_cat');

        $data['employee'] = $managerModel->employee_details($empid, $user_category, 'ALL');
      
        return  view('Layouts/Header')
            . view('Layouts/Sidebar')
            . view('admin/empolyees',$data)
            . view('Layouts/Footer');
    }

    public function toggle_user_status()
    {
        $session = session();

        $Model = new AdminModel();
        $admin_emp_id   = $session->get('emp_id');
        $admin_category = $session->get('user_category');
        $target_emp_id  = $this->request->getPost('emp_id');

        $result =  $Model->toggle_user_status(
            $admin_emp_id,
            $admin_category,
            $target_emp_id
        );
            return $this->response->setJSON([
                'status'  => $result[0]['status'] ?? '',
                'remarks' => $result[0]['remarks'] ?? ''
            ]);
    }

    public function adm_attendence()
    {
        $session = session();
        if (!$session->get('logged_in')) {
        return redirect()->to(base_url('/'));
        }

        $Model = new AdminModel();
        $empid = $session->get('emp_id');
        $user_category = $session->get('current_user_cat');

        // Get selected date from filter
        $filterDate = $this->request->getGet('filter_date') ?? date('Y-m-d');

        // Get exact values from input date
        $parts = explode('-', $filterDate);

        $year  = (int)$parts[0];
        $month = (int)$parts[1];
        $day   = (int)$parts[2];
        
        $data['attendance'] =  $Model->get_attendence_to_admin($empid, $day ,$month, $year);
        $data['filterDate'] = $filterDate;
        $data['everyday'] =  $Model->get_attendence_everyday($empid, $day ,$month, $year,$user_category);
        // $data['report'] =  $Model->get_monthly_report($empid,$month, $year);
        // echo '<pre>';
        // print_r($data['report']);
        // exit;
//         echo '<pre>';
// print_r([
//     'filterDate' => $filterDate,
//     'day'        => $day,
//     'month'      => $month,
//     'year'       => $year,
// ]);
// exit;

        return  view('Layouts/Header')
            . view('Layouts/Sidebar')
            . view('admin/attendance_dashboard',$data)
            . view('Layouts/Footer');
    }

    public function adm_attend()
    {
        $session = session();

        if (!$session->get('logged_in')) {
            return redirect()->to(base_url('/'));
        }

        $Model = new AdminModel();
        $empid = $session->get('emp_id');
        $user_category = $session->get('current_user_cat');

        // Get selected date from View All URL
        $filterDate = $this->request->getGet('filter_date') ?? date('Y-m-d');

        // Convert selected date into day, month, year
        $parts = explode('-', $filterDate);

        $year  = (int)$parts[0];
        $month = (int)$parts[1];
        $day   = (int)$parts[2];

        // Get attendance for ALL employees on selected date
        $data['everyday'] =  $Model->get_attendence_everyday($empid, $day ,$month, $year, $user_category);
        $data['filterDate'] = $filterDate;

        return view('Layouts/Header')
            . view('Layouts/Sidebar')
            . view('admin/attendance_adm', $data)
            . view('Layouts/Footer');
    }

    public function adm_master_time()
    {
        $session = session();

        if (!$session->get('logged_in')) {
            return redirect()->to(base_url('/'));
        }

        $Model = new AdminModel();
        $empid = $session->get('emp_id');
        $user_category = $this->request->getGet('user_category') ?? 'ALL';

        // Selected Month and Year
        $month = $this->request->getGet('month') ?? date('m');
        $year  = $this->request->getGet('year') ?? date('Y');

        $month = (int) $month;
        $year  = (int) $year;

        // Call procedure with ONLY emp_id, month, year
        $data['report'] = $Model->get_monthly_report($empid, $month,$year,$user_category);
        // echo'<pre>';
        // print_r($data['report']);
        // exit;

        // Send selected values to view
        $data['selectedMonth'] = str_pad($month, 2, '0', STR_PAD_LEFT);
        $data['selectedYear']  = $year;

        return view('Layouts/Header')
            . view('Layouts/Sidebar')
            . view('admin/master_time_sheet', $data)
            . view('Layouts/Footer');
    }

    public function adm_leave()
    {
        $session = session();
        if (!$session->get('logged_in')) {
        return redirect()->to(base_url('/'));
        }
        $managerModel = new ManagerModel();
        $empid = $session->get('emp_id');
        // $user_category = $session->get('user_category');
        $user_category = $session->get('current_user_cat');
        $fromdate = $this->request->getGet('from_date') ?? '2026-01-01';
        $todate   = $this->request->getGet('to_date') ?? '2026-12-31';

        $data['requests'] = $managerModel->leave_history($empid, $user_category, NULL, $fromdate, $todate);

        return  view('Layouts/Header')
            . view('Layouts/Sidebar')
            . view('admin/leave_overview', $data)
            . view('Layouts/Footer');
    }

    public function adm_payroll()
    {
        $session = session();
        if (!$session->get('logged_in')) {
        return redirect()->to(base_url('/'));
        }
        return  view('Layouts/Header')
            . view('Layouts/Sidebar')
            . view('admin/payroll_dashboard')
            . view('Layouts/Footer');
    }

    // public function adm_req()
    // {
    //     return  view('Layouts/Header')
    //         . view('Layouts/Sidebar')
    //         . view('admin/leave_requ')
    //         . view('Layouts/Footer');
    // }

    public function adm_announce()
    {
        $session = session();
        if (!$session->get('logged_in')) {
        return redirect()->to(base_url('/'));
        }
        $Model = new AdminModel();
        $empid = $session->get('emp_id');

        $data['announcement'] = $Model->get_announcement($empid);

        return  view('Layouts/Header')
            . view('Layouts/Sidebar')
            . view('admin/announcement',$data)
            . view('Layouts/Footer');
    }

    public function save_announcement()
    {
        $session = session();

        $Model = new AdminModel();

        $announcement_id = $this->request->getPost('announcement_id');

        $mode = empty($announcement_id) ? 'INSERT' : 'UPDATE';

        $title           = $this->request->getPost('title');
        $message         = $this->request->getPost('message');
        $user_category   = $this->request->getPost('user_category');

        $status          = null;
        $empid           = $session->get('emp_id');

       $Model->save_announcement($mode,$announcement_id,$title,$message,$user_category,$status,$empid);

       if ($mode === 'INSERT') {
           $notifModel = new \App\Models\NotificationModel();
           $notifModel->create_notification(
               'ANNOUNCEMENT',
               'New Announcement: ' . $title,
               $message,
               'ALL',
               null,
               null,
               $empid,
               null
           );
       }

        return $this->response->setJSON([
        'status'  => 'success',
        'message' => ($mode == 'INSERT')
                        ? 'Announcement Added Successfully'
                        : 'Announcement Updated Successfully'
    ]);
    }

    public function delete_announcement()
    {
        $session = session();
        $Model = new AdminModel();

        $announcement_id = $this->request->getPost('announcement_id');
       
        $empid = $session->get('emp_id');

       $Model->save_announcement('DELETE',$announcement_id,null, null, null, null,$empid);
      
       return $this->response->setJSON([
        'status'  => 'success',
        'message' => 'Announcement Deleted Successfully'
    ]);
    }


    

    public function addcandidate()
   {
    $session = session();
    if (!$session->get('logged_in')) {
        return redirect()->to(base_url('/'));
    }

    if ($this->request->getMethod() == 'POST') {

        $file            = $this->request->getFile('offer_letter');
        $candidate_role  = $this->request->getPost('candidate_role');
        $name            = $this->request->getPost('name');
        $email           = $this->request->getPost('email');
        $experience_type = $this->request->getPost('experience_type');

        $experience_json = json_encode([
            [
                "experience_type" => $experience_type
            ]
        ]);
        $mobile   = $this->request->getPost('mobile_no');
        $fileName = '';

        // FILE UPLOAD
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $fileName = $file->getRandomName();
            $file->move('uploads/offer_letters/', $fileName);
        }

        // SESSION VALUE
        $created_by = $session->get('user_category');

        $model = new AdminModel();

        // PROCEDURE CALL
        $result = $model->createCandidate($candidate_role, $name, $email, $mobile, $experience_json, $fileName, $created_by);

        // SUCCESS
        if (isset($result[0]['status']) && $result[0]['status'] == 'Y') {

            $refid = $result[0]['ref_id'];
            $token = $result[0]['password'];
            $onboardingUrl = base_url('on_boarding/verify/' . $refid . '/' . $token);

            // Trigger EmailService
            $emailService = new \App\Libraries\EmailService();

            if ($emailService->sendCandidateOnboardingLink($email, $name, $refid, $token, $onboardingUrl)) {
                return redirect()->back()
                    ->with('success', $result[0]['remarks']);
            } else {
                return redirect()->back()
                    ->with('error', 'Candidate created, but failed to send onboarding email.');
            }
        } else {
            return redirect()->back()
                ->with('error', $result[0]['remarks'] ?? 'Failed to create candidate.');
        }
    }

    return view('Layouts/Header')
        . view('Layouts/Sidebar')
        . view('admin/add_Candidate')
        . view('Layouts/Footer');
}

    public function view_cand()
    {
        $session = session();
       
        if (!$session->get('logged_in')) {
        return redirect()->to(base_url('/'));
        }
        $hr = $session->get('hr');
        $onboarding_status = $this->request->getGet('onboarding_status') ?? 'ALL';
        $offer_status      = $this->request->getGet('offer_status') ?? 'ALL';
        $candidate_type    = $this->request->getGet('candidate_type') ?? 'ALL';
        
        
        $model = new AdminModel();
        $data['details'] = $model->getcandidate('HR',$onboarding_status, $offer_status,$candidate_type);
        //  $data['details'] = $model->getcandidate('HR', 'ALL', 'ALL', 'ALL');

        return view('Layouts/Header')
            . view('Layouts/Sidebar')
            . view('admin/View_candidate', $data)
            . view('Layouts/Footer');
    }

    public function candidate_view($refid)
    {
        $session = session();
        // $refid = $session->get('ref_id');
        if (!$session->get('logged_in')) {
        return redirect()->to(base_url('/'));
        }

        $Model = new AdminModel();
        $model = new OnboardingModel();

        $null  = null;

        $dataArray = $model->getdetails($refid);
        $data['details'] = $dataArray[0] ?? [];

        // Get Managers
        $emp_id = $session->get('emp_id');
        $data['managers'] = $Model->getmgr($emp_id, $null);
        
        $data['holiday'] = $Model->getholidaylist();
       
        return view('Layouts/Header')
            . view('Layouts/Sidebar')
            . view('admin/candidate', $data)
            . view('Layouts/Footer');
    }

    public function saveOrganizationDetails()
    {
        $session = session();
        if (!$session->get('logged_in')) {
        return redirect()->to(base_url('/'));
        }
   

        $Model = new AdminModel();

        $refid = $this->request->getPost('ref_id');

        $data = [
            'department'   => $this->request->getPost('department'),
            'designation'  => $this->request->getPost('designation'),
            'reporting'    => $this->request->getPost('reporting_to'),
            'joining_date' => $this->request->getPost('joining_date'),
            'current_step' => 6
        ];


        $jsonData = json_encode($data);
      
        $result = $Model->updatecand($refid, $jsonData);

        return $this->response->setJSON([
            'status' => 'success',
            'data'   => $result
        ]);
    }


    public function final_submit()
{
    $session = session();
    if (!$session->get('logged_in')) {
        return redirect()->to(base_url('/'));
    }

    $refid = $this->request->getPost('ref_id');
    $empid = $session->get('emp_id');
    $Model = new AdminModel();
    $result = $Model->finalsubmit($refid, $empid);

    $row = $result[0] ?? [];

    // SAFE status fetch (handles both indexed + associative)
    $status = $row['status'] ?? $row[0] ?? null;

    if (!$status) {
        return $this->response->setJSON([
            'status'  => 'N',
            'remarks' => 'No status returned from procedure',
            'debug'   => $row
        ]);
    }

    $status = strtoupper($status);

    if ($status !== 'Y') {
        return $this->response->setJSON([
            'status'  => 'N',
            'remarks' => $row['remarks'] ?? $row[4] ?? 'Approval failed',
            'debug'   => $row
        ]);
    }

    // SAFE mapping (supports both formats)
    $emp_id   = $row['emp_id'] ?? $row[1] ?? '';
    $password = $row['password'] ?? $row[2] ?? '';
    $email    = $row['email'] ?? $row[3] ?? '';
    $remarks  = $row['remarks'] ?? $row[4] ?? '';

    // Send final approval email using custom EmailService
    $emailService = new \App\Libraries\EmailService();
    $loginUrl     = base_url('login');

    if (!$emailService->sendFinalOnboardingApproval($email, $emp_id, $password, $loginUrl)) {
        return $this->response->setJSON([
            'status'  => 'N',
            'remarks' => 'Approved but email failed to send'
        ]);
    }

    return $this->response->setJSON([
        'status'  => 'Y',
        'remarks' => 'Approved and email sent successfully'
    ]);
}


    public function replace_document()
    {

        $session = session();
        if (!$session->get('logged_in')) {
        return redirect()->to(base_url('/'));
        }

        $model = new OnboardingModel();

        $refid = $this->request->getPost('ref_id');
        $key   = $this->request->getPost('key');
        $file  = $this->request->getFile('file');

        $dataArray = $model->getdetails($refid);
        $user = $dataArray[0] ?? null;


        if (!$user) {
            return $this->response->setJSON([
                'status' => 'error',
                'msg' => 'No user found for refid'
            ]);
        }

        if (!$file) {
            return $this->response->setJSON([
                'status' => 'error',
                'msg' => 'File not received'
            ]);
        }

        if (!$file->isValid()) {
            return $this->response->setJSON([
                'status' => 'error',
                'msg' => $file->getErrorString()
            ]);
        }


        $documents = json_decode($user['documents'] ?? '{}', true);

        $folderMap = [
            'profile_photo'    => 'uploads/profile/',
            'aadhaar'          => 'uploads/aadhaar/',
            'pan'              => 'uploads/pancard/',
            'bank_proof'       => 'uploads/Bank_proof/',
            'degree'           => 'uploads/Degree_Certificate/',
            'marks_memo'       => 'uploads/Marks_memo/',
            'provisional'      => 'uploads/Provisional_certificate/',
            'intermediate'     => 'uploads/Intermeditae_Certificate/',
            'ssc'              => 'uploads/SSC_Certificate/',
            'additional'       => 'uploads/Additional_Certificate/',
            'resume'           => 'uploads/Resume/',
            'relieving_letter' => 'uploads/Relieving letter/',
        ];

        if (!isset($folderMap[$key])) {
            return $this->response->setJSON([
                'status' => 'error',
                'msg' => 'Invalid document type'
            ]);
        }

        $path = $folderMap[$key];

        /* Delete old file */
        if (!empty($documents[$key])) {

            $oldFile = FCPATH . $documents[$key];

            if (file_exists($oldFile)) {
                unlink($oldFile);
            }
        }

        /* Create same file name pattern used in onboarding */
        $ext = $file->getExtension();
        $newName = $refid . '_' . $key . '.' . $ext;

        /* Upload new file */
        $file->move(FCPATH . $path, $newName, true);

        /* Update JSON */
        $documents[$key] = $path . $newName;

        // IMPORTANT: use correct key here
        $model->saveStepData($refid, [
            'documents' => $documents
        ], 5);

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Upload successful',
            'path' => $path
        ]);
    }

    public function leave_view($leave_app_id)
    {
        $session = session();
        if (!$session->get('logged_in')) {
        return redirect()->to(base_url('/'));
        }
        $managerModel = new ManagerModel();
        $model = new EmployeeModel();
        $empid = $session->get('emp_id');
        $user_cat = $session->get('current_user_cat');
        $year = date('Y');
        $data['leave'] = $model->get_emp_leave($empid, $year);
        // dd($data['leave']);
        $requests = $managerModel->leave_history($empid, $user_cat, NULL, NULL, NULL);
        $data['leave'] = [];
        foreach ($requests as $row) {
            if (
                isset($row['leave_app_id']) &&
                $row['leave_app_id'] == $leave_app_id
            ) {
                $data['leave'] = $row;
                break;
            }
        }

        $request_empid = $data['leave']['emp_id'] ?? '';

        $data['leave_balance'] = $model->get_emp_leave($request_empid, $year);
        $data['leave_balance'] = $data['leave_balance'][0] ?? [];
        return view('Layouts/Header')
            . view('Layouts/Sidebar')
            . view('admin/leave_requ', $data)
            . view('Layouts/Footer');
    }

    public function adm_req()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to(base_url('/'));
        }
        $model = new EmployeeModel();
        $empid = $session->get('emp_id');

        $rawMonth = $this->request->getGet('month');
        $rawYear  = $this->request->getGet('year');

        if ($rawMonth === 'all' || $rawMonth === '0') {
            $month = null;
        } else {
            $month = ($rawMonth !== null && $rawMonth !== '') ? (int)$rawMonth : (int)date('n');
        }

        if ($rawYear === 'all' || $rawYear === '0') {
            $year = null;
        } else {
            $year = ($rawYear !== null && $rawYear !== '') ? (int)$rawYear : (int)date('Y');
        }

        $data['selectedMonth'] = $month;
        $data['selectedYear']  = $year;
        $data['requests']      = $model->leave_request($empid, $month, $year);
        
        return view('Layouts/Header')
            . view('Layouts/Sidebar')
            . view('admin/Requests', $data)
            . view('Layouts/Footer');
    }

    public function update_punch_time()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to(base_url('/'));
        }

        $model = new EmployeeModel();
        $target_emp_id = $this->request->getPost('target_emp_id');
        $att_date      = $this->request->getPost('attendance_date');
        $first_in_time = $this->request->getPost('first_in_time');
        $last_out_time = $this->request->getPost('last_out_time');
        $request_id    = $this->request->getPost('request_id');
        $actor_emp_id  = $session->get('emp_id');

        $first_in = !empty($first_in_time) ? ($att_date . ' ' . (strlen($first_in_time) == 5 ? $first_in_time . ':00' : $first_in_time)) : null;
        $last_out = !empty($last_out_time) ? ($att_date . ' ' . (strlen($last_out_time) == 5 ? $last_out_time . ':00' : $last_out_time)) : null;

        $result = $model->update_attendance_punch($target_emp_id, $att_date, $first_in, $last_out, $request_id, $actor_emp_id);

        return redirect()->back()
            ->with('status', 'Y')
            ->with('remarks', 'Attendance Punch updated and Request resolved successfully.');
    }

    public function missing_punchout()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to(base_url('/'));
        }

        $model = new EmployeeModel();

        $month      = $this->request->getVar('month');
        $year       = $this->request->getVar('year');
        $emp_id     = $this->request->getVar('emp_id') ?: '';
        $exact_date = $this->request->getVar('exact_date');

        // Check if no filters are applied, default to yesterday
        if ($month === null && $year === null && $exact_date === null && $this->request->getVar('emp_id') === null) {
            $exact_date = date('Y-m-d', strtotime('-1 day'));
        }

        $data['selectedMonth'] = (int)($month ?: date('n'));
        $data['selectedYear']  = (int)($year ?: date('Y'));
        $data['selectedEmp']   = $emp_id;
        $data['selectedDate']  = $exact_date;

        $data['missing_punchouts'] = $model->get_missing_punchouts($month ?: null, $year ?: null, $emp_id, $exact_date);

        $db = \Config\Database::connect();
        $data['employees'] = $db->query("CALL GetActiveUsersForDropdown()")->getResultArray();

        return view('Layouts/Header')
            . view('Layouts/Sidebar')
            . view('admin/missing_punchout', $data)
            . view('Layouts/Footer');
    }

    public function save_missing_punchout()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to(base_url('/'));
        }

        $model = new EmployeeModel();
        $target_emp_id = $this->request->getPost('target_emp_id');
        $att_date      = $this->request->getPost('attendance_date');
        $first_in_time = $this->request->getPost('first_in_time');
        $last_out_time = $this->request->getPost('last_out_time');
        $request_id    = $this->request->getPost('request_id');
        $actor_emp_id  = $session->get('emp_id');

        $first_in = !empty($first_in_time) ? ($att_date . ' ' . (strlen($first_in_time) == 5 ? $first_in_time . ':00' : $first_in_time)) : null;
        $last_out = !empty($last_out_time) ? ($att_date . ' ' . (strlen($last_out_time) == 5 ? $last_out_time . ':00' : $last_out_time)) : null;

        $result = $model->update_attendance_punch($target_emp_id, $att_date, $first_in, $last_out, $request_id, $actor_emp_id);

        $status = (!empty($result) && isset($result[0]['status'])) ? $result[0]['status'] : 'N';
        $remarks = (!empty($result) && isset($result[0]['remarks'])) ? $result[0]['remarks'] : 'Failed to update punch.';

        return redirect()->back()
            ->with('status', $status)
            ->with('remarks', $remarks);
    }

    public function attendance_overview()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to(base_url('/'));
        }

        $month  = $this->request->getVar('month') ?: date('n');
        $year   = $this->request->getVar('year') ?: date('Y');
        $search = $this->request->getVar('search') ?: '';

        $data['selectedMonth'] = (int)$month;
        $data['selectedYear']  = (int)$year;
        $data['search']        = $search;

        if ($month == 1) {
            $startDate = ($year - 1) . '-12-25';
        } else {
            $startDate = $year . '-' . str_pad($month - 1, 2, '0', STR_PAD_LEFT) . '-25';
        }
        $endDate = $year . '-' . str_pad($month, 2, '0', STR_PAD_LEFT) . '-24';

        $searchParam = $search ?: '';
        
        $admin_emp_id = $session->get('emp_id');
        
        $model = new AdminModel();
        $employees = $model->get_attendance_overview($admin_emp_id, $startDate, $endDate, $searchParam);

        foreach ($employees as &$emp) {
            $hrs = floor(($emp['total_work_mins'] ?? 0) / 60);
            $mins = ($emp['total_work_mins'] ?? 0) % 60;
            $emp['total_hours_fmt'] = sprintf('%02dh %02dm', $hrs, $mins);
        }

        $data['employees'] = $employees;

        return view('Layouts/Header')
            . view('Layouts/Sidebar')
            . view('admin/attendance_overview', $data)
            . view('Layouts/Footer');
    }

    public function attendance_details()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to(base_url('/'));
        }

        $emp_id = $this->request->getVar('emp_id') ?: 'BS00293';
        $month  = $this->request->getVar('month') ?: date('n');
        $year   = $this->request->getVar('year') ?: date('Y');

        $data['selectedEmp']   = $emp_id;
        $data['selectedMonth'] = (int)$month;
        $data['selectedYear']  = (int)$year;

        $db = \Config\Database::connect();
        $model = new EmployeeModel();

        $userRow = $db->query("
            SELECT u.*, m.emp_name as manager_name, d.department_name, des.designation_name
            FROM user_details u
            LEFT JOIN user_details m ON u.reporting = m.emp_id
            LEFT JOIN department_master d ON u.department = d.department_id
            LEFT JOIN designation_master des ON u.designation = des.designation_id
            WHERE u.emp_id = '$emp_id'
        ")->getRowArray();

        $data['employee'] = $userRow ?? [
            'emp_id' => $emp_id,
            'emp_name' => 'Employee ' . $emp_id,
            'designation_name' => 'Team Member',
            'manager_name' => 'Manager',
            'department_name' => 'General'
        ];

        $data['attendance'] = $model->get_emp_Attendance($emp_id, $month, $year);

        $data['leave_balances'] = $db->query("CALL get_emp_leave_balances(?, ?)", [$emp_id, $year])->getResultArray();

        $totalWorkMins = 0;
        $presentDays = 0;
        $totalDays = count($data['attendance'] ?? []);

        if (!empty($data['attendance'])) {
            foreach ($data['attendance'] as $row) {
                if (!empty($row['punch_in']) && !empty($row['punch_out'])) {
                    $inTS = strtotime($row['punch_in']);
                    $outTS = strtotime($row['punch_out']);
                    if ($outTS > $inTS) {
                        $totalWorkMins += ($outTS - $inTS) / 60;
                    }
                }
                if (in_array(($row['attendance_status'] ?? ''), ['PRESENT', 'P', 'WFH'])) {
                    $presentDays++;
                }
            }
        }

        $totalHoursFmt = round($totalWorkMins / 60, 1);
        $avgHoursFmt   = ($presentDays > 0) ? round(($totalWorkMins / 60) / $presentDays, 1) : 0;
        $attendancePct = ($totalDays > 0) ? round(($presentDays / $totalDays) * 100, 0) : 0;

        $data['kpi'] = [
            'total_hours'   => $totalHoursFmt,
            'avg_daily_hrs' => $avgHoursFmt,
            'overtime_hrs'  => 0.0,
            'attendance_pct'=> $attendancePct
        ];

        $data['employee_list'] = $db->table('user_details')
            ->select('emp_id, emp_name')
            ->get()
            ->getResultArray();

        return view('Layouts/Header')
            . view('Layouts/Sidebar')
            . view('admin/attendance_details', $data)
            . view('Layouts/Footer');
    }

    /**
     * AJAX endpoint: Admin edits an ABSENT attendance record.
     * POST JSON body:
     *   emp_id, att_date, edit_type (WFH|PL|SL|CL|LOP),
     *   punch_in (HH:MM - WFH only), punch_out (HH:MM - WFH only)
     */
    public function save_absent_edit()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return $this->response->setJSON(['status' => 'N', 'message' => 'Unauthorized']);
        }

        $adminEmpId  = $session->get('emp_id');
        $empId       = $this->request->getPost('emp_id');
        $attDate     = $this->request->getPost('att_date');     // Y-m-d
        $editType    = strtoupper(trim($this->request->getPost('edit_type') ?? ''));
        $punchInRaw  = $this->request->getPost('punch_in')  ?? '';  // HH:MM
        $punchOutRaw = $this->request->getPost('punch_out') ?? '';  // HH:MM

        // ── Basic validation ─────────────────────────────────
        if (empty($empId) || empty($attDate) || empty($editType)) {
            return $this->response->setJSON(['status' => 'N', 'message' => 'Employee ID, Attendance Date, and Edit Type are required.']);
        }

        if (!in_array($editType, ['WFH', 'PL', 'SL', 'ML', 'LOP'])) {
            return $this->response->setJSON(['status' => 'N', 'message' => 'Invalid edit type. Allowed: WFH, PL, SL, ML, LOP.']);
        }

        // ── Build datetime strings for WFH punch timings ────
        $punchIn  = null;
        $punchOut = null;

        if ($editType === 'WFH') {
            if (empty($punchInRaw) || empty($punchOutRaw)) {
                return $this->response->setJSON(['status' => 'N', 'message' => 'Punch In and Punch Out times are required for WFH.']);
            }
            $punchIn  = $attDate . ' ' . (strlen($punchInRaw)  === 5 ? $punchInRaw  . ':00' : $punchInRaw);
            $punchOut = $attDate . ' ' . (strlen($punchOutRaw) === 5 ? $punchOutRaw . ':00' : $punchOutRaw);
        }

        // ── Call model ──────────────────────────────────────
        $model  = new AdminModel();
        $result = $model->admin_edit_absent_attendance(
            $empId,
            $attDate,
            $editType,
            $punchIn,
            $punchOut,
            $adminEmpId
        );

        if ($result['status'] === 'Y') {
            // Automatically recalculate the payroll summary for the affected cycle
            $attTime = strtotime($attDate);
            $day = (int) date('d', $attTime);
            $month = (int) date('m', $attTime);
            $year = (int) date('Y', $attTime);
            
            // If date is >= 25, it belongs to the next month's payroll cycle
            if ($day >= 25) {
                $month += 1;
                if ($month > 12) {
                    $month = 1;
                    $year += 1;
                }
            }
            
            $model->generate_payroll_attendance($month, $year, $adminEmpId);
        }

        return $this->response->setJSON([
            'status'  => $result['status'],
            'message' => $result['message']
        ]);
    }

    /**
     * AJAX endpoint: Admin generates/updates payroll attendance summary.
     * POST JSON body:
     *   month, year
     */
    public function generate_payroll_attendance()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return $this->response->setJSON(['status' => 'N', 'message' => 'Unauthorized']);
        }
        
        if (strtoupper($session->get('user_category')) !== 'ADMIN') {
            return $this->response->setJSON(['status' => 'N', 'message' => 'Only Admin can perform this action.']);
        }

        $adminEmpId = $session->get('emp_id');
        $month      = (int) $this->request->getPost('month');
        $year       = (int) $this->request->getPost('year');

        if (empty($month) || empty($year)) {
            return $this->response->setJSON(['status' => 'N', 'message' => 'Month and Year are required.']);
        }

        $model  = new AdminModel();
        $result = $model->generate_payroll_attendance($month, $year, $adminEmpId);

        return $this->response->setJSON([
            'status'  => $result['status'],
            'message' => $result['message']
        ]);
    }

    /**
     * AJAX endpoint: Finalize payroll attendance
     */
    public function finalize_payroll_attendance()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return $this->response->setJSON(['status' => 'N', 'message' => 'Unauthorized']);
        }
        
        if (strtoupper($session->get('user_category')) !== 'ADMIN') {
            return $this->response->setJSON(['status' => 'N', 'message' => 'Only Admin can perform this action.']);
        }

        $month = (int) $this->request->getPost('month');
        $year  = (int) $this->request->getPost('year');

        if (empty($month) || empty($year)) {
            return $this->response->setJSON(['status' => 'N', 'message' => 'Month and Year are required.']);
        }

        $model = new AdminModel();
        $success = $model->finalize_payroll_attendance($month, $year);

        if ($success) {
            return $this->response->setJSON(['status' => 'Y', 'message' => 'Attendance finalized successfully.']);
        } else {
            return $this->response->setJSON(['status' => 'N', 'message' => 'Failed to finalize attendance.']);
        }
    }

    /**
     * Page: View Payroll Attendance Summary
     */
    public function payroll_attendance()
    {
        $session = session();
        if (!$session->get('logged_in') || strtoupper($session->get('user_category')) !== 'ADMIN') {
            return redirect()->to(base_url('login'));
        }

        $month = (int) $this->request->getPostGet('month') ?: (int) date('m');
        $year  = (int) $this->request->getPostGet('year')  ?: (int) date('Y');

        $model = new AdminModel();
        $records = $model->get_payroll_attendance_data($month, $year);
        $is_finalized = (!empty($records) && $records[0]['is_finalized'] == 'Y') ? true : false;

        $data = [
            'title'         => 'Payroll Attendance',
            'records'       => $records,
            'selectedMonth' => $month,
            'selectedYear'  => $year,
            'is_finalized'  => $is_finalized
        ];

        return view('Layouts/Header')
             . view('Layouts/Sidebar')
             . view('admin/payroll_attendance', $data)
             . view('Layouts/Footer');
    }

    public function update_progress()
    {
        $session = session();
        if (!$session->get('logged_in')) {
        return redirect()->to(base_url('/'));
        }
    $model = new EmployeeModel();

    $request_id = $this->request->getPost('request_id');
    $progress   = $this->request->getPost('progress');
    $empid      = session()->get('emp_id');

    $result = $model->update_requests('UPDATE_PROGRESS', $request_id, $empid, NULL, NULL,NULL,NULL,
    $progress,NULL );

     return redirect()->back()
        ->with('status', 'Y')
        ->with('remarks', 'Progress Updated Successfully');
     }

    public function resolve_request()
    {
        $session = session();
        if (!$session->get('logged_in')) {
        return redirect()->to(base_url('/'));
        }
        $model = new EmployeeModel();

        $request_id = $this->request->getPost('request_id');
        $empid      = session()->get('emp_id');

        $model->update_requests('RESOLVE',$request_id, $empid, NULL, NULL,NULL,NULL,
        NULL,NULL);

        return redirect()->back()
        ->with('status', 'Y')
        ->with('remarks', 'Request Resolved Successfully');
    }

    
    public function leave_balance()
    {
        $session = session();

        if (!$session->get('logged_in')) {
            return redirect()->to(base_url('/'));
        }

        $data['selectedMonth'] = $this->request->getPost('month') ?? date('m');
        $data['selectedYear']  = $this->request->getPost('year') ?? date('Y');
        
        $month = (int)$data['selectedMonth'];
        $year  = $data['selectedYear'];
        $month = 7;
        $year  = 2026;
        $Model = new AdminModel();
        $empid      = session()->get('emp_id');
        
        $data['leave_balance'] = $Model->get_leave_balance($empid,'ALL',$month,$year);
        // $data['leave_balance'] = $Model->get_leave_balance('E001', 'ALL', '7', 2026);

        return view('Layouts/Header')
        . view('Layouts/Sidebar')
        . view('admin/Leave_Balance', $data)
        . view('Layouts/Footer');
    }

    public function month_leave()
    {
        $session = session();

        if (!$session->get('logged_in')) {
            return redirect()->to(base_url('/'));
        }

        $data['selectedMonth'] = $this->request->getPost('month') ?? date('m');
        $data['selectedYear']  = $this->request->getPost('year') ?? date('Y');

        $month = (int)$data['selectedMonth'];
        $year  = $data['selectedYear'];
        
        $Model = new AdminModel();
        $empid      = session()->get('emp_id');

        $data['month'] = $Model->get_month_details($empid,'ALL',$month,$year);

        return view('Layouts/Header')
            . view('Layouts/Sidebar')
            . view('admin/Month_leave_details', $data)
            . view('Layouts/Footer');
        }

        public function adm_view($emp_id)
        {
        $session = session();
        if (!$session->get('logged_in')) {
        return redirect()->to(base_url('/'));
        }
        
        $model = new HomeModel();

        $result = $model->profile($emp_id);

        if (!empty($result)) {
            $data['profile'] = $result[0];
        } else {
            $data['profile'] = [];
        }
    

        return  view('Layouts/Header')
            . view('Layouts/Sidebar')
            . view('admin/emp_view',$data)
            . view('Layouts/Footer');
        }



public function adm_edit($emp_id)
{
    $session = session();
    if (!$session->get('logged_in')) {
        return redirect()->to(base_url('/'));
    }
       
    $model = new HomeModel();
    $result = $model->profile($emp_id);

    if (!empty($result)) {
        $data['profile'] = $result[0];
    } else {
        $data['profile'] = [];
    }
     

    return view('Layouts/Header')
         . view('Layouts/Sidebar')
         . view('admin/emp_edit', $data)
         . view('Layouts/Footer');
}



public function update_employee()
{
    $session = session();
    if (!$session->get('logged_in')) {
        return redirect()->to(base_url('/'));
    }

    $model = new AdminModel();
    
    // 1. Grab EVERYTHING submitted in the POST request
    $postData = $this->request->getPost();

    // 2. Extract the employee ID, then remove it from the array 
    $emp_id = $postData['emp_id'] ?? null;
    unset($postData['emp_id']);
    
    // 3. Security/Logic Check: Did they actually change anything?
    if (empty($postData)) {
        return redirect()->back()->with('success', 'No changes were made.');
    }

    // 4. Convert ONLY the changed fields into a JSON string
   // ================= CURRENT ADDRESS =================
            // Get existing profile
            $homeModel = new HomeModel();
            $profile = $homeModel->profile($emp_id);

            $currentAddress = json_decode($profile[0]['current_address'] ?? '{}', true);

            $currentAddress['city'] = $postData['city'] ?? ($currentAddress['city'] ?? '');
            $currentAddress['state'] = $postData['state'] ?? ($currentAddress['state'] ?? '');
            $currentAddress['pincode'] = $postData['pincode'] ?? ($currentAddress['pincode'] ?? '');
            $currentAddress['area'] = $postData['current_address'] ?? ($currentAddress['area'] ?? '');

            $postData['current_address'] = $currentAddress;

            unset(
                $postData['city'],
                $postData['state'],
                $postData['pincode']
            );

            // ================= QUALIFICATION =================

            // Get existing qualification JSON
$existingQualification = json_decode($profile[0]['qualification'] ?? '[]', true);

// Check whether any education field was edited
$educationChanged =
    isset($postData['qualification']) ||
    isset($postData['specialization']) ||
    isset($postData['institution']) ||
    isset($postData['year_of_pass']) ||
    isset($postData['percentage']) ||
    isset($postData['backlogs']) ||
    isset($postData['inter_institution']) ||
    isset($postData['inter_stream']) ||
    isset($postData['inter_year_of_pass']) ||
    isset($postData['inter_percentage']) ||
    isset($postData['tenth_institution']) ||
    isset($postData['tenth_year_of_pass']) ||
    isset($postData['tenth_percentage']);


    // ================= QUALIFICATION =================

$education = json_decode($profile[0]['qualification'] ?? '[]', true);

if (!is_array($education)) {
    $education = [];
}

foreach ($education as &$edu) {

    $type = strtolower(trim($edu['education_type'] ?? ''));

    if ($type == 'graduation') {

        $edu['qualification'] = $postData['qualification'] ?? ($edu['qualification'] ?? '');
        $edu['specialization'] = $postData['specialization'] ?? ($edu['specialization'] ?? '');
        $edu['institution'] = $postData['institution'] ?? ($edu['institution'] ?? '');
        $edu['year_of_pass'] = $postData['year_of_pass'] ?? ($edu['year_of_pass'] ?? '');

        if (isset($postData['percentage'])) {
            $edu['percentage'] = str_replace('%', '', $postData['percentage']);
        }

        $edu['backlogs'] = $postData['backlogs'] ?? ($edu['backlogs'] ?? '');

    } elseif ($type == 'intermediate') {

        $edu['institution'] = $postData['inter_institution'] ?? ($edu['institution'] ?? '');
        $edu['stream'] = $postData['inter_stream'] ?? ($edu['stream'] ?? '');
        $edu['year_of_pass'] = $postData['inter_year_of_pass'] ?? ($edu['year_of_pass'] ?? '');
        $edu['percentage'] = $postData['inter_percentage'] ?? ($edu['percentage'] ?? '');

    } elseif ($type == '10th' || $type == 'ssc') {

        $edu['institution'] = $postData['tenth_institution'] ?? ($edu['institution'] ?? '');
        $edu['year_of_pass'] = $postData['tenth_year_of_pass'] ?? ($edu['year_of_pass'] ?? '');
        $edu['percentage'] = $postData['tenth_percentage'] ?? ($edu['percentage'] ?? '');
    }
}

unset($edu);

$postData['qualification'] = $education;

unset(
    $postData['specialization'],
    $postData['institution'],
    $postData['year_of_pass'],
    $postData['percentage'],
    $postData['backlogs'],
    $postData['inter_institution'],
    $postData['inter_stream'],
    $postData['inter_year_of_pass'],
    $postData['inter_percentage'],
    $postData['tenth_institution'],
    $postData['tenth_year_of_pass'],
    $postData['tenth_percentage']
);

            // ================= EXPERIENCE =================

$existingExperience = json_decode($profile[0]['experience'] ?? '[]', true);

if (!is_array($existingExperience)) {
    $existingExperience = [];
}

if (isset($postData['experience'])) {

    foreach ($postData['experience'] as $index => $exp) {

        $existingExperience[$index]['company_name']
            = $exp['company_name']
            ?? ($existingExperience[$index]['company_name'] ?? '');

        $existingExperience[$index]['designation']
            = $exp['designation']
            ?? ($existingExperience[$index]['designation'] ?? '');

        $existingExperience[$index]['employment_type']
            = $exp['employment_type']
            ?? ($existingExperience[$index]['employment_type'] ?? '');

        $existingExperience[$index]['total_experience']
            = $exp['total_experience']
            ?? ($existingExperience[$index]['total_experience'] ?? '');

        $existingExperience[$index]['start_date']
            = $exp['start_date']
            ?? ($existingExperience[$index]['start_date'] ?? '');

        $existingExperience[$index]['end_date']
            = $exp['end_date']
            ?? ($existingExperience[$index]['end_date'] ?? '');

        $existingExperience[$index]['skills']
            = $exp['skills']
            ?? ($existingExperience[$index]['skills'] ?? '');

        $existingExperience[$index]['major_projects_delivered']
            = $exp['major_projects_delivered']
            ?? ($existingExperience[$index]['major_projects_delivered'] ?? '');

        $existingExperience[$index]['core_job_responsibilities']
            = $exp['core_job_responsibilities']
            ?? ($existingExperience[$index]['core_job_responsibilities'] ?? '');
    }

    $postData['experience'] = $existingExperience;
}
            // Convert to JSON
            $jsonData = json_encode($postData);

            
                // 5. Send the small JSON delta payload to your Database Procedure
                $result = $model->update_user_details($emp_id, $jsonData);

                if ($result) {
                    return redirect()->back()->with('success', 'Profile updated successfully.');
                } else {
                    return redirect()->back()->with('error', 'Failed to update profile.');
                }
            }

            public function update_document()
            {
                $session = session();

                if (!$session->get('logged_in')) {
                    return $this->response->setJSON([
                        'status'=>'error',
                        'message'=>'Unauthorized'
                    ]);
                }


                $emp_id = $this->request->getPost('emp_id');
                $key    = $this->request->getPost('key');

                $file = $this->request->getFile('file');


                if(!$file || !$file->isValid())
                {
                    return $this->response->setJSON([
                        'status'=>'error',
                        'message'=>'Invalid file'
                    ]);
                }



                // Get employee existing documents
                $homeModel = new HomeModel();

                $profile = $homeModel->profile($emp_id);


                if(empty($profile))
                {
                    return $this->response->setJSON([
                        'status'=>'error',
                        'message'=>'Employee not found'
                    ]);
                }



                $documents = json_decode(
                    $profile[0]['documents'] ?? '{}',
                    true
                );



                /*
                Folder mapping
                */

                $folderMap = [
                    'profile_photo'=>'uploads/profile/',
                    'aadhaar'=>'uploads/aadhaar/',
                    'pan'=>'uploads/pancard/',
                    'bank_proof'=>'uploads/Bank_proof/',
                    'degree'=>'uploads/Degree_Certificate/',
                    'provisional'=>'uploads/Provisional_certificate/',
                    'ssc'=>'uploads/SSC_Certificate/',
                    'resume'=>'uploads/Resume/',
                    'relieving_letter'=>'uploads/Relieving letter/'

                ];


                $folder = $folderMap[$key] ?? 'uploads/documents/';

                $uploadPath = FCPATH.$folder;

                if(!is_dir($uploadPath))
                {
                    mkdir($uploadPath,0777,true);
                }
                // Generate new file name

                $newName = $file->getRandomName();
                // Move file

                $file->move(
                    $uploadPath,
                    $newName
                );
                // Store relative path

                $documents[$key] = $folder.$newName;

                /*
                Send only documents JSON
                to existing procedure
                */

                $updateData = [

                    "documents"=>$documents

                ];

                $jsonData = json_encode($updateData);
                $model = new AdminModel();
                $result = $model->update_user_details($emp_id,$jsonData);

                if($result)
                {

                    return $this->response->setJSON([
                        'status'=>'success',
                        'message'=>'Document replaced successfully'
                    ]);

                }
                else
                {

                    return $this->response->setJSON([
                        'status'=>'error',
                        'message'=>'Update failed'
                    ]);

                }

            }

           public function add_emp()
           {
            $session = session();

            if (!$session->get('logged_in')) {
                return redirect()->to(base_url('/'));
            }

            $Model = new AdminModel();

            // Logged-in employee ID
            $emp_id = $session->get('emp_id');

            // Required parameter for getmgr()
            $null = null;

            // Get Reporting Officers / Managers, Departments, and Designations
            $data['managers'] = $Model->getmgr($emp_id, $null);
            $data['departments'] = $Model->get_departments();
            $data['designations'] = $Model->get_designations();

            return view('Layouts/Header')
                . view('Layouts/Sidebar')
                . view('admin/add_employee', $data)
                . view('Layouts/Footer');
        }

    public function save_employee()
    {
    $session = session();

    if (!$session->get('logged_in')) {
        return redirect()->to(base_url('/'));
    }

    $model = new AdminModel();

    // Logged-in employee/admin ID
    $emp_id = $session->get('emp_id');

    // Get all normal form fields
    $data = $this->request->getPost();

    // Remove confirm field - we don't need to save this in DB
    unset($data['bank_account_no_confirm']);

    // -----------------------------
    // Higher Education Details
    // -----------------------------
    $higherEducation = [];

    $higherDegrees = $this->request->getPost('higher_degree');
    $higherColleges = $this->request->getPost('higher_college');
    $higherYears = $this->request->getPost('higher_year');
    $higherPercentages = $this->request->getPost('higher_percentage');

    if (!empty($higherDegrees)) {

        foreach ($higherDegrees as $key => $degree) {

            $higherEducation[] = [
                'degree'      => $degree,
                'college'     => $higherColleges[$key] ?? '',
                'year'        => $higherYears[$key] ?? '',
                'percentage'  => $higherPercentages[$key] ?? ''
            ];
        }
    }

    $data['higher_education'] = $higherEducation;


    // -----------------------------
    // Previous Experience Details
    // -----------------------------
    $experience = [];

    $expCompany = $this->request->getPost('exp_company');
    $expDesignation = $this->request->getPost('exp_designation');
    $expType = $this->request->getPost('exp_type');
    $expYears = $this->request->getPost('exp_years');
    $expStartDate = $this->request->getPost('exp_start_date');
    $expEndDate = $this->request->getPost('exp_end_date');
    $expCtc = $this->request->getPost('exp_ctc');

    if (!empty($expCompany)) {

        foreach ($expCompany as $key => $company) {

            $experience[] = [
                'company'       => $company,
                'designation'   => $expDesignation[$key] ?? '',
                'employment_type' => $expType[$key] ?? '',
                'years'          => $expYears[$key] ?? '',
                'start_date'     => $expStartDate[$key] ?? '',
                'end_date'       => $expEndDate[$key] ?? '',
                'ctc'            => $expCtc[$key] ?? ''
            ];
        }
    }

    $data['experience'] = $experience;


    // Convert everything to JSON
    $jsonData = json_encode($data);

    // // Call model
    // $result = $model->add_new_employee($emp_id, $jsonData);

    // // Check result
    // if ($result) {

    //     $session->setFlashdata(
    //         'success',
    //         'Employee details saved successfully.'
    //     );

    //     return redirect()->to(base_url('admin/add_employee'));

    // } else {

    //     $session->setFlashdata(
    //         'error',
    //         'Unable to save employee details.'
    //     );

    //     return redirect()->back()->withInput();
    // Call model
$result = $model->add_new_employee($emp_id, $jsonData);

// ------------------------------------
// Check backend response
// ------------------------------------
if (!empty($result) && isset($result[0])) {

    $status        = $result[0]['status'] ?? 'N';
    $resultEmpId   = $result[0]['emp_id'] ?? null;
    $tempPassword  = $result[0]['temp_password'] ?? '';
    $email         = $result[0]['email'] ?? '';
    $remarks       = $result[0]['remarks'] ?? '';

    // ------------------------------------
    // STATUS = Y → Success
    // ------------------------------------
    if ($status === 'Y') {

        // Send final approval email
        $emailService = new \App\Libraries\EmailService();
        $loginUrl     = base_url('login');

        $emailSent = $emailService->sendFinalOnboardingApproval(
            $email,
            $resultEmpId,
            $tempPassword,
            $loginUrl
        );

        // Email failed
        if (!$emailSent) {

            $session->setFlashdata(
                'error',
                'Employee saved successfully, but email failed to send.'
            );

            return redirect()->to(base_url('admin/add_employee'));
        }

        // Email sent successfully
        $session->setFlashdata(
            'success',
            $remarks
        );

        return redirect()->to(base_url('admin/add_employee'));
    }

    // ------------------------------------
    // STATUS != Y → Backend failure
    // ------------------------------------
    $session->setFlashdata(
        'error',
        $remarks
    );

    return redirect()->back()->withInput();
}


// ------------------------------------
// No response from backend
// ------------------------------------
$session->setFlashdata(
    'error',
    'Unable to process employee details.'
);

return redirect()->back()->withInput();
  }


}


