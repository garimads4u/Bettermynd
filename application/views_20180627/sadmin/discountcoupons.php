<div class="col-md-12 col-sm-12 col-xs-12">
  <div  class="x_panel">
    <div class="x_content">
      <div id="infoMessage">
        <?php



	 if(isset($message)) { 

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
      <?php   $attributes = array('id' => 'coupon_form', 'class' => 'myprofile form-horizontal','enctype'=>'multipart/form-data');

 echo form_open(SADMIN_URL."update_coupon",$attributes);?>
      <?php if(isset($edit_id) && !empty($edit_id)){

	echo form_input($edit_id);

 }
else{
 ?>
      <div class="row">
        <div class="col-md-12">
          <div class="pull-right"> <a href="#" class="btn btn-primary" id="addcouponbutton"><i class="fa fa-plus"></i> Add Coupon</a> </div>
        </div>
      </div>
     <?php
}
	 ?>
      <div class="row  <?php  if(isset($edit_data) && !empty($edit_data)){?> <?php  }else{ ?> hide <?php }?>" id="add_form_div">
        <hr/>
        <div class="clearfix"></div>
        <div class="col-md-6">
          <div class="form-group"> <?php echo lang('coupon_code_label', 'coupon_code');?> <span class="mandatory">*</span> <?php echo form_input($coupon_code); ?> </div>
        </div>
        <div class="col-md-12">
          <div class="row">
            <div class="col-md-4">
              <div class="form-group"> <?php echo lang('coupon_code_mode_label', 'coupon_code_mode');?> <span class="mandatory">*</span><Br/>
                <input type="radio" name="coupon_code_mode[]" id="coupon_code_mode" class="flat"  value="MONTHLY"  <?php echo isset($edit_data) && !empty($edit_data) && $edit_data[0]->payment_mode == 'MONTHLY' ? 'checked="checked"' : 'checked="checked"';?>/>
                &nbsp;
                <label for="coupon_code_mode">Monthly</label>
                <input type="radio" name="coupon_code_mode[]" id="coupon_code_mode1" class=" flat"  value="ANNUALLY" <?php echo isset($edit_data) && !empty($edit_data) && $edit_data[0]->payment_mode == 'ANNUALLY' ? 'checked="checked"' : '';?>/>
                &nbsp;
                <label for="coupon_code_mode1">Annually</label>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group"> <?php echo lang('coupon_code_type_label', 'coupon_code');?> <span class="mandatory">*</span><Br/>
                <input type="radio" name="coupon_code_type[]"  id="coupon_code_type" class="cccoderadio flat"  value="AMOUNT" <?php echo isset($edit_data) && !empty($edit_data) && $edit_data[0]->coupon_code_type == 'AMOUNT' ? 'checked="checked"' : 'checked="checked"';?> />
                &nbsp;
                <label for="coupon_code_type">In Percentage</label>
                <input type="radio" name="coupon_code_type[]" id="coupon_code_type1" class="cccoderadio flat"  value="DAYS" <?php echo isset($edit_data) && !empty($edit_data) && $edit_data[0]->coupon_code_type == 'DAYS' ? 'checked="checked"' : '';?>/>
                &nbsp;
                <label for="coupon_code_type1">In Days</label>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group"> <?php echo lang('coupon_code_applicable_label', 'coupon_code');?> <span class="mandatory">*</span><Br/>
                <input type="radio" name="coupon_code_applicable[]" id="coupon_code_applicable" class="flat"  value="COMPANY"  <?php echo isset($edit_data) && !empty($edit_data) && $edit_data[0]->coupon_account_type == 'COMPANY' ? 'checked="checked"' : 'checked="checked"';?>/>
                &nbsp;
                <label for="coupon_code_applicable">COMPANY</label>
                <input type="radio" name="coupon_code_applicable[]" id="coupon_code_applicable1" class=" flat"  value="USER" <?php echo isset($edit_data) && !empty($edit_data) && $edit_data[0]->coupon_account_type == 'USER' ? 'checked="checked"' : '';?> />
                &nbsp;
                <label for="coupon_code_applicable1">USER</label>
                <input type="radio" name="coupon_code_applicable[]" id="coupon_code_applicable_1" class=" flat"  value="BOTH" <?php echo isset($edit_data) && !empty($edit_data) && $edit_data[0]->coupon_account_type == 'BOTH' ? 'checked="checked"' : '';?> />
                &nbsp;
                <label for="coupon_code_applicable_1">BOTH</label>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group hide" id="noofdays"> <?php echo lang('no_of_days_label', 'coupon_free_trial');?> <span class="mandatory">*</span><Br/>
            <?php echo form_input($coupon_free_trial); ?> </div>
          <div class="form-group" id="percentage"> <?php echo lang('percentage_label', 'discount_percentage');?> <span class="mandatory">*</span><Br/>
            <?php echo form_input($discount_percentage); ?> </div>
        </div>
        <div class="col-md-4">
          <div class="form-group"> <?php echo lang('coupon_start_date_label', 'coupon_start_date');?> <span class="mandatory">*</span><Br/>
            <?php echo form_input($coupon_start_date); ?> </div>
        </div>
        <div class="col-md-4">
          <div class="form-group"> <?php echo lang('coupon_end_date_label', 'coupon_end_date');?> <span class="mandatory">*</span><Br/>
            <?php echo form_input($coupon_end_date); ?> </div>
        </div>
        <div class="col-md-12">
          <div class="form-group"> <?php echo lang('coupon_code_desc_label', 'coupon_code_desc');?> <?php echo form_textarea($coupon_code_desc); ?> </div>
        </div>
        <div class="clearfix"></div>
        <div class="register-buttons">
          <?php

	  if(isset($edit_data) && !empty($edit_data)){

		   echo form_submit('submit', 'Update Coupon',array("class"=>"btn btn-primary"));

	  }

	  else{

		  

		 echo form_submit('submit', lang('add_coupon_label_button'),array("class"=>"btn btn-primary"));

	  }

		 

		 ?>
          <?php       echo "<a href='".SADMIN_URL."discountcoupons' class='btn btn-default'> Cancel </a>"; ?>
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
            <th>Coupon Code</th>
            
            <!--<th>Type</th>-->
            
            <th>Applicable On</th>
            <th>Discount In <br>
              (Per / Days)</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if(isset($existing_coupons) && !empty($existing_coupons)){

			foreach($existing_coupons as $coupon){

				if($coupon['coupon_code_status']=="1"){

					$checked="checked='checked'";

				}

				else{

					$checked="";

				}

				if($coupon['coupon_code_status']=="1"){

												$status="0";

											}

											else{

												$status="1";

											}

				?>
          <tr>
            <td><?php echo isset($coupon['coupon_code']) ? $coupon['coupon_code'] : 'N/A';?></td>
            
            <!--<td><?php // echo isset($coupon['coupon_code_type']) ? ucwords(strtolower($coupon['coupon_code_type'])) : 'N/A';?></td>-->
            
            <td><?php echo isset($coupon['coupon_account_type']) ? ucwords(strtolower($coupon['coupon_account_type'])) : 'N/A';?></td>
            <td><?php 

				if(isset($coupon['coupon_code_type']) && $coupon['coupon_code_type']=="DAYS"){

					

					echo isset($coupon['coupon_free_trial']) ? ucwords(strtolower($coupon['coupon_free_trial']))." Days" : 'N/A';

					

				}

				elseif(isset($coupon['coupon_code_type']) && $coupon['coupon_code_type']=="AMOUNT"){

				

					echo isset($coupon['discount_percentage']) ? number_format($coupon['discount_percentage'],2). " %" : 'N/A';

				}

				?></td>
            <td><label class='switch-lbl'>
                <input type='checkbox' <?php echo $checked;?> name='coupon_status_<?php echo $coupon['coupon_id'];?>' data-id="<?php echo $coupon['coupon_id'];?>" data-status='<?php echo $status;?>' class='js-switch  coupon_status' value='<?php $coupon['coupon_id'];?>' />
              </label></td>
            <td><a href="<?php echo SADMIN_URL;?>discountcoupons/<?php echo ($coupon['coupon_id']);?>" class="label label-success">EDIT</a> <a href="#" data-id="<?php echo $coupon['coupon_id'];?>" class="label label-danger deletecoupon">Delete</a></td>
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
<script type="text/javascript">

		   $(document).ready(function(){

            $(function () {

                var date = new Date();

                var nextDayDate = new Date();

                

			    $('#coupon_start_date').datepicker({

                dateFormat: "mm/dd/yy",

               minDate: 0

               

               

                 

				 

           });

		    	$('#coupon_end_date').datepicker({

                 dateFormat: "mm/dd/yy",
				 minDate: 1

                 

				 

           });

            });

			 });

        </script> 
<script type="text/javascript">

 $('input').on('ifChecked', function(event){

		var control_id=$(this).attr("id");

		if(control_id=="coupon_code_type" || control_id=="coupon_code_type1"){

			if($(this).val()=="AMOUNT"){

				if($("#percentage").hasClass("hide")){

					$("#percentage").removeClass("hide");

					if($("#noofdays").hasClass("hide")){}else{

						$("#noofdays").addClass("hide");

											

					}



				}

				$("#discount_percentage").val('');

				$("#coupon_free_trial").val('');	

			}

			else if($(this).val()=="DAYS"){

				if($("#noofdays").hasClass("hide")){

					$("#noofdays").removeClass("hide");

					if($("#percentage").hasClass("hide")){}else{

						$("#percentage").addClass("hide");

						

					}

				}

				$("#discount_percentage").val('');

				$("#coupon_free_trial").val('');	

			}

		}

	

		  });



</script>
<?php if(isset($edit_data) && count($edit_data) && !empty($edit_data)){



if($edit_data[0]->coupon_code_type=="AMOUNT"){

	?>
<script type="text/javascript">

	if($("#percentage").hasClass("hide")){

					$("#percentage").removeClass("hide");

					if($("#noofdays").hasClass("hide")){}else{

						$("#noofdays").addClass("hide");

											

					}



				}

			

				$("#coupon_free_trial").val('');	

	</script>
<?php

}

else{

	?>
<script type="text/javascript">

if($("#noofdays").hasClass("hide")){

					$("#noofdays").removeClass("hide");

					if($("#percentage").hasClass("hide")){}else{

						$("#percentage").addClass("hide");

						

					}

				}

				$("#discount_percentage").val('');

				

	</script>
<?php

}

}

?>
<Script type="text/javascript">

$("#addcouponbutton").click(function(e) {

    $("#add_form_div").toggleClass("hide");

});

$("#coupon_start_date").keydown(function(e) {

    return false;

});

$("#coupon_end_date").keydown(function(e) {

    return false;

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
