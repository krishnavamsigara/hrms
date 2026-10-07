<?php

namespace App\Controllers;

use App\Models\OnboardingModel;

class OnboardingController extends BaseController
{

    public function on_board()
    {
        $session = session();
        // $ref_id = $session->get('ref_id');

        return view('on_boarding/onboard_login');
    }

    // STEP : 1 LOGIN WITH REFERENCE ID AND PASSWORD
    public function login_check()
    {
        $session = session();
        // if (!$session->get('logged_in')) {
        // return redirect()->to(base_url('/'));
        // }
        $refid = trim($this->request->getPost('refid'));
        $password = trim($this->request->getPost('password'));

        $model = new OnboardingModel();
        $result = $model->candidatelogin($refid, $password);

        $data = $result[0];

        if ($data['status'] == 'Y') {

            // store session
            $session->set([
                'logged_in' => true,
                'ref_id'    => $data['ref_id'],
                'emp_name'  => $data['emp_name'],
                'email'     => $data['email'],
                'offer_status' => $data['offer_status'] ?? 'pending'
            ]);

            // REDIRECT TO YOUR PAGE
            $details = $model->getdetails($refid);
            $details = $details[0] ?? [];

            return $this->redirectToLastStep($details);
        } else {

            return redirect()->back()->with('error', $data['remarks']);
        }
    }

    public function verify($refid, $token)
    {
        $session = session();
        
        $model = new OnboardingModel();
        $result = $model->candidatelogin($refid, $token);

        $data = $result[0];

        if ($data['status'] == 'Y') {

            $session->set([
                'logged_in' => true,
                'ref_id'    => $data['ref_id'],
                'emp_name'  => $data['emp_name'],
                'email'     => $data['email'],
                'offer_status' => $data['offer_status'] ?? 'pending'
            ]);

         $details = $model->getdetails($refid);
         $details = $details[0] ?? [];

        // First login -> show appointment letter
        if (empty($details['offer_status']) || strtolower($details['offer_status']) != 'accepted') {
            return redirect()->to(base_url('on_boarding/view_appointment_letter'));
        }

        // Already accepted -> continue from last completed step
        return $this->redirectToLastStep($details);
        } else {
            return redirect()->to(base_url('on_boarding/onboard_login'))
                ->with('error', $data['remarks']);
        }
    }


    public function view_app_letter()
    {
        $session = session();
       
        $refid = $session->get('ref_id');

        $model = new OnboardingModel();
        $details = $model->getdetails($refid);

        // DEBUG (TEMP)
        // print_r($details); exit;

        $offer_status = strtolower($details[0]['offer_status'] ?? 'pending');

        return view('on_boarding/view_appointment_letter', [
            'offer_status' => $offer_status
        ]);
    }

    // STEP:2 OFFER LETTER ACCEPT
    public function accept_offer()
    {
        $session = session();
        $refid = $this->request->getPost('refid');

        $model = new OnboardingModel();
        $result = $model->acceptoffer($refid);
      
        $data = $result[0];

        if ($data['status'] == 'Y') {

            $details = $model->getdetails($refid);
            
            return redirect()->to('on_boarding/document_checklist');
        } else {
            return redirect()->back()->with('error', $data['remarks']);
        }
    }

    //STEP:3 OFFER LETTER REJECTION
    public function reject_offer()
    {
        $session = session();
        // if (!$session->get('logged_in')) {
        // return redirect()->to(base_url('/'));
        // }
        $refid  = $this->request->getPost('refid');
        $remarks = $this->request->getPost('remarks');

        $model = new OnboardingModel();

        $result = $model->rejectoffer($refid, $remarks);

        $data = $result[0];

        return redirect()->back()->with('message', $data['remarks']);
    }

    public function doc_check()
    {
        return view('on_boarding/document_checklist');
    }

