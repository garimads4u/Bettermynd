<?php
    $notificaion_msg= unread_mesages($this->session->userdata('user_id'));    
//    print_r($notificaion_msg);die;
    $sys_notification = get_nofication($this->session->userdata('user_id'));
    $tot_sys_notification = get_tot_nofication($this->session->userdata('user_id'));
?>
<div class="top_nav">
  <div class="nav_menu">
    <nav class="" role="navigation">
      <div class="nav toggle"> <a id="menu_toggle"><i class="fa fa-bars"></i></a> </div>
    
        <div class="mob-logo">
      <?php  if(isset($header_data) && isset($header_data['logo'])){ ?>
            <a href="<?php echo SITE_URL;?>"><img src="<?php  echo ASSETS_URL."logo/".$header_data['logo'];?>" width="176" height="52"  alt=""/></a>
        <?php }else if(isset($_SESSION['user_id']) && $_SESSION['user_id'] > 0 && $_SESSION['user_type'] == '4'){ ?>
            <a class="hidden-md" href="<?php echo PATIENT_URL."dashboard";?>"><img src="<?php echo IMAGES_URL;?>mob-view.png" /></a>
            <a class="hidden-sm" href="<?php echo PATIENT_URL."dashboard";?>"><img src="<?php echo IMAGES_URL;?>mob-view.png" /></a>
        <?php }else if(isset($_SESSION['user_id']) && $_SESSION['user_id'] > 0 && $_SESSION['user_type'] == '2'){ ?>
            <a class="hidden-md" href="<?php echo COLLEGE_URL."dashboard";?>"><img src="<?php echo IMAGES_URL;?>mob-view.png" /></a>
            <a class="hidden-sm" href="<?php echo COLLEGE_URL."dashboard";?>"><img src="<?php echo IMAGES_URL;?>mob-view.png" /></a>
        <?php }else if(isset($_SESSION['user_id']) && $_SESSION['user_id'] > 0 && $_SESSION['user_type'] == '3'){ ?>
            <a class="hidden-md" href="<?php echo PROVIDER_URL."dashboard";?>"><img src="<?php echo IMAGES_URL;?>mob-view.png" /></a>
            <a class="hidden-sm" href="<?php echo PROVIDER_URL."dashboard";?>"><img src="<?php echo IMAGES_URL;?>mob-view.png" /></a>
        <?php }else if(isset($_SESSION['user_id']) && $_SESSION['user_id'] > 0 && $_SESSION['user_type'] == '5'){ ?>
            <a class="hidden-md" href="<?php echo THIRD_PARTY_URL."dashboard";?>"><img src="<?php echo IMAGES_URL;?>mob-view.png" /></a>
            <a class="hidden-sm" href="<?php echo THIRD_PARTY_URL."dashboard";?>"><img src="<?php echo IMAGES_URL;?>mob-view.png" /></a>    
        <?php }else{  ?>
            <a class="hidden-md" href="<?php echo SITE_URL;?>"><img src="<?php echo IMAGES_URL;?>mob-view.png" /></a>
            <a class="hidden-sm" href="<?php echo SITE_URL;?>"><img src="<?php echo IMAGES_URL;?>mob-view.png" /></a>
        <?php } ?>
      
                                <div class="toggle_tagline-mob"></div>
                        </div>
                        <div class="toggle_tagline"></div>
      
      <ul class="nav navbar-nav navbar-right">
        <li class="">
            <a href="#" class="logout" title="Logout">
            <i class="fa fa-sign-out" aria-hidden="true"></i>
            </a>
        </li>
        <!--<li role="presentation" class="dropdown"> 
            <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false"> 
                <i class="fa fa-envelope-o" aria-hidden="true"></i>
                <span class="badge bg-blue mnotification" id="mail_count"><?php echo (isset($notificaion_msg) && !empty($notificaion_msg) && count($notificaion_msg)>0)?$notificaion_msg[0][0]->count:''; ?></span> 
            </a>
            <ul  class="dropdown-menu list-unstyled msg_list animated fadeIn" id="email_notification" role="menu">
                <?php if(isset($notificaion_msg) && !empty($notificaion_msg) && count($notificaion_msg)>0){
                    foreach($notificaion_msg[1] as $key=>$value){ ?>
                <li id="notify<?php echo $value->manage_id; ?>"> 
                     <a href="<?php echo ($this->uri->segment(1)=='email' && $this->uri->segment(2)=='inbox')?'javascript:void(0);':EMAIL_URL.'inbox/'.$value->manage_id;?>"  class="notify" data-value="box_inbox<?php echo $value->mail_id; ?>"> 
                          <span class="image">
            <?php  if (isset($value) && isset($value->profile_photo) && strlen($value->profile_photo)>0){ ?>
                   
        <img src="<?php echo IMAGE_VIEW_URL;?>?image=/<?php echo $value->profile_photo;?>&width=150&height=150&cropratio=1:1&doc_root=<?php echo urlencode(FILE_UPLOAD_PATH."upload/");?>" alt="Profile Image"/>
        <?php
              } else {
              ?>
        <img src="<?php echo DEFAULT_PROFILE_PIC;?>" alt="..." >
            <?php } ?>
                         </span>
                         
                         <span> 
                             <span><strong><?php echo $value->username; ?></strong></span> 
                             <span class="time pull-right" ><?php echo $this->basic_model->time_elapsed_string(strtotime($value->created_date)) ?></span>
                         
                         </span> 
                         <span class="message">
                             <?php echo (strlen(strip_tags(html_entity_decode(($value->subject))))>80)?substr(strip_tags(html_entity_decode(($value->subject))),0,80).'...':strip_tags(html_entity_decode(($value->subject))); ?> 
                         </span>
                     </a>
                 </li>
                <?php } ?>
                
                
                <?php } ?>
                 <li>
                    <div class="text-center"> <a href="<?php echo EMAIL_URL.'inbox'; ?>"> <strong>See All</strong> <i class="fa fa-angle-right"></i> </a> </div>
                </li>
            </ul>
        </li>
        <li role="presentation" class="dropdown"> 
            <a href="#" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false"> 
               <i class="fa fa-bell-o" aria-hidden="true"></i>
                <span class="badge bg-blue mnotification" id="notification_count"><?php echo ($tot_sys_notification>0)?$tot_sys_notification:''; ?></span>
            </a>
            <ul id="menu2" class="dropdown-menu list-unstyled msg_list animated fadeIn" role="menu">
                <?php 
                if(is_array($sys_notification) && count($sys_notification)>0){
                foreach($sys_notification as $val) {
                    $n_u_id = $this->encrypt->encode($val->id);
                    $n_u_id = str_replace(array('+', '/', '='), array('-', '_', '~'), $n_u_id);
                    ?>
                <li><a href="<?php echo TEMPLATE_URL.$val->url.'/'.$n_u_id; ?>" ><span class="time"><?php echo $this->basic_model->time_elapsed_string(strtotime($val->added)); ?></span><br><span class="message"><?php echo $val->notification_msg; ?></span> </a> </li>
                <?php }}?>
                <li>
                    <div class="text-center"> <a href="<?php echo NOTIFICATION_URL; ?>"> <strong>See All</strong> <i class="fa fa-angle-right"></i> </a> </div>
                </li>
            </ul>
        </li>-->        
      </ul>
    </nav>
  </div>
  <div class="page-title">
    <div class="title_left">
      <h3><?php
	 
	   if(isset($header_data) && isset($header_data['page_title'])){
		  echo $header_data['page_title'];
	  }
	  else{
		  echo "Dashboard";
	  }
	  ?></h3>
    </div>
    <div class="title_right">
      <ol class="breadcrumb">
      <?php 
      if(isset($header_data) && isset($header_data['breadcrumbs']) && is_array($header_data['breadcrumbs'])){
                        $length=count($header_data['breadcrumbs']) - 1;
                        
		  	for($i=1;$i<count($header_data['breadcrumbs']);$i++){
                            if($i!=$length) {
			?>
                        <li><a href="<?php echo $header_data['breadcrumbs'][0];?><?php echo $header_data['breadcrumbs'][$i][0];?>"> <?php echo ucwords($header_data['breadcrumbs'][$i][1]);?></a></li>
			<?php
                            }
                            else{
                                ?>
                        <li> <?php echo ucwords($header_data['breadcrumbs'][$i][1]);?></li>
                                <?php
                            }
			}
		  }
		  else{
		  ?>
        <li><a href="#"> Dashboard</a></li>
        <?php
		  }
		?>
      </ol>
    </div>
  </div>
</div>
<script type="text/javascript">
    <?php if($this->uri->segment(1)=='email' && $this->uri->segment(2)=='inbox'){ ?>
$(document).ready(function() {
    $(".notify").click(function() {
        $('.nav-tabs a[href="#inbox"]').tab('show');        
        var id = $(this).attr('data-value'); 
        $('.box_inbox a[href="#'+id+'"]').click()
//        $(".inbox-body").each(function(){
//            $(this).hide();
//            if($(this).attr('id') == id) {
//                $(this).show();
//            }
//        });        
        
    });
});
<?php } ?>
</script>