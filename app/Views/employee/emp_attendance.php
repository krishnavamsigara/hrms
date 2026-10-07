<?php

/*
 * Selected month/year
 */
$selectedMonth = (int)($selectedMonth ?? date('m'));
$selectedYear  = (int)($selectedYear ?? date('Y'));

/*
 * Team attendance report
 */
$report = $report ?? [];

/*
 * Get attendance period from backend.
 *
 * Example for August 2026:
 * period_start = 2026-07-25
 * period_end   = 2026-08-24
 */
$periodStart     = $report[0]['period_start'] ?? null;
$periodEnd       = $report[0]['period_end'] ?? null;
$calculatedUntil = $report[0]['calculated_until'] ?? null;

$gridDates = [];

if (!empty($periodStart) && !empty($calculatedUntil)) {

    $startDate = new \DateTime($periodStart);
    $endDate   = new \DateTime($calculatedUntil);

    while ($startDate <= $endDate) {

        $gridDates[] = clone $startDate;

        $startDate->modify('+1 day');
    }
}
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

/* Full Team Attendance Grid */

.team-attendance-scroll {
    max-height: 650px;
    overflow: auto;
}

.team-attendance-table {
    min-width: max-content;
    margin-bottom: 0;
}

.team-attendance-table th,
.team-attendance-table td {
    white-space: nowrap;
    vertical-align: middle;
    text-align: center;
}

.team-attendance-table th:first-child,
.team-attendance-table td:first-child {
    position: sticky;
    left: 0;
    z-index: 3;
    background: #ffffff;
    text-align: left;
    min-width: 220px;
}

.team-attendance-table thead th {
    position: sticky;
    top: 0;
    z-index: 4;
    background: #ffffff;
}

.team-attendance-table thead th:first-child {
    z-index: 5;
}

.team-attendance-table td {
    padding: 10px 12px;
    font-size: 12px;
    font-weight: 600;
}

.team-attendance-table th {
    padding: 10px 12px;
    font-size: 10px;
    font-weight: 700;
    color: var(--slate-500);
    border-bottom: 1px solid var(--slate-200);
}

.attendance-present {
    color: var(--bloom-purple);
    font-weight: 800;
}

.attendance-date-today {
    color: var(--bloom-danger) !important;
    font-weight: 800 !important;
}

/* ==========================================
   FULL TEAM ATTENDANCE GRID
   ========================================== */

.team-attendance-scroll {
    width: 100%;
    max-width: 100%;
    max-height: 620px;

    overflow-x: auto;
    overflow-y: auto;

    position: relative;

    border-top: 1px solid var(--slate-200);
}


/* Main table */
.team-attendance-table {
    width: max-content !important;
    min-width: 100%;
    margin-bottom: 0 !important;
    border-collapse: separate;
    border-spacing: 0;
    table-layout: fixed;
}


/* ------------------------------------------
   Employee column
   ------------------------------------------ */

.team-attendance-table th:first-child,
.team-attendance-table td:first-child {
    position: sticky;
    left: 0;

    width: 220px !important;
    min-width: 220px !important;
    max-width: 220px !important;

    background: #ffffff;

    text-align: left;

    z-index: 10;

    border-right: 1px solid var(--slate-200);
}


/* Shadow on sticky employee column */
.team-attendance-table th:first-child {
    z-index: 20;
    box-shadow: 4px 0 8px rgba(15, 23, 42, 0.06);
}

.team-attendance-table td:first-child {
    box-shadow: 4px 0 8px rgba(15, 23, 42, 0.04);
}


/* ------------------------------------------
   Date columns
   ------------------------------------------ */

.team-attendance-table th:not(:first-child),
.team-attendance-table td:not(:first-child) {

    width: 52px !important;
    min-width: 52px !important;
    max-width: 52px !important;

    text-align: center;

    white-space: nowrap;
}


/* ------------------------------------------
   Header
   ------------------------------------------ */

