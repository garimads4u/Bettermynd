<h1><?php echo lang('create_user_heading'); ?></h1>
<p class="login_headline">
    <?php
    
    if ($reg_type == "company") {
        echo lang('create_company_subheading');
    } elseif($reg_type == "affiliate") {
        echo lang('create_affiliate_subheading');
    }
    else {
        echo lang('create_user_subheading');
    }
    ?>
</p>
<div id="infoMessage"><?php echo $error; ?></div>
<?php
$attributes = array('id' => 'signupform', 'class' => 'regration-form form-horizontal');
echo form_open(SITE_URL . "affiliatereg", $attributes);
?>
<div class="row">
    <div class="col-sm-6">
        <?php
        if ($identity_column !== 'email') {
            echo ' <div class="form-group"> ';
            echo lang('create_user_identity_label', 'identity') . ' <span class="mandatory">*</span>';
            echo form_error('identity');
            echo form_input($identity);
            echo "<span id='user-availability-status'></span> "
            . " <p class='lbl-msg'>Your unique username to login.</p>";
            echo '</div>';
        }
        ?>
    </div>
    <div class="col-sm-6 hidden-xs">&nbsp;</div>
</div>
<div class="row">
    <div class="col-sm-6">
        <div class="form-group"> <?php echo lang('create_user_password_label', 'password'); ?> <span class="mandatory">*</span> <?php echo form_input($password); ?> <?php echo form_input($user_type); ?> </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group"> <?php echo lang('create_user_password_confirm_label', 'password_confirm'); ?> <span class="mandatory">*</span> <?php echo form_input($password_confirm); ?> </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group"> <?php echo lang('create_user_email_label', 'email'); ?> <span class="mandatory">*</span> <?php echo form_input($email); ?> </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group"> <?php echo lang('create_user_confirm_email_label', 'email'); ?> <span class="mandatory">*</span> <?php echo form_input($confirm_email); ?> </div>
    </div>

</div>

<div class="register-buttons"> <?php echo form_submit('submit', lang('create_user_submit_btn'), array("class" => "btn btn-primary", "id" => "signup_btn")); ?> <a href="<?php echo SITE_URL; ?>" class="to_register btn btn-default"> Login </a> <img src="<?php echo IMAGES_URL . "ssl_logo.png"; ?>" class="ssl"> </div>
<?php echo form_close(); ?>
