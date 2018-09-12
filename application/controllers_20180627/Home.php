<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    function __construct() {
        parent::__construct();
        redirect(WP_SITE_URL, 'refresh');
        $this->load->database();
        $this->load->helper(array('language'));
        $this->lang->load('auth');
        $this->load->helper(array('cookie', 'email'));
        $this->load->library('minify');
        set_smtp_config();
        $this->basic_model->set_current_timezone();
    }

    public function index() {
        unset($_SESSION['postdata']);
        $this->data = array();
        $this->headerdata = array();

        $this->templatelayout->get_home_header();
        $this->templatelayout->get_home_footer();
        $this->data['div_form_id'] = 'index';
        $this->elements['middle'] = 'home/index';
        $this->elements_data['middle'] = $this->data;
        $this->layout->setLayout('layout/home_layout');
        $this->layout->multiple_view($this->elements, $this->elements_data);
    }

    public function aboutus() {
        $this->data = array();
        $this->headerdata = array();
        $pagedata = $this->basic_model->get_cms_pages_by_slug('about_us');
        $this->data['pagedata'] = $pagedata;
        $this->templatelayout->get_home_header();
        $this->templatelayout->get_home_footer();
        $this->data['div_form_id'] = 'aboutus';
        $this->elements['middle'] = 'home/aboutus';
        $this->elements_data['middle'] = $this->data;
        $this->layout->setLayout('layout/home_layout');
        $this->layout->multiple_view($this->elements, $this->elements_data);
    }

    public function contact() {
        $this->data = array();
        $this->headerdata = array();
        $pagedata = $this->basic_model->get_cms_pages_by_slug('contact_us');
        $admin = $this->basic_model->getAdminDetails();
        $admin_name = ucfirst($admin['first_name'] . " " . $admin['last_name']);

        if ($this->input->post()) {
            if ($this->input->post('email')) {
                $name = $this->input->post('name');
                $email = $this->input->post('email');
                $subject = $this->input->post('subject');
                $user_message = $this->input->post('message');
                $message_content = $this->basic_model->get_mail_template('contact_us');
                $mail_content = html_entity_decode($message_content->mail_template_content);

                $message = str_replace(array("{{identity}}", "{{site}}", "{{name}}", "{{email}}", "{{subject}}", "{{message}}"), array($admin_name, SITE_NAME, $name, $email, $subject, $user_message), $mail_content);
                $message = MAIL_HEADER . $message . MAIL_FOOTER;
                $this->email->clear();
                $this->email->from($this->config->item('admin_email', 'ion_auth'), $this->config->item('site_title', 'ion_auth'));
                $this->email->to($admin['user_email']);
                $this->email->subject($message_content->mail_subject);
                $this->email->message($message);
                $this->email->send();

                $this->session->set_flashdata('message', "Thank you for contacting us! We have received your message and will be in touch shortly.");
            }
        }
        $this->data['message'] = $this->session->flashdata('message');
        $this->data['pagedata'] = $pagedata;
        $this->templatelayout->get_home_header();
        $this->templatelayout->get_home_footer();
        $this->data['div_form_id'] = 'contact';
        $this->elements['middle'] = 'home/contact';
        $this->elements_data['middle'] = $this->data;
        $this->layout->setLayout('layout/home_layout');
        $this->layout->multiple_view($this->elements, $this->elements_data);
    }

    public function services() {
        $this->data = array();
        $this->headerdata = array();
        $pagedata = $this->basic_model->get_cms_pages_by_slug('services');
        $this->data['pagedata'] = $pagedata;
        $this->templatelayout->get_home_header();
        $this->templatelayout->get_home_footer();
        $this->data['div_form_id'] = 'services';
        $this->elements['middle'] = 'home/services';
        $this->elements_data['middle'] = $this->data;
        $this->layout->setLayout('layout/home_layout');
        $this->layout->multiple_view($this->elements, $this->elements_data);
    }

    public function test_email() {
        exit;
        $message_content = $this->basic_model->get_mail_template('contact_us');
        $mail_content = html_entity_decode($message_content->mail_template_content);
        $message = MAIL_HEADER . $mail_content . MAIL_FOOTER;

        $this->load->library('custom_email');
        if ($this->custom_email->sendinblue_email($this->config->item('admin_email', 'ion_auth'), 'sangeeta@dreamsoft4u.com', $message_content->mail_subject, $message) == TRUE)
            prd('Sent', 1);
        else
            prd('Not Sent', 1);
        exit('here');
    }

}

?>