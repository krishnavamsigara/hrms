<?php

namespace App\Libraries;

// Include PHPMailer files from ThirdParty
require_once APPPATH . 'ThirdParty/PHPMailer/Exception.php';
require_once APPPATH . 'ThirdParty/PHPMailer/PHPMailer.php';
require_once APPPATH . 'ThirdParty/PHPMailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class EmailService
{
    private PHPMailer $mail;

    // public function __construct()
    // {
    //     $this->logStep("EmailService::__construct() started");

    //     $this->mail = new PHPMailer(true);

    //     // Verbose Debug Output
    //     $this->mail->SMTPDebug = SMTP::DEBUG_SERVER; 

    //     // Global SMTP Configuration
    //     $this->mail->isSMTP();
    //     $this->mail->Host       = 'sg2plmcpnl510119.prod.sin2.secureserver.net';
    //     $this->mail->SMTPAuth   = true;
    //     $this->mail->Username   = 'myhr@bloomsolutions.in';
    //     $this->mail->Password   = 'bloom@123!@#'; // Replace with actual password
    //     $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Port 465 SSL
    //     $this->mail->Port       = 465;

    //     // SSL stream options for cPanel
    //     $this->mail->SMTPOptions = [
    //         'ssl' => [
    //             'verify_peer'       => false,
    //             'verify_peer_name'  => false,
    //             'allow_self_signed' => true,
    //         ],
    //     ];

    //     // Default Sender
    //     $this->mail->setFrom('myhr@bloomsolutions.in', 'Bloom HRMS');
    //     $this->mail->isHTML(true);

    //     $this->logStep("EmailService::__construct() completed");
    // }


    public function __construct()
    {
        $this->mail = new PHPMailer(true);

        // Production Mode: Disable debug output
        $this->mail->SMTPDebug = SMTP::DEBUG_OFF;

        // Localhost Relay Configuration (Bypasses cPanel/GoDaddy Port 465 Firewall Blocks)
        $this->mail->isSMTP();
        $this->mail->Host        = 'localhost';
        $this->mail->SMTPAuth    = false;
        $this->mail->Username    = '';
        $this->mail->Password    = '';
        $this->mail->SMTPSecure  = false;
        $this->mail->SMTPAutoTLS = false;
        $this->mail->Port        = 25;

        // Default Sender Identity
        $this->mail->setFrom('myhr@bloomsolutions.in', 'Bloom HRMS');
        $this->mail->isHTML(true);
    }

    /**
     * Private core engine to handle recipient clearing, formatting, and sending
     */
    private function sendEmail(string $toEmail, string $toName, string $subject, string $htmlBody): bool
    {
        try {
            $this->mail->clearAddresses();
            $this->mail->addAddress($toEmail, $toName);

            $this->mail->Subject = $subject;
            $this->mail->Body    = $htmlBody;
            // Generates plain-text fallback for basic email clients
            $this->mail->AltBody = strip_tags(str_replace(['<br>', '<br/>', '<br />'], "\n", $htmlBody));

            return $this->mail->send();
        } catch (Exception $e) {
            log_message('error', 'EmailService PHPMailer Error: ' . $this->mail->ErrorInfo);
            return false;
        }
    }

    // =========================================================================
    // SCENARIO 1: Password Reset
    // =========================================================================
    public function sendPasswordReset(string $toEmail, string $toName, string $resetLink): bool
    {
        $subject = 'Reset Your Password - Bloom HRMS';

        $htmlBody = "
            <div style='font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #e0e0e0; border-radius: 8px;'>
                <div style='text-align: center; margin-bottom: 15px;'>
                    <img src='" . base_url('public/dist/img/Bloom logo.jpg') . "'
                        alt='Bloom HRMS'
                        style='max-height: 60px; width: auto;'>
                </div>
                <hr style='border: none; border-top: 1px solid #eee;'>
                <p>Hello <strong>{$toName}</strong>,</p>
                <p>We received a request to reset your account password. Click the button below to set a new password:</p>
                <p style='margin: 25px 0; text-align: center;'>
                    <a href='{$resetLink}' style='background-color: #007bff; color: #ffffff; padding: 12px 24px; text-decoration: none; border-radius: 5px; font-weight: bold; display: inline-block;'>Reset Password</a>
                </p>
                <p style='font-size: 13px; color: #666;'>If the button above does not work, copy and paste this link into your browser:</p>
                <p style='font-size: 13px;'><a href='{$resetLink}'>{$resetLink}</a></p>
                <br>
                <p style='font-size: 12px; color: #888;'>If you did not initiate this request, you can safely ignore this email.</p>
                <hr style='border: none; border-top: 1px solid #eee;'>
                <p style='font-size: 12px; color: #999; text-align: center;'>&copy; " . date('Y') . " Bloom Solutions. All rights reserved.</p>
            </div>
        ";

        return $this->sendEmail($toEmail, $toName, $subject, $htmlBody);
    }

    // =========================================================================
    // SCENARIO 2: Onboarding Welcome Email
    // =========================================================================
    public function sendCandidateOnboardingLink(string $toEmail, string $toName, string $refId, string $token, string $onboardingUrl): bool
    {
        $subject = 'Candidate Onboarding Details - Bloom Solutions';

        $htmlBody = "
            <div style='font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #e0e0e0; border-radius: 8px;'>
                <div style='text-align: center; margin-bottom: 15px;'>
                    <img src='" . base_url('public/dist/img/Bloom logo.jpg') . "'
                        alt='Bloom Solutions'
                        style='max-height: 60px; width: auto;'>
                </div>
                <hr style='border: none; border-top: 1px solid #eee;'>
                <p>Dear <strong>{$toName}</strong>,</p>
                <p>Your onboarding account has been created successfully. Please use the credentials below to complete your registration process:</p>


                <p><b>Onboarding Verification URL:</b></p>
                <p style='margin: 20px 0;'>
                    <a href='{$onboardingUrl}' style='background-color: #007bff; color: #ffffff; padding: 10px 20px; text-decoration: none; border-radius: 4px; display: inline-block; font-weight: bold;'>Complete Onboarding</a>
                </p>
                <p style='font-size: 13px; color: #666;'>If the button above does not work, copy and paste this link into your browser:</p>
                <p style='font-size: 13px;'><a href='{$onboardingUrl}'>{$onboardingUrl}</a></p>
                <br>
                <hr style='border: none; border-top: 1px solid #eee;'>
                <p style='font-size: 12px; color: #888;'>Regards,<br><strong>Bloom Solutions Team</strong></p>
            </div>
        ";

        return $this->sendEmail($toEmail, $toName, $subject, $htmlBody);
    }

    // =========================================================================
    // SCENARIO 3: Final Onboarding Approval & HRMS Credentials
    // =========================================================================
    public function sendFinalOnboardingApproval(string $toEmail, string $empId, string $password, string $loginUrl): bool
    {
        $subject = 'HRMS Login Credentials - Onboarding Completed';

        $htmlBody = "
            <div style='font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #e0e0e0; border-radius: 8px;'>
                        <div style='text-align: center; margin-bottom: 20px;'>
                    <img src='" . base_url('public/dist/img/Bloom logo.jpg') . "'
                        alt='Bloom Solutions'
                        style='max-height: 60px; width: auto;'>
                </div>
                <h2 style='color: #28a745;'>Congratulations! 🎉</h2>
                <p>Your onboarding process has been successfully completed and approved.</p>
                <p>Here are your official HRMS login credentials:</p>
                
                <div style='background-color: #f8f9fa; padding: 15px; border-left: 4px solid #28a745; margin: 20px 0;'>
                    <p style='margin: 5px 0;'><b>Employee ID:</b> {$empId}</p>
                    <p style='margin: 5px 0;'><b>Password:</b> {$password}</p>
                </div>

                <p style='margin: 20px 0;'>
                    <a href='{$loginUrl}' style='background-color: #28a745; color: #ffffff; padding: 10px 20px; text-decoration: none; border-radius: 4px; display: inline-block; font-weight: bold;'>Click to Login</a>
                </p>
                <br>
                <hr style='border: none; border-top: 1px solid #eee;'>
                <p style='font-size: 12px; color: #888;'>Regards,<br><strong>Bloom Solutions HR Team</strong></p>
            </div>
        ";

        return $this->sendEmail($toEmail, 'Employee', $subject, $htmlBody);
    }

    // =========================================================================
    // SCENARIO 4: Birthday Wishes
    // =========================================================================
    public function sendBirthdayWishes(string $toEmail, string $toName): bool
    {
        $subject = "Happy Birthday, {$toName}! 🎂";

        $htmlBody = "
            <div style='font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 25px; text-align: center; border: 1px solid #e0e0e0; border-radius: 8px;'>
                        <div style='margin-bottom: 20px;'>
                    <img src='" . base_url('public/dist/img/Bloom logo.jpg') . "'
                        alt='Bloom Solutions'
                        style='max-height: 60px; width: auto;'>
                </div>
                <h1 style='color: #e83e8c;'>Happy Birthday, {$toName}! 🎈</h1>
                <p style='font-size: 16px;'>Wishing you a fantastic day filled with joy, happiness, and success!</p>
                <p>Thank you for being a valued member of our team.</p>
                <br>
                <p style='font-size: 13px; color: #666;'>Warm regards,<br><strong>Everyone at Bloom Solutions</strong></p>
            </div>
        ";

        return $this->sendEmail($toEmail, $toName, $subject, $htmlBody);
    }
}