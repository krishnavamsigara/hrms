<?php
$userCategory = session()->get('user_category');

/*
 * Company Attendance Month:
 * 25th of previous month -> 24th of selected month
 *
 * Example:
 * 25 Jul 2026 - 24 Aug 2026 = August 2026
 * 25 Aug 2026 - 24 Sep 2026 = September 2026
 */

// Current date
$today = new DateTime();

// Determine current company attendance month
if ((int)$today->format('d') >= 25) {
    // 25th onwards = next company month
    $companyMonthDate = clone $today;
    $companyMonthDate->modify('+1 month');
} else {
    // 1st - 24th = current calendar month
    $companyMonthDate = clone $today;
}

$defaultMonth = $companyMonthDate->format('m');
$defaultYear  = $companyMonthDate->format('Y');

// Use submitted/selected values if available
$selectedMonth = $selectedMonth ?? $defaultMonth;
$selectedYear  = $selectedYear ?? $defaultYear;


/*
 * Company attendance period
 *
 * September 2026:
 * 25 Aug 2026 -> 24 Sep 2026
 */
$periodEnd = new DateTime(
    $selectedYear . '-' . $selectedMonth . '-24'
);

$periodStart = clone $periodEnd;
$periodStart->modify('-1 month');
$periodStart->setDate(
    (int)$periodStart->format('Y'),
    (int)$periodStart->format('m'),
    25
);

$summary = $summary ?? [];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bloom Solution | My Team</title>

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap">

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css"> 


    <style>
        :root {
            --bloom-purple: #4a00e0;
            --soft-gray: #f8fafc;
            --border-color: #e2e8f0;
            --bloom-success: #10b981;
            --bloom-danger: #ef4444;
            --bloom-info: #0ea5e9;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--soft-gray);
            font-size: 13px;
            overflow-x: hidden;
        }

        /* Header */
        .main-header {
            border-bottom: 1px solid #e2e8f0 !important;
            background: rgba(255, 255, 255, 0.75) !important;
            backdrop-filter: blur(12px);
        }

        /* Sidebar */
        .main-sidebar {
            background: #111c43 !important;
        }

        .nav-pills .nav-link.active {
            background: #007bff !important;
            color: #fff !important;
        }

        /* Content */
        .content-wrapper {
            background: var(--soft-gray);
            padding: 20px;
            min-height: calc(100vh - 114px);
        }


        /* Card Bloom */
        .card-bloom {
            border: 1px solid var(--border-color) !important;
            border-radius: 20px !important;
            background: #fff;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.04);
            overflow: hidden;
        }

        /* Tabs */
        .custom-tabs {
            border: none;
            margin-bottom: 20px;
        }

        .custom-tabs .nav-link {
            border: none;
            color: #64748b;
            font-weight: 600;
            border-radius: 12px;
            padding: 12px 20px;
        }

        .custom-tabs .nav-link.active {
            background: #eef2ff;
            color: var(--bloom-purple);
        }

        /* Table */
        .table {
            margin-bottom: 0;
        }

        .table thead {
            background: #f8fafc;
        }

        .table thead th {
            border: none;
            color: #64748b;
            font-size: 12px;
            text-transform: uppercase;
            font-weight: 700;
            padding: 16px;
        }

        .table td {
            vertical-align: middle !important;
            border-top: 1px solid #f1f5f9 !important;
            padding: 16px;
        }

        /* Employee Row */
        .employee-row:hover {
            background-color: #f8fafc;
        }

        /* Avatar */
        .avatar-list {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            object-fit: cover;
        }

        /* Status */
        .status-active {
            color: #10b981;
            background: #ecfdf5;
            padding: 4px 10px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 11px;
        }

        .status-leave {
            color: #d97706;
            background: #fef3c7;
            padding: 4px 10px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 11px;
        }

        /* Buttons */
        .action-btn {
            width: 30px;
            height: 30px;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px !important;
            transition: all .2s;
            border: 1px solid var(--border-color);
            background: #fff;
        }

        .btn-view {
            color: var(--bloom-info);
        }

        .btn-edit {
            color: var(--bloom-purple);
        }

        .action-btn:hover {
            background: #f1f5f9;
            transform: translateY(-1px);
        }

        html,
        body {
            height: 100%;
        }

        .wrapper {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .content-wrapper {
            flex: 1;
        }

        /* --- STATUS BADGES --- */
        .badge-status {
            width: 90px;
            padding: 6px 0;
            text-align: center;
            border-radius: 10px;
            font-weight: 700;
            font-size: 11px;
            display: inline-block;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .bg-approved {
            background: #ecfdf5;
            color: #10b981;
        }

        .bg-pending {
            background: #fff7ed;
            color: #ea580c;
        }

        .bg-rejected {
            background: #fef2f2;
            color: #ef4444;
        }

        .bg-cancelled {
            background: #f1f5f9;
            color: #64748b;
        }

        /* Active Employee Status */
        .bg-active {
            background: #ecfdf5;
            color: #10b981;
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

        /* FORCE FOOTER FIXED */
        /* .main-footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            z-index: 9999;
        } */

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

/* Pagination */
.dataTables_paginate .paginate_button {
    margin: 0 3px !important;
}

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

.dataTables_paginate {
    padding-right: 15px;
}

.badge-pending {
    background-color: #fff3cd !important;
    color: #d97706 !important;
    border: 1px solid #fcd34d;
    font-weight: 600;
}

.badge-success {
    background-color: #d1fae5 !important;
    color: #059669 !important;
    border: 1px solid #6ee7b7;
    font-weight: 600;
}

.badge-danger {
    background-color: #fee2e2 !important;
    color: #dc2626 !important;
    border: 1px solid #fca5a5;
    font-weight: 600;
}
.badge-status{
    width:110px;
    height:34px;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    border-radius:10px;
    font-size:11px;
    font-weight:700;
    text-transform:uppercase;
    letter-spacing:.4px;
}

.bg-pending{
    background:#fff7ed;
    color:#ea580c;
    border:1px solid #fed7aa;
}

.bg-resolved{
    background:#eff6ff;
    color:#2563eb;
    border:1px solid #bfdbfe;
}

.bg-completed{
    background:#ecfdf5;
    color:#10b981;
    border:1px solid #a7f3d0;
}

.bg-cancelled{
    background:#fef2f2;
    color:#dc2626;
    border:1px solid #fecaca;
}
.leave-actions{
    display:flex;
    gap:6px;
}

.btn-update{
    background:#e8f1ff;
    color:#2563eb;
    border:1px solid #c7dbff;
    border-radius:8px;
    font-size:12px;
    font-weight:600;
    padding:6px 12px;
}

.btn-update:hover{
    background:#dbeafe;
    color:#1d4ed8;
}

.btn-resolve{
    background:#e8fbf3;
    color:#059669;
    border:1px solid #baf3d8;
    border-radius:8px;
    font-size:12px;
    font-weight:600;
    padding:6px 12px;
}

.btn-resolve:hover{
    background:#d1fae5;
    color:#047857;
}

.btn-update:disabled,
.btn-resolve:disabled{
    background:#f1f5f9;
    color:#94a3b8;
    border:1px solid #e2e8f0;
    cursor:not-allowed;
    opacity:0.8;
}

/* =========================
   TEAM ATTENDANCE
   ========================= */

.stat-card {
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    padding: 16px;
    background: #fff;
    transition: all 0.2s ease-in-out;
}

.stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 15px -3px rgba(0,0,0,0.05);
}

.stat-icon {
    width: 38px;
    height: 38px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
}

.bg-info-subtle {
    background: #e0f2fe;
    color: #0284c7;
}

.bg-warning-subtle {
    background: #fef3c7;
    color: #d97706;
}

.bg-wo {
    background: #f1f5f9;
    color: #64748b;
}

.btn-action {
    width: 34px;
    height: 34px;
    border-radius: 10px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border: 1px solid #e2e8f0;
    background: #fff;
    color: #64748b;
    transition: 0.2s;
    cursor: pointer;
}

.btn-action:hover {
    border-color: var(--bloom-purple);
    color: var(--bloom-purple);
    background: #f8faff;
    transform: translateY(-2px);
}

#attendance .table td {
    vertical-align: middle !important;
}

#attendance .table thead th {
    white-space: nowrap;
}

