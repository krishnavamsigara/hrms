<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\NotificationModel;

class NotificationController extends BaseController
{
    public function index()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to(base_url('/'));
        }

        $emp_id = $session->get('emp_id');
        $model = new NotificationModel();

        $notifications = $model->get_user_notifications($emp_id);
        
        $data['notifications'] = $notifications;

        return view('Layouts/Header')
            . view('Layouts/Sidebar')
            . view('employee/notifications', $data)
            . view('Layouts/Footer');
    }

    public function mark_read()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return $this->response->setJSON(['status' => 'N', 'remarks' => 'Unauthorized']);
        }

        $emp_id = $session->get('emp_id');
        $notification_id = $this->request->getPost('notification_id') ?: null;

        $model = new NotificationModel();
        $result = $model->mark_notification_read($emp_id, $notification_id);

        if ($this->request->isAJAX()) {
            return $this->response->setJSON(['status' => 'Y', 'remarks' => 'Marked as read']);
        }

        return redirect()->back()->with('success', 'Notifications updated');
    }

    public function get_unread_count()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return $this->response->setJSON(['status' => 'N', 'unread_count' => 0, 'items' => []]);
        }

        $emp_id = $session->get('emp_id');
        $model = new NotificationModel();
        $notifications = $model->get_user_notifications($emp_id);

        $unread_count = 0;
        $items = [];

        if (!empty($notifications)) {
            foreach ($notifications as $row) {
                if (isset($row['is_read']) && (int)$row['is_read'] === 0) {
                    $unread_count++;
                }
                if (count($items) < 5) {
                    $items[] = [
                        'notification_id' => $row['notification_id'] ?? 0,
                        'category'        => $row['category'] ?? 'GENERAL',
                        'title'           => $row['title'] ?? '',
                        'message'         => $row['message'] ?? '',
                        'created_at'      => $row['created_at'] ?? '',
                        'is_read'         => $row['is_read'] ?? 0,
                        'sender_name'     => $row['sender_name'] ?? 'System'
                    ];
                }
            }
        }

        return $this->response->setJSON([
            'status'       => 'Y',
            'unread_count' => $unread_count,
            'items'        => $items
        ]);
    }
}
