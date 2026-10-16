<div class="content-wrapper" style="min-height: 800px; padding: 20px 24px;">
  
  <!-- Breadcrumb -->
  <div class="content-header p-0 mb-3">
    <div class="container-fluid p-0">
      <div class="row align-items-center">
        <div class="col-sm-7">
          <div class="d-flex align-items-center">
            <a href="<?= base_url('admin/payroll/runs') ?>" class="btn btn-sm btn-light border mr-3" title="Back to Runs">
              <i class="fas fa-arrow-left"></i>
            </a>
            <div>
              <h1 class="m-0 text-dark font-weight-bold" style="font-size: 22px; letter-spacing: -0.02em;">
                Run #<?= $run['payroll_run_id'] ?> &mdash; <?= date('F Y', mktime(0, 0, 0, $run['payroll_month'], 10, $run['payroll_year'])) ?>
                <?php 
                  $st = $run['payroll_status'];
                  $badgeCls = ($st === 'FINALIZED') ? 'badge-success' : (($st === 'APPROVED') ? 'badge-info' : 'badge-warning text-dark');
                ?>
                <span class="badge <?= $badgeCls ?> ml-2 px-2 py-1 font-weight-bold" style="font-size: 13px;">
                  <?= $st ?>
                </span>
              </h1>
              <p class="text-muted small mb-0 mt-1">
                Period: <strong><?= date('d M Y', strtotime($run['period_start'])) ?></strong> to <strong><?= date('d M Y', strtotime($run['period_end'])) ?></strong> | Basis: <strong><?= $run['salary_day_basis'] ?></strong>
              </p>
            </div>
          </div>
        </div>
        <div class="col-sm-5 text-right">
          <div class="btn-group">
            <a href="<?= base_url('admin/payroll/export_bank_csv/' . $run['payroll_run_id']) ?>" class="btn btn-outline-secondary btn-sm shadow-sm font-weight-bold px-3">
              <i class="fas fa-file-csv mr-1"></i> Bank CSV
            </a>
            <a href="<?= base_url('admin/payroll/export_register_csv/' . $run['payroll_run_id']) ?>" class="btn btn-outline-secondary btn-sm shadow-sm font-weight-bold px-3">
              <i class="fas fa-file-excel mr-1"></i> Full Register
            </a>
            <?php if ($run['payroll_status'] === 'FINALIZED'): ?>
              <a href="<?= base_url('admin/payroll/payslips?run_id=' . $run['payroll_run_id']) ?>" class="btn btn-success btn-sm shadow-sm font-weight-bold px-3">
                <i class="fas fa-file-invoice mr-1"></i> Payslips
              </a>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?= view('admin/payroll/payroll_nav') ?>

  <!-- Flash Messages -->
  <?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert" style="border-radius: 10px;">
      <i class="fas fa-check-circle mr-2"></i> <?= session()->getFlashdata('success') ?>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    </div>
  <?php endif; ?>

  <?php if (session()->getFlashdata('warning')): ?>
    <div class="alert alert-warning alert-dismissible fade show border-0 shadow-sm" role="alert" style="border-radius: 10px;">
      <i class="fas fa-exclamation-circle mr-2"></i> <?= session()->getFlashdata('warning') ?>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    </div>
  <?php endif; ?>

  <?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert" style="border-radius: 10px;">
      <i class="fas fa-exclamation-triangle mr-2"></i> <?= session()->getFlashdata('error') ?>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    </div>
  <?php endif; ?>

  <!-- Workflow Stepper Card -->
  <div class="card border-0 shadow-sm mb-4" style="border-radius: 14px; background: #ffffff;">
    <div class="card-body p-3">
      <div class="d-flex align-items-center justify-content-between flex-wrap" style="gap: 12px;">
        <!-- Step 1: Attendance Ingestion -->
        <div class="d-flex align-items-center">
          <div class="rounded-circle d-flex align-items-center justify-content-center text-white mr-2" style="width: 32px; height: 32px; background: #10b981; font-weight: bold; font-size: 13px;">
            <i class="fas fa-check"></i>
          </div>
          <div>
            <div class="font-weight-bold text-dark small">1. Attendance Summary</div>
            <a href="<?= base_url('admin/payroll_attendance?month=' . $run['payroll_month'] . '&year=' . $run['payroll_year']) ?>" class="small text-primary">View Ingestion &rarr;</a>
          </div>
        </div>

        <i class="fas fa-chevron-right text-muted d-none d-md-block"></i>

        <!-- Step 2: Salary Calculation -->
        <div class="d-flex align-items-center">
          <div class="rounded-circle d-flex align-items-center justify-content-center text-white mr-2" style="width: 32px; height: 32px; background: #10b981; font-weight: bold; font-size: 13px;">
            <i class="fas fa-check"></i>
          </div>
          <div>
            <div class="font-weight-bold text-dark small">2. Salary Calculation</div>
            <span class="text-success small font-weight-bold"><?= count($employees) ?> Employees Calculated</span>
          </div>
        </div>

        <i class="fas fa-chevron-right text-muted d-none d-md-block"></i>

        <!-- Step 3: Audit & Validation -->
        <div class="d-flex align-items-center">
          <?php $valReady = !empty($validation['metrics']['is_ready_for_approval']); ?>
          <div class="rounded-circle d-flex align-items-center justify-content-center text-white mr-2" style="width: 32px; height: 32px; background: <?= $valReady ? '#10b981' : '#f59e0b' ?>; font-weight: bold; font-size: 13px;">
            <i class="fas <?= $valReady ? 'fa-check' : 'fa-exclamation' ?>"></i>
          </div>
          <div>
            <div class="font-weight-bold text-dark small">3. Audit & Validation</div>
            <span class="small <?= $valReady ? 'text-success' : 'text-warning' ?> font-weight-bold">
              <?= $valReady ? '0 Errors &bull; Verified' : 'Exceptions Found' ?>
            </span>
          </div>
        </div>

        <i class="fas fa-chevron-right text-muted d-none d-md-block"></i>

        <!-- Step 4: Approval & Finalization -->
        <div class="d-flex align-items-center">
          <?php $isFin = ($run['payroll_status'] === 'FINALIZED'); ?>
          <div class="rounded-circle d-flex align-items-center justify-content-center text-white mr-2" style="width: 32px; height: 32px; background: <?= $isFin ? '#10b981' : '#64748b' ?>; font-weight: bold; font-size: 13px;">
            <i class="fas <?= $isFin ? 'fa-lock' : 'fa-lock-open' ?>"></i>
          </div>
          <div>
            <div class="font-weight-bold text-dark small">4. Finalization & Lock</div>
            <span class="small font-weight-bold text-muted"><?= $isFin ? 'Period Locked' : 'Pending Approval' ?></span>
          </div>
        </div>

        <!-- Workflow Action Controls -->
        <div class="ml-auto d-flex align-items-center" style="gap: 8px;">
          <?php if ($run['payroll_status'] !== 'FINALIZED'): ?>
            <a href="<?= base_url('admin/payroll/calculate_run/' . $run['payroll_run_id']) ?>" class="btn btn-outline-primary btn-sm font-weight-bold shadow-sm" onclick="return confirm('Recalculate salary for all active employees?');">
              <i class="fas fa-sync-alt mr-1"></i> Recalculate Run
            </a>

            <?php if ($run['payroll_status'] === 'CALCULATED'): ?>
              <form method="post" action="<?= base_url('admin/payroll/approve_run/' . $run['payroll_run_id']) ?>" class="d-inline">
                <button type="submit" class="btn btn-info btn-sm font-weight-bold shadow-sm">
                  <i class="fas fa-check-circle mr-1"></i> Approve Run
                </button>
              </form>
            <?php endif; ?>

            <?php if (in_array($run['payroll_status'], ['APPROVED', 'CALCULATED'])): ?>
              <form method="post" action="<?= base_url('admin/payroll/finalize_run/' . $run['payroll_run_id']) ?>" class="d-inline">
                <button type="submit" class="btn btn-success btn-sm font-weight-bold shadow-sm" onclick="return confirm('Lock this payroll run permanently and generate immutable payslips?');">
                  <i class="fas fa-lock mr-1"></i> Finalize & Generate Payslips
                </button>
              </form>
            <?php endif; ?>
          <?php else: ?>
            <button type="button" class="btn btn-outline-danger btn-sm font-weight-bold shadow-sm" data-toggle="modal" data-target="#reopenModal">
              <i class="fas fa-unlock mr-1"></i> Reopen for Corrections
            </button>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>

  <!-- Run Financial Totals Cards -->
  <?php $m = $validation['metrics'] ?? null; ?>
  <div class="row mb-4">
    <div class="col-md-2 col-sm-4 mb-2">
      <div class="p-3 bg-white shadow-sm" style="border-radius: 12px; border: 1px solid #e2e8f0;">
        <span class="text-uppercase text-muted font-weight-bold small" style="font-size: 11px;">Staff Processed</span>
        <h4 class="font-weight-bold text-dark mt-1 mb-0"><?= number_format($m['total_employees'] ?? count($employees)) ?></h4>
      </div>
    </div>
    <div class="col-md-2 col-sm-4 mb-2">
      <div class="p-3 bg-white shadow-sm" style="border-radius: 12px; border: 1px solid #e2e8f0;">
        <span class="text-uppercase text-muted font-weight-bold small" style="font-size: 11px;">Total Monthly CTC</span>
        <h4 class="font-weight-bold text-dark mt-1 mb-0">₹<?= number_format((float)($m['total_monthly_ctc'] ?? 0), 2) ?></h4>
      </div>
    </div>
    <div class="col-md-2 col-sm-4 mb-2">
      <div class="p-3 bg-white shadow-sm" style="border-radius: 12px; border: 1px solid #e2e8f0;">
        <span class="text-uppercase text-muted font-weight-bold small" style="font-size: 11px;">Gross Earnings</span>
        <h4 class="font-weight-bold text-primary mt-1 mb-0">₹<?= number_format((float)($m['total_gross_earnings'] ?? 0), 2) ?></h4>
      </div>
    </div>
    <div class="col-md-2 col-sm-4 mb-2">
      <div class="p-3 bg-white shadow-sm" style="border-radius: 12px; border: 1px solid #e2e8f0;">
        <span class="text-uppercase text-muted font-weight-bold small" style="font-size: 11px;">LOP Deductions</span>
        <h4 class="font-weight-bold text-danger mt-1 mb-0">-₹<?= number_format((float)($m['total_lop_deductions'] ?? 0), 2) ?></h4>
      </div>
    </div>
    <div class="col-md-2 col-sm-4 mb-2">
      <div class="p-3 bg-white shadow-sm" style="border-radius: 12px; border: 1px solid #e2e8f0;">
        <span class="text-uppercase text-muted font-weight-bold small" style="font-size: 11px;">Statutory Deductions</span>
        <h4 class="font-weight-bold text-danger mt-1 mb-0">-₹<?= number_format((float)($m['total_employee_deductions'] ?? 0), 2) ?></h4>
      </div>
    </div>
    <div class="col-md-2 col-sm-4 mb-2">
      <div class="p-3 bg-white shadow-sm" style="border-radius: 12px; border: 1px solid #e2e8f0; background: #ecfdf5 !important;">
        <span class="text-uppercase text-success font-weight-bold small" style="font-size: 11px;">Total Net Payout</span>
        <h4 class="font-weight-bold text-success mt-1 mb-0">₹<?= number_format((float)($m['total_net_salary'] ?? 0), 2) ?></h4>
      </div>
    </div>
  </div>

  <!-- Employee Compensation Register Table -->
  <div class="card border-0 shadow-sm" style="border-radius: 14px; background: #ffffff;">
    <div class="card-header bg-transparent border-0 pt-3 pb-2 d-flex justify-content-between align-items-center flex-wrap" style="gap: 10px;">
      <div>
        <h5 class="font-weight-bold text-dark mb-0" style="font-size: 16px;">
          <i class="fas fa-users-cog mr-2 text-primary"></i> Employee Salary Calculation Register
        </h5>
        <small class="text-muted">Calculated component-by-component with LOP proration.</small>
      </div>

      <!-- Search & Filters -->
      <form method="get" action="<?= base_url('admin/payroll/run/' . $run['payroll_run_id']) ?>" class="form-inline">
        <input type="text" name="search" class="form-control form-control-sm mr-2" placeholder="Search ID or Name..." value="<?= esc($search) ?>" style="border-radius: 6px; width: 180px;">
        <select name="status" class="form-control form-control-sm mr-2" style="border-radius: 6px;">
          <option value="">All Statuses</option>
          <option value="CALCULATED" <?= ($status === 'CALCULATED') ? 'selected' : '' ?>>Calculated</option>
          <option value="ERROR" <?= ($status === 'ERROR') ? 'selected' : '' ?>>Errors</option>
        </select>
        <button type="submit" class="btn btn-sm btn-primary px-3" style="border-radius: 6px;">Filter</button>
        <?php if ($search || $status): ?>
          <a href="<?= base_url('admin/payroll/run/' . $run['payroll_run_id']) ?>" class="btn btn-sm btn-light border ml-1" style="border-radius: 6px;">Clear</a>
        <?php endif; ?>
      </form>
    </div>

    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0 text-nowrap" style="font-size: 13px;">
          <thead style="background: #f8fafc; color: #475569; font-weight: 600;">
            <tr>
              <th class="pl-4">Employee</th>
              <th>Department</th>
              <th>Fixed Monthly CTC</th>
              <th>Attendance Days</th>
              <th>LOP Days</th>
              <th>Gross Earnings</th>
              <th>LOP Loss</th>
              <th>Other Deductions</th>
              <th>Net Salary</th>
              <th>Calculation Status</th>
              <th class="text-right pr-4">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($employees)): ?>
              <tr>
                <td colspan="11" class="text-center py-4 text-muted">
                  No employee records found matching your filters.
                </td>
              </tr>
            <?php else: ?>
              <?php foreach ($employees as $e): ?>
                <tr>
                  <td class="pl-4">
                    <span class="font-weight-bold text-dark"><?= esc($e['emp_name']) ?></span>
                    <small class="d-block text-muted font-weight-bold"><?= esc($e['emp_id']) ?></small>
                  </td>
                  <td>
                    <span class="badge badge-light border text-dark font-weight-normal"><?= esc($e['department_name'] ?? 'General') ?></span>
                    <small class="d-block text-muted"><?= esc($e['designation_name'] ?? '') ?></small>
                  </td>
                  <td class="font-weight-bold text-dark">
                    ₹<?= number_format((float)$e['monthly_ctc'], 2) ?>
                  </td>
                  <td>
                    <span class="badge badge-light border">
                      <strong><?= (float)$e['paid_days'] ?></strong> / <?= (float)$e['total_days'] ?> Days
                    </span>
                  </td>
                  <td>
                    <?php if ((float)$e['lop_days'] > 0): ?>
                      <span class="badge badge-danger px-2 font-weight-bold">
                        <?= (float)$e['lop_days'] ?> Days
                      </span>
                    <?php else: ?>
                      <span class="text-muted">0</span>
                    <?php endif; ?>
                  </td>
                  <td class="text-dark font-weight-bold">
                    ₹<?= number_format((float)$e['gross_earnings'], 2) ?>
                  </td>
                  <td class="text-danger font-weight-bold">
                    -₹<?= number_format((float)$e['lop_deduction'], 2) ?>
                  </td>
                  <td class="text-danger">
                    -₹<?= number_format((float)$e['other_deductions'], 2) ?>
                  </td>
                  <td class="text-success font-weight-bold" style="font-size: 14px;">
                    ₹<?= number_format((float)$e['net_salary'], 2) ?>
                  </td>
                  <td>
                    <?php if ($e['calculation_status'] === 'CALCULATED'): ?>
                      <span class="badge badge-success px-2 py-1 font-weight-normal">
                        <i class="fas fa-check mr-1"></i> Success
                      </span>
                    <?php else: ?>
                      <span class="badge badge-danger px-2 py-1 font-weight-bold" title="<?= esc($e['calculation_message']) ?>">
                        <i class="fas fa-times mr-1"></i> Error
                      </span>
                    <?php endif; ?>
                  </td>
                  <td class="text-right pr-4">
                    <button type="button" class="btn btn-sm btn-outline-primary px-2 py-1 btn-view-components mr-1" 
                            data-id="<?= $e['payroll_employee_id'] ?>" 
                            data-emp="<?= esc($e['emp_id']) ?>" 
                            data-name="<?= esc($e['emp_name']) ?>"
                            data-gross="₹<?= number_format((float)$e['gross_earnings'], 2) ?>"
                            data-lop="₹<?= number_format((float)$e['lop_deduction'], 2) ?>"
                            data-ded="₹<?= number_format((float)$e['other_deductions'], 2) ?>"
                            data-net="₹<?= number_format((float)$e['net_salary'], 2) ?>"
                            title="View Component Breakdown">
                      <i class="fas fa-layer-group"></i> Components
                    </button>
                    <?php if ($run['payroll_status'] === 'FINALIZED'): ?>
                      <a href="<?= base_url('admin/payroll/payslip/' . $run['payroll_run_id'] . '/' . $e['emp_id']) ?>" target="_blank" class="btn btn-sm btn-outline-success px-2 py-1 font-weight-bold" title="Digital Payslip">
                        <i class="fas fa-file-invoice"></i> Payslip
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

