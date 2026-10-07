<?php

namespace App\Models;

use CodeIgniter\Model;

class SalaryModel extends Model
{

    protected $db;

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }

    // Common Procedure Caller

    protected function callProcedure(
        string $procedureName,
        array $params = [],
        bool $isQuery = true
    ) {
        try {
            if (!empty($params)) {
                $escapedParams = array_map(function ($param) {
                    return "'" . $this->db->escapeString((string)$param) . "'";
                }, $params);
                $sql = "CALL {$procedureName}(" . implode(',', $escapedParams) . ")";
                $query = $this->db->query($sql);
            } else {
                $sql = "CALL {$procedureName}()";
                $query = $this->db->query($sql);
            }

            if ($isQuery && $query) {
                $result = $query->getResultArray();

                if ($this->db->connID instanceof \mysqli) {
                    try {
                        while (@mysqli_more_results($this->db->connID) && @mysqli_next_result($this->db->connID)) {
                            // Drain extra result sets left by MySQL stored procedure CALL
                        }
                    } catch (\Throwable $ex) {
                        // Suppress PHP 8.1+ strict mysqli exception
                    }
                }

                return $result;
            }

            return $query ? ($this->db->affectedRows() > 0) : false;
        } catch (\Throwable $e) {
            log_message('error', 'callProcedure Error [' . $procedureName . ']: ' . $e->getMessage());
            return $isQuery ? [] : false;
        }
    }

    public function get_emp_payslip($empid,$month,$year)
    {
        return $this->callProcedure('new_pay_slip', [$empid,$month,$year]);
    }

    public function get_emp_allowance($empid,$month,$year)
    {
        return $this->callProcedure('new_payslip_allowance', [$empid,$month,$year]);
    }

    public function get_emp_deductions($empid,$month,$year)
    {
        return $this->callProcedure('new_payslip_deductions', [$empid,$month,$year]);
    }

    public function get_view_salary()
    {
        return $this->callProcedure('view_all_salary', []);
    }

}
