<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Email extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library(array('ion_auth', 'form_validation'));
        $this->load->helper(array('url', 'language'));
        $this->basic_model->set_current_timezone();
    }

    function index() {
        $current_user = $this->ion_auth->user()->row();
        if ($current_user->user_role != "2") {
            if ($current_user->user_role == "1") {
                redirect(SADMIN_URL . "dashboard", 'refresh');
                exit;
            } elseif ($current_user->user_role == "3") {
                redirect(USER_URL . "dashboard");
            } elseif ($current_user->user_role == "4") {
                redirect(AFFILIATE_URL . "dashboard");
            } elseif ($current_user->user_role == "5") {
                redirect(ADMIN_URL . "dashboard");
            }
        } else {
            redirect(COMPANY_URL . "dashboard", 'refresh');
        }
    }

    public function autologin($url = NULL) {
        $this->load->library('session');
        $this->session->sess_regenerate();
    }

    function inbox() {
        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect(SITE_URL, 'refresh');
            exit;
        } else {

            $current_user = $this->ion_auth->user()->row();
            if (!($current_user->user_role == "1" || $current_user->user_role == "2" || $current_user->user_role == "3" || $current_user->user_role == "4" || $current_user->user_role == "5")) {
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
            } else {
                $this->load->model('email_model');

                $uri_segment = $this->uri->segment(3, 0);
                $uri = false;
                if (isset($uri_segment) && !empty($uri_segment) && is_numeric($uri_segment)) {
                    $id = array("id" => $uri_segment);
                    $result = $this->email_model->update_read_status($id);
                    if ($result) {
                        $uri = true;
                    }
                }
                $inbox_mail = $this->email_model->all_inbox_Mails($current_user->user_id);
                if (isset($inbox_mail) && !empty($inbox_mail) && count($inbox_mail) > 0 && $inbox_mail[0]->read == '0' && !$uri) {
                    $id = array("id" => $inbox_mail[0]->manage_id);
                    $data = $this->email_model->update_read_status($id);
                    if ($data) {
                        $inbox_mail[0]->read = '1';
                    }
                }


                $role_name = $this->basic_model->get_user_role($current_user->user_role);
                $this->headerdata['page_title'] = "Messages";
                $this->headerdata['breadcrumbs'] = array(SITE_URL, array('user/dashboard', 'Dashboard'), array('email/inbox', 'Messages'));
                if (isset($this->data['company_details']) && !empty($this->data['company_details'])) {
                    $company_details = $this->data['company_details'];
                }
                $this->sidebardata['is_active'] = 'email';
                $this->sidebardata["role_name"] = $role_name;
                $sent_msg = $this->email_model->all_outbox_Mails($current_user->user_id);

                if (isset($sent_msg) && $sent_msg && count($sent_msg) > 0) {
                    foreach ($sent_msg as $key => $value) {
                        if ($value->msg_type == 'au') {
                            $sent_msg[$key]->user_details = "All Users";
                        } else if ($value->msg_type == 'aa') {
                            $sent_msg[$key]->user_details = "All Admins";
                        } else {
                            $user_detail = $this->email_model->user_msg_detail($value->id);
                            if (isset($user_detail) && $user_detail && count($user_detail) > 0) {
                                $sent_msg[$key]->user_details = $user_detail;
                            }
                        }
                    }
                }

                $this->data['sent_mail'] = $sent_msg;
                $this->data['message'] = $this->session->flashdata('message');
                $this->data['error'] = $this->session->flashdata('error');
                $this->data['current_user'] = $current_user;
                $this->data['inbox_mail'] = $inbox_mail;
                $this->templatelayout->get_admin_dashboard_header($this->headerdata);
                $this->templatelayout->get_admin_dashboard_footer();

                if ($current_user->user_role == "1") {
                    $this->templatelayout->get_admin_dashboard_sidebar('superadminsidebar', $this->sidebardata);
                } elseif ($current_user->user_role == "2") {
                    $this->templatelayout->get_admin_dashboard_sidebar('companysidebar', $this->sidebardata);
                } elseif ($current_user->user_role == "3") {
                    $this->templatelayout->get_admin_dashboard_sidebar('usersidebar', $this->sidebardata);
                } elseif ($current_user->user_role == "5") {
                    $this->templatelayout->get_admin_dashboard_sidebar('adminsidebar', $this->sidebardata);
                }

                $this->elements['middle'] = 'email/email';
                $this->elements_data['middle'] = $this->data;

                $this->layout->setLayout('backend_layout/dashboardlayout');
                $this->layout->multiple_view($this->elements, $this->elements_data);
            }
        }
    }

    function compose_mail() {
        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect(SITE_URL, 'refresh');
            exit;
        } else {
            $uri_segment = $this->uri->segment(3, 0);
            $current_user = $this->ion_auth->user()->row();
            if (!($current_user->user_role == "2" || $current_user->user_role == "3" || $current_user->user_role == "5" || $current_user->user_role == "1")) {
                if ($current_user->user_role == "1") {
                    redirect(SADMIN_URL . "dashboard", 'refresh');
                    exit;
                } elseif ($current_user->user_role == "3") {
                    redirect(USER_URL . "dashboard");
                } elseif ($current_user->user_role == "4") {
                    redirect(AFFILIATE_URL . "dashboard");
                } elseif ($current_user->user_role == "5") {
                    redirect(ADMIN_URL . "dashboard");
                }
            } else {

                if (!($current_user->user_role == "1")) {
                    $subscription_check = $this->basic_model->is_subscription_expired($current_user->user_id);
                }
                if (isset($subscription_check) && !empty($subscription_check) && $subscription_check < 2) {
                    if ($current_user->user_role == "2")
                        redirect(COMPANY_URL . "expired");
                    if ($current_user->user_role == "5")
                        redirect(ADMIN_URL . "expired");
                    if ($current_user->user_role == "3")
                        redirect(USER_URL . "expired");
                    exit;
                }
                $this->load->model('email_model');
                if (($current_user->user_role == "3" && isset($uri_segment) && empty($uri_segment))) {
                    $this->session->set_flashdata('error', '<p class="alert alert-danger text-left">You can\'t compose message to any recipient.</p>');
                    redirect(EMAIL_URL . "inbox");
                }
                $replyuser = $this->email_model->msg_detail($uri_segment, $current_user->user_id);
                if (isset($uri_segment) && !empty($uri_segment) && $replyuser == false) {
                    $this->session->set_flashdata('error', '<p class="alert alert-danger text-left">Please specify valid user.</p>');
                    redirect(EMAIL_URL . "inbox");
                }

                $role_name = $this->basic_model->get_user_role($current_user->user_role);
                if (isset($this->data['company_details']) && !empty($this->data['company_details'])) {
                    $company_details = $this->data['company_details'];
                }
                $this->sidebardata['is_active'] = 'email';
                $this->sidebardata["role_name"] = $role_name;
                $this->headerdata['breadcrumbs'] = array(SITE_URL, array('user/dashboard', 'Dashboard'), array('email/compose_mail', 'New Message'));
                $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
                $this->data['error'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('error')));
                $this->data['current_user'] = $current_user;

                if ($current_user->user_role == "1") {
                    $users = $this->email_model->All_users_role(true, $current_user->id, array('2'));

                    if (isset($users) && !empty($users) && count($users) > 1) {
                        $users['au'] = "All Company Admins";
                    }
                } elseif ($current_user->user_role == "2") {

                    $users_user = $this->email_model->All_users_role(true, $current_user->id, array('3'), $current_user->user_company_id);

                    $users_admin = $this->email_model->All_users_role(true, $current_user->id, array('5'), $current_user->user_company_id);
                    $users = array();
                    if (isset($users_admin) && !empty($users_admin) && is_array($users_admin)) {
                        $users+=$users_admin;
                    }
                    if (isset($users_user) && !empty($users_user) && is_array($users_user)) {
                        $users+=$users_user;
                    }

                    if (isset($users_admin) && !empty($users_admin) && count($users_admin) > 1) {
                        $users['aa'] = "All Admin";
                    }
                    if (isset($users_user) && !empty($users_user) && count($users_user) > 1) {
                        $users['au'] = "All Users";
                    }
                } elseif ($current_user->user_role == "5") {
                    $users = $this->email_model->All_users_role(true, $current_user->id, array('3'), $current_user->user_company_id);
                    if (isset($users) && !empty($users) && count($users) > 1) {
                        $users['au'] = "All Users";
                    }
                } else {
                    $users = $this->email_model->All_users_role(true, $current_user->id, array('2'), $current_user->user_company_id);
                    $users = $this->email_model->All_users_role(true, $current_user->id, array('3'), $current_user->user_company_id);
                    if (isset($users) && !empty($users) && count($users) > 1) {
                        $users['au'] = "All Users";
                    }
                }
                $post_value = (isset($_SESSION['post_data'])) ? $_SESSION['post_data'] : "";
                $this->data['selected'] = (isset($post_value) && isset($post_value['users']) && !empty($post_value['users'])) ? $post_value['users'] : "";
                $this->data['users'] = isset($users) && !empty($users) ? $users : '';
                $subj_val = "";
                if (isset($post_value) && isset($post_value['subject'])) {
                    $subj_val = $post_value['subject'];
                } elseif (($replyuser)) {
                    if ((stripos($replyuser[0]->subject, 're:') !== false)) {
                        $subj_val = str_ireplace($replyuser[0]->subject, 're: ', 'RE: ') . substr($replyuser[0]->subject, 3, strlen($replyuser[0]->subject)) . "\r\n";
                    } else {
                        $subj_val = "RE: " . $replyuser[0]->subject;
                    }
                }
                $this->data['subject'] = array(
                    'name' => 'subject',
                    'id' => 'subject',
                    'type' => 'text',
                    'class' => 'form-control',
                    'value' => $subj_val,
                    'placeholder' => 'Your Subject'
                );
                $this->data['file_name'] = array(
                    'name' => 'file_name',
                    'type' => 'text',
                    'class' => 'form-control',
                    'readonly' => 'readonly',
                    'placeholder' => "Browse",
                    'value' => ''
                );
                $this->data['file'] = array(
                    'name' => 'file',
                    'id' => 'file',
                    'type' => 'file',
                    'class' => 'form-control',
                    'enctype' => 'multipart/form-data'
                );
                $this->data['editor'] = array(
                    'name' => 'messsage',
                    'id' => 'messsage',
                    'rows' => '4',
                    'value' => (isset($post_value) && isset($post_value['messsage']) && !empty($post_value['messsage'])) ? $post_value['messsage'] : (($replyuser) ? html_entity_decode("</br></br><hr><strong>From: </strong>" . $replyuser[0]->user_email . "</br><strong>To: </strong>" . $current_user->user_email . "</br><strong>Sent: </strong>" . date("D ,M d, Y H:i A", strtotime($replyuser[0]->created_date)) . "</br><strong>Subject: </strong>" . $replyuser[0]->subject . "<br/>" . $replyuser[0]->discription) : ''),
                    'class' => 'form-control',
                );

                if (isset($_SESSION['post_data']))
                    unset($_SESSION['post_data']);
                $this->data['reply_user'] = $replyuser[0];
                $this->headerdata['page_title'] = "New Message";

                $this->templatelayout->get_admin_dashboard_header($this->headerdata);
                $this->templatelayout->get_admin_dashboard_footer();

                if ($current_user->user_role == "1") {
                    $this->templatelayout->get_admin_dashboard_sidebar('superadminsidebar', $this->sidebardata);
                } elseif ($current_user->user_role == "2") {
                    $this->templatelayout->get_admin_dashboard_sidebar('companysidebar', $this->sidebardata);
                } elseif ($current_user->user_role == "3") {
                    $this->templatelayout->get_admin_dashboard_sidebar('usersidebar', $this->sidebardata);
                } elseif ($current_user->user_role == "5") {
                    $this->templatelayout->get_admin_dashboard_sidebar('adminsidebar', $this->sidebardata);
                }

                $this->elements['middle'] = 'email/compose_mail';
                $this->elements_data['middle'] = $this->data;
                $this->layout->setLayout('backend_layout/dashboardlayout');
                $this->layout->multiple_view($this->elements, $this->elements_data);
            }
        }
    }

    function send_mail() {

        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect(SITE_URL, 'refresh');
            exit;
        } else {
            $current_user = $this->ion_auth->user()->row();
            if (!($current_user->user_role == "2" || $current_user->user_role == "3" || $current_user->user_role == "5" || $current_user->user_role == "1")) {
                if ($current_user->user_role == "1") {
                    redirect(SADMIN_URL . "dashboard", 'refresh');
                    exit;
                } elseif ($current_user->user_role == "3") {
                    redirect(USER_URL . "dashboard");
                } elseif ($current_user->user_role == "4") {
                    redirect(AFFILIATE_URL . "dashboard");
                } elseif ($current_user->user_role == "5") {
                    redirect(ADMIN_URL . "dashboard");
                }
            } else {
                $this->load->model("email_model");
                $edit_id = $this->input->post('edit_id');
                $mail_id = $this->input->post('mail_id');
                if (!$mail_id) {
                    $mail_id = '0';
                }
                if (isset($mail_id) && !empty($mail_id)) {
                    $replyuser = $this->email_model->msg_detail($mail_id, $current_user->user_id);
                } else {
                    $replyuser = false;
                }
                if (isset($edit_id) && $replyuser) {
                    $this->form_validation->set_rules('edit_id', 'User is not Selected properly.', 'required');
                } else {
                    $this->form_validation->set_rules('users[]', 'Please specify at least one recipient', 'required');
                }
//                echo trim(str_replace('&nbsp;', '', strip_tags($this->input->post('message'))));die;
                $this->form_validation->set_rules('subject', 'Subject Field is required. Please enter subject to continue.', 'trim|required');
                $this->form_validation->set_rules('messsage', 'Message field can\'t be empty!', 'trim|required');
                $this->form_validation->set_message('required', '%s');
                $post_value = $this->input->post();

                if (isset($post_value) && is_array($post_value) && !empty($post_value) && $this->form_validation->run() == true) {
                    $subject = htmlentities($this->input->post('subject'));
                    if (trim(str_replace('&nbsp;', '', strip_tags($this->input->post('messsage')))) == "") {
                        $_SESSION['post_data'] = $_POST;
                        $this->session->set_flashdata('error', '<p class="alert alert-danger text-left">Message field can\'t be empty!.</p>');
                        redirect(EMAIL_URL . "compose_mail" . (($replyuser) ? '/' . $replyuser[0]->id : ''));
                    }
                    $mail_content = htmlentities($this->input->post('messsage'));
                    $users = $this->input->post('users');
                    $message_data['subject'] = $subject;
                    $message_data['discription'] = $mail_content;
                    $message_data['created_date'] = date("Y-m-d H:i:s");
                } else {
                    $_SESSION['post_data'] = $_POST;
                    $this->session->set_flashdata('error', (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message'))));
                    redirect(EMAIL_URL . "compose_mail" . (($replyuser) ? '/' . $replyuser[0]->id : ''));
                }

                if (isset($_FILES) && !empty($_FILES) && $_FILES['file']['size'] > 0) {
                    $config = array();
                    $attachment_upload_error = false;
                    $config['upload_path'] = EMAIL_UPLOAD_DIR;
                    $config['allowed_types'] = 'jpg|png|jpeg|gif|tif|doc|pdf|docx|odt|txt|ppt|xls|xlsx|zip|rar';
                    $config['encrypt_name'] = TRUE;
                    $config['max_size'] = '20480';
                    if (!file_exists($config['upload_path'])) {
                        mkdir($config['upload_path'], 0777, true);
                    }
                    $this->load->library('upload', $config);
                    if ($this->upload->do_upload('file')) {
                        $data = $this->upload->data();
                        $document_data = array(
                            'file_name' => $data['file_name'],
                            'orig_name' => $data['client_name'],
                        );
                    } else {
//                                    $error = (object)array('error' => $this->upload->display_errors());
//                                    $attachment_upload_error=$error->error;
                        $attachment_upload_error = "file uplading error";
                    }
                }

                if (!empty($replyuser)) {
                    $message_data['msg_type'] = 'ot';
                } else if (isset($users) && is_array($users) && !empty($users)) {
                    $users_mail = array();
                    $message_sent_field = array();
                    if ($current_user->user_role == "1") {
                        if (in_array('au', $users)) {
                            $users_mail = $this->email_model->All_users_role(false, $current_user->id, array('2'));
                            $message_data['msg_type'] = 'au';
                            array_push($message_sent_field, "All Company Admins");
                        } else {
                            $values = array_values($users);
                            $users_mail = $this->basic_model->get_users_data($values);
                            array_push($message_sent_field, $users_mail);
                            $message_data['msg_type'] = 'ot';
                        }
                    } elseif ($current_user->user_role == "2") {
                        $all = false;
                        if (in_array('au', $users) && in_array('aa', $users)) {
                            $users_mail = $this->email_model->All_users_role(false, $current_user->id, array('3', '5'), $current_user->user_company_id);
                            $all = true;
                            array_push($message_sent_field, 'All Users');
                            array_push($message_sent_field, 'All Admins');
                            unset($users[array_search('au', $users)]);
                            unset($users[array_search('aa', $users)]);
                            $message_data['msg_type'] = 'ot';
                        } elseif (in_array('aa', $users)) {
                            $users_mail = $this->email_model->All_users_role(false, $current_user->id, array('5'), $current_user->user_company_id);
                            unset($users[array_search('aa', $users)]);
                            array_push($message_sent_field, 'All Admins');
                            $message_data['msg_type'] = 'aa';
                        } elseif (in_array('au', $users)) {
                            $users_mail = $this->email_model->All_users_role(false, $current_user->id, array('3'), $current_user->user_company_id);
                            unset($users[array_search('au', $users)]);
                            array_push($message_sent_field, 'All Users');
                            $message_data['msg_type'] = 'au';
                        }
                        if (!($all)) {
                            if (count($users) > 0 && !empty($users)) {
                                $values = array_values($users);
                                if ($users_mail && !empty($users_mail)) {
                                    foreach ($values as $key => $value) {
                                        if (sizeof(array_filter($users_mail, function($valu) use ($value) {
                                                            return $valu->user_id == $value;
                                                        }))) {
                                            unset($values[$key]);
                                        }
                                    }
                                    $values = array_values($values);
                                }
                                if (isset($values) && is_array($values) && !empty($values)) {
                                    $message_data['msg_type'] = 'ot';
                                    $remaining_user = $this->basic_model->get_users_data($values);
                                    array_push($message_sent_field, $remaining_user);
                                    $users_mail = array_merge($users_mail, $remaining_user);
                                }
                            }
                        }
                    } elseif ($current_user->user_role == "5") {
                        if (in_array('au', $users)) {
                            $users_mail = $this->email_model->All_users_role(false, $current_user->id, array('3'), $current_user->user_company_id);
                            $message_data['msg_type'] = 'au';
                            array_push($message_sent_field, 'All Users');
                        } else {
                            $values = array_values($users);
                            $users_mail = $this->basic_model->get_users_data($values);
                            $message_data['msg_type'] = 'ot';
                            array_push($message_sent_field, $users_mail);
                        }
                    }
                } else {
                    $this->session->set_flashdata('error', '<p class="alert alert-danger text-left">There is some technical issue in sending your message.Please send again.</p>');
                    redirect(EMAIL_URL . 'inbox');
                }
                $string = '';
                if (isset($message_sent_field) && !empty($message_sent_field)) {
                    foreach ($message_sent_field as $key => $user) {
                        if (is_string($user)) {
                            if (!empty($string)) {
                                $string.=', ';
                            }
                            $string.=$user;
                        } elseif (is_array($user)) {
                            foreach ($user as $key1 => $indisual) {
                                if (!empty($string)) {
                                    $string.=', ';
                                }
                                $string.=$indisual->account_holder_name . '(' . $indisual->user_email . ')';
                            }
                        }
                    }
                }
                $message_data['msg_send_to'] = $string;
                if (isset($document_data) && $document_data && !empty($document_data)) {
                    $message_data = array_merge($document_data, $message_data);
                }

                $this->db->insert(EMAIL, $message_data);
                $msg_id = $this->db->insert_id();
                if ($msg_id) {
                    if (!empty($replyuser)) {
                        $user_array = array();
                        $user_array['sender_id'] = $current_user->user_id;
                        $user_array['recevier_id'] = $edit_id;
                        $user_array['created_date'] = date("Y-m-d H:i:s");
                        $user_array['mail_id'] = $msg_id;
                        $this->db->insert(EMAIL_MANAGE, $user_array);
                    } elseif (isset($users_mail) && is_array($users_mail) && !empty($users_mail)) {
                        $data = array();
                        foreach ($users_mail as $key => $values) {
                            $user_array = array();
                            $user_array['sender_id'] = $current_user->user_id;
                            ;
                            $user_array['recevier_id'] = $values->user_id;
                            $user_array['created_date'] = date("Y-m-d H:i:s");
                            ;
                            $user_array['mail_id'] = $msg_id;
                            $data[] = $user_array;
                        }
                        $last_id = $this->db->insert_batch(EMAIL_MANAGE, $data);
                    } else {
                        $this->session->set_flashdata('error', '<p class="alert alert-danger text-left">There is some technical issue in sending your message.Please send again</p>');
                        redirect(EMAIL_URL . 'compose_mail' . (($replyuser) ? '/' . $replyuser[0]->id : ''));
                    }
//                            if(isset($attachment_upload_error) && $attachment_upload_error && !empty($attachment_upload_error)){
//                                $this->session->set_flashdata('error', '<p class="alert alert-danger text-left">'.$attachment_upload_error.'</p>');
//                                redirect(EMAIL_URL . 'inbox');
//                            }
                    $this->session->set_flashdata('message', 'Message has been sent successfully.');
                    redirect(EMAIL_URL . 'inbox');
                } else {
                    $this->session->set_flashdata('error', '<p class="alert alert-danger text-left">There is some technical issue in sending your message.Please send again</p>');
                    redirect(EMAIL_URL . 'compose_mail' . (($replyuser) ? '/' . $replyuser[0]->id : ''));
                }
            }
        }
    }

    function read_status() {
        $post_value = $this->input->post();
        if (isset($post_value) && is_array($post_value) && !empty($post_value)) {
            $this->load->model('email_model');
            $data = $this->email_model->update_read_status($post_value);
            if ($data) {
                echo '1';
            } else {
                echo '0';
            }
            return;
        }
        echo '0';
        return;
    }

    /*
     * show all notification
     */

    function notification() {
        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect(SITE_URL, 'refresh');
            exit;
        } else {
            $current_user = $this->ion_auth->user()->row();
            if (!($current_user->user_role == "2" || $current_user->user_role == "3" || $current_user->user_role == "5" || $current_user->user_role == "1")) {
                if ($current_user->user_role == "1") {
                    redirect(SADMIN_URL . "dashboard", 'refresh');
                    exit;
                } elseif ($current_user->user_role == "3") {
                    redirect(USER_URL . "dashboard");
                } elseif ($current_user->user_role == "4") {
                    redirect(AFFILIATE_URL . "dashboard");
                } elseif ($current_user->user_role == "5") {
                    redirect(ADMIN_URL . "dashboard");
                }
            } else {
                if (!($current_user->user_role == "1"))
                    $subscription_check = $this->basic_model->is_subscription_expired($current_user->user_id);
                if (isset($subscription_check) && !empty($subscription_check) && $subscription_check < 2) {
                    if ($current_user->user_role == "2")
                        redirect(COMPANY_URL . "expired");
                    if ($current_user->user_role == "5")
                        redirect(ADMIN_URL . "expired");
                    if ($current_user->user_role == "3")
                        redirect(USER_URL . "expired");
                    exit;
                }
                $role_name = $this->basic_model->get_user_role($current_user->user_role);

                $this->headerdata['page_title'] = "Notification";
                $this->headerdata['breadcrumbs'] = array(SITE_URL, array('user/dashboard', 'Dashboard'), array('email/notification', 'Notification'));
                $this->sidebardata['is_active'] = 'email';
                $this->sidebardata["role_name"] = $role_name;
                $this->templatelayout->get_admin_dashboard_header($this->headerdata);
                $this->templatelayout->get_admin_dashboard_footer();
                if ($current_user->user_role == "1") {
                    $this->templatelayout->get_admin_dashboard_sidebar('superadminsidebar', $this->sidebardata);
                } elseif ($current_user->user_role == "2") {
                    $this->templatelayout->get_admin_dashboard_sidebar('companysidebar', $this->sidebardata);
                } elseif ($current_user->user_role == "3") {
                    $this->templatelayout->get_admin_dashboard_sidebar('usersidebar', $this->sidebardata);
                } elseif ($current_user->user_role == "5") {
                    $this->templatelayout->get_admin_dashboard_sidebar('adminsidebar', $this->sidebardata);
                }
                $this->load->model('email_model');
                $this->data['notification'] = $this->email_model->getNotification($current_user->user_id);

                $this->elements['middle'] = 'email/notification';
                $this->elements_data['middle'] = $this->data;
                $this->layout->setLayout('backend_layout/dashboardlayout');
                $this->layout->multiple_view($this->elements, $this->elements_data);
            }
        }
    }

    function download() {
        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect(SITE_URL, 'refresh');
            exit;
        } else {
            $current_user = $this->ion_auth->user()->row();
            if (!($current_user->user_role == "2" || $current_user->user_role == "3" || $current_user->user_role == "5" || $current_user->user_role == "1")) {
                if ($current_user->user_role == "1") {
                    redirect(SADMIN_URL . "dashboard", 'refresh');
                    exit;
                } elseif ($current_user->user_role == "3") {
                    redirect(USER_URL . "dashboard");
                } elseif ($current_user->user_role == "4") {
                    redirect(AFFILIATE_URL . "dashboard");
                } elseif ($current_user->user_role == "5") {
                    redirect(ADMIN_URL . "dashboard");
                }
            } else {
                if (!($current_user->user_role == "1"))
                    $subscription_check = $this->basic_model->is_subscription_expired($current_user->user_id);
                if (isset($subscription_check) && !empty($subscription_check) && $subscription_check < 2) {
                    if ($current_user->user_role == "2")
                        redirect(COMPANY_URL . "expired");
                    if ($current_user->user_role == "5")
                        redirect(ADMIN_URL . "expired");
                    if ($current_user->user_role == "3")
                        redirect(USER_URL . "expired");
                    exit;
                }
                $mailid = $this->uri->segment(3);
                $file_name = $this->uri->segment(4);
                $this->load->model("email_model");
                $data = $this->email_model->getfileAttachment($mailid, $file_name, $current_user->user_id);
                $fullPathurl = ASSETS_URL . 'upload/mailattachment/' . $file_name;
                $fullPath = EMAIL_UPLOAD_DIR . $file_name;
                if (isset($file_name) && isset($data) && file_exists($fullPath) && $data && !empty($data)) {
                    $this->load->helper('download');
                    force_download($data->orig_name, file_get_contents($fullPathurl));
                    die;
                    // change the path to fit your websites document structure
                    $orignalname = stripslashes($data->orig_name);
                    if ($fd = fopen($fullPath, "r")) {
                        $fsize = filesize($fullPath);
                        $path_parts = pathinfo($fullPath);
                        $ext = strtolower($path_parts["extension"]);
                        switch ($ext) {
                            case "pdf":
                                header("Content-type: application/$ext"); // add here more headers for diff. extensions
                                header("Content-Disposition: attachment; filename=\"" . $data->orig_name . "\""); // use 'attachment' to force a download
                                break;
                            case "docx" || "doc":
                                header("Content-type: application/$ext"); // add here more headers for diff. extensions
                                header("Content-Disposition: attachment; filename=\"" . $data->orig_name . "\""); // use 'attachment' to force a download
                                break;
                            case "zip" || "rar":
                                header("Content-type: application/$ext"); // add here more headers for diff. extensions
                                header("Content-Disposition: attachment; filename=\"" . $data->orig_name . "\""); // use 'attachment' to force a download
                                break;
                            case "mp3":
                                header("Content-type: audio/mpeg"); // add here more headers for diff. extensions
                                header("Content-Disposition: attachment; filename=\"" . $data->orig_name . "\""); // use 'attachment' to force a download
                                break;
                            case "jpg" || "jpeg":
                                header("Content-type: audio/jpeg"); // add here more headers for diff. extensions
                                header("Content-Disposition: attachment; filename=\"" . $data->orig_name . "\""); // use 'attachment' to force a download
                                break;

                            default:
                                header("Content-type: application/octet-stream");
                                header("Content-Disposition:attachment; filename=\"" . $data->orig_name . "\"");
                                break;
                        }
                        header("Content-length: $fsize");
                        header("Cache-control: private"); //use this to open files directly
                        while (!feof($fd)) {
                            $buffer = fread($fd, $fsize);
                            echo $buffer;
                        }
                    }
                } else {
                    $this->session->set_flashdata('error', '<p class="alert alert-danger text-left">Attachment not found.</p>');
                    redirect(EMAIL_URL . 'inbox');
                }
            }
        }
    }

    function fetchnotification() {
        $this->load->model('email_model');
        $current_user = $this->ion_auth->user()->row();
        $user_id = $current_user->user_id;
        $data = $this->email_model->get_tot_nofication($user_id);
        print_r($data);
        die();
    }

    function delete() {
        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect(SITE_URL, 'refresh');
            exit;
        } else {
            $current_user = $this->ion_auth->user()->row();
            if (!($current_user->user_role == "2" || $current_user->user_role == "3" || $current_user->user_role == "5" || $current_user->user_role == "1")) {
                if ($current_user->user_role == "1") {
                    redirect(SADMIN_URL . "dashboard", 'refresh');
                    exit;
                } elseif ($current_user->user_role == "3") {
                    redirect(USER_URL . "dashboard");
                } elseif ($current_user->user_role == "4") {
                    redirect(AFFILIATE_URL . "dashboard");
                } elseif ($current_user->user_role == "5") {
                    redirect(ADMIN_URL . "dashboard");
                }
            } else {
                if (!($current_user->user_role == "1"))
                    $subscription_check = $this->basic_model->is_subscription_expired($current_user->user_id);
                if (isset($subscription_check) && !empty($subscription_check) && $subscription_check < 2) {
                    if ($current_user->user_role == "2")
                        redirect(COMPANY_URL . "expired");
                    if ($current_user->user_role == "5")
                        redirect(ADMIN_URL . "expired");
                    if ($current_user->user_role == "3")
                        redirect(USER_URL . "expired");
                    exit;
                }
                $this->load->model("email_model");
                $post_value = $this->input->post();

                $this->form_validation->set_rules('selected[]', 'Mail is not Selected properly.', 'required');
                $this->form_validation->set_rules('type', 'Type of mail not defined.', 'required');

                if (isset($post_value) && is_array($post_value) && !empty($post_value) && $this->form_validation->run() == true) {
                    $type = $post_value['type'];
                    if (isset($post_value['selected']) & !empty($post_value['selected']) && is_array($post_value['selected']) && $type) {
                        foreach ($post_value['selected'] as $key => $values) {
                            $result = $this->email_model->delete_mail($values, $current_user->user_id, $post_value['type']);
                        }
                        $this->session->set_flashdata('message', 'Your mail has been deleted.');
                        redirect(EMAIL_URL . "inbox");
                    } else {
                        $this->session->set_flashdata('error', '<p class="alert alert-danger text-left">Please select mail to delete.</p>');
                        redirect(EMAIL_URL . "inbox");
                    }
                    $data = $this->email_model->update_read_status($post_value);
                } else {
                    $this->session->set_flashdata('error', '<p class="alert alert-danger text-left">Please select mail for delete.</p>');
                    redirect(EMAIL_URL . "inbox");
                }
            }
        }
    }

    function search() {
        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect(SITE_URL, 'refresh');
            exit;
        } else {
            $current_user = $this->ion_auth->user()->row();
            if (!($current_user->user_role == "2" || $current_user->user_role == "3" || $current_user->user_role == "5" || $current_user->user_role == "1")) {
                if ($current_user->user_role == "1") {
                    redirect(SADMIN_URL . "dashboard", 'refresh');
                    exit;
                } elseif ($current_user->user_role == "3") {
                    redirect(USER_URL . "dashboard");
                } elseif ($current_user->user_role == "4") {
                    redirect(AFFILIATE_URL . "dashboard");
                } elseif ($current_user->user_role == "5") {
                    redirect(ADMIN_URL . "dashboard");
                }
            } else {
                if (!($current_user->user_role == "1"))
                    $subscription_check = $this->basic_model->is_subscription_expired($current_user->user_id);
                if (isset($subscription_check) && !empty($subscription_check) && $subscription_check < 2) {
                    if ($current_user->user_role == "2")
                        redirect(COMPANY_URL . "expired");
                    if ($current_user->user_role == "5")
                        redirect(ADMIN_URL . "expired");
                    if ($current_user->user_role == "3")
                        redirect(USER_URL . "expired");
                    exit;
                }
                $this->load->model('email_model');
                $user_all = array();
                if ($current_user->user_role == "1") {
                    $users = $this->email_model->All_users_role(true, $current_user->id, array('2'));
                    if (isset($users) && !empty($users) && count($users) > 1) {
//                        $user_all['au']="All Company Admins";
                        $users['au'] = "All Company Admins";
                    }
                } elseif ($current_user->user_role == "2") {
                    $users_user = $this->email_model->All_users_role(true, $current_user->id, array('3'), $current_user->user_company_id);

                    $users_admin = $this->email_model->All_users_role(true, $current_user->id, array('5'), $current_user->user_company_id);
                    $users = array();
                    if (isset($users_admin) && !empty($users_admin) && is_array($users_admin)) {
                        $users+=$users_admin;
                    }
                    if (isset($users_user) && !empty($users_user) && is_array($users_user)) {
                        $users+=$users_user;
                    }

                    if (isset($users_admin) && !empty($users_admin) && count($users_admin) > 1) {
//                        $user_all['aa']="All Admin";
                        $users['aa'] = "All Admin";
                    }
                    if (isset($users_user) && !empty($users_user) && count($users_user) > 1) {
//                        $user_all['au']="All Users";
                        $users['au'] = "All Users";
                    }
                } elseif ($current_user->user_role == "5") {
                    $users = $this->email_model->All_users_role(true, $current_user->id, array('3'), $current_user->user_company_id);
                    if (isset($users) && !empty($users) && count($users) > 1) {
//                        $user_all['au']="All Users";
                        $users['au'] = "All Users";
                    }
                } else {
                    $users = $this->email_model->All_users_role(true, $current_user->id, array('2'), $current_user->user_company_id);
                }
//                print_r($users);die;
                $data = $this->input->post('data');
                $q = $data['q'];
                $results = array();
                foreach ($users as $i => $user) {
                    //if( stripos($user,$q) === 0 ){
                    $results[] = array('id' => $i, 'text' => $user);
                    //}
                }

//                if(isset($user_all) && !empty($user_all)){
//                    foreach($user_all as $i => $user){
//                                $results[] = array('id' => $i, 'text' => $user);
//                    }
//                }
//                print_r($results);die;
                echo json_encode(array('q' => $q, 'results' => $results));
            }
        }
    }

}
