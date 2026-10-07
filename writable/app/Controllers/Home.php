<?php

namespace App\Controllers;

use App\Libraries\EmailService;

use App\Models\HomeModel;
use App\Models\AdminModel; //Admin Model
use App\Models\OnboardingModel; //OnboardingModel

class Home extends BaseController
{
    public function index(): string
    {
        return view('aut_pages/login');
    }

    public function login()
    {
        $session = session();
        
        $model = new HomeModel();

        $staffId = $this->request->getPost('staff_id');
        $password = $this->request->getPost('password');

        $user = $model->authenticateUser($staffId, $password);
        // dd($user);
        // Check user exists
        if (!empty($user) && $user[0]['status'] == 'Y') {
            $userData = $user[0];
            $session->setFlashdata('status', $userData['status']);
            $session->setFlashdata('remarks', $userData['remarks']);
            // Session Creation
            $session->set([
                'logged_in'      => true,
                'emp_id'         => $userData['emp_id'],
                'emp_name'       => $userData['emp_name'],
                'user_category'  => $userData['user_category'], // Original role (never changes)
                'current_user_cat'  => $userData['user_category'], // Temporary switched role
                'hr'              => $userData['emp_id'] ,
                'first_login'    => $userData['is_first_login'],
                 'gender'           => strtoupper($userData['gender']) // MALE / FEMALE
                // 'ref_id'         => $userData['ref_id']
            ]);

            // FIRST LOGIN CHECK
            if ($userData['is_first_login'] == 1) {
                return redirect()->to(base_url('first_login'));
            }

            // Role Based Redirect
            switch ($userData['user_category']) {
                case 'ADMIN':
                    return redirect()->to(base_url('admin/adm_dashboard'))
                         ->with('status', $userData['status'])
                         ->with(
                            'remarks',
                            strtolower($userData['remarks']) == 'success'
                              ? 'Login Successful'
                              : $userData['remarks']
                          );

                case 'EMP':
                case 'HR':
                case 'MANAGER':
                case 'INTERN' :
                    return redirect()->to(base_url('employee/Emp_dashboard'))
                        ->with('status', $userData['status'])
                       ->with(
                          'remarks',
                          strtolower($userData['remarks']) == 'success'
                             ? 'Login Successful'
                             : $userData['remarks']
                          );

                default:
                    $session->destroy();
                    return redirect()->back()->with('error', 'Invalid User Type');
            }
        }

        return redirect()->back()->with('error', $user[0]['remarks'] ?? 'Invalid Employee ID or Password.');
    }

    public function first_login()
    {
        return view('aut_pages/First_login');
    }

    public function update_password()
   {
    $session = session();

    if (!$session->get('logged_in')) {
        return redirect()->to(base_url('/'));
    }

    $model = new HomeModel();

    $empId = $session->get('emp_id');
    $oldPassword = $this->request->getPost('old_password');
    $newPassword = $this->request->getPost('new_password');

    // PROCEDURE CALL
    $result = $model->changePassword(
        $empId,
        $oldPassword,
        $newPassword
    );

    // SAFE extraction
    $status  = $result[0]['status'] ?? null;
    $remarks = $result[0]['remarks'] ?? null;

    if (!empty($result) && strtoupper($status) === 'Y') {

        return redirect()->to(base_url('/'))->with(
            'success',
            $remarks ?: 'Password changed successfully'
        );

    } else {

        return redirect()->back()->with(
            'error',
            $remarks ?: 'Password change failed'
        );
    }
  }
    public function forgotPasswordPage()
    {
        return view('aut_pages/forgot');
    }

    public function logout()
    {
        session()->destroy();

        return redirect()->to(base_url('/'));
    }

