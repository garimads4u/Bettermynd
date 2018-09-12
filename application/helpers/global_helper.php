<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

function unread_mesages($userid) {
    $ci = & get_instance();
    $ci->load->database();
    $total_array = array();
    $count_query = "SELECT count(*) as count FROM " . EMAIL . " as `a` inner join " . EMAIL_MANAGE . " as b on b.mail_id=a.id where b.recevier_id=$userid and  b.read='0' and b.receverstatus='1'";
    $sql_count = $ci->db->query($count_query);
    if ($sql_count->num_rows() > 0) {
        $row_count = $sql_count->result();
        array_push($total_array, $sql_count->result());
        if ($row_count[0]->count > 0) {
            $query = "select x.*,b.user_id,b.profile_photo,b.account_holder_name,b.user_email,b.username  from (SELECT a.id,a.prent_id,a.subject,a.discription,a.msg_type,a.created_date,b.id as manage_id,b.sender_id,b.recevier_id,b.mail_id FROM " . EMAIL . " as `a` inner join " . EMAIL_MANAGE . " as b on b.mail_id=a.id where b.recevier_id=$userid and  b.read='0' and b.receverstatus='1' order by a.id desc limit 0,5) as x inner join " . USERS . " b on x.sender_id=b.user_id order by x.id desc limit 0,5";
            $sql = $ci->db->query($query);
            if ($sql->num_rows() > 0) {
                array_push($total_array, $sql->result());
                return $total_array;
            } else {
                return false;
            }
        }
    }
}

/*
 *  show all system specific notification
 */

function get_nofication($userid) {
    $ci = & get_instance();
    $ci->load->database();
    $query = "select * from " . NOTIFICATION . " n inner join " . NOTIFICATION_USER . " nu on(n.id = nu.notification_id) where nu.user_id = $userid and nu.read_status='0' order by added desc limit 5";
    $sql = $ci->db->query($query);
    $row = $sql->result();
    if (count($row)) {
        return $row;
    } else {
        return false;
    }
}

/*
 *  show all system specific notification
 */

function get_tot_nofication($userid) {

    $ci = & get_instance();
    $ci->load->database();
    $query = "select count(*) as tot_rec from " . NOTIFICATION . " n inner join " . NOTIFICATION_USER . " nu on(n.id = nu.notification_id) where nu.user_id = $userid and nu.read_status='0' order by added desc";
    $sql = $ci->db->query($query);
    $row = $sql->result();
    return $row['0']->tot_rec;
}

function get_state_name($stateCode) {
    $ci = & get_instance();
    $ci->load->database();
    $ci->db->select('state');
    $ci->db->where('state_code', $stateCode);
    $ci->db->limit(1);
    $query = $ci->db->get(STATES);
    $result = $query->row();
    return $result->state;
}

function getjoinurl($app_id) {
    $ci = & get_instance();
    $ci->load->database();
    $query = "select res_join_url from bm_appointments_zoom_info where appointment_id = $app_id";
    $sql = $ci->db->query($query);
    $row = $sql->row_array();
    if (count($row)) {
        return $row['res_join_url'];
    } else {
        return false;
    }
}

function getstarturl($app_id) {
    $ci = & get_instance();
    $ci->load->database();
    $ci->load->library('zoomapi');
    $query = "select * from bm_appointments_zoom_info where appointment_id = $app_id";
    $sql = $ci->db->query($query);
    $row = $sql->row_array();
    if (count($row)) {
        $data = array(
            'id' => $row['res_id'],
            'host_id' => $row['req_host_id']
        );
        $meeting = $ci->zoomapi->getMeetingInfo($data);

        $meeting = (array) json_decode($meeting);
        return $meeting['start_url'];
    } else {
        return false;
    }
}

function show_date($value = null, $timezone_code = null) {
    if ($value) {
//        if (is_numeric($value)) {
//            $value = date('Y-m-d H:i:s', $value);
//        }
        $CI = get_instance();
        $CI->load->model('basic_model');
        $result = date(DATE_FORMAT, strtotime($CI->basic_model->change_utc_datetime($value, $timezone_code)));
    } else {
        $result = 'N/A';
    }
    return $result;
}

function show_dateTime($value = null, $timezone_code = null) {
    if ($value) {
//        if (is_numeric($value)) {
//            $value = date('Y-m-d H:i:s', $value);
//        }
        $CI = get_instance();
        $CI->load->model('basic_model');
        $result = date(DATE_TIME_FORMAT, strtotime($CI->basic_model->change_utc_datetime($value, $timezone_code)));
    } else {
        $result = '';
    }
    return $result;
}

function show_time($value = null, $timezone_code = null) {
    if ($value) {
        if (is_numeric($value)) {
            $value = date('Y-m-d H:i:s', $value);
        }
        $CI = get_instance();
        $CI->load->model('basic_model');
        $result = date(TIME_FORMAT, strtotime($CI->basic_model->change_utc_datetime($value, $timezone_code)));
    } else {
        $result = 'N/A';
    }
    return $result;
}

function year_dropdown($lenth = 20) {
    $options = array_combine(range(date('Y'), date('Y') + $lenth), range(date('Y'), date('Y') + $lenth));
    return $options;
}

?>