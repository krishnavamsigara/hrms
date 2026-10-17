<?php
$mysqli = new mysqli("localhost", "root", "vamsi123", "hrmsdevtest");
$res = $mysqli->query("SHOW TABLES LIKE '%payroll%'");
echo "=== PAYROLL TABLES ===\n";
while ($r = $res->fetch_array()) {
    echo $r[0] . "\n";
}

$res2 = $mysqli->query("SHOW TABLES LIKE '%salary%'");
echo "\n=== SALARY TABLES ===\n";
while ($r = $res2->fetch_array()) {
    echo $r[0] . "\n";
}
