<?php
$current = json_decode($profile['current_address'] ?? '{}', true);
$documents = json_decode($profile['documents'] ?? '{}', true);
// echo '<pre>';
// print_r($documents);
// echo '</pre>';
// exit;
$qualification = json_decode($profile['qualification'] ?? '[]', true);
// echo '<pre>';
// print_r($qualification);
// echo '</pre>';
// exit;
$graduation = [];
$intermediate = [];
$tenth = [];

foreach ($qualification as $edu) {

    if (empty($edu['education_type'])) {
        continue;
    }
    switch (strtoupper($edu['education_type'])) {
        case 'GRADUATION':
            $graduation = $edu;
            break;

        case 'INTERMEDIATE':
            $intermediate = $edu;
            break;

        case '10TH':
            $tenth = $edu;
            break;
    }
}

$experiences = json_decode($profile['experience'] ?? '[]', true);

if (is_string($experiences)) {
    $experiences = json_decode($experiences, true);
}

$experiences = is_array($experiences) ? $experiences : [];

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
        /* Readonly fields */
input[readonly],
textarea[readonly] {
    background: #f1f5f9 !important;
    color: #475569 !important;
    border: 1px solid #d1d5db !important;
    cursor: not-allowed;
    opacity: 1 !important;
}

/* Disabled dropdowns */
 select:disabled {
    background: #f1f5f9 !important;
    color: #475569 !important;
    border: 1px solid #d1d5db !important;
    cursor: not-allowed;
    opacity: 1 !important;
}

/* Disabled file inputs */
/* input[type="file"]:disabled {
    background: #f1f5f9 !important;
    color: #64748b !important;
    cursor: not-allowed;
    opacity: 1 !important;
} */

    .section-header-wrap{
    display:flex;
    justify-content:space-between;
    align-items:flex-start;
}

