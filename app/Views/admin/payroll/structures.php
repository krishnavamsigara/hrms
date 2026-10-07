<div class="content-wrapper p-3">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2 align-items-center">
        <div class="col-sm-6">
          <h1 class="m-0 font-weight-bold text-dark">
            <a href="<?= base_url('admin/payroll') ?>" class="text-secondary mr-2"><i class="fas fa-arrow-left"></i></a>
            Employee Salary Structures
          </h1>
          <p class="text-muted small mb-0">Assign employee-specific salary component formulas, fixed allowances, or custom structures.</p>
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

      <div class="card card-outline card-info shadow-sm border-0">
        <div class="card-header bg-white d-flex align-items-center justify-content-between pt-3">
          <h3 class="card-title font-weight-bold text-secondary mb-0"><i class="fas fa-users-cog mr-2"></i> Employee Master Salary Assignments</h3>
          <div class="card-tools">
            <input type="text" id="empStructureSearch" class="form-control form-control-sm" placeholder="Search employee..." style="width: 220px;">
          </div>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" id="structuresTable">
              <thead class="bg-light text-uppercase text-secondary small">
                <tr>
                  <th>Emp ID</th>
                  <th>Employee Name</th>
                  <th>Department</th>
                  <th class="text-right">Monthly CTC</th>
                  <th class="text-center">Effective From</th>
                  <th class="text-center">Action</th>
                </tr>
              </thead>
              <tbody>
                <?php if (!empty($employees)): ?>
                  <?php foreach ($employees as $e): ?>
                    <tr>
                      <td class="font-weight-bold text-primary"><?= esc($e['emp_id']) ?></td>
                      <td class="font-weight-bold text-dark"><?= esc($e['emp_name']) ?></td>
                      <td><?= esc($e['department'] ?: 'General') ?></td>
                      <td class="text-right font-weight-bold text-success">₹<?= number_format($e['ctc'] ?: 50000, 2) ?></td>
                      <td class="text-center">
                        <span class="badge badge-info px-3 py-1 font-weight-bold">
                          <i class="fas fa-calendar-alt mr-1"></i>
                          <?= !empty($e['effective_from']) ? date('d M Y', strtotime($e['effective_from'])) : 'Default' ?>
                        </span>
                      </td>
                      <td class="text-center">
                        <button class="btn btn-sm btn-primary shadow-sm font-weight-bold btn-configure-structure" data-empid="<?= esc($e['emp_id']) ?>">
                          <i class="fas fa-edit mr-1"></i> Configure Structure
                        </button>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr>
                    <td colspan="6" class="text-center text-muted py-4">No employee master records found.</td>
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

