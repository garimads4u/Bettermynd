<div class="col-lg-10 col-md-12">
  <h2 class="page-heading">Company Profile</h2>
  <div id="infoMessage">
    <?php if (isset($message)) {
   ?>
    <p class="alert alert-success text-left">
      <?php
            echo $message;
            ?>
    </p>
    <?php }
        ?>
    <?php if (isset($error)) {
                ?>
    <p class="alert alert-danger text-left">
      <?php
            echo $error;
            ?>
    </p>
    <?php }
        ?>
  </div>
  <div class="x_panel">
    <div class="x_content">
      <?php
        $attributes = array('id' => 'company_profile', 'class' => 'myprofile form-horizontal', 'enctype' => 'multipart/form-data');

        echo form_open(COMPANY_URL . "company_profile", $attributes);
        ?>
      <?php echo form_input($user_id); ?> <?php echo form_input($action); ?> <?php echo form_input($company_url); ?>
      <div class="row">
        <div class="col-sm-6">
          <div class="form-group"> <?php echo lang('edit_company_profile_name', 'company_name'); ?> <?php echo form_input($company_name); ?> </div>
        </div>
        <div class="col-sm-6">
          <div class="form-group"> <?php echo lang('edit_company_profile_url', 'company_url_dummy'); ?> <?php echo form_input($company_url_dummy); ?> </div>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-6">
          <div class="form-group"> <?php echo lang('edit_company_profile_primary_account_holder', 'primary_account_holder'); ?> <?php echo form_input($primary_account_holder); ?> </div>
        </div>
        <div class="col-sm-6"> 
        </div>
      </div>
      <div class="row">
        <div class="col-sm-6">
          <div class="form-group"> <?php echo lang('edit_company_profile_general_email', 'company_general_email'); ?> <?php echo form_input($company_general_email); ?> </div>
        </div>
        <div class="col-sm-6">
          <div class="form-group"> <?php echo lang('edit_company_profile_support_email', 'company_support_email'); ?> <?php echo form_input($company_support_email); ?> </div>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-6">
          <div class="form-group"> <?php echo lang('edit_company_profile_office_phone', 'office_phone'); ?> <?php echo form_input($office_phone); ?> </div>
        </div>
        <div class="col-sm-6">
          <div class="form-group"> <?php echo lang('edit_company_profile_alternative_office_phone', 'office_phone2'); ?> <?php echo form_input($office_phone2); ?> </div>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-6">
          <div class="form-group"> <?php echo lang('edit_company_profile_mailing_address', 'company_address'); ?> <?php echo form_input($company_address); ?> </div>
        </div>
        <div class="col-sm-6">
          <div class="row">
            <div class="col-sm-6">
              <div class="form-group"> <?php echo lang('edit_company_profile_state', 'state'); ?>
                <?php
$options = $states;

$selected = $company_state;

$attr = 'class="form-control chosen-select"';

