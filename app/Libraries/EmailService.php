<?php

namespace App\Libraries;

use App\Models\MailModel;

class EmailService
{
    protected $mailModel;

    public function __construct()
    {
        $this->mailModel = new MailModel();
    }

    /**
     * Build CodeIgniter Email Service instance initialized with DB or .env SMTP config
     */
    protected function getEmailInstance()
    {
        $dbSettings = $this->mailModel->getSettings();
        $email = \Config\Services::email();
        $email->clear(true); // Reset previous state

        $config = [];
        $config['protocol']  = 'smtp';
        $config['mailType']  = 'html';
        $config['charset']   = 'utf-8';
        $config['wordWrap']  = true;
        $config['newline']   = "\r\n";
        $config['CRLF']      = "\r\n";

        if (!empty($dbSettings['smtp_host'])) {
            $config['SMTPHost']   = $dbSettings['smtp_host'];
            $config['SMTPPort']   = (int) ($dbSettings['smtp_port'] ?? 587);
            $config['SMTPUser']   = $dbSettings['smtp_user'] ?? '';
            $config['SMTPPass']   = $dbSettings['smtp_pass'] ?? '';
            $config['SMTPCrypto'] = $dbSettings['smtp_crypto'] ?? 'tls';
            $fromEmail            = $dbSettings['from_email'] ?? 'hr@bloom.com';
            $fromName             = $dbSettings['from_name'] ?? 'Bloom HRMS';
        } else {
            // Fallback to environment or default config
            $config['SMTPHost']   = env('email.SMTPHost', 'smtp.gmail.com');
            $config['SMTPPort']   = (int) env('email.SMTPPort', 587);
            $config['SMTPUser']   = env('email.SMTPUser', '');
            $config['SMTPPass']   = env('email.SMTPPass', '');
            $config['SMTPCrypto'] = env('email.SMTPCrypto', 'tls');
            $fromEmail            = env('email.fromEmail', 'myhr@bloomsolutions.in');
            $fromName             = env('email.fromName', 'Bloom HRMS Admin');
        }

        $email->initialize($config);
        $email->setFrom($fromEmail, $fromName);

        return $email;
    }

    /**
     * Core function to send email and log history
     */
    public function sendMail(
        $toEmail,
        $subject,
        $messageHtml,
        $category = 'custom',
        $recipientName = '',
        $attachmentPath = null,
        $sentBy = 'Admin'
    ) {
        $email = $this->getEmailInstance();
        $email->setTo($toEmail);
        $email->setSubject($subject);
        $email->setMessage($messageHtml);

        if (!empty($attachmentPath) && file_exists($attachmentPath)) {
            $email->attach($attachmentPath);
        }

        $sentSuccess = false;
        $errorMsg    = null;

        try {
            if ($email->send()) {
                $sentSuccess = true;
            } else {
                $errorMsg = $email->printDebugger(['headers', 'subject']);
            }
        } catch (\Exception $e) {
            $errorMsg = $e->getMessage();
        }

        // Log the email attempt in database
        $this->mailModel->logMail([
            'recipient_email' => $toEmail,
            'recipient_name'  => $recipientName ?: $toEmail,
            'category'        => $category,
            'subject'         => $subject,
            'message_body'    => $messageHtml,
            'attachment'      => $attachmentPath ? basename($attachmentPath) : null,
            'status'          => $sentSuccess ? 'sent' : 'failed',
            'error_message'   => $errorMsg,
            'sent_by'         => $sentBy ?: 'Admin',
        ]);

        return [
            'success' => $sentSuccess,
            'error'   => $errorMsg
        ];
    }

