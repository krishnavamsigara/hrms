<?php
$pdo = new PDO('mysql:host=localhost;dbname=hrmsdevtest;charset=utf8mb4', 'root', 'vamsi123');
foreach ($pdo->query("DESCRIBE salary_component_master") as $r) {
    echo $r['Field'] . " | " . $r['Type'] . "\n";
}
