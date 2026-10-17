<div class="content-wrapper" style="min-height: 800px; padding: 20px 24px;">
  
  <div class="content-header p-0 mb-3">
    <div class="container-fluid p-0">
      <div class="row align-items-center">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark font-weight-bold" style="font-size: 24px; letter-spacing: -0.02em;">
            <i class="fas fa-id-card-alt text-primary mr-2"></i> Employee Salary Structures Directory
          </h1>
          <p class="text-muted small mb-0 mt-1">
            Maintain employee-specific compensation structures, revise CTC & individual components, and synchronize approved versions with payroll cycles.
          </p>
        </div>
        <div class="col-sm-6 text-right">
          <span class="badge badge-light border text-dark font-weight-bold p-2 mr-2" style="font-size: 13px;">
            <i class="fas fa-users text-primary mr-1"></i> Active Employees: <?= count($structures) ?>
          </span>
          <span class="badge badge-light border text-dark font-weight-bold p-2" style="font-size: 13px;">
            <i class="fas fa-cubes text-info mr-1"></i> Master Components: <?= count($masterComponents) ?>
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
        <small class="text-muted">Approved salary structures and active components are captured directly during payroll cycle runs.</small>
      </div>
      <div>
        <input type="text" id="structureSearch" class="form-control form-control-sm" placeholder="Quick search employee..." style="border-radius: 6px; width: 240px;">
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
              <th>Active Components</th>
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
                  <span class="badge badge-light border text-dark px-2 py-1 font-weight-bold" title="Total active components assigned to this employee">
                    <i class="fas fa-cubes text-primary mr-1"></i> <?= (int)($s['active_component_count'] ?? count($masterComponents)) ?> Active
                  </span>
                </td>
                <td>
                  <?php if (($s['payroll_status'] ?? '') === 'APPROVED'): ?>
                    <span class="badge badge-success px-2 py-1 font-weight-normal"><i class="fas fa-check-circle mr-1"></i> Approved</span>
                  <?php else: ?>
                    <span class="badge badge-warning text-dark px-2 py-1 font-weight-normal">Draft</span>
                  <?php endif; ?>
                </td>
                <td class="text-right pr-4">
                  <button type="button" class="btn btn-sm btn-primary px-3 font-weight-bold btn-revise-struct shadow-sm" data-emp="<?= esc($s['emp_id']) ?>" style="border-radius: 6px;">
                    <i class="fas fa-edit mr-1"></i> Edit Components
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

