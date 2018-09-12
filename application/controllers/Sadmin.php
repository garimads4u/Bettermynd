<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Sadmin extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library(array('ion_auth', 'form_validation'));
        $this->load->helper(array('url', 'language', 'email'));
        set_smtp_config();
        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
        $this->lang->load('auth');
        $uri_segment = $this->uri->segment(2, 0);
        $this->load->model('sadmin_model');
        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect(SITE_URL, 'refresh');
            exit;
        } else {
            $current_user = $this->ion_auth->user()->row();
            $user_type = $current_user->user_type;
            if ($user_type != 1) {
                if ($user_type == 2) {
                    redirect(COLLEGE_URL . "dashboard");
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
            redirect(SADMIN_URL . 'dashboard');
            exit;
        }
    }

    public function dashboard() {
        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect(SITE_URL, 'refresh');
            exit;
        } else {
            $this->load->model('message_model', 'message');
            if ($this->input->post('send_flashmessage')) {
                $this->message->send_flashmessage();
                redirect(base_url('sadmin/dashboard'));
            }
            $current_user = $this->ion_auth->user()->row();
            $limit = 10;
            $this->data = array();
            $this->data['total_colleges'] = $this->sadmin_model->get_total_colleges();
            $this->data['total_providers'] = $this->sadmin_model->get_total_providers();
            $this->data['total_patients'] = $this->sadmin_model->get_total_patients();
            $this->data['total_appointments'] = $this->sadmin_model->get_total_appointment();

            $this->data['last_transactions'] = $this->sadmin_model->get_LastTransactions();
            $this->data['upcoming_appointment'] = $this->sadmin_model->get_upcoming_appointment($limit);
            $this->load->model('college_model');
            $this->data['college'] = $this->college_model->getCollege();
            $this->data['flashmessages'] = $this->message->admin_get_flashmessages();
            $this->data['script_to_include'] = "sadmin_js.js";
            $this->sidebardata = array();

            $this->headerdata['page_title'] = "Dashboard";
            $this->sidebardata['is_active'] = 'dashboard';
            $this->sidebardata["username"] = $current_user->first_name . " " . $current_user->last_name;
            $this->sidebardata["role_name"] = $this->basic_model->get_user_role($current_user->user_type);
            $this->sidebardata["profile_photo"] = $current_user->profile_image;
            $this->templatelayout->get_admin_dashboard_header($this->headerdata);
            $this->templatelayout->get_admin_dashboard_footer();
            $this->templatelayout->get_admin_dashboard_sidebar('superadminsidebar', $this->sidebardata);

            $this->elements['middle'] = 'sadmin/dashboard';
            $this->elements_data['middle'] = $this->data;
            $this->layout->setLayout('backend_layout/dashboardlayout');
            $this->layout->multiple_view($this->elements, $this->elements_data);
        }
    }

    public function upcoming_appoinment() {
        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect(SITE_URL, 'refresh');
            exit;
        } else {
            $this->load->model('message_model', 'message');
            if ($this->input->post('send_flashmessage')) {
                $this->message->send_flashmessage();
                redirect(base_url('sadmin/dashboard'));
            }
            $current_user = $this->ion_auth->user()->row();
            $this->data = array();

            $this->data['upcoming_appointment'] = $this->sadmin_model->get_upcoming_appointment();

            $this->data['script_to_include'] = "sadmin_js.js";
            $this->sidebardata = array();

            $this->headerdata['page_title'] = "Upcoming Appoinments";
            $this->headerdata['breadcrumbs'] = array(SADMIN_URL, array('dashboard', 'Dashboard'), array('upcoming_appoinment', 'Upcoming Appoinments'));
            $this->sidebardata['is_active'] = 'dashboard';
            $this->sidebardata["username"] = $current_user->first_name . " " . $current_user->last_name;
            $this->sidebardata["role_name"] = $this->basic_model->get_user_role($current_user->user_type);
            $this->sidebardata["profile_photo"] = $current_user->profile_image;
            $this->templatelayout->get_admin_dashboard_header($this->headerdata);
            $this->templatelayout->get_admin_dashboard_footer();
            $this->templatelayout->get_admin_dashboard_sidebar('superadminsidebar', $this->sidebardata);

            $this->elements['middle'] = 'sadmin/upcoming_appoinment';
            $this->elements_data['middle'] = $this->data;
            $this->layout->setLayout('backend_layout/dashboardlayout');
            $this->layout->multiple_view($this->elements, $this->elements_data);
        }
    }

    public function college() {
        $tables = $this->config->item('tables', 'ion_auth');
        $identity_column = $this->config->item('identity', 'ion_auth');
        $this->data['identity_column'] = $identity_column;

        if (!$this->ion_auth->logged_in()) {
            redirect(SITE_URL, 'refresh');
            exit;
        } else {

            if ($this->input->post('college_add')) {
                //Form validation checks
                unset($_SESSION['postdata']);
                $this->form_validation->set_rules('user_email', $this->lang->line('create_user_validation_identity_label'), 'required|valid_email|is_unique[' . $tables['users'] . '.' . $identity_column . ']');
                $this->form_validation->set_rules('first_name', $this->lang->line('create_user_validation_fname_label'), 'required');
                $this->form_validation->set_rules('last_name', $this->lang->line('create_user_validation_lname_label'), 'required');
                $this->form_validation->set_rules('college_name', $this->lang->line('create_user_validation_college_label'), 'required');
                $this->form_validation->set_rules('college_address', $this->lang->line('create_user_validation_college_address_label'), 'required');
                $this->form_validation->set_rules('college_state', $this->lang->line('create_user_validation_college_state_label'), 'required');
                $this->form_validation->set_rules('college_city', $this->lang->line('create_user_validation_college_city_label'), 'required');
                $this->form_validation->set_rules('college_zipcode', $this->lang->line('create_user_validation_college_zipcode_label'), 'required');
                $this->form_validation->set_rules('college_office_no', $this->lang->line('create_user_validation_college_office_label'), 'required');


                if ($this->form_validation->run() == true) {

                    $this->load->model("basic_model");

                    $additional_data = array();
                    $college_data = array();

                    $post_arr = $this->input->post();
                    $post_arr = $this->basic_model->stripTagsPostArray($post_arr);

                    $email = strtolower($post_arr['user_email']);
                    $identity = $email;
                    $password = '';

                    $additional_data['first_name'] = $post_arr['first_name'];
                    $additional_data['last_name'] = $post_arr['last_name'];
                    $additional_data['user_type'] = 2;
                    $college_data['college_name'] = $post_arr['college_name'];
                    $college_data['college_address'] = $post_arr['college_address'];
                    $college_data['college_state'] = $post_arr['college_state'];
                    $college_data['college_city'] = $post_arr['college_city'];
                    $college_data['college_zipcode'] = $post_arr['college_zipcode'];
                    $college_data['college_office_no'] = $post_arr['college_office_no'];
                    $last_id = $this->ion_auth->register($identity, $password, $email, $additional_data);

                    if ($last_id) {

                        $college_data['uid'] = $last_id;
                        $college_id = $this->sadmin_model->add_college($college_data);
                        $this->sadmin_model->update_college($last_id, array("college_id" => $college_id));
                        $data_1 = array();
                        $this->session->set_flashdata('message', $this->ion_auth->messages());
                        redirect(SADMIN_URL . "college");
                    }
                } else {
                    $_SESSION['postdata'] = $_POST;
                    $this->session->set_flashdata('error', (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message'))));
                    redirect(SADMIN_URL . "college");
                }
            }
            $college_update = $this->input->post('college_update');
            $edit_id = $this->input->post('edit_id');
            if ($college_update && !empty($edit_id)) {
                //Form validation checks
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

                    $this->load->model("basic_model");

                    $additional_data = array();
                    $college_data = array();

                    $post_arr = $this->input->post();
                    $post_arr = $this->basic_model->stripTagsPostArray($post_arr);

                    $additional_data['user_id'] = $post_arr['edit_id'];

                    $additional_data['first_name'] = $post_arr['first_name'];
                    $additional_data['last_name'] = $post_arr['last_name'];
                    $additional_data['user_type'] = 2;

                    $college_data['college_name'] = $post_arr['college_name'];
                    $college_data['college_address'] = $post_arr['college_address'];
                    $college_data['college_state'] = $post_arr['college_state'];
                    $college_data['college_city'] = $post_arr['college_city'];
                    $college_data['college_zipcode'] = $post_arr['college_zipcode'];
                    $college_data['college_office_no'] = $post_arr['college_office_no'];

                    if ($this->sadmin_model->update_college($post_arr['edit_id'], $additional_data, $college_data)) {
                        $this->session->set_flashdata('message', 'College profile updated successfully');
                        redirect(SADMIN_URL . "college");
                    }
                } else {
                    $_SESSION['postdata'] = $_POST;
                    $this->session->set_flashdata('error', (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message'))));
                    redirect(SADMIN_URL . "college");
                }
            }
            //print_r($this->session->flashdata('message')) ; die;
            $current_user = $this->ion_auth->user()->row();
            //$role_name = $this->basic_model->get_user_role($current_user->user_role);
            $this->data = array();
            $this->sidebardata = array();
            //$this->sidebardata["role_name"] = $role_name;
            //$this->sidebardata["profile_photo"] = $current_user->profile_photo;
            $this->sidebardata["username"] = $current_user->first_name . " " . $current_user->last_name;
            $this->sidebardata["role_name"] = $this->basic_model->get_user_role($current_user->user_type);
            $this->sidebardata["profile_photo"] = $current_user->profile_image;
            $this->sidebardata['is_active'] = 'college';
            $this->load->model('sadmin_model');
            $this->data['college_list'] = $this->sadmin_model->get_collegelist();
            $this->data['script_to_include'] = "sadmin_js.js";
            $this->headerdata = array();
            $this->headerdata['page_title'] = "College List";
            $this->headerdata['breadcrumbs'] = array(SADMIN_URL, array('dashboard', 'Dashboard'), array('college', 'College list'));

            $states = $this->basic_model->get_state_list();
            $this->data['states'] = $states;

            $edit_id = $this->uri->segment(3, 0);
            if (isset($edit_id) && $edit_id > 0) {
                $edit_data = $this->sadmin_model->get_college_data($edit_id);
                $this->data['edit_data'] = $edit_data;
            }
            if (isset($edit_data) && !empty($edit_data)) {
                $this->data['edit_id'] = array(
                    'name' => 'edit_id',
                    'id' => 'edit_id',
                    'type' => 'hidden',
                    'class' => 'form-control',
                    'value' => $edit_data[0]->user_id
                );


                $this->data['user_email'] = array(
                    'name' => 'user_email',
                    'id' => 'user_email',
                    "class" => "form-control",
                    'type' => 'text',
                    'maxlength' => '100',
                    'disabled' => 'disabled',
                    'value' => isset($edit_data) && !empty($edit_data) && isset($edit_data[0]->user_email) ? $edit_data[0]->user_email : ''
                );

                $this->data['first_name'] = array(
                    'name' => 'first_name',
                    'id' => 'first_name',
                    'type' => 'text',
                    'maxlength' => '32',
                    "class" => "form-control  col-md-7 col-xs-12",
                    'placeholder' => "First Name",
                    'value' => isset($edit_data) && !empty($edit_data) && isset($edit_data[0]->first_name) ? $edit_data[0]->first_name : ''
                );
                $this->data['last_name'] = array(
                    'name' => 'last_name',
                    'id' => 'last_name',
                    'type' => 'text',
                    'maxlength' => '32',
                    "class" => "form-control  col-md-7 col-xs-12",
                    'placeholder' => "Last Name",
                    'value' => isset($edit_data) && !empty($edit_data) && isset($edit_data[0]->last_name) ? $edit_data[0]->last_name : ''
                );

                $this->data['college_name'] = array(
                    'name' => 'college_name',
                    'id' => 'college_name',
                    'type' => 'text',
                    'maxlength' => '100',
                    "class" => "form-control  col-md-7 col-xs-12",
                    'placeholder' => "College Name",
                    'value' => isset($edit_data) && !empty($edit_data) && isset($edit_data[0]->college_name) ? $edit_data[0]->college_name : ''
                );

                $this->data['college_address'] = array(
                    'name' => 'college_address',
                    'id' => 'college_address',
                    'type' => 'text',
                    'maxlength' => '100',
                    "class" => "form-control  col-md-7 col-xs-12",
                    'placeholder' => "College Address",
                    'value' => isset($edit_data) && !empty($edit_data) && isset($edit_data[0]->college_address) ? $edit_data[0]->college_address : ''
                );

                $this->data['college_state'] = array(
                    'name' => 'college_state',
                    'id' => 'college_state',
                    'type' => 'text',
                    'maxlength' => '100',
                    "class" => "form-control  col-md-7 col-xs-12",
                    'placeholder' => "College State",
                    'value' => isset($edit_data) && !empty($edit_data) && isset($edit_data[0]->college_state) ? $edit_data[0]->college_state : ''
                );

                $this->data['college_city'] = array(
                    'name' => 'college_city',
                    'id' => 'college_city',
                    'type' => 'text',
                    'maxlength' => '32',
                    "class" => "form-control  col-md-7 col-xs-12",
                    'placeholder' => "College City",
                    'value' => isset($edit_data) && !empty($edit_data) && isset($edit_data[0]->college_city) ? $edit_data[0]->college_city : ''
                );

                $this->data['college_zipcode'] = array(
                    'name' => 'college_zipcode',
                    'id' => 'college_zipcode',
                    'type' => 'text',
                    'maxlength' => '15',
                    "class" => "form-control  col-md-7 col-xs-12",
                    'placeholder' => "College Zipcode",
                    'value' => isset($edit_data) && !empty($edit_data) && isset($edit_data[0]->college_zipcode) ? $edit_data[0]->college_zipcode : ''
                );

                $this->data['college_office_no'] = array(
                    'name' => 'college_office_no',
                    'id' => 'college_office_no',
                    'type' => 'text',
                    'maxlength' => '15',
                    "class" => "form-control  col-md-7 col-xs-12 mobilemark",
                    'placeholder' => "___-___-____",
                    'value' => isset($edit_data) && !empty($edit_data) && isset($edit_data[0]->college_office_no) ? $edit_data[0]->college_office_no : ''
                );
            } else {
                $this->data['identity'] = array(
                    'name' => 'username',
                    'id' => 'username',
                    "class" => "form-control ",
                    'type' => 'text',
                    'maxlength' => '15',
                    'type' => 'text',
                    'placeholder' => "Username",
                    'value' => isset($postdata) && !empty($postdata) && isset($postdata['username']) ? $postdata['username'] : ''
                );

                $this->data['user_type'] = array(
                    'name' => 'user_type',
                    'id' => 'user_type',
                    "class" => "form-control ",
                    'type' => 'text',
                    'maxlength' => '5',
                    'value' => '4',
                    'type' => 'hidden'
                );

                $this->data['user_email'] = array(
                    'name' => 'user_email',
                    'id' => 'user_email',
                    "class" => "form-control",
                    'type' => 'text',
                    'maxlength' => '100',
                    'placeholder' => "e.g. you@widgetcorp.com",
                    'value' => isset($postdata) && !empty($postdata) && isset($postdata['user_email']) ? $postdata['user_email'] : ''
                );

                $this->data['first_name'] = array(
                    'name' => 'first_name',
                    'id' => 'first_name',
                    'type' => 'text',
                    'maxlength' => '32',
                    "class" => "form-control  col-md-7 col-xs-12",
                    'placeholder' => "First Name",
                    'value' => isset($postdata) && !empty($postdata) && isset($postdata['first_name']) ? $postdata['first_name'] : ''
                );
                $this->data['last_name'] = array(
                    'name' => 'last_name',
                    'id' => 'last_name',
                    'type' => 'text',
                    'maxlength' => '32',
                    "class" => "form-control  col-md-7 col-xs-12",
                    'placeholder' => "Last Name",
                    'value' => isset($postdata) && !empty($postdata) && isset($postdata['last_name']) ? $postdata['last_name'] : ''
                );

                $this->data['college_name'] = array(
                    'name' => 'college_name',
                    'id' => 'college_name',
                    'type' => 'text',
                    'maxlength' => '100',
                    "class" => "form-control  col-md-7 col-xs-12",
                    'placeholder' => "College Name",
                    'value' => isset($postdata) && !empty($postdata) && isset($postdata['college_name']) ? $postdata['college_name'] : ''
                );

                $this->data['college_address'] = array(
                    'name' => 'college_address',
                    'id' => 'college_address',
                    'type' => 'text',
                    'maxlength' => '100',
                    "class" => "form-control  col-md-7 col-xs-12",
                    'placeholder' => "College Address",
                    'value' => isset($postdata) && !empty($postdata) && isset($postdata['college_address']) ? $postdata['college_address'] : ''
                );

                $this->data['college_state'] = array(
                    'name' => 'college_state',
                    'id' => 'college_state',
                    'type' => 'text',
                    'maxlength' => '100',
                    "class" => "form-control  col-md-7 col-xs-12",
                    'placeholder' => "College State",
                    'value' => isset($postdata) && !empty($postdata) && isset($postdata['college_state']) ? $postdata['college_state'] : ''
                );

                $this->data['college_city'] = array(
                    'name' => 'college_city',
                    'id' => 'college_city',
                    'type' => 'text',
                    'maxlength' => '32',
                    "class" => "form-control  col-md-7 col-xs-12",
                    'placeholder' => "College City",
                    'value' => isset($postdata) && !empty($postdata) && isset($postdata['college_city']) ? $postdata['college_city'] : ''
                );

                $this->data['college_zipcode'] = array(
                    'name' => 'college_zipcode',
                    'id' => 'college_zipcode',
                    'type' => 'text',
                    'maxlength' => '15',
                    "class" => "form-control  col-md-7 col-xs-12",
                    'placeholder' => "College Zipcode",
                    'value' => isset($postdata) && !empty($postdata) && isset($postdata['college_zipcode']) ? $postdata['college_zipcode'] : ''
                );

                $this->data['college_office_no'] = array(
                    'name' => 'college_office_no',
                    'id' => 'college_office_no',
                    'type' => 'text',
                    'maxlength' => '15',
                    "class" => "form-control  col-md-7 col-xs-12 mobilemark",
                    'placeholder' => "___-___-____",
                    'value' => isset($postdata) && !empty($postdata) && isset($postdata['college_office_no']) ? $postdata['college_office_no'] : ''
                );
            }

            $this->templatelayout->get_admin_dashboard_header($this->headerdata);
            $this->templatelayout->get_admin_dashboard_footer();
            $this->templatelayout->get_admin_dashboard_sidebar('superadminsidebar', $this->sidebardata);
            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
            $this->data['error'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('error')));
            $this->elements['middle'] = 'sadmin/college_list';
            $this->elements_data['middle'] = $this->data;
            $this->layout->setLayout('backend_layout/dashboardlayout');
            $this->layout->multiple_view($this->elements, $this->elements_data);
        }
    }

    public function mailtemplates() {
        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect(SITE_URL, 'refresh');
            exit;
        } else {
            $current_user = $this->ion_auth->user()->row();
            $this->data = array();
            $this->sidebardata = array();
            $this->sidebardata['is_active'] = 'mailtemplates';
            $this->sidebardata["username"] = $current_user->first_name . " " . $current_user->last_name;
            $this->sidebardata["role_name"] = $this->basic_model->get_user_role($current_user->user_type);
            $this->sidebardata["profile_photo"] = $current_user->profile_image;
            $this->headerdata['page_title'] = "Mail Templates";

            $this->data['script_to_include'] = "sadmin_js.js";
            $this->headerdata['breadcrumbs'] = array(SADMIN_URL, array('dashboard', 'Dashboard'), array('mailtemplates', 'Mail Templates'));
            $this->templatelayout->get_admin_dashboard_header($this->headerdata);
            $this->templatelayout->get_admin_dashboard_footer();
            $this->templatelayout->get_admin_dashboard_sidebar('superadminsidebar', $this->sidebardata);
            $mail_templates = $this->sadmin_model->get_mail_templates();
            if (isset($mail_templates) && !empty($mail_templates) && count($mail_templates)) {
                $this->data['mail_templates'] = $mail_templates;
            }

            $edit_id = $this->uri->segment(3, 0);
            if (isset($edit_id) && !empty($edit_id) && strlen($edit_id) > 0) {
                $edit_data = $this->sadmin_model->get_mail_template_data($edit_id);
                if (isset($edit_data) && (count($edit_data) > 0) && !empty($edit_data)) {
                    $this->data['edit_data'] = $edit_data;
                    $this->data['template_name'] = array(
                        'name' => 'template_name',
                        'id' => 'template_name',
                        'type' => 'text',
                        'class' => 'form-control',
                        'value' => $edit_data[0]->mail_template_name
                    );

                    $this->data['template_subject'] = array(
                        'name' => 'template_subject',
                        'id' => 'template_subject',
                        'type' => 'text',
                        'class' => 'form-control',
                        'value' => $edit_data[0]->mail_subject
                    );

                    $this->data['edit_id'] = array(
                        'name' => 'edit_id',
                        'id' => 'edit_id',
                        'type' => 'hidden',
                        'class' => 'form-control',
                        'value' => $edit_data[0]->mail_template_id
                    );

                    $this->data['mail_template_content'] = array(
                        'name' => 'mail_template_content',
                        'id' => 'mail_template_content',
                        'rows' => '4',
                        'value' => html_entity_decode($edit_data[0]->mail_template_content),
                        'class' => 'form-control'
                    );
                }
            }

            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

            $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');

            $this->elements['middle'] = 'sadmin/mailtemplates';

            $this->elements_data['middle'] = $this->data;

            $this->layout->setLayout('backend_layout/dashboardlayout');

            $this->layout->multiple_view($this->elements, $this->elements_data);
        }
    }

    public function update_template() {
        if (!$this->ion_auth->logged_in()) {
            redirect(SITE_URL, 'refresh');
            exit;
        } else {
            $current_user = $this->ion_auth->user()->row();
            $edit_id = $this->input->post('edit_id');
            if (isset($edit_id) && $edit_id > 0) {
                $this->form_validation->set_rules('template_name', 'Template Name', 'required');
                $this->form_validation->set_rules('template_subject', 'Subject', 'required');
                $this->form_validation->set_rules('mail_template_content', 'Template Content', 'required');
                if ($this->form_validation->run() == true) {
                    $template_name = $this->input->post('template_name');
                    $mail_template_content = htmlentities($this->input->post('mail_template_content'));
                    $mail_subject = htmlentities($this->input->post('template_subject'));
                    $data = array("mail_template_name" => $template_name, "mail_template_content" => $mail_template_content, "mail_subject" => $mail_subject);

                    if ($this->sadmin_model->update_template($data, $edit_id)) {
                        $this->session->set_flashdata('message', lang('template_successfully_updated'));
                        redirect(SADMIN_URL . "mailtemplates/");
                    }
                } else {
                    $_SESSION['postdata'] = $_POST;
                    $this->session->set_flashdata('error', (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message'))));
                }
            }
            redirect(SADMIN_URL . "mailtemplates/$edit_id");
        }
    }

    public function college_update_status() {
        $this->load->model('sadmin_model');
        $userinfo = $this->basic_model->get_userinfo($this->input->post('user_id'));
        if ($userinfo->first_name == '') {
            $identity = $this->config->item('identity', 'ion_auth');
            $identity = $userinfo->{$identity};
        } else {
            $identity = ucfirst($userinfo->first_name . ' ' . $userinfo->last_name);
        }
        $return = $this->sadmin_model->college_update_status();

        if ($return) {
            $data = array(
                'identity' => $identity
            );
            if ($this->input->post('status') != '1') {
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
            }
        } else {
            echo $return;
        }
    }

    public function cmspages() {
        if (!$this->ion_auth->logged_in()) {
            redirect(SITE_URL, 'refresh');
            exit;
        } else {
            $current_user = $this->ion_auth->user()->row();
            $this->data = array();
            $this->sidebardata = array();
            $this->sidebardata['is_active'] = 'cmspages';
            $this->sidebardata["username"] = $current_user->first_name . " " . $current_user->last_name;
            $this->sidebardata["role_name"] = $this->basic_model->get_user_role($current_user->user_type);
            $this->sidebardata["profile_photo"] = $current_user->profile_image;
            $this->headerdata['page_title'] = "CMS Pages";
            $this->data['script_to_include'] = "sadmin_js.js";
            $this->headerdata['breadcrumbs'] = array(SADMIN_URL, array('dashboard', 'Dashboard'), array('mailtemplates', 'CMS Pages'));
            $this->templatelayout->get_admin_dashboard_header($this->headerdata);
            $this->templatelayout->get_admin_dashboard_footer();
            $this->templatelayout->get_admin_dashboard_sidebar('superadminsidebar', $this->sidebardata);
            $page_templates = $this->sadmin_model->get_cms_pages();
            if (isset($page_templates) && !empty($page_templates) && count($page_templates)) {
                $this->data['page_templates'] = $page_templates;
            }
            $edit_id = $this->uri->segment(3, 0);
            if (isset($edit_id) && !empty($edit_id)) {
                $edit_info = $this->sadmin_model->get_page_detail($edit_id);
                if (isset($edit_info) && !empty($edit_info)) {
                    $this->data['edit_id'] = $edit_id;
                    $this->data['edit_data'] = $edit_info;
                    $this->data['page_title'] = array(
                        'name' => 'page_title',
                        'id' => 'page_title',
                        'type' => 'text',
                        'class' => 'form-control',
                        'value' => $edit_info[0]->page_title
                    );
                    $this->data['edit_id'] = array(
                        'name' => 'edit_id',
                        'id' => 'edit_id',
                        'type' => 'hidden',
                        'class' => 'form-control',
                        'value' => $edit_info[0]->page_id
                    );

                    $this->data['page_content'] = array(
                        'name' => 'page_content',
                        'id' => 'page_content',
                        'rows' => '4',
                        'value' => html_entity_decode($edit_info[0]->page_content),
                        'class' => 'form-control'
                    );
                }
            }
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
            $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
            $this->elements['middle'] = 'sadmin/pagetemplates';
            $this->elements_data['middle'] = $this->data;
            $this->layout->setLayout('backend_layout/dashboardlayout');
            $this->layout->multiple_view($this->elements, $this->elements_data);
        }
    }

    public function update_page() {
        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect(SITE_URL, 'refresh');

            exit;
        } else {

            $current_user = $this->ion_auth->user()->row();
            $edit_id = $this->input->post('edit_id');

            if (isset($edit_id) && $edit_id > 0) {

                $page_title = $this->input->post('page_title');

                $page_content = htmlentities($this->input->post('page_content'));
                $data = array("page_title" => $page_title, "page_content" => $page_content);

                if ($this->sadmin_model->update_page($data, $edit_id)) {

                    $this->session->set_flashdata('message', lang('page_successfully_updated'));

                    redirect(SADMIN_URL . "cmspages/");
                }
            }
        }
    }

    public function changepassword() {

        if (!$this->ion_auth->logged_in()) {

            // redirect them to the login page

            redirect(SITE_URL, 'refresh');

            exit;
        } else {

            $current_user = $this->ion_auth->user()->row();

            if ($current_user->user_type != "1") {

                if ($current_user->user_type == "2") {

                    redirect(COMPANY_URL . "dashboard", 'refresh');

                    exit;
                } elseif ($current_user->user_type == "3") {

                    redirect(USER_URL . "dashboard");
                } elseif ($current_user->user_type == "4") {

                    redirect(AFFILIATE_URL . "dashboard");
                } elseif ($current_user->user_type == "5") {

                    redirect(ADMIN_URL . "admin/dashboard");
                }
            } else {



                $this->data = array();



                $this->data['script_to_include'] = "sadmin_js.js";




                $this->sidebardata = array();
                $this->sidebardata["username"] = $current_user->first_name . " " . $current_user->last_name;

                $this->sidebardata["role_name"] = $this->basic_model->get_user_role($current_user->user_type);
                $this->sidebardata['is_active'] = 'changepassword';

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
                    //'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
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

                $this->headerdata['breadcrumbs'] = array(SADMIN_URL, array('dashboard', 'Dashboard'), array('changepassword', 'Change Password'));

                $this->templatelayout->get_admin_dashboard_header($this->headerdata);

                $this->templatelayout->get_admin_dashboard_footer();
                $this->sidebardata = array();
                $this->sidebardata["username"] = $current_user->first_name . " " . $current_user->last_name;
                $this->sidebardata["role_name"] = $this->basic_model->get_user_role($current_user->user_type);
                $this->sidebardata["profile_photo"] = $current_user->profile_image;
                $this->sidebardata['is_active'] = 'changepassword';
                $this->templatelayout->get_admin_dashboard_sidebar('superadminsidebar', $this->sidebardata);



                $this->elements['middle'] = 'sadmin/change_password';

                $this->elements_data['middle'] = $this->data;

                $this->layout->setLayout('backend_layout/dashboardlayout');

                $this->layout->multiple_view($this->elements, $this->elements_data);
            }
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

                        redirect(SADMIN_URL . "changepassword", 'refresh');
                    } else {

                        $this->session->set_flashdata('message', $this->ion_auth->messages());

                        redirect(SADMIN_URL . "changepassword", 'refresh');
                    }
                } else {

                    $this->session->set_flashdata('message', $this->ion_auth->messages());

                    redirect(SADMIN_URL . "changepassword", 'refresh');
                }
            } else {

                $this->session->set_flashdata('error', $this->ion_auth->errors());

                redirect(SADMIN_URL . "changepassword", 'refresh');
            }
        } else {

            $this->session->set_flashdata('error', (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message'))));
            redirect(SADMIN_URL . "changepassword");
        }
    }

    function redirecttocollege($id) {
        if (isset($id) && !empty($id)) {
            $id = base64_decode($id);
            $user_data = $this->basic_model->get_user_data($id);
            if (isset($user_data) && !empty($user_data)) {
                // Switchin Session Data
                $session_data = array(
                    'identity' => $user_data['user_email'],
                    'username' => $user_data['user_email'],
                    'email' => $user_data['user_email'],
                    'user_id' => $user_data['user_id'], //everyone likes to overwrite id so we'll use user_id
                    'old_last_login' => $user_data['last_login'],
                    'from_admin' => '1'
                );
                $this->session->set_userdata($session_data);
//                $this->session->set_userdata("total_logins", $this->basic_model->get_login_stat($user_data['user_id']));
                redirect(COLLEGE_URL . "dashboard");
                //
            }
        }
    }

    public function manage_profile() {
        $current_user = $this->ion_auth->user()->row();
        $tables = $this->config->item('tables', 'ion_auth');
        $identity_column = $this->config->item('identity', 'ion_auth');
        $this->data['identity_column'] = $identity_column;
        if (!$this->ion_auth->logged_in()) {
            redirect(SITE_URL, 'refresh');
            exit;
        } else {
            $this->data = array();
            $this->headerdata = array();
            $postdata = isset($_SESSION['postdata']) ? $_SESSION['postdata'] : '';
            if (!isset($postdata) && empty($postdata)) {

            }

            $this->data['title'] = "Manage Profile";

            $tables = $this->config->item('tables', 'ion_auth');
            $identity_column = $this->config->item('identity', 'ion_auth');
            $this->data['identity_column'] = $identity_column;
            // display the create user form
            // set the flash data error message if there is one
            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
            $this->data['error'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('error')));

            $this->data['user_id'] = array(
                'name' => 'user_id',
                'id' => 'user_id',
                "class" => "form-control ",
                'type' => 'text',
                'maxlength' => '5',
                'value' => $current_user->user_id,
                'type' => 'hidden'
            );

            $this->data['user_type'] = array(
                'name' => 'user_type',
                'id' => 'user_type',
                "class" => "form-control ",
                'type' => 'text',
                'maxlength' => '5',
                'value' => '4',
                'type' => 'hidden'
            );

            $this->data['email'] = array(
                'name' => 'email',
                'id' => 'email',
                "class" => "form-control",
                'type' => 'text',
                'readonly' => "readonly",
                'maxlength' => '100',
                'placeholder' => "e.g. you@widgetcorp.com",
                'value' => isset($postdata) && !empty($postdata) && isset($postdata['email']) ? $postdata['email'] : $current_user->user_email
            );

            $this->data['first_name'] = array(
                'name' => 'first_name',
                'id' => 'first_name',
                'type' => 'text',
                'maxlength' => '32',
                "class" => "form-control  col-md-7 col-xs-12",
                'placeholder' => "First Name",
                'value' => isset($postdata) && !empty($postdata) && isset($postdata['first_name']) ? $postdata['first_name'] : $current_user->first_name
            );
            $this->data['last_name'] = array(
                'name' => 'last_name',
                'id' => 'last_name',
                'type' => 'text',
                'maxlength' => '32',
                "class" => "form-control  col-md-7 col-xs-12",
                'placeholder' => "Last Name",
                'value' => isset($postdata) && !empty($postdata) && isset($postdata['last_name']) ? $postdata['last_name'] : $current_user->last_name
            );
            $this->data['patient_identification_number'] = array(
                'name' => 'patient_identification_number',
                'id' => 'patient_identification_number',
                'type' => 'text',
                'maxlength' => '32',
                "class" => "form-control  col-md-7 col-xs-12",
                'placeholder' => "Student ID Number",
                'value' => isset($postdata) && !empty($postdata) && isset($postdata['patient_identification_number']) ? $postdata['patient_identification_number'] : $current_user->patient_identification_number
            );
            $dob_date = "";
            if (isset($current_user->dob) && !empty($current_user->dob)) {
                $dob_date = $this->basic_model->convertDatePatient($current_user->dob);
            }

            $this->data['dob'] = array(
                'name' => 'dob',
                'id' => 'dob',
                'type' => 'text',
                'maxlength' => '32',
                "class" => "form-control  col-md-7 col-xs-12 noneditable ",
                'placeholder' => "Date Of Birth",
                'value' => $dob_date
            );

            $this->data['mobile_no'] = array(
                'name' => 'mobile_no',
                'id' => 'mobile_no',
                'type' => 'text',
                'maxlength' => '15',
                "class" => "form-control  col-md-7 col-xs-12 mobilemark",
                'placeholder' => "___-___-____",
                'value' => isset($postdata) && !empty($postdata) && isset($postdata['mobile_no']) ? $postdata['mobile_no'] : $current_user->mobile_no
            );

            $this->data['address'] = array(
                'name' => 'address',
                'id' => 'address',
                'type' => 'text',
                'maxlength' => '32',
                "class" => "form-control  col-md-7 col-xs-12",
                'placeholder' => "Enter Campus Address",
                'value' => isset($postdata) && !empty($postdata) && isset($postdata['address']) ? $postdata['address'] : $current_user->address
            );
            $this->data['city'] = array(
                'name' => 'city',
                'id' => 'city',
                'type' => 'text',
                'maxlength' => '32',
                "class" => "form-control  col-md-7 col-xs-12",
                'placeholder' => "Enter City",
                'value' => isset($postdata) && !empty($postdata) && isset($postdata['city']) ? $postdata['city'] : $current_user->city
            );

            $this->data['zipcode'] = array(
                'name' => 'zipcode',
                'id' => 'zipcode',
                'type' => 'text',
                'maxlength' => '10',
                "class" => "form-control  col-md-7 col-xs-12",
                'placeholder' => "Enter Zipcode",
                'value' => isset($postdata) && !empty($postdata) && isset($postdata['zipcode']) ? $postdata['zipcode'] : $current_user->zipcode
            );

            $states = $this->basic_model->get_state_list();

            $this->data['states'] = $states;

            if (isset($current_user->state) && !empty($current_user->state)) {
                $state_select = $current_user->state;
            } else {
                $state_select = '';
            }
            $this->data['state_selected'] = $state_select;

            $this->data['timezone_list'] = array('' => 'Select Time Zone') + $this->basic_model->get_timezonelist();
            if (isset($current_user->timezone_id) && !empty($current_user->timezone_id)) {
                $timezone_list_selected = $current_user->timezone_id;
            } else {
                $timezone_list_selected = DEFAULT_TIMEZONE;
            }
            $this->data['timezone_list_selected'] = $timezone_list_selected;
            $this->data['profile_image'] = $current_user->profile_image;

            $this->data['ethnicity_list'] = array('' => 'Select Ethnicity') + $this->basic_model->get_ethnicitylist();
            if (isset($current_user->ethnicity) && !empty($current_user->ethnicity)) {
                $ethnicity_list_selected = $current_user->ethnicity;
            } else {
                $ethnicity_list_selected = '';
            }
            $this->data['ethnicity_list_selected'] = $ethnicity_list_selected;

            if (isset($current_user->gender) && !empty($current_user->gender)) {
                $gender_selected = $current_user->gender;
            } else {
                $gender_selected = 1;
            }
            $this->data['gender_selected'] = $gender_selected;
            unset($_SESSION['postdata']);
            $this->data['script_to_include'] = "sadmin_js.js";
            $this->sidebardata = array();
            $this->sidebardata['is_active'] = 'manage_profile';
            $this->sidebardata["username"] = ucwords($current_user->first_name . ' ' . $current_user->last_name);
            $this->sidebardata["role_name"] = $this->basic_model->get_user_role($current_user->user_type);
            $this->sidebardata["profile_photo"] = $current_user->profile_image;
            $this->headerdata['page_title'] = "Manage Profile";
            $this->headerdata['breadcrumbs'] = array(PATIENT_URL, array('dashboard', 'Dashboard'), array('manage_profile', 'Manage Profile'));
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
            $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
            $this->templatelayout->get_admin_dashboard_header($this->headerdata);
            $this->templatelayout->get_admin_dashboard_footer();
            $this->templatelayout->get_admin_dashboard_sidebar('superadminsidebar', $this->sidebardata);
            $this->elements['middle'] = 'sadmin/admin_manage_profile';
            $this->elements_data['middle'] = $this->data;
            $this->layout->setLayout('backend_layout/dashboardlayout');
            $this->layout->multiple_view($this->elements, $this->elements_data);
        }
    }

    public function manage_admin_profile() {
        // Configuration options
        $tables = $this->config->item('tables', 'ion_auth');
        $identity_column = $this->config->item('identity', 'ion_auth');
        $this->data['identity_column'] = $identity_column;



        $this->form_validation->set_rules('first_name', $this->lang->line('create_user_validation_fname_label'), 'required');
        $this->form_validation->set_rules('last_name', $this->lang->line('create_user_validation_lname_label'), 'required');
        $this->form_validation->set_rules('dob', $this->lang->line('create_user_validation_dob_label'), 'required');
        $this->form_validation->set_rules('mobile_no', $this->lang->line('create_user_validation_mobile_no_label'), 'required');

        if ($this->form_validation->run() == true) {
            // check to see if we are creating the user
            // redirect them back to the admin page
            $this->load->model("basic_model");

            $additional_data = array();

            $post_arr = $this->input->post();
            $post_arr = $this->basic_model->stripTagsPostArray($post_arr);
            if ($this->sadmin_model->update_admin($post_arr)) {
                $this->session->set_flashdata('message', 'Admin Profile updated successfully.');
                redirect(SADMIN_URL . "manage_profile");
            } else {
                $_SESSION['postdata'] = $_POST;
                $this->session->set_flashdata('error', "Profile Image must be of JPG/PNG/JPEG/GIF image type.");
                redirect(SADMIN_URL . "manage_profile");
            }
        } else {
            $_SESSION['postdata'] = $_POST;
            $this->session->set_flashdata('error', (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message'))));
            redirect(SADMIN_URL . "manage_profile");
        }
    }

    function email_availablity() {
        $email = $this->input->post('user_email');
        $this->db->select('*');
        $this->db->from(USERS);
        $this->db->where('user_email', $this->input->post('user_email'));
        $query = $this->db->get();
        if ($query->num_rows() == 0) {
            echo 'true';
        } else {
            echo 'false';
        }
    }

    public function tagcollege() {
        if (!$this->ion_auth->logged_in()) {
            redirect(SITE_URL, 'refresh');
            exit;
        }
        if ($this->input->post('provider_id')) {
            $college = implode(',', $this->input->post('colleges'));
            $this->db->update(USERS, array('third_parties_college_ids' => $college), array('user_id' => $this->input->post('provider_id')));
        }
        redirect(base_url('sadmin/counselors'));
    }

    public function transactions($provider_id = false) {
        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect(SITE_URL, 'refresh');
            exit;
        } else {
            $current_user = $this->ion_auth->user()->row();
            $this->data = array();
            $filter = array();
            //$this->session->set_flashdata('message', "Your appointment has been booked.");
            //$this->data['message'] = $this->session->flashdata('message');
            $filter['provider_id'] = $provider_id;
            $filter['start_date'] = isset($_POST['start_date']) ? $this->input->post('start_date') : false;
            $filter['end_date'] = isset($_POST['end_date']) ? $this->input->post('end_date') : false;
            $this->data['transaction'] = $this->sadmin_model->get_appointment_transaction($filter, $provider_id ? true : false);
            if ($provider_id) {
                $this->data['gross_transaction'] = $this->sadmin_model->get_appointment_transaction($filter, false);
            }
            $this->data['provider_id'] = $provider_id;
            $this->data['start_date'] = array(
                'name' => 'start_date',
                'id' => 'start_date',
                'type' => 'text',
                'maxlength' => '32',
                'required' => 'required',
                "class" => "form-control  col-md-7 col-xs-12 noneditable ",
                'placeholder' => "Start date",
                'value' => $filter['start_date']
            );
            $this->data['end_date'] = array(
                'name' => 'end_date',
                'id' => 'end_date',
                'type' => 'text',
                'maxlength' => '32',
                'required' => 'required',
                "class" => "form-control  col-md-7 col-xs-12 noneditable ",
                'placeholder' => "End date",
                'value' => $filter['end_date']
            );
            //prd($filter,1);
            $this->sidebardata = array();
            //$this->sidebardata["role_name"] = $role_name;
            $this->sidebardata["profile_photo"] = $current_user->profile_image;
            $this->sidebardata["username"] = $current_user->first_name . " " . $current_user->last_name;
            $this->sidebardata['is_active'] = 'transactions';
            $this->sidebardata["role_name"] = $this->basic_model->get_user_role($current_user->user_type);

            $this->headerdata['page_title'] = "Transactions";
            $this->headerdata['breadcrumbs'] = array(SADMIN_URL, array('dashboard', 'Dashboard'), array('transactions', 'Transactions'));

            $this->templatelayout->get_admin_dashboard_header($this->headerdata);
            $this->templatelayout->get_admin_dashboard_footer();
            $this->templatelayout->get_admin_dashboard_sidebar('superadminsidebar', $this->sidebardata);
            $this->elements['middle'] = $provider_id ? 'sadmin/transaction_provider' : 'sadmin/transaction';
            $this->elements_data['middle'] = $this->data;
            $this->layout->setLayout('backend_layout/dashboardlayout');
            $this->layout->multiple_view($this->elements, $this->elements_data);
        }
    }

    public function counselors() {
        $tables = $this->config->item('tables', 'ion_auth');
        $identity_column = $this->config->item('identity', 'ion_auth');
        $this->data['identity_column'] = $identity_column;

        if (!$this->ion_auth->logged_in()) {
            redirect(SITE_URL, 'refresh');
            exit;
        } else {
            //print_r($this->session->flashdata('message')) ; die;
            $current_user = $this->ion_auth->user()->row();
            //$role_name = $this->basic_model->get_user_role($current_user->user_role);
            $this->data = array();
            $this->sidebardata = array();
            //$this->sidebardata["role_name"] = $role_name;
            //$this->sidebardata["profile_photo"] = $current_user->profile_photo;
            $this->sidebardata["username"] = $current_user->first_name . " " . $current_user->last_name;
            $this->sidebardata["role_name"] = $this->basic_model->get_user_role($current_user->user_type);
            $this->sidebardata["profile_photo"] = $current_user->profile_image;
            $this->sidebardata['is_active'] = 'counselors';
            $this->load->model('sadmin_model');
            $this->data['counselors_list'] = $this->sadmin_model->get_counselorslist();

            $this->load->model('college_model');
            $this->data['college_lists'] = $this->college_model->getCollege();
            $this->data['college'] = array('0' => 'Select College') + $this->college_model->getCollege();
            $this->data['script_to_include'] = "sadmin_js.js";
            $this->headerdata = array();
            $this->headerdata['page_title'] = "Counselors List";
            $this->headerdata['breadcrumbs'] = array(SADMIN_URL, array('dashboard', 'Dashboard'), array('counselors', 'Counselors list'));

            $states = $this->basic_model->get_state_list();
            $this->data['states'] = $states;

            $this->templatelayout->get_admin_dashboard_header($this->headerdata);
            $this->templatelayout->get_admin_dashboard_footer();
            $this->templatelayout->get_admin_dashboard_sidebar('superadminsidebar', $this->sidebardata);
            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
            $this->data['error'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('error')));
            $this->elements['middle'] = 'sadmin/counselors_list';
            $this->elements_data['middle'] = $this->data;
            $this->layout->setLayout('backend_layout/dashboardlayout');
            $this->layout->multiple_view($this->elements, $this->elements_data);
        }
    }

    public function students() {
        $tables = $this->config->item('tables', 'ion_auth');
        $identity_column = $this->config->item('identity', 'ion_auth');
        $this->data['identity_column'] = $identity_column;

        if (!$this->ion_auth->logged_in()) {
            redirect(SITE_URL, 'refresh');
            exit;
        } else {
            //print_r($this->session->flashdata('message')) ; die;
            $current_user = $this->ion_auth->user()->row();
            //$role_name = $this->basic_model->get_user_role($current_user->user_role);
            $this->data = array();
            $this->sidebardata = array();
            //$this->sidebardata["role_name"] = $role_name;
            //$this->sidebardata["profile_photo"] = $current_user->profile_photo;
            $this->sidebardata["username"] = $current_user->first_name . " " . $current_user->last_name;
            $this->sidebardata["role_name"] = $this->basic_model->get_user_role($current_user->user_type);
            $this->sidebardata["profile_photo"] = $current_user->profile_image;
            $this->sidebardata['is_active'] = 'students';
            $this->load->model('sadmin_model');
            $this->data['students_list'] = $this->sadmin_model->get_studentslist();

            $this->data['script_to_include'] = "sadmin_js.js";
            $this->headerdata = array();
            $this->headerdata['page_title'] = "Students List";
            $this->headerdata['breadcrumbs'] = array(SADMIN_URL, array('dashboard', 'Dashboard'), array('students', 'Students list'));

            $states = $this->basic_model->get_state_list();
            $this->data['states'] = $states;

            $this->templatelayout->get_admin_dashboard_header($this->headerdata);
            $this->templatelayout->get_admin_dashboard_footer();
            $this->templatelayout->get_admin_dashboard_sidebar('superadminsidebar', $this->sidebardata);
            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
            $this->data['error'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('error')));
            $this->elements['middle'] = 'sadmin/students_list';
            $this->elements_data['middle'] = $this->data;
            $this->layout->setLayout('backend_layout/dashboardlayout');
            $this->layout->multiple_view($this->elements, $this->elements_data);
        }
    }

    function update_template_status() {

        $mail_template_id = $this->uri->segment(3, 0);
        $mail_template_status = $this->uri->segment(4, 0);

        if (isset($mail_template_id)) {
            if (!$mail_template_status || $mail_template_status == "DeActivate") {

                $data['mail_template_status'] = intval('0');
            } else {

                $data['mail_template_status'] = intval('1');
            }

            if ($this->db->update(MAIL_TEMPLATES, $data, "mail_template_id=" . $mail_template_id)) {

                $this->session->set_flashdata('message', 'Template Status Updated Successfully.');

                echo "1";
            } else {

                $this->session->set_flashdata('error', 'Error Please Try again later');

                echo "0";
            }
        }
    }

    function welcome($college = '') {
        $this->load->model('college_model');
        $current_user = $this->ion_auth->user()->row();
        $tables = $this->config->item('tables', 'ion_auth');
        $identity_column = $this->config->item('identity', 'ion_auth');
        $this->data['identity_column'] = $identity_column;
        if (!$this->ion_auth->logged_in()) {
            redirect(SITE_URL, 'refresh');
            exit;
        } else {
            $this->data = array();
            $this->headerdata = array();
            $postdata = isset($_SESSION['postdata']) ? $_SESSION['postdata'] : '';
            if (!isset($postdata) && empty($postdata)) {

            }
            $college_lists = $this->college_model->getCollege();
            if (isset($college) && !empty($college) && $college > 0) {
                $this->data['college_id'] = $college;
            } else {
                $college = key($college_lists);
                $this->data['college_id'] = $college;
            }
            $this->data['title'] = "Welcome Note";
            $tables = $this->config->item('tables', 'ion_auth');
            $identity_column = $this->config->item('identity', 'ion_auth');
            $this->data['identity_column'] = $identity_column;
            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
            $this->data['error'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('error')));

            if ($this->input->post()) {
//                $updatewelcomedata = $this->sadmin_model->updatewelcomeData(array('notes_detail' => $_POST['notes_detail'], 'college_id' => $_POST['collegeid'], 'logo_image' => $_FILES['logo_image']['name']));
                $updatewelcomedata = $this->sadmin_model->updatewelcomeData(array('notes_detail' => $_POST['notes_detail'], 'college_id' => $_POST['collegeid']));
                if ($updatewelcomedata > 0) {
                    if ($this->sadmin_model->welcome_note_image(array('welcome_notes_id' => $updatewelcomedata, 'collage_id' => $_POST['collegeid']))) {
                        $this->session->set_flashdata('message', 'Welcome note updated successfully');
                    } else {
                        $this->session->set_flashdata('error', 'Error! Upload Image is not saved.');
                    }
                }
            }
            $cond = array('college_id' => $college, 'type != ' => 0);
            $notes = $this->sadmin_model->getwelcomeData($cond);
            $this->data['notes_img'] = $this->sadmin_model->getwelcome_imageData(array('collage_id' => $college));

            $this->data['states'] = $notes;
            $this->data['college_lists'] = $college_lists;

            $this->data['notes_detail'] = array(
                'name' => 'notes_detail',
                'id' => 'notes_detail',
                'rows' => '4',
                'placeholder' => 'welcome_note_content',
                'class' => 'form-control',
                'value' => (isset($notes->notes_detail) && !empty($notes->notes_detail) ? $notes->notes_detail : '')
            );

            $this->data['script_to_include'] = "sadmin_js.js";
            $this->sidebardata = array();
            $this->sidebardata['is_active'] = 'welcome';
            $this->sidebardata["username"] = ucwords($current_user->first_name . ' ' . $current_user->last_name);
            $this->sidebardata["role_name"] = $this->basic_model->get_user_role($current_user->user_type);
            $this->sidebardata["profile_photo"] = $current_user->profile_image;
            $this->headerdata['page_title'] = "Welcome Note";
            $this->headerdata['breadcrumbs'] = array(PATIENT_URL, array('dashboard', 'Dashboard'), array('welcome', 'Welcome Note'));
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
            $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
            $this->templatelayout->get_admin_dashboard_header($this->headerdata);
            $this->templatelayout->get_admin_dashboard_footer();
            $this->templatelayout->get_admin_dashboard_sidebar('superadminsidebar', $this->sidebardata);
            $this->elements['middle'] = 'sadmin/welcome';
            $this->elements_data['middle'] = $this->data;
            $this->layout->setLayout('backend_layout/dashboardlayout');
            $this->layout->multiple_view($this->elements, $this->elements_data);
        }
    }

    public function delete_welcomeimage($id) {
        $image_path = "assets/upload/welcome_note_image/"; // your image path
        $query_get_image = $this->db->get_where('welcome_note_image', array('id' => $id));
        foreach ($query_get_image->result() as $record) {
            // delete file, if exists...
            $filename = $image_path . $record->image;

            if (file_exists($filename)) {
                unlink($image_path . $record->image);
            }
            // ...and continue with your code
            $status = $this->sadmin_model->delete_welcome_image($record->id);
            if ($status == 'true') {
                $this->session->set_flashdata('message', "Image delete successfully.");
            } else {
                $this->session->set_flashdata('error', "Error! Please try again later.");
            }
            redirect(SADMIN_URL . 'welcome/' . $record->collage_id);
        }
    }

    function bettermynd_note() {
        //$this->load->model('college_model');
        $current_user = $this->ion_auth->user()->row();
        $tables = $this->config->item('tables', 'ion_auth');
        $identity_column = $this->config->item('identity', 'ion_auth');
        $this->data['identity_column'] = $identity_column;
        if (!$this->ion_auth->logged_in()) {
            redirect(SITE_URL, 'refresh');
            exit;
        } else {
            $this->data = array();
            $this->headerdata = array();
            $postdata = isset($_SESSION['postdata']) ? $_SESSION['postdata'] : '';
            if (!isset($postdata) && empty($postdata)) {

            }
            $this->data['title'] = "BetterMynd Note";
            $tables = $this->config->item('tables', 'ion_auth');
            $identity_column = $this->config->item('identity', 'ion_auth');
            $this->data['identity_column'] = $identity_column;
            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
            $this->data['error'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('error')));

            if ($this->input->post()) {
                if ($this->sadmin_model->updatebettermynd_noteData(array('note_title' => $_POST['note_title'], 'notes_detail' => $_POST['notes_detail'], 'notes_id' => $_POST['notes_id'], 'type' => '0'))) {
                    $this->session->set_flashdata('message', 'BetterMynd note updated successfully');
                }
            }
            $cond = array('type' => '0');
            $notes = $this->sadmin_model->getwelcomeData($cond);
            $this->data['notes_id_value'] = (isset($notes->notes_id) && !empty($notes->notes_id) ? $notes->notes_id : '');
            $this->data['notes_id'] = array(
                'name' => 'notes_id',
                'id' => 'notes_id',
                'type' => 'hidden',
                "class" => "form-control  col-md-7 col-xs-12",
                'placeholder' => "BetterMynd ID",
                'value' => (isset($notes->notes_id) && !empty($notes->notes_id) ? $notes->notes_id : '')
            );

            $this->data['note_title'] = array(
                'name' => 'note_title',
                'id' => 'note_title',
                'type' => 'text',
//                'maxlength' => '50',
                "class" => "form-control  col-md-7 col-xs-12",
                'placeholder' => "BetterMynd Title",
                'value' => (isset($notes->note_title) && !empty($notes->note_title) ? $notes->note_title : '')
            );

            $this->data['notes_detail'] = array(
                'name' => 'notes_detail',
                'id' => 'notes_detail',
                'rows' => '4',
                'placeholder' => 'welcome_note_content',
                'class' => 'form-control',
                'value' => (isset($notes->notes_detail) && !empty($notes->notes_detail) ? $notes->notes_detail : '')
            );

            $this->data['script_to_include'] = "sadmin_js.js";
            $this->sidebardata = array();
            $this->sidebardata['is_active'] = 'welcome';
            $this->sidebardata["username"] = ucwords($current_user->first_name . ' ' . $current_user->last_name);
            $this->sidebardata["role_name"] = $this->basic_model->get_user_role($current_user->user_type);
            $this->sidebardata["profile_photo"] = $current_user->profile_image;
            $this->headerdata['page_title'] = "BetterMynd Note";
            $this->headerdata['breadcrumbs'] = array(PATIENT_URL, array('dashboard', 'Dashboard'), array('welcome', 'BetterMynd Note'));
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
            $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
            $this->templatelayout->get_admin_dashboard_header($this->headerdata);
            $this->templatelayout->get_admin_dashboard_footer();
            $this->templatelayout->get_admin_dashboard_sidebar('superadminsidebar', $this->sidebardata);
            $this->elements['middle'] = 'sadmin/bettermynd_note';
            $this->elements_data['middle'] = $this->data;
            $this->layout->setLayout('backend_layout/dashboardlayout');
            $this->layout->multiple_view($this->elements, $this->elements_data);
        }
    }

    public function get_college_html() {
        $this->load->model('college_model');
        $college_lists = $this->college_model->getCollege();
        $string = '';
        $col_list = explode("_", trim($_POST['cdata']));
        if (isset($college_lists) && sizeof($college_lists) > 0) {
            foreach ($college_lists as $key => $value) {
                $ids = 'college_' . $key;

                if (in_array($key, $col_list)) {
                    $string .= "<div class='form-control'><label><input type='checkbox' name='colleges[]' id='" . $ids . "' value='" . $key . "' checked='checked' class='collegelist'  />&nbsp;" . $value . "</label></div>";
                } else {
                    $string .= "<div class='form-control'><label><input type='checkbox' name='colleges[]' id='" . $ids . "' value='" . $key . "' class='collegelist'  />&nbsp;" . $value . "</label></div>";
                }
            }
        }
        echo $string;
        exit();
    }

    public function user_change_password($user_id = false) {
        $current_user = $this->ion_auth->user()->row();
        $tables = $this->config->item('tables', 'ion_auth');
        $identity_column = $this->config->item('identity', 'ion_auth');
        $this->data['identity_column'] = $identity_column;
        if (!$this->ion_auth->logged_in()) {
            redirect(SITE_URL, 'refresh');
            exit;
        } else {
            $this->data = array();
            $this->headerdata = array();
            $user_id = base64_decode($user_id);
            $userinfo = $this->basic_model->get_userinfo($user_id);
            if (!$userinfo) {
                redirect(SADMIN_URL, 'refresh');
                exit;
            }

            if ($userinfo->user_type == 2)
                $action = 'college';
            if ($userinfo->user_type == 3 || $userinfo->user_type == 5)
                $action = 'counselors';
            if ($userinfo->user_type == 4)
                $action = 'students';

            $this->data['return_url'] = SADMIN_URL . $action;

            $this->data['title'] = "Chnage Password";
            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
            $this->data['error'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('error')));

            $this->data['user_name'] = ucfirst($userinfo->first_name . ' ' . $userinfo->last_name);
            $this->data['user_email'] = $userinfo->user_email;
            $this->data['user_id'] = array(
                'name' => 'user_id',
                'id' => 'user_id',
                "class" => "form-control ",
                'type' => 'text',
                'maxlength' => '5',
                'value' => base64_encode($userinfo->user_id),
                'type' => 'hidden'
            );
            $this->data['new_password'] = array(
                'name' => 'new',
                'id' => 'new',
                'type' => 'password',
                "class" => "form-control",
                'autofocus' => 'true',
                'placeholder' => 'Enter new password'
                    //'pattern' => '^.{'.$this->data['min_password_length'].'}.*$',
            );
            $this->data['new_password_confirm'] = array(
                'name' => 'new_confirm',
                'id' => 'new_confirm',
                'type' => 'password',
                "class" => "form-control",
                'placeholder' => 'Enter confirm password'

                    //'pattern' => '^.{'.$this->data['min_password_length'].'}.*$',
            );

            $this->data['script_to_include'] = "sadmin_js.js";
            $this->sidebardata = array();
            $this->sidebardata['is_active'] = 'user_change_passord';
            $this->sidebardata["username"] = ucwords($current_user->first_name . ' ' . $current_user->last_name);
            $this->sidebardata["role_name"] = $this->basic_model->get_user_role($current_user->user_type);
            $this->sidebardata["profile_photo"] = $current_user->profile_image;
            $this->headerdata['page_title'] = "Change Password";
            $this->headerdata['breadcrumbs'] = array(PATIENT_URL, array('dashboard', 'Dashboard'), array('user_change_passord', 'Change Password'));
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
            $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
            $this->templatelayout->get_admin_dashboard_header($this->headerdata);
            $this->templatelayout->get_admin_dashboard_footer();
            $this->templatelayout->get_admin_dashboard_sidebar('superadminsidebar', $this->sidebardata);
            $this->elements['middle'] = 'sadmin/user_change_password';
            $this->elements_data['middle'] = $this->data;
            $this->layout->setLayout('backend_layout/dashboardlayout');
            $this->layout->multiple_view($this->elements, $this->elements_data);
        }
    }

    public function user_save_password() {
        $id = base64_decode($this->input->post('user_id'));
        $password = $this->input->post('new');
        $confirm_password = $this->input->post('new_confirm');
        if (isset($id)) {
            $userinfo = $this->basic_model->get_userinfo($id);
            if (isset($userinfo) && !empty($userinfo)) {
                $identity = $userinfo->user_email;
                if (isset($password) && isset($confirm_password)) {
                    $change = $this->ion_auth->reset_password($identity, $password);
                }
            }
            if (isset($change) && $change) {
                if (empty($userinfo->zoom_user_id) && ($userinfo->user_type == 3 || $userinfo->user_type == 5)) {
                    $this->load->library('zoomapi');
                    $data1 = array(
                        'email' => $userinfo->user_email,
                        'first_name' => $userinfo->first_name,
                        'last_name' => $userinfo->last_name
                    );
                    $response_json = $this->zoomapi->custCreateAUser($data1);
                    $response = json_decode($response_json);
                    if (isset($response->id)) {
                        $zoom = array(
                            'zoom_user_id' => $response->id,
                            'zoom_response' => $response_json
                        );
                        $this->basic_model->set_userzoominfo($id, $zoom);
                    }
                }
                if ($userinfo->activation_code && !empty($userinfo->activation_code)) {
                    if ($userinfo->user_type == 3 || $userinfo->user_type == 5) {
                        $status = 0;
                    } else {
                        $status = 1;
                    }
                    $data = array(
                        'activation_code' => NULL,
                        'user_status' => $status
                    );
                    $this->db->update(USERS, $data, array('user_id' => $id));
                }
                $this->session->set_flashdata('message', "Password has been changed successfully.");

                redirect(SADMIN_URL . 'user_change_password/' . base64_encode($id));
            }
        }
    }

    public function user_detail() {
        $this->load->model('sadmin_model');
        $user_id = base64_decode($this->uri->segment(3));
        $result = $this->sadmin_model->get_user_detail($user_id);
        $data['result'] = $result;
        $data['ethnicity_list'] = array('' => '') + $this->basic_model->get_ethnicitylist();
        $data['timezone_list'] = array('' => '') + $this->basic_model->get_timezonelist();
        $data['states'] = $this->basic_model->get_state_list();
        $this->load->view('sadmin/userDetailModal', $data);
    }

    public function login_logs() {
        $tables = $this->config->item('tables', 'ion_auth');
        $identity_column = $this->config->item('identity', 'ion_auth');
        $this->data['identity_column'] = $identity_column;

        if (!$this->ion_auth->logged_in()) {
            redirect(SITE_URL, 'refresh');
            exit;
        } else {
            $this->data = array();
            $this->sidebardata = array();
            $current_user = $this->ion_auth->user()->row();
            $user_role = $this->uri->segment(3);

            $user_id_en = $this->uri->segment(4);
            $user_id = base64_decode($user_id_en);
            $user = $this->sadmin_model->get_user_detail($user_id);
            if (!$user) {
                redirect(SADMIN_URL . $user_role);
                exit;
            }
            $this->data['user_role'] = $user_role;
            $this->data['user_id'] = $user_id_en;
            $this->load->model('sadmin_model');

            $filter['start_date'] = isset($_POST['start_date']) ? $this->input->post('start_date') : false;
            $filter['end_date'] = isset($_POST['end_date']) ? $this->input->post('end_date') : false;
            $this->data['start_date'] = array(
                'name' => 'start_date',
                'id' => 'start_date',
                'type' => 'text',
                'maxlength' => '32',
                'required' => 'required',
                "class" => "form-control  col-md-7 col-xs-12 noneditable ",
                'placeholder' => "Login date",
                'value' => $filter['start_date']
            );
            $this->data['end_date'] = array(
                'name' => 'end_date',
                'id' => 'end_date',
                'type' => 'text',
                'maxlength' => '32',
                "class" => "form-control  col-md-7 col-xs-12 noneditable ",
                'placeholder' => "Logout date",
                'value' => $filter['end_date']
            );

            $this->data['results'] = $this->sadmin_model->get_login_logs($user_id, $filter);


            //$this->sidebardata["role_name"] = $role_name;
            //$this->sidebardata["profile_photo"] = $current_user->profile_photo;
            $this->sidebardata["username"] = $current_user->first_name . " " . $current_user->last_name;
            $this->sidebardata["role_name"] = $this->basic_model->get_user_role($current_user->user_type);
            $this->sidebardata["profile_photo"] = $current_user->profile_image;
            $this->sidebardata['is_active'] = 'students';


            $this->data['script_to_include'] = "sadmin_js.js";
            $this->headerdata = array();
            $this->headerdata['page_title'] = "'" . ucwords($user->first_name . ' ' . $user->last_name) . "' Logged In/out Logs";
            $this->headerdata['breadcrumbs'] = array(SADMIN_URL, array('dashboard', 'Dashboard'), array($user_role, ucfirst($user_role) . ' list'), array('login_logs', 'Logged in/out logs'));


            $this->templatelayout->get_admin_dashboard_header($this->headerdata);
            $this->templatelayout->get_admin_dashboard_footer();
            $this->templatelayout->get_admin_dashboard_sidebar('superadminsidebar', $this->sidebardata);
            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
            $this->data['error'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('error')));
            $this->elements['middle'] = 'sadmin/login_logs';
            $this->elements_data['middle'] = $this->data;
            $this->layout->setLayout('backend_layout/dashboardlayout');
            $this->layout->multiple_view($this->elements, $this->elements_data);
        }
    }

    function export_users($type = 'student') {
        $results = $this->sadmin_model->get_studentslist();
        if ($results) {
            $this->load->helper('csv');
            $ethnicity_list = array('' => '') + $this->basic_model->get_ethnicitylist();
            $timezone_list = array('' => 'Select Time Zone') + $this->basic_model->get_timezonelist();
            $gender = array('' => '') + $this->config->item('Gender');
            $yesno = array('' => '') + $this->config->item('YesNo');
            $states = $this->basic_model->get_state_list();
            $line = array();
            set_time_limit(0);
            ini_set('max_execution_time', 0);
            ini_set("memory_limit", "2048M");

            $download = time() . 'Export' . ucfirst($type) . '.csv';

            $line[] = 'Name';
            $line[] = 'Email';
            $line[] = 'College Name';
            $line[] = 'Student College ID';
            $line[] = 'Date Of Birth';
            $line[] = 'Mobile Number';
            $line[] = 'Gender';
            $line[] = 'Ethnicity';
            $line[] = 'TimeZone';
            $line[] = 'Campus Address';
            $line[] = 'State';
            $line[] = 'City';
            $line[] = 'Zipcode';
            $line[] = 'International Student';
            $line[] = 'Student Athlete';
            $line[] = 'Class Year';
            $line[] = 'Total Scheduled Sessions';
            $line[] = 'Last Logged in';
            $line[] = 'Registered On';

            $data[] = $line;
            $line = null;

            foreach ($results as $key => $value) {
                $line[] = ucwords($value->first_name . ' ' . $value->last_name);
                $line[] = $value->user_email;
                $line[] = $value->college_name;
                $line[] = $value->patient_identification_number;
                $line[] = show_date($value->dob);
                $line[] = $value->mobile_no;
                $line[] = $gender[$value->gender];
                $line[] = $ethnicity_list[$value->ethnicity];
                $line[] = $timezone_list[$value->timezone_id];
                $line[] = $value->address;
                $line[] = $value->state ? $states[$value->state] : '';
                $line[] = $value->city;
                $line[] = $value->zipcode;
                $line[] = $yesno[$value->is_international];
                $line[] = $yesno[$value->athlete];
                $line[] = $value->class_year;
                $line[] = $value->total_scheduled_session;
                $line[] = show_dateTime($value->user_last_loggedon);
                $line[] = show_date($value->user_createdon);
                $data[] = $line;
                $line = null;
            }

            array_to_csv($data, $download);
            $results = null;
            exit;
        }
    }

}
