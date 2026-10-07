<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bloom Solutions | Leave Management</title>

  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">

  <style>
    :root {
      --bloom-purple: #4a00e0;
      --bloom-orange: #e46c44;
      --mtn-navy: #120038;
      --table-hover: #f8fafc;
    }

    body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f4f7fe; }

    k { border-radius: 12px !important; margin: 2px 10px !important; }
    .nav-link.active { background-color: var(--bloom-purple) !important; box-shadow: 0 4px 12px rgba(74, 0, 224, 0.3); }
       .main-footer { background: #fff !important; border-top: 1px solid #e2e8f0 !important; padding: 1rem 1.5rem !important; color: #64748b !important; }
        .footer-link { color: var(--bloom-purple); font-weight: 700; }
        .footer-dot { height: 4px; width: 4px; background-color: #cbd5e1; border-radius: 50%; display: inline-block; margin: 0 8px; vertical-align: middle; }

.logo-circle{
width:42px;
height:42px;
border-radius:50%;
object-fit:cover;
border:2px solid #fff;
margin-right:10px;
}

/* Text */
.brand-text{
font-size:18px;
font-weight:700;
}

/* Colors matching logo */
.brand-blue{
color:#4a8cff;
}

.brand-orange{
color:#ff7a45;
}

    /* --- HEADER / NAVBAR --- */
    .main-header { border-bottom: 1px solid #eef2f6 !important; }

    /* --- TABLE & CARDS (HRMS STYLE) --- */
    .content-wrapper { background-color: #f4f7fe; padding: 20px; }
    
    .filter-bar {
      background: #fff;
      padding: 15px 25px;
      border-radius: 12px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
      box-shadow: 0 2px 4px rgba(0,0,0,0.02);
    }

    .custom-select-sm, .form-control-sm {
      border: 1px solid #e2e8f0;
      border-radius: 8px;
      height: 38px;
      padding: 0 12px;
      color: #64748b;
    }

    .card-hrms {
      background: #fff;
      border-radius: 12px;
      border: none;
      box-shadow: 0 4px 20px rgba(0,0,0,0.03);
      overflow: hidden;
    }

    .table thead th {
      background: #f1f5f9;
      color: #1e293b;
      font-weight: 600;
      font-size: 13px;
      border: none !important;
      padding: 15px;
    }

    .table td {
      vertical-align: middle !important;
      border-top: 1px solid #f1f5f9 !important;
      padding: 12px 15px !important;
      font-size: 14px;
    }

    .table tbody tr:hover { background-color: var(--table-hover); }

    .emp-avatar { width: 35px; height: 35px; border-radius: 50%; object-fit: cover; margin-right: 12px; }
    .emp-name { font-weight: 600; color: #1e293b; display: block; line-height: 1.2; }
    .emp-role { font-size: 12px; color: #64748b; }

    .btn-generate {
      background: #1e293b;
      color: #fff;
      border-radius: 8px;
      font-size: 12px;
      font-weight: 500;
      padding: 8px 16px;
      border: none;
      transition: 0.2s;
    }
    .btn-generate:hover { background: #0f172a; color: #fff; }

    .badge-designation {
      background: transparent;
      border: 1px solid #e2e8f0;
      padding: 6px 12px;
      border-radius: 8px;
      font-size: 13px;
      color: #475569;
      display: inline-flex;
      align-items: center;
      gap: 8px;
    }

  </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
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
          <a href="../empolyee/dashboard.html" class="btn btn-sm" style="background-color: #eef2ff; color: var(--bloom-purple); font-weight: 600; border-radius: 8px; border: 1px solid #c7d2fe;">
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
             class="rounded-circle shadow-sm"
             style="width: 32px; border: 2px solid #fff;">
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
              <a href="dashboard.html" class="nav-link">
                <i class="nav-icon fas fa-home"></i>
                <p>Dashboard</p>
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
    <div class="container-fluid">
      
      <div class="d-flex justify-content-between align-items-center mb-4 pt-2">
        <h5 class="font-weight-bold m-0">Employee Salary List</h5>
        <div class="d-flex gap-2">
          <input type="text" class="form-control-sm mr-2" value="11/03/2026 - 11/03/2026" style="width: 210px;">
          <select class="custom-select-sm mr-2"><option>Designation</option></select>
          <select class="custom-select-sm"><option>Sort By : Last 7 Days</option></select>
        </div>
      </div>

      <div class="filter-bar">
        <div class="d-flex align-items-center">
          <span class="mr-2 text-muted small">Row Per Page</span>
          <select class="custom-select-sm" style="width: 70px;"><option>10</option></select>
          <span class="ml-2 text-muted small">Entries</span>
        </div>
        <div class="d-flex align-items-center">
          <input type="text" class="form-control-sm" placeholder="Search..." style="width: 250px;">
        </div>
      </div>

      <div class="card card-hrms">
        <div class="table-responsive">
          <table class="table mb-0">
            <thead>
              <tr>
                <th width="40"><input type="checkbox" class="custom-check"></th>
                <th>Emp ID <i class="fas fa-sort ml-1 opacity-50"></i></th>
                <th>Name <i class="fas fa-sort ml-1 opacity-50"></i></th>
                <th>Email <i class="fas fa-sort ml-1 opacity-50"></i></th>
                <th>Phone <i class="fas fa-sort ml-1 opacity-50"></i></th>
                <th>Designation <i class="fas fa-sort ml-1 opacity-50"></i></th>
                <th>Joining Date <i class="fas fa-sort ml-1 opacity-50"></i></th>
                <th>Salary</th>
                <th>Payslip <i class="fas fa-sort ml-1 opacity-50"></i></th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><input type="checkbox" class="custom-check"></td>
                <td class="text-muted">Emp-002</td>
                <td>
                  <div class="d-flex align-items-center">
                    <img src="https://ui-avatars.com/api/?name=Brian+V&background=0ea5e9&color=fff" class="emp-avatar">
                    <div>
                      <span class="emp-name">Brian Villalobos</span>
                      <span class="emp-role">Developer</span>
                    </div>
                  </div>
                </td>
                <td class="text-muted">brian@example.com</td>
                <td class="text-muted">(179) 7382 829</td>
                <td><div class="badge-designation">Developer <i class="fas fa-chevron-down small opacity-50 ml-1"></i></div></td>
                <td class="text-muted">24 Oct 2024</td>
                <td class="font-weight-bold">$35000</td>
                <td><button class="btn btn-generate">Generate Slip</button></td>
              </tr>
              <tr>
                <td><input type="checkbox" class="custom-check"></td>
                <td class="text-muted">Emp-003</td>
                <td>
                  <div class="d-flex align-items-center">
                    <img src="https://ui-avatars.com/api/?name=Harvey+S&background=f59e0b&color=fff" class="emp-avatar">
                    <div>
                      <span class="emp-name">Harvey Smith</span>
                      <span class="emp-role">Developer</span>
                    </div>
                  </div>
                </td>
                <td class="text-muted">harvey@example.com</td>
                <td class="text-muted">(184) 2719 738</td>
                <td><div class="badge-designation">Executive <i class="fas fa-chevron-down small opacity-50 ml-1"></i></div></td>
                <td class="text-muted">18 Feb 2024</td>
                <td class="font-weight-bold">$20000</td>
                <td><button class="btn btn-generate">Generate Slip</button></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <footer class="main-footer">
    <strong>Copyright &copy; 2026 <a href="#" class="footer-link">Bloom Solutions</a></strong>
    <span class="footer-dot"></span>
    <span class="text-muted">All rights reserved.</span>
    <div class="float-right d-none d-sm-inline-block text-muted small">
      v2.4.0 <span class="footer-dot"></span> Optimized for Productivity
    </div>
  </footer>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
</body>
</html>
