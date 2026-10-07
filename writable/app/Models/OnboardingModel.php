<?php

namespace App\Models;

use CodeIgniter\Model;

class OnboardingModel extends Model
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

    // Create Candidate

    public function createCandidate($candidate_type, $emp_name, $email, $mobile, $offerletter, $created_by)
    {
        return $this->callProcedure(
            'hr_create_candidate',
            [
                $candidate_type,
                $emp_name,
                $email,
                $mobile,
                $offerletter,
                $created_by
            ]
        );
    }

    public function candidatelogin($refid, $password)
    {
        return $this->callProcedure('validate_candidate_login', [$refid, $password]);
    }

    public function getdetails($refid)
    {
        return $this->callProcedure('get_candidate_details_by_ref_id', [$refid]);
    }


    public function saveStepData(string $refId, array $newData, int $stepNumber): bool
    {
        // FETCH OLD DATA
        $existingData = [];

        if (!empty($result)) {
            $existingData = is_array($result) ? $result : json_decode($result, true);
        }
        // STORE CURRENT STEP
        $newData['current_step'] = $stepNumber;

        // START WITH OLD DATA
        $finalData = $existingData;

        // LOOP NEW DATA AND MERGE SAFELY
        foreach ($newData as $key => $value) {

            // If value is array (like address, documents)
            if (is_array($value)) {

                $finalData[$key] = array_merge(
                    $finalData[$key] ?? [],
                    $value
                );
            } else {

                // Only overwrite if not empty
                if ($value !== null && $value !== '') {
                    $finalData[$key] = $value;
                }
            }
        }

        // JSON ENCODE
        $jsonPayload = json_encode($finalData, JSON_UNESCAPED_SLASHES);

        // SAVE PROCEDURE
        return $this->callProcedure(
            'save_candidate_details',
            [$refId, $jsonPayload],
            false
        );
    }

    public function acceptoffer($refid)
    {
        return $this->callProcedure('accept_offer', [$refid]);
    }

    public function rejectoffer($refid, $remarks)
    {
        return $this->callProcedure('hr_reject_candidate', [$refid, $remarks]);
    }

    public function submitdetails($refid)
    {
        return $this->callProcedure('submit_candidate_details', [$refid]);
    }
}
