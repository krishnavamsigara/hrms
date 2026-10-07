<?php

// EXPERIENCE JSON
$experience = $details['experience'] ?? [];

if (is_string($experience)) {
    $experience = json_decode($experience, true) ?? [];
}

if (!is_array($experience)) {
    $experience = [];
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>BloomHR | Professional Experience</title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="<?= base_url('public/dist/css/onboarding.css') ?>">
<style>
.radio-wrap{
    display:flex;
    gap:15px;
}

.radio-box{
    flex:1;
    border:1px solid var(--border);
    border-radius:12px;
    padding:18px;
    cursor:pointer;
    transition:.3s;
    background: #fff;
}

.radio-box:hover{
    border-color:var(--bloom-purple);
    background:#f5f3ff;
}

.radio-box input{
    margin-right:8px;
}

.add-btn{
    border:none;
    background:#eef2ff;
    color:var(--bloom-purple);
    padding:12px 20px;
    border-radius:10px;
    font-weight:700;
    cursor:pointer;
    font-size:14px;
    transition: 0.3s;
}
.add-btn:hover {
    background: #e0e7ff;
}

.error-field {
    border: 1px solid red !important;
    background: #fff5f5 !important;
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
<form method="post" id="experienceForm">
    <input type="hidden" name="experience_json" id="experience_json">
    <div class="content-wrapper">
            <h1 class="page-title">Professional Experience</h1>

            <!-- Draft Mode Editable Banner -->
            <div class="edit-badge-bar" style="display: flex; align-items: center; gap: 8px; background: #eef2ff; color: #4338ca; border: 1px solid #c7d2fe; padding: 10px 16px; border-radius: 12px; margin-bottom: 25px; font-size: 13px; font-weight: 600;">
                <i class="fas fa-pen-to-square"></i>
                <span><strong>Draft Mode:</strong> You can modify your entries at any stage. Changes are allowed until final submission.</span>
            </div>

            <div class="main-card">
                <h3 class="section-title">
                    <i class="fas fa-briefcase"></i>
                    Work Experience Information
                </h3>

        <!-- <div class="form-group full">
            <label style="font-size: 15px; font-weight: 700; color: var(--bloom-dark); margin-bottom: 12px;">Choose Your Employment Status</label>

            <div class="radio-wrap">
                <div class="radio-box">
                    <label style="display: flex; align-items: center; cursor: pointer; font-weight: 600; width: 100%;">
                        <input type="radio" id="expFresher" name="experience" value="fresher" checked style="accent-color: var(--bloom-purple); width: 18px; height: 18px; margin-right: 10px;">
                        <div>
                            <span style="font-size: 15px; font-weight: 700; color: var(--bloom-dark); display: block;">I am a Fresher</span>
                            <span style="font-size: 12px; color: var(--muted); font-weight: 400;">No prior professional work experience</span>
                        </div>
                    </label>
                </div>

                <div class="radio-box">
                    <label style="display: flex; align-items: center; cursor: pointer; font-weight: 600; width: 100%;">
                        <input type="radio" id="expExperienced" name="experience" value="experienced" style="accent-color: var(--bloom-purple); width: 18px; height: 18px; margin-right: 10px;">
                        <div>
                            <span style="font-size: 15px; font-weight: 700; color: var(--bloom-dark); display: block;">I am Experienced</span>
                            <span style="font-size: 12px; color: var(--muted); font-weight: 400;">I have worked in one or more companies</span>
                        </div>
                    </label>
                </div>
            </div> -->

            <div id="experienceFields" style="display:none; margin-top: 30px;">
                <!-- dynamic container for multiple experience blocks -->
                <div id="experiencesContainer">
                    <!-- Spawning target -->
                </div>

                <div style="margin-top: 20px; margin-bottom: 30px;">
                    <button type="button" class="btn btn-outline" id="addExpBtn" style="color: var(--bloom-purple); border-color: var(--bloom-purple); font-weight: 700; width: 100%; justify-content: center; padding: 15px; border-style: dashed; border-width: 2px;">
                        <i class="fas fa-plus-circle"></i> Add More Experience / Previous Employment
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions block outside main card for structure consistency -->
    <div class="main-card">
        <div id="experienceError"
        style="display:none;
        margin-bottom:20px;
        padding:14px 18px;
        border-radius:10px;
        background:#fef2f2;
        color:#dc2626;
        border:1px solid #fecaca;
        font-weight:600;">
    </div>
        <div class="action-buttons" style="margin-top: 0; padding-top: 0; border-top: none;">
            <a href="<?= base_url('on_boarding/education_details') ?>" class="btn btn-outline">
                <i class="fas fa-arrow-left"></i> Back
            </a>
            <button type="button" class="btn btn-primary" onclick="saveAndNext()">
    Save & Next <i class="fas fa-arrow-right"></i>
</button>
        </div>
    </div>
</div>
</form>

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
const experiencesContainer = document.getElementById("experiencesContainer");
const addExpBtn = document.getElementById("addExpBtn");
const experienceFields = document.getElementById("experienceFields");
// const fresherRadio = document.querySelector('input[value="fresher"]');
// const experiencedRadio = document.querySelector('input[value="experienced"]');

const empTypeOptions = `
    <option value="">Select Type</option>
    <option>FULL TIME</option>
    <option>PART TIME</option>
    <option>INTERNSHIP</option>
    <option>CONTRACT</option>
`;

const expRangeOptions = `
    <option value="">Select Experience</option>
    <option>1.5 Years</option>
    <option>2 Years</option>
    <option>3 Years</option>
    <option>4 Years</option>
    <option>5 Years</option>
`;

function createExperienceBlock(data = {}) {
    const card = document.createElement("div");
    card.className = "experience-card";
    card.style.position = "relative";
    card.style.marginBottom = "25px";
    card.style.border = "1px solid var(--border)";
    card.style.borderRadius = "12px";
    card.style.padding = "25px";
    card.style.background = "#fff";

    const index = experiencesContainer.children.length + 1;

    card.innerHTML = `
        ${index > 1 ? `
        <button type="button" class="btn-remove-exp" onclick="removeExpBlock(this)" style="position: absolute; top: 22px; right: 22px; background: none; border: 1px solid #fecaca; color: #ef4444; padding: 6px 12px; border-radius: 6px; font-size: 12px; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 4px;">
            <i class="fas fa-trash"></i> Remove
        </button>
        ` : ''}
        <h4 style="font-size: 16px; font-weight: 700; color: var(--bloom-purple); border-bottom: 1px solid var(--border); padding-bottom: 10px; margin-bottom: 20px; display: flex; align-items: center; gap: 8px;">
            <i class="fas fa-briefcase"></i> Last / Current Employment Details ${index > 1 ? `#${index}` : '(Latest)'}
        </h4>
        
        <div class="grid">
            <div class="form-group">
                <label>Company Name <span class="required">*</span></label>
                <input type="text" class="form-control exp-company" placeholder="E.g., Bloom Solutions Pvt Ltd" value="${data.company_name || ''}">
                <small style="color: var(--muted); font-size: 11px;">Enter full name of the organization</small>
            </div>

            <div class="form-group">
                <label>Designation / Role <span class="required">*</span></label>
                <input type="text" class="form-control exp-designation" placeholder="E.g., Software Engineer" value="${data.designation || ''}">
                <small style="color: var(--muted); font-size: 11px;">Your last held official job title</small>
            </div>

            <div class="form-group">
                <label>Employment Type <span class="required">*</span></label>
                <select class="form-control exp-type">${empTypeOptions}</select>
            </div>

           <div class="form-group">
    <label>Total Experience <span class="required">*</span></label>
    <input type="text" class="form-control exp-range" placeholder="Enter total experience (e.g. 10 Months, 1 Year, 1.5 Years)" required>
</div>

            <div class="form-group">
                <label>Employment Start Date <span class="required">*</span></label>
                <input type="date" class="form-control exp-start" value="${data.start_date || ''}">
            </div>

            <div class="form-group">
                <label>Employment End Date <span class="required">*</span></label>
                <input type="date" class="form-control exp-end" value="${data.end_date || ''}">
            </div>

            <div class="form-group">
                <label>Current / Last CTC (Annual) <span class="required">*</span></label>
                <input type="text" class="form-control exp-current-ctc" placeholder="E.g., ₹ 4,50,000" value="${data.current_ctc || ''}">
            </div>

      <div class="form-group full">
                <label>Key Skills & Technologies Handled <span class="required">*</span></label>
                <input type="text" class="form-control exp-skills" placeholder="E.g., Python, SQL, HTML, CSS, Git" value="${data.skills || ''}">
            </div>
 
            <div class="form-group full">
                <label>Major Projects Delivered <span class="required">*</span></label>
                <textarea class="form-control exp-projects" placeholder="Describe key projects and your individual contributions.">${data.profProjects || ''}</textarea>
            </div>
 
            <div class="form-group full">
                <label>Core Job Responsibilities <span class="required">*</span></label>
                <textarea class="form-control exp-responsibilities" placeholder="Summarize your daily responsibilities and deliverables.">${data.responsibilities || ''}</textarea>
            </div>

        </div>
    `;

    experiencesContainer.appendChild(card);
    

    // FIX SELECT VALUES (IMPORTANT)
if (data.empType) {
    card.querySelector(".exp-type").value = data.empType;
}

if (data.totalExp) {
    card.querySelector(".exp-range").value = data.totalExp;
}

}

function removeExpBlock(button) {
    const card = button.closest(".experience-card");
    if (card) {
        card.remove();
        // Update indices and headers
        Array.from(experiencesContainer.children).forEach((child, index) => {
            const heading = child.querySelector("h4");
            if (heading) {
                heading.innerHTML = `<i class="fas fa-briefcase"></i> Last / Current Employment Details ${index > 0 ? `#${index+1}` : '(Latest)'}`;
            }
        });
    }
}

addExpBtn.addEventListener("click", () => {
    createExperienceBlock();
});

// Toggling Fresher / Experienced
// fresherRadio.addEventListener("change", function () {
//     experienceFields.style.display = "none";
//     localStorage.setItem("experience", "fresher");
// });

// experiencedRadio.addEventListener("change", function () {
//     experienceFields.style.display = "block";
//     localStorage.setItem("experience", "experienced");
//     if (experiencesContainer.children.length === 0) {
//         createExperienceBlock();
//     }
// });

function saveProfessionalData() {
    const isFresher = false; // since radio is removed
    localStorage.setItem("experience", isFresher ? "fresher" : "experienced");
     
    //  1. FIRST HANDLE FRESHER CASE
    if (isFresher) {

    document.getElementById("experience_json").value =
        JSON.stringify([
            {
                experience_type: "FRESHER"
            }
        ]);

    localStorage.removeItem("professional_history");
    return;
}


   const experiences = [];

   document.querySelectorAll(".experience-card").forEach(card => {
    const company = card.querySelector(".exp-company").value;
    const designation = card.querySelector(".exp-designation").value;
    const empType = card.querySelector(".exp-type").value;
    const totalExp = card.querySelector(".exp-range").value;
    const profStartDate = card.querySelector(".exp-start").value;
    const profEndDate = card.querySelector(".exp-end").value;
    const currentCtc = card.querySelector(".exp-current-ctc").value;
    const skills = card.querySelector(".exp-skills").value;
    const profProjects = card.querySelector(".exp-projects").value;
    const responsibilities = card.querySelector(".exp-responsibilities").value;
   const experienceDetails = [];

card.querySelectorAll(".project-table-body tr").forEach(row => {

    experienceDetails.push({
        skill: row.querySelector(".proj-skill").value,
        project_name: row.querySelector(".proj-name").value,
        responsibility: row.querySelector(".proj-responsibility").value,
        role: row.querySelector(".proj-role").value
    });

});
   if (company) {
    experiences.push({
    experience_type: "EXPERIENCED",
    employment_type: empType.replace(' ', '_'),

    company_name: company,
    designation: designation,

    start_date: profStartDate,
    end_date: profEndDate,

    total_experience: totalExp,

    current_ctc: currentCtc,

    skills: skills,

    major_projects_delivered: profProjects,

    core_job_responsibilities: responsibilities,

    experience_details: experienceDetails
});
}
});

  //  EXACT PLACE (PUT IT HERE)
    document.getElementById("experience_json").value =
        JSON.stringify(experiences);
    localStorage.setItem("professional_history", JSON.stringify(experiences));

    // Save legacy keys for the first experience
    if (experiences.length > 0) {
        localStorage.setItem("company", experiences[0].company_name);
        localStorage.setItem("designation", experiences[0].designation);
        localStorage.setItem("skills", experiences[0].skills);
    }
}

function showExperienceError(message) {
    const errorBox = document.getElementById("experienceError");
    errorBox.innerHTML = '<i class="fas fa-circle-exclamation"></i> ' + message;
    errorBox.style.display = "block";

    errorBox.scrollIntoView({
        behavior: "smooth",
        block: "center"
    });
}

function hideExperienceError() {
    document.getElementById("experienceError").style.display = "none";
}
// function saveAndNext() {
//     saveProfessionalData();
//     document.getElementById("experienceForm").submit();
// }

// On Page Load
document.addEventListener("DOMContentLoaded", () => {

    const experienceData = <?= json_encode($experience) ?>;

    console.log("EXPERIENCE DATA:", experienceData);

    experienceFields.style.display = "block";

    if (experienceData.length > 0) {

        experienceData.forEach(item => {
            createExperienceBlock({
                company_name: item.company_name || '',
                designation: item.designation || '',
                empType: item.employment_type
                    ? item.employment_type.replace('_', ' ')
                    : '',
                totalExp: item.total_experience || '',
                start_date: item.start_date || '',
                end_date: item.end_date || '',
                current_ctc: item.current_ctc || '',
                expected_ctc: item.expected_ctc || '',
                skills: item.skills || '',
               profProjects: item.major_projects_delivered || '',
               responsibilities: item.core_job_responsibilities || '',
            });
        });

    } else {
        createExperienceBlock(); // empty form
    }

});
function saveAndNext() {

    let isValid = true;

    hideExperienceError();

    document.querySelectorAll(".error-field").forEach(el => {
        el.classList.remove("error-field");
    });

    document.querySelectorAll(".experience-card").forEach(card => {

        const requiredFields = [
            card.querySelector(".exp-company"),
            card.querySelector(".exp-designation"),
            card.querySelector(".exp-type"),
            card.querySelector(".exp-range"),
            card.querySelector(".exp-current-ctc"),
            card.querySelector(".exp-skills"),
            card.querySelector(".exp-projects"),
            card.querySelector(".exp-responsibilities")
        ];

       requiredFields.forEach(field => {
    if (!field || !field.value || field.value.trim() === "") {
        if (field) field.classList.add("error-field");
        isValid = false;
    }
});

    const start = card.querySelector(".exp-start").value;
    const end = card.querySelector(".exp-end").value;
    const manualExp = card.querySelector(".exp-range").value;

    if (start && end && manualExp) {

        const calculatedYears = getExperienceFromDates(start, end);

        if (calculatedYears === "INVALID") {
            showExperienceError("End Date should be greater than Start Date.");

            card.querySelector(".exp-start").classList.add("error-field");
            card.querySelector(".exp-end").classList.add("error-field");

            isValid = false;
            return;
        }

    let enteredMonths = 0;

if (manualExp.toLowerCase().includes("year")) {
    enteredMonths = parseFloat(manualExp) * 12;
} else {
    enteredMonths = parseInt(manualExp);
}

if (enteredMonths !== calculatedYears) {
    showExperienceError("Total Experience does not match the selected Start Date and End Date.");

    card.querySelector(".exp-range").classList.add("error-field");
    card.querySelector(".exp-start").classList.add("error-field");
    card.querySelector(".exp-end").classList.add("error-field");

    isValid = false;
    return;
}
}
    });

    if (!isValid) {
        return;
    }

//     if (start && end && manualExp) {

//     const calculatedYears = getExperienceFromDates(start, end);

//     if (calculatedYears === "INVALID") {
//         alert("End Date should be greater than Start Date");

//         card.querySelector(".exp-start").classList.add("error-field");
//         card.querySelector(".exp-end").classList.add("error-field");

//         isValid = false;
//         return;
//     }

//     const manualYears = parseInt(manualExp);

//     if (manualYears !== calculatedYears) {
//         alert("Experience does not match Start and End dates");

//         card.querySelector(".exp-range").classList.add("error-field");
//         card.querySelector(".exp-start").classList.add("error-field");
//         card.querySelector(".exp-end").classList.add("error-field");

//         isValid = false;
//         return;
//     }
// }

    saveProfessionalData();

    console.log("Submitting form...");

    document.getElementById("experienceForm").submit();
}

function getExperienceFromDates(start, end) {

    if (!start || !end) return null;

    const startDate = new Date(start);
    const endDate = new Date(end);

    if (startDate > endDate) return "INVALID";

    let totalMonths =
        (endDate.getFullYear() - startDate.getFullYear()) * 12 +
        (endDate.getMonth() - startDate.getMonth());

    return totalMonths;
}

</script>
</body>
</html>