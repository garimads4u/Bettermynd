<script type="text/javascript">
    var Ist_subheadline = "";
    function change_hidden_value(control) {
        value = control.value;
        var selectedindex = control.selectedIndex;
        if (company_heading != "") {
            subheadlinevalue = control[selectedindex].getAttribute("data-subheadline");


            $("#ds_defaultcontent").val(value);
            $("#subheadlinetcontent").val(subheadlinevalue);
            $("#ds_defaultcontent").trigger("change");
            $("#ds_defaultcontent").trigger("keyup");
            $("#subheadlinetcontent").trigger("change");
            $("#subheadlinetcontent").trigger("keyup");
        }
    }
</script>
<style type="text/css">
    #dragandrophandler:hover{
        border:5px solid rgba(0,0,0,.2) !important;
    }
</style>
<?php
$dpi = 72;
$canvaswidth = 3.5; //inch
$canvasheight = 2; //inch
$canvaswidth_px = isset($template_data[0]) && $template_data[0]->width != "" ? $template_data[0]->width . 'px' : ''; //inch
$canvasheight_px = isset($template_data[0]) && $template_data[0]->height != "" ? $template_data[0]->height . 'px' : ''; //inch
$template_type = isset($template_data[0]) && $template_data[0]->type_id != "" ? $template_data[0]->type_id : '';
$template_group = isset($template_data[0]) && $template_data[0]->t_group_id != "" ? explode(',', $template_data[0]->t_group_id) : '';
?>

<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="alert alert-danger hide" id="errormsg"></div>
	<div  id="infoMessage"></div>
<?php if (!$edit) { ?>
        <div class="file-upload">
            <form id="fileupload" style="display:none;">
                <input type="file" id="files" name="FileInput" draggable="true" multiple onclick="">
            </form>
            <div id="dragandrophandler" class="dropzone text-center" onclick="$('#files').trigger('click');" style="cursor:pointer;">Drop File Here to Upload or  &nbsp; <span>Browse</span></div>

            <!--                </form>-->
            <p class="accepted_files">
                <!--<img src="<?php echo IMAGES_URL; ?>question_icon.png" width="21" height="20"  alt=""/>-->
                Accepted File Types: .pdf .jpg .png </p>
            <p id="fileUploadError" class="text-danger hide"></p>
        </div>
<?php } ?>
    <div class="row">
        <div class="col-md-5 col-sm-5">
            <div class="template_preview">
                <h3>TEMPLATE PREVIEW</h3>
                <div class="template_view" style="min-height:450px;">
                    <div id="slider" style="<?php echo!$edit ? 'display:none' : ''; ?>"><input type="hidden" id="hidden"/></div>
                    <span class="loading-img" style="display:none;"><img src="<?php echo IMAGES_URL; ?>loading.gif"><br>
                        LOADING...</span>
                    <div class="canvas_overflow">
                        <div class="canvas" style="position: relative;">
                            <div class="bleed">
                                <span class="safetyline"  data-toggle="popover"  data-content="Anything outside of the safety line may be trimmed off in the printing process">Safety Line
                                </span>
                            </div>
<?php
if ($edit && isset($template_elements) && count($template_elements) > 0 && !empty($template_elements[0])) {

    foreach ($template_elements as $data) {

        $settings = json_decode($data['settings']);
        $font_settings = json_decode($data['font_settings']);
        $color = $data['color'];
        $left = $data['cord_x'] . 'px';
        $top = $data['cord_y'] . 'px';
        $display = $data['is_active'] ? 'display:block' : 'display:none';
        $height = $settings->dsmaxheight . 'px';
        $width = $settings->dsmaxwidth . 'px';
        $fontsize = ($font_settings->dsfontsize * $dpi / 72) . 'px';
        $bold = isset($font_settings->dsbold) ? 'font-weight:bold' : 'font-weight:normal';
        $fontfamily = isset($font_settings->dsfont) && $font_settings->dsfont != "" ? str_replace('+', ' ', $font_settings->dsfont) : 'Arial';
        $italic = isset($font_settings->dsitalic) ? 'font-style:italic' : 'font-style:normal';
        $underline = isset($font_settings->dsunderline) ? 'text-decoration:underline' : 'text-decoration:none';
        $strikethrough = isset($font_settings->dsstrikethrough) ? 'text-decoration:line-through' : 'text-decoration:none';


        $dstexthstrech = 1;
        $dstextvstrech = 1;
        if (isset($font_settings->dstextvstrech)) {
            if ($font_settings->dstextvstrech >= 1)
                $dstextvstrech = $font_settings->dstextvstrech;
        }
        if (isset($font_settings->dstexthstrech)) {
            if ($font_settings->dstexthstrech >= 1)
                $dstexthstrech = $font_settings->dstexthstrech;
        }
        $trans = 'scale(' . $dstexthstrech . ',' . $dstextvstrech . ')';
        if ($data['element_type'] == 1) {
            ?>
                                        <div class="canvas_image canvas_elements" data-layer="<?php echo $data['element_name']; ?>" style="<?php echo $display; ?>"><span><?php echo $data['element_name']; ?></span></div>
                                    <?php } elseif ($data['element_type'] == 2) {
                                        ?>
                                        <div class="canvas_text canvas_elements" data-layer="<?php echo $data['element_name']; ?>" style="<?php echo $display; ?>"><span><?php echo $data['element_name']; ?></span></div>
                                        <?php
                                    } elseif ($data['element_type'] == 5) {
                                        ?>
                                        <div class="canvas_text canvas_elements" data-layer="<?php echo $data['element_name']; ?>"  style='<?php echo "$display;overflow:hidden;left:$left;top:$top;color: $color;font-size: $fontsize;text-align: $font_settings->dsalign;font-family: $fontfamily;$bold;$italic;$strikethrough;height:$height;width:$width; "; ?>'><span style="<?php echo "$underline;display:block;transform:$trans;-webkit-transform;$trans;"; ?>"><?php echo $settings->dsdefaultcontent; ?></span></div>
                                        <?php
                                    } elseif ($data['element_type'] == 6) {
                                        ?>
                                        <div class="canvas_text canvas_elements" data-layer="<?php echo $data['element_name']; ?>"  style='<?php echo "$display;overflow:hidden;left:$left;top:$top;color: $color;font-size: $fontsize;text-align: $font_settings->dsalign;font-family: $fontfamily;$bold;$italic;$strikethrough;height:$height;width:$width; "; ?>'><span style="<?php echo "$underline;display:block;transform:$trans;-webkit-transform;$trans;"; ?>"><?php echo $settings->dsdefaultcontent; ?></span></div>
                                        <?php
                                    } elseif ($data['element_type'] == 3) {
                                        $content = $settings->dsdefaultcontent;
                                        $bullet_type = $settings->dsbullettype;
                                        // $content = nl2br($content);
                                        $res = explode("\n", $content);
                                        $res = array_filter($res, 'trim');
                                        if ($bullet_type == '1')
                                            $num = 1;
                                        else if ($bullet_type == 'disc')
                                            $num = '&bull;';
                                        else if ($bullet_type == 'circle')
                                            $num = '&#9900;';
                                        else if ($bullet_type == 'square')
                                            $num = '&#9755;';
                                        else
                                            $num = '&bull;';
                                        $content = '<ul class="nobullet">';
                                        foreach ($res as $v) {
                                            if ($bullet_type == '1' || $bullet_type == 1) {
                                                $content .= '<li><span class="dsbullet">' . $num . '.</span> ' . $v . '</li>';
                                                $num++;
                                            } else {
                                                $content .= '<li><span class="dsbullet">' . $num . '</span> ' . $v . '</li>';
                                            }
                                        }
                                        $content.='</ul>';
//                            if($bullet_type=='1' || $bullet_type=='A' || $bullet_type=='a' || $bullet_type=='i' || $bullet_type=='I')
//                                $content.='</ol>';
//                            else
//                                $content.='</ul>';
                                        ?>
                                        <div class="canvas_text canvas_elements" data-layer="<?php echo $data['element_name']; ?>" style="<?php echo $display; ?>"><span><?php echo $content; ?></span></div>
                                        <?php
                                    } elseif ($data['element_type'] == 4) {
                                        ?>
                                        <div class="canvas_text canvas_elements" data-layer="<?php echo $data['element_name']; ?>" style='<?php echo "$display;overflow:hidden;left:$left;top:$top;color: $color;font-size: $fontsize;text-align: $font_settings->dsalign;font-family: $fontfamily;$bold;$italic;$strikethrough;height:$height;width:$width; "; ?>'><span style="<?php echo "$underline;display:block;transform:$trans;-webkit-transform;$trans;"; ?>">
                                        <?php
                                        $result_child = $this->tmodel->get_personalise_elements($data['element_name'], $data['template_id'], 4);
                                        // prd($result_child,1);
//                $sql = 'select * from dim_template_elements where is_active=1 and parent_element_name=\''.$data['element_name'].'\' and section_id = '.$section_id;
//                $result_child = mysql_query($sql);
                                        $t_company_elements = $result_child['t_company_elements'][0];

                                        $element_content = json_decode(str_replace('|-|', ' ', base64_decode($t_company_elements['element_content'])));

                                        foreach ($element_content as $key => $value) {
                                            ?>
                                                    <div class="relative clearfix">
                                                      <!--  <div class="canvas_text" data-layer="<?php echo $data['element_name']; ?>-title"><span>Feature</span></div>
                                                        <div class="pull-left" data-layer="<?php echo $data['element_name']; ?>-icon" style="border:1px dashed #f5f5f5;width:50px;height:20px; margin-right:8px; bottom:5px;"><span></span></div>
                                                        <div class="" data-layer="<?php echo $data['element_name']; ?>-description"><span>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</span></div>
                                                                         </div>-->
                <?php
                foreach ($result_child['t_element'] as $data_child) {
                    $settings = json_decode($data_child['settings']);
                    $font_settings = json_decode($data_child['font_settings']);
                    $color = $data_child['color'];
                    $left = $data_child['cord_x'] . 'px';
                    $top = $data_child['cord_y'] . 'px';
                    $height = $settings->dsmaxheight . 'px';
                    $width = $settings->dsmaxwidth . 'px';
                    $fontsize = ($font_settings->dsfontsize * $dpi / 72) . 'px';
                    $bold = isset($font_settings->dsbold) ? 'font-weight:bold' : 'font-weight:normal';
                    $fontfamily = isset($font_settings->dsfont) ? str_replace('+', ' ', $font_settings->dsfont) : '';
                    $italic = isset($font_settings->dsitalic) ? 'font-style:italic' : 'font-style:normal';
                    $underline = isset($font_settings->dsunderline) ? 'text-decoration:underline' : 'text-decoration:none';
                    $strikethrough = isset($font_settings->dsstrikethrough) ? 'text-decoration:line-through' : 'text-decoration:none';


                    $dstexthstrech = 1;
                    $dstextvstrech = 1;
                    if (isset($font_settings->dstextvstrech)) {
                        if ($font_settings->dstextvstrech >= 1)
                            $dstextvstrech = $font_settings->dstextvstrech;
                    }
                    if (isset($font_settings->dstexthstrech)) {
                        if ($font_settings->dstexthstrech >= 1)
                            $dstexthstrech = $font_settings->dstexthstrech;
                    }
                    $trans = 'scale(' . $dstexthstrech . ',' . $dstextvstrech . ')';
                    // echo   $data_child['element_name'] . $data['element_name'].'-title';
                    if ($data_child['element_name'] == $data['element_name'] . '-title') {
                        ?>
                                                                <div class="clearfix" data-layer="<?php echo $data_child['element_name']; ?>"  style='<?php echo "overflow:hidden;color: $color;font-size: $fontsize;text-align: $font_settings->dsalign;font-family: $fontfamily;$bold;$italic;$strikethrough;height:$height;width:$width; "; ?>'><span style="<?php echo "$underline;display:block;transform:$trans;-webkit-transform;$trans;"; ?>"><?php echo $value->feature_title; ?></span></div>
                                                                <?php
                                                            }
                                                            ?>

                                                            <?php
                                                            if ($data_child['element_name'] == $data['element_name'] . '-icon') {
                                                                ?>
                                                                <div class="clearfix">
                                                                    <div class="pull-left" data-layer="<?php echo $data_child['element_name']; ?>" style='<?php echo "overflow:hidden;color: $color;font-size:$fontsize;text-align: $font_settings->dsalign;font-family: $fontfamily;$bold;$italic;$strikethrough;height:$height;width:$width;  margin-right:8px; bottom:5px;"; ?>'>

                                                                        <span style="<?php echo "$underline;display:block;transform:$trans;-webkit-transform;$trans;"; ?>"data-svg='<?php echo IMAGES_URL . 'icons/' . $value->feature_icon; ?>'><?php echo file_get_contents(IMAGES_URL . 'icons/' . $value->feature_icon); ?></span>

                                                                    </div>
                        <?php
                    }
                    if ($data_child['element_name'] == $data['element_name'] . '-description') {
                        ?>
                                                                    <div class="" data-layer="<?php echo $data_child['element_name']; ?>"  style='<?php echo "overflow:hidden;color: $color;font-size: $fontsize;text-align: $font_settings->dsalign;font-family: $fontfamily;$bold;$italic;$strikethrough;height:$height;width:$width; "; ?>'><span style="<?php echo "$underline;display:block;transform:$trans;-webkit-transform;$trans;"; ?>"><?php echo $value->feature_description ?></span></div>
                                                                </div>
                                                                    <?php
                                                                }
                                                                ?>

                                                            <?php
                                                        }
                                                        ?>
                                                    </div>
                                                    <?php } ?>
                                            </span> </div>   
                                                <?php
                                            }
                                        }
                                    }
                                    ?>
                        </div>
                    </div>
                </div>
                <div class="progress-box">
                    <div id="myProgressbar" class="progress">
                        <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 33%;"> <span class="sr-only">0% Complete</span> </div>
                    </div>
                    <div class="steps-count">STEP 1 OF 3</div>
                </div>
            </div>
        </div>
        <div class="col-md-7 col-sm-7">
            <div class="clearfix">
                <div class="step1" data-step="1">
                    <form id="step-1">
                        <div class="x_panel follow-step">
                            <h3>Follow the steps below to setup your Template.</h3>
                            <p>File not uploading properly? Visit our <a href="#">File Preparation Overview ></a></p>
                            <h2>STEP 1 - <span>Template Setup</span></h2>
                        </div>
                        <div class="detected-size">
                            <div class="row">
                                <div class="col-sm-4 col-xs-12"> Detected Size </div>
                                <div class="col-sm-8 col-xs-12">
                                    <div class="row">
                                        <input type="hidden" value="<?php echo (isset($template_data) && !empty($template_data[0]) && $template_data[0]->background_image ? $template_data[0]->background_image : ''); ?>" name="background" id="background">
                                        <input type="hidden" value="0" name="section_id">
                                        <input type="hidden" value="<?php echo (isset($template_data) && !empty($template_data[0]) && $template_data[0]->id ? $template_data[0]->id : ''); ?>" name="template_id">
                                        <div class="col-sm-4 col-xs-4">
                                            <input  readonly type="text" id="width" name="width" value='<?php echo (isset($template_data) && !empty($template_data[0]) && $template_data[0]->width ? $template_data[0]->width : ''); ?>' class="form-control input_disabled">
                                        </div>
                                        <span class="pull-left">x</span>
                                        <div class="col-sm-4 col-xs-4">
                                            <input type="text" id="height" name="height" value='<?php echo (isset($template_data) && !empty($template_data[0]) && $template_data[0]->height ? $template_data[0]->height : ''); ?>'  readonly class="form-control input_disabled">
                                        </div>
                                        <span class="pull-left">Pixels</span> </div>
                                </div>
                            </div>
                        </div>
                        <div class="white_box">
                            <div class="row">
                                <!--                <div class="col-sm-1 col-xs-2">
                                                  <label>
                                                    <input type="checkbox" class="flat" checked="checked">
                                                  </label>
                                                </div>-->
                                <div class="col-sm-12 col-xs-10">
                                    <div class="row">
                                        <div class="col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label class="control-label" for="type">Type <span class="mandatory" style="font-size:14px !important;"> * </span></label>
