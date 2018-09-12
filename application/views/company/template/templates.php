<style type="text/css">
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
<div class="col-md-12 col-sm-12 col-xs-12">
  <div id="infoMessage">
    <?php if (isset($message)) {
            ?>
    <p class="alert alert-success text-left">
      <?php
                echo $message;
                ?>
    </p>
    <?php }
        ?>
    <?php if (isset($error)) {
            ?>
    <p class="alert alert-danger text-left">
      <?php
                echo $error;
                ?>
    </p>
    <?php }
        ?>
  </div>
  <div class="clearfix">&nbsp;</div>
  <?php if (count($template_list) > 0 && isset($template_list) && !empty($template_list)) { ?>
  <div class="row">
    <div class="col-md-5 col-sm-5">
      <div class="template_preview">
        <h3>TEMPLATE PREVIEW</h3>
        <div class="template_view" style="min-height:450px;"> 
          <!--                    	<span class="loading-img"><img src="images/loading.gif"><br>LOADING...</span>-->
          
          <div id="slider" class='hide'>
            <input type="hidden" id="hidden"/>
          </div>
          <div class="canvas_overflow">
            <div class="canvas" style="" id="canvas"> <span class="loading-img hide"><img src="<?php echo IMAGES_URL; ?>loading.gif"><br>
              LOADING...</span> <img src='' id='img_preview' class='hide'>
              <div id="video_container" class="videoContainer hide" > </div>
              <div class="control hide" id="controls_bar">
                            

                    </div>
            </div>
          </div>
        </div>
      </div>
      <div class="template_info hide" >
        <div class="pull-right"> <span id="personalize"><a href='' class='label label-success'>PERSONALIZE</a></span> <span id="edit"><a href='#' class='label label-danger'>EDIT</a></span> <span id="duplicate"></span> </div>
        <h4>Template Design 1</h4>
        <ul>
          <li id='tid'></li>
          <li id='t_type'></li>
          <li id='t_size'></li>
          <li id='dpi'></li>
          <li id='color'></li>
          <li id='t_group'></li>
        </ul>
        <h4>Description:</h4>
        <ul>
          <li id='t_desc'></li>
        </ul>
        <h4>Change History:</h4>
        <ul id="history">
          <li>01/25/16 - by First Lastname</li>
          <li>02/09/16 - by First Lastname</li>
        </ul>
      </div>
    </div>
    <div class="col-md-7 col-sm-7">
      <div class="x_panel">
        <div class="x_content">
          <h3 class="sections-head">TEMPLATES</h3>
          <table class="table table-striped table-bordered datatable_new">
            <thead>
              <tr>
                <th></th>
                <th>TITLE</th>
                <th>TYPE</th>
                <th>GROUP(S)</th>
                <th>STATUS</th>
                <th>ACTIONS</th>
              </tr>
            </thead>
            <tbody>
              <?php
                                if (isset($template_list) && count($template_list) > 0 && !empty($template_list)) {
                                    foreach ($template_list as $value) {
                                        if ($value->is_active == 1) {
                                            $checked = "checked='checked'";
                                        } else {
                                            $checked = "";
                                        }

                                        if ($value->source == '1') {
                                            $page_video = 'user_edit_video_template';
                                            $page = 'admin_edit_template';
                                            $edit = 'custom_template';
                                            $tid = $this->encrypt->encode($value->id);
                                            $tid = str_replace(array('+', '/', '='), array('-', '_', '~'), $tid);
                                        } else {
                                            $page_video = 'user_edit_video_template';
                                            $page = 'admin_design_template';
                                            $edit = 'design_template';
                                            $tid = $this->encrypt->encode($value->id);
                                            $tid = str_replace(array('+', '/', '='), array('-', '_', '~'), $tid);
                                        }

                                        if ($value->is_publish == '0') {
                                              if($value->video=='') {
                                            $edit_url = TEMPLATE_URL . $edit . "/" . $tid;
                                            }
                                            else{
                                            $edit_url = TEMPLATE_URL . 'video' . "/" . $tid;    
                                            }
                                            
                                            $edit_label = "label-danger";

                                            $personalize_url = "javascript:void();";
                                            $personalize_label = "label-gray";
                                        } else {
                                            $edit_url = "javascript:void();";
                                            $edit_label = "label-gray";

                                            $personalize_url = TEMPLATE_URL . $page . '/' . $tid;
                                            $personalize_label = "label-success";
                                        }
										
                                        echo "<tr>"
                                        . "<td><input type='radio' name='preview' class='preview flat' value='" . $value->id . "'></td>"
                                        . "<td>" . $value->title . "</td>"
                                        . "<td>" . ($value->category == '2' ? 'Banner Ads' : $value->type) . "</td>"
                                        . "<td>" . $value->t_group . "</td>"
                                        . "<td> <div id='toggle_over'> <input type='checkbox' " . $checked . " id='u_id_" . $value->id . "' name='status_" . $value->id . "' data-status='" . $value->is_active . "' class='ios-toggle template_status' value='$value->id' /> <label for='u_id_" . $value->id . "' class='checkbox-label'></label></div></td>"
                                        . "<td><a href='" . (isset($value->video) && $value->video!="" ? TEMPLATE_URL . $page_video . '/' . $tid : $personalize_url) . "' class='label " . $personalize_label . "'>PERSONALIZE</a> <a  href='" . $edit_url . "' class='label " . $edit_label . "'>EDIT</a> <a href='#' class='label label-warning lblduplicate' data-id='" . $value->id . "'  data-toggle=\"modal\" data-target=\"#myModal\">DUPLICATE</a> <a href='javascript:void();' data-id='" . $value->id . "'  class='label label-danger template_del'>DELETE</a> </td>"
                                        . "</tr>";
										
                                    }
                                }
                                ?>
            </tbody>
          </table>
        </div>
      </div>
      <div class="x_panel">
        <div class="x_content">
          <h3 class="sections-head">SAVED FILES</h3>
          <table class="table table-striped table-bordered datatable_new">
            <thead>
              <tr>
                <th>TITLE</th>
                <th>TYPE</th>
                <th>FILE TYPE</th>
                <th>DATE CREATED</th>
                <th>ACTIONS</th>
              </tr>
            </thead>
            <tbody>
              <?php
                                
                                if (isset($template_savelist) && count($template_savelist) > 0 && !empty($template_savelist)) {
                                    foreach ($template_savelist as $value) {
                                        if ($value->category == '1') {
                                            $type = "Print Ads";
                                        } else if ($value->category == '2') {
                                            $type = "Banner Ads";
                                        } else {
                                            $type = "Video";
                                        }
                                        $tid = $this->encrypt->encode($value->id);
                                        $tid = str_replace(array('+', '/', '='), array('-', '_', '-'), $tid);
                                        $ext = @pathinfo($value->file_path, PATHINFO_EXTENSION);
										if($type=="Video"){
                                        $filepath = TEMPLATE_URL . 'viewtemplate/' . $tid.'/'.$type;
										}
										else{
											$filepath = TEMPLATE_URL . 'viewtemplate/' . $tid;
										}
                                        echo "<tr>"
                                        . "<td>" . $value->title . "</td>"
                                        . "<td>" . $type . "</td>"
                                        . "<td>" . $ext . "</td>"
                                        . "<td>" . date(DATE_FORMAT, strtotime($value->created_on)) . "</td>"
                                        . "<td><a href='" . TEMPLATE_URL . 'download/' . $tid."/$type" . "' class='label label-download' data-toggle='tooltip'  alt='Download' title='Download'> <i class='fa fa-download'></i></a>  <a href='mailto:?subject=I have Created something intersting using brandize.com&body=$filepath' class='label label-success'>SEND</a> <a href='#' class='label label-warning lblcopy clipbrd'   data-clipboard-text='" . $filepath . "'>LINK</a> <a href='javascript:void();' data-id='" . $value->id . "'  class='label label-danger per_template_del'>DELETE</a> </td>"
                                        . "</tr>";
                                    }
                                }
                                ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <?php
    } else {
        echo "<p class='alert alert-danger text-left'>You have not created any template yet , <a href='" . COMPANY_URL . "customtemplate'>click here</a> to design new template</p>";
    }
    ?>
