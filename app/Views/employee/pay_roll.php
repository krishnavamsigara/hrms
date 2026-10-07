<!DOCTYPE html>
<html lang="en" style="height: 100%; overflow: hidden;">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bloom Solution | Payroll</title>
  <link rel="icon" type="image/jpeg" href="<?= base_url('public/dist/img/bloom.jpg') ?>">

  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">

  <style>
   :root {
  --bloom-purple: #4a00e0;
  --bloom-dark: #120038;
  --bloom-bg: #f8fafc;

  --sidebar-bg: #111c43;
  --bloom-blue: #4a8cff;
  --bloom-orange: #ff7a45;

  --text-dark: #1e293b;
  --text-muted: #64748b;
  --border-color: #e2e8f0;

  --card-bg: #ffffff;
  --soft-purple: #eef2ff;
  --soft-red: #fff1f2;
}

    body {
  font-family: 'Plus Jakarta Sans', sans-serif;
  background-color: var(--bloom-bg);
  color: var(--text-dark);
  font-size: 13px;
  height: 100%;
  overflow: hidden;
}

    .wrapper {
      height: 100vh;
      display: flex;
      flex-direction: column;
    }

     .main-header {
  border-bottom: 1px solid var(--border-color) !important;
  background: rgba(255, 255, 255, 0.85) !important;
  backdrop-filter: blur(10px);
}

    .main-sidebar {
      background: var(--mtn-deep) !important;
      box-shadow: 4px 0 10px rgba(0, 0, 0, 0.03) !important;
    }

    .custom-brand {
      display: flex;
      align-items: center;
      padding: 12px 16px;
      border-bottom: 1px solid rgba(255, 255, 255, 0.08);
    }

    .logo-circle {
      width: 42px;
      height: 42px;
      border-radius: 50%;
      object-fit: cover;
      border: 2px solid #fff;
      margin-right: 10px;
    }

    .brand-text {
      font-size: 18px;
      font-weight: 700;
    }

    .brand-blue {
      color: #4a8cff;
    }

    .brand-orange {
      color: #ff7a45;
    }

    .content-wrapper {
      background: var(--bloom-bg) !important;
      height: calc(100vh - 57px - 50px) !important;
      overflow: hidden !important;
      display: flex;
      flex-direction: column;
      padding: 15px !important;
    }

    .container-fluid {
      display: flex;
      flex-direction: column;
      height: 100%;
      gap: 15px;
    }

    .row-flex {
      display: flex;
      flex: 1;
      gap: 15px;
      min-height: 0;
    }

    .p-card {
      background: #fff;
      border-radius: 20px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.02);
      padding: 20px;
      display: flex;
      flex-direction: column;
    }

    .scroll-area {
      flex: 1;
      overflow-y: auto;
      padding-right: 5px;
    }

    .scroll-area::-webkit-scrollbar {
      width: 5px;
    }

    .scroll-area::-webkit-scrollbar-thumb {
      background: #e2e8f0;
      border-radius: 10px;
    }

    .section-label {
      color: var(--bloom-purple);
      font-weight: 800;
      font-size: 11px;
      text-transform: uppercase;
      margin-bottom: 15px;
      display: block;
      border-left: 4px solid var(--bloom-purple);
      padding-left: 12px;
    }

    .table td {
      padding: 12px 8px;
      vertical-align: middle;
    }

    .text-val {
      font-weight: 600;
      color: #1e293b;
    }

    /* Payslip Row Styling */
    .payslip-row {
      display: flex;
      align-items: center;
      justify-content: space-between;
      background: #f8fafc;
      border: 1px solid #f1f5f9;
      padding: 12px;
      border-radius: 12px;
      margin-bottom: 10px;
    }

    .pdf-box {
      width: 35px;
      height: 35px;
      background: #fff1f2;
      color: #e11d48;
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-right: 12px;
      font-size: 16px;
    }

    /* Button Styles */
    .btn-action-group {
      display: flex;
      gap: 8px;
    }

    .btn-view {
      background: #eef2ff;
      color: var(--bloom-purple);
      border: 1px solid #e2e8f0;
      font-weight: 700;
      border-radius: 8px;
      padding: 6px 10px;
      font-size: 11px;
      transition: all 0.2s;
    }

    .btn-view:hover {
      background: #e0e7ff;
      color: #3a00b0;
    }

    .btn-download {
      background: var(--bloom-purple);
      color: #fff;
      border: none;
      font-weight: 700;
      border-radius: 8px;
      padding: 6px 10px;
      font-size: 11px;
      transition: all 0.2s;
    }

    .btn-download:hover {
      background: #3a00b0;
      transform: translateY(-1px);
    }

    .total-ctc-box h2 {
      font-weight: 800;
      color: var(--bloom-dark);
      font-size: 28px;
      margin: 0;
    }

    .main-footer {
      background: #fff !important;
      border-top: 1px solid #e2e8f0 !important;
      color: #64748b;
      font-size: 12px;
      padding: 1rem 1.5rem !important;
    }

    /* Custom Tabs Styling */
    .custom-tabs-wrapper {
      width: 100%;
      overflow-x: auto;
      -webkit-overflow-scrolling: touch;
      border-bottom: 1px solid #e2e8f0;
      margin-bottom: 15px;
    }

    .custom-tabs-wrapper::-webkit-scrollbar {
      display: none;
    }

    .custom-tabs {
      border-bottom: none;
      flex-wrap: nowrap;
      margin-bottom: -1px;
    }

    .custom-tabs .nav-item {
      margin-bottom: 0;
    }

    .custom-tabs .nav-link {
      color: #64748b;
      border: none;
      border-bottom: 3px solid transparent;
      font-weight: 500;
      padding: 12px 24px;
      white-space: nowrap;
      transition: all 0.3s ease;
      background: transparent;
      font-size: 14px;
    }

    .custom-tabs .nav-link:hover {
      color: #1e293b;
      border-color: transparent;
    }

    .custom-tabs .nav-link.active {
      color: #1e293b;
      font-weight: 700;
      border-color: transparent transparent #0052cc transparent;
      background: transparent;
    }

    .tab-content {
      flex: 1;
      min-height: 0;
      display: flex;
      flex-direction: column;
    }

    .tab-pane {
      height: 100%;
      flex: 1;
      width: 100%;
    }

    .tab-pane.active {
      display: flex;
      flex-direction: column;
    }

    .tab-pane.fade {
      display: none;
    }

    .tab-pane.fade.show.active {
      display: flex !important;
    }

    /* =========================================
   MOBILE RESPONSIVENESS
   ========================================= */

