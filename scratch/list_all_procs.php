<?php
$mysqli = new mysqli("localhost", "root", "vamsi123", "hrmsdevtest");
$res = $mysqli->query("SHOW PROCEDURE STATUS WHERE Db = 'hrmsdevtest'");
echo "=== STORED PROCEDURES IN hrmsdevtest ===\n";
while ($r = $res->fetch_assoc()) {
    echo $r['Name'] . "\n";
}