.team-attendance-table thead th {
    position: sticky;
    top: 0;

    height: 58px;

    background: #ffffff;

    z-index: 15;

    padding: 7px 5px !important;

    font-size: 10px;
    font-weight: 700;

    color: var(--slate-600);

    border-bottom: 1px solid var(--slate-200);
}


/* Top-left employee header must stay above everything */
.team-attendance-table thead th:first-child {
    z-index: 30;
    background: #ffffff;
}


/* ------------------------------------------
   Body cells
   ------------------------------------------ */

.team-attendance-table tbody td {

    height: 55px;

    padding: 8px 5px !important;

    font-size: 12px;
    font-weight: 600;

    vertical-align: middle;

    border-bottom: 1px solid var(--slate-100);

    background: #ffffff;
}


/* Employee rows */
.team-attendance-table tbody td:first-child {
    background: #ffffff;
}


/* Row hover */
.team-attendance-table tbody tr:hover td {
    background-color: #f8fafc;
}


/* Keep sticky employee cell white on hover */
.team-attendance-table tbody tr:hover td:first-child {
    background-color: #f8fafc;
}


/* ------------------------------------------
   Attendance Present
   ------------------------------------------ */

.attendance-present {
    color: #3730a3 !important;
    font-weight: 800;
    font-size: 13px;
}


/* ------------------------------------------
   Today's date
   ------------------------------------------ */

.attendance-date-today {
    color: var(--bloom-danger) !important;
    font-weight: 800 !important;
}


/* ------------------------------------------
   Date number
   ------------------------------------------ */

.team-attendance-table thead th small {
    font-size: 8px !important;
    color: var(--slate-400) !important;
    font-weight: 600;
}


/* ------------------------------------------
   Scrollbar
   ------------------------------------------ */

.team-attendance-scroll::-webkit-scrollbar {
    width: 9px;
    height: 9px;
}

.team-attendance-scroll::-webkit-scrollbar-track {
    background: #f1f5f9;
    border-radius: 10px;
}

.team-attendance-scroll::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 10px;
}

.team-attendance-scroll::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}


/* ------------------------------------------
   Mobile
   ------------------------------------------ */

@media (max-width: 768px) {

    .team-attendance-scroll {
        max-height: 550px;
    }

    .team-attendance-table th:first-child,
    .team-attendance-table td:first-child {

        width: 180px !important;
        min-width: 180px !important;
        max-width: 180px !important;
    }

    .team-attendance-table th:not(:first-child),
    .team-attendance-table td:not(:first-child) {

        width: 48px !important;
        min-width: 48px !important;
        max-width: 48px !important;
    }

}

/* --- BLOOM BACK BUTTON --- */
.btn-bloom-back {
    background: #fff;
    color: var(--bloom-purple) !important;
    border: 1px solid var(--bloom-purple);
    border-radius: 10px;
    font-weight: 700;
    font-size: 12px;
    padding: 8px 18px;
    transition: all 0.3s ease;
    box-shadow: 0 2px 4px rgba(74, 0, 224, 0.08);
}

.btn-bloom-back:hover {
    background: linear-gradient(
        135deg,
        var(--bloom-purple) 0%,
        var(--bloom-dark) 100%
    );
    color: #fff !important;
    border-color: var(--bloom-purple);
    transform: translateY(-1px);
    box-shadow: 0 4px 10px rgba(74, 0, 224, 0.20);
}

.btn-bloom-back i {
    font-size: 11px;
}

/* Attendance Status Colors */

.attendance-present {
    background-color: #d1fae5 !important;
    color: #047857 !important;
    font-weight: 800;
    font-size: 13px;
    padding: 3px 7px;
    border-radius: 6px;
    display: inline-block;
}

/* Absent */
.bg-rejected {
    background-color: #fee2e2 !important;
    color: #b91c1c !important;
}

/* Leave */
.bg-info-subtle {
    background-color: #dbeafe !important;
    color: #1d4ed8 !important;
}

/* Week Off / Holiday */
.bg-wo {
    background-color: #f1f5f9 !important;
    color: #475569 !important;
}

/* WFH */
.bg-success {
    background-color: #dcfce7 !important;
    color: #15803d !important;
}

