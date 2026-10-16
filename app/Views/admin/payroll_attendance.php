<style>
  /* Premium HRMS Attendance Design Tokens */
  :root {
    --att-primary: #3b82f6;
    --att-primary-dark: #1d4ed8;
    --att-primary-light: #eff6ff;
    --att-success: #10b981;
    --att-success-light: #ecfdf5;
    --att-warning: #f59e0b;
    --att-warning-light: #fffbeb;
    --att-danger: #ef4444;
    --att-danger-light: #fef2f2;
    --att-indigo: #6366f1;
    --att-indigo-light: #eef2ff;
    --att-surface: #ffffff;
    --att-bg: #f8fafc;
    --att-border: #e2e8f0;
    --att-text-main: #0f172a;
    --att-text-muted: #64748b;
  }

  .content-wrapper {
    background-color: var(--att-bg) !important;
  }

  /* Card Styles */
  .att-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.04), 0 2px 4px -2px rgba(0, 0, 0, 0.04);
    transition: all 0.2s ease;
  }
  .att-card:hover {
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.06), 0 4px 6px -4px rgba(0, 0, 0, 0.04);
  }

  /* Stat Widget */
  .att-stat-widget {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    padding: 18px 20px;
    position: relative;
    overflow: hidden;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
  }
  .att-stat-widget:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 16px -4px rgba(0,0,0,0.06);
  }
  .att-stat-widget .stat-icon {
    width: 42px;
    height: 42px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 17px;
  }
  .att-stat-widget .stat-number {
    font-size: 24px;
    font-weight: 700;
    color: var(--att-text-main);
    line-height: 1.1;
    letter-spacing: -0.02em;
    margin-top: 8px;
  }
  .att-stat-widget .stat-label {
    font-size: 11.5px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: var(--att-text-muted);
  }

  /* Hero Banner */
  .att-hero-banner {
    background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
    border-radius: 18px;
    padding: 24px 28px;
    color: #ffffff;
    margin-bottom: 24px;
    position: relative;
    overflow: hidden;
    box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.25);
  }
  .att-hero-banner::after {
    content: '';
    position: absolute;
    top: -50%;
    right: -10%;
    width: 320px;
    height: 320px;
    background: radial-gradient(circle, rgba(16, 185, 129, 0.2) 0%, rgba(255,255,255,0) 70%);
    border-radius: 50%;
    pointer-events: none;
  }

  /* Buttons */
  .btn-att-primary {
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    color: #ffffff !important;
    border: none;
    border-radius: 10px;
    padding: 9px 18px;
    font-weight: 600;
    font-size: 13px;
    box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
    transition: all 0.2s ease;
  }
  .btn-att-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 16px rgba(37, 99, 235, 0.35);
  }
  .btn-att-success {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: #ffffff !important;
    border: none;
    border-radius: 10px;
    padding: 9px 20px;
    font-weight: 600;
    font-size: 13px;
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.25);
    transition: all 0.2s ease;
  }
  .btn-att-success:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 16px rgba(16, 185, 129, 0.35);
  }
  .btn-att-secondary {
    background: #ffffff;
    color: #334155 !important;
    border: 1px solid #cbd5e1;
    border-radius: 10px;
    padding: 9px 16px;
    font-weight: 600;
    font-size: 13px;
    transition: all 0.2s ease;
  }
  .btn-att-secondary:hover {
    background: #f1f5f9;
    border-color: #94a3b8;
  }

  /* Filter Panel */
  .filter-panel {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    padding: 16px 20px;
    margin-bottom: 22px;
  }

  /* Badge Styles */
  .badge-pill-soft {
    border-radius: 30px;
    padding: 6px 14px;
    font-size: 12px;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 6px;
  }
  .badge-soft-success {
    background-color: var(--att-success-light);
    color: #065f46;
    border: 1px solid #a7f3d0;
  }
  .badge-soft-warning {
    background-color: var(--att-warning-light);
    color: #92400e;
    border: 1px solid #fde68a;
  }
  .badge-soft-danger {
    background-color: var(--att-danger-light);
    color: #991b1b;
    border: 1px solid #fecaca;
  }
  .badge-soft-primary {
    background-color: var(--att-primary-light);
    color: #1e40af;
    border: 1px solid #bfdbfe;
  }

  /* Pulse Indicator */
  .pulse-dot-green {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background-color: #10b981;
    display: inline-block;
    box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
    animation: pulseAtt 1.8s infinite;
  }
  @keyframes pulseAtt {
    0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
    70% { transform: scale(1); box-shadow: 0 0 0 6px rgba(16, 185, 129, 0); }
    100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
  }

  /* Table Customization */
  .att-table thead th {
    background-color: #f8fafc;
    color: #475569;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.06em;
    padding: 13px 14px;
    border-top: none;
    border-bottom: 1px solid #e2e8f0;
  }
  .att-table tbody td {
    padding: 13px 14px;
    vertical-align: middle;
    color: #1e293b;
    font-size: 13px;
    border-bottom: 1px solid #f1f5f9;
  }
  .att-table tbody tr:hover {
    background-color: #f8fafc;
  }

  /* Employee Avatar Bubble */
  .emp-bubble {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    background: #e0e7ff;
    color: #4338ca;
    font-weight: 700;
    font-size: 13px;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  /* Custom DataTables styling override */
  .dataTables_wrapper .dataTables_length,
  .dataTables_wrapper .dataTables_filter {
    padding: 16px 20px;
    color: #64748b;
    font-size: 13px;
  }
  .dataTables_wrapper .dataTables_filter input {
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    padding: 6px 12px;
    margin-left: 8px;
    outline: none;
  }
  .dataTables_wrapper .dataTables_filter input:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
  }
  .dataTables_wrapper .dataTables_info,
  .dataTables_wrapper .dataTables_paginate {
    padding: 16px 20px;
    font-size: 13px;
    color: #64748b;
  }
  .dataTables_wrapper .dataTables_paginate .paginate_button {
    border-radius: 8px !important;
    margin: 0 2px;
  }
  .dataTables_wrapper .dataTables_paginate .paginate_button.current {
    background: #3b82f6 !important;
    border-color: #3b82f6 !important;
    color: #ffffff !important;
  }
