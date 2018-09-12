<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->database();
        $this->load->library(array('ion_auth', 'form_validation'));
        $this->load->helper(array('language'));

        $this->lang->load('auth');
        $this->load->helper(array('cookie', 'email'));
        $this->load->library('minify');
        $this->load->library('zoomapi');
        set_smtp_config();
        $this->basic_model->set_current_timezone();
    }

    public function index() {
        if ($this->ion_auth->logged_in()) {
            // redirect them to the login page
            $currentusertype = ($this->ion_auth->user()->row()->user_type);
            if ($currentusertype == 1) {
                redirect(SADMIN_URL . 'dashboard', 'refresh');
            } elseif ($currentusertype == 2) {
                redirect(COLLEGE_URL . 'dashboard', 'refresh');
            } elseif ($currentusertype == 3) {
                redirect(PROVIDER_URL . 'dashboard', 'refresh');
            } elseif ($currentusertype == 4) {
                redirect(PATIENT_URL . 'dashboard', 'refresh');
            } else {
                redirect(THIRD_PARTY_URL . 'dashboard', 'refresh');
            }
            exit;
        } else {
            $this->data = array();
            $this->headerdata = array();

            $this->data['title'] = SITE_NAME . " Login";
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message'); // If Error Returned then display error.

            $this->data['user_identity'] = "Email Address";
            $this->data['identity'] = array('name' => 'identity',
                'id' => 'identity',
                'type' => 'text',
                'class' => 'form-control',
                'value' => $this->form_validation->set_value('identity'),
                'placeholder' => 'Your registered email address with us'
            );
            $this->data['password'] = array('name' => 'password',
                'id' => 'password',
                'type' => 'password',
                'class' => 'form-control',
                'placeholder' => 'Enter Password'
            );
        }

        $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message'); // If Error Returned then display error.
        $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error'); // If Error Returned then display error.
        $this->templatelayout->get_header();
        $this->templatelayout->get_footer();
        $this->data['div_form_id'] = 'login';
        $this->elements['middle'] = 'prelogin/login';
        $this->elements_data['middle'] = $this->data;
        $this->layout->setLayout('layout/layout');
        $this->layout->multiple_view($this->elements, $this->elements_data);
    }

    public function checklogin() {
        //validate form input
        $this->form_validation->set_rules('identity', 'Identity', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == true) {
            $remember = (bool) $this->input->post('remember');
            if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember)) {

                //if the login is successful
                //redirect them back to the home page
                $currentuser = ($this->ion_auth->user()->row()->id);
                $currentusertype = ($this->ion_auth->user()->row()->user_type);
                /// start :: save login details
                if ($currentusertype != 1) {
                    $data['user_id'] = $currentuser;
                    $data['loggedin_on'] = $this->basic_model->set_utc_datetime(date('Y-m-d H:i:s'));
                    $this->db->insert(LOGIN_LOG, $data);
                }
                /// end :: save login details
                $this->session->set_flashdata('message', $this->ion_auth->messages());
                if ($currentusertype == 1) {
                    redirect(SADMIN_URL . 'dashboard', 'refresh');
                } elseif ($currentusertype == 2) {
                    redirect(COLLEGE_URL . 'dashboard', 'refresh');
                } elseif ($currentusertype == 3) {
                    redirect(PROVIDER_URL . 'dashboard', 'refresh');
                } elseif ($currentusertype == 4) {
                    redirect(PATIENT_URL . 'dashboard', 'refresh');
                } else {
                    redirect(THIRD_PARTY_URL . 'dashboard', 'refresh');
                }
            } else {
                // if the login was un-successful
                // redirect them back to the login page
                $this->session->set_flashdata('error', (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('error'))));


                redirect(SITE_URL . "login"); // use redirects instead of loading views for compatibility with MY_Controller libraries
            }
        }
    }

    public function signup() {
        $this->load->model("college_model");

        if ($this->ion_auth->logged_in()) {
            $currentusertype = ($this->ion_auth->user()->row()->user_type);
            if ($currentusertype == 1) {
                redirect(SADMIN_URL . 'dashboard', 'refresh');
            } elseif ($currentusertype == 2) {
                redirect(COLLEGE_URL . 'dashboard', 'refresh');
            } elseif ($currentusertype == 3) {
                redirect(PROVIDER_URL . 'dashboard', 'refresh');
            } elseif ($currentusertype == 4) {
                redirect(PATIENT_URL . 'dashboard', 'refresh');
            } else {
                redirect(THIRD_PARTY_URL . 'dashboard', 'refresh');
            }
            exit;
        }

        $this->data = array();
        $this->headerdata = array();
        $postdata = isset($_SESSION['postdata']) ? $_SESSION['postdata'] : '';
        $this->data['postdata'] = $postdata;

        $this->data['title'] = "Register New Company";

        $tables = $this->config->item('tables', 'ion_auth');
        $identity_column = $this->config->item('identity', 'ion_auth');
        $this->data['identity_column'] = $identity_column;
        // display the create user form
        // set the flash data error message if there is one
        $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
        $this->data['error'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('error')));

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

        $this->data['email'] = array(
            'name' => 'email',
            'id' => 'email',
            "class" => "form-control",
            'type' => 'text',
            'maxlength' => '100',
            'placeholder' => "e.g. you@widgetcorp.com",
            'value' => isset($postdata) && !empty($postdata) && isset($postdata['email']) ? $postdata['email'] : ''
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
        $this->data['patient_identification_number'] = array(
            'name' => 'patient_identification_number',
            'id' => 'patient_identification_number',
            'type' => 'text',
            'maxlength' => '32',
            "class" => "form-control  col-md-7 col-xs-12",
            'placeholder' => "Identification Number",
            'value' => isset($postdata) && !empty($postdata) && isset($postdata['patient_identification_number']) ? $postdata['patient_identification_number'] : ''
        );

        $this->data['dob'] = array(
            'name' => 'dob',
            'id' => 'dob',
            'type' => 'text',
            'maxlength' => '32',
            "class" => "form-control  col-md-7 col-xs-12 dob noneditable",
            'placeholder' => "Date Of Birth",
            'value' => isset($postdata) && !empty($postdata) && isset($postdata['dob']) ? $postdata['dob'] : ''
        );

        /* $this->data['mobile_no'] = array(
          'name' => 'mobile_no',
          'id' => 'mobile_no',
          'type' => 'text',
          'maxlength' => '15',
          "class" => "form-control  col-md-7 col-xs-12 mobilemark",
          'placeholder' => "___-___-____",
          'value' => isset($postdata) && !empty($postdata) && isset($postdata['mobile_no']) ? $postdata['mobile_no'] : ''
          ); */
        $this->data['terms_checked'] = array(
            'name' => 'terms_checked',
            'id' => 'terms_checked',
            'type' => 'checkbox',
            "class" => "flat required",
            'value' => 1
        );

        $this->load->model("basic_model");
        $terms_conditions = $this->basic_model->get_cms_pages_by_slug('terms_and_conditions_patient');
        $this->data['terms_conditions'] = $terms_conditions;
        if (isset($page_templates) && !empty($page_templates) && count($page_templates)) {
            $this->data['page_templates'] = $page_templates;
        }
        unset($_SESSION['postdata']);
        $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message'); // If Error Returned then display error.
        $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error'); // If Error Returned then display error.
        $this->data['college'] = $this->college_model->getCollege();
        $this->data['script_to_include'] = "college_js.js";
        $this->templatelayout->get_header();
        $this->templatelayout->get_footer();
        $this->elements['middle'] = 'prelogin/signup';
        $this->elements_data['middle'] = $this->data;
        $this->layout->setLayout('layout/layout');
        $this->layout->multiple_view($this->elements, $this->elements_data);
    }

    public function create_user() {

        // Configuration options
        $tables = $this->config->item('tables', 'ion_auth');
        $identity_column = $this->config->item('identity', 'ion_auth');
        $this->data['identity_column'] = $identity_column;

        unset($_SESSION['postdata']);

        $this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'required|valid_email|is_unique[' . $tables['users'] . '.' . $identity_column . ']');
        $this->form_validation->set_rules('first_name', $this->lang->line('create_user_validation_fname_label'), 'required');
        $this->form_validation->set_rules('last_name', $this->lang->line('create_user_validation_lname_label'), 'required');
        $this->form_validation->set_rules('dob', $this->lang->line('create_user_validation_dob_label'), 'required');
        //$this->form_validation->set_rules('mobile_no', $this->lang->line('create_user_validation_mobile_no_label'), 'required');

        if ($this->form_validation->run() == true) {
            // check to see if we are creating the user
            // redirect them back to the admin page
            $this->load->model("basic_model");

            $additional_data = array();

            $post_arr = $this->input->post();
            $post_arr = $this->basic_model->stripTagsPostArray($post_arr);

            $email = strtolower($post_arr['email']);
            $identity = $email;
            $password = '';

            if (isset($post_arr['dob']) && !empty($post_arr['dob'])) {
                $dob_date = $this->basic_model->convertDate($post_arr['dob']);
            }
            $additional_data['first_name'] = $post_arr['first_name'];
            $additional_data['last_name'] = $post_arr['last_name'];
            $additional_data['college_id'] = $post_arr['college_id'];
            $additional_data['dob'] = $dob_date;
            //$additional_data['mobile_no'] = $post_arr['mobile_no'];
            $additional_data['user_type'] = $post_arr['user_type'];
            if ($last_id = $this->ion_auth->register($identity, $password, $email, $additional_data)) {
                $data_1 = array();
                $this->session->set_flashdata('message', $this->ion_auth->messages());
                redirect(SITE_URL . "login");
            }
        } else {
            $_SESSION['postdata'] = $_POST;
            $this->session->set_flashdata('error', (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message'))));
            redirect(SITE_URL . "signup/patient");
        }
    }

    public function forgot_password() {
        // Function for forgot password
        if ($this->ion_auth->logged_in()) {
            $currentusertype = ($this->ion_auth->user()->row()->user_type);
            if ($currentusertype == 1) {
                redirect(SADMIN_URL . 'dashboard', 'refresh');
            } elseif ($currentusertype == 2) {
                redirect(COLLEGE_URL . 'dashboard', 'refresh');
            } elseif ($currentusertype == 3) {
                redirect(PROVIDER_URL . 'dashboard', 'refresh');
            } elseif ($currentusertype == 4) {
                redirect(PATIENT_URL . 'dashboard', 'refresh');
            } else {
                redirect(THIRD_PARTY_URL . 'dashboard', 'refresh');
            }
            exit;
        }

        $this->data = array();
        $this->headerdata = array();
        $this->data['title'] = "Forgot Password";
        $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message'); // If Error Returned then display error.

        $this->data['type'] = $this->config->item('identity', 'ion_auth');
        // setup the input
        $this->data['identity'] = array('name' => 'identity',
            'id' => 'identity',
            'class' => 'form-control',
            'placeholder' => "e.g. you@widgetcorp.com"
        );
        if ($this->config->item('identity', 'ion_auth') != 'email') {
            $this->data['identity_label'] = $this->lang->line('forgot_password_identity_label');
        } else {
            $this->data['identity_label'] = $this->lang->line('forgot_password_email_identity_label');
        }
        // set any errors and display the form
        $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
        $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
        $this->data['title'] = "Forgot Password";
        $this->templatelayout->get_header($this->headerdata);
        $this->templatelayout->get_footer();
        $this->data['div_form_id'] = 'login';
        $this->elements['middle'] = 'prelogin/forgot_password';
        $this->elements_data['middle'] = $this->data;
        $this->layout->setLayout('layout/layout');
        $this->layout->multiple_view($this->elements, $this->elements_data);
        //$this->_render_page('member/forgot_password', $this->data);
    }

    public function provider_signup() {
        $this->load->model("college_model");

        if ($this->ion_auth->logged_in()) {
            $currentusertype = ($this->ion_auth->user()->row()->user_type);
            if ($currentusertype == 1) {
                redirect(SADMIN_URL . 'dashboard', 'refresh');
            } elseif ($currentusertype == 2) {
                redirect(COLLEGE_URL . 'dashboard', 'refresh');
            } elseif ($currentusertype == 3) {
                redirect(PROVIDER_URL . 'dashboard', 'refresh');
            } elseif ($currentusertype == 4) {
                redirect(PATIENT_URL . 'dashboard', 'refresh');
            } else {
                redirect(THIRD_PARTY_URL . 'dashboard', 'refresh');
            }
            exit;
        }

        $this->data = array();
        $this->headerdata = array();
        $postdata = isset($_SESSION['postdata']) ? $_SESSION['postdata'] : '';
        $this->data['postdata'] = $postdata;
        $this->data['title'] = "Register New Provider";

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
            'placeholder' => "Provider First Name",
            'value' => isset($postdata) && !empty($postdata) && isset($postdata['first_name']) ? $postdata['first_name'] : ''
        );
        $this->data['last_name'] = array(
            'name' => 'last_name',
            'id' => 'last_name',
            'type' => 'text',
            'maxlength' => '32',
            "class" => "form-control  col-md-7 col-xs-12",
            'placeholder' => "Provider Last Name",
            'value' => isset($postdata) && !empty($postdata) && isset($postdata['last_name']) ? $postdata['last_name'] : ''
        );
        $this->data['mobile_no'] = array(
            'name' => 'mobile_no',
            'id' => 'mobile_no',
            'type' => 'text',
            'maxlength' => '15',
            "class" => "form-control  col-md-7 col-xs-12 mobilemark",
            'placeholder' => "___-___-____",
            'value' => isset($postdata) && !empty($postdata) && isset($postdata['mobile_no']) ? $postdata['mobile_no'] : ''
        );
        $this->data['terms_checked'] = array(
            'name' => 'terms_checked',
            'id' => 'terms_checked',
            'type' => 'checkbox',
            "class" => "flat required",
            'value' => 1
        );

        $this->load->model("basic_model");
        $terms_conditions = $this->basic_model->get_cms_pages_by_slug('terms_and_conditions_provider');
        $this->data['terms_conditions'] = $terms_conditions;
        if (isset($page_templates) && !empty($page_templates) && count($page_templates)) {
            $this->data['page_templates'] = $page_templates;
        }

        $this->data['college'] = array('' => 'Select College') + $this->college_model->getCollege();
        unset($_SESSION['postdata']);
        $this->templatelayout->get_header();
        $this->templatelayout->get_footer();
        $this->elements['middle'] = 'prelogin/provider_signup';
        $this->elements_data['middle'] = $this->data;
        $this->layout->setLayout('layout/layout');
        $this->layout->multiple_view($this->elements, $this->elements_data);
    }

    public function create_provider_user() {
        // Configuration options
        $tables = $this->config->item('tables', 'ion_auth');
        $identity_column = $this->config->item('identity', 'ion_auth');
        $this->data['identity_column'] = $identity_column;

        unset($_SESSION['postdata']);
        $this->form_validation->set_rules('user_email', $this->lang->line('create_user_validation_email_label'), 'required|valid_email|is_unique[' . $tables['users'] . '.' . $identity_column . ']');
        $this->form_validation->set_rules('first_name', $this->lang->line('create_user_validation_fname_label'), 'required');
        $this->form_validation->set_rules('last_name', $this->lang->line('create_user_validation_lname_label'), 'required');
        $this->form_validation->set_rules('mobile_no', $this->lang->line('create_user_validation_mobile_no_label'), 'required');

        if ($this->form_validation->run() == true) {
            // check to see if we are creating the user
            // redirect them back to the admin page
            $this->load->model("basic_model");

            $additional_data = array();

            $post_arr = $this->input->post();
            $post_arr = $this->basic_model->stripTagsPostArray($post_arr);
            $email = strtolower($post_arr['user_email']);
            $identity = $email;
            $password = "";

            $additional_data['first_name'] = $post_arr['first_name'];
            $additional_data['last_name'] = $post_arr['last_name'];
            $additional_data['college_id'] = $post_arr['college_id'];
            $additional_data['mobile_no'] = $post_arr['mobile_no'];
            $additional_data['user_type'] = $post_arr['user_type'];
            if ($last_id = $this->ion_auth->register($identity, $password, $email, $additional_data)) {
                if (isset($_FILES['profile_image']) && $_FILES['profile_image']['size'] > 0) {
                    $profileimage = $_FILES['profile_image'];
                    $extenstion = $this->basic_model->get_extension($profileimage['name']);

                    if ($extenstion != "error") {
                        $filename = $last_id . "." . $extenstion;
                        $config['upload_path'] = PROFILE_FILE_UPLOAD_PATH;
                        $config['allowed_types'] = 'jpg|png|jpeg|gif';
                        $config['max_size'] = 1024 * 2;
                        $config['file_name'] = $filename;
                        if (file_exists($config['upload_path'] . "/$filename")) {
                            unlink($config['upload_path'] . "/$filename");
                        }
                        $this->load->library('upload', $config);
                        $this->upload->initialize($config);
                        if ($this->upload->do_upload("profile_image")) {
                            $data_image = $this->upload->data();
                            $this->db->update(USERS, array('profile_image' => $data_image['file_name']), array('user_id' => $last_id));
                            $additional_data['profile_image'] = $data_image['file_name'];
                        }
                    }
                }
                $data_1 = array();
                $this->session->set_flashdata('message', $this->ion_auth->messages());
                redirect(SITE_URL . "login");
            }
        } else {
            $_SESSION['postdata'] = $_POST;
            $this->session->set_flashdata('error', (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message'))));
            redirect(SITE_URL . "signup/provider");
        }
    }

    public function activate() {
        $code = $this->uri->segment(3, 0);
        $id = $this->uri->segment(2, 0);
        $this->headerdata = array();
        $this->data = array();

        $user = $this->db->select('user_pswd')->where('user_id', $id)->get(USERS)->row();
        if (isset($user) && $user->user_pswd == '0') {
            if (isset($code) && isset($id)) {

                $this->data['new_password'] = array(
                    'name' => 'new',
                    'id' => 'new',
                    'type' => 'password',
                    "class" => "form-control",
                    'autofocus' => 'true',
                    'placeholder' => 'Enter password'
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
                $this->data['code'] = array(
                    'name' => 'code',
                    'id' => 'code',
                    'type' => 'hidden',
                    "class" => "form-control",
                    "value" => $code
                        //'pattern' => '^.{'.$this->data['min_password_length'].'}.*$',
                );
                $this->data['uuid'] = array(
                    'name' => 'uuid',
                    'id' => 'uuid',
                    'type' => 'hidden',
                    "class" => "form-control",
                    "value" => $id
                        //'pattern' => '^.{'.$this->data['min_password_length'].'}.*$',
                );
                $this->elements['middle'] = 'prelogin/reset_password';
                $this->templatelayout->get_header($this->headerdata);
                $this->templatelayout->get_footer();
                $this->elements_data['middle'] = $this->data;
                $this->layout->setLayout('layout/layout');
                $this->layout->multiple_view($this->elements, $this->elements_data);
            }
        } else {
            $this->session->set_flashdata('error', "<p class='alert alert-danger text-left'>This link is already expired. If you forgot your password then <a href='" . SITE_URL . "forgot_password'>click here</a> to reset again.</p>");
            redirect(SITE_URL . 'login');
        }
    }

    // Logout function
    public function checkout() {
        if ($this->ion_auth->user()) {
            $currentuser = ($this->ion_auth->user()->row()->id);
            $currentusertype = ($this->ion_auth->user()->row()->user_type);
            /// start :: save logout details
            if ($currentusertype != 1) {
                $last_entry = $this->db->select('id')->from(LOGIN_LOG)->where('user_id', $currentuser)->order_by('loggedin_on', 'DESC')->get()->row();
                $data['user_id'] = $currentuser;
                $data['loggedout_on'] = $this->basic_model->set_utc_datetime(date('Y-m-d H:i:s'));
                $this->db->update(LOGIN_LOG, $data, array("id" => $last_entry->id));
            }
        }
        $logout = $this->ion_auth->logout();
        // redirect them to the logout page
        $this->session->set_flashdata('message', $this->ion_auth->messages());
        redirect(WP_SITE_URL, 'refresh');
    }

    public function third_party_signup() {
        $this->load->model("college_model");
        if ($this->ion_auth->logged_in()) {
            $currentusertype = ($this->ion_auth->user()->row()->user_type);
            if ($currentusertype == 1) {
                redirect(SADMIN_URL . 'dashboard', 'refresh');
            } elseif ($currentusertype == 2) {
                redirect(COLLEGE_URL . 'dashboard', 'refresh');
            } elseif ($currentusertype == 3) {
                redirect(PROVIDER_URL . 'dashboard', 'refresh');
            } elseif ($currentusertype == 4) {
                redirect(PATIENT_URL . 'dashboard', 'refresh');
            } else {
                redirect(THIRD_PARTY_URL . 'dashboard', 'refresh');
            }
            exit;
        }
        $this->data = array();
        $this->headerdata = array();
        $postdata = isset($_SESSION['postdata']) ? $_SESSION['postdata'] : '';
        $this->data['postdata'] = $postdata;

        $this->data['title'] = "Register New Provider";

        $tables = $this->config->item('tables', 'ion_auth');
        $identity_column = $this->config->item('identity', 'ion_auth');
        $this->data['identity_column'] = $identity_column;
        // display the create user form
        // set the flash data error message if there is one
        $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
        $this->data['error'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('error')));
        $this->data['state'] = $this->basic_model->get_state_list();
        $this->data['user_type'] = array(
            'name' => 'user_type',
            'id' => 'user_type',
            "class" => "form-control ",
            'type' => 'text',
            'maxlength' => '5',
            'value' => '5',
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
        $this->data['address'] = array(
            'name' => 'address',
            'id' => 'address',
            'type' => 'text',
            'maxlength' => '150',
            "class" => "form-control  col-md-7 col-xs-12",
            'placeholder' => "Enter Address",
            'value' => isset($postdata) && !empty($postdata) && isset($postdata['address']) ? $postdata['address'] : ''
        );
        $this->data['city'] = array(
            'name' => 'city',
            'id' => 'city',
            'type' => 'text',
            'maxlength' => '32',
            "class" => "form-control  col-md-7 col-xs-12",
            'placeholder' => "Enter City",
            'value' => isset($postdata) && !empty($postdata) && isset($postdata['city']) ? $postdata['city'] : ''
        );
        $this->data['zipcode'] = array(
            'name' => 'zipcode',
            'id' => 'zipcode',
            'type' => 'text',
            'maxlength' => '10',
            "class" => "form-control  col-md-7 col-xs-12",
            'placeholder' => "Enter Zipcode",
            'value' => isset($postdata) && !empty($postdata) && isset($postdata['zipcode']) ? $postdata['zipcode'] : ''
        );

        $this->data['mobile_no'] = array(
            'name' => 'mobile_no',
            'id' => 'mobile_no',
            'type' => 'text',
            'maxlength' => '15',
            "class" => "form-control  col-md-7 col-xs-12 mobilemark",
            'placeholder' => "___-___-____",
            'value' => isset($postdata) && !empty($postdata) && isset($postdata['mobile_no']) ? $postdata['mobile_no'] : ''
        );

        $this->data['terms_checked'] = array(
            'name' => 'terms_checked',
            'id' => 'terms_checked',
            'type' => 'checkbox',
            "class" => "flat required",
            'value' => 1
        );
        $this->load->model("basic_model");
        $terms_conditions = $this->basic_model->get_cms_pages_by_slug('terms_and_conditions_third_party');
        $this->data['terms_conditions'] = $terms_conditions;
        if (isset($page_templates) && !empty($page_templates) && count($page_templates)) {
            $this->data['page_templates'] = $page_templates;
        }
        unset($_SESSION['postdata']);
        $this->templatelayout->get_header();
        $this->templatelayout->get_footer();
        $this->elements['middle'] = 'prelogin/third_party_signup';
        $this->elements_data['middle'] = $this->data;
        $this->layout->setLayout('layout/layout');
        $this->layout->multiple_view($this->elements, $this->elements_data);
    }

    public function create_third_party_user() {
        // Configuration options
        $tables = $this->config->item('tables', 'ion_auth');
        $identity_column = $this->config->item('identity', 'ion_auth');
        $this->data['identity_column'] = $identity_column;

        unset($_SESSION['postdata']);
        $this->form_validation->set_rules('first_name', $this->lang->line('create_user_validation_fname_label'), 'required');
        $this->form_validation->set_rules('last_name', $this->lang->line('create_user_validation_lname_label'), 'required');
        $this->form_validation->set_rules('user_email', $this->lang->line('create_user_validation_email_label'), 'required|valid_email|is_unique[' . $tables['users'] . '.' . $identity_column . ']');
        $this->form_validation->set_rules('mobile_no', $this->lang->line('create_user_validation_office_label'), 'required');
        $this->form_validation->set_rules('city', $this->lang->line('create_user_validation_city_label'), 'required');
        $this->form_validation->set_rules('state', $this->lang->line('create_user_validation_state_label'), 'required');
        $this->form_validation->set_rules('zipcode', $this->lang->line('create_user_validation_zipcode_label'), 'required');
        $this->form_validation->set_rules('address', $this->lang->line('create_user_validation_address_label'), 'required');

        if ($this->form_validation->run() == true) {
            // check to see if we are creating the user
            // redirect them back to the admin page
            $this->load->model("basic_model");

            $additional_data = array();

            $post_arr = $this->input->post();
            $post_arr = $this->basic_model->stripTagsPostArray($post_arr);
            $email = strtolower($post_arr['user_email']);
            $identity = $email;
            $password = "";
            $additional_data['first_name'] = $post_arr['first_name'];
            $additional_data['last_name'] = $post_arr['last_name'];
            $additional_data['mobile_no'] = $post_arr['mobile_no'];
            $additional_data['user_type'] = $post_arr['user_type'];
            $additional_data['city'] = $post_arr['city'];
            $additional_data['state'] = $post_arr['state'];
            $additional_data['zipcode'] = $post_arr['zipcode'];
            $additional_data['address'] = $post_arr['address'];

            if ($last_id = $this->ion_auth->register($identity, $password, $email, $additional_data)) {
                if (isset($_FILES['profile_image']) && $_FILES['profile_image']['size'] > 0) {
                    $profileimage = $_FILES['profile_image'];
                    $extenstion = $this->basic_model->get_extension($profileimage['name']);

                    if ($extenstion != "error") {
                        $filename = $last_id . "." . $extenstion;
                        $config['upload_path'] = PROFILE_FILE_UPLOAD_PATH;
                        $config['allowed_types'] = 'jpg|png|jpeg|gif';
                        $config['max_size'] = 1024 * 2;
                        $config['file_name'] = $filename;
                        if (file_exists($config['upload_path'] . "/$filename")) {
                            unlink($config['upload_path'] . "/$filename");
                        }
                        $this->load->library('upload', $config);
                        $this->upload->initialize($config);
                        if ($this->upload->do_upload("profile_image")) {
                            $data_image = $this->upload->data();
                            $this->db->update(USERS, array('profile_image' => $data_image['file_name']), array('user_id' => $last_id));
                            $additional_data['profile_image'] = $data_image['file_name'];
                        }
                    }
                }
                $data_1 = array();
                $this->session->set_flashdata('message', $this->ion_auth->messages());
                redirect(SITE_URL . "login");
            }
        } else {
            $_SESSION['postdata'] = $_POST;
            $this->session->set_flashdata('error', (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message'))));
            redirect(SITE_URL . "signup/third_party");
        }
    }

    public function college_signup() {
        $this->load->model("college_model");
        if ($this->ion_auth->logged_in()) {
            $currentusertype = ($this->ion_auth->user()->row()->user_type);
            if ($currentusertype == 1) {
                redirect(SADMIN_URL . 'dashboard', 'refresh');
            } elseif ($currentusertype == 2) {
                redirect(COLLEGE_URL . 'dashboard', 'refresh');
            } elseif ($currentusertype == 3) {
                redirect(PROVIDER_URL . 'dashboard', 'refresh');
            } elseif ($currentusertype == 4) {
                redirect(PATIENT_URL . 'dashboard', 'refresh');
            } else {
                redirect(THIRD_PARTY_URL . 'dashboard', 'refresh');
            }
            exit;
        }

        $this->data = array();
        $this->headerdata = array();
        $postdata = isset($_SESSION['postdata']) ? $_SESSION['postdata'] : '';
        $this->data['postdata'] = $postdata;
        $this->data['title'] = "Register New College";

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
            'maxlength' => '150',
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
            'maxlength' => '10',
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

        $this->data['terms_checked'] = array(
            'name' => 'terms_checked',
            'id' => 'terms_checked',
            'type' => 'checkbox',
            "class" => "flat required",
            'value' => 1
        );

        $states = $this->basic_model->get_state_list();
        $this->data['states'] = $states;

        $terms_conditions = $this->basic_model->get_cms_pages_by_slug('terms_and_conditions_college');
        $this->data['terms_conditions'] = $terms_conditions;
        if (isset($page_templates) && !empty($page_templates) && count($page_templates)) {
            $this->data['page_templates'] = $page_templates;
        }
        unset($_SESSION['postdata']);
        $this->templatelayout->get_header();
        $this->templatelayout->get_footer();
        $this->elements['middle'] = 'prelogin/college_signup';
        $this->elements_data['middle'] = $this->data;
        $this->layout->setLayout('layout/layout');
        $this->layout->multiple_view($this->elements, $this->elements_data);
    }

    public function create_college_user() {
        // Configuration options
        $tables = $this->config->item('tables', 'ion_auth');
        $identity_column = $this->config->item('identity', 'ion_auth');
        $this->data['identity_column'] = $identity_column;

        unset($_SESSION['postdata']);
        $this->form_validation->set_rules('user_email', $this->lang->line('create_user_validation_email_label'), 'required|valid_email|is_unique[' . $tables['users'] . '.' . $identity_column . ']');
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

            $this->load->model("sadmin_model");
            $additional_data = array();
            $college_data = array();

            $post_arr = $this->input->post();
            $post_arr = $this->basic_model->stripTagsPostArray($post_arr);
            $email = strtolower($post_arr['user_email']);
            $identity = $email;
            $password = "";

            $additional_data['first_name'] = $post_arr['first_name'];
            $additional_data['last_name'] = $post_arr['last_name'];
            $additional_data['user_type'] = 2;

            $college_data['college_name'] = $post_arr['college_name'];
            $college_data['college_address'] = $post_arr['college_address'];
            $college_data['college_state'] = $post_arr['college_state'];
            $college_data['college_city'] = $post_arr['college_city'];
            $college_data['college_zipcode'] = $post_arr['college_zipcode'];
            $college_data['college_office_no'] = $post_arr['college_office_no'];

            $college_id = $this->sadmin_model->add_college($college_data);
            $additional_data['college_id'] = $college_id;

            if ($last_id = $this->ion_auth->register($identity, $password, $email, $additional_data)) {

                $college_data['uid'] = $last_id;
                $this->sadmin_model->update_college_college($college_id, $college_data);

                $data_1 = array();
                $this->session->set_flashdata('message', $this->ion_auth->messages());
                redirect(SITE_URL . "login");
            }
        } else {
            $_SESSION['postdata'] = $_POST;
            $this->session->set_flashdata('error', (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message'))));
            redirect(SITE_URL . "signup/college");
        }
    }

    public function update_password() { ////34e56a304f4d2967145a32c1ed0b1579a334c31d
        $id = $this->input->post('uuid');
        $code = $this->input->post('code');
        $password = $this->input->post('new');
        $confirm_password = $this->input->post('new_confirm');
        if (isset($code) && isset($id)) {
            $userinfo = $this->basic_model->get_userinfo($id);
            if (isset($userinfo) && !empty($userinfo)) {
                $identity = $userinfo->user_email;

                if (isset($password) && isset($confirm_password)) {
                    $change = $this->ion_auth->reset_password($identity, $password);
                }
                if ($userinfo->user_type == 3 || $userinfo->user_type == 5) {
                    $activation = $this->ion_auth->activate($id, $code);
                } else {
                    $activation = $this->ion_auth->activate($id);
                }
            }
            if (isset($change) && $change) {
                if ($userinfo->user_type == 3 || $userinfo->user_type == 5) {
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

                $message_content = $this->basic_model->get_mail_template('welcome_mail');
                $mail_content = html_entity_decode($message_content->mail_template_content);
                $message = str_replace("{{identity}}", $userinfo->first_name . " " . $userinfo->last_name, $mail_content);
                $message = str_replace("{{siteurl}}", SITE_URL, $message);
                $message = MAIL_HEADER . $message . MAIL_FOOTER;

                $this->email->clear();
                $this->email->from($this->config->item('admin_email', 'ion_auth'), $this->config->item('site_title', 'ion_auth'));
                $this->email->to($userinfo->user_email);
                $this->email->subject($message_content->mail_subject);
                $this->email->message($message);
                $this->email->send();

                if ($userinfo->user_type != 3 && $userinfo->user_type != 5) {
                    $this->session->set_flashdata('message', "Thank you for registering for BetterMynd. Please login to complete your profile.");
                } else {
                    /* $message_content = $this->basic_model->get_mail_template('new_provider_joined');

                      $message = $message_content->mail_template_content;

                      $college_admin_info = $this->basic_model->get_college_admin_info($userinfo->college_id);
                      if (isset($college_admin_info) && !empty($college_admin_info)) {
                      $college_email = $college_admin_info['user_email'];
                      if (isset($college_email) && !empty($college_email)) {
                      $message = str_replace("{{identity}}", $college_admin_info['first_name'] . " " . $college_admin_info['last_name'], $message);
                      $message = str_replace("{{college}}", $college_admin_info['college_name'], $message);
                      $message = str_replace("{{username}}", $userinfo->first_name . " " . $userinfo->last_name, $message);
                      $message = str_replace("{{siteurl}}", SITE_URL, $message);
                      $message = MAIL_HEADER . $message . MAIL_FOOTER;
                      $this->email->clear();
                      $this->email->from($this->config->item('admin_email', 'ion_auth'), $this->config->item('site_title', 'ion_auth'));
                      $this->email->to($college_email);
                      $this->email->subject($message_content->mail_subject);
                      $this->email->message($message);
                      $this->email->send();
                      }
                      }
                      if ($userinfo->user_type == 3) {
                      $this->session->set_flashdata('message', "Thanks for activating your account.<br/>You can login now.");
                      } else {
                      $this->session->set_flashdata('error', "Your account not activate yet, please contact with college administrator.");
                      } */
                    $this->session->set_flashdata('message', "Please login to your account and complete your profile.");
                }
                redirect(SITE_URL . 'login', 'refresh');
            }
        }
        //$activation = $this->ion_auth->activate($id, $code);
    }

    public function change_password() {
        $identity_value = $this->input->post('identity');
        if (isset($identity_value) && !empty($identity_value)) {
            $identity = $this->ion_auth->where('user_email', $identity_value)->users()->row();
            if (empty($identity)) {
                $this->session->set_flashdata('error', '<p class="alert alert-danger text-left">This email address isn\'t registered on ' . SITE_NAME . '. Please enter a correct email address or <a href="' . SITE_URL . 'signup">register</a> to continue.</a>');
                redirect(SITE_URL . 'forgot_password');
            } else {
                $this->form_validation->set_rules('identity', $this->lang->line('forgot_password_validation_email_label'), 'required|valid_email');
                if ($this->form_validation->run() == false) {
                    $this->session->set_flashdata('error', validation_errors());
                    redirect(SITE_URL . 'forgot_password');
                } else {

                    $forgotten = $this->ion_auth->forgotten_password($identity->user_email);
                    if ($forgotten) {
                        $this->session->set_flashdata('message', "We have sent an email to your email address. Follow the instructions in email to reset your password.");
                        redirect(SITE_URL . "login");
                    } else {
                        $this->session->set_flashdata('error', $this->ion_auth->errors());
                        redirect(SITE_URL . "forgot_password");
                    }
                }
            }
        }
    }

    public function reset_password() {

        $this->data = array();
        $this->headerdata = array();
        $code = $this->uri->segment(2, 0);
        $user = $this->ion_auth->forgotten_password_check($code);
        if (isset($user) && !empty($user)) {
            $this->data['type'] = $this->config->item('identity', 'ion_auth');
            // setup the input
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
            $this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
            $this->data['new_password'] = array(
                'name' => 'new',
                'id' => 'new',
                'type' => 'password',
                "class" => "form-control",
                "placeholder" => "Enter password"
                    //'pattern' => '^.{'.$this->data['min_password_length'].'}.*$',
            );
            $this->data['new_password_confirm'] = array(
                'name' => 'new_confirm',
                'id' => 'new_confirm',
                'type' => 'password',
                "class" => "form-control",
                "placeholder" => "Enter confirm password"
                    //'pattern' => '^.{'.$this->data['min_password_length'].'}.*$',
            );
            $this->data['user_id'] = array(
                'name' => 'user_id',
                'id' => 'user_id',
                'type' => 'hidden',
                'value' => $user->id,
            );
            $this->data['csrf'] = $this->_get_csrf_nonce();
            $this->data['code'] = $code;

            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
            $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
            $this->data['title'] = "Forgot Password";
            $this->templatelayout->get_header($this->headerdata);
            $this->templatelayout->get_footer();
            $this->data['div_form_id'] = 'login';
            $this->elements['middle'] = 'prelogin/reset_password_forgot';
            $this->elements_data['middle'] = $this->data;
            $this->layout->setLayout('layout/layout');
            $this->layout->multiple_view($this->elements, $this->elements_data);
        } else {
            $this->session->set_flashdata('message', '<p class="alert alert-danger text-left">Authorization code for reset password is expired.</p>');
            redirect(SITE_URL . "login");
        }
    }

    public function update_password_forgot() {

        $this->data = array();
        $this->headerdata = array();
        $code = $this->uri->segment(2, 0);
        $user = $this->ion_auth->forgotten_password_check($code);

        if ($user) {
            $this->form_validation->set_rules('new', $this->lang->line('reset_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
            $this->form_validation->set_rules('new_confirm', $this->lang->line('reset_password_validation_new_password_confirm_label'), 'required');
            if ($this->form_validation->run() == false) {
                $this->session->set_flashdata('error', validation_errors());

                redirect(SITE_URL . "reset_password." . $user->user_id . "/" . $code);
            } else {
                if ($this->_valid_csrf_nonce() === FALSE || $user->id != $this->input->post('user_id')) {
                    $this->ion_auth->clear_forgotten_password_code($code);
                    $this->session->set_flashdata('error', $this->lang->line('error_csrf'));

                    redirect(SITE_URL);
                } else {
                    $identity = $user->{$this->config->item('identity', 'ion_auth')};
                    $change = $this->ion_auth->reset_password($identity, $this->input->post('new'));
                    if ($change) {
                        // if the password was successfully changed

                        $this->session->set_flashdata('message', $this->ion_auth->messages());
                        redirect(SITE_URL . 'login', 'refresh');
                    } else {
                        $this->session->set_flashdata('error', $this->ion_auth->errors());
                        redirect(SITE_URL . 'reset_password/' . $code, 'refresh');
                    }
                }
            }
        } else {
            $this->session->set_flashdata('error', "Invalid Authentication Code.");
            redirect(SITE_URL);
        }
    }

    // Password change helping functions
    function _get_csrf_nonce() {
        $this->load->helper('string');
        $key = random_string('alnum', 8);
        $value = random_string('alnum', 20);
        $this->session->set_flashdata('csrfkey', $key);
        $this->session->set_flashdata('csrfvalue', $value);
        return array($key => $value);
    }

    function _valid_csrf_nonce() {
        if ($this->input->post($this->session->flashdata('csrfkey')) !== FALSE &&
                $this->input->post($this->session->flashdata('csrfkey')) == $this->session->flashdata('csrfvalue')) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    // Password change helping functions Ends
    // 404 Not Found page
    public function notfound() {
        $this->load->view('prelogin/error_404');
    }

    public function nojs() {
        $this->load->view('prelogin/nojs');
    }

    public function current_time() {
        prd(date_default_timezone_get());
        prd(date('m-d-Y H:i:s'), 1);
    }

}
