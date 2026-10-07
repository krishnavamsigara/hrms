<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bloom Solutions | Departments</title>
  
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">

  <style>
    :root { 
        --bloom-purple: #4a00e0; 
        --soft-gray: #f8fafc; 
        --border-color: #e2e8f0; 
    }
    .nav-pills .nav-link.active, 
.nav-sidebar > .nav-item > .nav-link.active {
    background-color: #007bff !important; 
    color: #ffffff !important;
    box-shadow: 0 4px 12px rgba(0, 123, 255, 0.3);
}

/* Icon Spacing */
.nav-sidebar .nav-link > i {
    margin-right: 12px;
    font-size: 1.1rem;
    width: 25px;
    text-align: center;
}

/* Hover Effect for Inactive Links */
.nav-sidebar .nav-link:hover:not(.active) {
    background-color: rgba(255, 255, 255, 0.05) !important;
    color: #ffffff !important;
}

    body { 
        font-family: 'Plus Jakarta Sans', sans-serif; 
        background-color: var(--soft-gray); 
        font-size: 13px; 
        color: #334155;
    }

    /* Card Styling */
    .card-bloom { 
        border: 1px solid var(--border-color) !important; 
        border-radius: 20px !important; 
        background: #fff; 
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.04); 
        overflow: hidden;
    }

    /* Navbar & Sidebar */
    .main-header { 
        border-bottom: 1px solid #e2e8f0 !important; 
        background: rgba(255, 255, 255, 0.8) !important; 
        backdrop-filter: blur(12px); 
    }
    
    .main-sidebar { background-color: #1e293b !important; }

    /* Table Styling */
    .table thead th { 
        border-top: none; 
        border-bottom: 1px solid var(--border-color); 
        letter-spacing: 0.5px; 
        padding: 15px;
    }
    .table td { vertical-align: middle !important; padding: 15px; border-top: 1px solid #f1f5f9; }
    
    .dept-icon {
        width: 35px;
        height: 35px;
        border-radius: 10px;
        background: #f0f7ff;
        color: var(--bloom-purple);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
    }

    .staff-count {
        background: #f1f5f9;
        color: #64748b;
        padding: 4px 10px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 11px;
    }

    /* Search Input */
    .search-input {
        border-radius: 12px;
        border: 1px solid var(--border-color);
        padding-left: 35px;
        transition: 0.3s;
    }
    .search-input:focus {
        border-color: var(--bloom-purple);
        box-shadow: 0 0 0 4px rgba(74, 0, 224, 0.05);
    }
  </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">

   <div class="content-wrapper p-4">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
      <div>
        <h4 class="font-weight-bold mb-0">Departments</h4>
        <small class="text-muted">Manage your organization's functional units</small>
      </div>
     <a href="add_department.html" style="text-decoration: none;">
  <button class="btn btn-primary rounded-pill px-4" style="background:var(--bloom-purple); border:none;">
    <i class="fas fa-plus mr-2"></i> Add Department
  </button>
</a>
    </div>

    <div class="card-bloom">
      <div class="p-3 border-bottom position-relative">
        <i class="fas fa-search position-absolute" style="left: 25px; top: 22px; color: #94a3b8;"></i>
        <input type="text" id="deptSearch" class="form-control form-control-sm w-25 search-input" placeholder="Search departments...">
      </div>

      <div class="table-responsive">
        <table class="table table-hover mb-0">
          <thead class="bg-light">
            <tr class="small text-uppercase text-muted">
              <th class="pl-4">Department Name</th>
              <!-- <th>Core Function</th>
              <th>Head count</th> -->
              <th class="text-right pr-4">Action</th>
            </tr>
          </thead>
       <tbody id="deptTableBody">
<?php if (!empty($departments)): ?>
    <?php foreach ($departments as $row): ?>
        <tr class="dept-row">
            <td class="pl-4">
                <div class="d-flex align-items-center">
                    <div class="dept-icon mr-3">
                        <i class="fas fa-building"></i>
                    </div>
                    <div>
                        <strong class="dept-title">
                            <?= esc($row['department_name']) ?>
                        </strong>
                    </div>
                </div>
            </td>

            <!-- <td>-</td>

            <td>
                <span class="staff-count">-- Staff</span>
            </td> -->

            <td class="text-right pr-4">
                <button class="btn btn-sm btn-light border rounded-pill px-3">
                    Manage
                </button>
            </td>
        </tr>
    <?php endforeach; ?>
<?php else: ?>
    <tr>
        <td colspan="4" class="text-center py-4">
            No departments found.
        </td>
    </tr>
<?php endif; ?>
</tbody>
        </table>
      </div>
    </div>

    

  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

<script>
$(document).ready(function(){
  $("#deptSearch").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#deptTableBody .dept-row").filter(function() {
      $(this).toggle($(this).find(".dept-title").text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>

</body>
</html>
