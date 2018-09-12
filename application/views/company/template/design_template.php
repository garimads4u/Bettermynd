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
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="alert alert-danger hide" id="errormsg"></div>
    <div class="clearfix">&nbsp;</div>
    <div class="row">
        <div class="col-md-5 col-sm-5">
            <div class="template_preview">
                <h3>TEMPLATE PREVIEW</h3>
                <div class="template_view" style="min-height:450px;">
<!--               	    <img src="images/default-template.png" width="534" height="689"  alt=""/>-->


                    <div id="slider" style="display:none;"><input type="hidden" id="hidden"/></div>
                    <span class="loading-img" style="display:none;"><img src="<?php echo IMAGES_URL; ?>loading.gif"><br>LOADING...</span>
                    <div class="canvas_overflow">
                        <div class="canvas" style="position: relative;">
                            <div class="layer1"></div>
                            <div class="layer2" id='layer2'></div>
                            <div class="logo"></div>
                            <div class="layer3"></div>
                        </div>


                    </div>
                </div>
                <div class="progress-box">
                    <div id="myProgressbar" class="progress">
                        <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 33.33%;">
                            <span class="sr-only">0% Complete</span>
                        </div>
                    </div>
                    <div class="steps-count">STEP 1 OF 3</div>
                </div>
            </div>

        </div>
        <div class="col-md-7 col-sm-7">
            <form action="<?php echo TEMPLATE_URL; ?>save_design_theme" id="save_theme_frm" method="post">
                 <input type="hidden" name='c_compnay_id' id="c_compnay_id" value="<?php echo $company_details['company_id']; ?>">
                <div class="clearfix">
                    <div data-step="1" class="step1">

                        <div class="clearfix">
                            <h2 class="design_steps">STEP 1 <span>SELECT YOUR TEMPLATE TYPE, SIZE AND THEME OPTIONS.</span></h2>
                            <!--<a href="#" class="pull-right mar-top8"><img src="<?php echo IMAGES_URL; ?>question_icon.png" width="21" height="20"  alt=""/></a>-->
                        </div>
                        <div class="white_box">
                            <div class="row">
                                    <!--<div class="col-sm-1"><label><input type="checkbox" class="flat" checked="checked"></label></div>-->
                                <div class="col-sm-6"><div class="form-group">
                                        <label class="control-label" for="type">Type <span class="mandatory" style="font-size:14px !important;"> * </span></label>
                                        <?php
                                        $options = $template_types;
                                        $selected = isset($template_data) && !empty($template_data) && $edit && $template_data[0]->type_id ? $template_data[0]->type_id : '';
                                        $attr = 'class="form-control chosen-select" id="template_type" onchange="getsizes();"';
                                        echo form_dropdown('template_type', $options, $selected, $attr);
                                        
                                        
                                        ?>


                                    </div></div>

                                <div class="col-sm-6"><div class="form-group">
                                        <label class="control-label" for="size">Size <span class="mandatory" style="font-size:14px !important;"> * </span></label>
                                        <select class="form-control chosen-select" id="template_size" name="template_size" tabindex="-1" data-width="100%" >
                                            <option value="">Select Size</option>
                                            <?php
                                            if ($edit) {
                                                foreach ($theme_size as $template_type1) {
                                                    $selected = " ";
                                                    if ($theme_arr['size_id'] == $template_type1['size_id'])
                                                        $selected = " selected='selected' ";
                                                    echo '<option ' . $selected . ' value="' . $template_type1['size_id'] . '">' . $template_type1['display_size'] . '</option>';
                                                }
                                            }
                                            ?>
                                        </select>

                                    </div></div>
                              <?php  
                                    if($edit) { 
                                        $checked = isset($template_data[0]) && $template_data[0]->print_bleed == "1" ? "checked='checked'" : '';
                                    } else{
                                        $checked = "";
                                    }?>
                            
                                <div class="col-sm-12  mar-top8">
                                    <label>
                                        <input type="checkbox" class="flat" id="print_bleed" name='print_bleed' value='1' <?php echo $checked;?>>
                                       Add Print Bleed?</label>
                                </div>
                           
                            </div>
                        </div>
                        <div class="x_panel">
                            <div class="row">
                            <!--<div class="col-sm-1"><label><input type="checkbox" checked="checked" class="flat"></label></div>-->
                                <div class="col-xs-12">
                                    <div class="form-group">
                                        <label for="title">Title <span class="mandatory" style="font-size:14px !important;"> * </span></label>
                                        <input type="text" class="form-control" id="title" name="title" placeholder="" value="<?php echo (isset($template_data) && !empty($template_data[0]) && $template_data[0]->title ? $template_data[0]->title : ''); ?>">
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <label for="title" class="control-label">Group(s) <span class="mandatory" style="font-size:14px !important;"> * </span></label>
                                                <?php
                                                $options = $groups;
                                                $selected = isset($template_data) && !empty($template_data) && $edit && $template_data[0]->t_group_id ? explode(',', $template_data[0]->t_group_id) : '';
                                                $attr = 'class="groups_dropdown form-control" multiple="multiple" required="required" ';
                                                echo form_dropdown('groups[]', $options, $selected, $attr);
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-xs-12">
                                            <label class="control-label hidden-xs ">&nbsp;</label>
                                            <label><input type="checkbox" class="flat" checked="checked" name='notify_check' value='1'> Notify User Groups of New Template after Saving.</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea class="form-control" name="description" maxlength="250"><?php echo (isset($template_data) && !empty($template_data[0]) && $template_data[0]->description ? $template_data[0]->description : ''); ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div >
                            <div class="detected-size">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-6 col-md-5">
                                        <label class="control-label">Choose a Theme</label>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-6">
                                        <select class="form-control chosen-select" tabindex="-1" data-width="100%" id="theme_type" name="theme_type" onchange="load_theme();">
                                            <option value="">Select Theme</option>
                                            <?php
                                            if ($edit) {
                                                foreach ($mst_themes as $template_type2) {
                                                    $selected = " ";
                                                    if ($theme_arr['theme_id'] == $template_type2->id)
                                                        $selected = " selected='selected' ";
                                                    echo '<option ' . $selected . ' value="' . $template_type2->id . '">' . $template_type2->theme_name . '</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="x_panel" id="theme_properties"  style="display:none;">
                                <div class="row">
                                    <div class="col-md-4 col-sm-12"><label class="control-label">Theme Colors</label></div>
                                    <div class="col-md-8 col-sm-12">
                                        <div class="color_pic"><span>1</span>
        <!--                                    <span class="color_box" style="background-color:rgba(255,0,0,1)"></span>-->
                                            <span class="dscolorpick-parent">
                                                <input type="text" id="color1" name="color1" class="ds-colorpick" name="color[]" value="">
                                            </span></div>
                                        <div class="color_pic"><span>2</span>
            <!--                                <span class="color_box" style="background-color:rgba(0,255,0,1)"></span>-->
                                            <span class="dscolorpick-parent">
                                                <input type="text" id="color2" name="color2" class="ds-colorpick" name="color[]" value="" >
                                            </span></div>
                                        <div class="color_pic"><span>3</span>
            <!--                                <span class="color_box" style="background-color:rgba(0,0,255,1)"></span>-->
                                            <span class="dscolorpick-parent">
                                                <input type="text" id="color3" name="color3" class="ds-colorpick" name="color[]" value="" >
                                            </span></div>
                                        <div class="color_pic"><span>4</span>
            <!--                                <span class="color_box" style="background-color:rgba(0,0,0,1)"></span>-->
                                            <span class="dscolorpick-parent">
                                                <input type="text" id="color4" name="color4" class="ds-colorpick" name="color[]" value="" >
                                            </span></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label class="control-label">Main Photo</label>
                                        <div class="input-group" style="z-index: 0;" onclick="upload_bg();">

                                            <input type="text" class="form-control" id="bgtext" readonly placeholder="Browse">

                                            <input type="hidden" id="bg_url" name="bg_url" class="form-control" readonly>
                                            <input type="hidden" id="bg_height" name="bg_height" class="form-control" readonly>
                                            <input type="hidden" id="bg_width" name="bg_width" class="form-control" readonly>
                                            <input type="hidden" id="bg_left" name="bg_left" class="form-control" readonly>
                                            <input type="hidden" id="bg_top" name="bg_top" class="form-control" readonly>

                                            <span class="input-group-btn">
                                                <span class="btn btn-primary btn-file">
                                                    Upload
                                                </span>
                                            </span>

                                        </div></div>
                                    <div class="col-sm-6">
                                        <label class="control-label">Logo</label>
                                        <div class="input-group" style="z-index: 0;" onclick="upload_logo();">
                                            <input type="text" class="form-control" id="logotext" readonly placeholder="Browse">

                                            <input type="hidden" id="logo_url" name="logo_url" class="form-control" readonly>
                                            <input type="hidden" id="logo_height" name="logo_height" class="form-control" readonly>
                                            <input type="hidden" id="logo_width" name="logo_width" class="form-control" readonly>
                                            <input type="hidden" id="logo_left" name="logo_left" class="form-control" readonly>
                                            <input type="hidden" id="logo_top" name="logo_top" class="form-control" readonly>

                                            <span class="input-group-btn">
                                                <span class="btn btn-primary btn-file">
                                                    Upload
                                                </span>
                                            </span>

                                        </div></div>
                                </div>
                                <!--                    <div class="row">
                                                        <div class="col-lg-3 col-md-12"><label class="control-label">Pattern Image</label></div>
                                                         <div class="col-sm-9"><div class="input-group" style="z-index: 0;">
                                                        <input type="text" class="form-control" readonly placeholder="Browse">
                                                <span class="input-group-btn">
                                                    <span class="btn btn-primary btn-file">
                                                        Upload <input type="file" multiple>
                                                    </span>
                                                </span>

                                            </div></div>
                                                    </div>-->
                                <div class="row">
                                    <div class="col-sm-6"><label class="control-label">Font Family</label>
                                        <div class="form-group">
                                            <input id="font1" name="font1" type="text" >
                                        </div>
                                    </div>
                                    <div class="col-sm-6"><label class="control-label">Font Family 2</label>
                                        <div class="form-group">
                                            <input id="font2" name="font2" type="text">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 col-sm-12"><label class="control-label">Export File Types</label></div>
                                    <div class="col-md-8 col-sm-12">
                                        <label><input type="checkbox" class="flat" checked="checked" name="pdf"> PDF</label> &nbsp;
                                        <label><input type="checkbox" class="flat" checked="checked" name="jpeg"> JPEG</label>  &nbsp;
                                        <label><input type="checkbox" class="flat" checked="checked" name="png"> PNG</label> &nbsp;
        <!--                                <label><input type="checkbox" class="flat" checked="checked" name="gif"> GIF</label> &nbsp; -->
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-3 pull-right">
                                        <a href="#" class="btn btn-primary pull-right" onclick="show_step(2);">Next</a>  <input type="button" class="btn btn-primary pull-right hide" id="nextstep" value="Next">
                                    <input type="hidden" name="temp_elements" id="temp_elements">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="step2" data-step="2" style="display:none;">
                        <div class="clearfix">
                            <h2>STEP 2 <span>Personalization Options</span></h2>
                            <!--<a href="#" class=" mar-top8 pull-right"><img src="<?php // echo IMAGES_URL; ?>question_icon.png" width="21" height="20"  alt=""/></a>-->
                        </div>
                        <div class="white_box">
                            <div class="row">
                                <div class="col-sm-9">
                                    <p>Below are default personalization data for this Template Type. Editable in your <a href="<?php echo COMPANY_URL . 'company_profile' ?>" target="_blank">Company Profile</a>. You can add more data below.</p>
                                </div>
                                <!--                        <div class="col-sm-2 col-xs-offset-1">
                                                                <select class="select2_single form-control" tabindex="-1" data-width="100%"><option>1</option><option>2</option><option>10</option></select>
                                                        </div>-->
                            </div>
                            <div class="my_table table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" class="flat check_all" ></th>
                                            <th>Title</th>
                                            <th>Type</th>
                                            <th>Position</th>
                                            <th>Options</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>

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
                                <div class="col-sm-3 col-xs-12">
                                    <a href="javascript:void(0);" class="add_element btn btn-default pull-right">Add New</a>
                                </div>
                                <div class="col-sm-2 pull-right">
                                    <a href="javascript:void(0);" class="btn btn-primary pull-right" onclick="show_step(3);">NEXT</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="step3" data-step="3" style="display:none;">
                        <div class="clearfix">
                            <h2>STEP 3 <span>TEMPLATE CONTENT</span></h2>
                            <a href="#" class=" mar-top8 pull-right"><img src="<?php echo IMAGES_URL; ?>question_icon.png" width="21" height="20"  alt=""/></a>
                        </div>
                        <div class="white_box">
                            <div class="row">
                                <div class="col-sm-9">
                                    <p>Below are default personalization data for this Template Type. Editable in your <a href="<?php echo COMPANY_URL . 'company_profile' ?>" target="_blank">Company Profile</a>. You can add more data below.</p>
                                </div>
                                <!--                        <div class="col-sm-2 col-xs-offset-1">
                                                                <select class="select2_single form-control" tabindex="-1" data-width="100%"><option>1</option><option>2</option><option>10</option></select>
                                                        </div>-->
                            </div>
                            <div class="my_table table-responsive">
                                <table class="table table-bordered" >
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" class="flat check_all"></th>
                                            <th>Title</th>
                                            <th>Type</th>
                                            <th>Position</th>
                                            <th>Options</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                            <div class="row">
                                <div class="col-sm-4 col-xs-12">
                                    <div class="form-group">
                                        <input type="text" value="" id="name" class="form-control pull-left" placeholder="Name">
                                    </div>
                                </div>
                                <div class="col-sm-4 col-xs-12">
                                    <div class="form-group">
                                        <select id="type" class="form-control pull-left">
                                            <option value="1">Image</option>
                                            <option value="2">Text</option>
                                            <option value="3">Bullet</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-2 col-xs-12">
                                    <a href="javascript:void(0);" class="add_element btn btn-default pull-left">Add New</a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="clearfix register-buttons">
                    <input  type="button"  class="btn btn-primary prev3 hide" value="Prev">
                    <input type="button" id='btnsubmit' class="btn btn-primary hide"  value="Save Draft" onclick="download('0')">
                    <input type="button" id='btnsubmit_1' class="btn btn-primary hide"  value="Save Template" onclick="download('1')">
                    <input type="hidden" id="dataimgcontent" name="dataimgcontent">
                    <input type="hidden" id="savedraft" name="savedraft">
                    <input type="hidden" id="template_id_edit" name="template_id_edit" value="<?php echo isset($edit) && $edit != "" ? $edit : '' ?>">
                </div>
            </form>
        </div>
    </div>
</div>
<form action="<?php echo TEMPLATE_URL; ?>custom_template_file_upload"  method="post" enctype="multipart/form-data" style="display:none;">
    <input type="file" name="FileInput" id="FileInput" multiple style="opacity:0;">
</form>
<div class="modal fade" id="image_edit_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Edit Image</h4>
            </div>
            <div class="modal-body">

                <div style="border:1px solid #000; margin-top: 10px;" id="edit_image1"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="apply_image_changes">Apply changes</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<div class="modal fade" id="page_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Select Page</h4>
            </div>
            <div class="modal-body">
                <div id="message_page"></div>
                <select id="select_page">

                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="apply_page_changes">Apply changes</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div> 
<style>
    .canvas{
        overflow:hidden;
    }
    .bleed{
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
        margin: -29px 0px 0 -2px;
        position: absolute;
        color: #000;
        cursor:pointer;
    }
    .style_canvas{
        position: absolute;
    }
    .layer2, .layer3{
        position: absolute;
    }
    .layer1, .logo{
        position: absolute;
       
    }
    .canvas_elements{
        position: absolute;
        cursor: pointer;
        overflow:hidden;
        min-height:100px;
        min-width:100px;
        max-height:100px;
        max-width:100px;
        outline: 1px dotted #333;
    }
    /*.canvas_elements.selected:after {
        content: "x";
        font-family: arial;
        color: #000;
        position: absolute;
        top:0;right:0;
    }*/
    .canvas_elements.selected{
        outline:1px dashed #ccc;
        cursor:move;
    }
    .canvas_child_elements{
        cursor: pointer;
        font-size:auto;
        overflow:hidden;
        border: 1px dotted #333;
    }
    .canvas_image{
        border: 1px solid #666;
    }
    .canvas_image{
        border: 1px solid #666;
    }
    .layer1 img{
        max-width:none;
    }
    .logo img{
        max-width:none;
        height:50px;
    }
    .template_preview.stuck {
        position:fixed;
        top:0;
    }
    tr[data-source="Features"]{ background:#f5f5f5}
</style>

<canvas id="canvas" style="display:none;"></canvas>
<script>

    var company_features = '<?php echo json_encode($company_feature); ?>';
    var company_bullets = '<?php echo $company_bullets; ?>';
    var company_logo = '<?php echo $company_logo; ?>';
    var company_features_1 = '<?php echo base64_encode(str_replace(" ", "|-|", json_encode($company_feature))); ?>';
    var company_heading = '<?php echo $company_heading; ?>';
    var company_heading_1 = '<?php echo str_replace(" ", "|-|", $company_heading); ?>';
    var canvas = $('.canvas');
    var bleed = $('.bleed');
    var bleedsize = 38;//px
    var zoom = 55;
    var dpi = 72;
    var current_step = 1;
    var upload_type = '';
    var myCanvas = document.getElementsByTagName("canvas")[0];
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
    
   
    $('#print_bleed').on('ifChecked', function () {
       $('.bleed').show();

    });
    $('#print_bleed').on('ifUnchecked', function () {
         $('.bleed').hide();
    });
    $(function () {
          
        $('[data-step="2"],[data-step="3"]').hide();
        $("#color1").change(function () {
            $('.color1').css('fill', $(this).val());
        });
        $("#color2").change(function () {
            $('.color2').css('fill', $(this).val());
        });
        $("#color3").change(function () {
            $('.color3').css('fill', $(this).val());
        });
        $("#color4").change(function () {
            $('.color4').css('fill', $(this).val());
        });
        // canvas.css('zoom', zoom+'%' );
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

        $('#template_size').change(function () {
            size = $('#template_size').val();
            type = $('#template_type').val();
            if (size == '') {
                $('#theme_type').html('<option value="">Select Theme</option>');
                $("#theme_type").trigger("chosen:updated").change();

                return false;
            }
            $.post(SITE_URL + 'template/get_themes', {'size': size, 'type': type}, function (res) {
                $('#theme_type').html(res);
                //            $("#theme_type").select2({
                //            // placeholder: "Select a state",
                //                allowClear: true
                //            });
                $("#theme_type").trigger("chosen:updated");
            });
        });

        $(document).on('change keyup', '.cord_x', function () {
            var x = $(this).val();
            var source = $(this).parents('[data-source]').data('source');
            $('[data-layer="' + source + '"]').css('left', x + 'px');
        });
        $(document).on('change keyup', '.cord_y', function () {
            var y = $(this).val();
            var source = $(this).parents('[data-source]').data('source');
            $('[data-layer="' + source + '"]').css('top', y + 'px');
        });
        $(document).on('change', '.ds-colorpick', function () {
            var clr = $(this).val();
            var source = $(this).parents('[data-source]').data('source');

            $('[data-layer="' + source + '"]').css('color', clr);
        });
        $(document).on('change', '.ds-fontpick', function () {
            var font_settings = $(this).val();
            var obj = JSON.parse(font_settings);
            var source = $(this).parents('[data-source]').data('source');
            $('[data-layer="' + source + '"]').css('font-size', (obj.dsfontsize * dpi / 72) + 'px');
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
        });
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
                //                if(bullet_type=='1' || bullet_type=='A' || bullet_type=='a' || bullet_type=='i' || bullet_type=='I')
                //                    content='<ol type="'+bullet_type+'">';
                //                else
                //                    content='<ul type="'+bullet_type+'">';
                //                $.each(res,function(i,v){
                //                    content += '<li>'+v+'</li>';
                //                })
                //                if(bullet_type=='1' || bullet_type=='A' || bullet_type=='a' || bullet_type=='i' || bullet_type=='I')
                //                    content+='</ol>';
                //                else
                //                    content+='</ul>';

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
                });
                content += '</ul>';
                $('[data-layer="' + source + '"] span').html(content);
            } else {
                $('[data-layer="' + source + '"] span').text(obj.dsdefaultcontent);
            }

            $('[data-layer="' + source + '"]').css('max-width', obj.dsmaxwidth + 'px');
            $('[data-layer="' + source + '"]').css('min-width', obj.dsmaxwidth + 'px');
            $('[data-layer="' + source + '"]').css('max-height', obj.dsmaxheight + 'px');
            $('[data-layer="' + source + '"]').css('min-height', obj.dsmaxheight + 'px');
        });
        $(document).on('click', '.source', function () {
            //alert(1);
            var layer = $(this).parents('[data-source]').data('source');
            $('[data-layer]').removeClass('selected');
            $('[data-layer="' + layer + '"]').addClass('selected');
            $('[data-source]').removeClass('active');
            $('[data-source="' + layer + '"]').addClass('active');
        });
    });
    function upload_bg() {
        upload_type = 'bg';
        $('#FileInput').click();
    }
    function upload_logo() {
        upload_type = 'logo';
        $('#FileInput').click();
    }
    function getsizes() {
        val = $('#template_type').val();
        if (val == '') {
            $('#template_size').html('<option value="">Select Size</option>');
            $('#theme_type').html('<option value="">Select Theme</option>');
            //        $("#template_size, #theme_type").select2({
            //        // placeholder: "Select a state",
            //            allowClear: true
            //        });
            $("#theme_type").trigger("liszt:updated");

            return false;
        }
        $.post(SITE_URL + 'template/get_sizes', {'type': val}, function (res) {
            $('#template_size').html(res);
            $('#theme_type').html('<option value="">Select Theme</option>');
            //        $("#template_size, #theme_type").select2({
            //        // placeholder: "Select a state",
            //            allowClear: true
            //        });

            $("#template_size").trigger("chosen:updated");


        });
    }
    var elements = [];
   
    function load_theme(edit) {
         $("#temp_elements").val('0');
        if (typeof edit == 'undefined') {
            edit = false;
        } else {
            edit = true;
        }
        theme_size_id = $('#theme_type').val();
        $('#theme_properties').hide();
        $('.canvas').html('<div class="layer1"></div><div class="layer2" id="layer2"></div><div class="logo"></div><div class="layer3"></div><div class="bleed"><span class="safetyline"  data-toggle="tooltip" title="Anything outside of the safety line may be trimmed off in the printing process">Safety Line</span></div>');
        bleed = $('.bleed');
        if (!edit) {
            post_data = {'theme_size_id': theme_size_id};
        } else {
            post_data = {'theme_size_id': theme_size_id, 'template_id': '<?php echo isset($edit) ? $edit : 0; ?>'};
        }
        if (theme_size_id == '') {
            return false;
        }
        $('.loading-img').show();
        $.post(SITE_URL + 'template/load_theme', post_data, function (data) {
            data = JSON.parse(data);
           if(data.template_elements.length > 0){
               $("#temp_elements").val('1');
           }
            dpi = data.dpi;
            $('.canvas_child_elements').css('font-size', (14 * (dpi / 72)) + 'px');
            if(data.unit == 'in') {
            h = data.height * data.dpi;
            w = data.width * data.dpi;
            }
            else{
            h = data.height;
            w = data.width;
            }
            $('#bgtext, #logotext').val('');
            canvas.css('height', h + 'px');
            canvas.css('width', w + 'px');
            //bleedsize = bleedsize * (dpi / 72);
            bleed.css('width', (w - (bleedsize * 2)) + 'px');
            bleed.css('height', (h - (bleedsize * 2)) + 'px');
            bleed.css('margin-left', bleedsize + 'px');
            bleed.css('margin-top', bleedsize + 'px');
            <?php if ($edit && isset($template_data) && $template_data[0]->print_bleed == "1") {
        ?>
               bleed.show(); 
        <?php
    } else {
        ?>
                bleed.hide();    
    <?php }
    ?>
            myCanvas.width = w;
            myCanvas.height = h;
            $img_container = $('.layer1');
            $logo_container = $('.logo');
            $.post(SITE_URL + 'template/get_s3url', {'filename': data.default_bg}, function (res) {
                 $img = $('<img src="' + res + '">');
                 $img_container.html($img);
            });
            if(data.default_bg.indexOf('artwork/')>=0){
                myurl=SITE_URL +'assets/' + data.default_bg;
            }
            else{
                myurl=SITE_URL +'assets/upload/templates/' + data.default_bg;
            }
//            $img = $('<img src="' + myurl + '" style="width:' + data.bg_width + 'px;height:' + data.bg_height + 'px">');
//            $img_container.html($img);
            $('#bg_url').val(data.default_bg);
            $img_container.css('height', data.bg_height + 'px');
            $img_container.css('width', data.bg_width + 'px');
            $img_container.css('left', data.bg_x + 'px');
            $img_container.css('top', data.bg_y + 'px');
            $('#bg_width').val(data.bg_width);
            $('#bg_left').val(data.bg_x);
            $('#bg_height').val(data.bg_height);
            $('#bg_top').val(data.bg_y);
            $logo_img = $('<img src="' + SITE_URL + 'assets/logo/' + company_logo + '" style="height:' + data.logo_height + 'px">');
            $('#logo_url').val(company_logo);
            $logo_container.html($logo_img);
            
            $logo_container.css('left', data.logo_x + 'px');
            $logo_container.css('top', data.logo_y + 'px');
            $("#logo_width").val(data.logo_width);
            $("#logo_height").val(data.logo_height);
            $("#logo_left").val(data.logo_x);
            $("#logo_top").val(data.logo_y);
            $('#color1').val(data.color1).change();
            $('#color1').siblings('button').css('color', data.color1);
            $('#color2').val(data.color2).change();
            $('#color2').siblings('button').css('color', data.color2);
            $('#color3').val(data.color3).change();
            $('#color3').siblings('button').css('color', data.color3);
            $('#color4').val(data.color4).change();
            $('#color4').siblings('button').css('color', data.color4);
            $('.layer2').html(data.art_work_url_content);
            $('.layer2 svg').css('transform-origin', 'top left');
            $('.layer2 svg').css('transform', 'scale(' + w / $('svg').attr("width") + ', ' + h / $('svg').attr("height") + ')');

            $('#theme_properties').show();
            $('#slider').show();
            elements = [];
            $('[data-step="1"], [data-step="2"]').find('tbody').html('');

            $.each(data.template_elements, function (i, v) {
                if (v.data_type == 4 && JSON.parse(company_features).length <= 0) {

                }
                else if (v.data_type == 5 && JSON.parse(company_heading).length <= 0) {

                } else {

                    add_element(v);
                    if (!edit) {
                        post_data = {'id': v.id, 'theme_size_id': theme_size_id};
                    } else {
                        post_data = {'id': v.id, 'theme_size_id': theme_size_id, 'template_id': '<?php echo isset($edit) ? $edit : 0; ?>'};
                    }
                    if (v.element_type == 4) {
                        $.post(SITE_URL + 'template/get_theme_child_elements', post_data, function (result) {
                            result = JSON.parse(result);
                            $.each(result, function (i, vk) {
                                $.each(vk, function (i, v) {
                                    source = v.element_name;
                                    set = JSON.parse(v.settings);
                                    delete set.dsdefaultcontent
                                    $('[data-source="' + source + '"]').find('.ds-fontpick').val(v.font_settings).change();
                                    $('[data-source="' + source + '"]').find('.ds-settings').val(JSON.stringify(set)).change();
                                    $('[data-source="' + source + '"]').find('.ds-colorpick').val(v.color).change();
                                });
                            });
                        });
                    }
                }


            });
            $('#color1').trigger('change');
            $('#color2').trigger('change');
            $('#color3').trigger('change');
            $('#color4').trigger('change');
            $('.loading-img').hide();
            //$('[data-step="2"],[data-step="3"]').show();
            $('#print_bleed').prop('disabled', false);
            $('#print_bleed').iCheck('update');

        });
    }


    var top_def = 0,
            left_def = 0;
    function add_element(element) {

        //element = JSON.parse(element);

        var element_name = element.element_name;
        element_name = element_name.replace(/^\s+|\s+$/g,"");
        var element_type = element.element_type;
        var num = 2;
        var data_point_id = element.data_point_id;
        var font_settings = '';
        var settings = '';
        var color = '';
        var visible = 1;
        if (typeof element.is_active != 'undefined') {
            if (element.is_active == 0) {
                visible = 0;
            }
        }
        if (typeof element.cord_x != 'undefined') {
            left_def = element.cord_x;
        }
        if (typeof element.cord_y != 'undefined') {
            top_def = element.cord_y;
        }
        if (typeof element.data_point_category != 'undefined') {
            data_point_category = element.data_point_category;
            num = parseInt(data_point_category) + 1;
        } else {
            if (num == 2) {
                data_point_category = 1;
            } else {
                data_point_category = 2;
            }
        }

        if (typeof element.font_settings != 'undefined') {
            font_settings = element.font_settings;
        }
        if (typeof element.settings != 'undefined') {
            settings = element.settings;
        }
        if (typeof element.color != 'undefined') {
            color = element.color;
        }
        if (typeof data_point_id == 'undefined') {
            data_point_id = 0; // other
        }
        if ($.trim(element_name) == '') {
            $("#errormsg").text('Please enter element name.');
            $("#errormsg").removeClass("hide");
            $("#errormsg").addClass("show");
            window.scroll(0, 0);

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

        var element_type_name = element_type == '1' ? 'image' : 'text';
        element_type_name = element_type == '3' ? 'bullet' : element_type_name;
        i++;
        active = i;
        var k = i;
        if (element_type != 4) {
            var html = '<tr data-source="' + element_name + '" class="active">' +
                    '<td><input type="hidden" name="is_active[]" value="' + visible + '" />';
            if (visible) {
                html += '<input type="checkbox" checked="checked" class="flat is_active"></td>';
            } else {
                html += '<input type="checkbox" class="flat is_active"></td>';
            }

            html += '<td><span class="source" style="cursor:pointer;">' + element_name + '</span>' +
                    '<input type="hidden" value="' + element_name + '" name="element_name[]" style="width:25px;">' +
                    '<input type="hidden" value="" name="parent_element_name[]" style="width:25px;">' +
                    '<input type="hidden" value="' + data_point_id + '" name="data_point_id[]" style="width:25px;">';
            if (element_type == 5 && company_heading != "") {
                html += '<input type="hidden" value=' + company_heading_1 + ' name="company_heading" >';
            }
            html += '<input type="hidden" value="' + data_point_category + '" name="data_point_category[]" style="width:25px;">' +
                    '</td>' +
                    '<td>' + element_type_name +
                    '   <input type="hidden" value="' + element_type + '" name="element_type[]" style="width:25px;">' +
                    '</td>' +
                    '<td><div class=" position_controls">' +
                    '   <input class="form-control cord_x" type="text" value="' + left_def + '" name="cord_x[]" ><span>X</span>' +
                    ' <input class="form-control cord_y" type="text" value="' + top_def + '" name="cord_y[]"  ><span>Y</span>' +
                    '</div></td>' +
                    '<td>' +
                    '   <span class="dssettings-parent">' +
                    '      <input type="text" class="ds-fontpick" name="font_settings[]" value=\'' + font_settings + '\'>' +
                    ' </span>' +
                    ' <span class="dscolorpick-parent">' +
                    '     <input type="text" class="ds-colorpick" name="color[]" value=\'' + color + '\'>' +
                    ' </span>' +
                    ' <span class="dssettings-parent">' +
                    '     <input type="text" class="ds-settings"  data-element_type="' + element_type + '" name="settings[]" value=\'' + settings + '\'>' +
                    //            ' </span><span style="cursor:pointer;" onclick="remove_element(\''+element_name+'\')"><i class="fa fa-times"></i></span>'+
                    '</td>' +
                    '  </tr>';
        } else {
            var html = '<tr><td colspan="5" style="border-left:1px solid #fff;border-right:1px solid #fff;">&nbsp;</td></tr>';
            html += '<tr data-source="' + element_name + '" class="active">' +
                    '<th ><input type="hidden" name="is_active[]" value="1" />' +
                    '<input type="checkbox" checked="checked" class="flat is_active feature_ch"></th>' +
                    '<th colspan="3"><span class="source" style="cursor:pointer;">' + element_name + '</span>' +
                    '<input type="hidden" value="' + element_name + '" name="element_name[]" style="width:25px;">' +
                    '<input type="hidden" value=' + company_features_1 + ' name="company_feature" >' +
                    '<input type="hidden" value="" name="parent_element_name[]" style="width:25px;">' +
                    '<input type="hidden" value="' + data_point_id + '" name="data_point_id[]" style="width:25px;">' +
                    '<input type="hidden" value="' + data_point_category + '" name="data_point_category[]" style="width:25px;">' +
                    '<input class="form-control cord_x" type="hidden" value="' + left_def + '" name="cord_x[]" >' +
                    '<input class="form-control cord_y" type="hidden" value="' + top_def + '" name="cord_y[]"  >' +
                    '<input type="hidden" value="' + element_type + '" name="element_type[]" style="width:25px;">' +
                    '</th>' +
                    '<th>' +
                    '   <span class="dssettings-parent">' +
                    '      <input type="text" class="ds-fontpick" name="font_settings[]" value=\'' + font_settings + '\'>' +
                    ' </span>' +
                    ' <span class="dscolorpick-parent">' +
                    '     <input type="text" class="ds-colorpick" name="color[]" value=\'' + color + '\'>' +
                    ' </span>' +
                    ' <span class="dssettings-parent">' +
                    '     <input type="text" class="ds-settings" ';

            html += ' data-makereadonly="true" ';

            html += ' data-element_type="' + element_type + '" name="settings[]" value=\'' + settings + '\'>' +
//            ' </span><span style="cursor:pointer;" onclick="remove_element(\''+element_name+'\')"><i class="fa fa-times"></i></span>'+
                    '</th>' +
                    '  </tr>';

            html += '<tr data-source="' + element_name + '-title" class="active">' +
                    '<td><input type="hidden" name="is_active[]" value="1" />' +
                    '<input type="checkbox" checked="checked" class="flat is_active fch"></td>' +
                    '<td colspan="2"><span class="source" style="cursor:pointer;">Feature Heading</span>' +
                    '<input type="hidden" value="' + element_name + '-title" name="element_name[]" style="width:25px;">' +
                    '<input type="hidden" value="' + element_name + '" name="parent_element_name[]" style="width:25px;">' +
                    '<input type="hidden" value="' + data_point_id + '" name="data_point_id[]" style="width:25px;">' +
                    '<input type="hidden" value="' + data_point_category + '" name="data_point_category[]" style="width:25px;">' +
                    '<input class="form-control cord_x" type="hidden" value="' + left_def + '" name="cord_x[]" >' +
                    '<input class="form-control cord_y" type="hidden" value="' + top_def + '" name="cord_y[]"  >' +
                    '</td>' +
                    '<td>Text' +
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
                    '<td colspan="2"><span class="source" style="cursor:pointer;">Feature Icon</span>' +
                    '<input type="hidden" value="' + element_name + '-icon" name="element_name[]" style="width:25px;">' +
                    '<input type="hidden" value="' + element_name + '" name="parent_element_name[]" style="width:25px;">' +
                    '<input type="hidden" value="' + data_point_id + '" name="data_point_id[]" style="width:25px;">' +
                    '<input type="hidden" value="' + data_point_category + '" name="data_point_category[]" style="width:25px;">' +
                    '<input class="form-control cord_x" type="hidden" value="' + left_def + '" name="cord_x[]" >' +
                    '<input class="form-control cord_y" type="hidden" value="' + top_def + '" name="cord_y[]"  >' +
                    '</td>' +
                    '<td>Image' +
                    '   <input type="hidden" value="1" name="element_type[]" style="width:25px;">' +
                    '</td>' +
                    '<td>' +
                    '   <span class="dssettings-parent">' +
                    '      <input type="text"  readonly class="ds-fontpick" name="font_settings[]" value=\'\'>' +
                    ' </span>' +
                    ' <span class="dscolorpick-parent">' +
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
                    '<td colspan="2"><span class="source" style="cursor:pointer;">Feature Description</span>' +
                    '<input type="hidden" value="' + element_name + '-description"" name="element_name[]" style="width:25px;">' +
                    '<input type="hidden" value="' + element_name + '" name="parent_element_name[]" style="width:25px;">' +
                    '<input type="hidden" value="' + data_point_id + '" name="data_point_id[]" style="width:25px;">' +
                    '<input type="hidden" value="' + data_point_category + '" name="data_point_category[]" style="width:25px;">' +
                    '<input class="form-control cord_x" type="hidden" value="' + left_def + '" name="cord_x[]" >' +
                    '<input class="form-control cord_y" type="hidden" value="' + top_def + '" name="cord_y[]"  >' +
                    '</td>' +
                    '<td>Text' +
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
        //


        //

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
            var c_feature = JSON.parse(company_features);

            $.each(c_feature, function (i, vf) {
                features += '<div class="relative canvas_child_elements clearfix" ><div class="canvas_text" data-layer="' + element_name + '-title"><span>' + vf.feature_title + '</span></div>' +
                        '<div class="clearfix"><div class="pull-left canvas_child_elements" data-layer="' + element_name + '-icon" style="border:1px dashed #f5f5f5;width:50px;height:20px; margin-right:8px; bottom:5px;"><span data-svg="' + SITE_URL + 'assets/images/icons/' + vf.feature_icon + '"></span></div>' +
                        '<div class="canvas_child_elements" data-layer="' + element_name + '-description"><span>' + vf.feature_description + '</span></div></div>' +
                        '</div>';
            });

            features += '</div>';
            var text = $(features);
        }

        html_ele.find('.is_active').iCheck({
            checkboxClass: 'icheckbox_flat-blue'
        }).on('ifUnchecked', function () {
            $(this).parents('div').siblings('input').val(0);
            text.hide();
            $('[data-step="' + current_step + '"]').find('.check_all').prop('checked', false);
            $('[data-step="' + current_step + '"]').find('.check_all').iCheck('update');

            $('[data-step="' + current_step + '"]').find('.fch').prop('checked', false);
            $('[data-step="' + current_step + '"]').find('.fch').iCheck('update');

            $('[data-step="' + current_step + '"]').find('.feature_ch').prop('checked', false);
            $('[data-step="' + current_step + '"]').find('.feature_ch').iCheck('update');
        }).on('ifChecked', function () {
            $(this).parents('div').siblings('input').val(1);
            text.show();
            if ($('[data-step="' + current_step + '"]').find('.is_active').filter(':checked').length == $('[data-step="' + current_step + '"]').find('.is_active').length) {
                $('[data-step="' + current_step + '"]').find('.check_all').prop('checked', true);
                $('[data-step="' + current_step + '"]').find('.check_all').iCheck('update');
            }

            $('[data-step="' + current_step + '"]').find('.fch').prop('checked', true);
            $('[data-step="' + current_step + '"]').find('.fch').iCheck('update');
            $('[data-step="' + current_step + '"]').find('.feature_ch').prop('checked', true);
            $('[data-step="' + current_step + '"]').find('.feature_ch').iCheck('update');

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
        if (!visible) {
            text.hide();
        }

        if (element_type == 3) {
            html_ele.find('.ds-colorpick').dscolorpick({});
            html_ele.find('.ds-fontpick').dsfontpick({});
            html_ele.find('.ds-settings').dssettings({
                'dsdefaultcontent': element_name,
                'element_type': element_type,
                'dsmaxheight': 200
            });
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
                var dsfontsize = 18;
                var textheight = 25;
                if ($(this).data('feature') == "description") {
                    dsfontsize = 14;
                    textheight = 18;
                }
                $(this).dsfontpick({
                    dsfontsize: dsfontsize,
                    textheight: textheight
                });
            });
            html_ele.find('.ds-colorpick').each(function () {
                $(this).dscolorpick({});
            });
        } else {

            html_ele.find('.ds-colorpick').dscolorpick({});
            html_ele.find('.ds-fontpick').dsfontpick({});
            html_ele.find('.ds-settings').dssettings({
                'dsdefaultcontent': element_name,
                'element_type': element_type
            });

        }
        $('[data-source="' + element_name + '"]').find('input, select').each(function () {
            $(this).change();
        });
        $('.ds-default-content').keyup();

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
                // ratio = (1/ratio)-1;
                //                var offset = $(this).offset();
                //                var xPos = offset.left;
                //                var yPos = offset.top;
                //                var pos = ui.position;
                //                pos.left += (pos.left-SX)*ratio;
                //                pos.top += (pos.top-SY)*ratio;

                var original = ui.originalPosition;

                // jQuery will simply use the same object we alter here
                ui.position = {
                    left: (event.clientX - SX + original.left) / ratio,
                    top: (event.clientY - SY + original.top) / ratio
                };
                var pos = ui.position;

                if (pos.left < 0)
                    pos.left = 0;
                if (pos.top < 0)
                    pos.top = 0;
                ui_height = ui.helper.outerHeight();
                ui_width = ui.helper.outerWidth();
                if ((pos.top + ui_height) >= canvas.height())
                    pos.top = canvas.height() - ui_height;
                if ((pos.left + ui_width) >= canvas.width())
                    pos.left = canvas.width() - ui_width;


                //                $('[data-source="'+$(this).data('layer')+'"]').find('.cord_x').val(xPos-canvas.offset().left);
                //                $('[data-source="'+$(this).data('layer')+'"]').find('.cord_y').val(yPos-canvas.offset().top);
                //                $('[data-source="'+$(this).data('layer')+'"]').find('.cord_x').val(xPos);
                //                $('[data-source="'+$(this).data('layer')+'"]').find('.cord_y').val(yPos);
                $('[data-source="' + $(this).data('layer') + '"]').find('.cord_x').val((pos.left).toFixed(2));
                $('[data-source="' + $(this).data('layer') + '"]').find('.cord_y').val((pos.top).toFixed(2));
                //                $('[data-layer="'+$(this).data('layer')+'"]').css('left', xPos+'px');
                //                $('[data-layer="'+$(this).data('layer')+'"]').css('top', yPos+'px');
            }
        });
        text.resizable({
            // handles: ' n, e, s, w, ne, se, sw, nw',

            resize: function (event, ui) {
                var zoomScale = zoom / 100;
                var changeWidth = ui.size.width - ui.originalSize.width; // find change in width
                var newWidth = ui.originalSize.width + changeWidth / zoomScale; // adjust new width by our zoomScale

                var changeHeight = ui.size.height - ui.originalSize.height; // find change in height
                var newHeight = ui.originalSize.height + changeHeight / zoomScale; // adjust new height by our zoomScale

                ui.size.width = newWidth;
                ui.size.height = newHeight;

                var width = ui.size.width;
                var height = ui.size.height;

//                $('[data-source="' + $(this).data('layer') + '"]').find('.ds-max-width').val(width).change();
//                $('[data-source="' + $(this).data('layer') + '"]').find('.ds-max-height').val(height).change();
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

    function show_step(num) {
        $('#errormsg').removeClass('show');
        $("#errormsg").addClass("hide");
        if (num == 2) {
            var form = $("#save_theme_frm");
            form.validate();
            if (form.valid() == false ) {
                
                return false;
            }
             else if ($("#temp_elements").val()=='0') {
                
                        $("#errormsg").removeClass("hide");
                        $("#errormsg").text('There has not any element defined for selected size '+$("#template_size option:selected").text()+' in this theme.');
                        window.scroll(0, 0);
               
                return false;
            }
            else {
                $('#errormsg').removeClass('show');
                $("#errormsg").addClass("hide");
                $('.chosen-container').removeClass('qtip-custom');
            }
            $('.progress-bar').css('width', '66.66%');
            $('.steps-count').text('STEP 2 OF 3');
        }
        if (num == 3) {
            $('.progress-bar').css('width', '100%');
            $('.steps-count').text('STEP 3 OF 3');
            $('#btnsubmit').removeClass('hide');
            $('#btnsubmit_1').removeClass('hide');
            $('.prev3').removeClass('hide');

        }
        $("#step_num").text(num);
        $('[data-step]').hide();
        $('[data-step="' + num + '"]').show();
        current_step = num;

    }
    //image croping from image area select jquery
    var img_x_height = 0;
    var img_x_width = 0;
    var img_x_top = 0;
    var img_x_left = 0;
    function setImage1(url, val) {
        imgpath = url;
        url = SITE_URL + 'assets/upload/templates/' + url;
        var img_x = $('<img>');
        var img1 = $('<img>');
        var active_crop = false;
        var img_container = $('.layer1');
        var img_container2 = $('#edit_image1');
        img_container2.html('');
        img_x.attr('src', url);
        img1.attr('src', url);
        var maskWidth = img_container.width();
        var maskHeight = img_container.height();
        img1.css('width', '568px');
        img_x.css('position', 'absolute');

        $('#apply_image_changes').unbind('click');
        $('#apply_image_changes').bind('click', function () {
            $('#bgtext').val(val);
            active_crop = false;
            img_container.html(img_x);
            img_container.css('border', 'none');
            img_container.css('text-align', 'left');
            $('#image_edit_modal').modal('hide');
            $("#bg_url").val(imgpath);
            $("#bg_width").val(img_x_width);
            $("#bg_height").val(img_x_height);
            $("#bg_left").val(img_x_left);
            $("#bg_top").val(img_x_top);
        })

        img_container2.html(img1);
        $('#image_edit_modal').modal('show');

        $('#image_edit_modal').unbind('hidden.bs.modal').on('hidden.bs.modal', function () {
            $('[class*=imgareaselect]').remove();
        })
        $('#image_edit_modal').unbind('shown.bs.modal').on('shown.bs.modal', function () {

            var scaleX = maskWidth / (maskWidth || 1);
            var scaleY = maskHeight / (maskHeight || 1);
            img_x_height = Math.round(scaleY * img1.height());
            img_x_width = Math.round(scaleX * img1.width());
            img_x_top = Math.round(scaleY * 0);
            img_x_left = Math.round(scaleX * 0);
            img_x.css({
                width: img_x_width + 'px',
                height: img_x_height + 'px',
                marginLeft: '-' + img_x_left + 'px',
                marginTop: '-' + img_x_top + 'px'
            });

            active_crop = true;
            img1.imgAreaSelect({
                handles: true,
                aspectRatio: maskWidth / 10 + ':' + maskHeight / 10,
                x1: 0, y1: 0, x2: maskWidth / 10, y2: maskHeight / 10,
                onSelectChange: function (img_test, selection) {
                    if (!active_crop)
                        return false;
                    scaleX = maskWidth / (selection.width || maskWidth);
                    scaleY = maskHeight / (selection.height || maskHeight);

                    //                    img_x.css({
                    //                        width: Math.round(scaleX * img1.width()) + 'px',
                    //                        height: Math.round(scaleY * img1.height()) + 'px',
                    //                        marginLeft: '-' + Math.round(scaleX * selection.x1) + 'px',
                    //                        marginTop: '-' + Math.round(scaleY * selection.y1) + 'px'
                    //                    });
                    img_x_height = Math.round(scaleY * img1.height());
                    img_x_width = Math.round(scaleX * img1.width());
                    img_x_top = Math.round(scaleY * selection.y1) * (-1);
                    img_x_left = Math.round(scaleX * selection.x1) * (-1);
                    img_x.css({
                        width: img_x_width + 'px',
                        height: img_x_height + 'px',
                        marginLeft: img_x_left + 'px',
                        marginTop: img_x_top + 'px'
                    });
                    //img_container.html(img_x);
                }
            });
        });
    }
    function setLogo(url, val) {
        imgpath = url;
        url = SITE_URL + 'assets/upload/templates/' + url;
        var img_x = $('<img>');
        var img1 = $('<img>');
        var active_crop = false;
        var img_container = $('.logo');
        var img_container2 = $('#edit_image1');
        img_container2.html('');
        img_x.attr('src', url);
        img1.attr('src', url);
        var maskWidth = img_container.width();
        var maskHeight = img_container.height();
        img1.css('width', '568px');
        img_x.css('position', 'absolute');
        $("#logo_url").val(imgpath);

        
            $('#logotext').val(val);
            active_crop = false;
            img_container.html(img_x);
            img_container.css('border', 'none');
            img_container.css('text-align', 'left');
            $('#image_edit_modal').modal('hide');
            $("#logo_url").val(imgpath);
            $("#logo_width").val(img_x_width);
            $("#logo_height").val(img_x_height);
            $("#logo_left").val(img_x_left);
            $("#logo_top").val(img_x_top);
       

        
    }
    $(function () {

        $('.prev3').click(function () {
            $('[data-step="3"]').hide();
            $('[data-step="2"]').show();
            $('#step2').hide();
            $('#nextstep').removeClass('hide');
            $('.prev3').addClass('hide');
            $('#btnsubmit').addClass('hide');
            $('#btnsubmit_1').addClass('hide');
        });
        $('#nextstep').click(function () {
            $('[data-step="2"]').hide();
            $('[data-step="3"]').show();
            $('#nextstep').addClass('hide');
            $('.prev3').removeClass('hide');
            $('#btnsubmit').removeClass('hide');
            $('#btnsubmit_1').removeClass('hide');
        });
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
        $('a').click(function (e) {
            if ($(this).attr('href') == '#')
                e.preventDefault();
        });
        $('.check_all').on('ifUnchecked', function () {
            $(this).parents('table').children('tbody').find('.is_active').iCheck('uncheck');
        }).on('ifChecked', function () {
            $(this).parents('table').children('tbody').find('.is_active').iCheck('check');
        });
        $('.add_element').click(function () {
            if (current_step == 2) {
                var element_name = $('#name1').val();
                var element_type = $('#type1').val();
                //add_element(element_name, element_type, current_step, 0);

                var v = {};
                v.element_name = element_name;
                v.element_type = element_type;
                v.data_point_category = 1;
                v.element_name = element_name;
                v.element_name = element_name;
                add_element(v);
                $('#name1').val('');
            } else if (current_step == 3) {
                var element_name = $('#name').val();
                var element_type = $('#type').val();
                //add_element(element_name, element_type, current_step, 0);
                var v = {};
                v.element_name = element_name;
                v.element_type = element_type;
                v.data_point_category = 2;
                v.element_name = element_name;
                v.element_name = element_name;
                add_element(v);
                $('#name').val('');
            }


        })
        $('[name="FileInput"]').change(function () {
            var file_obj = $(this);
            var val = file_obj.val();
            var that = $(this).parents('form');
            var source = $(this).parents('[data-source]').data('source');
            //readURL(this,source);
            var options = {
                //			target:   '#output',   // target element(s) to be updated with server response
                //			beforeSubmit:  beforeSubmit,  // pre-submit callback
                success: function (data) {
                    data = JSON.parse(data);
                    if (data.status == 1) {
                        if (upload_type == 'bg') {
                            setImage1(data.file, data.original_name);
                        } else if (upload_type == 'logo') {
                            setLogo(data.file, data.original_name);
                        }
                    } else if (data.status == 2) {
                        $('#message_page').html(data.msg);
                        $('#select_page').html('');
                        for (i = 1; i <= data.pages; i++) {
                            $('#select_page').append('<option value="' + i + '">' + i + '</option>');
                        }
                        $('#apply_page_changes').unbind('click').bind('click', function () {
                            $('#apply_page_changes').unbind('click');
                            data.selected_page = $('#select_page').val();
                            $.post(SITE_URL + 'template/pdf_to_png', data, function (newdata) {
                                newdata = JSON.parse(newdata);
                                if (newdata.status == 1) {
                                    $('#page_modal').modal('hide');
                                    if (upload_type == 'bg') {
                                        setImage1(newdata.file, newdata.original_name);
                                    } else if (upload_type == 'logo') {
                                        setLogo(newdata.file, newdata.original_name);
                                    }
                                } else {

                                }
                            })
                        })
                        $('#page_modal').modal('show');
                    } else {
//                        $('#errormsg').removeClass('hide');
//                         $('#errormsg').html(data.msg);
                    }
                }, // post-submit callback
                //			uploadProgress: OnProgress, //upload progress callback
                resetForm: true        // reset the form after successful submit
            };
            that.ajaxSubmit(options);
            return false;
        });
    })

    $(function () {
        $('#font1').fontselect().change(function () {

            // replace + signs with spaces for css
            var font = $(this).val().replace(/\+/g, ' ');

            // split font into family and weight
            font = font.split(':');

            // set family on paragraphs //dsfont
            $('[data-step="3"]').find('[name="dsfont"]').each(function () {
                $(this).val(font[0]).change();
            })
            $('.canvas_text').css('font-family', font[0]);
        });

        $('#font2').fontselect().change(function () {

            // replace + signs with spaces for css
            var font = $(this).val().replace(/\+/g, ' ');

            // split font into family and weight
            font = font.split(':');

            // set family on paragraphs
            $('[data-step="2"]').find('[name="dsfont"]').each(function () {
                $(this).val(font[0]).change();
            })
            $('.canvas_text').css('font-family', font[0]);
        });
<?php
if ($edit) {
    echo 'load_theme(1);';
}
?>

    });
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
                title: 'Create Design Template'
            });
        } else {
            savetemplate();
        }

    }
    function savetemplate() {
        var flag = 0;
        var form = $("#save_theme_frm");
        form.validate();
        if (form.valid() == false) {
            return false;
        }


        var clone = $(".canvas").clone();
        
        clone.attr('id', 'myclone');
        clone.css('zoom', '100%');
        clone.css('transform-origin', 'top left');
        clone.css('transform', ' scale(1)');
        //            clone.css('top','-1000px');
        clone.css('position', 'absolute');
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
        
        clone.find('.layer2 svg').css('transform', 'none');
        svgText = clone.find('.layer2').html();
        mw = myCanvas.width;
        mh = myCanvas.height;



        clone.appendTo("body");

        $.post(SITE_URL + 'template/svgtopng', {'svg_content': svgText, 'swidth': mw, 'sheight': mh}, function (res) {

            $('.layer2').html('<img src="' + res + '" style="width:' + mw + ';height:' + mh + '">');
        }).always(function () {
            html2canvas($('#myclone'), {
                onrendered: function (canvas) {
                    var theCanvas = canvas;
                    document.body.appendChild(canvas);
                    clone.remove();
                    var imgData = theCanvas.toDataURL("image/jpeg", 1.0);
                    $("#dataimgcontent").val(imgData);
                    $('#save_theme_frm').submit();
                    theCanvas.remove();


                }

            });
        });

    }
    if (!('remove' in Element.prototype)) {
        Element.prototype.remove = function () {
            if (this.parentNode) {
                this.parentNode.removeChild(this);
            }
        };
    }
    $(document).on("click", function (event) {
        var $trigger = $(".font-select");
        if ($trigger !== event.target && !$trigger.has(event.target).length) {
            $(".fs-drop").slideUp();
            $(".font-select").removeClass("font-select-active");
        }
    });
    $(document).ready(function () {
        $(".chosen-search").hide();
    });

</script>
<link href="<?php echo JS_URL; ?>myPlugin/fontselect.css" rel="stylesheet">
<script src="<?php echo JS_URL; ?>myPlugin/jquery.fontselect.js"></script>
<script type="text/javascript" src="<?php echo JS_URL; ?>svgtopng/rgbcolor.js"></script>
<script type="text/javascript" src="<?php echo JS_URL; ?>svgtopng/StackBlur.js"></script>
<script type="text/javascript" src="<?php echo JS_URL; ?>svgtopng/canvg.js"></script>