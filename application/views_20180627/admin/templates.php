<div class="col-md-12 col-sm-12 col-xs-12">
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
  <div class="sections-head">TEMPLATES</div>
  <div class="x_panel">
    <div class="x_content">
      <table id="datatable" class="table table-striped table-bordered">
        <thead>
          <tr>
            <th>Title</th>
            <th>Type</th>
            <th>Size</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php
                    //   prd($template_list);
                    if (isset($template_list) && count($template_list) > 0 && !empty($template_list)) {
                        foreach ($template_list as $value) {
                            if ($value->source == '1') {
                                            $page_video = 'user_edit_video_template';
                                            $page = 'admin_edit_template';
                                            $edit = 'custom_template';
                                            $tid = $this->encrypt->encode($value->id);
                                            $tid = str_replace(array('+', '/', '='), array('-', '_', '~'), $tid);
                                        } else {
                                            $page_video = 'user_edit_video_template';
                                            $page = 'admin_design_template';
                                            $edit = 'design_template';
                                            $tid = $this->encrypt->encode($value->id);
                                            $tid = str_replace(array('+', '/', '='), array('-', '_', '~'), $tid);
                                        }
										if ($value->is_publish == '0') {
                                              if($value->video=='') {
                                            $edit_url = TEMPLATE_URL . $edit . "/" . $tid;
                                            }
                                            else{
                                            $edit_url = TEMPLATE_URL . 'video' . "/" . $tid;    
                                            }
                                            
                                            $edit_label = "label-danger";

                                            $personalize_url = "javascript:void();";
                                            $personalize_label = "label-gray hide";
                                        } else {
                                            $edit_url = "javascript:void();";
                                            $edit_label = "label-gray hide";

                                            $personalize_url = TEMPLATE_URL . $page . '/' . $tid;
                                            $personalize_label = "label-success";
                                        }
							if($value->video=='') {
                                            $edit_url = TEMPLATE_URL . $edit . "/" . $tid;
                                            }
                                            else{
                                            $edit_url = TEMPLATE_URL . 'video' . "/" . $tid;    
                                            }
											echo "<tr>"
											. "<td>" . $value->title . "</td>"
											. "<td>" . ($value->t_category == '2' ? 'Banner Ads' : $value->t_type) . "</td>"
											. "<td>" . ($value->width . ' x ' . $value->height . ' px') . "</td>";
											if($value->t_type=="VIDEO"){
												  echo  "<td><a href=" . TEMPLATE_URL . $page_video . '/' . $tid . " class='label label-success'>PERSONALIZE</a>";
											echo " <a  href='" . $edit_url . "' class='label " . $edit_label . "'>EDIT</a></td>";
											}
											else{
										   echo  "<td><a href=" . TEMPLATE_URL . $page . '/' . $tid . " class='label label-success'>PERSONALIZE</a>";
										   echo " <a  href='" . $edit_url . "' class='label " . $edit_label . "'>EDIT</a>";
											}
											echo "</tr>";
                        }
                    }
                    ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
