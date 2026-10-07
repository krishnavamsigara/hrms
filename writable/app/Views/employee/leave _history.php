<!-- <!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>BloomHR | Leave History</title>

  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

  <style>
    :root {
      --bloom-purple: #4a00e0;
      --bloom-dark: #2a0080;
      --mtn-deep: #120038;
      --bloom-orange: #e46c44;
      --bloom-success: #10b981;
      --bloom-danger: #dc2626;
      --glass: rgba(255, 255, 255, 0.95);
    }

    /* --- GLOBAL --- */
    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      background-color: #f8fafc;
      font-size: 13px;
      color: #334155;
    }

    /* --- NAVIGATION & SIDEBAR --- */
    .main-header {
      border-bottom: 1px solid #e2e8f0 !important;
      background: var(--glass) !important;
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

    /* --- CARDS & TABLES --- */
    .card-bloom {
      border: 1px solid #e2e8f0 !important;
      border-radius: 20px !important;
      background: #fff;
      box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05) !important;
      overflow: hidden;
    }

    .table thead th {
      background: #f8fafc;
      border-top: none;
      border-bottom: 1px solid #e2e8f0;
      text-transform: uppercase;
      font-size: 11px;
      letter-spacing: 0.5px;
      color: #64748b;
      padding: 15px;
    }

    .table td {
      vertical-align: middle !important;
      border-top: 1px solid #f1f5f9;
      padding: 15px;
    }

    /* --- STATUS BADGES --- */
    .badge-status {
      padding: 6px 12px;
      border-radius: 10px;
      font-weight: 700;
      font-size: 11px;
      display: inline-block;
    }

    .bg-approved {
      background: #ecfdf5;
      color: #10b981;
    }

    .bg-pending {
      background: #fff7ed;
      color: #ea580c;
    }

    .bg-rejected {
      background: #fef2f2;
      color: #ef4444;
    }

    /* --- BUTTONS --- */
    .btn-bloom-grad {
      background: linear-gradient(135deg, var(--bloom-purple) 0%, var(--bloom-dark) 100%);
      color: #fff !important;
      border: none;
      border-radius: 12px;
      font-weight: 700;
      padding: 10px 20px;
      font-size: 12px;
      transition: 0.3s;
    }

    .btn-bloom-grad:hover {
      transform: translateY(-1px);
      opacity: 0.9;
    }

    .btn-action {
      width: 34px;
      height: 34px;
      border-radius: 10px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      border: 1px solid #e2e8f0;
      background: #fff;
      color: #64748b;
      transition: 0.2s;
      cursor: pointer;
      margin-left: 4px;
    }

    .btn-action:hover {
      border-color: var(--bloom-purple);
      color: var(--bloom-purple);
      background: #f8faff;
      transform: translateY(-2px);
    }

    .btn-action.delete:hover {
      border-color: var(--bloom-danger);
      color: var(--bloom-danger);
      background: #fff1f2;
    }

    .form-control-bloom {
      border-radius: 12px;
      border: 1px solid #e2e8f0;
      font-size: 12px;
      height: auto;
      padding: 10px 15px;
    }

    /* --- FOOTER --- */
    .main-footer {
      background: #fff !important;
      border-top: 1px solid #e2e8f0 !important;
      color: #64748b;
      font-size: 12px;
      padding: 1rem 1.5rem !important;
    }

    .footer-dot {
      display: inline-block;
      width: 4px;
      height: 4px;
      background: #cbd5e1;
      border-radius: 50%;
      margin: 0 8px;
      vertical-align: middle;
    }

    .footer-link {
      color: var(--bloom-purple);
      font-weight: 600;
      text-decoration: none;
    }
  </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

    <nav class="main-header navbar navbar-expand navbar-white navbar-light shadow-sm">
      <ul class="navbar-nav align-items-center">
        <li class="nav-item"><a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a></li>
        <li class="nav-item d-none d-sm-inline-block ml-2">
          <h5 class="mb-0 font-weight-bold" style="color: var(--mtn-deep);">Hello, <span
              style="color: var(--bloom-purple);">Ishu</span> 👋</h5>
        </li>
      </ul>

      <ul class="navbar-nav ml-auto align-items-center">
        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#"><i class="far fa-comments"></i><span
              class="badge badge-danger navbar-badge">3</span></a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right shadow">
            <a href="#" class="dropdown-item">
              <div class="media">
                <img src="https://ui-avatars.com/api/?name=Rahul" class="img-size-40 mr-3 img-circle">
                <div class="media-body">
                  <h3 class="dropdown-item-title">Rahul <span class="float-right text-sm text-danger"><i
                        class="fas fa-star"></i></span></h3>
                  <p class="text-sm">Leave approved 👍</p>
                  <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 5 mins</p>
                </div>
              </div>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
          </div>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#"><i class="far fa-bell"></i><span
              class="badge badge-warning navbar-badge">2</span></a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right shadow">
            <span class="dropdown-header">2 Notifications</span>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item"><i class="fas fa-user-clock mr-2 text-primary"></i> New Request <span
                class="float-right text-muted text-sm">10m</span></a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item dropdown-footer">See All</a>
          </div>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link d-flex align-items-center" data-toggle="dropdown" href="#">
            <img src="https://ui-avatars.com/api/?name=Aishwarya&background=4a00e0&color=fff"
              class="rounded-circle shadow-sm" style="width: 32px; border: 2px solid #fff;">
            <span class="ml-2 d-none d-sm-inline-block font-weight-bold text-dark">Aishwarya</span>
          </a>
          <div class="dropdown-menu dropdown-menu-right border-0 shadow-lg mt-2" style="border-radius:12px;">
            <a href="profile.html" class="dropdown-item"><i class="fas fa-user mr-2"></i> Profile</a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item text-danger"><i class="fas fa-power-off mr-2"></i> Logout</a>
          </div>
        </li>
      </ul>
    </nav>


    <aside class="main-sidebar sidebar-dark-primary elevation-0">

      <a href="#" class="brand-link custom-brand">
        <img src="../dist/img/bloom.jpg" alt="Bloom Logo" class="brand-image logo-circle">
        <span class="brand-text">
          <span class="brand-blue">Bloom</span>
          <span class="brand-orange">Solutions</span>
        </span>
      </a>

      <div class="sidebar">
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

            <li class="nav-item">
              <a href="dashboard.html" class="nav-link">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>Dashboard</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="calender.html" class="nav-link">
                <i class="nav-icon fas fa-calendar-alt"></i>
                <p>My Calendar</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="team.html" class="nav-link">
                <i class="nav-icon fas fa-user-friends"></i>
                <p>My Team</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="my_attendance.html" class="nav-link">
                <i class="nav-icon fas fa-user-check"></i>
                <p>My Attendance</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="apply_leave1.html" class="nav-link active">
                <i class="nav-icon fas fa-calendar-minus"></i>
                <p>My Leave</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="pay_roll.html" class="nav-link">
                <i class="nav-icon fas fa-file-invoice-dollar"></i>
                <p>My Salary</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="requests.html" class="nav-link">
                <i class="nav-icon fas fa-paper-plane"></i>
                <p>My Requests</p>
              </a>
            </li>


          </ul>
        </nav>
      </div>
    </aside>

    <div class="content-wrapper">
      <section class="content pt-4">
        <div class="container-fluid">

          <div class="row mb-4">
            <div class="col-12">
              <div class="card-bloom p-4">
                <div class="row align-items-end">
                  <div class="col-md-3">
                    <label class="small font-weight-bold text-muted">Type</label>
                    <select class="form-control form-control-bloom">
                      <option>All Leaves</option>
                    </select>
                  </div>
                  <div class="col-md-3">
                    <label class="small font-weight-bold text-muted">Status</label>
                    <select class="form-control form-control-bloom">
                      <option>All Status</option>
                    </select>
                  </div>
                  <div class="col-md-4">
                    <label class="small font-weight-bold text-muted">Search</label>
                    <input type="text" class="form-control form-control-bloom" placeholder="Keywords...">
                  </div>
                  <div class="col-md-2">
                    <button class="btn btn-bloom-grad btn-block mt-2">SEARCH</button>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-12">
              <div class="card card-bloom">
                <div class="card-body p-0">
                  <div class="table-responsive">
                    <table class="table mb-0">
                      <thead>
                        <tr>
                          <th>Applied On</th>
                          <th>Leave Dates</th>
                          <th>Type</th>
                          <th>Reason</th>
                          <th>Status</th>
                          <th class="text-right">Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td class="font-weight-bold text-muted">02 Apr 2026</td>
                          <td>
                            <div class="font-weight-bold">Apr 10 - Apr 12</div><small class="text-muted">3 Days</small>
                          </td>
                          <td><span class="font-weight-bold text-primary">Annual Leave</span></td>
                          <td class="text-muted">Family function</td>
                          <td><span class="badge-status bg-approved">Approved</span></td>
                          <td class="text-right">
                            <button class="btn-action" onclick="viewLeave('Apr 10-12', 'Annual', 'Approved')"
                              title="View"><i class="fas fa-eye"></i></button>
                            <button class="btn-action text-info" onclick="downloadLeave('L-8821')" title="Download"><i
                                class="fas fa-file-download"></i></button>
                          </td>
                        </tr>
                        <tr>
                          <td class="font-weight-bold text-muted">28 Mar 2026</td>
                          <td>
                            <div class="font-weight-bold">Apr 05 - Apr 05</div><small class="text-muted">1 Day</small>
                          </td>
                          <td><span class="font-weight-bold text-warning">Casual Leave</span></td>
                          <td class="text-muted">Personal work</td>
                          <td><span class="badge-status bg-pending">Pending</span></td>
                          <td class="text-right">
                            <button class="btn-action text-primary" onclick="editLeave('Personal work')" title="Edit"><i
                                class="fas fa-edit"></i></button>
                            <button class="btn-action delete" onclick="deleteLeave(this)" title="Cancel"><i
                                class="fas fa-trash-alt"></i></button>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>

    <footer class="main-footer">
      <div class="d-flex align-items-center">
        <strong>Copyright &copy; 2026 <a href="#" class="footer-link ml-1">Bloom Solutions</a></strong>
        <span class="footer-dot"></span><span>All rights reserved.</span>
      </div>
    </footer>
  </div>

  <div class="modal fade" id="viewModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content card-bloom p-3">
        <div class="modal-header border-0">
          <h5 class="font-weight-bold">Leave Summary</h5><button type="button" class="close"
            data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <div class="p-3 rounded bg-light">
            <p class="mb-1 small text-muted">Dates</p>
            <h6 id="v-period" class="font-weight-bold"></h6>
            <hr>
            <p class="mb-1 small text-muted">Category</p>
            <h6 id="v-type" class="font-weight-bold text-primary"></h6>
            <hr>
            <p class="mb-1 small text-muted">Status</p><span id="v-status" class="badge-status bg-approved"></span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content card-bloom p-3">
        <div class="modal-header border-0">
          <h5 class="font-weight-bold">Update Request</h5><button type="button" class="close"
            data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body"><label class="small font-weight-bold">Modify Reason</label><textarea id="editReason"
            class="form-control form-control-bloom" rows="3"></textarea><button
            class="btn btn-bloom-grad btn-block mt-3" onclick="saveEdit()">UPDATE</button></div>
      </div>
    </div>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script>
    function viewLeave(period, type, status) {
      $('#v-period').text(period); $('#v-type').text(type); $('#v-status').text(status);
      $('#viewModal').modal('show');
    }
    function downloadLeave(id) {
      Swal.fire({ title: 'Processing...', text: 'Downloading ' + id, icon: 'info', timer: 1500, showConfirmButton: false, didOpen: () => Swal.showLoading() }).then(() => Swal.fire('Success', 'PDF Downloaded', 'success'));
    }
    function editLeave(reason) {
      $('#editReason').val(reason); $('#editModal').modal('show');
    }
    function saveEdit() {
      $('#editModal').modal('hide'); Swal.fire('Saved', 'Request updated', 'success');
    }
    function deleteLeave(btn) {
      Swal.fire({ title: 'Cancel Leave?', text: "You can't undo this!", icon: 'warning', showCancelButton: true, confirmButtonColor: '#4a00e0', confirmButtonText: 'Yes, Cancel it' }).then((r) => {
        if (r.isConfirmed) { $(btn).closest('tr').fadeOut(400); Swal.fire('Deleted', 'Request removed', 'success'); }
      });
    }
    $(function () { $('[title]').tooltip(); });
  </script>
