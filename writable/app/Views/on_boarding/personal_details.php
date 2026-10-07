<?php

$details = $details[0] ?? [];

// CURRENT ADDRESS
$current_address = [];

if (!empty($details['current_address'])) {

    $current_address = json_decode(
        $details['current_address'],
        true
    );
}

// PERMANENT ADDRESS
$perminent_address = [];

if (!empty($details['perminent_address'])) {

    $perminent_address = json_decode(
        $details['perminent_address'],
        true
    );
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>BloomHR | Personal Details</title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="<?= base_url('public/dist/css/onboarding.css') ?>">
<style>
    .required-error {
    border: 1px solid red !important;
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
            <form method="post" id="onboardForm" novalidate>
                <input type="hidden" name="refid" value="<?= session()->get('ref_id') ?>">
            <h1 class="page-title">Personal Information</h1>

            <!-- Draft Mode Editable Banner -->
            <div class="edit-badge-bar" style="display: flex; align-items: center; gap: 8px; background: #eef2ff; color: #4338ca; border: 1px solid #c7d2fe; padding: 10px 16px; border-radius: 12px; margin-bottom: 25px; font-size: 13px; font-weight: 600;">
                <i class="fas fa-pen-to-square"></i>
                <span><strong>Draft Mode:</strong> You can modify your entries at any stage. Changes are allowed until final submission.</span>
            </div>

            <div class="main-card">
                <h3 class="section-title">
                    <i class="fas fa-id-card"></i>
                    Basic Details
                </h3>

                <div class="grid">
                   <div class="form-group">
    <label>First Name <span class="required">*</span></label>
    <input type="text"
           id="firstName"
           name="firstName"
           class="form-control"
           placeholder="Enter First Name"
           value="<?= explode(' ', $details['emp_name'] ?? '', 2)[0] ?? '' ?>"
           required>
</div>

<div class="form-group">
    <label>Last Name <span class="required">*</span></label>
    <input type="text"
           id="lastName"
           name="lastName"
           class="form-control"
           placeholder="Enter Last Name"
           value="<?= explode(' ', $details['emp_name'] ?? '', 2)[1] ?? '' ?>"
           required>
</div>
                  <div class="form-group">
    <label>Mobile Number <span class="required">*</span></label>

    <div style="display:flex; align-items:center;">
        
        <!-- fixed +91 display -->
        <span style="padding:14px 12px; background:#eee; border-radius:6px 0 0 6px; border-right:0;">
            +91
        </span>

        <input type="tel"
               id="mobile"
               name="mobile"
               class="form-control"
               value="<?= $details['mobile'] ?? '' ?>"
               placeholder="Enter 10 digit number"
               maxlength="10"
               pattern="[6-9][0-9]{9}"
               title="Enter valid 10-digit Indian mobile number"
               style="border-radius:0 6px 6px 0;"
               required>
    </div>
</div>

                    <div class="form-group">
                        <label>Email Address <span class="required">*</span></label>
                        <input type="email"
       id="email"
       name="email"
       class="form-control"
       value="<?= $details['email'] ?? '' ?>" pattern="^[a-zA-Z0-9._%+-]+@(gmail\.com|yahoo\.com)$"
           title="Only Gmail and Yahoo emails are allowed" required>
                    </div>

                    <div class="form-group">
                        <label>Date of Birth <span class="required">*</span></label>
                        <input type="date" id="dob" name="dob" class="form-control" value="<?= $details['dob'] ?? '' ?>" required>
                    </div>

                    <div class="form-group">
                        <label>Gender <span class="required">*</span></label>
                        <select id="gender" name="gender" class="form-control" required>

    <option value="">Select Gender</option>

    <option value="MALE"
        <?= ($details['gender'] ?? '') == 'MALE' ? 'selected' : '' ?>>
        Male
    </option>

    <option value="FEMALE"
        <?= ($details['gender'] ?? '') == 'FEMALE' ? 'selected' : '' ?>>
        Female
    </option>

    <option value="OTHER"
        <?= ($details['gender'] ?? '') == 'OTHER' ? 'selected' : '' ?>>
        Other
    </option>

</select>
                    </div>
        
                    <div class="form-group">
                        <label>Marital Status</label>
                       <select id="marital" name="marital" class="form-control">

    <option value="">Select Status</option>

    <option value="SINGLE"
        <?= ($details['marital_status'] ?? '') == 'SINGLE' ? 'selected' : '' ?>>
        Single
    </option>

    <option value="MARRIED"
        <?= ($details['marital_status'] ?? '') == 'MARRIED' ? 'selected' : '' ?>>
        Married
    </option>

</select>
                    </div>

                    <div class="form-group">
                        <label>Father's Name <span class="required">*</span></label>
                        <input type="text" id="fatherName" name="fatherName" class="form-control" placeholder="Father's Full Name" value="<?= $details['father_name'] ?? '' ?>" required>
                    </div>

                    <div class="form-group">
                        <label>Mother's Name <span class="required">*</span></label>
                        <input type="text" id="motherName" name="motherName" class="form-control" placeholder="Mother's Full Name" value="<?= $details['mother_name'] ?? '' ?>" required>
                    </div>
                </div>

                <h3 class="section-title" style="margin-top: 40px;">
                    <i class="fas fa-address-book"></i>
                    Address & ID Details
                </h3>

                <div class="grid">
                    <div class="form-group">
                        <label>Aadhaar Number <span class="required">*</span></label>
                        <input type="text" id="aadhaarNumber" name="aadhaarNumber" class="form-control"  placeholder="1234-5678-9012" value="<?= !empty($details['aadhaar']) ? substr(chunk_split($details['aadhaar'], 4, '-'), 0, 14) : '' ?>"  maxlength="14" 
            pattern="[0-9]{4}-[0-9]{4}-[0-9]{4}"
           title="Aadhaar must be exactly 14 digits"required >
                    </div>

                    <div class="form-group">
                        <label>PAN Number <span class="required">*</span></label>
                        <input type="text" id="panNumber" name="panNumber" class="form-control" placeholder="ABCDE1234F" value="<?= $details['pan'] ?? '' ?>" maxlength="10"
           pattern="[A-Z]{5}[0-9]{4}[A-Z]{1}"
           title="PAN format must be like ABCDE1234F" required>
                    </div>

                  <div class="form-group">
    <label>House No <span class="required">*</span></label>
    <input type="text" id="houseNo" name="houseNo" class="form-control" 
value="<?= $current_address['houseNo'] ?? '' ?>"
placeholder="House No" required>
</div>

<div class="form-group">
    <label>Area <span class="required">*</span></label>
   <input type="text" id="area" name="area"  class="form-control" 
value="<?= $current_address['area'] ?? '' ?>"
placeholder="Area" required>
</div>

<div class="form-group">
    <label>Street No</label>
   <input type="text" id="streetNo" name="streetNo"  class="form-control" 
value="<?= $current_address['streetNo'] ?? '' ?>"
placeholder="Street No">
</div>

<div class="form-group">
    <label>Building Name</label>
    <input type="text" id="buildingName" name="buildingName"  class="form-control" 
value="<?= $current_address['buildingName'] ?? '' ?>"
placeholder="Building Name">
</div>

<!-- IMPORTANT hidden field -->
<input type="hidden" id="address" name="address">

                    <div class="form-group">
                        <label>City <span class="required">*</span></label>
                       <input type="text"
       id="city"
       name="city"
       class="form-control"
       placeholder="City"
       value="<?= $current_address['city'] ?? '' ?>" required>
                    </div>

                    <div class="form-group">
                        <label>State <span class="required">*</span></label>
                        <input type="text"
       id="state"
       name="state"
       class="form-control"
       placeholder="State"
       value="<?= $current_address['state'] ?? '' ?>"required>
                    </div>

                    <div class="form-group">
                        <label>Pincode <span class="required">*</span></label>
                       <input type="text"
       id="pincode"
       name="pincode"
       class="form-control"
       placeholder="6-digit Pincode"
       value="<?= $current_address['pincode'] ?? '' ?>" required>
                    </div>

                    <div class="form-group">
                        <label>Emergency Contact</label>
                        <input type="text" id="emergencyContact" name="emergencyContact" class="form-control" placeholder="Emergency Contact Number">
                    </div>
                </div>

                <div class="action-buttons">
                    <a href="<?= base_url('on_boarding/document_checklist') ?>" class="btn btn-outline">
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
document.getElementById('panNumber').addEventListener('input', function () {
    this.value = this.value.toUpperCase();
});
document.getElementById('aadhaarNumber').addEventListener('input', function () {
    let v = this.value.replace(/\D/g, '').substring(0, 12);
    this.value = v.replace(/(\d{4})(?=\d)/g, '$1-');
});
document.getElementById('email').addEventListener('input', function () {
    const value = this.value;
    const regex = /^[a-zA-Z0-9._%+-]+@(gmail\.com|yahoo\.com)$/;

    if (value && !regex.test(value)) {
        this.setCustomValidity("Only Gmail and Yahoo emails are allowed");
    } else {
        this.setCustomValidity("");
    }
});

document.getElementById('mobile').addEventListener('input', function () {
    this.value = this.value.replace(/\D/g, '').slice(0, 10);
});
document.getElementById('onboardForm').addEventListener('submit', function (e) {

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

    if (!valid) {
        e.preventDefault(); // STOP next page
    }
});
</script>
</body>
</html>