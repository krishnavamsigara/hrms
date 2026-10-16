<?php
$pdo = new PDO('mysql:host=localhost;dbname=hrmsdevtest;charset=utf8mb4', 'root', 'vamsi123');
echo "=== payroll_attendance_summary columns ===\n";
foreach ($pdo->query("DESCRIBE payroll_attendance_summary") as $r) {
    echo $r['Field'] . " | " . $r['Type'] . " | Default: " . ($r['Default'] ?? 'NULL') . "\n";
}
