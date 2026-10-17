<?php
$mysqli = new mysqli("localhost", "root", "vamsi123", "hrmsdevtest");
$res = $mysqli->query("CALL sp_get_annual_attendance_matrix(2026, 25, '2025-12-25', '2026-12-24')");
if (!$res) {
    echo "ERROR: " . $mysqli->error . "\n";
} else {
    echo "SUCCESS: " . $res->num_rows . " rows returned.\n";
    while ($r = $res->fetch_assoc()) print_r($r);
}
