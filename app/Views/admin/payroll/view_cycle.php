<div class="content-wrapper p-3">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2 align-items-center">
        <div class="col-sm-6">
          <h1 class="m-0 font-weight-bold text-dark">
            <a href="<?= base_url('admin/payroll') ?>" class="text-secondary mr-2"><i class="fas fa-arrow-left"></i></a>
            Payroll Cycle: <?= esc($cycle['payroll_code']) ?>
          </h1>
          <p class="text-muted small mb-0">Payroll Period: <strong><?= esc($cycle['period_start']) ?></strong> to <strong><?= esc($cycle['period_end']) ?></strong> | Pay Date: <strong><?= esc($cycle['pay_date'] ?: 'N/A') ?></strong></p>
        </div>
        <div class="col-sm-6 text-right">
          <?php if ($cycle['status'] !== 'LOCKED'): ?>
            <button class="btn btn-outline-primary btn-sm mr-2" data-toggle="modal" data-target="#importAttendanceModal"><i class="fas fa-file-import mr-1"></i> Import Attendance</button>
            <a href="<?= base_url('admin/payroll/calculate/' . $cycle['id']) ?>" class="btn btn-outline-info btn-sm mr-2 font-weight-bold"><i class="fas fa-sync-alt mr-1"></i> Recalculate All</a>

            <!-- Mode: Finalize & Generate Official Payslips -->
            <form action="<?= base_url('admin/payroll/update_status') ?>" method="POST" class="d-inline">
              <input type="hidden" name="payroll_cycle_id" value="<?= $cycle['id'] ?>">
              <input type="hidden" name="status" value="LOCKED">
              <button type="submit" class="btn btn-success btn-sm font-weight-bold mr-1 shadow-sm" onclick="return confirm('Are you sure you want to finalize this payroll? This will freeze all figures and generate permanent payslips for employees.')"><i class="fas fa-lock mr-1"></i> Finalize & Generate Payslips</button>
            </form>
          <?php else: ?>
            <span class="badge badge-dark px-3 py-2 font-weight-bold shadow-sm" style="font-size: 0.95rem;"><i class="fas fa-check-circle text-success mr-1"></i> PAYROLL FINALIZED & LOCKED (Payslips Generated)</span>
          <?php endif; ?>
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

      <!-- Stat Cards -->
      <div class="row">
        <div class="col-md-3 col-sm-6 col-12">
          <div class="info-box bg-white shadow-sm border-0">
            <span class="info-box-icon bg-primary text-white"><i class="fas fa-users"></i></span>
            <div class="info-box-content">
              <span class="info-box-text text-muted font-weight-bold">Total Employees</span>
              <span class="info-box-number text-dark h4 m-0 font-weight-bold"><?= number_format($cycle['total_employees']) ?></span>
            </div>
          </div>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
          <div class="info-box bg-white shadow-sm border-0">
            <span class="info-box-icon bg-info text-white"><i class="fas fa-money-bill-wave"></i></span>
            <div class="info-box-content">
              <span class="info-box-text text-muted font-weight-bold">Total Gross Pay</span>
              <span class="info-box-number text-info h4 m-0 font-weight-bold">₹<?= number_format($cycle['total_gross'], 2) ?></span>
            </div>
          </div>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
          <div class="info-box bg-white shadow-sm border-0">
            <span class="info-box-icon bg-danger text-white"><i class="fas fa-minus-circle"></i></span>
            <div class="info-box-content">
              <span class="info-box-text text-muted font-weight-bold">Total Deductions</span>
              <span class="info-box-number text-danger h4 m-0 font-weight-bold">₹<?= number_format($cycle['total_deductions'], 2) ?></span>
            </div>
          </div>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
          <div class="info-box bg-white shadow-sm border-0">
            <span class="info-box-icon bg-success text-white"><i class="fas fa-wallet"></i></span>
            <div class="info-box-content">
              <span class="info-box-text text-muted font-weight-bold">Total Net Pay</span>
              <span class="info-box-number text-success h4 m-0 font-weight-bold">₹<?= number_format($cycle['total_net'], 2) ?></span>
            </div>
          </div>
        </div>
      </div>

      <!-- Navigation Tabs: Employee Payroll & Employee Attendance -->
      <ul class="nav nav-tabs font-weight-bold mb-3 bg-white p-2 rounded shadow-sm" id="payrollViewTabs" role="tablist">
        <li class="nav-item">
          <a class="nav-link active text-primary" id="payroll-grid-tab" data-toggle="tab" href="#payroll-grid-panel" role="tab">
            <i class="fas fa-calculator mr-2"></i> Employee Payroll Grid
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-info" id="attendance-matrix-tab" data-toggle="tab" href="#attendance-matrix-panel" role="tab">
            <i class="fas fa-calendar-alt mr-2"></i> Employee Daily Attendance Matrix
          </a>
        </li>
      </ul>

      <div class="tab-content" id="payrollViewTabsContent">
        <!-- Tab 1: Employee Payroll Grid -->
        <div class="tab-pane fade show active" id="payroll-grid-panel" role="tabpanel">
          <div class="card card-outline card-primary shadow-sm border-0">
            <div class="card-header bg-white d-flex align-items-center justify-content-between pt-3">
              <h3 class="card-title font-weight-bold text-secondary m-0"><i class="fas fa-table mr-2"></i> Employee Payroll Draft Grid</h3>
              <div class="card-tools d-flex">
                <button class="btn btn-outline-secondary btn-sm mr-2" data-toggle="modal" data-target="#addAdjustmentModal" <?= in_array($cycle['status'], ['LOCKED']) ? 'disabled' : '' ?>><i class="fas fa-plus-circle mr-1"></i> Add HR Adjustment</button>
                <input type="text" id="gridSearch" class="form-control form-control-sm" placeholder="Search employee..." style="width: 200px;">
              </div>
            </div>
            <div class="card-body p-0">
              <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="payrollGridTa                  <thead class="bg-light text-uppercase text-secondary small">
                    <tr>
                      <th>Emp ID</th>
                      <th>Employee Name</th>
                      <th class="text-center">Month Days</th>
                      <th class="text-center text-success">Present</th>
                      <th class="text-center text-warning">Holidays/Offs</th>
                      <th class="text-center text-primary">Paid Days</th>
                      <th class="text-center text-danger">LOP</th>
                      <th class="text-right">Salary Basis</th>
                      <th class="text-right">Gross Pay</th>
                      <th class="text-right text-danger">Deductions</th>
                      <th class="text-right text-success">Net Pay</th>
                      <th class="text-center">Ver</th>
                      <th class="text-center">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if (!empty($employees)): ?>
                      <?php foreach ($employees as $emp): ?>
                        <?php
                          $mDays    = (int)$emp['working_days'];
                          $pDays    = (int)$emp['present_days'];
                          $hDays    = (int)($emp['holiday_days'] + $emp['weekly_off_days']);
                          $lDays    = (int)$emp['lop_days'];
                          $paidDays = max(0, $mDays - $lDays);
                        ?>
                        <tr>
                          <td class="font-weight-bold text-primary"><?= esc($emp['emp_id']) ?></td>
                          <td>
                            <div class="font-weight-bold text-dark"><?= esc($emp['employee_name']) ?></div>
                            <span class="small text-muted"><?= esc($emp['department'] ?: 'General') ?></span>
                          </td>
                          <td class="text-center font-weight-bold"><?= $mDays ?></td>
                          <td class="text-center text-success font-weight-bold"><?= $pDays ?></td>
                          <td class="text-center text-warning font-weight-bold"><?= $hDays ?></td>
                          <td class="text-center text-primary font-weight-bold"><?= $paidDays ?></td>
                          <td class="text-center text-danger font-weight-bold"><?= $lDays ?></td>
                          <td class="text-right">₹<?= number_format($emp['salary_basis'], 2) ?></td>
                          <td class="text-right font-weight-bold">₹<?= number_format($emp['gross_salary'], 2) ?></td>
                          <td class="text-right text-danger font-weight-bold">₹<?= number_format($emp['total_deductions'], 2) ?></td>
                          <td class="text-right text-success font-weight-bold">₹<?= number_format($emp['net_salary'], 2) ?></td>
                          <td class="text-center"><span class="badge badge-light border">v<?= esc($emp['calculation_version']) ?></span></td>
                          <td class="text-center">
                            <button class="btn btn-sm btn-outline-info shadow-sm view-emp-detail mr-1" data-empid="<?= esc($emp['emp_id']) ?>" title="Inspect & Edit LOP / Salary"><i class="fas fa-edit mr-1"></i> Inspect</button>
                            <a href="<?= base_url('employee/new_emp_payslip/' . $emp['emp_id'] . '/' . date('F', strtotime($cycle['period_end'])) . '/' . date('Y', strtotime($cycle['period_end']))) ?>" target="_blank" class="btn btn-sm btn-outline-secondary shadow-sm" title="View/Print Payslip"><i class="fas fa-print"></i></a>
                          </td>
                        </tr>
                      <?php endforeach; ?>
                    <?php else: ?>
                      <tr>
                        <td colspan="13" class="text-center text-muted py-4">No calculated payroll records found. Please click "Import Attendance" or "Recalculate Salary".</td>
                      </tr>
                    <?php endif; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

        <!-- Tab 2: Employee Daily Attendance Matrix -->
        <div class="tab-pane fade" id="attendance-matrix-panel" role="tabpanel">
          <div class="card card-outline card-info shadow-sm border-0">
            <div class="card-header bg-white pt-3 d-flex align-items-center justify-content-between">
              <h3 class="card-title font-weight-bold text-secondary mb-0">
                <i class="fas fa-calendar-check text-info mr-2"></i> Employee Daily Attendance Matrix (Cycle Period)
              </h3>
              <span class="badge badge-info"><i class="fas fa-arrows-alt-h mr-1"></i> Horizontal Scroll Table</span>
            </div>
            <div class="card-body p-0">
              <div style="overflow-x: auto; white-space: nowrap; max-width: 100%;">
                <table class="table table-bordered table-sm align-middle text-center mb-0" id="attendanceMatrixTable">
                  <thead class="bg-light small text-uppercase">
                    <tr>
                      <th style="position: sticky; left: 0; background: #f8f9fa; z-index: 2; min-width: 100px;" class="shadow-sm">Emp ID</th>
                      <th style="position: sticky; left: 100px; background: #f8f9fa; z-index: 2; min-width: 180px;" class="text-left shadow-sm">Employee Name</th>
                      <?php if (!empty($attendance_matrix['dates'])): ?>
                        <?php foreach ($attendance_matrix['dates'] as $d): ?>
                          <th style="min-width: 48px; font-size: 0.75rem;">
                            <?= date('d', strtotime($d)) ?><br>
                            <small class="text-muted"><?= date('D', strtotime($d)) ?></small>
                          </th>
                        <?php endforeach; ?>
                      <?php endif; ?>
                    </tr>
                  </thead>
                  <tbody class="small">
                    <?php if (!empty($attendance_matrix['matrix'])): ?>
                      <?php foreach ($attendance_matrix['matrix'] as $row): ?>
                        <tr>
                          <td style="position: sticky; left: 0; background: #ffffff; z-index: 1;" class="font-weight-bold text-primary shadow-sm"><?= esc($row['emp_id']) ?></td>
                          <td style="position: sticky; left: 100px; background: #ffffff; z-index: 1;" class="text-left font-weight-bold text-dark shadow-sm"><?= esc($row['emp_name']) ?></td>
                          <?php foreach ($attendance_matrix['dates'] as $d): ?>
                            <?php 
                              $dayInfo = $row['days'][$d] ?? null;
                              $st = $dayInfo ? strtoupper($dayInfo['status']) : '-';
                              $badgeBg = 'badge-secondary';
                              if (in_array($st, ['PRESENT', 'P'])) { $st = 'P'; $badgeBg = 'badge-success'; }
                              elseif (in_array($st, ['ABSENT', 'A', 'LOP'])) { $st = 'A'; $badgeBg = 'badge-danger'; }
                              elseif (in_array($st, ['HOLIDAY', 'HO'])) { $st = 'H'; $badgeBg = 'badge-warning'; }
                              elseif (in_array($st, ['WO', 'OFF'])) { $st = 'OFF'; $badgeBg = 'badge-light text-muted border'; }
                            ?>
                            <td>
                              <span class="badge <?= $badgeBg ?>" style="font-size: 0.75rem; padding: 4px 6px;" title="<?= esc($d) ?>: <?= esc($st) ?>"><?= esc($st) ?></span>
                            </td>
                          <?php endforeach; ?>
                        </tr>
                      <?php endforeach; ?>
                    <?php else: ?>
                      <tr>
                        <td colspan="100%" class="text-center text-muted py-4">No daily attendance records available for this period.</td>
                      </tr>
                    <?php endif; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>
