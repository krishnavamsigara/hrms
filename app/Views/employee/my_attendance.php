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
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bloom Solutions | Employee Timesheet</title>

  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap">
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
      padding-bottom: 25px !important;
    }

    /* Page Header */
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

    /* Form Controls & Filters */
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

    /* Card Styling */
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

    /* Profile Card */
    .profile-avatar {
      width: 76px;
      height: 76px;
      border-radius: 50%;
      object-fit: cover;
      border: 3px solid #ffffff;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
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

    .profile-meta-title {
      font-size: 9px;
      font-weight: 700;
      color: var(--slate-400);
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    .profile-meta-value {
      font-size: 12px;
      font-weight: 700;
      color: var(--slate-800);
    }

    /* Stat Cards */
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

    .stat-badge-trend {
      background: #dbeafe;
      color: var(--bloom-blue);
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
      margin-bottom: 2px;
    }

    .stat-value {
      font-size: 24px;
      font-weight: 800;
      color: var(--slate-900);
      line-height: 1.2;
    }

    .stat-unit {
      font-size: 13px;
      font-weight: 500;
      color: var(--slate-500);
    }

    /* Summary Period Card */
    .summary-title {
      font-size: 10px;
      font-weight: 700;
      color: var(--slate-400);
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    .summary-date-range {
      font-size: 11px;
      font-weight: 600;
      color: var(--slate-500);
    }

    .summary-grid {
      display: flex;
      justify-content: space-between;
      align-items: center;
      text-align: center;
      padding: 6px 0;
    }

    .summary-col {
      flex: 1;
      border-right: 1px solid var(--slate-200);
      padding: 0 4px;
    }

    .summary-col:last-child {
      border-right: none;
    }

    .summary-item-label {
      font-size: 9px;
      font-weight: 700;
      color: var(--slate-400);
      text-transform: uppercase;
      letter-spacing: 0.3px;
      margin-bottom: 4px;
    }

    .summary-item-val {
      font-size: 16px;
      font-weight: 800;
      color: var(--slate-800);
    }

    .summary-item-val.text-present {
      color: var(--bloom-blue);
    }

    .summary-item-val.text-absent {
      color: var(--bloom-danger);
    }

    /* Calendar */
    .cal-header-title {
      font-size: 14px;
      font-weight: 700;
      color: var(--slate-800);
    }

    .cal-month-link {
      color: var(--bloom-blue);
      font-weight: 600;
      font-size: 13px;
    }

    .cal-grid {
      display: grid;
      grid-template-columns: repeat(7, 1fr);
      gap: 6px;
    }

    .cal-day-name {
      text-align: center;
      font-size: 11px;
      font-weight: 700;
      color: var(--slate-400);
      padding: 4px 0;
    }

    .cal-day-cell {
      height: 40px;
      border-radius: 8px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 700;
      font-size: 12px;
      cursor: pointer;
      transition: all 0.2s ease;
      position: relative;
    }

    .cal-day-cell:hover {
      transform: scale(1.05);
    }

    .cal-day-cell.empty-cell {
      cursor: default;
      background: transparent;
    }

    .cal-day-cell.p-present {
      background-color: #dcfce7;
      color: #15803d;
    }

    .cal-day-cell.p-late {
      background-color: #fee2e2;
      color: #b91c1c;
    }

    .cal-day-cell.p-leave {
      background-color: #fef3c7;
      color: #b45309;
    }

    .cal-day-cell.p-wfh {
      background-color: #dbeafe;
      color: #1d4ed8;
    }

    .cal-day-cell.p-off {
      background-color: #f1f5f9;
      color: #64748b;
    }

    .cal-day-cell.active-selected {
      box-shadow: 0 0 0 2px var(--bloom-blue), 0 4px 8px rgba(37, 99, 235, 0.2);
    }

    /* Legend */
    .legend-item {
      display: flex;
      align-items: center;
      gap: 6px;
      font-size: 11px;
      font-weight: 600;
      color: var(--slate-600);
    }

    .legend-box {
      width: 12px;
      height: 12px;
      border-radius: 3px;
    }

    .legend-box.bg-p-present {
      background-color: #dcfce7;
    }

    .legend-box.bg-p-late {
      background-color: #fee2e2;
    }

    .legend-box.bg-p-leave {
      background-color: #fef3c7;
    }

    .legend-box.bg-p-wfh {
      background-color: #dbeafe;
    }

    .legend-box.bg-p-off {
      background-color: #f1f5f9;
    }

    /* Attendance Log Table */
    .ts-table {
      width: 100%;
      margin-bottom: 0;
    }

    .ts-table th {
      font-size: 10px;
      font-weight: 700;
      color: var(--slate-400);
      text-transform: uppercase;
      letter-spacing: 0.5px;
      border-bottom: 1px solid var(--slate-200) !important;
      padding: 10px 12px;
      background: #fafafa;
    }

    .ts-table td {
      padding: 12px 12px;
      vertical-align: middle;
      font-size: 12px;
      font-weight: 600;
      color: var(--slate-700);
      border-bottom: 1px solid var(--slate-100);
    }

    .ts-table tr {
      cursor: pointer;
      transition: background 0.15s ease;
    }

    .ts-table tr:hover {
      background-color: #f8fafc;
    }

    .ts-table tr.selected-row {
      background-color: #eff6ff !important;
    }

    /* Badges */
    .badge-status {
      font-size: 10px;
      font-weight: 700;
      padding: 4px 8px;
      border-radius: 6px;
      letter-spacing: 0.3px;
    }

    .badge-status.st-present {
      background-color: #dcfce7;
      color: #15803d;
    }

    .badge-status.st-late {
      background-color: #fee2e2;
      color: #b91c1c;
    }

    .badge-status.st-leave {
      background-color: #fef3c7;
      color: #b45309;
    }

    .badge-status.st-off {
      background-color: #f1f5f9;
      color: #475569;
    }

    /* Pagination */
    .page-link-custom {
      border: 1px solid var(--slate-200);
      background: #ffffff;
      color: var(--slate-600);
      padding: 5px 12px;
      border-radius: 8px;
      font-weight: 600;
      font-size: 11px;
      text-decoration: none;
      transition: all 0.2s ease;
    }

    .page-link-custom:hover {
      background: var(--slate-100);
      color: var(--slate-800);
      text-decoration: none;
    }

    .page-link-custom.active-page {
      background: var(--bloom-blue);
      color: #ffffff;
      border-color: var(--bloom-blue);
    }

     /* Pagination Styling */
.dataTables_paginate .paginate_button {
    margin: 0 3px !important;
}

.dataTables_paginate .paginate_button .page-link,
.dataTables_paginate .page-link {
    border-radius: 10px !important;
    border: 1px solid #e2e8f0 !important;
    color: #64748b !important;
    font-weight: 600;
}

/* Active Page */
.dataTables_paginate .page-item.active .page-link {
    background: linear-gradient(135deg, #4a00e0 0%, #2a0080 100%) !important;
    border-color: #4a00e0 !important;
    color: #fff !important;
}

/* Hover */
.dataTables_paginate .page-link:hover {
    background: #f8faff !important;
    color: #4a00e0 !important;
    border-color: #4a00e0 !important;
}

/* Info Text */
.dataTables_info {
    color: #64748b !important;
    font-size: 12px;
    font-weight: 600;
    padding-left: 15px;
}
.dataTables_length {
    margin: 15px;
    font-size: 13px;
    font-weight: 600;
    color: #64748b;
}

.dataTables_length select {
    height: 34px !important;
    min-width: 65px;
    border: 1px solid #e2e8f0 !important;
    border-radius: 10px !important;   /* Less rounded */
    padding: 4px 8px !important;
}


.dataTables_paginate {
    padding-right: 15px;
}

/* Keep Show Entries and Search on same row */
.dataTables_wrapper .dataTables_length {
    float: left;
    margin: 15px;
}

.dataTables_wrapper .dataTables_filter {
    float: right;
    margin: 15px;
    text-align: right;
}

.dataTables_wrapper .row:first-child {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.dataTables_wrapper .dataTables_filter input {
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    padding: 6px 10px;
    margin-left: 5px;
}

/* Sorting arrows */
table.dataTable thead .sorting:before,
table.dataTable thead .sorting:after,
table.dataTable thead .sorting_asc:before,
table.dataTable thead .sorting_asc:after,
table.dataTable thead .sorting_desc:before,
table.dataTable thead .sorting_desc:after {
    top: 50% !important;
    transform: translateY(-50%);
    font-size: 10px !important;
    color: #4a00e0 !important;
}

/* PRESENT - Green */
.badge-status.st-present {
    background-color: #dcfce7;
    color: #15803d;
}

/* ABSENT - Red */
.badge-status.st-absent {
    background-color: #fee2e2;
    color: #b91c1c;
}

/* HOLIDAY - Purple */
.badge-status.st-holiday {
    background-color: #ede9fe;
    color: #6d28d9;
}

/* LEAVE - Yellow */
.badge-status.st-leave {
    background-color: #fef3c7;
    color: #b45309;
}

/* WFH - Blue */
.badge-status.st-wfh {
    background-color: #dbeafe;
    color: #1d4ed8;
}
.cal-day-cell.p-present {
    background-color: #dcfce7 !important;
    color: #15803d !important;
    font-weight: 700;
}

.cal-day-cell.p-absent {
    background-color: #fee2e2 !important;
    color: #b91c1c !important;
    font-weight: 700;
}

.cal-day-cell.p-holiday {
    background-color: #ede9fe !important;
    color: #6d28d9 !important;
    font-weight: 700;
}

.cal-day-cell.p-leave {
    background-color: #fef3c7 !important;
    color: #b45309 !important;
    font-weight: 700;
}

.cal-day-cell.p-wfh {
    background-color: #dbeafe !important;
    color: #1d4ed8 !important;
    font-weight: 700;
}

.cal-day-cell.p-late {
    background-color: #ffedd5 !important;
    color: #c2410c !important;
    font-weight: 700;
}

/* Calendar Legend Colors */

.legend-box.bg-p-present {
    background-color: #dcfce7;
}

.legend-box.bg-p-absent {
    background-color: #fee2e2;
}

.legend-box.bg-p-holiday {
    background-color: #ede9fe;
}

.legend-box.bg-p-leave {
    background-color: #fef3c7;
}

.legend-box.bg-p-wfh {
    background-color: #dbeafe;
}

.summary-item-val.text-present {
    color: #15803d; /* Green */
}

.summary-item-val.text-absent {
    color: #b91c1c; /* Red */
}

.summary-item-val.text-holiday {
    color: #6d28d9; /* Purple */
}

.summary-item-val.text-leave {
    color: #b45309; /* Yellow/Orange */
}

.summary-item-val.text-wfh {
    color: #1d4ed8; /* Blue */
}

/* Attendance table - keep card height unchanged */
#attendanceTable_wrapper .dataTables_scrollBody {
    max-height: 220px !important;
    overflow-y: auto !important;
}
  </style>
</head>

<div class="content-wrapper">
  <section class="content pt-3">
    <div class="container-fluid">

      <!-- Header & Date Filter -->
      <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
        <div>
          <h1 class="page-title">Employee Timesheet</h1>
          <p class="page-subtitle">Review detailed attendance logs and timesheets.</p>
        </div>

        <div class="d-flex align-items-center mt-2 mt-md-0">
          <!-- Date Range Picker -->
          <form method="post" action="<?= base_url('employee/my_attendance') ?>" 
      class="d-flex align-items-end">

    <!-- Month -->
    <div class="mr-2" style="width: 150px;">
        <label class="font-weight-bold mb-1">Month</label>

        <select name="month" class="form-control form-control-sm">
            <?php
            for ($m = 1; $m <= 12; $m++):
                $value = str_pad($m, 2, '0', STR_PAD_LEFT);
            ?>
                <option value="<?= $value ?>"
                    <?= ($selectedMonth == $value) ? 'selected' : '' ?>>
                    <?= date('F', mktime(0, 0, 0, $m, 1)) ?>
                </option>
            <?php endfor; ?>
        </select>
    </div>

    <!-- Year -->
    <div class="mr-2" style="width: 110px;">
        <label class="font-weight-bold mb-1">Year</label>

        <select name="year" class="form-control form-control-sm">
            <?php
            $currentYear = date('Y');

            for ($y = $currentYear; $y >= 2023; $y--):
            ?>
                <option value="<?= $y ?>"
                    <?= ($selectedYear == $y) ? 'selected' : '' ?>>
                    <?= $y ?>
                </option>
            <?php endfor; ?>
        </select>
    </div>

    <!-- Filter Button -->
    <button type="submit"
            class="btn btn-sm"
            style="
                height: 31px;
                background: var(--bloom-purple);
                color: #fff;
                border-radius: 8px;
                font-weight: 700;
                padding: 0 15px;
            ">
        <!-- <i class="fas fa-filter mr-1"></i> -->
        Submit
    </button>

</form>
        </div>
      </div>

      <!-- Main Layout Container (Full Width) -->
      <div class="row">
        <div class="col-12">

          <!-- Top Row: Profile Card & Upper Stat Cards -->
          <div class="row mb-3">
            <!-- Employee Profile Summary Card -->
            <div class="col-12 col-md-5 col-lg-4 mb-3 mb-md-0">
              <div class="ts-card text-center d-flex flex-column justify-content-between">
                <div>
                  <!-- <img
                    src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&q=80&w=200"
                    alt="Alex Mitchell" class="profile-avatar mb-2"> -->
                    <?php if (!empty($attend['profile_photo'])): ?>
                          <img
                              src="<?= base_url($attend['profile_photo']) ?>"
                              alt="<?= esc($attend['employee_name'] ?? '-') ?>"
                              class="profile-avatar mb-2">
                      <?php else: ?>
                          <img
                              src="https://ui-avatars.com/api/?name=<?= urlencode($attend['employee_name'] ?? '-') ?>&background=4a00e0&color=fff"
                              alt="<?= esc($attend['employee_name'] ?? '-') ?>"
                              class="profile-avatar mb-2">
                      <?php endif; ?>
                  <h3 class="font-weight-bold mb-0" style="font-size: 17px; color: var(--slate-900);"><?= esc($attend['employee_name'] ?? '-') ?></h3>
                  <div class="emp-id-badge mb-2"><?= esc($attend['emp_id'] ?? '-') ?></div>

                  <div class="role-badge mb-3">
                    <i class="far fa-user"></i>
                    <?= esc($attend['designation'] ?? '-') ?>
                  </div>
                </div>

                <div class="border-top pt-2">
                  <div class="row text-left">
                    <div class="col-6 border-right">
                      <div class="profile-meta-title text-center">MANAGER</div>
                      <div class="profile-meta-value text-center"><?= esc($attend['reporting_officer_name'] ?? '-') ?></div>
                    </div>
                    <div class="col-6">
                      <div class="profile-meta-title text-center">SHIFT</div>
                      <div class="profile-meta-value text-center">General</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Top Right Section: 3 Stat Cards + Summary Period Card -->
            <div class="col-12 col-md-7 col-lg-8">
              <div class="d-flex flex-column justify-content-between h-100" style="gap: 12px;">

                <!-- 3 Stat Mini Cards Row -->
                <div class="row">
                  <!-- Stat 1: Total Hours -->
                  <div class="col-12 col-sm-4 mb-2 mb-sm-0">
                    <div class="ts-card">
                      <div class="d-flex justify-content-between align-items-center mb-2">
                        <div class="stat-icon-box">
                          <i class="far fa-clock"></i>
                        </div>
                        <span class="stat-badge"> <?= esc($monthlyWorkedDays) ?> DAYS</span>
                      </div>
                      <div class="stat-label">TOTAL HOURS WORKED</div>
                      <div class="stat-value">
                        <?= esc($monthlyTotalHours) ?> <span class="stat-unit">hrs</span>
                      </div>
                    </div>
                  </div>

                  <!-- Stat 2: Avg Daily Hours -->
                      <?php
                      $totalHours = $monthlyTotalHours;
                      $workedDays = $monthlyWorkedDays;

                      $avgDailyHours = $workedDays > 0
                          ? round($totalHours / $workedDays, 1)
                          : 0;
                      ?>
                  <div class="col-12 col-sm-4 mb-2 mb-sm-0">
                    <div class="ts-card">
                      <div class="d-flex justify-content-between align-items-center mb-2">
                        <div class="stat-icon-box">
                          <i class="fas fa-stopwatch"></i>
                        </div>
                      </div>
                      <div class="stat-label">AVG DAILY HOURS</div>
                      <div class="stat-value">
                        <?= $avgDailyHours ?> <span class="stat-unit">hrs</span>
                      </div>
                    </div>
                  </div>

                  <!-- Stat 3: Attendance % -->
                   <?php
                    $workingDays = (float)($attend['working_days'] ?? 0);
                    $presentDays = (float)($attend['present_days'] ?? 0);

                    $attendancePercentage = $workingDays > 0
                        ? round(($presentDays / $workingDays) * 100)
                        : 0;
                    ?>
                  <div class="col-12 col-sm-4">
                    <div class="ts-card">
                      <div class="d-flex justify-content-between align-items-center mb-2">
                        <div class="stat-icon-box">
                          <i class="far fa-check-square"></i>
                        </div>
                        <!-- <span class="stat-badge-trend">
                          <i class="fas fa-chart-line mr-1"></i> 2%
                        </span> -->
                      </div>
                      <div class="stat-label">ATTENDANCE %</div>
                      <div class="stat-value"><?= $attendancePercentage ?>%</div>
                    </div>
                  </div>
                </div>

                <!-- Summary Period Card -->
                <div class="ts-card">
    <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2">
        <span class="summary-title">SUMMARY PERIOD</span>

        <?php
        $pStartTs = !empty($attend['period_start']) ? strtotime($attend['period_start']) : false;
        $pEndTs   = !empty($attend['period_end']) ? strtotime($attend['period_end']) : false;

        if (!$pStartTs || !$pEndTs) {
            $selM = (int)($selectedMonth ?? date('m'));
            $selY = (int)($selectedYear ?? date('Y'));

            $prevM = ($selM == 1) ? 12 : ($selM - 1);
            $prevY = ($selM == 1) ? ($selY - 1) : $selY;

            $pStartTs = strtotime(sprintf('%04d-%02d-25', $prevY, $prevM));
            $pEndTs   = strtotime(sprintf('%04d-%02d-24', $selY, $selM));
        }

        $summaryStartStr = date('M d', $pStartTs);
        $summaryEndStr   = date('M d, Y', $pEndTs);
        ?>
        <span class="summary-date-range">
            <?= $summaryStartStr ?> - <?= $summaryEndStr ?>
        </span>
    </div>

    <div class="summary-grid py-1">

        <div class="summary-col">
            <div class="summary-item-label">TOTAL DAYS</div>
            
            <div class="summary-item-val">
                <?= $attend['total_calendar_days'] ?? 0 ?>
            </div>
        </div>

        <div class="summary-col">
            <div class="summary-item-label">WORKING</div>
            <div class="summary-item-val">
                <?= $attend['working_days'] ?? 0 ?>
            </div>
        </div>

        <div class="summary-col">
            <div class="summary-item-label">PRESENT</div>
            <div class="summary-item-val text-present">
                <?= number_format((float)($attend['present_days'] ?? 0), 0) ?>
            </div>
        </div>

        <div class="summary-col">
            <div class="summary-item-label">ABSENT</div>
            <div class="summary-item-val text-absent">
                <?= number_format((float)($attend['absent_days'] ?? 0), 0) ?>
            </div>
        </div>

        <div class="summary-col">
            <div class="summary-item-label">HOLIDAYS</div>
            <div class="summary-item-val text-holiday">
                <?= $attend['holiday_days'] ?? 0 ?>
            </div>
        </div>

        <div class="summary-col">
            <div class="summary-item-label">LEAVE</div>
            <div class="summary-item-val text-leave">
                <?= number_format((float)($attend['leave_days'] ?? 0), 0) ?>
            </div>
        </div>

        <div class="summary-col">
            <div class="summary-item-label">WFH</div>
            <div class="summary-item-val text-wfh">
                <?= number_format((float)($attend['wfh_days'] ?? 0), 0) ?>
            </div>
        </div>

    </div>
</div>
              </div>
            </div>
          </div>

          <!-- Bottom Grid: Attendance Calendar & Attendance Log Table -->
          <div class="row">
            <!-- Attendance Calendar Card -->
            <!-- Attendance Calendar Card -->
<div class="col-12 col-lg-5 mb-3 mb-lg-0">
    <div class="ts-card d-flex flex-column justify-content-between">

        <div>

          <?php
            $calendarMonth = (int) $selectedMonth;
            $calendarYear  = (int) $selectedYear;

            /*
            * Attendance Cycle
            *
            * July 2026
            * = June 25, 2026 to July 24, 2026
            */

            // Start = 25th of previous month
            $periodStart = new DateTime(
                sprintf('%04d-%02d-25', $calendarYear, $calendarMonth)
            );
            $periodStart->modify('-1 month');

            // End = 24th of selected month
            $periodEnd = new DateTime(
                sprintf('%04d-%02d-24', $calendarYear, $calendarMonth)
            );

            // Total days in cycle
            $periodDays = $periodStart->diff($periodEnd)->days + 1;

            // Weekday of starting date
            $startingDay = (int) $periodStart->format('w');

            /*
            * Create attendance lookup
            */
            $attendanceByDate = [];

            foreach ($attendance ?? [] as $row) {

                if (!empty($row['attendance_date'])) {

                    $st = strtoupper(trim($row['attendance_status'] ?? $row['status'] ?? ''));
                    if ($st === 'Y') {
                        $st = 'PRESENT';
                    }
                    $attendanceByDate[$row['attendance_date']] = $st;

                }
            }
            ?>

            <!-- Calendar Header -->
            <div class="d-flex justify-content-between align-items-center mb-3">

                <span class="cal-header-title">
                    Attendance Calendar
                </span>

                <a href="#" class="cal-month-link">
                  <?= $periodStart->format('M d, Y') ?>
                  -
                  <?= $periodEnd->format('M d, Y') ?>
              </a>

            </div>

            <!-- Calendar -->
            <div class="cal-grid mb-3">

                <!-- Weekday Headers -->
                <div class="cal-day-name">S</div>
                <div class="cal-day-name">M</div>
                <div class="cal-day-name">T</div>
                <div class="cal-day-name">W</div>
                <div class="cal-day-name">T</div>
                <div class="cal-day-name">F</div>
                <div class="cal-day-name">S</div>


                <!-- Empty cells before first day -->
                <?php for ($i = 0; $i < $startingDay; $i++): ?>

                    <div class="cal-day-cell empty-cell"></div>

                <?php endfor; ?>


                <!-- Actual Days -->
                <?php
        $currentDate = clone $periodStart;

        for ($i = 0; $i < $periodDays; $i++):

            $date = $currentDate->format('Y-m-d');

            $status = strtoupper(
                trim($attendanceByDate[$date] ?? '')
            );

            switch ($status) {

                case 'PRESENT':
                    $statusClass = 'p-present';
                    break;

                case 'ABSENT':
                    $statusClass = 'p-absent';
                    break;

                case 'HOLIDAY':
                    $statusClass = 'p-holiday';
                    break;

                case 'LEAVE':
                    $statusClass = 'p-leave';
                    break;

                case 'WFH':
                    $statusClass = 'p-wfh';
                    break;

                case 'LATE':
                    $statusClass = 'p-late';
                    break;

                default:
                    $statusClass = '';
                    break;
            }
        ?>

          <div
              class="cal-day-cell <?= $statusClass ?>"
              title="<?= esc($status ?: 'No Record') ?> - <?= $currentDate->format('d M Y') ?>">
              <?= $currentDate->format('d') ?>
          </div>

      <?php
          $currentDate->modify('+1 day');

      endfor; ?>

            </div>

        </div>


        <!-- Legend Footer -->
        <div
            class="d-flex justify-content-between align-items-center pt-2 border-top flex-wrap"
            style="gap: 6px;"
        >

            <div class="legend-item">
                <span class="legend-box bg-p-present"></span>
                PRESENT
            </div>

            <div class="legend-item">
                <span class="legend-box bg-p-absent"></span>
                ABSENT
            </div>

            <div class="legend-item">
                <span class="legend-box bg-p-holiday"></span>
                HOLIDAY
            </div>

            <div class="legend-item">
                <span class="legend-box bg-p-leave"></span>
                LEAVE
            </div>

            <div class="legend-item">
                <span class="legend-box bg-p-wfh"></span>
                WFH
            </div>

        </div>

    </div>
</div>
            <!-- Attendance Log Table Card -->
            <div class="col-12 col-lg-7">
              <div class="ts-card d-flex flex-column justify-content-between">
                <div class="table-responsive">
                  <table class="table ts-table" id="attendanceTable">
                    <thead>
                      <tr>
                        <th>DATE</th>
                        <th>STATUS</th>
                        <th>FIRST IN</th>
                        <th>LAST OUT</th>
                        <th>TOTAL HRS</th>
                      </tr>
                    </thead>
<tbody>

<?php if (!empty($attendance)): ?>

    <?php foreach ($attendance as $index => $row): ?>

        <?php
            $status = strtoupper(trim($row['attendance_status'] ?? $row['status'] ?? ''));
            if ($status === 'Y') {
                $status = 'PRESENT';
            }

            $holidayName = '';

            if ($status == 'HOLIDAY') {
                foreach ($holiday as $h) {
                    if ($h['holiday_date'] == $row['attendance_date']) {
                        $holidayName = $h['holiday_name'];
                        break;
                    }
                }
            }

        if ($status == 'PRESENT') {
            $badgeClass = 'st-present';
        } elseif ($status == 'ABSENT') {
            $badgeClass = 'st-absent';
        } elseif ($status == 'HOLIDAY') {
            $badgeClass = 'st-holiday';
        } elseif ($status == 'LEAVE') {
            $badgeClass = 'st-leave';
        } elseif ($status == 'WFH') {
            $badgeClass = 'st-wfh';
        } else {
            $badgeClass = 'st-off';
        }
        ?>

        <tr
            class="<?= $index == 0 ? 'selected-row' : '' ?> <?= $status == 'HOLIDAY' ? 'holiday-row' : '' ?>"
            onclick="selectRow(
                this,
                '<?= date('d M Y, l', strtotime($row['attendance_date'])) ?>',
                '<?= $row['first_in'] ?? '-' ?>',
                '<?= $row['last_out'] ?? '-' ?>'
            )">

            <!-- DATE -->
            <td class="font-weight-bold">
                <?= date('d M, D', strtotime($row['attendance_date'])) ?>
            </td>

            <?php if ($status == 'HOLIDAY'): ?>

                <!-- STATUS -->
                <td class="holiday-status-cell">
                    <span class="badge-status <?= $badgeClass ?>">
                        HOLIDAY
                    </span>
                </td>

                <!-- EMPTY - NO DASH -->
                <td></td>

                <!-- EMPTY - NO DASH -->
                <td></td>

                <!-- EMPTY - NO DASH -->
                <td></td>

            <?php else: ?>

                <!-- STATUS -->
                <td>
                    <span class="badge-status <?= $badgeClass ?>">
                        <?= esc($status ?: '-') ?>
                    </span>
                </td>

                <!-- FIRST IN -->
                <td>
                    <?= !empty($row['punch_in'])
                        ? date('h:i A', strtotime($row['punch_in']))
                        : '-' ?>
                </td>

                <!-- LAST OUT -->
                <td>
                    <?= !empty($row['punch_out'])
                        ? date('h:i A', strtotime($row['punch_out']))
                        : '-' ?>
                </td>

                <!-- TOTAL HOURS -->
                <td class="font-weight-bold">
                    <?php
                    $rowTotalHrs = '-';
                    if (!empty($row['total_hours']) && $row['total_hours'] !== '-') {
                        $rowTotalHrs = $row['total_hours'];
                    } elseif (!empty($row['daily_time_formatted']) && $row['daily_time_formatted'] !== '-') {
                        $rowTotalHrs = $row['daily_time_formatted'];
                    } elseif (!empty($row['punch_in']) && !empty($row['punch_out']) && $row['punch_in'] != '-' && $row['punch_out'] != '-') {
                        $inTs  = strtotime($row['punch_in']);
                        $outTs = strtotime($row['punch_out']);
                        if ($outTs > $inTs) {
                            $diffSec = $outTs - $inTs;
                            $rowTotalHrs = sprintf('%02d:%02d', floor($diffSec / 3600), floor(($diffSec % 3600) / 60));
                        }
                    }
                    ?>
                    <?= esc($rowTotalHrs) ?>
                </td>

            <?php endif; ?>

        </tr>

    <?php endforeach; ?>

<?php else: ?>

    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td class="text-center text-muted">
            <i class="far fa-calendar-times mr-1"></i>
            No attendance records found for the selected month.
        </td>
        <td></td>
    </tr>

<?php endif; ?>

</tbody>
                  </table>
                </div>

    
              </div>
            </div>
          </div>

        </div>

        <!-- Right Side Panel: Punch Details & Raw Punch Logs (Commented out for time being)
        <div class="col-12 col-xl-3 col-lg-4">
          <div class="punch-panel">
            <div class="d-flex justify-content-between align-items-start mb-3">
              <div>
                <h4 class="punch-panel-title mb-0">Punch Details</h4>
                <div class="punch-panel-date" id="selectedDateText">01 Nov 2023, Wednesday</div>
              </div>
              <button class="btn btn-sm text-muted p-0" title="Close details">
                <i class="fas fa-times" style="font-size: 14px;"></i>
              </button>
            </div>

            <div class="row mb-3">
              <div class="col-6 pr-1">
                <div class="punch-stat-card">
                  <div class="punch-stat-label">FIRST IN</div>
                  <div class="punch-stat-time" id="firstInTime">08:55 AM</div>
                </div>
              </div>
              <div class="col-6 pl-1">
                <div class="punch-stat-card">
                  <div class="punch-stat-label">LAST OUT</div>
                  <div class="punch-stat-time" id="lastOutTime">06:15 PM</div>
                </div>
              </div>
            </div>

            <div class="font-weight-bold text-dark mb-2" style="font-size: 13px;">Raw Punch Logs</div>

            <div class="punch-timeline">
              <div class="timeline-item">
                <div class="timeline-dot dot-blue"></div>
                <div class="d-flex justify-content-between align-items-center">
                  <span class="timeline-event-title">IN (Biometric)</span>
                  <span class="timeline-event-time">08:55 AM</span>
                </div>
                <div class="timeline-event-loc">
                  <i class="fas fa-map-marker-alt text-muted" style="font-size: 10px;"></i>
                  Main Gate Turnstile A
                </div>
              </div>

              <div class="timeline-item">
                <div class="timeline-dot"></div>
                <div class="d-flex justify-content-between align-items-center">
                  <span class="timeline-event-title">OUT (Break)</span>
                  <span class="timeline-event-time">01:00 PM</span>
                </div>
                <div class="timeline-event-loc">
                  <i class="fas fa-map-marker-alt text-muted" style="font-size: 10px;"></i>
                  Cafeteria Door
                </div>
              </div>

              <div class="timeline-item">
                <div class="timeline-dot dot-blue"></div>
                <div class="d-flex justify-content-between align-items-center">
                  <span class="timeline-event-title">IN (Break Return)</span>
                  <span class="timeline-event-time">01:45 PM</span>
                </div>
                <div class="timeline-event-loc">
                  <i class="fas fa-map-marker-alt text-muted" style="font-size: 10px;"></i>
                  Cafeteria Door
                </div>
              </div>

              <div class="timeline-item">
                <div class="timeline-dot"></div>
                <div class="d-flex justify-content-between align-items-center">
                  <span class="timeline-event-title">OUT (Biometric)</span>
                  <span class="timeline-event-time">06:15 PM</span>
                </div>
                <div class="timeline-event-loc">
                  <i class="fas fa-map-marker-alt text-muted" style="font-size: 10px;"></i>
                  Main Gate Turnstile B
                </div>
              </div>
            </div>

            <button class="btn-regularization mt-auto" data-toggle="modal" data-target="#regularizationModal">
              <i class="fas fa-file-signature text-primary"></i>
              Request Regularization
            </button>
          </div>
        </div>
        -->
      </div>

    </div>
  </section>
</div>

<!-- Modal for Request Regularization (Commented out for time being)
<div class="modal fade" id="regularizationModal" tabindex="-1" role="dialog" aria-labelledby="regModalTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content" style="border-radius: 16px; border: none; box-shadow: 0 10px 25px rgba(0,0,0,0.15);">
      <div class="modal-header border-0 pb-0">
        <h5 class="modal-title font-weight-bold" id="regModalTitle" style="color: var(--slate-900); font-size: 16px;">
          Request Attendance Regularization
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body pt-3">
        <form id="regForm">
          <div class="form-group mb-3">
            <label class="font-weight-bold small text-muted">DATE</label>
            <input type="text" class="form-control filter-input" value="01 Nov 2023" readonly>
          </div>
          <div class="row mb-3">
            <div class="col-6">
              <label class="font-weight-bold small text-muted">CORRECT IN TIME</label>
              <input type="time" class="form-control filter-input" value="08:55">
            </div>
            <div class="col-6">
              <label class="font-weight-bold small text-muted">CORRECT OUT TIME</label>
              <input type="time" class="form-control filter-input" value="18:15">
            </div>
          </div>
          <div class="form-group mb-3">
            <label class="font-weight-bold small text-muted">REASON FOR REGULARIZATION</label>
            <textarea class="form-control" rows="3" placeholder="Explain reason (e.g., Biometric missed, Client meeting, Device error)..." style="border-radius: 10px; font-size: 12px; border: 1px solid var(--slate-200);"></textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer border-0 pt-0">
        <button type="button" class="btn btn-light" data-dismiss="modal" style="border-radius: 10px; font-weight: 600; font-size: 12px;">Cancel</button>
        <button type="button" class="btn btn-primary" onclick="alert('Regularization request submitted successfully!')" style="background: var(--bloom-purple); border: none; border-radius: 10px; font-weight: 700; font-size: 12px; padding: 8px 18px;">Submit Request</button>
      </div>
    </div>
  </div>
</div>
-->

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>

<script>
$(document).ready(function () {

    $('#attendanceTable').DataTable({
        responsive: true,
        paging: true,
        ordering: true,
        searching: true,
        info: true,
        lengthChange: true,
        pageLength: 5,

        lengthMenu: [
            [5, 10, 25, 50],
            [5, 10, 25, 50]
        ],

        order: [],

        scrollY: '300px',
        scrollCollapse: false,

        dom: "<'row'<'col-md-6'l><'col-md-6'f>>" +
             "t" +
             "<'row'<'col-md-6'i><'col-md-6'p>>"
    });

});
</script>

<script>
  function selectRow(element, dateStr, firstIn, lastOut) {
    // Remove selected class from all rows
    $('#attendanceTable tbody tr').removeClass('selected-row');
    // Add selected class to clicked row
    $(element).addClass('selected-row');

    // Update right panel values if present
    if ($('#selectedDateText').length) {
      $('#selectedDateText').text(dateStr);
      $('#firstInTime').text(firstIn);
      $('#lastOutTime').text(lastOut);
    }
  }
</script>

</html>