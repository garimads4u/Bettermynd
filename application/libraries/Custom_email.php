<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Custom_Email extends CI_Email {

    public function __construct() {
        parent::__construct();
    }

    public function send_email($from = FALSE, $to = FALSE, $subject = FALSE, $message = FALSE, $attachement = FALSE) {
        if ($from && $to && $subject && $message) {
            //ci email
            $this->clear();
            $this->from($from);
            $this->to($to);
            $this->subject($subject);
            $this->message($message);
            if ($this->send() == TRUE)
                return TRUE;
            else
                return FALSE;
        }
    }

    public function sendinblue_email($from = FALSE, $to = FALSE, $subject = FALSE, $message = FALSE, $attachement = FALSE) {
        if ($from && $to && $subject && $message) {
            $oldtimeout = ini_get('max_execution_time');
            ini_set('max_execution_time', 46 * 60);
            require_once(APPPATH . 'libraries/Sendinblue/Mailin.php');
            $mailin = new Mailin('https://api.sendinblue.com/v2.0', 'fqRkwZEB5Ta7SFcP');    //Optional parameter: Timeout in MS

            $data = array("to" => array($to => $to),
                "from" => array($from, SITE_NAME),
                "subject" => $subject,
                "html" => $message,
                    //"attachment" => array("https://domain.com/path-to-file/filename1.pdf", "https://domain.com/path-to-file/filename2.jpg")
            );

            $response = $mailin->send_email($data);
            ini_set('max_execution_time', $oldtimeout);
            if ($response && strtolower(trim($response['code'])) == 'success')
                return TRUE;
            else
                return FALSE;
        }
    }

}