#attendance .style-date {
    white-space: nowrap;
}

/* Team Attendance mobile */
@media (max-width: 767.98px) {

    #attendance .card-bloom {
        border-radius: 12px !important;
    }

    #attendance .stat-card {
        padding: 10px !important;
    }

    #attendance .stat-icon {
        width: 32px !important;
        height: 32px !important;
        font-size: 13px !important;
        margin-right: 8px !important;
    }

    #attendance .stat-card h5 {
        font-size: 14px !important;
    }

    #attendance .stat-card span {
        font-size: 8px !important;
    }

    #attendance .style-date {
        font-size: 10px !important;
        padding: 8px !important;
    }

    #attendance .btn-action {
        width: 30px !important;
        height: 30px !important;
    }

    #attendance .table {
        min-width: 700px;
    }
}


.badge-status {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: auto;
    min-width: 0;
    padding: 3px 9px;
    line-height: 1;
    border-radius: 4px;
}

/* =========================
   MOBILE RESPONSIVENESS
   ========================= */

@media (max-width: 767.98px) {

    /* Page content */
    .content-wrapper {
        padding: 10px !important;
    }

    .content-wrapper .container-fluid {
        padding-left: 5px !important;
        padding-right: 5px !important;
    }

    /* Page heading */
    .content-wrapper h4 {
        font-size: 20px !important;
    }

    .content-wrapper p.small {
        font-size: 11px !important;
    }

    /* Main card */
    .card-bloom {
        border-radius: 14px !important;
    }

    .card-bloom.p-3 {
        padding: 10px !important;
    }

    /* =========================
       TABS
       ========================= */

    .custom-tabs {
        display: flex !important;
        flex-wrap: nowrap !important;
        overflow-x: auto !important;
        overflow-y: hidden !important;
        margin-bottom: 15px !important;
        padding-bottom: 3px;
        gap: 5px;
        -webkit-overflow-scrolling: touch;
    }

    .custom-tabs .nav-item {
        flex: 0 0 auto !important;
    }

    .custom-tabs .nav-link {
        white-space: nowrap !important;
        padding: 9px 12px !important;
        font-size: 11px !important;
        border-radius: 9px !important;
    }

    .custom-tabs .nav-link i {
        margin-right: 5px !important;
    }

    /* Hide scrollbar but keep horizontal scrolling */
    .custom-tabs::-webkit-scrollbar {
        display: none;
    }

    .custom-tabs {
        scrollbar-width: none;
    }

    /* =========================
       TABLE CARD
       ========================= */

    .tab-pane .card-bloom {
        border-radius: 12px !important;
    }

    .table-responsive {
        width: 100% !important;
        overflow-x: auto !important;
        -webkit-overflow-scrolling: touch;
    }

    /* Keep table readable instead of squeezing columns */
    .table {
        min-width: 700px;
        font-size: 11px !important;
    }

    .table thead th {
        padding: 10px 8px !important;
        font-size: 10px !important;
        white-space: nowrap !important;
    }

    .table td {
        padding: 10px 8px !important;
        white-space: nowrap;
    }

    /* Employee name column */
    .table td:first-child,
    .table th:first-child {
        padding-left: 10px !important;
    }

    /* Avatar */
    .avatar-list {
        width: 34px !important;
        height: 34px !important;
        min-width: 34px !important;
        margin-right: 8px !important;
        border-radius: 8px !important;
    }

    .table td strong {
        font-size: 11px !important;
    }

    .table td small {
        font-size: 9px !important;
    }

    /* Status */
    .badge-status {
        width: 90px !important;
        height: 30px !important;
        font-size: 9px !important;
    }

    .status-active,
    .status-leave {
        font-size: 9px !important;
        padding: 4px 8px !important;
    }

    /* =========================
       DATATABLE TOP SECTION
       ========================= */

    .dataTables_wrapper .row:first-child {
        display: flex !important;
        flex-direction: column !important;
        align-items: stretch !important;
        width: 100%;
        margin: 0 !important;
    }

    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter {
        float: none !important;
        width: 100% !important;
        margin: 8px 0 !important;
        padding: 0 10px !important;
        text-align: left !important;
    }

    .dataTables_wrapper .dataTables_length label,
    .dataTables_wrapper .dataTables_filter label {
        width: 100%;
        font-size: 11px !important;
    }

    .dataTables_wrapper .dataTables_filter input {
        width: calc(100% - 45px) !important;
        max-width: none !important;
        margin-left: 5px !important;
        padding: 7px 9px !important;
        font-size: 11px !important;
    }

    .dataTables_wrapper .dataTables_length select {
        font-size: 11px !important;
        padding: 4px 20px 4px 5px !important;
    }

    /* =========================
       DATATABLE BOTTOM SECTION
       ========================= */

    .dataTables_wrapper .dataTables_info {
        padding: 10px !important;
        font-size: 10px !important;
        text-align: center !important;
    }

    .dataTables_wrapper .dataTables_paginate {
        padding: 5px 10px 10px !important;
        text-align: center !important;
        white-space: nowrap;
    }

    .dataTables_paginate .paginate_button {
        margin: 0 1px !important;
    }

    .dataTables_paginate .page-link {
        padding: 5px 8px !important;
        font-size: 10px !important;
        border-radius: 7px !important;
    }

    /* =========================
       ACTION BUTTONS
       ========================= */

    .action-btn {
        width: 28px !important;
        height: 28px !important;
        font-size: 11px !important;
    }

    .leave-actions {
        display: flex !important;
        flex-direction: column !important;
        gap: 5px !important;
    }

    .btn-update,
    .btn-resolve {
        width: 100% !important;
        min-width: 110px !important;
        padding: 6px 8px !important;
        font-size: 10px !important;
        white-space: nowrap;
    }

    /* Progress input */
    .table .form-control {
        min-width: 130px;
        font-size: 10px !important;
        padding: 6px 8px !important;
    }

    /* =========================
       ATTENDANCE CARD
       ========================= */

    #attendance .card-bloom.p-5 {
        padding: 30px 15px !important;
    }

    #attendance .fa-4x {
        font-size: 35px !important;
    }

    #attendance h4 {
        font-size: 18px !important;
    }

    #attendance p {
        font-size: 11px !important;
    }

    /* =========================
       SUCCESS ALERT
       ========================= */

    .alert {
        left: 10px !important;
        right: 10px !important;
        top: 10px !important;
        min-width: auto !important;
        width: calc(100% - 20px) !important;
        font-size: 11px !important;
    }
}


