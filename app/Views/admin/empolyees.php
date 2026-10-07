
<?php
$activeCount = 0;

if (!empty($employee)) {
    foreach ($employee as $emp) {
        if ($emp['status'] == 'Y') {
            $activeCount++;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bloom Solutions | Employee Directory</title>
  
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">

  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">


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
    height: 34px !important;
    min-width: 65px;
    border: 1px solid #e2e8f0 !important;
    border-radius: 10px !important;   /* Less rounded */
    padding: 4px 8px !important;
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

/* Sorting arrows */
table.dataTable thead .sorting:before,
table.dataTable thead .sorting:after,
table.dataTable thead .sorting_asc:before,
table.dataTable thead .sorting_asc:after,
table.dataTable thead .sorting_desc:before,
table.dataTable thead .sorting_desc:after {
    top: 50% !important;
    transform: translateY(-50%);
    font-size: 10px !important;
    color: #4a00e0 !important;
}
/* =========================================================
   EMPLOYEE DIRECTORY RESPONSIVE DESIGN
   ========================================================= */

/* Employee table */
#empRequestsTable {
    width: 100% !important;
}

#empRequestsTable thead th {
    white-space: nowrap;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: .3px;
    padding-top: 14px;
    padding-bottom: 14px;
}

#empRequestsTable tbody td {
    vertical-align: middle;
    padding-top: 12px;
    padding-bottom: 12px;
}

/* Employee avatar */
.avatar-list {
    width: 38px;
    height: 38px;
    min-width: 38px;
    border-radius: 10px;
    object-fit: cover;
}

/* Employee name */
.emp-name {
    display: inline-block;
    max-width: 220px;
    word-break: break-word;
}

/* Action buttons */
.action-btn {
    width: 32px;
    height: 32px;
    min-width: 32px;
}

/* DataTables responsive child row */
table.dataTable > tbody > tr.child {
    background: #f8fafc !important;
}

table.dataTable > tbody > tr.child ul.dtr-details {
    width: 100%;
}

table.dataTable > tbody > tr.child ul.dtr-details li {
    padding: 8px 0;
    border-bottom: 1px solid #e2e8f0;
}

table.dataTable > tbody > tr.child span.dtr-title {
    min-width: 100px;
    font-weight: 700;
    color: #64748b;
}

/* =========================================================
   TABLET
   ========================================================= */

@media (max-width: 991.98px) {

    .content {
        padding: 15px !important;
    }

    .content-wrapper > .content {
        padding: 15px !important;
    }

    .card-bloom {
        border-radius: 16px !important;
    }

    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter {
        margin: 12px !important;
    }

    .dataTables_wrapper .row:first-child {
        display: flex;
        flex-wrap: wrap;
    }

    .dataTables_wrapper .dataTables_filter input {
        max-width: 180px;
    }
}


/* =========================================================
   MOBILE
   ========================================================= */

