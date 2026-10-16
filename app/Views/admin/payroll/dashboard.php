<div class="content-wrapper" style="min-height: 800px; padding: 20px 24px;">
  
  <!-- Breadcrumb -->
  <div class="content-header p-0 mb-3">
    <div class="container-fluid p-0">
      <div class="row align-items-center">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark font-weight-bold" style="font-size: 24px; letter-spacing: -0.02em;">
            <i class="fas fa-money-check-alt text-primary mr-2"></i> Payroll Command Center
          </h1>
          <p class="text-muted small mb-0 mt-1">
            Enterprise salary calculation engine driven by MySQL stored procedures & attendance inputs.
          </p>
        </div>
        <div class="col-sm-6 text-right">
          <button type="button" class="btn btn-primary shadow-sm px-4 font-weight-bold" data-toggle="modal" data-target="#createRunModal" style="border-radius: 8px;">
            <i class="fas fa-plus-circle mr-1"></i> Run New Payroll
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Shared Payroll Sub Navigation -->
  <?= view('admin/payroll/payroll_nav') ?>

  <!-- Flash Messages -->
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

  <!-- KPI Metrics Row -->
  <div class="row mb-4">
    <!-- Active Employees -->
    <div class="col-lg-3 col-sm-6 mb-3 mb-lg-0">
      <div class="card border-0 shadow-sm h-100" style="border-radius: 14px; background: #ffffff;">
        <div class="card-body p-3 d-flex align-items-center">
          <div class="rounded-circle d-flex align-items-center justify-content-center mr-3" style="width: 52px; height: 52px; background: #eff6ff; color: #2563eb; font-size: 22px;">
            <i class="fas fa-users"></i>
          </div>
          <div>
            <div class="text-uppercase text-muted font-weight-bold" style="font-size: 11px; letter-spacing: 0.5px;">Active Workforce</div>
            <div class="font-weight-bold text-dark mt-1" style="font-size: 24px; line-height: 1.1;"><?= number_format($totalActiveEmps) ?></div>
            <a href="<?= base_url('admin/payroll/structures') ?>" class="small text-primary font-weight-bold">View Structures &rarr;</a>
          </div>
        </div>
      </div>
    </div>

    <!-- Cutoff Cycle Policy -->
    <div class="col-lg-3 col-sm-6 mb-3 mb-lg-0">
      <div class="card border-0 shadow-sm h-100" style="border-radius: 14px; background: #ffffff;">
        <div class="card-body p-3 d-flex align-items-center">
          <div class="rounded-circle d-flex align-items-center justify-content-center mr-3" style="width: 52px; height: 52px; background: #ecfdf5; color: #10b981; font-size: 22px;">
            <i class="fas fa-calendar-alt"></i>
          </div>
          <div>
            <div class="text-uppercase text-muted font-weight-bold" style="font-size: 11px; letter-spacing: 0.5px;">Payroll Cutoff Policy</div>
            <div class="font-weight-bold text-dark mt-1" style="font-size: 18px; line-height: 1.2;">
              <?= $cycleStartDay ?><sup>th</sup> to <?= $cycleEndDay ?><sup>th</sup>
            </div>
            <span class="badge badge-success font-weight-normal mt-1">Fixed 30-Day Basis</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Finalized Cycles -->
    <div class="col-lg-3 col-sm-6 mb-3 mb-lg-0">
      <div class="card border-0 shadow-sm h-100" style="border-radius: 14px; background: #ffffff;">
        <div class="card-body p-3 d-flex align-items-center">
          <div class="rounded-circle d-flex align-items-center justify-content-center mr-3" style="width: 52px; height: 52px; background: #fffbeb; color: #f59e0b; font-size: 22px;">
            <i class="fas fa-lock"></i>
          </div>
          <div>
            <div class="text-uppercase text-muted font-weight-bold" style="font-size: 11px; letter-spacing: 0.5px;">Finalized Runs</div>
            <div class="font-weight-bold text-dark mt-1" style="font-size: 24px; line-height: 1.1;"><?= $finalizedRuns ?></div>
            <span class="text-muted small">Locked & Immutable</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Total Net Payout -->
    <div class="col-lg-3 col-sm-6 mb-3 mb-lg-0">
      <div class="card border-0 shadow-sm h-100" style="border-radius: 14px; background: #ffffff;">
        <div class="card-body p-3 d-flex align-items-center">
          <div class="rounded-circle d-flex align-items-center justify-content-center mr-3" style="width: 52px; height: 52px; background: #fdf2f8; color: #db2777; font-size: 22px;">
            <i class="fas fa-wallet"></i>
          </div>
          <div>
            <div class="text-uppercase text-muted font-weight-bold" style="font-size: 11px; letter-spacing: 0.5px;">Total Net Disbursed</div>
            <div class="font-weight-bold text-dark mt-1" style="font-size: 20px; line-height: 1.2;">₹<?= number_format($totalDisbursed, 2) ?></div>
            <a href="<?= base_url('admin/payroll/reports') ?>" class="small text-danger font-weight-bold">Bank Reports &rarr;</a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Financial Year Cycle Grid Card -->
  <div class="card border-0 shadow-sm mb-4" style="border-radius: 14px; background: #ffffff;">
    <div class="card-header bg-transparent border-0 pt-3 pb-2 d-flex justify-content-between align-items-center">
      <div>
        <h5 class="font-weight-bold text-dark mb-0" style="font-size: 16px;">
          <i class="fas fa-th mr-2 text-primary"></i> Financial Year Payroll Cycles Hub (FY <?= esc($selectedFY) ?>)
        </h5>
        <small class="text-muted">Monthly cycle calendar derived from company settings cutoff window.</small>
      </div>
      <div>
        <div class="btn-group btn-group-sm">
          <a href="<?= base_url('admin/payroll?fy=2026-27') ?>" class="btn btn-outline-secondary <?= $selectedFY === '2026-27' ? 'active font-weight-bold' : '' ?>">FY 2026-27</a>
          <a href="<?= base_url('admin/payroll?fy=2025-26') ?>" class="btn btn-outline-secondary <?= $selectedFY === '2025-26' ? 'active font-weight-bold' : '' ?>">FY 2025-26</a>
        </div>
      </div>
    </div>
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0 text-nowrap" style="font-size: 13px;">
          <thead style="background: #f8fafc; color: #475569; font-weight: 600;">
            <tr>
              <th class="pl-4">Cycle Month</th>
              <th>Cutoff Period Range</th>
              <th>Attendance Summary</th>
              <th>Staff Processed</th>
              <th>Run Status</th>
              <th class="text-right pr-4">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($fyMatrix as $fm): ?>
              <tr>
                <td class="pl-4 font-weight-bold text-dark">
                  <span class="mr-2"><?= $fm['month_name'] ?> <?= $fm['year'] ?></span>
                  <?php if ($fm['month'] == 9 && $fm['year'] == 2026): ?>
                    <span class="badge badge-info text-white font-weight-normal px-2 py-1">Active Cycle</span>
                  <?php endif; ?>
                </td>
                <td class="text-muted">
                  <i class="far fa-calendar-alt text-primary mr-1"></i> <?= $fm['period_label'] ?>
                </td>
                <td>
                  <?php if ($fm['att_finalized']): ?>
                    <span class="badge badge-success px-2 py-1 font-weight-normal">
                      <i class="fas fa-check-circle mr-1"></i> Attendance Finalized (<?= $fm['staff_count'] ?>)
                    </span>
                  <?php elseif ($fm['att_exists']): ?>
                    <span class="badge badge-warning text-dark px-2 py-1 font-weight-normal">
                      <i class="fas fa-clock mr-1"></i> Draft Attendance (<?= $fm['staff_count'] ?>)
                    </span>
                  <?php else: ?>
                    <span class="badge badge-light text-muted border px-2 py-1 font-weight-normal">
                      <i class="fas fa-minus mr-1"></i> Not Generated
                    </span>
                  <?php endif; ?>
                </td>
                <td>
                  <?php if (!empty($fm['run'])): ?>
                    <span class="font-weight-bold text-dark"><?= number_format($fm['run']['total_employees']) ?> Staff</span>
                    <small class="text-muted d-block">Net: ₹<?= number_format((float)$fm['run']['total_net_payout'], 2) ?></small>
                  <?php else: ?>
                    <span class="text-muted">&mdash;</span>
                  <?php endif; ?>
                </td>
                <td>
                  <?php if (!empty($fm['run'])): ?>
                    <?php 
                      $st = $fm['run']['payroll_status'];
                      $badgeClass = ($st === 'FINALIZED') ? 'badge-success' : (($st === 'APPROVED') ? 'badge-info' : 'badge-warning text-dark');
                    ?>
                    <span class="badge <?= $badgeClass ?> px-2 py-1 font-weight-bold">
                      <i class="fas fa-circle mr-1" style="font-size: 8px;"></i> <?= $st ?>
                    </span>
                  <?php else: ?>
                    <span class="badge badge-light text-muted border px-2 py-1 font-weight-normal">Pending</span>
                  <?php endif; ?>
                </td>
                <td class="text-right pr-4">
                  <?php if (!empty($fm['run'])): ?>
                    <a href="<?= base_url('admin/payroll/run/' . $fm['run']['payroll_run_id']) ?>" class="btn btn-sm btn-primary px-3 shadow-sm font-weight-bold" style="border-radius: 6px;">
                      <i class="fas fa-cogs mr-1"></i> View Run
                    </a>
                  <?php else: ?>
                    <form method="post" action="<?= base_url('admin/payroll/create_run') ?>" class="d-inline">
                      <input type="hidden" name="payroll_month" value="<?= $fm['month'] ?>">
                      <input type="hidden" name="payroll_year" value="<?= $fm['year'] ?>">
                      <input type="hidden" name="salary_day_basis" value="FIXED_30">
                      <button type="submit" class="btn btn-sm btn-outline-primary px-3 font-weight-bold" style="border-radius: 6px;">
                        <i class="fas fa-play mr-1"></i> Run Payroll
                      </button>
                    </form>
                  <?php endif; ?>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Recent Payroll Runs Section -->
  <div class="card border-0 shadow-sm" style="border-radius: 14px; background: #ffffff;">
    <div class="card-header bg-transparent border-0 pt-3 pb-2 d-flex justify-content-between align-items-center">
      <div>
        <h5 class="font-weight-bold text-dark mb-0" style="font-size: 16px;">
          <i class="fas fa-history mr-2 text-primary"></i> Processed Payroll Runs Master Table
        </h5>
        <small class="text-muted">History of calculated and finalized monthly cycles with direct audit links.</small>
      </div>
      <div>
        <a href="<?= base_url('admin/payroll/runs') ?>" class="btn btn-sm btn-light border px-3 font-weight-bold" style="border-radius: 6px;">
          View All Runs &rarr;
        </a>
      </div>
    </div>
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0 text-nowrap" style="font-size: 13px;">
          <thead style="background: #f8fafc; color: #475569; font-weight: 600;">
            <tr>
              <th class="pl-4">Run ID</th>
              <th>Period</th>
              <th>Day Basis</th>
              <th>Employees</th>
              <th>Gross Earnings</th>
              <th>LOP Deductions</th>
              <th>Total Deductions</th>
              <th>Net Payout</th>
              <th>Status</th>
              <th class="text-right pr-4">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($runs)): ?>
              <tr>
                <td colspan="10" class="text-center py-4 text-muted">
                  No payroll runs processed yet. Click <strong>"Run New Payroll"</strong> above to calculate your first cycle.
                </td>
              </tr>
            <?php else: ?>
              <?php foreach ($runs as $r): ?>
                <tr>
                  <td class="pl-4 font-weight-bold text-primary">
                    #<?= $r['payroll_run_id'] ?>
                  </td>
                  <td>
                    <strong><?= date('F Y', mktime(0, 0, 0, $r['payroll_month'], 10, $r['payroll_year'])) ?></strong>
                    <small class="d-block text-muted"><?= date('d M', strtotime($r['period_start'])) ?> - <?= date('d M Y', strtotime($r['period_end'])) ?></small>
                  </td>
                  <td>
                    <span class="badge badge-light border text-dark font-weight-normal"><?= $r['salary_day_basis'] ?></span>
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
                  <td class="text-danger">
                    -₹<?= number_format((float)$r['total_deductions'], 2) ?>
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
                      <?= $st ?>
                    </span>
                  </td>
                  <td class="text-right pr-4">
                    <a href="<?= base_url('admin/payroll/run/' . $r['payroll_run_id']) ?>" class="btn btn-sm btn-outline-primary px-2 py-1 font-weight-bold mr-1" title="Open Workbench">
                      <i class="fas fa-eye"></i> View
                    </a>
                    <a href="<?= base_url('admin/payroll/export_bank_csv/' . $r['payroll_run_id']) ?>" class="btn btn-sm btn-outline-secondary px-2 py-1" title="Download Bank Transfer CSV">
                      <i class="fas fa-file-csv"></i> Bank
                    </a>
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
      <form method="post" action="<?= base_url('admin/payroll/create_run') ?>">
        <div class="modal-header border-0 pb-0">
          <h5 class="modal-title font-weight-bold text-dark" id="createRunModalLabel">
            <i class="fas fa-play-circle text-primary mr-2"></i> Initiate Monthly Payroll Run
          </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body py-3">
          <p class="text-muted small mb-3">
            This will calculate earnings, LOP deductions using the <strong>fixed 30-day salary proration</strong> rule, employee statutory deductions, and employer contributions via MySQL stored procedures.
          </p>

          <div class="form-row">
            <div class="form-group col-md-6">
              <label class="font-weight-bold text-dark small">Payroll Month</label>
              <select name="payroll_month" class="form-control" required style="border-radius: 8px;">
                <?php for ($m = 1; $m <= 12; $m++): ?>
                  <option value="<?= $m ?>" <?= ($m == 9) ? 'selected' : '' ?>>
                    <?= date('F', mktime(0, 0, 0, $m, 10)) ?>
                  </option>
                <?php endfor; ?>
              </select>
            </div>
            <div class="form-group col-md-6">
              <label class="font-weight-bold text-dark small">Payroll Year</label>
              <select name="payroll_year" class="form-control" required style="border-radius: 8px;">
                <option value="2026" selected>2026</option>
                <option value="2025">2025</option>
                <option value="2024">2024</option>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label class="font-weight-bold text-dark small">Salary Calculation Basis</label>
            <select name="salary_day_basis" class="form-control" required style="border-radius: 8px;">
              <option value="FIXED_30" selected>Fixed 30-Day Basis (Standard company policy: ₹CTC / 30 * LOP)</option>
              <option value="CALENDAR_DAYS">Actual Calendar Days (Denominator = 28/29/30/31)</option>
              <option value="WORKING_DAYS">Payable Working Days Basis</option>
            </select>
            <small class="text-muted">
              Cutoff dates are automatically loaded from <strong>company settings</strong>: 25th to 24th.
            </small>
          </div>
        </div>
        <div class="modal-footer border-0 pt-0">
          <button type="button" class="btn btn-light border px-4" data-dismiss="modal" style="border-radius: 8px;">Cancel</button>
          <button type="submit" class="btn btn-primary px-4 font-weight-bold shadow-sm" style="border-radius: 8px;">
            <i class="fas fa-calculator mr-1"></i> Calculate Payroll
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
