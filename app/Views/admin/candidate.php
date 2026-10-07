<?php
$current_address = json_decode($details['current_address'] ?? '{}', true);
$education = json_decode($details['qualification'] ?? '[]', true);
if (!is_array($education)) {
    $education = [];
}

$qualification = $education;
$highest = $education[0] ?? [];
$inter = $education[1] ?? [];
$tenth = $education[2] ?? [];
// echo "<pre>";
// print_r($education);
// echo "</pre>";
// exit;
$experience = $details['experience'] ?? '[]';
$experience = json_decode($experience, true);

if (is_string($experience)) {
    $experience = json_decode($experience, true);
}

if (!is_array($experience)) {
    $experience = [];
}
// echo "<pre>";
// print_r($exp);
// exit;
?>
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

        .main-sidebar {
            background: var(--bloom-dark) !important;
        }

        .custom-brand {
            display: flex;
            align-items: center;
            padding: 16px;
            border-bottom: 1px solid rgba(255, 255, 255, .1);
        }

        .logo-circle {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            margin-right: 12px;
        }

        .brand-text {
            font-size: 18px;
            font-weight: 700;
        }

        .brand-blue {
            color: #4a8cff;
        }

        .brand-orange {
            color: #ff7a45;
        }

        .content-wrapper {
            background: var(--bloom-bg);
        }

        /* Compact, Symmetric Fields Grid */
        .grid-3 {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 15px;
        }

        /* Force all form elements and flex containers to stay inside their grid items */
        .form-group {
            margin-bottom: 0px;
            min-width: 0;
        }

        .form-group.span-3 {
            grid-column: span 3;
        }

        .form-group label {
            font-weight: 600;
            color: #64748b;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }

        .form-control-sm,
        .custom-select-sm,
        textarea.form-control-sm,
        .upload-container-wrapper {
            width: 100% !important;
            max-width: 100% !important;
            box-sizing: border-box !important;
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

        .profile-ref-tag {
            font-size: 14px;
            font-weight: 700;
            color: var(--bloom-danger);
            background: rgba(239, 68, 68, 0.1);
            padding: 6px 14px;
            border-radius: 8px;
            border: 1px solid rgba(239, 68, 68, 0.2);
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

        .edit-section-trigger {
            font-size: 12px;
            font-weight: 700;
            color: var(--bloom-purple);
            cursor: pointer;
            background: rgba(74, 0, 224, 0.08);
            padding: 4px 12px;
            border-radius: 6px;
            transition: all 0.15s ease-in-out;
        }

        .edit-section-trigger:hover {
            background: var(--bloom-purple);
            color: #fff;
            text-decoration: none;
        }

        /* Small Form Elements Styling - Standardized ReadOnly Visual States */
        .form-control-sm,
        .custom-select-sm {
            border-radius: 8px !important;
            border: 1px solid #e2e8f0 !important;
            color: #1e293b !important;
            background-color: #f8fafc !important;
            font-weight: 500;
            height: 34px !important;
            padding: 6px 12px !important;
            font-size: 13px !important;
            transition: all 0.2s ease;
        }

        .form-control-sm:focus,
        .custom-select-sm:focus {
            border-color: var(--bloom-purple) !important;
            box-shadow: 0 0 0 2px rgba(74, 0, 224, 0.15) !important;
            background-color: #fff !important;
        }

        /* Editable Status Active Class Styling overrides */
        .form-control-sm.editable-active,
        .custom-select-sm.editable-active {
            background-color: #fff !important;
            border-color: #cbd5e1 !important;
        }

        textarea.form-control-sm {
            height: auto !important;
            min-height: 60px;
        }

        /* Centered Photo Row Utility */
        .photo-center-row {
            display: flex;
            justify-content: center;
            width: 100%;
            margin-bottom: 20px;
            border-bottom: 1px dashed #e2e8f0;
            padding-bottom: 20px;
        }

        /* Document Upload Module Elements */
        .upload-container-wrapper {
            display: flex;
            align-items: center;
            gap: 8px;
            width: 100%;
        }

        .compact-upload-box {
            background: #f1f5f9;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            height: 34px;
            padding: 0 12px;
            display: flex;
            align-items: center;
            flex-grow: 1;
            overflow: hidden;
            cursor: pointer;
            transition: all 0.15s ease;
        }

        .compact-upload-box:hover {
            background: #e2e8f0;
            border-color: #cbd5e1;
        }

        .compact-upload-box span {
            font-size: 12px;
            font-weight: 600;
            color: #334155;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 90%;
        }

        .upload-action-btn {
            background: #f8fafc;
            border: 1px solid #cbd5e1;
            color: #64748b;
            border-radius: 8px;
            height: 34px;
            padding: 0 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 12px;
            cursor: pointer;
            transition: all 0.2s ease;
            white-space: nowrap;
            gap: 6px;
            pointer-events: none;
            opacity: 0.6;
        }

        .upload-action-btn.active-control {
            pointer-events: auto;
            opacity: 1;
            color: #475569;
        }

        .upload-action-btn.active-control:hover {
            background: var(--bloom-purple);
            border-color: var(--bloom-purple);
            color: #fff;
        }

        /* Split-Panel Asset Container Frame */
        .document-preview-card {
            background: #fff;
            border-radius: 12px;
            border: 1px solid #cbd5e1;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .preview-card-header {
            background: var(--bloom-dark);
            padding: 12px 16px;
            color: #fff;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .preview-card-header h4 {
            font-size: 13px;
            font-weight: 700;
            margin: 0;
        }

        /* Enable scrolling inside preview viewport when scaled */
        .preview-body-container {
            height: 620px;
            background: #334155;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #94a3b8;
            overflow: auto !important;
            position: relative;
            padding: 20px;
        }

        .workspace-container {
            display: flex !important;
            align-items: flex-start !important;
            justify-content: space-between !important;
            gap: 20px !important;
            flex-wrap: nowrap !important;
            width: 100%;
            position: relative;
        }

        .form-workspace-left {
            flex: 1 1 0% !important;
            min-width: 0 !important;
        }

        .preview-workspace-right {
            width: 440px !important;
            min-width: 440px !important;
            max-width: 440px !important;
            flex: 0 0 440px !important;
            flex-shrink: 0 !important;
            position: sticky !important;
            top: 20px !important;
            display: none;
            align-self: flex-start;
        }
    </style>

    <!-- Main Content Container Frame -->
    <div class="content-wrapper">
            <section class="content pt-4">
                <div class="container-fluid" style="max-width: 1440px;">

                    <!-- Header Block Module Elements -->
                    <div class="top-section">
                        <div class="header-left-side">
                            <div class="logo-box">
                                <i class="fas fa-user"></i>
                            </div>
                            <h2>Profile</h2>
                        </div>
                        <div class="profile-ref-tag">
                            <i class="fas fa-hashtag mr-1"></i>
                            Ref ID: <?= $details['ref_id'] ?? '' ?>
                        </div>
                    </div>

                    <!-- DUAL-PANEL WORKSPACE WRAPPER LAYER -->
                    <div class="workspace-container">

                        <!-- LEFT CONTAINER: PERSISTENT CORE INTERACTIVE FORM ELEMENT -->
                        <div class="form-workspace-left">


                            <!-- CARD BLOCK: PERSONAL PROFILE DETAILS -->
                            <div class="main-card" id="section_personal">
                                <div class="section-header-wrap">
                                    <?php
                                    $documents = json_decode($details['documents'] ?? '{}', true);
                                    ?>
                                    <h3 class="section-title"><i class="fas fa-id-card"></i> Personal Information</h3>
                                    <?php if (($details['offer_status'] ?? '') == 'PENDING'): ?>
                                        <a class="edit-section-trigger" onclick="unlockSectionFields('section_personal')"><i
                                                class="fas fa-edit mr-1"></i> Edit Section</a>
                                    <?php endif; ?>
                                </div>

                                <div class="photo-center-row">
                                    <div class="form-group text-center" style="width: 240px;">
                                        <label>Profile Photo</label>
                                        <div class="upload-container-wrapper">
                                            <?php $profile_photo = basename($documents['profile_photo'] ?? ''); ?>
                                            <div class="compact-upload-box"
                                                onclick="launchDocumentPreviewer('<?= !empty($documents['profile_photo']) ? base_url($documents['profile_photo']) : '' ?>', 'Profile Photo')">

                                                <span>
                                                    <i class="fas fa-image mr-2 text-muted"></i>
                                                    <?= $profile_photo ?>
                                                </span>
                                            </div>
                                            <div class="upload-action-btn active-control" data-key="profile_photo">
                                                <i class="fas fa-cloud-upload-alt"></i> Upload
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="grid-3">
                                    <div class="form-group">
                                        <label>Full Name</label>
                                        <input type="text" class="form-control form-control-sm"
                                            value="<?= $details['emp_name'] ?? '' ?>" readonly required>
                                    </div>
                                    <div class="form-group">
                                        <label>Mobile Number</label>
                                        <input type="tel" class="form-control form-control-sm"
                                            value="<?= $details['mobile'] ?? '' ?>" readonly required>
                                    </div>
                                    <div class="form-group">
                                        <label>Email Address</label>
                                        <input type="email" class="form-control form-control-sm"
                                            value="<?= $details['email'] ?? '' ?>" readonly required>
                                    </div>
                                    <div class="form-group">
                                        <label>Date of Birth</label>
                                        <input type="date" class="form-control form-control-sm"
                                            value="<?= $details['dob'] ?? '' ?>" readonly required>
                                    </div>
                                    <div class="form-group">
                                        <label>Gender</label>
                                        <select class="form-control form-control-sm custom-select-sm" disabled>
                                            <option value="MALE" <?= ($details['gender'] ?? '') == 'MALE' ? 'selected' : '' ?>>Male</option>
                                            <option value="FEMALE" <?= ($details['gender'] ?? '') == 'FEMALE' ? 'selected' : '' ?>>Female</option>
                                            <option value="OTHER" <?= ($details['gender'] ?? '') == 'OTHER' ? 'selected' : '' ?>>Other</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Marital Status</label>
                                        <select class="form-control form-control-sm custom-select-sm" disabled>
                                            <option value="SINGLE" <?= ($details['marital_status'] ?? '') == 'SINGLE' ? 'selected' : '' ?>>Single</option>
                                            <option value="MARRIED" <?= ($details['marital_status'] ?? '') == 'MARRIED' ? 'selected' : '' ?>>Married</option>
                                            <option value="DIVORCED" <?= ($details['marital_status'] ?? '') == 'DIVORCED' ? 'selected' : '' ?>>Divorced</option>
                                            <option value="WIDOWED" <?= ($details['marital_status'] ?? '') == 'WIDOWED' ? 'selected' : '' ?>>Widowed</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Father Name</label>
                                        <input type="text" class="form-control form-control-sm"
                                            value="<?= $details['father_name'] ?? '' ?>" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label>Mother Name</label>
                                        <input type="text" class="form-control form-control-sm"
                                            value="<?= $details['mother_name'] ?? '' ?>" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label>PAN Number</label>
                                        <input type="text" class="form-control form-control-sm"
                                            value="<?= $details['pan'] ?? '' ?>" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label>Aadhaar Number</label>
                                        <input type="text" class="form-control form-control-sm"
                                            value="<?= $details['aadhaar'] ?? '' ?>" readonly>
                                    </div>

                                    <?php $aadhaar = $documents['aadhaar'] ?? ''; ?>
                                    <div class="form-group">
                                        <label>Aadhaar Card Document</label>
                                        <div class="upload-container-wrapper">

                                            <div class="compact-upload-box"
                                                onclick="launchDocumentPreviewer('<?= base_url($aadhaar) ?>', 'Aadhaar Document')">

                                                <span>
                                                    <i class="fas fa-file-pdf text-danger mr-2"></i>
                                                    <?= basename($aadhaar) ?: 'Not Uploaded' ?>
                                                </span>
                                            </div>

                                            <div class="upload-action-btn active-control" data-key="aadhaar">
                                                <i class="fas fa-sync"></i> Replace
                                            </div>
                                        </div>
                                    </div>

                                    <?php $pan = $documents['pan'] ?? ''; ?>

                                    <div class="form-group">
                                        <label>PAN Card Document</label>
                                        <div class="upload-container-wrapper">

                                            <div class="compact-upload-box"
                                                onclick="launchDocumentPreviewer('<?= base_url($pan) ?>', 'PAN Document')">

                                                <span>
                                                    <i class="fas fa-file-pdf text-danger mr-2"></i>
                                                    <?= basename($pan) ?: 'Not Uploaded' ?>
                                                </span>
                                            </div>

                                            <div class="upload-action-btn active-control" data-key="pan">
                                                <i class="fas fa-sync"></i> Replace
                                            </div>

                                        </div>
                                    </div>

                                    <div class="form-group span-3">
                                        <label>Full Permanent Address</label>
                                        <textarea class="form-control form-control-sm" rows="2"
                                            readonly><?= ($current_address['houseNo'] ?? '') . ', ' . ($current_address['buildingName'] ?? '') . ', ' . ($current_address['streetNo'] ?? '') . ', ' . ($current_address['area'] ?? '') ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>City</label>
                                        <input type="text" class="form-control form-control-sm"
                                            value="<?= $current_address['city'] ?? '' ?>" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label>State</label>
                                        <input type="text" class="form-control form-control-sm"
                                            value="<?= $current_address['state'] ?? '' ?>" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label>Pincode</label>
                                        <input type="text" class="form-control form-control-sm"
                                            value="<?= $current_address['pincode'] ?? '' ?>" readonly>
                                    </div>
                                </div>
                            </div>

                            <!-- CARD BLOCK: BANKING SETTLEMENT COORDINATES -->
                            <div class="main-card" id="section_banking">
                                <div class="section-header-wrap">
                                    <h3 class="section-title"><i class="fas fa-university"></i> Bank Details</h3>
                                    <?php if (($details['offer_status'] ?? '') == 'PENDING'): ?>
                                        <a class="edit-section-trigger" onclick="unlockSectionFields('section_banking')"><i
                                                class="fas fa-edit mr-1"></i> Edit Section</a>
                                    <?php endif; ?>
                                </div>

                                <div class="grid-3">
                                    <div class="form-group">
                                        <label>Account Holder Name</label>
                                        <input type="text" class="form-control form-control-sm"
                                            value="<?= $details['bank_holder_name'] ?? '' ?>" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label>Bank Name</label>
                                        <input type="text" class="form-control form-control-sm"
                                            value="<?= $details['bank_name'] ?? '' ?>" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label>Account Number</label>

                                        <div style="position:relative;">
                                            <input type="password" id="accountNo" class="form-control form-control-sm"
                                                value="<?= $details['bank_account_no'] ?? '' ?>" readonly
                                                style="padding-right:40px;">
                                            <i id="accountEye" class="fas fa-eye" onclick="toggleAccountNo()" style="
                                                position:absolute;
                                                top:50%;
                                                right:12px;
                                                transform:translateY(-50%);
                                                cursor:pointer;
                                                color:#6c757d;">
                                            </i>
                                        </div>
                                    </div>
                                    <!-- <div class="form-group">                
                                        <label>Confirm Account Number</label>                
                                        <input type="text" class="form-control form-control-sm" value="30987654321" readonly>            
                                    </div> -->
                                    <div class="form-group">
                                        <label>IFSC Code</label>
                                        <input type="text" class="form-control form-control-sm"
                                            value="<?= $details['ifsc'] ?? '' ?>" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label>Branch Name</label>
                                        <input type="text" class="form-control form-control-sm"
                                            value="<?= $details['bank_branch'] ?? '' ?>" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label>UPI ID</label>
                                        <input type="text" class="form-control form-control-sm"
                                            value="<?= $details['upi_id'] ?? '' ?>" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label>Account Type</label>
                                        <input type="text" class="form-control form-control-sm"
                                            value="<?= $details['bank_account_type'] ?? '' ?>" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label>Passbook / Cancelled Cheque</label>
                                        <div class="upload-container-wrapper">
                                            <div class="compact-upload-box"
                                                onclick="launchDocumentPreviewer('cheque.jpg', 'Image Resource Asset')">
                                                <span><i class="fas fa-image text-info mr-2"></i>cheque.jpg</span>
                                            </div>
                                            <div class="upload-action-btn">
                                                <i class="fas fa-sync"></i> Replace
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- CARD BLOCK: EDUCATION HISTORY PORTFOLIO PIPELINE -->
                            <?php
                            $higherEducations = [];

                            foreach ($qualification as $edu) {

                                $type = strtolower(trim($edu['education_type'] ?? ''));

                                if (
                                    $type != 'graduation' &&
                                    $type != 'intermediate' &&
                                    $type != '10th'
                                ) {
                                    $higherEducations[] = $edu;
                                }
                            }
                            ?>
                            <div class="main-card" id="section_education">
                                <div class="section-header-wrap">
                                    <h3 class="section-title"><i class="fas fa-graduation-cap"></i> Education Details
                                    </h3>
                                    <?php if (($details['offer_status'] ?? '') == 'PENDING'): ?>
                                        <a class="edit-section-trigger"
                                            onclick="unlockSectionFields('section_education')"><i
                                                class="fas fa-edit mr-1"></i> Edit Section</a>
                                    <?php endif; ?>
                                </div>

                                <div class="grid-3">
                                    <?php if (!empty($higherEducations)): ?>

                                        <?php foreach ($higherEducations as $index => $higher): ?>

                                            <div class="form-group span-3"
                                                style="margin:15px 0 5px;border-top:1px dashed #e2e8f0;padding-top:15px;">

                                                <h4 class="section-title" style="font-size:13px;">
                                                    <i class="fas fa-user-graduate text-primary"></i>

                                                    Higher Education <?= $index + 1 ?>
                                                </h4>

                                            </div>

                                            <div class="form-group">
                                                <label>Qualification</label>
                                                <input type="text" class="form-control form-control-sm"
                                                    value="<?= $higher['education_type'] ?? '' ?>" readonly>
                                            </div>

                                            <div class="form-group">
                                                <label>College / University</label>
                                                <input type="text" class="form-control form-control-sm"
                                                    value="<?= $higher['institution'] ?? '' ?>" readonly>
                                            </div>

                                            <div class="form-group">
                                                <label>Passed Out Year</label>
                                                <input type="text" class="form-control form-control-sm"
                                                    value="<?= $higher['year_of_pass'] ?? '' ?>" readonly>
                                            </div>

                                            <div class="form-group">
                                                <label>Percentage</label>
                                                <input type="text" class="form-control form-control-sm"
                                                    value="<?= $higher['percentage'] ?? '' ?>" readonly>
                                            </div>

                                            <div class="form-group">
                                                <label>Course Type</label>
                                                <input type="text" class="form-control form-control-sm"
                                                    value="<?= $higher['courseType'] ?? '' ?>" readonly>
                                            </div>

                                        <?php endforeach; ?>

                                    <?php endif; ?>
                                    <!-- HIGHEST QUALIFICATION DETAILS -->
                                    <div class="form-group span-3"
                                        style="margin:15px 0 5px;border-top:1px dashed #e2e8f0;padding-top:15px;">
                                        <h4 class="section-title" style="font-size:13px;">
                                            <i class="fas fa-user-graduate text-success"></i>
                                            Graduation Details
                                        </h4>
                                    </div>
                                    <div class="form-group">
                                        <label>Degree Qualification</label>
                                        <input type="text" class="form-control form-control-sm"
                                            value="<?= $highest['education_type'] ?? '' ?>" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label>Specialization / Branch</label>
                                        <input type="text" class="form-control form-control-sm"
                                            value="<?= $highest['specialization'] ?? '' ?>" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label>College / University Name</label>
                                        <input type="text" class="form-control form-control-sm"
                                            value="<?= $highest['institution'] ?? '' ?>" readonly>
                                    </div>
                                    <!-- <div class="form-group">            
                                        <label>University / Board</label>            
                                        <input type="text" class="form-control form-control-sm" value="<?= $highest['university'] ?? '' ?>" readonly>        
                                    </div> -->
                                    <!-- <div class="form-group">            
                                    <label>Course Type</label>            
                                    <select class="form-control form-control-sm custom-select-sm" disabled style="font-size: 13px !important;">
                                        <option value="Regular" <?= ($highest['courseType'] ?? '') == 'Regular' ? 'selected' : '' ?>>Regular</option>
                                        <option value="Distance" <?= ($highest['courseType'] ?? '') == 'Distance' ? 'selected' : '' ?>>Distance</option>
                                        <option value="Online" <?= ($highest['courseType'] ?? '') == 'Online' ? 'selected' : '' ?>>Online</option>
                                    </select>         
                                </div> -->
                                    <div class="form-group">
                                        <label>Passed Out Year</label>
                                        <input type="number" class="form-control form-control-sm"
                                            value="<?= $highest['year_of_pass'] ?? '' ?>" readonly>
                                    </div>
                                    <!-- <div class="form-group">            
                                        <label>Start Date</label>            
                                        <input type="month" class="form-control form-control-sm"  value="<?= $highest['start_date'] ?? '' ?>" readonly>        
                                    </div>
                                    <div class="form-group">            
                                        <label>End Date</label>            
                                        <input type="month" class="form-control form-control-sm" value="<?= $highest['end_date'] ?? '' ?>"  readonly>        
                                    </div> -->
                                    <div class="form-group">
                                        <label>Percentage</label>
                                        <input type="text" class="form-control form-control-sm"
                                            value="<?= $highest['percentage'] ?? '' ?>" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label>Backlogs (If Any)</label>
                                        <select class="form-control form-control-sm custom-select-sm" disabled
                                            style="font-size: 13px !important;">
                                            <option value="No Backlogs" <?= ($highest['backlogs'] ?? '') == 'No Backlogs' ? 'selected' : '' ?>>No Backlogs</option>
                                            <option value="1 Backlog" <?= ($highest['backlogs'] ?? '') == '1 Backlog' ? 'selected' : '' ?>>1 Backlog</option>
                                            <option value="2 Backlogs" <?= ($highest['backlogs'] ?? '') == '2 Backlogs' ? 'selected' : '' ?>>2 Backlogs</option>
                                            <option value="3+ Backlogs" <?= ($highest['backlogs'] ?? '') == '3+ Backlogs' ? 'selected' : '' ?>>3+ Backlogs</option>
                                        </select>
                                    </div>

                                    <?php $degree = $documents['degree'] ?? ''; ?>
                                    <div class="form-group">
                                        <label>Degree Certificate</label>
                                        <div class="upload-container-wrapper">

                                            <div class="compact-upload-box"
                                                onclick="launchDocumentPreviewer('<?= base_url($degree) ?>', 'Degree Certificate')">

                                                <span>
                                                    <i class="fas fa-file-pdf text-danger mr-2"></i>
                                                    <?= basename($degree) ?: 'Not Uploaded' ?>
                                                </span>
                                            </div>

                                            <div class="upload-action-btn active-control" data-key="degree">
                                                <i class="fas fa-sync"></i> Replace
                                            </div>
                                        </div>
                                    </div>

                                    <?php $provisional = $documents['provisional'] ?? ''; ?>
                                    <div class="form-group">
                                        <label>Provisional Certificate</label>
                                        <div class="upload-container-wrapper">
                                            <div class="compact-upload-box"
                                                onclick="launchDocumentPreviewer('<?= base_url($provisional) ?>', 'Provisional Certificate')">

                                                <span>
                                                    <i class="fas fa-file-pdf text-danger mr-2"></i>
                                                    <?= basename($provisional) ?: 'Not Uploaded' ?>
                                                </span>
                                            </div>
                                            <div class="upload-action-btn active-control" data-key="provisional">
                                                <i class="fas fa-sync"></i> Replace
                                            </div>
                                        </div>
                                    </div>

                                    <!-- INTERMEDIATE (12TH) SUBSECTION PROFILE LINK -->
                                    <div class="form-group span-3"
                                        style="margin: 15px 0 5px 0; border-top: 1px dashed #e2e8f0; padding-top: 15px;">
                                        <h4 class="section-title" style="font-size: 13px;"><i
                                                class="fas fa-user-graduate text-muted"></i> Intermediate (12th) Details
                                        </h4>
                                    </div>

                                    <div class="form-group">
                                        <label>College Name</label>
                                        <input type="text" class="form-control form-control-sm"
                                            value="<?= $inter['institution'] ?? '' ?>" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label>Course / Stream</label>
                                        <select class="form-control form-control-sm custom-select-sm" disabled>
                                            <option value="MPC" <?= ($inter['stream'] ?? '') == 'MPC (Maths, Physics, Chemistry)' ? 'selected' : '' ?>>MPC</option>
                                            <option value="BIPC" <?= ($inter['stream'] ?? '') == 'BIPC' ? 'selected' : '' ?>>BIPC</option>
                                            <option value="CEC" <?= ($inter['stream'] ?? '') == 'CEC' ? 'selected' : '' ?>>
                                                CEC</option>
                                            <option value="MEC" <?= ($inter['stream'] ?? '') == 'MEC' ? 'selected' : '' ?>>
                                                MEC</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Board</label>
                                        <select class="form-control form-control-sm custom-select-sm" disabled>
                                            <option value="Board of Intermediate Education" <?= ($inter['board'] ?? '') == 'Board of Intermediate Education' ? 'selected' : '' ?>>
                                                Board of Intermediate
                                            </option>
                                            <option value="CBSE" <?= ($inter['board'] ?? '') == 'CBSE' ? 'selected' : '' ?>>CBSE</option>
                                            <option value="ICSE" <?= ($inter['board'] ?? '') == 'ICSE' ? 'selected' : '' ?>>ICSE</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Passed Out Year</label>
                                        <input type="number" class="form-control form-control-sm"
                                            value="<?= $inter['year_of_pass'] ?? '' ?>" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label>Percentage</label>
                                        <input type="text" class="form-control form-control-sm"
                                            value="<?= $inter['percentage'] ?? '' ?>" readonly>
                                    </div>
                                    <?php $inter = $documents['intermediate'] ?? ''; ?>

                                    <div class="form-group">
                                        <label>Intermediate Certificate</label>
                                        <div class="upload-container-wrapper">
                                            <div class="compact-upload-box"
                                                onclick="launchDocumentPreviewer('<?= base_url($inter) ?>', 'Intermediate Certificate')">

                                                <span>
                                                    <i class="fas fa-file-pdf text-danger mr-2"></i>
                                                    <?= basename($inter) ?: 'Not Uploaded' ?>
                                                </span>
                                            </div>
                                            <div class="upload-action-btn active-control" data-key="intermediate">
                                                <i class="fas fa-sync"></i> Replace
                                            </div>
                                        </div>
                                    </div>

                                    <!-- 10TH (SSC) SUBSECTION PROFILE LINK -->
                                    <div class="form-group span-3"
                                        style="margin: 15px 0 5px 0; border-top: 1px dashed #e2e8f0; padding-top: 15px;">
                                        <h4 class="section-title" style="font-size: 13px;"><i
                                                class="fas fa-school text-muted"></i> 10th (SSC) Details</h4>
                                    </div>

                                    <div class="form-group">
                                        <label>School Name</label>
                                        <input type="text" class="form-control form-control-sm"
                                            value="<?= $tenth['institution'] ?? '' ?>" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label>Board</label>
                                        <select class="form-control form-control-sm custom-select-sm" disabled>
                                            <option value="SSC" <?= ($tenth['board'] ?? '') == 'SSC (State Board)' ? 'selected' : '' ?>>SSC</option>
                                            <option value="CBSE" <?= ($tenth['board'] ?? '') == 'CBSE' ? 'selected' : '' ?>>CBSE</option>
                                            <option value="ICSE" <?= ($tenth['board'] ?? '') == 'ICSE' ? 'selected' : '' ?>>ICSE</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Passed Out Year</label>
                                        <input type="number" class="form-control form-control-sm"
                                            value="<?= $tenth['year_of_pass'] ?? '' ?>" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label>Percentage</label>
                                        <input type="text" class="form-control form-control-sm"
                                            value="<?= $tenth['percentage'] ?? '' ?>" readonly>
                                    </div>
                                    <?php $ssc = $documents['ssc'] ?? ''; ?>

                                    <div class="form-group">
                                        <label>10th Certificate</label>
                                        <div class="upload-container-wrapper">
                                            <div class="compact-upload-box"
                                                onclick="launchDocumentPreviewer('<?= base_url($ssc) ?>', 'SSC Certificate')">

                                                <span>
                                                    <i class="fas fa-file-pdf text-danger mr-2"></i>
                                                    <?= basename($ssc) ?: 'Not Uploaded' ?>
                                                </span>
                                            </div>
                                            <div class="upload-action-btn active-control" data-key="ssc">
                                                <i class="fas fa-sync"></i> Replace
                                            </div>
                                        </div>
                                    </div>
                                    <?php $marks = $documents['marks_memo'] ?? ''; ?>

                                    <div class="form-group">
                                        <label>Marks Memo / Other Attachments</label>
                                        <div class="upload-container-wrapper">
                                            <div class="compact-upload-box"
                                                onclick="launchDocumentPreviewer('<?= base_url($marks) ?>', 'Marks Memo')">

                                                <span>
                                                    <i class="fas fa-file-pdf text-danger mr-2"></i>
                                                    <?= basename($marks) ?: 'Not Uploaded' ?>
                                                </span>
                                            </div>
                                            <div class="upload-action-btn active-control" data-key="marks_memo">
                                                <i class="fas fa-sync"></i> Replace
                                            </div>

                                        </div>
                                    </div>

                                    <!-- ADDITIONAL COMPOSITE PROFILE METADATA SECTION -->
                                    <!-- <div class="form-group span-3" style="margin: 15px 0 5px 0; border-top: 1px dashed #e2e8f0; padding-top: 15px;">
                                        <h4 class="section-title" style="font-size: 13px;"><i class="fas fa-award text-muted"></i> Skills & Project Background</h4>
                                    </div>

                                    <div class="form-group span-3">            
                                        <label>Technical Skills Learned</label>            
                                        <input type="text" class="form-control form-control-sm" value="<?= $details['skills'] ?? '' ?>" readonly>        
                                    </div>
                                    <div class="form-group span-3">            
                                        <label>Academic Project Details</label>            
                                        <textarea class="form-control form-control-sm" rows="2" readonly>Designed and compiled deep integration pipelines utilizing custom back-end framework logic operations.</textarea>        
                                    </div>
                                    <div class="form-group">                
                                        <label>Technical Certificates / Coursework</label>
                                        <div class="upload-container-wrapper">
                                            <div class="compact-upload-box" onclick="launchDocumentPreviewer('internship_certs.pdf', 'PDF Verification Source Document')">                    
                                                <span><i class="fas fa-award text-warning mr-2"></i>internship_certs.pdf</span>
                                            </div>            
                                            <div class="upload-action-btn">
                                                <i class="fas fa-sync"></i> Replace
                                            </div> -->
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- CARD BLOCK: AUTOMATED WORK EXPERIENCE PORTFOLIO PIPELINE -->
                    <?php foreach ($experience as $index => $exp): ?>
                        <?php if (($exp['experience_type'] ?? '') === 'EXPERIENCED'): ?>
                            <div class="main-card" id="section_experience">
                                <div class="section-header-wrap">
                                    <h3 class="section-title">
                                        <i class="fas fa-briefcase"></i>
                                        Work Experience <?= $index + 1 ?>
                                    </h3>
                                    <?php if (($details['offer_status'] ?? '') == 'PENDING'): ?>
                                        <a class="edit-section-trigger" onclick="unlockSectionFields('section_experience')"><i
                                                class="fas fa-edit mr-1"></i> Edit Section</a>
                                    <?php endif; ?>
                                </div>

                                <div class="grid-3">
                                    <div class="form-group">
                                        <label>Company Name</label>
                                        <input type="text" class="form-control form-control-sm"
                                            value="<?= esc($exp['company_name'] ?? '') ?>" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label>Designation / Role</label>
                                        <input type="text" class="form-control form-control-sm"
                                            value="<?= esc($exp['designation'] ?? '') ?>" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label>Employment Type</label>
                                        <select class="form-control form-control-sm custom-select-sm" disabled>
                                            <option value="FULL_TIME" <?= ($exp['employment_type'] ?? '') == 'FULL_TIME' ? 'selected' : '' ?>>Full Time</option>
                                            <option value="PART_TIME" <?= ($exp['employment_type'] ?? '') == 'PART_TIME' ? 'selected' : '' ?>>Part Time</option>
                                            <option value="INTERNSHIP" <?= ($exp['employment_type'] ?? '') == 'INTERNSHIP' ? 'selected' : '' ?>>Internship</option>
                                            <option value="CONTRACT" <?= ($exp['employment_type'] ?? '') == 'CONTRACT' ? 'selected' : '' ?>>Contract</option>
                                        </select>
                                        <!-- <input type="text"class="form-control form-control-sm"   value="<?= esc($exp['employment_type'] ?? '') ?>" readonly> -->
                                    </div>
                                    <div class="form-group">
                                        <label>Total Experience</label>
                                        <!-- <select class="form-control form-control-sm custom-select-sm" disabled>                
                                            <option value="0 - 1 Year">0 - 1 Year</option>                
                                            <option value="1 - 3 Years" selected>1 - 3 Years</option>                
                                            <option value="3 - 5 Years">3 - 5 Years</option>                
                                            <option value="5+ Years">5+ Years</option>            
                                        </select>         -->
                                        <input type="text" class="form-control form-control-sm"
                                            value="<?= esc($exp['total_experience'] ?? '') ?>" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label>Start Date</label>
                                        <input type="date" class="form-control form-control-sm"
                                            value="<?= esc($exp['start_date'] ?? '') ?>" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label>End Date</label>
                                        <input type="date" class="form-control form-control-sm"
                                            value="<?= esc($exp['end_date'] ?? '') ?>" readonly>
                                    </div>
                                    <?php if ($index == 0): ?>
                                        <div class="form-group">
                                            <label>Current CTC</label>
                                            <input type="text" class="form-control form-control-sm"
                                                value="<?= number_format((int) ($exp['current_ctc'] ?? 0)) ?>" readonly>
                                        </div>
                                    <?php endif; ?>
                                    <!-- <div class="form-group">            
                                        <label>Expected CTC</label>            
                                        <input type="text" class="form-control form-control-sm" value="6,50,000" readonly>        
                                    </div> -->
                                    <?php $resume = $documents['resume'] ?? ''; ?>

                                    <div class="form-group">
                                        <label>Resume Attachment</label>
                                        <div class="upload-container-wrapper">
                                            <div class="compact-upload-box"
                                                onclick="launchDocumentPreviewer('<?= base_url($resume) ?>', 'Resume')">

                                                <span>
                                                    <i class="fas fa-file-pdf text-success mr-2"></i>
                                                    <?= basename($resume) ?: 'Not Uploaded' ?>
                                                </span>
                                            </div>
                                            <div class="upload-action-btn active-control" data-key="resume">
                                                <i class="fas fa-sync"></i> Replace
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group span-3">
                                        <label>Skills & Technologies</label>
                                        <input type="text" class="form-control form-control-sm"
                                            value="<?= esc($exp['skills'] ?? '') ?>" readonly>
                                    </div>
                                    <div class="form-group span-3">
                                        <label>Project Experience</label>
                                        <textarea class="form-control form-control-sm" rows="2"
                                            readonly><?= esc($exp['major_projects_delivered'] ?? '') ?></textarea>
                                    </div>
                                    <div class="form-group span-3">
                                        <label>Job Responsibilities</label>
                                        <textarea class="form-control form-control-sm" rows="2"
                                            readonly><?= esc($exp['core_job_responsibilities'] ?? '') ?></textarea>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>


                    <!-- FORM COMMITTAL ACTION BUTTON LAYER -->
                    <div style="margin-top: 30px; border-top: 1px solid #e2e8f0; padding-top: 20px; text-align: right;">
                        <?php
                        $current_step = $details['current_step'] ?? 0;
                        $onboarding_status = strtoupper($details['onboarding_status'] ?? '');
                        ?>
                        <?php if ($current_step == 6 && $onboarding_status != 'COMPLETED'): ?>
                            <button type="button"
                                style="background: linear-gradient(135deg,#4a00e0,#7c3aed); color:#fff; border:none; padding:10px 30px; border-radius:10px; font-size:13px; font-weight:700; cursor:pointer;"
                                onclick="finalSubmit()">

                                <i class="fas fa-save mr-2"></i>Final & Submit
                            </button>
                        <?php endif; ?>

                        <?php
                        $onboarding_status = strtoupper($details['onboarding_status'] ?? '');
                        ?>
                        <?php if ($onboarding_status != 'COMPLETED'): ?>
                            <button type="submit"
                                style="background: linear-gradient(135deg,#4a00e0,#7c3aed); color:#fff; border:none; padding:10px 30px; border-radius:10px; font-size:13px; font-weight:700; cursor:pointer; box-shadow:0 8px 20px rgba(74,0,224,0.2);"
                                data-toggle="modal" data-target="#organizationModal">
                                <i class="fas fa-save mr-2"></i>Save & Submit
                            </button>
                        <?php endif; ?>
                    </div>
                    <input type="file" id="docUploadInput" style="display:none;" accept=".pdf,.jpg,.png,.webp">
                </div>

                <!-- RIGHT CONTAINER: SIDE DYNAMIC ATTACHMENT VIEWPORT DRAWER -->
                <div class="preview-workspace-right" id="workspace_preview_drawer" style="width: 440px;">
                    <div class="document-preview-card">
                        <!-- HEADER WITH DYNAMIC ZOOM CONTROLS -->
                        <div class="preview-card-header"
                            style="padding: 12px 16px; display: flex; justify-content: space-between; align-items: center;">
                            <h4 id="preview_title_filename" style="font-size: 13px; font-weight: 700; margin: 0;">
                                document_preview.pdf</h4>

                            <!-- Action Controls for Drawer Zooming -->
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <button type="button" class="btn btn-xs btn-outline-light" onclick="adjustPreviewZoom(0.2)"
                                    title="Zoom In">
                                    <i class="fas fa-search-plus"></i>
                                </button>
                                <button type="button" class="btn btn-xs btn-outline-light" onclick="adjustPreviewZoom(-0.2)"
                                    title="Zoom Out">
                                    <i class="fas fa-search-minus"></i>
                                </button>
                                <button type="button" class="btn btn-xs btn-outline-light" onclick="resetPreviewZoom()"
                                    title="Reset Zoom">
                                    <i class="fas fa-undo"></i>
                                </button>
                                <a href="javascript:void(0)" style="color: #94a3b8; font-size: 14px; margin-left: 6px;"
                                    onclick="dismissPreviewDrawer()">
                                    <i class="fas fa-times"></i>
                                </a>
                            </div>
                        </div>

                        <!-- BODY CONTAINER WITH DYNAMIC IMAGE TARGET -->
                        <div class="preview-body-container" id="preview_viewport_container">
                            <iframe id="preview_iframe_target" src=""
                                style="display: none; width: 100%; height: 100%; border: none; transform-origin: center center; transition: transform 0.15s ease-in-out;"></iframe>
                            <img id="preview_image_target" src="" alt="Document Preview"
                                style="display: none; max-width: 100%; max-height: 100%; object-fit: contain; transform-origin: center center; transition: transform 0.15s ease-in-out;">

                            <div id="preview_fallback_meta" class="text-center p-4">
                                <i class="fas fa-file-invoice fa-4x mb-3" style="color: #64748b;"></i>
                                <h5 id="preview_context_meta" style="font-size: 13px; font-weight: 700; color: #fff;">
                                    Verification Source Asset
                                </h5>
                                <p class="mb-4" style="font-size: 12px; color: #94a3b8; font-weight: 500; line-height: 1.6;">
                                    No file selected or preview unavailable.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
        </section>
        </div>

    <div class="modal fade" id="organizationModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="border:none;border-radius:14px;overflow:hidden;">

                <!-- Header -->
                <div class="modal-header"
                    style="background:linear-gradient(135deg,#4a00e0,#7c3aed);color:#fff;border:none;padding:16px 22px;">

                    <h5 class="modal-title" style="font-weight:700;font-size:16px;">
                        <i class="fas fa-sitemap mr-2"></i>
                        Organization Details
                    </h5>

                    <button type="button" class="close text-white" data-dismiss="modal" style="opacity:1;">
                        &times;
                    </button>

                </div>

                <!-- Body -->
                <div class="modal-body" style="padding:25px;">

                    <div class="grid-3">

                        <div class="form-group">
                            <label>Department</label>
                            <input type="text" id="department" class="form-control form-control-sm" name="department"
                                placeholder="Enter Department">
                        </div>

                        <div class="form-group">
                            <label>Designation</label>
                            <input type="text" id="designation" class="form-control form-control-sm" name="designation"
                                placeholder="Enter Designation">
                        </div>

                        <div class="form-group">
                            <label>Reporting To</label>

                            <select class="form-control form-control-sm" id="reporting_to" name="reporting_to">

                                <option value="">Select Manager</option>

                                <?php foreach ($managers as $manager): ?>
                                    <option value="<?= $manager['emp_id']; ?>">
                                        <?= $manager['emp_id']; ?>
                                    </option>
                                <?php endforeach; ?>

                            </select>
                        </div>

                        <div class="form-group">
                            <label>Joining Date</label>

                            <input type="date" id="joining_date" class="form-control form-control-sm"
                                name="joining_date">
                        </div>

                    </div>

                </div>

                <!-- Footer -->
                <div class="modal-footer" style="border-top:1px solid #e2e8f0;padding:18px 25px;">

                    <button type="button" class="btn btn-light" data-dismiss="modal">
                        Cancel
                    </button>

                    <button type="button" onclick="saveOrganizationDetails()" style="background:linear-gradient(135deg,#4a00e0,#7c3aed);
                               color:#fff;
                               border:none;
                               padding:10px 28px;
                               border-radius:10px;
                               font-size:13px;
                               font-weight:700;
                               box-shadow:0 8px 20px rgba(74,0,224,.2);">

                        <i class="fas fa-save mr-2"></i>
                        Update Details

                    </button>

                </div>

            </div>
        </div>
    </div>
    <!-- System Script Frameworks -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>


    <script>
        function unlockSectionFields(sectionId) {
            const cardContext = document.getElementById(sectionId);

            // Unlock structural form input arrays
            const textualInputs = cardContext.querySelectorAll('input, textarea');
            textualInputs.forEach(input => {
                input.removeAttribute('readonly');
                input.classList.add('editable-active');
            });

            // Unlock custom selector controls
            const selectionControls = cardContext.querySelectorAll('select');
            selectionControls.forEach(select => {
                select.removeAttribute('disabled');
                select.classList.add('editable-active');
            });

            // Switch action upload button components to operational context
            const buttonControls = cardContext.querySelectorAll('.upload-action-btn');
            buttonControls.forEach(btn => {
                btn.classList.add('active-control');
            });
        }

        // Keep the preview as a direct child of the split workspace.
        // candidate1 contains a large amount of conditional PHP/HTML, so the browser
        // can normalize an unbalanced div differently than the source indentation.
        // This guarantees the preview stays in the right-hand flex column.
        (function normalizePreviewWorkspace() {
            const workspace = document.querySelector('.workspace-container');
            const preview = document.getElementById('workspace_preview_drawer');

            if (workspace && preview && preview.parentElement !== workspace) {
                workspace.appendChild(preview);
            }
        })();

        // Track individual scale factor for the preview drawer asset
        let currentPreviewScale = 1;

        function launchDocumentPreviewer(fileUrl, documentMetaContext) {
            resetPreviewZoom();

            const drawer = document.getElementById('workspace_preview_drawer');
            drawer.style.display = 'block';

            const titleElem = document.getElementById('preview_title_filename');
            const metaElem = document.getElementById('preview_context_meta');
            const fallbackTextElem = document.querySelector('#preview_fallback_meta p');

            const cleanName = fileUrl ? fileUrl.split('/').pop() : 'No File';
            if (titleElem) {
                titleElem.innerText = (cleanName === 'No Photo' || cleanName === 'No File') ? 'Missing Document' : cleanName;
            }
            if (metaElem) metaElem.innerText = documentMetaContext;

            const iframeTarget = document.getElementById('preview_iframe_target');
            const imageTarget = document.getElementById('preview_image_target');
            const fallbackMeta = document.getElementById('preview_fallback_meta');

            // Hide all targets to avoid flickering
            if (iframeTarget) iframeTarget.style.display = 'none';
            if (imageTarget) imageTarget.style.display = 'none';
            if (fallbackMeta) fallbackMeta.style.display = 'none';

            // Verify if File is inherently empty/missing (ex: URL string trailing with slash or recognized null placeholder)
            if (!fileUrl || fileUrl.endsWith('/') || cleanName === 'No Photo' || cleanName === 'No File') {
                if (fallbackMeta) {
                    fallbackMeta.style.display = 'block';
                    if (fallbackTextElem) fallbackTextElem.innerText = "No preview available.";
                }
                return;
            }

            const ext = fileUrl.split('.').pop().toLowerCase();

            if (['jpg', 'jpeg', 'png', 'webp', 'gif'].includes(ext)) {
                if (imageTarget) {
                    imageTarget.src = fileUrl;
                    imageTarget.style.display = 'block';
                }
            } else if (ext === 'pdf') {
                if (iframeTarget) {
                    iframeTarget.src = fileUrl;
                    iframeTarget.style.display = 'block';
                }
            } else {
                if (fallbackMeta) {
                    fallbackMeta.style.display = 'block';
                    if (fallbackTextElem) fallbackTextElem.innerText = "Preview not supported for this file format.";
                }
            }
        }

        function adjustPreviewZoom(amount) {
            const iframeTarget = document.getElementById('preview_iframe_target');
            const imageTarget = document.getElementById('preview_image_target');
            let target = null;

            if (iframeTarget && iframeTarget.style.display === 'block') target = iframeTarget;
            else if (imageTarget && imageTarget.style.display === 'block') target = imageTarget;

            if (!target) return;

            currentPreviewScale += amount;
            if (currentPreviewScale < 0.5) currentPreviewScale = 0.5;
            if (currentPreviewScale > 3.0) currentPreviewScale = 3.0;

            target.style.transform = `scale(${currentPreviewScale})`;
        }

        function resetPreviewZoom() {
            currentPreviewScale = 1;
            const iframeTarget = document.getElementById('preview_iframe_target');
            const imageTarget = document.getElementById('preview_image_target');

            if (iframeTarget) iframeTarget.style.transform = 'scale(1)';
            if (imageTarget) imageTarget.style.transform = 'scale(1)';
        }

        function dismissPreviewDrawer() {
            document.getElementById('workspace_preview_drawer').style.display = 'none';
        }

        function triggerFormSubmission(event) {
            event.preventDefault();
            alert("Profile configurations updated and committed successfully!");
        }

        document.addEventListener('DOMContentLoaded', function () {
            launchDocumentPreviewer('<?= !empty($documents['profile_photo']) ? base_url($documents['profile_photo']) : '' ?>', 'Profile Photo');
        });

        let selectedKey = null;

        document.querySelectorAll('.upload-action-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                selectedKey = this.getAttribute('data-key');
                document.getElementById('docUploadInput').click();
            });
        });

        document.getElementById('docUploadInput').addEventListener('change', function () {
            const file = this.files[0];

            if (!file || !selectedKey) return;

            let formData = new FormData();
            formData.append("file", file);
            formData.append("key", selectedKey);
            formData.append("ref_id", "<?= $details['ref_id'] ?>");

            fetch("<?= base_url('replace-document') ?>", {
                method: "POST",
                body: formData
            })
                .then(res => res.json())
                .then(res => {
                    if (res.status === 'success') {
                        showToast("Document replaced successfully.");
                        setTimeout(() => {
                            location.reload();
                        }, 1200);
                    } else {
                        showToast(res.msg || "Upload failed.", "error");
                    }
                })
                .catch(err => {
                    console.log(err);
                    showToast("Something went wrong.", "error");
                });
        });

        function showToast(message, type = "success") {

            const toast = document.getElementById("toastMessage");

            toast.innerHTML = message;

            if (type === "success") {
                toast.style.background = "linear-gradient(135deg,#10b981,#059669)";
            } else {
                toast.style.background = "linear-gradient(135deg,#ef4444,#dc2626)";
            }

            toast.style.display = "block";
            toast.style.opacity = "1";

            setTimeout(() => {
                toast.style.opacity = "0";

                setTimeout(() => {
                    toast.style.display = "none";
                }, 300);

            }, 3000);
        }

        function saveOrganizationDetails() {
            // alert('Function Called'); // test

            let formData = new FormData();

            formData.append('ref_id', '<?= $details['ref_id'] ?>');
            formData.append('department', document.getElementById('department').value);
            formData.append('designation', document.getElementById('designation').value);
            formData.append('reporting_to', document.getElementById('reporting_to').value);
            formData.append('joining_date', document.getElementById('joining_date').value);

            // console.log("Posting Data:");

            //     for (let pair of formData.entries()) {
            //         console.log(pair[0] + " : " + pair[1]);
            //     }

            fetch("<?= base_url('admin/save-organization-details') ?>", {
                method: "POST",
                body: formData
            })
                //     .then(res => res.text())
                // .then(res => {
                //     document.body.innerHTML = res;
                // })
                .then(res => res.json())
                .then(res => {
                    console.log(res);
                    showToast("Organization details updated successfully.");
                })
                .catch(err => {
                    console.log(err);
                    showToast("Something went wrong.", "error");
                });
        }
        //FINAL SUBMIT
        function finalSubmit() {
            let formData = new FormData();
            formData.append('ref_id', '<?= $details['ref_id'] ?>');

            fetch("<?= base_url('admin/final-submit') ?>", {
                method: "POST",
                body: formData
            })
                .then(async (res) => {
                    let text = await res.text();
                    console.log("RAW RESPONSE:", text);

                    try {
                        let json = JSON.parse(text);
                        console.log("JSON:", json);

                        if (json.status === 'Y') {
                            showToast("Candidate approved and mail sent successfully.");
                            setTimeout(() => {
                                location.reload();
                            }, 1500);
                            location.reload();
                        } else {
                            showToast(json.remarks, "error");
                        }
                    } catch (e) {
                        console.log("JSON ERROR:", e);
                        showToast("Server returned an invalid response.", "error");
                    }
                })
                .catch(err => {
                    console.log("FETCH ERROR:", err);
                    showToast("Request failed. Please try again.", "error");
                });

        }
    </script>
    <script>
        function toggleAccountNo() {
            let input = document.getElementById("accountNo");
            let eye = document.getElementById("accountEye");

            if (input.type === "password") {
                input.type = "text";
                eye.classList.remove("fa-eye");
                eye.classList.add("fa-eye-slash");
            } else {
                input.type = "password";
                eye.classList.remove("fa-eye-slash");
                eye.classList.add("fa-eye");
            }
        }
    </script>
    <div id="toastMessage" style="
        position:fixed;
        top:20px;
        right:20px;
        min-width:320px;
        padding:15px 20px;
        border-radius:10px;
        color:#fff;
        font-size:13px;
        font-weight:600;
        display:none;
        z-index:99999;
        box-shadow:0 10px 25px rgba(0,0,0,.15);
        transition:.3s;">
    </div>
</body>

</html>