@media (max-width: 767.98px) {

    body {
        font-size: 12px;
        overflow-x: hidden;
    }

    .content-wrapper {
        width: 100% !important;
        margin-left: 0 !important;
    }

    .content {
        padding: 10px !important;
    }

    /* Page heading */
    .content > .d-flex {
        display: block !important;
        margin-bottom: 15px !important;
    }

    .content h4 {
        font-size: 18px !important;
        line-height: 1.4;
    }

    .content h4 + small {
        font-size: 11px;
    }

    /* Main card */
    .card-bloom {
        border-radius: 16px !important;
        overflow: visible !important;
    }

    /* DataTable top controls */
    .dataTables_wrapper .row:first-child {
        display: flex !important;
        flex-direction: column !important;
        align-items: stretch !important;
        margin: 0 !important;
    }

    .dataTables_wrapper .row:first-child > div {
        width: 100% !important;
        max-width: 100% !important;
        flex: 0 0 100% !important;
    }

    .dataTables_wrapper .dataTables_length {
        float: none !important;
        width: 100% !important;
        margin: 12px 12px 5px !important;
    }

    .dataTables_wrapper .dataTables_filter {
        float: none !important;
        width: 100% !important;
        margin: 5px 12px 12px !important;
        text-align: left !important;
    }

    .dataTables_wrapper .dataTables_filter label {
        width: 100%;
        margin-bottom: 0;
    }

    .dataTables_wrapper .dataTables_filter input {
        width: calc(100% - 45px) !important;
        max-width: none !important;
        height: 38px;
        margin-left: 5px !important;
        border-radius: 10px !important;
    }

    .dataTables_length select {
        height: 36px !important;
        min-width: 65px;
    }

    /* Table */
    .table-responsive {
        overflow-x: visible !important;
    }

    #empRequestsTable {
        width: 100% !important;
    }

    /* Hide table header on mobile */
    #empRequestsTable thead {
        display: none;
    }

    /* Employee row becomes card */
    #empRequestsTable tbody tr.employee-row {
        display: block;
        margin: 10px 10px;
        padding: 14px;
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
    }

    #empRequestsTable tbody tr.employee-row:hover {
        background: #fff;
    }

    #empRequestsTable tbody tr.employee-row td {
        display: block;
        width: 100%;
        padding: 5px 0 !important;
        border: none !important;
        text-align: left !important;
    }

    /* Employee name */
    #empRequestsTable tbody tr.employee-row td:first-child {
        padding-bottom: 10px !important;
        border-bottom: 1px solid #eef2f7 !important;
        margin-bottom: 5px;
    }

    #empRequestsTable tbody tr.employee-row td:first-child .d-flex {
        align-items: center;
    }

    .avatar-list {
        width: 44px;
        height: 44px;
        min-width: 44px;
        border-radius: 12px;
    }

    .emp-name {
        max-width: 230px;
        font-size: 13px;
    }

    /* Department / Email / Mobile */
    #empRequestsTable tbody tr.employee-row td:nth-child(2)::before {
        content: "Department";
    }

    #empRequestsTable tbody tr.employee-row td:nth-child(3)::before {
        content: "Email";
    }

    #empRequestsTable tbody tr.employee-row td:nth-child(4)::before {
        content: "Mobile";
    }

    #empRequestsTable tbody tr.employee-row td:nth-child(2)::before,
    #empRequestsTable tbody tr.employee-row td:nth-child(3)::before,
    #empRequestsTable tbody tr.employee-row td:nth-child(4)::before {
        display: inline-block;
        width: 75px;
        color: #94a3b8;
        font-size: 9px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .5px;
        vertical-align: top;
    }

    .dept-name,
    .emp-email {
        word-break: break-word;
    }

    /* Status */
    #empRequestsTable tbody tr.employee-row td:nth-child(5) {
        margin-top: 5px;
    }

    #empRequestsTable tbody tr.employee-row td:nth-child(5)::before {
        content: "Status";
        display: inline-block;
        width: 75px;
        color: #94a3b8;
        font-size: 9px;
        font-weight: 700;
        text-transform: uppercase;
        vertical-align: middle;
    }

    /* Actions */
    #empRequestsTable tbody tr.employee-row td:last-child {
        margin-top: 10px;
        padding-top: 10px !important;
        border-top: 1px solid #eef2f7 !important;
        text-align: right !important;
    }

    #empRequestsTable tbody tr.employee-row td:last-child::before {
        content: "Actions";
        float: left;
        color: #94a3b8;
        font-size: 9px;
        font-weight: 700;
        text-transform: uppercase;
        padding-top: 8px;
    }

    .action-btn {
        width: 34px;
        height: 34px;
        min-width: 34px;
        margin-left: 4px;
        border-radius: 9px !important;
    }

    /* Pagination */
    .dataTables_wrapper .row:last-child {
        display: flex !important;
        flex-direction: column !important;
        align-items: center !important;
        margin: 0 !important;
    }

    .dataTables_wrapper .dataTables_info {
        width: 100% !important;
        text-align: center !important;
        padding: 12px 5px !important;
    }

    .dataTables_wrapper .dataTables_paginate {
        width: 100% !important;
        text-align: center !important;
        padding: 5px 0 12px !important;
    }

    .dataTables_paginate .paginate_button {
        margin: 0 2px !important;
    }

    .dataTables_paginate .page-link {
        min-width: 34px;
        height: 34px;
        padding: 7px 10px !important;
        font-size: 11px;
    }

}


/* =========================================================
   SMALL MOBILE
   ========================================================= */

@media (max-width: 480px) {

    .content {
        padding: 8px !important;
    }

    .content h4 {
        font-size: 16px !important;
    }

    .card-bloom {
        border-radius: 14px !important;
    }

    #empRequestsTable tbody tr.employee-row {
        margin: 8px 6px;
        padding: 12px;
        border-radius: 13px;
    }

    .avatar-list {
        width: 40px;
        height: 40px;
        min-width: 40px;
    }

    .emp-name {
        font-size: 12px;
        max-width: 190px;
    }

    #empRequestsTable tbody tr.employee-row td:nth-child(2)::before,
    #empRequestsTable tbody tr.employee-row td:nth-child(3)::before,
    #empRequestsTable tbody tr.employee-row td:nth-child(4)::before,
    #empRequestsTable tbody tr.employee-row td:nth-child(5)::before {
        width: 65px;
    }

    .status-active,
    .status-leave {
        font-size: 10px;
        padding: 4px 8px;
    }

    .action-btn {
        width: 32px;
        height: 32px;
        min-width: 32px;
    }

}


