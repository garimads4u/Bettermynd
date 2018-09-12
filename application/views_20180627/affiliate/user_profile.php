<div class="col-md-10 col-sm-11 col-xs-12">
    <h2 class="page-heading"><?php echo $heading; ?></h2>
    <div id="infoMessage"><?php if (isset($message)) {
   ?><p class="alert alert-success text-left"><?php
            echo $message;
            ?></p><?php }
        ?></div>
    <div id="infoMessage">
        <?php if (isset($error)) {
            ?><p class="alert alert-danger text-left"><?php
            echo $error;
            ?></p><?php }
        ?>
    </div>
    <div class="x_panel">
        <div class="x_content">
            <?php
            $attributes = array('id' => 'profile_frm', 'class' => 'myprofile form-horizontal', 'enctype' => 'multipart/form-data');
            echo form_open(AFFILIATE_URL . "update_profile", $attributes);
            ?>
            <?php echo form_input($action); ?>


            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <?php echo lang('edit_user_identity_label', 'username'); ?><p class="lbl-msg">Your unique username to login.</p>
                        <?php echo form_input($username); ?>

                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <?php echo lang('affiliate_profile_paypal_email_label', 'paypal_email'); ?> <span class="mandatory">*</span>
                        <?php echo form_input($paypal_email); ?>

                    </div>
                </div>
                <div class="col-sm-3">

                    <?php echo form_input($user_id); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <?php echo lang('edit_company_profile_full_name_label', 'account_holder_name'); ?> <span class="mandatory">*</span>
                        <?php echo form_input($account_holder_name); ?>

                    </div>
                </div>
                <div class="col-sm-6">
                    <?php echo lang('edit_user_email_label', 'user_email'); ?>  <span class="mandatory">*</span>
                    <?php echo form_input($user_email); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <?php echo lang('edit_user_office_number_label', 'office_phone'); ?>
                        <?php echo form_input($office_phone); ?>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <?php echo lang('edit_user_phone_label', 'mobile_phone'); ?> <span class="mandatory">*</span>
                        <?php echo form_input($mobile_phone); ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <?php echo lang('edit_user_address_label', 'address'); ?>
                        <?php echo form_input($address); ?>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <?php echo lang('edit_user_state_label', 'state'); ?>
                                <?php
                                $options = $states;
                                $selected = $state;
                                $attr = 'class="form-control chosen-select"';
                                echo form_dropdown('state', $options, $selected, $attr);
                                ?>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <?php echo lang('edit_user_zipcode_label', 'zipcode'); ?> <span class="mandatory">*</span>
                                <?php echo form_input($zipcode); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 hide">
                    <div class="form-group">
                        <?php echo lang('edit_user_website_label', 'website'); ?>
                        <?php echo form_input($website); ?>
                    </div>
                </div>
                <div class="col-sm-6 hide">
                    <div class="form-group">
                        <?php echo lang('edit_user_fax_number_label', 'fax_number'); ?>
                        <?php echo form_input($fax_number); ?>
                    </div>
                </div>
                <div class="col-sm-12 hide">
                    <div class="form-group">
                        <label for="bio">Bio (<span id='charCount'>500</span> characters)</label>
                        <?php
                        $attribute = array(
                            'name' => 'biography',
                            'id' => 'biography',
                            'maxlength' => '500',
                            'rows' => '4',
                            'value' => $biography,
                            'class' => 'form-control'
                        );

                        echo form_textarea($attribute);
                        ?>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <?php echo lang('edit_user_profile_pic_label', 'profile_photo2'); ?>
                        <div class="input-group">
                            <?php echo form_input($profilepic); ?>
                            <span class="input-group-btn">
                                <span class="btn btn-primary btn-file">
                                    Upload <?php
                                    $attribute = array(
                                        'type' => 'file',
                                        'accept' => 'image/*',
                                        'name' => 'profile_photo',
                                        'id' => 'profile_photo'
                                    );
                                    echo form_upload($attribute);
                                    ?>
                                </span>
                            </span>

                        </div>
                    </div>
                </div>
               
            </div>
            <div class="row hide">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="facebook">Social Media</label>
                        <?php echo form_input($fb_url); ?>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="twitter" class="hidden-xs">&nbsp;</label>
                        <?php echo form_input($twitter_url); ?>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <?php echo form_input($linkedin_url); ?>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <?php echo form_input($youtube_url); ?>
                    </div>
                </div>
            </div>
            <div class="register-buttons">
                <?php echo form_submit('submit', lang('edit_user_submit_btn'), array("class" => "btn btn-primary")); ?>
                <?php
                if ($cancel_btn) {
                    echo "<a href='" . SADMIN_URL . "company' class='btn btn-default'> Cancel </a>";
                } else {
                    echo "<a href='" . SADMIN_URL . "dashboard' class='btn btn-default'> Cancel </a>";
                }
                ?>

            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>

<script>
    $('#profile_frm').submit(function () {
        $("#user_email").prop('disabled', false);
        //Rest of code
    })
</script>
