<div class="col-md-10 col-sm-12">
  <div id="infoMessage">
    <?php
   if(isset($message) && strlen($message)>0 ) { 
	$message1=str_replace(" ","",$message);
	if(strlen($message1)>0){
        echo $message; 
        ?>
    <?php
	}
    } ?>
    <?php if(isset($error)  && strlen($error)>0) { 
            ?>
    <?php
        echo $error; 
         ?>
    <?php
    } ?>
  </div>
  <div class="sections-head">ADD NEW USER</div>
  <div class="x_panel">
    <div class="x_content">
      <div class="row">
        <?php
                $attributes = array('id' => 'add_user', 'class' => 'form-horizontal');
                echo form_open(ADMIN_URL . "create_user", $attributes);
                ?>
        <div class="col-sm-12">
          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                <label class="control-label" for="first-name">Username <span class="mandatory">*</span></label>
                <?php echo form_input($username); ?> <?php echo form_input($user_type); ?> </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label class="control-label" for="last-name">Full Name <span class="mandatory">*</span></label>
                <?php echo form_input($account_holder_name); ?> </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label class="control-label" for="email">E-mail <span class="mandatory">*</span></label>
                <?php echo form_input($user_email); ?> </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label class="control-label" for="phone">Phone</label>
                <?php echo form_input($mobile_phone); ?> </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label class="control-label " for="groups">Group(s)</label>
                <?php
                                    $options =$groups;
                                    $selected = '';
                                    $attr = 'class="form-control groups_dropdown" multiple="multiple"';
                                    echo form_dropdown('groups[]',$options,$selected,$attr);
                                    ?>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label class="control-label" for="groups">Level</label>
                <?php
                                    array_pop($levels);
                                    $options =$levels;
                                    $selected = $level;
                                    $attr = 'class="form-control chosen-select"';
                                    echo form_dropdown('level',$options,$selected,$attr);
                                    ?>
              </div>
            </div>
          </div>
          <div class="row paid_options ">
            <div class="col-sm-12">
              <div class="" role="tabpanel" data-example-id="togglable-tabs">
                <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
<!--                  <li role="presentation" > <a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Company Paid
                    <input type="checkbox" class="flat"  name='paidby[]' value='company'>
                    </a> </li>-->
                  <li role="presentation" class="active"> <a href=" #tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false"> User Paid
                    <input type="checkbox" class="flat" checked name='paidby[]' value='user'>
                    </a> </li>
                  <li class="total-monthly-hidden"><a href="javascript:void(0)">TOTAL:
                    <?php if (isset($membership_packages) && !empty($membership_packages) && count($membership_packages) > 0) {
                                                ?>
                    <span id='coupon' ><?php echo CURRENCY_SYMBOL; ?><?php echo $membership_packages[0]['package_amount']; ?> <?php echo ucwords(strtolower($membership_packages[0]['package_mode'])); ?> </span>
                    <input type="hidden" name="final_amount" id="final_amount" value="<?php echo $membership_packages[0]['package_amount']; ?>" />
                    <?php }
                                            ?>
                    </a> </li>
                  <li class="ques"><a tabindex="0" class="question_pop" data-toggle="popover" data-placement="bottom" data-html="true" data-trigger="focus"><img src="<?php echo IMAGES_URL; ?>question_icon.png"></a>
                    <div id="question_popover" class="hide">Company Paid option will automatically charge the Primary Account holder’s payment source for the additional user account. <br>
                      <br>
                      User Paid option will create the users account, but lock its functions until they add their personal billing details and pay for the membership.</div>
                  </li>
                </ul>
                <div id="myTabContent" class="tab-content">
