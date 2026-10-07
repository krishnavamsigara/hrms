
<?php
$user_category = session()->get('user_category');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Bloom Solution | Coming Soon</title>

<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
:root{
    --bloom-purple:#4a00e0;
    --bloom-dark:#2a0080;
    --mtn-deep:#120038;
    --bloom-orange:#e46c44;
}

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Plus Jakarta Sans',sans-serif;
}

<?php if ($user_category == 'ADMIN') : ?>

body{
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    background:#ffffff;
}

.coming-card{
    width:100%;
    max-width:700px;
    text-align:center;
    background:transparent;
    box-shadow:none;
    padding:20px;
    margin:auto;
}

<?php else: ?>

body{
    background:#f8fafc;
    font-family:'Plus Jakarta Sans',sans-serif;
    margin:0;
}

.content-wrapper{
    background:#f8fafc;
}

.coming-card{
    width:100%;
    max-width:700px;
    text-align:center;
    background:transparent;
    box-shadow:none;
    padding:30px;
    margin:70px auto;
}

<?php endif; ?>

.coming-card{
    width:100%;
    max-width:700px;
    text-align:center;
    background:transparent;
    box-shadow:none;
    padding:20px;
    margin:auto;
}

.logo{
    font-size:34px;
    font-weight:800;
    margin-bottom:30px;
}

.logo .bloom{
    color:var(--bloom-purple);
}

.logo .solutions{
    color:var(--bloom-orange);
}

.icon-box{
    width:130px;
    height:130px;
    border-radius:50%;
    background:#ffffff;
    border:2px solid #e9ecef;
    margin:auto;
    display:flex;
    align-items:center;
    justify-content:center;
    margin-bottom:25px;
}

.icon-box i{
    font-size:60px;
    color:var(--bloom-purple);
}

h1{
    font-size:42px;
    font-weight:800;
    color:var(--mtn-deep);
    margin-bottom:15px;
}

.subtitle{
    color:#64748b;
    font-size:16px;
    line-height:1.8;
    margin-bottom:30px;
}

.badge{
    background:none;
    color:var(--bloom-orange);
    padding:0;
    font-size:15px;
    font-weight:700;
}

.footer{
    margin-top:35px;
    color:#94a3b8;
    font-size:13px;
}

.btn-home{
    display:inline-block;
    margin-top:30px;
    padding:12px 24px;
    background:var(--bloom-purple);
    color:#fff;
    text-decoration:none;
    border-radius:12px;
    font-weight:700;
    transition:.3s;
}

.btn-home:hover{
    background:var(--bloom-dark);
    color:#fff;
    text-decoration:none;
}
.main-footer{
    position:fixed;
    bottom:0;
    left:0; /* Change this if your employee sidebar width is different */
    right:0;
    z-index:999;
}
</style>
</head>
<body>

<div class="coming-card">

    <!-- <div class="logo">
        <span class="bloom">Bloom</span>
        <span class="solutions">Solutions</span>
    </div> -->

    <div class="icon-box">
        <i class="fas fa-rocket"></i>
    </div>

    <h1>Coming Soon</h1>

    <p class="subtitle">
        We're working on something exciting for BloomHR.
        This feature is currently under development and will be available soon.
    </p>

    <div class="badge">
    <i class="fas fa-hourglass-half"></i>
    New Feature In Progress
</div>

<br>

<?php
$user_category = session()->get('user_category');

$dashboard_url = ($user_category == 'ADMIN')
    ? base_url('admin/adm_dashboard')
    : base_url('employee/Emp_dashboard');
?>

<a href="<?= $dashboard_url ?>" class="btn-home">
    <i class="fas fa-home mr-2"></i>
    Back to Dashboard
</a>

<div class="footer">
    © 2026 Bloom Solutions. All Rights Reserved.
</div>

</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

</body>
</html>