<?php
if (isset($user_info->account_holder_name) && $user_info->account_holder_name != "") {

    $name = $user_info->account_holder_name;
    $pos = strrpos($name, ' ');

    if ($pos === false) {
        $full_name = array(
            'firstname' => $name,
            'surname' => null
        );
    } else {
        $firstname = substr($name, 0, $pos + 1);
        $surname = substr($name, $pos);
        $full_name = array(
            'firstname' => $firstname,
            'surname' => $surname
        );
    }
}

?>

<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="clearfix">&nbsp;</div>
    <div class="row">
      <div class="col-md-7 col-sm-7">
        <div class="template_preview">
          <h3>TEMPLATE PREVIEW</h3>
          <input type="hidden" id="height" value="<?php echo $data1['height']?>">
          <input type="hidden" id="width" value="<?php echo $data1['width']?>">
          <div class="template_view" style="min-height:inherit"> 
            <!--                    	<span class="loading-img"><img src="images/loading.gif"><br>LOADING...</span>--> 
            <!--                        <div id="slider" style="display:none;"></div>--> 
            <span class="loading-img" style="display:none;"><img src="images/loading.gif"><br>
            LOADING...</span>
            <div id="video_container" class="videoContainer">
              <video autobuffer="autobuffer" controls width="100%">
                <source src="<?php echo ASSETS_URL."videos/".$data1['video']; ?>"></source>
                audio tag demo requires HTML 5 (try Firefox 3.5+) </video>
              <div class="canvas" id="lyrics">
                <?php
					if(isset($result4) && !empty($result4)){
                    foreach($result4 as $data){ 
                        $settings = json_decode($data['settings']);
                        $font_settings = json_decode($data['font_settings']);
                        $color = $data['color'];
                        $left = $data['cord_x'].'px';
                        $top = $data['cord_y'].'px';
                        $height = $settings->dsmaxheight.'px';
                        $width = $settings->dsmaxwidth.'px';
                        $fontsize = ($font_settings->dsfontsize*$dpi/72).'px';
                        $bold = isset($font_settings->dsbold)?'font-weight:bold':'font-weight:normal';
                        $fontfamily = isset($font_settings->dsfont)?  str_replace('+', ' ', $font_settings->dsfont):'';
                        $italic = isset($font_settings->dsitalic)?'font-style:italic':'font-style:normal';
                        $underline = isset($font_settings->dsunderline)?'text-decoration:underline':'text-decoration:none';
                        $strikethrough = isset($font_settings->dsstrikethrough)?'text-decoration:line-through':'text-decoration:none';
                        
                        
                        $dstexthstrech = 1; $dstextvstrech=1;
                        if(isset($font_settings->dstextvstrech)){
                            if($font_settings->dstextvstrech>=1)$dstextvstrech = $font_settings->dstextvstrech;
                        }
                        if(isset($font_settings->dstexthstrech)){
                            if($font_settings->dstexthstrech>=1)$dstexthstrech = $font_settings->dstexthstrech;
                        }
                        $trans = 'scale('.$dstexthstrech.','.$dstextvstrech.')';
                        if($data['element_type'] == 1){
                        ?>
                <div class="canvas_image canvas_elements" data-start="<?php echo $data['start']; ?>" data-stop="<?php echo $data['stop']; ?>" data-layer="<?php echo $data['element_name']; ?>"  data-layer="<?php echo $data['element_name']; ?>" style='<?php echo "overflow:hidden;left:$left;top:$top;color: $color;font-size:$fontsize;text-align: $font_settings->dsalign;font-family: $fontfamily;$bold;$italic;$strikethrough;height:$height;width:$width; "; ?>'>
                <span style="<?php echo "$underline;display:block;transform:$trans;-webkit-transform;$trans;"; ?>"><?php echo $settings->dsdefaultcontent; ?></span></div>
              <?php }elseif($data['element_type'] == 2){
						  if($data['element_name'] == "First Name") { 
						  ?>
              <div class="canvas_text canvas_elements" data-start="<?php echo $data['start']; ?>" data-stop="<?php echo $data['stop']; ?>" data-layer="<?php echo $data['element_name']; ?>"  data-layer="<?php echo $data['element_name']; ?>"  style='<?php echo "overflow:hidden;left:$left;top:$top;color: $color;font-size: $fontsize;text-align: $font_settings->dsalign;font-family: $fontfamily;$bold;$italic;$strikethrough;height:$height;width:$width; "; ?>'>
              <span style="<?php echo "$underline;display:block;transform:$trans;-webkit-transform;$trans;"; ?>"><?php echo isset($full_name['firstname']) && $full_name['firstname']!="" ? trim($full_name['firstname']) : $settings->dsdefaultcontent; ?></span></div>
            <?php
						  }
						  elseif($data['element_name']=="Last Name"){
							  ?>
            <div class="canvas_text canvas_elements" data-start="<?php echo $data['start']; ?>" data-stop="<?php echo $data['stop']; ?>" data-layer="<?php echo $data['element_name']; ?>"  data-layer="<?php echo $data['element_name']; ?>"  style='<?php echo "overflow:hidden;left:$left;top:$top;color: $color;font-size: $fontsize;text-align: $font_settings->dsalign;font-family: $fontfamily;$bold;$italic;$strikethrough;height:$height;width:$width; "; ?>'>
            <span style="<?php echo "$underline;display:block;transform:$trans;-webkit-transform;$trans;"; ?>"><?php echo isset($full_name['surname']) && $full_name['surname']!="" ? trim($full_name['surname']) : $settings->dsdefaultcontent; ?></span></div>
          <?php
						  }
						  else{
                        ?>
          <div class="canvas_text canvas_elements" data-start="<?php echo $data['start']; ?>" data-stop="<?php echo $data['stop']; ?>" data-layer="<?php echo $data['element_name']; ?>"  data-layer="<?php echo $data['element_name']; ?>"  style='<?php echo "overflow:hidden;left:$left;top:$top;color: $color;font-size: $fontsize;text-align: $font_settings->dsalign;font-family: $fontfamily;$bold;$italic;$strikethrough;height:$height;width:$width; "; ?>'>
          <span style="<?php echo "$underline;display:block;transform:$trans;-webkit-transform;$trans;"; ?>"><?php echo $settings->dsdefaultcontent; ?></span></div>
        <?php
						  }
						
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

                            ?>
        <div class="canvas_text canvas_elements" data-start="<?php echo $data['start']; ?>" data-stop="<?php echo $data['stop']; ?>" data-layer="<?php echo $data['element_name']; ?>"  data-layer="<?php echo $data['element_name']; ?>"  style='<?php echo "overflow:hidden;left:$left;top:$top;color: $color;font-size: $fontsize;text-align: $font_settings->dsalign;font-family: $fontfamily;$bold;$italic;$strikethrough;height:$height;width:$width; "; ?>'>
        <span style="<?php echo "$underline;display:block;transform:$trans;-webkit-transform;$trans;"; ?>"><?php echo $content; ?></span></div>
      <?php
                             }  
                    if(trim($font_settings->dsfont)!=''){
                    ?>
      <link href="https://fonts.googleapis.com/css?family=<?php echo $font_settings->dsfont; ?>" rel="stylesheet" type="text/css">
      <?php
                    }
                    }
					}
					 ?>
    </div>
  </div>
  <div class="control" style="position:absolute" >
    <div class="btmControl">
      <div class="btnPlay btn" title="Play/Pause video"><span class="icon-play"></span></div>
      <div class="progress-bar">
        <div class="progress"> <span class="bufferBar"></span> <span class="timeBar"></span> </div>
      </div>
      <div class="progress-bar curr-time" style="line-height:10px !important;"> 00:00:00 </div>
      <!--<div class="volume" title="Set volume">
                                            <span class="volumeBar"></span>
                                    </div>-->
      <div class="sound sound2 btn" title="Mute/Unmute sound"><span class="icon-sound"></span></div>
      <!--                                    <div class="btnFS btn" title="Switch to full screen"><span class="icon-fullscreen"></span></div>--> 
    </div>
  </div>
