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
            $attributes = array('id' => 'providerprofile_edit', 'class' => 'regration-form form-horizontal', "enctype" => "multipart/form-data");

            echo form_open(COLLEGE_URL . "provider_update", $attributes);
            ?>

            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="exampleInputFirstName">Provider First Name <span class="mandatory">*</span></label>
                        <?php echo form_input($first_name); ?>
                        <?php echo form_input($edit_id); ?>

                    </div></div>
                <div class="col-sm-6"><div class="form-group">
                        <label for="exampleInputLastName">Provider Last Name <span class="mandatory">*</span></label>
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
                <div class="col-sm-6 hide">
                    <div class="form-group">
                        <label for="exampleInputCollegeName">College Name <span class="mandatory">*</span></label>
                        <?php
                        $options = $college;
                        $selected = $college_id_selected;
                        $attr = 'class="form-control"';
                        echo form_dropdown('college_id', $options, $selected, $attr);
                        ?>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="exampleInputPhone">Office Phone Number <span class="mandatory">*</span></label>
                        <?php echo form_input($mobile_no); ?>
                    </div>
                </div>
            </div>
            <div class="row">

                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="exampleInputSpecialties">Counseling Specialties <span class="mandatory">*</span></label>
                        <?php
                        if (isset($_SESSION['postdata']['specialities']) && !empty($_SESSION['postdata']['specialities'])) {
                            $speciality_selected = $_SESSION['postdata']['specialities'];
                        } else {
                            $speciality_selected = $speciality_selected;
                        }
                        $options = $speciality;
                        $selected = $speciality_selected;
                        $attr = 'class="form-control chosen-select" multiple="multiple"';
                        echo form_dropdown('specialities[]', $options, $selected, $attr);
                        ?>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="exampleInputCost">Average rate per 45 minute session ($) <span class="mandatory">*</span></label>
                        <?php echo form_input($session_cost); ?>
                    </div>
                </div>
            </div>
            <div class="row">

                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="exampleInputBiography">Biography (Max Limit: 500)<span class="mandatory">*</span></label>
                        <?php echo form_textarea($biography); ?>
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
                        <label for="exampleInputImage">Upload Profile Image </label>
                        <div class="input-group profileimageDiv">
                            <input name="profile_image_txt"  class="form-control valid noneditable" placeholder="Browse" aria-invalid="false" type="text">
                            <span class="input-group-btn">
                                <span class="btn btn-primary btn-file"> Upload <!--<input name="profile_photo" accept="image/*" id="profile_photo" type="file">-->
                                    <input type="file" name="profile_image" accept="image/x-png,image/gif,image/jpeg" id="profile_image" />
                                </span>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="clearfix"></div>
                <div class="register-buttons">
                    <?php echo form_submit('submit', lang('update_user_submit_btn'), array("class" => "btn btn-primary", "id" => "signup_btn")); ?>
                    <?php echo "<a href='" . COLLEGE_URL . "provider' class='btn btn-default'> Cancel </a>"; ?>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>