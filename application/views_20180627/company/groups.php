<div class="col-md-12 col-sm-12 col-xs-12">
<div  class="x_panel">
<div class="x_content">
  <div id="infoMessage">
    <?php if(isset($message)) { 
        ?>
    <p class="alert alert-success text-left">
      <?php
        echo $message; 
        ?>
    </p>
    <?php
    } ?>
    <?php if(isset($error)) { 
        ?>
    <p class="alert alert-danger text-left">
      <?php
        echo $error; 
        ?>
    </p>
    <?php
    } ?>
  </div>
  <div class="clearfix"></div>
  <?php if(!isset($edit_data)){
	  ?>
  <div class="text-right">
    
    <a href="javascript:void(0);" class="btn btn-primary" id="addgroupbutton"><i class="fa fa-plus"></i>&nbsp;Add Group</a>
   
  </div>
  <div class="clearfix"></div>
  <hr/>
   <?php
  }
      ?>
  <div class=" <?php   if(isset($edit_data) && !empty($edit_data)){?> <?php  }else{ ?>hide <?php  }?>" id="add_form_div">
    
    <div class="clearfix"></div>
    <?php   $attributes = array('id' => 'group_form', 'class' => 'myprofile form-horizontal','enctype'=>'multipart/form-data');
 echo form_open(COMPANY_URL."create_group",$attributes);?>
    <?php if(isset($edit_id) && !empty($edit_id)){
	echo form_input($edit_id);
 }
 ?><div class="row">
    <div class="col-sm-6">
      <div class="form-group"> 
	  <?php echo lang('create_group_name_label', 'groupname');?> <span class="mandatory">*</span><Br/>
        <?php echo form_input($groupname); ?> </div>
    </div>
    <div class="col-sm-6">
    <label class="control-label hidden-xs"><br /></label>
    	<div class="">
      <?php
	  if(isset($edit_data) && !empty($edit_data)){
		   echo form_submit('submit', 'Update Group',array("class"=>"btn btn-primary"));
	  }
	  else{
		  
		 echo form_submit('submit', lang('create_group_submit_btn'),array("class"=>"btn btn-primary"));
	  }
		 
		 ?>
      <?php       echo "<a href='".COMPANY_URL."groups' class='btn btn-default'> Cancel </a>"; ?>
    </div>
    </div>
    </div>
    <?php echo form_close();?> </div>
    <div id="add_form_div">
<table id="datatable" class="table table-striped table-bordered">
        <thead>
          <tr>
            <th>Group Name</th>
            <th>Created On</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if(isset($existing_groups) && !empty($existing_groups)){
			foreach($existing_groups as $group){
				if($group['group_status']=="1"){
					$checked="checked='checked'";
				}
				else{
					$checked="";
				}
				if($group['group_status']=="1"){
												$status="0";
											}
											else{
												$status="1";
											}
				?>
          <tr>
            <td><?php echo isset($group['group_name']) ? $group['group_name'] : 'N/A';?></td>
            <td><?php echo date(DATE_TIME_FORMAT,strtotime($group['group_adddate']));?></td>
            <td><div id='toggle_over'> 
                <input type='checkbox' <?php echo $checked;?> name='group_status_<?php echo $group['group_id'];?>' id='group_status_<?php echo $group['group_id'];?>' data-id="<?php echo $group['group_id'];?>" data-status='<?php echo $status;?>' class='ios-toggle  group_status' value='<?php echo $group['group_id'];?>' /><?php echo "<label for='group_status_".$group['group_id']."' class='checkbox-label'></label>";?>
              </div></td> 
            <td><a href="<?php echo COMPANY_URL;?>groups/<?php echo ($group['group_id']);?>" class="label label-success">EDIT</a> <a href="#" data-id="<?php echo $group['group_id'];?>" class="label label-danger deletegroup">Delete</a></td>
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
</div>

<Script type="text/javascript">
$("#addgroupbutton").click(function(e) {
    $("#add_form_div").toggleClass("hide");
});
 $(document).on("click", ".deletegroup", function (e) {
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
			
			
			
            message: 'Do you really want to delete this group?',
            callback: function (result) {
                if (result == true) {

                    $.ajax({
                        url: SITE_URL + "company/deletegroup/"+id,
                        data: 'mail_template_id=' + id,
                        type: "POST",
                        success: function (data) {
				
                            window.location.href = SITE_URL + "company/groups";
                        },
                        error: function () {
                        }
                    });
                    //$('.switchery').trigger('click');

                }
            },
            title: 'Delete Group'
        });
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