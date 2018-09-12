<div class="col-md-12">
    <div class="x_panel">
        <div class="x_content">
            <div class="row">
                <div class="col-md-6 col-lg-5">
                    <div>
                        <div class="profile-photo">
                            <?php if (isset($college_data) && isset($college_data->profile_image) && strlen($college_data->profile_image) > 0) {
                                ?>

                                <img alt="profile Image" width="100" src="<?php echo IMAGE_VIEW_URL; ?>?image=/<?php echo $college_data->profile_image; ?>&width=150&height=150&cropratio=1:1&doc_root=<?php echo urlencode(PROFILE_FILE_UPLOAD_PATH); ?>" class="img-circle profile_img"/>

                                <?php
                            } else {
                                ?>
                                <img width="100" src="<?php echo DEFAULT_PROFILE_PIC; ?>" alt="profile Image" class="img-circle profile_img">
                            <?php } ?>
                        </div>
                        <div class="user-header-info">
                            <h2 class="user-name">
                                <?php echo isset($college_data) && !empty($college_data) && isset($college_data->first_name) ? ucwords($college_data->first_name . ' ' . $college_data->last_name) : "N/A"; ?>
                            </h2>
                            <h5 class="user-position">College</h5>
                            <div class="clear"></div>
                            <div><a class="btn btn-primary btn-xs" target="_blank" href="<?php echo COLLEGE_URL . "manage_profile" ?>">Edit </a></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="user-inf">
                        <div class="">

                            <ul class="user-contact-info ph-sm">
                                <li>
                                    <b><i class="color-primary mr-sm fa fa-envelope"></i></b>
                                    <?php echo isset($college_data) && !empty($college_data) && isset($college_data->user_email) ? $college_data->user_email : 'N/A'; ?>

                                </li>
                                <li><b><i class="color-primary mr-sm fa fa-phone"></i></b>
                                    <?php echo isset($college_data) && !empty($college_data) && isset($college_data->college_office_no) ? $college_data->college_office_no : "N/A"; ?>
                                </li>

                            </ul>
                        </div>
                    </div></div>
                <?php /* <div class="col-md-6 col-lg-4">
                  <div class="b-primary bt-sm ">
                  <div class="user-job">
                  <div class="widget-list list-sm list-left-element ">
                  <ul>
                  <li>
                  <a href="#">
                  <div class="left-element"><i class="fa fa-check color-success"></i></div>
                  <div class="text">
                  <span class="title">95 Jobs</span>
                  <span class="subtitle">Completed</span>
                  </div>
                  </a>
                  </li>
                  <li>
                  <a href="#">
                  <div class="left-element"><i class="fa fa-clock-o color-warning"></i></div>
                  <div class="text">
                  <span class="title">3 Projects</span>
                  <span class="subtitle">working on</span>
                  </div>
                  </a>
                  </li>
                  <li>
                  <a href="mailto:<?php echo $college_data->user_email; ?>">
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
                  </div> */ ?>
            </div>
            <hr class="black-bdr"><div class="clear"></div>
            <h2 class="profile-head">Other College Information</h2>
            <div class="clear"></div>


            <div class="profile-view-state">

                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Demographic Information</a></li>
                    <!--<li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Hospitals</a></li>
                    <li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Practice</a></li>-->
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="home">
                        <div class="table-responsive">
                            <table class="table table-hover dashboard-task-infos">
                                <tbody>
                                    <tr>
                                        <td>College Name</td>
                                        <td>
                                            <?php echo isset($college_data) && !empty($college_data) && isset($college_data->college_name) ? $college_data->college_name : 'N/A'; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>College Address</td>
                                        <td>
                                            <?php echo isset($college_data) && !empty($college_data) && isset($college_data->college_address) ? $college_data->college_address : 'N/A'; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>College State</td>
                                        <td>
                                            <?php echo isset($college_data) && !empty($college_data) && isset($college_data->college_state) ? get_state_name($college_data->college_state) : 'N/A'; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>College City</td>
                                        <td>
                                            <?php echo isset($college_data) && !empty($college_data) && isset($college_data->college_city) ? $college_data->college_city : 'N/A'; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>College Zipcode</td>
                                        <td>
                                            <?php echo isset($college_data) && !empty($college_data) && isset($college_data->college_zipcode) ? $college_data->college_zipcode : 'N/A'; ?>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>College Phone Number</td>
                                        <td>
                                            <?php echo isset($college_data) && !empty($college_data) && isset($college_data->college_office_no) ? $college_data->college_office_no : 'N/A'; ?>
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