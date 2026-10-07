<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bloom Solutions | Exceptions Dashboard - Missing Punches</title>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">

  <style>
    :root {
      --bloom-purple: #4a00e0;
      --bloom-dark: #120038;
      --bloom-bg: #f8fafc;
      --text-dark: #1e293b;
      --border-color: #e2e8f0;
    }
    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      background-color: var(--bloom-bg);
      color: var(--text-dark);
      font-size: 13px;
    }
    .card-bloom {
      border-radius: 16px;
      border: 1px solid var(--border-color);
      box-shadow: 0 10px 30px rgba(0,0,0,0.03);
      overflow: hidden;
      background: #fff;
    }
    .card-bloom .card-header {
      background: #fff;
      border-bottom: 1px solid var(--border-color);
      padding: 16px 20px;
    }
    .avatar-circle {
      width: 36px;
      height: 36px;
      border-radius: 50%;
      background: #4a00e0;
      color: #fff;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 700;
      font-size: 12px;
      margin-right: 12px;
    }
    .badge-out-punch {
      background: #fef2f2;
      color: #ef4444;
      border: 1px solid #fca5a5;
      font-weight: 800;
      padding: 4px 10px;
      border-radius: 6px;
      font-size: 11px;
      letter-spacing: 0.5px;
    }
    .badge-in-punch {
      background: #eff6ff;
      color: #3b82f6;
      border: 1px solid #93c5fd;
      font-weight: 800;
      padding: 4px 10px;
      border-radius: 6px;
      font-size: 11px;
      letter-spacing: 0.5px;
    }
    .punch-tag-in {
      background: #f1f5f9;
      color: #334155;
      border-radius: 6px;
      padding: 4px 8px;
      font-weight: 700;
      font-size: 11px;
    }
    .punch-tag-out-missing {
      background: #fff1f2;
      color: #e11d48;
      border-radius: 6px;
      padding: 4px 8px;
      font-weight: 700;
      font-size: 11px;
      border: 1px dashed #fda4af;
    }
    .table td, .table th {
      padding: 14px 16px;
      vertical-align: middle;
    }
    .table th {
      text-transform: uppercase;
      font-size: 11px;
      letter-spacing: 0.5px;
      color: #64748b;
      font-weight: 700;
    }
  </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