</div>
</div>
</div>
<div class="col-md-5 col-sm-5">
  <div class="x_panel template_perametors">
    <h2>TEMPLATES</h2>
    <form action="<?php echo TEMPLATE_URL;?>export_video" method="post" id="export_frm" enctype="multipart/form-data">
      <?php 
                        $i = 0;
                        ini_set('display_errors',0);
                    mysql_data_seek($result, 0);
                     foreach($result4 as $data){
                            $settings = json_decode($data['settings']);
                            $readonly = isset($settings->dsusereditable)?true:false;
                            if(!$readonly){?>
      <div class="row" data-source="<?php echo $data['element_name']; ?>">
        <div class="col-sm-12">
          <label class="control-label" for="full-name"><span class="source" style="cursor:pointer;"><?php echo $data['element_name']; ?></span></label>
          <?php 
                        if($data['element_type'] == 2){
							 if($data['element_name'] == "First Name") {
								  ?>
          <input value="<?php echo isset($full_name['firstname']) && $full_name['firstname']!="" ? trim($full_name['firstname']) : ''; ?>" type="text" placeholder="<?php echo $settings->dsdefaultcontent; ?>" maxlength="<?php echo $settings->dsmaxchars; ?>" class="form-control element_type" <?php echo $readonly; ?> data-element_type="<?php echo $data['element_type']; ?>" name="value[]">
          <?php
								 
								 }elseif($data['element_name'] == "Last Name") { ?>
          <input value="<?php echo isset($full_name['surname']) && $full_name['surname']!="" ? trim($full_name['surname']) : ''; ?>" type="text" placeholder="<?php echo $settings->dsdefaultcontent; ?>" maxlength="<?php echo $settings->dsmaxchars; ?>" class="form-control element_type" <?php echo $readonly; ?> data-element_type="<?php echo $data['element_type']; ?>" name="value[]">
          <?php
                            }else{
							 ?>
          <input type="text" placeholder="<?php echo $settings->dsdefaultcontent; ?>" maxlength="<?php echo $settings->dsmaxchars; ?>" class="form-control element_type" <?php echo $readonly; ?> data-element_type="<?php echo $data['element_type']; ?>" name="value[]">
          <?php }
							}elseif($data['element_type'] == 1){ ?>
          <input type="file" name="FileInput[]" class="form-control element_image">
          <?php }elseif($data['element_type'] == 3){?>
          <textarea placeholder="<?php echo $settings->dsdefaultcontent; ?>" maxlength="<?php echo $settings->dsmaxchars; ?>" class="form-control element_type" <?php echo $readonly; ?> data-element_type="<?php echo $data['element_type']; ?>" data-bullet_type="<?php echo $settings->dsbullettype; ?>" name="value[]"></textarea>
          <?php if(isset($settings->dsscalefont)){ ?>
          <span class="dssettings-parent">
          <input type="text" class="ds-fontpick" name="font_settings[]" value='<?php echo $data['font_settings']; ?>'>
          </span>
          <?php } ?>
          <?php } ?>
          <input type="hidden" value="<?php echo $data['element_type']; ?>" name="element_type[]">
          <input type="hidden" value="<?php echo $data['cord_x']; ?>" name="cord_x[]" >
          <input type="hidden" value="<?php echo $data['cord_y']; ?>" name="cord_y[]">
          <input type="hidden" value="<?php echo $data['start']; ?>" name="start[]">
          <input type="hidden" value="<?php echo $data['stop']; ?>" name="end[]">
          <?php if(isset($settings->dsscalefont)){ ?>
          <span class="dssettings-parent">
          <input type="text" class="ds-fontpick" name="font_settings[]" value='<?php echo $data['font_settings']; ?>'>
          </span>
          <?php }else{ ?>
          <input type="hidden" name="font_settings[]" value='<?php echo $data['font_settings']; ?>'>
          <?php } ?>
          <input type="hidden" name="color[]" value='<?php echo $data['color']; ?>'>
        </div>
      </div>
      <?php }} ?>
      <div class="row">
        <div class="col-sm-12">
          <?php if(isset($data1) && !empty($data1) && $data1['template_name']){
						?>
          <input type="hidden" name="origfilename" id="origfilename" value="<?php echo $data1['template_name'];?>" />
          <input type="hidden" name="template_id" value="<?php echo $data1['id'];?>" />
          <?php
					}
					?>
          <label class="control-label" for="email">Save File As:</label>
          <select id="filetype" name="file_type" class="form-control">
            <option value="mp4">mp4</option>
          </select>
          <input type="hidden" name="video" value="<?php echo $data1['video']; ?>">
        </div>
        <div class="col-sm-12"> <a href="javascript:void(0);" id="download" class="btn btn-primary">SAVE FILE</a> </div>
      </div>
    </form>
  </div>
