
<?php
$address = json_decode($details['current_address'] ?? '[]', true);
if (!is_array($address)) {
    $address = [];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BloomHR | Application Review</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('public/dist/css/onboarding.css') ?>">
    <style>
        /* Application Page Styles */
        .application-document {
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 40px;
            margin-bottom: 30px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.02);
        }

        .app-header-area {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 2px solid var(--bloom-purple);
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .app-branding h2 {
            color: var(--bloom-purple);
            font-weight: 800;
            margin-bottom: 5px;
            font-size: 24px;
        }

        .app-branding p {
            color: var(--muted);
            font-size: 13px;
            margin: 0;
        }

        .app-photo {
            width: 120px;
            height: 150px;
            border: 2px dashed var(--border);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f8fafc;
            color: var(--muted);
            font-size: 12px;
            text-align: center;
            padding: 10px;
            overflow: hidden;
        }

        .app-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .app-section {
            margin-bottom: 30px;
        }

        .app-section-title {
            background: #f1f5f9;
            padding: 8px 15px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 700;
            color: var(--bloom-dark);
            margin-bottom: 15px;
        }

        .detail-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px 30px;
        }

        .detail-item {
            font-size: 13px;
            display: flex;
            flex-direction: column;
        }

        .detail-item .label {
            font-weight: 700;
            color: var(--text);
            margin-bottom: 4px;
        }

        .detail-item .value {
            color: var(--muted);
            border-bottom: 1px dotted var(--border);
            padding-bottom: 4px;
            min-height: 20px;
        }

        .full-width {
            grid-column: 1 / -1;
        }

        .download-actions {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-bottom: 30px;
        }

        .btn-download {
            background: #f8fafc;
            color: var(--bloom-purple);
            border: 1px solid var(--border);
            padding: 12px 20px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }

        .btn-download:hover {
            background: #eef2ff;
            border-color: var(--bloom-purple);
        }

        @media print {
            body * {
                visibility: hidden;
            }

            .application-document,
            .application-document * {
                visibility: visible;
            }

            .application-document {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                border: none;
                box-shadow: none;
            }
        }

    </style>
</head>

