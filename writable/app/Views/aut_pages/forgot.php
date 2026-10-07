<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bloom Solutions | Reset Password</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,600,700&display=fallback">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <style>
    :root {
        --bloom-purple: #4a00e0;
        --bloom-dark: #2a0080;
        --mtn-deep: #120038;
    }
    
    body { 
        background: #f0f2f5;  
        display: flex; 
        align-items: center; 
        justify-content: center; 
        height: 100vh; 
        margin: 0; 
        font-family: 'Inter', sans-serif; 
    }
    
    .login-container { 
        width: 850px; 
        height: 520px; 
        display: flex; 
        box-shadow: 0 25px 50px rgba(0,0,0,0.2); 
        border-radius: 24px; 
        overflow: hidden; 
        background: #fff; 
        animation: fadeIn 0.6s ease-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* VISUAL SIDE */
    .login-visual-side { 
        flex: 1; 
        background: linear-gradient(to bottom, #120038 0%, #4a00e0 100%); 
        padding: 40px; 
        color: white; 
        display: flex; 
        flex-direction: column; 
        align-items: center; 
        justify-content: center; 
        position: relative; 
        overflow: hidden;
    }

    .video-wrapper {
        position: relative;
        z-index: 20;
        width: 240px;
        background: rgba(255, 255, 255, 0.1);
        padding: 8px;
        border-radius: 16px;
        backdrop-filter: blur(15px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.4);
        border: 1px solid rgba(255,255,255,0.2);
    }

    .logoVideo { 
        width: 100%; 
        border-radius: 10px;
        display: block;
    }

    .mountains-svg {
        position: absolute;
        bottom: 40px;
        left: 0;
        width: 100%;
        height: 200px;
        z-index: 5;
    }

    .water-container {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 60px;
        z-index: 10;
        overflow: hidden;
        background: rgba(255, 255, 255, 0.05);
    }

    .wave {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 200%;
        height: 100%;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 800 100" preserveAspectRatio="none"><path d="M0,50 C150,100 350,0 500,50 C650,100 800,0 800,50 L800,100 L0,100 Z" fill="rgba(255,255,255,0.15)"/></svg>');
        background-size: 50% 100%;
        animation: flow 12s linear infinite;
    }

    .wave.delay {
        animation: flow 8s linear infinite reverse;
        opacity: 0.6;
        bottom: 2px;
    }

    @keyframes flow {
        from { transform: translateX(0); }
        to { transform: translateX(-50%); }
    }

    /* FORM SIDE */
    .login-form-side { 
        flex: 1.1; 
        padding: 40px 60px; 
        display: flex; 
        flex-direction: column; 
        justify-content: center; 
    }

    .login-title { font-weight: 800; font-size: 28px; color: #1a1a1a; margin-bottom: 10px; }
    .subtitle { color: #888; margin-bottom: 35px; font-size: 14px; line-height: 1.5; }

    .form-control-custom { 
        border: 1px solid #e8e8e8; 
        border-radius: 12px; 
        padding: 12px 15px; 
        height: 52px;
        margin-bottom: 20px;
        transition: all 0.3s ease;
        background: #fcfcfd;
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
        height: 52px;
        border-radius: 12px; 
        font-weight: 700; 
        border: none;
        box-shadow: 0 8px 20px rgba(74, 0, 224, 0.25);
        transition: all 0.3s;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    .btn-bloom:hover { 
        transform: translateY(-2px); 
        box-shadow: 0 12px 25px rgba(74, 0, 224, 0.4);
        color: #fff;
    }

    .back-to-login {
        margin-top: 25px;
        display: inline-block;
        color: #888;
        font-size: 14px;
        text-decoration: none;
        transition: all 0.2s;
    }
    .back-to-login:hover {
        color: var(--bloom-purple);
    }
    .back-to-login i {
        margin-right: 8px;
        transition: transform 0.2s;
    }
    .back-to-login:hover i {
        transform: translateX(-5px);
    }

    .success-badge {
        display: none;
        background: #e6fffa;
        color: #2d3748;        
        padding: 15px;
        border-radius: 12px;
        border-left: 4px solid #38b2ac;
        margin-bottom: 20px;
        font-size: 13px;
    }
  </style>
</head>
<body>

<div class="login-container">
  <div class="login-visual-side">
    <div class="video-wrapper">
       <video class="logoVideo" width="100%" autoplay muted loop playsinline>
    <source src="<?= base_url('public/dist/img/Butterfly_Animation_Video_Generation.mp4') ?>" type="video/mp4">
</video>
    </div>
    
    <div class="mt-4 text-center" style="z-index: 25;">
        <h4 class="font-weight-bold mb-1">Bloom Solutions Private Limited</h4>
        <p class="small opacity-75">Secure Recovery System</p>
    </div>

    <svg class="mountains-svg" viewBox="0 0 500 200" preserveAspectRatio="none">
        <path d="M0,200 L150,50 L300,150 L450,20 L500,100 L500,200 Z" fill="#2a0080" opacity="0.4"/>
        <path d="M0,200 L100,100 L250,180 L400,80 L500,180 L500,200 Z" fill="#120038" opacity="0.7"/>
    </svg>

    <div class="water-container">
        <div class="wave"></div>
        <div class="wave delay"></div>
    </div>
  </div>

  <div class="login-form-side">
    <h1 class="login-title">Forgot Password?</h1>
    <p class="subtitle">Enter your email and we'll send you a link to reset your password and get you back on track.</p>
    
    <div id="successMsg" class="success-badge">
        <i class="fas fa-check-circle mr-2"></i> Recovery link sent! Please check your inbox.
    </div>

    <?php if (session()->getFlashdata('error')) : ?>
    <div class="alert alert-danger">
        <i class="fas fa-exclamation-circle mr-2"></i>
        <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('success')) : ?>
    <div class="alert alert-success">
        <i class="fas fa-check-circle mr-2"></i>
        <?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>

    <form id="resetForm" action="<?= base_url('forgot-password') ?>" method="post">
      <div class="form-group mb-4">
        <!-- <label class="small font-weight-bold text-muted mb-2">EMAIL ADDRESS</label> -->
        <input type="text"
       name="emp_id"
       class="form-control form-control-custom"
       placeholder="Enter Employee ID"
       required>
      </div>

      <button type="submit" class="btn btn-bloom btn-block">Send Reset Link</button>
    </form>

    <div class="text-center">
    <a href="<?= base_url('/') ?>" class="back-to-login">
        <i class="fas fa-arrow-left"></i> Back to Login
    </a>
</div>
  </div>
</div>

<script>
  const video = document.querySelector(".logoVideo");

  video.addEventListener("timeupdate", () => {
    if (video.currentTime >= 6) {
      video.currentTime = 2;
    }
  });
</script>
</body>
</html>