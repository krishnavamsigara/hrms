document.addEventListener("DOMContentLoaded", () => {
    initSidebar();
});

const steps = [
    { id: "offer", path: "/V2/on_boarding/view_appointment_letter" },
    { id: "checklist", path: "/V2/on_boarding/document_checklist" },
    { id: "personal", path: "/V2/on_boarding/personal_details" },
    { id: "bank", path: "/V2/on_boarding/bank_details" },
    { id: "education", path: "/V2/on_boarding/education_details" },
    { id: "professional", path: "/V2/on_boarding/professional_details" },
    { id: "upload", path: "/V2/on_boarding/document_upload" },
    { id: "crosscheck", path: "/V2/on_boarding/cross_check" }
];

function initSidebar() {
    const sidebarList = document.getElementById("sidebar-list");
    if (!sidebarList) return;

    // Add AdminLTE style brand logo to the top of the sidebar
    const sidebarContainer = document.querySelector('.app-sidebar');
    if (sidebarContainer && !document.querySelector('.sidebar-brand')) {
        const brandHtml = `
    <a href="#" class="sidebar-brand">
        <img src="/V2/public/dist/img/bloom.jpg" alt="Logo">
        <span><span style="color:#4a8cff;">Bloom</span> <span style="color:#ff7a45;">Solutions</span></span>
    </a>
`;
        sidebarContainer.insertAdjacentHTML('afterbegin', brandHtml);
    }

    const isSubmitted = localStorage.getItem("onboarding_submitted") === "true";
    let maxUnlockedIndex = isSubmitted ? (steps.length - 1) : (parseInt(localStorage.getItem("onboarding_max_step")) || 0);
    const currentPath = window.location.pathname;
    let currentIndex = steps.findIndex(s => currentPath.includes(s.path));
    console.log("Current Path:", currentPath);
    console.log("Current Index:", currentIndex);
    
    // Safety check: if URL directly accessed is locked, redirect to max unlocked
    // if (!isSubmitted && currentIndex > maxUnlockedIndex) {
    //     window.location.href = steps[maxUnlockedIndex].path;
    //     return;
    // }

    const html = steps.map((step, index) => {
        let statusClass = "disabled";
        let icon = '<i class="fas fa-lock"></i>';

        if (index < currentIndex) {
            statusClass = "completed";
            icon = '<i class="fas fa-check-circle"></i>';
        } else if (index === currentIndex) {
            statusClass = "active";
            icon = getStepIcon(step.id);
        } else if (index <= maxUnlockedIndex) {
            statusClass = "";
            icon = getStepIcon(step.id);
        }

        const link = statusClass === "disabled" ? "#" : step.path;

        return `
            <li>
                <a href="${link}" class="${statusClass}">
                    ${icon}
                    ${getStepName(step.id)}
                </a>
            </li>
        `;
    }).join("");

    sidebarList.innerHTML = html;
}

function getStepName(id) {
    const names = {
        "offer": "Offer Letter",
        "checklist": "Document Checklist",
        "personal": "Personal Details",
        "bank": "Bank Details",
        "education": "Education Details",
        "professional": "Professional Details",
        "upload": "Document Upload",
        "crosscheck": "Cross Check"
    };
    return names[id] || id;
}

function getStepIcon(id) {
    const icons = {
        "offer": '<i class="fas fa-file-contract"></i>',
        "checklist": '<i class="fas fa-list-check"></i>',
        "personal": '<i class="fas fa-user"></i>',
        "bank": '<i class="fas fa-university"></i>',
        "education": '<i class="fas fa-graduation-cap"></i>',
        "professional": '<i class="fas fa-briefcase"></i>',
        "upload": '<i class="fas fa-file-upload"></i>',
        "crosscheck": '<i class="fas fa-check-double"></i>'
    };
    return icons[id] || '<i class="fas fa-circle"></i>';
}

