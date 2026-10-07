<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->GET('login', 'Home::index');

$routes->POST('login', 'Home::login');

$routes->get('first_login', 'Home::first_login');

$routes->post('update_password', 'Home::update_password');

$routes->get('forgot-password', 'Home::forgotPasswordPage');
$routes->post('forgot-password', 'Home::forgotPassword');

$routes->get('resetpwd', 'Home::resetpwd');
$routes->post('resetForgotPassword', 'Home::resetForgotPassword');

$routes->get('logout', 'Home::logout');
$routes->get('auth/logout', 'Home::logout');

$routes->get('/profile', 'Home::profile');

$routes->get('aut_pages/holidays', 'Home::holiday');

$routes->get('aut_pages/comingsoon', 'Home::Coming_soon');

$routes->get('profile_updation', 'Home::profile_updation');
$routes->post('profile_updation', 'Home::profile_updation');

$routes->get('aut_pages/Holidays_create', 'Home::holiday_create');
$routes->post('aut_pages/Holidays_create', 'Home::holiday_create');
$routes->post('aut_pages/save_holiday', 'Home::save_holiday');

$routes->get('aut_pages/leave_policy', 'Home::leave_policy');
$routes->get('aut_pages/company_policy', 'Home::company_policy');
$routes->get('aut_pages/conduct', 'Home::conduct');
$routes->get('aut_pages/terms_conditions', 'Home::terms_conditions');

$routes->GET('aut_pages/change_password', 'Home::change_pwd');
$routes->POST('aut_pages/change_password', 'Home::change_pwd');
// Admin Dashboard
$routes->GET('admin/adm_dashboard', 'AdminController::admin_dash');
$routes->POST('admin/adm_dashboard', 'AdminController::admin_dash');
$routes->GET('admin/calender', 'AdminController::adm_cal');
$routes->POST('admin/calender', 'AdminController::adm_cal');
$routes->GET('admin/deparment', 'AdminController::adm_dep');
$routes->POST('admin/deparment', 'AdminController::adm_dep');
$routes->post('admin/save_department', 'AdminController::save_department');

$routes->GET('admin/designation', 'AdminController::adm_designation');
$routes->POST('admin/designation', 'AdminController::adm_designation');
$routes->post('admin/save_designation', 'AdminController::save_designation');

$routes->GET('admin/empolyees', 'AdminController::adm_emp');
$routes->POST('admin/empolyees', 'AdminController::adm_emp');
$routes->GET('admin/attendance_dashboard', 'AdminController::adm_attendence');
$routes->POST('admin/attendance_dashboard', 'AdminController::adm_attendence');

$routes->GET('admin/attendance_adm', 'AdminController::adm_attend');
$routes->POST('admin/attendance_adm', 'AdminController::adm_attend');

$routes->GET('admin/master_time_sheet', 'AdminController::adm_master_time');
$routes->POST('admin/master_time_sheet', 'AdminController::adm_master_time');

$routes->GET('admin/leave_overview', 'AdminController::adm_leave');
$routes->POST('admin/leave_overview', 'AdminController::adm_leave');
$routes->GET('admin/payroll_dashboard', 'AdminController::adm_payroll');
$routes->POST('admin/payroll_dashboard', 'AdminController::adm_payroll');
// $routes->GET('admin/leave_requ', 'AdminController::adm_req');
// $routes->POST('admin/leave_requ', 'AdminController::adm_req');
$routes->GET('admin/announcement', 'AdminController::adm_announce');
$routes->POST('admin/announcement', 'AdminController::adm_announce');
$routes->post('admin/save_announcement', 'AdminController::save_announcement');
$routes->post('admin/delete_announcement', 'AdminController::delete_announcement');
$routes->GET('aut_pages/polices', 'Home::adm_pol');
$routes->POST('aut_pages/polices', 'Home::adm_pol');
$routes->GET('admin/change_password', 'AdminController::adm_change_pwd');
$routes->POST('admin/change_password', 'AdminController::adm_change_pwd');
$routes->GET('aut_pages/help', 'Home::adm_help');
$routes->POST('aut_pages/help', 'Home::adm_help');

// $routes->GET('admin/change_password', 'Home::change_pwd');
// $routes->POST('admin/change_password', 'Home::change_pwd');

$routes->get('admin/onboard_login', 'AdminController::on_board');
$routes->post('admin/login_check', 'AdminController::login_check');
$routes->post('admin/accept_offer', 'AdminController::accept_offer');
$routes->post('admin/reject_offer', 'AdminController::reject_offer');

