<?php
$mysqli = new mysqli("localhost", "root", "vamsi123", "hrmsdevtest");
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error . "\n");
}

$rawSql = file_get_contents(__DIR__ . '/rebuild_payroll_procedures.sql');
$lines = explode("\n", $rawSql);
$inProc = false;
$current = '';

foreach ($lines as $line) {
    $trimmed = trim($line);
    if (stripos($trimmed, 'DELIMITER') === 0 || $trimmed === '//') {
        continue;
    }
    if (stripos($trimmed, 'DROP PROCEDURE') === 0) {
        $dropSql = rtrim($trimmed, ';');
        if ($mysqli->query($dropSql)) {
            echo "Executed: $dropSql\n";
        } else {
            echo "Error dropping: " . $mysqli->error . "\n";
        }
        continue;
    }
    if (stripos($trimmed, 'CREATE PROCEDURE') === 0) {
        $inProc = true;
        $current = $line . "\n";
        continue;
    }
    if ($inProc) {
        $current .= $line . "\n";
        if ($trimmed === 'END //' || $trimmed === 'END') {
            $procSql = preg_replace('/\/\/\s*$/', '', trim($current));
            if ($mysqli->query($procSql)) {
                if (preg_match('/CREATE PROCEDURE\s+([a-zA-Z0-9_]+)/i', $procSql, $m)) {
                    echo "Successfully rebuilt procedure: " . $m[1] . "\n";
                }
            } else {
                echo "Error creating procedure: " . $mysqli->error . "\n";
                echo "SQL Snippet: " . substr($procSql, 0, 150) . "...\n";
            }
            $inProc = false;
            $current = '';
        }
    }
}

// Now test calling sp_sync_all_active_components
echo "\nTesting sp_sync_all_active_components...\n";
if ($mysqli->query("CALL sp_sync_all_active_components()")) {
    echo "CALL sp_sync_all_active_components() SUCCEEDED!\n";
} else {
    echo "Error calling sp_sync_all_active_components: " . $mysqli->error . "\n";
}

$mysqli->close();
