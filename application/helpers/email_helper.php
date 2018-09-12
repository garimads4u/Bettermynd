<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

//set smtp configuration

function set_smtp_config() {
    $ci = get_instance();
    $config = Array(
        'protocol' => 'smtp',
        'smtp_host' => 'smtp.office365.com',
        'smtp_port' => 587,
        'smtp_user' => 'codysemrau@bettermynd.com',
        'smtp_pass' => 'BetterMynd2017!',
        'mailtype' => 'html',
        'smtp_crypto' => 'tls',
        'charset' => 'utf-8'
    );
    $ci->load->library('email', $config);
    $ci->email->set_newline("\r\n");
}

?>