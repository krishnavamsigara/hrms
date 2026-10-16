<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bloom Solutions | Attendance Overview</title>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">

  <style>
    :root {
      --bloom-purple: #4a00e0;
      --bloom-purple-light: #eef2ff;
      --bloom-dark: #120038;
      --bloom-success: #10b981;
      --bloom-danger: #dc2626;
      --bloom-warning: #f59e0b;
      --bloom-blue: #2563eb;
      --slate-50: #f8fafc;
      --slate-100: #f1f5f9;
      --slate-200: #e2e8f0;
      --slate-300: #cbd5e1;
      --slate-400: #94a3b8;
      --slate-500: #64748b;
      --slate-600: #475569;
      --slate-700: #334155;
      --slate-800: #1e293b;
      --slate-900: #0f172a;
    }

    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      background-color: var(--slate-50);
      font-size: 13px;
      color: var(--slate-700);
    }

    .content-wrapper {
      background-color: var(--slate-50);
      padding-bottom: 30px !important;
    }

    .page-title {
      font-size: 22px;
      font-weight: 800;
      color: var(--slate-900);
      margin-bottom: 2px;
    }

    .page-subtitle {
      font-size: 12px;
      color: var(--slate-500);
      margin-bottom: 0;
    }

    /* Annual Matrix Card */
    .matrix-card {
      background: #ffffff;
      border: 1px solid var(--slate-200);
      border-radius: 16px;
      padding: 18px 20px;
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
      margin-bottom: 20px;
    }

    .matrix-grid {
      display: grid;
      grid-template-columns: repeat(12, minmax(0, 1fr));
      gap: 10px;
    }

    @media (max-width: 1200px) {
      .matrix-grid {
        grid-template-columns: repeat(6, minmax(0, 1fr));
      }
    }

    @media (max-width: 768px) {
      .matrix-grid {
        grid-template-columns: repeat(3, minmax(0, 1fr));
      }
    }

    .month-cell {
      background: #ffffff;
      border: 1px solid var(--slate-200);
      border-radius: 12px;
      padding: 10px 8px;
      text-align: center;
      transition: all 0.2s ease;
      text-decoration: none !important;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      min-height: 110px;
      position: relative;
    }

    .month-cell:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
      border-color: var(--bloom-purple);
    }

    .month-cell.active-month {
      border: 2px solid var(--bloom-purple);
      background: #fbf9ff;
      box-shadow: 0 0 0 3px rgba(74, 0, 224, 0.12);
    }

    .month-cell .m-name {
      font-size: 13px;
      font-weight: 800;
      color: var(--slate-800);
      margin-bottom: 4px;
    }

    .month-cell.active-month .m-name {
      color: var(--bloom-purple);
    }

    .badge-soft-success {
      background: #d1fae5;
      color: #065f46;
      border: 1px solid #a7f3d0;
      font-size: 10px;
      font-weight: 700;
      padding: 2px 6px;
      border-radius: 6px;
    }

    .badge-soft-warning {
      background: #fef3c7;
      color: #92400e;
      border: 1px solid #fde68a;
      font-size: 10px;
      font-weight: 700;
      padding: 2px 6px;
      border-radius: 6px;
    }

    .badge-soft-gray {
      background: #f1f5f9;
      color: #64748b;
      border: 1px solid #e2e8f0;
      font-size: 10px;
      font-weight: 600;
      padding: 2px 6px;
      border-radius: 6px;
    }

    /* KPI Summary Cards */
    .kpi-row {
      margin-bottom: 20px;
    }

    .kpi-card {
      background: #ffffff;
      border: 1px solid var(--slate-200);
      border-radius: 14px;
      padding: 14px 18px;
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
      height: 100%;
      display: flex;
      align-items: center;
      gap: 14px;
    }

    .kpi-icon-wrap {
      width: 44px;
      height: 44px;
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 18px;
      flex-shrink: 0;
    }

    .kpi-title {
      font-size: 11px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      color: var(--slate-400);
      margin-bottom: 2px;
    }

    .kpi-val {
      font-size: 18px;
      font-weight: 800;
      color: var(--slate-900);
      line-height: 1.2;
    }

    .kpi-sub {
      font-size: 11px;
      color: var(--slate-500);
      margin-top: 2px;
    }

    /* Filter Card */
    .filter-card {
      background: #ffffff;
      border: 1px solid var(--slate-200);
      border-radius: 16px;
      padding: 16px 20px;
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
      margin-bottom: 20px;
    }

    .filter-input {
      border: 1px solid var(--slate-200);
      border-radius: 10px;
      height: 38px;
      font-size: 12px;
      font-weight: 500;
      color: var(--slate-700);
      background-color: #ffffff;
      padding: 0 12px;
      transition: all 0.2s ease;
    }

    .filter-input:focus {
      border-color: var(--bloom-purple);
      box-shadow: 0 0 0 3px rgba(74, 0, 224, 0.1);
      outline: none;
    }

    /* Table Card */
    .ts-card {
      background: #ffffff;
      border: 1px solid var(--slate-200);
      border-radius: 16px;
      padding: 20px;
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
      margin-bottom: 20px;
    }

    .emp-avatar-sm {
      width: 36px;
      height: 36px;
      border-radius: 50%;
      background: var(--bloom-purple-light);
      color: var(--bloom-purple);
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 700;
      font-size: 13px;
    }

    .emp-id-badge {
      background: var(--bloom-purple-light);
      color: var(--bloom-purple);
      font-weight: 700;
      font-size: 11px;
      padding: 3px 8px;
      border-radius: 6px;
    }

    .table-overview thead th {
      background-color: #f8fafc;
      color: var(--slate-500);
      font-size: 11px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      border-bottom: 1px solid var(--slate-200);
      padding: 12px 16px;
    }

    .table-overview tbody td {
      padding: 14px 16px;
      vertical-align: middle;
      font-size: 13px;
      border-bottom: 1px solid var(--slate-100);
    }

    .table-overview tbody tr:hover {
      background-color: #f8fafc;
    }

    .btn-view-ts {
      background: linear-gradient(135deg, #4a00e0 0%, #2a0080 100%);
      color: #ffffff;
      border: none;
      font-weight: 600;
      font-size: 12px;
      padding: 7px 14px;
      border-radius: 8px;
      transition: all 0.2s ease;
      display: inline-flex;
      align-items: center;
      gap: 6px;
    }

    .btn-view-ts:hover {
      color: #ffffff;
      transform: translateY(-1px);
      box-shadow: 0 4px 10px rgba(74, 0, 224, 0.25);
    }
  </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <div class="content-wrapper">
      <div class="content-header pt-4 pb-2">
        <div class="container-fluid">
          
          <!-- Top Header -->
          <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-3">
            <div>
              <h1 class="page-title">Employee Attendance Overview</h1>
              <p class="page-subtitle">Monthly timesheets, raw punch verification, and payroll attendance synchronization</p>
            </div>
            <div class="d-flex align-items-center flex-wrap gap-2">
              <span class="badge badge-light border px-3 py-2 text-dark font-weight-bold" style="font-size:12px;">
                <i class="far fa-calendar-alt text-primary mr-1"></i> Pay Cycle: <?= date('d M', strtotime($cycleStartDate ?? '2026-01-25')) ?> - <?= date('d M Y', strtotime($cycleEndDate ?? '2026-02-24')) ?>
              </span>

              <?php if (!empty($isFinalized)) : ?>
                <span class="badge badge-success px-3 py-2 shadow-sm font-weight-bold" style="font-size:12px;">
                  <i class="fas fa-lock mr-1"></i> Payroll Attendance: Finalized
                </span>
              <?php elseif (!empty($payrollGenerated)) : ?>
                <span class="badge badge-warning px-3 py-2 shadow-sm text-dark font-weight-bold" style="font-size:12px;">
                  <i class="fas fa-clock mr-1"></i> Payroll Attendance: Generated (Draft)
                </span>
              <?php else : ?>
                <span class="badge badge-light border px-3 py-2 text-muted shadow-sm font-weight-bold" style="font-size:12px;">
                  <i class="fas fa-circle-notch mr-1"></i> Payroll Attendance: Not Generated
                </span>
              <?php endif; ?>
            </div>
          </div>

          <!-- Annual Attendance & Payroll Availability (Jan - Dec) Matrix -->
          <div class="matrix-card">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
              <div>
                <strong class="text-dark" style="font-size:14px;">
                  <i class="fas fa-calendar-check text-primary mr-1"></i> <?= $selectedYear ?> Annual Attendance & Payroll Matrix (All 12 Months)
                </strong>
                <span class="text-muted ml-2" style="font-size:11px;">
                  Check attendance table punches and payroll sync status across the year. Click any month to view.
                </span>
              </div>
              <div class="d-flex align-items-center gap-1 flex-wrap">
                <span class="badge badge-soft-success">
                  <i class="fas fa-check-circle mr-1"></i> <?= $yearStats['available_months'] ?? 0 ?> Full Available
                </span>
                <span class="badge badge-soft-warning">
                  <i class="fas fa-clock mr-1"></i> <?= $yearStats['partial_months'] ?? 0 ?> Partial / In-Progress
                </span>
                <span class="badge badge-soft-gray">
                  <i class="fas fa-calendar-times mr-1"></i> <?= $yearStats['no_data_months'] ?? 0 ?> Upcoming / No Logs
                </span>
                <span class="badge badge-light border text-dark font-weight-bold">
                  <i class="fas fa-lock text-success mr-1"></i> <?= $yearStats['finalized_months'] ?? 0 ?> Finalized
                </span>
              </div>
            </div>

            <!-- 12-Month Matrix Grid -->
            <div class="matrix-grid">
              <?php if (!empty($yearMatrix)) : ?>
                <?php foreach ($yearMatrix as $m) : ?>
                  <?php
                    $isAct = !empty($m['is_current']);
                    $cellClass = 'month-cell' . ($isAct ? ' active-month' : '');
                  ?>
                  <a href="<?= base_url('admin/attendance_overview?month=' . $m['month'] . '&year=' . $selectedYear) ?>" class="<?= $cellClass ?>" title="<?= esc($m['full_name']) ?> (<?= date('d M', strtotime($m['start_date'])) ?> to <?= date('d M', strtotime($m['end_date'])) ?>)">
                    <div>
                      <div class="d-flex align-items-center justify-content-between">
                        <span class="m-name"><?= esc($m['name']) ?></span>
                        <?php if ($isAct) : ?>
                          <span class="badge badge-primary px-1" style="font-size:9px; background:var(--bloom-purple);">Current</span>
                        <?php endif; ?>
                      </div>

                      <!-- Raw Attendance Status from attendance table -->
                      <div class="my-1">
                        <?php if ($m['raw_status'] === 'full') : ?>
                          <span class="badge-soft-success d-inline-block w-100 text-truncate" title="<?= number_format($m['raw_count']) ?> punch logs">
                            <i class="fas fa-check mr-1"></i><?= number_format($m['raw_count']) ?> logs
                          </span>
                        <?php elseif ($m['raw_status'] === 'partial') : ?>
                          <span class="badge-soft-warning d-inline-block w-100 text-truncate" title="<?= number_format($m['raw_count']) ?> punch logs">
                            <i class="fas fa-exclamation-triangle mr-1"></i><?= number_format($m['raw_count']) ?> logs
                          </span>
                        <?php else : ?>
                          <span class="badge-soft-gray d-inline-block w-100 text-truncate">
                            No Logs
                          </span>
                        <?php endif; ?>
                      </div>

                      <?php if ($m['emp_count'] > 0) : ?>
                        <small class="text-muted d-block" style="font-size:10px;">
                          <?= $m['emp_count'] ?> active emps
                        </small>
                      <?php endif; ?>
                    </div>

                    <!-- Payroll Attendance Status -->
                    <div class="mt-2">
                      <?php if ($m['payroll_status'] === 'finalized') : ?>
                        <span class="badge badge-success w-100 py-1" style="font-size:10px; font-weight:700;">
                          <i class="fas fa-lock"></i> Finalized
                        </span>
                      <?php elseif ($m['payroll_status'] === 'draft') : ?>
                        <span class="badge badge-warning text-dark w-100 py-1" style="font-size:10px; font-weight:700;">
                          <i class="fas fa-sync-alt"></i> Draft
                        </span>
                      <?php else : ?>
                        <span class="badge badge-light border text-muted w-100 py-1" style="font-size:10px;">
                          Unsaved
                        </span>
                      <?php endif; ?>
                    </div>
                  </a>
                <?php endforeach; ?>
              <?php endif; ?>
            </div>
          </div>

          <!-- Quick KPI Bar for Selected Month -->
          <div class="row kpi-row">
            <div class="col-md-3 col-sm-6 mb-3 mb-md-0">
              <div class="kpi-card">
                <div class="kpi-icon-wrap" style="background:#eef2ff; color:#4a00e0;">
                  <i class="fas fa-fingerprint"></i>
                </div>
                <div>
                  <div class="kpi-title">Raw Attendance Logs</div>
                  <div class="kpi-val"><?= number_format($monthRawStats['total_punches'] ?? 0) ?></div>
                  <div class="kpi-sub">
                    <i class="fas fa-user-check text-success mr-1"></i><?= $monthRawStats['active_punched_emps'] ?? 0 ?> employees punched
                  </div>
                </div>
              </div>
            </div>

            <div class="col-md-3 col-sm-6 mb-3 mb-md-0">
              <div class="kpi-card">
                <div class="kpi-icon-wrap" style="background:#ecfdf5; color:#10b981;">
                  <i class="fas fa-calendar-day"></i>
                </div>
                <div>
                  <div class="kpi-title">Attendance Table Status</div>
                  <div class="kpi-val" style="font-size:15px; color:#10b981;">
                    <?php if (($monthRawStats['total_punches'] ?? 0) >= 2500) : ?>
                      <i class="fas fa-check-circle"></i> Full Month Ready
                    <?php elseif (($monthRawStats['total_punches'] ?? 0) > 0) : ?>
                      <i class="fas fa-clock text-warning"></i> Partial / In-Progress
                    <?php else : ?>
                      <i class="fas fa-times-circle text-muted"></i> No Punch Logs
                    <?php endif; ?>
                  </div>
                  <div class="kpi-sub">
                    <?= esc($monthRawStats['present_count'] ?? 0) ?> Present &bull; <?= esc($monthRawStats['wfh_count'] ?? 0) ?> WFH &bull; <?= esc($monthRawStats['leave_count'] ?? 0) ?> Leaves
                  </div>
                </div>
              </div>
            </div>

            <div class="col-md-3 col-sm-6 mb-3 mb-md-0">
              <div class="kpi-card">
                <div class="kpi-icon-wrap" style="background:#fffbeb; color:#f59e0b;">
                  <i class="fas fa-file-invoice-dollar"></i>
                </div>
                <div>
                  <div class="kpi-title">Payroll Sync State</div>
                  <div class="kpi-val" style="font-size:15px;">
                    <?php if (!empty($isFinalized)) : ?>
                      <span class="text-success"><i class="fas fa-lock mr-1"></i>Finalized</span>
                    <?php elseif (!empty($payrollGenerated)) : ?>
                      <span class="text-warning"><i class="fas fa-sync-alt mr-1"></i>Draft (Updateable)</span>
                    <?php else : ?>
                      <span class="text-muted"><i class="fas fa-minus-circle mr-1"></i>Not Saved Yet</span>
                    <?php endif; ?>
                  </div>
                  <div class="kpi-sub">
                    <?php if (!empty($currentPayrollSummary)) : ?>
                      <?= $currentPayrollSummary['emp_count'] ?? 0 ?> Emps &bull; <?= number_format($currentPayrollSummary['total_paid'] ?? 0, 0) ?> Paid Days
                    <?php else : ?>
                      Click save to generate summary
                    <?php endif; ?>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-md-3 col-sm-6">
              <div class="kpi-card">
                <div class="kpi-icon-wrap" style="background:#f8fafc; color:#64748b; border:1px solid #e2e8f0;">
                  <i class="fas fa-calendar-alt"></i>
                </div>
                <div>
                  <div class="kpi-title">Cut-off Cycle Period</div>
                  <div class="kpi-val" style="font-size:14px;">
                    <?= date('d M', strtotime($cycleStartDate ?? '2026-01-25')) ?> &rarr; <?= date('d M', strtotime($cycleEndDate ?? '2026-02-24')) ?>
                  </div>
                  <div class="kpi-sub">
                    <?= date('F Y', mktime(0, 0, 0, $selectedMonth, 10, $selectedYear)) ?>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Filter & Action Bar -->
          <div class="filter-card">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
              <form method="get" action="<?= base_url('admin/attendance_overview') ?>" class="row align-items-center gy-2 gx-3 flex-grow-1">
                <div class="col-auto">
                  <label class="sr-only">Month</label>
                  <select name="month" class="form-control filter-input">
                    <?php
                    $months = [
                      1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
                      5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
                      9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
                    ];
                    foreach ($months as $mNum => $mName) {
                      $sel = ($selectedMonth == $mNum) ? 'selected' : '';
                      echo "<option value=\"$mNum\" $sel>$mName</option>";
                    }
                    ?>
                  </select>
                </div>

                <div class="col-auto">
                  <label class="sr-only">Year</label>
                  <select name="year" class="form-control filter-input">
                    <?php
                    $currY = (int)date('Y');
                    for ($y = $currY - 2; $y <= $currY + 1; $y++) {
                      $sel = ($selectedYear == $y) ? 'selected' : '';
                      echo "<option value=\"$y\" $sel>$y</option>";
                    }
                    ?>
                  </select>
                </div>

                <div class="col-auto">
                  <label class="sr-only">Search</label>
                  <input type="text" name="search" class="form-control filter-input" placeholder="Search by EMP ID or Name..." value="<?= esc($search ?? '') ?>">
                </div>

                <div class="col-auto">
                  <button type="submit" class="btn btn-primary font-weight-bold px-3" style="height:38px; border-radius:10px; background:var(--bloom-purple); border:none;">
                    <i class="fas fa-filter mr-1"></i> Filter
                  </button>
                  <a href="<?= base_url('admin/attendance_overview') ?>" class="btn btn-light border font-weight-bold px-3 ml-1" style="height:38px; border-radius:10px;">
                    <i class="fas fa-redo mr-1"></i> Reset
                  </a>
                </div>
              </form>

              <!-- Dynamic Action Button based on Payroll Attendance Status -->
              <div class="col-auto ml-auto pl-0">
                <?php if (!empty($isFinalized)) : ?>
                  <button type="button" class="btn btn-secondary font-weight-bold px-3 shadow-sm" style="height:38px; border-radius:10px;" onclick="showFinalizedNotice()">
                    <i class="fas fa-lock mr-1"></i> Attendance Finalized
                  </button>
                <?php elseif (!empty($payrollGenerated)) : ?>
                  <button type="button" class="btn btn-warning font-weight-bold text-dark px-3 shadow-sm" style="height:38px; border-radius:10px; background:#f59e0b; border:none;" onclick="openPayrollModal('update')">
                    <i class="fas fa-sync-alt mr-1"></i> Update Attendance for Payroll
                  </button>
                <?php else : ?>
                  <button type="button" class="btn btn-success font-weight-bold px-3 shadow-sm" style="height:38px; border-radius:10px; background:#10b981; border:none;" onclick="openPayrollModal('generate')">
                    <i class="fas fa-calculator mr-1"></i> Save Attendance for Payroll
                  </button>
                <?php endif; ?>
              </div>
            </div>
          </div>

          <!-- Main Table Card -->
          <div class="ts-card p-0 overflow-hidden">
            <div class="table-responsive">
              <table id="overviewTable" class="table table-overview mb-0">
                <thead>
                  <tr>
                    <th>Emp ID</th>
                    <th>Employee Name</th>
                    <th>Department</th>
                    <th>Designation</th>
                    <th class="text-center">Present Days</th>
                    <th class="text-center">Total Worked Hours</th>
                    <th class="text-right">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (!empty($employees)) : ?>
                    <?php foreach ($employees as $emp) : ?>
                      <tr>
                        <td>
                          <span class="emp-id-badge"><?= esc($emp['emp_id']) ?></span>
                        </td>
                        <td>
                          <div class="d-flex align-items-center gap-2">
                            <div class="emp-avatar-sm mr-2">
                              <?= strtoupper(substr($emp['emp_name'] ?? 'E', 0, 1)) ?>
                            </div>
                            <div>
                              <strong class="text-dark d-block"><?= esc($emp['emp_name']) ?></strong>
                              <small class="text-muted"><?= esc($emp['email'] ?? 'N/A') ?></small>
                            </div>
                          </div>
                        </td>
                        <td><?= esc($emp['department_name'] ?? 'General') ?></td>
                        <td><?= esc($emp['designation_name'] ?? 'Employee') ?></td>
                        <td class="text-center">
                          <span class="badge badge-success px-2 py-1" style="font-size:12px; font-weight:700;">
                            <?= esc($emp['total_present'] ?? 0) ?> Days
                          </span>
                        </td>
                        <td class="text-center">
                          <span class="badge badge-light border px-2 py-1 text-dark" style="font-size:12px; font-weight:700;">
                            <?= esc($emp['total_hours_fmt'] ?? '00h 00m') ?>
                          </span>
                        </td>
                        <td class="text-right">
                          <a href="<?= base_url('admin/attendance_details?emp_id=' . urlencode($emp['emp_id']) . '&month=' . $selectedMonth . '&year=' . $selectedYear) ?>"
                             class="btn-view-ts" title="View Full Timesheet">
                            <i class="fas fa-calendar-alt"></i> View Timesheet
                          </a>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  <?php else : ?>
                    <tr>
                      <td colspan="7" class="text-center py-4 text-muted">No employee records found for this period.</td>
                    </tr>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>

  <!-- Payroll Generation / Update Modal -->
  <div class="modal fade" id="payrollModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content" style="border-radius: 16px; border:none; box-shadow:0 10px 30px rgba(0,0,0,0.15);">
        <div class="modal-header border-bottom">
          <h5 class="modal-title font-weight-bold text-dark" id="modalTitle">
            <i class="fas fa-calculator text-success mr-1"></i> Generate Payroll Attendance
          </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body text-center p-4">
          <div id="modalBodyIcon" class="mb-3">
            <div style="width:54px; height:54px; border-radius:50%; background:#d1fae5; color:#10b981; display:inline-flex; align-items:center; justify-content:center; font-size:24px;">
              <i class="fas fa-calculator"></i>
            </div>
          </div>
          <p class="text-dark mb-2" id="modalPrompt" style="font-size:14px; font-weight:600;">
            Are you sure you want to calculate and save attendance for 
            <strong><?= date('F Y', mktime(0, 0, 0, $selectedMonth, 10, $selectedYear)) ?></strong>?
          </p>
          <p class="text-muted mb-4" id="modalSubText" style="font-size:12px;">
            This will calculate payable and unpaid days for all active employees from 
            <strong><?= date('d M', strtotime($cycleStartDate ?? '2026-01-25')) ?></strong> to 
            <strong><?= date('d M Y', strtotime($cycleEndDate ?? '2026-02-24')) ?></strong>.
          </p>
          
          <button type="button" class="btn btn-light border font-weight-bold px-4 py-2 mr-2" data-dismiss="modal" style="border-radius:10px;">Cancel</button>
          <button type="button" class="btn btn-primary font-weight-bold px-4 py-2" id="btnRunPayroll" onclick="generatePayrollAttendance()" style="border-radius:10px; background:#10b981; border:none;">
            Yes, Save Attendance Data
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Already Finalized Modal Notice -->
  <div class="modal fade" id="finalizedNoticeModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content" style="border-radius: 16px; border:none; box-shadow:0 10px 30px rgba(0,0,0,0.15);">
        <div class="modal-header border-bottom">
          <h5 class="modal-title font-weight-bold text-dark">
            <i class="fas fa-lock text-success mr-2"></i> Attendance Already Finalized
          </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body text-center p-4">
          <div style="width:54px; height:54px; border-radius:50%; background:#ecfdf5; color:#10b981; display:inline-flex; align-items:center; justify-content:center; font-size:24px; margin-bottom:14px;">
            <i class="fas fa-shield-alt"></i>
          </div>
          <h6 class="font-weight-bold text-dark mb-2">Month Locked for Payroll Processing</h6>
          <p class="text-muted mb-4" style="font-size:13px;">
            The payroll attendance summary for <strong><?= date('F Y', mktime(0, 0, 0, $selectedMonth, 10, $selectedYear)) ?></strong> has already been <strong>FINALIZED</strong>.<br>
            To maintain audit integrity and prevent salary calculation discrepancies, finalized attendance cannot be modified or regenerated.
          </p>
          <button type="button" class="btn btn-secondary font-weight-bold px-4 py-2" data-dismiss="modal" style="border-radius:10px;">
            Close
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Toast Notification -->
  <div id="payrollToast" style="position:fixed; bottom:28px; right:28px; min-width:320px; max-width:440px; z-index:99999; border-radius:14px; padding:14px 18px; font-size:13px; font-weight:600; box-shadow:0 8px 30px rgba(0,0,0,0.18); display:none; align-items:center; gap:10px;">
    <i id="pToastIcon" class="fas fa-check-circle" style="font-size:18px;"></i>
    <span id="pToastMsg">Saved.</span>
    <button onclick="$('#payrollToast').hide()" style="margin-left:auto; background:none; border:none; cursor:pointer; font-size:16px; opacity:0.6;">&#x2715;</button>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>

  <script>
    var currentAction = '<?= !empty($payrollGenerated) ? 'update' : 'generate' ?>';
    var isMonthFinalized = <?= !empty($isFinalized) ? 'true' : 'false' ?>;

    $(document).ready(function () {
      $('#overviewTable').DataTable({
        "pageLength": 15,
        "ordering": true,
        "language": {
          "search": "Quick Filter Table:"
        }
      });
    });

    function showFinalizedNotice() {
      $('#finalizedNoticeModal').modal('show');
    }

    function openPayrollModal(action) {
      currentAction = action;
      if (isMonthFinalized) {
        showFinalizedNotice();
        return;
      }

      if (action === 'update') {
        $('#modalTitle').html('<i class="fas fa-sync-alt text-warning mr-1"></i> Update Attendance for Payroll');
        $('#modalBodyIcon').html('<div style="width:54px; height:54px; border-radius:50%; background:#fef3c7; color:#f59e0b; display:inline-flex; align-items:center; justify-content:center; font-size:24px;"><i class="fas fa-sync-alt"></i></div>');
        $('#modalPrompt').html('Attendance is already generated for <strong><?= date('F Y', mktime(0, 0, 0, $selectedMonth, 10, $selectedYear)) ?></strong> and not finalized.');
        $('#modalSubText').html('Clicking update will re-scan the <code>attendance</code> punches and <strong>UPDATE all columns</strong> (Present days, WFH, leaves, absent days, paid/unpaid days) with the latest numbers.');
        $('#btnRunPayroll').text('Yes, Update Attendance Columns').css({background: '#f59e0b', color: '#111827'});
      } else {
        $('#modalTitle').html('<i class="fas fa-calculator text-success mr-1"></i> Save Attendance for Payroll');
        $('#modalBodyIcon').html('<div style="width:54px; height:54px; border-radius:50%; background:#d1fae5; color:#10b981; display:inline-flex; align-items:center; justify-content:center; font-size:24px;"><i class="fas fa-calculator"></i></div>');
        $('#modalPrompt').html('Calculate and save attendance summary for <strong><?= date('F Y', mktime(0, 0, 0, $selectedMonth, 10, $selectedYear)) ?></strong>?');
        $('#modalSubText').html('This will calculate payable and unpaid days for all active employees from <strong><?= date('d M', strtotime($cycleStartDate ?? '2026-01-25')) ?></strong> to <strong><?= date('d M Y', strtotime($cycleEndDate ?? '2026-02-24')) ?></strong>.');
        $('#btnRunPayroll').text('Yes, Generate Payroll Data').css({background: '#10b981', color: '#ffffff'});
      }

      $('#payrollModal').modal('show');
    }

    function generatePayrollAttendance() {
      var btn = $('#btnRunPayroll');
      var origHtml = btn.html();
      btn.html('<i class="fas fa-spinner fa-spin mr-1"></i> ' + (currentAction === 'update' ? 'Updating Columns...' : 'Generating Data...')).prop('disabled', true);

      $.ajax({
        url: '<?= base_url('admin/generate_payroll_attendance') ?>',
        type: 'POST',
        data: {
          month: <?= $selectedMonth ?>,
          year: <?= $selectedYear ?>,
          <?= csrf_token() ?>: '<?= csrf_hash() ?>'
        },
        dataType: 'json',
        success: function(res) {
          btn.html(origHtml).prop('disabled', false);
          $('#payrollModal').modal('hide');

          if (res.status === 'FINALIZED' || res.is_finalized) {
            isMonthFinalized = true;
            showPToast(res.message, false);
            setTimeout(function() {
              showFinalizedNotice();
            }, 600);
          } else if (res.status === 'Y') {
            showPToast(res.message, true);
            // Refresh page after 1.2s to show updated columns and matrix badges
            setTimeout(function() {
              location.reload();
            }, 1200);
          } else {
            showPToast(res.message || 'Failed to process attendance.', false);
          }
        },
        error: function(xhr) {
          btn.html(origHtml).prop('disabled', false);
          $('#payrollModal').modal('hide');
          showPToast('Server error: ' + (xhr.responseText || 'Unknown error'), false);
        }
      });
    }

    function showPToast(msg, success) {
      var $t = $('#payrollToast');
      $t.css({
        background: success ? '#d1fae5' : '#fee2e2',
        color: success ? '#065f46' : '#991b1b',
        border: success ? '1px solid #6ee7b7' : '1px solid #fca5a5'
      });
      $('#pToastMsg').text(msg);
      $('#pToastIcon').attr('class', success ? 'fas fa-check-circle' : 'fas fa-exclamation-circle');
      $t.css('display', 'flex');
      setTimeout(function(){ $t.hide(); }, 6000);
    }
  </script>
</body>

</html>