<!-- Modal: Employee Component Breakdown Details -->
<div class="modal fade" id="componentsModal" tabindex="-1" role="dialog" aria-labelledby="componentsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content border-0 shadow" style="border-radius: 14px;">
      <div class="modal-header border-0 pb-0">
        <div>
          <h5 class="modal-title font-weight-bold text-dark" id="modalEmpName">Component Breakdown</h5>
          <small class="text-muted" id="modalEmpId">BS00001</small>
        </div>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body py-3">
        <!-- Totals Strip -->
        <div class="d-flex justify-content-between p-2 mb-3 bg-light rounded" style="font-size: 13px;">
          <div>Gross: <strong id="modalGross" class="text-dark">₹0</strong></div>
          <div>LOP Deduction: <strong id="modalLop" class="text-danger">₹0</strong></div>
          <div>Deductions: <strong id="modalDed" class="text-danger">₹0</strong></div>
          <div>Net Salary: <strong id="modalNet" class="text-success" style="font-size: 14px;">₹0</strong></div>
        </div>

        <div class="table-responsive">
          <table class="table table-sm table-bordered text-nowrap" style="font-size: 13px;">
            <thead class="bg-light">
              <tr>
                <th>Type</th>
                <th>Component Code</th>
                <th>Component Name</th>
                <th class="text-right">Monthly Fixed</th>
                <th class="text-right">LOP Deduction</th>
                <th class="text-right font-weight-bold">Payable Amount</th>
              </tr>
            </thead>
            <tbody id="componentsTableBody">
              <tr>
                <td colspan="6" class="text-center py-3 text-muted">Loading components...</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer border-0 pt-0">
        <button type="button" class="btn btn-light border px-4" data-dismiss="modal" style="border-radius: 8px;">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal: Reopen Run -->
