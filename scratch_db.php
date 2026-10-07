<?php
$mysqli = new mysqli("localhost", "root", "vamsi123", "hrmsdevtest");
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
$result = $mysqli->query("SHOW CREATE PROCEDURE sp_generate_payroll_attendance");
if ($result) {
    $row = $result->fetch_assoc();
    file_put_contents('sp_generate_payroll_attendance.sql', $row['Create Procedure']);
    echo "Procedure saved.";
} else {
    echo "Error: " . $mysqli->error;
}
$mysqli->close();
?>