.attendance-scroll {
    max-height: 220px;
    overflow-y: auto;
    overflow-x: auto;
}

.attendance-scroll thead th {
    position: sticky;
    top: 0;
    background: #fff;
    z-index: 2;
}
.live-availability-scroll {
    max-height: 220px;
    overflow-y: auto;
    overflow-x: hidden;
}
/* =========================
   FOOTER FIX
   Footer is inside content-wrapper
   ========================= */

.main-footer {
    margin-left: 0 !important;
    width: 100% !important;
    background: #fff !important;
    border-top: 1px solid #e2e8f0 !important;
    padding: 16px 25px !important;
}

/* Mobile */
@media (max-width: 767.98px) {
    .main-footer {
        margin-left: 0 !important;
        width: 100% !important;
    }
}
 .main-header {
      border-bottom: 1px solid #e2e8f0 !important;
      background: var(--glass) !important;
      backdrop-filter: blur(10px);
    }

    .main-sidebar {
      background: var(--mtn-deep) !important;
      box-shadow: 4px 0 10px rgba(0, 0, 0, 0.03) !important;
    }
    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">

    <div class="wrapper">

        <div class="content-wrapper">
            <div class="container-fluid py-3">

             <?php if(session()->getFlashdata('status') == 'Y') : ?>
            <div class="alert alert-success"
                style="
                    position:fixed;
                    top:20px;
                    right:20px;
                    z-index:9999;
                    min-width:250px;
                    border-radius:10px;
                    box-shadow:0 4px 12px rgba(0,0,0,0.15);
                ">
                <?= session()->getFlashdata('remarks') ?>
            </div>
            <?php endif; ?>
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h4 class="font-weight-bold mb-1">
                            My Team
                        </h4>

                        <p class="text-muted mb-0 small">
                            Manage your team members and requests
                        </p>
                    </div>
                </div>

                <!-- Main Card -->
                <div class="card-bloom p-3">

                    <!-- Tabs -->
                    <ul class="nav nav-tabs custom-tabs mb-4" role="tablist">

                        <li class="nav-item">
                            <a class="nav-link active"
                                data-toggle="tab"
                                href="#employees">

                                <i class="fas fa-users mr-2"></i>
                                Employees
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link"
                                data-toggle="tab"
                                href="#requests">

                                <i class="fas fa-calendar-times mr-2"></i>
                               Leave Requests
                            </a>
                        </li>

                       <?php if ($userCategory == 'ADMIN' || $userCategory == 'HR') : ?>
                            <li class="nav-item">
                                <a class="nav-link"
                                data-toggle="tab"
                                href="#emprequests">
                                    <i class="fas fa-ticket-alt mr-2"></i>
                                    Requests
                                </a>
                            </li>
                            <?php endif; ?>

                        <!-- <li class="nav-item">
                            <a class="nav-link"
                                data-toggle="tab"
                                href="#attendance">
                                <i class="fas fa-user-clock mr-2"></i>
                                Team Attendance
                            </a>
                        </li> -->

                        <!-- <li class="nav-item">
                            <a class="nav-link"
                            href="<?= base_url('aut_pages/comingsoon') ?>">
                                <i class="fas fa-user-clock mr-2"></i>
                                Team Attendance
                            </a>
                        </li> -->

                        <li class="nav-item">
                        <a class="nav-link"
                        data-toggle="tab"
                        href="#attendance">
                            <i class="fas fa-user-clock mr-2"></i>
                            Team Attendance
                        </a>
                    </li>

                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content">

                        <!-- Employees Tab -->
                        <div class="tab-pane fade show active" id="employees">

                            <div class="card-bloom">
                                <div class="table-responsive">

                                    <table id="employeesTable" class="table table-hover mb-0">

                                        <thead>
                                            <tr class="table-header">
                                                <th class="pl-4">Employee Name & ID</th>
                                                <th>Department</th>
                                                <th>Email Address</th>
                                                <th>Mobile No</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php if (!empty($employee) && $employee[0]['status'] == 'Y') : ?>
                                                <?php foreach ($employee as $row) : ?>
                                                    <tr class="employee-row">
                                                        <td class="pl-4">
                                                            <div class="d-flex align-items-center">
                                                                <img src="https://ui-avatars.com/api/?name=<?= urlencode($row['emp_name'] ?? '') ?>&background=4a00e0&color=fff"
                                                                    class="avatar-list mr-3">
                                                                <div>
                                                                    <strong><?= esc($row['emp_name'] ?? '') ?></strong><br>
                                                                    <small class="text-muted">
                                                                        <?= esc($row['emp_id'] ?? 'Employee') ?>
                                                                    </small>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <?= esc($row['department_name'] ?? '') ?>
                                                        </td>
                                                        <td>
                                                            <?= esc($row['email'] ?? '') ?>
                                                        </td>
                                                        <td>
                                                            <?= esc($row['mobile'] ?? '') ?>
                                                        </td>
                                                        <td>
                                                            <span class="status-active">
                                                                Active
                                                            </span>
                                                        </td>
                                                    </tr>

                                                <?php endforeach; ?>
                                                   <?php else : ?>
                                                        <tr>
                                                            <td></td>
                                                            <td></td>
                                                            <td class="text-center">
                                                                <?= esc($employee[0]['remarks'] ?? 'No employees found') ?>
                                                            </td>
                                                            <td></td>
                                                            <td></td>
                                                        </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Levae Requests Tab -->
                        <div class="tab-pane fade" id="requests">

                            <div class="card-bloom">
                                <div class="table-responsive">
                                   <table id="requestsTable" class="table table-hover mb-0">

                                        <thead>
                                            <tr class="table-header">
                                                <th class="pl-4">Employee Name & ID</th>
                                                <th>Applied On</th>
                                                <th>Leave Type</th>
                                                <th>Date</th>
                                                <th>No of Days</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php if (!empty($leave_requests) && $leave_requests[0]['status'] == 'Y') : ?>
                                                <?php foreach ($leave_requests as $row) : ?>
                                                    <?php if (isset($row['emp_name'])) : ?>
                                                        <tr class="employee-row">
                                                            <td class="pl-4">
                                                                <div class="d-flex align-items-center">
                                                                    <img src="https://ui-avatars.com/api/?name=<?= urlencode($row['emp_name'] ?? '') ?>&background=10b981&color=fff"
                                                                        class="avatar-list mr-3">
                                                                    <div>
                                                                        <strong><?= esc($row['emp_name'] ?? '') ?></strong><br>

                                                                        <small class="text-muted">
                                                                            <?= esc($row['emp_id'] ?? 'Employee') ?>
                                                                        </small>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td><?= date('d M Y', strtotime($row['applied_on']) ?? '') ?></td>
                                                            <td><?= esc($row['leave_name']) ?></td>
                                                           <td>
                                                                <?= date('d M', strtotime($row['from_date'])) ?>
                                                                to
                                                                <?= date('d M Y', strtotime($row['to_date'])) ?>
                                                            </td>
                                                             <td><?= esc((int)($row['applied_days'] ?? 0)) ?></td>
                                                            <td>
                                                                <?php if (strtolower($row['leave_status'] ?? '') == 'approved') { ?>
                                                                    <span class="badge-status bg-approved">Approved</span>
                                                                <?php } elseif (strtolower($row['leave_status'] ?? '') == 'pending') { ?>
                                                                    <span class="badge-status bg-pending">Pending</span>
                                                                <?php } elseif (strtolower($row['leave_status'] ?? '') == 'cancelled' || strtolower($row['leave_status']) == 'cancel') { ?>
                                                                    <span class="badge-status bg-cancelled">Cancelled</span>
                                                                <?php } else { ?>
                                                                    <span class="badge-status bg-rejected">Rejected</span>
                                                                <?php } ?>
                                                            </td>
                                                            <td>
                                                                <a href="<?= base_url('admin/leave_requ/' . $row['leave_app_id']) ?>">
                                                                    <button type="button" class="action-btn btn-view">
                                                                        <i class="fas fa-eye"></i>
                                                                    </button>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            <?php else : ?>
                                                <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                           <td style="white-space: nowrap;">
                                                <?= esc($leave_requests[0]['remarks']) ?>
                                            </td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>


            <!-- REQUESTS TAB -->
                       <?php if ($userCategory == 'ADMIN' || $userCategory == 'HR') : ?>
                        <div class="tab-pane fade" id="emprequests">

                            <div class="card-bloom">
                                <div class="table-responsive">

                                    <table id="empRequestsTable" class="table table-hover mb-0">

                                        <thead>
                                            <tr>
                                                <th>EMP ID</th>
                                                <th>Date</th>
                                                <th>REQ ID</th>
                                                <th>Subject</th>
                                                <th>Progress</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        
                                 </thead>           
                            <tbody>

                            <?php if (!empty($requests) && $requests[0]['status'] == 'Y') : ?>
                                <?php foreach($requests as $row) : ?>

                                <?php
                                    $statusClass = 'bg-pending';

                                    if ($row['status'] == 'PENDING') {
                                        $statusClass = 'bg-pending';
                                    }
                                    elseif ($row['status'] == 'RESOLVED') {
                                        $statusClass = 'bg-resolved';
                                    }
                                    elseif ($row['status'] == 'COMPLETED') {
                                        $statusClass = 'bg-completed';
                                    }
                                    elseif ($row['status'] == 'CANCELLED') {
                                        $statusClass = 'bg-cancelled';
                                    }
                                    ?>

                                <tr>
                                    <form action="<?= base_url('admin/update_progress') ?>" method="post">
                                    <td><?= $row['emp_id'] ?? '' ?></td>
                                    <td><?= date('d M Y', strtotime($row['created_at'])) ?></td>
                                    
                                    <td><?= $row['request_id'] ?? ''?></td>

                                    <td>
                                        <strong><?= esc($row['subject'] ?? '') ?></strong><br>
                                        <small class="text-muted"><?= esc($row['category']) ?></small>
                                    </td>

                                       <td>
                                            <input type="text"
                                                name="progress"
                                                class="form-control form-control-sm"
                                                value="<?= esc($row['progress'] ?? '') ?>"
                                                placeholder="Enter Progress">
                                        </td>

                                    <td>
                                        <span class="badge-status <?= $statusClass ?>">
                                            <?= esc($row['status'] ?? '') ?>
                                        </span>
                                    </td>

                                 <td>
                                    <input type="hidden"
                                        name="request_id"
                                        value="<?= $row['request_id'] ?>">

                                    <div class="leave-actions">

                                        <button type="submit"
                                                class="btn btn-update"
                                                <?= ($row['status'] == 'COMPLETED') ? 'disabled' : '' ?>>
                                            <i class="fas fa-edit mr-1"></i>
                                            Update Progress
                                        </button>

                                        <button type="submit"
                                                formaction="<?= base_url('admin/resolve_request') ?>"
                                                class="btn btn-resolve"
                                                <?= ($row['status'] == 'COMPLETED') ? 'disabled' : '' ?>>
                                            <i class="fas fa-check mr-1"></i>
                                            Resolve
                                        </button>

                                    </div>
                                </td>
                        </form>


                                </tr>

                                <?php endforeach; ?>

                            <?php else : ?>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="text-center">
                                    <?= esc($requests[0]['remarks'] ?? 'No Requests Found') ?>
                                </td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <?php endif; ?>

                            </tbody>
                                    </table>

                                </div>
                            </div>

                        </div>
                        <?php endif; ?>
                        <!-- Attendance Tab -->
                        <!-- <div class="tab-pane fade" id="attendance">

                            <div class="card-bloom">
                                <div class="table-responsive">

                                   <table id="attendanceTable" class="table table-hover mb-0">

                                        <thead>
                                            <tr class="table-header">
                                                <th class="pl-4">Employee Name</th>
                                                <th>Date</th>
                                                <th>Login Time</th>
                                                <th>Logout Time</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>

                                        <tbody>

                                            <tr class="employee-row">

                                                <td class="pl-4">
                                                    <div class="d-flex align-items-center">

                                                        <img src="https://ui-avatars.com/api/?name=Aishwarya&background=4a00e0&color=fff"
                                                            class="avatar-list mr-3">

                                                        <div>
                                                            <strong>Aishwarya</strong><br>
                                                            <small class="text-muted">
                                                                Software Developer
                                                            </small>
                                                        </div>

                                                    </div>
                                                </td>

                                                <td>21 Aug 2026</td>
                                                <td>09:05 AM</td>
                                                <td>06:15 PM</td>

                                                <td>
                                                    <span class="status-active">
                                                        Present
                                                    </span>
                                                </td>

                                            </tr>

                                        </tbody>

                                    </table>

                                </div>
                            </div>

                        </div> -->

                        <!-- Attendance Tab -->