function completeStepAndNext(currentId) {
    // Auto save input fields if on a form page
    saveInputsToStorage();

    const currentIndex = steps.findIndex(s => s.id === currentId);
    if (currentIndex > -1 && currentIndex < steps.length - 1) {
        const nextIndex = currentIndex + 1;
        
        let maxUnlockedIndex = parseInt(localStorage.getItem("onboarding_max_step")) || 0;
        if (nextIndex > maxUnlockedIndex) {
            localStorage.setItem("onboarding_max_step", nextIndex);
        }
        
        window.location.href = steps[nextIndex].path;
    } else if (currentIndex === steps.length - 1) {
        window.location.href = "thank_you.html";
    }
}

function logout() {
    localStorage.clear(); // Clear all saved progress on logout to start fresh
    window.location.href = "onboard_login.html";
}

// Storage helper functions to save and load user entered inputs automatically
function saveInputsToStorage() {
    const inputs = document.querySelectorAll("input, textarea, select");
    inputs.forEach(input => {
        if (input.type === "password" || input.type === "file") return;
        
        const key = input.id || input.name;
        if (!key) return;

        if (input.type === "radio") {
            if (input.checked) {
                localStorage.setItem(key, input.value);
            }
        } else if (input.type === "checkbox") {
            localStorage.setItem(key, input.checked ? "true" : "false");
        } else {
            localStorage.setItem(key, input.value);
        }
    });
}

function loadInputsFromStorage() {
    const inputs = document.querySelectorAll("input, textarea, select");
    inputs.forEach(input => {
        if (input.type === "password" || input.type === "file") return;

        const key = input.id || input.name;
        if (!key) return;

        const val = localStorage.getItem(key);
        if (val !== null) {
            if (input.type === "radio") {
                if (val === input.value) {
                    input.checked = true;
                    input.dispatchEvent(new Event('change'));
                }
            } else if (input.type === "checkbox") {
                input.checked = (val === "true");
                input.dispatchEvent(new Event('change'));
            } else {
                input.value = val;
                input.dispatchEvent(new Event('change'));
            }
        }
    });
}

// Automatically load inputs on page load and check submission status
document.addEventListener("DOMContentLoaded", () => {
    loadInputsFromStorage();
    checkSubmissionStatus();
});

