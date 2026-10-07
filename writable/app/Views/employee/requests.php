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
      --bloom-bg: #f4f7fe;
      --glass: rgba(255, 255, 255, 0.8);
      --mtn-deep: #1e293b;
    }

    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      background-color: var(--bloom-bg);
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
                  <option value="Profile Update">Profile Update</option>
                  <option value="Payroll Query">Payroll Query</option>
                  <option value="IT Support">IT Support</option>
                  <option value="General Grievance">General Grievance</option>
                  <option value="Other">Other</option>
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