<body>

    <header class="app-header">
        <a href="#" class="brand-logo">
            <i class="fas fa-leaf"></i> BloomHR
        </a>
        
    </header>

    <div class="app-container">
        <aside class="app-sidebar">
            <ul class="stepper-nav" id="sidebar-list">
                <!-- Injected by onboarding.js -->
            </ul>
        </aside>

        <main class="app-main">
            <div class="content-wrapper">
                <h1 class="page-title">Final Review</h1>

                <!-- Draft Mode Editable Banner -->
                <div class="edit-badge-bar"
                    style="display: flex; align-items: center; gap: 8px; background: #eef2ff; color: #4338ca; border: 1px solid #c7d2fe; padding: 10px 16px; border-radius: 12px; margin-bottom: 25px; font-size: 13px; font-weight: 600;">
                    <i class="fas fa-pen-to-square"></i>
                    <span><strong>Draft Mode:</strong> You can modify your entries at any stage. Changes are allowed
                        until final submission.</span>
                </div>

                <div class="main-card" style="background: transparent; box-shadow: none; padding: 0;">

                    <div class="download-actions">
                        <button class="btn-download" onclick="window.print()">
                            <i class="fas fa-file-pdf"></i> Download Application
                        </button>
                        <!-- <a href="public/dist/img/Appointment Letter - 1 (1) - Copy.pdf" download class="btn-download">
                            <i class="fas fa-envelope-open-text"></i> Download Offer Letter
                        </a> -->
                    </div>

                    <!-- APPLICATION DOCUMENT -->
                    <div class="application-document">
                        <div class="app-header-area">
                            <div class="app-branding">
                                <h2>Bloom Solutions Pvt. Ltd.</h2>
                                <p>Employee Registration Form</p>
                                <p style="margin-top: 10px; font-weight: 600;">
                                        Reference ID:
                                        <span style="color: var(--bloom-purple);">
                                            <?= $details['ref_id'] ?? '' ?>
                                        </span>
                                    </p>
                                </div>
                <?php
                $docs = $details['documents'] ?? [];

                $photo = !empty($docs['profile_photo'])
                    ? base_url($docs['profile_photo'])
                    : base_url('public/dist/img/default-user.png');
                ?>

                <div class="app-photo">
                    <img src="<?= $photo ?>" alt="Profile Photo">
                </div>
                        </div>

                        <!-- PERSONAL -->
                        <div class="app-section">
                            <div class="app-section-title"
                                style="display: flex; justify-content: space-between; align-items: center;">
                                <span>1. Personal Information</span>
                                <a href="<?= base_url('on_boarding/personal_details') ?>" class="edit-section-btn"
                                    style="color: var(--bloom-purple); font-size: 12px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 4px; padding: 4px 8px; border-radius: 4px; background: rgba(74, 0, 224, 0.05); transition: 0.2s;">
                                    <i class="fas fa-edit"></i> Edit Details
                                </a>
                            </div>
                            <div class="detail-grid">
                                <div class="detail-item">
                                    <div class="label">Full Name</div>
                                    <div class="value" id="fullName">
                                        <?= $details['emp_name'] ?? 'Not Provided' ?>
                                    </div>
                                </div>
                                <div class="detail-item">
                                    <div class="label">Gender</div>
                                    <div class="value" id="gender">
                                         <?= $details['gender'] ?? 'Not Provided' ?>
                                    </div>
                                </div>
                                <div class="detail-item">
                                    <div class="label">Date of Birth</div>
                                    <div class="value" id="dob">
                                         <?= $details['dob'] ?? 'Not Provided' ?>
                                    </div>
                                </div>
                                <div class="detail-item">
                                    <div class="label">Mobile Number</div>
                                    <div class="value" id="mobile">
                                         <?= $details['mobile'] ?? 'Not Provided' ?>
                                    </div>
                                </div>
                                <div class="detail-item">
                                    <div class="label">Email Address</div>
                                    <div class="value" id="email">
                                          <?= $details['email'] ?? 'Not Provided' ?>
                                    </div>
                                </div>
                                <div class="detail-item full-width">
                                <div class="label">Address</div>
                                <div class="value">
                                <?php
                                $addressParts = array_filter([
                                    $address['houseNo'] ?? '',
                                    $address['area'] ?? '',
                                    $address['streetNo'] ?? '',
                                    $address['buildingName'] ?? '',
                                    $address['street'] ?? '',
                                    $address['city'] ?? '',
                                    $address['state'] ?? '',
                                ]);

                                if (!empty($addressParts)) {
                                    echo implode(', ', $addressParts);
                                    if (!empty($address['pincode'])) {
                                        echo ' - ' . $address['pincode'];
                                    }
                                } else {
                                    echo 'Not Provided';
                                }
                                ?>
                                </div>
                            </div>
                            </div>
                        </div>

                        <!-- BANK -->
                        <div class="app-section">
                            <div class="app-section-title"
                                style="display: flex; justify-content: space-between; align-items: center;">
                                <span>2. Salary Account Details</span>
                                <a href="<?= base_url('on_boarding/bank_details') ?>" class="edit-section-btn"
                                    style="color: var(--bloom-purple); font-size: 12px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 4px; padding: 4px 8px; border-radius: 4px; background: rgba(74, 0, 224, 0.05); transition: 0.2s;">
                                    <i class="fas fa-edit"></i> Edit Details
                                </a>
                            </div>
                            <div class="detail-grid">
                                <div class="detail-item">
                                    <div class="label">Account Holder Name</div>
                                    <div class="value" id="bankHolder">
                                        <?= $details['bank_holder_name'] ?? 'Not Provided' ?>
                                    </div>
                                </div>
                                <div class="detail-item">
                                    <div class="label">Bank Name</div>
                                    <div class="value" id="bankName">
                                        <?= $details['bank_name'] ?? 'Not Provided' ?>
                                    </div>
                                </div>
                                <div class="detail-item">
                                    <div class="label">Account Number</div>
                                    <div class="value" id="bankAcc">
                                        <?= $details['bank_account_no'] ?? 'Not Provided' ?>
                                    </div>
                                </div>
                                <div class="detail-item">
                                    <div class="label">IFSC Code</div>
                                    <div class="value" id="bankIfsc">
                                        <?= $details['ifsc'] ?? 'Not Provided' ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                    
