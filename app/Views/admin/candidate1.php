
<?php
$current_address = json_decode($details['current_address'] ?? '{}', true);
$education = json_decode($details['qualification'] ?? '[]', true);
if (!is_array($education)) {
    $education = [];
}

$qualification = $education;
$highest = $education[0] ?? [];
$inter   = $education[1] ?? [];
$tenth   = $education[2] ?? [];
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
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Bloom Solution | Candidate Profile Form</title>

<!-- External CSS Libraries -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


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
/* Update your existing grid-3 class to include minmax constraints */
.grid-3 {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr)); /* Crucial fix: forces equal, bounded column widths */
    gap: 15px;
}

/* Force all form elements and flex containers to stay inside their grid items */
.form-group {
    margin-bottom: 0px;
    min-width: 0; /* Prevents text overflow mechanics from stretching grid panels */
}
.form-control-sm, 
.custom-select-sm, 
textarea.form-control-sm, 
.upload-container-wrapper {
  width: 100% !important;
  max-width: 100% !important;
  box-sizing: border-box !important;
}
/* Master Grid Layout for Split Form / File Preview */
.workspace-container {
    display: flex;
    gap: 20px;
    align-items: flex-start;
    transition: all 0.2s ease;
}

/* When preview is opened:
   Preview = LEFT
   Form/cards = RIGHT
*/
.workspace-container.preview-open {
    flex-direction: row-reverse;
}


.form-workspace-left {
    flex: 1;
    min-width: 0;
}



.preview-workspace-right.show {
    transform: translateX(0);
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

/* Compact, Symmetric Fields Grid */
.grid-3 {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 15px;
}

.form-group {
    margin-bottom: 0px;
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

/* Small Form Elements Styling - Standardized ReadOnly Visual States */
.form-control-sm, .custom-select-sm {
    border-radius: 8px !important;
    border: 1px solid #e2e8f0 !important;
    color: #1e293b !important;
    background-color: #f8fafc !important;
    font-weight: 500;
    height: 34px !important;
    padding: 6px 12px !important;
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
    pointer-events: none; /* Disabled globally until Edit context initialization */
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

.preview-body-container {
    height: 480px;
    background: #475569;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #94a3b8;
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
    font-size: 13px !important; /* <--- ADD THIS LINE */
    transition: all 0.2s ease;
    
}

/* Select2 - Bloom Theme */
.select2-container--default .select2-selection--single{
    height:34px !important;
    border:1px solid #ced4da !important;
    border-radius:8px !important;
    display:flex !important;
    align-items:center !important;
    padding:0 10px;
    transition:all .2s ease;
    color: #9ca3af !important;   /* Gray */
}

.select2-container--default .select2-selection--single:focus,
.select2-container--default.select2-container--focus .select2-selection--single{
    border-color:#7c3aed !important;
    box-shadow:0 0 0 0.2rem rgba(124,58,237,.18) !important;
}

.select2-container--default .select2-selection__rendered{
    line-height:36px !important;   /* Vertically center the text */
    font-size:15px !important;     /* Increase font size */
    /* font-weight:500 !important;    Optional */
    color:#495057 !important;
    padding-left:10px !important;
}

.select2-container--default .select2-selection__arrow{
    height:36px !important;
    right:8px !important;
}

.select2-dropdown{
    border:1px solid #7c3aed !important;
    border-radius:8px !important;
    overflow:hidden;
}

.select2-search--dropdown .select2-search__field{
    border:1px solid #7c3aed !important;
    border-radius:6px !important;
    outline:none !important;
}

.select2-search--dropdown .select2-search__field:focus{
    box-shadow:0 0 0 0.15rem rgba(124,58,237,.18);
}

.select2-results__option--highlighted.select2-results__option--selectable{
    background:#7c3aed !important;
    color:#fff !important;
}

/* Placeholder color */
.select2-container--default .select2-selection--single .select2-selection__placeholder{
    color: #9ca3af !important;   /* Gray */
    font-size: 14px !important;
}

/* =========================================================
   RESPONSIVE PROFILE REGISTRATION FORM
   ========================================================= */

/* Tablet */
@media (max-width: 991.98px) {

    .content-wrapper {
        margin-left: 0 !important;
    }

    .container-fluid {
        padding-left: 15px !important;
        padding-right: 15px !important;
    }

    .top-section {
        padding: 14px 16px;
    }

    .top-section h2 {
        font-size: 16px;
    }

    .profile-ref-tag {
        font-size: 12px;
        padding: 5px 10px;
    }

    .main-card {
        padding: 20px;
    }

    .grid-3 {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

    .form-group.span-3 {
        grid-column: span 2;
    }

    .preview-workspace-right {
        width: 400px !important;
    }
}


/* Mobile */
@media (max-width: 767.98px) {

    body {
        font-size: 13px;
        overflow-x: hidden;
    }

    .content-wrapper {
        margin-left: 0 !important;
        min-height: 100vh !important;
    }

    .content {
        padding-top: 15px !important;
    }

    .container-fluid {
        width: 100% !important;
        max-width: 100% !important;
        padding-left: 10px !important;
        padding-right: 10px !important;
    }

    /* Header */
    .top-section {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        gap: 12px;
        margin-bottom: 15px;
        padding: 14px;
        border-radius: 10px;
    }

    .header-left-side {
        width: 100%;
        gap: 10px;
    }

    .logo-box {
        width: 36px;
        height: 36px;
        min-width: 36px;
        font-size: 15px;
    }

    .top-section h2 {
        font-size: 15px;
        line-height: 1.3;
    }

    .profile-ref-tag {
        align-self: flex-start;
        font-size: 11px;
        padding: 5px 9px;
    }


    /* Cards */
    .main-card {
        padding: 15px;
        margin-bottom: 15px;
        border-radius: 10px;
    }


    /* Section header */
    .section-header-wrap {
        align-items: flex-start;
        gap: 10px;
        flex-wrap: wrap;
        margin-bottom: 15px;
    }

    .section-title {
        font-size: 14px;
    }

    .edit-section-trigger {
        font-size: 11px;
        padding: 4px 9px;
    }


    /* IMPORTANT:
       Convert 3-column layout to single column */
    .grid-3 {
        grid-template-columns: minmax(0, 1fr) !important;
        gap: 12px;
    }

    .form-group,
    .form-group.span-3 {
        grid-column: span 1 !important;
        min-width: 0;
        width: 100%;
    }


    /* Inputs */
    .form-control-sm,
    .custom-select-sm {
        width: 100% !important;
        max-width: 100% !important;
        font-size: 13px !important;
    }

    textarea.form-control-sm {
        min-height: 70px;
        resize: vertical;
    }


    /* Profile photo */
    .photo-center-row {
        margin-bottom: 15px;
        padding-bottom: 15px;
    }

    .photo-center-row .form-group {
        width: 100% !important;
        max-width: 100% !important;
    }


    /* Upload controls */
    .upload-container-wrapper {
        width: 100% !important;
        min-width: 0;
    }

    .compact-upload-box {
        min-width: 0;
        flex: 1;
    }

    .compact-upload-box span {
        max-width: 100%;
    }

    .upload-action-btn {
        flex-shrink: 0;
        padding: 0 9px;
        font-size: 11px;
    }


    /* Education subsection headings */
    .form-group.span-3[style*="border-top"] {
        margin-top: 10px !important;
        padding-top: 12px !important;
    }


    /* Workspace */
    .workspace-container {
        display: block;
        width: 100%;
    }

    .form-workspace-left {
        width: 100%;
        min-width: 0;
    }


    /* Preview drawer */
    .preview-workspace-right {
        width: 100% !important;
        max-width: 100% !important;
        right: 0;
    }

    .document-preview-card {
        width: 100%;
        height: 100vh;
        border-radius: 0;
    }

    .preview-body-container {
        height: calc(100vh - 55px) !important;
    }


    /* Bottom buttons */
    .form-workspace-left > div[style*="text-align: right"] {
        display: flex !important;
        flex-direction: column;
        gap: 10px;
        align-items: stretch !important;
    }

    .form-workspace-left > div[style*="text-align: right"] button {
        width: 100%;
        margin: 0 !important;
    }


    /* Organization modal */
    #organizationModal .modal-dialog {
        margin: 10px;
        max-width: none;
    }

    #organizationModal .modal-content {
        border-radius: 12px !important;
    }

    #organizationModal .modal-body {
        padding: 18px !important;
    }

    #organizationModal .grid-3 {
        grid-template-columns: 1fr !important;
    }

    #organizationModal .form-group {
        grid-column: span 1 !important;
    }

    #organizationModal .modal-footer {
        display: flex;
        flex-direction: column-reverse;
        gap: 8px;
    }

    #organizationModal .modal-footer button {
        width: 100%;
        margin: 0 !important;
    }


    /* Toast */
    #toastMessage {
        top: 10px !important;
        right: 10px !important;
        left: 10px !important;
        min-width: 0 !important;
        width: auto !important;
        font-size: 12px !important;
    }
}


