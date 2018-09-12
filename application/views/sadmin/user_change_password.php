<div id="infoMessage">
    <?php
    if (isset($message) && !empty($message)) {
        echo "<p class='alert alert-success text-left'>" . $message . "</p>";
    }

    if (isset($error) && !empty($error)) {
        echo "<p class='alert alert-danger text-left'>" . $error . "</p>";
    }
    ?>
</div>
<div class="x_panel">
    <div class="x_content">
        <div class="col-md-12">
            <?php
            if (isset($is_profile_completeness) && empty($is_profile_completeness)) {
                if ($is_profile_completeness < 1) {
                    ?>
                    <div class="alert alert-info">To continue to access the application, please complete your profile.</div>
                    <?php
                }
            }

            $attributes = array('id' => 'changePasswordFrm', 'class' => 'update-form form-horizontal', 'enctype' => 'multipart/form-data');

            echo form_open(SADMIN_URL . "user_save_password", $attributes);
            ?>
            <?php echo form_input($user_id); ?>

            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="">Name</label>
                        <div class="form-control"><?php echo $user_name; ?></div>

                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="">Email <span class="mandatory">*</span></label>
                        <div class="form-control"><?php echo $user_email; ?></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="exampleInputEmail1">New Password <span class="mandatory">*</span></label>
                        <?php echo form_input($new_password); ?>

                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Confirm Password <span class="mandatory">*</span></label>
                        <?php echo form_input($new_password_confirm); ?>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="clearfix"></div>
                <div class="register-buttons">
                    <?php echo form_submit('submit', 'Change Password', array("class" => "btn btn-primary", "id" => "signup_btn")); ?>
                    <?php echo "<a href='" . $return_url . "' class='btn btn-default'> Cancel </a>"; ?>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
