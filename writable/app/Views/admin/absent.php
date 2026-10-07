<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bloom Solutions | Absent List</title>

  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700&display=swap"
    rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">

  <style>
    .nav-pills .nav-link.active {
      background: #007bff !important;
      color: #fff !important;
    }

    :root {
      --bloom-purple: #4a00e0;
      --bloom-dark: #120038;
      --bloom-orange: #e46c44;
      --bloom-success: #10b981;
      --bloom-danger: #dc2626;
      --soft-gray: #f8fafc;
      --border-color: #e2e8f0;
      --glass: rgba(255, 255, 255, 0.75);
    }

    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      background-color: var(--soft-gray);
      font-size: 13px;
      color: #334155;
    }

    /* Cards */

    .card-bloom {
      border: 1px solid var(--border-color) !important;
      border-radius: 20px !important;
      background: #fff;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05) !important;
      margin-bottom: 20px;
      overflow: hidden;
    }

    /* Navigation */

    .main-header {
      border-bottom: 1px solid #e2e8f0 !important;
      background: var(--glass) !important;
      backdrop-filter: blur(12px);
    }

    .content-wrapper {
      padding-top: 100px;
      padding-bottom: 80px;
      background-color: var(--soft-gray) !important;
    }

    /* Sidebar */

    .main-sidebar {
      background: var(--bloom-dark) !important;
    }

    /* Footer */

    .main-footer {
      background: #fff !important;
      border-top: 1px solid #e2e8f0 !important;
      color: #64748b;
      font-size: 12px;
      padding: 1rem 1.5rem !important;
    }

    /* Badges */

    .badge-sick {
      background: #fee2e2;
      color: #dc2626;
      border-radius: 8px;
      padding: 4px 12px;
      font-weight: 600;
      font-size: 11px;
    }

    .badge-uninformed {
      background: #fff1f2;
      color: #be123c;
      border-radius: 8px;
      padding: 4px 12px;
      font-weight: 600;
      font-size: 11px;
    }

    .badge-wfh {
      background: #e0f2fe;
      color: #0369a1;
      border-radius: 8px;
      padding: 4px 12px;
      font-weight: 600;
      font-size: 11px;
    }

    /* Buttons */

    .btn-action {
      width: 32px;
      height: 32px;
      border-radius: 10px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      border: 1px solid var(--border-color);
      background: #fff;
      color: #64748b;
      transition: 0.2s;
    }

    .btn-action:hover {
      background: var(--bloom-purple);
      color: #fff !important;
      transform: translateY(-2px);
    }
  </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">

  <div class="wrapper">

    <!-- NAVBAR -->

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

            <li class="nav-item menu-open">
              <a href="#" class="nav-link active">
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
                  <a href="attendance_dashboard.html" class="nav-link active">
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
    <!-- CONTENT -->

    <div class="content-wrapper p-4">

      <section class="content">

        <div class="container-fluid px-lg-4">

          <div class="d-flex justify-content-between align-items-center mb-4">

            <div>

              <h4 class="font-weight-bold text-dark mb-0">Absentee Report</h4>

              <p class="text-muted small mb-0">
                Today • 26 March 2026
                <span class="ml-2 badge badge-light text-danger font-weight-bold px-3 py-1">
                  51 Absentees
                </span>
              </p>

            </div>

            <div>

              <button class="btn btn-sm btn-light border rounded-pill px-3 shadow-sm">
                <i class="fas fa-download mr-2"></i>Export PDF
              </button>


            </div>

          </div>

          <!-- TABLE -->

          <div class="card-bloom">

            <div class="table-responsive">

              <table class="table table-hover mb-0">

                <thead style="background:#fbfcfd">

                  <tr class="small text-muted text-uppercase">

                    <th class="pl-4 border-0 py-3">Employee</th>
                    <th class="border-0 py-3">Zone / Department</th>
                    <th class="border-0 py-3">Status Reason</th>
                    <th class="text-right pr-4 border-0 py-3">Actions</th>

                  </tr>

                </thead>

                <tbody>

                  <tr>

                    <td class="pl-4 py-3">

                      <div class="d-flex align-items-center">

                        <img src="https://ui-avatars.com/api/?name=Rahul+Sharma&background=4a00e0&color=fff"
                          class="rounded-circle mr-3" style="width:38px;height:38px">

                        <div>

                          <strong>Rahul Sharma</strong>
                          <br>
                          <small class="text-muted">Marketing Lead</small>

                        </div>

                      </div>

                    </td>

                    <td>

                      <strong>North Zone</strong>
                      <br>
                      <small class="text-muted">Marketing</small>

                    </td>

                    <td>
                      <span class="badge-sick">Sick Leave (Approved)</span>
                    </td>

                    <td class="text-right pr-4">

                      <a href="#" class="btn-action"><i class="fas fa-comment-dots"></i></a>
                      <a href="#" class="btn-action ml-1"><i class="fas fa-user"></i></a>

                    </td>

                  </tr>

                  <tr>

                    <td class="pl-4 py-3">

                      <div class="d-flex align-items-center">

                        <img src="https://ui-avatars.com/api/?name=Vikram+Reddy&background=e46c44&color=fff"
                          class="rounded-circle mr-3" style="width:38px;height:38px">

                        <div>

                          <strong>Vikram Reddy</strong>
                          <br>
                          <small class="text-muted">Backend Engineer</small>

                        </div>

                      </div>

                    </td>

                    <td>

                      <strong>South Zone</strong>
                      <br>
                      <small class="text-muted">Development</small>

                    </td>

                    <td>
                      <span class="badge-uninformed">Uninformed / No Show</span>
                    </td>

                    <td class="text-right pr-4">

                      <a href="#" class="btn-action"><i class="fas fa-phone"></i></a>
                      <a href="#" class="btn-action ml-1"><i class="fas fa-check"></i></a>

                    </td>

                  </tr>

                  <tr>

                    <td class="pl-4 py-3">

                      <div class="d-flex align-items-center">

                        <img src="https://ui-avatars.com/api/?name=Anitha+Rao&background=10b981&color=fff"
                          class="rounded-circle mr-3" style="width:38px;height:38px">

                        <div>

                          <strong>Anitha Rao</strong>
                          <br>
                          <small class="text-muted">UI Designer</small>

                        </div>

                      </div>

                    </td>

                    <td>

                      <strong>West Zone</strong>
                      <br>
                      <small class="text-muted">Design</small>

                    </td>

                    <td>
                      <span class="badge-sick">Sick Leave</span>
                    </td>

                    <td class="text-right pr-4">

                      <a href="#" class="btn-action"><i class="fas fa-comment-dots"></i></a>
                      <a href="#" class="btn-action ml-1"><i class="fas fa-user"></i></a>

                    </td>

                  </tr>

                </tbody>

              </table>

            </div>

          </div>

        </div>

      </section>

    </div>

    <footer class="main-footer fixed-bottom">

      <div class="float-right d-none d-sm-block">
        <b>Bloom</b> v2.0
      </div>

      <strong>
        Copyright © 2026
        <a href="#">Bloom Solutions</a>.
      </strong>

    </footer>

  </div>

  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

</body>

</html>