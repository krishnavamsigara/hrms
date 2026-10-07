<div class="content-wrapper" style="min-height: 800px; padding: 20px; background-color: #f4f6f9;">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-3 align-items-center">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark font-weight-bold">
                        <i class="fas fa-paper-plane text-primary mr-2"></i>Mail Center
                    </h1>
                    <p class="text-muted small mb-0">Compose emails, send Google Meet invites, manage templates, and configure SMTP settings.</p>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="<?= base_url('admin/mail/logs') ?>" class="btn btn-outline-secondary btn-sm rounded-pill px-3 mr-1">
                        <i class="fas fa-history mr-1"></i> Sent Logs
                    </a>
                    <a href="<?= base_url('admin/mail/settings') ?>" class="btn btn-outline-info btn-sm rounded-pill px-3">
                        <i class="fas fa-cog mr-1"></i> SMTP Settings
                    </a>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <!-- Flash Alert Messages -->
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                    <i class="fas fa-check-circle mr-2"></i><?= session()->getFlashdata('success') ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                    <i class="fas fa-exclamation-triangle mr-2"></i><?= session()->getFlashdata('error') ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif; ?>

            <div class="card card-primary card-outline shadow-sm rounded-lg border-0">
                <div class="card-header p-2 bg-white border-bottom">
                    <ul class="nav nav-pills" id="mailCategoryTabs">
                        <li class="nav-item">
                            <a class="nav-link <?= ($active_tab == 'offer_letter') ? 'active' : '' ?> font-weight-bold" href="#tab-offer" data-category="offer_letter">
                                <i class="fas fa-file-contract mr-1"></i> Offer Letter
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= ($active_tab == 'meet_invite') ? 'active' : '' ?> font-weight-bold" href="#tab-meet" data-category="meet_invite">
                                <i class="fas fa-video text-success mr-1"></i> Google Meet Invite
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= ($active_tab == 'custom') ? 'active' : '' ?> font-weight-bold" href="#tab-custom" data-category="custom">
                                <i class="fas fa-envelope-open text-info mr-1"></i> General / Custom Mail
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= ($active_tab == 'templates') ? 'active' : '' ?> font-weight-bold" href="#tab-templates" data-category="templates">
                                <i class="fas fa-edit text-warning mr-1"></i> Mail Template Editor
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="card-body p-4">
                    <div class="tab-content">

                        <!-- ==================== TAB 1: OFFER LETTER ==================== -->
                        <div class="tab-pane <?= ($active_tab == 'offer_letter') ? 'active show' : '' ?>" id="tab-offer">
                            <form action="<?= base_url('admin/mail/send') ?>" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="category" value="offer_letter">
                                
                                <?php if (!empty($candidates) || !empty($employees)): ?>
                                <div class="form-group bg-light p-3 rounded border">
                                    <label class="font-weight-bold text-dark"><i class="fas fa-user-check text-primary mr-1"></i> Select Recipient (Auto-fill)</label>
                                    <select class="form-control" id="offer_person_select" onchange="autoFillPerson(this, 'offer_recipient_email', 'offer_candidate_name')">
                                        <option value="">-- Choose Candidate or Employee --</option>
                                        <?php if (!empty($candidates)): ?>
                                            <optgroup label="Candidates">
                                                <?php foreach ($candidates as $cand): ?>
                                                    <option value="<?= htmlspecialchars($cand['email']) ?>" data-name="<?= htmlspecialchars($cand['emp_name']) ?>">
                                                        <?= htmlspecialchars($cand['emp_name']) ?> (<?= htmlspecialchars($cand['email']) ?>)
                                                    </option>
                                                <?php endforeach; ?>
                                            </optgroup>
                                        <?php endif; ?>
                                        <?php if (!empty($employees)): ?>
                                            <optgroup label="Employees">
                                                <?php foreach ($employees as $emp): ?>
                                                    <option value="<?= htmlspecialchars($emp['email']) ?>" data-name="<?= htmlspecialchars($emp['emp_name']) ?>">
                                                        <?= htmlspecialchars($emp['emp_name']) ?> (<?= htmlspecialchars($emp['email']) ?>)
                                                    </option>
                                                <?php endforeach; ?>
                                            </optgroup>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                <?php endif; ?>

                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label class="font-weight-bold">Candidate Email <span class="text-danger">*</span></label>
                                        <input type="email" name="recipient_email" id="offer_recipient_email" class="form-control" placeholder="candidate@example.com" required>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="font-weight-bold">Candidate Name <span class="text-danger">*</span></label>
                                        <input type="text" name="candidate_name" id="offer_candidate_name" class="form-control" placeholder="e.g. John Doe" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 form-group">
                                        <label class="font-weight-bold">Position / Designation</label>
                                        <input type="text" name="designation" id="offer_designation" class="form-control" placeholder="e.g. Software Engineer">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label class="font-weight-bold">Joining Date</label>
                                        <input type="date" name="joining_date" id="offer_joining_date" class="form-control" value="<?= date('Y-m-d', strtotime('+7 days')) ?>">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label class="font-weight-bold">Offered CTC / Salary</label>
                                        <input type="text" name="ctc" id="offer_ctc" class="form-control" placeholder="e.g. ₹ 6,00,000 LPA">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="font-weight-bold">Additional Offer Notes / Terms</label>
                                    <textarea name="custom_notes" id="offer_custom_notes" class="form-control" rows="3" placeholder="Enter any additional conditions or notes..."></textarea>
                                </div>

                                <div class="form-group">
                                    <label class="font-weight-bold"><i class="fas fa-paperclip mr-1"></i> Attach Offer Letter PDF / Document</label>
                                    <input type="file" name="attachment" class="form-control-file border p-2 rounded bg-light" accept=".pdf,.doc,.docx">
                                    <small class="form-text text-muted">Attach signed offer letter or agreement copy.</small>
                                </div>

                                <hr>
                                <div class="d-flex justify-content-between align-items-center">
                                    <button type="button" class="btn btn-outline-primary rounded-pill px-4" onclick="previewOfferLetter()">
                                        <i class="fas fa-eye mr-1"></i> Live Preview
                                    </button>
                                    <button type="submit" class="btn btn-primary px-4 font-weight-bold rounded-pill">
                                        <i class="fas fa-paper-plane mr-1"></i> Send Offer Letter Email
                                    </button>
                                </div>
                            </form>
                        </div>


                        <!-- ==================== TAB 2: GOOGLE MEET INVITE ==================== -->
                        <div class="tab-pane <?= ($active_tab == 'meet_invite') ? 'active show' : '' ?>" id="tab-meet">
                            <form action="<?= base_url('admin/mail/send') ?>" method="POST" enctype="multipart/form-data" id="meet_form">
                                <input type="hidden" name="category" value="meet_invite">

                                <?php if (!empty($candidates) || !empty($employees)): ?>
                                <div class="form-group bg-light p-3 rounded border">
                                    <label class="font-weight-bold text-dark"><i class="fas fa-user-check text-success mr-1"></i> Select Recipient (Auto-fill)</label>
                                    <select class="form-control" id="meet_person_select" onchange="autoFillPerson(this, 'meet_recipient_email', 'meet_recipient_name')">
                                        <option value="">-- Choose Candidate or Employee --</option>
                                        <?php if (!empty($candidates)): ?>
                                            <optgroup label="Candidates">
                                                <?php foreach ($candidates as $cand): ?>
                                                    <option value="<?= htmlspecialchars($cand['email']) ?>" data-name="<?= htmlspecialchars($cand['emp_name']) ?>">
                                                        <?= htmlspecialchars($cand['emp_name']) ?> (<?= htmlspecialchars($cand['email']) ?>)
                                                    </option>
                                                <?php endforeach; ?>
                                            </optgroup>
                                        <?php endif; ?>
                                        <?php if (!empty($employees)): ?>
                                            <optgroup label="Employees">
                                                <?php foreach ($employees as $emp): ?>
                                                    <option value="<?= htmlspecialchars($emp['email']) ?>" data-name="<?= htmlspecialchars($emp['emp_name']) ?>">
                                                        <?= htmlspecialchars($emp['emp_name']) ?> (<?= htmlspecialchars($emp['email']) ?>)
                                                    </option>
                                                <?php endforeach; ?>
                                            </optgroup>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                <?php endif; ?>

                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label class="font-weight-bold">Recipient Email <span class="text-danger">*</span></label>
                                        <input type="email" name="recipient_email" id="meet_recipient_email" class="form-control" placeholder="recipient@example.com" required>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="font-weight-bold">Recipient Name</label>
                                        <input type="text" name="recipient_name" id="meet_recipient_name" class="form-control" placeholder="e.g. Jane Smith">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label class="font-weight-bold">Meeting Title <span class="text-danger">*</span></label>
                                        <input type="text" name="meeting_title" id="meet_title" class="form-control" placeholder="e.g. Technical Interview - Phase 1" value="Bloom Solutions - Interview Session" required>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="font-weight-bold">Google Meet Link <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-success text-white"><i class="fas fa-video"></i></span>
                                            </div>
                                            <input type="url" name="meet_url" id="meet_url" class="form-control" placeholder="https://meet.google.com/abc-defg-hij" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label class="font-weight-bold">Meeting Date</label>
                                        <input type="date" name="meeting_date" id="meet_date" class="form-control" value="<?= date('Y-m-d') ?>">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="font-weight-bold">Meeting Time</label>
                                        <input type="time" name="meeting_time" id="meet_time" class="form-control" value="10:00">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="font-weight-bold">Meeting Agenda / Instructions</label>
                                    <textarea name="agenda" id="meet_agenda" class="form-control" rows="3" placeholder="Please join on time with your camera enabled. Discussion topics include..."></textarea>
                                </div>

                                <div class="form-group">
                                    <label class="font-weight-bold"><i class="fas fa-paperclip mr-1"></i> Attachment (Optional)</label>
                                    <input type="file" name="attachment" class="form-control-file border p-2 rounded bg-light">
                                </div>

                                <hr>
                                <div class="d-flex justify-content-between align-items-center">
                                    <button type="button" class="btn btn-outline-success rounded-pill px-4" onclick="previewMeetInvite()">
                                        <i class="fas fa-eye mr-1"></i> Live Preview
                                    </button>
                                    <button type="submit" class="btn btn-success px-4 font-weight-bold rounded-pill">
                                        <i class="fas fa-paper-plane mr-1"></i> Send Google Meet Invite
                                    </button>
                                </div>
                            </form>
                        </div>


                        <!-- ==================== TAB 3: CUSTOM MAIL ==================== -->
                        <div class="tab-pane <?= ($active_tab == 'custom') ? 'active show' : '' ?>" id="tab-custom">
                            <form action="<?= base_url('admin/mail/send') ?>" method="POST" enctype="multipart/form-data" id="custom_form">
                                <input type="hidden" name="category" value="custom">

                                <?php if (!empty($candidates) || !empty($employees)): ?>
                                <div class="form-group bg-light p-3 rounded border">
                                    <label class="font-weight-bold text-dark"><i class="fas fa-user-check text-info mr-1"></i> Select Recipient (Auto-fill)</label>
                                    <select class="form-control" id="custom_person_select" onchange="autoFillPerson(this, 'custom_recipient_email', 'custom_recipient_name')">
                                        <option value="">-- Choose Candidate or Employee --</option>
                                        <?php if (!empty($candidates)): ?>
                                            <optgroup label="Candidates">
                                                <?php foreach ($candidates as $cand): ?>
                                                    <option value="<?= htmlspecialchars($cand['email']) ?>" data-name="<?= htmlspecialchars($cand['emp_name']) ?>">
                                                        <?= htmlspecialchars($cand['emp_name']) ?> (<?= htmlspecialchars($cand['email']) ?>)
                                                    </option>
                                                <?php endforeach; ?>
                                            </optgroup>
                                        <?php endif; ?>
                                        <?php if (!empty($employees)): ?>
                                            <optgroup label="Employees">
                                                <?php foreach ($employees as $emp): ?>
                                                    <option value="<?= htmlspecialchars($emp['email']) ?>" data-name="<?= htmlspecialchars($emp['emp_name']) ?>">
                                                        <?= htmlspecialchars($emp['emp_name']) ?> (<?= htmlspecialchars($emp['email']) ?>)
                                                    </option>
                                                <?php endforeach; ?>
                                            </optgroup>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                <?php endif; ?>

                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label class="font-weight-bold">Recipient Email <span class="text-danger">*</span></label>
                                        <input type="email" name="recipient_email" id="custom_recipient_email" class="form-control" placeholder="user@example.com" required>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="font-weight-bold">Recipient Name</label>
                                        <input type="text" name="recipient_name" id="custom_recipient_name" class="form-control" placeholder="e.g. Alex Johnson">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <label class="font-weight-bold mb-0">Subject Line <span class="text-danger">*</span></label>
                                        <select class="custom-select custom-select-sm w-auto" id="custom_preset_select" onchange="applySubjectPreset(this)">
                                            <option value="">-- Load Quick Preset --</option>
                                            <option value="announcement">Important Company Announcement</option>
                                            <option value="docs_request">Document Submission Reminder</option>
                                            <option value="interview_followup">Interview Follow-up</option>
                                            <option value="welcome">Welcome to Bloom Solutions!</option>
                                        </select>
                                    </div>
                                    <input type="text" name="subject" id="custom_subject" class="form-control" placeholder="Enter email subject line..." required>
                                </div>

                                <div class="form-group">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <label class="font-weight-bold mb-0">Message Body (HTML Supported) <span class="text-danger">*</span></label>
                                        <div class="btn-group btn-group-sm">
                                            <button type="button" class="btn btn-outline-secondary" onclick="insertTag('custom_message_body', '<b>', '</b>')"><b>B</b></button>
                                            <button type="button" class="btn btn-outline-secondary" onclick="insertTag('custom_message_body', '<i>', '</i>')"><i>I</i></button>
                                            <button type="button" class="btn btn-outline-secondary" onclick="insertTag('custom_message_body', '<ul>\n  <li>', '</li>\n</ul>')"><i class="fas fa-list-ul"></i></button>
                                            <button type="button" class="btn btn-outline-secondary" onclick="insertTag('custom_message_body', '<a href=\'#\'>', '</a>')"><i class="fas fa-link"></i></button>
                                            <button type="button" class="btn btn-outline-info" onclick="insertText('custom_message_body', '{recipient_name}')">{name}</button>
                                        </div>
                                    </div>
                                    <textarea name="message_body" id="custom_message_body" class="form-control" rows="8" placeholder="Type your message content here..." required></textarea>
                                </div>

                                <div class="form-group">
                                    <label class="font-weight-bold"><i class="fas fa-paperclip mr-1"></i> Attach File</label>
                                    <input type="file" name="attachment" class="form-control-file border p-2 rounded bg-light">
                                </div>

                                <hr>
                                <div class="d-flex justify-content-between align-items-center">
                                    <button type="button" class="btn btn-outline-info rounded-pill px-4" onclick="previewCustomMail()">
                                        <i class="fas fa-eye mr-1"></i> Live Preview
                                    </button>
                                    <button type="submit" class="btn btn-info px-4 font-weight-bold rounded-pill text-white">
                                        <i class="fas fa-paper-plane mr-1"></i> Dispatch Custom Email
                                    </button>
                                </div>
                            </form>
                        </div>


                        <!-- ==================== TAB 4: MAIL TEMPLATE EDITOR ==================== -->
                        <div class="tab-pane <?= ($active_tab == 'templates') ? 'active show' : '' ?>" id="tab-templates">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="card border shadow-none mb-3">
                                        <div class="card-header bg-light">
                                            <h5 class="card-title m-0 font-weight-bold text-dark">
                                                <i class="fas fa-edit text-warning mr-1"></i> Email Template Settings
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Select Template Category</label>
                                                <select class="form-control font-weight-bold text-primary" id="editor_category_select" onchange="loadSelectedTemplate(this.value)">
                                                    <option value="offer_letter">Offer Letter Template</option>
                                                    <option value="meet_invite">Google Meet Invite Template</option>
                                                    <option value="custom">General / Custom Mail Template</option>
                                                </select>
                                            </div>

                                            <form action="<?= base_url('admin/mail/save_template') ?>" method="POST" id="template_edit_form">
                                                <input type="hidden" name="category" id="editor_category" value="offer_letter">

                                                <div class="form-group">
                                                    <label class="font-weight-bold">Template Name</label>
                                                    <input type="text" name="template_name" id="editor_template_name" class="form-control" placeholder="e.g. Employment Offer Letter">
                                                </div>

                                                <div class="form-group">
                                                    <label class="font-weight-bold">Subject Line Template</label>
                                                    <input type="text" name="subject_template" id="editor_subject_template" class="form-control" placeholder="e.g. Job Offer Letter - {designation}">
                                                </div>

                                                <div class="form-group">
                                                    <label class="font-weight-bold">Insert Available Variable Tags</label>
                                                    <div class="d-flex flex-wrap gap-1 mb-2" id="tag_buttons_container">
                                                        <button type="button" class="btn btn-xs btn-outline-secondary m-1" onclick="insertText('editor_body_template', '{candidate_name}')">{candidate_name}</button>
                                                        <button type="button" class="btn btn-xs btn-outline-secondary m-1" onclick="insertText('editor_body_template', '{recipient_name}')">{recipient_name}</button>
                                                        <button type="button" class="btn btn-xs btn-outline-secondary m-1" onclick="insertText('editor_body_template', '{designation}')">{designation}</button>
                                                        <button type="button" class="btn btn-xs btn-outline-secondary m-1" onclick="insertText('editor_body_template', '{joining_date}')">{joining_date}</button>
                                                        <button type="button" class="btn btn-xs btn-outline-secondary m-1" onclick="insertText('editor_body_template', '{ctc}')">{ctc}</button>
                                                        <button type="button" class="btn btn-xs btn-outline-secondary m-1" onclick="insertText('editor_body_template', '{meet_url}')">{meet_url}</button>
                                                        <button type="button" class="btn btn-xs btn-outline-secondary m-1" onclick="insertText('editor_body_template', '{meeting_title}')">{meeting_title}</button>
                                                        <button type="button" class="btn btn-xs btn-outline-secondary m-1" onclick="insertText('editor_body_template', '{meeting_date}')">{meeting_date}</button>
                                                        <button type="button" class="btn btn-xs btn-outline-secondary m-1" onclick="insertText('editor_body_template', '{meeting_time}')">{meeting_time}</button>
                                                        <button type="button" class="btn btn-xs btn-outline-secondary m-1" onclick="insertText('editor_body_template', '{agenda}')">{agenda}</button>
                                                        <button type="button" class="btn btn-xs btn-outline-secondary m-1" onclick="insertText('editor_body_template', '{company_name}')">{company_name}</button>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="font-weight-bold">HTML Body Template</label>
                                                    <textarea name="body_template" id="editor_body_template" class="form-control font-monospace" rows="14" style="font-family: monospace; font-size: 13px;" oninput="updateTemplateLivePreview()" required></textarea>
                                                </div>

                                                <button type="submit" class="btn btn-warning px-4 font-weight-bold text-dark rounded-pill">
                                                    <i class="fas fa-save mr-1"></i> Save Email Template
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="card border shadow-none">
                                        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                                            <h5 class="card-title m-0 font-weight-bold" style="font-size: 15px;">
                                                <i class="fas fa-desktop mr-1"></i> Live Rendered HTML Preview
                                            </h5>
                                            <span class="badge badge-warning text-dark">Real-time</span>
                                        </div>
                                        <div class="card-body p-2 bg-light" style="min-height: 550px;">
                                            <iframe id="template_preview_iframe" style="width: 100%; height: 550px; border: none; background: #fff; border-radius: 4px;"></iframe>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- ==================== UNIVERSAL LIVE PREVIEW MODAL ==================== -->
