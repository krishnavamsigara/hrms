<?php
$attendanceSummary = $attendance[0] ?? [];

$totalEmployees = $attendanceSummary['total_employees_count'] ?? 0;
$presentCount   = $attendanceSummary['today_present_count'] ?? 0;
$leaveCount     = $attendanceSummary['today_leave_count'] ?? 0;
$absentCount    = $attendanceSummary['today_absent_count'] ?? 0;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BloomHR | Attendance Management</title>

    <!-- Google Font: Plus Jakarta Sans -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- AdminLTE 3 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">


    <style>
        :root {
            --bloom-purple: #4a00e0;
            --bloom-dark: #2a0080;
            --mtn-deep: #120038;
            --bloom-orange: #e46c44;
            --bloom-success: #10b981;
            --bloom-danger: #dc2626;
            --glass: rgba(255, 255, 255, 0.95);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
            font-size: 13px;
            color: #334155;
        }

        /* --- LAYOUT & SPACING FIXES --- */
        .content-wrapper {
            min-height: auto !important;
            padding-bottom: 0px !important;
            background-color: #f8fafc;
        }

        .content {
            padding-bottom: 20px !important;
        }

        .row:last-of-type,
        .row:last-of-type .col-lg-12,
        .row:last-of-type .card {
            margin-bottom: 0px !important;
        }

        .main-footer {
            margin-top: 0px !important;
            padding: 8px 1.5rem !important;
            background: #fff !important;
            border-top: 1px solid #e2e8f0 !important;
            color: #64748b;
            font-size: 12px;
        }

        /* --- NAVIGATION & SIDEBAR --- */
        .main-header {
            border-bottom: 1px solid #e2e8f0 !important;
            background: var(--glass) !important;
            backdrop-filter: blur(10px);
        }

        .main-sidebar {
            background: var(--mtn-deep) !important;
            box-shadow: 4px 0 10px rgba(0, 0, 0, 0.03) !important;
        }

        .custom-brand {
            display: flex;
            align-items: center;
            padding: 12px 16px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        .logo-circle {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #fff;
            margin-right: 10px;
        }

        .brand-text {
            font-size: 18px;
            font-weight: 700;
        }

        .brand-blue {
            color: #4a8cff;
        }

        .brand-orange {
            color: #ff7a45;
        }

        /* --- BLOOM CARD STYLING --- */
        .card-bloom {
            transition: transform 0.2s ease;
            border: 1px solid #e2e8f0 !important;
            border-radius: 16px !important;
            background: #fff;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.03) !important;
            margin-bottom: 1rem;
        }

        /* --- SUMMARY STAT BOXES --- */
        .summary-stat-card {
            border-radius: 12px;
            padding: 1rem;
            text-align: center;
            border: 1px solid #e2e8f0;
            background: #fff;
            height: 100%;
        }

        /* --- TIMESHEET TABLE STYLING --- */
        .table-timesheet {
            font-size: 12.5px;
            border-collapse: separate;
            border-spacing: 0;
        }

        .table-timesheet th {
            border-top: none;
            border-bottom: 1px solid #e2e8f0;
            color: #475569;
            font-weight: 700;
            background: #f8fafc;
            vertical-align: middle;
            text-align: center;
        }

        .table-timesheet td {
            vertical-align: middle;
            border-top: 1px solid #f1f5f9;
            text-align: center;
        }

        .time-chip {
            display: inline-block;
            background: #f1f5f9;
            color: #334155;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 600;
            margin: 1px 0;
        }

        .time-chip-late {
            background: #fef3c7;
            color: #b45309;
        }

        .badge-absent-cell {
            color: var(--bloom-danger);
            font-weight: 700;
            font-size: 11px;
            letter-spacing: 0.5px;
        }

        .avatar-circle {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: #e0e7ff;
            color: #4338ca;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
        }

        .dot-indicator {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 4px;
        }

        .footer-link {
            color: var(--bloom-purple);
            font-weight: 600;
            text-decoration: none;
        }

        /* ==========================================
   MASTER TIMESHEET - SCROLLABLE DATE AREA
   ========================================== */

.timesheet-wrapper::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}

.table-timesheet {
    border-collapse: separate !important;
    border-spacing: 0;
    min-width: max-content;
}

/* Employee column - fixed */
.table-timesheet .employee-fixed {
    position: sticky;
    left: 0;
    z-index: 5;
    background: #fff;
    min-width: 220px;
    width: 220px;
    box-shadow: 3px 0 5px rgba(0, 0, 0, 0.04);
}

