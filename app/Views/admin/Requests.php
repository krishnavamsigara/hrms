<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title> Bloom Solutions | Requests</title>

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">

 <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">

<style>
:root{
--bloom-purple:#4a00e0;
--bloom-orange:#e46c44;
--soft-gray:#f8fafc;
--border-color:#e2e8f0;
}

body{
font-family:'Plus Jakarta Sans',sans-serif;
background:var(--soft-gray);
font-size:13px;
}

/* CARDS */
.card-bloom{
border:1px solid var(--border-color);
border-radius:16px;
background:#fff;
box-shadow:0 3px 6px rgba(0,0,0,0.04);
margin-bottom:15px;
}

/* STAT CARDS */
.stat-card{
padding:22px;
}

.stat-card strong{
font-size:24px;
display:block;
}

.leave-bar{
height:8px;
background:#eef2f7;
border-radius:10px;
overflow:hidden;
margin-top:8px;
}

.leave-bar div{
height:100%;
}

/* TABLE */
.leave-table td,
.leave-table th{
vertical-align:middle;
height:65px;
}

/* LEAVE TYPE BADGES */
.badge-casual,
.badge-sick,
.badge-wfh,
.badge-vacation{
display:inline-flex;
align-items:center;
justify-content:center;
min-width:130px;
height:38px;
font-size:13px;
font-weight:600;
border-radius:8px;
}

