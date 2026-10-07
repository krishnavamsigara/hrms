<?php

namespace App\Models;

use CodeIgniter\Model;

class ManagerModel extends Model
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
        $placeholders = implode(',', array_fill(0, count($params), '?'));

        $sql = "CALL {$procedureName}({$placeholders})";

        $query = $this->db->query($sql, $params);

        if ($isQuery) {
            return $query->getResultArray();
        }

        return $this->db->affectedRows() > 0;
    }



    public function leave_history($empid, $user_category, $status, $fromdate, $todate)
    {
        return $this->callProcedure('hr_get_leave_application', [
            $empid,
            $user_category,
            $status,
            $fromdate,
            $todate
        ]);
    }

    public function employee_details($empid, $user_category, $type)
    {

    // echo '<pre>';
    // print_r([
    //     'empid' => $empid,
    //     'user_category' => $user_category,
    //     'type' => $type
    // ]);
    // exit;
        return $this->callProcedure('hr_get_employee_details', [
            $empid,
            $user_category,
            $type
        ]);
    }
}