</body>

</html> -->



<?php 
$leave = $leave[0] ?? []; 
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>BloomHR | Apply Leave</title>

  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

  <style>
    :root {
      --bloom-purple: #4a00e0;
      --bloom-dark: #2a0080;
      --mtn-deep: #120038;
      --bloom-success: #10b981;
      --glass: rgba(255, 255, 255, 0.95);
    }

    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      background-color: #f8fafc;
      font-size: 13px;
      color: #334155;
    }

    /* --- LAYOUT --- */
    .main-header {
      border-bottom: 1px solid #e2e8f0 !important;
      background: var(--glass) !important;
      backdrop-filter: blur(10px);
    }

    .main-sidebar {
      background: var(--mtn-deep) !important;
    }

    .nav-link.active {
      background: var(--bloom-purple) !important;
      box-shadow: 0 4px 15px rgba(74, 0, 224, 0.3);
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
      border: 2px solid #fff;
      margin-right: 10px;
    }

    .brand-blue {
      color: #4a8cff;
      font-weight: 700;
    }

    .brand-orange {
      color: #ff7a45;
      font-weight: 700;
    }

    /* --- LEAVE FORM STYLES --- */
    .leave-card {
      background: #fff;
      border-radius: 24px;
      padding: 30px;
      border: 1px solid #e2e8f0;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.02);
      height: 100%;
    }

    .balance-pill {
      background: #f8fafc;
      border: 1px solid #e2e8f0;
      border-radius: 15px;
      padding: 15px;
      text-align: center;
      transition: 0.3s;
    }

    .balance-pill:hover {
      border-color: var(--bloom-purple);
      background: #fff;
    }

    .form-control-bloom {
      border-radius: 12px;
      border: 1px solid #e2e8f0;
      padding: 12px 15px;
      height: auto;
      font-size: 13px;
      font-weight: 500;
      transition: 0.3s;
    }

    .form-control-bloom:focus {
      border-color: var(--bloom-purple);
      box-shadow: 0 0 0 4px rgba(74, 0, 224, 0.05);
    }

    .section-head {
      font-size: 11px;
      font-weight: 800;
      text-transform: uppercase;
      letter-spacing: 1.5px;
      color: var(--bloom-purple);
      margin-bottom: 20px;
      display: block;
      border-left: 3px solid var(--bloom-purple);
      padding-left: 12px;
    }

    .btn-apply {
      background: linear-gradient(135deg, var(--bloom-purple) 0%, var(--bloom-dark) 100%);
      color: #fff;
      border: none;
      border-radius: 12px;
      padding: 12px 30px;
      font-weight: 700;
      letter-spacing: 0.5px;
      transition: 0.3s;
    }

    .btn-apply:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 20px rgba(74, 0, 224, 0.2);
      color: #fff;
    }

    .main-footer {
      background: #fff !important;
      border-top: 1px solid #e2e8f0 !important;
      color: #64748b;
      font-size: 12px;
      padding: 1rem 1.5rem !important;
    }

    .footer-link {
      color: var(--bloom-purple);
      font-weight: 600;
      text-decoration: none;
    }

    /* --- ALIGNMENT FIX FOR CHECKBOX --- */
    .custom-control {
      display: flex !important;
      align-items: center !important;
      min-height: unset !important;
    }

    .custom-control-label {
      padding-top: 2px;
      cursor: pointer;
    }

    .custom-control-label::before,
    .custom-control-label::after {
      top: 0.15rem !important;
    }
  </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

    <div class="content-wrapper">
      <div class="container-fluid px-4 py-4">

        <div class="row mb-4">
          <div class="col-md-3 mb-2">
            <div class="balance-pill">
              <span class="text-muted small font-weight-bold d-block mb-1">Total Applied Leaves</span>
              <h4 class="font-weight-bold mb-0 text-primary"><?= number_format($leave['Total_leaves_applied'] ?? 0, 0) ?></h4>
            </div>
          </div>
          <div class="col-md-3 mb-2">
            <div class="balance-pill"><span class="text-muted small font-weight-bold d-block mb-1">Approved Leave</span>
              <h4 class="font-weight-bold mb-0 text-success"><?= number_format($leave['Approved_leaves'] ?? 0, 0) ?></h4>
            </div>
          </div>
          <div class="col-md-3 mb-2">
            <div class="balance-pill"><span class="text-muted small font-weight-bold d-block mb-1">Pending Leave <small>(WFH*)</small></span>
              <h4 class="font-weight-bold mb-0 text-info"><?= number_format($leave['Pending_Leaves'] ?? 0, 0) ?></h4>
            </div>
          </div>
          <div class="col-md-3 mb-2">
            <div class="balance-pill"><span class="text-muted small font-weight-bold d-block mb-1">WFH (days)</span>
              <h4 class="font-weight-bold mb-0 text-danger"> <?= number_format($leave['WFH_taken'] ?? 0, 0) ?></h4>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-8 mb-4">
            <div class="leave-card">
              <span class="section-head">New Leave Request</span>
              <form method="post" action="<?= base_url('employee/leave_apply_submit') ?>">
                <div class="row">
                  <div class="col-md-6 mb-4">
                          <label class="font-weight-bold small text-muted">Leave Type</label>

                          <select name="leave_type" class="form-control form-control-bloom">
                            <option value="">Select Type</option>

                            <?php foreach ($leavetype as $type) { ?>
                              <option value="<?= $type['leave_code'] ?>">
                                <?= $type['leave_name'] ?>
                              </option>
                            <?php } ?>

                          </select>
                        </div>
                  <div class="col-md-6 mb-4">
                    <label class="font-weight-bold small text-muted">
                        Total Leave Days
                    </label>
                    <input type="text"
                        id="total_days"
                        class="form-control form-control-bloom"
                        readonly
                        placeholder="0 Days"
                        style="background-color:#ffffff !important; color:#000000 !important; opacity:1;">
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6 mb-4"><label class="font-weight-bold small text-muted">From Date</label><input
                      type="date" name="from_date" id="from_date" class="form-control form-control-bloom bg-white" class="fas fa-calendar-alt"></div>
                  <div class="col-md-6 mb-4"><label class="font-weight-bold small text-muted">To Date</label><input
                      type="date" name="to_date" id="to_date" class="form-control form-control-bloom bg-white" class="fas fa-calendar-alt"></div>
                </div>
                <div class="mb-4"><label class="font-weight-bold small text-muted">Reason</label><textarea
                   name="reason" class="form-control form-control-bloom" rows="4" placeholder="Description..."></textarea></div>
                <div class="d-flex align-items-center justify-content-between mt-2">
                  <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="urgentCheck">
                  </div>
                  <div class="d-flex" style="gap: 10px;">
                    <a href="<?= base_url('employee/leave_history') ?>" class="btn btn-outline-secondary"
                style="border-radius: 12px; font-weight: 700; font-size: 13px; padding: 12px 20px; border-color: #e2e8f0;">
                <i class="fas fa-history mr-1"></i> View History
              </a>
                    <button type="submit" class="btn btn-apply">Submit Application</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
          <div class="col-lg-4 mb-4">
            <div class="info-card bg-white p-4 h-100" style="border-radius:24px; border: 1px solid #e2e8f0;">
              <span class="section-head">Leave Utilization</span>

              <div class="mt-4">
                
                <?php 
                  $personalBal = $leave['Personal_leaves_bal'] ?? 12;
                  $personalTotal = 12;
                  $personalPct = ($personalBal / $personalTotal) * 100;
                ?>
                <div class="mb-4">
                  <div class="d-flex justify-content-between align-items-center mb-1">
                    <h6 class="mb-0 font-weight-bold" style="font-size:13px;">Personal Leave</h6>
                    <span class="small font-weight-bold text-muted"><?= number_format($personalBal, 0) ?> / <?= $personalTotal ?> Days</span>
                  </div>
                  <div class="progress shadow-sm" style="height: 8px; border-radius: 10px; background-color: #f1f5f9;">
                    <div class="progress-bar" role="progressbar"
                      style="width: <?= $personalPct ?>%; background-color: #0ea5e9; border-radius: 10px;" 
                      aria-valuenow="<?= $personalPct ?>"
                      aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                </div>

                <?php 
                  $sickBal = $leave['sick_leavs_bal'] ?? 10;
                  $sickTotal = 10;
                  $sickPct = ($sickBal / $sickTotal) * 100;
                ?>
                <div class="mb-4">
                  <div class="d-flex justify-content-between align-items-center mb-1">
                    <h6 class="mb-0 font-weight-bold" style="font-size:13px;">Sick Leave</h6>
                    <span class="small font-weight-bold text-muted"><?= number_format($sickBal, 0) ?> / <?= $sickTotal ?> Days</span>
                  </div>
                  <div class="progress shadow-sm" style="height: 8px; border-radius: 10px; background-color: #f1f5f9;">
                    <div class="progress-bar" role="progressbar"
                      style="width: <?= $sickPct ?>%; background-color: var(--bloom-success); border-radius: 10px;"
                      aria-valuenow="<?= $sickPct ?>" 
                      aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                </div>

                <?php 
                  $maternityBal = $leave['maternity_bal'] ?? 180;
                  $maternityTotal = 180;
                  $maternityPct = ($maternityBal / $maternityTotal) * 100;
                ?>
                <div class="mb-4">
                  <div class="d-flex justify-content-between align-items-center mb-1">
                    <h6 class="mb-0 font-weight-bold" style="font-size:13px;">Maternity Leave</h6>
                    <span class="small font-weight-bold text-muted"><?= number_format($maternityBal, 0) ?> / <?= $maternityTotal ?> Days</span>
                  </div>
                  <div class="progress shadow-sm" style="height: 8px; border-radius: 10px; background-color: #f1f5f9;">
                    <div class="progress-bar" role="progressbar"
                      style="width: <?= $maternityPct ?>%; background-color: #f59e0b; border-radius: 10px;" 
                      aria-valuenow="<?= $maternityPct ?>"
                      aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                </div>

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
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

  <div id="toastMessage" style="
  position: fixed;
  top: 20px;
  right: 20px;
  z-index: 99999;
  display: none;
  color: #fff;
  padding: 12px 18px;
  border-radius: 8px;
  font-size: 13px;
  box-shadow: 0 4px 10px rgba(0,0,0,0.2);
