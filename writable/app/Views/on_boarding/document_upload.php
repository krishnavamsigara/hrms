<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>BloomHR | Document Upload</title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="<?= base_url('public/dist/css/onboarding.css') ?>">
<style>
.upload-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 25px;
    margin-bottom: 15px;
}

.doc-upload-card {
    background: #fff;
    border: 1px solid var(--border);
    border-radius: 16px;
    padding: 22px;
    display: flex;
    flex-direction: column;
    position: relative;
    transition: 0.3s;
    box-shadow: 0 4px 6px rgba(15, 23, 42, 0.01);
    min-height: 220px;
}
.doc-upload-card:hover {
    box-shadow: 0 10px 20px rgba(15, 23, 42, 0.04);
    border-color: #cbd5e1;
}

.doc-meta {
    display: flex;
    align-items: center;
    gap: 15px;
    margin-bottom: 15px;
}

.doc-icon-large {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    background: #f5f3ff;
    color: var(--bloom-purple);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    flex-shrink: 0;
}

.doc-info h4 {
    margin: 0 0 4px 0;
    font-size: 15px;
    font-weight: 700;
    color: var(--bloom-dark);
}

.doc-info p {
    margin: 0;
    font-size: 12px;
    color: var(--muted);
}

.doc-status {
    margin-top: auto;
    border-top: 1px solid var(--border);
    padding-top: 15px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 11px;
    font-weight: 700;
    padding: 4px 10px;
    border-radius: 20px;
}

.status-badge.pending {
    background: #fffbeb;
    color: #b45309;
}

.status-badge.completed {
    background: #ecfdf5;
    color: #047857;
}

.remove-btn {
    background: none;
    border: none;
    color: #ef4444;
    cursor: pointer;
    font-size: 12px;
    font-weight: 600;
    display: none;
    align-items: center;
    gap: 4px;
}

.remove-btn:hover {
    text-decoration: underline;
}

@media(max-width: 768px) {
    .upload-grid {
        grid-template-columns: 1fr;
    }
}

.doc-status {
    position: relative;
}

