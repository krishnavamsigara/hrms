<?php
$pdo = new PDO('mysql:host=localhost;dbname=hrmsdevtest;charset=utf8mb4', 'root', 'vamsi123');
echo "=== department_master ===\n";
foreach ($pdo->query("DESCRIBE department_master") as $r) {
    echo $r['Field'] . " | " . $r['Type'] . "\n";
}
echo "=== designation_master ===\n";
foreach ($pdo->query("DESCRIBE designation_master") as $r) {
    echo $r['Field'] . " | " . $r['Type'] . "\n";
}
