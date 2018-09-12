<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Patient_model extends CI_Model {

    function __construct() { // Constructor
        parent::__construct();
    }

    function update_patient($post_arr) {
        $data['first_name'] = $post_arr['first_name'];
        $data['last_name'] = $post_arr['last_name'];
        //$data['college_id'] = $post_arr['college_id'];
        $data['patient_identification_number'] = $post_arr['patient_identification_number'];
        // list($month,$day,$year) =  @explode("-",$post_arr['dob']);
        // $dob = $day.'-'.$month.'-'.$year;

        $data['dob'] = $this->basic_model->convertDate($post_arr['dob']);
        $data['mobile_no'] = $post_arr['mobile_no'];
        $data['user_type'] = $post_arr['user_type'];
        $data['ethnicity'] = $post_arr['ethnicity'];
        $data['gender'] = $post_arr['gender'];
        $data['timezone_id'] = $post_arr['timezone'];
        $data['address'] = $post_arr['address'];
        $data['city'] = $post_arr['city'];
        $data['state'] = $post_arr['state'];
        $data['zipcode'] = $post_arr['zipcode'];
        $data['is_international'] = $post_arr['is_international'];
        $data['athlete'] = $post_arr['athlete'];
        $data['class_year'] = $post_arr['class_year'];
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
            $this->session->set_flashdata('message', 'Patient Profile updated successfully.');
            return true;
        }
    }

    public function get_booked_slot($default_date) {
        $this->db->select('a.slot_id');
        $this->db->from(APPOINTMENTS . ' a');
        $this->db->join(AVAILABALITY . ' av', 'av.avail_id = a.slot_id');
        $this->db->where('a.status', 1);
        $this->db->where('av.status', 1);
        $this->db->where("av.start_date >= ", $default_date);
        $query = $this->db->get();
        $result = '';
        if ($query->num_rows() > 0) {
            $data = $query->result();
            if ($data && is_array($data)) {
                foreach ($data as $key => $value) {
                    $result[$value->slot_id] = $value->slot_id;
                }
            }
            if ($result && is_array($result)) {
                $result = implode(',', $result);
            }
        }

        return $result;
    }

    public function get_user_providers($user_id) {
        $default_date = date('Y-m-d', strtotime(date('Y-m-d') . " +1 Days"));
        /* $default_av_cnd = " and start_date>='$default_date' and status = 1";

          $avail_booked_ids = $this->get_booked_slot($default_date);
          if ($avail_booked_ids) {
          $default_av_cnd .= " and avail_id NOT IN ($avail_booked_ids)";
          } */

        $default_av_cnd = '';
        $query = "(SELECT u.*,
                                p.*
                         FROM   bm_users AS u,
                                bm_provider_profile AS p
                         WHERE  u.user_type = '3'
                                AND u.user_status = '1'
                                AND p.session_cost > '0'
                                AND u.college_id = (SELECT college_id
                                                    FROM   bm_users
                                                    WHERE  user_id = " . $user_id . ")
                                AND u.user_id = p.provider_id

                                )

                    UNION ALL

                    (SELECT u.*,
                                tp.*
                         FROM   bm_users AS u,
                                bm_thirdparty_profile AS tp
                         WHERE  u.user_type = '5'
                                AND u.user_status = '1'
                                AND tp.session_cost > '0'
                                AND FIND_IN_SET((SELECT college_id
                                                    FROM   bm_users
                                                    WHERE  user_id = " . $user_id . "), u.third_parties_college_ids)
                                AND u.user_id = tp.thirdparty_id

                                )";

        $sql = $this->db->query($query);
        if ($sql->num_rows() > 0) {
            return $sql->result_array();
        }
    }

    public function get_user_providers_old($user_id) {
        $default_date = date('Y-m-d', strtotime(date('Y-m-d') . " +1 Days"));
        /* $default_av_cnd = " and start_date>='$default_date' and status = 1";

          $avail_booked_ids = $this->get_booked_slot($default_date);
          if ($avail_booked_ids) {
          $default_av_cnd .= " and avail_id NOT IN ($avail_booked_ids)";
          } */

        $default_av_cnd = '';
        $query = "(SELECT u.*,
                                p.*
                         FROM   bm_users AS u,
                                bm_provider_profile AS p
                         WHERE  u.user_type = '3'
                                AND u.user_status = '1'
                                AND p.session_cost > '0'
                                AND u.college_id = (SELECT college_id
                                                    FROM   bm_users
                                                    WHERE  user_id = " . $user_id . ")
                                AND u.user_id = p.provider_id
                                and u.user_id in (select provider_id from bm_provider_availablity where 1 $default_av_cnd)
                                )

                    UNION ALL

                    (SELECT u.*,
                                tp.*
                         FROM   bm_users AS u,
                                bm_thirdparty_profile AS tp
                         WHERE  u.user_type = '5'
                                AND u.user_status = '1'
                                AND tp.session_cost > '0'
                                AND (u.college_id = 0 or u.college_id is null or u.college_id = (SELECT college_id
                                                    FROM   bm_users
                                                    WHERE  user_id = " . $user_id . "))
                                AND u.user_id = tp.thirdparty_id
                                and u.user_id in (select provider_id from bm_provider_availablity where 1 $default_av_cnd)
                                )";

        $sql = $this->db->query($query);
        if ($sql->num_rows() > 0) {
            return $sql->result_array();
        }
    }

    public function get_search_providers($user_id) {
        $id = $this->input->post('provider_name');
        $speciality_id = $this->input->post('speciality_id');
        $insurance_id = $this->input->post('insurance_id');
        $price = $this->input->post('price');

        $default_date = date('Y-m-d', strtotime(date('Y-m-d') . " +1 Days"));
        //$start_date = $this->input->post('start_date') ? date('Y-m-d', strtotime($this->input->post('start_date'))) : $default_date;
        $start_date = $end_date = '';
        if ($this->input->post('start_date')) {
            $start_datetime = $this->basic_model->change_utc_datetime($this->input->post('start_date'));
            $start_date = date('Y-m-d', strtotime($start_datetime));
        }
        if ($this->input->post('end_date')) {
            $end_datetime = $this->basic_model->change_utc_datetime($this->input->post('end_date'));
            $end_date = date('Y-m-d', strtotime($end_datetime));
        }

        $st_date_cnd = $start_date ? " and start_date>='$start_date'  and status = 1" : '';
        $en_date_cnd = $end_date ? " and end_date<='$end_date'" : '';
        //prd($this->input->post(), 1);
        /* $avail_booked_ids = $this->get_booked_slot($default_date);
          if ($avail_booked_ids) {
          $st_date_cnd .= " and avail_id NOT IN ($avail_booked_ids)";
          } */

        //prd($this->input->post(), 1);
        $cnd_p = $avail_cnd_p = '';
        if (isset($id) && !empty($id)) {
            $cnd_p = "u.user_id='$id' and ";
        }
        if (isset($speciality_id) && !empty($speciality_id)) {
            $cnd_p .= "find_in_set($speciality_id,p.specialities) and ";
        }
        if (isset($insurance_id) && !empty($insurance_id)) {
            $cnd_p .= "find_in_set($insurance_id,p.insurance_carriers) and ";
        }
        if (isset($price) && !empty($price)) {
            $price_arr = explode('-', str_replace(array('$', '+'), array('', ''), $price));
            $start_price = trim(current($price_arr));
            $end_price = trim(end($price_arr));
            if ($end_price == 200) { // 200 and above
                $cnd_p .= "p.session_cost >= $start_price and ";
            } else {
                $cnd_p .= "p.session_cost BETWEEN $start_price AND $end_price and ";
            }
        }
        if (isset($st_date_cnd) && !empty($st_date_cnd)) {
            $avail_cnd_p = "  and u.user_id in (select provider_id from bm_provider_availablity where 1 $st_date_cnd $en_date_cnd)";
        }
        if (empty($avail_cnd_p)) {
            if (isset($en_date_cnd) && !empty($en_date_cnd)) {
                $avail_cnd_p = "  and u.user_id in (select provider_id from bm_provider_availablity where 1 $st_date_cnd $en_date_cnd)";
            }
        }

        $query = "(select u.*,p.*
                            from bm_users as u
                            join bm_provider_profile as p on u.user_id=p.provider_id
                            where $cnd_p p.session_cost > '0' and u.user_status='1' and ((u.user_type='3' and u.college_id = (select college_id from bm_users where user_id=" . $user_id . ")) or u.user_type='5')$avail_cnd_p
                                )
                                UNION ALL
                                (select u.*,p.*
                            from bm_users as u
                            join bm_thirdparty_profile as p on u.user_id=p.thirdparty_id
                            where $cnd_p p.session_cost > '0' and u.user_status='1' and (u.user_type='5')
                                AND FIND_IN_SET((SELECT college_id
                                                    FROM   bm_users
                                                    WHERE  user_id = " . $user_id . "), u.third_parties_college_ids)  $avail_cnd_p
                                )
                        ";

        $sql = $this->db->query($query);

        //prd($sql->result_array(), 1);
        if ($sql->num_rows() > 0) {
            return $sql->result_array();
        }
    }

    public function get_search_providers_20170823($user_id) {
        $searchterm = $this->input->post('provider_name');
        $type = $this->input->post('type');
        $id = $this->input->post('id');
        $insurance_id = $this->input->post('insurance_id');
        $price = $this->input->post('price');
        $speciality_id = $this->input->post('speciality_id');
        $default_date = date('Y-m-d', strtotime(date('Y-m-d') . " +1 Days"));
        //$start_date = $this->input->post('start_date') ? date('Y-m-d', strtotime($this->input->post('start_date'))) : $default_date;
        $start_date = $this->input->post('start_date') ? date('Y-m-d', strtotime($this->input->post('start_date'))) : '';
        $end_date = $this->input->post('end_date') ? date('Y-m-d', strtotime($this->input->post('end_date'))) : '';
        $st_date_cnd = $start_date ? " and start_date>='$start_date'  and status = 1" : "  and status = 1";
        $en_date_cnd = $end_date ? " and end_date<='$end_date'" : '';

        /* $avail_booked_ids = $this->get_booked_slot($default_date);
          if ($avail_booked_ids) {
          $st_date_cnd .= " and avail_id NOT IN ($avail_booked_ids)";
          } */

        //prd($this->input->post(), 1);
        $cnd_p = $cnd_pp = $cnd_p_tp = '';
        if (isset($insurance_id) && !empty($insurance_id)) {
            $cnd_p = "find_in_set($insurance_id,p.insurance_carriers) and ";
            $cnd_pp = "find_in_set($insurance_id,pp.insurance_carriers) and ";
            $cnd_p_tp = "((find_in_set($insurance_id,p.insurance_carriers) or find_in_set($insurance_id,tp.insurance_carriers) )) and ";
        }
        if (isset($price) && !empty($price)) {
            $price_arr = explode('-', str_replace(array('$', '+'), array('', ''), $price));
            $start_price = trim(current($price_arr));
            $end_price = trim(end($price_arr));
            if ($end_price == 200) { // 200 and above
                $cnd_p .= "p.session_cost >= $start_price and ";
                $cnd_pp .= "pp.session_cost >= $start_price and ";
                $cnd_p_tp .= "((p.session_cost >= $start_price) or (tp.session_cost >= $start_price)) and ";
            } else {
                $cnd_p .= "p.session_cost BETWEEN $start_price AND $end_price and ";
                $cnd_pp .= "pp.session_cost BETWEEN $start_price AND $end_price and ";
                $cnd_p_tp .= "((p.session_cost BETWEEN $start_price AND $end_price) or (tp.session_cost BETWEEN $start_price AND $end_price)) and ";
            }
        }

        if (isset($type) && isset($id) && !empty($type) && !empty($id)) {
            if ($type == 'provider') {
                $query = "(select u.*,p.*
                            from bm_users as u
                            join bm_provider_profile as p on u.user_id=p.provider_id
                            where $cnd_p p.session_cost > '0' and u.user_status='1' and ((u.user_type='3' and u.college_id = (select college_id from bm_users where user_id=" . $user_id . ")) or u.user_type='5') and u.user_id='$id'  and u.user_id in (select provider_id from bm_provider_availablity where 1 $st_date_cnd $en_date_cnd)
                                )
                                UNION ALL
                                (select u.*,p.*
                            from bm_users as u
                            join bm_thirdparty_profile as p on u.user_id=p.thirdparty_id
                            where $cnd_p p.session_cost > '0' and u.user_status='1' and (u.user_type='5') and u.user_id='$id'  and u.user_id in (select provider_id from bm_provider_availablity where 1 $st_date_cnd $en_date_cnd)
                                )
                        ";
            } else {
                $query = "(select
                            u.*,pp.*
                            from
                            bm_users u
                            join bm_provider_profile pp on pp.provider_id = u.user_id
                            WHERE  pp.session_cost > '0' and u.user_status='1' and ((u.user_type='3' and u.college_id = (select college_id from bm_users where user_id=" . $user_id . ")) or u.user_type='5')
                                and $cnd_pp find_in_set($id,pp.specialities) and u.user_id in (select provider_id from bm_provider_availablity where  1 $st_date_cnd $en_date_cnd)
                               )
                               UNION ALL

                               (select
                            u.*,pp.*
                            from
                            bm_users u
                            join bm_thirdparty_profile as pp on u.user_id=pp.thirdparty_id
                            WHERE  pp.session_cost > '0' and u.user_status='1' and (u.user_type='5')
                                and $cnd_pp find_in_set($id,pp.specialities) and u.user_id in (select provider_id from bm_provider_availablity where  1 $st_date_cnd $en_date_cnd)
                               )
                            ";
            }
        } else {
            if (!empty($searchterm)) {
                $query = "select
                            speciality_id
                            from bm_speciality
                            WHERE
                                (
                                     MATCH(speciality_title) AGAINST ('" . $searchterm . "') or
                                     soundex(speciality_title)=soundex('" . $searchterm . "') or
                                         speciality_title like '%$searchterm%'
                                 )";
                $qry = $this->db->query($query);
                $arg = '';
                foreach ($qry->result_array() as $val) {
                    $arg .= " or find_in_set({$val['speciality_id']},p.specialities) ";
                    $arg .= " or find_in_set({$val['speciality_id']},tp.specialities) ";
                }
                $query = "select *,
                    (CASE u.user_type
                        WHEN '3'
                        THEN p.specialities
                        ELSE tp.specialities
                    END) as specialities,
                    (CASE u.user_type
                        WHEN '3'
                        THEN p.session_cost
                        ELSE tp.session_cost
                    END) as session_cost,
                    (CASE u.user_type
                        WHEN '3'
                        THEN p.insurance_carriers
                        ELSE tp.insurance_carriers
                    END) as insurance_carriers,
                    (CASE u.user_type
                        WHEN '3'
                        THEN p.biography
                        ELSE tp.biography
                    END) as biography
                    from bm_users as u
                    left join bm_provider_profile as p on u.user_id=p.provider_id
                    left join bm_thirdparty_profile as tp on u.user_id=tp.thirdparty_id
                    where $cnd_p_tp (p.session_cost > '0' or tp.session_cost > '0' ) and u.user_status='1' and ((u.user_type='3' and u.college_id = (select college_id from bm_users where user_id=" . $user_id . ")) or u.user_type='5') and
                    (
                        MATCH(first_name, last_name) AGAINST ('" . $searchterm . "') or
                        soundex(first_name)=soundex('" . $searchterm . "')  or
                        soundex(last_name)=soundex('" . $searchterm . "') or
                        first_name like '%$searchterm%' or
                        last_name like '%$searchterm%' $arg
                    ) and u.user_id in (select provider_id from bm_provider_availablity where 1 $st_date_cnd $en_date_cnd)";
            } else {
                $query = "(select u.*,p.*
                            from bm_users as u
                            join bm_provider_profile as p on u.user_id=p.provider_id
                            where $cnd_p p.session_cost > '0' and u.user_status='1' and u.user_type='3' and u.college_id = (select college_id from bm_users where user_id=" . $user_id . ") and u.user_id in (select provider_id from bm_provider_availablity where 1 $st_date_cnd $en_date_cnd)
                                )
                            union all
                            (
                            select u.*,p.*
                            from bm_users as u
                            join bm_thirdparty_profile as p on u.user_id=p.thirdparty_id
                            where $cnd_p p.session_cost > '0' and u.user_status='1' and u.user_type='5' and  u.user_id in (select provider_id from bm_provider_availablity where 1 $st_date_cnd $en_date_cnd)
                                )
                        ";
            }
        }
        $sql = $this->db->query($query);
        if ($sql->num_rows() > 0) {
            return $sql->result_array();
        }
    }

    public function get_provider_data($user_id) {
        $query = "select u.*,p.* from bm_users as u,bm_provider_profile as p where u.user_id=$user_id and p.provider_id=u.user_id";
        $sql = $this->db->query($query);
        if ($sql->num_rows() > 0) {
            return $sql->result_array();
        } else {
            $query = "select u.*,p.* from bm_users as u,bm_thirdparty_profile as p where u.user_id=$user_id and p.thirdparty_id=u.user_id";
            $sql = $this->db->query($query);
            if ($sql->num_rows() > 0) {
                return $sql->result_array();
            }
        }
    }

    public function get_provider_availabality($user_id) {
        $data1 = $data = array();
        $query = "select * from bm_provider_availablity where provider_id=$user_id and status = 1 and end_date > '" . date('Y-m-d') . "'";
        $sql = $this->db->query($query);
        if ($sql->num_rows() > 0) {
            if ($sql->result_array() && is_array($sql->result_array())) {
                foreach ($sql->result_array() as $key => $value) {
                    $slot_id = $value['avail_id'];
                    $query = "select * from bm_appointments where slot_id=$slot_id and status = 1";
                    $result = $this->db->query($query)->row();
                    if ($result) {
                        continue;
                    } else {
                        $data[$key] = $value;
                    }
                }
            }
            $return['schedule'] = $data;
        }


        $query1 = "select distinct(start_time), avail_id from bm_provider_availablity where provider_id=$user_id and status = 1 and end_date > '" . date('Y-m-d') . "'";


        $sql1 = $this->db->query($query1);
        if ($sql1->result_array() && is_array($sql1->result_array())) {
            foreach ($sql->result_array() as $key => $value) {
                $slot_id = $value['avail_id'];
                $query = "select * from bm_appointments where slot_id=$slot_id and status = 1";
                $result = $this->db->query($query)->row();
                if ($result) {
                    continue;
                } else {
                    $data1[$key] = $value;
                }
            }
        }

        if ($data1) {
            $return['timings'] = $data1;
        } else {
            $return['timings'] = array();
        }
//        prd($return,1);
        return $return;
    }

    function appointment_transaction($data) {
        $value = unserialize($data);
//        $amount = ($value->amount / 100);
        $amount = $this->input->post('amount');
        $amount_to_bm = ($amount * 15) / 100;
        $amount_to_bm = number_format($amount_to_bm, 2);
        $amount_to_provider = $amount - $amount_to_bm;
        $data_insert = array(
            'patient_id' => $value->metadata->patient_id,
            'provider_id' => $value->metadata->provider_id,
            'appointment_id' => $value->metadata->appointment_id,
            'amount' => $amount,
            'amount_to_bm' => $amount_to_bm,
            'amount_to_provider' => $amount_to_provider,
            'transaction_no' => $value->balance_transaction,
            'charge_id' => $value->id,
            'response' => $data,
            'transaction_type' => $value->object,
            'payent_status' => $value->paid,
            'description' => $value->description,
            'date_created' => $this->basic_model->set_utc_datetime(date('Y-m-d H:i:s')),
            'ip' => $_SERVER['REMOTE_ADDR'],
            'coupon_id' => $value->metadata->coupon_id,
            'coupon_object' => $this->input->post('coupon_object'),
            'coupon_coupon_type' => $this->input->post('coupon_coupon_type'),
            'coupon_amount_off' => $this->input->post('coupon_amount_off'),
            'coupon_percent_off' => $this->input->post('coupon_percent_off'),
            'discount_amount' => $this->input->post('discount_amount'),
            'remain_session_cost' => $this->input->post('remain_session_cost'),
            'coupon_duration' => $this->input->post('coupon_duration'),
            'coupon_duration_in_months' => $this->input->post('coupon_duration_in_months'),
            'coupon_max_redemptions' => $this->input->post('coupon_max_redemptions'),
        );

        $this->db->insert(TRANSACTIONS, $data_insert);
    }

    public function get_time_slot($provider_id, $appointmentdate, $timeslot) {
        $this->db->select('*');
        $this->db->from(AVAILABALITY);
        $this->db->where('provider_id = "' . $provider_id . '" and concat_ws(" ",start_date,start_time) = "' . $appointmentdate . '"');
        $result = $this->db->get()->row();
        if ($result) {
            return $result->avail_id;
        }
    }

    public function get_patient_appointments($patient_id, $appointment_id = false) {
        $result = array();
        $query = "select a.app_id,a.patient_id,a.provider_id,pa.start_date,pa.end_date,pa.start_time,pa.end_time,a.slot_id as avail_id, a.status  from bm_appointments as a,bm_provider_availablity as pa, bm_users u where a.patient_id='" . $patient_id . "' and a.slot_id=pa.avail_id  and (a.status='1' or a.status='2') and a.provider_id=u.user_id  and u.user_status='1' and pa.status = '1'";

        if ($appointment_id) {
            $query .= "and a.app_id = $appointment_id";
        }
        $sql = $this->db->query($query);
        if ($sql->num_rows()) {
            $data = $appointment_id ? $sql->row_array() : $sql->result_array();
            if ($appointment_id) {
                $start_datetime = strtotime($this->basic_model->change_utc_datetime($data['start_date'] . ' ' . $data['start_time']));
                $end_datetime = strtotime($this->basic_model->change_utc_datetime($data['end_date'] . ' ' . $data['end_time']));
                $result = $data;
                $result['start_date'] = date('Y-m-d', $start_datetime);
                $result['start_time'] = date('H:i:s', $start_datetime);
                $result['end_date'] = date('Y-m-d', $end_datetime);
                $result['end_time'] = date('H:i:s', $end_datetime);
            } else {
                foreach ($data as $key => $value) {
                    $start_datetime = strtotime($this->basic_model->change_utc_datetime($value['start_date'] . ' ' . $value['start_time']));
                    $end_datetime = strtotime($this->basic_model->change_utc_datetime($value['end_date'] . ' ' . $value['end_time']));
                    $result[$key] = $value;
                    $result[$key]['start_date'] = date('Y-m-d', $start_datetime);
                    $result[$key]['start_time'] = date('H:i:s', $start_datetime);
                    $result[$key]['end_date'] = date('Y-m-d', $end_datetime);
                    $result[$key]['end_time'] = date('H:i:s', $end_datetime);
                }
            }
        }

        return $result;
    }

    public function get_patient_appointments_data($patient_id, $appointment_id = false) {
        $query = "select a.app_id,a.patient_id,a.provider_id,pa.start_date,pa.end_date,pa.start_time,pa.end_time,a.slot_id as avail_id, a.status
from bm_appointments as a
left join bm_provider_availablity as pa on a.slot_id=pa.avail_id
left join bm_users u on a.provider_id=u.user_id

where a.patient_id='{$patient_id}' and  u.user_status='1' ";
        if ($appointment_id) {
            $query .= " and a.app_id = $appointment_id";
        }
        $sql = $this->db->query($query);
        if ($sql->num_rows()) {
            $result = $appointment_id ? $sql->row_array() : $sql->result_array();
            return $result;
        } else {
            return false;
        }
    }

    function get_appointment_transaction($user_id) {
        $data = $result = $charge_ids = array();

        $this->db->select('*,av.start_date,av.end_date,av.start_time,av.end_time,av.avail_id, a.status as app_status');
        $this->db->from(TRANSACTIONS . ' t');
        $this->db->join(USERS . ' u', 't.provider_id = u.user_id');
        $this->db->join(APPOINTMENTS . ' a', 'a.app_id = t.appointment_id');
        $this->db->join(AVAILABALITY . ' av', 'av.avail_id = a.slot_id');
        $this->db->where('t.patient_id', $user_id);
        $this->db->order_by('av.start_date desc, av.start_time desc');
        $query = $this->db->get();
        //echo $this->db->last_Query(); die;
        if ($query->num_rows() > 0) {
            $data = $query->result();
            if ($data && is_array($data)) {
                foreach ($data as $key => $value) {
                    $result[$value->charge_id][$value->transaction_type] = $value;
                }
            }
            return $result;
        } else {
            return array();
        }
    }

    function book_an_appointment($patient_id, $provider_id, $slot_id) {
        $datatoinsert = array();
        $datatoinsert['patient_id'] = $patient_id;
        $datatoinsert['provider_id'] = $provider_id;
        $datatoinsert['slot_id'] = $slot_id;
        $datatoinsert['booked_on'] = $this->basic_model->set_utc_datetime(date('Y-m-d H:i:s'));
        $datatoinsert['status'] = '0';
        $this->db->insert('bm_appointments', $datatoinsert);
        return $this->db->insert_id();
    }

    function update_appointment($appointment_id) {
        if ($this->db->query("update bm_appointments set status='1' where app_id='" . $appointment_id . "'")) {
            return true;
        } else {
            return false;
        }
    }

    function get_total_transaction($user_id) {
        $this->db->select('SUM(t.amount) as total');
        $this->db->from(TRANSACTIONS . ' t');
        $this->db->join(USERS . ' u', 't.patient_id = u.user_id');
        $this->db->join(USERS . ' p', 't.provider_id = p.user_id');
        $this->db->where('u.user_id', $user_id);
        $this->db->where('p.user_status', 1);
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

    function get_total_appointment($user_id) {
        $this->db->select('COUNT(*) as total');
        $this->db->from(APPOINTMENTS . ' a');
        $this->db->join(TRANSACTIONS . ' t', 't.appointment_id = a.app_id');
        $this->db->join(USERS . ' u', 't.patient_id = u.user_id');
        $this->db->join(USERS . ' p', 't.provider_id = p.user_id');
        $this->db->where('u.user_id', $user_id);
        $this->db->where('u.user_status', '1');
        $this->db->where('p.user_status', 1);
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
            return array();
        }
    }

    function get_provider($user_id) {
        $this->db->select('*');
        $this->db->from(USERS . ' u');
        $this->db->join(APPOINTMENTS . ' a', 'a.provider_id = u.user_id');
        $this->db->join(TRANSACTIONS . ' t', 't.appointment_id = a.app_id');
        $this->db->where('a.patient_id', $user_id);
        $this->db->where('u.user_status', '1');
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

    function get_upcoming_appointment($user_id, $limit = null) {
        $result = array();
        $start_datetime = date('Y-m-d H:i:s', strtotime($this->basic_model->set_utc_datetime(date('Y-m-d H:i:s')) . " - 15 minutes"));

        //$this->db->select('u.first_name,u.last_name,av.start_date,av.end_date,av.start_time,av.end_time');
        $this->db->select('u.user_id,u.first_name,u.last_name,u.user_email,av.start_date,av.end_date,av.start_time,av.end_time,av.avail_id,a.*');
        $this->db->from(USERS . ' u');
        $this->db->join(APPOINTMENTS . ' a', 'a.provider_id = u.user_id');
        $this->db->join(TRANSACTIONS . ' t', 't.appointment_id = a.app_id and t.transaction_type = "charge"');
        $this->db->join(AVAILABALITY . ' av', 'av.avail_id = a.slot_id');
        $this->db->where('a.patient_id', $user_id);
        $this->db->where('concat_ws(" ",av.start_date,av.start_time) >= ', $start_datetime);
        $this->db->where('a.status', '1');
        $this->db->where('av.status', '1');
        $this->db->where('u.user_status', '1');
        if ($limit) {
            $this->db->limit(10);
        }
        $order = 'av.end_date asc, av.end_time asc';
        $this->db->order_by($order);
        $query = $this->db->get();
        //prd($query->result(), 1);
        if ($query->num_rows() > 0) {
            $result = $query->result();
        }
        return $result;
    }

    function get_provider_specialities($specialities) {
        if (isset($specialities) && !empty($specialities)) {
            $return = array();
            $sp_array = explode(",", $specialities);
            foreach ($sp_array as $sp) {
                $sp_query = "select * from bm_speciality where speciality_id='" . $sp . "'";
                $sp_query = $this->db->query($sp_query);
                if ($sp_query->num_rows()) {
                    $result = $sp_query->result_array();
                    array_push($return, $result[0]['speciality_title']);
                }
            }
            return $return;
        } else {
            return "";
        }
    }

    function save_zoom_info($appointment_zoom_data) {
        return $this->db->insert(APPOINTMENTS_ZOOM_INFO, $appointment_zoom_data) ? $this->db->insert_id() : false;
    }

    function get_insurence($insurance_carriers) {
        if (isset($insurance_carriers) && !empty($insurance_carriers)) {
            $return = array();
            $in_array = explode(",", $insurance_carriers);
            foreach ($in_array as $in) {
                $in_query = "select * from bm_insurance where id='" . $in . "'";
                $in_query = $this->db->query($in_query);
                if ($in_query->num_rows()) {
                    $result = $in_query->result_array();
                    array_push($return, $result[0]['insurance']);
                }
            }
            return $return;
        } else {
            return "";
        }
    }

}