echo form_dropdown('state', $options, $selected, $attr);
?>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group"> <?php echo lang('edit_company_profile_zip_code', 'company_zipcode'); ?> <?php echo form_input($company_zipcode); ?> </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-6">
          <div class="form-group"> <?php echo lang('edit_company_profile_website', 'company_website'); ?> <?php echo form_input($company_website); ?> </div>
        </div>
        <div class="col-sm-6">
          <div class="form-group"> <?php echo lang('edit_company_profile_fax_number', 'company_fax_number'); ?> <?php echo form_input($company_fax_number); ?> </div>
        </div>
        <div class="col-sm-12">
          <div class="form-group">
            <label for="bio">About Company <span class='count'>(<?php echo isset($company_desc) && $company_desc != "" ? 500 - strlen($company_desc) : '500'; ?> characters)</span></label>
            <?php
                        $attribute = array(
                            'name' => 'company_desc',
                            'id' => 'company_desc',
                            'maxlength' => '500',
                            'rows' => '4',
                            'value' => $company_desc,
                            'class' => 'form-control about'
                        );



                        echo form_textarea($attribute);
                        ?>
          </div>
        </div>
        <div class="col-sm-12">
          <div class="form-group">
            <label for="bio">Mission Statement <span class='count'>(<?php echo isset($company_mission_stmt) && $company_mission_stmt != "" ? 500 - strlen($company_mission_stmt) : '500'; ?> characters)</span></label>
            <?php
                        $attribute = array(
                            'name' => 'company_mission_stmt',
                            'id' => 'company_mission_stmt',
                            'maxlength' => '500',
                            'rows' => '4',
                            'value' => $company_mission_stmt,
                            'class' => 'form-control about'
                        );



                        echo form_textarea($attribute);
                        ?>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="form-group"> <?php echo lang('edit_company_profile_company_logo', 'company_logo1'); ?>
            <div class="input-group"> <?php echo form_input($company_logo1); ?> <span class="input-group-btn"> <span class="btn btn-primary btn-file"> Upload
              <?php
                        $attribute = array(
                            'type' => 'file',
                            'accept' => 'image/*',
                            'name' => 'company_logo1',
                            'id' => 'company_logo1'
                        );

                        echo form_upload($attribute);
                        ?>
              </span> </span> </div>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="form-group"> <?php echo lang('edit_company_profile_secondary_company_logo', 'company_logo2'); ?>
            <div class="input-group"> <?php echo form_input($company_logo2); ?> <span class="input-group-btn"> <span class="btn btn-primary btn-file"> Upload
              <?php
                                    $attribute = array(
                                        'type' => 'file',
                                        'accept' => 'image/*',
                                        'name' => 'company_logo2',
                                        'id' => 'company_logo2'
                                    );

                                    echo form_upload($attribute);
                                    ?>
              </span> </span> </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-3 col-xs-6">
          <div class="form-group">
            <label for="color1" class=" col-md-12 col-lg-7">Company Color 1</label>
            <div class="col-md-12 col-lg-5">
              <div id="colorSelector1">
                <div style="background-color: <?php echo $logo1_color1; ?>;"></div>
              </div>
              <?php echo form_input($company_logo1_color1); ?> </div>
          </div>
        </div>
        <div class="col-sm-3 col-xs-6">
          <div class="form-group">
            <label for="color2" class=" col-md-12 col-lg-7">Company Color 2</label>
            <div class="col-md-12 col-lg-5">
              <div id="colorSelector2" >
                <div style="background-color: <?php echo $logo1_color2; ?>"></div>
              </div>
              <?php echo form_input($company_logo1_color2); ?> </div>
          </div>
        </div>
        <div class="col-sm-3 col-xs-6">
          <div class="form-group">
            <label for="color3" class="col-md-12 col-lg-7">Company Color 3</label>
            <div class="col-md-12 col-lg-5">
              <div id="colorSelector3" >
                <div style="background-color: <?php echo $logo2_color1; ?>"></div>
              </div>
              <?php echo form_input($company_logo2_color1); ?> </div>
          </div>
        </div>
        <div class="col-sm-3 col-xs-6">
          <div class="form-group">
            <label for="color3" class="col-md-12 col-lg-7">Company Color 4</label>
            <div class="col-md-12 col-lg-5">
              <div id="colorSelector4" >
                <div style="background-color: <?php echo $logo2_color2; ?>"></div>
              </div>
              <?php echo form_input($company_logo2_color2); ?> </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-6">
          <div class="form-group">
            <label for="facebook">Social Media</label>
            <?php echo form_input($company_fb_url); ?> </div>
        </div>
        <div class="col-sm-6">
          <div class="form-group">
            <label for="twitter" class="hidden-xs">&nbsp;</label>
            <?php echo form_input($company_twitter_url); ?> </div>
        </div>
        <div class="col-sm-6">
          <div class="form-group"> <?php echo form_input($company_linkedin_url); ?> </div>
        </div>
        <div class="col-sm-6">
          <div class="form-group"> <?php echo form_input($company_youtube_url); ?> </div>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-12">
          <div class="form-group"> <?php echo lang('edit_company_profile_license_number', 'company_licence_number'); ?> <?php echo form_input($company_licence_number); ?> </div>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-12 drag_section">
          <h3>Headlines</h3>
          <ul id="handle-1" class="heading_line">
            <?php
                        if (isset($company_heading) && !empty($company_heading) && count($company_heading) > 0) {

                            $i = 1;

                            foreach ($company_heading as $value) {
                                ?>
            <li> <span class="drag-handle"><i class="fa fa-navicon"></i> <?php echo $i; ?> </span> <span><a href="javascript:void(0);" class="delete_heading" data-id="<?php echo $value->heading_id; ?>"><i class="fa fa-times "></i></a></span>
              <div class="form-group"> <?php echo lang('edit_company_profile_heading', 'heading_title'); ?> <?php echo form_input(array('name' => 'heading_title[]', 'placeholder' => 'Headline', 'class' => 'form-control heading_title', 'value' => isset($value->heading_title) && $value->heading_title != "" ? $value->heading_title : '')); ?> <?php echo form_hidden('heading_id[]', isset($value->heading_id) && $value->heading_id != "" ? $value->heading_id : ''); ?> </div>
              <div class="form-group"> <?php echo lang('edit_company_profile_subheading', 'heading_subtitle'); ?> <?php echo form_input(array('name' => 'heading_subtitle[]', 'placeholder' => 'Sub-Headline', 'class' => 'form-control sub', 'value' => isset($value->heading_subtitle) && $value->heading_subtitle != "" ? $value->heading_subtitle : '')); ?> </div>
            </li>
            <?php
                                $i++;
                            }
                        } else {
                            ?>
            <li> <span class="drag-handle"><i class="fa fa-navicon"></i> 1</span>
              <div class="form-group"> <?php echo lang('edit_company_profile_heading', 'heading_title'); ?> <?php echo form_input(array('name' => 'heading_title[]', 'data-subhead' => 'subheadline1', 'placeholder' => 'Headline', 'class' => 'form-control heading_title')); ?> </div>
              <div class="form-group"> <?php echo lang('edit_company_profile_subheading', 'heading_subtitle'); ?> <?php echo form_input(array('name' => 'heading_subtitle[]', 'id' => 'subheadline1', 'placeholder' => 'Sub-Headline', 'class' => 'form-control sub')); ?> </div>
            </li>
            <?php
}
?>
          </ul>
          <div class="clearfix"> <a href="javascript:void(0);" class="btn btn-default pull-right headline_add">ADD NEW HEADLINES</a> 
            
            <!--                                        <a href="javascript:void(0);" class="btn btn-default pull-right headline_delete">REMOVE HEADLINES</a>--> 
            
          </div>
        </div>
      </div>
      <div class=" drag_section">
        <div class="row">
          <div class="col-sm-6">
            <h3>Benefit Bullets</h3>
            <p>Add bullet points about the benefits of your brand.</p>
          </div>
          <div class="col-sm-6">
            <h3 class="pull-left">Bullet Icon</h3>
            <div class="pull-right"><a href="javascript:void(0);" class="btn btn-primary icon_select1"  data-placement="top" data-toggle="popover" data-container="body" type="button" data-html="true">SELECT ICON</a><img class='bulletclass' src="<?php echo isset($bullet_icon) && $bullet_icon != "" ? IMAGES_URL . 'icons/' . $bullet_icon : IMAGES_URL . 'icons/1-01.svg'; ?>"  alt=""/>
              <input type='hidden' name="bullet_icon" value="<?php echo isset($bullet_icon) && $bullet_icon != "" ? $bullet_icon : '1-01.svg'; ?>">
              <div class="hide icon_bullets">
                <ul class="icon_listing mybullets">
                  <li><a href="javascript:void(0);"><img src="<?php echo IMAGES_URL; ?>icons/1-01.svg"  alt=""/></a></li>
                  <li><a href="javascript:void(0);"><img src="<?php echo IMAGES_URL; ?>icons/1-02.svg"  alt=""/></a></li>
                  <li><a href="javascript:void(0);"><img src="<?php echo IMAGES_URL; ?>icons/1-03.svg"  alt=""/></a></li>
                  <li><a href="javascript:void(0);"><img src="<?php echo IMAGES_URL; ?>icons/1-04.svg"  alt=""/></a></li>
                  <li><a href="javascript:void(0);"><img src="<?php echo IMAGES_URL; ?>icons/1-05.svg"  alt=""/></a></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12">
            <ul id="handle-2" class="benefit-bullets">
              <?php
