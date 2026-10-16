-- Table 1: salary_component_master
CREATE TABLE IF NOT EXISTS salary_component_master (
    component_id BIGINT AUTO_INCREMENT PRIMARY KEY,
    component_code VARCHAR(30) NOT NULL UNIQUE,
    component_name VARCHAR(100) NOT NULL,

    component_type ENUM(
        'EARNING',
        'DEDUCTION',
        'EMPLOYER_CONTRIBUTION'
    ) NOT NULL,

    calculation_type ENUM(
        'FIXED',
        'PERCENTAGE',
        'FORMULA',
        'MANUAL'
    ) NOT NULL DEFAULT 'FIXED',

    percentage_base ENUM(
        'BASIC',
        'GROSS',
        'CTC',
        'NONE'
    ) NOT NULL DEFAULT 'NONE',

    percentage_value DECIMAL(7,4) DEFAULT NULL,

    is_lop_applicable TINYINT(1) NOT NULL DEFAULT 1,
    is_taxable TINYINT(1) NOT NULL DEFAULT 1,
    is_active TINYINT(1) NOT NULL DEFAULT 1,

    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Table 2: employee_salary_structure
CREATE TABLE IF NOT EXISTS employee_salary_structure (
    salary_structure_id BIGINT AUTO_INCREMENT PRIMARY KEY,
    emp_id VARCHAR(20) NOT NULL,

    structure_version INT NOT NULL DEFAULT 1,
    effective_from DATE NOT NULL,
    effective_to DATE DEFAULT NULL,

    monthly_ctc DECIMAL(12,2) NOT NULL DEFAULT 0.00,

    payroll_status ENUM(
        'DRAFT',
        'APPROVED',
        'INACTIVE'
    ) NOT NULL DEFAULT 'DRAFT',

    approved_by VARCHAR(20) DEFAULT NULL,
    approved_at DATETIME DEFAULT NULL,

    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP,

    UNIQUE KEY uq_emp_salary_version
        (emp_id, structure_version),

    KEY idx_salary_effective
        (emp_id, effective_from, effective_to)
) ENGINE=InnoDB;

-- Table 3: employee_salary_component
CREATE TABLE IF NOT EXISTS employee_salary_component (
    salary_component_id BIGINT AUTO_INCREMENT PRIMARY KEY,
    salary_structure_id BIGINT NOT NULL,
    component_id BIGINT NOT NULL,

    monthly_amount DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    percentage_value DECIMAL(7,4) DEFAULT NULL,

    is_active TINYINT(1) NOT NULL DEFAULT 1,

    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

    UNIQUE KEY uq_salary_component
        (salary_structure_id, component_id),

    CONSTRAINT fk_esc_structure
        FOREIGN KEY (salary_structure_id)
        REFERENCES employee_salary_structure(salary_structure_id)
        ON DELETE CASCADE ON UPDATE CASCADE,

    CONSTRAINT fk_esc_component
        FOREIGN KEY (component_id)
        REFERENCES salary_component_master(component_id)
        ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB;

-- Table 4: payroll_run
CREATE TABLE IF NOT EXISTS payroll_run (
    payroll_run_id BIGINT AUTO_INCREMENT PRIMARY KEY,

    payroll_month TINYINT UNSIGNED NOT NULL,
    payroll_year SMALLINT UNSIGNED NOT NULL,

    period_start DATE NOT NULL,
    period_end DATE NOT NULL,

    salary_day_basis ENUM(
        'FIXED_30',
        'CALENDAR_DAYS',
        'WORKING_DAYS'
    ) NOT NULL DEFAULT 'FIXED_30',

    payroll_status ENUM(
        'DRAFT',
        'CALCULATED',
        'APPROVED',
        'FINALIZED'
    ) NOT NULL DEFAULT 'DRAFT',

    employee_count INT NOT NULL DEFAULT 0,

    created_by VARCHAR(20) DEFAULT NULL,
    calculated_by VARCHAR(20) DEFAULT NULL,
    approved_by VARCHAR(20) DEFAULT NULL,
    finalized_by VARCHAR(20) DEFAULT NULL,

    calculated_at DATETIME DEFAULT NULL,
    approved_at DATETIME DEFAULT NULL,
    finalized_at DATETIME DEFAULT NULL,

    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP,

    UNIQUE KEY uq_payroll_period
        (payroll_year, payroll_month),

    CONSTRAINT chk_payroll_month
        CHECK (payroll_month BETWEEN 1 AND 12),

    CONSTRAINT chk_payroll_period
        CHECK (period_start <= period_end)
) ENGINE=InnoDB;

-- Table 5: payroll_employee
CREATE TABLE IF NOT EXISTS payroll_employee (
    payroll_employee_id BIGINT AUTO_INCREMENT PRIMARY KEY,
    payroll_run_id BIGINT NOT NULL,
    emp_id VARCHAR(20) NOT NULL,

    salary_structure_id BIGINT NOT NULL,
    attendance_summary_id BIGINT DEFAULT NULL,

    total_days DECIMAL(6,2) NOT NULL DEFAULT 0,
    working_days DECIMAL(6,2) NOT NULL DEFAULT 0,
    paid_days DECIMAL(6,2) NOT NULL DEFAULT 0,
    lop_days DECIMAL(6,2) NOT NULL DEFAULT 0,

    monthly_ctc DECIMAL(12,2) NOT NULL DEFAULT 0,
    gross_earnings DECIMAL(12,2) NOT NULL DEFAULT 0,
    lop_deduction DECIMAL(12,2) NOT NULL DEFAULT 0,
    other_deductions DECIMAL(12,2) NOT NULL DEFAULT 0,
    employer_contributions DECIMAL(12,2) NOT NULL DEFAULT 0,

    net_salary DECIMAL(12,2) NOT NULL DEFAULT 0,

    calculation_status ENUM(
        'CALCULATED',
        'ERROR'
    ) NOT NULL DEFAULT 'CALCULATED',

    calculation_message VARCHAR(500) DEFAULT NULL,

    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP,

    UNIQUE KEY uq_run_employee (payroll_run_id, emp_id),

    CONSTRAINT fk_pe_run
        FOREIGN KEY (payroll_run_id)
        REFERENCES payroll_run(payroll_run_id)
        ON DELETE CASCADE ON UPDATE CASCADE,

    CONSTRAINT fk_pe_structure
        FOREIGN KEY (salary_structure_id)
        REFERENCES employee_salary_structure(salary_structure_id)
        ON DELETE RESTRICT ON UPDATE CASCADE,

    CONSTRAINT fk_pe_attendance
        FOREIGN KEY (attendance_summary_id)
        REFERENCES payroll_attendance_summary(summary_id)
        ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB;

-- Table 6: payroll_employee_component
CREATE TABLE IF NOT EXISTS payroll_employee_component (
    payroll_employee_component_id BIGINT AUTO_INCREMENT PRIMARY KEY,
    payroll_employee_id BIGINT NOT NULL,
    component_id BIGINT NOT NULL,

    component_code VARCHAR(30) NOT NULL,
    component_name VARCHAR(100) NOT NULL,
    component_type VARCHAR(30) NOT NULL,

    monthly_amount DECIMAL(12,2) NOT NULL DEFAULT 0,
    calculated_amount DECIMAL(12,2) NOT NULL DEFAULT 0,
    lop_amount DECIMAL(12,2) NOT NULL DEFAULT 0,
    payable_amount DECIMAL(12,2) NOT NULL DEFAULT 0,

    calculation_details JSON DEFAULT NULL,

    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

    UNIQUE KEY uq_payroll_employee_component
        (payroll_employee_id, component_id),

    CONSTRAINT fk_pec_employee
        FOREIGN KEY (payroll_employee_id)
        REFERENCES payroll_employee(payroll_employee_id)
        ON DELETE CASCADE ON UPDATE CASCADE,

    CONSTRAINT fk_pec_component
        FOREIGN KEY (component_id)
        REFERENCES salary_component_master(component_id)
        ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB;

-- Table 7: payslip
CREATE TABLE IF NOT EXISTS payslip (
    payslip_id BIGINT AUTO_INCREMENT PRIMARY KEY,

    payroll_employee_id BIGINT NOT NULL,
    payslip_number VARCHAR(50) NOT NULL UNIQUE,

    payslip_status ENUM(
        'GENERATED',
        'PUBLISHED',
        'VOID'
    ) NOT NULL DEFAULT 'GENERATED',

    generated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    published_at DATETIME DEFAULT NULL,

    pdf_file_path VARCHAR(500) DEFAULT NULL,

    UNIQUE KEY uq_payslip_employee (payroll_employee_id),

    CONSTRAINT fk_payslip_employee
        FOREIGN KEY (payroll_employee_id)
        REFERENCES payroll_employee(payroll_employee_id)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;
