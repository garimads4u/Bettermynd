<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Thirdparty_model extends CI_Model {

    function __construct() { // Constructor
        parent::__construct();
    }

    function update_profile($post_arr) {
        $current_user_id = $post_arr['user_id'];
        $first_name = $post_arr['first_name'];
        $user_type = $post_arr['user_type'];
        $last_name = $post_arr['last_name'];
        $mobile_no = $post_arr['mobile_no'];
        $timezone = $post_arr['timezone'];
        $address = $post_arr['address'];
        $city = $post_arr['city'];
        $state = $post_arr['state'];
        $zipcode = $post_arr['zipcode'];

        $data = array(
            "first_name" => $first_name,
            "user_type" => $user_type,
            "last_name" => $last_name,
            "mobile_no" => $mobile_no,
            "address" => $address,
            "city" => $city,
            "state" => $state,
            "zipcode" => $zipcode,
            "timezone_id" => $timezone,
            "is_profile_completeness" => 1
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
                if (file_exists($config['upload_path'] . "/$filename")) {
                    unlink($config['upload_path'] . "/$filename");
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
        if (isset($_FILES['photo_id']) && $_FILES['photo_id']['size'] > 0) {
            $profileimage = $_FILES['photo_id'];
            $extenstion = $this->basic_model->get_extension($profileimage['name']);

            if ($extenstion != "error") {
                $filename = 'photoid_' . $current_user_id . "." . $extenstion;
                $config['upload_path'] = PROFILE_FILE_UPLOAD_PATH;
                $config['allowed_types'] = 'jpg|png|jpeg|gif';
                $config['max_size'] = 1024 * 2;
                $config['file_name'] = $filename;
                if (file_exists($config['upload_path'] . "/$filename")) {
                    unlink($config['upload_path'] . "/$filename");
                }
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if ($this->upload->do_upload("photo_id")) {
                    $data_image = $this->upload->data();
                    $data['photo_id'] = $data_image['file_name'];
                }
            } else {
                return false;
            }
        }

        if (isset($_FILES['counseling_certifications']) && !empty($_FILES['counseling_certifications'])) {
            $counseling_doc = count(array_filter($_FILES['counseling_certifications']['size']));
            $j = 0;

            for ($i = 1; $i <= $counseling_doc; $i++) {
                if (isset($_FILES['counseling_certifications']) && $_FILES['counseling_certifications']['size'][0] > 0) {
                    $counseling_arr = array_filter($_FILES['counseling_certifications']['tmp_name']);

                    if ($counseling_arr) {
                        foreach ($counseling_arr as $key => $doc) {
                            $_FILES['counseling_certification']['name'] = $_FILES['counseling_certifications']['name'][$key];
                            $_FILES['counseling_certification']['type'] = $_FILES['counseling_certifications']['type'][$key];
                            $_FILES['counseling_certification']['tmp_name'] = $_FILES['counseling_certifications']['tmp_name'][$key];
                            $_FILES['counseling_certification']['error'] = $_FILES['counseling_certifications']['error'][$key];
                            $_FILES['counseling_certification']['size'] = $_FILES['counseling_certifications']['size'][$key];

                            $extenstion = $this->basic_model->get_extension_doc($_FILES['counseling_certifications']['name'][$key]);

                            if ($extenstion != "error") {
                                $filename = "counseling_certifications_" . $current_user_id . "_" . time() . "_" . $key . "." . $extenstion;
                                $upload_path = COUNSELING_FILE_UPLOAD_PATH . '/' . $current_user_id;
                                if (!is_dir($upload_path)) {
                                    mkdir($upload_path, 0777, true);
                                }
                                $config['upload_path'] = $upload_path;
                                $config['allowed_types'] = 'jpg|png|jpeg|doc|docx|pdf';
                                $config['file_name'] = $filename;
                                if (file_exists($config['upload_path'] . "$filename")) {
                                    unlink($config['upload_path'] . "$filename");
                                }
                                $this->load->library('upload', $config);
                                $this->upload->initialize($config);
                                if ($this->upload->do_upload("counseling_certification")) {
                                    $data_image = $this->upload->data();
                                    $counseling_certifications[$j]['name'] = $data_image['file_name'];
                                    $counseling_certifications[$j]['document_title'] = $post_arr['document_name'][$j];
                                }
                            } else {
                                return false;
                            }
                        }
                    }
                }
                $j++;
            }
        }

        $malpractice_certifications = array();
        if (isset($_FILES['malpractice_certifications']) && !empty($_FILES['malpractice_certifications'])) {
            $malware_doc = count(array_filter($_FILES['malpractice_certifications']['size']));
            $k = 0;
            for ($i = 1; $i <= $malware_doc; $i++) {
                if (isset($_FILES['malpractice_certifications']) && $_FILES['malpractice_certifications']['size'][$k] > 0) {
                    $malpractice_arr = array_filter($_FILES['malpractice_certifications']['tmp_name']);
                    if ($malpractice_arr) {
                        foreach ($malpractice_arr as $key => $doc) {
                            $_FILES['malpractice_certification']['name'] = $_FILES['malpractice_certifications']['name'][$key];
                            $_FILES['malpractice_certification']['type'] = $_FILES['malpractice_certifications']['type'][$key];
                            $_FILES['malpractice_certification']['tmp_name'] = $_FILES['malpractice_certifications']['tmp_name'][$key];
                            $_FILES['malpractice_certification']['error'] = $_FILES['malpractice_certifications']['error'][$key];
                            $_FILES['malpractice_certification']['size'] = $_FILES['malpractice_certifications']['size'][$key];

                            $extenstion = $this->basic_model->get_extension_doc($_FILES['malpractice_certifications']['name'][$key]);
                            if ($extenstion != "error") {
                                $filename = "malpractice_certifications_" . $current_user_id . "_" . time() . "_" . $key . "." . $extenstion;
                                $upload_path = MALPRACTICE_FILE_UPLOAD_PATH . '/' . $current_user_id;
                                if (!is_dir($upload_path)) {
                                    mkdir($upload_path, 0777, true);
                                }
                                $config['upload_path'] = $upload_path;
                                $config['allowed_types'] = 'jpg|png|jpeg|doc|docx|pdf';
                                $config['file_name'] = $filename;
                                if (file_exists($config['upload_path'] . "$filename")) {
                                    unlink($config['upload_path'] . "$filename");
                                }

                                $this->load->library('upload', $config);
                                $this->upload->initialize($config);
                                if ($this->upload->do_upload("malpractice_certification")) {
                                    $data_image = $this->upload->data();
                                    $malpractice_certifications[$k]['name'] = $data_image['file_name'];
                                    $malpractice_certifications[$k]['document_title'] = $post_arr['malpractice_document_name'][$k];
                                }
                            } else {
                                return false;
                            }
                        }
                    }
                }
                $k++;
            }
        }

        if ($this->db->update(USERS, $data, "user_id=" . $post_arr['user_id'])) {
            if (isset($counseling_certifications) && !empty($counseling_certifications)) {
                /* $file_list = $this->getthirdparty_counseling_certifications($post_arr['user_id']);
                  if (isset($file_list) && !empty($file_list)) {
                  foreach ($file_list as $file) {
                  $this->db->where('thirdparty_id', $post_arr['user_id']);

                  @unlink(COUNSELING_FILE_UPLOAD_PATH . '/' . $post_arr['user_id'] . '/' . $file->counseling_certificate_name);

                  $this->db->delete(COUNSELING_CERTIFICATE, array('thirdparty_id' => $post_arr['user_id']));
                  }
                  } */
                foreach ($counseling_certifications as $row) {
                    $counseling['thirdparty_id'] = $post_arr['user_id'];
                    $counseling['counseling_certificate_name'] = $row['name'];
                    $counseling['counseling_document_title'] = $row['document_title'];
                    $counseling['created_date'] = time();
                    $this->db->insert(COUNSELING_CERTIFICATE, $counseling);
                }
            }

            if (isset($malpractice_certifications) && !empty($malpractice_certifications)) {
                /* $file_list = $this->getthirdparty_malpractice_insurance_certifications($post_arr['user_id']);
                  if (isset($file_list) && !empty($file_list)) {
                  foreach ($file_list as $file) {

                  $this->db->where('thirdparty_id', $post_arr['user_id']);

                  @unlink(MALPRACTICE_FILE_UPLOAD_PATH . '/' . $post_arr['user_id'] . '/' . $file->insurance_certificate_name);

                  $this->db->delete(MALPRACTICE_CERTIFICATE, array('thirdparty_id' => $post_arr['user_id']));
                  }
                  } */

                foreach ($malpractice_certifications as $row) {
                    $malpractice['thirdparty_id'] = $post_arr['user_id'];
                    $malpractice['insurance_certificate_name'] = $row['name'];
                    $malpractice['malpractice_document_title'] = $row['document_title'];
                    $malpractice['created_date'] = time();
                    $this->db->insert(MALPRACTICE_CERTIFICATE, $malpractice);
                }
            }

            $res['session_cost'] = $post_arr['session_cost'];
            $res['biography'] = $post_arr['biography'];
            $res['specialities'] = implode(',', $post_arr['specialities']);
            $res['insurance_carriers'] = implode(',', $post_arr['insurance_carriers']);

            $profile_exit_id = $this->getThirdPartyProfile($post_arr['user_id']);
            $profile_id = $profile_exit_id ? $profile_exit_id[0]->thirdparty_profile_id : '';

            if (isset($profile_id) && !empty($profile_id)) {
                $this->db->update(THIRD_PARTY_PROFILE, $res, "thirdparty_id=" . $post_arr['user_id']);
                return true;
            } else {
                $res['thirdparty_id'] = $post_arr['user_id'];
                $this->db->insert(THIRD_PARTY_PROFILE, $res);
                return true;
            }

            $this->session->set_flashdata('message', 'Profile updated successfully.');
            return true;
        }
    }

    public function getProfileData($uid) {
        $this->db->select('u.*,p.*');
        $this->db->from(USERS . ' u');
        $this->db->join(THIRD_PARTY_PROFILE . ' p', "u.user_id = p.thirdparty_id", "left");
        $this->db->where("u.user_id", $uid);
        $query = $this->db->get();
        // print_r($query);
        //die();
        if ($query->num_rows() > 0) {
            $data = $query->result();
            return $data[0];
        } else {
            return array();
        }
    }

    public function getThirdPartyProfile($pid) {
        $this->db->select('thirdparty_profile_id');
        $this->db->from(THIRD_PARTY_PROFILE);
        $this->db->where("thirdparty_id", $pid);
        $query = $this->db->get();
        $data = array();
        if ($query->num_rows() > 0) {
            $data = $query->result();
            return $data;
        } else {
            return false;
        }
    }

    public function getthirdparty_malpractice_insurance_certifications($pid) {
        $this->db->select('*');
        $this->db->from(MALPRACTICE_CERTIFICATE);
        $this->db->where("thirdparty_id", $pid);
        $query = $this->db->get();
        $data = array();
        if ($query->num_rows() > 0) {
            $data = $query->result();
            return $data;
        } else {
            return false;
        }
    }

    public function getthirdparty_counseling_certifications($pid) {
        $this->db->select('*');
        $this->db->from(COUNSELING_CERTIFICATE);
        $this->db->where("thirdparty_id", $pid);
        $query = $this->db->get();
        $data = array();
        if ($query->num_rows() > 0) {
            $data = $query->result();
            return $data;
        } else {
            return false;
        }
    }

    public function delete_counseling_certifications($data) {
        $this->db->where("thirdparty_id", $data['user_id']);
        $this->db->where("counseling_certificate_id", $data['cerificate_doc_id']);

        @unlink(COUNSELING_FILE_UPLOAD_PATH . '/' . $data['user_id'] . '/' . $data['doc_name']);

        $this->db->delete(COUNSELING_CERTIFICATE);
        return true;
    }

    public function delete_malpractice_certifications($data) {
        $this->db->where("thirdparty_id", $data['user_id']);
        $this->db->where("insurance_certificate_id", $data['cerificate_doc_id']);

        @unlink(MALPRACTICE_FILE_UPLOAD_PATH . '/' . $data['user_id'] . '/' . $data['doc_name']);

        $this->db->delete(MALPRACTICE_CERTIFICATE);
        return true;
    }

    public function get_total_transaction($user_id) {
        $this->db->select('SUM(t.amount) as total');
        $this->db->from(TRANSACTIONS . ' t');
        $this->db->join(USERS . ' u', 't.provider_id = u.user_id');
        $this->db->where('u.user_id', $user_id);
        $query = $this->db->get();
        //echo $this->db->last_Query(); die;
        if ($query->num_rows() > 0) {
            $res = $query->result();
            $total = $res[0]->total;
            if ($total > 0) {
                return $total;
            } else {
                return 0;
            }
        } else {
            return array();
        }
    }

    public function get_total_appointment($user_id) {
        $this->db->select('COUNT(*) as total');
        $this->db->from(APPOINTMENTS . ' a');
        $this->db->join(TRANSACTIONS . ' t', 't.appointment_id = a.app_id and  t.transaction_type="charge"');
        $this->db->join(USERS . ' u', 't.provider_id = u.user_id');
        $this->db->where('u.user_id', $user_id);
        $this->db->where("a.status", '1');
        $query = $this->db->get();
        // echo $this->db->last_Query(); die;
        if ($query->num_rows() > 0) {
            $res = $query->result();
            $total = $res[0]->total;
            if ($total > 0) {
                return $total;
            } else {
                return 0;
            }
        } else {
            return 0;
        }
    }

    public function get_total_patient($user_id) {
        $this->db->select('COUNT(*) as total');
        $this->db->from(APPOINTMENTS . ' a');
        $this->db->join(TRANSACTIONS . ' t', 't.appointment_id = a.app_id');
        $this->db->join(USERS . ' u', 't.provider_id = u.user_id');
        $this->db->where('u.user_id', $user_id);
        $this->db->group_by('a.patient_id');
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function get_our_patient($user_id) {
        $this->db->select('*');
        $this->db->from(USERS . ' u');
        $this->db->join(APPOINTMENTS . ' a', 'a.patient_id = u.user_id');
        $this->db->join(TRANSACTIONS . ' t', 't.appointment_id = a.app_id');
        $this->db->where('a.provider_id', $user_id);
        $this->db->group_by('u.user_id');
        $this->db->limit(10);
        $this->db->order_by('t.date_created', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }
    }

    public function get_upcoming_appointment($user_id, $limit = null) {
        $start_datetime = date('Y-m-d H:i:s', strtotime($this->basic_model->set_utc_datetime(date('Y-m-d H:i:s')) . " - 15 minutes"));
        $this->db->select('u.first_name,u.last_name,u.user_email,c.college_name,av.start_date,av.end_date,av.start_time,av.end_time,a.booked_on,av.avail_id,a.provider_id,a.patient_id,a.status,a.app_id');
        $this->db->from(USERS . ' u');
        $this->db->join(APPOINTMENTS . ' a', 'a.patient_id = u.user_id');
        $this->db->join(TRANSACTIONS . ' t', 't.appointment_id = a.app_id and t.transaction_type = "charge"');
        $this->db->join(AVAILABALITY . ' av', 'av.avail_id = a.slot_id');
        $this->db->join(COLLEGE . ' c', 'c.college_id = u.college_id');
        $this->db->where('a.provider_id', $user_id);
        $this->db->where("a.status", '1');
        $this->db->where('concat_ws(" ",av.start_date,av.start_time) >= ', $start_datetime);
        if ($limit) {
            $this->db->limit(10);
        }
        $order = 'av.start_date asc, av.start_time asc';
        $this->db->order_by($order);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }
    }

    public function get_past_appointment($user_id, $limit = null) {
        $end_datetime = $this->basic_model->set_utc_datetime(date('Y-m-d H:i:s'));
        $this->db->select('u.first_name,u.last_name,u.user_email,c.college_name,av.start_date,av.end_date,av.start_time,av.end_time');
        $this->db->from(USERS . ' u');
        $this->db->join(APPOINTMENTS . ' a', 'a.patient_id = u.user_id');
        $this->db->join(TRANSACTIONS . ' t', 't.appointment_id = a.app_id and t.transaction_type = "charge"');
        $this->db->join(AVAILABALITY . ' av', 'av.avail_id = a.slot_id');
        $this->db->join(COLLEGE . ' c', 'c.college_id = u.college_id');
        $this->db->where('a.provider_id', $user_id);
        $this->db->where("a.status", '1');
        $this->db->where('concat_ws(" ",av.end_date,av.end_time) <= ', $end_datetime);
        if ($limit) {
            $this->db->limit($limit);
        }
        $order = 'av.end_date desc, av.end_time desc';
        $this->db->order_by($order);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }
    }

}
