<?php
$pdo = new PDO('mysql:host=localhost;dbname=hrmsdevtest;charset=utf8mb4', 'root', 'vamsi123');
echo "=== user_details indexes ===\n";
foreach ($pdo->query("SHOW INDEX FROM user_details") as $idx) {
    echo $idx['Key_name'] . " on " . $idx['Column_name'] . " (Non_unique: " . $idx['Non_unique'] . ")\n";
}
echo "=== payroll_attendance_summary indexes ===\n";
foreach ($pdo->query("SHOW INDEX FROM payroll_attendance_summary") as $idx) {
    echo $idx['Key_name'] . " on " . $idx['Column_name'] . " (Non_unique: " . $idx['Non_unique'] . ")\n";
}
