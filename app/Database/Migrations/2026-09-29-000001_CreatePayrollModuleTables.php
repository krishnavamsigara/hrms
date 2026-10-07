<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePayrollModuleTables extends Migration
{
    public function up()
    {
        // 1. SALARY_COMPONENTS
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'component_code' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'component_name' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'component_type' => [
                'type'       => 'ENUM',
                'constraint' => ['EARNING', 'DEDUCTION', 'STATUTORY'],
                'default'    => 'EARNING',
            ],
            'calculation_type' => [
                'type'       => 'ENUM',
                'constraint' => ['PERCENTAGE', 'FIXED', 'SLAB'],
                'default'    => 'FIXED',
            ],
            'value' => [
                'type'       => 'DECIMAL',
                'constraint' => '12,2',
                'default'    => 0.00,
            ],
            'based_on' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => true, // CTC, BASIC, GROSS
            ],
            'is_statutory' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
            ],
            'is_employer_contribution' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
            ],
            'is_active' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 1,
            ],
            'display_order' => [
                'type'       => 'INT',
                'constraint' => 5,
                'default'    => 1,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('component_code');
        $this->forge->createTable('salary_components', true);

        // 2. EMP_SALARY_STRUCTURES
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'emp_id' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'component_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'calculation_type' => [
                'type'       => 'ENUM',
                'constraint' => ['PERCENTAGE', 'FIXED', 'SLAB'],
                'default'    => 'FIXED',
            ],
            'value' => [
                'type'       => 'DECIMAL',
                'constraint' => '12,2',
                'default'    => 0.00,
            ],
            'amount' => [
                'type'       => 'DECIMAL',
                'constraint' => '12,2',
                'default'    => 0.00,
            ],
            'effective_from' => [
                'type' => 'DATE',
            ],
            'effective_to' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey(['emp_id', 'component_id']);
        $this->forge->createTable('emp_salary_structures', true);

        // 3. EMP_OPTIONAL_COMPONENT_VALUES
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'emp_id' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'component_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'value' => [
                'type'       => 'DECIMAL',
                'constraint' => '12,2',
                'default'    => 0.00,
            ],
            'effective_from' => [
                'type' => 'DATE',
            ],
            'effective_to' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('emp_optional_component_values', true);

        // 4. STATUTORY_RULES
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'rule_code' => [
                'type'       => 'VARCHAR',
                'constraint' => '50', // EPF, ESI, PT, TDS
            ],
            'rule_name' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'employee_rate' => [
                'type'       => 'DECIMAL',
                'constraint' => '5,2',
                'default'    => 0.00,
            ],
            'employer_rate' => [
                'type'       => 'DECIMAL',
                'constraint' => '5,2',
                'default'    => 0.00,
            ],
            'wage_ceiling' => [
                'type'       => 'DECIMAL',
                'constraint' => '12,2',
                'default'    => 0.00,
            ],
            'state' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'default'    => 'TELANGANA',
            ],
            'effective_from' => [
                'type' => 'DATE',
            ],
            'effective_to' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('statutory_rules', true);

        // 5. STATUTORY_SLABS
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'rule_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'min_amount' => [
                'type'       => 'DECIMAL',
                'constraint' => '12,2',
                'default'    => 0.00,
            ],
            'max_amount' => [
                'type'       => 'DECIMAL',
                'constraint' => '12,2',
                'null'       => true,
            ],
            'slab_amount' => [
                'type'       => 'DECIMAL',
                'constraint' => '12,2',
                'default'    => 0.00,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('statutory_slabs', true);

        // 6. PAYROLL_CYCLES
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'payroll_code' => [
                'type'       => 'VARCHAR',
                'constraint' => '50', // e.g. AUG-2026
            ],
            'period_start' => [
                'type' => 'DATE', // e.g. 2026-07-25
            ],
            'period_end' => [
                'type' => 'DATE', // e.g. 2026-08-24
            ],
            'pay_date' => [
                'type' => 'DATE', // e.g. 2026-08-31
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['DRAFT', 'ATTENDANCE_IMPORTED', 'CALCULATED', 'HR_REVIEW', 'SUBMITTED', 'APPROVED', 'LOCKED'],
                'default'    => 'DRAFT',
            ],
            'total_employees' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
            ],
            'total_gross' => [
                'type'       => 'DECIMAL',
                'constraint' => '14,2',
                'default'    => 0.00,
            ],
            'total_deductions' => [
                'type'       => 'DECIMAL',
                'constraint' => '14,2',
                'default'    => 0.00,
            ],
            'total_net' => [
                'type'       => 'DECIMAL',
                'constraint' => '14,2',
                'default'    => 0.00,
            ],
            'created_by' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => true,
            ],
            'approved_by' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => true,
            ],
            'locked_by' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'approved_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'locked_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('payroll_cycles', true);

        // 7. PAYROLL_ATTENDANCES
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'payroll_cycle_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'emp_id' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'attendance_date' => [
                'type' => 'DATE',
            ],
            'status' => [
                'type'       => 'VARCHAR',
                'constraint' => '10', // P, A, HO, HOP, L, etc.
                'default'    => 'P',
            ],
            'in_time' => [
                'type'       => 'TIME',
                'null'       => true,
            ],
            'out_time' => [
                'type'       => 'TIME',
                'null'       => true,
            ],
            'worked_hours' => [
                'type'       => 'DECIMAL',
                'constraint' => '5,2',
                'default'    => 0.00,
            ],
            'leave_type' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => true,
            ],
            'is_paid' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 1,
            ],
            'is_hr_overridden' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
            ],
            'original_status' => [
                'type'       => 'VARCHAR',
                'constraint' => '10',
                'null'       => true,
            ],
            'override_reason' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey(['payroll_cycle_id', 'emp_id']);
        $this->forge->createTable('payroll_attendances', true);

        // 8. PAYROLL_EMPLOYEES (Payroll Draft & Processing Snapshot)
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'payroll_cycle_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'emp_id' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'employee_name' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ],
            'working_days' => [
                'type'       => 'DECIMAL',
                'constraint' => '5,1',
                'default'    => 0,
            ],
            'present_days' => [
                'type'       => 'DECIMAL',
                'constraint' => '5,1',
                'default'    => 0,
            ],
            'absent_days' => [
                'type'       => 'DECIMAL',
                'constraint' => '5,1',
                'default'    => 0,
            ],
            'paid_leave_days' => [
                'type'       => 'DECIMAL',
                'constraint' => '5,1',
                'default'    => 0,
            ],
            'holiday_days' => [
                'type'       => 'DECIMAL',
                'constraint' => '5,1',
                'default'    => 0,
            ],
            'weekly_off_days' => [
                'type'       => 'DECIMAL',
                'constraint' => '5,1',
                'default'    => 0,
            ],
            'lop_days' => [
                'type'       => 'DECIMAL',
                'constraint' => '5,1',
                'default'    => 0,
            ],
            'salary_basis' => [
                'type'       => 'DECIMAL',
                'constraint' => '12,2',
                'default'    => 0.00,
            ],
            'gross_salary' => [
                'type'       => 'DECIMAL',
                'constraint' => '12,2',
                'default'    => 0.00,
            ],
            'leave_deduction' => [
                'type'       => 'DECIMAL',
                'constraint' => '12,2',
                'default'    => 0.00,
            ],
            'total_earnings' => [
                'type'       => 'DECIMAL',
                'constraint' => '12,2',
                'default'    => 0.00,
            ],
            'total_deductions' => [
                'type'       => 'DECIMAL',
                'constraint' => '12,2',
                'default'    => 0.00,
            ],
            'net_salary' => [
                'type'       => 'DECIMAL',
                'constraint' => '12,2',
                'default'    => 0.00,
            ],
            'calculation_version' => [
                'type'       => 'INT',
                'constraint' => 5,
                'default'    => 1,
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['DRAFT', 'CALCULATED', 'HR_REVIEWED', 'APPROVED', 'LOCKED'],
                'default'    => 'DRAFT',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey(['payroll_cycle_id', 'emp_id']);
        $this->forge->createTable('payroll_employees', true);

        // 9. PAYROLL_ADJUSTMENTS
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'payroll_cycle_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'emp_id' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'component_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'adjustment_type' => [
                'type'       => 'ENUM',
                'constraint' => ['EARNING', 'DEDUCTION'],
                'default'    => 'EARNING',
            ],
            'amount' => [
                'type'       => 'DECIMAL',
                'constraint' => '12,2',
                'default'    => 0.00,
            ],
            'reason' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'created_by' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => true,
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['PENDING', 'APPLIED', 'REJECTED'],
                'default'    => 'APPLIED',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('payroll_adjustments', true);

        // 10. SALARIES (Final Frozen Payroll Header)
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'payroll_cycle_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'emp_id' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'gross_amount' => [
                'type'       => 'DECIMAL',
                'constraint' => '12,2',
                'default'    => 0.00,
            ],
            'total_earnings' => [
                'type'       => 'DECIMAL',
                'constraint' => '12,2',
                'default'    => 0.00,
            ],
            'total_deductions' => [
                'type'       => 'DECIMAL',
                'constraint' => '12,2',
                'default'    => 0.00,
            ],
            'net_amount' => [
                'type'       => 'DECIMAL',
                'constraint' => '12,2',
                'default'    => 0.00,
            ],
            'paid_days' => [
                'type'       => 'DECIMAL',
                'constraint' => '5,1',
                'default'    => 0,
            ],
            'lop_days' => [
                'type'       => 'DECIMAL',
                'constraint' => '5,1',
                'default'    => 0,
            ],
            'generated_on' => [
                'type' => 'DATETIME',
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['GENERATED', 'PAID', 'CANCELLED'],
                'default'    => 'GENERATED',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey(['payroll_cycle_id', 'emp_id']);
        $this->forge->createTable('salaries', true);

        // 11. SALARY_DETAILS (Final Frozen Component Breakdown)
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'salary_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'component_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'component_code_snapshot' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'component_name_snapshot' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'component_type' => [
                'type'       => 'ENUM',
                'constraint' => ['EARNING', 'DEDUCTION', 'STATUTORY'],
            ],
            'calculation_type' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
            ],
            'calculation_value' => [
                'type'       => 'DECIMAL',
                'constraint' => '12,2',
                'default'    => 0.00,
            ],
            'base_amount' => [
                'type'       => 'DECIMAL',
                'constraint' => '12,2',
                'default'    => 0.00,
            ],
            'amount' => [
                'type'       => 'DECIMAL',
                'constraint' => '12,2',
                'default'    => 0.00,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('salary_id');
        $this->forge->createTable('salary_details', true);

        // 12. PAYSLIPS
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'salary_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'payslip_number' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'emp_id' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'month' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
            ],
            'year' => [
                'type'       => 'INT',
                'constraint' => 4,
            ],
            'issued_at' => [
                'type' => 'DATETIME',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('payslips', true);

        // 13. PAYROLL_CALCULATION_HISTORIES (Audit Log)
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'payroll_cycle_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'emp_id' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'version_no' => [
                'type'       => 'INT',
                'constraint' => 5,
            ],
            'gross' => [
                'type'       => 'DECIMAL',
                'constraint' => '12,2',
            ],
            'deductions' => [
                'type'       => 'DECIMAL',
                'constraint' => '12,2',
            ],
            'net' => [
                'type'       => 'DECIMAL',
                'constraint' => '12,2',
            ],
            'calculated_by' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'reason' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'calculated_at' => [
                'type' => 'DATETIME',
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('payroll_calculation_histories', true);

        // 14. PAYROLL_IMPORT_BATCHES & ERRORS
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'payroll_cycle_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'file_name' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'uploaded_by' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'total_records' => [
                'type'       => 'INT',
                'default'    => 0,
            ],
            'success_records' => [
                'type'       => 'INT',
                'default'    => 0,
            ],
            'failed_records' => [
                'type'       => 'INT',
                'default'    => 0,
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['PROCESSING', 'COMPLETED', 'FAILED'],
                'default'    => 'COMPLETED',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('payroll_import_batches', true);

        // 15. EMPLOYEE_ADVANCES
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'emp_id' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'advance_date' => [
                'type' => 'DATE',
            ],
            'principal_amount' => [
                'type'       => 'DECIMAL',
                'constraint' => '12,2',
            ],
            'remaining_amount' => [
                'type'       => 'DECIMAL',
                'constraint' => '12,2',
            ],
            'installment_amount' => [
                'type'       => 'DECIMAL',
                'constraint' => '12,2',
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['ACTIVE', 'PAID_OFF', 'CANCELLED'],
                'default'    => 'ACTIVE',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('employee_advances', true);
    }

    public function down()
    {
        $this->forge->dropTable('employee_advances', true);
        $this->forge->dropTable('payroll_import_batches', true);
        $this->forge->dropTable('payroll_calculation_histories', true);
        $this->forge->dropTable('payslips', true);
        $this->forge->dropTable('salary_details', true);
        $this->forge->dropTable('salaries', true);
        $this->forge->dropTable('payroll_adjustments', true);
        $this->forge->dropTable('payroll_employees', true);
        $this->forge->dropTable('payroll_attendances', true);
        $this->forge->dropTable('payroll_cycles', true);
        $this->forge->dropTable('statutory_slabs', true);
        $this->forge->dropTable('statutory_rules', true);
        $this->forge->dropTable('emp_optional_component_values', true);
        $this->forge->dropTable('emp_salary_structures', true);
        $this->forge->dropTable('salary_components', true);
    }
}
