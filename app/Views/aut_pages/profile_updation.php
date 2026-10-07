
<?php
$currentAddress = json_decode($profile['current_address'] ?? '{}', true);
$qualification  = json_decode($profile['qualification'] ?? '[]', true);

$experienceRaw = $profile['experience'] ?? '[]';
$experience = json_decode($experienceRaw, true);
// safety fallback (VERY IMPORTANT)
if (!is_array($experience)) {
    $experience = [];
}

$documents      = json_decode($profile['documents'] ?? '{}', true);

?>
<?php
$isFresher = false;

if (!empty($experience)) {
    $isFresher = isset($experience[0]['employment_type']) 
        && strtoupper($experience[0]['employment_type']) == 'FRESHER';
}
?>
<?php
$graduation = [];
$intermediate = [];
$tenth = [];
$higherEducation = [];

foreach ($qualification as $q) {

    if (($q['education_type'] ?? '') == 'graduation') {
        $graduation = $q;
    }

    if (($q['education_type'] ?? '') == 'intermediate') {
        $intermediate = $q;
    }

    if (($q['education_type'] ?? '') == '10th') {
        $tenth = $q;
    }
     if (($q['education_type'] ?? '') == 'higher') {
        $higherEducation[] = $q;
    }

}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bloom Solution | Profile Updation</title>

    <!-- External CSS Libraries -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">

    <style>
        :root {
            --bloom-purple: #4a00e0;
            --bloom-dark: #120038;
            --bloom-success: #10b981;
            --bloom-danger: #ef4444;
            --bloom-bg: #f8fafc;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bloom-bg);
            font-size: 13px;
            color: #334155;
            padding-bottom: 60px;
        }

        .content-wrapper {
            background: var(--bloom-bg);
        }

        /* Grid Constraints */
        .grid-3 {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 15px;
        }

        /* Form Elements */
        .form-group {
            margin-bottom: 15px;
            min-width: 0;
        }

        .form-group.span-3 {
            grid-column: span 3;
        }

        .form-control-sm,
        .custom-select-sm,
        textarea.form-control-sm {
            width: 100% !important;
            max-width: 100% !important;
            box-sizing: border-box !important;
            border-radius: 8px !important;
            border: 1px solid #e2e8f0 !important;
            color: #1e293b !important;
            background-color: #fff !important;
            font-weight: 500;
            padding: 6px 12px !important;
            font-size: 13px !important;
            transition: all 0.2s ease;
        }

        .form-control-sm {
            height: 34px !important;
        }

        textarea.form-control-sm {
            height: auto !important;
            min-height: 60px;
        }

        .form-control-sm:focus,
        .custom-select-sm:focus,
        textarea.form-control-sm:focus {
            border-color: var(--bloom-purple) !important;
            box-shadow: 0 0 0 2px rgba(74, 0, 224, 0.15) !important;
            outline: none;
        }

        .form-group label {
            font-weight: 600;
            color: #64748b;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }

        /* Top Section Wrapper Style */
        .top-section {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 25px;
            background: #fff;
            padding: 15px 20px;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        .header-left-side {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .logo-box {
            width: 40px;
            height: 40px;
            background: rgba(74, 0, 224, 0.1);
            color: var(--bloom-purple);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }

        .top-section h2 {
            font-size: 18px;
            font-weight: 700;
            color: var(--bloom-dark);
            margin: 0;
        }

        /* Master Card Layout Structure */
        .main-card {
            background: #fff;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            border: 1px solid #e2e8f0;
        }

        .section-header-wrap {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #f1f5f9;
        }

        .section-title {
            font-size: 15px;
            font-weight: 700;
            color: var(--bloom-dark);
            display: flex;
            align-items: center;
            gap: 8px;
            margin: 0;
        }

        .section-title i {
            color: var(--bloom-purple);
        }

        .photo-center-row {
            display: flex;
            justify-content: center;
            width: 100%;
            margin-bottom: 20px;
            border-bottom: 1px dashed #e2e8f0;
            padding-bottom: 20px;
        }

        /* Master Grid Layout */
        .workspace-container {
            display: flex;
            gap: 20px;
            align-items: flex-start;
        }

        .form-workspace-left {
            flex: 1;
            min-width: 0;
        }

        /* Add Button style */
        .btn-add-icon {
            background: rgba(74, 0, 224, 0.1);
            color: var(--bloom-purple);
            border: 1px dashed var(--bloom-purple);
            border-radius: 50%;
            width: 32px;
            height: 32px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: 0.2s;
        }

        .btn-add-icon:hover {
            background: var(--bloom-purple);
            color: #fff;
        }

        .password-wrapper {
            position: relative;
        }

        .password-wrapper i {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #94a3b8;
        }

        /* Hide default Edge/IE reveal eye icon since we have a custom one */
        input[type="password"]::-ms-reveal,
        input[type="password"]::-ms-clear {
            display: none;
        }


        /* --- BLOOM BACK BUTTON --- */
.btn-bloom-back {
    background: #fff;
    color: var(--bloom-purple) !important;
    border: 1px solid var(--bloom-purple);
    border-radius: 10px;
    font-weight: 700;
    font-size: 12px;
    padding: 8px 18px;
    transition: all 0.3s ease;
    box-shadow: 0 2px 4px rgba(74, 0, 224, 0.08);
}

.btn-bloom-back:hover {
    background: linear-gradient(
        135deg,
        var(--bloom-purple) 0%,
        var(--bloom-dark) 100%
    );
    color: #fff !important;
    border-color: var(--bloom-purple);
    transform: translateY(-1px);
    box-shadow: 0 4px 10px rgba(74, 0, 224, 0.20);
}

.btn-bloom-back i {
    font-size: 11px;
}

/* =========================================================
   BLOOM PROFILE UPDATION - RESPONSIVE DESIGN
   ========================================================= */

/* Tablet */
@media (max-width: 992px) {

    .content {
        padding-top: 15px !important;
    }

    .container-fluid {
        padding-left: 12px !important;
        padding-right: 12px !important;
    }

    .grid-3 {
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 12px;
    }

    .main-card {
        padding: 20px;
    }

    .top-section {
        padding: 13px 16px;
        margin-bottom: 18px;
    }

    .top-section h2 {
        font-size: 16px;
    }

    .workspace-container {
        display: block;
    }

    .form-workspace-left {
        width: 100%;
    }
}


/* Mobile */
@media (max-width: 767px) {

    body {
        font-size: 12px;
        padding-bottom: 30px;
        overflow-x: hidden;
    }

    .content-wrapper {
        width: 100%;
        min-height: 100vh;
    }

    .content {
        padding-top: 10px !important;
    }

    .container-fluid {
        width: 100%;
        padding-left: 8px !important;
        padding-right: 8px !important;
    }

    /* Header */
    .top-section {
        display: flex;
        width: 100%;
        padding: 12px 14px;
        margin-bottom: 12px;
        border-radius: 10px;
    }

    .header-left-side {
        gap: 10px;
    }

    .logo-box {
        width: 34px;
        height: 34px;
        min-width: 34px;
        border-radius: 8px;
        font-size: 15px;
    }

    .top-section h2 {
        font-size: 15px;
        line-height: 1.3;
    }


    /* Main Cards */
    .main-card {
        width: 100%;
        padding: 15px;
        margin-bottom: 15px;
        border-radius: 10px;
    }

    /* Section Header */
    .section-header-wrap {
        margin-bottom: 15px;
        padding-bottom: 8px;
    }

    .section-title {
        font-size: 13px;
        line-height: 1.4;
    }

    .section-title i {
        font-size: 12px;
    }


    /* IMPORTANT:
       Change 3-column grid into single column */
    .grid-3 {
        display: grid;
        grid-template-columns: 1fr;
        gap: 0;
        width: 100%;
    }

    .form-group {
        width: 100%;
        min-width: 0;
        margin-bottom: 12px;
    }

    .form-group.span-3 {
        grid-column: span 1;
    }


    /* Form Controls */
    .form-control-sm,
    .custom-select-sm,
    textarea.form-control-sm {
        width: 100% !important;
        max-width: 100% !important;
        min-width: 0 !important;
        font-size: 12px !important;
        height: 36px !important;
        padding: 7px 10px !important;
    }

    textarea.form-control-sm {
        height: auto !important;
        min-height: 70px;
    }

    .form-group label {
        font-size: 10px;
        margin-bottom: 4px;
    }


    /* Profile Photo */
    .photo-center-row {
        margin-bottom: 15px;
        padding-bottom: 15px;
    }

    .photo-center-row .form-group {
        width: 100% !important;
        max-width: 280px;
    }


    /* Address / Education sub headings */
    .main-card h4.section-title {
        font-size: 12px !important;
        margin-bottom: 12px !important;
    }


    /* Higher Education / Experience dynamic boxes */
    #higher_education_section,
    #experience_section {
        padding: 12px !important;
        border-radius: 8px;
        width: 100%;
        box-sizing: border-box;
    }

    .higher-edu-row,
    .experience-row {
        width: 100%;
        overflow: hidden;
    }


    /* Dynamic section heading */
    #higher_education_section .d-flex,
    #experience_section .d-flex {
        gap: 8px;
        align-items: center !important;
    }

    #higher_education_section .section-title,
    #experience_section .section-title {
        font-size: 11px !important;
    }


    /* Add button */
    .btn-add-icon {
        width: 30px;
        height: 30px;
        min-width: 30px;
        font-size: 11px;
    }


    /* Radio buttons */
    .custom-control-inline {
        margin-right: 12px;
        margin-bottom: 5px;
    }

    .custom-control-label {
        font-size: 12px;
    }


    /* Alerts */
    .alert {
        font-size: 11px;
        padding: 10px 35px 10px 12px;
        margin-bottom: 12px;
        border-radius: 8px;
    }

    .alert ul {
        padding-left: 18px;
    }


    /* Password fields */
    .password-wrapper {
        width: 100%;
    }

    .password-wrapper i {
        right: 10px;
    }


    /* Bottom buttons */
    .text-right.mt-3.mb-5 {
        display: flex !important;
        flex-direction: column;
        gap: 8px;
        width: 100%;
        margin-top: 15px !important;
        margin-bottom: 25px !important;
    }

    .btn-bloom-back,
    .text-right.mt-3.mb-5 .btn-primary {
        width: 100%;
        min-height: 38px;
        font-size: 12px;
    }


    /* File inputs */
    input[type="file"].form-control-sm {
        height: auto !important;
        min-height: 36px;
        padding: 6px 8px !important;
        font-size: 11px !important;
    }


    /* Existing document names */
    .form-control.form-control-sm[style*="background:#f8f9fa"] {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }


    /* Prevent long values from breaking mobile layout */
    input,
    select,
    textarea {
        max-width: 100%;
    }


    /* Current employment */
    #section_experience .mb-4.pb-4 {
        padding-bottom: 12px !important;
        margin-bottom: 15px !important;
    }


    /* Higher education question */
    #section_education > .mb-4:first-of-type {
        margin-bottom: 15px !important;
    }


    /* Remove excessive desktop spacing */
    .pt-3 {
        padding-top: 12px !important;
    }

    .mb-4 {
        margin-bottom: 15px !important;
    }
}


