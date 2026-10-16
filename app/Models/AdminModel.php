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

        $sql = !empty($params) ? "CALL {$procedureName}({$placeholders})" : "CALL {$procedureName}()";

        $query = $this->db->query($sql, $params);

        if ($this->db->connID instanceof \mysqli) {
            try {
                while (@mysqli_more_results($this->db->connID) && @mysqli_next_result($this->db->connID)) {
                    // Drain extra result sets left by MySQL stored procedure CALL
                }
            } catch (\Throwable $ex) {
                // Suppress PHP 8.1+ strict mysqli exception
            }
        }

        if ($isQuery) {
            return $query ? $query->getResultArray() : [];
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

    public function save_holiday($mode, $holiday_id, $holiday_date, $holiday_name, $holiday_type, $applicable_for, $status)
    {
        return $this->callProcedure(
            'sp_holiday_cud',
            [$mode, $holiday_id, $holiday_date, $holiday_name, $holiday_type, $applicable_for, $status]
        );
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

    public function save_department($mode, $department_id, $department_name, $status)
    {
        return $this->callProcedure(
            'sp_department_cud',
            [$mode, $department_id, $department_name, $status]
        );
    }

    public function get_designations()
    {
        return $this->callProcedure('hr_get_designations', []);
    }

    public function save_designation($mode, $designation_id, $designation_name, $status)
    {
        return $this->callProcedure(
            'sp_designation_cud',
            [$mode, $designation_id, $designation_name, $status]
        );
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

    public function add_new_employee($emp_id, $jsonData)
    {
    return $this->callProcedure('hr_add_new_employee', [$emp_id, $jsonData]);
    }

    public function get_attendence_to_admin($emp_id, $day, $month, $year)
    {  
    return $this->callProcedure('get_attendence_today_admin', [$emp_id, $day, $month, $year]);
    }

    public function get_attendence_everyday($emp_id, $day, $month, $year, $user_category)
    {  
    return $this->callProcedure('get_attendence_admin_every_day', [$emp_id, $day, $month, $year, $user_category]);
    }
    
    public function get_monthly_report($emp_id,$month, $year, $user_category)
    {  
        return $this->callProcedure('get_attendence_monthly_report',[$emp_id,$month, $year,$user_category]);
    }

    public function get_leave_types()
    {
        return $this->callProcedure('hr_get_leave_types', []);
    }

    public function save_leave_type($mode, $leave_type_id, $leave_code, $leave_name, $year, $yearly_quota, $carry_forward_flag, $max_carry_forward, $encashment_flag, $requires_approval, $affects_salary, $gender_applicable, $status, $is_accrual)
    {
        return $this->callProcedure(
            'sp_leave_type_cud',
            [
                $mode, $leave_type_id, $leave_code, $leave_name, $year, $yearly_quota,
                $carry_forward_flag, $max_carry_forward, $encashment_flag, $requires_approval,
                $affects_salary, $gender_applicable, $status, $is_accrual
            ]
        );
    }

    public function generate_leave_balances($year)
    {
        return $this->callProcedure('hr_generate_leave_balances', [$year]);
    }

    /**
     * Admin edit of an ABSENT attendance record.
     * Supports WFH (with punch timings), PL/SL/CL (with balance deduction + leave_application),
     * or LOP (forced Loss of Pay).
     *
     * @param string      $emp_id
     * @param string      $att_date       Y-m-d
     * @param string      $edit_type      WFH | PL | SL | CL | LOP
     * @param string|null $punch_in       Y-m-d H:i:s  (required for WFH)
     * @param string|null $punch_out      Y-m-d H:i:s  (required for WFH)
     * @param string      $admin_emp_id
     * @return array ['status' => 'Y'|'N', 'message' => '...']
     */
    public function admin_edit_absent_attendance(
        string  $emp_id,
        string  $att_date,
        string  $edit_type,
        ?string $punch_in,
        ?string $punch_out,
        string  $admin_emp_id
    ): array {
        $pi = $punch_in  ?? 'NULL';
        $po = $punch_out ?? 'NULL';

        // Use session variables for OUT parameters (MySQL stored proc OUT params)
        $this->db->query("SET @p_status = '', @p_message = ''");

        $sql = "CALL sp_admin_edit_absent_attendance(?, ?, ?, ?, ?, ?, @p_status, @p_message)";
        $this->db->query($sql, [
            $emp_id,
            $att_date,
            strtoupper($edit_type),
            $admin_emp_id,
            $punch_in,
            $punch_out
        ]);

        $row = $this->db->query("SELECT @p_status AS status, @p_message AS message")->getRowArray();

        return [
            'status'  => $row['status']  ?? 'N',
            'message' => $row['message'] ?? 'Unknown error'
        ];
    }

    /**
     * Generate Payroll Attendance Summary for a specific month and year
     *
     * @param int $month
     * @param int $year
     * @param string $admin_emp_id
     * @return array
     */
    public function generate_payroll_attendance(int $month, int $year, string $admin_emp_id): array
    {
        $this->db->query("SET @p_status = '', @p_message = ''");

        $sql = "CALL sp_generate_payroll_attendance(?, ?, ?, @p_status, @p_message)";
        $this->db->query($sql, [
            $month,
            $year,
            $admin_emp_id
        ]);

        $row = $this->db->query("SELECT @p_status AS status, @p_message AS message")->getRowArray();

        return [
            'status'  => $row['status']  ?? 'N',
            'message' => $row['message'] ?? 'Unknown error'
        ];
    }

    /**
     * Get payroll attendance summary data with employee details
     */
    public function get_payroll_attendance_data(int $month, int $year, string $emp_id): array
    {
        $sql = "CALL get_payroll_attendance_data_proc(?, ?, ?)";
        return $this->db->query($sql, [$emp_id, $month, $year])->getResultArray();
    }
    
    public function finalize_payroll_attendance(int $month, int $year, string $emp_id): bool
    {
        $sql = "CALL finalize_payroll_attendance_proc(?, ?, ?)";
        return $this->db->query($sql, [$emp_id, $month, $year]);
    }

    public function get_attendance_overview(string $emp_id, string $startDate, string $endDate, string $searchParam): array
    {
        return $this->callProcedure('get_attendance_overview_data', [$emp_id, $startDate, $endDate, $searchParam]);
    }

    public function get_active_users_dropdown(): array
    {
        return $this->callProcedure('getactiveUsersfordropdown', []);
    }

    public function get_user_details(string $emp_id): array
    {
        $res = $this->callProcedure('get_user_details', [$emp_id]);
        return (!empty($res) && isset($res[0])) ? $res[0] : ($res ?: []);
    }

    public function get_payroll_attendance_summary_stats(int $month, int $year): array
    {
        $res = $this->callProcedure('sp_get_payroll_attendance_summary_stats', [$month, $year]);
        return (!empty($res) && isset($res[0])) ? $res[0] : [];
    }

    public function get_attendance_punch_stats(string $startDate, string $endDate): array
    {
        $res = $this->callProcedure('sp_get_attendance_punch_stats', [$startDate, $endDate]);
        return (!empty($res) && isset($res[0])) ? $res[0] : [
            'total_punches'       => 0,
            'active_punched_emps' => 0,
            'present_count'       => 0,
            'wfh_count'           => 0,
            'leave_count'         => 0,
            'absent_count'        => 0
        ];
    }

    public function get_annual_attendance_matrix(int $year, int $cycleStartDay, string $startFilter, string $endFilter): array
    {
        return $this->callProcedure('sp_get_annual_attendance_matrix', [$year, $cycleStartDay, $startFilter, $endFilter]);
    }

    public function get_annual_payroll_summary(int $year): array
    {
        return $this->callProcedure('sp_get_annual_payroll_summary', [$year]);
    }

    public function get_raw_attendance_punch_counts(string $startDate, string $endDate): array
    {
        $res = $this->callProcedure('sp_get_raw_attendance_punch_counts', [$startDate, $endDate]);
        return (!empty($res) && isset($res[0])) ? $res[0] : ['raw_punches' => 0, 'raw_emps' => 0];
    }
}


