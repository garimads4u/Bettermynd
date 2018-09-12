<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="sections-head">Users List</div>
    <div id="infoMessage"><?php if (isset($message)) {
   ?><p class="alert alert-success text-left"><?php
            echo strip_tags($message);
            ?></p><?php }
        ?>
        <?php if (isset($error)) {
            ?><p class="alert alert-danger text-left"><?php
                echo strip_tags($error);
                ?></p><?php }
            ?>
    </div>
    <div class="x_panel">
        <div class="row user_buttons">
            <div class="col-xs-6 text-left">
                <p>Download Bulk User Import CSV Format (<a href="<?php echo ASSETS_URL; ?>docs/Import_template.csv">Download</a>)<br/>
                    Total size of uploadable file must not exceed 5MB</p>
            </div>
            <div class="col-xs-6 text-right">
                <a href="<?php echo COMPANY_URL . 'add_user'; ?>" class="btn btn-primary"><i class="fa fa-plus"></i>&nbsp;Add User</a>
                <a href="javascript:void(0);" class="btn btn-primary" id="import_csv">
                    <i class="fa fa-file"></i>&nbsp;Import Users</a>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="x_panel">
        <div class="x_content">
            <table id="datatable" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Username</th>

                        <th>Level</th>
                        <th>Group(s)</th>
                        <th>Add Date</th>
                        <th>Profile</th>
                       	<th>Status</th>
                        <th>Stats<br/><small class="custom nowrap">Login | Created | Sent</small></th>                        
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($company_list) && count($company_list) > 0 && !empty($company_list)) {
                        foreach ($company_list as $value) {
                            if ($value->user_status == 1) {
                                $checked = "checked='checked'";
                            } else {
                                $checked = "";
                            }
                            $locationStr = '';
                            if (isset($value->state) && !empty($value->state)) {
                                $locationStr = $value->state . ' ';
                            }
                            if (isset($value->zipcode) && !empty($value->zipcode)) {
                                $locationStr = $value->zipcode;
                            }
                            $current_date = strtotime(date('Y-m-d h:i:s'));
                            $end_date = strtotime($value->subscription_end_date);
                            if ($end_date < $current_date) {
                                $bg = '#fef2f4';
                            } else {
                                $bg = '#ffffff';
                            }
                            $group = explode(',', $value->group_user);
                            $options = $groups;
                            $selected = $group;
                            $attr = 'class="form-control groups_dropdown"  multiple="multiple" style="width:200px;" data-id="' . $value->user_id . '"';

                            echo "<tr style='background:$bg'>"
                            . "<td>" . $value->username . "</td>"
                            //. "<td><a href='mailto:".$value->user_email."'>" . $value->user_email . "</a></td>"
                            . "<td>" . $this->basic_model->get_user_role($value->user_role) . "</td>"
                            . "<td>" . form_dropdown('level', $options, $selected, $attr) . "</td>"
                            . "<td class='nowrap'>" . date(DATE_FORMAT, ($value->user_createdon)) . "</td>"
                            . "<td><a href='" . COMPANY_URL . "edit_user/" . $value->user_id . "'>Profile</a> </td><td> ";
                            if (strlen($value->user_pswd) > 0) {
                                echo "<div id='toggle_over'> <input type='checkbox' " . $checked . " id='u_id_" . $value->user_id . "' name='status_" . $value->user_id . "' data-status='" . $value->user_status . "' class='ios-toggle user_status' value='$value->user_id' /> <label for='u_id_" . $value->user_id . "' class='checkbox-label'></label></div>";
                            } else {
                                echo "<div id='toggle_over'> <input type='checkbox'  id='u_id_" . $value->user_id . "' name='status_" . $value->user_id . "' data-status='" . $value->user_status . "' data-password='no' class='ios-toggle user_status' value='$value->user_id' /> <label for='u_id_" . $value->user_id . "' class='checkbox-label'></label></div>";
                            }
                            echo "</td><td>" . $this->basic_model->get_login_counts($value->user_id) . " | 0 | 0</td>"
                            . "<td><a href='" . COMPANY_URL . "user_transaction/" . base64_encode($value->user_id) . "' class='label label-success'  data-toggle='tooltip' title='User Transaction'><i class='fa fa-money'></i></a>&nbsp;";
                            if (strlen($value->user_pswd) <= 0) {
                                echo "<a href='" . COMPANY_URL . "resend_activation/" . base64_encode($value->user_id) . "' class='label label-warning' data-toggle='tooltip'  title='Reactivation Link'><i class='fa fa-compress'></i></a>";
                            }
                            echo "</td></tr>";
                        }
                    }
                    ?>

                </tbody>
            </table>
        </div>
    </div>

</div>
<form action="<?php echo COMPANY_URL; ?>importcsvusers" method="post" class="hide" enctype="multipart/form-data" id="importform">
    <input type="file" name="importedcsv" id="importedcsv" />
    <input type="submit" id="submit_btn_csv" value="Import" />
</form>
<script type="text/javascript">
    $("#import_csv").click(function (e) {
        $("#importedcsv").trigger("click");
    });
    $("#importedcsv").change(function (e) {
        pathvalue = $(this).val();
        pathvalue = pathvalue.replace(/\s+/g, '');
        if (pathvalue.indexOf(".csv") <= 0) {
            var errordiv = document.createElement("p");
            errordiv.setAttribute("class", "alert alert-danger");
            errordiv.setAttribute("id", "error_p");
            $("#infoMessage").text('');
            document.getElementById("infoMessage").appendChild(errordiv);
            $("#error_p").text('');
            $("#error_p").html('Invalid file, Only <strong>.csv</strong> extension files are supported.');
            return false;
        }
        else {
            $("#infoMessage").text('');
            bootbox.confirm({
                buttons: {
                    confirm: {
                        label: 'Yes, please'
                                //className: 'confirm-button-class'
                    },
                    cancel: {
                        label: 'No, thanks'
                                //className: 'cancel-button-class'
                    }
                },
                message: 'Do you really want to import this csv to our records.',
                callback: function (result) {
                    if (result == true) {
                        $("#importform").submit();

                    }
                    else {
                        window.location = SITE_URL + "company/users";
                    }
                },
                title: 'Multiple User Upload'
            });
        }
        /*if(pathvalue.length>0){
         $("#importform").submit();
         }*/
    });
    $(document).ready(function () {
        $(".groups_dropdown").change(function (event)
        {
            if (event.target == this)
            {
                var user_id = $(this).data('id');
                var value = $(this).val();
                console.log(value);
                $.ajax({
                    url: SITE_URL + "company/update_user_group/",
                    data: 'user_id=' + user_id + '&value=' + value,
                    type: "POST",
                    success: function (data) {

//                                    window.location.href = "";
                    },
                    error: function () {
                    }
                });

            }
        });
    });
</script>