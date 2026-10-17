<div class="content-wrapper" style="min-height: 800px; padding: 20px 24px;">
  
  <div class="content-header p-0 mb-3">
    <div class="container-fluid p-0">
      <div class="row align-items-center">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark font-weight-bold" style="font-size: 24px; letter-spacing: -0.02em;">
            <i class="fas fa-cubes text-primary mr-2"></i> Salary Component Master
          </h1>
          <p class="text-muted small mb-0 mt-1">
            Configure standardized earnings, deductions, statutory rules, and employer contribution definitions.
          </p>
        </div>
        <div class="col-sm-6 text-right">
          <button type="button" class="btn btn-primary shadow-sm px-4 font-weight-bold" data-toggle="modal" data-target="#addComponentModal" style="border-radius: 8px;">
            <i class="fas fa-plus-circle mr-1"></i> Add Component
          </button>
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
    <div class="card-header bg-transparent border-0 pt-3 pb-2">
      <h5 class="font-weight-bold text-dark mb-0" style="font-size: 16px;">
        <i class="fas fa-layer-group mr-2 text-primary"></i> Active Salary Components (<?= count($components) ?>)
      </h5>
      <small class="text-muted">Components used to calculate employee payroll and render payslips.</small>
    </div>

    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0 text-nowrap" style="font-size: 13px;">
          <thead style="background: #f8fafc; color: #475569; font-weight: 600;">
            <tr>
              <th class="pl-4">Component Code</th>
              <th>Component Name</th>
              <th>Category Type</th>
              <th>Calculation Method</th>
              <th>Calculation Base</th>
              <th>Value / %</th>
              <th>LOP Proration</th>
              <th>Taxable</th>
              <th>Status</th>
              <th class="text-right pr-4">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($components as $c): ?>
              <tr>
                <td class="pl-4 font-weight-bold">
                  <code><?= esc($c['component_code']) ?></code>
                </td>
                <td class="font-weight-bold text-dark">
                  <?= esc($c['component_name']) ?>
                </td>
                <td>
                  <?php if ($c['component_type'] === 'EARNING'): ?>
                    <span class="badge badge-success px-2 py-1 font-weight-normal"><i class="fas fa-arrow-up mr-1"></i> Earning</span>
                  <?php elseif ($c['component_type'] === 'DEDUCTION'): ?>
                    <span class="badge badge-danger px-2 py-1 font-weight-normal"><i class="fas fa-arrow-down mr-1"></i> Deduction</span>
                  <?php else: ?>
                    <span class="badge badge-info px-2 py-1 font-weight-normal"><i class="fas fa-shield-alt mr-1"></i> Employer Contrib</span>
                  <?php endif; ?>
                </td>
                <td>
                  <span class="badge badge-light border text-dark"><?= esc($c['calculation_type']) ?></span>
                </td>
                <td>
                  <?= ($c['percentage_base'] !== 'NONE') ? '<span class="badge badge-light border">' . esc($c['percentage_base']) . '</span>' : '&mdash;' ?>
                </td>
                <td class="font-weight-bold text-dark">
                  <?php if ($c['calculation_type'] === 'PERCENTAGE' && $c['percentage_value'] !== null): ?>
                    <?= (float)$c['percentage_value'] ?>%
                  <?php elseif ($c['calculation_type'] === 'FIXED'): ?>
                    Fixed Amount
                  <?php else: ?>
                    &mdash;
                  <?php endif; ?>
                </td>
                <td>
                  <?php if ((int)$c['is_lop_applicable'] === 1): ?>
                    <span class="badge badge-warning text-dark font-weight-bold px-2 py-1"><i class="fas fa-check mr-1"></i> LOP Prorated</span>
                  <?php else: ?>
                    <span class="badge badge-light border text-muted">Fixed / Non-LOP</span>
                  <?php endif; ?>
                </td>
                <td>
                  <?php if ((int)$c['is_taxable'] === 1): ?>
                    <span class="text-success"><i class="fas fa-check-circle"></i> Yes</span>
                  <?php else: ?>
                    <span class="text-muted"><i class="fas fa-minus-circle"></i> No</span>
                  <?php endif; ?>
                </td>
                <td>
                  <a href="<?= base_url('admin/payroll/toggle_component/' . $c['component_id']) ?>" 
                     class="badge <?= ((int)$c['is_active'] === 1) ? 'badge-success' : 'badge-secondary' ?> px-2 py-1"
                     title="Click to toggle status">
                    <?= ((int)$c['is_active'] === 1) ? 'Active' : 'Inactive' ?>
                  </a>
                </td>
                <td class="text-right pr-4">
                  <button type="button" class="btn btn-sm btn-outline-primary px-2 py-1 btn-edit-comp mr-1"
                          data-id="<?= $c['component_id'] ?>"
                          data-code="<?= esc($c['component_code']) ?>"
                          data-name="<?= esc($c['component_name']) ?>"
                          data-type="<?= esc($c['component_type']) ?>"
                          data-calc="<?= esc($c['calculation_type']) ?>"
                          data-base="<?= esc($c['percentage_base']) ?>"
                          data-val="<?= esc($c['percentage_value'] ?? '') ?>"
                          data-lop="<?= (int)$c['is_lop_applicable'] ?>"
                          data-tax="<?= (int)$c['is_taxable'] ?>"
                          data-act="<?= (int)$c['is_active'] ?>">
                    <i class="fas fa-edit"></i> Edit
                  </button>
                  <a href="<?= base_url('admin/payroll/delete_component/' . $c['component_id']) ?>" 
                     class="btn btn-sm btn-outline-danger px-2 py-1" 
                     onclick="return confirm('Are you sure you want to delete component <?= esc($c['component_code']) ?>?');">
                    <i class="fas fa-trash-alt"></i>
                  </a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

