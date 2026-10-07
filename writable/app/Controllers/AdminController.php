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
        // echo '<pre>';
        // print_r($data['holiday']);
        // exit;
        // dd($data['holiday']);
        $data['adm_dash'] = $Model->get_adm_dash($emp_id, $user_category);
        // echo '<pre>';
        // print_r($data['adm_dash']);
        // exit;
        $data['birthday'] = $Model->get_birthday();
        // echo '<pre>';
        // print_r($data['birthday']);
        // exit;
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
        // echo '<pre>';
        // print_r($data['holiday']);
        // exit;
        // dd($data['holiday']);
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
        // echo '<pre>';
        // print_r($data['department']);
        // exit;
   
        return  view('Layouts/Header')
            . view('Layouts/Sidebar')
            . view('admin/deparment',$data)
            . view('Layouts/Footer');
    }

    public function adm_emp()
    {
        $session = session();
        if (!$session->get('logged_in')) {
        return redirect()->to(base_url('/'));
        }
        $managerModel = new ManagerModel();
        $empid = $session->get('emp_id');
        $user_category = $session->get('user_category');

        $data['employee'] = $managerModel->employee_details($empid, $user_category, 'ALL');
      
        // echo '<pre>';
        // print_r($data['employee']);
        // exit;
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
        return  view('Layouts/Header')
            . view('Layouts/Sidebar')
            . view('admin/attendance_dashboard')
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
        $user_category = $session->get('user_category');
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
        // echo '<pre>';
        // print_r($data['announcement']);
        // exit;

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
        // echo $announcement_id;
        // exit;
        $empid = $session->get('emp_id');

       $Model->save_announcement('DELETE',$announcement_id,null, null, null, null,$empid);
        // echo '<pre>';
        // print_r($result);
        // exit;
       return $this->response->setJSON([
        'status'  => 'success',
        'message' => 'Announcement Deleted Successfully'
    ]);
    }


    // public function adm_change_pwd()
    // {
    //     $session = session();
    //     if (!$session->get('logged_in')) {
    //     return redirect()->to(base_url('/'));
    //     }
    //     return  view('Layouts/Header')
    //         . view('Layouts/Sidebar')
    //         . view('admin/change_password')
    //         . view('Layouts/Footer');
    // }

    // public function addcandidate()
    // {
    //     $session = session();
    //     if (!$session->get('logged_in')) {
    //     return redirect()->to(base_url('/'));
    //     }
    //     if ($this->request->getMethod() == 'POST') {

    //         $file = $this->request->getFile('offer_letter');
    //         $candidate_role   = $this->request->getPost('candidate_role');
    //         $name             = $this->request->getPost('name');
    //         $email            = $this->request->getPost('email');
    //         $experience_type = $this->request->getPost('experience_type');

    //         $experience_json = json_encode([
    //             [
    //                 "experience_type" => $experience_type
    //             ]
    //         ]);
    //         $mobile           = $this->request->getPost('mobile_no');
    //         $fileName = '';

    //         // echo '<pre>';
    //         // print_r($this->request->getPost());
    //         // exit;


    //         // FILE UPLOAD
    //         if ($file && $file->isValid() && !$file->hasMoved()) {

    //             $fileName = $file->getRandomName();

    //             $file->move('uploads/offer_letters/', $fileName);
    //         }

    //         // SESSION VALUE
    //         $created_by = $session->get('user_category');

    //         $model = new AdminModel();

    //         // PROCEDURE CALL
    //         $result = $model->createCandidate($candidate_role, $name, $email, $mobile, $experience_json, $fileName, $created_by);


    //         // SUCCESS
    //         if ($result[0]['status'] == 'Y') {

    //             $refid = $result[0]['ref_id'];
    //             $token = $result[0]['password'];

    //             // EMAIL SERVICE
    //             $emailService = \Config\Services::email();

    //             $emailService->setTo($email);

    //             $emailService->setSubject('Candidate Onboarding Details');

    //             $message = "
    //                         Dear $name,<br><br>

    //                         Your onboarding account has been created successfully.<br><br>

    //                         <b>Reference ID :</b> $refid<br>
    //                         <b>Token :</b> $token<br><br>

    //                         <b>Onboarding URL :</b><br>

    //                         <a href='" . base_url('on_boarding/verify/' . $refid . '/' . $token) . "'>
    //                         " . base_url('on_boarding/verify/' . $refid . '/' . $token) . "
    //                         </a><br><br>

    //                         Regards,<br>
    //                         Bloom Solutions
    //                         ";

    //             $emailService->setMessage($message);

    //             $emailService->send();

    //             return redirect()->back()
    //                 ->with('success', $result[0]['remarks']);
    //         } else {

    //             return redirect()->back()
    //                 ->with('error', $result[0]['remarks']);
    //         }
    //     }

    //     return view('Layouts/Header')
    //         . view('Layouts/Sidebar')
    //         . view('admin/add_Candidate')
    //         . view('Layouts/Footer');
    // }

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
        // echo "<pre>";
        // print_r(session()->get());
        // exit;
        if (!$session->get('logged_in')) {
        return redirect()->to(base_url('/'));
        }
        $hr = $session->get('hr');
        $onboarding_status = $this->request->getGet('onboarding_status') ?? 'ALL';
        $offer_status      = $this->request->getGet('offer_status') ?? 'ALL';
        $candidate_type    = $this->request->getGet('candidate_type') ?? 'ALL';
        // echo "<pre>";
        // print_r($this->request->getGet());
        // exit;
        
        $model = new AdminModel();
        $data['details'] = $model->getcandidate('HR',$onboarding_status, $offer_status,$candidate_type);
        //  $data['details'] = $model->getcandidate('HR', 'ALL', 'ALL', 'ALL');
        // echo '<pre>';
        // print_r($data['details']);
        // echo '</pre>';
        // exit;

