<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bloom Solutions | Add Employee</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">

    <style>
        :root {
            --bloom-purple: #4a00e0;
            --bloom-dark: #120038;
            --bloom-orange: #e46c44;
            --bloom-success: #10b981;
            --bloom-danger: #dc2626;
            --mtn-deep: #120038;
            --soft-gray: #f8fafc;
            --border-color: #e2e8f0;
            --glass: rgba(255, 255, 255, 0.75);
        }

        body { 
            font-family: 'Plus Jakarta Sans', sans-serif;  
            background-color: var(--soft-gray); 
            font-size: 13px; 
            color: #334155; 
        }

        .content-wrapper {
            padding-top: 90px;
            padding-bottom: 60px;
            background-color: var(--soft-gray);
        }
        .logo-circle{
width:42px;
height:42px;
border-radius:50%;
object-fit:cover;
border:2px solid #fff;
margin-right:10px;
}


        /* --- PREMIUM CARDS --- */
        .card-bloom {
            border: 1px solid var(--border-color) !important;
            border-radius: 20px !important;
            background: #fff;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.04) !important;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            margin-bottom: 20px;
            padding: 1.5rem;
            width: 100%;
            position: relative;
        }

        .section-title {
            font-weight: 700;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--bloom-purple);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
        }

        .section-title i { margin-right: 10px; }

        /* --- FORM STYLING --- */
        label { font-weight: 600; color: #475569; margin-bottom: 6px; }
        
        .form-control {
            border-radius: 10px;
            border: 1px solid var(--border-color);
            padding: 10px 15px;
            font-size: 13px;
            transition: 0.2s;
        }

        .form-control:focus {
            border-color: var(--bloom-purple);
            box-shadow: 0 0 0 3px rgba(74, 0, 224, 0.1);
        }

        /* --- SKILLS TAGS --- */
        .skills-container {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            padding: 8px;
            border: 1px solid var(--border-color);
            border-radius: 10px;
            background: #fff;
        }

        .skill-tag {
            background: #eef2ff;
            color: var(--bloom-purple);
            padding: 4px 12px;
            border-radius: 8px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .skill-tag i { cursor: pointer; font-size: 10px; }

        #skillInput { border: none; outline: none; flex: 1; min-width: 100px; }

        /* --- PROFILE UPLOAD --- */
        .profile-upload-wrapper {
            width: 110px;
            height: 110px;
            border-radius: 50%;
            background: var(--soft-gray);
            border: 2px dashed var(--border-color);
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            overflow: hidden;
            position: relative;
        }

        #imagePreview { width: 100%; height: 100%; object-fit: cover; display: none; }

        /* --- NAVIGATION --- */
        .main-header { 
            border-bottom: 1px solid #e2e8f0 !important; 
            background: var(--glass) !important; 
            backdrop-filter: blur(12px); 
        }

        .brand-link .brand-blue { color: #4a8cff; }
        .brand-link .brand-orange { color: #ff7a45; }

        /* --- BUTTONS --- */
        .btn-save {
            background: var(--bloom-purple);
            color: white;
            border-radius: 10px;
            font-weight: 700;
            padding: 12px 30px;
            border: none;
        }

        .btn-save:hover { background: var(--bloom-dark); color: white; transform: translateY(-2px); }
    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <nav class="main-header navbar navbar-expand navbar-white navbar-light shadow-sm fixed-top">

  <ul class="navbar-nav align-items-center">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
    </li>

    <li class="nav-item d-none d-sm-inline-block ml-2">
      <h5 class="mb-0 font-weight-bold" style="color: var(--mtn-deep);">
        Hello, <span style="color: var(--bloom-purple);">Ishu</span> 👋
      </h5>
    </li>
  </ul>

  <ul class="navbar-nav ml-auto align-items-center">
        <!-- Role Switcher -->
        <li class="nav-item mr-3 d-none d-sm-inline-block">
          <a href="../empolyee/dashboard.html" class="btn btn-sm" style="background-color: #eef2ff; color: var(--bloom-purple); font-weight: 600; border-radius: 8px; border: 1px solid #c7d2fe;">
            <i class="fas fa-exchange-alt mr-1"></i> Switch to Employee
          </a>
        </li>
        <!-- Messages -->
    <li class="nav-item dropdown">
      <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="far fa-comments"></i>
        <span class="badge badge-danger navbar-badge">3</span>
      </a>

      <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right shadow">
        
        <a href="#" class="dropdown-item">
          <div class="media">
            <img src="https://ui-avatars.com/api/?name=Rahul" class="img-size-40 mr-3 img-circle">
            <div class="media-body">
              <h3 class="dropdown-item-title">
                Rahul
                <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
              </h3>
              <p class="text-sm">Leave approved 👍</p>
              <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 5 mins</p>
            </div>
          </div>
        </a>

        <div class="dropdown-divider"></div>

        <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>

      </div>
    </li>

    <!-- Leave Notifications -->
    <li class="nav-item dropdown">
      <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="far fa-bell"></i>
        <span class="badge badge-warning navbar-badge">2</span>
      </a>

      <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right shadow">

        <span class="dropdown-header">2 Leave Notifications</span>

        <div class="dropdown-divider"></div>

        <a href="#" class="dropdown-item">
          <i class="fas fa-user-clock mr-2 text-primary"></i>
          New Leave Request
          <span class="float-right text-muted text-sm">10 mins</span>
        </a>

        <div class="dropdown-divider"></div>

        <a href="#" class="dropdown-item">
          <i class="fas fa-check-circle mr-2 text-success"></i>
          Leave Approved
          <span class="float-right text-muted text-sm">1 hour</span>
        </a>

        <div class="dropdown-divider"></div>

        <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>

      </div>
    </li>

    <!-- Profile -->
    <li class="nav-item dropdown">
      <a class="nav-link d-flex align-items-center" data-toggle="dropdown" href="#">
        <img src="https://ui-avatars.com/api/?name=Aishwarya&background=4a00e0&color=fff"
             class="rounded-circle shadow-sm"
             style="width: 32px; border: 2px solid #fff;">
        <span class="ml-2 d-none d-sm-inline-block font-weight-bold text-dark">
          Aishwarya
        </span>
      </a>

      <div class="dropdown-menu dropdown-menu-right border-0 shadow-lg mt-2" style="border-radius:12px;">
        <a href="profile.html" class="dropdown-item">
          <i class="fas fa-user mr-2"></i> Profile
        </a>

        <div class="dropdown-divider"></div>

        <a href="#" class="dropdown-item text-danger">
          <i class="fas fa-power-off mr-2"></i> Logout
        </a>
      </div>
    </li>

  </ul>

</nav>
          <aside class="main-sidebar sidebar-dark-primary elevation-0" style="background-color: #111c43;">
      <a href="#" class="brand-link border-0" style="background-color: #111c43;">
        <img src="../dist/img/bloom.jpg" alt="Logo" class="brand-image img-circle">
        <span class="brand-text font-weight-bold">
          <span style="color:#4a8cff;">Bloom</span> <span style="color:#ff7a45;">Solutions</span>
        </span>
      </a>

      <div class="sidebar">
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu">


            <li class="nav-item">
              <a href="dashboard.html" class="nav-link">
                <i class="nav-icon fas fa-home"></i>
                <p>Dashboard</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="calender.html" class="nav-link">
                <i class="nav-icon far fa-calendar-alt"></i>
                <p>My Calendar</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="deparment.html" class="nav-link">
                <i class="nav-icon fas fa-building"></i>
                <p>Departments</p>
              </a>
            </li>

            <li class="nav-item menu-open">
              <a href="#" class="nav-link active">
                <i class="nav-icon fas fa-users-cog"></i>
                <p>HR<i class="right fas fa-angle-right"></i></p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="empolyees.html" class="nav-link active">
                    <i class="nav-icon far fa-id-card"></i>
                    <p>Employees</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="attendance_dashboard.html" class="nav-link">
                    <i class="nav-icon far fa-clock"></i>
                    <p>Attendance</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="leave_overview.html" class="nav-link">
                    <i class="nav-icon fas fa-calendar-times"></i>
                    <p>Leave Mgmt</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="payroll_dashboard.html" class="nav-link">
                    <i class="nav-icon fas fa-money-check-alt"></i>
                    <p>Payroll</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="leave_requ.html" class="nav-link">
                    <i class="nav-icon fas fa-paper-plane"></i>
                    <p>Requests</p>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item">
              <a href="announcement.html" class="nav-link">
                <i class="nav-icon fas fa-bullhorn"></i>
                <p>Announcements</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-chart-line"></i>
                <p>Reports & Logs</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-cog"></i>
                <p>Settings<i class="right fas fa-angle-right"></i></p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="polices.html" class="nav-link">
                    <i class="nav-icon fas fa-list-ol"></i>
                    <p>Policies</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="change_password.html" class="nav-link">
                    <i class="nav-icon fas fa-key"></i>
                    <p>Change Password</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="help.html" class="nav-link">
                    <i class="nav-icon fa fa-question-circle"></i>
                    <p>Help Desk</p>
                  </a>
                </li>

              </ul>
        </nav>
      </div>
    </aside>

    <div class="content-wrapper">
        <div class="container-fluid px-lg-5">
            <form id="addEmployeeForm">
                <div class="row">
                    <div class="col-lg-8">
                        
                        <div class="card-bloom">
                            <div class="section-title"><i class="fas fa-user-circle"></i> Personal & Contact Details</div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label>Full Name</label>
                                    <input type="text" class="form-control" placeholder="e.g. Rahul Sharma" required>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Date of Birth (DOB)</label>
                                    <input type="date" class="form-control" required>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Main Contact No.</label>
                                    <input type="tel" class="form-control" placeholder="+91 98765 43210">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Alternative Contact No.</label>
                                    <input type="tel" class="form-control" placeholder="Emergency Contact">
                                </div>
                                <div class="col-md-12 form-group">
                                    <label>Official Email</label>
                                    <input type="email" class="form-control" placeholder="rahul@bloom.in">
                                </div>
                            </div>
                        </div>

                        <div class="card-bloom">
                            <div class="section-title"><i class="fas fa-graduation-cap"></i> Academic & Professional History</div>
                            <div class="row">
                                <div class="col-md-12 form-group">
                                    <label>Academic Studies (Education)</label>
                                    <textarea class="form-control" rows="2" placeholder="e.g. MBA in HR / B.Tech in CSE"></textarea>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Previous Company</label>
                                    <input type="text" class="form-control" placeholder="Company Name">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Years of Experience</label>
                                    <input type="text" class="form-control" placeholder="e.g. 3 Years">
                                </div>
                                <div class="col-md-12 form-group">
                                    <label>Experience Details</label>
                                    <textarea class="form-control" rows="2" placeholder="Roles and responsibilities held previously..."></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="card-bloom">
                            <div class="section-title"><i class="fas fa-project-diagram"></i> Projects & Skills</div>
                            <div class="row">
                                <div class="col-md-12 form-group">
                                    <label>Projects (Worked & Working On)</label>
                                    <textarea class="form-control" rows="3" placeholder="Describe key projects..."></textarea>
                                </div>
                                <div class="col-md-12 form-group">
                                    <label>Skills (Type and press Enter)</label>
                                    <div class="skills-container" id="skillsWrapper">
                                        <input type="text" id="skillInput" placeholder="Add a skill...">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-bloom">
                            <div class="section-title"><i class="fas fa-rupee-sign"></i> Employment & Payroll</div>
                            <div class="row">
                                <div class="col-md-4 form-group">
                                    <div class="d-flex justify-content-between">
                                        <label>Department</label>
                                        <a href="#" class="small text-primary font-weight-bold">+ Add New</a>
                                    </div>
                                    <select class="form-control">
                                        <option>Development</option>
                                        <option>Design</option>
                                        <option>HR & Admin</option>
                                    </select>
                                </div>
                                <div class="col-md-4 form-group">
                                    <label>Designation</label>
                                    <input type="text" class="form-control" placeholder="e.g. Developer">
                                </div>
                                <div class="col-md-4 form-group">
                                    <label>Employee ID</label>
                                    <input type="text" class="form-control" placeholder="BLM-2026-XXX">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Monthly Salary (CTC)</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-white" style="border-radius:10px 0 0 10px; font-weight: bold;">₹</span>
                                        </div>
                                        <input type="number" class="form-control" style="border-radius:0 10px 10px 0;" placeholder="Amount in INR">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-5 d-flex justify-content-end">
                            <button type="button" class="btn btn-light px-4 mr-2" style="border-radius:10px;">Discard</button>
                            <button type="submit" class="btn btn-save shadow">Finish & Save Record</button>
                        </div>

                    </div>

                    <div class="col-lg-4">
                        <div class="card-bloom text-center sticky-top" style="top:90px">
                            <h6 class="font-weight-bold mb-3">Profile Picture</h6>
                            <div class="profile-upload-wrapper" id="uploadArea">
                                <img id="imagePreview" src="">
                                <div id="uploadPlaceholder">
                                    <i class="fas fa-camera fa-2x text-muted"></i>
                                </div>
                                <input type="file" id="profileInput" hidden accept="image/*">
                            </div>
                            <p class="small text-muted mt-3">Employee Status: <span class="badge badge-success px-3" style="background:#dcfce7; color:#166534; border-radius:10px;">Available</span></p>
                            <hr>
                            <div class="text-left">
                                <h6 class="font-weight-bold small text-primary"><i class="fas fa-lightbulb mr-1"></i> Quick Note</h6>
                                <p class="small text-muted mb-0">Ensure all contact details are verified. An automated welcome email will be sent to the official address.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <footer class="main-footer">
        <strong>Copyright &copy; 2026 <a href="#" class="footer-link">Bloom Solutions</a>.</strong>
        All rights reserved.
    </footer>
</div>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

<script>
    $(document).ready(function() {
        // Image Upload Logic
        $('#uploadArea').on('click', function() { $('#profileInput').click(); });
        $('#profileInput').on('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = e => {
                    $('#imagePreview').attr('src', e.target.result).show();
                    $('#uploadPlaceholder').hide();
                }
                reader.readAsDataURL(file);
            }
        });

        // Skills Tagging Logic
        const skills = [];
        $('#skillInput').on('keypress', function(e) {
            if (e.which === 13) {
                e.preventDefault();
                const val = $(this).val().trim();
                if (val && !skills.includes(val)) {
                    skills.push(val);
                    $(`<span class="skill-tag">${val} <i class="fas fa-times" onclick="removeSkill('${val}', this)"></i></span>`)
                        .insertBefore('#skillInput');
                    $(this).val('');
                }
            }
        });
    });

    function removeSkill(skill, el) {
        $(el).parent().remove();
    }
</script>

</body>
</html>
