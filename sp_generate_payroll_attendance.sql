CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_generate_payroll_attendance`(
    IN p_month INT,
    IN p_year INT,
    IN p_admin_emp_id VARCHAR(20),
    OUT p_status CHAR(1),
    OUT p_message VARCHAR(500)
)
main_block: BEGIN
    DECLARE done INT DEFAULT FALSE;
    DECLARE v_emp_id VARCHAR(20);
    DECLARE v_is_finalized VARCHAR(1);
    
    DECLARE v_start_date DATE;
    DECLARE v_end_date DATE;
    
    DECLARE v_total_days DECIMAL(5,2) DEFAULT 0;
    DECLARE v_working_days DECIMAL(5,2) DEFAULT 0;
    
    DECLARE v_present DECIMAL(5,2) DEFAULT 0;
    DECLARE v_wfh DECIMAL(5,2) DEFAULT 0;
    DECLARE v_leave DECIMAL(5,2) DEFAULT 0;
    DECLARE v_holiday DECIMAL(5,2) DEFAULT 0;
    DECLARE v_weekoff DECIMAL(5,2) DEFAULT 0;
    DECLARE v_absent DECIMAL(5,2) DEFAULT 0;
    
    DECLARE v_late INT DEFAULT 0;
    DECLARE v_half_days DECIMAL(5,2) DEFAULT 0;
    DECLARE v_overtime DECIMAL(6,2) DEFAULT 0;
    
    DECLARE v_paid DECIMAL(5,2) DEFAULT 0;
    DECLARE v_unpaid DECIMAL(5,2) DEFAULT 0;

    
    DECLARE emp_cursor CURSOR FOR 
        SELECT emp_id FROM user_login_details WHERE UPPER(status) = 'ACTIVE';
        
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;
    
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        GET DIAGNOSTICS CONDITION 1
            @sq_errno = MYSQL_ERRNO,
            @sq_msg   = MESSAGE_TEXT;
        ROLLBACK;
        SET p_status  = 'N';
        SET p_message = CONCAT('DB Error [', IFNULL(@sq_errno,'?'), ']: ', IFNULL(@sq_msg, 'Unknown'));
    END;

    IF p_admin_emp_id IS NULL OR p_admin_emp_id = '' THEN
        SET p_status = 'N';
        SET p_message = 'Admin Employee ID is required to run this process.';
        LEAVE main_block;
    END IF;

    SELECT is_finalized INTO v_is_finalized 
    FROM payroll_attendance_summary 
    WHERE payroll_month = p_month AND payroll_year = p_year 
    LIMIT 1;

    IF v_is_finalized = 'Y' THEN
        SET p_status = 'N';
        SET p_message = 'Attendance is already finalized for this month and cannot be regenerated.';
        LEAVE main_block;
    END IF;

    
    IF p_month = 1 THEN
        SET v_start_date = CONCAT(p_year - 1, '-12-25');
    ELSE
        SET v_start_date = CONCAT(p_year, '-', LPAD(p_month - 1, 2, '0'), '-25');
    END IF;
    SET v_end_date = CONCAT(p_year, '-', LPAD(p_month, 2, '0'), '-24');

    SET v_total_days = DATEDIFF(v_end_date, v_start_date) + 1;

    
    SELECT COUNT(*) INTO v_holiday 
    FROM holiday_master 
    WHERE holiday_date BETWEEN v_start_date AND v_end_date 
      AND status = 'A'
      AND UPPER(holiday_type) != 'WEEK_OFF';

    
    SELECT COUNT(*) INTO v_weekoff 
    FROM holiday_master 
    WHERE holiday_date BETWEEN v_start_date AND v_end_date 
      AND status = 'A'
      AND UPPER(holiday_type) = 'WEEK_OFF';

    SET v_working_days = v_total_days - v_holiday - v_weekoff;
    IF v_working_days < 0 THEN SET v_working_days = 0; END IF;

    START TRANSACTION;
    
    OPEN emp_cursor;
    
    read_loop: LOOP
        FETCH emp_cursor INTO v_emp_id;
        IF done THEN
            LEAVE read_loop;
        END IF;

        SET v_present = 0;
        SET v_wfh = 0;
        SET v_leave = 0;
        SET v_absent = 0;
        SET v_late = 0;
        SET v_half_days = 0;
        SET v_overtime = 0;

        
        
        SELECT 
            SUM(CASE WHEN UPPER(TRIM(status)) IN ('PRESENT') THEN 1 ELSE 0 END),
            SUM(CASE WHEN UPPER(TRIM(status)) IN ('WFH') THEN 1 ELSE 0 END),
            SUM(CASE WHEN UPPER(TRIM(status)) IN ('PL', 'SL', 'ML', 'CL', 'LEAVE') THEN 1 ELSE 0 END),
            SUM(CASE WHEN UPPER(TRIM(status)) IN ('ABSENT', 'A', 'LOP') THEN 1 ELSE 0 END),
            SUM(CASE WHEN UPPER(TRIM(status)) = 'LATE' THEN 1 ELSE 0 END)
        INTO 
            v_present, v_wfh, v_leave, v_absent, v_late
        FROM attendance
        WHERE emp_id = v_emp_id 
          AND attendance_date BETWEEN v_start_date AND v_end_date
          AND DAYOFWEEK(attendance_date) NOT IN (1,7)
          AND attendance_date NOT IN (SELECT holiday_date FROM holiday_master WHERE status = 'A');

        SET v_present = IFNULL(v_present, 0);
        SET v_wfh = IFNULL(v_wfh, 0);
        SET v_leave = IFNULL(v_leave, 0);
        SET v_absent = IFNULL(v_absent, 0);
        SET v_late = IFNULL(v_late, 0);

        
        SET v_present = v_present + v_late; 
        
        
        SET v_paid = v_present + v_wfh + v_leave + v_holiday + v_weekoff;
        SET v_unpaid = v_absent;

        
        INSERT INTO payroll_attendance_summary (
            emp_id, payroll_month, payroll_year, 
            total_days, working_days, 
            present_days, wfh_days, leave_days, holiday_days, weekly_off_days, absent_days,
            paid_days, unpaid_days,
            late_count, half_days, overtime_hours
        ) VALUES (
            v_emp_id, p_month, p_year,
            v_total_days, v_working_days,
            v_present, v_wfh, v_leave, v_holiday, v_weekoff, v_absent,
            v_paid, v_unpaid,
            v_late, v_half_days, v_overtime
        )
        ON DUPLICATE KEY UPDATE 
            total_days = v_total_days,
            working_days = v_working_days,
            present_days = v_present,
            wfh_days = v_wfh,
            leave_days = v_leave,
            holiday_days = v_holiday,
            weekly_off_days = v_weekoff,
            absent_days = v_absent,
            paid_days = v_paid,
            unpaid_days = v_unpaid,
            late_count = v_late,
            half_days = v_half_days,
            overtime_hours = v_overtime;

    END LOOP;
    
    CLOSE emp_cursor;
    
    COMMIT;
    
    SET p_status = 'Y';
    SET p_message = CONCAT('Payroll attendance generated successfully for period ', DATE_FORMAT(v_start_date, '%d-%b'), ' to ', DATE_FORMAT(v_end_date, '%d-%b'));

END