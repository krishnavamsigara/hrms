<?php

namespace App\Models;

use App\Models\AdminModel; //AdminModel
use CodeIgniter\Model;

class HomeModel extends Model
{
    /**
     * Checks if a user exists and fetches category and first-login flag
     * @param string $user_id
     * @param mixed $ftl (unused here, can be removed)
     * @return array|false User details (exists, id, category, is_firstlogin) or false if not found
     */

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


    //Login Authentication

    public function authenticateUser($staffId, $password)
    {
        return $this->callProcedure('authenticate_user', [$staffId, $password]);
    }

    public function changePassword($empId, $oldPassword, $newPassword)
    {
        return $this->callProcedure('change_password', [$empId, $oldPassword, $newPassword,  null, false]);
    }

    public function profile($user_id)
    {
        return $this->callProcedure('get_user_details', [$user_id]);
    }

    public function Token($empId, $token)
    {
        return $this->callProcedure('store_forgot_password_token', [$empId, $token]);
    }

    public function changeForgotPassword($empId, $oldPassword, $newPassword, $token, $forgotFlag)
    {
        return $this->callProcedure('change_password', [
            $empId,
            $oldPassword,
            $newPassword,
            $token,
            $forgotFlag
        ]);
    }

    public function profile_updation($empId, $jsonData)
    {
        return $this->callProcedure('hrms_profile_updation', [$empId,$jsonData]);
    }
}
