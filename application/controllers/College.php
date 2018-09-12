<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class College extends CI_Controller {

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
        $this->load->model('patient_model');
        $this->load->model('provider_model');
        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect(SITE_URL, 'refresh');
            exit;
        } else {
            $current_user = $this->ion_auth->user()->row();
            $user_type = $current_user->user_type;
            if ($user_type != 2) {
                if ($user_type == 1) {
                    redirect(SADMIN_URL . "dashboard");
                } else if ($user_type == 3) {
                    redirect(PROVIDER_URL . "dashboard");
                } else if ($user_type == 4) {
                    redirect(PATIENT_URL . "dashboard");
                } else {
                    redirect(THIRD_PARTY_URL . "dashboard");
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
            redirect(COLLEGE_URL . "dashboard");
        }
    }

    function dashboard() {
        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect(SITE_URL, 'refresh');
            exit;
        } else {
            $this->data = array();
            $limit = 10;
            $current_user = $this->ion_auth->user()->row();
            $user_complete_status = $this->basic_model->getUserCompletenessStatus($current_user->user_id);
            if (isset($user_complete_status) && $user_complete_status != 1) {
                redirect(COLLEGE_URL . "manage_profile");
                exit;
            }

            $this->data['total_transaction_amount'] = $this->college_model->get_TotalTransactions($current_user->user_id, $current_user->college_id);
            $this->data['total_patient'] = $this->college_model->getTotalUserAcType($current_user->user_id, $current_user->college_id, 4);
            $this->data['total_provider'] = $this->college_model->getTotalUserAcType($current_user->user_id, $current_user->college_id, 3);
            $this->data['total_third_party'] = $this->college_model->getTotalUserAcType($current_user->user_id, $current_user->college_id, 5);

            $this->data['last_transactions'] = $this->college_model->get_LastTransactions($current_user->user_id, $current_user->college_id);
            $this->data['upcoming_appointment'] = $this->college_model->get_upcoming_appointment($current_user->user_id, $current_user->college_id, $limit);

            $this->sidebardata = array();
            $this->sidebardata["username"] = $current_user->first_name . " " . $current_user->last_name;
            $this->sidebardata["role_name"] = $this->basic_model->get_user_role($current_user->user_type);
            $this->sidebardata["profile_photo"] = $current_user->profile_image;

            $this->headerdata['page_title'] = "Dashboard";
            $this->headerdata['breadcrumbs'] = array(COLLEGE_URL, array('dashboard', 'Dashboard'));
            $this->sidebardata['is_active'] = 'dashboard';
            $this->templatelayout->get_admin_dashboard_header($this->headerdata);
            $this->templatelayout->get_admin_dashboard_footer();
            $this->templatelayout->get_admin_dashboard_sidebar('collegesidebar', $this->sidebardata);
            $this->elements['middle'] = 'college/dashboard';
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
            $this->data = array();

            $current_user = $this->ion_auth->user()->row();
            $user_complete_status = $this->basic_model->getUserCompletenessStatus($current_user->user_id);
            if (isset($user_complete_status) && $user_complete_status != 1) {
                redirect(COLLEGE_URL . "manage_profile");
                exit;
            }

            $this->data['upcoming_appointment'] = $this->college_model->get_upcoming_appointment($current_user->user_id, $current_user->college_id);
            $this->sidebardata = array();
            $this->sidebardata["username"] = $current_user->first_name . " " . $current_user->last_name;
            $this->sidebardata["role_name"] = $this->basic_model->get_user_role($current_user->user_type);
            $this->sidebardata["profile_photo"] = $current_user->profile_image;

            $this->headerdata['page_title'] = "Upcoming Appoinments";
            $this->headerdata['breadcrumbs'] = array(COLLEGE_URL, array('dashboard', 'Dashboard'), array('upcoming_appoinment', 'Upcoming Appoinments'));
            $this->sidebardata['is_active'] = 'dashboard';
            $this->templatelayout->get_admin_dashboard_header($this->headerdata);
            $this->templatelayout->get_admin_dashboard_footer();
            $this->templatelayout->get_admin_dashboard_sidebar('collegesidebar', $this->sidebardata);
            $this->elements['middle'] = 'college/upcoming_appoinment';
            $this->elements_data['middle'] = $this->data;
            $this->layout->setLayout('backend_layout/dashboardlayout');
            $this->layout->multiple_view($this->elements, $this->elements_data);
        }
    }

    public function provider() {
        $tables = $this->config->item('tables', 'ion_auth');
        $identity_column = $this->config->item('identity', 'ion_auth');
        $this->data['identity_column'] = $identity_column;

        if (!$this->ion_auth->logged_in()) {
            redirect(SITE_URL, 'refresh');
            exit;
        } else {

            $current_user = $this->ion_auth->user()->row();
            $user_complete_status = $this->basic_model->getUserCompletenessStatus($current_user->user_id);
            if (isset($user_complete_status) && $user_complete_status != 1) {
                redirect(COLLEGE_URL . "manage_profile");
                exit;
            }
            //$role_name = $this->basic_model->get_user_role($current_user->user_role);
            $this->data = array();
            $this->sidebardata = array();
            //$this->sidebardata["role_name"] = $role_name;
            //$this->sidebardata["profile_photo"] = $current_user->profile_photo;
            $this->sidebardata["username"] = $current_user->first_name . " " . $current_user->last_name;
            $this->sidebardata["role_name"] = $this->basic_model->get_user_role($current_user->user_type);
            $this->sidebardata['is_active'] = 'provider';
            $this->load->model('college_model');
            $this->sidebardata["profile_photo"] = $current_user->profile_image;
            $this->data['provider_list'] = $this->college_model->get_ProviderListByCollege($current_user->college_id);
            $this->data['script_to_include'] = "college_js.js";
            $this->headerdata = array();
            $this->headerdata['page_title'] = "Manage Provider";
            $this->headerdata['breadcrumbs'] = array(COLLEGE_URL, array('dashboard', 'Dashboard'), array('provider', 'Manage Provider'));

            $this->templatelayout->get_admin_dashboard_header($this->headerdata);
            $this->templatelayout->get_admin_dashboard_footer();
            $this->templatelayout->get_admin_dashboard_sidebar('collegesidebar', $this->sidebardata);
            $this->data['message'] = $this->session->flashdata('message');
            $this->elements['middle'] = 'college/manageprovider';
            $this->elements_data['middle'] = $this->data;
            $this->layout->setLayout('backend_layout/dashboardlayout');
            $this->layout->multiple_view($this->elements, $this->elements_data);
        }
    }

    public function provider_update_status() {
        $this->load->model('college_model');
        $userinfo = $this->basic_model->get_userinfo($this->input->post('user_id'));
        $identity = $this->config->item('identity', 'ion_auth');
        if ($userinfo->first_name == '') {
            $identity = $this->config->item('identity', 'ion_auth');
            $identity = $userinfo->{$identity};
        } else {
            $identity = ucfirst($userinfo->first_name . ' ' . $userinfo->last_name);
        }
        $return = $this->college_model->provider_update_status();

        if ($return) {
            $data = array(
                'identity' => $identity
            );
            if ($this->input->post('status') == '1') {
                $this->load->model('basic_model');
                $message_content = $this->basic_model->get_mail_template('inactivation_mail');
                if (isset($message_content) && !empty($message_content)) {
                    $mail_content = html_entity_decode($message_content->mail_template_content);
                    $message = str_replace("{{identity}}", $data['identity'], $mail_content);

                    $message = MAIL_HEADER . $message . MAIL_FOOTER;
//                    $this->email->clear();
//                    $this->email->from($this->config->item('admin_email', 'ion_auth'), $this->config->item('site_title', 'ion_auth'));
//                    $this->email->to($userinfo->user_email);
//                    $this->email->subject($message_content->mail_subject);
//                    $this->email->message($message);
                    if ($this->custom_email->sendinblue_email($this->config->item('admin_email', 'ion_auth'), $userinfo->user_email, $message_content->mail_subject, $message) == TRUE) {
                        echo $return;
                    } else {
                        echo $return;
                    }
                } else {
                    echo $return;
                }
            } else {
                $this->load->model('basic_model');
                $message_content = $this->basic_model->get_mail_template('reactivation_mail');
                if (isset($message_content) && !empty($message_content)) {
                    $mail_content = html_entity_decode($message_content->mail_template_content);
                    $message = str_replace("{{identity}}", $data['identity'], $mail_content);
                    $message = str_replace("{{siteurl}}", SITE_URL, $message);

                    $message = MAIL_HEADER . $message . MAIL_FOOTER;
                    $this->email->clear();
                    $this->email->from($this->config->item('admin_email', 'ion_auth'), $this->config->item('site_title', 'ion_auth'));
                    $this->email->to($userinfo->user_email);
                    $this->email->subject($message_content->mail_subject);
                    $this->email->message($message);
                    if ($this->custom_email->sendinblue_email($this->config->item('admin_email', 'ion_auth'), $userinfo->user_email, $message_content->mail_subject, $message) == TRUE) {
                        echo $return;
                    } else {
                        echo $return;
                    }
                } else {
                    echo $return;
                }
            }
        } else {
            echo $return;
        }
    }

    public function provider_edit($edit_id) {
        $this->load->model('basic_model');

        $current_user = $this->ion_auth->user()->row();
        $provider_profile_data = $this->college_model->getProviderData(base64_decode($edit_id), $current_user->user_id);
        $tables = $this->config->item('tables', 'ion_auth');
        $identity_column = $this->config->item('identity', 'ion_auth');
        $this->data['identity_column'] = $identity_column;

        if (!$this->ion_auth->logged_in()) {
            redirect(SITE_URL, 'refresh');
            exit;
        } else {
            $user_complete_status = $this->basic_model->getUserCompletenessStatus($current_user->user_id);
            if (isset($user_complete_status) && $user_complete_status != 1) {
                redirect(COLLEGE_URL . "manage_profile");
                exit;
            }
            $this->data = array();
            $this->headerdata = array();
            $postdata = isset($_SESSION['postdata']) ? $_SESSION['postdata'] : '';

            $this->data['title'] = "Manage Provider";

            // set the flash data error message if there is one
            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
            $this->data['error'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('error')));

            $this->data['edit_id'] = array(
                'name' => 'edit_id',
                'id' => 'edit_id',
                "class" => "form-control ",
                'type' => 'text',
                'value' => $edit_id,
                'type' => 'hidden'
            );

            $this->data['user_email'] = array(
                'name' => 'user_email',
                'id' => 'user_email',
                "class" => "form-control",
                'type' => 'text',
                'maxlength' => '100',
                'disabled' => 'disabled',
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
                'placeholder' => "Provider Average rate per 45 minute session ($)",
                'value' => isset($postdata) && !empty($postdata) && isset($postdata['session_cost']) ? $postdata['session_cost'] : $provider_profile_data->session_cost
            );

            $this->data['college'] = $this->college_model->getCollege();
            $this->data['college_id_selected'] = $provider_profile_data->college_id;
            $this->data['speciality'] = $this->basic_model->get_specialitylist();
            $profileSpeciality = "";
            if (isset($provider_profile_data->specialities) && !empty($provider_profile_data->specialities)) {
                $profileSpeciality = explode(',', $provider_profile_data->specialities);
            }

            $this->data['timezone_list'] = $this->basic_model->get_timezonelist();
            if (isset($provider_profile_data->timezone_id) && !empty($provider_profile_data->timezone_id)) {
                $timezone_id = $provider_profile_data->timezone_id;
            } else {
                $timezone_id = DEFAULT_TIMEZONE;
            }

            $this->data['timezone_list_selected'] = $timezone_id;

            $this->data['speciality_selected'] = $profileSpeciality;
            $this->data['profile_image'] = $provider_profile_data->profile_image;

            $this->sidebardata = array();
            $this->sidebardata["username"] = $current_user->first_name . " " . $current_user->last_name;
            $this->sidebardata["role_name"] = $this->basic_model->get_user_role($current_user->user_type);
            $this->sidebardata["profile_photo"] = $current_user->profile_image;
            $this->headerdata['page_title'] = "Update Provider Profile";
            $this->headerdata['breadcrumbs'] = array(COLLEGE_URL, array('dashboard', 'Dashboard'), array('provider_profile', 'Update Provider Profile'));
            $this->data['script_to_include'] = "college_js.js";
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
            $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
            $this->templatelayout->get_admin_dashboard_header($this->headerdata);
            $this->templatelayout->get_admin_dashboard_footer();
            $this->templatelayout->get_admin_dashboard_sidebar('collegesidebar', $this->sidebardata);
            $this->elements['middle'] = 'college/provider_edit';
            $this->elements_data['middle'] = $this->data;
            $this->layout->setLayout('backend_layout/dashboardlayout');
            $this->layout->multiple_view($this->elements, $this->elements_data);
        }
    }

    public function provider_update() {
        // Configuration options
        $edit_id = $this->input->post('edit_id');
        if (empty($edit_id)) {
            redirect(COLLEGE_URL . 'provider', 'refresh');
            exit;
        }


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

        if ($this->form_validation->run() == true) {
            // check to see if we are creating the user
            // redirect them back to the admin page
            $this->load->model("basic_model");
            $this->load->model("provider_model");

            $post_arr = $this->input->post();
            $post_arr = $this->basic_model->stripTagsPostArray($post_arr);

            if ($this->college_model->update_provider($post_arr)) {
                $this->session->set_flashdata('message', $this->lang->line('profile_update_provider'));
                redirect(COLLEGE_URL . "provider");
            } else {
                $_SESSION['postdata'] = $_POST;
                $this->session->set_flashdata('error', "Profile Image must be of JPG/PNG/JPEG/GIF image type.");
                redirect(COLLEGE_URL . "provider_edit");
            }
        } else {
            $_SESSION['postdata'] = $_POST;
            $this->session->set_flashdata('error', (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message'))));
            redirect(COLLEGE_URL . "provider_edit/" . $edit_id);
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
                redirect(COLLEGE_URL . "manage_profile");
                exit;
            }
            $this->data = array();

            $this->sidebardata = array();

            $this->data['script_to_include'] = "sadmin_js.js";
            $this->sidebardata["username"] = $current_user->first_name . " " . $current_user->last_name;
            $this->sidebardata["role_name"] = $this->basic_model->get_user_role($current_user->user_type);
            $this->sidebardata["profile_photo"] = $current_user->profile_image;
            $this->sidebardata['is_active'] = 'changepassword';
            $this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
            $this->data['old_password'] = array(
                'name' => 'old',
                'id' => 'old',
                'type' => 'password',
                'class' => 'form-control',
                'required' => 'required',
                'placeholder' => 'Old Password'
            );
            $this->data['new_password'] = array(
                'name' => 'new',
                'id' => 'new',
                'type' => 'password',
                'required' => 'required',
                'class' => 'form-control',
                'placeholder' => 'New Password'
            );
            $this->data['new_password_confirm'] = array(
                'name' => 'new_confirm',
                'id' => 'new_confirm',
                'type' => 'password',
                'required' => 'required',
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
            $this->headerdata['breadcrumbs'] = array(COLLEGE_URL, array('dashboard', 'Dashboard'), array('changepassword', 'Change Password'));
            $this->templatelayout->get_admin_dashboard_header($this->headerdata);
            $this->templatelayout->get_admin_dashboard_footer();
            $this->templatelayout->get_admin_dashboard_sidebar('collegesidebar', $this->sidebardata);
            $this->elements['middle'] = 'college/change_password';
            $this->elements_data['middle'] = $this->data;
            $this->layout->setLayout('backend_layout/dashboardlayout');
            $this->layout->multiple_view($this->elements, $this->elements_data);
        }
    }

    public function change_password() {
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
                        redirect(COLLEGE_URL . "changepassword", 'refresh');
                    } else {
                        $this->session->set_flashdata('message', $this->ion_auth->messages());
                        redirect(COLLEGE_URL . "changepassword", 'refresh');
                    }
                } else {

                    $this->session->set_flashdata('message', $this->ion_auth->messages());

                    redirect(COLLEGE_URL . "changepassword", 'refresh');
                }
            } else {

                $this->session->set_flashdata('error', $this->ion_auth->errors());

                redirect(COLLEGE_URL . "changepassword", 'refresh');
            }
        } else {

            $this->session->set_flashdata('error', (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message'))));
            redirect(COLLEGE_URL . "changepassword");
        }
    }

    public function manage_profile() {
        $tables = $this->config->item('tables', 'ion_auth');
        $identity_column = $this->config->item('identity', 'ion_auth');
        $this->data['identity_column'] = $identity_column;

        if (!$this->ion_auth->logged_in()) {
            redirect(SITE_URL, 'refresh');
            exit;
        } else {
            $current_user = $this->ion_auth->user()->row();

            $college_data = $this->college_model->getCollegeprofileData($current_user->user_id);
            $this->data = array();
            $this->headerdata = array();
            $postdata = isset($_SESSION['postdata']) ? $_SESSION['postdata'] : '';

            $this->data['title'] = "Manage College";

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
                'value' => '2',
                'type' => 'hidden'
            );

            $this->data['user_id'] = array(
                'name' => 'user_id',
                'id' => 'user_id',
                "class" => "form-control ",
                'type' => 'text',
                'maxlength' => '5',
                'value' => $college_data->user_id,
                'type' => 'hidden'
            );

            $this->data['college_id'] = array(
                'name' => 'college_id',
                'id' => 'college_id',
                "class" => "form-control ",
                'type' => 'text',
                'maxlength' => '5',
                'value' => $college_data->college_id,
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
                'value' => isset($postdata) && !empty($postdata) && isset($postdata['user_email']) ? $postdata['user_email'] : $college_data->user_email
            );

            $this->data['first_name'] = array(
                'name' => 'first_name',
                'id' => 'first_name',
                'type' => 'text',
                'maxlength' => '32',
                "class" => "form-control  col-md-7 col-xs-12",
                'placeholder' => "First Name",
                'value' => isset($postdata) && !empty($postdata) && isset($postdata['first_name']) ? $postdata['first_name'] : $college_data->first_name
            );

            $this->data['last_name'] = array(
                'name' => 'last_name',
                'id' => 'last_name',
                'type' => 'text',
                'maxlength' => '32',
                "class" => "form-control  col-md-7 col-xs-12",
                'placeholder' => "Last Name",
                'value' => isset($postdata) && !empty($postdata) && isset($postdata['last_name']) ? $postdata['last_name'] : $college_data->last_name
            );

            $this->data['college_name'] = array(
                'name' => 'college_name',
                'id' => 'college_name',
                'type' => 'text',
                'maxlength' => '100',
                "class" => "form-control  col-md-7 col-xs-12",
                'placeholder' => "College Name",
                'value' => isset($postdata) && !empty($postdata) && isset($postdata['college_name']) ? $postdata['college_name'] : $college_data->college_name
            );

            $this->data['college_address'] = array(
                'name' => 'college_address',
                'id' => 'college_address',
                'type' => 'text',
                'maxlength' => '200',
                "class" => "form-control  col-md-7 col-xs-12",
                'placeholder' => "College Address",
                'value' => isset($postdata) && !empty($postdata) && isset($postdata['college_address']) ? $postdata['college_address'] : $college_data->college_address
            );

            $this->data['college_state'] = array(
                'name' => 'college_state',
                'id' => 'college_state',
                'type' => 'text',
                'maxlength' => '100',
                "class" => "form-control  col-md-7 col-xs-12",
                'placeholder' => "College State",
                'value' => isset($postdata) && !empty($postdata) && isset($postdata['college_state']) ? $postdata['college_state'] : $college_data->college_state
            );

            $this->data['college_city'] = array(
                'name' => 'college_city',
                'id' => 'college_city',
                'type' => 'text',
                'maxlength' => '32',
                "class" => "form-control  col-md-7 col-xs-12",
                'placeholder' => "College City",
                'value' => isset($postdata) && !empty($postdata) && isset($postdata['college_city']) ? $postdata['college_city'] : $college_data->college_city
            );

            $this->data['college_zipcode'] = array(
                'name' => 'college_zipcode',
                'id' => 'college_zipcode',
                'type' => 'text',
                'maxlength' => '10',
                "class" => "form-control  col-md-7 col-xs-12",
                'placeholder' => "College Zipcode",
                'value' => isset($postdata) && !empty($postdata) && isset($postdata['college_zipcode']) ? $postdata['college_zipcode'] : $college_data->college_zipcode
            );

            $this->data['college_office_no'] = array(
                'name' => 'college_office_no',
                'id' => 'college_office_no',
                'type' => 'text',
                'maxlength' => '15',
                "class" => "form-control  col-md-7 col-xs-12 mobilemark",
                'placeholder' => "___-___-____",
                'value' => isset($postdata) && !empty($postdata) && isset($postdata['college_office_no']) ? $postdata['college_office_no'] : $college_data->college_office_no
            );
            $this->data['is_profile_completeness'] = $current_user->is_profile_completeness;
            $this->data['is_disabled'] = $current_user->is_disabled;
            $states = $this->basic_model->get_state_list();
            $this->data['states'] = $states;
            $this->data['states_selected'] = $college_data->college_state;

            $this->data['timezone_list'] = $this->basic_model->get_timezonelist();
            $timezone_id = isset($postdata) && !empty($postdata) && isset($postdata['timezone_id']) ? $postdata['timezone_id'] : $college_data->timezone_id;
            if ($timezone_id) {
                $timezone_id = $timezone_id;
            } else {
                $timezone_id = DEFAULT_TIMEZONE;
            }
            $this->data['timezone_list_selected'] = $timezone_id;

            $this->data['profile_image'] = $college_data->profile_image;

            $this->sidebardata = array();
            $this->sidebardata["username"] = ucwords($college_data->first_name . ' ' . $college_data->last_name);
            $this->sidebardata["role_name"] = $this->basic_model->get_user_role($current_user->user_type);
            $this->sidebardata['is_active'] = 'manage_profile';
            $this->sidebardata["profile_photo"] = $college_data->profile_image;
            $this->data['script_to_include'] = "college_js.js";

            $this->headerdata['page_title'] = "Manage Profile";
            $this->headerdata['breadcrumbs'] = array(COLLEGE_URL, array('dashboard', 'Dashboard'), array('manage_profile', 'Manage Profile'));
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
            $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
            $this->templatelayout->get_admin_dashboard_header($this->headerdata);
            $this->templatelayout->get_admin_dashboard_footer();
            $this->templatelayout->get_admin_dashboard_sidebar('collegesidebar', $this->sidebardata);
            $this->elements['middle'] = 'college/college_manage_profile';
            $this->elements_data['middle'] = $this->data;
            $this->layout->setLayout('backend_layout/dashboardlayout');
            $this->layout->multiple_view($this->elements, $this->elements_data);
        }
    }

    public function manage_patient_profile() {
        // Configuration options
        $tables = $this->config->item('tables', 'ion_auth');
        $identity_column = $this->config->item('identity', 'ion_auth');
        $this->data['identity_column'] = $identity_column;

        unset($_SESSION['postdata']);
        $this->form_validation->set_rules('first_name', $this->lang->line('create_user_validation_fname_label'), 'required');
        $this->form_validation->set_rules('last_name', $this->lang->line('create_user_validation_lname_label'), 'required');
        $this->form_validation->set_rules('college_name', $this->lang->line('create_user_validation_college_label'), 'required');
        $this->form_validation->set_rules('college_address', $this->lang->line('create_user_validation_college_address_label'), 'required');
        $this->form_validation->set_rules('college_state', $this->lang->line('create_user_validation_college_state_label'), 'required');
        $this->form_validation->set_rules('college_city', $this->lang->line('create_user_validation_college_city_label'), 'required');
        $this->form_validation->set_rules('college_zipcode', $this->lang->line('create_user_validation_college_zipcode_label'), 'required');
        $this->form_validation->set_rules('college_office_no', $this->lang->line('create_user_validation_college_office_label'), 'required');

        if ($this->form_validation->run() == true) {
            // check to see if we are creating the user
            // redirect them back to the admin page
            $this->load->model("basic_model");

            $additional_data = array();
            $college_data = array();

            $post_arr = $this->input->post();
            $post_arr = $this->basic_model->stripTagsPostArray($post_arr);

            if ($this->college_model->update_college_profile($post_arr)) {
                $this->session->set_flashdata('message', 'College Profile updated successfully.');
                redirect(COLLEGE_URL . "manage_profile");
            } else {
                $_SESSION['postdata'] = $_POST;
                $this->session->set_flashdata('error', "Profile Image must be of JPG/PNG/JPEG/GIF image type.");
                redirect(COLLEGE_URL . "manage_profile");
            }
        } else {
            $_SESSION['postdata'] = $_POST;
            $this->session->set_flashdata('error', (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message'))));
            redirect(COLLEGE_URL . "manage_profile");
        }
    }

    public function college_profile() {
        $tables = $this->config->item('tables', 'ion_auth');

        if (!$this->ion_auth->logged_in()) {
            redirect(SITE_URL, 'refresh');
            exit;
        } else {
            $current_user = $this->ion_auth->user()->row();
            $user_complete_status = $this->basic_model->getUserCompletenessStatus($current_user->user_id);
            if (isset($user_complete_status) && $user_complete_status != 1) {
                redirect(COLLEGE_URL . "manage_profile");
                exit;
            }
            $college_data = $this->college_model->getCollegeprofileData($current_user->user_id);
            $this->data = array();
            $this->headerdata = array();

            $this->data['title'] = "View Profile";

            $this->data['college_data'] = $college_data;

            $this->sidebardata = array();
            $this->sidebardata["username"] = ucwords($college_data->first_name . ' ' . $college_data->last_name);
            $this->sidebardata['is_active'] = 'manage_profile';
            $this->sidebardata["profile_photo"] = $college_data->profile_image;

            $this->headerdata['page_title'] = "Manage Profile";
            $this->headerdata['breadcrumbs'] = array(COLLEGE_URL, array('dashboard', 'Dashboard'), array('college_profile', 'College View Profile'));
            $this->templatelayout->get_admin_dashboard_header($this->headerdata);
            $this->templatelayout->get_admin_dashboard_footer();
            $this->templatelayout->get_admin_dashboard_sidebar('collegesidebar', $this->sidebardata);
            $this->elements['middle'] = 'college/college_view_profile';
            $this->elements_data['middle'] = $this->data;
            $this->layout->setLayout('backend_layout/dashboardlayout');
            $this->layout->multiple_view($this->elements, $this->elements_data);
        }
    }

    public function appointments() {
        $tables = $this->config->item('tables', 'ion_auth');
        $identity_column = $this->config->item('identity', 'ion_auth');
        $this->data['identity_column'] = $identity_column;

        if (!$this->ion_auth->logged_in()) {
            redirect(SITE_URL, 'refresh');
            exit;
        } else {

            $current_user = $this->ion_auth->user()->row();
            $user_complete_status = $this->basic_model->getUserCompletenessStatus($current_user->user_id);
            if (isset($user_complete_status) && $user_complete_status != 1) {
                redirect(COLLEGE_URL . "manage_profile");
                exit;
            }
            //$role_name = $this->basic_model->get_user_role($current_user->user_role);
            $this->data = array();
            $this->sidebardata = array();
            //$this->sidebardata["role_name"] = $role_name;
            //$this->sidebardata["profile_photo"] = $current_user->profile_photo;
            $this->sidebardata["username"] = $current_user->first_name . " " . $current_user->last_name;
            $this->sidebardata["role_name"] = $this->basic_model->get_user_role($current_user->user_type);
            $this->sidebardata['is_active'] = 'appointments';
            $this->load->model('college_model');
            $this->sidebardata["profile_photo"] = $current_user->profile_image;
            $this->data['appointments_list'] = $this->college_model->get_appointments($current_user->college_id);
            $this->data['script_to_include'] = "college_js.js";
            $this->headerdata = array();
            $this->headerdata['page_title'] = "Appointments";
            $this->headerdata['breadcrumbs'] = array(COLLEGE_URL, array('dashboard', 'Dashboard'), array('appointments', 'Appointments'));

            $this->templatelayout->get_admin_dashboard_header($this->headerdata);
            $this->templatelayout->get_admin_dashboard_footer();
            $this->templatelayout->get_admin_dashboard_sidebar('collegesidebar', $this->sidebardata);
            $this->data['message'] = $this->session->flashdata('message');
            $this->elements['middle'] = 'college/appointments';
            $this->elements_data['middle'] = $this->data;
            $this->layout->setLayout('backend_layout/dashboardlayout');
            $this->layout->multiple_view($this->elements, $this->elements_data);
        }
    }

    public function cancelappointment() {
        $current_user = $this->ion_auth->user()->row();
        $appointment = $this->college_model->get_appointment_details(base64_decode($this->input->post('appointment_id')));
        if (!count($appointment))
            redirect(PROVIDER_URL . 'availability');
        $provider_id = $appointment['provider_id'];
        $patient_id = $appointment['patient_id'];
        $avail_id = $appointment['slot_id'];
        try {

            $update = $this->provider_model->update_appointment($avail_id, $provider_id, $patient_id);
            if ($update) {
                $patient_data = $this->basic_model->get_user_data($patient_id);
                $provider_data = $this->patient_model->get_provider_data($provider_id);
                $provider_data = $provider_data[0];
                $appointment_data = $this->provider_model->get_avail_info($avail_id);
                $appointment_data = (array) $appointment_data[0];
                $app_id = $appointment['app_id'];

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

                $message_content = $this->basic_model->get_mail_template('appointment_canceled_by_college_provider');
                $mail_content = html_entity_decode($message_content->mail_template_content);
                $message = str_replace("{{identity}}", $provider_data['first_name'] . " " . $provider_data['last_name'], $mail_content);
                $message = str_replace("{{college_name}}", $current_user->first_name . " " . $current_user->last_name . '(college)', $message);
                $message = str_replace("{{name}}", $patient_data['first_name'] . " " . $patient_data['last_name'], $message);
                $message = str_replace("{{siteurl}}", SITE_URL, $message);
                $message = str_replace("{{appointment_date}}", show_date($appointment_data['start_date'] . ' ' . $appointment_data['start_time'], $provider_data['timezone_code']), $message);
                $message = str_replace("{{appointment_time}}", show_time($appointment_data['start_date'] . ' ' . $appointment_data['start_time'], $provider_data['timezone_code']), $message);
                $message = str_replace("{{additional}}", '', $message);
                $message = MAIL_HEADER . $message . MAIL_FOOTER;

                $this->email->clear();
                $this->email->from($this->config->item('admin_email', 'ion_auth'), $this->config->item('site_title', 'ion_auth'));
                $this->email->to($provider_data['user_email']);
                $this->email->subject($message_content->mail_subject);
                $this->email->message($message);
                $this->email->send();

                $message_content = $this->basic_model->get_mail_template('appointment_canceled_by_college_provider');
                $mail_content = html_entity_decode($message_content->mail_template_content);
                $message = str_replace("{{identity}}", $patient_data['first_name'] . " " . $patient_data['last_name'], $mail_content);
                $message = str_replace("{{college_name}}", $current_user->first_name . " " . $current_user->last_name . '(college)', $message);
                $message = str_replace("{{name}}", $provider_data['first_name'] . " " . $provider_data['last_name'], $message);
                $message = str_replace("{{siteurl}}", SITE_URL, $message);
                $message = str_replace("{{appointment_date}}", show_date($appointment_data['start_date'] . ' ' . $appointment_data['start_time'], $patient_data['timezone_code']), $message);
                $message = str_replace("{{appointment_time}}", show_time($appointment_data['start_date'] . ' ' . $appointment_data['start_time'], $patient_data['timezone_code']), $message);
                $message = str_replace("{{additional}}", 'Your payment will be refunded in full.', $message);
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
                $message = str_replace("{{cancelled_by}}", ucfirst($current_user->first_name . " " . $current_user->last_name), $message);
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
                redirect(COLLEGE_URL . 'appointments');
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
        redirect(COLLEGE_URL . 'appointments');
    }

    public function calendar($provider_id) {
        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect(SITE_URL, 'refresh');
            exit;
        } else {

            $current_user = $this->ion_auth->user()->row();
            $this->data = array();

            $this->sidebardata = array();

            $this->data['script_to_include'] = "sadmin_js.js";
            //$this->sidebardata["role_name"] = $role_name;
            $this->sidebardata["profile_photo"] = $current_user->profile_image;
            $this->sidebardata["username"] = $current_user->first_name . " " . $current_user->last_name;
            $this->sidebardata['is_active'] = 'college';
            $this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
            $provider_id = base64_decode($provider_id);
            $this->data['provider_id'] = $provider_id;
            $provider_data = $this->provider_model->get_user_info($provider_id);
            $this->data['provider_data'] = (array) $provider_data[0];

            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
            $this->data['error'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('error')));
            $this->headerdata['page_title'] = "Availablity Schedule";
            $schedule = $this->provider_model->getProviderShcedule($provider_id);
            if (isset($schedule) && !empty($schedule)) {
                $this->data['schedules'] = $schedule;
            }
            $this->load->model('basic_model');
            $this->data['avail_times'] = $this->basic_model->get_times();
            $this->headerdata['breadcrumbs'] = array(PROVIDER_URL, array('dashboard', 'Dashboard'), array('availabality', 'Availability'));
            $this->templatelayout->get_admin_dashboard_header($this->headerdata);
            $this->templatelayout->get_admin_dashboard_footer();
            $this->templatelayout->get_admin_dashboard_sidebar('collegesidebar', $this->sidebardata);
            $this->elements['middle'] = 'college/availabality';
            $this->elements_data['middle'] = $this->data;
            $this->layout->setLayout('backend_layout/dashboardlayout');
            $this->layout->multiple_view($this->elements, $this->elements_data);
        }
    }

    public function saveavailabality() {
        $provider_id = $this->input->post('provider_id');
        $startdate = $this->input->post('startdate');
        $enddate = $this->input->post('enddate');
        $timeslots = array_filter($_POST['timeslot']);
        $message = '';

        if ($timeslots == '') {
            $message = 'Time slots is required field.';
        }
        if ($enddate == '') {
            $message = 'End Date is required field.';
        }
        if ($startdate == '') {
            $message = 'Start Date is required field.';
        }

        if ($message) {
            $this->session->set_flashdata('error', $message);
            redirect('college/calendar/' . base64_encode($provider_id));
        }
        $startTime = strtotime($startdate);
        $endTime = strtotime($enddate);
        // Loop between timestamps, 24 hours at a time
        for ($i = $startTime; $i <= $endTime; $i = $i + 86400) {
            for ($t = 0; $t < count($timeslots); $t++) {

                $slot = explode('-', $timeslots[$t]);
                $start_datetime = $this->basic_model->set_utc_datetime(date('Y-m-d', $i) . ' ' . date('H:i:s', strtotime(trim(current($slot)))));
                $end_datetime = $this->basic_model->set_utc_datetime(date('Y-m-d', $i) . ' ' . date('H:i:s', strtotime(trim(end($slot)))));

                $datatoinsert = array();
                $datatoinsert['provider_id'] = $provider_id;
                $datatoinsert['start_date'] = date('Y-m-d', strtotime($start_datetime));
                $datatoinsert['end_date'] = date('Y-m-d', strtotime($end_datetime));
                $datatoinsert['start_time'] = date('H:i', strtotime($start_datetime));
                $datatoinsert['end_time'] = date('H:i', strtotime($end_datetime));

                $chkStartTime = date('Y-m-d H:i', strtotime('-30 minutes', strtotime($datatoinsert['start_date'] . ' ' . $datatoinsert['start_time'])));
                $chkEndTime = date('Y-m-d H:i', strtotime('+30 minutes', strtotime($datatoinsert['start_date'] . ' ' . $datatoinsert['start_time'])));
                $count = $this->db->query("select count(*) as avl_count from bm_provider_availablity where concat(start_date,' ',start_time) between '$chkStartTime' and '$chkEndTime' and provider_id=$provider_id and status=1")->row_array();

                if ($count['avl_count'] > 0) {
                    continue;
                } else {
                    $this->db->insert('bm_provider_availablity', $datatoinsert);
                }
                // }
            }
        }


        $last_id = $this->db->insert_id();

        if ($last_id) {
            $this->session->set_flashdata('message', 'Availability created successfully.');
        } else {
            $this->session->set_flashdata('error', 'This appointment could not be created because it overlaps with an existing appointment time.');
        }
        redirect('college/calendar/' . base64_encode($provider_id));
    }

    public function update_schedule() {
        $avail_id = $this->input->post('avail_id');
        $provider_id = $this->input->post('provider_id');
        $slot_id = $this->input->post('slot_id');
        $patient_id = $this->input->post('patient_id');
        $app_id = $this->input->post('app_id');
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
        $this->load->view('college/update_schedule', $this->data);
    }

    public function updateavailabality() {
        $current_user = $this->ion_auth->user()->row();
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

                        $message_content = $this->basic_model->get_mail_template('appointment_canceled_by_college_provider');
                        $mail_content = html_entity_decode($message_content->mail_template_content);
                        $message = str_replace("{{identity}}", $provider_data['first_name'] . " " . $provider_data['last_name'], $mail_content);
                        $message = str_replace("{{college_name}}", $current_user->first_name . " " . $current_user->last_name, $message);
                        $message = str_replace("{{name}}", $patient_data['first_name'] . " " . $patient_data['last_name'], $message);
                        $message = str_replace("{{siteurl}}", SITE_URL, $message);
                        $message = str_replace("{{appointment_date}}", show_date($appointment_data['start_date'] . ' ' . $appointment_data['start_time'], $provider_data['timezone_code']), $message);
                        $message = str_replace("{{appointment_time}}", show_time($appointment_data['start_date'] . ' ' . $appointment_data['start_time'], $provider_data['timezone_code']), $message);
                        $message = str_replace("{{additional}}", '', $message);
                        $message = MAIL_HEADER . $message . MAIL_FOOTER;

                        $this->email->clear();
                        $this->email->from($this->config->item('admin_email', 'ion_auth'), $this->config->item('site_title', 'ion_auth'));
                        $this->email->to($provider_data['user_email']);
                        $this->email->subject($message_content->mail_subject);
                        $this->email->message($message);
                        $this->email->send();

                        $message_content = $this->basic_model->get_mail_template('appointment_canceled_by_college_provider');
                        $mail_content = html_entity_decode($message_content->mail_template_content);
                        $message = str_replace("{{identity}}", $patient_data['first_name'] . " " . $patient_data['last_name'], $mail_content);
                        $message = str_replace("{{college_name}}", $current_user->first_name . " " . $current_user->last_name, $message);
                        $message = str_replace("{{name}}", $provider_data['first_name'] . " " . $provider_data['last_name'], $message);
                        $message = str_replace("{{siteurl}}", SITE_URL, $message);
                        $message = str_replace("{{appointment_date}}", show_date($appointment_data['start_date'] . ' ' . $appointment_data['start_time'], $patient_data['timezone_code']), $message);
                        $message = str_replace("{{appointment_time}}", show_time($appointment_data['start_date'] . ' ' . $appointment_data['start_time'], $patient_data['timezone_code']), $message);
                        $message = str_replace("{{additional}}", 'Your payment will be refunded in full.', $message);
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
                        $message = str_replace("{{cancelled_by}}", ucfirst($current_user->first_name . " " . $current_user->last_name), $message);
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
                        redirect('college/calendar/' . base64_encode($provider_id));
                    }
                } else {
                    $update = $this->provider_model->update_schedule($avail_id);
                    if ($update) {
                        $this->session->set_flashdata('message', "Schedule Cancelled Successfully.");
                        redirect('college/calendar/' . base64_encode($provider_id));
                    }
                }
            } else {
                redirect(COLLEGE_URL . "availability");
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
        redirect('college/calendar/' . base64_encode($provider_id));
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
            redirect(SADMIN_URL . "college");
            //
        }
    }

}