function checkSubmissionStatus() {
    const isSubmitted = localStorage.getItem("onboarding_submitted") === "true";
    if (!isSubmitted) return;

    // Add a developer Unlock & Edit button for testing environments
    const userProfile = document.querySelector(".user-profile");
    if (userProfile && !document.getElementById("unlock-testing-btn")) {
        const unlockBtn = document.createElement("a");
        unlockBtn.id = "unlock-testing-btn";
        unlockBtn.href = "#";
        unlockBtn.style.background = "#fff1f2";
        unlockBtn.style.color = "#e11d48";
        unlockBtn.style.border = "1px solid #fecdd3";
        unlockBtn.style.padding = "6px 12px";
        unlockBtn.style.borderRadius = "8px";
        unlockBtn.style.fontSize = "12px";
        unlockBtn.style.fontWeight = "700";
        unlockBtn.style.marginRight = "15px";
        unlockBtn.style.textDecoration = "none";
        unlockBtn.style.display = "inline-flex";
        unlockBtn.style.alignItems = "center";
        unlockBtn.style.gap = "6px";
        unlockBtn.innerHTML = `<i class="fas fa-unlock"></i> Unlock & Edit`;
        
        unlockBtn.onclick = function(e) {
            e.preventDefault();
            localStorage.removeItem("onboarding_submitted");
            window.location.reload();
        };
        
        userProfile.insertBefore(unlockBtn, userProfile.firstChild);
    }

    // 1. Update all Draft Mode banners on the page to Locked Mode
    const editBanners = document.querySelectorAll(".edit-badge-bar");
    editBanners.forEach(banner => {
        banner.style.background = "#ecfdf5";
        banner.style.color = "#065f46";
        banner.style.borderColor = "#a7f3d0";
        banner.innerHTML = `
            <i class="fas fa-lock" style="color: #059669; font-size: 14px;"></i>
            <span><strong>Submitted Mode (Read-Only):</strong> Your application has been successfully submitted. You can view your entered details, but no further changes can be made.</span>
        `;
    });

    // 2. Disable all input fields, textareas, selects, and checkboxes
    const inputs = document.querySelectorAll("input, textarea, select");
    inputs.forEach(input => {
        if (input.id === "declaration_check") {
            input.checked = true;
        }
        input.disabled = true;
        input.style.backgroundColor = "#f8fafc"; // Slate 50 to show read-only
        input.style.cursor = "not-allowed";
        input.style.color = "#64748b"; // Slate 500
        input.style.borderColor = "#cbd5e1";
    });

    // 3. Hide all "add/remove" dynamic experience or qualification buttons
    const dynamicButtons = document.querySelectorAll(".btn-add-more, .btn-remove, button[onclick*='addQualification'], button[onclick*='addExperience'], button[onclick*='removeExperience'], button[onclick*='removeQual'], button[onclick*='addMoreExperience']");
    dynamicButtons.forEach(btn => {
        btn.style.display = "none";
    });

    // Hide file upload containers, file inputs and delete buttons
    const fileControls = document.querySelectorAll("input[type='file'], .file-upload-box, .btn-delete-file, .upload-btn, .file-input-wrapper");
    fileControls.forEach(ctrl => {
        ctrl.style.pointerEvents = "none";
        ctrl.style.opacity = "0.6";
        if (ctrl.tagName === "INPUT") {
            ctrl.disabled = true;
        }
    });

    // 4. Update form action buttons (e.g. Save & Next)
    const saveNextBtn = document.querySelector("button[onclick^='completeStepAndNext']");
    if (saveNextBtn) {
        const onclickAttr = saveNextBtn.getAttribute("onclick");
        const match = onclickAttr ? onclickAttr.match(/'([^']+)'/) : null;
        if (match && match[1]) {
            const currentStepId = match[1];
            saveNextBtn.innerHTML = `Next Step <i class="fas fa-arrow-right"></i>`;
            saveNextBtn.style.background = "linear-gradient(135deg, #6366f1, #4f46e5)";
            saveNextBtn.onclick = function(e) {
                e.preventDefault();
                // Direct step navigation without saving
                const currentIndex = steps.findIndex(s => s.id === currentStepId);
                if (currentIndex > -1 && currentIndex < steps.length - 1) {
                    window.location.href = steps[currentIndex + 1].path;
                }
            };
        }
    }

    // 5. Hide Edit buttons in cross_check review sections
    const editSectionBtns = document.querySelectorAll(".edit-section-btn");
    editSectionBtns.forEach(btn => {
        btn.style.display = "none";
    });

    // 6. Replace final submit button with a submitted badge and hide back to edit button
    const finalSubmitBtn = document.getElementById("finalSubmitBtn");
    if (finalSubmitBtn) {
        const parent = finalSubmitBtn.parentElement;
        if (parent) {
            parent.innerHTML = `
                <div style="background: #ecfdf5; color: #047857; border: 1px solid #a7f3d0; padding: 12px 24px; border-radius: 12px; font-weight: 700; font-size: 14px; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.1);">
                    <i class="fas fa-check-circle" style="font-size: 16px;"></i> Application Submitted & Locked
                </div>
            `;
        }
    }

    // Hide the declaration checkbox wrapper container on cross check page
    const declContainer = document.querySelector(".declaration-checkbox-container");
    if (declContainer) {
        declContainer.style.background = "#f0fdf4";
        declContainer.style.borderColor = "#bbf7d0";
        declContainer.style.color = "#166534";
        const label = declContainer.querySelector("label");
        if (label) {
            label.style.color = "#166534";
            label.innerHTML = `<i class="fas fa-clipboard-check"></i> Application finalized and submitted under verified declaration.`;
        }
    }
}

