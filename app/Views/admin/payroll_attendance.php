<div class="content-wrapper bg-light">
  <section class="content-header pb-0">
    <div class="container-fluid">
      <div class="row align-items-center mb-2">
        <div class="col-sm-6">
          <h1 class="font-weight-bold text-dark">
            <i class="fas fa-calculator text-success mr-2"></i> Payroll Attendance Summary
          </h1>
        </div>
      </div>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">
      
      <!-- Filters -->
      <div class="card shadow-sm mb-4" style="border-radius: 12px; border:none;">
        <div class="card-body py-3">
          <form method="get" action="<?= base_url('admin/payroll_attendance') ?>" class="form-row align-items-center">
            
            <div class="col-auto">
              <label class="sr-only">Month</label>
              <select name="month" class="form-control" style="border-radius:8px;">
                <?php for ($m = 1; $m <= 12; $m++) : ?>
                  <option value="<?= $m ?>" <?= ($selectedMonth == $m) ? 'selected' : '' ?>>
                    <?= date('F', mktime(0, 0, 0, $m, 10)) ?>
                  </option>
                <?php endfor; ?>
              </select>
            </div>

            <div class="col-auto">
              <label class="sr-only">Year</label>
              <select name="year" class="form-control" style="border-radius:8px;">
                <?php
                $currY = (int)date('Y');
                for ($y = $currY - 2; $y <= $currY + 1; $y++) {
                  $sel = ($selectedYear == $y) ? 'selected' : '';
                  echo "<option value=\"$y\" $sel>$y</option>";
                }
                ?>
              </select>
            </div>

            <div class="col-auto">
              <button type="submit" class="btn btn-primary font-weight-bold px-4" style="border-radius:8px;">
                <i class="fas fa-filter mr-1"></i> Filter
              </button>
              <a href="<?= base_url('admin/payroll_attendance') ?>" class="btn btn-light border font-weight-bold px-4 ml-1" style="border-radius:8px;">
                Reset
              </a>
            </div>
            
            <div class="col-auto ml-auto text-muted small">
              <?php if (isset($is_finalized) && $is_finalized): ?>
                  <span class="badge badge-success px-3 py-2" style="font-size:14px;"><i class="fas fa-check-circle"></i> Finalized</span>
              <?php else: ?>
                  <?php if (!empty($records)): ?>
                  <button type="button" class="btn btn-warning font-weight-bold px-4" style="border-radius:8px;" id="finalizeBtn">
                    <i class="fas fa-lock mr-1"></i> Finalize Attendance
                  </button>
                  <?php endif; ?>
              <?php endif; ?>
            </div>
          </form>
        </div>
      </div>

      <!-- Data Table -->
      <div class="card shadow-sm" style="border-radius: 12px; border:none; overflow:hidden;">
        <div class="card-body p-0 table-responsive">
          <table class="table table-hover mb-0" id="payrollTable">
            <thead class="bg-light text-secondary">
              <tr style="font-size:12px; text-transform:uppercase; letter-spacing:0.5px;">
                <th class="py-3 px-4 border-0">Emp ID</th>
                <th class="py-3 px-4 border-0">Name</th>
                <th class="py-3 text-center border-0">Total</th>
                <th class="py-3 text-center border-0">Work Days</th>
                <th class="py-3 text-center border-0 text-success">Paid</th>
                <th class="py-3 text-center border-0 text-danger">Unpaid</th>
                <th class="py-3 text-center border-0">Present</th>
                <th class="py-3 text-center border-0">WFH</th>
                <th class="py-3 text-center border-0">Leave</th>
                <th class="py-3 text-center border-0">Holidays</th>
                <th class="py-3 text-center border-0">Absent/LOP</th>
                <th class="py-3 text-center border-0">Late</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($records)) : ?>
                <?php foreach ($records as $row) : ?>
                  <tr style="font-size:14px;">
                    <td class="px-4 align-middle">
                      <span class="badge badge-light border text-dark p-2" style="font-size:13px;">
                        <?= esc($row['emp_id']) ?>
                      </span>
                    </td>
                    <td class="px-4 align-middle font-weight-bold text-dark">
                      <?= esc($row['emp_name']) ?><br>
                      <small class="text-muted font-weight-normal"><?= esc($row['designation']) ?></small>
                    </td>
                    <td class="text-center align-middle"><?= floatval($row['total_days']) ?></td>
                    <td class="text-center align-middle font-weight-bold"><?= floatval($row['working_days']) ?></td>
                    <td class="text-center align-middle text-success font-weight-bold bg-light">
                      <?= floatval($row['paid_days']) ?>
                    </td>
                    <td class="text-center align-middle text-danger font-weight-bold bg-light">
                      <?= floatval($row['unpaid_days']) ?>
                    </td>
                    <td class="text-center align-middle"><?= floatval($row['present_days']) ?></td>
                    <td class="text-center align-middle"><?= floatval($row['wfh_days']) ?></td>
                    <td class="text-center align-middle"><?= floatval($row['leave_days']) ?></td>
                    <td class="text-center align-middle"><?= floatval($row['holiday_days']) + floatval($row['weekly_off_days']) ?></td>
                    <td class="text-center align-middle"><?= floatval($row['absent_days']) ?></td>
                    <td class="text-center align-middle"><?= intval($row['late_count']) ?></td>
                  </tr>
                <?php endforeach; ?>
              <?php else : ?>
                <tr>
                  <td colspan="11" class="text-center py-5 text-muted">
                    <i class="fas fa-folder-open fa-2x mb-3 text-light"></i><br>
                    No payroll attendance records found for this period.<br>
                    <small>Go to <a href="<?= base_url('admin/attendance_overview') ?>">Attendance Overview</a> to generate data.</small>
                  </td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
      
    </div>
  </section>
</div>

<!-- DataTables Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
<script>
  $(document).ready(function() {
    $('#payrollTable').DataTable({
      "pageLength": 25,
      "ordering": true,
      "language": {
        "search": "Search Employees:"
      }
    });

    $('#finalizeBtn').on('click', function() {
        if (confirm("Are you sure you want to finalize attendance for this month? This action cannot be undone.")) {
            $.ajax({
                url: '<?= base_url('admin/finalize_payroll_attendance') ?>',
                type: 'POST',
                data: {
                    month: '<?= $selectedMonth ?>',
                    year: '<?= $selectedYear ?>'
                },
                success: function(res) {
                    if (res.status === 'Y') {
                        alert(res.message);
                        location.reload();
                    } else {
                        alert(res.message);
                    }
                },
                error: function() {
                    alert('An error occurred while finalizing attendance.');
                }
            });
        }
    });
  });
</script>
