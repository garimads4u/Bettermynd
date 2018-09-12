<div class="col-md-12 col-sm-12 col-xs-12">
  <div id="infoMessage">
    <?php
   if(isset($message) && strlen($message)>0 ) { 
	$message1=str_replace(" ","",$message);
	if(strlen($message1)>0){
      ?>
    <p class="alert alert-success">
      <?php  echo $message; ?>
    </p>
    <?php
	}
    } ?>
    <?php if(isset($error)  && strlen($error)>0) { 
            ?>
    <p class="alert alert-danger">
      <?php
        echo $error; 
         ?>
    </p>
    <?php
    } ?>
  </div>
  <?php 
    $template_group= isset($template_data[0]) && $template_data[0]->t_group_id != "" ? explode(',',$template_data[0]->t_group_id) : ''; 
    if(isset($template_data) && !empty($template_data)){
        
        $src = ASSETS_URL.'videos/'.$template_data[0]->video;
        $display_video="";
        $new_control="block";
    }
    else{
        $src="";
        $display_video="display:none;";
        $new_control="none";
    }
    ?>
  <div class="file-upload">
    <form id="fileupload" style="display:none;">
      <input type="file" id="files" name="FileInput" draggable="true" onclick="">
    </form>
    <div id="dragandrophandler" class="dropzone text-center" onclick="$('#files').trigger('click');" style="cursor:pointer;">Drop File here to Upload or  &nbsp; <span>Browse</span></div>
    
    <!--                </form>-->
    <p class="accepted_files"> 
      <!--<img src="<?php echo IMAGES_URL; ?>question_icon.png" width="21" height="20"  alt=""/>--> 
      Accepted File Types: .mov, .mp4, .avi, .mpg, .wmv, .3gp, .3gpp</p>
    <p id="fileUploadError" class="text-danger hide"></p>
  </div>
  <div class="row">
    <div class="col-md-5 col-sm-5">
      <div class="template_preview">
        <h3>TEMPLATE PREVIEW</h3>
        <div class="template_view temp_min_height"> 
          <!--                    	<span class="loading-img"><img src="images/loading.gif"><br>LOADING...</span>--> 
          <!--                        <div id="slider" style="display:none;"></div>--> 
          <span class="loading-img" style="display:none;z-index:500000 !important;"><img src="<?php echo IMAGES_URL;?>loading.gif"><br>
          LOADING...</span>
          <div id="video_container" class="videoContainer" style="<?php echo $display_video;?>">
            <video autobuffer="autobuffer" width="100%" id="play_video">
              <source src="<?php echo $src;?>" id="targetsource"></source>
              <!--<source src="http://paulirish.com/demo/js/yayquery30sec.mp3"></source>--> 
              audio tag demo requires HTML 5 (try Firefox 3.5+) </video>
            <div class="canvas" id="lyrics">
              <?php
					
                 if($edit && isset($template_element) && count($template_element) > 0 && !empty($template_element)){
		 foreach($template_element as $data){
                        $settings = json_decode($data['settings']);
                        $font_settings = json_decode($data['font_settings']);
                        $color = $data['color'];
                        $left = $data['cord_x'].'px';
                        $top = $data['cord_y'].'px';
                        $display = $data['is_active']?'display:block':'display:none';
                        if($data['element_type'] == 1){
                        ?>
              <div class="canvas_image canvas_elements" data-layer="<?php echo $data['element_name']; ?>" style="<?php echo $display; ?>"><span><?php echo $data['element_name']; ?></span></div>
              <?php }elseif($data['element_type'] == 2){
                        ?>
              <div class="canvas_text canvas_elements" data-layer="<?php echo $data['element_name']; ?>" style="<?php echo $display; ?>"><span><?php echo $data['element_name']; ?></span></div>
              <?php
                    }elseif($data['element_type'] == 3){
                                $content = $settings->dsdefaultcontent;
                                $bullet_type = $settings->dsbullettype;
                               // $content = nl2br($content);
                                $res = explode("\n", $content);
                                $res = array_filter($res, 'trim');
                            if($bullet_type=='1')
                                $num = 1;
                            else if($bullet_type=='disc')
                                $num = '&bull;';
                            else if($bullet_type=='circle')
                                $num = '&#9900;';
                            else if($bullet_type=='square')
                                $num = '&#9755;';
                            else
                                $num = '&bull;';
                            $content = '<ul class="nobullet">';
                            foreach($res as $v){
                                if($bullet_type=='1' || $bullet_type==1){
                                    $content .= '<li><span class="dsbullet">'.$num.'.</span> '.$v.'</li>';
                                    $num++;
                                }else{
                                    $content .= '<li><span class="dsbullet">'.$num.'</span> '.$v.'</li>';
                                }
                            }
                            $content.='</ul>';
//                            if($bullet_type=='1' || $bullet_type=='A' || $bullet_type=='a' || $bullet_type=='i' || $bullet_type=='I')
//                                $content.='</ol>';
//                            else
//                                $content.='</ul>';
                         ?>
              <div class="canvas_text canvas_elements" data-layer="<?php echo $data['element_name']; ?>" style="<?php echo $display; ?>"><span><?php echo $content; ?></span></div>
              <?php } } } ?>
            </div>
            <div class="control" style="display:<?php echo $new_control;?>;margin-top:10px !important;" id="new_controls">
              <div class="btmControl">
                <div class="btnPlay btn" title="Play/Pause video"><span class="icon-play"></span></div>
                <div class="progress-bar">
                  <div class="progress"> <span class="bufferBar"></span> <span class="timeBar"></span> </div>
                </div>
                <div class="progress-bar curr-time" style="line-height:10px !important;">00:00:00</div>
                <div class="sound sound2 btn" title="Mute/Unmute sound"><span class="icon-sound"></span></div>
              </div>
            </div>
          </div>
        </div>
        <div class="progress-box">
          <div class="steps-count">STEP <span id="step_num">1</span> OF 2</div>
        </div>
      </div>
    </div>
    <div class="col-md-7 col-sm-7">
      <div class="clearfix">
        <div class="step1" data-step="1">
          <form id="step-1">
            <div class="x_panel follow-step">
              <h3>Follow the steps below to setup your Template.</h3>
              <p>File not uploading properly? Visit our <a href="#">File Preperation Overview ></a></p>
              <h2>STEP 1 - <span>Template Setup</span></h2>
            </div>
            <div class="detected-size">
              <div class="row">
                <div class="col-sm-4 col-xs-12"> Detected Size </div>
                <div class="col-sm-8 col-xs-12">
                  <input type="hidden" value="<?php echo trim($data1['video']); ?>" name="video" id="background">
                  <input type="hidden" value="<?php echo $data1['id']; ?>" name="section_id">
                  <input type="hidden" value="<?php echo (isset($template_data) && !empty($template_data[0]) && $template_data[0]->id ? $template_data[0]->id : ''); ?>" name="template_id">
                  <input type="hidden" value="0" name="duration"  id="duration">
                  <div class="col-sm-4 col-xs-4">
                    <input onkeydown="return false;" onmousedown="return false;" type="text" id="width" name="width"  value="<?php echo (isset($template_data) && !empty($template_data[0]) && $template_data[0]->width ? $template_data[0]->width : ''); ?>" class="form-control graycolor">
                  </div>
                  <span class="pull-left">x</span>
                  <div class="col-sm-4 col-xs-4">
                    <input onkeydown="return false;" onmousedown="return false;"  type="text" value="<?php echo (isset($template_data) && !empty($template_data[0]) && $template_data[0]->height ? $template_data[0]->height : ''); ?>" id="height" name="height" class="form-control graycolor">
                    <input type="hidden" name="origname" id="origname" readonly />
                  </div>
                  <span class="pull-left">Pixels</span> </div>
              </div>
            </div>
            <div class="white_box">
              <div class="row">
                <div class="col-sm-12 col-xs-10">
                  <div class="row">
                    <div class="col-md-6 col-sm-12">
                      <div class="form-group">
                        <label class="control-label" for="type">Type</label>
                       
                          <?php foreach($template_types as $templates){
                                    if($templates['category']==3){
										//value="<?php echo $templates['id']; 
                                    ?>
                                    <input type="hidden" name="template_type" id="template_type" value="<?php echo $templates['id'];?>" />
                          <input onkeydown="javascript:return false;" class="form-control graycolor" onmousedown="javascript:return false;" type="text"  name="template_type_display" id="template_type_display" value="<?php echo ucwords(strtolower($templates['type'])); ?>" />
                          <?php } } ?>
                       
                      </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                      <div class="form-group">
                        <label class="control-label" for="group">Group(s)<span class="mandatory" style="font-size:14px !important;"> * </span></label>
                        <?php
                                                $options = $v_groups;
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
                    <input type="checkbox" name="notify" id="notify" class="flat" checked="checked" value="1">
                    Notify User Groups of New Template after Saving via Email</label>
                </div>
              </div>
            </div>
            <div class="x_panel">
              <div class="row">
                <div class="col-xs-12">
                  <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" class="form-control"  id="title" name="title" placeholder="" value="<?php echo (isset($template_data) && !empty($template_data[0]) && $template_data[0]->title ? $template_data[0]->title : ''); ?>" required maxlength="150">
                  </div>
                  <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" name="description" maxlength="250"><?php echo (isset($template_data) && !empty($template_data[0]) && $template_data[0]->description ? $template_data[0]->description : ''); ?></textarea>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-12"> <a href="#" class="btn btn-primary pull-right" onclick="show_step(2);" id="btn_next">Next</a> </div>
              </div>
            </div>
          </form>
        </div>
        <form action="<?php echo TEMPLATE_URL;?>save_video_template" id="save_template_frm" method="post">
          <div class="step2" data-step="2" style="display:none;">
            <div class="clearfix">
              <h2>STEP 2 <span>Personalization Options</span></h2>
              <a href="#" class="pull-right"><img src="<?php echo IMAGES_URL; ?>question_icon.png" width="21" height="20"  alt=""/></a> </div>
            <div class="white_box">
              <div class="row">
                <div class="col-sm-9">
                  <p>Below are default personalization data for this Template Type. Editable in your <a href="#">Company Profile</a>. You can add more data below.</p>
                </div>
                <div class="col-sm-2 col-xs-offset-1">
                  <input type="hidden" name="template_id" id="template_id" value="<?php echo (isset($template_data) && !empty($template_data[0]) && $template_data[0]->id ? $template_data[0]->id : ''); ?>" />
                </div>
              </div>
              <div class="table-responsive my_table">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th><input type="checkbox" class="flat check_all" checked="checked"></th>
                      <th>Title</th>
                      <th>Type</th>
                      <th>Position</th>
                      <th>Time</th>
                      <th>Options</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                        $i = 0;
                       if ($edit && isset($template_element) && count($template_element) > 0 && !empty($template_element[0])) {
                        foreach ($template_element as $data) {
                            if($data['data_point_category']==1){ ?>
                    <tr data-source="<?php echo $data['element_name']; ?>">
                      <td><input type="hidden" name="is_active[]" value="<?php echo $data['is_active']; ?>" />
                        <input type="checkbox" class="flat is_active" <?php if($data['is_active']){ echo 'checked="checked"'; } ?>></td>
                      <td><span class="source" style="cursor:pointer;"><?php echo ucwords($data['element_name']); ?></span>
                        <input type="hidden" value="<?php echo $data['element_name']; ?>" name="element_name[]" style="width:25px;">
                        <input type="hidden" value="<?php echo $data['data_point_id']; ?>" name="data_point_id[]" style="width:25px;">
                        <input type="hidden" value="<?php echo $data['data_point_category']; ?>" name="data_point_category[]" style="width:25px;"></td>
                      <td><?php //echo $type = $data['element_type']==1?'image':'text';
                        switch($data['element_type']){
                            case 1:echo 'Image';break;
                            case 2:echo 'Text';break;
                            case 3:echo 'Bullet';break;
                        }
                        ?>
                        <input type="hidden" value="<?php echo $data['element_type']; ?>" name="element_type[]" style="width:25px;"></td>
                      <td><div class="position_controls">
                          <input class="form-control cord_x" type="text" value="<?php echo $data['cord_x']; ?>" name="cord_x[]" >
                          <span>X,</span>
                          <input class="form-control cord_y" type="text" value="<?php echo $data['cord_y']; ?>" name="cord_y[]">
                          <span>Y</span> </div></td>
                      <td ><div class="vid_time position_controls">
                          <div class="relative pull-left">
                            <input class="form-control start" readonly type="text" value="<?php echo $data['start']; ?>" >
                            <div class="pop_vid" ><strong class="arrow"></strong>
                              <input class="form-control start1" type="hidden" value="<?php echo $data['start']; ?>" name="start[]">
                              <div class="pull-left start_time" id="s_time">0:00</div>
                              <div class="pull-right end_time">0:00</div>
                              <div class="start2" style="margin-top:25px;">
                                <input type="hidden" id="hidden"/>
                              </div>
                              <div class="clearfix"></div>
                            </div>
                          </div>
                          <div class="relative pull-left">
                            <input class="form-control end" readonly type="text" value="<?php echo $data['stop']; ?>"  >
                            <div class="pop_vid" ><strong class="arrow"></strong>
                              <input class="form-control end1" type="hidden" value="<?php echo $data['stop']; ?>" name="end[]">
                              <div class="pull-left start_time">0:00</div>
                              <div class="pull-right end_time">0:00</div>
                              <div class="end2" style="margin-top:25px;">
                                <input type="hidden" id="hidden"/>
                              </div>
                              <div class="clearfix"></div>
                            </div>
                          </div>
                        </div></td>
                      <td class="nowrap"><span class="dssettings-parent">
                        <input type="text" class="ds-fontpick" name="font_settings[]" value='<?php echo $data['font_settings']; ?>'>
                        </span> <span class="dscolorpick-parent">
                        <input type="text" class="ds-colorpick" name="color[]" value='<?php echo $data['color']; ?>'>
                        </span> <span class="dssettings-parent">
                        <input type="text" class="ds-settings" data-element_type="<?php echo $data['element_type']; ?>" name="settings[]" value="<?php echo htmlentities($data['settings']); ?>">
                        </span></td>
                    </tr>
                    <?php } }
                    }?>
                  </tbody>
                </table>
              </div>
              <div class="row">
                <div class="col-sm-5 col-xs-12">
                  <div class="form-group">
                    <input type="text" value="" id="name1" class="form-control pull-left" placeholder="Name">
                  </div>
                </div>
                <div class="col-sm-4 col-xs-12">
                  <div class="form-group">
                    <select id="type1" class="form-control pull-left">
                      <option value="2">Text</option>
                    </select>
                  </div>
                </div>
                <div class="col-sm-3 col-xs-12"> <a href="javascript:void(0);" class="add_element btn btn-default pull-right">Add New</a> </div>
              </div>
            </div>
          </div>
          <input type="hidden" id="notify_check" name="notify_check" value="0" />
          <input type="hidden" id="savedraft" name="savedraft">
        </form>
      </div>
      <div class="clearfix register-buttons">
        <input type="button" id="draft_template" onclick="download('0')" class="btn btn-primary hide" value="Save Draft">
        <input type="button" id="save_template" onclick="download('1')" class="btn btn-primary hide" value="Save Template">
      </div>
    </div>
  </div>