    //STEP:4 PERSONAL DETAILS PAGE
    public function person_det()
    {
        $session = session();

        $refid = $session->get('ref_id');
        $model = new OnboardingModel();

        // SAVE
        if ($this->request->getMethod() == 'POST') {

            // STEP 1: get raw post
            $post = $this->request->getPost();

            // STEP 2: filter empty values
            $newData = [];
            foreach ($post as $key => $value) {
                if ($value !== null && $value !== '') {
                    $newData[$key] = $value;
                }
            }


            //  PAN VALIDATION (ADD THIS)
            if (!empty($newData['panNumber'])) {
                if (!preg_match('/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/', $newData['panNumber'])) {
                    return redirect()->back()->with('error', 'Invalid PAN format (e.g., ABCDE1234F)');
                }
            }

            if (!empty($newData['aadhaarNumber'])) {
                if (!preg_match('/^\d{4}-\d{4}-\d{4}$/', $newData['aadhaarNumber'])) {
                    return redirect()->back()->with('error', 'Invalid Aadhaar number (must be 12 digits)');
                }
            }

            $email = $newData['email'] ?? '';

            if (!empty($email)) {
                if (!preg_match('/^[a-zA-Z0-9._%+-]+@(gmail\.com|yahoo\.com)$/', $email)) {
                    return redirect()->back()->with('error', 'Only Gmail and Yahoo emails are allowed');
                }
            }

            $mobile = $newData['mobile'] ?? '';

            if (!empty($mobile)) {
                if (!preg_match('/^[6-9][0-9]{9}$/', $mobile)) {
                    return redirect()->back()->with('error', 'Invalid mobile number');
                }

                // add +91 before saving
                $mobile = '+91' . $mobile;
            }
            // STEP 3: map to DB structure
            $aadhaar = str_replace('-', '', $newData['aadhaarNumber'] ?? '');
            $data = [
                'emp_name' => trim(($newData['firstName'] ?? '') . ' ' . ($newData['lastName'] ?? '')),
                'mobile'   => $newData['mobile'] ?? null,
                'email'    => $newData['email'] ?? null,
                'dob'      => $newData['dob'] ?? null,
                'gender'   => $newData['gender'] ?? null,
                'marital_status' => $newData['marital'] ?? null,
                'father_name' => $newData['fatherName'] ?? null,
                'mother_name' => $newData['motherName'] ?? null,
                'aadhaar' => $aadhaar,
                'pan' => $newData['panNumber'] ?? null,
                'current_address' => [
                    'houseNo' => $newData['houseNo'] ?? null,
                    'area' => $newData['area'] ?? null,
                    'streetNo' => $newData['streetNo'] ?? null,
                    'buildingName' => $newData['buildingName'] ?? null,
                    'street' => $newData['address'] ?? null,
                    'city' => $newData['city'] ?? null,
                    'state' => $newData['state'] ?? null,
                    'pincode' => $newData['pincode'] ?? null,
                ]
            ];

            // STEP 4: save
            $result = $model->saveStepData($refid, $data, 1);

            if ($result) {
                return redirect()->to(base_url('on_boarding/bank_details'));
            } else {
                return redirect()->back()->with('error', 'Save failed');
            }
        }
        // FETCH
        $details = $model->getdetails($refid);
        // dd($details);
        return view('on_boarding/personal_details', [
            'details' => $details
        ]);
    }

    //STEP:5 BANK DETAILS PAGE
    public function bank_det()
    {
        $session = session();
        $refid = $session->get('ref_id');

        $model = new OnboardingModel();

        //  SAVE PART
        if ($this->request->getMethod() == 'POST') {

            $data = [
                'bank_holder_name' => $this->request->getPost('bankHolder'),
                'bank_name'        => $this->request->getPost('bankName'),
                'bank_account_no'  => $this->request->getPost('bankAcc'),
                'ifsc'             => $this->request->getPost('bankIfsc'),
                'bank_branch'      => $this->request->getPost('bankBranch'),
                'upi_id'           => $this->request->getPost('upiId'),
                'bank_account_type' => $this->request->getPost('bankAccType')
            ];

            $model->saveStepData($refid, $data, 2);

            return redirect()->to(base_url('on_boarding/education_details'));
        }

        // FETCH PART
        $details = $model->getdetails($refid);

        return view('on_boarding/bank_details', [
            'details' => $details
        ]);
    }