/* =========================================================
   VERY SMALL MOBILE
   ========================================================= */

@media (max-width: 360px) {

    .content {
        padding: 6px !important;
    }

    .content h4 {
        font-size: 15px !important;
    }

    #empRequestsTable tbody tr.employee-row {
        margin: 6px 3px;
        padding: 10px;
    }

    .emp-name {
        max-width: 160px;
    }

    #empRequestsTable tbody tr.employee-row td:nth-child(2)::before,
    #empRequestsTable tbody tr.employee-row td:nth-child(3)::before,
    #empRequestsTable tbody tr.employee-row td:nth-child(4)::before,
    #empRequestsTable tbody tr.employee-row td:nth-child(5)::before {
        width: 60px;
    }
}
/* =========================================================
   MOBILE - SEARCH BAR FIX
   ========================================================= */
@media (max-width: 767.98px) {

    /* Keep DataTables controls inside the card */
    .card-bloom .dataTables_wrapper {
        width: 100%;
        overflow: hidden;
    }

    .card-bloom .dataTables_wrapper .row:first-child {
        display: flex !important;
        flex-direction: column !important;
        align-items: stretch !important;
        width: 100%;
        margin: 0 !important;
    }

    /* Show entries */
    .card-bloom .dataTables_wrapper .dataTables_length {
        width: 100% !important;
        margin: 10px 12px 5px !important;
        padding: 0 !important;
    }

    /* Search area */
    .card-bloom .dataTables_wrapper .dataTables_filter {
        width: 100% !important;
        margin: 5px 12px 12px !important;
        padding: 0 !important;
        text-align: left !important;
    }

    /* Search label */
    .card-bloom .dataTables_wrapper .dataTables_filter label {
        display: flex !important;
        align-items: center;
        width: 100%;
        margin: 0 !important;
        font-size: 0;
    }

    /* Search input */
    .card-bloom .dataTables_wrapper .dataTables_filter input {
        width: calc(100% - 24px) !important;
        max-width: 100% !important;
        height: 38px !important;
        margin: 0 !important;
        padding: 6px 12px !important;
        box-sizing: border-box !important;
        border-radius: 10px !important;
        font-size: 13px !important;
    }

    /* Table/card should not create horizontal overflow */
    .card-bloom {
        width: 100%;
        overflow: hidden !important;
    }

    .table-responsive {
        width: 100%;
        overflow-x: hidden !important;
    }
}


/* ---------- Smaller Mobile ---------- */
@media (max-width: 480px) {

    .card-bloom .dataTables_wrapper .dataTables_length {
        margin-left: 10px !important;
        margin-right: 10px !important;
    }

    .card-bloom .dataTables_wrapper .dataTables_filter {
        margin-left: 10px !important;
        margin-right: 10px !important;
    }

    .card-bloom .dataTables_wrapper .dataTables_filter input {
        width: calc(100% - 20px) !important;
        height: 36px !important;
    }
}

/* Reduce gap between Show Entries/Search and table */
#empRequestsTable_wrapper .row:first-child {
    margin-bottom: 1px !important;
}

#empRequestsTable_wrapper .dataTables_length,
#empRequestsTable_wrapper .dataTables_filter {
    margin-bottom: 0 !important;
}

#empRequestsTable_wrapper .dataTables_length,
#empRequestsTable_wrapper .dataTables_filter {
    margin-top: 1px !important;
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
        <h4 class="font-weight-bold mb-0">
            Total Active Employees
        </h4>

        <small class="text-muted">
            <span id="empCount"><?= $activeCount ?></span> employees currently active
        </small>
    </div>

    <a href="<?= base_url('admin/add_employee') ?>"
       style="text-decoration: none;">
        <button class="btn btn-primary rounded-pill px-4"
                style="background: var(--bloom-purple); border: none;">
            <i class="fas fa-plus mr-2"></i> Add Employee
        </button>
    </a>

</div>

    <div class="card-bloom">
      <div class="p-3 d-flex justify-content-between align-items-center bg-white">
        
      </div>

      <div class="table-responsive">
        <table id="empRequestsTable" class="table mb-0">
             <!-- <table id="leaveHistoryTable" class="table mb-0"> -->
          <thead class="bg-light">
            <tr class="small text-uppercase text-muted">
              <th class="pl-4 border-0">Employee Name & ID</th>
              <th class="border-0">Department</th>
              <th class="border-0">Email Address</th>
              <th class="border-0">Mobile No</th>
              <th class="border-0">Status</th>
              <th class="text-right pr-4 border-0">Actions</th>
            </tr>
          </thead>

          <tbody id="employeeTableBody">

