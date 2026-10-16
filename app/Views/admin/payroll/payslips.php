<div class="content-wrapper" style="min-height: 800px; padding: 20px 24px;">
  
  <div class="content-header p-0 mb-3">
    <div class="container-fluid p-0">
      <div class="row align-items-center">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark font-weight-bold" style="font-size: 24px; letter-spacing: -0.02em;">
            <i class="fas fa-file-invoice-dollar text-primary mr-2"></i> Payslip Management Center
          </h1>
          <p class="text-muted small mb-0 mt-1">
            Browse, print, download, and publish immutable monthly employee payslips.
          </p>
        </div>
        <div class="col-sm-6 text-right">
          <span class="badge badge-light border text-dark font-weight-bold p-2" style="font-size: 13px;">
            Total Payslips: <?= count($payslips) ?>
          </span>
        </div>
      </div>
    </div>
  </div>

  <?= view('admin/payroll/payroll_nav') ?>

  <?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert" style="border-radius: 10px;">
      <i class="fas fa-check-circle mr-2"></i> <?= session()->getFlashdata('success') ?>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    </div>
  <?php endif; ?>

  <!-- Filter Card -->
  <div class="card border-0 shadow-sm mb-4" style="border-radius: 14px; background: #ffffff;">
    <div class="card-body p-3">
      <form method="get" action="<?= base_url('admin/payroll/payslips') ?>" class="form-row align-items-end">
        <div class="col-md-3 col-sm-6 mb-2 mb-md-0">
          <label class="font-weight-bold small text-muted">Filter by Month</label>
          <select name="month" class="form-control form-control-sm" style="border-radius: 6px;">
            <option value="">All Months</option>
            <?php for ($m = 1; $m <= 12; $m++): ?>
              <option value="<?= $m ?>" <?= ($month == $m) ? 'selected' : '' ?>>
                <?= date('F', mktime(0, 0, 0, $m, 10)) ?>
              </option>
            <?php endfor; ?>
          </select>
        </div>
        <div class="col-md-2 col-sm-6 mb-2 mb-md-0">
          <label class="font-weight-bold small text-muted">Filter by Year</label>
          <select name="year" class="form-control form-control-sm" style="border-radius: 6px;">
            <option value="">All Years</option>
            <option value="2026" <?= ($year == 2026) ? 'selected' : '' ?>>2026</option>
            <option value="2025" <?= ($year == 2025) ? 'selected' : '' ?>>2025</option>
          </select>
        </div>
        <div class="col-md-4 col-sm-8 mb-2 mb-md-0">
          <label class="font-weight-bold small text-muted">Search Employee / Number</label>
          <input type="text" name="search" class="form-control form-control-sm" placeholder="Search Emp ID, Name, or PS Number..." value="<?= esc($search) ?>" style="border-radius: 6px;">
        </div>
        <div class="col-md-3 col-sm-4 text-right">
          <button type="submit" class="btn btn-sm btn-primary px-3 font-weight-bold" style="border-radius: 6px;">
            <i class="fas fa-filter mr-1"></i> Apply Filter
          </button>
          <?php if ($month || $year || $search || $runId): ?>
            <a href="<?= base_url('admin/payroll/payslips') ?>" class="btn btn-sm btn-light border px-2 font-weight-bold" style="border-radius: 6px;">Reset</a>
          <?php endif; ?>
        </div>
      </form>
    </div>
  </div>

  <!-- Payslip Master Table -->
  <div class="card border-0 shadow-sm" style="border-radius: 14px; background: #ffffff;">
    <div class="card-header bg-transparent border-0 pt-3 pb-2">
      <h5 class="font-weight-bold text-dark mb-0" style="font-size: 16px;">
        <i class="fas fa-file-invoice mr-2 text-primary"></i> Generated Digital Payslips (<?= count($payslips) ?>)
      </h5>
      <small class="text-muted">Click <strong>"View Payslip"</strong> to preview the executive print layout.</small>
    </div>

    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0 text-nowrap" style="font-size: 13px;">
          <thead style="background: #f8fafc; color: #475569; font-weight: 600;">
            <tr>
              <th class="pl-4">Payslip Number</th>
              <th>Employee</th>
              <th>Period Month</th>
              <th>Paid Days / LOP</th>
              <th>Gross Earnings</th>
              <th>Deductions</th>
              <th>Net Payout</th>
              <th>Generated Date</th>
              <th>Status</th>
              <th class="text-right pr-4">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($payslips)): ?>
              <tr>
                <td colspan="10" class="text-center py-5 text-muted">
                  No payslips generated yet for the selected criteria. Finalize a payroll run to generate payslips automatically.
                </td>
              </tr>
            <?php else: ?>
              <?php foreach ($payslips as $ps): ?>
                <tr>
                  <td class="pl-4 font-weight-bold text-primary">
                    <i class="fas fa-file-invoice mr-1 text-muted"></i>
                    <?= esc($ps['payslip_number']) ?>
                  </td>
                  <td>
                    <span class="font-weight-bold text-dark"><?= esc($ps['emp_name']) ?></span>
                    <small class="d-block text-muted font-weight-bold"><?= esc($ps['emp_id']) ?> &bull; <?= esc($ps['department_name'] ?? 'General') ?></small>
                  </td>
                  <td>
                    <strong><?= date('F Y', mktime(0, 0, 0, $ps['payroll_month'], 10, $ps['payroll_year'])) ?></strong>
                    <small class="d-block text-muted"><?= date('d M', strtotime($ps['period_start'])) ?> - <?= date('d M Y', strtotime($ps['period_end'])) ?></small>
                  </td>
                  <td>
                    <span class="badge badge-light border font-weight-bold">
                      <?= (float)$ps['paid_days'] ?> Paid
                    </span>
                    <?php if ((float)$ps['lop_days'] > 0): ?>
                      <span class="badge badge-danger ml-1 font-weight-bold"><?= (float)$ps['lop_days'] ?> LOP</span>
                    <?php endif; ?>
                  </td>
                  <td class="font-weight-bold text-dark">
                    ₹<?= number_format((float)$ps['gross_earnings'], 2) ?>
                  </td>
                  <td class="text-danger">
                    -₹<?= number_format((float)$ps['other_deductions'], 2) ?>
                  </td>
                  <td class="text-success font-weight-bold" style="font-size: 14px;">
                    ₹<?= number_format((float)$ps['net_salary'], 2) ?>
                  </td>
                  <td class="text-muted small">
                    <?= date('d M Y, h:i A', strtotime($ps['generated_at'])) ?>
                  </td>
                  <td>
                    <?php if ($ps['payslip_status'] === 'GENERATED'): ?>
                      <span class="badge badge-success px-2 py-1 font-weight-normal"><i class="fas fa-check mr-1"></i> Generated</span>
                    <?php elseif ($ps['payslip_status'] === 'PUBLISHED'): ?>
                      <span class="badge badge-primary px-2 py-1 font-weight-normal"><i class="fas fa-globe mr-1"></i> Published</span>
                    <?php else: ?>
                      <span class="badge badge-secondary px-2 py-1 font-weight-normal">Void</span>
                    <?php endif; ?>
                  </td>
                  <td class="text-right pr-4">
                    <a href="<?= base_url('admin/payroll/payslip/' . $ps['payroll_run_id'] . '/' . $ps['emp_id']) ?>" target="_blank" class="btn btn-sm btn-primary px-3 shadow-sm font-weight-bold" style="border-radius: 6px;">
                      <i class="fas fa-eye mr-1"></i> View Payslip
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
