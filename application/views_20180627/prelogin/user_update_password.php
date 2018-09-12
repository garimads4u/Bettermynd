<h1 ><?php echo lang('reset_password_heading');?></h1>
<div id="infoMessage"><?php echo $message;?></div>
<div id="infoMessage"><?php echo $error;?></div>
<?php
$attributes = array('id' => 'reset_form', 'class' => 'login-form form-horizontal');
 echo form_open(SITE_URL."update_user_password/" . $code,$attributes);?>
    
 <div class="form-group">
 <?php echo (lang('reset_password_new_password_label',"new_password"));?>
    <?php echo form_input($new_password);?>
    
  </div>
  <div class="form-group">
 <?php echo lang('reset_password_new_password_confirm_label', 'new_password_confirm');?>
    <?php echo form_input($new_password_confirm);?>
    
  </div>
<?php /*?><p>Please enter your<strong> Registered Email Address.</strong> Brandize will send you a link to reset your password.</p>
 <?php */?>
  
 <div class="login_btns">
 <?php echo form_submit('submit', lang('reset_password_submit_btn'),array("class"=>"btn btn-primary btn-block"));?>
 
  <a href="<?php echo SITE_URL . 'login';?>" class="to_register btn  btn-block btn-default"> Back to login </a>
  </div>
  <?php echo form_input($user_id);?>
	<?php echo form_hidden($csrf); ?>
 <?php echo form_close();?>