    public function profile()
    {
       $session = session();
       if (!$session->get('logged_in')) {
       return redirect()->to(base_url('/'));
       } 
        $emp_id = $session->get('emp_id');

        $model = new HomeModel();

        $result = $model->profile($emp_id);
        $data['profile'] = $result[0];
        // dd($data['profile']);
        // echo '<pre>';
        // print_r($data['profile']);
        // exit;
        return view('Layouts/Header')
            . view('Layouts/Sidebar')
            . view('aut_pages/profile', $data)
            . view('Layouts/Footer');
    }

//  public function forgotPassword()
// {
//     helper(['form', 'url']);

//     if ($this->request->is('post')) {
//         $userId = $this->request->getPost('emp_id');

//         if (!empty($userId)) {
//             $model = new HomeModel();
//             $user  = $model->profile($userId);

//             if ($user && isset($user[0]['email'])) {
//                 $email   = $user[0]['email'];
//                 $empName = $user[0]['emp_name'];

//                 // Generate cryptographically secure token
//                 $token = bin2hex(random_bytes(16));

//                 // Store token in DB
//                 $model->Token($userId, $token);

//                 // Create reset URL
//                 $resetLink = base_url('resetpwd?token=' . $token . '&emp_id=' . $userId);

//                 $emailService = \Config\Services::email();
//                 $emailService->clear(true); // Reset state

//                 $emailService->setMailType('html');
//                 $emailService->setFrom('myhr@bloomsolutions.in', 'Bloom HRMS');
//                 $emailService->setTo($email);
//                 $emailService->setSubject('Reset Password');
//                 $emailService->setMessage("
//                     Hello {$empName},<br><br>
//                     Click the link below to reset your password:<br><br>
//                     <a href='{$resetLink}'>{$resetLink}</a><br><br>
//                     If you did not request this, please ignore this email.<br><br>
//                     Regards,<br>
//                     HRMS Team
//                 ");

//                 if ($emailService->send()) {
//                     return redirect()->to('/login')->with('success', 'Reset link sent to your email.');
//                 } else {
//                     return redirect()->back()->with('error', 'Email sending failed.');
//                 }
//             }
//                 else {
//                 return redirect()->back()
//                     ->with('error', 'User email not found.');
//             }
//         }
//     }

//     return view('aut_pages/forgot');
// }

public function forgotPassword()
    {
        helper(['form', 'url']);

        if ($this->request->is('post')) {
            $userId = $this->request->getPost('emp_id');

            if (!empty($userId)) {
                $model = new HomeModel();
                $user  = $model->profile($userId);

                if ($user && isset($user[0]['email'])) {
                    $email   = $user[0]['email'];
                    $empName = $user[0]['emp_name'];

                    // 1. Generate secure token & save to DB
                    $token     = bin2hex(random_bytes(16));
                    $model->Token($userId, $token);

                    // 2. Build reset URL
                    $resetLink = base_url('resetpwd?token=' . $token . '&emp_id=' . $userId);

                    // 3. Trigger Email Service
                    $emailService = new EmailService();

                    if ($emailService->sendPasswordReset($email, $empName, $resetLink)) {
                        return redirect()->to('/login')
                            ->with('success', 'Password reset link sent to your email.');
                    } else {
                        return redirect()->back()
                            ->with('error', 'Failed to send email. Please try again or contact support.');
                    }
                } else {
                    return redirect()->back()
                        ->with('error', 'Employee ID or email address not found.');
                }
            } else {
                return redirect()->back()
                    ->with('error', 'Please enter your Employee ID.');
            }
        }

        return view('aut_pages/forgot');
    }



    public function resetpwd()
    {
       
        $token = $this->request->getGet('token');
        $empId = $this->request->getGet('emp_id');

        // validate token here

        return view('aut_pages/Reset_pwd', [
            'token' => $token,
            'emp_id' => $empId
        ]);
    }

    public function resetForgotPassword()
    {
        

        $empId = $this->request->getPost('emp_id');
        $token = $this->request->getPost('token');
        $newPassword = $this->request->getPost('new_password');

        $model = new HomeModel();

        $result = $model->changeForgotPassword($empId, null, $newPassword, $token, true);
        $result = $result[0] ?? [];

        if (($result['status'] ?? '') === 'Y') {

            return redirect()->to('/login')
                ->with('success', $result['remarks'] ?? 'Password updated successfully.');

        } else {

            return redirect()->to('/forgot-password')
                ->with('error', $result['remarks'] ?? 'Invalid or expired token.');
        }
        
    }

