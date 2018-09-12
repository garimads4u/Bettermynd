<script>
    $(document).ready(function () {
        $("#dob.datetimepicker").datetimepicker({
            format: 'MM/DD/YYYY',
            maxDate: 'now',
        });
    })
</script>
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

            $attributes = array('id' => 'updatePatientProfile', 'class' => 'update-form form-horizontal', 'enctype' => 'multipart/form-data');

            echo form_open(SADMIN_URL . "manage_admin_profile", $attributes);
            ?>
            <?php echo form_input($user_type); ?>
            <?php echo form_input($user_id); ?>

            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="exampleInputEmail1">First Name <span class="mandatory">*</span></label>
                        <?php echo form_input($first_name); ?>

                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Last Name <span class="mandatory">*</span></label>
                        <?php echo form_input($last_name); ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email Address <span class="mandatory">*</span></label>
                        <?php echo form_input($email); ?>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="exampleInputPassword1">Date Of Birth <span class="mandatory">*</span></label>

                        <div id="dob" class='input-group date datetimepicker' style=" margin-bottom:0">
                            <?php echo form_input($dob); ?>
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Mobile Number <span class="mandatory">*</span></label>
                        <?php echo form_input($mobile_no); ?>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="exampleInputGender">Gender <span class="mandatory">*</span></label>
                        <?php
                        $gender = array("" => 'Select Gender', "m" => "Male", "f" => "Female");
                        $options = $gender;
                        $selected = $gender_selected;
                        $attr = 'class="form-control"';
                        echo form_dropdown('gender', $options, $selected, $attr);
                        ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="exampleInputEthnicity">Ethnicity <span class="mandatory">*</span></label>
                        <?php
                        $options = $ethnicity_list;
                        $selected = $ethnicity_list_selected;
                        $attr = 'class="form-control"';
                        echo form_dropdown('ethnicity', $options, $selected, $attr);
                        ?>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="exampleInputInsuranceCarriers">TimeZone <span class="mandatory">*</span></label>
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
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="exampleInputAddress">Campus Address <span class="mandatory">*</span></label>
                        <?php echo form_input($address); ?>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="exampleInputCity">City <span class="mandatory">*</span></label>
                        <?php echo form_input($city); ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="exampleInputState">State <span class="mandatory">*</span></label>
                        <div class="form-group">
                            <?php
                            $options = $states;
                            $selected = $state_selected;
                            $attr = 'class="chosen-select form-control"';
                            echo form_dropdown('state', $options, $selected, $attr);
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="exampleInputZipcode">Zipcode <span class="mandatory">*</span></label>
                        <?php echo form_input($zipcode); ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="exampleInputImage">Upload Profile Image </label>
                        <div class="input-group profileimageDiv">
                            <input name="profile_image_txt"  class="form-control valid noneditable" placeholder="Upload Profile Image" aria-invalid="false" type="text">
                            <span class="input-group-btn">
                                <span class="btn btn-primary btn-file"> Browse <!--<input name="profile_photo" accept="image/*" id="profile_photo" type="file">-->
                                    <input type="file" name="profile_image" accept="image/x-png,image/gif,image/jpeg" id="profile_image" />
                                </span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="clearfix"></div>
                <div class="register-buttons">
                    <?php echo form_submit('submit', lang('update_user_submit_btn'), array("class" => "btn btn-primary", "id" => "signup_btn")); ?>
                    <?php echo "<a href='" . PATIENT_URL . "dashboard' class='btn btn-default'> Cancel </a>"; ?>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>