// Admin Mail Center Routes
$routes->get('admin/mail/compose', 'MailController::compose');
$routes->post('admin/mail/send', 'MailController::send');
$routes->get('admin/mail/logs', 'MailController::logs');
$routes->get('admin/mail/view_log/(:num)', 'MailController::viewLog/$1');
$routes->get('admin/mail/settings', 'MailController::settings');
$routes->post('admin/mail/save_settings', 'MailController::saveSettings');
$routes->post('admin/mail/test_smtp', 'MailController::testSmtp');
$routes->get('admin/mail/get_template/(:segment)', 'MailController::getTemplate/$1');
$routes->post('admin/mail/save_template', 'MailController::saveTemplate');

$routes->GET('admin/cross_check', 'AdminController::crosscheck');
$routes->POST('admin/cross_check', 'AdminController::crosscheck');
$routes->GET('admin/decline', 'AdminController::decline');
$routes->POST('admin/decline', 'AdminController::decline');
$routes->GET('admin/document_checklist', 'AdminController::doc_check');
$routes->POST('admin/document_checklist', 'AdminController::doc_check');
$routes->GET('admin/education_details', 'AdminController::edu_details');
$routes->POST('admin/education_details', 'AdminController::edu_details');
$routes->GET('admin/personal_details', 'AdminController::person_det');
$routes->POST('admin/personal_details', 'AdminController::person_det');
$routes->GET('admin/professional_details', 'AdminController::professional_det');
$routes->POST('admin/professional_details', 'AdminController::professional_det');
$routes->GET('admin/thank_you', 'AdminController::thanku');
$routes->POST('admin/thank_you', 'AdminController::thanku');
$routes->GET('admin/bank_details', 'AdminController::bank_det');
$routes->POST('admin/bank_details', 'AdminController::bank_det');
$routes->GET('admin/view_appointment_letter', 'AdminController::view_app_letter');
$routes->POST('admin/view_appointment_letter', 'AdminController::view_app_letter');
$routes->GET('admin/document_upload', 'AdminController::doc_upload');
$routes->POST('admin/document_upload', 'AdminController::doc_upload');

$routes->GET('admin/add_Candidate', 'AdminController::addcandidate');
$routes->POST('admin/add_Candidate', 'AdminController::addcandidate');
$routes->GET('admin/View_candidate', 'AdminController::view_cand');
$routes->POST('admin/View_candidate', 'AdminController::view_cand');

$routes->get('admin/candidate', 'AdminController::view_cand');
$routes->get('admin/candidate/(:segment)', 'AdminController::candidate_view/$1');

$routes->post('replace-document', 'AdminController::replace_document');
$routes->post('admin/save-organization-details', 'AdminController::saveOrganizationDetails');
$routes->post('admin/final-submit', 'AdminController::final_submit');

$routes->GET('admin/Requests', 'AdminController::adm_req');
$routes->POST('admin/Requests', 'AdminController::adm_req');
$routes->post('admin/update_progress', 'AdminController::update_progress');
$routes->post('admin/resolve_request', 'AdminController::resolve_request');
$routes->post('admin/update_punch_time', 'AdminController::update_punch_time');
$routes->get('admin/missing_punchout', 'AdminController::missing_punchout');
$routes->post('admin/missing_punchout', 'AdminController::missing_punchout');
$routes->post('admin/save_missing_punchout', 'AdminController::save_missing_punchout');
$routes->get('admin/attendance_overview', 'AdminController::attendance_overview');
$routes->post('admin/attendance_overview', 'AdminController::attendance_overview');
$routes->get('admin/attendance_details', 'AdminController::attendance_details');
$routes->post('admin/attendance_details', 'AdminController::attendance_details');
$routes->post('admin/save_absent_edit', 'AdminController::save_absent_edit');
$routes->post('admin/generate_payroll_attendance', 'AdminController::generate_payroll_attendance');
$routes->post('admin/finalize_payroll_attendance', 'AdminController::finalize_payroll_attendance');
$routes->get('admin/payroll_attendance', 'AdminController::payroll_attendance');
$routes->post('admin/payroll_attendance', 'AdminController::payroll_attendance');

