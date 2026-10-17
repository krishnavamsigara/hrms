<div class="content-wrapper" style="min-height: 800px; padding: 20px 24px;">
  
  <div class="content-header p-0 mb-3">
    <div class="container-fluid p-0">
      <div class="row align-items-center">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark font-weight-bold" style="font-size: 24px; letter-spacing: -0.02em;">
            <i class="fas fa-cogs text-primary mr-2"></i> Payroll Processing & Runs Master
          </h1>
          <p class="text-muted small mb-0 mt-1">
            Manage monthly cycles, track workflow states (Draft &rarr; Calculated &rarr; Approved &rarr; Finalized).
          </p>
        </div>
        <div class="col-sm-6 text-right">
          <button type="button" class="btn btn-primary shadow-sm px-4 font-weight-bold" data-toggle="modal" data-target="#createRunModal" style="border-radius: 8px;">
            <i class="fas fa-plus-circle mr-1"></i> New Payroll Run
          </button>
        </div>
      </div>
    </div>
  </div>

  <?= view('admin/payroll/payroll_nav') ?>

  <?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert" style="border-radius: 10px;">
      <i class="fas fa-check-circle mr-2"></i> <?= session()->getFlashdata('success') ?>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
  <?php endif; ?>

  <?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert" style="border-radius: 10px;">
      <i class="fas fa-exclamation-triangle mr-2"></i> <?= session()->getFlashdata('error') ?>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
  <?php endif; ?>

  <div class="card border-0 shadow-sm" style="border-radius: 14px; background: #ffffff;">
    <div class="card-header bg-transparent border-0 pt-3 pb-2 d-flex justify-content-between align-items-center flex-wrap" style="gap: 10px;">
      <div>
        <h5 class="font-weight-bold text-dark mb-0" style="font-size: 16px;">
          <i class="fas fa-list-alt mr-2 text-primary"></i> All Payroll Cycles
        </h5>
        <small class="text-muted">Click <strong>"Open Workbench"</strong> to inspect 29+ component breakdowns, validate statutory rules, or finalize the period.</small>
      </div>
      <div>
        <input type="text" id="runsSearch" class="form-control form-control-sm" placeholder="Search cycle..." style="border-radius: 6px; width: 220px;">
      </div>
    </div>
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0 text-nowrap" id="runsTable" style="font-size: 13px;">
          <thead style="background: #f8fafc; color: #475569; font-weight: 600;">
            <tr>
              <th class="pl-4">Cycle</th>
              <th>Period Cutoff</th>
              <th>Calculation Rule</th>
              <th>Staff Count</th>
              <th>Gross Earnings</th>
              <th>LOP Loss</th>
              <th>Net Disbursed</th>
              <th>Workflow State</th>
              <th class="text-right pr-4">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($runs)): ?>
              <tr>
                <td colspan="9" class="text-center py-5 text-muted">
                  No payroll runs created yet. Click <strong>"New Payroll Run"</strong> to generate your first cycle.
                </td>
              </tr>
            <?php else: ?>
              <?php foreach ($runs as $r): ?>
                <tr>
                  <td class="pl-4 font-weight-bold text-dark">
                    <span class="text-primary font-weight-bold">#<?= $r['payroll_run_id'] ?></span> &mdash; 
                    <?= date('F Y', mktime(0, 0, 0, (int)$r['payroll_month'], 10, (int)$r['payroll_year'])) ?>
                  </td>
                  <td class="text-muted">
                    <i class="far fa-calendar-alt text-primary mr-1"></i>
                    <?= date('d M', strtotime($r['period_start'])) ?> to <?= date('d M Y', strtotime($r['period_end'])) ?>
                  </td>
                  <td>
                    <span class="badge badge-light border text-dark font-weight-normal"><?= esc($r['salary_day_basis']) ?></span>
                  </td>
                  <td class="font-weight-bold text-dark">
                    <?= number_format($r['total_employees']) ?> Staff
                  </td>
                  <td class="text-dark font-weight-bold">
                    ₹<?= number_format((float)$r['total_gross'], 2) ?>
                  </td>
                  <td class="text-danger font-weight-bold">
                    -₹<?= number_format((float)$r['total_lop_deductions'], 2) ?>
                  </td>
                  <td class="text-success font-weight-bold" style="font-size: 14px;">
                    ₹<?= number_format((float)$r['total_net_payout'], 2) ?>
                  </td>
                  <td>
                    <?php 
                      $st = $r['payroll_status'];
                      $cls = ($st === 'FINALIZED') ? 'badge-success' : (($st === 'APPROVED') ? 'badge-info' : 'badge-warning text-dark');
                    ?>
                    <span class="badge <?= $cls ?> px-2 py-1 font-weight-bold">
                      <i class="fas <?= ($st === 'FINALIZED') ? 'fa-lock' : 'fa-circle' ?> mr-1" style="font-size: 8px;"></i> <?= $st ?>
                    </span>
                  </td>
                  <td class="text-right pr-4">
                    <a href="<?= base_url('admin/payroll/run/' . $r['payroll_run_id']) ?>" class="btn btn-sm btn-primary px-3 shadow-sm font-weight-bold mr-1" style="border-radius: 6px;">
                      <i class="fas fa-wrench mr-1"></i> Open Workbench
                    </a>
                    <a href="<?= base_url('admin/payroll/export_register_csv/' . $r['payroll_run_id']) ?>" class="btn btn-sm btn-outline-success px-2 py-1 font-weight-bold mr-1" title="Download Excel (29 Reference Columns)">
                      <i class="fas fa-file-excel mr-1"></i> Excel
                    </a>
                    <?php if ($r['payroll_status'] === 'FINALIZED'): ?>
                      <a href="<?= base_url('admin/payroll/payslips?run_id=' . $r['payroll_run_id']) ?>" class="btn btn-sm btn-outline-info px-2 py-1 font-weight-bold" title="View Payslips">
                        <i class="fas fa-file-invoice"></i> Payslips
                      </a>
                    <?php endif; ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