/* Very small mobile screens */
@media (max-width: 400px) {

    .main-card {
        padding: 12px;
    }

    .top-section {
        padding: 12px;
    }

    .top-section h2 {
        font-size: 14px;
    }

    .section-title {
        font-size: 13px;
    }

    .form-control-sm,
    .custom-select-sm {
        font-size: 12px !important;
    }

    .upload-action-btn {
        padding: 0 7px;
        font-size: 10px;
    }

    .compact-upload-box span {
        font-size: 11px;
    }
}

/* =========================================================
   DOCUMENT PREVIEW DRAWER
   ========================================================= */

.preview-workspace-right {
    position: fixed;
    top: 0;
    right: 0;
    width: 440px;
    height: 100vh;
    background: #fff;
    z-index: 9999;

    transform: translateX(100%);
    transition: transform 0.3s ease;

    box-shadow: -10px 0 30px rgba(0,0,0,0.18);

    display: block;
    visibility: hidden;
}

.preview-workspace-right.show {
    transform: translateX(0);
    visibility: visible;
}

/* Maximized */
.preview-workspace-right.maximized {
    width: calc(100vw - 20px) !important;
    max-width: none !important;
}

/* Minimized */
.preview-workspace-right.minimized {
    width: 320px !important;
    height: 52px !important;
    top: auto;
    bottom: 15px;
    right: 15px;
    border-radius: 10px;
    overflow: hidden;
}

/* Preview card */
.document-preview-card {
    width: 100%;
    height: 100%;
    background: #fff;
    border-radius: 0;
    border: none;
    overflow: hidden;

    display: flex;
    flex-direction: column;
}

/* Header */
.preview-card-header {
    flex-shrink: 0;
    height: 56px;

    background: var(--bloom-dark);
    padding: 0 15px;

    color: #fff;

    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
}

.preview-header-title {
    display: flex;
    align-items: center;
    min-width: 0;
    flex: 1;
}

.preview-header-title i {
    margin-right: 8px;
    color: #94a3b8;
}