//         echo "<pre>";
// echo "HR = ";
// var_dump($hr);

// echo "Onboarding = ";
// var_dump($onboarding_status);

// echo "Offer = ";
// var_dump($offer_status);

// echo "Type = ";
// var_dump($candidate_type);
// exit;

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
        // echo '<pre>';
        // print_r($data['details']);
        // exit;

        // Get Managers
        $emp_id = $session->get('emp_id');
        $data['managers'] = $Model->getmgr($emp_id, $null);
        // echo '<pre>';
        // print_r($data['managers']);
        // exit;
        $data['holiday'] = $Model->getholidaylist();
        // echo '<pre>';
        // print_r($data['holiday']);
        // exit;
        // dd($data['holiday']);
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
    // echo "<pre>";
    // print_r($this->request->getPost());
    // exit;

        $Model = new AdminModel();

        $refid = $this->request->getPost('ref_id');

        $data = [
            'department'   => $this->request->getPost('department'),
            'designation'  => $this->request->getPost('designation'),
            'reporting'    => $this->request->getPost('reporting_to'),
            'joining_date' => $this->request->getPost('joining_date'),
            'current_step' => 6
        ];

//         echo "<pre>";
// print_r($data);
// echo json_encode($data);
// exit;

        $jsonData = json_encode($data);
        // echo $jsonData;
        // exit;

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
        $user_cat = $session->get('user_category');
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
        $data['requests'] = $model->leave_request($empid);
        // dd($data['requests']);
        // echo '<pre>';
        // print_r($data['requests']);
        // exit;
        return  view('Layouts/Header')
            . view('Layouts/Sidebar')
            . view('admin/Requests',$data)
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
        // dd($month);
        $month = 7;
        $year  = 2026;
        $Model = new AdminModel();
        $empid      = session()->get('emp_id');
        
        $data['leave_balance'] = $Model->get_leave_balance($empid,'ALL',$month,$year);
        // $data['leave_balance'] = $Model->get_leave_balance('E001', 'ALL', '7', 2026);
//      var_dump($empid);
// var_dump($month);
// var_dump($year);
// exit;
        // echo '<pre>';
        // print_r($data['leave_balance']);
        // exit;

//         echo '<pre>';
// print_r($data['leave_balance']);
// exit;
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
        // dd($month);
        // $month = 7;
        // $year  = 2026;
        $Model = new AdminModel();
        $empid      = session()->get('emp_id');

        $data['month'] = $Model->get_month_details($empid,'ALL',$month,$year);

        // echo '<pre>';
        // print_r($data['month']);
        // exit;

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
        // echo '<pre>';
        // print_r($data['profile']);
        // echo '</pre>';
        // exit;

        return  view('Layouts/Header')
            . view('Layouts/Sidebar')
            . view('admin/emp_view',$data)
            . view('Layouts/Footer');
        }

//         public function adm_edit($emp_id)
//         {
//            $session = session();
//            if (!$session->get('logged_in')) {
//            return redirect()->to(base_url('/'));
//            }
                
//             $model = new HomeModel();

//             $result = $model->profile($emp_id);

