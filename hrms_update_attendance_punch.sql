CREATE DEFINER=`root`@`localhost` PROCEDURE `hrms_update_attendance_punch`(
    IN p_emp_id VARCHAR(20),
    IN p_attendance_date DATE,
    IN p_first_in DATETIME,
    IN p_last_out DATETIME,
    IN p_request_id BIGINT,
    IN p_actor_emp_id VARCHAR(20)
)
main_block:BEGIN
    DECLARE v_work_mins INT DEFAULT 0;
    DECLARE v_status VARCHAR(20) DEFAULT 'PRESENT';
    DECLARE v_actor_category VARCHAR(20);

    SET time_zone = '+05:30';

    SELECT user_category INTO v_actor_category
    FROM user_login_details
    WHERE emp_id = p_actor_emp_id AND status = 'ACTIVE';

    IF v_actor_category NOT IN ('HR', 'ADMIN') THEN
        SELECT 'N' AS status, 'Unauthorized actor' AS remarks;
        LEAVE main_block;
    END IF;

    IF p_first_in IS NOT NULL AND p_last_out IS NOT NULL THEN
        SET v_work_mins = TIMESTAMPDIFF(MINUTE, p_first_in, p_last_out);
        IF v_work_mins < 0 THEN SET v_work_mins = 0; END IF;
        SET v_status = 'PRESENT';
    END IF;

    -- 1. Update or Insert in attendance table (used by employee/my_attendance)
    IF EXISTS (SELECT 1 FROM attendance WHERE emp_id = p_emp_id AND attendance_date = p_attendance_date) THEN
        UPDATE attendance
        SET punch_in = p_first_in,
            punch_out = p_last_out,
            status = v_status,
            updated_at = NOW()
        WHERE emp_id = p_emp_id AND attendance_date = p_attendance_date;
    ELSE
        INSERT INTO attendance (
            emp_id, attendance_date, punch_in, punch_out, status, created_at, updated_at
        ) VALUES (
            p_emp_id, p_attendance_date, p_first_in, p_last_out, v_status, NOW(), NOW()
        );
    END IF;

    -- 2. Update or Insert in attendance_daily table
    IF EXISTS (SELECT 1 FROM attendance_daily WHERE emp_id = p_emp_id AND attendance_date = p_attendance_date) THEN
        UPDATE attendance_daily
        SET first_in = p_first_in,
            last_out = p_last_out,
            work_minutes = v_work_mins,
            late_minutes = 0,
            early_exit_minutes = 0,
            attendance_status = v_status,
            remarks = 'Punch timing updated by Admin',
            updated_at = NOW()
        WHERE emp_id = p_emp_id AND attendance_date = p_attendance_date;
    ELSE
        INSERT INTO attendance_daily (
            emp_id, attendance_date, first_in, last_out, work_minutes,
            overtime_minutes, late_minutes, early_exit_minutes,
            attendance_status, remarks, generated_flag, received_on, updated_at
        ) VALUES (
            p_emp_id, p_attendance_date, p_first_in, p_last_out, v_work_mins,
            0, 0, 0,
            v_status, 'Punch timing created by Admin', 'Y', NOW(), NOW()
        );
    END IF;

    -- 3. Mark request as RESOLVED in general_requests
    IF p_request_id IS NOT NULL AND p_request_id > 0 THEN
        UPDATE general_requests
        SET status = 'RESOLVED',
            progress = 'Punch updated and resolved by Admin',
            resolved_id = p_actor_emp_id,
            updated_at = NOW()
        WHERE request_id = p_request_id;
    END IF;

    SELECT 'Y' AS status, 'Attendance punch updated in both tables successfully' AS remarks;
END