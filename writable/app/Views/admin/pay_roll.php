<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bloom Solutions | Pay Roll</title>
  
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

.emp-badge{
    display:inline-block;
    padding:6px 12px;
    border-radius:10px;
    font-size:13px;
    font-weight:600;
}

.emp-purple{
    background:#ede9fe;
    color:#5b21b6;
    border:1px solid #d8b4fe;
}

.emp-green{
    background:#ecfdf5;
    color:#059669;
    border:1px solid #a7f3d0;
}

.emp-blue{
    background:#EEF4FF;
    color:#1D4ED8;
    border:1px solid #BFDBFE;
}

.emp-magenta{
    background:#FDF2FF;
    color:#A21CAF;
    border:1px solid #6b09d4;
}
  </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">

<div class="content-wrapper">
  <section class="content p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <div>
        <h4 class="font-weight-bold mb-0">Manage Salary</h4>
        <!-- <small class="text-muted"><span id="empCount">10</span> employees currently active</small> -->
      </div>
      
      <!-- <a href="add_new.html" class="btn btn-primary rounded-pill px-4 d-flex align-items-center" style="background:var(--bloom-purple); border:none;">
        <i class="fas fa-plus mr-2"></i> Add New
      </a> -->
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

      <div class="table-responsive">
       <table id="salaryTable" class="table table-hover mb-0">
          <thead class="bg-light">
            <tr class="small text-uppercase text-muted">
              <th class="pl-4 border-0">SL.NO</th>
              <th class="border-0">EMPLOYEE ID</th>
              <th class="border-0">EMPLOYEE NAME</th>
              <th class="border-0">DEPARTMENT</th>
              <th class="border-0">MONTH</th>
              <th class="border-0">YEAR</th>
              <th class="text-right pr-4 border-0">Actions</th>
            </tr>
          </thead>

           <tbody>

<?php if (!empty($salary)) : ?>

   <?php $i = 1; ?>
<?php foreach ($salary as $row) : ?>

<?php
$colors = ['emp-purple', 'emp-green', 'emp-blue', 'emp-magenta'];
$badge = $colors[($i - 1) % 4];
?>
    <tr>
        <td class="pl-4"><?= $i++; ?></td>
       <td>
    <span class="emp-badge <?= $badge ?>">
        <?= !empty($row['staff_id']) ? esc($row['staff_id']) : '-' ?>
    </span>
</td>

<td>
    <span class="emp-badge <?= $badge ?>">
        <?= esc($row['staff_name']) ? esc($row['staff_name']): '-'?>
    </span>
</td>
        <td><?= $row['department_name'] ?  $row['department_name'] : '-' ?></td>
       <td>
    <select class="custom-select custom-select-sm monthFilter" style="width:120px;">
        <?php
        $months = [
            "January","February","March","April","May","June",
            "July","August","September","October","November","December"
        ];

        foreach($months as $month){
        ?>
            <option value="<?= $month ?>" <?= $month==date('F')?'selected':'' ?>>
                <?= $month ?>
            </option>
        <?php } ?>
    </select>
</td>

<td>
    <select class="custom-select custom-select-sm yearFilter" style="width:90px;">
        <?php
        for($y=date('Y'); $y>=2024; $y--){
        ?>
            <option value="<?= $y ?>" <?= $y==date('Y')?'selected':'' ?>>
                <?= $y ?>
            </option>
        <?php } ?>
    </select>
</td>
        <td class="text-right pr-4">

            <a href="javascript:void(0)"
   class="action-btn btn-view viewPayslip"
   data-emp="<?= $row['staff_id']; ?>"
   title="View">
    <i class="fas fa-eye"></i>
</a>
                

            <a href="#" class="action-btn btn-edit" title="Edit">
                <i class="fas fa-edit"></i>
            </a>

            <button class="action-btn btn-delete" title="Delete">
                <i class="fas fa-trash-alt"></i>
            </button>

        </td>

    </tr>

    <?php endforeach; ?>

<?php else : ?>

<tr>
    <td colspan="7" class="text-center text-muted py-4">
        No Employees Found
    </td>
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<?php if (session()->getFlashdata('error')) : ?>
<script>
$(document).ready(function () {

    toastr.options = {
        closeButton: true,
        progressBar: true,
        positionClass: "toast-top-right",
        timeOut: 5000,
        extendedTimeOut: 1000
    };

    toastr.warning("<?= session()->getFlashdata('error'); ?>");
});
</script>
<?php endif; ?>
<script>
$(document).on('click','.viewPayslip',function(){

    var row = $(this).closest('tr');

    var empid = $(this).data('emp');
    var month = row.find('.monthFilter').val();
    var year  = row.find('.yearFilter').val();

    window.location.href =
        "<?= site_url('employee/new_emp_payslip') ?>/" +
        empid + "/" +
        month + "/" +
        year;

});
</script>
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
