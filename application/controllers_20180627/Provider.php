<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Provider extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library(array('ion_auth', 'form_validation'));
        $this->load->helper(array('url', 'language', 'email'));
        set_smtp_config();

        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
        $this->lang->load('auth');
        $uri_segment = $this->uri->segment(2, 0);
        $this->load->model('college_model');
        $this->load->model('provider_model');
        $this->load->model('thirdparty_model', 'tp');
        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect(SITE_URL, 'refresh');
            exit;
        } else {
            $current_user = $this->ion_auth->user()->row();
            $user_type = $current_user->user_type;
            if ($user_type != 3) {
                if ($user_type == 1) {
                    redirect(SADMIN_URL . "dashboard");
                } else if ($user_type == 2) {
                    redirect(COLLEGE_URL . "dashboard");
                } else if ($user_type == 4) {
                    redirect(PATIENT_URL . "dashboard");
                } else {
                    redirect(PROVIDER_URL . "dashboard");
                }
            }
        }
        $this->basic_model->set_current_timezone();
    }

    function index() {
        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect(SITE_URL, 'refresh');
            exit;
        } else {
            redirect(PROVIDER_URL . "dashboard");
        }
    }

    function dashboard() {
        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect(SITE_URL, 'refresh');
            exit;
        } else {
            $current_user = $this->ion_auth->user()->row();
            $user_complete_status = $this->basic_model->getUserCompletenessStatus($current_user->user_id);
            if (isset($user_complete_status) && $user_complete_status != 1) {
                redirect(PROVIDER_URL . "manage_profile");
            }
            $this->data = array();
            $limit = 10;
            $this->data['total_transaction_amount'] = $this->provider_model->get_total_transaction($current_user->user_id);
            $this->data['total_upcomming_appointment'] = $this->provider_model->get_total_upcomming_appointment($current_user->user_id);
            $this->data['total_appointment'] = $this->provider_model->get_total_appointment($current_user->user_id);
            $this->data['total_patient'] = $this->provider_model->get_total_patient($current_user->user_id);
            $this->data['our_patient'] = $this->provider_model->get_our_patient($current_user->user_id);
            $this->data['upcoming_appointment'] = $this->provider_model->get_upcoming_appointment($current_user->user_id, $limit);
            $this->data['past_appointment'] = $this->provider_model->get_past_appointment($current_user->user_id, $limit);
            $this->sidebardata = array();
            $this->sidebardata["username"] = ucwords($current_user->first_name . ' ' . $current_user->last_name);
            $this->sidebardata["profile_photo"] = $current_user->profile_image;
            $this->sidebardata["role_name"] = $this->basic_model->get_user_role($current_user->user_type);
            $this->headerdata['page_title'] = "Dashboard";
            $this->headerdata['breadcrumbs'] = array(PROVIDER_URL, array('dashboard', 'Dashboard'));
            $this->sidebardata['is_active'] = 'dashboard';
            $this->templatelayout->get_admin_dashboard_header($this->headerdata);
            $this->templatelayout->get_admin_dashboard_footer();
            $this->templatelayout->get_admin_dashboard_sidebar('providersidebar', $this->sidebardata);
            $this->elements['middle'] = 'provider/dashboard';
            $this->elements_data['middle'] = $this->data;
            $this->layout->setLayout('backend_layout/dashboardlayout');
            $this->layout->multiple_view($this->elements, $this->elements_data);
        }
    }

    function upcoming_appoinment() {
        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect(SITE_URL, 'refresh');
            exit;
        } else {
            $current_user = $this->ion_auth->user()->row();
            $user_complete_status = $this->basic_model->getUserCompletenessStatus($current_user->user_id);
            if (isset($user_complete_status) && $user_complete_status != 1) {
                redirect(PROVIDER_URL . "manage_profile");
            }
            $this->data = array();
            $this->data['upcoming_appointment'] = $this->provider_model->get_upcoming_appointment($current_user->user_id);

            $this->sidebardata = array();
            $this->sidebardata["username"] = ucwords($current_user->first_name . ' ' . $current_user->last_name);
            $this->sidebardata["profile_photo"] = $current_user->profile_image;
            $this->sidebardata["role_name"] = $this->basic_model->get_user_role($current_user->user_type);
            $this->headerdata['page_title'] = "Upcoming Appoinments";
            $this->headerdata['breadcrumbs'] = array(PROVIDER_URL, array('dashboard', 'Dashboard'), array('upcoming_appoinment', 'Upcoming Appoinments'));
            $this->sidebardata['is_active'] = 'dashboard';
            $this->templatelayout->get_admin_dashboard_header($this->headerdata);
            $this->templatelayout->get_admin_dashboard_footer();
            $this->templatelayout->get_admin_dashboard_sidebar('providersidebar', $this->sidebardata);
            $this->elements['middle'] = 'provider/upcoming_appoinment';
            $this->elements_data['middle'] = $this->data;
            $this->layout->setLayout('backend_layout/dashboardlayout');
            $this->layout->multiple_view($this->elements, $this->elements_data);
        }
    }

    public function manage_profile() {
        if (!$this->ion_auth->logged_in()) {
            redirect(SITE_URL, 'refresh');
            exit;
        } else {
            $current_user = $this->ion_auth->user()->row();
            $provider_profile_data = $this->provider_model->getProfileData($current_user->user_id);

            $this->data = array();
            $this->headerdata = array();
            $postdata = isset($_SESSION['postdata']) ? $_SESSION['postdata'] : '';


            $this->data['title'] = "Manage Provider";

            $tables = $this->config->item('tables', 'ion_auth');
            $identity_column = $this->config->item('identity', 'ion_auth');
            $this->data['identity_column'] = $identity_column;
            // display the create user form
            // set the flash data error message if there is one
            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
            $this->data['error'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('error')));

            $this->data['user_type'] = array(
                'name' => 'user_type',
                'id' => 'user_type',
                "class" => "form-control ",
                'type' => 'text',
                'maxlength' => '5',
                'value' => '3',
                'type' => 'hidden'
            );

            $this->data['user_id'] = array(
                'name' => 'user_id',
                'id' => 'user_id',
                "class" => "form-control ",
                'type' => 'text',
                'maxlength' => '5',
                'value' => $current_user->user_id,
                'type' => 'hidden'
            );

            $this->data['user_email'] = array(
                'name' => 'user_email',
                'id' => 'user_email',
                "class" => "form-control",
                'type' => 'text',
                'maxlength' => '100',
                'readonly' => 'readonly',
                'placeholder' => "e.g. you@widgetcorp.com",
                'value' => isset($postdata) && !empty($postdata) && isset($postdata['user_email']) ? $postdata['user_email'] : $provider_profile_data->user_email
            );

            $this->data['first_name'] = array(
                'name' => 'first_name',
                'id' => 'first_name',
                'type' => 'text',
                'maxlength' => '32',
                "class" => "form-control  col-md-7 col-xs-12",
                'placeholder' => "Provider First Name",
                'value' => isset($postdata) && !empty($postdata) && isset($postdata['first_name']) ? $postdata['first_name'] : $provider_profile_data->first_name
            );
            $this->data['last_name'] = array(
                'name' => 'last_name',
                'id' => 'last_name',
                'type' => 'text',
                'maxlength' => '32',
                "class" => "form-control  col-md-7 col-xs-12",
                'placeholder' => "Provider Last Name",
                'value' => isset($postdata) && !empty($postdata) && isset($postdata['last_name']) ? $postdata['last_name'] : $provider_profile_data->last_name
            );
            $this->data['mobile_no'] = array(
                'name' => 'mobile_no',
                'id' => 'mobile_no',
                'type' => 'text',
                'maxlength' => '15',
                "class" => "form-control  col-md-7 col-xs-12 mobilemark",
                'placeholder' => "___-___-____",
                'value' => isset($postdata) && !empty($postdata) && isset($postdata['mobile_no']) ? $postdata['mobile_no'] : $provider_profile_data->mobile_no
            );
            $this->data['biography'] = array(
                'name' => 'biography',
                'id' => 'biography',
                'type' => 'textarea',
                'rows' => 5,
                'maxlength' => '500',
                "class" => "form-control",
                'placeholder' => "Provider Biography",
                'value' => isset($postdata) && !empty($postdata) && isset($postdata['biography']) ? $postdata['biography'] : $provider_profile_data->biography
            );

            $this->data['session_cost'] = array(
                'name' => 'session_cost',
                'id' => 'session_cost',
                'type' => 'text',
                'maxlength' => '7',
                "class" => "form-control  col-md-7 col-xs-12 allow_decimal", //decimalNumber
                'placeholder' => "Provider average rate per 45 minute session ($)",
                'value' => isset($postdata) && !empty($postdata) && isset($postdata['session_cost']) ? $postdata['session_cost'] : $provider_profile_data->session_cost
            );
            $this->data['is_profile_completeness'] = $current_user->is_profile_completeness;
            $this->data['is_user_active'] = $current_user->user_status;
            $this->data['is_disabled'] = $current_user->is_disabled;
            $this->data['college'] = array('' => 'Select College') + $this->college_model->getCollege();
            $this->data['college_id_selected'] = $provider_profile_data->college_id;
            $this->data['speciality'] = $this->basic_model->get_specialitylist();
            $this->data['insurence_list'] = $this->basic_model->get_insurencelist();
            $profileSpeciality = $profileInsurance = "";

            if (isset($provider_profile_data->specialities) && !empty($provider_profile_data->specialities)) {
                $profileSpeciality = explode(',', $provider_profile_data->specialities);
            }

            if (isset($provider_profile_data->insurance_carriers) && !empty($provider_profile_data->insurance_carriers)) {
                $profileInsurance = explode(',', $provider_profile_data->insurance_carriers);
            }

            $this->data['timezone_list'] = $this->basic_model->get_timezonelist();
            if (isset($provider_profile_data->timezone_id) && !empty($provider_profile_data->timezone_id)) {
                $timezone_id = $provider_profile_data->timezone_id;
            } else {
                $timezone_id = DEFAULT_TIMEZONE;
            }
            $this->data['timezone_list_selected'] = $timezone_id;

            $this->data['speciality_selected'] = $profileSpeciality;
            $this->data['insurence_selected'] = $profileInsurance;
            $this->data['profile_image'] = $provider_profile_data->profile_image;
            $this->data['photo_id'] = $provider_profile_data->photo_id;

//            $certificate_uploads = $this->tp->getthirdparty_counseling_certifications($current_user->user_id);
//            $insurance_certificate_upload = "";
//            if (isset($certificate_uploads) && !empty($certificate_uploads)) {
//                foreach ($certificate_uploads as $upload) {
//                    $insurance_certificate_upload[] = $upload;
//                }
//            }
//            $this->data['insurance_certificate_upload'] = $insurance_certificate_upload;
//
//            $malpractice_uploads = $this->tp->getthirdparty_malpractice_insurance_certifications($current_user->user_id);
//
//            $malpractice_certificate_upload = "";
//            if (isset($malpractice_uploads) && !empty($malpractice_uploads)) {
//                foreach ($malpractice_uploads as $upload) {
//                    $malpractice_certificate_upload[] = $upload;
//                }
//            }
//            $this->data['malpractice_certificate_upload'] = $malpractice_certificate_upload;
            $this->sidebardata = array();
            $this->sidebardata["username"] = ucwords($current_user->first_name . ' ' . $current_user->last_name);
            $this->sidebardata['is_active'] = 'manage_profile';

            $this->sidebardata["username"] = ucwords($current_user->first_name . ' ' . $current_user->last_name);

            $this->sidebardata["profile_photo"] = $current_user->profile_image;
            $this->sidebardata["role_name"] = $this->basic_model->get_user_role($current_user->user_type);
            $this->headerdata['page_title'] = "Manage Profile";
            $this->data['current_user'] = $current_user;
            $this->headerdata['breadcrumbs'] = array(PROVIDER_URL, array('dashboard', 'Dashboard'), array('manage_profile', 'Manage Profile'));
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
            $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
            $this->templatelayout->get_admin_dashboard_header($this->headerdata);
            $this->templatelayout->get_admin_dashboard_footer();
            $this->templatelayout->get_admin_dashboard_sidebar('providersidebar', $this->sidebardata);
            $this->elements['middle'] = 'provider/provider_manage_profile';
            $this->elements_data['middle'] = $this->data;
            $this->layout->setLayout('backend_layout/dashboardlayout');
            $this->layout->multiple_view($this->elements, $this->elements_data);
        }
    }

    public function manage_provider_profile() {
        // Configuration options
        $tables = $this->config->item('tables', 'ion_auth');
        $identity_column = $this->config->item('identity', 'ion_auth');
        $this->data['identity_column'] = $identity_column;

        unset($_SESSION['postdata']);
        $this->form_validation->set_rules('first_name', $this->lang->line('create_user_validation_fname_label'), 'required');
        $this->form_validation->set_rules('last_name', $this->lang->line('create_user_validation_lname_label'), 'required');
        $this->form_validation->set_rules('mobile_no', $this->lang->line('create_user_validation_mobile_no_label'), 'required');
        $this->form_validation->set_rules('session_cost', $this->lang->line('create_user_validation_cost_label'), 'required');
        $this->form_validation->set_rules('biography', $this->lang->line('create_user_validation_biography_label'), 'required');
        $this->form_validation->set_rules('specialities[]', $this->lang->line('create_user_validation_specialities_label'), 'required');
        $this->form_validation->set_rules('insurance_carriers[]', $this->lang->line('create_user_validation_insurance_carriers_label'), 'required');

        if ($this->form_validation->run() == true) {
            // check to see if we are creating the user
            // redirect them back to the admin page
            $this->load->model("basic_model");

            $additional_data = array();

            $post_arr = $this->input->post();
            $post_arr = $this->basic_model->stripTagsPostArray($post_arr);
//            if (isset($_FILES['counseling_certifications']) && !empty($_FILES['counseling_certifications'])) {
//                $counseling_doc = count($_FILES['counseling_certifications']['size']);
//                $j = 0;
//                for ($i = 1; $i <= $counseling_doc; $i++) {
//                    if (isset($_FILES['counseling_certifications']) && $_FILES['counseling_certifications']['size'][$j] > 0) {
//                        if (isset($post_arr['document_name']) && empty($post_arr['document_name'][$j])) {
//                            $_SESSION['postdata'] = $_POST;
//                            $this->session->set_flashdata('error', "Please enter document name with uploading documents.");
//                            redirect(PROVIDER_URL . "manage_profile");
//                        }
//                    }
//                    $j++;
//                }
//            }
//
//            if (isset($_FILES['malpractice_certifications']) && !empty($_FILES['malpractice_certifications'])) {
//                $counseling_doc = count($_FILES['malpractice_certifications']['size']);
//                $j = 0;
//                for ($i = 1; $i <= $counseling_doc; $i++) {
//                    if (isset($_FILES['malpractice_certifications']) && $_FILES['malpractice_certifications']['size'][$j] > 0) {
//                        if (isset($post_arr['malpractice_document_name']) && empty($post_arr['malpractice_document_name'][$j])) {
//                            $_SESSION['postdata'] = $_POST;
//                            $this->session->set_flashdata('error', "Please enter malpractice document name with uploading malpractice insurance certifications.");
//                            redirect(PROVIDER_URL . "manage_profile");
//                        }
//                    }
//                    $j++;
//                }
//            }
            if ($this->provider_model->update_provider($post_arr)) {
                $this->session->set_flashdata('message', $this->lang->line('profile_update_provider'));
                redirect(PROVIDER_URL . "manage_profile");
            } else {
                $_SESSION['postdata'] = $_POST;
                $this->session->set_flashdata('error', "Profile Image must be of JPG/PNG/JPEG/GIF image type.");
                redirect(PROVIDER_URL . "manage_profile");
            }
        } else {
            $_SESSION['postdata'] = $_POST;
            $this->session->set_flashdata('error', (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message'))));
            redirect(PROVIDER_URL . "manage_profile");
        }
    }

    public function changepassword() {

        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect(SITE_URL, 'refresh');
            exit;
        } else {
            $current_user = $this->ion_auth->user()->row();
            $user_complete_status = $this->basic_model->getUserCompletenessStatus($current_user->user_id);
            if (isset($user_complete_status) && $user_complete_status != 1) {
                redirect(PROVIDER_URL . "manage_profile");
            }
            $this->data = array();
            $this->sidebardata = array();
            $this->data['script_to_include'] = "sadmin_js.js";
            $this->sidebardata["username"] = $current_user->first_name . " " . $current_user->last_name;
            $this->sidebardata['is_active'] = 'changepassword';
            $this->sidebardata["profile_photo"] = $current_user->profile_image;
            $this->sidebardata["role_name"] = $this->basic_model->get_user_role($current_user->user_type);
            $this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
            $this->data['old_password'] = array(
                'name' => 'old',
                'id' => 'old',
                'type' => 'password',
                'class' => 'form-control',
                'placeholder' => 'Old Password'
            );
            $this->data['new_password'] = array(
                'name' => 'new',
                'id' => 'new',
                'type' => 'password',
                'class' => 'form-control',
                'placeholder' => 'New Password'
            );
            $this->data['new_password_confirm'] = array(
                'name' => 'new_confirm',
                'id' => 'new_confirm',
                'type' => 'password',
                'class' => 'form-control',
                'placeholder' => 'Confirm New Password'
            );
            $this->data['user_id'] = array(
                'name' => 'user_id',
                'id' => 'user_id',
                'type' => 'hidden',
                'value' => $current_user->id,
            );
            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
            $this->data['error'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('error')));
            $this->headerdata['page_title'] = "Change Password";
            $this->headerdata['breadcrumbs'] = array(PROVIDER_URL, array('dashboard', 'Dashboard'), array('changepassword', 'Change Password'));
            $this->templatelayout->get_admin_dashboard_header($this->headerdata);
            $this->templatelayout->get_admin_dashboard_footer();
            $this->templatelayout->get_admin_dashboard_sidebar('providersidebar', $this->sidebardata);
            $this->elements['middle'] = 'provider/change_password';
            $this->elements_data['middle'] = $this->data;
            $this->layout->setLayout('backend_layout/dashboardlayout');
            $this->layout->multiple_view($this->elements, $this->elements_data);
        }
    }

    public function change_password() {
        $current_user = $this->ion_auth->user()->row();
        $user_complete_status = $this->basic_model->getUserCompletenessStatus($current_user->user_id);
        if (isset($user_complete_status) && $user_complete_status != 1) {
            redirect(PROVIDER_URL . "manage_profile");
        }

        $this->form_validation->set_rules('old', $this->lang->line('change_password_validation_old_password_label'), 'required');
        $this->form_validation->set_rules('new', $this->lang->line('change_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
        $this->form_validation->set_rules('new_confirm', $this->lang->line('change_password_validation_new_password_confirm_label'), 'required');
        if ($this->form_validation->run() == true) {
            $identity = $this->session->userdata('identity');
            $change = $this->ion_auth->change_password($identity, $this->input->post('old'), $this->input->post('new'));
            $identity_u = $this->config->item('identity', 'ion_auth');
            if ($change) {
                $userinfo = $this->basic_model->get_userinfo($this->input->post('user_id'));
                $data = array(
                    'identity' => $userinfo->{$identity_u}
                );
                $this->load->model('basic_model');
                $message_content = $this->basic_model->get_mail_template('change_password');
                if (isset($message_content) && !empty($message_content)) {
                    $mail_content = html_entity_decode($message_content->mail_template_content);
                    $message = str_replace("{{identity}}", $data['identity'], $mail_content);
                    $message = MAIL_HEADER . $message . MAIL_FOOTER;
                    $this->email->clear();
                    $this->email->from($this->config->item('admin_email', 'ion_auth'), $this->config->item('site_title', 'ion_auth'));
                    $this->email->to($userinfo->user_email);
                    $this->email->subject($message_content->mail_subject);
                    $this->email->message($message);
                    if ($this->email->send() == TRUE) {
                        $this->session->set_flashdata('message', $this->ion_auth->messages());
                        redirect(PROVIDER_URL . "changepassword", 'refresh');
                    } else {
                        $this->session->set_flashdata('message', $this->ion_auth->messages());
                        redirect(PROVIDER_URL . "changepassword", 'refresh');
                    }
                } else {

                    $this->session->set_flashdata('message', $this->ion_auth->messages());

                    redirect(PROVIDER_URL . "changepassword", 'refresh');
                }
            } else {

                $this->session->set_flashdata('error', $this->ion_auth->errors());

                redirect(PROVIDER_URL . "changepassword", 'refresh');
            }
        } else {

            $this->session->set_flashdata('error', (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message'))));
            redirect(PROVIDER_URL . "changepassword");
        }
    }

    public function availability() {
        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect(SITE_URL, 'refresh');
            exit;
        } else {

            $current_user = $this->ion_auth->user()->row();

            $user_complete_status = $this->basic_model->getUserCompletenessStatus($current_user->user_id);
            if (isset($user_complete_status) && $user_complete_status != 1) {
                redirect(PROVIDER_URL . "manage_profile");
            }

            $this->data = array();

            $this->sidebardata = array();

            $this->data['script_to_include'] = "sadmin_js.js";
            $this->sidebardata["username"] = $current_user->first_name . " " . $current_user->last_name;
            $this->sidebardata['is_active'] = 'availabality';
            $this->sidebardata["profile_photo"] = $current_user->profile_image;
            $this->sidebardata["role_name"] = $this->basic_model->get_user_role($current_user->user_type);
            $this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
            $this->data['provider_id'] = $current_user->user_id;

            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
            $this->data['error'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('error')));
            $this->headerdata['page_title'] = "Availability";
            $schedule = $this->provider_model->getProviderShcedule($current_user->user_id);
            if (isset($schedule) && !empty($schedule)) {
                $this->data['schedules'] = $schedule;
            }
            $this->load->model('basic_model');
            $this->data['avail_times'] = $this->basic_model->get_times();
            $this->headerdata['breadcrumbs'] = array(PROVIDER_URL, array('dashboard', 'Dashboard'), array('availabality', 'Availability'));
            $this->templatelayout->get_admin_dashboard_header($this->headerdata);
            $this->templatelayout->get_admin_dashboard_footer();
            $this->templatelayout->get_admin_dashboard_sidebar('providersidebar', $this->sidebardata);
            $this->elements['middle'] = 'provider/availabality';
            $this->elements_data['middle'] = $this->data;
            $this->layout->setLayout('backend_layout/dashboardlayout');
            $this->layout->multiple_view($this->elements, $this->elements_data);
        }
    }

    public function saveavailabality() {
        $provider_id = $this->input->post('provider_id');
        $startdate = $this->input->post('startdate');
        $enddate = $this->input->post('enddate');
        //$timeslots = $_POST['timeslot'];

        $startdate = $this->basic_model->set_utc_datetime($startdate);

        $startTime = strtotime($startdate);
        $endTime = strtotime('+45 minutes', $startTime);

        $count = $this->basic_model->check_availability($provider_id, $startTime, $endTime);
        if ($count['avl_count'] > 0) {
            $this->session->set_flashdata('error', 'This appointment could not be created because it overlaps with an existing appointment time.');
            redirect('provider/availability');
        }
//       die;
        /*
          while ($startTime < $endTime)
          {
          $datatoinsert = array();
          if(strtotime('+45 minutes',$startTime) < $endTime)
          {
          $datatoinsert['provider_id'] = $provider_id;
          $datatoinsert['start_date'] = date('Y-m-d', strtotime($startdate));
          $datatoinsert['end_date'] = date('Y-m-d', strtotime($enddate));
          $datatoinsert['start_time'] = date('H:i', $startTime);
          $datatoinsert['end_time'] = date('H:i', strtotime('+45 minutes',$startTime));
          $this->db->insert('bm_provider_availablity', $datatoinsert);
          }
          $startTime = strtotime('+45 minutes',$startTime);
          }
         */

        $datatoinsert = array();
        $datatoinsert['provider_id'] = $provider_id;
        $datatoinsert['start_date'] = date('Y-m-d', strtotime($startdate));
        $datatoinsert['end_date'] = date('Y-m-d', strtotime('+45 minutes', $startTime));
        $datatoinsert['start_time'] = date('H:i', $startTime);
        $datatoinsert['end_time'] = date('H:i', strtotime('+45 minutes', $startTime));
        $this->db->insert('bm_provider_availablity', $datatoinsert);
        $last_id = $this->db->insert_id();

        /*
          $startTime = strtotime($startdate);
          $endTime = strtotime($enddate);
          // Loop between timestamps, 24 hours at a time
          for ($i = $startTime; $i < $endTime; $i = $i + 86400) {
          for ($t = 0; $t < count($timeslots); $t++) {
          if (isset($timeslots[$t + 1])) {
          $datatoinsert = array();
          $datatoinsert['provider_id'] = $provider_id;
          $datatoinsert['start_date'] = date('Y-m-d', $i);
          $datatoinsert['end_date'] = date('Y-m-d', $i);
          $datatoinsert['start_time'] = date('h:i A', strtotime($timeslots[$t]));
          $datatoinsert['end_time'] = date('h:i A', strtotime($timeslots[$t + 1]));

          $this->db->insert('bm_provider_availablity', $datatoinsert);
          }
          }
          }
         */



        if ($last_id) {
            $this->session->set_flashdata('message', 'Availability Created Successfully.');
            redirect('provider/availability');
        } else {
            $this->session->set_flashdata('error', 'Your Availability scheduling not correct, please define the atleast 45 minutes session time.');
            redirect('provider/availability');
        }
    }

    public function view_profile() {
        if (!$this->ion_auth->logged_in()) {
            redirect(SITE_URL, 'refresh');
            exit;
        } else {
            $current_user = $this->ion_auth->user()->row();

            $user_complete_status = $this->basic_model->getUserCompletenessStatus($current_user->user_id);
            if (isset($user_complete_status) && $user_complete_status != 1) {
                redirect(PROVIDER_URL . "manage_profile");
            }

            $provider_profile_data = $this->provider_model->getProfileData($current_user->user_id);
            $this->data = array();
            $this->headerdata = array();

            if (isset($provider_profile_data->specialities) && !empty($provider_profile_data->specialities)) {
                $speciality = $this->basic_model->getSpecialityName($provider_profile_data->specialities);
            } else {
                $speciality = "N/A";
            }

            $this->data['current_user'] = $current_user;
            $this->data['speciality'] = $speciality;
            $this->data['title'] = "View Profile";
            $this->data['profile_data'] = $provider_profile_data;
            $tables = $this->config->item('tables', 'ion_auth');
            $identity_column = $this->config->item('identity', 'ion_auth');
            $this->data['identity_column'] = $identity_column;
            // display the create user form
            // set the flash data error message if there is one
            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
            $this->data['error'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('error')));

            if (isset($provider_profile_data->timezone_id) && !empty($provider_profile_data->timezone_id)) {
                $timezone = $this->basic_model->getTimeZoneName($provider_profile_data->timezone_id);
            } else {
                $timezone = "N/A";
            }
            $this->data['timezone'] = $timezone;
            $this->data['is_owner'] = '1';
            if (isset($provider_profile_data->college_id) && !empty($provider_profile_data->college_id)) {
                $college_name = $this->basic_model->getCollegeName($provider_profile_data->college_id);
            } else {
                $college_name = "N/A";
            }
            $this->data['CollegeName'] = $college_name;

            if (isset($provider_profile_data->insurance_carriers) && !empty($provider_profile_data->insurance_carriers)) {
                $insurence_name = $this->basic_model->getInsurenceName($provider_profile_data->insurance_carriers);
            } else {
                $insurence_name = "N/A";
            }
            $this->data['InsurenceName'] = $insurence_name;
            $this->sidebardata = array();
            $this->sidebardata["username"] = ucwords($provider_profile_data->first_name . ' ' . $provider_profile_data->last_name);
            $this->sidebardata['is_active'] = 'manage_profile';


            $this->sidebardata["profile_photo"] = $provider_profile_data->profile_image;
            $this->headerdata['page_title'] = "View provider Profile";
            $this->headerdata['breadcrumbs'] = array(PROVIDER_URL, array('dashboard', 'Dashboard'), array('view_profile', 'View Provider Profile'));
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
            $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
            $this->templatelayout->get_admin_dashboard_header($this->headerdata);
            $this->templatelayout->get_admin_dashboard_footer();
            $this->templatelayout->get_admin_dashboard_sidebar('providersidebar', $this->sidebardata);
            $this->elements['middle'] = 'provider/view_profile';
            $this->elements_data['middle'] = $this->data;

            $this->layout->setLayout('backend_layout/dashboardlayout');
            $this->layout->multiple_view($this->elements, $this->elements_data);
        }
    }

    public function update_schedule() {
        $avail_id = $this->input->post('avail_id');
        $provider_id = $this->input->post('provider_id');
        $slot_id = $this->input->post('slot_id');
        $patient_id = $this->input->post('patient_id');
        $app_id = $this->input->post('app_id');
        $app_status = $this->input->post('app_status');
        $this->data = array();
        if (isset($avail_id) && !empty($avail_id)) {
            $this->data['avail_id'] = $avail_id;
        }
        if (isset($app_id) && !empty($app_id) && $app_id > 0) {
            $this->data['app_id'] = $app_id;
        }
        if (isset($provider_id) && !empty($provider_id)) {
            $this->data['provider_id'] = $provider_id;
        }
        if (isset($slot_id) && !empty($slot_id)) {
            $this->data['slot_id'] = $slot_id;
        }
        if (isset($patient_id) && !empty($patient_id)) {
            $this->data['patient_id'] = $patient_id;
        }
        if (isset($app_status) && !empty($app_status)) {
            $this->data['app_status'] = $app_status;
        }
        $avail_info = $this->provider_model->get_avail_info($avail_id);
        if (isset($avail_info) && !empty($avail_info)) {
            $this->data['avail_info'] = $avail_info[0];
        }
        $this->data['avail_times'] = $this->basic_model->get_times(date('H:i', strtotime($avail_info[0]->start_time)));
        $this->load->model('basic_model');
        $patient_info = $this->provider_model->get_user_info($patient_id);

        if (isset($patient_info) && !empty($patient_info)) {
            $this->data['patient_info'] = $patient_info[0];
        }
        $this->load->view('provider/update_schedule', $this->data);
    }

    public function updateavailabality() {

        $ttype = $this->input->post('ttype');
        $provider_id = $this->input->post('provider_id');
        $patient_id = $this->input->post('patient_id');
        $avail_id = $this->input->post('avail_id');
        try {
            if (isset($ttype) && !empty($ttype)) {
                if ($ttype == "appointment" && isset($patient_id) && !empty($patient_id)) {
                    $update = $this->provider_model->update_appointment($avail_id, $provider_id, $patient_id);
                    if ($update) {
                        $patient_data = $this->basic_model->get_user_data($patient_id);
                        $this->load->model('patient_model');
                        $provider_data = $this->patient_model->get_provider_data($provider_id);
                        $provider_data = $provider_data[0];
                        $appointment_data = $this->provider_model->get_avail_info($avail_id);
                        $appointment_data = (array) $appointment_data[0];
                        $app_id = $this->input->post('app_id');
                        $transaction = $this->provider_model->get_appointment_transaction($app_id);
                        $chk_refund_amt = $this->basic_model->chk_applied_coupon(serialize($transaction));
                        $metadata = array(
                            'patient_id' => $patient_id,
                            'provider_id' => $provider_id,
                            'appointment_id' => $app_id,
                            'amount_to_bm' => $transaction['amount_to_bm'],
                            'amount_to_provider' => $transaction['amount_to_provider'],
                        );

                        if (isset($transaction['charge_id']) && !empty($transaction['charge_id']) && $chk_refund_amt > 0) {
                            require_once(APPPATH . 'libraries/Stripe/lib/Stripe.php'); //or you
                            Stripe::setApiKey(STRIPE_SK); //Replace with your Secret Key


                            $k = new Stripe_Charge($transaction['charge_id'], STRIPE_SK);
                            $refund = $k->refund(array(
                                //"charge" => $transaction['charge_id'],
                                "metadata" => $metadata,
                                "reason" => 'requested_by_customer',
                            ));
                            $refund = $refund->__toArray(true);
                        } else {
                            $refund = array();
                            $refund['metadata'] = $metadata;
                            $refund['reason'] = 'requested_by_customer';
                            $refund['refunded'] = 1;
                        }
                        $this->provider_model->appointment_refund(serialize($refund), serialize($transaction));


                        $message_content = $this->basic_model->get_mail_template('appointment_canceled_by_provider');
                        $mail_content = html_entity_decode($message_content->mail_template_content);
                        $message = str_replace("{{identity}}", $provider_data['first_name'] . " " . $provider_data['last_name'], $mail_content);
                        $message = str_replace("{{patient_name}}", $patient_data['first_name'] . " " . $patient_data['last_name'], $message);
                        $message = str_replace("{{siteurl}}", SITE_URL, $message);
                        $message = str_replace("{{appointment_date}}", show_date($appointment_data['start_date'] . ' ' . $appointment_data['start_time']), $message);
                        $message = str_replace("{{appointment_time}}", show_time($appointment_data['start_date'] . ' ' . $appointment_data['start_time']), $message);
                        $message = str_replace("{{payment_info}}", CURRENCY_SYMBOL . $provider_data['session_cost'], $message);
                        $message = MAIL_HEADER . $message . MAIL_FOOTER;

                        $this->email->clear();
                        $this->email->from($this->config->item('admin_email', 'ion_auth'), $this->config->item('site_title', 'ion_auth'));
                        $this->email->to($provider_data['user_email']);
                        $this->email->subject($message_content->mail_subject);
                        $this->email->message($message);
                        $this->email->send();

                        $message_content = $this->basic_model->get_mail_template('appointment_canceled_patient');
                        $mail_content = html_entity_decode($message_content->mail_template_content);
                        $message = str_replace("{{identity}}", $patient_data['first_name'] . " " . $patient_data['last_name'], $mail_content);
                        $message = str_replace("{{provider_name}}", $provider_data['first_name'] . " " . $provider_data['last_name'], $message);
                        $message = str_replace("{{siteurl}}", SITE_URL, $message);
                        $message = str_replace("{{appointment_date}}", show_date($appointment_data['start_date'] . ' ' . $appointment_data['start_time'], $patient_data['timezone_code']), $message);
                        $message = str_replace("{{appointment_time}}", show_time($appointment_data['start_date'] . ' ' . $appointment_data['start_time'], $patient_data['timezone_code']), $message);
                        $message = str_replace("{{payment_info}}", CURRENCY_SYMBOL . $provider_data['session_cost'], $message);
                        $message = MAIL_HEADER . $message . MAIL_FOOTER;

                        $this->email->clear();
                        $this->email->from($this->config->item('admin_email', 'ion_auth'), $this->config->item('site_title', 'ion_auth'));
                        $this->email->to($patient_data['user_email']);
                        $this->email->subject($message_content->mail_subject);
                        $this->email->message($message);
                        $this->email->send();

                        //send mail to admin
                        $admin = $this->basic_model->getAdminDetails();
                        $message_content = $this->basic_model->get_mail_template('appointment_canceled_send_to_admin');
                        $mail_content = html_entity_decode($message_content->mail_template_content);
                        $message = str_replace("{{identity}}", ucfirst($admin['first_name'] . " " . $admin['last_name']), $mail_content);
                        $message = str_replace("{{cancelled_by}}", ucfirst($provider_data['first_name'] . " " . $provider_data['last_name']), $message);
                        $message = str_replace("{{patient_name}}", ucfirst($patient_data['first_name'] . " " . $patient_data['last_name']), $message);
                        $message = str_replace("{{patient_email}}", $patient_data['user_email'], $message);
                        $message = str_replace("{{counselor_name}}", ucfirst($provider_data['first_name'] . " " . $provider_data['last_name']), $message);
                        $message = str_replace("{{counselor_email}}", $provider_data['user_email'], $message);
                        $message = str_replace("{{appointment_date}}", show_date($appointment_data['start_date'] . ' ' . $appointment_data['start_time'], $admin['timezone_code']), $message);
                        $message = str_replace("{{appointment_time}}", show_time($appointment_data['start_date'] . ' ' . $appointment_data['start_time'], $admin['timezone_code']), $message);
                        $message = MAIL_HEADER . $message . MAIL_FOOTER;

                        $this->email->clear();
                        $this->email->from($this->config->item('admin_email', 'ion_auth'), $this->config->item('site_title', 'ion_auth'));
                        $this->email->to($admin['user_email']);
                        $this->email->subject($message_content->mail_subject);
                        $this->email->message($message);
                        $this->email->send();

                        $this->session->set_flashdata('message', "Appointment Cancelled Successfully.");
                        redirect(PROVIDER_URL . 'availability');
                    }
                } else {
                    $update = $this->provider_model->update_schedule($avail_id);
                    if ($update) {
                        $this->session->set_flashdata('message', "Availability Removed Successfully.");
                        redirect(PROVIDER_URL . 'availability');
                    }
                }
            } else {
                redirect(PROVIDER_URL . "availability");
            }
        } catch (Stripe_CardError $e) {
            $json['error'] = $e->getMessage();
        } catch (Stripe_InvalidRequestError $e) {
            $json['error'] = $e->getMessage();
        } catch (Stripe_AuthenticationError $e) {
            $json['error'] = $e->getMessage();
        } catch (Stripe_Error $e) {
            $json['error'] = $e->getMessage();
        } catch (Exception $e) {
            $json['error'] = $e->getMessage();
        }
        $this->session->set_flashdata('error', $json['error']);
        redirect(PROVIDER_URL . 'availability');
    }

    public function joinappointment($app_id) {
        $app_id = base64_decode($app_id);
        shell_exec('usr/local/bin/php -' . base_url('cron/endmeeting/' . $app_id));
        $url = getstarturl($app_id);
        redirect($url);
    }

    function redirecttoadmin() {
        if (isset($_SESSION['from_admin']) && $_SESSION['from_admin'] == "1") {
            $_SESSION['from_admin'] = '';
            unset($_SESSION['from_admin']);
        } else {
            redirect(SADMIN_URL . "college");
        }
        $user_data = $this->basic_model->get_super_data();

        if (isset($user_data) && !empty($user_data)) {
            // Switchin Session Data
            $session_data = array(
                'identity' => $user_data['user_email'],
                'username' => $user_data['user_email'],
                'email' => $user_data['user_email'],
                'user_id' => $user_data['user_id'], //everyone likes to overwrite id so we'll use user_id
                'old_last_login' => $user_data['last_login'],
            );
            $this->session->set_userdata($session_data);
            //$this->session->set_userdata("total_logins", $this->basic_model->get_login_stat($user_data['user_id']));
            redirect(SADMIN_URL);
            //
        }
    }

    public function deleteCounselingCertifications() {
        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect(SITE_URL, 'refresh');
            exit;
        } else {
            $current_user = $this->ion_auth->user()->row();
            $user_complete_status = $this->basic_model->getUserCompletenessStatus($current_user->user_id);
            if (isset($user_complete_status) && $user_complete_status != 1) {
                redirect(PROVIDER_URL . "manage_profile");
            }

            if (isset($_GET['did']) && !empty($_GET['did'])) {
                $data['user_id'] = $current_user->user_id;
                $data['cerificate_doc_id'] = $_GET['did'];
                $data['doc_name'] = $_GET['doc_name'];
                $delete_certificate = $this->tp->delete_counseling_certifications($data);
                if ($delete_certificate) {
                    $this->session->set_flashdata('message', "Counseling Certification deleted succesfully.");
                    redirect(PROVIDER_URL . "manage_profile");
                } else {
                    $this->session->set_flashdata('error', "Incorrect Data!");
                    redirect(PROVIDER_URL . "manage_profile");
                }
            } else {
                $this->session->set_flashdata('error', "Incorrect Data!");
                redirect(PROVIDER_URL . "manage_profile");
            }
        }
    }

    public function deleteMalpracticeCertifications() {
        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect(SITE_URL, 'refresh');
            exit;
        } else {
            $current_user = $this->ion_auth->user()->row();
            $user_complete_status = $this->basic_model->getUserCompletenessStatus($current_user->user_id);
            if (isset($user_complete_status) && $user_complete_status != 1) {
                redirect(PROVIDER_URL . "manage_profile");
            }

            if (isset($_GET['did']) && !empty($_GET['did'])) {
                $data['user_id'] = $current_user->user_id;
                $data['cerificate_doc_id'] = $_GET['did'];
                $data['doc_name'] = $_GET['doc_name'];
                $delete_certificate = $this->tp->delete_malpractice_certifications($data);
                if ($delete_certificate) {
                    $this->session->set_flashdata('message', "Malpractice Insurance certification deleted succesfully.");
                    redirect(PROVIDER_URL . "manage_profile");
                } else {
                    $this->session->set_flashdata('error', "Incorrect Data!");
                    redirect(PROVIDER_URL . "manage_profile");
                }
            } else {
                $this->session->set_flashdata('error', "Incorrect Data!");
                redirect(PROVIDER_URL . "manage_profile");
            }
        }
    }

    public function counselingCertificateDownload() {
        $this->load->helper('download');
        if (isset($_GET['did']) && !empty($_GET['did'])) {
            $file_name = $_GET['doc_name'];
            $current_user = $this->ion_auth->user()->row();
            $fileFullPathURL = COUNSELING_FILE_UPLOAD_PATH . '/' . $current_user->user_id . "/" . $file_name;
            $data = file_get_contents(COUNSELING_FILE_UPLOAD_PATH . '/' . $current_user->user_id . "/" . $file_name);

            $file_extn = explode(".", strtolower($file_name));
            if (isset($file_extn) && !empty($file_extn)) {
                $file_extension = $file_extn[1];
            }
            if ($file_extension == "doc" || $file_extension == "docx" || $file_extension == "pdf") {
                $this->downloadFile($fileFullPathURL);
            } else {
                force_download($file_name, $data);
                //$this->downloadFile($fileFullPathURL);
            }
            force_download($file_name, $data);
        }
    }

    public function malpracticeCertificateDownload() {
        $this->load->helper('download');
        if (isset($_GET['did']) && !empty($_GET['did'])) {
            $file_name = $_GET['doc_name'];
            $current_user = $this->ion_auth->user()->row();
            $fileFullPathURL = MALPRACTICE_FILE_UPLOAD_PATH . '/' . $current_user->user_id . "/" . $file_name;
            $data = file_get_contents(MALPRACTICE_FILE_UPLOAD_PATH . '/' . $current_user->user_id . "/" . $file_name);

            $file_extn = explode(".", strtolower($file_name));
            if (isset($file_extn) && !empty($file_extn)) {
                $file_extension = $file_extn[1];
            }
            if ($file_extension == "doc" || $file_extension == "docx" || $file_extension == "pdf") {
                $this->downloadFile($fileFullPathURL);
            } else {
                force_download($file_name, $data);
                //$this->downloadFile($fileFullPathURL);
            }
            force_download($file_name, $data);
        }
    }

    public function govtIssuedIdDownload() {
        $this->load->helper('download');
        if (isset($_GET['did']) && !empty($_GET['did'])) {
            $file_name = $_GET['photo_id'];
            $current_user = $this->ion_auth->user()->row();
            $fileFullPathURL = PROFILE_FILE_UPLOAD_PATH . "/" . $file_name;
            $data = file_get_contents(PROFILE_FILE_UPLOAD_PATH . "/" . $file_name);

            $file_extn = explode(".", strtolower($file_name));
            if (isset($file_extn) && !empty($file_extn)) {
                $file_extension = $file_extn[1];
            }
            if ($file_extension == "doc" || $file_extension == "docx" || $file_extension == "pdf") {
                $this->downloadFile($fileFullPathURL);
            } else {
                force_download($file_name, $data);
                //$this->downloadFile($fileFullPathURL);
            }
            force_download($file_name, $data);
        }
    }

    public function downloadFile($file) {
        $file_name = $file;
        $mime = 'application/octet-stream';
        header('Pragma: public');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Cache-Control: private', false);
        header('Content-Type: ' . $mime);
        header('Content-Disposition: attachment; filename="' . basename($file_name) . '"');
        header('Content-Transfer-Encoding: binary');
        readfile($file_name);
        exit();
    }

    public function past_appoinment() {
        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect(SITE_URL, 'refresh');
            exit;
        } else {
            $current_user = $this->ion_auth->user()->row();
            $user_complete_status = $this->basic_model->getUserCompletenessStatus($current_user->user_id);
            if (isset($user_complete_status) && $user_complete_status != 1) {
                redirect(PROVIDER_URL . "manage_profile");
            }
            $this->data = array();
            $this->data['past_appointment'] = $this->provider_model->get_past_appointment($current_user->user_id);

            $this->sidebardata = array();
            $this->sidebardata["username"] = ucwords($current_user->first_name . ' ' . $current_user->last_name);
            $this->sidebardata["profile_photo"] = $current_user->profile_image;
            $this->sidebardata["role_name"] = $this->basic_model->get_user_role($current_user->user_type);
            $this->headerdata['page_title'] = "Past Appoinments";
            $this->headerdata['breadcrumbs'] = array(PROVIDER_URL, array('dashboard', 'Dashboard'), array('past_appoinment', 'Past Appoinments'));
            $this->sidebardata['is_active'] = 'dashboard';
            $this->templatelayout->get_admin_dashboard_header($this->headerdata);
            $this->templatelayout->get_admin_dashboard_footer();
            $this->templatelayout->get_admin_dashboard_sidebar('providersidebar', $this->sidebardata);
            $this->elements['middle'] = 'provider/past_appoinment';
            $this->elements_data['middle'] = $this->data;
            $this->layout->setLayout('backend_layout/dashboardlayout');
            $this->layout->multiple_view($this->elements, $this->elements_data);
        }
    }

}
