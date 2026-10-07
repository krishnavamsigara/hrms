<?php
$attend = isset($attend['emp_id']) ? $attend : ($attend[0] ?? []);

$calculatedTotalHours = 0;
$calculatedWorkedDays = 0;

if (!empty($attendance)) {
    foreach ($attendance as $row) {
        $st = strtoupper(trim($row['attendance_status'] ?? $row['status'] ?? ''));
        if (in_array($st, ['PRESENT', 'WFH', 'LATE'])) {
            $calculatedWorkedDays++;
        }
        $th = $row['total_hours'] ?? $row['daily_time_formatted'] ?? '';
        if (!empty($th) && $th !== '-') {
            $parts = explode(':', $th);
            if (count($parts) >= 2) {
                $calculatedTotalHours += (int)$parts[0] + ((int)$parts[1] / 60);
            }
        } elseif (!empty($row['punch_in']) && !empty($row['punch_out']) && $row['punch_in'] != '-' && $row['punch_out'] != '-') {
            $inTs  = strtotime($row['punch_in']);
            $outTs = strtotime($row['punch_out']);
            if ($outTs > $inTs) {
                $calculatedTotalHours += ($outTs - $inTs) / 3600;
            }
        }
    }
}

$monthlyTotalHours = round($calculatedTotalHours, 1);
$monthlyWorkedDays = $calculatedWorkedDays > 0 ? $calculatedWorkedDays : (int)($attend['present_days'] ?? 0);
$avgDailyHours = $monthlyWorkedDays > 0 ? round($monthlyTotalHours / $monthlyWorkedDays, 1) : 0;
$totalDays = !empty($attendance) ? count($attendance) : 30;
$attPct = $totalDays > 0 ? round(($monthlyWorkedDays / $totalDays) * 100) : 0;

