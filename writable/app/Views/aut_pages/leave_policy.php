<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Bloom Solutions | Leave Policy</title>

  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
    rel="stylesheet">

  <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

  <link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">

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


    /* CONTENT */
    .content-wrapper {
      background: var(--soft-bg);
    }

    /* SECTION */
    .policy-section {
      margin-bottom: 30px;
    }

    .section-title {
      font-size: 20px;
      font-weight: 700;
      color: #111827;
      margin-bottom: 12px;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .section-title i {
      color: var(--primary);
      font-size: 16px;
    }

    .policy-text {
      line-height: 1.9;
      color: #64748b;
      margin-bottom: 0;
      font-size: 13px;
    }

    /* MINI GRID */
    .mini-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
      gap: 16px;
      margin-top: 18px;
    }

    /* MINI CARD */
    .mini-info {
      position: relative;
      overflow: hidden;
      padding: 18px;
      border-radius: 18px;
      background: #fff;
      border: 1px solid #e2e8f0;
      transition: .3s;
      min-height: 170px;
    }

    .mini-info:hover {
      transform: translateY(-4px);
      box-shadow: 0 10px 25px rgba(0, 0, 0, .06);
    }

    /* WATERMARK */
    .mini-info::after {
      content: "";
      position: absolute;
      right: -15px;
      bottom: -15px;
      width: 90px;
      height: 90px;
      background: url('../dist/img/bloom.jpg') no-repeat center;
      background-size: contain;
      opacity: .04;
    }

    /* ICON */
    .mini-icon {
      width: 46px;
      height: 46px;
      border-radius: 14px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #fff;
      margin-bottom: 14px;
      font-size: 16px;
    }

    .bg-blue {
      background: linear-gradient(135deg, #2563eb, #60a5fa);
    }

    .bg-green {
      background: linear-gradient(135deg, #10b981, #34d399);
    }

    .bg-orange {
      background: linear-gradient(135deg, #f97316, #fb923c);
    }

    .bg-purple {
      background: linear-gradient(135deg, #7c3aed, #a855f7);
    }

    .mini-info h4 {
      font-size: 14px;
      font-weight: 700;
      color: #111827;
      margin-bottom: 8px;
    }

    .mini-info p {
      font-size: 12px;
      line-height: 1.8;
      color: #64748b;
      margin: 0;
    }

    /* IMPORTANT POINTS */
    .highlight-box {
      margin-top: 18px;
    }

    .point-item {
      display: flex;
      align-items: flex-start;
      gap: 10px;
      margin-bottom: 14px;
      color: #475569;
      line-height: 1.8;
    }

    .point-item i {
      color: var(--primary);
      margin-top: 5px;
      font-size: 11px;
    }

    /* FOOTER */
    .main-footer {
      background: #fff !important;
      border-top: 1px solid #e2e8f0 !important;
      font-size: 12px;
    }

    .footer-link {
      color: var(--primary);
      text-decoration: none;
      font-weight: 700;
    }

    @media(max-width:768px) {
      .section-title {
        font-size: 18px;
      }
    }
  </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">

  <div class="wrapper">

   

    <!-- CONTENT -->
    <div class="content-wrapper">

      <section class="content pt-4">

        <div class="container-fluid">

          <!-- TITLE -->
          <div class="policy-section">

            <div class="section-title">
              <i class="fas fa-calendar-check"></i>
              Employee Leave Policy
            </div>

            <p class="policy-text">
              Bloom Solutions supports employee wellbeing by providing structured leave benefits,
              planned holidays and professional work-life balance policies for all employees.
            </p>

          </div>

          <!-- LEAVE TYPES -->
          <div class="policy-section">

            <div class="section-title">
              <i class="fas fa-clipboard-list"></i>
              Leave Categories
            </div>

            <div class="mini-grid">

              <!-- Casual -->
              <div class="mini-info">

                <div class="mini-icon bg-blue">
                  <i class="fas fa-umbrella-beach"></i>
                </div>

                <h4>Casual Leave</h4>

                <p>
                  Employees may apply casual leave for personal work or emergencies with manager approval.
                </p>

              </div>

              <!-- Sick -->
              <div class="mini-info">

                <div class="mini-icon bg-green">
                  <i class="fas fa-notes-medical"></i>
                </div>

                <h4>Sick Leave</h4>

                <p>
                  Sick leave can be used during illness or medical recovery periods when required.
                </p>

              </div>

              <!-- Maternity -->
              <div class="mini-info">

                <div class="mini-icon bg-orange">
                  <i class="fas fa-baby"></i>
                </div>

                <h4>Maternity Leave</h4>

                <p>
                  Female employees are eligible for maternity leave according to company policy.
                </p>

              </div>

              <!-- Planned -->
              <div class="mini-info">

                <div class="mini-icon bg-purple">
                  <i class="fas fa-plane"></i>
                </div>

                <h4>Planned Leave</h4>

                <p>
                  Planned leave should be informed earlier for smooth coordination and approvals.
                </p>

              </div>

            </div>

          </div>

          <!-- IMPORTANT GUIDELINES -->
          <div class="policy-section">

            <div class="section-title">
              <i class="fas fa-star"></i>
              Important Guidelines
            </div>

            <div class="highlight-box">

              <div class="point-item">
                <i class="fas fa-circle"></i>
                <span>
                  Leave requests must be submitted through the HR portal.
                </span>
              </div>

              <div class="point-item">
                <i class="fas fa-circle"></i>
                <span>
                  Manager approval is mandatory before leave approval.
                </span>
              </div>

              <div class="point-item">
                <i class="fas fa-circle"></i>
                <span>
                  Unapproved absence may affect attendance and salary processing.
                </span>
              </div>

              <div class="point-item">
                <i class="fas fa-circle"></i>
                <span>
                  Public holidays will be officially announced by management.
                </span>
              </div>

              <div class="point-item">
                <i class="fas fa-circle"></i>
                <span>
                  Employees should maintain proper attendance and leave records.
                </span>
              </div>

            </div>

          </div>

        </div>

      </section>

    </div>

    <!-- FOOTER -->
    <footer class="main-footer">

      <strong>
        Copyright &copy; 2026

        <a href="https://www.bloomsolutions.in/" class="footer-link">
          Bloom Solutions
        </a>
      </strong>

    </footer>

  </div>

  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

</body>

</html>