<div class="modal fade" id="previewMailModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title font-weight-bold" id="previewModalTitle">
                    <i class="fas fa-search mr-1"></i> Email Template Live Preview
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-0" style="background: #f8f9fa;">
                <iframe id="previewModalIframe" style="width: 100%; height: 500px; border: none;"></iframe>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary rounded-pill px-4" data-dismiss="modal">Close Preview</button>
            </div>
        </div>
    </div>
</div>

<script>
// Dynamic tab switcher and URL sync
function switchTabTo(targetHref, category) {
    // 1. Update tab nav link headers
    $('#mailCategoryTabs a').removeClass('active');
    $('#mailCategoryTabs a[href="' + targetHref + '"]').addClass('active');

    // 2. Update tab pane contents
    $('.tab-pane').removeClass('active show');
    $(targetHref).addClass('active show');

    // 3. Update URL in address bar without reloading
    if (history.pushState) {
        var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + '?tab=' + category + targetHref;
        window.history.pushState({path: newurl}, '', newurl);
    }
}

document.addEventListener('DOMContentLoaded', function() {
    // Attach click handler to all category tabs
    $('#mailCategoryTabs a').on('click', function(e) {
        e.preventDefault();
        var targetHref = $(this).attr('href');
        var category = $(this).data('category') || 'offer_letter';
        switchTabTo(targetHref, category);
    });

    // Handle initial load based on URL hash or ?tab= query parameter
    var hash = window.location.hash;
    var params = new URLSearchParams(window.location.search);
    var tabParam = params.get('tab');

    if (hash && document.querySelector('#mailCategoryTabs a[href="' + hash + '"]')) {
        var cat = document.querySelector('#mailCategoryTabs a[href="' + hash + '"]').getAttribute('data-category');
        switchTabTo(hash, cat);
    } else if (tabParam) {
        var targetHash = '#tab-offer';
        if (tabParam === 'meet_invite') targetHash = '#tab-meet';
        else if (tabParam === 'custom') targetHash = '#tab-custom';
        else if (tabParam === 'templates') targetHash = '#tab-templates';
        switchTabTo(targetHash, tabParam);
    }

    // Load initial template editor data
    var initialCategory = document.getElementById('editor_category_select').value;
    loadSelectedTemplate(initialCategory);
});