<div class="tab-pane fade" id="attendance">

    <!-- Attendance Main Card -->
    <div class="card-bloom p-4 mb-4">

        
    <!-- Attendance Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">

       <div class="d-flex align-items-center">
        <h5 class="mb-0">
            Team Attendance
        </h5>

        <span style="
            margin-left: 8px;
            padding: 4px 9px;
            border-radius: 6px;
            background-color: #dbeafe;
            color: #2563eb;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.3px;
        ">
            TODAY
        </span>
    </div>

            <!-- Date Picker -->
           <form method="post" action="<?= base_url('employee/myteammgr') ?>#attendance" class="d-flex align-items-end">

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

</form>
            </div>



       <!-- Team Overview Metrics Cards -->
        
            <div class="row mb-4">
              <div class="col-6 col-md-4 col-lg-2 mb-3 mb-lg-0">
                <div class="stat-card d-flex align-items-center">
                  <div class="stat-icon bg-light text-secondary mr-3"><i class="fas fa-users"></i></div>
                  <div>
                    <h5 class="font-weight-bold mb-0"><?= $report[0]['total_team_members'] ?? 0 ?></h5>
                    <span class="text-muted text-xs font-weight-bold">TOTAL TEAM</span>
                  </div>
                </div>
              </div>

              <div class="col-6 col-md-4 col-lg-2 mb-3 mb-lg-0">
                <div class="stat-card d-flex align-items-center">
                  <div class="stat-icon bg-info-subtle text-info mr-3"><i class="fas fa-user-check"></i></div>
                  <div>
                    <h5 class="font-weight-bold mb-0 text-info"><?= $report[0]['today_present'] ?? 0 ?></h5>
                    <span class="text-muted text-xs font-weight-bold">PRESENT</span>
                  </div>
                </div>
              </div>

              <div class="col-6 col-md-4 col-lg-2 mb-3 mb-lg-0">
                <div class="stat-card d-flex align-items-center">
                  <div class="stat-icon bg-warning-subtle text-warning mr-3"><i class="fas fa-plane"></i></div>
                  <div>
                    <h5 class="font-weight-bold mb-0 text-warning"><?= $report[0]['today_leave'] ?? 0 ?></h5>
                    <span class="text-muted text-xs font-weight-bold">ON LEAVE</span>
                  </div>
                </div>
              </div>

              <div class="col-6 col-md-4 col-lg-2 mb-3 mb-lg-0">
                <div class="stat-card d-flex align-items-center">
                  <div class="stat-icon bg-rejected text-danger mr-3"><i class="fas fa-user-times"></i></div>
                  <div>
                    <h5 class="font-weight-bold mb-0 text-danger"><?= $report[0]['today_absent'] ?? 0 ?></h5>
                    <span class="text-muted text-xs font-weight-bold">ABSENT</span>
                  </div>
                </div>
              </div>

              <div class="col-6 col-md-4 col-lg-2 mb-3 mb-lg-0">
                <div class="stat-card d-flex align-items-center">
                  <div class="stat-icon bg-light text-dark mr-3"><i class="far fa-clock"></i></div>
                  <div>
                    <h5 class="font-weight-bold mb-0"><?= $report[0]['today_wfh'] ?? 0 ?></h5>
                    <span class="text-muted text-xs font-weight-bold">WFH</span>
                  </div>
                </div>
              </div>

              <div class="col-6 col-md-4 col-lg-2 mb-3 mb-lg-0">
                <div class="stat-card d-flex align-items-center">
                  <div class="stat-icon bg-light text-muted mr-3"><i class="fas fa-ellipsis-h"></i></div>
                  <div>
                    <h5 class="font-weight-bold mb-0 text-muted">0</h5>
                    <span class="text-muted text-xs font-weight-bold">NOT PUNCHED</span>
                  </div>
                </div>
              </div>
            </div>

            <!-- Attendance Grid & Live Availability Row -->
            <div class="row">
   <?php
