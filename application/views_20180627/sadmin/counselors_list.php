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
            <table id="datatable" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Email</th>
                        <th>Name</th>
                        <th>College Name</th>
                        <th>Registered On</th>
                        <th>Status</th>
                        <th width="10%" class="no_sorting">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($counselors_list) && !empty($counselors_list) && count($counselors_list) > 0) {
                        foreach ($counselors_list as $value) {
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
                            if ($value->user_type == 5) {
                                //$college_name .= $value->user_type==5?'<b>(Third Party Counselor)</b>':'';
                                $college_name = '<b>(Third Party Counselor)</b>';
                            } else {
                                $college_name = $value->college_name ? ucfirst($value->college_name) . '<br>' : '';
                            }

                            $college_id = !empty($value->third_parties_college_ids) ? $value->third_parties_college_ids : 0;
                            $tag_btn = $value->user_type == 5 ? '<a href="javascript:void(0);" class="label label-info" onclick="tagcollege(' . $value->user_id . ' , ' . "'" . $college_id . "'" . ');" >Tag College</a>' : '';
                            ?>
                            <tr>
                                <td><a href='mailto:<?= $value->user_email ?>'><?= $value->user_email ?></a></td>
                                <td><?= ucfirst($value->first_name) . ' ' . ucfirst($value->last_name) ?></td>
                                <td><?= $college_name ?></td>
                                <td><?= show_dateTime($value->user_createdon) ?></td>
                                <td> <div id='toggle_over'> <input type='checkbox' <?= $checked ?> id='u_id_<?= $value->user_id ?>' name='status_<?= $value->user_id ?>' data-status='<?= $value->user_status ?>' class='ios-toggle college_status' value='<?= $value->user_id ?>' /> <label class='checkbox-label' for='u_id_<?= $value->user_id ?>'></label></div></td>
                                <td>

                                    <a href='<?= SADMIN_URL ?>redirecttocollege/<?= base64_encode($value->user_id) ?>' class='label label-success'>Login</a>
                                    <?= $tag_btn ?>
                                    <a href='<?= SADMIN_URL ?>login_logs/counselors/<?= base64_encode($value->user_id) ?>' class='label label-primary'>Log In/Out Logs</a>
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
    function tagcollege(provider_id, cid) {
        $('#provider_id').val(provider_id);
        var college_lists = cid.split(',');
        var clglists = '';
        $.each(college_lists, function (i, val) {
            clglists = clglists + val + '_';
        });
        $.post("<?php echo SADMIN_URL; ?>get_college_html", {cdata: clglists}, function (data, status) {
            $("#boxholder").html(data);
        });
        $('#tag_college_modal').modal('show');
    }
</script>
<?php if (isset($is_exist) && $is_exist == "1") { ?>
    <script type="text/javascript">
        if ($("#add_form_div").hasClass("hide")) {
            $("#add_form_div").removeClass("hide");
        }

    </script>
<?php } ?>
<div id="tag_college_modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="<?php echo SADMIN_URL . 'tagcollege'; ?>" method="post">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Tag a College</h4>
                </div>
                <div class="modal-body">

                    <div class="form-group" >
        <!--                <label for="exampleInputCollegeName">College Name <span class="mandatory">*</span></label>-->
                        <?php
                        /*
                          $options = $college;
                          $selected = '0';
                          $attr = 'id="college_id" class="form-control"';
                          echo form_dropdown('college_id', $options, $selected, $attr);

                          $collegeStr = '';
                          if(isset($college_lists) && sizeof($college_lists) > 0)
                          {
                          foreach($college_lists as $key => $value)
                          {
                          $ids = 'college_'.$key;
                          $collegeStr .= $key.",";
                          echo "<div class='form-control'><label><input type='checkbox' name='colleges[]' id='".$ids."' value='".$key."' class='collegelist'  />&nbsp;".$value."</label></div>";
                          }
                          } */
                        ?>
                        <div id="boxholder"></div>
        <!--                <input type="hidden" name="college_str" id="college_str" value="<? //=(isset($collegeStr) && !empty($collegeStr) ? substr($collegeStr, 0,-1) : ''); ?>" />-->
                        <input type="hidden" name="provider_id" id="provider_id" value=""/>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->