  <div class="col-sm-6 col-xs-12 col-sm-offset-3">
          <h2 class="page-heading"><?php echo lang('change_password_heading');?></h2>
          <div id="infoMessage"><?php echo $message;?></div>
          <div id="infoMessage"><?php echo $error;?></div>

          <div class="x_panel">
            <div class="x_content">
              <?php
        $attributes = array('id' => 'change_password', 'class' => 'myprofile form-horizontal');
    echo form_open(SADMIN_URL."change_password/" ,$attributes);?>
              <div class="row">
                  <div class="col-sm-12">
                    <div class="form-group">
                     <?php echo lang('change_password_old_password_label', 'old');?> <span class="mandatory">*</span>
                      <?php echo form_input($old_password);?>
                    </div>
                  </div>
                
                  <div class="col-sm-12">
                    <div class="form-group">
                      <?php echo sprintf(lang('change_password_new_password_label', 'new'),$min_password_length);?> <span class="mandatory">*</span>
                      <?php echo form_input($new_password);?>
                    </div>
                  </div>
                  <div class="col-sm-12">
                    <div class="form-group">
                      <?php echo lang('change_password_new_password_confirm_label', 'new_confirm');?> <span class="mandatory">*</span>
                      <?php echo form_input($new_password_confirm);?>
                    </div>
                  </div>
                  </div>
                
                  <div class="register-buttons">
  <?php echo form_submit('submit', lang('change_password_submit_btn'),array("class"=>"btn btn-primary"));?>
  
  <?php echo form_input($user_id);?>
	</div>
              <?php echo form_close();?>
            </div>
          </div>
        </div>