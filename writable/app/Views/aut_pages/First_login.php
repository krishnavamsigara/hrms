<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bloom Solutions | First Login</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,600,700&display=fallback">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <style>
        :root {
            --bloom-purple: #4a00e0;
            --bloom-dark: #2a0080;
            --mtn-deep: #120038;
        }

        body {
            background: url("<?= base_url('public/dist/img/Bg.png') ?>") no-repeat center center fixed;
            background-size: cover;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            font-family: 'Inter', sans-serif;
        }

        .bg-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.4);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            z-index: 0;
        }

        .login-container{
    width:480px;
    display:flex;
    flex-direction:column;
    position:relative;
    z-index:10;
    padding:45px 40px;

    background: rgba(255,255,255,0.88);
    backdrop-filter: blur(18px);
    -webkit-backdrop-filter: blur(18px);

    border:1px solid rgba(255,255,255,0.35);
    border-radius:22px;

    box-shadow:
        0 25px 50px rgba(18,0,56,.20),
        0 8px 30px rgba(74,0,224,.15);

    overflow:hidden;
}

.login-container::before{
    content:"";
    position:absolute;
    top:0;
    left:0;
    right:0;
    height:6px;
    background:linear-gradient(90deg,#4a00e0,#7b4dff,#00c6ff);
}
        /* ===== Layout ===== */
.page-wrapper{
    display:flex;
    justify-content:center;
    align-items:stretch;   /* change from center to stretch */
    gap:30px;
    position:relative;
    z-index:10;
    width:100%;
    max-width:1100px;
    padding:30px;
}

/* ===== Password Rules Card ===== */
.instruction-panel{
    width:480px;
    position:relative;

    background: rgba(255,255,255,0.88);
    backdrop-filter: blur(18px);
    -webkit-backdrop-filter: blur(18px);

    border:1px solid rgba(255,255,255,.35);
    border-radius:22px;

    padding:35px;

    box-shadow:
        0 25px 50px rgba(18,0,56,.20),
        0 8px 30px rgba(74,0,224,.15);

    display:flex;
    flex-direction:column;
    justify-content:center;

    overflow:hidden;
}

.instruction-panel::before{
    content:"";
    position:absolute;
    top:0;
    left:0;
    right:0;
    height:6px;
    background:linear-gradient(90deg,#00c6ff,#4a00e0,#7b4dff);
}
.instruction-panel h6{
    font-size:18px;
    font-weight:700;
    color:#120038;
    margin-bottom:8px;
}

.instruction-panel p{
    font-size:13px;
    color:#64748b;
    margin-bottom:25px;
}

.rule-item{
    display:flex;
    align-items:center;
    margin-bottom:15px;
    font-size:13px;
    font-weight:600;
    color:#64748b;
    transition:.3s;
}

.rule-item i{
    width:18px;
    margin-right:10px;
    font-size:15px;
}

.rule-item.valid{
    color:#10b981;
}

.rule-item.invalid{
    color:#ef4444;
}

/* Mobile */
@media(max-width:991px){

.page-wrapper{
    flex-direction:column;
}

.login-container,
.instruction-panel{
    width:100%;
    max-width:480px;
}

}
        .login-title {
            font-weight: 800;
            font-size: 24px;
            color: #1a1a1a;
            margin-bottom: 6px;
        }

        .subtitle {
            color: #666;
            margin-bottom: 30px;
            font-size: 14px;
            line-height: 1.5;
        }

        .form-control-custom {
            border: 1px solid #e8e8e8;
            border-radius: 10px;
            padding: 10px 15px;
            height: 48px;
            margin-bottom: 15px;
            transition: all 0.3s ease;
            background: #fcfcfd;
            font-size: 14px;
        }

        .form-control-custom:focus {
            border-color: var(--bloom-purple);
            box-shadow: 0 0 0 4px rgba(74, 0, 224, 0.08);
            background: #fff;
            outline: none;
        }

        .btn-bloom {
            background: linear-gradient(135deg, var(--bloom-purple) 0%, var(--bloom-dark) 100%);
            color: #fff;
            height: 48px;
            border-radius: 10px;
            font-weight: 700;
            border: none;
            box-shadow: 0 8px 20px rgba(74, 0, 224, 0.25);
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 10px;
        }

        .btn-bloom:hover {
            transform: translateY(-1px);
            box-shadow: 0 10px 25px rgba(74, 0, 224, 0.35);
            color: #fff;
        }

        .profile-icon {
            width: 72px;
            height: 72px;
            background: linear-gradient(135deg, var(--bloom-purple) 0%, var(--bloom-dark) 100%);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            font-weight: bold;
            margin: 0 auto 20px auto;
            box-shadow: 0 8px 20px rgba(74, 0, 224, 0.25);
        }

        .login-container::after,
.instruction-panel::after{
    content:"";
    position:absolute;
    width:220px;
    height:220px;
    background:rgba(74,0,224,.08);
    border-radius:50%;
    top:-80px;
    right:-80px;
    filter:blur(35px);
    pointer-events:none;
}
.login-title{
    font-size:28px;
    font-weight:800;
    background:linear-gradient(135deg,#4a00e0,#7b4dff);
    -webkit-background-clip:text;
    -webkit-text-fill-color:transparent;
}

.rule-item{
    background:#f8f9ff;
    border-radius:12px;
    padding:12px 15px;
    margin-bottom:12px;
    transition:.3s;
    border:1px solid transparent;
}

.rule-item.valid{
    background:#ecfdf5;
    border-color:#10b981;
}

.rule-item.invalid{
    background:#fef2f2;
    border-color:#ef4444;
}
    </style>
</head>

<body>
    <div class="bg-overlay"></div>
<div class="page-wrapper">
<div class="login-container">
        <div class="text-center">
            <?php
$empName = session()->get('emp_name');

$nameParts = explode(' ', trim($empName));

if (count($nameParts) >= 2) {
    $initials = strtoupper(substr($nameParts[0], 0, 1) . substr($nameParts[1], 0, 1));
} else {
    $initials = strtoupper(substr($empName, 0, 2));
}
?>

<div class="profile-icon">
    <?= $initials; ?>
</div>

<h1 class="login-title">Welcome, <?= session()->get('emp_name'); ?>! 👋</h1>
<p class="subtitle">For your security, please set a new password to access your dashboard.</p>

<?php if(session()->getFlashdata('error')): ?>
    <div class="alert alert-danger">
        <?= session()->getFlashdata('error'); ?>
    </div>
<?php endif; ?>

<?php if(session()->getFlashdata('success')): ?>
    <div class="alert alert-success">
        <?= session()->getFlashdata('success'); ?>
    </div>
<?php endif; ?>

</div>

<form action="<?= base_url('update_password') ?>" method="post">

    <div class="form-group mb-2">
        <label class="small font-weight-bold text-muted mb-1">
            OLD PASSWORD
        </label>

        <input type="password"
               name="old_password"
               class="form-control form-control-custom"
               placeholder="Enter old password"
               required>
    </div>

    <div class="form-group mb-4">
        <label class="small font-weight-bold text-muted mb-1">
            NEW PASSWORD
        </label>

        <input type="password"
               id="newPassword"
               name="new_password"
               oninput="validatePasswordStrength();checkPasswordMatch();"
               class="form-control form-control-custom"
               placeholder="Enter new password"
               required>
    </div>

    <div class="form-group mb-4">
        <label class="small font-weight-bold text-muted mb-1">
            CONFIRM PASSWORD
        </label>

        <input type="password"
               id="confirmPassword"
               name="confirm_password"
               oninput="checkPasswordMatch();"
               class="form-control form-control-custom"
               placeholder="Enter new password"
               required>
    </div>
    <button id="submitBtn" type="submit" class="btn btn-bloom btn-block" disabled>
        UPDATE & CONTINUE
    </button>

</form>
</div>

<div class="instruction-panel">

<h6>Password Validation Requirements</h6>

<p>
Your new password must satisfy all the validations below.
</p>

<div id="rule-capital" class="rule-item">
    <i class="far fa-circle"></i>
    At least 1 Capital Letter (A-Z)
</div>

<div id="rule-lowercase" class="rule-item">
    <i class="far fa-circle"></i>
    At least 1 Lowercase Letter (a-z)
</div>

<div id="rule-number" class="rule-item">
    <i class="far fa-circle"></i>
    At least 1 Number (0-9)
</div>

<div id="rule-special" class="rule-item">
    <i class="far fa-circle"></i>
    At least 1 Special Character
</div>

<div id="rule-length" class="rule-item">
    <i class="far fa-circle"></i>
    Minimum 8 Characters
</div>

</div>

</div>

<script>
    function validatePasswordStrength(){

const password=document.getElementById("newPassword").value;

const checks={
capital:/[A-Z]/.test(password),
lowercase:/[a-z]/.test(password),
number:/[0-9]/.test(password),
special:/[@$!%*?&#]/.test(password),
length:password.length>=8
};

for(const [key,passed] of Object.entries(checks)){

const rule=document.getElementById("rule-"+key);

const icon=rule.querySelector("i");

if(password===""){
rule.className="rule-item";
icon.className="far fa-circle";
}
else if(passed){
rule.className="rule-item valid";
icon.className="fas fa-check-circle";
}
else{
rule.className="rule-item invalid";
icon.className="fas fa-times-circle";
}

}

}

function checkPasswordMatch(){

const newPass=document.getElementById("newPassword").value;

const confirm=document.getElementById("confirmPassword").value;

const submit=document.getElementById("submitBtn");

const valid=
/[A-Z]/.test(newPass)&&
/[a-z]/.test(newPass)&&
/[0-9]/.test(newPass)&&
/[@$!%*?&#]/.test(newPass)&&
newPass.length>=8&&
newPass===confirm;

submit.disabled=!valid;

}
</script>
</body>
</html>