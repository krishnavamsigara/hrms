<?php
$details = $details[0] ?? [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>BloomHR | Bank Details</title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="<?= base_url('public/dist/css/onboarding.css') ?>">
<style>
    .required-error {
    border: 1px solid red !important;
}

.error-toast{
    display:none;
    background:#fee2e2;
    color:#b91c1c;
    border:1px solid #fecaca;
    padding:14px 18px;
    border-radius:10px;
    margin-bottom:20px;
    font-weight:600;
    align-items:center;
    gap:10px;
}

.error-toast.show{
    display:flex;
}

</style>
</head>
<body>

<header class="app-header">
    <a href="#" class="brand-logo">
        <i class="fas fa-leaf"></i> BloomHR
    </a>
    <div class="user-profile">
        <div class="avatar">U</div>
        <a href="<?= base_url('on_boarding/onboard_login') ?>" class="logout-btn">Logout</a>
    </div>
</header>

<div class="app-container">
    <aside class="app-sidebar">
        <ul class="stepper-nav" id="sidebar-list">
            <!-- Injected by onboarding.js -->
        </ul>
    </aside>

    <main class="app-main">
        <div class="content-wrapper">
            <form method="post" id="bankForm" novalidate>
            <h1 class="page-title">Bank Details</h1>

            <div id="errorToast" class="error-toast">
    <i class="fas fa-circle-exclamation"></i>
    <span id="errorMessage"></span>
</div>

            <!-- Draft Mode Editable Banner -->
            <div class="edit-badge-bar" style="display: flex; align-items: center; gap: 8px; background: #eef2ff; color: #4338ca; border: 1px solid #c7d2fe; padding: 10px 16px; border-radius: 12px; margin-bottom: 25px; font-size: 13px; font-weight: 600;">
                <i class="fas fa-pen-to-square"></i>
                <span><strong>Draft Mode:</strong> You can modify your entries at any stage. Changes are allowed until final submission.</span>
            </div>

            <div class="main-card">
                <h3 class="section-title" style="display:flex; justify-content:space-between; align-items:center;">
    <span>
        <i class="fas fa-university"></i>
        Salary Account Information
    </span>

    <button type="button"
            onclick="toggleBankFields(this)"
            style="padding:5px 12px; border:none; background:#4f46e5; color:#fff; border-radius:6px; cursor:pointer;">
        <i class="fas fa-eye"></i> View
    </button>
</h3>
                <div class="grid">
                    <div class="form-group">
                        <label>Account Holder Name <span class="required">*</span></label>
                        <input type="text" id="bankHolder" name="bankHolder" class="form-control" placeholder="Enter Account Holder Name (as per Bank Records)" value="<?= $details['bank_holder_name'] ?? '' ?>" required>
                    </div>

                    <div class="form-group">
                        <label>Bank Name <span class="required">*</span></label>
                        <input type="text" id="bankName" name="bankName" class="form-control" placeholder="E.g., HDFC Bank, ICICI Bank"  value="<?= $details['bank_name'] ?? '' ?>" required>
                    </div>

                    <div class="form-group">
                        <label>Account Number <span class="required">*</span></label>
                        <input type="password" id="bankAcc" name="bankAcc" class="form-control bank-secure" placeholder="Enter Salary Account Number" value="<?= $details['bank_account_no'] ?? '' ?>" required>
                    </div>

                    <div class="form-group">
                        <!-- <div style="position:relative;"> -->
                        <label>Confirm Account Number <span class="required">*</span></label>
                        <input type="password" id="bankAccConfirm" name="bankAccConfirm" class="form-control bank-secure" placeholder="Re-enter Account Number"  value="<?= $details['bank_account_no'] ?? '' ?>" required>
                         <!-- <span onclick="toggleField('bankAccConfirm', this)"
              style="position:absolute; right:12px; top:65%; transform:translateY(-50%); cursor:pointer;">
            <i class="fas fa-eye"></i>
        </span>
                    </div> -->
                    </div>

                    <div class="form-group">
                        <label>IFSC Code <span class="required">*</span></label>
                        <input type="text" id="bankIfsc" name="bankIfsc" class="form-control" placeholder="11-digit Alphanumeric IFSC" value="<?= $details['ifsc'] ?? '' ?>" required>
                    </div>

                    <div class="form-group">
                        <label>Branch Name <span class="required">*</span></label>
                        <input type="text" id="bankBranch" name="bankBranch" class="form-control" placeholder="Bank Branch Name"  value="<?= $details['bank_branch'] ?? '' ?>" required>
                    </div>

                    <div class="form-group">
                        <label>UPI ID (Optional)</label>
                        <input type="text" id="upiId" name="upiId" class="form-control" placeholder="username@bank"   value="<?= $details['upi_id'] ?? '' ?>">
                    </div>

                    <div class="form-group">
                        <label>Account Type <span class="required">*</span></label>
                        <select id="bankAccType" name="bankAccType" class="form-control" required>

                        <option value="">Select Type <span class="required">*</span></option>

                        <option value="SAVINGS"
                            <?= ($details['bank_account_type'] ?? '') == 'SAVINGS' ? 'selected' : '' ?>>
                            Savings
                        </option>

                        <option value="CURRENT"
                            <?= ($details['bank_account_type'] ?? '') == 'CURRENT' ? 'selected' : '' ?>>
                            Current
                        </option>

                        <option value="SALARY"
                            <?= ($details['bank_account_type'] ?? '') == 'SALARY' ? 'selected' : '' ?>>
                            Salary
                        </option>

                  </select>
                    </div>
                </div>

                <div class="action-buttons">
                    <a href="<?= base_url('on_boarding/personal_details') ?>" class="btn btn-outline">
                        <i class="fas fa-arrow-left"></i> Back
                    </a>
                    <button type="submit" class="btn btn-primary">
                    Save & Next <i class="fas fa-arrow-right"></i>
                </button>
                </div>
            </div>
        </div>
  </form>
        <footer class="app-footer">
            &copy; 2026 Bloom Solutions. All rights reserved.
        </footer>
    </main>
</div>

<script>
    const BASE_URL = "<?= base_url() ?>";
</script>
<script src="<?= base_url('public/dist/js/onboarding.js') ?>"></script>
<script>
let bankVisible = false;

function toggleBankFields(btn) {

    let fields = document.querySelectorAll('.bank-secure');
    let icon = btn.querySelector('i');

    if (fields.length === 0) {
        alert("No secure fields found");
        return;
    }

    bankVisible = !bankVisible;

    fields.forEach(input => {
        input.type = bankVisible ? "text" : "password";
    });

    btn.innerHTML = bankVisible
        ? '<i class="fas fa-eye-slash"></i> Hide'
        : '<i class="fas fa-eye"></i> View';
}

document.getElementById('bankForm').addEventListener('submit', function (e) {

    const inputs = this.querySelectorAll("[required]");
    let valid = true;

    inputs.forEach(input => {
        if (!input.value.trim()) {
            input.classList.add("required-error");
            valid = false;
        } else {
            input.classList.remove("required-error");
        }
    });

    // ACCOUNT MATCH VALIDATION (IMPORTANT PART)
    const acc = document.getElementById('bankAcc').value.trim();
    const confirmAcc = document.getElementById('bankAccConfirm').value.trim();

    if (acc !== confirmAcc) {
        e.preventDefault();
        showError("Account Number and Confirm Account Number do not match.");

        document.getElementById('bankAccConfirm').classList.add("required-error");
        valid = false;
    }

    if (!valid) {
        e.preventDefault(); // STOP NEXT PAGE
    }
});

function showError(message){

    const toast = document.getElementById("errorToast");
    const msg = document.getElementById("errorMessage");

    msg.innerText = message;

    toast.classList.add("show");

    setTimeout(() => {
        toast.classList.remove("show");
    }, 3000);

}
</script>

</body>
</html>