$selectedMonth = (int) $selectedMonth;
$selectedYear  = (int) $selectedYear;

/*
 * ==========================================
 * COMPANY ATTENDANCE PERIOD
 * ==========================================
 *
 * August  = 25 Jul - 24 Aug
 * September = 25 Aug - 24 Sep
 * October = 25 Sep - 24 Oct
 */

$periodStart = new DateTime(
    sprintf(
        '%04d-%02d-25',
        $selectedYear,
        $selectedMonth
    )
);

$periodStart->modify('-1 month');

$periodEnd = new DateTime(
    sprintf(
        '%04d-%02d-24',
        $selectedYear,
        $selectedMonth
    )
);

/*
 * Today
 */
$today = new DateTime();

/*
 * ==========================================
 * FIND LAST AVAILABLE DATE
 * ==========================================
 *
 * It cannot be:
 * - after company period end
 * - after today
 */

if ($today < $periodEnd) {
    $lastAvailableDate = clone $today;
} else {
    $lastAvailableDate = clone $periodEnd;
}

/*
 * ==========================================
 * GENERATE LAST 6 CALENDAR DAYS
 * ==========================================
 */

$gridDates = [];

for ($i = 5; $i >= 0; $i--) {

    $date = clone $lastAvailableDate;
    $date->modify("-{$i} days");

    /*
     * Make sure we don't go before
     * company period start.
     */
    if ($date >= $periodStart) {
        $gridDates[] = $date;
    }
}
?>
              <!-- Calendar Matrix -->
              <div class="col-lg-8 mb-4 mb-lg-0">
    <div class="card-bloom h-100">

        <div class="p-3 border-bottom d-flex justify-content-between align-items-center">
            <h6 class="font-weight-bold mb-0">
                <?= date('F', mktime(0, 0, 0, $selectedMonth, 1)) ?> Attendance
            </h6>

            <div>
                <span class="badge badge-status bg-info-subtle mr-1">
                     Lea
                </span>

                <span class="badge badge-status bg-rejected mr-1">
                     Abs
                </span>

                <span class="badge badge-status bg-wo">
                     Off
                </span>

                  <!-- View All -->
       <a href="<?= base_url('employee/emp_attendance') ?>?month=<?= $selectedMonth ?>&year=<?= $selectedYear ?>"
        class="btn btn-sm"
        style="
                background: var(--bloom-purple);
                color: #fff;
                border-radius: 7px;
                font-weight: 700;
                padding: 5px 12px;
        ">
            View All
        </a>
            </div>
        </div>

        <div class="table-responsive attendance-scroll">
            <table class="table text-center mb-0">

                <thead>
                    <tr>
                        <th class="text-left">Employee</th>

                        <?php foreach ($gridDates as $date): ?>

                            <th
                                <?= $date->format('Y-m-d') == date('Y-m-d')
                                    ? 'class="text-danger"'
                                    : '' ?>
                            >
                                <?= $date->format('d') ?>
                            </th>

                        <?php endforeach; ?>

                    </tr>
                </thead>

                <?php
            $backendStatus  = '';
            $backendRemarks = '';

            if (!empty($report) && is_array($report)) {
                foreach ($report as $reportItem) {

                    if (!empty($reportItem['remarks'])) {
                        $backendRemarks = $reportItem['remarks'];
                    }

                    if (!empty($reportItem['status'])) {
                        $backendStatus = $reportItem['status'];
                    }

                    if (($reportItem['status'] ?? '') === 'N') {
                        $backendRemarks = $reportItem['remarks'] ?? '';
                        break;
                    }
                }
            }
            ?>

    <tbody>

        <?php
        $hasEmployee = false;
        ?>

        <?php if (!empty($report) && is_array($report)): ?>

            <?php foreach ($report as $employee): ?>

                <?php
                $employeeName = trim($employee['employee_name'] ?? '');

                // Skip empty/status-only records
                if ($employeeName === '') {
                    continue;
                }

                $hasEmployee = true;

                $attendanceData = json_decode(
                    $employee['attendance_data'] ?? '[]',
                    true
                );

                $attendanceByDate = [];

                foreach ($attendanceData as $attendance) {
                    if (!empty($attendance['date'])) {
                        $attendanceByDate[$attendance['date']]
                            = strtoupper($attendance['status'] ?? '');
                    }
                }
                ?>

        <tr>

            <td class="text-left font-weight-bold">

                <img
                    src="https://ui-avatars.com/api/?name=<?= urlencode($employeeName) ?>&background=4a00e0&color=fff"
                    class="rounded-circle mr-2"
                    style="width:28px; height:28px;"
                >

                <?= esc($employeeName) ?>

            </td>

            <?php foreach ($gridDates as $date): ?>

                <?php
                $dateKey = $date->format('Y-m-d');
                $status = $attendanceByDate[$dateKey] ?? '';
                ?>

                <td>

                    <?php if ($status === 'PRESENT'): ?>

                        <span class="text-success font-weight-bold">P</span>

                    <?php elseif ($status === 'ABSENT'): ?>

                        <span class="badge-status bg-rejected">A</span>

                    <?php elseif ($status === 'LEAVE'): ?>

                        <span class="badge-status bg-info-subtle">L</span>

                    <?php elseif ($status === 'HOLIDAY'): ?>

                        <span class="badge-status bg-wo">WO</span>

                    <?php elseif ($status === 'WFH'): ?>

                        <span class="badge-status bg-success">WFH</span>

                    <?php elseif ($status === 'LATE'): ?>

                        <span class="attendance-late">L</span>

                    <?php else: ?>

                        -

                    <?php endif; ?>

                </td>

            <?php endforeach; ?>

        </tr>

    <?php endforeach; ?>