</div>

<!-- Modal: Create & Calculate New Payroll Run -->
<div class="modal fade" id="createRunModal" tabindex="-1" role="dialog" aria-labelledby="createRunModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content border-0 shadow" style="border-radius: 14px;">
      <form method="post" action="<?= base_url('admin/payroll/create_run') ?>" id="formCreateRun">
        <?= csrf_field() ?>
        <div class="modal-header border-0 pb-0">
          <h5 class="modal-title font-weight-bold text-dark" id="createRunModalLabel">
            <i class="fas fa-play-circle text-primary mr-2"></i> Initiate Monthly Payroll Run
          </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body py-3">
          
          <div class="form-row">
            <div class="form-group col-md-6">
              <label class="font-weight-bold text-dark small">Payroll Month</label>
              <select name="payroll_month" id="modal_payroll_month" class="form-control font-weight-bold" required style="border-radius: 8px;">
                <?php for ($m = 1; $m <= 12; $m++): ?>
                  <option value="<?= $m ?>" <?= ($m == 10) ? 'selected' : '' ?>>
                    <?= date('F', mktime(0, 0, 0, $m, 10)) ?>
                  </option>
                <?php endfor; ?>
              </select>
            </div>
            <div class="form-group col-md-6">
              <label class="font-weight-bold text-dark small">Payroll Year</label>
              <select name="payroll_year" id="modal_payroll_year" class="form-control font-weight-bold" required style="border-radius: 8px;">
                <option value="2026" selected>2026</option>
                <option value="2025">2025</option>
                <option value="2024">2024</option>
              </select>
            </div>
          </div>

          <!-- Cutoff Period Display from Company Settings -->
          <div class="p-3 mb-3 bg-light rounded border" style="font-size: 13px;">
            <div class="d-flex justify-content-between align-items-center">
              <span class="text-muted"><i class="far fa-calendar-check text-primary mr-1"></i> Cutoff Period:</span>
              <strong class="text-dark font-weight-bold" id="lblPeriodRange">Loading cutoff...</strong>
            </div>
            <small class="text-muted d-block mt-1">Derived from Company Settings: Day <?= (int)($settings['payroll_cycle_start_day'] ?? 25) ?> to <?= (int)($settings['payroll_cycle_end_day'] ?? 24) ?>.</small>
          </div>

          <!-- Attendance Summary Validation Status -->
          <div class="form-group mb-3">
            <label class="font-weight-bold text-dark small mb-1">
              <i class="fas fa-fingerprint text-info mr-1"></i> Attendance Finalization Status:
            </label>
            <div id="attendanceStatusBox">
              <div class="p-2 bg-light text-muted small rounded"><i class="fas fa-spinner fa-spin mr-1"></i> Checking attendance status...</div>
            </div>
          </div>

          <div class="form-group mb-1">
            <label class="font-weight-bold text-dark small">Salary Calculation Basis</label>
            <select name="salary_day_basis" class="form-control" required style="border-radius: 8px;">
              <option value="FIXED_30" selected>Fixed 30-Day Basis (Standard company policy: ₹CTC / 30 * LOP)</option>
              <option value="CALENDAR_DAYS">Actual Calendar Days</option>
              <option value="WORKING_DAYS">Working Days</option>
            </select>
          </div>
        </div>

        <div class="modal-footer border-0 pt-0">
          <button type="button" class="btn btn-light border px-4" data-dismiss="modal" style="border-radius: 8px;">Cancel</button>
          <button type="submit" class="btn btn-primary px-4 font-weight-bold shadow-sm" id="btnSubmitRun" style="border-radius: 8px;">
            <i class="fas fa-calculator mr-1"></i> Calculate & Create Run
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function() {
  // Table search
  $('#runsSearch').on('keyup', function() {
    var val = $(this).val().toLowerCase();
    $('#runsTable tbody tr').filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(val) > -1);
    });
  });

  const attStatusMap = <?= json_encode($attStatusMap ?? []) ?>;
  const startDay = <?= (int)($settings['payroll_cycle_start_day'] ?? 25) ?>;
  const endDay   = <?= (int)($settings['payroll_cycle_end_day'] ?? 24) ?>;

  function updateModalPeriodAndAttendance() {
    const month = parseInt($('#modal_payroll_month').val()) || 10;
    const year  = parseInt($('#modal_payroll_year').val()) || 2026;

    // Period calculation
    let prevMonth = month - 1;
    let prevYear  = year;
    if (prevMonth === 0) {
      prevMonth = 12;
      prevYear  = year - 1;
    }

    const monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
    const periodStr = startDay + ' ' + monthNames[prevMonth - 1] + ' ' + prevYear + ' to ' + endDay + ' ' + monthNames[month - 1] + ' ' + year;
    $('#lblPeriodRange').text(periodStr);

    // Attendance status check
    const key = year + '-' + String(month).padStart(2, '0');
    const att = attStatusMap[key];

    const box = $('#attendanceStatusBox');
    const submitBtn = $('#btnSubmitRun');

    if (!att || !att.count) {
      box.html(`
        <div class="alert alert-danger py-2 px-3 small border-0 mb-0" style="border-radius: 8px;">
          <i class="fas fa-times-circle mr-1"></i> Attendance summary has <strong>not been generated</strong> for this period.
          <a href="<?= base_url('admin/payroll_attendance') ?>?month=${month}&year=${year}" class="btn btn-xs btn-outline-danger ml-2 font-weight-bold" target="_blank">Generate Attendance &rarr;</a>
        </div>
      `);
      submitBtn.prop('disabled', true).attr('title', 'Attendance must be generated and finalized first');
    } else if (!att.finalized) {
      box.html(`
        <div class="alert alert-warning py-2 px-3 small border-0 mb-0" style="border-radius: 8px; color: #854d0e; background: #fef9c3;">
          <i class="fas fa-exclamation-triangle mr-1"></i> Attendance exists (${att.count} staff) but is <strong>NOT finalized</strong>.
          <a href="<?= base_url('admin/payroll_attendance') ?>?month=${month}&year=${year}" class="btn btn-xs btn-warning ml-2 font-weight-bold text-dark" target="_blank">Finalize Attendance &rarr;</a>
        </div>
      `);
      submitBtn.prop('disabled', true).attr('title', 'Attendance must be finalized first');
    } else {
      box.html(`
        <div class="alert alert-success py-2 px-3 small border-0 mb-0" style="border-radius: 8px;">
          <i class="fas fa-check-circle mr-1"></i> Attendance is <strong>Finalized &amp; Locked</strong> for ${att.count} staff members. Ready to create cycle.
        </div>
      `);
      submitBtn.prop('disabled', false).removeAttr('title');
    }
  }

  $('#modal_payroll_month, #modal_payroll_year').on('change', updateModalPeriodAndAttendance);

  // Trigger on open
  $('#createRunModal').on('show.bs.modal', function() {
    updateModalPeriodAndAttendance();
  });

  // Submit UI feedback
  $('#formCreateRun').on('submit', function() {
    $('#btnSubmitRun').prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Calculating Cycle...');
  });

  updateModalPeriodAndAttendance();
});
</script>
