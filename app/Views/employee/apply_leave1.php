
<?php 
$leave = $leave[0] ?? []; 
$session = session();
$original_role = $session->get('user_category');
$employeeGender = session()->get('gender');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bloom Solution | Apply Leave</title>

  
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

  <style>
    :root {
      --bloom-purple: #4a00e0;
      --bloom-dark: #2a0080;
      --mtn-deep: #120038;
      --bloom-success: #10b981;
      --glass: rgba(255, 255, 255, 0.95);
    }

    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      background-color: #f8fafc;
      font-size: 13px;
      color: #334155;
    }

    /* --- LAYOUT --- */
    .main-header {
      border-bottom: 1px solid #e2e8f0 !important;
      background: var(--glass) !important;
      backdrop-filter: blur(10px);
    }


    .logo-circle {
      width: 42px;
      height: 42px;
      border-radius: 50%;
      border: 2px solid #fff;
      margin-right: 10px;
    }

    .brand-blue {
      color: #4a8cff;
      font-weight: 700;
    }

    .brand-orange {
      color: #ff7a45;
      font-weight: 700;
    }

    /* --- LEAVE FORM STYLES --- */
    .leave-card {
      background: #fff;
      border-radius: 24px;
      padding: 30px;
      border: 1px solid #e2e8f0;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.02);
      height: 100%;
    }

    .balance-pill {
      background: #f8fafc;
      border: 1px solid #e2e8f0;
      border-radius: 15px;
      padding: 15px;
      text-align: center;
      transition: 0.3s;
    }

    .balance-pill:hover {
      border-color: var(--bloom-purple);
      background: #fff;
    }

    .form-control-bloom {
      border-radius: 12px;
      border: 1px solid #e2e8f0;
      padding: 12px 15px;
      height: auto;
      font-size: 13px;
      font-weight: 500;
      transition: 0.3s;
    }

    .form-control-bloom:focus {
      border-color: var(--bloom-purple);
      box-shadow: 0 0 0 4px rgba(74, 0, 224, 0.05);
    }

    .section-head {
      font-size: 11px;
      font-weight: 800;
      text-transform: uppercase;
      letter-spacing: 1.5px;
      color: var(--bloom-purple);
      margin-bottom: 20px;
      display: block;
      border-left: 3px solid var(--bloom-purple);
      padding-left: 12px;
    }

    .btn-apply {
      background: linear-gradient(135deg, var(--bloom-purple) 0%, var(--bloom-dark) 100%);
      color: #fff;
      border: none;
      border-radius: 12px;
      padding: 12px 30px;
      font-weight: 700;
      letter-spacing: 0.5px;
      transition: 0.3s;
    }

    .btn-apply:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 20px rgba(74, 0, 224, 0.2);
      color: #fff;
    }

    .main-footer {
      background: #fff !important;
      border-top: 1px solid #e2e8f0 !important;
      color: #64748b;
      font-size: 12px;
      padding: 1rem 1.5rem !important;
    }

    .footer-link {
      color: var(--bloom-purple);
      font-weight: 600;
      text-decoration: none;
    }

    /* --- ALIGNMENT FIX FOR CHECKBOX --- */
    .custom-control {
      display: flex !important;
      align-items: center !important;
      min-height: unset !important;
    }

    .custom-control-label {
      padding-top: 2px;
      cursor: pointer;
    }

    .custom-control-label::before,
    .custom-control-label::after {
      top: 0.15rem !important;
    }

    .flatpickr-day.sunday-day {
    background: #d1d5db !important;
    color: #475569 !important;
    border-color: #d1d5db !important;
    border-radius: 100px;
}
.sidebar-dark-primary .nav-sidebar > .nav-item > .nav-link.active {
  background-color: #007bff !important;
  color: #ffffff !important;
}
 
    /* --- LEAVE FORM STYLES --- */
    .leave-card {
      background: #fff;
      border-radius: 24px;
      padding: 30px;
      border: 1px solid #e2e8f0;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.02);
      height: 100%;
    }
 
    .balance-pill {
      background: #f8fafc;
      border: 1px solid #e2e8f0;
      border-radius: 15px;
      padding: 15px;
      text-align: center;
      transition: 0.3s;
    }
 
    .balance-pill:hover {
      border-color: var(--bloom-purple);
      background: #fff;
    }
 
    .form-control-bloom {
      border-radius: 12px;
      border: 1px solid #e2e8f0;
      padding: 12px 15px;
      height: auto;
      font-size: 13px;
      font-weight: 500;
      transition: 0.3s;
    }
 
    .form-control-bloom:focus {
      border-color: var(--bloom-purple);
      box-shadow: 0 0 0 4px rgba(74, 0, 224, 0.05);
    }
 
    .section-head {
      font-size: 11px;
      font-weight: 800;
      text-transform: uppercase;
      letter-spacing: 1.5px;
      color: var(--bloom-purple);
      margin-bottom: 20px;
      display: block;
      border-left: 3px solid var(--bloom-purple);
      padding-left: 12px;
    }
 
    .btn-apply {
      background: linear-gradient(135deg, var(--bloom-purple) 0%, var(--bloom-dark) 100%);
      color: #fff;
      border: none;
      border-radius: 12px;
      padding: 12px 30px;
      font-weight: 700;
      letter-spacing: 0.5px;
      transition: 0.3s;
    }
 
    .btn-apply:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 20px rgba(74, 0, 224, 0.2);
      color: #fff;
    }
 
   .btn-view-history {
    background: linear-gradient(135deg, #0f766e, #115e59);
    color: #ffffff !important;
    border: none;
    border-radius: 12px;
    font-weight: 700;
    font-size: 13px;
    padding: 12px 20px;
    box-shadow: 0 4px 10px rgba(15, 118, 110, 0.20);
    transition: all 0.25s ease;
}

.btn-view-history:hover {
    background: linear-gradient(135deg, #115e59, #134e4a);
    color: #ffffff !important;
    transform: translateY(-1px);
    box-shadow: 0 6px 14px rgba(15, 118, 110, 0.28);
}


  </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

    <div class="content-wrapper">
      <div class="container-fluid px-4 py-4">

        <div class="row mb-4">
          <div class="col-md-3 mb-2">
            <div class="balance-pill">
              <span class="text-muted small font-weight-bold d-block mb-1">Total Applied Leaves(days)</span>
              <h4 class="font-weight-bold mb-0 text-primary"><?= number_format($leave['Total_Leave_Days'] ?? (($leave['Total_Approved_Days'] ?? 0) + ($leave['Total_Pending_Days'] ?? 0)), 0) ?></h4>
            </div>
          </div>
          <div class="col-md-3 mb-2">
            <div class="balance-pill"><span class="text-muted small font-weight-bold d-block mb-1">Approved Leave(days)</span>
              <h4 class="font-weight-bold mb-0 text-success"><?= number_format($leave['Total_Approved_Days'] ?? 0, 0) ?></h4>
            </div>
          </div>
          <div class="col-md-3 mb-2">
            <div class="balance-pill"><span class="text-muted small font-weight-bold d-block mb-1">Pending Requests</span>
              <h4 class="font-weight-bold mb-0 text-info"><?= number_format($leave['Pending_Leaves'] ?? 0, 0) ?></h4>
            </div>
          </div>
          <div class="col-md-3 mb-2">
            <div class="balance-pill"><span class="text-muted small font-weight-bold d-block mb-1">WFH (days)</span>
              <h4 class="font-weight-bold mb-0 text-danger"> <?= number_format($leave['WFH_taken'] ?? 0, 0) ?></h4>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-8 mb-4">
            <div class="leave-card">
              <span class="section-head">New Leave Request</span>
              <form method="post" action="<?= base_url('employee/leave_apply_submit') ?>">
                <div class="row">
                  <div class="col-md-6 mb-4">
                          <label class="font-weight-bold small text-muted">Leave Type</label>

                          <select name="leave_type" id="leave_type" class="form-control form-control-bloom">
                      <option value="">Select Type</option>

                     <?php foreach ($leavetype as $type): ?>

                    <?php
                    $empGender = strtoupper(trim($employeeGender));
                    $leaveGender = strtoupper(trim($type['gender_applicable']));

                    // Normalize employee gender
                    if ($empGender == 'M') $empGender = 'MALE';
                    if ($empGender == 'F') $empGender = 'FEMALE';

                    // Normalize leave gender
                    if ($leaveGender == 'M') $leaveGender = 'MALE';
                    if ($leaveGender == 'F') $leaveGender = 'FEMALE';

                    // Hide female-only leave for male employees
                    if ($empGender == 'MALE' && $leaveGender == 'FEMALE') {
                        continue;
                    }
                    ?>

                    <option value="<?= $type['leave_code'] ?>">
                        <?= esc($type['leave_name']) ?>
                    </option>

                <?php endforeach; ?>
                  </select>
                        </div>
                <div class="col-md-6 mb-4">
                    <label class="font-weight-bold small text-muted">Leave Balance(Days)</label>
                    <input type="text"
                          id="leave_balance"
                          class="form-control form-control-bloom bg-white"
                          readonly
                          placeholder="Available Balance">
                </div>
                </div>
                <div class="row">
                <div class="col-md-4 mb-4">
                    <label class="font-weight-bold small text-muted">From Date</label>
                  <div class="input-group">
                    <input type="text"
                          name="from_date"
                          id="from_date"
                          class="form-control form-control-bloom bg-white"
                          placeholder="Select Date"
                          readonly>

                    <div class="input-group-append">
                        <span class="input-group-text bg-white" id="fromDateIcon" style="cursor:pointer;">
                            <i class="fas fa-calendar-alt"></i>
                        </span>
                    </div>
                </div>
                </div>

                <div class="col-md-4 mb-4">
                    <label class="font-weight-bold small text-muted">To Date</label>
                   <div class="input-group">
                    <input type="text"
                          name="to_date"
                          id="to_date"
                          class="form-control form-control-bloom bg-white"
                          placeholder="Select Date"
                          readonly>

                    <div class="input-group-append">
                        <span class="input-group-text bg-white" id="toDateIcon" style="cursor:pointer;">
                            <i class="fas fa-calendar-alt"></i>
                        </span>
                    </div>
                </div>
                </div>

                              <div class="col-md-4 mb-4">
                                <label class="font-weight-bold small text-muted">
                                    Total Leave Days
                                </label>
                                <input type="text"
                                    id="total_days"
                                    class="form-control form-control-bloom"
                                    readonly
                                    placeholder="0 Days"
                                    style="background-color:#ffffff !important; color:#000000 !important; opacity:1;">
                              </div>
                 </div>
                
                <div class="mb-4"><label class="font-weight-bold small text-muted">Reason</label><textarea
                   name="reason" class="form-control form-control-bloom" rows="4" placeholder="Description..."></textarea></div>
                <div class="d-flex align-items-center justify-content-between mt-2">
                  <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="urgentCheck">
                  </div>
                  <div class="d-flex" style="gap: 10px;">
                    <a href="<?= base_url('employee/leave_history') ?>"
                    class="btn btn-view-history">

                      <i class="fas fa-history mr-1"></i>
                      View History

                  </a>
                    <button type="submit" id="submitBtn" class="btn btn-apply">Submit Application</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
          <div class="col-lg-4 mb-4">
            <div class="info-card bg-white p-4 h-100" style="border-radius:24px; border: 1px solid #e2e8f0;">
              <div class="d-flex justify-content-between align-items-center">
                <span class="section-head">Leave Available</span>
            </div>
              <div class="mt-4">
                
                  <?php
                  $personalUsed = (float)($leave['Personal_leaves_used'] ?? 0);
                  $personalBal  = (float)($leave['Personal_leaves_bal'] ?? 0);
                  $personalTotal = (float)($leave['Personal_leaves_total'] ?? ($personalUsed + $personalBal));
                  if ($personalTotal <= 0) $personalTotal = $personalUsed + $personalBal;
                  $personalPct = ($personalTotal > 0) ? min(100, round(($personalBal / $personalTotal) * 100)) : 0;
                  ?>

               <div class="mb-4">
              <div class="d-flex justify-content-between align-items-center mb-1">
                  <h6 class="mb-0 font-weight-bold" style="font-size:13px;">Personal Leave</h6>
                  <span class="small font-weight-bold text-muted">
                      <?= (int)$personalBal ?> Available / <?= (int)$personalTotal ?> Days Total
                  </span>
              </div>
                   <div class="progress shadow-sm" style="height:8px;border-radius:10px;background:#f1f5f9;">
                        <div class="progress-bar"
                            style="width:<?= $personalPct ?>%;background:#0ea5e9;border-radius:10px;">
                        </div>
                    </div>
                    <small class="text-muted d-block mt-1" style="font-size:11px;"><?= (int)$personalUsed ?> day(s) used</small>
                </div>

                      <?php if ($original_role != 'INTERN') : ?>

                      <?php
                      $sickUsed  = (float)($leave['sick_leaves_used'] ?? 0);
                      $sickBal   = (float)($leave['sick_leavs_bal'] ?? 0);
                      $sickTotal = (float)($leave['sick_leaves_total'] ?? ($sickUsed + $sickBal));
                      if ($sickTotal <= 0) $sickTotal = $sickUsed + $sickBal;
                      $sickPct   = ($sickTotal > 0) ? min(100, round(($sickBal / $sickTotal) * 100)) : 0;
                      ?>

                      <div class="mb-4">
                          <div class="d-flex justify-content-between align-items-center mb-1">
                              <h6 class="mb-0 font-weight-bold" style="font-size:13px;">Sick Leave</h6>
                              <span class="small font-weight-bold text-muted">
                                  <?= (int)$sickBal ?> Available / <?= (int)$sickTotal ?> Days Total
                              </span>
                          </div>

                          <div class="progress shadow-sm" style="height:8px;border-radius:10px;background:#f1f5f9;">
                              <div class="progress-bar"
                                  style="width:<?= $sickPct ?>%;background:var(--bloom-success);border-radius:10px;">
                              </div>
                          </div>
                          <small class="text-muted d-block mt-1" style="font-size:11px;"><?= (int)$sickUsed ?> day(s) used</small>
                      </div>
                   <?php if (!in_array(strtoupper(trim($employeeGender)), ['M', 'MALE'])) : ?>
                      <?php
                      $matUsed  = (float)($leave['maternity_used'] ?? 0);
                      $matBal   = (float)($leave['maternity_bal'] ?? 0);
                      $matTotal = (float)($leave['maternity_total'] ?? ($matUsed + $matBal));
                      if ($matTotal <= 0) $matTotal = $matUsed + $matBal;
                      $matPct   = ($matTotal > 0) ? min(100, round(($matBal / $matTotal) * 100)) : 0;
                      ?>

                      <div class="mb-4">
                          <div class="d-flex justify-content-between align-items-center mb-1">
                              <h6 class="mb-0 font-weight-bold" style="font-size:13px;">Maternity Leave</h6>
                              <span class="small font-weight-bold text-muted">
                                 <?= (int)$matBal ?> Available / <?= (int)$matTotal ?> Days Total
                              </span>
                          </div>

                          <div class="progress shadow-sm" style="height:8px;border-radius:10px;background:#f1f5f9;">
                              <div class="progress-bar"
                                  style="width:<?= $matPct ?>%;background:#f59e0b;border-radius:10px;">
                              </div>
                          </div>
                          <small class="text-muted d-block mt-1" style="font-size:11px;"><?= (int)$matUsed ?> day(s) used</small>
                      </div>
               <?php endif; ?>
                  <?php endif; ?>
                    <?php
                    $lopUsed = (float)($leave['lop_used'] ?? 0);
                    ?>

                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="mb-0 font-weight-bold" style="font-size:13px;">LOP</h6>
                            <span class="badge badge-danger px-3 py-2">
                                <?= $lopUsed ?> Day<?= ($lopUsed != 1) ? 's' : '' ?>
                            </span>
                        </div>
                    </div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>

  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

  <div id="toastMessage" style="
  position: fixed;
  top: 20px;
  right: 20px;
  z-index: 99999;
  display: none;
  background: #28a745;
  color: #fff;
  padding: 12px 18px;
  border-radius: 8px;
  font-size: 13px;
  box-shadow: 0 4px 10px rgba(0,0,0,0.2);
">
</div>
  
<script>
const holidays = <?= json_encode($holiday); ?>;

const holidayMap = {};

holidays.forEach(h => {
    holidayMap[h.holiday_date] = h.holiday_type;
});

const today = new Date().toISOString().split('T')[0];

// FROM DATE
const fromPicker = flatpickr("#from_date", {
    dateFormat: "Y-m-d",      // Value sent to PHP/DB
    altInput: true,
    altFormat: "d-m-Y",       // Displayed to the user
    clickOpens: true,
    onDayCreate: function(_, __, fp, dayElem) {

        const date = fp.formatDate(dayElem.dateObj, "Y-m-d");
        const day = dayElem.dateObj.getDay();

        if (date === today) dayElem.style.background = "#ffe066";

        if (day === 0) dayElem.classList.add("sunday-day");

        if (holidayMap[date]) {
            dayElem.style.background = "#ef4444";
            dayElem.style.color = "#fff";
        }
    }
});

document.getElementById("fromDateIcon").onclick = function () {
    fromPicker.open();
};

// TO DATE
const toPicker = flatpickr("#to_date", {
    dateFormat: "Y-m-d",      // Value sent to PHP/DB
    altInput: true,
    altFormat: "d-m-Y",       // Displayed to the user
    clickOpens: true,
    onDayCreate: function(_, __, fp, dayElem) {

        const date = fp.formatDate(dayElem.dateObj, "Y-m-d");
        const day = dayElem.dateObj.getDay();

        if (date === today) dayElem.style.background = "#ffe066";

        if (day === 0) dayElem.classList.add("sunday-day");

        if (holidayMap[date]) {
            dayElem.style.background = "#ef4444";
            dayElem.style.color = "#fff";
        }
    }
});

document.getElementById("toDateIcon").onclick = function () {
    toPicker.open();
};
</script>

<?php if (session()->getFlashdata('status')) : ?>
<script>
  const toast = document.getElementById("toastMessage");
  
  // Fetch status and remarks from session
  const status = "<?= session()->getFlashdata('status'); ?>";
  const remarks = "<?= session()->getFlashdata('remarks'); ?>";
  
  // Apply text to the toast
  toast.innerText = remarks;
  
  // Set background color based on status
  if (status === "Y") {
      toast.style.background = "#10b981"; // Success Green
  } else if (status === "N") {
      toast.style.background = "#ef4444"; // Error Red
  } else {
      toast.style.background = "#3b82f6"; // Default Blue just in case
  }

  // Display the toast
  toast.style.display = "block";

  // Hide after 3 seconds
  setTimeout(() => {
    toast.style.display = "none";
  }, 3000);
</script>
<?php endif; ?>

<script>
function calculateLeaveDays() {

    let fromDate = document.getElementById('from_date').value;
    let toDate   = document.getElementById('to_date').value;

    if (fromDate && toDate) {

        let start = new Date(fromDate);
        let end   = new Date(toDate);

        // Validation for backwards dates
        if (end < start) {
            document.getElementById('total_days').value = 'Invalid Date Range';
            return;
        }

        let workingDays = 0;
        let currentDate = new Date(start);

        // Iterate through each date from start to end
        while (currentDate <= end) {
            let dayOfWeek = currentDate.getDay();
            
            // Format currentDate to match DB holiday 'YYYY-MM-DD'
            let yyyy = currentDate.getFullYear();
            let mm = String(currentDate.getMonth() + 1).padStart(2, '0');
            let dd = String(currentDate.getDate()).padStart(2, '0');
            let formattedDate = `${yyyy}-${mm}-${dd}`;

            // Check if it's NOT Sunday (0) AND NOT a holiday in the map
            if (dayOfWeek !== 0 && !holidayMap[formattedDate]) {
                workingDays++;
            }

            // Move to the next day
            currentDate.setDate(currentDate.getDate() + 1);
        }

        document.getElementById('total_days').value = workingDays + ' Day(s)';
    }
}

document.getElementById('from_date').addEventListener('change', calculateLeaveDays);
document.getElementById('to_date').addEventListener('change', calculateLeaveDays);
</script>
<script>
const leaveBalances = {
    PL: <?= $leave['Personal_leaves_bal'] ?? 0 ?>,
    SL: <?= $leave['sick_leavs_bal'] ?? 0 ?>,
    ML: <?= $leave['maternity_bal'] ?? 0 ?>,
    LOP: <?= $leave['lop_bal'] ?? 0 ?>,
    WFH: 'N/A'
};

$('#leave_type').on('change', function() {

    let leaveType = $(this).val();
    let balance = leaveBalances[leaveType];

    if (balance !== undefined) {
        $('#leave_balance').val(balance + ' Days');
    } else {
        $('#leave_balance').val('');
    }

    // Disable only for PL and SL when balance is 0
    if (
        (leaveType === 'PL' && parseFloat(balance) <= 0) ||
        (leaveType === 'SL' && parseFloat(balance) <= 0)
    ) {
        $('#submitBtn').prop('disabled', true);
    } else {
        $('#submitBtn').prop('disabled', false);
    }

});
</script>
</body>

</html>