.preview-header-title h4 {
    font-size: 13px;
    font-weight: 700;
    margin: 0;

    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

/* Header buttons */
.preview-header-actions {
    display: flex;
    align-items: center;
    gap: 5px;
}

.preview-header-btn {
    width: 30px;
    height: 30px;

    border: none;
    background: transparent;

    color: #cbd5e1;

    border-radius: 6px;

    display: flex;
    align-items: center;
    justify-content: center;

    cursor: pointer;

    transition: 0.2s ease;
}

.preview-header-btn:hover {
    background: rgba(255,255,255,0.12);
    color: #fff;
}

/* Preview body */
.preview-body-container {
    flex: 1;

    min-height: 0;

    background: #334155;

    display: flex;
    align-items: center;
    justify-content: center;

    overflow: hidden;

    position: relative;
}

/* Images */
.preview-body-container img {
    max-width: 100%;
    max-height: 100%;

    object-fit: contain;

    display: block;
}

/* PDF */
.preview-body-container iframe {
    width: 100%;
    height: 100%;

    border: none;

    display: block;
}

/* Empty/error message */
.preview-empty-state {
    text-align: center;
    padding: 30px;
    color: #cbd5e1;
}

.preview-empty-state i {
    font-size: 42px;
    margin-bottom: 15px;
}

.preview-empty-state p {
    margin: 0;
    font-size: 13px;
}

/* When minimized, hide body */
.preview-workspace-right.minimized .preview-body-container {
    display: none;
}

/* Mobile */
@media (max-width: 767.98px) {

    .preview-workspace-right {
        width: 100% !important;
        max-width: 100% !important;
        right: 0;
    }

    .preview-workspace-right.maximized {
        width: 100% !important;
    }

    .preview-workspace-right.minimized {
        width: calc(100% - 20px) !important;
        height: 52px !important;
        right: 10px;
        bottom: 10px;
    }

    .preview-card-header {
        height: 54px;
        padding: 0 10px;
    }

    .preview-header-btn {
        width: 28px;
        height: 28px;
    }
}

.preview-header {
    height: 60px;
    background: #160044;
    color: #fff;

    display: flex;
    align-items: center;
    justify-content: space-between;

    padding: 0 18px;

    border-bottom: 1px solid rgba(255,255,255,.08);
}

.preview-file-info {
    display: flex;
    align-items: center;

    font-size: 13px;
    font-weight: 700;

    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;

    max-width: 70%;
}

.preview-controls {
    display: flex;
    align-items: center;
    gap: 4px;
}

.preview-control-btn {
    width: 34px;
    height: 34px;

    border: none;
    background: transparent;
    color: #fff;

    border-radius: 6px;

    display: flex;
    align-items: center;
    justify-content: center;

    cursor: pointer;

    font-size: 14px;

    transition: all .2s ease;
}

.preview-control-btn:hover {
    background: rgba(255,255,255,.12);
}

.preview-control-btn:active {
    transform: scale(.92);
}

.close-preview-btn:hover {
    background: #ef4444;
}


/*PREVIEW LATEST ONE */

/* =========================================================
   WORKSPACE - LEFT CARDS + RIGHT PREVIEW
   ========================================================= */

.workspace-container {
    display: flex !important;
    width: 100%;
    gap: 20px;
    align-items: flex-start;
    position: relative;
}

/* LEFT SIDE - ALL FORM CARDS */
.form-workspace-left {
    flex: 1 1 auto;
    min-width: 0;
    width: auto;
}


/* =========================================================
   RIGHT PREVIEW PANEL
   ========================================================= */

.preview-workspace-right {
    position: fixed !important;

    top: 70px !important;
    right: 20px !important;

    width: 440px !important;
    height: calc(100vh - 90px) !important;

    background: #fff;

    z-index: 9999;

    transform: translateX(calc(100% + 40px));

    visibility: hidden;

    transition:
        transform 0.3s ease,
        visibility 0.3s ease;

    box-shadow: -8px 0 25px rgba(0, 0, 0, 0.15);

    border-radius: 12px;

    overflow: hidden;
}


/* OPEN PREVIEW */

.preview-workspace-right.show {
    transform: translateX(0) !important;
    visibility: visible !important;
}


/* =========================================================
   PREVIEW CARD
   ========================================================= */

.document-preview-card {
    width: 100%;
    height: 100%;

    display: flex;
    flex-direction: column;

    background: #fff;
}


/* HEADER */

.preview-header {
    flex: 0 0 52px;

    display: flex;
    align-items: center;
    justify-content: space-between;

    padding: 0 14px;

    background: #fff;

    border-bottom: 1px solid #e2e8f0;
}


/* FILE NAME */

.preview-file-info {
    min-width: 0;

    display: flex;
    align-items: center;

    font-size: 13px;
    font-weight: 700;

    color: #334155;
}

#preview_title_filename {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}


/* CONTROLS */

.preview-controls {
    display: flex;
    align-items: center;
    gap: 4px;
}


/* BUTTON */

.preview-control-btn {
    width: 34px;
    height: 34px;

    display: flex;
    align-items: center;
    justify-content: center;

    border: none;
    background: transparent;

    color: #475569;

    border-radius: 7px;

    cursor: pointer;

    transition: all 0.2s ease;
}

.preview-control-btn:hover {
    background: #f1f5f9;
    color: #4a00e0;
}

.close-preview-btn:hover {
    background: #fee2e2;
    color: #dc2626;
}


/* =========================================================
   PREVIEW BODY
   ========================================================= */

.preview-body-container {
    flex: 1;

    width: 100%;
    height: 100%;

    overflow: auto;

    background: #f8fafc;

    position: relative;
}


/* EMPTY STATE */

.preview-empty-state {
    width: 100%;
    height: 100%;

    display: flex;
    flex-direction: column;

    align-items: center;
    justify-content: center;

    color: #94a3b8;
}

.preview-empty-state i {
    font-size: 40px;
    margin-bottom: 12px;
}

.preview-empty-state p {
    margin: 0;
    font-size: 13px;
    font-weight: 600;
}


/* =========================================================
   MAXIMIZED
   ========================================================= */

.preview-workspace-right.maximized {
    top: 20px !important;
    right: 20px !important;

    width: calc(100vw - 40px) !important;
    height: calc(100vh - 40px) !important;
}


/* =========================================================
   MINIMIZED
   ========================================================= */

.preview-workspace-right.minimized {
    width: 320px !important;
    height: 52px !important;

    top: auto !important;
    right: 20px !important;
    bottom: 20px !important;

    border-radius: 10px;

    overflow: hidden;
}

.preview-workspace-right.minimized .preview-body-container {
    display: none !important;
}


/* =========================================================
   MOBILE
   ========================================================= */

@media (max-width: 767.98px) {

    .workspace-container {
        display: block !important;
        width: 100%;
    }

    .form-workspace-left {
        width: 100% !important;
    }

    .preview-workspace-right {
        top: 0 !important;
        right: 0 !important;

        width: 100vw !important;
        height: 100vh !important;

        border-radius: 0;
    }

    .preview-workspace-right.maximized {
        top: 0 !important;
        right: 0 !important;

        width: 100vw !important;
        height: 100vh !important;
    }

    .preview-workspace-right.minimized {
        width: calc(100vw - 20px) !important;
        height: 52px !important;

        top: auto !important;
        right: 10px !important;
        bottom: 10px !important;

        border-radius: 10px;
    }
}
/* When preview is open, reserve space on the right */
.workspace-container:has(.preview-workspace-right.show) {
    padding-right: 460px;
}

.workspace-container:has(.preview-workspace-right.show) .form-workspace-left {
    width: calc(100% - 460px);
}
.preview-body-container {
    background: #000 !important;
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
                        <h2>Profile Registration Form</h2>    
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
                                    <a class="edit-section-trigger" onclick="unlockSectionFields('section_personal')"><i class="fas fa-edit mr-1"></i> Edit Section</a>
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
                                           <div class="upload-action-btn active-control"
                                            data-key="profile_photo">
                                            <i class="fas fa-cloud-upload-alt"></i> Upload
                                        </div>
                                        </div>
                                    </div>
                                </div> 
                                
                                <div class="grid-3">
                                    <div class="form-group">                
                                        <label>Full Name</label>                
                                        <input type="text" class="form-control form-control-sm" value="<?= $details['emp_name'] ?? '' ?>" readonly required>            
                                    </div>
                                    <div class="form-group">                
                                        <label>Mobile Number</label>                
                                        <input type="tel" class="form-control form-control-sm" value="<?= $details['mobile'] ?? '' ?>" readonly required>            
                                    </div>
                                    <div class="form-group">                
                                        <label>Email Address</label>                
                                        <input type="email" class="form-control form-control-sm" value="<?= $details['email'] ?? '' ?>" readonly required>            
                                    </div>
                                    <div class="form-group">                
                                        <label>Date of Birth</label>                
                                        <input type="date" class="form-control form-control-sm" value="<?= $details['dob'] ?? '' ?>" readonly required>            
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
                                        <input type="text" class="form-control form-control-sm" value="<?= $details['father_name'] ?? '' ?>" readonly>            
                                    </div>
                                    <div class="form-group">                
                                        <label>Mother Name</label>                
                                        <input type="text" class="form-control form-control-sm" value="<?= $details['mother_name'] ?? '' ?>" readonly>            
                                    </div>
                                    <div class="form-group">                
                                        <label>PAN Number</label>                
                                        <input type="text" class="form-control form-control-sm" value="<?= $details['pan'] ?? '' ?>" readonly>           
                                    </div>
                                    <div class="form-group">                
                                        <label>Aadhaar Number</label>                
                                        <input type="text" class="form-control form-control-sm" value="<?= $details['aadhaar'] ?? '' ?>" readonly>            
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

                                            <div class="upload-action-btn active-control"
                                            data-key="aadhaar">
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

                                           <div class="upload-action-btn active-control"
                                                data-key="pan">
                                            <i class="fas fa-sync"></i> Replace
                                            </div>

                                        </div>
                                      </div>

                                    <div class="form-group span-3">                
                                        <label>Full Permanent Address</label>                
                                        <textarea class="form-control form-control-sm" rows="2" readonly><?= ($current_address['houseNo'] ?? '') . ', ' . ($current_address['buildingName'] ?? '') . ', ' . ($current_address['streetNo'] ?? '') . ', ' . ($current_address['area'] ?? '') ?></textarea>            
                                    </div>
                                    <div class="form-group">                
                                        <label>City</label>                
                                        <input type="text" class="form-control form-control-sm" value="<?= $current_address['city'] ?? '' ?>" readonly>            
                                    </div>
                                    <div class="form-group">                
                                        <label>State</label>                
                                        <input type="text" class="form-control form-control-sm" value="<?= $current_address['state'] ?? '' ?>" readonly>            
                                    </div>
                                    <div class="form-group">                   
                                        <label>Pincode</label>                
                                        <input type="text" class="form-control form-control-sm" value="<?= $current_address['pincode'] ?? '' ?>" readonly>            
                                    </div>
                                </div>
                            </div>

                            <!-- CARD BLOCK: BANKING SETTLEMENT COORDINATES -->
                            <div class="main-card" id="section_banking">
                                <div class="section-header-wrap">
                                    <h3 class="section-title"><i class="fas fa-university"></i> Bank Details</h3>
                                    <?php if (($details['offer_status'] ?? '') == 'PENDING'): ?>
                                    <a class="edit-section-trigger" onclick="unlockSectionFields('section_banking')"><i class="fas fa-edit mr-1"></i> Edit Section</a>
                                    <?php endif; ?>
                                </div>

                                <div class="grid-3">
                                    <div class="form-group">                
                                        <label>Account Holder Name</label>                
                                        <input type="text" class="form-control form-control-sm" value="<?= $details['bank_holder_name'] ?? '' ?>" readonly>            
                                    </div>
                                    <div class="form-group">                
                                        <label>Bank Name</label>                
                                        <input type="text" class="form-control form-control-sm" value="<?= $details['bank_name'] ?? '' ?>"  readonly>            
                                    </div>
                                    <div class="form-group">
                                    <label>Account Number</label>

                                    <div style="position:relative;">
                                        <input type="password"
                                            id="accountNo"
                                            class="form-control form-control-sm"
                                            value="<?= $details['bank_account_no'] ?? '' ?>"
                                            readonly
                                            style="padding-right:40px;">
                                        <i id="accountEye"
                                        class="fas fa-eye"
                                        onclick="toggleAccountNo()"
                                        style="
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
                                        <input type="text" class="form-control form-control-sm" value="<?= $details['ifsc'] ?? '' ?>" readonly>            
                                    </div>
                                    <div class="form-group">                
                                        <label>Branch Name</label>                
                                        <input type="text" class="form-control form-control-sm" value="<?= $details['bank_branch'] ?? '' ?>" readonly>            
                                    </div>
                                    <div class="form-group">                
                                        <label>UPI ID</label>                
                                        <input type="text" class="form-control form-control-sm" value="<?= $details['upi_id'] ?? '' ?>" readonly>            
                                    </div>
                                    <div class="form-group">        
                                         <label>Account Type</label>                
                                         <input type="text" class="form-control form-control-sm"value="<?= $details['bank_account_type'] ?? '' ?>" readonly>            
                                    </div>
                                    <div class="form-group">                
                                        <label>Passbook / Cancelled Cheque</label>
                                        <div class="upload-container-wrapper">
                                            <div class="compact-upload-box" onclick="launchDocumentPreviewer('cheque.jpg', 'Image Resource Asset')">                    
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
                                    <h3 class="section-title"><i class="fas fa-graduation-cap"></i> Education Details</h3>
                                    <?php if (($details['offer_status'] ?? '') == 'PENDING'): ?>
                                    <a class="edit-section-trigger" onclick="unlockSectionFields('section_education')"><i class="fas fa-edit mr-1"></i> Edit Section</a>
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
                                            <input type="text"
                                                class="form-control form-control-sm"
                                                value="<?= $higher['education_type'] ?? '' ?>"
                                                readonly>
                                        </div>

                                        <div class="form-group">
                                            <label>College / University</label>
                                            <input type="text"
                                                class="form-control form-control-sm"
                                                value="<?= $higher['institution'] ?? '' ?>"
                                                readonly>
                                        </div>

                                        <div class="form-group">
                                            <label>Passed Out Year</label>
                                            <input type="text"
                                                class="form-control form-control-sm"
                                                value="<?= $higher['year_of_pass'] ?? '' ?>"
                                                readonly>
                                        </div>

                                        <div class="form-group">
                                            <label>Percentage</label>
                                            <input type="text"
                                                class="form-control form-control-sm"
                                                value="<?= $higher['percentage'] ?? '' ?>"
                                                readonly>
                                        </div>

                                        <div class="form-group">
                                            <label>Course Type</label>
                                            <input type="text"
                                                class="form-control form-control-sm"
                                                value="<?= $higher['courseType'] ?? '' ?>"
                                                readonly>
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
                                        <input type="text" class="form-control form-control-sm" value="<?= $highest['specialization'] ?? '' ?>" readonly>        
                                    </div>
                                    <div class="form-group">            
                                        <label>College / University Name</label>            
                                        <input type="text" class="form-control form-control-sm"  value="<?= $highest['institution'] ?? '' ?>" readonly>        
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
                                        <input type="number" class="form-control form-control-sm" value="<?= $highest['year_of_pass'] ?? '' ?>"  readonly>        
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
                                        <input type="text" class="form-control form-control-sm"  value="<?= $highest['percentage'] ?? '' ?>"  readonly>        
                                    </div>
                                   <div class="form-group">            
                                    <label>Backlogs (If Any)</label>            
                                    <select class="form-control form-control-sm custom-select-sm" disabled style="font-size: 13px !important;">
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

                                                <div class="upload-action-btn active-control"
                                                    data-key="degree">
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
                                       <div class="upload-action-btn active-control"
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
                                        <input type="text" class="form-control form-control-sm" value="<?= $inter['institution'] ?? '' ?>"  readonly>
                                    </div>
                                    <div class="form-group">    
                                        <label>Course / Stream</label>    
                                        <select class="form-control form-control-sm custom-select-sm" disabled>
                                        <option value="MPC" <?= ($inter['stream'] ?? '') == 'MPC (Maths, Physics, Chemistry)' ? 'selected' : '' ?>>MPC</option>
                                        <option value="BIPC" <?= ($inter['stream'] ?? '') == 'BIPC' ? 'selected' : '' ?>>BIPC</option>
                                        <option value="CEC" <?= ($inter['stream'] ?? '') == 'CEC' ? 'selected' : '' ?>>CEC</option>
                                        <option value="MEC" <?= ($inter['stream'] ?? '') == 'MEC' ? 'selected' : '' ?>>MEC</option>
                                    </select>
                                       </div>
                                    <div class="form-group">    
                                        <label>Board</label>    
                                       <select class="form-control form-control-sm custom-select-sm" disabled>
                                    <option value="Board of Intermediate Education"
                                        <?= ($inter['board'] ?? '') == 'Board of Intermediate Education' ? 'selected' : '' ?>>
                                        Board of Intermediate
                                    </option>
                                    <option value="CBSE" <?= ($inter['board'] ?? '') == 'CBSE' ? 'selected' : '' ?>>CBSE</option>
                                    <option value="ICSE" <?= ($inter['board'] ?? '') == 'ICSE' ? 'selected' : '' ?>>ICSE</option>
                                </select>
                                    </div>
                                    <div class="form-group">    
                                        <label>Passed Out Year</label>    
                                        <input type="number" class="form-control form-control-sm" value="<?= $inter['year_of_pass'] ?? '' ?>"  readonly>
                                    </div>
                                    <div class="form-group">    
                                        <label>Percentage</label>    
                                        <input type="text" class="form-control form-control-sm" value="<?= $inter['percentage'] ?? '' ?>" readonly>
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
                                        <div class="upload-action-btn active-control"
                                            data-key="intermediate">
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
                                        <input type="text" class="form-control form-control-sm" value="<?= $tenth['institution'] ?? '' ?>"  readonly>
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
                                        <input type="number" class="form-control form-control-sm"  value="<?= $tenth['year_of_pass'] ?? '' ?>"  readonly>
                                    </div>
                                    <div class="form-group">    
                                        <label>Percentage</label>    
                                        <input type="text" class="form-control form-control-sm" value="<?= $tenth['percentage'] ?? '' ?>" readonly>
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
                                               <div class="upload-action-btn active-control"
                                            data-key="ssc">
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
                                       <div class="upload-action-btn active-control"
                                                        data-key="marks_memo">
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
                                    <a class="edit-section-trigger" onclick="unlockSectionFields('section_experience')"><i class="fas fa-edit mr-1"></i> Edit Section</a>
                                    <?php endif; ?>
                                </div>

                                <div class="grid-3">
                                    <div class="form-group">            
                                        <label>Company Name</label>            
                                        <input type="text" class="form-control form-control-sm"  value="<?= esc($exp['company_name'] ?? '') ?>"readonly>        
                                    </div>
                                    <div class="form-group">            
                                        <label>Designation / Role</label>            
                                        <input type="text" class="form-control form-control-sm"  value="<?= esc($exp['designation'] ?? '') ?>" readonly>        
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
                              <input type="text" class="form-control form-control-sm"  value="<?= esc($exp['total_experience'] ?? '') ?>" readonly>
                                    </div>
                                    <div class="form-group">            
                                        <label>Start Date</label>            
                                        <input type="date" class="form-control form-control-sm" value="<?= esc($exp['start_date'] ?? '') ?>" readonly>        
                                    </div>
                                    <div class="form-group">            
                                        <label>End Date</label>            
                                        <input type="date" class="form-control form-control-sm" value="<?= esc($exp['end_date'] ?? '') ?>" readonly>        
                                    </div>
                                    <?php if ($index == 0): ?>
                                            <div class="form-group">            
                                                <label>Current CTC</label>            
                                                <input type="text" class="form-control form-control-sm"
                                                    value="<?= number_format((int)($exp['current_ctc'] ?? 0)) ?>" readonly>        
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
                                                   <div class="upload-action-btn active-control"
                                                            data-key="resume">
                                                            <i class="fas fa-sync"></i> Replace
                                                        </div>
                                                </div>
                                            </div>
                                    <div class="form-group span-3">            
                                        <label>Skills & Technologies</label>            
                                        <input type="text" class="form-control form-control-sm" value="<?= esc($exp['skills'] ?? '') ?>"  readonly>        
                                    </div>
                                    <div class="form-group span-3">            
                                        <label>Project Experience</label>            
                                        <textarea class="form-control form-control-sm" rows="2" readonly><?= esc($exp['major_projects_delivered'] ?? '') ?></textarea>        
                                    </div>
                                    <div class="form-group span-3">            
                                        <label>Job Responsibilities</label>            
                                       <textarea class="form-control form-control-sm" rows="2" readonly><?= esc($exp['core_job_responsibilities'] ?? '') ?></textarea>        
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
                                <button type="submit" style="background: linear-gradient(135deg,#4a00e0,#7c3aed); color:#fff; border:none; padding:10px 30px; border-radius:10px; font-size:13px; font-weight:700; cursor:pointer; box-shadow:0 8px 20px rgba(74,0,224,0.2);" data-toggle="modal"
                           data-target="#organizationModal">
                                    <i class="fas fa-save mr-2"></i>Save & Submit
                                </button>
                                <?php endif; ?>
                               
                            </div>

                
                            <!-- CARD BLOCK: ORGANIZATION DETAILS -->
                                 <!-- <div class="main-card" id="section_organization">
                                <div class="section-header-wrap">
                                <h3 class="section-title">
                                <i class="fas fa-sitemap"></i> Organization Details
                                </h3>
                                <a class="edit-section-trigger" onclick="unlockSectionFields('section_organization')">
                                <i class="fas fa-edit mr-1"></i> Edit Section
                                </a>
                                </div>
                                
                                    <div class="grid-3">
                                <div class="form-group">
                                    <label>Department</label>
                                    <select class="form-control form-control-sm" name="department">
                                        <option value="">Select Department</option>
                                        <option value="Software Development">Software Development</option>
                                        <option value="HR">HR</option>
                                        <option value="Finance">Finance</option>
                                        <option value="Marketing">Marketing</option>
                                        <option value="Operations">Operations</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Designation</label>
                                    <select class="form-control form-control-sm" name="designation">
                                        <option value="">Select Designation</option>
                                        <option value="Software Engineer">Software Engineer</option>
                                        <option value="Senior Software Engineer">Senior Software Engineer</option>
                                        <option value="Team Lead">Team Lead</option>
                                        <option value="Project Manager">Project Manager</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Reporting To</label>
                                    <select class="form-control form-control-sm" name="reporting_to">
                                        <option value="">Select Manager</option>
                                        <option value="Project Manager">Project Manager</option>
                                        <option value="Team Lead">Team Lead</option>
                                        <option value="Engineering Manager">Engineering Manager</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Joining Date</label>
                                    <input type="date" class="form-control form-control-sm" name="joining_date">
                                </div>

                            </div>
                                </div>

                                  <div style="margin-top: 30px; border-top: 1px solid #e2e8f0; padding-top: 20px; text-align: right;">
                                <button type="submit" style="background: linear-gradient(135deg,#4a00e0,#7c3aed); color:#fff; border:none; padding:10px 30px; border-radius:10px; font-size:13px; font-weight:700; cursor:pointer; box-shadow:0 8px 20px rgba(74,0,224,0.2);">
                                    <i class="fas fa-save mr-2"></i>Update details
                                </button> -->
                            </div>
                            <input type="file" id="docUploadInput" style="display:none;" accept=".pdf,.jpg,.png,.webp">
                        </form>
                    </div>

                    

                  <!-- RIGHT CONTAINER: SIDE DYNAMIC ATTACHMENT VIEWPORT DRAWER -->
             <!-- =========================================================
     DOCUMENT PREVIEW DRAWER
     ========================================================= -->

<div class="preview-workspace-right" id="workspace_preview_drawer">

    <div class="document-preview-card">

        <!-- HEADER -->
        <div class="preview-header">

    <div class="preview-file-info">
        <i class="fas fa-file-alt mr-2"></i>
        <span id="preview_title_filename">Document Preview</span>
    </div>

    <div class="preview-controls">

        <!-- Zoom Out -->
        <button type="button"
                class="preview-control-btn"
                onclick="zoomPreviewOut()"
                title="Zoom Out">
            <i class="fas fa-search-minus"></i>
        </button>

        <!-- Zoom In -->
        <button type="button"
                class="preview-control-btn"
                onclick="zoomPreviewIn()"
                title="Zoom In">
            <i class="fas fa-search-plus"></i>
        </button>

        <!-- Refresh -->
        <button type="button"
                class="preview-control-btn"
                onclick="refreshPreview()"
                title="Refresh">
            <i class="fas fa-sync-alt"></i>
        </button>

        <!-- Close -->
        <button type="button"
                class="preview-control-btn close-preview-btn"
                onclick="dismissPreviewDrawer()"
                title="Close">
            <i class="fas fa-times"></i>
        </button>

    </div>

</div>

        <!-- DOCUMENT BODY -->
        <div class="preview-body-container"
             id="preview_body_container">

            <div class="preview-empty-state">

                <i class="fas fa-file-alt"></i>

                <p>
                    Select a document to preview
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

                <button type="button"
                        class="close text-white"
                        data-dismiss="modal"
                        style="opacity:1;">
                    &times;
                </button>

            </div>

            <!-- Body -->
            <div class="modal-body" style="padding:25px;">

                <div class="grid-3">

                    <div class="form-group">
                        <label>Department</label>
                        <input type="text"
                               id="department"
                               class="form-control form-control-sm"
                               name="department"
                               placeholder="Enter Department">
                    </div>

                    <div class="form-group">
                        <label>Designation</label>
                        <input type="text"
                               id="designation"
                               class="form-control form-control-sm"
                               name="designation"
                               placeholder="Enter Designation">
                    </div>

                    <div class="form-group">
                        <label>Reporting To</label>

                        <select class="form-control form-control-sm"
                                id="reporting_to"
                                name="reporting_to">

                            <option value="">Select Manager</option>

                            <?php foreach($managers as $manager): ?>
                                <option value="<?= $manager['emp_id']; ?>">
                                    <?= $manager['emp_id']; ?>
                                </option>
                            <?php endforeach; ?>

                        </select>
                    </div>

                    <div class="form-group">
                        <label>Joining Date</label>

                        <input type="date"
                               id="joining_date"
                               class="form-control form-control-sm"
                               name="joining_date">
                    </div>

                </div>

            </div>

            <!-- Footer -->
            <div class="modal-footer"
                 style="border-top:1px solid #e2e8f0;padding:18px 25px;">

                <button type="button"
                        class="btn btn-light"
                        data-dismiss="modal">
                    Cancel
                </button>

                <button type="button"
                        onclick="saveOrganizationDetails()"
                        style="background:linear-gradient(135deg,#4a00e0,#7c3aed);
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

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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

/* =========================================================
   DOCUMENT PREVIEW
   ========================================================= */
let previewZoom = 1;
let currentPreviewUrl = '';
let currentPreviewMeta = '';
function launchDocumentPreviewer(fileUrl, documentMetaContext) {

    console.log("Preview clicked:", fileUrl);

    const drawer = document.getElementById('workspace_preview_drawer');

    currentPreviewUrl = fileUrl;
    currentPreviewMeta = documentMetaContext;

    // Reset zoom whenever a new document is opened
    previewZoom = 1;

    drawer.style.display = 'block';

    setTimeout(() => {
        drawer.classList.add('show');
    }, 10);

    document.getElementById('preview_title_filename').innerText =
        fileUrl.split('/').pop();

    const metaElement = document.getElementById('preview_context_meta');

    if (metaElement) {
        metaElement.innerText = documentMetaContext;
    }

    renderPreviewDocument();
}

function renderPreviewDocument() {

    const container = document.querySelector('.preview-body-container');

    if (!container || !currentPreviewUrl) {
        return;
    }

    container.innerHTML = "";

    const cleanUrl = currentPreviewUrl.split('?')[0];

    const extension = cleanUrl
        .split('.')
        .pop()
        .toLowerCase();

    if (['jpg', 'jpeg', 'png', 'webp', 'gif'].includes(extension)) {

        const img = document.createElement("img");

        img.src = cleanUrl + "?t=" + Date.now();

        img.style.maxWidth = "none";
        img.style.maxHeight = "none";

        img.style.width = (100 * previewZoom) + "%";

        img.style.height = "auto";

        img.style.borderRadius = "10px";

        img.style.display = "block";

        img.style.margin = "0 auto";

        img.style.transition = "width .2s ease";

        container.appendChild(img);

    }

    else if (extension === "pdf") {

        const iframe = document.createElement("iframe");

        iframe.src = cleanUrl + "?t=" + Date.now();

        iframe.style.width = (100 / previewZoom) + "%";
        iframe.style.height = (100 / previewZoom) + "%";

        iframe.style.border = "none";

        iframe.style.transform = "scale(" + previewZoom + ")";

        iframe.style.transformOrigin = "top left";

        container.appendChild(iframe);
    }

    else {

        container.innerHTML = `
            <div style="
                height:100%;
                display:flex;
                align-items:center;
                justify-content:center;
                color:#64748b;
                font-size:14px;
                font-weight:600;
            ">
                Preview not available for this file type.
            </div>
        `;
    }
}

function zoomPreviewIn() {

    if (!currentPreviewUrl) return;

    previewZoom += 0.1;

    if (previewZoom > 2) {
        previewZoom = 2;
    }

    renderPreviewDocument();
}

function zoomPreviewOut() {

    if (!currentPreviewUrl) return;

    previewZoom -= 0.1;

    if (previewZoom < 0.5) {
        previewZoom = 0.5;
    }

    renderPreviewDocument();
}

function refreshPreview() {

    if (!currentPreviewUrl) return;

    renderPreviewDocument();
}
/* =========================================================
   CLOSE PREVIEW
   ========================================================= */

function dismissPreviewDrawer() {

    const drawer =
        document.getElementById('workspace_preview_drawer');

    if (!drawer) {
        return;
    }

    drawer.classList.remove('show');
    drawer.classList.remove('minimized');
    drawer.classList.remove('maximized');

    updatePreviewMaximizeIcon();
}

/* =========================================================
   MINIMIZE PREVIEW
   ========================================================= */

function minimizePreviewDrawer() {

    const drawer =
        document.getElementById('workspace_preview_drawer');

    if (!drawer) {
        return;
    }

    drawer.classList.remove('maximized');

    drawer.classList.add('minimized');

    updatePreviewMaximizeIcon();
}


/* =========================================================
   MAXIMIZE / RESTORE PREVIEW
   ========================================================= */

function maximizePreviewDrawer() {

    const drawer =
        document.getElementById('workspace_preview_drawer');

    if (!drawer) {
        return;
    }


    /*
     * If currently minimized,
     * restore it first.
     */
    if (drawer.classList.contains('minimized')) {

        drawer.classList.remove('minimized');

        drawer.classList.add('show');

        updatePreviewMaximizeIcon();

        return;
    }


    /*
     * Toggle maximize.
     */
    if (drawer.classList.contains('maximized')) {

        drawer.classList.remove('maximized');

    } else {

        drawer.classList.add('maximized');

    }

    updatePreviewMaximizeIcon();
}


/* =========================================================
   UPDATE MAXIMIZE ICON
   ========================================================= */

function updatePreviewMaximizeIcon() {

    const drawer =
        document.getElementById('workspace_preview_drawer');

    const button =
        document.getElementById('previewMaximizeBtn');

    if (!drawer || !button) {
        return;
    }

    const icon =
        button.querySelector('i');

    if (!icon) {
        return;
    }


    if (drawer.classList.contains('maximized')) {

        icon.classList.remove('fa-expand');

        icon.classList.add('fa-compress');

        button.title = 'Restore';

    } else {

        icon.classList.remove('fa-compress');

        icon.classList.add('fa-expand');

        button.title = 'Maximize';

    }
}

function triggerFormSubmission(event) {
    event.preventDefault();
    alert("Profile configurations updated and committed successfully!");
}

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
        },300);

    },3000);
}