$routes->get('admin/emp_view/(:any)', 'AdminController::adm_view/$1');
$routes->POST('admin/emp_view', 'AdminController::adm_view');
$routes->GET('admin/emp_edit/(:any)', 'AdminController::adm_edit/$1');
$routes->POST('admin/emp_edit', 'AdminController::adm_edit');
// Update Employee
$routes->post('admin/update_employee', 'AdminController::update_employee');

$routes->post('admin/update_document', 'AdminController::update_document');

$routes->post('admin/toggle_user_status', 'AdminController::toggle_user_status');

$routes->GET('admin/add_employee', 'AdminController::add_emp');
$routes->post('admin/save_employee', 'AdminController::save_employee');
//Employee Dashboard
$routes->GET('employee/Emp_dashboard', 'EmployeeController::emp_dash');
$routes->POST('employee/Emp_dashboard', 'EmployeeController::emp_dash');
$routes->GET('employee/calender', 'EmployeeController::cal');
$routes->POST('employee/calender', 'EmployeeController::cal');
$routes->GET('employee/team', 'EmployeeController::team');
$routes->POST('employee/team', 'EmployeeController::team');
$routes->GET('employee/my_attendance', 'EmployeeController::attendence');
$routes->POST('employee/my_attendance', 'EmployeeController::attendence');
$routes->GET('employee/apply_leave1', 'EmployeeController::leave');
$routes->POST('employee/apply_leave1', 'EmployeeController::leave');
$routes->GET('employee/pay_roll', 'EmployeeController::Sal');
$routes->POST('employee/pay_roll', 'EmployeeController::Sal');
$routes->GET('employee/requests', 'EmployeeController::req');
$routes->POST('employee/requests', 'EmployeeController::req');
$routes->post('employee/submit_request', 'EmployeeController::submit_request');
$routes->get('employee/cancel_request/(:num)', 'EmployeeController::cancel_request/$1');
$routes->post('employee/complete_request', 'EmployeeController::complete_request');
$routes->GET('employee/myteammgr', 'EmployeeController::teammgr');
$routes->POST('employee/myteammgr', 'EmployeeController::teammgr');

$routes->GET('employee/emp_attendance', 'EmployeeController::emp_attendance');
$routes->POST('employee/emp_attendance', 'EmployeeController::emp_attendance');

// $routes->GET('employee/change_password', 'Home::change_pwd');
// $routes->POST('employee/change_password', 'Home::change_pwd');

$routes->get('employee/leave', 'EmployeeController::leave');

$routes->GET('employee/leave_history', 'EmployeeController::view_history_emp');
$routes->POST('employee/leave_history', 'EmployeeController::view_history_emp');

$routes->post('employee/leave_apply_submit', 'EmployeeController::leave_apply_submit');

$routes->post('employee/emp_pi_po', 'EmployeeController::emp_pi_po');

//ONBOARDING DASHBOARD
$routes->get('on_boarding/onboard_login', 'OnboardingController::on_board');
$routes->post('on_boarding/login_check', 'OnboardingController::login_check');
$routes->get('on_boarding/view_appointment_letter', 'OnboardingController::view_app_letter');

$routes->get('on_boarding/verify/(:segment)/(:segment)', 'OnboardingController::verify/$1/$2');

$routes->get('on_boarding/finalsubmit', 'OnboardingController::finalsubmit');

$routes->post('on_boarding/accept_offer', 'OnboardingController::accept_offer');
$routes->post('on_boarding/reject_offer', 'OnboardingController::reject_offer');

$routes->GET('on_boarding/cross_check', 'OnboardingController::crosscheck');
$routes->POST('on_boarding/cross_check', 'OnboardingController::crosscheck');
$routes->GET('on_boarding/decline', 'OnboardingController::decline');
$routes->POST('on_boarding/decline', 'OnboardingController::decline');
$routes->GET('on_boarding/document_checklist', 'OnboardingController::doc_check');
$routes->POST('on_boarding/document_checklist', 'OnboardingController::doc_check');
$routes->GET('on_boarding/education_details', 'OnboardingController::edu_details');
$routes->POST('on_boarding/education_details', 'OnboardingController::edu_details');
$routes->GET('on_boarding/personal_details', 'OnboardingController::person_det');
$routes->POST('on_boarding/personal_details', 'OnboardingController::person_det');
$routes->GET('on_boarding/professional_details', 'OnboardingController::professional_det');
$routes->POST('on_boarding/professional_details', 'OnboardingController::professional_det');
$routes->GET('on_boarding/thank_you', 'OnboardingController::thanku');
$routes->POST('on_boarding/thank_you', 'OnboardingController::thanku');
$routes->GET('on_boarding/bank_details', 'OnboardingController::bank_det');
$routes->POST('on_boarding/bank_details', 'OnboardingController::bank_det');
$routes->GET('on_boarding/view_appointment_letter', 'OnboardingController::view_app_letter');
$routes->POST('on_boarding/view_appointment_letter', 'OnboardingController::view_app_letter');
$routes->GET('on_boarding/document_upload', 'OnboardingController::doc_upload');
$routes->post('on_boarding/save_documents', 'OnboardingController::save_documents');
$routes->post('on_boarding/delete_document', 'OnboardingController::delete_document');
$routes->post('on_boarding/upload_single_document', 'OnboardingController::upload_single_document');