</div>
</div>
</div>
</div>
<script src="<?php echo JS_URL.'myPlugin/myPlugin.js';?>"></script> 
<script src="<?php echo JS_URL.'jquery.annotatevideo.js';?>"></script>
<style>
    .canvas{
        position:absolute;left:20px;top:0px;width: 100%;height:100%;overflow: hidden;
    }
    .style_canvas{
        position: absolute;
    }
    .canvas_elements{
        position: absolute;
        cursor: pointer;
    }
    .canvas_elements.selected:after {
        content: "x";
        font-family: arial;
        color: #000;
        position: absolute;
        top:0;right:0;
    }
    .canvas_elements.selected{
        border: 1px dotted #333;
    }
    .canvas_image{
         border: 1px solid #666;
         min-height:10px;
         min-width:10px;
         overflow:hidden;
    }
    .canvas_image img{
        max-width:none;
    }
    .dssettings-parent {
        float: right;
        top: -45px;
        right: 5px;
    }
    /*** VIDEO CONTROLS CSS ***/
    .videoContainer{overflow:auto; max-height: 600px; width: 100%; padding-bottom:35px;}
/* control holder */
.control{
	color:#ccc;
/*	position:absolute;*/
	bottom:20px;
	left:0;
        right:0;
        margin:auto;
	width:310px;
	z-index:5;
	display:block;
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
	border: 1px solid rgba(0,0,0,0.7);
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
    
    
    var dpi = <?php echo $dpi; ?>;
    var width = <?php echo $canvaswidth; ?>;
    var height = <?php echo $canvasheight; ?>;
    var zoom = 55;
    var canvas = $('.canvas');
    function set_dimensions(){
        width = $('video').width();
        height = $('video').height();
        data_width = $('#width').val();
        data_height = $('#height').val();
        width_per = (width/data_width)*100;
        height_per = (height/data_height)*100;
        canvas.css('width',data_width+'px');
        canvas.css('height',data_height-+'px');
      //  canvas.css('zoom', width_per+'%' );
        canvas.css('transform-origin', 'top left' );
        $('#lyrics').css('width',width);
        
    //    canvas.css('-moz-transform', ' scale('+width_per/100+')' );
    }
    $(function(){
        set_dimensions();
        $(window).on('resize',function(){set_dimensions()});
        $('#menu_toggle').on('click',function(){set_dimensions()});
        $('#lyrics div').each(function(){
                jQuery('video').annotatevideo({
                        start : $(this).attr('data-start'),
                        stop  : $(this).attr('data-stop'),
                        elem  : $(this)
                });
        });
        
//        canvas.css('zoom', zoom+'%' );
//        canvas.css('transform-origin', 'top left' );
//        canvas.css('transform', ' scale('+zoom/100+')' );
        $( "#slider" ).slider({
         min: 10,
         max:100,
         step:10,
         value: zoom,
            slide: function( event, ui ) {
//                canvas.css('zoom', ui.value+'%' );
//                canvas.css('transform', ' scale('+ui.value/100+')' );
            }
        });
        //image croping customized
        function setImage(source,url){
            var img = $('<img>');
            var img_container1 = $('#edit_image');
            img_container1.html('');
            var img_container = $('[data-layer="'+source+'"]');
            img.attr('src',url);
            //img_container.html(img);
            
            var div_inner = $('<div></div>');
            var div_outer = $('<div></div>');
            div_outer.css('position','absolute');
            div_outer.css('top','15px');
            div_outer.css('outline-color','red');
            div_outer.css('outline-style','dashed');
            
            div_outer.html(div_inner);
            
            var maskWidth  = img_container.width();
            var maskHeight = img_container.height();
            img_container1.css('height',maskHeight+'px');
            img_container1.css('width',maskWidth+'px');
            img_container1.css('overflow','hidden');
            img_container1.css('position','relative');
            img.css('height',maskHeight+'px');
            img.css('width',maskWidth+'px');
            img.css('position','absolute');
            div_inner.css('height',maskHeight+'px');
            div_inner.css('width',maskWidth+'px');
            $('#apply_image_changes').unbind('click');
            $('#apply_image_changes').bind('click',function(){
                img_container.html(img);
                img_container.css('border','none');
                $('#image_edit_modal').modal('hide');
            })
            img_container1.html(img);
            img_container1.after(div_outer);
          
            $('#image_edit_modal').modal('show');
            
            $('#image_edit_modal').on('hidden.bs.modal',function(){
                div_inner.remove();
                div_outer.remove();
                img_container1.html('');
            })
            $('#image_edit_modal').on('shown.bs.modal',function(){
                div_outer.draggable({
                    //containment:'body',
                    drag: function(){
                        var offset = $(this).offset();
                        var xPos = offset.left;
                        var yPos = offset.top;
                        img.css('left',xPos-img_container1.offset().left+'px');
                        img.css('top',yPos-img_container1.offset().top+'px');
                    }
                });
                div_inner.resizable({
                    handles: 'n, e, s, w, ne, se, sw, nw',
                    resize: function(event, ui) {
                        var width = ui.size.width;
                        var height = ui.size.height;
                        img.css('width',width+'px');
                        img.css('height',height+'px');
                    }
                });
                div_inner.css({cursor: 'move'});
            });
        }
        //image croping from image area select jquery
        function setImage1(source,url){
            var img_x = $('<img data-imgid="'+source+'">');
            var img1 = $('<img data-imgid1="'+source+'">');
            var active_crop = false;
            var img_container = $('[data-layer="'+source+'"]');
            var img_container1 = $('#edit_image');
            var img_container2 = $('#edit_image1');
            img_container1.html('');
            img_container2.html('');
            
            img_x.attr('src',url);
            img1.attr('src',url);
            
            var maskWidth  = img_container.width();
            var maskHeight = img_container.height();
            img_container1.css('height',maskHeight+'px');
            img_container1.css('width',maskWidth+'px');
            img1.css('width','568px');
            img_container1.css('overflow','hidden');
            img_container1.css('position','relative');
            
            img_x.css('position','absolute');
            
            $('#apply_image_changes').unbind('click');
            $('#apply_image_changes').bind('click',function(){
                active_crop= false;
                img_container.html(img_x);
                img_container.css('border','none');
                img_container.css('text-align','left');
                $('#image_edit_modal').modal('hide');
            })
            img_container1.html(img_x);
            img_container2.html(img1);
            $('#image_edit_modal').modal('show');
            
            $('#image_edit_modal').unbind('hidden.bs.modal').on('hidden.bs.modal',function(){
                img_container1.html('');
                $('[class*=imgareaselect]').remove();
            })
            $('#image_edit_modal').unbind('shown.bs.modal').on('shown.bs.modal',function(){
                
                var scaleX = maskWidth / (maskWidth || 1);
                var scaleY = maskHeight / (maskHeight || 1);

                img_x.css({
                    width: Math.round(scaleX * img1.width()) + 'px',
                    height: Math.round(scaleY * img1.height()) + 'px',
                    marginLeft: '-' + Math.round(scaleX * 0) + 'px',
                    marginTop: '-' + Math.round(scaleY * 0) + 'px'
                });

                active_crop = true;
                img1.imgAreaSelect({
                    handles: true,
                    aspectRatio: maskWidth+':'+maskHeight,
                    x1: 0, y1: 0, x2: maskWidth, y2: maskHeight,
                    onSelectChange: function(img_test, selection){
                        if(!active_crop)return false;
                        scaleX = maskWidth / (selection.width || maskWidth);
                        scaleY = maskHeight / (selection.height || maskHeight);
                        
                        img_x.css({
                            width: Math.round(scaleX * img1.width()) + 'px',
                            height: Math.round(scaleY * img1.height()) + 'px',
                            marginLeft: '-' + Math.round(scaleX * selection.x1) + 'px',
                            marginTop: '-' + Math.round(scaleY * selection.y1) + 'px'
                        });
                    }
                });
            });
        }
        //load image at client size
        function readURL(input,source) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                
                reader.onload = function (e) {
                    setImage(source, e.target.result);
                }
                
                reader.readAsDataURL(input.files[0]);
            }
        }
        function afterSuccess()
        {
            readURL(this,source);
            $('#submit-btn').show(); //hide submit button
            $('#loading-img').hide(); //hide submit button
            $('#progressbox').delay( 1000 ).fadeOut(); //hide progress bar
            
        }
        $(".element_image").change(function(){
            var that = $(this).parents('form');
            var source = $(this).parents('[data-source]').data('source');
            //readURL(this,source);
            var options = { 
                //			target:   '#output',   // target element(s) to be updated with server response 
                //			beforeSubmit:  beforeSubmit,  // pre-submit callback 
                success:       function(data){
                    data = JSON.parse(data);
                    if(data.status){
                        setImage1(source, 'uploads/'+data.file);
                    }else{
                        alert(data.msg);
                    }
                },  // post-submit callback 
                //			uploadProgress: OnProgress, //upload progress callback 
                resetForm: true        // reset the form after successful submit 
            }; 
            that.ajaxSubmit(options);  
            return false;
        });
        
        $('.element_type').on('keyup change', function(){
            var source = $(this).parents('[data-source]').data('source');
            var element_type=$(this).data('element_type');
            if(element_type==2){
                $('[data-layer="'+source+'"] span').html($(this).val());
            }else if(element_type==3){
                var dsbullettype = $(this).data('bullet_type');
                var content = $(this).val();
                var li_html = '';
                content = content.replace(/\r?\n/g, '-___-');
                var res = content.split('-___-');
                var content = '<ul class="nobullet">';
                if(dsbullettype=='1' || dsbullettype==1){
                    var num = 1;
                }else if(dsbullettype=='disc'){
                    var num = '&bull;';
                }else if(dsbullettype=='circle'){
                    var num = '&#9900;';
                }else if(dsbullettype=='square'){
                    var num = '&#9755;';
                }else{
                    var num = '&bull;';
                }
                
                $.each(res,function(i,v){
                    if(dsbullettype=='1' || dsbullettype==1){
                        content += '<li><span class="dsbullet">'+num+'.</span> '+v+'</li>';
                        num++;
                    }else{
                        content += '<li><span class="dsbullet">'+num+'</span> '+v+'</li>';
                    }
                })
                content += '</ui>';
                $('[data-layer="'+source+'"] span').html(content);
            }
        })
        $('#download').on('click', function(){
            $('#export_frm').submit();
        })
        
        var romanize = function(userNumber) {
        var rome = [];
        for (var i = 0; i <= userNumber; i++) {
            if (userNumber >= 5) {
            rome.push("V");
            userNumber = (userNumber % 5);
            } else if (userNumber === 4) {
            return "IV";
            } else if (userNumber <= 3) {
            rome.push("I");
            }
        }
        return rome
        };
        
        
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
                $('[data-layer="'+source+'"] span').css('line-height', dstextheight+'px');
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
            }else{
                $('[data-layer="'+source+'"]').css('text-decoration', 'none');
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
            $('[data-layer="'+source+'"] span').css('transform', trans);
            $('[data-layer="'+source+'"] span').css('-webkit-transform', trans);
        })
    })
    
</script> 
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
	video[0].removeAttribute("controls");
	
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
			alert('Your browsers doesn\'t support fullscreen');
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
    </script>