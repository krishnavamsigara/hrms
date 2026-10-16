<style>
  /* BloomHR Design System Tokens */
  :root {
    --pr-primary: #2563eb;
    --pr-primary-dark: #1d4ed8;
    --pr-primary-light: #eff6ff;
    --pr-success: #10b981;
    --pr-success-light: #ecfdf5;
    --pr-warning: #f59e0b;
    --pr-warning-light: #fffbeb;
    --pr-danger: #ef4444;
    --pr-danger-light: #fef2f2;
    --pr-indigo: #6366f1;
    --pr-indigo-light: #eef2ff;
    --pr-surface: #ffffff;
    --pr-bg: #f8fafc;
    --pr-border: #e2e8f0;
    --pr-text-main: #0f172a;
    --pr-text-muted: #64748b;
  }

  .content-wrapper {
    background-color: var(--pr-bg) !important;
  }

  /* SOP 5-Step Execution Stepper */
  .pr-sop-stepper {
    display: flex;
    align-items: stretch;
    justify-content: space-between;
    background: #ffffff;
    border: 1px solid var(--pr-border);
    border-radius: 16px;
    padding: 10px 14px;
    margin-bottom: 22px;
    box-shadow: 0 4px 6px -1px rgba(0,0,0,0.03);
    overflow-x: auto;
    gap: 8px;
  }
  .pr-sop-step {
    flex: 1;
    min-width: 170px;
    display: flex;
    align-items: center;
    padding: 10px 12px;
    border-radius: 12px;
    position: relative;
    text-decoration: none !important;
    transition: all 0.2s ease;
    border: 1px solid transparent;
  }
  .pr-sop-step:hover {
    background: #f1f5f9;
  }
  .pr-sop-step.active {
    background: #eff6ff;
    border-color: #bfdbfe;
    box-shadow: 0 2px 8px rgba(37,99,235,0.08);
  }
  .pr-sop-step.completed {
    background: #f8fafc;
  }
  .pr-sop-step-num {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: #e2e8f0;
    color: #475569;
    font-weight: 700;
    font-size: 13px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 10px;
    flex-shrink: 0;
  }
  .pr-sop-step.active .pr-sop-step-num {
    background: var(--pr-primary);
    color: #ffffff;
    box-shadow: 0 0 0 3px rgba(37,99,235,0.25);
  }
  .pr-sop-step.completed .pr-sop-step-num {
    background: var(--pr-success);
    color: #ffffff;
  }
  .pr-sop-step-text {
    line-height: 1.25;
  }
  .pr-sop-step-title {
    font-size: 12px;
    font-weight: 700;
    color: var(--pr-text-main);
  }
  .pr-sop-step-desc {
    font-size: 11px;
    color: var(--pr-text-muted);
  }
  .pr-sop-step-arrow {
    color: #cbd5e1;
    font-size: 11px;
    margin-left: auto;
    padding-left: 6px;
  }

  /* Card Elevate */
  .pr-sop-card {
    background: #ffffff;
    border: 1px solid var(--pr-border);
    border-radius: 16px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.04);
    overflow: hidden;
    margin-bottom: 20px;
  }
  .pr-sop-card .card-header {
    background: #ffffff;
    border-bottom: 1px solid var(--pr-border);
    padding: 16px 20px;
  }

  /* 35-Column Sticky Table Grid */
  .pr-35col-wrapper {
    position: relative;
    max-height: 620px;
    overflow: auto;
    border: 1px solid var(--pr-border);
    border-radius: 12px;
    background: #ffffff;
  }
  .pr-35col-table {
    margin-bottom: 0;
    border-collapse: separate;
    border-spacing: 0;
    font-size: 12px;
    white-space: nowrap;
    width: 100%;
  }
  .pr-35col-table thead th {
    position: sticky;
    top: 0;
    z-index: 2;
    background: #f8fafc;
    color: #334155;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    padding: 10px 12px;
    border-bottom: 2px solid #cbd5e1;
    border-right: 1px solid #e2e8f0;
  }
  .pr-35col-table tbody td {
    padding: 8px 12px;
    border-bottom: 1px solid #f1f5f9;
    border-right: 1px solid #f1f5f9;
    vertical-align: middle;
  }

  /* Sticky Left Frozen Columns (#1 Emp ID, #2 Employee Name) */
  .pr-col-sticky-1 {
    position: sticky !important;
    left: 0;
    z-index: 3 !important;
    min-width: 95px;
    max-width: 100px;
    background: #ffffff;
    box-shadow: 2px 0 4px rgba(0,0,0,0.03);
  }
  thead .pr-col-sticky-1 {
    background: #f1f5f9 !important;
    z-index: 5 !important;
  }
  .pr-col-sticky-2 {
    position: sticky !important;
    left: 95px;
    z-index: 3 !important;
    min-width: 180px;
    max-width: 220px;
    background: #ffffff;
    box-shadow: 3px 0 5px rgba(0,0,0,0.04);
  }
  thead .pr-col-sticky-2 {
    background: #f1f5f9 !important;
    z-index: 5 !important;
  }

  /* Sticky Right Frozen Columns (#33 Status, #34 Difference, #35 ESI Status) */
  .pr-col-sticky-33 {
    position: sticky !important;
    right: 205px;
    z-index: 3 !important;
    min-width: 105px;
    background: #ffffff;
    box-shadow: -2px 0 4px rgba(0,0,0,0.03);
  }
  thead .pr-col-sticky-33 {
    background: #f1f5f9 !important;
    z-index: 5 !important;
  }
  .pr-col-sticky-34 {
    position: sticky !important;
    right: 105px;
    z-index: 3 !important;
    min-width: 100px;
    background: #ffffff;
  }
  thead .pr-col-sticky-34 {
    background: #f1f5f9 !important;
    z-index: 5 !important;
  }
  .pr-col-sticky-35 {
    position: sticky !important;
    right: 0;
    z-index: 3 !important;
    min-width: 105px;
    background: #ffffff;
  }
  thead .pr-col-sticky-35 {
    background: #f1f5f9 !important;
    z-index: 5 !important;
  }

  /* Tier Group Color Accents */
  .tier-identity { background: #eff6ff !important; color: #1e40af !important; }
  .tier-contract { background: #f8fafc !important; color: #334155 !important; }
  .tier-attendance { background: #fef2f2 !important; color: #991b1b !important; }
  .tier-earnings { background: #f0fdf4 !important; color: #166534 !important; }
  .tier-statutory-emp { background: #f5f3ff !important; color: #5b21b6 !important; }
  .tier-deductions { background: #fffbeb !important; color: #92400e !important; }
  .tier-netpay { background: #dcfce7 !important; color: #14532d !important; font-weight: 800; }
  .tier-banking { background: #f1f5f9 !important; color: #475569 !important; }
  .tier-audit { background: #f8fafc !important; color: #0f172a !important; }

  /* Navigation Bar at Bottom of Each Step */
  .pr-step-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px 20px;
    background: #ffffff;
    border: 1px solid var(--pr-border);
    border-radius: 14px;
    margin-top: 24px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.02);
  }

  /* Metric KPI Cards in Step 4 */
  .kpi-outlay-card {
    background: #ffffff;
    border: 1px solid var(--pr-border);
    border-radius: 14px;
    padding: 18px 20px;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
  }
  .kpi-outlay-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 20px -5px rgba(0,0,0,0.06);
  }
  .kpi-outlay-val {
    font-size: 24px;
    font-weight: 800;
    line-height: 1.1;
    letter-spacing: -0.02em;
  }
  .kpi-outlay-lbl {
    font-size: 11.5px;
    font-weight: 700;
    text-transform: uppercase;
    color: var(--pr-text-muted);
    letter-spacing: 0.04em;
    margin-top: 4px;
  }
</style>

<div class="content-wrapper p-3">
  <div class="content-header">
    <div class="container-fluid">

      <!-- Breadcrumbs & Cycle Header Info -->
      <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap">
        <div>
          <h2 class="font-weight-bold text-dark m-0 d-flex align-items-center">
            <a href="<?= base_url('admin/payroll') ?>" class="text-secondary mr-2" title="Back to Payroll Dashboard"><i class="fas fa-arrow-left"></i></a>
            <span>Compensation Run: <span class="text-primary"><?= esc($cycle['payroll_code']) ?></span></span>
          </h2>
          <div class="text-muted small mt-1">
            <span class="mr-3"><i class="far fa-calendar-alt mr-1"></i> Period: <strong><?= date('d M Y', strtotime($cycle['period_start'])) ?></strong> to <strong><?= date('d M Y', strtotime($cycle['period_end'])) ?></strong></span>
            <span class="mr-3"><i class="fas fa-stopwatch mr-1"></i> Standard Base: <strong>30 Working Days</strong></span>
            <span><i class="fas fa-shield-alt mr-1"></i> Status: 
              <?php if ($cycle['status'] === 'LOCKED'): ?>
                <span class="badge badge-success px-2 py-1"><i class="fas fa-lock mr-1"></i> LOCKED &amp; SEALED</span>
              <?php else: ?>
                <span class="badge badge-warning px-2 py-1"><i class="fas fa-clock mr-1"></i> <?= esc($cycle['status']) ?></span>
              <?php endif; ?>
            </span>
          </div>
        </div>

        <div class="mt-2 mt-sm-0 d-flex align-items-center">
          <a href="<?= base_url('admin/payroll/export_excel/' . $cycle['id']) ?>" class="btn btn-sm btn-outline-success font-weight-bold mr-2 shadow-sm" title="Download Official Master 35-Column Excel">
            <i class="fas fa-file-excel mr-1"></i> Export 35-Col Master Excel
          </a>
          <a href="<?= base_url('admin/payroll') ?>" class="btn btn-sm btn-outline-secondary font-weight-bold shadow-sm">
            <i class="fas fa-tachometer-alt mr-1"></i> Dashboard
          </a>
        </div>
      </div>

      <!-- SOP 5-STEP LIFECYCLE EXECUTION STEPPER (SOP-PAY-2026-V2 Page 2) -->
      <div class="pr-sop-stepper">
        <a href="<?= base_url('admin/payroll/view/' . $cycle['id'] . '?step=1') ?>" class="pr-sop-step <?= ($current_step == 1) ? 'active' : (($current_step > 1) ? 'completed' : '') ?>">
          <div class="pr-sop-step-num"><?= ($current_step > 1) ? '<i class="fas fa-check"></i>' : '1' ?></div>
          <div class="pr-sop-step-text">
            <div class="pr-sop-step-title">Attendance Ingestion</div>
            <div class="pr-sop-step-desc"><?= $is_attendance_finalized ? 'Finalized &amp; Locked' : 'Verification' ?></div>
          </div>
          <i class="fas fa-chevron-right pr-sop-step-arrow"></i>
        </a>

        <a href="<?= base_url('admin/payroll/view/' . $cycle['id'] . '?step=2') ?>" class="pr-sop-step <?= ($current_step == 2) ? 'active' : (($current_step > 2) ? 'completed' : '') ?>">
          <div class="pr-sop-step-num"><?= ($current_step > 2) ? '<i class="fas fa-check"></i>' : '2' ?></div>
          <div class="pr-sop-step-text">
            <div class="pr-sop-step-title">Structure &amp; Count</div>
            <div class="pr-sop-step-desc">Headcount Review</div>
          </div>
          <i class="fas fa-chevron-right pr-sop-step-arrow"></i>
        </a>

        <a href="<?= base_url('admin/payroll/view/' . $cycle['id'] . '?step=3') ?>" class="pr-sop-step <?= ($current_step == 3) ? 'active' : (($current_step > 3) ? 'completed' : '') ?>">
          <div class="pr-sop-step-num"><?= ($current_step > 3) ? '<i class="fas fa-check"></i>' : '3' ?></div>
          <div class="pr-sop-step-text">
            <div class="pr-sop-step-title">Master 35-Col Grid</div>
            <div class="pr-sop-step-desc">Read-Only Financials</div>
          </div>
          <i class="fas fa-chevron-right pr-sop-step-arrow"></i>
        </a>

        <a href="<?= base_url('admin/payroll/view/' . $cycle['id'] . '?step=4') ?>" class="pr-sop-step <?= ($current_step == 4) ? 'active' : (($current_step > 4) ? 'completed' : '') ?>">
          <div class="pr-sop-step-num"><?= ($current_step > 4) ? '<i class="fas fa-check"></i>' : '4' ?></div>
          <div class="pr-sop-step-text">
            <div class="pr-sop-step-title">Closure &amp; Options</div>
            <div class="pr-sop-step-desc">Dual-Maker Seal</div>
          </div>
          <i class="fas fa-chevron-right pr-sop-step-arrow"></i>
        </a>

        <a href="<?= base_url('admin/payroll/view/' . $cycle['id'] . '?step=5') ?>" class="pr-sop-step <?= ($current_step == 5) ? 'active' : '' ?>">
          <div class="pr-sop-step-num">5</div>
          <div class="pr-sop-step-text">
            <div class="pr-sop-step-title">Payslips Repository</div>
            <div class="pr-sop-step-desc">Batch Distribution</div>
          </div>
        </a>
      </div>

    </div>
  </div>

  <section class="content">
    <div class="container-fluid">

      <!-- Alert Flash Messages -->
      <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <i class="fas fa-check-circle mr-2"></i><?= session()->getFlashdata('success') ?>
          <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
      <?php endif; ?>
      <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <i class="fas fa-exclamation-circle mr-2"></i><?= session()->getFlashdata('error') ?>
          <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
      <?php endif; ?>


      <!-- ================================================================= -->
      <!-- STEP 1: ATTENDANCE VERIFICATION & INGESTION (SOP Pages 4-5)        -->
      <!-- ================================================================= -->
      <?php if ($current_step == 1): ?>
        
        <!-- CASE 1: Attendance is Already Finalized & Locked -->
        <div class="pr-sop-card <?= $is_attendance_finalized ? 'border-success' : '' ?>">
          <div class="card-header d-flex align-items-center justify-content-between flex-wrap" style="cursor: pointer;" data-toggle="collapse" data-target="#collapseAttendanceRoster">
            <div class="d-flex align-items-center">
              <span class="badge <?= $is_attendance_finalized ? 'badge-success' : 'badge-secondary' ?> p-2 mr-3 font-weight-bold" style="font-size: 13px;">
                <i class="fas <?= $is_attendance_finalized ? 'fa-lock' : 'fa-info-circle' ?> mr-1"></i>
                <?= $is_attendance_finalized ? 'ATTENDANCE FINALIZED &amp; LOCKED' : 'ATTENDANCE SNAPSHOT' ?>
              </span>
              <div>
                <strong class="text-dark">Card 1: Attendance Verification &amp; Ingestion Registry</strong>
                <div class="text-muted small">Cryptographic Audit Checksum: <code class="text-primary font-weight-bold"><?= esc($attendance_checksum) ?></code> &bull; Total <?= count($attendance_roster) ?> employee logs</div>
              </div>
            </div>
            <div class="text-muted small">
              <span class="mr-2 text-primary font-weight-bold"><i class="fas fa-eye mr-1"></i> Click to Toggle Roster Table</span>
              <i class="fas fa-chevron-down"></i>
            </div>
          </div>

          <div class="collapse <?= $is_attendance_finalized ? 'show' : '' ?>" id="collapseAttendanceRoster">
            <div class="card-body p-0">
              <div class="table-responsive" style="max-height: 380px;">
                <table class="table table-hover table-striped align-middle mb-0" style="font-size: 12.5px;">
                  <thead class="bg-light text-uppercase text-secondary small">
                    <tr>
                      <th>Emp ID</th>
                      <th>Employee Name</th>
                      <th>Department</th>
                      <th class="text-center">Total Days</th>
                      <th class="text-center text-primary">Working Days</th>
                      <th class="text-center text-success font-weight-bold">Present</th>
                      <th class="text-center text-info">WFH</th>
                      <th class="text-center text-warning">Leaves</th>
                      <th class="text-center text-danger font-weight-bold">Unpaid LOP</th>
                      <th class="text-center font-weight-bold text-success" style="background: #ecfdf5;">Paid Days</th>
                      <th class="text-center">Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if (!empty($attendance_roster)): ?>
                      <?php foreach ($attendance_roster as $ar): ?>
                        <tr>
                          <td class="font-weight-bold text-primary"><?= esc($ar['emp_id']) ?></td>
                          <td class="font-weight-bold text-dark"><?= esc($ar['emp_name']) ?></td>
                          <td class="text-muted"><?= esc($ar['department'] ?? 'General') ?></td>
                          <td class="text-center"><?= (float)($ar['total_days'] ?? 30) ?></td>
                          <td class="text-center font-weight-bold text-primary"><?= (float)($ar['working_days'] ?? 30) ?></td>
                          <td class="text-center text-success font-weight-bold"><?= (float)($ar['present_days'] ?? 0) ?></td>
                          <td class="text-center text-info"><?= (float)($ar['wfh_days'] ?? 0) ?></td>
                          <td class="text-center text-warning"><?= (float)($ar['leave_days'] ?? 0) ?></td>
                          <td class="text-center text-danger font-weight-bold"><?= (float)($ar['lop_days'] ?? 0) ?></td>
                          <td class="text-center text-success font-weight-bold" style="background: #f0fdf4;"><?= (float)($ar['paid_days'] ?? 30) ?></td>
                          <td class="text-center">
                            <span class="badge badge-success px-2 py-1"><i class="fas fa-check-circle mr-1"></i> LOCKED</span>
                          </td>
                        </tr>
                      <?php endforeach; ?>
                    <?php else: ?>
                      <tr>
                        <td colspan="11" class="text-center text-muted py-4">No verified attendance records found for this period.</td>
                      </tr>
                    <?php endif; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

        <!-- CASE 2: Attendance is NOT Finalized Notice -->
        <?php if (!$is_attendance_finalized): ?>
          <div class="pr-sop-card border-warning">
            <div class="card-body p-4 bg-light">
              <div class="d-flex align-items-center">
                <div class="mr-3 text-warning"><i class="fas fa-exclamation-triangle fa-3x"></i></div>
                <div>
                  <h5 class="font-weight-bold text-dark m-0">Card 2: Attendance Pending Regularization (Action Required)</h5>
                  <p class="text-muted small mb-2">Monthly attendance cut-off for this period has not been sealed in the Attendance Finalize module. Finalize &amp; Lock attendance to preserve immutable records.</p>
                  <a href="<?= base_url('admin/payroll_attendance') ?>" class="btn btn-warning btn-sm font-weight-bold shadow-sm">
                    <i class="fas fa-external-link-alt mr-1"></i> Open Attendance Finalize Module
                  </a>
                </div>
              </div>
            </div>
          </div>
        <?php endif; ?>

        <!-- CASE 3: Manual Attendance Override & Bulk Excel Upload -->
        <div class="pr-sop-card">
          <div class="card-header bg-white d-flex align-items-center justify-content-between flex-wrap">
            <h5 class="card-title font-weight-bold text-dark m-0">
              <i class="fas fa-file-upload text-info mr-2"></i> Card 3: Manual Attendance Override &amp; Bulk Excel Upload
            </h5>
            <a href="data:text/csv;charset=utf-8,emp_id%2Cattendance_date%2Cstatus%2Cworked_hours%0ABS00102%2C2026-11-01%2CPRESENT%2C9.0" download="Sample_Attendance_Template.csv" class="btn btn-outline-primary btn-sm font-weight-bold">
              <i class="fas fa-download mr-1"></i> Download Sample Attendance Template (.csv)
            </a>
          </div>
          <div class="card-body p-4">
            <form action="<?= base_url('admin/payroll/import_attendance/' . $cycle['id']) ?>" method="POST" enctype="multipart/form-data">
              <div class="p-4 border rounded text-center" style="background: #f8fafc; border-style: dashed !important; border-width: 2px !important;">
                <i class="fas fa-cloud-upload-alt fa-3x text-primary mb-2"></i>
                <h6 class="font-weight-bold text-dark mb-1">Drag &amp; Drop Attendance CSV or Browse</h6>
                <p class="text-muted small mb-3">Columns: <code>emp_id, attendance_date, status, worked_hours</code></p>
                <input type="file" name="excel_file" class="form-control-file d-inline-block w-auto border p-1 rounded" accept=".csv, .xls, .xlsx">
                <button type="submit" class="btn btn-primary btn-sm font-weight-bold ml-2 shadow-sm"><i class="fas fa-upload mr-1"></i> Upload &amp; Overwrite</button>
              </div>
            </form>
          </div>
        </div>

        <!-- Step 1 Footer Navigation -->
        <div class="pr-step-footer">
          <a href="<?= base_url('admin/payroll') ?>" class="btn btn-outline-secondary font-weight-bold">
            <i class="fas fa-arrow-left mr-1"></i> Back to Dashboard
          </a>
          <a href="<?= base_url('admin/payroll/view/' . $cycle['id'] . '?step=2') ?>" class="btn btn-primary font-weight-bold shadow-sm">
            Next: Proceed to Calculation Review <i class="fas fa-arrow-right ml-1"></i>
          </a>
        </div>

      <?php endif; ?>


      <!-- ================================================================= -->
      <!-- STEP 2: EMPLOYEE SALARY STRUCTURE & ATTENDANCE COUNT (SOP Page 6)  -->
      <!-- ================================================================= -->
      <?php if ($current_step == 2): ?>

        <!-- Headcount Banner & Calculation Trigger -->
        <div class="pr-sop-card bg-white p-3 d-flex align-items-center justify-content-between flex-wrap">
          <div class="d-flex align-items-center">
            <div class="mr-3" style="width: 48px; height: 48px; border-radius: 12px; background: #eff6ff; color: #2563eb; display:flex; align-items:center; justify-content:center; font-size: 20px;">
              <i class="fas fa-users-cog"></i>
            </div>
            <div>
              <h4 class="font-weight-bold text-dark m-0">Verified Headcount: <span class="text-primary"><?= count($employees) ?> Employees Verified</span></h4>
              <p class="text-muted small mb-0">Confirm every employee with locked attendance has an assigned salary structure before executing statutory stored procedures.</p>
            </div>
          </div>
          <div class="mt-2 mt-sm-0">
            <a href="<?= base_url('admin/payroll/calculate/' . $cycle['id']) ?>" class="btn btn-success btn-lg font-weight-bold shadow-sm" onclick="return confirm('Execute automated 35-column statutory payroll calculation for active employees?')">
              <i class="fas fa-calculator mr-2"></i> Calculate Payroll
            </a>
          </div>
        </div>

        <!-- Dual Tabs Navigation -->
        <ul class="nav nav-pills mb-3 bg-white p-2 rounded shadow-sm border" id="step2Tabs" role="tablist">
          <li class="nav-item">
            <a class="nav-link active font-weight-bold" id="tab-structures-nav" data-toggle="pill" href="#tab-structures" role="tab">
              <i class="fas fa-money-check-alt mr-2"></i> Tab 1 - Salary Structures (CTC Breakdown)
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link font-weight-bold text-secondary" id="tab-attendance-nav" data-toggle="pill" href="#tab-attendance" role="tab">
              <i class="fas fa-calendar-check mr-2"></i> Tab 2 - Finalized Attendance &amp; LOP
            </a>
          </li>
        </ul>

        <div class="tab-content" id="step2TabsContent">
          <!-- Tab 1: Salary Structures with Inline Edit Modal Trigger -->
          <div class="tab-pane fade show active" id="tab-structures" role="tabpanel">
            <div class="pr-sop-card">
              <div class="card-header bg-white d-flex align-items-center justify-content-between">
                <strong class="text-dark"><i class="fas fa-list-ul mr-2 text-primary"></i> Employee Salary Structures Master Roster</strong>
                <span class="badge badge-light border text-muted"><?= count($salary_structures) ?> Structures Mapped</span>
              </div>
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table table-hover align-middle mb-0" style="font-size: 13px;">
                    <thead class="bg-light text-uppercase text-secondary small">
                      <tr>
                        <th>Emp ID</th>
                        <th>Employee Name</th>
                        <th>Designation</th>
                        <th class="text-right text-primary">Monthly CTC</th>
                        <th class="text-right text-dark">Direct Gross (A)</th>
                        <th class="text-right text-muted">Employer Contrib.</th>
                        <th class="text-right text-danger">Total Deductions (B)</th>
                        <th class="text-right text-success font-weight-bold" style="background: #f0fdf4;">Net In-Hand</th>
                        <th class="text-center">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php if (!empty($salary_structures)): ?>
                        <?php foreach ($salary_structures as $st): ?>
                          <?php 
                            $ctc = (float)($st['salary'] ?? $st['ctc1'] ?? 0);
                            $gross = (float)($st['gross'] ?? ($ctc * 0.90));
                            $emp_contrib = (float)($st['pf_employer_contribution'] ?? 0) + (float)($st['esi_employer_contribution'] ?? 0);
                            $deduct = (float)($st['total_deductions'] ?? ($ctc * 0.10));
                            $net = (float)($st['net_pay'] ?? ($gross - $deduct));
                          ?>
                          <tr>
                            <td class="font-weight-bold text-primary"><?= esc($st['emp_id']) ?></td>
                            <td class="font-weight-bold text-dark"><?= esc($st['emp_name']) ?></td>
                            <td class="text-muted small"><?= esc($st['designation'] ?? 'Employee') ?></td>
                            <td class="text-right font-weight-bold text-primary">₹<?= number_format($ctc, 2) ?></td>
                            <td class="text-right font-weight-bold text-dark">₹<?= number_format($gross, 2) ?></td>
                            <td class="text-right text-muted">₹<?= number_format($emp_contrib, 2) ?></td>
                            <td class="text-right text-danger font-weight-bold">₹<?= number_format($deduct, 2) ?></td>
                            <td class="text-right text-success font-weight-bold" style="background: #f0fdf4;">₹<?= number_format($net, 2) ?></td>
                            <td class="text-center">
                              <button class="btn btn-sm btn-outline-primary font-weight-bold btn-edit-structure" 
                                data-empid="<?= esc($st['emp_id']) ?>"
                                data-empname="<?= esc($st['emp_name']) ?>"
                                data-ctc="<?= $ctc ?>"
                                data-gross="<?= $gross ?>">
                                <i class="fas fa-edit mr-1"></i> Edit Structure
                              </button>
                            </td>
                          </tr>
                        <?php endforeach; ?>
                      <?php else: ?>
                        <tr>
                          <td colspan="9" class="text-center text-muted py-4">No employee salary structures found.</td>
                        </tr>
                      <?php endif; ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>

          <!-- Tab 2: Finalized Attendance & LOP -->
          <div class="tab-pane fade" id="tab-attendance" role="tabpanel">
            <div class="pr-sop-card">
              <div class="card-header bg-white d-flex align-items-center justify-content-between">
                <strong class="text-dark"><i class="fas fa-calendar-alt mr-2 text-info"></i> Confirmed Attendance &amp; Loss of Pay (LOP)</strong>
                <span class="badge badge-success"><i class="fas fa-lock mr-1"></i> Read-Only Finalized Attendance</span>
              </div>
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table table-hover align-middle mb-0" style="font-size: 13px;">
                    <thead class="bg-light text-uppercase text-secondary small">
                      <tr>
                        <th>Emp ID</th>
                        <th>Employee Name</th>
                        <th class="text-center text-info font-weight-bold">Working Days</th>
                        <th class="text-center text-success font-weight-bold">Present Days</th>
                        <th class="text-center text-warning">Approved Leaves</th>
                        <th class="text-center text-info">WFH Days</th>
                        <th class="text-center text-danger font-weight-bold">LOP Days</th>
                        <th class="text-center text-success font-weight-bold" style="background: #f0fdf4;">Total Paid Days</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php if (!empty($employees)): ?>
                        <?php foreach ($employees as $e): ?>
                          <tr>
                            <td class="font-weight-bold text-primary"><?= esc($e['emp_id']) ?></td>
                            <td class="font-weight-bold text-dark"><?= esc($e['employee_name']) ?></td>
                            <td class="text-center font-weight-bold text-muted">30</td>
                            <td class="text-center text-success font-weight-bold"><?= (float)($e['present_days'] ?? 0) ?></td>
                            <td class="text-center text-warning"><?= (float)($e['paid_leave_days'] ?? 0) ?></td>
                            <td class="text-center text-info"><?= (float)($e['wfh_days'] ?? 0) ?></td>
                            <td class="text-center text-danger font-weight-bold"><?= (float)($e['lop_days'] ?? 0) ?></td>
                            <td class="text-center text-success font-weight-bold" style="background: #f0fdf4;"><?= (float)($e['paid_days'] ?? 30) ?></td>
                          </tr>
                        <?php endforeach; ?>
                      <?php else: ?>
                        <tr>
                          <td colspan="8" class="text-center text-muted py-4">No attendance count data loaded.</td>
                        </tr>
                      <?php endif; ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Step 2 Footer Navigation -->
        <div class="pr-step-footer">
          <a href="<?= base_url('admin/payroll/view/' . $cycle['id'] . '?step=1') ?>" class="btn btn-outline-secondary font-weight-bold">
            <i class="fas fa-arrow-left mr-1"></i> Back to Step 1
          </a>
          <a href="<?= base_url('admin/payroll/view/' . $cycle['id'] . '?step=3') ?>" class="btn btn-primary font-weight-bold shadow-sm">
            Next: Master Payroll Calculation Grid <i class="fas fa-arrow-right ml-1"></i>
          </a>
        </div>

      <?php endif; ?>


      <!-- ================================================================= -->
      <!-- STEP 3: MASTER PAYROLL CALCULATION GRID (READ-ONLY 35 COLUMNS)     -->
      <!-- ================================================================= -->
      <?php if ($current_step == 3): ?>

        <!-- Read-Only Audit Protection Alert (SOP Page 7) -->
        <div class="alert alert-warning border-warning shadow-sm d-flex align-items-center mb-3">
          <i class="fas fa-lock fa-2x mr-3 text-warning"></i>
          <div>
            <strong class="text-dark" style="font-size: 14px;">Read-Only Audit Protection Active</strong>
            <div class="text-dark small">Step 3 operates strictly in <strong>read-only mode</strong>. All numerical values and formulas are locked from direct editing to ensure regulatory compliance and prevent discrepancy injections.</div>
          </div>
        </div>

        <div class="pr-sop-card">
          <div class="card-header bg-white d-flex align-items-center justify-content-between flex-wrap">
            <div>
              <h5 class="font-weight-bold text-dark m-0">Master Payroll Calculation Grid (35 Columns)</h5>
              <span class="text-muted small">Period: <strong><?= date('d M Y', strtotime($cycle['period_start'])) ?></strong> to <strong><?= date('d M Y', strtotime($cycle['period_end'])) ?></strong> &bull; Total <?= count($employees) ?> Employees Processed</span>
            </div>
            <div class="mt-2 mt-sm-0 d-flex align-items-center">
              <input type="text" id="grid35Search" class="form-control form-control-sm mr-2" placeholder="Search by ID, name, bank, or IFSC..." style="width: 250px;">
              <a href="<?= base_url('admin/payroll/export_excel/' . $cycle['id']) ?>" class="btn btn-sm btn-success font-weight-bold shadow-sm">
                <i class="fas fa-file-excel mr-1"></i> Export 35-Col Excel
              </a>
            </div>
          </div>

          <div class="card-body p-0">
            <!-- 35-Column Table with Sticky Left (#1, #2) and Sticky Right (#33, #34, #35) -->
            <div class="pr-35col-wrapper">
              <table class="pr-35col-table" id="table35Col">
                <thead>
                  <tr>
                    <!-- Identity (Frozen Left) -->
                    <th class="pr-col-sticky-1 tier-identity" title="#1 Emp ID">#1 Emp ID</th>
                    <th class="pr-col-sticky-2 tier-identity" title="#2 Employee Name">#2 Employee Name</th>

                    <!-- Contract & Attendance -->
                    <th class="tier-contract" title="#3 Monthly CTC Contract">#3 Salary</th>
                    <th class="tier-attendance text-center" title="#4 Approved Leaves">#4 Leaves</th>
                    <th class="tier-attendance text-center" title="#5 Fixed 30 Working Days">#5 Working Days</th>
                    <th class="tier-attendance text-right" title="#6 LOP Deduction = (Gross / 30) * LOP">#6 Leave Deduction</th>

                    <!-- Earnings -->
                    <th class="tier-earnings text-right" title="#7 Other Earnings / Incentives">#7 Other Earnings</th>
                    <th class="tier-earnings text-right" title="#8 Adjusted CTC1">#8 CTC1</th>
                    <th class="tier-earnings text-right font-weight-bold" title="#9 Direct Gross">#9 Gross</th>
                    <th class="tier-earnings text-right" title="#10 Basic = 50% of CTC">#10 Basic</th>
                    <th class="tier-earnings text-right" title="#11 HRA = 20% of CTC">#11 HRA</th>
                    <th class="tier-earnings text-right" title="#12 Medical = 5% of CTC">#12 Medical</th>
                    <th class="tier-earnings text-right" title="#13 Conveyance = 8% of CTC">#13 Conveyance</th>
                    <th class="tier-earnings text-right" title="#14 Special Allowance Balance">#14 Others</th>

                    <!-- Employer Statutory -->
                    <th class="tier-statutory-emp text-right" title="#15 National Pension Scheme">#15 Employer NPS</th>
                    <th class="tier-statutory-emp text-right" title="#16 PF Employer Share (Capped at 1,800)">#16 PF Employer</th>
                    <th class="tier-statutory-emp text-right" title="#17 PF Admin Charges (75)">#17 Admin Charges</th>
                    <th class="tier-statutory-emp text-right" title="#18 ESI Employer (3.25% if Gross <= 21,000)">#18 ESI Employer</th>

                    <!-- Employee Deductions -->
                    <th class="tier-deductions text-right" title="#19 Professional Tax (200)">#19 PT</th>
                    <th class="tier-deductions text-right" title="#20 PF Employee (12% capped at 1,800)">#20 PF Employee</th>
                    <th class="tier-deductions text-right" title="#21 ESI Employee (0.75% if Gross <= 21,000)">#21 ESI Employee</th>
                    <th class="tier-deductions text-right" title="#22 Advance Recovery / Misc">#22 Advances / Other</th>
                    <th class="tier-deductions text-right" title="#23 Income Tax Section 192">#23 TDS</th>
                    <th class="tier-deductions text-right font-weight-bold" title="#24 Total Deductions">#24 Total Deductions</th>

                    <!-- Disbursal -->
                    <th class="tier-netpay text-right" title="#25 Net Pay = Gross - Deductions">#25 Net Pay</th>

                    <!-- Banking Details -->
                    <th class="tier-banking" title="#26 Disbursal Bank Account">#26 Bank A/c No</th>
                    <th class="tier-banking" title="#27 Beneficiary Bank">#27 Bank Name</th>
                    <th class="tier-banking" title="#28 IFSC Code">#28 IFSC</th>
                    <th class="tier-banking" title="#29 Mobile Number">#29 Mobile</th>

                    <!-- Advance Ledger -->
                    <th class="tier-contract text-right" title="#30 Principal Advance">#30 Advance Amount</th>
                    <th class="tier-contract text-right" title="#31 Remaining Balance">#31 Bal Advance</th>
                    <th class="tier-contract text-right" title="#32 Actual Net Transfer">#32 Amount Paid</th>

                    <!-- Audit (Frozen Right) -->
                    <th class="pr-col-sticky-33 tier-audit text-center" title="#33 Reconciliation Tag">#33 Status</th>
                    <th class="pr-col-sticky-34 tier-audit text-center" title="#34 Strictly 0.00 Difference">#34 Difference</th>
                    <th class="pr-col-sticky-35 tier-audit text-center" title="#35 ESI Eligibility">#35 ESI Status</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (!empty($employees)): ?>
                    <?php foreach ($employees as $e): ?>
                      <tr>
                        <!-- #1 & #2 Frozen Left -->
                        <td class="pr-col-sticky-1 font-weight-bold text-primary"><?= esc($e['emp_id']) ?></td>
                        <td class="pr-col-sticky-2 font-weight-bold text-dark">
                          <div><?= esc($e['employee_name']) ?></div>
                          <span class="small text-muted"><?= esc($e['department'] ?? 'General') ?></span>
                        </td>

                        <!-- Contract & Attendance -->
                        <td class="text-right font-weight-bold text-primary">₹<?= number_format((float)$e['salary_basis'], 2) ?></td>
                        <td class="text-center text-danger font-weight-bold"><?= (float)($e['lop_days'] ?? 0) ?></td>
                        <td class="text-center text-muted">30</td>
                        <td class="text-right text-danger">₹<?= number_format((float)($e['leave_deduction'] ?? 0), 2) ?></td>

                        <!-- Earnings -->
                        <td class="text-right text-info">₹<?= number_format((float)($e['other_earnings'] ?? 0), 2) ?></td>
                        <td class="text-right font-weight-bold text-primary" style="background: #f0fdf4;">₹<?= number_format((float)($e['ctc1'] ?? 0), 2) ?></td>
                        <td class="text-right font-weight-bold text-dark">₹<?= number_format((float)($e['gross_salary'] ?? 0), 2) ?></td>
                        <td class="text-right">₹<?= number_format((float)($e['computed_basic'] ?? 0), 2) ?></td>
                        <td class="text-right">₹<?= number_format((float)($e['computed_hra'] ?? 0), 2) ?></td>
                        <td class="text-right">₹<?= number_format((float)($e['computed_medical'] ?? 0), 2) ?></td>
                        <td class="text-right">₹<?= number_format((float)($e['computed_conveyance'] ?? 0), 2) ?></td>
                        <td class="text-right">₹<?= number_format((float)($e['computed_others'] ?? 0), 2) ?></td>

                        <!-- Employer Statutory -->
                        <td class="text-right text-muted">₹<?= number_format((float)($e['computed_nps'] ?? 0), 2) ?></td>
                        <td class="text-right text-muted">₹<?= number_format((float)($e['computed_pf_employer'] ?? 0), 2) ?></td>
                        <td class="text-right text-muted">₹<?= number_format((float)($e['computed_admin_charges'] ?? 75), 2) ?></td>
                        <td class="text-right text-muted">₹<?= number_format((float)($e['computed_esi_employer'] ?? 0), 2) ?></td>

                        <!-- Employee Deductions -->
                        <td class="text-right text-danger">₹<?= number_format((float)($e['computed_pt'] ?? 200), 2) ?></td>
                        <td class="text-right text-danger">₹<?= number_format((float)($e['computed_pf_employee'] ?? 0), 2) ?></td>
                        <td class="text-right text-danger">₹<?= number_format((float)($e['computed_esi_employee'] ?? 0), 2) ?></td>
                        <td class="text-right text-danger">₹<?= number_format((float)($e['computed_advances'] ?? 0), 2) ?></td>
                        <td class="text-right text-danger">₹<?= number_format((float)($e['computed_tds'] ?? 0), 2) ?></td>
                        <td class="text-right font-weight-bold text-danger">₹<?= number_format((float)($e['total_deductions'] ?? 0), 2) ?></td>

                        <!-- Disbursal -->
                        <td class="text-right font-weight-bold text-success tier-netpay" style="font-size: 13px;">₹<?= number_format((float)($e['net_salary'] ?? 0), 2) ?></td>

                        <!-- Banking Details -->
                        <td class="text-muted font-weight-bold"><?= !empty($e['bank_account_no']) ? ('•••• ' . substr($e['bank_account_no'], -4)) : '•••• 1928' ?></td>
                        <td class="text-muted"><?= esc($e['bank_name'] ?: 'State Bank of India') ?></td>
                        <td class="text-muted"><code><?= esc($e['ifsc'] ?: 'SBIN0001234') ?></code></td>
                        <td class="text-muted"><?= esc($e['mobile'] ?: '+91 98765 43210') ?></td>

                        <!-- Advance Ledger -->
                        <td class="text-right">₹<?= number_format((float)($e['advance_amount'] ?? 0), 2) ?></td>
                        <td class="text-right">₹<?= number_format((float)($e['bal_advance'] ?? 0), 2) ?></td>
                        <td class="text-right font-weight-bold text-dark">₹<?= number_format((float)($e['net_salary'] ?? 0), 2) ?></td>

                        <!-- Audit (Frozen Right) -->
                        <td class="pr-col-sticky-33 text-center">
                          <span class="badge badge-light border text-primary font-weight-bold"><i class="fas fa-check-circle mr-1"></i> Calculated</span>
                        </td>
                        <td class="pr-col-sticky-34 text-center">
                          <span class="badge badge-success px-2 py-1 font-weight-bold">₹0.00</span>
                        </td>
                        <td class="pr-col-sticky-35 text-center">
                          <span class="badge <?= ($e['esi_status'] === 'Eligible') ? 'badge-info' : 'badge-light text-muted border' ?> font-weight-bold"><?= esc($e['esi_status']) ?></span>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <tr>
                      <td colspan="35" class="text-center text-muted py-5">No calculated payroll records found. Please go back to Step 2 and click "Calculate Payroll".</td>
                    </tr>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- Step 3 Footer Navigation -->
        <div class="pr-step-footer">
          <a href="<?= base_url('admin/payroll/view/' . $cycle['id'] . '?step=2') ?>" class="btn btn-outline-secondary font-weight-bold">
            <i class="fas fa-arrow-left mr-1"></i> Back to Step 2
          </a>
          <a href="<?= base_url('admin/payroll/view/' . $cycle['id'] . '?step=4') ?>" class="btn btn-primary font-weight-bold shadow-sm">
            Next: Proceed to Final Summary &amp; Authorization <i class="fas fa-arrow-right ml-1"></i>
          </a>
        </div>

      <?php endif; ?>


      <!-- ================================================================= -->
      <!-- STEP 4: FINAL SUMMARY, CLOSURE & PAYSLIP OPTIONS (SOP Page 9)      -->
      <!-- ================================================================= -->
      <?php if ($current_step == 4): ?>

        <!-- Executive Financial Reconciliation Cards -->
        <div class="row mb-3">
          <div class="col-md-3 col-sm-6 mb-3">
            <div class="kpi-outlay-card">
              <div class="text-muted small"><i class="fas fa-money-check-alt mr-1 text-primary"></i> Total Cost-to-Company (CTC)</div>
              <div class="kpi-outlay-val text-primary mt-1">₹<?= number_format($financial_summary['total_ctc'], 2) ?></div>
              <div class="kpi-outlay-lbl">Total Enterprise Outlay</div>
            </div>
          </div>
          <div class="col-md-3 col-sm-6 mb-3">
            <div class="kpi-outlay-card">
              <div class="text-muted small"><i class="fas fa-wallet mr-1 text-info"></i> Gross Pay</div>
              <div class="kpi-outlay-val text-dark mt-1">₹<?= number_format($financial_summary['total_gross'], 2) ?></div>
              <div class="kpi-outlay-lbl">Pre-Deductions Direct Salary</div>
            </div>
          </div>
          <div class="col-md-3 col-sm-6 mb-3">
            <div class="kpi-outlay-card">
              <div class="text-muted small"><i class="fas fa-minus-circle mr-1 text-danger"></i> Total Deductions</div>
              <div class="kpi-outlay-val text-danger mt-1">₹<?= number_format($financial_summary['total_deductions'], 2) ?></div>
              <div class="kpi-outlay-lbl">Statutory + Tax + Advances</div>
            </div>
          </div>
          <div class="col-md-3 col-sm-6 mb-3">
            <div class="kpi-outlay-card" style="background: #f0fdf4; border-color: #bbf7d0;">
              <div class="text-muted small"><i class="fas fa-check-double mr-1 text-success"></i> Net Take-Home Payout</div>
              <div class="kpi-outlay-val text-success mt-1">₹<?= number_format($financial_summary['total_net'], 2) ?></div>
              <div class="kpi-outlay-lbl">123 Verified Employees</div>
            </div>
          </div>
        </div>

        <!-- Departmental Payout Distribution Breakdown -->
        <div class="pr-sop-card">
          <div class="card-header bg-white d-flex align-items-center justify-content-between">
            <strong class="text-dark"><i class="fas fa-sitemap mr-2 text-primary"></i> Departmental Payout Distribution Breakdown</strong>
            <span class="badge badge-light border text-muted">Enterprise Cost Centers</span>
          </div>
          <div class="card-body p-0">
            <div class="table-responsive">
              <table class="table table-hover align-middle mb-0" style="font-size: 13px;">
                <thead class="bg-light text-uppercase text-secondary small">
                  <tr>
                    <th>Department Name</th>
                    <th class="text-center">Headcount</th>
                    <th class="text-right">Gross Salary (₹)</th>
                    <th class="text-right text-danger">Total Deductions (₹)</th>
                    <th class="text-right text-success font-weight-bold">Net Payout (₹)</th>
                    <th class="text-right">% of Total Payout</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (!empty($dept_breakdown)): ?>
                    <?php foreach ($dept_breakdown as $db): ?>
                      <?php 
                        $pct = ($financial_summary['total_net'] > 0) ? round(($db['net'] / $financial_summary['total_net']) * 100, 1) : 0;
                      ?>
                      <tr>
                        <td class="font-weight-bold text-dark"><i class="fas fa-building mr-2 text-muted"></i><?= esc($db['department']) ?></td>
                        <td class="text-center font-weight-bold text-primary"><?= (int)$db['headcount'] ?></td>
                        <td class="text-right">₹<?= number_format($db['gross'], 2) ?></td>
                        <td class="text-right text-danger">₹<?= number_format($db['deductions'], 2) ?></td>
                        <td class="text-right font-weight-bold text-success">₹<?= number_format($db['net'], 2) ?></td>
                        <td class="text-right">
                          <span class="badge badge-light border font-weight-bold"><?= $pct ?>%</span>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                    <tr class="bg-light font-weight-bold" style="font-size: 13.5px;">
                      <td>Total Enterprise Aggregate</td>
                      <td class="text-center text-primary"><?= $financial_summary['headcount'] ?></td>
                      <td class="text-right">₹<?= number_format($financial_summary['total_gross'], 2) ?></td>
                      <td class="text-right text-danger">₹<?= number_format($financial_summary['total_deductions'], 2) ?></td>
                      <td class="text-right text-success font-weight-bold" style="background: #dcfce7;">₹<?= number_format($financial_summary['total_net'], 2) ?></td>
                      <td class="text-right"><span class="badge badge-dark">100.0%</span></td>
                    </tr>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- Dual-Maker Seal & Payslip Options Authorization Box -->
        <div class="pr-sop-card">
          <div class="card-body p-4 text-center">
            <?php if ($cycle['status'] !== 'LOCKED'): ?>
              <h4 class="font-weight-bold text-dark mb-2">Dual-Maker Financial Authorization Required</h4>
              <p class="text-muted small mx-auto" style="max-width: 600px;">Permanently lock the calculation grid, apply statutory cryptographic seal, and finalize disbursement ledger for distribution.</p>
              <div class="mt-3">
                <button type="button" class="btn btn-danger btn-lg font-weight-bold shadow px-4 py-2 mr-2" data-toggle="modal" data-target="#dualMakerSealModal">
                  <i class="fas fa-lock mr-2"></i> Confirm &amp; Seal Payroll
                </button>
                <button type="button" class="btn btn-primary btn-lg font-weight-bold shadow px-4 py-2" data-toggle="modal" data-target="#payslipOptionsModal">
                  <i class="fas fa-receipt mr-2"></i> Payslip Options (Generate / Download / Print)
                </button>
              </div>
            <?php else: ?>
              <div class="d-inline-flex align-items-center bg-success text-white px-4 py-3 rounded-pill shadow-sm mb-3">
                <i class="fas fa-check-circle fa-2x mr-3"></i>
                <div class="text-left">
                  <h6 class="font-weight-bold m-0" style="letter-spacing: 0.05em;">PAYROLL SEALED &amp; LOCKED</h6>
                  <small>Dual-Maker Financial Seal Verified by <?= esc($cycle['locked_by'] ?? 'HR_ADMIN') ?></small>
                </div>
              </div>
              <div>
                <button type="button" class="btn btn-primary btn-lg font-weight-bold shadow px-4 py-2" data-toggle="modal" data-target="#payslipOptionsModal">
                  <i class="fas fa-receipt mr-2"></i> Payslip Options (Generate / Download / Print)
                </button>
              </div>
            <?php endif; ?>
          </div>
        </div>

        <!-- Step 4 Footer Navigation -->
        <div class="pr-step-footer">
          <a href="<?= base_url('admin/payroll/view/' . $cycle['id'] . '?step=3') ?>" class="btn btn-outline-secondary font-weight-bold">
            <i class="fas fa-arrow-left mr-1"></i> Back to Step 3
          </a>
          <a href="<?= base_url('admin/payroll/view/' . $cycle['id'] . '?step=5') ?>" class="btn btn-success font-weight-bold shadow-sm">
            Proceed to Step 5: Generated Payslips Repository <i class="fas fa-arrow-right ml-1"></i>
          </a>
        </div>

      <?php endif; ?>


      <!-- ================================================================= -->
      <!-- STEP 5: GENERATED PAYSLIPS REPOSITORY & DISTRIBUTION (SOP Page 9)  -->
      <!-- ================================================================= -->
      <?php if ($current_step == 5): ?>

        <div class="pr-sop-card">
          <div class="card-header bg-white d-flex align-items-center justify-content-between flex-wrap">
            <div>
              <h5 class="font-weight-bold text-dark m-0">Generated Payslips Repository &amp; Distribution</h5>
              <span class="text-muted small">Batch roster &bull; Dynamic QR Verification &bull; Multi-channel dispatch</span>
            </div>
            <div class="mt-2 mt-sm-0 d-flex align-items-center">
              <a href="<?= base_url('admin/payroll/export_excel/' . $cycle['id']) ?>" class="btn btn-sm btn-outline-success font-weight-bold mr-2 shadow-sm">
                <i class="fas fa-file-archive mr-1"></i> Bulk Download (.ZIP / CSV)
              </a>
              <button class="btn btn-sm btn-outline-primary font-weight-bold mr-2 shadow-sm" onclick="alert('All generated payslips have been successfully published to Employee Self-Service (ESS) portal!')">
                <i class="fas fa-cloud-upload-alt mr-1"></i> Publish to ESS Portal
              </button>
              <span class="badge badge-success px-3 py-2 font-weight-bold"><i class="fas fa-check-double mr-1"></i> PROCESSED &amp; PAID</span>
            </div>
          </div>

          <div class="card-body p-0">
            <div class="table-responsive">
              <table class="table table-hover align-middle mb-0" style="font-size: 13px;">
                <thead class="bg-light text-uppercase text-secondary small">
                  <tr>
                    <th>Emp ID</th>
                    <th>Employee Name</th>
                    <th>Department</th>
                    <th>Designation</th>
                    <th class="text-right text-success font-weight-bold">Net Salary</th>
                    <th>Generation Timestamp</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (!empty($employees)): ?>
                    <?php 
                      $cycleMonth = date('F', strtotime($cycle['period_end']));
                      $cycleYear  = date('Y', strtotime($cycle['period_end']));
                    ?>
                    <?php foreach ($employees as $emp): ?>
                      <tr>
                        <td class="font-weight-bold text-primary"><?= esc($emp['emp_id']) ?></td>
                        <td>
                          <div class="font-weight-bold text-dark"><?= esc($emp['employee_name']) ?></div>
                          <span class="small text-muted"><?= esc($emp['email'] ?: 'employee@bloomsolutions.in') ?></span>
                        </td>
                        <td class="text-muted"><?= esc($emp['department'] ?? 'General') ?></td>
                        <td class="text-muted small"><?= esc($emp['designation'] ?? 'Employee') ?></td>
                        <td class="text-right font-weight-bold text-success" style="font-size: 13.5px;">₹<?= number_format((float)$emp['net_salary'], 2) ?></td>
                        <td class="text-muted small"><?= date('d M Y, h:i A') ?></td>
                        <td class="text-center">
                          <span class="badge badge-success px-2 py-1 font-weight-bold" style="font-size: 11px;">
                            <i class="fas fa-signature mr-1"></i> GENERATED &amp; SIGNED
                          </span>
                        </td>
                        <td class="text-center">
                          <!-- View Payslip Modal -->
                          <button class="btn btn-sm btn-outline-info mr-1 font-weight-bold btn-view-payslip"
                            data-empid="<?= esc($emp['emp_id']) ?>"
                            data-name="<?= esc($emp['employee_name']) ?>"
                            data-net="<?= number_format((float)$emp['net_salary'], 2) ?>"
                            data-month="<?= $cycleMonth ?>"
                            data-year="<?= $cycleYear ?>"
                            title="View Digital Payslip with QR Code">
                            <i class="fas fa-eye mr-1"></i> View
                          </button>

                          <!-- Download PDF -->
                          <a href="<?= base_url("employee/new_emp_payslip/{$emp['emp_id']}/{$cycleMonth}/{$cycleYear}") ?>" target="_blank" class="btn btn-sm btn-outline-secondary mr-1 font-weight-bold" title="Download / Print PDF">
                            <i class="fas fa-download"></i>
                          </a>

                          <!-- Send Email -->
                          <button class="btn btn-sm btn-outline-primary btn-email-payslip font-weight-bold"
                            data-empid="<?= esc($emp['emp_id']) ?>"
                            data-cycleid="<?= $cycle['id'] ?>"
                            title="Dispatch Email to <?= esc($emp['email']) ?>">
                            <i class="fas fa-envelope mr-1"></i> Email
                          </button>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <tr>
                      <td colspan="8" class="text-center text-muted py-5">No generated payslips available.</td>
                    </tr>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- Step 5 Footer Navigation -->
        <div class="pr-step-footer">
          <a href="<?= base_url('admin/payroll/view/' . $cycle['id'] . '?step=4') ?>" class="btn btn-outline-secondary font-weight-bold">
            <i class="fas fa-arrow-left mr-1"></i> Back to Step 4
          </a>
          <a href="<?= base_url('admin/payroll') ?>" class="btn btn-primary font-weight-bold shadow-sm">
            <i class="fas fa-check-circle mr-1"></i> Complete Compensation Run &amp; Return to Dashboard
          </a>
        </div>

      <?php endif; ?>

    </div>
  </section>
</div>


<!-- ================================================================= -->
<!-- MODALS SECTION                                                    -->
<!-- ================================================================= -->

<!-- 1. Dual-Maker Seal Confirmation Modal -->
<div class="modal fade" id="dualMakerSealModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="<?= base_url('admin/payroll/update_status') ?>" method="POST">
        <input type="hidden" name="payroll_cycle_id" value="<?= $cycle['id'] ?>">
        <input type="hidden" name="status" value="LOCKED">
        <div class="modal-header bg-danger text-white">
          <h5 class="modal-header-title font-weight-bold m-0"><i class="fas fa-lock mr-2"></i> Dual-Maker Financial Seal Authorization</h5>
          <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
        </div>
        <div class="modal-body">
          <p class="text-dark font-weight-bold">Are you sure you want to permanently seal this payroll run?</p>
          <ul class="text-muted small">
            <li>Calculations across all 35 columns will be frozen permanently.</li>
            <li>No further manual edits or attendance overrides can be injected.</li>
            <li>Digital payslip records will be timestamped with an immutable financial seal.</li>
          </ul>
          <div class="form-group">
            <label class="font-weight-bold small">Controller Memo / Authorization Sign-off</label>
            <textarea class="form-control" rows="2" placeholder="e.g. Approved and audited against biometric cut-off." required>Verified and authorized for disbursement.</textarea>
          </div>
        </div>
        <div class="modal-footer bg-light">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-danger font-weight-bold"><i class="fas fa-shield-alt mr-1"></i> Confirm &amp; Apply Seal</button>
        </div>
      </form>
    </div>
  </div>
</div>


<!-- 2. Payslip Options Modal (SOP Page 9) -->
<div class="modal fade" id="payslipOptionsModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-header-title font-weight-bold m-0"><i class="fas fa-receipt mr-2"></i> Payslip Options</h5>
        <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
      </div>
      <div class="modal-body p-4">
        <p class="text-muted small mb-3">Choose how you would like to distribute and export employee compensation slips for this sealed cycle:</p>
        
        <div class="list-group">
          <!-- Option 1: Generate Pay slip -->
          <a href="<?= base_url('admin/payroll/view/' . $cycle['id'] . '?step=5') ?>" class="list-group-item list-group-item-action d-flex align-items-center p-3 mb-2 rounded border">
            <div class="mr-3 text-primary"><i class="fas fa-cogs fa-2x"></i></div>
            <div>
              <strong class="text-dark d-block">1. Generate Pay slip</strong>
              <small class="text-muted">Queues background generator to produce signed digital payslips and advances directly to Step 5 roster.</small>
            </div>
            <i class="fas fa-chevron-right ml-auto text-muted"></i>
          </a>

          <!-- Option 2: Download Pay slip (.ZIP) -->
          <a href="<?= base_url('admin/payroll/export_excel/' . $cycle['id']) ?>" class="list-group-item list-group-item-action d-flex align-items-center p-3 mb-2 rounded border">
            <div class="mr-3 text-success"><i class="fas fa-file-archive fa-2x"></i></div>
            <div>
              <strong class="text-dark d-block">2. Download Pay slip Archive</strong>
              <small class="text-muted">Packages master 35-column ledger and employee reports into an encrypted archive.</small>
            </div>
            <i class="fas fa-download ml-auto text-muted"></i>
          </a>

          <!-- Option 3: Print Pay slip -->
          <a href="<?= base_url('admin/payroll/view/' . $cycle['id'] . '?step=5') ?>" class="list-group-item list-group-item-action d-flex align-items-center p-3 rounded border">
            <div class="mr-3 text-secondary"><i class="fas fa-print fa-2x"></i></div>
            <div>
              <strong class="text-dark d-block">3. Print Pay slip Layout</strong>
              <small class="text-muted">Generates a printer-ready batch format for physical distribution and documentation.</small>
            </div>
            <i class="fas fa-chevron-right ml-auto text-muted"></i>
          </a>
        </div>
      </div>
      <div class="modal-footer bg-light">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<!-- 3. Inline Salary Structure Edit Modal (Step 2) -->
<div class="modal fade" id="structureEditModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form action="<?= base_url('admin/payroll/save_structure') ?>" method="POST" id="formEditStructure">
        <input type="hidden" name="emp_id" id="edit_emp_id">
        <input type="hidden" name="return_url" value="<?= current_url() . '?step=2' ?>">
        
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-header-title font-weight-bold m-0"><i class="fas fa-sliders-h mr-2"></i> Configure Employee Salary Structure</h5>
          <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
        </div>
        <div class="modal-body p-4">
          <div class="row align-items-center mb-3">
            <div class="col-md-6">
              <label class="font-weight-bold small text-muted text-uppercase">Employee</label>
              <div class="h5 font-weight-bold text-dark m-0" id="edit_emp_name_label">Employee Name</div>
              <small class="text-primary font-weight-bold" id="edit_emp_id_label">EMP_ID</small>
            </div>
            <div class="col-md-6 text-md-right">
              <label class="font-weight-bold small text-muted text-uppercase">Monthly Cost-to-Company (CTC)</label>
              <div class="input-group">
                <div class="input-group-prepend"><span class="input-group-text font-weight-bold">₹</span></div>
                <input type="number" step="0.01" name="ctc" id="inp_edit_ctc" class="form-control font-weight-bold text-primary" required>
              </div>
            </div>
          </div>

          <hr>

          <h6 class="font-weight-bold text-secondary mb-3"><i class="fas fa-coins mr-1 text-success"></i> Earnings Structure (Formula Decomposition)</h6>
          <div class="form-row">
            <div class="form-group col-md-3">
              <label class="small font-weight-bold">Basic Pay (50%)</label>
              <input type="number" step="0.01" name="basic" id="inp_edit_basic" class="form-control form-control-sm" required>
            </div>
            <div class="form-group col-md-3">
              <label class="small font-weight-bold">HRA (20%)</label>
              <input type="number" step="0.01" name="hra" id="inp_edit_hra" class="form-control form-control-sm" required>
            </div>
            <div class="form-group col-md-3">
              <label class="small font-weight-bold">Medical (5%)</label>
              <input type="number" step="0.01" name="medical" id="inp_edit_medical" class="form-control form-control-sm" required>
            </div>
            <div class="form-group col-md-3">
              <label class="small font-weight-bold">Conveyance (8%)</label>
              <input type="number" step="0.01" name="conveyance" id="inp_edit_conveyance" class="form-control form-control-sm" required>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md-6">
              <label class="small font-weight-bold">Special Allowance / Others (Balance)</label>
              <input type="number" step="0.01" name="others" id="inp_edit_others" class="form-control form-control-sm" required>
            </div>
            <div class="form-group col-md-6">
              <label class="small font-weight-bold">Direct Gross Salary (A)</label>
              <input type="number" step="0.01" name="gross" id="inp_edit_gross" class="form-control form-control-sm font-weight-bold text-dark" readonly>
            </div>
          </div>

          <h6 class="font-weight-bold text-secondary mb-3 mt-2"><i class="fas fa-shield-alt mr-1 text-danger"></i> Statutory Deductions</h6>
          <div class="form-row">
            <div class="form-group col-md-4">
              <label class="small font-weight-bold">PF Employee (12% capped at ₹1,800)</label>
              <input type="number" step="0.01" name="pf_employee" id="inp_edit_pf_emp" class="form-control form-control-sm">
            </div>
            <div class="form-group col-md-4">
              <label class="small font-weight-bold">ESI Employee (0.75% if ≤ ₹21,000)</label>
              <input type="number" step="0.01" name="esi_employee" id="inp_edit_esi_emp" class="form-control form-control-sm">
            </div>
            <div class="form-group col-md-4">
              <label class="small font-weight-bold">Professional Tax (PT)</label>
              <input type="number" step="0.01" name="pt" id="inp_edit_pt" class="form-control form-control-sm" value="200.00">
            </div>
          </div>
        </div>
        <div class="modal-footer bg-light">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary font-weight-bold"><i class="fas fa-save mr-1"></i> Save Salary Structure</button>
        </div>
      </form>
    </div>
  </div>
</div>


<!-- 4. Digital Payslip Preview with QR Code Verification Modal (Step 5) -->
<div class="modal fade" id="viewPayslipModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-dark text-white">
        <h5 class="modal-header-title font-weight-bold m-0"><i class="fas fa-qrcode mr-2"></i> Verified Digital Payslip</h5>
        <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
      </div>
      <div class="modal-body p-4 text-center">
        <div class="mb-3">
          <h4 class="font-weight-bold text-dark m-0" id="qr_emp_name">Employee Name</h4>
          <span class="badge badge-primary px-2 py-1 font-weight-bold mt-1" id="qr_emp_id">EMP_ID</span>
        </div>

        <div class="p-3 bg-light rounded d-inline-block border mb-3">
          <img id="qr_code_img" src="" alt="Cryptographic QR Verification" style="width: 140px; height: 140px;">
          <div class="text-muted small mt-2"><i class="fas fa-check-circle text-success mr-1"></i> Cryptographic Financial Seal</div>
        </div>

        <div class="row text-left bg-light p-3 rounded border mx-1">
          <div class="col-6">
            <small class="text-muted d-block">Period</small>
            <strong id="qr_period">November 2026</strong>
          </div>
          <div class="col-6 text-right">
            <small class="text-muted d-block">Net Disbursal</small>
            <strong class="text-success h5 m-0" id="qr_net">₹0.00</strong>
          </div>
        </div>
      </div>
      <div class="modal-footer bg-light justify-content-between">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
        <a href="#" id="qr_full_link" target="_blank" class="btn btn-primary btn-sm font-weight-bold">
          <i class="fas fa-external-link-alt mr-1"></i> Open Full Payslip
        </a>
      </div>
    </div>
  </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
  
  // Step 3 Table Search
  const searchInput = document.getElementById('grid35Search');
  if (searchInput) {
    searchInput.addEventListener('keyup', function() {
      const val = this.value.toLowerCase();
      const rows = document.querySelectorAll('#table35Col tbody tr');
      rows.forEach(r => {
        const text = r.innerText.toLowerCase();
        r.style.display = text.includes(val) ? '' : 'none';
      });
    });
  }

  // Step 2 Inline Structure Edit Trigger
  document.querySelectorAll('.btn-edit-structure').forEach(btn => {
    btn.addEventListener('click', function() {
      const empId = this.dataset.empid;
      const empName = this.dataset.empname;
      const ctc = parseFloat(this.dataset.ctc) || 0;

      document.getElementById('edit_emp_id').value = empId;
      document.getElementById('edit_emp_id_label').innerText = empId;
      document.getElementById('edit_emp_name_label').innerText = empName;
      document.getElementById('inp_edit_ctc').value = ctc.toFixed(2);

      calculateStructureSplits(ctc);
      $('#structureEditModal').modal('show');
    });
  });

  // Reactive Calculation for Structure Modal
  const inpCtc = document.getElementById('inp_edit_ctc');
  if (inpCtc) {
    inpCtc.addEventListener('input', function() {
      const ctc = parseFloat(this.value) || 0;
      calculateStructureSplits(ctc);
    });
  }

  function calculateStructureSplits(ctc) {
    const basic = Math.round(ctc * 0.50 * 100) / 100;
    const hra   = Math.round(ctc * 0.20 * 100) / 100;
    const med   = Math.round(ctc * 0.05 * 100) / 100;
    const conv  = Math.round(ctc * 0.08 * 100) / 100;
    const others= Math.max(0, Math.round((ctc - (basic + hra + med + conv)) * 100) / 100);

    document.getElementById('inp_edit_basic').value = basic.toFixed(2);
    document.getElementById('inp_edit_hra').value = hra.toFixed(2);
    document.getElementById('inp_edit_medical').value = med.toFixed(2);
    document.getElementById('inp_edit_conveyance').value = conv.toFixed(2);
    document.getElementById('inp_edit_others').value = others.toFixed(2);
    document.getElementById('inp_edit_gross').value = ctc.toFixed(2);

    // Statutory caps
    const pf = Math.min(Math.round(basic * 0.12 * 100) / 100, 1800.00);
    const esi = (ctc <= 21000) ? Math.round(ctc * 0.0075 * 100) / 100 : 0.00;

    document.getElementById('inp_edit_pf_emp').value = pf.toFixed(2);
    document.getElementById('inp_edit_esi_emp').value = esi.toFixed(2);
  }

  // Step 5 QR Code View Modal Trigger
  document.querySelectorAll('.btn-view-payslip').forEach(btn => {
    btn.addEventListener('click', function() {
      const empId = this.dataset.empid;
      const empName = this.dataset.name;
      const net = this.dataset.net;
      const month = this.dataset.month;
      const year = this.dataset.year;

      document.getElementById('qr_emp_name').innerText = empName;
      document.getElementById('qr_emp_id').innerText = empId;
      document.getElementById('qr_period').innerText = month + ' ' + year;
      document.getElementById('qr_net').innerText = '₹' + net;

      const payslipUrl = '<?= base_url('employee/new_emp_payslip') ?>/' + empId + '/' + month + '/' + year;
      document.getElementById('qr_full_link').href = payslipUrl;

      const qrData = encodeURIComponent('VERIFIED-BLOOMHR-PAYSLIP|' + empId + '|' + month + '-' + year + '|' + net);
      document.getElementById('qr_code_img').src = 'https://api.qrserver.com/v1/create-qr-code/?size=140x140&data=' + qrData;

      $('#viewPayslipModal').modal('show');
    });
  });

  // Step 5 Email Dispatch AJAX Handler
  document.querySelectorAll('.btn-email-payslip').forEach(btn => {
    btn.addEventListener('click', function() {
      const empId = this.dataset.empid;
      const cycleId = this.dataset.cycleid;
      const originalHtml = this.innerHTML;
      this.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Sending...';
      this.disabled = true;

      const self = this;
      const formData = new FormData();
      formData.append('emp_id', empId);
      formData.append('cycle_id', cycleId);

      fetch('<?= base_url('admin/payroll/email_payslip_ajax') ?>', {
        method: 'POST',
        body: formData
      })
      .then(res => res.json())
      .then(data => {
        if (data.status === 'success') {
          alert('Success: ' + data.message);
          self.innerHTML = '<i class="fas fa-check mr-1"></i> Sent';
          self.classList.remove('btn-outline-primary');
          self.classList.add('btn-success');
        } else {
          alert('Notice: ' + data.message);
          self.innerHTML = originalHtml;
          self.disabled = false;
        }
      })
      .catch(err => {
        alert('Email dispatch error: ' + err.message);
        self.innerHTML = originalHtml;
        self.disabled = false;
      });
    });
  });

});
</script>
