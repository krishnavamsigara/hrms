<?php
$mysqli = new mysqli("localhost", "root", "vamsi123", "hrmsdevtest");
$res = $mysqli->query("SHOW CREATE PROCEDURE get_attendance_overview_data");
if ($res) {
    $row = $res->fetch_assoc();
    echo $row['Create Procedure'] . "\n";
} else {
    echo "Error: " . $mysqli->error . "\n";
}
