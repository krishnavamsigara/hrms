<?php
$mysqli = new mysqli("localhost", "root", "vamsi123", "hrmsdevtest");

echo "=== SALARY COMPONENT MASTER ===\n";
$resMaster = $mysqli->query("SELECT component_id, component_code, component_name, component_type, calculation_type, percentage_base, percentage_value, is_lop_applicable, is_active FROM salary_component_master ORDER BY component_id");
while ($r = $resMaster->fetch_assoc()) {
    echo "ID: {$r['component_id']} | Code: {$r['component_code']} | Type: {$r['component_type']} | Calc: {$r['calculation_type']} | Pct: {$r['percentage_value']} | Active: {$r['is_active']}\n";
}

echo "\n=== EMPLOYEE SALARY COMPONENT COUNT PER STRUCTURE ===\n";
$resCompCount = $mysqli->query("SELECT salary_structure_id, COUNT(*) as cnt FROM employee_salary_component GROUP BY salary_structure_id LIMIT 5");
while ($r = $resCompCount->fetch_assoc()) {
    echo "Structure ID: {$r['salary_structure_id']} has {$r['cnt']} components\n";
}