</div>

<!-- Modal: Add Salary Component -->
<div class="modal fade" id="addComponentModal" tabindex="-1" role="dialog" aria-labelledby="addComponentModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content border-0 shadow" style="border-radius: 14px;">
      <form method="post" action="<?= base_url('admin/payroll/save_component') ?>">
        <?= csrf_field() ?>
        <div class="modal-header border-0 pb-0">
          <h5 class="modal-title font-weight-bold text-dark" id="addComponentModalLabel">
            <i class="fas fa-plus-circle text-primary mr-2"></i> Add Salary Component
          </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body py-3">
          <div class="alert alert-info py-2 px-3 small border-0 mb-3" style="border-radius: 8px; background: #eff6ff; color: #1e40af; border-left: 4px solid #3b82f6 !important;">
            <i class="fas fa-magic mr-1"></i> <strong>Auto-Assignment to All Employees:</strong> Adding this new component will automatically attach it in <strong>Active</strong> state across all active employee salary structures. You can customize individual amounts anytime on the <a href="<?= base_url('admin/payroll/structures') ?>" class="text-primary font-weight-bold text-underline">Salary Structures</a> page.
          </div>

          <div class="form-row">
            <div class="form-group col-md-6">
              <label class="font-weight-bold text-dark small">Component Code</label>
              <input type="text" name="component_code" class="form-control" placeholder="e.g. SPECIAL_ALLOW" required style="border-radius: 8px; text-transform: uppercase;">
            </div>
            <div class="form-group col-md-6">
              <label class="font-weight-bold text-dark small">Component Name</label>
              <input type="text" name="component_name" class="form-control" placeholder="e.g. Special Allowance" required style="border-radius: 8px;">
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md-6">
              <label class="font-weight-bold text-dark small">Category Type</label>
              <select name="component_type" class="form-control" required style="border-radius: 8px;">
                <option value="EARNING">EARNING</option>
                <option value="DEDUCTION">DEDUCTION</option>
                <option value="EMPLOYER_CONTRIBUTION">EMPLOYER_CONTRIBUTION</option>
              </select>
            </div>
            <div class="form-group col-md-6">
              <label class="font-weight-bold text-dark small">Calculation Type</label>
              <select name="calculation_type" class="form-control" required style="border-radius: 8px;">
                <option value="FIXED">FIXED</option>
                <option value="PERCENTAGE">PERCENTAGE</option>
                <option value="FORMULA">FORMULA</option>
                <option value="MANUAL">MANUAL</option>
              </select>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md-4">
              <label class="font-weight-bold text-dark small">Percentage Base</label>
              <select name="percentage_base" class="form-control" style="border-radius: 8px;">
                <option value="NONE">NONE</option>
                <option value="BASIC">BASIC</option>
                <option value="GROSS">GROSS</option>
                <option value="CTC">CTC</option>
              </select>
            </div>
            <div class="form-group col-md-4">
              <label class="font-weight-bold text-dark small">Percentage (%)</label>
              <input type="number" step="0.0001" name="percentage_value" class="form-control" placeholder="e.g. 50.00" style="border-radius: 8px;">
            </div>
            <div class="form-group col-md-4">
              <label class="font-weight-bold text-dark small">Default Amount (₹)</label>
              <input type="number" step="0.01" name="default_monthly_amount" class="form-control" placeholder="0.00" style="border-radius: 8px;">
            </div>
          </div>

          <div class="form-group mb-0">
            <div class="custom-control custom-checkbox mb-2">
              <input type="checkbox" class="custom-control-input" id="is_lop_app" name="is_lop_applicable" value="1" checked>
              <label class="custom-control-label small font-weight-bold text-dark" for="is_lop_app">Subject to LOP (Loss of Pay) Proration</label>
            </div>
            <div class="custom-control custom-checkbox mb-2">
              <input type="checkbox" class="custom-control-input" id="is_tax" name="is_taxable" value="1" checked>
              <label class="custom-control-label small font-weight-bold text-dark" for="is_tax">Taxable Component</label>
            </div>
            <div class="custom-control custom-checkbox">
              <input type="checkbox" class="custom-control-input" id="is_act" name="is_active" value="1" checked>
              <label class="custom-control-label small font-weight-bold text-dark" for="is_act">Active Component</label>
            </div>
          </div>
        </div>
        <div class="modal-footer border-0 pt-0">
          <button type="button" class="btn btn-light border px-4" data-dismiss="modal" style="border-radius: 8px;">Cancel</button>
          <button type="submit" class="btn btn-primary px-4 font-weight-bold shadow-sm" style="border-radius: 8px;">Save Component</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal: Edit Salary Component -->