<!-- Modal: Edit Employee Salary Structure & Components -->
<div class="modal fade" id="reviseStructureModal" tabindex="-1" role="dialog" aria-labelledby="reviseStructureModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
    <div class="modal-content border-0 shadow" style="border-radius: 14px;">
      <form method="post" action="<?= base_url('admin/payroll/save_structure') ?>" id="formReviseStructure">
        <?= csrf_field() ?>
        <input type="hidden" name="emp_id" id="rev_emp_id">
        
        <div class="modal-header border-0 pb-2" style="background: #f8fafc; border-top-left-radius: 14px; border-top-right-radius: 14px;">
          <div>
            <h5 class="modal-title font-weight-bold text-dark" id="rev_emp_title">
              <i class="fas fa-user-edit text-primary mr-2"></i> Revise Salary & Components
            </h5>
            <div class="text-muted small mt-1" id="rev_emp_subtitle">Employee Details</div>
          </div>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>

        <div class="modal-body py-3">
          
          <!-- Top Row: Monthly CTC & Effective Date -->
          <div class="form-row p-3 mb-3" style="background: #f1f5f9; border-radius: 10px;">
            <div class="col-md-5">
              <label class="font-weight-bold text-dark small mb-1">
                Monthly CTC (₹) <span class="text-danger">*</span>
              </label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text bg-white font-weight-bold text-primary">₹</span>
                </div>
                <input type="number" step="0.01" name="monthly_ctc" id="rev_monthly_ctc" class="form-control font-weight-bold text-primary" required style="font-size: 16px; border-radius: 0 8px 8px 0;" placeholder="e.g. 30000.00">
              </div>
              <small class="text-muted">Total Monthly Cost-to-Company for this revision.</small>
            </div>

            <div class="col-md-4">
              <label class="font-weight-bold text-dark small mb-1">
                Effective From Date <span class="text-danger">*</span>
              </label>
              <input type="date" name="effective_from" id="rev_effective_from" class="form-control font-weight-bold" required value="<?= date('Y-m-01') ?>" style="border-radius: 8px;">
              <small class="text-muted">Starting date for this salary structure revision.</small>
            </div>

            <div class="col-md-3 d-flex align-items-end">
              <button type="button" class="btn btn-outline-primary btn-block font-weight-bold shadow-sm" id="btnRecalculateSplit" style="border-radius: 8px; height: 38px;">
                <i class="fas fa-magic mr-1"></i> Auto-Calculate Split
              </button>
            </div>
          </div>

          <!-- Component Breakdown Section Header -->
          <div class="d-flex justify-content-between align-items-center mb-2 px-1">
            <div>
              <h6 class="font-weight-bold text-dark m-0 small text-uppercase" style="letter-spacing: 0.5px;">
                <i class="fas fa-layer-group text-primary mr-1"></i> Component Breakdown & Individual Overrides
              </h6>
              <small class="text-muted">Enable or disable components for this employee, adjust percentages or set exact monthly amounts.</small>
            </div>
            <div>
              <span class="badge badge-light border text-muted" id="compStatsBadge">Loading components...</span>
            </div>
          </div>

          <!-- Components Table -->
          <div class="table-responsive" style="max-height: 380px; overflow-y: auto; border: 1px solid #e2e8f0; border-radius: 10px;">
            <table class="table table-sm table-hover align-middle mb-0 text-nowrap" id="tableComponentsEdit" style="font-size: 13px;">
              <thead style="background: #f8fafc; position: sticky; top: 0; z-index: 5;">
                <tr>
                  <th style="width: 50px;" class="text-center">Active</th>
                  <th style="width: 110px;">Type</th>
                  <th>Component Name & Code</th>
                  <th style="width: 110px;">Calc Method</th>
                  <th style="width: 140px;">Percentage (%)</th>
                  <th style="width: 180px;" class="text-right pr-3">Monthly Amount (₹)</th>
                </tr>
              </thead>
              <tbody id="structureComponentsBody">
                <tr><td colspan="6" class="text-center py-4 text-muted"><i class="fas fa-spinner fa-spin mr-1"></i> Loading structure...</td></tr>
              </tbody>
            </table>
          </div>

          <!-- Live Summary Card -->
          <div class="card border-0 shadow-sm mt-3" style="border-radius: 10px; background: #f8fafc; border: 1px solid #e2e8f0;">
            <div class="card-body p-3">
              <div class="row align-items-center text-center">
                <div class="col-md-2 border-right">
                  <small class="text-muted text-uppercase font-weight-bold" style="font-size: 11px;">Monthly CTC</small>
                  <div class="font-weight-bold text-primary mt-1" id="sum_ctc" style="font-size: 16px;">₹0.00</div>
                </div>
                <div class="col-md-2 border-right">
                  <small class="text-muted text-uppercase font-weight-bold" style="font-size: 11px;">Gross Earnings</small>
                  <div class="font-weight-bold text-success mt-1" id="sum_gross" style="font-size: 16px;">₹0.00</div>
                </div>
                <div class="col-md-2 border-right">
                  <small class="text-muted text-uppercase font-weight-bold" style="font-size: 11px;">Total Deductions</small>
                  <div class="font-weight-bold text-danger mt-1" id="sum_deductions" style="font-size: 16px;">₹0.00</div>
                </div>
                <div class="col-md-2 border-right">
                  <small class="text-muted text-uppercase font-weight-bold" style="font-size: 11px;">Net In-Hand Pay</small>
                  <div class="font-weight-bold text-dark mt-1" id="sum_net" style="font-size: 16px;">₹0.00</div>
                </div>
                <div class="col-md-2 border-right">
                  <small class="text-muted text-uppercase font-weight-bold" style="font-size: 11px;">Employer Contrib.</small>
                  <div class="font-weight-bold text-info mt-1" id="sum_employer" style="font-size: 16px;">₹0.00</div>
                </div>
                <div class="col-md-2">
                  <small class="text-muted text-uppercase font-weight-bold" style="font-size: 11px;">CTC Balance Check</small>
                  <div class="mt-1" id="sum_tally_badge">
                    <span class="badge badge-success px-2 py-1">Balanced ✓</span>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>

        <div class="modal-footer border-0 pt-0 pb-3 pr-3">
          <button type="button" class="btn btn-light border px-4" data-dismiss="modal" style="border-radius: 8px;">Cancel</button>
          <button type="submit" class="btn btn-primary px-4 font-weight-bold shadow-sm" style="border-radius: 8px;">
            <i class="fas fa-check-circle mr-1"></i> Save & Approve Revision
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
  // Live search in structures table
  $('#structureSearch').on('keyup', function() {
    var val = $(this).val().toLowerCase();
    $('#structuresTable tbody tr').filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(val) > -1);
    });
  });

  var masterComps = [];

  $(document).on('click', '.btn-revise-struct', function(e) {
    e.preventDefault();
    var empId = $(this).data('emp');
    $('#rev_emp_id').val(empId);
    $('#rev_emp_title').html('<i class="fas fa-user-edit text-primary mr-2"></i> Revise Salary & Components: ' + empId);
    $('#rev_emp_subtitle').text('Fetching salary structure...');
    $('#structureComponentsBody').html('<tr><td colspan="6" class="text-center py-4 text-muted"><i class="fas fa-spinner fa-spin mr-1"></i> Loading structure...</td></tr>');
    $('#reviseStructureModal').modal('show');

    $.ajax({
      url: '<?= base_url("admin/payroll/get_structure") ?>/' + encodeURIComponent(empId),
      type: 'GET',
      dataType: 'json',
      success: function(resp) {
        if (resp && resp.status === 'SUCCESS') {
          masterComps = resp.master || [];
          var s = resp.data.structure || {};
          var assigned = resp.data.components || [];

          $('#rev_emp_title').html('<i class="fas fa-user-edit text-primary mr-2"></i> Revise Salary: <strong>' + (s.emp_name || empId) + '</strong> (' + empId + ')');
          $('#rev_emp_subtitle').html((s.department_name || 'General') + ' &bull; ' + (s.designation_name || 'Staff') + ' &bull; Current CTC: <strong>₹' + parseFloat(s.monthly_ctc || 0).toFixed(2) + '</strong> &bull; Version v' + (s.structure_version || 1));
          $('#rev_monthly_ctc').val(parseFloat(s.monthly_ctc || 0).toFixed(2));
          if (s.effective_from) {
            $('#rev_effective_from').val(s.effective_from);
          }

          renderComponentRows(assigned);
          updateLiveSummary();
        } else {
          $('#structureComponentsBody').html('<tr><td colspan="6" class="text-center py-4 text-danger"><i class="fas fa-exclamation-triangle mr-1"></i> Failed to retrieve salary details.</td></tr>');
        }
      },
      error: function(xhr, status, err) {
        $('#structureComponentsBody').html('<tr><td colspan="6" class="text-center py-4 text-danger"><i class="fas fa-exclamation-triangle mr-1"></i> Error loading structure data: ' + err + '</td></tr>');
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
      var amt = exist ? parseFloat(exist.monthly_amount).toFixed(2) : (m.default_monthly_amount ? parseFloat(m.default_monthly_amount).toFixed(2) : '0.00');
      var pct = exist && exist.percentage_value !== null ? parseFloat(exist.percentage_value).toFixed(2) : (m.percentage_value !== null ? parseFloat(m.percentage_value).toFixed(2) : '');
      var isActive = exist ? (parseInt(exist.is_active) === 1) : (parseInt(m.is_active) === 1);

      var typeBadge = (m.component_type === 'EARNING') ? '<span class="badge badge-success px-2 py-1"><i class="fas fa-arrow-up mr-1"></i> Earning</span>' :
                      ((m.component_type === 'DEDUCTION') ? '<span class="badge badge-danger px-2 py-1"><i class="fas fa-arrow-down mr-1"></i> Deduction</span>' :
                      '<span class="badge badge-info px-2 py-1"><i class="fas fa-shield-alt mr-1"></i> Employer</span>');

      var lopBadge = (parseInt(m.is_lop_applicable) === 1) ? '<span class="badge badge-warning text-dark font-weight-normal ml-1" style="font-size: 10px;">LOP Prorated</span>' : '';
      var taxBadge = (parseInt(m.is_taxable) === 1) ? '<span class="badge badge-light border text-muted ml-1" style="font-size: 10px;">Taxable</span>' : '';

      html += '<tr class="comp-row ' + (isActive ? '' : 'table-light text-muted') + '" data-comp-id="' + m.component_id + '" data-type="' + m.component_type + '" data-code="' + m.component_code + '">' +
        '<td class="text-center align-middle">' +
          '<input type="hidden" name="components[' + m.component_id + '][is_active]" value="0">' +
          '<input type="checkbox" class="comp-active-toggle" name="components[' + m.component_id + '][is_active]" value="1" ' + (isActive ? 'checked' : '') + ' style="cursor: pointer; transform: scale(1.1);">' +
        '</td>' +
        '<td class="align-middle">' + typeBadge + '</td>' +
        '<td class="align-middle">' +
          '<div class="font-weight-bold text-dark">' + m.component_name + '</div>' +
          '<small class="text-muted font-weight-bold"><code>' + m.component_code + '</code></small>' + lopBadge + taxBadge +
        '</td>' +
        '<td class="align-middle"><span class="badge badge-light border text-dark font-weight-normal">' + m.calculation_type + '</span></td>' +
        '<td class="align-middle">' +
          '<input type="number" step="0.01" class="form-control form-control-sm comp-pct" name="components[' + m.component_id + '][percentage_value]" value="' + pct + '" placeholder="%" data-base="' + (m.percentage_base || 'NONE') + '" style="border-radius: 6px;">' +
        '</td>' +
        '<td class="align-middle pr-3">' +
          '<input type="number" step="0.01" class="form-control form-control-sm text-right comp-amt font-weight-bold" name="components[' + m.component_id + '][monthly_amount]" value="' + amt + '" data-code="' + m.component_code + '" style="border-radius: 6px;">' +
        '</td>' +
        '</tr>';
    });
    $('#structureComponentsBody').html(html);
    $('#compStatsBadge').text(masterComps.length + ' Total Components Available');

    bindComponentRowEvents();
  }

  function bindComponentRowEvents() {
    // When checkbox is toggled
    $('.comp-active-toggle').on('change', function() {
      var row = $(this).closest('tr');
      if ($(this).is(':checked')) {
        row.removeClass('table-light text-muted');
      } else {
        row.addClass('table-light text-muted');
      }
      updateLiveSummary();
    });

    // When monthly amount is edited directly
    $('.comp-amt').on('input change', function() {
      updateLiveSummary();
    });

    // When percentage is edited directly
    $('.comp-pct').on('input change', function() {
      var pct = parseFloat($(this).val()) || 0;
      var ctc = parseFloat($('#rev_monthly_ctc').val()) || 0;
      var base = $(this).data('base');
      var row = $(this).closest('tr');
      var amtInput = row.find('.comp-amt');

      if (pct > 0 && ctc > 0) {
        var baseAmt = ctc;
        if (base === 'BASIC') {
          var basicInput = $('.comp-amt[data-code="BASIC"]');
          baseAmt = parseFloat(basicInput.val()) || (ctc * 0.50);
        }
        var computed = Math.round((baseAmt * pct / 100) * 100) / 100;
        amtInput.val(computed.toFixed(2));
      }
      updateLiveSummary();
    });

    // When monthly CTC is edited
    $('#rev_monthly_ctc').on('input change', function() {
      updateLiveSummary();
    });
  }

  function updateLiveSummary() {
    var ctc = parseFloat($('#rev_monthly_ctc').val()) || 0;
    var gross = 0.00;
    var deductions = 0.00;
    var employer = 0.00;

    $('.comp-row').each(function() {
      var isActive = $(this).find('.comp-active-toggle').is(':checked');
      if (!isActive) return;

      var type = $(this).data('type');
      var amt = parseFloat($(this).find('.comp-amt').val()) || 0;

      if (type === 'EARNING') {
        gross += amt;
      } else if (type === 'DEDUCTION') {
        deductions += amt;
      } else if (type === 'EMPLOYER_CONTRIBUTION') {
        employer += amt;
      }
    });

    gross = Math.round(gross * 100) / 100;
    deductions = Math.round(deductions * 100) / 100;
    employer = Math.round(employer * 100) / 100;
    var net = Math.max(0, Math.round((gross - deductions) * 100) / 100);

    $('#sum_ctc').text('₹' + ctc.toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2}));
    $('#sum_gross').text('₹' + gross.toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2}));
    $('#sum_deductions').text('₹' + deductions.toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2}));
    $('#sum_net').text('₹' + net.toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2}));
    $('#sum_employer').text('₹' + employer.toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2}));

    var diff = Math.round((ctc - gross) * 100) / 100;
    if (Math.abs(diff) < 0.01) {
      $('#sum_tally_badge').html('<span class="badge badge-success px-2 py-1 font-weight-bold"><i class="fas fa-check-circle mr-1"></i> Balanced ✓</span>');
    } else if (diff > 0) {
      $('#sum_tally_badge').html('<span class="badge badge-warning text-dark px-2 py-1 font-weight-bold" title="Gross is ₹' + Math.abs(diff).toFixed(2) + ' less than CTC"><i class="fas fa-exclamation-triangle mr-1"></i> Remainder: ₹' + diff.toFixed(2) + '</span>');
    } else {
      $('#sum_tally_badge').html('<span class="badge badge-danger px-2 py-1 font-weight-bold" title="Gross exceeds CTC by ₹' + Math.abs(diff).toFixed(2) + '"><i class="fas fa-exclamation-triangle mr-1"></i> Exceeds: ₹' + Math.abs(diff).toFixed(2) + '</span>');
    }
  }

  // Auto-Calculate Split button
  $('#btnRecalculateSplit').on('click', function() {
    var ctc = parseFloat($('#rev_monthly_ctc').val()) || 0;
    if (ctc <= 0) {
      alert('Please enter a valid monthly CTC amount first (e.g. 30000).');
      $('#rev_monthly_ctc').focus();
      return;
    }

    var basic = Math.round(ctc * 0.50 * 100) / 100;
    var hra   = Math.round(ctc * 0.20 * 100) / 100;
    var conv  = Math.round(ctc * 0.08 * 100) / 100;
    var med   = Math.round(ctc * 0.05 * 100) / 100;

    // Calculate other fixed/percentage earnings that might be active
    var otherEarnings = basic + hra + conv + med;
    var dynamicEarningsSum = 0;

    $('.comp-row').each(function() {
      var code = $(this).data('code');
      var type = $(this).data('type');
      if (type === 'EARNING' && !['BASIC','HRA','CONVEYANCE','MEDICAL','SPECIAL_ALLOWANCE'].includes(code)) {
        var pct = parseFloat($(this).find('.comp-pct').val()) || 0;
        var amt = parseFloat($(this).find('.comp-amt').val()) || 0;
        if (pct > 0) {
          amt = Math.round((ctc * pct / 100) * 100) / 100;
          $(this).find('.comp-amt').val(amt.toFixed(2));
        }
        dynamicEarningsSum += amt;
      }
    });

    var spl = Math.max(0, Math.round((ctc - (otherEarnings + dynamicEarningsSum)) * 100) / 100);

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

    // Make sure all standard components are checked active
    $('.comp-active-toggle').each(function() {
      var row = $(this).closest('tr');
      var code = row.data('code');
      if (['BASIC','HRA','CONVEYANCE','MEDICAL','SPECIAL_ALLOWANCE','PF_EMPLOYEE','ESI_EMPLOYEE','PROF_TAX','PF_EMPLOYER','ESI_EMPLOYER'].includes(code)) {
        $(this).prop('checked', true);
        row.removeClass('table-light text-muted');
      }
    });

    updateLiveSummary();
  });

  // Form submit validation & UI feedback
  $('#formReviseStructure').on('submit', function() {
    var ctc = parseFloat($('#rev_monthly_ctc').val()) || 0;
    if (ctc <= 0) {
      alert('Please enter a valid monthly CTC amount first (e.g. 30000).');
      $('#rev_monthly_ctc').focus();
      return false;
    }
    $(this).find('button[type="submit"]').prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Saving & Approving...');
    return true;
  });
});
</script>
