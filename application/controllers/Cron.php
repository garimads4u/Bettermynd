<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cron extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('email');
        set_smtp_config();
    }

    //Run Every Hour
    function appointmentnotification() {
        $query = "select
            a.app_id appointment_id,
            pat.user_id patient_id,
            pat.first_name patient_fname,
            pat.last_name patient_lname,
            pat.user_email patient_email,
            pro.user_id provider_id,
            pro.first_name provider_fname,
            pro.last_name provider_lname,
            pro.user_email provider_email,
            at.amount session_cost,
            pa.start_date,
            pa.start_time,
            CONCAT(pa.start_date,' ',pa.start_time) appointment_start_time,
            CONCAT(pa.end_date,' ',pa.end_time) appointment_end_time
        from bm_appointments a
        left join bm_provider_availablity pa on a.slot_id = pa.avail_id
        left join bm_users pat on pat.user_id=a.patient_id
        left join bm_users pro on pro.user_id=a.provider_id
        left join bm_appointment_transaction at on at.appointment_id=a.app_id
        where
        a.status = 1 and
        CONCAT(pa.start_date,' ',pa.start_time) BETWEEN DATE_ADD(NOW(), INTERVAL 24 HOUR) AND DATE_ADD(NOW(), INTERVAL 25 HOUR)";
        $sql = $this->db->query($query);
        $appointments = $sql->result_array();
        foreach ($appointments as $appointment) {
            //Notify Provider
            $message_content = $this->basic_model->get_mail_template('appointment_notify_provider');
            $mail_content = html_entity_decode($message_content->mail_template_content);
            $message = str_replace("{{identity}}", $appointment['provider_fname'] . " " . $appointment['provider_lname'], $mail_content);
            $message = str_replace(" {{patient_name}}", $appointment['patient_fname'] . " " . $appointment['patient_lname'], $message);
            $message = str_replace("{{siteurl}}", SITE_URL, $message);
            $message = str_replace("{{appointment_date}}", $appointment['start_date'], $message);
            $message = str_replace("{{appointment_time}}", $appointment['start_time'], $message);
            $message = str_replace("{{payment_info}}", CURRENCY_SYMBOL . $appointment['session_cost'], $message);
            $message = MAIL_HEADER . $message . MAIL_FOOTER;

            $this->email->clear();
            $this->email->from($this->config->item('admin_email', 'ion_auth'), $this->config->item('site_title', 'ion_auth'));
            $this->email->to($appointment['provider_email']);
            $this->email->subject($message_content->mail_subject);
            $this->email->message($message);
            $this->email->send();

            //Notify Patient
            $message_content = $this->basic_model->get_mail_template('appointment_notify_patient');
            $mail_content = html_entity_decode($message_content->mail_template_content);
            $message = str_replace("{{identity}}", $appointment['patient_fname'] . " " . $appointment['patient_lname'], $mail_content);
            $message = str_replace("{{provider_name}}", $appointment['provider_fname'] . " " . $appointment['provider_lname'], $message);
            $message = str_replace("{{siteurl}}", SITE_URL, $message);
            $message = str_replace("{{appointment_date}}", $appointment['start_date'], $message);
            $message = str_replace("{{appointment_time}}", $appointment['start_time'], $message);
            $message = str_replace("{{payment_info}}", CURRENCY_SYMBOL . $appointment['session_cost'], $message);
            $message = MAIL_HEADER . $message . MAIL_FOOTER;

            $this->email->clear();
            $this->email->from($this->config->item('admin_email', 'ion_auth'), $this->config->item('site_title', 'ion_auth'));
            $this->email->to($appointment['patient_email']);
            $this->email->subject($message_content->mail_subject);
            $this->email->message($message);
            $this->email->send();
        }
    }

    //Run Every 15 Minutes
    function endexpiredmeetings() {
        $query = "select
            a.app_id appointment_id,
            pa.start_date,
            pa.start_time,
            CONCAT(pa.start_date,' ',pa.start_time) appointment_start_time,
            CONCAT(pa.end_date,' ',pa.end_time) appointment_end_time
        from bm_appointments a
        left join bm_provider_availablity pa on a.slot_id = pa.avail_id
        left join bm_appointments_zoom_info azi on azi.appointment_id=a.app_id
        where
        CONCAT(pa.end_date,' ',pa.end_time) < NOW()";
        $sql = $this->db->query($query);
        $appointments = $sql->result_array();
        foreach ($appointments as $appointment) {
            $endAMeetingArray = array(
                'id' => $appointment['res_id'],
                'host_id' => $appointment['req_host_id']
            );
            $this->zoomapi->endAMeeting($endAMeetingArray);
        }
    }

    public function endmeeting() {
        $oldtimeout = ini_get('max_execution_time');
        ini_set('max_execution_time', 46 * 60);
        $upcoming_appointments = $this->basic_model->get_current_appointment();
        if ($upcoming_appointments && is_array($upcoming_appointments)) {
            $this->load->library('zoomapi');
            foreach ($upcoming_appointments as $key => $value) {
                if ($value['app_id']) {
                    $app_id = $value['app_id'];
                    $sql = $this->db->query('select * from bm_appointments_zoom_info where appointment_id=' . $app_id);
                    $appointment = $sql->row_array();
                    if (count($appointment)) {
                        $endAMeetingArray = array(
                            'id' => $appointment['res_id'],
                            'host_id' => $appointment['req_host_id']
                        );
                        $response = $this->zoomapi->endAMeeting($endAMeetingArray);
                        if ($response) {
                            $this->db->update(APPOINTMENTS, array('end_status' => '0'), array("app_id" => $app_id));
                        }
                    }
                }
            }
        }
        ini_set('max_execution_time', $oldtimeout);
        exit;
    }

}

?>