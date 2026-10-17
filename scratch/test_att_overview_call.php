<?php
$mysqli = new mysqli("localhost", "root", "vamsi123", "hrmsdevtest");
$res = $mysqli->query("CALL get_attendance_overview_data('BS00001', '2026-09-25', '2026-10-24', '')");
if (!$res) {
    echo "ERROR: " . $mysqli->error . "\n";
} else {
    echo "SUCCESS: " . $res->num_rows . " rows returned.\n";
}