/* Very Small Mobile */
@media (max-width: 480px) {

    .container-fluid {
        padding-left: 6px !important;
        padding-right: 6px !important;
    }

    .main-card {
        padding: 12px;
        border-radius: 9px;
    }

    .top-section {
        padding: 10px 12px;
    }

    .logo-box {
        width: 32px;
        height: 32px;
        min-width: 32px;
    }

    .top-section h2 {
        font-size: 14px;
    }

    .section-title {
        font-size: 12px;
    }

    .form-control-sm,
    .custom-select-sm,
    textarea.form-control-sm {
        font-size: 11px !important;
    }

    .form-group label {
        font-size: 9.5px;
    }

    #higher_education_section,
    #experience_section {
        padding: 10px !important;
    }

    .btn-bloom-back,
    .text-right.mt-3.mb-5 .btn-primary {
        font-size: 11px;
        padding: 8px 12px;
    }
}
    </style>
</head>

<body class="hold-transition layout-fixed">
    <div class="wrapper">

        <!-- Main Content Container Frame -->
        <div class="content-wrapper">
            <section class="content pt-4">
                <div class="container-fluid">

                    <!-- Header Block -->
                    <div class="top-section">
                        <div class="header-left-side">
                            <div class="logo-box">
                                <i class="fas fa-user-edit"></i>
                            </div>
                            <h2>Profile Updation</h2>
                        </div>
                    </div>

                    <div class="workspace-container">
                        <div class="form-workspace-left">
                            <?php if (session()->getFlashdata('success')): ?>
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <?= session()->getFlashdata('success') ?>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            <?php endif; ?>

                            <?php if (session()->getFlashdata('errors')): ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <ul class="mb-0">
                                    <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                        <li><?= esc($error) ?></li>
                                    <?php endforeach ?>
                                    </ul>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            <?php endif; ?>

                            <?php if (session()->getFlashdata('error')): ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <?= session()->getFlashdata('error') ?>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            <?php endif; ?>

                            <form id="profileForm" action="<?= base_url('profile_updation') ?>" method="POST" enctype="multipart/form-data"
                                onsubmit="return validateForm() && validatePassingYears()">

                                <!-- CARD BLOCK: PERSONAL PROFILE DETAILS -->
                                <div class="main-card" id="section_personal">
                                    <div class="section-header-wrap">
                                        <h3 class="section-title"><i class="fas fa-id-card"></i> Personal Information
                                        </h3>
                                    </div>
                                <div class="photo-center-row">
                                    <div class="form-group text-center" style="width:240px;">

                                        <label>Profile Photo</label>

                                        <?php if (!empty($documents['profile_photo'])): ?>
                                            <div class="form-control form-control-sm text-left" style="background:#f8f9fa;">
                                                <?= basename($documents['profile_photo']) ?>
                                            </div>
                                        <?php else: ?>
                                            <input type="file"
                                                name="profile_photo"
                                                class="form-control form-control-sm"
                                                accept="image/*"
                                                required>
                                        <?php endif; ?>

                                    </div>
                                </div>

                                    <div class="grid-3">
                                        <div class="form-group">
                                            <label>Full Name <span class="text-danger">*</span></label>
                                            <input type="text" name="emp_name"value="<?= esc($profile['emp_name'] ?? '') ?>" class="form-control form-control-sm"
                                               readonly style="background: #f1f5f9 !important;">
                                        </div>
                                        <div class="form-group">
                                            <label>Mobile Number <span class="text-danger">*</span></label>
                                            <input type="tel" name="mobile" value="<?= esc($profile['mobile'] ?? '') ?>" class="form-control form-control-sm"
                                                pattern="[0-9]{10}" maxlength="10" title="Please enter a valid 10-digit mobile number" readonly style="background: #f1f5f9 !important;">
                                        </div>
                                        <div class="form-group">
                                            <label>Email Address <span class="text-danger">*</span></label>
                                            <input type="email" name="email" value="<?= esc($profile['email'] ?? '') ?>" class="form-control form-control-sm"
                                              readonly style="background: #f1f5f9 !important;">
                                        </div>
                                        <div class="form-group">
                                            <label>Date of Birth <span class="text-danger">*</span></label>
                                            <input type="date" name="dob" value="<?= esc($profile['dob'] ?? '') ?>" class="form-control form-control-sm" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Gender <span class="text-danger">*</span></label>
                                           <select name="gender" class="form-control form-control-sm" style="background: #f1f5f9 !important;">
                                                <option value="MALE" <?= (strtoupper($profile['gender'] ?? '') == 'MALE') ? 'selected' : '' ?>>Male</option>
                                                <option value="FEMALE" <?= (strtoupper($profile['gender'] ?? '') == 'FEMALE') ? 'selected' : '' ?>>Female</option>
                                                <option value="OTHER" <?= (strtoupper($profile['gender'] ?? '') == 'OTHER') ? 'selected' : '' ?>>Other</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Marital Status <span class="text-danger">*</span></label>
                                           <select name="marital_status" class="form-control form-control-sm" style="background: #f1f5f9 !important;">
                                            <option value="SINGLE" <?= ($profile['marital_status']=='SINGLE')?'selected':'' ?>>Single</option>
                                            <option value="MARRIED" <?= ($profile['marital_status']=='MARRIED')?'selected':'' ?>>Married</option>
                                            <option value="DIVORCED" <?= ($profile['marital_status']=='DIVORCED')?'selected':'' ?>>Divorced</option>
                                            <option value="WIDOWED" <?= ($profile['marital_status']=='WIDOWED')?'selected':'' ?>>Widowed</option>
                                        </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Father Name</label>
                                            <input type="text" name="father_name" value="<?= esc($profile['father_name'] ?? '') ?>" class="form-control form-control-sm" style="background: #f1f5f9 !important;">
                                        </div>
                                        <div class="form-group">
                                            <label>Mother Name</label>
                                            <input type="text" name="mother_name"value="<?= esc($profile['mother_name'] ?? '') ?>" class="form-control form-control-sm">
                                        </div>
                                        <div class="form-group">
                                            <label>PAN Number <span class="text-danger">*</span></label>
                                            <input type="text" name="pan"value="<?= esc($profile['pan'] ?? '') ?>" class="form-control form-control-sm" 
                                                pattern="[A-Za-z]{5}[0-9]{4}[A-Za-z]{1}" maxlength="10" title="Please enter a valid PAN number (e.g. ABCDE1234F)" style="text-transform: uppercase;" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Aadhaar Number <span class="text-danger">*</span></label>
                                            <input type="text" name="aadhaar" value="<?= esc($profile['aadhaar'] ?? '') ?>" class="form-control form-control-sm"
                                                pattern="[0-9]{12}" maxlength="12" title="Please enter a valid 12-digit Aadhaar number" readonly style="background: #f1f5f9 !important;">
                                        </div>
                                        <div class="form-group">
                                            <label>Aadhaar Card Document <span class="text-danger">*</span></label>
                                            <?php if (!empty($documents['aadhaar_doc'])): ?>
                                                <div class="form-control form-control-sm" style="background:#f8f9fa;">
                                                    <?= basename($documents['aadhaar_doc']) ?>
                                                </div>
                                            <?php else: ?>
                                                <input type="file"
                                                    name="aadhaar_doc"
                                                    class="form-control form-control-sm"
                                                    accept=".pdf,.jpg,.jpeg,.png"
                                                    required>
                                            <?php endif; ?>
                                        </div>
                                        <div class="form-group">
                                        <label>PAN Card Document <span class="text-danger">*</span></label>

                                        <?php if (!empty($documents['pan_doc'])): ?>
                                            <div class="form-control form-control-sm" style="background:#f8f9fa;">
                                                <?= basename($documents['pan_doc']) ?>
                                            </div>
                                        <?php else: ?>
                                            <input type="file"
                                                name="pan_doc"
                                                class="form-control form-control-sm"
                                                accept=".pdf,.jpg,.jpeg,.png"
                                                required>
                                        <?php endif; ?>
                                    </div>
                                    </div>

                                    <h4 class="section-title mt-3 mb-3" style="font-size: 13px;"><i
                                            class="fas fa-map-marker-alt text-muted"></i> Address Details</h4>
                                    <div class="grid-3">
                                        <div class="form-group">
                                            <label>House Number <span class="text-danger">*</span></label>
                                            <input type="text" name="house_number" value="<?= esc($currentAddress['houseNo'] ?? '') ?>" class="form-control form-control-sm"
                                               style="background: #f1f5f9 !important;">
                                        </div>
                                        <div class="form-group">
                                            <label>Area / Town <span class="text-danger">*</span></label>
                                            <input type="text" name="area_town" value="<?= esc($currentAddress['area'] ?? '') ?>" class="form-control form-control-sm"
                                               style="background: #f1f5f9 !important;">
                                        </div>
                                        <div class="form-group">
                                            <label>District <span class="text-danger">*</span></label>
                                            <input type="text" name="district" value="<?= esc($currentAddress['streetNo'] ?? '') ?>" class="form-control form-control-sm"
                                               style="background: #f1f5f9 !important;">
                                        </div>
                                        <div class="form-group">
                                            <label>City <span class="text-danger">*</span></label>
                                            <input type="text" name="city" value="<?= esc($currentAddress['city'] ?? '') ?>" class="form-control form-control-sm"
                                               style="background: #f1f5f9 !important;">
                                        </div>
                                        <div class="form-group">
                                            <label>State <span class="text-danger">*</span></label>
                                            <input type="text" value="<?= esc($currentAddress['state'] ?? '') ?>" name="state" class="form-control form-control-sm"
                                               style="background: #f1f5f9 !important;">
                                        </div>
                                        <div class="form-group">
                                            <label>Pincode <span class="text-danger">*</span></label>
                                            <input type="text" name="Pincode" value="<?= esc($currentAddress['pin_code'] ?? '') ?>" class="form-control form-control-sm"
                                                pattern="[0-9]{6}" maxlength="6" title="Please enter a valid 6-digit Pincode" style="background: #f1f5f9 !important;">
                                        </div>
                                    </div>
                                </div>

                                <!-- CARD BLOCK: BANKING DETAILS -->
                                <div class="main-card" id="section_banking">
                                    <div class="section-header-wrap">
                                        <h3 class="section-title"><i class="fas fa-university"></i> Bank Details</h3>
                                    </div>
                                    <div class="grid-3">
                                        <div class="form-group">
                                            <label>Account Holder Name <span class="text-danger">*</span></label>
                                            <input type="text" name="bank_holder_name" value="<?= esc($profile['bank_holder_name'] ?? '') ?>"
                                                class="form-control form-control-sm"readonly style="background: #f1f5f9 !important;">
                                        </div>
                                        <div class="form-group">
                                            <label>Bank Name <span class="text-danger">*</span></label>
                                            <input type="text" name="bank_name" value="<?= esc($profile['bank_name'] ?? '') ?>" class="form-control form-control-sm"
                                              readonly style="background: #f1f5f9 !important;">
                                        </div>
                                        <div class="form-group">
                                            <label>IFSC Code <span class="text-danger">*</span></label>
                                            <input type="text" name="ifsc" value="<?= esc($profile['ifsc'] ?? '') ?>" class="form-control form-control-sm"
                                                pattern="^[A-Za-z]{4}0[A-Za-z0-9]{6}$" maxlength="11" title="Please enter a valid 11-character IFSC code" style="text-transform: uppercase;" readonly style="background: #f1f5f9 !important;">
                                        </div>

                                        <div class="form-group">
                                            <label>Account Number <span class="text-danger">*</span></label>
                                            <div class="password-wrapper">
                                                <input type="password" id="bank_account_no" name="bank_account_no" value="<?= esc($profile['bank_account_no'] ?? '') ?>"
                                                    class="form-control form-control-sm" pattern="[0-9]{9,18}" maxlength="18" title="Please enter a valid bank account number"readonly style="background: #f1f5f9 !important;">
                                                <i class="fas fa-eye"
                                                    onclick="togglePassword('bank_account_no', this)"></i>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Confirm Account Number <span class="text-danger">*</span></label>
                                            <div class="password-wrapper">
                                                <input type="password" id="bank_account_no_confirm"
                                                    name="bank_account_no_confirm" value="<?= esc($profile['bank_account_no'] ?? '') ?>" class="form-control form-control-sm"
                                                    pattern="[0-9]{9,18}" maxlength="18" title="Please enter a valid bank account number" readonly style="background: #f1f5f9 !important;">
                                                <i class="fas fa-eye"
                                                    onclick="togglePassword('bank_account_no_confirm', this)"></i>
                                            </div>
                                            <small id="bank_match_error" class="text-danger"
                                                style="display:none; font-size: 11px; margin-top: 4px;">Account numbers
                                                do not match!</small>
                                        </div>
                                        <div class="form-group">
                                            <label>Branch Name <span class="text-danger">*</span></label>
                                            <input type="text" name="bank_branch" value="<?= esc($profile['bank_branch'] ?? '') ?>" class="form-control form-control-sm"
                                              readonly style="background: #f1f5f9 !important;">
                                        </div>

                                        <div class="form-group">
                                            <label>Account Type <span class="text-danger">*</span></label>
                                            <select name="bank_account_type"
                                                class="form-control form-control-sm custom-select-sm"disabled style="background: #f1f5f9 !important;">
                                                 <option value="SAVINGS" <?= ($profile['bank_account_type']=='SAVINGS')?'selected':'' ?>>Savings</option>
                                                <option value="CURRENT" <?= ($profile['bank_account_type']=='CURRENT')?'selected':'' ?>>Current</option>
                                                <option value="SALARY" <?= ($profile['bank_account_type']=='SALARY')?'selected':'' ?>>Salary</option>
                                            </select>
                                        </div>
                                        <!-- <div class="form-group">
                                            <label>Passbook / Cancelled Cheque <span
                                                    class="text-danger">*</span></label>
                                            <input type="file" name="bank_doc" class="form-control form-control-sm"
                                                accept=".pdf,.jpg,.jpeg,.png" required>
                                        </div> -->
                                        <div class="form-group">
                                            <label>UPI ID <span class="text-muted">(Optional)</span></label>
                                            <input type="text" name="upi_id" value="<?= esc($profile['upi_id'] ?? '') ?>" class="form-control form-control-sm" readonly style="background: #f1f5f9 !important;">
                                        </div>
                                    </div>
                                </div>

                                <!-- CARD BLOCK: EDUCATION HISTORY -->
                                <div class="main-card" id="section_education">
                                    <div class="section-header-wrap">
                                        <h3 class="section-title"><i class="fas fa-graduation-cap"></i> Education
                                            Details</h3>
                                    </div>

                                    <!-- HIGHER EDUCATION QUESTION -->
                                    <div class="mb-4">
                                        <label
                                            style="font-size: 14px; font-weight: 600; color: var(--bloom-dark); text-transform: none;">Do
                                            you have any higher education?</label>
                                        <div class="mt-2">
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="higher_edu_yes" name="has_higher_education"
                                                    value="Yes" class="custom-control-input"
                                                    onchange="toggleHigherEducation()">
                                                <label class="custom-control-label" for="higher_edu_yes">Yes</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="higher_edu_no" name="has_higher_education"
                                                    value="No" class="custom-control-input"
                                                    onchange="toggleHigherEducation()" checked>
                                                <label class="custom-control-label" for="higher_edu_no">No</label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- HIGHER EDUCATION DYNAMIC SECTION -->
                                    <div id="higher_education_section"
                                    style="display: <?= !empty($higherEducation) ? 'block' : 'none' ?>;
                                        background:#f8fafc;
                                        padding:20px;
                                        border-radius:8px;
                                        border:1px solid #e2e8f0;
                                        margin-bottom:20px;">
                                                 <div class="d-flex justify-content-between align-items-center mb-3">
                                                <h4 class="section-title" style="font-size: 13px; margin:0;"><i
                                                 class="fas fa-plus-circle text-muted"></i> Higher Education Details
                                                    </h4>
                                                     <button type="button" class="btn-add-icon" onclick="addHigherEducationRow()"
                                                     title="Add another qualification">
                                                     <i class="fas fa-plus"></i>
                                                    </button>
                                                </div>
                                <div id="higher_edu_container">

                                <?php foreach ($higherEducation as $index => $edu): ?>

                                <div class="higher-edu-row mb-4 pb-3"
                                    style="border-bottom:1px dashed #cbd5e1;">

                                    <div class="grid-3">

                                        <div class="form-group">
                                            <label>Degree</label>
                                            <input type="text"
                                                name="higher_degree[]"
                                                class="form-control form-control-sm"
                                                value="<?= esc($edu['degree']) ?>">
                                        </div>

                                        <div class="form-group">
                                            <label>College</label>
                                            <input type="text"
                                                name="higher_college[]"
                                                class="form-control form-control-sm"
                                                value="<?= esc($edu['college']) ?>">
                                        </div>

                                        <div class="form-group">
                                            <label>Year</label>
                                            <input type="number"
                                                name="higher_year[]"
                                                class="form-control form-control-sm"
                                                value="<?= esc($edu['year']) ?>">
                                        </div>

                                        <div class="form-group">
                                            <label>Percentage</label>
                                            <input type="text"
                                                name="higher_percentage[]"
                                                class="form-control form-control-sm"
                                                inputmode="decimal"
                                                pattern="^\d+(\.\d{1,2})?$"
                                                oninput="this.value=this.value.replace(/[^0-9.]/g,'').replace(/(\..*)\./g,'$1');"
                                                maxlength="6"
                                                value="<?= esc($edu['percentage']) ?>">
                                        </div>

                                    </div>

                                </div>

                                <?php endforeach; ?>

                                </div>
                                    </div>

                                    <!-- GRADUATION DETAILS (MANDATORY) -->
                                    <div class="mb-4 pt-3" style="border-top: 1px dashed #e2e8f0;">
                                        <h4 class="section-title mb-3" style="font-size: 13px;"><i
                                                class="fas fa-university text-muted"></i> Graduation Details <span
                                                class="text-danger">*</span></h4>
                                        <div class="grid-3">
                                            <div class="form-group">
                                                <label>College / University <span class="text-danger">*</span></label>
                                                <input type="text" name="institution"
                                                    class="form-control form-control-sm" value="<?= esc($graduation['institution'] ?? '') ?>">
                                            </div>
                                            <div class="form-group">
                                                <label>Degree / Branch <span class="text-danger">*</span></label>
                                                <input type="text" name="degree"
                                                    class="form-control form-control-sm"  value="<?= esc($graduation['degree'] ?? '') ?>">
                                            </div>
                                            <div class="form-group">
                                                <label>Year of Passing <span class="text-danger">*</span></label>
                                                <input type="number" id="graduation_year" name="year_of_pass"
                                                    class="form-control form-control-sm" min="1900"
                                                        max="2100"
                                                            step="1"
                                                            onwheel="this.blur()"
                                                            oninput="this.value = this.value.replace(/[^0-9]/g,'').slice(0,4)" value="<?= esc($graduation['year_of_pass'] ?? '') ?>">
                                            </div>
                                           <div class="form-group">
                                        <label>Percentage / CGPA <span class="text-danger">*</span></label>
                                        <input type="text"
                                            name="percentage"
                                            class="form-control form-control-sm"
                                            value="<?= esc($graduation['percentage'] ?? '') ?>"
                                            inputmode="decimal"
                                            pattern="^\d+(\.\d{1,2})?$"
                                            oninput="this.value=this.value.replace(/[^0-9.]/g,'').replace(/(\..*)\./g,'$1');"
                                            maxlength="6"
                                            required>
                                    </div>
                                           <div class="form-group">
                                                <label>Graduation Certificate <span class="text-danger">*</span></label>

                                                <?php if (!empty($documents['degree_certificate'])): ?>
                                                    <div class="form-control form-control-sm" style="background:#f8f9fa;">
                                                        <?= basename($documents['degree_certificate']) ?>
                                                    </div>
                                                <?php else: ?>
                                                    <input type="file"
                                                        name="grad_cert"
                                                        class="form-control form-control-sm"
                                                        accept=".pdf,.jpg,.png"
                                                        required>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- INTERMEDIATE DETAILS -->
                                    <div class="mb-4 pt-3" style="border-top: 1px dashed #e2e8f0;">
                                        <h4 class="section-title mb-3" style="font-size: 13px;"><i
                                                class="fas fa-user-graduate text-muted"></i> Intermediate (12th) Details
                                        </h4>
                                        <div class="grid-3">
                                            <div class="form-group">
                                                <label>College Name <span class="text-danger">*</span></label>
                                                <input type="text" name="inter_college"
                                                    class="form-control form-control-sm" value="<?= esc($intermediate['institution'] ?? '') ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Board <span class="text-danger">*</span></label>
                                                <input type="text" name="inter_board"
                                                    class="form-control form-control-sm" value="<?= esc($intermediate['board'] ?? '') ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Year of Passing <span class="text-danger">*</span></label>
                                                <input type="number" id="inter_year" name="inter_year"
                                                min="1900"
                                                max="2100"
                                                step="1"
                                                onwheel="this.blur()"
                                                oninput="this.value = this.value.replace(/[^0-9]/g,'').slice(0,4)"
                                                    class="form-control form-control-sm" value="<?= esc($intermediate['year_of_pass'] ?? '') ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Percentage / CGPA <span class="text-danger">*</span></label>
                                                <input type="text" name="inter_percentage"
                                                    class="form-control form-control-sm" value="<?= esc($intermediate['percentage'] ?? '') ?>"
                                                    inputmode="decimal"
                                                    pattern="^\d+(\.\d{1,2})?$"
                                                    oninput="this.value=this.value.replace(/[^0-9.]/g,'').replace(/(\..*)\./g,'$1');"
                                                    maxlength="6"
                                                    required>
                                            </div>
                                            <div class="form-group">
                                            <label>Intermediate Certificate <span class="text-muted">(Optional)</span></label>

                                            <?php if (!empty($documents['intermediate_certificate'])): ?>
                                                <div class="form-control form-control-sm" style="background:#f8f9fa;">
                                                    <?= basename($documents['intermediate_certificate']) ?>
                                                </div>
                                            <?php else: ?>
                                                <input type="file"
                                                    name="inter_cert"
                                                    class="form-control form-control-sm"
                                                    accept=".pdf,.jpg,.png">
                                            <?php endif; ?>
                                        </div>
                                        </div>
                                    </div>

                                    <!-- 10TH DETAILS (MANDATORY) -->
                                    <div class="mb-4 pt-3" style="border-top: 1px dashed #e2e8f0;">
                                        <h4 class="section-title mb-3" style="font-size: 13px;"><i
                                                class="fas fa-school text-muted"></i> 10th (High School) Details <span
                                                class="text-danger">*</span></h4>
                                        <div class="grid-3">
                                            <div class="form-group">
                                                <label>School Name <span class="text-danger">*</span></label>
                                                <input type="text" name="tenth_school"
                                                    class="form-control form-control-sm" value="<?= esc($tenth['institution'] ?? '') ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Board <span class="text-danger">*</span></label>
                                                <input type="text" name="tenth_board"
                                                    class="form-control form-control-sm" value="<?= esc($tenth['board'] ?? '') ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Year of Passing <span class="text-danger">*</span></label>
                                                <input type="number" id="tenth_year" name="tenth_year"
                                                min="1900"
                                                    max="2100"
                                                    step="1"
                                                    onwheel="this.blur()"
                                                    oninput="this.value = this.value.replace(/[^0-9]/g,'').slice(0,4)"
                                                    class="form-control form-control-sm" value="<?= esc($tenth['year_of_pass'] ?? '') ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Percentage / CGPA <span class="text-danger">*</span></label>
                                                <input type="text" name="tenth_percentage"
                                                    class="form-control form-control-sm"  value="<?= esc($tenth['percentage'] ?? '') ?>" 
                                                    inputmode="decimal"
                                                    pattern="^\d+(\.\d{1,2})?$"
                                                    oninput="this.value=this.value.replace(/[^0-9.]/g,'').replace(/(\..*)\./g,'$1');"
                                                    maxlength="6"
                                                    required>
                                            </div>
                                            <div class="form-group">
                                                    <label>10th Certificate <span class="text-danger">*</span></label>

                                                    <?php if (!empty($documents['ssc_certificate'])): ?>
                                                        <div class="form-control form-control-sm" style="background:#f8f9fa;">
                                                            <?= basename($documents['ssc_certificate']) ?>
                                                        </div>
                                                    <?php else: ?>
                                                        <input type="file"
                                                            name="tenth_cert"
                                                            class="form-control form-control-sm"
                                                            accept=".pdf,.jpg,.png"
                                                            required>
                                                    <?php endif; ?>
                                                </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- CARD BLOCK: WORK EXPERIENCE -->
                                <div class="main-card" id="section_experience">
                                    <div class="section-header-wrap">
                                        <h3 class="section-title"><i class="fas fa-briefcase"></i> Work Experience
                                            Information</h3>
                                    </div>

                                    <!-- CURRENT EMPLOYMENT (READONLY) -->
                                    <div class="mb-4 pb-4" style="border-bottom: 1px dashed #e2e8f0;">
                                        <h4 class="section-title mb-3" style="font-size: 13px;"><i class="fas fa-building text-muted"></i> Current Employment (Blooms)</h4>
                                        <div class="grid-3">
                                            <div class="form-group">
                                                <label>Company Name</label>
                                                <input type="text" class="form-control form-control-sm" value="Blooms" readonly style="background: #f1f5f9 !important;">
                                            </div>
                                            <div class="form-group">
                                                <label>Designation</label>
                                                <input type="text" class="form-control form-control-sm" value="<?= esc($profile['designation_name'] ?? 'N/A') ?>" readonly style="background: #f1f5f9 !important;">
                                            </div>
                                            <div class="form-group">
                                                <label>Department</label>
                                                <input type="text" class="form-control form-control-sm" value="<?= esc($profile['department_name'] ?? 'N/A') ?>" readonly style="background: #f1f5f9 !important;">
                                            </div>
                                            <div class="form-group">
                                                <label>Date of Joining</label>
                                                <input type="text" class="form-control form-control-sm" value="<?= esc($profile['joining_date'] ?? 'N/A') ?>" readonly style="background: #f1f5f9 !important;">
                                            </div>
                                            <div class="form-group">
                                                <label>Reporting To</label>
                                                <input type="text" class="form-control form-control-sm" value="<?= esc($profile['reporting'] ?? 'N/A') ?>" readonly style="background: #f1f5f9 !important;">
                                            </div>
                                            <div class="form-group">
                                                <label>Work Location</label>
                                                <input type="text" class="form-control form-control-sm" value="<?= esc($profile['work_location'] ?? 'N/A') ?>" readonly style="background: #f1f5f9 !important;">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <label
                                            style="font-size: 14px; font-weight: 600; color: var(--bloom-dark); text-transform: none;">Do
                                            you have any prior experience other than Blooms?</label>
                                        <div class="mt-2">
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio"
                                                        id="exp_yes"
                                                        name="has_experience"
                                                        value="Yes"
                                                        class="custom-control-input"
                                                        <?= !empty($experience) ? 'checked' : '' ?>
                                                        onchange="toggleExperience()">
                                                <label class="custom-control-label" for="exp_yes">Yes</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="exp_no" name="has_experience" value="No"
                                                    class="custom-control-input" onchange="toggleExperience()"  <?= empty($experience) ? 'checked' : '' ?>>
                                                <label class="custom-control-label" for="exp_no">No</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="experience_section"
                                        style="display: none; background: #f8fafc; padding: 20px; border-radius: 8px; border: 1px solid #e2e8f0;">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h4 class="section-title" style="font-size: 13px; margin:0;"><i
                                                    class="fas fa-building text-muted"></i> Prior Experience Details
                                            </h4>
                                            <button type="button" class="btn-add-icon" onclick="addExperienceRow()"
                                                title="Add another experience">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>

                                        <div id="experience_container">
                                    <?php if (!empty($experience)): ?>
                                    <?php foreach($experience as $index => $exp): ?>
                                    <div class="experience-row mb-4 pb-3" style="border-bottom:1px dashed #cbd5e1;">

                                        <div class="grid-3">

                                            <div class="form-group">
                                                <label>Company Name</label>
                                                <input type="text"
                                                    name="exp_company[]"
                                                    class="form-control form-control-sm"
                                                    value="<?= esc($exp['company_name']) ?>">
                                            </div>

                                            <div class="form-group">
                                                <label>Designation</label>
                                                <input type="text"
                                                    name="exp_designation[]"
                                                    class="form-control form-control-sm"
                                                    value="<?= esc($exp['designation']) ?>">
                                            </div>

                                            <div class="form-group">
                                                <label>Employment Type</label>

                                                <select name="exp_type[]" class="form-control form-control-sm">

                                                    <option value="FULL_TIME"
                                                        <?= ($exp['employment_type']=='FULL_TIME')?'selected':'' ?>>
                                                        Full Time
                                                    </option>

                                                    <option value="PART_TIME"
                                                        <?= ($exp['employment_type']=='PART_TIME')?'selected':'' ?>>
                                                        Part Time
                                                    </option>

                                                    <option value="INTERNSHIP"
                                                        <?= ($exp['employment_type']=='INTERNSHIP')?'selected':'' ?>>
                                                        Internship
                                                    </option>

                                                    <option value="CONTRACT"
                                                        <?= ($exp['employment_type']=='CONTRACT')?'selected':'' ?>>
                                                        Contract
                                                    </option>

                                                </select>

                                            </div>

                                            <div class="form-group">
                                                <label>Total Experience(YEAR)</label>
                                                <input type="text"
                                                    name="exp_years[]"
                                                    class="form-control form-control-sm"
                                                    value="<?= esc($exp['total_experience']) ?>">
                                            </div>

                                            <div class="form-group">
                                                <label>Start Date</label>
                                                <input type="date"
                                                    name="exp_start_date[]"
                                                    class="form-control form-control-sm"
                                                    value="<?= esc($exp['start_date']) ?>">
                                            </div>

                                            <div class="form-group">
                                                <label>End Date</label>
                                                <input type="date"
                                                    name="exp_end_date[]"
                                                    class="form-control form-control-sm"
                                                    value="<?= esc($exp['end_date']) ?>">
                                            </div>

                                            <div class="form-group">
                                                <label>Current CTC</label>
                                                <input type="text"
                                                    name="exp_ctc[]"
                                                    class="form-control form-control-sm"
                                                    value="<?= esc($exp['current_ctc']) ?>">
                                            </div>

                                        </div>

                                    </div>

                                    <?php endforeach; ?>

                                    <?php endif; ?>

                                    </div>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="text-right mt-3 mb-5">
                                    
                                <button type="button"
                                    class="btn btn-bloom-back"
                                    onclick="window.history.back();">
                                    <i class="fas fa-arrow-left mr-1"></i> Back
                                </button>
                                    <button type="submit" class="btn btn-primary px-4 py-2"
                                        style="background: var(--bloom-purple); border: none; border-radius: 8px; font-weight: 600;">
                                        <i class="fas fa-save mr-2"></i> Save Profile Details
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </section>
        </div>
    </div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Bank details validation
        function validateForm() {
            const accNo = document.getElementById('bank_account_no').value;
            const confirmAccNo = document.getElementById('bank_account_no_confirm').value;
            const errorMsg = document.getElementById('bank_match_error');

            if (accNo !== confirmAccNo) {
                errorMsg.style.display = 'block';
                document.getElementById('bank_account_no_confirm').focus();
                return false;
            }
            errorMsg.style.display = 'none';
            return true;
        }

        // Toggle password visibility
        function togglePassword(inputId, iconElement) {
            const input = document.getElementById(inputId);
            if (input.type === "password") {
                input.type = "text";
                iconElement.classList.remove("fa-eye");
                iconElement.classList.add("fa-eye-slash");
            } else {
                input.type = "password";
                iconElement.classList.remove("fa-eye-slash");
                iconElement.classList.add("fa-eye");
            }
        }

        // Higher Education Dynamic Logic
        let higherEduCount = 0;
        function toggleHigherEducation() {
            const isYes = document.getElementById('higher_edu_yes').checked;
            const section = document.getElementById('higher_education_section');
            if (isYes) {
                section.style.display = 'block';
                if (higherEduCount === 0) {
                    addHigherEducationRow();
                }
            } else {
                section.style.display = 'none';
            }
        }

        function addHigherEducationRow() {
            higherEduCount++;
            const container = document.getElementById('higher_edu_container');

            const row = document.createElement('div');
            row.className = 'higher-edu-row mb-4 pb-3';
            row.style.borderBottom = '1px dashed #cbd5e1';
            row.id = 'higher_edu_row_' + higherEduCount;

            row.innerHTML = `
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="m-0 text-muted" style="font-weight: 600; font-size: 12px; text-transform: uppercase;">Qualification #${higherEduCount}</h6>
                ${higherEduCount > 1 ? '<button type="button" class="btn btn-xs btn-danger" style="border-radius: 4px;" onclick="removeHigherEducationRow(' + higherEduCount + ')"><i class="fas fa-times"></i> Remove</button>' : ''}
            </div>
            <div class="grid-3">
                <div class="form-group">
                    <label>Degree / Qualification <span class="text-danger">*</span></label>
                    <input type="text" name="higher_degree[]" class="form-control form-control-sm" required>
                </div>
                <div class="form-group">
                    <label>College / University <span class="text-danger">*</span></label>
                    <input type="text" name="higher_college[]" class="form-control form-control-sm" required>
                </div>
                <div class="form-group">
                    <label>Year of Passing <span class="text-danger">*</span></label>
                    <input type="number" name="higher_year[]" class="form-control form-control-sm" required>
                </div>
                <div class="form-group">
                    <label>Percentage / CGPA <span class="text-danger">*</span></label>
                    <input type="text" name="higher_percentage[]" class="form-control form-control-sm" required>
                </div>
                <div class="form-group">
                    <label>Higher Education Certificate <span class="text-danger">*</span></label>
                    <input type="file" name="higher_cert[]" class="form-control form-control-sm" accept=".pdf,.jpg,.png" required>
                </div>
            </div>
        `;
            container.appendChild(row);
        }

        function removeHigherEducationRow(id) {
            const row = document.getElementById('higher_edu_row_' + id);
            if (row) {
                row.remove();
            }
        }

        // Work Experience Dynamic Logic
        let expCount = 0;
        function toggleExperience() {
            const isYes = document.getElementById('exp_yes').checked;
            const section = document.getElementById('experience_section');
            if (isYes) {
                section.style.display = 'block';
                if (expCount === 0) {
                    addExperienceRow();
                }
            } else {
                section.style.display = 'none';
            }
        }

        function addExperienceRow() {
            expCount++;
            const container = document.getElementById('experience_container');

            const row = document.createElement('div');
            row.className = 'experience-row mb-4 pb-3';
            row.style.borderBottom = '1px dashed #cbd5e1';
            row.id = 'experience_row_' + expCount;

            row.innerHTML = `
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="m-0 text-muted" style="font-weight: 600; font-size: 12px; text-transform: uppercase;">Experience #${expCount}</h6>
                ${expCount > 1 ? '<button type="button" class="btn btn-xs btn-danger" style="border-radius: 4px;" onclick="removeExperienceRow(' + expCount + ')"><i class="fas fa-times"></i> Remove</button>' : ''}
            </div>
            <div class="grid-3">
                <div class="form-group">            
                    <label>Company Name <span class="text-danger">*</span></label>            
                    <input type="text" name="exp_company[]" class="form-control form-control-sm" required>        
                </div>
                <div class="form-group">            
                    <label>Designation / Role <span class="text-danger">*</span></label>            
                    <input type="text" name="exp_designation[]" class="form-control form-control-sm" required>        
                </div>
                <div class="form-group">            
                    <label>Employment Type <span class="text-danger">*</span></label>            
                    <select name="exp_type[]" class="form-control form-control-sm custom-select-sm" required>
                        <option value="">Select Type</option>
                        <option value="FULL_TIME">Full Time</option>
                        <option value="PART_TIME">Part Time</option>
                        <option value="INTERNSHIP">Internship</option>
                        <option value="CONTRACT">Contract</option>
                    </select>     
                </div>
                <div class="form-group">            
                    <label>Total Experience (in years) <span class="text-danger">*</span></label>            
                    <input type="number" step="0.1" name="exp_years[]" class="form-control form-control-sm" required>
                </div>
                <div class="form-group">            
                    <label>Start Date <span class="text-danger">*</span></label>            
                    <input type="date" name="exp_start_date[]" class="form-control form-control-sm" required>        
                </div>
                <div class="form-group">            
                    <label>End Date <span class="text-danger">*</span></label>            
                    <input type="date" name="exp_end_date[]" class="form-control form-control-sm" required>        
                </div>
                <div class="form-group">            
                    <label>Current CTC <span class="text-danger">*</span></label>            
                    <input type="text" name="exp_ctc[]" class="form-control form-control-sm" required>        
                </div>
                <div class="form-group">            
                    <label>Experience Letter / Relieving <span class="text-danger">*</span></label>
                    <input type="file" name="exp_doc[]" class="form-control form-control-sm" accept=".pdf,.jpg,.png" required>
                </div>
            </div>
        `;
            container.appendChild(row);
        }

        function removeExperienceRow(id) {
            const row = document.getElementById('experience_row_' + id);
            if (row) {
                row.remove();
            }
        }

        document.addEventListener("DOMContentLoaded", function () {

    if (document.getElementById("exp_yes").checked) {
        document.getElementById("experience_section").style.display = "block";
    }

});
    </script>

    <script>
