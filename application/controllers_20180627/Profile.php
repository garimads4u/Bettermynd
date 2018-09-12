<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library(array('ion_auth', 'form_validation'));
        $this->load->helper(array('url', 'language', 'email'));
        set_smtp_config();

        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
        $this->lang->load('auth');
        $uri_segment = $this->uri->segment(2, 0);
        $this->load->model('basic_model');
        $this->basic_model->set_current_timezone();
    }

    function index() {

    }

    function profile() {
        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect(SITE_URL . "login", 'refresh');
            exit;
        }
        $current_user = $this->ion_auth->user()->row();
        $user_id = $this->uri->segment(2, 0);
        $user_info = $this->basic_model->get_user_info($user_id);
//		if($user_info->user_type=="3"){
        if (1) {

            $this->load->model('provider_model');
            $this->load->model('thirdparty_model', 'tp');
            if ($user_info->user_type == "3") {
                $provider_profile_data = $this->provider_model->getProfileData($user_id);
            } else {
                $provider_profile_data = $this->tp->getProfileData($user_id);
            }
            $this->data = array();
            $this->headerdata = array();

            if (isset($provider_profile_data->specialities) && !empty($provider_profile_data->specialities)) {
                $speciality = $this->basic_model->getSpecialityName($provider_profile_data->specialities);
            } else {
                $speciality = "N/A";
            }
            if (isset($provider_profile_data->insurance_carriers) && !empty($provider_profile_data->insurance_carriers)) {
                $insurence_name = $this->basic_model->getInsurenceName($provider_profile_data->insurance_carriers);
            } else {
                $insurence_name = "N/A";
            }
            $this->data['current_user'] = $current_user;
            $this->data['InsurenceName'] = $insurence_name;
            $this->data['speciality'] = $speciality;
            $this->data['title'] = "View Provider Profile";
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

            if (isset($provider_profile_data->college_id) && !empty($provider_profile_data->college_id)) {
                $college_name = $this->basic_model->getCollegeName($provider_profile_data->college_id);
            } else {
                $college_name = "N/A";
            }
            $this->data['CollegeName'] = $college_name;
            $this->sidebardata = array();
            $this->sidebardata["username"] = ucwords($current_user->first_name . ' ' . $current_user->last_name);
            $this->sidebardata['is_active'] = 'manage_profile';


            $this->sidebardata["profile_photo"] = $current_user->profile_image;
            $this->headerdata['page_title'] = "View provider Profile";
            $this->headerdata['breadcrumbs'] = array(PROVIDER_URL, array('dashboard', 'Dashboard'), array('view_profile', 'View Provider Profile'));
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
            $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
            $this->templatelayout->get_admin_dashboard_header($this->headerdata);
            $this->templatelayout->get_admin_dashboard_footer();
            if ($current_user->user_type == "1") {
                $this->templatelayout->get_admin_dashboard_sidebar('superadminsidebar', $this->sidebardata);
            } elseif ($current_user->user_type == "2") {
                $this->templatelayout->get_admin_dashboard_sidebar('collegesidebar', $this->sidebardata);
            } elseif ($current_user->user_type == "3") {
                $this->templatelayout->get_admin_dashboard_sidebar('providersidebar', $this->sidebardata);
            } elseif ($current_user->user_type == "4") {
                $this->templatelayout->get_admin_dashboard_sidebar('patientsidebar', $this->sidebardata);
            } elseif ($current_user->user_type == "5") {
                $this->templatelayout->get_admin_dashboard_sidebar('thirdpartysidebar', $this->sidebardata);
            }
            if ($user_id == $current_user->user_id) {
                $this->data['is_owner'] = '1';
            }
            $this->elements['middle'] = 'provider/view_profile';
            $this->elements_data['middle'] = $this->data;

            $this->layout->setLayout('backend_layout/dashboardlayout');
            $this->layout->multiple_view($this->elements, $this->elements_data);
        }
    }

}