if (isset($company_bullets) && !empty($company_bullets) && count($company_bullets) > 0) {

    $i = 1;

    foreach ($company_bullets as $value) {
        ?>
              <li class="col-sm-6"><span class="drag-handle"><i class="fa fa-navicon"></i> <?php echo $i; ?></span> <span><a href="javascript:void(0);" class="delete_bullets" data-id="<?php echo $value->company_bullet_id; ?>"><i class="fa fa-times "></i></a></span>
                <div class="form-group"> <?php echo form_input(array('name' => 'bullet_detail[]', 'class' => 'form-control', 'value' => isset($value->bullet_detail) && $value->bullet_detail != "" ? $value->bullet_detail : '')); ?> <?php echo form_hidden('company_bullet_id[]', isset($value->company_bullet_id) && $value->company_bullet_id != "" ? $value->company_bullet_id : ''); ?> </div>
              </li>
              <?php
        $i++;
    }
} else {

    for ($i = 1; $i <= 6; $i++) {
        ?>
              <li class="col-sm-6"><span class="drag-handle"><i class="fa fa-navicon"></i> <?php echo $i; ?></span>
                <div class="form-group"> <?php echo form_input(array('name' => 'bullet_detail[]', 'class' => 'form-control', 'value' => isset($value->bullet_detail) && $value->bullet_detail != "" ? $value->bullet_detail : '')); ?> </div>
              </li>
              <?php
    }
    ?>
              <?php } ?>
            </ul>
            <div class="clearfix"> <a href="javascript:void(0);" class="btn btn-default pull-right add_bullets">ADD NEW BULLET</a> </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-12 drag_section">
          <h3>Features</h3>
          <p>Enter the poduct or service features that your brand offers.</p>
          <ul id="handle-3" class="features">
            <?php
