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
                            <h5 class="user-position">Student</h5>
                            <div class="clear"></div>
                            <div><a class="btn btn-primary btn-xs" target="_blank" href="<?php echo PATIENT_URL . "manage_profile" ?>">Edit </a></div>
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
                                <li><b><i class="color-primary mr-sm fa fa-globe"></i></b>                        
                                    <?php echo isset($profile_data) && !empty($profile_data) && isset($timezone) ? $timezone : "N/A"; ?>
                                </li>

                            </ul>
                        </div>
                    </div></div> <!-- 
                <div class="col-md-6 col-lg-4">
                    <div class="b-primary bt-sm ">
                        <div class="user-job">
                            <div class="widget-list list-sm list-left-element ">
                                <ul>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <div class="left-element"><i class="fa fa-check color-success"></i></div>
                                            <div class="text">
                                                <span class="title">0 Appointment</span>
                                                <span class="subtitle">Completed</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <div class="left-element"><i class="fa fa-clock-o color-warning"></i></div>
                                            <div class="text">
                                                <span class="title">1 Provider</span>
                                                <span class="subtitle">Connected</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="mailto:<?php echo $profile_data->user_email; ?>">
                                            <div class="left-element"><i class="fa fa-envelope color-primary"></i></div>
                                            <div class="text">
                                                <span class="title">Leave a Message</span>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>  -->
            </div>
            <hr class="black-bdr"><div class="clear"></div>
            <h2 class="profile-head">Other Student Information</h2>
            <div class="clear"></div>


            <div class="profile-view-state">

                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Demographic Information</a></li>
                    <!---<li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Hospitals</a></li>
                    <li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Practice</a></li>-->
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="home">
                        <div class="table-responsive">
                            <table class="table table-hover dashboard-task-infos">
                                <tbody>
                                    <tr>
                                        <td>Student DOB</td>
                                        <td>
                                            <?php echo isset($profile_data) && !empty($profile_data) && isset($dob) ? date(DATE_FORMAT,strtotime($dob)) : 'N/A'; ?>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Student Gender</td>
                                        <td>
                                            <?php echo isset($profile_data) && !empty($profile_data) && isset($profile_data->gender) ? ucwords($profile_data->gender) : 'N/A'; ?>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Ethnicity</td>
                                        <td>
                                            <?php echo isset($profile_data) && !empty($profile_data) && isset($ethnicity_name) ? ucwords($ethnicity_name) : 'N/A'; ?>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td>College Name</td>
                                        <td>
                                            <?php echo isset($profile_data) && !empty($profile_data) && isset($college_name) ? $college_name : "N/A"; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Student ID Number</td>
                                        <td>
                                            <?php echo isset($profile_data) && !empty($profile_data) && isset($profile_data->patient_identification_number) ? $profile_data->patient_identification_number : "N/A"; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Office Phone Number</td>
                                        <td>                                
                                            <?php echo isset($profile_data) && !empty($profile_data) && isset($profile_data->mobile_no) ? $profile_data->mobile_no : "N/A"; ?>                   
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>TimeZone</td>
                                        <td>
                                            <?php echo isset($profile_data) && !empty($profile_data) && isset($timezone) ? $timezone : "N/A"; ?>                   
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!--<div role="tabpanel" class="tab-pane" id="messages">...</div>
                    <div role="tabpanel" class="tab-pane" id="settings">...</div>-->
                </div>
            </div>
        </div>
    </div>
</div>



