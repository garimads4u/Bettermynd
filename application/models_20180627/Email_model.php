<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Email_model extends CI_Model {

    function __construct() { // Constructor
        parent::__construct();
    }
    function All_mails($user){
        
         $data = array(
            'mail_template_slang' => $slang,
            'mail_template_status' => '1'
        );
        $query = $this->db->get_where(MAIL_TEMPLATES, $data);
        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            return false;
        }
    }
     function All_users($user_id,$user_role,$comapny_id=""){
         $data = array(
            'user_status' => '1'
        );
         $user_status=array('1');
         $where_in=array('3','5');
         $this->db->select('user_email,username,user_id');
         $this->db->from(USERS);
         $this->db->where_in('user_role',$where_in);
         $this->db->where('user_status', '1');
         $this->db->where('user_company_id', $comapny_id);
         
         $query =$this->db->get();
        if ($query->num_rows() > 0) {
             $level = array();

        foreach ($query->result() as $key => $value) {

            $level[$value->user_id] = $value->user_email;
        }
        return $level;        
        } else {
            return false;
        }
    }
    
      function roleTypeUsers($user_role=3,$company_id=''){
           $query = "select * from " . USERS . " where user_role='$user_role' and user_status='1'";
          if(!empty($company_id)){
            $query.= "user_company_id=$company_id";
          }
            $query.= " order by user_id";

        $sql = $this->db->query($query);
        $row = $sql->result();
        if (count($row)) {
            return $row;
        }else{
            return false;
        }
    }
    
    
      function all_inbox_Mails($userid){
        $query="select x.*,b.user_id,b.account_holder_name,b.user_email,b.username from (SELECT a.id,a.prent_id,a.subject,a.orig_name,a.file_name,a.discription,a.msg_type,b.id as manage_id,a.created_date,b.read,b.sender_id,b.recevier_id,b.mail_id FROM ".EMAIL." as `a` inner join ".EMAIL_MANAGE." as b on b.mail_id=a.id where b.recevier_id=$userid and b.receverstatus='1') as x inner join ".USERS." b on x.sender_id=b.user_id order by x.id desc";
        $sql = $this->db->query($query);
        $row = $sql->result();
        if (count($row)) {
            return $row;
        }else{
            return false;
        }
    }
    
    function all_outbox_Mails($userid){
        $query="select a.*,b.* from (SELECT a.id,a.subject,a.msg_type,a.orig_name,a.file_name,a.discription,a.created_date,a.msg_send_to,b.recevier_id FROM ".EMAIL." as `a` inner join ".EMAIL_MANAGE." as b on b.mail_id=a.id where b.sender_id=$userid and b.senderstatus='1' group by a.id order by a.id desc) as a inner join ".USERS." as b on a.recevier_id=b.user_id order by a.id desc";
//        echo $query;die;
        $sql = $this->db->query($query);
        $row = $sql->result();
        if (count($row)) {
            return $row;
        }else{
            return false;
        }
    }
    
    function user_msg_detail($msg_id){
          $query="select  a.*,b.* from  ".EMAIL_MANAGE." as a inner join ".USERS." b on a.recevier_id=b.user_id where a.mail_id=$msg_id";
        $sql = $this->db->query($query);
        $row = $sql->result();
        if (count($row)) {
            return $row;
        }else{
            return false;
        }
    }
    
    function msg_detail($msg_id,$recevier_id){
        $query="select a.*,b.user_id,b.user_email,b.account_holder_name from (select  a.*,b.sender_id from ".EMAIL." as a inner join ".EMAIL_MANAGE."  as b on a.id=b.mail_id where a.id=".$msg_id." and b.recevier_id=".$recevier_id." ) as a inner join ".USERS." as b on a.sender_id=b.user_id";
        $sql = $this->db->query($query);
        $row = $sql->result();
        if (count($row)) {
            return $row;
        }else{
            return false;
        }
    }
    
    function All_users_role($select=true,$user_id,$user_role="",$comapny_id=""){
         $data = array(
            'user_status' => '1'
        );
         
         
         $this->db->select('user_email,username,user_id,user_role,user_company_id');
         $this->db->from(USERS);
         
         if(isset($user_role) && is_array($user_role) && !empty($user_role)){
         $this->db->where_in('user_role',$user_role);    
         }elseif(isset ($user_role ) &&  !empty($user_role)){
         $this->db->where('user_role',$user_role);    
         }
         $this->db->where_not_in('user_id',$user_id);
         
         if(isset($comapny_id) && is_array($comapny_id) && !empty($comapny_id)){
            $this->db->where_in('user_company_id',$comapny_id);    
            }elseif(isset ($comapny_id ) &&  !empty($comapny_id)){
            $this->db->where('user_company_id',$comapny_id);    
         }
         
         $this->db->where('user_status', '1');
         
         $query =$this->db->get();
        if ($query->num_rows() > 0) {
            if($select){
                $level = array();
                foreach ($query->result() as $key => $value) {

                    $level[$value->user_id] = $value->user_email;
                }
                return $level;
            }else{
                return $query->result();                
            }        
        } else {
            return false;
        }
    }
    function update_read_status($id){
        $query="select * from ".EMAIL_MANAGE." where  id=".$id['id'];
        $sql = $this->db->query($query);
        if($sql->num_rows()>0){
            $data = array(
                'read' => '1',
                );
            $this->db->where('id', $id['id']);
            $update=$this->db->update(EMAIL_MANAGE, $data);       

            if($update){
                return true;
            }            
        }        
        return false;
    }
    
    function getNotification($userid){
        $query="select * from ".NOTIFICATION." n inner join ".NOTIFICATION_USER." nu on(n.id = nu.notification_id) where nu.user_id = $userid order by n.added desc";            
        $sql = $this->db->query($query);
        $row = $sql->result();
        if (count($row)) {
            return $row;
        }else{
            return false;
        }
    }
    function getfileAttachment($mail_id='',$file_name='',$userid){
        if(isset($mail_id) && !empty($mail_id) && isset($file_name) && !empty($file_name) ){
            $query="select  a.* from ".EMAIL." as a inner join ".EMAIL_MANAGE." as b on a.id=b.mail_id 
         where       
case WHEN  b.recevier_id=$userid
         THEN b.receverstatus='1'
         ELSE b.senderstatus='1'
END and         
 a.id=".$mail_id." and a.file_name='".$file_name."'   limit 0,1";         
//            echo $query;die;
            $sql = $this->db->query($query);
            if($sql->num_rows()>0){
                $row = $sql->result();
                return $row[0];
            }            
        }
            return false;
    }
    function delete_mail($id,$userid,$type='inbox'){
        if($type =='inbox'){    
        $query="select  a.* from ".EMAIL." as a inner join  ".EMAIL_MANAGE." as b on a.id=b.mail_id where a.id=$id and b.recevier_id=$userid limit 0,1";         
            $sql = $this->db->query($query);
            
        }else if($type =='outbox'){
        $query="select  a.* from ".EMAIL." as a inner join  ".EMAIL_MANAGE." as b on a.id=b.mail_id where a.id=$id and b.sender_id=$userid limit 0,1";         
            $sql = $this->db->query($query);            
        }else{
            return false;
        }
            $sql = $this->db->query($query);
            if($sql->num_rows()>0){
                $row=$sql->result();
                if($type =='inbox'){                    
                    $data = array(
                    'receverstatus' => '0',
                    );
                    $this->db->where('recevier_id', $userid);
                }else if($type =='outbox'){
                    $data = array(
                    'senderstatus' => '0',
                    );
                    $this->db->where('sender_id', $userid);
        //            $query.='senderstatus="0" where sender_id='.$userid.' and mail_id= '.$id;
                }else{
                    return false;
                }
                $this->db->where('mail_id', $id);
               $update= $this->db->update(EMAIL_MANAGE,$data);
                if($update){
                    return $row;
                }
                return false;
            }
            return false;                   
    }

    function get_tot_nofication($userid){
        $this->load->model('basic_model');
        $sql_not_count = $this->db->query("select count(*) as total_not from ".NOTIFICATION." n inner join ".NOTIFICATION_USER." nu on(n.id = nu.notification_id) where nu.user_id = $userid and nu.read_status='0'");
        $not_result = $sql_not_count->result();
        $total_notification = $not_result['0']->total_not;
        
        $sql = $this->db->query("select * from ".NOTIFICATION." n inner join ".NOTIFICATION_USER." nu on(n.id = nu.notification_id) where nu.user_id = $userid and nu.read_status='0' order by added desc limit 5");
        $html_data ='';
        $total_rows = $sql->num_rows();
        if($total_rows>0){ 
        $sys_notification=$sql->result();
        if(is_array($sys_notification) && count($sys_notification)>0){
                foreach($sys_notification as $val) {
                    $n_u_id = $this->encrypt->encode($val->id);
                    $n_u_id = str_replace(array('+', '/', '='), array('-', '_', '~'), $n_u_id);
                    $html_data .= '<li> <a href="'.TEMPLATE_URL.$val->url.'/'.$n_u_id.'"><span class="time">';
                    $html_data .= $this->basic_model->time_elapsed_string(strtotime($val->added)).'</span><br><span class="message">'.$val->notification_msg.'</span> </a> </li>';
                    
        }}}
        $html_data .= '<li><div class="text-center"> <a href="'.NOTIFICATION_URL.'"> <strong>See All</strong> <i class="fa fa-angle-right"></i> </a> </div></li>';
        
        $query_email_count ="select count(*) as tot_email from (SELECT a.id,a.prent_id,a.subject,a.discription,a.msg_type,a.created_date,b.id as manage_id,b.sender_id,b.recevier_id,b.mail_id FROM ".EMAIL." as `a` inner join ".EMAIL_MANAGE." as b on b.mail_id=a.id where b.recevier_id=$userid and  b.read='0' and b.receverstatus='1') as x inner join ".USERS." b on x.sender_id=b.user_id order by x.id desc";            
        $sql_email_count = $this->db->query($query_email_count);
         $row_email_count = $sql_email_count->result();
        $email_total_rows = $row_email_count['0']->tot_email;
        $query_email="select x.*,b.user_id,b.profile_photo,b.account_holder_name,b.username,b.user_email from (SELECT a.id,a.prent_id,a.subject,a.discription,a.msg_type,a.created_date,b.id as manage_id,b.sender_id,b.recevier_id,b.mail_id FROM ".EMAIL." as `a` inner join ".EMAIL_MANAGE." as b on b.mail_id=a.id where b.recevier_id=$userid and  b.read='0' and b.receverstatus='1') as x inner join ".USERS." b on x.sender_id=b.user_id order by x.id desc limit 5";            
        $sql_email = $this->db->query($query_email);
        $row_email = $sql_email->result();
        $html_email = '';
        if(isset($row_email) && !empty($row_email) && count($row_email)>0){
               foreach($row_email as $key=>$value){ 
                $html_email .='<li id="notify'.$value->manage_id.'">'; 
                $html_email .='<a href="'.EMAIL_URL.'inbox/'.$value->manage_id.'"  class="notify" data-value="box_inbox'.$value->mail_id.'">'; 
                $html_email .='<span class="image" style="width:69%">';
                if (isset($value) && isset($value->profile_photo) && strlen($value->profile_photo)>0){ 
        /*$html_email .='<img src="'.IMAGE_VIEW_URL.'image/'.$value->profile_photo;?>&width=150&height=150&cropratio=1:1&doc_root=<?php echo urlencode(FILE_UPLOAD_PATH."upload/");?>" alt="Profile Image"/>
                    */  
           $profile_photo = $value->profile_photo;         
                 $html_email .='<img src="'.IMAGE_VIEW_URL.'?image=/'.$profile_photo.'&width=150&height=150&cropratio=1:1&doc_root='.urlencode(FILE_UPLOAD_PATH."upload/").'" class="img-circle profile_img"/>';           
                } else {
              $html_email .='<img src="'.DEFAULT_PROFILE_PIC.'" alt="..."  width="50" height="50">';
             } 
                       $html_email .='  </span><span> <span>'.$value->username.'</span> <span class="time">'.$this->basic_model->time_elapsed_string(strtotime($value->created_date)).'</span> </span> <span class="message">'.$value->subject.'</span>';
                    $html_email .= '</a></li>';
                }} 
                 $html_email .= '<li><div class="text-center"> <a href="'.EMAIL_URL.'inbox"> <strong>See All</strong> <i class="fa fa-angle-right"></i> </a> </div>
                </li>';
        
        
        $response_array = array(
            "notification" =>array(
             "count_notification" => $total_notification,
             "notification_html" => $html_data  
            ),
            "email" =>array(
               "count_email" =>$email_total_rows,
               "email_html" => $html_email
            )
        );
        //echo $total_rows.'|~|'.$html_data;
        echo json_encode($response_array);
        die();
    }
}