</div>
<!-- Javascript Code Starts Here--> 
<script src="<?php echo JS_URL.'myPlugin/myPlugin_video.js';?>"></script> 
<script src="<?php echo JS_URL.'jquery.annotatevideo.js';?>"></script> 
<script>
 $(document).on("click", ".start, .end", function(event){
    event.preventDefault();
    $(this).next('div').toggle();
}); 
  </script> 
<script>
$(".a_pop").click(function(e){
    $(".window_drop").show();
     e.stopPropagation();
});

$(".window_drop").click(function(e){
    e.stopPropagation();
});

$(document).click(function(){
    $(".window_drop").hide();
});
function download(value){
        $('#savedraft').val(value);
         if(value=='1'){
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
                            $('#save_template_frm').submit(); 
                            $(this).prop('disabled',true);
                        }
                    },
                    title: 'Create Custom Template'
                });
    }else{
         $('#save_template_frm').submit();
          $(this).prop('disabled',true);
    }
  
    }
</script>
<style>
    .canvas{position:absolute;left:20px !important;top:50px !important;width: 100%;height:75%;overflow: hidden; overflow:hidden;}.style_canvas{position: absolute;}.canvas_elements{position: absolute;cursor: pointer;font-size:<?php echo 14*$dpi/72; ?>px;overflow:hidden;min-height:100px;min-width:100px;max-height:100px;max-width:100px; border: 1px dotted #333;}.canvas_elements.selected{
        outline:1px dashed #ccc;
        cursor:move;
    }
    .canvas_image{
         border: 1px solid #666;
    }
    .canvas_image{
         border: 1px solid #666;
    }
    .pop_vid{
	position: absolute;
        display: none;
        width: 200px;
        padding: 1px;
        font-size: 14px;
        font-style: normal;
        font-weight: 400;
        line-height: 1.42857143;
        text-align: left;
        text-align: start;
        top: -55px;
        right:0;
        z-index: 999;
        padding: 5px 13px 8px 10px;
        background-color: #fff;
        -webkit-background-clip: padding-box;
        background-clip: padding-box;
        border: 1px solid #ccc;
        border: 1px solid rgba(0,0,0,.2);
        border-radius: 6px;
        -webkit-box-shadow: 0 5px 5px rgba(0,0,0,.2);
        box-shadow: 0 5px 5px rgba(0,0,0,.2);
        line-break: auto;
    }
	
	.pop_vid:before, .pop_vid:after {
	content: "";
	position: absolute;
	border-left: 10px solid transparent;
	border-right: 10px solid transparent;
	top: 100%;
	left: 87%;
	margin-left: -10px;
}

