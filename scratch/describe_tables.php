<?php
$mysqli = new mysqli("localhost", "root", "vamsi123", "hrmsdevtest");
$res = $mysqli->query("SHOW INDEX FROM employee_salary_component");
echo "=== INDICES ON employee_salary_component ===\n";
while ($r = $res->fetch_assoc()) {
    echo "{$r['Key_name']} -> {$r['Column_name']} (Unique: " . ($r['Non_unique'] == 0 ? 'YES' : 'NO') . ")\n";
}
