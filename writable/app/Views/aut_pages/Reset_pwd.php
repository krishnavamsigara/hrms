
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>BloomHR | Change Password</title>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
  
  <style>
    :root {
        --bloom-purple: #4a00e0;
        --bloom-dark: #2a0080;
        --mtn-deep: #120038;
        --bloom-orange: #e46c44;
        --bloom-success: #10b981;
        --bloom-danger: #ef4444;
        --bloom-muted: #64748b;
    }

   body{
    font-family:'Plus Jakarta Sans',sans-serif;
    background:linear-gradient(135deg,#f7f5ff 0%,#eef2ff 45%,#ffffff 100%);
    font-size:13px;
    color:#334155;
}
    .nav-pills .nav-link.active { background: #007bff !important; color: #fff !important; }
    
    /* Change Password UI Styles */
    .password-card {
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        background: #fff;
    }
    
    .input-group-text {
        background-color: #f8fafc;
        border-color: #e2e8f0;
        color: var(--bloom-muted);
        cursor: pointer;
    }
    
    .form-control {
        border-color: #e2e8f0;
        border-radius: 8px;
        font-size: 13px;
        height: 40px;
    }
    
    .form-control:focus {
        border-color: var(--bloom-purple);
        box-shadow: 0 0 0 3px rgba(74, 0, 224, 0.1);
    }

    /* Strength Meter Bar */
    .strength-meter {
        height: 5px;
        background-color: #e2e8f0;
        border-radius: 3px;
        overflow: hidden;
        transition: all 0.3s ease;
    }
    
    .strength-bar {
        height: 100%;
        width: 0%;
        transition: all 0.3s ease;
    }

    /* Checklist Side Panel Instruction styles */
    .instruction-panel {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
    }

    .rule-item {
        font-size: 12.5px;
        font-weight: 600;
        color: var(--bloom-muted);
        display: flex;
        align-items: center;
        margin-bottom: 10px;
        transition: all 0.2s ease;
    }
    
    .rule-item i {
        margin-right: 10px;
        font-size: 15px;
        width: 16px;
        text-align: center;
    }
    
    .rule-item.valid {
        color: var(--bloom-success);
    }
    
    .rule-item.invalid {
        color: var(--bloom-danger);
    }

    .main-footer { background: #fff !important; border-top: 1px solid #e2e8f0 !important; font-size: 12px; padding: 1rem 1.5rem !important; }

    .password-card,
.instruction-panel{
    border:none;
    border-radius:22px;
    background:#fff;
    box-shadow:0 20px 50px rgba(74,0,224,.10);
    transition:.3s;
}

.password-card:hover,
.instruction-panel:hover{
    transform:translateY(-4px);
    box-shadow:0 28px 70px rgba(74,0,224,.18);
}

.logo-box{
    background:#fff;
    border-radius:18px;
    padding:18px 35px;
    display:inline-block;
    box-shadow:0 12px 30px rgba(74,0,224,.08);
}


  </style>
</head>
<body class="hold-transition login-page" style="background-color:#f4f7fe;">
<div class="container-fluid d-flex align-items-center justify-content-center" style="min-height:100vh;">

    <div>

        <div class="text-center mb-4">
           <div class="logo-box">

       <img src="<?= base_url('public/dist/img/image.png') ?>"
     alt="BloomHR"
     style="width:240px; height:70px; object-fit:contain;">
    </div>

           <p class="small font-weight-600 mt-3 mb-0"
   style="color:#475569; font-size:14px; letter-spacing:0.3px;">
    Secure Password Reset Portal
</p>
        </div>

        <div class="row justify-content-center">
          
          <div class="col-lg-5 col-md-6 mb-4">
            <div class="card password-card shadow-sm h-100">
              <div class="card-header border-0 bg-transparent pt-4 px-4">
                <h5 class="card-title font-weight-bold mb-0" style="color: var(--mtn-deep);">
                  <i class="fas fa-key text-primary mr-2"></i>Change System Password
                </h5>
              </div>
              
              <div class="card-body px-4 pb-4">

              <?php if(session()->getFlashdata('success')): ?>
    <div class="alert alert-success">
        <?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>

<?php if(session()->getFlashdata('error')): ?>
    <div class="alert alert-danger">
        <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>
                <form id="changePasswordForm"
      action="<?= base_url('resetForgotPassword') ?>"
      method="POST">

      <input type="hidden" name="token" value="<?= $token ?>">
      <input type="hidden" name="emp_id" value="<?= $emp_id ?>">
                  
                  <!-- <div class="form-group mb-3">
                    <label class="font-weight-bold small text-dark">Current Password</label>
                    <div class="input-group">
                      <input type="password"
       id="currentPassword"
       name="old_password"
       class="form-control"
       required
       placeholder="Enter current password" placeholder="Enter current password">
                      <div class="input-group-append" onclick="togglePasswordVisibility('currentPassword', 'currentPassIcon')">
                        <span class="input-group-text"><i id="currentPassIcon" class="far fa-eye"></i></span>
                      </div>
                    </div>
                  </div> -->

                  <div class="form-group mb-2">
                    <label class="font-weight-bold small text-dark">New Strong Password</label>
                    <div class="input-group">
                      <input type="password" id="newPassword" name="new_password"class="form-control" required placeholder="Enter complex secure password" oninput="validatePasswordStrength()">
                      <div class="input-group-append" onclick="togglePasswordVisibility('newPassword', 'newPassIcon')">
                        <span class="input-group-text"><i id="newPassIcon" class="far fa-eye"></i></span>
                      </div>
                    </div>
                  </div>

                  <div class="mb-3">
                    <div class="strength-meter mb-1">
                      <div id="strengthBar" class="strength-bar"></div>
                    </div>
                    <div class="d-flex justify-content-between text-xs font-weight-bold">
                      <span id="strengthText" style="color: var(--bloom-muted);">Strength: Empty</span>
                    </div>
                  </div>

                  <div class="form-group mb-4">
                    <label class="font-weight-bold small text-dark">Confirm New Password</label>
                    <div class="input-group">
                      <input type="password"id="confirmPassword" name="confirm_password" class="form-control"  required placeholder="Re-type new password" oninput="checkPasswordMatch()">
                      <div class="input-group-append" onclick="togglePasswordVisibility('confirmPassword', 'confirmPassIcon')">
                        <span class="input-group-text"><i id="confirmPassIcon" class="far fa-eye"></i></span>
                      </div>
                    </div>
                    <div id="matchFeedback" class="small font-weight-bold mt-1 d-none"></div>
                  </div>

                  <button type="submit" id="submitBtn" class="btn py-1.5 px-4 text-white font-weight-bold" 
                          style="background-color: var(--bloom-purple); border-radius: 8px; border:none; font-size: 12px;" disabled>
                    <i class="fas fa-save mr-2"></i>Update Account Password
                  </button>
                </form>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 mb-4">
            <div class="instruction-panel p-4 shadow-sm h-100 d-flex flex-column justify-content-center">
              <h6 class="font-weight-bold mb-1" style="color: var(--mtn-deep);">Password Validation Requirements</h6>
              <p class="text-muted small mb-4">Your new security string signature must satisfy all parameter validations below to activate changes updates.</p>
              
              <div class="p-1">
                <div id="rule-capital" class="rule-item">
                  <i class="far fa-circle"></i> At least 1 Capital Letter (A-Z)
                </div>
                <div id="rule-lowercase" class="rule-item">
                  <i class="far fa-circle"></i> At least 1 Lowercase Letter (a-z)
                </div>
                <div id="rule-number" class="rule-item">
                  <i class="far fa-circle"></i> At least 1 Number Digit (0-9)
                </div>
                <div id="rule-special" class="rule-item">
                  <i class="far fa-circle"></i> At least 1 Special Character (@, $, !, %, *, #)
                </div>
                <div id="rule-length" class="rule-item">
                  <i class="far fa-circle"></i> Minimum 8 Characters total size length
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
       </div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

<script>
  function togglePasswordVisibility(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon = document.getElementById(iconId);
    if (input.type === "password") {
      input.type = "text";
      icon.className = "far fa-eye-slash";
    } else {
      input.type = "password";
      icon.className = "far fa-eye";
    }
  }

  function validatePasswordStrength() {
    const password = document.getElementById("newPassword").value;
    
    const checks = {
      capital: /[A-Z]/.test(password),
      lowercase: /[a-z]/.test(password),
      number: /[0-9]/.test(password),
      special: /[@$!%*?&#]/.test(password),
      length: password.length >= 8
    };

    let passedCount = 0;

    for (const [key, passed] of Object.entries(checks)) {
      const element = document.getElementById(`rule-${key}`);
      const icon = element.querySelector("i");
      
      if (password.length === 0) {
        element.className = "rule-item";
        icon.className = "far fa-circle";
      } else if (passed) {
        element.className = "rule-item valid";
        icon.className = "fas fa-check-circle";
        passedCount++;
      } else {
        element.className = "rule-item invalid";
        icon.className = "fas fa-times-circle";
      }
    }

    const progressBar = document.getElementById("strengthBar");
    const progressText = document.getElementById("strengthText");
    
    let percentage = (passedCount / 5) * 100;
    progressBar.style.width = percentage + "%";

    if (password.length === 0) {
      progressBar.style.backgroundColor = "#e2e8f0";
      progressText.innerText = "Strength: Empty";
      progressText.style.color = "var(--bloom-muted)";
    } else if (passedCount <= 2) {
      progressBar.style.backgroundColor = "var(--bloom-danger)";
      progressText.innerText = "Strength: Weak 🚫";
      progressText.style.color = "var(--bloom-danger)";
    } else if (passedCount <= 4) {
      progressBar.style.backgroundColor = "var(--bloom-orange)";
      progressText.innerText = "Strength: Medium ⚠️";
      progressText.style.color = "var(--bloom-orange)";
    } else {
      progressBar.style.backgroundColor = "var(--bloom-success)";
      progressText.innerText = "Strength: Strong / Secure Peak ✅";
      progressText.style.color = "var(--bloom-success)";
    }

    checkPasswordMatch();
  }

  function checkPasswordMatch() {
    const password = document.getElementById("newPassword").value;
    const confirmPassword = document.getElementById("confirmPassword").value;
    const feedback = document.getElementById("matchFeedback");
    const submitBtn = document.getElementById("submitBtn");
    
    const allRulesPassed = /[A-Z]/.test(password) && 
                           /[a-z]/.test(password) && 
                           /[0-9]/.test(password) && 
                           /[@$!%*?&#]/.test(password) && 
                           password.length >= 8;

    if (confirmPassword.length === 0) {
      feedback.className = "small font-weight-bold mt-1 d-none";
      submitBtn.disabled = true;
      return;
    }

    feedback.classList.remove("d-none");
    if (password === confirmPassword && allRulesPassed) {
      feedback.className = "small font-weight-bold mt-1 text-success";
      feedback.innerText = "✓ Passwords verification match confirmed.";
      submitBtn.disabled = false;
    } else {
      feedback.className = "small font-weight-bold mt-1 text-danger";
      if(!allRulesPassed) {
        feedback.innerText = "✗ Password must meet all strength requirements above.";
      } else {
        feedback.innerText = "✗ Passwords do not match.";
      }
      submitBtn.disabled = true;
    }
  }

//   function handleFormSubmit(event) {
//     event.preventDefault();
//     alert("Success! Your password has been securely updated.");
//     document.getElementById("changePasswordForm").reset();
//     validatePasswordStrength();
//   }
</script>
</body>
</html>
