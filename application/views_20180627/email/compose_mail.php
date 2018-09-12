<style type="text/css">
#editor{
	width:100% !important;
	height:100% !important;	
}
</style>
<div class="col-md-12 col-sm-12 col-xs-12">
    <div id="infoMessage"><?php
        if(isset($message) && strlen($message)>0 ) { 
            $message1=str_replace(" ","",$message);
            if(strlen($message1)>0){
            echo $message; 
            ?><?php
            }
        } ?>
            <?php if(isset($error)  && strlen($error)>0) { 
                ?><?php
            echo $error; 
            ?><?php
        } ?>
    </div>
<div class="x_panel">
            <div class="x_title">
              <h2><a href="<?php echo  EMAIL_URL ?>inbox" class="btn btn-default">Back to Inbox</a></h2>
<!--              <a href="mail_compose.html" class="btn btn-primary pull-right">Compose New Mail</a>-->
              <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form action="<?php echo EMAIL_URL . "send_mail";?>" method="post" class="form-horizontal form-label-left mail-compose" name="composeMail"  id="composeMail" enctype="multipart/form-data" >
                    <input type="hidden" name="edit_id" value="<?php echo (isset($reply_user) && !empty($reply_user))?$reply_user->user_id:'0' ?>" >
                    <input type="hidden" name="mail_id" value="<?php echo (isset($reply_user) && !empty($reply_user))?$reply_user->id:'0' ?>" >
                <!-- To Field -->
                <div class="row">                 
                <div class="form-group clearfix">
                    <div class="col-lg-2 col-md-2 col-sm-12">
                        <label class="control-label email" for="User">To:</label>
                     </div>
                    <div class="col-lg-10 col-md-10 col-sm-12"  id="chosen-select-mail" >
                      <?php if(isset($reply_user->id) && $reply_user->id!='') {
                          //
                      }else {?>    
                        <input type="text" id="test" placeholder='Select Users' class="form-control" />
                      <?php }?>         
                             <?php     
                             if(isset($reply_user) && !empty($reply_user)){
                                 echo $reply_user->user_email;
                             }else{

                                    $options =$users;
                                    $selected = $selected;
                                    $attr = 'id="chosen_mail" style="display:none;" class=" form-control chosen-select-mail "    data-placeholder="Select Users" multiple="multiple"';
                                    echo form_dropdown('users[]',$users,$selected,$attr);                                 
                             }
                            ?>    
                    </div>
                </div>
                  <!-- Subject Field -->
                  <div class="form-group clearfix">
                    <div class="col-lg-2 col-md-2 col-sm-12">
                      <label for="subject" class="control-label">Subject:</label>
                    </div>
                    <div class="col-lg-10 col-md-10 col-sm-12">
                            <?php echo form_input($subject); ?>
<!--                      <input type="text" name="subject" class="form-control" id="subject" placeholder="Your subject...">-->
                    </div>
                  </div>
                  <div class="form-group clearfix">
                    <div class="col-lg-2 col-md-2 col-sm-12">
                      <label for="subject" class="control-label">Attachment:</label>
                    </div>
                      <div class="col-sm-6">
                         
                            <div class="input-group">
                                <?php echo form_input($file_name); ?>
                                <span class="input-group-btn">
                                    <span class="btn btn-primary btn-file">
                                        Upload <?php                                        
                                        echo form_upload($file);?>
                                    </span>
                                </span>

                            </div>
                    </div>
                  </div>
                          <link href="<?php echo RTF_EDITOR;?>summernote.css" rel="stylesheet"  type="text/css">
			<script src="<?php echo RTF_EDITOR;?>summernote.js" type="text/javascript"></script>
                    <div class="form-group">
                    <div class="col-lg-2 col-md-2 col-sm-12">
                      <label for="messsage">Message:</label>
                    </div>
                    <div class="col-lg-10 col-md-10 col-sm-12">
                     <?php echo form_textarea($editor);?>            
                    </div>                       
  <script type="text/javascript">
  
		  $('#messsage').summernote({height:300});
		  </script>                                  
                    </div>
                  
                  <div class="col-lg-12 col-md-12 col-sm-12 text-right">
                      <button class="btn btn-primary last" type="submit" id="submit_mail"><i class="fa fa-paper-plane"></i> Send</button>
                  </div>
                </div>
              </form>
              <!-- /MAIL LIST --> 
              
            </div>
          </div>
</div>
<script>   
$("#chosen_mail").on("chosen:ready",function(){
  $("#test").remove();
});
</script>

