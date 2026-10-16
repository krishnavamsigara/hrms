<?php
$h = $payslip['header'];
$earnings = $payslip['earnings'];
$deductions = $payslip['deductions'];
$contribs = $payslip['employer_contributions'];

$monthName = date('F', mktime(0, 0, 0, (int)$h['payroll_month'], 10, (int)$h['payroll_year']));
?>
<style>
  @media print {
    .main-sidebar, .main-header, .content-header, .no-print, .payroll-nav-card, footer {
      display: none !important;
    }
    .content-wrapper {
      margin: 0 !important;
      padding: 0 !important;
      background: #ffffff !important;
    }
    .payslip-container {
      box-shadow: none !important;
      border: 1px solid #cbd5e1 !important;
      margin: 0 auto !important;
      width: 100% !important;
      max-width: 100% !important;
      page-break-after: always;
    }
  }

  .payslip-container {
    max-width: 900px;
    margin: 20px auto;
    background: #ffffff;
    border-radius: 12px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 4px 15px rgba(0,0,0,0.06);
    padding: 32px 36px;
    font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    color: #1e293b;
  }

  .payslip-header-border {
    border-bottom: 2px solid #2563eb;
    padding-bottom: 18px;
    margin-bottom: 20px;
  }

  .payslip-table th, .payslip-table td {
    padding: 8px 12px;
    font-size: 12.5px;
  }

  .payslip-table th {
    background: #f8fafc;
    color: #475569;
    font-weight: 700;
    text-transform: uppercase;
    font-size: 11px;
    letter-spacing: 0.5px;
  }

  .payslip-net-box {
    background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
    border: 1px solid #bfdbfe;
    border-radius: 10px;
    padding: 16px 20px;
    margin: 20px 0;
  }
</style>

