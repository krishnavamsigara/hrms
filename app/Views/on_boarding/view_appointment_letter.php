<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>BloomHR | Offer Letter</title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="<?= base_url('public/dist/css/onboarding.css') ?>">
<style>
  /* Local specific overrides if needed */
  .pdf-container {
    height: 600px; /* Set a fixed height since we are now in a scrolling main container */
    overflow: hidden;
    background: #eef2ff;
    position: relative;
    border: 1px solid var(--border);
    border-radius: 12px;
    margin-bottom: 20px;
  }

  .pdf-viewer {
    width: 100%;
    height: 100%;
    border: none;
  }

  .footer-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 20px;
    border-top: 1px solid var(--border);
    padding-top: 20px;
  }

  .checkbox-wrapper {
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 14px;
    font-weight: 600;
    color: #334155;
    cursor: pointer;
  }

  .checkbox-wrapper input {
    width: 20px;
    height: 20px;
    accent-color: #4a00e0;
    cursor: pointer;
  }

  .accept {
    pointer-events: none;
    opacity: 0.5;
  }

  .accept.enabled {
    pointer-events: auto;
    opacity: 1;
  }
  
  @media(max-width: 768px) {
    .footer-actions {
      flex-direction: column;
      gap: 20px;
    }
    .action-buttons {
      width: 100%;
      justify-content: center;
    }
  }
</style>
</head>
<body>

<?php if(session()->getFlashdata('message')): ?>
<script>
alert("<?= session()->getFlashdata('message') ?>");
</script>
<?php endif; ?>

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
            <h1 class="page-title">Appointment Letter</h1>

            <div class="main-card">
                <h3 class="section-title">
                    <i class="fas fa-file-contract"></i>
                    Review Your Offer
                </h3>
                
                <!-- PDF AREA -->
                <div class="pdf-container">
     <iframe
        class="pdf-viewer"
        src="<?= base_url('public/dist/img/Offer_Acceptance_Letter.pdf') ?>#toolbar=0&navpanes=0&scrollbar=0">
    </iframe>
                </div>

                <!-- FOOTER ACTIONS -->
                <div class="footer-actions">
                    <label class="checkbox-wrapper">
                    <input type="checkbox" id="agree">
                    I have read and agree to the terms & conditions
                    </label>

                  <div class="action-buttons" style="margin-top: 0; padding-top: 0; border: none;">

<?php if ($offer_status == 'accepted') { ?>

    <!-- ONLY NEXT BUTTON -->
    <a href="<?= base_url('on_boarding/document_checklist') ?>" class="btn btn-primary">
        Next <i class="fas fa-arrow-right"></i>
    </a>

<?php } else { ?>

    <!-- DECLINE -->
    <button type="button"
        class="btn btn-outline"
        style="color: #ef4444; border-color: #fca5a5;"
        onclick="document.getElementById('rejectPopup').style.display='flex'">

        <i class="fas fa-times"></i> Decline Offer
    </button>

    <!-- ACCEPT -->
    <form method="post" action="<?= base_url('on_boarding/accept_offer') ?>" style="display:inline;">
        <input type="hidden" name="refid" value="<?= session()->get('ref_id') ?>">

        <button type="submit"
            class="btn btn-primary accept"
            id="acceptBtn"
            disabled>
            Accept Offer <i class="fas fa-check"></i>
        </button>
    </form>

<?php } ?>

</div>
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
 const check = document.getElementById("agree");
const btn = document.getElementById("acceptBtn");

if (check && btn) {
    btn.disabled = true;

    check.addEventListener("change", () => {
        if (check.checked) {
            btn.disabled = false;
            btn.classList.add("enabled");
        } else {
            btn.disabled = true;
            btn.classList.remove("enabled");
        }
    });
}
  // Disable right click
  document.addEventListener("contextmenu", e => e.preventDefault());

  // Disable Ctrl+P / Ctrl+S
  document.addEventListener("keydown", function(e) {
    if ((e.ctrlKey && e.key === 'p') || (e.ctrlKey && e.key === 's')) {
      e.preventDefault();
    }
  });
</script>

<div id="rejectPopup"
style="
display:none;
position:fixed;
top:0;
left:0;
width:100%;
height:100%;
background:rgba(0,0,0,0.6);
z-index:9999;
justify-content:center;
align-items:center;
">

<div style="
background:#fff;
width:420px;
padding:30px;
border-radius:16px;
box-shadow:0 20px 40px rgba(0,0,0,0.3);
font-family:'Plus Jakarta Sans', sans-serif;
">

<h2 style="
margin-top:0;
margin-bottom:20px;
color:#120038;
font-size:24px;
font-weight:700;
text-align:center;
">
Decline Offer
</h2>

<form method="post" action="<?= base_url('on_boarding/reject_offer') ?>">

<input type="hidden"
name="refid"
value="<?= session()->get('ref_id') ?>">


<textarea
name="remarks"
placeholder="Enter reason for declining..."
required
style="
width:100%;
height:120px;
padding:15px;
border:1px solid #d1d5db;
border-radius:12px;
resize:none;
font-size:14px;
outline:none;
font-family:'Plus Jakarta Sans', sans-serif;
"></textarea>

<div style="
display:flex;
justify-content:flex-end;
gap:12px;
margin-top:20px;
">

<button
type="button"
onclick="document.getElementById('rejectPopup').style.display='none'"
style="
padding:10px 18px;
border:none;
border-radius:10px;
background:#e5e7eb;
cursor:pointer;
font-weight:600;
">
Cancel
</button>

<button
type="submit"
style="
padding:10px 18px;
border:none;
border-radius:10px;
background:#ef4444;
color:#fff;
cursor:pointer;
font-weight:600;
">
Submit
</button>

</div>

</form>

</div>
</div>
</body>
</html>