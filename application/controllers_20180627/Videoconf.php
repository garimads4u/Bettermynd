<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Videoconf extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('zoomapi');
        $this->basic_model->set_current_timezone();
    }

    function list_user() {
        $response = $this->zoomapi->listUsers();
        $users = json_decode($response);
        prd($users);
    }

    function list_meeting() {
        $data1 = array(
            'host_id' => 'wkOXoOSeQoCzlbrUwlWSxw'
//            'host_id' => '91zIyX-DSj-wr9dwQndaRQ'
        );
        echo '<pre>';
        $response = $this->zoomapi->listMeetings($data1);
        prd(json_decode($response));
        die;
    }

    function create_meeting() {
        $data1 = array(
//                    'host_id' => $provider_id,
            'host_id' => '91zIyX-DSj-wr9dwQndaRQ',
            'topic' => 'Meeting',
            'type' => 1,
        );
        $response = $this->zoomapi->createAMeeting($data1);
        prd(json_decode($response));
        die;
    }

    function log_meeting() {
        $data1 = array(
            'from' => '2017-01-01',
            'to' => '2017-01-17',
            'type' => 2,
        );
        $response = $this->zoomapi->logMeeting($data1);
        prd(json_decode($response));
        die;
    }

    function create_user() {
        $data1 = array(
            'email' => 'sourabh@ukitss.com',
            'first_name' => 'sourabh',
            'last_name' => 'tejawat'
        );
        $response = $this->zoomapi->custCreateAUser($data1);
        $response = json_decode($response);
        prd($response);
    }

    function list_recording() {
        $data1 = array(
            'host_id' => 'wkOXoOSeQoCzlbrUwlWSxw'
        );
        $response = $this->zoomapi->list_recording($data1);
        prd(json_decode($response));
        die;
    }

}