">
</div>
  
<script>
const holidays = <?= json_encode($holiday); ?>;

const holidayMap = {};

holidays.forEach(h => {
    holidayMap[h.holiday_date] = h.holiday_type;
});

const today = new Date().toISOString().split('T')[0];

// FROM DATE
flatpickr("#from_date", {
    dateFormat: "Y-m-d",
    onDayCreate: function(_, __, fp, dayElem) {

        const date = fp.formatDate(dayElem.dateObj, "Y-m-d");
        const day = dayElem.dateObj.getDay();

        if (date === today) {
            dayElem.style.background = "#ffe066";
        }

        if (day === 0) {
            dayElem.style.background = "#d1d5db";
        }

        if (holidayMap[date]) {
            dayElem.style.background = "#ef4444";
            dayElem.style.color = "#fff";
        }
    }
});

// TO DATE
flatpickr("#to_date", {
    dateFormat: "Y-m-d",
    onDayCreate: function(_, __, fp, dayElem) {

        const date = fp.formatDate(dayElem.dateObj, "Y-m-d");
        const day = dayElem.dateObj.getDay();

        if (date === today) {
            dayElem.style.background = "#ffe066";
        }

        if (day === 0) {
            dayElem.style.background = "#d1d5db";
        }

        if (holidayMap[date]) {
            dayElem.style.background = "#ef4444";
            dayElem.style.color = "#fff";
        }
    }
});
</script>

