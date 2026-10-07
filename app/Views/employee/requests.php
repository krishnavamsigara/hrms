<!DOCTYPE html>
<html lang="en" style="height: 100%; overflow: hidden;">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bloom Solution | My Requests</title>

  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">

  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">


  <style>
    :root {
  --bloom-purple: #4a00e0;
  --bloom-dark: #120038;
  --bloom-bg: #f8fafc;

  --sidebar-bg: #111c43;
  --bloom-blue: #4a8cff;
  --bloom-orange: #ff7a45;

  --text-dark: #1e293b;
  --text-muted: #64748b;
  --border-color: #e2e8f0;

  --card-bg: #ffffff;
  --soft-purple: #eef2ff;
  --soft-red: #fff1f2;
}

    body {
  font-family: 'Plus Jakarta Sans', sans-serif;
  background-color: var(--bloom-bg);
  color: var(--text-dark);
  font-size: 13px;
  height: 100%;
  overflow: hidden;
}

    .wrapper {
      height: 100vh;
      display: flex;
      flex-direction: column;
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

    .content-wrapper {
      background: var(--bloom-bg) !important;
      height: calc(100vh - 57px - 50px) !important;
      overflow: hidden !important;
      display: flex;
      flex-direction: column;
      padding: 15px !important;
    }

    .container-fluid {
      display: flex;
      flex-direction: column;
      height: 100%;
      gap: 15px;
    }

    .row-flex {
      display: flex;
      flex: 1;
      gap: 15px;
      min-height: 0;
    }

    .p-card {
      background: #fff;
      border-radius: 20px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.02);
      padding: 20px;
      display: flex;
      flex-direction: column;
    }

    .scroll-area {
      flex: 1;
      overflow-y: auto;
      padding-right: 5px;
    }

    .scroll-area::-webkit-scrollbar {
      width: 5px;
    }

    .scroll-area::-webkit-scrollbar-thumb {
      background: #e2e8f0;
      border-radius: 10px;
    }

    .section-label {
      color: var(--bloom-purple);
      font-weight: 800;
      font-size: 11px;
      text-transform: uppercase;
      margin-bottom: 15px;
      display: block;
      border-left: 4px solid var(--bloom-purple);
      padding-left: 12px;
    }

    .main-footer {
      background: #fff !important;
      border-top: 1px solid #e2e8f0 !important;
      color: #64748b;
      font-size: 12px;
      padding: 1rem 1.5rem !important;
    }

    .form-control,
    .custom-select {
      border-radius: 8px;
      border: 1px solid #e2e8f0;
      padding: 10px 15px;
      font-size: 13px;
      height: auto;
      box-shadow: none !important;
    }

    .form-control:focus,
    .custom-select:focus {
      border-color: var(--bloom-purple);
      box-shadow: 0 0 0 0.2rem rgba(74, 0, 224, 0.1) !important;
    }

    .btn-submit {
      background: var(--bloom-purple);
      color: #fff;
      font-weight: 700;
      border-radius: 8px;
      padding: 10px 20px;
      border: none;
      transition: all 0.3s ease;
    }

    .btn-submit:hover {
      background: #3a00b0;
      color: #fff;
      transform: translateY(-1px);
    }