//LEAVE ROUTES 
$routes->GET('admin/leave_requ', 'AdminController::leave_view');
$routes->get('admin/leave_requ/(:num)', 'AdminController::leave_view/$1');
$routes->post('leave/leave_decision', 'EmployeeController::leave_decision');

$routes->GET('admin/leave_types', 'AdminController::leave_types');
$routes->POST('admin/save_leave_type', 'AdminController::save_leave_type');
$routes->POST('admin/generate_leave_balances', 'AdminController::generate_leave_balances');

$routes->GET('admin/Leave_Balance', 'AdminController::leave_balance');
$routes->POST('admin/Leave_Balance', 'AdminController::leave_balance');
$routes->GET('admin/Month_leave_details', 'AdminController::month_leave');
$routes->POST('admin/Month_leave_details', 'AdminController::month_leave');


//SALARY AND PAYSLIP ROUTES
$routes->GET('admin/pay_roll', 'SalaryController::pay_roll');
$routes->POST('admin/pay_roll', 'SalaryController::pay_roll');

// ADMIN PAYROLL ENGINE MODULE ROUTES
$routes->GET('admin/payroll', 'PayrollAdminController::index');
$routes->POST('admin/payroll/create', 'PayrollAdminController::create_cycle');
$routes->GET('admin/payroll/view/(:num)', 'PayrollAdminController::view_cycle/$1');
$routes->POST('admin/payroll/import_attendance/(:num)', 'PayrollAdminController::import_attendance/$1');
$routes->GET('admin/payroll/calculate/(:num)', 'PayrollAdminController::calculate_cycle/$1');
$routes->POST('admin/payroll/add_adjustment', 'PayrollAdminController::add_adjustment');
$routes->POST('admin/payroll/update_status', 'PayrollAdminController::update_status');
$routes->GET('admin/payroll/employee_detail/(:num)/(:any)', 'PayrollAdminController::employee_detail/$1/$2');
$routes->match(['get', 'post'], 'admin/payroll/components', 'PayrollAdminController::components');
$routes->POST('admin/payroll/save_component', 'PayrollAdminController::save_component');
$routes->GET('admin/payroll/delete_component/(:num)', 'PayrollAdminController::delete_component/$1');
$routes->GET('admin/payroll/toggle_component/(:num)', 'PayrollAdminController::toggle_component/$1');
$routes->GET('admin/payroll/structures', 'PayrollAdminController::structures');
$routes->GET('admin/payroll/get_emp_structure/(:any)', 'PayrollAdminController::get_emp_structure/$1');
$routes->POST('admin/payroll/save_structure', 'PayrollAdminController::save_structure');
$routes->POST('admin/payroll/save_employee_draft', 'PayrollAdminController::save_employee_draft');


$routes->GET('employee/new_emp_payslip/(:any)/(:any)/(:any)', 'SalaryController::emp_payslip/$1/$2/$3');
$routes->POST('employee/new_emp_payslip/(:any)/(:any)/(:any)', 'SalaryController::emp_payslip/$1/$2/$3');

// NOTIFICATIONS SYSTEM ROUTES
$routes->get('employee/notifications', 'NotificationController::index');
$routes->post('notifications/mark_read', 'NotificationController::mark_read');
$routes->get('notifications/header_count', 'NotificationController::get_unread_count');


$routes->GET('employee/salaryinvoice', 'SalaryController::Sal_invoice');
$routes->POST('employee/salaryinvoice', 'SalaryController::Sal_invoice');


//SWITCH ROLES
$routes->GET('switchrole/HR', 'Home::switchRoleHR');
$routes->GET('switchrole/ADMIN', 'Home::switchRoleADMIN');