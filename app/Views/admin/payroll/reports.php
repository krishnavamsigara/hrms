<div class="content-wrapper" style="min-height: 800px; padding: 20px 24px;">
  
  <div class="content-header p-0 mb-3">
    <div class="container-fluid p-0">
      <div class="row align-items-center">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark font-weight-bold" style="font-size: 24px; letter-spacing: -0.02em;">
            <i class="fas fa-university text-primary mr-2"></i> Payroll Reports & Bank Transfer Center
          </h1>
          <p class="text-muted small mb-0 mt-1">
            Export NEFT/RTGS bank disbursement sheets, master payroll registers, and financial summaries.
          </p>
        </div>
        <div class="col-sm-6 text-right">
          <?php if (!empty($activeRun)): ?>
            <a href="<?= base_url('admin/payroll/export_bank_csv/' . $activeRun['payroll_run_id']) ?>" class="btn btn-primary shadow-sm font-weight-bold px-3 mr-2" style="border-radius: 8px;">
              <i class="fas fa-file-csv mr-1"></i> Export Bank Transfer CSV
            </a>
            <a href="<?= base_url('admin/payroll/export_register_csv/' . $activeRun['payroll_run_id']) ?>" class="btn btn-outline-secondary shadow-sm font-weight-bold px-3" style="border-radius: 8px;">
              <i class="fas fa-file-excel mr-1"></i> Full Register CSV
            </a>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>

  <?= view('admin/payroll/payroll_nav') ?>

  <!-- Cycle Selector Card -->
  <div class="card border-0 shadow-sm mb-4" style="border-radius: 14px; background: #ffffff;">
    <div class="card-body p-3">
      <form method="get" action="<?= base_url('admin/payroll/reports') ?>" class="form-row align-items-center">
        <div class="col-md-5">
          <div class="d-flex align-items-center">
            <label class="font-weight-bold small text-muted mr-3 mb-0 text-nowrap">Select Payroll Cycle:</label>
            <select name="run_id" class="form-control" onchange="this.form.submit();" style="border-radius: 8px;">
              <?php foreach ($runs as $r): ?>
                <option value="<?= $r['payroll_run_id'] ?>" <?= ($selectedRunId == $r['payroll_run_id']) ? 'selected' : '' ?>>
                  Run #<?= $r['payroll_run_id'] ?> &mdash; <?= date('F Y', mktime(0, 0, 0, $r['payroll_month'], 10, $r['payroll_year'])) ?> (<?= $r['payroll_status'] ?>)
                </option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
        <?php if (!empty($activeRun)): ?>
          <div class="col-md-7 text-md-right mt-2 mt-md-0">
            <span class="text-muted small mr-3">
              Period: <strong><?= date('d M', strtotime($activeRun['period_start'])) ?> - <?= date('d M Y', strtotime($activeRun['period_end'])) ?></strong>
            </span>
            <span class="badge badge-success px-2 py-1 font-weight-normal mr-2">
              Staff: <strong><?= count($employees) ?></strong>
            </span>
            <span class="font-weight-bold text-primary" style="font-size: 15px;">
              Net Payout: ₹<?= number_format((float)$activeRun['total_net_payout'], 2) ?>
            </span>
          </div>
        <?php endif; ?>
      </form>
    </div>
  </div>

  <?php if (empty($activeRun)): ?>
    <div class="card border-0 shadow-sm p-5 text-center text-muted" style="border-radius: 14px;">
      <i class="fas fa-file-invoice-dollar fa-3x mb-3 text-muted"></i>
      <h5>No Payroll Cycle Selected</h5>
      <p class="small">Please select a cycle from above or process a payroll run first.</p>
    </div>
  <?php else: ?>

    <!-- Nav Tabs for Reports -->
    <ul class="nav nav-pills mb-3" id="reportsTab" role="tablist">
      <li class="nav-item">
        <a class="nav-link active font-weight-bold" id="bank-tab" data-toggle="pill" href="#bank" role="tab" style="border-radius: 8px;">
          <i class="fas fa-university mr-1"></i> Bank Transfer Sheet (NEFT / RTGS)
        </a>
      </li>
      <li class="nav-item ml-2">
        <a class="nav-link font-weight-bold" id="register-tab" data-toggle="pill" href="#register" role="tab" style="border-radius: 8px;">
          <i class="fas fa-table mr-1"></i> Master Payroll Register
        </a>
      </li>
    </ul>

    <div class="tab-content" id="reportsTabContent">
      <!-- TAB 1: Bank Transfer Sheet -->
      <div class="tab-pane fade show active" id="bank" role="tabpanel">
        <div class="card border-0 shadow-sm" style="border-radius: 14px; background: #ffffff;">
          <div class="card-header bg-transparent border-0 pt-3 pb-2 d-flex justify-content-between align-items-center">
            <div>
              <h5 class="font-weight-bold text-dark mb-0" style="font-size: 16px;">
                <i class="fas fa-file-csv mr-2 text-primary"></i> Bank Payout Advice (<?= count($employees) ?> Records)
              </h5>
              <small class="text-muted">Standard format for bank upload and NEFT bulk salary transfer.</small>
            </div>
            <div>
              <a href="<?= base_url('admin/payroll/export_bank_csv/' . $activeRun['payroll_run_id']) ?>" class="btn btn-sm btn-outline-primary font-weight-bold" style="border-radius: 6px;">
                <i class="fas fa-download mr-1"></i> Download CSV
              </a>
            </div>
          </div>
          <div class="card-body p-0">
            <div class="table-responsive">
              <table class="table table-hover align-middle mb-0 text-nowrap" style="font-size: 13px;">
                <thead style="background: #f8fafc; color: #475569; font-weight: 600;">
                  <tr>
                    <th class="pl-4">#</th>
                    <th>Employee ID</th>
                    <th>Beneficiary Name</th>
                    <th>Bank Name</th>
                    <th>Account Number</th>
                    <th>IFSC Code</th>
                    <th class="text-right pr-4 font-weight-bold">Transfer Amount (₹)</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $idx = 1; foreach ($employees as $e): ?>
                    <tr>
                      <td class="pl-4 text-muted"><?= $idx++ ?></td>
                      <td class="font-weight-bold text-primary"><?= esc($e['emp_id']) ?></td>
                      <td class="font-weight-bold text-dark"><?= esc($e['emp_name']) ?></td>
                      <td><?= esc($e['bank_name'] ?: 'N/A') ?></td>
                      <td class="font-weight-bold text-dark"><?= esc($e['bank_account_no'] ?: 'N/A') ?></td>
                      <td><code><?= esc($e['ifsc'] ?: 'N/A') ?></code></td>
                      <td class="text-right pr-4 font-weight-bold text-success" style="font-size: 14px;">
                        ₹<?= number_format((float)$e['net_salary'], 2) ?>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
                <tfoot class="bg-light">
                  <tr>
                    <th colspan="6" class="pl-4 font-weight-bold text-dark">Total Net Payout</th>
                    <th class="text-right pr-4 font-weight-bold text-success" style="font-size: 15px;">
                      ₹<?= number_format((float)$activeRun['total_net_payout'], 2) ?>
                    </th>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>
        </div>
      </div>

      <!-- TAB 2: Master Payroll Register -->
      <div class="tab-pane fade" id="register" role="tabpanel">
        <div class="card border-0 shadow-sm" style="border-radius: 14px; background: #ffffff;">
          <div class="card-header bg-transparent border-0 pt-3 pb-2 d-flex justify-content-between align-items-center">
            <div>
              <h5 class="font-weight-bold text-dark mb-0" style="font-size: 16px;">
                <i class="fas fa-file-invoice mr-2 text-primary"></i> Master Compensation Register
              </h5>
              <small class="text-muted">Full breakdown of days, earnings, LOP deductions, statutory items, and net pay.</small>
            </div>
            <div>
              <a href="<?= base_url('admin/payroll/export_register_csv/' . $activeRun['payroll_run_id']) ?>" class="btn btn-sm btn-outline-primary font-weight-bold" style="border-radius: 6px;">
                <i class="fas fa-download mr-1"></i> Download Register CSV
              </a>
            </div>
          </div>
          <div class="card-body p-0">
            <div class="table-responsive">
              <table class="table table-hover align-middle mb-0 text-nowrap" style="font-size: 12.5px;">
                <thead style="background: #f8fafc; color: #475569; font-weight: 600;">
                  <tr>
                    <th class="pl-4">Employee</th>
                    <th>Fixed CTC</th>
                    <th>Paid / LOP</th>
                    <th>Gross Payable</th>
                    <th>LOP Loss</th>
                    <th>Deductions</th>
                    <th>Employer Contrib</th>
                    <th class="text-right pr-4">Net Salary</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($employees as $e): ?>
                    <tr>
                      <td class="pl-4 font-weight-bold">
                        <span class="text-dark"><?= esc($e['emp_name']) ?></span>
                        <small class="d-block text-muted font-weight-bold"><?= esc($e['emp_id']) ?></small>
                      </td>
                      <td class="font-weight-bold text-dark">
                        ₹<?= number_format((float)$e['monthly_ctc'], 2) ?>
                      </td>
                      <td>
                        <span class="badge badge-light border">
                          <?= (float)$e['paid_days'] ?> / <?= (float)$e['total_days'] ?>
                        </span>
                        <?php if ((float)$e['lop_days'] > 0): ?>
                          <span class="badge badge-danger ml-1"><?= (float)$e['lop_days'] ?> LOP</span>
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
                      <td class="text-info">
                        ₹<?= number_format((float)$e['employer_contributions'], 2) ?>
                      </td>
                      <td class="text-right pr-4 font-weight-bold text-success" style="font-size: 13.5px;">
                        ₹<?= number_format((float)$e['net_salary'], 2) ?>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

  <?php endif; ?>

</div>