/* STATUS BADGES */
.badge-status{
    width: 100px;
    padding: 6px 0;
    text-align: center;
    border-radius: 10px;
    font-weight: 700;
    font-size: 11px;
    display: inline-block;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Pending */
.badge-pending{
    background:#fff7ed;
    color:#ea580c;
}

/* Completed */
.badge-approved{
    background:#ecfdf5;
    color:#10b981;
}

/* Resolved */
.badge-resolved{
    background:#eff6ff;
    color:#2563eb;
}

/* Cancelled */
.badge-cancelled{
    background:#f1f5f9;
    color:#64748b;
}
    .table td,
    .table th {
      padding: 12px;
      vertical-align: middle;
      border-top: 1px solid #f1f5f9;
    }

    .table th {
      color: #64748b;
      font-weight: 600;
      font-size: 12px;
      text-transform: uppercase;
      border-top: none;
      border-bottom: 2px solid #e2e8f0;
    }

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

/* =========================================================
   MOBILE RESPONSIVENESS
   ========================================================= */

@media (max-width: 767.98px) {

    /* Allow the page itself to scroll on mobile */
    html,
    body {
        height: auto !important;
        min-height: 100%;
        overflow-x: hidden !important;
        overflow-y: auto !important;
    }

    .wrapper {
        min-height: 100vh !important;
        height: auto !important;
    }

    .content-wrapper {
        height: auto !important;
        min-height: calc(100vh - 57px) !important;
        overflow: visible !important;
        padding: 10px !important;
    }

    .container-fluid {
        height: auto !important;
        gap: 10px;
        padding: 0 !important;
    }

    /* Page heading card */
    .container-fluid > .p-card:first-of-type {
        padding: 15px !important;
        border-radius: 14px;
    }

    .container-fluid > .p-card:first-of-type h5 {
        font-size: 17px !important;
    }

    .container-fluid > .p-card:first-of-type p {
        font-size: 11px !important;
        line-height: 1.5;
    }

    /* IMPORTANT:
       Change two-column layout into one column */
    .row-flex {
        display: flex !important;
        flex-direction: column !important;
        gap: 10px !important;
        flex: none !important;
        min-height: auto !important;
    }

    /* Both cards full width */
    .row-flex > .p-card {
        flex: none !important;
        width: 100% !important;
        min-width: 0 !important;
        padding: 15px !important;
        border-radius: 14px;
    }

    /* Create Request card */
    .row-flex > .p-card:first-child {
        min-height: auto !important;
    }

    .section-label {
        font-size: 10px !important;
        padding-left: 9px;
        margin-bottom: 15px !important;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        font-size: 12px;
    }

    .form-control,
    .custom-select {
        width: 100% !important;
        font-size: 12px !important;
        padding: 9px 11px !important;
    }

    textarea.form-control {
        min-height: 100px;
    }

    /* Form buttons */
    .row-flex > .p-card:first-child .border-top {
        padding-top: 12px !important;
        margin-top: 5px !important;
    }

    .row-flex > .p-card:first-child .border-top {
        display: flex;
        justify-content: flex-end;
        flex-wrap: wrap;
        gap: 8px;
    }

    .row-flex > .p-card:first-child .border-top .btn {
        margin-right: 0 !important;
        font-size: 11px;
        padding: 8px 12px;
    }

    .btn-submit {
        padding: 8px 12px !important;
        font-size: 11px !important;
    }

    /* Request history card */
    .row-flex > .p-card:last-child {
        min-height: 400px !important;
        overflow: hidden !important;
    }

    /* Let table scroll horizontally instead of cutting */
    .row-flex > .p-card:last-child .scroll-area {
        width: 100% !important;
        overflow-x: auto !important;
        overflow-y: visible !important;
        padding-right: 0 !important;
        -webkit-overflow-scrolling: touch;
    }

    #requestHistoryTable {
        width: 700px !important;
        min-width: 700px !important;
        margin-bottom: 0 !important;
    }

    #requestHistoryTable th,
    #requestHistoryTable td {
        padding: 9px 8px !important;
        font-size: 11px !important;
        white-space: nowrap;
    }

    #requestHistoryTable th {
        font-size: 10px !important;
    }

    /* Subject can wrap */
    #requestHistoryTable td:nth-child(3) {
        white-space: normal !important;
        min-width: 180px;
        max-width: 220px;
    }

    /* Status column */
    .badge-status {
        width: 90px !important;
        font-size: 10px !important;
        padding: 5px 0 !important;
    }

    #requestHistoryTable .btn {
        width: 90px !important;
        font-size: 10px !important;
        padding: 5px !important;
    }

    /* DataTable top controls */
    .dataTables_wrapper {
        width: 100% !important;
        overflow: visible !important;
    }

    .dataTables_wrapper .row:first-child {
        display: flex !important;
        flex-direction: column !important;
        align-items: stretch !important;
        width: 100% !important;
        margin: 0 !important;
    }

    .dataTables_wrapper .dataTables_length {
        float: none !important;
        margin: 0 0 8px 0 !important;
        width: 100% !important;
    }

    .dataTables_wrapper .dataTables_length label {
        width: 100%;
        font-size: 11px;
    }

    .dataTables_wrapper .dataTables_length select {
        width: auto !important;
        margin: 0 4px;
    }

    .dataTables_wrapper .dataTables_filter {
        float: none !important;
        margin: 0 0 10px 0 !important;
        text-align: left !important;
        width: 100% !important;
    }

    .dataTables_wrapper .dataTables_filter label {
        width: 100%;
        font-size: 11px;
    }

    .dataTables_wrapper .dataTables_filter input {
        width: calc(100% - 50px) !important;
        max-width: 100% !important;
        margin-left: 5px !important;
        padding: 7px 10px !important;
        font-size: 11px !important;
    }

    /* DataTable bottom */
    .dataTables_wrapper .row:last-child {
        display: flex !important;
        flex-direction: column !important;
        align-items: center !important;
        margin: 10px 0 0 !important;
    }

    .dataTables_wrapper .dataTables_info {
        text-align: center !important;
        font-size: 10px !important;
        margin-bottom: 8px !important;
    }

    .dataTables_wrapper .dataTables_paginate {
        float: none !important;
        text-align: center !important;
    }

    .dataTables_paginate .paginate_button {
        margin: 0 1px !important;
    }

    .dataTables_paginate .page-link {
        padding: 5px 8px !important;
        font-size: 10px !important;
    }

    /* Success alert */
    .alert.alert-success {
        position: fixed !important;
        top: 10px !important;
        left: 10px !important;
        right: 10px !important;
        min-width: auto !important;
        width: auto !important;
        font-size: 12px;
        z-index: 9999;
    }

    /* Modal */
    .modal-dialog {
        margin: 10px !important;
    }

    .modal-content {
        border-radius: 14px;
    }

    .modal-title {
        font-size: 15px;
    }

    .modal-body {
        font-size: 12px;
    }

    .modal-footer .btn {
        font-size: 11px;
        padding: 7px 12px;
    }

    /* Footer */
    .main-footer {
        margin-left: 0 !important;
        padding: 10px !important;
        text-align: center;
        font-size: 10px !important;
    }
}


