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
      <?php   $attributes = array('id' => 'state_form', 'class' => 'myprofile form-horizontal','enctype'=>'multipart/form-data');
 echo form_open(SADMIN_URL."update_state",$attributes);?>
 <?php if(isset($edit_id) && !empty($edit_id)){
	echo form_input($edit_id);
 }
 ?>
 <div class="row">
 	<div class="col-md-12">
     <div class="pull-right">
	<a href="#" class="btn btn-primary" id="addstatebutton"><i class="fa fa-plus"></i> Add State</a>
 </div>
    </div>
 </div>

      <div class="row <?php  if(isset($edit_data) && !empty($edit_data)){?> <?php  }else{ ?> hide <?php }?>" id="add_form_div">
      <hr/>
      <div class="clearfix"></div>
      <div class="col-md-6"><div class="form-group"> <?php echo lang('state_label', 'state');?> <span class="mandatory">*</span> <?php echo form_input($state); ?> </div></div>
        <div class="col-md-6"><div class="form-group"> <?php echo lang('state_code_label', 'state_code');?> <span class="mandatory">*</span> <?php echo form_input($state_code); ?> </div></div>

        <div class="clearfix"></div>
        <div class="register-buttons"> <?php
	  if(isset($edit_data) && !empty($edit_data)){
		   echo form_submit('submit', 'Update State',array("class"=>"btn btn-primary"));
	  }
	  else{
		  
		 echo form_submit('submit', lang('save_state_button'),array("class"=>"btn btn-primary"));
	  }
		 
		 ?>
          <?php       echo "<a href='".SADMIN_URL."managestates' class='btn btn-default'> Cancel </a>"; ?>
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
            <th>State Name</th>
            <th>State Code</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
        <?php if(isset($get_states) && !empty($get_states)){
			foreach($get_states as $state){ 
				?>
				<tr>
                <td><?php echo isset($state->state) ? $state->state : 'N/A';?></td>

                <td><?php echo isset($state->state_code) ? $state->state_code : 'N/A';?></td>
               
                <td> <a href="<?php echo SADMIN_URL;?>managestates/<?php echo ($state->state_id);?>" class="label label-success">EDIT</a>
                <a href="#" data-id="<?php echo $state->state_id;?>" class="label label-danger deletestate">Delete</a>
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
$("#addstatebutton").click(function(e) {
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