    public function change_pwd()
    {
       $session = session();
       if (!$session->get('logged_in')) {
       return redirect()->to(base_url('/'));
       } 

        if ($this->request->getMethod(true) === 'GET') {

            return view('Layouts/Header')
                . view('Layouts/Sidebar')
                . view('aut_pages/change_password')
                . view('Layouts/Footer');
        }

        if ($this->request->getMethod(true) === 'POST') {

            $empId = session()->get('emp_id');

            $oldPassword = $this->request->getPost('old_password');
            $newPassword = $this->request->getPost('new_password');
            $confirmPassword = $this->request->getPost('confirm_password');

            if ($newPassword != $confirmPassword) {

                return redirect()->back()->with(
                    'error',
                    'Passwords do not match'
                );
            }

            $model = new HomeModel();

            $result = $model->changePassword(
                        $empId,
                        $oldPassword,
                        $newPassword
                    );

                    $status  = $result[0]['status'] ?? 'N';
                    $remarks = $result[0]['remarks'] ?? '';

                    if (strtoupper($status) == 'Y') {

                        return redirect()->back()->with(
                            'success',
                            $remarks
                        );

                    } else {

                        return redirect()->back()->with(
                            'error',
                            $remarks
                        );
                    }
        }
    }

    public function adm_help()
    {
        $session = session();
        if (!$session->get('logged_in')) {
        return redirect()->to(base_url('/'));
        }
        return  view('Layouts/Header')
            . view('Layouts/Sidebar')
            . view('aut_pages/help')
            . view('Layouts/Footer');
    }

    public function adm_pol()
    {
        $session = session();
        if (!$session->get('logged_in')) {
        return redirect()->to(base_url('/'));
        } 
        return  view('Layouts/Header')
            . view('Layouts/Sidebar')
            . view('aut_pages/polices')
            . view('Layouts/Footer');
    }

