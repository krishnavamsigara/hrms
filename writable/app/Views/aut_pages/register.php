<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bloom Solutions | Agent Registration</title>
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
        background: #f0f2f5; 
        display: flex; 
        align-items: center; 
        justify-content: center; 
        min-height: 100vh; 
        margin: 0; 
        font-family: 'Inter', sans-serif; 
    }
    
    .login-container { 
        width: 900px; /* Slightly wider for registration fields */
        min-height: 600px; 
        display: flex; 
        box-shadow: 0 25px 50px rgba(0,0,0,0.2); 
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
        width: 180px;
        background: rgba(255, 255, 255, 0.1);
        padding: 8px;
        border-radius: 16px;
        backdrop-filter: blur(15px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.4);
        border: 1px solid rgba(255,255,255,0.2);
    }

    .logoVideo { width: 100%; border-radius: 10px; display: block; }

    .mountains-svg { position: absolute; bottom: 40px; left: 0; width: 100%; height: 200px; z-index: 5; }

    .water-container { position: absolute; bottom: 0; left: 0; width: 100%; height: 60px; z-index: 10; overflow: hidden; background: rgba(255, 255, 255, 0.05); }

    .wave { position: absolute; bottom: 0; left: 0; width: 200%; height: 100%; background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 800 100" preserveAspectRatio="none"><path d="M0,50 C150,100 350,0 500,50 C650,100 800,0 800,50 L800,100 L0,100 Z" fill="rgba(255,255,255,0.15)"/></svg>'); background-size: 50% 100%; animation: flow 12s linear infinite; }
    .wave.delay { animation: flow 8s linear infinite reverse; opacity: 0.6; bottom: 2px; }

    @keyframes flow { from { transform: translateX(0); } to { transform: translateX(-50%); } }

    /* FORM SIDE */
    .login-form-side { 
        flex: 1.2; 
        padding: 40px 50px; 
        display: flex; 
        flex-direction: column; 
        justify-content: center; 
    }

    .login-title { font-weight: 800; font-size: 26px; color: #1a1a1a; margin-bottom: 2px; }
    .subtitle { color: #888; margin-bottom: 25px; font-size: 13px; }

    .form-control-custom { 
        border: 1px solid #e8e8e8; 
        border-radius: 10px; 
        padding: 10px 15px; 
        height: 44px;
        margin-bottom: 12px;
        transition: all 0.3s ease;
        background: #fcfcfd;
        font-size: 14px;
    }
    .form-control-custom:focus { border-color: var(--bloom-purple); box-shadow: 0 0 0 4px rgba(74, 0, 224, 0.08); background: #fff; outline: none; }
     
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
    .btn-bloom:hover { transform: translateY(-1px); box-shadow: 0 10px 25px rgba(74, 0, 224, 0.35); color: #fff; }

    .text-bloom { color: var(--bloom-purple); font-weight: 600; }
    
    .form-row-custom { display: flex; gap: 15px; }
    .form-row-custom .form-group { flex: 1; }

  </style>
</head>                                                                                
<body>

<div class="login-container">
  <div class="login-visual-side">
    <div class="video-wrapper">
        <video class="logoVideo" muted playsinline autoplay loop>
            <source src="public/dist/img/Butterfly_Animation_Video_Generation.mp4" type="video/mp4">
        </video>
    </div>
    
    <div class="mt-4 text-center" style="z-index: 25;">
        <h4 class="font-weight-bold mb-1">Join Bloom Solutions</h4>
        <p class="small opacity-75">Start your journey with us today</p>
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
    <h1 class="login-title">Create Account</h1>
    <p class="subtitle">Join our network and manage your workspace.</p>
    
    <form action="login.html">
      <div class="form-row-custom">
        <div class="form-group mb-1">
            <label class="small font-weight-bold text-muted mb-1">FIRST NAME</label>
            <input type="text" class="form-control form-control-custom" placeholder="John" required>
        </div>
        <div class="form-group mb-1">
            <label class="small font-weight-bold text-muted mb-1">LAST NAME</label>
            <input type="text" class="form-control form-control-custom" placeholder="Doe" required>
        </div>
      </div>

      <div class="form-group mb-1">
        <label class="small font-weight-bold text-muted mb-1">WORK EMAIL</label>
        <input type="email" class="form-control form-control-custom" placeholder="john.doe@bloom.com" required>
      </div>

      <div class="form-group mb-1">
        <label class="small font-weight-bold text-muted mb-1">DEPARTMENT</label>
        <select class="form-control form-control-custom">
            <option>Operations</option>
            <option>Human Resources</option>
            <option>IT Support</option>
            <option>Management</option>
        </select>
      </div>
      
      <div class="form-row-custom">
        <div class="form-group mb-2">
            <label class="small font-weight-bold text-muted mb-1">PASSWORD</label>
            <input type="password" class="form-control form-control-custom" placeholder="••••••••" required>
        </div>
        <div class="form-group mb-2">
            <label class="small font-weight-bold text-muted mb-1">CONFIRM</label>
            <input type="password" class="form-control form-control-custom" placeholder="••••••••" required>
        </div>
      </div>

      <div class="form-group mb-3">
        <div class="custom-control custom-checkbox small">
            <input type="checkbox" class="custom-control-input" id="termsCheck" required>
            <label class="custom-control-label text-muted" for="termsCheck">I agree to the <a href="#" class="text-bloom">Terms of Service</a></label>
        </div>
      </div>

      <button type="submit" class="btn btn-bloom btn-block">REGISTER NOW</button>
    </form>
    
    <div class="text-center mt-3">
        <p class="small text-muted mb-0">Already have an account? <a href="login.html" class="text-bloom">Sign In</a></p>  
    </div>
  </div>
</div>

<script>
  const video = document.querySelector(".logoVideo");
  video.addEventListener("timeupdate", () => {
    if (video.currentTime >= 6) video.currentTime = 2;
  });

  window.addEventListener('load', () => {
    video.play().catch(e => console.log("Autoplay blocked"));
  });
</script>
</body>
</html>