<div class="col-md-12 col-sm-12 col-xs-12">
    <div id="infoMessage">
        <?php if (isset($message)) {
            ?>
            <p class="alert alert-success text-left">
                <?php
                echo $message;
                ?>
            </p>
        <?php }
        ?>
        <?php if (isset($error)) {
            ?>
            <p class="alert alert-danger text-left">
                <?php
                echo $error;
                ?>
            </p>
        <?php }
        ?>
    </div>
    <div class="sections-head">TEMPLATES</div>
    <div class="x_panel">
        <div class="x_content">
            <table id="datatable" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Type</th>
                        <th>Size</th>
                        <th>Group</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    
                    if (isset($template_list) && count($template_list) > 0 && !empty($template_list)) {
                        foreach ($template_list as $value) {
                              
                            if ($value->source == '1') {
                                $page_video = 'user_edit_video_template';
                                $page = 'admin_edit_template';
                                $edit = 'custom_template';
                                $tid = $this->encrypt->encode($value->id);
                                $tid = str_replace(array('+', '/', '='), array('-', '_', '~'), $tid);
                                if ($value->is_publish == '0') {
									 if($value->video=='') {
                                    $edit_url = TEMPLATE_URL . $edit . "/" . $tid;
                                    }
                                    else{
                                    $edit_url = TEMPLATE_URL . 'video' . "/" . $tid;    
                                    }
                                   
                                    $edit_label = "label-danger";

                                    $personalize_url = "javascript:void();";
                                    $personalize_label = "label-gray";
                                } else {
                                    $edit_url = "javascript:void();";
                                    $edit_label = "label-gray";

                                    $personalize_url = TEMPLATE_URL . $page . '/' . $tid;
                                    $personalize_label = "label-success";
                                }
                            } else {
                                $page_video = 'user_edit_video_template';
                                $page = 'admin_design_template';
                                $edit = 'design_template';
                                $tid = $this->encrypt->encode($value->id);
                                $tid = str_replace(array('+', '/', '='), array('-', '_', '~'), $tid);

                                  if ($value->is_publish == '0') {
                                    $edit_url = TEMPLATE_URL . $edit .  "/" . $tid;
                                    $edit_label = "label-danger";

                                    $personalize_url = "javascript:void();";
                                    $personalize_label = "label-gray";
                                } else {
                                    $edit_url = "javascript:void();";
                                    $edit_label = "label-gray";

                                    $personalize_url = TEMPLATE_URL . $page . '/' . $tid;
                                    $personalize_label = "label-success";
                                }
                            }
                            if ($value->is_active == 1) {
                                $checked = "checked='checked'";
                            } else {
                                $checked = "";
                            }
                          
                           
                            echo "<tr>"
                            . "<td>" . $value->title . "</td>"
                            . "<td>" . ($value->category == '2' ? 'Banner Ads' : $value->type) . "</td>"
                            . "<td class='nowrap'>" . ($value->width . ' x ' . $value->height . ' px') . "</td>"
                            . "<td>" . $value->t_group . "</td>"
                            . "<td> <div id='toggle_over'> <input type='checkbox' " . $checked . " id='u_id_" . $value->id . "' name='status_" . $value->id . "' data-status='" . $value->is_active . "' class='ios-toggle template_status' value='$value->id' /> <label for='u_id_" . $value->id . "' class='checkbox-label'></label></div></td>"
                            . "<td><a href='" . (isset($value->video) && $value->video!="" ? TEMPLATE_URL . $page_video . '/' . $tid : $personalize_url) . "' class='label " . $personalize_label . "'>PERSONALIZE</a>  <a href='" . $edit_url . "' class='label " . $edit_label . "'>EDIT</a>  <a href='#' class='label label-warning lblduplicate' data-id='" . $value->id . "'  data-toggle=\"modal\" data-target=\"#myModal\">DUPLICATE</a></td>"
                            . "</tr>";
										
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="sections-head">USERS</div>
    <div class="x_panel">
        <div class="x_content">
            <table id="datatable" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Username</th>
                        <!-- <th>Email</th>-->
                        <th>Level</th>
                        <th>Group(s)</th>
                        <th>Add Date</th>
                        <th>Profile</th>
                        <th>Status</th>
                        <th>Stats<br/>
                            <small class="custom nowrap">Login | Created | Sent</small></th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
<?php
if (isset($company_list) && count($company_list) > 0 && !empty($company_list)) {
    foreach ($company_list as $value) {
        $pass = isset($value->user_pswd) && $value->user_pswd != "" ? '1' : '0';
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
        $attr = 'class="form-control groups_dropdown "  multiple="multiple" style="width:200px;" data-id="' . $value->user_id . '"';

        echo "<tr style='background:$bg'>"
        . "<td>" . $value->username . "</td>"
        //. "<td><a href='mailto:".$value->user_email."'>" . $value->user_email . "</a></td>"
        . "<td>" . $this->basic_model->get_user_role($value->user_role) . "</td>"
        . "<td>" . form_dropdown('level', $options, $selected, $attr) . "</td>"
        . "<td class='nowrap'>" . date(DATE_FORMAT, ($value->user_createdon)) . "</td>"
        . "<td><a href='" . COMPANY_URL . "edit_user/" . $value->user_id . "'>Profile</a> </td><td>";
		if(strlen($value->user_pswd)>1){
        echo "<div id='toggle_over'> <input type='checkbox' " . $checked . " id='u_id_" . $value->user_id . "' name='status_" . $value->user_id . "' data-pwd='" . $pass . "' data-status='" . $value->user_status . "' class='ios-toggle user_status' value='$value->user_id' /> <label for='u_id_" . $value->user_id . "' class='checkbox-label'></label></div>";
		}
		else{
        echo "<div id='toggle_over'> <input type='checkbox'  id='u_id_" . $value->user_id . "' name='status_" . $value->user_id . "' data-pwd='" . $pass . "' data-status='" . $value->user_status . "' class='ios-toggle user_status' value='$value->user_id' /> <label for='u_id_" . $value->user_id . "' class='checkbox-label'></label></div>";
		}
        echo "</td><td>" . $this->basic_model->get_login_counts($value->user_id) . " | 0 | 0</td>"
        . "<td><a href='" . COMPANY_URL . "user_transaction/" . base64_encode($value->user_id) . "' class='label label-success' data-toggle='tooltip' title='User Transaction'><i class='fa fa-money'></i></a>&nbsp;<a href='" . COMPANY_URL . "resend_activation/" . base64_encode($value->user_id) . "' class='label label-warning' data-toggle='tooltip'  title='Reactivation Link'><i class='fa fa-compress'></i></a></td>"
        . "</tr>";
    }
}
?>
                </tbody>
            </table>
            <div class="clearfix"> <a href="<?php echo COMPANY_URL . 'add_user'; ?>" class="btn btn-primary"><i class="fa fa-plus"></i>&nbsp;Add User</a></div>
        </div>
    </div>
</div>
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Please enter the name for duplicate template.</h4>
            </div>
            <form action="<?php echo TEMPLATE_URL; ?>duplicatetemplate" id="template_form" method="post">
                <div class="modal-body">
                    <div class="alert alert-danger hide" id="errormsgtemplate"></div>
                    <p>
                        <input type="hidden" name="chngetemplate_id" id="chngetemplate_id" />
                        <input type="hidden" name="redirect" id="redirect" value='dashboard' />
                    </p>
                    <input type="text" name="newtemplatename" id="newtemplatename" class="form-control"/>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Proceed</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
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

    $(document).on("click", ".user_status", function (e) {
        e.preventDefault();
        id = $(this).attr('id');
        var status = $(this).data('status');
        status = status != '' && status == '1' ? 'deactivate' : 'activate';
        u_id = $(this).val();
        var pwd = $(this).data('pwd');
        status = status != '' && status == '1' ? 'deactivate' : 'activate';
        var msg = "";
        u_id = $(this).val();
        if (pwd == '1') {
            msg = 'Do you really want to ' + status + ' user profile?';


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
                message: 'Do you really want to ' + status + ' user profile?',
                callback: function (result) {
                    if (result == true) {
                        if (document.getElementById(id).checked) {
                            status = '0';
                        }
                        else {
                            status = '1';
                        }
                        $.ajax({
                            url: SITE_URL + "company/update_status",
                            data: 'user_id=' + u_id + '&status=' + status,
                            type: "POST",
                            success: function (data) {

                                window.location.href = "";
                            },
                            error: function () {
                            }
                        });
                        //$('.switchery').trigger('click');

                    }
                },
                title: 'Manage Company Account Status'
            });
        }
        else {
            bootbox.alert({
                message: "User still not logged in yet",
                callback: function () { /* your callback code */
                },
                title: 'Manage Company Account Status'
            });
        }
    });

    $(document).on("click", ".template_status", function (e) {
        e.preventDefault();
        id = $(this).attr('id');
        var status = $(this).data('status');
        status = status != '' && status == '1' ? 'deactivate' : 'activate';
        u_id = $(this).val();

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
            message: 'Do you really want to ' + status + ' template?',
            callback: function (result) {
                if (result == true) {
                    if (document.getElementById(id).checked) {
                        status = '0';
                    }
                    else {
                        status = '1';
                    }
                    $.ajax({
                        url: SITE_URL + "template/template_status",
                        data: 't_id=' + u_id + '&status=' + status,
                        type: "POST",
                        success: function (data) {
                            window.location.href = "";
                        },
                        error: function () {
                        }
                    });
                    //$('.switchery').trigger('click');

                }
            },
            title: 'Manage Company Template Status'
        });
    });
    $(".lblduplicate").click(function (e) {
        $("#chngetemplate_id").val($(this).data('id'));
        document.getElementById('template_form').reset();
        $('#template_form').find('input').removeClass('error');

    });
    
    $(document).ready(function (e) {
        $("#template_form").validate({
            rules: {
                newtemplatename: {
                    required: {
                     depends: function () {
                         $(this).val($(this).val().ltrim());
                         return true;
                     }
                 },
                    minlength: 4,
                    maxlength: 254

                }
            },
            messages: {
                newtemplatename: {required: "Please enter template name to continue.",
                    maxlength: "Please enter 50 character only."},
            },
            errorPlacement: function (error, element) {

                var my = "";

                var at = "";



                if ($(window).width() < 800)

                {

                    my = 'bottom right';

                    at = 'top right';

                }

                else

                {

                    my = 'bottom right';

                    at = 'top right';

                }

                if (!error.is(':empty')) {

                    $(element).not('.valid').qtip({
                        overwrite: false,
                        content: error,
                        show: 'focus',
                        hide: 'blur',
                        position: {
                            my: my,
                            at: at,
                            viewport: $(window),
                            adjust: {x: 0, y: 0}
                        },
                        style: {
                            classes: 'qtip-custom qtip-shadow',
                            tip: {
                                height: 6,
                                width: 11
                            }
                        }
                    })
                            .qtip('option', 'content.text', error);
                }
                else {
                    element.qtip('destroy');
                }
            },
            success: "valid"
        });
    });
</script>