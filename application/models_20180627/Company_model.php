<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Company_model extends CI_Model {

    function __construct() { // Constructor
        parent::__construct();
    }

    function encrypt_str($str) {
        $str = md5(md5(md5(md5($str))));
        return $str;
    }

    function get_company_invoices($user_id) {
        $query = "select t.*,u.username,u.account_holder_name from " . TRANSACTIONS . " as t," . USERS . " as u where md5(md5(md5(md5(t.user_id))))='" . $user_id . "' and t.user_id=u.user_id order by t.transaction_date DESC";

        $sql = $this->db->query($query);
        $result = $sql->result_array();
        if (count($result)) {
            return $result;
        } else {
            return "";
        }
    }

    function get_invoice_detail($transaction_id) {

        $query = "select t.*,u.username,u.account_holder_name from " . TRANSACTIONS . " as t," . USERS . " as u where t.user_transaction_id='" . $transaction_id . "' and t.user_id=u.user_id order by t.transaction_date DESC";
        $sql = $this->db->query($query);
        $result = $sql->result_array();
        if (count($result)) {
            return $result[0];
        } else {
            return "";
        }
    }

    function get_transaction_detail($transaction_id) {

        $query = "select t.*,u.username,u.user_email,u.account_holder_name,u.mobile_phone,u.address,u.zipcode from " . TRANSACTIONS . " as t," . USERS . " as u where t.transaction_number='" . $transaction_id . "' and t.user_id=u.user_id order by t.transaction_date DESC";
        $sql = $this->db->query($query);
        $result = $sql->result_array();
        if (count($result)) {
                $subTotal = trim($result[0]['sub_total']);
                if(isset($result[0]['discount_percentage']) && $result[0]['discount_percentage'] > 0)
                {
                    $discountFigure = ($subTotal * $result[0]['discount_percentage']) / 100;
                    $result[0]['total_amount_after_discount'] = $subTotal - $discountFigure;
                }else{
                    $result[0]['total_amount_after_discount'] = $subTotal;
                }
            
            return $result[0];
        } else {
            return "";
        }
    }

    function update_profile() {
        $username = ltrim(rtrim($this->input->post('username')));
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
        $current_user_id = $this->input->post('user_id');
        $newsletter_checked = $this->input->post('is_newsletter');
        $account_holder_name = ltrim(rtrim($this->input->post('account_holder_name')));

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
            "account_holder_name" => $account_holder_name
//		"email"=>$usermail
        );

        if (isset($_FILES['profile_photo']) && $_FILES['profile_photo']['size'] > 0) {
            $profileimage = $_FILES['profile_photo'];
            $extenstion = $this->basic_model->get_extension($profileimage['name']);
            if ($extenstion != "error") {

                $filename = $current_user_id . "primary." . $extenstion;
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
				else{
					echo "<pre>";
									print_r( $this->upload->display_errors());
									echo "</pre>";
									exit;
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

    function update_company_profile() {
        $company_name = $this->input->post('company_name');
        $user_id = $this->input->post('user_id');
        $company_url = $this->input->post('company_url');
        $primary_account_holder = $this->input->post('primary_account_holder');
        $company_general_email = $this->input->post('company_general_email');
        $company_support_email = $this->input->post('company_support_email');
        $office_phone = $this->input->post('office_phone');
        $office_phone2 = $this->input->post('office_phone2');
        $company_address = $this->input->post('company_address');
        $company_state = $this->input->post('state');
        $company_zipcode = $this->input->post('company_zipcode');
        $company_website = $this->input->post('company_website');
        $company_fax_number = $this->input->post('company_fax_number');
        $company_desc = $this->input->post('company_desc');
        $company_mission_stmt = $this->input->post('company_mission_stmt');
        $company_logo1 = $this->input->post('company_logo1');
        $company_logo2 = $this->input->post('company_logo2');
        $company_logo1_color1 = $this->input->post('company_logo1_color1');
        $company_logo1_color2 = $this->input->post('company_logo1_color2');
        $company_logo2_color1 = $this->input->post('company_logo2_color1');
        $company_logo2_color2 = $this->input->post('company_logo2_color2');
        $company_fb_url = $this->input->post('company_fb_url');
        $company_twitter_url = $this->input->post('company_twitter_url');
        $company_linkedin_url = $this->input->post('company_linkedin_url');
        $company_youtube_url = $this->input->post('company_youtube_url');
        $bullet_icon = $this->input->post('bullet_icon');
        $company_licence_number = $this->input->post('company_licence_number');

        //$current_user_id = $this->ion_auth->user()->row()->id;

        $data = array(
            "company_name" => $company_name,
            "company_url" => $company_url,
            "user_id" => $user_id,
            "primary_account_holder" => $primary_account_holder,
            "company_support_email" => $company_support_email,
            "company_general_email" => $company_general_email,
            "office_phone" => $office_phone,
            "office_phone2" => $office_phone2,
            "company_address" => $company_address,
            "company_state" => $company_state,
            "company_zipcode" => $company_zipcode,
            "company_website" => $company_website,
            "company_fax_number" => $company_fax_number,
            "company_desc" => $company_desc,
            "company_mission_stmt" => $company_mission_stmt,
            "company_logo1" => $company_logo1,
            "company_logo2" => $company_logo2,
            "company_logo1_color1" => $company_logo1_color1,
            "company_logo1_color2" => $company_logo1_color2,
            "company_logo2_color1" => $company_logo2_color1,
            "company_logo2_color2" => $company_logo2_color2,
            "company_fb_url" => $company_fb_url,
            "company_twitter_url" => $company_twitter_url,
            "company_linkedin_url" => $company_linkedin_url,
            "company_youtube_url" => $company_youtube_url,
            "company_licence_number" => $company_licence_number,
            "bullet_icon" => $bullet_icon,
            "company_createdon" => date(DATE_FORMAT)
        );

        if (isset($_FILES['company_logo1']) && $_FILES['company_logo1']['size'] > 0) {
            $profileimage = $_FILES['company_logo1'];
            $extenstion = $this->basic_model->get_extension($profileimage['name']);
            if ($extenstion != "error") {

                $filename = $user_id . "_primary." . $extenstion;
                $config['upload_path'] = FILE_UPLOAD_PATH . "logo/";
                $config['allowed_types'] = 'jpg|png|jpeg|gif';
                $config['file_name'] = $filename;
                if (file_exists($config['upload_path'] . "$filename")) {
                    unlink($config['upload_path'] . "$filename");
                }

                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if ($this->upload->do_upload("company_logo1")) {
                    $data_image = $this->upload->data();
                    $data['company_logo1'] = $data_image['file_name'];
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

                $filename = $user_id . "_secondary." . $extenstion;
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
        $this->db->select('*');
        $this->db->from('brandize_user_company');
        $this->db->where('user_id', $user_id);
        $query = $this->db->get();

        if ($query->num_rows() == 0) {
            if ($this->db->insert(USER_COMPANY, $data)) {
                $this->session->set_flashdata('message', 'Profile successfully added.');
            }
        } else {
            if ($this->db->update(USER_COMPANY, $data, "user_id=" . $user_id)) {
                $this->session->set_flashdata('message', 'Profile successfully updated.');
                //return;
            }
        }

        $company_id = $this->db->get_where(USER_COMPANY, array('user_id' => $user_id))->row()->company_id;

        $heading_title = $this->input->post('heading_title');
        $heading_subtitle = $this->input->post('heading_subtitle');
        $heading_id = $this->input->post('heading_id');
        $heading_title = array_filter($heading_title);
        if (!empty($heading_title)) {
            foreach ($heading_title as $key => $heading) {
                $data = array(
                    'heading_title' => $heading,
                    'heading_subtitle' => $heading_subtitle[$key],
                    'company_id' => $company_id,
                    'heading_createdon' => date('Y-m-d h:i:s'),
                    'heading_status' => '1'
                );
                if (isset($heading_id[$key]) && $heading_id[$key] != "") {
                    $this->db->update(COMPANY_HEADING, $data, "heading_id=" . $heading_id[$key]);
                } else {
                    $this->db->insert(COMPANY_HEADING, $data);
                }
            }
        }

        $bullet_detail = $this->input->post('bullet_detail');
        $company_bullet_id = $this->input->post('company_bullet_id');
        $bullet_detail = array_filter($bullet_detail);
        if (!empty($bullet_detail)) {
            foreach ($bullet_detail as $key => $value) {
                $data = array(
                    'bullet_detail' => $value,
                    'bullet_status' => '1',
                    'bullet_company_id' => $company_id,
                    'bullet_adddate' => date('Y-m-d h:i:s')
                );
                if (isset($company_bullet_id[$key]) && $company_bullet_id[$key] != "" && count($company_bullet_id) > 0) {
                    $this->db->update(COMPANY_BULLETS, $data, "company_bullet_id=" . $company_bullet_id[$key]);
                } else {
                    $this->db->insert(COMPANY_BULLETS, $data);
                }
            }
        }

        $feature_title = $this->input->post('feature_title');
        $feature_description = $this->input->post('feature_description');
        $feature_id = $this->input->post('feature_id');
        $feature_icon = $this->input->post('feature_icon');
        $feature_title = array_filter($feature_title);
        if (!empty($feature_title)) {
            foreach ($feature_title as $key => $feature) {
                $data = array(
                    'feature_title' => $feature,
                    'feature_description' => $feature_description[$key],
                    'feature_icon' => $feature_icon[$key],
                    'feature_company_id' => $company_id,
                    'feature_status' => '1',
                    'feature_adddate' => date('Y-m-d h:i:s')
                );
                if (isset($feature_id[$key]) && $feature_id[$key] != "") {
                    $this->db->update(COMPANY_FEATURES, $data, "feature_id=" . $feature_id[$key]);
                } else {
                    $this->db->insert(COMPANY_FEATURES, $data);
                }
            }
        }
    }

    function get_company_heading($company_id) {
        $this->db->select('*');
        $this->db->where('company_id', $company_id);
        $this->db->where('heading_status', '1');
        $this->db->from(COMPANY_HEADING);
        $this->db->order_by('heading_id');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }
    }

    function get_company_bullets($company_id) {
        $this->db->select('*');
        $this->db->where('bullet_company_id', $company_id);
        $this->db->where('bullet_status', '1');
        $this->db->from(COMPANY_BULLETS);
        $this->db->order_by('company_bullet_id');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }
    }

    function get_company_feature($company_id) {
        $this->db->select('*');
        $this->db->where('feature_company_id', $company_id);
        $this->db->where('feature_status', '1');
        $this->db->from(COMPANY_FEATURES);
        $this->db->order_by('feature_company_id');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }
    }

    function geticon($el_id, $limit) {
        $this->db->select('*');
        $this->db->from(MST_ICONS);
        $query = $this->db->get();
        $rows = $query->num_rows();

        $this->db->select('*');
        $this->db->from(MST_ICONS);
        $this->db->limit(48, $limit * 48);
        $query = $this->db->get();
        $query = $query->result();

        $class = $limit * 48 <= $rows && count($query) == 48 ? 'show' : 'hide';
        $prev = isset($limit) && $limit == 0 ? 'hide' : 'show';
        $str = '<div class="icon_features">
          <ul class="icon_listing iconno1" data-info="' . $el_id . '">';
        if (count($query) > 0) {
            foreach ($query as $v) {
                $str .= "<li><img src='" . IMAGES_URL . "icons/" . $v->icon_name . "'></li>";
            }
        } else {
            $str .="<p class='text-center'>No more icons to load</p>";
        }
        $str .='</ul>'
                . '</div><div class="clearfix popover_footer"><a href="javascript:void(0);" class="prev btn btn-default ' . $prev . '" data-page="' . $limit . '" >  &laquo; Prev</a> <a href="javascript:void(0);" data-page="' . $limit . '" class="next btn  btn-default ' . $class . '">Next &raquo;</a></div>';
        return $str;
    }

    function delete_heading() {
        $data = array(
            'heading_id' => $this->input->post('heading_id')
        );
        if ($this->db->delete(COMPANY_HEADING, $data)) {
            $this->session->set_flashdata('message', 'Heading Deleted Successfully.');
            return '1';
        } else {
            return '0';
        }
    }

    function delete_bullet() {
        $data = array(
            'company_bullet_id' => $this->input->post('company_bullet_id')
        );
        if ($this->db->delete(COMPANY_BULLETS, $data)) {
            $this->session->set_flashdata('message', 'Bullet Deleted Successfully.');
            return '1';
        } else {
            return '0';
        }
    }

    function delete_feature() {
        $data = array(
            'feature_id' => $this->input->post('feature_id')
        );
        if ($this->db->delete(COMPANY_FEATURES, $data)) {
            $this->session->set_flashdata('message', 'Features Deleted Successfully.');
            return '1';
        } else {
            return '0';
        }
    }
   function get_userlist($company_id=false) {
        $data = array(
            'user_role' => 3
        );
		if(isset($company_id) && $company_id>0){
		
	
 $query="select u.*, (select GROUP_CONCAT(ug.group_id)  from  ".USER_GROUPS." ug where ug.user_id=u.user_id) as group_user from ".USERS." u where (u.user_role=3 or u.user_role=5) and u.user_company_id=".$company_id." order by u.user_id desc";
        
        $query=$this->db->query($query);
        
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
		
		}
    }

    function update_user() {
        $username = $this->input->post('username');
        $user_email = $this->input->post('user_email');
        $mobile_phone = $this->input->post('mobile_phone');
        $current_user_id = $this->input->post('user_id');
        $account_holder_name = $this->input->post('account_holder_name');
        $level = $this->input->post('level');
        $data = array(
            "user_email" => $user_email,
            "mobile_phone" => $mobile_phone,
            "account_holder_name" => $account_holder_name,
            "user_role" => $level
        );

        if ($this->db->update(USERS, $data, "user_id=" . $current_user_id)) {
            $groups = $this->input->post('groups');
            if (count($groups) > 0 && !empty($groups)) {
                if ($this->db->delete(USER_GROUPS, array('user_id' => $current_user_id))) {
                    foreach ($groups as $v) {
                        $this->db->select('*');
                        $this->db->from(USER_GROUPS);
                        $this->db->where('group_id', $v);
                        $this->db->where('user_id', $current_user_id);
                        $query = $this->db->get();
                        if ($query->num_rows() == 0) {
                            $data = array(
                                'group_id' => $v,
                                'user_id' => $current_user_id,
                                'user_group_assign_date' => date('Y-m-d h:i:s')
                            );
                            $this->db->insert(USER_GROUPS, $data);
                        }
                    }
                }
            }
            $this->session->set_flashdata('message', 'Profile successfully updated.');
            return;
        }
    }

    function user_transactions($cid = false) {

        $this->db->select('u.username,u.user_email,u.user_id,t.transaction_number,t.transaction_date,m.package_mode,t.sub_total,t.discount_percentage,t.transaction_description, t.subscription_end_date');
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

    function user_assign_groups($user_id) {
        $groups = $this->input->post('groups');
        if (isset($groups) && !empty($groups) && count($groups) > 0) {
            foreach ($groups as $value) {
                $this->db->select('*');
                $this->db->from(USER_GROUPS);
                $this->db->where('group_id', $value);
                $this->db->where('user_id', $user_id);
                $query = $this->db->get();

                if ($query->num_rows() == 0) {
                    $data = array(
                        'group_id' => $value,
                        'user_id' => $user_id,
                        'user_group_assign_date' => date('Y-m-d h:i:s')
                    );
                    $this->db->insert(USER_GROUPS, $data);
                }
            }
        }
    }

    function update_user_group() {
        $user_id = $this->input->post('user_id');
        $value = $this->input->post('value');
        $group_id = explode(',', $value);
        if (count($group_id) > 0 && !empty($group_id)) {

            if ($this->db->delete(USER_GROUPS, array('user_id' => $user_id))) {
                if ($group_id[0] != 'null') {
                    foreach ($group_id as $v) {
                        $this->db->select('*');
                        $this->db->from(USER_GROUPS);
                        $this->db->where('group_id', $v);
                        $this->db->where('user_id', $user_id);
                        $query = $this->db->get();
                        if ($query->num_rows() == 0) {
                            $data = array(
                                'group_id' => $v,
                                'user_id' => $user_id,
                                'user_group_assign_date' => date('Y-m-d h:i:s')
                            );
                            $this->db->insert(USER_GROUPS, $data);
                        }
                    }
                }
            }
        } else {
            return false;
        }
    }

    function get_users_groups($user_id) {
        $this->db->select('GROUP_CONCAT(group_id) as user_group');
        $query = $this->db->get_where(USER_GROUPS, array('user_id' => $user_id));
        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }
    
    function get_support_videos(){
        $this->db->select('*');
        $query = $this->db->get_where(SUPPORT_VIDEOS, array('status' => '1'));
        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }

   

}
