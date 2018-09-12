<div class="col-md-12">
    <?php
    $attributes = array('id' => 'collegesignupform', 'class' => 'regration-form form-horizontal cutom-reg');

    echo form_open(SITE_URL . "create_college_user", $attributes);
    ?>

    <div class="row">
        <div class="col-md-6">

            <div class="left-register">

                <h2><span>BetterMynd</span> Register Form</h2>
                <p style="text-align:left;">See why BetterMynd is the fastest growing telemedicine software for providers.</p>
                <ul>
                    <li><a href=""><i class="fa fa-check-circle-o" aria-hidden="true"></i>&nbsp; How providers are increasing revenue.</a></li>
                    <li><a href=""><i class="fa fa-check-circle-o" aria-hidden="true"></i>&nbsp; Connecting with patients via 2-way secure HD video.</a></li>
                    <li><a href=""><i class="fa fa-check-circle-o" aria-hidden="true"></i>&nbsp; Billing and reimbursement for remote treatment.</a></li>
                    <li><a href=""><i class="fa fa-check-circle-o" aria-hidden="true"></i>&nbsp; Managing diagnosis and treatment with ePrescribe.</a></li>
                    <li><a href=""><i class="fa fa-check-circle-o" aria-hidden="true"></i>&nbsp; Overview of our turn-key student adoption program.</a></li>	
                </ul>
            </div>
        </div>    

        <div class="col-md-6 ">
        
      
            <div class="right-register">
              <?php if(isset($error) && !empty($error)){
		?>
        <div class="clearfix"></div>
        <br/>
		<div class="alert alert-danger text-left"><?php echo $error;?></div>
        <div class="clearfix"></div>        
		<?php
	}
	 if(isset($message) && !empty($message)){
		?>
        <div class="clearfix"></div>        
        <br/>        
		<div class="alert alert-success  text-left"><?php echo $message;?></div>
                <div class="clearfix"></div>
		<?php
	}
	?>  
                <div class="form-group">
                    <h3>College Registration</h3>
                </div>
                <div class="form-group">
                    <label for="exampleInputFirstName">First Name <span class="mandatory">*</span></label>
                    <?php echo form_input($first_name); ?>
                    <?php echo form_input($user_type); ?>

                </div>

                <div class="form-group">
                    <label for="exampleInputLastName">Last Name <span class="mandatory">*</span></label>
                    <?php echo form_input($last_name); ?>

                </div>

                <div class="form-group">
                    <label for="exampleInputEmail1">Email Address <span class="mandatory">*</span></label>
                    <?php echo form_input($user_email); ?>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">College Name <span class="mandatory">*</span></label>
                    <?php echo form_input($college_name); ?> 
                </div>


                <div class="form-group">
                    <label for="exampleInputPassword1">College Address <span class="mandatory">*</span></label>
                    <?php echo form_input($college_address); ?> 
                </div>


                <div class="form-group">
                    <label for="exampleInputPassword1">College State <span class="mandatory">*</span></label>
                    <?php
                    if (isset($edit_data) && !empty($edit_data)) {
                        $selected = array($edit_data[0]->college_state);
                    } else {
                        $selected = isset($postdata) && !empty($postdata['college_state']) ? $postdata['college_state'] : '';
                    }
                    ?>
                    <?php echo form_dropdown("college_state", $states, $selected, "class='form-control chosen'"); ?> 
                </div>

                <div class="form-group">
                    <label for="exampleInputPassword1">College City <span class="mandatory">*</span></label>
                    <?php echo form_input($college_city); ?> 
                </div>


                <div class="form-group">
                    <label for="exampleInputPassword1">College Zipcode <span class="mandatory">*</span></label>
                    <?php echo form_input($college_zipcode); ?> 
                </div>


                <div class="form-group">
                    <label for="exampleInputPassword1">Office Phone No. <span class="mandatory">*</span></label>
                    <?php echo form_input($college_office_no); ?> 
                </div>




                <div class="form-group">
                    <div class="checkbox">
                        <label>
                            <?php echo form_input($terms_checked); ?> Accept terms & conditions <span class="mandatory">*</span>
                        </label>
                        <span class="paddtop10"><a data-toggle="modal" data-target="#myModal" class="to_register" href="javascript:void(0);"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> </a></span>
                    </div>
                </div>
                <div class="form-group margbtm">
                    <?php echo form_submit('submit', lang('create_user_submit_btn'), array("class" => "btn btn-primary pull-left", "id" => "signup_btn")); ?> 
                    <span class="paddtop10 pull-right">Already Have an Account  <a href="<?php echo SITE_URL; ?>login" class="to_register">Login </a></span>  </div>

                <?php echo form_close(); ?> 
            </div> 
            <div class="claer"></div>  
        </div>
        <div class="claer"></div> 
    </div> 
</div>    
</div>            

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?php echo $terms_conditions->page_title; ?></h4>
            </div>
            <div class="modal-body">
                <?php echo html_entity_decode($terms_conditions->page_content); ?>
            </div>
        </div>

    </div>
</div>