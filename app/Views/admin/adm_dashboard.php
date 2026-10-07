<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
   <title>Bloom Solutions | Admin Dashboard</title>

    <div class="content-wrapper">
      <section class="content pt-3">
        <div class="container-fluid">

          <div class="row row-equal">
            <div class="col-md-3 col-sm-6">
              <div class="card-bloom stat-mini" style="color: var(--bloom-orange)">
                <div class="stat-icon-circle" style="background:#fff3e6;"><i class="fas fa-calendar-check"></i></div>
                <strong><?= $adm_dash[0]['total_active_employees'] ?? 0 ?></strong>
                <small class="text-muted font-weight-bold">Total Empolyees</small>
                <a href="<?= base_url('admin/empolyees') ?>" class="small text-primary mt-2 font-weight-bold">
                      Available
                  </a>
              </div>
            </div>
            <div class="col-md-3 col-sm-6">
              <div class="card-bloom stat-mini" style="color: #0369a1">
                <div class="row text-center">

                  <!-- Departments -->
                  <div class="col-6 border-right">
                    <div class="stat-icon-circle" style="background:#e0f2fe;">
                      <i class="fas fa-project-diagram" style="color:#0369a1;"></i>
                    </div>
                    <strong><?= $adm_dash[0]['total_active_departments'] ?? 0 ?></strong>
                    <br>
                    <small class="font-weight-bold">
                      <a href="<?= base_url('admin/deparment') ?>" class="text-muted">Departments</a>
                    </small>
                  </div>

                  <!-- Designations -->
                  <div class="col-6">
                    <div class="stat-icon-circle" style="background:#f0f9ff;">
                      <i class="fas fa-id-badge" style="color:#0284c7;"></i>
                    </div>
                    <strong><?= $adm_dash[0]['total_active_designations'] ?? 0 ?></strong>
                    <br>
                    <small class="font-weight-bold">
                      <a href="<?= base_url('admin/designation') ?>" class="text-muted">Designations</a>
                    </small>
                  </div>

                </div>
              </div>
            </div>
            <div class="col-md-3 col-sm-6">
              <div class="card-bloom stat-mini">

                <div class="row text-center">

                  <!-- Present -->
                  <div class="col-4 border-right px-1">

                    <div class="stat-icon-circle" style="background:#ecfdf5;">
                      <i class="fas fa-user-check" style="color:#10b981;"></i>
                    </div>

                    <strong><?= $adm_dash[0]['employees_present_today'] ?? 0 ?></strong>
                    <br>
                    <small class="text-muted font-weight-bold">Present</small>

                  </div>

                  <!-- WFH -->
                  <div class="col-4 border-right px-1">

                    <div class="stat-icon-circle" style="background:#e0f2fe;">
                      <i class="fas fa-laptop-house" style="color:#0284c7;"></i>
                    </div>

                    <strong><?= $adm_dash[0]['employees_wfh_today'] ?? 0 ?></strong>
                    <br>
                    <small class="text-muted font-weight-bold">WFH</small>

                  </div>

                  <!-- Absent -->
                  <div class="col-4 px-1">

                    <div class="stat-icon-circle" style="background:#fef2f2;">
                      <i class="fas fa-user-times" style="color:#ef4444;"></i>
                    </div>

                   <strong><?= $adm_dash[0]['employees_absent_today'] ?? 0 ?></strong>
                   <br>
                    <small class="text-muted font-weight-bold">Absent</small>

                  </div>

                </div>

              </div>
            </div>


            <div class="col-md-3 col-sm-6">
              <div class="card-bloom stat-mini">

                <div class="row text-center">

                  <!-- Pending leaves -->
                  <div class="col-6 border-right">

                    <div class="stat-icon-circle" style="background:#ecfdf5;">
    <i class="fas fa-calendar-check" style="color:#10b981;"></i>
