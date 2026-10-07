<?php
$today = new DateTime();

$nextHoliday = null;

foreach ($holiday as $h) {

    //  SKIP WEEK_OFF (Sunday)
    if ($h['holiday_type'] == 'WEEK_OFF') {
        continue;
    }

    $holidayDate = new DateTime($h['holiday_date']);

    if ($holidayDate >= $today) {
        if ($nextHoliday === null || $holidayDate < new DateTime($nextHoliday['holiday_date'])) {
            $nextHoliday = $h;
        }
    }
}

$daysLeft = '';
if ($nextHoliday) {
    $holidayDate = new DateTime($nextHoliday['holiday_date']);
    $diff = $today->diff($holidayDate);
    $daysLeft = $diff->days . " Days Left";
}
?>
<?php
$present = (int)($empdash[0]['present_days_count'] ?? 0);
$wfh     = (int)($empdash[0]['current_month_wfh_count'] ?? 0);
$leave   = (int)($empdash[0]['current_leave_total'] ?? 0);

$total = $present + $wfh + $leave;

$attendancePercent = ($total > 0)
    ? round((($present + $wfh) / $total) * 100)
    : 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bloom Solution | Emp Dashboard</title>
  
<div class="content-wrapper">
      <section class="content pt-3">
        <div class="container-fluid">
          <div class="row">
            <div class="col-lg-4 mb-3">
              <div class="card card-bloom">
                <div class="card-body">
                  
                 <?php
$empName = session()->get('emp_name');

$nameParts = explode(' ', $empName);

$initials = '';

if (count($nameParts) >= 2) {
    $initials = strtoupper(substr($nameParts[0], 0, 1) . substr($nameParts[1], 0, 1));
} else {
    $initials = strtoupper(substr($empName, 0, 2));
}
?>

<div class="d-flex align-items-center mb-3">

<img src="https://ui-avatars.com/api/?name=<?= $initials; ?>&background=4a00e0&color=fff"
     class="profile-img-header mr-3">

<div>
    <h6 class="font-weight-bold mb-0"><?= session()->get('emp_name'); ?></h6>
    <small class="text-primary font-weight-bold"><?= session()->get('emp_id'); ?></small>
</div>

</div>
                  <div class="p-2 rounded bg-light mb-2" style="font-size: 11px;">
                   <div class="d-flex justify-content-between">
    <span>Manager:</span>
    <b><?= !empty($empdash[0]['reporting']) ? esc($empdash[0]['reporting']) : '-' ?></b>