.remove-btn {
    position: absolute;
    right: 0;
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
            <h1 class="page-title">Document Upload</h1>

            <!-- Draft Mode Editable Banner -->
            <div class="edit-badge-bar" style="display: flex; align-items: center; gap: 8px; background: #eef2ff; color: #4338ca; border: 1px solid #c7d2fe; padding: 10px 16px; border-radius: 12px; margin-bottom: 25px; font-size: 13px; font-weight: 600;">
                <i class="fas fa-pen-to-square"></i>
                <span><strong>Draft Mode:</strong> You can modify your entries at any stage. Changes are allowed until final submission.</span>
            </div>

            <div class="main-card">
                <h3 class="section-title" style="margin-bottom: 10px;">
                    <i class="fas fa-file-shield" style="color:var(--bloom-purple);"></i>
                    Consolidated Digital Document Center
                </h3>
                <p style="color: var(--muted); margin-bottom: 35px; line-height: 1.6; font-size: 14px;">
                    Please upload your digital documents in high quality. Only PDF, JPG, and PNG formats are supported. Maximum size limit is 50KB per file.
                </p>

                <form id="uploadForm" method="post"action="<?= base_url('on_boarding/save_documents') ?>"enctype="multipart/form-data">
                    <!-- ============================================
                         SECTION 1: PERSONAL & BANK DOCUMENTS
                         ============================================ -->
                    <div class="upload-section" style="margin-bottom: 45px;">
                        <h3 class="section-title" style="color: var(--bloom-purple); border-bottom: 2px solid var(--border); padding-bottom: 12px; margin-bottom: 25px;">
                            <i class="fas fa-id-card"></i> 1. Personal Identity & Bank Documents
                        </h3>
                        <div class="upload-grid">
                            <!-- Profile Photo -->
                            <div class="doc-upload-card">
                                <div class="doc-meta">
                                    <div class="doc-icon-large"><i class="fas fa-camera"></i></div>
                                    <div class="doc-info">
                                        <h4>Profile Photo <span class="required">*</span></h4>

                             <p>Recent high-quality passport size headshot</p>
                                    </div>
                                </div>
                                <div class="upload-box" style="padding: 15px;">
                                    <i class="fas fa-image" style="font-size:22px;"></i>
                        <p style="font-size:12px;">
                            <?php if (!empty($details['documents']['profile_photo'])): ?>
                                Uploaded 
                            <?php else: ?>
                                Choose image (JPG/PNG, Max 50KB)
                            <?php endif; ?>
                        </p>            
                        <input type="file" name="doc_profile_photo" id="doc_profile_photo" accept="image/*" class="required-doc"
                      data-label="Profile Photo" onchange="handleFileUpload(this, 'Profile Photo')">
                                </div>
                                <div class="doc-status">

                        <span class="status-badge <?= !empty($details['documents']['profile_photo']) ? 'completed' : 'pending' ?>"
                            id="badge_doc_profile_photo">

                            <?php if (!empty($details['documents']['profile_photo'])): ?>
                                <i class="fas fa-circle-check"></i> Uploaded
                            <?php else: ?>
                                <i class="fas fa-clock"></i> Not Uploaded
                            <?php endif; ?>

                        </span>

                        <button type="button"
                            class="remove-btn"
                            id="remove_doc_profile_photo"
                            onclick="clearUpload('doc_profile_photo','profile_photo')"
                            style="<?= !empty($details['documents']['profile_photo']) ? 'display:inline-flex;' : 'display:none;' ?>">

                            <i class="fas fa-trash"></i> Remove
                        </button>

                    </div>
                            </div>

                            <!-- Aadhaar Card -->
                            <div class="doc-upload-card">
                                <div class="doc-meta">
                                    <div class="doc-icon-large"><i class="fas fa-id-card"></i></div>
                                    <div class="doc-info">
                                        <h4>Aadhaar Card <span class="required">*</span></h4>
                
                             <p>Front & back copy of your Aadhaar card</p>
                                    </div>
                                </div>
                                <div class="upload-box" style="padding: 15px;">
                                    <i class="fas fa-file-pdf" style="font-size:22px;"></i>
                                    <p style="font-size:12px;">
                                    <?php if (!empty($details['documents']['aadhaar'])): ?>
                                        Uploaded
                                    <?php else: ?>
                                        Choose PDF / Image (Max 50KB)
                                    <?php endif; ?>
                                </p>
                                    <input type="file"  name="doc_aadhaar" id="doc_aadhaar" accept=".pdf,image/*"class="required-doc" data-label="Aadhaar Card" onchange="handleFileUpload(this, 'Aadhaar Card')">
                                </div>
                                <div class="doc-status">

                        <span class="status-badge <?= !empty($details['documents']['aadhaar']) ? 'completed' : 'pending' ?>"
                            id="badge_doc_aadhaar">

                            <?php if (!empty($details['documents']['aadhaar'])): ?>
                                <i class="fas fa-circle-check"></i> Uploaded
                            <?php else: ?>
                                <i class="fas fa-clock"></i> Not Uploaded
                            <?php endif; ?>

                        </span>

                        <button type="button"
                            class="remove-btn"
                            id="remove_doc_aadhaar"
                            onclick="clearUpload('doc_aadhaar','aadhaar')"
                            style="<?= !empty($details['documents']['aadhaar']) ? 'display:inline-flex;' : 'display:none;' ?>">

                            <i class="fas fa-trash"></i> Remove
                        </button>

                    </div>
                            </div>

                            <!-- PAN Card -->
                            <div class="doc-upload-card">
                                <div class="doc-meta">
                                    <div class="doc-icon-large"><i class="fas fa-address-card"></i></div>
                                    <div class="doc-info">
                                        <h4>PAN Card <span class="required">*</span></h4>
                                                      
                                <p>Clear scan of your original PAN card</p>
                                    </div>
                                </div>
                                <div class="upload-box" style="padding: 15px;">
                                    <i class="fas fa-file-pdf" style="font-size:22px;"></i>
                                 <p style="font-size:12px;">
                            <?php if (!empty($details['documents']['pan'])): ?>
                                Uploaded
                            <?php else: ?>
                                Choose PDF / Image (Max 50KB)
                            <?php endif; ?>
                        </p>
                                    <input type="file" name="doc_pan" id="doc_pan" accept=".pdf,image/*" class="required-doc"
                               data-label="PAN Card" onchange="handleFileUpload(this, 'PAN Card')">
                                </div>
                                <div class="doc-status">

                    <span class="status-badge <?= !empty($details['documents']['pan']) ? 'completed' : 'pending' ?>"
                        id="badge_doc_pan">

                        <?php if (!empty($details['documents']['pan'])): ?>
                            <i class="fas fa-circle-check"></i> Uploaded
                        <?php else: ?>
                            <i class="fas fa-clock"></i> Not Uploaded
                        <?php endif; ?>

                    </span>

                    <button type="button"
                        class="remove-btn"
                        id="remove_doc_pan"
                        onclick="clearUpload('doc_pan','pan')"
                        style="<?= !empty($details['documents']['pan']) ? 'display:inline-flex;' : 'display:none;' ?>">

                        <i class="fas fa-trash"></i> Remove
                    </button>

                    </div>
                            </div>

                            <!-- Bank Passbook -->
                            <div class="doc-upload-card">
                                <div class="doc-meta">
                                    <div class="doc-icon-large"><i class="fas fa-university"></i></div>
                                    <div class="doc-info">
                                        <h4>Bank Proof <span class="required">*</span></h4>
                                        <p>Passbook front page or Cancelled Cheque</p>
                                    </div>
                                </div>
                                <div class="upload-box" style="padding: 15px;">
                                    <i class="fas fa-file-pdf" style="font-size:22px;"></i>
                                    <p style="font-size:12px;">
                                    <?php if (!empty($details['documents']['bank_proof'])): ?>
                                        Uploaded
                                    <?php else: ?>
                                        Choose PDF / Image (Max 50KB)
                                    <?php endif; ?>
                                </p>
                                    <input type="file" name="doc_bank_proof" id="doc_bank_proof" accept=".pdf,image/*" class="required-doc"
                            data-label="Bank Proof" onchange="handleFileUpload(this, 'Bank Proof')">
                                </div>
                               <div class="doc-status">

                            <span class="status-badge <?= !empty($details['documents']['bank_proof']) ? 'completed' : 'pending' ?>"
                                id="badge_doc_bank_proof">

                                <?php if (!empty($details['documents']['bank_proof'])): ?>
                                    <i class="fas fa-circle-check"></i> Uploaded
                                <?php else: ?>
                                    <i class="fas fa-clock"></i> Not Uploaded
                                <?php endif; ?>

                            </span>

                            <button type="button"
                                class="remove-btn"
                                id="remove_doc_bank_proof"
                                onclick="clearUpload('doc_bank_proof','bank_proof')"
                                style="<?= !empty($details['documents']['bank_proof']) ? 'display:inline-flex;' : 'display:none;' ?>">

                                <i class="fas fa-trash"></i> Remove
                            </button>

                        </div>
                            </div>
                        </div>
                    </div>

                    <!-- ============================================
                         SECTION 2: ACADEMIC CERTIFICATES
                         ============================================ -->
                    <div class="upload-section" style="margin-bottom: 45px;">
                        <h3 class="section-title" style="color: var(--bloom-purple); border-bottom: 2px solid var(--border); padding-bottom: 12px; margin-bottom: 25px;">
                            <i class="fas fa-graduation-cap"></i> 2. Academic Certificates
                        </h3>
                        <div class="upload-grid">
                            <!-- Degree Certificate -->
                            <div class="doc-upload-card">
                                <div class="doc-meta">
                                    <div class="doc-icon-large"><i class="fas fa-graduation-cap"></i></div>
                                    <div class="doc-info">
                                        <h4>Degree Certificate</h4>
                                        <p>Highest degree convocational / certificate</p>
                                    </div>
                                </div>
                                <div class="upload-box" style="padding: 15px;">
                                    <i class="fas fa-file-pdf" style="font-size:22px;"></i>
                                   <p style="font-size:12px;">
                                <?php if (!empty($details['documents']['degree'])): ?>
                                    Uploaded
                                <?php else: ?>
                                    Choose PDF / Image (Max 50KB)
                                <?php endif; ?>
                            </p>
                                    <input type="file" name="doc_degree" id="doc_degree" accept=".pdf" onchange="handleFileUpload(this, 'Degree Certificate')">
                                </div>
                                <div class="doc-status">

                            <span class="status-badge <?= !empty($details['documents']['degree']) ? 'completed' : 'pending' ?>"
                                id="badge_doc_degree">

                                <?php if (!empty($details['documents']['degree'])): ?>
                                    <i class="fas fa-circle-check"></i> Uploaded
                                <?php else: ?>
                                    <i class="fas fa-clock"></i> Not Uploaded
                                <?php endif; ?>

                            </span>

                            <button type="button"
                                class="remove-btn"
                                id="remove_doc_degree"
                                onclick="clearUpload('doc_degree','degree')"
                                style="<?= !empty($details['documents']['degree']) ? 'display:inline-flex;' : 'display:none;' ?>">

                                <i class="fas fa-trash"></i> Remove
                            </button>

                        </div>
                            </div>

                            <!-- Marks Memo -->
                            <div class="doc-upload-card">
                                <div class="doc-meta">
                                    <div class="doc-icon-large"><i class="fas fa-list-numeric"></i></div>
                                    <div class="doc-info">
                                        <h4>Marks Memo</h4>
                                        <p>Cumulative marksheet / consolidated memo</p>
                                    </div>
                                </div>
                                <div class="upload-box" style="padding: 15px;">
                                    <i class="fas fa-file-pdf" style="font-size:22px;"></i>
                                    <p style="font-size:12px;">
                                        <?php if (!empty($details['documents']['marks_memo'])): ?>
                                            Uploaded
                                        <?php else: ?>
                                            Choose PDF / Image (Max 50KB)
                                        <?php endif; ?>
                                    </p>
                                    <input type="file" name="doc_marks_memo" id="doc_marks_memo" accept=".pdf" onchange="handleFileUpload(this, 'Marks Memo')">
                                </div>
                 <div class="doc-status">

                  <span class="status-badge <?= !empty($details['documents']['marks_memo']) ? 'completed' : 'pending' ?>"
                    id="badge_doc_marks_memo">

                    <?php if (!empty($details['documents']['marks_memo'])): ?>
                        <i class="fas fa-circle-check"></i> Uploaded
                    <?php else: ?>
                        <i class="fas fa-clock"></i> Not Uploaded
                    <?php endif; ?>

                </span>

                <button type="button"
                    class="remove-btn"
                    id="remove_doc_marks_memo"
                    onclick="clearUpload('doc_marks_memo','marks_memo')"
                    style="<?= !empty($details['documents']['marks_memo']) ? 'display:inline-flex;' : 'display:none;' ?>">

                    <i class="fas fa-trash"></i> Remove
                </button>
                                            
                    </div>
                            </div>

                            <!-- Provisional -->
                            <div class="doc-upload-card">
                                <div class="doc-meta">
                                    <div class="doc-icon-large"><i class="fas fa-stamp"></i></div>
                                    <div class="doc-info">
                                        <h4>Provisional Certificate <span class="required">*</span></h4>
                
                                        <p>Provisional degree certificate</p>
                                    </div>
                                </div>
                                <div class="upload-box" style="padding: 15px;">
                                    <i class="fas fa-file-pdf" style="font-size:22px;"></i>
                                    <p style="font-size:12px;">
                            <?php if (!empty($details['documents']['provisional'])): ?>
                                Uploaded
                            <?php else: ?>
                                Choose PDF / Image (Max 50KB)
                            <?php endif; ?>
                        </p>
                                    <input type="file" name="doc_provisional" id="doc_provisional" accept=".pdf" class="required-doc"
                               data-label="Provisional Certificate" onchange="handleFileUpload(this, 'Provisional Certificate')">
                                </div>
                               <div class="doc-status">
                                <span class="status-badge <?= !empty($details['documents']['provisional']) ? 'completed' : 'pending' ?>"
                                    id="badge_doc_provisional">

                                    <?php if (!empty($details['documents']['provisional'])): ?>
                                        <i class="fas fa-circle-check"></i> Uploaded
                                    <?php else: ?>
                                        <i class="fas fa-clock"></i> Not Uploaded
                                    <?php endif; ?>

                                </span>

                                <button type="button"
                                    class="remove-btn"
                                    id="remove_doc_provisional"
                                    onclick="clearUpload('doc_provisional','provisional')"
                                    style="<?= !empty($details['documents']['provisional']) ? 'display:inline-flex;' : 'display:none;' ?>">

                                    <i class="fas fa-trash"></i> Remove
                                </button>

                            </div>
                            </div>

                            <!-- Intermediate (12th) -->
                            <div class="doc-upload-card">
                                <div class="doc-meta">
                                    <div class="doc-icon-large"><i class="fas fa-user-graduate"></i></div>
                                    <div class="doc-info">
                                        <h4>12th / Intermediate Certificate</h4>
                                       
                                        <p>High school standard marksheet / memo</p>
                                    </div>
                                </div>
                                <div class="upload-box" style="padding: 15px;">
                                    <i class="fas fa-file-pdf" style="font-size:22px;"></i>
                                    <p style="font-size:12px;">
                                <?php if (!empty($details['documents']['intermediate'])): ?>
                                    Uploaded
                                <?php else: ?>
                                    Choose PDF / Image (Max 50KB)
                                <?php endif; ?>
                                    </p>
                                    <input type="file" name="doc_inter" id="doc_inter" accept=".pdf" 
                                   data-label="Intermediate Certificate" onchange="handleFileUpload(this, 'Intermediate Certificate')">
                                </div>
                               <div class="doc-status">

                                <span class="status-badge <?= !empty($details['documents']['intermediate']) ? 'completed' : 'pending' ?>"
                                    id="badge_doc_inter">

                                    <?php if (!empty($details['documents']['intermediate'])): ?>
                                        <i class="fas fa-circle-check"></i> Uploaded
                                    <?php else: ?>
                                        <i class="fas fa-clock"></i> Not Uploaded
                                    <?php endif; ?>

                                </span>

                                <button type="button"
                                    class="remove-btn"
                                    id="remove_doc_inter"
                                    onclick="clearUpload('doc_inter','intermediate')"
                                    style="<?= !empty($details['documents']['intermediate']) ? 'display:inline-flex;' : 'display:none;' ?>">

                                    <i class="fas fa-trash"></i> Remove
                                </button>

                            </div>
                            </div>

                            <!-- 10th Certificate -->
                            <div class="doc-upload-card">
                                <div class="doc-meta">
                                    <div class="doc-icon-large"><i class="fas fa-school"></i></div>
                                    <div class="doc-info">
                                        <h4>10th / SSC Certificate <span class="required">*</span></h4>
                                       
                                        <p>Date of birth proof and 10th standard certificate</p>
                                    </div>
                                </div>
                                <div class="upload-box" style="padding: 15px;">
                                    <i class="fas fa-file-pdf" style="font-size:22px;"></i>
                                    <p style="font-size:12px;">
                                <?php if (!empty($details['documents']['ssc'])): ?>
                                    Uploaded
                                <?php else: ?>
                                    Choose PDF / Image (Max 50KB)
                                <?php endif; ?>
                            </p>
                                    <input type="file" name="doc_ssc" id="doc_ssc" accept=".pdf" class="required-doc"
                         data-label="10th Certificate" onchange="handleFileUpload(this, '10th Certificate')">
                                </div>
                               <div class="doc-status">

                                    <span class="status-badge <?= !empty($details['documents']['ssc']) ? 'completed' : 'pending' ?>"
                                        id="badge_doc_ssc">

                                        <?php if (!empty($details['documents']['ssc'])): ?>
                                            <i class="fas fa-circle-check"></i> Uploaded
                                        <?php else: ?>
                                            <i class="fas fa-clock"></i> Not Uploaded
                                        <?php endif; ?>

                                    </span>

                                    <button type="button"
                                        class="remove-btn"
                                        id="remove_doc_ssc"
                                        onclick="clearUpload('doc_ssc','ssc')"
                                        style="<?= !empty($details['documents']['ssc']) ? 'display:inline-flex;' : 'display:none;' ?>">

                                        <i class="fas fa-trash"></i> Remove
                                    </button>

                                </div>
                                </div>

                            <!-- Additional Certs -->
                            <div class="doc-upload-card">
                                <div class="doc-meta">
                                    <div class="doc-icon-large"><i class="fas fa-award"></i></div>
                                    <div class="doc-info">
                                        <h4>Additional Certifications</h4>
                                        <p>Internship proof, online courses (optional)</p>
                                    </div>
                                </div>
                                <div class="upload-box" style="padding: 15px;">
                                    <i class="fas fa-file-zipper" style="font-size:22px;"></i>
                                    <p style="font-size:12px;">
                                <?php if (!empty($details['documents']['additional'])): ?>
                                    Uploaded
                                <?php else: ?>
                                    Choose PDF / Image (Max 50KB)
                                <?php endif; ?>
                            </p>
                                    <input type="file"  name="doc_additional" id="doc_additional" accept=".pdf,.zip" onchange="handleFileUpload(this, 'Additional Certifications')">
                                </div>
                                <div class="doc-status">

                                    <span class="status-badge <?= !empty($details['documents']['additional']) ? 'completed' : 'pending' ?>"
                                        id="badge_doc_additional">

                                        <?php if (!empty($details['documents']['additional'])): ?>
                                            <i class="fas fa-circle-check"></i> Uploaded
                                        <?php else: ?>
                                            <i class="fas fa-clock"></i> Not Uploaded
                                        <?php endif; ?>

                                    </span>

                                    <button type="button"
                                        class="remove-btn"
                                        id="remove_doc_additional"
                                        onclick="clearUpload('doc_additional','additional')"
                                        style="<?= !empty($details['documents']['additional']) ? 'display:inline-flex;' : 'display:none;' ?>">

                                        <i class="fas fa-trash"></i> Remove
                                    </button>

                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ============================================
                         SECTION 3: PROFESSIONAL DOCUMENTS
                         ============================================ -->
                    <div class="upload-section" id="profUploadSection" style="margin-bottom: 45px;">
                        <h3 class="section-title" style="color: var(--bloom-purple); border-bottom: 2px solid var(--border); padding-bottom: 12px; margin-bottom: 25px;">
                            <i class="fas fa-briefcase"></i> 3. Professional Experience Documents
                        </h3>

                        <!-- Dynamically managed overlay notification for Freshers -->
                        <div id="fresherOverlay" class="na-overlay" style="display:none; position: static; background: #fafcff; border: 2px dashed #cbd5e1; padding: 40px; margin-bottom: 20px; align-items: center; justify-content: center; text-align: center; border-radius: 16px;">
                            <i class="fas fa-mug-hot" style="font-size: 42px; color: var(--bloom-purple); margin-bottom: 15px;"></i>
                            <h4 style="font-weight: 700; color: var(--bloom-dark); margin-bottom: 8px;">Not Required for Freshers</h4>
                            <p style="color: var(--muted); font-size: 13px; max-width: 500px; margin: 0 auto; line-height:1.5;">
                                You registered your employment status as <strong>Fresher</strong> in the previous step. Resume and Experience Certificates are not required. You can proceed directly!
                            </p>
                        </div>

                        <div class="upload-grid" id="profUploadGrid">
                            <!-- Resume -->
                            <div class="doc-upload-card">
                                <div class="doc-meta">
                                    <div class="doc-icon-large"><i class="fas fa-file-lines"></i></div>
                                    <div class="doc-info">
                                        <h4>Resume / CV <span class="required">*</span></h4>
                                        <p>Most recently updated curriculum vitae</p>
                                    </div>
                                </div>
                                <div class="upload-box" style="padding: 15px;">
                                    <i class="fas fa-file-pdf" style="font-size:22px;"></i>
                                    <!-- <p style="font-size:12px;">Choose PDF or DOC (Max 50KB)</p> -->
                                                  <p style="font-size:12px;">
                            <?php if (!empty($details['documents']['resume'])): ?>
                                Uploaded
                            <?php else: ?>
                                Choose PDF / Image (Max 50KB)
                            <?php endif; ?>
                        </p>
                                    <input type="file" name="doc_resume" id="doc_resume" accept=".pdf,image/*" class="required-doc"
                               data-label="Resume / CV" onchange="handleFileUpload(this, 'Resume / CV')">
                                </div>
                                <div class="doc-status">

                    <span class="status-badge <?= !empty($details['documents']['resume']) ? 'completed' : 'pending' ?>"
                        id="badge_doc_resume">
                        
                        <?php if (!empty($details['documents']['resume'])): ?>
                            <i class="fas fa-circle-check"></i> Uploaded
                        <?php else: ?>
                            <i class="fas fa-clock"></i> Not Uploaded
                        <?php endif; ?>

                    </span>

                    <button type="button"
                        class="remove-btn"
                        id="remove_doc_resume"
                        onclick="clearUpload('doc_resume','resume')"
                        style="<?= !empty($details['documents']['resume']) ? 'display:inline-flex;' : 'display:none;' ?>">

                        <i class="fas fa-trash"></i> Remove
                    </button>

                    </div>
                            </div>

                            <!-- Relieving Letter -->
                            <div class="doc-upload-card" id="relieving_letter_card">
                                <div class="doc-meta">
                                    <div class="doc-icon-large"><i class="fas fa-receipt"></i></div>
                                    <div class="doc-info">
                                        <h4>Experience / Relieving Letter <span class="required">*</span></h4>
                                        <p>From your most recent employer</p>
                                    </div>
                                </div>
                                <div class="upload-box" style="padding: 15px;">
                                    <i class="fas fa-file-pdf" style="font-size:22px;"></i>
                                    <!-- <p style="font-size:12px;">Choose PDF (Max 50KB)</p> -->
                                                                        <p style="font-size:12px;">
                            <?php if (!empty($details['documents']['relieving_letter'])): ?>
                                Uploaded
                            <?php else: ?>
                                Choose PDF / Image (Max 50KB)
                            <?php endif; ?>
                        </p>
                                    <input type="file" name="doc_relieving_letter" id="doc_relieving_letter" accept=".pdf" class="required-doc"
                               data-label="Experience / Relieving Letter" onchange="handleFileUpload(this, 'Experience / Relieving Letter')">
                                </div>
                               <div class="doc-status">
                                <span class="status-badge <?= !empty($details['documents']['relieving_letter']) ? 'completed' : 'pending' ?>"
                                    id="badge_doc_relieving_letter">
                           
                                    <?php if (!empty($details['documents']['relieving_letter'])): ?>
                                        <i class="fas fa-circle-check"></i> Uploaded
                                    <?php else: ?>
                                        <i class="fas fa-clock"></i> Not Uploaded
                                    <?php endif; ?>

                                </span>

                                <button type="button"
                                    class="remove-btn"
                                    id="remove_doc_relieving_letter"
                                    onclick="clearUpload('doc_relieving_letter','relieving_letter')"
                                    style="<?= !empty($details['documents']['relieving_letter']) ? 'display:inline-flex;' : 'display:none;' ?>">

                                    <i class="fas fa-trash"></i> Remove
                                </button>

                            </div>
                            </div>
                        </div>
                    </div>
             <div id="documentError"
     style="display:none;
            margin-bottom:20px;
            padding:12px 16px;
            border-radius:8px;
            background:#fef2f2;
            border:1px solid #fecaca;
            color:#dc2626;
            font-weight:600;">
</div>
                <div class="action-buttons">
                    <a href="<?= base_url('on_boarding/professional_details') ?>" class="btn btn-outline">
                        <i class="fas fa-arrow-left"></i> Back
                    </a>
           <button type="button" class="btn btn-primary" onclick="submitForm()">
                Complete & Next
                <i class="fas fa-arrow-right"></i>
            </button>
   </form>
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
// Handle Mock File Upload
function handleFileUpload(input, docName) {

    if (!input.files || !input.files[0]) return;

    const formData = new FormData();
    formData.append("file", input.files[0]);
    let keyMap = {
    doc_profile_photo: "profile_photo",
    doc_aadhaar: "aadhaar",
    doc_pan: "pan",
    doc_bank_proof: "bank_proof",
    doc_degree: "degree",
    doc_marks_memo: "marks_memo",
    doc_provisional: "provisional",
    doc_inter: "intermediate",
    doc_ssc: "ssc",
    doc_additional: "additional",
    doc_resume: "resume",
    doc_relieving_letter: "relieving_letter"
};

formData.append("key", keyMap[input.id]);

    fetch("<?= base_url('on_boarding/upload_single_document') ?>", {
        method: "POST",
        body: formData
    })
    .then(res => res.json())
    .then(res => {

        if (!res.success) {
            alert("Upload failed");
            return;
        }

        //  CLEAR VALIDATION ERROR IF EXISTS
input.style.border = "";
const errorBox = document.getElementById("err_" + input.id);
if (errorBox) {
    errorBox.innerText = "";
}

        const inputId = input.id;

        const badge = document.getElementById('badge_' + inputId);
        const removeBtn = document.getElementById('remove_' + inputId);

        if (badge) {
            badge.className = "status-badge completed";
            badge.innerHTML = `<i class="fas fa-circle-check"></i> Uploaded`;
        }

        if (removeBtn) {
            removeBtn.style.display = "inline-flex";
        }

        // SAFE: only update text, DO NOT touch HTML structure
const box = input.closest(".upload-box");

  if (box) {
        const p = box.querySelector("p");
        if (p) {
            const box = input.closest(".upload-box");

if (box) {
    const p = box.querySelector("p");
    if (p) {
        p.textContent = "Uploaded";
    }
}
        }
    }  })
    .catch(err => {
        console.error(err);
        alert("Upload error");
    });
}
// Check Fresher status and pre-populate already uploaded files from localStorage
document.addEventListener("DOMContentLoaded", () => {
    // 1. Handle Fresher Overlay
    
   if ((experienceType || "").toUpperCase() === "FRESHER") {
        document.getElementById("fresherOverlay").style.display = "flex";
        document.getElementById("profUploadGrid").style.display = "none";
    } else {
        document.getElementById("fresherOverlay").style.display = "none";
        document.getElementById("profUploadGrid").style.display = "grid";
    }


    // 2. Pre-populate uploaded files status from localStorage
    const fileInputs = ["doc_profile_photo", "doc_aadhaar", "doc_pan", "doc_bank_proof", "doc_degree", "doc_marks_memo", "doc_provisional", "doc_inter", "doc_ssc", "doc_additional", "doc_resume", "doc_experience_letter"];
    fileInputs.forEach(id => {
     // const fileName = localStorage.getItem(id);
        if (fileName) {
            const badge = document.getElementById('badge_' + id);
            const removeBtn = document.getElementById('remove_' + id);

            if (badge) {
                badge.className = "status-badge completed";
                badge.innerHTML = `<i class="fas fa-circle-check"></i> ${fileName.substring(0, 20)}${fileName.length > 20 ? '...' : ''}`;
            }
            if (removeBtn) {
                removeBtn.style.display = "inline-flex";
            }
        }
    });
});

const experienceType = "<?= !empty($details['experience']) 
    ? (json_decode($details['experience'], true)[0]['experience_type'] ?? '') 
    : '' ?>";

document.addEventListener("DOMContentLoaded", () => {

    if (experienceType.toUpperCase() === "FRESHER") {
        document.getElementById("fresherOverlay").style.display = "flex";
        document.getElementById("profUploadGrid").style.display = "none";
    } else {
        document.getElementById("fresherOverlay").style.display = "none";
        document.getElementById("profUploadGrid").style.display = "grid";
    }
const relievingCard = document.getElementById("relieving_letter_card");

if ((experienceType || "").toUpperCase() === "FRESHER") {
    if (relievingCard) relievingCard.style.display = "none";
}    

});
function clearUpload(inputId, key) {

    fetch("<?= base_url('on_boarding/delete_document') ?>", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: "key=" + key
    })
    .then(res => res.json())
    .then(res => {

    const input = document.getElementById(inputId);
const box = input ? input.closest(".upload-box") : null;

if (box) {
    const p = box.querySelector("p");
    if (p) {
        p.textContent = "Choose image (JPG/PNG, Max 50KB)";
    }
}

        console.log(res);

        //NO POPUP ANYMORE

        if (!res.success) {
            return; // silently stop
        }

        document.getElementById(inputId).value = "";

        document.getElementById("badge_" + inputId).innerHTML =
            `<i class="fas fa-clock"></i> Not Uploaded`;

        document.getElementById("remove_" + inputId).style.display = "none";
    });
}