function autoFillPerson(selectObj, emailElemId, nameElemId) {
    var selectedOption = selectObj.options[selectObj.selectedIndex];
    var email = selectedOption.value;
    var name = selectedOption.getAttribute('data-name');
    if (email) {
        document.getElementById(emailElemId).value = email;
        document.getElementById(nameElemId).value = name || '';
    }
}

function insertText(elemId, textToInsert) {
    var txtarea = document.getElementById(elemId);
    if (!txtarea) return;
    var start = txtarea.selectionStart;
    var end = txtarea.selectionEnd;
    var text = txtarea.value;
    txtarea.value = text.substring(0, start) + textToInsert + text.substring(end);
    txtarea.selectionStart = txtarea.selectionEnd = start + textToInsert.length;
    txtarea.focus();

    if (elemId === 'editor_body_template') {
        updateTemplateLivePreview();
    }
}

function insertTag(elemId, startTag, endTag) {
    var txtarea = document.getElementById(elemId);
    if (!txtarea) return;
    var start = txtarea.selectionStart;
    var end = txtarea.selectionEnd;
    var selectedText = txtarea.value.substring(start, end) || 'Sample Text';
    var replacement = startTag + selectedText + endTag;
    txtarea.value = txtarea.value.substring(0, start) + replacement + txtarea.value.substring(end);
    txtarea.focus();
}

