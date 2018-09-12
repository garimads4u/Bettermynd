<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Provider_model extends CI_Model {

    public function __construct() { // Constructor
        parent::__construct();
    }

    public function update_provider($post_arr) {
        $current_user_id = $post_arr['user_id'];
        $first_name = $post_arr['first_name'];
        $user_type = $post_arr['user_type'];
        $last_name = $post_arr['last_name'];
        $mobile_no = $post_arr['mobile_no'];
        $college_id = $post_arr['college_id'];
        $timezone = $post_arr['timezone'];

        $data = array(
            "first_name" => $first_name,
            "user_type" => $user_type,
            "last_name" => $last_name,
            "mobile_no" => $mobile_no,
            "college_id" => $college_id,
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
        if (isset($_FILES['photo_id']) && $_FILES['photo_id']['size'] > 0) {
            $profileimage = $_FILES['photo_id'];
            $extenstion = $this->basic_model->get_extension($profileimage['name']);
            if ($extenstion != "error") {
                $filename = 'photoid_' . $current_user_id . "." . $extenstion;
                $config['upload_path'] = PROFILE_FILE_UPLOAD_PATH;
                $config['allowed_types'] = 'jpg|png|jpeg|gif';
                $config['max_size'] = 1024 * 2;
                $config['file_name'] = $filename;
                if (file_exists($config['upload_path'] . "$filename")) {
                    unlink($config['upload_path'] . "$filename");
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

//        if (isset($_FILES['counseling_certifications']) && !empty($_FILES['counseling_certifications'])) {
//            $counseling_doc = count($_FILES['counseling_certifications']['size']);
//            $j = 0;
//            for ($i = 1; $i <= $counseling_doc; $i++) {
//                if (isset($_FILES['counseling_certifications']) && $_FILES['counseling_certifications']['size'][0] > 0) {
//                    foreach ($_FILES['counseling_certifications']['tmp_name'] as $key => $doc) {
//                        $_FILES['counseling_certification']['name'] = $_FILES['counseling_certifications']['name'][$key];
//                        $_FILES['counseling_certification']['type'] = $_FILES['counseling_certifications']['type'][$key];
//                        $_FILES['counseling_certification']['tmp_name'] = $_FILES['counseling_certifications']['tmp_name'][$key];
//                        $_FILES['counseling_certification']['error'] = $_FILES['counseling_certifications']['error'][$key];
//                        $_FILES['counseling_certification']['size'] = $_FILES['counseling_certifications']['size'][$key];
//
//                        $extenstion = $this->basic_model->get_extension_doc($_FILES['counseling_certifications']['name'][$key]);
//
//                        if ($extenstion != "error") {
//                            $filename = "counseling_certifications_" . $current_user_id . "_" . time() . "_" . $key . "." . $extenstion;
//                            $upload_path = COUNSELING_FILE_UPLOAD_PATH . '/' . $current_user_id;
//                            if (!is_dir($upload_path)) {
//                                mkdir($upload_path, 0777, true);
//                            }
//                            $config['upload_path'] = $upload_path;
//                            $config['allowed_types'] = 'jpg|png|jpeg|doc|docx|pdf';
//                            $config['file_name'] = $filename;
//                            if (file_exists($config['upload_path'] . "$filename")) {
//                                unlink($config['upload_path'] . "$filename");
//                            }
//                            $this->load->library('upload', $config);
//                            $this->upload->initialize($config);
//                            if ($this->upload->do_upload("counseling_certification")) {
//                                $data_image = $this->upload->data();
//                                $counseling_certifications[$j]['name'] = $data_image['file_name'];
//                                $counseling_certifications[$j]['document_title'] = $post_arr['document_name'][$j];
//                            }
//                        } else {
//                            return false;
//                        }
//                    }
//                }
//                $j++;
//            }
//        }
//
//        $malpractice_certifications = array();
//        if (isset($_FILES['malpractice_certifications']) && !empty($_FILES['malpractice_certifications'])) {
//            $malware_doc = count($_FILES['malpractice_certifications']['size']);
//            $k = 0;
//            for ($i = 1; $i <= $malware_doc; $i++) {
//                if (isset($_FILES['malpractice_certifications']) && $_FILES['malpractice_certifications']['size'][$k] > 0) {
//                    foreach ($_FILES['malpractice_certifications']['tmp_name'] as $key => $doc) {
//                        $_FILES['malpractice_certification']['name'] = $_FILES['malpractice_certifications']['name'][$key];
//                        $_FILES['malpractice_certification']['type'] = $_FILES['malpractice_certifications']['type'][$key];
//                        $_FILES['malpractice_certification']['tmp_name'] = $_FILES['malpractice_certifications']['tmp_name'][$key];
//                        $_FILES['malpractice_certification']['error'] = $_FILES['malpractice_certifications']['error'][$key];
//                        $_FILES['malpractice_certification']['size'] = $_FILES['malpractice_certifications']['size'][$key];
//
//                        $extenstion = $this->basic_model->get_extension_doc($_FILES['malpractice_certifications']['name'][$key]);
//                        if ($extenstion != "error") {
//                            $filename = "malpractice_certifications_" . $current_user_id . "_" . time() . "_" . $key . "." . $extenstion;
//                            $upload_path = MALPRACTICE_FILE_UPLOAD_PATH . '/' . $current_user_id;
//                            if (!is_dir($upload_path)) {
//                                mkdir($upload_path, 0777, true);
//                            }
//                            $config['upload_path'] = $upload_path;
//                            $config['allowed_types'] = 'jpg|png|jpeg|doc|docx|pdf';
//                            $config['file_name'] = $filename;
//                            if (file_exists($config['upload_path'] . "$filename")) {
//                                unlink($config['upload_path'] . "$filename");
//                            }
//
//                            $this->load->library('upload', $config);
//                            $this->upload->initialize($config);
//                            if ($this->upload->do_upload("malpractice_certification")) {
//                                $data_image = $this->upload->data();
//                                $malpractice_certifications[$k]['name'] = $data_image['file_name'];
//                                $malpractice_certifications[$k]['document_title'] = $post_arr['malpractice_document_name'][$k];
//                            }
//                        } else {
//                            return false;
//                        }
//                    }
//                }
//                $k++;
//            }
//        }

        if ($this->db->update(USERS, $data, "user_id=" . $post_arr['user_id'])) {
//            if (isset($counseling_certifications) && !empty($counseling_certifications)) {
//                foreach ($counseling_certifications as $row) {
//                    $counseling['thirdparty_id'] = $post_arr['user_id'];
//                    $counseling['counseling_certificate_name'] = $row['name'];
//                    $counseling['counseling_document_title'] = $row['document_title'];
//                    $counseling['created_date'] = time();
//                    $this->db->insert(COUNSELING_CERTIFICATE, $counseling);
//                }
//            }
//
//            if (isset($malpractice_certifications) && !empty($malpractice_certifications)) {
//
//                foreach ($malpractice_certifications as $row) {
//                    $malpractice['thirdparty_id'] = $post_arr['user_id'];
//                    $malpractice['insurance_certificate_name'] = $row['name'];
//                    $malpractice['malpractice_document_title'] = $row['document_title'];
//                    $malpractice['created_date'] = time();
//                    $this->db->insert(MALPRACTICE_CERTIFICATE, $malpractice);
//                }
//            }
            $res['session_cost'] = $post_arr['session_cost'];
            $res['biography'] = $post_arr['biography'];
            $res['specialities'] = implode(',', $post_arr['specialities']);
            $res['insurance_carriers'] = implode(',', $post_arr['insurance_carriers']);


            $profile_id = $this->getProviderProfile($post_arr['user_id']);
            if (isset($profile_id) && !empty($profile_id)) {
                $this->db->update(PROVIDER_PROFILE, $res, "provider_id=" . $post_arr['user_id']);
                return true;
            } else {
                $res['provider_id'] = $post_arr['user_id'];
                $this->db->insert(PROVIDER_PROFILE, $res);
                return true;
            }
            $this->session->set_flashdata('message', 'Provider Profile updated successfully.');
            return true;
        }
    }

    public function getProfileData($uid) {
        $this->db->select('u.*,p.*');
        $this->db->from(USERS . ' u');
        $this->db->join(PROVIDER_PROFILE . ' p', "u.user_id = p.provider_id", "left");
        $this->db->where("u.user_id", $uid);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $data = $query->result();

            return $data[0];
        } else {
            $this->db->select('u.*,p.*');
            $this->db->from(USERS . ' u');
            $this->db->join(THIRD_PARTY_PROFILE . ' p', "u.user_id = p.thirdparty_id", "inner");
            $this->db->where("u.user_id", $uid);
            $query = $this->db->get();
            if ($query->num_rows() > 0) {
                $data = $query->result();
                return $data[0];
            } else {
                return array();
            }
            return array();
        }
    }

    public function getProviderProfile($uid) {
        $this->db->select('provider_id');
        $this->db->from(PROVIDER_PROFILE);
        $this->db->where("provider_id", $uid);
        $query = $this->db->get();
        $data = array();
        if ($query->num_rows() > 0) {
            $data = $query->result();
            return $data;
        } else {
            return false;
        }
    }

    public function getProviderShcedule($uid) {
        $this->db->select('*');
        $this->db->from(AVAILABALITY);
        $this->db->where("provider_id", $uid);
        $this->db->where("status", '1');
        //$this->db->where(" end_date>'" . date('Y-m-d') . "' ");
        $query = $this->db->get();
        $data = $result = array();
        if ($query->num_rows() > 0) {
            $data = $query->result();
            if ($data) {
                foreach ($data as $key => $value) {
                    $start_datetime = strtotime($this->basic_model->change_utc_datetime($value->start_date . ' ' . $value->start_time));
                    $end_datetime = strtotime($this->basic_model->change_utc_datetime($value->end_date . ' ' . $value->end_time));
                    $result[$key] = $value;
                    $result[$key]->start_date = date('Y-m-d', $start_datetime);
                    $result[$key]->start_time = date('H:i:s', $start_datetime);
                    $result[$key]->end_date = date('Y-m-d', $end_datetime);
                    $result[$key]->end_time = date('H:i:s', $end_datetime);
                }
            }
        }
        return $result;
    }

    public function getValidProviderShcedule($uid) {
        $this->db->select('*');
        $this->db->from(AVAILABALITY);
        $this->db->where("provider_id", $uid);
        $this->db->where("status", '1');
        $this->db->where(" end_date>'" . date('Y-m-d') . "' ");
        $query = $this->db->get();
        $data = $result = array();
        if ($query->num_rows() > 0) {
            $data = $query->result();
            if ($data) {
                foreach ($data as $key => $value) {
                    $start_datetime = strtotime($this->basic_model->change_utc_datetime($value->start_date . ' ' . $value->start_time));
                    $end_datetime = strtotime($this->basic_model->change_utc_datetime($value->end_date . ' ' . $value->end_time));
                    $result[$key] = $value;
                    $result[$key]->start_date = date('Y-m-d', $start_datetime);
                    $result[$key]->start_time = date('H:i:s', $start_datetime);
                    $result[$key]->end_date = date('Y-m-d', $end_datetime);
                    $result[$key]->end_time = date('H:i:s', $end_datetime);
                }
            }
        }
        return $data;
    }

    public function get_slot_booking($provider_id, $slot_id) {
        $query = "select * from bm_appointments where provider_id='" . $provider_id . "' and slot_id='" . $slot_id . "' and status='1'";
        $sql = $this->db->query($query);
        if ($sql->num_rows()) {
            return $sql->result_array();
        }
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
        $this->db->join(AVAILABALITY . ' av', 'av.avail_id = a.slot_id');
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

    public function get_total_upcomming_appointment($user_id) {
        $start_datetime = date('Y-m-d H:i:s', strtotime($this->basic_model->set_utc_datetime(date('Y-m-d H:i:s')) . " - 15 minutes"));

        $this->db->select('COUNT(*) as total');
        $this->db->from(APPOINTMENTS . ' a');
        $this->db->join(TRANSACTIONS . ' t', 't.appointment_id = a.app_id and t.transaction_type = "charge"');
        $this->db->join(USERS . ' u', 't.provider_id = u.user_id');
        $this->db->join(AVAILABALITY . ' av', 'av.avail_id = a.slot_id');
        $this->db->where('u.user_id', $user_id);
        $this->db->where('concat_ws(" ",av.start_date,av.start_time) >= ', $start_datetime);
        $this->db->where('a.status', '1');
        $this->db->where('u.user_status', '1');
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
        //echo $this->db->last_Query(); die;
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
        $this->db->where("av.status", '1');
        //$this->db->where('av.start_date >=', date('Y-m-d'));
        $this->db->where('concat_ws(" ",av.start_date,av.start_time) >= ', $start_datetime);
        //$this->db->where('av.start_time >=', date('H:i:s'));
        if ($limit) {
            $this->db->limit(10);
        }
        $order = 'av.end_date asc, av.end_time asc';
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
        //$this->db->where('av.start_time >=', date('H:i:s'));
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

    public function get_avail_info($avail_id) {
        $this->db->select('*');
        $this->db->from(AVAILABALITY);
        $this->db->where("avail_id", $avail_id);
        $query = $this->db->get();
        $data = array();
        if ($query->num_rows() > 0) {
            $data = $query->result();
            return $data;
        } else {
            return false;
        }
    }

    public function get_user_info($user_id) {
        $this->db->select('u.*,c.college_name');
        $this->db->from(USERS . ' u');
        $this->db->join(COLLEGE . ' c', "c.college_id = u.college_id");
        $this->db->where("u.user_id", $user_id);
        $query = $this->db->get();
        $data = array();
        if ($query->num_rows() > 0) {
            $data = $query->result();
            return $data;
        } else {
            return false;
        }
    }

    public function update_appointment($avail_id, $provider_id, $patient_id) {
        $data = array(
            'status' => '2'
        );
        $this->db->where('provider_id', $provider_id);
        $this->db->where('patient_id', $patient_id);
        $this->db->where('slot_id', $avail_id);
        if ($this->input->post() && $this->input->post('app_id')) {
            $this->db->where('app_id', $this->input->post('app_id'));
        }
        $d = $this->db->update(APPOINTMENTS, $data);
        return $d;
    }

    public function update_schedule($avail_id) {
        $data = array(
            'status' => '2'
        );
        $this->db->where('avail_id', $avail_id);
        $d = $this->db->update(AVAILABALITY, $data);
        return $d;
    }

    public function get_appointment_transaction($app_id) {
        //$query = "select charge_id, amount, amount_to_bm, amount_to_provider  from bm_appointment_transaction where appointment_id=$app_id and transaction_type='charge'";
        $query = "select *  from bm_appointment_transaction where appointment_id=$app_id and transaction_type='charge'";
        $sql = $this->db->query($query);
        return $sql->row_array();
    }

    function appointment_refund($data, $transaction) {
        $value = unserialize($data);
        $value_trans = unserialize($transaction);

        $res = $value;
        //$value = $value['refunds']['data'][0];
        if ($res['refunded']) {
//            $data_insert = array(
//                'patient_id' => $value['metadata']['patient_id'],
//                'provider_id' => $value['metadata']['provider_id'],
//                'appointment_id' => $value['metadata']['appointment_id'],
//                'amount' => ($value['amount'] / 100),
//                'amount_to_bm' => $value['metadata']['amount_to_bm'],
//                'amount_to_provider' => $value['metadata']['amount_to_provider'],
//                'transaction_no' => $value['balance_transaction'],
//                'charge_id' => $value['charge'],
//                'response' => $data,
//                'transaction_type' => 'refund',
//                'payent_status' => $value['status'] == 'succeeded' ? 1 : 0,
//                'description' => $value['reason'],
//                'date_created' => date('d-m-Y H:i:s'),
//                'ip' => $_SERVER['REMOTE_ADDR'],
//            );
            $data_insert = $value_trans;
            $data_insert['transaction_type'] = 'refund';
            $data_insert['ip'] = $_SERVER['REMOTE_ADDR'];
            $data_insert['response'] = $data;
            $data_insert['date_created'] = $this->basic_model->set_utc_datetime(date('Y-m-d H:i:s'));
            unset($data_insert['tans_id']);

            $this->db->insert(TRANSACTIONS, $data_insert);
        }
    }

}
