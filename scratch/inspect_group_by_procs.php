<?php
$mysqli = new mysqli("localhost", "root", "vamsi123", "hrmsdevtest");

$procs = ['sp_get_attendance_punch_stats', 'sp_get_annual_attendance_matrix'];
foreach ($procs as $p) {
    echo "========================================\n$p\n========================================\n";
    $res = $mysqli->query("SHOW CREATE PROCEDURE `$p`");
    if ($res) {
        $row = $res->fetch_assoc();
        echo $row['Create Procedure'] . "\n\n";
    } else {
        echo "Error: " . $mysqli->error . "\n";
    }
}
