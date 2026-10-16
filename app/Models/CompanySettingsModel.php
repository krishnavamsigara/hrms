<?php

namespace App\Models;

use CodeIgniter\Model;

class CompanySettingsModel extends Model
{
    protected $table = 'company_settings';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'company_name',
        'brand_title_primary',
        'brand_title_secondary',
        'company_address',
        'city',
        'state',
        'pincode',
        'country',
        'email',
        'phone',
        'website',
        'logo_url',
        'watermark_url',
        'payroll_cycle_start_day',
        'payroll_cycle_end_day',
        'salary_pay_day',
        'standard_work_hours_per_day',
        'pan_number',
        'tan_number',
        'gstin',
        'pf_establishment_code',
        'esic_code',
        'cin',
        'payslip_prefix',
        'payslip_signatory_title',
        'payslip_footer_disclaimer',
        'updated_by',
        'updated_at'
    ];

    /**
     * Get Company Settings using Stored Procedure
     */
    public function get_settings(): array
    {
        try {
            $query = $this->db->query("CALL sp_get_company_settings()");
            $row = $query ? $query->getRowArray() : null;

            // Drain extra result sets left by stored proc
            if ($this->db->connID instanceof \mysqli) {
                try {
                    while (@mysqli_more_results($this->db->connID) && @mysqli_next_result($this->db->connID)) {
                        // drain
                    }
                } catch (\Throwable $ex) {
                    // suppress
                }
            }

            if ($row) {
                return $row;
            }
        } catch (\Throwable $e) {
            log_message('error', 'sp_get_company_settings error: ' . $e->getMessage());
        }

        // Direct table fallback if procedure fails
        $row = $this->db->table($this->table)->orderBy('id', 'ASC')->get()->getRowArray();
        if ($row) {
            return $row;
        }

        // Default fallback values
        return [
            'id'                          => 1,
            'company_name'                => 'Bloom Solutions',
            'brand_title_primary'         => 'Bloom',
            'brand_title_secondary'       => 'Solutions',
            'company_address'             => 'H No. 6-2-981, Flat No. 501, 5th Floor, Maruthi Plaza, Khairatabad - 500004, Hyderabad, Telangana.',
            'city'                        => 'Hyderabad',
            'state'                       => 'Telangana',
            'pincode'                     => '500004',
            'country'                     => 'India',
            'email'                       => 'hr@bloomsolutions.com',
            'phone'                       => '+91 40 1234 5678',
            'website'                     => 'https://bloomsolutions.com',
            'logo_url'                    => 'public/dist/img/bloom.jpg',
            'watermark_url'               => 'public/dist/img/bloom.jpg',
            'payroll_cycle_start_day'     => 25,
            'payroll_cycle_end_day'       => 24,
            'salary_pay_day'              => 1,
            'standard_work_hours_per_day' => 9.00,
            'pan_number'                  => '',
            'tan_number'                  => '',
            'gstin'                       => '',
            'pf_establishment_code'       => '',
            'esic_code'                   => '',
            'cin'                         => '',
            'payslip_prefix'              => 'PS-',
            'payslip_signatory_title'     => 'Authorized Signatory',
            'payslip_footer_disclaimer'   => 'This is a computer-generated statement, and does not require a signature and stamp.',
        ];
    }

    /**
     * Save Company Settings using Stored Procedure
     */
    public function save_settings(array $data, string $actor = 'ADMIN'): array
    {
        try {
            $this->db->query("SET @p_status = '', @p_message = ''");

            $sql = "CALL sp_save_company_settings(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, @p_status, @p_message)";
            $this->db->query($sql, [
                $data['company_name']            ?? 'Bloom Solutions',
                $data['brand_title_primary']     ?? 'Bloom',
                $data['brand_title_secondary']   ?? 'Solutions',
                $data['company_address']         ?? '',
                $data['city']                    ?? '',
                $data['state']                   ?? '',
                $data['pincode']                 ?? '',
                $data['country']                 ?? 'India',
                $data['email']                   ?? '',
                $data['phone']                   ?? '',
                $data['website']                 ?? '',
                $data['logo_url']                ?? null,
                $data['watermark_url']           ?? null,
                (int)($data['payroll_cycle_start_day'] ?? 25),
                (int)($data['payroll_cycle_end_day']   ?? 24),
                (int)($data['salary_pay_day']          ?? 1),
                (float)($data['standard_work_hours_per_day'] ?? 9.00),
                $data['pan_number']              ?? '',
                $data['tan_number']              ?? '',
                $data['gstin']                   ?? '',
                $data['pf_establishment_code']   ?? '',
                $data['esic_code']               ?? '',
                $data['cin']                     ?? '',
                $data['payslip_prefix']          ?? 'PS-',
                $data['payslip_signatory_title'] ?? 'Authorized Signatory',
                $data['payslip_footer_disclaimer'] ?? 'This is a computer-generated statement, and does not require a signature and stamp.',
                $actor
            ]);

            // Drain extra result sets left by stored proc
            if ($this->db->connID instanceof \mysqli) {
                try {
                    while (@mysqli_more_results($this->db->connID) && @mysqli_next_result($this->db->connID)) {
                        // drain
                    }
                } catch (\Throwable $ex) {
                    // suppress
                }
            }

            $res = $this->db->query("SELECT @p_status AS status, @p_message AS message")->getRowArray();
            return [
                'status'  => $res['status'] ?? 'Y',
                'message' => $res['message'] ?? 'Settings saved successfully.'
            ];
        } catch (\Throwable $e) {
            log_message('error', 'sp_save_company_settings error: ' . $e->getMessage());
            return [
                'status'  => 'N',
                'message' => 'Failed to save company settings: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Get Company Settings (camelCase alias)
     */
    public function getSettings(): array
    {
        return $this->get_settings();
    }

    /**
     * Save Company Settings (camelCase alias)
     */
    public function saveSettings(array $data, string $actor = 'ADMIN'): array
    {
        return $this->save_settings($data, $actor);
    }
}

