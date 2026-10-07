<div class="content-wrapper p-3">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2 align-items-center">
        <div class="col-sm-6">
          <h1 class="m-0 font-weight-bold text-dark"><i class="fas fa-calculator text-primary mr-2"></i>Payroll Processing Cycles</h1>
          <p class="text-muted small mb-0">Manage monthly payroll cycles, attendance imports, salary structures, and frozen payouts.</p>
        </div>
        <div class="col-sm-6 text-right">
          <a href="<?= base_url('admin/payroll/components') ?>" class="btn btn-outline-secondary btn-sm mr-2"><i class="fas fa-cogs mr-1"></i> Salary Components</a>
          <a href="<?= base_url('admin/payroll/structures') ?>" class="btn btn-outline-info btn-sm mr-2"><i class="fas fa-id-card mr-1"></i> Salary Structures</a>
          <button class="btn btn-primary btn-sm font-weight-bold" data-toggle="modal" data-target="#createCycleModal"><i class="fas fa-plus mr-1"></i> Create Payroll Cycle</button>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <i class="fas fa-check-circle mr-2"></i><?= session()->getFlashdata('success') ?>
          <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
      <?php endif; ?>
      <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <i class="fas fa-exclamation-circle mr-2"></i><?= session()->getFlashdata('error') ?>
          <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
      <?php endif; ?>

      <div class="card card-outline card-primary shadow-sm border-0">
        <div class="card-header bg-white border-bottom-0 pt-3">
          <h3 class="card-title font-weight-bold text-secondary"><i class="fas fa-history mr-2"></i>Active & Past Payroll Cycles</h3>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-hover table-striped align-middle mb-0">
              <thead class="bg-light text-uppercase text-secondary small">
                <tr>
                  <th>Cycle Code</th>
                  <th>Period Range</th>
                  <th>Pay Date</th>
                  <th class="text-center">Employees</th>
                  <th class="text-right">Total Gross</th>
                  <th class="text-right">Total Deductions</th>
                  <th class="text-right">Total Net</th>
                  <th class="text-center">Workflow Status</th>
                  <th class="text-center">Action</th>
                </tr>
              </thead>
              <tbody>
                <?php if (!empty($cycles)): ?>
                  <?php foreach ($cycles as $c): ?>
                    <tr>
                      <td class="font-weight-bold text-primary">
                        <i class="fas fa-calendar-alt text-muted mr-1"></i> <?= esc($c['payroll_code']) ?>
                      </td>
                      <td><?= esc($c['period_start']) ?> to <?= esc($c['period_end']) ?></td>
                      <td><span class="badge badge-light border"><?= esc($c['pay_date'] ?: 'N/A') ?></span></td>
                      <td class="text-center font-weight-bold"><?= number_format($c['total_employees']) ?></td>
                      <td class="text-right font-weight-bold">₹<?= number_format($c['total_gross'], 2) ?></td>
                      <td class="text-right text-danger font-weight-bold">₹<?= number_format($c['total_deductions'], 2) ?></td>
                      <td class="text-right text-success font-weight-bold">₹<?= number_format($c['total_net'], 2) ?></td>
                      <td class="text-center">
                        <?php
                          $st = $c['status'];
                          $badgeClass = 'badge-secondary';
                          if ($st == 'DRAFT') $badgeClass = 'badge-secondary';
                          elseif ($st == 'ATTENDANCE_IMPORTED') $badgeClass = 'badge-info';
                          elseif ($st == 'CALCULATED') $badgeClass = 'badge-primary';
                          elseif ($st == 'HR_REVIEW') $badgeClass = 'badge-warning';
                          elseif ($st == 'SUBMITTED') $badgeClass = 'badge-info';
                          elseif ($st == 'APPROVED') $badgeClass = 'badge-success';
                          elseif ($st == 'LOCKED') $badgeClass = 'badge-dark';
                        ?>
                        <span class="badge <?= $badgeClass ?> px-3 py-1"><?= esc($st) ?></span>
                      </td>
                      <td class="text-center">
                        <a href="<?= base_url('admin/payroll/view/' . $c['id']) ?>" class="btn btn-sm btn-outline-primary shadow-sm font-weight-bold">
                          <i class="fas fa-folder-open mr-1"></i> Process / View
                        </a>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr>
                    <td colspan="9" class="text-center text-muted py-4">No payroll cycles created yet. Click "Create Payroll Cycle" to begin.</td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<!-- Modal: Create Payroll Cycle -->
<div class="modal fade" id="createCycleModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="<?= base_url('admin/payroll/create') ?>" method="POST">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-header-title font-weight-bold m-0"><i class="fas fa-calendar-plus mr-2"></i> Create New Payroll Cycle</h5>
          <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close"><span>&times;</span></button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label class="font-weight-bold">Payroll Cycle Code / Name <span class="text-danger">*</span></label>
            <input type="text" name="payroll_code" class="form-control" placeholder="e.g. AUG-2026 (25 Jul - 24 Aug)" required value="AUG-2026">
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label class="font-weight-bold">Period Start Date <span class="text-danger">*</span></label>
              <input type="date" name="period_start" class="form-control" required value="2026-07-25">
            </div>
            <div class="form-group col-md-6">
              <label class="font-weight-bold">Period End Date <span class="text-danger">*</span></label>
              <input type="date" name="period_end" class="form-control" required value="2026-08-24">
            </div>
          </div>
          <div class="form-group">
            <label class="font-weight-bold">Expected Pay Date</label>
            <input type="date" name="pay_date" class="form-control" value="2026-08-31">
          </div>
        </div>
        <div class="modal-footer bg-light">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary font-weight-bold"><i class="fas fa-check mr-1"></i> Create Cycle</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
