<?php
$mysqli = new mysqli("localhost", "root", "vamsi123", "hrmsdevtest");
$result = $mysqli->query("SELECT DISTINCT status FROM leave_application;");
while ($row = $result->fetch_assoc()) {
    echo $row['status'] . "\n";
}
$mysqli->close();
?>
