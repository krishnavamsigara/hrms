<?php

namespace App\Models;

use CodeIgniter\Model;

class PayrollModel extends Model
{
    protected $DBGroup = 'default';
    protected $db;

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect('default');
    }

    // Common Stored Procedure Caller
    protected function callProcedure(string $procedureName, array $params = [], bool $isQuery = true)
    {
        try {
            $placeholders = implode(',', array_fill(0, count($params), '?'));
            $sql = !empty($params) ? "CALL {$procedureName}({$placeholders})" : "CALL {$procedureName}()";
            $query = $this->db->query($sql, $params);

            if ($this->db->connID instanceof \mysqli) {
                try {
                    while (@mysqli_more_results($this->db->connID) && @mysqli_next_result($this->db->connID)) {}
                } catch (\Throwable $ex) {}
            }

            if ($isQuery && $query) {
                return is_object($query) ? $query->getResultArray() : [];
            }
            return (bool)$query;
        } catch (\Throwable $e) {
            log_message('error', 'callProcedure Error [' . $procedureName . ']: ' . $e->getMessage());
            return $isQuery ? [] : false;
        }
    }

    // ==========================================
    // 1. SALARY COMPONENTS MASTER
    // ==========================================
    public function get_salary_components()
    {
        return $this->callProcedure('sp_get_salary_components', []);
    }

    public function save_salary_component($data)
    {
        $mode    = !empty($data['id']) ? 'UPDATE' : 'CREATE';
        $id      = $data['id'] ?? 0;
        $code    = $data['component_code'] ?? '';
        $name    = $data['component_name'] ?? '';
        $type    = $data['component_type'] ?? 'EARNING';
        $calc    = $data['calculation_type'] ?? 'FIXED';
        $value   = $data['value'] ?? 0.00;
        $based   = $data['based_on'] ?? 'CTC';
        $is_stat = $data['is_statutory'] ?? 0;
        $is_emp  = $data['is_employer_contribution'] ?? 0;
        $order   = $data['display_order'] ?? 1;

        return $this->callProcedure('sp_salary_component_cud', [
            $mode, $id, $code, $name, $type, $calc, $value, $based, $is_stat, $is_emp, $order
        ], false);
    }

    public function delete_salary_component($id)
    {
        return $this->callProcedure('sp_salary_component_cud', [
            'SOFT_DELETE', $id, '', '', '', '', 0, '', 0, 0, 0
        ], false);
    }

    public function toggle_salary_component($id)
    {
        return $this->callProcedure('sp_salary_component_cud', [
            'TOGGLE', $id, '', '', '', '', 0, '', 0, 0, 0
        ], false);
    }

    // ==========================================
    // 2. EMPLOYEE SALARY STRUCTURE
    // ==========================================
    public function get_emp_salary_structure($emp_id)
    {
        return $this->callProcedure('sp_get_emp_salary_structure', [$emp_id], true);
    }

    public function save_emp_salary_structure($emp_id, $components_data)
    {
        $this->callProcedure('sp_delete_emp_salary_structure', [$emp_id], false);

        foreach ($components_data as $comp) {
            if (empty($comp['component_id'])) continue;
            
            $effective_from = !empty($comp['effective_from']) ? $comp['effective_from'] : date('Y-m-01');

            $this->callProcedure('sp_save_emp_salary_structure', [
                $emp_id,
                (int)$comp['component_id'],
                $comp['calculation_type'] ?? 'FIXED',
                $comp['value'] ?? 0,
                $comp['amount'] ?? 0,
                $effective_from
            ], false);
        }
        return true;
    }

    // ==========================================
    // 3. PAYROLL CYCLES
    // ==========================================
    public function get_all_cycles()
    {
        return $this->callProcedure('sp_get_all_payroll_cycles', []);
    }

    public function get_cycle_by_id($id)
    {
        $res = $this->callProcedure('sp_get_payroll_cycle_by_id', [(int)$id]);
        return (!empty($res) && isset($res[0])) ? $res[0] : null;
    }

    public function create_payroll_cycle($data)
    {
        $res = $this->callProcedure('sp_create_payroll_cycle', [
            $data['payroll_code'],
            $data['period_start'],
            $data['period_end'],
            $data['pay_date'],
            $data['created_by'] ?? 'ADMIN'
        ]);
        return (!empty($res) && isset($res[0]['cycle_id'])) ? (int)$res[0]['cycle_id'] : 0;
    }

    public function check_attendance_finalized(int $month, int $year): array
    {
        $res = $this->callProcedure('sp_check_attendance_finalized', [$month, $year]);
        $row = (!empty($res) && isset($res[0])) ? $res[0] : ['cnt' => 0, 'is_finalized' => 0];
        $count = (int)($row['cnt'] ?? 0);
        $is_finalized = ((int)($row['is_finalized'] ?? 0) === 1);

        return [
            'exists'    => ($count > 0),
            'finalized' => $is_finalized,
            'count'     => $count,
        ];
    }

    public function get_cycle_by_period(string $period_start, string $period_end)
    {
        $res = $this->callProcedure('sp_get_payroll_cycle_by_period', [$period_start, $period_end]);
        return (!empty($res) && isset($res[0])) ? $res[0] : null;
    }

    public function get_cycle_by_code(string $payroll_code)
    {
        $res = $this->callProcedure('sp_get_payroll_cycle_by_code', [$payroll_code]);
        return (!empty($res) && isset($res[0])) ? $res[0] : null;
    }

    public function delete_payroll_cycle(int $cycle_id): bool
    {
        return $this->callProcedure('sp_delete_payroll_cycle', [$cycle_id], false);
    }

    // ==========================================
    // 4. ATTENDANCE SNAPSHOT & ACTIVE EMPLOYEES
    // ==========================================
    public function get_active_employees()
    {
        return $this->callProcedure('sp_get_active_employees_for_payroll', []);
    }

    public function populate_attendance_snapshot($cycle_id)
    {
        $cycle = $this->get_cycle_by_id($cycle_id);
        if (!$cycle) return false;

        $targetMonth = (int)date('m', strtotime($cycle['period_end']));
        $targetYear  = (int)date('Y', strtotime($cycle['period_end']));

        $active_users = $this->get_active_employees();
        $summaryRows  = $this->callProcedure('sp_get_cycle_attendance_summaries', [$targetMonth, $targetYear]);

        if (!empty($summaryRows)) {
            $existing_eids = array_column($active_users, 'emp_id');
            foreach ($summaryRows as $sr) {
                if (!in_array($sr['emp_id'], $existing_eids)) {
                    $active_users[] = ['emp_id' => $sr['emp_id']];
                    $existing_eids[] = $sr['emp_id'];
                }
            }
        }

        if (empty($active_users)) return false;

        $period_start = new \DateTime($cycle['period_start']);
        $period_end   = new \DateTime($cycle['period_end']);
        $period_end->modify('+1 day');
        $daterange = new \DatePeriod($period_start, new \DateInterval('P1D'), $period_end);

        $dates = [];
        foreach ($daterange as $d) {
            $dates[] = $d->format('Y-m-d');
        }

        $this->db->transStart();
        $this->db->table('payroll_attendances')->where('payroll_cycle_id', $cycle_id)->delete();

        // Fetch company holidays from holiday_master via stored procedure
        $holidays = $this->callProcedure('hr_get_holiday_master', []);
        $holiday_dates = [];
        foreach ($holidays as $h) {
            if (!empty($h['holiday_date'])) {
                $holiday_dates[] = date('Y-m-d', strtotime($h['holiday_date']));
            }
        }

        foreach ($active_users as $u) {
            $emp_id = $u['emp_id'];

            // Fetch live attendance records for this employee within period
            $att_records = $this->db->table('attendance')
                ->where('emp_id', $emp_id)
                ->where('attendance_date >=', $cycle['period_start'])
                ->where('attendance_date <=', $cycle['period_end'])
                ->get()->getResultArray();

            $att_map = [];
            foreach ($att_records as $ar) {
                $att_map[$ar['attendance_date']] = $ar;
            }

            foreach ($dates as $dt) {
                $status   = 'PRESENT';
                $is_paid  = 1;
                $in_time  = null;
                $out_time = null;

                if (isset($att_map[$dt])) {
                    $st = strtoupper(trim($att_map[$dt]['status']));
                    if (in_array($st, ['PRESENT', 'P', 'HOP'])) {
                        $status = 'PRESENT';
                        $is_paid = 1;
                    } elseif (in_array($st, ['HOLIDAY', 'HO'])) {
                        $status = 'HOLIDAY';
                        $is_paid = 1;
                    } elseif (in_array($st, ['OFF', 'WO'])) {
                        $status = 'WO';
                        $is_paid = 1;
                    } else {
                        $status = 'ABSENT';
                        $is_paid = 0;
                    }
                    $in_time  = $att_map[$dt]['punch_in'] ?? null;
                    $out_time = $att_map[$dt]['punch_out'] ?? null;
                } else {
                    $dayOfWeek = date('N', strtotime($dt)); // 7 is Sunday
                    if (in_array($dt, $holiday_dates)) {
                        $status  = 'HOLIDAY';
                        $is_paid = 1;
                    } elseif ($dayOfWeek == 7) {
                        $status  = 'WO';
                        $is_paid = 1;
                    } else {
                        $status  = 'PRESENT';
                        $is_paid = 1;
                    }
                }

                $this->db->table('payroll_attendances')->insert([
                    'payroll_cycle_id' => $cycle_id,
                    'emp_id'           => $emp_id,
                    'attendance_date'  => $dt,
                    'status'           => $status,
                    'in_time'          => $in_time,
                    'out_time'         => $out_time,
                    'worked_hours'     => 8.0,
                    'is_paid'          => $is_paid,
                    'created_at'       => date('Y-m-d H:i:s'),
                    'updated_at'       => date('Y-m-d H:i:s'),
                ]);
            }
        }

        $this->db->table('payroll_cycles')->where('id', $cycle_id)->update([
            'status'     => 'ATTENDANCE_IMPORTED',
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        $this->db->transComplete();
        return $this->db->transStatus();
    }

    public function get_cycle_attendance_matrix($cycle_id)
    {
        $cycle = $this->get_cycle_by_id($cycle_id);
        if (!$cycle) return ['dates' => [], 'matrix' => []];

        $period_start = new \DateTime($cycle['period_start']);
        $period_end   = new \DateTime($cycle['period_end']);
        $period_end->modify('+1 day');
        $daterange = new \DatePeriod($period_start, new \DateInterval('P1D'), $period_end);

        $dates = [];
        foreach ($daterange as $d) {
            $dates[] = $d->format('Y-m-d');
        }

        $records = $this->callProcedure('sp_get_cycle_attendance_matrix', [$cycle_id]);

        $matrix = [];
        foreach ($records as $r) {
            $emp_id = $r['emp_id'];
            if (!isset($matrix[$emp_id])) {
                $matrix[$emp_id] = [
                    'emp_id'   => $emp_id,
                    'emp_name' => $r['emp_name'] ?? ('Employee ' . $emp_id),
                    'days'     => [],
                ];
            }
            $matrix[$emp_id]['days'][$r['attendance_date']] = [
                'status'  => $r['status'],
                'is_paid' => $r['is_paid'],
                'id'      => $r['id'],
            ];
        }

        return [
            'dates'  => $dates,
            'matrix' => array_values($matrix),
        ];
    }

    public function import_excel_attendance($cycle_id, $attendance_rows)
    {
        $cycle = $this->get_cycle_by_id($cycle_id);
        if (!$cycle) return false;

        $this->db->transStart();

        $this->db->table('payroll_attendances')->where('payroll_cycle_id', $cycle_id)->delete();

        foreach ($attendance_rows as $row) {
            $emp_id = $row['emp_id'] ?? $row['employee_code'] ?? '';
            if (empty($emp_id)) continue;

            $attendance_date = $row['attendance_date'];
            $status          = strtoupper(trim($row['status'] ?? 'P'));
            $in_time         = !empty($row['in_time']) ? $row['in_time'] : null;
            $out_time        = !empty($row['out_time']) ? $row['out_time'] : null;
            $worked_hours    = !empty($row['worked_hours']) ? (float)$row['worked_hours'] : 8.00;

            $unpaid_statuses = ['A', 'LOP', 'ABSENT', 'UNPAID'];
            $is_paid = in_array($status, $unpaid_statuses) ? 0 : 1;

            $this->db->table('payroll_attendances')->insert([
                'payroll_cycle_id' => $cycle_id,
                'emp_id'           => $emp_id,
                'attendance_date'  => $attendance_date,
                'status'           => $status,
                'in_time'          => $in_time,
                'out_time'         => $out_time,
                'worked_hours'     => $worked_hours,
                'leave_type'       => $row['leave_type'] ?? null,
                'is_paid'          => $is_paid,
                'created_at'       => date('Y-m-d H:i:s'),
                'updated_at'       => date('Y-m-d H:i:s'),
            ]);
        }

        $this->db->table('payroll_cycles')->where('id', $cycle_id)->update([
            'status'     => 'ATTENDANCE_IMPORTED',
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        $this->db->transComplete();
        return $this->db->transStatus();
    }

    public function update_attendance_override($id, $new_status, $reason, $hr_user_id)
    {
        $unpaid_statuses = ['A', 'LOP', 'ABSENT', 'UNPAID'];
        $is_paid = in_array(strtoupper(trim($new_status)), $unpaid_statuses) ? 0 : 1;

        $this->callProcedure('sp_update_attendance_override', [
            (int)$id,
            strtoupper(trim($new_status)),
            $is_paid,
            $reason,
            $hr_user_id
        ]);
        return true;
    }

    // ==========================================
    // 5. PAYROLL CALCULATION ENGINE
    // ==========================================
    public function calculate_payroll_cycle($cycle_id, $calculated_by = 'HR_ADMIN')
    {
        $cycle = $this->get_cycle_by_id($cycle_id);
        if (!$cycle) return false;

        $period_start = new \DateTime($cycle['period_start']);
        $period_end   = new \DateTime($cycle['period_end']);
        $interval     = $period_start->diff($period_end);
        $total_period_days = $interval->days + 1; // e.g. 25-Jul to 24-Aug = 31 days

        $targetMonth = (int)date('m', strtotime($cycle['period_end']));
        $targetYear  = (int)date('Y', strtotime($cycle['period_end']));

        // Check if finalized payroll_attendance_summary exists for this period
        $summary_rows = $this->db->table('payroll_attendance_summary')
            ->where('payroll_month', $targetMonth)
            ->where('payroll_year', $targetYear)
            ->get()->getResultArray();

        $summary_map = [];
        foreach ($summary_rows as $sr) {
            $summary_map[$sr['emp_id']] = $sr;
        }

        // Get list of active employees from user_login_details
        $active_users   = $this->get_active_employees();
        $active_emp_ids = array_column($active_users, 'emp_id');

        // Build list of employees to calculate
        $employees = [];
        if (!empty($summary_map)) {
            foreach ($summary_map as $eid => $srow) {
                $employees[] = ['emp_id' => $eid];
            }
        } elseif (!empty($active_emp_ids)) {
            $employees = $this->db->table('payroll_attendances')
                ->select('emp_id')
                ->where('payroll_cycle_id', $cycle_id)
                ->whereIn('emp_id', $active_emp_ids)
                ->groupBy('emp_id')
                ->get()->getResultArray();
        }

        if (empty($employees)) {
            foreach ($active_users as $u) {
                $employees[] = ['emp_id' => $u['emp_id']];
            }
        }

        $all_components = $this->get_salary_components();
        $component_map  = [];
        foreach ($all_components as $c) {
            $component_map[$c['component_code']] = $c;
        }

        // Get PT Statutory Slabs via stored procedure
        $pt_slabs = $this->callProcedure('sp_get_pt_slabs', ['PT_TELANGANA']);

        $total_cycle_gross      = 0;
        $total_cycle_deductions = 0;
        $total_cycle_net        = 0;
        $employee_count         = 0;

        $this->db->transStart();

        foreach ($employees as $empRow) {
            $emp_id = $empRow['emp_id'];

            // Fetch employee details from user_details DB via stored procedure
            $emp_master_res = $this->callProcedure('get_user_details', [$emp_id]);
            $emp_master = (!empty($emp_master_res) && isset($emp_master_res[0])) ? $emp_master_res[0] : [];
            $emp_name = $emp_master['emp_name'] ?? ('Employee ' . $emp_id);

            // Fetch base salary/CTC from legacy employee_salary via stored procedure
            $legacy_sal_res = $this->callProcedure('sp_get_latest_salary', [$emp_id]);
            $legacy_sal = (!empty($legacy_sal_res) && isset($legacy_sal_res[0])) ? $legacy_sal_res[0] : [];
            $salary = (float)($legacy_sal['salary'] ?? $legacy_sal['ctc1'] ?? 50000.00);

            // Attendance aggregation: Use finalized attendance summary if available
            if (isset($summary_map[$emp_id])) {
                $sum = $summary_map[$emp_id];
                $working_days     = 30; // Standard 30 days per company workbook
                $present_days     = (float)$sum['present_days'];
                $absent_days      = (float)$sum['absent_days'];
                $paid_leave_days  = (float)$sum['leave_days'];
                $holiday_days     = (float)$sum['holiday_days'];
                $weekly_off_days  = (float)$sum['weekly_off_days'];
                $paid_days        = (float)$sum['paid_days'];
                $lop_days         = (float)$sum['unpaid_days'];
            } else {
                $attendance_records = $this->db->table('payroll_attendances')
                    ->where('payroll_cycle_id', $cycle_id)
                    ->where('emp_id', $emp_id)
                    ->get()->getResultArray();

                $present_days   = 0;
                $absent_days    = 0;
                $paid_leave_days= 0;
                $holiday_days   = 0;
                $weekly_off_days= 0;

                if (!empty($attendance_records)) {
                    foreach ($attendance_records as $att) {
                        $st = strtoupper(trim($att['status']));
                        if (in_array($st, ['P', 'HOP', 'PRESENT'])) {
                            $present_days++;
                        } elseif (in_array($st, ['HO', 'HOLIDAY'])) {
                            $holiday_days++;
                        } elseif (in_array($st, ['WO', 'OFF'])) {
                            $weekly_off_days++;
                        } elseif ($att['is_paid'] == 1) {
                            $paid_leave_days++;
                        } else {
                            $absent_days++;
                        }
                    }
                } else {
                    $present_days     = 30;
                    $absent_days      = 0;
                    $paid_leave_days  = 0;
                    $holiday_days     = 0;
                    $weekly_off_days  = 0;
                }

                $working_days = 30;
                $paid_days = $present_days + $paid_leave_days + $holiday_days + $weekly_off_days;
                $lop_days  = max(0, 30 - $paid_days);
            }

            // 1. Leave Salary Deduction = (Salary * Leaves) / 30
            $leave_deduction = round(($salary * $lop_days) / 30, 2);

            // 2. Other Earnings
            $other_earnings = (float)($legacy_sal['other_earnings'] ?? 0.00);

            // 3. CTC1 = Salary - Leave salary deduction + Other Earnings
            $ctc1 = round($salary - $leave_deduction + $other_earnings, 2);

            // 4. Component Earnings based on CTC1
            $basic      = round($ctc1 * 0.50, 2);
            $hra        = round($ctc1 * 0.20, 2);
            $medical    = round($ctc1 * 0.05, 2);
            $conveyance = round($ctc1 * 0.08, 2);

            // 5. Statutory Employer & Employee Contributions
            $pf_employer = ($basic < 15000) ? round($basic * 0.12, 2) : 1800.00;
            $pf_employee = ($basic < 15000) ? round($basic * 0.12, 2) : 1800.00;
            $admin_charges = round(($pf_employee * 13 / 12) - $pf_employer, 2);

            // 6. ESI Flag & Gross Determination
            // ESI eligibility threshold is Gross <= 21,000 INR
            $estimated_gross = $ctc1 * 0.9055;
            $has_legacy_esi  = !empty($legacy_sal['esi_employee_contribution']) && (float)$legacy_sal['esi_employee_contribution'] > 0;
            $esi_eligible    = ($estimated_gross <= 21000.00 || $has_legacy_esi) && $ctc1 > 0;

            if ($esi_eligible) {
                $esi_flag     = 'YES';
                $gross_salary = round($ctc1 * 0.9055, 2);
                $esi_employer = ($gross_salary < 21001.00) ? round($gross_salary * 0.0325, 2) : 0.00;
                $esi_employee = ($gross_salary < 21001.00 && $gross_salary > 4100.00) ? round($gross_salary * 0.0075, 2) : 0.00;
                $others       = round(($ctc1 * 0.17) - $pf_employer - $esi_employer - $admin_charges, 2);
            } else {
                $esi_flag     = 'NO';
                $esi_employer = 0.00;
                $esi_employee = 0.00;
                $gross_salary = round($ctc1 - $pf_employer - $admin_charges - $esi_employer, 2);
                $others       = round(($ctc1 * 0.17) - $pf_employer - $esi_employer - $admin_charges, 2);
            }

            // 7. PT (Professional Tax)
            $pt = ($gross_salary >= 20000.00) ? 200.00 : (($gross_salary > 15000.00) ? 150.00 : 0.00);

            // 8. Other Deductions & Advances
            $nps      = (float)($legacy_sal['NPS'] ?? 0.00);
            $advances = (float)($legacy_sal['advances/ other_deductions'] ?? 0.00);
            $tds      = (float)($legacy_sal['tds'] ?? 0.00);

            // Check active advance installment
            $adv_row = $this->db->table('employee_advances')
                ->where('emp_id', $emp_id)
                ->where('status', 'ACTIVE')
                ->get()->getRowArray();
            if ($adv_row) {
                $advances += min((float)$adv_row['installment_amount'], (float)$adv_row['remaining_amount']);
            }

            // Fetch HR Adjustments for this cycle
            $adjustments = $this->db->table('payroll_adjustments')
                ->where('payroll_cycle_id', $cycle_id)
                ->where('emp_id', $emp_id)
                ->where('status', 'APPLIED')
                ->get()->getResultArray();

            $adj_earnings   = 0.00;
            $adj_deductions = 0.00;
            foreach ($adjustments as $adj) {
                if ($adj['adjustment_type'] == 'EARNING') {
                    $adj_earnings += (float)$adj['amount'];
                } else {
                    $adj_deductions += (float)$adj['amount'];
                }
            }

            $total_earnings   = $gross_salary + $adj_earnings;
            $total_deductions = round($pt + $pf_employee + $esi_employee + $advances + $tds + $adj_deductions, 2);
            $net_salary       = max(0, round($total_earnings - $total_deductions, 2));

            $existing = $this->db->table('payroll_employees')
                ->where('payroll_cycle_id', $cycle_id)
                ->where('emp_id', $emp_id)
                ->get()->getRowArray();

            $version = $existing ? ((int)$existing['calculation_version'] + 1) : 1;

            $payroll_emp_data = [
                'payroll_cycle_id'      => $cycle_id,
                'emp_id'                => $emp_id,
                'employee_name'         => $emp_name,
                'working_days'          => 30,
                'present_days'          => $present_days,
                'absent_days'           => $absent_days,
                'paid_leave_days'       => $paid_leave_days,
                'holiday_days'          => $holiday_days,
                'weekly_off_days'       => $weekly_off_days,
                'lop_days'              => $lop_days,
                'salary_basis'          => $salary,
                'ctc1'                  => $ctc1,
                'leave_deduction'       => $leave_deduction,
                'other_earnings'        => $other_earnings,
                'esi_flag'              => $esi_flag,
                'gross_salary'          => $gross_salary,
                'total_earnings'        => $total_earnings,
                'total_deductions'      => $total_deductions,
                'net_salary'            => $net_salary,
                'calculation_version'   => $version,
                'status'                => 'CALCULATED',
                'updated_at'            => date('Y-m-d H:i:s'),
            ];

            if ($existing) {
                $this->db->table('payroll_employees')->where('id', $existing['id'])->update($payroll_emp_data);
            } else {
                $payroll_emp_data['created_at'] = date('Y-m-d H:i:s');
                $this->db->table('payroll_employees')->insert($payroll_emp_data);
            }

            // Sync into employee_salary for this month & year
            $monthName = date('F', strtotime($cycle['period_end']));
            $yearStr   = date('Y', strtotime($cycle['period_end']));

            $existEmpSal = $this->db->query("SELECT id FROM `employee_salary` WHERE `EMP_ID` = ? AND LOWER(`month`) = ? AND `year` = ?", [
                $emp_id, strtolower($monthName), $yearStr
            ])->getRowArray();

            if ($existEmpSal) {
                $sqlEmpSal = "UPDATE `employee_salary` SET
                    `name` = ?,
                    `salary` = ?,
                    `leaves` = ?,
                    `Working_days` = ?,
                    `Leave_salary_deduction` = ?,
                    `other_earnings` = ?,
                    `ctc1` = ?,
                    `gross` = ?,
                    `basic @ 50%` = ?,
                    `hra @ 20%` = ?,
                    `medical @ 5%` = ?,
                    `conveyance @ 8%` = ?,
                    `others @ 17%` = ?,
                    `NPS` = ?,
                    `pf_employer_contribution` = ?,
                    `admin_charges` = ?,
                    `esi_employer_contribution` = ?,
                    `pt` = ?,
                    `pf_employee_contribution` = ?,
                    `esi_employee_contribution` = ?,
                    `advances/ other_deductions` = ?,
                    `tds` = ?,
                    `total_deductions` = ?,
                    `net_pay` = ?
                WHERE `id` = ?";
                $this->db->query($sqlEmpSal, [
                    $emp_name, round($salary), round($lop_days), 30, (string)round($leave_deduction), round($other_earnings),
                    round($ctc1), round($gross_salary), round($basic), round($hra), round($medical), round($conveyance),
                    $others, round($nps), round($pf_employer), round($admin_charges), round($esi_employer), round($pt),
                    round($pf_employee), round($esi_employee), round($advances), round($tds), round($total_deductions),
                    round($net_salary), $existEmpSal['id']
                ]);
            } else {
                $sqlEmpSal = "INSERT INTO `employee_salary` (
                    `EMP_ID`, `name`, `salary`, `leaves`, `Working_days`, `Leave_salary_deduction`, `other_earnings`,
                    `ctc1`, `gross`, `basic @ 50%`, `hra @ 20%`, `medical @ 5%`, `conveyance @ 8%`, `others @ 17%`,
                    `NPS`, `pf_employer_contribution`, `admin_charges`, `esi_employer_contribution`, `pt`,
                    `pf_employee_contribution`, `esi_employee_contribution`, `advances/ other_deductions`, `tds`,
                    `total_deductions`, `net_pay`, `month`, `year`
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $this->db->query($sqlEmpSal, [
                    $emp_id, $emp_name, round($salary), round($lop_days), 30, (string)round($leave_deduction), round($other_earnings),
                    round($ctc1), round($gross_salary), round($basic), round($hra), round($medical), round($conveyance),
                    $others, round($nps), round($pf_employer), round($admin_charges), round($esi_employer), round($pt),
                    round($pf_employee), round($esi_employee), round($advances), round($tds), round($total_deductions),
                    round($net_salary), $monthName, $yearStr
                ]);
            }

            $this->db->table('payroll_calculation_histories')->insert([
                'payroll_cycle_id' => $cycle_id,
                'emp_id'           => $emp_id,
                'version_no'       => $version,
                'gross'            => $total_earnings,
                'deductions'       => $total_deductions,
                'net'              => $net_salary,
                'calculated_by'    => $calculated_by,
                'reason'           => 'Automated workbook payroll recalculation',
                'calculated_at'    => date('Y-m-d H:i:s'),
            ]);

            $total_cycle_gross      += $total_earnings;
            $total_cycle_deductions += $total_deductions;
            $total_cycle_net        += $net_salary;
            $employee_count++;
        }

        $this->db->table('payroll_cycles')->where('id', $cycle_id)->update([
            'status'           => 'CALCULATED',
            'total_employees'  => $employee_count,
            'total_gross'      => $total_cycle_gross,
            'total_deductions' => $total_cycle_deductions,
            'total_net'        => $total_cycle_net,
            'updated_at'       => date('Y-m-d H:i:s'),
        ]);

        $this->db->transComplete();
        return $this->db->transStatus();
    }

    // ==========================================
    // 6. HR ADJUSTMENTS
    // ==========================================
    public function add_payroll_adjustment($data)
    {
        return $this->callProcedure('sp_save_payroll_adjustment', [
            (int)($data['payroll_cycle_id'] ?? 0),
            $data['emp_id'] ?? '',
            (int)($data['component_id'] ?? 0),
            $data['adjustment_type'] ?? 'EARNING',
            (float)($data['amount'] ?? 0),
            $data['reason'] ?? '',
            $data['created_by'] ?? 'HR_ADMIN'
        ], false);
    }

    public function get_payroll_adjustments($cycle_id, $emp_id = null)
    {
        return $this->callProcedure('sp_get_payroll_adjustments', [(int)$cycle_id, $emp_id ?: '']);
    }

    public function get_payroll_export_data(int $cycle_id, string $month, string $year): array
    {
        return $this->callProcedure('sp_get_payroll_export_data', [$cycle_id, $month, $year]);
    }

    public function get_payroll_cycle_employees(int $cycle_id): array
    {
        return $this->callProcedure('sp_get_payroll_cycle_employees', [$cycle_id]);
    }

    public function get_all_payroll_attendance_summaries(): array
    {
        return $this->callProcedure('sp_get_all_payroll_attendance_summaries', []);
    }

    public function get_emp_attendance_summary(string $emp_id, int $month, int $year)
    {
        $res = $this->callProcedure('sp_get_emp_attendance_summary', [$emp_id, $month, $year]);
        return (!empty($res) && isset($res[0])) ? $res[0] : null;
    }

    public function get_payroll_calculation_history(int $cycle_id, string $emp_id): array
    {
        return $this->callProcedure('sp_get_payroll_calculation_history', [$cycle_id, $emp_id]);
    }

    public function get_payroll_cycle_emp_attendances(int $cycle_id, string $emp_id): array
    {
        return $this->callProcedure('sp_get_payroll_cycle_emp_attendances', [$cycle_id, $emp_id]);
    }

    public function get_all_emp_salary_structures(): array
    {
        return $this->callProcedure('sp_get_all_emp_salary_structures', []);
    }

    public function get_emp_structure_overview(string $emp_id)
    {
        $res = $this->callProcedure('sp_get_emp_structure_overview', [$emp_id]);
        return (!empty($res) && isset($res[0])) ? $res[0] : null;
    }

    public function save_employee_salary(
        string $emp_id,
        float $ctc,
        float $gross,
        float $basic,
        float $hra,
        float $medical,
        float $conveyance,
        float $others,
        float $other_earnings,
        float $nps,
        float $pf_employer,
        float $admin_charges,
        float $esi_employer,
        float $pt,
        float $pf_employee,
        float $esi_employee,
        float $advance,
        float $tds,
        float $total_deductions,
        float $net_pay
    ): bool {
        return $this->callProcedure('sp_save_employee_salary', [
            $emp_id, $ctc, $gross, $basic, $hra, $medical, $conveyance, $others, $other_earnings,
            $nps, $pf_employer, $admin_charges, $esi_employer, $pt, $pf_employee, $esi_employee,
            $advance, $tds, $total_deductions, $net_pay
        ], false);
    }

    public function save_employee_payroll_draft($data)
    {
        $cycle_id     = (int)$data['payroll_cycle_id'];
        $emp_id       = $data['emp_id'];
        $present_days = (int)round((float)$data['present_days']);
        $lop_days     = (int)round((float)$data['lop_days']);
        $adj_earning  = (float)($data['manual_earnings_adj'] ?? 0);
        $adj_deduct   = (float)($data['manual_deductions_adj'] ?? 0);
        $reason       = $data['reason'] ?? 'HR Draft Edit';

        $emp_row = $this->db->table('payroll_employees')
            ->where('payroll_cycle_id', $cycle_id)
            ->where('emp_id', $emp_id)
            ->get()->getRowArray();

        if (!$emp_row) return false;

        $working_days   = 30; // Strict 30-day base per company workbook rule
        $base_gross     = (float)$emp_row['salary_basis'];
        $other_earnings = (float)($emp_row['other_earnings'] ?? 0);

        // Recalculate daily rate & leave deduction based on updated LOP days: (Salary * Leaves) / 30
        $leave_deduction = round(($base_gross * $lop_days) / 30, 2);
        $ctc1            = round($base_gross - $leave_deduction + $other_earnings, 2);
        $gross_salary    = max(0, $ctc1);

        if ($adj_earning > 0) {
            $this->add_payroll_adjustment([
                'payroll_cycle_id' => $cycle_id,
                'emp_id'           => $emp_id,
                'adjustment_type'  => 'EARNING',
                'amount'           => $adj_earning,
                'reason'           => $reason,
                'created_by'       => 'HR_ADMIN',
            ]);
        }

        if ($adj_deduct > 0) {
            $this->add_payroll_adjustment([
                'payroll_cycle_id' => $cycle_id,
                'emp_id'           => $emp_id,
                'adjustment_type'  => 'DEDUCTION',
                'amount'           => $adj_deduct,
                'reason'           => $reason,
                'created_by'       => 'HR_ADMIN',
            ]);
        }

        // Aggregate applied adjustments via stored procedure
        $all_adjustments = $this->get_payroll_adjustments($cycle_id, $emp_id);
        $adjustments = array_filter($all_adjustments, function($a) {
            return ($a['status'] ?? '') === 'APPLIED';
        });

        $total_adj_earn = 0;
        $total_adj_ded  = 0;
        foreach ($adjustments as $a) {
            if ($a['adjustment_type'] == 'EARNING') $total_adj_earn += (float)$a['amount'];
            else $total_adj_ded += (float)$a['amount'];
        }

        $total_earnings = $gross_salary + $total_adj_earn;

        $legacy_sal_res = $this->callProcedure('sp_get_latest_salary', [$emp_id]);
        $legacy_sal = (!empty($legacy_sal_res) && isset($legacy_sal_res[0])) ? $legacy_sal_res[0] : [];
        $basic = round($base_gross * 0.50, 2);
        $epf_basic_base = min($basic, 15000.00);
        $epf_employee = (float)($legacy_sal['pf_employee_contribution'] ?? round($epf_basic_base * 0.12, 2));
        $pt = (float)($legacy_sal['pt'] ?? ($gross_salary > 20000 ? 200 : ($gross_salary >= 15001 ? 150 : 0)));

        $total_deductions = $epf_employee + $pt + $total_adj_ded;
        $net_salary       = max(0, $total_earnings - $total_deductions);
        $version          = ((int)$emp_row['calculation_version']) + 1;

        $this->db->table('payroll_employees')->where('id', $emp_row['id'])->update([
            'working_days'        => 30,
            'present_days'        => $present_days,
            'absent_days'         => $lop_days,
            'lop_days'            => $lop_days,
            'leave_deduction'     => $leave_deduction,
            'ctc1'                => $ctc1,
            'gross_salary'        => $gross_salary,
            'total_earnings'      => $total_earnings,
            'total_deductions'    => $total_deductions,
            'net_salary'          => $net_salary,
            'calculation_version' => $version,
            'status'              => 'HR_EDITED',
            'updated_at'          => date('Y-m-d H:i:s'),
        ]);

        // Recalculate cycle summary totals
        $totals = $this->db->table('payroll_employees')
            ->selectSum('gross_salary', 'total_gross')
            ->selectSum('total_deductions', 'total_deductions')
            ->selectSum('net_salary', 'total_net')
            ->selectCount('id', 'total_employees')
            ->where('payroll_cycle_id', $cycle_id)
            ->get()->getRowArray();

        $this->db->table('payroll_cycles')->where('id', $cycle_id)->update([
            'total_employees'  => $totals['total_employees'] ?? 0,
            'total_gross'      => $totals['total_gross'] ?? 0,
            'total_deductions' => $totals['total_deductions'] ?? 0,
            'total_net'        => $totals['total_net'] ?? 0,
            'status'           => 'HR_REVIEW',
            'updated_at'       => date('Y-m-d H:i:s'),
        ]);

        return true;
    }

    // ==========================================
    // 7. PAYROLL WORKFLOW, LOCKING & FREEZING
    // ==========================================
    public function update_cycle_status($cycle_id, $status, $actor_emp_id = 'HR_ADMIN')
    {
        $cycle = $this->get_cycle_by_id($cycle_id);
        if (!$cycle) return false;

        $this->callProcedure('sp_update_cycle_status', [(int)$cycle_id, $status, $actor_emp_id]);

        if (in_array($status, ['APPROVED', 'LOCKED'])) {
            $this->freeze_payroll_results($cycle_id);
        }

        return true;
    }

    public function freeze_payroll_results($cycle_id)
    {
        $cycle = $this->get_cycle_by_id($cycle_id);
        if (!$cycle) return false;

        $employees = $this->db->table('payroll_employees')
            ->where('payroll_cycle_id', $cycle_id)
            ->get()->getResultArray();

        $cycle_month = date('F', strtotime($cycle['period_end']));
        $cycle_year  = date('Y', strtotime($cycle['period_end']));

        foreach ($employees as $emp) {
            $emp_id = $emp['emp_id'];

            $existing_salary = $this->db->table('salaries')
                ->where('payroll_cycle_id', $cycle_id)
                ->where('emp_id', $emp_id)
                ->get()->getRowArray();

            $sal_data = [
                'payroll_cycle_id' => $cycle_id,
                'emp_id'           => $emp_id,
                'gross_amount'     => $emp['gross_salary'],
                'total_earnings'   => $emp['total_earnings'],
                'total_deductions' => $emp['total_deductions'],
                'net_amount'       => $emp['net_salary'],
                'paid_days'        => $emp['present_days'] + $emp['paid_leave_days'] + $emp['holiday_days'] + $emp['weekly_off_days'],
                'lop_days'         => $emp['lop_days'],
                'generated_on'     => date('Y-m-d H:i:s'),
                'status'           => 'GENERATED',
                'updated_at'       => date('Y-m-d H:i:s'),
            ];

            if ($existing_salary) {
                $salary_id = $existing_salary['id'];
                $this->db->table('salaries')->where('id', $salary_id)->update($sal_data);
                $this->db->table('salary_details')->where('salary_id', $salary_id)->delete();
            } else {
                $sal_data['created_at'] = date('Y-m-d H:i:s');
                $this->db->table('salaries')->insert($sal_data);
                $salary_id = $this->db->insertID();
            }

            // Create Salary Details snapshot rows from employee's configured salary structure or defaults
            $emp_structures = $this->get_emp_salary_structure($emp_id);
            $components_snapshot = [];

            if (!empty($emp_structures)) {
                foreach ($emp_structures as $es) {
                    $code = $es['component_code'];
                    $name = $es['component_name'];
                    $type = $es['component_type'];
                    $calc = $es['calculation_type'];
                    $val  = (float)$es['value'];
                    $amt  = (float)$es['amount'];

                    // Pro-rate earning component if LOP days exist in this cycle
                    if ($type == 'EARNING' && $emp['salary_basis'] > 0) {
                        $ratio = $emp['gross_salary'] / $emp['salary_basis'];
                        $amt = round($amt * $ratio, 2);
                    }

                    $components_snapshot[] = [
                        'code' => $code,
                        'name' => $name,
                        'type' => $type,
                        'calc' => $calc,
                        'val'  => $val,
                        'base' => $emp['gross_salary'],
                        'amt'  => $amt,
                    ];
                }
            } else {
                // Fetch computed components from employee_salary for this month and year
                $computed_sal = $this->db->table('employee_salary')
                    ->where('EMP_ID', $emp_id)
                    ->where('LOWER(month)', strtolower($cycle_month))
                    ->where('year', (string)$cycle_year)
                    ->get()->getRowArray();

                if (!$computed_sal) {
                    $computed_sal = $this->db->table('employee_salary')
                        ->where('EMP_ID', $emp_id)
                        ->orderBy('id', 'DESC')
                        ->get()->getRowArray();
                }

                $basic      = (float)($computed_sal['basic @ 50%'] ?? round($emp['gross_salary'] * 0.50, 2));
                $hra        = (float)($computed_sal['hra @ 20%'] ?? round($emp['gross_salary'] * 0.20, 2));
                $medical    = (float)($computed_sal['medical @ 5%'] ?? round($emp['gross_salary'] * 0.05, 2));
                $conveyance = (float)($computed_sal['conveyance @ 8%'] ?? round($emp['gross_salary'] * 0.08, 2));
                $other_earn = (float)($computed_sal['others @ 17%'] ?? max(0, $emp['gross_salary'] - ($basic + $hra + $medical + $conveyance)));

                $components_snapshot = [
                    ['code' => 'BASIC', 'name' => 'Basic Salary', 'type' => 'EARNING', 'calc' => 'PERCENTAGE', 'val' => 50, 'base' => $emp['gross_salary'], 'amt' => $basic],
                    ['code' => 'HRA', 'name' => 'House Rent Allowance', 'type' => 'EARNING', 'calc' => 'PERCENTAGE', 'val' => 20, 'base' => $emp['gross_salary'], 'amt' => $hra],
                    ['code' => 'MEDICAL', 'name' => 'Medical Allowance', 'type' => 'EARNING', 'calc' => 'PERCENTAGE', 'val' => 5, 'base' => $emp['gross_salary'], 'amt' => $medical],
                    ['code' => 'CONVEYANCE', 'name' => 'Conveyance Allowance', 'type' => 'EARNING', 'calc' => 'PERCENTAGE', 'val' => 8, 'base' => $emp['gross_salary'], 'amt' => $conveyance],
                    ['code' => 'OTHER_EARNINGS', 'name' => 'Other Allowance', 'type' => 'EARNING', 'calc' => 'FIXED', 'val' => 0, 'base' => $emp['gross_salary'], 'amt' => $other_earn],
                ];

                $pf_deduct  = (float)($computed_sal['pf_employee_contribution'] ?? 0.00);
                $pt_deduct  = (float)($computed_sal['pt'] ?? 0.00);
                $esi_deduct = (float)($computed_sal['esi_employee_contribution'] ?? 0.00);
                $tds_deduct = (float)($computed_sal['tds'] ?? 0.00);
                $adv_deduct = (float)($computed_sal['advances/ other_deductions'] ?? 0.00);

                if ($pf_deduct > 0) {
                    $components_snapshot[] = ['code' => 'PF_EMPLOYEE', 'name' => 'EPF', 'type' => 'DEDUCTION', 'calc' => 'FIXED', 'val' => 0, 'base' => $emp['gross_salary'], 'amt' => $pf_deduct];
                }
                if ($pt_deduct > 0) {
                    $components_snapshot[] = ['code' => 'PT', 'name' => 'Professional Tax', 'type' => 'DEDUCTION', 'calc' => 'FIXED', 'val' => 0, 'base' => $emp['gross_salary'], 'amt' => $pt_deduct];
                }
                if ($esi_deduct > 0) {
                    $components_snapshot[] = ['code' => 'ESI_EMPLOYEE', 'name' => 'ESI', 'type' => 'DEDUCTION', 'calc' => 'FIXED', 'val' => 0, 'base' => $emp['gross_salary'], 'amt' => $esi_deduct];
                }
                if ($tds_deduct > 0) {
                    $components_snapshot[] = ['code' => 'TDS', 'name' => 'Income Tax', 'type' => 'DEDUCTION', 'calc' => 'FIXED', 'val' => 0, 'base' => $emp['gross_salary'], 'amt' => $tds_deduct];
                }
                if ($adv_deduct > 0) {
                    $components_snapshot[] = ['code' => 'OTHER_DEDUCTION', 'name' => 'Other Deductions', 'type' => 'DEDUCTION', 'calc' => 'FIXED', 'val' => 0, 'base' => $emp['gross_salary'], 'amt' => $adv_deduct];
                }
            }

            // Write into salary_details (New Schema)
            $basic_component_amount = 0;
            foreach ($components_snapshot as $cs) {
                if ($cs['code'] == 'BASIC') {
                    $basic_component_amount = $cs['amt'];
                }
                $this->db->table('salary_details')->insert([
                    'salary_id'               => $salary_id,
                    'component_code_snapshot' => $cs['code'],
                    'component_name_snapshot' => $cs['name'],
                    'component_type'          => $cs['type'],
                    'calculation_type'        => $cs['calc'],
                    'calculation_value'       => $cs['val'],
                    'base_amount'             => $cs['base'],
                    'amount'                  => $cs['amt'],
                    'created_at'              => date('Y-m-d H:i:s'),
                ]);
            }

            // Write / update Payslips row (New Schema)
            $existing_payslip = $this->db->table('payslips')
                ->where('salary_id', $salary_id)
                ->get()->getRowArray();
            if (!$existing_payslip) {
                $payslip_no = 'PS-' . $cycle_year . date('m', strtotime($cycle['period_end'])) . '-' . $emp_id;
                $this->db->table('payslips')->insert([
                    'salary_id'      => $salary_id,
                    'payslip_number' => $payslip_no,
                    'emp_id'         => $emp_id,
                    'month'          => $cycle_month,
                    'year'           => $cycle_year,
                    'issued_at'      => date('Y-m-d H:i:s'),
                    'created_at'     => date('Y-m-d H:i:s'),
                ]);
            }

            // ==========================================
            // DUAL-WRITE SYNC: OLD VERSION TABLES
            // Sync into salary_tbl, allowance_list, deduction_list
            // ==========================================
            $user = $this->db->table('user_details')->where('emp_id', $emp_id)->get()->getRowArray();
            $emp_name = $user['emp_name'] ?? $emp['employee_name'];
            $dept_id  = $user['department'] ?? null;

            $paid_days = (int)round((float)($emp['present_days'] + $emp['paid_leave_days'] + $emp['holiday_days'] + $emp['weekly_off_days']));
            $lop_days  = (int)round((float)$emp['lop_days']);
            $work_days = (int)round((float)($emp['working_days'] ?: 30));

            $existing_legacy_sal = $this->db->table('salary_tbl')
                ->where('staff_id', $emp_id)
                ->where('month', $cycle_month)
                ->where('year', $cycle_year)
                ->get()->getRowArray();

            $legacy_sal_data = [
                'staff_name'         => $emp_name,
                'staff_id'           => $emp_id,
                'basic_salary'       => $basic_component_amount ?: round($emp['gross_salary'] * 0.50),
                'total_working_days' => $work_days,
                'no_days_present'    => $paid_days,
                'no_days_absent'     => $lop_days,
                'total_allowances'   => round($emp['total_earnings']),
                'total_deductions'   => round($emp['total_deductions']),
                'advance_amount'     => 0,
                'ctc'                => round($emp['salary_basis']),
                'net_income'         => round($emp['net_salary']),
                'monthly_ctc'        => round($emp['salary_basis']),
                'month'              => $cycle_month,
                'year'               => $cycle_year,
                'department_id'      => $dept_id,
                'updated_on'         => date('Y-m-d H:i:s'),
            ];

            if ($existing_legacy_sal) {
                $this->db->table('salary_tbl')->where('id', $existing_legacy_sal['id'])->update($legacy_sal_data);
            } else {
                $legacy_sal_data['added_by'] = 1;
                $legacy_sal_data['added_on'] = date('Y-m-d H:i:s');
                $this->db->table('salary_tbl')->insert($legacy_sal_data);
            }

            // Sync allowance_list & deduction_list
            $this->db->table('allowance_list')
                ->where('staff_id', $emp_id)
                ->where('month', $cycle_month)
                ->where('year', $cycle_year)
                ->delete();

            $this->db->table('deduction_list')
                ->where('staff_id', $emp_id)
                ->where('month', $cycle_month)
                ->where('year', $cycle_year)
                ->delete();

            foreach ($components_snapshot as $cs) {
                if ($cs['type'] == 'EARNING') {
                    $this->db->table('allowance_list')->insert([
                        'staff_id'       => $emp_id,
                        'allowance_name' => $cs['name'],
                        'amount'         => round($cs['amt']),
                        'month'          => $cycle_month,
                        'year'           => $cycle_year,
                    ]);
                } else {
                    $this->db->table('deduction_list')->insert([
                        'staff_id'       => $emp_id,
                        'deduction_name' => $cs['name'],
                        'd_amount'       => round($cs['amt']),
                        'month'          => $cycle_month,
                        'year'           => $cycle_year,
                    ]);
                }
            }
        }
    }

    // ==========================================
    // 8. PAYSLIP FETCH & COMPATIBILITY
    // ==========================================
    public function get_employee_frozen_payslip($emp_id, $month, $year)
    {
        $res = $this->callProcedure('sp_get_frozen_payslip', [$emp_id, $month, (int)$year]);
        $salary = (!empty($res) && isset($res[0])) ? $res[0] : null;

        if (!$salary) return null;

        $details = $this->callProcedure('sp_get_frozen_payslip_details', [(int)$salary['id']]);

        $earnings   = [];
        $deductions = [];
        $basic_salary = 0;

        foreach ($details as $d) {
            if ($d['component_type'] == 'EARNING') {
                $earnings[] = [
                    'allowance_name' => $d['component_name_snapshot'],
                    'amount'         => $d['amount'],
                    'a_amount'       => $d['amount'],
                ];
                if ($d['component_code_snapshot'] == 'BASIC') {
                    $basic_salary = $d['amount'];
                }
            } else {
                $deductions[] = [
                    'deduction_name' => $d['component_name_snapshot'],
                    'd_amount'       => $d['amount'],
                    'amount'         => $d['amount'],
                ];
            }
        }

        $content_row = [
            'month'               => $month,
            'year'                => $year,
            'user_name'           => $salary['emp_name'] ?? '',
            'emp_name'            => $salary['emp_name'] ?? '',
            'emp_id'              => $salary['emp_id'],
            'department_name'     => $salary['department_name'] ?? '',
            'designation_name'    => $salary['designation_name'] ?? '',
            'location'            => $salary['location'] ?? 'Hyderabad',
            'joining_date'        => $salary['joining_date'] ?? '',
            'pan'                 => $salary['pan'] ?? '',
            'pan_no'              => $salary['pan'] ?? '',
            'pf_account_no'       => $salary['pf_account_no'] ?? '',
            'esic_no'             => $salary['esic_no'] ?? '',
            'uan'                 => $salary['uan'] ?? '',
            'bank_name'           => $salary['bank_name'] ?? '',
            'bank_account_no'     => $salary['bank_account_no'] ?? '',
            'ifsc'                => $salary['ifsc'] ?? '',
            'ifsc_code'           => $salary['ifsc'] ?? '',
            'basic_salary'        => $basic_salary,
            'total_working_days'  => (int)round((float)($salary['paid_days'] + $salary['lop_days'])),
            'no_days_present'     => (int)round((float)$salary['paid_days']),
            'no_days_absent'      => (int)round((float)$salary['lop_days']),
            'working_days'        => (int)round((float)($salary['paid_days'] + $salary['lop_days'])),
            'present_days'        => (int)round((float)$salary['paid_days']),
            'lop_days'            => (int)round((float)$salary['lop_days']),
            'total_allowances'    => $salary['total_earnings'],
            'total_deductions'    => $salary['total_deductions'],
            'monthly_ctc'         => $salary['gross_amount'],
            'ctc'                 => $salary['gross_amount'],
            'net_income'          => $salary['net_amount'],
            'net_salary'          => $salary['net_amount'],
            'payroll_code'        => $salary['payroll_code'] ?? '',
            'payslip_number'      => $salary['payslip_number'] ?? '',
            'period_start'        => $salary['period_start'] ?? '',
            'period_end'          => $salary['period_end'] ?? '',
        ];

        return [
            'header'     => $salary,
            'content'    => [$content_row],
            'earnings'   => $earnings,
            'deductions' => $deductions,
        ];
    }

    // ==========================================
    // NORMALIZED PAYROLL ENGINE (7 TABLES & 9 PROCEDURES)
    // ==========================================

    /**
     * Helper to execute a stored procedure with OUT parameters
     */
    public function executeProcWithOutParams(string $procCallSql, array $outVars): array
    {
        try {
            $mysqli = $this->db->connID instanceof \mysqli ? $this->db->connID : new \mysqli("localhost", "root", "vamsi123", "hrmsdevtest");
            $mysqli->query($procCallSql);
            while (@mysqli_more_results($mysqli) && @mysqli_next_result($mysqli)) {}

            $selectParts = [];
            foreach ($outVars as $varName => $alias) {
                $selectParts[] = "{$varName} AS {$alias}";
            }
            $selectSql = "SELECT " . implode(', ', $selectParts);
            $res = $mysqli->query($selectSql);
            $row = ($res && $res->num_rows > 0) ? $res->fetch_assoc() : [];
            if ($res) $res->free();
            return $row;
        } catch (\Throwable $e) {
            log_message('error', 'executeProcWithOutParams Error: ' . $e->getMessage());
            return ['status' => 'ERROR', 'message' => $e->getMessage()];
        }
    }

    /**
     * Helper to execute a stored procedure that returns multiple result sets
     */
    public function executeProcMulti(string $procName, array $params = []): array
    {
        try {
            $mysqli = $this->db->connID instanceof \mysqli ? $this->db->connID : new \mysqli("localhost", "root", "vamsi123", "hrmsdevtest");
            $paramStrs = array_map(function($p) use ($mysqli) {
                if ($p === null) return 'NULL';
                if (is_numeric($p)) return $p;
                return "'" . $mysqli->real_escape_string($p) . "'";
            }, $params);
            $sql = "CALL {$procName}(" . implode(', ', $paramStrs) . ")";

            $resultSets = [];
            if ($mysqli->multi_query($sql)) {
                do {
                    if ($result = $mysqli->store_result()) {
                        $resultSets[] = $result->fetch_all(MYSQLI_ASSOC);
                        $result->free();
                    }
                } while (@mysqli_more_results($mysqli) && @mysqli_next_result($mysqli));
            }
            return $resultSets;
        } catch (\Throwable $e) {
            log_message('error', "executeProcMulti [{$procName}] Error: " . $e->getMessage());
            return [];
        }
    }

    // 1. Create payroll run via procedure
    public function sp_create_payroll_run(int $month, int $year, string $dayBasis = 'FIXED_30', string $adminId = 'ADMIN'): array
    {
        $escapedBasis = addslashes($dayBasis);
        $escapedAdmin = addslashes($adminId);
        $sql = "CALL sp_create_payroll_run({$month}, {$year}, '{$escapedBasis}', '{$escapedAdmin}', @p_run_id, @p_status, @p_message)";
        return $this->executeProcWithOutParams($sql, [
            '@p_run_id'  => 'run_id',
            '@p_status'  => 'status',
            '@p_message' => 'message'
        ]);
    }

    // 2. Calculate single employee payroll
    public function sp_calculate_employee_payroll(int $runId, string $empId, string $adminId = 'ADMIN'): array
    {
        $escapedEmp   = addslashes($empId);
        $escapedAdmin = addslashes($adminId);
        $sql = "CALL sp_calculate_employee_payroll({$runId}, '{$escapedEmp}', '{$escapedAdmin}', @p_status, @p_message)";
        return $this->executeProcWithOutParams($sql, [
            '@p_status'  => 'status',
            '@p_message' => 'message'
        ]);
    }

    // 3. Calculate all monthly payroll
    public function sp_calculate_monthly_payroll(int $runId, string $adminId = 'ADMIN'): array
    {
        $escapedAdmin = addslashes($adminId);
        $sql = "CALL sp_calculate_monthly_payroll({$runId}, '{$escapedAdmin}', @p_processed, @p_errors, @p_status, @p_message)";
        return $this->executeProcWithOutParams($sql, [
            '@p_processed' => 'processed',
            '@p_errors'    => 'errors',
            '@p_status'    => 'status',
            '@p_message'   => 'message'
        ]);
    }

    // 4. Validate payroll run
    public function sp_validate_payroll_run(int $runId): array
    {
        $sets = $this->executeProcMulti('sp_validate_payroll_run', [$runId]);
        return [
            'metrics'    => (!empty($sets[0]) && isset($sets[0][0])) ? $sets[0][0] : null,
            'exceptions' => $sets[1] ?? []
        ];
    }

    // 5. Approve payroll run
    public function sp_approve_payroll_run(int $runId, string $adminId = 'ADMIN'): array
    {
        $escapedAdmin = addslashes($adminId);
        $sql = "CALL sp_approve_payroll_run({$runId}, '{$escapedAdmin}', @p_status, @p_message)";
        return $this->executeProcWithOutParams($sql, [
            '@p_status'  => 'status',
            '@p_message' => 'message'
        ]);
    }

    // 6. Finalize payroll run
    public function sp_finalize_payroll_run(int $runId, string $adminId = 'ADMIN'): array
    {
        $escapedAdmin = addslashes($adminId);
        $sql = "CALL sp_finalize_payroll_run({$runId}, '{$escapedAdmin}', @p_status, @p_message)";
        return $this->executeProcWithOutParams($sql, [
            '@p_status'  => 'status',
            '@p_message' => 'message'
        ]);
    }

    // 7. Generate payslips
    public function sp_generate_payslips(int $runId, string $adminId = 'ADMIN'): array
    {
        $escapedAdmin = addslashes($adminId);
        $sql = "CALL sp_generate_payslips({$runId}, '{$escapedAdmin}', @p_generated, @p_status, @p_message)";
        return $this->executeProcWithOutParams($sql, [
            '@p_generated' => 'generated',
            '@p_status'    => 'status',
            '@p_message'   => 'message'
        ]);
    }

    // 8. Get employee payslip
    public function sp_get_employee_payslip(int $runId, string $empId): ?array
    {
        $sets = $this->executeProcMulti('sp_get_employee_payslip', [$runId, $empId]);
        if (empty($sets) || empty($sets[0])) {
            return null;
        }
        return [
            'header'                 => $sets[0][0],
            'earnings'               => $sets[1] ?? [],
            'deductions'             => $sets[2] ?? [],
            'employer_contributions' => $sets[3] ?? [],
        ];
    }

    // 9. Reopen payroll run
    public function sp_reopen_payroll_run(int $runId, string $adminId = 'ADMIN', string $reason = 'Correction'): array
    {
        $escapedAdmin  = addslashes($adminId);
        $escapedReason = addslashes($reason);
        $sql = "CALL sp_reopen_payroll_run({$runId}, '{$escapedAdmin}', '{$escapedReason}', @p_status, @p_message)";
        return $this->executeProcWithOutParams($sql, [
            '@p_status'  => 'status',
            '@p_message' => 'message'
        ]);
    }

    // Runs list
    public function get_all_runs(): array
    {
        $sql = "SELECT 
                    pr.*,
                    COUNT(pe.payroll_employee_id) AS total_employees,
                    IFNULL(SUM(pe.gross_earnings), 0) AS total_gross,
                    IFNULL(SUM(pe.lop_deduction), 0) AS total_lop_deductions,
                    IFNULL(SUM(pe.other_deductions), 0) AS total_deductions,
                    IFNULL(SUM(pe.employer_contributions), 0) AS total_employer_contrib,
                    IFNULL(SUM(pe.net_salary), 0) AS total_net_payout
                FROM payroll_run pr
                LEFT JOIN payroll_employee pe ON pr.payroll_run_id = pe.payroll_run_id
                GROUP BY pr.payroll_run_id
                ORDER BY pr.payroll_year DESC, pr.payroll_month DESC";
        return $this->db->query($sql)->getResultArray();
    }

    public function get_run_by_id(int $runId): ?array
    {
        $sql = "SELECT * FROM payroll_run WHERE payroll_run_id = ?";
        $res = $this->db->query($sql, [$runId])->getResultArray();
        return !empty($res) ? $res[0] : null;
    }

    public function get_run_employees(int $runId, string $search = '', string $status = ''): array
    {
        $builder = $this->db->table('payroll_employee pe')
            ->select('pe.*, u.emp_name, u.email, u.mobile, u.bank_account_no, u.bank_name, u.ifsc, d.department_name, des.designation_name')
            ->join('user_details u', 'pe.emp_id = u.emp_id', 'left')
            ->join('department_master d', 'u.department = d.department_id', 'left')
            ->join('designation_master des', 'u.designation = des.designation_id', 'left')
            ->where('pe.payroll_run_id', $runId);

        if (!empty($search)) {
            $builder->groupStart()
                ->like('pe.emp_id', $search)
                ->orLike('u.emp_name', $search)
                ->groupEnd();
        }

        if (!empty($status)) {
            $builder->where('pe.calculation_status', $status);
        }

        $builder->orderBy('pe.emp_id', 'ASC');
        return $builder->get()->getResultArray();
    }

    /**
     * Fetch run employees with mapped statutory components and banking details
     */
    public function get_run_employees_with_components(int $runId, string $search = '', string $status = ''): array
    {
        $builder = $this->db->table('payroll_employee pe')
            ->select('pe.*, u.emp_name, u.email, u.mobile, u.bank_account_no, u.bank_name, u.ifsc, d.department_name, des.designation_name')
            ->join('user_details u', 'pe.emp_id = u.emp_id', 'left')
            ->join('department_master d', 'u.department = d.department_id', 'left')
            ->join('designation_master des', 'u.designation = des.designation_id', 'left')
            ->where('pe.payroll_run_id', $runId);

        if (!empty($search)) {
            $builder->groupStart()
                ->like('pe.emp_id', $search)
                ->orLike('u.emp_name', $search)
                ->orLike('u.bank_account_no', $search)
                ->orLike('u.ifsc', $search)
                ->groupEnd();
        }

        if (!empty($status)) {
            $builder->where('pe.calculation_status', $status);
        }

        $builder->orderBy('pe.emp_id', 'ASC');
        $employees = $builder->get()->getResultArray();

        if (empty($employees)) {
            return [];
        }

        // Fetch all component snapshots for this run in a single efficient query
        $compRows = $this->db->table('payroll_employee_component pec')
            ->select('pec.*')
            ->join('payroll_employee pe', 'pec.payroll_employee_id = pe.payroll_employee_id')
            ->where('pe.payroll_run_id', $runId)
            ->get()->getResultArray();

        $compMap = [];
        foreach ($compRows as $c) {
            $compMap[$c['payroll_employee_id']][$c['component_code']] = $c;
        }

        // Fetch advances ledger if active
        $advRows = $this->db->table('employee_advances')
            ->select('emp_id, SUM(advance_amount) as adv_amt, SUM(balance_amount) as bal_amt')
            ->whereIn('UPPER(status)', ['ACTIVE', 'APPROVED'])
            ->groupBy('emp_id')
            ->get()->getResultArray();
        $advMap = [];
        foreach ($advRows as $a) {
            $advMap[$a['emp_id']] = $a;
        }

        $result = [];
        foreach ($employees as $e) {
            $peId = (int)$e['payroll_employee_id'];
            $empComps = $compMap[$peId] ?? [];

            $basic     = (float)($empComps['BASIC']['payable_amount'] ?? 0);
            $hra       = (float)($empComps['HRA']['payable_amount'] ?? 0);
            $med       = (float)($empComps['MEDICAL']['payable_amount'] ?? 0);
            $conv      = (float)($empComps['CONVEYANCE']['payable_amount'] ?? 0);
            $others    = (float)($empComps['SPECIAL_ALLOWANCE']['payable_amount'] ?? 0);
            $nps       = (float)($empComps['NPS']['payable_amount'] ?? 0);
            $pfEmplr   = (float)($empComps['PF_EMPLOYER']['payable_amount'] ?? 0);
            $adminChg  = isset($empComps['ADMIN_CHARGES']) ? (float)$empComps['ADMIN_CHARGES']['payable_amount'] : 75.00;
            $esiEmplr  = (float)($empComps['ESI_EMPLOYER']['payable_amount'] ?? 0);
            $pt        = (float)($empComps['PROF_TAX']['payable_amount'] ?? 200.00);
            $pfEmp     = (float)($empComps['PF_EMPLOYEE']['payable_amount'] ?? 0);
            $esiEmp    = (float)($empComps['ESI_EMPLOYEE']['payable_amount'] ?? 0);
            $advDeduct = (float)($empComps['ADVANCES']['payable_amount'] ?? 0);
            $tds       = (float)($empComps['TDS']['payable_amount'] ?? 0);

            // Compute other earnings from non-standard components
            $dynamicEarnings = 0.00;
            foreach ($empComps as $code => $c) {
                if ($c['component_type'] === 'EARNING' && !in_array($code, ['BASIC', 'HRA', 'MEDICAL', 'CONVEYANCE', 'SPECIAL_ALLOWANCE'])) {
                    $dynamicEarnings += (float)$c['payable_amount'];
                }
            }

            $e['basic']                     = $basic;
            $e['hra']                       = $hra;
            $e['medical']                   = $med;
            $e['conveyance']                = $conv;
            $e['others']                    = $others;
            $e['employer_nps']              = $nps;
            $e['pf_employer_contribution']  = $pfEmplr;
            $e['admin_charges']             = $adminChg;
            $e['esi_employer_contribution'] = $esiEmplr;
            $e['pt']                        = $pt;
            $e['pf_employee_contribution']  = $pfEmp;
            $e['esi_employee_contribution'] = $esiEmp;
            $e['advances_deduction']        = $advDeduct;
            $e['tds']                       = $tds;
            $e['other_earnings']            = $dynamicEarnings;
            $e['ctc1']                      = (float)$e['monthly_ctc'];
            $e['salary']                    = (float)$e['monthly_ctc'];
            $e['leaves']                    = (float)$e['lop_days'];
            $e['leave_deduction']           = (float)$e['lop_deduction'];
            $e['total_deductions']          = (float)$e['other_deductions'];
            $e['net_pay']                   = (float)$e['net_salary'];
            $e['advance_amount']            = (float)($advMap[$e['emp_id']]['adv_amt'] ?? 0);
            $e['bal_advance']               = (float)($advMap[$e['emp_id']]['bal_amt'] ?? 0);
            $e['components_list']           = array_values($empComps);

            $result[] = $e;
        }

        return $result;
    }

    /**
     * Synchronize legacy payroll_cycles & payroll_employees tables
     */
    public function sync_legacy_payroll_cycle(int $runId): void
    {
        try {
            $run = $this->get_run_by_id($runId);
            if (!$run) return;

            $month = (int)$run['payroll_month'];
            $year  = (int)$run['payroll_year'];
            $pStart = $run['period_start'];
            $pEnd   = $run['period_end'];
            $monthNameShort = strtoupper(date('M', mktime(0, 0, 0, $month, 10, $year)));
            $payrollCode = "{$monthNameShort}-{$year} (" . date('d M', strtotime($pStart)) . " - " . date('d M', strtotime($pEnd)) . ")";
            $payDate = date('Y-m-t', strtotime($pEnd));

            $agg = $this->db->table('payroll_employee')
                ->select('COUNT(*) as total_emp, SUM(gross_earnings) as total_gross, SUM(other_deductions) as total_ded, SUM(net_salary) as total_net')
                ->where('payroll_run_id', $runId)
                ->get()->getRowArray();

            $totalEmp   = (int)($agg['total_emp'] ?? 0);
            $totalGross = (float)($agg['total_gross'] ?? 0);
            $totalDed   = (float)($agg['total_ded'] ?? 0);
            $totalNet   = (float)($agg['total_net'] ?? 0);
            $legacyStatus = ($run['payroll_status'] === 'FINALIZED') ? 'LOCKED' : (($run['payroll_status'] === 'APPROVED') ? 'APPROVED' : 'DRAFT');

            $existCycle = $this->db->table('payroll_cycles')
                ->where('period_start', $pStart)
                ->where('period_end', $pEnd)
                ->get()->getRowArray();

            $cycleData = [
                'payroll_code'     => $payrollCode,
                'period_start'     => $pStart,
                'period_end'       => $pEnd,
                'pay_date'         => $payDate,
                'status'           => $legacyStatus,
                'total_employees'  => $totalEmp,
                'total_gross'      => $totalGross,
                'total_deductions' => $totalDed,
                'total_net'        => $totalNet,
                'updated_at'       => date('Y-m-d H:i:s'),
            ];

            if ($existCycle) {
                $cycleId = (int)$existCycle['id'];
                $this->db->table('payroll_cycles')->where('id', $cycleId)->update($cycleData);
            } else {
                $cycleData['created_by'] = $run['created_by'] ?: 'ADMIN';
                $cycleData['created_at'] = date('Y-m-d H:i:s');
                $this->db->table('payroll_cycles')->insert($cycleData);
                $cycleId = (int)$this->db->insertID();
            }

            $employees = $this->get_run_employees_with_components($runId);
            foreach ($employees as $e) {
                $existPe = $this->db->table('payroll_employees')
                    ->where('payroll_cycle_id', $cycleId)
                    ->where('emp_id', $e['emp_id'])
                    ->get()->getRowArray();

                $peData = [
                    'payroll_cycle_id'    => $cycleId,
                    'emp_id'              => $e['emp_id'],
                    'employee_name'       => $e['emp_name'],
                    'working_days'        => 30,
                    'present_days'        => (float)($e['paid_days'] ?? 30),
                    'absent_days'         => (float)($e['lop_days'] ?? 0),
                    'paid_leave_days'     => 0,
                    'holiday_days'        => 0,
                    'weekly_off_days'     => 0,
                    'lop_days'            => (float)($e['lop_days'] ?? 0),
                    'salary_basis'        => (float)$e['monthly_ctc'],
                    'ctc1'                => (float)$e['monthly_ctc'],
                    'leave_deduction'     => (float)$e['lop_deduction'],
                    'other_earnings'      => (float)$e['other_earnings'],
                    'esi_flag'            => ((float)$e['gross_earnings'] <= 21000) ? 'YES' : 'NO',
                    'gross_salary'        => (float)$e['gross_earnings'],
                    'total_earnings'      => (float)$e['gross_earnings'],
                    'total_deductions'    => (float)$e['other_deductions'],
                    'net_salary'          => (float)$e['net_salary'],
                    'calculation_version' => 1,
                    'status'              => $e['calculation_status'],
                    'updated_at'          => date('Y-m-d H:i:s'),
                ];

                if ($existPe) {
                    $this->db->table('payroll_employees')->where('id', $existPe['id'])->update($peData);
                } else {
                    $peData['created_at'] = date('Y-m-d H:i:s');
                    $this->db->table('payroll_employees')->insert($peData);
                }
            }
        } catch (\Throwable $th) {
            log_message('error', 'sync_legacy_payroll_cycle error: ' . $th->getMessage());
        }
    }

    public function get_employee_run_components(int $payrollEmployeeId): array
    {
        return $this->db->table('payroll_employee_component')
            ->where('payroll_employee_id', $payrollEmployeeId)
            ->orderBy('component_type', 'ASC')
            ->orderBy('component_id', 'ASC')
            ->get()->getResultArray();
    }

    // Master components
    public function get_salary_component_master(): array
    {
        return $this->db->table('salary_component_master')
            ->orderBy('component_type', 'ASC')
            ->orderBy('component_id', 'ASC')
            ->get()->getResultArray();
    }

    public function save_salary_component_master(array $data): int
    {
        $builder = $this->db->table('salary_component_master');
        if (!empty($data['component_id'])) {
            $id = (int)$data['component_id'];
            unset($data['component_id']);
            $builder->where('component_id', $id)->update($data);
            return $id;
        } else {
            $builder->insert($data);
            return (int)$this->db->insertID();
        }
    }

    public function toggle_salary_component_master(int $id): bool
    {
        $sql = "UPDATE salary_component_master SET is_active = IF(is_active = 1, 0, 1) WHERE component_id = ?";
        $res = (bool)$this->db->query($sql, [$id]);
        
        // Also sync active status to employee structures
        $comp = $this->db->table('salary_component_master')->where('component_id', $id)->get()->getRowArray();
        if ($comp) {
            $this->db->table('employee_salary_component')
                ->where('component_id', $id)
                ->update(['is_active' => (int)$comp['is_active']]);
        }
        $this->recalculate_open_runs();
        return $res;
    }

    public function delete_salary_component_master(int $id): bool
    {
        // Remove from employee structures
        $this->db->table('employee_salary_component')->where('component_id', $id)->delete();
        $res = (bool)$this->db->table('salary_component_master')->where('component_id', $id)->delete();
        $this->recalculate_open_runs();
        return $res;
    }

    /**
     * Add a newly created component to all active employees' salary structures in active state
     */
    public function add_component_to_all_active_employees(int $componentId, float $defaultAmt = 0.0): int
    {
        // 1. Stored procedure call
        try {
            $this->db->query("CALL sp_add_component_to_all_employees(?)", [$componentId]);
        } catch (\Throwable $e) {
            log_message('error', 'sp_add_component_to_all_employees error: ' . $e->getMessage());
        }

        // 2. PHP fallback & guarantee loop across all active employees
        $comp = $this->db->table('salary_component_master')
            ->where('component_id', $componentId)
            ->get()->getRowArray();
        if (!$comp) return 0;

        $structures = $this->get_all_employee_structures();
        $count = 0;

        foreach ($structures as $s) {
            $structId = (int)($s['salary_structure_id'] ?? 0);
            $monthlyCtc = (float)($s['monthly_ctc'] ?? 0);
            if ($structId <= 0) continue;

            $amt = $defaultAmt;
            $pct = isset($comp['percentage_value']) && $comp['percentage_value'] !== null ? (float)$comp['percentage_value'] : null;

            if ($comp['calculation_type'] === 'PERCENTAGE' && $pct !== null && $pct > 0) {
                if (($comp['percentage_base'] ?? '') === 'BASIC') {
                    $basicRow = $this->db->table('employee_salary_component esc')
                        ->join('salary_component_master m', 'esc.component_id = m.component_id')
                        ->where('esc.salary_structure_id', $structId)
                        ->where('m.component_code', 'BASIC')
                        ->get()->getRowArray();
                    $basicAmt = (float)($basicRow['monthly_amount'] ?? 0);
                    $amt = round(($basicAmt * $pct) / 100, 2);
                } else {
                    $amt = round(($monthlyCtc * $pct) / 100, 2);
                }
            }

            $existing = $this->db->table('employee_salary_component')
                ->where('salary_structure_id', $structId)
                ->where('component_id', $componentId)
                ->get()->getRowArray();

            if ($existing) {
                $this->db->table('employee_salary_component')
                    ->where('salary_component_id', $existing['salary_component_id'])
                    ->update([
                        'is_active'        => 1,
                        'percentage_value' => $pct,
                        'monthly_amount'   => ($existing['monthly_amount'] > 0) ? $existing['monthly_amount'] : $amt,
                    ]);
            } else {
                $this->db->table('employee_salary_component')->insert([
                    'salary_structure_id' => $structId,
                    'component_id'        => $componentId,
                    'monthly_amount'      => $amt,
                    'percentage_value'    => $pct,
                    'is_active'           => 1,
                    'created_at'          => date('Y-m-d H:i:s'),
                ]);
            }
            $count++;
        }

        // Recalculate any open payroll runs
        $this->recalculate_open_runs();

        return $count;
    }

    /**
     * Recalculate any open/unfinalized payroll runs so updated salary structures and components reflect immediately
     */
    public function recalculate_open_runs(?string $empId = null): void
    {
        $openRuns = $this->db->table('payroll_run')
            ->whereIn('payroll_status', ['DRAFT', 'CALCULATED', 'APPROVED'])
            ->get()->getResultArray();

        foreach ($openRuns as $run) {
            $runId = (int)$run['payroll_run_id'];
            if ($empId) {
                $this->sp_calculate_employee_payroll($runId, $empId, 'ADMIN');
            } else {
                $this->sp_calculate_monthly_payroll($runId, 'ADMIN');
            }
        }
    }

    // Salary structures
    public function get_all_employee_structures(): array
    {
        $sql = "SELECT 
                    u.emp_id,
                    u.emp_name,
                    d.department_name,
                    des.designation_name,
                    u.bank_name,
                    u.bank_account_no,
                    u.ifsc,
                    ess.salary_structure_id,
                    ess.structure_version,
                    ess.effective_from,
                    ess.effective_to,
                    ess.monthly_ctc,
                    ess.payroll_status,
                    (SELECT COUNT(*) FROM employee_salary_component esc WHERE esc.salary_structure_id = ess.salary_structure_id AND esc.is_active = 1) AS active_component_count,
                    (SELECT COUNT(*) FROM employee_salary_component esc WHERE esc.salary_structure_id = ess.salary_structure_id) AS total_component_count
                FROM user_details u
                LEFT JOIN department_master d ON u.department = d.department_id
                LEFT JOIN designation_master des ON u.designation = des.designation_id
                LEFT JOIN employee_salary_structure ess ON ess.salary_structure_id = (
                    SELECT ess2.salary_structure_id 
                    FROM employee_salary_structure ess2 
                    WHERE ess2.emp_id = u.emp_id AND ess2.payroll_status = 'APPROVED'
                    ORDER BY ess2.structure_version DESC, ess2.salary_structure_id DESC 
                    LIMIT 1
                )
                WHERE LOWER(u.profisional_details_status) = 'active'
                ORDER BY u.emp_id ASC";
        return $this->db->query($sql)->getResultArray();
    }

    public function get_employee_structure_full(string $empId): ?array
    {
        $struct = $this->db->table('employee_salary_structure ess')
            ->select('ess.*, u.emp_name, d.department_name, des.designation_name')
            ->join('user_details u', 'ess.emp_id = u.emp_id', 'left')
            ->join('department_master d', 'u.department = d.department_id', 'left')
            ->join('designation_master des', 'u.designation = des.designation_id', 'left')
            ->where('ess.emp_id', $empId)
            ->where('ess.payroll_status', 'APPROVED')
            ->orderBy('ess.structure_version', 'DESC')
            ->limit(1)
            ->get()->getRowArray();

        if (!$struct) {
            $u = $this->db->table('user_details u')
                ->select('u.emp_id, u.emp_name, d.department_name, des.designation_name')
                ->join('department_master d', 'u.department = d.department_id', 'left')
                ->join('designation_master des', 'u.designation = des.designation_id', 'left')
                ->where('u.emp_id', $empId)
                ->get()->getRowArray();
            if (!$u) return null;
            $struct = [
                'emp_id'              => $u['emp_id'],
                'emp_name'            => $u['emp_name'],
                'department_name'     => $u['department_name'],
                'designation_name'    => $u['designation_name'],
                'salary_structure_id' => 0,
                'monthly_ctc'         => 30000.00,
                'effective_from'      => date('Y-m-01'),
                'payroll_status'      => 'DRAFT',
            ];
        }

        $components = [];
        if (!empty($struct['salary_structure_id'])) {
            $components = $this->db->table('employee_salary_component esc')
                ->select('esc.*, m.component_code, m.component_name, m.component_type, m.calculation_type, m.percentage_base, m.is_lop_applicable, m.is_taxable')
                ->join('salary_component_master m', 'esc.component_id = m.component_id')
                ->where('esc.salary_structure_id', $struct['salary_structure_id'])
                ->orderBy('m.component_type', 'ASC')
                ->orderBy('m.component_id', 'ASC')
                ->get()->getResultArray();
        }

        return [
            'structure'  => $struct,
            'components' => $components,
        ];
    }

    public function save_employee_structure_full(string $empId, float $monthlyCtc, array $components, string $effectiveFrom, string $adminId = 'ADMIN'): bool
    {
        $lastVersion = (int)($this->db->table('employee_salary_structure')
            ->where('emp_id', $empId)
            ->selectMax('structure_version', 'v')
            ->get()->getRow()->v ?? 0);
        $nextVersion = $lastVersion + 1;

        // Mark previous structure versions with end date
        $this->db->table('employee_salary_structure')
            ->where('emp_id', $empId)
            ->update([
                'effective_to'   => date('Y-m-d', strtotime($effectiveFrom . ' -1 day')),
                'payroll_status' => 'INACTIVE',
            ]);

        // Insert new approved version with exact updated Monthly CTC (e.g. 30k)
        $this->db->table('employee_salary_structure')->insert([
            'emp_id'            => $empId,
            'structure_version' => $nextVersion,
            'effective_from'    => $effectiveFrom,
            'effective_to'      => null,
            'monthly_ctc'       => $monthlyCtc,
            'payroll_status'    => 'APPROVED',
            'approved_by'       => $adminId,
            'approved_at'       => date('Y-m-d H:i:s'),
            'created_at'        => date('Y-m-d H:i:s'),
            'updated_at'        => date('Y-m-d H:i:s'),
        ]);

        $newStructId = $this->db->insertID();

        $masterComps = $this->get_salary_component_master();
        foreach ($masterComps as $m) {
            $compId = (int)$m['component_id'];
            $compData = $components[$compId] ?? null;

            if ($compData !== null) {
                $amt = (float)($compData['monthly_amount'] ?? 0);
                $pct = (isset($compData['percentage_value']) && $compData['percentage_value'] !== '') ? (float)$compData['percentage_value'] : null;
                $isActive = !empty($compData['is_active']) ? 1 : 0;
            } else {
                $amt = (float)($m['default_monthly_amount'] ?? 0);
                $pct = isset($m['percentage_value']) ? (float)$m['percentage_value'] : null;
                $isActive = (int)($m['is_active'] ?? 1);
            }

            $this->db->table('employee_salary_component')->insert([
                'salary_structure_id' => $newStructId,
                'component_id'        => $compId,
                'monthly_amount'      => $amt,
                'percentage_value'    => $pct,
                'is_active'           => $isActive,
                'created_at'          => date('Y-m-d H:i:s'),
            ]);
        }

        // Sync legacy table employee_salary so any legacy references have the updated 30k
        $this->sync_legacy_employee_salary($empId, $monthlyCtc, $components, $effectiveFrom);

        // Recalculate any open/unfinalized payroll runs for this employee immediately!
        $this->recalculate_open_runs($empId);

        return true;
    }

    /**
     * Synchronize legacy employee_salary & emp_salary_structures tables
     */
    public function sync_legacy_employee_salary(string $empId, float $monthlyCtc, array $components, string $effectiveFrom): void
    {
        try {
            $basic = 0.00; $hra = 0.00; $conv = 0.00; $med = 0.00; $others = 0.00;
            $pfEmp = 0.00; $esiEmp = 0.00; $pt = 0.00; $gross = 0.00; $deductions = 0.00;
            $pfEmplr = 0.00; $esiEmplr = 0.00;

            $masterComps = $this->get_salary_component_master();
            $masterMap = [];
            foreach ($masterComps as $m) {
                $masterMap[$m['component_id']] = $m;
            }

            foreach ($components as $cid => $cdata) {
                if (empty($cdata['is_active'])) continue;
                $amt = (float)($cdata['monthly_amount'] ?? 0);
                $m = $masterMap[$cid] ?? null;
                if (!$m) continue;

                $code = $m['component_code'];
                $type = $m['component_type'];

                if ($type === 'EARNING') {
                    $gross += $amt;
                    if ($code === 'BASIC') $basic = $amt;
                    elseif ($code === 'HRA') $hra = $amt;
                    elseif ($code === 'CONVEYANCE') $conv = $amt;
                    elseif ($code === 'MEDICAL') $med = $amt;
                    else $others += $amt;
                } elseif ($type === 'DEDUCTION') {
                    $deductions += $amt;
                    if (strpos($code, 'PF') !== false) $pfEmp = $amt;
                    elseif (strpos($code, 'ESI') !== false) $esiEmp = $amt;
                    elseif (strpos($code, 'TAX') !== false || $code === 'PROF_TAX') $pt = $amt;
                } elseif ($type === 'EMPLOYER_CONTRIBUTION') {
                    if (strpos($code, 'PF') !== false) $pfEmplr = $amt;
                    elseif (strpos($code, 'ESI') !== false) $esiEmplr = $amt;
                }
            }

            $net = max(0, $gross - $deductions);
            $monthName = strtolower(date('F', strtotime($effectiveFrom)));
            $year = (int)date('Y', strtotime($effectiveFrom));

            // Upsert into employee_salary
            $exist = $this->db->table('employee_salary')
                ->where('EMP_ID', $empId)
                ->where('month', $monthName)
                ->where('year', $year)
                ->get()->getRowArray();

            $salData = [
                'EMP_ID'                     => $empId,
                'salary'                     => $monthlyCtc,
                'ctc1'                       => $monthlyCtc,
                'gross'                      => $gross,
                'basic @ 50%'                => $basic,
                'hra @ 20%'                  => $hra,
                'medical @ 5%'               => $med,
                'conveyance @ 8%'            => $conv,
                'others @ 17%'               => $others,
                'pf_employee_contribution'   => $pfEmp,
                'esi_employee_contribution'  => $esiEmp,
                'pt'                         => $pt,
                'pf_employer_contribution'   => $pfEmplr,
                'esi_employer_contribution'  => $esiEmplr,
                'total_deductions'           => $deductions,
                'net_pay'                    => $net,
                'month'                      => $monthName,
                'year'                       => $year,
            ];

            if ($exist) {
                $this->db->table('employee_salary')->where('id', $exist['id'])->update($salData);
            } else {
                $this->db->table('employee_salary')->insert($salData);
            }
        } catch (\Throwable $e) {
            log_message('error', 'sync_legacy_employee_salary error: ' . $e->getMessage());
        }
    }

    // Payslips list
    public function get_all_payslips(int $runId = null, int $month = null, int $year = null, string $search = ''): array
    {
        $builder = $this->db->table('payslip p')
            ->select('p.*, pe.emp_id, pe.gross_earnings, pe.lop_deduction, pe.other_deductions, pe.net_salary, pe.paid_days, pe.lop_days, pr.payroll_month, pr.payroll_year, pr.period_start, pr.period_end, pr.payroll_run_id, u.emp_name, u.email, d.department_name')
            ->join('payroll_employee pe', 'p.payroll_employee_id = pe.payroll_employee_id')
            ->join('payroll_run pr', 'pe.payroll_run_id = pr.payroll_run_id')
            ->join('user_details u', 'pe.emp_id = u.emp_id', 'left')
            ->join('department_master d', 'u.department = d.department_id', 'left');

        if ($runId) {
            $builder->where('pr.payroll_run_id', $runId);
        }
        if ($month) {
            $builder->where('pr.payroll_month', $month);
        }
        if ($year) {
            $builder->where('pr.payroll_year', $year);
        }
        if (!empty($search)) {
            $builder->groupStart()
                ->like('pe.emp_id', $search)
                ->orLike('u.emp_name', $search)
                ->orLike('p.payslip_number', $search)
                ->groupEnd();
        }

        $builder->orderBy('p.payslip_id', 'DESC');
        return $builder->get()->getResultArray();
    }
}

