<div id="infoMessage">
    <?php
    if (isset($message) && !empty($message)) {
        echo "<p class='alert alert-success text-left'>" . $message . "</p>";
    }

    if (isset($error) && !empty($error)) {
        echo "<p class='alert alert-danger text-left'>" . $error . "</p>";
        //echo $error;
    }
    ?>
</div>
<div class="x_panel">
    <div class="x_content">
        <div class="col-md-12">
            <?php
            if (isset($is_profile_completeness) && empty($is_profile_completeness)) {
                if ($is_profile_completeness < 1) {
                    ?>
                    <div class="alert alert-info static_alrt_sh">To continue to access the application, please complete your profile.</div>
                    <?php
                }
            } elseif ($is_user_active == 0) {
                ?>
                <div class="alert alert-info static_alrt_sh">Thank you for completing your BetterMynd profile! <br>Your credentials are currently being verified by the BetterMynd team. You will receive an email notification within 24 to 48 hours notifying you when your account has been activated. If you have any questions or concerns, please email us at providers@bettermynd.com.</div>
                <?php
            } elseif ($is_disabled == 0) {
                ?>
                <div class="alert alert-danger static_alrt_sh">This account is temporary disabled, Please enable it for further process.</div>
                <?php
            }

            $attributes = array('id' => 'providerprofileform', 'class' => 'provider-form form-horizontal', "enctype" => "multipart/form-data");

            echo form_open(PROVIDER_URL . "manage_provider_profile", $attributes);
            ?>

            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="exampleInputFirstName">Provider First Name <span class="mandatory">*</span></label>
                        <?php echo form_input($first_name); ?>
                        <?php echo form_input($user_type); ?>
                        <?php echo form_input($user_id); ?>

                    </div></div>
                <div class="col-sm-6"><div class="form-group">
                        <label for="exampleInputLastName">Provider Last Name <span class="mandatory">*</span></label>
                        <?php echo form_input($last_name); ?>

                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email Address <span class="mandatory">*</span></label>
                        <?php echo form_input($user_email); ?>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="exampleInputCollegeName">College Name <span class="mandatory">*</span></label>
                        <?php
                        $options = $college;
                        $selected = $college_id_selected;
                        $attr = 'class="form-control" disabled="disabled"';
                        echo form_dropdown('college_id', $options, $selected, $attr);
                        ?>
                        <input type="hidden" name="college_id" value="<?php echo $selected; ?>"/>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="exampleInputPhone">Office Phone Number <span class="mandatory">*</span></label>
                        <?php echo form_input($mobile_no); ?>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="exampleInputSpecialties">Counseling Specialties <span class="mandatory">*</span></label>
                        <?php
                        if (isset($_SESSION['postdata']['specialities']) && !empty($_SESSION['postdata']['specialities'])) {
                            $speciality_selected = $_SESSION['postdata']['specialities'];
                        } else {
                            $speciality_selected = $speciality_selected;
                        }
                        $options = $speciality;
                        $selected = $speciality_selected;
                        $attr = 'class="form-control chosen-select required" multiple="multiple"';
                        echo form_dropdown('specialities[]', $options, $selected, $attr);
                        ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="exampleInputCost">Average rate per 45 minute session (&dollar;)<span class="mandatory">*</span></label>
                        <?php echo form_input($session_cost); ?>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="exampleInputInsuranceCarriers">What health insurance plans do you accept? <span class="mandatory">*</span></label>
                        <?php
                        if (isset($_SESSION['postdata']['insurance_carriers']) && !empty($_SESSION['postdata']['insurance_carriers'])) {
                            $insurence_selected = $_SESSION['postdata']['insurance_carriers'];
                        } else {
                            $insurence_selected = $insurence_selected;
                        }
                        $options = $insurence_list;
                        $selected = $insurence_selected;
                        $attr = 'class="form-control chosen-select required" multiple="multiple"';
                        echo form_dropdown('insurance_carriers[]', $options, $selected, $attr);
                        ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="exampleInputBiography">Biography (Max Limit: 500)<span class="mandatory">*</span></label>
                        <?php echo form_textarea($biography); ?>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="exampleInputImage">Upload Profile Image <span class="mandatory">*</span></label>
                        <div class="input-group profileimageDiv">
                            <input name="profile_image_txt" value="<?php echo $current_user->profile_image; ?>" class="form-control valid noneditable" placeholder="Browse" aria-invalid="false" type="text" id="profile_image_txt">
                            <span class="input-group-btn">
                                <span class="btn btn-primary btn-file"> Browse <!--<input name="profile_photo" accept="image/*" id="profile_photo" type="file">-->
                                    <input type="file" name="profile_image" accept="image/x-png,image/gif,image/jpeg" id="profile_image" />
                                </span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="exampleInputImage">Government Issued Photo ID <span class="mandatory">*</span></label>
                        <div class="input-group profileimageDiv">
                            <input name="photo_id_txt" value="<?php echo $current_user->photo_id; ?>" class="form-control valid noneditable" placeholder="Browse" aria-invalid="false" type="text" id="photo_id_txt">
                            <span class="input-group-btn">
                                <span class="btn btn-primary btn-file"> Browse <!--<input name="profile_photo" accept="image/*" id="profile_photo" type="file">-->
                                    <input type="file" name="photo_id" accept="image/x-png,image/gif,image/jpeg" id="photo_id" />
                                </span>
                                <?php if (isset($current_user->photo_id) && $current_user->photo_id) { ?>
                                    <a href="<?php echo PROVIDER_URL . "govtIssuedIdDownload?did=" . $current_user->user_id . "&photo_id=" . $current_user->photo_id; ?>" class="btn btn-info" title="Download">
                                        <i class="fa fa-download"></i>
                                    </a>
                                <?php } ?>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="exampleInputInsuranceCarriers">TimeZone <span class="mandatory">*</span></label>
                        <?php
                        $options = $timezone_list;
                        $selected = $timezone_list_selected;
                        $attr = 'class="chosen-select form-control"';
                        echo form_dropdown('timezone', $options, $selected, $attr);
                        ?>
                    </div>
                </div>
            </div>
            <!--
                                         <div class="panel panel-default group-bdr">
              <div class="panel-body">
                <h3  class="md-head ">Add & upload counseling certifications <a href="javascript:void(0);" class="btn btn-success pull-right addmultipleuploadbtn" onclick="addmultipleupload();"><i class="fa fa-plus"></i></a>
                  <div class="clear"></div>
                </h3>
            <?php
            $count_insurance_certificate = 0;
            if (isset($insurance_certificate_upload) && !empty($insurance_certificate_upload)) {
                $count_insurance_certificate = count($insurance_certificate_upload);
                foreach ($insurance_certificate_upload as $insurance_certificate) {
                    ?>
                                                                                                                                                                                                                                                                                                                        <div class="row">
                                                                                                                                                                                                                                                                                                                          <div class="col-sm-12">
                                                                                                                                                                                                                                                                                                                            <div class="form-group">
                                                                                                                                                                                                                                                                                                                              <h5> <?php echo isset($insurance_certificate) && !empty($insurance_certificate) && isset($insurance_certificate->counseling_document_title) ? $insurance_certificate->counseling_document_title : $insurance_certificate->counseling_certificate_name; ?>
                    <?php
                    if (isset($insurance_certificate) && !empty($insurance_certificate)) {
                        $name = $insurance_certificate->counseling_certificate_name;
                        $name_arr = explode('.', $name);
                        if (isset($name_arr[1]) && !empty($name_arr[1])) {
                            echo ' ( ' . $name_arr[1] . ' ) ';
                        }
                    }
                    ?>
                                                                                                                                                                                                                                                                                                                                <span class="pull-right"> <a href="<?php echo PROVIDER_URL . "deleteCounselingCertifications?did=" . $insurance_certificate->counseling_certificate_id . "&doc_name=" . $insurance_certificate->counseling_certificate_name; ?>" onclick="return confirm('Are you sure , you want to delete this counseling certification.');" class="btn btn-danger"><i class="fa fa-trash"></i></a> <a href="<?php echo PROVIDER_URL . "counselingCertificateDownload?did=" . $insurance_certificate->counseling_certificate_id . "&doc_name=" . $insurance_certificate->counseling_certificate_name; ?>" class="btn btn-info"><i class="fa fa-download"></i></a> </span> </h5>
                                                                                                                                                                                                                                                                                                                            </div>
                                                                                                                                                                                                                                                                                                                          </div>
                                                                                                                                                                                                                                                                                                                        </div>
                    <?php
                }
            }
            ?>
                <div class="row multipleuploadcontainer">
                  <input type="hidden" name="count_insurance_certificate" id="count_insurance_certificate" value="<?php echo $count_insurance_certificate; ?>">
                  <div class="col-sm-12 multipleupload">
                    <div class="form-group form-border">
                      <div class="row">
                        <div class="col-md-4">
                          <input type="text" name="document_name[]" class="form-control certificateRequire" placeholder="Enter Document Name" />
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <div class="input-group counsellingDiv">
                              <input name="counselling"  class="form-control valid noneditable" placeholder="Browse" aria-invalid="false" type="text">
                              <span class="input-group-btn"> <span class="btn btn-primary btn-file"> Upload
                              <input type="file" class="file" name="counseling_certifications[]" placeholder="Select a certificate">
                              </span> </span> </div>
                          </div>
                        </div>
                        <div class="col-md-4"> <a href="javascript:void(0);" class="btn btn-primary pull-right" onclick="removemultipleupload(this);"><i class="fa fa-minus"></i></a> </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="panel panel-default group-bdr">
              <div class="panel-body">
                <h3  class="md-head ">Add & upload malpractice insurance certifications <a href="javascript:void(0);" class="btn btn-success pull-right addmultipleuploadMalvarebtn" onclick="addmultipleuploadMalvare();"><i class="fa fa-plus"></i></a>
                  <div class="clear"></div>
                </h3>
            <?php
            $count_malpractice_certificate = 0;
            if (isset($malpractice_certificate_upload) && !empty($malpractice_certificate_upload)) {
                $count_malpractice_certificate = count($malpractice_certificate_upload);
                foreach ($malpractice_certificate_upload as $certificate) {
                    ?>
                                                                                                                                                                                                                                                                                                                        <div class="row">
                                                                                                                                                                                                                                                                                                                          <div class="col-sm-12">
                                                                                                                                                                                                                                                                                                                            <div class="form-group">
                                                                                                                                                                                                                                                                                                                              <h5> <?php echo isset($certificate) && !empty($certificate) && isset($certificate->malpractice_document_title) ? $certificate->malpractice_document_title : $certificate->insurance_certificate_name; ?>
                    <?php
                    if (isset($certificate) && !empty($certificate)) {
                        $name = $certificate->insurance_certificate_name;
                        $name_arr = explode('.', $name);
                        if (isset($name_arr[1]) && !empty($name_arr[1])) {
                            echo ' ( ' . $name_arr[1] . ' ) ';
                        }
                    }
                    ?>
                                                                                                                                                                                                                                                                                                                                <span class="pull-right"><a href="<?php echo PROVIDER_URL . "deleteMalpracticeCertifications?did=" . $certificate->insurance_certificate_id . "&doc_name=" . $certificate->insurance_certificate_name; ?>" onclick="return confirm('Are you sure , you want to delete this malpractice insurance certificate document.');" class="btn btn-danger"><i class="fa fa-trash"></i></a> <a href="<?php echo PROVIDER_URL . "malpracticeCertificateDownload?did=" . $certificate->insurance_certificate_id . "&doc_name=" . $certificate->insurance_certificate_name; ?>" class="btn btn-info"><i class="fa fa-download"></i></a> </span></h5>
                                                                                                                                                                                                                                                                                                                            </div>
                                                                                                                                                                                                                                                                                                                          </div>
                                                                                                                                                                                                                                                                                                                        </div>
                    <?php
                }
            }
            ?>
                <div class="row multipleuploadMalvarecontainer">
                    <input type="hidden" name="count_malpractice_certificate" id="count_malpractice_certificate" value="<?php echo $count_malpractice_certificate; ?>">
                  <div class="col-sm-12 multipleuploadMalvare">
                    <div class="form-group  form-border">
                      <div class="row">

                        <div class="col-md-4">
                          <input type="text" name="malpractice_document_name[]" class="form-control malCertificateRequire" placeholder="Enter Document Name" />
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <div class="input-group malpracticeDiv">
                              <input name="malpractice"  class="form-control valid noneditable" placeholder="Browse" aria-invalid="false" type="text">
                              <span class="input-group-btn"> <span class="btn btn-primary btn-file"> Upload
                              <input type="file" class="file" name="malpractice_certifications[]" placeholder="Select a certificate">
                              </span> </span> </div>
                          </div>

                        </div>

                        <div class="col-md-4"> <a href="javascript:void(0);" class="btn btn-primary pull-right" onclick="removemultipleuploadMalvare(this);"><i class="fa fa-minus"></i></a> </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <script>
                        var clone = $('.multipleupload').clone();
                        function addmultipleupload() {
                            var k = clone.clone();
                            $('.multipleuploadcontainer').append(k);
                            if($('.multipleuploadcontainer .multipleupload').length >= 10){
                                $('.addmultipleuploadbtn').addClass('disabled');
                                return false;
                            }else{
                                $('.addmultipleuploadbtn').removeClass('disabled');
                            }
                                                  $('.btn-file :file').on('fileselect', function (event, numFiles, label) {

                            var input = $(this).parents('.input-group').find(':text'),
                                    log = numFiles > 1 ? numFiles + ' files selected' : label;

                            if (input.length) {
                                input.val(log);
                            } else {
                                if (log)
                                    alert(log);
                            }

                        });
                        }
                        function removemultipleupload(that) {
                            $('.addmultipleuploadbtn').removeClass('disabled');
                            if ($('.multipleupload').length == 1)
                                return false;
                            $(that).parents('.multipleupload').remove();
                        }

                        var clonecetificate = $('.multipleuploadMalvare').clone();
                        function addmultipleuploadMalvare() {
                            var k = clonecetificate.clone();
                            $('.multipleuploadMalvarecontainer').append(k);
                            if($('.multipleuploadMalvarecontainer .multipleuploadMalvare').length >= 10){
                                $('.addmultipleuploadMalvarebtn').addClass('disabled');
                                return false;
                            }else{
                                $('.addmultipleuploadMalvarebtn').removeClass('disabled');
                            }
                                                  $('.btn-file :file').on('fileselect', function (event, numFiles, label) {

                            var input = $(this).parents('.input-group').find(':text'),
                                    log = numFiles > 1 ? numFiles + ' files selected' : label;

                            if (input.length) {
                                input.val(log);
                            } else {
                                if (log)
                                    alert(log);
                            }

                        });
                        }
                        function removemultipleuploadMalvare(that) {
                            $('.addmultipleuploadMalvarebtn').removeClass('disabled');
                            if ($('.multipleuploadMalvare').length == 1)
                                return false;
                            $(that).parents('.multipleuploadMalvare').remove();
                        }


                    </script>-->
            <div class="row">
                <div class="clearfix"></div>
                <div class="register-buttons">
                    <?php echo form_submit('submit', lang('update_user_submit_btn'), array("class" => "btn btn-primary", "id" => "signup_btn")); ?>
                    <?php echo "<a href='" . PROVIDER_URL . "dashboard' class='btn btn-default'> Cancel </a>"; ?>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>