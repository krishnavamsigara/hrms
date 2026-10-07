```html
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Bloom Solutions | Leave History</title>

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">

<style>

:root{
--bloom-purple:#4a00e0;
--bloom-orange:#e46c44;
--bloom-success:#10b981;
--bloom-danger:#dc2626;
--soft-gray:#f8fafc;
--border-color:#e2e8f0;
}

body{
font-family:'Plus Jakarta Sans',sans-serif;
background:var(--soft-gray);
font-size:13px;
color:#334155;
}

/* Cards */

.card-bloom{
border:1px solid var(--border-color);
border-radius:20px;
background:#fff;
box-shadow:0 4px 6px rgba(0,0,0,0.04);
}

/* Table */

.leave-table th{
background:#f1f5f9;
font-weight:600;
}

.leave-table td{
vertical-align:middle;
}

/* Leave Type Badges */

.badge{
padding:6px 10px;
font-size:12px;
border-radius:8px;
font-weight:600;
}

.badge-casual{
background:#eef2ff;
color:#4338ca;
}

.badge-sick{
background:#fff1f2;
color:#be123c;
}

.badge-wfh{
background:#ecfeff;
color:#0891b2;
}

.badge-vacation{
background:#fef9c3;
color:#a16207;
}

/* Status */

.badge-approved{
background:#e8fbf3;
color:#059669;
border:1px solid #baf3d8;
}

.badge-rejected{
background:#fee2e2;
color:#b91c1c;
border:1px solid #fecaca;
}

.badge-pending{
background:#fff7ed;
color:#c2410c;
border:1px solid #fed7aa;
}

/* Action Buttons */

.leave-actions{
display:flex;
gap:6px;
}

.leave-actions .btn{
border-radius:8px;
padding:6px 10px;
font-size:12px;
border:1px solid var(--border-color);
background:#fff;
}

.btn-view{color:#4a00e0;}
.btn-approve{color:#059669;}
.btn-reject{color:#dc2626;}

.leave-actions .btn:hover{
background:#f8fafc;
}

/* Footer */

.main-footer{
background:#fff;
border-top:1px solid #e2e8f0;
color:#64748b;
padding:1rem 1.5rem;
}

</style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">

<div class="wrapper">

<!-- Navbar -->

<nav class="main-header navbar navbar-expand navbar-white navbar-light shadow-sm">

<ul class="navbar-nav align-items-center">

<li class="nav-item">
<a class="nav-link" data-widget="pushmenu"><i class="fas fa-bars"></i></a>
</li>

<li class="nav-item ml-2">
<h5 class="mb-0 font-weight-bold">
Hello, <span style="color:#4a00e0;">Ishu</span> 👋
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



<!-- Page Content -->

<div class="content-wrapper">

<section class="content pt-3">

<div class="container-fluid">

<div class="row">

<div class="col-12">

<div class="card card-bloom">

<div class="card-header">
<h3 class="card-title font-weight-bold">Employee Leave History</h3>
</div>


<div class="card-body table-responsive p-0">

<table class="table table-hover leave-table">

<thead>

<tr>
<th>Employee</th>
<th>Department</th>
<th>Leave Type</th>
<th>Dates</th>
<th>Status</th>
<th>Action</th>
</tr>

</thead>

<tbody>

<tr>
<td>Rahul Kumar</td>
<td>IT</td>
<td><span class="badge badge-casual">Casual Leave</span></td>
<td>12 Apr - 13 Apr</td>
<td><span class="badge badge-approved">Approved</span></td>

<td>
<div class="leave-actions">
<button class="btn btn-view"><i class="fas fa-eye"></i></button>
<button class="btn btn-approve"><i class="fas fa-check"></i></button>
<button class="btn btn-reject"><i class="fas fa-times"></i></button>
</div>
</td>

</tr>


<tr>
<td>Sravani</td>
<td>HR</td>
<td><span class="badge badge-sick">Sick Leave</span></td>
<td>15 Apr</td>
<td><span class="badge badge-approved">Approved</span></td>

<td>
<div class="leave-actions">
<button class="btn btn-view"><i class="fas fa-eye"></i></button>
<button class="btn btn-approve"><i class="fas fa-check"></i></button>
<button class="btn btn-reject"><i class="fas fa-times"></i></button>
</div>
</td>

</tr>


<tr>
<td>Mahesh</td>
<td>Development</td>
<td><span class="badge badge-wfh">WFH</span></td>
<td>16 Apr</td>
<td><span class="badge badge-pending">Pending</span></td>

<td>
<div class="leave-actions">
<button class="btn btn-view"><i class="fas fa-eye"></i></button>
<button class="btn btn-approve"><i class="fas fa-check"></i></button>
<button class="btn btn-reject"><i class="fas fa-times"></i></button>
</div>
</td>

</tr>


<tr>
<td>Ravi Kumar</td>
<td>Finance</td>
<td><span class="badge badge-vacation">Vacation</span></td>
<td>18 Apr - 20 Apr</td>
<td><span class="badge badge-rejected">Rejected</span></td>

<td>
<div class="leave-actions">
<button class="btn btn-view"><i class="fas fa-eye"></i></button>
<button class="btn btn-approve"><i class="fas fa-check"></i></button>
<button class="btn btn-reject"><i class="fas fa-times"></i></button>
</div>
</td>

</tr>

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

<strong>Copyright © 2026
<a href="#">Bloom Solutions</a>
</strong>

</footer>

</div>


<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

</body>
</html>
```