@media (max-width: 767.98px) {

  /* Prevent the page from becoming wider than the screen */
  html,
  body {
    width: 100%;
    max-width: 100%;
    overflow-x: hidden !important;
  }

  /* Main content */
  .content-wrapper {
    height: calc(100vh - 57px) !important;
    padding: 10px !important;
    overflow: hidden !important;
  }

  .container-fluid {
    width: 100% !important;
    padding: 0 !important;
    gap: 10px !important;
  }

  /* =========================================
     ANNUAL CTC CARD
     ========================================= */

  .p-card {
    border-radius: 14px !important;
    padding: 14px !important;
  }

  .p-card.flex-row {
    flex-direction: column !important;
    align-items: flex-start !important;
    gap: 12px;
  }

  .p-card.flex-row .total-ctc-box {
    width: 100%;
    text-align: left !important;
  }

  .p-card.flex-row h5 {
    font-size: 15px !important;
  }

  .p-card.flex-row p {
    font-size: 10px !important;
    line-height: 1.5;
  }

  .total-ctc-box h2 {
    font-size: 23px !important;
  }

  /* Show / Hide Values button */
  #maskToggle {
    font-size: 9px !important;
    padding: 4px 9px !important;
  }

  /* =========================================
     PAYROLL TABS
     ========================================= */

  .custom-tabs-wrapper {
    width: 100% !important;
    overflow-x: auto !important;
    overflow-y: hidden !important;
    margin-bottom: 10px !important;
    flex-shrink: 0 !important;
    -webkit-overflow-scrolling: touch;
  }

  .custom-tabs {
    display: flex !important;
    flex-wrap: nowrap !important;
    width: max-content !important;
    min-width: 100%;
  }

  .custom-tabs .nav-item {
    flex: 0 0 auto !important;
  }

  .custom-tabs .nav-link {
    padding: 9px 14px !important;
    font-size: 11px !important;
    white-space: nowrap !important;
  }

  /* Hide scrollbar */
  .custom-tabs-wrapper::-webkit-scrollbar {
    display: none;
  }

  .custom-tabs-wrapper {
    scrollbar-width: none;
  }

  /* =========================================
     TAB CONTENT
     ========================================= */

  .tab-content {
    width: 100% !important;
    min-width: 0 !important;
  }

  .tab-pane {
    width: 100% !important;
    min-width: 0 !important;
  }

  /* =========================================
     PAYSLIP CARD
     ========================================= */

  #payslips .p-card {
    padding: 12px !important;
    border-radius: 14px !important;
  }

  /* Payslip Vault + filters */
  #payslips .d-flex.justify-content-between {
    flex-direction: column !important;
    align-items: stretch !important;
    gap: 10px !important;
  }

  .section-label {
    font-size: 10px !important;
    margin-bottom: 0 !important;
  }

  /* Filter container */
  #payslips .d-flex[style*="gap:10px"] {
    width: 100% !important;
    display: flex !important;
    gap: 7px !important;
  }

  #monthFilter,
  #yearFilter {
    width: 50% !important;
    height: 34px !important;
    font-size: 10px !important;
  }

  /* =========================================
     PAYSLIP LIST
     ========================================= */

  .scroll-area {
    width: 100% !important;
    min-width: 0 !important;
    padding-right: 0 !important;
    overflow-y: auto !important;
  }

  .payslip-row {
    width: 100% !important;
    min-width: 0 !important;
    padding: 10px !important;
    border-radius: 10px !important;
    margin-bottom: 8px !important;
  }

  .pdf-box {
    width: 32px !important;
    height: 32px !important;
    min-width: 32px !important;
    margin-right: 9px !important;
    border-radius: 8px !important;
    font-size: 14px !important;
  }

  .payslip-row p {
    font-size: 11px !important;
    line-height: 1.4;
  }

  /* View button */
  .btn-action-group {
    gap: 5px !important;
    flex-shrink: 0;
  }

  .btn-view {
    padding: 6px 9px !important;
    font-size: 10px !important;
    border-radius: 7px !important;
  }

  /* =========================================
     COMING SOON TABS
     ========================================= */

  #breakdown .p-card,
  #ytd .p-card {
    padding: 20px 12px !important;
    border-radius: 14px !important;
  }

  #breakdown .fa-4x,
  #ytd .fa-4x {
    font-size: 35px !important;
  }

  #breakdown h3,
  #ytd h3 {
    font-size: 18px !important;
  }

  #breakdown p,
  #ytd p {
    font-size: 11px !important;
  }

  /* =========================================
     ALERT
     ========================================= */

  #payslips .alert {
    font-size: 10px !important;
    padding: 9px 35px 9px 10px !important;
    margin-bottom: 10px !important;
  }
}

  </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <div class="content-wrapper">
      <div class="container-fluid">

        <!-- Annual CTC Card -->
        <div class="p-card flex-row justify-content-between align-items-center" style="flex: 0 0 auto;">
          <div>
            <div class="d-flex align-items-center mb-1">
              <h5 class="font-weight-bold mb-0 mr-3">Annual CTC Overview</h5>
              <button id="maskToggle" class="btn btn-sm btn-light border"
                style="border-radius: 20px; font-weight: 600; font-size: 11px; padding: 2px 10px;"
                onclick="toggleMask()">
                <i class="fas fa-eye"></i> Show Values
              </button>
            </div>
            <p class="text-muted mb-0 small">Compensation breakdown for
              <?= esc($selectedYear ?? date('Y') . '-' . substr(date('Y') + 1, -2)); ?>
            </p>
          </div>

          <div class="total-ctc-box text-right">
            <?php
            $fmt = new NumberFormatter('en_IN', NumberFormatter::DECIMAL);
            $annualCTC = ($displayMonthlyCTC ?? 0) * 12;
            ?>
            <h2>
              ₹ <span class="maskable" data-value="<?= esc($fmt->format($annualCTC)); ?>">***</span>
            </h2>
          </div>
        </div>

        <!-- Navigation Tabs -->
        <div class="custom-tabs-wrapper" style="flex: 0 0 auto;">
          <ul class="nav nav-tabs custom-tabs" id="payrollTabs" role="tablist">
            <li class="nav-item" role="presentation">
              <a class="nav-link" id="breakdown-tab" data-toggle="tab" href="#breakdown" role="tab"
                aria-controls="breakdown" aria-selected="false">
                Salary Breakdown
              </a>
            </li>
            <li class="nav-item" role="presentation">
              <a class="nav-link active" id="payslips-tab" data-toggle="tab" href="#payslips" role="tab"
                aria-controls="payslips" aria-selected="true">
                Payslips
              </a>
            </li>
            <li class="nav-item" role="presentation">
              <a class="nav-link" id="ytd-tab" data-toggle="tab" href="#ytd" role="tab" aria-controls="ytd"
                aria-selected="false">
                Year-to-Date (YTD)
              </a>
            </li>
          </ul>
        </div>

        <!-- Tab Contents -->
        <div class="tab-content" id="payrollTabsContent">

          <!-- Salary Breakdown Tab -->
          <div class="tab-pane fade" id="breakdown" role="tabpanel" aria-labelledby="breakdown-tab">
            <div class="p-card h-100 d-flex justify-content-center align-items-center">
              <div class="text-center">
                <i class="fas fa-tools fa-4x mb-3" style="color: var(--bloom-purple);"></i>
                <h3 class="font-weight-bold">Coming Soon</h3>
                <p class="text-muted">Salary Breakdown will be available soon.</p>
              </div>
            </div>
          </div>

          <!-- Payslips Tab -->
          <div class="tab-pane fade show active" id="payslips" role="tabpanel" aria-labelledby="payslips-tab">
            <div class="p-card h-100 flex-fill">

              <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-warning alert-dismissible fade show">
                  <i class="fas fa-exclamation-circle"></i>
                  <?= esc(session()->getFlashdata('error')); ?>
                  <button type="button" class="close" data-dismiss="alert">
                    <span>&times;</span>
                  </button>
                </div>
              <?php endif; ?>

              <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="section-label mb-0">Payslip Vault</span>

                <div class="d-flex" style="gap:10px;">
                  <!-- Month Filter -->
                  <select id="monthFilter" class="custom-select custom-select-sm"
                    style="width:130px; border-radius:8px; font-weight:600;">
                    <option value="ALL" <?= ($selectedMonth == 'ALL') ? 'selected' : '' ?>>All</option>
                    <?php
                    $months = [
                      "January",
                      "February",
                      "March",
                      "April",
                      "May",
                      "June",
                      "July",
                      "August",
                      "September",
                      "October",
                      "November",
                      "December"
                    ];
                    foreach ($months as $month) {
                      ?>
                      <option value="<?= esc($month) ?>" <?= ($selectedMonth == $month) ? 'selected' : '' ?>>
                        <?= esc($month) ?>
                      </option>
                    <?php } ?>
                  </select>

                  <!-- Year Filter -->
                  <select id="yearFilter" class="custom-select custom-select-sm"
                    style="width:120px; border-radius:8px; font-weight:600;">
                    <?php
                    $currentYear = date('Y');
                    for ($i = 0; $i < 5; $i++) {
                      $startYear = $currentYear - $i;
                      $endYear = substr($startYear + 1, -2);
                      $value = $startYear . '-' . $endYear;
                      ?>
                      <option value="<?= esc($value) ?>" <?= ($selectedYear == $value) ? 'selected' : '' ?>>
                        <?= esc($value) ?>
                      </option>
                    <?php } ?>
                  </select>
                </div>
              </div>

              <!-- Payslips List Area -->
              <div class="scroll-area">
                <?php if (!empty($error)): ?>
                  <div class="alert alert-warning text-center">
                    <?= esc($error) ?>
                  </div>
                <?php elseif (!empty($content)): ?>
                  <?php foreach ($content as $row): ?>
                    <div class="payslip-row" data-month="<?= esc($row['month'] ?? ''); ?>">
                      <div class="d-flex align-items-center">
                        <div class="pdf-box">
                          <i class="fas fa-file-pdf"></i>
                        </div>
                        <div>
                          <p class="mb-0 font-weight-bold">
                            <?= esc($row['month'] ?? '') ?>         <?= esc($row['year'] ?? '') ?>
                          </p>
                        </div>
                      </div>

                      <div class="btn-action-group">
                        <a href="<?= base_url(
                          'employee/new_emp_payslip/'
                          . esc($row['emp_id'] ?? '0') . '/'
                          . esc($row['month'] ?? '0') . '/'
                          . esc($row['year'] ?? '0')
                        ) ?>" class="btn-view" title="View Payslip">
                          <i class="fas fa-eye"></i>
                        </a>
                      </div>
                    </div>
                  <?php endforeach; ?>
                <?php else: ?>
                  <div class="text-center text-muted mt-4">
                    No Payslips Available
                  </div>
                <?php endif; ?>
              </div>

            </div>
          </div>

          <!-- YTD Tab -->
          <div class="tab-pane fade" id="ytd" role="tabpanel" aria-labelledby="ytd-tab">
            <div class="p-card h-100 d-flex justify-content-center align-items-center">
              <div class="text-center">
                <i class="fas fa-tools fa-4x mb-3" style="color: var(--bloom-purple);"></i>
                <h3 class="font-weight-bold mb-2" style="color:#1e293b;">Coming Soon</h3>
                <p class="text-muted mb-0" style="font-size:15px;">
                  Year-to-Date (YTD) summary will be available soon.
                </p>
              </div>
            </div>
          </div>

        </div>

      </div>
    </div>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

  <script>
    let isMasked = true;

    function toggleMask() {
      isMasked = !isMasked;
      const maskables = document.querySelectorAll('.maskable');
      const toggleBtn = document.getElementById('maskToggle');

      if (isMasked) {
        maskables.forEach(el => el.textContent = '***');
        toggleBtn.innerHTML = '<i class="fas fa-eye"></i> Show Values';
      } else {
        maskables.forEach(el => el.textContent = el.getAttribute('data-value'));
        toggleBtn.innerHTML = '<i class="fas fa-eye-slash"></i> Hide Values';
      }
    }

    // Filter Change Handler (server-side query update)
    $('#monthFilter, #yearFilter').on('change', function () {
      var month = $('#monthFilter').val();
      var year = $('#yearFilter').val();

      window.location.href =
        "<?= base_url('employee/pay_roll'); ?>?month=" +
        encodeURIComponent(month) +
        "&year=" +
        encodeURIComponent(year);
    });
  </script>
</body>

</html>