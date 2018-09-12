<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="sections-head">User Transactions</div>
     <div id="infoMessage"><?php if(isset($message)) { 
        ?><p class="alert alert-success text-left"><?php
        echo $message; 
        ?></p><?php
    } ?></div>
    <div id="infoMessage">
        <?php if(isset($error)) { 
        ?><p class="alert alert-danger text-left"><?php
        echo $error; 
        ?></p><?php
    } ?>
    </div>
    
            <?php

			 if(isset($did) && isset($is_user_expired) && $is_user_expired!="2" && $did>0){
		
				?>
<!--                 <div class="x_panel">
        <div class="x_content">
        	<div class="pull-right">
            	<a href="<?php echo ADMIN_URL;?>makeuserpayment/<?php echo $did;?>" class="btn btn-primary">Make Payment</a>
                
            </div>
        </div>
        </div>-->
                <?php
			}
			elseif(isset($did) && isset($is_user_expired) && $is_user_expired =="2" && $did>0 && isset($subscription_id) && $subscription_id>0){
				?>
<!--                 <div class="x_panel">
        <div class="x_content">
        	<div class="pull-right">
            	<a href="javascript:void(0);" class="btn btn-primary cancelsubscription" data-id="<?php echo $subscription_id;?>">Cancel Subscription</a>
                
            </div>
        </div>
        </div>-->
                <?php
				}
				?>
                

    <div class="x_panel">
        <div class="x_content">
            <table id="datatable" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Transaction Number</th>
                        <th>Transaction Date</th>
                        <th>Sub Total</th>
                      
                        <th>Description</th>
                        <th>Package</th>
                        <!--<th>Actions</th>-->
                    </tr>
                </thead>
                <tbody>
                    <?php
                    
                    if (isset($result) && count($result) > 0) {
                        $i=1;
                        foreach ($result as $value) {
                            echo "<tr>"
                            . "<td>" . $i++ . "</td>"
                            . "<td>" . $value->transaction_number . "</td>"
                            . "<td>" . date(DATE_FORMAT, strtotime($value->transaction_date)) . "</td>"
                            . "<td>  " .CURRENCY_SYMBOL.$value->sub_total . "</td>"
                            
                            . "<td>" . $value->transaction_description . "</td>"
                            . "<td>" . ucwords(strtolower($value->package_mode)) . "</td>"
//                            . "<td><a href='".COMPANY_URL."export_invoice/".$value->transaction_number."'><i class='fa fa-file-pdf-o' aria-hidden='true'></i></a></td>"
                            . "</tr>";
                        }
                    }
                    ?>

                </tbody>
            </table>
        </div>
    </div>

</div>
<script type="text/javascript">
$(".cancelsubscription").click(function(e) {
	
        e.preventDefault();
        var subscription_id = $(this).data('id');
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
            message: 'Do you really want to cancel subscription for this user.',
            callback: function (result) {
                if (result == true) {
                    $.ajax({
                        url: SITE_URL + "company/cancelsubscription/"+subscription_id,
                        data: 'subscription_id=' + subscription_id,
                        type: "POST",
                        success: function (data) {
						
                         window.location.href='';

                        },
                        error: function () {
                        }
                    });

                }
            },
            title: 'Cancel Subscription'
        });
    
    
});
</script>
<script type="text/javascript">
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
		ajaxindicatorstart('Please wait while we are canceling this subscription...');
  }).ajaxStop(function () {
		//hide ajax indicator
		ajaxindicatorstop();
  });
</script>