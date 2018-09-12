<div class="col-md-10 col-sm-12">
     <div id="infoMessage"><?php if(isset($message)) { 
     ?><p class="alert alert-success text-left"><?php
        echo $message; 
      ?></p><?php 
    } ?>
        <?php if(isset($error)) { 
        ?><p class="alert alert-danger text-left"><?php
        echo $error; 
        ?></p><?php
    } ?>
    </div>
    <div class="sections-head">EDIT USER</div>
    <div class="x_panel">
        <div class="x_content">
            <div class="row">
                <?php
                $attributes = array('id' => 'add_user', 'class' => 'form-horizontal');
                echo form_open(ADMIN_URL . "edit_user", $attributes);
                ?>
                <?php echo form_input($action); ?>
                <?php echo form_input($user_id); ?>
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label" for="first-name">Username <span class="mandatory">*</span></label> 
                                <?php echo form_input($username); ?> 
                                <?php echo form_input($user_type); ?>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label" for="last-name">Full Name <span class="mandatory">*</span></label>
                                <?php echo form_input($account_holder_name); ?>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label" for="email">E-mail <span class="mandatory">*</span></label>
                                <?php echo form_input($user_email); ?>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label" for="phone">Phone</label>
                                <?php echo form_input($mobile_phone); ?>
                            </div>
                        </div>


                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label " for="groups">Group(s)</label>

                                <?php
                                
                                $group= explode(',',$group);
                                $options = $groups;
                                $selected = $group;
                                $attr = 'class="chosen-select form-control" multiple="multiple"';
                                echo form_dropdown('groups[]', $options, $selected, $attr);
                                ?>    


                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label" for="groups">Level</label>
                                <?php
                                $options = $levels;
                                $selected = $level;
                                $attr = 'class="form-control chosen-select"';
                                echo form_dropdown('level', $options, $selected, $attr);
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="register-buttons">
                        <?php echo form_submit('submit', 'Update User', array("class" => "btn btn-primary")); ?>
                        <a href='<?php echo COMPANY_URL . "users" ?>' class='btn btn-default'> Cancel </a>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(function () {
        $('li #home-tab').on('click', function () {
            $('#home-tab> .icheckbox_flat-blue').addClass('checked');
            $('#home-tab> .icheckbox_flat-blue input').attr('checked', true);

            $('#profile-tab .icheckbox_flat-blue').removeClass('checked');
            $('#profile-tab> .icheckbox_flat-blue input').attr('checked', false);
            $('.total-monthly-hidden').removeClass('hide');
            $('.total-monthly-hidden').addClass('show');

        });
        $('li #profile-tab').on('click', function () {
            $('#profile-tab> .icheckbox_flat-blue').addClass('checked');

            $('#profile-tab> .icheckbox_flat-blue input').attr('checked', true);
            $('#home-tab .icheckbox_flat-blue').removeClass('checked');
            $('#home-tab> .icheckbox_flat-blue input').attr('checked', false);
            $('.total-monthly-hidden').removeClass('show');
            $('.total-monthly-hidden').addClass('hide');
        });

    });

    $('.btn-apply').on('click', function () {
        $(this).fadeOut(function () {
            $('.apply').fadeIn();
        });
    });

    $("[data-toggle=popover]").popover({
        html: true,
        content: function () {
            return $('#question_popover').html();
        }
    });
</script> 
<script type="text/javascript">
    $('#myTab input').on('ifChecked', function (event) {
        if ($(this).val() == 'user') {
            $('li #profile-tab').trigger('click');
        }
        if ($(this).val() == 'company') {
            $('li #home-tab').trigger('click');
        }
    });
    $('#tab_content1 input').on('ifChecked', function (event) {


        if ($(this).data('mtype') == "check") {
            //alert($(this).data('mtype'));
            return false;
        }
        var final_str = "$" + $(this).data('price') + " " + $(this).data('type');

        if ($(this).data('type') == "Monthly" && $(this).data('mtype') == "radio") {
            $("#issubscription").toggleClass("hide");
            $('#is_subscription').iCheck('uncheck');
            $("#is_subscription").removeAttr("checked");
        }
        else if ($(this).data('type') == "Annually" && $(this).data('mtype') == "radio") {
            $("#issubscription").toggleClass("hide");
            $('#is_subscription').iCheck('uncheck');
            $("#is_subscription").removeAttr("checked");
        }
        $("#coupon").text(final_str);
        $("#final_amount").val($(this).data('price'));
    });
    var g_plan_id = "";
    // Applying coupon_code
    $("#coupon_btn").click(function (e) {
        var plan_type = "";
        plan_type = document.getElementsByName("membership_plan[]");
        if (plan_type.length > 0) {
            for (i = 0; i < plan_type.length; i++)
            {
                if (plan_type.item(i).checked == true)
                {
                    plan_id = plan_type.item(i).value;
                    g_plan_id = plan_type.item(i).id;
                }
            }

        }
       
        jQuery.ajax({
            url: SITE_URL + "coupon_code_validation/" + $("#coupon_code").val() + "/" + plan_id + "/" + $("#user_type").val(),
            data: 'coupon_code=' + $("#coupon_code").val() + "&plan_type=" + plan_id + "&user_type=" + $("#user_type").val(),
            type: "POST",
            datatype: 'json',
            success: function (data) {
                var returnjson = JSON.parse(data);



                if (returnjson.type == "success") {
                    var coupon_type = returnjson.coupon_type

                    if (coupon_type == "amount") {
                        var net_amount = $("#final_amount").val();
                        var discount = (100 - returnjson.percentage) / 100;
                        var new_amount = net_amount * (discount);
                        plan_type = $("#" + g_plan_id).data('type');
                        if (plan_type == "Monthly") {
                            $('#coupon').text('$' + new_amount + ' ' + plan_type).fadeIn();
                        }
                        else if (plan_type == "Annually") {
                            $('#coupon').text('$' + new_amount + ' ' + plan_type).fadeIn();
                        }
                    }
                    else if (coupon_type == "days")
                    {
                        var net_amount = $("#final_amount").val();
                        var discount = returnjson.percentage;
                        plan_type = $("#" + g_plan_id).data('type');
                        $("#coupon").html('$' + net_amount + ' ' + plan_type + "<br/> (You Got  " + returnjson.percentage + " days extra in your subscription.)")
                    }
                    error_element = document.createElement("p");
                    error_element.setAttribute("class", "csuccess text-right");
                    error_element.setAttribute("id", "custom_error");
                    $("#custom_error1").text('');
                    document.getElementById("custom_error1").appendChild(error_element);
                    $("#custom_error").text("Coupon Successfully Applied");
                }
                else {
                    error_element = document.createElement("p");
                    error_element.setAttribute("class", "cerror text-right");
                    error_element.setAttribute("id", "custom_error");
                    $("#custom_error1").text('');
                    document.getElementById("custom_error1").appendChild(error_element);
                    $("#custom_error").text("Coupon Not Applicable");

                }
            },
            error: function () {

                error_element = document.createElement("p");
                error_element.setAttribute("class", "cerror  text-right");
                error_element.setAttribute("id", "custom_error");
                $("#custom_error1").text('');
                document.getElementById("custom_error1").appendChild(error_element);
                $("#custom_error").text("Coupon Not Applicable");


            }
        });
    });
</script>