if (isset($company_feature) && !empty($company_feature) && count($company_feature) > 0) {

    $i = 1;

    foreach ($company_feature as $value) {
        ?>
            <li> <span class="drag-handle"><i class="fa fa-navicon"></i> <?php echo $i; ?></span> <span><a href="javascript:void(0);" class="delete_features" data-id="<?php echo $value->feature_id; ?>"><i class="fa fa-times "></i></a></span>
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group"> <?php echo form_input(array('name' => 'feature_title[]', 'placeholder' => 'Title', 'class' => 'form-control', 'value' => isset($value->feature_title) && $value->feature_title != "" ? $value->feature_title : '')); ?> <?php echo form_hidden('feature_id[]', isset($value->feature_id) && $value->feature_id != "" ? $value->feature_id : ''); ?> </div>
                  <div class="pull-right"><a href="javascript:void(0);" class="btn btn-primary icon_select2" id='<?php echo "select_icon_" . $i; ?>'  data-placement="top" data-toggle="popover" data-container="body" type="button" data-html="true">SELECT ICON</a><img src="<?php echo isset($value->feature_icon) && $value->feature_icon != "" ? IMAGES_URL . 'icons/' . $value->feature_icon : IMAGES_URL . 'icons/1-01.svg'; ?>"  alt=""/> <?php echo form_hidden('feature_icon[]', isset($value->feature_icon) && $value->feature_icon != "" ? $value->feature_icon : '1-01.svg'); ?> </div>
                  <div class="clearfix"></div>
                </div>
                <div  class="col-sm-6">
                  <div class="form-group"> <?php echo form_textarea(array('name' => 'feature_description[]', 'maxlength' => '300', 'rows' => '4', 'placeholder' => 'Description (300 Characters)', 'class' => 'form-control feature_textarea', 'value' => isset($value->feature_description) && $value->feature_description != "" ? $value->feature_description : '')); ?> </div>
                  <p class="pull-right"><?php echo isset($value->feature_description) && $value->feature_description != "" ? 300 - strlen($value->feature_description) : '300'; ?> Characters Left</p>
                </div>
              </div>
            </li>
            <?php
        $i++;
    }
} else {

    for ($i = 1; $i <= 3; $i++) {
        ?>
            <li> <span class="drag-handle"><i class="fa fa-navicon"></i> <?php echo $i; ?></span>
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group"> <?php echo form_input(array('name' => 'feature_title[]', 'placeholder' => 'Title', 'class' => 'form-control')); ?> </div>
                  <div class="pull-right"><a href="javascript:void(0);" class="btn btn-primary icon_select2" id="<?php echo "select_icon_" . $i; ?>"  data-placement="top" data-toggle="popover" data-container="body" type="button" data-html="true">SELECT ICON</a><img src="<?php echo IMAGES_URL . 'icons/1-01.svg'; ?>"  alt=""/> <?php echo form_hidden('feature_icon[]', '1-01.svg'); ?> </div>
                  <div class="clearfix"></div>
                </div>
                <div  class="col-sm-6">
                  <div class="form-group"> <?php echo form_textarea(array('name' => 'feature_description[]', 'maxlength' => '300', 'rows' => '4', 'placeholder' => 'Description (300 Characters)', 'class' => 'form-control feature_textarea')); ?> </div>
                  <p class="pull-right">300 Characters Left</p>
                </div>
              </div>
            </li>
            <?php
    }
    ?>
            <?php }
