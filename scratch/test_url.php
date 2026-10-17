<?php
define('FCPATH', dirname(__DIR__) . '/public/');
require dirname(__DIR__) . '/app/Config/Paths.php';
$paths = new Config\Paths();
require $paths->systemDirectory . '/Boot.php';
CodeIgniter\Boot::bootWeb($paths);

echo "base_url('admin/payroll/get_structure/'): " . base_url('admin/payroll/get_structure/') . "\n";
echo "base_url('admin/payroll/get_structure') . '/': " . base_url('admin/payroll/get_structure') . "/\n";