<!-- EDUCATION -->
<div class="app-section">
    <div class="app-section-title"style="display: flex; justify-content: space-between; align-items: center;">
        <span>3. Education Profile</span>
        <a href="<?= base_url('on_boarding/education_details') ?>" class="edit-section-btn"
        style="color: var(--bloom-purple); font-size: 12px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 4px; padding: 4px 8px; border-radius: 4px; background: rgba(74, 0, 224, 0.05); transition: 0.2s;">
        <i class="fas fa-edit"></i> Edit Details
      </a>
    </div>

<?php
$qualifications = json_decode($details['qualification'] ?? '[]', true);

if (!is_array($qualifications)) {
    $qualifications = [];
}

$priority = ['Graduation', 'Intermediate', '10th'];

$basic = [];
$higher = [];

foreach ($qualifications as $q) {
    $type = $q['education_type'] ?? '';

    if (in_array($type, $priority)) {
        $basic[$type] = $q;
    } else {
        $higher[] = $q; // M.Tech, MBA etc.
    }
}
?>

<!-- 1. HIGHER EDUCATION FIRST -->
<?php if (!empty($higher)): ?>
    <div style="margin-bottom:15px; font-weight:700; color:var(--bloom-purple);">
        Higher Education
    </div>

    <?php foreach ($higher as $q): ?>
        <div class="detail-grid" style="margin-bottom:20px;">
            <div class="detail-item">
                <div class="label">Qualification</div>
                <div class="value"><?= $q['education_type'] ?? 'Not Provided' ?></div>
            </div>

            <div class="detail-item">
                <div class="label">Institution</div>
                <div class="value"><?= $q['institution'] ?? 'Not Provided' ?></div>
            </div>

            <div class="detail-item">
                <div class="label">Year</div>
                <div class="value"><?= $q['year_of_pass'] ?? 'Not Provided' ?></div>
            </div>

            <div class="detail-item">
                <div class="label">Percentage</div>
                <div class="value"><?= $q['percentage'] ?? 'Not Provided' ?></div>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<!-- 2. BASIC EDUCATION (Graduation → Inter → 10th) -->
<?php foreach ($priority as $type): ?>
    <?php if (!empty($basic[$type])): 
        $q = $basic[$type]; 
    ?>
        <div style="margin-bottom:20px;">
            <div style="font-weight:700; color:var(--bloom-purple); margin-bottom:8px;">
                <?= $type ?>
            </div>

            <div class="detail-grid">

                <div class="detail-item">
                    <div class="label">Institution</div>
                    <div class="value"><?= $q['institution'] ?? 'Not Provided' ?></div>
                </div>

                <?php if ($type == 'Graduation'): ?>
                    <div class="detail-item">
                        <div class="label">Qualification</div>
                        <div class="value"><?= $q['qualification'] ?? 'Not Provided' ?></div>
                    </div>

                    <div class="detail-item">
                        <div class="label">Specialization</div>
                        <div class="value"><?= $q['specialization'] ?? 'Not Provided' ?></div>
                    </div>
                <?php endif; ?>

                <?php if ($type == 'Intermediate'): ?>
                    <div class="detail-item">
                        <div class="label">Stream</div>
                        <div class="value"><?= $q['stream'] ?? 'Not Provided' ?></div>
                    </div>

                    <div class="detail-item">
                        <div class="label">Board</div>
                        <div class="value"><?= $q['board'] ?? 'Not Provided' ?></div>
                    </div>
                <?php endif; ?>

                <div class="detail-item">
                    <div class="label">Year</div>
                    <div class="value"><?= $q['year_of_pass'] ?? 'Not Provided' ?></div>
                </div>

                <div class="detail-item">
                    <div class="label">Percentage</div>
                    <div class="value"><?= $q['percentage'] ?? 'Not Provided' ?></div>
                </div>

            </div>
        </div>
    <?php endif; ?>
<?php endforeach; ?>

