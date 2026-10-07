<?php
// Test compilation and basic execution of controller methods
require 'c:/Users/VamsiKrishna/Desktop/V2/vendor/autoload.php';

$files = [
    'c:/Users/VamsiKrishna/Desktop/V2/app/Controllers/AdminController.php',
    'c:/Users/VamsiKrishna/Desktop/V2/app/Views/admin/attendance_overview.php',
    'c:/Users/VamsiKrishna/Desktop/V2/app/Views/admin/attendance_details.php',
    'c:/Users/VamsiKrishna/Desktop/V2/app/Views/admin/Requests.php',
    'c:/Users/VamsiKrishna/Desktop/V2/app/Config/Routes.php'
];

foreach ($files as $file) {
    $cmd = "C:\\xampp\\php\\php.exe -l \"$file\"";
    exec($cmd, $output, $return_var);
    if ($return_var === 0) {
        echo "SYNTAX OK: " . basename($file) . "\n";
    } else {
        echo "SYNTAX ERROR in " . basename($file) . ":\n" . implode("\n", $output) . "\n";
    }
    $output = [];
}