?>
          </ul>
          <div class="clearfix"> <a href="javascript:void(0);" class="btn btn-default pull-right add_feature">ADD NEW FEATURE</a> </div>
        </div>
      </div>
      <div class="register-buttons">
        <button type="submit" class="btn btn-primary">Save</button>
        <a href="#" class="btn btn-default"> Cancel </a> </div>
      <?php echo form_close(); ?> </div>
  </div>
</div>
<style>

    #colorSelector1 div{

        position: relative;

        width: 30px;

        height: 30px;

        background: url(<?php echo IMAGES_URL; ?>select.png) -3px -3px;

    }

    #colorSelector2 div{

        position: relative;

        width: 30px;

        height: 30px;

        background: url(<?php echo IMAGES_URL; ?>select.png) -3px -3px;

    }

    #colorSelector3 div{

        position: relative;

        width: 30px;

        height: 30px;

        background: url(<?php echo IMAGES_URL; ?>select.png) -3px -3px;

    }

    #colorSelector4 div{

        position: relative;

        width: 30px;

        height: 30px;

        background: url(<?php echo IMAGES_URL; ?>select.png) -3px -3px;

    }

    .popover_footer {

        margin: 0 -15px -10px;

        text-align:center;

        padding: 8px 14px;

        font-size: 14px;

        font-weight: 400;

        line-height: 18px;

        background-color: #F7F7F7;

        border-top: 1px solid #EBEBEB;

        border-radius: 0 0 5px 5px;

    }

    .popover_footer a.btn.show{ display:inline-block !important;}

