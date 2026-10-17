<?php
$m = new mysqli("localhost", "root", "vamsi123", "hrmsdevtest");
$sql = "SELECT 
    u.emp_id,
    u.emp_name,
    ess.salary_structure_id,
    ess.structure_version,
    ess.monthly_ctc,
    ess.payroll_status,
    (SELECT COUNT(*) FROM employee_salary_component esc WHERE esc.salary_structure_id = ess.salary_structure_id AND esc.is_active = 1) AS active_component_count,
    (SELECT COUNT(*) FROM employee_salary_component esc WHERE esc.salary_structure_id = ess.salary_structure_id) AS total_component_count
FROM user_details u
LEFT JOIN employee_salary_structure ess ON ess.salary_structure_id = (
    SELECT ess2.salary_structure_id 
    FROM employee_salary_structure ess2 
    WHERE ess2.emp_id = u.emp_id AND ess2.payroll_status = 'APPROVED'
    ORDER BY ess2.structure_version DESC, ess2.salary_structure_id DESC 
    LIMIT 1
)
WHERE LOWER(u.profisional_details_status) = 'active'
ORDER BY u.emp_id ASC
LIMIT 5";

$res = $m->query($sql);
while ($r = $res->fetch_assoc()) {
    print_r($r);
}
