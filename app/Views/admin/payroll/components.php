<div class="content-wrapper p-3">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2 align-items-center">
        <div class="col-sm-6">
          <h1 class="m-0 font-weight-bold text-dark">
            <a href="<?= base_url('admin/payroll') ?>" class="text-secondary mr-2"><i class="fas fa-arrow-left"></i></a>
            Salary Component Master
          </h1>
          <p class="text-muted small mb-0">Configure Earnings, Deductions, and Statutory Rules (EPF, ESI, PT Telangana Slabs, TDS).</p>
        </div>
        <div class="col-sm-6 text-right">
          <button class="btn btn-primary btn-sm font-weight-bold" data-toggle="modal" data-target="#addComponentModal" id="btnAddNewComp"><i class="fas fa-plus mr-1"></i> Add New Component</button>
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
        <div class="card-header bg-white pt-3">
          <h3 class="card-title font-weight-bold text-secondary"><i class="fas fa-sliders-h mr-2"></i> Master Salary Components Definition</h3>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
              <thead class="bg-light text-uppercase text-secondary small">
                <tr>
                  <th>Order</th>
                  <th>Code</th>
                  <th>Component Name</th>
                  <th>Type</th>
                  <th>Calculation</th>
                  <th>Value</th>
                  <th>Based On</th>
                  <th>Statutory?</th>
                  <th>Status</th>
                  <th class="text-center">Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php if (!empty($components)): ?>
                  <?php foreach ($components as $c): ?>
                    <tr>
                      <td class="font-weight-bold text-muted"><?= esc($c['display_order']) ?></td>
                      <td class="font-weight-bold text-primary"><code><?= esc($c['component_code']) ?></code></td>
                      <td class="font-weight-bold text-dark"><?= esc($c['component_name']) ?></td>
                      <td>
                        <?php if ($c['component_type'] == 'EARNING'): ?>
                          <span class="badge badge-success px-2 py-1">EARNING</span>
                        <?php elseif ($c['component_type'] == 'DEDUCTION'): ?>
                          <span class="badge badge-danger px-2 py-1">DEDUCTION</span>
                        <?php else: ?>
                          <span class="badge badge-info px-2 py-1">STATUTORY</span>
                        <?php endif; ?>
                      </td>
                      <td><span class="badge badge-light border"><?= esc($c['calculation_type']) ?></span></td>
                      <td class="font-weight-bold"><?= esc($c['value']) ?><?= $c['calculation_type'] == 'PERCENTAGE' ? '%' : '' ?></td>
                      <td><span class="text-muted small"><?= esc($c['based_on'] ?: 'N/A') ?></span></td>
                      <td><?= $c['is_statutory'] ? '<span class="badge badge-warning text-dark">YES</span>' : '<span class="text-muted">No</span>' ?></td>
                      <td><?= $c['is_active'] ? '<span class="badge badge-success">ACTIVE</span>' : '<span class="badge badge-secondary">INACTIVE</span>' ?></td>
                      <td class="text-center">
                        <button class="btn btn-sm btn-outline-primary shadow-sm btn-edit-comp mr-1"
                          data-id="<?= $c['id'] ?>"
                          data-code="<?= esc($c['component_code']) ?>"
                          data-name="<?= esc($c['component_name']) ?>"
                          data-type="<?= esc($c['component_type']) ?>"
                          data-calc="<?= esc($c['calculation_type']) ?>"
                          data-val="<?= esc($c['value']) ?>"
                          data-based="<?= esc($c['based_on']) ?>"
                          data-stat="<?= esc($c['is_statutory']) ?>"
                          data-emp="<?= esc($c['is_employer_contribution']) ?>"
                          data-order="<?= esc($c['display_order']) ?>">
                          <i class="fas fa-edit"></i> Edit
                        </button>
                        <a href="<?= base_url('admin/payroll/toggle_component/' . $c['id']) ?>" class="btn btn-sm btn-outline-warning shadow-sm mr-1" title="Toggle Status">
                          <i class="fas fa-power-off"></i>
                        </a>
                        <a href="<?= base_url('admin/payroll/delete_component/' . $c['id']) ?>" class="btn btn-sm btn-outline-danger shadow-sm" onclick="return confirm('Are you sure you want to soft delete this component?');" title="Soft Delete">
                          <i class="fas fa-trash-alt"></i>
                        </a>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr>
                    <td colspan="10" class="text-center text-muted py-4">No components defined. Click "Add New Component" to create one.</td>
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

