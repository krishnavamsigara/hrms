<?php
$pdo = new PDO('mysql:host=localhost;dbname=hrmsdevtest;charset=utf8mb4', 'root', 'vamsi123');
$res = $pdo->query("SHOW FULL COLUMNS FROM user_details WHERE Field = 'emp_id'")->fetch(PDO::FETCH_ASSOC);
print_r($res);
$tbl = $pdo->query("SHOW TABLE STATUS WHERE Name = 'user_details'")->fetch(PDO::FETCH_ASSOC);
echo "user_details Collation: " . $tbl['Collation'] . "\n";
