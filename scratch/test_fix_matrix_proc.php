<?php
$mysqli = new mysqli("localhost", "root", "vamsi123", "hrmsdevtest");

$sql = "
DROP PROCEDURE IF EXISTS sp_get_annual_attendance_matrix;
";
$mysqli->query($sql);

$proc = "
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_get_annual_attendance_matrix`(
    IN p_year INT,
    IN p_cycle_start_day INT,
    IN p_start_filter DATE,
    IN p_end_filter DATE
)
BEGIN
    SELECT 
        t.p_month,
        t.p_year,
        COUNT(*) as raw_count,
        COUNT(DISTINCT t.emp_id) as emp_count
    FROM (
        SELECT 
            emp_id,
            CASE 
                WHEN DAY(attendance_date) >= p_cycle_start_day THEN 
                    CASE WHEN MONTH(attendance_date) = 12 THEN 1 ELSE MONTH(attendance_date) + 1 END
                ELSE MONTH(attendance_date)
            END AS p_month,
            CASE 
                WHEN DAY(attendance_date) >= p_cycle_start_day AND MONTH(attendance_date) = 12 THEN YEAR(attendance_date) + 1
                ELSE YEAR(attendance_date)
            END AS p_year
        FROM attendance
        WHERE attendance_date >= p_start_filter AND attendance_date <= p_end_filter
    ) t
    GROUP BY t.p_year, t.p_month;
END;
";

if (!$mysqli->query($proc)) {
    die("CREATE PROCEDURE failed: " . $mysqli->error . "\n");
}
echo "Procedure recreated successfully!\n";

$res = $mysqli->query("CALL sp_get_annual_attendance_matrix(2026, 25, '2025-12-25', '2026-12-24')");
if (!$res) {
    echo "ERROR CALLING: " . $mysqli->error . "\n";
} else {
    echo "SUCCESS: " . $res->num_rows . " rows returned.\n";
    while ($r = $res->fetch_assoc()) {
        print_r($r);
    }
}