<div class="modal fade" id="reopenModal" tabindex="-1" role="dialog" aria-labelledby="reopenModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content border-0 shadow" style="border-radius: 14px;">
      <form method="post" action="<?= base_url('admin/payroll/reopen_run/' . $run['payroll_run_id']) ?>">
        <div class="modal-header border-0 pb-0">
          <h5 class="modal-title font-weight-bold text-dark" id="reopenModalLabel">
            <i class="fas fa-unlock text-warning mr-2"></i> Reopen Finalized Payroll Run
          </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body py-3">
          <div class="alert alert-warning small border-0 mb-3" style="border-radius: 8px;">
            <i class="fas fa-exclamation-triangle mr-1"></i> Reopening this run will unlock calculations and mark existing payslips as <strong>VOID</strong> until recalculated and refinalized.
          </div>
          <div class="form-group">
            <label class="font-weight-bold text-dark small">Reason for Reopening</label>
            <textarea name="reason" class="form-control" rows="3" required placeholder="Describe adjustment or error..." style="border-radius: 8px;"></textarea>
          </div>
        </div>
        <div class="modal-footer border-0 pt-0">
          <button type="button" class="btn btn-light border px-4" data-dismiss="modal" style="border-radius: 8px;">Cancel</button>
          <button type="submit" class="btn btn-danger px-4 font-weight-bold shadow-sm" style="border-radius: 8px;">Reopen Run</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  $('.btn-view-components').on('click', function() {
    var peId  = $(this).data('id');
    var empId = $(this).data('emp');
    var name  = $(this).data('name');
    var gross = $(this).data('gross');
    var lop   = $(this).data('lop');
    var ded   = $(this).data('ded');
    var net   = $(this).data('net');

    $('#modalEmpName').text(name);
    $('#modalEmpId').text(empId);
    $('#modalGross').text(gross);
    $('#modalLop').text(lop);
    $('#modalDed').text(ded);
    $('#modalNet').text(net);

    $('#componentsTableBody').html('<tr><td colspan="6" class="text-center py-3 text-muted"><i class="fas fa-spinner fa-spin mr-1"></i> Loading components...</td></tr>');
    $('#componentsModal').modal('show');

    $.ajax({
      url: '<?= base_url("admin/payroll/get_employee_run_components_ajax") ?>',
      type: 'POST',
      data: { payroll_employee_id: peId },
      dataType: 'json',
      success: function(resp) {
        if (resp.status === 'SUCCESS' && resp.components.length > 0) {
          var html = '';
          resp.components.forEach(function(c) {
            var typeBadge = (c.component_type === 'EARNING') ? '<span class="badge badge-success">Earning</span>' :
                            ((c.component_type === 'DEDUCTION') ? '<span class="badge badge-danger">Deduction</span>' :
                            '<span class="badge badge-info">Employer Contrib</span>');
            html += '<tr>' +
              '<td>' + typeBadge + '</td>' +
              '<td><code>' + c.component_code + '</code></td>' +
              '<td>' + c.component_name + '</td>' +
              '<td class="text-right">₹' + parseFloat(c.monthly_amount).toFixed(2) + '</td>' +
              '<td class="text-right text-danger">' + (parseFloat(c.lop_amount) > 0 ? '-₹' + parseFloat(c.lop_amount).toFixed(2) : '0.00') + '</td>' +
              '<td class="text-right font-weight-bold text-dark">₹' + parseFloat(c.payable_amount).toFixed(2) + '</td>' +
              '</tr>';
          });
          $('#componentsTableBody').html(html);
        } else {
          $('#componentsTableBody').html('<tr><td colspan="6" class="text-center py-3 text-muted">No components recorded.</td></tr>');
        }
      },
      error: function() {
        $('#componentsTableBody').html('<tr><td colspan="6" class="text-center text-danger py-3">Failed to load components.</td></tr>');
      }
    });
  });
});
</script>
