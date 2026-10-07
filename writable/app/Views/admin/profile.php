<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>BloomHR | Profile</title>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
  
  <style>
    :root {
        --bloom-purple: #4a00e0;
        --bloom-dark: #2a0080;
        --mtn-deep: #120038;
        --glass: rgba(255, 255, 255, 0.95);
    }

    body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8fafc; font-size: 13px; color: #334155; }

    /* --- SHARED LAYOUT STYLES --- */
    .main-header { border-bottom: 1px solid #e2e8f0 !important; background: var(--glass) !important; backdrop-filter: blur(10px); }
    .main-sidebar { background: var(--mtn-deep) !important; }
    .custom-brand { display:flex; align-items:center; padding:12px 16px; border-bottom:1px solid rgba(255,255,255,0.08); }
    .logo-circle { width:42px; height:42px; border-radius:50%; object-fit:cover; border:2px solid #fff; margin-right:10px; }
    .brand-text { font-size:18px; font-weight:700; }
    .brand-blue { color:#4a8cff; }
    .brand-orange { color:#ff7a45; }

    /* --- PROFILE SPECIFIC STYLES --- */
    .profile-header-banner {
      height: 180px;
      background: linear-gradient(135deg, var(--mtn-deep) 0%, var(--bloom-purple) 100%);
      border-radius: 0 0 40px 40px;
      position: relative;
      margin-bottom: 90px;
    }

    .profile-main-card {
      position: absolute;
      bottom: -60px;
      left: 2%;
      right: 2%;
      background: var(--glass);
      backdrop-filter: blur(10px);
      border-radius: 24px;
      padding: 25px;
      display: flex;
      align-items: center;
      border: 1px solid rgba(255,255,255,0.4);
      box-shadow: 0 15px 35px rgba(18, 0, 56, 0.08);
    }

    .profile-image-wrap {
      width: 110px;
      height: 110px;
      border-radius: 20px;
      background: #fff;
      padding: 4px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.1);
      margin-right: 25px;
    }
    .profile-image-wrap img { width: 100%; height: 100%; border-radius: 16px; object-fit: cover; }

    .info-card {
      background: #fff;
      border-radius: 20px;
      padding: 25px;
      border: 1px solid #e2e8f0;
      height: 100%;
    }

    .section-head {
      font-size: 10px;
      font-weight: 800;
      text-transform: uppercase;
      letter-spacing: 1.2px;
      color: var(--bloom-purple);
      margin-bottom: 20px;
      display: block;
      border-left: 3px solid var(--bloom-purple);
      padding-left: 10px;
    }

    .item-label { font-size: 10px; font-weight: 600; color: #94a3b8; text-transform: uppercase; display: block; }
    .item-value { font-size: 13px; font-weight: 700; color: var(--mtn-deep); }
    .address-box { background: #f8fafc; padding: 15px; border-radius: 15px; margin-top: 15px; border: 1px dashed #cbd5e1; }
    
    .btn-bloom-outline {
      border: 2px solid var(--bloom-purple);
      color: var(--bloom-purple);
      border-radius: 10px;
      font-weight: 700;
      font-size: 12px;
      padding: 8px 18px;
      transition: 0.3s;
    }
    .btn-bloom-outline:hover { background: var(--bloom-purple); color: #fff; }
  </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <nav class="main-header navbar navbar-expand navbar-white navbar-light shadow-sm">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block ml-2">
        <h5 class="mb-0 font-weight-bold" style="color: var(--mtn-deep);">My Profile</h5>
      </li>
    </ul>

    <ul class="navbar-nav ml-auto align-items-center">
      <li class="nav-item dropdown">
        <a class="nav-link d-flex align-items-center" data-toggle="dropdown" href="#">
          <img src="https://ui-avatars.com/api/?name=Aishwarya&background=4a00e0&color=fff" class="rounded-circle shadow-sm" style="width: 32px; border: 2px solid #fff;">
          <span class="ml-2 d-none d-sm-inline-block font-weight-bold text-dark">Aishwarya</span>
        </a>
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

            <li class="nav-item menu-open">
              <a href="#" class="nav-link active">
                <i class="nav-icon fas fa-users-cog"></i>
                <p>HR<i class="right fas fa-angle-right"></i></p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="empolyees.html" class="nav-link active">
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
    
    <div class="profile-header-banner">
      <div class="profile-main-card">
        <div class="profile-image-wrap">
          <img src="https://ui-avatars.com/api/?name=Ishusravani&background=4a00e0&color=fff&size=200">
        </div>
        <div class="flex-grow-1">
          <h2 class="font-weight-bold mb-1" style="color: var(--mtn-deep);">Ishusravani</h2>
          <p class="mb-2 text-muted">
            <span class="badge badge-pill" style="background: rgba(74, 0, 224, 0.1); color: var(--bloom-purple); padding: 5px 12px;">BS00286</span>
            <span class="mx-2">•</span> Joined 02 June 2025
          </p>
          <div class="d-flex align-items-center">
             <div class="mr-4"><span class="item-label">Reporting To</span><span class="item-value">Kuppala Baji Babu</span></div>
             <div><span class="item-label">Work Location</span><span class="item-value">Hyderabad</span></div>
          </div>
        </div>
        <div class="ml-auto d-none d-md-block">
          <button class="btn btn-bloom-outline">Update Details</button>
        </div>
      </div>
    </div>

    <section class="content">
      <div class="container-fluid px-3">
        <div class="row">
          <div class="col-lg-5 mb-4">
            <div class="info-card">
              <span class="section-head">Personal & Contact Details</span>
              <div class="row">
                  <div class="col-6 mb-3">
                      <span class="item-label">Email Address</span>
                      <span class="item-value">ishus39@gmail.com</span>
                  </div>
                  <div class="col-6 mb-3">
                      <span class="item-label">Mobile Number</span>
                      <span class="item-value">+91 000000000</span>
                  </div>
                  <div class="col-6 mb-3">
                      <span class="item-label">Date of Birth</span>
                      <span class="item-value">18 Oct 2002</span>
                  </div>
                  <div class="col-6 mb-3">
                      <span class="item-label">Gender</span>
                      <span class="item-value">Female</span>
                  </div>
              </div>
              <div class="address-box">
                  <span class="item-label">Residential Address</span>
                  <p class="item-value mb-1">H.No 5-120 vk puram, Bhimavaram</p>
                  <span class="item-value text-muted small">Andhra Pradesh - 534202</span>
              </div>
            </div>
          </div>

          <div class="col-lg-7">
            <div class="row">
              <div class="col-md-6 mb-4">
                  <div class="info-card border-top" style="border-top: 3px solid #003399 !important;">
                      <span class="section-head">Bank Information</span>
                      <div class="text-center py-2">
                          <h5 class="font-weight-bold" style="color: #003399;">AXIS BANK</h5>
                          <span class="item-label mt-2">Account Number</span>
                          <span class="item-value" style="font-size: 16px;">92501001XXXX</span>
                      </div>
                      <div class="mt-3 p-2 rounded bg-light border text-center">
                          <span class="item-label">IFSC Code</span>
                          <span class="item-value">UTIB022298</span>
                      </div>
                  </div>
              </div>
              <div class="col-md-6 mb-4">
                  <div class="info-card">
                      <span class="section-head">Statutory & ID Compliance</span>
                      <div class="mb-2"><span class="item-label">PAN</span><span class="item-value">FTOPAXXXXD</span></div>
                      <div class="mb-2"><span class="item-label">Aadhaar</span><span class="item-value">7896 XXXX 6007</span></div>
                      <hr class="my-2">
                      <div class="mb-2"><span class="item-label">UAN Number</span><span class="item-value">102204741640</span></div>
                      <div class="mb-2"><span class="item-label">ESIC Number</span><span class="item-value">5222085698</span></div>
                  </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <footer class="main-footer">
    <strong>Copyright &copy; 2026 <a href="#" class="brand-orange">Bloom Solutions</a>.</strong>
    All rights reserved.
  </footer>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
</body>
</html>