</style>

<div class="content-wrapper p-3 p-md-4">
  <div class="container-fluid">

    <!-- Shared Payroll Sub Navigation -->
    <?= view('admin/payroll/payroll_nav') ?>

    <!-- Flash Notifications -->
    <?php if (session()->getFlashdata('success')): ?>
      <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 mb-3" style="border-radius: 12px; background: #ecfdf5; color: #065f46; border-left: 4px solid #10b981 !important;" role="alert">
        <div class="d-flex align-items-center">
          <i class="fas fa-check-circle fa-lg mr-2 text-success"></i>
          <div><?= session()->getFlashdata('success') ?></div>
        </div>
        <button type="button" class="close" data-dismiss="alert" style="color: #065f46;"><span>&times;</span></button>
      </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
      <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 mb-3" style="border-radius: 12px; background: #fef2f2; color: #991b1b; border-left: 4px solid #ef4444 !important;" role="alert">
        <div class="d-flex align-items-center">
          <i class="fas fa-exclamation-triangle fa-lg mr-2 text-danger"></i>
          <div><?= session()->getFlashdata('error') ?></div>
        </div>
        <button type="button" class="close" data-dismiss="alert" style="color: #991b1b;"><span>&times;</span></button>
      </div>
    <?php endif; ?>

    <!-- Hero Banner -->
    <div class="att-hero-banner">
      <div class="row align-items-center">
        <div class="col-lg-7 col-md-12 mb-3 mb-lg-0">
          <div class="d-flex align-items-center mb-2">
            <span class="badge badge-pill-soft text-white mr-2" style="background: rgba(16, 185, 129, 0.25); border: 1px solid rgba(16, 185, 129, 0.4);">
              <i class="fas fa-calendar-check mr-1 text-success"></i> ATTENDANCE VERIFICATION
            </span>
            <span class="text-light small opacity-75">Pay Cycle Attendance & Deduction Aggregator</span>
          </div>
          <h2 class="font-weight-bold text-white mb-2" style="letter-spacing: -0.02em;">Payroll Attendance Summary</h2>
          <p class="text-light opacity-75 mb-0" style="max-width: 620px; font-size: 13.5px; line-height: 1.5;">
            Official attendance totals for the 25th-to-24th monthly period. Paid days determine base earnings, while unpaid absent days automatically generate LOP salary deductions.
          </p>
        </div>
        <div class="col-lg-5 col-md-12 text-lg-right">
          <div class="d-flex flex-wrap justify-content-lg-end gap-2">
            <a href="<?= base_url('admin/payroll') ?>" class="btn btn-att-secondary mr-2 mb-2 shadow-sm">
              <i class="fas fa-calculator text-primary mr-1"></i> Payroll Cycles Dashboard
            </a>
            <?php if (isset($is_finalized) && $is_finalized): ?>
              <?php if (!empty($existingCycle)): ?>
                <a href="<?= base_url('admin/payroll/view/' . $existingCycle['id']) ?>" class="btn btn-att-primary mb-2 shadow-sm">
                  <i class="fas fa-check-double mr-1"></i> Open Payroll Cycle (<?= esc($existingCycle['payroll_code']) ?>)
                </a>
              <?php else: ?>
                <button type="button" class="btn btn-att-success mb-2 shadow-sm" data-toggle="modal" data-target="#generateCycleModal">
                  <i class="fas fa-magic mr-1"></i> Generate Payroll Cycle
                </button>
              <?php endif; ?>
            <?php else: ?>
              <?php if (!empty($records)): ?>
                <button type="button" class="btn btn-warning font-weight-bold mb-2 shadow-sm text-dark mr-2" id="btnRecalcBanner" onclick="recalculateAttendance()">
                  <i class="fas fa-sync-alt mr-1"></i> Update / Recalculate
                </button>
                <button type="button" class="btn btn-att-success mb-2 shadow-sm" id="topFinalizeBtn" onclick="$('#finalizeBtn').click()">
                  <i class="fas fa-lock mr-1"></i> Finalize Attendance
                </button>
              <?php else: ?>
                <button type="button" class="btn btn-att-success mb-2 shadow-sm font-weight-bold" id="btnGenBanner" onclick="recalculateAttendance()">
                  <i class="fas fa-calculator mr-1"></i> Generate Attendance Summary
                </button>
              <?php endif; ?>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>

    <!-- Filter & Month Control Panel -->
    <div class="filter-panel shadow-sm">
      <div class="row align-items-center">
        <div class="col-lg-6 col-md-12 mb-3 mb-lg-0">
          <form method="get" action="<?= base_url('admin/payroll_attendance') ?>" class="form-inline flex-wrap">
            <label class="mr-2 font-weight-bold text-secondary small text-uppercase">Month / Year:</label>
            <select name="month" class="form-control form-control-sm mr-2 mb-1" style="border-radius: 8px; min-width: 140px;">
              <?php for ($m = 1; $m <= 12; $m++) : ?>
                <option value="<?= $m ?>" <?= ($selectedMonth == $m) ? 'selected' : '' ?>>
                  <?= date('F', mktime(0, 0, 0, $m, 10)) ?>
                </option>
              <?php endfor; ?>
            </select>

            <select name="year" class="form-control form-control-sm mr-2 mb-1" style="border-radius: 8px; width: 95px;">
              <?php
              $currY = 2026;
              for ($y = $currY - 2; $y <= $currY + 1; $y++) {
                $sel = ($selectedYear == $y) ? 'selected' : '';
                echo "<option value=\"$y\" $sel>$y</option>";
              }
              ?>
            </select>

            <button type="submit" class="btn btn-att-primary btn-sm px-3 mb-1 mr-1" style="padding: 6px 14px;">
              <i class="fas fa-filter mr-1"></i> View Month
            </button>
            <a href="<?= base_url('admin/payroll_attendance?month=8&year=2026') ?>" class="btn btn-light btn-sm border px-3 mb-1" style="border-radius: 8px;">
              August 2026
            </a>
          </form>
        </div>

        <div class="col-lg-6 col-md-12 text-lg-right d-flex justify-content-lg-end align-items-center flex-wrap">
          <div class="mr-3 mb-1">
            <span class="text-muted small mr-1 font-weight-bold">Cut-off Period:</span>
            <span class="badge badge-pill-soft badge-soft-dark">
              <i class="far fa-calendar-alt text-primary mr-1"></i>
              <?= date('d M Y', strtotime($periodStart)) ?> &rarr; <?= date('d M Y', strtotime($periodEnd)) ?>
            </span>
          </div>

          <div class="mb-1">
            <?php if (isset($is_finalized) && $is_finalized): ?>
              <span class="badge badge-pill-soft badge-soft-success">
                <span class="pulse-dot-green"></span> Finalized & Verified
              </span>
            <?php else: ?>
              <span class="badge badge-pill-soft badge-soft-warning">
                <i class="fas fa-clock mr-1"></i> Pending Finalization
              </span>
              <?php if (!empty($records)): ?>
                <button type="button" class="btn btn-warning btn-sm font-weight-bold px-3 py-1 ml-2" style="border-radius:8px;" id="finalizeBtn">
                  <i class="fas fa-lock mr-1"></i> Finalize Attendance
                </button>
              <?php endif; ?>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>

    <!-- KPI Metric Cards Grid -->
    <div class="row mb-4">
      <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
        <div class="att-stat-widget">
          <div class="d-flex justify-content-between align-items-center">
            <span class="stat-label">Total Staff</span>
            <div class="stat-icon" style="background: var(--att-primary-light); color: var(--att-primary);">
              <i class="fas fa-users"></i>
            </div>
          </div>
          <div class="stat-number"><?= number_format($stats['totalEmployees']) ?></div>
          <div class="small text-muted mt-1">Active employees</div>
        </div>
      </div>

      <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
        <div class="att-stat-widget">
          <div class="d-flex justify-content-between align-items-center">
            <span class="stat-label">Work Days</span>
            <div class="stat-icon" style="background: var(--att-indigo-light); color: var(--att-indigo);">
              <i class="fas fa-briefcase"></i>
            </div>
          </div>
          <div class="stat-number text-info"><?= number_format($stats['totalWorkingDays'], 0) ?></div>
          <div class="small text-muted mt-1">Expected work days</div>
        </div>
      </div>

      <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
        <div class="att-stat-widget">
          <div class="d-flex justify-content-between align-items-center">
            <span class="stat-label">Paid Days</span>
            <div class="stat-icon" style="background: var(--att-success-light); color: var(--att-success);">
              <i class="fas fa-check-circle"></i>
            </div>
          </div>
          <div class="stat-number text-success"><?= number_format($stats['totalPaidDays'], 0) ?></div>
          <div class="small text-success font-weight-bold mt-1">Salary earning days</div>
        </div>
      </div>

      <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
        <div class="att-stat-widget">
          <div class="d-flex justify-content-between align-items-center">
            <span class="stat-label">Unpaid (LOP)</span>
            <div class="stat-icon" style="background: var(--att-danger-light); color: var(--att-danger);">
              <i class="fas fa-minus-circle"></i>
            </div>
          </div>
          <div class="stat-number text-danger"><?= number_format($stats['totalUnpaidDays'], 0) ?></div>
          <div class="small text-danger font-weight-bold mt-1">Salary deduction days</div>
        </div>
      </div>

      <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
        <div class="att-stat-widget">
          <div class="d-flex justify-content-between align-items-center">
            <span class="stat-label">Paid Leaves</span>
            <div class="stat-icon" style="background: #f1f5f9; color: #475569;">
              <i class="fas fa-plane-departure"></i>
            </div>
          </div>
          <div class="stat-number text-dark"><?= number_format($stats['totalLeaves'], 0) ?></div>
          <div class="small text-muted mt-1">Approved paid leave</div>
        </div>
      </div>

      <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
        <div class="att-stat-widget">
          <div class="d-flex justify-content-between align-items-center">
            <span class="stat-label">Holidays & WO</span>
            <div class="stat-icon" style="background: var(--att-warning-light); color: var(--att-warning);">
              <i class="fas fa-umbrella-beach"></i>
            </div>
          </div>
          <div class="stat-number text-warning"><?= number_format($stats['totalHolidays'], 0) ?></div>
          <div class="small text-muted mt-1">Statutory off days</div>
        </div>
      </div>
    </div>

    <!-- Attendance Table Card -->
    <div class="att-card mb-4">
      <div class="card-header bg-white py-3 px-4 border-0 d-flex flex-wrap justify-content-between align-items-center">
        <div>
          <h5 class="font-weight-bold text-dark m-0 d-flex align-items-center">
            <i class="fas fa-table text-primary mr-2"></i> Attendance Log: <?= esc($monthName) ?> <?= esc($selectedYear) ?>
          </h5>
          <small class="text-muted">Verified individual staff metrics determining the payout calculation</small>
        </div>
        <div class="d-flex align-items-center">
          <span class="badge badge-pill-soft badge-soft-primary px-3 mr-2 font-weight-bold">
            <?= count($records) ?> Employees Verified
          </span>
          <?php if (isset($is_finalized) && $is_finalized && empty($existingCycle)): ?>
            <button class="btn btn-sm btn-att-success" data-toggle="modal" data-target="#generateCycleModal">
              <i class="fas fa-magic mr-1"></i> Generate Cycle
            </button>
          <?php endif; ?>
        </div>
      </div>

      <div class="table-responsive">
        <table class="table att-table mb-0" id="payrollAttendanceTable">
          <thead>
            <tr>
              <th>Employee Info</th>
              <th class="text-center">Total Period</th>
              <th class="text-center">Work Days</th>
              <th class="text-center">Paid Days</th>
              <th class="text-center">Unpaid / LOP</th>
              <th class="text-center">Present</th>
              <th class="text-center">WFH</th>
              <th class="text-center">Leave</th>
              <th class="text-center">Holidays & WO</th>
              <th class="text-center">Late</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($records)) : ?>
              <?php foreach ($records as $row) : ?>
                <?php
                  $initials = '';
                  $names = explode(' ', trim($row['emp_name'] ?? ''));
                  foreach (array_slice($names, 0, 2) as $n) {
                    $initials .= strtoupper(substr($n, 0, 1));
                  }
                  $unpaid = floatval($row['unpaid_days']);
                ?>
                <tr>
                  <td>
                    <div class="d-flex align-items-center">
                      <div class="emp-bubble mr-3">
                        <?= $initials ?: 'EM' ?>
                      </div>
                      <div>
                        <div class="font-weight-bold text-dark" style="font-size: 13.5px;"><?= esc($row['emp_name']) ?></div>
                        <div class="text-muted small">
                          <span class="font-weight-bold text-primary mr-1"><?= esc($row['emp_id']) ?></span> &bull; 
                          <?= esc($row['designation'] ?? 'Staff') ?>
                        </div>
                      </div>
                    </div>
                  </td>
                  <td class="text-center text-muted font-weight-bold">
                    <?= floatval($row['total_days']) ?> d
                  </td>
                  <td class="text-center font-weight-bold text-dark">
                    <?= floatval($row['working_days']) ?>
                  </td>
                  <td class="text-center">
                    <span class="badge badge-pill-soft badge-soft-success font-weight-bold" style="font-size: 12.5px;">
                      <i class="fas fa-check mr-1"></i> <?= floatval($row['paid_days']) ?>
                    </span>
                  </td>
                  <td class="text-center">
                    <?php if ($unpaid > 0): ?>
                      <span class="badge badge-pill-soft badge-soft-danger font-weight-bold" style="font-size: 12.5px;">
                        <i class="fas fa-exclamation-circle mr-1"></i> <?= $unpaid ?> LOP
                      </span>
                    <?php else: ?>
                      <span class="text-muted font-weight-normal">0</span>
                    <?php endif; ?>
                  </td>
                  <td class="text-center font-weight-bold text-dark">
                    <?= floatval($row['present_days']) ?>
                  </td>
                  <td class="text-center">
                    <span class="text-info font-weight-bold"><?= floatval($row['wfh_days']) ?></span>
                  </td>
                  <td class="text-center">
                    <span class="text-secondary"><?= floatval($row['leave_days']) ?></span>
                  </td>
                  <td class="text-center text-muted">
                    <?= floatval($row['holiday_days']) + floatval($row['weekly_off_days']) ?>
                  </td>
                  <td class="text-center">
                    <?php $late = intval($row['late_count']); ?>
                    <?php if ($late > 0): ?>
                      <span class="badge badge-pill-soft badge-soft-warning font-weight-bold"><?= $late ?></span>
                    <?php else: ?>
                      <span class="text-muted">0</span>
                    <?php endif; ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else : ?>
              <tr>
                <td colspan="10" class="text-center py-5">
                  <div class="py-4">
                    <?php if (!empty($rawPunches) && $rawPunches > 0) : ?>
                      <div class="mb-3" style="width: 64px; height: 64px; border-radius: 50%; background: #ecfdf5; color: #10b981; display: inline-flex; align-items: center; justify-content: center; font-size: 26px;">
                        <i class="fas fa-calculator"></i>
                      </div>
                      <h5 class="font-weight-bold text-dark mb-1">Payroll Attendance Not Generated Yet</h5>
                      <p class="text-muted small mb-2" style="max-width: 540px; margin: 0 auto;">
                        Raw punch logs exist in <code>attendance</code> for <strong><?= esc($monthName) ?> <?= esc($selectedYear) ?></strong>:
                        <span class="badge badge-success px-2 py-1"><?= number_format($rawPunches ?? 0) ?> punch logs</span> across <strong><?= $rawEmps ?? 0 ?> employees</strong>.
                      </p>
                      <p class="text-muted small mb-4">Click below to calculate payable days, present days, and unpaid absent deductions (LOP) for all active staff.</p>
                      <button type="button" class="btn btn-att-success px-4 py-2 font-weight-bold shadow-sm" id="btnGenEmpty" onclick="recalculateAttendance()">
                        <i class="fas fa-magic mr-1"></i> Generate Attendance for <?= esc($monthName) ?> <?= esc($selectedYear) ?>
                      </button>
                    <?php else : ?>
                      <div class="mb-3" style="width: 64px; height: 64px; border-radius: 50%; background: #fef2f2; color: #ef4444; display: inline-flex; align-items: center; justify-content: center; font-size: 24px;">
                        <i class="fas fa-calendar-times"></i>
                      </div>
                      <h5 class="font-weight-bold text-dark mb-1">No Attendance Punch Records Found</h5>
                      <p class="text-muted small mb-3">No punches or attendance logs found in the attendance table for <?= esc($monthName) ?> <?= esc($selectedYear) ?> (<?= date('d M', strtotime($periodStart)) ?> to <?= date('d M Y', strtotime($periodEnd)) ?>).</p>
                      <a href="<?= base_url('admin/payroll_attendance?month=2&year=2026') ?>" class="btn btn-att-primary px-3 mr-2">
                        <i class="fas fa-calendar-alt mr-1"></i> February 2026
                      </a>
                      <a href="<?= base_url('admin/payroll_attendance?month=8&year=2026') ?>" class="btn btn-light border px-3">
                        <i class="fas fa-calendar-alt mr-1"></i> August 2026
                      </a>
                    <?php endif; ?>
                  </div>
                </td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>

  </div>
