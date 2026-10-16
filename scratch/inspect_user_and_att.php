<?php
$pdo = new PDO('mysql:host=localhost;dbname=hrmsdevtest;charset=utf8mb4', 'root', 'vamsi123', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

echo "=== user_details ===\n";
foreach ($pdo->query("DESCRIBE user_details") as $r) {
    if (in_array($r['Field'], ['id', 'emp_id', 'staff_id', 'first_name', 'last_name', 'email', 'status', 'user_status'])) {
        echo "  " . $r['Field'] . " | " . $r['Type'] . "\n";
    }
}
$sampleUser = $pdo->query("SELECT * FROM user_details LIMIT 2")->fetchAll(PDO::FETCH_ASSOC);
print_r($sampleUser);

echo "\n=== payroll_attendance_summary ===\n";
foreach ($pdo->query("DESCRIBE payroll_attendance_summary") as $r) {
    echo "  " . $r['Field'] . " | " . $r['Type'] . "\n";
}
$sampleSummary = $pdo->query("SELECT * FROM payroll_attendance_summary LIMIT 2")->fetchAll(PDO::FETCH_ASSOC);
print_r($sampleSummary);
