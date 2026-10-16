<div class="content-wrapper" style="min-height: 800px; padding: 20px 24px;">
  
  <div class="content-header p-0 mb-3">
    <div class="container-fluid p-0">
      <div class="row align-items-center">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark font-weight-bold" style="font-size: 24px; letter-spacing: -0.02em;">
            <i class="fas fa-id-card-alt text-primary mr-2"></i> Employee Salary Structures Directory
          </h1>
          <p class="text-muted small mb-0 mt-1">
            Maintain employee-specific compensation structures, effective-date versioning, and approvals.
          </p>
        </div>
        <div class="col-sm-6 text-right">
          <span class="badge badge-light border text-dark font-weight-bold p-2 mr-2" style="font-size: 13px;">
            <i class="fas fa-users text-primary mr-1"></i> Active Employees: <?= count($structures) ?>
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

  <?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert" style="border-radius: 10px;">
      <i class="fas fa-exclamation-triangle mr-2"></i> <?= session()->getFlashdata('error') ?>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    </div>
  <?php endif; ?>

  <div class="card border-0 shadow-sm" style="border-radius: 14px; background: #ffffff;">
    <div class="card-header bg-transparent border-0 pt-3 pb-2 d-flex justify-content-between align-items-center">
      <div>
        <h5 class="font-weight-bold text-dark mb-0" style="font-size: 16px;">
          <i class="fas fa-table mr-2 text-primary"></i> Master Salary Structures Directory
        </h5>
        <small class="text-muted">Only approved structures for the effective payroll date are used during calculation.</small>
      </div>
      <div>
        <input type="text" id="structureSearch" class="form-control form-control-sm" placeholder="Quick search employee..." style="border-radius: 6px; width: 220px;">
      </div>
    </div>

    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0 text-nowrap" id="structuresTable" style="font-size: 13px;">
          <thead style="background: #f8fafc; color: #475569; font-weight: 600;">
            <tr>
              <th class="pl-4">Employee</th>
              <th>Department / Role</th>
              <th>Bank Account</th>
              <th>Structure Version</th>
              <th>Effective From</th>
              <th>Monthly CTC</th>
              <th>Approval Status</th>
              <th class="text-right pr-4">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($structures as $s): ?>
              <tr>
                <td class="pl-4 font-weight-bold">
                  <span class="text-dark"><?= esc($s['emp_name']) ?></span>
                  <small class="d-block text-muted font-weight-bold"><?= esc($s['emp_id']) ?></small>
                </td>
                <td>
                  <span class="badge badge-light border text-dark font-weight-normal"><?= esc($s['department_name'] ?? 'General') ?></span>
                  <small class="d-block text-muted"><?= esc($s['designation_name'] ?? 'Staff') ?></small>
                </td>
                <td>
                  <span class="font-weight-bold text-dark"><?= esc($s['bank_name'] ?: 'N/A') ?></span>
                  <small class="d-block text-muted"><?= esc($s['bank_account_no'] ?: '') ?></small>
                </td>
                <td>
                  <span class="badge badge-info px-2 py-1 font-weight-bold">
                    v<?= (int)($s['structure_version'] ?? 1) ?>
                  </span>
                </td>
                <td>
                  <i class="far fa-calendar-check text-success mr-1"></i>
                  <?= !empty($s['effective_from']) ? date('d M Y', strtotime($s['effective_from'])) : '&mdash;' ?>
                </td>
                <td class="font-weight-bold text-primary" style="font-size: 14px;">
                  ₹<?= number_format((float)($s['monthly_ctc'] ?? 0), 2) ?>
                </td>
                <td>
                  <?php if (($s['payroll_status'] ?? '') === 'APPROVED'): ?>
                    <span class="badge badge-success px-2 py-1 font-weight-normal"><i class="fas fa-check-circle mr-1"></i> Approved</span>
                  <?php else: ?>
                    <span class="badge badge-warning text-dark px-2 py-1 font-weight-normal">Draft</span>
                  <?php endif; ?>
                </td>
                <td class="text-right pr-4">
                  <button type="button" class="btn btn-sm btn-outline-primary px-3 font-weight-bold btn-revise-struct" data-emp="<?= esc($s['emp_id']) ?>" style="border-radius: 6px;">
                    <i class="fas fa-sliders-h mr-1"></i> Revise Salary
                  </button>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