<?php foreach($employee as $emp){ ?>

<tr class="employee-row">
    <td class="pl-4">
        <div class="d-flex align-items-center">
            <img src="https://ui-avatars.com/api/?name=<?= urlencode($emp['emp_name']) ?>&background=4a00e0&color=fff"
                 class="avatar-list mr-2">

            <div>
                <strong class="emp-name"><?= $emp['emp_name'] ? $emp['emp_name'] : '-'?></strong><br>
                <small class="text-muted"><?= $emp['emp_id'] ?></small>
            </div>
        </div>
    </td>

    <td class="dept-name">
         <?= !empty($emp['department_name']) ? $emp['department_name'] : '-' ?>
    </td>

    <td class="emp-email">
        <?= $emp['email'] ? $emp['email'] : '-'?>
    </td>

    <td>
        <?= $emp['mobile'] ? $emp['mobile'] : '-'?>
    </td>

    <td>
    <?php $status = trim(strtolower($emp['employee_login_status'])); ?>

    <span class="<?= $status === 'active' ? 'status-active' : 'status-leave' ?>">
        <?= ucfirst($status) ?>
    </span>
</td>
    <td class="text-right pr-4">
       <a href="<?= base_url('admin/emp_view/' . $emp['emp_id']) ?>" class="action-btn btn-view" title="View">
            <i class="fas fa-eye"></i>
        </a>

        <a href="<?= base_url('admin/emp_edit/'. $emp['emp_id']) ?>" class="action-btn btn-edit" title="Edit">
            <i class="fas fa-edit"></i>
        </a>

        <button class="action-btn btn-delete delete-btn"
        title="Delete"
        data-name="<?= $emp['emp_name'] ?>"
        data-empid="<?= $emp['emp_id'] ?>">
    <i class="fas fa-trash-alt"></i>
</button>
    </td>
</tr>

<?php } ?>

</tbody>
        </table>
      </div>  1
    </div>

    <!-- <div class="mt-4">
        <a href="index.html" class="btn btn-sm text-muted px-0"><i class="fas fa-arrow-left mr-2"></i>Back to Dashboard</a>
    </div> -->
  </div>
</div>
  </section>
</div>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
$(document).ready(function(){
    // 1. Search and Filter Logic
    function filterTable() {
        var searchValue = $("#employeeSearch").val().toLowerCase();
        var deptValue = $("#deptFilter").val();
        var visibleCount = 0;

        $("#employeeTableBody .employee-row").each(function() {
            var name = $(this).find(".emp-name").text().toLowerCase();
            var email = $(this).find(".emp-email").text().toLowerCase();
            var dept = $(this).find(".dept-name").text();
            
            var matchSearch = name.indexOf(searchValue) > -1 || email.indexOf(searchValue) > -1;
            var matchDept = (deptValue === "All" || dept === deptValue);
            
            if(matchSearch && matchDept) {
                $(this).show();
                visibleCount++;
            } else {
                $(this).hide();
            }
        });
        $("#empCount").text(visibleCount);
    }

    $("#employeeSearch").on("keyup", filterTable);
    $("#deptFilter").on("change", filterTable);

    // 2. Delete Confirmation Logic
    // $(document).on("click", ".delete-btn", function() {
    //     var name = $(this).data("name");
    //     var row = $(this).closest("tr");
        
    //     if (confirm("Are you sure you want to remove " + name + " from the directory?")) {
    //         row.css("background", "#fee2e2");
    //         row.fadeOut(400, function() {
    //             row.remove();
    //             // Update count after removal
    //             var currentCount = parseInt($("#empCount").text());
    //             $("#empCount").text(currentCount - 1);
    //         });
    //     }
    // });
});

$(document).ready(function () {
    $('#empRequestsTable').DataTable({
      responsive: true,
      paging: true,
      ordering: true,
      searching: true,
      info: true,
      lengthChange: true,
      pageLength:10,
      dom: "<'row'<'col-md-6'l><'col-md-6'f>>" +
         "t" +
         "<'row'<'col-md-6'i><'col-md-6'p>>"

      });
});
</script>

<script>
    $(document).on("click", ".delete-btn", function () {

    if (!confirm("Are you sure you want to change this employee's status?")) {
        return;
    }

    var btn = $(this);
    var empid = btn.data("empid");

    $.ajax({
        url: "<?= base_url('admin/toggle_user_status') ?>",
        type: "POST",
        data: {
            emp_id: empid
        },
        dataType: "json",
        success: function(res) {

            toastr.success(res.remarks);

            setTimeout(function () {
                location.reload();
            }, 1000);
        },
        error: function() {
            toastr.error("Something went wrong.");
        }
    });

});

toastr.options = {
    closeButton: true,
    progressBar: true,
    positionClass: "toast-top-right",
    timeOut: "2500"
};
</script>
  
</body>
</html>