</div>
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog"> 
    
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Please enter the name for duplicate template.</h4>
      </div>
      <form action="<?php echo TEMPLATE_URL; ?>duplicatetemplate" id="template_form" method="post">
        <div class="modal-body">
          <div class="alert alert-danger hide" id="errormsgtemplate"></div>
          <p>
            <input type="hidden" name="chngetemplate_id" id="chngetemplate_id" />
            <input type="hidden" name="redirect" id="redirect" value='template' />
          </p>
          <input type="text" name="newtemplatename" id="newtemplatename" class="form-control"/>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Proceed</button>
        </div>
      </form>
    </div>
  </div>
</div>
<script src="<?php echo JS_URL; ?>clipboard.min.js"></script> 
<script>

    $(document).ready(function () {
        $('.datatable_new').DataTable({

			  stateSave: true,
            "sDom": '<"row view-filter"<"col-sm-12"<"pull-left"l><"pull-right"f><"clearfix">>>t<"row view-pager"<"col-sm-12"<"text-center"ip>>>',
            'fnDrawCallback' : function(e) {
                $('input.flat').iCheck({
                 radioClass: 'iradio_flat-blue'
                });
        
             },
            "ordering": false,
            "bFilter": false,
            "bInfo":false,
            "bLengthChange": false,
           "pagingType" :"simple_numbers"
           
        });
        
        
    });
 

    var canvas = $('.canvas');

    var zoom = 55;
    $(document).ready(function () {

//        canvas.css('transform-origin', 'top left');
//        canvas.css('transform', ' scale(' + zoom / 100 + ')');
        $("#slider").slider({
            animate: true,
            range: "min",
            min: 10,
            max: 300,
            step: 5,
            value: zoom,
            slide: function (event, ui) {
                zoom = ui.value;
                //canvas.css('zoom', ui.value+'%' );
                canvas.css('transform', ' scale(' + ui.value / 100 + ')');
            }
        });
        $(document).on('ifChecked', '.flat', function()  {
            canvas.css('position','');
            canvas.css('transform-origin', '');
            canvas.css('transform', '');
            $("#img_preview").removeClass("show").addClass('hide');
            $('.loading-img').removeClass('hide');
            $('.loading-img').addClass('show');
            $("#slider").removeClass("show").addClass('hide');
           
            var t_value = $(this).val();
            $.post(SITE_URL + 'template/get_preview', {'id': t_value }, function (result) {
				
                result = JSON.parse(result);
                $.each(result, function (i, v) {
                    $('#tid').html("Template ID #:" + v.id);
                    $('#t_type').html("Type :" + v.type);
                    $('#t_size').html("Size :" + v.width + ' x ' + v.height + 'px');
                    $('#t_group').html("Groups(s) #:" + v.t_group);
                    $('#t_desc').html("Description #:" + v.description);
                    if (v.is_publish == '0') {
                        url_per = "javascript:void();";
                        per_label = "label-gray";
                    }
                    else {
                        url_per = "<?php TEMPLATE_URL; ?>" + v.page + "/" + v.tid;
                        per_label = "label-success";
                    }
                    $('#personalize').html("<a href='" + url_per + "' class='label " + per_label + "'>PERSONALIZE</a>");
                    if (v.is_publish == '0') {
                        url_edit = "<?php TEMPLATE_URL; ?>" + v.edit + "/" + v.tid;
                        edit_label = "label-danger";
                    }
                    else {
                        url_edit = "javascript:void();";
                        edit_label = "label-gray";
                    }

                    $('#edit').html("<a href='" + url_edit + "' class='label " + edit_label + "'>EDIT</a>");

                    $('#duplicate').html("<a href='#' class='label label-warning lblduplicate' data-id='" + v.id + "'  data-toggle=\"modal\" data-target=\"#myModal\">DUPLICATE</a>");
                    if (v.type != "VIDEO") {
                        if (v.preview_img != null) {
                            $('#img_preview').attr('src', v.preview_img);
                        }
                        else {
                            $('#img_preview').attr('src', SITE_URL + 'assets/upload/templates/' + v.background_image);
                        }
                        $('.loading-img').hide();
                        $("#video_container").toggleClass("hide");
                        //$("#img_preview").toggleClass("hide");
                        canvas.css('position','relative');
                        canvas.css('transform-origin', 'top left');
                        canvas.css('transform', ' scale(' + zoom / 100 + ')');
                        $("#img_preview").removeClass("hide").addClass('show');
                        $(".loading-img").removeClass("show").addClass('hide');
                        // $('#slider').toggleClass('hide');
                        if($("#slider").hasClass("hide")){
							$("#slider").removeClass("hide");
						}
						$("#video_container").html('');
                        $("#canvas").css('transform', ' scale(' + zoom / 100 + ')');
						if($("#controls_bar").hasClass("hide")){
							
						}
						else{
							$("#controls_bar").addClass("hide");
						}

                    } else {
						
                        if ($("#video_container").hasClass("hide")) {
                            $("#video_container").removeClass("hide")
                        }
                     
						$("#img_preview").removeClass("show");
						$("#img_preview").addClass("hide");
						 if($("#slider").hasClass("hide")){
							 $("#slider").removeClass("hide");
							 $("#slider").addClass("hide");
						 }
						 else{
                        $("#slider").addClass("hide");
						 }
                        var m_video = document.createElement("video");
                        m_video.setAttribute("autobuffer", "autobuffer");
                        
                        m_video.setAttribute("width", v.width+"px");
                        m_video.setAttribute("height", v.height+"px");
							
                        var source = "";
                        source = document.createElement("source");
                        source.setAttribute("src", SITE_URL + 'assets/videos/final/' + v.preview_img);
                        source.setAttribute("width", v.width+"px");
                        source.setAttribute("height", v.height+"px");
                        m_video.appendChild(source);
                        var videocontainer = document.getElementById("video_container");
                        videocontainer.innerHTML = "";
                        videocontainer.appendChild(m_video);
                        $("#canvas").css('transform', ' scale(1.0)');
						$("#controls_bar").html("");
					
						$("#controls_bar").html('<div class="btmControl"><div class="btnPlay btn" title="Play/Pause video"><span class="icon-play"></span></div><div class="progress-bar"><div class="progress"><span class="bufferBar"></span><span class="timeBar"></span></div></div><div class="progress-bar curr-time" id="curr_time" style="line-height:10px !important;">00:00:00</div><div class="sound sound2 btn" title="Mute/Unmute sound"><span class="icon-sound"></span></div></div>');	
						if($("#controls_bar").hasClass("hide")){
							$("#controls_bar").removeClass("hide");
						}
						
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
			
		if((currentBuffer < maxduration) ) {
			//setTimeout(startBuffer, 500);
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

                    }
                    var li = "";
                    revision = JSON.parse(v.history);
                    if (revision.length > 0) {
                        $.each(revision, function (i, s) {
                            li += "<li>" + s.modify_date + ' - by ' + s.account_holder_name + "</li>";
                        });
                    }
                    else {
                        li += "<li>No Revisions</li>"
                    }
                    $('#history').html(li);
                });

                $('.template_info').removeClass('hide');
                $('.template_info').addClass('show');
            });
        });
    });

    $(document).on("click", ".template_status", function (e) {
        e.preventDefault();
        id = $(this).attr('id');
        var status = $(this).data('status');
        status = status != '' && status == '1' ? 'deactivate' : 'activate';
        u_id = $(this).val();

        bootbox.confirm({
            buttons: {
                confirm: {
                    label: 'Yes, please'
                            //className: 'confirm-button-class'
                },
                cancel: {
                    label: 'No, thanks'
                            //className: 'cancel-button-class'
                }
            },
            message: 'Do you really want to ' + status + ' template?',
            callback: function (result) {
                if (result == true) {
                    if (document.getElementById(id).checked) {
                        status = '0';
                    }
                    else {
                        status = '1';
                    }
                    $.ajax({
                        url: SITE_URL + "template/template_status",
                        data: 't_id=' + u_id + '&status=' + status,
                        type: "POST",
                        success: function (data) {
                            window.location.href = "";
                        },
                        error: function () {
                        }
                    });
                    //$('.switchery').trigger('click');

                }
            },
            title: 'Manage Company Template Status'
        });
    });

    $(document).on("click", ".template_del", function (e) {
        e.preventDefault();
        id = $(this).data('id');
        bootbox.confirm({
            buttons: {
                confirm: {
                    label: 'Yes, please'
                            //className: 'confirm-button-class'
                },
                cancel: {
                    label: 'No, thanks'
                            //className: 'cancel-button-class'
                }
            },
            message: 'Do you really want to delete this template permanently',
            callback: function (result) {
                if (result == true) {
                    $.ajax({
                        url: SITE_URL + "template/template_delete",
                        data: 'template_id=' + id,
                        type: "POST",
                        success: function (data) {

                            window.location.href = SITE_URL + 'template/templates';
                        },
                        error: function () {
                        }
                    });
                    //$('.switchery').trigger('click');

                }
            },
            title: 'Delete Template'
        });
    });
    
     $(document).on("click", ".per_template_del", function (e) {
        e.preventDefault();
        id = $(this).data('id');
        bootbox.confirm({
            buttons: {
                confirm: {
                    label: 'Yes, please'
                            //className: 'confirm-button-class'
                },
                cancel: {
                    label: 'No, thanks'
                            //className: 'cancel-button-class'
                }
            },
            message: 'Do you really want to delete this template permanently',
            callback: function (result) {
                if (result == true) {
                    $.ajax({
                        url: SITE_URL + "template/per_template_delete",
                        data: 'template_id=' + id,
                        type: "POST",
                        success: function (data) {

                            window.location.href = SITE_URL + 'template/templates';
                        },
                        error: function () {
                        }
                    });
                    //$('.switchery').trigger('click');

                }
            },
            title: 'Delete Template'
        });
    });
    
    $('.download').click(function () {
        img = $(this).data('img');
        $.ajax({
            url: SITE_URL + "template/download_file",
            data: 'img=' + img,
            type: "POST",
            success: function (data) {

                // window.location.href = "";
            },
            error: function () {
            }
        });
    });
    
    $(document).on("click", ".lblduplicate", function (e) {
        $("#chngetemplate_id").val($(this).data('id'));
        document.getElementById('template_form').reset();
        $('#template_form').find('input').removeClass('error');;
    });


$('#example').on( 'page.dt', function () { //your click handler is here 
    //
    });
    $(document).ready(function (e) {
        $("#template_form").validate({
            rules: {
                newtemplatename: {
                   required: {
                    depends: function () {
                        $(this).val($(this).val().ltrim());
                        return true;
                    }
                },
                    minlength: 4,
                    maxlength: 50

                }
            },
            messages: {
                newtemplatename: {required: "Please enter template name to continue.",
                    maxlength: "Please enter 50 character only."},
            },
            errorPlacement: function (error, element) {

                var my = "";

                var at = "";



                if ($(window).width() < 800)

                {

                    my = 'bottom right';

                    at = 'top right';

                }

                else

                {

                    my = 'bottom right';

                    at = 'top right';

                }

                if (!error.is(':empty')) {

                    $(element).not('.valid').qtip({
                        overwrite: false,
                        content: error,
                        show: 'focus',
                        hide: 'blur',
                        position: {
                            my: my,
                            at: at,
                            viewport: $(window),
                            adjust: {x: 0, y: 0}

                        },
                        style: {
                            classes: 'qtip-custom qtip-shadow',
                            tip: {
                                height: 6,
                                width: 11

                            }

                        }

                    })

                            .qtip('option', 'content.text', error);

                }

                else {

                    element.qtip('destroy');

                }

            },
            success: "valid"

        });
        
       
    });
 
 $(document).on("click", ".lblcopy", function (e) {
           	bootbox.alert({
                message: "Your link is copied to clipboard, you can share with anyone.",
                callback: function () { /* your callback code */
                },
                title: 'Template Link Copied'
            });
        });
 var clipboard = new Clipboard('.clipbrd');

</script>
<script>

    /*
JS Modified from a tutorial found here: 
http://www.inwebson.com/html5/custom-html5-video-controls-with-jquery/

I really wanted to learn how to skin html5 video.
*/
$(document).ready(function(){});

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