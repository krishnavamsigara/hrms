<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Bloom Solutions | Code of Conduct</title>

  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
    rel="stylesheet">

  <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

  <link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">

  <style>
    :root {
      --bloom-purple: #4a00e0;
      --bloom-dark: #111c43;
      --bloom-orange: #ff7a45;
      --soft-bg: #f4f7fb;
      --border-color: #e2e8f0;
      --text-light: #64748b;
    }

    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      background: var(--soft-bg);
      font-size: 13px;
      color: #334155;
    }

    /* NAVBAR */
    .main-header {
      border-bottom: 1px solid #e2e8f0 !important;
      background: #fff !important;
      height: 55px;
    }

    /* SIDEBAR */
    .main-sidebar {
      background: #111c43 !important;
    }

    .brand-link {
      border-bottom: 1px solid rgba(255,255,255,.08);
      padding: 14px 18px;
    }

    .nav-sidebar .nav-link {
      height: 42px;
      font-size: 13px;
      display: flex;
      align-items: center;
    }

    .nav-sidebar .nav-link.active {
      background: #007bff !important;
      color: #fff !important;
      border-radius: 8px;
    }

    .nav-sidebar .nav-link:hover:not(.active) {
      background: rgba(255,255,255,.08);
      border-radius: 8px;
    }

    /* CONTENT */
    .content-wrapper {
      background: #f4f7fb;
    }

    .page-header {
      padding: 28px 28px 10px;
    }

    .page-title {
      font-size: 24px;
      font-weight: 800;
      color: #111827;
      margin-bottom: 6px;
    }

    .page-subtitle {
      font-size: 13px;
      color: #64748b;
    }

    /* POLICY SECTION */
    .policy-section {
      position: relative;
      padding: 24px 28px;
      margin-bottom: 18px;
      border-bottom: 1px solid #e2e8f0;
    }

    .policy-section:last-child {
      border-bottom: none;
    }

    /* WATERMARK */
    .policy-section::after {
      content: "";
      position: absolute;
      right: 20px;
      top: 10px;
      width: 90px;
      height: 90px;
      background: url('../dist/img/bloom.jpg') no-repeat center;
      background-size: contain;
      opacity: 0.03;
      pointer-events: none;
    }

    .section-title {
      font-size: 18px;
      font-weight: 700;
      color: #111827;
      margin-bottom: 16px;
      display: flex;
      align-items: center;
    }

    .section-title i {
      width: 38px;
      height: 38px;
      border-radius: 12px;
      background: linear-gradient(135deg, #4a00e0, #7c3aed);
      color: #fff;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 15px;
      margin-right: 12px;
    }

    .policy-text {
      color: #475569;
      line-height: 1.9;
      margin-bottom: 16px;
      font-size: 13px;
    }

    /* MINI INFO */
    .mini-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
      gap: 16px;
      margin-top: 20px;
    }

    .mini-info {
      background: rgba(255,255,255,.7);
      border: 1px solid #e2e8f0;
      border-radius: 16px;
      padding: 18px;
      transition: .3s;
    }

    .mini-info:hover {
      transform: translateY(-4px);
      box-shadow: 0 10px 20px rgba(0,0,0,.06);
      background: #fff;
    }

    .mini-icon {
      width: 42px;
      height: 42px;
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #fff;
      margin-bottom: 12px;
      font-size: 15px;
    }

    .bg-purple {
      background: linear-gradient(135deg, #4a00e0, #7c3aed);
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
      margin-bottom: 8px;
      color: #111827;
    }

    .mini-info p {
      font-size: 12px;
      color: #64748b;
      line-height: 1.7;
      margin: 0;
    }

    /* HIGHLIGHT */
    .highlight-box {
      background: linear-gradient(135deg, #eef2ff, #f5f3ff);
      border-left: 4px solid #4a00e0;
      padding: 16px 18px;
      border-radius: 14px;
      margin-top: 20px;
      font-size: 13px;
      color: #334155;
      line-height: 1.8;
    }

    .highlight-box strong {
      color: #111827;
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
      text-decoration: none;
      font-weight: 700;
    }

    @media(max-width:768px) {

      .page-header,
      .policy-section {
        padding-left: 18px;
        padding-right: 18px;
      }

      .page-title {
        font-size: 20px;
      }

    }
  </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
  <div class="wrapper">

   

    <!-- CONTENT -->
    <div class="content-wrapper">

      <!-- HEADER -->
      <div class="page-header">

        <div class="page-title">
          Code of Conduct
        </div>

        <div class="page-subtitle">
          Professional ethics, workplace behaviour and employee responsibilities at Bloom Solutions.
        </div>

      </div>

      <!-- SECTION -->
      <section class="policy-section">

        <div class="section-title">
          <i class="fas fa-handshake"></i>
          Workplace Ethics
        </div>

        <div class="policy-text">
          All employees are expected to maintain honesty, professionalism and integrity while representing Bloom Solutions. Respectful communication and ethical behaviour are mandatory across all departments and client interactions.
        </div>

        <div class="mini-grid">

          <div class="mini-info">

            <div class="mini-icon bg-purple">
              <i class="fas fa-user-tie"></i>
            </div>

            <h4>Professional Behaviour</h4>

            <p>
              Employees should maintain respectful communication and positive workplace conduct.
            </p>

          </div>

          <div class="mini-info">

            <div class="mini-icon bg-blue">
              <i class="fas fa-users"></i>
            </div>

            <h4>Team Collaboration</h4>

            <p>
              Support teamwork, coordination and knowledge sharing across departments.
            </p>

          </div>

          <div class="mini-info">

            <div class="mini-icon bg-green">
              <i class="fas fa-lock"></i>
            </div>

            <h4>Data Confidentiality</h4>

            <p>
              Protect company data, client records and confidential information responsibly.
            </p>

          </div>

          <div class="mini-info">

            <div class="mini-icon bg-orange">
              <i class="fas fa-laptop-code"></i>
            </div>

            <h4>System Usage</h4>

            <p>
              Company systems and resources should only be used for official work purposes.
            </p>

          </div>

        </div>

        <div class="highlight-box">
          <strong>Important:</strong>
          Harassment, discrimination, misuse of company assets or violation of workplace ethics may result in disciplinary action as per company policies.
        </div>

      </section>

      <!-- SECTION -->
      <section class="policy-section">

        <div class="section-title">
          <i class="fas fa-briefcase"></i>
          Employee Responsibilities
        </div>

        <div class="policy-text">
          Employees are responsible for maintaining punctuality, completing assigned work on time and ensuring compliance with company guidelines and operational standards.
        </div>

        <div class="mini-grid">

          <div class="mini-info">

            <div class="mini-icon bg-blue">
              <i class="fas fa-clock"></i>
            </div>

            <h4>Punctuality</h4>

            <p>
              Maintain regular attendance and inform managers about leave or delays earlier.
            </p>

          </div>

          <div class="mini-info">

            <div class="mini-icon bg-purple">
              <i class="fas fa-tasks"></i>
            </div>

            <h4>Work Quality</h4>

            <p>
              Deliver quality work within timelines while following project standards.
            </p>

          </div>

          <div class="mini-info">

            <div class="mini-icon bg-green">
              <i class="fas fa-shield-alt"></i>
            </div>

            <h4>Policy Compliance</h4>

            <p>
              Follow company policies, HR rules and security procedures without violations.
            </p>

          </div>

          <div class="mini-info">

            <div class="mini-icon bg-orange">
              <i class="fas fa-comments"></i>
            </div>

            <h4>Communication</h4>

            <p>
              Maintain clear, respectful and transparent communication with teams and managers.
            </p>

          </div>

        </div>

      </section>

    </div>

    

  </div>

  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

</body>

</html>