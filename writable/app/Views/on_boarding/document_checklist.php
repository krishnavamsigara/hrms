<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>BloomHR | Document Checklist</title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="<?= base_url('public/dist/css/onboarding.css') ?>">
</head>
<body>

<!-- Header -->
<header class="app-header">
    <a href="#" class="brand-logo">
        <i class="fas fa-leaf"></i> BloomHR
    </a>
    <div class="user-profile">
        <div class="avatar">U</div>
       <a href="<?= base_url('on_boarding/onboard_login') ?>" class="logout-btn">
    Logout
</a>
    </div>
</header>

<div class="app-container">
    <!-- Sidebar -->
    <aside class="app-sidebar">
        <ul class="stepper-nav" id="sidebar-list">
            <!-- Injected by onboarding.js -->
        </ul>
    </aside>

    <!-- Main Content -->
    <main class="app-main">
        <div class="content-wrapper">
            <h1 class="page-title">Welcome Aboard! 🎉</h1>

            <div class="main-card">
                <h3 class="section-title">
                    <i class="fas fa-list-check" style="color:var(--bloom-purple);"></i>
                    Pre-Registration Checklist
                </h3>
                <p style="color: var(--muted); margin-bottom: 25px; line-height: 1.6;">
                    Before you begin the onboarding process, please ensure you have the following documents ready in digital format. This will make your registration smooth and quick.
                </p>

                <ul class="doc-list" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px; margin-bottom: 25px;">
                    <!-- 1. Photo -->
                    <li class="doc-item" style="margin-bottom: 0;">
                        <div class="doc-icon"><i class="fas fa-image"></i></div>
                        <div class="doc-details">
                            <h4 style="font-size:14px;">Recent Passport Photo</h4>
                            <p style="font-size:11px;">Clear headshot with light background</p>
                            <span class="badge" style="background:#fef3c7; color:#d97706;">JPG / PNG (Max 50KB)</span>
                        </div>
                    </li>
                    <!-- 2. Aadhaar -->
                    <li class="doc-item" style="margin-bottom: 0;">
                        <div class="doc-icon"><i class="fas fa-id-card"></i></div>
                        <div class="doc-details">
                            <h4 style="font-size:14px;">Aadhaar Card Copy</h4>
                            <p style="font-size:11px;">Scanned front & back of original card</p>
                            <span class="badge" style="background:#fef3c7; color:#d97706;">PDF / JPG (Max 50KB)</span>
                        </div>
                    </li>
                    <!-- 3. PAN -->
                    <li class="doc-item" style="margin-bottom: 0;">
                        <div class="doc-icon"><i class="fas fa-address-card"></i></div>
                        <div class="doc-details">
                            <h4 style="font-size:14px;">PAN Card Copy</h4>
                            <p style="font-size:11px;">Scanned front of original PAN card</p>
                            <span class="badge" style="background:#fef3c7; color:#d97706;">PDF / JPG (Max 50KB)</span>
                        </div>
                    </li>
                    <!-- 4. Bank Proof -->
                    <li class="doc-item" style="margin-bottom: 0;">
                        <div class="doc-icon"><i class="fas fa-university"></i></div>
                        <div class="doc-details">
                            <h4 style="font-size:14px;">Bank Account Proof</h4>
                            <p style="font-size:11px;">Passbook front or Cancelled Cheque</p>
                            <span class="badge" style="background:#fef3c7; color:#d97706;">PDF / JPG (Max 50KB)</span>
                        </div>
                    </li>
                    <!-- 5. Highest Degree -->
                    <li class="doc-item" style="margin-bottom: 0;">
                        <div class="doc-icon"><i class="fas fa-graduation-cap"></i></div>
                        <div class="doc-details">
                            <h4 style="font-size:14px;">Highest Degree Certificate</h4>
                            <p style="font-size:11px;">Convocational degree copy</p>
                            <span class="badge" style="background:#fef3c7; color:#d97706;">PDF (Max 50KB)</span>
                        </div>
                    </li>
                    <!-- 6. Marks Memo -->
                    <li class="doc-item" style="margin-bottom: 0;">
                        <div class="doc-icon"><i class="fas fa-list-numeric"></i></div>
                        <div class="doc-details">
                            <h4 style="font-size:14px;">Academic Marks Memo</h4>
                            <p style="font-size:11px;">Consolidated degree transcripts</p>
                            <span class="badge" style="background:#fef3c7; color:#d97706;">PDF (Max 50KB)</span>
                        </div>
                    </li>
                    <!-- 7. Provisional -->
                    <li class="doc-item" style="margin-bottom: 0;">
                        <div class="doc-icon"><i class="fas fa-stamp"></i></div>
                        <div class="doc-details">
                            <h4 style="font-size:14px;">Provisional Certificate</h4>
                            <p style="font-size:11px;">Provisional passing certificate</p>
                            <span class="badge" style="background:#fef3c7; color:#d97706;">PDF (Max 50KB)</span>
                        </div>
                    </li>
                    <!-- 8. 12th -->
                    <li class="doc-item" style="margin-bottom: 0;">
                        <div class="doc-icon"><i class="fas fa-user-graduate"></i></div>
                        <div class="doc-details">
                            <h4 style="font-size:14px;">12th / Intermediate Certificate</h4>
                            <p style="font-size:11px;">12th class marksheet copy</p>
                            <span class="badge" style="background:#fef3c7; color:#d97706;">PDF (Max 50KB)</span>
                        </div>
                    </li>
                    <!-- 9. 10th -->
                    <li class="doc-item" style="margin-bottom: 0;">
                        <div class="doc-icon"><i class="fas fa-school"></i></div>
                        <div class="doc-details">
                            <h4 style="font-size:14px;">10th / SSC Certificate</h4>
                            <p style="font-size:11px;">Date of birth proof and SSC marksheet</p>
                            <span class="badge" style="background:#fef3c7; color:#d97706;">PDF (Max 50KB)</span>
                        </div>
                    </li>
                    <!-- 10. Resume -->
                    <li class="doc-item" style="margin-bottom: 0;">
                        <div class="doc-icon"><i class="fas fa-file-lines"></i></div>
                        <div class="doc-details">
                            <h4 style="font-size:14px;">Resume / CV</h4>
                            <p style="font-size:11px;">Latest updated curriculum vitae</p>
                            <span class="badge" style="background:#fef3c7; color:#d97706;">PDF / DOC (Max 50KB)</span>
                        </div>
                    </li>
                    <!-- 11. Experience Letter -->
                    <li class="doc-item" style="margin-bottom: 0;">
                        <div class="doc-icon"><i class="fas fa-receipt"></i></div>
                        <div class="doc-details">
                            <h4 style="font-size:14px;">Relieving / Experience Letter</h4>
                            <p style="font-size:11px;">From your last employer (if experienced)</p>
                            <span class="badge" style="background:#fef3c7; color:#d97706;">PDF (Max 50KB)</span>
                        </div>
                    </li>
                    <!-- 12. Additional Certifications -->
                    <li class="doc-item" style="margin-bottom: 0;">
                        <div class="doc-icon"><i class="fas fa-award"></i></div>
                        <div class="doc-details">
                            <h4 style="font-size:14px;">Additional Certifications</h4>
                            <p style="font-size:11px;">Course and internship proofs (optional)</p>
                            <span class="badge" style="background:#fef3c7; color:#d97706;">PDF / ZIP (Max 50KB)</span>
                        </div>
                    </li>
                </ul>

                <div class="action-buttons">
                     <a href="<?= base_url('on_boarding/view_appointment_letter') ?>" class="btn btn-outline">
                        <i class="fas fa-arrow-left"></i> Back
                    </a>
                    <button class="btn btn-primary" onclick="window.location.href='<?= base_url('on_boarding/personal_details') ?>'">
                        I'm Ready. Start Registration <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="app-footer">
            &copy; 2026 Bloom Solutions. All rights reserved.
        </footer>
    </main>
</div>
<script>
    const BASE_URL = "<?= base_url() ?>";
</script>
<script src="<?= base_url('public/dist/js/onboarding.js') ?>"></script>
</body>
</html>
