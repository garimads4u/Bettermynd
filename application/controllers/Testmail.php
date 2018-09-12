<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Testmail extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('email');
        set_smtp_config();
        $this->basic_model->set_current_timezone();
    }

    function index() {
        $this->load->model('basic_model');
        $message_content = $this->basic_model->get_mail_template('inactivation_mail_provider');
        if (isset($message_content) && !empty($message_content)) {
            $mail_content = html_entity_decode($message_content->mail_template_content);
            $message = $mail_content;
            $message = MAIL_HEADER . $message . MAIL_FOOTER;
            $this->email->clear();
            $this->email->from($this->config->item('admin_email', 'ion_auth'), $this->config->item('site_title', 'ion_auth'));
            $this->email->to('systemadmin@dreamsoft4u.com');
            $this->email->subject($message_content->mail_subject);
            $this->email->message($message);
            if ($this->email->send() == TRUE) {
                echo 'sent';
            } else {
                echo 'fail';
            }
        } else {
            echo 'template not found';
        }
    }

}
