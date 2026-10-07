<?php
$education = json_decode($profile['qualification'] ?? '[]', true);

$graduation = [];
$intermediate = [];
$tenth = [];

foreach ($education as $edu) {
    $type = strtolower(trim($edu['education_type'] ?? ''));

    if ($type == 'graduation') {
        $graduation = $edu;
    } elseif ($type == 'intermediate') {
        $intermediate = $edu;
    } elseif ($type == '10th' || $type == 'ssc') {
        $tenth = $edu;
    }
}
?>
<?php
$documents = json_decode($profile['documents'] ?? '{}', true);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Bloom Solution | Candidate Edit Form</title>

<!-- External CSS Libraries -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap">
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

.main-sidebar {
    background: var(--bloom-dark)!important;
}

.custom-brand {
    display: flex;
    align-items: center;
    padding: 16px;
    border-bottom: 1px solid rgba(255,255,255,.1);
}

.logo-circle {
    width: 35px;
    height: 35px;
    border-radius: 50%;
    margin-right: 12px;
}

.brand-text { font-size: 18px; font-weight: 700; }
.brand-blue { color: #4a8cff; }
.brand-orange { color: #ff7a45; }
.content-wrapper { background: var(--bloom-bg); }

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
    box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
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
    box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
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
.form-control-sm, .custom-select-sm {
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

.form-control-sm:focus, .custom-select-sm:focus {
    border-color: var(--bloom-purple) !important;
    box-shadow: 0 0 0 2px rgba(74, 0, 224, 0.15) !important;
    background-color: #fff !important;
}

/* Editable Status Active Class Styling overrides */
.form-control-sm.editable-active, .custom-select-sm.editable-active {
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
    box-shadow: 0 10px 25px -5px rgba(0,0,0,0.1);
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

.workspace-container{
    display:flex;
    align-items:flex-start;
    justify-content:space-between;
    gap:20px;
    flex-wrap:nowrap;
}

.form-workspace-left{
    flex:1 1 0;
    min-width:0;
}

.preview-workspace-right{
    width:440px;
    min-width:440px;
    flex-shrink:0;
    position:sticky;
    top:20px;
    display:none;
}
</style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

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
                        <i class="fas fa-hashtag mr-1"></i> EMP ID: <?= esc($profile['emp_id'] ?? 'N/A') ?>
                    </div>
                </div>

                <!-- DUAL-PANEL WORKSPACE WRAPPER LAYER -->
                <div class="workspace-container">
                    
                    <!-- LEFT CONTAINER: PERSISTENT CORE INTERACTIVE FORM ELEMENT -->
                   <div class="form-workspace-left">
    <form action="<?= base_url('admin/update_employee') ?>" method="post" id="profileRegistrationForm">
        <input type="hidden" name="emp_id" value="<?= esc($profile['emp_id']) ?>">
        
        <!-- CARD BLOCK: PERSONAL PROFILE DETAILS -->
        <div class="main-card" id="section_personal">
            <div class="section-header-wrap">
                <h3 class="section-title"><i class="fas fa-id-card"></i> Personal Information</h3>
                <a class="edit-section-trigger" onclick="unlockSectionFields('section_personal')"><i class="fas fa-edit mr-1"></i> Edit Section</a>
            </div>
            
            <div class="photo-center-row">
                <div class="form-group text-center" style="width:240px;">
                    <label>Profile Photo</label>
                    <div class="upload-container-wrapper">
                        <div class="compact-upload-box"
                             onclick="launchDocumentPreviewer('<?= base_url($documents['profile_photo'] ?? '') ?>','Profile Photo')">
                            <span>
                                <i class="fas fa-image mr-2 text-muted"></i>
                                <?= basename($documents['profile_photo'] ?? 'No Photo') ?>
                            </span>
                        </div>
                        <div class="upload-action-btn"
                             data-key="profile_photo">
                            <i class="fas fa-cloud-upload-alt"></i> Upload
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="grid-3">
                <div class="form-group">                
                    <label>Full Name</label>                
                    <input type="text" name="emp_name" class="form-control form-control-sm"  value="<?= esc($profile['emp_name'] ?? '') ?>" data-original="<?= esc($profile['emp_name'] ?? '') ?>" readonly required>            
                </div>
                <div class="form-group">                
                    <label>Mobile Number</label>                
                    <input type="tel" name="mobile" class="form-control form-control-sm"  value="<?= esc($profile['mobile'] ?? '') ?>" data-original="<?= esc($profile['mobile'] ?? '') ?>" readonly required>            
                </div>
                <div class="form-group">                
                    <label>Email Address</label>                
                    <input type="email" name="email" class="form-control form-control-sm" value="<?= esc($profile['email'] ?? '') ?>" data-original="<?= esc($profile['email'] ?? '') ?>" readonly required>            
                </div>
                <div class="form-group">                
                    <label>Date of Birth</label>                
                    <input type="date" name="dob" class="form-control form-control-sm" value="<?= esc($profile['dob'] ?? '') ?>" data-original="<?= esc($profile['dob'] ?? '') ?>" readonly required>            
                </div>
                <div class="form-group">
                    <label>Gender</label>
                    <?php $gender = strtoupper(trim($profile['gender'] ?? '')); ?>
                    <select name="gender" class="form-control form-control-sm custom-select-sm" data-original="<?= esc($gender) ?>" disabled>
                        <option value="M" <?= in_array($gender, ['M', 'MALE']) ? 'selected' : '' ?>>Male</option>
                        <option value="F" <?= in_array($gender, ['F', 'FEMALE']) ? 'selected' : '' ?>>Female</option>
                        <option value="O" <?= in_array($gender, ['O', 'OTHER']) ? 'selected' : '' ?>>Other</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Marital Status</label>
                    <select name="marital_status" class="form-control form-control-sm custom-select-sm" data-original="<?= esc($profile['marital_status'] ?? '') ?>" disabled>
                        <option value="Single" <?= ($profile['marital_status'] ?? '') == 'Single' ? 'selected' : '' ?>>Single</option>
                        <option value="Married" <?= ($profile['marital_status'] ?? '') == 'Married' ? 'selected' : '' ?>>Married</option>
                    </select>
                </div>

                <div class="form-group">                
                    <label>Father Name</label>                
                    <input type="text" name="father_name" class="form-control form-control-sm" value="<?= esc($profile['father_name'] ?? '') ?>" data-original="<?= esc($profile['father_name'] ?? '') ?>" readonly>            
                </div>
                <div class="form-group">                
                    <label>Mother Name</label>                
                    <input type="text" name="mother_name" class="form-control form-control-sm" value="<?= esc($profile['mother_name'] ?? '') ?>" data-original="<?= esc($profile['mother_name'] ?? '') ?>" readonly>            
                </div>
                <div class="form-group">                
                    <label>PAN Number</label>                
                    <input type="text" name="pan" class="form-control form-control-sm" value="<?= esc($profile['pan'] ?? '') ?>" data-original="<?= esc($profile['pan'] ?? '') ?>" readonly>            
                </div>
                <div class="form-group">                
                    <label>Aadhaar Number</label>                
                    <input type="text" name="aadhaar" class="form-control form-control-sm" value="<?= esc($profile['aadhaar'] ?? '') ?>" data-original="<?= esc($profile['aadhaar'] ?? '') ?>" readonly>            
                </div>

                <div class="form-group">
                    <label>Aadhaar Card Document</label>
                    <div class="upload-container-wrapper">
                        <div class="compact-upload-box"
                             onclick="launchDocumentPreviewer('<?= base_url($documents['aadhaar'] ?? '') ?>','Aadhaar Card')">
                            <span>
                                <i class="fas fa-file-pdf text-danger mr-2"></i>
                                <?= basename($documents['aadhaar'] ?? 'No File') ?>
                            </span>
                        </div>
                        <div class="upload-action-btn"
                             data-key="aadhaar">
                            <i class="fas fa-sync"></i> Replace
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>PAN Card Document</label>
                    <div class="upload-container-wrapper">
                        <div class="compact-upload-box"
                             onclick="launchDocumentPreviewer('<?= base_url($documents['pan'] ?? '') ?>','PAN Card')">
                            <span>
                                <i class="fas fa-file-pdf text-danger mr-2"></i>
                                <?= basename($documents['pan'] ?? 'No File') ?>
                            </span>
                        </div>
                        <div class="upload-action-btn"
                             data-key="pan">
                            <i class="fas fa-sync"></i> Replace
                        </div>
                    </div>
                </div>
                
                <?php
                $current = json_decode($profile['current_address'] ?? '{}', true);
                $addressString = trim(implode(', ', array_filter([
                    $current['houseNo'] ?? '',
                    $current['area'] ?? '',
                    $current['streetNo'] ?? '',
                    $current['buildingName'] ?? '',
                    $current['street'] ?? ''
                ])));
                ?>

                <div class="form-group span-3">
                    <label>Full Current Address</label>
                    <textarea name="current_address" class="form-control form-control-sm" rows="2" data-original="<?= esc($addressString) ?>" readonly><?= $addressString ?></textarea>
                </div>

                <div class="form-group">
                    <label>City</label>
                    <input type="text" name="city" class="form-control form-control-sm" value="<?= esc($current['city'] ?? '') ?>" data-original="<?= esc($current['city'] ?? '') ?>" readonly>
                </div>

                <div class="form-group">
                    <label>State</label>
                    <input type="text" name="state" class="form-control form-control-sm" value="<?= esc($current['state'] ?? '') ?>" data-original="<?= esc($current['state'] ?? '') ?>" readonly>
                </div>

                <div class="form-group">
                    <label>Pincode</label>
                    <input type="text" name="pincode" class="form-control form-control-sm" value="<?= esc($current['pincode'] ?? '') ?>" data-original="<?= esc($current['pincode'] ?? '') ?>" readonly>
                </div>
            </div>
        </div>

        <!-- CARD BLOCK: BANKING SETTLEMENT COORDINATES -->
        <div class="main-card" id="section_banking">
            <div class="section-header-wrap">
                <h3 class="section-title"><i class="fas fa-university"></i> Bank Details</h3>
                <a class="edit-section-trigger" onclick="unlockSectionFields('section_banking')"><i class="fas fa-edit mr-1"></i> Edit Section</a>
            </div>

            <div class="grid-3">
                <div class="form-group">                
                    <label>Account Holder Name</label>                
                    <input type="text" name="bank_holder_name" class="form-control form-control-sm" value="<?= esc($profile['bank_holder_name'] ?? '') ?>" data-original="<?= esc($profile['bank_holder_name'] ?? '') ?>" readonly>            
                </div>
                <div class="form-group">                
                    <label>Bank Name</label>                
                    <input type="text" name="bank_name" class="form-control form-control-sm" value="<?= esc($profile['bank_name'] ?? '') ?>" data-original="<?= esc($profile['bank_name'] ?? '') ?>" readonly>            
                </div>
                <div class="form-group">                
                    <label>Account Number</label>                
                    <input type="password" name="bank_account_no" class="form-control form-control-sm"  value="<?= esc($profile['bank_account_no'] ?? '') ?>" data-original="<?= esc($profile['bank_account_no'] ?? '') ?>" readonly>            
                </div>
                <div class="form-group">                
                    <label>Confirm Account Number</label>                
                    <input type="text" class="form-control form-control-sm"  value="<?= esc($profile['bank_account_no'] ?? '') ?>" readonly>            
                </div>
                <div class="form-group">                
                    <label>IFSC Code</label>                
                    <input type="text" name="ifsc" class="form-control form-control-sm" value="<?= esc($profile['ifsc'] ?? '') ?>" data-original="<?= esc($profile['ifsc'] ?? '') ?>" readonly>            
                </div>
                <div class="form-group">                
                    <label>Branch Name</label>                
                    <input type="text" name="bank_branch" class="form-control form-control-sm" value="<?= esc($profile['bank_branch'] ?? '') ?>" data-original="<?= esc($profile['bank_branch'] ?? '') ?>" readonly>            
                </div>
                <div class="form-group">                
                    <label>UPI ID</label>                
                    <input type="text" name="upi_id" class="form-control form-control-sm" value="<?= esc($profile['upi_id'] ?? '') ?>" data-original="<?= esc($profile['upi_id'] ?? '') ?>" readonly>            
                </div>
                <div class="form-group">
                    <label>Account Type</label>
                    <?php $accType = strtoupper(trim($profile['bank_account_type'] ?? '')); ?>
                    <select name="bank_account_type" class="form-control form-control-sm custom-select-sm" data-original="<?= esc($accType) ?>" disabled>
                        <option value="SAVINGS" <?= in_array($accType, ['SAVINGS', 'SAVING']) ? 'selected' : '' ?>>Savings</option>
                        <option value="CURRENT" <?= $accType == 'CURRENT' ? 'selected' : '' ?>>Current</option>
                        <option value="SALARY" <?= $accType == 'SALARY' ? 'selected' : '' ?>>Salary</option>
                    </select>
                </div>
            </div>
        </div>
        
        <!-- CARD BLOCK: EDUCATION HISTORY PORTFOLIO PIPELINE -->
        <div class="main-card" id="section_education">
            <div class="section-header-wrap">
                <h3 class="section-title"><i class="fas fa-graduation-cap"></i> Education Details</h3>
                <a class="edit-section-trigger" onclick="unlockSectionFields('section_education')"><i class="fas fa-edit mr-1"></i> Edit Section</a>
            </div>

            <div class="grid-3">
                <!-- HIGHEST QUALIFICATION DETAILS -->
                <div class="form-group">            
                    <label>Degree Qualification</label>            
                    <select name="qualification" class="form-control form-control-sm custom-select-sm" data-original="<?= esc($graduation['qualification'] ?? '') ?>" disabled style="font-size: 13px !important;">
                        <?php if (!empty($graduation['qualification'])): ?>
                        <option value="<?= esc($graduation['qualification']) ?>">
                            <?= esc($graduation['qualification']) ?>
                        </option>
                    <?php else: ?>
                        <option value="">Select Qualification</option>
                    <?php endif; ?>
                        <option value="B.Tech / B.E" <?= ($graduation['qualification'] ?? '') == 'B.Tech / B.E' ? 'selected' : '' ?>>B.Tech / B.E</option>
                        <option value="B.Sc" <?= ($graduation['qualification'] ?? '') == 'B.Sc' ? 'selected' : '' ?>>B.Sc</option>
                        <option value="BCA" <?= ($graduation['qualification'] ?? '') == 'BCA' ? 'selected' : '' ?>>BCA</option>
                        <option value="MCA" <?= ($graduation['qualification'] ?? '') == 'MCA' ? 'selected' : '' ?>>MCA</option>
                        <option value="B.Com" <?= ($graduation['qualification'] ?? '') == 'B.Com' ? 'selected' : '' ?>>B.Com</option>
                    </select>        
                </div>
                <div class="form-group">            
                    <label>Specialization / Branch</label>            
                    <input type="text" name="specialization" class="form-control form-control-sm" value="<?= esc($graduation['specialization'] ?? '') ?>" data-original="<?= esc($graduation['specialization'] ?? '') ?>" readonly>        
                </div>
                <div class="form-group">            
                    <label>College / University Name</label>            
                    <input type="text" name="institution" class="form-control form-control-sm" value="<?= esc(($graduation['institution'] ?? '') . ' - ' . ($graduation['university'] ?? '')) ?>" data-original="<?= esc(($graduation['institution'] ?? '') . ' - ' . ($graduation['university'] ?? '')) ?>" readonly>        
                </div>
                
                <div class="form-group">            
                    <label>Passed Out Year</label>            
                    <input type="number" name="year_of_pass" class="form-control form-control-sm" value="<?= esc($graduation['year_of_pass'] ?? '') ?>" data-original="<?= esc($graduation['year_of_pass'] ?? '') ?>" readonly>        
                </div>
                
                <div class="form-group">            
                    <label>Percentage / CGPA</label>            
                    <input type="text" name="percentage" class="form-control form-control-sm" value="<?= esc($graduation['percentage'] ?? '') ?>%" data-original="<?= esc($graduation['percentage'] ?? '') ?>%" readonly>        
                </div>
                <div class="form-group">            
                    <label>Backlogs (If Any)</label>            
                    <select name="backlogs" class="form-control form-control-sm custom-select-sm" data-original="<?= esc($graduation['backlogs'] ?? '') ?>" disabled style="font-size: 13px !important;">
                        <option value="<?= esc($graduation['backlogs'] ?? '') ?>">
                            <?= esc($graduation['backlogs'] ?? 'Select Backlogs') ?>
                        </option>
                        <option>No Backlogs</option>
                        <option>1 Backlog</option>
                        <option>2 Backlogs</option>
                        <option>3+ Backlogs</option>
                    </select>        
                </div>

                <div class="form-group">
                    <label>Degree Certificate</label>
                    <div class="upload-container-wrapper">
                        <div class="compact-upload-box"
                             onclick="launchDocumentPreviewer('<?= base_url($documents['degree'] ?? '') ?>','Degree Certificate')">
                            <span>
                                <i class="fas fa-file-pdf text-danger mr-2"></i>
                                <?= basename($documents['degree'] ?? 'No File') ?>
                            </span>
                        </div>
                        <div class="upload-action-btn"
                             data-key="degree">
                            <i class="fas fa-sync"></i> Replace
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Provisional Certificate</label>
                    <div class="upload-container-wrapper">
                        <div class="compact-upload-box"
                             onclick="launchDocumentPreviewer('<?= base_url($documents['provisional'] ?? '') ?>','Provisional Certificate')">
                            <span>
                                <i class="fas fa-file-pdf text-danger mr-2"></i>
                                <?= basename($documents['provisional'] ?? 'No File') ?>
                            </span>
                        </div>
                        <div class="upload-action-btn"
                             data-key="provisional">
                            <i class="fas fa-sync"></i> Replace
                        </div>
                    </div>
                </div>

                <!-- INTERMEDIATE (12TH) SUBSECTION PROFILE LINK -->
                <div class="form-group span-3" style="margin: 15px 0 5px 0; border-top: 1px dashed #e2e8f0; padding-top: 15px;">
                    <h4 class="section-title" style="font-size: 13px;"><i class="fas fa-user-graduate text-muted"></i> Intermediate (12th) Details</h4>
                </div>

                <div class="form-group">    
                    <label>College Name</label>    
                    <input type="text" name="inter_institution" class="form-control form-control-sm" value="<?= esc($intermediate['institution'] ?? '') ?>" data-original="<?= esc($intermediate['institution'] ?? '') ?>" readonly>
                </div>
                <div class="form-group">    
                    <label>Course / Stream</label>    
                    <select name="inter_stream" class="form-control form-control-sm custom-select-sm" data-original="<?= esc($intermediate['stream'] ?? '') ?>" disabled style="font-size: 13px !important;">
                        <option value="<?= esc($intermediate['stream'] ?? '') ?>">
                            <?= esc($intermediate['stream'] ?? 'Select Stream') ?>
                        </option>
                        <option value="MPC" <?= ($intermediate['stream'] ?? '') == 'MPC' ? 'selected' : '' ?>>MPC</option>
                        <option value="BIPC" <?= ($intermediate['stream'] ?? '') == 'BIPC' ? 'selected' : '' ?>>BIPC</option>
                        <option value="CEC" <?= ($intermediate['stream'] ?? '') == 'CEC' ? 'selected' : '' ?>>CEC</option>
                        <option value="MEC" <?= ($intermediate['stream'] ?? '') == 'MEC' ? 'selected' : '' ?>>MEC</option>
                        <option value="HEC" <?= ($intermediate['stream'] ?? '') == 'HEC' ? 'selected' : '' ?>>HEC</option>
                        <option value="Vocational" <?= ($intermediate['stream'] ?? '') == 'Vocational' ? 'selected' : '' ?>>Vocational</option>
                        <option value="Other" <?= ($intermediate['stream'] ?? '') == 'Other' ? 'selected' : '' ?>>Other</option>
                    </select>
                </div>
                
                <div class="form-group">    
                    <label>Passed Out Year</label>    
                    <input type="number" name="inter_year_of_pass" class="form-control form-control-sm"  value="<?= esc($intermediate['year_of_pass'] ?? '') ?>" data-original="<?= esc($intermediate['year_of_pass'] ?? '') ?>" readonly>
                </div>
                <div class="form-group">    
                    <label>Percentage / GPA</label>    
                    <input type="text" name="inter_percentage" class="form-control form-control-sm" value="<?= esc($intermediate['percentage'] ?? '') ?>" data-original="<?= esc($intermediate['percentage'] ?? '') ?>" readonly>
                </div>
                <div class="form-group">
                    <label>Intermediate Certificate</label>
                    <div class="upload-container-wrapper">
                        <div class="compact-upload-box"
                             onclick="launchDocumentPreviewer('<?= base_url($documents['inter_certificate'] ?? '') ?>','Intermediate Certificate')">
                            <span>
                                <i class="fas fa-file-pdf text-danger mr-2"></i>
                                <?= basename($documents['inter_certificate'] ?? 'No File') ?>
                            </span>
                        </div>
                        <div class="upload-action-btn"
                             data-key="inter_certificate">
                            <i class="fas fa-sync"></i> Replace
                        </div>
                    </div>
                </div>

                <!-- 10TH (SSC) SUBSECTION PROFILE LINK -->
                <div class="form-group span-3" style="margin: 15px 0 5px 0; border-top: 1px dashed #e2e8f0; padding-top: 15px;">
                    <h4 class="section-title" style="font-size: 13px;"><i class="fas fa-school text-muted"></i> 10th (SSC) Details</h4>
                </div>

                <div class="form-group">    
                    <label>School Name</label>    
                    <input type="text" name="tenth_institution" class="form-control form-control-sm" value="<?= esc($tenth['institution'] ?? '') ?>" data-original="<?= esc($tenth['institution'] ?? '') ?>" readonly>
                </div>
                
                <div class="form-group">    
                    <label>Passed Out Year</label>    
                    <input type="number" name="tenth_year_of_pass" class="form-control form-control-sm" value="<?= esc($tenth['year_of_pass'] ?? '') ?>" data-original="<?= esc($tenth['year_of_pass'] ?? '') ?>" readonly>
                </div>
                <div class="form-group">    
                    <label>Percentage / GPA</label>    
                    <input type="text" name="tenth_percentage" class="form-control form-control-sm" value="<?= esc($tenth['percentage'] ?? '') ?>" data-original="<?= esc($tenth['percentage'] ?? '') ?>" readonly>
                </div>
                <div class="form-group">
                    <label>10th Certificate</label>
                    <div class="upload-container-wrapper">
                        <div class="compact-upload-box"
                             onclick="launchDocumentPreviewer('<?= base_url($documents['ssc'] ?? '') ?>','10th Certificate')">
                            <span>
                                <i class="fas fa-file-pdf text-danger mr-2"></i>
                                <?= basename($documents['ssc'] ?? 'No File') ?>
                            </span>
                        </div>
                        <div class="upload-action-btn"
                             data-key="ssc">
                            <i class="fas fa-sync"></i> Replace
                        </div>
                    </div>
                </div>
                
            </div>
        </div>

        <!-- CARD BLOCK: AUTOMATED WORK EXPERIENCE PORTFOLIO PIPELINE -->
        <?php
        $experience = json_decode($profile['experience'] ?? '[]', true);

        if (is_string($experience)) {
            $experience = json_decode($experience, true);
        }

        if (!is_array($experience) || empty($experience)) {
            $experience = [[
                'company_name' => 'N/A',
                'designation' => 'N/A',
                'employment_type' => 'N/A',
                'total_experience' => 'N/A',
                'start_date' => '',
                'end_date' => '',
                'skills' => 'N/A',
                'major_projects_delivered' => 'N/A',
                'core_job_responsibilities' => 'N/A'
            ]];
        }
        ?>

        <?php foreach ($experience as $index => $exp): ?>

        <div class="main-card" id="section_experience_<?= $index ?>">
            <div class="section-header-wrap">
                <h3 class="section-title">
                    <i class="fas fa-briefcase"></i>
                    Experience <?= $index + 1 ?>
                </h3>
                <a class="edit-section-trigger"
                   onclick="unlockSectionFields('section_experience_<?= $index ?>')">
                    <i class="fas fa-edit mr-1"></i> Edit Section
                </a>
            </div>

            <div class="grid-3">
                <div class="form-group">
                    <label>Company Name</label>
                    <input type="text" name="experience[<?= $index ?>][company_name]" class="form-control form-control-sm"
                        value="<?= esc($exp['company_name'] ?? 'N/A') ?>" data-original="<?= esc($exp['company_name'] ?? 'N/A') ?>" readonly>
                </div>

                <div class="form-group">
                    <label>Designation</label>
                    <input type="text" name="experience[<?= $index ?>][designation]" class="form-control form-control-sm"
                        value="<?= esc($exp['designation'] ?? 'N/A') ?>" data-original="<?= esc($exp['designation'] ?? 'N/A') ?>" readonly>
                </div>

                <div class="form-group">
                    <label>Employment Type</label>
                    <input type="text" name="experience[<?= $index ?>][employment_type]" class="form-control form-control-sm"
                        value="<?= esc($exp['employment_type'] ?? 'N/A') ?>" data-original="<?= esc($exp['employment_type'] ?? 'N/A') ?>" readonly>
                </div>

                <div class="form-group">
                    <label>Total Experience</label>
                    <input type="text" name="experience[<?= $index ?>][total_experience]" class="form-control form-control-sm"
                        value="<?= esc($exp['total_experience'] ?? 'N/A') ?>" data-original="<?= esc($exp['total_experience'] ?? 'N/A') ?>" readonly>
                </div>

                <div class="form-group">
                    <label>Start Date</label>
                    <input type="date" name="experience[<?= $index ?>][start_date]" class="form-control form-control-sm"
                        value="<?= esc($exp['start_date'] ?? '') ?>" data-original="<?= esc($exp['start_date'] ?? '') ?>" readonly>
                </div>

                <div class="form-group">
                    <label>End Date</label>
                    <input type="date" name="experience[<?= $index ?>][end_date]" class="form-control form-control-sm"
                        value="<?= esc($exp['end_date'] ?? '') ?>" data-original="<?= esc($exp['end_date'] ?? '') ?>" readonly>
                </div>

                <div class="form-group span-3">
                    <label>Skills</label>
                    <input type="text" name="experience[<?= $index ?>][skills]" class="form-control form-control-sm"
                        value="<?= esc($exp['skills'] ?? 'N/A') ?>" data-original="<?= esc($exp['skills'] ?? 'N/A') ?>" readonly>
                </div>

                <div class="form-group span-3">
                    <label>Project Experience</label>
                    <textarea name="experience[<?= $index ?>][major_projects_delivered]" class="form-control form-control-sm" rows="2" data-original="<?= esc($exp['major_projects_delivered'] ?? 'N/A') ?>" readonly><?= esc($exp['major_projects_delivered'] ?? 'N/A') ?></textarea>
                </div>

                <div class="form-group span-3">
                    <label>Job Responsibilities</label>
                    <textarea name="experience[<?= $index ?>][core_job_responsibilities]" class="form-control form-control-sm" rows="2" data-original="<?= esc($exp['core_job_responsibilities'] ?? 'N/A') ?>" readonly><?= esc($exp['core_job_responsibilities'] ?? 'N/A') ?></textarea>
                </div>
            </div>
        </div>

        <?php endforeach; ?>

        <!-- FORM COMMITTAL ACTION BUTTON LAYER -->
        <div style="margin-top: 30px; border-top: 1px solid #e2e8f0; padding-top: 20px; text-align: right;">
            <button type="submit" style="background: linear-gradient(135deg,#4a00e0,#7c3aed); color:#fff; border:none; padding:10px 30px; border-radius:10px; font-size:13px; font-weight:700; cursor:pointer; box-shadow:0 8px 20px rgba(74,0,224,0.2);">
                <i class="fas fa-save mr-2"></i>save & submit
            </button>
        </div>
        <input type="file" 
               id="docUploadInput"
               style="display:none;"
               accept=".pdf,.jpg,.jpeg,.png,.webp">
    </form>
</div>

                    <!-- RIGHT CONTAINER: SIDE DYNAMIC ATTACHMENT VIEWPORT DRAWER -->
                    <div class="preview-workspace-right" id="workspace_preview_drawer" style="width: 440px;">
                        <div class="document-preview-card">
                            <!-- HEADER WITH DYNAMIC ZOOM CONTROLS -->
                            <div class="preview-card-header" style="padding: 12px 16px; display: flex; justify-content: space-between; align-items: center;">
                                <h4 id="preview_title_filename" style="font-size: 13px; font-weight: 700; margin: 0;">document_preview.pdf</h4>
                                
                                <!-- Action Controls for Drawer Zooming -->
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <button type="button" class="btn btn-xs btn-outline-light" onclick="adjustPreviewZoom(0.2)" title="Zoom In">
                                        <i class="fas fa-search-plus"></i>
                                    </button>
                                    <button type="button" class="btn btn-xs btn-outline-light" onclick="adjustPreviewZoom(-0.2)" title="Zoom Out">
                                        <i class="fas fa-search-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-xs btn-outline-light" onclick="resetPreviewZoom()" title="Reset Zoom">
                                        <i class="fas fa-undo"></i>
                                    </button>
                                    <a href="javascript:void(0)" style="color: #94a3b8; font-size: 14px; margin-left: 6px;" onclick="dismissPreviewDrawer()">
                                        <i class="fas fa-times"></i>
                                    </a>
                                </div>
                            </div>

                            <!-- BODY CONTAINER WITH DYNAMIC IMAGE TARGET -->
                            <div class="preview-body-container" id="preview_viewport_container">
                                <iframe id="preview_iframe_target" src="" style="display: none; width: 100%; height: 100%; border: none; transform-origin: center center; transition: transform 0.15s ease-in-out;"></iframe>
                                <img id="preview_image_target" src="" alt="Document Preview" style="display: none; max-width: 100%; max-height: 100%; object-fit: contain; transform-origin: center center; transition: transform 0.15s ease-in-out;">
                                
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
</div>

<!-- System Script Frameworks -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

<script>
// Track individual scale factor for the preview drawer asset
let currentPreviewScale = 1;

function unlockSectionFields(sectionId) {
    const cardContext = document.getElementById(sectionId);
    if (!cardContext) return;
    
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
    return true;
}

// ==========================================
// DELTA UPDATE LOGIC INTERCEPTOR
// ==========================================
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('profileRegistrationForm');
    
    if (form) {
        form.addEventListener('submit', function(e) {
            // Locate all dynamically tracked fields
            const trackedElements = this.querySelectorAll('[data-original]');
            
            trackedElements.forEach(element => {
                const currentValue = element.value.trim();
                const originalValue = element.getAttribute('data-original').trim();
                
                // Compare current state against DB baseline state
                if (currentValue === originalValue) {
                    // Mute element so POST ignores it
                    element.disabled = true;
                } else {
                    // Failsafe: Ensure modified elements are passed successfully
                    element.disabled = false;
                    element.removeAttribute('readonly');
                }
            });
        });
    }
});

let selectedDocumentKey="";

document.querySelectorAll('.upload-action-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        selectedDocumentKey = this.dataset.key;
        document.getElementById('docUploadInput').click();
    });
});

document.getElementById('docUploadInput').addEventListener('change', function() {
    let file = this.files[0];
    if(!file) return;

    let formData = new FormData();
    formData.append("file", file);
    formData.append("key", selectedDocumentKey);
    formData.append("emp_id", "<?= $profile['emp_id'] ?>");

    fetch("<?= base_url('admin/update_document') ?>", {
        method:"POST",
        body:formData
    })
    .then(res => res.json())
    .then(data => {
        if(data.status == "success") {
            alert("Document replaced successfully");
            location.reload();
        } else {
            alert(data.message);
        }
    })
    .catch(err => {
        console.log(err);
        alert("Upload failed");
    });
});
</script>

</body>
</html>