<!-- Modal: Configure Employee Salary Structure -->
<div class="modal fade" id="configureStructureModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <form action="<?= base_url('admin/payroll/save_structure') ?>" method="POST" id="structureForm">
        <input type="hidden" name="emp_id" id="modal_emp_id">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-header-title font-weight-bold m-0"><i class="fas fa-sliders-h mr-2"></i> Configure Salary Structure for <span id="modal_emp_name_label">...</span></h5>
          <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close"><span>&times;</span></button>
        </div>
        <div class="modal-body">
          <div class="row bg-light p-3 rounded mb-3">
            <div class="col-md-6 form-group mb-0">
              <label class="font-weight-bold">Monthly CTC (₹) <span class="text-danger">*</span></label>
              <input type="number" step="0.01" name="ctc" id="modal_ctc" class="form-control font-weight-bold text-primary" required>
            </div>
            <div class="col-md-6 form-group mb-0">
              <label class="font-weight-bold">Effective From Date <span class="text-danger">*</span></label>
              <input type="date" name="effective_from" id="modal_effective_from" class="form-control" value="<?= date('Y-m-01') ?>" required>
            </div>
          </div>

          <h6 class="font-weight-bold text-secondary mb-2"><i class="fas fa-list-ol mr-1"></i> Salary Component Breakdown</h6>
          <div class="table-responsive">
            <table class="table table-bordered table-sm align-middle" id="modalComponentsTable">
              <thead class="bg-light text-uppercase small text-secondary">
                <tr>
                  <th>Component</th>
                  <th>Type</th>
                  <th>Calc Mode</th>
                  <style>
                    #modalComponentsTable th, #modalComponentsTable td { vertical-align: middle; }
                  </style>
                  <th style="width: 140px;">Value (% / Fixed)</th>
                  <th style="width: 160px;" class="text-right">Monthly Amount (₹)</th>
                </tr>
              </thead>
              <tbody id="modalComponentsBody">
                <!-- Dynamically injected by JS -->
              </tbody>
              <tfoot>
                <tr class="bg-light font-weight-bold border-top">
                  <td colspan="4" class="text-right text-dark">Direct Gross Cash Salary (A):</td>
                  <td class="text-right text-success font-weight-bold" id="modal_total_gross" style="font-size: 0.95rem;">₹0.00</td>
                </tr>
                <tr class="bg-light">
                  <td colspan="4" class="text-right text-muted">Employer Contributions (EPF/ESI/NPS in CTC):</td>
                  <td class="text-right text-info font-weight-bold" id="modal_employer_contrib" style="font-size: 0.95rem;">₹0.00</td>
                </tr>
                <tr class="bg-light font-weight-bold text-primary">
                  <td colspan="4" class="text-right">Total Calculated Monthly CTC:</td>
                  <td class="text-right font-weight-bold" id="modal_total_ctc_display" style="font-size: 1rem;">₹0.00</td>
                </tr>
                <tr class="bg-light font-weight-bold">
                  <td colspan="4" class="text-right text-danger">Total Employee Deductions (B):</td>
                  <td class="text-right text-danger font-weight-bold" id="modal_total_deductions" style="font-size: 0.95rem;">₹0.00</td>
                </tr>
                <tr class="bg-success text-white font-weight-bold" style="font-size: 1.05rem;">
                  <td colspan="4" class="text-right">Estimated Net Monthly In-Hand Salary (A - B):</td>
                  <td class="text-right font-weight-bold" id="modal_net_inhand">₹0.00</td>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
        <div class="modal-footer bg-light">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary font-weight-bold"><i class="fas fa-save mr-1"></i> Save Salary Structure</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function() {
  const searchInput = document.getElementById('empStructureSearch');
  if (searchInput) {
    searchInput.addEventListener('keyup', function() {
      const value = this.value.toLowerCase();
      const rows = document.querySelectorAll('#structuresTable tbody tr');
      rows.forEach(r => {
        const text = r.innerText.toLowerCase();
        r.style.display = text.includes(value) ? '' : 'none';
      });
    });
  }

  const defaultFormula = {
    'BASIC': { calc: 'PERCENTAGE', val: 50 },
    'HRA': { calc: 'PERCENTAGE', val: 20 },
    'MEDICAL': { calc: 'PERCENTAGE', val: 5 },
    'CONVEYANCE': { calc: 'PERCENTAGE', val: 8 },
    'OTHER_EARNINGS': { calc: 'PERCENTAGE', val: 10.5 },
    'EPF_EMPLOYER': { calc: 'PERCENTAGE', val: 6.5 },
    'EPF_EMPLOYEE': { calc: 'PERCENTAGE', val: 12 },
    'ESI_EMPLOYEE': { calc: 'PERCENTAGE', val: 0.75 },
    'ESI_EMPLOYER': { calc: 'PERCENTAGE', val: 3.25 },
    'PT': { calc: 'SLAB', val: 0 },
  };

  $(document).on('click', '.btn-configure-structure', function() {
    const empId = $(this).data('empid');
    $('#configureStructureModal').modal('show');
    
    const tbody = document.getElementById('modalComponentsBody');
    tbody.innerHTML = '<tr><td colspan="5" class="text-center py-4"><i class="fas fa-spinner fa-spin fa-2x text-primary"></i><p class="mt-2 text-muted">Loading employee structure...</p></td></tr>';

    fetch('<?= base_url('admin/payroll/get_emp_structure/') ?>' + empId)
      .then(res => res.json())
      .then(data => {
        if (data.status === 'success') {
          document.getElementById('modal_emp_id').value = data.emp_id;
          document.getElementById('modal_emp_name_label').innerText = `${data.emp_name} (${data.emp_id})`;
          document.getElementById('modal_ctc').value = data.ctc || 25000;
          if (data.effective_from) {
            document.getElementById('modal_effective_from').value = data.effective_from;
          }

          const existingMap = {};
          if (data.structures && data.structures.length > 0) {
            data.structures.forEach(s => {
              existingMap[s.component_code] = s;
            });
          }

          let html = '';
          (data.components || []).forEach(comp => {
            const code = comp.component_code;
            const existing = existingMap[code];

            let calcType = comp.calculation_type || 'FIXED';
            let val = comp.value || 0;
            let amt = 0;

            if (existing) {
              calcType = existing.calculation_type;
              val = parseFloat(existing.value || 0);
              amt = parseFloat(existing.amount || 0);
            } else if (defaultFormula[code]) {
              calcType = defaultFormula[code].calc;
              val = defaultFormula[code].val;
              amt = (data.ctc * val) / 100;
            }

            let badgeClass = 'badge-success';
            if (comp.component_type === 'DEDUCTION') badgeClass = 'badge-danger';
            else if (comp.component_type === 'STATUTORY') badgeClass = 'badge-info';

            html += `
              <tr data-code="${code}" data-compid="${comp.id}" data-type="${comp.component_type}">
                <td class="font-weight-bold text-dark">
                  ${comp.component_name} <br><small class="text-muted"><code>${code}</code></small>
                </td>
                <td><span class="badge ${badgeClass}">${comp.component_type}</span></td>
                <td>
                  <select name="components[${comp.id}][calculation_type]" class="form-control form-control-sm comp-calc-type">
                    <option value="PERCENTAGE" ${calcType==='PERCENTAGE'?'selected':''}>PERCENTAGE (%)</option>
                    <option value="FIXED" ${calcType==='FIXED'?'selected':''}>FIXED (₹)</option>
                    <option value="SLAB" ${calcType==='SLAB'?'selected':''}>SLAB</option>
                  </select>
                </td>
                <td>
                  <input type="number" step="0.01" name="components[${comp.id}][value]" class="form-control form-control-sm comp-val-input" value="${val}">
                </td>
                <td>
                  <input type="number" step="0.01" name="components[${comp.id}][amount]" class="form-control form-control-sm text-right font-weight-bold comp-amt-input" value="${amt.toFixed(2)}">
                </td>
              </tr>
            `;
          });

          tbody.innerHTML = html;
          recalculateModalAmounts();
          attachModalCalcEvents();
        }
      });
  });

  function attachModalCalcEvents() {
    $('#modal_ctc').off('input').on('input', function(e) {
      recalculateModalAmounts(e.target);
    });

    $(document).off('input change', '.comp-val-input, .comp-calc-type, .comp-amt-input').on('input change', '.comp-val-input, .comp-calc-type, .comp-amt-input', function(e) {
      recalculateModalAmounts(e.target);
    });
  }

  function recalculateModalAmounts(targetEl = null) {
    const ctc = parseFloat($('#modal_ctc').val()) || 0;

    // Handle targeted row updates if user explicitly edited an input
    if (targetEl) {
      const $target = $(targetEl);
      const $row = $target.closest('tr');
      if ($row.length) {
        const calcType = $row.find('.comp-calc-type').val();
        const $valInput = $row.find('.comp-val-input');
        const $amtInput = $row.find('.comp-amt-input');

        if ($target.hasClass('comp-amt-input')) {
          const amt = parseFloat($target.val()) || 0;
          if (calcType === 'PERCENTAGE') {
            const calculatedPct = ctc > 0 ? (amt / ctc) * 100 : 0;
            $valInput.val(calculatedPct.toFixed(2));
          } else {
            $valInput.val(amt.toFixed(2));
          }
        } else if ($target.hasClass('comp-val-input')) {
          const val = parseFloat($target.val()) || 0;
          if (calcType === 'PERCENTAGE') {
            const calculatedAmt = (ctc * val) / 100;
            $amtInput.val(calculatedAmt.toFixed(2));
          } else {
            $amtInput.val(val.toFixed(2));
          }
        } else if ($target.hasClass('comp-calc-type')) {
          const val = parseFloat($valInput.val()) || 0;
          const amt = parseFloat($amtInput.val()) || 0;
          if (calcType === 'PERCENTAGE') {
            const calculatedPct = ctc > 0 ? (amt / ctc) * 100 : 0;
            $valInput.val(calculatedPct.toFixed(2));
          } else {
            $valInput.val(amt.toFixed(2));
          }
        }
      }
    }

    let totalGrossCash = 0;
    let basicAmt = 0;

    // First pass: Calculate Direct Cash Earnings
    $('#modalComponentsBody tr').each(function() {
      const type = $(this).attr('data-type');
      const code = $(this).attr('data-code');
      if (type !== 'EARNING') return;

      const calcType = $(this).find('.comp-calc-type').val();
      const $valInput = $(this).find('.comp-val-input');
      const $amtInput = $(this).find('.comp-amt-input');
      const val = parseFloat($valInput.val()) || 0;

      let amt = parseFloat($amtInput.val()) || 0;

      // If user edited Monthly CTC field, update percentage-based earning amounts
      if (targetEl && targetEl.id === 'modal_ctc' && calcType === 'PERCENTAGE') {
        amt = (ctc * val) / 100;
        $amtInput.val(amt.toFixed(2));
      }

      totalGrossCash += amt;
      if (code === 'BASIC') basicAmt = amt;
    });

    // Second pass: Calculate Statutory Employer Contributions & Employee Deductions
    let totalEmployerContrib = 0;
    let totalDeductions = 0;

    $('#modalComponentsBody tr').each(function() {
      const type = $(this).attr('data-type');
      const code = $(this).attr('data-code');
      if (type === 'EARNING') return;

      const calcType = $(this).find('.comp-calc-type').val();
      const $valInput = $(this).find('.comp-val-input');
      const $amtInput = $(this).find('.comp-amt-input');
      const val = parseFloat($valInput.val()) || 0;
      let amt = parseFloat($amtInput.val()) || 0;

      const isDirectlyEdited = targetEl && $(targetEl).closest('tr').is($(this)) && $(targetEl).hasClass('comp-amt-input');

      if (!isDirectlyEdited) {
        if (type === 'STATUTORY') {
          if (code === 'EPF_EMPLOYER') {
            const epfBase = Math.min(basicAmt, 15000);
            amt = calcType === 'PERCENTAGE' ? (epfBase * (val || 12)) / 100 : (val || amt);
            $amtInput.val(amt.toFixed(2));
          } else if (code === 'ESI_EMPLOYER') {
            amt = totalGrossCash <= 21000 ? (totalGrossCash * 0.0325) : 0;
            $amtInput.val(amt.toFixed(2));
          } else if (calcType === 'PERCENTAGE') {
            amt = (ctc * val) / 100;
            $amtInput.val(amt.toFixed(2));
          }
        } else if (type === 'DEDUCTION') {
          if (code === 'EPF_EMPLOYEE') {
            const epfBase = Math.min(basicAmt, 15000);
            amt = calcType === 'PERCENTAGE' ? (epfBase * (val || 12)) / 100 : (val || amt);
            $amtInput.val(amt.toFixed(2));
          } else if (code === 'ESI_EMPLOYEE') {
            amt = totalGrossCash <= 21000 ? (totalGrossCash * 0.0075) : 0;
            $amtInput.val(amt.toFixed(2));
          } else if (code === 'PT') {
            if (calcType === 'SLAB') {
              if (totalGrossCash > 20000) amt = 200;
              else if (totalGrossCash >= 15001) amt = 150;
              else amt = 0;
            } else if (calcType === 'PERCENTAGE') {
              amt = (totalGrossCash * val) / 100;
            }
            $amtInput.val(amt.toFixed(2));
          } else if (calcType === 'PERCENTAGE') {
            amt = (totalGrossCash * val) / 100;
            $amtInput.val(amt.toFixed(2));
          }
        }
      }

      if (type === 'STATUTORY') totalEmployerContrib += amt;
      else if (type === 'DEDUCTION') totalDeductions += amt;
    });

    const calculatedTotalCTC = totalGrossCash + totalEmployerContrib;
    const netInHand = Math.max(0, totalGrossCash - totalDeductions);

    $('#modal_total_gross').text('₹' + totalGrossCash.toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
    $('#modal_employer_contrib').text('₹' + totalEmployerContrib.toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
    $('#modal_total_ctc_display').text('₹' + calculatedTotalCTC.toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
    $('#modal_total_deductions').text('₹' + totalDeductions.toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
    $('#modal_net_inhand').text('₹' + netInHand.toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
  }
});
</script>
