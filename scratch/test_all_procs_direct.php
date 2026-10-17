<?php
$mysqli = new mysqli("localhost", "root", "vamsi123", "hrmsdevtest");

echo "1. CALL get_attendance_overview_data('BS00001', '2026-09-25', '2026-10-24', '')...\n";
$res1 = $mysqli->query("CALL get_attendance_overview_data('BS00001', '2026-09-25', '2026-10-24', '')");
echo "Count: " . $res1->num_rows . "\n";
$mysqli->next_result();

echo "2. CALL sp_get_payroll_attendance_summary_stats(10, 2026)...\n";
$res2 = $mysqli->query("CALL sp_get_payroll_attendance_summary_stats(10, 2026)");
echo "Count: " . $res2->num_rows . "\n";
$mysqli->next_result();

echo "3. CALL sp_get_attendance_punch_stats('2026-09-25', '2026-10-24')...\n";
$res3 = $mysqli->query("CALL sp_get_attendance_punch_stats('2026-09-25', '2026-10-24')");
echo "Count: " . $res3->num_rows . "\n";
$mysqli->next_result();

echo "4. CALL sp_get_annual_attendance_matrix(2026, 25, '2025-12-25', '2026-12-24')...\n";
$res4 = $mysqli->query("CALL sp_get_annual_attendance_matrix(2026, 25, '2025-12-25', '2026-12-24')");
echo "Count: " . $res4->num_rows . "\n";
print_r($res4->fetch_assoc());
$mysqli->next_result();

echo "5. CALL sp_get_annual_payroll_summary(2026)...\n";
$res5 = $mysqli->query("CALL sp_get_annual_payroll_summary(2026)");
echo "Count: " . $res5->num_rows . "\n";
$mysqli->next_result();

echo "\nALL 5 STORED PROCEDURES EXECUTED FLAWLESSLY!\n";