</div>


                        <!-- PROFESSIONAL -->
                         <?php
                        $experience = json_decode($details['experience'] ?? '[]', true);

                        if (is_string($experience)) {
                            $experience = json_decode($experience, true);
                        }

                        $isExperienced = false;

                        if (!empty($experience)) {
                            foreach ($experience as $exp) {
                                if (($exp['experience_type'] ?? '') === 'EXPERIENCED') {
                                    $isExperienced = true;
                                    break;
                                }
                            }
                        }
                        ?>
                 <?php if ($isExperienced): ?>
                        <div class="app-section">
                            <div class="app-section-title"
                                style="display: flex; justify-content: space-between; align-items: center;">
                                <span>4. Professional Experience</span>
                                <a href="<?= base_url('on_boarding/professional_details') ?>" class="edit-section-btn"
                                    style="color: var(--bloom-purple); font-size: 12px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 4px; padding: 4px 8px; border-radius: 4px; background: rgba(74, 0, 224, 0.05); transition: 0.2s;">
                                    <i class="fas fa-edit"></i> Edit Details
                                </a>
                            </div>
                           
<?php
$experience = json_decode($details['experience'] ?? '[]', true);

if (is_string($experience)) {
    $experience = json_decode($experience, true);
}

if (!is_array($experience)) {
    $experience = [];
}
?>

<div id="professionalDynamicContainer">

<?php if (!empty($experience)): ?>

    <?php foreach ($experience as $index => $exp): ?>

        <?php if (($exp['experience_type'] ?? '') == 'FRESHER'): ?>

            <h5 style="margin:20px 0 15px; color:var(--bloom-purple); font-size:16px; font-weight:700;">
                Experience <?= $index + 1 ?>
            </h5>
            <div class="detail-grid">

                <div class="detail-item">
                    <div class="label">Previous Company</div>
                    <div class="value">N/A</div>
                </div>

                <div class="detail-item">
                    <div class="label">Designation</div>
                    <div class="value">N/A</div>
                </div>

                <div class="detail-item full-width">
                    <div class="label">Key Skills</div>
                    <div class="value">N/A</div>
                </div>
            </div>

        <?php else: ?>

            <h5 style="margin:20px 0 15px; color:var(--bloom-purple); font-size:16px; font-weight:700;">
                Experience <?= $index + 1 ?>
            </h5>
            <div class="detail-grid">
               
                <div class="detail-item">
                    <div class="label">Company</div>
                    <div class="value"><?= $exp['company_name'] ?? 'Not Provided' ?></div>
                </div>

                <div class="detail-item">
                    <div class="label">Designation</div>
                    <div class="value"><?= $exp['designation'] ?? 'Not Provided' ?></div>
                </div>

                <div class="detail-item">
                <div class="label">Years of Experience</div>
                <div class="value"><?= $exp['total_experience'] ?? 'Not Provided' ?></div>
            </div>

                <div class="detail-item">
                    <div class="label">Skills</div>
                    <div class="value"><?= $exp['skills'] ?? 'Not Provided' ?></div>
                </div>
            </div>

        <?php endif; ?>

    <?php endforeach; ?>

<?php else: ?>

    <div style="color:var(--muted); font-size:13px;">
        No professional experience found.
    </div>
<?php endif; ?>

</div>
         <?php endif; ?>   
         
           <!-- UPLOADS REVIEW -->