function applySubjectPreset(selectObj) {
    var val = selectObj.value;
    var subjElem = document.getElementById('custom_subject');
    var bodyElem = document.getElementById('custom_message_body');

    if (val === 'announcement') {
        subjElem.value = 'Important Announcement from Bloom Solutions';
        bodyElem.value = '<p>Please be advised of the following important updates regarding our organization:</p>\n<ul>\n  <li>Update 1: Scheduled maintenance window on Friday.</li>\n  <li>Update 2: New HR portal policies published.</li>\n</ul>\n<p>Reach out to the HR desk if you have any questions.</p>';
    } else if (val === 'docs_request') {
        subjElem.value = 'Action Required: Pending Document Submission Reminder';
        bodyElem.value = '<p>This is a gentle reminder to submit your pending onboarding documents at your earliest convenience.</p>\n<p>Required Documents:</p>\n<ul>\n  <li>Government Identification Copy</li>\n  <li>Relieving Letter / Past Experience Certificate</li>\n</ul>\n<p>Please upload them through your candidate login portal.</p>';
    } else if (val === 'interview_followup') {
        subjElem.value = 'Interview Status Update - Bloom Solutions';
        bodyElem.value = '<p>Thank you for taking the time to interview with Bloom Solutions.</p>\n<p>We appreciated learning more about your background and experience. Our hiring committee is reviewing candidate evaluations, and we will update you on the next steps shortly.</p>';
    } else if (val === 'welcome') {
        subjElem.value = 'Welcome to Bloom Solutions!';
        bodyElem.value = '<p>We are excited to welcome you to the Bloom Solutions team!</p>\n<p>Your journey with us officially begins soon. Attached to this email are your orientation schedule and introductory guidance notes.</p>';
    }
}