<?php
$options = $template_types;
$selected = $template_type;
$attr = 'class="form-control chosen-select" id="templatetype"';
echo form_dropdown('template_type', $options, $selected, $attr);
?>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label class="control-label" for="group">Group(s) <span class="mandatory" style="font-size:14px !important;"> * </span></label>
<?php
$options = $groups;
$selected = $template_group;
$attr = 'class="groups_dropdown form-control" multiple="multiple" id="groups" ';
echo form_dropdown('groups[]', $options, $selected, $attr);
?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12  mar-top8">
                                    <label>
                                        <input type="checkbox" class="flat" checked="checked" name='notify_check' value='1'>
                                        Notify User Groups of New Template after Saving
                                    </label>
                                </div>
                            </div>
<?php
if ($edit) {
    $checked = isset($template_data[0]) && $template_data[0]->print_bleed == "1" ? "checked='checked'" : '';
} else {
    $checked = "";
}
?>
                            <div class="row">
                                <div class="col-sm-12  mar-top8">
                                    <label>
                                        <input type="checkbox" class="flat" id="print_bleed" name='print_bleed' value='1' <?php echo $checked; ?>>
                                        Add Print Bleed?
                                    </label>
                                </div>
                            </div>


                        </div>
                        <div class="x_panel">
                            <div class="row">
                                <!--                <div class="col-sm-1 col-xs-2">
                                                  <label>
                                                    <input type="checkbox" checked="checked" class="flat">
                                                  </label>
                                                </div>-->
                                <div class="col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label for="title">Title <span class="mandatory" style="font-size:14px !important;"> * </span></label>
                                        <input type="text" class="form-control"id="title" name="title" value="<?php echo (isset($template_data) && !empty($template_data[0]) && $template_data[0]->title ? $template_data[0]->title : ''); ?>" placeholder="Enter Template Title">
                                    </div>
                                    <div class="form-group">
                                        <label for="description" >Description</label>
                                        <textarea class="form-control" id="description" name="description" maxlength="250"><?php echo (isset($template_data) && !empty($template_data[0]) && $template_data[0]->description ? $template_data[0]->description : ''); ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12"> <button type="button" class="btn btn-primary pull-right" onclick="show_step(2);" id="step1">Continue to Step 2</button> </div>
                                <input type="hidden" name='c_compnay_id' id="c_compnay_id" value="<?php echo $company_details['company_id']; ?>">
                            </div>
                        </div>
                    </form>
                </div>
                <form action=<?php echo TEMPLATE_URL . 'save_template'; ?> id="save_template_frm" method="post">
                    <div class="step2" data-step="2" style="display:none;">
                        <div class="clearfix">
                            <h2>STEP 2 <span>Personalization Options</span></h2>
                            <!--<a href="#" class="pull-right mar-top8"><img src="<?php echo IMAGES_URL; ?>question_icon.png" width="21" height="20" alt="" /></a>--> 
                        </div>
                        <div class="white_box">
                            <div class="row">
                                <div class="col-sm-9">
                                    <p>Below are default personalization data for this Template Type. Editable in your <a href="<?php echo COMPANY_URL . 'company_profile' ?>" target="_blank">Company Profile</a>. You can add more data below.</p>
                                </div>
                                <!--                <div class="col-sm-2 col-sm-offset-1">
                                                  <div class="form-group">
                                                    <select class="select2_single form-control" tabindex="-1" data-width="100%">
                                                      <option>1</option>
                                                      <option>2</option>
                                                      <option>10</option>
                                                    </select>
                                                  </div>
                                                </div>-->
                            </div>
                            <div class="table-responsive my_table">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" class="flat check_all" checked="checked"></th>
                                            <th>Title</th>
                                            <th>Type</th>
                                            <th>Position</th>
                                            <th>Options</th>
                                        </tr>
                                    </thead>
                                    <tbody>
