
<?php
$session = session();
$original_role = $session->get('user_category'); // Their true identity
$active_role   = $session->get('current_user_cat'); // The view they are currently using

$uri = service('uri');
$current = uri_string();


$isSettingsActive = in_array($current, [
    'aut_pages/polices',
    'aut_pages/leave_policy',
    'aut_pages/company_policy',
    'aut_pages/conduct',
    'aut_pages/terms_conditions',
    'aut_pages/change_password',
    'aut_pages/help'
]);

$isHRActive =
    $current == 'admin/empolyees' ||
    strpos($current, 'admin/emp_view') === 0 ||
    strpos($current, 'admin/emp_edit') === 0 ||
    strpos($current, 'admin/add_employee') === 0 ||
    $current == 'admin/attendance_dashboard' ||
    strpos($current, 'admin/attendance_adm') === 0 ||
    strpos($current, 'admin/master_time_sheet') === 0 ||
    $current == 'admin/leave_overview' ||
    strpos($current, 'admin/Leave_Balance') === 0 ||
    strpos($current, 'admin/Month_leave_details') === 0 ||
    strpos($current, 'admin/leave_req') === 0 ||
    $current == 'admin/pay_roll' ||
    $current == 'admin/Requests';

$isOnBoardingActive = in_array($current, [
    'admin/add_Candidate',
    'admin/View_candidate'
]);

$isMailActive = (strpos($current, 'admin/mail') === 0);
?>
<?php if(in_array($active_role, ['EMP', 'HR', 'MANAGER', 'INTERN'])) { ?>

<aside class="main-sidebar sidebar-dark-primary elevation-0">

      <a href="#" class="brand-link custom-brand">
       <img src="<?= base_url('public/dist/img/bloom.jpg') ?>"
     class="brand-image img-circle"
     style="width:35px;height:35px;object-fit:cover;">
        <span class="brand-text">
          <span class="brand-blue">Bloom</span>
          <span class="brand-orange">Solutions</span>
        </span>
      </a>

      <div class="sidebar">
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

            <li class="nav-item">
             <a href="<?= base_url('employee/Emp_dashboard') ?>"
             class="nav-link <?= ($uri->getSegment(2) == 'Emp_dashboard') ? 'active' : '' ?>">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>Dashboard</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="<?= base_url('employee/calender') ?>"class="nav-link <?= ($current == 'employee/calender') ? 'active' : '' ?>">
                <i class="nav-icon fas fa-calendar-alt"></i>
                <p>My Calendar</p>
              </a>
            </li>



          <li class="nav-item">
            <?php if ($original_role == 'EMP') { ?>
                <a href="<?= base_url('employee/myteammgr') ?>"
                  class="nav-link <?= (
                      $current == 'employee/team' ||
                      $current == 'employee/myteammgr' ||
                      $current == 'employee/emp_attendance' ||
                      strpos($current, 'admin/leave_requ/') === 0
                  ) ? 'active' : '' ?>">
                    <i class="nav-icon fas fa-user-friends"></i>
                    <p>My Team</p>
                </a>

            <?php } elseif ($original_role == 'MANAGER' || $original_role == 'HR') { ?>
                <a href="<?= base_url('employee/myteammgr') ?>"
                  class="nav-link <?= (
                      $current == 'employee/team' ||
                      $current == 'employee/myteammgr' ||
                      $current == 'employee/emp_attendance' ||
                      strpos($current, 'admin/leave_requ/') === 0
                  ) ? 'active' : '' ?>">
                    <i class="nav-icon fas fa-user-friends"></i>
                    <p>My Team</p>
                </a>
            <?php } ?>
        </li>

            <!-- <li class="nav-item">
              <a href="<?= base_url('employee/my_attendance') ?>" class="nav-link <?= ($current == 'employee/my_attendance') ? 'active' : '' ?>">
                <i class="nav-icon fas fa-user-check"></i>
                <p>My Attendance</p>
              </a>
            </li> -->

             <li class="nav-item">
              <a href="<?= base_url('admin/announcement') ?>"class="nav-link <?= ($current == 'admin/announcement') ? 'active' : '' ?>">
                <i class="nav-icon fas fa-bullhorn"></i>
                <p>Announcements</p>
              </a>
            </li>
            
            <?php if($original_role != 'INTERN') { ?>
            <li class="nav-item">
              <a href="<?= base_url('employee/my_attendance') ?>" class="nav-link <?= ($current == 'employee/my_attendance') ? 'active' : '' ?>">
                <i class="nav-icon fas fa-user-check"></i>
                <p>My Attendance</p>
              </a>
            </li>
            <?php } ?>
            
           
            <li class="nav-item">
              <a href="<?= base_url('employee/apply_leave1') ?>"
                class="nav-link <?= in_array($current, ['employee/apply_leave1', 'employee/leave_history']) ? 'active' : '' ?>">
                  <i class="nav-icon fas fa-calendar-minus"></i>
                  <p>My Leave</p>
              </a>
          </li>

            <?php if($original_role != 'INTERN') { ?>
           <li class="nav-item">
          <a href="<?= base_url('employee/pay_roll') ?>"
            class="nav-link <?= (strpos(current_url(), 'employee/new_emp_payslip') !== false || $current == 'employee/pay_roll') ? 'active' : '' ?>">
              <i class="nav-icon fas fa-file-invoice-dollar"></i>
              <p>My Salary</p>
          </a>
          </li>
            <?php } ?>

            <?php if($original_role != 'INTERN') { ?>
            <li class="nav-item">
               <a href="<?= base_url('employee/requests') ?>"class="nav-link <?= ($current == 'employee/requests') ? 'active' : '' ?>">
                <i class="nav-icon fas fa-paper-plane"></i>
                <p>My Requests</p>
              </a>
            </li>
            <?php } ?>

            <li class="nav-item">
               <a href="<?= base_url('employee/notifications') ?>" class="nav-link <?= ($current == 'employee/notifications') ? 'active' : '' ?>">
                <i class="nav-icon fas fa-bell"></i>
                <p>Notifications</p>
              </a>
            </li>


            <li class="nav-item <?= $isSettingsActive ? 'menu-open' : '' ?>">
            <a href="#" class="nav-link <?= $isSettingsActive ? 'active' : '' ?>">
              <i class="nav-icon fas fa-cog"></i>
              <p>
                Settings
                <i class="right fas fa-angle-right"></i>
              </p>
            </a>
              <ul class="nav nav-treeview">
                 <li class="nav-item">
            <a href="<?= base_url('aut_pages/polices') ?>"
              class="nav-link <?= in_array($current, [
                    'aut_pages/polices',
                    'aut_pages/leave_policy',
                    'aut_pages/company_policy',
                    'aut_pages/conduct',
                    'aut_pages/terms_conditions'
              ]) ? 'active' : '' ?>">
                <i class="nav-icon fas fa-list-ol"></i>
                <p>Policies</p>
            </a>
        </li>
                <li class="nav-item">
                  <a href="<?= base_url('aut_pages/change_password') ?>"
                 class="nav-link <?= ($current == 'aut_pages/change_password') ? 'active' : '' ?>">
                    <i class="nav-icon fas fa-key"></i>
                    <p>Change Password</p>
                  </a>
                </li>

                 <li class="nav-item">
                  <a href="<?= base_url('aut_pages/help') ?>"
                 class="nav-link <?= ($current == 'aut_pages/help') ? 'active' : '' ?>">
                    <i class="nav-icon fa fa-question-circle"></i>
                    <p>Support</p>
                  </a>
                </li>
          </ul>
        </nav>
      </div>
    </aside>

