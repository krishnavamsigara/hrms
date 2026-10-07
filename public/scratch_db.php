<?php
$mysqli = new mysqli("localhost", "root", "vamsi123", "hrmsdevtest");
$result = $mysqli->query("SHOW CREATE PROCEDURE hrms_update_attendance_punch");
if ($result) {
    $row = $result->fetch_assoc();
    file_put_contents('../hrms_update_attendance_punch.sql', $row['Create Procedure']);
    echo "Saved procedure.";
}
$mysqli->close();
?>
