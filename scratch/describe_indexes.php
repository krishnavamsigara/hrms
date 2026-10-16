<?php
$pdo = new PDO('mysql:host=localhost;dbname=hrmsdevtest;charset=utf8mb4', 'root', 'vamsi123');
echo "=== KEYS ON payroll_attendance_summary ===\n";
foreach ($pdo->query("SHOW INDEX FROM payroll_attendance_summary") as $r) {
    echo $r['Key_name'] . " | " . $r['Column_name'] . " | Non_unique: " . $r['Non_unique'] . "\n";
}
