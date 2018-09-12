<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="alert alert-danger hide" id="errormsg"></div>
    <?php
    if ($template_data[0]->id) {
        $dpi = 72;
        $canvaswidth = $template_data[0]->width / $dpi; //inch
        $canvasheight = $template_data[0]->height / $dpi; //inch
//$canvaswidth_px = ($canvaswidth*$dpi).'px';//inch
//$canvasheight_px = ($canvasheight*$dpi).'px';//inch
        $canvaswidth_px = $template_data[0]->width . 'px'; //inch
        $canvasheight_px = $template_data[0]->height . 'px'; //inch
        if (isset($user_info->account_holder_name) && $user_info->account_holder_name != "") {

            $name = $user_info->account_holder_name;
            $pos = strrpos($name, ' ');

            if ($pos === false) {
                $full_name = array(
                    'firstname' => $name,
                    'surname' => null
                );
            } else {
                $firstname = substr($name, 0, $pos + 1);
                $surname = substr($name, $pos);
                $full_name = array(
                    'firstname' => $firstname,
                    'surname' => $surname
                );
            }
        }
        ?>
        <div class="clearfix">&nbsp;</div>
        <div class="row">
            <div class="col-md-7 col-sm-7">
                <div class="template_preview">
                    <h3>TEMPLATE PREVIEW</h3>
                    <div class="template_view" style="min-height:450px;">
    <!--                    	<span class="loading-img"><img src="images/loading.gif"><br>LOADING...</span>-->

                        <div id="slider"><input type="hidden" id="hidden"/></div>
                        <div  class="canvas_overflow">
                            <div class="canvas" style="position: relative;">
                                <?php
                                if ($edit && isset($template_elements) && count($template_elements) > 0 && !empty($template_elements[0])) {

                                    foreach ($template_elements as $data) {
                                        $settings = json_decode($data['settings']);
                                        $font_settings = json_decode($data['font_settings']);
                                        $color = $data['color'];
                                        $left = $data['cord_x'] . 'px';
                                        $top = $data['cord_y'] . 'px';
                                        $height = $settings->dsmaxheight . 'px';
                                        $width = $settings->dsmaxwidth . 'px';
                                        $fontsize = ($font_settings->dsfontsize * $dpi / 72) . 'px';
                                        $bold = isset($font_settings->dsbold) ? 'font-weight:bold' : 'font-weight:normal';
                                        $fontfamily = isset($font_settings->dsfont) && $font_settings->dsfont!="" ? str_replace('+', ' ', $font_settings->dsfont) : 'Arial';
                                        $italic = isset($font_settings->dsitalic) ? 'font-style:italic' : 'font-style:normal';
                                        $underline = isset($font_settings->dsunderline) ? 'text-decoration:underline' : 'text-decoration:none';
                                        $strikethrough = isset($font_settings->dsstrikethrough) ? 'text-decoration:line-through' : 'text-decoration:none';


                                        $dstexthstrech = 1;
                                        $dstextvstrech = 1;
                                        if (isset($font_settings->dstextvstrech)) {
                                            if ($font_settings->dstextvstrech >= 1)
                                                $dstextvstrech = $font_settings->dstextvstrech;
                                        }
                                        if (isset($font_settings->dstexthstrech)) {
                                            if ($font_settings->dstexthstrech >= 1)
                                                $dstexthstrech = $font_settings->dstexthstrech;
                                        }
                                        $trans = 'scale(' . $dstexthstrech . ',' . $dstextvstrech . ')';
                                        if ($data['element_type'] == 1 && $data['parent_element_name'] == '') {
                                            ?>
                                            <div class="canvas_image canvas_elements" data-layer="<?php echo $data['element_name']; ?>" style='<?php echo "overflow:hidden;left:$left;top:$top;color: $color;font-size:$fontsize;text-align: $font_settings->dsalign;font-family: $fontfamily;$bold;$italic;$strikethrough;height:$height;width:$width;border:none "; ?>'>
                                                <?php if ($data['element_name'] == "HeadShot") { ?>
                                                    <img src="<?php echo UPLOAD_URL . $headshot; ?>" width="100%" height="100%" border='0'>
                                                <?php } else { ?>
                                                    <span style="<?php echo "$underline;display:block;transform:$trans;-webkit-transform;$trans;"; ?>"><?php echo $settings->dsdefaultcontent; ?></span>
                                                <?php } ?>
                                            </div>
                                            <?php
                                        } elseif ($data['element_type'] == 2 && $data['parent_element_name'] == '') {

                                            if ($data['element_name'] == "First Name") {
                                                ?>
                                                <div class="canvas_text canvas_elements" data-layer="<?php echo $data['element_name']; ?>"  style='<?php echo "overflow:hidden;left:$left;top:$top;color: $color;font-size: $fontsize;text-align: $font_settings->dsalign;font-family: $fontfamily;$bold;$italic;$strikethrough;height:$height;width:$width; "; ?>'><span style="<?php echo "$underline;display:block;transform:$trans;-webkit-transform;$trans;"; ?>"><?php echo isset($full_name['firstname']) && $full_name['firstname'] != "" ? trim($full_name['firstname']) : $settings->dsdefaultcontent; ?></span></div>

                                            <?php } elseif ($data['element_name'] == "Last Name") {
                                                ?>
                                                <div class="canvas_text canvas_elements" data-layer="<?php echo $data['element_name']; ?>"  style='<?php echo "overflow:hidden;left:$left;top:$top;color: $color;font-size: $fontsize;text-align: $font_settings->dsalign;font-family: $fontfamily;$bold;$italic;$strikethrough;height:$height;width:$width; "; ?>'><span style="<?php echo "$underline;display:block;transform:$trans;-webkit-transform;$trans;"; ?>"><?php echo isset($full_name['surname']) && $full_name['surname'] != "" ? trim($full_name['surname']) : $settings->dsdefaultcontent; ?></span></div>

                                            <?php } elseif ($data['element_name'] == "Phone - Office") {
                                                ?>
                                                <div class="canvas_text canvas_elements" data-layer="<?php echo $data['element_name']; ?>"  style='<?php echo "overflow:hidden;left:$left;top:$top;color: $color;font-size: $fontsize;text-align: $font_settings->dsalign;font-family: $fontfamily;$bold;$italic;$strikethrough;height:$height;width:$width; "; ?>'><span style="<?php echo "$underline;display:block;transform:$trans;-webkit-transform;$trans;"; ?>"><?php echo isset($user_info->office_phone) && $user_info->office_phone != "" ? $user_info->office_phone : $settings->dsdefaultcontent; ?></span></div>
                                            <?php } elseif ($data['element_name'] == "Phone - Mobile") {
                                                ?>
                                                <div class="canvas_text canvas_elements" data-layer="<?php echo $data['element_name']; ?>"  style='<?php echo "overflow:hidden;left:$left;top:$top;color: $color;font-size: $fontsize;text-align: $font_settings->dsalign;font-family: $fontfamily;$bold;$italic;$strikethrough;height:$height;width:$width; "; ?>'><span style="<?php echo "$underline;display:block;transform:$trans;-webkit-transform;$trans;"; ?>"><?php echo isset($user_info->mobile_phone) && $user_info->mobile_phone != "" ? $user_info->mobile_phone : $settings->dsdefaultcontent; ?></span></div>
                                            <?php } elseif ($data['element_name'] == "Fax") {
                                                ?>
                                                <div class="canvas_text canvas_elements" data-layer="<?php echo $data['element_name']; ?>"  style='<?php echo "overflow:hidden;left:$left;top:$top;color: $color;font-size: $fontsize;text-align: $font_settings->dsalign;font-family: $fontfamily;$bold;$italic;$strikethrough;height:$height;width:$width; "; ?>'><span style="<?php echo "$underline;display:block;transform:$trans;-webkit-transform;$trans;"; ?>"><?php echo isset($user_info->fax_number) && $user_info->fax_number != "" ? $user_info->fax_number : $settings->dsdefaultcontent; ?></span></div>
                                            <?php } elseif ($data['element_name'] == "Email") {
                                                ?>
                                                <div class="canvas_text canvas_elements" data-layer="<?php echo $data['element_name']; ?>"  style='<?php echo "overflow:hidden;left:$left;top:$top;color: $color;font-size: $fontsize;text-align: $font_settings->dsalign;font-family: $fontfamily;$bold;$italic;$strikethrough;height:$height;width:$width; "; ?>'><span style="<?php echo "$underline;display:block;transform:$trans;-webkit-transform;$trans;"; ?>"><?php echo isset($user_info->user_email) && $user_info->user_email != "" ? $user_info->user_email : $settings->dsdefaultcontent; ?></span></div>
                                            <?php } elseif ($data['element_name'] == "Website") {
                                                ?>
                                                <div class="canvas_text canvas_elements" data-layer="<?php echo $data['element_name']; ?>"  style='<?php echo "overflow:hidden;left:$left;top:$top;color: $color;font-size: $fontsize;text-align: $font_settings->dsalign;font-family: $fontfamily;$bold;$italic;$strikethrough;height:$height;width:$width; "; ?>'><span style="<?php echo "$underline;display:block;transform:$trans;-webkit-transform;$trans;"; ?>"><?php echo isset($user_info->website) && $user_info->website != "" ? $user_info->website : $settings->dsdefaultcontent; ?></span></div>
                                            <?php } elseif ($data['element_name'] == "Address") {
                                                ?>
                                                <div class="canvas_text canvas_elements" data-layer="<?php echo $data['element_name']; ?>"  style='<?php echo "overflow:hidden;left:$left;top:$top;color: $color;font-size: $fontsize;text-align: $font_settings->dsalign;font-family: $fontfamily;$bold;$italic;$strikethrough;height:$height;width:$width; "; ?>'><span style="<?php echo "$underline;display:block;transform:$trans;-webkit-transform;$trans;"; ?>"><?php echo isset($user_info->address) && $user_info->address != "" ? $user_info->address : $settings->dsdefaultcontent; ?></span></div>
                                            <?php } elseif ($data['element_name'] == "Zip") {
                                                ?>
                                                <div class="canvas_text canvas_elements" data-layer="<?php echo $data['element_name']; ?>"  style='<?php echo "overflow:hidden;left:$left;top:$top;color: $color;font-size: $fontsize;text-align: $font_settings->dsalign;font-family: $fontfamily;$bold;$italic;$strikethrough;height:$height;width:$width; "; ?>'><span style="<?php echo "$underline;display:block;transform:$trans;-webkit-transform;$trans;"; ?>"><?php echo isset($user_info->zipcode) && $user_info->zipcode != "" ? $user_info->zipcode : $settings->dsdefaultcontent; ?></span></div>
                                            <?php } elseif ($data['element_name'] == "Bio") {
                                                ?>
                                                <div class="canvas_text canvas_elements" data-layer="<?php echo $data['element_name']; ?>"  style='<?php echo "overflow:hidden;left:$left;top:$top;color: $color;font-size: $fontsize;text-align: $font_settings->dsalign;font-family: $fontfamily;$bold;$italic;$strikethrough;height:$height;width:$width; "; ?>'><span style="<?php echo "$underline;display:block;transform:$trans;-webkit-transform;$trans;"; ?>"><?php echo isset($user_info->biography) && $user_info->biography != "" ? $user_info->biography : $settings->dsdefaultcontent; ?></span></div>
                                            <?php } else {
                                                ?>
                                                <div class="canvas_text canvas_elements" data-layer="<?php echo $data['element_name']; ?>"  style='<?php echo "overflow:hidden;left:$left;top:$top;color: $color;font-size: $fontsize;text-align: $font_settings->dsalign;font-family: $fontfamily;$bold;$italic;$strikethrough;height:$height;width:$width; "; ?>'><span style="<?php echo "$underline;display:block;transform:$trans;-webkit-transform;$trans;"; ?>"><?php echo $settings->dsdefaultcontent; ?></span></div>
                                            <?php }
                                            ?>

                                            <?php
                                        } elseif ($data['element_type'] == 5) {
                                            ?>
                                            <div class="canvas_text canvas_elements" data-layer="<?php echo $data['element_name']; ?>"  style='<?php echo "overflow:hidden;left:$left;top:$top;color: $color;font-size: $fontsize;text-align: $font_settings->dsalign;font-family: $fontfamily;$bold;$italic;$strikethrough;height:$height;width:$width; "; ?>'><span style="<?php echo "$underline;display:block;transform:$trans;-webkit-transform;$trans;"; ?>"><?php echo $settings->dsdefaultcontent; ?></span></div>
                                            <?php
                                        } elseif ($data['element_type'] == 6) {
                                            ?>
                                            <div class="canvas_text canvas_elements" data-layer="<?php echo $data['element_name']; ?>"  style='<?php echo "overflow:hidden;left:$left;top:$top;color: $color;font-size: $fontsize;text-align: $font_settings->dsalign;font-family: $fontfamily;$bold;$italic;$strikethrough;height:$height;width:$width; "; ?>'><span style="<?php echo "$underline;display:block;transform:$trans;-webkit-transform;$trans;"; ?>"><?php echo $settings->dsdefaultcontent; ?></span></div>
                                            <?php
                                        } elseif ($data['element_type'] == 3 && $data['parent_element_name'] == '') {
                                            $content = $settings->dsdefaultcontent;
                                            $bullet_type = $settings->dsbullettype;
                                            // $content = nl2br($content);
                                            $res = explode("\n", $content);
                                            $res = array_filter($res, 'trim');
                                            if ($bullet_type == '1')
                                                $num = 1;
                                            else if ($bullet_type == 'disc')
                                                $num = '&bull;';
                                            else if ($bullet_type == 'circle')
                                                $num = '&#9900;';
                                            else if ($bullet_type == 'square')
                                                $num = '&#9755;';
                                            else
                                                $num = '&bull;';
                                            $content = '<ul class="nobullet">';
                                            foreach ($res as $v) {
                                                if ($bullet_type == '1' || $bullet_type == 1) {
                                                    $content .= '<li><span class="dsbullet">' . $num . '.</span> ' . $v . '</li>';
                                                    $num++;
                                                } else {
                                                    $content .= '<li><span class="dsbullet">' . $num . '</span> ' . $v . '</li>';
                                                }
                                            }
                                            $content.='</ul>';
//                            if($bullet_type=='1' || $bullet_type=='A' || $bullet_type=='a' || $bullet_type=='i' || $bullet_type=='I')
//                                $content.='</ol>';
//                            else
//                                $content.='</ul>';
                                            ?>
                                            <div class="canvas_text canvas_elements" data-layer="<?php echo $data['element_name']; ?>"  style='<?php echo "overflow:hidden;left:$left;top:$top;color: $color;font-size: $fontsize;text-align: $font_settings->dsalign;font-family: $fontfamily;$bold;$italic;$strikethrough;height:$height;width:$width; "; ?>'><span style="<?php echo "$underline;display:block;transform:$trans;-webkit-transform;$trans;"; ?>"><?php echo $content; ?></span></div>
                                            <?php
                                        } elseif ($data['element_type'] == 4) {
                                            ?>
                                            <div class="canvas_text canvas_elements" data-layer="<?php echo $data['element_name']; ?>" style='<?php echo "overflow:hidden;left:$left;top:$top;color: $color;font-size: $fontsize;text-align: $font_settings->dsalign;font-family: $fontfamily;$bold;$italic;$strikethrough;height:$height;width:$width; "; ?>'><span style="<?php echo "$underline;display:block;transform:$trans;-webkit-transform;$trans;"; ?>">
                                                    <?php
                                                    $result_child = $this->tmodel->get_personalise_elements($data['element_name'], $data['template_id'], 4);
                                                    // prd($result_child,1);
												
//                $sql = 'select * from dim_template_elements where is_active=1 and parent_element_name=\''.$data['element_name'].'\' and section_id = '.$section_id;
//                $result_child = mysql_query($sql);
                                                    $t_company_elements = $result_child['t_company_elements'][0];
												
                                                    $element_content = json_decode(str_replace('|-|', ' ', base64_decode($t_company_elements['element_content'])));

                                                    foreach ($element_content as $key => $value) {
                                                        ?>
                                                        <div class="relative clearfix">
                                                          <!--  <div class="canvas_text" data-layer="<?php echo $data['element_name']; ?>-title"><span>Feature</span></div>
                                                            <div class="pull-left" data-layer="<?php echo $data['element_name']; ?>-icon" style="border:1px dashed #f5f5f5;width:50px;height:20px; margin-right:8px; bottom:5px;"><span></span></div>
                                                            <div class="" data-layer="<?php echo $data['element_name']; ?>-description"><span>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</span></div>
                                                                             </div>-->
                                                            <?php
                                                            foreach ($result_child['t_element'] as $data_child) {
                                                                $settings = json_decode($data_child['settings']);
                                                                $font_settings = json_decode($data_child['font_settings']);
                                                                $color = $data_child['color'];
                                                                $left = $data_child['cord_x'] . 'px';
                                                                $top = $data_child['cord_y'] . 'px';
                                                                $height = $settings->dsmaxheight . 'px';
                                                                $width = $settings->dsmaxwidth . 'px';
                                                                $fontsize = ($font_settings->dsfontsize * $dpi / 72) . 'px';
                                                                $bold = isset($font_settings->dsbold) ? 'font-weight:bold' : 'font-weight:normal';
                                                                $fontfamily = isset($font_settings->dsfont) ? str_replace('+', ' ', $font_settings->dsfont) : '';
                                                                $italic = isset($font_settings->dsitalic) ? 'font-style:italic' : 'font-style:normal';
                                                                $underline = isset($font_settings->dsunderline) ? 'text-decoration:underline' : 'text-decoration:none';
                                                                $strikethrough = isset($font_settings->dsstrikethrough) ? 'text-decoration:line-through' : 'text-decoration:none';


                                                                $dstexthstrech = 1;
                                                                $dstextvstrech = 1;
                                                                if (isset($font_settings->dstextvstrech)) {
                                                                    if ($font_settings->dstextvstrech >= 1)
                                                                        $dstextvstrech = $font_settings->dstextvstrech;
                                                                }
                                                                if (isset($font_settings->dstexthstrech)) {
                                                                    if ($font_settings->dstexthstrech >= 1)
                                                                        $dstexthstrech = $font_settings->dstexthstrech;
                                                                }
                                                                $trans = 'scale(' . $dstexthstrech . ',' . $dstextvstrech . ')';
                                                                // echo   $data_child['element_name'] . $data['element_name'].'-title';
                                                                if ($data_child['element_name'] == $data['element_name'] . '-title') {
                                                                    ?>
                                                                    <div class="clearfix" data-layer="<?php echo $data_child['element_name']; ?>"  style='<?php echo "overflow:hidden;color: $color;font-size: $fontsize;text-align: $font_settings->dsalign;font-family: $fontfamily;$bold;$italic;$strikethrough;height:$height;width:$width; "; ?>'><span style="<?php echo "$underline;display:block;transform:$trans;-webkit-transform;$trans;"; ?>"><?php echo $value->feature_title; ?></span></div>
                                                                    <?php
                                                                }
                                                                ?>

                                                                <?php
                                                                if ($data_child['element_name'] == $data['element_name'] . '-icon') {
                                                                    ?>
                                                                    <div class="clearfix">
                                                                        <div class="pull-left" data-layer="<?php echo $data_child['element_name']; ?>" style='<?php echo "overflow:hidden;color: $color;font-size:$fontsize;text-align: $font_settings->dsalign;font-family: $fontfamily;$bold;$italic;$strikethrough;height:$height;width:$width;  margin-right:8px; bottom:5px;"; ?>'>

                                                                            <span style="<?php echo "$underline;display:block;transform:$trans;-webkit-transform;$trans;"; ?>"data-svg='<?php echo IMAGES_URL . 'icons/' . $value->feature_icon; ?>'><?php echo file_get_contents(IMAGES_URL . 'icons/' . $value->feature_icon); ?></span>

                                                                        </div>
                                                                        <?php
                                                                    }
                                                                    if ($data_child['element_name'] == $data['element_name'] . '-description') {
                                                                        ?>
                                                                        <div class="" data-layer="<?php echo $data_child['element_name']; ?>"  style='<?php echo "overflow:hidden;color: $color;font-size: $fontsize;text-align: $font_settings->dsalign;font-family: $fontfamily;$bold;$italic;$strikethrough;height:$height;width:$width; "; ?>'><span style="<?php echo "$underline;display:block;transform:$trans;-webkit-transform;$trans;"; ?>"><?php echo $value->feature_description ?></span></div>
                                                                    </div>
                                                                    <?php
                                                                }
                                                                ?>

                                                                <?php
                                                            }
                                                            ?>
                                                        </div>
                                                    <?php } ?>
                                                </span> </div>
                                            <?php
                                        }
                                        if (trim($font_settings->dsfont) != '') {
                                            ?>

                                            <link href="https://fonts.googleapis.com/css?family=<?php echo $font_settings->dsfont; ?>" rel="stylesheet" type="text/css">
                                            <?php
                                        }
                                    }
                                }
                                ?>
                            </div></div>
                    </div>
                </div>
            </div>
            <div class="col-md-5 col-sm-5">
            
                    <div class="x_panel template_perametors"><h2>TEMPLATES</h2>

                        <?php
                        $i = 0;
						if(isset($template_elements) && !empty($template_elements)){
                        foreach ($template_elements as $data) {
                            $settings = json_decode($data['settings']);
                            $readonly = isset($settings->dsusereditable) ? true : false;
                            if (!$readonly) {
                                ?>

                                <div data-source="<?php echo $data['element_name']; ?>">
                                    <?php if ($data['element_type'] != 5 && $data['element_type'] != 6) { ?>
                                        <label class="control-label" for="full-name"><span class="source" style="cursor:pointer;"><?php echo ucwords($data['element_name']); ?></span><?php if ($data['element_type'] == 1) { ?> <a href="#" data-toggle="tooltip" data-placement="bottom" title="Please upload an image that you want to be displayed in the <?php echo $data['element_name']; ?> section of the template."><i class="fa fa-info-circle"></i></a> <?php } ?></label>
                    <!--                        <input type="text" id="full-name" class="form-control" placeholder="123-456-7890" >-->
                                        <?php
                                    } if ($data['element_type'] == 2) {
                                        if ($data['element_name'] == "First Name") {
                                            ?>
                                            <input type="text" placeholder="<?php echo ucwords($settings->dsdefaultcontent); ?>" value="<?php echo isset($full_name['firstname']) && $full_name['firstname'] != "" ? trim($full_name['firstname']) : ''; ?>" maxlength="<?php echo $settings->dsmaxchars; ?>" class="form-control element_type" <?php echo $readonly; ?> data-element_type="<?php echo $data['element_type']; ?>">
                                            <?php if (isset($settings->dsscalefont)) { ?>
                                                <span class="dssettings-parent">
                                                    <input type="text" class="ds-fontpick" name="font_settings[]" value='<?php echo $data['font_settings']; ?>'>
                                                </span>
                                                <?php
                                            }
                                        } elseif ($data['element_name'] == "Last Name") {
                                            ?>
                                            <input type="text" placeholder="<?php echo ucwords($settings->dsdefaultcontent); ?>" value="<?php echo isset($full_name['surname']) && $full_name['surname'] != "" ? trim($full_name['surname']) : ''; ?>" maxlength="<?php echo $settings->dsmaxchars; ?>" class="form-control element_type" <?php echo $readonly; ?> data-element_type="<?php echo $data['element_type']; ?>">
                                            <?php if (isset($settings->dsscalefont)) { ?>
                                                <span class="dssettings-parent">
                                                    <input type="text" class="ds-fontpick" name="font_settings[]" value='<?php echo $data['font_settings']; ?>'>
                                                </span>
                                                <?php
                                            }
                                        } elseif ($data['element_name'] == "Phone - Office") {
                                            ?>
                                            <input type="text" placeholder="<?php echo $settings->dsdefaultcontent; ?>" value="<?php echo isset($user_info->office_phone) && $user_info->office_phone != "" ? $user_info->office_phone : ''; ?>" maxlength="<?php echo $settings->dsmaxchars; ?>" class="form-control element_type" <?php echo $readonly; ?> data-element_type="<?php echo $data['element_type']; ?>">
                                            <?php if (isset($settings->dsscalefont)) { ?>
                                                <span class="dssettings-parent">
                                                    <input type="text" class="ds-fontpick" name="font_settings[]" value='<?php echo $data['font_settings']; ?>'>
                                                </span>
                                                <?php
                                            }
                                        } elseif ($data['element_name'] == "Phone - Mobile") {
                                            ?>
                                            <input type="text" placeholder="<?php echo $settings->dsdefaultcontent; ?>" value="<?php echo isset($user_info->mobile_phone) && $user_info->mobile_phone != "" ? $user_info->mobile_phone : ''; ?>" maxlength="<?php echo $settings->dsmaxchars; ?>" class="form-control element_type" <?php echo $readonly; ?> data-element_type="<?php echo $data['element_type']; ?>">
                                            <?php if (isset($settings->dsscalefont)) { ?>
                                                <span class="dssettings-parent">
                                                    <input type="text" class="ds-fontpick" name="font_settings[]" value='<?php echo $data['font_settings']; ?>'>
                                                </span>
                                                <?php
                                            }
                                        } elseif ($data['element_name'] == "Fax") {
                                            ?>
                                            <input type="text" placeholder="<?php echo $settings->dsdefaultcontent; ?>" value="<?php echo isset($user_info->fax_number) && $user_info->fax_number != "" ? $user_info->fax_number : ''; ?>" maxlength="<?php echo $settings->dsmaxchars; ?>" class="form-control element_type" <?php echo $readonly; ?> data-element_type="<?php echo $data['element_type']; ?>">
                                            <?php if (isset($settings->dsscalefont)) { ?>
                                                <span class="dssettings-parent">
                                                    <input type="text" class="ds-fontpick" name="font_settings[]" value='<?php echo $data['font_settings']; ?>'>
                                                </span>
                                                <?php
                                            }
                                        } elseif ($data['element_name'] == "Email") {
                                            ?>
                                            <input type="text" placeholder="<?php echo $settings->dsdefaultcontent; ?>" value="<?php echo isset($user_info->user_email) && $user_info->user_email != "" ? $user_info->user_email : ''; ?>" maxlength="<?php echo $settings->dsmaxchars; ?>" class="form-control element_type" <?php echo $readonly; ?> data-element_type="<?php echo $data['element_type']; ?>">
                                            <?php if (isset($settings->dsscalefont)) { ?>
                                                <span class="dssettings-parent">
                                                    <input type="text" class="ds-fontpick" name="font_settings[]" value='<?php echo $data['font_settings']; ?>'>
                                                </span>
                                                <?php
                                            }
                                        } elseif ($data['element_name'] == "Website") {
                                            ?>
                                            <input type="text" placeholder="<?php echo $settings->dsdefaultcontent; ?>" value="<?php echo isset($user_info->website) && $user_info->website != "" ? $user_info->website : ''; ?>" maxlength="<?php echo $settings->dsmaxchars; ?>" class="form-control element_type" <?php echo $readonly; ?> data-element_type="<?php echo $data['element_type']; ?>">
                                            <?php if (isset($settings->dsscalefont)) { ?>
                                                <span class="dssettings-parent">
                                                    <input type="text" class="ds-fontpick" name="font_settings[]" value='<?php echo $data['font_settings']; ?>'>
                                                </span>
                                                <?php
                                            }
                                        } elseif ($data['element_name'] == "Address") {
                                            ?>
                                            <input type="text" placeholder="<?php echo $settings->dsdefaultcontent; ?>" value="<?php echo isset($user_info->address) && $user_info->address != "" ? $user_info->address : ''; ?>" maxlength="<?php echo $settings->dsmaxchars; ?>" class="form-control element_type" <?php echo $readonly; ?> data-element_type="<?php echo $data['element_type']; ?>">
                                            <?php if (isset($settings->dsscalefont)) { ?>
                                                <span class="dssettings-parent">
                                                    <input type="text" class="ds-fontpick" name="font_settings[]" value='<?php echo $data['font_settings']; ?>'>
                                                </span>
                                                <?php
                                            }
                                        } elseif ($data['element_name'] == "Zip") {
                                            ?>
                                            <input type="text" placeholder="<?php echo $settings->dsdefaultcontent; ?>" value="<?php echo isset($user_info->zipcode) && $user_info->zipcode != "" ? $user_info->zipcode : ''; ?>" maxlength="<?php echo $settings->dsmaxchars; ?>" class="form-control element_type" <?php echo $readonly; ?> data-element_type="<?php echo $data['element_type']; ?>">
                                            <?php if (isset($settings->dsscalefont)) { ?>
                                                <span class="dssettings-parent">
                                                    <input type="text" class="ds-fontpick" name="font_settings[]" value='<?php echo $data['font_settings']; ?>'>
                                                </span>
                                                <?php
                                            }
                                        } elseif ($data['element_name'] == "Bio") {
                                            ?>
                                            <input type="text" placeholder="<?php echo $settings->dsdefaultcontent; ?>" value="<?php echo isset($user_info->biography) && $user_info->biography != "" ? $user_info->biography : ''; ?>" maxlength="<?php echo $settings->dsmaxchars; ?>" class="form-control element_type" <?php echo $readonly; ?> data-element_type="<?php echo $data['element_type']; ?>">
                                            <?php if (isset($settings->dsscalefont)) { ?>
                                                <span class="dssettings-parent">
                                                    <input type="text" class="ds-fontpick" name="font_settings[]" value='<?php echo $data['font_settings']; ?>'>
                                                </span>
                                                <?php
                                            }
                                        } else {
                                            ?>
                                            <input type="text" placeholder="<?php echo $settings->dsdefaultcontent; ?>" value="" maxlength="200" class="form-control element_type" <?php echo $readonly; ?> data-element_type="<?php echo $data['element_type']; ?>">
                                            <?php if (isset($settings->dsscalefont)) { ?>
                                                <span class="dssettings-parent">
                                                    <input type="text" class="ds-fontpick" name="font_settings[]" value='<?php echo $data['font_settings']; ?>'>
                                                </span>
                                                <?php
                                            }
                                        }
                                        ?>



                                        <?php
                                    } elseif ($data['element_type'] == 5) {
                                        ?>
                                        <input type="hidden" placeholder="<?php echo $settings->dsdefaultcontent; ?>" value="<?php echo $settings->dsdefaultcontent; ?>" maxlength="200" class="form-control element_type" <?php echo $readonly; ?> data-element_type="<?php echo $data['element_type']; ?>">
                                        <?php
                                    } elseif ($data['element_type'] == 6) {
                                        ?>
                                        <input type="hidden" placeholder="<?php echo $settings->dsdefaultcontent; ?>" value="<?php echo $settings->dsdefaultcontent; ?>" maxlength="200" class="form-control element_type" <?php echo $readonly; ?> data-element_type="<?php echo $data['element_type']; ?>">
                                        <?php
                                    } elseif ($data['element_type'] == 1) {
                                        ?>
                                        <form action="<?php echo TEMPLATE_URL . 'custom_template_file_upload'; ?>"  method="post" enctype="multipart/form-data">

                                            <div class="input-group">
                                                <input type="text" class="form-control " readonly placeholder="Browse">
                                                <span class="input-group-btn">
                                                    <span class="btn btn-primary btn-file">
                                                        Upload <input type="file" class="element_image" multiple name="FileInput">
                                                    </span>
                                                </span>

                                            </div>

                                            <?php /* ?><input type="file" name="FileInput" class="form-control element_image"><?php */ ?>

                                        </form>
                                    <?php } elseif ($data['element_type'] == 3) { ?>
                                        <textarea placeholder="<?php echo ucwords($settings->dsdefaultcontent); ?>" maxlength="200" class="form-control element_type" <?php echo $readonly; ?> data-element_type="<?php echo $data['element_type']; ?>" data-bullet_type="<?php echo $settings->dsbullettype; ?>"><?php echo ucwords($settings->dsdefaultcontent); ?></textarea>
                                        <?php if (isset($settings->dsscalefont)) { ?>
                                            <span class="dssettings-parent">
                                                <input type="text" class="ds-fontpick" name="font_settings[]" value='<?php echo $data['font_settings']; ?>'>
                                            </span>
                                        <?php } ?>
                                    <?php } ?>

                                </div>
                                <?php
                            }
                        }
						}
                        ?>

                        <form action="<?php echo TEMPLATE_URL . 'download_file' ?>" method="post" id="tmp_frm">
                        <div class="row">
                            <div class="col-sm-12">
                                <label class="control-label" for="email">Save File Version As:</label>
                            </div>
                            <div class="col-sm-12">
                                <select id="filetype" class="chosen-select form-control">
                                    <option value="jpeg">JPEG</option>
                                    <option value="png">PNG</option>
                                    <option value="pdf">PDF</option>

                                </select>
                                <!--                                           	<div class="checkbox-inline">
                                                                                <label><input type="radio" class="flat" checked="checked"> PDF</label>
                                                                              </div> <div class="checkbox-inline">
                                                                                <label><input type="radio" class="flat" > JPG</label>
                                                                              </div> <div class="checkbox-inline">
                                                                                <label><input type="radio" class="flat" checked="checked"> PNG</label>
                                                                              </div>-->
                            </div>
                            <div class="col-sm-12">
                                <a href="javascript:void(0);" id="download" class="btn btn-primary">SAVE FILE</a>
                                <input type="hidden" name="dwnlink" id="dwnlink">
                                <input type="hidden" name="template_id" id="template_id" value="<?php echo $template_data[0]->id;?>">
                                <input type="hidden" name="origfilename" id="origfilename" value="<?php echo $template_data[0]->template_name;?>">
                            </div>
                        </div>
                            </form>
                    </div>
               
                <!--                <div class="template_info">
                                        <h4>Template Design 1</h4>
                                    <ul>
                                        <li>Template ID #: 4321</li>
                                        <li>Type: Flyer	</li>
                                        <li>Size: 8.5x11�? (2550x3300 pixels)</li>
                                        <li>Bleed: OFF	Resolution: 300 DPI	</li>
                                        <li>Color Mode: CMYK</li>
                                        <li>Group(s): Agent Group 1, Agent Group 3</li>
                                    </ul>
                                    <h4>Description:</h4>
                                    <ul>
                                        <li>This is a description that is entered when this
                template was created. HTML is usable here.</li>
                                    </ul>
                                    <h4>Change History:</h4>
                                    <ul>
                                        <li>01/25/16 - by First Lastname</li>
                                        <li>02/09/16 - by First Lastname</li>
                                    </ul>
                                </div>-->
            </div>
            <?php
        } else {
            echo "<div class='col-md-12'><p class='alert alert-danger text-left'>Template not found or deleted.</p></div>";
        }
        ?>
    </div>