<?php
$i = 0;
ini_set('display_errors', 0);
if ($edit && isset($template_elements) && count($template_elements) > 0 && !empty($template_elements[0])) {
    foreach ($template_elements as $data) {

        if ($data['data_point_category'] == 1) {
            ?>
                                                    <tr data-source="<?php echo $data['element_name']; ?>">
                                                        <td class="valing-middle"><input type="hidden" name="is_active[]" value="<?php echo $data['is_active']; ?>" />
                                                            <input type="checkbox" class="flat is_active" <?php
                                        if ($data['is_active']) {
                                            echo 'checked="checked"';
                                        }
            ?>></td>
                                                        <td class="ln-height"><span class="source" style="cursor:pointer;"><?php echo $data['element_name']; ?></span>
                                                            <input type="hidden" value="<?php echo $data['parent_element_name']; ?>" name="parent_element_name[]" style="width:25px;">
                                                            <input type="hidden" value="<?php echo $data['element_name']; ?>" name="element_name[]" style="width:25px;">
                                                            <input type="hidden" value="<?php echo $data['data_point_id']; ?>" name="data_point_id[]" style="width:25px;">
                                                            <input type="hidden" value="<?php echo $data['data_point_category']; ?>" name="data_point_category[]" style="width:25px;"></td>
                                                        <td class="ln-height"><?php
                                                       //echo $type = $data['element_type']==1?'image':'text';
                                                       switch ($data['element_type']) {
                                                           case 1:echo 'Image';
                                                               break;
                                                           case 2:echo 'Text';
                                                               break;
                                                           case 3:echo 'Bullet';
                                                               break;
                                                       }
            ?>
                                                            <input type="hidden" value="<?php echo $data['element_type']; ?>" name="element_type[]" style="width:25px;"></td>
                                                        <td><div class="position_controls">
                                                                <input class="form-control cord_x" type="text" value="<?php echo $data['cord_x']; ?>" name="cord_x[]" maxlength="6">
                                                                <span>X</span>
                                                                <input class="form-control cord_y" type="text" value="<?php echo $data['cord_y']; ?>" name="cord_y[]" maxlength="6">
                                                                <span>Y</span> </div></td>
                                                        <td><span class="dssettings-parent">
                                                                <input type="text" class="ds-fontpick" name="font_settings[]" value='<?php echo $data['font_settings']; ?>'>
                                                            </span> <span class="dscolorpick-parent">
                                                                <input type="text" class="ds-colorpick" name="color[]" value='<?php echo $data['color']; ?>'>
                                                            </span> <span class="dssettings-parent">
                                                                <input type="text" class="ds-settings" data-element_type="<?php echo $data['element_type']; ?>" name="settings[]" value="<?php echo htmlentities($data['settings']); ?>">
                                                            </span>
                                                            <!--                        <span style="cursor:pointer;" onclick="remove_element('<?php echo $data['element_name']; ?>')"><i class="fa fa-times"></i></span>--></td>
                                                    </tr>
            <?php
        }
    }
}
?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="row">
                                <div class="col-sm-4 col-xs-12">
                                    <div class="form-group">
                                        <input type="text" value="" id="name1" class="form-control pull-left" placeholder="Name">
                                    </div>
                                </div>
                                <div class="col-sm-3 col-xs-12">
                                    <div class="form-group">
                                        <select id="type1" class="form-control pull-left">
                                            <option value="1">Image</option>
                                            <option value="2">Text</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3 col-xs-12"> <a href="javascript:void(0);" class="add_element btn btn-default pull-right">Add New</a> </div>
                                <div class="col-sm-2 form-group"> <button  type="button" class="btn btn-primary pull-right" onclick="show_step(3);" id="step2">NEXT</button> <input type="button" class="btn btn-primary pull-right hide" id="nextstep" value="Next"></div>

                            </div>
                        </div>
                    </div>
                    <div class="step3" style="display:none;" data-step="3">
                        <div class="clearfix">
                            <h2>STEP 3 <span>TEMPLATE CONTENT</span></h2>
                            <!--<a href="#" class="pull-right mar-top8"><img src="<?php echo IMAGES_URL; ?>question_icon.png" width="21" height="20" alt="" /></a>--> 
                        </div>
                        <div class="white_box">
                            <div class="row">
                                <div class="col-sm-9">
                                    <p>Below are default personalization data for this Template Type. Editable in your <a href="<?php echo COMPANY_URL . 'company_profile' ?>" target="_blank">Company Profile</a>. You can add more data below.</p>
                                </div>
                                <!--                <div class="col-sm-2 col-sm-offset-1">
                                                  <select class="select2_single form-control" tabindex="-1" data-width="100%">
                                                    <option>1</option>
                                                    <option>2</option>
                                                    <option>10</option>
                                                  </select>
                                                </div>-->
                            </div>
                            <div class=" table-responsive my_table">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" class="flat check_all" checked></th>
                                            <th>Title</th>
                                            <th>Type</th>
                                            <th>Position</th>
                                            <th>Options</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $i = 0;
                                    $j = 1;
                                    $element_name_temp = "";
                                    ini_set('display_errors', 0);

                                    if ($edit && isset($template_elements) && count($template_elements) > 0 && !empty($template_elements[0])) {
                                        foreach ($template_elements as $data) {
                                            if ($data['data_point_category'] == 2 && $data['element_type'] != '4') {
                                                ?>
                                                    <tr data-source="<?php echo $data['element_name']; ?>">
                                                        <td class="valing-middle"><input type="hidden" name="is_active[]" value="<?php echo $data['is_active']; ?>" />
                                                            <input type="checkbox" class="flat is_active" <?php
                                                    if ($data['is_active']) {
                                                        echo 'checked="checked"';
                                                    }
                                                    ?>></td>
                                                        <td class="ln-height"><span class="source" style="cursor:pointer;"><?php echo $data['element_name']; ?></span>
                                                            <input type="hidden" value="<?php echo $data['element_name']; ?>" name="element_name[]" style="width:25px;">
                                                            <input type="hidden" value="<?php echo $data['parent_element_name']; ?>" name="parent_element_name[]" style="width:25px;">
                                                            <input type="hidden" value="<?php echo $data['data_point_id']; ?>" name="data_point_id[]" style="width:25px;">
                                                            <input type="hidden" value="<?php echo $data['data_point_category']; ?>" name="data_point_category[]" style="width:25px;"></td>
                                                        <td ><?php
                                                       //echo $type = $data['element_type']==1?'image':'text';
                                                       switch ($data['element_type']) {
                                                           case 1:echo 'Image';
                                                               break;
                                                           case 2:echo 'Text';
                                                               break;
                                                           case 3:echo 'Bullet';
                                                               break;
                                                           case 5:echo 'Text';
                                                               break;
                                                           case 6:echo 'Text';
                                                               break;
                                                       }
                                                    ?>
                                                            <input type="hidden" value="<?php echo $data['element_type']; ?>" name="element_type[]" style="width:25px;"></td>
                                                        <td><div class="position_controls">
                                                                <input class="form-control cord_x" type="text" value="<?php echo $data['cord_x']; ?>" name="cord_x[]" maxlength="6">
                                                                <span>X</span>
                                                                <input class="form-control cord_y" type="text" value="<?php echo $data['cord_y']; ?>" name="cord_y[]" maxlength="6">
                                                                <span>Y</span> </div></td>
                                                        <td><span class="dssettings-parent">
                                                                <input type="text" class="ds-fontpick" name="font_settings[]" value='<?php echo $data['font_settings']; ?>'>
                                                            </span> <span class="dscolorpick-parent">
                                                                <input type="text" class="ds-colorpick" name="color[]" value='<?php echo $data['color']; ?>'>
                                                            </span> <span class="dssettings-parent">
                                                                <input type="text" class="ds-settings"  data-element_type="<?php echo $data['element_type']; ?>" name="settings[]" value='<?php echo ($data['settings']); ?>'>
                                                            </span></td>
                                                    </tr>
                                                    <?php
                                                } else {
                                                    if ($data['element_type'] == 4) {
                                                        $features = $this->tmodel->get_custom_feature_elements($data['template_id']);
                                                        $element_name_temp = $data['element_type'];
                                                        ?>
                                                        <tr><td colspan="5" style="border-left:1px solid #fff;border-right:1px solid #fff;">&nbsp;</td></tr>
                                                        <tr data-source="<?php echo $data['element_name']; ?>">
                                                            <th class="valing-middle"><input type="hidden" name="is_active[]" value="<?php echo $data['is_active']; ?>" />
                                                                <input type="checkbox" class="flat is_active feature_ch" <?php
                                                        if ($data['is_active']) {
                                                            echo 'checked="checked"';
                                                        }
                                                        ?>></th>
                                                            <th colspan="3" class="ln-height"><span class="source" style="cursor:pointer;"><?php echo $data['element_name']; ?></span>
                                                                <input type="hidden" value="<?php echo $data['element_name']; ?>" name="element_name[]" style="width:25px;">
                                                                <input type="hidden" value="<?php echo $data['data_point_id']; ?>" name="data_point_id[]" style="width:25px;">
                                                                <input type="hidden" value="<?php echo $data['parent_element_name']; ?>" name="parent_element_name[]" style="width:25px;">
                                                                <input type="hidden" value="<?php echo $data['data_point_category']; ?>" name="data_point_category[]" style="width:25px;">
                                                                <input class="form-control cord_x" type="hidden" value="<?php echo $data['cord_x']; ?>" name="cord_x[]" maxlength="6">
                                                                <input class="form-control cord_y" type="hidden" value="<?php echo $data['cord_y']; ?>" name="cord_y[]" maxlength="6">
                                                                <input type="hidden" value="<?php echo $data['element_type']; ?>" name="element_type[]" style="width:25px;">
                                                                <input type="hidden" value="<?php echo base64_encode(str_replace(" ", "|-|", json_encode($company_feature1))); ?>" name="company_feature" >
                                                            </th>
                                                            <td><span class="dssettings-parent">
                                                                    <input type="text" class="ds-fontpick" name="font_settings[]" value='<?php echo $data['font_settings']; ?>'>
                                                                </span> <span class="dscolorpick-parent">
                                                                    <input type="text" class="ds-colorpick" name="color[]" value='<?php echo $data['color']; ?>'>
                                                                </span> <span class="dssettings-parent">
                                                                    <input type="text" class="ds-settings"  data-element_type="<?php echo $data['element_type']; ?>" name="settings[]" value='<?php echo ($data['settings']); ?>'>
                                                                </span></td>
                                                        </tr>  
                                                        <?php
                                                        foreach ($features as $f_element) {
                                                            $et = explode('-', $f_element['element_name']);
                                                            ?>
                                                            <tr data-source="<?php echo $f_element['element_name']; ?>" class="active">
                                                                <td class="valing-middle"><input type="hidden" name="is_active[]" value="1" />
                                                                    <input type="checkbox" class="flat fch is_active"
                                                            <?php
                                                            if ($data['is_active']) {
                                                                echo 'checked="checked"';
                                                            }
                                                            ?> class="flat fch"></td>
                                                                <td colspan="2" class="ln-height"><span class="source" style="cursor:pointer;"><?php echo $data['element_name'] . ' ' . ucfirst($et[1]); ?></span>
                                                                    <input type="hidden" value="<?php echo $f_element['element_name']; ?>" name="element_name[]" style="width:25px;">
                                                                    <input type="hidden" value="<?php echo $data['element_name']; ?>" name="parent_element_name[]" style="width:25px;">
                                                                    <input type="hidden" value="<?php echo $f_element['data_point_id']; ?>" name="data_point_id[]" style="width:25px;">
                                                                    <input type="hidden" value="<?php echo $f_element['data_point_category']; ?>" name="data_point_category[]" style="width:25px;">
                                                                    <input class="form-control cord_x" type="hidden" value="<?php echo $f_element['cord_x']; ?>" name="cord_x[]" maxlength="6">
                                                                    <input class="form-control cord_y" type="hidden" value="<?php echo $f_element['cord_y']; ?>" name="cord_y[]" maxlength="6">
                                                                </td>
                                                                <td  class="valing-middle">
                                                                <?php
                                                                //echo $type = $data['element_type']==1?'image':'text';
                                                                switch ($f_element['element_type']) {
                                                                    case 1:echo 'Image';
                                                                        break;
                                                                    case 2:echo 'Text';
                                                                        break;
                                                                    case 3:echo 'Bullet';
                                                                        break;
                                                                }
                                                                ?>
                                                                    <input type="hidden" value="2" name="element_type[]" style="width:25px;">
                                                                </td>
                                                                <td><span class="dssettings-parent"> 
                                                                        <input type="text" class="ds-fontpick" <?php if ($et[1] == 'icon') { echo 'readonly';} ?> name="font_settings[]" value='<?php echo $f_element['font_settings']; ?>'>
                                                                    </span> <span class="dscolorpick-parent">
                                                                        <input type="text" class="ds-colorpick" <?php if ($et[1] == 'icon') { echo 'readonly';} ?> name="color[]" value='<?php echo $f_element['color']; ?>'>
                                                                    </span> <span class="dssettings-parent">
                                                                        <input type="text" class="ds-settings" data-feature="<?php echo $et[1]; ?>"  data-element_type="<?php echo $f_element['element_type']; ?>" data-makereadonly="true" name="settings[]" value='<?php echo ($f_element['settings']); ?>'>
                                                                    </span></td>
                                                            </tr>  
                                                                    <?php }
                                                                ?>
                                                        <tr><td colspan="5" style="border-left:1px solid #fff;border-right:1px solid #fff;">&nbsp;</td></tr>
                                                    <?php
                                                    }
                                                    if ($data['parent_element_name'] != "") {
                                                        
                                                    }
                                                }
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="row">
                                <div class="col-sm-5 col-xs-12">
                                    <div class="form-group">
                                        <input type="text" value="" id="name" class="form-control pull-left" placeholder="Name">
                                    </div>
                                </div>
                                <div class="col-sm-4 col-xs-12">
                                    <div class="form-group">
                                        <select id="type" class="form-control pull-left">
                                            <option value="1">Image</option>
                                            <option value="2">Text</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3 col-xs-12"> <a href="javascript:void(0);" class="add_element btn btn-default pull-left">Add New</a>&nbsp;
                                </div>
                                <div class="col-sm-12 col-xs-12 col-sm-offset-3 mar-top8">
                                    <input  type="button"  class="btn btn-primary prev3" value="Prev"> <input  type="button" onclick="download('0')" class="btn btn-primary" name="savedraft" value="Save Draft" > <input  type="button" onclick="download('1')" class="btn btn-primary" value="Publish">
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" value="<?php echo (isset($template_data) && !empty($template_data[0]) && $template_data[0]->id ? $template_data[0]->id : ''); ?>" name="custom_template_id" id="custom_template_id">

                    <input type="hidden" id="dataimgcontent" name="dataimgcontent">
                    <input type="hidden" id="notify" name="notify">
                    <input type="hidden" id="savedraft" name="savedraft">

                </form>
            </div>
            <div class="clearfix register-buttons"> </div>
        </div>
    </div>
</div>
<div class="modal fade" id="page_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Select Page</h4>
            </div>
            <div class="modal-body">
                <div id="message_page" style="padding-bottom:5px;"></div>
                <div class="row">
                    <div class=" col-sm-4 col-xs-6">
                        <select id="select_page" class="form-control">

                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="apply_image_changes">Apply changes</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<script>
    $(".a_pop").click(function (e) {
        $(".window_drop").show();
        e.stopPropagation();
    });

    $(".window_drop").click(function (e) {
        e.stopPropagation();
    });

    $(document).click(function () {
        $(".window_drop").hide();
    });
</script>
<style>
    .canvas{
        <?php if (!$edit) { ?>display:none;<?php } ?>

        width: <?php echo $canvaswidth_px; ?>;
        height: <?php echo $canvasheight_px; ?>;
        border:1px solid #ccc;
        overflow:hidden;
        /*zoom:30%;*/
        <?php if ($edit && trim($template_data[0]->background_image) != '') { ?>
            background-image: url(<?php echo UPLOAD_URL . 'templates/' . $template_data[0]->background_image; ?>);
        <?php } ?>

        <?php if ($edit && trim($template_data[0]->background_color) != '') { ?>
            background-color: <?php echo $template_data[0]->background_color; ?>;
        <?php } ?>
        background-color:#ffffff;
    }
    .bleed{
        <?php if ($edit) { ?>
            width: <?php echo $template_data[0]->width - 38 * 2; ?>px;
            height: <?php echo $template_data[0]->height - 38 * 2; ?>px;
            margin-top:38px;
            margin-left:38px;
        <?php } ?>
        position: relative;
        text-align: left;
        border:2px dotted #000;
        outline: 38px solid rgba(12, 12, 54, 0.1);
    }
    .safetyline{
        background-color: #fff;
        opacity: 0.95;
        padding: 2px;
        border: 1px solid #000;
        margin: 0px 0px 0 -2px;
        top:12px;
        position: fixed;
        color: #000;
        cursor:pointer;
    }
    .style_canvas{
        position: absolute;
    }
    .canvas_elements{
        position: absolute;
        cursor: pointer;
        font-size:<?php echo 14 * $dpi / 72; ?>px;
        overflow:hidden;
        min-height:100px;
        min-width:100px;
        max-height:100px;
        max-width:100px;
        border: 1px dotted #333;
    }
    .canvas_child_elements{
        cursor: pointer;
        /*font-size:<?php //echo 14 * $dpi / 72; ?>px;*/
        overflow:hidden;
        border: 1px dotted #333;
    }

    .canvas_elements.selected{
        outline:1px dashed #ccc;
        cursor:move;
    }
    .canvas_image{
        border: 1px solid #666;
    }
    .canvas_image{
        border: 1px solid #666;
    }
    .template_preview.stuck {
        position:fixed;
        top:0;
    }
    tr[data-source="Features"]{ background:#f5f5f5}
</style>
<script>
    var i = <?php echo $i; ?>,
            active = i;
    // var i = 0,active=i;

    var company_features = '<?php echo json_encode($company_feature, JSON_HEX_APOS); ?>';
    var company_bullets = '<?php echo addslashes(str_replace('\r\n', '<br>', $company_bullets)); ?>';
    var company_features_1 = '<?php echo base64_encode(str_replace(" ", "|-|", json_encode($company_feature1))); ?>';
    var company_heading = '<?php echo $company_heading; ?>';
    var canvas = $('.canvas');
    var bleed = $('.bleed');
    var bleedsize = 38;//px
    var elements = [];
    var default_text = "Your text goes here...";
    var dpi = <?php echo $dpi; ?>;
    var zoom = 55;
    var scale_bar = zoom / 100;
    var data_points;
    var top_def = 40,
            left_def = 40;
    var current_step = 1;
    $(document).ready(function () {

        $('[data-toggle="popover"]').popover();
    });
    $(document).ready(function () {
<?php if ($edit && isset($template_data[0]) && $template_data[0]->print_bleed == "1") {
    ?>
            $('.bleed').show();
    <?php
} else {
    ?>
            $('.bleed').hide();
<?php }
?>
        $('#print_bleed').on('ifChecked', function () {
            $('.bleed').show();

        });
        $('#print_bleed').on('ifUnchecked', function () {

            $('.bleed').hide();
        });
    });

    function add_element(element_name, element_type, num, data_point_id, makereadonly) {
        element_name = element_name.replace(/^\s+|\s+$/g,"");
        if (typeof data_point_id == 'undefined') {
            data_point_id = 0; // other
        }
        if (typeof makereadonly == 'undefined') {
            makereadonly = 0; // other
        }
        if ($.trim(element_name) == '') {
            $("#errormsg").text('Please enter element name.');
            $("#errormsg").removeClass("hide");
            $("#errormsg").addClass("show");
            window.scroll(0, 0);
            //alert('please enter element name');
            return false;
        }
        if ($.inArray(element_name, elements) >= 0 || element_name == 'background') {
            $("#errormsg").text('Element name already exists.');
            $("#errormsg").removeClass("hide");
            $("#errormsg").addClass("show");
            window.scroll(0, 0);
            return false;
        }
        $('#errormsg').removeClass('show');
        $("#errormsg").addClass("hide");
        elements.push(element_name);

        var element_type_name = element_type == '1' ? 'Image' : 'Text';
        element_type_name = element_type == '3' ? 'Bullet' : element_type_name;
        element_type_name = element_type == '4' ? 'features' : element_type_name;
        i++;
        active = i;
        var k = i;
        if (num == 2) {
            data_point_category = 1;
        } else {
            data_point_category = 2;
        }
        if (element_type != 4) {
            var html = '<tr data-source="' + element_name + '" class="active">' +
                    '<td class="valing-middle"><input type="hidden" name="is_active[]" value="1" />' +
                    '<input type="checkbox" checked="checked" class="flat is_active"></td>' +
                    '<td class="ln-height"><span class="source" style="cursor:pointer;">' + element_name + '</span>' +
                    '<input type="hidden" value="' + element_name + '" name="element_name[]" style="width:25px;">' +
                    '<input type="hidden" value="" name="parent_element_name[]" style="width:25px;">' +
                    '<input type="hidden" value="' + data_point_id + '" name="data_point_id[]" style="width:25px;">' +
                    '<input type="hidden" value="' + data_point_category + '" name="data_point_category[]" style="width:25px;">' +
                    '</td>' +
                    '<td class="ln-height">' + element_type_name +
                    '   <input type="hidden" value="' + element_type + '" name="element_type[]" style="width:25px;">' +
                    '</td>' +
                    '<td><div class=" position_controls">' +
                    '   <input class="form-control cord_x" type="text" value="' + left_def + '" name="cord_x[]" maxlength="6"><span>X</span>' +
                    ' <input class="form-control cord_y" type="text" value="' + top_def + '" name="cord_y[]" maxlength="6" ><span>Y</span>' +
                    '</div></td>' +
                    '<td>' +
                    '   <span class="dssettings-parent">' +
                    '      <input type="text" class="ds-fontpick" name="font_settings[]" value=\'\'>' +
                    ' </span>' +
                    ' <span class="dscolorpick-parent">' +
                    '     <input type="text" class="ds-colorpick" name="color[]" value=\'\'>' +
                    ' </span>' +
                    ' <span class="dssettings-parent">' +
                    '     <input type="text" class="ds-settings" ';
            if (makereadonly == 1 || makereadonly == '1') {
                html += ' data-makereadonly="true" ';
            }
            html += ' data-element_type="' + element_type + '" name="settings[]" value=\'\'>' +
//            ' </span><span style="cursor:pointer;" onclick="remove_element(\''+element_name+'\')"><i class="fa fa-times"></i></span>'+
                    '</td>' +
                    '  </tr>';
        } else {
            var html = '<tr><td colspan="5" style="border-left:1px solid #fff;border-right:1px solid #fff;">&nbsp;</td></tr>';
            html += '<tr data-source="' + element_name + '" class="active">' +
                    '<th class="valing-middle"><input type="hidden" name="is_active[]" value="1" />' +
                    '<input type="checkbox" checked="checked" class="flat is_active feature_ch"></th>' +
                    '<th colspan="3" class="ln-height"><span class="source" style="cursor:pointer;">' + element_name + '</span>' +
                    '<input type="hidden" value="' + element_name + '" name="element_name[]" style="width:25px;">' +
                    '<input type="hidden" value=' + company_features_1 + ' name="company_feature" >' +
                    '<input type="hidden" value="" name="parent_element_name[]" style="width:25px;">' +
                    '<input type="hidden" value="' + data_point_id + '" name="data_point_id[]" style="width:25px;">' +
                    '<input type="hidden" value="' + data_point_category + '" name="data_point_category[]" style="width:25px;">' +
                    '<input class="form-control cord_x" type="hidden" value="' + left_def + '" name="cord_x[]" maxlength="6">' +
                    '<input class="form-control cord_y" type="hidden" value="' + top_def + '" name="cord_y[]"  maxlength="6">' +
                    '<input type="hidden" value="' + element_type + '" name="element_type[]" style="width:25px;">' +
                    '</th>' +
                    '<th>' +
                    '   <span class="dssettings-parent">' +
                    '      <input type="text" class="ds-fontpick" name="font_settings[]" value=\'\'>' +
                    ' </span>' +
                    ' <span class="dscolorpick-parent">' +
                    '     <input type="text" class="ds-colorpick" name="color[]" value=\'\'>' +
                    ' </span>' +
                    ' <span class="dssettings-parent">' +
                    '     <input type="text" class="ds-settings" ';

            html += ' data-makereadonly="true" ';

            html += ' data-element_type="' + element_type + '" name="settings[]" value=\'\'>' +
//            ' </span><span style="cursor:pointer;" onclick="remove_element(\''+element_name+'\')"><i class="fa fa-times"></i></span>'+
                    '</th>' +
                    '  </tr>';

            html += '<tr data-source="' + element_name + '-title" class="active">' +
                    '<td><input type="hidden" name="is_active[]" value="1" />' +
                    '<input type="checkbox" checked="checked" class="flat is_active fch"></td>' +
                    '<td colspan="2" class="ln-height"><span class="source" style="cursor:pointer;">Feature Heading</span>' +
                    '<input type="hidden" value="' + element_name + '-title" name="element_name[]" style="width:25px;">' +
                    '<input type="hidden" value="' + element_name + '" name="parent_element_name[]" style="width:25px;">' +
                    '<input type="hidden" value="' + data_point_id + '" name="data_point_id[]" style="width:25px;">' +
                    '<input type="hidden" value="' + data_point_category + '" name="data_point_category[]" style="width:25px;">' +
                    '<input class="form-control cord_x" type="hidden" value="' + left_def + '" name="cord_x[]" maxlength="6">' +
                    '<input class="form-control cord_y" type="hidden" value="' + top_def + '" name="cord_y[]"  maxlength="6">' +
                    '</td>' +
                    '<td  class="valing-middle">Text' +
                    '   <input type="hidden" value="2" name="element_type[]" style="width:25px;">' +
                    '</td>' +
                    '<td>' +
                    '   <span class="dssettings-parent">' +
                    '      <input type="text"  class="ds-fontpick" name="font_settings[]" value=\'\'>' +
                    ' </span>' +
                    ' <span class="dscolorpick-parent">' +
                    '     <input type="text" class="ds-colorpick" name="color[]" value=\'\'>' +
                    ' </span>' +
                    ' <span class="dssettings-parent">' +
                    '     <input type="text" data-feature="title" class="ds-settings" ';

            html += ' data-makereadonly="true" ';

            html += ' data-element_type="2" name="settings[]" value=\'\'>' +
                    '</td>' +
                    '  </tr>';


            html += '<tr data-source="' + element_name + '-icon" class="active">' +
                    '<td><input type="hidden" name="is_active[]" value="1" />' +
                    '<input type="checkbox" checked="checked" class="flat is_active fch"></td>' +
                    '<td colspan="2" class="ln-height"><span class="source" style="cursor:pointer;">Feature Icon</span>' +
                    '<input type="hidden" value="' + element_name + '-icon" name="element_name[]" style="width:25px;">' +
                    '<input type="hidden" value="' + element_name + '" name="parent_element_name[]" style="width:25px;">' +
                    '<input type="hidden" value="' + data_point_id + '" name="data_point_id[]" style="width:25px;">' +
                    '<input type="hidden" value="' + data_point_category + '" name="data_point_category[]" style="width:25px;">' +
                    '<input class="form-control cord_x" type="hidden" value="' + left_def + '" name="cord_x[]" maxlength="6">' +
                    '<input class="form-control cord_y" type="hidden" value="' + top_def + '" name="cord_y[]"  maxlength="6">' +
                    '</td>' +
                    '<td class="valing-middle">Image' +
                    '   <input type="hidden" value="1" name="element_type[]" style="width:25px;">' +
                    '</td>' +
                    '<td>' +
                    '   <span class="dssettings-parent">' +
                    '      <input type="text" readonly  class="ds-fontpick" name="font_settings[]" value=\'\'>' +
                    ' </span>' +
                    ' <span class="dscolorpick-parent" >' +
                    '     <input type="text" readonly class="ds-colorpick" name="color[]" value=\'\'>' +
                    ' </span>' +
                    ' <span class="dssettings-parent">' +
                    '     <input type="text" data-feature="icon" class="ds-settings" ';

            html += ' data-makereadonly="true" ';

            html += ' data-element_type="2" name="settings[]" value=\'\'>' +
                    '</td>' +
                    '  </tr>';
            html += '<tr data-source="' + element_name + '-description" class="active">' +
                    '<td><input type="hidden" name="is_active[]" value="1" />' +
                    '<input type="checkbox" checked="checked" class="flat is_active fch"></td>' +
                    '<td colspan="2" class="ln-height"><span class="source" style="cursor:pointer;">Feature Description</span>' +
                    '<input type="hidden" value="' + element_name + '-description"" name="element_name[]" style="width:25px;">' +
                    '<input type="hidden" value="' + element_name + '" name="parent_element_name[]" style="width:25px;">' +
                    '<input type="hidden" value="' + data_point_id + '" name="data_point_id[]" style="width:25px;">' +
                    '<input type="hidden" value="' + data_point_category + '" name="data_point_category[]" style="width:25px;">' +
                    '<input class="form-control cord_x" type="hidden" value="' + left_def + '" name="cord_x[]" maxlength="6">' +
                    '<input class="form-control cord_y" type="hidden" value="' + top_def + '" name="cord_y[]"  maxlength="6">' +
                    '</td>' +
                    '<td class="valing-middle">Text' +
                    '   <input type="hidden" value="2" name="element_type[]" style="width:25px;">' +
                    '</td>' +
                    '<td>' +
                    '   <span class="dssettings-parent">' +
                    '      <input type="text" class="ds-fontpick" name="font_settings[]" value=\'\'>' +
                    ' </span>' +
                    ' <span class="dscolorpick-parent">' +
                    '     <input type="text" class="ds-colorpick" name="color[]" value=\'\'>' +
                    ' </span>' +
                    ' <span class="dssettings-parent">' +
                    '     <input type="text" data-feature="description"  class="ds-settings" ';

            html += ' data-makereadonly="true" ';
            html += ' data-element_type="2" name="settings[]" value=\'\'>' +
                    '</td>' +
                    '  </tr>' +
                    '  <tr><td colspan="5" style="border-left:1px solid #fff;border-right:1px solid #fff;">&nbsp;</td></tr>';

        }
        $('[data-source]').removeClass('active');
        var html_ele = $(html);


        $('[data-step="' + num + '"]').find('tbody').append(html_ele);

        if (element_type == 3) {
            html_ele.find('.ds-settings').dssettings({
                'dsdefaultcontent': element_name,
                'element_type': element_type,
                'dsmaxheight': 200
            });
            html_ele.find('.ds-fontpick').dsfontpick({});
            html_ele.find('.ds-colorpick').dscolorpick({});
        } else if (element_type == 4) {
            html_ele.find('.ds-settings').each(function () {
                var content = "features";
                var width = 300;
                var height = 350;
                if ($(this).data('feature') == "description") {
                    content = 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.';
                    width = 200;
                    height = 80;
                }
                if ($(this).data('feature') == "title") {
                    content = 'Title.';
                    width = 300;
                    height = 30;
                }
                if ($(this).data('feature') == "icon") {
                    content = 'ICON';
                    width = 80;
                    height = 80;
                }
                $(this).dssettings({
                    'dsdefaultcontent': content,
                    dsmaxwidth: width,
                    dsmaxheight: height
                });

            });
            html_ele.find('.ds-fontpick').each(function () {
                $(this).dsfontpick({});
            });
            html_ele.find('.ds-colorpick').each(function () {
                $(this).dscolorpick({});
            });
        } else {
            html_ele.find('.ds-settings').dssettings({
                'dsdefaultcontent': element_name,
                'element_type': element_type
            });
            html_ele.find('.ds-fontpick').dsfontpick({});
            html_ele.find('.ds-colorpick').dscolorpick({});
        }



        $('.canvas_elements').removeClass('selected');

        if (element_type == 2 || element_type == 5 || element_type == 6) {
            var text = $('<div class="canvas_text canvas_elements selected" data-layer="' + element_name + '"><span>' + element_name + '</span></div>');
        } else if (element_type == 1) {
            var text = $('<div class="canvas_image canvas_elements selected" data-layer="' + element_name + '"><span> Image </span></div>');
        } else if (element_type == 3) {
            var bullet = '<div class="canvas_text canvas_elements selected" data-layer="' + element_name + '"><span><ul>';
            for (il = 1; il <= 3; il++) {
                bullet += '<li>Bullet Item ' + il + '</li>';
            }
            bullet += '</ul></span></div>';
            var text = $(bullet);
        } else if (element_type == 4) {

            var features = '<div class="canvas_text canvas_elements selected" data-layer="' + element_name + '">';

            var c_feature = $.parseJSON(company_features);

            $.each(c_feature, function (i, v) {
                features += '<div class="relative clearfix" ><div class="canvas_text canvas_child_elements" data-layer="' + element_name + '-title"><span>' + v.feature_title + '</span></div>' +
                        '<div class="clearfix"><div class="pull-left canvas_child_elements" data-layer="' + element_name + '-icon" style="border:1px dashed #f5f5f5;width:50px;height:20px; margin-right:8px; bottom:5px;"><span data-svg="' + SITE_URL + 'assets/images/icons/' + v.feature_icon + '"></span></div>' +
                        '<div class="canvas_child_elements" data-layer="' + element_name + '-description"><span>' + v.feature_description + '</span></div></div>' +
                        '</div>';
            });


            features += '</div>';
            var text = $(features);
        }
        html_ele.find('.is_active').iCheck({
            checkboxClass: 'icheckbox_flat-blue'
        }).on('ifUnchecked', function () {
            $(this).parent('div').siblings('input').val(0);
            text.hide();
            if($(this).hasClass('fch')){
                    $('[data-step="' + current_step + '"]').find('.feature_ch').prop('checked', false);
                    $('[data-step="' + current_step + '"]').find('.feature_ch').iCheck('update');
            }
            $('[data-step="' + current_step + '"]').find('.check_all').prop('checked', false);
            $('[data-step="' + current_step + '"]').find('.check_all').iCheck('update');
            if(element_name=='Features'){
                $('[data-step="' + current_step + '"]').find('.fch').prop('checked', false);
                $('[data-step="' + current_step + '"]').find('.fch').iCheck('update');                
            }
//            $('[data-step="' + current_step + '"]').find('.fch').prop('checked', false);
//            $('[data-step="' + current_step + '"]').find('.fch').iCheck('update');
//
//            $('[data-step="' + current_step + '"]').find('.feature_ch').prop('checked', false);
//            $('[data-step="' + current_step + '"]').find('.feature_ch').iCheck('update');
        }).on('ifChecked', function () {
            $(this).parent('div').siblings('input').val(1);
            text.show();
            
            if(element_name=='Features'){
                $('[data-step="' + current_step + '"]').find('.fch').prop('checked', true);
                $('[data-step="' + current_step + '"]').find('.fch').iCheck('update');                
            }
            if($(this).hasClass('fch')){
                $('[data-step="' + current_step + '"]').find('.feature_ch').prop('checked', true);
                $('[data-step="' + current_step + '"]').find('.feature_ch').iCheck('update');
            }
            if ($('[data-step="' + current_step + '"]').find('.is_active').filter(':checked').length == $('[data-step="' + current_step + '"]').find('.is_active').length) {
                $('[data-step="' + current_step + '"]').find('.check_all').prop('checked', true);
                $('[data-step="' + current_step + '"]').find('.check_all').iCheck('update');
            }
//            $('[data-step="' + current_step + '"]').find('.fch').prop('checked', true);
//            $('[data-step="' + current_step + '"]').find('.fch').iCheck('update');
//            $('[data-step="' + current_step + '"]').find('.feature_ch').prop('checked', true);
//            $('[data-step="' + current_step + '"]').find('.feature_ch').iCheck('update');

        });

        i = k;
        canvas.append(text);
        $('[data-svg]').each(function (i, v) {
            var that = $(this);
            var id = 'canvas' + i;
            $(this).load($(this).data('svg'), function () {
                svgText = that.html();

                $.post(SITE_URL + 'template/svgtopng', {'svg_content': svgText, 'swidth': 60, 'sheight': 60}, function (res) {
                    that.html('<img src="' + res + '" style="width:' + 60 + ';height:' + 60 + '">');
                });
            });
            //  return false;
        });

        top_def = top_def + 50;
        if (top_def > (canvas.height() - 80)) {
            top_def = 40;
            left_def = left_def + 400;
        }
        $('[data-source="' + element_name + '"]').find('input, select').each(function () {
            $(this).change().blur();
        })
        $('.ds-default-content').keyup();
        $('.ds-max-width').keyup();
        init_elements();
    }

    function drawInlineSVG(ctx, rawSVG, callback) {

        var svg = new Blob([rawSVG], {type: "image/svg+xml;charset=utf-8"}),
                domURL = self.URL || self.webkitURL || self,
                url = domURL.createObjectURL(svg),
                img = new Image;

        img.onload = function () {
            ctx.drawImage(this, 0, 0);
            domURL.revokeObjectURL(url);
            callback(this);
        };

        img.src = url;

    }
    var SX = 0,
            SY = 0;
    function init_elements() {
        var text = $('.canvas_elements');
        text.draggable({
            containment: canvas,
            start: function (event) {
                SX = event.clientX;
                SY = event.clientY;
            },
            drag: function (event, ui) {
                var ratio = zoom / 100;
                var original = ui.originalPosition;
                ui.position = {
                    left: (event.clientX - SX + original.left) / ratio,
                    top: (event.clientY - SY + original.top) / ratio
                };
                var pos = ui.position;

                if (pos.left <= 0)
                    pos.left = 0;
                if (pos.top <= 0)
                    pos.top = 0;
                ui_height = ui.helper.outerHeight();
                ui_width = ui.helper.outerWidth();
                if ((pos.top + ui_height) >= canvas.height())
                    pos.top = canvas.height() - ui_height;
                if ((pos.left + ui_width) >= canvas.width())
                    pos.left = canvas.width() - ui_width;



                $('[data-source="' + $(this).data('layer') + '"]').find('.cord_x').val((pos.left).toFixed(2));
                $('[data-source="' + $(this).data('layer') + '"]').find('.cord_y').val((pos.top).toFixed(2));
            }
        });
        text.resizable({
            // handles: ' n, e, s, w, ne, se, sw, nw',
            resize: function (event, ui) {
                var zoomScale = zoom / 100;
                var changeWidth = ui.size.width - ui.originalSize.width; // find change in width
                var newWidth = ui.originalSize.width + changeWidth / zoomScale;

                var changeHeight = ui.size.height - ui.originalSize.height; // find change in height
                var newHeight = ui.originalSize.height + changeHeight / zoomScale;

                ui.size.width = newWidth;
                ui.size.height = newHeight;

                var width = ui.size.width;
                var height = ui.size.height;
                $('[data-settingsource="' + $(this).data('layer') + '"]').find('.ds-max-width').val(width).change();
                $('[data-settingsource="' + $(this).data('layer') + '"]').find('.ds-max-height').val(height).change();
            }
        });
        text.mousedown(function () {
            active = $(this).data('layer');
            $('[data-source]').removeClass('active');
            $('[data-source="' + active + '"]').addClass('active');
            text.removeClass('selected');
            $(this).addClass('selected');
        });
        canvas.mouseup(function (e) {
            if (!text.is(e.target) // if the target of the click isn't the container...
                    && text.has(e.target).length === 0) // ... nor a descendant of the container
            {
                text.removeClass('selected');
                $('[data-source]').removeClass('active');
            }
        });
    }
    function remove_element(source) {
        $('[data-source="' + source + '"]').remove();
        $('[data-layer="' + source + '"]').remove();
    }
    $(function () {
        $('.is_active').on('ifUnchecked', function () {
            
            $(this).parent('div').siblings('input').val(0);
            var layer = $(this).parents('[data-source]').data('source');
           
            if($(this).hasClass('fch')){
                $('[data-layer="Features"]').hide();
                    $('[data-step="' + current_step + '"]').find('.feature_ch').prop('checked', false);
                    $('[data-step="' + current_step + '"]').find('.feature_ch').iCheck('update');
                    
                    $('[data-step="' + current_step + '"]').find('.fch').prop('checked', false);
                    $('[data-step="' + current_step + '"]').find('.fch').iCheck('update');
            }
            else {
                 $('[data-layer="' + layer + '"]').hide();
            }
            $('[data-step="' + current_step + '"]').find('.check_all').prop('checked', false);
            $('[data-step="' + current_step + '"]').find('.check_all').iCheck('update');
                    if(layer=='Features'){
                     $('[data-step="' + current_step + '"]').find('.fch').prop('checked', false);
                     $('[data-step="' + current_step + '"]').find('.fch').iCheck('update'); 
                    }
//             $('[data-step="' + current_step + '"]').find('.fch').prop('checked', false);
//             $('[data-step="' + current_step + '"]').find('.fch').iCheck('update');
//             
//             $('[data-step="' + current_step + '"]').find('.feature_ch').prop('checked', false);
//             $('[data-step="' + current_step + '"]').find('.feature_ch').iCheck('update');

        });
        $('.is_active').on('ifChecked', function () {
            $(this).parent('div').siblings('input').val(1);
            var layer = $(this).parents('[data-source]').data('source');
            
          
             if(layer=='Features'){
                $('[data-step="' + current_step + '"]').find('.feature_ch').prop('checked', true);
                $('[data-step="' + current_step + '"]').find('.feature_ch').iCheck('update'); 
                
                 $('[data-step="' + current_step + '"]').find('.fch').prop('checked', true);
                $('[data-step="' + current_step + '"]').find('.fch').iCheck('update');
            }
             if($(this).hasClass('fch')){
                $('[data-layer="Features"]').show();
                $('[data-step="' + current_step + '"]').find('.feature_ch').prop('checked', true);
                $('[data-step="' + current_step + '"]').find('.feature_ch').iCheck('update');
                
                $('[data-step="' + current_step + '"]').find('.fch').prop('checked', true);
                $('[data-step="' + current_step + '"]').find('.fch').iCheck('update');
            }
            else{
                $('[data-layer="' + layer + '"]').show();
            }
              if ($('[data-step="' + current_step + '"]').find('.is_active').filter(':checked').length == $('[data-step="' + current_step + '"]').find('.is_active').length) {
                $('[data-step="' + current_step + '"]').find('.check_all').prop('checked', true);
                $('[data-step="' + current_step + '"]').find('.check_all').iCheck('update');
            }
//             $('[data-step="' + current_step + '"]').find('.fch').prop('checked', true);
//             $('[data-step="' + current_step + '"]').find('.fch').iCheck('update');
//             $('[data-step="' + current_step + '"]').find('.feature_ch').prop('checked', true);
//             $('[data-step="' + current_step + '"]').find('.feature_ch').iCheck('update');
        });

//        $('.feature_ch').on('ifChecked', function () {
//             $(this).parent('div').siblings('input').val(1);
//              $('[data-layer="Features"]').show();
//              $('[data-step="' + current_step + '"]').find('.fch').prop('checked', true);
//             $('[data-step="' + current_step + '"]').find('.fch').iCheck('update');
////             $('[data-step="' + current_step + '"]').find('.feature_ch').prop('checked', true);
////             $('[data-step="' + current_step + '"]').find('.feature_ch').iCheck('update');
//        });
//         $('.feature_ch').on('ifUnchecked', function () {
//              $(this).parent('div').siblings('input').val(0);
//              $('[data-layer="Features"]').hide();
//    //             $('[data-step="' + current_step + '"]').find('.feature_ch').prop('checked', false);
//    //             $('[data-step="' + current_step + '"]').find('.feature_ch').iCheck('update'); 
//             $('[data-step="' + current_step + '"]').find('.fch').prop('checked', false);
//             $('[data-step="' + current_step + '"]').find('.fch').iCheck('update');
//        });

        $('a').click(function (e)
        {
            if ($(this).attr('href') == '#')
                e.preventDefault();
        });
        $('.add_element').click(function () {
            if (current_step == 2) {
                var element_name = $('#name1').val();
                var element_type = $('#type1').val();
                $('#name1').val('');
            } else if (current_step == 3) {
                var element_name = $('#name').val();
                var element_type = $('#type').val();
                $('#name').val('');
            }
            if (element_type == 4 && company_features.length <= 0) {
                alert("your company do not have any features in profile.");
                return false;
            }
            add_element(element_name, element_type, current_step, 0);

        })
        //canvas.css('zoom', zoom+'%' );
        canvas.css('transform-origin', 'top left');
        canvas.css('transform', ' scale(' + zoom / 100 + ')');



        $("#slider").slider({
            animate: true,
            range: "min",
            min: 10,
            max: 100,
            step: 5,
            value: zoom,
            slide: function (event, ui) {
                zoom = ui.value;
                //canvas.css('zoom', ui.value+'%' );
                canvas.css('transform', ' scale(' + ui.value / 100 + ')');
            }
        });

        $(document).on('change keyup', '.cord_x', function () {
            var x = $(this).val();
            var source = $(this).parents('[data-source]').data('source');
            $('[data-layer="' + source + '"]').css('left', x + 'px');
        })
        $(document).on('change keyup', '.cord_y', function () {
            var y = $(this).val();
            var source = $(this).parents('[data-source]').data('source');
            $('[data-layer="' + source + '"]').css('top', y + 'px');
        })
        $(document).on('change', '.ds-colorpick', function () {
            var clr = $(this).val();
            var source = $(this).parents('[data-source]').data('source');
            $('[data-layer="' + source + '"]').css('color', clr);
        })
        $(document).on('change', '.ds-fontpick', function () {
            var font_settings = $(this).val();
            var obj = JSON.parse(font_settings);
            var source = $(this).parents('[data-source]').data('source');

            $('[data-layer="' + source + '"]').css('font-size', (obj.dsfontsize * (dpi / 72)) + 'px');
            $('[data-layer="' + source + '"]').css('text-align', obj.dsalign);
            if (typeof obj.dsfont != 'undefined') {
                var font = obj.dsfont;
                $('[data-layer="' + source + '"]').css('font-family', font.replace(/\+/g, ' '));
            }
            if (typeof obj.dstextheight != 'undefined') {
                var dstextheight = obj.dstextheight;
                $('[data-layer="' + source + '"] span').css('line-height', dstextheight + 'px');
            }
            if (typeof obj.dstextwidth != 'undefined') {
                var dstextwidth = obj.dstextwidth;
                $('[data-layer="' + source + '"] span').css('letter-spacing', dstextwidth + 'px');
            }
            if (typeof obj.dsbold != 'undefined') {
                $('[data-layer="' + source + '"] span').css('font-weight', 'bold');
            } else {
                $('[data-layer="' + source + '"] span').css('font-weight', 'normal');
            }
            if (typeof obj.dsunderline != 'undefined') {
                $('[data-layer="' + source + '"] span').css('text-decoration', 'underline');
            } else {
                $('[data-layer="' + source + '"] span').css('text-decoration', 'none');
            }
            if (typeof obj.dsstrikethrough != 'undefined') {
                $('[data-layer="' + source + '"]').css('text-decoration', 'line-through');
                //var strike = '<strike>'+$('[data-layer="'+source+'"] span').text()+'<strike>';
                //$('[data-layer="'+source+'"] span').html(strike);
            } else {
                $('[data-layer="' + source + '"]').css('text-decoration', 'none');
                //var strike = $('[data-layer="'+source+'"] span').text();
                //$('[data-layer="'+source+'"] span').html(strike);
            }
            if (typeof obj.dsitalic != 'undefined') {
                $('[data-layer="' + source + '"]').css('font-style', 'italic');
            } else {
                $('[data-layer="' + source + '"]').css('font-style', 'normal');
            }
            //font streching
            var dstexthstrech = 1,
                    dstextvstrech = 1;
            if (typeof obj.dstextvstrech != 'undefined') {
                if (obj.dstextvstrech >= 1)
                    dstextvstrech = obj.dstextvstrech;
            }
            if (typeof obj.dstexthstrech != 'undefined') {
                if (obj.dstexthstrech >= 1)
                    dstexthstrech = obj.dstexthstrech;
            }
            var trans = 'scale(' + dstexthstrech + ',' + dstextvstrech + ')';
            $('[data-layer="' + source + '"] span').css('display', 'block');
            //$('[data-layer="'+source+'"] span').css('text-align', 'center');
            $('[data-layer="' + source + '"] span').css('transform', trans);
            $('[data-layer="' + source + '"] span').css('-webkit-transform', trans);
        })
        $(document).on('change', '.ds-settings', function () {
            var settings = $(this).val();
            var obj = JSON.parse(settings);
            var source = $(this).parents('[data-source]').data('source');
            if (obj.dselement_type == 3) {
                var content = obj.dsdefaultcontent;
                var bullet_type = obj.dsbullettype;
                var li_html = '';
                content = content.replace(/\r?\n/g, '-___-');
                var res = content.split('-___-');

                if (bullet_type == '1' || bullet_type == 1) {
                    var num = 1;
                } else if (bullet_type == 'disc') {
                    var num = '&bull;';
                } else if (bullet_type == 'circle') {
                    var num = '&#9900;';
                } else if (bullet_type == 'square') {
                    var num = '&#9755;';
                } else {
                    var num = '&bull;';
                }
                content = '<ul class="nobullet">';
                $.each(res, function (i, v) {
                    if (bullet_type == '1' || bullet_type == 1) {
                        content += '<li><span class="dsbullet">' + num + '.</span> ' + v + '</li>';
                        num++;
                    } else {
                        content += '<li><span class="dsbullet">' + num + '</span> ' + v + '</li>';
                    }
                })
                content += '</ul>';
                $('[data-layer="' + source + '"] span').html(content);
            } else {
                $('[data-layer="' + source + '"] span').text(obj.dsdefaultcontent);
            }

            $('[data-layer="' + source + '"]').css('max-width', obj.dsmaxwidth + 'px');
            $('[data-layer="' + source + '"]').css('min-width', obj.dsmaxwidth + 'px');
            $('[data-layer="' + source + '"]').css('max-height', obj.dsmaxheight + 'px');
            $('[data-layer="' + source + '"]').css('min-height', obj.dsmaxheight + 'px');
        })
        $(document).on('click', '.source', function () {
            //alert(1);
            var layer = $(this).parents('[data-source]').data('source');
            $('[data-layer]').removeClass('selected');
            $('[data-layer="' + layer + '"]').addClass('selected');
            $('[data-source]').removeClass('active');
            $('[data-source="' + layer + '"]').addClass('active');
        })


        var $cache = $('.template_preview');
        w_stuck = $cache.width();
        //store the initial position of the element
        var vTop = $cache.offset().top - parseFloat($cache.css('margin-top').replace(/auto/, 0));
        $(window).on('resize, scroll', function (event) {
            // what the y position of the scroll is
            var y = $(this).scrollTop();

            // whether that's below the form
            if (y >= vTop && window.innerWidth >= 767) {
                // if so, ad the fixed class
                $cache.addClass('stuck');
                $cache.css('width', w_stuck + 'px');
            } else {
                // otherwise remove it
                $cache.removeClass('stuck');
                $cache.css('width', 'auto');
            }
        }).resize(function () {
            w_stuck = $cache.width();
        });
//        $('.ds-settings').dssettings({
//                'dsdefaultcontent': element_name,
//                'element_type': element_type
//            });
    })

    $(function () {
<?php if (!$edit) { ?>
            $('[data-source],[data-layer]').remove();
<?php } ?>
        $(document).ready(function () {
            $(window).keydown(function (event) {
                if (event.keyCode == 13 && (event.target.nodeName != "TEXTAREA" && event.target.nodeName != "textarea")) {
                    event.preventDefault();
                    return false;
                }
            });
        });
        init_elements();
        $('[data-source]').find('input, select').each(function () {
            $(this).change().blur();
        })

        $('.check_all').on('ifUnchecked', function () {
            $(this).parents('table').children('tbody').find('.is_active').iCheck('uncheck');
        }).on('ifChecked', function () {
            $(this).parents('table').children('tbody').find('.is_active').iCheck('check');
        });

        $('.prev3').click(function () {
            $('[data-step="3"]').hide();
            $('[data-step="2"]').show();
            $('#step2').hide();
            $('#nextstep').removeClass('hide');
        });
        $('#nextstep').click(function () {
            $('[data-step="2"]').hide();
            $('[data-step="3"]').show();
            $('#nextstep').addClass('hide');
        });
    });

    function show_step(num) {
        $('#errormsg').removeClass('show');
        $("#errormsg").addClass("hide");
        if (num == 2) {

            if ($('#width').val() == '') {
                if ($("#errormsg").hasClass("hide")) {
                    $("#errormsg").removeClass("hide");
                    $("#errormsg").text('Please upload a valid file to continue.');
                    window.scroll(0, 0);
                }
            }

            var form = $("#step-1");
            form.validate();
            if (form.valid() == false) {
                return;
            }
            else {
                $('#step1').text('Loading');
                $('#step1').prop('disabled', true);
                $('.chosen-container').removeClass('qtip-custom');
                $(".input_disabled").prop('disabled', false);
            }


            $.post(SITE_URL + 'template/update_template', $('#step-1').serialize(), function (data) {


<?php if (!$edit || ($template_elements == false && !$template_elements)) { ?>
                    data_points = JSON.parse(data);
                    //$('[data-source],[data-layer]').remove();
                    $.each(data_points.template_data_points, function (i, v) {
                        if (v.data_category == '1') {
                            add_element(v.data_name, v.data_type, num, v.id, v.readonly);
                        }
                    });
                    $('#custom_template_id').val(data_points.id);
                    $('#notify').val(data_points.notify_check);
<?php } ?>
                $("#step_num").text(num);
                $('.file-upload').hide();
                $('[data-step]').hide();
                $('[data-step="' + num + '"]').show();

                $('.progress-bar').css('width', '66.66%');
                $('.steps-count').text('STEP 2 OF 3');

            });
        }
        if (num == 3) {
            $('#step2').text('Loading');
            $('#step2').prop('disabled', true);
<?php if (!$edit || ($template_elements == false && !$template_elements)) { ?>
                $.each(data_points.template_data_points, function (i, v) {
                    if (v.data_category == '2') {
                        if (v.data_type == 4 && company_features.length <= 0) {

                        }
                        else if (v.data_type == 5 && v.data_type == 6 && company_heading == '') {

                        } else {
                            add_element(v.data_name, v.data_type, num, v.id, v.readonly);
                        }
                    }
                });
<?php } ?>
            $("#step_num").text(num);
            $('[data-step]').hide();
            $('[data-step="' + num + '"]').show();
            $('.progress-bar').css('width', '100%');
            $('.steps-count').text('STEP 3 OF 3');

        }
        current_step = num;

    }

    function download(value) {
        $('#savedraft').val(value);
        if (value == '1') {
            bootbox.confirm({
                buttons: {
                    confirm: {
                        label: 'Continue'
                                //className: 'confirm-button-class'
                    },
                    cancel: {
                        label: 'Cancel'
                                //className: 'cancel-button-class'
                    }
                },
                message: 'Do you really want to publish template? Once it publish you cannot able to edit the template.',
                callback: function (result) {
                    if (result == true) {
                        savetemplate();
                    }
                },
                title: 'Create Custom Template'
            });
        } else {
            savetemplate();
        }

    }
    function savetemplate() {


        var link = $('<a id="dwnld"></a>');
        var clone = $(".canvas").clone();
        clone.css('zoom', '100%');
        clone.css('transform-origin', 'top left');
        clone.css('transform', ' scale(1)');
        //            clone.css('top','-1000px');
        //    clone.css('position','absolute');
        clone.children('.canvas_image').each(function (i, v) {
            if ($(this).children('img').length == 0) {
                $(this).remove();
            } else {
                $(this).css('border', 'none');
            }
        });
        clone.children('.canvas_text').each(function (i, v) {
            var source = $(this).data('layer');
            if ($.trim($('[data-source="' + source + '"]').find('input').val()) == '' && $('[data-source="' + source + '"]').length != 0) {
                $(this).remove();
            }
        });
        clone.children('.canvas_elements').css('border', 'none');
        clone.children('.canvas_child_elements').css('border', 'none');
        clone.find('.ui-resizable-handle, .bleed').remove();
        clone.appendTo("body");
        link.appendTo("body");

        html2canvas(clone, {
            onrendered: function (canvas) {
                var theCanvas = canvas;
                document.body.appendChild(canvas);
                clone.remove();
                var filetype = 'jpeg';
                if (filetype == 'jpeg') {
                    var link = document.getElementById('dwnld');
                    link.href = theCanvas.toDataURL("image/jpeg", 1.0);
                    $("#dataimgcontent").val(theCanvas.toDataURL("image/jpeg", 1.0));
                    //link.download = 'image.jpeg';
                    // link.click();
                    theCanvas.parentNode.removeChild(canvas);

                    $('#save_template_frm').submit();
                    link.remove();
                }

            }

        });

    }
//      $(function(){
//        $(document).ajaxSend(function(event, jqXHR, settings) {
//        
//        $('.wholepageloader').remove();
//            $('body').append('<div class="wholepageloader" style="background-image:url(<?php echo base_url(); ?>assets/images/bg.png);position:fixed;top:0; height: 100%;width: 100%;z-index:999999;"><i class="fa fa-cog fa-spin" style="margin-left: 50%;margin-top: 25%;color: #fff;font-size: 40px;"></i></div>');
//        });
//
//        $(document).ajaxComplete(function(event, jqXHR, settings) {
//            $('.wholepageloader').remove();
//        });
//    });
    $(document).on("click", function (event) {
        var $trigger = $(".font-select");
        if ($trigger !== event.target && !$trigger.has(event.target).length) {
            $(".fs-drop").slideUp();
            $(".font-select").removeClass("font-select-active");
        }
    });

</script>
<script src="<?php echo JS_URL; ?>file_upload.js"></script>
<script type="text/javascript" src="<?php echo JS_URL; ?>svgtopng/rgbcolor.js"></script>
<script type="text/javascript" src="<?php echo JS_URL; ?>svgtopng/StackBlur.js"></script>
<script type="text/javascript" src="<?php echo JS_URL; ?>svgtopng/canvg.js"></script>
