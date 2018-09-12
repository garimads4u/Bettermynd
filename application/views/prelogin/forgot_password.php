    <div class="col-md-6 col-md-offset-3">
   <?php if(isset($message) && strlen($message)>0 ) { 
	$message1=str_replace(" ","",$message);
	if(strlen($message1)>0){
        ?><p class="alert alert-success text-left"><?php
        echo ($message); 
        ?></p><?php
	}
    } ?>
        <?php if(isset($error)  && strlen($error)>0) { 
            ?><p class="alert alert-danger text-left"><?php
        echo strip_tags($error); 
         ?></p><?php
    } ?>
   
   <?php
$attributes = array('id' => 'forgotform', 'class' => 'login-form form-horizontal');
 echo form_open(SITE_URL."change_password",$attributes);?>
 <p class="font18"><strong class="black">Forgot Password?</strong></p><br>
   <p class="font18">Enter your email address that you used to register. We'll send you an email with your username and a link to reset your password.</p>
 
    
 <div class="form-group">
  <?php echo lang('forgot_password_email_label', 'identity');?>
    <?php echo form_input($identity);?>
    
  </div>

 
  
 <div class="login_btns">
  <?php echo form_submit('submit', lang('forgot_password_submit_btn'),array("class"=>"btn btn-primary btn-block"));?>
  <a href="<?php echo SITE_URL . 'login';?>" class="to_register"> Back to login </a>
  </div></div>
 <?php echo form_close();?>

<?php /*?><script>
// just for the demos, avoids form submit
jQuery.validator.setDefaults({
  debug: true,
  success: "valid"
});
$( "#forgotform" ).validate({
  rules: {
    email: {
      required: true,
     	email:true
    }
  }
});
</script><?php */?>