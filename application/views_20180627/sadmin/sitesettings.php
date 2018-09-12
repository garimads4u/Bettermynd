<style>#char_count{float: right; padding-top:10px;}</style>
<div class="col-md-12 col-sm-12 col-xs-12">
    <h2 class="page-heading"><?php echo $heading;?></h2>
    <div id="infoMessage"><?php if(isset($message)) { 
        ?><p class="alert alert-success text-left"><?php
        echo $message; 
        ?></p><?php
    } ?></div>
    <div id="infoMessage">
        <?php if(isset($error)) { 
        ?><p class="alert alert-danger text-left"><?php
        echo $error; 
        ?></p><?php
    } ?>
    </div>
    <div class="x_panel">
        <div class="x_content">
             <?php
    $attributes = array('id' => 'site_setting_form', 'class' => 'sitesetting form-horizontal','enctype'=>'multipart/form-data');
    echo form_open(SADMIN_URL."update_site_setting",$attributes);?>
     <?php echo form_input($action); ?>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                           <?php echo lang('label_site_title', 'site_title');?>
                            <span class="mandatory">*</span>
                            <?php echo form_input($site_title); ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="meta_keywords">Meta Keywords</label>
                            <span class="mandatory">*</span>
                            <?php
                            $attribute = array(
                                'name' => 'meta_keywords',
                                'id' => 'meta_keywords',
                                'maxlength' => '1000',
                                'rows' => '6',
                                'value' => $meta_keywords,
                                'class' => 'form-control'
                            );

                            echo form_textarea($attribute);
                            ?>
                            <span id='char_count'>(Max. 1000 characters)</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="meta_description">Meta Description</label>
                            <span class="mandatory">*</span>
                            <?php
                            $attribute = array(
                                'name' => 'meta_description',
                                'id' => 'meta_description',
                                'maxlength' => '1000',
                                'rows' => '6',
                                'value' => $meta_description,
                                'class' => 'form-control'
                            );

                            echo form_textarea($attribute);
                            ?>
                            <span id='char_count'>(Max. 1000 characters)</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <?php echo lang('label_tax_percentage', 'tax_percentage');?>
                            <span class="mandatory">*</span>
                            <?php echo form_input($tax_percentage); ?>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <?php echo lang('label_time_zone', 'site_time_zone');?>
                            <span class="mandatory">*</span>
                            <?php
                            $options =$site_time_zone;
                            $selected = $time_zone;
                            $attr = 'class="form-control chosen-select"';
                            echo form_dropdown('site_time_zone',$options,$selected,$attr);
                            ?>
                        </div>
                    </div>
                </div>
                <div class="register-buttons">
                    <?php echo form_submit('submit', lang('edit_site_settings_btn'),array("class"=>"btn btn-primary"));
                       echo "<a href='".SADMIN_URL."dashboard' class='btn btn-default'>Cancel</a>";
                    ?>
                    
                </div>
            <?php echo form_close();?>
        </div>
    </div>
</div>