    /**
     * Generate HTML template for Offer Letters
     */
    public function renderOfferLetterTemplate($data)
    {
        $candidateName = htmlspecialchars($data['candidate_name'] ?? 'Candidate');
        $designation   = htmlspecialchars($data['designation'] ?? 'Team Member');
        $joiningDate   = htmlspecialchars($data['joining_date'] ?? date('Y-m-d'));
        $ctc           = htmlspecialchars($data['ctc'] ?? 'As discussed');
        $customNotes   = nl2br(htmlspecialchars($data['custom_notes'] ?? ''));
        $companyName   = htmlspecialchars($data['company_name'] ?? 'Bloom Solutions');

        $notesSection = $customNotes ? "<div style='margin-bottom: 20px;'><p><strong>Additional Details:</strong></p><p>{$customNotes}</p></div>" : "";

        $tmpl = $this->mailModel->getTemplate('offer_letter');
        if ($tmpl && !empty($tmpl['body_template'])) {
            $replacements = [
                '{candidate_name}'       => $candidateName,
                '{recipient_name}'       => $candidateName,
                '{designation}'          => $designation,
                '{joining_date}'         => $joiningDate,
                '{ctc}'                  => $ctc,
                '{custom_notes}'         => $customNotes,
                '{custom_notes_section}' => $notesSection,
                '{company_name}'         => $companyName,
            ];
            return str_replace(array_keys($replacements), array_values($replacements), $tmpl['body_template']);
        }

        return "
        <div style='font-family: Arial, sans-serif; max-width: 650px; margin: 0 auto; border: 1px solid #e0e0e0; border-radius: 8px; overflow: hidden; background-color: #ffffff;'>
            <div style='background: linear-gradient(135deg, #111c43 0%, #1e2d67 100%); padding: 25px; text-align: center; color: #ffffff;'>
                <h2 style='margin: 0; font-size: 24px;'>Offer of Employment</h2>
                <p style='margin: 5px 0 0 0; font-size: 14px; color: #4a8cff;'>{$companyName} HR Team</p>
            </div>
            <div style='padding: 30px; color: #333333; line-height: 1.6;'>
                <p>Dear <strong>{$candidateName}</strong>,</p>
                <p>We are delighted to extend an offer of employment for the position of <strong>{$designation}</strong> at <strong>{$companyName}</strong>.</p>

                <div style='background-color: #f8fafc; border-left: 4px solid #4a8cff; padding: 15px; margin: 20px 0; border-radius: 4px;'>
                    <p style='margin: 0 0 8px 0;'><strong>Position:</strong> {$designation}</p>
                    <p style='margin: 0 0 8px 0;'><strong>Expected Date of Joining:</strong> {$joiningDate}</p>
                    <p style='margin: 0;'><strong>Annual Compensation (CTC):</strong> {$ctc}</p>
                </div>

                " . ($customNotes ? "<div style='margin-bottom: 20px;'><p><strong>Additional Details:</strong></p><p>{$customNotes}</p></div>" : "") . "

                <p>Please find the formal offer details attached to this email. We kindly ask you to review, sign, and return the accepted copy before your joining date.</p>

                <p style='margin-top: 30px;'>We are looking forward to having you on our team!</p>

                <p>Best regards,<br>
                <strong>HR Department</strong><br>
                {$companyName}</p>
            </div>
            <div style='background-color: #f1f5f9; padding: 15px; text-align: center; font-size: 12px; color: #64748b;'>
                This is an automated email from {$companyName} HRMS system. Please do not reply directly to this notification.
            </div>
        </div>";
    }

    /**
     * Generate HTML template for Google Meet Invites
     */
    public function renderGoogleMeetTemplate($data)
    {
        $candidateName = htmlspecialchars($data['recipient_name'] ?? 'Participant');
        $title         = htmlspecialchars($data['meeting_title'] ?? 'Interview / Discussion');
        $meetUrl       = htmlspecialchars($data['meet_url'] ?? '#');
        $meetDate      = htmlspecialchars($data['meeting_date'] ?? date('Y-m-d'));
        $meetTime      = htmlspecialchars($data['meeting_time'] ?? '10:00 AM');
        $agenda        = nl2br(htmlspecialchars($data['agenda'] ?? 'Discussion regarding upcoming opportunities.'));
        $companyName   = htmlspecialchars($data['company_name'] ?? 'Bloom Solutions');

        $tmpl = $this->mailModel->getTemplate('meet_invite');
        if ($tmpl && !empty($tmpl['body_template'])) {
            $replacements = [
                '{recipient_name}' => $candidateName,
                '{candidate_name}' => $candidateName,
                '{meeting_title}'  => $title,
                '{meet_url}'       => $meetUrl,
                '{meeting_date}'   => $meetDate,
                '{meeting_time}'   => $meetTime,
                '{agenda}'         => $agenda,
                '{company_name}'   => $companyName,
            ];
            return str_replace(array_keys($replacements), array_values($replacements), $tmpl['body_template']);
        }

        return "
        <div style='font-family: Arial, sans-serif; max-width: 650px; margin: 0 auto; border: 1px solid #e0e0e0; border-radius: 8px; overflow: hidden; background-color: #ffffff;'>
            <div style='background: linear-gradient(135deg, #0f9d58 0%, #0b8043 100%); padding: 25px; text-align: center; color: #ffffff;'>
                <h2 style='margin: 0; font-size: 24px;'>Google Meet Invitation</h2>
                <p style='margin: 5px 0 0 0; font-size: 14px; color: #e8f5e9;'>{$companyName} Video Meeting</p>
            </div>
            <div style='padding: 30px; color: #333333; line-height: 1.6;'>
                <p>Hello <strong>{$candidateName}</strong>,</p>
                <p>You have been invited to a Google Meet session with the {$companyName} team.</p>

                <div style='background-color: #f0fdf4; border-left: 4px solid #0f9d58; padding: 18px; margin: 20px 0; border-radius: 6px;'>
                    <h3 style='margin: 0 0 10px 0; color: #166534;'>{$title}</h3>
                    <p style='margin: 0 0 6px 0;'>📅 <strong>Date:</strong> {$meetDate}</p>
                    <p style='margin: 0 0 6px 0;'>⏰ <strong>Time:</strong> {$meetTime}</p>
                    <p style='margin: 0 0 15px 0;'>📌 <strong>Agenda:</strong><br>{$agenda}</p>
                    
                    <div style='text-align: center; margin-top: 20px;'>
                        <a href='{$meetUrl}' target='_blank' style='background-color: #0f9d58; color: #ffffff; padding: 12px 24px; font-weight: bold; text-decoration: none; border-radius: 5px; display: inline-block;'>Join Google Meet</a>
                    </div>
                </div>

                <p style='font-size: 13px; color: #666666;'>Direct Meeting Link: <a href='{$meetUrl}' style='color: #0f9d58;'>{$meetUrl}</a></p>

                <p style='margin-top: 25px;'>Please join the meeting 5 minutes prior to the scheduled time.</p>

                <p>Warm regards,<br>
                <strong>{$companyName} Team</strong></p>
            </div>
            <div style='background-color: #f1f5f9; padding: 15px; text-align: center; font-size: 12px; color: #64748b;'>
                Sent via {$companyName} HRMS Mail Center.
            </div>
        </div>";
    }

