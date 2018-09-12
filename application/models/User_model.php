<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User_model extends CI_Model {

    function __construct() { // Constructor
        parent::__construct();
    }

     function update_user() {
        $username = $this->input->post('username');
        $user_email = $this->input->post('user_email');
        $office_phone = $this->input->post('office_phone');
        $mobile_phone = $this->input->post('mobile_phone');
        $address = $this->input->post('address');
        $zipcode = $this->input->post('zipcode');
        $state = $this->input->post('state');
        $biography = $this->input->post('biography');
        $fb_url = $this->input->post('fb_url');
        $twitter_url = $this->input->post('twitter_url');
        $linkedin_url = $this->input->post('linkedin_url');
        $youtube_url = $this->input->post('youtube_url');
        $current_user_id = $this->input->post('user_id');
        $newsletter_checked = $this->input->post('is_newsletter');
        $account_holder_name = $this->input->post('account_holder_name');

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
            "state" => $state,
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
            $this->session->set_flashdata('message', 'User Profile updated successfully.');
            return;
        }
    }
}
