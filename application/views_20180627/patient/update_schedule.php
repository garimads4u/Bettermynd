<div class="modal-body">
    <div class="form-group">
        <input type="hidden" id="provider_id" name="provider_id" value="<?php echo $provider_id; ?>" />
        <input type="hidden" name="avail_id" id="avail_id" value="<?php echo $avail_info->avail_id; ?>" />
        <label class="control-label col-md-3"><strong>Start Date</strong></label>
        <label class="control-label"><?php echo show_dateTime($avail_info->start_date . " " . $avail_info->start_time); ?></label>
    </div>
    <div class="form-group">
        <label class="control-label col-md-3"><strong>End Date</strong></label>
        <label class="control-label"><?php echo show_dateTime($avail_info->end_date . " " . $avail_info->end_time); ?></label>
    </div>
    <div class="clearfix"></div>
    <?php if (isset($provider_info)) {
        ?>
        <div class="form-group">
            <label class="control-label col-md-3"><strong>Provider Name</strong> </label>
            <label class="control-label"><?php echo $provider_info->first_name . " " . $provider_info->last_name; ?></label>
            <input type="hidden" name="patient_id" id="patient_id" value="<?php echo $provider_info->user_id; ?>" />
        </div>

        <?php
    }
    ?>
    <?php if (isset($app_status)) {
        ?>
        <div class="form-group">
            <label class="control-label col-md-3"><strong>Status</strong> </label>
            <label class="control-label"><?php echo $app_status == 2 ? 'Canceled' : 'Confirmed'; ?></label>
            <input type="hidden" name="patient_id" id="patient_id" value="<?php echo $patient_id; ?>" />
        </div>

        <?php
    }
    $start_datetime = $this->basic_model->change_utc_datetime($avail_info->start_date . ' ' . $avail_info->start_time);
    $end_datetime = $this->basic_model->change_utc_datetime($avail_info->end_date . ' ' . $avail_info->end_time);
    $is_start_meeting = 'NO';
    if (date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . " + 15 minutes")) >= $start_datetime && date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . " - 15 minutes")) <= $end_datetime) {
        $is_start_meeting = 'YES';
    }
    if (isset($app_id) && isset($app_status) && $app_status == 1 && $is_start_meeting == 'NO' && $start_datetime >= date('Y-m-d H:i:s')) {
        ?>
        <div class="form-group">
            <span class="red">*Please note that you will be able to enter your session 15-minutes prior to your scheduled appointment time.</span>
        </div>
    <?php }
    ?>
    <div class="clearfix"></div>
</div>
<div class="modal-footer">
    <input type="hidden" value="appointment" name="ttype" id="ttype" />
    <input type="hidden" name="app_id" id="app_id" value="<?php echo $app_id; ?>" />
    <?php
    if ($is_start_meeting == 'YES') {
        ?>
        <a href="<?php echo base_url('patient/joinappointment/' . base64_encode($app_id)); ?>" target="_blank" class="btn btn-success" id="btnfinal"><i class="fa fa-play"></i> Start Meeting</a>
        <?php
    }
    if (isset($app_id) && isset($app_status) && $app_status == 1 && $start_datetime >= date('Y-m-d H:i:s')) {
        ?>

        <?php $before_24_hours = strtotime($start_datetime . "-1 days"); ?>
        <input type="hidden" name="refund_time_limit" id="refund_time_limit" value="<?php echo $before_24_hours; ?>" />
        <button type="submit" class="btn btn-danger" id="btnfinal" onclick="
                    if (confirm('Are you sure you want to cancel this appointment? '))
                        return true;
                    else
                        return false;
                "><i class="fa fa-times"></i> Cancel Appointment</button>

    <?php }
    ?>
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>

<!--
<div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success" id="btnfinal">Save</button>
        </div>

-->