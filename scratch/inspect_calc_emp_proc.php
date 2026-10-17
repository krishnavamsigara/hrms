<?php
$mysqli = new mysqli("localhost", "root", "vamsi123", "hrmsdevtest");
$res = $mysqli->query("SHOW CREATE PROCEDURE sp_calculate_employee_payroll");
$row = $res->fetch_assoc();
echo $row['Create Procedure'] . "\n";
