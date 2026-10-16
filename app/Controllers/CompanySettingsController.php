<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CompanySettingsModel;

class CompanySettingsController extends BaseController
{
    protected $settingsModel;

    public function __construct()
    {
        $this->settingsModel = new CompanySettingsModel();
    }

    private function checkAuth()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return false;
        }
        $cat = strtoupper((string)$session->get('user_category'));
        return ($cat === 'ADMIN' || $cat === 'HR');
    }

    /**
     * View Company Settings Page
     */
    public function index()
    {
        if (!$this->checkAuth()) {
            return redirect()->to(base_url('/'))->with('error', 'Unauthorized access.');
        }

        $settings = $this->settingsModel->get_settings();

        $data = [
            'settings' => $settings,
            'title'    => 'Company Settings & Payroll Configuration'
        ];

        return view('Layouts/Header', $data)
            . view('Layouts/Sidebar')
            . view('admin/company_settings', $data)
            . view('Layouts/Footer');
    }

    /**
     * Update Company Settings
     */
    public function update()
    {
        if (!$this->checkAuth()) {
            return redirect()->to(base_url('/'))->with('error', 'Unauthorized access.');
        }

        $session = session();
        $actor = $session->get('emp_id') ?? 'ADMIN';

        $data = [
            'company_name'                => trim($this->request->getPost('company_name') ?? 'Bloom Solutions'),
            'brand_title_primary'         => trim($this->request->getPost('brand_title_primary') ?? 'Bloom'),
            'brand_title_secondary'       => trim($this->request->getPost('brand_title_secondary') ?? 'Solutions'),
            'company_address'             => trim($this->request->getPost('company_address') ?? ''),
            'city'                        => trim($this->request->getPost('city') ?? ''),
            'state'                       => trim($this->request->getPost('state') ?? ''),
            'pincode'                     => trim($this->request->getPost('pincode') ?? ''),
            'country'                     => trim($this->request->getPost('country') ?? 'India'),
            'email'                       => trim($this->request->getPost('email') ?? ''),
            'phone'                       => trim($this->request->getPost('phone') ?? ''),
            'website'                     => trim($this->request->getPost('website') ?? ''),
            'payroll_cycle_start_day'     => (int)($this->request->getPost('payroll_cycle_start_day') ?: 25),
            'payroll_cycle_end_day'       => (int)($this->request->getPost('payroll_cycle_end_day') ?: 24),
            'salary_pay_day'              => (int)($this->request->getPost('salary_pay_day') ?: 1),
            'standard_work_hours_per_day' => (float)($this->request->getPost('standard_work_hours_per_day') ?: 9.00),
            'pan_number'                  => strtoupper(trim($this->request->getPost('pan_number') ?? '')),
            'tan_number'                  => strtoupper(trim($this->request->getPost('tan_number') ?? '')),
            'gstin'                       => strtoupper(trim($this->request->getPost('gstin') ?? '')),
            'pf_establishment_code'       => strtoupper(trim($this->request->getPost('pf_establishment_code') ?? '')),
            'esic_code'                   => strtoupper(trim($this->request->getPost('esic_code') ?? '')),
            'cin'                         => strtoupper(trim($this->request->getPost('cin') ?? '')),
            'payslip_prefix'              => trim($this->request->getPost('payslip_prefix') ?? 'PS-'),
            'payslip_signatory_title'     => trim($this->request->getPost('payslip_signatory_title') ?? 'Authorized Signatory'),
            'payslip_footer_disclaimer'   => trim($this->request->getPost('payslip_footer_disclaimer') ?? ''),
        ];

        // Handle Logo Image Upload
        $logoFile = $this->request->getFile('logo_file');
        if ($logoFile && $logoFile->isValid() && !$logoFile->hasMoved()) {
            $newName = 'company_logo_' . time() . '.' . $logoFile->getExtension();
            $destPath = FCPATH . 'public/dist/img/';
            if (!is_dir($destPath)) {
                mkdir($destPath, 0755, true);
            }
            $logoFile->move($destPath, $newName);
            $data['logo_url'] = 'public/dist/img/' . $newName;
        }

        // Handle Watermark Image Upload
        $watermarkFile = $this->request->getFile('watermark_file');
        if ($watermarkFile && $watermarkFile->isValid() && !$watermarkFile->hasMoved()) {
            $newName = 'company_watermark_' . time() . '.' . $watermarkFile->getExtension();
            $destPath = FCPATH . 'public/dist/img/';
            if (!is_dir($destPath)) {
                mkdir($destPath, 0755, true);
            }
            $watermarkFile->move($destPath, $newName);
            $data['watermark_url'] = 'public/dist/img/' . $newName;
        }

        $result = $this->settingsModel->save_settings($data, $actor);

        if ($result['status'] === 'Y') {
            return redirect()->to(base_url('admin/company_settings'))
                ->with('success', $result['message']);
        }

        return redirect()->back()
            ->withInput()
            ->with('error', $result['message']);
    }

    /**
     * JSON API Endpoint for AJAX/client components
     */
    public function get_json()
    {
        $settings = $this->settingsModel->get_settings();
        return $this->response->setJSON($settings);
    }
}
