<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Affiliate_model extends CI_Model {

    function __construct() { // Constructor
        //  $this->load->library('libs3');
        parent::__construct();
    }

    function update_profile() {
        // $username = $this->input->post('username');
        $user_email = ltrim(rtrim($this->input->post('user_email')));
        $office_phone = ltrim(rtrim($this->input->post('office_phone')));
        $mobile_phone = ltrim(rtrim($this->input->post('mobile_phone')));
        $address = ltrim(rtrim($this->input->post('address')));
        $zipcode = ltrim(rtrim($this->input->post('zipcode')));
        $website = ltrim(rtrim($this->input->post('website')));
        $state = ltrim(rtrim($this->input->post('state')));
        $fax_number = ltrim(rtrim($this->input->post('fax_number')));
        $biography = ltrim(rtrim($this->input->post('biography')));
        $fb_url = ltrim(rtrim($this->input->post('fb_url')));
        $twitter_url = ltrim(rtrim($this->input->post('twitter_url')));
        $linkedin_url = ltrim(rtrim($this->input->post('linkedin_url')));
        $youtube_url = ltrim(rtrim($this->input->post('youtube_url')));
        $current_user_id = ltrim(rtrim($this->input->post('user_id')));
        $newsletter_checked = ltrim(rtrim($this->input->post('is_newsletter')));
        $account_holder_name = ltrim(rtrim($this->input->post('account_holder_name')));
        $paypal_email = ltrim(rtrim($this->input->post('paypal_email')));

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
            "is_newsletter" => $newsletter_checked,
            "account_holder_name" => $account_holder_name,
            "paypal_email" => $paypal_email
//		"email"=>$usermail
        );


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

        if ($this->db->update(USERS, $data, "user_id=" . $current_user_id)) {
            $this->session->set_flashdata('message', 'Profile successfully updated.');
            return;
        }
    }

    function ref_company() {
        $sponsor = $this->session->userdata('username');
        $this->db->select('u.*,uc.company_url,uc.company_name');
        $this->db->from(USERS . ' u');
        $this->db->join(USER_COMPANY . ' uc', 'uc.user_id=u.user_id');
        $this->db->where('u.sponsor', $sponsor);
        $this->db->where('u.user_role', '2');
        $this->db->order_by('u.user_createdon','DESC');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    function ref_user() {
        $sponsor = $this->session->userdata('username');
        $this->db->select('u.*,uc.company_url,uc.company_name');
        $this->db->from(USERS . ' u');
        $this->db->join(USER_COMPANY . ' uc', 'uc.company_id=u.user_company_id');
        $this->db->where('u.sponsor', $sponsor);
        $this->db->where('u.user_role', '3');
        $this->db->order_by('u.user_createdon','DESC');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    function referrer_count() {
        $sponsor = $this->session->userdata('username');
        $sql = "SELECT * FROM " . REFERRAL_STATS . " WHERE sponsor IN (SELECT username FROM " . USERS . " WHERE `user_role`=4) and sponsor='" . $sponsor . "'    GROUP BY user_type,ip_address";
        $query = $this->db->query($sql);
        $result = $query->result();
        $num = count($result);
        return $num;
    }

    function count_active_member() {
        $sponsor = $this->session->userdata('username');
        $this->db->select('*');
        $this->db->from(USERS);
        $this->db->where('sponsor', $sponsor);
        $this->db->where('user_status', '1');
        $query = $this->db->get();
        $result = $query->result();
        return $query->num_rows();
    }

    function get_commission_amount($list = false) {
        $sponsor = $this->session->userdata('username');
        $date = explode('-', $list);
        $d = $date[0];
        $y = $date[1];
        $sql = "select sum(commision_amount) commision_amt,sponsor,generated_on from " . AFFILIATE_COMMISSION . " where month(generated_on) ='" . $d . "' and YEAR(generated_on) = '$y' and sponsor = '" . $sponsor . "' group by sponsor";
        $query = $this->db->query($sql);
        $result = $query->result();
        if ($query->num_rows() == 1) {
            return $result[0]->commision_amt;
        } else {
            return 0;
        }
    }

    function affiliate_sales() {
        $sponsor = $this->session->userdata('username');
        $sql = "SELECT DATE_FORMAT(FROM_UNIXTIME(user_createdon), '%Y-%m') as y, count(user_id) as a FROM " . USERS . " WHERE sponsor='" . $sponsor . "' and DATE_FORMAT(FROM_UNIXTIME(user_createdon), '%Y')='".date('Y')."'  group by sponsor , y";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        $year=date('Y');
        $array=array();
        $j=0;
        
        for($i=1;$i<=12;$i++){
            $monthYear=$year.'-'.str_pad($i, 2, "0", STR_PAD_LEFT);
            $array[$j]['y']=$monthYear;
            $array[$j]['a']='0';
            $j++;
        }
        foreach($array as $key=>$value){
            foreach($result as $newarray){
                if(in_array($value['y'], $newarray)){
                    $array[$key]['a']=$newarray['a'];
                }
            }
        }
        return json_encode($array);
    }

    function trainingSteps($active = false) {
        $query = "select *  from " . AFFILIATE_TRAINING . " where status='1' ";

        $query.=" order by tstep_id ASC";
        $sql = $this->db->query($query);
        $result = $sql->result_array();
        return $result;
    }

    function trainingStepContents($step_id) {
        $query = "select *  from " . TRAINING_MEDIA . " where affiliate_training_id='" . $step_id . "' order by ts_id DESC";
        $sql = $this->db->query($query);
        return $result = $sql->result_array();
    }

}
