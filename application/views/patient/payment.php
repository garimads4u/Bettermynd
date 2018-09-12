<div id="infoMessage">
    <?php
    if (isset($message) && !empty($message)) {
        echo "<p class='alert alert-success text-left'>" . $message . "</p>";
    } if (isset($error) && !empty($error)) {
        echo "<p class='alert alert-danger text-left'>" . $error . "</p>";
    }
    ?>
</div>
<div class="x_panel">
    <div class="x_content">
        <div class="col-md-12">
            <?php
            $attributes = array('id' => 'paymentform', 'class' => 'update-form form-horizontal', 'enctype' => 'multipart/form-data', 'autocomplete' => 'off');
            echo form_open(PATIENT_URL . "checkout", $attributes);
            ?>
            <input style="display:none">
            <input type="text" style="display:none">
            <input type="password" style="display:none">
            <input type="hidden" name="amount" id="amount" value="<?php echo (isset($provider_info) && !empty($provider_info) && isset($provider_info['session_cost']) && !empty($provider_info['session_cost']) ? $provider_info['session_cost'] : '0.00' ) ?>">
            <input type="hidden" name="description" id="description" value="Appointment Transaction">

            <input type="hidden" name="coupon_id" id="coupon_id">
            <input type="hidden" name="coupon_object" id="coupon_object">
            <input type="hidden" name="coupon_coupon_type" id="coupon_coupon_type">
            <input type="hidden" name="coupon_amount_off" id="coupon_amount_off">
            <input type="hidden" name="coupon_percent_off" id="coupon_percent_off">
            <input type="hidden" name="discount_amount" id="discount_amount">
            <input type="hidden" name="remain_session_cost" id="remain_session_cost" value="<?php echo $session_cost ?>">
            <input type="hidden" name="coupon_duration" id="coupon_duration">
            <input type="hidden" name="coupon_duration_in_months" id="coupon_duration_in_months">
            <input type="hidden" name="coupon_max_redemptions" id="coupon_max_redemptions">

            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-info static_alrt_sh">
                        <div class="row">
                            <div class="col-md-4">
                                <label class="control-label">
                                    <strong>Appointment With : </strong>
                                </label>
                                <label class="control-label">
                                    <?php echo ucwords($provider_info['first_name'] . " " . $provider_info['last_name']); ?>
                                </label>
                            </div>
                            <div class="col-md-3">
                                <label class="control-label">
                                    <strong>Session Cost : </strong>
                                </label>
                                <label class="control-label">
                                    <?php echo '$' . $session_cost; ?>
                                </label>
                            </div>
                            <div class="col-md-5">
                                <label class="control-label">
                                    <strong>Appointment On : </strong>
                                </label>
                                <label class="control-label">
                                    <?php echo date('M d, Y h:i A', strtotime($appointment_on)) . ' - ' . date('h:i A', strtotime($end_timeslot)); ?>
                                </label>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-12">
                    <div class="alert alert-warning static_alrt_sh">
                        <?php /* <p>Please enter your payment information below to book your appointment. If for whatever reason you need to cancel, you can do so at any time 24-hours before your scheduled appointment time to receive a full refund.</p>
                          <p>If your selected counselor accepts your insurance plan, they may provide you with a receipt at the end of your session so that you can be reimbursed by your insurance company. However, please contact your insurance company directly to make sure that they will provide you with a reimbursement.</p> */ ?>
                        <p>To book your appointment, please enter your payment information below. You may cancel your appointment 24-hours before your scheduled appointment time for a full refund.</p>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-6 col-sm-12">
                    <div class="card_form">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <?php // echo lang('create_user_first_name_card_label', 'first_name');  ?>
                                    <?php echo form_input($first_name); ?>
                                    <?php echo form_input($patient_id); ?>
                                    <?php echo form_input($provider_id); ?>
                                    <?php echo form_input($slot_id); ?>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <?php // echo lang('create_user_last_name_card_label', 'last_name');  ?>
                                    <?php echo form_input($last_name); ?>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-12 col-lg-6">
                                <div class="form-group">
                                    <?php // echo lang('create_user_card_number_label', 'card_number');  ?>
                                    <?php echo form_input($card_number); ?>
                                    <i class="cccard" aria-hidden="true"></i>
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-3 col-md-6 col-lg-3">
                                <div class="form-group">
                                    <?php // echo lang('create_user_card_expiration_number_label', 'expiration_date');  ?>
                                    <?php echo form_input($expiration_date); ?>
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-3 col-md-6 col-lg-3">
                                <div class="form-group">
                                    <?php // echo lang('create_user_card_cvv_number_label', 'cvv_code');  ?>
                                    <?php echo form_input($cvv_code); ?>
                                    <i class="cvv_icon" aria-hidden="true" title='3 digit no. printed on back of your card.'></i>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <?php // echo lang('create_user_address_label', 'address');  ?>
                                    <?php echo form_input($address); ?>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <?php // echo lang('create_user_zip_code_label', 'zip_code');  ?>
                                    <?php echo form_input($zip_code); ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="input-group">
                                    <?php echo form_input($coupon_code); ?>
                                    <span class="input-group-btn">
                                        <a id="apply_coupon_id" class="btn btn-danger" href="javascript:void(0)" onclick="apply_coupon()" style="margin-right:0">Apply Promo Code</a>
                                    </span>
                                    <span style='display:inline-block'>
                                        <i class="fa fa-spinner fa-pulse fa-3x fa-fw hide" id="coupon_loading_image" ></i>
                                    </span>
                                </div>
                                <span id="msg" class="coupon_error"></span>
                            </div>
                        </div>
                    </div>
                    <?php /* <div class="register-buttons">
                      <button id="signup_btn" class="btn btn-primary" type="submit">Pay Now </button>
                      <span style='display:inline-block'>
                      <i class="fa fa-spinner fa-pulse fa-3x fa-fw hide" id="loading_image" ></i>
                      </span>
                      <?php //echo form_submit('submit', 'Pay Now', array("class" => "btn btn-primary", "id" => "signup_btn","data-loading-text" => "<i class='fa fa-spinner fa-spin fa-3x fa-fw'></i>"));  ?>
                      </div> */ ?>
                </div>
                <div class="col-md-6 col-sm-12">

                    <div class="card_form">
                        <div class="card_detail row">
                            <div class="col-sm-12 card_head"><p class="text-center">Summary</p></div>
                            <div class="col-md-6 col-sm-6 text-right">
                                <label class="control-label">
                                    <strong>Session Cost : </strong>
                                </label>
                            </div>
                            <div class="col-md-6 col-sm-6 text-right">
                                <label class="control-label">
                                    <?php echo '$' . $session_cost; ?>
                                </label>
                            </div>
                            <div class="col-md-6 col-sm-6 text-right">
                                <label class="control-label">
                                    <strong>Discounts : </strong>
                                </label>
                            </div>
                            <div class="col-md-6 col-sm-6 text-right">
                                <label class="control-label" id="discount_amt_label">
                                    <?php echo '$' . number_format(0, 2); ?>
                                </label>
                            </div>
                            <div class="col-sm-12"><hr></div>
                            <div class="col-md-6 col-sm-6 text-right">
                                <label class="control-label">
                                    <strong>Total Session Amount : </strong>
                                </label>

                            </div>
                            <div class="col-md-6 col-sm-6 text-right">

                                <label class="control-label" id="charge_amt_label">
                                    <?php echo '$' . $session_cost; ?>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!--                    <div class="card_form">
                                            <div class="row">
                                                <div class="col-sm-6">

                                                </div>
                                            </div>
                                        </div>-->
                </div>
                <div class="clearfix"></div>
                <div class="col-md-6 col-sm-12">
                    <div class="register-buttons">
                        <button id="signup_btn" class="btn btn-primary" type="submit">Pay Now </button>
                        <a id="signup_link" class="btn btn-primary" onclick="submit_without_tpken()" href="javascript:void(0)">Pay Now </a>
                        <span style='display:inline-block'>
                            <i class="fa fa-spinner fa-pulse fa-3x fa-fw hide" id="loading_image" ></i>
                        </span>
                        <?php //echo form_submit('submit', 'Pay Now', array("class" => "btn btn-primary", "id" => "signup_btn","data-loading-text" => "<i class='fa fa-spinner fa-spin fa-3x fa-fw'></i>"));  ?>
                    </div>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script>
                            $(document).ready(function () {
                                $("#coupon_code").keyup(function () {
                                    if ($("#coupon_code").val() == '') {
                                        set_def_val();
                                    }
                                })
                            })
                            $('#signup_link').hide();
                            Stripe.setPublishableKey('<?php echo STRIPE_PK; ?>');
                            $("#expiration_date").val('');
                            function stripeResponseHandler(status, response) {
                                if (response.error) {
                                    $('#signup_btn').removeAttr("disabled");
                                    $('#loading_image').removeClass('show').addClass('hide');
                                    $('#infoMessage').html("<p class='alert alert-danger text-left'>" + response.error.message + "</p>");
                                    $(".alert-error").fadeTo(2000, 500).slideUp(800, function () {
                                        $(".alert-error").alert('close');
                                    });
//            document.getElementById('a_x200').style.display = 'block';
//            $(".payment-errors").html(response.error.message);
                                } else {
                                    var form$ = $("#paymentform");
                                    var token = response['id'];
                                    form$.append("<input type='hidden' name='stripeToken' value='" + token + "' />");
                                    var dataSet = form$.serialize();
                                    $.ajax({
                                        type: "POST",
                                        url: form$.attr("action"),
                                        data: dataSet,
                                        dataType: 'json',
                                        success: function (json) {
                                            $("#signup_btn").attr("disabled", false);
                                            $('#loading_image').removeClass('show').addClass('hide');
                                            form$.get(0).reset();
                                            if (json['success']) {
                                                window.location = "<?php echo PATIENT_URL; ?>dashboard";
                                            }
                                            if (json['error']) {
                                                $('#infoMessage').html("<p class='alert alert-danger text-left'>" + json['error'] + "</p>");
                                                $(".alert-error").fadeTo(2000, 500).slideUp(800, function () {
                                                    $(".alert-error").alert('close');
                                                });
                                                set_def_val();
                                            }
                                        }
                                    });
                                }
                            }

                            function apply_coupon() {
                                var coupon_code = $("#coupon_code").val();
                                var error = 'This fiels is required.';
                                var c_my = 'bottom right';
                                var c_at = 'top right';
                                if ($(window).width() < 800) {
                                    c_my = 'bottom right';
                                    c_at = 'top right';
                                }

                                if (coupon_code == '') {
                                    $("#coupon_code").not('.valid').qtip({
                                        overwrite: false,
                                        content: error,
                                        show: 'focus',
                                        hide: 'blur',
                                        position: {
                                            my: c_my, at: c_at, viewport: $(window),
                                            adjust: {
                                                x: 0,
                                                y: 0
                                            }
                                        },
                                        style: {
                                            classes: 'qtip-custom qtip-shadow',
                                            tip: {
                                                height: 6,
                                                width: 11
                                            }
                                        }
                                    }).qtip('option', 'content.text', error);

                                    if ($("#coupon_code").attr("name") == "coupon_code") {
                                        $("#coupon_code").addClass('error');
                                    }
                                } else {
                                    if ($("#coupon_code").attr("name") == "coupon_code") {
                                        $("#coupon_code").removeClass('error');
                                    }
                                    $("#coupon_code").qtip('destroy');

                                    $('#coupon_loading_image').removeClass('hide').addClass('show');
                                    $("#apply_coupon_id").attr("disabled", true);

                                    var requestData = "coupon_id=" + coupon_code;
                                    var session_cost = "<?php echo $session_cost ?>";
                                    $.ajax({
                                        type: "POST",
                                        data: {session_cost: session_cost, coupon_id: coupon_code},
                                        url: "<?php echo PATIENT_URL ?>validate_coupon",
                                        dataType: 'JSON',
                                        success: function (data) {
                                            if (data.status == 'success') {
                                                $("#discount_amt_label").html('$' + data.message.discount_amt);
                                                $("#charge_amt_label").html('$' + data.message.remain_session_cost);
                                                $('#msg').addClass('success').removeClass('coupon_error').html("Coupon applied successfully.");

                                                $("#coupon_id").val(data.message.coupon_id);
                                                $("#coupon_object").val(data.message.coupon_object);
                                                $("#coupon_coupon_type").val(data.message.coupon_coupon_type);
                                                $("#coupon_amount_off").val(data.message.coupon_amount_off);
                                                $("#coupon_percent_off").val(data.message.coupon_percent_off);
                                                $("#discount_amount").val(data.message.discount_amt);
                                                $("#remain_session_cost").val(data.message.remain_session_cost);
                                                $("#coupon_duration").val(data.message.coupon_duration);
                                                $("#coupon_duration_in_months").val(data.message.coupon_duration_in_months);
                                                $("#coupon_max_redemptions").val(data.message.coupon_max_redemptions);

                                                $('#coupon_loading_image').removeClass('show').addClass('hide');
                                                $("#apply_coupon_id").attr("disabled", false);

                                                if (data.message.remain_session_cost <= 0) {
                                                    $('#paymentform .form-group').find('input').removeClass('error');
                                                    $('#signup_btn').hide();
                                                    $('#signup_link').show();
                                                }


                                            } else {
                                                set_def_val();
                                                $('#msg').html(data.message);
                                                $('#coupon_loading_image').removeClass('show').addClass('hide');
                                                $("#apply_coupon_id").attr("disabled", false);

                                            }
                                        }
                                    });


                                }

                            }

                            function set_def_val() {
                                var session_cost = "<?php echo $session_cost ?>";
                                $("#discount_amt_label").html('$0.00');
                                $("#charge_amt_label").html('$' + session_cost);
                                $('#msg').addClass('coupon_error').removeClass('success').html('');

                                $("#coupon_id").val('');
                                $("#coupon_object").val('');
                                $("#coupon_coupon_type").val('');
                                $("#coupon_amount_off").val('');
                                $("#coupon_percent_off").val('');
                                $("#discount_amount").val('');
                                $("#remain_session_cost").val(session_cost);
                                $("#coupon_duration").val('');
                                $("#coupon_duration_in_months").val('');
                                $("#coupon_max_redemptions").val('');

                                $('#signup_btn').show();
                                $('#signup_link').hide();
                            }


                            function submit_without_tpken() {
                                $("#signup_link").hide();
                                $('#loading_image').removeClass('hide').addClass('show');
                                var form$ = $("#paymentform");
                                var dataSet = form$.serialize();
                                $.ajax({
                                    type: "POST",
                                    url: form$.attr("action"),
                                    data: dataSet,
                                    dataType: 'json',
                                    success: function (json) {
                                        $('#loading_image').removeClass('show').addClass('hide');
                                        form$.get(0).reset();
                                        if (json['success']) {
                                            window.location = "<?php echo PATIENT_URL; ?>dashboard";
                                        }
                                        if (json['error']) {
                                            $('#infoMessage').html("<p class='alert alert-danger text-left'>" + json['error'] + "</p>");
                                            $(".alert-error").fadeTo(2000, 500).slideUp(800, function () {
                                                $(".alert-error").alert('close');
                                            });
                                            set_def_val();
                                        }
                                    }
                                });
                            }

</script>