/* Very small phones */
@media (max-width: 400px) {

    .content-wrapper {
        padding: 7px !important;
    }

    .row-flex > .p-card {
        padding: 12px !important;
    }

    .container-fluid > .p-card:first-of-type h5 {
        font-size: 15px !important;
    }

    .container-fluid > .p-card:first-of-type p {
        font-size: 10px !important;
    }

    .section-label {
        font-size: 9px !important;
    }

    .btn-submit,
    .row-flex > .p-card:first-child .border-top .btn {
        font-size: 10px !important;
        padding: 7px 9px !important;
    }
}
  </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
   

    <div class="content-wrapper">
      <div class="container-fluid">
        <?php if(session()->getFlashdata('status') == 'Y') : ?>
<div class="alert alert-success"
     style="
        position:fixed;
        top:20px;
        right:20px;
        z-index:9999;
        min-width:280px;
        border-radius:10px;
        box-shadow:0 4px 12px rgba(0,0,0,0.15);
     ">
    <?= session()->getFlashdata('remarks') ?>
</div>
<?php endif; ?>
        <div class="p-card flex-row justify-content-between align-items-center" style="flex: 0 0 auto;">
          <div>
            <h5 class="font-weight-bold mb-0">My Requests</h5>
            <p class="text-muted mb-0 small">Submit and track requests for HR or your Manager</p>
          </div>
        </div>

        <div class="row-flex">
          <!-- Submit Form Card -->
          <div class="p-card" style="flex: 1;">
            <span class="section-label">Create New Request</span>
            <div class="scroll-area pr-3">
             <form action="<?= base_url('employee/submit_request') ?>" method="post" enctype="multipart/form-data">
                <div class="form-group">
                  <label class="font-weight-bold">Request Type</label>
                  <select name="category" class="custom-select form-control" required>
                    <option value="" disabled selected>Select category...</option>
                    <?php if (!empty($request_types)) : ?>
                      <?php foreach ($request_types as $type) : ?>
                        <option value="<?= esc($type['type_name']) ?>"><?= esc($type['type_name']) ?></option>
                      <?php endforeach; ?>
                    <?php else : ?>
                      <option value="Missing Punchout">Missing Punchout</option>
                      <option value="Attendance">Attendance</option>
                      <option value="Profile Update">Profile Update</option>
                      <option value="Payroll Query">Payroll Query</option>
                      <option value="IT Support">IT Support</option>
                      <option value="General Grievance">General Grievance</option>
                      <option value="Other">Other</option>
                    <?php endif; ?>
                  </select>
                </div>

                

                <div class="form-group">
                  <label class="font-weight-bold">Subject</label>
                  <input type="text"  name="subject" class="form-control" placeholder="Brief summary of your request" >
                </div>

                <div class="form-group">
                  <label class="font-weight-bold">Description</label>
                  <textarea name="description" class="form-control" rows="4"
                    placeholder="Please provide detailed information regarding your request..."></textarea>
                </div>

                <!-- <div class="form-group">
                  <label class="font-weight-bold">Attachment <span
                      class="text-muted font-weight-normal">(Optional)</span></label>
                  <div class="custom-file">
                    <input type="file"name="attachment" class="custom-file-input" id="customFile">
                    <label class="custom-file-label" for="customFile" style="border-radius: 8px;">Choose file...</label>
                  </div>
                </div> -->
              
            </div>
            <div class="pt-3 border-top mt-auto text-right">
              <button type="button" class="btn btn-light font-weight-bold mr-2"
                style="border-radius: 8px;">Cancel</button>
              <button type="submit" class="btn btn-submit">
                <i class="fas fa-paper-plane mr-2"></i>Submit Request
              </button>
           </form>
            </div>
          </div>

          <!-- History Card -->
          <div class="p-card" style="flex: 2;">
            <span class="section-label">Request History</span>
            <div class="scroll-area">
             <table id="requestHistoryTable" class="table table-hover mb-0">
                <thead>
                  <tr>
                    <th>Date</th>
                    <th>Request ID</th>
                    <th>Subject</th>
                    <th>Progress</th>
                    <th>Status</th>
                    <!-- <th>Action</th> -->
                  </tr>
                </thead>
                
                <tbody>
        <?php if (!empty($requests)) : ?>
         <?php foreach($requests as $row) : ?>

        <?php
        $badgeClass = 'badge-pending';

        if ($row['status'] == 'PENDING') {
            $badgeClass = 'badge-pending';
        }
        elseif ($row['status'] == 'RESOLVED') {
            $badgeClass = 'badge-resolved';
        }
        elseif ($row['status'] == 'COMPLETED') {
            $badgeClass = 'badge-approved';
        }
        elseif ($row['status'] == 'CANCELLED') {
            $badgeClass = 'badge-cancelled';
        }
        ?>

        <tr>
            <td class="text-muted">
                <?= date('d M Y', strtotime($row['created_at'] ?? '')) ?>
            </td>

            <td class="font-weight-bold">
                <?=esc($row['request_id'] ?? '') ?>
            </td>

            <td>
                <span class="font-weight-bold text-dark">
                    <?= esc($row['subject'] ?? '') ?>
                </span>
                <br>
                <small class="text-muted">
                    <?= esc($row['category'] ?? '') ?>
                </small>
            </td>

            <td>
                <?= esc($row['progress'] ?? '') ?>
            </td>

          <td>
    <div class="d-flex flex-column align-items-center">

        <span class="badge-status <?= $badgeClass ?>">
            <?= esc($row['status']) ?>
        </span>

        <?php if($row['status'] == 'PENDING') : ?>

            <a href="javascript:void(0);"
               class="btn btn-sm btn-danger mt-1"
               style="width:100px;border-radius:8px;font-size:11px;"
               onclick="openCancelModal(<?= $row['request_id'] ?>)">
                Cancel
            </a>

        <?php elseif($row['status'] == 'RESOLVED') : ?>

            <form action="<?= base_url('employee/complete_request') ?>"
                  method="post"
                  class="mt-1">

                <input type="hidden"
                       name="request_id"
                       value="<?= $row['request_id'] ?>">

                <button type="submit"
                        class="btn btn-sm btn-success"
                        style="width:100px;border-radius:8px;font-size:11px;">
                    Complete
                </button>

            </form>

        <?php endif; ?>

    </div>
