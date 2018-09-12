<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Message_model extends CI_Model {

    function __construct() { // Constructor
        parent::__construct();
    }

    function send_flashmessage(){
        if($this->db->insert('bm_flashmessages', array('message'=>$this->input->post('flashmessage')))){
            $message_id = $this->db->insert_id();
            $colleges = $this->input->post('college_id');
            foreach($colleges as $college_id){
                $this->db->insert('bm_flashmessage_colleges', array('message_id'=>$message_id, 'college_id'=>$college_id));
            }
        }
    }

    function admin_get_flashmessages(){
        return $this->db->query("select fm.*, (select group_concat(c.college_name) from bm_flashmessage_colleges fmc left join bm_college c on c.college_id=fmc.college_id where fmc.message_id = fm.id) as colleges from bm_flashmessages fm order by fm.id desc")->result();
    }
    function get_flashmessages($college_id = false){
        if(!$college_id)return false;
        return $this->db->query("select fm.* from bm_flashmessage_colleges fmc join bm_flashmessages fm on fmc.message_id = fm.id where fmc.college_id = $college_id order by fm.id desc")->result();
    }
}

?>