    //STEP:6 EDUCATION DETAILS PAGE
    public function edu_details()
    {
      
        $session = session();
        // if (!$session->get('logged_in')) {
        // return redirect()->to(base_url('/'));
        // }
        $refid = $session->get('ref_id');

        $model = new OnboardingModel();

        // FETCH DETAILS (MOVE OUTSIDE SO BOTH GET + POST WORK)
        $details = $model->getdetails($refid);
        $details = $details[0] ?? [];

        if ($this->request->getMethod() == 'POST') {

            $post = $this->request->getPost();

            $newData = [];
            if (!empty($post['techSkills'])) {
                $newData['skills'] = $post['techSkills'];
            }

            if (!empty($post['qualification_json'])) {
                $decoded = json_decode($post['qualification_json'], true);
                if (is_array($decoded)) {
                    $newData['qualification'] = $decoded;
                }
            }

            $model->saveStepData($refid, $newData, 3);

            // GET EXPERIENCE TYPE
            $experience = json_decode($details['experience'] ?? '[]', true);

            $type = '';

            if (is_array($experience) && isset($experience[0]['experience_type'])) {
                $type = $experience[0]['experience_type'];
            }

            // FLOW DECISION
            if ($type == 'FRESHER') {
                return redirect()->to(base_url('on_boarding/document_upload'));
            } else {
                return redirect()->to(base_url('on_boarding/professional_details'));
            }
        }

        return view('on_boarding/education_details', [
            'details' => $details
        ]);
    }

    //STEP:7 PROFESSIONAL DETAILS PAGE
    public function professional_det()
    {
        $session = session();
      
        $refid = $session->get('ref_id');

        $model = new OnboardingModel();

        if ($this->request->getMethod() == 'POST') {

            $post = $this->request->getPost();


            $newData = [];
            if (!empty($post['experience_json'])) {
                $decoded = json_decode($post['experience_json'], true);

                if (is_array($decoded)) {
                    $newData['experience'] = json_encode($decoded);
                }
            }

            $result = $model->saveStepData($refid, $newData, 4);

            if ($result) {
                return redirect()->to(base_url('on_boarding/document_upload'));
            } else {
                return redirect()->back()->with('error', 'Save failed');
            }
        }
        $details = $model->getdetails($refid);
        $details = $details[0] ?? [];

        if (!empty($details['experience']) && is_string($details['experience'])) {
            $details['experience'] = json_decode($details['experience'], true) ?? [];
        }

        return view('on_boarding/professional_details', [
            'details' => $details
        ]);
    }

    public function doc_upload()
    {
        $session = session();
      
        $refid = $session->get('ref_id');

        $model = new OnboardingModel();

        $details = $model->getdetails($refid);
        $details = $details[0] ?? [];

        //  IMPORTANT FIX: decode documents JSON
        if (!empty($details['documents'])) {
            $details['documents'] = json_decode($details['documents'], true);
        } else {
            $details['documents'] = [];
        }
       
        return view('on_boarding/document_upload', [
            'details' => $details
        ]);
    }