</div>

<!-- Modal: Generate Payroll Cycle from Attendance -->
<div class="modal fade" id="generateCycleModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content border-0 shadow-lg" style="border-radius: 18px; overflow: hidden;">
      <form action="<?= base_url('admin/payroll/create') ?>" method="POST">
        <input type="hidden" name="payroll_month" value="<?= $selectedMonth ?>">
        <input type="hidden" name="payroll_year" value="<?= $selectedYear ?>">

        <div class="modal-header text-white px-4 py-3" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); border: none;">
          <div>
            <h5 class="modal-title font-weight-bold text-white mb-0">
              <i class="fas fa-calculator text-success mr-2"></i> Generate Payroll Cycle
            </h5>
            <small class="text-light opacity-75">Automated payroll calculation with finalized attendance</small>
          </div>
          <button type="button" class="close text-white" data-dismiss="modal" style="opacity: 0.9;">&times;</button>
        </div>

        <div class="modal-body p-4 bg-white">
          <div class="p-3 mb-3 rounded-lg" style="background: #ecfdf5; border: 1px solid #a7f3d0; border-radius: 12px;">
            <div class="d-flex align-items-center mb-1">
              <i class="fas fa-check-circle text-success fa-lg mr-2"></i>
              <span class="text-success font-weight-bold">Attendance Finalized &amp; Verified</span>
            </div>
            <div class="text-dark small">
              <?= count($records) ?> employee records ready. Working days, paid days, and unpaid absent days (LOP) will automatically compute gross and net salaries.
            </div>
          </div>

          <div class="form-group">
            <label class="font-weight-bold text-dark small text-uppercase">Cycle Code / Name <span class="text-danger">*</span></label>
            <input type="text" name="payroll_code" class="form-control" style="border-radius: 8px;" required value="<?= esc($cycleCode) ?>">
          </div>

          <div class="form-row">
            <div class="form-group col-md-6">
              <label class="font-weight-bold text-dark small text-uppercase">Period Start Date <span class="text-danger">*</span></label>
              <input type="date" name="period_start" class="form-control" style="border-radius: 8px;" required value="<?= esc($periodStart) ?>">
            </div>
            <div class="form-group col-md-6">
              <label class="font-weight-bold text-dark small text-uppercase">Period End Date <span class="text-danger">*</span></label>
              <input type="date" name="period_end" class="form-control" style="border-radius: 8px;" required value="<?= esc($periodEnd) ?>">
            </div>
          </div>

          <div class="form-group mb-0">
            <label class="font-weight-bold text-dark small text-uppercase">Expected Payout Date</label>
            <input type="date" name="pay_date" class="form-control" style="border-radius: 8px;" value="<?= esc($payDate) ?>">
          </div>
        </div>

        <div class="modal-footer px-4 py-3 bg-light border-0 d-flex justify-content-between">
          <button type="button" class="btn btn-secondary px-3" data-dismiss="modal" style="border-radius: 8px; font-weight: 600;">Cancel</button>
          <button type="submit" class="btn btn-att-success px-4">
            <i class="fas fa-play mr-1"></i> Generate &amp; Calculate Cycle
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- DataTables & Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
<script>
  $(document).ready(function() {
    $('#payrollAttendanceTable').DataTable({
      "pageLength": 25,
      "ordering": true,
      "language": {
        "search": "Quick Search Staff:",
        "lengthMenu": "Show _MENU_ employees per page",
        "info": "Displaying _START_ to _END_ of _TOTAL_ employees"
      }
    });

    $('#finalizeBtn').on('click', function() {
      if (confirm("Are you sure you want to finalize attendance for <?= esc($monthName) ?> <?= esc($selectedYear) ?>? This action cannot be undone.")) {
        $.ajax({
          url: '<?= base_url('admin/finalize_payroll_attendance') ?>',
          type: 'POST',
          data: {
            month: '<?= $selectedMonth ?>',
            year: '<?= $selectedYear ?>',
            <?= csrf_token() ?>: '<?= csrf_hash() ?>'
          },
          success: function(res) {
            if (res.status === 'Y') {
              alert(res.message);
              location.reload();
            } else {
              alert(res.message);
            }
          },
          error: function() {
            alert('An error occurred while finalizing attendance.');
          }
        });
      }
    });
  });

  function recalculateAttendance() {
    var btns = $('#btnRecalcBanner, #btnGenBanner, #btnGenEmpty');
    btns.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Generating Attendance...');

    $.ajax({
      url: '<?= base_url('admin/generate_payroll_attendance') ?>',
      type: 'POST',
      data: {
        month: '<?= $selectedMonth ?>',
        year: '<?= $selectedYear ?>',
        <?= csrf_token() ?>: '<?= csrf_hash() ?>'
      },
      dataType: 'json',
      success: function(res) {
        if (res.status === 'FINALIZED') {
          alert(res.message);
          btns.prop('disabled', false).html('<i class="fas fa-lock mr-1"></i> Attendance Finalized');
        } else if (res.status === 'Y') {
          alert(res.message);
          location.reload();
        } else {
          alert(res.message || 'Failed to generate attendance.');
          btns.prop('disabled', false).html('<i class="fas fa-calculator mr-1"></i> Generate Attendance');
        }
      },
      error: function(xhr) {
        alert('Server error: ' + (xhr.responseText || 'Unknown error'));
        btns.prop('disabled', false).html('<i class="fas fa-calculator mr-1"></i> Generate Attendance');
      }
    });
  }
</script>