.badge-casual{ background:#e8f1ff; color:#2563eb; border:1px solid #c7dbff; }
.badge-sick{ background:#ffeaea; color:#dc2626; border:1px solid #ffc9c9; }
.badge-wfh{ background:#e8fbf3; color:#059669; border:1px solid #baf3d8; }
.badge-vacation{ background:#fff6e6; color:#d97706; border:1px solid #ffe3b3; }

.stat-link{
text-decoration:none;
color:inherit;
display:block;
}

.stat-link:hover .card-bloom{
transform:translateY(-2px);
box-shadow:0 6px 12px rgba(0,0,0,0.08);
}



/* ACTION BUTTONS */
.leave-actions{
display:flex;
gap:6px;
}

.leave-actions .btn{
height:34px;
display:flex;
align-items:center;
justify-content:center;
font-size:12px;
padding:0 12px;
border-radius:8px;
}

.btn-view{ background:#e8f1ff; color:#2563eb; border:1px solid #c7dbff; }
.btn-approve{ background:#e8fbf3; color:#059669; border:1px solid #baf3d8; }
.btn-reject{ background:#ffeaea; color:#dc2626; border:1px solid #ffc9c9; }

.btn-view:hover{background:#dbeafe;}
.btn-approve:hover{background:#d1fae5;}
.btn-reject:hover{background:#fee2e2;}
.nav-pills .nav-link.active{ background:#007bff!important; color:#fff!important; }
/* DataTables Wrapper */
.dataTables_wrapper {
    padding: 10px 0;
}
/* ===== COMPACT TABLE ===== */

.leave-table thead th {
    padding: 10px 12px !important;
    font-size: 11px !important;
    font-weight: 700;
    line-height: 1.2;
    height: 42px !important;
    vertical-align: middle !important;
}

.leave-table tbody td {
    padding: 12px !important;
    font-size: 14px;
    vertical-align: middle !important;
}

/* Reduce row height */
.leave-table tbody tr {
    height: 55px !important;
}

/* Fix sorting icon position */
table.dataTable thead .sorting:before,
table.dataTable thead .sorting:after,
table.dataTable thead .sorting_asc:before,
table.dataTable thead .sorting_desc:before {
    top: 50% !important;
    transform: translateY(-50%);
    font-size: 10px !important;
}


/* =========================
   COMPACT DATATABLE DESIGN
========================= */

/* Remove extra DataTable spacing */
.dataTables_wrapper {
    padding: 0 !important;
}

.dataTables_wrapper .row {
    margin: 0 !important;
    padding: 6px 12px !important;
    align-items: center;
}

/* Show Entries */
.dataTables_length {
    margin: 0 !important;
    font-size: 12px !important;
    font-weight: 600;
    color: #64748b;
}

.dataTables_length select {
    height: 30px !important;
    min-width: 65px;
    padding: 2px 8px !important;
    border: 1px solid #e2e8f0 !important;
    border-radius: 8px !important;
    font-size: 12px !important;
}



/* Reduce Row Height */
.leave-table tbody tr {
    height: 55px !important;
}

/* Sorting Arrows */
table.dataTable thead .sorting:before,
table.dataTable thead .sorting:after,
table.dataTable thead .sorting_asc:before,
table.dataTable thead .sorting_desc:before {
    font-size: 9px !important;
    top: 50% !important;
    transform: translateY(-50%);
    color: #4a00e0 !important;
}

/* Info Text */
.dataTables_info {
    font-size: 12px !important;
    color: #64748b !important;
    padding-top: 8px !important;
}

/* Pagination Area */
.dataTables_paginate {
    padding-top: 5px !important;
}

/* Pagination Buttons */
.dataTables_paginate .page-link {
    border-radius: 8px !important;
    border: 1px solid #e2e8f0 !important;
    background: #fff !important;
    color: #64748b !important;
    font-size: 12px !important;
    font-weight: 600 !important;
    min-width: 34px;
    height: 34px;
    line-height: 20px;
}

/* Hover */
.dataTables_paginate .page-link:hover {
    background: #f8faff !important;
    color: #4a00e0 !important;
    border-color: #4a00e0 !important;
}

/* Active Page */
.dataTables_paginate .page-item.active .page-link {
    background: linear-gradient(135deg, #4a00e0 0%, #2a0080 100%) !important;
    border-color: #4a00e0 !important;
    color: #fff !important;
}

/* Disabled */
.dataTables_paginate .page-item.disabled .page-link {
    background: #f8fafc !important;
    color: #cbd5e1 !important;
    border-color: #e2e8f0 !important;
}
/* Info text */
.dataTables_info {
    padding: 12px 15px !important;
    font-size: 12px;
    font-weight: 600;
    color: #64748b !important;
}

/* Pagination area */
.dataTables_paginate {
    padding: 10px 15px !important;
}

/* Previous / Next buttons */
.dataTables_paginate .paginate_button,
.dataTables_paginate .page-item {
    margin: 0 3px !important;
}

/* Pagination links */
.dataTables_paginate .page-link {
    padding: 8px 14px !important;
    min-height: 36px;
    border-radius: 8px !important;
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

/* Extra tight Show Entries / Search spacing */
.dataTables_wrapper .row:first-child {
    padding-top: 0 !important;
    padding-bottom: 0 !important;
    margin-top: 10px !important;
    margin-bottom: 0 !important;
}

.dataTables_wrapper .dataTables_length,
.dataTables_wrapper .dataTables_filter {
    margin-top: 0 !important;
    margin-bottom: 0 !important;
}
</style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">

<div class="wrapper">

<div class="content-wrapper">
<section class="content pt-3">
<div class="container-fluid">


<div class="row">
<div class="col-12">
<div class="card card-bloom">
    <div class="card-header d-flex align-items-center justify-content-between flex-wrap">
        <h3 class="card-title font-weight-bold mb-0">Employee Requests</h3>
        
        <!-- Filter Form for Month and Year Cycle -->
        <form method="get" action="<?= base_url('admin/Requests') ?>" class="form-inline mt-2 mt-sm-0">
            <label class="mr-2 font-weight-bold text-muted small">Cycle Filter:</label>
            <select name="month" class="form-control form-control-sm mr-2 custom-select">
                <option value="all" <?= (isset($selectedMonth) && $selectedMonth === null) ? 'selected' : '' ?>>-- All Months --</option>
                <?php
                $months = [
                    1 => 'January (Dec 25 - Jan 24)',
                    2 => 'February (Jan 25 - Feb 24)',
                    3 => 'March (Feb 25 - Mar 24)',
                    4 => 'April (Mar 25 - Apr 24)',
                    5 => 'May (Apr 25 - May 24)',
                    6 => 'June (May 25 - Jun 24)',
                    7 => 'July (Jun 25 - Jul 24)',
                    8 => 'August (Jul 25 - Aug 24)',
                    9 => 'September (Aug 25 - Sep 24)',
                    10 => 'October (Sep 25 - Oct 24)',
                    11 => 'November (Oct 25 - Nov 24)',
                    12 => 'December (Nov 25 - Dec 24)'
                ];
                foreach ($months as $num => $name) {
                    $sel = (isset($selectedMonth) && $selectedMonth === $num) ? 'selected' : '';
                    echo "<option value=\"$num\" $sel>$name</option>";
                }
                ?>
            </select>

            <select name="year" class="form-control form-control-sm mr-2 custom-select">
                <option value="all" <?= (isset($selectedYear) && $selectedYear === null) ? 'selected' : '' ?>>-- All Years --</option>
                <?php
                $curYr = date('Y');
                for ($y = $curYr - 1; $y <= $curYr + 1; $y++) {
                    $sel = (isset($selectedYear) && $selectedYear === $y) ? 'selected' : '';
                    echo "<option value=\"$y\" $sel>$y</option>";
                }
                ?>
            </select>

            <button type="submit" class="btn btn-sm btn-primary mr-1"><i class="fas fa-filter mr-1"></i>Filter</button>
            <a href="<?= base_url('admin/Requests') ?>" class="btn btn-sm btn-secondary"><i class="fas fa-undo mr-1"></i>Reset</a>
        </form>
    </div>
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

                              <div class="table-responsive">

                                    <table id="empRequestsTable" class="table table-hover mb-0">

                                        <thead>
                                            <tr>
                                                <th>Emp Id</th>
                                                <th>Date</th>
                                                <th>Request ID</th>
                                                <th>Subject</th>
                                                <th>Progress</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        
                                 </thead>           
                            <tbody>

                            <?php if(!empty($requests)) : ?>
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

                                    $cat = trim($row['category'] ?? '');
                                    $isMissingPunch = in_array($cat, ['Missing Punchout', 'Missing Punch']);
                                    $isAttendance = in_array($cat, ['Attendance', 'Attendance Regularization', 'Attendance Request']);
                                    
                                    preg_match('/\d{4}-\d{2}-\d{2}/', $row['subject'], $matches);
                                    $attDate = !empty($matches[0]) ? $matches[0] : date('Y-m-d', strtotime($row['created_at']));
                                    ?>

                                <tr>
                                    <td><?= esc($row['emp_id'] ?? '-') ?></td>
                                    <td><?= date('d M Y', strtotime($row['created_at'])) ?? '-' ?></td>
                                    <td><?= esc($row['request_id'] ?? '-') ?></td>
                                    
                                    <td>
                                        <strong><?= esc($row['subject']) ?></strong><br>
                                        <small class="text-muted"><?= esc($row['category']) ?? '-' ?></small>
                                    </td>

                                    <?php if ($isMissingPunch) : ?>
                                        <td>
                                            <span class="text-muted small"><?= esc($row['progress'] ?? 'Punch Timing Pending') ?></span>
                                        </td>
                                        <td>
                                            <span class="badge-status <?= $statusClass ?>">
                                                <?= esc($row['status']) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <a href="<?= base_url('admin/missing_punchout?emp_id=' . urlencode($row['emp_id']) . '&month=' . ($selectedMonth ?? date('n')) . '&year=' . ($selectedYear ?? date('Y'))) ?>" 
                                               class="btn btn-sm btn-info font-weight-bold px-3" 
                                               title="View & Edit Missing Punchout">
                                                <i class="fas fa-eye mr-1"></i> View
                                            </a>
                                        </td>
                                    <?php elseif ($isAttendance) : ?>
                                        <td>
                                            <span class="text-muted small"><?= esc($row['progress'] ?? 'Attendance Review Pending') ?></span>
                                        </td>
                                        <td>
                                            <span class="badge-status <?= $statusClass ?>">
                                                <?= esc($row['status']) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <a href="<?= base_url('admin/attendance_details?emp_id=' . urlencode($row['emp_id']) . '&month=' . ($selectedMonth ?? date('n')) . '&year=' . ($selectedYear ?? date('Y'))) ?>" 
                                               class="btn btn-sm btn-primary font-weight-bold px-3" 
                                               title="View Employee Attendance Timesheet">
                                                <i class="fas fa-eye mr-1"></i> View
                                            </a>
                                        </td>
                                    <?php else : ?>
                                        <form action="<?= base_url('admin/update_progress') ?>" method="post">
                                            <td>
                                                <input type="text"
                                                    name="progress"
                                                    class="form-control form-control-sm"
                                                    value="<?= esc($row['progress'] ?? '-') ?>"
                                                    placeholder="Enter Progress">
                                            </td>

                                            <td>
                                                <span class="badge-status <?= $statusClass ?>">
                                                    <?= esc($row['status']) ?>
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
                                    <?php endif; ?>
                                </tr>
                                <?php endforeach; ?>

                            <?php elseif (($requests[0]['status'] ?? '') == 'N') : ?>

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

                </div>
                </div>
                </div>
</div>
</section>
</div>
</div>



<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>

  <script>
    $('#empRequestsTable').DataTable({
    paging: true,
    ordering: true,
    searching: true,
    info: true,
    lengthChange: true,
    pageLength: 10,
    dom: '<"row"<"col-md-6"l><"col-md-6"f>>rt<"row"<"col-md-6"i><"col-md-6"p>>'
});
  </script>
  <script>
setTimeout(function(){
    $('.alert').fadeOut();
}, 3000);
</script>
</body>
</html>