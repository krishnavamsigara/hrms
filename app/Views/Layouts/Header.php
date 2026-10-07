<?php
$active_role = session()->get('current_user_cat');
?>

<?php if($active_role == 'ADMIN') { ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- <title>Bloom Solutions | Admin Dashboard</title> -->
  <link rel="icon" type="image/jpeg" href="<?= base_url('public/dist/img/bloom.jpg') ?>">

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

    <nav class="main-header navbar navbar-expand navbar-white navbar-light shadow-sm">

      <ul class="navbar-nav align-items-center">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
        </li>

        <li class="nav-item ml-2 hello-user">
          <h5 class="mb-0 font-weight-bold" style="color: var(--mtn-deep);">
            Hello, <span style="color: var(--bloom-purple);"><?= session()->get('emp_name'); ?></span> 👋
          </h5>
        </li>
      </ul>

      <ul class="navbar-nav ml-auto align-items-center">

        <!-- Role Switcher -->
<?php
$original_role = session()->get('user_category');
$active_role   = session()->get('current_user_cat');
?>

<?php if ($original_role == 'HR' && $active_role == 'HR') { ?>

<li class="nav-item mr-3 d-none d-sm-inline-block">
    <a href="<?= base_url('switchrole/ADMIN') ?>"
       class="btn btn-sm"
       style="background-color:#eef2ff;color:#4a00e0;font-weight:600;border-radius:8px;border:1px solid #c7d2fe;">
        <i class="fas fa-exchange-alt mr-1"></i>
        Switch to Admin
    </a>
</li>

<?php } elseif ($original_role == 'HR' && $active_role == 'ADMIN') { ?>

<li class="nav-item mr-3 d-none d-sm-inline-block">
    <a href="<?= base_url('switchrole/HR') ?>"
       class="btn btn-sm"
       style="background-color:#eef2ff;color:#4a00e0;font-weight:600;border-radius:8px;border:1px solid #c7d2fe;">
        <i class="fas fa-exchange-alt mr-1"></i>
        Switch to Employee
    </a>
</li>

<?php } ?>
        <!-- Messages -->
        <!-- <li class="nav-item dropdown">
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
        </li> -->

        <!-- System Notifications Dropdown -->
        <li class="nav-item dropdown mr-2">
          <a class="nav-link position-relative" data-toggle="dropdown" href="#" style="font-size: 1.1rem; color: #475569;">
            <i class="far fa-bell"></i>
            <span class="badge badge-danger navbar-badge notif-count-badge" style="display:none; font-size:10px; font-weight:700; background-color:#dc2626 !important; color:#ffffff !important; border-radius:10px; padding: 2px 6px; position:absolute; top:2px; right:1px; box-shadow: 0 2px 5px rgba(220, 38, 38, 0.5);">0</span>
          </a>

          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right shadow-lg border-0" style="width: 320px; border-radius: 16px;">
            <div class="dropdown-header font-weight-bold text-dark d-flex justify-content-between align-items-center py-2 px-3 border-bottom">
              <span><i class="fas fa-bell mr-1 text-primary"></i> Notifications</span>
              <small class="notif-count-text text-muted">0 Unread</small>
            </div>

            <div class="notifDropdownList" style="max-height: 280px; overflow-y: auto;">
              <div class="text-center text-muted p-3">Loading notifications...</div>
            </div>

            <div class="dropdown-divider m-0"></div>
            <a href="<?= base_url('employee/notifications') ?>" class="dropdown-item dropdown-footer text-center font-weight-bold text-primary py-2" style="background:#f8fafc; border-bottom-left-radius: 16px; border-bottom-right-radius: 16px;">
              View All Notifications <i class="fas fa-arrow-right ml-1"></i>
            </a>
          </div>
        </li>

        <!-- Profile -->
        <li class="nav-item dropdown">
          <a class="nav-link d-flex align-items-center" data-toggle="dropdown" href="#">

<?php
$empName = session()->get('emp_name');

$nameParts = explode(' ', $empName);

$initials = '';

if (count($nameParts) >= 2) {
    $initials = strtoupper(substr($nameParts[0], 0, 1) . substr($nameParts[1], 0, 1));
} else {
    $initials = strtoupper(substr($empName, 0, 2));
}
?>

<img src="https://ui-avatars.com/api/?name=<?= $initials; ?>&background=4a00e0&color=fff"
     class="rounded-circle shadow-sm"
     style="width: 32px; border: 2px solid #fff;">
 
<span class="ml-2 d-inline-block employee-header-info">
    <div class="font-weight-bold text-dark" style="line-height:1.2;">
        <?= session()->get('emp_name'); ?>
    </div>
 
    <div style="
        color:#4a00e0;
        font-size:11px;
        font-weight:600;
        line-height:1.2;">
        <?= session()->get('emp_id'); ?>
    </div>
</span>

</a>
          <div class="dropdown-menu dropdown-menu-right border-0 shadow-lg mt-2" style="border-radius:12px;">
           <a href="<?php echo base_url('profile'); ?>" class="dropdown-item">
              <i class="fas fa-user mr-2"></i> Profile
          </a>

            <div class="dropdown-divider"></div>

            <a href="<?= base_url('logout') ?>" class="dropdown-item text-danger">
              <i class="fas fa-power-off mr-2"></i> Logout
            </a>
          </div>
        </li>

      </ul>

    </nav>
           

<?php } elseif(in_array($active_role, ['EMP', 'HR', 'MANAGER' ,'INTERN'])) { ?>

  <!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- <title>BloomHR | Dashboard</title> -->
  <link rel="icon" type="image/jpeg" href="<?= base_url('public/dist/img/bloom.jpg') ?>">
  
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">

  <style>
    :root {
      --bloom-purple: #4a00e0;
      --bloom-dark: #2a0080;
      --mtn-deep: #120038;
      --bloom-orange: #e46c44;
      --bloom-success: #10b981;
      --bloom-danger: #dc2626;
      --glass: rgba(255, 255, 255, 0.95);
    }

    /* --- REDUCE FOOTER & ROW GAPS --- */
    /* .content-wrapper { */
      /* min-height: auto !important; */
      /* Prevents the body from stretching too long */
      /* padding-bottom: 0px !important; */
    /* } */

    .content {
      padding-bottom: 5px !important;
      /* The "slight" gap you requested */
    }

    .row:last-of-type,
    .row:last-of-type .col-lg-12,
    .row:last-of-type .card {
      margin-bottom: 0px !important;
      /* Removes the bottom margin of the last card/row */
    }

    .main-footer {
      margin-top: 0px !important;
      padding: 8px 1.5rem !important;
      /* Tightens the footer height itself */
    }

    .card-bloom {
      margin-bottom: 0px !important;
    }

    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      background-color: #f8fafc;
      font-size: 13px;
      color: #334155;
    }

    /* --- NAVIGATION & SIDEBAR --- */
    .main-header {
      border-bottom: 1px solid #e2e8f0 !important;
      background: var(--glass) !important;
      backdrop-filter: blur(10px);
    }

    .main-sidebar {
      background: var(--mtn-deep) !important;
      box-shadow: 4px 0 10px rgba(0, 0, 0, 0.03) !important;
    }

    /* --- CARDS --- */
    .card-bloom {
      transition: transform 0.2s ease;
      border: 1px solid #e2e8f0 !important;
      border-radius: 20px !important;
      background: #fff;
      box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05) !important;
    }

    .card-bloom:hover {
      transform: translateY(-2px);
    }

    /* --- STAT CARDS --- */
    .stat-card {
      background: #fff;
      padding: 1.25rem;
      border-radius: 10px;
      border: 1px solid #e2e8f0;
    }

    .stat-icon {
      width: 44px;
      height: 44px;
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 12px;
      font-size: 18px;
    }

    /* --- TIMELINE --- */
    .timeline-bar {
      height: 12px;
      border-radius: 50px;
      display: flex;
      overflow: hidden;
      background: #f1f5f9;
      margin: 20px 0 10px 0;
    }

    .t-productive {
      background: var(--bloom-success);
      border-right: 2px solid #fff;
    }

    .t-break {
      background: #f59e0b;
      border-right: 2px solid #fff;
    }

    .t-overtime {
      background: var(--bloom-purple);
    }

    /* --- TRACKERS (Refined Tones) --- */
    .bg-holiday {
      background: linear-gradient(135deg, #fffcf5 0%, #fff7ed 100%) !important;
      border: 1px solid #fed7aa !important;
    }

    .bg-birthday {
      background: linear-gradient(135deg, #fffafb 0%, #fff1f2 100%) !important;
      border: 1px solid #fecdd3 !important;
    }

    /* --- BUTTONS --- */
    .btn-bloom-grad {
      background: linear-gradient(135deg, var(--bloom-purple) 0%, var(--bloom-dark) 100%);
      color: #fff !important;
      border: none;
      border-radius: 12px;
      font-weight: 700;
      padding: 10px;
      font-size: 11px;
    }

    .btn-punch-in {
      background-color: var(--bloom-success);
      color: white;
      border-radius: 12px;
      font-weight: 700;
      border: none;
    }

    .btn-punch-out {
      background-color: var(--bloom-danger);
      color: white;
      border-radius: 12px;
      font-weight: 700;
      border: none;
    }


    /* --- FOOTER --- */
    .main-footer {
      background: #fff !important;
      border-top: 1px solid #e2e8f0 !important;
      color: #64748b;
      font-size: 12px;
      padding: 1rem 1.5rem !important;
    }

    .footer-dot {
      display: inline-block;
      width: 4px;
      height: 4px;
      background: #cbd5e1;
      border-radius: 50%;
      margin: 0 8px;
      vertical-align: middle;
    }

    .footer-link {
      color: var(--bloom-purple);
      font-weight: 600;
      text-decoration: none;
    }

    /* Sidebar brand header */
    .custom-brand {
      display: flex;
      align-items: center;
      padding: 12px 16px;
      border-bottom: 1px solid rgba(255, 255, 255, 0.08);
    }

    /* Round butterfly logo */
    .logo-circle {
      width: 42px;
      height: 42px;
      border-radius: 50%;
      object-fit: cover;
      border: 2px solid #fff;
      margin-right: 10px;
    }

    /* Text */
    .brand-text {
      font-size: 18px;
      font-weight: 700;
    }

    /* Colors matching logo */
    .brand-blue {
      color: #4a8cff;
    }

    .brand-orange {
      color: #ff7a45;
    }

    .employee-header-info {
    white-space: nowrap;
}

.employee-header-info .font-weight-bold {
    font-size: 13px;
}

.employee-header-info > div:last-child {
    font-size: 11px !important;
}

@media (max-width: 576px) {

    .employee-header-info {
        display: inline-block !important;
        margin-left: 6px !important;
        max-width: 130px;
        overflow: hidden;
    }

    .employee-header-info .font-weight-bold {
        font-size: 12px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .employee-header-info > div:last-child {
        font-size: 10px !important;
    }

}
  </style>

<!-- <body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed"> -->
  <!-- <body class="hold-transition sidebar-mini layout-fixed layout-footer-fixed"> -->
    <body class="hold-transition sidebar-mini layout-fixed">
      <!-- <body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed"> -->
        <!-- <body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed"> -->
  <div class="wrapper">

    <nav class="main-header navbar navbar-expand navbar-white navbar-light shadow-sm">

      <ul class="navbar-nav align-items-center">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
        </li>
 <li class="nav-item ml-2 hello-user">
  <h5 class="mb-0 font-weight-bold" style="color: var(--mtn-deep);">
    Hello, 
    <span style="color: var(--bloom-purple);">
      <?= session()->get('emp_name'); ?>
    </span> 👋
  </h5>
</li>
      </ul>

      <ul class="navbar-nav ml-auto align-items-center">

        <!-- Role Switcher -->

<?php if(session()->get('current_user_cat') == 'ADMIN') { ?>

    <li class="nav-item mr-3 d-none d-sm-inline-block">
        <a href="<?= base_url('switchrole/HR') ?>" 
           class="btn btn-sm"
           style="background-color: #eef2ff; color: var(--bloom-purple); font-weight: 600; border-radius: 8px; border: 1px solid #c7d2fe;">
            <i class="fas fa-exchange-alt mr-1"></i> Switch to Employee
        </a>
    </li>

<?php } elseif(session()->get('current_user_cat') == 'HR') { ?>

    <li class="nav-item mr-3 d-none d-sm-inline-block">
        <a href="<?= base_url('switchrole/ADMIN') ?>" 
           class="btn btn-sm"
           style="background-color: #eef2ff; color: var(--bloom-purple); font-weight: 600; border-radius: 8px; border: 1px solid #c7d2fe;">
            <i class="fas fa-exchange-alt mr-1"></i> Switch to Admin
        </a>
    </li>

<?php } ?>
        <!-- Messages -->
        <!-- <li class="nav-item dropdown">
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

               <!-- System Notifications Dropdown -->
        <li class="nav-item dropdown mr-2">
          <a class="nav-link position-relative" data-toggle="dropdown" href="#" style="font-size: 1.1rem; color: #475569;">
            <i class="far fa-bell"></i>
            <span class="badge badge-danger navbar-badge notif-count-badge" style="display:none; font-size:10px; font-weight:700; background-color:#dc2626 !important; color:#ffffff !important; border-radius:10px; padding: 2px 6px; position:absolute; top:2px; right:1px; box-shadow: 0 2px 5px rgba(220, 38, 38, 0.5);">0</span>
          </a>

          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right shadow-lg border-0" style="width: 320px; border-radius: 16px;">
            <div class="dropdown-header font-weight-bold text-dark d-flex justify-content-between align-items-center py-2 px-3 border-bottom">
              <span><i class="fas fa-bell mr-1 text-primary"></i> Notifications</span>
              <small class="notif-count-text text-muted">0 Unread</small>
            </div>

            <div class="notifDropdownList" style="max-height: 280px; overflow-y: auto;">
              <div class="text-center text-muted p-3">Loading notifications...</div>
            </div>

            <div class="dropdown-divider m-0"></div>
            <a href="<?= base_url('employee/notifications') ?>" class="dropdown-item dropdown-footer text-center font-weight-bold text-primary py-2" style="background:#f8fafc; border-bottom-left-radius: 16px; border-bottom-right-radius: 16px;">
              View All Notifications <i class="fas fa-arrow-right ml-1"></i>
            </a>
          </div>
        </li>

        <!-- Profile -->
        <li class="nav-item dropdown">
         <a class="nav-link d-flex align-items-center" data-toggle="dropdown" href="#">

<?php
$empName = session()->get('emp_name');

$nameParts = explode(' ', $empName);

$initials = '';

if (count($nameParts) >= 2) {
    $initials = strtoupper(substr($nameParts[0], 0, 1) . substr($nameParts[1], 0, 1));
} else {
    $initials = strtoupper(substr($empName, 0, 2));
}
?>

<img src="https://ui-avatars.com/api/?name=<?= $initials; ?>&background=4a00e0&color=fff"
     class="rounded-circle shadow-sm"
     style="width: 32px; border: 2px solid #fff;">
 
<span class="ml-2 d-inline-block employee-header-info">
    <div class="font-weight-bold text-dark" style="line-height:1.2;">
        <?= session()->get('emp_name'); ?>
    </div>
    <small class="text-muted" style="font-size: 11px;">
        <?= session()->get('current_user_cat'); ?>
    </small>
</span>

        </a>

        <div class="dropdown-menu dropdown-menu-right shadow border-0" style="border-radius: 12px;">

          <a href="<?= base_url('admin/profile'); ?>" class="dropdown-item">
            <i class="fas fa-user mr-2 text-primary"></i> Profile
          </a>

          <a href="<?= base_url('admin/change_password'); ?>" class="dropdown-item">
            <i class="fas fa-key mr-2 text-warning"></i> Change Password
          </a>

          <div class="dropdown-divider"></div>

          <a href="<?= base_url('logout'); ?>" class="dropdown-item text-danger">
            <i class="fas fa-sign-out-alt mr-2"></i> Logout
          </a>

        </div>

        </li>
      </ul>
    </nav>

<?php } ?>

<script>
(function() {
    function loadHeaderNotifications() {
        fetch('<?= base_url("notifications/header_count") ?>')
            .then(response => response.json())
            .then(data => {
                if (data && data.status === 'Y') {
                    const count = data.unread_count || 0;
                    const badges = document.querySelectorAll('.notif-count-badge');
                    const textElements = document.querySelectorAll('.notif-count-text');
                    const listContainers = document.querySelectorAll('.notifDropdownList');

                    badges.forEach(b => {
                        if (count > 0) {
                            b.innerText = count > 99 ? '99+' : count;
                            b.style.display = 'inline-block';
                        } else {
                            b.style.display = 'none';
                        }
                    });

                    textElements.forEach(t => {
                        t.innerText = count + ' Unread';
                    });

                    listContainers.forEach(container => {
                        if (!data.items || data.items.length === 0) {
                            container.innerHTML = '<div class="text-center text-muted p-3"><i class="fas fa-check-circle text-success mr-1"></i> All caught up!</div>';
                            return;
                        }

                        let html = '';
                        data.items.forEach(item => {
                            let iconClass = 'fas fa-info-circle text-info';
                            if (item.category === 'LEAVE') iconClass = 'fas fa-calendar-alt text-primary';
                            else if (item.category === 'PAYSLIP') iconClass = 'fas fa-file-invoice-dollar text-success';
                            else if (item.category === 'ANNOUNCEMENT') iconClass = 'fas fa-bullhorn text-warning';
                            else if (item.category === 'REQUEST') iconClass = 'fas fa-tasks text-purple';

                            const unreadStyle = parseInt(item.is_read) === 0 ? 'font-weight-bold bg-light' : '';

                            html += `
                                <a href="<?= base_url('employee/notifications') ?>" class="dropdown-item p-2 ${unreadStyle}" style="border-bottom: 1px solid #f1f5f9; white-space: normal;">
                                    <div class="media align-items-center">
                                        <div class="mr-2"><i class="${iconClass}"></i></div>
                                        <div class="media-body small">
                                            <div class="text-dark font-weight-bold">${item.title}</div>
                                            <div class="text-muted text-truncate" style="max-width: 230px;">${item.message}</div>
                                            <div class="text-xs text-muted mt-1"><i class="far fa-clock mr-1"></i> ${item.created_at}</div>
                                        </div>
                                    </div>
                                </a>
                            `;
                        });
                        container.innerHTML = html;
                    });
                }
            })
            .catch(err => console.error("Notification load error:", err));
    }

    window.loadHeaderNotifications = loadHeaderNotifications;

    if (document.readyState === "loading") {
        document.addEventListener("DOMContentLoaded", loadHeaderNotifications);
    } else {
        loadHeaderNotifications();
    }

    setInterval(loadHeaderNotifications, 30000);
})();
</script>
