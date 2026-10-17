<?php
$mysqli = new mysqli("localhost", "root", "vamsi123", "hrmsdevtest");
$res = $mysqli->query("SHOW CREATE PROCEDURE sp_generate_payslips");
if ($res) {
    $row = $res->fetch_assoc();
    echo $row['Create Procedure'] . "\n";
} else {
    echo "sp_generate_payslips error: " . $mysqli->error . "\n";
}
