<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BloomHR | Enterprise Attendance</title>

    <!-- Google Font: Plus Jakarta Sans -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- AdminLTE 3 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">

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
            padding-bottom: 5px !important;
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

        .card-bloom:hover {
            transform: translateY(-2px);
        }

        /* --- DASHBOARD ACTION CARDS --- */
        .action-card {
            position: relative;
            padding: 1.25rem;
            border-radius: 16px;
            background: #fff;
            border: 1px solid #e2e8f0;
        }

        .action-card .badge-status {
            position: absolute;
            top: 16px;
            right: 16px;
            font-size: 10px;
            font-weight: 700;
            padding: 4px 8px;
            border-radius: 6px;
            text-transform: uppercase;
        }

        .icon-square {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            margin-bottom: 12px;
        }

        /* --- QUICK LINK BUTTON CARDS --- */
        .quick-link-card {
            display: flex;
            align-items: center;
            padding: 1rem;
            border-radius: 12px;
            background: #fff;
            border: 1px solid #e2e8f0;
            text-decoration: none !important;
            color: #334155;
            transition: all 0.2s ease;
            font-weight: 600;
        }

        .quick-link-card:hover {
            background: #f8fafc;
            border-color: #cbd5e1;
            color: var(--bloom-purple);
        }

        /* --- TABLES & BADGES --- */
        .table-custom th {
            border-top: none;
            border-bottom: 1px solid #f1f5f9;
            color: #64748b;
            font-weight: 600;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .table-custom td {
            vertical-align: middle;
            border-top: 1px solid #f1f5f9;
            font-size: 12.5px;
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

        .badge-soft-success {
            background: #dcfce7;
            color: #15803d;
        }

        .badge-soft-warning {
            background: #fef3c7;
            color: #b45309;
        }

        .badge-soft-danger {
            background: #fee2e2;
            color: #b91c1c;
        }

        .badge-soft-secondary {
            background: #f1f5f9;
            color: #475569;
        }

        .footer-link {
            color: var(--bloom-purple);
            font-weight: 600;
            text-decoration: none;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        
        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <section class="content pt-3">
                <div class="container-fluid">
                    <!-- Dashboard Top Header Row -->
                    <form action="" method="GET" class="mb-4">
                        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between">

                            <!-- Title & Subtitle -->
                            <div class="mb-3 mb-md-0">
                                <h4 class="font-weight-bold mb-0" style="color: var(--mtn-deep, #1e293b);">Attendance Dashboard
                                </h4>
                                <small class="text-muted">Overview of today's attendance and pending actions.</small>
                            </div>

                            <!-- Interactive Controls Group -->
                            <div class="d-flex align-items-center flex-wrap" style="gap: 10px;">


                                <form method="get" action="<?= base_url('admin/adm_attendence') ?>">
                                <!-- Functional Date Picker -->
                                <div class="input-group input-group-sm shadow-sm" style="width: 170px;">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-white border-right-0 text-muted"
                                            style="border-top-left-radius: 8px; border-bottom-left-radius: 8px;">
                                            <i class="far fa-calendar-alt"></i>
                                        </span>
                                    </div>
                                    <input type="date" name="filter_date"
                                        class="form-control border-left-0 font-weight-bold text-secondary pl-0"
                                         value="<?= $filterDate ?? date('Y-m-d') ?>"
                                        style="border-top-right-radius: 8px; border-bottom-right-radius: 8px;">
                                </div>

                                <!-- Submit Button -->
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
                        </div>
                    </form>

                </div>

                <!-- Top 3 Action Cards -->
                <div class="row">
                    <div class="col-lg-4 col-md-6 mb-3">
                        <div class="action-card shadow-sm">
                            <span class="badge-status bg-danger text-white">High Priority</span>
                            <div class="icon-square bg-light-danger text-danger" style="background: #fee2e2;">
                                <i class="fas fa-user-slash"></i>
                            </div>
                            <small class="text-muted font-weight-bold d-block mb-1">Missing Out-Punches</small>
                            <div class="d-flex align-items-baseline">
                                <h2 class="font-weight-bold mb-0 mr-2" style="color: var(--bloom-danger);">12</h2>
                                <small class="text-muted">requires review</small>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 mb-3">
                        <div class="action-card shadow-sm">
                            <span class="badge-status text-white" style="background: #d97706;">Pending</span>
                            <div class="icon-square text-warning" style="background: #fef3c7;">
                                <i class="fas fa-user-clock"></i>
                            </div>
                            <small class="text-muted font-weight-bold d-block mb-1">Unapproved Absences</small>
                            <div class="d-flex align-items-baseline">
                                <h2 class="font-weight-bold mb-0 mr-2" style="color: #d97706;">8</h2>
                                <small class="text-muted">from yesterday</small>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-12 mb-3">
                        <div class="action-card shadow-sm">
                            <div class="icon-square text-primary" style="background: #e0e7ff;">
                                <i class="fas fa-calendar-plus"></i>
                            </div>
                            <small class="text-muted font-weight-bold d-block mb-1">Leave Requests</small>
                            <div class="d-flex align-items-baseline">
                                <h2 class="font-weight-bold mb-0 mr-2" style="color: var(--bloom-purple);">5</h2>
                                <small class="text-muted">awaiting approval</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Organization Summary Card -->

                <div class="row mb-3">
                    <div class="col-12">
                        <div class="card card-bloom mb-0">
                            <div class="card-body py-3">

                            <h6 class="font-weight-bold mb-3 text-dark">
                                Organization Summary
                            </h6>

                            <div class="row text-center">

                                <!-- Total Employees -->
                                <div class="col-6 col-md border-right">
                                    <small class="text-muted d-block font-weight-bold">
                                        Total Employees
                                    </small>
                                    <h3 class="font-weight-bold my-1">
                                        <?= $attendance[0]['total_employees_count'] ?? 0 ?>
                                    </h3>
                                </div>

                                <!-- Present -->
                                <div class="col-6 col-md border-right">
                                    <small class="text-muted d-block font-weight-bold">
                                        Present
                                    </small>
                                    <h3 class="font-weight-bold text-primary my-1">
                                        <?= $attendance[0]['today_present_count'] ?? 0 ?>
                                    </h3>
                                </div>

                                <!-- On Leave -->
                                <div class="col-6 col-md border-right">
                                    <small class="text-muted d-block font-weight-bold">
                                        On Leave
                                    </small>
                                    <h3 class="font-weight-bold text-info my-1">
                                        <?= $attendance[0]['today_leave_count'] ?? 0 ?>
                                    </h3>
                                </div>

                                <!-- Absent -->
                                <div class="col-6 col-md border-right">
                                    <small class="text-muted d-block font-weight-bold">
                                        Absent
                                    </small>
                                    <h3 class="font-weight-bold text-danger my-1">
                                        <?= $attendance[0]['today_absent_count'] ?? 0 ?>
                                    </h3>
                                </div>

                                <!-- WFH -->
                                <div class="col-6 col-md">
                                    <small class="text-muted d-block font-weight-bold">
                                        WFH
                                    </small>
                                    <h3 class="font-weight-bold text-dark my-1">
                                        <?= $attendance[0]['today_wfh_count'] ?? 0 ?>
                                    </h3>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                

                </div>


                <!-- Quick Links Section -->

                    <div class="row mb-3">
                        <div class="col-12">
                        <div class="card card-bloom mb-0">

                            <!-- Quick Links Header -->
                            <div class="card-header border-bottom d-flex align-items-center justify-content-between py-2 px-3">

                                <h6 class="font-weight-bold text-dark mb-0">
                                    <i class="fas fa-bolt text-warning mr-2"></i>
                                    Quick Links
                                </h6>

                            </div>

                            <!-- Quick Links Body -->
                            <div class="card-body p-3">

                                <div class="row">

                                    <!-- Timesheet Lookup -->
                                   <div class="col-lg-3 col-md-6 mb-2 mb-lg-0">
                                    <a href="<?= base_url('admin/master_time_sheet?filter_date=' . ($filterDate ?? date('Y-m-d'))) ?>"
                                    class="quick-link-card shadow-sm">

                                        <div class="icon-square mb-0 mr-3 text-primary"
                                            style="background: #e0e7ff;">
                                            <i class="fas fa-search"></i>
                                        </div>

                                        <span>Timesheet Lookup</span>
                                    </a>
                                </div>

                                    <!-- Exceptions -->
                                    <div class="col-lg-3 col-md-6 mb-2 mb-lg-0">
                                        <a href="#" class="quick-link-card shadow-sm">
                                            <div class="icon-square mb-0 mr-3 text-danger"
                                                style="background: #fee2e2;">
                                                <i class="fas fa-exclamation-triangle"></i>
                                            </div>

                                            <span>Exceptions</span>
                                        </a>
                                    </div>

                                    <!-- Bulk Regularize -->
                                    <div class="col-lg-3 col-md-6 mb-2 mb-lg-0">
                                        <a href="#" class="quick-link-card shadow-sm">
                                            <div class="icon-square mb-0 mr-3 text-info"
                                                style="background: #e0f2fe;">
                                                <i class="fas fa-sliders-h"></i>
                                            </div>

                                            <span>Bulk Regularize</span>
                                        </a>
                                    </div>

                                    <!-- Download Reports -->
                                    <div class="col-lg-3 col-md-6 mb-2 mb-lg-0">
                                        <a href="#" class="quick-link-card shadow-sm">
                                            <div class="icon-square mb-0 mr-3 text-secondary"
                                                style="background: #f1f5f9;">
                                                <i class="fas fa-download"></i>
                                            </div>

                                            <span>Download Reports</span>
                                        </a>
                                    </div>

                                </div>

                            </div>
                        </div>

                    </div>


                    </div>


                <!-- Bottom Tables Split Row -->
                <div class="row">
                    <!-- Directory Today -->
                    <div class="col-lg-12 mb-3">
                        <div class="card-header bg-white border-bottom d-flex align-items-center py-3 px-3">

                                <!-- Title stays on left -->
                                <h6 class="font-weight-bold mb-0 text-dark d-flex align-items-center">
                                    <i class="fas fa-users text-muted mr-2"></i>
                                    Today Attendance
                                </h6>

                                <!-- Buttons stay together at right corner -->
                                <div class="ml-auto d-flex align-items-center">

                                <!-- Attendance - Bloom Purple -->
                                <a href="<?= base_url('admin/attendance_adm?filter_date=' . ($filterDate ?? date('Y-m-d'))) ?>"
                                class="btn btn-sm font-weight-bold px-3 py-1 shadow-sm mr-2"
                                style="border-radius: 8px; font-size: 12px; background-color: #4a00e0; color: #fff; border-color: #4a00e0;">
                                    View All <i class="fas fa-arrow-right ml-1"></i>
                                </a>

                                <!-- Time Sheet - Green -->
                                <!-- <a href="<?= base_url('admin/master_time_sheet?filter_date=' . ($filterDate ?? date('Y-m-d'))) ?>"
                                class="btn btn-sm font-weight-bold px-3 py-1 shadow-sm"
                                style="border-radius: 8px; font-size: 12px; background-color: #10b981; color: #fff; border-color: #10b981;">
                                    Time Sheet <i class="fas fa-arrow-right ml-1"></i>
                                </a> -->

                            </div>

                            </div>
                            <div class="card-body p-0 table-responsive">
                                <table class="table table-custom mb-0">
                                    <thead>
                                        <tr>
                                            <th>Employee</th>
                                            <th>Department</th>
                                            <th>Status</th>
                                            <th>IN TIME</th>
                                            <th>PUNCH OUT</th>
                                            <th>TOTAL HOURS</th>
                                        </tr>
                                    </thead>
                                   <tbody>
                            <?php
                            $employees = $everyday ?? [];

                            // Get random 5 employees
                            if (count($employees) > 5) {
                                $randomKeys = array_rand($employees, 5);
                                $randomEmployees = array_map(fn($key) => $employees[$key], $randomKeys);
                            } else {
                                $randomEmployees = $employees;
                            }
                            ?>

                            <?php foreach ($randomEmployees as $employee): ?>

                                <?php
                                $status = strtoupper($employee['attendance_status'] ?? '');

                                $statusClass = 'badge-soft-secondary';

                                if ($status === 'PRESENT') {
                                    $statusClass = 'badge-soft-success';
                                } elseif ($status === 'LATE') {
                                    $statusClass = 'badge-soft-warning';
                                } elseif ($status === 'ABSENT') {
                                    $statusClass = 'badge-soft-danger';
                                } elseif ($status === 'LEAVE') {
                                    $statusClass = 'badge-soft-secondary';
                                } elseif ($status === 'WFH') {
                                    $statusClass = 'badge-soft-info';
                                }
                                ?>

                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-circle mr-2">
                                                <?= strtoupper(substr($employee['employee_name'] ?? 'E', 0, 2)) ?>
                                            </div>

                                            <div>
                                                <strong class="d-block text-dark">
                                                    <?= esc($employee['employee_name'] ?? 'Employee') ?>
                                                </strong>
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        <?= esc($employee['department_name'] ?? '-') ?>
                                    </td>

                                    <td>
                                        <span class="badge <?= $statusClass ?> px-2 py-1">
                                            <?= esc($status ?: '-') ?>
                                        </span>
                                    </td>
                                    <!-- IN TIME -->
                                    <td>
                                        <?= !empty($employee['punch_in'])
                                            ? date('H:i:s', strtotime($employee['punch_in']))
                                            : '-' ?>
                                    </td>

                                    <!-- PUNCH OUT -->
                                    <td>
                                        <?= !empty($employee['punch_out'])
                                            ? date('H:i:s', strtotime($employee['punch_out']))
                                            : '-' ?>
                                    </td>

                                    <!-- TOTAL HOURS -->
                                    <td>
                                        <?= esc($employee['total_hours'] ?? '-') ?>
                                    </td>
                                </tr>

                            <?php endforeach; ?>
                        </tbody>
                     </table>
                            </div>
                        </div>
                    </div>
                    

                    <!-- Master Timesheet -->
                    
                </div>

        </div>
        </section>
    </div>


    </div>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
</body>

</html>