    public function save_documents()
    {
        $session = session();
      
        $refid = $session->get('ref_id');

        $model = new OnboardingModel();

        $details = $model->getdetails($refid);
        $details = $details[0] ?? [];

        $documents = [];

        if (!empty($details['documents'])) {
            $documents = json_decode($details['documents'], true) ?? [];
        }

        // Profile Photo
        $file = $this->request->getFile('doc_profile_photo');
        if ($file && $file->isValid()) {
            $name = $refid . '_photo.' . $file->getExtension();
            $file->move(FCPATH . 'uploads/profile/', $name, true);
            $documents['profile_photo'] = 'uploads/profile/' . $name;
        }

        // Aadhaar
        $file = $this->request->getFile('doc_aadhaar');
        if ($file && $file->isValid()) {
            $name = $refid . '_aadhar.' . $file->getExtension();
            $file->move(FCPATH . 'uploads/aadhaar/', $name, true);
            $documents['aadhaar'] = 'uploads/aadhaar/' . $name;
        }

        // PAN
        $file = $this->request->getFile('doc_pan');
        if ($file && $file->isValid()) {
            $name = $refid . '_pancard.' . $file->getExtension();
            $file->move(FCPATH . 'uploads/pancard/', $name, true);
            $documents['pan'] = 'uploads/pancard/' . $name;
        }

        // Bank Proof
        $file = $this->request->getFile('doc_bank_proof');
        if ($file && $file->isValid()) {
            $name = $refid . '_Bankproof.' . $file->getExtension();
            $file->move(FCPATH . 'uploads/Bank_proof/', $name, true);
            $documents['bank_proof'] = 'uploads/Bank_proof/' . $name;
        }

        // Degree
        $file = $this->request->getFile('doc_degree');
        if ($file && $file->isValid()) {
            $name = $refid . '_degree.' . $file->getExtension();
            $file->move(FCPATH . 'uploads/Degree_Certificate/', $name, true);
            $documents['degree'] = 'uploads/Degree_Certificate/' . $name;
        }

        // Marks Memo
        $file = $this->request->getFile('doc_marks_memo');
        if ($file && $file->isValid()) {
            $name = $refid . '_Marksmemo.' . $file->getExtension();
            $file->move(FCPATH . 'uploads/Marks_memo/', $name, true);
            $documents['marks_memo'] = 'uploads/Marks_memo/' . $name;
        }

        // Provisional
        $file = $this->request->getFile('doc_provisional');
        if ($file && $file->isValid()) {
            $name = $refid . '_provisional.' . $file->getExtension();
            $file->move(FCPATH . 'uploads/Provisional_certificate/', $name, true);
            $documents['provisional'] = 'uploads/Provisional_certificate/' . $name;
        }

        // Intermediate
        $file = $this->request->getFile('doc_inter');
        if ($file && $file->isValid()) {
            $name = $refid . '_Inter_certificate.' . $file->getExtension();
            $file->move(FCPATH . 'uploads/Intermeditae_Certificate/', $name, true);
            $documents['intermediate'] = 'uploads/Intermeditae_Certificate/' . $name;
        }

        // SSC
        $file = $this->request->getFile('doc_ssc');
        if ($file && $file->isValid()) {
            $name = $refid . '_SSC_certificate.' . $file->getExtension();
            $file->move(FCPATH . 'uploads/SSC_Certificate/', $name, true);
            $documents['ssc'] = 'uploads/SSC_Certificate/' . $name;
        }

        // Additional Certificate
        $file = $this->request->getFile('doc_additional');
        if ($file && $file->isValid()) {
            $name = $refid . '_Additional.' . $file->getExtension();
            $file->move(FCPATH . 'uploads/Additional_Certificate/', $name, true);
            $documents['additional'] = 'uploads/Additional_Certificate/' . $name;
        }

        // Resume
        $file = $this->request->getFile('doc_resume');
        if ($file && $file->isValid()) {
            $name = $refid . '_resume.' . $file->getExtension();
            $file->move(FCPATH . 'uploads/Resume/', $name, true);
            $documents['resume'] = 'uploads/Resume/' . $name;
        }

        // Relieving Letter
        $file = $this->request->getFile('doc_relieving_letter');
        if ($file && $file->isValid()) {
            $name = $refid . '_relieving_letter.' . $file->getExtension();
            $file->move(FCPATH . 'uploads/Relieving letter/', $name, true);
            $documents['relieving_letter'] = 'uploads/Relieving letter/' . $name;
        }

      
        $newData['documents'] = $documents;

        $result = $model->saveStepData($refid, $newData, 5);

        if ($result) {
            return redirect()->to(base_url('on_boarding/cross_check'));
        }

        return redirect()->back()->with('error', 'Save Failed');
    }