</div>
<div class="modal fade" id="image_edit_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Edit Image</h4>
            </div>
            <div class="modal-body">
                <!--                <div style="border:1px solid #000;" id="edit_image"></div>-->
                <div style="border:1px solid #000; margin-top: 10px;" id="edit_image1"></div>
                <!--                Rotate : <div id="slider" class="pull-right" style="width:200px;"></div>-->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="apply_image_changes">Apply changes</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<div class="modal fade" id="page_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Select Page</h4>
            </div>
            <div class="modal-body">
                <div id="message_page"></div>
                <select id="select_page">

                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="apply_page_changes">Apply changes</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<div id="loading" style="position:absolute; height: 100%;width:100%;top:0;left:0;display:none;"><i class="fa fa-cog fa-spin fa-lg"></i></div>

<style>
    .canvas{
        width: <?php echo $canvaswidth_px; ?>;
        height: <?php echo $canvasheight_px; ?>;
        overflow:hidden;
        <?php if(trim($template_data[0]->background_image)!=''){ ?>
        background-image: url(<?php echo $bg_url; ?>);
        <?php } ?> 
        
        <?php if(trim($template_data[0]->background_color)!=''){ ?>
        background-color: <?php echo $template_data[0]->background_color; ?>;
        <?php } ?>    
        background-color:#ffffff;
    }
    .style_canvas{
        position: absolute;
    }
    .canvas_elements{
        position: absolute;
        cursor: pointer;
    }
    .canvas_elements.selected:after {
        content: "x";
        font-family: arial;
        color: #000;
        position: absolute;
        top:0;right:0;
    }
    .canvas_elements.selected{
        border: 1px dotted #333;
    }
    
    .canvas_image{
         border: 1px solid #666;
         min-height:10px;
         min-width:10px;
         overflow:hidden;
    }
    .canvas_image img{
        max-width:none;
    }
    .dssettings-parent {
        float: right;
        top: -45px;
        right: 5px;
    }
    .template_preview.stuck {
        position:fixed;
        top:0;
    }
