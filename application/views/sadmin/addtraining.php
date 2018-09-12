<style type="text/css">
    #editor{
        width:100% !important;
        height:100% !important;	
    }
</style>
<div class="col-md-12 col-sm-12 col-xs-12">
    <div id="infoMessage"><?php
        if (isset($message) && strlen($message) > 0) {
            $message1 = str_replace(" ", "", $message);
            if (strlen($message1) > 0) {
                echo $message;
                ?><?php
            }
        }
        ?>
        <?php if (isset($error) && strlen($error) > 0) {
            ?><?php
            echo $error;
            ?><?php }
        ?>
    </div>
    <div class="x_panel">

        <div class="x_content">
            <form class="form-horizontal" action="<?php echo SADMIN_URL; ?>savetrainingstep" method="post" enctype="multipart/form-data" id="addtraingingform">
                <?php if (isset($editid)) {
                    ?>
                    <input type="hidden" name="editid" id="editid" value="<?php echo $editid; ?>" />
                    <?php
                }
                ?>
                <!-- To Field -->
                <div class="row">                 
                    <div class="form-group clearfix">
                        <div class="col-lg-2 col-md-2 col-sm-12">
                            <label class="control-label email" for="User">Title:</label>
                        </div>
                        <div class="col-lg-10 col-md-10 col-sm-12"  id="chosen-select-mail" >

                            <input type="text" class="form-control" placeholder="Training Title" value="<?php if (isset($step_data['ts_title'])) {
                    echo $step_data['ts_title'];
                } else {
                    ' ';
                } ?>" name="tstep_title" id="tstep_title"  required="required" />
                        </div>
                    </div>
                    <!-- Subject Field -->

                    <link href="<?php echo RTF_EDITOR; ?>summernote.css" rel="stylesheet"  type="text/css">
                    <script src="<?php echo RTF_EDITOR; ?>summernote.js" type="text/javascript"></script>
                    <div class="form-group">
                        <div class="col-lg-2 col-md-2 col-sm-12">
                            <label class="control-label" for="messsage">Description:</label>
                        </div>
                        <div class="col-lg-10 col-md-10 col-sm-12">
                            <textarea name="description" id="description" class="form-control">
                                <?php
                                if (isset($step_data['ts_description'])) {
                                    echo html_entity_decode($step_data['ts_description']);
                                } else {
                                    ' ';
                                }
                                ?>
                            </textarea>
                        </div>                       
                        <script type="text/javascript">

                            $('#description').summernote({height: 300});
                        </script>                                  
                    </div>
                    <div class="form-group clearfix">
                        <div class="col-lg-2 col-md-2 col-sm-12">
                            <label for="subject" class="control-label">Attachment:</label>
                        </div>
                        <div class="col-sm-6">

                            <div class="input-group">
                                <input type="text" class="form-control " readonly placeholder="Browse">
                                <span class="input-group-btn">
                                    <span class="btn btn-primary btn-file">
                                        Upload <input type="file" class="element_image" name="ts_files[]" id="ts_files"   multiple="multiple">
                                    </span>
                                </span>

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 text-right">
                        <a class="btn btn-default" href="<?php echo SADMIN_URL; ?>trainings">Cancel</a>		
                        <button type="submit" class="btn btn-primary"><?php if (isset($step_data) && strlen($step_data['ts_title']) > 0) {
                                    echo "Update";
                                } else {
                                    echo "Create";
                                } ?></button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
