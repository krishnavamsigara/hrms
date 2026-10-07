<?php

namespace App\Models;

use CodeIgniter\Model;

class NotificationModel extends Model
{
    protected $db;

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }

    protected function callProcedure(
        string $procedureName,
        array $params = [],
        bool $isQuery = true
    ) {
        $placeholders = implode(',', array_fill(0, count($params), '?'));
        $sql = "CALL {$procedureName}({$placeholders})";
        $query = $this->db->query($sql, $params);

        if ($isQuery) {
            return $query->getResultArray();
        }

        return true;
    }

    public function create_notification(
        $category,
        $title,
        $message,
        $target_type = 'USER',
        $target_dept_id = null,
        $target_emp_id = null,
        $sender_emp_id = null,
        $reference_id = null
    ) {
        return $this->callProcedure(
            'hr_create_notification',
            [
                $category,
                $title,
                $message,
                $target_type,
                $target_dept_id,
                $target_emp_id,
                $sender_emp_id,
                $reference_id
            ],
            true
        );
    }

    public function get_user_notifications($emp_id)
    {
        return $this->callProcedure('hr_get_user_notifications', [$emp_id], true);
    }

    public function mark_notification_read($emp_id, $notification_id = null)
    {
        return $this->callProcedure('hr_mark_notification_read', [$emp_id, $notification_id], true);
    }
}
