<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bloom Solutions | Help</title>

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

    .content-wrapper {
  padding-bottom: 50px;
}

.content-wrapper {
  padding-bottom: 50px;
}

.main-footer {
  z-index: 1030;
}


html, body {
  height: 100%;
}

.wrapper {
  min-height: 100vh;
  display: flex;
  flex-direction: column;
}

.content-wrapper {
  flex: 1;
}

/* FORCE FOOTER FIXED */
.main-footer {
  position: fixed;
  bottom: 0;
  left: 0;
  right: 0;
  z-index: 9999;
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
              <h4 class="font-weight-bold mb-0" style="color: var(--mtn-deep);">Help Desk</h4>
            </div>
          </div>
        </div>
      </section>
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-3">
              <div class="card card-bloom">
                <div class="card-body p-0">
                  <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <a class="nav-link active rounded-0 px-4 py-3 border-bottom" id="v-pills-getting-started-tab"
                      data-toggle="pill" href="#v-pills-getting-started" role="tab" style="font-weight: 600;"><i
                        class="fas fa-play-circle mr-2 text-primary" style="width: 20px;"></i> Getting Started</a>
                    <a class="nav-link rounded-0 px-4 py-3 border-bottom" id="v-pills-modules-tab" data-toggle="pill"
                      href="#v-pills-modules" role="tab" style="font-weight: 600;"><i
                        class="fas fa-layer-group mr-2 text-success" style="width: 20px;"></i> Modules Guide</a>
                    <a class="nav-link rounded-0 px-4 py-3 border-bottom" id="v-pills-faq-tab" data-toggle="pill"
                      href="#v-pills-faq" role="tab" style="font-weight: 600;"><i
                        class="fas fa-question-circle mr-2 text-warning" style="width: 20px;"></i> FAQs</a>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-md-9">
              <div class="card card-bloom" style="min-height: 400px;">
                <div class="card-body p-4">
                  <div class="tab-content" id="v-pills-tabContent">

                    <!-- Getting Started -->
                    <div class="tab-pane fade show active" id="v-pills-getting-started" role="tabpanel">
                      <h5 class="font-weight-bold text-dark mb-4">Welcome to BloomHR Help Center</h5>
                      <p class="text-muted" style="line-height: 1.6;">BloomHR is a comprehensive Human Resource
                        Management System designed to simplify your daily work life. Here's a quick overview of how to
                        navigate the portal:</p>

                      <div class="mt-4 p-3 rounded" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                        <h6 class="font-weight-bold text-primary mb-3"><i class="fas fa-compass mr-2"></i> Navigation
                          Basics</h6>
                        <ul class="text-muted pl-3 mb-0" style="line-height: 1.8;">
                          <li><strong>Sidebar Menu:</strong> Use the left sidebar to access different modules like
                            Attendance, Leave, Payroll, etc.</li>
                          <li><strong>Role Switcher:</strong> If you are an HR or Admin, use the "Switch to
                            Employee/Admin" button at the top right to switch between your administrative and personal
                            views.</li>
                          <li><strong>Profile Dropdown:</strong> Click your profile picture at the top right to access
                            your personal settings or logout.</li>
                        </ul>
                      </div>
                    </div>

                    <!-- Modules Guide -->
                    <div class="tab-pane fade" id="v-pills-modules" role="tabpanel">
                      <h5 class="font-weight-bold text-dark mb-4">Modules Guide</h5>

                      <div class="accordion" id="modulesAccordion">
                        <div class="card border mb-2 shadow-none rounded">
                          <div class="card-header bg-white p-0" id="headingOne">
                            <h2 class="mb-0">
                              <button
                                class="btn btn-link btn-block text-left font-weight-bold text-dark text-decoration-none p-3"
                                type="button" data-toggle="collapse" data-target="#collapseOne">
                                <i class="fas fa-tachometer-alt text-primary mr-2"
                                  style="width: 24px; text-align: center;"></i> Dashboard Overview
                              </button>
                            </h2>
                          </div>
                          <div id="collapseOne" class="collapse show" data-parent="#modulesAccordion">
                            <div class="card-body text-muted border-top" style="line-height: 1.6; background: #fafafa;">
                              The <strong>Dashboard</strong> provides a high-level overview of your work day. It
                              includes a live clock for punching in/out, your attendance stats, upcoming holidays, and
                              birthdays. For admins, it shows company-wide metrics like total employees and pending
                              leaves.
                            </div>
                          </div>
                        </div>

                        <div class="card border mb-2 shadow-none rounded">
                          <div class="card-header bg-white p-0" id="headingTwo">
                            <h2 class="mb-0">
                              <button
                                class="btn btn-link btn-block text-left font-weight-bold text-dark text-decoration-none p-3 collapsed"
                                type="button" data-toggle="collapse" data-target="#collapseTwo">
                                <i class="fas fa-calendar-minus text-success mr-2"
                                  style="width: 24px; text-align: center;"></i> Leave Management
                              </button>
                            </h2>
                          </div>
                          <div id="collapseTwo" class="collapse" data-parent="#modulesAccordion">
                            <div class="card-body text-muted border-top" style="line-height: 1.6; background: #fafafa;">
                              Apply for leaves, view your leave balances, and track the status of your past requests.
                              Managers can use the Leave Overview module to approve or reject team requests.
                            </div>
                          </div>
                        </div>

                        <div class="card border mb-2 shadow-none rounded">
                          <div class="card-header bg-white p-0" id="headingThree">
                            <h2 class="mb-0">
                              <button
                                class="btn btn-link btn-block text-left font-weight-bold text-dark text-decoration-none p-3 collapsed"
                                type="button" data-toggle="collapse" data-target="#collapseThree">
                                <i class="fas fa-file-invoice-dollar text-warning mr-2"
                                  style="width: 24px; text-align: center;"></i> Payroll & Salary
                              </button>
                            </h2>
                          </div>
                          <div id="collapseThree" class="collapse" data-parent="#modulesAccordion">
                            <div class="card-body text-muted border-top" style="line-height: 1.6; background: #fafafa;">
                              View your Salary Breakdown, download Monthly Payslips, and check your Year-to-Date (YTD)
                              summaries. Sensitive information is masked by default and can be toggled via the "Show
                              Values" button.
                            </div>
                          </div>
                        </div>

                        <div class="card border mb-2 shadow-none rounded">
                          <div class="card-header bg-white p-0" id="headingFour">
                            <h2 class="mb-0">
                              <button
                                class="btn btn-link btn-block text-left font-weight-bold text-dark text-decoration-none p-3 collapsed"
                                type="button" data-toggle="collapse" data-target="#collapseFour">
                                <i class="fas fa-paper-plane text-danger mr-2"
                                  style="width: 24px; text-align: center;"></i> Team Requests
                              </button>
                            </h2>
                          </div>
                          <div id="collapseFour" class="collapse" data-parent="#modulesAccordion">
                            <div class="card-body text-muted border-top" style="line-height: 1.6; background: #fafafa;">
                              Need an IT asset? Want to update your profile? Use the Requests module to raise tickets to
                              HR, IT, or your manager and track their resolution status.
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <!-- FAQs -->
                    <div class="tab-pane fade" id="v-pills-faq" role="tabpanel">
                      <h5 class="font-weight-bold text-dark mb-4">Frequently Asked Questions</h5>

                      <div class="mb-4 pb-3 border-bottom">
                        <h6 class="font-weight-bold text-primary mb-2">Q: How do I mark my attendance?</h6>
                        <p class="text-muted small mb-0" style="font-size: 13px;">Go to your Dashboard and click the
                          green "PUNCH IN" button to start your shift. When you're done for the day, click "PUNCH OUT".
                        </p>
                      </div>
                      <div class="mb-4 pb-3 border-bottom">
                        <h6 class="font-weight-bold text-primary mb-2">Q: Why are my salary values showing as "***"?
                        </h6>
                        <p class="text-muted small mb-0" style="font-size: 13px;">For your privacy, financial data is
                          masked by default. Click the "Show Values" button with the eye icon on the Payroll page to
                          reveal your salary details.</p>
                      </div>
                      <div class="mb-4">
                        <h6 class="font-weight-bold text-primary mb-2">Q: How do I apply for a Half-Day leave?</h6>
                        <p class="text-muted small mb-0" style="font-size: 13px;">Navigate to "My Leave", click "Apply
                          Leave", and select "Half Day" under the duration dropdown. Specify whether it's the First Half
                          or Second Half.</p>
                      </div>
                    </div>

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