<div class="modal fade" id="editComponentModal" tabindex="-1" role="dialog" aria-labelledby="editComponentModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content border-0 shadow" style="border-radius: 14px;">
      <form method="post" action="<?= base_url('admin/payroll/save_component') ?>">
        <?= csrf_field() ?>
        <input type="hidden" name="component_id" id="edit_id">
        <div class="modal-header border-0 pb-0">
          <h5 class="modal-title font-weight-bold text-dark" id="editComponentModalLabel">
            <i class="fas fa-edit text-primary mr-2"></i> Edit Salary Component
          </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body py-3">
          <div class="form-row">
            <div class="form-group col-md-6">
              <label class="font-weight-bold text-dark small">Component Code</label>
              <input type="text" name="component_code" id="edit_code" class="form-control" required style="border-radius: 8px; text-transform: uppercase;">
            </div>
            <div class="form-group col-md-6">
              <label class="font-weight-bold text-dark small">Component Name</label>
              <input type="text" name="component_name" id="edit_name" class="form-control" required style="border-radius: 8px;">
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md-6">
              <label class="font-weight-bold text-dark small">Category Type</label>
              <select name="component_type" id="edit_type" class="form-control" required style="border-radius: 8px;">
                <option value="EARNING">EARNING</option>
                <option value="DEDUCTION">DEDUCTION</option>
                <option value="EMPLOYER_CONTRIBUTION">EMPLOYER_CONTRIBUTION</option>
              </select>
            </div>
            <div class="form-group col-md-6">
              <label class="font-weight-bold text-dark small">Calculation Type</label>
              <select name="calculation_type" id="edit_calc" class="form-control" required style="border-radius: 8px;">
                <option value="FIXED">FIXED</option>
                <option value="PERCENTAGE">PERCENTAGE</option>
                <option value="FORMULA">FORMULA</option>
                <option value="MANUAL">MANUAL</option>
              </select>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md-6">
              <label class="font-weight-bold text-dark small">Percentage Base</label>
              <select name="percentage_base" id="edit_base" class="form-control" style="border-radius: 8px;">
                <option value="NONE">NONE</option>
                <option value="BASIC">BASIC</option>
                <option value="GROSS">GROSS</option>
                <option value="CTC">CTC</option>
              </select>
            </div>
            <div class="form-group col-md-6">
              <label class="font-weight-bold text-dark small">Percentage Value (%)</label>
              <input type="number" step="0.0001" name="percentage_value" id="edit_val" class="form-control" style="border-radius: 8px;">
            </div>
          </div>

          <div class="form-group mb-0">
            <div class="custom-control custom-checkbox mb-2">
              <input type="checkbox" class="custom-control-input" id="edit_lop" name="is_lop_applicable" value="1">
              <label class="custom-control-label small font-weight-bold text-dark" for="edit_lop">Subject to LOP (Loss of Pay) Proration</label>
            </div>
            <div class="custom-control custom-checkbox mb-2">
              <input type="checkbox" class="custom-control-input" id="edit_tax" name="is_taxable" value="1">
              <label class="custom-control-label small font-weight-bold text-dark" for="edit_tax">Taxable Component</label>
            </div>
            <div class="custom-control custom-checkbox">
              <input type="checkbox" class="custom-control-input" id="edit_act" name="is_active" value="1">
              <label class="custom-control-label small font-weight-bold text-dark" for="edit_act">Active Component</label>
            </div>
          </div>
        </div>
        <div class="modal-footer border-0 pt-0">
          <button type="button" class="btn btn-light border px-4" data-dismiss="modal" style="border-radius: 8px;">Cancel</button>
          <button type="submit" class="btn btn-primary px-4 font-weight-bold shadow-sm" style="border-radius: 8px;">Update Component</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function() {
  $(document).on('click', '.btn-edit-comp', function(e) {
    e.preventDefault();
    $('#edit_id').val($(this).data('id'));
    $('#edit_code').val($(this).data('code'));
    $('#edit_name').val($(this).data('name'));
    $('#edit_type').val($(this).data('type'));
    $('#edit_calc').val($(this).data('calc'));
    $('#edit_base').val($(this).data('base'));
    $('#edit_val').val($(this).data('val'));
    $('#edit_lop').prop('checked', parseInt($(this).data('lop')) === 1);
    $('#edit_tax').prop('checked', parseInt($(this).data('tax')) === 1);
    $('#edit_act').prop('checked', parseInt($(this).data('act')) === 1);

    $('#editComponentModal').modal('show');
  });
});
</script>
