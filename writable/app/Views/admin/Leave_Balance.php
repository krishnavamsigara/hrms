<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bloom Solutions | Leave Balance</title>
  
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

.btn-bloom {
    background-color: #4a00e0;
    border-color: #4a00e0;
    color: #fff;
}

.btn-bloom:hover {
    background-color: #3d00ba;
    border-color: #3d00ba;
    color: #fff;
}

.btn-bloom:focus,
.btn-bloom:active {
    background-color: #3d00ba !important;
    border-color: #3d00ba !important;
    color: #fff !important;
    box-shadow: 0 0 0 0.2rem rgba(74, 0, 224, 0.25);
}
  </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">

<div class="content-wrapper">
  <section class="content p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <div>
        <h4 class="font-weight-bold mb-0">Leave Balance</h4>
        <!-- <small class="text-muted"><span id="empCount">10</span> employees currently active</small> -->
      </div>
      
      <!-- <a href="add_new.html" class="btn btn-primary rounded-pill px-4 d-flex align-items-center" style="background:var(--bloom-purple); border:none;">
        <i class="fas fa-plus mr-2"></i> Add New
      </a> -->
    </div>
<div class="card card-bloom mb-3">
    <div class="card-body py-3">

        <form method="post" action="<?= base_url('admin/Leave_Balance') ?>">

            <div class="d-flex align-items-end">

                <!-- Month -->
                <div class="mr-3" style="width:180px;">
                    <label class="font-weight-bold mb-1">Month</label>
                    <select name="month" class="form-control form-control-sm">
                        <?php
                        for($m=1;$m<=12;$m++):
                            $value = str_pad($m,2,'0',STR_PAD_LEFT);
                        ?>
                        <option value="<?= $value ?>" <?= ($selectedMonth==$value)?'selected':'' ?>>
                            <?= date('F', mktime(0,0,0,$m,1)) ?>
                        </option>
                        <?php endfor; ?>
                    </select>
                </div>

                <!-- Year -->
                <div class="mr-3" style="width:140px;">
                    <label class="font-weight-bold mb-1">Year</label>
                    <select name="year" class="form-control form-control-sm">
                        <?php
                        $currentYear = date('Y');
                        for($y=$currentYear;$y>=2023;$y--):
                        ?>
                        <option value="<?= $y ?>" <?= ($selectedYear==$y)?'selected':'' ?>>
                            <?= $y ?>
                        </option>
                        <?php endfor; ?>
                    </select>
                </div>

                <!-- Submit -->
                <div>
                    <button type="submit" class="btn btn-bloom btn-sm px-4">
                         Submit
                    </button>
                </div>

            </div>

        </form>

    </div>
</div>
    <div class="card-bloom">
     <div class="p-3 d-flex justify-content-between align-items-center bg-white">
        <!-- <div class="input-group input-group-sm w-25"> -->
            <!-- <div class="input-group-prepend">
                <span class="input-group-text bg-light border-right-0 rounded-left-pill"><i class="fas fa-search text-muted"></i></span>
            </div> -->
            <!-- <input type="text" id="employeeSearch" class="form-control border-left-0 rounded-right-pill" placeholder="Search name or email..."> -->
        <!-- </div> -->

        <!-- <select id="deptFilter" class="btn btn-sm btn-light border rounded-pill px-3">
            <option value="All">All Departments</option>
            <option value="Development">Development</option>
            <option value="Marketing">Marketing</option>
            <option value="Mobile Apps">Mobile Apps</option>
            <option value="HR & Admin">HR & Admin</option>
            <option value="Design">Design</option>
            <option value="Sales">Sales</option>
            <option value="Analytics">Analytics</option>
            <option value="IT Support">IT Support</option>
        </select> -->
      </div>
<?php if(session()->getFlashdata('error')): ?>

<div class="alert alert-warning alert-dismissible fade show">
    <i class="fas fa-exclamation-circle"></i>
    <?= session()->getFlashdata('error'); ?>

    <button type="button" class="close" data-dismiss="alert">
        <span>&times;</span>
    </button>
</div>

<?php endif; ?>

      <div class="table-responsive">
       <table id="salaryTable" class="table mb-0">
          <thead class="bg-light">
            <tr class="small text-uppercase text-muted">
              <th class="pl-4 border-0">SL.NO</th>
              <th class="border-0">EMPLOYEE ID</th>
              <th class="border-0">EMPLOYEE NAME</th>
              <th class="border-0">LEAVE TAKEN(YEARLY)</th>
              <th class="border-0">LEAVE TAKEN(MONTHS)</th>
              <th class="border-0">WFH(YEARLY)</th>
              <th class="border-0">WFH(MONTHS)</th>
            </tr>
          </thead>
          <tbody>
<?php if (!empty($leave_balance) && $leave_balance[0]['status'] == 'Y') : ?>
    <?php foreach ($leave_balance as $row) : ?>
        <tr>
            <td><?= $row['sl.no'] ?? '' ?></td>
            <td><?= $row['employee id'] ?? '' ?></td>
            <td><?= $row['employee name'] ?? '' ?></td>
            <td><?= (int)($row['leave taken(yearly)'] ?? 0) ?></td>
            <td><?= (int)($row['leave taken(months)'] ?? 0) ?></td>
            <td><?= (int)($row['wfh(yearly)'] ?? 0) ?></td>
            <td><?= (int)($row['wfh(months)'] ?? 0) ?></td>
        </tr>
    <?php endforeach; ?>
<?php else : ?>
    <tr>
        <td colspan="7" class="text-center">No records found</td>
    </tr>
<?php endif; ?>
</tbody>
        
        </table>
      </div>  
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
   $('#salaryTable').DataTable({
    paging: true,
    ordering: true,
    searching: true,
    info: true,
    lengthChange: true,
    pageLength: 10,
    dom: '<"top"lf>rt<"bottom"ip><"clear">'
});
</script>

</body>
</html>
