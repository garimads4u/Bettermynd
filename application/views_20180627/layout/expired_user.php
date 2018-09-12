<div class="col-sm-12">
  <h2 class="page-heading">Renew Subscription</h2>
  <div class="x_panel">
    <div class="x_content"> 
<!--      <div class="row">
        <div class="col-sm-12">
          <div class="expire_subs">
            <h2>Your subscription has expired !</h2>
            <p>Click Reactivate Account to update your billing information and reactivate your subscription so that you can resume using Brandize features</p>
                         <button class="btn btn-primary">Reactivate Account</button> 
          </div>
        </div>
      </div>-->
      <?php
 $attributes = array('id' => 'activate_frm','class' => 'regration-form form-horizontal');
 echo form_open(USER_URL."update_subscription",$attributes);?>
      <?php echo form_input($user_type); ?>
      <div class="row">
        <div id="infoMessage">
          <?php if(isset($error) && strlen($error)>0){
			 echo $error;
		 }
		 if(isset($message) && strlen($message)>0){
			 echo $message;
		 }
		 ?>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label class="control-label" for="email">Membership Package</label>
            <div class="clearfix"></div>
            <?php if(isset($packages) && count($packages) && !empty($packages)){
					$i=1;
				foreach($packages as $package){
																	if($i==1){
																		$state="checked='checked'";
																	}
																	else{
																		$state="";
																	}
																?>
            <div class="member_pack_input">
              <input data-mtype="radio" <?php echo $state;?> type="radio" data-price="<?php echo $package['package_amount'];?>" data-type="<?php echo ucwords(strtolower($package['package_mode']));?>" name="membership_plan[]" id="membership_plan<?php echo $package['package_id'];?>" class="package_radio flat" value="<?php echo $package['package_id'];?>" />
              <label class="no-label-formatting" for="membership_plan<?php echo $package['package_id'];?>"><?php echo ucwords(strtolower($package['package_mode']));?> (<?php echo CURRENCY_SYMBOL;?><?php echo $package['package_amount']." ".ucwords(strtolower($package['package_mode']));?>) </label>
            </div>
            <?php
	  $i++;	}
				}
			  ?>
          </div>
          <div class="form-group"  id="issubscription">
            <input type="checkbox" name="is_subscription" data-mtype="check" checked="checked" id="is_subscription" value="1" class="flat" />
            &nbsp;
            <label class="no-label-formatting" for="is_subscription">I agree to pay the auto renew for monthly subscription.</label>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="row paid_options ">
            <div class="col-sm-12">
              <div class="" role="tabpanel" data-example-id="togglable-tabs">
                <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                  <li role="presentation" class="active"> <a href=" #tab_content1" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false"> Register with </a> </li>
                  <li><!--<a href="javascript:void()" class="no_link">[COMPANY NAME]</a>--></li>
                </ul>
                <div id="myTabContent" class="tab-content">
                  <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="profile-tab">
                    <div>
                      <div class="card_total row">
                        <div class="col-sm-6"> <strong>TOTAL: </strong><span id='coupon' ><?php echo CURRENCY_SYMBOL; ?><?php echo $packages[0]['package_amount']. ' ' .$packages[0]['package_mode'] ; if(isset($tax) && $tax>0){?>  +<small><?php echo $tax;?>% Tax of $<?php echo $packages[0]['package_amount'];?></small><?php } ?></span>
                          <input type="hidden" name="final_amount" id="final_amount" value="<?php echo $packages[0]['package_amount'];?>" />
                        </div>
                        <div class="col-sm-6">
                           <a title="Remove Coupon Code" href="javascript:void(0);" class="mandatory hide" id="btnclear" style="float:left !important;margin-left:-13px !important;margin-top:10px !important;"><i class="fa fa-times"></i></a>
                        <a href="javascript:void(0)" class="btn-apply">Apply Discount Code</a>
                          <div class="input-group apply" id="display_txtbox">
                            <div class="default-input-group "> <?php echo form_input($coupon_code);?>
                              <input type="button" class="btn btn-link" value="Apply" id="coupon_btn">
                            </div>
                            
                            <!-- /input-group --> 
                          </div>
                        </div>
                        <div id="applied_coupon" class=" col-md-6 hide"> </div>
                      </div>
                      <div class="checkbox">
                        <label>
                          <input type="checkbox" class="flat" disabled="disabled" checked="checked">
                          Credit Card <img src="<?php echo IMAGES_URL;?>cards.png"  alt=""/> </label>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-12">
          <h4>Card Details</h4>
        </div>
        <div class="col-sm-12">
          <div class="card_form" style="padding-top:5px;">
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group"> <?php echo form_input($first_name);?> </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group"> <?php echo form_input($last_name);?> </div>
              </div>
              <div class="col-sm-6 col-md-12 col-lg-6">
                <div class="form-group"> <?php echo form_input($card_number);?> <i class="cccard" aria-hidden="true"></i></div>
              </div>
              <div class="col-xs-6 col-sm-3 col-md-6 col-lg-3">
                <div class="form-group"> <?php echo form_input($expiration_date);?> </div>
              </div>
              <div class="col-xs-6 col-sm-3 col-md-6 col-lg-3">
                <div class="form-group"> <?php echo form_input($cvv_code);?> <i class="cvv_icon" aria-hidden="true" title='3 digit no. printed on back of your card.'></i> </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-8">
                <div class="form-group"> <?php echo form_input($address);?> </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group"> <?php echo form_input($zip_code);?> </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="register-buttons"> <?php echo form_submit('submit', 'Pay Now',array("class"=>"btn btn-primary","id"=>"signup_btn"));?> </div>
      <?php echo form_close();?> </div>
  </div>