<?php endif; ?>


<?php if (!$hasEmployee): ?>

    <tr>
        <td colspan="<?= count($gridDates) + 1 ?>" class="text-center py-4 text-muted">

            <i class="fas fa-users mr-2"></i>

            <?= esc(
                !empty($backendRemarks)
                    ? $backendRemarks
                    : 'No employees are there/assigned.'
            ) ?>

        </td>
    </tr>

<?php endif; ?>

</tbody>

            </table>
        </div>

    </div>
</div>
              <!-- Live Status List -->
              <div class="col-lg-4">
                <div class="card-bloom h-100 p-3">
                  <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                    <h6 class="font-weight-bold mb-0">Live Availability</h6>
                    <!-- <button class="btn-action" title="View All" onclick="viewAllStatus()"><i class="fas fa-eye"></i></button> -->
                  </div>
                  
                  <div class="live-availability-scroll"> 

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
            ?>

                <div class="d-flex align-items-center mb-3">

                    <img
                        src="https://ui-avatars.com/api/?name=<?= urlencode($employee['employee_name'] ?? 'Employee') ?>&background=4a00e0&color=fff"
                        class="rounded-circle mr-3"
                        style="width:30px; height:30px;"
                    >
                <?php
                $status = strtoupper($employee['today_attendance_status'] ?? '-');

                $statusClass = 'text-muted';
                $statusBg = '#f1f5f9';

                if ($status === 'PRESENT') {
                    $statusClass = 'text-success';
                    $statusBg = '#dcfce7';       // light green
                } elseif ($status === 'ABSENT') {
                    $statusClass = 'text-danger';
                    $statusBg = '#fee2e2';       // light red
                } elseif ($status === 'LEAVE') {
                    $statusClass = 'text-warning';
                    $statusBg = '#fef3c7';       // light yellow
                } elseif ($status === 'WFH') {
                    $statusClass = 'text-primary';
                    $statusBg = '#dbeafe';       // light blue
                }
                ?>

                <div class="flex-grow-1 position-relative">

                    <div class="font-weight-bold">
                        <?= esc($employee['employee_name'] ?? 'Employee') ?>
                    </div>

                    <span class="<?= $statusClass ?>"
                        style="
                            position: absolute;
                            top: 0;
                            right: 0;
                            padding: 4px 9px;
                            border-radius: 6px;
                            font-size: 10px;
                            font-weight: 700;
                            background-color: <?= $statusBg ?>;
                        ">
                        <?= esc($employee['today_attendance_status'] ?? '-') ?>
                    </span>

                    <small class="text-muted">
                        <?= esc($employee['emp_id'] ?? '-') ?>
                    </small>

                </div>

                </div>

         <?php endforeach; ?>

        <?php if (!$hasEmployee): ?>

            <div class="text-center text-muted py-4">
                <i class="fas fa-users mr-2"></i>
                <?= esc($backendRemarks ?: 'No employees are there/assigned.') ?>
            </div>

        <?php endif; ?>

        </div>
                 
                </div>
              </div>
            </div>

            <!-- Detailed Summary Table -->
            <div class="card-bloom mt-4">
              <div class="p-3 border-bottom d-flex justify-content-between align-items-center">
                <h6 class="font-weight-bold mb-0">Monthly Summary Details </h6>
                <!-- <button class="btn btn-outline-secondary btn-sm" style="border-radius:10px;"><i class="fas fa-download mr-1"></i> Export Report</button> -->
                 <div class="input-group input-group-sm" style="width: 250px;">
                    <div class="input-group-prepend">
                        <span class="input-group-text bg-white"
                            style="border-radius:10px 0 0 10px;">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                    </div>

                    <input type="text"
                        id="summarySearch"
                        class="form-control"
                        placeholder="Search employee..."
                        style="border-radius:0 10px 10px 0;">
                </div>
              </div>
              <div class="table-responsive attendance-scroll">
                <table class="table mb-0" id="summaryTable">
                  <thead>
                    <tr>
                      <th>Employee</th>
                      <th>ID</th>
                      <th>Present</th>
                      <th>Leave</th>
                      <th>wfh</th>
                      <th>Missed Punch</th>
                      <th>Total Hrs</th>
                      <!-- <th class="text-right">Actions</th> -->
                    </tr>
                  </thead>
         <tbody>

