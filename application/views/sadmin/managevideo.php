<div class="col-md-12 col-sm-12 col-xs-12">
  <div  class="x_panel">
    <div class="x_content">
    <div id="infoMessage"><?php

	 if(isset($message)) { 
        ?><p class="alert alert-success text-left"><?php
        echo $message; 
        ?></p><?php
    } ?>
        <?php if(isset($error)) { 
        ?><p class="alert alert-danger text-left"><?php
        echo $error; 
        ?></p><?php
    } ?>
    </div>
 <?php   
 $attributes = array('id' => 'video_form', 'class' => 'myprofile form-horizontal','enctype'=>'multipart/form-data');
echo form_open(SADMIN_URL."update_support_video",$attributes);

 if(isset($edit_id) && !empty($edit_id)){
	echo form_input($edit_id);
 }
 ?>
 <div class="row">
 	<div class="col-md-12">
     <div class="pull-right">
	<a href="#" class="btn btn-primary" id="addvideobutton"><i class="fa fa-plus"></i> Add Video</a>
 </div>
    </div>
 </div>

      <div class="row <?php  if(isset($edit_data) && !empty($edit_data)){?> <?php  }else{ ?> hide <?php }?>" id="add_form_div">
      <hr/>
      <div class="clearfix"></div>
      <div class="col-md-6"><div class="form-group"> <?php echo lang('title_label', 'title');?> <span class="mandatory">*</span> <?php echo form_input($title); ?> </div></div>
        <div class="col-md-6"><div class="form-group"> <?php echo lang('url_label', 'url');?> <span class="mandatory">*</span> <?php echo form_input($url); ?> </div></div>

        <div class="clearfix"></div>
        <div class="register-buttons"> <?php
	  if(isset($edit_data) && !empty($edit_data)){
		   echo form_submit('submit', lang('update_video_button'),array("class"=>"btn btn-primary"));
	  }
	  else{
		  
		 echo form_submit('submit', lang('save_video_button'),array("class"=>"btn btn-primary"));
	  }
		 
		 ?>
          <?php       echo "<a href='".SADMIN_URL."managevideos' class='btn btn-default'> Cancel </a>"; ?>
        </div>
      </div>
      <?php echo form_close();?> </div>
  </div>
</div>
<div class="col-md-12 col-sm-12 col-xs-12">
  <div class="x_panel" id="add_form_div">
    <div class="x_content">
      <table id="datatable" class="table table-striped table-bordered">
        <thead>
          <tr>
            <th>Title</th>
            <th>Video Url</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
        <?php if(isset($get_support_videos) && !empty($get_support_videos)){
		foreach($get_support_videos as $video){ 
                    if($video->status=="1"){
                        $checked="checked='checked'";
                    }else{
                        $checked="";
                    }
                    if($video->status=="1"){
                        $status="DeActivate";
                    }else{
                        $status="Activate";
                    }
		?>
				<tr>
                <td><?php echo isset($video->title) ? $video->title : 'N/A';?></td>
                <td><?php echo isset($video->url) ? $video->url : 'N/A';?></td>
                 <td>
                     <div id='toggle_over'><input type='checkbox' <?php echo $checked;?> name='supportvideo_status_<?php echo $video->video_id;?>' data-id="<?php echo $video->video_id;?>" id="<?php echo $video->video_id;?>" data-status='<?php echo $status;?>' class='ios-toggle  supportvideo_status' value='<?php $video->video_id;?>' /> <label for='<?php echo $video->video_id;?>' class='checkbox-label'></label></div>                     
                 </td>
                <td> <a href="<?php echo SADMIN_URL;?>managevideos/<?php echo ($video->video_id);?>" class="label label-success">EDIT</a>
                <a href="#" data-id="<?php echo $video->video_id;?>" class="label label-danger deletevideo">Delete</a>
                </td>
                </tr>
				<?php
			}
		}
		?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<Script type="text/javascript">
$("#addvideobutton").click(function(e) {
    $("#add_form_div").toggleClass("hide");
});
</script>
<?php if(isset($is_exist) && $is_exist=="1"){
	?>
	<script type="text/javascript">
	if($("#add_form_div").hasClass("hide")){
		$("#add_form_div").removeClass("hide");
	}
	</script>
	<?php
}
?>