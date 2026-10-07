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
        min-height: calc(100vh - 57px) !important;
        padding-bottom: 20px !important;
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

/* Fix DataTables pagination visibility above footer */
.content-wrapper {
    min-height: calc(100vh - 57px) !important;
    padding-bottom: 20px !important;
}

.dataTables_wrapper {
    padding-bottom: 15px !important;
}

.dataTables_info,
.dataTables_paginate {
    padding-bottom: 10px !important;
}

.main-footer {
    margin-top: 0 !important;
    position: relative !important;
    z-index: 10;
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


    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        
        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <section class="content pt-3">
                <div class="container-fluid">
                   
    <div class="card card-bloom">
      
        <div class="card-header bg-white border-bottom d-flex align-items-center py-3 px-3">
            <div>
                <h6 class="font-weight-bold mb-1 text-dark d-flex align-items-center">
                    <i class="fas fa-users text-muted mr-2"></i>
                    Attendance Directory
                </h6>

                <small class="text-muted">
                    Attendance for <?= date('d M Y', strtotime($filterDate ?? date('Y-m-d'))) ?>
                </small>
            </div>

            
    <!-- Right side: Date Filter -->
     <div class="ml-auto">
    <form method="get" action="<?= base_url('admin/attendance_adm') ?>">
        <div class="d-flex align-items-center" style="gap: 10px;">

            <!-- Date Picker -->
            <div class="input-group input-group-sm shadow-sm" style="width: 170px;">
                
                <div class="input-group-prepend">
                    <span class="input-group-text bg-white border-right-0 text-muted"
                        style="border-top-left-radius: 8px; border-bottom-left-radius: 8px;">
                        <i class="far fa-calendar-alt"></i>
                    </span>
                </div>

                <input type="date"
                    name="filter_date"
                    class="form-control border-left-0 font-weight-bold text-secondary pl-0"
                    value="<?= esc($filterDate ?? date('Y-m-d')) ?>"
                    style="border-top-right-radius: 8px; border-bottom-right-radius: 8px;">
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
            <a href="<?= base_url('admin/attendance_dashboard?filter_date=' . ($filterDate ?? date('Y-m-d'))) ?>"
               
               >
                <!-- <i class="fas fa-arrow-left mr-1"></i> Back -->
            </a>
        </div>

        <div class="card-body p-0 table-responsive">

            <table class="table table-custom mb-0" id="attendanceTable">

                <thead>
                    <tr>
                        <th>EMPLOYEE</th>
                        <th>DEPARTMENT</th>
                        <th>STATUS</th>
                        <th>IN TIME</th>
                        <th>PUNCH OUT</th>
                        <th>TOTAL HOURS</th>
                    </tr>
                </thead>

               <tbody>

    <?php if (!empty($everyday)): ?>

        <?php foreach ($everyday as $employee): ?>

            <?php
            $status = strtoupper(
                $employee['attendance_status'] ?? ''
            );

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

            $employeeName = $employee['employee_name'] ?? 'Employee';

            $initials = strtoupper(
                substr($employeeName, 0, 2)
            );
            ?>

            <tr>

                <!-- EMPLOYEE -->
                <td>
                    <div class="d-flex align-items-center">

                        <div class="avatar-circle mr-2">
                            <?= esc($initials) ?>
                        </div>

                        <div>
                            <strong class="d-block text-dark">
                                <?= esc($employeeName) ?>
                            </strong>
                        </div>

                    </div>
                </td>

                <!-- DEPARTMENT -->
                <td>
                    <?= esc($employee['department_name'] ?? '-') ?>
                </td>

                <!-- STATUS -->
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

    <?php else: ?>

        <tr>
            <td colspan="6" class="text-center text-muted py-4">
                <i class="fas fa-users-slash mr-1"></i>
                No attendance records found for this date.
            </td>
        </tr>

    <?php endif; ?>

</tbody>

            </table>

        </div>
    </div>

</div>

                        <div class="d-flex justify-content-start mb-3" style="margin-left: 15px;">
                                <button type="button"
                                    class="btn btn-bloom-back"
                                    onclick="window.history.back();">
                                    <i class="fas fa-arrow-left mr-1"></i> Back
                                </button>
                            </div>              
        </section>
    </div>


    </div>

    <!-- Scripts -->
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
      order: [], // Use backend order initially
      searching: true,
      info: true,
      lengthChange: true,
      pageLength:10,
      dom: "<'row'<'col-md-6'l><'col-md-6'f>>" +
         "t" +
         "<'row'<'col-md-6'i><'col-md-6'p>>"

      });
      });
  </script>
</body>

</html>