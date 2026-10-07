<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>BloomHR | Thank You</title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="<?= base_url('public/dist/css/onboarding.css') ?>">
<style>
.thank-you-card {
    text-align: center;
    padding: 60px 40px;
    max-width: 600px;
    margin: 40px auto;
}

.success-icon {
    width: 100px;
    height: 100px;
    background: #ecfdf5;
    color: #10b981;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 50px;
    margin-bottom: 25px;
    box-shadow: 0 10px 25px rgba(16, 185, 129, 0.2);
}

.thank-you-title {
    font-size: 32px;
    font-weight: 800;
    color: var(--bloom-dark);
    margin-bottom: 15px;
}

.thank-you-message {
    color: var(--muted);
    font-size: 16px;
    line-height: 1.6;
    margin-bottom: 40px;
}

.btn-home {
    background: linear-gradient(135deg, var(--bloom-purple), #7c3aed);
    color: #fff;
    padding: 14px 30px;
    border-radius: 12px;
    font-weight: 700;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    box-shadow: 0 10px 20px rgba(74, 0, 224, 0.2);
    transition: 0.3s;
}

.btn-home:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 25px rgba(74, 0, 224, 0.3);
}

/* Hide sidebar for this page and center content */
.app-sidebar {
    display: none;
}
.app-main {
    margin-left: 0;
    justify-content: center;
    align-items: center;
}
.content-wrapper {
    max-width: 100%;
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
    <main class="app-main">
        <div class="content-wrapper">
            <div class="main-card thank-you-card">
                <div class="success-icon">
                    <i class="fas fa-check"></i>
                </div>
                <h1 class="thank-you-title">Registration Complete!</h1>
                <p class="thank-you-message">
                    Thank you for submitting your details. Your registration process has been successfully completed. 
                    Our HR team will review your application and contact you via email shortly with the next steps.
                </p>
               <footer class="app-footer" style="margin-top: 0;">
            &copy; 2026 Bloom Solutions. All rights reserved.
        </footer>
            </div>
           
        </div>

        
    </main>
</div>

<script>
    // Clear the tracking so they can't go back using the browser back button effectively
    localStorage.removeItem("onboarding_max_step");
</script>
</body>
</html>