// Load Mail Template in Editor
function loadSelectedTemplate(category) {
    document.getElementById('editor_category').value = category;

    fetch('<?= base_url("admin/mail/get_template") ?>/' + category)
        .then(function(res) { return res.json(); })
        .then(function(data) {
            if (data && !data.error) {
                document.getElementById('editor_template_name').value = data.template_name || '';
                document.getElementById('editor_subject_template').value = data.subject_template || '';
                document.getElementById('editor_body_template').value = data.body_template || '';
                updateTemplateLivePreview();
            }
        })
        .catch(function(err) {
            console.log('Error loading template', err);
        });
}

function updateTemplateLivePreview() {
    var rawHtml = document.getElementById('editor_body_template').value;
    var iframe = document.getElementById('template_preview_iframe');
    if (!iframe) return;

    var rendered = rawHtml
        .replace(/{candidate_name}/g, 'John Doe')
        .replace(/{recipient_name}/g, 'Alex Smith')
        .replace(/{designation}/g, 'Senior Software Engineer')
        .replace(/{joining_date}/g, '<?= date("Y-m-d", strtotime("+7 days")) ?>')
        .replace(/{ctc}/g, '₹ 8,50,000 LPA')
        .replace(/{meet_url}/g, 'https://meet.google.com/abc-defg-hij')
        .replace(/{meeting_title}/g, 'Technical Interview - Round 1')
        .replace(/{meeting_date}/g, '<?= date("Y-m-d") ?>')
        .replace(/{meeting_time}/g, '11:00 AM')
        .replace(/{agenda}/g, 'Discuss system architecture and team alignment.')
        .replace(/{company_name}/g, 'Bloom Solutions')
        .replace(/{subject}/g, 'Sample Mail Subject')
        .replace(/{custom_notes_section}/g, '<div style="margin-bottom: 20px;"><p><strong>Additional Details:</strong></p><p>Please bring original ID proofs on day 1.</p></div>');

    var doc = iframe.contentDocument || iframe.contentWindow.document;
    doc.open();
    doc.write(rendered);
    doc.close();
}

