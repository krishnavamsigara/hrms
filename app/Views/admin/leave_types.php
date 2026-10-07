<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bloom Solutions | Leave Types</title>
  
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">

  <style>
    :root { 
        --bloom-purple: #4a00e0; 
        --soft-gray: #f8fafc; 
        --border-color: #e2e8f0; 
    }

    body { 
        font-family: 'Plus Jakarta Sans', sans-serif; 
        background-color: var(--soft-gray); 
        font-size: 13px; 
        color: #334155;
    }

    .main-header {
      border-bottom: 1px solid #e2e8f0 !important;
      background: #ffffff !important;
      height: 55px;
    }

    .main-sidebar {
      background: #111c43 !important;
    }

    .card-bloom { 
        border: 1px solid var(--border-color) !important; 
        border-radius: 20px !important; 
        background: #fff; 
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.04); 
        overflow: hidden;
    }

    .table thead th { 
        border-top: none; 
        border-bottom: 1px solid var(--border-color); 
        letter-spacing: 0.5px; 
        padding: 15px;
        text-align: center;
    }
    .table td { vertical-align: middle !important; padding: 12px; border-top: 1px solid #f1f5f9; text-align: center; }
    
    .lt-icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        background: #f0f7ff;
        color: var(--bloom-purple);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
    }

    .search-input {
        border-radius: 12px;
        border: 1px solid var(--border-color);
        padding-left: 35px;
        transition: 0.3s;
    }
    .search-input:focus {
        border-color: var(--bloom-purple);
        box-shadow: 0 0 0 4px rgba(74, 0, 224, 0.05);
    }

    .badge-status-active {
        background-color: #e6f4ea;
        color: #137333;
        font-weight: 600;
        padding: 4px 10px;
        border-radius: 12px;
        font-size: 11px;
    }
    .badge-status-inactive {
        background-color: #fce8e6;
        color: #c5221f;
        font-weight: 600;
        padding: 4px 10px;
        border-radius: 12px;
        font-size: 11px;
    }

    .modal-content {
        border-radius: 16px;
        border: none;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }
    .modal-header {
        border-bottom: 1px solid var(--border-color);
        background: #f8fafc;
        border-top-left-radius: 16px;
        border-top-right-radius: 16px;
    }

    .btn-gen-balances {
        background: #111c43;
        color: white;
        border-radius: 20px;
        font-weight: 600;
        border: none;
        transition: 0.3s;
    }
    .btn-gen-balances:hover {
        background: var(--bloom-purple);
        color: white;
    }
  </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">

   <div class="content-wrapper p-4">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
      <div>
        <h4 class="font-weight-bold mb-0">Leave Types Management</h4>
        <small class="text-muted">Configure organization leave policies, quotas, and accruals</small>
      </div>
      <div>
        <button class="btn btn-gen-balances px-3 py-2 mr-2" data-toggle="modal" data-target="#generateBalancesModal">
          <i class="fas fa-magic mr-1"></i> Generate Balances
        </button>
        <button class="btn btn-primary rounded-pill px-4 py-2" style="background:var(--bloom-purple); border:none;" data-toggle="modal" data-target="#addLeaveTypeModal">
          <i class="fas fa-plus mr-1"></i> Add Leave Type
        </button>
      </div>
    </div>

    <!-- Alert container -->
    <div id="alertContainer"></div>

    <div class="card-bloom">
      <div class="p-3 border-bottom position-relative d-flex justify-content-between align-items-center">
        <div class="position-relative w-25">
            <i class="fas fa-search position-absolute" style="left: 12px; top: 10px; color: #94a3b8;"></i>
            <input type="text" id="ltSearch" class="form-control form-control-sm search-input" placeholder="Search leave types...">
        </div>
        <small class="text-muted font-weight-bold">Total Configurations: <?= count($leave_types ?? []) ?></small>
      </div>

      <div class="table-responsive">
        <table class="table table-hover mb-0">
          <thead class="bg-light">
            <tr class="small text-uppercase text-muted">
              <th>ID</th>
              <th>Code</th>
              <th class="text-left">Leave Name</th>
              <th>Year</th>
              <th>Yearly Quota</th>
              <th>Accrual</th>
              <th>Salary Effect</th>
              <th>Gender</th>
              <th>Status</th>
              <th class="text-right pr-4">Action</th>
            </tr>
          </thead>
          <tbody id="ltTableBody">
          <?php if (!empty($leave_types)): ?>
              <?php foreach ($leave_types as $row): ?>
                  <tr class="lt-row" id="row-lt-<?= esc($row['leave_type_id']) ?>">
                      <td class="font-weight-bold text-muted">#<?= esc($row['leave_type_id']) ?></td>
                      <td>
                          <span class="badge badge-dark px-2 py-1"><?= esc($row['leave_code']) ?></span>
                      </td>
                      <td class="text-left">
                          <strong class="lt-title text-dark"><?= esc($row['leave_name']) ?></strong>
                      </td>
                      <td class="font-weight-bold"><?= esc($row['year'] ?? '') ?></td>
                      <td class="font-weight-bold text-primary"><?= esc(number_format((float)($row['yearly_quota'] ?? 0), 1)) ?> Days</td>
                      <td>
                          <?php if (($row['is_accrual'] ?? 'N') === 'Y'): ?>
                              <span class="badge badge-info px-2">Yes</span>
                          <?php else: ?>
                              <span class="badge badge-light border px-2">No</span>
                          <?php endif; ?>
                      </td>
                      <td>
                          <?php if (($row['affects_salary'] ?? 'N') === 'Y'): ?>
                              <span class="badge badge-warning px-2">Loss of Pay</span>
                          <?php else: ?>
                              <span class="badge badge-light border px-2">Paid</span>
                          <?php endif; ?>
                      </td>
                      <td>
                          <span class="small font-weight-bold"><?= esc($row['gender_applicable'] ?? 'ALL') ?></span>
                      </td>
                      <td>
                          <?php if (($row['status'] ?? 'A') === 'A' || ($row['status'] ?? 'A') === '1'): ?>
                              <span class="badge-status-active"><i class="fas fa-check-circle mr-1"></i> Active</span>
                          <?php else: ?>
                              <span class="badge-status-inactive"><i class="fas fa-times-circle mr-1"></i> Inactive</span>
                          <?php endif; ?>
                      </td>

                      <td class="text-right pr-4">
                          <button class="btn btn-sm btn-outline-primary rounded-pill px-3 mr-1 btn-edit-lt"
                                  data-id="<?= esc($row['leave_type_id'] ?? '') ?>"
                                  data-code="<?= esc($row['leave_code'] ?? '') ?>"
                                  data-name="<?= esc($row['leave_name'] ?? '') ?>"
                                  data-year="<?= esc($row['year'] ?? '') ?>"
                                  data-quota="<?= esc($row['yearly_quota'] ?? '0') ?>"
                                  data-carry="<?= esc($row['carry_forward_flag'] ?? 'N') ?>"
                                  data-maxcarry="<?= esc($row['max_carry_forward'] ?? '0') ?>"
                                  data-encash="<?= esc($row['encashment_flag'] ?? 'N') ?>"
                                  data-approval="<?= esc($row['requires_approval'] ?? 'Y') ?>"
                                  data-salary="<?= esc($row['affects_salary'] ?? 'N') ?>"
                                  data-gender="<?= esc($row['gender_applicable'] ?? '') ?>"
                                  data-status="<?= esc($row['status'] ?? 'A') ?>"
                                  data-accrual="<?= esc($row['is_accrual'] ?? 'N') ?>">
                              <i class="fas fa-edit mr-1"></i> Edit
                          </button>
                          <button class="btn btn-sm btn-outline-danger rounded-pill px-3 btn-delete-lt"
                                  data-id="<?= esc($row['leave_type_id'] ?? '') ?>"
                                  data-name="<?= esc($row['leave_name'] ?? '') ?>">
                              <i class="fas fa-trash-alt mr-1"></i> Delete
                          </button>
                      </td>
                  </tr>
              <?php endforeach; ?>
          <?php else: ?>
              <tr>
                  <td colspan="10" class="text-center py-4 text-muted">
                      No leave types configured.
                  </td>
              </tr>
          <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>

  </div>
