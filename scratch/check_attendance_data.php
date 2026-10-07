<?php
$pdo = new PDO('mysql:host=localhost;dbname=hrmsdevtest;charset=utf8mb4', 'root', 'vamsi123');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$emp_id = 'BS00293';
$month = 10;
$year = 2026;

// Call get_employee_attendance_dashboard
$stmt = $pdo->prepare("CALL get_employee_attendance_dashboard(?, ?, ?)");
$stmt->execute([$emp_id, $month, $year]);
$dash = $stmt->fetchAll(PDO::FETCH_ASSOC);
$stmt->closeCursor();

echo "Dash result:\n";
print_r($dash);

// Call get_employee_attendance_details
$stmt2 = $pdo->prepare("CALL get_employee_attendance_details(?, ?, ?)");
$stmt2->execute([$emp_id, $month, $year]);
$details = $stmt2->fetchAll(PDO::FETCH_ASSOC);
$stmt2->closeCursor();

echo "\nDetails count: " . count($details) . "\n";
if (!empty($details)) {
    echo "First detail row:\n";
    print_r($details[0]);
}