<div class="app-section">

    <div class="app-section-title"
        style="display: flex; justify-content: space-between; align-items: center;">
        <span>5. Uploaded Digital Documents</span>
         <a href="<?= base_url('on_boarding/document_upload') ?>" class="edit-section-btn"
        style="color: var(--bloom-purple); font-size: 12px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 4px; padding: 4px 8px; border-radius: 4px; background: rgba(74, 0, 224, 0.05); transition: 0.2s;">
        <i class="fas fa-edit"></i> Edit Details
      </a>
    </div>

    <?php $docs = $details['documents'] ?? []; ?>

    <div class="detail-grid">

        <div class="detail-item">
            <div class="label">Profile Photo</div>
            <div class="value"
                style="color: <?= !empty($docs['profile_photo']) ? '#16a34a' : '#dc2626' ?>; font-weight:700;">
                <?= !empty($docs['profile_photo']) ? 'Uploaded' : 'Not Uploaded' ?>
            </div>
        </div>

        <div class="detail-item">
            <div class="label">Aadhaar Card</div>
            <div class="value"
             style="color: <?= !empty($docs['aadhaar']) ? '#16a34a' : '#dc2626' ?>; font-weight:700;">
                <?= !empty($docs['aadhaar']) ? 'Uploaded' : 'Not Uploaded' ?>
            </div>
        </div>

        <div class="detail-item">
            <div class="label">PAN Card</div>
            <div class="value"
             style="color: <?= !empty($docs['pan']) ? '#16a34a' : '#dc2626' ?>; font-weight:700;">
                <?= !empty($docs['pan']) ? 'Uploaded' : 'Not Uploaded' ?>
            </div>
        </div>

        <div class="detail-item">
            <div class="label">Bank Proof</div>
            <div class="value"
             style="color: <?= !empty($docs['bank_proof']) ? '#16a34a' : '#dc2626' ?>; font-weight:700;">
                <?= !empty($docs['bank_proof']) ? 'Uploaded' : 'Not Uploaded' ?>
            </div>
        </div>

        <div class="detail-item">
            <div class="label">Degree Certificate</div>
            <div class="value"
             style="color: <?= !empty($docs['degree']) ? '#16a34a' : '#dc2626' ?>; font-weight:700;">
                <?= !empty($docs['degree']) ? 'Uploaded' : 'Not Uploaded' ?>
            </div>
        </div>

        <div class="detail-item">
            <div class="label">Marks Memo</div>
            <div class="value"
            style="color: <?= !empty($docs['marks_memo']) ? '#16a34a' : '#dc2626' ?>; font-weight:700;">
                <?= !empty($docs['marks_memo']) ? 'Uploaded' : 'Not Uploaded' ?>
            </div>
        </div>

        <div class="detail-item">
            <div class="label">Provisional Certificate</div>
            <div class="value"
             style="color: <?= !empty($docs['provisional']) ? '#16a34a' : '#dc2626' ?>; font-weight:700;">
                <?= !empty($docs['provisional']) ? 'Uploaded' : 'Not Uploaded' ?>
            </div>
        </div>

        <div class="detail-item">
            <div class="label">12th Certificate</div>
            <div class="value"
             style="color: <?= !empty($docs['intermediate']) ? '#16a34a' : '#dc2626' ?>; font-weight:700;">
                <?= !empty($docs['intermediate']) ? 'Uploaded' : 'Not Uploaded' ?>
            </div>
        </div>

        <div class="detail-item">
            <div class="label">10th Certificate</div>
            <div class="value"
             style="color: <?= !empty($docs['ssc']) ? '#16a34a' : '#dc2626' ?>; font-weight:700;">
                <?= !empty($docs['ssc']) ? 'Uploaded' : 'Not Uploaded' ?>
            </div>
        </div>

        <div class="detail-item">
            <div class="label">Additional Certificates</div>
            <div class="value"
             style="color: <?= !empty($docs['additional']) ? '#16a34a' : '#dc2626' ?>; font-weight:700;">
                <?= !empty($docs['additional']) ? 'Uploaded' : 'Not Uploaded' ?>
            </div>
        </div>

        <div class="detail-item">
            <div class="label">Resume / CV</div>
            <div class="value"
             style="color: <?= !empty($docs['resume']) ? '#16a34a' : '#dc2626' ?>; font-weight:700;">
                <?= !empty($docs['resume']) ? 'Uploaded' : 'Not Uploaded' ?>
            </div>
        </div>

        <div class="detail-item">
            <div class="label">Experience Letter</div>
            <div class="value"
             style="color: <?= !empty($docs['relieving_letter']) ? '#16a34a' : '#dc2626' ?>; font-weight:700;">
                <?= !empty($docs['relieving_letter']) ? 'Uploaded' : 'Not Uploaded' ?>
            </div>
        </div>

    </div>
