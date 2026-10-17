<?php
$mysqli = new mysqli("localhost", "root", "vamsi123", "hrmsdevtest");

echo "=== payroll_cycles ===\n";
$res = $mysqli->query("SELECT * FROM payroll_cycles");
if ($res) {
    while ($r = $res->fetch_assoc()) print_r($r);
} else {
    echo $mysqli->error . "\n";
}

echo "=== payroll_run ===\n";
$res2 = $mysqli->query("SELECT * FROM payroll_run");
if ($res2) {
    while ($r = $res2->fetch_assoc()) print_r($r);
}

echo "=== payroll_employees count ===\n";
$res3 = $mysqli->query("SELECT COUNT(*) as cnt FROM payroll_employees");
if ($res3) print_r($res3->fetch_assoc());

echo "=== payroll_employee count ===\n";
$res4 = $mysqli->query("SELECT COUNT(*) as cnt FROM payroll_employee");
if ($res4) print_r($res4->fetch_assoc());
