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
            } elseif ($is_disabled == 0) {
                ?>
                <div class="alert alert-danger static_alrt_sh">This account is temporary disabled, Please enable it for further process.</div>
                <?php
            }
            $attributes = array('id' => 'collegeupdateform', 'class' => 'update-form form-horizontal', "enctype" => "multipart/form-data");

            echo form_open(COLLEGE_URL . "manage_patient_profile", $attributes);
            ?>

            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="exampleInputFirstName">First Name <span class="mandatory">*</span></label>
                        <?php echo form_input($first_name); ?>
                        <?php echo form_input($user_type); ?>
                        <?php echo form_input($user_id); ?>
                        <?php echo form_input($college_id); ?>
                    </div>
                </div>
                <div class="col-sm-6"><div class="form-group">
                        <label for="exampleInputLastName">Last Name <span class="mandatory">*</span></label>
                        <?php echo form_input($last_name); ?>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email Address <span class="mandatory">*</span></label>
                        <?php echo form_input($user_email); ?>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="exampleInputPassword1">College Name <span class="mandatory">*</span></label>
                        <?php echo form_input($college_name); ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="exampleInputPassword1">College Address <span class="mandatory">*</span></label>
                        <?php echo form_input($college_address); ?>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="exampleInputPassword1">College State <span class="mandatory">*</span></label>
                        <?php
                        if (isset($edit_data) && !empty($edit_data)) {
                            $selected = array($edit_data[0]->college_state);
                        } else if (isset($states_selected) && !empty($states_selected)) {
                            $selected = $states_selected;
                        } else {
                            $selected = '';
                        }
                        ?>
                        <?php echo form_dropdown("college_state", $states, $selected, "class='form-control chosen'"); ?>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="exampleInputPassword1">College City <span class="mandatory">*</span></label>
                        <?php echo form_input($college_city); ?>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="exampleInputPassword1">College Zipcode <span class="mandatory">*</span></label>
                        <?php echo form_input($college_zipcode); ?>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="exampleInputPassword1">Office Phone No. <span class="mandatory">*</span></label>
                        <?php echo form_input($college_office_no); ?>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="exampleInputImage">Upload Profile Image </label>
                        <div class="input-group profileimageDiv">
                            <input name="profile_image_txt"  class="form-control valid noneditable" placeholder="Browse" aria-invalid="false" type="text">
                            <span class="input-group-btn">
                                <span class="btn btn-primary btn-file"> Browse <!--<input name="profile_photo" accept="image/*" id="profile_photo" type="file">-->
                                    <input type="file" accept="image/x-png,image/gif,image/jpeg" name="profile_image" id="profile_image" />
                                </span>
                            </span>
                        </div>

                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="exampleInputTimezone">TimeZone <span class="mandatory">*</span></label>
                        <?php
                        $options = $timezone_list;
                        $selected = $timezone_list_selected;
                        $attr = 'class="chosen-select form-control"';
                        echo form_dropdown('timezone', $options, $selected, $attr);
                        ?>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="clearfix"></div>
                <div class="register-buttons">
                    <?php echo form_submit('submit', lang('update_user_submit_btn'), array("class" => "btn btn-primary", "id" => "signup_btn")); ?>
                    <?php echo "<a href='" . COLLEGE_URL . "dashboard' class='btn btn-default'> Cancel </a>"; ?>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>