</td>
           
        </tr>

    <?php endforeach; ?>
<?php else : ?>
    <tr>
    <td></td> <!-- Date -->
    <td></td> <!-- Ticket ID -->

    <td class="text-center">
        <?= ucfirst(esc($requests[0]['remarks'] ?? 'No Requests Found')) ?>
    </td>

    <td></td> <!-- Progress -->
    <td></td> <!-- Status -->
    </tr>
<?php endif; ?>
</tbody>
              </table>
            </div>
          </div>
        </div>
<div class="modal fade" id="cancelModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Cancel Request</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <div class="modal-body">
        Are you sure you want to cancel this request?
      </div>

      <div class="modal-footer">
        <a id="confirmCancelBtn" class="btn btn-danger">Yes, Cancel</a>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
      </div>

    </div>
  </div>
</div>
      </div>
    </div>

    <footer class="main-footer">
      <strong>Copyright &copy; 2026 <a href="https://www.bloomsolutions.in/" class="footer-link ml-1">Bloom
          Solutions</a></strong>
    </footer>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.min.js"></script>

  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>


  <script>
    $(document).ready(function () {
      bsCustomFileInput.init();
    });

    function openCancelModal(requestId)
    {
    let url = "<?= base_url('employee/cancel_request/') ?>" + requestId;
    document.getElementById('confirmCancelBtn').href = url;

    $('#cancelModal').modal('show');
    }
  </script>
  <script>
$(document).ready(function () {
    $('#requestHistoryTable').DataTable({
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