</div>
                    <div class="d-flex justify-content-between mt-1"><span>Location:</span><b>Hyderabad</b></div>
                  </div>
                 <a href="<?= base_url('profile') ?>" 
              class="btn-bloom-grad btn-block text-center text-decoration-none">
            VIEW FULL PROFILE
           </a>
                </div>
              </div>
            </div>

            <div class="col-lg-4 mb-3">
              <div class="card card-bloom text-center">
                <div class="card-body">
                  <h6 class="font-weight-bold mb-3">Attendance Status</h6>
                  <div class="position-relative mx-auto mb-3" style="max-width: 90px;">
                    <canvas id="attnChart" height="90"></canvas>
                    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                      <b style="font-size:14px;"><?= $attendancePercent ?>%</b>
                    </div>
                  </div>
                  <div class="d-flex justify-content-around mt-2">
                    <div><small class="d-block text-muted">Present</small><b class="text-success"><?= $present ?></b></div>
                    <div><small class="d-block text-muted">WFH</small><b class="text-warning"><?= $wfh ?></b></div>
                    <div><small class="d-block text-muted">Absent</small><b class="text-danger"><?= $leave ?></b></div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-lg-4 mb-3">
              <div class="card card-bloom text-center">
                <div class="card-body">
                  <small class="text-muted font-weight-bold">LIVE CLOCK</small>
                  <h4 class="font-weight-bold my-2" id="liveClock" style="color: var(--bloom-purple);">00:00:00</h4>
                  <div class="p-2 border rounded-pill mb-3" style="background: #f8fafc;">
                    <small class="text-muted d-block" style="font-size: 10px;">SHIFT PROGRESS</small>
                    <h5 class="mb-0 font-weight-bold" id="shiftTimer">00:00:00</h5>
                  </div>
                  <div class="row no-gutters">
                    <div class="col-6 pr-1">
                      <button class="btn btn-punch-in btn-block btn-sm py-2" disabled>PUNCH IN</button>
                    </div>
                    <div class="col-6 pl-1">
                      <button class="btn btn-punch-out btn-block btn-sm py-2" disabled>PUNCH OUT</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
           
            <div class="col-md-6 mb-3">
               <a href="<?= base_url('aut_pages/holidays') ?>" style="text-decoration:none; color:inherit;">
              <div class="card card-bloom bg-holiday">
                <div class="card-body d-flex align-items-center justify-content-between">
                  <div class="d-flex align-items-center">
                    <div class="icon-box bg-white shadow-sm mr-3" style="color: var(--bloom-orange);"><i
                        class="fas fa-umbrella-beach"></i></div>
                    <div>
                      <small class="text-uppercase font-weight-bold text-muted" style="font-size: 10px;">Next
                        Holiday</small>
                      <h6 class="mb-0 font-weight-bold"><?= $nextHoliday['holiday_name'] ?? 'No Holiday' ?> -
                    <?= isset($nextHoliday['holiday_date']) ? date('M d, Y', strtotime($nextHoliday['holiday_date'])) : '' ?> </h6>
                    </div>
                  </div>
                  <span class="badge badge-warning px-3 py-2" style="border-radius: 8px;"><?= $daysLeft ?></span>
                  <span class="badge badge-success px-3 py-2"
                    style="border-radius: 8px; cursor: pointer;"
                    onclick="window.location.href='<?= base_url('aut_pages/holidays') ?>'">
                  View All
              </span>
                </div>
              </div>
            </div>
            </a>
            
            <div class="col-md-6 mb-3">
              <div class="card card-bloom bg-birthday">
                <div class="card-body d-flex align-items-center justify-content-between">
                  <div class="d-flex align-items-center">
                    <div class="icon-box bg-white shadow-sm mr-3" style="color: #db2777;"><i
                        class="fas fa-birthday-cake"></i></div>
                    <div>
                      <small class="text-uppercase font-weight-bold text-muted" style="font-size: 10px;">Next
                        Birthday</small>
                      <!-- <h6 class="mb-0 font-weight-bold">Sarah Jenkins - Feb 28</h6> -->
                <?php if (!empty($birthday)) : ?>
          <h6 class="mb-0 font-weight-bold">
              <?= esc($birthday[0]['emp_names']) ?>
              (<?= date('d M', strtotime(date('Y') . '-' . $birthday[0]['birthday_date'])) ?>)

              <?php
                  if ($birthday[0]['days_left'] == 0) {
                      $badgeClass = "badge-success";
                      $text = "Today";
                  } elseif ($birthday[0]['days_left'] == 1) {
                      $badgeClass = "badge-warning";
                      $text = "1 Day Left";
                  } else {
                      $badgeClass = "badge-warning";
                      $text = $birthday[0]['days_left'] . " Days Left";
                  }
              ?>

              <span class="badge <?= $badgeClass ?> ml-4 px-2 py-1" style="border-radius:8px;">
                  <?= $text ?>
              </span>
          </h6>
      <?php else : ?>
          <h6 class="mb-0 font-weight-bold">No Upcoming Birthdays</h6>
      <?php endif; ?>
                    </div>
                  </div>
                  <!-- <button class="btn btn-xs btn-outline-danger px-3 font-weight-bold"disabled style="border-radius: 8px;">Wish
                    Her</button> -->
                </div>
              </div>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-md-3">
              <div class="stat-card shadow-sm">
                <div class="stat-icon" style="background: #fff0e6; color: #ff6b00;"><i class="fas fa-clock"></i></div>
                <h4 class="font-weight-bold mb-0">0 <small class="text-muted">/ 0</small></h4>
                <small class="text-muted">Total Hours Today</small>
              </div>
            </div>
            <div class="col-md-3">
              <div class="stat-card shadow-sm">
                <div class="stat-icon" style="background: #f0f0f0; color: #333;"><i class="fas fa-briefcase"></i></div>
                <h4 class="font-weight-bold mb-0">0 <small class="text-muted">/ 0</small></h4>
                <small class="text-muted">Total Hours Week</small>
              </div>
            </div>
            <div class="col-md-3">
              <div class="stat-card shadow-sm">
                <div class="stat-icon" style="background: #e6f0ff; color: #0066ff;"><i
                    class="fas fa-calendar-check"></i></div>
                <h4 class="font-weight-bold mb-0">0 <small class="text-muted">/ 0</small></h4>
                <small class="text-muted">Total Hours Month</small>
              </div>
            </div>
            <div class="col-md-3">
              <div class="stat-card shadow-sm">
                <div class="stat-icon" style="background: #ffe6eb; color: #ff0040;"><i class="fas fa-bolt"></i></div>
                <h4 class="font-weight-bold mb-0">0 <small class="text-muted">/ 0</small></h4>
                <small class="text-muted">Overtime Month</small>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-lg-12">
              <div class="card card-bloom">
                <div class="card-body">
                  <div class="row text-center mb-1">
                    <div class="col-3">
                      <small class="text-muted d-block" style="letter-spacing: 0.5px;">Working Hours</small>
                      <h6 class="font-weight-bold" style="color: var(--mtn-deep);">0m</h6>
                    </div>
                    <div class="col-3">
                      <small class="text-muted d-block" style="letter-spacing: 0.5px;">Productive</small>
                      <h6 class="font-weight-bold" style="color: #10b981;">0m</h6>
                    </div>
                    <div class="col-3">
                      <small class="text-muted d-block" style="letter-spacing: 0.5px;">Break</small>
                      <h6 class="font-weight-bold" style="color: #f59e0b;">0m</h6>
                    </div>
                    <div class="col-3">
                      <small class="text-muted d-block" style="letter-spacing: 0.5px;">Overtime</small>
                      <h6 class="font-weight-bold" style="color: #6366f1;">0m</h6>
                    </div>
                  </div>

                  <div class="timeline-bar">
                    <div class="t-productive" style="width: 30%;" title="Productive"></div>
                    <div class="t-break" style="width: 8%;" title="Break"></div>
                    <div class="t-productive" style="width: 40%;" title="Productive"></div>
                    <div class="t-break" style="width: 7%;" title="Break"></div>
                    <div class="t-overtime" style="width: 15%;" title="Overtime"></div>
                  </div>

                  <div class="d-flex justify-content-between text-muted" style="font-size: 10px; font-weight: 500;">
                    <span>10:00 AM</span>
                    <span>12:00 PM</span>
                    <span>02:00 PM</span>
                    <span>04:00 PM</span>
                    <span>06:00 PM</span>
                    <span class="text-primary">Overtime</span>
                  </div>
                </div>
              </div>
            </div>
          </div>


        </div>
      </section>
    </div>
    
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <script>
    const ctx = document.getElementById('attnChart').getContext('2d');
    new Chart(ctx, {
      type: 'doughnut',
      data: {
        datasets: [{
          data: [
    <?= $present ?>,
    <?= $wfh ?>,
    <?= $leave ?>
],
          backgroundColor: ['#4a00e0', '#f59e0b', '#dc2626'],
          borderWidth: 0
      }]
      },
      options: { cutout: '78%', plugins: { legend: { display: false } } }
    });

    setInterval(() => {
      document.getElementById('liveClock').innerText = new Date().toLocaleTimeString();
    }, 1000);

    // let sec = 19338;
    // setInterval(() => {
    //   sec++;
    //   let h = Math.floor(sec / 3600), m = Math.floor((sec % 3600) / 60), s = sec % 60;
    //   document.getElementById('shiftTimer').innerText = `${h.toString().padStart(2, '0')}:${m.toString().padStart(2, '0')}:${s.toString().padStart(2, '0')}`;
    // }, 1000);
  </script>
  <div id="toastMessage" style="
  position: fixed;
  top: 20px;
  right: 20px;
  z-index: 99999;
  display: none;
  color: #fff;
  padding: 12px 18px;
  border-radius: 8px;
  font-size: 13px;
  box-shadow: 0 4px 10px rgba(0,0,0,0.2);
">
</div>

<?php if (session()->getFlashdata('remarks')) : ?>
<script>
    const toast = document.getElementById("toastMessage");

    const status = "<?= session()->getFlashdata('status'); ?>";
    const remarks = "<?= session()->getFlashdata('remarks'); ?>";

    toast.innerText = remarks;

    if (status === "Y") {
        toast.style.background = "#10b981";
    } else {
        toast.style.background = "#ef4444";
    }

    toast.style.display = "block";

    setTimeout(() => {
        toast.style.display = "none";
    }, 3000);
</script>
<?php endif; ?>
</body>

</html>