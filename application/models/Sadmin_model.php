<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Sadmin_model extends CI_Model {

    function __construct() { // Constructor
        //  $this->load->library('libs3');
        $this->load->helper('download_helper');
        parent::__construct();
    }

    function get_collegelist() {
        $this->db->select("*, (select count(user_id) from " . DB_PREFIX . USERS . " where user_type=4 and college_id=c.college_id) as students_count ", false);
        $this->db->from(USERS . ' u');
        $this->db->join(COLLEGE . ' c', 'c.uid = u.user_id');
        $this->db->where('u.user_type', 2);
        $this->db->order_by('user_createdon', 'DESC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    function get_counselorslist() {
        $this->db->select('*');
        $this->db->from(USERS . ' u');
        $this->db->join(COLLEGE . ' c', 'c.college_id = u.college_id', 'left');
        $this->db->where('u.user_type', 3);
        $this->db->or_where('u.user_type', 5);
        $this->db->order_by('user_createdon', 'DESC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    function get_studentslist() {
        $this->db->select('u.*,c.*, (SELECT count(app_id) FROM bm_appointments a JOIN bm_appointment_transaction at ON at.appointment_id = a.app_id WHERE a.patient_id = u.user_id AND a.status IN (0,1) AND at.transaction_type = "charge") as total_scheduled_session');
        $this->db->from(USERS . ' u');
        $this->db->join(COLLEGE . ' c', 'c.college_id = u.college_id');
        //$this->db->join(APPOINTMENTS . ' a', ' u.user_id = a.patient_id AND a.status IN (0,1)', 'left');
        $this->db->where('u.user_type', 4);
        $this->db->order_by('user_createdon', 'DESC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    function get_college_data($user_id) {
        $this->db->select('*');
        $this->db->from(USERS . ' u');
        $this->db->join(COLLEGE . ' c', 'c.uid = u.user_id');
        $this->db->where('u.user_type', 2);
        $this->db->where('u.user_id', $user_id);
        $query = $this->db->get();
        //echo $this->db->last_Query(); die;
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }
    }

    function add_college($data) {
        if ($this->db->insert(COLLEGE, $data)) {
            return $this->db->insert_id();
        }
    }

    function update_college($user_id, $additional_data = array(), $college_data = NULL) {
        $college = "";
        $additional = "";
        if (!empty($user_id)) {
            if (!empty($additional_data)) {
                $this->db->where('user_id', $user_id);
                $additional = $this->db->update(USERS, $additional_data);
                //echo $this->db->last_query();
            }

            if (!empty($college_data)) {
                $this->db->where('uid', $user_id);
                $college = $this->db->update(COLLEGE, $college_data);
            }
        }

        if ($additional || $college) {
            return true;
        } else {
            return false;
        }
    }

    function update_college_college($college_id, $college_data) {

        $additional = "";
        $college = "";

        if (!empty($college_data)) {
            $this->db->where('college_id', $college_id);
            $college = $this->db->update(COLLEGE, $college_data);
        }

        if ($additional || $college) {
            return true;
        } else {
            return false;
        }
    }

    function update_profile() {
        // $username = $this->input->post('username');
        $user_email = $this->input->post('user_email');
        $office_phone = $this->input->post('office_phone');
        $mobile_phone = $this->input->post('mobile_phone');
        $address = $this->input->post('address');
        $zipcode = $this->input->post('zipcode');
        $website = $this->input->post('website');
        $state = $this->input->post('state');
        $fax_number = $this->input->post('fax_number');
        $biography = $this->input->post('biography');
        $fb_url = $this->input->post('fb_url');
        $twitter_url = $this->input->post('twitter_url');
        $linkedin_url = $this->input->post('linkedin_url');
        $youtube_url = $this->input->post('youtube_url');
        $current_user_id = $this->input->post('user_id');
        $newsletter_checked = $this->input->post('is_newsletter');

        if (isset($newsletter_checked) && $newsletter_checked == "1") {
            $newsletter_checked = '1';
        } else {
            $newsletter_checked = '0';
        }

        //$current_user_id = $this->ion_auth->user()->row()->id;

        $data = array(
            "user_email" => $user_email,
            "office_phone" => $office_phone,
            "mobile_phone" => $mobile_phone,
            "address" => $address,
            "zipcode" => $zipcode,
            "website" => $website,
            "state" => $state,
            "fax_number" => $fax_number,
            "biography" => $biography,
            "fb_url" => $fb_url,
            "twitter_url" => $twitter_url,
            "linkedin_url" => $linkedin_url,
            "youtube_url" => $youtube_url,
            "is_newsletter" => $newsletter_checked
//		"email"=>$usermail
        );

        //---------------------------
        if (isset($_FILES['profile_photo']) && $_FILES['profile_photo']['size'] > 0) {
            $profileimage = $_FILES['profile_photo'];
            $extenstion = $this->basic_model->get_extension($profileimage['name']);
            if ($extenstion != "error") {

                $filename = $current_user_id . "." . $extenstion;
                $config['upload_path'] = FILE_UPLOAD_PATH . "upload/";
                $config['allowed_types'] = 'jpg|png|jpeg|gif';
                $config['file_name'] = $filename;
                if (file_exists($config['upload_path'] . "$filename")) {
                    unlink($config['upload_path'] . "$filename");
                }
                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if ($this->upload->do_upload("profile_photo")) {
                    $data_image = $this->upload->data();
                    $data['profile_photo'] = $data_image['file_name'];
                }
            } else {
                $this->session->set_flashdata('error', "Profile Pic must be of JPG/PNG image type.");
                return;
            }
        }
        if (isset($_FILES['company_logo2']) && $_FILES['company_logo2']['size'] > 0) {
            $profileimage = $_FILES['company_logo2'];
            $extenstion = $this->basic_model->get_extension($profileimage['name']);
            if ($extenstion != "error") {

                $filename = $current_user_id . "primary." . $extenstion;
                $config['upload_path'] = FILE_UPLOAD_PATH . "logo/";
                $config['allowed_types'] = 'jpg|png|jpeg|gif';
                $config['file_name'] = $filename;
                if (file_exists($config['upload_path'] . "$filename")) {
                    unlink($config['upload_path'] . "$filename");
                }
                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if ($this->upload->do_upload("company_logo2")) {
                    $data_image = $this->upload->data();
                    $data['company_logo2'] = $data_image['file_name'];
                }
            } else {
                $this->session->set_flashdata('error', "Company Logo Pic must be of JPG/PNG image type.");
                return;
            }
        }
        if ($this->db->update(USERS, $data, "user_id=" . $current_user_id)) {
            $this->session->set_flashdata('message', 'Profile successfully updated.');
            return;
        }
    }

    function college_update_status() {
        $is_disabled = 0;
        if ($this->input->post('status') == '1') {
            $is_disabled = 1;
        }
        $data = array(
            'user_status' => intval($this->input->post('status')),
            'is_disabled' => $is_disabled
        );
        if ($this->db->update(USERS, $data, "user_id=" . $this->input->post('user_id'))) {
            // $this->session->set_flashdata('message', 'Status Updated Successfully.');
            return '1';
        } else {
            return '0';
        }
    }

    function company_transactions($cid = false) {
        $this->db->select('u.username,u.user_email,u.user_id,t.transaction_number,t.transaction_date,m.package_mode,t.sub_total,t.discount_percentage,t.transaction_description, t.subscription_end_date,t.tax');
        $this->db->from(TRANSACTIONS . ' t');
        $this->db->join(USERS . ' u', "u.user_id=t.user_id", "inner");
        $this->db->join(MEMBERSHIP_PACKAGES . ' m', "m.package_id=t.package_id", "inner");
        $this->db->where("t.user_id", $cid);
        $this->db->order_by('transaction_date', 'DESC');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }
    }

    function email_check() {
        $this->db->select('*');
        $this->db->from(USERS);
        $this->db->where('user_email', $this->input->post('user_email'));
        $this->db->where('user_id!=', $this->input->post('user_id'));
        $query = $this->db->get();
        if ($query->num_rows() == 0) {
            return true;
        } else {
            return false;
        }
    }

    function get_mail_templates() {
        $this->db->select('*');
        $this->db->from(MAIL_TEMPLATES);
        $this->db->order_by('mail_template_name');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }
    }

    function get_cms_pages() {
        $this->db->select('*');
        $this->db->from(CMS_PAGES);
        $this->db->order_by('page_title');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }
    }

    function get_mail_template_data($template_id) {
        $this->db->select('*');
        $this->db->from(MAIL_TEMPLATES);
        $this->db->where('mail_template_id', $template_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }
    }

    function get_page_detail($page_id) {
        $this->db->select('*');
        $this->db->from(CMS_PAGES);
        $this->db->where('page_id', $page_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }
    }

    function update_template($data, $template_id) {
        return $this->db->update(MAIL_TEMPLATES, $data, "mail_template_id=" . $template_id);
    }

    function update_page($data, $page_id) {
        return $this->db->update(CMS_PAGES, $data, "page_id=" . $page_id);
    }

    function update_package($data, $template_id) {
        return $this->db->update(MEMBERSHIP_PACKAGES, $data, "package_id=" . $template_id);
    }

    function get_membership_plans() {
        $this->db->select('*');
        $this->db->from(MEMBERSHIP_PACKAGES);
        $this->db->order_by('account_type,package_amount');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }
    }

    function get_plan_details($template_id) {
        $this->db->select('*');
        $this->db->from(MEMBERSHIP_PACKAGES);
        $this->db->where('package_id', $template_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }
    }

    function get_discount_coupons() {
        $query = "select * from " . DISCOUNT_COUPONS . " order by coupon_id DESC";
        $sql = $this->db->query($query);
        $result = $sql->result_array();
        if (count($result) > 0) {
            return $result;
        }
    }

    function get_states() {
        $this->db->select('*');
        $this->db->from(STATES);
        $this->db->order_by('state');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }
    }

    function get_state_data($state_id) {
        $this->db->select('*');
        $this->db->from(STATES);
        $this->db->where('state_id', $state_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }
    }

    function update_state($data, $state_id) {
        return $this->db->update(STATES, $data, "state_id=" . $state_id);
    }

    function get_all_states() {
        $query = "select * from " . STATES . " order by state_id DESC";
        $sql = $this->db->query($query);
        $result = $sql->result_array();
        if (count($result) > 0) {
            return $result;
        }
    }

    function get_site_settings() {
        $this->db->select('*');
        $this->db->from(SITE_SETTINGS);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }
    }

    function get_timezones() {
        $this->db->select("timezone_id,TimeZone");
        $query = $this->db->get(TIMEZONES);
        $get_timezones = array();
        foreach ($query->result() as $key => $value) {
            $get_timezones[$value->timezone_id] = $value->TimeZone;
        }

        return $get_timezones;
    }

    //function used for display list of site logs
    function get_user_data_logs() {
        $this->db->select('u.username,u.user_email,u.user_id,ls.user_id,ls.user_ip_address');
        $this->db->from(LOGIN_STATS . ' ls');
        $this->db->join(USERS . ' u', "u.user_id=ls.user_id", "inner");
        $this->db->order_by('ls.user_id', 'ASC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }
    }

    function get_support_videos() {
        $this->db->select('*');
        $this->db->from(SUPPORT_VIDEOS);
        $this->db->order_by('video_id');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }
    }

    function get_support_video_data($video_id) {
        $this->db->select('*');
        $this->db->from(SUPPORT_VIDEOS);
        $this->db->where('video_id', $video_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }
    }

    function trainingSteps() {
        $query = "select *  from " . AFFILIATE_TRAINING . "";
        $query.=" order by tstep_id ASC";
        $sql = $this->db->query($query);
        return $result = $sql->result_array();
    }

    function update_admin($post_arr) {
        $data['first_name'] = $post_arr['first_name'];
        $data['last_name'] = $post_arr['last_name'];
        $data['dob'] = $this->basic_model->convertDate($post_arr['dob']);
        $data['mobile_no'] = $post_arr['mobile_no'];
        $data['user_type'] = 1;
        $data['ethnicity'] = $post_arr['ethnicity'];
        $data['gender'] = $post_arr['gender'];
        $data['timezone_id'] = $post_arr['timezone'];
        $data['address'] = $post_arr['address'];
        $data['city'] = $post_arr['city'];
        $data['state'] = $post_arr['state'];
        $data['zipcode'] = $post_arr['zipcode'];
        $data['is_profile_completeness'] = 1;

        if ($post_arr['timezone']) {
            $timezone_code = $this->db->select('timezone_code')->from(TIMEZONE)->where('timezone_value', trim($post_arr['timezone']))->get()->row();
            if ($timezone_code && $timezone_code->timezone_code) {
                $data['timezone_code'] = $timezone_code->timezone_code;
            }
        }

        $current_user_id = $post_arr['user_id'];
        if (isset($_FILES['profile_image']) && $_FILES['profile_image']['size'] > 0) {
            $profileimage = $_FILES['profile_image'];
            $extenstion = $this->basic_model->get_extension($profileimage['name']);
            if ($extenstion != "error") {
                $filename = $current_user_id . "." . $extenstion;
                $config['upload_path'] = PROFILE_FILE_UPLOAD_PATH;
                $config['allowed_types'] = 'jpg|png|jpeg|gif';
                $config['max_size'] = 1024 * 2;
                $config['file_name'] = $filename;
                if (file_exists($config['upload_path'] . "$filename")) {
                    unlink($config['upload_path'] . "$filename");
                }
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if ($this->upload->do_upload("profile_image")) {
                    $data_image = $this->upload->data();
                    $data['profile_image'] = $data_image['file_name'];
                }
            } else {
                return false;
            }
        }
        if ($this->db->update(USERS, $data, "user_id=" . $post_arr['user_id'])) {
            return true;
        }
    }

    function get_total_colleges() {
        $this->db->select('*');
        $this->db->from(COLLEGE);
        $query = $this->db->get();
        return $query->num_rows();
    }

    function get_total_providers() {
        $this->db->select('*');
        $this->db->from(USERS . ' u');
        $cnd = "u.user_type='3' OR u.user_type='5'";
        $this->db->where($cnd);
        $query = $this->db->get();
        return $query->num_rows();
    }

    function get_total_patients() {
        $this->db->select('*');
        $this->db->from(USERS . ' u');
        $this->db->where('u.user_type', 4);
        $query = $this->db->get();
        return $query->num_rows();
    }

    function get_total_appointment() {
        $this->db->select('*');
        $this->db->from(APPOINTMENTS);
        $this->db->where('status', 1);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function get_LastTransactions() {
        $this->db->select('concat(u.first_name," ",u.last_name) as provider_name,av.start_date,av.end_date,av.start_time,av.end_time,t.amount,t.transaction_no, (select concat(first_name," ",last_name)  from bm_users where user_id = a.patient_id) as patient_name  ');
        $this->db->from(USERS . ' u');
        $this->db->join(APPOINTMENTS . ' a', 'a.provider_id = u.user_id');
        $this->db->join(TRANSACTIONS . ' t', 't.appointment_id = a.app_id');
        $this->db->join(AVAILABALITY . ' av', 'av.avail_id = a.slot_id');
        $counselor_cnd = "u.user_type IN (3,5)";
        $this->db->where($counselor_cnd);
        $this->db->where("t.payent_status", '1');
        $this->db->where("a.status", '1');
        $this->db->limit(10);
        $this->db->order_by('a.booked_on', 'desc');
        $query = $this->db->get();
        //echo $this->db->last_Query(); die;
        if ($query->num_rows() > 0) {
            $data = $query->result();
            return $data;
        } else {
            return array();
        }
    }

    public function get_upcoming_appointment($limit = null) {
        $data = array();
        $this->db->select('concat(u.first_name," ",u.last_name) as provider_name,av.start_date,av.end_date,av.start_time,av.end_time, (select concat(first_name," ",last_name)  from bm_users where user_id = a.patient_id) as patient_name  ');
        $this->db->from(USERS . ' u');
        $this->db->join(APPOINTMENTS . ' a', 'a.provider_id = u.user_id');
        $this->db->join(TRANSACTIONS . ' t', 't.appointment_id = a.app_id and t.transaction_type = "charge"');
        $this->db->join(AVAILABALITY . ' av', 'av.avail_id = a.slot_id');
        $usr_typ_cnd = "(u.user_type='3' OR u.user_type='5')";
        $this->db->where($usr_typ_cnd);
        $this->db->where("a.status", '1');
        $this->db->where('concat_ws(" ",av.start_date,av.start_time) >= ', date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . " - 15 minutes")));
        if ($limit) {
            $this->db->limit(10);
        }
        $this->db->order_by('t.date_created', 'desc');
        $query = $this->db->get();
        //prd($query->result(), 1);
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }
    }

    function get_appointment_transaction($filter = array(), $detailed = false) {
        $sql = "";
        if (!$detailed) {
            $sql .= "SELECT at.provider_id, at.date_created, u.*, s.first_name as student_first_name, s.last_name as student_last_name,c.college_name, av.start_date, av.start_time
                    , SUM(COALESCE(CASE WHEN at.transaction_type = 'refund' THEN at.remain_session_cost END,0)) total_refunds
                    , SUM(COALESCE(CASE WHEN at.transaction_type = 'charge' THEN at.amount END,0)) total_charges
                    , SUM(COALESCE(CASE WHEN at.transaction_type = 'charge' THEN at.remain_session_cost END,0)) total_paid_charges
                    , SUM(COALESCE(CASE WHEN at.transaction_type = 'charge' THEN at.amount_to_provider END,0))
                    - SUM(COALESCE(CASE WHEN at.transaction_type = 'refund' THEN at.amount_to_provider END,0)) balance
                    , SUM(COALESCE(CASE WHEN at.transaction_type = 'charge' THEN at.discount_amount END,0))
                    - SUM(COALESCE(CASE WHEN at.transaction_type = 'refund' THEN at.discount_amount END,0)) discount_amt
                    , SUM(COALESCE(CASE WHEN at.transaction_type = 'charge' THEN at.remain_session_cost END,0))
                    - SUM(COALESCE(CASE WHEN at.transaction_type = 'refund' THEN at.remain_session_cost END,0)) paid_amt
                    , SUM(COALESCE(CASE WHEN at.transaction_type = 'charge' THEN at.amount END,0))
                    - SUM(COALESCE(CASE WHEN at.transaction_type = 'refund' THEN at.amount END,0)) gross_balance
                    , SUM(COALESCE(CASE WHEN at.transaction_type = 'charge' THEN at.amount_to_bm END,0))
                    - SUM(COALESCE(CASE WHEN at.transaction_type = 'refund' THEN at.amount_to_bm END,0)) balance_bm ";
        } else {
            $sql .= "SELECT at.* , s.first_name as student_first_name, s.last_name as student_last_name,c.college_name, av.start_date, av.start_time";
        }
        $sql .= " FROM " . DB_PREFIX . TRANSACTIONS . " at
                JOIN " . DB_PREFIX . USERS . " u on u.user_id = at.provider_id
                JOIN " . DB_PREFIX . USERS . " s on s.user_id = at.patient_id
                JOIN " . DB_PREFIX . APPOINTMENTS . " ap on ap.app_id = at.appointment_id
                JOIN " . DB_PREFIX . AVAILABALITY . " av on av.avail_id = ap.slot_id
                JOIN " . DB_PREFIX . COLLEGE . " c on c.college_id = s.college_id
                WHERE at.payent_status = 1 ";

        if ($filter['start_date'] && $filter['end_date']) {
            $filter['start_date'] = $this->basic_model->set_utc_datetime($filter['start_date']);
            $filter['end_date'] = $this->basic_model->set_utc_datetime($filter['end_date']);
            //$sql .= " and (DATE_FORMAT(at.date_created, '%m/%d/%Y') BETWEEN DATE_FORMAT('{$filter['start_date']}', '%m/%d/%Y') AND DATE_FORMAT('{$filter['end_date']}', '%m/%d/%Y')) ";
            $sql .= " and date_created >= '{$filter['start_date']}' AND date_created <= '{$filter['end_date']}'";
        }
        if ($filter['provider_id']) {
            $sql .= " and at.provider_id = {$filter['provider_id']}";
        } else {
            $sql .= " GROUP BY at.provider_id";
        }
        $sql .= " ORDER BY at.appointment_id DESC, at.date_created ASC";

        return $this->db->query($sql)->result();
    }

    public function getwelcomeData($cond) {
        return $this->db->get_where(WELCOME_NOTES, $cond)->row();
    }

    public function updatewelcomeData($data = array()) {

        $is_notes = $this->db->query("select * from " . DB_PREFIX . WELCOME_NOTES . " where college_id = '" . $data['college_id'] . "'")->result();
        if (isset($_FILES['logo_image']) && $_FILES['logo_image']['size'] > 0) {
            $profileimage = $_FILES['logo_image'];
            $extenstion = $this->basic_model->get_extension($profileimage['name']);
            if ($extenstion != "error") {
                $filename = $profileimage['name'] . "." . $extenstion;
                $config['upload_path'] = FILE_UPLOAD_PATH . 'welcome_note_image/';
                $config['allowed_types'] = 'jpg|png|jpeg|gif';
                $config['max_size'] = 1024 * 2;
                $config['file_name'] = $filename;
                if (file_exists($config['upload_path'] . "$filename")) {
                    unlink($config['upload_path'] . "$filename");
                }
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if ($this->upload->do_upload("logo_image")) {
                    $data_image = $this->upload->data();
                    $data['logo_image'] = $data_image['file_name'];
                }
            } else {
                return false;
            }
        }
        if (isset($_FILES['logocover_image']) && $_FILES['logocover_image']['size'] > 0) {
            $profileimage = $_FILES['logocover_image'];
            $extenstion = $this->basic_model->get_extension($profileimage['name']);
            if ($extenstion != "error") {
                $filename = $profileimage['name'] . "." . $extenstion;
                $config['upload_path'] = FILE_UPLOAD_PATH . 'welcome_note_image/';
                $config['allowed_types'] = 'jpg|png|jpeg|gif';
                $config['max_size'] = 1024 * 2;
                $config['file_name'] = $filename;
                if (file_exists($config['upload_path'] . "$filename")) {
                    unlink($config['upload_path'] . "$filename");
                }
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if ($this->upload->do_upload("logocover_image")) {
                    $data_image = $this->upload->data();
                    $data['logo_cover'] = $data_image['file_name'];
                } else {
//                    echo '<pre>';
//                    print_r($this->upload->display_errors());
                }
            } else {
                return false;
            }
        }
        if (isset($is_notes[0]->notes_id) && $is_notes[0]->notes_id > 0) {
            $query = $this->db->update(WELCOME_NOTES, $data, array("notes_id" => $is_notes[0]->notes_id));
            $note_id = $is_notes[0]->notes_id;
        } else {
            $query = $this->db->insert(WELCOME_NOTES, $data);
            $note_id = $this->db->insert_id();
        }

        return $note_id;
    }

    public function getwelcome_imageData($notesid = array()) {
        return $this->db->get_where('welcome_note_image', $notesid)->result();
    }

    public function welcome_note_image($data = array()) {
        $current_user = $this->ion_auth->user()->row();
        if (isset($_FILES['upload_image']) && $_FILES['upload_image']['size'] > 0) {
            $uploadimage = $_FILES['upload_image'];
            $extenstion = $this->basic_model->get_extension($uploadimage['name']);
            if ($extenstion != "error") {
                $filename = $uploadimage['name'] . "." . $extenstion;
                $config['upload_path'] = FILE_UPLOAD_PATH . 'welcome_note_image/';
                $config['allowed_types'] = 'jpg|png|jpeg|gif';
                $config['max_size'] = 1024 * 2;
                $config['file_name'] = $filename;
                if (file_exists($config['upload_path'] . "$filename")) {
                    unlink($config['upload_path'] . "$filename");
                }
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if ($this->upload->do_upload("upload_image")) {
                    $data_image = $this->upload->data();
                    $data['image'] = $data_image['file_name'];
                    return $this->db->insert('welcome_note_image', $data);
                } else {
                    return false;
                }
            }
        } else {
            return true;
        }
    }

    public function updatebettermynd_noteData($data = array()) {
        $is_notes = $this->db->query("select * from " . DB_PREFIX . WELCOME_NOTES . " where notes_id = '" . $data['notes_id'] . "'")->result();
        if (isset($is_notes[0]->notes_id) && $is_notes[0]->notes_id > 0) {
            return $this->db->update(WELCOME_NOTES, $data, array("notes_id" => $is_notes[0]->notes_id));
        } else {
            return $this->db->insert(WELCOME_NOTES, $data);
        }
    }

    function get_user_detail($user_id, $user_role = 4) {
        $this->db->select('*');
        $this->db->from(USERS . ' u');
        $this->db->join(COLLEGE . ' c', 'c.college_id = u.college_id', 'left');
        $this->db->where('u.user_id', $user_id);
        return $this->db->get()->row();
    }

    function get_login_logs($user_id, $filter = array()) {
        $sql = "SELECT * FROM " . DB_PREFIX . LOGIN_LOG . " WHERE user_id = '$user_id'";
        if ($filter['start_date']) {
            $filter['start_date'] = $filter['start_date'] . ' ' . date('H:i:s');
            $filter['start_date'] = $this->basic_model->set_utc_datetime($filter['start_date']);
            $sql .= " and DATE_FORMAT(loggedin_on, '%m/%d/%Y') >= DATE_FORMAT('{$filter['start_date']}', '%m/%d/%Y')";
        }
        if ($filter && $filter['end_date']) {
            $filter['end_date'] = $filter['end_date'] . ' ' . date('H:i:s');
            $filter['end_date'] = $this->basic_model->set_utc_datetime($filter['end_date']);

            $sql .= " and DATE_FORMAT(loggedin_on, '%m/%d/%Y') <= DATE_FORMAT('{$filter['end_date']}', '%m/%d/%Y')";
        }
        $sql .= " ORDER BY loggedin_on DESC";
        //prd($sql, 1);
        return $this->db->query($sql)->result();
    }

    function delete_welcome_image($id) {
        if ($this->db->delete("welcome_note_image", "id = " . $id)) {
            return true;
        } else {
            return false;
        }
    }

}