<!--                  <div role="tabpanel" class="tab-pane fade" id="tab_content1" aria-labelledby="home-tab">
                    <div>
                      <div>
                        <div class="accordion" id="accordion" role="tablist" aria-multiselectable="true">
                          <div class="panel">
                            <div class="">
                              <div class="col-sm-7"> <a class="panel-heading" role="tab" id="company-collapse" data-toggle="collapse" data-parent="#accordion" href="#" aria-expanded="false" aria-controls="company_collapse">
                                <h4 class="panel-title"> Add Company Payment Info Now </h4>
                                </a>
                                <div class="total-monthly-show">&nbsp;<strong> TOTAL:
                                  <?php if (isset($membership_packages) && !empty($membership_packages) && count($membership_packages) > 0) {
                                                ?>
                                  <span id='coupon' ><?php echo CURRENCY_SYMBOL; ?><?php echo $membership_packages[0]['package_amount']; ?> <?php echo ucwords(strtolower($membership_packages[0]['package_mode'])); ?> </span>
                                  <input type="hidden" name="final_amount" id="final_amount" value="<?php echo $membership_packages[0]['package_amount']; ?>" />
                                  <?php }
                                            ?>
                                  </strong> </div>
                              </div>
                              <div class="col-sm-5 text-right"> <a href="javascript:void(0)" class="btn-apply">Apply Discount Code</a> <a title="Remove Coupon Code" href="javascript:void(0);" class="mandatory hide" id="btnclear" style="float:left !important;margin-left:-13px !important;margin-top:10px !important;"><i class="fa fa-times"></i></a>
                                <div class="input-group apply" style="margin-bottom:0;">
                                  <div class="default-input-group"> <?php echo form_input($coupon_code); ?>
                                    <?php
                                    $data = array(
                                        'name' => 'coupon_btn',
                                        'id' => 'coupon_btn',
                                        'value' => 'coupon_btn',
                                        'type' => 'button',
                                        'content' => 'Apply',
                                        'class' => 'btn btn-link'
                                    
									);
									

                                    echo form_button($data);
                                    ?>
                                    <div id="custom_error1"></div>
                                  </div>
                                   /input-group  
                                </div>
                              </div>
                            </div>
                            <div id="company_collapse" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="company-collapse">
                              <div class="panel-body">
                                <div class="row">
                                  <?php if (isset($membership_packages) && !empty($membership_packages) && count($membership_packages) > 0) {
                                                                        ?>
                                  <div class="col-md-12">
                                    <div class="form-group"> <?php echo lang('membership_package_label', 'email'); ?><br/>
                                      <?php
                                                                                $i = 1;
                                                                                foreach ($membership_packages as $package) {
                                                                                    if ($i == 1) {
                                                                                        $state = "checked='checked'";
                                                                                    } else {
                                                                                        $state = "";
                                                                                    }
                                                                                    ?>
                                      <div class="member_pack_input">
                                        <input data-mtype="radio" <?php echo $state; ?> type="radio" data-price="<?php echo $package['package_amount']; ?>" data-type="<?php echo ucwords(strtolower($package['package_mode'])); ?>" name="membership_plan[]" id="membership_plan<?php echo $package['package_id']; ?>" class="package_radio flat" value="<?php echo $package['package_id']; ?>" />
                                        <label class="no-label-formatting" for="membership_plan<?php echo $package['package_id']; ?>"><?php echo ucwords(strtolower($package['package_mode'])); ?> (<?php echo CURRENCY_SYMBOL; ?><?php echo $package['package_amount'] . " " . ucwords(strtolower($package['package_mode'])); ?>) </label>
                                      </div>
                                      <?php
                                                                                    $i++;
                                                                                }
                                                                                ?>
                                    </div>
                                    <div class="form-group" id="issubscription">
                                      <input type="checkbox" name="is_subscription" data-mtype="check"  id="is_subscription" value="1" class="flat" />
                                      &nbsp;
                                      <label class="no-label-formatting" for="is_subscription"> I agree to pay the auto renew for monthly subscription.</label>
                                    </div>
                                  </div>
                                  <?php }
                                                                    ?>
                                  <div class="col-sm-6">
                                    <div class="form-group"> <?php echo form_input($first_name); ?> </div>
                                  </div>
                                  <div class="col-sm-6">
                                    <div class="form-group"> <?php echo form_input($last_name); ?> </div>
                                  </div>
                                  <div class="col-sm-6">
                                    <div class="form-group"> <?php echo form_input($card_number); ?> <i class="cccard" aria-hidden="true"></i> </div>
                                  </div>
                                  <div class="col-sm-3">
                                    <div class="form-group"> <?php echo form_input($expiration_date); ?> </div>
                                  </div>
                                  <div class="col-sm-3">
                                    <div class="form-group"> <?php echo form_input($cvv_code); ?> <i class="cvv_icon" aria-hidden="true" title='3 digit no. printed on back of your card.'></i> </div>
                                  </div>
                                </div>
                                <div class="row">
                                  <div class="col-sm-8">
                                    <div class="form-group"> <?php echo form_input($address); ?> </div>
                                  </div>
                                  <div class="col-sm-4">
                                    <div class="form-group"> <?php echo form_input($zip_code); ?> </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>-->
                  <div role="tabpanel" class="tab-pane fade  active in" id="tab_content2" aria-labelledby="profile-tab" style="margin-left:0px !important;">
                    <div>
                      <div>
                        <div class="accordion" id="accordion1" role="tablist" aria-multiselectable="true">
                          <div class="panel"> <a class="panel-heading collapsed" role="tab" id="create_payment_info" data-toggle="collapse" data-parent="#accordion1" href="#create-payment-info" aria-expanded="false" aria-controls="create-payment-info">
                            <h4 class="panel-title"> Create Account and Let User Add Payment Info </h4>
                            </a>
                            <div id="create-payment-info" class="panel-collapse collapse" role="tabpanel" aria-labelledby="create_payment_info"> </div>
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
              <div class="form-group">
                <label for="message">Add a Custom Message to the User’s Welcome E-mail:</label>
                <?php
                                $attribute = array(
                                    'name' => 'welcome_msg',
                                    'id' => 'welcome_msg',
                                    'maxlength' => '500',
                                    'rows' => '4',
                                    'placeholder' => 'Enter custom welcome message',
                                    'class' => 'form-control',
									'value'=>$company_details['company_name']." allows you to design your own personalize FLYER,POSTER,TRIFOLD,LETTER,POSTCARD ETC."
                                );

                                echo form_textarea($attribute);
                                ?>
              </div>
            </div>
          </div>
          <div class="register-buttons"> <?php echo form_submit('submit', 'Add User', array("class" => "btn btn-primary")); ?> <a href='<?php echo ADMIN_URL . "users" ?>' class='btn btn-default'> Cancel </a> </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
    $(function () {
            $('li #home-tab').on('click', function () {
                $('#home-tab> .icheckbox_flat-blue').addClass('checked');
                $('#home-tab> .icheckbox_flat-blue input').attr('checked',true);
				
                $('#profile-tab .icheckbox_flat-blue').removeClass('checked');
		$('#profile-tab> .icheckbox_flat-blue input').attr('checked',false);
                $('.total-monthly-hidden').removeClass('hide');
                $('.total-monthly-hidden').addClass('show');
				
            });
            $('li #profile-tab').on('click', function () {
                $('#profile-tab> .icheckbox_flat-blue').addClass('checked');
				
		$('#profile-tab> .icheckbox_flat-blue input').attr('checked',true);
                $('#home-tab .icheckbox_flat-blue').removeClass('checked');
		$('#home-tab> .icheckbox_flat-blue input').attr('checked',false);
                $('.total-monthly-hidden').removeClass('show');
                $('.total-monthly-hidden').addClass('hide');
            });
			 
        });

    $('.btn-apply').on('click', function () {
        $(this).fadeOut(function () {
            $('.apply').fadeIn();
        });
    });

    $("[data-toggle=popover]").popover({
        html: true,
        content: function () {
            return $('#question_popover').html();
        }
    });