    /**
     * Generate HTML template for Custom Mails
     */
    public function renderCustomTemplate($data)
    {
        $recipientName = htmlspecialchars($data['recipient_name'] ?? 'Recipient');
        $subject       = htmlspecialchars($data['subject'] ?? 'Notification');
        $messageBody   = $data['message_body'] ?? '';
        $companyName   = htmlspecialchars($data['company_name'] ?? 'Bloom Solutions');

        $tmpl = $this->mailModel->getTemplate('custom');
        if ($tmpl && !empty($tmpl['body_template'])) {
            $replacements = [
                '{recipient_name}' => $recipientName,
                '{candidate_name}' => $recipientName,
                '{subject}'        => $subject,
                '{message_body}'   => $messageBody,
                '{company_name}'   => $companyName,
            ];
            return str_replace(array_keys($replacements), array_values($replacements), $tmpl['body_template']);
        }

        return "
        <div style='font-family: Arial, sans-serif; max-width: 650px; margin: 0 auto; border: 1px solid #e0e0e0; border-radius: 8px; overflow: hidden; background-color: #ffffff;'>
            <div style='background: linear-gradient(135deg, #17a2b8 0%, #117a8b 100%); padding: 25px; text-align: center; color: #ffffff;'>
                <h2 style='margin: 0; font-size: 24px;'>{$subject}</h2>
                <p style='margin: 5px 0 0 0; font-size: 14px; color: #e0f7fa;'>{$companyName}</p>
            </div>
            <div style='padding: 30px; color: #333333; line-height: 1.6;'>
                <p>Dear <strong>{$recipientName}</strong>,</p>
                <div style='margin: 20px 0;'>
                    {$messageBody}
                </div>
                <p style='margin-top: 30px;'>Best regards,<br>
                <strong>{$companyName} Team</strong></p>
            </div>
            <div style='background-color: #f1f5f9; padding: 15px; text-align: center; font-size: 12px; color: #64748b;'>
                Sent via {$companyName} HRMS.
            </div>
        </div>";
    }

    /**
     * Test SMTP Connection
     */
    public function testSmtpConnection($settings, $testEmail)
    {
        $email = \Config\Services::email();
        $email->clear(true);

        $config = [
            'protocol'   => 'smtp',
            'mailType'   => 'html',
            'charset'    => 'utf-8',
            'wordWrap'   => true,
            'newline'    => "\r\n",
            'CRLF'       => "\r\n",
            'SMTPHost'   => $settings['smtp_host'] ?? '',
            'SMTPPort'   => (int) ($settings['smtp_port'] ?? 587),
            'SMTPUser'   => $settings['smtp_user'] ?? '',
            'SMTPPass'   => $settings['smtp_pass'] ?? '',
            'SMTPCrypto' => $settings['smtp_crypto'] ?? 'tls',
        ];

        $email->initialize($config);
        $email->setFrom($settings['from_email'] ?? 'hr@bloom.com', $settings['from_name'] ?? 'Bloom HRMS Test');
        $email->setTo($testEmail);
        $email->setSubject('Bloom HRMS - SMTP Test Connection');
        $email->setMessage('<h3>SMTP Configuration Test</h3><p>If you are reading this email, your SMTP settings are working correctly!</p>');

        try {
            if ($email->send()) {
                return ['success' => true, 'message' => 'SMTP connection successful! Test email sent to ' . $testEmail];
            } else {
                return ['success' => false, 'message' => 'SMTP Failed: ' . strip_tags($email->printDebugger(['headers', 'subject']))];
            }
        } catch (\Exception $e) {
            return ['success' => false, 'message' => 'Exception: ' . $e->getMessage()];
        }
    }
}