function saveOrganizationDetails()
{
    let department   = document.getElementById('department');
    let designation  = document.getElementById('designation');
    let reporting_to = document.getElementById('reporting_to');
    let joining_date = document.getElementById('joining_date');

    // Remove old error borders
    [department, designation, reporting_to, joining_date].forEach(function(el){
        el.style.border = "";
    });

    let hasError = false;

    if (department.value.trim() == "") {
        department.style.border = "1px solid red";
        hasError = true;
    }

    if (designation.value.trim() == "") {
        designation.style.border = "1px solid red";
        hasError = true;
    }

    if (reporting_to.value == "") {
        reporting_to.style.border = "1px solid red";
        hasError = true;
    }

    if (joining_date.value == "") {
        joining_date.style.border = "1px solid red";
        hasError = true;
    }

    if (hasError) {
        showToast("Please fill all required fields.", "error");
        return;
    }

    let formData = new FormData();

    formData.append('ref_id', '<?= $details['ref_id'] ?>');
    formData.append('department', department.value);
    formData.append('designation', designation.value);
    formData.append('reporting_to', reporting_to.value);
    formData.append('joining_date', joining_date.value);

    fetch("<?= base_url('admin/save-organization-details') ?>", {
        method: "POST",
        body: formData
    })
    .then(res => res.json())
    .then(res => {
        showToast("Organization details updated successfully.");
    })
    .catch(err => {
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

$(document).ready(function () {
    $('#reporting_to').select2({
        placeholder: "Select Manager",
        allowClear: true,
        width: '100%',
        dropdownParent: $('#organizationModal')
    });
});
</script>
<div id="toastMessage"
     style="
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