</div>
<script type="text/javascript">
$('input').on('ifChecked', function(event){
	 	if($(this).data('mtype')=="check"){
		//alert($(this).data('mtype'));
		return false;
		}
		var final_str="$"+ $(this).data('price')+" "+ $(this).data('type');
		<?php
		if(isset($tax) && $tax>0){
			?>
			final_str+='+<small><?php echo $tax;?>% Tax of $'+$(this).data('price')+'</small>'
			<?php
			 } 
			 ?>
		if($(this).data('type')=="Monthly" && $(this).data('mtype')=="radio"){
		//$("#issubscription").toggleClass("hide");
			$('#is_subscription').iCheck('uncheck');		
			$("#is_subscription").removeAttr("checked");
		}
		else if($(this).data('type')=="Annually" && $(this).data('mtype')=="radio"){
		//	$("#issubscription").toggleClass("hide");
		$('#is_subscription').iCheck('uncheck');		
			$("#is_subscription").removeAttr("checked");		
		}
	$("#coupon").html(final_str);
	$("#final_amount").val($(this).data('price'));
		  });
		  var g_plan_id="";
		  // Applying coupon_code
		  $("#coupon_btn").click(function(e) {
			  var plan_type="";
			plan_type=document.getElementsByName("membership_plan[]");
			if(plan_type.length>0){
				for(i=0;i<plan_type.length;i++)
				{
					if(plan_type.item(i).checked==true)
					{
					plan_id=plan_type.item(i).value;
					g_plan_id=plan_type.item(i).id;
					}
				}
				
			}
	
        	 jQuery.ajax({
            url: SITE_URL + "coupon_code_validation/"+ $("#coupon_code").val()+"/"+plan_id+"/"+$("#user_type").val(),
            data: 'coupon_code=' + $("#coupon_code").val()+"&plan_type="+plan_id+"&user_type="+$("#user_type").val(),
            type: "POST",
			datatype:'json',
            success: function (data) {
			var returnjson=JSON.parse(data);
				if(returnjson.type=="success"){
						var coupon_type=returnjson.coupon_type
					if(coupon_type=="amount"){
							var net_amount=$("#final_amount").val();
							var discount=(100-returnjson.percentage)/100;
							 var new_amount=net_amount*(discount);
							 plan_type=$("#"+g_plan_id).data('type');
							 if(plan_type=="Monthly"){
							$('#coupon').html('$' + new_amount.toFixed(2) + ' ' + plan_type <?php if(isset($tax) && $tax>0){?> +'<small>+ <?php echo $tax;?>% Tax of $'+new_amount.toFixed(2)+'</small>'<?php } ?>).fadeIn();
							 }
							 else if(plan_type=="Annually"){
								$('#coupon').html('$' + new_amount.toFixed(2) + ' ' + plan_type <?php if(isset($tax) && $tax>0){?> +'<small>+ <?php echo $tax;?>% Tax of $'+new_amount.toFixed(2)+'</small>'<?php } ?>).fadeIn();
							 }
						}
						else if(coupon_type=="days")
						{
							var net_amount=$("#final_amount").val();
							var discount=returnjson.percentage;
							 plan_type=$("#"+g_plan_id).data('type');
							$("#coupon").text('$' + net_amount + ' ' +plan_type + " ( + "+returnjson.percentage+" days)")
						}
					error_element=document.createElement("p");
					error_element.setAttribute("class","alert alert-success  text-left");
					error_element.setAttribute("id","custom_error");
					$("#infoMessage").text('');
					document.getElementById("infoMessage").appendChild(error_element);
					$("#custom_error").text("Coupon Successfully Applied");
					$("#coupon_code").attr("disabled","disabled");
					if($("#btnclear").hasClass("hide")){
						$("#btnclear").removeClass("hide");
					}
					
						
				}
				else{
					error_element=document.createElement("p");
					error_element.setAttribute("class","alert alert-danger text-left");
					error_element.setAttribute("id","custom_error");
					$("#infoMessage").text('');
					document.getElementById("infoMessage").appendChild(error_element);
					$("#custom_error").text("Coupon Not Applicable");
					window.scroll(0,0);
				}
            },
            error: function () {
				
					error_element=document.createElement("p");
					error_element.setAttribute("class","alert alert-danger  text-left");
					error_element.setAttribute("id","custom_error ");
					$("#infoMessage").text('');
					document.getElementById("infoMessage").appendChild(error_element);
					$("#custom_error").text("Coupon Not Applicable");
					window.scroll(0,0);
					
            }
        });
        });
		 $('.btn-apply').on('click', function () {
        $(this).fadeOut(function () {
            $('.apply').fadeIn();
        });});
        	$("#btnclear").click(function(e) {
            
				var all_radios=document.getElementsByClassName("iradio_flat-blue");
				if(all_radios.length>0){
					for(i=0;i<all_radios.length;i++){
						var all_classes="";
     					all_classes=all_radios.item(i).getAttribute("class");
	
					if(all_classes.indexOf("checked")>0){
						control=all_radios.item(i).getElementsByTagName("input");
						item_id=control.item(0).getAttribute("data-price")+" " + control.item(0).getAttribute("data-type");
						var mytext="";
						mytext="$"+item_id;
						<?php if(isset($tax) && $tax>0){
							?>
							mytext=mytext+'<small>+ <?php echo $tax;?>% Tax of $'+control.item(0).getAttribute("data-price")+'</small>'
							<?php
						}
						?>
						$("#coupon").html(mytext);
						$("#custom_error").text('');
						$("#coupon_code").val('');
						$("#final_amount").val(control.item(0).getAttribute('data-price'));
						document.getElementById("coupon_code").disabled=false;
						if($("#btnclear").hasClass("hide")){
						}
						else{
							$("#btnclear").addClass("hide");
							$("#custom_error").text('');
								$("#custom_error").addClass('hide');
						}
					}
	
					}
				}
				
			
        });
        $(document).ready(function(){
             $.validator.addMethod("text_validation", function (value, element) {
        // var numericReg = /^[A-Za-z|\'|\s]+$/;
        var numericReg = /^[A-Za-z]+$/;
        //    var numericReg = /^[a-zA-Z'.,-]{0,150}$/;
        return numericReg.test(value);

    }, "Please enter Characters only.");
    
      $.validator.addMethod("postcode", function (value, element) {
            var numericReg = /^(?=.*\d)[a-zA-Z\d #,-]+$/;
            return numericReg.test(value);
        }, "Postcode contains 6-8 alpha numneric or digit only");
            $("#activate_frm").validate({
        rules: {
            first_name: {
                required: true,
                rangelength: [3, 32],
                text_validation: true
            },
            last_name: {
                required: true,
                rangelength: [3, 32],
                text_validation: true
            },
            card_number: {
                required: true,
                creditcard: true,
                minlength: 13,
                maxlength: 25
            },
            expiration_date: {
                required: true,
                minlength: 9
            },
            cvv_code: {
                required: true
                
            },
            address: {
                required: true
            },
            zip_code: {
                required: true,
                rangelength: [5, 8],
                postcode:true
            }
        },
        messages: {
            username: { remote: "{0} is already in use."},
            confirm_email: { equalTo: "Email Address and Repeat Email Address doesn't match.."},
            password_confirm : { equalTo : "Password and Confirm Password doesn't match." },
            expiration_date : { minlength : "Expiration date must be in MM/YYYY format." },
            zip_code : {rangelength:"Zipcode contains 5-8 alpha numneric or digit only."}
        },
//        errorPlacement: function (label, element) {
//            if (element.attr("name") == "terms_checked") {
//                $('<span class="error"></span>').insertAfter('.terms').append(label)
//            } else {
//                $('<span class="arrow"></span>').insertBefore(element);
//                $('<span class="error"></span>').insertAfter(element).append(label)
//            }
//
//        },
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
         submitHandler: function (form) {
            $("#signup_btn").attr("disabled", true);
            form.submit(); // <- use 'form' argument here.
            },
        success: "valid"
    }); 
        });
		
</script>