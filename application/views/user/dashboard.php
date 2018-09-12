<div class="col-md-12 col-sm-12 col-xs-12">
    <div id="infoMessage"><?php if (isset($message)) {
   ?><p class="alert alert-success text-left"><?php
            echo $message;
            ?></p><?php }
        ?>
        <?php if (isset($error)) {
            ?><p class="alert alert-danger text-left"><?php
                echo $error;
                ?></p><?php }
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
                                $page = 'user_edit_template';								
                                $tid = $this->encrypt->encode($value->id);
                                $tid = str_replace(array('+', '/', '='), array('-', '_', '~'), $tid);
                            } else {
                                $page = 'user_design_template';
				$page_video = 'user_edit_video_template';
                                $tid = $this->encrypt->encode($value->id);
                                $tid = str_replace(array('+', '/', '='), array('-', '_', '~'), $tid);
                            }
							if($value->is_publish=="0" && $value->video!=""){
										}else{
                            echo "<tr>"
                            . "<td>" . $value->title . "</td>"
                            . "<td>" . ($value->t_category == '2' ? 'Banner Ads' : $value->t_type) . "</td>"
                            . "<td class='nowrap'>" . ($value->width . ' x ' . $value->height . ' px') . "</td>";
							if($value->t_type=="VIDEO"){
								  echo  "<td><a href=" . TEMPLATE_URL . $page_video . '/' . $tid . " class='label label-success'>PERSONALIZE</a></td>";
							}
							else{
                           echo  "<td><a href=" . TEMPLATE_URL . $page . '/' . $tid . " class='label label-success'>PERSONALIZE</a></td>";
							}
                            echo "</tr>";
										}
                        }
                    }
                    ?>

                </tbody>
            </table>
        </div>
    </div>

</div>