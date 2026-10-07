
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>BloomHR | My Attendance</title>

  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">

 <style>
:root{
  --bloom-purple:#4a00e0;
  --bloom-dark:#120038;
  --bloom-success:#10b981;
  --bloom-danger:#dc2626;
  --bloom-warning:#f59e0b;
  --glass:rgba(255,255,255,.95);
}

body{
  font-family:'Plus Jakarta Sans',sans-serif;
  background:#f8fafc;
  font-size:12px;
  color:#334155;
}

/* HEADER */
.main-header{
  border-bottom:1px solid #e2e8f0!important;
  background:var(--glass)!important;
  backdrop-filter:blur(10px);
}

.main-sidebar{
  background:var(--bloom-dark)!important;
}

/* BRAND */
.custom-brand{
  display:flex;
  align-items:center;
  padding:10px 14px;
  border-bottom:1px solid rgba(255,255,255,.08);
}

.logo-circle{
  width:36px;
  height:36px;
  border-radius:50%;
  object-fit:cover;
  border:2px solid #fff;
  margin-right:8px;
}

.brand-text{
  font-size:16px;
  font-weight:700;
}

.brand-blue{
  color:#4a8cff;
}

.brand-orange{
  color:#ff7a45;
}



/* CARDS */
.stat-box,
.info-card{ 
  background:#fff;
  border-radius:16px;
  padding:14px;
  border:1px solid #e2e8f0;
  transition:.3s;
  height:100%;
}

.stat-box:hover,
.info-card:hover{
  transform:translateY(-2px);
  box-shadow:0 8px 18px rgba(0,0,0,.05);
}

.row.equal-cols{
  display:flex;
  flex-wrap:wrap;
}

.row.equal-cols>[class*='col-']{
  display:flex;
  flex-direction:column;
  margin-bottom:14px;
}

/* TOP STATS */
.stat-icon{
  width:36px;
  height:36px;
  border-radius:10px;
  display:flex;
  align-items:center;
  justify-content:center;
  margin-bottom:10px;
  font-size:14px;
}

.stat-box h3{
  font-size:22px;
}

/* TITLE */
.section-title{
  border-left:3px solid var(--bloom-purple);
  padding-left:8px;
  color:var(--bloom-purple);
  font-weight:800;
  font-size:10px;
  text-transform:uppercase;
  margin-bottom:12px;
}

/* SELECT */
.cal-select{
  width:105px;
  border-radius:10px;
  height:34px;
  font-size:12px;
}

/* ATTENDANCE CYCLE */
.attendance-cycle{
  background:#f8f9ff;
  padding:8px 12px;
  border-radius:12px;
  font-size:12px;
  font-weight:600;
  border:1px solid #e5e7eb;
}
.mini-calendar{
  display:grid;
  grid-template-columns:repeat(7,1fr);
  gap:5px; /* reduced gap */
}

.day-name{
  text-align:center;
  font-weight:700;
  font-size:12px;
  color:#64748b;
  margin-bottom:4px;
}

.day-box{
  height:60px;     
  min-width:50px;    
  border-radius:12px;
  display:flex;
  align-items:center;
  justify-content:center;
  font-weight:700;
  font-size:14px;
  cursor:pointer;
  transition:.3s;
}

.day-box:hover{
  transform:translateY(-2px);
}
.present{
  background:#dff5e5;
  color:#15803d;
}

.absent{
  background:#fde2e2;
  color:#c0392b;
}

.wfh{
  background:#dde2ff;
  color:#4f46e5;
}

