<?php
$m = new mysqli('localhost', 'root', 'vamsi123', 'hrmsdevtest');
$res = $m->query("SHOW PROCEDURE STATUS WHERE Db = 'hrmsdevtest'");
while ($r = $res->fetch_assoc()) {
    if (stripos($r['Name'], 'payroll') !== false || stripos($r['Name'], 'attendance') !== false) {
        echo $r['Name'] . "\n";
    }
}