<?php if (session()->getFlashdata('status')) : ?>
<script>
  const toast = document.getElementById("toastMessage");
  
  // Fetch status and remarks from session
  const status = "<?= session()->getFlashdata('status'); ?>";
  const remarks = "<?= session()->getFlashdata('remarks'); ?>";
  
  // Apply text to the toast
  toast.innerText = remarks;
  
  // Set background color based on status
  if (status === 'Y') {
      toast.style.background = "#10b981"; // Success Green
  } else if (status === 'N') {
      toast.style.background = "#ef4444"; // Error Red
  } else {
      toast.style.background = "#3b82f6"; // Default Blue just in case
  }

  // Display the toast
  toast.style.display = "block";

  // Hide after 3.5 seconds
  setTimeout(() => {
    toast.style.display = "none";
  }, 3500);
</script>
<?php endif; ?>

<script>
function calculateLeaveDays() {

    let fromDate = document.getElementById('from_date').value;
    let toDate   = document.getElementById('to_date').value;

    if (fromDate && toDate) {

        let start = new Date(fromDate);
        let end   = new Date(toDate);

        // Validation for backwards dates
        if (end < start) {
            document.getElementById('total_days').value = 'Invalid Date Range';
            return;
        }

        let workingDays = 0;
        let currentDate = new Date(start);

        // Iterate through each date from start to end
        while (currentDate <= end) {
            let dayOfWeek = currentDate.getDay();
            
            // Format currentDate to match DB holiday 'YYYY-MM-DD'
            let yyyy = currentDate.getFullYear();
            let mm = String(currentDate.getMonth() + 1).padStart(2, '0');
            let dd = String(currentDate.getDate()).padStart(2, '0');
            let formattedDate = `${yyyy}-${mm}-${dd}`;

            // Check if it's NOT Sunday (0) AND NOT a holiday in the map
            if (dayOfWeek !== 0 && !holidayMap[formattedDate]) {
                workingDays++;
            }

            // Move to the next day
            currentDate.setDate(currentDate.getDate() + 1);
        }

        document.getElementById('total_days').value = workingDays + ' Day(s)';
    }
}

document.getElementById('from_date').addEventListener('change', calculateLeaveDays);
document.getElementById('to_date').addEventListener('change', calculateLeaveDays);
</script>
</body>

</html>