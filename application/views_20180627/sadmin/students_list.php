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
    <div class="x_panel">
        <div class="x_content">
            <?php if (isset($students_list) && !empty($students_list) && count($students_list) > 0) { ?>
                <div class="row">
                    <div class="col-md-12">
                        <a href="<?= SADMIN_URL ?>export_users/student" target="_blank" class="btn btn-primary pull-right"> Export Student</a>
                    </div>
                </div>
            <?php } ?>
            <table id="datatable" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Email</th>
                        <th>Name</th>
                        <th>College Name</th>
                        <th>Total Scheduled Sessions</th>
                        <th>Last Logged in</th>
                        <th>Registered On</th>
                        <th>Status</th>
                        <th width="10%" class="no_sorting">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($students_list) && !empty($students_list) && count($students_list) > 0) {
                        foreach ($students_list as $value) {
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
                                <td><a href='mailto:<?= $value->user_email ?>'><?= $value->user_email ?> </a></td>
                                <td><?= ucfirst($value->first_name) . ' ' . ucfirst($value->last_name) ?> </td>
                                <td><?= $value->college_name ?></td>
                                <td><?= $value->total_scheduled_session ?></td>
                                <td> <?= show_dateTime($value->user_last_loggedon) ?></td>
                                <td> <?= show_date($value->user_createdon) ?></td>
                                <!--<td>" . $value->college_address . "</td>"
                                . "<td>" . $locationStr . "</td>"-->
                                <td> <div id='toggle_over'> <input type='checkbox' <?= $checked ?> id='u_id_<?= $value->user_id ?>' name='status_<?= $value->user_id ?>' data-status='<?= $value->user_status ?>' class='ios-toggle college_status' value='<?= $value->user_id ?>' /> <label class='checkbox-label' for='u_id_<?= $value->user_id ?>'></label></div></td>
                                <td>

                                    <a href='<?= SADMIN_URL ?>redirecttocollege/<?= base64_encode($value->user_id) ?>' class='label label-success'>Login</a>
                                    <a href='javascript:void(0)' class='label label-info' onclick="user_detail('<?= SADMIN_URL . "user_detail/" . base64_encode($value->user_id) ?>', '<?= $value->user_id ?>')">View</a>
                                    <a href='<?= SADMIN_URL ?>login_logs/students/<?= base64_encode($value->user_id) ?>' class='label label-primary'>Log In/Out Logs</a>
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

<div id="userDetail"></div>

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
