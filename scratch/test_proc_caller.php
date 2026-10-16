<?php
$mysqli = new mysqli("localhost", "root", "vamsi123", "hrmsdevtest");

function callProcWithMultiResultSets($mysqli, $procName, $params) {
    $paramStrs = array_map(function($p) use ($mysqli) {
        if ($p === null) return 'NULL';
        if (is_numeric($p)) return $p;
        return "'" . $mysqli->real_escape_string($p) . "'";
    }, $params);
    $sql = "CALL $procName(" . implode(', ', $paramStrs) . ")";

    $resultSets = [];
    if ($mysqli->multi_query($sql)) {
        do {
            if ($result = $mysqli->store_result()) {
                $resultSets[] = $result->fetch_all(MYSQLI_ASSOC);
                $result->free();
            }
        } while ($mysqli->more_results() && $mysqli->next_result());
    } else {
        throw new Exception($mysqli->error);
    }
    return $resultSets;
}

echo "Testing sp_validate_payroll_run(1):\n";
$sets = callProcWithMultiResultSets($mysqli, 'sp_validate_payroll_run', [1]);
echo "Result sets returned: " . count($sets) . "\n";
print_r($sets[0]);

echo "\nTesting sp_get_employee_payslip(1, 'BS00001'):\n";
$payslipSets = callProcWithMultiResultSets($mysqli, 'sp_get_employee_payslip', [1, 'BS00001']);
echo "Result sets returned: " . count($payslipSets) . "\n";
echo "Header emp_name: " . $payslipSets[0][0]['emp_name'] . "\n";
echo "Earnings count: " . count($payslipSets[1]) . "\n";
echo "Deductions count: " . count($payslipSets[2]) . "\n";
echo "Employer contrib count: " . count($payslipSets[3]) . "\n";

$mysqli->close();
