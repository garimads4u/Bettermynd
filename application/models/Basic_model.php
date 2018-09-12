<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Basic_model extends CI_Model {

    function __construct() { // Constructor
        parent::__construct();
    }

    public function stripTagsPostArray($post_arr = array()) {
        $temp_arr = array();
        if (is_array($post_arr) && count($post_arr)) {
            foreach ($post_arr AS $key => $value) {
                if (is_string($value)) {
                    $temp_arr["$key"] = strip_tags($value);
                } else {
                    $temp_arr["$key"] = $value;
                }
            }
        }
        return $temp_arr;
    }

    public function escapeStringPostArray($post_arr = array()) {
        $temp_arr = array();
        if (is_array($post_arr) && count($post_arr)) {
            foreach ($post_arr AS $key => $value) {
                if (is_string($value)) {
                    $temp_arr["$key"] = mysql_real_escape_string($value);
                } else {
                    $temp_arr["$key"] = $value;
                }
            }
        }
        return $temp_arr;
    }

    function convert_date($str) {
        $str = str_replace(" ", "", $str);
        $strarray = explode("/", $str);
        $new_str = $strarray[1] . "-" . $strarray[0];
        return $new_str;
    }

    function convert_name($str) {
        $strarray = explode(" ", $str);

        if (count($strarray) > 1) {
            $return['first_name'] = $strarray[0];
            $return['last_name'] = $strarray[1];
        } else {
            $return['first_name'] = $strarray[0];
            $return['last_name'] = $strarray[0];
        }

        return $return;
    }

    function set_authorize_subscription($ccdata, $startdate, $enddate, $amount) {
        $this->load->library('authorize_arb');
        $this->authorize_arb->startData('create');
        $refId = substr(md5(microtime() . 'ref'), 0, 20);
        $this->authorize_arb->addData('refId', $refId);
        $subscription_data = array(
            'name' => 'BetterMynd Monthly Subscription',
            'paymentSchedule' => array(
                'interval' => array(
                    'length' => $ccdata['length'],
                    'unit' => 'months',
                ),
                'startDate' => date('Y-m-d', strtotime($enddate)),
                'totalOccurrences' => 9999,
                'trialOccurrences' => 0,
            ),
            'amount' => $amount,
            'trialAmount' => 0,
            'payment' => array(
                'creditCard' => array(
                    'cardNumber' => str_replace(" ", "", str_replace("-", "", $ccdata['card_number'])),
                    'expirationDate' => $this->convert_date($ccdata['expiration_date']),
                    'cardCode' => $ccdata['cvv_code'],
                ),
            ),
            'order' => array(
                'invoiceNumber' => '123',
                'description' => 'BetterMynd Monthly Subscription',
            ),
            'billTo' => array(
                'firstName' => $ccdata['first_name'],
                'lastName' => $ccdata['last_name'],
                'address' => $ccdata['address'],
                'city' => '',
                'state' => '',
                'zip' => $ccdata['zip_code'],
                'country' => '',
            ),
        );

        $this->authorize_arb->addData('subscription', $subscription_data);
        $return = array();
        if ($this->authorize_arb->send()) {
            $return['code'] = "success";
            $return['subscription_id'] = $this->authorize_arb->getId();
        } else {

            $return['code'] = "error";
            $return['message'] = $this->authorize_arb->getError();
        }
        return $return;
    }

    function cancel_authorize_subscription($subscription_id) {

        $this->load->library('authorize_arb');
        if (isset($subscription_id) && $subscription_id > 0) {

            $this->authorize_arb->startData('cancel');
            $this->authorize_arb->addData('subscriptionId', $subscription_id);

            if ($this->authorize_arb->send()) {
                return "success";
            } else {
                return $this->authorize_arb->getError();
            }
        }
    }

    function username_check() {
        $data = array(
            'username' => $this->input->post('username'),
        );
        $query = $this->db->get_where(USERS, $data);
        if ($query->num_rows() == 0) {
            return "true";
        } else {
            return "false";
        }
    }

    function email_check() {
        $data = array(
            'user_email' => $this->input->post('user_email'),
        );
        $query = $this->db->get_where(USERS, $data);
        if ($query->num_rows() == 0) {
            return "true";
        } else {
            return "false";
        }
    }

    function get_user_role($role_id) {
        $data = array(
            'user_roles_id' => $role_id
        );
        $query = $this->db->get_where(USERS_ROLE, $data);
        if ($query->num_rows() == 1) {
            return $query->row('user_roles_name');
        } else {
            return false;
        }
    }

    function get_extension($filename) {
// Get extension of a filename , and checking its valid or not for image uploading
        $extensionarray = explode(".", $filename);
        if (count($extensionarray) > 0) {
            $fileext = $extensionarray[sizeof($extensionarray) - 1];
            if (isset($fileext) && strlen($fileext) > 0) {
                $fileext = strtolower($fileext);
                if ($fileext == "jpg" || $fileext == "jpeg") {
                    return "jpg";
                } elseif ($fileext == "png") {
                    return "png";
                } elseif ($fileext == "jpeg") {
                    return "jpeg";
                } elseif ($fileext == "gif") {
                    return "gif";
                } elseif ($fileext == "bmp") {
                    return "bmp";
                } else {

                    return "error";
                }
            }
        } else {
            return "error";
        }
    }

    function get_userinfo($user_id) {
        $data = array(
            'user_id' => $user_id
        );
        $query = $this->db->get_where(USERS, $data);
        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            return false;
        }
    }

    function get_state_list() {
        $this->db->select("state_code,state");
        $query = $this->db->get(STATES);
        $state = array();
        $state[''] = "Select State";
        foreach ($query->result() as $key => $value) {
            $state[$value->state_code] = $value->state;
        }
//echo "<pre>";print_r($state); die;
        return $state;
    }

    function get_mail_template($slang) {
        $data = array(
            'mail_template_slang' => $slang,
            'mail_template_status' => '1'
        );
        $query = $this->db->get_where(MAIL_TEMPLATES, $data);
        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            return false;
        }
    }

    function get_company_logo($param) {
        $query = $this->db->query("select * from " . USERS . " where username='" . $param . "'");
        $result = $query->result_array();
        if (count($result)) {

            if (isset($result[0]['company_logo2']) && strlen($result[0]['company_logo2']) > 0) {

                return ASSETS_URL . "logo/" . $result[0]['company_logo2'];
            } else {
                return DEFAULT_LOGO;
            }
        } else {
            return DEFAULT_LOGO;
        }
    }

    function get_membership_packages($account_type) {
        $query = "select * from " . MEMBERSHIP_PACKAGES . " where account_type='" . $account_type . "'";
        $sql = $this->db->query($query);
        $result = $sql->result_array();
        if (count($result)) {
            return $result;
        }
    }

    function get_membership_package_details($package_id) {
        $query = "select * from " . MEMBERSHIP_PACKAGES . " where package_id='" . $package_id . "'";
        $sql = $this->db->query($query);
        $result = $sql->result_array();
        if (count($result)) {
            return $result;
        }
    }

    function validate_coupon($coupon_code, $check_type, $plan_type) {
        if (strlen(ltrim(rtrim($coupon_code))) > 0) {
            $check_query = "select * from " . DISCOUNT_COUPONS . " where coupon_code='" . $coupon_code . "' and coupon_account_type in ('" . $check_type . "','BOTH') and payment_mode='" . $plan_type . "' and coupon_code_status='1' and (CURDATE() BETWEEN coupon_code_sdate and coupon_code_edate )";
            $check_sql = $this->db->query($check_query);
            $result = $check_sql->result_array();
            if (count($result)) {
                return $result;
            }
        }
    }

    function set_login_stat($user_id) {
        $data = array();
        $data['user_logout_time'] = date('Y-m-d h:i:s');
        $this->db->update(LOGIN_STATS, $data, "user_logout_time is NULL");

        $data['user_id'] = $user_id;
        $data['user_login_time'] = date('Y-m-d h:i:s');
        $data['user_ip_address'] = $_SERVER['REMOTE_ADDR'];
        $data['user_logout_time'] = NULL;

        $this->db->insert(LOGIN_STATS, $data);
        return $this->db->insert_id();
    }

    function set_logout_stat($session_id) {
        $data = array();
        $data['user_logout_time'] = date('Y-m-d h:i:s');
        $this->db->update(LOGIN_STATS, $data, "stat_id=$session_id");
    }

    function get_login_stat($user_id) {
        $query = "select count(*) as mcount from " . LOGIN_STATS . " where user_id=" . $user_id;
        $sql = $this->db->query($query);
        $row = $sql->result_array();
        if (count($row)) {
            if ($row[0]['mcount'] > 0) {
                return $row[0]['mcount'];
            } else {
                return "0";
            }
        } else {
            return "0";
        }
    }

    function get_user_data($user_id) {
//$query = "select *,college_name as collegename from bm_users left join college as c on college_id = college_id where user_id=" . $user_id . " ";
        $query = "select * from bm_users where user_id=" . $user_id;
        $sql = $this->db->query($query);
        $row = $sql->result_array();
        if (count($row)) {
            $query1 = "select * from bm_college where college_id=" . $row[0]['college_id'];
            $sql1 = $this->db->query($query1);
            $row1 = $sql1->result_array();
            if ($row1 && $row1[0]) {
                $row[0]['collegename'] = $row1[0]['college_name'];
            }
            return $row[0];
        }
    }

    function get_super_data() {
        $query = "select * from bm_" . USERS . " where user_type=1 order by user_id LIMIT 0,1";
        $sql = $this->db->query($query);
        $row = $sql->result_array();
        if (count($row)) {
            return $row[0];
        }
    }

    function is_subscription_expired($user_id) {
        $check_query = $this->db->query("select subscription_end_date,user_status from " . USERS . " where user_id=$user_id");
        $check_sql = $check_query->result_array();
        if (count($check_sql)) {
            $end_date = $check_sql[0]['subscription_end_date'];

            $current_date = strtotime(date('Y-m-d h:i:s'));
            $end_date = strtotime($end_date);

            if ($end_date > $current_date) {


                return "2";
            } else {
                return "1";
            }
        } else {
            return "0";
        }
        exit;
    }

    function generate_invoice_number() {
        $invoiceno = "BZ/";
        $invoiceno.=date('Ymd') . "/";
        $invoiceno.=uniqid();
        return $invoiceno;
    }

    function get_company_details($username) {
        $return = "";
        $query = "select * from " . USERS . " where username='" . $username . "' and user_role='2'";
        $sql = $this->db->query($query);
        $result = $sql->result_array();
        if (count($result)) {

            $return['username'] = $result[0]['username'];
            $return['logo'] = $result[0]['username'];
            $company_details = $this->get_company_profile_details($result[0]['user_id']);
            if (isset($company_details) && count($company_details) && !empty($company_details)) {
                $return['details'] = $company_details;
            }
        }
        return $return;
    }

    function get_company_details_byid($user_id) {
        $query = "select * from " . USERS . " where user_id=(select user_id from " . USER_COMPANY . " where company_id='" . $user_id . "') and user_role='2'";
        $sql = $this->db->query($query);
        $result = $sql->result_array();
        if (count($result)) {

            $return['username'] = $result[0]['username'];
            $return['logo'] = $result[0]['company_logo2'];
            $company_details = $this->get_company_profile_details($result[0]['user_id']);
            if (isset($company_details) && count($company_details) && !empty($company_details)) {
                $return['details'] = $company_details;
            }
            return $return;
        }
    }

    function get_company_profile_details($user_id) {
        $query = "select * from " . USER_COMPANY . " where user_id='" . $user_id . "'";
        $sql = $this->db->query($query);
        $result = $sql->result_array();
        if (count($result)) {
            return $result[0];
        }
    }

    function get_company_profile($company_id) {
        $query = "select * from " . USER_COMPANY . " where company_id='" . $company_id . "'";
        $sql = $this->db->query($query);
        $result = $sql->result_array();
        if (count($result)) {
            return $result[0];
        }
    }

    function update_status($user_id) {
        $data = array(
            'user_status' => '1'
        );
        if ($this->db->update(USERS, $data, "user_id=" . $user_id)) {
            $this->session->set_flashdata('message', '<p class="alert alert-success text-left">Account Activated Successfully.Kindly Set Your Password for Login into BetterMynd.</p>');
            return true;
        } else {
            return false;
        }
    }

    function checkIfUserExists($username, $usermail) {
        $query = "select * from " . USERS;
        if ($usermail) {
            $data[0] = "user_email='" . $usermail . "'";
        }
        if ($username) {
            $data[1] = "username='" . $username . "'";
        }
        $str = implode(" or ", $data);
        if ($str) {
            $query.=" where " . $str;
        }

        $sql = $this->db->query($query);
        $result = $sql->result_array();

        if (count($result) > 0) {
            return "1";
        } else {
            return "2";
        }
    }

    function get_company_id($user_id) {
        $query = "select * from " . USER_COMPANY . " where user_id='" . $user_id . "'";
        $sql = $this->db->query($query);
        $result = $sql->result_array();
        if (count($result) > 0) {
            return $result[0]['company_id'];
        } else {

        }
    }

    function get_company_roles() {
        $this->db->select("user_roles_id,user_roles_name");
        $query = $this->db->get(USERS_ROLE);
        $level = array();
        $level[''] = "Select Level";
        foreach ($query->result() as $key => $value) {
            if ($value->user_roles_name == "User" || $value->user_roles_name == "Admin") {
                $level[$value->user_roles_id] = $value->user_roles_name;
            }
        }
        return $level;
    }

    function get_groups($company_id) {
        $query = $this->db->query("select * from " . GROUPS . " where group_created_company_id=" . $company_id . " order by group_adddate DESC");
        $sql = $query->result_array($query);
        if (count($sql) > 0) {
            return $sql;
        }
    }

    function get_group($edit_id) {
        $query = $this->db->query("select * from " . GROUPS . " where group_id=$edit_id");
        $sql = $query->result_array($query);
        if (count($sql) > 0) {
            return $sql[0];
        }
    }

    function get_group_dropdown($company_id, $user_role = false) {

        $this->db->select("group_id,group_name");
        $query = $this->db->get_where(GROUPS, array('group_status' => '1', 'group_created_company_id' => $company_id));
        $level = array();

        foreach ($query->result() as $key => $value) {

            $level[$value->group_id] = $value->group_name;
        }
        return $level;
    }

    function get_times($default = '00:00', $interval = '+45 minutes') {

        $output = array();

        $current = strtotime('00:00');
        $end = strtotime('23:59');

        while ($current <= $end) {
            $time = date('H:i', $current);
            $sel = ( $time == $default ) ? ' selected' : '';


// $output .= "<option value=\"{$time}\"{$sel}>" . date('h:i A', $current) . '</option>';
            array_push($output, date('h:i A', $current));
            $current = strtotime($interval, $current);
        }

        return $output;
    }

    function checkIfValid($username, $usermail) {
        $okay = "";

        $okay = preg_match('/^([A-Za-z]{1})([A-Za-z0-9-_.]{2,100})([A-Za-z0-9])+\@([a-zA-Z0-9]+\.)+(([a-zA-Z]{2,4}))\w?$/', $usermail);
        if (!$okay) {

            return "Invalid email address.";
        }

        $okay = preg_match('/^([a-zA-Z])[a-zA-z0-9\._-]{2,14}[A-Za-z0-9]$/', $username);
        if (!$okay) {
            return "Username must be of 4-15 alphanumeric characters";
        }

        if (round($username) > 0) {
            return "Username can't be numeric only.";
        }
        return "ok";
    }

    function get_login_counts($user_id) {
        $result = $this->db->query("select count(*) as mcount from " . LOGIN_STATS . " where user_id=" . $user_id);
        $result = $result->result_array();
        if (count($result) > 0) {
            return $result[0]['mcount'];
        } else {
            return "0";
        }
    }

    public function resend_activation_bulk($id = false) {

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

    public function import_user($array) {
        if ($this->db->insert(USERS, $array)) {
            return $this->db->insert_id();
        }
    }

    function if_coupon_used($user_id) {
        $check_query = "select * from " . TRANSACTIONS . " where user_id='" . $user_id . "' order by user_transaction_id  DESC LIMIT 0,1";
        $check_sql = $this->db->query($check_query);
        $result = $check_sql->result_array();
        if (count($result) > 0) {
            $coupon_code = $result[0]['discount_code'];
            if (isset($coupon_code) && strlen($coupon_code) > 0) {
                return $coupon_code;
            } else {
                return "N/A";
            }
        } else {
            return "N/A";
        }
    }

    function get_company_url($user_id) {
        $query = "select * from " . USER_COMPANY . " where company_id = (select user_company_id from " . USERS . " where user_id=" . $user_id . ")";
        $sql = $this->db->query($query);
        $result = $sql->result_array();

        if (count($result)) {
            return $result[0]['company_url'];
        }
    }

    function get_users_data($user_ids) {
        if (is_array($user_ids) && !empty($user_ids)) {
            $this->db->select('*');
            $this->db->from(USERS);
            $this->db->where('user_status', '1');
            $users = array_values($user_ids);
            $this->db->where_in('user_id', $users);
        } else if (!empty($user_ids)) {
            $this->db->select('*');
            $this->db->from(USERS);
            $this->db->where('user_status', '1');
            $this->db->where('user_id', $user_ids);
        } else {
            return false;
        }
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;
    }

    /*
     *
     */

    function readNotification($nofication_user_id) {
        $query = "update " . NOTIFICATION_USER . " set read_status='1' where id='" . $nofication_user_id . "'";
        $sql = $this->db->query($query);
    }

//using unix time stemp get the elipsed time.
    function time_elapsed_string($ptime) {
        $etime = time() - $ptime;

        if ($etime < 1) {
            return '0 seconds';
        }

        $a = array(365 * 24 * 60 * 60 => 'year',
            30 * 24 * 60 * 60 => 'month',
            24 * 60 * 60 => 'day',
            60 * 60 => 'hour',
            60 => 'minute',
            1 => 'second'
        );
        $a_plural = array('year' => 'years',
            'month' => 'months',
            'day' => 'days',
            'hour' => 'hours',
            'minute' => 'minutes',
            'second' => 'seconds'
        );

        foreach ($a as $secs => $str) {
            $d = $etime / $secs;
            if ($d >= 1) {
                $r = round($d);
                return $r . ' ' . ($r > 1 ? $a_plural[$str] : $str) . ' ago';
            }
        }
    }

    function check_referrer($ref) {
        if (isset($ref) && $ref != "") {
            $query = $this->db->get_where(USERS, array('username' => $ref, 'user_role' => 4, 'user_status' => 1));
            $result = $query->num_rows();
            if ($result == 1) {
                $data = $query->result();
                return $data[0]->username;
            } else {
                return "superadmin";
            }
        }
    }

    function get_client_ip() {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP')) {
            $ipaddress = getenv('HTTP_CLIENT_IP');
        } else if (getenv('HTTP_X_FORWARDED_FOR')) {
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        } else if (getenv('HTTP_X_FORWARDED')) {
            $ipaddress = getenv('HTTP_X_FORWARDED');
        } else if (getenv('HTTP_FORWARDED_FOR')) {
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        } else if (getenv('HTTP_FORWARDED')) {
            $ipaddress = getenv('HTTP_FORWARDED');
        } else if (getenv('REMOTE_ADDR')) {
            $ipaddress = getenv('REMOTE_ADDR');
        } else {
            $ipaddress = 'UNKNOWN';
        }
        return $ipaddress;
    }

    function affiliate_stats($ref) {
        $ip = $this->get_client_ip();
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        $sql = "INSERT INTO BetterMynd_referral_stats (ip_address, user_agent, sponsor,user_type, visits) VALUES('$ip', '$user_agent', '$ref','user',1) ON DUPLICATE KEY UPDATE  visits=visits+1";
        $this->db->query($sql);
    }

    function check_param($param) {
        $check_query = "select * from " . USERS . " where username ='" . $param . "'";
        $check_sql = $this->db->query($check_query);
        $result = $check_sql->result_array();
        if (count($result) > 0) {
            return "1";
        }
    }

    function get_tax() {
        $sql = $this->db->query("select * from " . SITE_SETTINGS . " LIMIT 0,1");
        $result = $sql->result_array();
        if (count($result)) {
            if (isset($result[0]['tax_percentage']) && $result[0]['tax_percentage'] > 0) {
                return $result[0]['tax_percentage'];
            } else {
                return "0";
            }
        }
    }

    function calculate_tax_amount($amount) {
        $tax = $this->get_tax();
        if (isset($tax) && $tax > 0) {
            $net_amount = ((100 + $tax) / 100) * $amount;
            return $net_amount;
        } else {
            return $amount;
        }
    }

    function get_templates($companyid = false, $template_id = false) {
        $this->db->select('t.*,tt.type,tt.category,GROUP_CONCAT(mg.group_name SEPARATOR ", ") as t_group,GROUP_CONCAT(mg.group_id) as t_group_id');
        $this->db->from(TEMPLATES . ' t');
        $this->db->join(TEMPLATE_TYPES . ' tt', 'tt.id=t.type', 'inner');
        $this->db->join(TEMPLATE_GROUPS . ' tg', 'tg.template_id=t.id', 'inner');
        $this->db->join('BetterMynd_mst_groups mg', 'mg.group_id=tg.group_id', 'inner');
        if ($companyid) {

            $this->db->where('t.company_id', $companyid);
            $this->db->group_by('tg.template_id');
            $this->db->order_by('t.id', 'desc');
        }
        if ($template_id) {
            $this->db->where('t.id', $template_id);
        }
        $this->db->where('is_publish', 1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $return = $query->result();
        } else {
            $return = false;
        }
        return $return;
    }

    function get_user_company_logo($user_id) {

        $query = $this->db->query("select company_logo2 from " . USERS . " where user_id=(select user_id from " . USER_COMPANY . " where company_id=(select user_company_id from " . USERS . " where user_id=$user_id))");
        $result = $query->result_array();
        if (count($result) > 0) {
            if (strlen($result[0]['company_logo2']) > 0) {
                return $result['0']['company_logo2'];
            }
        }
    }

    function payout_months() {
        $payout_array = array();
        $masterpayouts = $this->db->query("select * from " . MST_PAYOUT . " order by generate_date desc LIMIT 0,1");
        $masterpayouts = $masterpayouts->result();

        $paid_payouts = $this->db->query("select * from " . MST_PAYOUT . " where is_paid = '1' order by id");
        $paid_payouts = $paid_payouts->result();

//$startDate = strtotime($masterpayouts[0]->generate_date. ' +1 week');
        $startDate = strtotime($masterpayouts[0]->generate_date);

        $endDate = strtotime(date("Y-m-31"), strtotime('last month'));
        $startDate = strtotime(date('Y-m-01', $startDate) . ' +1 month');

        $days_between = ceil(abs($endDate - $startDate) / 86400) / 30 - 1;
//$days_between = ceil(abs($endDate - $startDate) / 86400)/30;
        $currentDate = $endDate;
        $pending_payouts = array();
        $i = 0;
        $startDate = $masterpayouts[0]->generate_date;
        $startDate1 = strtotime($masterpayouts[0]->generate_date);

        while ($days_between >= 0) {
            $m_month = date('m', strtotime($startDate));
            if ($m_month == "01" || $m_month == 1) {
                if (date('Y', strtotime($startDate)) % 4 == 0) {
                    $startDate = date('Y-m-d', strtotime($startDate . ' +29 days'));
                } else {
                    $startDate = date('Y-m-d', strtotime($startDate . ' +28 days'));
                }
            } else {

                $startDate = date('Y-m-d', strtotime($startDate . ' +1 month'));
            }
//  $value = date('m/d/Y', $startDate1)." - ".date('m/d/Y', strtotime($startDate));
            $value = date('F Y', strtotime($startDate));
            $startDate1 = strtotime($startDate);
            $key = date('m-d-Y', $startDate1);
            $pending_payouts[$key] = $value;
            $days_between--;
        }

//          echo "<pre>";
//          print_r($pending_payouts);
//          exit;
        $payout_array['pending_payouts'] = $pending_payouts;
        $payout_array['paid_payouts'] = $paid_payouts;
        return $payout_array;
    }

    public function get_timezonelist() {
        $this->db->select('timezone_value,timezone_name');
        $this->db->from(TIMEZONE);
        $this->db->order_by('timezone_name', 'asc');
        $query = $this->db->get();
        $timezone = array();
        if ($query->result()) {
            foreach ($query->result() as $t) {
                $timezone[$t->timezone_value] = $t->timezone_name;
            }
            return $timezone;
        } else {
            return FALSE;
        }
    }

    public function get_specialitylist() {
        $this->db->select('speciality_id,speciality_title');
        $this->db->from(SPECIALITY);
        $this->db->order_by('speciality_title', 'asc');
        $query = $this->db->get();
        $speciality = array();
        if ($query->result()) {
            foreach ($query->result() as $s) {
                $speciality[$s->speciality_id] = $s->speciality_title;
            }
            return $speciality;
        } else {
            return FALSE;
        }
    }

    public function get_insurencelist() {
        $this->db->select('id,insurance');
        $this->db->from(INSURANCE);
        $this->db->order_by('is_none_txt asc, insurance asc');
        $query = $this->db->get();
        $insurance = array();
        if ($query->result()) {
            foreach ($query->result() as $s) {
                $insurance[$s->id] = $s->insurance;
            }
            return $insurance;
        } else {
            return FALSE;
        }
    }

    public function get_providers($college_id = false) {
        $this->db->select('user_id, concat(first_name, " ", last_name) as name');
        $this->db->from(USERS);
        $condition = "user_status = 1 and ((user_type = 3 and college_id = $college_id) or (user_type = 5 and FIND_IN_SET(" . $college_id . ", third_parties_college_ids)))";
        $this->db->where($condition);
        $query = $this->db->get();

        $result = '';
        if ($query->num_rows() > 0) {
            $data = $query->result();
            if ($data && is_array($data)) {
                foreach ($data as $key => $value) {
                    $result[$value->user_id] = $value->name;
                }
            }
        }

        return $result;
    }

    public function get_ethnicitylist() {
        $this->db->select('ethnicity_id,ethnicity_name');
        $this->db->from(MST_ETHNICITY);
        $this->db->order_by('ethnicity_name', 'asc');
        $query = $this->db->get();
        $ethnicity = array();
        if ($query->result()) {
            foreach ($query->result() as $s) {
                $ethnicity[$s->ethnicity_id] = $s->ethnicity_name;
            }
            return $ethnicity;
        } else {
            return FALSE;
        }
    }

    public function convertDate($date) {
        if (isset($date) && $date != ""):
            if (!is_numeric($date)) {
                $date = strtotime($date);
            }
            return date('Y-m-d', $date);
        else:
            return NULL;
        endif;
    }

    public function getUserCompletenessStatus($uid) {
        $this->db->select('is_profile_completeness');
        $this->db->from(USERS);
        $this->db->where('user_id', $uid);
        $this->db->where('user_status', '1');
        $query = $this->db->get();
        $user_status = array();
        if ($query->result()) {
            $is_profile = $query->result();
            $is_profile = $is_profile[0];
            return $is_profile->is_profile_completeness;
        } else {
            return FALSE;
        }
    }

    public function convertDatePatient($dob_date) {
        if (isset($dob_date) && $dob_date != ""):
            return date_format(date_create($dob_date), 'm/d/Y');
        else:
            return NULL;
        endif;
    }

    function get_extension_doc($filename) {
// Get extension of a filename , and checking its valid or not for image uploading
        $extensionarray = explode(".", $filename);
        if (count($extensionarray) > 0) {
            $fileext = $extensionarray[sizeof($extensionarray) - 1];
            if (isset($fileext) && strlen($fileext) > 0) {
                $fileext = strtolower($fileext);
                if ($fileext == "jpg" || $fileext == "jpeg") {
                    return "jpg";
                } elseif ($fileext == "png") {
                    return "png";
                } elseif ($fileext == "jpeg") {
                    return "jpeg";
                } elseif ($fileext == "pdf") {
                    return "pdf";
                } elseif ($fileext == "doc") {
                    return "doc";
                } elseif ($fileext == "docx") {
                    return "docx";
                } else {

                    return "error";
                }
            }
        } else {
            return "error";
        }
    }

    function get_cms_pages_by_slug($slug_name) {
        $this->db->select('*');
        $this->db->from(CMS_PAGES);
        $this->db->where('page_slang', $slug_name);
        $this->db->order_by('page_title');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->result();
            $result = $result[0];
            return $result;
        } else {
            return array();
        }
    }

    public function getTimeZoneName($value) {
        $this->db->select('timezone_name');
        $this->db->from(TIMEZONE);
        $this->db->where("timezone_value", $value);
        $query = $this->db->get();
        $data = array();
        if ($query->num_rows() > 0) {
            $data = $query->result();
            return $data[0]->timezone_name;
        } else {
            return false;
        }
    }

    public function getCollegeName($college_id) {
        $this->db->select('college_name');
        $this->db->from(COLLEGE);
        $this->db->where("college_id", $college_id);
        $query = $this->db->get();
        $data = array();
        if ($query->num_rows() > 0) {
            $data = $query->result();
            return $data[0]->college_name;
        } else {
            return false;
        }
    }

    public function getEthnicityName($ethnicity_id) {
        $this->db->select('ethnicity_name');
        $this->db->from(MST_ETHNICITY);
        $this->db->where("ethnicity_id", $ethnicity_id);
        $query = $this->db->get();
        $data = array();
        if ($query->num_rows() > 0) {
            $data = $query->result();
            return $data[0]->ethnicity_name;
        } else {
            return false;
        }
    }

    public function getSpecialityName($sp) {
// $sp_name = "";
        $name = array();
        if (!empty($sp)) {
            $ids = explode(',', $sp);
            foreach ($ids as $key) {
                $this->db->select('speciality_title');
                $this->db->from(SPECIALITY);
                $this->db->where("speciality_id", $key);
                $query = $this->db->get();
                $data = array();
                if ($query->num_rows() > 0) {
                    $data = $query->result();
                    $name[] = $data[0]->speciality_title;
                }
            }
//$sp_name = implode(' , ', $name);
        }
        return $name;
    }

    function strip_content($string, $length) {

        $str_split = explode(" ", $string);
        if (count($str_split) > 0) {
            if ($length > count($str_split)) {
                $limit = count($str_split);
            } elseif ($length < count($str_split)) {
                $limit = $length;
            } else {
                $limit = count($str_split);
            }
            $return = array();
            for ($i = 0; $i < $limit; $i++) {
                array_push($return, $str_split[$i]);
            }
            return implode(" ", $return) . "...";
        }
    }

    public function get_user_info($user_id) {
        $this->db->select('*');
        $this->db->from(USERS);
        $this->db->where("user_id", $user_id);
        $query = $this->db->get();
        $data = array();
        if ($query->num_rows() > 0) {
            $data = $query->result();
            return $data[0];
        }
    }

    function get_college_admin_info($college_id) {
        $query = "select u.*,c.* from bm_users as u,bm_college as c where c.uid=u.user_id and c.college_id='" . $college_id . "'";
        $sql = $this->db->query($query);
        if ($sql->num_rows()) {
            $result = $sql->result_array();
            if (count($result)) {
                return $result[0];
            }
        }
    }

    function set_userzoominfo($id, $zoom) {
        $this->db->where('user_id', $id);
        return $this->db->update(USERS, $zoom);
    }

    function getInsurenceName($in) {
        $name = array();
        if (!empty($in)) {
            $ids = explode(',', $in);
            foreach ($ids as $key) {
                $this->db->select('insurance');
                $this->db->from(INSURANCE);
                $this->db->where("id", $key);
                $query = $this->db->get();
                $data = array();
                if ($query->num_rows() > 0) {
                    $data = $query->result();
                    $name[] = $data[0]->insurance;
                }
            }
        }
        return $name;
    }

    function getAdminDetails() {
        $result = [];
        $this->db->select('u.first_name, u.last_name, u.user_email, u.timezone_code');
        $this->db->from(USERS . ' u');
        $this->db->where('u.user_status', '1');
        $this->db->where('u.user_type', '1');
        $result = $this->db->get()->row_array();
        return $result;
    }

    public function check_availability($provider_id, $startTime, $endTime) {
//$chkStartTime = date('Y-m-d H:i', strtotime('-30 minutes', $startTime));
//$chkEndTime = date('Y-m-d H:i', strtotime('+30 minutes', $startTime));
        $chkStartTime = date('Y-m-d H:i', strtotime('-44 minutes', $startTime));
        $chkEndTime = date('Y-m-d H:i', strtotime('+45 minutes', $startTime));
        $count = $this->db->query("select count(*) as avl_count from bm_provider_availablity where concat(start_date,' ',start_time) between '$chkStartTime' and '$chkEndTime' and provider_id=$provider_id and status=1")->row_array();
        return $count;
    }

    public function get_current_appointment() {
        $chkStartTime = date('Y-m-d H:i', strtotime(date('Y-m-d H:i:s') . "- 15 minutes "));
        $chkEndTime = date('Y-m-d H:i');
        $result = $this->db->query("select app_id from bm_provider_availablity as av INNER JOIN bm_appointments as a ON a.slot_id = av.avail_id where concat(av.end_date,' ',av.end_time) between '$chkStartTime' and '$chkEndTime' and a.end_status=1 and av.status=1 and a.status=1")->result_array();
        return $result;
    }

    public function set_utc_datetime($datetime, $is_in_strtotime = null) {
        $current_timezone = date_default_timezone_get();
        if (is_numeric($datetime)) {
            $datetime = date('Y-m-d H:i:s', $datetime);
        }
        $u_timestamp = strtotime($datetime);
        date_default_timezone_set(DEFAULT_TIMEZONE_CODE);
        $result = date("Y-m-d H:i:s", $u_timestamp);
        if ($is_in_strtotime == 1) {
            $result = strtotime($result);
        }
        date_default_timezone_set($current_timezone);
        return $result;
    }

    public function change_utc_datetime($datetime, $timezone_code = null) {
        $current_timezone = $get_in_timezone = date_default_timezone_get();
        if ($timezone_code) {
            $get_in_timezone = $timezone_code;
        }
        date_default_timezone_set('UTC');
        if (is_numeric($datetime)) {
            $datetime = date('Y-m-d H:i:s', $datetime);
        }
        $u_timestamp = strtotime($datetime);
        date_default_timezone_set($get_in_timezone);
        $result = date("Y-m-d H:i:s", $u_timestamp);
        date_default_timezone_set($current_timezone);
        return $result;
    }

    public function set_current_timezone() {
        $get_loggedin_user = $this->ion_auth->user()->row();
        $timezone_code = DEFAULT_TIMEZONE_CODE;
        if ($get_loggedin_user && $get_loggedin_user->timezone_code && $get_loggedin_user->timezone_code != '') {
            $timezone_code = $get_loggedin_user->timezone_code;
        }
        date_default_timezone_set($timezone_code);
    }

    public function chk_applied_coupon($transaction) {
        $transaction = unserialize($transaction);
        return $transaction['remain_session_cost'];
    }

    public function is_reusable_coupon($coupon_duration, $coupon_id, $user_id) {
        $is_valid = 'YES';
        if (strtolower($coupon_duration) == 'once') {
            $query = "select COUNT(*) as trans_id from bm_appointment_transaction where patient_id=$user_id and coupon_id = '$coupon_id'  and transaction_type='charge' and coupon_duration = '$coupon_duration'";
            $sql = $this->db->query($query)->row_array();
            if ($sql && $sql['trans_id'] > 0) {
                $is_valid = 'NO';
            }
        }
        return $is_valid;
    }

    function get_college_name($college_id) {
        $college = $this->db->select("*")->where('college_id', $college_id)->get(COLLEGE)->row();
        return $college;
    }

}
