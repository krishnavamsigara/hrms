<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Bloom Solutions | Rejected Leaves</title>

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">

<style>

:root{
--bloom-purple:#4a00e0;
--soft-gray:#f8fafc;
--border-color:#e2e8f0;
--bloom-danger:#ef4444;
}

body{
font-family:'Plus Jakarta Sans',sans-serif;
background:var(--soft-gray);
font-size:13px;
}

.card-bloom{
border:1px solid var(--border-color);
border-radius:18px;
background:#fff;
}

.avatar{
width:36px;
height:36px;
border-radius:10px;
}

.badge-reject{
background:#fee2e2;
color:#b91c1c;
padding:4px 10px;
border-radius:8px;
font-weight:600;
}

.action-btn{
width:30px;
height:30px;
display:inline-flex;
align-items:center;
justify-content:center;
border-radius:8px;
border:1px solid var(--border-color);
background:#fff;
cursor:pointer;
}

.employee-row:hover{
background:#f8fafc
}

</style>
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed">

<div class="wrapper">

<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light shadow-sm">

<ul class="navbar-nav">
<li class="nav-item">
<a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
</li>

<li class="nav-item ml-2">
<h5 class="mb-0 font-weight-bold">
Rejected Leaves
</h5>
</li>

</ul>

</nav>


<!-- Sidebar -->
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
                  <a href="attendance_dashboard.html" class="nav-link">
                    <i class="nav-icon far fa-clock"></i>
                    <p>Attendance</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="leave_overview.html" class="nav-link active">
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

<section class="content p-4">

<div class="d-flex justify-content-between mb-4">

<div>
<h4 class="font-weight-bold">
Rejected Leave Requests
</h4>
<small class="text-muted">
Leaves that were declined by HR
</small>
</div>

</div>



<div class="card-bloom">

<div class="table-responsive">

<table class="table table-hover mb-0">

<thead class="bg-light text-uppercase small text-muted">

<tr>
<th class="pl-4">Employee</th>
<th>Department</th>
<th>Leave Type</th>
<th>Dates</th>
<th>Status</th>
<th class="text-right pr-4">Action</th>
</tr>

</thead>



<tbody>


<tr class="employee-row">

<td class="pl-4">
<div class="d-flex align-items-center">

<img src="https://ui-avatars.com/api/?name=Aniket&background=ef4444&color=fff" class="avatar mr-2">

<div>
<strong>Aniket Mishra</strong><br>
<small class="text-muted">Sales Executive</small>
</div>

</div>
</td>

<td>Sales</td>
<td>Casual Leave</td>
<td>18 Jun</td>

<td>
<span class="badge-reject">
<i class="fas fa-times-circle"></i> Rejected
</span>
</td>

<td class="text-right pr-4">

<button class="action-btn" title="View Reason">
<i class="fas fa-eye text-primary"></i>
</button>

</td>

</tr>



<tr class="employee-row">

<td class="pl-4">
<div class="d-flex align-items-center">

<img src="https://ui-avatars.com/api/?name=Ravi&background=ec4899&color=fff" class="avatar mr-2">

<div>
<strong>Ravi Kumar</strong><br>
<small class="text-muted">Marketing Lead</small>
</div>

</div>
</td>

<td>Marketing</td>
<td>Sick Leave</td>
<td>12 Jun - 14 Jun</td>

<td>
<span class="badge-reject">
<i class="fas fa-times-circle"></i> Rejected
</span>
</td>

<td class="text-right pr-4">

<button class="action-btn" title="View Reason">
<i class="fas fa-eye text-primary"></i>
</button>

</td>

</tr>



<tr class="employee-row">

<td class="pl-4">
<div class="d-flex align-items-center">

<img src="https://ui-avatars.com/api/?name=Priya&background=f59e0b&color=fff" class="avatar mr-2">

<div>
<strong>Priya Singh</strong><br>
<small class="text-muted">HR Executive</small>
</div>

</div>
</td>

<td>HR</td>
<td>Emergency Leave</td>
<td>05 Jun</td>

<td>
<span class="badge-reject">
<i class="fas fa-times-circle"></i> Rejected
</span>
</td>

<td class="text-right pr-4">

<button class="action-btn" title="View Reason">
<i class="fas fa-eye text-primary"></i>
</button>

</td>

</tr>



</tbody>

</table>

</div>

</div>

</section>

</div>

</div>

</body>
</html>
