<div class="col-md-12 col-sm-12 col-xs-12">
    <div id="infoMessage">
        <?php
        if (isset($message)) {
            if (strpos($message, 'alert-success') !== false) {
                echo $message;
            } else {
                ?>
                <p class="alert alert-success text-left">
                    <?php echo $message; ?>
                </p>
                <?php
            }
        }
        ?>

        <?php
        if (isset($error)) {
            if (strpos($error, 'alert-danger') !== false) {
                echo $error;
            } else {
                ?>
                <p class="alert alert-danger text-left">
                    <?php echo $error; ?>
                </p>
                <?php
            }
        }
        ?>
    </div>
    <div  class="x_panel">
        <div class="x_content">
            <?php
            $attributes = array('id' => 'college_form', 'class' => 'myprofile form-horizontal', 'enctype' => 'multipart/form-data');
            echo form_open(SADMIN_URL . "college", $attributes);


            if (isset($edit_id) && !empty($edit_id)) {
                echo form_input($edit_id);
            } else {
                ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="pull-right"> <a href="#" class="btn btn-primary" id="addcollegebutton"><i class="fa fa-plus"></i> Add College</a> </div>
                    </div>
                </div>
            <?php } ?>


            <div class="row  <?php if (isset($edit_data) && !empty($edit_data)) { ?> <?php } else { ?> hide <?php } ?>" id="add_form_div">
                <hr/>
                <div class="clearfix"></div>
                <div class="col-sm-6 ">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email Address <span class="mandatory">*</span></label>
                        <?php echo form_input($user_email); ?>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="exampleInputEmail1">First Name <span class="mandatory">*</span></label>
                        <?php echo form_input($first_name); ?>

                    </div>
                </div>
                <div class="col-sm-6"><div class="form-group">
                        <label for="exampleInputEmail1">Last Name <span class="mandatory">*</span></label>
                        <?php echo form_input($last_name); ?>

                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="exampleInputPassword1">College Name <span class="mandatory">*</span></label>
                        <?php echo form_input($college_name); ?>
                    </div>
                </div>
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
                        } else {
                            $selected = '';
                        }
                        ?>
                        <?php echo form_dropdown("college_state", $states, $selected, "class='form-control chosen'"); ?>
                    </div>
                </div>
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

                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="exampleInputPassword1">Office Phone No. <span class="mandatory">*</span></label>
                        <?php echo form_input($college_office_no); ?>
                    </div>
                </div>

                <div class="clearfix"></div>
                <div class="register-buttons">
                    <?php
                    if (isset($edit_data) && !empty($edit_data)) {
                        echo form_submit('college_update', lang('update_college_label_button'), array("class" => "btn btn-primary"));
                    } else {
                        echo form_submit('college_add', lang('add_college_label_button'), array("class" => "btn btn-primary"));
                    }
                    ?>
                    <?php echo "<a href='" . SADMIN_URL . "college' class='btn btn-default'> Cancel </a>"; ?>
                </div>
            </div>
            <?php echo form_close(); ?> </div>
    </div>

    <div class="x_panel">
        <div class="x_content">
            <table id="datatable" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Email</th>
                        <th>Name</th>
                        <th>College Name</th>
                        <th>Address</th>
                        <th>Zip Code</th>
                        <th>Office No.</th>
                        <th>No. of students</th>
                        <th>Status</th>
                        <th width="10%" class="no_sorting">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($college_list) && !empty($college_list) && count($college_list) > 0) {
                        foreach ($college_list as $value) {
                            if ($value->user_status == 1) {
                                $checked = "checked='checked'";
                            } else {
                                $checked = "";
                            }

                            $locationStr = '';
                            if (isset($value->college_state) && !empty($value->college_state)) {
                                $locationStr = $value->college_state . ' ';
                            }
                            if (isset($value->college_city) && !empty($value->college_city)) {
                                $locationStr = $value->college_zipcode;
                            }
                            if (isset($value->college_zipcode) && !empty($value->college_zipcode)) {
                                $locationStr = $value->college_zipcode;
                            }
                            ?>
                            <tr>
                                <td><a href='mailto:<?= $value->user_email ?>'><?= $value->user_email ?></a></td>
                                <td><?= ucfirst($value->first_name) . ' ' . ucfirst($value->last_name) ?></td>
                                <td><?= ucfirst($value->college_name) ?></td>
                                <td><?= $value->college_address ?></td>
                                <td><?= $locationStr ?></td>
                                <td><?= $value->college_office_no ?></td>
                                <td><?= $value->students_count ?></td>
                                <td> <div id='toggle_over'> <input type='checkbox' <?= $checked ?> id='u_id_<?= $value->user_id ?>' name='status_<?= $value->user_id ?>' data-status='<?= $value->user_status ?>' class='ios-toggle college_status' value='<?= $value->user_id ?>' /> <label class='checkbox-label' for='u_id_<?= $value->user_id ?>'></label></div></td>
                                <td>
                                    <a href='<?= SADMIN_URL ?>college/<?= $value->user_id ?>' class='label label-danger'>EDIT</a>
                                    <a href='<?= SADMIN_URL ?>redirecttocollege/<?= base64_encode($value->user_id) ?>' class='label label-success'>Login</a>
                                    <a href='<?= SADMIN_URL ?>login_logs/college/<?= base64_encode($value->user_id) ?>' class='label label-primary'>Log In/Out Logs</a>
                                    <a href='<?= SADMIN_URL ?>user_change_password/<?= base64_encode($value->user_id) ?>' class='label label-warning'>Change Password</a>
                                </td>
                            </tr>
                            <?php
                        }
                    }
                    ?>

                </tbody>
            </table>
        </div>
    </div>


</div>

<Script type="text/javascript">
    $("#addcollegebutton").click(function (e) {
        $("#add_form_div").toggleClass("hide");
    });

    $("#coupon_start_date").keydown(function (e) {
        return false;
    });

    $("#coupon_end_date").keydown(function (e) {
        return false;
    });

</script>
<?php if (isset($is_exist) && $is_exist == "1") { ?>
    <script type="text/javascript">
        if ($("#add_form_div").hasClass("hide")) {
            $("#add_form_div").removeClass("hide");
        }
    </script>
<?php } ?>
