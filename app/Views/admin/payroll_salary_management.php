<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bloom Solutions | Admin Salary Management</title>

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
        <img src="../dist/img/bloom.jpg" alt="Logo" class="brand-image img-circle">
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
                <p>Salary Management</p>
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
                  <li class="breadcrumb-item active" aria-current="page">Salary Management</li>
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
                <li class="nav-item"><a href="payroll_salary_management.html" class="nav-link px-3 py-2 active"><i class="fas fa-money-bill mr-1"></i> Financials</a></li>
                <li class="nav-item"><a href="payroll_attendance_inputs.html" class="nav-link px-3 py-2 "><i class="fas fa-user-clock mr-1"></i> Attendance</a></li>
                <li class="nav-item"><a href="payroll_processing.html" class="nav-link px-3 py-2 "><i class="fas fa-sync-alt mr-1"></i> Processing</a></li>
                <li class="nav-item"><a href="payroll_approval_center.html" class="nav-link px-3 py-2 "><i class="fas fa-check-circle mr-1"></i> Approvals</a></li>
                <li class="nav-item"><a href="payroll_payslips.html" class="nav-link px-3 py-2 "><i class="fas fa-file-invoice mr-1"></i> Payslips</a></li>
                <li class="nav-item"><a href="payroll_reports.html" class="nav-link px-3 py-2 "><i class="fas fa-chart-bar mr-1"></i> Reports</a></li>
              </ul>
            </div>
          </div>
    
          <div class="custom-tabs-wrapper mb-3" style="border-bottom: 1px solid #e2e8f0;">
              <ul class="nav nav-tabs custom-tabs nav-justified" id="salaryTabs" role="tablist">
                <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#components" role="tab">Salary Components</a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#templates" role="tab">Salary Templates</a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#assignment" role="tab">Employee Assignment</a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#hikes" role="tab">Increments & Hikes</a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#loans" role="tab">Advances & Loans</a></li>
              </ul>
            </div>
            <div class="card card-bloom p-4">
              <div class="tab-content">
                <!-- Components -->
                <div class="tab-pane fade show active" id="components" role="tabpanel">
                  <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="input-group" style="width: 250px;">
                      <div class="input-group-prepend"><span class="input-group-text bg-white"><i class="fas fa-search text-muted"></i></span></div>
                      <input type="text" class="form-control border-left-0" placeholder="Search component...">
                    </div>
                    <button class="btn btn-primary font-weight-bold" data-toggle="modal" data-target="#addComponentModal"><i class="fas fa-plus mr-1"></i> Add Component</button>
                  </div>
                  <div class="table-responsive">
                    <table class="table table-hover border">
                      <thead class="bg-light text-muted"><tr><th>COMPONENT NAME</th><th>TYPE</th><th>CALCULATION VALUE</th><th>STATUS</th><th class="text-right">ACTIONS</th></tr></thead>
                      <tbody>
                        <tr><td>Basic Salary</td><td><span class="badge badge-success px-2 py-1">Earning</span></td><td>50% of CTC</td><td><div class="custom-control custom-switch"><input type="checkbox" class="custom-control-input" id="c1" checked><label class="custom-control-label" for="c1"></label></div></td><td class="text-right"><button class="btn btn-sm btn-light text-primary"><i class="fas fa-edit"></i></button> <button class="btn btn-sm btn-light text-danger"><i class="fas fa-trash"></i></button></td></tr>
                        <tr><td>HRA</td><td><span class="badge badge-success px-2 py-1">Earning</span></td><td>20% of Basic</td><td><div class="custom-control custom-switch"><input type="checkbox" class="custom-control-input" id="c2" checked><label class="custom-control-label" for="c2"></label></div></td><td class="text-right"><button class="btn btn-sm btn-light text-primary"><i class="fas fa-edit"></i></button> <button class="btn btn-sm btn-light text-danger"><i class="fas fa-trash"></i></button></td></tr>
                        <tr><td>PF Deduction</td><td><span class="badge badge-danger px-2 py-1">Deduction</span></td><td>12% of Basic</td><td><div class="custom-control custom-switch"><input type="checkbox" class="custom-control-input" id="c3" checked><label class="custom-control-label" for="c3"></label></div></td><td class="text-right"><button class="btn btn-sm btn-light text-primary"><i class="fas fa-edit"></i></button> <button class="btn btn-sm btn-light text-danger"><i class="fas fa-trash"></i></button></td></tr>
                      </tbody>
                    </table>
                  </div>
                </div>

                <!-- Templates -->
                <div class="tab-pane fade" id="templates" role="tabpanel">
                  <div class="d-flex justify-content-between align-items-center mb-4">
                    <h6 class="font-weight-bold mb-0">Configured Templates</h6>
                    <button class="btn btn-primary font-weight-bold"><i class="fas fa-plus mr-1"></i> Create Template</button>
                  </div>
                  <div class="row">
                    <div class="col-md-4 mb-3">
                      <div class="card shadow-sm border h-100 p-4" style="border-radius:12px;">
                        <h6 class="font-weight-bold">Standard Developer Tier</h6>
                        <h4 class="font-weight-bold text-primary mt-2">₹ 6,00,000 <small class="text-muted text-sm font-weight-normal">/ yr</small></h4>
                        <hr>
                        <p class="text-muted small mb-0"><i class="fas fa-layer-group mr-1"></i> 8 Components Included</p>
                      </div>
                    </div>
                    <div class="col-md-4 mb-3">
                      <div class="card shadow-sm border h-100 p-4" style="border-radius:12px;">
                        <h6 class="font-weight-bold">Senior Management Tier</h6>
                        <h4 class="font-weight-bold text-primary mt-2">₹ 15,00,000 <small class="text-muted text-sm font-weight-normal">/ yr</small></h4>
                        <hr>
                        <p class="text-muted small mb-0"><i class="fas fa-layer-group mr-1"></i> 10 Components Included</p>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Assignment -->
                <div class="tab-pane fade" id="assignment" role="tabpanel">
                  <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="input-group" style="width: 250px;">
                      <div class="input-group-prepend"><span class="input-group-text bg-white"><i class="fas fa-search text-muted"></i></span></div>
                      <input type="text" class="form-control border-left-0" placeholder="Search employee...">
                    </div>
                    <div>
                      <button class="btn btn-light border mr-2"><i class="fas fa-filter mr-1"></i> Filter</button>
                      <button class="btn btn-primary font-weight-bold"><i class="fas fa-user-check mr-1"></i> Assign Salary</button>
                    </div>
                  </div>
                  <div class="table-responsive">
                    <table class="table table-hover border">
                      <thead class="bg-light text-muted"><tr><th>EMPLOYEE</th><th>DEPARTMENT</th><th>CURRENT TEMPLATE</th><th>GROSS SALARY</th><th class="text-right">ACTIONS</th></tr></thead>
                      <tbody>
                        <tr><td><div class="d-flex align-items-center"><img src="https://ui-avatars.com/api/?name=John+Doe&background=f1f5f9" class="rounded-circle mr-2" width="32"><strong>John Doe</strong></div></td><td>Engineering</td><td><span class="badge badge-light border">Standard Developer Tier</span></td><td class="font-weight-bold">₹ 6,00,000</td><td class="text-right"><button class="btn btn-sm btn-light text-primary font-weight-bold">Edit</button></td></tr>
                      </tbody>
                    </table>
                  </div>
                </div>

                <!-- Hikes -->
                <div class="tab-pane fade" id="hikes" role="tabpanel">
                  <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="font-weight-bold mb-0">Salary Increments</h6>
                    <button class="btn btn-primary font-weight-bold" data-toggle="modal" data-target="#hikeModal"><i class="fas fa-chart-line mr-1"></i> Process Hike</button>
                  </div>
                  <table class="table table-hover border">
                    <thead class="bg-light text-muted"><tr><th>EMPLOYEE</th><th>EFFECTIVE DATE</th><th>OLD SALARY</th><th>HIKE %</th><th>NEW SALARY</th><th class="text-right">STATUS</th></tr></thead>
                    <tbody>
                      <tr><td><strong>Jane Smith</strong></td><td>01 May 2026</td><td class="text-muted">₹ 5,00,000</td><td class="text-success font-weight-bold">+ 10%</td><td class="font-weight-bold">₹ 5,50,000</td><td class="text-right"><span class="badge badge-warning">Pending Approval</span></td></tr>
                    </tbody>
                  </table>
                </div>

                <!-- Loans -->
                <div class="tab-pane fade" id="loans" role="tabpanel">
                  <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="font-weight-bold mb-0">Advances & Loans</h6>
                    <button class="btn btn-primary font-weight-bold" data-toggle="modal" data-target="#loanModal"><i class="fas fa-hand-holding-usd mr-1"></i> Grant Loan</button>
                  </div>
                  <table class="table table-hover border">
                    <thead class="bg-light text-muted"><tr><th>EMPLOYEE</th><th>TOTAL LOAN</th><th>EMI AMOUNT</th><th>RECOVERED</th><th>BALANCE</th><th class="text-right">STATUS</th></tr></thead>
                    <tbody>
                      <tr><td><strong>Mark Lee</strong></td><td>₹ 50,000</td><td>₹ 5,000</td><td class="text-success">₹ 15,000</td><td class="text-danger font-weight-bold">₹ 35,000</td><td class="text-right"><span class="badge badge-info">Active</span></td></tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          
          <!-- Add Component Modal -->
          <div class="modal fade" id="addComponentModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content" style="border-radius: 12px; border: none;">
                <div class="modal-header border-bottom-0"><h5 class="modal-title font-weight-bold">Add Component</h5><button type="button" class="close" data-dismiss="modal"><span>&times;</span></button></div>
                <div class="modal-body">
                  <div class="form-group"><label>Component Name</label><input type="text" class="form-control"></div>
                  <div class="form-group"><label>Type</label><select class="form-control"><option>Earning</option><option>Deduction</option></select></div>
                  <div class="form-group"><label>Calculation Value</label><input type="text" class="form-control" placeholder="e.g., 50% CTC"></div>
                </div>
                <div class="modal-footer border-top-0"><button class="btn btn-light" data-dismiss="modal">Cancel</button><button class="btn btn-primary">Save</button></div>
              </div>
            </div>
          </div>

          <!-- Hike Modal -->
          <div class="modal fade" id="hikeModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content" style="border-radius: 12px; border: none;">
                <div class="modal-header border-bottom-0"><h5 class="modal-title font-weight-bold">Process Increment</h5><button type="button" class="close" data-dismiss="modal"><span>&times;</span></button></div>
                <div class="modal-body">
                  <div class="form-group"><label>Employee</label><select class="form-control"><option>Jane Smith</option></select></div>
                  <div class="form-group"><label>Hike Percentage (%)</label><input type="number" class="form-control" placeholder="10"></div>
                  <div class="form-group"><label>Effective Month</label><input type="month" class="form-control"></div>
                </div>
                <div class="modal-footer border-top-0"><button class="btn btn-light" data-dismiss="modal">Cancel</button><button class="btn btn-primary">Submit for Approval</button></div>
              </div>
            </div>
          </div>

          <!-- Loan Modal -->
          <div class="modal fade" id="loanModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content" style="border-radius: 12px; border: none;">
                <div class="modal-header border-bottom-0"><h5 class="modal-title font-weight-bold">Grant Loan/Advance</h5><button type="button" class="close" data-dismiss="modal"><span>&times;</span></button></div>
                <div class="modal-body">
                  <div class="form-group"><label>Employee</label><select class="form-control"><option>Mark Lee</option></select></div>
                  <div class="form-group"><label>Principal Amount (₹)</label><input type="number" class="form-control" placeholder="50000"></div>
                  <div class="form-group"><label>EMI Deductions per Month (₹)</label><input type="number" class="form-control" placeholder="5000"></div>
                </div>
                <div class="modal-footer border-top-0"><button class="btn btn-light" data-dismiss="modal">Cancel</button><button class="btn btn-primary">Grant</button></div>
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