<?php
$hasEmployee = false;
$backendRemarks = '';

if (!empty($summary) && is_array($summary)) {
    foreach ($summary as $item) {
        if (($item['status'] ?? '') === 'N') {
            $backendRemarks = $item['remarks'] ?? '';
            break;
        }
    }
}
?>

<?php if (!empty($summary) && is_array($summary)): ?>

    <?php foreach ($summary as $employee): ?>

        <?php
        $employeeName = trim($employee['employee_name'] ?? '');

        // Skip empty/status-only records
        if ($employeeName === '') {
            continue;
        }

        $hasEmployee  = true;
        $empId        = $employee['emp_id'] ?? '-';
        $present      = $employee['total_present'] ?? 0;
        $leave        = $employee['total_leaves'] ?? 0;
        $wfh          = $employee['total_wfh'] ?? 0;
        $missedPunch  = $employee['missed_punch'] ?? 0;
        $totalHours   = $employee['total_hours'] ?? '00:00:00';
        ?>

        <tr>
            <td class="font-weight-bold">
                <img
                    src="https://ui-avatars.com/api/?name=<?= urlencode($employeeName) ?>&background=4a00e0&color=fff"
                    class="rounded-circle mr-2"
                    style="width:28px; height:28px;">
                <?= esc($employeeName) ?>
            </td>

            <td class="text-muted"><?= esc($empId) ?></td>
            <td><?= $present ?></td>
            <td>
                <span class="text-primary font-weight-bold">
                    <?= $leave ?>
                </span>
            </td>
            <td><?= $wfh ?></td>
            <td><?= $missedPunch ?></td>
            <td><?= esc($totalHours) ?></td>
        </tr>

    <?php endforeach; ?>