    public function holiday()
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
        return   view('Layouts/Header')
            . view('Layouts/Sidebar')
            . view('aut_pages/holidays', $data)
            . view('Layouts/Footer');
    }

    public function Coming_soon(){

     return   view('Layouts/Header')
            . view('Layouts/Sidebar')
            . view('aut_pages/comingsoon')
            . view('Layouts/Footer');

    }

   public function profile_updation()
   {
        $session = session();
        $emp_id = $session->get('emp_id');
        $model = new HomeModel();

        $result = $model->profile($emp_id);
        $data['profile'] = $result[0];
        $existingDocuments = json_decode($data['profile']['documents'] ?? '{}', true);

        $profilePhotoPath = $existingDocuments['profile_photo'] ?? '';
        $aadhaarPath      = $existingDocuments['aadhaar_doc'] ?? '';
        $panPath          = $existingDocuments['pan_doc'] ?? '';
        $degreePath       = $existingDocuments['degree_certificate'] ?? '';
        $interPath        = $existingDocuments['intermediate_certificate'] ?? '';
        $sscPath          = $existingDocuments['ssc_certificate'] ?? '';
        // echo '<pre>';
        // print_r($data['profile']);
        // echo '</pre>';
        // exit;
        if ($this->request->getMethod() === 'POST') {
            $rules = [
                'emp_name' => 'required|min_length[3]',
                'mobile' => 'required|exact_length[10]|numeric',
                'email' => 'required|valid_email',
                'aadhaar' => 'required|exact_length[12]|numeric',
                'pan' => 'required|alpha_numeric|exact_length[10]',
                'bank_account_no' => 'required|numeric',
                'bank_account_no_confirm' => 'required|matches[bank_account_no]',
                'ifsc' => 'required|alpha_numeric|exact_length[11]',
                // 'aadhaar_doc' => 'uploaded[aadhaar_doc]|max_size[aadhaar_doc,2048]|ext_in[aadhaar_doc,pdf,jpg,jpeg,png]',
                // 'pan_doc' => 'uploaded[pan_doc]|max_size[pan_doc,2048]|ext_in[pan_doc,pdf,jpg,jpeg,png]'
            ];
 
            if (!$this->validate($rules)) {
    return redirect()->back()
        ->withInput()
        ->with('errors', $this->validator->getErrors());
        }

        // Define upload path
        $uploadPath = FCPATH . 'uploads/profile_docs/';
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        // Upload Aadhaar
        
        $aadhaarDoc = $this->request->getFile('aadhaar_doc');
        if ($aadhaarDoc && $aadhaarDoc->isValid() && !$aadhaarDoc->hasMoved()) {
            $extension = $aadhaarDoc->getExtension();
            $fileName  = $emp_id . "_aadhaar." . $extension;
            $aadhaarDoc->move(FCPATH . 'uploads/aadhaar/', $fileName);
            $aadhaarPath = 'uploads/aadhaar/' . $fileName;
        }

        // Upload PAN
    
        $panDoc = $this->request->getFile('pan_doc');
        if ($panDoc && $panDoc->isValid() && !$panDoc->hasMoved()) {
            $extension = $panDoc->getExtension();
            $fileName  = $emp_id . "_pan." . $extension;
            $panDoc->move(FCPATH . 'uploads/pancard/', $fileName);
            $panPath = 'uploads/pancard/' . $fileName;
        }

        // PROFILE PHOTO
    
        $profilePhoto = $this->request->getFile('profile_photo');
        if ($profilePhoto && $profilePhoto->isValid() && !$profilePhoto->hasMoved()) {
            $extension = $profilePhoto->getExtension();
            $fileName  = $emp_id . "_profile." . $extension;
            $profilePhoto->move(FCPATH . 'uploads/profile/', $fileName);
            $profilePhotoPath = 'uploads/profile/' . $fileName;
        }

        // Degree Certificate
        
        $degreeDoc = $this->request->getFile('grad_cert');
        if ($degreeDoc && $degreeDoc->isValid() && !$degreeDoc->hasMoved()) {
            $ext = $degreeDoc->getExtension();
            $fileName = $emp_id . "." . $ext;
            $degreeDoc->move(FCPATH . 'uploads/Degree_Certificate/', $fileName);
            $degreePath = "uploads/Degree_Certificate/" . $fileName;
        }

        // Intermediate Certificate
      
        $interDoc = $this->request->getFile('inter_cert');
        if ($interDoc && $interDoc->isValid() && !$interDoc->hasMoved()) {
            $ext = $interDoc->getExtension();
            $fileName = $emp_id . "." . $ext;
            $interDoc->move(FCPATH . 'uploads/Intermeditae_Certificate/', $fileName);
            $interPath = "uploads/Intermeditae_Certificate/" . $fileName;
        }

        // SSC Certificate
       
        $sscDoc = $this->request->getFile('tenth_cert');
        if ($sscDoc && $sscDoc->isValid() && !$sscDoc->hasMoved()) {
            $ext = $sscDoc->getExtension();
            $fileName = $emp_id . "." . $ext;
            $sscDoc->move(FCPATH . 'uploads/SSC_Certificate/', $fileName);
            $sscPath = "uploads/SSC_Certificate/" . $fileName;
        }
        // Create JSON
        // $existingQualification = json_decode($data['profile']['qualification'] ?? '[]', true);
        // $qualification = $existingQualification;
        /* GRADUATION */
        $qualification = [];

$qualification[] = [
    "education_type" => "graduation",
    "institution"    => $this->request->getPost('institution'),
    "degree"         => $this->request->getPost('degree'),
    "year_of_pass"   => $this->request->getPost('year_of_pass'),
    "percentage"     => $this->request->getPost('percentage')
];

$qualification[] = [
    "education_type" => "intermediate",
    "institution"    => $this->request->getPost('inter_college'),
    "board"          => $this->request->getPost('inter_board'),
    "year_of_pass"   => $this->request->getPost('inter_year'),
    "percentage"     => $this->request->getPost('inter_percentage')
];

$qualification[] = [
    "education_type" => "10th",
    "institution"    => $this->request->getPost('tenth_school'),
    "board"          => $this->request->getPost('tenth_board'),
    "year_of_pass"   => $this->request->getPost('tenth_year'),
    "percentage"     => $this->request->getPost('tenth_percentage')
];


        $higher_degree     = $this->request->getPost('higher_degree');
        $higher_college    = $this->request->getPost('higher_college');
        $higher_year       = $this->request->getPost('higher_year');
        $higher_percentage = $this->request->getPost('higher_percentage');

        $higherEducation = [];

        if (!empty($higher_degree)) {
            for ($i = 0; $i < count($higher_degree); $i++) {
                $higherEducation[] = [
                    "education_type" => "higher",
                    "degree" => $higher_degree[$i],
                    "college" => $higher_college[$i],
                    "year" => $higher_year[$i],
                    "percentage" => $higher_percentage[$i]
                ];
            }
        }
        foreach ($higherEducation as $h) {
            $qualification[] = $h;
        }
        $exp_company = $this->request->getPost('exp_company');

        $experience = [];

        if (!empty($exp_company)) {
            for ($i = 0; $i < count($exp_company); $i++) {
                $experience[] = [
                    "company_name"     => $exp_company[$i],
                    "designation"      => $this->request->getPost('exp_designation')[$i],
                    "employment_type"  => $this->request->getPost('exp_type')[$i],
                    "total_experience" => $this->request->getPost('exp_years')[$i],
                    "start_date"       => $this->request->getPost('exp_start_date')[$i],
                    "end_date"         => $this->request->getPost('exp_end_date')[$i],
                    "current_ctc"      => $this->request->getPost('exp_ctc')[$i]
                ];
            }
        }

       $documents = [
            "profile_photo" => $profilePhotoPath,
            "aadhaar_doc"   => $aadhaarPath,
            "pan_doc"       => $panPath,
            "degree_certificate" => $degreePath,
            "intermediate_certificate" => $interPath,
            "ssc_certificate" => $sscPath
        ];

        $currentAddress = [
                "houseNo"  => $this->request->getPost('house_number'),
                "area"     => $this->request->getPost('area_town'),
                "streetNo" => $this->request->getPost('district'),
                "city"     => $this->request->getPost('city'),
                "state"    => $this->request->getPost('state'),
                "pin_code" => $this->request->getPost('Pincode'),
            ];

        $profileData = [
            "dob"           => $this->request->getPost('dob'),
            "father_name"   => $this->request->getPost('father_name'),  
            "mother_name"   => $this->request->getPost('mother_name'),
            "pan"           => $this->request->getPost('pan'),
            "current_address" => json_encode($currentAddress),
            "qualification" => json_encode($qualification),
            "experience"    => json_encode($experience),
            "documents"     => json_encode($documents)
        ];
        $jsonData = json_encode($profileData);
        // echo "<pre>";
        // echo $jsonData;
        // echo "</pre>";
        // exit;
  

        // Call Procedure
        $response = $model->profile_updation($emp_id, $jsonData);
        // echo "<pre>";
        // print_r($response);
        // exit;
        if (!empty($response) 
            && isset($response[0]['status']) 
            && strtoupper($response[0]['status']) === 'Y') {

            return redirect()->back()->with(
                'success',
                $response[0]['remarks'] ?? 'Profile updated successfully'
            );

        } else {

            return redirect()->back()->with(
                'error',
                $response[0]['remarks'] ?? 'Profile Updation Failed'
            );
        }}
                return view('Layouts/Header')
                    . view('Layouts/Sidebar')
                    . view('aut_pages/profile_updation',$data)
                    . view('Layouts/Footer');
        }

    #In Home.php controller
 Public function switchRoleHR()
    {
        $session = session();
       
        // Removed the dd() here so the script can actually run!
 
        // 1. Security Check
        $originalRole = $session->get('user_category');
        if (!in_array($originalRole, ['HR', 'ADMIN'])) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }
 
        // 2. Update the active session role
        $session->set('current_user_cat', 'HR');
 
        return redirect()->to(base_url('employee/Emp_dashboard'))
            ->with('status', 'Y')
            ->with('remarks', 'Role switched to HR successfully.');

    }
 
    public function switchRoleADMIN()
    {
        $session = session();
       
        // Removed the dd() here so the script can actually run!
 
        // 1. Security Check
        $originalRole = $session->get('user_category');
        if (!in_array($originalRole, ['HR', 'ADMIN'])) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }
 
        // 2. Update the active session role
        $session->set('current_user_cat', 'ADMIN');
 
        return redirect()->to(base_url('admin/adm_dashboard'))
            ->with('status', 'Y')
            ->with('remarks', 'Role switched to ADMIN successfully.');
 
       
    }

    public function holiday_create()
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
        return   view('Layouts/Header')
                . view('Layouts/Sidebar')
                . view('aut_pages/Holidays_create' ,$data)
                . view('Layouts/Footer');

        }

    public function leave_policy(){

        return   view('Layouts/Header')
            . view('Layouts/Sidebar')
            . view('aut_pages/leave_policy')
            . view('Layouts/Footer');
     }

    public function company_policy(){

     return   view('Layouts/Header')
            . view('Layouts/Sidebar')
            . view('aut_pages/company_policy')
            . view('Layouts/Footer');

    }
    
    public function conduct(){

     return   view('Layouts/Header')
            . view('Layouts/Sidebar')
            . view('aut_pages/conduct')
            . view('Layouts/Footer');

    }

    public function terms_conditions(){

     return   view('Layouts/Header')
            . view('Layouts/Sidebar')
            . view('aut_pages/terms_conditions')
            . view('Layouts/Footer');

    }


}
