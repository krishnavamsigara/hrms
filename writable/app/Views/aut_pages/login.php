<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bloom Solutions | Agent Login</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,600,700&display=fallback">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <style>
    :root {
      --bloom-purple: #4a00e0;
      --bloom-dark: #2a0080;
      --mtn-deep: #120038;
      --error-bg: #fdf2f2;
      --error-text: #e11d48;
      --error-border: #fecdd3;
    }

    body {
      background: #f0f2f5;
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
      margin: 0;
      font-family: 'Inter', sans-serif;
    }

    .login-container {
      width: 850px;
      min-height: 520px;
      display: flex;
      box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2);
      border-radius: 24px;
      overflow: hidden;
      background: #fff;
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
      width: 220px;
      background: rgba(255, 255, 255, 0.1);
      padding: 8px;
      border-radius: 16px;
      backdrop-filter: blur(15px);
      box-shadow: 0 15px 35px rgba(0, 0, 0, 0.4);
      border: 1px solid rgba(255, 255, 255, 0.2);
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
      padding: 30px 50px;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    .login-title {
      font-weight: 800;
      font-size: 26px;
      color: #1a1a1a;
      margin-bottom: 2px;
    }

    .subtitle {
      color: #888;
      margin-bottom: 20px;
      font-size: 13px;
    }

    .form-control-custom {
      border: 1px solid #e8e8e8;
      border-radius: 10px;
      padding: 10px 15px;
      height: 48px;
      margin-bottom: 12px;
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
    }

    .text-bloom {
      color: var(--bloom-purple);
      font-weight: 600;
    }

    /* CAPTCHA SECTION */
    .captcha-row {
      display: flex;
      align-items: center;
      gap: 12px;
      margin-bottom: 6px;
    }

    .captcha-code {
      background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
      color: var(--bloom-purple);
      padding: 0 16px;
      height: 48px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 20px;
      font-weight: 800;
      border-radius: 10px;
      letter-spacing: 4px;
      white-space: nowrap;
      border: 1px solid #dee2e6;
      box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.05);
      font-family: 'Courier New', Courier, monospace;
      user-select: none;
    }

    .captcha-refresh {
      cursor: pointer;
      color: #888;
      font-size: 20px;
      transition: all 0.3s ease;
      display: flex;
      align-items: center;
      justify-content: center;
      width: 48px;
      height: 48px;
      border-radius: 10px;
      background: #fcfcfd;
      border: 1px solid #e8e8e8;
    }

    .captcha-refresh:hover {
      color: var(--bloom-purple);
      background: #f0ecfc;
      border-color: var(--bloom-purple);
      transform: rotate(180deg);
    }

    .captcha-input {
      flex: 1;
      margin-bottom: 0 !important;
    }

    /* ALERTS & ERRORS */
    .alert-custom {
      background-color: var(--error-bg);
      color: var(--error-text);
      border: 1px solid var(--error-border);
      border-radius: 10px;
      padding: 10px 15px;
      font-size: 13px;
      font-weight: 600;
      display: flex;
      align-items: center;
      gap: 8px;
      margin-bottom: 15px;
    }

    .alert-success-custom {
      background-color: #f0fdf4;
      color: #166534;
      border: 1px solid #bbf7d0;
      border-radius: 10px;
      padding: 10px 15px;
      font-size: 13px;
      font-weight: 600;
      display: flex;
      align-items: center;
      gap: 8px;
      margin-bottom: 15px;
    }

    .inline-error {
      color: var(--error-text);
      font-size: 12px;
      font-weight: 600;
      margin-bottom: 15px;
      display: none;
      padding-left: 5px;
    }

    /* Hide Microsoft Edge password reveal button */
