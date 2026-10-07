<?php

namespace App\Models;

use App\Models\OnboardingModel; //Onbarding Model
use App\Models\ManagerModel; //ManagerModel
use CodeIgniter\Model;

class AdminModel extends Model
{

    protected $db;

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }

    // Common Procedure Caller

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

        return $this->db->affectedRows() > 0;
    }

    // Create Candidate

    public function createCandidate($candidate_type, $emp_name, $email, $mobile, $experience, $offerletter, $created_by)
    {
        return $this->callProcedure(
            'hr_create_candidate',
            [
                $candidate_type,
                $emp_name,
                $email,
                $mobile,
                $experience,
                $offerletter,
                $created_by
            ]
        );
    }

    public function getcandidate($hr,$onboarding_status,$offer_status ,$candidate_type)
    {
        return $this->callProcedure('get_candidate_list', [$hr,$onboarding_status,$offer_status ,$candidate_type]);
    }

    public function getmgr($emp_id, $null)
    {
        return $this->callProcedure('get_user_drop_down', [$emp_id, $null]);
    }

    public function updatecand($refid, $jsonData)
    {
        return $this->callProcedure('save_candidate_details', [$refid, $jsonData]);
    }

    public function finalsubmit($refid,$empid)
    {
        return $this->callProcedure('hr_approve_candidate', [$refid ,$empid]);
    }

    public function getholidaylist()
    {
        return $this->callProcedure('hr_get_holiday_master', []);
    
    }
   
    public function get_announcement($empid)
    {
        return $this->callProcedure('hr_announcement_get', [$empid]);
    
    }

    public function save_announcement($mode,$announcement_id,$title,$message,$user_category, $status,$empid)
    {
    return $this->callProcedure(
        'hr_announcement_save',
        [
            $mode,
            $announcement_id,
            $title,
            $message,
            $user_category,
            $status,
            $empid
        ],false );
    }

    public function get_leave_balance($empid,$user_category,$month,$year)
    {
        return $this->callProcedure('get_employee_leave_summary', [$empid,$user_category,$month,$year]);
    
    }

    public function get_month_details($empid,$user_category,$month,$year)
    {
        return $this->callProcedure('hr_get_leave_detailed_report', [$empid,$user_category,$month,$year]);
    }

    public function update_user_details($emp_id, $jsonData)
    {
    return $this->callProcedure('hrms_update_user_details', [$emp_id, $jsonData]);
    }

    public function get_adm_dash($emp_id, $user_category)
    {
    return $this->callProcedure('get_admin_dashboard', [$emp_id, $user_category]);
    }

    public function get_departments()
    {
    return $this->callProcedure('hr_get_departments', []);
    }

    public function get_birthday()
    {
    return $this->callProcedure('hr_get_upcoming_birthdays', []);
    }
    
    public function toggle_user_status($admin_emp_id, $admin_category, $target_emp_id)
    {
    return $this->callProcedure(
        'hr_toggle_user_status',
        [$admin_emp_id, $admin_category, $target_emp_id] );
    }

}

