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

            <div class="form-group">
                <label for="collegelist">College</label><span class="mandatory">*</span>
                <select name="college_id" id="college_id" class="form-control" style="width:250px;" onchange="redirectURL(this.value);">
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



            <link href="<?php echo RTF_EDITOR; ?>summernote.css" rel="stylesheet">
            <script src="<?php echo RTF_EDITOR; ?>summernote.js"></script>
            <div class="form-group"> <label for="exampleInputPassword1">Welcome Note<span class="mandatory">*</span></label>
                <?php echo form_textarea($notes_detail); ?>
                <p>*Note: Image dimensions should not be greater than 250X250 pixels.</p>
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
                    $("#notes_detail").summernote({height: 300});

                    function redirectURL(cid)
                    {
                        var loc = "<?php echo SITE_URL . 'sadmin/welcome/'; ?>" + cid;
                        window.location.href = loc;
                    }
</script>