.leave{
  background:#fff2c7;
  color:#b45309;
}
.attendance-legend{
  display:flex;
  gap:14px;
  flex-wrap:wrap;
  font-size:12px;
  font-weight:500;
}
.dot{
  width:10px;
  height:10px;
  display:inline-block;
  border-radius:50%;
  margin-right:5px;
}
.absent-dot{
  background:#fde2e2;
}
.wfh-dot{
  background:#dde2ff;
}
.leave-dot{
  background:#fff2c7;
}
/* RIGHT PANEL */
.attendance-panel{
  background:linear-gradient(to bottom,#fff,#fafbff);
}

/* SCORE CARD */
.score-card{
  background:linear-gradient(135deg,#4a00e0,#7b2ff7);
  border-radius:18px;
  padding:16px;
  color:#fff;
  box-shadow:0 8px 20px rgba(74,0,224,.16);
}

.score-card h2{
  font-size:26px;
}

.score-icon{
  font-size:28px;
}

.progress{
  height:6px;
  border-radius:20px;
  background:rgba(255,255,255,.25);
}

/* INSIGHT BOX */
.insight-box{
  display:flex;
  justify-content:space-between;
  align-items:center;
  padding:12px;
  border-radius:16px;
  border:1px solid rgba(255,255,255,.5);
  box-shadow:0 4px 14px rgba(0,0,0,.04);
  margin-bottom:10px;
}

.insight-box h4{
  font-size:20px;
  margin:0;
}

.icon-wrap{
  width:40px;
  height:40px;
  border-radius:12px;
  display:flex;
  align-items:center;
  justify-content:center;
  font-size:15px;
  background:#fff;
}

.present-bg{
  background:#ecfdf5;
}

.absent-bg{
  background:#fef2f2;
}

.leave-bg{
  background:#fff7ed;
}

.wfh-bg{
  background:#eef2ff;
}

/* SUMMARY */
.quick-summary{
  background:#fff;
  border:1px solid #e2e8f0;
  border-radius:14px;
  padding:12px;
}

.summary-row{
  display:flex;
  justify-content:space-between;
  padding:9px 0;
  border-bottom:1px solid #edf2f7;
  font-size:12px;
}

/* HOLIDAY */
.holiday-item{
  border-bottom:1px solid #f1f5f9;
  padding:8px 0;
  display:flex;
  align-items:center;
  justify-content:space-between;
}

/* FOOTER */
.main-footer{
  background:#fff!important;
  border-top:1px solid #e2e8f0!important;
  color:#64748b;
  font-size:11px;
  padding:.8rem 1.2rem!important;
}

@media(max-width:991px){

  .score-card{
    padding:14px;
  }

  .day-box{
    height:36px;
    font-size:12px;
  }

  .insight-box{
    padding:10px;
  }
}
</style>
</head>

    <div class="content-wrapper">
      <section class="content">
        <div class="container-fluid pt-3">

          <div class="row equal-cols">
            <div class="col-6 col-md-3">
              <div class="stat-box shadow-sm">
                <div class="stat-icon bg-light text-primary"><i class="fas fa-check-circle"></i></div>
                <span class="text-muted small font-weight-bold">Present Days</span>
                <h3 class="font-weight-bold mb-0">21</h3>
              </div>
            </div>
            <div class="col-6 col-md-3">
              <div class="stat-box shadow-sm">
                <div class="stat-icon bg-light text-success"><i class="fas fa-stopwatch"></i></div>
                <span class="text-muted small font-weight-bold">Avg Hours</span>
                <h3 class="font-weight-bold mb-0">08:45</h3>
              </div>
            </div>
            <div class="col-6 col-md-3">
              <div class="stat-box shadow-sm">
                <div class="stat-icon bg-light text-warning"><i class="fas fa-running"></i></div>
                <span class="text-muted small font-weight-bold">Late Entries</span>
                <h3 class="font-weight-bold mb-0">02</h3>
              </div>
            </div>
            <div class="col-6 col-md-3">
              <div class="stat-box shadow-sm">
                <div class="stat-icon bg-light text-danger"><i class="fas fa-times-circle"></i></div>
                <span class="text-muted small font-weight-bold">Absent</span>
                <h3 class="font-weight-bold mb-0">01</h3>
              </div>
            </div>
          </div>

          <div class="row equal-cols">

    <!-- Calendar Section -->
    <div class="col-12 col-xl-8 col-lg-7">

        <div class="info-card shadow-sm">

            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
                <span class="section-title mb-0">
                    Attendance Calendar
                </span>

                <div class="d-flex flex-wrap mt-2 mt-md-0">

                    <select class="form-control mr-2 cal-select">
                        <option>January</option>
                        <option>February</option>
                        <option>March</option>
                        <option selected>April</option>
                        <option>May</option>
                    </select>

                    <select class="form-control cal-select">
                        <option>2025</option>
                        <option selected>2026</option>
                        <option>2027</option>
                    </select>

                </div>
            </div>

            <div class="attendance-cycle mb-3">
                <i class="fas fa-calendar-alt mr-2 text-primary"></i>
                Attendance Cycle :
                <strong>25 Mar 2026 → 24 Apr 2026</strong>
            </div>

            <div class="mini-calendar">
                <div class="day-name">M</div>
                <div class="day-name">T</div>
                <div class="day-name">W</div>
                <div class="day-name">T</div>
                <div class="day-name">F</div>
                <div class="day-name">S</div>
                <div class="day-name">S</div>

                <div class="day-box wfh">25</div>
                <div class="day-box absent">26</div>
                <div class="day-box leave">27</div>
                <div class="day-box present">28</div>
                <div class="day-box present">29</div>
                <div class="day-box wfh">30</div>
                <div class="day-box present">31</div>

                <div class="day-box present">1</div>
                <div class="day-box present">2</div>
                <div class="day-box leave">3</div>
                <div class="day-box present">4</div>
                <div class="day-box absent">5</div>
                <div class="day-box present">6</div>
                <div class="day-box present">7</div>

                <div class="day-box present">8</div>
                <div class="day-box wfh">9</div>
                <div class="day-box present">10</div>
                <div class="day-box leave">11</div>
                <div class="day-box present">12</div>
                <div class="day-box present">13</div>
                <div class="day-box absent">14</div>

                <div class="day-box present">15</div>
                <div class="day-box present">16</div>
                <div class="day-box present">17</div>
                <div class="day-box leave">18</div>
                <div class="day-box present">19</div>
                <div class="day-box wfh">20</div>
                <div class="day-box present">21</div>

                <div class="day-box present">22</div>
                <div class="day-box present">23</div>
                <div class="day-box absent">24</div>
            </div>

            <div class="attendance-legend mt-3">
                <span><span class="dot bg-success"></span> Present</span>
                <span><span class="dot absent-dot"></span> Absent</span>
                <span><span class="dot wfh-dot"></span> WFH</span>
                <span><span class="dot leave-dot"></span> Leave</span>
            </div>
        </div>
    </div>

  <!-- Right Side Box -->
<div class="col-12 col-xl-4 col-lg-5">
              <div class="info-card shadow-sm">
                <span class="section-title">Log Summary</span>
                <div class="table-responsive">
                  <table class="table table-sm table-borderless mt-2">
                    <thead>
                      <tr class="text-muted small">
                        <th>DATE</th>
                        <th>IN</th>
                        <th>STATUS</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>02 Apr</td>
                        <td>09:05</td>
                        <td><span class="badge badge-success">On Duty</span></td>
                      </tr>
                      <tr>
                        <td>01 Apr</td>
                        <td>08:50</td>
                        <td><span class="badge badge-light">Full Day</span></td>
                      </tr>
                      <tr>
                        <td>31 Mar</td>
                        <td>09:45</td>
                        <td><span class="badge badge-warning">Late In</span></td>
                      </tr>
                      <tr>
                        <td>30 Mar</td>
                        <td>09:00</td>
                        <td><span class="badge badge-light">Full Day</span></td>
                      </tr>
                      <tr>
                        <td>29 Mar</td>
                        <td>--:--</td>
                        <td><span class="badge badge-danger">Absent</span></td>
                      </tr>
                      <tr>
                        <td>02 Apr</td>
                        <td>09:05</td>
                        <td><span class="badge badge-success">On Duty</span></td>
                      </tr>
                      <tr>
                        <td>01 Apr</td>
                        <td>08:50</td>
                        <td><span class="badge badge-light">Full Day</span></td>
                      </tr>
                      <tr>
                        <td>31 Mar</td>
                        <td>09:45</td>
                        <td><span class="badge badge-warning">Late In</span></td>
                      </tr>
                      <tr>
                        <td>30 Mar</td>
                        <td>09:00</td>
                        <td><span class="badge badge-light">Full Day</span></td>
                      </tr>
                      <tr>
                        <td>29 Mar</td>
                        <td>--:--</td>
                        <td><span class="badge badge-danger">Absent</span></td>
                      </tr>
                       <tr>
                        <td>29 Mar</td>
                        <td>--:--</td>
                        <td><span class="badge badge-danger">Absent</span></td>
                      </tr>
                      <tr>
                        <td>02 Apr</td>
                        <td>09:05</td>
                        <td><span class="badge badge-success">On Duty</span></td>
                      </tr>
                      <tr>
                        <td>01 Apr</td>
                        <td>08:50</td>
                        <td><span class="badge badge-light">Full Day</span></td>
                      </tr>
                      <tr>
                        <td>31 Mar</td>
                        <td>09:45</td>
                        <td><span class="badge badge-warning">Late In</span></td>
                      </tr>
                      <tr>
                        <td>30 Mar</td>
                        <td>09:00</td>
                        <td><span class="badge badge-light">Full Day</span></td>
                      </tr>
                      <tr>
                        <td>29 Mar</td>
                        <td>--:--</td>
                        <td><span class="badge badge-danger">Absent</span></td>
                      </tr>
                    </tbody>
                  </table>
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
    $(function () {
      var ctx = document.getElementById('attendanceBarChart').getContext('2d');

      // Create Gradient for the bars
      var gradient = ctx.createLinearGradient(0, 0, 0, 400);
      gradient.addColorStop(0, '#4a00e0'); // Bloom Purple
      gradient.addColorStop(1, '#8e2de2');

      new Chart(ctx, {
        type: 'bar',
        data: {
          labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
          datasets: [{
            label: 'Working Hours',
            data: [8.5, 9.2, 8.0, 7.5, 9.0, 4.0, 0], // Sample data
            backgroundColor: gradient,
            borderRadius: 8,
            barThickness: 25
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: { display: false }
          },
          scales: {
            y: {
              beginAtZero: true,
              max: 12,
              grid: { display: true, color: '#f1f5f9' },
              ticks: { font: { family: 'Plus Jakarta Sans', size: 11 } }
            },
            x: {
              grid: { display: false },
              ticks: { font: { family: 'Plus Jakarta Sans', size: 11, weight: '600' } }
            }
          }
        }
      });
    });
  </script>
</body>

</html>
