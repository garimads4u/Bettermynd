<div class="col-md-6 col-md-offset-3">
 <?php if (isset($message) && !empty($message)) {
        ?><div class="alert alert-success text-left"><?php echo strip_tags($message,"br,a"); ?></div><?php 
    } 
    ?>
    <?php
    if (isset($error) && !empty($error)) {
        ?><div class="alert alert-danger text-left"><?php echo strip_tags($error,"<br>,<a>"); ?></div><?php 
    }
    ?>
        <?php
        $attributes = array('id' => 'loginform', 'class' => 'login-form form-horizontal');
        echo form_open(SITE_URL . "checklogin", $attributes);
        ?>
    <p class="font18"><strong class="black">Sign in</strong> to start your session</p><br>
    <div class="form-group">
        <?php echo lang('login_identity_label', 'identity'); ; ?>
        <?php echo form_input($identity); ?>

    </div>
    <div class="form-group">
         <?php echo lang('login_password_label', 'password'); ?>
        <?php echo form_input($password); ?>        
    </div>
    <div class="checkbox"> <div class="clearfix">

            <label class="pull-left"><?php $data = array('value' => '1','class' => 'flat', "name" => "remember", "id" => "remember"); ?>
        <?php echo form_checkbox($data); ?> <?php echo lang('login_remember_label', 'remember'); ?>
            </label>
        </div>
<!--       <p class="lbl-msg">(if this is a private computer)</p>-->
    </div>
    <div class="login_btns">
<?php echo form_submit('submit', lang('login_submit_btn'), array("class" => "btn btn-primary btn-block")); ?>
          <a href="<?php echo SITE_URL . "forgot_password"; ?>" class="pull-right  forgot_pass">Forgot your password ?</a><br>
          <a href="<?php echo SITE_URL . "signup/patient"; ?>" class="pull-right  forgot_pass">Not registered yet ?</a>
    </div></div>
<?php echo form_close(); ?>

