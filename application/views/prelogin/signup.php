<div class="col-md-12">
    <?php
    $attributes = array('id' => 'signupform', 'class' => 'regration-form form-horizontal cutom-reg');

    echo form_open(SITE_URL . "create_user", $attributes);
    ?>

    <div class="row">
        <div class="col-md-6">

            <div class="left-register">

                <h2><span>BetterMynd</span></h2>
                <!-- <p style="text-align:left;">See why BetterMynd is the fastest growing telemedicine software for providers.</p> -->
                <p style="text-align:left;">Making mental healthcare resources more accessible for college students across America.</p>
                <!--
                <ul>
                    <li><a href=""><i class="fa fa-check-circle-o" aria-hidden="true"></i>&nbsp; How providers are increasing revenue.</a></li>
                    <li><a href=""><i class="fa fa-check-circle-o" aria-hidden="true"></i>&nbsp; Connecting with patients via 2-way secure HD video.</a></li>
                    <li><a href=""><i class="fa fa-check-circle-o" aria-hidden="true"></i>&nbsp; Billing and reimbursement for remote treatment.</a></li>
                    <li><a href=""><i class="fa fa-check-circle-o" aria-hidden="true"></i>&nbsp; Managing diagnosis and treatment with ePrescribe.</a></li>
                    <li><a href=""><i class="fa fa-check-circle-o" aria-hidden="true"></i>&nbsp; Overview of our turn-key student adoption program.</a></li>
                </ul>
                -->
            </div>
        </div>
        <div class="col-md-6 ">
            <div class="right-register">

                <div class="form-group">
                    <h3>College Student Registration</h3>
                </div>
                <div class="form-group">
                    <div id="infoMessage">
                        <?php
                        if (isset($message) && !empty($message)) {
                            echo '<div class="alert alert-success text-left">' . $message . '</div>';
                        }

                        if (isset($error) && !empty($error)) {
                            echo '<div class="alert alert-danger text-left">' . $error . '</div>';
                        }
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="exampleInputEmail1">Student First Name <span class="mandatory">*</span></label>
                    <?php echo form_input($first_name); ?>

                </div>

                <div class="form-group">
                    <label for="exampleInputEmail1">Student Last Name <span class="mandatory">*</span></label>
                    <?php echo form_input($last_name); ?>
                    <input type="hidden" name="user_type" id="user_type" value="4" />

                </div>

                <div class="form-group">
                    <label for="exampleInputEmail1">Email Address <span class="mandatory">*</span></label>
                    <?php echo form_input($email); ?>
                </div>

                <div class="form-group">
                    <label for="exampleInputEmail1">College <span class="mandatory">*</span></label>
                    <?php
                    $options = $college;
                    $selected = isset($postdata) && !empty($postdata['college_id']) ? $postdata['college_id'] : '';
                    $attr = 'class="groups_dropdown form-control"';
                    echo form_dropdown('college_id', $options, $selected, $attr);
                    ?>
                </div>


                <?php /* <div class="form-group">
                  <label for="exampleInputEmail1">Are you an international student? <span class="mandatory">*</span></label>
                  <select name="is_international" class="form-control" id="is_international" >
                  <option value="1">Yes</option>
                  <option value="0">No</option>
                  </select>

                  </div> */ ?>

                <!--             <div class="form-group"> -->
                <!--                 <label for="exampleInputEmail1">Identification Number <span class="mandatory">*</span></label> -->
                <?php // echo form_input($patient_id); ?>
                <!--             </div> -->



                <div class="form-group">
                    <label for="exampleInputPassword1">Date Of Birth <span class="mandatory">*</span></label>

                    <div class='input-group date datetimepicker' style=" margin-bottom:0" id="dob_datetimepicker">
                        <?php echo form_input($dob); ?>
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>

                </div>



                <?php /* <div class="form-group">
                  <label for="exampleInputEmail1">Mobile Number <span class="mandatory">*</span></label>
                  <?php echo form_input($mobile_no); ?>
                  </div> */ ?>




                <div class="form-group">
                    <div class="checkbox">
                        <label>
                            <?php echo form_input($terms_checked); ?> Please read and accept BetterMynd's Terms & Conditions <span class="mandatory">*</span>
                        </label>
                        <span class="paddtop10"><a data-toggle="modal" data-target="#myModal" class="to_register" href="javascript:void(0);"><i class="fa fa-exclamation-circle" aria-hidden="true" data-toggle="tooltip" title="Student Terms & Conditions"></i> </a></span>
                    </div>
                </div>



                <div class="form-group margbtm">
                    <?php echo form_submit('submit', lang('create_user_submit_btn'), array("class" => "btn btn-primary pull-left", "id" => "signup_btn")); ?>
                    <span class="paddtop10 pull-right">Already registered? <a href="<?php echo SITE_URL; ?>login" class="to_register">Login </a></span>

                    <?php echo form_close(); ?>
                </div>
                <div class="claer"></div>
            </div>
            <div class="claer"></div>
        </div>
    </div>
</div>
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title black"><?php echo $terms_conditions->page_title; ?></h4>
            </div>
            <div class="modal-body">
                <?php echo html_entity_decode($terms_conditions->page_content); ?>
            </div>
        </div>

    </div>
</div>

<script type="text/javascript">
    $(document).ready(function (e) {
        var default_date = moment(new Date(<?php echo date('Y') - 17; ?>, <?php echo date('m') - 1; ?>, <?php echo date('d'); ?>));
        $("#dob_datetimepicker").datetimepicker({
            //useCurrent: false,
            defaultDate: default_date,
            maxDate: moment(),
            format: 'MM/DD/YYYY',
            minDate: '1900-01-01',
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

            //var t = new Date(e.date);
            //var ageDifMs = Date.now() - t.getTime();
            //alert(e.date);
            //var ageDate = new Date(ageDifMs); // miliseconds from epoch
            //alert(ageDate);
            //return Math.abs(ageDate.getUTCFullYear() - 1970);
        });

        $('#dob').val('');

    });
</script>