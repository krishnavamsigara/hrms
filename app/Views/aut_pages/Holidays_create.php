<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bloom Solutions | Holiday Master</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,600,700&display=fallback">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/css/bootstrap-datepicker.min.css">

    <style>
        :root {
            --primary: #4a00e0;
            --dark: #111c43;
            --bg: #f4f7fe;
        }

        body {
            background: var(--bg);
            font-family: 'Inter', sans-serif;
            font-size: 13px;
        }

        .content-wrapper {
            background: var(--bg);
            min-height: 100vh;
            padding: 30px;
        }

        .page-header {
            background: linear-gradient(135deg, var(--dark), var(--primary));
            color: #fff;
            padding: 22px 28px;
            border-radius: 20px;
            margin-bottom: 25px;
            box-shadow: 0 10px 25px rgba(74,0,224,.18);
        }

        .page-header h3 {
            margin: 0;
            font-weight: 700;
        }

        .page-header p {
            margin: 6px 0 0;
            opacity: .9;
        }

        .table-card {
            background: #fff;
            border-radius: 20px;
            padding: 20px;
            box-shadow: 0 8px 25px rgba(0,0,0,.06);
        }

        .table thead th {
            background: #4a00e0;
            color: #fff;
            border: none;
            font-weight: 600;
            padding: 14px;
            text-align: center;
        }

        .table tbody td {
            vertical-align: middle;
            padding: 14px;
            border-color: #eef2f7;
            text-align: center;
        }

        .table-hover tbody tr:hover {
            background: #f8f9ff;
        }

        .holiday-table {
            max-height: 600px;
            overflow-y: auto;
        }

        .holiday-table thead th {
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .table-tools {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 20px;
        }

        .search-box {
            width: 250px;
            border-radius: 10px;
        }

        .filter-select {
            width: 160px;
            border-radius: 10px;
        }

        .add-btn-main {
            background: var(--primary);
            color: white;
            border-radius: 25px;
            padding: 8px 20px;
            border: none;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(74, 0, 224, 0.25);
            transition: all 0.3s;
        }

        .add-btn-main:hover {
            background: var(--dark);
            color: white;
        }

        .holiday-badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 10px;
            font-size: 12px;
            font-weight: 600;
        }

        .holiday-purple { background: #ede9fe; color: #5b21b6; border: 1px solid #d8b4fe; }
        .holiday-green  { background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0; }
        .holiday-blue   { background: #EEF4FF; color: #1D4ED8; border: 1px solid #BFDBFE; }
        .holiday-magenta{ background: #FDF2FF; color: #A21CAF; border: 1px solid #e9d5ff; }

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
            border-bottom: 1px solid #e2e8f0;
            background: #f8fafc;
            border-top-left-radius: 16px;
            border-top-right-radius: 16px;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini">

<div class="content-wrapper">

    <div class="page-header d-flex justify-content-between align-items-center">
        <div>
            <h3><i class="fas fa-calendar-alt mr-2"></i>Holiday Master Management</h3>
            <p>Bloom Solutions Pvt Ltd - Create & Manage Organization Holidays</p>
        </div>
        <button type="button" class="add-btn-main" data-toggle="modal" data-target="#addHolidayModal">
            <i class="fas fa-plus mr-1"></i> Add Holiday
        </button>
    </div>

    <!-- Alert Container -->
    <div id="alertContainer"></div>

    <div class="table-card">
        <div class="table-tools">
            <div class="d-flex align-items-center flex-wrap" style="gap: 10px;">
                <div class="position-relative">
                    <input type="text" id="holidaySearch" class="form-control search-box" placeholder="Search Holiday...">
                </div>

                <select id="yearFilter" class="form-control filter-select">
                    <option value="ALL">All Years</option>
                    <?php 
                    $currentY = date('Y');
                    for ($y = $currentY + 1; $y >= 2024; $y--): 
                    ?>
                        <option value="<?= $y ?>" <?= ($y == $currentY) ? 'selected' : '' ?>>Year <?= $y ?></option>
                    <?php endfor; ?>
                </select>

                <select id="typeFilter" class="form-control filter-select">
                    <option value="ALL">All Types</option>
                    <option value="FESTIVAL">Festival</option>
                    <option value="NATIONAL">National</option>
                    <option value="COMPANY">Company</option>
                    <option value="WEEK_OFF">Week Off</option>
                    <option value="OPTIONAL">Optional</option>
                </select>
            </div>

            <small class="text-muted font-weight-bold" id="holidayCountText">Total Holidays: <?= count($holiday ?? []) ?></small>
        </div>

        <div class="table-responsive holiday-table">
            <table class="table table-bordered table-hover">
                <thead class="bg-primary">
                    <tr>
                        <th width="8%">ID</th>
                        <th width="32%">Holiday Name</th>
                        <th width="20%">Holiday Date</th>
                        <th width="15%">Type</th>
                        <th width="10%">Status</th>
                        <th width="15%">Action</th>
                    </tr>
                </thead>

                <tbody id="holidayBody">
                <?php if (!empty($holiday)): ?>
                    <?php $i = 0; ?>
                    <?php foreach ($holiday as $h): ?>
                        <?php
                        $hYear = date('Y', strtotime($h['holiday_date']));
                        $hDateFormatted = date('d-m-Y', strtotime($h['holiday_date']));
                        $hStatus = $h['status'] ?? 'A';

                        $holidayColors = ['holiday-purple', 'holiday-green', 'holiday-blue', 'holiday-magenta'];
                        $badgeClass = $holidayColors[$i % count($holidayColors)];
                        $i++;
                        ?>
                        <tr class="holiday-row" 
                            data-year="<?= $hYear ?>" 
                            data-type="<?= esc($h['holiday_type'] ?? 'FESTIVAL') ?>"
                            data-status="<?= $hStatus ?>"
                            id="row-holiday-<?= esc($h['holiday_id']) ?>">
                            <td class="font-weight-bold text-muted">#<?= esc($h['holiday_id']) ?></td>
                            <td class="text-left font-weight-bold">
                                <span class="holiday-badge <?= $badgeClass ?> holiday-title">
                                    <?= esc($h['holiday_name']) ?>
                                </span>
                            </td>
                            <td>
                                <span class="font-weight-bold text-dark">
                                    <i class="far fa-calendar-alt text-primary mr-1"></i>
                                    <?= $hDateFormatted ?>
                                </span>
                            </td>
                            <td>
                                <span class="badge badge-light border px-2 py-1">
                                    <?= esc($h['holiday_type'] ?? 'FESTIVAL') ?>
                                </span>
                            </td>
                            <td>
                                <?php if ($hStatus === 'A' || $hStatus === '1'): ?>
                                    <span class="badge-status-active"><i class="fas fa-check-circle mr-1"></i> Active</span>
                                <?php else: ?>
                                    <span class="badge-status-inactive"><i class="fas fa-times-circle mr-1"></i> Inactive</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary rounded-pill px-3 mr-1 btn-edit-holiday"
                                        data-id="<?= esc($h['holiday_id']) ?>"
                                        data-name="<?= esc($h['holiday_name']) ?>"
                                        data-date="<?= $hDateFormatted ?>"
                                        data-type="<?= esc($h['holiday_type'] ?? 'FESTIVAL') ?>"
                                        data-applicable="<?= esc($h['applicable_for'] ?? 'ALL') ?>"
                                        data-status="<?= $hStatus ?>">
                                    <i class="fas fa-edit mr-1"></i> Edit
                                </button>
                                <button class="btn btn-sm btn-outline-danger rounded-pill px-3 btn-delete-holiday"
                                        data-id="<?= esc($h['holiday_id']) ?>"
                                        data-name="<?= esc($h['holiday_name']) ?>">
                                    <i class="fas fa-trash-alt mr-1"></i> Delete
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">
                            No holiday records found.
                        </td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ADD HOLIDAY MODAL -->
<div class="modal fade" id="addHolidayModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title font-weight-bold text-dark"><i class="fas fa-calendar-plus text-primary mr-2"></i> Add Holiday</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="addHolidayForm">
        <div class="modal-body p-4">
          <input type="hidden" name="mode" value="INSERT">
          <div class="form-group">
            <label class="font-weight-bold text-muted small">HOLIDAY NAME <span class="text-danger">*</span></label>
            <input type="text" name="holiday_name" class="form-control form-control-lg" placeholder="e.g. Diwali" required>
          </div>
          <div class="form-group">
            <label class="font-weight-bold text-muted small">HOLIDAY DATE <span class="text-danger">*</span></label>
            <div class="input-group">
                <input type="text" name="holiday_date" class="form-control datepicker-input" placeholder="dd-mm-yyyy" required autocomplete="off">
                <div class="input-group-append">
                    <span class="input-group-text bg-white"><i class="fas fa-calendar-alt text-primary"></i></span>
                </div>
            </div>
          </div>
          <div class="form-group">
            <label class="font-weight-bold text-muted small">HOLIDAY TYPE</label>
            <select name="holiday_type" class="form-control">
              <option value="FESTIVAL" selected>Festival</option>
              <option value="NATIONAL">National</option>
              <option value="COMPANY">Company</option>
              <option value="WEEK_OFF">Week Off</option>
              <option value="OPTIONAL">Optional</option>
            </select>
          </div>
          <div class="form-group">
            <label class="font-weight-bold text-muted small">APPLICABLE FOR</label>
            <select name="applicable_for" class="form-control">
              <option value="ALL" selected>All Employees</option>
            </select>
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
          <button type="submit" class="btn btn-primary rounded-pill px-4" style="background:var(--primary); border:none;">
            <i class="fas fa-save mr-1"></i> Save Holiday
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- EDIT HOLIDAY MODAL -->
<div class="modal fade" id="editHolidayModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title font-weight-bold text-dark"><i class="fas fa-edit text-primary mr-2"></i> Edit Holiday</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="editHolidayForm">
        <div class="modal-body p-4">
          <input type="hidden" name="mode" value="UPDATE">
          <input type="hidden" name="holiday_id" id="editHolidayId">
          <div class="form-group">
            <label class="font-weight-bold text-muted small">HOLIDAY NAME <span class="text-danger">*</span></label>
            <input type="text" name="holiday_name" id="editHolidayName" class="form-control form-control-lg" required>
          </div>
          <div class="form-group">
            <label class="font-weight-bold text-muted small">HOLIDAY DATE <span class="text-danger">*</span></label>
            <div class="input-group">
                <input type="text" name="holiday_date" id="editHolidayDate" class="form-control datepicker-input" required autocomplete="off">
                <div class="input-group-append">
                    <span class="input-group-text bg-white"><i class="fas fa-calendar-alt text-primary"></i></span>
                </div>
            </div>
          </div>
          <div class="form-group">
            <label class="font-weight-bold text-muted small">HOLIDAY TYPE</label>
            <select name="holiday_type" id="editHolidayType" class="form-control">
              <option value="FESTIVAL">Festival</option>
              <option value="NATIONAL">National</option>
              <option value="COMPANY">Company</option>
              <option value="WEEK_OFF">Week Off</option>
              <option value="OPTIONAL">Optional</option>
            </select>
          </div>
          <div class="form-group">
            <label class="font-weight-bold text-muted small">APPLICABLE FOR</label>
            <select name="applicable_for" id="editApplicableFor" class="form-control">
              <option value="ALL">All Employees</option>
            </select>
          </div>
          <div class="form-group mb-0">
            <label class="font-weight-bold text-muted small">STATUS</label>
            <select name="status" id="editHolidayStatus" class="form-control">
              <option value="A">Active</option>
              <option value="I">Inactive</option>
            </select>
          </div>
        </div>
        <div class="modal-footer bg-light border-0">
          <button type="button" class="btn btn-secondary rounded-pill px-4" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary rounded-pill px-4" style="background:var(--primary); border:none;">
            <i class="fas fa-check-circle mr-1"></i> Update Holiday
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- DELETE CONFIRMATION MODAL -->
<div class="modal fade" id="deleteHolidayModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header border-0 pb-0">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="deleteHolidayForm">
        <div class="modal-body text-center pt-0 px-4">
          <input type="hidden" name="mode" value="DELETE">
          <input type="hidden" name="holiday_id" id="deleteHolidayId">
          <div class="text-danger mb-3" style="font-size: 40px;">
            <i class="fas fa-exclamation-circle"></i>
          </div>
          <h5 class="font-weight-bold">Are you sure?</h5>
          <p class="text-muted small">Do you really want to delete holiday <strong id="deleteHolidayName" class="text-dark"></strong>?</p>
        </div>
        <div class="modal-footer border-0 justify-content-center pt-0 pb-4">
          <button type="button" class="btn btn-light rounded-pill px-4" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-danger rounded-pill px-4">Delete</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/js/bootstrap-datepicker.min.js"></script>

<script>
$(document).ready(function(){

    // Initialize Datepickers
    $('.datepicker-input').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true,
        orientation: "bottom auto"
    });

    // Alert helper
    function showAlert(type, message) {
        var alertHtml = '<div class="alert alert-' + type + ' alert-dismissible fade show rounded-lg shadow-sm mb-4" role="alert">' +
          '<strong>' + (type === 'success' ? 'Success!' : 'Error!') + '</strong> ' + message +
          '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
          '<span aria-hidden="true">&times;</span></button></div>';
        $('#alertContainer').html(alertHtml);
        setTimeout(function() { $('.alert').alert('close'); }, 4000);
    }

    // Filter Logic
    function filterHolidays() {
        var searchVal = $("#holidaySearch").val().toLowerCase();
        var selectedYear = $("#yearFilter").val();
        var selectedType = $("#typeFilter").val();

        var visibleCount = 0;

        $("#holidayBody tr.holiday-row").each(function() {
            var row = $(this);
            var titleText = row.find(".holiday-title").text().toLowerCase();
            var rowYear = row.data("year").toString();
            var rowType = row.data("type").toString();

            var matchesSearch = (titleText.indexOf(searchVal) > -1);
            var matchesYear = (selectedYear === "ALL" || rowYear === selectedYear);
            var matchesType = (selectedType === "ALL" || rowType === selectedType);

            if (matchesSearch && matchesYear && matchesType) {
                row.show();
                visibleCount++;
            } else {
                row.hide();
            }
        });

        $("#holidayCountText").text("Total Holidays: " + visibleCount);
    }

    $("#holidaySearch").on("keyup", filterHolidays);
    $("#yearFilter, #typeFilter").on("change", filterHolidays);

    // Initial filter run
    filterHolidays();

    // Submit Add Holiday Form
    $('#addHolidayForm').on('submit', function(e){
        e.preventDefault();
        $.ajax({
            url: '<?= base_url("aut_pages/save_holiday") ?>',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(res) {
                if (res.status === 'success') {
                    $('#addHolidayModal').modal('hide');
                    $('#addHolidayForm')[0].reset();
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

    // Open Edit Holiday Modal
    $(document).on('click', '.btn-edit-holiday', function(){
        var id = $(this).data('id');
        var name = $(this).data('name');
        var date = $(this).data('date');
        var type = $(this).data('type');
        var applicable = $(this).data('applicable');
        var status = $(this).data('status');

        $('#editHolidayId').val(id);
        $('#editHolidayName').val(name);
        $('#editHolidayDate').val(date);
        $('#editHolidayType').val(type);
        $('#editApplicableFor').val(applicable);
        $('#editHolidayStatus').val(status);

        $('#editHolidayModal').modal('show');
    });

    // Submit Edit Holiday Form
    $('#editHolidayForm').on('submit', function(e){
        e.preventDefault();
        $.ajax({
            url: '<?= base_url("aut_pages/save_holiday") ?>',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(res) {
                if (res.status === 'success') {
                    $('#editHolidayModal').modal('hide');
                    showAlert('success', res.message);
                    setTimeout(function(){ location.reload(); }, 800);
                } else {
                    showAlert('danger', res.message);
                }
            },
            error: function() {
                showAlert('danger', 'Failed to update holiday.');
            }
        });
    });

    // Open Delete Holiday Modal
    $(document).on('click', '.btn-delete-holiday', function(){
        var id = $(this).data('id');
        var name = $(this).data('name');

        $('#deleteHolidayId').val(id);
        $('#deleteHolidayName').text(name);
        $('#deleteHolidayModal').modal('show');
    });

    // Submit Delete Holiday Form
    $('#deleteHolidayForm').on('submit', function(e){
        e.preventDefault();
        $.ajax({
            url: '<?= base_url("aut_pages/save_holiday") ?>',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(res) {
                if (res.status === 'success') {
                    $('#deleteHolidayModal').modal('hide');
                    showAlert('success', res.message);
                    setTimeout(function(){ location.reload(); }, 800);
                } else {
                    showAlert('danger', res.message);
                }
            },
            error: function() {
                showAlert('danger', 'Failed to delete holiday.');
            }
        });
    });

});
</script>

</body>
</html>