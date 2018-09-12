<div class="col-md-12">
    <div class="x_panel">
        <div class="x_content">
            <div class="row">
                <div class="col-md-6 col-lg-5">
                    <div>
                        <div class="profile-photo">
                            <?php if (isset($profile_data) && isset($profile_data->profile_image) && strlen($profile_data->profile_image) > 0) {
                                ?>

                                <img alt="Profile Image" width="100" src="<?php echo IMAGE_VIEW_URL; ?>?image=/<?php echo $profile_data->profile_image; ?>&width=150&height=150&cropratio=1:1&doc_root=<?php echo urlencode(PROFILE_FILE_UPLOAD_PATH); ?>" class="img-circle profile_img"/>

                                <?php
                            } else {
                                ?>
                                <img alt="Profile Image" width="100" src="<?php echo DEFAULT_PROFILE_PIC; ?>" class="img-circle profile_img">
                            <?php } ?>
                        </div>
                        <div class="user-header-info">
                            <h2 class="user-name">
                                <?php echo isset($profile_data) && !empty($profile_data) && isset($profile_data->first_name) ? ucwords($profile_data->first_name . ' ' . $profile_data->last_name) : "N/A"; ?>
                            </h2>
                            <h5 class="user-position"><?php echo $profile_data->user_type == 5 ? 'Third Party Counselor' : 'On Campus Provider' ?></h5>
                            <div class="clear"></div>
                            <div>
                                <?php if (isset($is_owner) && !empty($is_owner) && $is_owner == "1") {
                                    ?>
                                    <a class="btn btn-primary btn-xs" target="_blank" href="<?php echo PROVIDER_URL . "manage_profile" ?>">Edit </a>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="user-inf">
                        <div class="">

                            <ul class="user-contact-info ph-sm">
                                <li>
                                    <b><i class="color-primary mr-sm fa fa-envelope"></i></b>
                                    <?php echo isset($profile_data) && !empty($profile_data) && isset($profile_data->user_email) ? $profile_data->user_email : "N/A"; ?>

                                </li>
                                <li><b><i class="color-primary mr-sm fa fa-phone"></i></b>
                                    <?php echo isset($profile_data) && !empty($profile_data) && isset($profile_data->mobile_no) ? $profile_data->mobile_no : "N/A"; ?>
                                </li>
<!--                                <li><b><i class="color-primary mr-sm fa fa-globe"></i></b>
                                <?php echo isset($profile_data) && !empty($profile_data) && isset($timezone) ? $timezone : "N/A"; ?>
                                </li>-->

                            </ul>
                        </div>
                    </div></div>
                <?php if (isset($profile_data) && $profile_data->user_id != $current_user->user_id) { ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="user-inf">
                            <div class="form-group">
                                <label class="blank">&nbsp;</label>

                                <br> <a  class="btn btn-primary pull-right" href = "<?php echo PATIENT_URL; ?>bookanappointment/<?php echo $profile_data->user_id; ?>"">Book Appointment</a>

                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <hr class="black-bdr"><div class="clear"></div>
            <h2 class="profile-head"><?php echo $profile_data->user_type == 5 ? 'Other Counselor Information' : 'Other Provider Information' ?></h2>
            <div class="clear"></div>


            <div class="profile-view-state">

                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Demographic Information</a></li>
                    <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Biography</a></li>
                    <!--<li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Hospitals</a></li>
                    <li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Practice</a></li>-->
                    <li role="presentation"><a href="#specialty" aria-controls="specialty" role="tab" data-toggle="tab">Specialties</a></li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="home">
                        <div class="table-responsive">
                            <table class="table table-hover dashboard-task-infos">
                                <tbody>
                                    <tr>
                                        <td>College Name </td>
                                        <td>
                                            <?php echo isset($profile_data) && !empty($profile_data) && isset($CollegeName) ? $CollegeName : "N/A"; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Office Phone Number </td>
                                        <td>
                                            <?php echo isset($profile_data) && !empty($profile_data) && isset($profile_data->mobile_no) ? $profile_data->mobile_no : "N/A"; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Average rate per 45 minute session ($) </td>
                                        <td>
                                            <?php echo isset($profile_data) && !empty($profile_data) && isset($profile_data->session_cost) ? "$" . number_format($profile_data->session_cost, 2) : "N/A"; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Insurance Accepted </td>
                                        <td>
                                            <?php echo isset($profile_data) && !empty($profile_data) && is_array($InsurenceName) ? implode(', ', $InsurenceName) : "N/A"; ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="profile">
                        <div class="padding-profile">
                            <p>
                                <?php echo isset($profile_data) && !empty($profile_data) && isset($profile_data->biography) ? $profile_data->biography : "N/A"; ?>
                            </p>
                        </div>
                    </div>
                    <!--<div role="tabpanel" class="tab-pane" id="messages">...</div>
                    <div role="tabpanel" class="tab-pane" id="settings">...</div>-->
                    <div role="tabpanel" class="tab-pane" id="specialty">
                        <div class="padding-profile">
                            <ul class="specility-profile">
                                <?php
                                $i = 1;
                                if (is_array($speciality)) {
                                    foreach ($speciality as $name) {
                                        ?>
                                        <li>
                                            <?php echo $name; ?>
                                        </li>
                                        <?php
                                        $i++;
                                    }
                                } else {
                                    echo $speciality;
                                }
                                ?>
                            </ul>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
