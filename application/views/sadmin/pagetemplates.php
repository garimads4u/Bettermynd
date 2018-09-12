<div class="col-md-12 col-sm-12 col-xs-12">
    <div id="infoMessage"><?php if (isset($message)) {
   ?><p class="alert alert-success text-left"><?php
            echo $message;
            ?></p><?php }
        ?>
        <?php if (isset($error)) {
            ?><p class="alert alert-danger text-left"><?php
                echo $error;
                ?></p><?php }
            ?>
    </div><?php
    if (isset($edit_data) && (count($edit_data) > 0) && !empty($edit_data)) {
        ?>
        <div class="x_panel">
            <div class="x_content">
                <?php
                $attributes = array('id' => 'cms_template_frm', 'class' => 'myprofile form-horizontal', 'enctype' => 'multipart/form-data');
                echo form_open(SADMIN_URL . "update_page", $attributes);
                ?>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <?php echo lang('page_title_label', 'page_title'); ?> <span class="mandatory">*</span>
                            <?php echo form_input($page_title); ?>
                            <?php echo form_input($edit_id); ?>

                        </div>
                        <link href="<?php echo RTF_EDITOR; ?>summernote.css" rel="stylesheet">
                        <script src="<?php echo RTF_EDITOR; ?>summernote.js"></script>
                        <div class="form-group">
                            <?php echo lang('page_content_label', 'page_content_label'); ?> <span class="mandatory">*</span>
                            <?php echo form_textarea($page_content); ?>

                        </div>

                        <div class="register-buttons">
                            <?php echo form_submit('submit', lang('update_page_content_button'), array("class" => "btn btn-primary")); ?>
                            <?php
                            echo "<a href='" . SADMIN_URL . "cmspages' class='btn btn-default'> Cancel </a>";
                            ?>
                        </div>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
        <Script type="text/javascript">
            $("#page_content").summernote({height: 300});
        </script>

        <?php
    }
    ?>

    <div class="sections-head">CMS Pages</div>
    <div class="x_panel">
        <div class="x_content">
            <table id="datatable" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Created On</th>
                        <!--<th>Status</th>-->
                        <th class="no_sorting">Actions</th>
                    </tr>
                </thead>
                <?php if (isset($page_templates) && !empty($page_templates) && count($page_templates) > 0) {
                    ?>
                    <tbody>

                        <?php
                        foreach ($page_templates as $template) {
                            if ($template->page_status == "1") {
                                $checked = "checked='checked'";
                            } else {
                                $checked = '';
                            }
                            if ($template->page_status == "1") {
                                $status = "DeActivate";
                            } else {
                                $status = "Activate";
                            }
                            ?>
                            <tr>
                                <td><?php echo $template->page_title; ?></td>
                                <td><?php echo date(DATE_FORMAT, strtotime($template->page_createdon)); ?></td>
                                <?php /* <td>
                                  <div id='toggle_over'><input type='checkbox' <?php echo $checked; ?> name='teplate_status_<?php echo $template->page_id; ?>' data-id="<?php echo $template->page_id; ?>" id="<?php echo $template->page_id; ?>" data-status='<?php echo $status; ?>' class='ios-toggle  template_status' value='<?php $template->page_id; ?>' /> <label for='<?php echo $template->page_id; ?>' class='checkbox-label'></label></div>
                                  </td> */ ?>
                                <td>

                                    <a href="<?php echo SADMIN_URL; ?>cmspages/<?php echo ($template->page_id); ?>" class="label label-danger">EDIT</a>
                                </td>
                            </tr>

                            <?php
                        }
                        ?>
                    </tbody>
                    <?php
                }
                ?>
            </table>
        </div>
    </div>
</div>