/* Header employee */
.table-timesheet thead .employee-fixed {
    z-index: 10;
    background: #f8fafc;
}

/* Date columns */
.table-timesheet .date-column {
    min-width: 95px;
    width: 95px;
}

/* Fixed summary columns on right */
.table-timesheet .summary-fixed {
    position: sticky;
    right: 0;
    z-index: 5;
    background: #fff;
    min-width: 85px;
    width: 85px;
    box-shadow: -3px 0 5px rgba(0, 0, 0, 0.04);
}

/* Header summary columns */
.table-timesheet thead .summary-fixed {
    z-index: 10;
    background: #f8fafc;
}

/* Keep Total Hrs slightly wider */
.table-timesheet .total-hours-fixed {
    position: sticky;
    right: 0;
    z-index: 5;
    background: #fff;
    min-width: 100px;
    width: 100px;
    box-shadow: -3px 0 5px rgba(0, 0, 0, 0.04);
}

.table-timesheet thead .total-hours-fixed {
    z-index: 10;
    background: #f8fafc;
}

/* Scrollbar */
.timesheet-wrapper::-webkit-scrollbar {
    height: 8px;
}

.timesheet-wrapper::-webkit-scrollbar-track {
    background: #f1f5f9;
    border-radius: 10px;
}

.timesheet-wrapper::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 10px;
}

.timesheet-wrapper::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}

/* Status cells */
.timesheet-status {
    font-size: 10px;
    font-weight: 700;
    letter-spacing: .3px;
}

.badge-present-cell {
    color: #15803d;
    font-weight: 700;
    font-size: 10px;
}

.badge-absent-cell {
    color: #dc2626;
    font-weight: 700;
    font-size: 10px;
}

.badge-late-cell {
    color: #b45309;
    font-weight: 700;
    font-size: 10px;
}

.badge-holiday-cell {
    color: #64748b;
    font-weight: 700;
    font-size: 10px;
}

.badge-leave-cell {
    color: #ca8a04;
    font-weight: 700;
    font-size: 10px;
}

.badge-wfh-cell {
    color: #2563eb;
    font-weight: 700;
    font-size: 10px;
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

/* ==========================================
   MASTER TIMESHEET
   FIXED EMPLOYEE + FIXED SUMMARY
   SCROLL ONLY DATE COLUMNS
   ========================================== */

.timesheet-wrapper {
    width: 100%;
    max-width: 100%;
    overflow: visible;
    position: relative;
}


/* ------------------------------------------
   ALL CELLS
   ------------------------------------------ */

.table-timesheet th,
.table-timesheet td {
    box-sizing: border-box;
}

/* ------------------------------------------
   EMPLOYEE COLUMN - FIXED LEFT
   ------------------------------------------ */

.table-timesheet .employee-fixed {
    position: sticky !important;
    left: 0 !important;

    width: 220px !important;
    min-width: 220px !important;
    max-width: 220px !important;

    z-index: 20 !important;

    background: #fff !important;

    box-shadow: 3px 0 6px rgba(0, 0, 0, 0.08);

    white-space: normal;
}

/* Employee HEADER */
.table-timesheet thead .employee-fixed {
    z-index: 50 !important;
    background: #f8fafc !important;
}

/* ------------------------------------------
   DATE COLUMNS - SCROLLABLE
   ------------------------------------------ */

.table-timesheet .date-column {
    width: 95px !important;
    min-width: 95px !important;
    max-width: 95px !important;

    text-align: center;
}

/* ------------------------------------------
   SUMMARY COLUMNS - FIXED RIGHT
   ------------------------------------------ */

.table-timesheet .summary-fixed {
    position: sticky !important;

    width: 85px !important;
    min-width: 85px !important;
    max-width: 85px !important;

    background: #fff !important;

    z-index: 20 !important;

    box-shadow: -3px 0 6px rgba(0, 0, 0, 0.08);
}

/*
   IMPORTANT:
   Each right-fixed column needs its own right position.
*/

.table-timesheet th.summary-fixed:nth-last-child(4),
.table-timesheet td.summary-fixed:nth-last-child(4) {
    right: 270px !important;
}

.table-timesheet th.summary-fixed:nth-last-child(3),
.table-timesheet td.summary-fixed:nth-last-child(3) {
    right: 185px !important;
}

.table-timesheet th.summary-fixed:nth-last-child(2),
.table-timesheet td.summary-fixed:nth-last-child(2) {
    right: 100px !important;
}

/* ------------------------------------------
   TOTAL HOURS - FIXED RIGHT
   ------------------------------------------ */

.table-timesheet .total-hours-fixed {
    position: sticky !important;

    right: 0 !important;

    width: 100px !important;
    min-width: 100px !important;
    max-width: 100px !important;

    background: #fff !important;

    z-index: 20 !important;

    box-shadow: -3px 0 6px rgba(0, 0, 0, 0.08);
}

/* ------------------------------------------
   HEADER FIXING
   ------------------------------------------ */

.table-timesheet thead th {
    position: sticky;
    top: 0;

    background: #f8fafc !important;

    z-index: 30;
}

/* Employee header must be above everything */
.table-timesheet thead .employee-fixed {
    position: sticky !important;
    left: 0 !important;
    top: 0 !important;
    z-index: 60 !important;
}

/* Summary headers must be above date headers */
.table-timesheet thead .summary-fixed {
    position: sticky !important;
    top: 0 !important;
    z-index: 60 !important;
}

/* Total hours header */
.table-timesheet thead .total-hours-fixed {
    position: sticky !important;
    right: 0 !important;
    top: 0 !important;
    z-index: 60 !important;
}

/* ------------------------------------------
   BODY
   ------------------------------------------ */

.table-timesheet tbody td {
    background: #fff;
}

/* Keep fixed body columns above scrolling dates */
.table-timesheet tbody .employee-fixed,
.table-timesheet tbody .summary-fixed,
.table-timesheet tbody .total-hours-fixed {
    z-index: 20 !important;
}

/* ------------------------------------------
   SCROLLBAR
   ------------------------------------------ */

.timesheet-wrapper::-webkit-scrollbar {
    height: 8px;
}

.timesheet-wrapper::-webkit-scrollbar-track {
    background: #f1f5f9;
    border-radius: 10px;
}

.timesheet-wrapper::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 10px;
}

