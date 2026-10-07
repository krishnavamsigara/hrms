<div class="content-wrapper" style="min-height: 800px; padding: 20px; background-color: #f4f6f9;">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-3 align-items-center">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark font-weight-bold">
                        <i class="fas fa-sliders-h text-info mr-2"></i>SMTP Configuration
                    </h1>
                    <p class="text-muted small mb-0">Configure primary SMTP credentials used by the system to dispatch emails.</p>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="<?= base_url('admin/mail/compose') ?>" class="btn btn-primary btn-sm rounded-pill px-3 mr-1 font-weight-bold">
                        <i class="fas fa-pen mr-1"></i> Compose Mail
                    </a>
                    <a href="<?= base_url('admin/mail/logs') ?>" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                        <i class="fas fa-history mr-1"></i> Sent Logs
                    </a>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <!-- Notifications -->
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                    <i class="fas fa-check-circle mr-2"></i><?= session()->getFlashdata('success') ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                    <i class="fas fa-exclamation-triangle mr-2"></i><?= session()->getFlashdata('error') ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
            <?php endif; ?>

            <div class="row">
                <!-- SMTP Settings Card -->
                <div class="col-md-7">
                    <div class="card card-info card-outline shadow-sm border-0 rounded-lg">
                        <div class="card-header bg-white border-bottom">
                            <h5 class="m-0 font-weight-bold text-dark"><i class="fas fa-server text-info mr-2"></i>SMTP Server Settings</h5>
                        </div>
                        <form action="<?= base_url('admin/mail/save_settings') ?>" method="POST">
                            <div class="card-body p-4">
                                <div class="row">
                                    <div class="col-md-8 form-group">
                                        <label class="font-weight-bold">SMTP Host Server <span class="text-danger">*</span></label>
                                        <input type="text" name="smtp_host" class="form-control" placeholder="e.g. smtp.gmail.com or mail.yourdomain.com" value="<?= htmlspecialchars($settings['smtp_host'] ?? '') ?>" required>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label class="font-weight-bold">SMTP Port <span class="text-danger">*</span></label>
                                        <input type="number" name="smtp_port" class="form-control" placeholder="587 or 465" value="<?= htmlspecialchars($settings['smtp_port'] ?? '587') ?>" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label class="font-weight-bold">SMTP Username / Email</label>
                                        <input type="text" name="smtp_user" class="form-control" placeholder="user@gmail.com" value="<?= htmlspecialchars($settings['smtp_user'] ?? '') ?>">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="font-weight-bold">SMTP Password / App Password</label>
                                        <input type="password" name="smtp_pass" class="form-control" placeholder="••••••••••••" value="<?= htmlspecialchars($settings['smtp_pass'] ?? '') ?>">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label class="font-weight-bold">Encryption Protocol</label>
                                        <select name="smtp_crypto" class="form-control">
                                            <option value="tls" <?= (($settings['smtp_crypto'] ?? 'tls') === 'tls') ? 'selected' : '' ?>>TLS (Port 587)</option>
                                            <option value="ssl" <?= (($settings['smtp_crypto'] ?? '') === 'ssl') ? 'selected' : '' ?>>SSL (Port 465)</option>
                                            <option value="" <?= (empty($settings['smtp_crypto'])) ? 'selected' : '' ?>>None (Port 25)</option>
                                        </select>
                                    </div>
                                </div>

                                <hr>
                                <h6 class="font-weight-bold text-secondary mb-3"><i class="fas fa-id-card mr-1"></i> Sender Defaults</h6>

                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label class="font-weight-bold">Default Sender Email</label>
                                        <input type="email" name="from_email" class="form-control" placeholder="noreply@bloom.com" value="<?= htmlspecialchars($settings['from_email'] ?? '') ?>">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="font-weight-bold">Default Sender Name</label>
                                        <input type="text" name="from_name" class="form-control" placeholder="Bloom HRMS Admin" value="<?= htmlspecialchars($settings['from_name'] ?? 'Bloom HRMS') ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer bg-light text-right p-3">
                                <button type="submit" class="btn btn-info px-4 font-weight-bold rounded-pill text-white">
                                    <i class="fas fa-save mr-1"></i> Save Settings
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Test Connection Card -->
                <div class="col-md-5">
                    <div class="card card-secondary card-outline shadow-sm border-0 rounded-lg">
                        <div class="card-header bg-white border-bottom">
                            <h5 class="m-0 font-weight-bold text-dark"><i class="fas fa-vial text-warning mr-2"></i>Test SMTP Connection</h5>
                        </div>
                        <form action="<?= base_url('admin/mail/test_smtp') ?>" method="POST">
                            <!-- Pass current values as test -->
                            <input type="hidden" name="smtp_host" value="<?= htmlspecialchars($settings['smtp_host'] ?? '') ?>">
                            <input type="hidden" name="smtp_port" value="<?= htmlspecialchars($settings['smtp_port'] ?? '587') ?>">
                            <input type="hidden" name="smtp_user" value="<?= htmlspecialchars($settings['smtp_user'] ?? '') ?>">
                            <input type="hidden" name="smtp_pass" value="<?= htmlspecialchars($settings['smtp_pass'] ?? '') ?>">
                            <input type="hidden" name="smtp_crypto" value="<?= htmlspecialchars($settings['smtp_crypto'] ?? 'tls') ?>">
                            <input type="hidden" name="from_email" value="<?= htmlspecialchars($settings['from_email'] ?? '') ?>">
                            <input type="hidden" name="from_name" value="<?= htmlspecialchars($settings['from_name'] ?? 'Bloom Test') ?>">

                            <div class="card-body p-4">
                                <p class="text-muted small">Verify your SMTP server credentials by sending a test email to your inbox.</p>
                                <div class="form-group">
                                    <label class="font-weight-bold">Test Recipient Email <span class="text-danger">*</span></label>
                                    <input type="email" name="test_email" class="form-control" placeholder="your-email@gmail.com" required>
                                </div>
                            </div>
                            <div class="card-footer bg-light text-right p-3">
                                <button type="submit" class="btn btn-outline-dark font-weight-bold rounded-pill px-4">
                                    <i class="fas fa-paper-plane mr-1"></i> Send Test Email
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Helpful Tips Card -->
                    <div class="card bg-light border-0 shadow-sm rounded-lg mt-3">
                        <div class="card-body p-3">
                            <h6 class="font-weight-bold text-primary"><i class="fas fa-lightbulb mr-1"></i> Common Tips for Gmail & Outlook</h6>
                            <ul class="small text-muted mb-0 pl-3">
                                <li>For Gmail, use <code>smtp.gmail.com</code> with port <code>587</code> (TLS).</li>
                                <li>Use a Gmail <strong>App Password</strong> if 2-Factor Authentication is active.</li>
                                <li>For Outlook/Office365, host is <code>smtp.office365.com</code> port <code>587</code>.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