<div class="content-wrapper">
<section class="content pt-3">
<div class="container-fluid">

  <?php if(session()->getFlashdata('status') == 'Y') : ?>
    <div class="alert alert-success alert-dismissible fade show mb-3" style="border-radius:10px;">
        <i class="fas fa-check-circle mr-2"></i><?= session()->getFlashdata('remarks') ?>
        <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
  <?php endif; ?>

  <div class="row">
    <div class="col-12">
      <div class="card card-bloom">
        <div class="card-header d-flex align-items-center justify-content-between flex-wrap">
          <div>
            <div class="d-flex align-items-center mb-1">
              <h4 class="font-weight-bold mb-0 mr-3">Exceptions Dashboard</h4>
              <?php $actionCount = !empty($missing_punchouts) ? count($missing_punchouts) : 0; ?>
              <span class="badge badge-danger badge-pill px-3 py-2 font-weight-bold">
                <i class="fas fa-exclamation-circle mr-1"></i><?= $actionCount ?> Action Required
              </span>
            </div>
            <p class="text-muted small mb-0">Review and resolve missing punch anomalies for the selected month</p>
          </div>

          <!-- FILTER TABS -->
          <div class="w-100 mt-3">
            <ul class="nav nav-pills mb-3" id="filter-tab" role="tablist" style="font-size: 12px; font-weight: 600;">
              <li class="nav-item">
                <a class="nav-link <?= !empty($selectedDate) ? 'active' : '' ?> py-1 px-3" id="date-tab" data-toggle="pill" href="#date-filter" role="tab">By Exact Date</a>
              </li>
              <li class="nav-item">
                <a class="nav-link <?= empty($selectedDate) ? 'active' : '' ?> py-1 px-3" id="month-tab" data-toggle="pill" href="#month-filter" role="tab">By Payroll Month</a>
              </li>
            </ul>

            <div class="tab-content bg-light p-3 rounded border" id="filter-tabContent">
              <!-- Exact Date Filter -->
              <div class="tab-pane fade <?= !empty($selectedDate) ? 'show active' : '' ?>" id="date-filter" role="tabpanel">
                <form method="get" action="<?= base_url('admin/missing_punchout') ?>" class="form-inline m-0">
                  <label class="mr-2 font-weight-bold text-muted small">Date:</label>
                  <input type="date" name="exact_date" class="form-control form-control-sm mr-4" value="<?= isset($selectedDate) ? esc($selectedDate) : '' ?>" required>
                  
                  <label class="mr-2 font-weight-bold text-muted small">Employee:</label>
                  <select name="emp_id" class="form-control form-control-sm mr-4 custom-select" style="max-width:200px;">
                    <option value="">-- All Employees --</option>
                    <?php if (!empty($employees)) : ?>
                      <?php foreach ($employees as $emp) : ?>
                        <?php $selEmp = (isset($selectedEmp) && $selectedEmp == $emp['emp_id']) ? 'selected' : ''; ?>
                        <option value="<?= esc($emp['emp_id']) ?>" <?= $selEmp ?>>
                          <?= esc($emp['emp_id']) ?> - <?= esc($emp['emp_name']) ?>
                        </option>
                      <?php endforeach; ?>
                    <?php endif; ?>
                  </select>

                  <button type="submit" class="btn btn-sm btn-primary font-weight-bold mr-1">
                    <i class="fas fa-filter mr-1"></i>Apply Date Filter
                  </button>
                  <a href="<?= base_url('admin/missing_punchout') ?>" class="btn btn-sm btn-secondary font-weight-bold">
                    <i class="fas fa-undo mr-1"></i>Reset
                  </a>
                </form>
              </div>
              
              <!-- Month Filter -->
              <div class="tab-pane fade <?= empty($selectedDate) ? 'show active' : '' ?>" id="month-filter" role="tabpanel">
                <form method="get" action="<?= base_url('admin/missing_punchout') ?>" class="form-inline m-0">
                  <label class="mr-2 font-weight-bold text-muted small">Month:</label>
                  <select name="month" class="form-control form-control-sm mr-2 custom-select">
                    <?php
                    $months = [
                        1 => 'January (Dec 25 - Jan 24)', 2 => 'February (Jan 25 - Feb 24)',
                        3 => 'March (Feb 25 - Mar 24)', 4 => 'April (Mar 25 - Apr 24)',
                        5 => 'May (Apr 25 - May 24)', 6 => 'June (May 25 - Jun 24)',
                        7 => 'July (Jun 25 - Jul 24)', 8 => 'August (Jul 25 - Aug 24)',
                        9 => 'September (Aug 25 - Sep 24)', 10 => 'October (Sep 25 - Oct 24)',
                        11 => 'November (Oct 25 - Nov 24)', 12 => 'December (Nov 25 - Dec 24)'
                    ];
                    $curMonth = $selectedMonth ?? date('n');
                    foreach ($months as $num => $name) {
                        $sel = ($curMonth == $num) ? 'selected' : '';
                        echo "<option value=\"$num\" $sel>$name</option>";
                    }
                    ?>
                  </select>

                  <label class="mr-2 font-weight-bold text-muted small">Year:</label>
                  <select name="year" class="form-control form-control-sm mr-4 custom-select">
                    <?php
                    $curYr = $selectedYear ?? date('Y');
                    for ($y = date('Y') - 1; $y <= date('Y') + 1; $y++) {
                        $sel = ($curYr == $y) ? 'selected' : '';
                        echo "<option value=\"$y\" $sel>$y</option>";
                    }
                    ?>
                  </select>

                  <label class="mr-2 font-weight-bold text-muted small">Employee:</label>
                  <select name="emp_id" class="form-control form-control-sm mr-4 custom-select" style="max-width:200px;">
                    <option value="">-- All Employees --</option>
                    <?php if (!empty($employees)) : ?>
                      <?php foreach ($employees as $emp) : ?>
                        <?php $selEmp = (isset($selectedEmp) && $selectedEmp == $emp['emp_id']) ? 'selected' : ''; ?>
                        <option value="<?= esc($emp['emp_id']) ?>" <?= $selEmp ?>>
                          <?= esc($emp['emp_id']) ?> - <?= esc($emp['emp_name']) ?>
                        </option>
                      <?php endforeach; ?>
                    <?php endif; ?>
                  </select>

                  <button type="submit" class="btn btn-sm btn-primary font-weight-bold mr-1">
                    <i class="fas fa-filter mr-1"></i>Apply Month Filter
                  </button>
                  <a href="<?= base_url('admin/missing_punchout') ?>" class="btn btn-sm btn-secondary font-weight-bold">
                    <i class="fas fa-undo mr-1"></i>Reset
                  </a>
                </form>
              </div>
            </div>
          </div>
        </div>

        <div class="card-body p-0">
          <div class="table-responsive">
            <table id="missingPunchTable" class="table table-hover mb-0">
              <thead class="bg-light">
                <tr>
                  <th>EMPLOYEE</th>
                  <th>DATE</th>
                  <th>RECORDED PUNCHES</th>
                  <th>MISSING</th>
                  <th>SET OUT TIME</th>
                  <th class="text-center">ACTION</th>
                </tr>
              </thead>
              <tbody>
                <?php if (!empty($missing_punchouts)) : ?>
                  <?php foreach ($missing_punchouts as $index => $row) : ?>
                    <tr>
                      <td>
                        <div class="d-flex align-items-center">
                          <div class="avatar-circle">
                            <?= strtoupper(substr($row['emp_name'] ?? $row['emp_id'], 0, 2)) ?>
                          </div>
                          <div>
                            <div class="font-weight-bold text-dark mb-0"><?= esc($row['emp_name'] ?? 'Employee') ?></div>
                            <small class="text-muted"><?= esc($row['emp_id']) ?></small>
                          </div>
                        </div>
                      </td>

                      <td class="font-weight-bold text-secondary">
                        <?= date('M d, Y', strtotime($row['attendance_date'])) ?>
                        <br><small class="text-muted"><?= esc($row['day_name'] ?? date('l', strtotime($row['attendance_date']))) ?></small>
                      </td>

                      <td>
                        <span class="punch-tag-in mr-2">
                          <?= !empty($row['punch_in']) ? date('H:i', strtotime($row['punch_in'])) : '09:30' ?> IN
                        </span>
                        <span class="punch-tag-out-missing">
                          --:-- OUT
                        </span>
                      </td>

                      <td>
                        <span class="badge-out-punch">
                          <i class="fas fa-arrow-circle-right mr-1"></i>OUT-PUNCH
                        </span>
                      </td>

                      <!-- INLINE FORM FOR DIRECT ROW SAVING -->
                      <td>
                          <input type="time" name="last_out_time" form="form_punch_<?= $index ?>" class="form-control form-control-sm font-weight-bold text-primary" style="width: 120px;" value="18:30" required>
                      </td>

                      <td class="text-center">
                        <form id="form_punch_<?= $index ?>" action="<?= base_url('admin/save_missing_punchout') ?>" method="post" class="form-inline m-0 justify-content-center">
                          <input type="hidden" name="target_emp_id" value="<?= esc($row['emp_id']) ?>">
                          <input type="hidden" name="attendance_date" value="<?= esc($row['attendance_date']) ?>">
                          <input type="hidden" name="first_in_time" value="<?= !empty($row['punch_in']) ? date('H:i', strtotime($row['punch_in'])) : '09:30' ?>">

                          <button type="submit" class="btn btn-sm btn-success font-weight-bold px-3">
                            <i class="fas fa-check mr-1"></i> Save & Resolve
                          </button>
                        </form>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                <?php else : ?>
                  <tr>
                    <td colspan="6" class="text-center py-4 text-muted">
                      <i class="fas fa-check-circle text-success fa-2x d-block mb-2"></i>
                      No Missing Punch Outs found for the selected filter.
                    </td>
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
</div>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>

<script>
  $(document).ready(function() {
    $('#missingPunchTable').DataTable({
      paging: true,
      ordering: true,
      searching: true,
      info: true,
      pageLength: 10,
      dom: '<"row p-3"<"col-md-6"l><"col-md-6"f>>rt<"row p-3"<"col-md-6"i><"col-md-6"p>>'
    });
  });
</script>
</body>
</html>