</div>

<!-- ADD LEAVE TYPE MODAL -->
<div class="modal fade" id="addLeaveTypeModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title font-weight-bold text-dark"><i class="fas fa-plus-circle text-primary mr-2"></i> Add Leave Type</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="addLeaveTypeForm">
        <div class="modal-body p-4">
          <input type="hidden" name="mode" value="INSERT">
          <div class="row">
              <div class="col-md-4 form-group">
                <label class="font-weight-bold text-muted small">LEAVE CODE <span class="text-danger">*</span></label>
                <input type="text" name="leave_code" class="form-control" placeholder="e.g. PL, SL, WFH" required style="text-transform:uppercase;">
              </div>
              <div class="col-md-8 form-group">
                <label class="font-weight-bold text-muted small">LEAVE NAME <span class="text-danger">*</span></label>
                <input type="text" name="leave_name" class="form-control" placeholder="e.g. Personal Leave" required>
              </div>
          </div>
          <div class="row">
              <div class="col-md-4 form-group">
                <label class="font-weight-bold text-muted small">YEAR</label>
                <input type="number" name="year" class="form-control" value="<?= date('Y') ?>" required>
              </div>
              <div class="col-md-4 form-group">
                <label class="font-weight-bold text-muted small">YEARLY QUOTA (DAYS)</label>
                <input type="number" step="0.5" name="yearly_quota" class="form-control" value="12.0" required>
              </div>
              <div class="col-md-4 form-group">
                <label class="font-weight-bold text-muted small">ACCRUAL LEAVE</label>
                <select name="is_accrual" class="form-control">
                  <option value="Y" selected>Yes (Monthly Accrual)</option>
                  <option value="N">No (Lump sum)</option>
                </select>
              </div>
          </div>
          <div class="row">
              <div class="col-md-4 form-group">
                <label class="font-weight-bold text-muted small">REQUIRES APPROVAL</label>
                <select name="requires_approval" class="form-control">
                  <option value="Y" selected>Yes</option>
                  <option value="N">No</option>
                </select>
              </div>
              <div class="col-md-4 form-group">
                <label class="font-weight-bold text-muted small">AFFECTS SALARY (LOP)</label>
                <select name="affects_salary" class="form-control">
                  <option value="N" selected>No (Paid)</option>
                  <option value="Y">Yes (Loss of Pay)</option>
                </select>
              </div>
              <div class="col-md-4 form-group">
                <label class="font-weight-bold text-muted small">GENDER APPLICABLE</label>
                <select name="gender_applicable" class="form-control">
                  <option value="" selected>ALL Genders</option>
                  <option value="FEMALE">Female Only</option>
                  <option value="MALE">Male Only</option>
                </select>
              </div>
          </div>
          <div class="form-group mb-0">
            <label class="font-weight-bold text-muted small">STATUS</label>
            <select name="status" class="form-control">
              <option value="A" selected>Active</option>
              <option value="I">Inactive</option>
            </select>
          </div>
        </div>
        <div class="modal-footer bg-light border-0">
          <button type="button" class="btn btn-secondary rounded-pill px-4" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary rounded-pill px-4" style="background:var(--bloom-purple); border:none;">
            <i class="fas fa-save mr-1"></i> Save Leave Type
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- EDIT LEAVE TYPE MODAL -->
<div class="modal fade" id="editLeaveTypeModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title font-weight-bold text-dark"><i class="fas fa-edit text-primary mr-2"></i> Edit Leave Type</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="editLeaveTypeForm">
        <div class="modal-body p-4">
          <input type="hidden" name="mode" value="UPDATE">
          <input type="hidden" name="leave_type_id" id="editLtId">
          <div class="row">
              <div class="col-md-4 form-group">
                <label class="font-weight-bold text-muted small">LEAVE CODE <span class="text-danger">*</span></label>
                <input type="text" name="leave_code" id="editLtCode" class="form-control" required style="text-transform:uppercase;">
              </div>
              <div class="col-md-8 form-group">
                <label class="font-weight-bold text-muted small">LEAVE NAME <span class="text-danger">*</span></label>
                <input type="text" name="leave_name" id="editLtName" class="form-control" required>
              </div>
          </div>
          <div class="row">
              <div class="col-md-4 form-group">
                <label class="font-weight-bold text-muted small">YEAR</label>
                <input type="number" name="year" id="editLtYear" class="form-control" required>
              </div>
              <div class="col-md-4 form-group">
                <label class="font-weight-bold text-muted small">YEARLY QUOTA (DAYS)</label>
                <input type="number" step="0.5" name="yearly_quota" id="editLtQuota" class="form-control" required>
              </div>
              <div class="col-md-4 form-group">
                <label class="font-weight-bold text-muted small">ACCRUAL LEAVE</label>
                <select name="is_accrual" id="editLtAccrual" class="form-control">
                  <option value="Y">Yes (Monthly Accrual)</option>
                  <option value="N">No (Lump sum)</option>
                </select>
              </div>
          </div>
          <div class="row">
              <div class="col-md-4 form-group">
                <label class="font-weight-bold text-muted small">REQUIRES APPROVAL</label>
                <select name="requires_approval" id="editLtApproval" class="form-control">
                  <option value="Y">Yes</option>
                  <option value="N">No</option>
                </select>
              </div>
              <div class="col-md-4 form-group">
                <label class="font-weight-bold text-muted small">AFFECTS SALARY (LOP)</label>
                <select name="affects_salary" id="editLtSalary" class="form-control">
                  <option value="N">No (Paid)</option>
                  <option value="Y">Yes (Loss of Pay)</option>
                </select>
              </div>
              <div class="col-md-4 form-group">
                <label class="font-weight-bold text-muted small">GENDER APPLICABLE</label>
                <select name="gender_applicable" id="editLtGender" class="form-control">
                  <option value="">ALL Genders</option>
                  <option value="FEMALE">Female Only</option>
                  <option value="MALE">Male Only</option>
                </select>
              </div>
          </div>
          <div class="form-group mb-0">
            <label class="font-weight-bold text-muted small">STATUS</label>
            <select name="status" id="editLtStatus" class="form-control">
              <option value="A">Active</option>
              <option value="I">Inactive</option>
            </select>
          </div>
        </div>
        <div class="modal-footer bg-light border-0">
          <button type="button" class="btn btn-secondary rounded-pill px-4" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary rounded-pill px-4" style="background:var(--bloom-purple); border:none;">
            <i class="fas fa-check-circle mr-1"></i> Update Leave Type
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- DELETE CONFIRMATION MODAL -->
<div class="modal fade" id="deleteLeaveTypeModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header border-0 pb-0">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="deleteLeaveTypeForm">
        <div class="modal-body text-center pt-0 px-4">
          <input type="hidden" name="mode" value="DELETE">
          <input type="hidden" name="leave_type_id" id="deleteLtId">
          <div class="text-danger mb-3" style="font-size: 40px;">
            <i class="fas fa-exclamation-circle"></i>
          </div>
          <h5 class="font-weight-bold">Are you sure?</h5>
          <p class="text-muted small">Do you really want to delete leave type <strong id="deleteLtName" class="text-dark"></strong>?</p>
        </div>
        <div class="modal-footer border-0 justify-content-center pt-0 pb-4">
          <button type="button" class="btn btn-light rounded-pill px-4" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-danger rounded-pill px-4">Delete</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- GENERATE LEAVE BALANCES MODAL -->
