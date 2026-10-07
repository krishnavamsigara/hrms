<div class="content-wrapper" style="min-height: 800px; padding: 20px; background-color: #f4f6f9;">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-3 align-items-center">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark font-weight-bold">
                        <i class="fas fa-history text-secondary mr-2"></i>Email Dispatch Logs
                    </h1>
                    <p class="text-muted small mb-0">Track history and delivery statuses of all outgoing emails.</p>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="<?= base_url('admin/mail/compose') ?>" class="btn btn-primary btn-sm rounded-pill px-3 mr-1 font-weight-bold">
                        <i class="fas fa-pen mr-1"></i> Compose New Mail
                    </a>
                    <a href="<?= base_url('admin/mail/settings') ?>" class="btn btn-outline-info btn-sm rounded-pill px-3">
                        <i class="fas fa-cog mr-1"></i> SMTP Settings
                    </a>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <!-- Flash Notifications -->
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                    <i class="fas fa-check-circle mr-2"></i><?= session()->getFlashdata('success') ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
            <?php endif; ?>

            <div class="card shadow-sm border-0 rounded-lg">
                <div class="card-header bg-white d-flex align-items-center justify-content-between p-3 border-bottom">
                    <h5 class="m-0 font-weight-bold text-dark"><i class="fas fa-list-alt text-muted mr-2"></i>Sent Messages Log</h5>
                    <div>
                        <a href="<?= base_url('admin/mail/logs?category=all') ?>" class="btn btn-sm <?= ($selected_category == 'all') ? 'btn-secondary font-weight-bold' : 'btn-outline-secondary' ?> mr-1">All</a>
                        <a href="<?= base_url('admin/mail/logs?category=offer_letter') ?>" class="btn btn-sm <?= ($selected_category == 'offer_letter') ? 'btn-primary font-weight-bold' : 'btn-outline-primary' ?> mr-1">Offer Letters</a>
                        <a href="<?= base_url('admin/mail/logs?category=meet_invite') ?>" class="btn btn-sm <?= ($selected_category == 'meet_invite') ? 'btn-success font-weight-bold' : 'btn-outline-success' ?> mr-1">Meet Invites</a>
                        <a href="<?= base_url('admin/mail/logs?category=custom') ?>" class="btn btn-sm <?= ($selected_category == 'custom') ? 'btn-info font-weight-bold' : 'btn-outline-info' ?>">General Mails</a>
                    </div>
                </div>

                <div class="card-body p-0 table-responsive">
                    <table class="table table-hover table-striped align-middle mb-0">
                        <thead class="bg-light text-uppercase text-secondary small font-weight-bold">
                            <tr>
                                <th style="width: 60px;" class="text-center">#</th>
                                <th>Date & Time</th>
                                <th>Category</th>
                                <th>Recipient</th>
                                <th>Subject</th>
                                <th class="text-center">Status</th>
                                <th>Sent By</th>
                                <th class="text-center" style="width: 100px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($logs)): ?>
                                <?php foreach ($logs as $index => $log): ?>
                                    <tr>
                                        <td class="text-center font-weight-bold text-muted"><?= $index + 1 ?></td>
                                        <td class="small text-nowrap"><?= date('d M Y, h:i A', strtotime($log['created_at'])) ?></td>
                                        <td>
                                            <?php if ($log['category'] === 'offer_letter'): ?>
                                                <span class="badge badge-primary px-2 py-1"><i class="fas fa-file-contract mr-1"></i> Offer Letter</span>
                                            <?php elseif ($log['category'] === 'meet_invite'): ?>
                                                <span class="badge badge-success px-2 py-1"><i class="fas fa-video mr-1"></i> Meet Invite</span>
                                            <?php else: ?>
                                                <span class="badge badge-info px-2 py-1"><i class="fas fa-envelope mr-1"></i> General</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="font-weight-bold text-dark"><?= htmlspecialchars($log['recipient_name'] ?: 'N/A') ?></div>
                                            <small class="text-muted"><?= htmlspecialchars($log['recipient_email']) ?></small>
                                        </td>
                                        <td class="text-truncate" style="max-width: 260px;" title="<?= htmlspecialchars($log['subject']) ?>">
                                            <?= htmlspecialchars($log['subject']) ?>
                                            <?php if ($log['attachment']): ?>
                                                <br><small class="text-info"><i class="fas fa-paperclip"></i> <?= htmlspecialchars($log['attachment']) ?></small>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <?php if ($log['status'] === 'sent'): ?>
                                                <span class="badge badge-success px-3 py-1 rounded-pill"><i class="fas fa-check-circle mr-1"></i> Sent</span>
                                            <?php else: ?>
                                                <span class="badge badge-danger px-3 py-1 rounded-pill" title="<?= htmlspecialchars($log['error_message'] ?? '') ?>">
                                                    <i class="fas fa-times-circle mr-1"></i> Failed
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="small text-muted"><?= htmlspecialchars($log['sent_by'] ?? 'Admin') ?></td>
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-outline-primary" onclick="viewLogModal(<?= $log['id'] ?>)">
                                                <i class="fas fa-eye"></i> View
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8" class="text-center py-5 text-muted">
                                        <i class="fas fa-inbox fa-3x mb-3 text-secondary"></i>
                                        <p class="mb-0 font-weight-bold">No mail dispatch logs recorded yet.</p>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal to Inspect Sent Email -->
<div class="modal fade" id="logDetailModal" tabindex="-1" role="dialog" aria-labelledby="logModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content shadow-lg border-0">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title font-weight-bold" id="logModalLabel"><i class="fas fa-envelope-open-text mr-2"></i>Email Log Details</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <div class="row mb-3 bg-light p-3 rounded">
                    <div class="col-md-6">
                        <small class="text-muted text-uppercase d-block">Recipient</small>
                        <strong id="modalRecipient"></strong>
                    </div>
                    <div class="col-md-6">
                        <small class="text-muted text-uppercase d-block">Sent Time</small>
                        <strong id="modalTime"></strong>
                    </div>
                </div>
                <div class="mb-3">
                    <small class="text-muted text-uppercase d-block">Subject</small>
                    <div id="modalSubject" class="font-weight-bold h6 text-primary"></div>
                </div>

                <div id="modalErrorContainer" class="alert alert-danger d-none mb-3">
                    <strong>Delivery Error:</strong> <span id="modalErrorText"></span>
                </div>

                <label class="font-weight-bold">Message Content Preview:</label>
                <div id="modalBody" class="border p-3 rounded bg-white" style="max-height: 350px; overflow-y: auto;">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary rounded-pill px-4" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
function viewLogModal(id) {
    fetch('<?= base_url('admin/mail/view_log') ?>/' + id)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                alert(data.error);
                return;
            }
            document.getElementById('modalRecipient').innerText = (data.recipient_name || '') + ' (' + data.recipient_email + ')';
            document.getElementById('modalTime').innerText = data.created_at;
            document.getElementById('modalSubject').innerText = data.subject;
            document.getElementById('modalBody').innerHTML = data.message_body || '<em>No HTML content recorded</em>';

            var errContainer = document.getElementById('modalErrorContainer');
            if (data.status === 'failed' && data.error_message) {
                document.getElementById('modalErrorText').innerText = data.error_message;
                errContainer.classList.remove('d-none');
            } else {
                errContainer.classList.add('d-none');
            }

            $('#logDetailModal').modal('show');
        })
        .catch(err => alert('Failed to fetch log details: ' + err));
}
</script>