</script> 
<script type="text/javascript">
$('#myTab input').on('ifChecked',function(event){
	if($(this).val()=='user'){
			 $('li #profile-tab').trigger('click');
		}
		if($(this).val()=='company'){
			 $('li #home-tab').trigger('click');
		}
	});
    $('#tab_content1 input').on('ifChecked', function (event) {
		

        if ($(this).data('mtype') == "check") {
            //alert($(this).data('mtype'));
            return false;
        }
        var final_str = "$" + $(this).data('price') + " " + $(this).data('type');

        if ($(this).data('type') == "Monthly" && $(this).data('mtype') == "radio") {
            //$("#issubscription").toggleClass("hide");
            $('#is_subscription').iCheck('uncheck');
            $("#is_subscription").removeAttr("checked");
        }
        else if ($(this).data('type') == "Annually" && $(this).data('mtype') == "radio") {
           // $("#issubscription").toggleClass("hide");
            $('#is_subscription').iCheck('uncheck');
            $("#is_subscription").removeAttr("checked");
        }
        $("#coupon").text(final_str);
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
			var m_val=$("#coupon_code").val();
			m_val=m_val.toString();
			m_val=m_val.replace(/\s+/g,'');
			if(m_val.length>0){
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
							$('#coupon').text('$' + new_amount + ' '+plan_type).fadeIn();
								$("#final_amount").val(new_amount);							
							 }
							 else if(plan_type=="Annually"){
								$('#coupon').text('$' + new_amount + ' '+plan_type).fadeIn();
								$("#final_amount").val(new_amount);
							 }
						}
						else if(coupon_type=="days")
						{
							var net_amount=$("#final_amount").val();
							var discount=returnjson.percentage;
							 plan_type=$("#"+g_plan_id).data('type');
							$("#coupon").html('$' + net_amount + ' ' +plan_type + "<br/> (You Got  "+returnjson.percentage+" days extra in your subscription.)")
						}
					error_element=document.createElement("p");
					error_element.setAttribute("class","csuccess text-right");
					error_element.setAttribute("id","custom_error");
					$("#custom_error1").text('');
					document.getElementById("custom_error1").appendChild(error_element);
					$("#custom_error").text("Coupon Successfully Applied");
					$("#coupon_code").attr("disabled","disabled");
					if($("#btnclear").hasClass("hide")){
						$("#btnclear").removeClass("hide");
					}
				}
				else{
					error_element=document.createElement("p");
					error_element.setAttribute("class","cerror text-right");
					error_element.setAttribute("id","custom_error");
					$("#custom_error1").text('');
					document.getElementById("custom_error1").appendChild(error_element);
					$("#custom_error").text("Coupon Not Applicable");
					
				}
            },
            error: function () {
				
					error_element=document.createElement("p");
					error_element.setAttribute("class","cerror  text-right");
					error_element.setAttribute("id","custom_error");
					$("#custom_error1").text('');
					document.getElementById("custom_error1").appendChild(error_element);
					$("#custom_error").text("Coupon Not Applicable");
					
					
            }
        });
			}
			else{
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
						$("#coupon").text(mytext);
						$("#custom_error").text('');
					}
	
					}
				}
				
			}
        });
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
						$("#coupon").text(mytext);
						$("#custom_error").text('');
						$("#coupon_code").val('');
						$("#final_amount").val(control.item(0).getAttribute('data-price'));
						document.getElementById("coupon_code").disabled=false;
						if($("#btnclear").hasClass("hide")){
						}
						else{
							$("#btnclear").addClass("hide");
						}
					}
	
					}
				}
				
			
        });
</script> 
