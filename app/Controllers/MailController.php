<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MailModel;
use App\Libraries\EmailService;

class MailController extends BaseController
{
    protected $mailModel;
    protected $emailService;

    public function __construct()
    {
        $this->mailModel    = new MailModel();
        $this->emailService = new EmailService();
    }

    /**
     * Check if user is logged in as Admin or HR
     */
    private function checkAuth()
    {
        $session      = session();
        $active_role  = $session->get('current_user_cat') ?? $session->get('user_category');
        if (!in_array($active_role, ['ADMIN', 'HR', 'MANAGER'])) {
            return redirect()->to('/login')->with('error', 'Access denied.');
        }
        return null;
    }

    /**
     * Compose View
     */
    public function compose()
    {
        if ($authRedirect = $this->checkAuth()) {
            return $authRedirect;
        }

        // Fetch candidate list if available for convenience
        $db = \Config\Database::connect();
        $candidates = [];
        if ($db->tableExists('candidate')) {
            $candidates = $db->table('candidate')->select('refid, emp_name, email, mobile')->get()->getResultArray();
        }

        $employees = [];
        if ($db->tableExists('employees')) {
            $employees = $db->table('employees')->select('emp_id, emp_name, email, mobile')->get()->getResultArray();
        }

        $templates = $this->mailModel->getAllTemplates();

        $data = [
            'title'      => 'Mail Center - Compose Email',
            'candidates' => $candidates,
            'employees'  => $employees,
            'templates'  => $templates,
            'active_tab' => $this->request->getGet('tab') ?? 'offer_letter'
        ];

        echo view('Layouts/Header', $data);
        echo view('Layouts/Sidebar', $data);
        echo view('admin/mail/compose', $data);
        echo view('Layouts/Footer', $data);
    }

    /**
     * Handle Email Sending
     */
    public function send()
    {
        if ($authRedirect = $this->checkAuth()) {
            return $authRedirect;
        }

        $category = $this->request->getPost('category') ?? 'custom';
        $session  = session();
        $sentBy   = $session->get('emp_name') ?? $session->get('user_category') ?? 'Admin';

        $attachmentPath = null;
        $file = $this->request->getFile('attachment');

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $uploadDir = WRITEPATH . 'uploads/email_attachments/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $file->move($uploadDir, $newName);
            $attachmentPath = $uploadDir . $newName;
        }

        if ($category === 'offer_letter') {
            $recipientEmail = trim($this->request->getPost('recipient_email') ?? '');
            $candidateName  = trim($this->request->getPost('candidate_name') ?? '');
            $designation    = trim($this->request->getPost('designation') ?? '');
            $joiningDate    = trim($this->request->getPost('joining_date') ?? '');
            $ctc            = trim($this->request->getPost('ctc') ?? '');
            $notes          = trim($this->request->getPost('custom_notes') ?? '');
            $subject        = "Job Offer Letter - " . ($designation ? $designation : "Bloom Solutions");

            if (empty($recipientEmail) || empty($candidateName)) {
                return redirect()->back()->with('error', 'Recipient email and Candidate Name are required.');
            }

            $messageHtml = $this->emailService->renderOfferLetterTemplate([
                'candidate_name' => $candidateName,
                'designation'    => $designation,
                'joining_date'   => $joiningDate,
                'ctc'            => $ctc,
                'custom_notes'   => $notes,
            ]);

            $result = $this->emailService->sendMail(
                $recipientEmail,
                $subject,
                $messageHtml,
                'offer_letter',
                $candidateName,
                $attachmentPath,
                $sentBy
            );

        } elseif ($category === 'meet_invite') {
            $recipientEmail = trim($this->request->getPost('recipient_email') ?? '');
            $recipientName  = trim($this->request->getPost('recipient_name') ?? '');
            $meetingTitle   = trim($this->request->getPost('meeting_title') ?? 'Google Meet Invitation');
            $meetUrl        = trim($this->request->getPost('meet_url') ?? '');
            $meetingDate    = trim($this->request->getPost('meeting_date') ?? '');
            $meetingTime    = trim($this->request->getPost('meeting_time') ?? '');
            $agenda         = trim($this->request->getPost('agenda') ?? '');
            $subject        = "Invitation: " . $meetingTitle;

            if (empty($recipientEmail) || empty($meetUrl)) {
                return redirect()->back()->with('error', 'Recipient email and Google Meet link are required.');
            }

            $messageHtml = $this->emailService->renderGoogleMeetTemplate([
                'recipient_name' => $recipientName,
                'meeting_title'  => $meetingTitle,
                'meet_url'       => $meetUrl,
                'meeting_date'   => $meetingDate,
                'meeting_time'   => $meetingTime,
                'agenda'         => $agenda,
            ]);

            $result = $this->emailService->sendMail(
                $recipientEmail,
                $subject,
                $messageHtml,
                'meet_invite',
                $recipientName,
                $attachmentPath,
                $sentBy
            );

        } else {
            // Custom Mail
            $recipientEmail = trim($this->request->getPost('recipient_email') ?? '');
            $recipientName  = trim($this->request->getPost('recipient_name') ?? '');
            $subject        = trim($this->request->getPost('subject') ?? 'Notification from Bloom Solutions');
            $messageBody    = $this->request->getPost('message_body') ?? '';

            if (empty($recipientEmail) || empty($subject) || empty($messageBody)) {
                return redirect()->back()->with('error', 'Recipient email, Subject, and Message body are required.');
            }

            $messageHtml = $this->emailService->renderCustomTemplate([
                'recipient_name' => $recipientName,
                'subject'        => $subject,
                'message_body'   => $messageBody,
            ]);

            $result = $this->emailService->sendMail(
                $recipientEmail,
                $subject,
                $messageHtml,
                'custom',
                $recipientName,
                $attachmentPath,
                $sentBy
            );
        }