<?php endif; ?>


<?php if (!$hasEmployee): ?>

    <tr>
        <td colspan="7" class="text-center py-4 text-muted">
            <i class="fas fa-users mr-2"></i>
            <?= esc($backendRemarks ?: 'No employees are there/assigned.') ?>
        </td>
    </tr>

<?php endif; ?>

</tbody>
                </table>
              </div>
            </div>

          </div>
                        
                    </div>
                    <!-- End Tab Content -->

                </div>
                <!-- End Main Card -->

            </div>
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>


  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            let isManager = true;

            function toggleRoleView() {
                isManager = !isManager;
                const employeeView = document.getElementById('employeeView');
                const managerView = document.getElementById('managerView');
                const teamSubtitle = document.getElementById('teamSubtitle');

                if (isManager) {
                    employeeView.style.display = 'none';
                    managerView.style.display = 'flex';
                    teamSubtitle.textContent = 'Manage your team members and requests';
                } else {
                    managerView.style.display = 'none';
                    employeeView.style.display = 'flex';
                    teamSubtitle.textContent = 'Team Overview';
                }
            }

            // --- UPDATED: REFRESH ON TAB CHANGE SCRIPT ---
            $(document).ready(function() {
                // 1. On page load, check the URL for a hash (e.g., #attendance)
                let hash = window.location.hash;

                if (hash) {
                    // Show the tab that matches the URL hash instantly on load
                    $('.nav-tabs a[href="' + hash + '"]').tab('show');
                }

                // 2. When a user CLICKS a tab, force a page reload
               $('.nav-tabs a[data-toggle="tab"]').on('click', function(e) {

                let targetHash = $(this).attr('href');
                let currentHash = window.location.hash || '#employees';

                if (currentHash !== targetHash) {
                    e.preventDefault();
                    e.stopPropagation();

                    window.location.hash = targetHash;
                    window.location.reload();
                }
            });
            });
        </script>
        <script>
            $(document).ready(function () {

    $('#employeesTable').DataTable({
        paging: true,
        ordering: true,
        searching: true,
        info: true,
        lengthChange: true,
        pageLength: 10,
        dom: '<"top"lf>rt<"bottom"ip><"clear">'
    });

   $('#requestsTable').DataTable({
    paging: true,
    ordering: true,
    order: [], // Use backend order initially
    searching: true,
    info: true,
    lengthChange: true,
    pageLength: 10,
    dom: '<"top"lf>rt<"bottom"ip><"clear">',
    language: {
        emptyTable: "There are no leave applications."
    }
});

    $('#attendanceTable').DataTable({
        paging: true,
        ordering: true,
        searching: true,
        info: true,
        lengthChange: true,
        pageLength: 10,
        dom: '<"top"lf>rt<"bottom"ip><"clear">'
    });
   $('#empRequestsTable').DataTable({
    paging: true,
    ordering: true,
    searching: true,
    info: true,
    lengthChange: true,
    pageLength: 10,
    dom: '<"top"lf>rt<"bottom"ip><"clear">'
    });
    });
    </script>
        <script>
setTimeout(function(){
    $('.alert').fadeOut();
}, 3000);
</script>

<script>
function showEmpDetails(name, empId, hours) {

    Swal.fire({
        title: '<strong>' + name + '</strong>',
        html:
            '<div class="text-left mt-2">' +
            '<p class="mb-1"><strong>Employee ID:</strong> ' + empId + '</p>' +
            '<p class="mb-1"><strong>Total Hours Tracked:</strong> ' + hours + ' hrs</p>' +
            '<p class="mb-0 text-muted">Period: 25 Jul 2026 - 24 Aug 2026</p>' +
            '</div>',
        icon: 'info',
        confirmButtonColor: '#4a00e0',
        confirmButtonText: 'Close'
    });

}

function viewAllStatus() {

    Swal.fire({
        title: 'Live Team Availability',
        html: '<p class="text-muted">Showing status for all 12 team members.</p>',
        icon: 'info',
        confirmButtonColor: '#4a00e0'
    });

}
</script>
<script>
document.getElementById("summarySearch").addEventListener("keyup", function () {

    let searchValue = this.value.toLowerCase();
    let rows = document.querySelectorAll("#summaryTable tbody tr");

    rows.forEach(function (row) {

        let employee = row.cells[0]?.textContent.toLowerCase() || "";
        let employeeId = row.cells[1]?.textContent.toLowerCase() || "";

        row.style.display =
            employee.includes(searchValue) ||
            employeeId.includes(searchValue)
                ? ""
                : "none";
    });
});
</script>
</body>

</html>