.attendance-late {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: #fff3e0;
    color: #e67e22;
    border-radius: 5px;
    padding: 4px 8px;
    font-weight: 600;
}
/* Common badge styling */
.badge-status {
    display: inline-block;
    min-width: 28px;
    text-align: center;
    font-size: 10px;
    font-weight: 800;
    padding: 4px 7px;
    border-radius: 6px;
    line-height: 1.2;
}
.card-bloom {
    background: #ffffff;
    border: 1px solid var(--slate-200);
    border-radius: 16px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
}
  </style>
</head>

<div class="content-wrapper">
  <section class="content pt-3">
    <div class="container-fluid">

    <div class="card-bloom mb-3">
    <div class="p-3">
        
        <!-- Your Month / Year Filter Form -->
        <form method="get"
              action="<?= base_url('employee/emp_attendance') ?>#attendance"
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
                            <?= ((int)$selectedMonth === $m) ? 'selected' : '' ?>>
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
                            <?= ((int)$selectedYear === $y) ? 'selected' : '' ?>>
                            <?= $y ?>
                        </option>
                    <?php endfor; ?>
                </select>
            </div>

            <button type="submit"
                    class="btn btn-sm"
                    style="
                        height:31px;
                        background:var(--bloom-purple);
                        color:#fff;
                        border-radius:8px;
                        font-weight:700;
                        padding:0 15px;
                    ">
                Submit
            </button>

        </form>

    </div>
</div>

<div class="card-bloom">

    <!-- Header -->
    <div class="p-3 border-bottom d-flex justify-content-between align-items-center flex-wrap">

        <div>
            <h6 class="font-weight-bold mb-1">
                <?= date('F', mktime(0, 0, 0, $selectedMonth, 1)) ?>
                Team Attendance
            </h6>

            <?php if (!empty($periodStart) && !empty($periodEnd)): ?>

                <small class="text-muted font-weight-bold">
                    <?= date('d M Y', strtotime($periodStart)) ?>
                    -
                    <?= date('d M Y', strtotime($periodEnd)) ?>
                </small>

            <?php endif; ?>
        </div>


        <!-- Legend -->
        <div class="d-flex align-items-center mt-2 mt-md-0">

            <!-- <span class="badge badge-status bg-info-subtle mr-1">
                Lea
            </span>

            <span class="badge badge-status bg-rejected mr-1">
                Abs
            </span>

            <span class="badge badge-status bg-wo mr-1">
                Off
            </span>

            <span class="badge badge-status bg-success">
                WFH
            </span> -->

        </div>

    </div>


    <!-- Attendance Table -->
   <div class="team-attendance-scroll">

        <table class="table text-center team-attendance-table">

            <thead>
    <tr>

        <th class="text-center" style="font-size: 14px; font-weight: 700;">
    Employee
</th>

        <?php foreach ($gridDates as $date): ?>

    <?php
    $dateKey = $date->format('Y-m-d');
    $isToday = ($dateKey === date('Y-m-d'));
    ?>

    <th class="<?= $isToday ? 'attendance-date-today' : '' ?> text-center">

        <div style="font-size:10px; font-weight:700; color:#64748b;">
            <?= strtoupper($date->format('M')) ?>
        </div>

        <div style="font-size:14px;font-weight:800;">
            <?= $date->format('d') ?>
        </div>

        <small class="d-block" style="font-size:10px; font-weight:700; color:#64748b;">
            <?= strtoupper($date->format('D')) ?>
        </small>

    </th>

<?php endforeach; ?>

    </tr>
</thead>


            <tbody>

        <?php
        $hasEmployee = false;
        $backendRemarks = '';

        if (!empty($report) && is_array($report)) {
            foreach ($report as $item) {
                if (($item['status'] ?? '') === 'N') {
                    $backendRemarks = $item['remarks'] ?? '';
                    break;
                }
            }
        }
        ?>