<?php } elseif(in_array($active_role, ['ADMIN', 'HR'])) { ?>


        <aside class="main-sidebar sidebar-dark-primary elevation-0" style="background-color: #111c43;">
      <a href="#" class="brand-link border-0" style="background-color: #111c43;">
        <img src="<?= base_url('public/dist/img/bloom.jpg') ?>"
     class="brand-image img-circle"
     style="width:35px;height:35px;object-fit:cover;">
        <span class="brand-text font-weight-bold">
          <span style="color:#4a8cff;">Bloom</span> <span style="color:#ff7a45;">Solutions</span>
        </span>
      </a>

      <div class="sidebar">
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu">

            <li class="nav-item">
              <a href="<?= base_url('admin/adm_dashboard') ?>" class="nav-link <?= ($current == 'admin/adm_dashboard') ? 'active' : '' ?>">
                <i class="nav-icon fas fa-home"></i>
                <p>Dashboard</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= base_url('admin/calender') ?>" class="nav-link <?= ($current == 'admin/calender') ? 'active' : '' ?>">
                <i class="nav-icon far fa-calendar-alt"></i>
                <p>My Calendar</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= base_url('admin/deparment') ?>" class="nav-link <?= ($current == 'admin/deparment') ? 'active' : '' ?>">
                <i class="nav-icon fas fa-building"></i>
                <p>Departments</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= base_url('admin/designation') ?>" class="nav-link <?= ($current == 'admin/designation') ? 'active' : '' ?>">
                <i class="nav-icon fas fa-id-badge"></i>
                <p>Designations</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="<?= base_url('aut_pages/Holidays_create') ?>" class="nav-link <?= ($current == 'aut_pages/Holidays_create') ? 'active' : '' ?>">
                  <i class="nav-icon fas fa-calendar-alt"></i>
                  <p>Holiday Edit</p>
              </a>
           </li>

           <li class="nav-item <?= $isHRActive ? 'menu-open' : '' ?>">
         <a href="#" class="nav-link <?= $isHRActive ? 'active' : '' ?>">
                <i class="nav-icon fas fa-users-cog"></i>
                <p>HR<i class="right fas fa-angle-right"></i></p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="<?= base_url('admin/empolyees') ?>"
                    class="nav-link <?= (
                          $current == 'admin/empolyees' ||
                          strpos($current, 'admin/emp_view') === 0 ||
                          strpos($current, 'admin/emp_edit') === 0 ||
                          strpos($current, 'admin/add_employee') === 0 

                      ) ? 'active' : '' ?>">
                    <i class="nav-icon far fa-id-card"></i>
                    <p>Employees</p>
                  </a>
                </li>
             
                <li class="nav-item">
                    <a href="<?= base_url('admin/attendance_dashboard') ?>" 
                      class="nav-link <?= ($current == 'admin/attendance_dashboard'||
                      strpos($current, 'admin/attendance_adm') === 0 ||
                      strpos($current, 'admin/master_time_sheet') === 0
                      ) ? 'active' : '' ?>">
                        <i class="nav-icon far fa-clock"></i>
                        <p>Attendance</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('admin/payroll_attendance') ?>" 
                      class="nav-link <?= ($current == 'admin/payroll_attendance') ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-calculator"></i>
                        <p>Payroll Attendance</p>
                    </a>
                </li>
                <li class="nav-item">
                  <a href="<?= base_url('admin/leave_overview') ?>"
                      class="nav-link <?= (
                            $current == 'admin/leave_overview' ||
                            strpos($current, 'admin/Leave_Balance') === 0 ||
                            strpos($current, 'admin/Month_leave_details') === 0 ||
                            strpos($current, 'admin/leave_req') === 0
                        ) ? 'active' : '' ?>">
                    <i class="nav-icon fas fa-calendar-times"></i>
                    <p>Leave Mgmt</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?= base_url('admin/leave_types') ?>"
                      class="nav-link <?= ($current == 'admin/leave_types') ? 'active' : '' ?>">
                    <i class="nav-icon fas fa-sliders-h"></i>
                    <p>Leave Types</p>
                  </a>
                </li>
                <!-- <li class="nav-item">
                  <a href="<?= base_url('admin/payroll_dashboard') ?>" class="nav-link <?= ($current == 'admin/payroll_dashboard') ? 'active' : '' ?>">
                    <i class="nav-icon fas fa-money-check-alt"></i>
                    <p>Payroll</p>
                  </a>
                </li> -->

                 <li class="nav-item">
                  <a href="<?= base_url('admin/payroll') ?>" class="nav-link <?= (strpos($current, 'admin/payroll') === 0 || $current == 'admin/pay_roll') ? 'active' : '' ?>">
                    <i class="nav-icon fas fa-calculator"></i>
                    <p>Payroll Processing</p>
                  </a>
                </li>

                <li class="nav-item">
                 <a href="<?= base_url('admin/Requests') ?>"
                 class="nav-link <?= ($current == 'admin/Requests') ? 'active' : '' ?>">
                    <i class="nav-icon fas fa-paper-plane"></i>
                    <p>Requests</p>
                  </a>
                </li>

                <li class="nav-item">
                 <a href="<?= base_url('admin/missing_punchout') ?>"
                 class="nav-link <?= ($current == 'admin/missing_punchout') ? 'active' : '' ?>">
                    <i class="nav-icon fas fa-user-clock"></i>
                    <p>Missing Punchouts</p>
                  </a>
                </li>

                <li class="nav-item">
                 <a href="<?= base_url('admin/attendance_overview') ?>"
                 class="nav-link <?= ($current == 'admin/attendance_overview' || $current == 'admin/attendance_details') ? 'active' : '' ?>">
                    <i class="nav-icon fas fa-calendar-check"></i>
                    <p>Attendance Overview</p>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item">
              <a href="<?= base_url('admin/announcement') ?>"class="nav-link <?= ($current == 'admin/announcement') ? 'active' : '' ?>">
                <i class="nav-icon fas fa-bullhorn"></i>
                <p>Announcements</p>
              </a>
            </li>

            <li class="nav-item">
               <a href="<?= base_url('employee/notifications') ?>" class="nav-link <?= ($current == 'employee/notifications') ? 'active' : '' ?>">
                <i class="nav-icon fas fa-bell"></i>
                <p>Notifications</p>
              </a>
            </li>
            <!-- <li class="nav-item">
              <a href="<?= base_url('on_boarding/onboard_login') ?>"class="nav-link <?= ($current == 'on_boarding/onboard_login') ? 'active' : '' ?>">
                <i class="nav-icon fas fa-chart-line"></i>
                <p>On Boarding</p>
              </a>
            </li>

             <li class="nav-item">
              <a href="<?= base_url('admin/add_Candidate') ?>"class="nav-link <?= ($current == 'admin/add_Candidate') ? 'active' : '' ?>">
                <i class="nav-icon fas fa-chart-line"></i>
                <p>Candidate</p>
              </a>
            </li> -->


         <li class="nav-item <?= $isOnBoardingActive ? 'menu-open' : '' ?>">
         <a href="#" class="nav-link <?= $isOnBoardingActive ? 'active' : '' ?>">
            <i class="nav-icon fas fa-user-check"></i>
            <p>
              On Boarding 
              <i class="right fas fa-angle-right"></i>
              </p>
          </a>
                <ul class="nav nav-treeview">
                  <!-- <li class="nav-item">
                    <a href="<?= base_url('on_boarding/onboard_login') ?>"
                class="nav-link <?= ($current == 'on_boarding/onboard_login') ? 'active' : '' ?>">
                     <i class="nav-icon fas fa-sign-in-alt"></i>
                      <p>Login</p>
                    </a>
                  </li> -->
                  <li class="nav-item">
                    <a href="<?= base_url('admin/add_Candidate') ?>"class="nav-link <?= ($current == 'admin/add_Candidate') ? 'active' : '' ?>">
                      <i class="nav-icon fas fa-user-tie"></i>
                      <p>Add Candidate</p>
                    </a>
                  </li>

                 <li class="nav-item">
                    <a href="<?= base_url('admin/View_candidate') ?>"class="nav-link <?= ($current == 'admin/View_candidate') ? 'active' : '' ?>">
                      <i class="nav-icon fas fa-user-tie"></i>
                      <p> View Candidate</p>
                    </a>
                  </li>

                </ul>
            </li>

            <li class="nav-item <?= $isMailActive ? 'menu-open' : '' ?>">
              <a href="#" class="nav-link <?= $isMailActive ? 'active' : '' ?>">
                <i class="nav-icon fas fa-paper-plane"></i>
                <p>
                  Mail Center
                  <i class="right fas fa-angle-right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="<?= base_url('admin/mail/compose') ?>" class="nav-link <?= ($current == 'admin/mail/compose') ? 'active' : '' ?>">
                    <i class="nav-icon fas fa-pen"></i>
                    <p>Compose Mail</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?= base_url('admin/mail/logs') ?>" class="nav-link <?= ($current == 'admin/mail/logs') ? 'active' : '' ?>">
                    <i class="nav-icon fas fa-history"></i>
                    <p>Sent Logs</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?= base_url('admin/mail/settings') ?>" class="nav-link <?= ($current == 'admin/mail/settings') ? 'active' : '' ?>">
                    <i class="nav-icon fas fa-sliders-h"></i>
                    <p>SMTP Settings</p>
                  </a>
                </li>
              </ul>
            </li>

             <li class="nav-item <?= $isSettingsActive ? 'menu-open' : '' ?>">
            <a href="#" class="nav-link <?= $isSettingsActive ? 'active' : '' ?>">
              <i class="nav-icon fas fa-cog"></i>
              <p>
                Settings
                <i class="right fas fa-angle-right"></i>
              </p>
            </a>
              <ul class="nav nav-treeview">
                  <li class="nav-item">
    <a href="<?= base_url('aut_pages/polices') ?>"
       class="nav-link <?= in_array($current, [
            'aut_pages/polices',
            'aut_pages/leave_policy',
            'aut_pages/company_policy',
            'aut_pages/conduct',
            'aut_pages/terms_conditions'
       ]) ? 'active' : '' ?>">
        <i class="nav-icon fas fa-list-ol"></i>
        <p>Policies</p>
    </a>
</li>
                <li class="nav-item">
                  <a href="<?= base_url('aut_pages/change_password') ?>"class="nav-link <?= ($current == 'aut_pages/change_password') ? 'active' : '' ?>">
                    <i class="nav-icon fas fa-key"></i>
                    <p>Change Password</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?= base_url('aut_pages/help') ?>"
             class="nav-link <?= ($current == 'aut_pages/help') ? 'active' : '' ?>">
                    <i class="nav-icon fa fa-question-circle"></i>
                    <p>Support</p>
                  </a>
                </li>

              </ul>
        </nav>
      </div>
    </aside>


    <?php } ?>





