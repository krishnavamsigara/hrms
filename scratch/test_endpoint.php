<?php
$ch = curl_init("http://localhost:8085/admin/payroll/get_structure/BS00001");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$res = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
echo "HTTP Code: $httpCode\n";
echo "Response:\n" . substr($res, 0, 500) . "\n";
curl_close($ch);
