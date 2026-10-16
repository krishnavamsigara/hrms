<?php
$mysqli = new mysqli("localhost", "root", "vamsi123", "hrmsdevtest");
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$rawSql = file_get_contents(__DIR__ . '/create_payroll_procedures.sql');

// Split SQL by procedure definitions or clean delimiters
// Since mysqli doesn't understand "DELIMITER //", let's split individual procedures
$cleanSql = str_replace(["DELIMITER //", "DELIMITER ;", "//"], ["", "", ";"], $rawSql);

// We can execute each statement cleanly by parsing blocks or drop and create
// Better yet, let's read each DROP and CREATE statement
$statements = [];
$current = '';
$lines = explode("\n", $rawSql);
$inProc = false;

foreach ($lines as $line) {
    $trimmed = trim($line);
    if (stripos($trimmed, 'DELIMITER') === 0 || $trimmed === '//') {
        continue;
    }
    if (stripos($trimmed, 'DROP PROCEDURE') === 0) {
        $mysqli->query($trimmed);
        echo "Dropped: $trimmed\n";
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
            // Remove // from end
            $procSql = preg_replace('/\/\/\s*$/', '', trim($current));
            if ($mysqli->query($procSql)) {
                // Extract proc name
                if (preg_match('/CREATE PROCEDURE\s+([a-zA-Z0-9_]+)/i', $procSql, $m)) {
                    echo "Created procedure: " . $m[1] . "\n";
                }
            } else {
                echo "Error creating procedure: " . $mysqli->error . "\n";
                echo "SQL: " . substr($procSql, 0, 150) . "...\n";
            }
            $inProc = false;
            $current = '';
        }
    }
}

echo "\nVerifying procedures in hrmsdevtest:\n";
$res = $mysqli->query("SHOW PROCEDURE STATUS WHERE Db = 'hrmsdevtest'");
$procs = [
    'sp_create_payroll_run',
    'sp_calculate_employee_payroll',
    'sp_calculate_monthly_payroll',
    'sp_validate_payroll_run',
    'sp_approve_payroll_run',
    'sp_finalize_payroll_run',
    'sp_generate_payslips',
    'sp_get_employee_payslip',
    'sp_reopen_payroll_run'
];

$existing = [];
while ($r = $res->fetch_assoc()) {
    $existing[] = $r['Name'];
}

foreach ($procs as $p) {
    echo "  $p: " . (in_array($p, $existing) ? "OK" : "MISSING") . "\n";
}

$mysqli->close();
