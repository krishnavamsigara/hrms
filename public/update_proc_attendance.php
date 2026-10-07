<?php
$mysqli = new mysqli("localhost", "root", "vamsi123", "hrmsdevtest");

if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}

$query = <<<'SQL'
CREATE PROCEDURE `sp_admin_edit_absent_attendance`(
    IN  p_emp_id        VARCHAR(20),
    IN  p_att_date      DATE,
    IN  p_edit_type     VARCHAR(10),   
    IN  p_admin_emp_id  VARCHAR(20),
    IN  p_punch_in      DATETIME,
    IN  p_punch_out     DATETIME,
    OUT p_out_status    CHAR(1),
    OUT p_out_message   VARCHAR(500)
)
BEGIN
    main_block: BEGIN

    DECLARE v_leave_type_id     INT    DEFAULT NULL;
    DECLARE v_lop_type_id       INT    DEFAULT NULL;
    DECLARE v_balance_id        BIGINT DEFAULT NULL;
    DECLARE v_closing_balance   DECIMAL(5,2) DEFAULT 0;
    DECLARE v_att_exists        INT    DEFAULT 0;
    DECLARE v_att_status        VARCHAR(30) DEFAULT '';
    DECLARE v_leave_year        INT;
    DECLARE v_new_att_status    VARCHAR(20) DEFAULT 'ABSENT';
    DECLARE v_approved_days     DECIMAL(5,2) DEFAULT 1.00;
    DECLARE v_lop_days          DECIMAL(5,2) DEFAULT 0.00;
    DECLARE v_app_leave_type_id INT DEFAULT NULL;
    DECLARE v_app_id            BIGINT DEFAULT NULL;
    DECLARE v_existing_app_id   BIGINT DEFAULT NULL;
    DECLARE v_reason_text       VARCHAR(500) DEFAULT '';

    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        GET DIAGNOSTICS CONDITION 1
            @sq_errno = MYSQL_ERRNO,
            @sq_msg   = MESSAGE_TEXT;
        ROLLBACK;
        SET p_out_status  = 'N';
        SET p_out_message = CONCAT('DB Error [', IFNULL(@sq_errno,'?'), ']: ', IFNULL(@sq_msg, 'Unknown'));
    END;

    SET p_out_status  = 'N';
    SET p_out_message = 'Init';

    SET v_leave_year = YEAR(p_att_date);


    SELECT 1, UPPER(TRIM(status))
    INTO   v_att_exists, v_att_status
    FROM   attendance
    WHERE  emp_id = p_emp_id AND attendance_date = p_att_date
    LIMIT  1;

    IF v_att_exists = 0 THEN
        SET p_out_status  = 'N';
        SET p_out_message = CONCAT('No attendance record for ', p_emp_id, ' on ', p_att_date);
        LEAVE main_block;
    END IF;

    IF v_att_status NOT IN ('ABSENT', 'A') THEN
        SET p_out_status  = 'N';
        SET p_out_message = CONCAT('Day is not ABSENT (current: ', v_att_status, '). Only ABSENT days can be edited.');
        LEAVE main_block;
    END IF;


    SELECT leave_type_id INTO v_lop_type_id
    FROM   leave_type
    WHERE  UPPER(TRIM(leave_code)) = 'LOP'
      AND  year   = v_leave_year
      AND  status = 'A'
    ORDER  BY leave_type_id ASC
    LIMIT  1;

    START TRANSACTION;

    SELECT app_id INTO v_existing_app_id
    FROM leave_application
    WHERE emp_id = p_emp_id
      AND status = 'PENDING'
      AND p_att_date BETWEEN from_date AND to_date
    LIMIT 1;

    IF UPPER(p_edit_type) = 'WFH' THEN

        SELECT leave_type_id INTO v_leave_type_id
        FROM   leave_type
        WHERE  UPPER(TRIM(leave_code)) = 'WFH'
          AND  year   = v_leave_year
          AND  status = 'A'
        ORDER  BY leave_type_id ASC LIMIT 1;

        IF v_leave_type_id IS NULL THEN
            ROLLBACK;
            SET p_out_status  = 'N';
            SET p_out_message = CONCAT('WFH leave type not found for year ', v_leave_year);
            LEAVE main_block;
        END IF;


        SELECT balance_id, closing_balance
        INTO   v_balance_id, v_closing_balance
        FROM   emp_leave_balance
        WHERE  emp_id        = p_emp_id
          AND  leave_type_id = v_leave_type_id
          AND  year          = v_leave_year
        ORDER  BY balance_id ASC LIMIT 1;
        
        IF v_balance_id IS NULL THEN
            INSERT INTO emp_leave_balance (emp_id, leave_type_id, year, opening_balance, credited, availed, closing_balance)
            VALUES (p_emp_id, v_leave_type_id, v_leave_year, 0, 0, 0, 0);
            SET v_balance_id = LAST_INSERT_ID();
        END IF;


        UPDATE emp_leave_balance
        SET    availed          = availed + 1,
               closing_balance  = closing_balance - 1,
               updated_on       = NOW(),
               updated_at       = NOW()
        WHERE  balance_id = v_balance_id;

        SET v_approved_days = 1.00;
        SET v_lop_days      = 0.00;
        SET v_new_att_status = 'WFH';
        SET v_reason_text = CONCAT('Admin adjusted: Absent on ', DATE_FORMAT(p_att_date,'%d-%b-%Y'), ' changed to WFH.');
        SET v_app_leave_type_id = v_leave_type_id;

        IF v_existing_app_id IS NOT NULL THEN
            UPDATE leave_application
            SET leave_type_id = v_app_leave_type_id,
                approved_leave_days = v_approved_days,
                lop_days = v_lop_days,
                reason = CONCAT(IFNULL(reason, ''), ' | ', v_reason_text),
                status = 'APPROVED',
                approved_by = p_admin_emp_id,
                approved_on = NOW(),
                updated_on = NOW()
            WHERE app_id = v_existing_app_id;
            SET v_app_id = v_existing_app_id;
        ELSE
            INSERT INTO leave_application (
                emp_id, leave_type_id,
                from_date, to_date,
                total_days, applied_days, approved_leave_days, lop_days,
                reason, status,
                applied_on, approved_by, approved_on,
                received_on, updated_on
            ) VALUES (
                p_emp_id, v_app_leave_type_id,
                p_att_date, p_att_date,
                1.00, 1.00, v_approved_days, v_lop_days,
                v_reason_text, 'APPROVED',
                NOW(), p_admin_emp_id, NOW(),
                NOW(), NOW()
            );
            SET v_app_id = LAST_INSERT_ID();
        END IF;


        UPDATE attendance
        SET    status     = v_new_att_status,
               punch_in   = IF(v_new_att_status = 'WFH', p_punch_in, NULL),
               punch_out  = IF(v_new_att_status = 'WFH', p_punch_out, NULL),
               updated_at = NOW()
        WHERE  emp_id = p_emp_id AND attendance_date = p_att_date;

        COMMIT;

        IF v_new_att_status = 'WFH' THEN
            SET p_out_status  = 'Y';
            SET p_out_message = CONCAT('WFH applied for ', DATE_FORMAT(p_att_date,'%d %b %Y'), '. WFH balance deducted. Application #', v_app_id, ' processed.');
        ELSE
            SET p_out_status  = 'Y';
            SET p_out_message = CONCAT('No WFH balance available. Marked as LOP for ', DATE_FORMAT(p_att_date,'%d %b %Y'), '. Application #', v_app_id, ' processed.');
        END IF;


    ELSEIF UPPER(p_edit_type) IN ('PL','SL','ML') THEN

        SELECT leave_type_id INTO v_leave_type_id
        FROM   leave_type
        WHERE  UPPER(TRIM(leave_code)) = UPPER(TRIM(p_edit_type))
          AND  year   = v_leave_year
          AND  status = 'A'
        ORDER  BY leave_type_id ASC LIMIT 1;

        IF v_leave_type_id IS NULL THEN
            ROLLBACK;
            SET p_out_status  = 'N';
            SET p_out_message = CONCAT(UPPER(p_edit_type), ' leave type not found for year ', v_leave_year);
            LEAVE main_block;
        END IF;


        SELECT balance_id, closing_balance
        INTO   v_balance_id, v_closing_balance
        FROM   emp_leave_balance
        WHERE  emp_id        = p_emp_id
          AND  leave_type_id = v_leave_type_id
          AND  year          = v_leave_year
        ORDER  BY balance_id ASC LIMIT 1;

        IF v_balance_id IS NULL THEN
            ROLLBACK;
            SET p_out_status  = 'N';
            SET p_out_message = CONCAT('No balance record for ', UPPER(p_edit_type), ' in year ', v_leave_year, ' for employee ', p_emp_id);
            LEAVE main_block;
        END IF;

        IF v_closing_balance >= 1 THEN

            UPDATE emp_leave_balance
            SET    availed          = availed + 1,
                   closing_balance  = closing_balance - 1,
                   updated_on       = NOW(),
                   updated_at       = NOW()
            WHERE  balance_id = v_balance_id;

            SET v_approved_days  = 1.00;
            SET v_lop_days       = 0.00;
            SET v_new_att_status = 'LEAVE';
            SET v_app_leave_type_id = v_leave_type_id;
            SET v_reason_text = CONCAT('Admin adjusted: Absent on ', DATE_FORMAT(p_att_date,'%d-%b-%Y'), ' changed to ', UPPER(p_edit_type), ' leave. Balance deducted.');

            IF v_existing_app_id IS NOT NULL THEN
                UPDATE leave_application
                SET leave_type_id = v_app_leave_type_id,
                    approved_leave_days = v_approved_days,
                    lop_days = v_lop_days,
                    reason = CONCAT(IFNULL(reason, ''), ' | ', v_reason_text),
                    status = 'APPROVED',
                    approved_by = p_admin_emp_id,
                    approved_on = NOW(),
                    updated_on = NOW()
                WHERE app_id = v_existing_app_id;
                SET v_app_id = v_existing_app_id;
            ELSE
                INSERT INTO leave_application (
                    emp_id, leave_type_id,
                    from_date, to_date,
                    total_days, applied_days, approved_leave_days, lop_days,
                    reason, status,
                    applied_on, approved_by, approved_on,
                    received_on, updated_on
                ) VALUES (
                    p_emp_id, v_app_leave_type_id,
                    p_att_date, p_att_date,
                    1.00, 1.00, 1.00, 0.00,
                    v_reason_text, 'APPROVED',
                    NOW(), p_admin_emp_id, NOW(),
                    NOW(), NOW()
                );
                SET v_app_id = LAST_INSERT_ID();
            END IF;

            UPDATE attendance
            SET    status     = 'LEAVE',
                   punch_in   = NULL,
                   punch_out  = NULL,
                   updated_at = NOW()
            WHERE  emp_id = p_emp_id AND attendance_date = p_att_date;

            COMMIT;
            SET p_out_status  = 'Y';
            SET p_out_message = CONCAT(UPPER(p_edit_type), ' leave applied for ', DATE_FORMAT(p_att_date,'%d %b %Y'), '. Balance deducted. Application #', v_app_id, ' processed.');

        ELSE

            SET v_app_leave_type_id = IFNULL(v_lop_type_id, v_leave_type_id);
            SET v_reason_text = CONCAT('Admin adjusted: Absent on ', DATE_FORMAT(p_att_date,'%d-%b-%Y'), ' - no ', UPPER(p_edit_type), ' balance, marked as LOP.');

            IF v_existing_app_id IS NOT NULL THEN
                UPDATE leave_application
                SET leave_type_id = v_app_leave_type_id,
                    approved_leave_days = 0.00,
                    lop_days = 1.00,
                    reason = CONCAT(IFNULL(reason, ''), ' | ', v_reason_text),
                    status = 'APPROVED',
                    approved_by = p_admin_emp_id,
                    approved_on = NOW(),
                    updated_on = NOW()
                WHERE app_id = v_existing_app_id;
                SET v_app_id = v_existing_app_id;
            ELSE
                INSERT INTO leave_application (
                    emp_id, leave_type_id,
                    from_date, to_date,
                    total_days, applied_days, approved_leave_days, lop_days,
                    reason, status,
                    applied_on, approved_by, approved_on,
                    received_on, updated_on
                ) VALUES (
                    p_emp_id, v_app_leave_type_id,
                    p_att_date, p_att_date,
                    1.00, 1.00, 0.00, 1.00,
                    v_reason_text, 'APPROVED',
                    NOW(), p_admin_emp_id, NOW(),
                    NOW(), NOW()
                );
                SET v_app_id = LAST_INSERT_ID();
            END IF;

            UPDATE attendance
            SET    status     = 'ABSENT',
                   punch_in   = NULL,
                   punch_out  = NULL,
                   updated_at = NOW()
            WHERE  emp_id = p_emp_id AND attendance_date = p_att_date;

            COMMIT;
            SET p_out_status  = 'Y';
            SET p_out_message = CONCAT('No ', UPPER(p_edit_type), ' balance. Marked as LOP for ', DATE_FORMAT(p_att_date,'%d %b %Y'), '. Application #', v_app_id, ' processed.');
        END IF;


    ELSEIF UPPER(p_edit_type) = 'LOP' THEN

        SET v_app_leave_type_id = v_lop_type_id;

        IF v_app_leave_type_id IS NULL THEN
            ROLLBACK;
            SET p_out_status  = 'N';
            SET p_out_message = CONCAT('LOP leave type not found for year ', v_leave_year);
            LEAVE main_block;
        END IF;

        SET v_reason_text = CONCAT('Admin adjusted: Absent on ', DATE_FORMAT(p_att_date,'%d-%b-%Y'), ' marked as Loss of Pay (LOP).');

        IF v_existing_app_id IS NOT NULL THEN
            UPDATE leave_application
            SET leave_type_id = v_app_leave_type_id,
                approved_leave_days = 0.00,
                lop_days = 1.00,
                reason = CONCAT(IFNULL(reason, ''), ' | ', v_reason_text),
                status = 'APPROVED',
                approved_by = p_admin_emp_id,
                approved_on = NOW(),
                updated_on = NOW()
            WHERE app_id = v_existing_app_id;
            SET v_app_id = v_existing_app_id;
        ELSE
            INSERT INTO leave_application (
                emp_id, leave_type_id,
                from_date, to_date,
                total_days, applied_days, approved_leave_days, lop_days,
                reason, status,
                applied_on, approved_by, approved_on,
                received_on, updated_on
            ) VALUES (
                p_emp_id, v_app_leave_type_id,
                p_att_date, p_att_date,
                1.00, 1.00, 0.00, 1.00,
                v_reason_text, 'APPROVED',
                NOW(), p_admin_emp_id, NOW(),
                NOW(), NOW()
            );
            SET v_app_id = LAST_INSERT_ID();
        END IF;

        UPDATE attendance
        SET    status     = 'ABSENT',
               punch_in   = NULL,
               punch_out  = NULL,
               updated_at = NOW()
        WHERE  emp_id = p_emp_id AND attendance_date = p_att_date;

        COMMIT;
        SET p_out_status  = 'Y';
        SET p_out_message = CONCAT('Marked as Loss of Pay (LOP) for ', DATE_FORMAT(p_att_date,'%d %b %Y'), '. Application #', v_app_id, ' processed.');

    ELSE
        ROLLBACK;
        SET p_out_status  = 'N';
        SET p_out_message = CONCAT('Invalid edit type: "', p_edit_type, '". Allowed: WFH, PL, SL, ML, LOP.');
    END IF;

    END main_block;

END;
SQL;

if ($mysqli->query("DROP PROCEDURE IF EXISTS sp_admin_edit_absent_attendance")) {
    echo "Dropped old procedure if existed.\n";
}

if ($mysqli->query($query)) {
    echo "Procedure updated successfully.\n";
} else {
    echo "Error creating procedure: " . $mysqli->error . "\n";
}

$mysqli->close();
?>