// Leave balances are now handled dynamically in the HTML below
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bloom Solutions | Admin Employee Timesheet</title>

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
      overflow-x: hidden;
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

    .filter-input {
      border: 1px solid var(--slate-200);
      border-radius: 10px;
      height: 38px;
      font-size: 12px;
      font-weight: 500;
      color: var(--slate-700);
      background-color: #ffffff;
      padding: 0 12px;
    }

    .ts-card {
      background: #ffffff;
      border: 1px solid var(--slate-200);
      border-radius: 16px;
      padding: 18px;
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
      height: 100%;
      transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .ts-card:hover {
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04);
    }

    .profile-avatar {
      width: 76px;
      height: 76px;
      border-radius: 50%;
      object-fit: cover;
      border: 3px solid #ffffff;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
      background: var(--bloom-purple-light);
      color: var(--bloom-purple);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 28px;
      font-weight: 800;
      margin: 0 auto;
    }

    .emp-id-badge {
      color: var(--bloom-purple);
      font-size: 12px;
      font-weight: 700;
    }

    .role-badge {
      background-color: var(--slate-100);
      color: var(--slate-600);
      font-size: 11px;
      font-weight: 600;
      padding: 5px 12px;
      border-radius: 20px;
      display: inline-flex;
      align-items: center;
      gap: 6px;
    }

    .stat-icon-box {
      width: 38px;
      height: 38px;
      border-radius: 10px;
      background-color: var(--bloom-purple-light);
      color: var(--bloom-purple);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 16px;
    }

    .stat-badge {
      background: var(--slate-100);
      color: var(--slate-600);
      font-weight: 700;
      font-size: 10px;
      padding: 3px 8px;
      border-radius: 6px;
    }

    .stat-label {
      font-size: 10px;
      font-weight: 700;
      color: var(--slate-400);
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    .stat-value {
      font-size: 22px;
      font-weight: 800;
      color: var(--slate-900);
      line-height: 1.1;
    }

    .stat-unit {
      font-size: 12px;
      font-weight: 600;
      color: var(--slate-400);
    }

    /* Badges */
    .st-present { background-color: #d1fae5; color: #065f46; font-weight: 700; font-size: 10px; padding: 4px 10px; border-radius: 6px; }
    .st-late { background-color: #fee2e2; color: #991b1b; font-weight: 700; font-size: 10px; padding: 4px 10px; border-radius: 6px; }
    .st-leave { background-color: #fef3c7; color: #92400e; font-weight: 700; font-size: 10px; padding: 4px 10px; border-radius: 6px; }
    .st-wfh { background-color: #dbeafe; color: #1e40af; font-weight: 700; font-size: 10px; padding: 4px 10px; border-radius: 6px; }
    .st-holiday { background-color: #f3e8ff; color: #6b21a8; font-weight: 700; font-size: 10px; padding: 4px 10px; border-radius: 6px; }
    .st-off { background-color: var(--slate-100); color: var(--slate-600); font-weight: 700; font-size: 10px; padding: 4px 10px; border-radius: 6px; }
    .st-absent { background-color: #fee2e2; color: #b91c1c; font-weight: 700; font-size: 10px; padding: 4px 10px; border-radius: 6px; }

    .table-timesheet thead th {
      background-color: #ffffff;
      color: var(--slate-400);
      font-size: 10px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      border-bottom: 1px solid var(--slate-200);
      padding: 12px 14px;
    }

    .table-timesheet tbody td {
      padding: 14px;
      vertical-align: middle;
      font-size: 12px;
      border-bottom: 1px solid var(--slate-100);
    }

    .table-timesheet tbody tr:hover {
      background-color: #f8fafc;
    }

    /* Action Buttons */
    .action-icon-btn {
      width: 32px;
      height: 32px;
      border-radius: 8px;
      border: 1px solid var(--slate-200);
      background: #ffffff;
      color: var(--slate-600);
      display: inline-flex;
      align-items: center;
      justify-content: center;
      transition: all 0.2s ease;
      cursor: pointer;
    }

    .action-icon-btn:hover {
      background: var(--bloom-purple-light);
      color: var(--bloom-purple);
      border-color: var(--bloom-purple);
    }

    /* Absent Edit Row Highlight */
    tr.absent-row td { background-color: #fff8f8 !important; }
    tr.absent-row .edit-absent-btn {
      background: var(--bloom-purple-light);
      color: var(--bloom-purple);
      border-color: var(--bloom-purple);
      font-size: 10px; font-weight: 700;
      height: 28px; padding: 0 10px; border-radius: 8px;
      border-width: 1px; border-style: solid;
      cursor: pointer; transition: all 0.2s ease;
    }
    tr.absent-row .edit-absent-btn:hover {
      background: var(--bloom-purple);
      color: #fff;
    }

    /* Inline edit save row */
    .inline-edit-row td { background: #f0f4ff !important; padding: 10px 14px !important; }
    .inline-save-btn {
      height: 32px; padding: 0 14px; border-radius: 8px;
      background: var(--bloom-purple); color: #fff;
      border: none; font-size: 11px; font-weight: 700;
      cursor: pointer; transition: all 0.2s;
    }
    .inline-save-btn:hover { opacity: 0.88; }
    .inline-cancel-btn {
      height: 32px; padding: 0 12px; border-radius: 8px;
      background: #fff; color: var(--slate-600);
      border: 1px solid var(--slate-200);
      font-size: 11px; font-weight: 600;
      cursor: pointer; transition: all 0.2s;
    }
    .inline-cancel-btn:hover { border-color: var(--bloom-danger); color: var(--bloom-danger); }
    .inline-select, .inline-time {
      height: 32px; border-radius: 8px;
      border: 1px solid var(--slate-200);
      font-size: 11px; font-weight: 600;
      color: var(--slate-700); padding: 0 8px;
      background: #fff;
    }
    .inline-select:focus, .inline-time:focus {
      outline: none;
      border-color: var(--bloom-purple);
      box-shadow: 0 0 0 2px rgba(74,0,224,0.1);
    }

    /* Toast notification */
    #absEditToast {
      position: fixed; bottom: 28px; right: 28px;
      min-width: 300px; max-width: 420px;
      z-index: 99999;
      border-radius: 14px;
      padding: 14px 18px;
      font-size: 13px; font-weight: 600;
      box-shadow: 0 8px 30px rgba(0,0,0,0.18);
      display: none;
      align-items: center; gap: 10px;
      animation: slideUp 0.3s ease;
    }
    #absEditToast.show { display: flex; }
    #absEditToast.toast-success { background: #d1fae5; color: #065f46; border: 1px solid #6ee7b7; }
    #absEditToast.toast-error   { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }
    @keyframes slideUp {
      from { transform: translateY(20px); opacity: 0; }
      to   { transform: translateY(0);    opacity: 1; }
    }

    /* Drawer / Side Modal */
    .punch-drawer {
      position: fixed;
      top: 0;
      right: -420px;
      width: 400px;
      height: 100vh;
      background: #ffffff;
      box-shadow: -5px 0 25px rgba(0, 0, 0, 0.15);
      z-index: 9999;
      transition: right 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      display: flex;
      flex-direction: column;
    }

    .punch-drawer.open {
      right: 0;
    }

    .drawer-overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100vw;
      height: 100vh;
      background: rgba(15, 23, 42, 0.4);
      backdrop-filter: blur(2px);
      z-index: 9998;
      display: none;
    }

    .drawer-overlay.show {
      display: block;
    }

    .punch-timeline-item {
      position: relative;
      padding-left: 28px;
      padding-bottom: 20px;
    }

    .punch-timeline-item::before {
      content: '';
      position: absolute;
      left: 7px;
      top: 18px;
      bottom: 0;
      width: 2px;
      background-color: var(--slate-200);
    }

    .punch-timeline-item:last-child::before {
      display: none;
    }

    .punch-timeline-dot {
      position: absolute;
      left: 0;
      top: 4px;
      width: 16px;
      height: 16px;
      border-radius: 50%;
      background-color: var(--bloom-purple);
      border: 3px solid #ffffff;
      box-shadow: 0 0 0 2px var(--slate-200);
    }
  </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <div class="content-wrapper">
      <div class="content-header pt-4 pb-2">
        <div class="container-fluid">

          <!-- Flash Message -->
          <?php if (session()->getFlashdata('status') == 'Y') : ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 12px;">
              <i class="fas fa-check-circle mr-1"></i> <?= session()->getFlashdata('remarks') ?>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          <?php endif; ?>

          <!-- Top Navigation / Filters Bar -->
          <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
            <div>
              <h1 class="page-title">Employee Timesheet</h1>
              <p class="page-subtitle">Review detailed attendance logs and timesheets.</p>
            </div>

            <!-- Filters -->
            <form method="get" action="<?= base_url('admin/attendance_details') ?>" class="d-flex align-items-center gap-2 flex-wrap">
              <select name="emp_id" class="form-control filter-input" style="min-width: 180px;" onchange="this.form.submit()">
                <?php if (!empty($employee_list)) : ?>
                  <?php foreach ($employee_list as $e) : ?>
                    <option value="<?= esc($e['emp_id']) ?>" <?= ($selectedEmp == $e['emp_id']) ? 'selected' : '' ?>>
                      <?= esc($e['emp_id']) ?> - <?= esc($e['emp_name']) ?>
                    </option>
                  <?php endforeach; ?>
                <?php else : ?>
                  <option value="<?= esc($selectedEmp) ?>"><?= esc($selectedEmp) ?></option>
                <?php endif; ?>
              </select>

              <select name="month" class="form-control filter-input" onchange="this.form.submit()">
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

              <select name="year" class="form-control filter-input" onchange="this.form.submit()">
                <?php
                $currY = (int)date('Y');
                for ($y = $currY - 2; $y <= $currY + 1; $y++) {
                  $sel = ($selectedYear == $y) ? 'selected' : '';
                  echo "<option value=\"$y\" $sel>$y</option>";
                }
                ?>
              </select>

              <button type="submit" class="btn btn-sm btn-primary font-weight-bold px-3" style="height:38px; border-radius:10px; background:var(--bloom-purple); border:none;">
                <i class="fas fa-sync-alt"></i>
              </button>
            </form>
          </div>

          <!-- Top Grid Section -->
          <div class="row">
            <!-- Left Employee Profile Card -->
            <div class="col-lg-4 col-md-5 mb-4">
              <div class="ts-card text-center d-flex flex-column justify-content-between">
                <div>
                  <div class="profile-avatar mb-3">
                    <?= strtoupper(substr($employee['emp_name'] ?? 'E', 0, 1)) ?>
                  </div>
                  <h5 class="font-weight-bold text-dark mb-1"><?= esc($employee['emp_name'] ?? 'Employee') ?></h5>
                  <div class="emp-id-badge mb-2"><?= esc($employee['emp_id'] ?? $selectedEmp) ?></div>
                  <div class="role-badge mb-4">
                    <i class="fas fa-briefcase text-primary"></i> <?= esc($employee['designation_name'] ?? 'Team Member') ?>
                  </div>
                </div>

                <div class="border-top pt-3">
                  <div class="row text-left">
                    <div class="col-6">
                      <div class="stat-label">MANAGER</div>
                      <div class="font-weight-bold text-dark" style="font-size:12px;"><?= esc($employee['manager_name'] ?? 'Sarah Jenkins') ?></div>
                    </div>
                    <div class="col-6">
                      <div class="stat-label">SHIFT</div>
                      <div class="font-weight-bold text-dark" style="font-size:12px;">General (09:30 - 18:30)</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Right Stats Grid -->
            <div class="col-lg-8 col-md-7 mb-4">
              <div class="row">
                <!-- Stat 1: Total Hours -->
                <div class="col-sm-6 col-lg-3 mb-3">
                  <div class="ts-card">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                      <div class="stat-icon-box"><i class="far fa-clock"></i></div>
                      <span class="stat-badge"><?= $monthlyWorkedDays ?> DAYS</span>
                    </div>
                    <div class="stat-label mb-1">TOTAL HOURS WORKED</div>
                    <div>
                      <span class="stat-value"><?= $monthlyTotalHours ?></span>
                      <span class="stat-unit">hrs</span>
                    </div>
                  </div>
                </div>

                <!-- Stat 2: Avg Daily Hours -->
                <div class="col-sm-6 col-lg-3 mb-3">
                  <div class="ts-card">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                      <div class="stat-icon-box" style="background:#f0fdf4; color:#16a34a;"><i class="fas fa-stopwatch"></i></div>
                    </div>
                    <div class="stat-label mb-1">AVG DAILY HOURS</div>
                    <div>
                      <span class="stat-value"><?= $avgDailyHours ?></span>
                      <span class="stat-unit">hrs</span>
                    </div>
                  </div>
                </div>

                <!-- Stat 3: Total Overtime -->
                <div class="col-sm-6 col-lg-3 mb-3">
                  <div class="ts-card">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                      <div class="stat-icon-box" style="background:#fff7ed; color:#ea580c;"><i class="fas fa-history"></i></div>
                    </div>
                    <div class="stat-label mb-1">TOTAL OVERTIME</div>
                    <div>
                      <span class="stat-value">0.0</span>
                      <span class="stat-unit">hrs</span>
                    </div>
                  </div>
                </div>

                <!-- Stat 4: Attendance % -->
                <div class="col-sm-6 col-lg-3 mb-3">
                  <div class="ts-card">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                      <div class="stat-icon-box" style="background:#eff6ff; color:#2563eb;"><i class="fas fa-user-check"></i></div>
                      <span class="badge badge-primary font-weight-bold" style="font-size:10px;">+2%</span>
                    </div>
                    <div class="stat-label mb-1">ATTENDANCE %</div>
                    <div>
                      <span class="stat-value"><?= $attPct ?>%</span>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Period Bar & Secondary Cards -->
              <div class="row align-items-center mb-3">
                <div class="col-md-6 mb-2 mb-md-0">
                  <span class="font-weight-bold text-muted" style="font-size:12px;">
                    Period: <?= date('M 25, Y', strtotime('-1 month', strtotime("$selectedYear-$selectedMonth-01"))) ?> - <?= date('M 24, Y', strtotime("$selectedYear-$selectedMonth-01")) ?>
                  </span>
                </div>
                <div class="col-md-6 text-md-right">
                  <button class="btn btn-light border font-weight-bold text-dark mr-2" style="border-radius:10px; font-size:12px;">
                    <i class="fas fa-download mr-1"></i> Export CSV
                  </button>
                  <button class="btn btn-primary font-weight-bold" style="border-radius:10px; font-size:12px; background:var(--bloom-purple); border:none;">
                    <i class="fas fa-print mr-1"></i> Print Report
                  </button>
                </div>
              </div>

              <div class="row">
                <!-- Leave Balance -->
                <div class="col-md-6 mb-3">
                  <div class="ts-card">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                      <div class="stat-icon-box" style="background:#eef2ff; color:#4a00e0;"><i class="far fa-calendar-alt"></i></div>
                      <span class="stat-label">LEAVE BALANCE</span>
                    </div>
                    <div class="d-flex align-items-center justify-content-around text-center pt-2">
                      <?php if (!empty($leave_balances)) : ?>
                        <?php foreach ($leave_balances as $lb) : ?>
                          <div>
                            <div class="stat-label" title="<?= esc($lb['leave_name'] ?? '') ?>"><?= esc(strtoupper($lb['leave_code'] ?? '')) ?></div>
                            <div class="font-weight-bold text-dark" style="font-size:16px;"><?= (float)($lb['balance_days'] ?? 0) ?></div>
                          </div>
                        <?php endforeach; ?>
                      <?php else : ?>
                        <div class="text-muted" style="font-size:12px;">No leave balances found</div>
                      <?php endif; ?>
                    </div>
                  </div>
                </div>

                <!-- Shift Details -->
                <div class="col-md-6 mb-3">
                  <div class="ts-card">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                      <div class="stat-icon-box" style="background:#f1f5f9; color:#475569;"><i class="far fa-clock"></i></div>
                      <span class="stat-label">SHIFT DETAILS</span>
                    </div>
                    <div class="d-flex align-items-center justify-content-between pt-2">
                      <div>
                        <div class="stat-label">HOURS</div>
                        <div class="font-weight-bold text-dark" style="font-size:13px;">09:30 - 18:30</div>
                      </div>
                      <div class="text-right">
                        <div class="stat-label">BREAK</div>
                        <div class="font-weight-bold text-dark" style="font-size:13px;">60 mins</div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

            </div>
          </div>

          <!-- Daily Timesheet Table Card -->
          <div class="ts-card p-0 overflow-hidden">
            <div class="table-responsive">
              <table id="timesheetTable" class="table table-timesheet mb-0">
                <thead>
                  <tr>
                    <th>DATE</th>
                    <th>STATUS</th>
                    <th>FIRST IN</th>
                    <th>LAST OUT</th>
                    <th>TOTAL HRS</th>
                    <th>LATE (M)</th>
                    <th>EARLY (M)</th>
                    <th>OT (HRS)</th>
                    <th class="text-right">ACTIONS</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (!empty($attendance)) : ?>
                    <?php foreach ($attendance as $index => $row) : ?>
                      <?php
                      $st = strtoupper(trim($row['attendance_status'] ?? $row['status'] ?? 'ABSENT'));
                      $stBadge = 'st-absent';
                      if ($st === 'PRESENT')         $stBadge = 'st-present';
                      elseif ($st === 'LATE')         $stBadge = 'st-late';
                      elseif (strpos($st,'LEAVE')!==false) $stBadge = 'st-leave';
                      elseif ($st === 'WFH')          $stBadge = 'st-wfh';
                      elseif ($st === 'HOLIDAY')      $stBadge = 'st-holiday';
                      elseif (in_array($st,['WEEKLY OFF','WEEKOFF','OFF'])) $stBadge = 'st-off';
                      elseif ($st === 'LOP')          $stBadge = 'st-absent';

                      $isAbsent     = ($st === 'ABSENT' || $st === 'A');
                      $inTime       = !empty($row['punch_in'])  && $row['punch_in']  !== '-' ? date('h:i A', strtotime($row['punch_in']))  : '-';
                      $outTime      = !empty($row['punch_out']) && $row['punch_out'] !== '-' ? date('h:i A', strtotime($row['punch_out'])) : '-';
                      $inTimeRaw    = !empty($row['punch_in'])  && $row['punch_in']  !== '-' ? date('H:i', strtotime($row['punch_in']))  : '';
                      $outTimeRaw   = !empty($row['punch_out']) && $row['punch_out'] !== '-' ? date('H:i', strtotime($row['punch_out'])) : '';
                      $totHrs       = !empty($row['total_hours']) ? $row['total_hours'] : ($row['daily_time_formatted'] ?? '-');
                      $formattedDate= date('d M, D', strtotime($row['attendance_date']));
                      $attDate      = $row['attendance_date'];
                      $empId        = esc($row['emp_id']);
                      $rowId        = 'att-row-' . $index;
                      $editRowId    = 'edit-row-' . $index;
                      ?>

                      <!-- ─── Display Row ─── -->
                      <tr id="<?= $rowId ?>" class="<?= $isAbsent ? 'absent-row' : '' ?>">
                        <td class="font-weight-bold text-dark"><?= $formattedDate ?></td>
                        <td id="status-cell-<?= $index ?>">
                          <span class="<?= $stBadge ?>" id="status-badge-<?= $index ?>"><?= $st ?></span>
                        </td>
                        <td id="punchin-cell-<?= $index ?>"><?= $inTime ?></td>
                        <td id="punchout-cell-<?= $index ?>"><?= $outTime ?></td>
                        <td class="font-weight-bold text-dark" id="hrs-cell-<?= $index ?>"><?= $totHrs ?></td>
                        <td class="text-muted">-</td>
                        <td class="text-muted">-</td>
                        <td class="text-muted">0.0</td>
                        <td class="text-right">
                          <?php if ($isAbsent) : ?>
                            <!-- ABSENT: show Edit Attendance button -->
                            <button class="edit-absent-btn mr-1"
                                    title="Edit Attendance for Absent Day"
                                    onclick="openInlineEdit(<?= $index ?>, '<?= $empId ?>', '<?= $attDate ?>')"
                                    id="edit-btn-<?= $index ?>">
                              <i class="fas fa-pen mr-1"></i> Edit
                            </button>
                          <?php else : ?>
                            <!-- Non-absent: existing edit punch button -->
                            <button class="action-icon-btn mr-1" title="Edit Punch Timings"
                                    onclick="openEditModal('<?= $empId ?>', '<?= $attDate ?>',
                                    '<?= esc($row['punch_in'] ?? '') ?>', '<?= esc($row['punch_out'] ?? '') ?>')">
                              <i class="far fa-calendar-alt"></i>
                            </button>
                          <?php endif; ?>
                          <!-- View Punch Details Drawer -->
                          <button class="action-icon-btn" title="View Punch Details"
                                  onclick="openPunchDrawer('<?= $formattedDate ?>', '<?= $inTime ?>', '<?= $outTime ?>', '<?= $st ?>')">
                            <i class="far fa-eye"></i>
                          </button>
                        </td>
                      </tr>

                      <?php if ($isAbsent) : ?>
                      <!-- ─── Inline Edit Row (hidden by default) ─── -->
                      <tr id="<?= $editRowId ?>" class="inline-edit-row" style="display:none;">
                        <td colspan="9">
                          <div class="d-flex align-items-center flex-wrap" style="gap:10px;">

                            <!-- Date label -->
                            <div style="min-width:90px;">
                              <div class="stat-label" style="font-size:9px;">DATE</div>
                              <div class="font-weight-bold text-dark" style="font-size:12px;"><?= $formattedDate ?></div>
                            </div>

                            <!-- Edit Type Select -->
                            <div>
                              <div class="stat-label" style="font-size:9px;">CHANGE TO</div>
                              <select class="inline-select" id="etype-<?= $index ?>"
                                      onchange="togglePunchFields(<?= $index ?>)">
                                <option value="">-- Select --</option>
                                <option value="WFH">WFH (Work From Home)</option>
                                <option value="PL">PL (Personal Leave)</option>
                                <option value="SL">SL (Sick Leave)</option>
                                <option value="ML">ML (Maternity Leave)</option>
                                <option value="LOP">LOP (Loss of Pay)</option>
                              </select>
                            </div>

                            <!-- WFH Punch Times (shown only when WFH selected) -->
                            <div id="wfh-times-<?= $index ?>" style="display:none; gap:8px;" class="d-flex align-items-center">
                              <div>
                                <div class="stat-label" style="font-size:9px;">PUNCH IN</div>
                                <input type="time" class="inline-time" id="pin-<?= $index ?>"
                                       value="09:30" min="00:00" max="23:59">
                              </div>
                              <div>
                                <div class="stat-label" style="font-size:9px;">PUNCH OUT</div>
                                <input type="time" class="inline-time" id="pout-<?= $index ?>"
                                       value="18:30" min="00:00" max="23:59">
                              </div>
                            </div>

                            <!-- Info note for PL/SL/CL -->
                            <div id="leave-note-<?= $index ?>" style="display:none;">
                              <span style="font-size:10px; color:var(--slate-500); font-style:italic;">
                                <i class="fas fa-info-circle text-primary mr-1"></i>
                                Balance will be deducted. If no balance, marked as LOP.
                              </span>
                            </div>

                            <!-- Save / Cancel -->
                            <div class="ml-auto d-flex" style="gap:6px;">
                              <button class="inline-save-btn" id="save-btn-<?= $index ?>"
                                      onclick="saveAbsentEdit(<?= $index ?>, '<?= $empId ?>', '<?= $attDate ?>')"
                                      disabled>
                                <i class="fas fa-save mr-1"></i> Save
                              </button>
                              <button class="inline-cancel-btn" onclick="cancelInlineEdit(<?= $index ?>)">
                                <i class="fas fa-times"></i> Cancel
                              </button>
                            </div>

                          </div>
                        </td>
                      </tr>
                      <?php endif; ?>

                    <?php endforeach; ?>
                  <?php else : ?>
                    <tr>
                      <td colspan="9" class="text-center py-4 text-muted">No attendance logs available for this period.</td>
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

  <!-- Right Drawer Overlay -->
  <div class="drawer-overlay" id="drawerOverlay" onclick="closePunchDrawer()"></div>

  <!-- Right Side Punch Details Drawer -->
  <div class="punch-drawer" id="punchDrawer">
    <div class="p-3 border-bottom d-flex align-items-center justify-content-between">
      <div>
        <h6 class="font-weight-bold text-dark mb-0">Punch Details</h6>
        <small class="text-muted" id="drawerDate">01 Nov 2023, Wednesday</small>
      </div>
      <button type="button" class="btn btn-sm btn-light border rounded-circle" onclick="closePunchDrawer()">
        <i class="fas fa-times"></i>
      </button>
    </div>

    <div class="p-3 bg-light border-bottom">
      <div class="row text-center">
        <div class="col-6 border-right">
          <div class="stat-label">FIRST IN</div>
          <div class="font-weight-bold text-dark" id="drawerFirstIn" style="font-size:14px;">09:30 AM</div>
        </div>
        <div class="col-6">
          <div class="stat-label">LAST OUT</div>
          <div class="font-weight-bold text-dark" id="drawerLastOut" style="font-size:14px;">06:30 PM</div>
        </div>
      </div>
    </div>

    <div class="p-3 flex-grow-1 overflow-auto">
      <div class="stat-label mb-3">RAW PUNCH LOGS</div>

      <div class="punch-timeline-item">
        <div class="punch-timeline-dot"></div>
        <div class="d-flex align-items-center justify-content-between">
          <strong class="text-dark">IN (Biometric / Web)</strong>
          <small class="text-muted" id="drawerInLog">09:30 AM</small>
        </div>
        <small class="text-muted d-block">Main Gate Turnstile A</small>
      </div>

      <div class="punch-timeline-item">
        <div class="punch-timeline-dot" style="background:#f59e0b;"></div>
        <div class="d-flex align-items-center justify-content-between">
          <strong class="text-dark">OUT (Break)</strong>
          <small class="text-muted">01:00 PM</small>
        </div>
        <small class="text-muted d-block">Cafeteria Door</small>
      </div>

      <div class="punch-timeline-item">
        <div class="punch-timeline-dot" style="background:#2563eb;"></div>
        <div class="d-flex align-items-center justify-content-between">
          <strong class="text-dark">IN (Break Return)</strong>
          <small class="text-muted">01:45 PM</small>
        </div>
        <small class="text-muted d-block">Cafeteria Door</small>
      </div>

      <div class="punch-timeline-item">
        <div class="punch-timeline-dot" style="background:#dc2626;"></div>
        <div class="d-flex align-items-center justify-content-between">
          <strong class="text-dark">OUT (Biometric / Web)</strong>
          <small class="text-muted" id="drawerOutLog">06:30 PM</small>
        </div>
        <small class="text-muted d-block">Main Gate Turnstile B</small>
      </div>
    </div>

    <div class="p-3 border-top bg-light">
      <button class="btn btn-block btn-light border font-weight-bold text-dark" style="border-radius:10px;">
        <i class="fas fa-edit mr-1"></i> Request Regularization
      </button>
    </div>
  </div>

  <!-- Edit Punch Modal (for non-absent rows) -->
  <div class="modal fade" id="editPunchModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content" style="border-radius: 16px;">
        <div class="modal-header border-bottom">
          <h5 class="modal-title font-weight-bold text-dark">
            <i class="fas fa-clock text-primary mr-1"></i> Edit Punch Timings
          </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="<?= base_url('admin/save_missing_punchout') ?>" method="post">
          <div class="modal-body">
            <input type="hidden" name="target_emp_id" id="edit_emp_id">
            <input type="hidden" name="attendance_date" id="edit_att_date">
            <div class="form-group mb-3">
              <label class="font-weight-bold text-muted small">Employee ID</label>
              <input type="text" id="display_emp_id" class="form-control filter-input" readonly>
            </div>
            <div class="form-group mb-3">
              <label class="font-weight-bold text-muted small">Attendance Date</label>
              <input type="date" id="display_att_date" class="form-control filter-input" readonly>
            </div>
            <div class="row">
              <div class="col-6">
                <div class="form-group mb-3">
                  <label class="font-weight-bold text-dark small">Punch In Time</label>
                  <input type="time" name="first_in_time" id="edit_first_in" class="form-control filter-input" required>
                </div>
              </div>
              <div class="col-6">
                <div class="form-group mb-3">
                  <label class="font-weight-bold text-dark small">Punch Out Time</label>
                  <input type="time" name="last_out_time" id="edit_last_out" class="form-control filter-input" required>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer border-top">
            <button type="button" class="btn btn-light border font-weight-bold px-3" data-dismiss="modal" style="border-radius:10px;">Cancel</button>
            <button type="submit" class="btn btn-primary font-weight-bold px-4" style="border-radius:10px; background:var(--bloom-purple); border:none;">Save Punch Timings</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- ─── Toast Notification ─── -->
  <div id="absEditToast">
    <i id="toastIcon" class="fas fa-check-circle" style="font-size:18px;"></i>
    <span id="toastMsg">Saved.</span>
    <button onclick="hideToast()" style="margin-left:auto; background:none; border:none; cursor:pointer; font-size:16px; opacity:0.6;">&#x2715;</button>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>

  <script>
    /* ── DataTable init ────────────────────────────────────── */
    $(document).ready(function () {
      $('#timesheetTable').DataTable({
        pageLength: 31,
        ordering: false,
        language: { search: 'Filter Daily Log:' }
      });
    });

    /* ── Punch Drawer ──────────────────────────────────────── */
    function openPunchDrawer(dateStr, inTime, outTime, statusStr) {
      $('#drawerDate').text(dateStr);
      $('#drawerFirstIn').text(inTime !== '-' ? inTime : 'N/A');
      $('#drawerLastOut').text(outTime !== '-' ? outTime : 'N/A');
      $('#drawerInLog').text(inTime !== '-' ? inTime : 'N/A');
      $('#drawerOutLog').text(outTime !== '-' ? outTime : 'N/A');
      $('#drawerOverlay').addClass('show');
      $('#punchDrawer').addClass('open');
    }
    function closePunchDrawer() {
      $('#drawerOverlay').removeClass('show');
      $('#punchDrawer').removeClass('open');
    }

    /* ── Edit Punch Modal (non-absent rows) ────────────────── */
    function openEditModal(empId, attDate, inTimeFull, outTimeFull) {
      $('#edit_emp_id').val(empId);
      $('#display_emp_id').val(empId);
      $('#edit_att_date').val(attDate);
      $('#display_att_date').val(attDate);
      let inT = '', outT = '';
      if (inTimeFull && inTimeFull.length >= 16) inT = inTimeFull.substring(11, 16);
      if (outTimeFull && outTimeFull.length >= 16) outT = outTimeFull.substring(11, 16);
      $('#edit_first_in').val(inT || '09:30');
      $('#edit_last_out').val(outT || '18:30');
      $('#editPunchModal').modal('show');
    }

    /* ══════════════════════════════════════════════════════════
     * ABSENT INLINE EDIT FUNCTIONS
     * ════════════════════════════════════════════════════════ */

    /** Open inline edit row for an ABSENT record */
    function openInlineEdit(idx, empId, attDate) {
      $('#att-row-' + idx).after($('#edit-row-' + idx));
      $('#edit-row-' + idx).show();
      $('#edit-btn-' + idx).hide();
      // Reset state
      $('#etype-' + idx).val('');
      $('#wfh-times-' + idx).hide();
      $('#leave-note-' + idx).hide();
      $('#save-btn-' + idx).prop('disabled', true);
    }

    /** Cancel inline edit */
    function cancelInlineEdit(idx) {
      $('#edit-row-' + idx).hide();
      $('#edit-btn-' + idx).show();
    }

    /** Show/hide conditional fields based on selected edit type */
    function togglePunchFields(idx) {
      var type = $('#etype-' + idx).val();
      if (type === 'WFH') {
        $('#wfh-times-' + idx).show().css('display','flex');
        $('#leave-note-' + idx).hide();
      } else if (['PL','SL','ML'].indexOf(type) !== -1) {
        $('#wfh-times-' + idx).hide();
        $('#leave-note-' + idx).show();
      } else {
        $('#wfh-times-' + idx).hide();
        $('#leave-note-' + idx).hide();
      }
      $('#save-btn-' + idx).prop('disabled', type === '');
    }

    /** AJAX save for absent edit */
    function saveAbsentEdit(idx, empId, attDate) {
      var type    = $('#etype-' + idx).val();
      var punchIn = '';
      var punchOut = '';

      if (!type) {
        showToast('Please select an edit type.', false);
        return;
      }

      if (type === 'WFH') {
        punchIn  = $('#pin-'  + idx).val();
        punchOut = $('#pout-' + idx).val();
        if (!punchIn || !punchOut) {
          showToast('Punch In and Punch Out are required for WFH.', false);
          return;
        }
        if (punchOut <= punchIn) {
          showToast('Punch Out must be after Punch In.', false);
          return;
        }
      }

      var $saveBtn = $('#save-btn-' + idx);
      var origHtml = $saveBtn.html();
      $saveBtn.html('<i class="fas fa-spinner fa-spin mr-1"></i> Saving...').prop('disabled', true);

      $.ajax({
        url: '<?= base_url('admin/save_absent_edit') ?>',
        type: 'POST',
        data: {
          emp_id:    empId,
          att_date:  attDate,
          edit_type: type,
          punch_in:  punchIn,
          punch_out: punchOut,
          <?= csrf_token() ?>: '<?= csrf_hash() ?>'
        },
        dataType: 'json',
        success: function(res) {
          if (res.status === 'Y') {
            showToast(res.message, true);
            // ── Live-update the display row ──────────────────
            updateDisplayRow(idx, type, attDate, punchIn, punchOut);
            cancelInlineEdit(idx);
          } else {
            showToast(res.message || 'Save failed.', false);
            $saveBtn.html(origHtml).prop('disabled', false);
          }
        },
        error: function(xhr) {
          showToast('Server error: ' + (xhr.responseText || 'Unknown error'), false);
          $saveBtn.html(origHtml).prop('disabled', false);
        }
      });
    }

    /** Update the visible display row after a successful save */
    function updateDisplayRow(idx, type, attDate, punchIn, punchOut) {
      var badgeClass, badgeText, pInDisp = '-', pOutDisp = '-';

      if (type === 'WFH') {
        badgeClass = 'st-wfh';   badgeText = 'WFH';
        pInDisp  = formatTimeDisplay(punchIn);
        pOutDisp = formatTimeDisplay(punchOut);
      } else if (type === 'PL' || type === 'SL' || type === 'ML') {
        // Server decides if it becomes LEAVE or LOP — show optimistically as LEAVE
        // The toast message will tell the user the exact outcome
        badgeClass = 'st-leave'; badgeText = type + ' LEAVE';
      } else if (type === 'LOP') {
        badgeClass = 'st-absent'; badgeText = 'LOP';
      }

      $('#status-badge-'  + idx).attr('class', badgeClass).text(badgeText);
      $('#punchin-cell-'  + idx).text(pInDisp);
      $('#punchout-cell-' + idx).text(pOutDisp);
      // Remove absent-row styling and Edit button
      $('#att-row-' + idx).removeClass('absent-row');
      $('#edit-btn-' + idx).closest('td').html(
        '<button class="action-icon-btn" title="View Punch Details"' +
        ' onclick="openPunchDrawer(\'' + pInDisp + '\', \'' + pOutDisp + '\', \'' + badgeText + '\')">' +
        '<i class="far fa-eye"></i></button>'
      );
    }

    /** Format HH:MM → h:mm AM/PM for display */
    function formatTimeDisplay(hhmm) {
      if (!hhmm) return '-';
      var parts = hhmm.split(':');
      var h = parseInt(parts[0]), m = parseInt(parts[1]);
      var ampm = h >= 12 ? 'PM' : 'AM';
      h = h % 12 || 12;
      return h + ':' + (m < 10 ? '0' : '') + m + ' ' + ampm;
    }

    /* ── Toast ─────────────────────────────────────────────── */
    var _toastTimer;
    function showToast(msg, success) {
      var $t = $('#absEditToast');
      $t.removeClass('toast-success toast-error show');
      $('#toastMsg').text(msg);
      $('#toastIcon').attr('class', success ? 'fas fa-check-circle' : 'fas fa-exclamation-circle');
      $t.addClass(success ? 'toast-success' : 'toast-error').addClass('show');
      clearTimeout(_toastTimer);
      _toastTimer = setTimeout(hideToast, 5000);
    }
    function hideToast() {
      $('#absEditToast').removeClass('show');
    }
  </script>
</body>

</html>
