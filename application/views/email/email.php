<div class="col-md-12 col-sm-12 col-xs-12" >
   <div id="infoMessage"><?php
        if(isset($message) && strlen($message)>0 ) { 
            $message1=str_replace(" ","",$message);
            if(strlen($message1)>0){
            echo '<p class="alert-success">'.$message.'</p>'; 
            ?><?php
            }
        } ?>
            <?php if(isset($error)  && strlen($error)>0) { 
                ?><?php
            echo '<p class="alert-error">'.$error.'</p>';                 
            ?><?php
        } ?>
    </div>
  <!-- Nav tabs -->
  <ul class="nav nav-tabs email_mess" role="tablist">
  <?php  if((isset($inbox_mail) && !empty($inbox_mail) && count($inbox_mail)>0) || (isset($sent_mail) && !empty($sent_mail) && count($sent_mail)>0)){ ?>
            <a href="javascript:void(0)"  class="btn btn-primary pull-right" id="deletemail"><i class="fa fa-trash" ></i></a>
    <?php } ?>    
    <a href="<?php echo EMAIL_URL ?>inbox" class="btn btn-primary pull-right"><i class="fa fa-refresh"></i></a>
    
                <?php if($current_user->user_role!='3'){ ?>
              <a href="<?php echo EMAIL_URL ?>compose_mail" class="btn btn-primary pull-right compose-big">Compose New Message</a>
              <a href="<?php echo EMAIL_URL ?>compose_mail" class="btn btn-primary pull-right compose"><i class="fa fa-edit"></i></a>
              <?php } ?>
    <li role="presentation" class="active"><a href="#inbox" aria-controls="inbox" role="tab" data-toggle="tab">Inbox</a></li>
    <li role="presentation"><a href="#sendbox" aria-controls="sendbox" role="tab" data-toggle="tab">Sent</a></li>
    
  </ul>
  <!-- Tab panes -->
  <div class="tab-content" id="tabscontent">
    <div role="tabpanel" class="tab-pane active" id="inbox">        
        <div class="x_panel">
            <div class="x_content" style="width:100%; overflow-y:hidden; ">
              <div class="flexbox mobile_mail-overflow">
                
                    <?php if(isset($inbox_mail) && !empty($inbox_mail) && count($inbox_mail)>0){ ?>
                   
                <div class="col-sm-3 col-xs-4 mail_list_column col">
                     <form action="<?php echo EMAIL_URL.'delete' ?>" method="post" class="" id="forminbox">
                    <input type="hidden" name="type" value="inbox">
                    <?php foreach($inbox_mail as $key=>$value){  ?>
                  <div  class="<?php echo ($value->read==1)?'read':'unread'; ?> mail_list box_inbox"> 
                        <div class="left">  <?php
                          $value_checkbox=$value->id;
                          $data = array('class' => 'flat','name'=>'selected[]','id'=>'email_check','value'=>$value_checkbox);
                          echo form_checkbox($data);
                          ?>   
                        
                        </div>
                        <div class="right">
                        <a href="#box_inbox<?php echo $value->mail_id; ?>" data-related="box_inbox<?php echo $value->mail_id; ?>" data-id="<?php echo $value->manage_id; ?>" >
                            <h3>
                          <strong data-toggle="tooltip" title="<?php echo  $value->user_email ?>">
                               <?php

                                echo (strlen( $value->user_email)>20)?substr(( $value->user_email),0,20).'...':$value->user_email;
                                ?>                               
                          </strong>                               
                            </h3>
                        </a> 
                            <p><?php echo (strlen(strip_tags(html_entity_decode(($value->subject))))>60)?substr(strip_tags(html_entity_decode(($value->subject))),0,60).'...':strip_tags(html_entity_decode(($value->subject))); ?></p>
                             <small class="pull-right"><?php echo date('H:i A M d Y',strtotime($value->created_date)); ?></small>
                        </div>
                    
                  </div>
                    <?php   } ?>
                   </form>  
                </div>               
                 
                <!-- CONTENT MAIL -->
                <div class="col-sm-9 col-xs-8 mail_view col">
                    <?php
                        $i=0;
                        foreach($inbox_mail as $key=>$value){  ?>
                    <div class="inbox-body" id="box_inbox<?php echo $value->mail_id ?>" <?php echo ($i>0)?'style="display:none;"':''; ?>>
                    <div class="mail_heading row">
                      <div class="col-md-8">
                        <div class="sender-info">
                          <div class="row">
                            <div class="col-md-12"> 
                                <strong>From: <?php echo $value->account_holder_name ?> </strong>
                                <strong>(<?php echo $value->user_email ?> )</strong>
                                </br>
                                <strong>To: me</strong>  
                               
                                  
                            </div>                           
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4 text-right">
                        <p class="date"> <?php echo date('H:i A M d Y',strtotime($value->created_date)); ?></p>
                      </div>
                      <div class="col-md-12">
                        <h4> Subject: <?php echo $value->subject ?> </h4>
                      </div>
                    </div>
                    <div class="view-mail">
                         <?php if(isset($value->file_name) && !empty($value->file_name) ){?>                            
                            <a class="pull-right"  data-toggle="tooltip" title="<?php echo   $value->orig_name; ?>" data-placement="left" href="<?php echo EMAIL_URL.'download/'.$value->id.'/'.$value->file_name; ?>" target="_blank" alt="<?php echo  $value->orig_name ?>"><i class="fa fa-paperclip"> <?php  echo (strlen(  $value->orig_name)>20)?substr((  $value->orig_name),0,20).'...': $value->orig_name; ?></i> </a>
                            </br>
                            <hr>       
                            <?php } ?>                          
                        <?php echo html_entity_decode($value->discription) ?>                         
                   </div>                  
                        
                        <div class="compose-btn pull-left"> 
                            <a class="btn btn-sm btn-primary" href="<?php echo EMAIL_URL.'compose_mail/'.$value->id ?>" >
                                <i class="fa fa-reply"></i> Reply
                            </a>
                        </div>
                  </div>
                      <?php $i++;  } ?>                                         
                    
                  </div>     
                    <?php }else{ ?>
                    <div class="col-sm-12 col-md-offset-5">                        
                        No record found.
                    </div> 
                <?php } ?>
                </div>
                <!-- /CONTENT MAIL --> 
              </div>
            </div>
        </div>    
    <div role="tabpanel" class="tab-pane" id="sendbox">        
        <div class="x_panel">            
            <div class="x_content" style="width:100%; overflow-y:hidden; ">
              <div class="flexbox mobile_mail-overflow">
                  <?php if(isset($sent_mail) && !empty($sent_mail) && count($sent_mail)>0){  ?>
                
                <div class="col-sm-3 col-xs-4 mail_list_column col">
                       <form action="<?php echo EMAIL_URL.'delete' ?>" method="post" class="" id="formoutbox">
                    <input type="hidden" name="type" value="outbox">
                    <?php foreach($sent_mail as $key=>$value){                      
                        ?>
                  <div class="mail_list box_outbox">
                    <div class="left">
                          <?php
                          $value_checkbox=$value->id;
                          $data = array('class' => 'flat','name'=>'selected[]','id'=>'email_check','value'=>$value_checkbox);
                          echo form_checkbox($data);
                          ?>                     
                    </div>
                    <div class="right">
                        <a href="#box_outbox<?php echo $value->id ?>" data-related="box_outbox<?php echo $value->id ?>">
                             
                                
                      <h3>
                           <?php 
                                $toshow="";
                                if(!empty($value->msg_send_to)){
                                $toshow= $value->msg_send_to;
                            ?>
                        <?php }elseif(is_string($value->user_details)){
                                $toshow= $value->user_details;
                            ?>                                                                                               
                        <?php }else{
                                    foreach ($value->user_details as $userinde=>$userdetial){
                                            $toshow.=$userdetial->user_email.',';
                                                                                               
                                     }                                 
                                $toshow=rtrim($toshow,',');
                                }
                                ?>
                          <strong data-toggle="tooltip" title="<?php echo $toshow ?>">
                               <?php
                                echo (strlen($toshow)>20)?substr(($toshow),0,20).'...':$toshow;
                                ?>                               
                          </strong>                                                         
                      </h3>                      
                        </a>
                        <p><?php echo (strlen(strip_tags(html_entity_decode(($value->subject))))>60)?substr(strip_tags(html_entity_decode(($value->subject))),0,60).'...':strip_tags(html_entity_decode(($value->subject))); ?></p>
                         <small class="pull-right"><?php echo date('H:i A M d Y',strtotime($value->created_date)); ?></small>
                    </div>
                  </div>
                       
                    <?php } ?>   
                      </form>
                </div>
                 
                <!-- /MAIL LIST -->                 
                <!-- CONTENT MAIL -->
                <div class="col-sm-9 col-xs-8 mail_view col">                  
                        <?php
                        $i=0;
                        foreach($sent_mail as $key=>$value){ ?>
                    <div class="outbox_body" id="box_outbox<?php echo $value->id ?>" <?php echo ($i>0)?'style="display:none;"':''; ?>>
                    <div class="mail_heading row">
                      <div class="col-md-8">
                        <div class="sender-info">
                          <div class="row">
                            <div class="col-md-12"> <strong>From: me</strong> 
                                </br>
                                <?php if(!empty($value->msg_send_to)){ ?>
                                    <strong>To: <?php echo  $value->msg_send_to; ?></strong>
                                <?php }elseif(is_string($value->user_details)){ ?>                              
                                <strong>(<?php  echo $value->user_details ?> )</strong>                                 
                                <?php }else{
                                foreach ($value->user_details as $userinde=>$userdetial){
                                    ?>
                                <strong><?php echo $userdetial->account_holder_name ?> </strong>
                                <strong>(<?php  echo $userdetial->user_email ?> )</strong> 
                                
                                <?php } }  ?>     
                                
                            </div>                             
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4 text-right">
                        <p class="date"><?php echo date('H:i A M d Y',strtotime($value->created_date)); ?> </p>
                      </div>
                      <div class="col-md-12">
                        <h4> Subject: <?php echo $value->subject ?>
                        
                        </h4>
                      </div>
                    </div>
                    <div class="view-mail">
                         <?php if(isset($value->file_name) && !empty($value->file_name) ){?>    
                        
                        <a class="pull-right"  data-toggle="tooltip" title="<?php echo   $value->orig_name; ?>" data-placement="left" href="<?php echo EMAIL_URL.'download/'.$value->id.'/'.$value->file_name; ?>" target="_blank" alt="<?php echo  $value->orig_name ?>"><i class="fa fa-paperclip"> <?php  echo (strlen(  $value->orig_name)>20)?substr((  $value->orig_name),0,20).'...': $value->orig_name; ?></i> </a>
                        </br>
                        <hr>       
                        <?php } ?>  
                        <?php echo html_entity_decode($value->discription) ?> 
                       
                   </div>                    
                  </div>
                      <?php $i++;  } ?>
                </div>
                <?php }else{ ?>
                                        <div class="col-sm-12 col-md-offset-5">                        
                        No record found.
                    </div> 

                <?php } ?>
                <!-- /CONTENT MAIL --> 
              </div>
            </div>
        </div>        
    </div>
  </div>
