<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bloom Solutions | Admin Payslips & Disbursement</title>

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

  <style>
    /* Modern Pill/Segmented Control Tabs */
    .custom-tabs-wrapper {
      margin-bottom: 20px;
      border-bottom: none !important;
      display: flex;
      justify-content: flex-start;
      overflow-x: auto;
      scrollbar-width: none;
      -ms-overflow-style: none;
    }
    .custom-tabs-wrapper::-webkit-scrollbar {
      display: none;
    }
    .custom-tabs {
      border-bottom: none !important;
      gap: 5px;
      padding: 6px;
      background: #f1f5f9;
      border-radius: 50px;
      display: inline-flex;
      flex-wrap: nowrap;
    }
    .custom-tabs .nav-item {
      margin-bottom: 0;
    }
    .custom-tabs .nav-link {
      color: #64748b;
      border: none !important;
      font-weight: 600;
      padding: 10px 24px !important;
      border-radius: 50px !important;
      transition: all 0.3s ease;
      background: transparent;
      font-size: 14px;
      display: flex;
      align-items: center;
      gap: 8px;
      white-space: nowrap;
    }
    .custom-tabs .nav-link:hover:not(.active) {
      color: #1e293b;
      background: #e2e8f0;
    }
    .custom-tabs .nav-link.active {
      color: #ffffff !important;
      background: #4a00e0 !important;
      box-shadow: 0 4px 15px rgba(74, 0, 224, 0.2) !important;
      font-weight: 700;
      transform: translateY(-1px);
    }
  </style>
</head>