</style>
<link rel="stylesheet" media="screen" type="text/css" href="<?php echo CSS_URL; ?>colorpicker.css" />
<script type="text/javascript" src="<?php echo JS_URL; ?>colorpicker.js"></script> 
<script>

    $(document).ready(function () {

        $('#colorSelector1').ColorPicker({
            color: '<?php echo $logo1_color1; ?>',
            onShow: function (colpkr) {

                $(colpkr).fadeIn(500);

                return false;

            },
            onHide: function (colpkr) {

                $(colpkr).fadeOut(500);

                return false;

            },
            onChange: function (hsb, hex, rgb) {

                $('#colorSelector1 div').css('backgroundColor', '#' + hex);

                $('#company_logo1_color1').val('#' + hex);

            }

        });



        $('#colorSelector2').ColorPicker({
            color: '<?php echo $logo1_color2; ?>',
            onShow: function (colpkr) {

                $(colpkr).fadeIn(500);

                return false;

            },
            onHide: function (colpkr) {

                $(colpkr).fadeOut(500);

                return false;

            },
            onChange: function (hsb, hex, rgb) {

                $('#colorSelector2 div').css('backgroundColor', '#' + hex);

                $('#company_logo1_color2').val('#' + hex);

            }

        });



        $('#colorSelector3').ColorPicker({
            color: '<?php echo $logo2_color1; ?>',
            onShow: function (colpkr) {

                $(colpkr).fadeIn(500);

                return false;

            },
            onHide: function (colpkr) {

                $(colpkr).fadeOut(500);

                return false;

            },
            onChange: function (hsb, hex, rgb) {

                $('#colorSelector3 div').css('backgroundColor', '#' + hex);

                $('#company_logo2_color1').val('#' + hex);

            }

        });



        $('#colorSelector4').ColorPicker({
            color: '<?php echo $logo2_color2; ?>',
            onShow: function (colpkr) {

                $(colpkr).fadeIn(500);

                return false;

            },
            onHide: function (colpkr) {

                $(colpkr).fadeOut(500);

                return false;

            },
            onChange: function (hsb, hex, rgb) {

                $('#colorSelector4 div').css('backgroundColor', '#' + hex);

                $('#company_logo2_color2').val('#' + hex);

            }

        });



        var i = '<?php echo isset($company_heading) && !empty($company_heading) && count($company_heading) > 0 ? count($company_heading) : 1; ?>';

        $('.headline_add').click(function () {

            var $clone = $('.heading_line li').first().clone();
            
            $clone.find('input').val('');

            $clone.find('.delete_heading').html('');

            $clone.find('.delete_heading').remove();

//            $clone.find('.drag-handle').html('<i class="fa fa-navicon"></i> ' + numItems++);

            $clone.find('.drag-handle').after('<a href="javascript:void(0);" class="d_delete"> <i class="fa fa-remove "></i></a>');

            $clone.appendTo('.heading_line');
            var count = 1;
            $('.heading_line > li:visible .drag-handle').each(function(){
               $(this).html('<i class="fa fa-navicon"></i> ' + count);
               count++;
            });

            //$('.heading_line li span .drag-handle').last().html('<i class="fa fa-navicon"></i> ' + ++i);



        });



        var b_i = '<?php echo isset($company_bullets) && !empty($company_bullets) && count($company_bullets) > 0 ? count($company_bullets) : 6; ?>';

        $('.add_bullets').click(function () {

            var $clone = $('.benefit-bullets li').first().clone();

            $clone.find('input').val('');

            $clone.find('.delete_bullets').html('');

            $clone.find('.delete_bullets').remove();

            $clone.find('.drag-handle').html('<i class="fa fa-navicon"></i> ' + ++b_i);

            $clone.find('.drag-handle').after('<a href="javascript:void(0);" class="d_delete"> <i class="fa fa-remove "></i></a>');

            $clone.appendTo('.benefit-bullets');
            
             var count = 1;
            $('.benefit-bullets > li:visible .drag-handle').each(function(){
               $(this).html('<i class="fa fa-navicon"></i> ' + count);
               count++;
            });

            //$('.benefit-bullets li span').last().html('<i class="fa fa-navicon"></i> ' + ++b_i);



        });



        var f_i = '<?php echo isset($company_feature) && !empty($company_feature) && count($company_feature) > 0 ? count($company_feature) : 3; ?>';

        $('.add_feature').click(function () {

            var $clone = $('.features li').first().clone();
           
            $clone.find('.icon_select2').attr('id', 'select_icon_' + (parseInt(f_i) + 1));

            $clone.find('input').val('');

            $clone.find('textarea').val('');

            $clone.find('.delete_features').html('');

            $clone.find('.delete_features').remove();

            $clone.find('.drag-handle').html('<i class="fa fa-navicon"></i> ' + ++f_i);

            $clone.find('.feature_textarea').parent('div').next().html('300 Charcters left');


            $clone.find('.drag-handle').after('<a href="javascript:void(0);" class="d_delete"> <i class="fa fa-remove "></i></a>');

            $clone.appendTo('.features'); var count = 1;
            $('.features > li:visible .drag-handle').each(function(){
               $(this).html('<i class="fa fa-navicon"></i> ' + count);
               count++;
            });
            

            //$('.drag-handle').last().html('<i class="fa fa-navicon"></i> ' + ++f_i);

            // popupover();

        });

        $('.headline_delete').click(function (e) {

            $('.heading_line ul li:last').remove();

            e.preventDefault();

        });

        $(document).on('click', '.d_delete', function () {
            $(this).closest('li').fadeOut('200');
           

        });





        $(".icon_select1").popover({
            html: true,
            content: function () {



                return $('.icon_bullets').html();

            }

        });



        $(document).on('click', '.mybullets a img', function () {

            console.log($(this));

            var $this = $(this);

            $('input[name=bullet_icon]').val($this.attr('src').substr($this.attr('src').lastIndexOf("/") + 1));

            $('.bulletclass').attr('src', $this.attr('src'));

            $('[data-toggle="popover"]').popover('hide');



        });

        $(document).on('click', '.iconno1 img', function () {



            var $this = $(this);

            var element_id = $('.iconno1').data('info');

            //alert(element_id);

            $('#' + element_id).next('img').attr('src', $this.attr('src'));

            $('#' + element_id).next().next('input[name="feature_icon[]"]').val($this.attr('src').substr($this.attr('src').lastIndexOf("/") + 1));



            $('[data-toggle="popover"]').popover('hide');





        });





    });

    $(document).on('keyup', '.feature_textarea', function () {

        var char = this.value;

        if (char.length >= 0) {

            var c = 300 - char.length;

            $(this).parent('div').next().html(c + ' Charcters left');



        }

    });

    $(document).on('keyup', '.about', function () {



        var char = this.value;

        if (char.length >= 0) {

            var c = 500 - char.length;



//            $('.count').html();

            $(this).parent().find('.count').html(c + ' Charcters left');



        }

    });



