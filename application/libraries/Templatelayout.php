<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of templatelayout
 */
class templatelayout {

    var $obj;

    public function __construct() {
        $this->obj = & get_instance();
    }

    public function get_footer() {
        $this->footer = '';
        $this->obj->elements['footer'] = 'layout/footer';
        $this->obj->elements_data['footer'] = $this->footer;
    }

    public function get_header($header_data = array()) {
        $this->header = '';
        $this->header['header_data'] = $header_data;
        $this->obj->elements['header'] = 'layout/header';
        $this->obj->elements_data['header'] = $this->header;
    }

    public function get_admin_dashboard_header($header_data = array()) {
        $this->header = '';
        $this->header['header_data'] = $header_data;

//	  $this->header['profileimage']= $profileimage;	  
        $this->obj->elements['header'] = 'backend_layout/dashboardheader';
        $this->obj->elements_data['header'] = $this->header;
    }

    public function get_admin_dashboard_footer() {
        $this->footer = '';
        $this->obj->elements['footer'] = 'backend_layout/dashboardfooter';
        $this->obj->elements_data['footer'] = $this->footer;
    }

    public function get_admin_dashboard_sidebar($sidebar, $sidebar_data = array()) {

        $this->sidebar = '';
        $this->sidebar['sidebar_data'] = $sidebar_data;
        $this->obj->elements['sidebar'] = 'backend_layout/' . $sidebar;
        $this->obj->elements_data['sidebar'] = $this->sidebar;
    }

    public function get_home_header($header_data = array()) {
        $this->header = '';
        $this->header['header_data'] = $header_data;
        $this->obj->elements['header'] = 'layout/home_header';
        $this->obj->elements_data['header'] = $this->header;
    }
    
    public function get_home_footer() {
        $this->footer = '';
        $this->obj->elements['footer'] = 'layout/home_footer';
        $this->obj->elements_data['footer'] = $this->footer;
    }


}

?>