<script type="text/javascript">
    $(document).ready(function (e) {
        var default_date = moment(new Date(<?php echo date('Y') - 17; ?>, <?php echo date('m') - 1; ?>, <?php echo date('d'); ?>));
        $("#dob_datetimepicker").datetimepicker({
            //useCurrent: false,
            defaultDate: default_date,
            maxDate: moment(),
            format: 'MM/DD/YYYY',
            //minDate: '1900-01-01',
        });
        $("#dob_datetimepicker").on("dp.change", function (e) {
            var decrementYear = moment(new Date(e.date));
            decrementYear.add(17, 'Years');
            if (moment(new Date()) < decrementYear) {
                $('#dob_datetimepicker').data('DateTimePicker').date(default_date);
                $(this).data("DateTimePicker").hide();
                $('#dob').val('');
                bootbox.alert({
                    message: "We’re sorry, but BetterMynd is unable to process your registration at this time. If you have questions or concerns, please email us at <a href='mailto:support@bettermynd.com'>support@bettermynd.com</a>.",
                    title: "<span class='error'>Error</span>",
                    size: 'midium'
                });

            }
        });

        //$('#dob').val('');

    });
</script>
<div id="infoMessage">
    <?php
    if (isset($message) && !empty($message)) {
        echo "<p class='alert alert-success text-left'>" . $message . "</p>";
    }

    if (isset($error) && !empty($error)) {
        //echo "<p class='alert alert-danger text-left'>" . $error . "</p>";
        echo $error;
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
                    <div class="alert alert-info static_alrt_sh">Please complete your profile before continuing. Note that all of your personal information is private and secure and will not be shared with your college or any other outside parties.</div>
                    <?php
                }
            } elseif ($is_disabled == 0) {
                ?>
                <div class="alert alert-danger static_alrt_sh">This account is temporary disabled, Please enable it for further process.</div>
                <?php
            }

            $attributes = array('id' => 'updatePatientProfile', 'class' => 'update-form form-horizontal', 'enctype' => 'multipart/form-data');

            echo form_open(PATIENT_URL . "manage_patient_profile", $attributes);
            ?>
            <?php echo form_input($user_type); ?>
            <?php echo form_input($user_id); ?>

            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Student First Name <span class="mandatory">*</span></label>
                        <?php echo form_input($first_name); ?>

                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Student Last Name <span class="mandatory">*</span></label>
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
                        <label for="exampleInputEmail1">College Name <span class="mandatory">*</span></label>
                        <?php
                        $options = $college;
                        $selected = $college_selected;
                        $attr = 'class="form-control" disabled="disabled"';
                        echo form_dropdown('college_id', $options, $selected, $attr);
                        ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Student College ID <span class="mandatory">*</span></label>
                        <?php echo form_input($patient_identification_number); ?>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="exampleInputPassword1">Date Of Birth <span class="mandatory">*</span></label>

                        <div class='input-group date datetimepicker' style=" margin-bottom:0" id="dob_datetimepicker">
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
                        $gender = array("" => 'Select Gender', "m" => "Male", "f" => "Female", "t" => "Other/Non-Conforming");
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
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="exampleInputCity">City <span class="mandatory">*</span></label>
                        <?php echo form_input($city); ?>
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
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="exampleInputZipcode">Are you an international student? <span class="mandatory">*</span></label>
                        <?php
                        $options = $this->config->item('YesNo');
                        $selected = $is_international_selected;
                        $attr = 'class="form-control"';
                        echo form_dropdown('is_international', $options, $selected, $attr);
                        ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="exampleInputZipcode">Are you a student athlete? <span class="mandatory">*</span></label>
                        <?php
                        $options = $this->config->item('YesNo');
                        $selected = $athlete_selected;
                        $attr = 'class="form-control"';
                        echo form_dropdown('athlete', $options, $selected, $attr);
                        ?>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="exampleInputZipcode">Class Year <span class="mandatory">*</span></label>
                        <?php
                        $options = year_dropdown(10);
                        $selected = $class_year_selected;
                        $attr = 'class="form-control"';
                        echo form_dropdown('class_year', $options, $selected, $attr);
                        ?>
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