//    function popupover() {

//        $(".icon_select2").popover({

//            html: true,

//            content: function () {

//                $('.icon_features ul').data('info', this.id);

//                return $('.icon_features').html();

//            }

//        });

//    }

//    popupover();

    $(document).ready(function () {

        $(document).on('click', '.icon_select2', function () {

            $('[data-toggle="popover"]').popover('destroy');

            el = $(this);

            el_id = $(this).attr('id');

            $.get('<?php echo COMPANY_URL . 'getcontent' ?>/' + el_id + '/0', function (response) {

                el.unbind('click').popover({
                    content: response,
                    title: ('FEATURES' || '&nbsp;') + ' <a class="close" href="javascript:void(0);">&times;</a>',
                    html: true,
                    delay: {show: 500, hide: 100}

                }).popover('show');



            });

        });





        $(document).on('click', '.next', function () {

            var page = parseInt($(this).data('page'));

            $.get('<?php echo COMPANY_URL . 'getcontent' ?>/' + el_id + '/' + ++page, function (response) {

                $('.popover_footer').remove();

                $('.iconno1').html(response);



            });





        });

        $(document).on('click', '.prev', function () {

            var page = parseInt($(this).data('page'));

            $.get('<?php echo COMPANY_URL . 'getcontent' ?>/' + el_id + '/' + --page, function (response) {

                $('.iconno1').html('');

                $('.iconno1').html(response);



            });



        });

        $(document).on('click', '.close', function () {

            $('[data-toggle="popover"]').popover('hide');

        });

    });



</script>