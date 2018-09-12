<div class="col-md-12">
    <div class="x_panel">
        <div class="x_content">
            <div class="row">
                <div class="col-md-8">
                    <div>
                        <div class="profile-photo">
                            <?php if (isset($profile_data) && isset($profile_data->profile_image) && strlen($profile_data->profile_image) > 0) {
                                ?>
                                <img alt="Profile Image" width="100" src="<?php echo IMAGE_VIEW_URL; ?>?image=/<?php echo $profile_data->profile_image; ?>&width=150&height=150&cropratio=1:1&doc_root=<?php echo urlencode(PROFILE_FILE_UPLOAD_PATH); ?>" class="img-circle profile_img"/>
                                <?php
                            } else {
                                ?>
                                <img width="100" src="<?php echo DEFAULT_PROFILE_PIC; ?>" alt="Profile Image" class="img-circle profile_img"> 
                            <?php } ?>
                        </div>
                        <div class="user-header-info">
                            <h2 class="user-name">
                                <?php echo isset($profile_data) && !empty($profile_data) && isset($profile_data->first_name) ? ucwords($profile_data->first_name . ' ' . $profile_data->last_name) : "N/A"; ?>
                            </h2>
                            <h5 class="user-position">Third Party Provider</h5>
                            <div class="clear"></div>
                            <div><a class="btn btn-primary btn-xs" target="_blank" href="<?php echo THIRD_PARTY_URL . "manage_profile" ?>">Edit </a></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
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
              
            </div>
            <hr class="black-bdr"><div class="clear"></div>
            <h2 class="profile-head">Other Provider Information</h2>
            <div class="clear"></div>


            <div class="profile-view-state">

                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Demographic Information</a></li>
                    <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Biography</a></li>
                    <!--<li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Hospitals</a></li>-->
                    <li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Counseling certifications</a></li>
                    <li role="presentation"><a href="#specialty" aria-controls="specialty" role="tab" data-toggle="tab">Malpractice Insurance Certifications</a></li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="home">
                        <div class="table-responsive">
                            <table class="table table-hover dashboard-task-infos">
                                <tbody>
                                    <tr>
                                        <td>Address </td>
                                        <td>
                                            <?php echo isset($profile_data) && !empty($profile_data) && isset($profile_data->address) ? $profile_data->address : 'N/A'; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>City </td>
                                        <td>
                                            <?php echo isset($profile_data) && !empty($profile_data) && isset($profile_data->city) ? $profile_data->city : 'N/A'; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>State </td>
                                        <td>
                                            <?php echo isset($profile_data) && !empty($profile_data) && isset($profile_data->state) ? get_state_name($profile_data->state) : 'N/A'; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Zipcode </td>
                                        <td>
                                            <?php echo isset($profile_data) && !empty($profile_data) && isset($profile_data->zipcode) ? $profile_data->zipcode : 'N/A'; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Office Phone Number </td>
                                        <td>                                
                                            <?php echo isset($profile_data) && !empty($profile_data) && isset($profile_data->mobile_no) ? $profile_data->mobile_no : 'N/A'; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Average rate per 45 minute session ($) </td>
                                        <td>
                                            <?php echo isset($profile_data) && !empty($profile_data) && isset($profile_data->session_cost) ? $profile_data->session_cost : "N/A"; ?>                   
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>TimeZone </td>
                                        <td>
                                            <?php echo isset($profile_data) && !empty($profile_data) && isset($timezone) ? $timezone : "N/A"; ?>                   
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
                    <!--<div role="tabpanel" class="tab-pane" id="messages">...</div>-->
                    <div role="tabpanel" class="tab-pane" id="settings">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <tbody>
                                    <?php
                                    if (isset($insurance_certificate_upload) && !empty($insurance_certificate_upload)) {
                                        foreach ($insurance_certificate_upload as $insurance_certificate) {
                                            ?>
                                            <tr>
                                                <td>
                                                    <?php echo isset($insurance_certificate) && !empty($insurance_certificate) && isset($insurance_certificate->counseling_document_title) ? $insurance_certificate->counseling_document_title : $insurance_certificate->counseling_certificate_name; ?>
                                                    <?php
                                                    if (isset($insurance_certificate) && !empty($insurance_certificate)) {
                                                        $name = $insurance_certificate->counseling_certificate_name;
                                                        $name_arr = explode('.', $name);
                                                        if (isset($name_arr[1]) && !empty($name_arr[1])) {
                                                            echo ' ( ' . $name_arr[1] . ' ) ';
                                                        }
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <span class="pull-right"> 
                                                        <a href="<?php echo THIRD_PARTY_URL . "counselingCertificateDownload?did=" . $insurance_certificate->counseling_certificate_id . "&doc_name=" . $insurance_certificate->counseling_certificate_name; ?>" class="btn btn-info"><i class="fa fa-download"></i></a> 
                                                    </span>
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
                    <div role="tabpanel" class="tab-pane" id="specialty">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <tbody>
                                    <?php
                                    if (isset($malpractice_certificate_upload) && !empty($malpractice_certificate_upload)) {
                                        foreach ($malpractice_certificate_upload as $certificate) {
                                            ?>
                                            <tr>
                                                <td>
                                                    <?php echo isset($certificate) && !empty($certificate) && isset($certificate->malpractice_document_title) ? $certificate->malpractice_document_title : $certificate->insurance_certificate_name; ?>
                                                    <?php
                                                    if (isset($certificate) && !empty($certificate)) {
                                                        $name = $certificate->insurance_certificate_name;
                                                        $name_arr = explode('.', $name);
                                                        if (isset($name_arr[1]) && !empty($name_arr[1])) {
                                                            echo ' ( ' . $name_arr[1] . ' ) ';
                                                        }
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <span class="pull-right">
                                                        <a href="<?php echo THIRD_PARTY_URL . "malpracticeCertificateDownload?did=" . $certificate->insurance_certificate_id . "&doc_name=" . $certificate->insurance_certificate_name; ?>" class="btn btn-info"><i class="fa fa-download"></i></a> 
                                                    </span>
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
            </div>
        </div>
    </div>
</div>