// document.getElementById("uploadForm").addEventListener("submit", function(e) {

//     const profilePhoto = document.getElementById("doc_profile_photo").value;

//     if (!profilePhoto) {
//         e.preventDefault();
//         alert("Please upload Profile Photo to continue");
//         return false;
//     }

// });

function validateDocuments() {

    document.querySelectorAll("small[id^='err_']").forEach(el => {
        el.remove();
    });

    const fields = document.querySelectorAll(".required-doc");

    let isValid = true;

    fields.forEach(field => {

    console.log("Checking:", field.id);


        // Skip experience docs for freshers
        if (
            experienceType.toUpperCase() === "FRESHER" &&
            (field.id === "doc_resume" ||
             field.id === "doc_relieving_letter")
        ) {
            return;
        }

        const label = field.dataset.label;
        const errorId = "err_" + field.id;

        let errorBox = document.getElementById(errorId);

        if (!errorBox) {
            errorBox = document.createElement("small");
            errorBox.id = errorId;
            errorBox.style.color = "red";
            errorBox.style.display = "block";

            const card = field.closest(".doc-upload-card");
            const target = card.querySelector(".doc-status") || card;
            target.appendChild(errorBox);
        }

        const card = field.closest(".doc-upload-card");
        const badge = card.querySelector(".status-badge");

        const isUploaded = badge && badge.classList.contains("completed");

        if (!isUploaded) {

            isValid = false;
            field.style.border = "1px solid red";
            errorBox.innerText = label + " is required";

        } else {

            field.style.border = "";
            errorBox.innerText = "";
        }
    });

    return isValid;
}

function submitForm() {

    const errorBox = document.getElementById("documentError");

    if (!validateDocuments()) {

        errorBox.style.display = "block";
        errorBox.innerHTML = `<i class="fas fa-circle-exclamation"></i> Please upload all required documents.`;

        errorBox.scrollIntoView({
            behavior: "smooth",
            block: "center"
        });

        return;
    }

    errorBox.style.display = "none";
    document.getElementById("uploadForm").submit();
}
</script>
</body>
</html>
