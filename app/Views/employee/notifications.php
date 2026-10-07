<div class="content-wrapper p-4" style="background-color: #f8fafc;">

    <!-- Alert Container -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show rounded-12 shadow-sm" role="alert">
            <i class="fas fa-check-circle mr-2"></i> <?= esc(session()->getFlashdata('success')) ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="font-weight-bold mb-1 text-dark">
                <i class="fas fa-bell mr-2 text-danger"></i> Notifications Center
            </h4>
            <p class="text-muted small mb-0">View all updates regarding your leaves, payslips, announcements, and requests</p>
        </div>
        <div>
            <button type="button" id="btnMarkAllRead" class="btn btn-outline-primary rounded-pill px-4 shadow-sm font-weight-bold">
                <i class="fas fa-check-double mr-1"></i> Mark All as Read
            </button>
        </div>
    </div>

    <!-- Category Filter Tabs -->
    <div class="mb-4">
        <div class="btn-group btn-group-toggle" data-toggle="buttons">
            <label class="btn btn-light active border px-3 py-2 rounded-left font-weight-bold notif-filter-btn" data-category="ALL">
                <input type="radio" name="options" id="filterAll" checked> All Notifications
            </label>
            <label class="btn btn-light border px-3 py-2 font-weight-bold notif-filter-btn" data-category="LEAVE">
                <input type="radio" name="options" id="filterLeaves"> <i class="fas fa-calendar-alt text-primary mr-1"></i> Leaves
            </label>
            <label class="btn btn-light border px-3 py-2 font-weight-bold notif-filter-btn" data-category="PAYSLIP">
                <input type="radio" name="options" id="filterPayslips"> <i class="fas fa-file-invoice-dollar text-success mr-1"></i> Payslips
            </label>
            <label class="btn btn-light border px-3 py-2 font-weight-bold notif-filter-btn" data-category="ANNOUNCEMENT">
                <input type="radio" name="options" id="filterAnnouncements"> <i class="fas fa-bullhorn text-warning mr-1"></i> Announcements
            </label>
            <label class="btn btn-light border px-3 py-2 rounded-right font-weight-bold notif-filter-btn" data-category="REQUEST">
                <input type="radio" name="options" id="filterRequests"> <i class="fas fa-tasks text-purple mr-1"></i> Requests
            </label>
        </div>
    </div>

    <!-- Notifications List Container -->
    <div class="row">
        <div class="col-12">
            <?php if (!empty($notifications)): ?>
                <div class="list-group shadow-sm border-0 rounded-16" id="notifContainer">
                    <?php foreach ($notifications as $notif): ?>
                        <?php 
                            $isRead = (int)($notif['is_read'] ?? 0) === 1;
                            $cat = esc($notif['category'] ?? 'GENERAL');
                            
                            $badgeClass = 'badge-secondary';
                            $iconClass  = 'fas fa-info-circle text-info';
                            if ($cat === 'LEAVE') {
                                $badgeClass = 'badge-primary';
                                $iconClass  = 'fas fa-calendar-alt text-primary';
                            } elseif ($cat === 'PAYSLIP') {
                                $badgeClass = 'badge-success';
                                $iconClass  = 'fas fa-file-invoice-dollar text-success';
                            } elseif ($cat === 'ANNOUNCEMENT') {
                                $badgeClass = 'badge-warning text-dark';
                                $iconClass  = 'fas fa-bullhorn text-warning';
                            } elseif ($cat === 'REQUEST') {
                                $badgeClass = 'badge-info';
                                $iconClass  = 'fas fa-tasks text-info';
                            }
                        ?>
                        <div class="list-group-item list-group-item-action p-3 mb-2 rounded-16 border notif-card <?= $isRead ? 'bg-white text-muted' : 'bg-light font-weight-normal border-primary' ?>"
                             data-category="<?= $cat ?>"
                             data-read="<?= $isRead ? '1' : '0' ?>"
                             id="notif-item-<?= esc($notif['notification_id']) ?>"
                             style="transition: all 0.3s ease; border-radius: 16px;">
                            
                            <div class="d-flex w-100 justify-content-between align-items-center mb-2">
                                <div class="d-flex align-items-center">
                                    <div class="icon-box mr-3 p-2 bg-white rounded-circle shadow-sm" style="width: 40px; height: 40px; text-align: center; line-height: 24px;">
                                        <i class="<?= $iconClass ?> fa-lg"></i>
                                    </div>
                                    <div>
                                        <span class="badge <?= $badgeClass ?> px-2 py-1 mb-1" style="font-size: 11px; font-weight: 600;">
                                            <?= $cat ?>
                                        </span>
                                        <h6 class="mb-0 font-weight-bold text-dark notif-title">
                                            <?= esc($notif['title']) ?>
                                        </h6>
                                    </div>
                                </div>

                                <div class="text-right">
                                    <small class="text-muted d-block mb-1">
                                        <i class="far fa-clock mr-1"></i> <?= esc($notif['created_at']) ?>
                                    </small>
                                    <span class="badge badge-pill <?= $isRead ? 'badge-light border text-muted' : 'badge-danger' ?> notif-status-badge">
                                        <?= $isRead ? 'Read' : 'Unread' ?>
                                    </span>
                                </div>
                            </div>

                            <p class="mb-2 text-secondary px-1" style="font-size: 13.5px; line-height: 1.5;">
                                <?= esc($notif['message']) ?>
                            </p>

                            <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                                <small class="text-muted">
                                    <i class="fas fa-user-circle mr-1"></i> Sender: <strong><?= esc($notif['sender_name'] ?? 'System') ?></strong>
                                </small>
                                <div class="action-box">
                                    <?php if (!$isRead): ?>
                                        <button type="button" class="btn btn-sm btn-outline-success rounded-pill px-3 btn-mark-single-read" data-id="<?= esc($notif['notification_id']) ?>">
                                            <i class="fas fa-check mr-1"></i> Mark as Read
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="card card-bloom text-center py-5 shadow-sm">
                    <div class="card-body">
                        <i class="fas fa-bell-slash fa-3x text-muted mb-3"></i>
                        <h5 class="font-weight-bold text-dark">No Notifications Found</h5>
                        <p class="text-muted">You have no active notifications at this time.</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    // Filter functionality
    const filterBtns = document.querySelectorAll('.notif-filter-btn');
    const cards = document.querySelectorAll('.notif-card');

    filterBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            filterBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');

            const selectedCat = this.getAttribute('data-category');

            cards.forEach(card => {
                const cardCat = card.getAttribute('data-category');
                if (selectedCat === 'ALL' || cardCat === selectedCat) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });

    function markCardAsRead(cardItem) {
        if (!cardItem) return;
        cardItem.setAttribute('data-read', '1');
        cardItem.classList.remove('bg-light', 'border-primary');
        cardItem.classList.add('bg-white', 'text-muted');
        
        const badge = cardItem.querySelector('.notif-status-badge');
        if (badge) {
            badge.className = 'badge badge-pill badge-light border text-muted notif-status-badge';
            badge.innerText = 'Read';
        }
        
        const actionBox = cardItem.querySelector('.action-box');
        if (actionBox) {
            actionBox.innerHTML = '';
        }
    }

    // Mark single as read via AJAX (NO DELETE, Keep element visible and update state)
    document.querySelectorAll('.btn-mark-single-read').forEach(btn => {
        btn.addEventListener('click', function() {
            const notifId = this.getAttribute('data-id');
            const cardItem = document.getElementById('notif-item-' + notifId);

            const formData = new FormData();
            formData.append('notification_id', notifId);

            fetch('<?= base_url("notifications/mark_read") ?>', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'Y') {
                    markCardAsRead(cardItem);
                    // Refresh top navbar badge
                    if (typeof loadHeaderNotifications === 'function') {
                        loadHeaderNotifications();
                    }
                }
            })
            .catch(err => console.error("Error marking read:", err));
        });
    });

    // Mark All as Read via AJAX
    const btnMarkAll = document.getElementById('btnMarkAllRead');
    if (btnMarkAll) {
        btnMarkAll.addEventListener('click', function() {
            const formData = new FormData();
            formData.append('notification_id', '0');

            fetch('<?= base_url("notifications/mark_read") ?>', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'Y') {
                    document.querySelectorAll('.notif-card').forEach(card => {
                        markCardAsRead(card);
                    });
                    if (typeof loadHeaderNotifications === 'function') {
                        loadHeaderNotifications();
                    }
                }
            })
            .catch(err => console.error("Error marking all read:", err));
        });
    }
});
</script>
