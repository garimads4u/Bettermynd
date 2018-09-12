<div class="col-md-12">
    <?php
    $attributes = array('id' => 'providersignupform', 'class' => 'regration-form form-horizontal cutom-reg', "enctype" => "multipart/form-data");

    echo form_open(SITE_URL . "create_provider_user", $attributes);
    ?>
    <div class="row">
        <div class="col-md-6">
            <div class="left-register">
                <h2><span>BetterMynd</span></h2>
                    <!-- <p style="text-align:left;">See why BetterMynd is the fastest growing telemedicine software for providers.</p> -->
                <p style="text-align:left;">Making mental healthcare resources more accessible for college students across America.</p>
                <!--
                <h2><span>BetterMynd</span> Register Form</h2>
                <p style="text-align:left;">See why BetterMynd is the fastest growing telemedicine software for providers.</p>
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
                    <h3>College Counselor Registration</h3>
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
                    <label for="exampleInputFirstName">Provider First Name <span class="mandatory">*</span></label>
                    <?php echo form_input($first_name); ?>
                    <?php echo form_input($user_type); ?>

                </div>

                <div class="form-group">
                    <label for="exampleInputLastName">Provider Last Name <span class="mandatory">*</span></label>
                    <?php echo form_input($last_name); ?>

                </div>


                <div class="form-group">
                    <label for="exampleInputEmail1">Email Address <span class="mandatory">*</span></label>
                    <?php echo form_input($user_email); ?>
                </div>

                <div class="form-group">
                    <label for="exampleInputCollegeName">College Name <span class="mandatory">*</span></label>
                    <?php
                    $options = $college;
                    $selected = isset($postdata) && !empty($postdata['college_id']) ? $postdata['college_id'] : '';
                    $attr = 'class="groups_dropdown form-control"';
                    echo form_dropdown('college_id', $options, $selected, $attr);
                    ?>
                </div>


                <div class="form-group">
                    <label for="exampleInputPhone">Office Phone Number <span class="mandatory">*</span></label>
                    <?php echo form_input($mobile_no); ?>
                </div>

                <?php /* <div class="form-group">
                  <label for="exampleInputImage">Profile Image <span class="mandatory">*</span></label>
                  <!--  <input type="file" name="profile_image" id="profile_image" />-->
                  <div class="input-group profileimageDiv">
                  <input name="profile_image_txt" value="" autocomplete="off" class="form-control valid noneditable" placeholder="Browse" aria-invalid="false" type="text">
                  <span class="input-group-btn"> <span class="btn btn-primary btn-file"> Upload <!--<input name="profile_photo" accept="image/*" id="profile_photo" type="file">-->
                  <input type="file" name="profile_image" accept="image/x-png,image/gif,image/jpeg" id="profile_image" />
                  </span> </span>
                  </div>
                  </div> */ ?>

                <div class="form-group">
                    <div class="checkbox">
                        <label>
                            <?php echo form_input($terms_checked); ?>  Please read & accept BetterMynd all Terms and Conditions <span class="mandatory">*</span>
                        </label>
                        <span class="paddtop10"><a data-toggle="modal" data-target="#myModal" class="to_register" href="javascript:void(0);"><i class="fa fa-exclamation-circle" aria-hidden="true" data-toggle="tooltip" title="Counselor Terms & Conditions"></i> </a></span>
                    </div>
                </div>

                <div class="form-group margbtm">
                    <?php echo form_submit('submit', lang('create_user_submit_btn'), array("class" => "btn btn-primary pull-left", "id" => "signup_btn")); ?>
                    <span class="paddtop10 pull-right">Already Have an Account  <a href="<?php echo SITE_URL; ?>login" class="to_register">Login </a></span>
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
                <h4 class="modal-title"><?php echo $terms_conditions->page_title; ?></h4>
            </div>
            <div class="modal-body">
                <?php echo html_entity_decode($terms_conditions->page_content); ?>
            </div>
        </div>

    </div>
</div>
<script type="text/javascript">
    $(document).ready(function (e) {
        $(".datetimepicker").datetimepicker({
            maxDate: new Date(<?php echo date('Y'); ?>, <?php echo date('m') - 1; ?>, <?php echo date('d'); ?>),
            format: 'MM/DD/YYYY',
            minDate: '1900-01-01'

        });

    });
</script>