</div>
<script type="text/javascript">
$('.box_inbox a').on( "click", function(e) {
    e.preventDefault();
    var $this=$(this);
    var id = $(this).attr('data-related'); 
    var manage_id = $(this).attr('data-id');         
    $(".inbox-body").each(function(){
        $(this).hide();
        if($(this).attr('id') == id) {
            $(this).show();
        }
    });
var unread=$this.parents('.unread');
if (unread.length) {
//    $.ajax({
//      type: 'POST',
//      url: "<?php // echo EMAIL_URL ?>read_status",
//      data: {
//                sid: sender_id,
//                id: id
//            },
//      dataType: "json",
//      success: function(resultData) { alert("Save Complete") }
//    });
//saveData.error(function() { alert("Something went wrong"); });
//
//        alert("<?php // echo EMAIL_URL ?>read_status");
        $.ajax({
            url: "<?php echo EMAIL_URL ?>read_status",
            data: {
                id: manage_id
            },
            type: "post",
            dataType : "json"
        })
        .done(function( json ) {
            if(json=='1'){
                unread.removeClass('unread');
                unread.addClass('read');
                $this.find('i').removeClass('fa-circle');
                $this.find('i').addClass('fa-circle-o');
                var notity_count=$("#mail_count").text();
                if(notity_count!=""){
                    if(parseInt(notity_count)-1==0){
                        $("#mail_count").text('');    
                    }else{
                        $("#mail_count").text(parseInt(notity_count)-1);    
                    }                    
                }
                $("#notify"+manage_id).remove();
            }
        })
//        .fail(function( xhr, status, errorThrown ) {
//            alert( "Sorry, there was a problem!" );
//            console.log( "Error: " + errorThrown );
//            console.log( "Status: " + status );
//            console.dir( xhr );
//        })
//        .always(function( xhr, status ) {
//            alert( "The request is complete!" );
//        });
//        alert("adfs");
    }
});  
$('.box_outbox a').on( "click", function(e) {
    e.preventDefault();
    var id = $(this).attr('data-related'); 
    $(".outbox_body").each(function(){
        $(this).hide();
        if($(this).attr('id') == id) {
            $(this).show();
        }
    });
});  

$("#deletemail").on("click",function(){
    if($("input:checkbox:checked").length){       
        var $tab = $('#tabscontent'), $active = $tab.find('.tab-pane.active');        
        bootbox.confirm({
            buttons: {
                confirm: {
                    label: 'Yes, please'
                            //className: 'confirm-button-class'
                },
                cancel: {
                    label: 'No, thanks'
                            //className: 'cancel-button-class'
                }
            },
            message: 'Do you really want to remove this message permanently ?',
            callback: function (result) {
                if (result == true) {
                    if($active[0].id=='inbox'){   
                        if($('#forminbox')){
                            $('#forminbox').submit();
                        }else{
                            return false;
                        }
                    }else if($active[0].id=='sendbox'){
                        if($('#formoutbox')){
                            $('#formoutbox').submit();
                        }else{
                            return false;
                        }
                    }else{
                        return false;
                    }  
                }
            },
            title: 'Delete Message'
        });                        
    }else{
        alert("Please select mail to delete.");
    }
    return false;
});
$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {  
  $('input[name*=\'selected\']').attr('checked', false);
});
       
</script>