//             if (!empty($result)) {
//               $data['profile'] = $result[0];
//             } else {
//               $data['profile'] = [];
//             }
//                 // echo '<pre>';
//                 // print_r($data['profile']);
//                 // echo '</pre>';
//                 // exit;
//             return  view('Layouts/Header')
//                 . view('Layouts/Sidebar')
//                 . view('admin/emp_edit',$data)
//                 . view('Layouts/Footer');
//         }

//         public function update_employee()
//         {
//             $model = new AdminModel();
//             $emp_id = $this->request->getPost('emp_id');
//             $homeModel = new HomeModel();

//             $profile = $homeModel->profile($emp_id);

//             $profile = !empty($profile) ? $profile[0] : [];

//             $data = [
//     'ref_id'            => $profile['ref_id'] ?? '',
//     'emp_name'          => $this->request->getPost('emp_name') ?: ($profile['emp_name'] ?? ''),
//     'email'             => $this->request->getPost('email') ?: ($profile['email'] ?? ''),
//     'mobile'            => $this->request->getPost('mobile') ?: ($profile['mobile'] ?? ''),
//     'dob'               => $this->request->getPost('dob') ?: ($profile['dob'] ?? ''),
//     'gender'            => $this->request->getPost('gender') ?: ($profile['gender'] ?? ''),
//     'marital_status'    => $this->request->getPost('marital_status') ?: ($profile['marital_status'] ?? ''),
//     'father_name'       => $this->request->getPost('father_name') ?: ($profile['father_name'] ?? ''),
//     'mother_name'       => $this->request->getPost('mother_name') ?: ($profile['mother_name'] ?? ''),
//     'current_address'   => $this->request->getPost('current_address') ?: ($profile['current_address'] ?? ''),
//     'perminent_address' => $this->request->getPost('perminent_address') ?: ($profile['perminent_address'] ?? ''),
//     'bank_holder_name'  => $this->request->getPost('bank_holder_name') ?: ($profile['bank_holder_name'] ?? ''),
//     'bank_name'         => $this->request->getPost('bank_name') ?: ($profile['bank_name'] ?? ''),
//     'bank_branch'       => $this->request->getPost('bank_branch') ?: ($profile['bank_branch'] ?? ''),
//     'bank_account_no'   => $this->request->getPost('bank_account_no') ?: ($profile['bank_account_no'] ?? ''),
//     'ifsc'              => $this->request->getPost('ifsc') ?: ($profile['ifsc'] ?? ''),
//     'upi_id'            => $this->request->getPost('upi_id') ?: ($profile['upi_id'] ?? ''),
//     'bank_account_type' => $this->request->getPost('bank_account_type') ?: ($profile['bank_account_type'] ?? ''),
//     'pan'               => $this->request->getPost('pan') ?: ($profile['pan'] ?? ''),
//     'aadhaar'           => $this->request->getPost('aadhaar') ?: ($profile['aadhaar'] ?? ''),
//     'uan'               => $this->request->getPost('uan') ?: ($profile['uan'] ?? ''),
//     'skills'            => $profile['skills'] ?? '',
//     'qualification'     => $profile['qualification'] ?? '',
//     'experience'        => $profile['experience'] ?? '',
//     'documents'         => $profile['documents'] ?? '',
//     'department'        => $profile['department'] ?? '',
//     'designation'       => $profile['designation'] ?? '',
//     'reporting'         => $profile['reporting'] ?? '',
//     'joining_date'      => $profile['joining_date'] ?? '',
//     'received_ondatetime' => $profile['received_ondatetime'] ?? '',
//     'at_blooms'         => $profile['at_blooms'] ?? '',
//     'profisional_details_status' => $profile['profisional_details_status'] ?? ''
// ];

//              $jsonData = json_encode($data);
//             // echo "<pre>";
//             // print_r($data);
//             // echo "</pre>";

//             // echo $jsonData;
//             // exit;

//             $result = $model->update_user_details($emp_id, $jsonData);

//             if ($result) {
//                 return redirect()->back()->with('success', 'Profile updated successfully.');
//             } else {
//                 return redirect()->back()->with('error', 'Failed to update profile.');
//             }
//         }


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
     
    // echo '<pre>';
    //     print_r($data['profile']);
    //     echo '</pre>';
    //     exit;
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

            // Debug (remove after testing)
            // echo "<pre>";
            // print_r($postData);

            // echo "\n\nJSON:\n";
            // echo $jsonData;
            // exit;

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

      }
