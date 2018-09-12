<h1 ><?php echo lang('set_password_heading');?></h1>
<?php /*?><div id="infoMessage"><?php echo $message;?></div>
<div id="infoMessage"><?php echo $error;?></div>
<?php */?>  

  <div class="col-sm-6 col-xs-12 col-sm-offset-3">
  <?php
$attributes = array('id' => 'reset_form', 'class' => 'login-form form-horizontal');
 echo form_open(SITE_URL."update_password",$attributes);
 ?>
    
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
 <?php echo form_submit('submit', lang('save_submit_btn'),array("class"=>"btn btn-primary btn-block"));?>
 
  <a href="<?php echo SITE_URL . 'login';?>" class="to_register"> Back to login </a>
  </div></div>
  <?php echo form_input($code);?>
	<?php echo form_input($uuid); ?>
 <?php echo form_close();?>