</div>
         </div>


                        <div style="margin-top: 40px; font-size: 12px; color: var(--muted); text-align: justify;">
                            <strong>Declaration:</strong> I hereby declare that the information provided above is true
                            and correct to the best of my knowledge and belief. I understand that any misrepresentation
                            or omission of facts may result in termination of my employment.
                        </div>

                        <!-- Declaration Checkbox -->
                        <div class="declaration-checkbox-container"
                            style="margin-top: 25px; background: #faf5ff; border: 1px dashed #d8b4fe; padding: 15px 20px; border-radius: 12px; display: flex; align-items: flex-start; gap: 12px;">
                            <input type="checkbox" id="declaration_check"
                                style="width: 18px; height: 18px; margin-top: 2px; cursor: pointer; accent-color: var(--bloom-purple);">
                            <label for="declaration_check"
                                style="font-size: 13px; font-weight: 600; color: #581c87; cursor: pointer; line-height: 1.5; user-select: none;">
                                I confirm that the details filled by me are legitimate, and if any changes are required,
                                I understand they will not be done after it is submitted. I have checked and verified
                                everything once again.
                            </label>
                        </div>

                        <div style="display: flex; justify-content: space-between; margin-top: 50px;">
                            <div
                                style="border-top: 1px solid var(--text); padding-top: 10px; width: 200px; text-align: center; font-size: 12px; font-weight: 700;">
                                Date & Place</div>
                            <div
                                style="border-top: 1px solid var(--text); padding-top: 10px; width: 200px; text-align: center; font-size: 12px; font-weight: 700;">
                                Signature of Applicant</div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="action-buttons"
                        style="background: #fff; padding: 25px; border-radius: 15px; box-shadow: 0 4px 6px rgba(0,0,0,0.02); display: flex; align-items: center; justify-content: space-between; gap: 15px; flex-wrap: wrap;">
                        <a href="<?= base_url('on_boarding/document_upload') ?>" class="btn btn-outline" id="backToEditBtn">
                    <i class="fas fa-arrow-left"></i> Back to Edit
                        </a>
                        <button class="btn btn-primary" id="finalSubmitBtn" disabled 
                            style="opacity: 0.5; cursor: not-allowed; transition: 0.3s;">
                            Final Submit Application <i class="fas fa-check-circle"></i>
                        </button>
                    </div>

                </div>
            </div>

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
        

        // Static academic loading
      const setText = (id, value) => {
    const el = document.getElementById(id);
    if (el) el.innerText = value || "Not Provided";
};

