<style>
  /* Sticky 35-Column Workbench Table Grid */
  .wb-grid-wrapper {
    position: relative;
    max-height: 640px;
    overflow: auto;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    background: #ffffff;
  }
  .wb-grid-table {
    margin-bottom: 0;
    border-collapse: separate;
    border-spacing: 0;
    font-size: 12px;
    white-space: nowrap;
    width: 100%;
  }
  .wb-grid-table thead th {
    position: sticky;
    top: 0;
    z-index: 4;
    background: #f8fafc;
    color: #334155;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    padding: 10px 12px;
    border-bottom: 2px solid #cbd5e1;
    border-right: 1px solid #e2e8f0;
  }
  .wb-grid-table tbody td {
    padding: 8px 12px;
    border-bottom: 1px solid #f1f5f9;
    border-right: 1px solid #f1f5f9;
    vertical-align: middle;
  }
  .wb-grid-table tbody tr:hover td {
    background-color: #f8fafc;
  }

  /* Sticky Left Frozen Columns (#1 Emp ID, #2 Employee Name) */
  .wb-col-sticky-1 {
    position: sticky !important;
    left: 0;
    z-index: 5 !important;
    min-width: 95px;
    max-width: 110px;
    background: #ffffff;
    box-shadow: 2px 0 4px rgba(0,0,0,0.03);
  }
  thead .wb-col-sticky-1 {
    background: #f1f5f9 !important;
    z-index: 7 !important;
  }
  .wb-col-sticky-2 {
    position: sticky !important;
    left: 95px;
    z-index: 5 !important;
    min-width: 170px;
    max-width: 220px;
    background: #ffffff;
    box-shadow: 3px 0 5px rgba(0,0,0,0.04);
  }
  thead .wb-col-sticky-2 {
    background: #f1f5f9 !important;
    z-index: 7 !important;
  }

  /* Sticky Right Frozen Column (#30 Status / Action) */
  .wb-col-sticky-action {
    position: sticky !important;
    right: 0;
    z-index: 5 !important;
    min-width: 130px;
    background: #ffffff;
    box-shadow: -3px 0 5px rgba(0,0,0,0.04);
    text-align: right;
  }
  thead .wb-col-sticky-action {
    background: #f1f5f9 !important;
    z-index: 7 !important;
  }

  /* Header Group Colors */
  .th-identity { background: #f1f5f9 !important; color: #1e293b; }
  .th-contract { background: #eff6ff !important; color: #1d4ed8; }
  .th-attendance { background: #fef2f2 !important; color: #b91c1c; }
  .th-earnings { background: #f0fdf4 !important; color: #15803d; }
  .th-stat-emplr { background: #f8fafc !important; color: #475569; }
  .th-deductions { background: #fff1f2 !important; color: #be123c; }
  .th-netpay { background: #ecfdf5 !important; color: #047857; font-weight: 800 !important; }
  .th-banking { background: #f8fafc !important; color: #334155; }
</style>

<div class="content-wrapper" style="min-height: 800px; padding: 20px 24px;">
  
  <!-- Breadcrumb & Header -->
  <div class="content-header p-0 mb-3">
    <div class="container-fluid p-0">
      <div class="row align-items-center">
        <div class="col-sm-7">
          <div class="d-flex align-items-center">
            <a href="<?= base_url('admin/payroll/runs') ?>" class="btn btn-sm btn-light border mr-3" title="Back to Runs Directory">
              <i class="fas fa-arrow-left"></i>
            </a>
            <div>
              <h1 class="m-0 text-dark font-weight-bold" style="font-size: 22px; letter-spacing: -0.02em;">
                Payroll Cycle Workbench #<?= $run['payroll_run_id'] ?> &mdash; <?= date('F Y', mktime(0, 0, 0, (int)$run['payroll_month'], 10, (int)$run['payroll_year'])) ?>
                <?php 
                  $st = $run['payroll_status'];
                  $badgeCls = ($st === 'FINALIZED') ? 'badge-success' : (($st === 'APPROVED') ? 'badge-info' : 'badge-warning text-dark');
                ?>
                <span class="badge <?= $badgeCls ?> ml-2 px-2 py-1 font-weight-bold" style="font-size: 13px;">
                  <i class="fas <?= ($st === 'FINALIZED') ? 'fa-lock' : 'fa-circle' ?> mr-1" style="font-size: 8px;"></i> <?= $st ?>
                </span>
              </h1>
              <p class="text-muted small mb-0 mt-1">
                Cutoff: <strong><?= date('d M Y', strtotime($run['period_start'])) ?></strong> to <strong><?= date('d M Y', strtotime($run['period_end'])) ?></strong> | Rule: <strong><?= esc($run['salary_day_basis']) ?></strong> | Total: <strong><?= count($employees) ?> Employees Calculated</strong>
              </p>
            </div>
          </div>
        </div>
        
        <div class="col-sm-5 text-right">
          <div class="btn-group" style="gap: 6px;">
            <!-- Download Excel Reference -->
            <a href="<?= base_url('admin/payroll/export_register_csv/' . $run['payroll_run_id']) ?>" class="btn btn-success btn-sm shadow-sm font-weight-bold px-3" style="border-radius: 6px;">
              <i class="fas fa-file-excel mr-1"></i> Download Excel
            </a>

            <!-- Bank CSV -->
            <a href="<?= base_url('admin/payroll/export_bank_csv/' . $run['payroll_run_id']) ?>" class="btn btn-outline-secondary btn-sm shadow-sm font-weight-bold px-3" style="border-radius: 6px;">
              <i class="fas fa-file-csv mr-1"></i> Bank CSV
            </a>

            <!-- Finalize Button -->
            <?php if (in_array($run['payroll_status'], ['CALCULATED', 'APPROVED'])): ?>
              <button type="button" class="btn btn-primary btn-sm shadow-sm font-weight-bold px-3" data-toggle="modal" data-target="#finalizeRunModal" style="border-radius: 6px;">
                <i class="fas fa-lock mr-1"></i> Finalize Payroll Cycle
              </button>
            <?php elseif ($run['payroll_status'] === 'FINALIZED'): ?>
              <a href="<?= base_url('admin/payroll/payslips?run_id=' . $run['payroll_run_id']) ?>" class="btn btn-outline-success btn-sm shadow-sm font-weight-bold px-3" style="border-radius: 6px;">
                <i class="fas fa-file-invoice mr-1"></i> Payslips
              </a>
              <button type="button" class="btn btn-outline-danger btn-sm font-weight-bold shadow-sm" data-toggle="modal" data-target="#reopenModal" style="border-radius: 6px;">
                <i class="fas fa-unlock mr-1"></i> Reopen
              </button>
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

  <?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert" style="border-radius: 10px;">
      <i class="fas fa-exclamation-triangle mr-2"></i> <?= session()->getFlashdata('error') ?>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    </div>
  <?php endif; ?>

  <!-- Summary Cards -->
  <?php 
    $totMonthlyCtc = 0.00;
    $totGross = 0.00;
    $totLop = 0.00;
    $totDed = 0.00;
    $totNet = 0.00;
    foreach ($employees as $e) {
      $totMonthlyCtc += (float)$e['monthly_ctc'];
      $totGross += (float)$e['gross_earnings'];
      $totLop += (float)$e['lop_deduction'];
      $totDed += (float)$e['other_deductions'];
      $totNet += (float)$e['net_salary'];
    }
  ?>
  <div class="row mb-3">
    <div class="col-md-2 col-sm-4 mb-2">
      <div class="p-3 bg-white shadow-sm" style="border-radius: 12px; border: 1px solid #e2e8f0;">
        <span class="text-uppercase text-muted font-weight-bold small" style="font-size: 11px;">Staff Processed</span>
        <h4 class="font-weight-bold text-dark mt-1 mb-0"><?= count($employees) ?></h4>
      </div>
    </div>
    <div class="col-md-2 col-sm-4 mb-2">
      <div class="p-3 bg-white shadow-sm" style="border-radius: 12px; border: 1px solid #e2e8f0;">
        <span class="text-uppercase text-muted font-weight-bold small" style="font-size: 11px;">Total Monthly CTC</span>
        <h4 class="font-weight-bold text-dark mt-1 mb-0">₹<?= number_format($totMonthlyCtc, 2) ?></h4>
      </div>
    </div>
    <div class="col-md-2 col-sm-4 mb-2">
      <div class="p-3 bg-white shadow-sm" style="border-radius: 12px; border: 1px solid #e2e8f0;">
        <span class="text-uppercase text-muted font-weight-bold small" style="font-size: 11px;">Gross Earnings</span>
        <h4 class="font-weight-bold text-primary mt-1 mb-0">₹<?= number_format($totGross, 2) ?></h4>
      </div>
    </div>
    <div class="col-md-2 col-sm-4 mb-2">
      <div class="p-3 bg-white shadow-sm" style="border-radius: 12px; border: 1px solid #e2e8f0;">
        <span class="text-uppercase text-muted font-weight-bold small" style="font-size: 11px;">LOP Deductions</span>
        <h4 class="font-weight-bold text-danger mt-1 mb-0">-₹<?= number_format($totLop, 2) ?></h4>
      </div>
    </div>
    <div class="col-md-2 col-sm-4 mb-2">
      <div class="p-3 bg-white shadow-sm" style="border-radius: 12px; border: 1px solid #e2e8f0;">
        <span class="text-uppercase text-muted font-weight-bold small" style="font-size: 11px;">Total Deductions</span>
        <h4 class="font-weight-bold text-danger mt-1 mb-0">-₹<?= number_format($totDed, 2) ?></h4>
      </div>
    </div>
    <div class="col-md-2 col-sm-4 mb-2">
      <div class="p-3 bg-white shadow-sm" style="border-radius: 12px; border: 1px solid #e2e8f0; background: #ecfdf5 !important;">
        <span class="text-uppercase text-success font-weight-bold small" style="font-size: 11px;">Total Net Disbursal</span>
        <h4 class="font-weight-bold text-success mt-1 mb-0">₹<?= number_format($totNet, 2) ?></h4>
      </div>
    </div>
  </div>

  <!-- Master 29+ Column Calculation Grid -->
  <div class="card border-0 shadow-sm" style="border-radius: 14px; background: #ffffff;">
    <div class="card-header bg-transparent border-0 pt-3 pb-2 d-flex justify-content-between align-items-center flex-wrap" style="gap: 10px;">
      <div>
        <h5 class="font-weight-bold text-dark mb-0" style="font-size: 16px;">
          <i class="fas fa-table text-primary mr-2"></i> Master Payroll Calculation Workbench Grid
        </h5>
        <small class="text-muted">Direct component-by-component statutory breakdown conforming with company policy.</small>
      </div>

      <div class="d-flex align-items-center" style="gap: 8px;">
        <input type="text" id="gridSearch" class="form-control form-control-sm" placeholder="Quick search ID, Name, Bank..." style="border-radius: 6px; width: 220px;">
        <a href="<?= base_url('admin/payroll/export_register_csv/' . $run['payroll_run_id']) ?>" class="btn btn-sm btn-outline-success font-weight-bold" style="border-radius: 6px;">
          <i class="fas fa-file-excel mr-1"></i> Export 29-Col Excel
        </a>
      </div>
    </div>

    <div class="card-body p-0">
      <div class="wb-grid-wrapper">
        <table class="wb-grid-table" id="workbenchTable">
          <thead>
            <tr>
              <!-- 1 & 2 Identity (Frozen Left) -->
              <th class="wb-col-sticky-1 th-identity" title="Employee ID">#1 Emp ID</th>
              <th class="wb-col-sticky-2 th-identity" title="Employee Name">#2 Name</th>

              <!-- Contract & Attendance -->
              <th class="th-contract text-right" title="Salary / Monthly CTC">#3 Salary</th>
              <th class="th-attendance text-center" title="Leaves / LOP Days">#4 Leaves</th>
              <th class="th-attendance text-center" title="Working Days Basis">#5 Working Days</th>
              <th class="th-attendance text-right text-danger" title="Leave Salary Deduction">#6 Leave Deduction</th>

              <!-- Earnings -->
              <th class="th-earnings text-right text-info" title="Other Earnings">#7 Other Earnings</th>
              <th class="th-earnings text-right font-weight-bold" title="Adjusted CTC1">#8 CTC1</th>
              <th class="th-earnings text-right font-weight-bold text-success" title="Direct Gross Earnings">#9 Gross</th>
              <th class="th-earnings text-right" title="Basic Salary (50% of CTC)">#10 Basic @ 50%</th>
              <th class="th-earnings text-right" title="House Rent Allowance (20% of CTC)">#11 HRA @ 20%</th>
              <th class="th-earnings text-right" title="Medical Allowance (5% of CTC)">#12 Medical @ 5%</th>
              <th class="th-earnings text-right" title="Conveyance Allowance (8% of CTC)">#13 Conveyance @ 8%</th>
              <th class="th-earnings text-right" title="Special Allowance / Others (17% of CTC)">#14 Others @ 17%</th>

              <!-- Employer Statutory -->
              <th class="th-stat-emplr text-right" title="Employer NPS Contribution">#15 Employer NPS</th>
              <th class="th-stat-emplr text-right" title="PF Employer Share (Capped at 1,800)">#16 PF Employer</th>
              <th class="th-stat-emplr text-right" title="Admin Charges (75.00)">#17 Admin Charges</th>
              <th class="th-stat-emplr text-right" title="ESI Employer Share (3.25% if CTC <= 21,000)">#18 ESI Employer</th>

              <!-- Employee Deductions -->
              <th class="th-deductions text-right" title="Professional Tax">#19 PT</th>
              <th class="th-deductions text-right" title="PF Employee Share (12% capped at 1,800)">#20 PF Employee</th>
              <th class="th-deductions text-right" title="ESI Employee Share (0.75% if CTC <= 21,000)">#21 ESI Employee</th>
              <th class="th-deductions text-right" title="Advances / Other Deductions">#22 Advances/Other</th>
              <th class="th-deductions text-right" title="TDS / Income Tax">#23 TDS</th>
              <th class="th-deductions text-right font-weight-bold text-danger" title="Total Employee Deductions">#24 Total Deductions</th>

              <!-- Disbursal -->
              <th class="th-netpay text-right" title="Net In-Hand Pay">#25 Net Pay</th>

              <!-- Banking Details -->
              <th class="th-banking" title="Bank Account Number">#26 Bank A/c No</th>
              <th class="th-banking" title="Beneficiary Bank Name">#27 BANK NAME</th>
              <th class="th-banking" title="Bank IFSC Code">#28 IFSC</th>
              <th class="th-banking" title="Contact Mobile Number">#29 Mobile No</th>

              <!-- Action (Frozen Right) -->
              <th class="wb-col-sticky-action th-identity text-center" title="Status & Details">#30 Status / Action</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($employees)): ?>
              <tr>
                <td colspan="30" class="text-center py-5 text-muted">
                  No employee records calculated for this cycle.
                </td>
              </tr>
            <?php else: ?>
              <?php foreach ($employees as $e): ?>
                <tr>
                  <!-- 1 & 2 Identity Left -->
                  <td class="wb-col-sticky-1 font-weight-bold text-primary"><?= esc($e['emp_id']) ?></td>
                  <td class="wb-col-sticky-2 font-weight-bold text-dark">
                    <div><?= esc($e['emp_name']) ?></div>
                    <small class="text-muted"><?= esc($e['department_name'] ?? 'General') ?> &bull; <?= esc($e['designation_name'] ?? 'Staff') ?></small>
                  </td>

                  <!-- Contract & Attendance -->
                  <td class="text-right font-weight-bold text-primary">₹<?= number_format((float)$e['salary'], 2) ?></td>
                  <td class="text-center font-weight-bold <?= ((float)$e['leaves'] > 0) ? 'text-danger' : 'text-muted' ?>">
                    <?= number_format((float)$e['leaves'], 1) ?>
                  </td>
                  <td class="text-center text-muted"><?= (int)$e['working_days'] ?></td>
                  <td class="text-right text-danger font-weight-bold">
                    <?= ((float)$e['leave_deduction'] > 0) ? '-₹' . number_format((float)$e['leave_deduction'], 2) : '₹0.00' ?>
                  </td>

                  <!-- Earnings -->
                  <td class="text-right text-info">₹<?= number_format((float)$e['other_earnings'], 2) ?></td>
                  <td class="text-right font-weight-bold text-dark">₹<?= number_format((float)$e['ctc1'], 2) ?></td>
                  <td class="text-right font-weight-bold text-success" style="background: #f0fdf4;">₹<?= number_format((float)$e['gross_earnings'], 2) ?></td>
                  <td class="text-right">₹<?= number_format((float)$e['basic'], 2) ?></td>
                  <td class="text-right">₹<?= number_format((float)$e['hra'], 2) ?></td>
                  <td class="text-right">₹<?= number_format((float)$e['medical'], 2) ?></td>
                  <td class="text-right">₹<?= number_format((float)$e['conveyance'], 2) ?></td>
                  <td class="text-right">₹<?= number_format((float)$e['others'], 2) ?></td>

                  <!-- Employer Statutory -->
                  <td class="text-right text-muted">₹<?= number_format((float)$e['employer_nps'], 2) ?></td>
                  <td class="text-right text-muted">₹<?= number_format((float)$e['pf_employer_contribution'], 2) ?></td>
                  <td class="text-right text-muted">₹<?= number_format((float)$e['admin_charges'], 2) ?></td>
                  <td class="text-right text-muted">₹<?= number_format((float)$e['esi_employer_contribution'], 2) ?></td>

                  <!-- Employee Deductions -->
                  <td class="text-right text-danger">₹<?= number_format((float)$e['pt'], 2) ?></td>
                  <td class="text-right text-danger">₹<?= number_format((float)$e['pf_employee_contribution'], 2) ?></td>
                  <td class="text-right text-danger">₹<?= number_format((float)$e['esi_employee_contribution'], 2) ?></td>
                  <td class="text-right text-danger">₹<?= number_format((float)$e['advances_deduction'], 2) ?></td>
                  <td class="text-right text-danger">₹<?= number_format((float)$e['tds'], 2) ?></td>
                  <td class="text-right font-weight-bold text-danger" style="background: #fff1f2;">-₹<?= number_format((float)$e['total_deductions'], 2) ?></td>

                  <!-- Disbursal -->
                  <td class="text-right font-weight-bold text-success" style="background: #ecfdf5; font-size: 13px;">₹<?= number_format((float)$e['net_pay'], 2) ?></td>

                  <!-- Banking Details -->
                  <td class="font-weight-bold text-dark"><?= esc($e['bank_account_no'] ?: 'N/A') ?></td>
                  <td><?= esc($e['bank_name'] ?: 'N/A') ?></td>
                  <td><code><?= esc($e['ifsc'] ?: 'N/A') ?></code></td>
                  <td><?= esc($e['mobile'] ?: '') ?></td>

                  <!-- Action Right -->
                  <td class="wb-col-sticky-action text-center">
                    <button type="button" class="btn btn-xs btn-outline-primary font-weight-bold px-2 py-1 btn-view-components mr-1"
                            data-emp="<?= esc($e['emp_id']) ?>"
                            data-name="<?= esc($e['emp_name']) ?>"
                            data-gross="₹<?= number_format((float)$e['gross_earnings'], 2) ?>"
                            data-lop="₹<?= number_format((float)$e['lop_deduction'], 2) ?>"
                            data-ded="₹<?= number_format((float)$e['total_deductions'], 2) ?>"
                            data-net="₹<?= number_format((float)$e['net_pay'], 2) ?>"
                            data-comps='<?= json_encode($e['components_list'] ?? []) ?>'
                            title="Inspect component snapshots">
                      <i class="fas fa-layer-group"></i> Comps
                    </button>
                    <?php if ($run['payroll_status'] === 'FINALIZED'): ?>
                      <a href="<?= base_url('admin/payroll/payslip/' . $run['payroll_run_id'] . '/' . $e['emp_id']) ?>" target="_blank" class="btn btn-xs btn-outline-success font-weight-bold px-2 py-1" title="Digital Payslip">
                        <i class="fas fa-file-invoice"></i>
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

<!-- Modal: Finalize Payroll Cycle Confirmation -->
<div class="modal fade" id="finalizeRunModal" tabindex="-1" role="dialog" aria-labelledby="finalizeRunModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content border-0 shadow" style="border-radius: 14px;">
      <form method="post" action="<?= base_url('admin/payroll/finalize_run/' . $run['payroll_run_id']) ?>" id="formFinalizeRun">
        <?= csrf_field() ?>
        <div class="modal-header border-0 pb-0">
          <h5 class="modal-title font-weight-bold text-dark" id="finalizeRunModalLabel">
            <i class="fas fa-lock text-success mr-2"></i> Finalize Payroll Cycle &amp; Lock Period
          </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body py-3">
          <div class="alert alert-warning border-0 p-3 small mb-3" style="border-radius: 8px; background: #fffbeb; color: #92400e;">
            <i class="fas fa-exclamation-triangle mr-1"></i> <strong>Important Compliance Action:</strong> Finalizing this cycle will permanently lock the calculations, record audit logs, and auto-generate immutable digital payslips for all <strong><?= count($employees) ?> active employees</strong>.
          </div>

          <div class="p-3 bg-light rounded border mb-2" style="font-size: 13px;">
            <div class="d-flex justify-content-between mb-1">
              <span class="text-muted">Payroll Period:</span>
              <strong class="text-dark"><?= date('F Y', mktime(0, 0, 0, (int)$run['payroll_month'], 10, (int)$run['payroll_year'])) ?></strong>
            </div>
            <div class="d-flex justify-content-between mb-1">
              <span class="text-muted">Staff Included:</span>
              <strong class="text-dark"><?= count($employees) ?> Employees</strong>
            </div>
            <div class="d-flex justify-content-between mb-1">
              <span class="text-muted">Total Gross Earnings:</span>
              <strong class="text-primary">₹<?= number_format($totGross, 2) ?></strong>
            </div>
            <div class="d-flex justify-content-between mb-1">
              <span class="text-muted">Total Deductions:</span>
              <strong class="text-danger">-₹<?= number_format($totDed, 2) ?></strong>
            </div>
            <hr class="my-2">
            <div class="d-flex justify-content-between">
              <span class="font-weight-bold text-dark">Total Net Disbursal:</span>
              <strong class="text-success font-weight-bold" style="font-size: 15px;">₹<?= number_format($totNet, 2) ?></strong>
            </div>
          </div>
        </div>
        <div class="modal-footer border-0 pt-0">
          <button type="button" class="btn btn-light border px-4" data-dismiss="modal" style="border-radius: 8px;">Cancel</button>
          <button type="submit" class="btn btn-success px-4 font-weight-bold shadow-sm" id="btnSubmitFinalize" style="border-radius: 8px;">
            <i class="fas fa-lock mr-1"></i> Confirm &amp; Finalize Cycle
          </button>
        </div>
      </form>
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
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body py-3">
        <!-- Totals Strip -->
        <div class="d-flex justify-content-between p-2 mb-3 bg-light rounded" style="font-size: 13px;">
          <div>Gross: <strong id="modalGross" class="text-success">₹0</strong></div>
          <div>LOP Deduction: <strong id="modalLop" class="text-danger">₹0</strong></div>
          <div>Total Deductions: <strong id="modalDed" class="text-danger">₹0</strong></div>
          <div>Net Disbursed: <strong id="modalNet" class="text-dark">₹0</strong></div>
        </div>

        <div class="table-responsive" style="max-height: 380px; overflow-y: auto;">
          <table class="table table-sm table-hover align-middle mb-0" id="componentsTable" style="font-size: 13px;">
            <thead class="bg-light">
              <tr>
                <th>Type</th>
                <th>Component Code &amp; Name</th>
                <th class="text-right">Monthly Amount</th>
                <th class="text-right">LOP Loss</th>
                <th class="text-right font-weight-bold">Payable Amount</th>
              </tr>
            </thead>
            <tbody id="componentsBody">
              <tr><td colspan="5" class="text-center py-4 text-muted">No components found.</td></tr>
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
<?php if ($run['payroll_status'] === 'FINALIZED'): ?>
<div class="modal fade" id="reopenModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content border-0 shadow" style="border-radius: 14px;">
      <form method="post" action="<?= base_url('admin/payroll/reopen_run/' . $run['payroll_run_id']) ?>">
        <?= csrf_field() ?>
        <div class="modal-header border-0 pb-0">
          <h5 class="modal-title font-weight-bold text-dark">
            <i class="fas fa-unlock text-danger mr-2"></i> Reopen Payroll Run #<?= $run['payroll_run_id'] ?>
          </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body py-3">
          <div class="alert alert-danger border-0 p-3 small mb-3" style="border-radius: 8px;">
            Reopening will revoke finalized status and allow recalculating salary structures and attendance.
          </div>
          <div class="form-group mb-0">
            <label class="font-weight-bold text-dark small">Reason for Reopening <span class="text-danger">*</span></label>
            <textarea name="reason" class="form-control" rows="3" required placeholder="Describe why this period is being reopened..." style="border-radius: 8px;"></textarea>
          </div>
        </div>
        <div class="modal-footer border-0 pt-0">
          <button type="button" class="btn btn-light border px-4" data-dismiss="modal" style="border-radius: 8px;">Cancel</button>
          <button type="submit" class="btn btn-danger px-4 font-weight-bold shadow-sm" style="border-radius: 8px;">
            <i class="fas fa-unlock mr-1"></i> Reopen Period
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
<?php endif; ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function() {
  // Live quick search in 35-column workbench
  $('#gridSearch').on('keyup', function() {
    var val = $(this).val().toLowerCase();
    $('#workbenchTable tbody tr').filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(val) > -1);
    });
  });

  // Finalize submit feedback
  $('#formFinalizeRun').on('submit', function() {
    $('#btnSubmitFinalize').prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Locking &amp; Generating Payslips...');
  });

  // Component breakdown modal click handler
  $(document).on('click', '.btn-view-components', function(e) {
    e.preventDefault();
    var empId = $(this).data('emp');
    var empName = $(this).data('name');
    var gross = $(this).data('gross');
    var lop = $(this).data('lop');
    var ded = $(this).data('ded');
    var net = $(this).data('net');
    var comps = $(this).data('comps') || [];

    $('#modalEmpName').text(empName);
    $('#modalEmpId').text('Emp ID: ' + empId);
    $('#modalGross').text(gross);
    $('#modalLop').text(lop);
    $('#modalDed').text(ded);
    $('#modalNet').text(net);

    var html = '';
    if (comps && comps.length > 0) {
      comps.forEach(function(c) {
        var typeBadge = (c.component_type === 'EARNING') ? '<span class="badge badge-success px-2 py-1">Earning</span>' :
                        ((c.component_type === 'DEDUCTION') ? '<span class="badge badge-danger px-2 py-1">Deduction</span>' :
                        '<span class="badge badge-info px-2 py-1">Employer</span>');

        var monthlyAmt = parseFloat(c.monthly_amount || 0).toFixed(2);
        var lopAmt = parseFloat(c.lop_amount || 0).toFixed(2);
        var payableAmt = parseFloat(c.payable_amount || 0).toFixed(2);

        html += '<tr>' +
          '<td>' + typeBadge + '</td>' +
          '<td><strong class="text-dark">' + (c.component_name || c.component_code) + '</strong> <small class="text-muted font-weight-bold"><code>' + c.component_code + '</code></small></td>' +
          '<td class="text-right">₹' + monthlyAmt + '</td>' +
          '<td class="text-right text-danger">' + (parseFloat(lopAmt) > 0 ? '-₹' + lopAmt : '₹0.00') + '</td>' +
          '<td class="text-right font-weight-bold text-dark">₹' + payableAmt + '</td>' +
          '</tr>';
      });
    } else {
      html = '<tr><td colspan="5" class="text-center py-4 text-muted">No component snapshots saved.</td></tr>';
    }

    $('#componentsBody').html(html);
    $('#componentsModal').modal('show');
  });
});
</script>
