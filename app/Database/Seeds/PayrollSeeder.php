<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PayrollSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();
        $now = date('Y-m-d H:i:s');

        // 1. Seed Salary Components Master
        $components = [
            [
                'component_code'           => 'BASIC',
                'component_name'           => 'Basic Salary',
                'component_type'           => 'EARNING',
                'calculation_type'         => 'PERCENTAGE',
                'value'                    => 50.00,
                'based_on'                 => 'CTC',
                'is_statutory'             => 0,
                'is_employer_contribution' => 0,
                'is_active'                => 1,
                'display_order'            => 1,
                'created_at'               => $now,
                'updated_at'               => $now,
            ],
            [
                'component_code'           => 'HRA',
                'component_name'           => 'House Rent Allowance',
                'component_type'           => 'EARNING',
                'calculation_type'         => 'PERCENTAGE',
                'value'                    => 20.00,
                'based_on'                 => 'CTC',
                'is_statutory'             => 0,
                'is_employer_contribution' => 0,
                'is_active'                => 1,
                'display_order'            => 2,
                'created_at'               => $now,
                'updated_at'               => $now,
            ],
            [
                'component_code'           => 'MEDICAL',
                'component_name'           => 'Medical Allowance',
                'component_type'           => 'EARNING',
                'calculation_type'         => 'PERCENTAGE',
                'value'                    => 5.00,
                'based_on'                 => 'CTC',
                'is_statutory'             => 0,
                'is_employer_contribution' => 0,
                'is_active'                => 1,
                'display_order'            => 3,
                'created_at'               => $now,
                'updated_at'               => $now,
            ],
            [
                'component_code'           => 'CONVEYANCE',
                'component_name'           => 'Conveyance Allowance',
                'component_type'           => 'EARNING',
                'calculation_type'         => 'PERCENTAGE',
                'value'                    => 8.00,
                'based_on'                 => 'CTC',
                'is_statutory'             => 0,
                'is_employer_contribution' => 0,
                'is_active'                => 1,
                'display_order'            => 4,
                'created_at'               => $now,
                'updated_at'               => $now,
            ],
            [
                'component_code'           => 'OTHER_EARNINGS',
                'component_name'           => 'Other Earnings / Special Allowance',
                'component_type'           => 'EARNING',
                'calculation_type'         => 'FIXED',
                'value'                    => 0.00,
                'based_on'                 => 'CTC',
                'is_statutory'             => 0,
                'is_employer_contribution' => 0,
                'is_active'                => 1,
                'display_order'            => 5,
                'created_at'               => $now,
                'updated_at'               => $now,
            ],
            [
                'component_code'           => 'EPF_EMPLOYEE',
                'component_name'           => 'EPF (Employee)',
                'component_type'           => 'DEDUCTION',
                'calculation_type'         => 'PERCENTAGE',
                'value'                    => 12.00,
                'based_on'                 => 'BASIC',
                'is_statutory'             => 1,
                'is_employer_contribution' => 0,
                'is_active'                => 1,
                'display_order'            => 6,
                'created_at'               => $now,
                'updated_at'               => $now,
            ],
            [
                'component_code'           => 'EPF_EMPLOYER',
                'component_name'           => 'EPF (Employer)',
                'component_type'           => 'STATUTORY',
                'calculation_type'         => 'PERCENTAGE',
                'value'                    => 12.00,
                'based_on'                 => 'BASIC',
                'is_statutory'             => 1,
                'is_employer_contribution' => 1,
                'is_active'                => 1,
                'display_order'            => 7,
                'created_at'               => $now,
                'updated_at'               => $now,
            ],
            [
                'component_code'           => 'ESI_EMPLOYEE',
                'component_name'           => 'ESI (Employee)',
                'component_type'           => 'DEDUCTION',
                'calculation_type'         => 'PERCENTAGE',
                'value'                    => 0.75,
                'based_on'                 => 'GROSS',
                'is_statutory'             => 1,
                'is_employer_contribution' => 0,
                'is_active'                => 1,
                'display_order'            => 8,
                'created_at'               => $now,
                'updated_at'               => $now,
            ],
            [
                'component_code'           => 'ESI_EMPLOYER',
                'component_name'           => 'ESI (Employer)',
                'component_type'           => 'STATUTORY',
                'calculation_type'         => 'PERCENTAGE',
                'value'                    => 3.25,
                'based_on'                 => 'GROSS',
                'is_statutory'             => 1,
                'is_employer_contribution' => 1,
                'is_active'                => 1,
                'display_order'            => 9,
                'created_at'               => $now,
                'updated_at'               => $now,
            ],
            [
                'component_code'           => 'PT',
                'component_name'           => 'Professional Tax (PT)',
                'component_type'           => 'DEDUCTION',
                'calculation_type'         => 'SLAB',
                'value'                    => 0.00,
                'based_on'                 => 'GROSS',
                'is_statutory'             => 1,
                'is_employer_contribution' => 0,
                'is_active'                => 1,
                'display_order'            => 10,
                'created_at'               => $now,
                'updated_at'               => $now,
            ],
            [
                'component_code'           => 'ADVANCE',
                'component_name'           => 'Salary Advance Recovery',
                'component_type'           => 'DEDUCTION',
                'calculation_type'         => 'FIXED',
                'value'                    => 0.00,
                'based_on'                 => null,
                'is_statutory'             => 0,
                'is_employer_contribution' => 0,
                'is_active'                => 1,
                'display_order'            => 11,
                'created_at'               => $now,
                'updated_at'               => $now,
            ],
            [
                'component_code'           => 'TDS',
                'component_name'           => 'Tax Deducted at Source (TDS)',
                'component_type'           => 'DEDUCTION',
                'calculation_type'         => 'FIXED',
                'value'                    => 0.00,
                'based_on'                 => null,
                'is_statutory'             => 1,
                'is_employer_contribution' => 0,
                'is_active'                => 1,
                'display_order'            => 12,
                'created_at'               => $now,
                'updated_at'               => $now,
            ],
        ];

        foreach ($components as $comp) {
            $builder = $db->table('salary_components');
            if ($builder->where('component_code', $comp['component_code'])->countAllResults() == 0) {
                $builder->insert($comp);
            }
        }

        // 2. Seed Statutory Rules (EPF, ESI, PT)
        $ptRule = [
            'rule_code'      => 'PT_TELANGANA',
            'rule_name'      => 'Telangana Professional Tax',
            'employee_rate'  => 0.00,
            'employer_rate'  => 0.00,
            'wage_ceiling'   => 0.00,
            'state'          => 'TELANGANA',
            'effective_from' => '2026-01-01',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];
        $builderRule = $db->table('statutory_rules');
        $ruleRow = $builderRule->where('rule_code', 'PT_TELANGANA')->get()->getRowArray();
        if (!$ruleRow) {
            $builderRule->insert($ptRule);
            $ruleId = $db->insertID();
        } else {
            $ruleId = $ruleRow['id'];
        }

        // Slabs for Telangana PT
        $slabs = [
            ['rule_id' => $ruleId, 'min_amount' => 0.00,     'max_amount' => 15000.00, 'slab_amount' => 0.00,   'created_at' => $now],
            ['rule_id' => $ruleId, 'min_amount' => 15001.00, 'max_amount' => 20000.00, 'slab_amount' => 150.00, 'created_at' => $now],
            ['rule_id' => $ruleId, 'min_amount' => 20001.00, 'max_amount' => null,     'slab_amount' => 200.00, 'created_at' => $now],
        ];
        foreach ($slabs as $slab) {
            $builderSlab = $db->table('statutory_slabs');
            if ($builderSlab->where('rule_id', $ruleId)->where('min_amount', $slab['min_amount'])->countAllResults() == 0) {
                $builderSlab->insert($slab);
            }
        }
    }
}
