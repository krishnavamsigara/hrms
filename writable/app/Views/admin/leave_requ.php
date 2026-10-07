<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bloom Solutions | Request Detail</title>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
  <style>
    :root { --bloom-purple: #4a00e0; --bloom-dark: #120038; --bloom-orange: #e46c44; --bloom-success: #10b981; --bloom-danger: #dc2626; --mtn-deep: #120038; --soft-gray: #f8fafc; --border-color: #e2e8f0; }
    body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: var(--soft-gray); font-size: 13px; color: #334155; }
    .card-bloom { border: 1px solid var(--border-color) !important; border-radius: 20px !important; background: #fff; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.04) !important; margin-bottom: 20px; overflow: hidden; }
    .logo-circle { width: 42px; height: 42px; border-radius: 50%; object-fit: cover; border: 2px solid #fff; margin-right: 10px; }
    .brand-blue { color: #4a8cff; }
    .brand-orange { color: #ff7a45; }
    .avatar-sm { width: 45px; height: 45px; border-radius: 12px; }
    .main-footer { background: #fff !important; border-top: 1px solid #e2e8f0 !important; color: #64748b; padding: 1rem 1.5rem !important; }
 .nav-pills .nav-link.active{ background:#007bff!important; color:#fff!important; }
  </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <div class="content-wrapper">
    <section class="content pt-4">
      <div class="container-fluid">
        <div class="row">
          
          <div class="col-lg-8">
            <div class="card-bloom p-4">
              <div class="d-flex justify-content-between align-items-start mb-4">
                <div>
                  <h5 class="font-weight-bold mb-1" style="color: var(--bloom-purple)">Application Details</h5>
                  <span class="text-muted small">Leave Application Id:<?= $leave['leave_app_id'] ?></span>
                </div>
                <span class="badge badge-pill badge-warning px-3 py-2"><?= esc($leave['leave_status']) ?></span>
              </div>

              <div class="row mt-4">
                <div class="col-md-6 mb-4">
                  <label class="text-muted small font-weight-bold text-uppercase">Employee</label>
                  <div class="d-flex align-items-center mt-1">
                    <img src="https://ui-avatars.com/api/?name=<?= urlencode($leave['emp_name']) ?>&background=4a00e0&color=fff"
                        class="avatar-sm mr-2">

                   <div>
                    <p class="mb-0 font-weight-bold">
                        <?= esc($leave['emp_name']) ?>
                    </p>
                    <small class="text-dark font-weight-bold d-block">
                        Employee ID: <?= esc($leave['emp_id']) ?>
                    </small>
                    <small class="text-dark font-weight-bold d-block">
                        Department: <?= esc($leave['department_name']) ?>
                    </small>
                </div>
                </div>
                </div>
                <div class="col-md-6 mb-4">
                  <label class="text-muted small font-weight-bold text-uppercase">Dates</label>
                  <p class="font-weight-bold mt-1 text-dark"><?= date('d M Y', strtotime($leave['from_date'])) ?>
                  -
                  <?= date('d M Y', strtotime($leave['to_date'])) ?>
                  (<?= $leave['applied_days'] ?> Days)</p>
                  <small class="text-dark font-weight-bold">
                    Applied On: <?= date('d M Y', strtotime($leave['applied_on'])) ?>
                </small>
                </div>
                <div class="col-12 mb-4">
                  <label class="text-muted small font-weight-bold text-uppercase">Reason</label>
                  <div class="p-3 rounded mt-1 shadow-sm" style="background: #f8fafc; border-left: 4px solid var(--bloom-purple);">
                    <?= esc($leave['reason']) ?>
                  </div>
                </div>
              </div>

             <div class="mt-4 pt-4 border-top">
                <?php 
                  // Clean the status string once to avoid typos
                  $status_check = strtolower(trim($leave['leave_status'])); 
                ?>

                <?php if ($status_check === 'pending'): ?>
                  
                  <form id="decisionForm" action="<?= base_url('leave/leave_decision') ?>" method="POST">
                    <input type="hidden" id="userCategory" value="<?= session()->get('user_category') ?>">
                    <input type="hidden" name="leave_id" value="<?= $leave['leave_app_id'] ?>">
                    <input type="hidden" name="decision" id="decisionInput" value="">
                    
                    <label class="font-weight-bold mb-2">Admin Remarks</label>
                    <textarea name="reason" id="adminRemarks" class="form-control mb-3 shadow-sm" rows="3" placeholder="Enter reason for decision..." style="background: #f1f5f9; border: 1px solid #e2e8f0;"></textarea>
                    
                    <div class="d-flex justify-content-end mt-3">
                      <button type="button" id="btnReject" class="btn btn-outline-danger px-4 rounded-pill mr-2">Reject Request</button>
                      <button type="button" id="btnApprove" class="btn btn-success px-4 rounded-pill font-weight-bold" style="background: var(--bloom-purple); border:none;">Approve Request</button>
                    </div>
                  </form>

                <?php elseif ($status_check === 'approved'): ?>
                  <div class="alert alert-success text-center mb-3" style="border-radius: 12px;">
                    <h6 class="mb-0 font-weight-bold"><i class="fas fa-check-circle mr-2"></i> Leave Approved</h6>
                  </div>
                  
                  <?php if (!empty($leave['rejection_reason'])): ?>
                    <div class="p-3 rounded shadow-sm" style="background: #f8fafc; border-left: 4px solid var(--bloom-success);">
                      <label class="text-muted small font-weight-bold text-uppercase d-block mb-1">Admin Remarks</label>
                      <span class="text-dark"><?= esc($leave['rejection_reason']) ?></span>
                    </div>
                  <?php endif; ?>

                <?php elseif ($status_check === 'rejected' || $status_check === 'reject'): ?>
                  <div class="alert alert-danger text-center mb-3" style="border-radius: 12px;">
                    <h6 class="mb-0 font-weight-bold"><i class="fas fa-times-circle mr-2"></i> Leave Rejected</h6>
                  </div>
                  
                  <?php if (!empty($leave['rejection_reason'])): ?>
                    <div class="p-3 rounded shadow-sm" style="background: #f8fafc; border-left: 4px solid var(--bloom-danger);">
                      <label class="text-muted small font-weight-bold text-uppercase d-block mb-1">Reason for Rejection</label>
                      <span class="text-dark"><?= esc($leave['rejection_reason']) ?></span>
                    </div>
                  <?php else: ?>
                     <div class="p-3 rounded shadow-sm text-center text-muted" style="background: #f8fafc; border: 1px dashed var(--border-color);">
                        No reason provided.
                     </div>
                  <?php endif; ?>

                <?php endif; ?>
              </div>
            </div>
          </div>

          <div class="col-lg-4">
            <div class="card-bloom p-3 mb-3 border-0" style="background: #fff4f0;">
              <h6 class="font-weight-bold text-warning mb-2"><i class="fas fa-exclamation-triangle mr-2"></i>Conflict Alert</h6>
              <!-- <p class="small text-dark mb-0"><strong>2 other members</strong> from Marketing are off during these dates.</p> -->
               <p class="small text-dark mb-0 text-center">
              <span class="px-3 py-2 rounded-pill font-weight-bold"
                    style="background:#fff; color:#f59e0b; border:1px dashed #f59e0b; display:inline-block;">
                  🚧 Coming Soon
              </span>
          </p>
            </div>

            <div class="card-bloom p-3">
              <h6 class="font-weight-bold mb-3">Leave Available (2026)</h6>
               <?php
               $personalUsed = $leave_balance['Personal_leaves_used'] ?? 0;
               $personalOpening = $leave_balance['Personal_leaves_bal'] ?? 0;
               $personalPct = ($personalOpening > 0) ? ($personalUsed / $personalOpening) * 100 : 0;
                ?>
              <div class="mb-3">
                <div class="d-flex justify-content-between mb-1 small">
                  <span class="text-muted">Personal Leave</span>
                    <span class="font-weight-bold">
                       <?= (int)$personalUsed ?> / <?= (int)$personalOpening ?> Days
                    </span>
                </div>
                <div class="progress progress-xxs" style="height: 6px;">
                  <div class="progress-bar bg-primary" style="width: <?= $personalPct ?>%"></div>
                </div>
              </div>
              <?php
              $sickUsed = $leave_balance['sick_leaves_used'] ?? 0;
              $sickOpening = $leave_balance['sick_leavs_bal'] ?? 0;
              $sickPct = ($sickOpening > 0) ? ($sickUsed / $sickOpening) * 100 : 0;
              ?>
              <div class="mb-3">
                <div class="d-flex justify-content-between mb-1 small">
                   <span class="text-muted">Sick Leave</span>
                    <span class="font-weight-bold">
                       <?= (int)$sickUsed ?> / <?= (int)$sickOpening ?> Days
                    </span>
                </div>
                <div class="progress progress-xxs" style="height: 6px;">
                  <div class="progress-bar bg-success" style="width: <?= $sickPct ?>%"></div>
                </div>
              </div>

              <?php
              $matUsed = $leave_balance['maternity_used'] ?? 0;
              $matOpening = $leave_balance['maternity_bal'] ?? 0;
              $matPct = ($matOpening > 0) ? ($matUsed / $matOpening) * 100 : 0;
              ?>

              <div class="mb-3">
                <div class="d-flex justify-content-between mb-1 small">
                   <span class="text-muted">Maternity Leave</span>
                  <span class="font-weight-bold">
                      <?= (int)$matUsed ?> / <?= (int)$matOpening ?> Days
                  </span>
                </div>
                <div class="progress progress-xxs" style="height: 6px;">
                  <div class="progress-bar bg-warning" style="width: <?= $matPct ?>%"></div>
                </div>
              </div>
            <?php
            $lopUsed = (float)($leave_balance['lop_used'] ?? 0);
            ?>

            <div class="mb-3">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="text-muted">LOP</span>
                    <span class="badge badge-danger px-3 py-2">
                        <?= $lopUsed ?> Day<?= ($lopUsed != 1) ? 's' : '' ?>
                    </span>
                </div>
            </div>          
                <!-- <div class="py-2 px-3 rounded mb-3" style="background: var(--soft-gray); border: 1px dashed var(--border-color);">
                <small class="text-muted d-block">Current Request Impact:</small>
                <span class="font-weight-bold text-danger">-3 Days Earned Leave</span>
              </div> -->

              <!-- <hr> -->

              <!-- <h6 class="font-weight-bold mb-3 small text-uppercase text-muted">Recent History</h6>
              <div class="recent-item mb-3">
                <div class="d-flex justify-content-between align-items-center">
                  <span class="font-weight-bold small">Sick Leave</span>
                  <span class="badge badge-light border">Sep 12</span>
                </div>
                <small class="text-muted">1 Day • Approved</small>
              </div>
              <div class="recent-item">
                <div class="d-flex justify-content-between align-items-center">
                  <span class="font-weight-bold small">Casual Leave</span>
                  <span class="badge badge-light border">Aug 05</span>
                </div>
                <small class="text-muted">2 Days • Approved</small>
              </div>
            </div>
          </div> -->

        </div>
      </div>
    </section>
  </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
</body>
</html>
<script>
$(document).ready(function() {
    // Clear error styling
    $('#adminRemarks').on('input', function() {
        $(this).removeClass('is-invalid border-danger')
               .attr('placeholder', 'Enter reason for decision...');
    });

    // Handle the Approve Button
    $('#btnApprove').click(function() {

    var userCategory = $('#userCategory').val();
    var reason = $('#adminRemarks').val().trim();

    if (userCategory === 'HR' && reason === '') {
        $('#adminRemarks')
            .addClass('is-invalid border-danger')
            .attr('placeholder', '⚠️ HR remarks are required for approval...')
            .focus();
        return false;
    }

    $('#decisionInput').val('Approved');

    $(this).html('<i class="fas fa-check-circle mr-1"></i> Leave Approved');
    $(this).prop('disabled', true);
    $('#btnReject').prop('disabled', true).removeClass('btn-outline-danger').addClass('text-muted');

    $('#decisionForm').submit();
});

    // Handle the Reject Button
    $('#btnReject').click(function() {
        var reason = $('#adminRemarks').val().trim();
        
        if (reason === '') {
            $('#adminRemarks')
                .addClass('is-invalid border-danger') 
                .attr('placeholder', '⚠️ Required: Please enter a reason for rejection...') 
                .focus(); 
            return false; 
        }
        
        // Sends EXACTLY "Reject" to the DB
        $('#decisionInput').val('Reject');
        
        $(this).html('<i class="fas fa-times-circle mr-1"></i> Leave Rejected');
        $(this).prop('disabled', true);
        $('#btnApprove').prop('disabled', true).css('opacity', '0.5'); 
        $('#decisionForm').submit();
    });
});
</script>