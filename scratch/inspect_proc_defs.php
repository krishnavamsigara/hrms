<?php
$mysqli = new mysqli("localhost", "root", "vamsi123", "hrmsdevtest");
$procs = [
    'sp_check_attendance_finalized',
    'sp_create_payroll_cycle',
    'sp_create_payroll_run',
    'sp_get_payroll_export_data',
    'sp_get_payroll_cycle_employees',
    'sp_finalize_payroll_run',
    'sp_generate_payroll_attendance',
    'finalize_payroll_attendance_proc'
];

$out = "";
foreach ($procs as $p) {
    $out .= "====================================================\n";
    $out .= "PROCEDURE: $p\n";
    $out .= "====================================================\n";
    $res = $mysqli->query("SHOW CREATE PROCEDURE `$p`");
    if ($res && $row = $res->fetch_assoc()) {
        $out .= $row['Create Procedure'] . "\n\n";
    } else {
        $out .= "Not found or error: " . $mysqli->error . "\n\n";
    }
}
file_put_contents(__DIR__ . '/proc_defs_out.txt', $out);
echo "Written UTF-8!\n";
