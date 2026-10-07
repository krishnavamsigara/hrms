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
        return $this->db->table('salary_components')
            ->orderBy('display_order', 'ASC')
            ->get()->getResultArray();
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
        $rows = $this->db->table('emp_salary_structures es')
            ->select('es.*, sc.component_code, sc.component_name, sc.component_type, sc.based_on')
            ->join('salary_components sc', 'sc.id = es.component_id', 'left')
            ->where('es.emp_id', $emp_id)
            ->get()->getResultArray();

        if (empty($rows)) {
            $res = $this->callProcedure('sp_get_emp_salary_structure', [$emp_id], true);
            if (!empty($res)) return $res;
        }

        return $rows;
    }

    public function save_emp_salary_structure($emp_id, $components_data)
    {
        $this->db->transStart();
        $this->db->table('emp_salary_structures')->where('emp_id', $emp_id)->delete();

        foreach ($components_data as $comp) {
            if (empty($comp['component_id'])) continue;
            
            $effective_from = !empty($comp['effective_from']) ? $comp['effective_from'] : date('Y-m-01');

            $this->db->table('emp_salary_structures')->insert([
                'emp_id'           => $emp_id,
                'component_id'     => (int)$comp['component_id'],
                'calculation_type' => $comp['calculation_type'] ?? 'FIXED',
                'value'            => $comp['value'] ?? 0,
                'amount'           => $comp['amount'] ?? 0,
                'effective_from'   => $effective_from,
                'created_at'       => date('Y-m-d H:i:s'),
                'updated_at'       => date('Y-m-d H:i:s'),
            ]);
        }
        $this->db->transComplete();
        return $this->db->transStatus();
    }

    // ==========================================
    // 3. PAYROLL CYCLES
    // ==========================================
    public function get_all_cycles()
    {
        return $this->db->table('payroll_cycles')
            ->orderBy('id', 'DESC')
            ->get()->getResultArray();
    }

    public function get_cycle_by_id($id)
    {
        return $this->db->table('payroll_cycles')
            ->where('id', $id)
            ->get()->getRowArray();
    }

    public function create_payroll_cycle($data)
    {
        $data['status']     = 'DRAFT';
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->table('payroll_cycles')->insert($data);
        return $this->db->insertID();
    }

    // ==========================================
    // 4. ATTENDANCE SNAPSHOT & ACTIVE EMPLOYEES
    // ==========================================
    public function get_active_employees()
    {
        return $this->db->table('user_login_details uld')
            ->select('uld.emp_id, ud.emp_name, dm.department_name as department, dsm.designation_name as designation')
            ->join('user_details ud', 'ud.emp_id = uld.emp_id', 'left')
            ->join('department_master dm', 'dm.department_id = ud.department', 'left')
            ->join('designation_master dsm', 'dsm.designation_id = ud.designation', 'left')
            ->where('UPPER(uld.status)', 'ACTIVE')
            ->get()->getResultArray();
    }

    public function populate_attendance_snapshot($cycle_id)
    {
        $cycle = $this->get_cycle_by_id($cycle_id);
        if (!$cycle) return false;

        $active_users = $this->get_active_employees();
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

        // Fetch company holidays from holiday_master
        $holidays = $this->db->table('holiday_master')->get()->getResultArray();
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

        $records = $this->db->table('payroll_attendances pa')
            ->select('pa.*, ud.emp_name')
            ->join('user_details ud', 'ud.emp_id = pa.emp_id', 'left')
            ->where('pa.payroll_cycle_id', $cycle_id)
            ->get()->getResultArray();

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
        $row = $this->db->table('payroll_attendances')->where('id', $id)->get()->getRowArray();
        if (!$row) return false;

        $unpaid_statuses = ['A', 'LOP', 'ABSENT', 'UNPAID'];
        $is_paid = in_array(strtoupper(trim($new_status)), $unpaid_statuses) ? 0 : 1;

        return $this->db->table('payroll_attendances')->where('id', $id)->update([
            'original_status'   => $row['original_status'] ?? $row['status'],
            'status'            => strtoupper(trim($new_status)),
            'is_paid'           => $is_paid,
            'is_hr_overridden'  => 1,
            'override_reason'   => $reason,
            'updated_at'        => date('Y-m-d H:i:s'),
        ]);
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

        // Get list of active employees from user_login_details
        $active_users   = $this->get_active_employees();
        $active_emp_ids = array_column($active_users, 'emp_id');

        // Get list of unique employees in attendance snapshot filtering active users
        $employees = [];
        if (!empty($active_emp_ids)) {
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

        // Get PT Statutory Slabs
        $pt_slabs = $this->db->table('statutory_slabs ss')
            ->select('ss.*')
            ->join('statutory_rules sr', 'sr.id = ss.rule_id')
            ->where('sr.rule_code', 'PT_TELANGANA')
            ->get()->getResultArray();

        $total_cycle_gross      = 0;
        $total_cycle_deductions = 0;
        $total_cycle_net        = 0;
        $employee_count         = 0;

        $this->db->transStart();

        foreach ($employees as $empRow) {
            $emp_id = $empRow['emp_id'];

            // Fetch employee details from user_details DB
            $emp_master = $this->db->table('user_details')
                ->where('emp_id', $emp_id)
                ->get()->getRowArray();
            $emp_name = $emp_master['emp_name'] ?? ('Employee ' . $emp_id);

            // Fetch base salary/CTC from legacy employee_salary if available
            $legacy_sal = $this->db->table('employee_salary')
                ->where('EMP_ID', $emp_id)
                ->orderBy('id', 'DESC')
                ->get()->getRowArray();
            $monthly_ctc = (float)($legacy_sal['ctc1'] ?? $legacy_sal['salary'] ?? 50000.00);

            // Attendance aggregation
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
                $working_days = count($attendance_records);
            } else {
                $working_days     = $total_period_days;
                $present_days     = $total_period_days;
                $absent_days      = 0;
                $paid_leave_days  = 0;
                $holiday_days     = 0;
                $weekly_off_days  = 0;
            }

            $paid_days = $present_days + $paid_leave_days + $holiday_days + $weekly_off_days;
            $lop_days  = max(0, $total_period_days - $paid_days);

            // Check employee custom structure or compute default components
            $emp_structures = $this->get_emp_salary_structure($emp_id);

            $basic      = 0;
            $hra        = 0;
            $medical    = 0;
            $conveyance = 0;
            $other_earn = 0;

            if (!empty($emp_structures)) {
                foreach ($emp_structures as $es) {
                    $code = $es['component_code'];
                    $amt  = (float)$es['amount'];
                    if ($code == 'BASIC') $basic = $amt;
                    elseif ($code == 'HRA') $hra = $amt;
                    elseif ($code == 'MEDICAL') $medical = $amt;
                    elseif ($code == 'CONVEYANCE') $conveyance = $amt;
                    elseif ($code == 'OTHER_EARNINGS') $other_earn = $amt;
                }
            } elseif (!empty($legacy_sal)) {
                $basic      = (float)($legacy_sal['basic @ 50%'] ?? ($monthly_ctc * 0.50));
                $hra        = (float)($legacy_sal['hra @ 20%'] ?? ($monthly_ctc * 0.20));
                $medical    = (float)($legacy_sal['medical @ 5%'] ?? ($monthly_ctc * 0.05));
                $conveyance = (float)($legacy_sal['conveyance @ 8%'] ?? ($monthly_ctc * 0.08));
                $other_earn = (float)($legacy_sal['others @ 17%'] ?? ($monthly_ctc * 0.17));
            } else {
                $basic      = round($monthly_ctc * 0.50, 2);
                $hra        = round($monthly_ctc * 0.20, 2);
                $medical    = round($monthly_ctc * 0.05, 2);
                $conveyance = round($monthly_ctc * 0.08, 2);
                $other_earn = round($monthly_ctc * 0.17, 2);
            }

            $base_gross = $basic + $hra + $medical + $conveyance + $other_earn;

            // Pro-rate salary / calculate Leave Deduction based on LOP days
            $daily_rate = $total_period_days > 0 ? ($base_gross / $total_period_days) : 0;
            $leave_deduction = round($daily_rate * $lop_days, 2);

            $gross_salary = max(0, $base_gross - $leave_deduction);

            // Statutory Deductions
            $epf_basic_base = min($basic, 15000.00);
            $epf_employee = (float)($legacy_sal['pf_employee_contribution'] ?? round($epf_basic_base * 0.12, 2));

            $esi_employee = (float)($legacy_sal['esi_employee_contribution'] ?? 0.00);
            if (empty($legacy_sal) && $gross_salary <= 21000.00 && $gross_salary > 0) {
                $esi_employee = round($gross_salary * 0.0075, 2);
            }

            $pt = (float)($legacy_sal['pt'] ?? 0.00);
            if (empty($legacy_sal) && !empty($pt_slabs)) {
                foreach ($pt_slabs as $slab) {
                    $min = (float)$slab['min_amount'];
                    $max = $slab['max_amount'] !== null ? (float)$slab['max_amount'] : 999999999.00;
                    if ($gross_salary >= $min && $gross_salary <= $max) {
                        $pt = (float)$slab['slab_amount'];
                        break;
                    }
                }
            }

            $advance = (float)($legacy_sal['advances/ other_deductions'] ?? 0.00);
            $adv_row = $this->db->table('employee_advances')
                ->where('emp_id', $emp_id)
                ->where('status', 'ACTIVE')
                ->get()->getRowArray();
            if ($adv_row) {
                $advance += min((float)$adv_row['installment_amount'], (float)$adv_row['remaining_amount']);
            }

            $tds = (float)($legacy_sal['tds'] ?? 0.00);

            // Fetch HR Adjustments for this employee and cycle
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

            $total_earnings = $gross_salary + $adj_earnings;
            $total_deductions = $epf_employee + $esi_employee + $pt + $advance + $tds + $adj_deductions;
            $net_salary = max(0, $total_earnings - $total_deductions);

            $existing = $this->db->table('payroll_employees')
                ->where('payroll_cycle_id', $cycle_id)
                ->where('emp_id', $emp_id)
                ->get()->getRowArray();

            $version = $existing ? ((int)$existing['calculation_version'] + 1) : 1;

            $payroll_emp_data = [
                'payroll_cycle_id'      => $cycle_id,
                'emp_id'                => $emp_id,
                'employee_name'         => $emp_name,
                'working_days'          => $working_days,
                'present_days'          => $present_days,
                'absent_days'           => $absent_days,
                'paid_leave_days'       => $paid_leave_days,
                'holiday_days'          => $holiday_days,
                'weekly_off_days'       => $weekly_off_days,
                'lop_days'              => $lop_days,
                'salary_basis'          => $base_gross,
                'gross_salary'          => $gross_salary,
                'leave_deduction'       => $leave_deduction,
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

            $this->db->table('payroll_calculation_histories')->insert([
                'payroll_cycle_id' => $cycle_id,
                'emp_id'           => $emp_id,
                'version_no'       => $version,
                'gross'            => $total_earnings,
                'deductions'       => $total_deductions,
                'net'              => $net_salary,
                'calculated_by'    => $calculated_by,
                'reason'           => 'Automated payroll recalculation',
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
        $data['status']     = 'APPLIED';
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        return $this->db->table('payroll_adjustments')->insert($data);
    }

    public function get_payroll_adjustments($cycle_id, $emp_id = null)
    {
        $builder = $this->db->table('payroll_adjustments pa')
            ->select('pa.*, sc.component_name')
            ->join('salary_components sc', 'sc.id = pa.component_id', 'left')
            ->where('pa.payroll_cycle_id', $cycle_id);
        if (!empty($emp_id)) {
            $builder->where('pa.emp_id', $emp_id);
        }
        return $builder->get()->getResultArray();
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

        $working_days = (int)round((float)$emp_row['working_days']);
        $base_gross   = (float)$emp_row['salary_basis'];

        // Recalculate daily rate & leave deduction based on updated LOP days
        $daily_rate      = $working_days > 0 ? ($base_gross / $working_days) : 0;
        $leave_deduction = round($daily_rate * $lop_days, 2);
        $gross_salary    = max(0, $base_gross - $leave_deduction);

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

        // Aggregate applied adjustments
        $adjustments = $this->db->table('payroll_adjustments')
            ->where('payroll_cycle_id', $cycle_id)
            ->where('emp_id', $emp_id)
            ->where('status', 'APPLIED')
            ->get()->getResultArray();

        $total_adj_earn = 0;
        $total_adj_ded  = 0;
        foreach ($adjustments as $a) {
            if ($a['adjustment_type'] == 'EARNING') $total_adj_earn += (float)$a['amount'];
            else $total_adj_ded += (float)$a['amount'];
        }

        $total_earnings = $gross_salary + $total_adj_earn;

        $legacy_sal = $this->db->table('employee_salary')
            ->where('EMP_ID', $emp_id)
            ->orderBy('id', 'DESC')
            ->get()->getRowArray();
        $basic = round($base_gross * 0.50, 2);
        $epf_basic_base = min($basic, 15000.00);
        $epf_employee = (float)($legacy_sal['pf_employee_contribution'] ?? round($epf_basic_base * 0.12, 2));
        $pt = (float)($legacy_sal['pt'] ?? ($gross_salary > 20000 ? 200 : ($gross_salary >= 15001 ? 150 : 0)));

        $total_deductions = $epf_employee + $pt + $total_adj_ded;
        $net_salary       = max(0, $total_earnings - $total_deductions);
        $version          = ((int)$emp_row['calculation_version']) + 1;

        $this->db->table('payroll_employees')->where('id', $emp_row['id'])->update([
            'working_days'        => $working_days,
            'present_days'        => $present_days,
            'absent_days'         => $lop_days,
            'lop_days'            => $lop_days,
            'leave_deduction'     => $leave_deduction,
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

        $update_data = [
            'status'     => $status,
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        if ($status == 'APPROVED') {
            $update_data['approved_by'] = $actor_emp_id;
            $update_data['approved_at'] = date('Y-m-d H:i:s');
        } elseif ($status == 'LOCKED') {
            $update_data['locked_by'] = $actor_emp_id;
            $update_data['locked_at'] = date('Y-m-d H:i:s');
        }

        $this->db->transStart();
        $this->db->table('payroll_cycles')->where('id', $cycle_id)->update($update_data);

        if (in_array($status, ['APPROVED', 'LOCKED'])) {
            $this->freeze_payroll_results($cycle_id);
        }

        $this->db->transComplete();
        return $this->db->transStatus();
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

            // Create Salary Details snapshot rows from employee's configured salary structure
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
                $basic      = round($emp['gross_salary'] * 0.50, 2);
                $hra        = round($emp['gross_salary'] * 0.20, 2);
                $medical    = round($emp['gross_salary'] * 0.05, 2);
                $conveyance = round($emp['gross_salary'] * 0.08, 2);
                $other_earn = max(0, $emp['gross_salary'] - ($basic + $hra + $medical + $conveyance));

                $components_snapshot = [
                    ['code' => 'BASIC', 'name' => 'Basic Salary', 'type' => 'EARNING', 'calc' => 'PERCENTAGE', 'val' => 50, 'base' => $emp['gross_salary'], 'amt' => $basic],
                    ['code' => 'HRA', 'name' => 'House Rent Allowance', 'type' => 'EARNING', 'calc' => 'PERCENTAGE', 'val' => 20, 'base' => $emp['gross_salary'], 'amt' => $hra],
                    ['code' => 'MEDICAL', 'name' => 'Medical Allowance', 'type' => 'EARNING', 'calc' => 'PERCENTAGE', 'val' => 5, 'base' => $emp['gross_salary'], 'amt' => $medical],
                    ['code' => 'CONVEYANCE', 'name' => 'Conveyance Allowance', 'type' => 'EARNING', 'calc' => 'PERCENTAGE', 'val' => 8, 'base' => $emp['gross_salary'], 'amt' => $conveyance],
                    ['code' => 'OTHER_EARNINGS', 'name' => 'Other Allowance', 'type' => 'EARNING', 'calc' => 'FIXED', 'val' => 0, 'base' => $emp['gross_salary'], 'amt' => $other_earn],
                ];
            }

            foreach ($components_snapshot as $cs) {
                $this->db->table('salary_details')->insert([
                    'salary_id'               => $salary_id,
                    'component_code_snapshot' => $cs['code'],
                    'component_name_snapshot' => $cs['name'],
                    'component_type'           => $cs['type'],
                    'calculation_type'         => $cs['calc'],
                    'calculation_value'       => $cs['val'],
                    'base_amount'             => $cs['base'],
                    'amount'                  => $cs['amt'],
                    'created_at'              => date('Y-m-d H:i:s'),
                ]);
            }

            // Create Payslip row
            $existing_payslip = $this->db->table('payslips')
                ->where('salary_id', $salary_id)
                ->get()->getRowArray();
            if (!$existing_payslip) {
                $payslip_no = 'PS-' . $cycle_year . date('m', strtotime($cycle['period_end'])) . '-' . sprintf('%04d', $emp_id);
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
        }
    }

    // ==========================================
    // 8. PAYSLIP FETCH & COMPATIBILITY
    // ==========================================
    public function get_employee_frozen_payslip($emp_id, $month, $year)
    {
        $salary = $this->db->table('salaries s')
            ->select('s.*, pc.payroll_code, pc.period_start, pc.period_end, ud.emp_name, ud.bank_account_no, ud.ifsc, ud.pan, dm.department_name, dsm.designation_name')
            ->join('payroll_cycles pc', 'pc.id = s.payroll_cycle_id', 'left')
            ->join('user_details ud', 'ud.emp_id = s.emp_id', 'left')
            ->join('department_master dm', 'dm.department_id = ud.department', 'left')
            ->join('designation_master dsm', 'dsm.designation_id = ud.designation', 'left')
            ->where('s.emp_id', $emp_id)
            ->where('MONTH(s.generated_on)', date('m', strtotime("$month 1 $year")))
            ->where('YEAR(s.generated_on)', $year)
            ->get()->getRowArray();

        if (!$salary) {
            $salary = $this->db->table('salaries s')
                ->select('s.*, pc.payroll_code, pc.period_start, pc.period_end, ud.emp_name, ud.bank_account_no, ud.ifsc, ud.pan, dm.department_name, dsm.designation_name')
                ->join('payroll_cycles pc', 'pc.id = s.payroll_cycle_id', 'left')
                ->join('user_details ud', 'ud.emp_id = s.emp_id', 'left')
                ->join('department_master dm', 'dm.department_id = ud.department', 'left')
                ->join('designation_master dsm', 'dsm.designation_id = ud.designation', 'left')
                ->where('s.emp_id', $emp_id)
                ->orderBy('s.id', 'DESC')
                ->get()->getRowArray();
        }

        if (!$salary) return null;

        $details = $this->db->table('salary_details')
            ->where('salary_id', $salary['id'])
            ->get()->getResultArray();

        $earnings   = [];
        $deductions = [];
        $basic_salary = 0;

        foreach ($details as $d) {
            if ($d['component_type'] == 'EARNING') {
                $earnings[] = [
                    'allowance_name' => $d['component_name_snapshot'],
                    'amount'         => $d['amount'],
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
            'emp_id'              => $salary['emp_id'],
            'emp_name'            => $salary['emp_name'] ?? '',
            'department_name'     => $salary['department_name'] ?? '',
            'designation_name'    => $salary['designation_name'] ?? '',
            'pan'                 => $salary['pan'] ?? '',
            'bank_account_no'     => $salary['bank_account_no'] ?? '',
            'ifsc'                => $salary['ifsc'] ?? '',
            'basic_salary'        => $basic_salary,
            'total_working_days'  => $salary['paid_days'] + $salary['lop_days'],
            'no_days_present'     => $salary['paid_days'],
            'no_days_absent'      => $salary['lop_days'],
            'total_allowances'    => $salary['total_earnings'],
            'total_deductions'    => $salary['total_deductions'],
            'ctc'                 => $salary['gross_amount'],
            'net_income'          => $salary['net_amount'],
            'payroll_code'        => $salary['payroll_code'] ?? '',
        ];

        return [
            'header'     => $salary,
            'content'    => [$content_row],
            'earnings'   => $earnings,
            'deductions' => $deductions,
        ];
    }
}