function validatePassingYears() {

    let tenth = parseInt(document.getElementById('tenth_year').value) || 0;
    let inter = parseInt(document.getElementById('inter_year').value) || 0;
    let graduation = parseInt(document.getElementById('graduation_year').value) || 0;

    if (inter <= tenth) {
        Swal.fire({
            icon: 'warning',
            title: 'Invalid Passing Year',
            text: 'Intermediate passing year should be after 10th.',
            confirmButtonColor: '#4a00e0'
        });
        document.getElementById('inter_year').focus();
        return false;
    }

    if (graduation <= inter) {
        Swal.fire({
            icon: 'warning',
            title: 'Invalid Passing Year',
            text: 'Graduation passing year should be after Intermediate.',
            confirmButtonColor: '#4a00e0'
        });
        document.getElementById('graduation_year').focus();
        return false;
    }

    let higherYears = document.querySelectorAll(".higher_year");

    for (let year of higherYears) {

        let pgYear = parseInt(year.value);

        if (pgYear && pgYear <= graduation) {
            Swal.fire({
                icon: 'warning',
                title: 'Invalid Passing Year',
                text: 'Higher Education passing year should be after Graduation.',
                confirmButtonColor: '#4a00e0'
            });

            year.focus();
            return false;
        }
    }

    return true;
}
</script>

</body>

</html>