input[type="password"]::-ms-reveal,
input[type="password"]::-ms-clear {
    display: none;
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
        <p class="small opacity-75">Elevate your HR experience</p>
      </div>

      <svg class="mountains-svg" viewBox="0 0 500 200" preserveAspectRatio="none">
        <path d="M0,200 L150,50 L300,150 L450,20 L500,100 L500,200 Z" fill="#2a0080" opacity="0.4" />
        <path d="M0,200 L100,100 L250,180 L400,80 L500,180 L500,200 Z" fill="#120038" opacity="0.7" />
      </svg>

      <div class="water-container">
        <div class="wave"></div>
        <div class="wave delay"></div>
      </div>
    </div>

    <div class="login-form-side">
      <h1 class="login-title">Login</h1>
      <p class="subtitle">Enter your credentials to manage your portal.</p>

      <?php if(session()->getFlashdata('success')): ?>
        <div class="alert-success-custom">
          <i class="fas fa-check-circle"></i> 
          <?= session()->getFlashdata('success') ?>
        </div>
      <?php endif; ?>

      <?php if(session()->getFlashdata('error')): ?>
        <div class="alert-custom">
          <i class="fas fa-exclamation-circle"></i> 
          <?= session()->getFlashdata('error') ?> 
        </div>
      <?php endif; ?>

      <form action="<?= base_url('login') ?>" method="post" id="login-form">
        <div class="form-group mb-1">
          <label class="small font-weight-bold text-muted mb-1">Employee ID</label>
          <input type="text"
                 id="emID"
                 name="staff_id"
                 class="form-control form-control-custom"
                 placeholder="*******"
                 maxlength="7"
                 minlength="7"
                 required>
        </div>

        <div class="form-group mb-2">
    <div class="d-flex justify-content-between">
        <label class="small font-weight-bold text-muted mb-1">PASSWORD</label>
        <a href="<?= base_url('forgot-password') ?>" class="small text-bloom">Forgot?</a>
    </div>

    <div class="position-relative">
        <input type="password"
               id="passField"
               name="password"
               class="form-control form-control-custom pr-5"
               placeholder="••••••••"
               required>

        <span id="togglePassword"
              style="position:absolute; right:15px; top:50%; transform:translateY(-50%); cursor:pointer; color:#6c757d;">
            <i class="fas fa-eye"></i>
        </span>
    </div>
</div>

        <div class="form-group mb-1">
            <div class="captcha-row">
              <div class="captcha-code" id="captcha-code">0000</div>
             <i class="fas fa-sync-alt captcha-refresh" onclick="generateCaptcha()" title="Refresh Captcha"></i>
        <input type="text"
               name="captcha"
               class="form-control form-control-custom captcha-input"
               placeholder="Enter Captcha"
              maxlength="4"
              minlength="4"
              pattern="[0-9]{4}"
              inputmode="numeric"
              oninput="this.value=this.value.replace(/[^0-9]/g,'').slice(0,4)"
               id="captcha-input"
               required>
       </div>
  
          <small id="captcha-error" class="text-danger" style="display:none;">
            Invalid captcha! Please try again.
          </small>
        </div>
        <button type="submit" class="btn btn-bloom btn-block mt-3">SIGN IN</button>
      </form>
    </div>
  </div>

  <script>
    function fillLogin(emID) {
      document.getElementById('emID').value = emID;
      document.getElementById('passField').value = 'password123';
    }

    const video = document.querySelector(".logoVideo");
    if(video) {
        video.addEventListener("timeupdate", () => {
          if (video.currentTime >= 6) video.currentTime = 2;
        });

        window.addEventListener('load', () => {
          video.play().catch(e => console.log("Autoplay blocked"));
        });
    }
  </script>
  <script>
    let currentCaptcha = "";

    function generateCaptcha() {
      currentCaptcha = Math.floor(1000 + Math.random() * 9000).toString();
      document.getElementById("captcha-code").innerText = currentCaptcha;
    }

    window.onload = generateCaptcha;
document.getElementById("login-form").addEventListener("submit", function (e) {

  const enteredCaptcha = document.getElementById("captcha-input").value.trim();
  const errorMsg = document.getElementById("captcha-error");

  if (enteredCaptcha !== currentCaptcha) {
    e.preventDefault();

    errorMsg.style.display = "block";

    document.getElementById("captcha-input").value = "";
    generateCaptcha();
    return;
  }

  errorMsg.style.display = "none";
});
document.getElementById("captcha-input").addEventListener("input", function () {
  document.getElementById("captcha-error").style.display = "none";
});
  </script>

  <script>
document.getElementById("togglePassword").addEventListener("click", function () {
    const password = document.getElementById("passField");
    const icon = this.querySelector("i");

    if (password.type === "password") {
        password.type = "text";
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");
    } else {
        password.type = "password";
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
    }
});
</script>
</body>

</html>