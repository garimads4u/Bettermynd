<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Company extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     * 	- or -
     * 		http://example.com/index.php/welcome/index
     * 	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */
    function __construct() {

        parent::__construct();
        $this->load->database();
        $this->load->library(array('ion_auth', 'form_validation'));
        $this->load->helper(array('url', 'language', 'email'));
        set_smtp_config();

        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
        $this->lang->load('auth');
        $this->load->library('encrypt');
        $uri_segment = $this->uri->segment(2, 0);
        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect(SITE_URL, 'refresh');
            exit;
        }
        //
        $current_user = $this->ion_auth->user()->row();
        $this->data = array();
        $this->headerdata = array();
        $this->sidebardata = array();
        $this->sidebardata['profile_photo'] = $current_user->profile_photo;
        $company_details = $this->basic_model->get_company_profile($current_user->user_company_id);
        if (isset($company_details) && !empty($company_details)) {
            $this->data['company_details'] = $company_details;

            $user_logo = $this->basic_model->get_user_company_logo($current_user->user_id);

            if (isset($user_logo) && !empty($user_logo)) {
                $this->sidebardata["logo"] = $user_logo;
                $this->headerdata["logo"] = $user_logo;
            }
            $this->sidebardata["username"] = $current_user->account_holder_name != "" ? $current_user->account_holder_name : $current_user->username;
        }

        $this->basic_model->set_current_timezone();
    }

    function index() {
        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect(SITE_URL, 'refresh');
            exit;
        }
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

    function expired() {
        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect(SITE_URL, 'refresh');
            exit;
        } else {

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
            }
            $subscription_check = $this->basic_model->is_subscription_expired($current_user->user_id);
            if ($subscription_check == 2) {
                redirect(COMPANY_URL . "dashboard");
                exit;
            }

            $role_name = $this->basic_model->get_user_role($current_user->user_role);
            $this->sidebardata["role_name"] = $role_name;
            if (isset($this->data['company_details']) && !empty($this->data['company_details'])) {
                $company_details = $this->data['company_details'];
            } $packages = $this->basic_model->get_membership_packages('COMPANY');
            if (isset($packages) && count($packages) && !empty($packages)) {
                $this->data['packages'] = $packages;
            }
            $tax = $this->basic_model->get_tax();
            if (isset($tax) && $tax > 0) {
                $this->data['tax'] = $tax;
            }
            $this->data['user_type'] = array(
                'name' => 'user_type',
                'id' => 'user_type',
                "class" => "form-control ",
                'type' => 'text',
                'maxlength' => '5',
                'value' => 'C',
                'type' => 'hidden'
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
            $this->data['card_number'] = array(
                'name' => 'card_number',
                'id' => 'card_number',
                'type' => 'text',
                "class" => "form-control  col-md-7 col-xs-12 credit_card_number nonpaste",
                'placeholder' => "Credit Card Number"
            );
            $this->data['expiration_date'] = array(
                'name' => 'expiration_date',
                'id' => 'expiration_date',
                'type' => 'text',
                "class" => "form-control  col-md-7 col-xs-12 credit_card_expiry nonpaste",
                'placeholder' => "MM / YYYY"
            );
            $this->data['cvv_code'] = array(
                'name' => 'cvv_code',
                'id' => 'cvv_code',
                'type' => 'password',
                "class" => "form-control  col-md-7 col-xs-12 credit_card_cvc nonpaste",
                'placeholder' => "CVV"
            );
            $this->data['address'] = array(
                'name' => 'address',
                'id' => 'address',
                'type' => 'text',
                'maxlength' => '250',
                "class" => "form-control  col-md-7 col-xs-12",
                'placeholder' => "Address",
                'value' => isset($postdata) && !empty($postdata) && isset($postdata['address']) ? $postdata['address'] : ''
            );
            $this->data['zip_code'] = array(
                'name' => 'zip_code',
                'id' => 'zip_code',
                'type' => 'text',
                'maxlength' => '8',
                "class" => "form-control  col-md-7 col-xs-12",
                'placeholder' => "Zip Code",
                'value' => isset($postdata) && !empty($postdata) && isset($postdata['zip_code']) ? $postdata['zip_code'] : ''
            );
            $this->data['coupon_code'] = array(
                'name' => 'coupon_code',
                'id' => 'coupon_code',
                "class" => "form-control",
                'type' => 'text',
                'placeholder' => "Enter Code"
            );
            $this->headerdata['page_title'] = "Your License Is Expired";
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
            $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
            $this->templatelayout->get_admin_dashboard_header($this->headerdata);
            $this->templatelayout->get_admin_dashboard_footer();
            $this->templatelayout->get_admin_dashboard_sidebar('companysidebar', $this->sidebardata);
            $this->elements['middle'] = 'layout/expired';
            $this->elements_data['middle'] = $this->data;
            $this->layout->setLayout('backend_layout/dashboardlayout');
            $this->layout->multiple_view($this->elements, $this->elements_data);
        }
    }

    function update_subscription() {

        $membership_plan = $this->input->post('membership_plan');
        if (isset($membership_plan) && !empty($membership_plan)) {
            $membership_plan = $membership_plan[0];
        }
        $is_subscription = $this->input->post('is_subscription');
        $final_amount = $this->input->post('final_amount');
        $coupon_code = $this->input->post('coupon_code');
        $first_name = $this->input->post('first_name');
        $last_name = $this->input->post('last_name');

        $card_number = $this->input->post('card_number');
        $expiration_date = $this->input->post('expiration_date');
        $cvv_code = $this->input->post('cvv_code');
        $address = $this->input->post('address');
        $user_type = $this->input->post('user_type');
        $zip_code = $this->input->post('zip_code');
        $current_user = $this->ion_auth->user()->row();
        $ccdata['first_name'] = $first_name;
        $ccdata['last_name'] = $last_name;
        $ccdata['card_number'] = $card_number;
        $ccdata['expiration_date'] = $expiration_date;
        //
        $ccdata['cvv_code'] = $cvv_code;
        $ccdata['expiration_date'] = $expiration_date;
        $ccdata['address'] = $address;
        $ccdata['zip_code'] = $zip_code;
        $ccdata['email'] = $current_user->user_email;
        $email = $current_user->user_email;


        $member_ship_plan = $this->basic_model->get_membership_package_details($membership_plan);

        $plan_type = $member_ship_plan[0]['package_mode'];
        if (isset($plan_type) && !empty($plan_type)) {
            $ccdata['package_mode'] = $plan_type;
        }
        if ($user_type == "C") {
            $p_c_type = "COMPANY";
        } else {
            $p_c_type = "USER";
        }
        $additional_data = array();
        if (isset($coupon_code) && !empty($coupon_code)) {
            $validate = $this->basic_model->validate_coupon($coupon_code, $p_c_type, $plan_type);
        }
        if (isset($validate) && !empty($validate)) {
            if ($validate[0]['coupon_code_type'] == "AMOUNT") {
                //$additional_data['discount']=$validate[0]['discount_percentage'];
            }
        } else {
            //$additional_data['discount']=0;
        }
        $tax = $this->basic_model->get_tax();

        if (isset($validate) && $validate[0]['payment_mode'] == "ANNUALLY" && $validate[0]['coupon_code_type'] == "AMOUNT") {

            $one_time_payment = ($member_ship_plan[0]['package_amount']) * ((100 - ($validate[0]['discount_percentage'])) / 100);
            $subscription_start_date = date('Y-m-d h:i:s');
            $subscription_end_date = date('Y-m-d h:i:s', strtotime("+365 days"));
            $ccdata['discount_code'] = $coupon_code;
            $ccdata['discount'] = $validate[0]['discount_percentage'] . "%";
        } elseif (isset($validate) && $validate[0]['payment_mode'] == "MONTHLY" && $validate[0]['coupon_code_type'] == "AMOUNT") {

            $one_time_payment = ($member_ship_plan[0]['package_amount']) * ((100 - ($validate[0]['discount_percentage'])) / 100);
            $subscription_start_date = date('Y-m-d h:i:s');
            $subscription_end_date = date('Y-m-d h:i:s', strtotime("+30 days"));
            $ccdata['discount_code'] = $coupon_code;
            $ccdata['discount'] = $validate[0]['discount_percentage'] . "%";
        } elseif (isset($validate) && $validate[0]['payment_mode'] == "ANNUALLY" && $validate[0]['coupon_code_type'] == "DAYS") {
            $one_time_payment = ($member_ship_plan[0]['package_amount']);
            $extended_days = $validate[0]['coupon_free_trial'];
            $final_days = 365 + $extended_days;
            $subscription_start_date = date('Y-m-d h:i:s');
            $subscription_end_date = date('Y-m-d h:i:s', strtotime("+" . $final_days . " days"));
            $ccdata['discount_code'] = $coupon_code;
            $ccdata['discount'] = $validate[0]['coupon_free_trial'] . " days";
        } elseif (isset($validate) && $validate[0]['payment_mode'] == "MONTHLY" && $validate[0]['coupon_code_type'] == "DAYS") {
            $one_time_payment = ($member_ship_plan[0]['package_amount']);
            $extended_days = $validate[0]['coupon_free_trial'];
            $final_days = 30 + $extended_days;
            $subscription_start_date = date('Y-m-d h:i:s');
            $subscription_end_date = date('Y-m-d h:i:s', strtotime("+ " . $final_days . " days"));
            $ccdata['discount_code'] = $coupon_code;
            $ccdata['discount'] = $validate[0]['coupon_free_trial'] . " days";
        } else {
            $one_time_payment = ($member_ship_plan[0]['package_amount']);
            $subscription_start_date = date('Y-m-d h:i:s');
            if ($member_ship_plan[0]['package_mode'] == "ANNUALLY") {
                $subscription_end_date = date('Y-m-d h:i:s', strtotime("+365 days"));
            } else {
                $subscription_end_date = date('Y-m-d h:i:s', strtotime("+30 days"));
            }
            $ccdata['discount_code'] = '';
            $ccdata['discount'] = '0';
        }
        $ccdata['amount'] = $this->basic_model->calculate_tax_amount($one_time_payment);
        $this->load->model('aim_model');

        $payment_status_one_time = $this->aim_model->ChargeCreditCard($ccdata, $email, '0');
        $transaction_data = array();
        if (isset($payment_status_one_time) && $payment_status_one_time['code'] == "error") {
            $_SESSION['postdata'] = $_POST;
            $this->session->set_flashdata('error', '<p class="alert alert-danger text-left">' . $payment_status_one_time['message'] . '</p>');
            redirect(COMPANY_URL . 'expired');
            exit;
        } elseif (isset($payment_status_one_time) && $payment_status_one_time['code'] == "success") {
            $transaction_data['transaction_number'] = $payment_status_one_time['transaction_id'];
            $transaction_data['approval_code'] = $payment_status_one_time['approval_code'];
            $transaction_data['sub_total'] = $payment_status_one_time['data']['x_amount'];
            $transaction_data['package_id'] = $membership_plan;
            if (isset($tax) && $tax > 0) {
                $transaction_data['tax'] = $tax;
            }
            $transaction_data['transaction_description'] = $payment_status_one_time['data']['x_description'];
            $additional_data['subscription_start_date'] = $subscription_start_date;
            $additional_data['subscription_end_date'] = $subscription_end_date;
            $transaction_data['subscription_start_date'] = $subscription_start_date;
            $transaction_data['subscription_end_date'] = $subscription_end_date;
            $transaction_data['user_id'] = $current_user->user_id;
            $transaction_data['user_role'] = $current_user->user_role;
            $transaction_data['transaction_date'] = date('Y-m-d h:i:s');
            $transaction_data['paid_by_userid'] = $current_user->user_id;
        }
        if (isset($is_subscription) && $is_subscription == "1") {
            if ($member_ship_plan[0]['package_mode'] == "ANNUALLY") {
                $ccdata['length'] = 12;
            } else {
                $ccdata['length'] = 1;
            }
            $payment_status = $this->basic_model->set_authorize_subscription($ccdata, $subscription_start_date, $subscription_end_date, $this->basic_model->calculate_tax_amount($member_ship_plan[0]['package_amount']));
            if (isset($payment_status) && $payment_status['code'] == "error") {
                $this->session->set_flashdata('error', $payment_status['message']);
                redirect(COMPANY_URL . 'expired');
                exit;
            } elseif (isset($payment_status) && $payment_status['code'] == "success") {
                $additional_data['user_current_subscription_id'] = $payment_status['subscription_id'];
            }
        }
        $additional_data['package_id'] = $member_ship_plan[0]['package_id'];
        if (isset($additional_data) && !empty($additional_data)) {
            if ($this->db->update(USERS, $additional_data, "user_id =" . $this->ion_auth->user()->row()->user_id)) {
                $transaction_data['transaction_invoice_number'] = $this->basic_model->generate_invoice_number();
                if ($this->db->insert(TRANSACTIONS, $transaction_data)) {
                    $this->session->set_flashdata('message', '<p class="alert alert-success">Thanks for your purchase. Now your next subscription date is ' . date(DATE_FORMAT, strtotime($subscription_end_date)) . '. </p>');
                    redirect(COMPANY_URL . "invoices");
                }
            }
        }
    }

    function pay_user_subscription() {

        $membership_plan = $this->input->post('membership_plan');
        if (isset($membership_plan) && !empty($membership_plan)) {
            $membership_plan = $membership_plan[0];
        }
        $is_subscription = $this->input->post('is_subscription');
        $final_amount = $this->input->post('final_amount');
        $coupon_code = $this->input->post('coupon_code');
        $first_name = $this->input->post('first_name');
        $last_name = $this->input->post('last_name');

        $card_number = $this->input->post('card_number');
        $expiration_date = $this->input->post('expiration_date');
        $cvv_code = $this->input->post('cvv_code');
        $address = $this->input->post('address');
        $user_type = $this->input->post('user_type');
        $zip_code = $this->input->post('zip_code');
        $puser_id = $this->input->post('puser_id');

        $current_user = $this->ion_auth->user()->row();
        $ccdata['first_name'] = $first_name;
        $ccdata['last_name'] = $last_name;
        $ccdata['card_number'] = $card_number;
        $ccdata['expiration_date'] = $expiration_date;
        //
        $ccdata['cvv_code'] = $cvv_code;
        $ccdata['expiration_date'] = $expiration_date;
        $ccdata['address'] = $address;
        $ccdata['zip_code'] = $zip_code;
        $ccdata['email'] = $current_user->user_email;
        $email = $current_user->user_email;


        $member_ship_plan = $this->basic_model->get_membership_package_details($membership_plan);

        $plan_type = $member_ship_plan[0]['package_mode'];
        if (isset($plan_type) && !empty($plan_type)) {
            $ccdata['package_mode'] = $plan_type;
        }
        if ($user_type == "C") {
            $p_c_type = "COMPANY";
        } else {
            $p_c_type = "USER";
        }
        $additional_data = array();
        if (isset($coupon_code) && !empty($coupon_code)) {
            $validate = $this->basic_model->validate_coupon($coupon_code, $p_c_type, $plan_type);
        }

        if (isset($validate) && !empty($validate)) {
            if ($validate[0]['coupon_code_type'] == "AMOUNT") {

            }
        } else {

        }


        if (isset($validate) && $validate[0]['payment_mode'] == "ANNUALLY" && $validate[0]['coupon_code_type'] == "AMOUNT") {

            $one_time_payment = ($member_ship_plan[0]['package_amount']) * ((100 - ($validate[0]['discount_percentage'])) / 100);
            $subscription_start_date = date('Y-m-d h:i:s');
            $subscription_end_date = date('Y-m-d h:i:s', strtotime("+365 days"));
            $ccdata['discount_code'] = $coupon_code;
            $ccdata['discount'] = $validate[0]['discount_percentage'] . "%";
        } elseif (isset($validate) && $validate[0]['payment_mode'] == "MONTHLY" && $validate[0]['coupon_code_type'] == "AMOUNT") {
            echo "entered1";
            $one_time_payment = ($member_ship_plan[0]['package_amount']) * ((100 - ($validate[0]['discount_percentage'])) / 100);
            $subscription_start_date = date('Y-m-d h:i:s');
            $subscription_end_date = date('Y-m-d h:i:s', strtotime("+30 days"));
            $ccdata['discount_code'] = $coupon_code;
            $ccdata['discount'] = $validate[0]['discount_percentage'] . "%";
        } elseif (isset($validate) && $validate[0]['payment_mode'] == "ANNUALLY" && $validate[0]['coupon_code_type'] == "DAYS") {

            $one_time_payment = ($member_ship_plan[0]['package_amount']);
            $extended_days = $validate[0]['coupon_free_trial'];
            $final_days = 365 + $extended_days;
            $subscription_start_date = date('Y-m-d h:i:s');
            $subscription_end_date = date('Y-m-d h:i:s', strtotime("+" . $final_days . " days"));
            $ccdata['discount_code'] = $coupon_code;
            $ccdata['discount'] = $validate[0]['coupon_free_trial'] . " days";
        } elseif (isset($validate) && $validate[0]['payment_mode'] == "MONTHLY" && $validate[0]['coupon_code_type'] == "DAYS") {

            $one_time_payment = ($member_ship_plan[0]['package_amount']);
            $extended_days = $validate[0]['coupon_free_trial'];
            $final_days = 30 + $extended_days;
            $subscription_start_date = date('Y-m-d h:i:s');
            $subscription_end_date = date('Y-m-d h:i:s', strtotime("+ " . $final_days . " days"));
            $ccdata['discount_code'] = $coupon_code;
            $ccdata['discount'] = $validate[0]['coupon_free_trial'] . " days";
        } else {

            $one_time_payment = ($member_ship_plan[0]['package_amount']);
            $subscription_start_date = date('Y-m-d h:i:s');
            if ($member_ship_plan[0]['package_mode'] == "ANNUALLY") {
                $subscription_end_date = date('Y-m-d h:i:s', strtotime("+365 days"));
            } else {
                $subscription_end_date = date('Y-m-d h:i:s', strtotime("+30 days"));
            }
            $ccdata['discount_code'] = '';
            $ccdata['discount'] = '0';
        }
        $ccdata['amount'] = $one_time_payment;

        $this->load->model('aim_model');

        $payment_status_one_time = $this->aim_model->ChargeCreditCard($ccdata, $email, '0');
        $transaction_data = array();
        if (isset($payment_status_one_time) && $payment_status_one_time['code'] == "error") {
            $_SESSION['postdata'] = $_POST;
            $this->session->set_flashdata('error', $payment_status_one_time['message']);
            redirect(COMPANY_URL . 'makeuserpayment/' . $puser_id);
            exit;
        } elseif (isset($payment_status_one_time) && $payment_status_one_time['code'] == "success") {
            $transaction_data['transaction_number'] = $payment_status_one_time['transaction_id'];
            $transaction_data['approval_code'] = $payment_status_one_time['approval_code'];
            $transaction_data['sub_total'] = $payment_status_one_time['data']['x_amount'];
            $transaction_data['package_id'] = $membership_plan;
            $transaction_data['transaction_description'] = $payment_status_one_time['data']['x_description'];
            $additional_data['subscription_start_date'] = date('Y-m-d h:i:s', strtotime($subscription_start_date));
            $additional_data['subscription_end_date'] = date('Y-m-d h:i:s', strtotime($subscription_end_date));
            $transaction_data['subscription_start_date'] = $subscription_start_date;
            $transaction_data['subscription_end_date'] = $subscription_end_date;
            $transaction_data['user_id'] = $puser_id;
            $transaction_data['user_role'] = $current_user->user_role;
            $transaction_data['transaction_date'] = date('Y-m-d h:i:s');
            $transaction_data['paid_by_userid'] = $current_user->user_id;
        }
        if (isset($is_subscription) && $is_subscription == "1") {
            if ($member_ship_plan[0]['package_mode'] == "ANNUALLY") {
                $ccdata['length'] = 12;
            } else {
                $ccdata['length'] = 1;
            }
            $payment_status = $this->basic_model->set_authorize_subscription($ccdata, $subscription_start_date, $subscription_end_date, $member_ship_plan[0]['package_amount']);
            if (isset($payment_status) && $payment_status['code'] == "error") {
                $this->session->set_flashdata('error', $payment_status['message']);
                redirect(COMPANY_URL . 'makeuserpayment/' . $puser_id);
                exit;
            } elseif (isset($payment_status) && $payment_status['code'] == "success") {

                $additional_data['user_current_subscription_id'] = $payment_status['subscription_id'];
            }
        }
        $additional_data['package_id'] = $member_ship_plan[0]['package_id'];
        if (isset($additional_data) && !empty($additional_data)) {
            if ($this->db->update(USERS, $additional_data, "user_id =" . $puser_id)) {
                $transaction_data['transaction_invoice_number'] = $this->basic_model->generate_invoice_number();
                if ($this->db->insert(TRANSACTIONS, $transaction_data)) {
                    $this->session->set_flashdata('message', 'Thanks for your purchase. Now your next subscription date is ' . date(DATE_FORMAT, strtotime($subscription_end_date)) . '.');
                    redirect(COMPANY_URL . 'user_transaction/' . base64_encode($puser_id));
                }
            }
        }
    }

    function dashboard() {
        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect(SITE_URL, 'refresh');
            exit;
        } else {
            $this->load->model('template_model');
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
            }
            $subscription_check = $this->basic_model->is_subscription_expired($current_user->user_id);
            if ($subscription_check < 2) {
                redirect(COMPANY_URL . "expired");
                exit;
            }

            $company_details = $this->basic_model->get_company_profile_details($current_user->user_id);
            $role_name = $this->basic_model->get_user_role($current_user->user_role);
            $this->data['template_list'] = $this->template_model->get_templates($company_details['company_id'], false);
            $this->load->model('company_model');
            if (isset($this->data['company_details']) && !empty($this->data['company_details'])) {
                $company_details = $this->data['company_details'];
            }

            $existing_groups = $this->basic_model->get_group_dropdown($company_details['company_id']);
            $this->data['groups'] = $existing_groups;
            $this->data['company_list'] = $this->company_model->get_userlist($company_details['company_id']);
            $this->sidebardata['is_active'] = 'dashboard';
            $this->sidebardata["role_name"] = $role_name;

            $this->headerdata['page_title'] = "Dashboard";

            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
            $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
            $this->templatelayout->get_admin_dashboard_header($this->headerdata);
            $this->templatelayout->get_admin_dashboard_footer();
            $this->templatelayout->get_admin_dashboard_sidebar('companysidebar', $this->sidebardata);
            $this->elements['middle'] = 'company/dashboard';
            $this->elements_data['middle'] = $this->data;
            $this->layout->setLayout('backend_layout/dashboardlayout');
            $this->layout->multiple_view($this->elements, $this->elements_data);
        }
    }

    function invoices() {
        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect(SITE_URL, 'refresh');
            exit;
        } else {

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

                $subscription_check = $this->basic_model->is_subscription_expired($current_user->user_id);
                if ($subscription_check < 2) {
                    redirect(COMPANY_URL . "expired");
                    exit;
                }

                $role_name = $this->basic_model->get_user_role($current_user->user_role);
                $this->load->model('company_model');
                $this->load->model('sadmin_model');
                $this->data['script_to_include'] = "company_js.js";
                $this->sidebardata['is_active'] = 'invoices';
                $this->sidebardata["role_name"] = $role_name;
                $this->sidebardata["username"] = $current_user->account_holder_name != "" ? $current_user->account_holder_name : $current_user->username;
                if (isset($this->data['company_details']) && !empty($this->data['company_details'])) {
                    $company_details = $this->data['company_details'];
                }
                $this->headerdata['page_title'] = "Invoices";
                $this->headerdata['breadcrumbs'] = array(COMPANY_URL, array('dashboard', 'Dashboard'), array('invoices', 'Invoices'));
                $this->templatelayout->get_admin_dashboard_header($this->headerdata);
                $this->templatelayout->get_admin_dashboard_footer();
                $this->templatelayout->get_admin_dashboard_sidebar('companysidebar', $this->sidebardata);
                $invoices = $this->sadmin_model->company_transactions($current_user->user_id);
                $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
                $this->data['error'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('error')));
                if (isset($invoices) && count($invoices) > 0) {
                    $this->data['invoices'] = $invoices;
                }
                $this->elements['middle'] = 'company/invoices';
                $this->elements_data['middle'] = $this->data;
                $this->layout->setLayout('backend_layout/dashboardlayout');
                $this->layout->multiple_view($this->elements, $this->elements_data);
            }
        }
    }

    public function get_invoice() {
        $invoice_id = $this->uri->segment(3, 0);
        $this->load->model('company_model');
        $invoice_data = $this->company_model->get_invoice_detail($invoice_id);
        $na = "N/A";
        $str = '<div style="width:100% !important;">
		<table style="width:100% !important;" cellpadding="0" cellspacing="0">
		<tr>
		<td style="width:48% !important;text-align:left!important;"><img src="' . IMAGES_URL . 'logo-bettermynd-left.png" border="0" alt="' . SITE_NAME . '"  /></td>
		<td style="width:48% !important;text-align:right!important;"></td>
		</tr></table>
		<br/>
		<table align="left" cellpadding="0" cellspacing="0" style="width:100% !important;">
		<tr>
		<td style="width:20% !important;border:solid 1px #a5a5a5 !important;padding-left:1% !important;"><strong>Customer Name</strong></td><td  style="width:20% !important;border:solid 1px #a5a5a5 !important;padding-left:1% !important;">' . $invoice_data['account_holder_name'] . '</td><td  style="width:20% !important;">&nbsp;</td><td  style="width:20% !important;border:solid 1px #a5a5a5 !important;padding-left:1% !important;"><strong>Invoice No.</strong></td><td  style="width:20% !important;border:solid 1px #a5a5a5 !important;padding-left:1% !important;">' . $invoice_data['user_transaction_id'] . '</td>
		</tr>
		<tr>
		<td style="width:20% !important;border:solid 1px #a5a5a5 !important;padding-left:1% !important;"><strong>Customer ID</strong></td><td  style="width:20% !important;border:solid 1px #a5a5a5 !important;padding-left:1% !important;">' . $invoice_data['user_id'] . '</td><td  style="width:20% !important;">&nbsp;</td><td  style="width:20% !important;border:solid 1px #a5a5a5 !important;padding-left:1% !important;"><strong>Date</strong></td><td  style="width:20% !important;border:solid 1px #a5a5a5 !important;padding-left:1% !important;">' . date(DATE_FORMAT, strtotime($invoice_data['transaction_date'])) . '</td>
		</tr>
		</table>
		<br/><hr><br/>
		<table cellpadding="0" cellspacing="0" style="width:100% !important;">
		<thead>
		<th style="border:solid 1px #a5a5a5 !important;padding-left:1% !important;">Transaction #</th>
		<th style="border:solid 1px #a5a5a5 !important;padding-left:1% !important;">Description</th>
		<th style="border:solid 1px #a5a5a5 !important;padding-right:1% !important;text-align:right !important;">Amount</th>
		</thead>
		<tr>
		<td style="border:solid 1px #a5a5a5 !important;padding-left:1% !important;">' . $invoice_data['transaction_number'] . '</td>
		<td style="border:solid 1px #a5a5a5 !important;padding-left:1% !important;">' . (isset($invoice_data['transaction_description']) ? $invoice_data['transaction_description'] : '') . '</td>
		<td style="border:solid 1px #a5a5a5 !important;padding-right:1% !important;text-align:right !important;">' . CURRENCY_SYMBOL . ' ' . $invoice_data['sub_total'] . '</td>
		</tr>
		</table><br/>
		<table cellpadding="0" cellspacing="0" style="width:100% !important;">
		<tr>
		<td style="border:solid 1px #a5a5a5 !important;width:50% !important;text-align:left !important;padding-left:1% !important;"><strong>Total</strong></td>
		<td style="border:solid 1px #a5a5a5 !important;width:50% !important;text-align:right !important;padding-right:1% !important;">' . CURRENCY_SYMBOL . ' ' . $invoice_data['sub_total'] . '</td>

		</tr>
		</table>
		</div>
	<div class="clearfix"></div>';
        echo $str;
    }

    function export_invoice($transaction_id) {
        $transaction_id = $this->uri->segment(3, 0);
        if (isset($transaction_id) || !empty($transaction_id)) {

            $this->load->model('company_model');

            $current_user = $this->ion_auth->user()->row();
            $role_name = $this->basic_model->get_user_role($current_user->user_role);
            $invoice_data = $this->company_model->get_transaction_detail($transaction_id);
            if (isset($invoice_data) && !empty($invoice_data)) {

                $this->data['heading'] = 'Invoice';
                $this->data['invoice_data'] = $invoice_data;
                $this->data['transaction_id'] = $transaction_id;
                $this->sidebardata['is_active'] = 'invoices';
                $this->sidebardata["role_name"] = $role_name;
                $this->headerdata['page_title'] = 'Invoice';
                $this->headerdata['breadcrumbs'] = array(COMPANY_URL, array('dashboard', 'Dashboard'), array('invoices', 'Invoices'));
                $this->templatelayout->get_admin_dashboard_header($this->headerdata);
                $this->templatelayout->get_admin_dashboard_footer();
                $this->templatelayout->get_admin_dashboard_sidebar('companysidebar', $this->sidebardata);
                $company_details = $this->basic_model->get_company_profile_details($current_user->user_id);
                if (isset($this->data['company_details']) && !empty($this->data['company_details'])) {
                    $company_details = $this->data['company_details'];
                }

                $this->elements['middle'] = 'company/company_invoice';
                $this->elements_data['middle'] = $this->data;
                $this->layout->setLayout('backend_layout/dashboardlayout');
                $this->layout->multiple_view($this->elements, $this->elements_data);
            } else {

                redirect(COMPANY_URL . "dashboard");
                exit;
            }
        } else {

            redirect(COMPANY_URL . "dashboard");
            exit;
        }
    }

    function download_invoice($transaction_id) {
        $transaction_id = $this->uri->segment(3, 0);
        if (isset($transaction_id) && !empty($transaction_id)) {
            $this->load->model('company_model');

            $invoice_data = $this->company_model->get_transaction_detail($transaction_id);
            if (isset($invoice_data) && !empty($invoice_data)) {
                $data['invoice_data'] = $invoice_data;


                $html = $this->load->view('company/print_invoice', $data, true);
                $path = MPDF_PATH . 'mpdf.php';
                include($path);
                $mpdf = new mPDF('utf-8', 'A4', 5, 5, 5, 5);
                $mpdf->SetTitle("Transaction-" . $invoice_data['transaction_number']);
                $mpdf->WriteHTML($html);
                $filename = "Transaction-" . $invoice_data['transaction_number'] . ".pdf";
                $mpdf->Output($filename, 'D');
                exit;
            } else {
                redirect(COMPANY_URL . "dashboard");
                exit;
            }
        } else {
            redirect(COMPANY_URL . "dashboard");
            exit;
        }
    }

    function profile() {
        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect(SITE_URL, 'refresh');
            exit;
        } else {

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
                $subscription_check = $this->basic_model->is_subscription_expired($current_user->user_id);
                if ($subscription_check < 2) {
                    redirect(COMPANY_URL . "expired");
                    exit;
                }

                $role_name = $this->basic_model->get_user_role($current_user->user_role);
                $this->load->model('company_model');
                $states = $this->basic_model->get_state_list();
                $this->data['action'] = array(
                    'name' => 'action',
                    'id' => 'action',
                    'type' => 'hidden',
                    'value' => 'action'
                );
                $this->data['username'] = array(
                    'name' => 'username',
                    'id' => 'username',
                    'type' => 'text',
                    'class' => 'form-control',
                    'value' => $current_user->username,
                    'disabled' => 'disabled'
                );
                $this->data['user_id'] = array(
                    'name' => 'user_id',
                    'id' => 'user_id',
                    'type' => 'hidden',
                    'class' => 'form-control',
                    'value' => $current_user->user_id
                );
                $this->data['account_holder_name'] = array(
                    'name' => 'account_holder_name',
                    'id' => 'account_holder_name',
                    'type' => 'text',
                    'maxlength' => '100',
                    'class' => 'form-control',
                    'value' => $current_user->account_holder_name
                );
                $this->data['user_email'] = array(
                    'name' => 'user_email',
                    'id' => 'user_email',
                    'type' => 'text',
                    'maxlength' => '200',
                    'class' => 'form-control',
                    'value' => $current_user->user_email
                );
                $this->data['office_phone'] = array(
                    'name' => 'office_phone',
                    'id' => 'office_phone',
                    'type' => 'text',
                    'maxlength' => '16',
                    'class' => 'form-control',
                    'value' => isset($current_user->office_phone) && $current_user->office_phone != "" ? $current_user->office_phone : ''
                );
                $this->data['mobile_phone'] = array(
                    'name' => 'mobile_phone',
                    'id' => 'mobile_phone',
                    'type' => 'text',
                    'class' => 'form-control phone_number',
                    'value' => isset($current_user->mobile_phone) && $current_user->mobile_phone != "" ? $current_user->mobile_phone : ''
                );
                $this->data['address'] = array(
                    'name' => 'address',
                    'id' => 'address',
                    'type' => 'text',
                    'maxlength' => '200',
                    'class' => 'form-control',
                    'value' => isset($current_user->address) && $current_user->address != "" ? $current_user->address : ''
                );
                $this->data['zipcode'] = array(
                    'name' => 'zipcode',
                    'id' => 'zipcode',
                    'type' => 'text',
                    'maxlength' => '8',
                    'class' => 'form-control',
                    'value' => isset($current_user->zipcode) && $current_user->zipcode != "" ? $current_user->zipcode : ''
                );
                $this->data['website'] = array(
                    'name' => 'website',
                    'id' => 'website',
                    'type' => 'text',
                    'maxlength' => '200',
                    'class' => 'form-control',
                    'value' => isset($current_user->website) && $current_user->website != "" ? $current_user->website : ''
                );
                $this->data['fax_number'] = array(
                    'name' => 'fax_number',
                    'id' => 'fax_number',
                    'type' => 'text',
                    'maxlength' => '16',
                    'class' => 'form-control',
                    'value' => isset($current_user->fax_number) && $current_user->fax_number != "" ? $current_user->fax_number : ''
                );
                $this->data['profilepic'] = array(
                    'name' => 'profilepic',
                    'type' => 'text',
                    'class' => 'form-control',
                    'readonly' => 'readonly',
                    'placeholder' => "Browse",
                    'value' => isset($current_user->profile_photo) && $current_user->profile_photo != "" ? $current_user->profile_photo : ''
                );
                $this->data['companylogo'] = array(
                    'name' => 'companylogo',
                    'type' => 'text',
                    'class' => 'form-control',
                    'readonly' => 'readonly',
                    'placeholder' => "Browse",
                    'value' => isset($current_user->company_logo2) && $current_user->company_logo2 != "" ? $current_user->company_logo2 : ''
                );
                $this->data['fb_url'] = array(
                    'name' => 'fb_url',
                    'id' => 'fb_url',
                    'type' => 'text',
                    'maxlength' => '200',
                    'class' => 'form-control',
                    'placeholder' => 'Facebook Url',
                    'value' => isset($current_user->fb_url) && $current_user->fb_url != "" ? $current_user->fb_url : ''
                );
                $this->data['twitter_url'] = array(
                    'name' => 'twitter_url',
                    'id' => 'twitter_url',
                    'type' => 'text',
                    'maxlength' => '200',
                    'class' => 'form-control',
                    'placeholder' => 'Twitter Url',
                    'value' => isset($current_user->twitter_url) && $current_user->twitter_url != "" ? $current_user->twitter_url : ''
                );
                $this->data['linkedin_url'] = array(
                    'name' => 'linkedin_url',
                    'id' => 'linkedin_url',
                    'type' => 'text',
                    'maxlength' => '200',
                    'class' => 'form-control',
                    'placeholder' => 'Linkedin Url',
                    'value' => isset($current_user->linkedin_url) && $current_user->linkedin_url != "" ? $current_user->linkedin_url : ''
                );
                $this->data['youtube_url'] = array(
                    'name' => 'youtube_url',
                    'id' => 'youtube_url',
                    'type' => 'text',
                    'class' => 'form-control',
                    'placeholder' => 'Youtube Url',
                    'value' => isset($current_user->youtube_url) && $current_user->youtube_url != "" ? $current_user->youtube_url : ''
                );

                $this->data['heading'] = 'My Profile';
                $this->data['newsletter'] = $current_user->is_newsletter;
                $this->data['biography'] = $current_user->biography;
                $this->data['biography_length'] = isset($current_user->biography) && $current_user->biography != "" ? 500 - strlen($current_user->biography) : '500';
                $this->data['states'] = $states;

                $this->data['reset_password_link'] = "<a href='#' class='btn btn-primary changepassword'   role='button' data-toggle='modal' data-id='" . $current_user->user_id . "' data-email='" . $current_user->user_email . "'>CHANGE PASSWORD</a>";
                $this->data['state'] = isset($current_user->state) && $current_user->state != "" ? $current_user->state : '';
                $this->data['script_to_include'] = "company_js.js";
                $this->data['btn_label'] = isset($current_user->account_holder_name) && $current_user->account_holder_name != "" ? lang('edit_user_submit_btn') : lang('edit_company_profile_submit_label');
                $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
                $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
                if (isset($this->data['company_details']) && !empty($this->data['company_details'])) {
                    $company_details = $this->data['company_details'];
                }

                $this->sidebardata['is_active'] = 'profile';
                $this->sidebardata["role_name"] = $role_name;
                $this->sidebardata["username"] = $current_user->account_holder_name != "" ? $current_user->account_holder_name : $current_user->username;
                $this->headerdata['page_title'] = 'My Profile';
                $this->headerdata['breadcrumbs'] = array(COMPANY_URL, array('dashboard', 'Dashboard'), array('profile', 'My Profile'));
                $this->templatelayout->get_admin_dashboard_header($this->headerdata);
                $this->templatelayout->get_admin_dashboard_footer();
                $this->templatelayout->get_admin_dashboard_sidebar('companysidebar', $this->sidebardata);
                $this->elements['middle'] = 'company/profile';
                $this->elements_data['middle'] = $this->data;
                $this->layout->setLayout('backend_layout/dashboardlayout');
                $this->layout->multiple_view($this->elements, $this->elements_data);
            }
        }
    }

    function update_profile() {
        $action = $this->input->post('action');
        if (!isset($action)) {
            redirect(COMPANY_URL . "profile", 'refresh');
            exit;
        }
        if (isset($action)) {

            $this->load->model('sadmin_model');
            $this->load->model('company_model');
            if ($this->sadmin_model->email_check()) {
                $this->company_model->update_profile();
            } else {
                $this->session->set_flashdata('error', "Email id you entered is already exist please try with other email address.");
            }
            redirect(COMPANY_URL . "profile");
        }
    }

    function changepassword() {
        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect(SITE_URL, 'refresh');
            exit;
        } else {
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
                $subscription_check = $this->basic_model->is_subscription_expired($current_user->user_id);
                if ($subscription_check < 2) {
                    redirect(COMPANY_URL . "expired");
                    exit;
                }
                $role_name = $this->basic_model->get_user_role($current_user->user_role);

                $this->data['script_to_include'] = "company_js.js";
                $this->sidebardata['is_active'] = 'changepassword';
                $this->sidebardata["role_name"] = $role_name;
                if (isset($this->data['company_details']) && !empty($this->data['company_details'])) {
                    $company_details = $this->data['company_details'];
                }
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
                    //'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
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
                    'value' => $current_user->user_id,
                );
                $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
                $this->data['error'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('error')));
                $this->headerdata['page_title'] = "Change Password";
                $this->headerdata['breadcrumbs'] = array(COMPANY_URL, array('dashboard', 'Dashboard'), array('changepassword', 'Change Password'));
                $this->templatelayout->get_admin_dashboard_header($this->headerdata);
                $this->templatelayout->get_admin_dashboard_footer();
                $this->templatelayout->get_admin_dashboard_sidebar('companysidebar', $this->sidebardata);

                $this->elements['middle'] = 'company/change_password';
                $this->elements_data['middle'] = $this->data;
                $this->layout->setLayout('backend_layout/dashboardlayout');
                $this->layout->multiple_view($this->elements, $this->elements_data);
            }
        }
    }

    function change_password() {
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
                        redirect(COMPANY_URL . "changepassword", 'refresh');
                    } else {
                        $this->session->set_flashdata('message', $this->ion_auth->messages());
                        redirect(COMPANY_URL . "changepassword", 'refresh');
                    }
                } else {
                    $this->session->set_flashdata('message', $this->ion_auth->messages());
                    redirect(COMPANY_URL . "changepassword", 'refresh');
                }
            } else {
                $this->session->set_flashdata('message', $this->ion_auth->errors());
                redirect(COMPANY_URL . "changepassword", 'refresh');
            }
        } else {
            $this->session->set_flashdata('error', (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message'))));
            //$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

            redirect(COMPANY_URL . "changepassword");
        }
    }

    function company_profile() {
        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect(SITE_URL, 'refresh');
            exit;
        } else {
            $this->load->model('company_model');
            if ($this->input->post('action') && $this->input->post('action') != "") {
                $this->company_model->update_company_profile();
                redirect(COMPANY_URL . "company_profile");
            } else {

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
                    $subscription_check = $this->basic_model->is_subscription_expired($current_user->user_id);
                    if ($subscription_check < 2) {
                        redirect(COMPANY_URL . "expired");
                        exit;
                    }

                    $role_name = $this->basic_model->get_user_role($current_user->user_role);
                    $this->sidebardata['is_active'] = 'company_profile';
                    $this->sidebardata["role_name"] = $role_name;
                    $this->sidebardata["username"] = $current_user->account_holder_name != "" ? $current_user->account_holder_name : $current_user->username;
                    $current_user = $this->ion_auth->user()->row();
                    $this->db->select('*');
                    $this->db->from('brandize_user_company');
                    $this->db->where('user_id', $current_user->user_id);
                    $query = $this->db->get();
                    if ($query->num_rows() == 1) {
                        $company_user = $query->result();
                        $company_user = $company_user[0];
                    }

                    $states = $this->basic_model->get_state_list();
                    $this->data['states'] = $states;
                    $this->data['action'] = array(
                        'name' => 'action',
                        'id' => 'action',
                        'type' => 'hidden',
                        'value' => 'action'
                    );
                    $this->data['user_id'] = array(
                        'name' => 'user_id',
                        'id' => 'user_id',
                        'type' => 'hidden',
                        'value' => $current_user->user_id,
                    );
                    $this->data['company_name'] = array(
                        'name' => 'company_name',
                        'id' => 'company_name',
                        'type' => 'text',
                        'maxlength' => '50',
                        'class' => 'form-control',
                        'value' => isset($company_user) && !empty($company_user) && $company_user->company_name != "" ? $company_user->company_name : '',
                    );
                    $url = "http://" . $current_user->username . ".brandize.com";
                    $this->data['company_url_dummy'] = array(
                        'name' => 'company_url_dummy',
                        'id' => 'company_url_dummy',
                        'type' => 'text',
                        'class' => 'form-control',
                        'value' => $url,
                        'disabled' => 'disabled'
                    );
                    $this->data['company_url'] = array(
                        'name' => 'company_url',
                        'id' => 'company_url',
                        'type' => 'hidden',
                        'class' => 'form-control',
                        'value' => $url
                    );

                    $this->data['primary_account_holder'] = array(
                        'name' => 'primary_account_holder',
                        'id' => 'primary_account_holder',
                        'type' => 'text',
                        'maxlength' => '100',
                        'class' => 'form-control',
                        'value' => isset($company_user) && !empty($company_user) && $company_user->primary_account_holder != "" ? $company_user->primary_account_holder : $current_user->account_holder_name
                    );
                    $this->data['company_support_email'] = array(
                        'name' => 'company_support_email',
                        'id' => 'company_support_email',
                        'type' => 'text',
                        'maxlength' => '200',
                        'class' => 'form-control',
                        'value' => isset($company_user) && !empty($company_user) && $company_user->company_support_email != "" ? $company_user->company_support_email : ''
                    );
                    $this->data['company_general_email'] = array(
                        'name' => 'company_general_email',
                        'id' => 'company_general_email',
                        'type' => 'text',
                        'maxlength' => '200',
                        'class' => 'form-control',
                        'value' => isset($company_user) && !empty($company_user) && $company_user->company_general_email != "" ? $company_user->company_general_email : $current_user->user_email
                    );
                    $this->data['office_phone'] = array(
                        'name' => 'office_phone',
                        'id' => 'office_phone',
                        'type' => 'text',
                        'maxlength' => '16',
                        'class' => 'form-control',
                        'value' => isset($company_user) && !empty($company_user) && $company_user->office_phone != "" ? $company_user->office_phone : $current_user->office_phone
                    );
                    $this->data['office_phone2'] = array(
                        'name' => 'office_phone2',
                        'id' => 'office_phone2',
                        'type' => 'text',
                        'maxlength' => '16',
                        'class' => 'form-control',
                        'value' => isset($company_user) && !empty($company_user) && $company_user->office_phone2 != "" ? $company_user->office_phone2 : ''
                    );
                    $this->data['company_address'] = array(
                        'name' => 'company_address',
                        'id' => 'company_address',
                        'type' => 'text',
                        'maxlength' => '200',
                        'class' => 'form-control',
                        'value' => isset($company_user) && !empty($company_user) && $company_user->company_address != "" ? $company_user->company_address : $current_user->address
                    );
                    $this->data['company_zipcode'] = array(
                        'name' => 'company_zipcode',
                        'id' => 'company_zipcode',
                        'type' => 'text',
                        'maxlength' => '8',
                        'class' => 'form-control',
                        'value' => isset($company_user) && !empty($company_user) && $company_user->company_zipcode != "" ? $company_user->company_zipcode : $current_user->zipcode
                    );
                    $this->data['company_website'] = array(
                        'name' => 'company_website',
                        'id' => 'company_website',
                        'type' => 'text',
                        'maxlength' => '200',
                        'class' => 'form-control',
                        'value' => isset($company_user) && !empty($company_user) && $company_user->company_website != "" ? $company_user->company_website : $current_user->website
                    );
                    $this->data['company_fax_number'] = array(
                        'name' => 'company_fax_number',
                        'id' => 'company_fax_number',
                        'type' => 'text',
                        'maxlength' => '16',
                        'class' => 'form-control',
                        'value' => isset($company_user) && !empty($company_user) && $company_user->company_fax_number != "" ? $company_user->company_fax_number : $current_user->fax_number
                    );

                    $this->data['company_logo1'] = array(
                        'name' => 'company_logo1',
                        'type' => 'text',
                        'class' => 'form-control',
                        'readonly' => 'readonly',
                        'placeholder' => "Browse",
                        'value' => isset($company_user) && !empty($company_user) && $company_user->company_logo1 != "" ? $company_user->company_logo1 : $current_user->company_logo2
                    );
                    $this->data['company_logo2'] = array(
                        'name' => 'company_logo2',
                        'type' => 'text',
                        'class' => 'form-control',
                        'readonly' => 'readonly',
                        'placeholder' => "Browse",
                        'value' => isset($company_user) && !empty($company_user) && $company_user->company_logo2 != "" ? $company_user->company_logo2 : ''
                    );
                    $this->data['company_logo1_color1'] = array(
                        'name' => 'company_logo1_color1',
                        'id' => 'company_logo1_color1',
                        'type' => 'hidden',
                        'class' => 'form-control',
                        'readonly' => 'readonly',
                        'value' => isset($company_user) && !empty($company_user) && $company_user->company_logo1_color1 != "" ? $company_user->company_logo1_color1 : ''
                    );
                    $this->data['company_logo1_color2'] = array(
                        'name' => 'company_logo1_color2',
                        'id' => 'company_logo1_color2',
                        'type' => 'hidden',
                        'class' => 'form-control',
                        'readonly' => 'readonly',
                        'value' => isset($company_user) && !empty($company_user) && $company_user->company_logo1_color2 != "" ? $company_user->company_logo1_color2 : ''
                    );
                    $this->data['company_logo2_color1'] = array(
                        'name' => 'company_logo2_color1',
                        'id' => 'company_logo2_color1',
                        'type' => 'hidden',
                        'class' => 'form-control',
                        'readonly' => 'readonly',
                        'value' => isset($company_user) && !empty($company_user) && $company_user->company_logo2_color1 != "" ? $company_user->company_logo2_color1 : ''
                    );
                    $this->data['company_logo2_color2'] = array(
                        'name' => 'company_logo2_color2',
                        'id' => 'company_logo2_color2',
                        'type' => 'hidden',
                        'class' => 'form-control',
                        'readonly' => 'readonly',
                        'value' => isset($company_user) && !empty($company_user) && $company_user->company_logo2_color2 != "" ? $company_user->company_logo2_color2 : ''
                    );
                    $this->data['company_fb_url'] = array(
                        'name' => 'company_fb_url',
                        'id' => 'company_fb_url',
                        'type' => 'text',
                        'maxlength' => '200',
                        'class' => 'form-control',
                        'placeholder' => 'Facebook Url',
                        'value' => isset($company_user) && !empty($company_user) && $company_user->company_fb_url != "" ? $company_user->company_fb_url : $current_user->fb_url
                    );
                    $this->data['company_twitter_url'] = array(
                        'name' => 'company_twitter_url',
                        'id' => 'company_twitter_url',
                        'type' => 'text',
                        'maxlength' => '200',
                        'class' => 'form-control',
                        'placeholder' => 'Twitter Url',
                        'value' => isset($company_user) && !empty($company_user) && $company_user->company_twitter_url != "" ? $company_user->company_twitter_url : $current_user->twitter_url
                    );
                    $this->data['company_linkedin_url'] = array(
                        'name' => 'company_linkedin_url',
                        'id' => 'company_linkedin_url',
                        'type' => 'text',
                        'maxlength' => '200',
                        'class' => 'form-control',
                        'placeholder' => 'Linkedin Url',
                        'value' => isset($company_user) && !empty($company_user) && $company_user->company_linkedin_url != "" ? $company_user->company_linkedin_url : $current_user->linkedin_url
                    );
                    $this->data['company_youtube_url'] = array(
                        'name' => 'company_youtube_url',
                        'id' => 'company_youtube_url',
                        'type' => 'text',
                        'maxlength' => '200',
                        'class' => 'form-control',
                        'placeholder' => 'Youtube Url',
                        'value' => isset($company_user) && !empty($company_user) && $company_user->company_youtube_url != "" ? $company_user->company_youtube_url : $current_user->youtube_url
                    );
                    $this->data['company_licence_number'] = array(
                        'name' => 'company_licence_number',
                        'id' => 'company_licence_number',
                        'type' => 'text',
                        'maxlength' => '200',
                        'class' => 'form-control',
                        'value' => isset($company_user) && !empty($company_user) && $company_user->company_licence_number != "" ? $company_user->company_licence_number : ''
                    );

                    $dirname = ASSETS_PATH . "images/icons/";
                    $images = glob($dirname . "*.svg");

                    $this->data['feature_icons'] = $images;
                    $this->data['logo1_color1'] = isset($company_user) && !empty($company_user) && $company_user->company_logo1_color1 != "" ? $company_user->company_logo1_color1 : '#f4f4f4';
                    $this->data['logo1_color2'] = isset($company_user) && !empty($company_user) && $company_user->company_logo1_color2 != "" ? $company_user->company_logo1_color2 : '#f4f4f4';
                    $this->data['logo2_color1'] = isset($company_user) && !empty($company_user) && $company_user->company_logo2_color1 != "" ? $company_user->company_logo2_color1 : '#f4f4f4';
                    $this->data['logo2_color2'] = isset($company_user) && !empty($company_user) && $company_user->company_logo2_color2 != "" ? $company_user->company_logo2_color2 : '#f4f4f4';
                    $this->data['company_desc'] = isset($company_user) && !empty($company_user) && $company_user->company_desc != "" ? $company_user->company_desc : '';
                    $this->data['bullet_icon'] = isset($company_user) && !empty($company_user) && $company_user->bullet_icon != "" ? $company_user->bullet_icon : '';
                    $this->data['company_mission_stmt'] = isset($company_user) && !empty($company_user) && $company_user->company_mission_stmt != "" ? $company_user->company_mission_stmt : '';
                    $this->data['company_state'] = isset($company_user) && !empty($company_user) && $company_user->company_state != "" ? $company_user->company_state : '';

                    $this->data['company_heading'] = isset($company_user) && !empty($company_user) ? $this->company_model->get_company_heading($company_user->company_id) : '';
                    $this->data['company_bullets'] = isset($company_user) && !empty($company_user) ? $this->company_model->get_company_bullets($company_user->company_id) : '';
                    $this->data['company_feature'] = isset($company_user) && !empty($company_user) ? $this->company_model->get_company_feature($company_user->company_id) : '';

                    $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
                    $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
                    $this->data['script_to_include'] = "company_js.js";
                    $this->headerdata['page_title'] = "Company Profile";
                    $this->headerdata['breadcrumbs'] = array(COMPANY_URL, array('dashboard', 'Dashboard'), array('company_profile', 'Company Profile'));
                    $this->templatelayout->get_admin_dashboard_header($this->headerdata);
                    $this->templatelayout->get_admin_dashboard_footer();
                    $this->templatelayout->get_admin_dashboard_sidebar('companysidebar', $this->sidebardata);
                    if (isset($this->data['company_details']) && !empty($this->data['company_details'])) {
                        $company_details = $this->data['company_details'];
                    }
                    $this->elements['middle'] = 'company/company_profile';
                    $this->elements_data['middle'] = $this->data;
                    $this->layout->setLayout('backend_layout/dashboardlayout');
                    $this->layout->multiple_view($this->elements, $this->elements_data);
                }
            }
        }
    }

    function getcontent($el_id = false, $limit = false) {
        $this->load->model('company_model');
        $str = $this->company_model->geticon($el_id, $limit);
        echo $str;
        exit;
    }

    function delete_company_heading() {
        $this->load->model('company_model');
        $return = $this->company_model->delete_heading();
        echo $return;
        die;
    }

    function delete_company_bullet() {
        $this->load->model('company_model');
        $return = $this->company_model->delete_bullet();
        echo $return;
        die;
    }

    function delete_company_feature() {
        $this->load->model('company_model');
        $return = $this->company_model->delete_feature();
        echo $return;
        die;
    }

    function users() {
        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect(SITE_URL, 'refresh');
            exit;
        } else {
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
                $subscription_check = $this->basic_model->is_subscription_expired($current_user->user_id);
                if ($subscription_check < 2) {
                    redirect(COMPANY_URL . "expired");
                    exit;
                }

                $role_name = $this->basic_model->get_user_role($current_user->user_role);
                $this->sidebardata["role_name"] = $role_name;
                $this->sidebardata['is_active'] = 'users';
                $this->load->model('company_model');

                $company_details = $this->basic_model->get_company_profile_details($current_user->user_id);
                $existing_groups = $this->basic_model->get_group_dropdown($company_details['company_id']);

                $this->data['company_list'] = $this->company_model->get_userlist($company_details['company_id']);

                $this->data['groups'] = $existing_groups;
                $this->data['script_to_include'] = "company_js.js";

                $company_details = $this->basic_model->get_company_profile_details($current_user->user_id);
                if (isset($company_details) && !empty($company_details)) {
                    $this->data['company_details'] = $company_details;
                }
                $this->headerdata['page_title'] = "Users List";
                $this->headerdata['breadcrumbs'] = array(COMPANY_URL, array('dashboard', 'Dashboard'), array('users', 'Users'));
                $this->templatelayout->get_admin_dashboard_header($this->headerdata);
                $this->templatelayout->get_admin_dashboard_footer();
                $this->templatelayout->get_admin_dashboard_sidebar('companysidebar', $this->sidebardata);
                $this->data['message'] = $this->session->flashdata('message');
                $this->data['error'] = $this->session->flashdata('error');
                $this->elements['middle'] = 'company/users_list';
                $this->elements_data['middle'] = $this->data;
                $this->layout->setLayout('backend_layout/dashboardlayout');
                $this->layout->multiple_view($this->elements, $this->elements_data);
            }
        }
    }

    function edit_user($user_id = false) {
        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect(SITE_URL, 'refresh');
            exit;
        } else {
            $this->load->model('company_model');
            $this->load->model('sadmin_model');
            if ($this->input->post('action') && $this->input->post('action') != "") {
                $this->form_validation->set_rules('level', 'User level field is required.', 'required');

                if ($this->form_validation->run() == true) {
                    $user_id = $this->input->post('user_id');
                    if ($this->sadmin_model->email_check()) {
                        $this->company_model->update_user();
                    } else {
                        $this->session->set_flashdata('error', "Email id you entered is already exist please try with other email address.");
                        redirect(COMPANY_URL . "edit_user/" . $user_id);
                    }

                    redirect(COMPANY_URL . "users");
                }
            } else {
                $current_user = $this->basic_model->get_userinfo($user_id);
                $company_user = $this->ion_auth->user()->row();
                if ($company_user->user_role != "2") {
                    if ($company_user->user_role == "1") {
                        redirect(SADMIN_URL . "dashboard", 'refresh');
                        exit;
                    } elseif ($company_user->user_role == "3") {
                        redirect(USER_URL . "dashboard");
                    } elseif ($company_user->user_role == "4") {
                        redirect(AFFILIATE_URL . "dashboard");
                    } elseif ($company_user->user_role == "5") {
                        redirect(ADMIN_URL . "dashboard");
                    }
                } else {
                    $subscription_check = $this->basic_model->is_subscription_expired($company_user->user_id);
                    if ($subscription_check < 2) {
                        redirect(COMPANY_URL . "expired");
                        exit;
                    }

                    $role_name = $this->basic_model->get_user_role($current_user->user_role);
                    $this->data['action'] = array(
                        'name' => 'action',
                        'id' => 'action',
                        'type' => 'hidden',
                        'value' => 'action'
                    );
                    $this->data['username'] = array(
                        'name' => 'username',
                        'id' => 'username',
                        'type' => 'text',
                        'class' => 'form-control',
                        'value' => $current_user->username,
                        'disabled' => 'disabled'
                    );
                    $this->data['user_id'] = array(
                        'name' => 'user_id',
                        'id' => 'user_id',
                        'type' => 'hidden',
                        'class' => 'form-control',
                        'value' => $current_user->user_id
                    );
                    $this->data['user_type'] = array(
                        'name' => 'user_type',
                        'id' => 'user_type',
                        "class" => "form-control ",
                        'maxlength' => '5',
                        'value' => 'U',
                        'type' => 'hidden'
                    );
                    $this->data['account_holder_name'] = array(
                        'name' => 'account_holder_name',
                        'id' => 'account_holder_name',
                        'type' => 'text',
                        'maxlength' => '100',
                        'class' => 'form-control',
                        'value' => $current_user->account_holder_name
                    );
                    $this->data['user_email'] = array(
                        'name' => 'user_email',
                        'id' => 'user_email',
                        'type' => 'text',
                        'maxlength' => '200',
                        'class' => 'form-control',
                        'value' => $current_user->user_email
                    );

                    $this->data['mobile_phone'] = array(
                        'name' => 'mobile_phone',
                        'id' => 'mobile_phone',
                        'type' => 'text',
                        'class' => 'form-control phone_number',
                        'value' => isset($current_user->mobile_phone) && $current_user->mobile_phone != "" ? $current_user->mobile_phone : ''
                    );


                    $this->data['level'] = isset($current_user->user_role) && $current_user->user_role != "" ? $current_user->user_role : '';
                    $levels = $this->basic_model->get_company_roles();
                    $this->data['levels'] = isset($levels) && !empty($levels) ? $levels : '';

                    unset($_SESSION['postdata']);
                    $registration_plans = $this->basic_model->get_membership_packages('USER');
                    if (isset($registration_plans) && !empty($registration_plans) && count($registration_plans) > 0) {
                        $this->data['membership_packages'] = $registration_plans;
                    }

                    if (isset($this->data['company_details']) && !empty($this->data['company_details'])) {
                        $company_details = $this->data['company_details'];
                    }
                    $existing_groups = $this->basic_model->get_group_dropdown($company_details['company_id']);
                    $this->data['groups'] = $existing_groups;
                    $group = $this->company_model->get_users_groups($user_id);
                    $this->data['group'] = isset($group) && !empty($group) && $group[0]->user_group != "" ? $group[0]->user_group : '';
                    $this->data['heading'] = 'User Profile';
                    $this->data['newsletter'] = $current_user->is_newsletter;
                    $this->data['biography'] = $current_user->biography;
                    $this->data['biography_length'] = isset($current_user->biography) && $current_user->biography != "" ? 500 - strlen($current_user->biography) : '500';
                    $this->data['reset_password_link'] = "<a href='#' class='btn btn-primary changepassword'   role='button' data-toggle='modal' data-id='" . $current_user->user_id . "' data-email='" . $current_user->user_email . "'>CHANGE PASSWORD</a>";
                    $this->data['state'] = isset($current_user->state) && $current_user->state != "" ? $current_user->state : '';
                    $this->data['script_to_include'] = "company_js.js";
                    $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
                    $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');


                    $this->sidebardata['is_active'] = 'users';
                    $this->sidebardata["role_name"] = $role_name;
                    $this->headerdata['page_title'] = 'User Profile';
                    $this->headerdata['breadcrumbs'] = array(COMPANY_URL, array('dashboard', 'Dashboard'), array('users', 'Users List'));
                    $this->templatelayout->get_admin_dashboard_header($this->headerdata);
                    $this->templatelayout->get_admin_dashboard_footer();
                    $this->templatelayout->get_admin_dashboard_sidebar('companysidebar', $this->sidebardata);
                    $this->elements['middle'] = 'company/edit_user';
                    $this->elements_data['middle'] = $this->data;
                    $this->layout->setLayout('backend_layout/dashboardlayout');
                    $this->layout->multiple_view($this->elements, $this->elements_data);
                }
            }
        }
    }

    function user_transaction($cid = 0) {
        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect(SITE_URL, 'refresh');
            exit;
        } else {
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
                    redirect(ADMIN_URL . "admin/dashboard");
                }
            } else {
                $this->load->model('company_model');

                $result = $this->company_model->user_transactions(base64_decode($cid));
                $role_name = $this->basic_model->get_user_role($current_user->user_role);
                $this->sidebardata["role_name"] = $role_name;
                $this->data['did'] = base64_decode($cid);
                $this->data['is_user_expired'] = $this->basic_model->is_subscription_expired(base64_decode($cid));
                $user_subscription_id = $this->basic_model->get_subscription_id(base64_decode($cid));
                if (isset($user_subscription_id) && $user_subscription_id > 0) {
                    $this->data['subscription_id'] = $user_subscription_id;
                }
                $this->sidebardata["username"] = $current_user->username;
                $this->sidebardata['is_active'] = 'users';
                $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
                $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
                if (isset($result) && !empty($result)) {
                    $this->data['result'] = $result;
                }
                if (isset($this->data['company_details']) && !empty($this->data['company_details'])) {
                    $company_details = $this->data['company_details'];
                }
                $this->headerdata['page_title'] = "User Transactions";
                $this->headerdata['breadcrumbs'] = array(COMPANY_URL, array('dashboard', 'Dashboard'), array('users', 'Users List'), array('user_transaction/' . $cid, 'Transaction History'));
                $this->templatelayout->get_admin_dashboard_header($this->headerdata);
                $this->templatelayout->get_admin_dashboard_footer();
                $this->templatelayout->get_admin_dashboard_sidebar('companysidebar', $this->sidebardata);

                $this->elements['middle'] = 'company/company_transaction';
                $this->elements_data['middle'] = $this->data;
                $this->layout->setLayout('backend_layout/dashboardlayout');
                $this->layout->multiple_view($this->elements, $this->elements_data);
            }
        }
    }

    function update_status() {
        $this->load->model('sadmin_model');
        $userinfo = $this->basic_model->get_userinfo($this->input->post('user_id'));
        $identity = $this->config->item('identity', 'ion_auth');
        $return = $this->sadmin_model->update_status();

        if ($return) {
            $data = array(
                'identity' => $userinfo->{$identity}
            );
            if ($this->input->post('status') == '1') {
                $this->load->model('basic_model');
                $message_content = $this->basic_model->get_mail_template('active_status');
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
                        $this->session->set_flashdata('message', "User status changed successfully.");
                        echo $return;
                    } else {
                        $this->session->set_flashdata('error', "Error In Deactivating user.");
                        echo $return;
                    }
                } else {
                    $this->session->set_flashdata('error', "Error In Deactivating user.");
                    echo $return;
                }
            } else {
                $this->load->model('basic_model');
                $message_content = $this->basic_model->get_mail_template('deactivation_mail');
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
                        $this->session->set_flashdata('message', "User status changed successfully.");
                        echo $return;
                    } else {
                        $this->session->set_flashdata('error', "Error In changing user status.");
                        echo $return;
                    }
                } else {
                    $this->session->set_flashdata('error', "Error In changing user status.");
                    echo $return;
                }
            }
        } else {
            $this->session->set_flashdata('error', "Error In changing user status.");
            echo $return;
        }
    }

    function add_user() {
        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect(SITE_URL, 'refresh');
            exit;
        } else {
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
                $subscription_check = $this->basic_model->is_subscription_expired($current_user->user_id);
                if ($subscription_check < 2) {
                    redirect(COMPANY_URL . "expired");
                    exit;
                }
                $role_name = $this->basic_model->get_user_role($current_user->user_role);
                $this->data['script_to_include'] = "company_js.js";
                if (isset($this->data['company_details']) && !empty($this->data['company_details'])) {
                    $company_details = $this->data['company_details'];
                }

                $this->sidebardata['is_active'] = 'users';
                $this->sidebardata["role_name"] = $role_name;
                $postdata = isset($_SESSION['postdata']) ? $_SESSION['postdata'] : '';
                $this->data['username'] = array(
                    'name' => 'username',
                    'id' => 'username',
                    'type' => 'text',
                    'maxlength' => '15',
                    'class' => 'form-control',
                    'value' => isset($postdata) && !empty($postdata) && isset($postdata['username']) ? $postdata['username'] : ''
                );
                $this->data['user_type'] = array(
                    'name' => 'user_type',
                    'id' => 'user_type',
                    "class" => "form-control ",
                    'maxlength' => '5',
                    'value' => 'U',
                    'type' => 'hidden'
                );

                $this->data['account_holder_name'] = array(
                    'name' => 'account_holder_name',
                    'id' => 'account_holder_name',
                    'type' => 'text',
                    'maxlength' => '100',
                    'class' => 'form-control',
                    'value' => isset($postdata) && !empty($postdata) && isset($postdata['account_holder_name']) ? $postdata['account_holder_name'] : ''
                );
                $this->data['user_email'] = array(
                    'name' => 'user_email',
                    'id' => 'user_email',
                    'type' => 'text',
                    'maxlength' => '200',
                    'placeholder' => "eg: julie@widgetco.com",
                    'class' => 'form-control',
                    'value' => isset($postdata) && !empty($postdata) && isset($postdata['user_email']) ? $postdata['user_email'] : ''
                );
                $this->data['mobile_phone'] = array(
                    'name' => 'mobile_phone',
                    'id' => 'mobile_phone',
                    'type' => 'text',
                    'class' => 'form-control phone_number',
                    'value' => isset($postdata) && !empty($postdata) && isset($postdata['mobile_phone']) ? $postdata['mobile_phone'] : ''
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
                $this->data['card_number'] = array(
                    'name' => 'card_number',
                    'id' => 'card_number',
                    'type' => 'text',
                    "class" => "form-control  col-md-7 col-xs-12 credit_card_number",
                    'placeholder' => "Credit Card Number"
                );
                $this->data['expiration_date'] = array(
                    'name' => 'expiration_date',
                    'id' => 'expiration_date',
                    'type' => 'text',
                    'autocomplete' => "off",
                    "class" => "form-control  col-md-7 col-xs-12 credit_card_expiry",
                    'placeholder' => "MM / YYYY",
                    'autofill' => 'false'
                );
                $this->data['cvv_code'] = array(
                    'name' => 'cvv_code',
                    'id' => 'cvv_code',
                    'type' => 'password',
                    "class" => "form-control  col-md-7 col-xs-12 credit_card_cvc",
                    'placeholder' => "CVV",
                    'autofill' => 'false'
                );
                $this->data['address'] = array(
                    'name' => 'address',
                    'id' => 'address',
                    'type' => 'text',
                    "class" => "form-control  col-md-7 col-xs-12",
                    'placeholder' => "Address",
                    'value' => isset($postdata) && !empty($postdata) && isset($postdata['address']) ? $postdata['address'] : ''
                );
                $this->data['zip_code'] = array(
                    'name' => 'zip_code',
                    'id' => 'zip_code',
                    'type' => 'text',
                    'maxlength' => '9',
                    "class" => "form-control  col-md-7 col-xs-12",
                    'placeholder' => "Zip Code",
                    'value' => isset($postdata) && !empty($postdata) && isset($postdata['zip_code']) ? $postdata['zip_code'] : ''
                );
                $this->data['coupon_code'] = array(
                    'name' => 'coupon_code',
                    'id' => 'coupon_code',
                    "class" => "form-control",
                    'type' => 'text',
                    "maxlength" => "15",
                    'placeholder' => "Enter Code"
                );

                $this->data['level'] = isset($postdata) && !empty($postdata) && isset($postdata['level']) ? $postdata['level'] : '';
                $levels = $this->basic_model->get_company_roles();
                $this->data['levels'] = isset($levels) && !empty($levels) ? $levels : '';
                unset($_SESSION['postdata']);
                $registration_plans = $this->basic_model->get_membership_packages('USER');
                if (isset($registration_plans) && !empty($registration_plans) && count($registration_plans) > 0) {
                    $this->data['membership_packages'] = $registration_plans;
                }
                $tax = $this->basic_model->get_tax();
                if (isset($tax) && $tax > 0) {
                    $this->data['tax'] = $tax;
                }

                $existing_groups = $this->basic_model->get_group_dropdown($company_details['company_id']);
                $this->data['groups'] = $existing_groups;
                $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
                $this->data['error'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('error')));
                $this->headerdata['page_title'] = "Add User";
                $this->headerdata['breadcrumbs'] = array(COMPANY_URL, array('dashboard', 'Dashboard'), array('users', 'Users List'), array('add_user', 'Add User'));
                $this->templatelayout->get_admin_dashboard_header($this->headerdata);
                $this->templatelayout->get_admin_dashboard_footer();
                $this->templatelayout->get_admin_dashboard_sidebar('companysidebar', $this->sidebardata);

                $this->elements['middle'] = 'company/add_user';
                $this->elements_data['middle'] = $this->data;
                $this->layout->setLayout('backend_layout/dashboardlayout');
                $this->layout->multiple_view($this->elements, $this->elements_data);
            }
        }
    }

    public function create_user() {

        // Configuration options
        $tables = $this->config->item('tables', 'ion_auth');
        $identity_column = $this->config->item('identity', 'ion_auth');
        $this->data['identity_column'] = $identity_column;
        $current_user = $this->ion_auth->user()->row();
        $this->load->model('company_model');


        //Form validation checks
        unset($_SESSION['postdata']);
        $this->form_validation->set_rules('username', $this->lang->line('create_user_validation_identity_label'), 'required|is_unique[' . $tables['users'] . '.' . $identity_column . ']');
        $this->form_validation->set_rules('user_email', $this->lang->line('create_user_validation_email_label'), 'required|valid_email|is_unique[' . $tables['users'] . '.user_email]');
        $this->form_validation->set_rules('level', 'User level field is required.', 'required');

        if ($this->form_validation->run() == true) {

            $email = strtolower($this->input->post('user_email'));
            $identity = $this->input->post('username');
            $password = "";

            $additional_data = array();
            $additional_data['account_holder_name'] = $this->input->post('account_holder_name');
            $additional_data['mobile_phone'] = $this->input->post('mobile_phone');
        }




        $paidby = $this->input->post('paidby');
        if (isset($paidby) && $paidby[0] == "company") {
            $paidby = 'company';
        } else {
            $paidby = 'user';
        }

        $company_id = $current_user->user_id;
        $company_details = $this->basic_model->get_company_profile_details($current_user->user_id);

        if (isset($company_details) && $company_details['company_id'] > 0) {
            $company_id = $company_details['company_id'];
        }

        $user_type = $this->input->post('user_type');
        if (isset($user_type) && strlen($user_type) > 0) {
            if ($user_type == "U") {
                $additional_data['user_role'] = $this->input->post('level');
                //$additional_data['user_role'] = "3";
            }
        }
        if ($this->form_validation->run() == true) {
            if ($paidby == 'company') {
                // check to see if we are creating the user
                // redirect them back to the admin page
                $this->load->model("basic_model");
                $first_name = $this->input->post('first_name');
                $last_name = $this->input->post('last_name');
                $card_number = $this->input->post('card_number');
                $expiration_date = $this->input->post('expiration_date');
                $cvv_code = $this->input->post('cvv_code');
                $address = $this->input->post('address');
                $zip_code = $this->input->post('zip_code');
                $membership_plan = $this->input->post('membership_plan');

                if (isset($company_id) && !empty($company_id) && $company_id > 0) {
                    //$company_details = $this->basic_model->get_company_profile_details($company_id);
                    $additional_data['user_company_id'] = $company_id;
                }
                $ccdata = array();
                if (isset($membership_plan) && !empty($membership_plan)) {
                    $membership_plan = $membership_plan[0];
                    $plan_details = $this->basic_model->get_membership_package_details($membership_plan);
                    $ccdata['amount'] = $plan_details[0]['package_amount'];
                    $ccdata['package_mode'] = $plan_details[0]['package_mode'];
                } else {
                    $ccdata['amount'] = 99;
                    $ccdata['package_mode'] = 'MONTHLY';
                }


                if (isset($last_name) && strlen($last_name) > 0) {
                    $ccdata['last_name'] = $last_name;
                }
                if (isset($first_name) && strlen($first_name) > 0) {
                    $ccdata['first_name'] = $first_name;
                }
                if (isset($card_number) && strlen($card_number) > 0) {
                    $ccdata['card_number'] = $card_number;
                }
                if (isset($expiration_date) && strlen($expiration_date) > 0) {
                    $ccdata['expiration_date'] = $expiration_date;
                }
                if (isset($cvv_code) && strlen($cvv_code) > 0) {
                    $ccdata['cvv_code'] = $cvv_code;
                }
                if (isset($address) && strlen($address) > 0) {
                    $ccdata['address'] = $address;
                }
                if (isset($zip_code) && strlen($zip_code) > 0) {
                    $ccdata['zip_code'] = $zip_code;
                }

                $coupon_code = $this->input->post('coupon_code');
                $is_subscription = $this->input->post('is_subscription');

                if (isset($coupon_code) && strlen($coupon_code) > 0) {
                    $additional_data['coupon_code'] = $coupon_code;
                    // Call a Method to verify the coupon code and get the Percentage of discount
                    $additional_data['discount'] = 0;
                } else {
                    $additional_data['coupon_code'] = '';
                    $additional_data['discount'] = "0";
                }


                $member_ship_plan = $this->basic_model->get_membership_package_details($membership_plan);
                $plan_type = $member_ship_plan[0]['package_mode'];
                if ($user_type == "U") {
                    $p_c_type = "USER";
                }
                $validate = $this->basic_model->validate_coupon($coupon_code, $p_c_type, $plan_type);

                $this->load->model('aim_model');

                if (isset($validate) && !empty($validate)) {
                    if ($validate[0]['coupon_code_type'] == "AMOUNT") {
                        $additional_data['discount'] = $validate[0]['discount_percentage'];
                    }
                } else {
                    $additional_data['discount'] = 0;
                }

                if (isset($validate) && $validate[0]['payment_mode'] == "ANNUALLY" && $validate[0]['coupon_code_type'] == "AMOUNT") {

                    $one_time_payment = ($member_ship_plan[0]['package_amount']) * ((100 - ($validate[0]['discount_percentage'])) / 100);
                    $subscription_start_date = date('Y-m-d h:i:s');
                    $subscription_end_date = date('Y-m-d h:i:s', strtotime("+365 days"));
                    $ccdata['discount_code'] = $coupon_code;
                    $ccdata['discount'] = $validate[0]['discount_percentage'] . "%";
                } elseif (isset($validate) && $validate[0]['payment_mode'] == "MONTHLY" && $validate[0]['coupon_code_type'] == "AMOUNT") {

                    $one_time_payment = ($member_ship_plan[0]['package_amount']) * ((100 - ($validate[0]['discount_percentage'])) / 100);
                    $subscription_start_date = date('Y-m-d h:i:s');
                    $subscription_end_date = date('Y-m-d h:i:s', strtotime("+30 days"));
                    $ccdata['discount_code'] = $coupon_code;
                    $ccdata['discount'] = $validate[0]['discount_percentage'] . "%";
                } elseif (isset($validate) && $validate[0]['payment_mode'] == "ANNUALLY" && $validate[0]['coupon_code_type'] == "DAYS") {
                    $one_time_payment = ($member_ship_plan[0]['package_amount']);
                    $extended_days = $validate[0]['coupon_free_trial'];
                    $final_days = 365 + $extended_days;
                    $subscription_start_date = date('Y-m-d h:i:s');
                    $subscription_end_date = date('Y-m-d h:i:s', strtotime("+" . $final_days . " days"));
                    $ccdata['discount_code'] = $coupon_code;
                    $ccdata['discount'] = $validate[0]['coupon_free_trial'] . " days";
                } elseif (isset($validate) && $validate[0]['payment_mode'] == "MONTHLY" && $validate[0]['coupon_code_type'] == "DAYS") {
                    $one_time_payment = ($member_ship_plan[0]['package_amount']);
                    $extended_days = $validate[0]['coupon_free_trial'];
                    $final_days = 30 + $extended_days;
                    $subscription_start_date = date('Y-m-d h:i:s');
                    $subscription_end_date = date('Y-m-d h:i:s', strtotime("+ " . $final_days . " days"));
                    $ccdata['discount_code'] = $coupon_code;
                    $ccdata['discount'] = $validate[0]['coupon_free_trial'] . " days";
                } else {
                    $one_time_payment = $member_ship_plan[0]['package_amount'];
                    $subscription_start_date = date('Y-m-d h:i:s');
                    if ($member_ship_plan[0]['package_mode'] == "ANNUALLY") {
                        $subscription_end_date = date('Y-m-d h:i:s', strtotime("+365 days"));
                    } else {
                        $subscription_end_date = date('Y-m-d h:i:s', strtotime("+30 days"));
                    }
                    $ccdata['discount_code'] = '';
                    $ccdata['discount'] = '0';
                }
                $ccdata['amount'] = $this->basic_model->calculate_tax_amount($one_time_payment);

                $payment_status_one_time = $this->aim_model->ChargeCreditCard($ccdata, $email, $additional_data['discount']);
                $transaction_data = array();
                if (isset($payment_status_one_time) && $payment_status_one_time['code'] == "error") {
                    $_SESSION['postdata'] = $_POST;
                    $this->session->set_flashdata('error', '<p class="alert alert-danger text-left">' . $payment_status_one_time['message'] . '</p>');
                    redirect(COMPANY_URL . 'add_user');
                    exit;
                } elseif (isset($payment_status_one_time) && $payment_status_one_time['code'] == "success") {
                    $transaction_data['transaction_number'] = $payment_status_one_time['transaction_id'];
                    $transaction_data['approval_code'] = $payment_status_one_time['approval_code'];
                    $transaction_data['sub_total'] = $payment_status_one_time['data']['x_amount'];
                    $transaction_data['package_id'] = $membership_plan;
                    $transaction_data['transaction_description'] = $payment_status_one_time['data']['x_description'];
                    $additional_data['subscription_start_date'] = $subscription_start_date;
                    $additional_data['subscription_end_date'] = $subscription_end_date;
                }

                if (isset($is_subscription) && $is_subscription == "1") {
                    if ($member_ship_plan[0]['package_mode'] == "ANNUALLY") {
                        $ccdata['length'] = 12;
                    } else {
                        $ccdata['length'] = 1;
                    }
                    $payment_status = $this->basic_model->set_authorize_subscription($ccdata, $subscription_start_date, $subscription_end_date, $this->basic_model->calculate_tax_amount($member_ship_plan[0]['package_amount']));
                }
                $additional_data['package_id'] = $member_ship_plan[0]['package_id'];


                // Here we need to get the respond from client when we need to start the subscription

                if (isset($payment_status) && $payment_status['code'] == "error") {
                    $this->session->set_flashdata('error', $payment_status['message']);
                    redirect(COMPANY_URL . 'add_user');
                    exit;
                } elseif (isset($payment_status) && $payment_status['code'] == "success") {
                    $additional_data['user_current_subscription_id'] = $payment_status['subscription_id'];
                }
            } else {
                if (isset($company_id) && !empty($company_id) && $company_id > 0) {
                    $company_details = $this->basic_model->get_company_profile_details($company_id);
                    $additional_data['user_company_id'] = $company_id;
                }
            }
            //
            $newsletter_checked = $this->input->post('newsletter_checked');
            if (isset($newsletter_checked) && $newsletter_checked == "1") {
                $additional_data['is_newsletter'] = '1';
            } else {
                $additional_data['is_newsletter'] = '0';
            }

            if ($last_id = $this->ion_auth->register_user($identity, $password, $email, $additional_data)) {
                $this->company_model->user_assign_groups($last_id);
                if ($paidby == 'company') {

                    $transaction_data['user_id'] = $last_id;
                    $transaction_data['transaction_date'] = date('Y-m-d h:i:s');
                    $transaction_data['user_role'] = $additional_data['user_role'];
                    if (isset($tax) && $tax > 0) {
                        $transaction_data['tax'] = $tax;
                    }
                    $transaction_data['paid_by_userid'] = $current_user->user_id;
                    $transaction_data['discount_code'] = $additional_data['coupon_code'];
                    $transaction_data['discount_percentage'] = $additional_data['discount'];
                    $transaction_data['subscription_start_date'] = $subscription_start_date;
                    $transaction_data['subscription_end_date'] = $subscription_end_date;
                    if (isset($additional_data['user_current_subscription_id'])) {
                        $transaction_data['subscription_id'] = $additional_data['user_current_subscription_id'];
                    }
                    if (isset($transaction_data) && count($transaction_data) > 0) {
                        $transaction_data['transaction_invoice_number'] = $this->basic_model->generate_invoice_number();
                        $this->db->insert(TRANSACTIONS, $transaction_data);
                    }
                }
                $this->session->set_flashdata('message', $this->ion_auth->messages());

                redirect(COMPANY_URL . 'users');
            }
        } else {
            $_SESSION['postdata'] = $_POST;
            $this->session->set_flashdata('error', (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message'))));
            redirect(COMPANY_URL . "add_user");
        }
    }

    function importcsvusers() {
        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect(SITE_URL, 'refresh');
            exit;
        } else {

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
            }
            $subscription_check = $this->basic_model->is_subscription_expired($current_user->user_id);
            if ($subscription_check < 2) {
                redirect(COMPANY_URL . "expired");
                exit;
            }
            $role_name = $this->basic_model->get_user_role($current_user->user_role);
            $this->load->model('company_model');
            if (isset($this->data['company_details']) && !empty($this->data['company_details'])) {
                $company_details = $this->data['company_details'];
            }
            $existing_groups = $this->basic_model->get_group_dropdown($company_details['company_id']);
            $this->data['groups'] = $existing_groups;
            $this->data['company_list'] = $this->company_model->get_userlist($company_details['company_id']);
            $this->sidebardata['is_active'] = 'users';
            $this->sidebardata["role_name"] = $role_name;
            $this->headerdata['page_title'] = "Import Users";

            if (isset($_FILES['importedcsv']) && $_FILES['importedcsv']['size'] > 0) {
                $this->data['csvpath'] = $_FILES['importedcsv']['tmp_name'];
                $this->data['current_user'] = $this->ion_auth->user()->row();
                $this->data['user_company_id'] = $this->basic_model->get_company_id($current_user->user_id);
            }
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
            $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
            $this->templatelayout->get_admin_dashboard_header($this->headerdata);
            $this->templatelayout->get_admin_dashboard_footer();
            $this->templatelayout->get_admin_dashboard_sidebar('companysidebar', $this->sidebardata);

            $this->elements['middle'] = 'company/importusers';
            $this->elements_data['middle'] = $this->data;
            $this->layout->setLayout('backend_layout/dashboardlayout');
            $this->layout->multiple_view($this->elements, $this->elements_data);
        }
    }

    public function resend_activation($id = false) {
        $id = base64_decode($id);
        $user = $this->ion_auth_model->user($id)->row();
        $email = $user->user_email;
        if ($this->ion_auth_model->forgotten_password($email)) {   //changed
            // Get user information
            if ($user) {
                $user = $this->ion_auth_model->user($id)->row();
                $data = array(
                    'identity' => $user->{$this->config->item('identity', 'ion_auth')},
                    'forgotten_password_code' => $user->forgotten_password_code
                );

                $this->load->model('basic_model');
                $welcome_msg = $this->input->post('welcome_msg');
                $message_content = $this->basic_model->get_mail_template('update_user_password');
                if (isset($message_content) && !empty($message_content)) {
                    $mail_content = html_entity_decode($message_content->mail_template_content);
                    $message = str_replace("{{identity}}", $data['identity'], $mail_content);
                    $message = str_replace("{{siteurl}}", SITE_URL, $message);
                    //
                    $message = str_replace("{{forgotcode}}", $data['forgotten_password_code'], $message);
                    //
                    if (isset($welcome_msg) && $welcome_msg != "") {
                        $message = str_replace("{{welcome_msg}}", $welcome_msg, $message);
                    } else {
                        $message = str_replace("{{welcome_msg}}", "", $message);
                    }
                    $message = MAIL_HEADER . $message . MAIL_FOOTER;
                    $this->email->clear();
                    $this->email->from($this->config->item('admin_email', 'ion_auth'), $this->config->item('site_title', 'ion_auth'));
                    $this->email->to($user->user_email);
                    $this->email->subject($message_content->mail_subject);
                    $this->email->message($message);

                    if ($this->email->send() == TRUE) {
                        $this->session->set_flashdata('message', "Activation email sent to user email address.");
                    }
                } else {
                    $this->session->set_flashdata('error', "Unable to Send Activation Email.");
                }
            } else {
                $this->session->set_flashdata('error', "Unable to Send Activation Email.");
            }
        } else {
            $this->session->set_flashdata('error', "Unable to Send Activation Email.");
        }
        redirect(COMPANY_URL . 'users');
    }

    public function resend_activation_bulk($id = false) {
        $id = base64_decode($id);
        $user = $this->ion_auth_model->user($id)->row();
        $email = $user->user_email;
        if ($this->ion_auth_model->forgotten_password($email)) {   //changed
            // Get user information
            if ($user) {
                $user = $this->ion_auth_model->user($id)->row();
                $data = array(
                    'identity' => $user->{$this->config->item('identity', 'ion_auth')},
                    'forgotten_password_code' => $user->forgotten_password_code
                );

                $this->load->model('basic_model');
                $welcome_msg = $this->input->post('welcome_msg');
                $message_content = $this->basic_model->get_mail_template('update_user_password');
                if (isset($message_content) && !empty($message_content)) {
                    $mail_content = html_entity_decode($message_content->mail_template_content);
                    $message = str_replace("{{identity}}", $data['identity'], $mail_content);
                    $message = str_replace("{{siteurl}}", SITE_URL, $message);
                    //
                    $message = str_replace("{{forgotcode}}", $data['forgotten_password_code'], $message);
                    //
                    if (isset($welcome_msg) && $welcome_msg != "") {
                        $message = str_replace("{{welcome_msg}}", $welcome_msg, $message);
                    } else {
                        $message = str_replace("{{welcome_msg}}", "", $message);
                    }
                    $message = MAIL_HEADER . $message . MAIL_FOOTER;
                    $this->email->clear();
                    $this->email->from($this->config->item('admin_email', 'ion_auth'), $this->config->item('site_title', 'ion_auth'));
                    $this->email->to($user->user_email);
                    $this->email->subject($message_content->mail_subject);
                    $this->email->message($message);

                    if ($this->email->send() == TRUE) {
                        $this->session->set_flashdata('message', "Activation email sent to user email address.");
                    }
                } else {
                    $this->session->set_flashdata('error', "Unable to Send Activation Email.");
                }
            } else {
                $this->session->set_flashdata('error', "Unable to Send Activation Email.");
            }
        } else {
            $this->session->set_flashdata('error', "Unable to Send Activation Email.");
        }
    }

    function groups() {
        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect(SITE_URL, 'refresh');
            exit;
        } else {
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
                $subscription_check = $this->basic_model->is_subscription_expired($current_user->user_id);
                if ($subscription_check < 2) {
                    redirect(COMPANY_URL . "expired");
                    exit;
                }
                $role_name = $this->basic_model->get_user_role($current_user->user_role);

                $this->data['script_to_include'] = "company_js.js";
                $this->sidebardata['is_active'] = 'groups';
                $this->sidebardata["role_name"] = $role_name;
                $this->sidebardata["username"] = $current_user->account_holder_name != "" ? $current_user->account_holder_name : $current_user->username;
                $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
                $this->data['error'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('error')));
                //
                if (isset($this->data['company_details']) && !empty($this->data['company_details'])) {
                    $company_details = $this->data['company_details'];
                }

                $edit_id = $this->uri->segment(3, 0);
                if (isset($edit_id) && $edit_id > 0) {
                    $edit_data = $this->basic_model->get_group($edit_id);
                    $this->data['edit_data'] = $edit_data;
                }
                if (isset($edit_data) && !empty($edit_data)) {
                    $this->data['groupname'] = array(
                        'name' => 'groupname',
                        'id' => 'groupname',
                        'type' => 'text',
                        'required' => 'true',
                        'class' => 'form-control ',
                        'value' => $edit_data['group_name']
                    );
                    $this->data['edit_id'] = array(
                        'name' => 'edit_id',
                        'id' => 'edit_id',
                        'type' => 'hidden',
                        'required' => 'true',
                        'class' => 'form-control ',
                        'value' => $edit_data['group_id']
                    );
                } else {
                    if (isset($_SESSION['postData']) && !empty($_SESSION['postData'])) {
                        $postdata = $_SESSION['postData'];
                    }
                    $this->data['groupname'] = array(
                        'name' => 'groupname',
                        'id' => 'groupname',
                        'type' => 'text',
                        'required' => 'true',
                        'class' => 'form-control ',
                        "value" => isset($postdata) && !empty($postdata) && isset($postdata['groupname']) ? $postdata['groupname'] : ''
                    );
                    if (isset($_SESSION['is_exist'])) {
                        $this->data['is_exist'] = $_SESSION['is_exist'];
                        unset($_SESSION['is_exist']);
                        unset($_SESSION['postData']);
                    }
                }
                $company_details = $this->basic_model->get_company_profile_details($current_user->user_id);
                $existing_groups = $this->basic_model->get_groups($company_details['company_id']);
                if (isset($existing_groups) && !empty($existing_groups)) {
                    $this->data['existing_groups'] = $existing_groups;
                }

                $this->headerdata['page_title'] = "Groups";
                $this->headerdata['breadcrumbs'] = array(COMPANY_URL, array('dashboard', 'Dashboard'), array('groups', 'Groups'));
                $this->templatelayout->get_admin_dashboard_header($this->headerdata);
                $this->templatelayout->get_admin_dashboard_footer();
                $this->templatelayout->get_admin_dashboard_sidebar('companysidebar', $this->sidebardata);

                $this->elements['middle'] = 'company/groups';
                $this->elements_data['middle'] = $this->data;
                $this->layout->setLayout('backend_layout/dashboardlayout');
                $this->layout->multiple_view($this->elements, $this->elements_data);
            }
        }
    }

    function create_group() {
        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect(SITE_URL, 'refresh');
            exit;
        } else {
            $current_user = $this->ion_auth->user()->row();
            $groupname = $this->input->post('groupname');
            if (isset($groupname) && !empty($groupname)) {
                $edit_id = $this->input->post('edit_id');
                $data = array();
                $data['group_name'] = $groupname;
                $company_details = $this->basic_model->get_company_profile_details($current_user->user_id);
                $data['group_created_company_id'] = $company_details['company_id'];
                $data['group_adddate'] = date('Y-m-d h:i:s');
                $data['group_status'] = '1';
                if (isset($edit_id) && $edit_id > 0) {
                    $check_query = "select * from " . GROUPS . " where group_name='$groupname' and group_id<>'" . $edit_id . "' and group_created_company_id=" . $company_details['company_id'];
                    $check_sql = $this->db->query($check_query);
                    $check_result = $check_sql->result_array();
                    if (count($check_result) > 0) {
                        $this->session->set_flashdata('error', "Group Already Exists");
                        $_SESSION['postData'] = $_POST;
                        $_SESSION['is_exist'] = '1';
                        redirect(COMPANY_URL . "groups");
                        exit;
                    }
                    if ($this->db->update(GROUPS, $data, "group_id=$edit_id")) {
                        $this->session->set_flashdata('message', "Group Updated Successfully.");
                        redirect(COMPANY_URL . "groups");
                    }
                } else {

                    $check_query = "select * from " . GROUPS . " where group_name='$groupname'  and group_created_company_id=" . $company_details['company_id'];
                    $check_sql = $this->db->query($check_query);
                    $check_result = $check_sql->result_array();
                    if (count($check_result) > 0) {
                        $this->session->set_flashdata('error', "Group Already Exists");
                        $_SESSION['postData'] = $_POST;
                        $_SESSION['is_exist'] = '1';
                        redirect(COMPANY_URL . "groups");
                        exit;
                    }
                    if ($this->db->insert(GROUPS, $data)) {
                        $this->session->set_flashdata('message', "Group Added Successfully.");
                        redirect(COMPANY_URL . "groups");
                    }
                }
            }
        }
    }

    function update_group() {
        $group_id = $this->uri->segment(3, 0);
        $status = $this->uri->segment(4, 0);
        if (!$status) {
            $status = '0';
        }
        if (isset($group_id) && $group_id > 0) {
            $data = array();
            $data['group_status'] = $status;
            if ($this->db->update(GROUPS, $data, 'group_id=' . $group_id)) {
                echo "true";
            } else {
                echo "false";
            }
        }
    }

    function validate_group() {
        $group_name = urldecode($this->uri->segment(3, 0));
        if (isset($group_name) && strlen($group_name) > 0) {
            $current_user = $this->ion_auth->user()->row();
            $company_details = $this->basic_model->get_company_profile_details($current_user->user_id);
            $check_query = "select * from " . GROUPS . " where group_name='" . $group_name . "' and group_created_company_id=" . $company_details['company_id'];
            $check_sql = $this->db->query($check_query);
            $result = $check_sql->result_array();
            if (count($result) > 0) {
                echo "false";
            } else {
                echo "true";
            }
        }
    }

    function deletegroup() {
        $delid = $this->uri->segment(3, 0);
        $sql = $this->db->query("select * from " . USER_GROUPS . " where group_id=" . $delid);
        $result = $sql->result_array();

        if (count($result) <= 0) {
            if (isset($delid) && $delid > 0) {
                if ($delquery = $this->db->query("DELETE from " . GROUPS . " where group_id=" . $delid)) {
                    echo "true";
                }
            }
        } else {
            $this->session->set_flashdata('error', "Unable to delete group!. This group is assign to users");
            echo "true";
        }
    }

    function update_user_group() {
        $this->load->model('company_model');
        $this->company_model->update_user_group();
        die;
    }

    function makeuserpayment() {
        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect(SITE_URL, 'refresh');
            exit;
        } else {

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
            }

            $role_name = $this->basic_model->get_user_role($current_user->user_role);
            $puser_id = $this->uri->segment(3, 0);

            if (isset($puser_id) && $puser_id > 0) {
                $this->data['puser_id'] = $puser_id;
            }
            if (isset($this->data['company_details']) && !empty($this->data['company_details'])) {
                $company_details = $this->data['company_details'];
            }
            $this->sidebardata["role_name"] = $role_name;
            $packages = $this->basic_model->get_membership_packages('USER');
            if (isset($packages) && count($packages) && !empty($packages)) {
                $this->data['packages'] = $packages;
            }
            $this->data['user_type'] = array(
                'name' => 'user_type',
                'id' => 'user_type',
                "class" => "form-control ",
                'type' => 'text',
                'maxlength' => '5',
                'value' => 'U',
                'type' => 'hidden'
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
            $this->data['card_number'] = array(
                'name' => 'card_number',
                'id' => 'card_number',
                'type' => 'text',
                "class" => "form-control  col-md-7 col-xs-12 credit_card_number nonpaste",
                'placeholder' => "Credit Card Number"
            );
            $this->data['expiration_date'] = array(
                'name' => 'expiration_date',
                'id' => 'expiration_date',
                'type' => 'text',
                "class" => "form-control  col-md-7 col-xs-12 credit_card_expiry nonpaste",
                'placeholder' => "MM / YYYY"
            );
            $this->data['cvv_code'] = array(
                'name' => 'cvv_code',
                'id' => 'cvv_code',
                'type' => 'password',
                "class" => "form-control  col-md-7 col-xs-12 credit_card_cvc nonpaste",
                'placeholder' => "CVV"
            );
            $this->data['address'] = array(
                'name' => 'address',
                'id' => 'address',
                'type' => 'text',
                'maxlength' => '250',
                "class" => "form-control  col-md-7 col-xs-12",
                'placeholder' => "Address",
                'value' => isset($postdata) && !empty($postdata) && isset($postdata['address']) ? $postdata['address'] : ''
            );
            $this->data['zip_code'] = array(
                'name' => 'zip_code',
                'id' => 'zip_code',
                'type' => 'text',
                'maxlength' => '8',
                "class" => "form-control  col-md-7 col-xs-12",
                'placeholder' => "Zip Code",
                'value' => isset($postdata) && !empty($postdata) && isset($postdata['zip_code']) ? $postdata['zip_code'] : ''
            );
            $this->data['coupon_code'] = array(
                'name' => 'coupon_code',
                'id' => 'coupon_code',
                "class" => "form-control",
                'type' => 'text',
                'placeholder' => "Enter Code"
            );
            $this->headerdata['page_title'] = "Make User Payment";
            $this->data['message'] = $this->session->flashdata('message');
            $this->data['error'] = $this->session->flashdata('error');
            $this->templatelayout->get_admin_dashboard_header($this->headerdata);
            $this->templatelayout->get_admin_dashboard_footer();
            $this->templatelayout->get_admin_dashboard_sidebar('companysidebar', $this->sidebardata);

            $this->elements['middle'] = 'company/makeuserpayment';
            $this->elements_data['middle'] = $this->data;
            $this->layout->setLayout('backend_layout/dashboardlayout');
            $this->layout->multiple_view($this->elements, $this->elements_data);
        }
    }

    function cancelsubscription() {
        $subscription_id = $this->uri->segment(3, 0);
        $check_query = "select * from " . USERS . " where user_current_subscription_id='" . $subscription_id . "'";
        $check_sql = $this->db->query($check_query);
        $result = $check_sql->result_array();
        if (count($result)) {
            $is_cancelled = $this->basic_model->cancel_authorize_subscription($subscription_id);
            if ($is_cancelled == "success") {
                $this->session->set_flashdata('message', "Subscription cancelled successfully.");
                $data['user_current_subscription_id'] = '';
                $this->db->update(USERS, $data, "user_id=" . $result[0]['user_id']);
                echo "true";
            } else {
                $this->session->set_flashdata('error', $is_cancelled);
                echo "false";
            }
        }
    }

    function customtemplate() {

        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect(SITE_URL, 'refresh');
            exit;
        } else {
            $this->load->model('template_model');
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
            }
            $subscription_check = $this->basic_model->is_subscription_expired($current_user->user_id);
            if ($subscription_check < 2) {
                redirect(COMPANY_URL . "expired");
                exit;
            }

            $company_details = $this->basic_model->get_company_profile_details($current_user->user_id);
            $role_name = $this->basic_model->get_user_role($current_user->user_role);
            $this->data['template_list'] = $this->template_model->get_templates($company_details['company_id'], false);
            $this->load->model('company_model');
            if (isset($this->data['company_details']) && !empty($this->data['company_details'])) {
                $company_details = $this->data['company_details'];
            }
            $this->data['mode'] = 'C';
            $this->sidebardata['is_active'] = 'customtemplate';
            $this->sidebardata["role_name"] = $role_name;
            $this->headerdata['page_title'] = "Custom Template";
            $this->headerdata['breadcrumbs'] = array(COMPANY_URL, array('dashboard', 'Dashboard'), array('customtemplate', 'Custom Template'));

            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
            $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
            $this->templatelayout->get_admin_dashboard_header($this->headerdata);
            $this->templatelayout->get_admin_dashboard_footer();
            $this->templatelayout->get_admin_dashboard_sidebar('companysidebar', $this->sidebardata);

            $this->elements['middle'] = 'company/template/template_dashboard';
            $this->elements_data['middle'] = $this->data;
            $this->layout->setLayout('backend_layout/dashboardlayout');
            $this->layout->multiple_view($this->elements, $this->elements_data);
        }
    }

    function designtemplate() {

        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect(SITE_URL, 'refresh');
            exit;
        } else {
            $this->load->model('template_model');
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
            }
            $subscription_check = $this->basic_model->is_subscription_expired($current_user->user_id);
            if ($subscription_check < 2) {
                redirect(COMPANY_URL . "expired");
                exit;
            }

            $company_details = $this->basic_model->get_company_profile_details($current_user->user_id);
            $role_name = $this->basic_model->get_user_role($current_user->user_role);
            $this->data['template_list'] = $this->template_model->get_templates($company_details['company_id'], false);
            $this->load->model('company_model');
            if (isset($this->data['company_details']) && !empty($this->data['company_details'])) {
                $company_details = $this->data['company_details'];
            }
            $this->data['mode'] = 'D';
            $this->sidebardata['is_active'] = 'designtemplate';
            $this->sidebardata["role_name"] = $role_name;
            $this->headerdata['page_title'] = "Design Template";
            $this->headerdata['breadcrumbs'] = array(COMPANY_URL, array('dashboard', 'Dashboard'), array('customtemplate', 'Design Template'));
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
            $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
            $this->templatelayout->get_admin_dashboard_header($this->headerdata);
            $this->templatelayout->get_admin_dashboard_footer();
            $this->templatelayout->get_admin_dashboard_sidebar('companysidebar', $this->sidebardata);

            $this->elements['middle'] = 'company/template/template_dashboard';
            $this->elements_data['middle'] = $this->data;
            $this->layout->setLayout('backend_layout/dashboardlayout');
            $this->layout->multiple_view($this->elements, $this->elements_data);
        }
    }

    function api() {
        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect(SITE_URL, 'refresh');
            exit;
        } else {
            $this->load->model('template_model');
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
            }
            $subscription_check = $this->basic_model->is_subscription_expired($current_user->user_id);
            if ($subscription_check < 2) {
                redirect(COMPANY_URL . "expired");
                exit;
            }


            $role_name = $this->basic_model->get_user_role($current_user->user_role);
            $this->load->model('company_model');
            if (isset($this->data['company_details']) && !empty($this->data['company_details'])) {
                $company_details = $this->data['company_details'];
            }
            $this->sidebardata['is_active'] = 'api';
            $this->sidebardata["role_name"] = $role_name;
            $this->headerdata['page_title'] = "API";
            $this->headerdata['breadcrumbs'] = array(COMPANY_URL, array('dashboard', 'Dashboard'), array('api', 'API'));
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
            $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
            $this->templatelayout->get_admin_dashboard_header($this->headerdata);
            $this->templatelayout->get_admin_dashboard_footer();
            $this->templatelayout->get_admin_dashboard_sidebar('companysidebar', $this->sidebardata);

            $this->elements['middle'] = 'company/api';
            $this->elements_data['middle'] = $this->data;
            $this->layout->setLayout('backend_layout/dashboardlayout');
            $this->layout->multiple_view($this->elements, $this->elements_data);
        }
    }

    function support() {
        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect(SITE_URL, 'refresh');
            exit;
        } else {
            $this->load->model('template_model');
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
            }
            $subscription_check = $this->basic_model->is_subscription_expired($current_user->user_id);
            if ($subscription_check < 2) {
                redirect(COMPANY_URL . "expired");
                exit;
            }


            $role_name = $this->basic_model->get_user_role($current_user->user_role);

            $this->load->model('company_model');
            if (isset($this->data['company_details']) && !empty($this->data['company_details'])) {
                $company_details = $this->data['company_details'];
            }

            $this->sidebardata['is_active'] = 'support';
            $this->sidebardata["role_name"] = $role_name;
            $this->headerdata['page_title'] = "Support";
            $this->headerdata['breadcrumbs'] = array(COMPANY_URL, array('dashboard', 'Dashboard'), array('support', 'Support'));
            $get_support_videos = $this->company_model->get_support_videos();
            $this->data['get_support_videos'] = $get_support_videos;
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
            $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
            $this->templatelayout->get_admin_dashboard_header($this->headerdata);
            $this->templatelayout->get_admin_dashboard_footer();
            $this->templatelayout->get_admin_dashboard_sidebar('companysidebar', $this->sidebardata);

            $this->elements['middle'] = 'company/support';
            $this->elements_data['middle'] = $this->data;
            $this->layout->setLayout('backend_layout/dashboardlayout');
            $this->layout->multiple_view($this->elements, $this->elements_data);
        }
    }

    function get_max_size() {
        echo ini_get("upload_max_filesize");
        exit;
    }

    function createtemplate() {
        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect(SITE_URL, 'refresh');
            exit;
        } else {
            $this->load->model('template_model');
            $current_user = $this->ion_auth->user()->row();
            if ($current_user->user_role != "2" && $current_user != "5") {
                if ($current_user->user_role == "1") {
                    redirect(SADMIN_URL . "dashboard", 'refresh');
                    exit;
                } elseif ($current_user->user_role == "3") {
                    redirect(USER_URL . "dashboard");
                } elseif ($current_user->user_role == "4") {
                    redirect(AFFILIATE_URL . "dashboard");
                }
            }
            $subscription_check = $this->basic_model->is_subscription_expired($current_user->user_id);
            if ($subscription_check < 2) {
                redirect(COMPANY_URL . "expired");
                exit;
            }

            $company_details = $this->basic_model->get_company_profile_details($current_user->user_id);
            $role_name = $this->basic_model->get_user_role($current_user->user_role);
            $this->data['template_list'] = $this->template_model->get_templates($company_details['company_id'], false);
            $this->load->model('company_model');
            if (isset($this->data['company_details']) && !empty($this->data['company_details'])) {
                $company_details = $this->data['company_details'];
            }
            $this->sidebardata['is_active'] = 'createtemplate';
            $this->sidebardata["role_name"] = $role_name;
            $this->headerdata['page_title'] = "Create Template";
            $this->headerdata['breadcrumbs'] = array(COMPANY_URL, array('dashboard', 'Dashboard'), array('createtemplate', 'Create Template'));

            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
            $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
            $this->templatelayout->get_admin_dashboard_header($this->headerdata);
            $this->templatelayout->get_admin_dashboard_footer();
            if ($current_user->user_role == "2")
                $this->templatelayout->get_admin_dashboard_sidebar('companysidebar', $this->sidebardata);
            elseif ($current_user->user_role == "5")
                $this->templatelayout->get_admin_dashboard_sidebar('adminsidebar', $this->sidebardata);
            $this->elements['middle'] = 'company/template/template_dashboard';
            $this->elements_data['middle'] = $this->data;
            $this->layout->setLayout('backend_layout/dashboardlayout');
            $this->layout->multiple_view($this->elements, $this->elements_data);
        }
    }

}