.profile-corner-photo{
    width:90px;
    height:90px;
    border-radius:12px;   /* square with rounded corners */
    object-fit:cover;
    border:3px solid #e2e8f0;
    box-shadow:0 4px 10px rgba(0,0,0,.15);
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
                    <!-- <div class="top-section">
                        <div class="header-left-side">
                            <div class="logo-box">
                                <i class="fas fa-user-edit"></i>
                            </div>
                            <h2>Profile Updation</h2>
                        </div>
                    </div> -->

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

                            <form id="profileForm" action="<?= base_url('admin/profile_updation') ?>" method="POST" enctype="multipart/form-data"
                                onsubmit="return validateForm()">

                                <!-- CARD BLOCK: PERSONAL PROFILE DETAILS -->
                                <div class="main-card" id="section_personal">
                                <div class="section-header-wrap">
                                <h3 class="section-title">
                                    <i class="fas fa-id-card"></i> Personal Information
                                </h3>

                               <?php if (!empty($documents['profile_photo'])) : ?>
                                <img src="<?= base_url('public/' . ($documents['profile_photo'] ?? '')) ?>"
                                    class="profile-corner-photo"
                                    alt="Profile Photo"
                                    style="width:120px;height:120px;">
                                    <?php endif; ?>
                                    
                            </div>

                                

                                    <div class="grid-3">
                                        <div class="form-group">
                                            <label>Full Name <span class="text-danger">*</span></label>
                                            <input type="text" name="emp_name" class="form-control form-control-sm"
                                             value="<?= esc($profile['emp_name'] ?? '') ?>"
                                                 readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Mobile Number <span class="text-danger">*</span></label>
                                            <input type="tel" name="mobile" class="form-control form-control-sm"
                                                pattern="[0-9]{10}" maxlength="10" title="Please enter a valid 10-digit mobile number" value="<?= esc($profile['mobile'] ?? '') ?>"
                                                readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Email Address <span class="text-danger">*</span></label>
                                            <input type="email" name="email" class="form-control form-control-sm"value="<?= esc($profile['email'] ?? '') ?>"
                                                 readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Date of Birth <span class="text-danger">*</span></label>
                                            <input type="date" name="dob" class="form-control form-control-sm" 
                                             value="<?= esc($profile['dob'] ?? '') ?>" readonly>
                                        </div>
                                        <?php
                                        $gender = strtoupper($profile['gender'] ?? '');

                                        if ($gender == 'M') {
                                            $gender = 'MALE';
                                        } elseif ($gender == 'F') {
                                            $gender = 'FEMALE';
                                        }
                                        ?>

                                        <div class="form-group">
                                            <label>Gender <span class="text-danger">*</span></label>
                                            <input type="text"
                                                class="form-control form-control-sm"
                                                value="<?= esc(ucfirst(strtolower($gender))) ?>"
                                                readonly>
                                            <input type="hidden" name="gender" value="<?= esc($profile['gender'] ?? '') ?>">
                                        </div>
                                        <div class="form-group">
                                        <label>Marital Status <span class="text-danger">*</span></label>
                                        <select name="marital_status"
                                            class="form-control form-control-sm custom-select-sm" disabled>
                                            <option value="SINGLE" <?= ($profile['marital_status'] ?? '') == 'SINGLE' ? 'selected' : '' ?>>Single</option>
                                            <option value="MARRIED" <?= ($profile['marital_status'] ?? '') == 'MARRIED' ? 'selected' : '' ?>>Married</option>
                                            <option value="DIVORCED" <?= ($profile['marital_status'] ?? '') == 'DIVORCED' ? 'selected' : '' ?>>Divorced</option>
                                            <option value="WIDOWED" <?= ($profile['marital_status'] ?? '') == 'WIDOWED' ? 'selected' : '' ?>>Widowed</option>
                                        </select>

                                        <input type="hidden" name="marital_status" value="<?= esc($profile['marital_status'] ?? '') ?>">
                                    </div>
                                        <div class="form-group">
                                            <label>Father Name</label>
                                            <input type="text" name="father_name" class="form-control form-control-sm"
                                            value="<?= esc($profile['father_name'] ?? '') ?>" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Mother Name</label>
                                            <input type="text" name="mother_name" class="form-control form-control-sm"
                                            value="<?= esc($profile['mother_name'] ?? '') ?>" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>PAN Number <span class="text-danger">*</span></label>
                                            <input type="text" name="pan" class="form-control form-control-sm" 
                                                pattern="[A-Za-z]{5}[0-9]{4}[A-Za-z]{1}" maxlength="10" title="Please enter a valid PAN number (e.g. ABCDE1234F)" style="text-transform: uppercase;" 
                                                value="<?= esc($profile['pan'] ?? '') ?>"
                                                readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Aadhaar Number <span class="text-danger">*</span></label>
                                            <input type="text" name="aadhaar" class="form-control form-control-sm"
                                                pattern="[0-9]{12}" maxlength="12" title="Please enter a valid 12-digit Aadhaar number" 
                                                  value="<?= esc($profile['aadhaar'] ?? '') ?>"
                                                  readonly>
                                        </div>
                                        <!-- <div class="form-group">
                                            <label>Aadhaar Card Document <span class="text-danger">*</span></label>
                                            <input type="file" name="aadhaar_doc" class="form-control form-control-sm"
                                                accept=".pdf,.jpg,.jpeg,.png" required>
                                        </div>
                                        <div class="form-group">
                                            <label>PAN Card Document <span class="text-danger">*</span></label>
                                            <input type="file" name="pan_doc" class="form-control form-control-sm"
                                                accept=".pdf,.jpg,.jpeg,.png" required>
                                        </div> -->
                                    </div>

                                    <h4 class="section-title mt-3 mb-3" style="font-size: 13px;">
                                    <i class="fas fa-map-marker-alt text-muted"></i> Address Details
                                </h4>

                                <div class="grid-3">
                                    <div class="form-group">
                                        <label>House Number <span class="text-danger">*</span></label>
                                        <input type="text"
                                            name="house_number"
                                            class="form-control form-control-sm"
                                            value="<?= esc($current['houseNo'] ?? '') ?>"
                                            readonly>
                                    </div>

                                    <div class="form-group">
                                        <label>Area / Town <span class="text-danger">*</span></label>
                                        <input type="text"
                                            name="area_town"
                                            class="form-control form-control-sm"
                                            value="<?= esc($current['area'] ?? '') ?>"
                                            readonly>
                                    </div>

                                    <div class="form-group">
                                        <label>District <span class="text-danger">*</span></label>
                                        <input type="text"
                                            name="district"
                                            class="form-control form-control-sm"
                                            value="<?= esc($current['district'] ?? '') ?>"
                                            readonly>
                                    </div>

                                    <div class="form-group">
                                        <label>City <span class="text-danger">*</span></label>
                                        <input type="text"
                                            name="city"
                                            class="form-control form-control-sm"
                                            value="<?= esc($current['city'] ?? '') ?>"
                                            readonly>
                                    </div>

                                    <div class="form-group">
                                        <label>State <span class="text-danger">*</span></label>
                                        <input type="text"
                                            class="form-control form-control-sm"
                                            value="<?= esc($current['state'] ?? '') ?>"
                                            readonly>
                                    </div>

                                    <div class="form-group">
                                        <label>Pincode <span class="text-danger">*</span></label>
                                        <input type="text"
                                            class="form-control form-control-sm"
                                            value="<?= esc($current['pincode'] ?? '') ?>"
                                            readonly>
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
                                            <input type="text" name="bank_holder_name"
                                                class="form-control form-control-sm"
                                                value="<?= esc($profile['bank_holder_name'] ?? '') ?>"
                                                readonly>
                                        </div>

                                        <div class="form-group">
                                            <label>Bank Name <span class="text-danger">*</span></label>
                                            <input type="text" name="bank_name"
                                                class="form-control form-control-sm"
                                                value="<?= esc($profile['bank_name'] ?? '') ?>"
                                                readonly>
                                        </div>

                                        <div class="form-group">
                                            <label>IFSC Code <span class="text-danger">*</span></label>
                                            <input type="text" name="ifsc"
                                                class="form-control form-control-sm"
                                                value="<?= esc($profile['ifsc'] ?? '') ?>"
                                                style="text-transform: uppercase;"
                                                readonly>
                                        </div>

                                        <div class="form-group">
                                            <label>Account Number <span class="text-danger">*</span></label>
                                            <div class="password-wrapper">
                                                <input type="password"
                                                    id="bank_account_no"
                                                    name="bank_account_no"
                                                    class="form-control form-control-sm"
                                                    value="<?= esc($profile['bank_account_no'] ?? '') ?>"
                                                    readonly>
                                                <i class="fas fa-eye" onclick="togglePassword('bank_account_no', this)"></i>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Branch Name <span class="text-danger">*</span></label>
                                            <input type="text" name="bank_branch"
                                                class="form-control form-control-sm"
                                                value="<?= esc($profile['bank_branch'] ?? '') ?>"
                                                readonly>
                                        </div>

                                        <div class="form-group">
                                            <label>Account Type <span class="text-danger">*</span></label>
                                            <select name="bank_account_type"
                                                class="form-control form-control-sm custom-select-sm"
                                                disabled>
                                                <option value="SAVINGS" <?= ($profile['bank_account_type'] ?? '') == 'SAVINGS' ? 'selected' : '' ?>>Savings</option>
                                                <option value="CURRENT" <?= ($profile['bank_account_type'] ?? '') == 'CURRENT' ? 'selected' : '' ?>>Current</option>
                                                <option value="SALARY" <?= ($profile['bank_account_type'] ?? '') == 'SALARY' ? 'selected' : '' ?>>Salary</option>
                                            </select>

                                            <!-- Hidden input because disabled fields are not submitted -->
                                            <input type="hidden" name="bank_account_type"
                                                value="<?= esc($profile['bank_account_type'] ?? '') ?>">
                                        </div>

                                        <div class="form-group">
                                            <label>UPI ID <span class="text-muted">(Optional)</span></label>
                                            <input type="text" name="upi_id"
                                                class="form-control form-control-sm"
                                                value="<?= esc($profile['upi_id'] ?? '') ?>"
                                                readonly>
                                        </div>                                    </div>
                                </div>

                                <!-- CARD BLOCK: EDUCATION HISTORY -->
                                <div class="main-card" id="section_education">
                                    <div class="section-header-wrap">
                                        <h3 class="section-title"><i class="fas fa-graduation-cap"></i> Education
                                            Details</h3>
                                    </div>

                                    <!-- HIGHER EDUCATION QUESTION -->
                                    <!-- <div class="mb-4"> -->
                                        <!-- <label
                                            style="font-size: 14px; font-weight: 600; color: var(--bloom-dark); text-transform: none;">Do
                                            you have any higher education?</label> -->
                                        <!-- <div class="mt-2">
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
                                    </div> -->

                                    <!-- HIGHER EDUCATION DYNAMIC SECTION -->
                                    <!-- <div id="higher_education_section"
                                        style="display: none; background: #f8fafc; padding: 20px; border-radius: 8px; border: 1px solid #e2e8f0; margin-bottom: 20px;">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h4 class="section-title" style="font-size: 13px; margin:0;"><i
                                                    class="fas fa-plus-circle text-muted"></i> Higher Education Details
                                            </h4>
                                            <button type="button" class="btn-add-icon" onclick="addHigherEducationRow()"
                                                title="Add another qualification">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>

                                        <div id="higher_edu_container"> -->
                                            <!-- Dynamic rows will be inserted here -->
                                        <!-- </div>
                                    </div> -->

                                    <!-- GRADUATION DETAILS (MANDATORY) -->
                                    <div class="mb-4 pt-3" style="border-top: 1px dashed #e2e8f0;">
                                        <h4 class="section-title mb-3" style="font-size: 13px;"><i
                                                class="fas fa-university text-muted"></i> Graduation Details <span
                                                class="text-danger">*</span></h4>
                                        <div class="grid-3">
                                            <div class="form-group">
                                                <label>College / University <span class="text-danger">*</span></label>
                                                <input type="text" name="grad_college"
                                                    class="form-control form-control-sm"  value="<?= esc($graduation['institution'] ?? '') ?>"
                                                    readonly>
                                            </div>
                                            <div class="form-group">
                                                <label>Degree / Branch <span class="text-danger">*</span></label>
                                                <input type="text" name="grad_degree"
                                                    class="form-control form-control-sm" 
                                                     value="<?= esc(($graduation['qualification'] ?? '') . (!empty($graduation['specialization']) ? ' - '.$graduation['specialization'] : '')) ?>"
                                                     readonly>
                                            </div>
                                            <div class="form-group">
                                                <label>Year of Passing <span class="text-danger">*</span></label>
                                                <input type="number" name="grad_year"
                                                    class="form-control form-control-sm" 
                                                    value="<?= esc($graduation['year_of_pass'] ?? '') ?>"
                                                    readonly>
                                            </div>
                                            <div class="form-group">
                                                <label>Percentage / CGPA <span class="text-danger">*</span></label>
                                                <input type="text" name="grad_percentage"
                                                    class="form-control form-control-sm" 
                                                    value="<?= esc($graduation['percentage'] ?? '') ?>"
                                                    readonly>
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
                                                    class="form-control form-control-sm"
                                                    value="<?= esc($intermediate['institution'] ?? '') ?>"
                                                    readonly>
                                            </div>
                                            <div class="form-group">
                                                <label>Board <span class="text-danger">*</span></label>
                                                <input type="text" name="inter_board"
                                                    class="form-control form-control-sm" 
                                                    value="<?= esc($intermediate['board'] ?? '') ?>"
                                                   readonly>

                                            </div>
                                            <div class="form-group">
                                                <label>Year of Passing <span class="text-danger">*</span></label>
                                                <input type="number" name="inter_year"
                                                    class="form-control form-control-sm"
                                                     value="<?= esc($intermediate['year_of_pass'] ?? '') ?>"
                                                    readonly>

                                            </div>
                                            <div class="form-group">
                                                <label>Percentage / CGPA <span class="text-danger">*</span></label>
                                                <input type="text" name="inter_percentage"
                                                    class="form-control form-control-sm" 
                                                    value="<?= esc($intermediate['percentage'] ?? '') ?>"
                                                     readonly>
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
                                                    class="form-control form-control-sm" 
                                                    value="<?= esc($tenth['institution'] ?? '') ?>"
                                                   readonly>

                                            </div>
                                            <div class="form-group">
                                                <label>Board <span class="text-danger">*</span></label>
                                                <input type="text" name="tenth_board"
                                                    class="form-control form-control-sm"
                                                    value="<?= esc($tenth['board'] ?? '') ?>"
                                                    readonly>
                                            </div>
                                            <div class="form-group">
                                                <label>Year of Passing <span class="text-danger">*</span></label>
                                                <input type="number" name="tenth_year"
                                                    class="form-control form-control-sm"
                                                    value="<?= esc($tenth['year_of_pass'] ?? '') ?>"
                                                    readonly>
                                            </div>
                                            <div class="form-group">
                                                <label>Percentage / CGPA <span class="text-danger">*</span></label>
                                                <input type="text" name="tenth_percentage"
                                                    class="form-control form-control-sm" 
                                                    value="<?= esc($tenth['percentage'] ?? '') ?>"
                                                    readonly>
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
                                     <?php foreach ($experiences as $index => $exp): ?>
                                    <div class="mb-4 pb-4" style="border-bottom: 1px dashed #e2e8f0;">
                                      <h4 class="section-title mb-3" style="font-size:13px;">
                                            <i class="fas fa-building text-muted"></i>
                                            Experience <?= $index + 1 ?>
                                        </h4>
                                        <div class="grid-3">
                                            <div class="form-group">
                                                <label>Company Name</label>
                                                <input type="text" class="form-control form-control-sm" value="<?= esc($exp['company_name'] ?? '') ?>" readonly style="background: #f1f5f9 !important;">
                                            </div>
                                            <div class="form-group">
                                                <label>Designation</label>
                                                <input type="text" class="form-control form-control-sm" value="<?= esc($exp['designation'] ?? '') ?>" readonly style="background: #f1f5f9 !important;">
                                            </div>
                                            <div class="form-group">
                                                <label>Department</label>
                                                <input type="text" class="form-control form-control-sm" value="<?= (($profile['department'] ?? '') == '0') ? 'N/A' : esc($profile['department'] ?? '') ?>" readonly style="background: #f1f5f9 !important;">
                                            </div>
                                            <div class="form-group">
                                                <label>Date of Joining</label>
                                                <input type="text" class="form-control form-control-sm" value="<?= esc($profile['joining_date'] ?? '') ?>" readonly style="background: #f1f5f9 !important;">
                                            </div>
                                            <div class="form-group">
                                                <label>Reporting To</label>
                                                <input type="text" class="form-control form-control-sm" value="<?= esc($profile['reporting'] ?? '') ?>" readonly style="background: #f1f5f9 !important;">
                                            </div>
                                            <div class="form-group">
                                                <label>Work Location</label>
                                                <input type="text" class="form-control form-control-sm" value="<?= esc($profile['company_name'] ?? '') ?>" readonly style="background: #f1f5f9 !important;">
                                            </div>
                                        </div>
                                    </div>
                                 <?php endforeach; ?>
                                    <!-- <div class="mb-4">
                                        <label
                                            style="font-size: 14px; font-weight: 600; color: var(--bloom-dark); text-transform: none;">Do
                                            you have any prior experience other than Blooms?</label>
                                        <div class="mt-2">
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="exp_yes" name="has_experience" value="Yes"
                                                    class="custom-control-input" onchange="toggleExperience()">
                                                <label class="custom-control-label" for="exp_yes">Yes</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="exp_no" name="has_experience" value="No"
                                                    class="custom-control-input" onchange="toggleExperience()" checked>
                                                <label class="custom-control-label" for="exp_no">No</label>
                                            </div>
                                        </div>
                                    </div> -->

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
                                            <!-- Dynamic rows will be inserted here -->
                                        </div>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="text-right mt-3 mb-5">
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
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

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
    </script>

    <script>
document.addEventListener("DOMContentLoaded", function () {

    // Make all text fields readonly
    document.querySelectorAll('input').forEach(function (el) {
        if (el.type !== 'file' && el.type !== 'radio' && el.type !== 'checkbox') {
            el.setAttribute('readonly', true);
        }
    });

    // Disable dropdowns
    document.querySelectorAll('select').forEach(function (el) {
        el.setAttribute('disabled', true);
    });

    // Make textareas readonly
    document.querySelectorAll('textarea').forEach(function (el) {
        el.setAttribute('readonly', true);
    });

    // Disable radio buttons and checkboxes
    document.querySelectorAll('input[type="radio"], input[type="checkbox"]').forEach(function (el) {
        el.setAttribute('disabled', true);
    });

    // Disable file uploads
    document.querySelectorAll('input[type="file"]').forEach(function (el) {
        el.setAttribute('disabled', true);
    });

    // Hide submit button
    document.querySelectorAll('button[type="submit"]').forEach(function (el) {
        el.style.display = "none";
    });

});
</script>

</body>

</html>