.timesheet-wrapper::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
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

/* Only attendance table scrolls vertically */
.timesheet-scroll {
    width: 100%;
    overflow-x: auto;
    overflow-y: visible;
    position: relative;
}

/* Keep table header visible while scrolling rows */
.timesheet-scroll .table-timesheet thead th {
    position: sticky;
    top: 0;
    z-index: 20;
}
/* Back button outside card */
.btn-bloom-back {
    margin-bottom: 20px !important;
    position: relative;
    z-index: 5;
}

/* Reduce gap between Show Entries/Search and table */
#masterTable_wrapper .row:first-child {
    margin-bottom: 1px !important;
}

#masterTable_wrapper .dataTables_length,
#masterTable_wrapper .dataTables_filter {
    margin-bottom: 0 !important;
}
    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <section class="content pt-3">
                <div class="container-fluid">
              
                    <!-- Page Header Row -->
                    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-3">
                        <div>
                            <h4 class="font-weight-bold mb-0" style="color: var(--mtn-deep);">Time Sheet</h4>
                            <small class="text-muted">Attendance Overview for Current Period (25th - 24th)</small>
                        </div>
                       <form method="get" action="<?= base_url('admin/master_time_sheet') ?>">

                        <div class="d-flex align-items-end" style="gap: 8px;">

                            <!-- Month -->
                            <div style="width: 130px;">
                                <label class="font-weight-bold mb-1" style="font-size: 11px;">
                                    Month
                                </label>

                                <select name="month"
                                    class="form-control form-control-sm font-weight-bold">

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
                            <div style="width: 100px;">
                                <label class="font-weight-bold mb-1" style="font-size: 11px;">
                                    Year
                                </label>

                                <select name="year"
                                    class="form-control form-control-sm font-weight-bold">

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


                            <!-- Submit -->
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

                                Submit

                            </button>

                        </div>

                    </form>
                    </div>

                

                    <!-- Master Attendance Timesheet Card -->
                    <div class="card card-bloom mb-3">
                        <div class="card-header bg-white border-bottom py-3 d-flex flex-column flex-md-row align-items-md-center justify-content-end">
                            <h6 class="font-weight-bold mb-2 mb-md-0 d-flex align-items-center" style="color: var(--mtn-deep);">
                                <i class="fas fa-th-large text-primary mr-2"></i>Monthly Attendance Timesheet
                            </h6>
                            <div class="d-flex align-items-center justify-content-end ml-auto" style="gap: 8px;">
                                <div class="input-group input-group-sm">
                                    <?php
                            $firstReport = $report[0] ?? [];

                            $periodStart = $firstReport['period_start'] ?? null;
                            $periodEnd   = $firstReport['calculated_until'] ?? ($filterDate ?? date('Y-m-d'));
                            ?>

                            <div class="input-group input-group-sm">

                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-light border-right-0 text-muted"
                                        style="border-radius:8px 0 0 8px;">
                                        Period:
                                    </span>
                                </div>

                                <div class="form-control border-left-0 font-weight-bold text-secondary"
                                    style="border-radius:0 8px 8px 0; white-space:nowrap;">

                                    <?php if ($periodStart): ?>

                                        <?= date('d M Y', strtotime($periodStart)) ?>
                                        -
                                        <?= date('d M Y', strtotime($periodEnd)) ?>

                                    <?php else: ?>

                                        <?= date('d M Y', strtotime($filterDate ?? date('Y-m-d'))) ?>

                                    <?php endif; ?>

                                </div>

                            </div>
                                </div>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-primary dropdown-toggle font-weight-bold px-3 shadow-sm" type="button" data-toggle="dropdown" style="border-radius: 8px; background: linear-gradient(135deg, var(--bloom-purple), var(--bloom-dark)); border: none;">
                                        <i class="fas fa-download mr-1"></i> Export
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="#"><i class="far fa-file-excel mr-2 text-success"></i> Excel</a>
                                        <a class="dropdown-item" href="#"><i class="far fa-file-pdf mr-2 text-danger"></i> PDF</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Filters & Legend Bar -->
                        <div class="card-body bg-light border-bottom py-2 px-3">
                            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between" style="gap: 10px;">
                                <!-- <div class="d-flex align-items-center flex-wrap" style="gap: 8px; flex: 1;">
                                    <span class="text-muted font-weight-bold" style="font-size: 11px;"><i class="fas fa-filter mr-1"></i> Filters |</span>
                                    <div class="input-group input-group-sm" style="max-width: 240px;">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-white border-right-0"><i class="fas fa-search text-muted"></i></span>
                                        </div>
                                        <input type="text" class="form-control border-left-0 pl-0" placeholder="Search employee...">
                                    </div>
                                    <select class="custom-select custom-select-sm" style="width: auto; border-radius: 6px;">
                                        <option>All Departments</option>
                                    </select>
                                    <select class="custom-select custom-select-sm" style="width: auto; border-radius: 6px;">
                                        <option>All Locations</option>
                                    </select>
                                </div> -->

                                <!-- <div class="d-flex align-items-center" style="gap: 12px; font-size: 11px; font-weight: 600;">
                                    <span><span class="dot-indicator bg-danger"></span> Absent</span>
                                    <span><span class="dot-indicator" style="background: #d97706;"></span> Late</span>
                                </div> -->
                            </div>
                        </div>

                        <!-- Main Table -->
                      
                        <div class="card-body p-0">

                           <?php
                        $reports = $report ?? [];

                        $firstReport = $reports[0] ?? [];

                        $periodStart = $firstReport['period_start'] ?? null;

                        /*
                        * IMPORTANT:
                        * calculated_until is the last date for which attendance
                        * should actually be displayed.
                        *
                        * Example:
                        * September 2026
                        * period_start     = 25-Aug-2026
                        * period_end       = 24-Sep-2026
                        * calculated_until = 01-Sep-2026
                        *
                        * Therefore display only:
                        * 25-Aug → 01-Sep
                        */
                        $calculatedUntil = $firstReport['calculated_until'] ?? null;

                        $dates = [];

                        if ($periodStart && $calculatedUntil) {

                            $startDate = new DateTime($periodStart);
                            $endDate   = new DateTime($calculatedUntil);

                            $currentDate = clone $startDate;

                            while ($currentDate <= $endDate) {

                                $dates[] = $currentDate->format('Y-m-d');

                                $currentDate->modify('+1 day');
                            }
                        }
                        ?>
                            <div class="timesheet-wrapper">

                                <table class="table table-timesheet mb-0" id="masterTable">

                                    <thead>

                                        <tr>

                                            <!-- FIXED EMPLOYEE -->
                                            <th class="text-left pl-3 employee-fixed">
                                                Employee
                                            </th>


                                            <!-- DYNAMIC DATES -->
                                            <?php foreach ($dates as $date): ?>

                                                <?php
                                                $dateObj = new DateTime($date);
                                                ?>

                                                <th class="date-column">

                                                    <?= $dateObj->format('d M') ?>

                                                    <br>

                                                    <small class="text-muted font-weight-normal">
                                                        <?= $dateObj->format('D') ?>
                                                    </small>

                                                </th>

                                            <?php endforeach; ?>


                                            <!-- FIXED SUMMARY -->
                                            <th class="summary-fixed">
                                                Present
                                            </th>

                                            <th class="summary-fixed">
                                                Absent
                                            </th>

                                            <th class="summary-fixed">
                                                Late
                                            </th>

                                            <th class="total-hours-fixed">
                                                Total Hrs
                                            </th>

                                        </tr>

                                    </thead>


                                    <tbody>

                                        <?php if (!empty($reports)): ?>

                                            <?php foreach ($reports as $employee): ?>

                                                <?php
                                                $employeeName = $employee['employee_name'] ?? 'Employee';
                                                $empId = $employee['emp_id'] ?? '-';
                                                $department = $employee['department_name'] ?? '-';

                                                $initials = strtoupper(
                                                    substr($employeeName, 0, 2)
                                                );

                                                /*
                                                * Convert attendance JSON into date lookup.
                                                */
                                                $attendanceData = [];

                                                if (!empty($employee['attendance_data'])) {

                                                    $decodedAttendance =
                                                        json_decode(
                                                            $employee['attendance_data'],
                                                            true
                                                        );

                                                    if (is_array($decodedAttendance)) {

                                                        foreach ($decodedAttendance as $attendanceDay) {

                                                            if (!empty($attendanceDay['date'])) {

                                                                $attendanceData[
                                                                    $attendanceDay['date']
                                                                ] = $attendanceDay;
                                                            }
                                                        }
                                                    }
                                                }
                                                ?>

                                                <tr>

                                                    <!-- FIXED EMPLOYEE -->
                                                    <td class="text-left pl-3 employee-fixed">

                                                        <div class="d-flex align-items-center">

                                                            <div class="avatar-circle mr-2">
                                                                <?= esc($initials) ?>
                                                            </div>

                                                            <div>

                                                                <strong class="d-block text-dark">
                                                                    <?= esc($employeeName) ?>
                                                                </strong>

                                                                <small class="text-muted">
                                                                    <?= esc($empId) ?>
                                                                    <?php if ($department !== '-'): ?>
                                                                        • <?= esc($department) ?>
                                                                    <?php endif; ?>
                                                                </small>

                                                            </div>

                                                        </div>

                                                    </td>
                                <!-- DYNAMIC DATE CELLS -->
                                <?php foreach ($dates as $date): ?>

                                    <?php
                                    $dayData = $attendanceData[$date] ?? [];

                                    $status = strtoupper(trim($dayData['status'] ?? ''));

                                    $punchIn  = $dayData['punch_in'] ?? null;
                                    $punchOut = $dayData['punch_out'] ?? null;
                                    ?>

                                    <td class="date-column">

                                        <!-- PRESENT -->
                                        <?php if ($status === 'PRESENT'): ?>

                                            <span class="badge-present-cell">
                                                PRESENT
                                            </span>

                                            <?php if (!empty($punchIn)): ?>
                                                <br>

                                                <span class="time-chip">
                                                    <?= date('H:i', strtotime($punchIn)) ?>
                                                </span>
                                            <?php endif; ?>


                                            <?php if (!empty($punchOut)): ?>
                                                <br>

                                                <span class="time-chip">
                                                    <?= date('H:i', strtotime($punchOut)) ?>
                                                </span>
                                            <?php endif; ?>


                                        <!-- LATE -->
                                        <?php elseif ($status === 'LATE'): ?>

                                            <span class="badge-late-cell">
                                                LATE
                                            </span>

                                            <?php if (!empty($punchIn)): ?>
                                                <br>

                                                <span class="time-chip time-chip-late">
                                                    <?= date('H:i', strtotime($punchIn)) ?>
                                                </span>
                                            <?php endif; ?>


                                            <?php if (!empty($punchOut)): ?>
                                                <br>

                                                <span class="time-chip">
                                                    <?= date('H:i', strtotime($punchOut)) ?>
                                                </span>
                                            <?php endif; ?>


                                        <!-- ABSENT -->
                                        <?php elseif ($status === 'ABSENT'): ?>

                                            <span class="badge-absent-cell">
                                                ABSENT
                                            </span>


                                        <!-- HOLIDAY -->
                                        <?php elseif ($status === 'HOLIDAY'): ?>

                                            <span class="badge-holiday-cell">
                                                HOLIDAY
                                            </span>


                                        <!-- LEAVE -->
                                        <?php elseif ($status === 'LEAVE'): ?>

                                            <span class="badge-leave-cell">
                                                LEAVE
                                            </span>


                                        <!-- WFH -->
                                        <?php elseif ($status === 'WFH'): ?>

                                            <span class="badge-wfh-cell">
                                                WFH
                                            </span>


                                        <!-- NO DATA -->
                                        <?php else: ?>

                                            <span class="text-muted">
                                                -
                                            </span>

                                        <?php endif; ?>

                                    </td>

                                <?php endforeach; ?>


                                                    <!-- FIXED PRESENT -->
                                                    <td class="summary-fixed font-weight-bold text-primary">

                                                        <?= esc(
                                                            $employee['total_present'] ?? 0
                                                        ) ?>

                                                    </td>


                                                    <!-- FIXED ABSENT -->
                                                    <td class="summary-fixed font-weight-bold text-danger">

                                                        <?= esc(
                                                            $employee['total_absent'] ?? 0
                                                        ) ?>

                                                    </td>


                                                    <!-- FIXED LATE -->
                                                    <td class="summary-fixed font-weight-bold"
                                                        style="color:#d97706;">

                                                        <?php
                                                        /*
                                                        * Calculate late count from attendance_data
                                                        */
                                                        $lateCount = 0;

                                                        foreach ($attendanceData as $day) {

                                                            if (
                                                                strtoupper(
                                                                    $day['status'] ?? ''
                                                                ) === 'LATE'
                                                            ) {
                                                                $lateCount++;
                                                            }
                                                        }
                                                        ?>

                                                        <?= $lateCount ?>

                                                    </td>


                                                    <!-- FIXED TOTAL HOURS -->
                                                    <td class="total-hours-fixed font-weight-bold text-dark">

                                                        <?= esc(
                                                            $employee['total_hours'] ?? '00:00:00'
                                                        ) ?>

                                                    </td>

                                                </tr>

                                            <?php endforeach; ?>


                                        <?php else: ?>

                                            <tr>

                                                <td colspan="<?= count($dates) + 5 ?>"
                                                    class="text-center text-muted py-5">

                                                    <i class="fas fa-calendar-times mr-1"></i>

                                                    No attendance records found.

                                                </td>

                                            </tr>

                                        <?php endif; ?>

                                    </tbody>

                                </table>

                            </div>

                        </div>

                        <!-- Card Footer / Pagination -->
                        <!-- <div class="card-footer bg-white border-top py-2 px-3 d-flex align-items-center justify-content-between">
                            <small class="text-muted">Showing 1 to 2 of 150 entries</small>
                            <ul class="pagination pagination-sm m-0">
                                <li class="page-item disabled"><a class="page-link" href="#"><i class="fas fa-chevron-left"></i></a></li>
                                <li class="page-item active"><a class="page-link" href="#" style="background-color: var(--bloom-purple); border-color: var(--bloom-purple);">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item"><a class="page-link" href="#"><i class="fas fa-chevron-right"></i></a></li>
                            </ul>
                        </div> -->
                       
                    </div>
                       <div class="d-flex justify-content-start mb-3">
                                <button type="button"
                                    class="btn btn-bloom-back"
                                    onclick="window.history.back();">
                                    <i class="fas fa-arrow-left mr-1"></i> Back
                                </button>
                            </div>
                </div>
            </section>
        </div>

                          
    </div>

    <!-- REQUIRED SCRIPTS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
   <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>

  <script>
     $(document).ready(function () {

    $('#masterTable').DataTable({
        responsive: false,
        paging: true,
        ordering: true,
        order: [],
        searching: true,
        info: true,
        lengthChange: true,
        pageLength: 10,

        dom: "<'row'<'col-md-6'l><'col-md-6'f>>" +
             "t" +
             "<'row'<'col-md-6'i><'col-md-6'p>>"
    });

    // Make ONLY the table scroll vertically
    $('#masterTable').wrap('<div class="timesheet-scroll"></div>');
});
  </script>
</body>

</html>