<div class="modal fade" id="generateBalancesModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title font-weight-bold text-dark"><i class="fas fa-magic text-primary mr-2"></i> Generate Balances</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="generateBalancesForm">
        <div class="modal-body p-4 text-center">
          <p class="text-muted small mb-3">Select the target year to generate leave quota balances for all active employees.</p>
          <div class="form-group mb-0">
            <label class="font-weight-bold text-muted small">TARGET YEAR</label>
            <select name="year" class="form-control form-control-lg text-center font-weight-bold">
              <option value="2026" selected>Year 2026</option>
              <option value="2025">Year 2025</option>
              <option value="2027">Year 2027</option>
            </select>
          </div>
        </div>
        <div class="modal-footer bg-light border-0 justify-content-center">
          <button type="button" class="btn btn-secondary rounded-pill px-3" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-gen-balances rounded-pill px-4 py-2">
            <i class="fas fa-cogs mr-1"></i> Generate
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

<script>
$(document).ready(function(){
  // Search filter
  $("#ltSearch").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#ltTableBody .lt-row").filter(function() {
      $(this).toggle($(this).find(".lt-title").text().toLowerCase().indexOf(value) > -1)
    });
  });

  function showAlert(type, message) {
    var alertHtml = '<div class="alert alert-' + type + ' alert-dismissible fade show rounded-lg shadow-sm mb-4" role="alert">' +
      '<strong>' + (type === 'success' ? 'Success!' : 'Error!') + '</strong> ' + message +
      '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
      '<span aria-hidden="true">&times;</span></button></div>';
    $('#alertContainer').html(alertHtml);
    setTimeout(function() { $('.alert').alert('close'); }, 4000);
  }

  // Submit Add Leave Type Form
  $('#addLeaveTypeForm').on('submit', function(e){
    e.preventDefault();
    $.ajax({
      url: '<?= base_url("admin/save_leave_type") ?>',
      type: 'POST',
      data: $(this).serialize(),
      dataType: 'json',
      success: function(res) {
        if (res.status === 'success') {
          $('#addLeaveTypeModal').modal('hide');
          $('#addLeaveTypeForm')[0].reset();
          showAlert('success', res.message);
          setTimeout(function(){ location.reload(); }, 800);
        } else {
          showAlert('danger', res.message);
        }
      },
      error: function() {
        showAlert('danger', 'Failed to communicate with server.');
      }
    });
  });

  // Open Edit Leave Type Modal
  $(document).on('click', '.btn-edit-lt', function(){
    var id = $(this).data('id');
    var code = $(this).data('code');
    var name = $(this).data('name');
    var year = $(this).data('year');
    var quota = $(this).data('quota');
    var approval = $(this).data('approval');
    var salary = $(this).data('salary');
    var gender = $(this).data('gender');
    var status = $(this).data('status');
    var accrual = $(this).data('accrual');

    $('#editLtId').val(id);
    $('#editLtCode').val(code);
    $('#editLtName').val(name);
    $('#editLtYear').val(year);
    $('#editLtQuota').val(quota);
    $('#editLtApproval').val(approval);
    $('#editLtSalary').val(salary);
    $('#editLtGender').val(gender);
    $('#editLtStatus').val(status);
    $('#editLtAccrual').val(accrual);

    $('#editLeaveTypeModal').modal('show');
  });

  // Submit Edit Leave Type Form
  $('#editLeaveTypeForm').on('submit', function(e){
    e.preventDefault();
    $.ajax({
      url: '<?= base_url("admin/save_leave_type") ?>',
      type: 'POST',
      data: $(this).serialize(),
      dataType: 'json',
      success: function(res) {
        if (res.status === 'success') {
          $('#editLeaveTypeModal').modal('hide');
          showAlert('success', res.message);
          setTimeout(function(){ location.reload(); }, 800);
        } else {
          showAlert('danger', res.message);
        }
      },
      error: function() {
        showAlert('danger', 'Failed to update leave type.');
      }
    });
  });

  // Open Delete Modal
  $(document).on('click', '.btn-delete-lt', function(){
    var id = $(this).data('id');
    var name = $(this).data('name');

    $('#deleteLtId').val(id);
    $('#deleteLtName').text(name);
    $('#deleteLeaveTypeModal').modal('show');
  });

  // Submit Delete Form
  $('#deleteLeaveTypeForm').on('submit', function(e){
    e.preventDefault();
    $.ajax({
      url: '<?= base_url("admin/save_leave_type") ?>',
      type: 'POST',
      data: $(this).serialize(),
      dataType: 'json',
      success: function(res) {
        if (res.status === 'success') {
          $('#deleteLeaveTypeModal').modal('hide');
          showAlert('success', res.message);
          setTimeout(function(){ location.reload(); }, 800);
        } else {
          showAlert('danger', res.message);
        }
      },
      error: function() {
        showAlert('danger', 'Failed to delete leave type.');
      }
    });
  });

  // Submit Generate Balances Form
  $('#generateBalancesForm').on('submit', function(e){
    e.preventDefault();
    $.ajax({
      url: '<?= base_url("admin/generate_leave_balances") ?>',
      type: 'POST',
      data: $(this).serialize(),
      dataType: 'json',
      success: function(res) {
        if (res.status === 'success') {
          $('#generateBalancesModal').modal('hide');
          showAlert('success', res.message);
        } else {
          showAlert('danger', res.message);
        }
      },
      error: function() {
        showAlert('danger', 'Failed to generate leave balances.');
      }
    });
  });

});
</script>

</body>
</html>