        if ($result['success']) {
            return redirect()->to('admin/mail/logs')->with('success', 'Email sent successfully to ' . $recipientEmail);
        } else {
            return redirect()->back()->with('error', 'Failed to send email. Error: ' . strip_tags($result['error']));
        }
    }

    /**
     * Sent Mail History Logs
     */
    public function logs()
    {
        if ($authRedirect = $this->checkAuth()) {
            return $authRedirect;
        }

        $category = $this->request->getGet('category') ?? 'all';
        $logs = $this->mailModel->getMailLogs($category);

        $data = [
            'title'            => 'Mail Center - Sent Logs',
            'logs'             => $logs,
            'selected_category' => $category,
        ];

        echo view('Layouts/Header', $data);
        echo view('Layouts/Sidebar', $data);
        echo view('admin/mail/logs', $data);
        echo view('Layouts/Footer', $data);
    }

    /**
     * Get Log Details via AJAX
     */
    public function viewLog($id)
    {
        if ($authRedirect = $this->checkAuth()) {
            return $this->response->setJSON(['error' => 'Unauthorized']);
        }

        $log = $this->mailModel->getMailLogById($id);
        if (!$log) {
            return $this->response->setJSON(['error' => 'Log not found']);
        }

        return $this->response->setJSON($log);
    }

    /**
     * SMTP Settings View
     */
    public function settings()
    {
        if ($authRedirect = $this->checkAuth()) {
            return $authRedirect;
        }

        $settings = $this->mailModel->getSettings();

        $data = [
            'title'    => 'Mail Center - SMTP Settings',
            'settings' => $settings,
        ];

        echo view('Layouts/Header', $data);
        echo view('Layouts/Sidebar', $data);
        echo view('admin/mail/settings', $data);
        echo view('Layouts/Footer', $data);
    }

    /**
     * Save SMTP Settings
     */
    public function saveSettings()
    {
        if ($authRedirect = $this->checkAuth()) {
            return $authRedirect;
        }

        $data = [
            'smtp_host'   => trim($this->request->getPost('smtp_host') ?? ''),
            'smtp_port'   => (int) ($this->request->getPost('smtp_port') ?? 587),
            'smtp_user'   => trim($this->request->getPost('smtp_user') ?? ''),
            'smtp_pass'   => trim($this->request->getPost('smtp_pass') ?? ''),
            'smtp_crypto' => trim($this->request->getPost('smtp_crypto') ?? 'tls'),
            'from_email'  => trim($this->request->getPost('from_email') ?? ''),
            'from_name'   => trim($this->request->getPost('from_name') ?? 'Bloom HRMS'),
        ];

        $this->mailModel->saveSettings($data);

        return redirect()->to('admin/mail/settings')->with('success', 'SMTP settings updated successfully!');
    }

    /**
     * Test SMTP Connection
     */
    public function testSmtp()
    {
        if ($authRedirect = $this->checkAuth()) {
            return redirect()->to('/login');
        }

        $testEmail = trim($this->request->getPost('test_email') ?? '');
        if (empty($testEmail)) {
            return redirect()->back()->with('error', 'Please provide a test recipient email address.');
        }

        $settings = [
            'smtp_host'   => trim($this->request->getPost('smtp_host') ?? ''),
            'smtp_port'   => (int) ($this->request->getPost('smtp_port') ?? 587),
            'smtp_user'   => trim($this->request->getPost('smtp_user') ?? ''),
            'smtp_pass'   => trim($this->request->getPost('smtp_pass') ?? ''),
            'smtp_crypto' => trim($this->request->getPost('smtp_crypto') ?? 'tls'),
            'from_email'  => trim($this->request->getPost('from_email') ?? ''),
            'from_name'   => trim($this->request->getPost('from_name') ?? 'Bloom Test'),
        ];

        $res = $this->emailService->testSmtpConnection($settings, $testEmail);

        if ($res['success']) {
            return redirect()->back()->with('success', $res['message']);
        } else {
            return redirect()->back()->with('error', $res['message']);
        }
    }

    /**
     * Get Mail Template via AJAX
     */
    public function getTemplate($category)
    {
        if ($authRedirect = $this->checkAuth()) {
            return $this->response->setJSON(['error' => 'Unauthorized']);
        }

        $tmpl = $this->mailModel->getTemplate($category);
        if (!$tmpl) {
            return $this->response->setJSON(['error' => 'Template not found']);
        }

        return $this->response->setJSON($tmpl);
    }

    /**
     * Save Mail Template
     */
    public function saveTemplate()
    {
        if ($authRedirect = $this->checkAuth()) {
            return $authRedirect;
        }

        $category = trim($this->request->getPost('category') ?? '');
        $subject  = trim($this->request->getPost('subject_template') ?? '');
        $body     = $this->request->getPost('body_template') ?? '';
        $name     = trim($this->request->getPost('template_name') ?? '');

        if (empty($category) || empty($subject) || empty($body)) {
            return redirect()->to('admin/mail/compose?tab=templates#tab-templates')->with('error', 'Category, Subject Template, and Body Template are required.');
        }

        $this->mailModel->saveTemplate($category, $subject, $body, $name);

        return redirect()->to('admin/mail/compose?tab=templates#tab-templates')->with('success', 'Email template updated successfully!');
    }
}
