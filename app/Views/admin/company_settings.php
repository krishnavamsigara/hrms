<div class="content-wrapper p-3" style="background: #f8fafc;">
  <!-- Content Header -->
  <div class="content-header pb-2">
    <div class="container-fluid">
      <div class="row align-items-center">
        <div class="col-sm-6">
          <h1 class="m-0 font-weight-bold text-dark" style="font-size: 1.5rem;">
            <i class="fas fa-building text-primary mr-2"></i> Company Settings & Payroll Configuration
          </h1>
          <p class="text-muted small mb-0 mt-1">
            Configure company branding, official address, statutory identifiers, and attendance/payroll cut-off periods.
          </p>
        </div>
        <div class="col-sm-6 text-sm-right mt-2 mt-sm-0">
          <a href="<?= base_url('admin/payroll') ?>" class="btn btn-outline-secondary btn-sm font-weight-bold mr-2">
            <i class="fas fa-calculator mr-1"></i> Payroll Processing
          </a>
          <button type="submit" form="companySettingsForm" class="btn btn-primary btn-sm font-weight-bold shadow-sm" style="background: #4a00e0; border-color: #4a00e0;">
            <i class="fas fa-save mr-1"></i> Save Changes
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Main Content -->
  <section class="content">
    <div class="container-fluid">

      <!-- Alerts -->
      <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
          <i class="fas fa-check-circle mr-2"></i> <?= session()->getFlashdata('success') ?>
          <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
      <?php endif; ?>

      <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
          <i class="fas fa-exclamation-circle mr-2"></i> <?= session()->getFlashdata('error') ?>
          <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
      <?php endif; ?>

      <form id="companySettingsForm" action="<?= base_url('admin/company_settings/update') ?>" method="POST" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <div class="row">

          <!-- Left Column: Company Profile & Statutory -->
          <div class="col-lg-7">

            <!-- Card 1: Brand & Profile -->
            <div class="card card-outline card-primary shadow-sm border-0 mb-4" style="border-radius: 12px;">
              <div class="card-header bg-white pt-3 border-bottom-0">
                <h5 class="card-title font-weight-bold text-dark m-0">
                  <i class="fas fa-id-card text-primary mr-2"></i> Company Profile & Identity
                </h5>
              </div>
              <div class="card-body">
                <div class="form-group">
                  <label class="font-weight-bold text-secondary small">Company Full Legal Name <span class="text-danger">*</span></label>
                  <input type="text" name="company_name" class="form-control" value="<?= esc($settings['company_name'] ?? 'Bloom Solutions') ?>" required placeholder="e.g. Bloom Solutions Private Limited">
                </div>

                <div class="row">
                  <div class="col-md-6 form-group">
                    <label class="font-weight-bold text-secondary small">Brand Name (Primary Word)</label>
                    <input type="text" name="brand_title_primary" class="form-control" value="<?= esc($settings['brand_title_primary'] ?? 'Bloom') ?>" placeholder="e.g. Bloom">
                    <small class="text-muted">Displays in blue on header logos & payslips</small>
                  </div>
                  <div class="col-md-6 form-group">
                    <label class="font-weight-bold text-secondary small">Brand Name (Secondary Word)</label>
                    <input type="text" name="brand_title_secondary" class="form-control" value="<?= esc($settings['brand_title_secondary'] ?? 'Solutions') ?>" placeholder="e.g. Solutions">
                    <small class="text-muted">Displays in accent color on header logos & payslips</small>
                  </div>
                </div>

                <div class="form-group">
                  <label class="font-weight-bold text-secondary small">Registered Corporate Address <span class="text-danger">*</span></label>
                  <textarea name="company_address" class="form-control" rows="2" required placeholder="Full registered office address"><?= esc($settings['company_address'] ?? '') ?></textarea>
                  <small class="text-muted">This address appears on official payslips and exported reports.</small>
                </div>

                <div class="row">
                  <div class="col-md-4 form-group">
                    <label class="font-weight-bold text-secondary small">City</label>
                    <input type="text" name="city" class="form-control" value="<?= esc($settings['city'] ?? 'Hyderabad') ?>" placeholder="Hyderabad">
                  </div>
                  <div class="col-md-4 form-group">
                    <label class="font-weight-bold text-secondary small">State</label>
                    <input type="text" name="state" class="form-control" value="<?= esc($settings['state'] ?? 'Telangana') ?>" placeholder="Telangana">
                  </div>
                  <div class="col-md-4 form-group">
                    <label class="font-weight-bold text-secondary small">Pincode</label>
                    <input type="text" name="pincode" class="form-control" value="<?= esc($settings['pincode'] ?? '500004') ?>" placeholder="500004">
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-4 form-group">
                    <label class="font-weight-bold text-secondary small">Official Email</label>
                    <input type="email" name="email" class="form-control" value="<?= esc($settings['email'] ?? '') ?>" placeholder="hr@bloomsolutions.com">
                  </div>
                  <div class="col-md-4 form-group">
                    <label class="font-weight-bold text-secondary small">Contact Phone</label>
                    <input type="text" name="phone" class="form-control" value="<?= esc($settings['phone'] ?? '') ?>" placeholder="+91 40 1234 5678">
                  </div>
                  <div class="col-md-4 form-group">
                    <label class="font-weight-bold text-secondary small">Official Website</label>
                    <input type="url" name="website" class="form-control" value="<?= esc($settings['website'] ?? '') ?>" placeholder="https://bloomsolutions.com">
                  </div>
                </div>

                <!-- Branding Assets Preview & Upload -->
                <div class="row mt-2 pt-2 border-top">
                  <div class="col-md-6 form-group">
                    <label class="font-weight-bold text-secondary small d-block">Company Logo Image</label>
                    <div class="d-flex align-items-center mb-2">
                      <img src="<?= base_url($settings['logo_url'] ?? 'public/dist/img/bloom.jpg') ?>" alt="Logo" class="img-thumbnail mr-3 shadow-sm" style="height: 52px; width: 52px; object-fit: contain;">
                      <div class="small text-muted">Active Logo: <code><?= esc($settings['logo_url'] ?? 'bloom.jpg') ?></code></div>
                    </div>
                    <input type="file" name="logo_file" class="form-control-file small" accept="image/*">
                    <small class="text-muted d-block mt-1">Recommended size: 200x200px (PNG/JPG)</small>
                  </div>

                  <div class="col-md-6 form-group">
                    <label class="font-weight-bold text-secondary small d-block">Payslip Watermark Image</label>
                    <div class="d-flex align-items-center mb-2">
                      <img src="<?= base_url($settings['watermark_url'] ?? 'public/dist/img/bloom.jpg') ?>" alt="Watermark" class="img-thumbnail mr-3 shadow-sm" style="height: 52px; width: 52px; object-fit: contain; opacity: 0.7;">
                      <div class="small text-muted">Active Watermark: <code><?= esc($settings['watermark_url'] ?? 'bloom.jpg') ?></code></div>
                    </div>
                    <input type="file" name="watermark_file" class="form-control-file small" accept="image/*">
                    <small class="text-muted d-block mt-1">Translucent watermark on payslip background</small>
                  </div>
                </div>

              </div>
            </div>

            <!-- Card 2: Statutory & Registrations -->
            <div class="card card-outline card-info shadow-sm border-0 mb-4" style="border-radius: 12px;">
              <div class="card-header bg-white pt-3 border-bottom-0">
                <h5 class="card-title font-weight-bold text-dark m-0">
                  <i class="fas fa-landmark text-info mr-2"></i> Statutory & Tax Identifiers
                </h5>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6 form-group">
                    <label class="font-weight-bold text-secondary small">Company PAN</label>
                    <input type="text" name="pan_number" class="form-control font-weight-bold" value="<?= esc($settings['pan_number'] ?? '') ?>" placeholder="e.g. AAACB1234F" style="letter-spacing: 1px;">
                  </div>
                  <div class="col-md-6 form-group">
                    <label class="font-weight-bold text-secondary small">Company TAN</label>
                    <input type="text" name="tan_number" class="form-control font-weight-bold" value="<?= esc($settings['tan_number'] ?? '') ?>" placeholder="e.g. HYDB12345A" style="letter-spacing: 1px;">
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6 form-group">
                    <label class="font-weight-bold text-secondary small">GSTIN</label>
                    <input type="text" name="gstin" class="form-control font-weight-bold" value="<?= esc($settings['gstin'] ?? '') ?>" placeholder="e.g. 36AAACB1234F1Z5" style="letter-spacing: 1px;">
                  </div>
                  <div class="col-md-6 form-group">
                    <label class="font-weight-bold text-secondary small">Corporate CIN</label>
                    <input type="text" name="cin" class="form-control font-weight-bold" value="<?= esc($settings['cin'] ?? '') ?>" placeholder="e.g. U72200TG2020PTC123456" style="letter-spacing: 1px;">
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6 form-group">
                    <label class="font-weight-bold text-secondary small">EPF Establishment Code</label>
                    <input type="text" name="pf_establishment_code" class="form-control font-weight-bold" value="<?= esc($settings['pf_establishment_code'] ?? '') ?>" placeholder="e.g. AP/HYD/0012345/000">
                  </div>
                  <div class="col-md-6 form-group">
                    <label class="font-weight-bold text-secondary small">ESIC Registration Code</label>
                    <input type="text" name="esic_code" class="form-control font-weight-bold" value="<?= esc($settings['esic_code'] ?? '') ?>" placeholder="e.g. 52000123450001001">
                  </div>
                </div>
              </div>
            </div>

          </div>

          <!-- Right Column: Payroll Cutoff Rules & Payslip Options -->
          <div class="col-lg-5">

            <!-- Card 3: Payroll Cycle Cutoff Rules -->
            <div class="card card-outline card-success shadow-sm border-0 mb-4" style="border-radius: 12px;">
              <div class="card-header bg-white pt-3 border-bottom-0">
                <h5 class="card-title font-weight-bold text-dark m-0">
                  <i class="fas fa-calendar-alt text-success mr-2"></i> Payroll Cycle & Cut-off Rules
                </h5>
              </div>
              <div class="card-body">
                <p class="small text-muted mb-3">
                  Define the monthly attendance cut-off window. The payroll cycle generator and attendance tally modules use these day settings dynamically.
                </p>

                <div class="row align-items-center">
                  <div class="col-sm-6 form-group">
                    <label class="font-weight-bold text-secondary small">Cycle Start Day <span class="text-danger">*</span></label>
                    <div class="input-group">
                      <input type="number" id="cycleStartDayInput" name="payroll_cycle_start_day" class="form-control font-weight-bold text-center" min="1" max="31" value="<?= (int)($settings['payroll_cycle_start_day'] ?? 25) ?>" required>
                      <div class="input-group-append">
                        <span class="input-group-text small">th</span>
                      </div>
                    </div>
                    <small class="text-muted">Day of previous month</small>
                  </div>

                  <div class="col-sm-6 form-group">
                    <label class="font-weight-bold text-secondary small">Cycle End Day <span class="text-danger">*</span></label>
                    <div class="input-group">
                      <input type="number" id="cycleEndDayInput" name="payroll_cycle_end_day" class="form-control font-weight-bold text-center" min="1" max="31" value="<?= (int)($settings['payroll_cycle_end_day'] ?? 24) ?>" required>
                      <div class="input-group-append">
                        <span class="input-group-text small">th</span>
                      </div>
                    </div>
                    <small class="text-muted">Day of payroll month</small>
                  </div>
                </div>

                <div class="row">
                  <div class="col-sm-6 form-group">
                    <label class="font-weight-bold text-secondary small">Salary Pay Day <span class="text-danger">*</span></label>
                    <div class="input-group">
                      <input type="number" id="payDayInput" name="salary_pay_day" class="form-control font-weight-bold text-center" min="1" max="31" value="<?= (int)($settings['salary_pay_day'] ?? 1) ?>" required>
                      <div class="input-group-append">
                        <span class="input-group-text small">st/th</span>
                      </div>
                    </div>
                    <small class="text-muted">Monthly disbursement date</small>
                  </div>

                  <div class="col-sm-6 form-group">
                    <label class="font-weight-bold text-secondary small">Standard Daily Shift</label>
                    <div class="input-group">
                      <input type="number" step="0.5" name="standard_work_hours_per_day" class="form-control text-center font-weight-bold" min="4" max="24" value="<?= (float)($settings['standard_work_hours_per_day'] ?? 9.00) ?>">
                      <div class="input-group-append">
                        <span class="input-group-text small">hrs</span>
                      </div>
                    </div>
                    <small class="text-muted">Daily working hours base</small>
                  </div>
                </div>

                <!-- Dynamic Cut-off Preview Banner -->
                <div class="p-3 bg-light rounded mt-2 border">
                  <div class="font-weight-bold text-primary mb-1 small">
                    <i class="fas fa-info-circle mr-1"></i> Configured Cycle Example Preview:
                  </div>
                  <div class="text-dark small" id="cyclePreviewText">
                    Attendance Window: <strong>25 Aug</strong> to <strong>24 Sep</strong><br>
                    Salary Disbursed On: <strong>01 Oct</strong>
                  </div>
                </div>

              </div>
            </div>

            <!-- Card 4: Payslip Template Settings -->
            <div class="card card-outline card-warning shadow-sm border-0 mb-4" style="border-radius: 12px;">
              <div class="card-header bg-white pt-3 border-bottom-0">
                <h5 class="card-title font-weight-bold text-dark m-0">
                  <i class="fas fa-file-invoice-dollar text-warning mr-2"></i> Payslip Formatting & Disclaimer
                </h5>
              </div>
              <div class="card-body">
                <div class="form-group">
                  <label class="font-weight-bold text-secondary small">Payslip Reference Number Prefix</label>
                  <input type="text" name="payslip_prefix" class="form-control font-weight-bold" value="<?= esc($settings['payslip_prefix'] ?? 'PS-') ?>" placeholder="PS-">
                  <small class="text-muted">Example output: <code>PS-202610-BS00001</code></small>
                </div>

                <div class="form-group">
                  <label class="font-weight-bold text-secondary small">Authorized Signatory Title</label>
                  <input type="text" name="payslip_signatory_title" class="form-control" value="<?= esc($settings['payslip_signatory_title'] ?? 'Authorized Signatory') ?>" placeholder="Authorized Signatory">
                </div>

                <div class="form-group">
                  <label class="font-weight-bold text-secondary small">Computer-Generated Disclaimer Text</label>
                  <textarea name="payslip_footer_disclaimer" class="form-control" rows="3" placeholder="Disclaimer note shown at the bottom of payslips"><?= esc($settings['payslip_footer_disclaimer'] ?? 'This is a computer-generated statement, and does not require a signature and stamp.') ?></textarea>
                  <small class="text-muted">Displayed with green verified badge at the bottom of official employee payslips.</small>
                </div>
              </div>
            </div>

            <!-- Submission Button Card -->
            <div class="card bg-white shadow-sm border-0 p-3 text-right" style="border-radius: 12px;">
              <div>
                <a href="<?= base_url('admin/payroll') ?>" class="btn btn-outline-secondary font-weight-bold mr-2">Cancel</a>
                <button type="submit" class="btn btn-primary font-weight-bold px-4 shadow-sm" style="background: #4a00e0; border-color: #4a00e0;">
                  <i class="fas fa-save mr-2"></i> Save Company Settings
                </button>
              </div>
            </div>

          </div>

        </div>
      </form>

    </div>
  </section>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const startInput = document.getElementById('cycleStartDayInput');
    const endInput   = document.getElementById('cycleEndDayInput');
    const payInput   = document.getElementById('payDayInput');
    const previewEl  = document.getElementById('cyclePreviewText');

    function updatePreview() {
      const s = parseInt(startInput.value) || 25;
      const e = parseInt(endInput.value) || 24;
      const p = parseInt(payInput.value) || 1;

      previewEl.innerHTML = `Attendance Window: <strong>${s}th of previous month</strong> to <strong>${e}th of payroll month</strong><br>` +
                            `Scheduled Pay Date: <strong>${p}st/th of payout month</strong>`;
    }

    startInput.addEventListener('input', updatePreview);
    endInput.addEventListener('input', updatePreview);
    payInput.addEventListener('input', updatePreview);
    updatePreview();
  });
</script>
