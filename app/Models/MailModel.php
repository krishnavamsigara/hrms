<?php

namespace App\Models;

use CodeIgniter\Model;

class MailModel extends Model
{
    protected $db;

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
        $this->ensureTablesExist();
    }

    private function ensureTablesExist()
    {
        if (!$this->db->tableExists('mail_settings')) {
            $forge = \Config\Database::forge();
            $forge->addField([
                'id'          => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
                'smtp_host'   => ['type' => 'VARCHAR', 'constraint' => '255', 'null' => true],
                'smtp_port'   => ['type' => 'INT', 'constraint' => 5, 'default' => 587],
                'smtp_user'   => ['type' => 'VARCHAR', 'constraint' => '255', 'null' => true],
                'smtp_pass'   => ['type' => 'VARCHAR', 'constraint' => '255', 'null' => true],
                'smtp_crypto' => ['type' => 'VARCHAR', 'constraint' => '10', 'default' => 'tls'],
                'from_email'  => ['type' => 'VARCHAR', 'constraint' => '255', 'null' => true],
                'from_name'   => ['type' => 'VARCHAR', 'constraint' => '255', 'null' => true],
                'updated_at'  => ['type' => 'DATETIME', 'null' => true],
            ]);
            $forge->addKey('id', true);
            $forge->createTable('mail_settings', true);
        }

        if (!$this->db->tableExists('mail_logs')) {
            $forge = \Config\Database::forge();
            $forge->addField([
                'id'              => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
                'recipient_email' => ['type' => 'VARCHAR', 'constraint' => '255'],
                'recipient_name'  => ['type' => 'VARCHAR', 'constraint' => '255', 'null' => true],
                'category'        => ['type' => 'VARCHAR', 'constraint' => '50'],
                'subject'         => ['type' => 'VARCHAR', 'constraint' => '255'],
                'message_body'    => ['type' => 'TEXT', 'null' => true],
                'attachment'      => ['type' => 'VARCHAR', 'constraint' => '255', 'null' => true],
                'status'          => ['type' => 'VARCHAR', 'constraint' => '20', 'default' => 'sent'],
                'error_message'   => ['type' => 'TEXT', 'null' => true],
                'sent_by'         => ['type' => 'VARCHAR', 'constraint' => '100', 'null' => true],
                'created_at'      => ['type' => 'DATETIME', 'null' => true],
            ]);
            $forge->addKey('id', true);
            $forge->createTable('mail_logs', true);
        }

        if (!$this->db->tableExists('mail_templates')) {
            $forge = \Config\Database::forge();
            $forge->addField([
                'id'               => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
                'category'         => ['type' => 'VARCHAR', 'constraint' => '50'],
                'template_name'    => ['type' => 'VARCHAR', 'constraint' => '255'],
                'subject_template' => ['type' => 'VARCHAR', 'constraint' => '255'],
                'body_template'    => ['type' => 'TEXT'],
                'updated_at'       => ['type' => 'DATETIME', 'null' => true],
            ]);
            $forge->addKey('id', true);
            $forge->addUniqueKey('category');
            $forge->createTable('mail_templates', true);
            $this->seedDefaultTemplates();
        }
    }

    private function seedDefaultTemplates()
    {
        $templates = [
            [
                'category'         => 'offer_letter',
                'template_name'    => 'Employment Offer Letter',
                'subject_template' => 'Job Offer Letter - {designation} | {company_name}',
                'body_template'    => '<div style="font-family: Arial, sans-serif; max-width: 650px; margin: 0 auto; border: 1px solid #e0e0e0; border-radius: 8px; overflow: hidden; background-color: #ffffff;"><div style="background: linear-gradient(135deg, #111c43 0%, #1e2d67 100%); padding: 25px; text-align: center; color: #ffffff;"><h2 style="margin: 0; font-size: 24px;">Offer of Employment</h2><p style="margin: 5px 0 0 0; font-size: 14px; color: #4a8cff;">{company_name} HR Team</p></div><div style="padding: 30px; color: #333333; line-height: 1.6;"><p>Dear <strong>{candidate_name}</strong>,</p><p>We are delighted to extend an offer of employment for the position of <strong>{designation}</strong> at <strong>{company_name}</strong>.</p><div style="background-color: #f8fafc; border-left: 4px solid #4a8cff; padding: 15px; margin: 20px 0; border-radius: 4px;"><p style="margin: 0 0 8px 0;"><strong>Position:</strong> {designation}</p><p style="margin: 0 0 8px 0;"><strong>Expected Date of Joining:</strong> {joining_date}</p><p style="margin: 0;"><strong>Annual Compensation (CTC):</strong> {ctc}</p></div>{custom_notes_section}<p>Please find the formal offer details attached to this email. We kindly ask you to review, sign, and return the accepted copy before your joining date.</p><p style="margin-top: 30px;">We are looking forward to having you on our team!</p><p>Best regards,<br><strong>HR Department</strong><br>{company_name}</p></div><div style="background-color: #f1f5f9; padding: 15px; text-align: center; font-size: 12px; color: #64748b;">This is an automated email from {company_name} HRMS system. Please do not reply directly to this notification.</div></div>',
                'updated_at'       => date('Y-m-d H:i:s'),
            ],
            [
                'category'         => 'meet_invite',
                'template_name'    => 'Google Meet Invitation',
                'subject_template' => 'Invitation: {meeting_title} - {company_name}',
                'body_template'    => '<div style="font-family: Arial, sans-serif; max-width: 650px; margin: 0 auto; border: 1px solid #e0e0e0; border-radius: 8px; overflow: hidden; background-color: #ffffff;"><div style="background: linear-gradient(135deg, #0f9d58 0%, #0b8043 100%); padding: 25px; text-align: center; color: #ffffff;"><h2 style="margin: 0; font-size: 24px;">Google Meet Invitation</h2><p style="margin: 5px 0 0 0; font-size: 14px; color: #e8f5e9;">{company_name} Video Meeting</p></div><div style="padding: 30px; color: #333333; line-height: 1.6;"><p>Hello <strong>{recipient_name}</strong>,</p><p>You have been invited to a Google Meet session with the {company_name} team.</p><div style="background-color: #f0fdf4; border-left: 4px solid #0f9d58; padding: 18px; margin: 20px 0; border-radius: 6px;"><h3 style="margin: 0 0 10px 0; color: #166534;">{meeting_title}</h3><p style="margin: 0 0 6px 0;">📅 <strong>Date:</strong> {meeting_date}</p><p style="margin: 0 0 6px 0;">⏰ <strong>Time:</strong> {meeting_time}</p><p style="margin: 0 0 15px 0;">📌 <strong>Agenda:</strong><br>{agenda}</p><div style="text-align: center; margin-top: 20px;"><a href="{meet_url}" target="_blank" style="background-color: #0f9d58; color: #ffffff; padding: 12px 24px; font-weight: bold; text-decoration: none; border-radius: 5px; display: inline-block;">Join Google Meet</a></div></div><p style="font-size: 13px; color: #666666;">Direct Meeting Link: <a href="{meet_url}" style="color: #0f9d58;">{meet_url}</a></p><p style="margin-top: 25px;">Please join the meeting 5 minutes prior to the scheduled time.</p><p>Warm regards,<br><strong>{company_name} Team</strong></p></div><div style="background-color: #f1f5f9; padding: 15px; text-align: center; font-size: 12px; color: #64748b;">Sent via {company_name} HRMS Mail Center.</div></div>',
                'updated_at'       => date('Y-m-d H:i:s'),
            ],
            [
                'category'         => 'custom',
                'template_name'    => 'General / Custom Notification',
                'subject_template' => '{subject}',
                'body_template'    => '<div style="font-family: Arial, sans-serif; max-width: 650px; margin: 0 auto; border: 1px solid #e0e0e0; border-radius: 8px; overflow: hidden; background-color: #ffffff;"><div style="background: linear-gradient(135deg, #17a2b8 0%, #117a8b 100%); padding: 25px; text-align: center; color: #ffffff;"><h2 style="margin: 0; font-size: 24px;">{subject}</h2><p style="margin: 5px 0 0 0; font-size: 14px; color: #e0f7fa;">{company_name}</p></div><div style="padding: 30px; color: #333333; line-height: 1.6;"><p>Dear <strong>{recipient_name}</strong>,</p><div style="margin: 20px 0;">{message_body}</div><p style="margin-top: 30px;">Best regards,<br><strong>{company_name} Team</strong></p></div><div style="background-color: #f1f5f9; padding: 15px; text-align: center; font-size: 12px; color: #64748b;">Sent via {company_name} HRMS.</div></div>',
                'updated_at'       => date('Y-m-d H:i:s'),
            ]
        ];

        foreach ($templates as $tmpl) {
            $this->db->table('mail_templates')->insert($tmpl);
        }
    }

    public function getSettings()
    {
        $builder = $this->db->table('mail_settings');
        $row = $builder->get()->getFirstRow('array');
        return $row ?: [];
    }

    public function saveSettings($data)
    {
        $builder = $this->db->table('mail_settings');
        $existing = $builder->get()->getFirstRow('array');
        $data['updated_at'] = date('Y-m-d H:i:s');

        if ($existing) {
            return $builder->where('id', $existing['id'])->update($data);
        } else {
            return $builder->insert($data);
        }
    }

    public function logMail($data)
    {
        $builder = $this->db->table('mail_logs');
        $data['created_at'] = date('Y-m-d H:i:s');
        return $builder->insert($data);
    }

    public function getMailLogs($category = null, $limit = 100)
    {
        $builder = $this->db->table('mail_logs');
        if ($category && $category !== 'all') {
            $builder->where('category', $category);
        }
        $builder->orderBy('created_at', 'DESC');
        $builder->limit($limit);
        return $builder->get()->getResultArray();
    }

    public function getMailLogById($id)
    {
        $builder = $this->db->table('mail_logs');
        return $builder->where('id', $id)->get()->getRowArray();
    }

    public function getTemplate($category)
    {
        if (!$this->db->tableExists('mail_templates')) {
            $this->ensureTablesExist();
        }
        $builder = $this->db->table('mail_templates');
        $row = $builder->where('category', $category)->get()->getRowArray();
        return $row ?: null;
    }

    public function getAllTemplates()
    {
        if (!$this->db->tableExists('mail_templates')) {
            $this->ensureTablesExist();
        }
        $builder = $this->db->table('mail_templates');
        return $builder->get()->getResultArray();
    }

    public function saveTemplate($category, $subjectTemplate, $bodyTemplate, $templateName = null)
    {
        if (!$this->db->tableExists('mail_templates')) {
            $this->ensureTablesExist();
        }
        $builder = $this->db->table('mail_templates');
        $existing = $builder->where('category', $category)->get()->getRowArray();

        $data = [
            'category'         => $category,
            'subject_template' => $subjectTemplate,
            'body_template'    => $bodyTemplate,
            'updated_at'       => date('Y-m-d H:i:s'),
        ];
        if ($templateName) {
            $data['template_name'] = $templateName;
        }

        if ($existing) {
            return $builder->where('id', $existing['id'])->update($data);
        } else {
            if (empty($data['template_name'])) {
                $data['template_name'] = ucfirst(str_replace('_', ' ', $category));
            }
            return $builder->insert($data);
        }
    }
}

