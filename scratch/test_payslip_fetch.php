<?php
$mysqli = new mysqli("localhost", "root", "vamsi123", "hrmsdevtest");
if ($mysqli->multi_query("CALL sp_get_employee_payslip(1, 'BS00001')")) {
    $idx = 1;
    do {
        if ($res = $mysqli->store_result()) {
            echo "=== Result Set $idx ===\n";
            $rows = $res->fetch_all(MYSQLI_ASSOC);
            print_r($rows);
            $res->free();
            $idx++;
        }
    } while ($mysqli->more_results() && $mysqli->next_result());
}
$mysqli->close();