// Live Preview Modals for send forms
function previewOfferLetter() {
    var name = document.getElementById('offer_candidate_name').value || 'John Doe';
    var desig = document.getElementById('offer_designation').value || 'Software Engineer';
    var date = document.getElementById('offer_joining_date').value || '<?= date("Y-m-d", strtotime("+7 days")) ?>';
    var ctc = document.getElementById('offer_ctc').value || '₹ 6,00,000 LPA';
    var notes = document.getElementById('offer_custom_notes').value || '';

    fetch('<?= base_url("admin/mail/get_template/offer_letter") ?>')
        .then(res => res.json())
        .then(data => {
            var raw = (data && data.body_template) ? data.body_template : '';
            var notesSection = notes ? '<div style="margin-bottom: 20px;"><p><strong>Additional Details:</strong></p><p>' + notes + '</p></div>' : '';
            var html = raw
                .replace(/{candidate_name}/g, name)
                .replace(/{recipient_name}/g, name)
                .replace(/{designation}/g, desig)
                .replace(/{joining_date}/g, date)
                .replace(/{ctc}/g, ctc)
                .replace(/{custom_notes_section}/g, notesSection)
                .replace(/{company_name}/g, 'Bloom Solutions');

            showModalPreview('Offer Letter Live Preview', html);
        });
}

