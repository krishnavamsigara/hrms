<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMailTables extends Migration
{
    public function up()
    {
        // mail_settings table
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'smtp_host' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'smtp_port' => [
                'type'       => 'INT',
                'constraint' => 5,
                'default'    => 587,
            ],
            'smtp_user' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'smtp_pass' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'smtp_crypto' => [
                'type'       => 'VARCHAR',
                'constraint' => '10',
                'default'    => 'tls',
            ],
            'from_email' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'from_name' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('mail_settings', true);

        // mail_logs table
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'recipient_email' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'recipient_name' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'category' => [
                'type'       => 'VARCHAR',
                'constraint' => '50', // offer_letter, meet_invite, custom
            ],
            'subject' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'message_body' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'attachment' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'status' => [
                'type'       => 'VARCHAR',
                'constraint' => '20', // sent, failed
                'default'    => 'sent',
            ],
            'error_message' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'sent_by' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('mail_logs', true);
    }

    public function down()
    {
        $this->forge->dropTable('mail_settings', true);
        $this->forge->dropTable('mail_logs', true);
    }
}
