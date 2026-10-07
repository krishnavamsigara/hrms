<?php

$qualification = $details['qualification'] ?? [];

// IMPORTANT: always make it array
if (is_string($qualification)) {
    $qualification = json_decode($qualification, true) ?? [];
}

if (!is_array($qualification)) {
    $qualification = [];
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>BloomHR | Education Details</title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="<?= base_url('public/dist/css/onboarding.css') ?>">
<style>
   .required-error {
    border: 1px solid red !important;
}

.required-error {
    border: 2px solid red !important;
    /* box-shadow: 0 0 4px rgba(255, 0, 0, 0.4) !important;
    outline: none !important; */
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
        <form method="post" id="educationForm" novalidate>
    <input type="hidden" name="qualification_json" id="qualification_json">

    
        <div class="content-wrapper">
            <h1 class="page-title">Education Details</h1>

            <!-- Draft Mode Editable Banner -->
            <div class="edit-badge-bar" style="display: flex; align-items: center; gap: 8px; background: #eef2ff; color: #4338ca; border: 1px solid #c7d2fe; padding: 10px 16px; border-radius: 12px; margin-bottom: 25px; font-size: 13px; font-weight: 600;">
                <i class="fas fa-pen-to-square"></i>
                <span><strong>Draft Mode:</strong> You can modify your entries at any stage. Changes are allowed until final submission.</span>
            </div>

           <!-- Higher Education Question -->
<div class="main-card" style="margin-bottom:20px;">
    <div class="form-group">
        <label>Do you have any Higher Education Qualification?</label>

        <div style="display:flex; gap:25px; margin-top:10px;">
            <label>
                <input type="radio" name="higherEducation" value="Yes">
                Yes
            </label>

            <label>
                <input type="radio" name="higherEducation" value="No" checked>
                No
            </label>
        </div>
    </div>
</div>

<!-- Higher Education Section -->
<div id="higherEducationSection" style="display:none;">

<!-- <div style="margin-bottom:30px;text-align:center;">
        <button type="button"
                class="btn btn-outline"
                id="addQualBtn"
                style="color: var(--bloom-purple);
                       border-color: var(--bloom-purple);
                       font-weight:700;
                       width:100%;
                       justify-content:center;
                       padding:15px;
                       border-style:dashed;
                       border-width:2px;">

            <i class="fas fa-plus-circle"></i>
            Add Another
        </button>
    </div> -->

    <div id="qualificationsContainer"></div>


</div>
           <div class="main-card" style="margin-bottom: 25px;">
    <h3 class="section-title" style="color: var(--bloom-purple); border-bottom: 1px solid var(--border); padding-bottom: 12px; margin-bottom: 20px;">
        <i class="fas fa-user-graduate"></i>
        1. Graduation Details
    </h3>

    <div class="grid">

        <div class="form-group">
            <label>Qualification <span class="required">*</span></label>
            <select id="graduationQualification" class="form-control" required>
                <option value="">Select Qualification</option>
                <option>B.Tech / B.E</option>
                <option>B.Sc</option>
                <option>BCA</option>
                <option>B.Com</option>
                <option>BA</option>
                <option>BBA</option>
                <option>Other</option>
            </select>
        </div>

        <div class="form-group">
            <label>Specialization / Branch <span class="required">*</span></label>
            <input type="text" id="graduationBranch" class="form-control"
                   placeholder="E.g. Computer Science, EEE, Mechanical" required>
        </div>

        <div class="form-group">
            <label>College Name <span class="required">*</span></label>
            <input type="text" id="graduationCollege" class="form-control"
                   placeholder="Enter College Name" required>
        </div>

        <div class="form-group">
            <label>University <span class="required">*</span></label>
            <input type="text" id="graduationUniversity" class="form-control"
                   placeholder="E.g. JNTUK" required>
        </div>

        <div class="form-group">
            <label>Course Type <span class="required">*</span></label>
            <select id="graduationCourseType" class="form-control" required>
                <option value="">Select Course Type</option>
                <option>Regular</option>
                <option>Distance</option>
                <option>Online</option>
            </select>
        </div>

        <div class="form-group">
            <label>Passed Out Year <span class="required">*</span></label>
            <input type="number" id="graduationYear" class="form-control"
                   placeholder="E.g. 2024" required>
        </div>

        <div class="form-group">
            <label>Percentage / CGPA <span class="required">*</span></label>
            <input type="text" id="graduationCgpa" class="form-control"
                   placeholder="E.g. 8.5 CGPA or 85%" required>
        </div>

        <div class="form-group">
            <label>Active Backlogs <span class="required">*</span></label>
            <select id="graduationBacklogs" class="form-control" required>
                <option value="">Select</option>
                <option>No Backlogs</option>
                <option>1 Backlog</option>
                <option>2 Backlogs</option>
                <option>3+ Backlogs</option>
            </select>
        </div>

    </div>
</div>

            <!-- Intermediate details -->
            <div class="main-card" style="margin-bottom: 25px;">
                <h3 class="section-title" style="color: var(--bloom-purple); border-bottom: 1px solid var(--border); padding-bottom: 12px; margin-bottom: 20px;">
                    <i class="fas fa-user-graduate"></i>
                    2. Intermediate / 12th / Diploma Details
                </h3>
                <div class="grid">
                    <div class="form-group">
                        <label>College Name <span class="required">*</span></label>
                        <input type="text" id="interCollege" name="interCollege" class="form-control" placeholder="Enter Junior College Name" required>
                        <small style="color: var(--muted); font-size: 11px;">E.g., Narayana Junior College</small>
                    </div>

                    <div class="form-group">
                        <label>Course / Stream <span class="required">*</span></label>
                        <select id="interStream" name="interStream" class="form-control" required>
                            <option value="">Select Stream</option>
                            <option>MPC (Maths, Physics, Chemistry)</option>
                            <option>BIPC (Biology, Physics, Chemistry)</option>
                            <option>CEC (Civics, Economics, Commerce)</option>
                            <option>MEC (Maths, Economics, Commerce)</option>
                            <option>HEC</option>
                            <option>Diploma / Polytechnic</option>
                            <option>Other</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Board <span class="required">*</span></label>
                        <select id="interBoard" name="interBoard" class="form-control" required>
                            <option value="">Select Board</option>
                            <option>Board of Intermediate Education</option>
                            <option>CBSE</option>
                            <option>ICSE</option>
                            <option>State Board</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Passed Out Year <span class="required">*</span></label>
                        <input type="number" id="interYear" name="interYear" class="form-control" placeholder="E.g., 2020" required>
                    </div>

                    <div class="form-group">
                        <label>Percentage / GPA <span class="required">*</span></label>
                        <input type="text" id="interGpa" name="interGpa" class="form-control" placeholder="E.g., 90% or 9.0 GPA" required>
                    </div>

                    <!-- <div class="form-group">
                        <label>Start Date <span class="required">*</span></label>
                        <input type="month" id="interStartDate" name="interStartDate" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>End Date <span class="required">*</span></label>
                        <input type="month" id="interEndDate" name="interEndDate" class="form-control" required>
                    </div> -->
                </div>
            </div>

            <!-- SSC Details -->
            <div class="main-card" style="margin-bottom: 25px;">
                <h3 class="section-title" style="color: var(--bloom-purple); border-bottom: 1px solid var(--border); padding-bottom: 12px; margin-bottom: 20px;">
                    <i class="fas fa-school"></i>
                    3. 10th / SSC Details
                </h3>
                <div class="grid">
                    <div class="form-group">
                        <label>School Name <span class="required">*</span></label>
                        <input type="text" id="sscSchool" name="sscSchool" class="form-control" placeholder="Enter High School Name" required>
                        <small style="color: var(--muted); font-size: 11px;">E.g., St. Johns High School</small>
                    </div>

                    <div class="form-group">
                        <label>Board <span class="required">*</span></label>
                        <select id="sscBoard" name="sscBoard" class="form-control" required>
                            <option value="">Select Board</option>
                            <option>SSC (State Board)</option>
                            <option>CBSE</option>
                            <option>ICSE</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Passed Out Year <span class="required">*</span></label>
                        <input type="number" id="sscYear" name="sscYear" class="form-control" placeholder="E.g., 2018" required>
                    </div>

                    <div class="form-group">
                        <label>Percentage / GPA <span class="required">*</span></label>
                        <input type="text" id="sscGpa" name="sscGpa" class="form-control" placeholder="E.g., 95% or 9.5 GPA" required>
                    </div>

                </div>
            </div>

            

            <!-- Actions Card -->
            <div class="main-card">
                <div class="action-buttons" style="margin-top: 0; padding-top: 0; border-top: none;">
                    <a href="<?= base_url('on_boarding/bank_details') ?>" class="btn btn-outline">
                        <i class="fas fa-arrow-left"></i> Back
                    </a>
                   <button type="submit" class="btn btn-primary">
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
const qualificationsContainer = document.getElementById("qualificationsContainer");
const addQualBtn = document.getElementById("addQualBtn");

if (addQualBtn) {
    addQualBtn.addEventListener("click", () => {
        createQualificationBlock();
    });
}

const higherSection = document.getElementById("higherEducationSection");

document.querySelectorAll("input[name='higherEducation']").forEach(radio => {

    radio.addEventListener("change", function () {

        if (this.value === "Yes") {

            higherSection.style.display = "block";

            if (qualificationsContainer.children.length === 0) {
                createQualificationBlock();
            }

        } else {

            higherSection.style.display = "none";
            qualificationsContainer.innerHTML = "";

        }

    });

});

// Degree options HTML for dynamic card dropdown
const degreeOptions = `
    <option value="">Select Qualification </option>
    <option>M.Tech / M.E</option>
    <option>M.Sc</option>
    <option>MCA</option>
    <option>MBA</option>
    <option>PHD / Doctorate</option>
    <option>Other PG Degree</option>
`;

function createQualificationBlock(data = {}) {
    const card = document.createElement("div");
    card.className = "main-card qualification-card";
    card.style.position = "relative";
    card.style.marginBottom = "25px";

    const index = qualificationsContainer.children.length + 1;

    card.innerHTML = `
        ${index > 1 ? `
        <button type="button" class="btn-remove-qual" onclick="removeQualBlock(this)" style="position: absolute; top: 22px; right: 22px; background: none; border: 1px solid #fecaca; color: #ef4444; padding: 6px 12px; border-radius: 6px; font-size: 12px; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 4px;">
            <i class="fas fa-trash"></i> Remove
        </button>
        ` : ''}
        <div style="display:flex;justify-content:space-between;align-items:center;border-bottom:1px solid var(--border);padding-bottom:12px;margin-bottom:20px;">

    <h3 class="section-title" style="margin:0;border:none;color:var(--bloom-purple);">
        <i class="fas fa-graduation-cap"></i>
        1. Higher Qualification Details ${index > 1 ? `#${index}` : '(Highest)'}
    </h3>

    ${
        index === 1
        ? `
        <button
            type="button"
            id="addQualBtnHeader"
            onclick="createQualificationBlock()"
            style="
                width:36px;
                height:36px;
                border-radius:50%;
                border:2px dashed var(--bloom-purple);
                background:#fff;
                color:var(--bloom-purple);
                cursor:pointer;
                display:flex;
                align-items:center;
                justify-content:center;
                font-size:18px;
                font-weight:700;">
            <i class="fas fa-plus"></i>
        </button>
        `
        : ``
    }

</div>
        <div class="grid">
            <div class="form-group">
                <label>Highest Qualification</label>
                <select class="form-control qual-degree">${degreeOptions}</select>
                <small style="color: var(--muted); font-size: 11px;">Select degree category</small>
            </div>

            

            <div class="form-group">
                <label>College / University Name </label>
                <input type="text" class="form-control qual-college" placeholder="E.g., JNTU Kakinada" value="${data.college || ''}">
                <small style="color: var(--muted); font-size: 11px;">Full name of campus attended</small>
            </div>

            

            <div class="form-group">
                <label>Course Type</label>
                <select class="form-control qual-type">
                    <option value="">Select Course Type</option>
                    <option>Regular</option>
                    <option>Distance</option>
                    <option>Online</option>
                </select>
            </div>

            <div class="form-group">
                <label>Passed Out Year</label>
                <input type="number" class="form-control qual-year" value="${data.year_of_pass || ''}">
            </div>

            <div class="form-group">
                <label>Percentage / CGPA</label>
                <input type="text" class="form-control qual-cgpa" value="${data.percentage || ''}">
            </div>

        </div>
    `;

    qualificationsContainer.appendChild(card);

    // Pre-populate select tags
setTimeout(() => {
    const degree = card.querySelector(".qual-degree");
    if (degree) {
        degree.value = data.qualification || data.education_type || "";
    }

    const type = card.querySelector(".qual-type");
    if (type) {
        type.value = data.courseType || "";
    }
}, 0);
}

function removeQualBlock(button) {
    const card = button.closest(".qualification-card");
    if (card) {
        card.remove();
        // Update indices and headers
        Array.from(qualificationsContainer.children).forEach((child, index) => {
            const heading = child.querySelector(".section-title");
            if (heading) {
                heading.innerHTML = `<i class="fas fa-graduation-cap"></i> 1. Higher Qualification Details ${index > 0 ? `#${index+1}` : '(Highest)'}`;
            }
        });
    }
}

// addQualBtn.addEventListener("click", () => {
//     createQualificationBlock();
// });

function saveEducationData() {

    const qualifications = [];

    qualifications.push({
    education_type: "Graduation",
    qualification: document.getElementById("graduationQualification").value,
    specialization: document.getElementById("graduationBranch").value,
    institution: document.getElementById("graduationCollege").value,
    university: document.getElementById("graduationUniversity").value,
    courseType: document.getElementById("graduationCourseType").value,
    year_of_pass: document.getElementById("graduationYear").value,
    percentage: document.getElementById("graduationCgpa").value,
    backlogs: document.getElementById("graduationBacklogs").value
});

    // =====================
    // 1. DEGREE / HIGHER ED
    // =====================
    document.querySelectorAll(".qualification-card").forEach(card => {

        const qualification = card.querySelector(".qual-degree").value;

        if (qualification && qualification.trim() !== "") {
           qualifications.push({
            education_type: qualification,
            // specialization: card.querySelector(".qual-specialization").value,
            institution: card.querySelector(".qual-college").value,
            // university: card.querySelector(".qual-university").value,
            courseType: card.querySelector(".qual-type").value,
            year_of_pass: card.querySelector(".qual-year").value,
            percentage: card.querySelector(".qual-cgpa").value,
            // backlogs: card.querySelector(".qual-backlogs").value
        });
        }
    });

    // =====================
    // 2. INTERMEDIATE
    // =====================
   qualifications.push({
    education_type: "Intermediate",
    institution: document.getElementById("interCollege").value,
    stream: document.getElementById("interStream").value,
    board: document.getElementById("interBoard").value,
    year_of_pass: document.getElementById("interYear").value,
    // start_date: document.getElementById("interStartDate").value,
    // end_date: document.getElementById("interEndDate").value,
    percentage: document.getElementById("interGpa").value
});

    // =====================
    // 3. SSC / 10TH
    // =====================
    qualifications.push({
        education_type: "10th",
        institution: document.getElementById("sscSchool").value,
        board: document.getElementById("sscBoard").value,
        year_of_pass: document.getElementById("sscYear").value,
        // start_date: document.getElementById("sscStartDate").value,
        // end_date: document.getElementById("sscEndDate").value,
        percentage: document.getElementById("sscGpa").value
    });

    // FINAL JSON
    document.getElementById("qualification_json").value =
        JSON.stringify(qualifications);
}


function saveAndNext() {
    saveEducationData();
    completeStepAndNext('education');
}

// On Page Load
document.addEventListener("DOMContentLoaded", () => {
const qualificationData = <?= json_encode($qualification ?? [], JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>;

// console.log("QUALIFICATION DATA FROM PHP:", qualificationData);

    if (qualificationData.length > 0) {

        qualificationData.forEach(item => {

        if (item.education_type === 'Graduation') {

    document.getElementById('graduationQualification').value = item.qualification || '';
    document.getElementById('graduationBranch').value = item.specialization || '';
    document.getElementById('graduationCollege').value = item.institution || '';
    document.getElementById('graduationUniversity').value = item.university || '';
    document.getElementById('graduationCourseType').value = item.courseType || '';
    document.getElementById('graduationYear').value = item.year_of_pass || '';
    document.getElementById('graduationCgpa').value = item.percentage || '';
    document.getElementById('graduationBacklogs').value = item.backlogs || '';
}

    // HIGHER EDUCATION
   if (
    item.education_type !== 'Graduation' &&
    item.education_type !== '10th' &&
    item.education_type !== 'Intermediate'
   ) {
        document.querySelector("input[value='Yes']").checked = true;
       document.getElementById("higherEducationSection").style.display = "block";

   createQualificationBlock({
    qualification: item.education_type,
    college: item.institution || '',
    courseType: item.courseType || '',
    year_of_pass: item.year_of_pass || '',
    percentage: item.percentage || ''
});
    }

    // INTERMEDIATE
    if (item.education_type === 'Intermediate') {

        const interCollege = document.getElementById('interCollege');
if (interCollege) {
    interCollege.value = item.institution || '';
}
        document.getElementById('interStream').value = item.stream || '';
        document.getElementById('interBoard').value = item.board || '';
        document.getElementById('interYear').value = item.year_of_pass || '';
        document.getElementById('interGpa').value = item.percentage || '';
        // document.getElementById('interStartDate').value = item.start_date || '';
        // document.getElementById('interEndDate').value = item.end_date || '';
    }

    // SSC
    if (item.education_type === '10th') {

        document.getElementById('sscSchool').value = item.institution || '';
        document.getElementById('sscBoard').value = item.board || '';
        document.getElementById('sscYear').value = item.year_of_pass || '';
        document.getElementById('sscGpa').value = item.percentage || '';
        // document.getElementById('sscStartDate').value = item.start_date || '';
        // document.getElementById('sscEndDate').value = item.end_date || '';
    }

});

    } else {

    document.querySelector("input[value='No']").checked = true;
    document.getElementById("higherEducationSection").style.display = "none";

}

    // SKILLS
   

        document.getElementById("educationForm").addEventListener("submit", function (e) {
    e.preventDefault();

    saveEducationData();

    let valid = true;
    let firstError = null;

    // ONLY INTER + SSC VALIDATION
    // GRADUATION + INTERMEDIATE + SSC VALIDATION
    const interSscFields = [

    // Graduation
    "graduationQualification",
    "graduationBranch",
    "graduationCollege",
    "graduationUniversity",
    "graduationCourseType",
    "graduationYear",
    "graduationCgpa",
    "graduationBacklogs",

    // Intermediate
    "interCollege",
    "interStream",
    "interBoard",
    "interYear",
    "interGpa",

    // SSC
    "sscSchool",
    "sscBoard",
    "sscYear",
    "sscGpa"
];

    interSscFields.forEach(id => {
        const field = document.getElementById(id);

        if (!field) return;

        if (!field.value || field.value.trim() === "") {
            field.classList.add("required-error");

            if (!firstError) {
                firstError = field;
            }

            valid = false;
        } else {
            field.classList.remove("required-error");
        }
    });

        //  ADD TECH SKILLS HERE (THIS IS THE CORRECT PLACE)

  const field = document.getElementById("techSkills");

if (field) {
    if (!field.value.trim()) {
        field.classList.add("required-error");
        if (!firstError) firstError = field;
        valid = false;
    } else {
        field.classList.remove("required-error");
    }
}

    // STOP IF ERROR
    if (!valid) {
        firstError.focus();
        return;
    }

    // SUBMIT ONLY IF OK
    this.submit();
});

 //  ADD THIS HERE (RIGHT BELOW SUBMIT CODE)

    document.querySelectorAll("#educationForm input, #educationForm select, #educationForm textarea")
    .forEach(field => {
        field.addEventListener("input", function () {
            if (this.value.trim() !== "") {
                this.classList.remove("required-error");
            }
        });
    });


});

</script>
</body>
</html>