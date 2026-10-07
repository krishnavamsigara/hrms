<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bloom Solutions | Admin Payroll Dashboard</title>

  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700&display=swap"
    rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
  <style>
    :root {
      --bloom-purple: #4a00e0;
      --bloom-dark: #120038;
      --bloom-orange: #e46c44;
      --bloom-success: #10b981;
      --bloom-danger: #dc2626;
      --mtn-deep: #120038;
      --soft-gray: #f8fafc;
      --border-color: #e2e8f0;
    }

    /* BODY */
    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      background-color: var(--soft-gray);
      font-size: 13px;
      color: #334155;
    }

    /* NAVBAR */
    .main-header {
      border-bottom: 1px solid #e2e8f0 !important;
      background: #ffffff !important;
      height: 55px;
    }

    /* SIDEBAR */
    .main-sidebar {
      background: #111c43 !important;
    }

    /* SIDEBAR BRAND */
    .brand-link {
      border-bottom: 1px solid rgba(255, 255, 255, 0.1);
      padding: 14px 18px;
    }

    /* SIDEBAR NAV LINKS */
    .nav-sidebar .nav-link {
      display: flex;
      align-items: center;
      height: 42px;
      padding: 0 14px;
      font-size: 13px;
    }

    .nav-sidebar .nav-link i {
      width: 24px;
      text-align: center;
      margin-right: 10px;
      font-size: 14px;
    }

    .nav-sidebar .nav-link p {
      margin: 0;
    }

    /* ACTIVE MENU */
    .nav-pills .nav-link.active,
    .nav-sidebar>.nav-item>.nav-link.active {
      background: #007bff !important;
      color: #fff !important;
    }

    /* HOVER */
    .nav-sidebar .nav-link:hover:not(.active) {
      background: rgba(255, 255, 255, 0.08);
    }

    /* CONTENT */
    .content {
      padding-top: 10px !important;
    }

    /* ROW FIX */
    .row {
      margin-bottom: 6px;
    }

    /* CARD */
    .card-bloom {
      border: 1px solid var(--border-color) !important;
      border-radius: 16px !important;
      background: #fff;
      box-shadow: 0 3px 6px rgba(0, 0, 0, 0.04);
      margin-bottom: 12px;
      transition: all .3s;
    }

    .card-bloom:hover {
      transform: translateY(-4px);
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08);
    }

    /* MINI STAT CARDS */
    .stat-mini {
      padding: 18px;
    }

    .stat-mini strong {
      font-size: 1.4rem;
      color: var(--mtn-deep);
    }

    .stat-icon-circle {
      width: 42px;
      height: 42px;
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 17px;
      margin-bottom: 10px;
    }

    /* STATUS GRID */
    .status-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 10px;
      text-align: center;
    }

    .fulltime {
      grid-column: 1/span 2;
    }

    .status-item {
      background: #f4f6f9;
      padding: 10px;
      border-radius: 6px;
    }

    .status-item strong {
      font-size: 1.2rem;
    }

    /* PROGRESS MULTI */
    .progress-multi {
      display: flex;
      height: 8px;
      overflow: hidden;
      border-radius: 4px;
      background: #f1f5f9;
    }

    .progress-multi div {
      height: 100%;
    }

    /* AVATAR */
    .avatar-sm {
      width: 38px;
      height: 38px;
      border-radius: 10px;
    }

    /* FOOTER */
    .main-footer {
      background: #fff !important;
      border-top: 1px solid #e2e8f0 !important;
      font-size: 12px;
      padding: 10px 20px !important;
    }

    /* FOOTER LINK */
    .footer-link {
      color: var(--bloom-purple);
      font-weight: 600;
      text-decoration: none;
    }

    /* MOBILE */
    @media(max-width:768px) {

      .content-wrapper {
        padding-top: 55px;
        padding-bottom: 15px;
      }

      .stat-mini strong {
        font-size: 1.2rem;
      }

    }

    /* Equal height rows */
    .row-equal {
      display: flex;
      flex-wrap: wrap;
    }

    .row-equal>[class*='col-'] {
      display: flex;
    }

    .row-equal .card-bloom {
      flex: 1;
      width: 100%;
    }

    /* ZONES CARD */
    .zone-item {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 12px 14px;
      border-radius: 12px;
      border: 1px solid #e2e8f0;
      background: #f8fafc;
      margin-bottom: 10px;
      transition: all .25s ease;
      text-decoration: none;
    }

    .zone-item:hover {
      transform: translateY(-3px);
      box-shadow: 0 6px 14px rgba(0, 0, 0, 0.08);
      background: #ffffff;
    }

    /* LEFT CONTENT */
    .zone-left {
      display: flex;
      align-items: center;
    }

    /* ZONE IMAGE */
    .zone-img {
      width: 40px;
      height: 40px;
      border-radius: 10px;
      object-fit: cover;
      margin-right: 12px;
    }

    /* ZONE ICON (optional) */
    .zone-icon {
      width: 40px;
      height: 40px;
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #fff;
      font-size: 16px;
      margin-right: 12px;
    }

    /* COLORS */
    .zone-blue .zone-icon {
      background: #3b82f6;
    }

    .zone-green .zone-icon {
      background: #10b981;
    }

    .zone-orange .zone-icon {
      background: #f59e0b;
    }

    /* EMPLOYEE COUNT */
    .zone-count {
      font-size: 12px;
      font-weight: 600;
      background: #eef2ff;
      padding: 4px 8px;
      border-radius: 6px;
      color: #4a00e0;
    }
  </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
  <div class="wrapper">

    <div class="content-wrapper">
      <section class="content pt-3">
        <div class="container-fluid">

          <div class="row mb-3">
            <div class="col-12 d-flex justify-content-between align-items-center">
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent p-0 m-0">
                  <li class="breadcrumb-item"><a href="dashboard.html" class="text-primary">Home</a></li>
                  <li class="breadcrumb-item"><a href="payroll_dashboard.html" class="text-primary">Payroll</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Payroll Dashboard</li>
                </ol>
              </nav>
            </div>
          </div>
    
          <!-- Payroll Module Horizontal Nav -->
          <div class="card card-bloom mb-3 border-0 shadow-sm" style="background: #ffffff; border-radius: 12px; overflow: hidden; transition: all 0.3s ease;">
            <div class="card-header border-0 bg-transparent py-3" data-card-widget="collapse" style="cursor: pointer; display: flex; justify-content: space-between; align-items: center;">
              <h6 class="m-0 font-weight-bold" style="color: #4a00e0; font-size: 14px; letter-spacing: 0.3px;">
                <i class="fas fa-layer-group mr-2"></i> Payroll Navigation
              </h6>
              <div>
                <button type="button" class="btn btn-sm btn-light rounded-circle" data-card-widget="collapse" style="width: 32px; height: 32px; box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
                  <i class="fas fa-minus text-primary"></i>
                </button>
              </div>
            </div>
            <div class="card-body py-2 px-4">
              <style>
                .payroll-pills .nav-link { color: #475569; background: #f1f5f9; border-radius: 50px; white-space: nowrap; font-weight: 600; font-size: 12px; transition: all 0.2s; }
                .payroll-pills .nav-link:hover:not(.active) { background: #e2e8f0; color: #1e293b; }
                .payroll-pills .nav-link.active { background: #4a00e0; color: #ffffff; box-shadow: 0 4px 10px rgba(74, 0, 224, 0.2); transform: translateY(-1px); }
              </style>
              <ul class="nav nav-pills payroll-pills flex-nowrap gap-2 align-items-center" style="gap: 8px; margin-bottom: 15px; overflow-x: auto; scrollbar-width: none;">
                <li class="nav-item"><a href="payroll_dashboard.html" class="nav-link px-3 py-2 active"><i class="fas fa-tachometer-alt mr-1"></i> Dashboard</a></li>
                <li class="nav-item"><a href="payroll_configuration.html" class="nav-link px-3 py-2 "><i class="fas fa-cogs mr-1"></i> Config</a></li>
                <li class="nav-item"><a href="payroll_salary_management.html" class="nav-link px-3 py-2 "><i class="fas fa-money-bill mr-1"></i> Financials</a></li>
                <li class="nav-item"><a href="payroll_attendance_inputs.html" class="nav-link px-3 py-2 "><i class="fas fa-user-clock mr-1"></i> Attendance</a></li>
                <li class="nav-item"><a href="payroll_processing.html" class="nav-link px-3 py-2 "><i class="fas fa-sync-alt mr-1"></i> Processing</a></li>
                <li class="nav-item"><a href="payroll_approval_center.html" class="nav-link px-3 py-2 "><i class="fas fa-check-circle mr-1"></i> Approvals</a></li>
                <li class="nav-item"><a href="payroll_payslips.html" class="nav-link px-3 py-2 "><i class="fas fa-file-invoice mr-1"></i> Payslips</a></li>
                <li class="nav-item"><a href="payroll_reports.html" class="nav-link px-3 py-2 "><i class="fas fa-chart-bar mr-1"></i> Reports</a></li>
              </ul>
            </div>
          </div>
    
                    <div class="row row-equal">
            <div class="col-md-4 col-sm-6">
              <div class="card-bloom stat-mini" style="color: var(--bloom-purple)">
                <div class="stat-icon-circle" style="background:#eef2ff;"><i class="fas fa-users"></i></div>
                <strong>142</strong>
                <small class="text-muted font-weight-bold">Total Employees</small>
                <a href="#" class="small text-primary mt-2 font-weight-bold">View List</a>
              </div>
            </div>
            <div class="col-md-4 col-sm-6">
              <div class="card-bloom stat-mini" style="color: var(--bloom-orange)">
                <div class="stat-icon-circle" style="background:#fff3e6;"><i class="fas fa-hourglass-half"></i></div>
                <strong>April 2026</strong>
                <small class="text-muted font-weight-bold">Pending Payroll</small>
                <a href="payroll_processing.html" class="small text-primary mt-2 font-weight-bold">Process Now</a>
              </div>
            </div>
            <div class="col-md-4 col-sm-6">
              <div class="card-bloom stat-mini" style="color: var(--bloom-success)">
                <div class="stat-icon-circle" style="background:#ecfdf5;"><i class="fas fa-check-circle"></i></div>
                <strong>March 2026</strong>
                <small class="text-muted font-weight-bold">Processed Payroll</small>
                <a href="payroll_reports.html" class="small text-primary mt-2 font-weight-bold">View Report</a>
              </div>
            </div>
            <div class="col-md-4 col-sm-6">
              <div class="card-bloom stat-mini" style="color: #0369a1">
                <div class="stat-icon-circle" style="background:#e0f2fe;"><i class="fas fa-money-check-alt"></i></div>
                <strong>₹ 45.2 L</strong>
                <small class="text-muted font-weight-bold">Total Salary Payout</small>
                <a href="#" class="small text-primary mt-2 font-weight-bold">Analytics</a>
              </div>
            </div>
            <div class="col-md-4 col-sm-6">
              <div class="card-bloom stat-mini" style="color: var(--bloom-danger)">
                <div class="stat-icon-circle" style="background:#fef2f2;"><i class="fas fa-clipboard-check"></i></div>
                <strong>5 Requests</strong>
                <small class="text-muted font-weight-bold">Pending Approvals</small>
                <a href="payroll_approval_center.html" class="small text-primary mt-2 font-weight-bold">Review Now</a>
              </div>
            </div>
            <div class="col-md-4 col-sm-6">
              <div class="card-bloom stat-mini" style="color: #475569">
                <div class="stat-icon-circle" style="background:#f1f5f9;"><i class="fas fa-calendar-alt"></i></div>
                <strong>01 May 2026</strong>
                <small class="text-muted font-weight-bold">Next Payday</small>
                <a href="#" class="small text-primary mt-2 font-weight-bold">Reminders</a>
              </div>
            </div>
          </div>
          
<div class="row">
            <div class="col-md-8 mb-3">
              <div class="card card-bloom p-4 h-100">
                <h6 class="font-weight-bold mb-4">Analytics Overview</h6>
                <div class="row">
                  <div class="col-md-6 mb-3">
                    <div style="height:250px; background:#f8fafc; border-radius:12px; display:flex; flex-direction:column; align-items:center; justify-content:center; border:1px solid #e2e8f0;">
                      <i class="fas fa-chart-line fa-3x text-primary mb-2 opacity-50"></i>
                      <span class="text-muted font-weight-bold">Monthly Payroll Trend</span>
                      <small class="text-muted">(Chart.js Placeholder)</small>
                    </div>
                  </div>
                  <div class="col-md-6 mb-3">
                    <div style="height:250px; background:#f8fafc; border-radius:12px; display:flex; flex-direction:column; align-items:center; justify-content:center; border:1px solid #e2e8f0;">
                      <i class="fas fa-chart-pie fa-3x text-info mb-2 opacity-50"></i>
                      <span class="text-muted font-weight-bold">Dept. Salary Distribution</span>
                      <small class="text-muted">(Chart.js Placeholder)</small>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            
            <div class="col-md-4 mb-3">
              <div class="card card-bloom p-4 h-100">
                <h6 class="font-weight-bold mb-4">Quick Actions</h6>
                <div class="d-flex flex-column gap-3" style="gap:15px;">
                  <a href="payroll_processing.html" class="btn btn-primary btn-block text-left py-3 rounded-lg font-weight-bold shadow-sm">
                    <i class="fas fa-play-circle mr-2 fa-lg"></i> Process Payroll
                  </a>
                  <a href="payroll_attendance_inputs.html" class="btn btn-light btn-block text-left py-3 rounded-lg font-weight-bold border">
                    <i class="fas fa-file-import mr-2 text-info fa-lg"></i> Import Attendance
                  </a>
                  <a href="payroll_salary_management.html" class="btn btn-light btn-block text-left py-3 rounded-lg font-weight-bold border">
                    <i class="fas fa-rupee-sign mr-2 text-success fa-lg"></i> Assign Salary
                  </a>
                  <a href="payroll_payslips.html" class="btn btn-light btn-block text-left py-3 rounded-lg font-weight-bold border">
                    <i class="fas fa-file-invoice mr-2 text-warning fa-lg"></i> Generate Payslips
                  </a>
                  <a href="payroll_reports.html" class="btn btn-light btn-block text-left py-3 rounded-lg font-weight-bold border">
                    <i class="fas fa-download mr-2 text-secondary fa-lg"></i> Download Reports
                  </a>
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
</body>

</html>