<!-- Modal: Add / Edit Component -->
<div class="modal fade" id="addComponentModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="<?= base_url('admin/payroll/save_component') ?>" method="POST" id="componentForm">
        <input type="hidden" name="id" id="comp_id" value="">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-header-title font-weight-bold m-0" id="compModalTitle"><i class="fas fa-plus-circle mr-2"></i> Add Salary Component Master</h5>
          <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close"><span>&times;</span></button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label class="font-weight-bold">Component Code <span class="text-danger">*</span></label>
            <input type="text" name="component_code" id="comp_code" class="form-control text-uppercase" placeholder="e.g. SPECIAL_ALLOWANCE" required>
          </div>
          <div class="form-group">
            <label class="font-weight-bold">Component Name <span class="text-danger">*</span></label>
            <input type="text" name="component_name" id="comp_name" class="form-control" placeholder="e.g. Special Allowance" required>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label class="font-weight-bold">Type <span class="text-danger">*</span></label>
              <select name="component_type" id="comp_type" class="form-control" required>
                <option value="EARNING">EARNING</option>
                <option value="DEDUCTION">DEDUCTION</option>
                <option value="STATUTORY">STATUTORY</option>
              </select>
            </div>
            <div class="form-group col-md-6">
              <label class="font-weight-bold">Calculation Type <span class="text-danger">*</span></label>
              <select name="calculation_type" id="comp_calc" class="form-control" required>
                <option value="PERCENTAGE">PERCENTAGE</option>
                <option value="FIXED">FIXED</option>
                <option value="SLAB">SLAB</option>
              </select>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label class="font-weight-bold">Default Value (%) or (₹)</label>
              <input type="number" step="0.01" name="value" id="comp_val" class="form-control" value="0.00">
            </div>
            <div class="form-group col-md-6">
              <label class="font-weight-bold">Based On</label>
              <select name="based_on" id="comp_based" class="form-control">
                <option value="CTC">CTC</option>
                <option value="BASIC">BASIC</option>
                <option value="GROSS">GROSS</option>
              </select>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label class="font-weight-bold">Statutory Component?</label>
              <select name="is_statutory" id="comp_stat" class="form-control">
                <option value="0">No</option>
                <option value="1">Yes</option>
              </select>
            </div>
            <div class="form-group col-md-6">
              <label class="font-weight-bold">Display Order</label>
              <input type="number" name="display_order" id="comp_order" class="form-control" value="1">
            </div>
          </div>
        </div>
        <div class="modal-footer bg-light">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary font-weight-bold"><i class="fas fa-save mr-1"></i> Save Component</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function() {
  $('#btnAddNewComp').on('click', function() {
    $('#componentForm')[0].reset();
    $('#comp_id').val('');
    $('#compModalTitle').html('<i class="fas fa-plus-circle mr-2"></i> Add Salary Component Master');
    $('#addComponentModal').modal('show');
  });

  $(document).on('click', '.btn-edit-comp', function() {
    var btn = $(this);
    $('#comp_id').val(btn.data('id'));
    $('#comp_code').val(btn.data('code'));
    $('#comp_name').val(btn.data('name'));
    $('#comp_type').val(btn.data('type'));
    $('#comp_calc').val(btn.data('calc'));
    $('#comp_val').val(btn.data('val'));
    $('#comp_based').val(btn.data('based') || 'CTC');
    $('#comp_stat').val(btn.data('stat') || '0');
    $('#comp_order').val(btn.data('order') || '1');

    $('#compModalTitle').html('<i class="fas fa-edit mr-2"></i> Edit Salary Component Master');
    $('#addComponentModal').modal('show');
  });
});
</script>
