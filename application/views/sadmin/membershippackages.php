<div class="col-md-12 col-sm-12 col-xs-12">
    <?php if (isset($edit_data) && !empty($edit_data) && count($edit_data) > 0) {
        ?>
        <div class="x_panel">
            <div class="x_content">
                <?php
                $attributes = array('id' => 'plan_form', 'class' => 'myprofile form-horizontal', 'enctype' => 'multipart/form-data');
                echo form_open(SADMIN_URL . "update_package", $attributes);
                ?>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <?php echo lang('member_package_amount_label', 'package_amount'); ?>
                            <?php echo form_input($package_amount); ?>
                            <?php echo form_input($edit_id); ?>
                        </div>
                    </div>
                    <Div class="clearfix"></Div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <?php echo lang('member_package_mode_label', 'package_mode'); ?><br/>
                            <input type="radio" name="membership_package[]" id="membership_package1" value="COMPANY" <?php if ($edit_data[0]->account_type == "COMPANY") { ?> checked="checked"<?php } ?>/>&nbsp;<label for="membership_package1">Company</label>
                            &nbsp;
                            <input type="radio" name="membership_package[]" id="membership_package2" value="USER" <?php if ($edit_data[0]->account_type == "USER") { ?> checked="checked"<?php } ?>/>&nbsp;<label for="membership_package2">User</label>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <?php echo lang('member_package_account_label', 'package_mode'); ?><br/>
                            <input type="radio" name="package_mode[]" id="package_mode1" value="MONTHLY" <?php if ($edit_data[0]->package_mode == "MONTHLY") { ?> checked="checked"<?php } ?>/>&nbsp;<label  for="package_mode1" >Monthly</label>
                            &nbsp;
                            <input type="radio" name="package_mode[]" id="package_mode2" value="ANNUALLY" <?php if ($edit_data[0]->package_mode == "ANNUALLY") { ?> checked="checked"<?php } ?>/>&nbsp;<label  for="package_mode2">Annually</label>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="register-buttons">
                        <?php echo form_submit('submit', lang('update_member_package_button'), array("class" => "btn btn-primary")); ?>
                        <?php
                        echo "<a href='" . SADMIN_URL . "membershippackages' class='btn btn-default'> Cancel </a>";
                        ?>
                    </div>
                </div>
                <?php echo form_close(); ?> </div>
        </div>
        <?php
    }
    ?>
    <ul class="nav nav-tabs">
        <li class="<?php
        if ($active_tab == "C" || !$active_tab) {
            echo "active";
        }
        ?>"><a data-toggle="tab" href="#home">Company </a></li>
        <li class="<?php
        if (isset($active_tab) && $active_tab == "U") {
            echo "active";
        }
        ?>"><a data-toggle="tab" href="#menu1">Users</a></li>
    </ul>
    <div class="tab-content">
        <div id="home" class="tab-pane fade in <?php
        if ($active_tab == "C" || !$active_tab) {
            echo "active";
        }
        ?>">
            <div class="x_panel">
                <div class="x_content">
                    <table id="datatable" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Amount</th>
                                <th>Created On</th>
                                <th>Type</th>
                                <!--<th>Status</th>-->
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <?php if (isset($membership_plans) && !empty($membership_plans) && count($membership_plans) > 0) {
                            ?>
                            <tbody>
                                <?php
                                foreach ($membership_plans as $plan) {
                                    if ($plan->account_type == "COMPANY") {
                                        if ($plan->package_status == "1") {
                                            $checked = "checked='checked'";
                                        } else {
                                            $checked = '';
                                        }
                                        if ($plan->package_status == "1") {
                                            $status = "DeActivate";
                                        } else {
                                            $status = "Activate";
                                        }
                                        ?>
                                        <tr>
                                            <td><?php echo $plan->package_amount; ?></td>
                                            <td><?php echo date(DATE_FORMAT, strtotime($plan->package_adddate)); ?></td>
                                            <td><?php echo $plan->package_mode; ?></td>
                                          <?php /*?>  <td><div id='toggle_over'>
                                                    <input type='checkbox' <?php echo $checked; ?> name='teplate_status_<?php echo $plan->package_id; ?>' data-id="<?php echo $plan->package_id; ?>" data-status='<?php echo $status; ?>' class='ios-toggle  package_status' value='<?php $plan->package_id; ?>' id='<?php echo $plan->package_id; ?>'  data-pltype="<?php echo $plan->account_type; ?>"/>
                                                    <label for='<?php echo $plan->package_id; ?>' class='checkbox-label'></label>
                                                </div></td><?php */?>
                                            <td><a href="<?php echo SADMIN_URL; ?>membershippackages/<?php echo ($plan->package_id); ?>" class="label label-danger">EDIT</a></td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                            </tbody>
                            <?php
                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>
        <div id="menu1" class="tab-pane fade <?php
        if (isset($active_tab) && $active_tab == "U") {
            echo " in active";
        }
        ?>">
            <div class="x_panel">
                <div class="x_content">
                    <table id="datatable1" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Amount</th>
                                <th>Created On</th>
                                <th>Type</th>
                               <!-- <th>Status</th>-->
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <?php if (isset($membership_plans) && !empty($membership_plans) && count($membership_plans) > 0) {
                            ?>
                            <tbody>
                                <?php
                                foreach ($membership_plans as $plan) {
                                    if ($plan->account_type != "COMPANY") {
                                        if ($plan->package_status == "1") {
                                            $checked = "checked='checked'";
                                        } else {
                                            $checked = '';
                                        }
                                        if ($plan->package_status == "1") {
                                            $status = "DeActivate";
                                        } else {
                                            $status = "Activate";
                                        }
                                        ?>
                                        <tr>
                                            <td><?php echo $plan->package_amount; ?></td>
                                            <td><?php echo date(DATE_FORMAT, strtotime($plan->package_adddate)); ?></td>
                                            <td><?php echo $plan->package_mode; ?></td>
                                          <?php /*?>  <td><div id='toggle_over'>
                                                    <input type='checkbox' <?php echo $checked; ?> name='teplate_status_<?php echo $plan->package_id; ?>' data-id="<?php echo $plan->package_id; ?>" data-status='<?php echo $status; ?>' class='ios-toggle  package_status' value='<?php $plan->package_id; ?>' data-pltype="<?php echo $plan->account_type; ?>" id='<?php echo $plan->package_id; ?>'/>
                                                    <label for='<?php echo $plan->package_id; ?>' class='checkbox-label'></label>
                                                </div></td><?php */?>
                                            <td><a href="<?php echo SADMIN_URL; ?>membershippackages/<?php echo ($plan->package_id); ?>" class="label label-danger">EDIT</a></td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                            </tbody>
                            <?php
                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>