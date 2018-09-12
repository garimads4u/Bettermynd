<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class College_model extends CI_Model {

    function __construct() { // Constructor
        parent::__construct();
    }

    public function getCollege() {
        $college = array('' => 'Select College');
        $this->db->select('c.college_id,c.college_name');
        $this->db->from(COLLEGE . ' c');
        $this->db->join(USERS . ' u', 'c.uid = u.user_id');
        $this->db->where('u.user_status', 1);
        $this->db->where('u.user_type', 2);
        $this->db->order_by('c.college_name', 'asc');
        $query = $this->db->get();
        if ($query->result()) {
            foreach ($query->result() as $c) {
                $college[$c->college_id] = $c->college_name;
            }
        }
        return $college;
    }

    public function get_ProviderList($user_id) {
        $this->db->select('u.*,c.college_name');
        $this->db->from(USERS . ' u');
        $this->db->join(COLLEGE . ' c', 'c.college_id = u.college_id');
        $this->db->where('u.user_type', 3);
        $this->db->where('c.uid', $user_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function get_ProviderListByCollege($college_id) {
        $this->db->select('u.*,c.college_name');
        $this->db->from(USERS . ' u');
        $this->db->join(COLLEGE . ' c', 'c.college_id = u.college_id');
        $this->db->where('u.user_type', 3);
        $this->db->where('c.college_id', $college_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function provider_update_status() {
        $is_disabled = 0;
        if ($this->input->post('status') == '1') {
            $is_disabled = 1;
        }
        $data = array(
            'user_status' => intval($this->input->post('status')),
            'is_disabled' => $is_disabled
        );
        if ($this->db->update(USERS, $data, "user_id=" . $this->input->post('user_id'))) {
            return '1';
        } else {
            return '0';
        }
    }

    public function getProviderData($uid, $college_user_id) {
        $this->db->select('u.*,p.*');
        $this->db->from(USERS . ' u');
        $this->db->join(PROVIDER_PROFILE . ' p', "u.user_id = p.provider_id", "left");
        $this->db->join(COLLEGE . ' c', "c.college_id = u.college_id");
        $this->db->where("u.user_id", $uid);
        //$this->db->where("c.uid", $college_user_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $data = $query->result();
            return $data[0];
        } else {
            return array();
        }
    }

    public function update_provider($post_arr) {

        $edit_id = base64_decode($post_arr['edit_id']);
        $first_name = $post_arr['first_name'];
        $last_name = $post_arr['last_name'];
        $mobile_no = $post_arr['mobile_no'];
        $college_id = $post_arr['college_id'];
        $timezone = $post_arr['timezone'];

        $data = array(
            "first_name" => $first_name,
            "last_name" => $last_name,
            "mobile_no" => $mobile_no,
            "college_id" => $college_id,
            "timezone_id" => $timezone
        );

        if ($post_arr['timezone']) {
            $timezone_code = $this->db->select('timezone_code')->from(TIMEZONE)->where('timezone_value', trim($post_arr['timezone']))->get()->row();
            if ($timezone_code && $timezone_code->timezone_code) {
                $data['timezone_code'] = $timezone_code->timezone_code;
            }
        }

        if (isset($_FILES['profile_image']) && $_FILES['profile_image']['size'] > 0) {
            $profileimage = $_FILES['profile_image'];
            $extenstion = $this->basic_model->get_extension($profileimage['name']);
            if ($extenstion != "error") {
                $filename = $edit_id . "." . $extenstion;
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

        if ($this->db->update(USERS, $data, "user_id=" . $edit_id)) {
            $res['session_cost'] = $post_arr['session_cost'];
            $res['biography'] = $post_arr['biography'];
            $res['specialities'] = @implode(',', $post_arr['specialities']);

            $profile_id = $this->provider_model->getProviderProfile($edit_id);
            if (isset($profile_id) && !empty($profile_id)) {
                $this->db->update(PROVIDER_PROFILE, $res, "provider_id=" . $edit_id);
                return true;
            } else {
                $res['provider_id'] = $edit_id;
                $this->db->insert(PROVIDER_PROFILE, $res);
                return true;
            }
            $this->session->set_flashdata('message', 'Provider Profile updated successfully.');
            return true;
        }
    }

    public function getCollegeprofileData($college_userid = false) {
        $this->db->select('c.*,u.*');
        $this->db->from(COLLEGE . ' c');
        $this->db->join(USERS . ' u', 'c.college_id = u.college_id');
        //$this->db->where('u.user_status', 1);
        $this->db->where('u.user_type', 2);
        if ($college_userid) {
            $this->db->where('u.user_id', $college_userid);
        }
        $this->db->order_by('c.college_name', 'asc');
        $query = $this->db->get();
        $college = array();
        if ($query->result()) {
            return $query->result()[0];
        } else {
            return FALSE;
        }
    }

    public function update_college_profile($post_arr) {
        $current_user_id = $post_arr['user_id'];
        $first_name = $post_arr['first_name'];
        $user_type = $post_arr['user_type'];
        $last_name = $post_arr['last_name'];
        $user_email = $post_arr['user_email'];
        $timezone = $post_arr['timezone'];

        $data = array(
            "first_name" => $first_name,
            "user_type" => $user_type,
            "last_name" => $last_name,
            "user_email" => $user_email,
            "timezone_id" => $timezone,
            'is_profile_completeness' => 1
        );

        if ($post_arr['timezone']) {
            $timezone_code = $this->db->select('timezone_code')->from(TIMEZONE)->where('timezone_value', trim($post_arr['timezone']))->get()->row();
            if ($timezone_code && $timezone_code->timezone_code) {
                $data['timezone_code'] = $timezone_code->timezone_code;
            }
        }

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
            $college['college_name'] = $post_arr['college_name'];
            $college['college_address'] = $post_arr['college_address'];
            $college['college_state'] = $post_arr['college_state'];
            $college['college_city'] = $post_arr['college_city'];
            $college['college_zipcode'] = $post_arr['college_zipcode'];
            $college['college_office_no'] = $post_arr['college_office_no'];
            if (isset($post_arr['college_id']) && !empty($post_arr['college_id'])) {
                $this->db->update(COLLEGE, $college, "uid=" . $post_arr['user_id']);
            }
            $this->session->set_flashdata('message', 'College Profile updated successfully.');
            return true;
        }
    }

    public function get_CollegeID($user_id) {
        $this->db->select('c.college_id');
        $this->db->from(COLLEGE . ' c');
        $this->db->where('c.uid', $user_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $data = $query->result();
            $college_id = $data[0]->college_id;
            return $college_id;
        } else {
            return false;
        }
    }

    public function get_TotalTransactions($user_id, $college_id) {
        $this->db->select('SUM(t.amount) as total');
        $this->db->from(TRANSACTIONS . ' t');
        $this->db->join(USERS . ' u', 't.provider_id = u.user_id');
        $this->db->where('u.college_id', $college_id);
        $this->db->where('u.user_id !=', $user_id);
        $this->db->where('u.user_type', '3');
        $this->db->where("t.payent_status", '1');
        $query = $this->db->get();
        //echo $this->db->last_Query(); die;
        if ($query->num_rows() > 0) {
            $data = $query->result();
            $amount = $data[0]->total;
            if (empty($amount)) {
                $amount = 0;
            }
            return $amount;
        } else {
            return 0;
        }
    }

    public function getTotalUserAcType($user_id, $college_id, $user_type) {
        $this->db->select('user_id');
        $this->db->from(USERS . ' u');
        $this->db->where("u.user_type", $user_type);
        if ($user_type == 5) {
            $this->db->where("FIND_IN_SET('" . $college_id . "', u.third_parties_college_ids)");
        } else {
            $this->db->where("u.college_id", $college_id);
        }
        $this->db->where('u.user_id !=', $user_id);
        $query = $this->db->get();
        //echo $this->db->last_Query(); die;
        if ($query->num_rows() > 0) {
            return $query->num_rows();
        } else {
            return 0;
        }
    }

    public function get_LastTransactions($user_id, $college_id) {
        $this->db->select('concat(u.first_name," ",u.last_name) as patient_name,av.start_date,av.end_date,av.start_time,av.end_time,t.amount,t.transaction_no, (select concat(first_name," ",last_name)  from bm_users where user_id = a.provider_id) as provider_name');
        $this->db->from(USERS . ' u');
        $this->db->join(APPOINTMENTS . ' a', 'a.patient_id = u.user_id');
        $this->db->join(TRANSACTIONS . ' t', 't.appointment_id = a.app_id');
        $this->db->join(AVAILABALITY . ' av', 'av.avail_id = a.slot_id');

        $cnd = "u.user_id != $user_id and u.user_type = 4 and u.college_id = $college_id and t.payent_status = 1 and a.status = 1";
        $this->db->where($cnd);

        $this->db->limit(10);
        $this->db->order_by('a.booked_on', 'desc');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $data = $query->result();
            return $data;
        } else {
            return array();
        }
    }

    public function get_upcoming_appointment($user_id, $college_id, $limit = null) {
        $today = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . " - 15 minutes"));
        $this->db->select('concat(u.first_name," ",u.last_name) as patient_name,av.start_date,av.end_date,av.start_time,av.end_time, (select concat(first_name," ",last_name)  from bm_users where user_id = a.provider_id) as provider_name  ');
        $this->db->from(USERS . ' u');
        $this->db->join(APPOINTMENTS . ' a', 'a.patient_id = u.user_id');
        $this->db->join(TRANSACTIONS . ' t', 't.appointment_id = a.app_id and t.transaction_type = "charge"');
        $this->db->join(AVAILABALITY . ' av', 'av.avail_id = a.slot_id');
        $cnd = "u.user_id != $user_id and u.user_type = 4 and u.college_id = $college_id and a.status = 1 and concat_ws(' ',av.start_date,av.start_time) >= '$today'";
        $this->db->where($cnd);
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

    public function get_appointments($college_id) {
        $this->db->select('a.app_id, pat.first_name patient_fname, pat.last_name patient_lname, pro.first_name provider_fname, pro.last_name provider_lname, pa.start_time, pa.start_date, a.status, a.booked_on');
        $this->db->from(APPOINTMENTS . ' a');
        $this->db->join(AVAILABALITY . ' pa', 'a.slot_id = pa.avail_id');
        $this->db->join(USERS . ' pro', 'a.provider_id = pro.user_id');
        $this->db->join(USERS . ' pat', 'a.patient_id = pat.user_id');
        $this->db->where('pro.college_id', $college_id);
        $this->db->where('a.status IN(1,2)');
        $this->db->order_by('a.app_id', 'desc');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_appointment_details($appointment_id) {
        $this->db->select('*');
        $this->db->from(APPOINTMENTS . ' a');
        $this->db->where('a.app_id', $appointment_id);
        $this->db->where('a.status', 1);
        $query = $this->db->get();
        return $query->row_array();
    }

}

?>