</style>
<script>
    var dpi = <?php echo $dpi; ?>;
    var width = <?php echo $canvaswidth; ?>;
    var height = <?php echo $canvasheight; ?>;
    var zoom = 50;
    var scale_bar = zoom/100;
    var canvas = $('.canvas');
    $(function(){
	 $('[data-svg]').each(function(i,v){
            var that = $(this);
				svgText = $(v).html();
				
                $.post(SITE_URL + 'template/svgtopng', {'svg_content': svgText,'swidth': 60, 'sheight': 60}, function (res) {
				that.html('<img src="'+res+'" style="width:'+60+';height:'+60+'">');
				});
         });
	
        var $cache = $('.template_preview');
        w_stuck = $cache.width();
        //store the initial position of the element
        var vTop = $cache.offset().top - parseFloat($cache.css('margin-top').replace(/auto/, 0));
         $(window).on('resize, scroll',function (event) {
            // what the y position of the scroll is
            var y = $(this).scrollTop();

            // whether that's below the form
            if (y >= vTop && window.innerWidth >= 767) {
            // if so, ad the fixed class
            $cache.addClass('stuck');
            $cache.css('width', w_stuck+'px');
            } else {
            // otherwise remove it
            $cache.removeClass('stuck');
            $cache.css('width', 'auto');
            }
        }).resize(function(){
            w_stuck = $cache.width();
        });
        
     //   canvas.css('zoom', zoom+'%' );
        canvas.css('transform-origin', 'top left' );
        canvas.css('transform', ' scale('+zoom/100+')' );
        $( "#slider" ).slider({
		animate: true,
            range: "min",
         min: 10,
         max:100,
         step:2,
         value: zoom,
            slide: function( event, ui ) {
                canvas.css('zoom', ui.value+'%' );
                canvas.css('transform', ' scale('+ui.value/100+')' );
                newScale = ui.value/100;
                var height = canvas.height()/scale_bar*newScale;
                var width = canvas.width()/scale_bar*newScale;
                scale_bar = newScale;
            }
        });
        //image croping customized
        function setImage(source,url){
            var img = $('<img>');
            var img_container1 = $('#edit_image');
            img_container1.html('');
            var img_container = $('[data-layer="'+source+'"]');
            img.attr('src',url);
            //img_container.html(img);
            
            var div_inner = $('<div></div>');
            var div_outer = $('<div></div>');
            div_outer.css('position','absolute');
            div_outer.css('top','15px');
            div_outer.css('outline-color','red');
            div_outer.css('outline-style','dashed');
            
            div_outer.html(div_inner);
            
            var maskWidth  = img_container.width();
            var maskHeight = img_container.height();
            img_container1.css('height',maskHeight+'px');
            img_container1.css('width',maskWidth+'px');
            img_container1.css('overflow','hidden');
            img_container1.css('position','relative');
            img.css('height',maskHeight+'px');
            img.css('width',maskWidth+'px');
            img.css('position','absolute');
            div_inner.css('height',maskHeight+'px');
            div_inner.css('width',maskWidth+'px');
            $('#apply_image_changes').unbind('click');
            $('#apply_image_changes').bind('click',function(){
                img_container.html(img);
                img_container.css('border','none');
                $('#image_edit_modal').modal('hide');
            })
            img_container1.html(img);
            img_container1.after(div_outer);
            //                        $( "#slider" ).slider({
            //                        min: 0,
            //                        max:360,
            //                        step:1,
            //                        value: 0,
            //                            slide: function( event, ui ) {
            //                                img.css({
            //                                    transform: 'rotate(' + ui.value + 'deg)'
            //                                });
            //                                div_outer.css({
            //                                    transform: 'rotate(' + ui.value + 'deg)'
            //                                });
            //                                div_inner.css({
            //                                    transform: 'rotate(' + ui.value + 'deg)'
            //                                });
            //                            }
            //                        });
            $('#image_edit_modal').modal('show');
            
            $('#image_edit_modal').on('hidden.bs.modal',function(){
                div_inner.remove();
                div_outer.remove();
                img_container1.html('');
            })
            $('#image_edit_modal').on('shown.bs.modal',function(){
                div_outer.draggable({
                    //containment:'body',
                    drag: function(){
                        var offset = $(this).offset();
                        var xPos = offset.left;
                        var yPos = offset.top;
                        img.css('left',xPos-img_container1.offset().left+'px');
                        img.css('top',yPos-img_container1.offset().top+'px');
                    }
                });
                div_inner.resizable({
                    handles: 'n, e, s, w, ne, se, sw, nw',
                    resize: function(event, ui) {
                        var width = ui.size.width;
                        var height = ui.size.height;
                        img.css('width',width+'px');
                        img.css('height',height+'px');
                    }
                });
                div_inner.css({cursor: 'move'});
            });
        }
        //image croping from image area select jquery
        function setImage1(source,url,org_name,input){
            
            url = SITE_URL + 'assets/upload/templates/'+url;
            var img_x = $('<img data-imgid="'+source+'">');
            var img1 = $('<img data-imgid1="'+source+'">');
            var active_crop = false;
            var img_container = $('[data-layer="'+source+'"]');
            var img_container1 = $('#edit_image');
            var img_container2 = $('#edit_image1');
            img_container1.html('');
            img_container2.html('');
            
            img_x.attr('src',url);
            img1.attr('src',url);
            
            var maskWidth  = img_container.width();
            var maskHeight = img_container.height();
            img_container1.css('height',maskHeight+'px');
            img_container1.css('width',maskWidth+'px');
            img1.css('width','568px');
            img_container1.css('overflow','hidden');
            img_container1.css('position','relative');
            
            img_x.css('position','absolute');
            
            $('#apply_image_changes').unbind('click');
            $('#apply_image_changes').bind('click',function(){
                active_crop= false;
                img_container.html(img_x);
                img_container.css('border','none');
                img_container.css('text-align','left');
                $('#image_edit_modal').modal('hide');
                input.val(org_name);
            })
            img_container1.html(img_x);
            img_container2.html(img1);
            $('#image_edit_modal').modal('show');
            
            $('#image_edit_modal').unbind('hidden.bs.modal').on('hidden.bs.modal',function(){
                img_container1.html('');
                $('[class*=imgareaselect]').remove();
            })
            $('#image_edit_modal').unbind('shown.bs.modal').on('shown.bs.modal',function(){
                
                var scaleX = maskWidth / (maskWidth || 1);
                var scaleY = maskHeight / (maskHeight || 1);

                img_x.css({
                    width: Math.round(scaleX * img1.width()) + 'px',
                    height: Math.round(scaleY * img1.height()) + 'px',
                    marginLeft: '-' + Math.round(scaleX * 0) + 'px',
                    marginTop: '-' + Math.round(scaleY * 0) + 'px'
                });

                active_crop = true;
                img1.imgAreaSelect({
                    handles: true,
                    aspectRatio: maskWidth+':'+maskHeight,
                    x1: 0, y1: 0, x2: maskWidth, y2: maskHeight,
                    onSelectChange: function(img_test, selection){
                        if(!active_crop)return false;
                        scaleX = maskWidth / (selection.width || maskWidth);
                        scaleY = maskHeight / (selection.height || maskHeight);
                        
                        img_x.css({
                            width: Math.round(scaleX * img1.width()) + 'px',
                            height: Math.round(scaleY * img1.height()) + 'px',
                            marginLeft: '-' + Math.round(scaleX * selection.x1) + 'px',
                            marginTop: '-' + Math.round(scaleY * selection.y1) + 'px'
                        });
                    }
                });
            });
        }
        //load image at client size
        function readURL(input,source) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                
                reader.onload = function (e) {
                    setImage(source, e.target.result);
                }
                
                reader.readAsDataURL(input.files[0]);
            }
        }
        function afterSuccess()
        {
            readURL(this,source);
            $('#submit-btn').show(); //hide submit button
            $('#loading-img').hide(); //hide submit button
            $('#progressbox').delay( 1000 ).fadeOut(); //hide progress bar
            
        }
        $(".element_image").change(function(){
             var input = $(this).parents('.input-group').find(':text');
            var that = $(this).parents('form');
            var source = $(this).parents('[data-source]').data('source');
            //readURL(this,source);
            var options = { 
                //			target:   '#output',   // target element(s) to be updated with server response 
                //			beforeSubmit:  beforeSubmit,  // pre-submit callback 
                success:       function(data){
                    data = JSON.parse(data);
                    if(data.status){
                       
                        setImage1(source, data.file,data.original_name,input);
                    }else{
                        $('#errormsg').text(data.msg);
                        $('#errormsg').removeClass('hide');
                        //alert(data.msg);
                    }
                },  // post-submit callback 
                //			uploadProgress: OnProgress, //upload progress callback 
                resetForm: true        // reset the form after successful submit 
            }; 
            that.ajaxSubmit(options);  
            return false;
        });
        
        $('.element_type').on('keyup change', function(){
            var source = $(this).parents('[data-source]').data('source');
            var element_type=$(this).data('element_type');
            if(element_type==2){
                $('[data-layer="'+source+'"] span').html($(this).val());
            }else if(element_type==3){
                var dsbullettype = $(this).data('bullet_type');
                var content = $(this).val();
                var li_html = '';
                content = content.replace(/\r?\n/g, '-___-');
                var res = content.split('-___-');
                var content = '<ul class="nobullet">';
                if(dsbullettype=='1' || dsbullettype==1){
                    var num = 1;
                }else if(dsbullettype=='disc'){
                    var num = '&bull;';
                }else if(dsbullettype=='circle'){
                    var num = '&#9900;';
                }else if(dsbullettype=='square'){
                    var num = '&#9755;';
                }else{
                    var num = '&bull;';
                }
                
                $.each(res,function(i,v){
                    if(dsbullettype=='1' || dsbullettype==1){
                        content += '<li><span class="dsbullet">'+num+'.</span> '+v+'</li>';
                        num++;
                    }else{
                        content += '<li><span class="dsbullet">'+num+'</span> '+v+'</li>';
                    }
                })
                content += '</ui>';
                $('[data-layer="'+source+'"] span').html(content);
            }
        })
        $('#download').on('click', function(){
            
            var link = $('<a id="dwnld"></a>');
            var clone = $( ".canvas" ).clone();
            clone.css('zoom','100%');
            clone.css('transform-origin', 'top left' );
            clone.css('transform', ' scale(1)' );
            //            clone.css('top','-1000px');
            //    clone.css('position','absolute');
            clone.children('.canvas_image').each(function(i,v){
                if($(this).children('img').length==0){
                    $(this).remove();
                }else{
                    $(this).css('border','none');
                }
            });
            clone.children('.canvas_text').each(function(i,v){
                var source = $(this).data('layer');
                if(source=='bullets'){
                    if(($.trim($('[data-source="'+source+'"]').find('textarea').val())=='' && $('[data-source="'+source+'"]').length!=0)){
                    $(this).remove();
                }
                }else {
                if(($.trim($('[data-source="'+source+'"]').find('input').val())=='' && $('[data-source="'+source+'"]').length!=0)){
                    $(this).remove();
                }
            }
                
            });
            clone.appendTo( "body");
            link.appendTo( "body");
            
            html2canvas(clone, {
                onrendered: function(canvas) {
                    var theCanvas = canvas;
					
                    document.body.appendChild(canvas);
                    clone.remove();
                    var filetype = $('#filetype').val();
                    if (filetype == 'jpeg') {
                        var link = document.getElementById('dwnld');
//                        link.href = theCanvas.toDataURL("image/jpeg", 1.0);
//                        link.download = 'image.jpeg';
//                        link.click();
//                        theCanvas.remove();
//                        link.remove();
//                        return false;
                        // var imgData = theCanvas.toDataURL("image/jpeg", 1.0);
						// theCanvas.remove();
                        // var strDataURI = imgData.substr(22, imgData.length);
                        // var blob = dataURLtoBlob(imgData);
                        // var objurl = URL.createObjectURL(blob);
                        // link.download = "image.jpeg";

                        // link.href = objurl;

                        // link.click();
                        
                        // link.remove();
						var imgData = theCanvas.toDataURL("image/jpeg", 1.0);
						$('#dwnlink').val(imgData);
						$('#tmp_frm').submit();
						  theCanvas.remove();
                    }
                    if (filetype == 'png') {
                        var link = document.getElementById('dwnld');
                        var imgData = theCanvas.toDataURL("image/png");
						$('#dwnlink').val(imgData);
						$('#tmp_frm').submit();
						 theCanvas.remove();
                    }
                    if(filetype=='gif'){
                        var link = document.getElementById('dwnld');
                        link.href = theCanvas.toDataURL("image/gif");
                        link.download = 'image.gif';
                        link.click();
                        theCanvas.remove();
                        link.remove();
                    }
                    if(filetype=='pdf'){
                        
                        var imgData = theCanvas.toDataURL("image/jpeg", 1.0);
//                        var pdf = new jsPDF('l', 'in', [width, height]);
var orientation = 'p';
if(width>height)orientation = 'l';
var pdf = new jsPDF(orientation, 'in', [width, height]);
//                        console.log(width+'-'+height);
                        pdf.addImage(imgData, 'JPEG', 0, 0, width, height);
                        var download = document.getElementById('dwnld');
                        
                        pdf.save("download.pdf");
                        
                        theCanvas.remove();
                    }
                    
                }
            });
        });
         if (!('remove' in Element.prototype)) {
    Element.prototype.remove = function() {
        if (this.parentNode) {
            this.parentNode.removeChild(this);
        }
    };
} 
        var romanize = function(userNumber) {
        var rome = [];
        for (var i = 0; i <= userNumber; i++) {
            if (userNumber >= 5) {
            rome.push("V");
            userNumber = (userNumber % 5);
            } else if (userNumber === 4) {
            return "IV";
            } else if (userNumber <= 3) {
            rome.push("I");
            }
        }
        return rome
        };
        
        
        $(document).on('change','.ds-fontpick',function(){
            var font_settings = $(this).val();
            var obj = JSON.parse(font_settings);
            var source = $(this).parents('[data-source]').data('source');
            $('[data-layer="'+source+'"]').css('font-size', (obj.dsfontsize*dpi/72)+'px');
            $('[data-layer="'+source+'"]').css('text-align', obj.dsalign);
            if(typeof obj.dsfont != 'undefined'){
                var font = obj.dsfont;
                $('[data-layer="'+source+'"]').css('font-family', font.replace(/\+/g,' '));
            }
            if(typeof obj.dstextheight != 'undefined'){
                var dstextheight = obj.dstextheight;
                $('[data-layer="'+source+'"] span').css('line-height', dstextheight+'px');
            }
            if(typeof obj.dstextwidth != 'undefined'){
                var dstextwidth = obj.dstextwidth;
                $('[data-layer="'+source+'"] span').css('letter-spacing', dstextwidth+'px');
            }
            if(typeof obj.dsbold != 'undefined'){
                $('[data-layer="'+source+'"] span').css('font-weight', 'bold');
            }else{
                $('[data-layer="'+source+'"] span').css('font-weight', 'normal');
            }
            if(typeof obj.dsunderline != 'undefined'){
                $('[data-layer="'+source+'"] span').css('text-decoration', 'underline');
            }else{
                $('[data-layer="'+source+'"] span').css('text-decoration', 'none');
            }
            if(typeof obj.dsstrikethrough != 'undefined'){
                $('[data-layer="'+source+'"]').css('text-decoration', 'line-through');
            }else{
                $('[data-layer="'+source+'"]').css('text-decoration', 'none');
            }
            if(typeof obj.dsitalic != 'undefined'){
                $('[data-layer="'+source+'"]').css('font-style', 'italic');
            }else{
                $('[data-layer="'+source+'"]').css('font-style', 'normal');
            }
            //font streching
            var dstexthstrech = 1, dstextvstrech=1;
            if(typeof obj.dstextvstrech != 'undefined'){
                if(obj.dstextvstrech>=1)dstextvstrech = obj.dstextvstrech;
            }
            if(typeof obj.dstexthstrech != 'undefined'){
                if(obj.dstexthstrech>=1)dstexthstrech = obj.dstexthstrech;
            }
            var trans = 'scale('+dstexthstrech+','+dstextvstrech+')';
            $('[data-layer="'+source+'"] span').css('display', 'block');
           //$('[data-layer="'+source+'"] span').css('text-align', 'center');
            $('[data-layer="'+source+'"] span').css('transform', trans);
            $('[data-layer="'+source+'"] span').css('-webkit-transform', trans);
        })
    });
	  function dataURLtoBlob(dataurl) {
    var arr = dataurl.split(','), mime = arr[0].match(/:(.*?);/)[1],
        bstr = atob(arr[1]), n = bstr.length, u8arr = new Uint8Array(n);
    while(n--){
        u8arr[n] = bstr.charCodeAt(n);
    }
    return new Blob([u8arr], {type:mime});
}
      $(document).ready(function(){
	
      $(".chosen-search").hide();
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
	
	
  // jQuery(document).ajaxStart(function () {
   		// show ajax indicator
		// ajaxindicatorstart('Updating data.. please wait..');
  // }).ajaxStop(function () {
		// hide ajax indicator
		// ajaxindicatorstop();
  // });
</script>
    