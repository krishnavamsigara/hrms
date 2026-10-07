<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bloom Solutions | Admin Dashboard</title>

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

    <div class="content-wrapper">
      <section class="content-header pt-3">
        <div class="container-fluid">
          <div class="row mb-3">
            <div class="col-sm-6">
              <h4 class="font-weight-bold mb-0" style="color: var(--mtn-deep);">Company Policies</h4>
            </div>
            <div class="col-sm-6 text-right">
              <button class="btn btn-primary btn-sm" style="border-radius: 8px; font-weight: 600;"><i class="fas fa-upload mr-1"></i> Upload Policy</button>
            </div>
          </div>
        </div>
      </section>
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-4">
              <div class="card card-bloom">
                <div class="card-body">
                  <div class="d-flex align-items-center mb-3">
                    <div class="stat-icon-circle bg-light text-primary mr-3" style="font-size: 20px;"><i class="fas fa-umbrella-beach"></i></div>
                    <h6 class="font-weight-bold mb-0">Leave Policy</h6>
                  </div>
                  <p class="text-muted text-sm">Guidelines on annual, sick, and casual leave entitlements and the application process.</p>
                  <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top">
                    <small class="text-muted font-weight-bold">Updated: Jan 10, 2026</small>
                    <button class="btn btn-sm btn-outline-primary" style="border-radius: 6px;"><i class="fas fa-download"></i></button>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="card card-bloom">
                <div class="card-body">
                  <div class="d-flex align-items-center mb-3">
                    <div class="stat-icon-circle bg-light text-success mr-3" style="font-size: 20px;"><i class="fas fa-laptop-code"></i></div>
                    <h6 class="font-weight-bold mb-0">IT & Asset Policy</h6>
                  </div>
                  <p class="text-muted text-sm">Rules concerning the acceptable use of company hardware, software, and networks.</p>
                  <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top">
                    <small class="text-muted font-weight-bold">Updated: Feb 05, 2026</small>
                    <button class="btn btn-sm btn-outline-success" style="border-radius: 6px;"><i class="fas fa-download"></i></button>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="card card-bloom">
                <div class="card-body">
                  <div class="d-flex align-items-center mb-3">
                    <div class="stat-icon-circle bg-light text-danger mr-3" style="font-size: 20px;"><i class="fas fa-handshake"></i></div>
                    <h6 class="font-weight-bold mb-0">Code of Conduct</h6>
                  </div>
                  <p class="text-muted text-sm">Core values, ethics, and expected professional behavior for all employees.</p>
                  <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top">
                    <small class="text-muted font-weight-bold">Updated: Dec 20, 2025</small>
                    <button class="btn btn-sm btn-outline-danger" style="border-radius: 6px;"><i class="fas fa-download"></i></button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>
  
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
