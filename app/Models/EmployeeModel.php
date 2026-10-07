<?php

namespace App\Models;

use App\Models\AdminModel; //Admin Model
use CodeIgniter\Model;

class EmployeeModel extends Model
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

    public function get_emp_leave($empid, $year)
    {
        return $this->callProcedure('hr_get_employee_leave_dashboard', [$empid, $year]);
    }

    public function get_leave_type()
    {
        return $this->callProcedure('hr_get_leave_types', []);
    }

    public function leave_apply($empid, $leave_code, $fromdate, $todate, $reason)
    {
        return $this->callProcedure('hr_apply_leave', [$empid, $leave_code, $fromdate, $todate, $reason]);
    }

    public function get_leave_history($empid, $user_category, $status, $fromdate, $todate)
    {
        return $this->callProcedure('hr_get_leave_application', [$empid, $user_category, $status, $fromdate, $todate]);
    }

    //Leave History
    public function get_emp_leave_history($empid)
    {
        return $this->callProcedure('hr_get_leave_history', [$empid]);
    }

    //Leave Accept/Reject
    public function leave_decision($leave_id, $decision, $manager_id, $reason = null)
    {
        return $this->callProcedure('hr_leave_action', [$leave_id, $decision, $manager_id, $reason], false);
    }

    //REQUEST RAISING
    public function leave_request($empid, $month = null, $year = null)
    {
        return $this->callProcedure('hrms_get_requests', [$empid, $month, $year]);
    }

    public function update_attendance_punch($emp_id, $attendance_date, $first_in, $last_out, $request_id, $actor_emp_id)
    {
        return $this->callProcedure('hrms_update_attendance_punch', [$emp_id, $attendance_date, $first_in, $last_out, $request_id, $actor_emp_id], true);
    }

    public function get_missing_punchouts($month = null, $year = null, $emp_id = null, $day_name = null)
    {
        return $this->callProcedure('hrms_get_missing_punchouts', [$month, $year, $emp_id, $day_name]);
    }

    public function get_request_types()
    {
        return $this->callProcedure('hrms_get_request_types', []);
    }
    
    public function update_requests($action, $request_id, $actor_emp_id,$category,$subject, $description,$attachment_path, $progress,
    $reason)
    {
        return $this->callProcedure('hrms_update_requests', [$action, $request_id, $actor_emp_id,$category,$subject,$description,
        $attachment_path,$progress, $reason ],false);
     }
     

    public function get_emp_dash($empid)
    {
        return $this->callProcedure('getemployeedashboard', [$empid]);
    }
    
    public function employee_attendance_punch($empid, $ip_address, $punch_type)
    {
        return $this->callProcedure('employee_attendance_punch', [$empid,$ip_address,$punch_type]);
    }

    public function get_emp_Attendance($empid, $month, $year)
    {
        return $this->callProcedure('get_employee_attendance_details', [$empid,$month, $year]);
    }

    public function get_emp_attend($empid, $month, $year)
    {
        return $this->callProcedure('get_employee_attendance_dashboard', [$empid,$month, $year]);
    }

    public function get_emp_report($empid, $month, $year)
    {
        return $this->callProcedure('get_employee_attendence_reporting_to', [$empid,$month, $year]);
    }

    public function get_emp_summary($empid, $month, $year)
    {
        return $this->callProcedure('get_attendence_period_summary_details', [$empid,$month, $year]);
    }

}