<?php foreach ($report as $employee): ?>

    <?php
    $employeeName = trim($employee['employee_name'] ?? '');

    if ($employeeName === '') {
        continue;
    }

    $hasEmployee = true;

    $employeeId = $employee['emp_id'] ?? '';

    $attendanceData = json_decode(
        $employee['attendance_data'] ?? '[]',
        true
    );

    $attendanceByDate = [];

    foreach ($attendanceData as $attendanceItem) {

        if (!empty($attendanceItem['date'])) {

            $attendanceByDate[$attendanceItem['date']]
                = strtoupper($attendanceItem['status'] ?? '');

        }
    }
    ?>

                        <?php

                        /*
                         * Employee information
                         */
                        $employeeName =
                            $employee['employee_name'] ?? 'Employee';

                        $employeeId =
                            $employee['emp_id'] ?? '';



                        /*
                         * Decode attendance JSON
                         */
                        $attendanceData = json_decode(
                            $employee['attendance_data'] ?? '[]',
                            true
                        );


                        /*
                         * Create date => status lookup
                         */
                        $attendanceByDate = [];

                        foreach ($attendanceData as $attendanceItem) {

                            if (!empty($attendanceItem['date'])) {

                                $attendanceByDate[
                                    $attendanceItem['date']
                                ] = strtoupper(
                                    $attendanceItem['status'] ?? ''
                                );

                            }
                        }

                        ?>

                        <tr>

                            <!-- Employee -->
                            <td class="font-weight-bold">

                                <div class="d-flex align-items-center">

                                        <img
                                            src="https://ui-avatars.com/api/?name=<?= urlencode($employeeName) ?>&background=4a00e0&color=fff"
                                            class="rounded-circle mr-2"
                                            style="
                                                width:32px;
                                                height:32px;
                                            "
                                        >
                                    <div>

                                        <div>
                                            <?= esc($employeeName) ?>
                                        </div>

                                        <small class="text-muted">
                                            <?= esc($employeeId) ?>
                                        </small>

                                    </div>

                                </div>

                            </td>


                            <!-- Attendance Dates -->
                            <?php foreach ($gridDates as $date): ?>

                                <?php

                                $dateKey =
                                    $date->format('Y-m-d');

                                $status =
                                    $attendanceByDate[$dateKey] ?? '';

                                ?>

                                <td>

                                  <?php if ($status === 'PRESENT'): ?>

                                    <span class="badge-status attendance-present">
                                        P
                                    </span>

                                    <?php elseif ($status === 'ABSENT'): ?>

                                        <span class="badge-status bg-rejected">
                                            A
                                        </span>

                                    <?php elseif ($status === 'LEAVE'): ?>

                                        <span class="badge-status bg-info-subtle">
                                            L
                                        </span>

                                    <?php elseif ($status === 'HOLIDAY'): ?>

                                        <span class="badge-status bg-wo">
                                            H
                                        </span>

                                    <?php elseif ($status === 'WFH'): ?>

                                        <span class="badge-status bg-success">
                                            WFH
                                        </span>

                                        <?php elseif ($status === 'LATE'): ?>

                                        <span class="attendance-late">
                                            L
                                        </span>


                                    <?php else: ?>

                                        -

                                    <?php endif; ?>

                                </td>

                            <?php endforeach; ?>

                        </tr>

                <?php endforeach; ?>


                <?php if (!$hasEmployee): ?>

                <tr>
                    <td
                        colspan="<?= count($gridDates) + 1 ?>"
                        class="text-center text-muted py-4">
                        <i class="fas fa-users mr-2"></i>
                        <?= esc($backendRemarks ?: 'No employees are there/assigned.') ?>
                    </td>
                </tr>

            <?php endif; ?>

            </tbody>

        </table>

    </div>

</div>

<div class="d-flex justify-content-start mb-3" style="margin-top:10px;">
    <button type="button"
        class="btn btn-bloom-back"
        onclick="window.location.href='<?= base_url('employee/myteammgr') ?>#attendance';">
        <i class="fas fa-arrow-left mr-1"></i> Back
    </button>
</div>

</div>
 </section>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>

</html>