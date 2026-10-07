<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bloom Solutions | Add Department</title>
  
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">

<style>

:root{
--bloom-purple:#4a00e0;
--bloom-dark:#120038;
--soft-gray:#f8fafc;
--border-color:#e2e8f0;
--glass:rgba(255,255,255,0.75);
}

body{
font-family:'Plus Jakarta Sans',sans-serif;
background:var(--soft-gray);
font-size:13px;
color:#334155;
}

.main-header{
border-bottom:1px solid #e2e8f0!important;
background:var(--glass)!important;
backdrop-filter:blur(12px);
}

.main-sidebar{
background:#111c43!important;
}

.content-wrapper{
background:var(--soft-gray)!important;
padding:25px;
min-height:calc(100vh - 114px);
}

.card-bloom{
border:1px solid var(--border-color)!important;
border-radius:24px!important;
background:#fff;
box-shadow:0 10px 25px -5px rgba(0,0,0,0.05);
padding:35px;
}

.form-group label{
font-weight:700;
color:#64748b;
font-size:11px;
text-transform:uppercase;
margin-bottom:8px;
letter-spacing:0.5px;
}

.form-control{
border-radius:12px;
border:1px solid #e2e8f0;
padding:12px 15px;
height:auto;
background:#fbfcfd;
font-size:13px;
}

.form-control:focus{
border-color:var(--bloom-purple);
box-shadow:0 0 0 4px rgba(74,0,224,0.05);
background:#fff;
}

.icon-box{
width:48px;
height:48px;
border-radius:14px;
border:1px solid #e2e8f0;
display:flex;
align-items:center;
justify-content:center;
cursor:pointer;
transition:.3s;
color:#94a3b8;
font-size:18px;
background:#fff;
}

.icon-box:hover{
border-color:var(--bloom-purple);
color:var(--bloom-purple);
background:#f5f3ff;
}

.icon-box.active{
border-color:var(--bloom-purple);
background:var(--bloom-purple);
color:#fff;
box-shadow:0 8px 15px rgba(74,0,224,0.2);
}

.btn-save{
background:var(--bloom-purple);
color:#fff;
border-radius:12px;
padding:12px 40px;
font-weight:700;
border:none;
}

.btn-save:hover{
background:var(--bloom-dark);
color:#fff;
}

.btn-cancel{
background:#f1f5f9;
color:#64748b;
border-radius:12px;
padding:12px 25px;
font-weight:700;
border:none;
}

.zone-select-wrapper{
background:#f8fafc;
border:1px solid var(--border-color);
border-radius:18px;
padding:20px;
margin-top:10px;
}

.nav-pills .nav-link.active{
background:#007bff!important;
color:#fff!important;
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
              <a href="deparment.html" class="nav-link active">
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
    <section class="content">
      <div class="container" style="max-width: 750px;"> 
        <div class="card-bloom">
          <form id="addDeptForm">
            <div class="row">
              <div class="col-md-7 form-group">
                <label>Department Name</label>
                <input type="text" class="form-control" placeholder="e.g. Operations & Logistics" required>
              </div>
              <div class="col-md-5 form-group">
                <label>Operational Zone</label>
                <select class="form-control" required>
                  <option selected disabled>Select Zone...</option>
                  <option>North Zone</option>
                  <option>South Zone</option>
                  <option>East Zone</option>
                  <option>West Zone</option>
                  <option>Global HQ</option>
                  <option>Digital / Remote</option>
                </select>
              </div>
            </div>

            <div class="form-group mt-3">
              <label>Department Identity (Visual Icon)</label>
              <div class="d-flex flex-wrap" style="gap: 15px;">
                <div class="icon-box active" data-icon="map-marker-alt"><i class="fas fa-map-marker-alt"></i></div>
                <div class="icon-box" data-icon="warehouse"><i class="fas fa-warehouse"></i></div>
                <div class="icon-box" data-icon="laptop-house"><i class="fas fa-laptop-house"></i></div>
                <div class="icon-box" data-icon="globe"><i class="fas fa-globe"></i></div>
                <div class="icon-box" data-icon="truck"><i class="fas fa-truck"></i></div>
                <div class="icon-box" data-icon="building"><i class="fas fa-building"></i></div>
                <div class="icon-box" data-icon="headset"><i class="fas fa-headset"></i></div>
              </div>
            </div>

            <div class="zone-select-wrapper mt-4">
                <div class="form-group mb-0">
                    <label>Department Supervisor</label>
                    <select class="form-control">
                        <option selected disabled>Assign Head for this Department...</option>
                        <option>Aishwarya (Super Admin)</option>
                        <option>Rahul Sharma (North Lead)</option>
                        <option>Sneha Kapoor (South Lead)</option>
                    </select>
                    <div class="mt-3 p-2 rounded" style="background: #fff; border: 1px dashed #cbd5e1;">
                         <small class="text-muted"><i class="fas fa-shield-alt mr-1 text-primary"></i> <b>Authority Note:</b> The assigned supervisor will have full approval rights for leaves and expenses within this department zone.</small>
                    </div>
                </div>
            </div>

            <div class="form-group mt-4">
              <label>Department Mission / Description</label>
              <textarea class="form-control" rows="3" placeholder="Describe the core functions and goals for this department..."></textarea>
            </div>

           <div class="mt-5 d-flex justify-content-end align-items-center" style="gap:15px;">
  <button type="button" class="btn btn-cancel" onclick="history.back()">Discard</button>
  <button type="submit" class="btn btn-save shadow-sm">Save Department Profile</button>
</div>
          </form>
        </div>
         <div class="mt-4">
        <a href="deparment.html" class="btn btn-sm text-muted"><i class="fas fa-arrow-left mr-1"></i> Back to Departments</a>
    </div>

      </div>
    </section>
  </div>

  <footer class="main-footer fixed-bottom text-center py-3">
    <strong>Copyright &copy; 2026 <a href="#" class="footer-link">Bloom Solutions</a></strong>
  </footer>

</div>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

<script>
  // Icon Toggle
  $('.icon-box').on('click', function() {
    $('.icon-box').removeClass('active');
    $(this).addClass('active');
  });

  // Submit Handler
  $('#addDeptForm').on('submit', function(e) {
    e.preventDefault();
    alert('Department Profile Saved to Zone Successfully!');
  });
</script>

</body>
</html>
