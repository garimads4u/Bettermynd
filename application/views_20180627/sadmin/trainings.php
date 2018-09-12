<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="sections-head">Training List</div>
    <div id="infoMessage"><?php if (isset($message)) {
   ?><p class="alert alert-success text-left"><?php
            echo strip_tags($message);
            ?></p><?php }
        ?>
        <?php if (isset($error)) {
            ?><p class="alert alert-danger text-left"><?php
                echo strip_tags($error);
                ?></p><?php }
            ?>
    </div>
    <div class="x_panel">
        <div class="row user_buttons">

            <div class="col-xs-12 text-right">
                <a href="<?php echo SADMIN_URL . 'addtraining'; ?>" class="btn btn-primary"><i class="fa fa-plus"></i>&nbsp;Add Training</a>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="x_panel">
        <div class="x_content">
            <table id="datatable" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>S.No.</th>
                        <th>Title</th>
                        <th>Status</th>
                        <th>Added</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $cnt = 1;
                    foreach ($training_steps_data as $training_steps_data) {
                        ?>
                        <tr>
                            <td><?php echo $cnt++; ?></td>
                            <td><?php echo $training_steps_data['ts_title']; ?></td>
                            <td>
                                 <?php
                                if ($training_steps_data['status'] == "1") {
                                    $checked = "checked='checked'";
                                } else {
                                    $checked = '';
                                }
                                if ($training_steps_data['status'] == "1") {
                                    $status = "DeActivate";
                                } else {
                                    $status = "Activate";
                                }
                                ?>  
                              <div id='toggle_over'><input type='checkbox' <?php echo $checked;?> name='training_status_<?php echo $training_steps_data['tstep_id'];?>' data-id="<?php echo $training_steps_data['tstep_id'];?>" id="<?php echo $training_steps_data['tstep_id'];?>" data-status='<?php echo $status;?>' class='ios-toggle  training_status' value='<?php echo $training_steps_data['tstep_id'];?>' /> <label for='<?php echo $training_steps_data['tstep_id'];?>' class='checkbox-label'></label></div>
                            </td>
                            <td>
                                <?php echo date(DATE_FORMAT, strtotime($training_steps_data['addedon'])); ?>
                            </td>
                            <td>
                                                                
                                    <!--<a title="<?php echo $title; ?>" for="<?php echo $training_steps_data['tstep_id']; ?>" href="javascript:void(0);" class="btn btn-default btn-xs changeStatus"><i class="fa fa-eye"></i></a>-->
                                <a title = "Edit" href="<?php echo SADMIN_URL; ?>addtraining/<?php echo $training_steps_data['tstep_id']; ?>" class="label label-success">Edit</a>
                                <a title = "Delete" href="javascript:void(0);" data-id="<?php echo $training_steps_data['tstep_id']; ?>" class="label label-danger deltraining">Delete</a>
    <?php ?>
                            </td>
                        </tr>
                                <?php
                            }
                            ?>
                </tbody>
            </table>
        </div>
    </div>

</div>