    public function delete_document()
    {
        $session = session();
        // if (!$session->get('logged_in')) {
        // return redirect()->to(base_url('/'));
        // }
        $refid = $session->get('ref_id');

        $model = new OnboardingModel();

        $key = $this->request->getPost('key');

        if (!$key) {
            $json = $this->request->getJSON(true);
            $key = $json['key'] ?? '';
        }
        $details = $model->getdetails($refid);
        $details = $details[0] ?? [];

        $documents = json_decode($details['documents'], true) ?? [];

        //  DEBUG (temporary)
        log_message('error', 'DELETE KEY: ' . $key);
        log_message('error', print_r($documents, true));

        if (isset($documents[$key])) {

            $filePath = FCPATH . $documents[$key];

            if (file_exists($filePath)) {
                unlink($filePath);
            }

            unset($documents[$key]);

            $model->saveStepData($refid, ['documents' => $documents], 5);

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Deleted successfully'
            ]);
        }

        return $this->response->setJSON([
            'debug_key' => $key
        ]);
    }

    public function upload_single_document()
    {
        $session = session();
        // if (!$session->get('logged_in')) {
        // return redirect()->to(base_url('/'));
        // }
        $refid = $session->get('ref_id');

        $model = new OnboardingModel();

        $file = $this->request->getFile('file');
        $key  = $this->request->getPost('key');

        if (!$file || !$file->isValid()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid file'
            ]);
        }

        $details = $model->getdetails($refid);
        $details = $details[0] ?? [];

        $documents = !empty($details['documents'])
            ? json_decode($details['documents'], true)
            : [];

        $ext = $file->getExtension();
        $name = $refid . '_' . $key . '.' . $ext;

        $folderMap = [
            'profile_photo' => 'uploads/profile/',
            'aadhaar'       => 'uploads/aadhaar/',
            'pan'           => 'uploads/pancard/',
            'bank_proof'    => 'uploads/Bank_proof/',
            'degree'        => 'uploads/Degree_Certificate/',
            'marks_memo'    => 'uploads/Marks_memo/',
            'provisional'   => 'uploads/Provisional_certificate/',
            'intermediate'  => 'uploads/Intermeditae_Certificate/',
            'ssc'           => 'uploads/SSC_Certificate/',
            'additional'    => 'uploads/Additional_Certificate/',
            'resume'        => 'uploads/Resume/',
            'relieving_letter' => 'uploads/Relieving letter/',
        ];

        if (!isset($folderMap[$key])) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid document key'
            ]);
        }

        $path = $folderMap[$key];

        $file->move(FCPATH . $path, $name);

        $documents[$key] = $path . $name;

        $model->saveStepData($refid, ['documents' => $documents], 5);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Uploaded successfully'
        ]);
    }
    public function crosscheck()
    {
        $session = session();
        
        $refid = $session->get('ref_id');

        $model = new OnboardingModel();

        $details = $model->getdetails($refid);
        $details = $details[0] ?? [];

        if (!empty($details['documents'])) {
            $details['documents'] = json_decode($details['documents'], true);
        } else {
            $details['documents'] = [];
        }


        return view('on_boarding/cross_check', [
            'details' => $details
        ]);
    }

    public function finalsubmit()
    {
        $session = session();
       
        $refid = $session->get('ref_id');

        $model = new OnboardingModel();

        $result = $model->submitdetails($refid);

        return redirect()->to(base_url('on_boarding/thank_you'));
    }

    public function decline()
    {
        $session = session();
     
        return view('on_boarding/decline');
    }

    public function thanku()
    {
        $session = session();
       
        return view('on_boarding/thank_you');
    }

    private function redirectToLastStep($details)
    {
        $currentStep = (int)($details['current_step'] ?? 0);

        switch ($currentStep) {

            case 1:
                return redirect()->to(base_url('on_boarding/bank_details'));

            case 2:
                return redirect()->to(base_url('on_boarding/education_details'));

            case 3:
                return redirect()->to(base_url('on_boarding/professional_details'));

            case 4:
                return redirect()->to(base_url('on_boarding/document_upload'));

            case 5:
                return redirect()->to(base_url('on_boarding/cross_check'));

            default:
                return redirect()->to(base_url('on_boarding/view_appointment_letter'));
        }
    }
}
