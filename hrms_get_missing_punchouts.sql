CREATE DEFINER=`root`@`localhost` PROCEDURE `hrms_get_missing_punchouts`(
    IN p_month INT,
    IN p_year INT,
    IN p_emp_id VARCHAR(20),
    IN p_exact_date DATE
)
main_block:BEGIN
    DECLARE v_start_date DATE;
    DECLARE v_end_date DATE;

    SET time_zone = '+05:30';

    IF p_exact_date IS NOT NULL THEN
        SET v_start_date = p_exact_date;
        SET v_end_date = p_exact_date;
    ELSE
        IF p_month IS NULL OR p_month <= 0 THEN
            SET p_month = MONTH(CURRENT_DATE());
        END IF;

        IF p_year IS NULL OR p_year <= 0 THEN
            SET p_year = YEAR(CURRENT_DATE());
        END IF;

        IF p_month = 1 THEN
            SET v_start_date = STR_TO_DATE(CONCAT(p_year - 1, '-12-25'), '%Y-%m-%d');
        ELSE
            SET v_start_date = STR_TO_DATE(CONCAT(p_year, '-', LPAD(p_month - 1, 2, '0'), '-25'), '%Y-%m-%d');
        END IF;

        SET v_end_date = STR_TO_DATE(CONCAT(p_year, '-', LPAD(p_month, 2, '0'), '-24'), '%Y-%m-%d');
    END IF;

    SELECT 
        a.id AS attendance_id,
        a.emp_id,
        u.emp_name,
        a.attendance_date,
        a.punch_in,
        a.punch_out,
        IFNULL(ad.attendance_status, 'MISSED_PUNCH') AS attendance_status,
        ad.remarks,
        DAYNAME(a.attendance_date) AS day_name
    FROM attendance a
    JOIN user_details u ON a.emp_id = u.emp_id
    LEFT JOIN attendance_daily ad ON a.emp_id = ad.emp_id AND a.attendance_date = ad.attendance_date
    WHERE a.attendance_date BETWEEN v_start_date AND v_end_date
      AND (
            (a.punch_in IS NOT NULL AND a.punch_out IS NULL)
            OR (ad.first_in IS NOT NULL AND ad.last_out IS NULL)
            OR ad.attendance_status = 'MISSED_PUNCH'
          )
      AND (p_emp_id IS NULL OR p_emp_id = '' OR a.emp_id = p_emp_id)
    ORDER BY a.attendance_date DESC, a.emp_id ASC;
END