.pop_vid:before {
	border-top: 10px solid #111;
	border-top: 10px solid rgba(0, 0, 0, 0.5);
	margin-top: 0px;
}

.pop_vid:after{
	border-top: 10px solid #fff;
	margin-top: 0px;
	z-index: 1;
}

	
	
	
    .table>tbody>tr>td, .table>tfoot>tr>td, .table>thead>tr>td {
        padding: 8px 9px!important;
    }
    .template_preview.stuck {
        position:fixed;
        top:0;
    }
    
    
    /*** VIDEO CONTROLS CSS ***/
    .videoContainer{overflow:auto; max-height: 600px; width: 100%; padding-bottom:35px;}
/* control holder */
.control{
	color:#ccc;
	position:absolute;
	left:0;
        right:0;
        margin:auto;
	width:310px;
	z-index:5;
	display:none;
}
/* control bottom part */
.btmControl{
	clear:both;
}
.control .btnPlay {
	float:left;
        margin-right:0px;
	width:34px;
	height:30px;
	padding:5px;
	background: rgba(0,0,0,0.5);
	cursor:pointer;
	border-radius: 6px 0 0 6px;
	border: 1px solid rgba(0,0,0,0.7);
	box-shadow: inset 0 0 1px rgba(255,255,255,0.5);
}
.control .icon-play{
	background:url(http://s.cdpn.io/6035/vp_sprite.png) no-repeat -11px 0;
	width: 6px;
	height: 9px;
	display: block;
	margin: 4px 0 0 8px;
}
.control .icon-pause{
	background:url(http://s.cdpn.io/6035/vp_sprite.png) no-repeat -34px -1px;
	width: 8px;
	height: 9px;
	display: block;
	margin: 4px 0 0 8px;
}
.control .selected{
	font-size:15px;
	color:#ccc;
}
.control .sound{
	width: 30px;
	height: 30px;
	float:left;
	background: rgba(0,0,0,0.5);
	border: 1px solid rgba(0,0,0,0.7);
	border-left: none;
	box-shadow: inset 0 0 1px rgba(255,255,255,0.5);
	cursor: pointer;
        margin-right:0px;
        border-radius: 0 6px 6px 0;
}
.control .icon-sound {  
	background:url(http://s.cdpn.io/6035/vp_sprite.png) no-repeat -19px 0;
	width: 13px;
	height: 10px;
	display: block;
	margin: -2px 0 0 -8px;
}
.control .muted .icon-sound{
	width: 7px !important;
}
.control .btnFS{
	width: 30px;
	height: 30px;
	border-radius: 0 6px 6px 0;
	float:left;
	background: rgba(0,0,0,0.5);
	border: 1px solid rgba(0,0,0,0.7);
	border-left: none;
	box-shadow: inset 0 0 1px rgba(255,255,255,0.5);

}
.control .icon-fullscreen {  
	background:url(http://s.cdpn.io/6035/vp_sprite.png) no-repeat 0 0;
	width: 10px;
	height: 10px;
	display: block;
	margin: 8px 0 0 9px;
}

/* PROGRESS BAR CSS */
/* Progress bar */
.progress-bar {
    width:auto;
	height: 30px;
	padding: 10px;
	background: rgba(0,0,0,0.6) !important;
	border: 1px solid rgba(0,0,0,0.7) !important;
	border-left: none;
	box-shadow: inset 0 0 1px rgba(255,255,255,0.5);
	float:left;

}
.progress {
	width:150px;
	height:7px;
	position:relative;
	cursor:pointer;
	background: rgba(0,0,0,0.4) !important; /* fallback */
	box-shadow: 0 1px 0 rgba(255,255,255,0.1), inset 0 1px 1px rgba(0,0,0,1);
	border-radius:10px;
}
.progress span {
	height:100%;
	position:absolute;
	top:0;
	left:0;
	display:block;
	border-radius:10px;
}
.timeBar{
	z-index:10;
	width:0;
	background: -webkit-linear-gradient(top, rgba(107,204,226,1) 0%,rgba(29,163,208,1) 100%);
	box-shadow: 0 0 7px rgba(107,204,226,.5);
}
.bufferBar{
	z-index:5;
	width:0;
	background: rgba(255,255,255,0.2);
}

/* VOLUME BAR CSS */
/* volume bar */
.volume{
	position:relative;
	cursor:pointer;
	width:70px;
	height:10px;
	float:right;
	margin-top:10px;
	margin-right:10px;
}
.volumeBar{
	display:block;
	height:100%;
	position:absolute;
	top:0;
	left:0;
	background-color:#eee;
	z-index:10;
}

@media only screen and (max-width:990px){
	.progress{ width:70px;}
	.control{width:230px;}
}
@media only screen and (max-width:767px){
	.progress{ width:150px;}
	.control{width:310px;}
}
@media only screen and (max-width:479px) {
.progress{ width:70px;}	
.control{width:230px;}
}

</style>
<script>
<?php echo $dpi;?>

    var i = <?php echo $i;?>,active=i;
    var canvas = $('.canvas');
    var elements = [];
    var default_text = "Your text goes here...";
    var dpi = <?php echo $dpi;?>;
    var zoom = 55;
    var data_points;
    var top_def = 0, left_def = 0;
    var current_step = 1;
    var w_stuck = 0;
    function secondsToHms(d) {
        d = Number(d);
        var h = Math.floor(d / 3600);
        var m = Math.floor(d % 3600 / 60);
        var s = Math.floor(d % 3600 % 60);
        return ((h > 0 ? h + ":" + (m < 10 ? "0" : "") : "") + m + ":" + (s < 10 ? "0" : "") + s); 
    }
    function add_element(element_name, element_type, num, data_point_id){
        if(typeof data_point_id == 'undefined'){
            data_point_id=0; // other
        }
        if($.trim(element_name)==''){
            alert('please enter element name');
            return false;
        }
        if($.inArray( element_name, elements ) >= 0 || element_name=='background'){
            alert('element name already exists');
            return false;
        }
        elements.push(element_name);
        
        var element_type_name = element_type=='1'?'image':'text';
        element_type_name = element_type=='3'?'bullet':element_type_name;
        i++;
        active = i;
        var k = i;
        if(num==2){
            data_point_category=1;
        }else{
            data_point_category=2;
        }
        var duration = $('#duration').val();
        var duration_text = secondsToHms(duration);
        var html = '<tr data-source="'+element_name+'" class="active">'+
            '<td class="valing-middle"><input type="hidden" name="is_active[]" value="1" />'+
            '<input type="checkbox" checked="checked" class="flat is_active"></td>'+
            '<td class="ln-height"><span class="source" style="cursor:pointer;">'+element_name+'</span>'+
            '<input type="hidden" value="'+element_name+'" name="element_name[]" style="width:25px;">'+
            '<input type="hidden" value="'+data_point_id+'" name="data_point_id[]" style="width:25px;">'+
            '<input type="hidden" value="'+data_point_category+'" name="data_point_category[]" style="width:25px;">'+
            '</td>'+
            '<td class="ln-height">'+IstLetter(element_type_name)+
            ' <input type="hidden" value="'+element_type+'" name="element_type[]" style="width:25px;">'+
            '</td>'+
            '<td><div class="position_controls">'+
            '   <input class="form-control cord_x" type="text" value="'+left_def+'" name="cord_x[]" ><span>X,</span>'+
            ' <input class="form-control cord_y" type="text" value="'+top_def+'" name="cord_y[]"  ><span>Y</span>'+
            '</div></td>'+
            '<td><div class="vid_time position_controls">'+
                    '<div class="relative pull-left">'+
                        '<input class="form-control start" readonly="readonly" type="text" value="0:00" >'+
                        '<div class="pop_vid" ><strong class="arrow"></strong>'+
                            '<input class="form-control start1" type="hidden" value="0" name="start[]">'+
                            '<div class="pull-left start_time">0:00</div>'+
                            '<div class="pull-right end_time">'+duration_text+'</div>'+
                            '<div class="start2" style="margin-top:25px;"></div>'+
                            '<div class="clearfix"></div>'+
                        '</div>'+
                    '</div>'+
                    '<div class="relative pull-left">'+
                        '<input class="form-control end" readonly="readonly" type="text" value="'+duration_text+'"  >'+
                        '<div class="pop_vid" ><strong class="arrow"></strong>'+
                            '<input class="form-control end1" type="hidden" value="'+duration+'" name="end[]">'+
                            '<div class="pull-left start_time">0:00</div>'+
                            '<div class="pull-right end_time">'+duration_text+'</div>'+
                            '<div class="end2" style="margin-top:25px;"></div>'+
                            '<div class="clearfix"></div>'+
                        '</div>'+
                      
                    '</div>'+
            '</div></td>'+
            '<td class="nowrap">'+
            '   <span class="dssettings-parent">'+
            '      <input type="text" class="ds-fontpick" name="font_settings[]" value=\'\'>'+
            ' </span>'+
            ' <span class="dscolorpick-parent">'+
            '     <input type="text" class="ds-colorpick" name="color[]" value=\'\'>'+
            ' </span>'+
            ' <span class="dssettings-parent">'+
            '     <input type="text" class="ds-settings"  data-element_type="'+element_type+'" name="settings[]" value=\'\'>'+
//            ' </span><span style="cursor:pointer;" onclick="remove_element(\''+element_name+'\')"><i class="fa fa-times"></i></span>'+
            '</td>'+  
            '  </tr>';
        $('[data-source]').removeClass('active');
        var html_ele = $(html);
        
        $('[data-step="'+num+'"]').find('tbody').append(html_ele);
        set_start_slider($(html_ele).find(".start2"),0,duration,0);
        set_end_slider($(html_ele).find(".end2"),0,duration,duration);
     
        $('.end_time').text(duration_text);
        html_ele.find('.ds-colorpick').dscolorpick({});
        if(element_type==3){
            html_ele.find('.ds-settings').dssettings({
                'dsdefaultcontent':element_name,
                'element_type':element_type,
                'dsmaxheight':30,
                'dsmaxwidth':100
            });
        }else{
            html_ele.find('.ds-settings').dssettings({
                'dsdefaultcontent':element_name,
                'element_type':element_type
            });
        }
        

        html_ele.find('.ds-fontpick').dsfontpick({});
        
        $('.canvas_elements').removeClass('selected');
        if(element_type==2){
            var text = $('<div data-start="0" data-stop="0" class="canvas_text canvas_elements selected" data-layer="'+element_name+'"><span>'+element_name+'</span></div>');
        }else if(element_type==1){
            var text = $('<div data-start="0" data-stop="0" class="canvas_image canvas_elements selected" data-layer="'+element_name+'"><span> Image </span></div>');
        }else if(element_type==3){
            var bullet = '<div data-start="0" data-stop="0" class="canvas_text canvas_elements selected" data-layer="'+element_name+'"><span><ul>';
                for(il=1;il<=3;il++){
                     bullet += '<li>Bullet Item '+il+'</li>';
                }
                bullet += '</ul></span></div>';
            var text = $(bullet);
        }
        html_ele.find('.is_active').iCheck({
            checkboxClass: 'icheckbox_flat-blue'
        }).on('ifUnchecked',function(){
           $(this).parents('div').siblings('input').val(0);
           text.hide();
        }).on('ifChecked',function(){
           $(this).parents('div').siblings('input').val(1);
           text.show();
        });
        i = k;
        canvas.append(text);
        top_def = top_def+35;
        if(top_def>(canvas.height()-35)){
            top_def = 0;
            left_def=left_def+200;
        }
        $('[data-source="'+element_name+'"]').find('input, select').each(function(){
            $(this).change().blur();
        })
        init_elements();
		$("#name1").val('');
    }
    function set_start_slider(that, min, max, value){
        that.parents('.relative').find('.start_time').text(secondsToHms(0));
        that.parents('.relative').find('.end_time').text(secondsToHms(max));
        that.slider({
            animate: true,
            range: "min",
            min: 0,
            max:max,
            step:1,
            value: value,
            slide: function( event, ui ) {
                sec = secondsToHms(ui.value);
                that.parents('.relative').find('.start_time').text(secondsToHms(ui.value));
                $(this).siblings('.start1').val(ui.value);
                $(this).siblings('.start1').change();
                $(this).parents('.pop_vid').siblings('.start').val(sec);
                set_end_slider($(this).parents('.relative').siblings('.relative').find('.end2'),ui.value,max,$(this).parents('.relative').siblings('.relative').find('.end1').val());
            }
        });
    }
    function set_end_slider(that, min, max, value){
        that.parents('.relative').find('.start_time').text(secondsToHms(min));
        that.parents('.relative').find('.end_time').text(secondsToHms($('#duration').val()));
        that.slider({
            animate: true,
            range: "min",
            min: min,
            max:$('#duration').val(),
            step: 1,
            value: value,
            slide: function( event, ui ) {
                sec = secondsToHms(ui.value);
                that.parents('.relative').find('.end_time').text(secondsToHms(ui.value));
                $(this).siblings('.end1').val(ui.value);
                $(this).siblings('.end1').change();
                $(this).parents('.pop_vid').siblings('.end').val(sec);
                set_start_slider($(this).parents('.relative').siblings('.relative').find('.start2'),0,ui.value,$(this).parents('.relative').siblings('.relative').find('.start1').val());
            }
        });
    }
    var SX =0, SY=0;
    function init_elements(){
        var text = $('.canvas_elements');
        text.draggable({
            containment:canvas,
            start: function(event) {
                SX = event.clientX;
                SY = event.clientY;
            },
            drag: function(event, ui){

                var ratio = zoom/100;
                var original = ui.originalPosition;
                ui.position = {
                    left: (event.clientX - SX + original.left) / ratio,
                    top:  (event.clientY - SY + original.top ) / ratio
                };
                var pos = ui.position;
                
                    if(pos.left < 0) pos.left=0;
                    if(pos.top < 0) pos.top=0;
                    ui_height = ui.helper.outerHeight();
                    ui_width = ui.helper.outerWidth();
                    if((pos.top+ui_height) >= canvas.height()) pos.top=canvas.height()-ui_height;
                    if((pos.left+ui_width) >= canvas.width()) pos.left=canvas.width()-ui_width;
                $('[data-source="'+$(this).data('layer')+'"]').find('.cord_x').val(pos.left.toFixed(2));
                $('[data-source="'+$(this).data('layer')+'"]').find('.cord_y').val(pos.top.toFixed(2));
            }
        });
        text.resizable({

            resize: function(event, ui) {
                var zoomScale = zoom/100;
                var changeWidth = ui.size.width - ui.originalSize.width; // find change in width
                var newWidth = ui.originalSize.width + changeWidth / zoomScale; // adjust new width by our zoomScale
                var changeHeight = ui.size.height - ui.originalSize.height; // find change in height
                var newHeight = ui.originalSize.height + changeHeight / zoomScale; // adjust new height by our zoomScale
                ui.size.width = newWidth;
                ui.size.height = newHeight;
                
                var width = ui.size.width;
                var height = ui.size.height;
//                $('[data-source="'+$(this).data('layer')+'"]').find('.ds-max-width').val(width).change();
//                $('[data-source="'+$(this).data('layer')+'"]').find('.ds-max-height').val(height).change();
                $('[data-settingsource="' + $(this).data('layer') + '"]').find('.ds-max-width').val(width).change();
                $('[data-settingsource="' + $(this).data('layer') + '"]').find('.ds-max-height').val(height).change();
            }
        });
        text.mousedown(function(){
            active = $(this).data('layer');
            $('[data-source]').removeClass('active');
            $('[data-source="'+active+'"]').addClass('active');
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
    function remove_element(source){
        $('[data-source="'+source+'"]').remove();
        $('[data-layer="'+source+'"]').remove();
    }
    function init_annotation(){
        $('#lyrics div').each(function(){
            jQuery('video').annotatevideo({
                    start : 0,
                    stop  : 0,
                    elem  : $(this)
            });
            jQuery('video').annotatevideo({
                    start : $(this).attr('data-start'),
                    stop  : $(this).attr('data-stop'),
                    elem  : $(this)
            });
    });
    }
    $(function(){
        $('.check_all').on('ifUnchecked',function(){
           $(this).parents('table').children('tbody').find('.is_active').iCheck('uncheck');
        }).on('ifChecked',function(){
           $(this).parents('table').children('tbody').find('.is_active').iCheck('check');
        });
        //store the element
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
            $cache.css('width', (w_stuck+2)+'px');
            } else {
            // otherwise remove it
            $cache.removeClass('stuck');
            $cache.css('width', 'auto');
            }
        }).resize(function(){
            w_stuck = $cache.width();
        });
        $(".start2").each(function(){
            val = $(this).siblings('.start1').val();
            sec = secondsToHms(val);
            $(this).parents('.pop_vid').siblings('.start').val(sec);
            $(this).slider({
                min: 0,
                max:$('#duration').val(),
                step:1,
                value: $(this).siblings('.start1').val(),
                    slide: function( event, ui ) {
                        sec = secondsToHms(ui.value);
                        $(this).siblings('.start1').val(ui.value);
                        $(this).parents('.pop_vid').siblings('.start').val(sec);
                    }
            });
        });
        $(".end2").each(function(){
            val = $(this).siblings('.end1').val();
            sec = secondsToHms(val);
            $(this).parents('.pop_vid').siblings('.end').val(sec);
            $(this).slider({
                min: 0,
                max:$('#duration').val(),
                step:1,
                value: $(this).siblings('.end1').val(),
                    slide: function( event, ui ) {
                        sec = secondsToHms(ui.value);
                        $(this).siblings('.end1').val(ui.value);
                        $(this).parents('.pop_vid').siblings('.end').val(sec);
                    }
            });
        });
        $('.end_time').text(secondsToHms($('#duration').val()));
        $(document).mousedown(function (e) {
            settings_window = $('.pop_vid');
            if (!settings_window.is(e.target) // if the target of the click isn't the container...
                && settings_window.has(e.target).length === 0) // ... nor a descendant of the container
                {
                settings_window.hide();
            }
        });
        $('.is_active').on('ifUnchecked',function(){
           $(this).parents('div').siblings('input').val(0);
           var layer = $(this).parents('[data-source]').data('source');
           $('[data-layer="'+layer+'"]').hide();
        });
        $('.is_active').on('ifChecked',function(){
           $(this).parents('div').siblings('input').val(1);
           var layer = $(this).parents('[data-source]').data('source');
           $('[data-layer="'+layer+'"]').show();
        });
        $('a').click(function(e)
        {
            if($(this).attr('href')=='#')
            e.preventDefault();
        });
        $('.add_element').click(function(){
            if(current_step==2){
                var element_name = $('#name1').val();
                var element_type = $('#type1').val();
            }else if(current_step==3){
                var element_name = $('#name').val();
                var element_type = $('#type').val();
            }
            add_element(element_name, element_type, current_step);
        })
        $( "#slider" ).slider({
         min: 10,
         max:100,
         step:5,
         value: zoom,
            slide: function( event, ui ) {

            }
        });
        
        $(document).on('change keyup','.cord_x',function(){
            var x = $(this).val();
            var source = $(this).parents('[data-source]').data('source');
            $('[data-layer="'+source+'"]').css('left',x+'px');
        })
        $(document).on('change keyup','.cord_y',function(){
            var y = $(this).val();
            var source = $(this).parents('[data-source]').data('source');
            $('[data-layer="'+source+'"]').css('top',y+'px');
        })
        $(document).on('change keyup','.start1',function(){
            var x = $(this).val();
            var source = $(this).parents('[data-source]').data('source');
            $('[data-layer="'+source+'"]').attr('data-start', x);
            $('[data-layer="'+source+'"]').data('start', x);
            init_annotation()
        })
        $(document).on('change keyup','.end1',function(){
            var y = $(this).val();
            var source = $(this).parents('[data-source]').data('source');
            $('[data-layer="'+source+'"]').attr('data-stop', y);
            $('[data-layer="'+source+'"]').data('stop', y);
            init_annotation();
        })
        $(document).on('change','.ds-colorpick',function(){
            var clr = $(this).val();
            var source = $(this).parents('[data-source]').data('source');
            $('[data-layer="'+source+'"]').css('color',clr);
        })
        $(document).on('change','.ds-fontpick',function(){
            var font_settings = $(this).val();
            var obj = JSON.parse(font_settings);
            var source = $(this).parents('[data-source]').data('source');
            $('[data-layer="'+source+'"]').css('font-size', (obj.dsfontsize*dpi/72)+'px');
            $('[data-layer="'+source+'"]').css('text-align', obj.dsalign);
            if(typeof obj.dsfont != 'undefined'){
                var font = obj.dsfont;
                $('[data-layer="'+source+'"]').css('font-family', font.replace(/\+/g,' '));
            }
            if(typeof obj.dstextheight != 'undefined'){
                var dstextheight = obj.dstextheight;
                //$('[data-layer="'+source+'"] span').css('line-height', dstextheight+'px');
            }
            if(typeof obj.dstextwidth != 'undefined'){
                var dstextwidth = obj.dstextwidth;
                $('[data-layer="'+source+'"] span').css('letter-spacing', dstextwidth+'px');
            }
            if(typeof obj.dsbold != 'undefined'){
                $('[data-layer="'+source+'"] span').css('font-weight', 'bold');
            }else{
                $('[data-layer="'+source+'"] span').css('font-weight', 'normal');
            }
            if(typeof obj.dsunderline != 'undefined'){
                $('[data-layer="'+source+'"] span').css('text-decoration', 'underline');
            }else{
                $('[data-layer="'+source+'"] span').css('text-decoration', 'none');
            }
            if(typeof obj.dsstrikethrough != 'undefined'){
                $('[data-layer="'+source+'"]').css('text-decoration', 'line-through');
                //var strike = '<strike>'+$('[data-layer="'+source+'"] span').text()+'<strike>';
                //$('[data-layer="'+source+'"] span').html(strike);
            }else{
                $('[data-layer="'+source+'"]').css('text-decoration', 'none');
                //var strike = $('[data-layer="'+source+'"] span').text();
                //$('[data-layer="'+source+'"] span').html(strike);
            }
            if(typeof obj.dsitalic != 'undefined'){
                $('[data-layer="'+source+'"]').css('font-style', 'italic');
            }else{
                $('[data-layer="'+source+'"]').css('font-style', 'normal');
            }
            //font streching
            var dstexthstrech = 1, dstextvstrech=1;
            if(typeof obj.dstextvstrech != 'undefined'){
                if(obj.dstextvstrech>=1)dstextvstrech = obj.dstextvstrech;
            }
            if(typeof obj.dstexthstrech != 'undefined'){
                if(obj.dstexthstrech>=1)dstexthstrech = obj.dstexthstrech;
            }
            var trans = 'scale('+dstexthstrech+','+dstextvstrech+')';
            $('[data-layer="'+source+'"] span').css('display', 'block');
           //$('[data-layer="'+source+'"] span').css('text-align', 'center');
           // $('[data-layer="'+source+'"] span').css('transform', trans);
         //   $('[data-layer="'+source+'"] span').css('-webkit-transform', trans);
        })
        $(document).on('change','.ds-settings',function(){
            var settings = $(this).val();
            var obj = JSON.parse(settings);
            var source = $(this).parents('[data-source]').data('source');
            if(obj.dselement_type==3){
                var content = obj.dsdefaultcontent;
                var bullet_type = obj.dsbullettype;
                var li_html = '';
                content = content.replace(/\r?\n/g, '-___-');
                var res = content.split('-___-');
                if(bullet_type=='1' || bullet_type==1){
                    var num = 1;
                }else if(bullet_type=='disc'){
                    var num = '&bull;';
                }else if(bullet_type=='circle'){
                    var num = '&#9900;';
                }else if(bullet_type=='square'){
                    var num = '&#9755;';
                }else{
                    var num = '&bull;';
                }
                content = '<ul class="nobullet">';
                $.each(res,function(i,v){
                    if(bullet_type=='1' || bullet_type==1){
                        content += '<li><span class="dsbullet">'+num+'.</span> '+v+'</li>';
                        num++;
                    }else{
                        content += '<li><span class="dsbullet">'+num+'</span> '+v+'</li>';
                    }
                })
                content += '</ul>';
                $('[data-layer="'+source+'"] span').html(content);
            }else{
                $('[data-layer="'+source+'"] span').text(obj.dsdefaultcontent);
            }
            
            $('[data-layer="'+source+'"]').css('max-width',obj.dsmaxwidth+'px');
            $('[data-layer="'+source+'"]').css('min-width',obj.dsmaxwidth+'px');
            $('[data-layer="'+source+'"]').css('max-height',obj.dsmaxheight+'px');
            $('[data-layer="'+source+'"]').css('min-height',obj.dsmaxheight+'px');
        })
        $(document).on('click','.source',function(){
            //alert(1);
            var layer = $(this).parents('[data-source]').data('source');
            $('[data-layer]').removeClass('selected');
            $('[data-layer="'+layer+'"]').addClass('selected');
            $('[data-source]').removeClass('active');
            $('[data-source="'+layer+'"]').addClass('active');
        })
    })
    
    $(function(){
        <?php if(!$edit){ ?>
        $('[data-source],[data-layer]').remove();
        <?php } ?>
        $(document).ready(function() {
        $(window).keydown(function(event){
            if(event.keyCode == 13 && (event.target.nodeName != "TEXTAREA" && event.target.nodeName != "textarea")) {
            event.preventDefault();
            return false;
            }
        });
        });
        init_elements();
        $('[data-source]').find('input, select').each(function(){
            $(this).change().blur();
        })

    })
    
    function show_step(num){
        if(num==2){
            if($('#width').val()==''){
                $("#infoMessage").html('<p class="alert alert-danger">Error, Please upload a valid video file to continue.</p>');
				$(".alert-danger").fadeTo(2000, 500).slideUp(800, function(){
                 $(".alert-danger").alert('close');
				 $("#targetsource").attr("src","");
		
});
				window.scrollTo(0,0);
                return false;
            }
			var form = $("#step-1");
            form.validate();
            if (form.valid() == false) {
                return;
            }
            else {
                $('.chosen-container').removeClass('qtip-custom');
                $(".input_disabled").prop('disabled', false);
		$("#btn_next").unbind("click");
            }
			
			
			
            $.post('<?php echo TEMPLATE_URL;?>update_section_video',$('#step-1').serialize(),function(data){
                <?php if(!$edit){ ?>
				
                data_points = JSON.parse(data);
				if(data_points.error != null && data_points.error != undefined){
					$("#infoMessage").html('<p class="alert alert-danger">'+data_points.error+'</p>');
			$(".alert-danger").fadeTo(2000, 500).slideUp(800, function(){
                 $(".alert-danger").alert('close');
				 $("#targetsource").attr("src","");
			});
			window.scrollTo(0,0);
			return;
				}
                //console.log(data);
                //$('[data-source],[data-layer]').remove();
                $.each(data_points, function(i,v){
                    if(v.data_category=='1'){
                        add_element(v.data_name, v.data_type, num, v.id);
                    }
                });
                $("#template_id").val(data_points.template_id);
                <?php } ?>
				
                $("#step_num").text(num);
                $('.file-upload').hide();
                $('[data-step]').hide();
                $('[data-step="'+num+'"]').show();
				if(document.getElementById("notify") != null){
					if(document.getElementById("notify").checked==true){
						$("#notify_check").val('1');
					}
				}
				$("#save_template").removeClass("hide");
                                $("#draft_template").removeClass("hide");
            });
        }
        if(num==3){
            <?php if(!$edit){ ?>
            $.each(data_points, function(i,v){
                if(v.data_category=='2'){
                    add_element(v.data_name, v.data_type, num, v.id);
                }
            })
            <?php } ?>
            $("#step_num").text(num);
            $('[data-step]').hide();
            $('[data-step="'+num+'"]').show();
            
        }
        current_step = num;
    }
    $(document).on("click", function (event) {
        var $trigger = $(".font-select");
        if ($trigger !== event.target && !$trigger.has(event.target).length) {
            $(".fs-drop").slideUp();
            $(".font-select").removeClass("font-select-active");
        }
    });
</script> 
<script src="<?php echo JS_URL.'file_upload_video.js';?>"></script> 
<!-- /footer content --> 
<script>
    /*
JS Modified from a tutorial found here: 
http://www.inwebson.com/html5/custom-html5-video-controls-with-jquery/

I really wanted to learn how to skin html5 video.
*/
$(document).ready(function(){
	//INITIALIZE
	var video = $('video');
	
	//remove default control when JS loaded
		if(video[0].hasAttribute("controls")){
	video[0].removeAttribute("controls");
		}
	
	$('.caption').fadeIn(500);
 
	//before everything get started
	video.on('loadedmetadata', function() {
			
		//set video properties
		$('.current').text(timeFormat(0));
		$('.duration').text(timeFormat(video[0].duration));
		updateVolume(0, 0.7);
			
		//start to get video buffering data 
		setTimeout(startBuffer, 150);
			
		//bind video events
		$('.videoContainer')
		.hover(function() {
			//$('.control').stop().fadeIn();
			$('.caption').stop().fadeIn();
		}, function() {
			if(!volumeDrag && !timeDrag){
				//$('.control').stop().fadeOut();
				$('.caption').stop().fadeOut();
			}
		})
		.on('click', function() {
			$('.btnPlay').find('.icon-play').addClass('icon-pause').removeClass('icon-play');
			$(this).unbind('click');
			video[0].play();
		});
	});
	
	//display video buffering bar
	var startBuffer = function() {
		var currentBuffer = video[0].buffered.end(0);
		var maxduration = video[0].duration;
		var perc = 100 * currentBuffer / maxduration;
		$('.bufferBar').css('width',perc+'%');
			
		if(currentBuffer < maxduration) {
			setTimeout(startBuffer, 500);
		}
	};	
	
	//display current video play time
	video.on('timeupdate', function() {
		var currentPos = video[0].currentTime;
		$(".curr-time").text(secondsToTime(video[0].currentTime));
		var maxduration = video[0].duration;
		var perc = 100 * currentPos / maxduration;
		$('.timeBar').css('width',perc+'%');	
		$('.current').text(timeFormat(currentPos));
                if(currentPos==maxduration){
                    $('.btnPlay').removeClass('paused');
                    $('.btnPlay').find('.icon-pause').removeClass('icon-pause').addClass('icon-play');
			video[0].pause();
                }
	});
	
	//CONTROLS EVENTS
	//video screen and play button clicked
	video.on('click', function() { playpause(); } );
	$('.btnPlay').on('click', function() { playpause(); } );
	var playpause = function() {
		
		if(video[0].paused || video[0].ended) {
			$('.btnPlay').addClass('paused');
			$('.btnPlay').find('.icon-play').addClass('icon-pause').removeClass('icon-play');
			video[0].play();
		}
		else {
			$('.btnPlay').removeClass('paused');
			$('.btnPlay').find('.icon-pause').removeClass('icon-pause').addClass('icon-play');
			video[0].pause();
		}
	};

	
	//fullscreen button clicked
	$('.btnFS').on('click', function() {
		if($.isFunction(video[0].webkitEnterFullscreen)) {
			video[0].webkitEnterFullscreen();
		}	
		else if ($.isFunction(video[0].mozRequestFullScreen)) {
			video[0].mozRequestFullScreen();
		}
		else {
			 $("#infoMessage").html('<p class="alert alert-danger">Error, Your Browser Don\'t Support Full Screen.</p>');
			 		$(".alert-danger").fadeTo(2000, 500).slideUp(800, function(){
                 $(".alert-danger").alert('close');
				 $("#targetsource").attr("src","");
});
		}
	});
	
	//sound button clicked
	$('.sound').click(function() {
		video[0].muted = !video[0].muted;
		$(this).toggleClass('muted');
		if(video[0].muted) {
			$('.volumeBar').css('width',0);
		}
		else{
			$('.volumeBar').css('width', video[0].volume*100+'%');
		}
	});
	
	//VIDEO EVENTS
	//video canplay event
	video.on('canplay', function() {
		$('.loading').fadeOut(100);
	});
	
	//video canplaythrough event
	//solve Chrome cache issue
	var completeloaded = false;
	video.on('canplaythrough', function() {
		completeloaded = true;
	});
	
	//video ended event
	video.on('ended', function() {
		$('.btnPlay').removeClass('paused');
		video[0].pause();
	});

	//video seeking event
	video.on('seeking', function() {
		//if video fully loaded, ignore loading screen
		if(!completeloaded) { 
			$('.loading').fadeIn(200);
		}	
	});
	
	//video seeked event
	video.on('seeked', function() { });
	
	//video waiting for more data event
	video.on('waiting', function() {
		$('.loading').fadeIn(200);
	});
	
	//VIDEO PROGRESS BAR
	//when video timebar clicked
	var timeDrag = false;	/* check for drag event */
	$('.progress').on('mousedown', function(e) {
		timeDrag = true;
		updatebar(e.pageX);
	});
	$(document).on('mouseup', function(e) {
		if(timeDrag) {
			timeDrag = false;
			updatebar(e.pageX);
		}
	});
	$(document).on('mousemove', function(e) {
		if(timeDrag) {
			updatebar(e.pageX);
		}
	});
	var updatebar = function(x) {
		var progress = $('.progress');
		
		//calculate drag position
		//and update video currenttime
		//as well as progress bar
		var maxduration = video[0].duration;
		
		var position = x - progress.offset().left;
		var percentage = 100 * position / progress.width();
		if(percentage > 100) {
			percentage = 100;
		}
		if(percentage < 0) {
			percentage = 0;
		}
		$('.timeBar').css('width',percentage+'%');	
		video[0].currentTime = maxduration * percentage / 100;
	};

	//VOLUME BAR
	//volume bar event
	var volumeDrag = false;
	$('.volume').on('mousedown', function(e) {
		volumeDrag = true;
		video[0].muted = false;
		$('.sound').removeClass('muted');
		updateVolume(e.pageX);
	});
	$(document).on('mouseup', function(e) {
		if(volumeDrag) {
			volumeDrag = false;
			updateVolume(e.pageX);
		}
	});
	$(document).on('mousemove', function(e) {
		if(volumeDrag) {
			updateVolume(e.pageX);
		}
	});
	var updateVolume = function(x, vol) {
		var volume = $('.volume');
		var percentage;
		//if only volume have specificed
		//then direct update volume
		if(vol) {
			percentage = vol * 100;
		}
		else {
			var position = x - volume.offset().left;
			percentage = 100 * position / volume.width();
		}
		
		if(percentage > 100) {
			percentage = 100;
		}
		if(percentage < 0) {
			percentage = 0;
		}
		
		//update volume bar and video volume
		$('.volumeBar').css('width',percentage+'%');	
		video[0].volume = percentage / 100;
		
		//change sound icon based on volume
		if(video[0].volume == 0){
			$('.sound').removeClass('sound2').addClass('muted');
		}
		else if(video[0].volume > 0.5){
			$('.sound').removeClass('muted').addClass('sound2');
		}
		else{
			$('.sound').removeClass('muted').removeClass('sound2');
		}
		
	};

	//Time format converter - 00:00
	var timeFormat = function(seconds){
		var m = Math.floor(seconds/60)<10 ? "0"+Math.floor(seconds/60) : Math.floor(seconds/60);
		var s = Math.floor(seconds-(m*60))<10 ? "0"+Math.floor(seconds-(m*60)) : Math.floor(seconds-(m*60));
		return m+":"+s;
	};
});

 function secondsToTime(secs)
{
    secs = Math.round(secs);
    var hours = Math.floor(secs / (60 * 60));
	if(hours<10){
		hours="0"+hours
	}

    var divisor_for_minutes = secs % (60 * 60);
    var minutes = Math.floor(divisor_for_minutes / 60);
	if(minutes<10){
		minutes="0"+minutes
	}
	

    var divisor_for_seconds = divisor_for_minutes % 60;
    var seconds = Math.ceil(divisor_for_seconds);
	if(seconds<10){
		seconds="0"+seconds
	}
    var obj = hours+":"+minutes+":"+ Math.round(seconds);
	 return obj;
}
   
function IstLetter(str){
	str = str.toLowerCase().replace(/\b[a-z]/g, function(letter) {
    return letter.toUpperCase();
});
return str;
}
    
    </script>