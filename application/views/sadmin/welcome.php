<style>
    .upload-img-gallery img{
        width: 100%;
        border: 4px #fff solid;
        box-shadow: 0px 0px 4px #ccc;
    }
    .upload-img-gallery a{
        position: absolute;
        right: 26px;
        top: 8px;
        font-size: 16px;
        background: rgba(255, 255, 255, 0.84);
        width: 26px;
        line-height: 26px;
        text-align: center;
        border-radius: 50%;
        color: #d21725;
        text-decoration: none;
    }
</style>
<div id="infoMessage">
    <?php
    if (isset($message) && !empty($message)) {
        echo "<p class='alert alert-success text-left'>" . $message . "</p>";
    }

    if (isset($error) && !empty($error)) {
        echo "<p class='alert alert-danger text-left'>" . $error . "</p>";
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
                    <div class="alert alert-info">To continue to access the application, please complete your profile.</div>
                    <?php
                }
            }

            $attributes = array('id' => 'welcomee_frm', 'class' => 'update-form form-horizontal', 'enctype' => 'multipart/form-data');

            echo form_open(SADMIN_URL . "welcome/{$college_id}", $attributes);
            ?>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="collegelist">College</label><span class="mandatory">*</span>
                        <select name="college_id" id="college_id" class="form-control" onchange="redirectURL(this.value);">
                            <?php
                            foreach ($college_lists as $key => $value) {
                                if (isset($college_id) && $college_id > 0 && $key == $college_id) {
                                    echo "<option value=" . $key . " selected='selected'>" . $value . "</option>";
                                } else {
                                    echo "<option value=" . $key . ">" . $value . "</option>";
                                }
                            }
                            ?>
                        </select>
                        <input type="hidden" name="collegeid" id="collegeid" value="<?php echo $college_id; ?>" />
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="exampleInputImage">Upload Logo
                            <?php if ($states && $states->logo_image) { ?>
                                (<a href="javascript:void(0)" data-toggle="modal" data-target="#logoModal">Uploaded logo</a>)
                            <?php }
                            ?></label>
                        <div class="input-group logoimageDiv">
                            <input name="logo_image_txt"  class="form-control valid" placeholder="Upload Logo" aria-invalid="false" type="text">
                            <span class="input-group-btn">
                                <span class="btn btn-primary btn-file"> Browse <!--<input name="profile_photo" accept="image/*" id="profile_photo" type="file">-->
                                    <input type="file" name="logo_image" accept="image/x-png,image/gif,image/jpeg" id="logo_image" />
                                </span>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="exampleInputImage">Upload Cover
                            <?php if ($states && $states->logo_cover) { ?>
                                (<a href="javascript:void(0)" data-toggle="modal" data-target="#coverModal">Uploaded Cover</a>)
                            <?php }
                            ?></label>
                        <div class="input-group logocoverimageDiv">
                            <input name="logocover_image_txt"  class="form-control valid" placeholder="Upload Logo" aria-invalid="false" type="text">
                            <span class="input-group-btn">
                                <span class="btn btn-primary btn-file"> Browse <!--<input name="profile_photo" accept="image/*" id="profile_photo" type="file">-->
                                    <input type="file" name="logocover_image" accept="image/x-png,image/gif,image/jpeg" id="logocover_image" />
                                </span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>


            <link href="<?php echo RTF_EDITOR; ?>summernote.css" rel="stylesheet">
            <script src="<?php echo RTF_EDITOR; ?>summernote.js"></script>
            <div class="form-group"> <label for="exampleInputPassword1">Welcome Note<span class="mandatory">*</span></label>
                <?php echo form_textarea($notes_detail); ?>
                <p>*Note: Image dimensions should not be greater than 250X250 pixels.</p>
            </div>

            <div class="row">
                <div class="col-md-12">

                    <div class="form-group">
                        <label for="exampleInputImage">Upload Image </label>
                        <div class="input-group uploadimageDiv">
                            <input name="upload_image_txt"  class="form-control valid" placeholder="Upload Image" aria-invalid="false" type="text">
                            <span class="input-group-btn">
                                <span class="btn btn-primary btn-file"> Browse <!--<input name="profile_photo" accept="image/*" id="profile_photo" type="file">-->
                                    <input type="file" name="upload_image" accept="image/x-png,image/gif,image/jpeg" id="upload_image" />
                                </span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <?php
                foreach ($notes_img as $value) {
                    if ($key != 0 && $key % 4 == 0) {
                        ?>
                    </div><div class="row">
                    <?php }
                    ?>
                    <div class="col-sm-3 col-xs-6 upload-img-gallery">
                        <img src="<?php echo IMAGE_VIEW_URL; ?>?image=/<?= $value->image; ?>&width=200&height=200&cropratio=1:1&doc_root=<?php echo urlencode(FILE_UPLOAD_PATH . 'welcome_note_image/'); ?>" />
                        <a href="<?php echo SADMIN_URL . "delete_welcomeimage/" . $value->id ?>" class="fa fa-times" title="Delete image"></a>
                    </div>
                <?php } ?>
            </div>
        </div>
        <!-- <div class="row">
             <div class="col-sm-6">
                 <div class="form-group">
                     <label for="exampleInputEmail1">Welcome Note <span class="mandatory">*</span></label>
        <?php echo form_input($first_name); ?>

                 </div>
             </div>
         </div> -->
        <div class="row">
            <div class="clearfix"></div>
            <div class="register-buttons">
                <?php echo form_submit('submit', 'Update Note', array("class" => "btn btn-primary", "id" => "signup_btn")); ?>
                <?php echo "<a href='" . PATIENT_URL . "dashboard' class='btn btn-default'> Cancel </a>"; ?>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>
</div>

<Script type="text/javascript">
                            $("#notes_detail").summernote({height: 300, disableDragAndDrop: true});

                            function redirectURL(cid)
                            {
                                var loc = "<?php echo SITE_URL . 'sadmin/welcome/'; ?>" + cid;
                                window.location.href = loc;
                            }
</script>


<div id="logoModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Uploaded Logo</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <?php if ($states && $states->logo_image) { ?>
                            <img src="<?php echo IMAGE_VIEW_URL; ?>?image=/<?= $states->logo_image; ?>&width=150&height=150&cropratio=1:1&doc_root=<?php echo urlencode(FILE_UPLOAD_PATH . 'welcome_note_image/'); ?>" class="img-circle"/>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
<div id="coverModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Uploaded Cover</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <?php if ($states && $states->logo_cover) { ?>
                            <img src="<?php echo IMAGE_VIEW_URL; ?>?image=/<?= $states->logo_cover; ?>&width=500&height=150&cropratio=4:1&doc_root=<?php echo urlencode(FILE_UPLOAD_PATH . 'welcome_note_image/'); ?>" />
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>