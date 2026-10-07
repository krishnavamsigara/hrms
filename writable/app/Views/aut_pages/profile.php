
<?php
$current_address = json_decode($profile['current_address'], true);

$perminent_address = json_decode($profile['perminent_address'], true);

$documents = json_decode($profile['documents'] ?? '{}', true);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bloom Solution | My Profile</title>
  
  <style>
    :root {
        --bloom-purple: #4a00e0;
        --bloom-dark: #2a0080;
        --mtn-deep: #120038;
        --bloom-orange: #e46c44;
        --bloom-success: #10b981;
        --bloom-danger: #dc2626;
        --glass: rgba(255, 255, 255, 0.95);
    }

    body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8fafc; font-size: 13px; color: #334155; }

    /* --- NAVIGATION & SIDEBAR --- */
    .main-header { border-bottom: 1px solid #e2e8f0 !important; background: var(--glass) !important; backdrop-filter: blur(10px); }
    .main-sidebar { background: var(--mtn-deep) !important; box-shadow: 4px 0 10px rgba(0,0,0,0.03) !important; }
    .nav-link.active { background: var(--bloom-purple) !important; box-shadow: 0 4px 15px rgba(74, 0, 224, 0.3); }

    /* --- SIDEBAR BRANDING --- */
    .custom-brand { display:flex; align-items:center; padding:12px 16px; border-bottom:1px solid rgba(255,255,255,0.08); }
    .logo-circle { width:42px; height:42px; border-radius:50%; object-fit:cover; border:2px solid #fff; margin-right:10px; }
    .brand-text { font-size:18px; font-weight:700; }
    .brand-blue { color:#4a8cff; }
    .brand-orange { color:#ff7a45; }

    /* --- PROFILE HEADER --- */
    .profile-header-banner {
      height: 200px;
      background: linear-gradient(135deg, var(--mtn-deep) 0%, var(--bloom-purple) 100%);
      border-radius: 0 0 40px 40px;
      position: relative;
      margin-bottom: 90px;
    }

    .profile-main-card {
      position: absolute;
      bottom: -70px;
      left: 5%;
      right: 5%;
      background: var(--glass);
      backdrop-filter: blur(10px);
      border-radius: 24px;
      padding: 30px;
      display: flex;
      align-items: center;
      border: 1px solid rgba(255,255,255,0.4);
      box-shadow: 0 20px 40px rgba(18, 0, 56, 0.08);
    }

    .profile-image-wrap {
      width: 130px; height: 130px; border-radius: 20px;
      background: #fff; padding: 5px; margin-right: 30px;
      box-shadow: 0 10px 25px rgba(0,0,0,0.05);
    }
    .profile-image-wrap img { width: 100%; height: 100%; border-radius: 16px; object-fit: cover; }

    /* --- INFO CARDS --- */
    .info-card {
      background: #fff;
      border-radius: 20px;
      padding: 25px;
      border: 1px solid #e2e8f0;
      height: 100%;
      transition: 0.3s ease;
    }
    .info-card:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(0,0,0,0.02); }

    .section-head {
      font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 1.5px;
      color: var(--bloom-purple); margin-bottom: 20px; display: block;
      border-left: 3px solid var(--bloom-purple); padding-left: 12px;
    }

    .item-label { font-size: 10px; font-weight: 600; color: #94a3b8; text-transform: uppercase; display: block; }
    .item-value { font-size: 13px; font-weight: 700; color: var(--mtn-deep); }
    .address-box { background: #f8fafc; padding: 15px; border-radius: 15px; margin-top: 15px; border: 1px dashed #cbd5e1; }

    /* --- FOOTER CUSTOM --- */
    .main-footer { background: #fff !important; border-top: 1px solid #e2e8f0 !important; color: #64748b; font-size: 12px; padding: 1rem 1.5rem !important; }
    .footer-link { color: var(--bloom-purple); font-weight: 600; text-decoration: none; }

    @keyframes pulse {
      0% { transform: scale(1); }
      50% { transform: scale(1.03); box-shadow: 0 8px 25px rgba(228, 108, 68, 0.6); }
      100% { transform: scale(1); }
    }
  </style>


    <ul class="navbar-nav ml-auto align-items-center">
      <li class="nav-item dropdown">
      <!-- <a class="nav-link d-flex align-items-center" data-toggle="dropdown" href="#">
        <img src="https://ui-avatars.com/api/?name=<?= urlencode($profile['emp_name']); ?>&background=4a00e0&color=fff"
             class="rounded-circle shadow-sm"
             style="width: 32px; border: 2px solid #fff;">
        <span class="ml-2 d-none d-sm-inline-block font-weight-bold text-dark">
          <?= session()->get('emp_name'); ?>
        </span>
      </a> -->

      <div class="dropdown-menu dropdown-menu-right border-0 shadow-lg mt-2" style="border-radius:12px;">
        <a href="../aut_pages/profile.html" class="dropdown-item">
          <i class="fas fa-user mr-2"></i> Profile
        </a>

        <div class="dropdown-divider"></div>

       <a href="<?= base_url('logout') ?>" class="dropdown-item text-danger">
              <i class="fas fa-power-off mr-2"></i> Logout
            </a>
      </div>
    </li>
    </ul>
  </nav>


  <div class="content-wrapper">
    
    <div class="profile-header-banner">
      <div class="profile-main-card">
        <div class="profile-image-wrap">
    <?php if (!empty($documents['profile_photo'])) : ?>
        <img src="<?= base_url($documents['profile_photo']); ?>"
             alt="Profile Photo">
    <?php else : ?>
        <img src="https://ui-avatars.com/api/?name=<?= urlencode($profile['emp_name']); ?>&background=4a00e0&color=fff&size=200">
    <?php endif; ?>
</div>
        <div class="flex-grow-1">
          <h2 class="font-weight-bold mb-1" style="color: var(--mtn-deep);"><?= esc($profile['emp_name'] ?? 'N/A'); ?></h2>
          <p class="mb-3 text-muted">
            <span class="badge badge-pill" style="background: rgba(74, 0, 224, 0.1); color: var(--bloom-purple); padding: 5px 12px;"><?= esc($profile['emp_id']); ?></span>
            <span class="mx-2">•</span>
            <i class="fas fa-calendar-alt mr-1"></i>
            Joined <?= !empty($profile['joining_date']) ? date('d F Y', strtotime($profile['joining_date'])) : '-' ?>
          </p>
          <div class="d-flex align-items-center">
             <div class="mr-4 text-center" style="border-right: 1px solid #eee; padding-right: 20px;">
                <span class="item-label">Reporting To</span>
                <span class="item-value"><?= esc($profile['reporting'] ?? 'N/A'); ?></span>
             </div>
             <div class="mr-4 text-center" style="border-right: 1px solid #eee; padding-right: 20px;">
                <span class="item-label">Work Location</span>
                <span class="item-value"><i class="fas fa-location-dot text-danger mr-1"></i>Hyderabad</span>
                </div>
               <div class="mr-4 text-center" style="border-right: 1px solid #eee; padding-right: 20px;">
                <span class="item-label">Designation</span>
                <span class="item-value">
                    <?= !empty($profile['designation_name']) ? esc($profile['designation_name']) : '-' ?>
                </span>
             </div>
             <div class="mr-4 text-center" style="border-right: 1px solid #eee; padding-right: 20px;">
                <span class="item-label">Department</span>
                <span class="item-value">
                    <?= !empty($profile['department_name']) ? esc($profile['department_name']) : '-' ?>
                </span>
            </div>
             
          </div>
        </div>

<?php if (
    strtolower($profile['at_blooms'] ?? '') === 'true' &&
    strtolower($profile['profisional_details_status'] ?? '') === 'active'
) : ?>
 <div class="ml-auto d-none d-md-block">
    <a href="<?= base_url('profile_updation') ?>"
       class="btn px-4 font-weight-bold"
       style="background: var(--bloom-orange); color: white; border-radius:12px; border:none; box-shadow: 0 6px 20px rgba(228, 108, 68, 0.4); text-decoration: none; animation: pulse 2s infinite;">
        <i class="fas fa-user-edit mr-2"></i> Profile Updation
    </a>
</div>
<?php endif; ?>
      </div>
    </div>

    <section class="content">
      <div class="container-fluid px-4 pb-5">
        <div class="row">
          <div class="col-lg-4 mb-4">
            <div class="info-card">
              <span class="section-head">Personal Details</span>
              <div class="mb-3"><span class="item-label">Email Address</span><span class="item-value"><?= esc($profile['email']); ?></span></div>
              <div class="mb-3"><span class="item-label">Phone</span><span class="item-value"><?= esc($profile['mobile']); ?></span></div>
              <div class="row">
                  <div class="col-6"><span class="item-label">Birthday</span><span class="item-value"><?= date('d M Y', strtotime($profile['dob'])); ?></span></div>
                   <!-- <div class="col-6"><span class="item-label">PAN Number</span><span class="item-value"><?= esc($profile['pan']); ?></span></div>
              <div class="col-6"><span class="item-label">Aadhaar Card</span><span class="item-value"><?= esc($profile['aadhaar']); ?></span></div> -->
                  <div class="col-6"><span class="item-label">Gender</span><span class="item-value"><?= ucfirst($profile['gender']); ?></span></div>
              </div>
<div class="address-box">
    <span class="item-label">Current Residence</span>
<span class="item-value" style="word-break: break-word; line-height:1.5;">
<?php
$line1 = [];
$line2 = [];

if (!empty($current_address['houseNo'])) {
    $line1[] = $current_address['houseNo'];
}

if (!empty($current_address['area'])) {
    $line1[] = $current_address['area'];
}

if (!empty($current_address['streetNo'])) {
    $line1[] = $current_address['streetNo'];
}

if (!empty($current_address['city'])) {
    $line2[] = $current_address['city'];
}

if (!empty($current_address['state'])) {
    $line2[] = $current_address['state'];
}

if (!empty($current_address['pin_code'])) {
    $line2[] = $current_address['pin_code'];
}
?>

<span style="color:#1f2937;">
    <?= esc(implode(', ', $line1)) ?>
</span><?php if (!empty($line1) && !empty($line2)) echo ', '; ?>

<strong style="color:#1f2937;">
    <?= esc(implode(', ', $line2)) ?>
</strong>
</span>

</div>
            </div>
          </div>

         <div class="col-lg-4 mb-4">
    <div class="info-card" style="border-top: 4px solid #003399 !important;">

        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:15px;">
            <span class="section-head">Bank & Statutory</span>

            <button type="button"
                    id="toggleSensitiveData"
                    style="border:none;background:none;color:#003399;font-size:18px;cursor:pointer;">
                <i class="fas fa-eye"></i>
            </button>
        </div>

        <div class="row">

            <div class="col-6 mb-3">
                <span class="item-label">Bank Name</span>
                <span class="item-value sensitive-field"
                      data-value="<?= esc($profile['bank_name'] ?? 'N/A'); ?>">
                    ••••••••
                </span>
            </div>

            <div class="col-6 mb-3">
                <span class="item-label">Account No</span>
                <span class="item-value sensitive-field"
                      data-value="<?= esc($profile['bank_account_no'] ?? 'N/A'); ?>">
                    ••••••••
                </span>
            </div>

            <div class="col-6 mb-3">
                <span class="item-label">IFSC Code</span>
                <span class="item-value sensitive-field"
                      data-value="<?= esc($profile['ifsc'] ?? 'N/A'); ?>">
                    ••••••••
                </span>
            </div>

            <div class="col-6 mb-3">
                <span class="item-label">Aadhaar No</span>
                <span class="item-value sensitive-field"
                      data-value="<?= esc($profile['aadhaar'] ?? 'N/A'); ?>">
                    ••••••••
                </span>
            </div>

            <div class="col-6 mb-3">
                <span class="item-label">PAN No</span>
                <span class="item-value sensitive-field"
                      data-value="<?= esc($profile['pan'] ?? 'N/A'); ?>">
                    ••••••••
                </span>
            </div>

            <div class="col-6 mb-3">
                <span class="item-label">PF Account No</span>
                <span class="item-value sensitive-field"
                      data-value="<?= esc($profile['pf_account_no'] ?? 'N/A'); ?>">
                    ••••••••
                </span>
            </div>

            <div class="col-6 mb-3">
                <span class="item-label">UAN No</span>
                <span class="item-value sensitive-field"
                      data-value="<?= esc($profile['uan'] ?? 'N/A'); ?>">
                    ••••••••
                </span>
            </div>

            <div class="col-6 mb-3">
                <span class="item-label">ESIC No</span>
                <span class="item-value sensitive-field"
                      data-value="<?= esc($profile['esic_no'] ?? 'N/A'); ?>">
                    ••••••••
                </span>
            </div>

        </div>
    </div>
</div>         

<div class="col-lg-4 mb-4">
    <div class="info-card">
        <span class="section-head">Education</span>

        <?php
        $education = json_decode($profile['qualification'] ?? '', true);
        

if (is_string($education)) {
    $education = json_decode($education, true);
}

if (!is_array($education)) {
    $education = [];
}
// If qualification is a single object, convert it first
if (isset($education['degree'])) {
    $education = [$education];
}

$higherEducation = [];
$graduation = [];
$intermediate = [];
$tenth = [];

foreach ($education as $edu) {

    $type = strtolower(trim($edu['education_type'] ?? ''));

    if ($type == 'graduation') {
        $graduation[] = $edu;
    } elseif ($type == 'intermediate') {
        $intermediate[] = $edu;
    } elseif ($type == '10th') {
        $tenth[] = $edu;
    } else {
        $higherEducation[] = $edu;
    }
}

$education = array_merge(
    $higherEducation,
    $graduation,
    $intermediate,
    $tenth
);
$leftEducation = array_slice($education, 0, 3);
$rightEducation = array_slice($education, 3);

        if (!empty($education)) : ?>

<div class="row">

    <div class="col-md-6">

        <?php foreach ($leftEducation as $edu) : ?>
        

 <div class="mb-3">

    <span class="item-value d-block font-weight-bold text-dark mb-1">
        <?=
        esc(
            $edu['education_type']
            ?? $edu['degree']
            ?? 'Education'
        )
        ?>
    </span>

    <small class="text-muted d-block">
        <?=
        esc(
            $edu['institution']
            ?? $edu['college']
            ?? 'N/A'
        )
        ?>

        <?php if (!empty($edu['specialization'])) : ?>
            - <?= esc($edu['specialization']) ?>
        <?php elseif (!empty($edu['branch'])) : ?>
            - <?= esc($edu['branch']) ?>
        <?php endif; ?>
    </small>

    <small class="text-muted d-block">
        Year:
        <?= esc($edu['year_of_pass'] ?? $edu['year'] ?? 'N/A') ?>
    </small>

</div>

      <?php endforeach; ?>

    </div> <!-- Left Column Ends -->

    <div class="col-md-6">

        <?php foreach ($rightEducation as $edu) : ?>

        <div class="mb-3">

            <span class="item-value d-block font-weight-bold text-dark mb-1">
                <?= esc($edu['education_type'] ?? $edu['degree'] ?? 'Education') ?>
            </span>

            <small class="text-muted d-block">
                <?= esc($edu['institution'] ?? $edu['college'] ?? 'N/A') ?>

                <?php if (!empty($edu['specialization'])) : ?>
                    - <?= esc($edu['specialization']) ?>
                <?php elseif (!empty($edu['branch'])) : ?>
                    - <?= esc($edu['branch']) ?>
                <?php endif; ?>
            </small>

            <small class="text-muted d-block">
                Year: <?= esc($edu['year_of_pass'] ?? $edu['year'] ?? 'N/A') ?>
            </small>

        </div>

        <?php endforeach; ?>

    </div> <!-- Right Column Ends -->

</div> <!-- Row Ends -->

<?php else : ?>

    <span class="item-value">No Education Details Found</span>

<?php endif; ?>

</div>
</div>
<?php
$experience = json_decode($profile['experience'] ?? '', true);

if (is_string($experience)) {
    $experience = json_decode($experience, true);
}

$isExperienced = !empty($experience)
    && is_array($experience)
    && (($experience[0]['experience_type'] ?? '') !== 'FRESHER');
?>

<?php if ($isExperienced) : ?>
<div class="col-lg-4 mb-4">
    <div class="info-card">
        <span class="section-head">Experience</span>

        <?php foreach ($experience as $exp) : ?>
            <div class="mb-3">
                <span class="item-value d-block">
                    <?= esc($exp['company_name'] ?? 'N/A') ?>
                </span>

                <small class="d-block text-muted">
                    <?= esc($exp['designation'] ?? 'N/A') ?>
                </small>

                <small class="d-block text-muted">
                    <?= esc($exp['total_experience'] ?? 'N/A') ?>
                </small>

                <small class="d-block text-muted">
                    <?= date('Y', strtotime($exp['start_date'])) ?>
                    -
                    <?= date('y', strtotime($exp['end_date'])) ?>
                </small>
            </div>
        <?php endforeach; ?>

    </div>
</div>
<?php endif; ?>

<?php if ($isExperienced) : ?>

<div class="col-lg-4 mb-4">
    <div class="info-card" style="border-top: 4px solid #003399 !important;">

        <span class="section-head">Career & Skills</span>

        <div class="mb-4">
            <span class="item-label mb-2">Technical proficiency</span>

            <div class="d-flex flex-wrap" style="gap: 5px;">

                <?php
                $skills = [];

                $experience = json_decode($profile['experience'] ?? '', true);

                if (is_string($experience)) {
                    $experience = json_decode($experience, true);
                }

                if (is_array($experience)) {
                    foreach ($experience as $exp) {
                        if (!empty($exp['skills'])) {
                            $skills = array_merge($skills, explode(',', $exp['skills']));
                        }
                    }
                }

                $skills = array_unique(array_map('trim', $skills));

                foreach ($skills as $skill) :
                ?>
                    <span class="badge badge-light border">
                        <?= esc($skill); ?>
                    </span>
                <?php endforeach; ?>

            </div>
        </div>

    </div>
</div>

<?php endif; ?>
           
          </div>
        </div>
      </div>
    </section>
  </div>

  
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
<script>
let visible = false;

document.getElementById("toggleSensitiveData").addEventListener("click", function () {

    visible = !visible;

    document.querySelectorAll(".sensitive-field").forEach(field => {

        if (visible) {
            field.textContent = field.dataset.value;
        } else {
            field.textContent = "••••••••";
        }

    });

    this.innerHTML = visible
        ? '<i class="fas fa-eye-slash"></i>'
        : '<i class="fas fa-eye"></i>';
});
</script>
</body>
</html>