<?php
$offer_status = service('request')->getGet('offer_status') ?? 'ALL';
$onboarding_status = service('request')->getGet('onboarding_status') ?? 'ALL';
$candidate_type = service('request')->getGet('candidate_type') ?? 'ALL';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bloom Solutions | View Candidate</title>
  
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">

  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">

  <style>
    :root { 
      --bloom-purple: #4a00e0; 
      --soft-gray: #f8fafc; 
      --border-color: #e2e8f0; 
      --bloom-success: #10b981;
      --bloom-danger: #ef4444;
      --bloom-info: #0ea5e9;
    }

    body { 
      font-family: 'Plus Jakarta Sans', sans-serif; 
      background-color: var(--soft-gray); 
      font-size: 13px; 
    }

    /* Card Styling */
    .card-bloom { 
      border: 1px solid var(--border-color) !important; 
      border-radius: 20px !important; 
      background: #fff; 
      box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.04); 
      overflow: hidden;
    }

    .avatar-list { width: 38px; height: 38px; border-radius: 10px; object-fit: cover; }

    /* Status Badges */
    .status-active { color: #10b981; background: #ecfdf5; padding: 4px 10px; border-radius: 8px; font-weight: 600; font-size: 11px; }
    .status-leave { color: #d97706; background: #fef3c7; padding: 4px 10px; border-radius: 8px; font-weight: 600; font-size: 11px; }

    /* Header & Sidebar */
    .main-header { 
      border-bottom: 1px solid #e2e8f0 !important; 
      background: rgba(255, 255, 255, 0.75) !important; 
      backdrop-filter: blur(12px); 
    }
    
   .nav-pills .nav-link.active{
background:#007bff!important;
color:#fff!important;
}


    /* Action Buttons */
    .action-btn {
      width: 30px;
      height: 30px;
      padding: 0;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      border-radius: 8px !important;
      transition: all 0.2s;
      border: 1px solid var(--border-color);
      background: #fff;
    }
    .btn-view { color: var(--bloom-info); }
    .btn-edit { color: var(--bloom-purple); }
    .btn-delete { color: var(--bloom-danger); }
    
    .action-btn:hover { background: #f1f5f9; transform: translateY(-1px); }
    .btn-delete:hover { background: #fee2e2; border-color: #fecaca; }

    .employee-row:hover { background-color: #f8fafc; }

.status-green {
  background: #dcfce7;
  color: #166534;
  padding: 4px 10px;
  border-radius: 8px;
  font-weight: 600;
  font-size: 11px;
  display: inline-block;
}

.status-orange {
  background: #fef3c7;
  color: #92400e;
  padding: 4px 10px;
  border-radius: 8px;
  font-weight: 600;
  font-size: 11px;
  display: inline-block;
}

.status-red {
  background: #fee2e2;
  color: #b91c1c;
  padding: 4px 10px;
  border-radius: 8px;
  font-weight: 600;
  font-size: 11px;
  display: inline-block;
}

/* .status-gray {
  background: #e5e7eb;
  color: #6b7280;
  padding: 4px 10px;
  border-radius: 8px;
  font-weight: 600;
  font-size: 11px;
  display: inline-block;
} */

.status-gray {
  background: #dbeafe;
  color: #1d4ed8;
  padding: 4px 10px;
  border-radius: 8px;
  font-weight: 600;
  font-size: 11px;
  display: inline-block;
}

 /* Pagination Styling */
.dataTables_paginate .paginate_button {
    margin: 0 3px !important;
}

.dataTables_paginate .paginate_button .page-link,
.dataTables_paginate .page-link {
    border-radius: 10px !important;
    border: 1px solid #e2e8f0 !important;
    color: #64748b !important;
    font-weight: 600;
}

/* Active Page */
.dataTables_paginate .page-item.active .page-link {
    background: linear-gradient(135deg, #4a00e0 0%, #2a0080 100%) !important;
    border-color: #4a00e0 !important;
    color: #fff !important;
}

/* Hover */
.dataTables_paginate .page-link:hover {
    background: #f8faff !important;
    color: #4a00e0 !important;
    border-color: #4a00e0 !important;
}

/* Info Text */
.dataTables_info {
    color: #64748b !important;
    font-size: 12px;
    font-weight: 600;
    padding-left: 15px;
}
.dataTables_length {
    margin: 15px;
    font-size: 13px;
    font-weight: 600;
    color: #64748b;
}

.dataTables_length select {
    border: 1px solid #e2e8f0 !important;
    border-radius: 10px !important;
    padding: 5px 10px !important;
    background: #fff !important;
    color: #334155 !important;
    margin: 0 5px;
}


.dataTables_paginate {
    padding-right: 15px;
}

/* Keep Show Entries and Search on same row */
.dataTables_wrapper .dataTables_length {
    float: left;
    margin: 15px;
}

.dataTables_wrapper .dataTables_filter {
    float: right;
    margin: 15px;
    text-align: right;
}

.dataTables_wrapper .row:first-child {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.dataTables_wrapper .dataTables_filter input {
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    padding: 6px 10px;
    margin-left: 5px;
}

.filter-card{
    margin:20px;
    background:#fff;
    border:1px solid #e2e8f0;
    border-radius:18px;
    padding:20px;
    box-shadow:0 3px 10px rgba(0,0,0,.04);
}

.filter-title{
    font-size:16px;
    font-weight:700;
    color:#2a0080;
    margin-bottom:18px;
    display:flex;
    align-items:center;
    gap:8px;
}

.filter-title i{
    color:#4a00e0;
}

.filter-card label{
    font-size:12px;
    font-weight:700;
    color:#64748b;
    margin-bottom:6px;
}

.filter-card .form-control{
    height:42px;
    border-radius:12px;
    border:1px solid #dbe3ee;
    font-size:13px;
    box-shadow:none;
}

.filter-card .form-control:focus{
    border-color:#4a00e0;
    box-shadow:0 0 0 .15rem rgba(74,0,224,.15);
}

.btn-filter{
    background:linear-gradient(135deg,#4a00e0,#2a0080);
    color:#fff;
    border:none;
    border-radius:12px;
    height:42px;
    font-weight:600;
}

.btn-filter:hover{
    color:#fff;
    opacity:.95;
}

.btn-reset{
    border-radius:12px;
    height:42px;
    font-weight:600;
}
.filter-card{
    margin:11px;          /* instead of 20px */
    margin:10px 5px;      /* top-bottom 10px, left-right 5px */
}
/* =========================
   RESPONSIVE TEXT SIZE
========================= */

/* Normal desktop */
body {
    font-size: 13px;
}

.filter-title {
    font-size: 16px;
}

.filter-card label {
    font-size: 12px;
}

.filter-card .form-control,
.btn-filter,
.btn-reset {
    font-size: 13px;
}

table {
    font-size: 13px;
}

/* Laptop / smaller screens */
@media (max-width: 1200px) {

    body {
        font-size: 12px;
    }

    h4 {
        font-size: 18px !important;
    }

    .filter-title {
        font-size: 14px;
    }

    .filter-card label {
        font-size: 11px;
    }

    .filter-card .form-control,
    .btn-filter,
    .btn-reset {
        font-size: 12px;
    }

    table {
        font-size: 12px;
    }

    table th {
        font-size: 10px !important;
    }

    table td {
        font-size: 12px;
    }

    .status-green,
    .status-orange,
    .status-red,
    .status-gray {
        font-size: 10px;
    }

    .dataTables_length,
    .dataTables_filter,
    .dataTables_info {
        font-size: 11px !important;
    }

    .dataTables_paginate .page-link {
        font-size: 11px !important;
    }
}

/* Smaller laptop / tablet */
@media (max-width: 992px) {

    body {
        font-size: 11px;
    }

    h4 {
        font-size: 16px !important;
    }

    .filter-title {
        font-size: 13px;
    }

    .filter-card label {
        font-size: 10px;
    }

    .filter-card .form-control,
    .btn-filter,
    .btn-reset {
        font-size: 11px;
    }

    table {
        font-size: 11px;
    }

    table th {
        font-size: 9px !important;
    }

    table td {
        font-size: 11px;
    }

    .status-green,
    .status-orange,
    .status-red,
    .status-gray {
        font-size: 9px;
        padding: 3px 8px;
    }

    .dataTables_length,
    .dataTables_filter,
    .dataTables_info {
        font-size: 10px !important;
    }

    .dataTables_paginate .page-link {
        font-size: 10px !important;
    }
}

/* Mobile */
@media (max-width: 576px) {

    body {
        font-size: 10px;
    }

    h4 {
        font-size: 14px !important;
    }

    .filter-title {
        font-size: 12px;
    }

    .filter-card label {
        font-size: 9px;
    }

    .filter-card .form-control,
    .btn-filter,
    .btn-reset {
        font-size: 10px;
    }

    table {
        font-size: 10px;
    }

    table th {
        font-size: 8px !important;
    }

    table td {
        font-size: 10px;
    }

    .status-green,
    .status-orange,
    .status-red,
    .status-gray {
        font-size: 8px;
        padding: 3px 6px;
    }

    .dataTables_length,
    .dataTables_filter,
    .dataTables_info {
        font-size: 9px !important;
    }

    .dataTables_paginate .page-link {
        font-size: 9px !important;
    }
}

/* Extra tight Show Entries / Search spacing */
.dataTables_wrapper .top {
    padding-top: 2px !important;
    padding-bottom: 2px !important;
    margin: 0 !important;
}

.dataTables_wrapper .dataTables_length,
.dataTables_wrapper .dataTables_filter {
    margin-top: 0 !important;
    margin-bottom: 0 !important;
}

  </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">

<div class="content-wrapper">
  <section class="content p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <div>
        <h4 class="font-weight-bold mb-0">Total View Candidates</h4>
        <!-- <small class="text-muted"><span id="empCount">10</span> employees currently active</small> -->
      </div>
    </div>

    <div class="filter-card">

    <div class="filter-title">
        <i class="fas fa-filter"></i>
        Candidate Filters
    </div>

    <form method="get" action="<?= base_url('admin/View_candidate') ?>">

        <div class="row">

            <div class="col-md-3">
                <label>Offer Status</label>

                <select class="form-control" name="offer_status">
                    <option value="ALL" <?= ($offer_status=='ALL')?'selected':'' ?>>All</option>
                    <option value="PENDING" <?= ($offer_status=='PENDING')?'selected':'' ?>>Pending</option>
                    <option value="ACCEPTED" <?= ($offer_status=='ACCEPTED')?'selected':'' ?>>Accepted</option>
                </select>

            </div>

            <div class="col-md-3">
                <label>Onboarding Status</label>

                <select class="form-control" name="onboarding_status">
                    <option value="ALL" <?= ($onboarding_status=='ALL')?'selected':'' ?>>All</option>
                    <option value="NOT_STARTED" <?= ($onboarding_status=='NOT_STARTED')?'selected':'' ?>>Not Started</option>
                    <option value="SUBMITTED" <?= ($onboarding_status=='SUBMITTED')?'selected':'' ?>>Submitted</option>
                    <option value="IN_PROGRESS" <?= ($onboarding_status=='IN_PROGRESS')?'selected':'' ?>>In Progress</option>
                    <option value="COMPLETED" <?= ($onboarding_status=='COMPLETED')?'selected':'' ?>>Completed</option>
                </select>

            </div>

            <div class="col-md-3">
                <label>Candidate Type</label>

                <select class="form-control" name="candidate_type">
                    <option value="ALL" <?= ($candidate_type=='ALL')?'selected':'' ?>>All</option>
                    <option value="ADMIN" <?= ($candidate_type=='ADMIN')?'selected':'' ?>>Admin</option>
                    <option value="HR" <?= ($candidate_type=='HR')?'selected':'' ?>>HR</option>
                    <option value="MANAGER" <?= ($candidate_type=='MANAGER')?'selected':'' ?>>Manager</option>
                    <option value="EMP" <?= ($candidate_type=='EMP')?'selected':'' ?>>Employee</option>
                    <option value="INTERN" <?= ($candidate_type=='INTERN')?'selected':'' ?>>Intern</option>
                </select>

            </div>

            <div class="col-md-3 d-flex align-items-end">

                <button type="submit" class="btn btn-filter btn-block">
                   submit
                </button>

            </div>
        </div>
  </form>
</div>
    <div class="card-bloom">
        
      <!-- <div class="p-3 border-bottom d-flex justify-content-between align-items-center bg-white"> -->

      <div class="p-3 border-bottom bg-white">

    <div class="d-flex align-items-center" style="gap:10px; flex-wrap:wrap;">

    </div>

</div>
        <div class="input-group input-group-sm w-25">

        <!-- ADD THIS BELOW SEARCH BOX -->
<div class="d-flex mt-2" style="gap:10px;">

</div>
           
      </div>
      
      <div class="table-responsive">
       <table id="leaveHistoryTable" class="table table-hover mb-0">
          <thead class="bg-light">
            <tr class="small text-uppercase text-muted">
              <th class="border-0">Reference Id</th>
              <th class="border-0">Candidate Type</th>
              <th class="border-0">Name</th>
              <th class="border-0">Email Address</th>
              <th class="border-0"> Onboarding Status</th>
               <th class="border-0">Offer Status</th>
              <th class="text-right pr-4 border-0">Actions</th>
            </tr>
          </thead>
          <tbody id="employeeTableBody">
            <?php foreach ($details as $row): ?>
            <tr class="employee-row">
                <td><?= $row['ref_id'] ?? '-'?></td>
                <td><?= $row['candidate_type'] ?? '-'?></td>
                <td><?= $row['emp_name'] ?? '-'?></td>
                <td><?= $row['email'] ?? '-'?></td>
                <td class="onboarding-status">
                <?php
                $ob = $row['onboarding_status'];

              switch ($ob) {
                  case 'IN_PROGRESS':
                      echo '<span class="status-orange">IN_PROGRESS</span>';
                      break;

                  case 'SUBMITTED':
                      echo '<span class="status-green">SUBMITTED</span>';
                      break;

                  case 'NOT_STARTED':
                      echo '<span class="status-gray">NOT_STARTED</span>';
                      break;

                  default:
                      echo '<span class="status-gray">'.$ob.'</span>';
                      break;
              }
                                ?>
                                </td>

            <td class="offer-status">
              <?php
              $offer = $row['offer_status'];

              switch ($offer) {
                  case 'ACCEPTED':
                      echo '<span class="status-green">ACCEPTED</span>';
                      break;

                  case 'PENDING':
                      echo '<span class="status-red">PENDING</span>';
                      break;

                  case 'REJECTED':
                      echo '<span class="status-red">REJECTED</span>';
                      break;

                  default:
                      echo '<span class="status-gray">'.$offer.'</span>';
                      break;
                    }
                    ?>
                    </td>
                                <td class="text-right pr-4">
                  <a href="<?= base_url('admin/candidate/'.$row['ref_id']) ?>" class="btn btn-view">
                        <i class="fas fa-eye"></i>
                    </a>

                </td>
        </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>  1
    </div>

    
  </div>
</div>
  </section>
</div>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>


<script>
$(document).ready(function () {

    function filterTable() {

        var searchValue = $("#employeeSearch").val().toLowerCase();
        var onboardingValue = $("#onboardingFilter").val();
        var offerValue = $("#offerFilter").val();

        $("#employeeTableBody .employee-row").each(function () {

            var name = $(this).find("td:nth-child(2)").text().toLowerCase();
            var email = $(this).find("td:nth-child(3)").text().toLowerCase();

            var onboarding = $(this).find(".onboarding-status").text().trim();
            var offer = $(this).find(".offer-status").text().trim();

            var matchSearch =
                name.includes(searchValue) ||
                email.includes(searchValue);

            var matchOnboarding =
                onboardingValue === "" || onboarding === onboardingValue;

            var matchOffer =
                offerValue === "" || offer === offerValue;

            if (matchSearch && matchOnboarding && matchOffer) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    }

    $("#employeeSearch").on("keyup", filterTable);
    $("#onboardingFilter").on("change", filterTable);
    $("#offerFilter").on("change", filterTable);

});
</script>
<script>
  $(document).ready(function () {
    $('#leaveHistoryTable').DataTable({
      paging: true,
      ordering: true,
      searching: true,
      info: true,
      lengthChange: true,
      pageLength:10,
      dom: '<"top"lf>rt<"bottom"ip><"clear">'
      });
});
</script>
</body>
</html>
