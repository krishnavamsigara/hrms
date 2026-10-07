<?php
$mysqli = new mysqli("localhost", "root", "vamsi123", "hrmsdevtest");

if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}

$result = $mysqli->query("SHOW CREATE PROCEDURE sp_admin_edit_absent_attendance");
if ($result) {
    $row = $result->fetch_assoc();
    echo $row['Create Procedure'];
} else {
    echo "Error: " . $mysqli->error;
}
$mysqli->close();
?>