</div>
                    <strong><?= $adm_dash[0]['pending_leave_applications'] ?? 0 ?></strong>

                    <small class="font-weight-bold">
                  <a href="<?= base_url('admin/leave_overview') ?>" class="text-muted">
                      Leaves Requests
                  </a>
              </small>

                  

                  </div>

                  <!-- Pending Requests-->
                  <div class="col-6">
        
            <div class="stat-icon-circle" style="background:#fef2f2;">
                <i class="fas fa-comment-dots" style="color:#ef4444;"></i>
            </div>
                    <strong><?= $adm_dash[0]['pending_general_requests'] ?? 0 ?></strong>
                   <small class="font-weight-bold">
                <a href="<?= base_url('admin/Requests') ?>"class="text-muted" >
                    General Requests
                </a>
            </small>
                  </div>

                </div>

              </div>
            </div>

            <!-- <div class="col-md-3 col-sm-6">
              <div class="card-bloom stat-mini" style="color: var(--bloom-danger)">
                <div class="stat-icon-circle" style="background:#fef2f2;"><i class="fas fa-tasks"></i></div>
                <strong>96</strong>
                <small class="text-muted font-weight-bold">Pending Leaves</small>
                <a href="leave_pending.html" class="small text-primary mt-2 font-weight-bold">Awaiting for approval</a>
              </div>
            </div> -->
          </div>

          <div class="row row-equal">
            <div class="col-lg-4 col-md-6">
              <div class="card-bloom">
                <div class="p-3 d-flex justify-content-between align-items-center">
                  <h6 class="mb-0 font-weight-bold">Employee Status</h6>
                </div>
                <div class="px-3 pb-3">
                  <div class="d-flex justify-content-between align-items-end mb-2">
                    <small class="text-muted">Total Workforce</small>
                    <strong style="font-size:1.4rem">0</strong>
                  </div>
                  <div class="progress-multi mb-3">
                    <div class="bg-warning" style="width: 48%"></div>
                    <div class="bg-info" style="width: 20%"></div>
                    <div class="bg-danger" style="width: 22%"></div>
                    <div class="bg-primary" style="width: 10%"></div>
                  </div>
                  <div class="status-grid">
                    <div class="status-item fulltime">
                      <small class="text-muted">Fulltime</small><br>
                      <strong>0</strong>
                    </div>

                    <div class="status-item">
                      <small class="text-muted">Contract</small><br>
                      <strong>0</strong>
                    </div>

                    <div class="status-item">
                      <small class="text-muted">Probation</small><br>
                      <strong>0</strong>
                    </div>
                  </div>

                </div>
              </div>
            </div>
            <!-- <div class="col-lg-4 col-md-6">
              <div class="card-bloom p-3"> -->

                <!-- Header with Week Badge -->
                <!-- <div class="d-flex justify-content-between align-items-center mb-2">
                  <h6 class="font-weight-bold mb-0">Attendance Mix</h6>
                  <span class="badge badge-light border">This Week</span>
                </div>

                <div class="chart-container" style="height:180px; position:relative;">
                  <canvas id="attChart"></canvas>
                </div>

                <div class="mt-3 row text-center">
                  <div class="col-3 mb-2 text-left small">
                    <i class="fas fa-circle text-success mr-1"></i> Present
                  </div>

                  <div class="col-3 mb-2 text-left small">
                    <i class="fas fa-circle text-danger mr-1"></i> Absent
                  </div>

                  <div class="col-3 mb-2 text-left small">
                    <i class="fas fa-circle text-info mr-1"></i> WFH
                  </div>

                  <div class="col-3 mb-2 text-left small">
                    <i class="fas fa-circle text-warning mr-1"></i> Break
                  </div>
                </div>

              </div>
            </div> -->

            <div class="col-lg-4 col-md-6">
    <div class="card-bloom p-3">

       <div class="d-flex justify-content-center align-items-center mb-2">
    <h6 class="font-weight-bold mb-0">Attendance Mix</h6>
</div>

        <div class="d-flex flex-column justify-content-center align-items-center"
             style="height:220px;">

            <i class="fas fa-chart-pie"
               style="font-size:55px; color:#b39ddb;"></i>

            <h5 class="mt-3 mb-2 font-weight-bold text-secondary">
                Coming Soon
            </h5>

            <p class="text-muted text-center mb-0" style="font-size:14px;">
                Attendance analytics and insights will be available in a future update.
            </p>

        </div>

    </div>
</div>
            <div class="col-lg-4 col-md-12">
              <div class="card-bloom p-3">
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-3">
                  <h6 class="font-weight-bold mb-0">📍 Zones</h6>
                </div>

                <!-- Zone 1 -->
                <a href="#" class="zone-item">

                  <div class="zone-left">

                    <img src="<?= base_url('public/dist/img/bloom.jpg') ?>" class="zone-img">

                    <div>
                      <div class="font-weight-bold small">Blooms HO</div>
                      <small class="text-muted">Head Office</small>
                    </div>

                  </div>

                  <span class="zone-count">0</span>

                </a>

                <!-- Zone 2 -->
                <a href="#" class="zone-item">

                  <div class="zone-left">

                     <img src="<?= base_url('public/dist/img/waterboard_logo.jpg') ?>" class="zone-img">


                    <div>
                      <div class="font-weight-bold small">Blooms WB</div>
                      <small class="text-muted">Water Board</small>
                    </div>

                  </div>

                  <span class="zone-count">0</span>

                </a>

                <!-- Zone 3 -->
                <a href="#" class="zone-item">

                  <div class="zone-left">

                    <img src="https://cdn.siasat.com/wp-content/uploads/2025/08/GHMC-Hyderabad.jpg" class="zone-img">

                    <div>
                      <div class="font-weight-bold small">Blooms GHMC</div>
                      <small class="text-muted">GHMC Department</small>
                    </div>

                  </div>

                  <span class="zone-count">0</span>

                </a>

              </div>
            </div>
          </div>
          <div class="row row-equal">

            <!-- Holiday Card -->
           <div class="col-lg-6 col-md-12">

    <div class="card-bloom card-holiday p-3 position-relative">

        <!-- FULL CARD LINK -->
        <a href="<?= base_url('aut_pages/holidays') ?>" class="stretched-link"></a>

        <div class="d-flex align-items-center mb-3">
    <h6 class="mb-0 mr-auto">🌴 Chill Holidays</h6>

    <span class="badge badge-light border mr-2">Upcoming</span>

    <span class="badge badge-light border"
          style="border-radius:5px; cursor:pointer;"
          onclick="window.location.href='<?= base_url('aut_pages/holidays') ?>'">
        View All
    </span>
