<?php
$userCategory = session()->get('user_category');
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
                                                <th>Department</th>
                                                <th>Applied On</th>
                                                <th>Leave Type</th>
                                                <th>Date</th>
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
                                                            <td><?= esc($row['department_name'] ?? '') ?></td>
                                                            <td><?= date('d M Y', strtotime($row['applied_on']) ?? '') ?></td>
                                                            <td><?= esc($row['leave_name']) ?></td>
                                                            <td><?= date('d M', strtotime($row['from_date']) ?? '') ?>-<?= date('d M Y', strtotime($row['to_date']) ?? '') ?></td>
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

                        <div class="tab-pane fade" id="attendance">

                <div class="card-bloom p-5 text-center">

                    <i class="fas fa-user-clock fa-4x text-primary mb-3"></i>

                    <h4 class="font-weight-bold">
                        Team Attendance
                    </h4>

                    <p class="text-muted mb-0">
                        This feature is coming soon.
                    </p>

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
</body>

</html>