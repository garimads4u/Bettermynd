<div class="col-md-12 col-sm-12 col-xs-12">
    <div id="infoMessage">
        <?php if (isset($message)) { ?>
            <p class="alert alert-success text-left">
                <?php echo $message; ?>
            </p>
        <?php } ?>

        <?php if (isset($error)) { ?>
            <p class="alert alert-danger text-left">
                <?php echo $error; ?>
            </p>
        <?php } ?>
    </div>

    <div class="x_panel">
        <div class="x_content">
            <table id="datatable" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Email Address</th>
                        <th>Full Name</th>
                        <th>College Name</th>
                        <th>Office No.</th>
                        <th>Status</th>
                        <th class="no_sorting">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($provider_list) && !empty($provider_list) && count($provider_list) > 0) {
                        foreach ($provider_list as $value) {
                            if ($value->user_status == 1) {
                                $checked = "checked='checked'";
                            } else {
                                $checked = "";
                            }

                            $locationStr = '';

                            echo "<tr>"
                            . "<td><a href='mailto:" . $value->user_email . "'>" . $value->user_email . "</a></td>"
                            . "<td>" . ucfirst($value->first_name) . ' ' . ucfirst($value->last_name) . "</td>"
                            . "<td>" . ucfirst($value->college_name) . "</td>"
                            . "<td>" . $value->mobile_no . "</td>"
                            . "<td> <div id='toggle_over'> <input type='checkbox' " . $checked . " id='u_id_" . $value->user_id . "' name='status_" . $value->user_id . "' data-status='" . $value->user_status . "' class='ios-toggle provider_status' value='$value->user_id' /> <label class='checkbox-label' for='u_id_" . $value->user_id . "'></label></div></td>"
                            . "<td>
                            <a href='" . COLLEGE_URL . "provider_edit/" . base64_encode($value->user_id) . "' class='label label-danger'>EDIT</a>
                            <a href='" . COLLEGE_URL . "calendar/" . base64_encode($value->user_id) . "' class='label label-info'>Calendar</a>
                           </td>"
                            . "</tr>";
                        }
                    }
                    ?>

                </tbody>
            </table>
        </div>
    </div>

</div>

