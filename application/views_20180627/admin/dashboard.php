<div class="col-md-12 col-sm-12 col-xs-12">
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
  <div class="sections-head">USERS</div>
  <div class="x_panel">
    <div class="x_content">
      <table id="datatable" class="table table-striped table-bordered">
        <thead>
          <tr>
            <th>Username</th>
            <!-- <th>Email</th>-->
            <th>Level</th>
            <th>Group(s)</th>
            <th>Add Date</th>
            <th>Profile</th>
            <th>Status</th>
            <th>Stats<br/>
              <small class="custom">Login | Created | Sent</small></th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php
                     
                   if (isset($company_list) && count($company_list) > 0 && !empty($company_list)) {
                        foreach ($company_list as $value) {
						if($this->session->userdata('user_id') != $value->user_id) {
                            if ($value->user_status == 1) {
                                $checked = "checked='checked'";
                            } else {
                                $checked = "";
                            }
                            $locationStr = '';
                            if(isset($value->state) && !empty($value->state)) 
                            {
                                $locationStr = $value->state.' ';                                
                            }
                            if(isset($value->zipcode) && !empty($value->zipcode)) 
                            {
                                 $locationStr = $value->zipcode;    
                            }
                            $current_date = strtotime(date('Y-m-d h:i:s'));
                            $end_date = strtotime($value->subscription_end_date);
                            if($end_date < $current_date){
                                $bg='#fef2f4';
                            }
                            else{
                                $bg='#ffffff';
                            }
                          $group= explode(',',$value->group_user);
				  $options =$groups;
                                    $selected = $group;
                                    $attr = 'class="form-control groups_dropdown"  multiple="multiple" style="width:200px;" data-id="'.$value->user_id.'"';
                           if($value->user_role != "5"){       
                            echo "<tr style='background:$bg'>"
                            . "<td>" . $value->username . "</td>"
                            //. "<td><a href='mailto:".$value->user_email."'>" . $value->user_email . "</a></td>"
                            . "<td>" . $this->basic_model->get_user_role($value->user_role) . "</td>"
                            . "<td>".form_dropdown('level',$options,$selected,$attr)."</td>"
							  . "<td>".date(DATE_FORMAT,  ($value->user_createdon)) ."</td>"
							  ."<td><a href='".ADMIN_URL."edit_user/".$value->user_id."'>Profile</a> </td><td>";
							  if(strlen($value->user_pswd)>1){
                            echo "<div id='toggle_over'> <input type='checkbox' " . $checked . " id='u_id_".$value->user_id."' name='status_".$value->user_id."' data-status='".$value->user_status."' class='ios-toggle user_status' value='$value->user_id' /> <label for='u_id_".$value->user_id."' class='checkbox-label'></label></div>";
							  }
							  else{
							  echo  "<div id='toggle_over'>
							  <input type='checkbox'  id='u_id_".$value->user_id."' name='status_".$value->user_id."' data-status='".$value->user_status."' data-password='no' class='ios-toggle user_status' value='$value->user_id' /> <label for='u_id_".$value->user_id."' class='checkbox-label'></label></div>";		  
							  }
							echo "</td><td>".$this->basic_model->get_login_counts($value->user_id)." | 0 | 0</td>"
                            . "<td><a href='".ADMIN_URL."user_transaction/".base64_encode($value->user_id)."' class='label label-success'>Transaction</a>&nbsp;";
                            if(!$value->user_status){
								
							echo "<a href='".ADMIN_URL."resend_activation/".base64_encode($value->user_id)."' class='label label-warning'>ReActivation Link</a>";
							}
							echo "</td>"
                            . "</tr>";
										}
                        }
						}
                    }
                    ?>
        </tbody>
      </table>
      <div class="clearfix"> <a href="<?php echo ADMIN_URL.'add_user';?>" class="btn btn-primary"><i class="fa fa-plus"></i>&nbsp;Add User</a></div>
    </div>
  </div>
</div>
<script type="text/javascript">
					$(document).ready(function(){
$(".groups_dropdown").change(function(event)
{
    if(event.target == this)
    {
        var user_id = $(this).data('id');
        var value = $(this).val();
        console.log(value);
            $.ajax({
                        url: SITE_URL + "company/update_user_group/",
                        data: 'user_id=' + user_id + '&value=' + value,
                        type: "POST",
                        success: function (data) {

//                                    window.location.href = "";
                        },
                        error: function () {
                        }
                    });
                
    }
});
});
	function ajaxindicatorstart(text)
	{
		if(jQuery('body').find('#resultLoading').attr('id') != 'resultLoading'){
		jQuery('body').append('<div id="resultLoading" style="display:none"><div><img src="<?php echo IMAGES_URL.'ajax-loader.gif';?>"><div>'+text+'</div></div><div class="bg"></div></div>');
		}
		
		jQuery('#resultLoading').css({
			'width':'100%',
			'height':'100%',
			'position':'fixed',
			'z-index':'10000000',
			'top':'0',
			'left':'0',
			'right':'0',
			'bottom':'0',
			'margin':'auto'
		});	
		
		jQuery('#resultLoading .bg').css({
			'background':'#000000',
			'opacity':'0.7',
			'width':'100%',
			'height':'100%',
			'position':'absolute',
			'top':'0'
		});
		
		jQuery('#resultLoading>div:first').css({
			'width': '250px',
			'height':'75px',
			'text-align': 'center',
			'position': 'fixed',
			'top':'0',
			'left':'0',
			'right':'0',
			'bottom':'0',
			'margin':'auto',
			'font-size':'16px',
			'z-index':'10',
			'color':'#ffffff'
			
		});

	    jQuery('#resultLoading .bg').height('100%');
        jQuery('#resultLoading').fadeIn(300);
	    jQuery('body').css('cursor', 'wait');
	}

	function ajaxindicatorstop()
	{
	    jQuery('#resultLoading .bg').height('100%');
        jQuery('#resultLoading').fadeOut(300);
	    jQuery('body').css('cursor', 'default');
	}
	
	
  jQuery(document).ajaxStart(function () {
   		//show ajax indicator
		ajaxindicatorstart('Updating data.. please wait..');
  }).ajaxStop(function () {
		//hide ajax indicator
		ajaxindicatorstop();
  });
    $(document).on("click", ".user_status", function (e) {
		e.preventDefault();
        id = $(this).attr('id');
		
		var pass=$(this).data("password");
		if(pass=="no"){
			 bootbox.alert({
                message: "User still not logged in yet",
                callback: function () { /* your callback code */
                },
                title: 'Manage Company Account Status'
            });
			return ;
		}
		
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
            message: 'Do you really want to ' + status + ' user profile?',
            callback: function (result) {
                if (result == true) {
                    if (document.getElementById(id).checked) {
                        status = '0';
                    }
                    else {
                        status = '1';
                    }
                    $.ajax({
                        url: SITE_URL + "company/update_status",
                        data: 'user_id=' + u_id + '&status=' + status,
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
            title: 'Manage Company Account Status'
        });
    });
</script>