</div>

<!-- Modal: Revise Salary Structure -->
<div class="modal fade" id="reviseStructureModal" tabindex="-1" role="dialog" aria-labelledby="reviseStructureModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content border-0 shadow" style="border-radius: 14px;">
      <form method="post" action="<?= base_url('admin/payroll/save_structure') ?>">
        <input type="hidden" name="emp_id" id="rev_emp_id">
        <div class="modal-header border-0 pb-0">
          <div>
            <h5 class="modal-title font-weight-bold text-dark" id="rev_emp_title">Revise Employee Salary Structure</h5>
            <small class="text-muted" id="rev_emp_subtitle">Employee ID</small>
          </div>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body py-3">
          <div class="form-row mb-3">
            <div class="col-md-6">
              <label class="font-weight-bold text-dark small">Monthly CTC (₹)</label>
              <div class="input-group">
                <div class="input-group-prepend"><span class="input-group-text bg-light font-weight-bold">₹</span></div>
                <input type="number" step="0.01" name="monthly_ctc" id="rev_monthly_ctc" class="form-control font-weight-bold text-primary" required style="font-size: 16px;">
              </div>
              <small class="text-muted">Enter total monthly cost-to-company to auto-split.</small>
            </div>
            <div class="col-md-6">
              <label class="font-weight-bold text-dark small">Effective From Date</label>
              <input type="date" name="effective_from" id="rev_effective_from" class="form-control" required value="<?= date('Y-m-01') ?>">
              <small class="text-muted">Effective date for new salary version.</small>
            </div>
          </div>

          <div class="d-flex justify-content-between align-items-center mb-2">
            <h6 class="font-weight-bold text-dark m-0 small text-uppercase" style="letter-spacing: 0.5px;">Component Breakdown</h6>
            <button type="button" class="btn btn-xs btn-outline-secondary" id="btnRecalculateSplit">
              <i class="fas fa-magic mr-1"></i> Auto-Calculate 50/20/8/5/17 Split
            </button>
          </div>

          <div class="table-responsive" style="max-height: 340px; overflow-y: auto;">
            <table class="table table-sm table-bordered text-nowrap mb-0" style="font-size: 13px;">
              <thead class="bg-light">
                <tr>
                  <th>Type</th>
                  <th>Component</th>
                  <th style="width: 140px;">Percentage (%)</th>
                  <th style="width: 170px;" class="text-right">Monthly Amount (₹)</th>
                </tr>
              </thead>
              <tbody id="structureComponentsBody">
                <tr><td colspan="4" class="text-center py-3 text-muted">Loading components...</td></tr>
              </tbody>
            </table>
          </div>
        </div>
        <div class="modal-footer border-0 pt-0">
          <button type="button" class="btn btn-light border px-4" data-dismiss="modal" style="border-radius: 8px;">Cancel</button>
          <button type="submit" class="btn btn-primary px-4 font-weight-bold shadow-sm" style="border-radius: 8px;">
            <i class="fas fa-check mr-1"></i> Save & Approve Revision
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  // Live search
  $('#structureSearch').on('keyup', function() {
    var val = $(this).val().toLowerCase();
    $('#structuresTable tbody tr').filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(val) > -1);
    });
  });

  var masterComps = [];

  $('.btn-revise-struct').on('click', function() {
    var empId = $(this).data('emp');
    $('#rev_emp_id').val(empId);
    $('#rev_emp_title').text('Revise Salary Structure: ' + empId);
    $('#rev_emp_subtitle').text('Fetching current components...');
    $('#structureComponentsBody').html('<tr><td colspan="4" class="text-center py-3 text-muted"><i class="fas fa-spinner fa-spin mr-1"></i> Loading structure...</td></tr>');
    $('#reviseStructureModal').modal('show');

    $.ajax({
      url: '<?= base_url("admin/payroll/get_structure/") ?>' + empId,
      type: 'GET',
      dataType: 'json',
      success: function(resp) {
        if (resp.status === 'SUCCESS') {
          masterComps = resp.master;
          var s = resp.data.structure;
          var assigned = resp.data.components;

          $('#rev_emp_title').text('Revise Salary: ' + (s.emp_name || empId));
          $('#rev_emp_subtitle').text(empId + ' &bull; ' + (s.department_name || '') + ' &bull; Current CTC: ₹' + parseFloat(s.monthly_ctc).toFixed(2));
          $('#rev_monthly_ctc').val(parseFloat(s.monthly_ctc).toFixed(2));
          if (s.effective_from) {
            $('#rev_effective_from').val(s.effective_from);
          }

          renderComponentRows(assigned);
        }
      }
    });
  });

  function renderComponentRows(assigned) {
    var assignedMap = {};
    if (assigned && assigned.length > 0) {
      assigned.forEach(function(c) {
        assignedMap[c.component_id] = c;
      });
    }

    var html = '';
    masterComps.forEach(function(m) {
      var exist = assignedMap[m.component_id];
      var amt = exist ? parseFloat(exist.monthly_amount).toFixed(2) : '0.00';
      var pct = exist && exist.percentage_value !== null ? parseFloat(exist.percentage_value).toFixed(2) : (m.percentage_value !== null ? parseFloat(m.percentage_value).toFixed(2) : '');

      var typeBadge = (m.component_type === 'EARNING') ? '<span class="badge badge-success">Earning</span>' :
                      ((m.component_type === 'DEDUCTION') ? '<span class="badge badge-danger">Deduction</span>' :
                      '<span class="badge badge-info">Employer</span>');

      html += '<tr>' +
        '<td>' + typeBadge + '</td>' +
        '<td><strong>' + m.component_name + '</strong> <small class="text-muted">(' + m.component_code + ')</small></td>' +
        '<td><input type="number" step="0.01" class="form-control form-control-sm comp-pct" name="components[' + m.component_id + '][percentage_value]" value="' + pct + '" placeholder="%"></td>' +
        '<td><input type="number" step="0.01" class="form-control form-control-sm text-right comp-amt font-weight-bold" name="components[' + m.component_id + '][monthly_amount]" value="' + amt + '" data-code="' + m.component_code + '"></td>' +
        '</tr>';
    });
    $('#structureComponentsBody').html(html);
  }

  $('#btnRecalculateSplit').on('click', function() {
    var ctc = parseFloat($('#rev_monthly_ctc').val()) || 0;
    if (ctc <= 0) {
      alert('Please enter a valid monthly CTC amount first.');
      return;
    }

    var basic = Math.round(ctc * 0.50 * 100) / 100;
    var hra   = Math.round(ctc * 0.20 * 100) / 100;
    var conv  = Math.round(ctc * 0.08 * 100) / 100;
    var med   = Math.round(ctc * 0.05 * 100) / 100;
    var spl   = Math.max(0, Math.round((ctc - (basic + hra + conv + med)) * 100) / 100);

    var pfEmp = Math.min(Math.round(basic * 0.12 * 100) / 100, 1800.00);
    var esiEmp = (ctc <= 21000) ? Math.round(ctc * 0.0075 * 100) / 100 : 0.00;
    var pt    = (ctc >= 20000) ? 200.00 : ((ctc >= 15000) ? 150.00 : 0.00);

    var pfEmplr = Math.min(Math.round(basic * 0.12 * 100) / 100, 1800.00);
    var esiEmplr = (ctc <= 21000) ? Math.round(ctc * 0.0325 * 100) / 100 : 0.00;

    $('.comp-amt').each(function() {
      var code = $(this).data('code');
      if (code === 'BASIC') $(this).val(basic.toFixed(2));
      else if (code === 'HRA') $(this).val(hra.toFixed(2));
      else if (code === 'CONVEYANCE') $(this).val(conv.toFixed(2));
      else if (code === 'MEDICAL') $(this).val(med.toFixed(2));
      else if (code === 'SPECIAL_ALLOWANCE') $(this).val(spl.toFixed(2));
      else if (code === 'PF_EMPLOYEE') $(this).val(pfEmp.toFixed(2));
      else if (code === 'ESI_EMPLOYEE') $(this).val(esiEmp.toFixed(2));
      else if (code === 'PROF_TAX') $(this).val(pt.toFixed(2));
      else if (code === 'PF_EMPLOYER') $(this).val(pfEmplr.toFixed(2));
      else if (code === 'ESI_EMPLOYER') $(this).val(esiEmplr.toFixed(2));
    });
  });
});
</script>
