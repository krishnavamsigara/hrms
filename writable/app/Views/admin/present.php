<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>BloomHR | Present Employees</title>

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">

<style>

:root{
--bloom-purple:#4a00e0;
--soft-gray:#f8fafc;
--bloom-success:#10b981;
}

body{
font-family:'Plus Jakarta Sans',sans-serif;
background:var(--soft-gray);
font-size:13px;
}

/* Card Style */

.card-bloom{
border:1px solid #e2e8f0!important;
border-radius:16px!important;
background:#fff;
box-shadow:0 4px 10px rgba(0,0,0,0.05);
}

/* Present Badge */

.badge-present{
background:#ecfdf5;
color:#10b981;
padding:4px 10px;
border-radius:8px;
font-weight:600;
}

/* Avatar */

.avatar-list{
width:32px;
height:32px;
border-radius:8px;
margin-right:10px;
}

.main-header{
border-bottom:1px solid #e2e8f0!important;
}

</style>

</head>

<body class="hold-transition sidebar-mini layout-fixed">

<div class="wrapper">

<!-- Navbar -->

<nav class="main-header navbar navbar-expand navbar-white navbar-light shadow-sm">

<ul class="navbar-nav">
<li class="nav-item">
<a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
</li>

<li class="nav-item ml-2">
<h5 class="mb-0 font-weight-bold">
Present Employees - Mar 13, 2026
</h5>
</li>
</ul>

</nav>


<!-- Sidebar -->

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


<!-- Content -->

<div class="content-wrapper">

<section class="content pt-4">

<div class="container-fluid">


<div class="card card-bloom">

<div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">

<h6 class="font-weight-bold mb-0">
Present Employees List
</h6>

<input type="text" class="form-control form-control-sm w-25 rounded-pill" placeholder="Search employee">

</div>


<div class="table-responsive">

<table class="table table-hover mb-0">

<thead class="bg-light">

<tr class="small text-muted text-uppercase">

<th class="pl-4">Employee</th>
<th>Check-In</th>
<th>Check-Out</th>
<th>Status</th>

</tr>

</thead>

<tbody>

<tr>

<td class="pl-4">

<div class="d-flex align-items-center">

<img src="https://ui-avatars.com/api/?name=Ishu+A&background=4a00e0&color=fff" class="avatar-list">

<strong>Ishu Aishwarya</strong>

</div>

</td>

<td>09:15 AM</td>

<td>--:--</td>

<td>
<span class="badge-present">
Present
</span>
</td>

</tr>


<tr>

<td class="pl-4">

<div class="d-flex align-items-center">

<img src="https://ui-avatars.com/api/?name=Rahul+S&background=10b981&color=fff" class="avatar-list">

<strong>Rahul Sharma</strong>

</div>

</td>

<td>09:05 AM</td>

<td>--:--</td>

<td>
<span class="badge-present">
Present
</span>
</td>

</tr>


<tr>

<td class="pl-4">

<div class="d-flex align-items-center">

<img src="https://ui-avatars.com/api/?name=Anita+K&background=6366f1&color=fff" class="avatar-list">

<strong>Anita Kumar</strong>

</div>

</td>

<td>09:22 AM</td>

<td>--:--</td>

<td>
<span class="badge-present">
Present
</span>
</td>

</tr>

</tbody>

</table>

</div>

</div>

</div>

</section>

</div>


<!-- Footer -->

<footer class="main-footer">

<strong>Copyright &copy; 2026
<a href="#" class="text-primary">Bloom Solutions</a>
</strong>

<span class="float-right d-none d-sm-inline-block">
Version 2.0
</span>

</footer>

</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

</body>
</html>