<div class="content-wrapper" style="min-height: 800px; padding: 20px 24px;">
  
  <!-- Action Bar (Hidden on print) -->
  <div class="no-print d-flex justify-content-between align-items-center mb-3" style="max-width: 900px; margin: 0 auto 16px auto;">
    <a href="<?= base_url('admin/payroll/payslips') ?>" class="btn btn-sm btn-light border font-weight-bold" style="border-radius: 6px;">
      <i class="fas fa-arrow-left mr-1"></i> Back to Payslips
    </a>
    <div class="btn-group">
      <button type="button" class="btn btn-sm btn-primary px-3 shadow-sm font-weight-bold" onclick="window.print();" style="border-radius: 6px;">
        <i class="fas fa-print mr-1"></i> Print / Save as PDF
      </button>
    </div>
  </div>

  <!-- Executive Payslip Document Container -->
  <div class="payslip-container">
    
    <!-- Top Header: Company Brand & Address -->
    <div class="payslip-header-border">
      <div class="row align-items-center">
        <div class="col-8">
          <div class="d-flex align-items-center">
            <?php if (!empty($h['logo_url'])): ?>
              <img src="<?= base_url($h['logo_url']) ?>" alt="Logo" style="height: 48px; object-fit: contain; margin-right: 14px; border-radius: 6px;">
            <?php endif; ?>
            <div>
              <h3 class="m-0 font-weight-bold text-dark" style="font-size: 20px; letter-spacing: -0.02em;">
                <?= esc($h['company_name']) ?>
              </h3>
              <p class="text-muted small mb-0 mt-1" style="line-height: 1.4;">
                <?= esc($h['company_address']) ?><br>
                <?= esc($h['city']) ?>, <?= esc($h['state']) ?> - <?= esc($h['pincode']) ?>
              </p>
            </div>
          </div>
        </div>
        <div class="col-4 text-right">
          <div class="badge badge-light border text-dark px-3 py-2" style="font-size: 13px; border-radius: 8px;">
            <div class="text-uppercase text-muted" style="font-size: 10px; font-weight: 700; letter-spacing: 0.5px;">Payslip Number</div>
            <div class="font-weight-bold text-primary"><?= esc($h['payslip_number']) ?></div>
          </div>
          <div class="small text-muted mt-2">
            Period: <strong><?= date('d M', strtotime($h['period_start'])) ?> - <?= date('d M Y', strtotime($h['period_end'])) ?></strong>
          </div>
        </div>
      </div>

      <!-- Statutory Metadata Strip -->
      <div class="row mt-3 pt-2 border-top text-muted" style="font-size: 11px;">
        <div class="col-3">CIN: <strong><?= esc($h['cin'] ?: 'N/A') ?></strong></div>
        <div class="col-3">PAN: <strong><?= esc($h['pan_number'] ?: 'N/A') ?></strong></div>
        <div class="col-3">TAN: <strong><?= esc($h['tan_number'] ?: 'N/A') ?></strong></div>
        <div class="col-3 text-right">GSTIN: <strong><?= esc($h['gstin'] ?: 'N/A') ?></strong></div>
      </div>
    </div>

    <!-- Document Title -->
    <div class="text-center mb-4">
      <h4 class="font-weight-bold text-dark mb-1" style="font-size: 16px; text-transform: uppercase; letter-spacing: 0.5px;">
        Salary Payslip &mdash; <?= $monthName ?> <?= $h['payroll_year'] ?>
      </h4>
      <small class="text-muted">Calculated on a fixed 30-day salary proration standard</small>
    </div>

    <!-- Employee & Attendance Info Tables -->
    <div class="row mb-3">
      <!-- Employee Profile -->
      <div class="col-md-6 mb-3 mb-md-0">
        <table class="table table-sm table-bordered mb-0" style="font-size: 12px;">
          <tbody>
            <tr>
              <th style="width: 38%; background: #f8fafc;">Employee Name</th>
              <td class="font-weight-bold text-dark"><?= esc($h['emp_name']) ?></td>
            </tr>
            <tr>
              <th style="background: #f8fafc;">Employee ID</th>
              <td class="font-weight-bold text-primary"><?= esc($h['emp_id']) ?></td>
            </tr>
            <tr>
              <th style="background: #f8fafc;">Department</th>
              <td><?= esc($h['department'] ?: 'General') ?></td>
            </tr>
            <tr>
              <th style="background: #f8fafc;">Designation</th>
              <td><?= esc($h['designation'] ?: 'Staff') ?></td>
            </tr>
            <tr>
              <th style="background: #f8fafc;">Date of Joining</th>
              <td><?= !empty($h['joining_date']) ? date('d M Y', strtotime($h['joining_date'])) : 'N/A' ?></td>
            </tr>
            <tr>
              <th style="background: #f8fafc;">PAN / UAN</th>
              <td><?= esc($h['pan'] ?: 'N/A') ?> / <?= esc($h['uan'] ?: 'N/A') ?></td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Banking & Attendance Metrics -->
      <div class="col-md-6">
        <table class="table table-sm table-bordered mb-0" style="font-size: 12px;">
          <tbody>
            <tr>
              <th style="width: 38%; background: #f8fafc;">Bank Name</th>
              <td class="font-weight-bold"><?= esc($h['bank_name'] ?: 'N/A') ?></td>
            </tr>
            <tr>
              <th style="background: #f8fafc;">Bank Account No</th>
              <td class="font-weight-bold text-dark"><?= esc($h['bank_account_no'] ?: 'N/A') ?></td>
            </tr>
            <tr>
              <th style="background: #f8fafc;">IFSC Code</th>
              <td><?= esc($h['ifsc'] ?: 'N/A') ?></td>
            </tr>
            <tr>
              <th style="background: #f8fafc;">Total Cycle Days</th>
              <td><?= (float)$h['total_days'] ?> Days</td>
            </tr>
            <tr>
              <th style="background: #f8fafc;">Paid Days</th>
              <td class="font-weight-bold text-success"><?= (float)$h['paid_days'] ?> Days</td>
            </tr>
            <tr>
              <th style="background: #f8fafc;">Loss of Pay (LOP)</th>
              <td class="font-weight-bold <?= ((float)$h['lop_days'] > 0) ? 'text-danger' : 'text-muted' ?>">
                <?= (float)$h['lop_days'] ?> Days
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Side-by-Side Earnings and Deductions Table -->
    <div class="row">
      <!-- Earnings Table -->
      <div class="col-md-6 pr-md-1">
        <table class="table table-bordered payslip-table mb-0">
          <thead>
            <tr>
              <th>Earnings Component</th>
              <th class="text-right">Fixed</th>
              <th class="text-right">LOP Loss</th>
              <th class="text-right">Payable</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($earnings as $earn): ?>
              <tr>
                <td>
                  <strong><?= esc($earn['component_name']) ?></strong>
                  <small class="text-muted d-block"><?= esc($earn['component_code']) ?></small>
                </td>
                <td class="text-right text-muted">₹<?= number_format((float)$earn['monthly_amount'], 2) ?></td>
                <td class="text-right text-danger">
                  <?= ((float)$earn['lop_amount'] > 0) ? '-₹' . number_format((float)$earn['lop_amount'], 2) : '&mdash;' ?>
                </td>
                <td class="text-right font-weight-bold text-dark">₹<?= number_format((float)$earn['payable_amount'], 2) ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
          <tfoot class="bg-light">
            <tr>
              <th colspan="3" class="text-dark font-weight-bold">Gross Earnings (A)</th>
              <th class="text-right text-primary font-weight-bold" style="font-size: 13px;">
                ₹<?= number_format((float)$h['gross_earnings'], 2) ?>
              </th>
            </tr>
          </tfoot>
        </table>
      </div>

      <!-- Deductions Table -->
      <div class="col-md-6 pl-md-1">
        <table class="table table-bordered payslip-table mb-0">
          <thead>
            <tr>
              <th>Deductions Component</th>
              <th class="text-right">Monthly</th>
              <th class="text-right">Deducted</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($deductions)): ?>
              <tr><td colspan="3" class="text-center py-3 text-muted">No deductions applicable.</td></tr>
            <?php else: ?>
              <?php foreach ($deductions as $ded): ?>
                <tr>
                  <td>
                    <strong><?= esc($ded['component_name']) ?></strong>
                    <small class="text-muted d-block"><?= esc($ded['component_code']) ?></small>
                  </td>
                  <td class="text-right text-muted">₹<?= number_format((float)$ded['monthly_amount'], 2) ?></td>
                  <td class="text-right font-weight-bold text-danger">-₹<?= number_format((float)$ded['payable_amount'], 2) ?></td>
                </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
          <tfoot class="bg-light">
            <tr>
              <th colspan="2" class="text-dark font-weight-bold">Total Deductions (B)</th>
              <th class="text-right text-danger font-weight-bold" style="font-size: 13px;">
                -₹<?= number_format((float)$h['other_deductions'], 2) ?>
              </th>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>

    <!-- Net Salary Box Callout -->
    <div class="payslip-net-box">
      <div class="row align-items-center">
        <div class="col-sm-7">
          <div class="text-uppercase text-muted font-weight-bold" style="font-size: 11px; letter-spacing: 0.5px;">Net Salary Payable (A - B)</div>
          <div class="font-weight-bold text-dark mt-1" style="font-size: 13px; font-style: italic;">
            <?= esc($netWords) ?>
          </div>
        </div>
        <div class="col-sm-5 text-sm-right mt-2 mt-sm-0">
          <div class="font-weight-bold text-primary" style="font-size: 26px; line-height: 1;">
            ₹<?= number_format((float)$h['net_salary'], 2) ?>
          </div>
          <small class="text-muted">Direct Deposit to Account Ending in ...<?= substr($h['bank_account_no'] ?? '0000', -4) ?></small>
        </div>
      </div>
    </div>

    <!-- Employer Contributions Strip -->
    <?php if (!empty($contribs)): ?>
      <div class="mb-4 p-2 rounded bg-light" style="border: 1px dashed #cbd5e1; font-size: 11.5px;">
        <span class="font-weight-bold text-muted text-uppercase mr-2">Employer Contributions (Not deducted from Take-Home):</span>
        <?php foreach ($contribs as $ec): ?>
          <span class="mr-3 text-dark">
            <strong><?= esc($ec['component_name']) ?>:</strong> ₹<?= number_format((float)$ec['payable_amount'], 2) ?>
          </span>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <!-- Footer Signatory & Disclaimer -->
    <div class="mt-4 pt-3 border-top">
      <div class="row align-items-end">
        <div class="col-7">
          <p class="text-muted small mb-0" style="font-size: 11px; line-height: 1.4;">
            <i class="fas fa-shield-alt text-success mr-1"></i> <?= esc($h['payslip_footer_disclaimer'] ?: 'This is a system generated statement, verified and approved.') ?><br>
            Generated on <?= date('d M Y, h:i A', strtotime($h['generated_at'])) ?>
          </p>
        </div>
        <div class="col-5 text-right">
          <div style="border-top: 1px solid #94a3b8; display: inline-block; padding-top: 6px; min-width: 180px;" class="text-center">
            <span class="font-weight-bold text-dark small" style="font-size: 12px;"><?= esc($h['payslip_signatory_title'] ?: 'Director / Authorized Signatory') ?></span>
            <small class="d-block text-muted" style="font-size: 10px;"><?= esc($h['company_name']) ?></small>
          </div>
        </div>
      </div>
    </div>

  </div>

</div>