function previewMeetInvite() {
    var name = document.getElementById('meet_recipient_name').value || 'Jane Smith';
    var title = document.getElementById('meet_title').value || 'Bloom Solutions - Interview Session';
    var url = document.getElementById('meet_url').value || 'https://meet.google.com/abc-defg-hij';
    var date = document.getElementById('meet_date').value || '<?= date("Y-m-d") ?>';
    var time = document.getElementById('meet_time').value || '10:00 AM';
    var agenda = document.getElementById('meet_agenda').value || 'Discussion regarding upcoming opportunities.';

    fetch('<?= base_url("admin/mail/get_template/meet_invite") ?>')
        .then(res => res.json())
        .then(data => {
            var raw = (data && data.body_template) ? data.body_template : '';
            var html = raw
                .replace(/{recipient_name}/g, name)
                .replace(/{candidate_name}/g, name)
                .replace(/{meeting_title}/g, title)
                .replace(/{meet_url}/g, url)
                .replace(/{meeting_date}/g, date)
                .replace(/{meeting_time}/g, time)
                .replace(/{agenda}/g, agenda)
                .replace(/{company_name}/g, 'Bloom Solutions');

            showModalPreview('Google Meet Invitation Live Preview', html);
        });
}

function previewCustomMail() {
    var name = document.getElementById('custom_recipient_name').value || 'Alex Johnson';
    var subj = document.getElementById('custom_subject').value || 'Notification';
    var body = document.getElementById('custom_message_body').value || 'Sample custom message content...';

    fetch('<?= base_url("admin/mail/get_template/custom") ?>')
        .then(res => res.json())
        .then(data => {
            var raw = (data && data.body_template) ? data.body_template : '';
            var html = raw
                .replace(/{recipient_name}/g, name)
                .replace(/{subject}/g, subj)
                .replace(/{message_body}/g, body)
                .replace(/{company_name}/g, 'Bloom Solutions');

            showModalPreview('Custom Mail Live Preview', html);
        });
}

function showModalPreview(title, htmlContent) {
    document.getElementById('previewModalTitle').innerHTML = '<i class="fas fa-search mr-1"></i> ' + title;
    var iframe = document.getElementById('previewModalIframe');
    var doc = iframe.contentDocument || iframe.contentWindow.document;
    doc.open();
    doc.write(htmlContent);
    doc.close();
    $('#previewMailModal').modal('show');
}
</script>