</div>

<!-- Modal: Import Attendance -->
<div class="modal fade" id="importAttendanceModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="<?= base_url('admin/payroll/import_attendance/' . $cycle['id']) ?>" method="POST" enctype="multipart/form-data">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-header-title font-weight-bold m-0"><i class="fas fa-file-import mr-2"></i> Import Attendance for Cycle</h5>
          <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
        </div>
        <div class="modal-body">
          <p class="text-muted small">Upload employee monthly work duration CSV report (Columns: <code>emp_id, attendance_date, status, worked_hours</code>) or click Submit to auto-populate from active employees.</p>
          <div class="form-group">
            <label class="font-weight-bold">Excel/CSV File (Optional)</label>
            <input type="file" name="excel_file" class="form-control-file border p-2 rounded w-100" accept=".csv, .xls, .xlsx">
          </div>
        </div>
        <div class="modal-footer bg-light">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary font-weight-bold"><i class="fas fa-upload mr-1"></i> Import & Process</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal: Add HR Adjustment -->
<div class="modal fade" id="addAdjustmentModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="<?= base_url('admin/payroll/add_adjustment') ?>" method="POST">
        <input type="hidden" name="payroll_cycle_id" value="<?= $cycle['id'] ?>">
        <div class="modal-header bg-secondary text-white">
          <h5 class="modal-header-title font-weight-bold m-0"><i class="fas fa-edit mr-2"></i> Add HR Payroll Adjustment Line</h5>
          <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label class="font-weight-bold">Select Employee <span class="text-danger">*</span></label>
            <select name="emp_id" class="form-control" required>
              <option value="">-- Choose Employee --</option>
              <?php foreach ($employees as $e): ?>
                <option value="<?= esc($e['emp_id']) ?>"><?= esc($e['emp_id']) ?> - <?= esc($e['employee_name']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label class="font-weight-bold">Adjustment Type <span class="text-danger">*</span></label>
              <select name="adjustment_type" class="form-control" required>
                <option value="EARNING">Addition / Earning (+)</option>
                <option value="DEDUCTION">Deduction (-)</option>
              </select>
            </div>
            <div class="form-group col-md-6">
              <label class="font-weight-bold">Component (Optional)</label>
              <select name="component_id" class="form-control">
                <option value="">-- General Adjustment --</option>
                <?php foreach ($components as $c): ?>
                  <option value="<?= $c['id'] ?>"><?= esc($c['component_name']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="font-weight-bold">Adjustment Amount (₹) <span class="text-danger">*</span></label>
            <input type="number" step="0.01" name="amount" class="form-control" placeholder="e.g. 2000.00" required>
          </div>
          <div class="form-group">
            <label class="font-weight-bold">HR Reason / Audit Note <span class="text-danger">*</span></label>
            <textarea name="reason" class="form-control" rows="2" placeholder="e.g. Performance Incentive / Special Allowance" required></textarea>
          </div>
        </div>
        <div class="modal-footer bg-light">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-success font-weight-bold"><i class="fas fa-save mr-1"></i> Apply & Recalculate</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal: Employee Payroll Detail & Audit Inspection -->
<div class="modal fade" id="empDetailModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-info text-white">
        <h5 class="modal-header-title font-weight-bold m-0"><i class="fas fa-user-edit mr-2"></i> Employee Payroll Audit & Draft Editor</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close"><span>&times;</span></button>
      </div>
      <div class="modal-body" id="empDetailBody">
        <div class="text-center py-4"><i class="fas fa-spinner fa-spin fa-2x text-info"></i><p class="mt-2 text-muted">Loading calculation details...</p></div>
      </div>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const searchInput = document.getElementById('gridSearch');
  if (searchInput) {
    searchInput.addEventListener('keyup', function() {
      const value = this.value.toLowerCase();
      const rows = document.querySelectorAll('#payrollGridTable tbody tr');
      rows.forEach(r => {
        const text = r.innerText.toLowerCase();
        r.style.display = text.includes(value) ? '' : 'none';
      });
    });
  }

  // Inspect detail & draft edit handler
  document.querySelectorAll('.view-emp-detail').forEach(btn => {
    btn.addEventListener('click', function() {
      const empId = this.dataset.empid;
      $('#empDetailModal').modal('show');
      fetch('<?= base_url('admin/payroll/employee_detail/' . $cycle['id']) ?>/' + empId)
        .then(res => res.json())
        .then(data => {
          if (data.status === 'success') {
            const p = data.payroll || {};
            const isLocked = <?= json_encode($cycle['status'] === 'LOCKED') ?>;
            const monthDays = Math.round(p.working_days || 31);
            const holidayDays = Math.round(p.holiday_days || 0);
            const weeklyOffDays = Math.round(p.weekly_off_days || 0);
            const totalHolidays = holidayDays + weeklyOffDays;
            const officeWorkingDays = Math.max(0, monthDays - totalHolidays);
            const presentDays = Math.round(p.present_days || 0);
            const lopDays = Math.round(p.lop_days || 0);
            const paidDays = Math.max(0, monthDays - lopDays);

            let html = `
              <div class="row">
                <div class="col-md-6">
                  <h6 class="font-weight-bold text-primary mb-2"><i class="fas fa-info-circle mr-1"></i> Calculation Summary (v${p.calculation_version || 1})</h6>
                  <ul class="list-group list-group-flush mb-3 border rounded">
                    <li class="list-group-item d-flex justify-content-between py-2"><span>Employee Name:</span> <strong>${p.employee_name || ''} (${p.emp_id || ''})</strong></li>
                    <li class="list-group-item d-flex justify-content-between py-2"><span>Total Month Days:</span> <strong>${monthDays} days</strong></li>
                    <li class="list-group-item d-flex justify-content-between py-2 text-warning"><span>Holidays & Offs:</span> <strong>${totalHolidays} days (${holidayDays} Hol + ${weeklyOffDays} Off)</strong></li>
                    <li class="list-group-item d-flex justify-content-between py-2"><span>Office Working Days:</span> <strong>${officeWorkingDays} days</strong></li>
                    <li class="list-group-item d-flex justify-content-between py-2 text-success"><span>Present Days (Office):</span> <strong>${presentDays} days</strong></li>
                    <li class="list-group-item d-flex justify-content-between py-2 text-primary font-weight-bold"><span>Total Paid Days:</span> <strong id="summary_paid_days">${paidDays} days</strong></li>
                    <li class="list-group-item d-flex justify-content-between py-2 text-danger"><span>LOP / Absent Days:</span> <strong id="summary_lop_days">${lopDays} days</strong></li>
                    <li class="list-group-item d-flex justify-content-between py-2"><span>Salary Basis:</span> <strong>₹${parseFloat(p.salary_basis || 0).toLocaleString('en-IN', {minimumFractionDigits: 2})}</strong></li>
                    <li class="list-group-item d-flex justify-content-between py-2 text-danger"><span>Leave Deduction:</span> <strong>₹${parseFloat(p.leave_deduction || 0).toLocaleString('en-IN', {minimumFractionDigits: 2})}</strong></li>
                  </ul>
                </div>
                <div class="col-md-6">
                  <h6 class="font-weight-bold text-success mb-2"><i class="fas fa-coins mr-1"></i> Financial Snapshot</h6>
                  <ul class="list-group list-group-flush mb-3 border rounded">
                    <li class="list-group-item d-flex justify-content-between py-2 font-weight-bold"><span>Total Earnings:</span> <span class="text-info">₹${parseFloat(p.total_earnings || 0).toLocaleString('en-IN', {minimumFractionDigits: 2})}</span></li>
                    <li class="list-group-item d-flex justify-content-between py-2 font-weight-bold"><span>Total Deductions:</span> <span class="text-danger">₹${parseFloat(p.total_deductions || 0).toLocaleString('en-IN', {minimumFractionDigits: 2})}</span></li>
                    <li class="list-group-item d-flex justify-content-between py-2 font-weight-bold h5 mb-0 bg-light"><span>Net Take-Home Pay:</span> <span class="text-success">₹${parseFloat(p.net_salary || 0).toLocaleString('en-IN', {minimumFractionDigits: 2})}</span></li>
                  </ul>
                </div>
              </div>
            `;

            if (data.adjustments && data.adjustments.length > 0) {
              html += `<h6 class="font-weight-bold text-secondary mt-2 mb-1"><i class="fas fa-list mr-1"></i> Applied HR Adjustments</h6><table class="table table-sm border mb-3"><thead><tr class="bg-light"><th>Type</th><th>Component</th><th>Amount</th><th>Reason</th></tr></thead><tbody>`;
              data.adjustments.forEach(a => {
                html += `<tr><td><span class="badge badge-${a.adjustment_type=='EARNING'?'success':'danger'}">${a.adjustment_type}</span></td><td>${a.component_name || 'General'}</td><td>₹${a.amount}</td><td>${a.reason}</td></tr>`;
              });
              html += `</tbody></table>`;
            }

            if (!isLocked) {
              html += `
                <hr>
                <form action="<?= base_url('admin/payroll/save_employee_draft') ?>" method="POST" id="employeeDraftForm">
                  <input type="hidden" name="payroll_cycle_id" value="<?= $cycle['id'] ?>">
                  <input type="hidden" name="emp_id" value="${p.emp_id || ''}">
                  <h6 class="font-weight-bold text-dark mb-2"><i class="fas fa-edit text-warning mr-1"></i> HR Draft Editor: Update Attendance / LOP Days & Salary</h6>
                  
                  <div class="row bg-light p-2 rounded mb-2 align-items-center">
                    <div class="col-md-4 form-group mb-0">
                      <label class="font-weight-bold small text-success">Present Days (Office)</label>
                      <input type="number" step="1" min="0" max="${officeWorkingDays}" id="modal_present_days" name="present_days" class="form-control form-control-sm font-weight-bold text-success" value="${presentDays}" required>
                      <small class="text-muted">Office Days: ${officeWorkingDays}</small>
                    </div>
                    <div class="col-md-4 form-group mb-0">
                      <label class="font-weight-bold small text-danger">LOP / Absent Days</label>
                      <input type="number" step="1" min="0" max="${officeWorkingDays}" id="modal_lop_days" name="lop_days" class="form-control form-control-sm font-weight-bold text-danger" value="${lopDays}" required>
                      <small class="text-muted">Deducted days</small>
                    </div>
                    <div class="col-md-4 form-group mb-0">
                      <label class="font-weight-bold small text-primary">Total Paid Days</label>
                      <input type="text" id="modal_paid_days_display" class="form-control form-control-sm font-weight-bold text-primary bg-white" value="${paidDays}" readonly>
                      <small class="text-muted" id="modal_paid_days_hint">Present (${presentDays}) + Hol (${totalHolidays})</small>
                    </div>
                  </div>

                  <div class="row bg-light p-2 rounded mb-2 align-items-center">
                    <div class="col-md-6 form-group mb-0">
                      <label class="font-weight-bold small text-success">Add Earning (+ ₹)</label>
                      <input type="number" step="0.01" name="manual_earnings_adj" class="form-control form-control-sm" placeholder="0.00">
                    </div>
                    <div class="col-md-6 form-group mb-0">
                      <label class="font-weight-bold small text-danger">Add Deduction (- ₹)</label>
                      <input type="number" step="0.01" name="manual_deductions_adj" class="form-control form-control-sm" placeholder="0.00">
                    </div>
                  </div>

                  <div class="form-group mb-2">
                    <label class="font-weight-bold small">Audit Reason / HR Remark <span class="text-danger">*</span></label>
                    <input type="text" name="reason" class="form-control form-control-sm" placeholder="e.g. Leave adjustment approved by HR" required>
                  </div>

                  <div class="text-right pt-2">
                    <button type="submit" class="btn btn-primary btn-sm font-weight-bold shadow-sm"><i class="fas fa-save mr-1"></i> Save Employee Draft</button>
                  </div>
                </form>
              `;
            }

            document.getElementById('empDetailBody').innerHTML = html;

            // Synchronized calculation taking into account holidays & office working days
            const modalLop = document.getElementById('modal_lop_days');
            const modalPresent = document.getElementById('modal_present_days');
            const modalPaid = document.getElementById('modal_paid_days_display');
            const modalPaidHint = document.getElementById('modal_paid_days_hint');
            const summaryPaid = document.getElementById('summary_paid_days');
            const summaryLop = document.getElementById('summary_lop_days');

            if (modalLop && modalPresent) {
              modalLop.addEventListener('input', function() {
                let lop = parseInt(this.value, 10);
                if (isNaN(lop) || lop < 0) lop = 0;
                if (officeWorkingDays > 0 && lop > officeWorkingDays) {
                  lop = officeWorkingDays;
                  this.value = lop;
                }
                const newPresent = Math.max(0, officeWorkingDays - lop);
                const newPaid = Math.max(0, monthDays - lop);
                modalPresent.value = newPresent;
                if (modalPaid) modalPaid.value = newPaid;
                if (modalPaidHint) modalPaidHint.innerText = `Present (${newPresent}) + Hol (${totalHolidays})`;
                if (summaryPaid) summaryPaid.innerText = `${newPaid} days`;
                if (summaryLop) summaryLop.innerText = `${lop} days`;
              });

              modalPresent.addEventListener('input', function() {
                let present = parseInt(this.value, 10);
                if (isNaN(present) || present < 0) present = 0;
                if (officeWorkingDays > 0 && present > officeWorkingDays) {
                  present = officeWorkingDays;
                  this.value = present;
                }
                const newLop = Math.max(0, officeWorkingDays - present);
                const newPaid = Math.min(monthDays, present + totalHolidays);
                modalLop.value = newLop;
                if (modalPaid) modalPaid.value = newPaid;
                if (modalPaidHint) modalPaidHint.innerText = `Present (${present}) + Hol (${totalHolidays})`;
                if (summaryPaid) summaryPaid.innerText = `${newPaid} days`;
                if (summaryLop) summaryLop.innerText = `${newLop} days`;
              });
            }
          }
        });
    });
  });
});
</script>
