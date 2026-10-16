<?php
$uri = service('uri');
$currentUri = uri_string();
?>
<style>
  :root {
    --pr-navy: #0f172a;
    --pr-blue: #2563eb;
    --pr-blue-light: #eff6ff;
    --pr-indigo: #4f46e5;
    --pr-emerald: #10b981;
    --pr-amber: #f59e0b;
    --pr-slate: #64748b;
    --pr-border: #e2e8f0;
  }
  .payroll-nav-card {
    background: #ffffff;
    border: 1px solid var(--pr-border);
    border-radius: 14px;
    padding: 8px 14px;
    margin-bottom: 22px;
    box-shadow: 0 2px 6px -1px rgba(0,0,0,0.05);
  }
  .payroll-nav-pills {
    display: flex;
    align-items: center;
    gap: 8px;
    flex-wrap: nowrap;
    overflow-x: auto;
    padding: 4px 2px;
    scrollbar-width: thin;
  }
  .payroll-nav-pills::-webkit-scrollbar {
    height: 4px;
  }
  .payroll-nav-pills::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 4px;
  }
  .payroll-nav-link {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 16px;
    border-radius: 10px;
    font-size: 13px;
    font-weight: 600;
    color: #475569;
    background: #f8fafc;
    border: 1px solid transparent;
    text-decoration: none !important;
    white-space: nowrap;
    transition: all 0.2s ease;
  }
  .payroll-nav-link:hover {
    background: #f1f5f9;
    color: #1e293b;
    transform: translateY(-1px);
  }
  .payroll-nav-link.active {
    background: linear-gradient(135deg, #1e40af, #2563eb);
    color: #ffffff !important;
    box-shadow: 0 4px 10px rgba(37, 99, 235, 0.25);
  }
  .payroll-nav-link.active i {
    color: #93c5fd;
  }
  .payroll-cycle-badge {
    margin-left: auto;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 12px;
    font-weight: 600;
    padding: 6px 14px;
    border-radius: 20px;
    background: #f1f5f9;
    color: #334155;
    border: 1px solid #e2e8f0;
    white-space: nowrap;
  }
</style>

<div class="payroll-nav-card">
  <div class="payroll-nav-pills">
    <a href="<?= base_url('admin/payroll') ?>" 
       class="payroll-nav-link <?= ($currentUri === 'admin/payroll' || $currentUri === 'admin/payroll/') ? 'active' : '' ?>">
      <i class="fas fa-chart-pie"></i>
      <span>1. Dashboard</span>
    </a>

    <a href="<?= base_url('admin/payroll_attendance') ?>" 
       class="payroll-nav-link <?= ($currentUri === 'admin/payroll_attendance') ? 'active' : '' ?>">
      <i class="fas fa-user-clock"></i>
      <span>2. Attendance Summary</span>
    </a>

    <a href="<?= base_url('admin/payroll/components') ?>" 
       class="payroll-nav-link <?= (strpos($currentUri, 'admin/payroll/components') === 0) ? 'active' : '' ?>">
      <i class="fas fa-cubes"></i>
      <span>3. Salary Components</span>
    </a>

    <a href="<?= base_url('admin/payroll/structures') ?>" 
       class="payroll-nav-link <?= (strpos($currentUri, 'admin/payroll/structures') === 0) ? 'active' : '' ?>">
      <i class="fas fa-id-card-alt"></i>
      <span>4. Salary Structures</span>
    </a>

    <a href="<?= base_url('admin/payroll/runs') ?>" 
       class="payroll-nav-link <?= (strpos($currentUri, 'admin/payroll/run') === 0 || $currentUri === 'admin/payroll/runs') ? 'active' : '' ?>">
      <i class="fas fa-cogs"></i>
      <span>5. Processing & Runs</span>
    </a>

    <a href="<?= base_url('admin/payroll/payslips') ?>" 
       class="payroll-nav-link <?= (strpos($currentUri, 'admin/payroll/payslip') === 0) ? 'active' : '' ?>">
      <i class="fas fa-file-invoice-dollar"></i>
      <span>6. Payslip Center</span>
    </a>

    <a href="<?= base_url('admin/payroll/reports') ?>" 
       class="payroll-nav-link <?= (strpos($currentUri, 'admin/payroll/reports') === 0) ? 'active' : '' ?>">
      <i class="fas fa-university"></i>
      <span>7. Reports & Bank</span>
    </a>

    <div class="payroll-cycle-badge d-none d-lg-inline-flex">
      <span class="badge badge-success"><i class="fas fa-check-circle mr-1"></i> Fixed 30-Day Policy</span>
      <span class="text-muted">Cycle: 25th - 24th</span>
    </div>
  </div>
</div>
