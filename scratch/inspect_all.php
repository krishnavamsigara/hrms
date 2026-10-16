<?php
$pdo = new PDO('mysql:host=localhost;dbname=hrmsdevtest;charset=utf8mb4', 'root', 'vamsi123', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

echo "=== TABLES ===\n";
$tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
foreach ($tables as $t) {
    echo "- $t\n";
}

echo "\n=== COMPANY SETTINGS ===\n";
if (in_array('company_settings', $tables)) {
    foreach ($pdo->query("DESCRIBE company_settings") as $r) {
        echo "  " . $r['Field'] . " | " . $r['Type'] . "\n";
    }
    echo "--- Data in company_settings ---\n";
    $rows = $pdo->query("SELECT * FROM company_settings")->fetchAll(PDO::FETCH_ASSOC);
    print_r($rows);
} else {
    echo "company_settings table NOT FOUND. Looking for similar tables:\n";
    foreach ($tables as $t) {
        if (stripos($t, 'setting') !== false || stripos($t, 'company') !== false) {
            echo "  found: $t\n";
        }
    }
}

echo "\n=== EMPLOYEE TABLE ===\n";
foreach ($tables as $t) {
    if (stripos($t, 'emp') !== false || stripos($t, 'user') !== false) {
        echo "Found: $t\n";
    }
}

echo "\n=== PROCEDURES ===\n";
$procs = $pdo->query("SHOW PROCEDURE STATUS WHERE Db = 'hrmsdevtest'")->fetchAll(PDO::FETCH_ASSOC);
foreach ($procs as $p) {
    echo "- " . $p['Name'] . "\n";
}
