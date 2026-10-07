<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title> Bloom Solutions | Leave Overview</title>

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

/* STATUS BADGES */
.badge-status{
display:inline-flex;
align-items:center;
justify-content:center;
min-width:100px;
height:34px;
font-size:12px;
font-weight:600;
border-radius:20px;
}

.badge-pending{ background:#fff7e6; color:#b7791f; border:1px solid #ffe3b3; }
.badge-approved{ background:#e8fbf3; color:#059669; border:1px solid #baf3d8; }
.badge-rejected{ background:#ffeaea; color:#dc2626; border:1px solid #ffc9c9; }

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
height: 28px;
display:flex;
align-items:center;
justify-content:center;
font-size:11px;
padding:0 10px;
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

/* Table Header */
.leave-table thead th {
    background: #f8fafc !important;
    color: #64748b !important;
    font-size: 11px !important;
    font-weight: 700 !important;
    text-transform: uppercase;
    padding: 10px 12px !important;
    height: 42px !important;
    line-height: 1.2;
    vertical-align: middle !important;
    border-bottom: 1px solid #e2e8f0 !important;
}

/* Table Body */
.leave-table tbody td {
    padding: 6px 10px !important;
    font-size: 13px !important;
    vertical-align: middle !important;
}

/* Reduce Row Height */
.leave-table tbody tr {
    height: 42px !important;
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

/* Leave Type Badge Compact */
.badge-casual,
.badge-sick,
.badge-wfh,
.badge-vacation {
    min-width: 100px;
    height: 28px;
    font-size: 11px;
}

/* Status Badge Compact */
.badge-status,
.badge-approved,
.badge-pending,
.badge-rejected {
    min-width: 90px;
    height: 28px;
    font-size: 11px;
}
/* Table Header */
.leave-table thead th {
    background: #f8fafc;
    color: #64748b;
    font-weight: 700;
    text-transform: uppercase;


    font-size: 11px;
}
/* Show entries spacing */
.dataTables_wrapper .dataTables_length {
    padding: 12px 15px !important;
    margin: 0 !important;
}

/* Top controls row */
.dataTables_wrapper .row:first-child {
    padding-top: 2px !important;
    padding-bottom: 2px !important;
}

.emp-name {
    font-size: 14px;
    font-weight: 700;   /* Bold */
}

</style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">

<div class="wrapper">

<div class="content-wrapper">
<section class="content pt-3">
<div class="container-fluid">

<div class="row">
    <div class="col-md">
        <!-- <a href="leave_pending.html" class="stat-link"> -->
        <div class="card-bloom stat-card">
        <small>Leave Requests</small>
        <strong><?= $requests[0]['total_applications'] ?? 0 ?></strong>
        <!-- <div class="leave-bar"><div style="width:70%;background:#4a00e0"></div></div> -->
        </div>
        </a>
    </div>

    <div class="col-md">
        <!-- <a href="leave_approved.html" class="stat-link"> -->
        <div class="card-bloom stat-card">
        <small>Approved</small>
        <strong><?= $requests[0]['total_approved'] ?? 0 ?></strong>
        <!-- <div class="leave-bar"><div style="width:60%;background:#10b981"></div></div> -->
        </div>
        </a>
    </div>

    <div class="col-md">
        <!-- <a href="leave_pending.html" class="stat-link"> -->
        <div class="card-bloom stat-card">
        <small>Pending</small>
        <strong><?= $requests[0]['total_pending'] ?? 0 ?></strong>
        <!-- <div class="leave-bar"><div style="width:30%;background:#facc15"></div></div> -->
        </div>
        </a>
    </div>

    <div class="col-md">
        <!-- <a href="leave_reject.html" class="stat-link"> -->
        <div class="card-bloom stat-card">
        <small>Rejected</small>
        <strong><?= $requests[0]['total_rejected'] ?? 0 ?></strong>
        <!-- <div class="leave-bar"><div style="width:15%;background:#f87171"></div></div> -->
        </div>
        </a>
    </div>
    
</div>

<div class="row">
<div class="col-12">
<div class="card card-bloom">
   <div class="card-header d-flex justify-content-between align-items-center">

    <div>
        <h3 class="card-title font-weight-bold mb-1">
            Employee Leave Requests
        </h3>
    </div>

    <!-- <div class="d-flex align-items-center" style="gap:10px;"> -->

        <!-- Leave Balance -->
        <!-- <a href="<?= base_url('admin/Leave_Balance') ?>"
           class="btn btn-sm rounded-pill px-3 text-white"
           style="background:linear-gradient(135deg,#06b6d4,#0284c7);border:none;box-shadow:0 4px 10px rgba(6,182,212,.25);">
            <i class="fas fa-wallet mr-1"></i>
            Leave Balance
        </a> -->

        <!-- Monthly Leave Details -->
        <!-- <a href="<?= base_url('admin/Month_leave_details') ?>"
           class="btn btn-sm rounded-pill px-3 text-white"
           style="background:linear-gradient(135deg,#4a00e0,#7c3aed);border:none;box-shadow:0 4px 10px rgba(74,0,224,.25);">
            <i class="fas fa-calendar-alt mr-1"></i>
            Monthly Details
        </a> -->

    <!-- </div> -->

</div>
    <div class="card-body table-responsive p-0">
    <div class="px-3 pt-3">
        <table class="table table-hover leave-table">
            <thead>
                <tr>
                    <th>Employee Name & ID</th>
                    <th>Reporting Manager</th>
                    <th>Department</th>
                    <th>Applied On</th>
                    <th>Leave Type</th>
                    <th>Dates</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                // --- BULLETPROOF DATA CHECK ---
                $isValidData = false;
                
                if (!empty($requests)) {
                    $first_item = reset($requests); // Gets the first item without assuming the key is
                    
                    // Case 1: It's a multi-dimensional array (Multiple rows returned)
                    if (is_array($first_item) && isset($first_item['status']) && $first_item['status'] == 'Y') {
                        $isValidData = true;
                    } 
                    // Case 2: It's a single flat array (Only ONE row returned)
                    elseif (isset($requests['status']) && $requests['status'] == 'Y') {
                        $isValidData = true;
                        $requests = [$requests]; // Wrap it in an array so the foreach loop doesn't break!
                    }
                }
                ?>

                <?php if ($isValidData) : ?>
                    <?php foreach ($requests as $row) : 
                        // Determine the correct color badge for this specific row
                        $status_check = strtolower(trim($row['leave_status']));
                        $badge_class = 'badge-pending';
                        if ($status_check === 'approved') {
                            $badge_class = 'badge-approved';
                        } elseif ($status_check === 'rejected' || $status_check === 'reject') {
                            $badge_class = 'badge-rejected';
                        }
                    ?>
                    <tr>
                        <?php
                    $gender = strtoupper(trim($row['gender'] ?? ''));
                    $bgColor = ($gender == 'F' || $gender == 'FEMALE') ? 'ff69b4' : '4a00e0';
                    ?>

                    <td class="pl-4">
                        <div class="d-flex align-items-center">
                            <img src="https://ui-avatars.com/api/?name=<?= urlencode($row['emp_name']) ?>&background=<?= $bgColor ?>&color=fff"
                                class="avatar-list mr-2"
                                style="width:32px; height:32px; border-radius:4px; object-fit:cover;">

                            <div>
                                <strong class="emp-name"><?= $row['emp_name'] ?: '-' ?></strong><br>
                                <small class="text-muted"><?= $row['emp_id'] ?></small>
                            </div>
                        </div>
                    </td>
                        <td><?= esc($row['reporting_to_name'] ? $row['reporting_to_name'] :'-') ?></td>
                        <td><?= esc($row['department_name'] ? $row['department_name'] :'-') ?></td>
                        <td><?= date('d M Y', strtotime($row['applied_on']) ?? '') ?></td>
                        <td><span class="badge badge-casual"><?= esc($row['leave_name']) ? $row['leave_name'] : '-'?></span></td>
                       <td>
                        <div>
                            <strong>
                                <?= date('d M', strtotime($row['from_date'])) ?>
                                -
                                <?= date('d M Y', strtotime($row['to_date'])) ?>
                            </strong>
                            <br>
                            <small class="text-muted">
                               <?= (int)$row['applied_days'] ?> Day<?= ($row['applied_days'] > 1 ? 's' : '') ?>
                            </small>
                        </div>
                    </td>
                        
                        <td><span class="badge badge-status <?= $badge_class ?>"><?= esc($row['leave_status']) ? $row['leave_status'] : '-'?></span></td>
                        
                        <td>
                            <div class="leave-actions">
                                <a href="<?= base_url('admin/leave_requ/' . $row['leave_app_id']) ?>" class="btn btn-view">
                                    <i class="fas fa-eye"></i>
                                </a>
                                
                               
                            </div>
                        </td>
                    </tr>
                   <?php endforeach; ?>
                <?php if (($requests[0]['status'] ?? '') == 'N') : ?>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>

                    <td class="text-center">
                        <?= esc($requests[0]['remarks'] ?? 'No leave requests found') ?>
                    </td>

                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <?php endif; ?>

                <?php endif; ?>      
            </tbody>
        </table>
    </div>
</div>
</div>
</div>
</div>


</div>
</section>
</div>
</div>

<div class="modal fade" id="decisionModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content" style="border-radius: 16px; border: 1px solid var(--border-color);">
      <div class="modal-header border-bottom-0">
        <h5 class="modal-title font-weight-bold" id="modalTitle">Leave Decision</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
      <div class="modal-body pt-0">
        <form id="decisionForm" action="<?= base_url('leave/leave_decision') ?>" method="POST">
          <input type="hidden" name="leave_id" id="modalLeaveId" value="">
          <input type="hidden" name="decision" id="modalDecision" value="">
          
          <label class="font-weight-bold mb-2 text-muted small text-uppercase">Admin Remarks</label>
          <textarea name="reason" id="adminRemarks" class="form-control mb-3 shadow-sm" rows="3" placeholder="Enter reason for decision..." style="background: #f1f5f9; border: 1px solid #e2e8f0;" required></textarea>
          
          <div class="d-flex justify-content-end mt-3 border-top pt-3">
            <button type="button" class="btn btn-outline-secondary px-4 rounded-pill mr-2" data-dismiss="modal">Cancel</button>
            <button type="submit" id="modalSubmitBtn" class="btn text-white px-4 rounded-pill font-weight-bold"></button>
          </div>
        </form>
      </div>
      
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>

<script>
// JavaScript to handle the Modal popup
$('#decisionModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget); 
  var leaveId = button.data('id');     // Extract info from data-id
  var action = button.data('action');  // Extract info from data-action ('approved' or 'rejected')
  
  var modal = $(this);
  
  // Set the hidden inputs for the form
  modal.find('#modalLeaveId').val(leaveId);
  modal.find('#modalDecision').val(action);
  modal.find('#adminRemarks').val(''); // Clear old remarks
  
  // Update Modal Text & Button Color based on Action
  if (action === 'approved') {
      modal.find('#modalTitle').text('Approve Leave Request');
      modal.find('#modalSubmitBtn').text('Approve Request').css('background', '#10b981').css('border', 'none');
  } else {
      modal.find('#modalTitle').text('Reject Leave Request');
      modal.find('#modalSubmitBtn').text('Reject Request').css('background', '#ef4444').css('border', 'none');
  }
});
</script>
 <script>
$(document).ready(function () {
    $('.leave-table').DataTable({
        responsive: true,
        paging: true,
        ordering: true,
        order: [], // Use backend order initially
        searching: true,
        info: true,
        lengthChange: true,
        pageLength: 10,
        dom:
            "<'row'<'col-md-6'l><'col-md-6'f>>" +
            "t" +
            "<'row'<'col-md-6'i><'col-md-6'p>>"
    });
});
</script>
</body>
</html>