<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
  <div class="wrapper">

    <nav class="main-header navbar navbar-expand navbar-white navbar-light shadow-sm">

      <ul class="navbar-nav align-items-center">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
        </li>

        <li class="nav-item d-none d-sm-inline-block ml-2">
          <h5 class="mb-0 font-weight-bold" style="color: var(--mtn-deep);">
            Hello, <span style="color: var(--bloom-purple);">Ishu</span> 👋
          </h5>
        </li>
      </ul>

      <ul class="navbar-nav ml-auto align-items-center">

        <!-- Role Switcher -->
        <li class="nav-item mr-3 d-none d-sm-inline-block">
          <a href="../empolyee/dashboard.html" class="btn btn-sm"
            style="background-color: #eef2ff; color: var(--bloom-purple); font-weight: 600; border-radius: 50px; white-space: nowrap; border: 1px solid #c7d2fe;">
            <i class="fas fa-exchange-alt mr-1"></i> Switch to Employee
          </a>
        </li>

        <!-- Messages -->
        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="far fa-comments"></i>
            <span class="badge badge-danger navbar-badge">3</span>
          </a>

          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right shadow">

            <a href="#" class="dropdown-item">
              <div class="media">
                <img src="https://ui-avatars.com/api/?name=Rahul" class="img-size-40 mr-3 img-circle">
                <div class="media-body">
                  <h3 class="dropdown-item-title">
                    Rahul
                    <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                  </h3>
                  <p class="text-sm">Leave approved 👍</p>
                  <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 5 mins</p>
                </div>
              </div>
            </a>

            <div class="dropdown-divider"></div>

            <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>

          </div>
        </li>

        <!-- Leave Notifications -->
        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="far fa-bell"></i>
            <span class="badge badge-warning navbar-badge">2</span>
          </a>

          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right shadow">

            <span class="dropdown-header">2 Leave Notifications</span>

            <div class="dropdown-divider"></div>

            <a href="#" class="dropdown-item">
              <i class="fas fa-user-clock mr-2 text-primary"></i>
              New Leave Request
              <span class="float-right text-muted text-sm">10 mins</span>
            </a>

            <div class="dropdown-divider"></div>

            <a href="#" class="dropdown-item">
              <i class="fas fa-check-circle mr-2 text-success"></i>
              Leave Approved
              <span class="float-right text-muted text-sm">1 hour</span>
            </a>

            <div class="dropdown-divider"></div>

            <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>

          </div>
        </li>

        <!-- Profile -->
        <li class="nav-item dropdown">
          <a class="nav-link d-flex align-items-center" data-toggle="dropdown" href="#">
            <img src="https://ui-avatars.com/api/?name=Aishwarya&background=4a00e0&color=fff"
              class="rounded-circle shadow-sm" style="width: 32px; border: 2px solid #fff;">
            <span class="ml-2 d-none d-sm-inline-block font-weight-bold text-dark">
              Aishwarya
            </span>
          </a>

          <div class="dropdown-menu dropdown-menu-right border-0 shadow-lg mt-2" style="border-radius:12px;">
            <a href="profile.html" class="dropdown-item">
              <i class="fas fa-user mr-2"></i> Profile
            </a>

            <div class="dropdown-divider"></div>

            <a href="#" class="dropdown-item text-danger">
              <i class="fas fa-power-off mr-2"></i> Logout
            </a>
          </div>
        </li>

      </ul>

    </nav>
            <aside class="main-sidebar sidebar-dark-primary elevation-0" style="background-color: #111c43;">
      <a href="#" class="brand-link border-0" style="background-color: #111c43;">
        <img src="public/dist/img/bloom.jpg" alt="Logo" class="brand-image img-circle">
        <span class="brand-text font-weight-bold">
          <span style="color:#4a8cff;">Bloom</span> <span style="color:#ff7a45;">Solutions</span>
        </span>
      </a>

      <div class="sidebar">
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu">


            <li class="nav-item">
              <a href="dashboard.html" class="nav-link active">
                <i class="nav-icon fas fa-home"></i>
                <p>Payslips & Disbursement</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="calender.html" class="nav-link">
                <i class="nav-icon far fa-calendar-alt"></i>
                <p>My Calendar</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="deparment.html" class="nav-link">
                <i class="nav-icon fas fa-building"></i>
                <p>Departments</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-users-cog"></i>
                <p>HR<i class="right fas fa-angle-right"></i></p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="empolyees.html" class="nav-link">
                    <i class="nav-icon far fa-id-card"></i>
                    <p>Employees</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="attendance_dashboard.html" class="nav-link">
                    <i class="nav-icon far fa-clock"></i>
                    <p>Attendance</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="leave_overview.html" class="nav-link">
                    <i class="nav-icon fas fa-calendar-times"></i>
                    <p>Leave Mgmt</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="payroll_dashboard.html" class="nav-link">
                    <i class="nav-icon fas fa-money-check-alt"></i>
                    <p>Payroll</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="leave_requ.html" class="nav-link">
                    <i class="nav-icon fas fa-paper-plane"></i>
                    <p>Requests</p>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item">
              <a href="announcement.html" class="nav-link">
                <i class="nav-icon fas fa-bullhorn"></i>
                <p>Announcements</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-chart-line"></i>
                <p>Reports & Logs</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-cog"></i>
                <p>Settings<i class="right fas fa-angle-right"></i></p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="polices.html" class="nav-link">
                    <i class="nav-icon fas fa-list-ol"></i>
                    <p>Policies</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="change_password.html" class="nav-link">
                    <i class="nav-icon fas fa-key"></i>
                    <p>Change Password</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="help.html" class="nav-link">
                    <i class="nav-icon fa fa-question-circle"></i>
                    <p>Help Desk</p>
                  </a>
                </li>

              </ul>
        </nav>
      </div>
    </aside>

    <div class="content-wrapper">
      <section class="content pt-3">
        <div class="container-fluid">

          <div class="row mb-3">
            <div class="col-12 d-flex justify-content-between align-items-center">
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent p-0 m-0">
                  <li class="breadcrumb-item"><a href="dashboard.html" class="text-primary">Home</a></li>
                  <li class="breadcrumb-item"><a href="payroll_dashboard.html" class="text-primary">Payroll</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Payslips & Disbursement</li>
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
                <li class="nav-item"><a href="payroll_dashboard.html" class="nav-link px-3 py-2 "><i class="fas fa-tachometer-alt mr-1"></i> Dashboard</a></li>
                <li class="nav-item"><a href="payroll_configuration.html" class="nav-link px-3 py-2 "><i class="fas fa-cogs mr-1"></i> Config</a></li>
                <li class="nav-item"><a href="payroll_salary_management.html" class="nav-link px-3 py-2 "><i class="fas fa-money-bill mr-1"></i> Financials</a></li>
                <li class="nav-item"><a href="payroll_attendance_inputs.html" class="nav-link px-3 py-2 "><i class="fas fa-user-clock mr-1"></i> Attendance</a></li>
                <li class="nav-item"><a href="payroll_processing.html" class="nav-link px-3 py-2 "><i class="fas fa-sync-alt mr-1"></i> Processing</a></li>
                <li class="nav-item"><a href="payroll_approval_center.html" class="nav-link px-3 py-2 "><i class="fas fa-check-circle mr-1"></i> Approvals</a></li>
                <li class="nav-item"><a href="payroll_payslips.html" class="nav-link px-3 py-2 active"><i class="fas fa-file-invoice mr-1"></i> Payslips</a></li>
                <li class="nav-item"><a href="payroll_reports.html" class="nav-link px-3 py-2 "><i class="fas fa-chart-bar mr-1"></i> Reports</a></li>
              </ul>
            </div>
          </div>
    
          <div class="custom-tabs-wrapper mb-3" style="border-bottom: 1px solid #e2e8f0;">
              <ul class="nav nav-tabs custom-tabs nav-justified" id="payTabs" role="tablist">
                <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#payslips" role="tab"><i class="fas fa-file-invoice mr-2"></i>Payslips</a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#disbursement" role="tab"><i class="fas fa-money-check mr-2"></i>Salary Disbursement</a></li>
              </ul>
            </div>
            <div class="card card-bloom p-4">
              <div class="tab-content">
                <!-- Payslips -->
                <div class="tab-pane fade show active" id="payslips" role="tabpanel">
                  <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="input-group" style="max-width: 300px;">
                      <div class="input-group-prepend"><span class="input-group-text bg-white"><i class="fas fa-calendar"></i></span></div>
                      <select class="form-control border-left-0"><option>April 2026</option><option>March 2026</option></select>
                    </div>
                    <div>
                      <button class="btn btn-outline-primary font-weight-bold mr-2"><i class="fas fa-paper-plane mr-1"></i> Email All</button>
                      <button class="btn btn-primary font-weight-bold"><i class="fas fa-download mr-1"></i> Download ZIP</button>
                    </div>
                  </div>
                  <table class="table table-hover border">
                    <thead class="bg-light text-muted"><tr><th>EMPLOYEE</th><th>DEPARTMENT</th><th>NET PAY</th><th>STATUS</th><th class="text-right">ACTIONS</th></tr></thead>
                    <tbody>
                      <tr><td><strong>John Doe</strong></td><td>Engineering</td><td class="font-weight-bold">₹ 55,500</td><td><span class="badge badge-success px-2 py-1">Generated</span></td><td class="text-right"><button class="btn btn-sm btn-light text-primary"><i class="fas fa-eye"></i> View</button> <button class="btn btn-sm btn-light text-info"><i class="fas fa-envelope"></i> Send</button></td></tr>
                      <tr><td><strong>Jane Smith</strong></td><td>Marketing</td><td class="font-weight-bold">₹ 46,800</td><td><span class="badge badge-success px-2 py-1">Generated</span></td><td class="text-right"><button class="btn btn-sm btn-light text-primary"><i class="fas fa-eye"></i> View</button> <button class="btn btn-sm btn-light text-info"><i class="fas fa-envelope"></i> Send</button></td></tr>
                    </tbody>
                  </table>
                </div>
                
                <!-- Disbursement -->
                <div class="tab-pane fade" id="disbursement" role="tabpanel">
                  <div class="d-flex justify-content-between align-items-center mb-4">
                    <h6 class="font-weight-bold mb-0">Bank Transfer Statements</h6>
                    <div>
                      <button class="btn btn-light border font-weight-bold mr-2 text-success"><i class="fas fa-file-excel mr-1"></i> Export Bank Format</button>
                      <button class="btn btn-primary font-weight-bold"><i class="fas fa-check-circle mr-1"></i> Mark All Paid</button>
                    </div>
                  </div>
                  <table class="table table-hover border">
                    <thead class="bg-light text-muted"><tr><th>EMPLOYEE</th><th>BANK NAME</th><th>ACCOUNT NO.</th><th>AMOUNT</th><th>PAYMENT STATUS</th><th class="text-right">ACTIONS</th></tr></thead>
                    <tbody>
                      <tr><td><strong>John Doe</strong></td><td>HDFC Bank</td><td>XXXX-XXXX-1234</td><td class="font-weight-bold">₹ 55,500</td><td><span class="badge badge-warning px-2 py-1">Pending</span></td><td class="text-right"><button class="btn btn-sm btn-success">Mark Paid</button></td></tr>
                      <tr><td><strong>Jane Smith</strong></td><td>ICICI Bank</td><td>XXXX-XXXX-5678</td><td class="font-weight-bold">₹ 46,800</td><td><span class="badge badge-success px-2 py-1">Paid</span></td><td class="text-right"><button class="btn btn-sm btn-light text-muted" disabled>Paid</button></td></tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
    <footer class="main-footer">

    <div class="d-flex align-items-center">
      <strong>Copyright &copy; 2026 <a href="https://www.bloomsolutions.in/" class="footer-link ml-1">Bloom
          Solutions</a></strong>


    </div>
  </footer>
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