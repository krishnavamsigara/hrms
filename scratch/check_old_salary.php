<?php
$pdo = new PDO('mysql:host=localhost;dbname=hrmsdevtest;charset=utf8mb4', 'root', 'vamsi123', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

echo "=== salary_components ===\n";
$sc = $pdo->query("SELECT * FROM salary_components LIMIT 10")->fetchAll(PDO::FETCH_ASSOC);
print_r($sc);

echo "=== emp_salary_structures ===\n";
$ess = $pdo->query("SELECT * FROM emp_salary_structures LIMIT 5")->fetchAll(PDO::FETCH_ASSOC);
print_r($ess);

echo "=== count active users in user_details ===\n";
$users = $pdo->query("SELECT count(*) as c FROM user_details WHERE LOWER(profisional_details_status) = 'active'")->fetch(PDO::FETCH_ASSOC);
echo "Active users: " . $users['c'] . "\n";
