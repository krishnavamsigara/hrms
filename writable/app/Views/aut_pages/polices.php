<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bloom Solutions | Polices</title>

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

    .hero-section {
      position: relative;
      height: 380px;
      background: url('https://images.unsplash.com/photo-1521737604893-d14cc237f11d') center/cover no-repeat;
      border-radius: 20px;
      margin-bottom: 30px;
      overflow: hidden;
    }

    /* dark overlay */
    .hero-section::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.45);
    }

    /* text on image */
    .hero-content {
      position: relative;
      z-index: 2;
      color: #fff;
      padding: 40px;
    }

    .hero-content h1 {
      font-size: 34px;
      font-weight: 800;
    }

    .hero-content p {
      font-size: 15px;
      opacity: 0.9;
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

    /* ==========================
   PAGE HEADER
========================== */

    .page-title {
      font-size: 28px;
      font-weight: 800;
      color: var(--mtn-deep);
      margin-bottom: 6px;
    }

    .page-subtitle {
      font-size: 14px;
      color: #64748b;
    }

    /* ==========================
   POLICY SECTION
========================== */

    .policy-row {
      margin-top: 25px;
    }

    .policy-card {
      background: #fff;
      border-radius: 22px;
      padding: 28px 22px;
      border: 1px solid #e2e8f0;
      height: 100%;
      transition: all .35s ease;
      position: relative;
      overflow: hidden;
      box-shadow: 0 4px 18px rgba(15, 23, 42, .05);
    }

    .policy-card:hover {
      transform: translateY(-8px);
      box-shadow: 0 15px 30px rgba(0, 0, 0, .08);
      border-color: #c7d2fe;
    }

    /* top hover effect */
    .policy-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 4px;
      background: linear-gradient(90deg,
          var(--bloom-purple),
          #7c3aed);
    }

    /* ==========================
   ICON BOX
========================== */

    .policy-icon {
      width: 70px;
      height: 70px;
      border-radius: 20px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 28px;
      margin-bottom: 22px;
      box-shadow: 0 8px 18px rgba(0, 0, 0, .08);
    }

    .policy-icon i {
      color: #fff;
    }

    /* icon colors */

    .policy-blue {
      background: linear-gradient(135deg,
          #3b82f6,
          #2563eb);
    }

    .policy-green {
      background: linear-gradient(135deg,
          #10b981,
          #059669);
    }

    .policy-orange {
      background: linear-gradient(135deg,
          #f59e0b,
          #ea580c);
    }

    .policy-purple {
      background: linear-gradient(135deg,
          #8b5cf6,
          #6d28d9);
    }

    /* ==========================
   TEXT
========================== */

    .policy-title {
      font-size: 18px;
      font-weight: 700;
      color: var(--mtn-deep);
      margin-bottom: 12px;
    }

    .policy-text {
      font-size: 13px;
      line-height: 1.8;
      color: #64748b;
      min-height: 78px;
    }

    /* ==========================
   BUTTON STYLE
========================== */

    .policy-btn {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      margin-top: 20px;
      font-size: 13px;
      font-weight: 700;
      color: var(--bloom-purple);
      background: #eef2ff;
      padding: 10px 16px;
      border-radius: 12px;
      transition: .3s;
    }

    .policy-card:hover .policy-btn {
      background: var(--bloom-purple);
      color: #fff;
    }

    .policy-btn i {
      transition: .3s;
    }

    .policy-card:hover .policy-btn i {
      transform: translateX(5px);
    }

    /* ==========================
   MOBILE
========================== */

    @media(max-width:768px) {

      .page-title {
        font-size: 22px;
      }

      .policy-card {
        padding: 22px 18px;
      }

      .policy-icon {
        width: 60px;
        height: 60px;
        font-size: 24px;
      }

      .policy-title {
        font-size: 16px;
      }

    }
  </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
  <div class="wrapper">

   
    <div class="content-wrapper">

        <div class="container-fluid">
          <!-- BIG OFFICE IMAGE SECTION -->
          <div class="hero-section">
            <div class="hero-content">
              <h1>Company Policies</h1>
              <p>Access all HR rules, guidelines and workplace standards in one place</p>
            </div>
          </div>
   <!-- POLICY ROW -->
            <div class="row policy-row">

              <!-- LEAVE POLICY -->
              <div class="col-lg-3 col-md-6 mb-4">

                <a href="<?= base_url('aut_pages/leave_policy') ?>" style="text-decoration:none;">
                  

                  <div class="policy-card">

                    <div class="policy-icon policy-blue">
                      <i class="fas fa-calendar-check"></i>
                    </div>

                    <div class="policy-title">
                      Leave Policy
                    </div>

                    <div class="policy-text">
                      View employee leave rules, attendance guidelines,
                      approvals and holiday structure details.
                    </div>

                    <span class="policy-btn">
                      Read Policy
                      <i class="fas fa-arrow-right"></i>
                    </span>

                  </div>

                </a>

              </div>

              <!-- COMPANY POLICY -->
              <div class="col-lg-3 col-md-6 mb-4">

                <a href="<?= base_url('aut_pages/company_policy') ?>" style="text-decoration:none;">

                  <div class="policy-card">

                    <div class="policy-icon policy-green">
                      <i class="fas fa-building"></i>
                    </div>

                    <div class="policy-title">
                      Company Policy
                    </div>

                    <div class="policy-text">
                      Understand workplace standards,
                      HR processes and operational procedures.
                    </div>

                    <span class="policy-btn">
                      Explore
                      <i class="fas fa-arrow-right"></i>
                    </span>

                  </div>

                </a>

              </div>

              <!-- CODE OF CONDUCT -->
              <div class="col-lg-3 col-md-6 mb-4">

                <a href="<?= base_url('aut_pages/conduct') ?>" style="text-decoration:none;">

                  <div class="policy-card">

                    <div class="policy-icon policy-orange">
                      <i class="fas fa-user-shield"></i>
                    </div>

                    <div class="policy-title">
                      Code of Conduct
                    </div>

                    <div class="policy-text">
                      Learn professional ethics,
                      employee behaviour and workplace expectations.
                    </div>

                    <span class="policy-btn">
                      Open Guide
                      <i class="fas fa-arrow-right"></i>
                    </span>

                  </div>

                </a>

              </div>

              <!-- TERMS -->
              <div class="col-lg-3 col-md-6 mb-4">

                <a href="<?= base_url('aut_pages/terms_conditions') ?>" style="text-decoration:none;">

                  <div class="policy-card">

                    <div class="policy-icon policy-purple">
                      <i class="fas fa-file-contract"></i>
                    </div>

                    <div class="policy-title">
                      Terms & Conditions
                    </div>

                    <div class="policy-text">
                      Review company terms,
                      employee responsibilities and usage conditions.
                    </div>

                    <span class="policy-btn">
                      View Terms
                      <i class="fas fa-arrow-right"></i>
                    </span>

                  </div>

                </a>

              </div>

            </div>

          </div>

      </section>

    </div>


  </div>

  <!-- SCRIPTS -->
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

</body>

</html>