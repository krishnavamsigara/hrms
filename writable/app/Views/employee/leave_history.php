<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bloom Solution | Leave History</title>

  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

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

    /* --- GLOBAL --- */
    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      background-color: #f8fafc;
      font-size: 13px;
      color: #334155;
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

    /* --- CARDS & TABLES --- */
    .card-bloom {
      border: 1px solid #e2e8f0 !important;
      border-radius: 20px !important;
      background: #fff;
      box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05) !important;
      overflow: hidden;
    }

    .table thead th {
      background: #f8fafc;
      border-top: none;
      border-bottom: 1px solid #e2e8f0;
      text-transform: uppercase;
      font-size: 11px;
      letter-spacing: 0.5px;
      color: #64748b;
      padding: 15px;
    }

    .table td {
      vertical-align: middle !important;
      border-top: 1px solid #f1f5f9;
      padding: 15px;
    }

    /* --- STATUS BADGES --- */
    .badge-status {
      width: 90px;          /* Forces all badges to be exactly the same size */
      padding: 6px 0;       /* Removes left/right padding so text centers inside the fixed width */
      text-align: center;   /* Centers the text */
      border-radius: 10px;
      font-weight: 700;
      font-size: 11px;
      display: inline-block;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    .bg-approved {
      background: #ecfdf5;
      color: #10b981; /* Emerald Green */
    }

    .bg-pending {
      background: #fff7ed;
      color: #ea580c; /* Orange */
    }

    .bg-rejected {
      background: #fef2f2;
      color: #ef4444; /* Red */
    }

    .bg-cancelled {
      background: #f1f5f9;
      color: #64748b; /* Slate Gray - distinct from Rejected */
    }

    /* --- CUSTOM CANCEL BUTTON --- */
    .btn-bloom-cancel {
      background: #fff;
      color: #dc2626;
      border: 1px solid #fecaca;
      border-radius: 8px;
      font-weight: 700;
      font-size: 10px;
      padding: 5px 0;
      width: 90px; /* Matches the width of the badges exactly */
      transition: all 0.3s ease;
      margin-top: 5px;
      text-transform: uppercase;
      cursor: pointer;
      display: block; /* Ensures it drops to the next line cleanly */
    }

    .btn-bloom-cancel:hover {
      background: #fef2f2;
      color: #b91c1c;
      border-color: #f87171;
    }

    /* --- BUTTONS --- */
    .btn-bloom-grad {
      background: linear-gradient(135deg, var(--bloom-purple) 0%, var(--bloom-dark) 100%);
      color: #fff !important;
      border: none;
      border-radius: 12px;
      font-weight: 700;
      padding: 10px 20px;
      font-size: 12px;
      transition: 0.3s;
    }

    .btn-bloom-grad:hover {
      transform: translateY(-1px);
      opacity: 0.9;
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
      margin-left: 4px;
    }

    .btn-action:hover {
      border-color: var(--bloom-purple);
      color: var(--bloom-purple);
      background: #f8faff;
      transform: translateY(-2px);
    }

    .btn-action.delete:hover {
      border-color: var(--bloom-danger);
      color: var(--bloom-danger);
      background: #fff1f2;
    }

    .form-control-bloom {
      border-radius: 12px;
      border: 1px solid #e2e8f0;
      font-size: 12px;
      height: auto;
      padding: 10px 15px;
    }

    /* --- FOOTER --- */
    .main-footer {
      background: #fff !important;
      border-top: 1px solid #e2e8f0 !important;
      color: #64748b;
      font-size: 12px;
      padding: 1rem 1.5rem !important;
    }

    .footer-dot {
      display: inline-block;
      width: 4px;
      height: 4px;
      background: #cbd5e1;
      border-radius: 50%;
      margin: 0 8px;
      vertical-align: middle;
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

body {
    height: 100%;
}

.wrapper {
    min-height: 100vh;
}

.content-wrapper {
    min-height: calc(100vh - 114px) !important;
    display: flex;
    flex-direction: column;
}

.content {
    flex: 1;
}

.main-footer {
    margin-top: auto;
}
  </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

   
    <div class="content-wrapper">
      <section class="content pt-4">
        <div class="container-fluid">

          <!-- <div class="row mb-4">
            <div class="col-12">
              <div class="card-bloom p-4">
                <div class="row align-items-end">
                  <div class="col-md-3">
                    <label class="small font-weight-bold text-muted">Type</label>
                      <select name="leave_type" class="form-control form-control-bloom">
                        <option value="">All Leaves</option>
                        <option value="Maternity Leave">Maternity Leave</option>
                        <option value="Personal Leave">Personal Leave</option>
                        <option value="Sick Leave">Sick Leave</option>
                        <option value="Work From Home">Work From Home</option>
                      </select>
                  </div>

                  <div class="col-md-3">
                      <label class="small font-weight-bold text-muted">Status</label>
                      <select name="leave_status" class="form-control form-control-bloom">
                          <option value="">All Status</option>
                          <option value="APPROVED">Approved</option>
                          <option value="PENDING">Pending</option>
                          <option value="REJECTED">REJECTED</option>
                          <option value="CANCELLED">Cancelled</option>
                      </select>
                  </div>

                  <div class="col-md-4">
                      <label class="small font-weight-bold text-muted">Search</label>
                      <input type="text"
                            name="keyword"
                            class="form-control form-control-bloom"
                            placeholder="Search by reason...">
                  </div>

                  <div class="col-md-2">
                      <button type="submit" class="btn btn-bloom-grad btn-block mt-2">
                          SEARCH
                      </button>
                  </div>
                </div>
              </div>
            </div>
          </div> -->

          <div class="row">
            <div class="col-12">
              <div class="card card-bloom">
                <div class="card-body p-0">
                  <div class="table-responsive">
                    <table id="leaveHistoryTable" class="table mb-0">
                      <thead>
                        <tr>
                          <th>Applied On</th>
                          <th>Leave Dates</th>
                          <th>Type</th>
                          <th>Reason</th>
                          <th>Status</th>
                          <th>Remarks</th>
                        </tr>
                      </thead>
                        <tbody>
                          <?php if (!empty($history) && ($history[0]['status'] ?? '') == 'Y') { ?>
                            <?php foreach ($history as $row) { ?>
                            
                              <tr>
                                <td class="font-weight-bold text-muted">
                                  <?= !empty($row['applied_on']) ? date('d M Y', strtotime($row['applied_on'])) : '' ?>
                                </td>
                                <td>
                                  <div class="font-weight-bold">
                                    <?= !empty($row['from_date']) ? date('d M', strtotime($row['from_date'])) : '' ?>
                                      -
                                      <?= !empty($row['to_date']) ? date('d M Y', strtotime($row['to_date'])) : '' ?>
                                  </div>
                                 <small class="text-muted">
                                    <?= !empty($row['total_days']) ?(int) $row['total_days'] . ' Day(s)' : '-' ?>
                                </small>
                                </td>
                                <td>
                                  <span class="font-weight-bold text-primary">
                                   <?= esc($row['leave_name'] ?? '-') ?>
                                  </span>
                                </td>
                                <td class="text-muted">
                                  <?= esc($row['reason'] ?? '-') ?>
                                </td>
                                <td>
                                  <?php if (strtolower($row['leave_status'] ?? '') == 'approved') { ?>
                                    <span class="badge-status bg-approved">Approved</span>
                                    
                                  <?php } elseif (strtolower($row['leave_status'] ?? '') == 'pending') { ?>
                                    <div class="text-right">
                                        <span class="badge-status bg-pending d-block">Pending</span>
                                        
                                        <form id="cancelForm_<?= $row['leave_app_id'] ?>" action="<?= base_url('leave/leave_decision') ?>" method="POST" class="m-0">
                                            <input type="hidden" name="leave_id" value="<?= $row['leave_app_id'] ?>">
                                            <input type="hidden" name="decision" value="CANCEL">
                                            <input type="hidden" name="reason" value="Cancelled by user.">
                                            
                                            <button type="button" class="btn-bloom-cancel" onclick="confirmCancel(<?= $row['leave_app_id'] ?>)">
                                                <i class="fas fa-times mr-1"></i> Cancel
                                            </button>
                                        </form>
                                    </div>
                                    
                                  <?php } elseif (strtolower($row['leave_status']?? '') == 'cancelled' || strtolower($row['leave_status'] ?? '-') == 'cancel') { ?>
                                    <span class="badge-status bg-cancelled">Cancelled</span>
                                    
                                 <?php } elseif (!empty($row['leave_status'])) { ?>
                                      <span class="badge-status bg-rejected">Rejected</span>
                                  <?php } else { ?>
                                      <span class="text-muted">-</span>
                                  <?php } ?>
                                </td>
                               <td>
                                    <?php if (
                                        ($row['leave_status'] ?? '') == 'APPROVED' &&
                                        empty($row['rejection_reason']) &&
                                        empty($row['cancel_reason'])
                                    ): ?>
                                        <span class="text-success small">Approved by Manager</span>

                                    <?php elseif (!empty($row['rejection_reason'])): ?>
                                        <span class="text-danger small"><?= esc($row['rejection_reason']) ?></span>

                                    <?php elseif (!empty($row['cancel_reason'])): ?>
                                        <span class="text-warning small"><?= esc($row['cancel_reason']) ?></span>

                                    <?php else: ?>
                                        <span class="text-muted small">-</span>
                                    <?php endif; ?>
                                </td>
                              </tr>
                            <?php } ?>
                          <?php } else { ?>
                          <tr>
                              <td></td> <!-- Applied On -->
                              <td></td> <!-- Leave Dates -->
                              <td></td> <!-- Type -->

                              <td class="text-center">
                                  <?=ucfirst(esc($history[0]['remarks'] ?? 'No leave records found')) ?>
                              </td>

                              <td></td> <!-- Status -->
                              <td></td> <!-- Remarks -->
                          </tr>
                          <?php } ?>
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

  <div class="modal fade" id="viewModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content card-bloom p-3">
        <div class="modal-header border-0">
          <h5 class="font-weight-bold">Leave Summary</h5><button type="button" class="close"
            data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <div class="p-3 rounded bg-light">
            <p class="mb-1 small text-muted">Dates</p>
            <h6 id="v-period" class="font-weight-bold"></h6>
            <hr>
            <p class="mb-1 small text-muted">Category</p>
            <h6 id="v-type" class="font-weight-bold text-primary"></h6>
            <hr>
            <p class="mb-1 small text-muted">Status</p><span id="v-status" class="badge-status bg-approved"></span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content card-bloom p-3">
        <div class="modal-header border-0">
          <h5 class="font-weight-bold">Update Request</h5><button type="button" class="close"
            data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body"><label class="small font-weight-bold">Modify Reason</label><textarea id="editReason"
            class="form-control form-control-bloom" rows="3"></textarea><button
            class="btn btn-bloom-grad btn-block mt-3" onclick="saveEdit()">UPDATE</button></div>
      </div>
    </div>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>

  <script>
    function viewLeave(period, type, status) {
      $('#v-period').text(period); $('#v-type').text(type); $('#v-status').text(status);
      $('#viewModal').modal('show');
    }
    function downloadLeave(id) {
      Swal.fire({ title: 'Processing...', text: 'Downloading ' + id, icon: 'info', timer: 1500, showConfirmButton: false, didOpen: () => Swal.showLoading() }).then(() => Swal.fire('Success', 'PDF Downloaded', 'success'));
    }
    function editLeave(reason) {
      $('#editReason').val(reason); $('#editModal').modal('show');
    }
    function saveEdit() {
      $('#editModal').modal('hide'); Swal.fire('Saved', 'Request updated', 'success');
    }
    function deleteLeave(btn) {
      Swal.fire({ title: 'Cancel Leave?', text: "You can't undo this!", icon: 'warning', showCancelButton: true, confirmButtonColor: '#4a00e0', confirmButtonText: 'Yes, Cancel it' }).then((r) => {
        if (r.isConfirmed) { $(btn).closest('tr').fadeOut(400); Swal.fire('Deleted', 'Request removed', 'success'); }
      });
    }
    $(function () { $('[title]').tooltip(); });
  </script>
<script>
  function confirmCancel(leaveId) {
      Swal.fire({ 
        title: 'Cancel Leave Request?', 
        text: "Are you sure you want to withdraw this pending request? This action cannot be undone.", 
        icon: 'warning', 
        showCancelButton: true, 
        confirmButtonColor: '#dc2626', // var(--bloom-danger)
        cancelButtonColor: '#64748b',  // muted slate
        confirmButtonText: 'Yes, Cancel it!',
        cancelButtonText: 'Keep Request',
        customClass: {
            confirmButton: 'btn btn-danger rounded-pill px-4',
            cancelButton: 'btn btn-secondary rounded-pill px-4 mx-2'
        },
        buttonsStyling: false // Allows our custom bootstrap classes to take over
      }).then((result) => {
        if (result.isConfirmed) {
          // Show a quick loading state so the user knows it's working
          Swal.fire({
            title: 'Cancelling...',
            allowOutsideClick: false,
            didOpen: () => {
              Swal.showLoading();
            }
          });
          
          // Submit the specific form naturally
          document.getElementById('cancelForm_' + leaveId).submit();
        }
      });
    }

    $(document).ready(function () {
    $('#leaveHistoryTable').DataTable({
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

<?php if (session()->getFlashdata('success')) : ?>
<script>
Swal.fire({
    icon: 'success',
    title: 'Success',
    text: '<?= session()->getFlashdata('success'); ?>',
    confirmButtonColor: '#4a00e0'
});
</script>
<?php endif; ?>
</body>

</html>