setText("interCollege", localStorage.getItem("interCollege"));
setText("interStream", localStorage.getItem("interStream"));
setText("interBoard", localStorage.getItem("interBoard"));
setText("interYear", localStorage.getItem("interYear"));
setText("interGpa", localStorage.getItem("interGpa"));


        // Load Document Upload review
        const docIds = [
            "doc_profile_photo", "doc_aadhaar", "doc_pan", "doc_bank_proof",
            "doc_degree", "doc_marks_memo", "doc_provisional", "doc_inter", "doc_ssc", "doc_additional",
            "doc_resume", "doc_experience_letter"
        ];
        docIds.forEach(id => {
            const valueElement = document.getElementById("rev_" + id.replace("doc_", ""));
            if (valueElement) {
                const fileName = localStorage.getItem(id);
                if (fileName) {
                    valueElement.innerHTML = `<span style="color:#047857; font-weight:700;"><i class="fas fa-check-circle"></i> ${fileName}</span>`;

     if (id === "doc_profile_photo") {
    const fileName = localStorage.getItem("doc_profile_photo");

    if (fileName) {
        const img = document.querySelector(".app-photo img");

        if (img) {
            img.src = "<?= base_url('uploads/profile/') ?>" + fileName;
            img.style.display = "block";
        }
    }
}
                } else {
                 if (id.includes("resume") || id.includes("experience_letter")) {
    valueElement.innerHTML = `<span style="color:var(--muted); font-weight:600;">Not Required</span>`;
}
                    valueElement.innerHTML = `<span style="color:#ef4444; font-weight:700;"><i class="fas fa-times-circle"></i> Not Uploaded</span>`;
                }
            }
        });

       document.addEventListener("DOMContentLoaded", function () {

    const declCheck = document.getElementById("declaration_check");
    const submitBtn = document.getElementById("finalSubmitBtn");

    if (declCheck && submitBtn) {

        const toggleBtn = () => {
            submitBtn.disabled = !declCheck.checked;
            submitBtn.style.opacity = declCheck.checked ? "1" : "0.5";
            submitBtn.style.cursor = declCheck.checked ? "pointer" : "not-allowed";
        };

        declCheck.addEventListener("change", toggleBtn);

        //  IMPORTANT: run once on page load
        toggleBtn();

        submitBtn.addEventListener("click", function (e) {
            if (this.disabled) return;
            triggerFinalSubmitPopup();
        });
    }

});
        // Modal popups for Final Confirmation
        function triggerFinalSubmitPopup() {
            const modal = document.getElementById("submitConfirmationModal");
            if (!modal) return;
            modal.style.display = "flex";
            setTimeout(() => {
                modal.style.opacity = "1";
                modal.firstElementChild.style.transform = "scale(1)";
            }, 10);
        }

        function closeFinalSubmitPopup() {
            const modal = document.getElementById("submitConfirmationModal");
            if (!modal) return;
            modal.style.opacity = "0";
            modal.firstElementChild.style.transform = "scale(0.9)";
            setTimeout(() => {
                modal.style.display = "none";
            }, 300);
        }

      function confirmAndExecuteSubmit() {
    localStorage.setItem("onboarding_submitted", "true");
    window.location.href = "<?= base_url('on_boarding/finalsubmit') ?>";
}
    </script>

    <!-- Final Submit Confirmation Modal -->
    <div id="submitConfirmationModal"
        style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.7); backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px); z-index: 9999; align-items: center; justify-content: center; opacity: 0; transition: opacity 0.3s ease;">
        <div
            style="background: rgba(255, 255, 255, 0.95); border: 1px solid rgba(255, 255, 255, 0.25); box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); width: 100%; max-width: 550px; border-radius: 20px; padding: 35px; text-align: center; margin: 20px; transform: scale(0.9); transition: transform 0.3s ease;">
            <div
                style="width: 70px; height: 70px; background: #fffbeb; border: 2px solid #fbbf24; border-radius: 50%; color: #d97706; display: inline-flex; align-items: center; justify-content: center; font-size: 32px; margin-bottom: 20px; box-shadow: 0 8px 20px rgba(217, 119, 6, 0.15);">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <h3
                style="font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 800; font-size: 22px; color: #1e293b; margin-bottom: 12px;">
                Confirm Final Submission</h3>
               <div style="margin: 0; padding: 0; text-align: left; font-size: 12px; line-height: 1.6; color: #475569;">

    <div style="margin-bottom: 8px;">
        Please read the following instructions carefully before proceeding:
    </div>

    <div style="color: hsl(21, 98%, 50%); font-weight: 600; text-align: center; margin: 8px 0 12px 0;">
        Please bring a printed copy of this application along with you to the office during your joining process.
    </div>

    <div style="margin-bottom: 6px;">
        • <strong>Declaration Verified:</strong> By submitting, you confirm that all details filled by you are 100% legitimate, authentic, and correct.
    </div>

    <div style="margin-bottom: 6px;">
        • <strong>No Further Edits Allowed:</strong> Once you submit, the form will be finalized and sent to HR.
        <strong>Any changes required will not be allowed under any circumstances.</strong>
    </div>

    <div>
        • <strong>Final Review:</strong> Please check all details (Personal, Bank, Education, Experience, and Uploads) once again to verify everything is correct.
    </div>

</div>
            <div style="display: flex; gap: 15px; justify-content: center; flex-wrap: wrap;">
                <button onclick="closeFinalSubmitPopup()"
                    style="background: #f1f5f9; color: #475569; border: 1px solid #cbd5e1; padding: 12px 24px; border-radius: 12px; font-weight: 700; font-size: 14px; cursor: pointer; transition: 0.2s; flex: 1; min-width: 140px;">
                    <i class="fas fa-times"></i> Check Again
                </button>
                <button onclick="confirmAndExecuteSubmit()"
    style="background: linear-gradient(135deg, var(--bloom-purple), #7c3aed); color: #fff; border: none; padding: 12px 24px; border-radius: 12px; font-weight: 700; font-size: 14px; cursor: pointer; transition: 0.2s; box-shadow: 0 8px 20px rgba(124, 58, 237, 0.25); flex: 1; min-width: 180px;">
    <i class="fas fa-check-circle"></i> Yes, Confirm & Submit
</button>
            </div>
        </div>
    </div>
</body>

</html>