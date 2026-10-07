<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Bloom Solutions | Login</title>

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
  body {
    margin: 0;
    font-family: 'Plus Jakarta Sans', sans-serif;
    height: 100vh;
    display: flex;
    background: linear-gradient(135deg, #120038, #4a00e0);
    overflow: hidden;
  }

  /* LEFT SIDE */
  .left {
    flex: 1;
    color: white;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: flex-start;
    padding: 80px;
    position: relative;
  }

  /* Glow effect */
  .left::before {
    content: "";
    position: absolute;
    width: 300px;
    height: 300px;
    background: rgba(255,255,255,0.1);
    border-radius: 50%;
    top: 10%;
    left: 20%;
    filter: blur(80px);
  }

  /* BRAND (LOGO + TEXT) */
  .brand {
    display: flex;
    align-items: center;
    gap: 10px;
  }

  .logo-video {
    width: 90px;
    border-radius: 8px;
  }

  .brand-title {
    margin: 0;
    font-size: 32px;
    font-weight: 700;
    letter-spacing: 0.5px;
  }

  .tagline {
    margin-top: 12px;
    opacity: 0.85;
    max-width: 360px;
    font-size: 14px;
    line-height: 1.6;
  }

  /* RIGHT SIDE */
  .right {
    flex: 1;
    display: flex;
    justify-content: center;
    align-items: center;
  }

  /* LOGIN CARD */
  .login-box {
    width: 340px;
    padding: 35px;
    border-radius: 16px;
    background: rgba(255,255,255,0.1);
    backdrop-filter: blur(25px);
    box-shadow: 0 20px 50px rgba(0,0,0,0.3);
    color: white;
  }

  .login-box h2 {
    margin-bottom: 5px;
    font-weight: 600;
  }

  .login-box p {
    font-size: 13px;
    opacity: 0.75;
    margin-bottom: 20px;
  }

  /* INPUTS */
  .input-group {
    position: relative;
    margin-bottom: 15px;
  }

  input {
    width: 100%;
    padding: 12px;
    border-radius: 10px;
    border: none;
    outline: none;
    font-size: 14px;
    background: rgba(255,255,255,0.15);
    color: white;
    transition: 0.3s;
  }

  input::placeholder {
    color: rgba(255,255,255,0.6);
  }

  input:focus {
    background: rgba(255,255,255,0.25);
    box-shadow: 0 0 0 2px rgba(255,255,255,0.2);
  }

  /* PASSWORD TOGGLE */
  .toggle {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
    font-size: 12px;
    opacity: 0.8;
  }

  /* BUTTON */
  button {
    width: 100%;
    padding: 12px;
    border-radius: 10px;
    border: none;
    font-weight: 600;
    cursor: pointer;
    background: white;
    color: #4a00e0;
    transition: all 0.3s ease;
  }

  button:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(255,255,255,0.4);
  }

  /* FOOTER */
  .footer {
    text-align: center;
    font-size: 12px;
    margin-top: 15px;
    opacity: 0.7;
  }

  /* DECLINE POPUP */
  .decline-modal {
    position: fixed;
    top: 0; left: 0; width: 100%; height: 100%;
    background: rgba(0,0,0,0.6);
    backdrop-filter: blur(5px);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1000;
    opacity: 0;
    visibility: hidden;
    transition: 0.3s;
  }
  .decline-modal.show {
    opacity: 1;
    visibility: visible;
  }
  .decline-content {
    background: #fff;
    padding: 35px 25px;
    border-radius: 16px;
    text-align: center;
    width: 320px;
    color: #334155;
    transform: scale(0.9);
    transition: 0.3s;
    box-shadow: 0 20px 40px rgba(0,0,0,0.4);
  }
  .decline-modal.show .decline-content {
    transform: scale(1);
  }
  .decline-icon {
    font-size: 50px;
    color: #ef4444;
    margin-bottom: 15px;
  }
  .decline-content h3 { margin: 0 0 10px; color: #120038; font-size: 22px; font-weight: 700; }
  .decline-content p { font-size: 14px; margin-bottom: 25px; line-height: 1.6; color: #475569; }
  .decline-content button {
    background: #120038;
    color: #fff;
    border: none;
    padding: 12px 20px;
    border-radius: 10px;
    cursor: pointer;
    font-weight: 600;
  }
  .decline-content button:hover {
    transform: translateY(0);
    box-shadow: none;
    background: #4a00e0;
  }
</style>
</head>

<body>

<!-- LEFT SIDE -->
<div class="left">
  <div class="brand">
    <video class="logo-video" autoplay muted loop playsinline>
      <source src="public\dist\img\Butterfly_Animation_Video_Generation.mp4" type="video/mp4">
    </video>
    <h1 class="brand-title">Bloom Solutions</h1>
  </div>
  <p class="tagline">
    Experience a smarter way to manage HR operations.
  </p>
</div>

<!-- RIGHT SIDE -->
<div class="right">
  <div class="login-box">
    <h2>Sign In</h2>
    <p>Access your dashboard securely</p>

    <?php if(session()->getFlashdata('error')): ?>
    <div style="color: red; margin-bottom: 10px; font-weight: bold;">
        <?= session()->getFlashdata('error'); ?>
    </div>
<?php endif; ?>

    <form method="post" action="<?= base_url('on_boarding/login_check') ?>">
      <div class="input-group">
        <input type="text" name="refid" placeholder="Reference Id" required>
      </div>

      <div class="input-group">
        <input type="password" id="password" name="password" placeholder="Password" required>
        <span class="toggle" onclick="togglePass()">Show</span>
      </div>

    <button type="submit">
  Login
</button>
    </form>

    <div class="footer">© Bloom Solutions</di
      >
  </div>
</div>

<!-- DECLINE MODAL -->
<div class="decline-modal" id="declineModal">
  <div class="decline-content">
    <div class="decline-icon">
      <i class="fas fa-info-circle"></i>
    </div>
    <h3>Thank You</h3>
    <p>Your response has been recorded. Please note that your login credentials will no longer be active.</p>
    <button onclick="document.getElementById('declineModal').classList.remove('show')">Acknowledge</button>
  </div>
</div>

<script>
  // Check if we just declined an offer
  if (localStorage.getItem("show_decline_msg") === "true") {
    document.getElementById("declineModal").classList.add("show");
    localStorage.removeItem("show_decline_msg");
  }

function togglePass() {
  const pass = document.getElementById("password");
  pass.type = pass.type === "password" ? "text" : "password";
}
</script>

</body>
</html>                 