<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bloom Solutions | Company Policy</title>

  <!-- Google Font -->
  <link
    href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
    rel="stylesheet">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

  <!-- AdminLTE -->
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

    /* CONTENT */
    .content-wrapper {
      background: var(--soft-gray);
    }

    .policy-container {
      padding: 28px;
    }

    /* HEADER */
    .policy-header {
      margin-bottom: 30px;
    }

    .policy-header h2 {
      font-size: 28px;
      font-weight: 800;
      color: #111827;
      margin-bottom: 8px;
    }

    .policy-header p {
      color: #64748b;
      font-size: 13px;
      margin: 0;
    }

    /* SECTION */
    .policy-section {
      margin-bottom: 34px;
      position: relative;
    }

    .policy-section::after {
      content: "";
      position: absolute;
      right: 0;
      top: 0;
      width: 120px;
      height: 120px;
      background: url('../dist/img/bloom.jpg') no-repeat center;
      background-size: contain;
      opacity: 0.03;
      pointer-events: none;
    }

    .policy-title {
      font-size: 17px;
      font-weight: 700;
      color: #111827;
      margin-bottom: 15px;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .policy-title i {
      color: var(--bloom-purple);
      font-size: 15px;
    }

    .policy-text {
      font-size: 13px;
      line-height: 1.9;
      color: #475569;
    }

    /* HIGHLIGHT */
    .highlight-box {
      background: #eef2ff;
      border-left: 4px solid var(--bloom-purple);
      padding: 15px 18px;
      border-radius: 12px;
      margin-top: 18px;
      color: #4338ca;
      font-size: 13px;
      line-height: 1.8;
    }

    /* MINI GRID */
    .mini-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
      gap: 18px;
      margin-top: 18px;
    }

    .mini-info {
      padding: 18px 0;
      border-bottom: 1px solid #e2e8f0;
    }

    .mini-icon {
      width: 44px;
      height: 44px;
      border-radius: 14px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #fff;
      margin-bottom: 14px;
      font-size: 16px;
    }

    .bg-blue {
      background: linear-gradient(135deg, #2563eb, #38bdf8);
    }

    .bg-green {
      background: linear-gradient(135deg, #10b981, #34d399);
    }

    .bg-orange {
      background: linear-gradient(135deg, #f97316, #fb923c);
    }

    .mini-info h4 {
      font-size: 14px;
      font-weight: 700;
      color: #111827;
      margin-bottom: 10px;
    }

    .mini-info p,
    .mini-info li {
      font-size: 12px;
      color: #64748b;
      line-height: 1.8;
    }

    .mini-info ul {
      padding-left: 18px;
      margin: 0;
    }

    /* POLICY POINTS */
    .policy-points {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 14px;
      margin-top: 20px;
    }

    .policy-point {
      background: #fff;
      border: 1px solid #e2e8f0;
      border-radius: 14px;
      padding: 14px 16px;
      display: flex;
      align-items: center;
      gap: 10px;
      font-size: 13px;
      color: #334155;
    }

    .policy-point i {
      color: #10b981;
    }

    /* CONTACT */
    .contact-box {
      margin-top: 20px;
    }

    .contact-item {
      margin-bottom: 12px;
      font-size: 13px;
      color: #334155;
    }

    .contact-item i {
      color: var(--bloom-purple);
      margin-right: 8px;
    }

    /* FOOTER */
    .main-footer {
      background: #fff !important;
      border-top: 1px solid #e2e8f0 !important;
      font-size: 12px;
      padding: 10px 20px !important;
    }

    .footer-link {
      color: var(--bloom-purple);
      font-weight: 600;
      text-decoration: none;
    }

    /* MOBILE */
    @media(max-width:768px) {
      .policy-container {
        padding: 18px;
      }

      .policy-header h2 {
        font-size: 22px;
      }
    }
  </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
  <div class="wrapper">

   
    <!-- CONTENT -->
    <div class="content-wrapper">

      <section class="content">

        <div class="container-fluid policy-container">

          <!-- HEADER -->
          <div class="policy-header">

            <h2>Privacy Policy</h2>

            <p>
              Bloom Solutions is committed to protecting employee and customer information securely.
            </p>

          </div>

          <!-- INTRO -->
          <div class="policy-section">

            <div class="policy-title">
              <i class="fas fa-shield-alt"></i>
              Introduction
            </div>

            <div class="policy-text">
              Welcome to Bloom Solutions ("we," "us," or "our"). We are committed to protecting your privacy
              and ensuring your information is handled responsibly and securely.
            </div>

            <div class="highlight-box">
              By accessing or using our website and services, you agree to the terms of this Privacy Policy.
            </div>

          </div>

          <!-- INFORMATION -->
          <div class="policy-section">

            <div class="policy-title">
              <i class="fas fa-database"></i>
              Information We Collect
            </div>

            <div class="mini-grid">

              <div class="mini-info">

                <div class="mini-icon bg-blue">
                  <i class="fas fa-user"></i>
                </div>

                <h4>Personal Information</h4>

                <ul>
                  <li>Name</li>
                  <li>Email Address</li>
                  <li>Phone Number</li>
                  <li>Mailing Address</li>
                </ul>

              </div>

              <div class="mini-info">

                <div class="mini-icon bg-green">
                  <i class="fas fa-laptop"></i>
                </div>

                <h4>Non-Personal Information</h4>

                <ul>
                  <li>Browser Details</li>
                  <li>IP Address</li>
                  <li>Visited Pages</li>
                  <li>Operating System</li>
                </ul>

              </div>

              <div class="mini-info">

                <div class="mini-icon bg-orange">
                  <i class="fas fa-cookie-bite"></i>
                </div>

                <h4>Cookies & Tracking</h4>

                <p>
                  Cookies help improve user experience, save preferences and analyze traffic.
                </p>

              </div>

            </div>

          </div>

          <!-- USE OF DATA -->
          <div class="policy-section">

            <div class="policy-title">
              <i class="fas fa-cogs"></i>
              How We Use Your Information
            </div>

            <div class="policy-points">

              <div class="policy-point">
                <i class="fas fa-check-circle"></i>
                Maintain and improve services
              </div>

              <div class="policy-point">
                <i class="fas fa-check-circle"></i>
                Process transactions securely
              </div>

              <div class="policy-point">
                <i class="fas fa-check-circle"></i>
                Respond to customer requests
              </div>

              <div class="policy-point">
                <i class="fas fa-check-circle"></i>
                Ensure website security
              </div>

            </div>

          </div>

          <!-- DATA SHARING -->
          <div class="policy-section">

            <div class="policy-title">
              <i class="fas fa-share-alt"></i>
              Information Sharing
            </div>

            <div class="policy-text">
              We do not sell or rent personal information to third parties.
            </div>

            <div class="highlight-box">

              Information may only be shared with:
              <ul>
                <li>Trusted service providers</li>
                <li>Legal authorities when required</li>
                <li>Business transfer partners</li>
                <li>With your direct consent</li>
              </ul>

            </div>

          </div>

          <!-- SECURITY -->
          <div class="policy-section">

            <div class="policy-title">
              <i class="fas fa-lock"></i>
              Data Security
            </div>

            <div class="policy-text">
              Bloom Solutions follows strong technical and organizational measures
              to protect information from unauthorized access and misuse.
            </div>

          </div>

          <!-- CONTACT -->
          <div class="policy-section">

            <div class="policy-title">
              <i class="fas fa-phone-alt"></i>
              Contact Us
            </div>

            <div class="contact-box">

              <div class="contact-item">
                <strong>Bloom Solutions Pvt Ltd</strong>
              </div>

              <div class="contact-item">
                <i class="fas fa-envelope"></i>
                info@bloomsolutions.in
              </div>

              <div class="contact-item">
                <i class="fas fa-phone"></i>
                040 23320015
              </div>

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