</div>

        <?php
        $count = 0;
        foreach ($holiday as $h):

            if ($h['holiday_date'] < date('Y-m-d')) continue;
            if ($h['holiday_type'] == 'WEEK_OFF') continue;
            if ($count == 3) break;

            $day = date('d', strtotime($h['holiday_date']));
            $month = date('M', strtotime($h['holiday_date']));

               // Days left
    $today = new DateTime(date('Y-m-d'));
    $holidayDate = new DateTime($h['holiday_date']);
    $daysLeft = $today->diff($holidayDate)->days;
        ?>

        <div class="d-flex align-items-center mb-3">

    <div class="holiday-date text-center mr-3">
        <strong><?= $day ?></strong><br>
        <small><?= strtoupper($month) ?></small>
    </div>

    <div class="flex-grow-1">
        <div class="font-weight-bold small">
            <?= esc($h['holiday_name']) ?>
        </div>
        <small class="text-muted">
            <?= esc($h['holiday_type']) ?>
        </small>
    </div>

    <span class="badge badge-warning px-3 py-2 ml-auto"
          style="border-radius:8px;">
        <?= $daysLeft ?> Days Left
    </span>

</div>

        <?php
            $count++;
        endforeach;
        ?>

    </div>
</div>
            <!-- Birthday Card -->
            <div class="col-lg-6 col-md-12">
              <div class="card-bloom card-birthday p-3">

                <div class="d-flex justify-content-between align-items-center mb-3">
                  <h6 class="mb-0">🎂 Birthdays</h6>
                  <span class="badge badge-light border">Today</span>
                </div>

                <?php if (!empty($birthday)) : ?>

    <?php foreach ($birthday as $row): ?>

<div class="d-flex align-items-center justify-content-between mb-3">

    <!-- Name + Date -->
    <div style="width:45%;">
        <div class="font-weight-bold small">
            <?= esc($row['emp_names']) ?>
        </div>

        <small class="text-muted">
            <?= date('d M', strtotime(date('Y').'-'.$row['birthday_date'])) ?>
        </small>
    </div>

    <!-- Days Left -->
    <div style="width:25%; text-align:center;">
        <span class="badge <?= $row['days_left']==0 ? 'badge-success' : 'badge-warning' ?> px-3 py-2"
              style="border-radius:8px;">
            <?= $row['days_left']==0 ? 'Today' : $row['days_left'].' Days Left' ?>
        </span>
    </div>

    <!-- Wish Button -->
    <div style="width:20%; text-align:right;">
        <a href="#" class="btn btn-sm btn-outline-success">
            🎂 Wish
        </a>
    </div>

</div>

<?php endforeach; ?>
<?php else : ?>

    <div class="text-center py-4">
        <small class="text-muted">No birthdays available.</small>
    </div>

<?php endif; ?>
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
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <script>
    const commonOptions = { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } } };

    // Attendance Chart
    new Chart(document.getElementById('attChart'), {
      type: 'doughnut',
      data: {
        datasets: [{
          data: [59, 21, 2, 15],
          backgroundColor: ['#10b981', '#0ea5e9', '#f59e0b', '#ef4444'],
          borderWidth: 0, borderRadius: 5, spacing: 3
        }]
      },
      options: { ...commonOptions, cutout: '85%' }
    });

    // Tasks Chart
    new Chart(document.getElementById('tasksDoughnut'), {
      type: 'doughnut',
      data: {
        datasets: [{
          data: [70, 15, 10, 5],
          backgroundColor: ['#4a00e0', '#10b981', '#f59e0b', '#dc2626'],
          borderWidth: 0, borderRadius: 5, spacing: 5
        }]
      },
      options: { ...commonOptions, cutout: '80%' }
    });
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