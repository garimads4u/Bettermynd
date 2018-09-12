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
    <?php if (isset($patient_info)) {
        ?>
        <div class="form-group">
            <label class="control-label col-md-3"><strong>Student Name</strong> </label>
            <label class="control-label"><?php echo $patient_info->first_name . " " . $patient_info->last_name; ?></label>
            <input type="hidden" name="patient_id" id="patient_id" value="<?php echo $patient_info->user_id; ?>" />
            <input type="hidden" name="app_id" id="app_id" value="<?php echo $app_id; ?>" />
        </div>

        <?php
    }
    ?>
    <div class="clearfix"></div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    <?php
    $start_datetime = $this->basic_model->change_utc_datetime($avail_info->start_date . ' ' . $avail_info->start_time);
    $end_datetime = $this->basic_model->change_utc_datetime($avail_info->end_date . ' ' . $avail_info->end_time);

    if (!isset($patient_info)) {
        if ($start_datetime >= date('Y-m-d H:i:s')) {
            ?>
            <input type="hidden" value="schedule" name="ttype" id="ttype" />
            <button type="submit" class="btn btn-danger" id="btnfinal"><i class="fa fa-times"></i> Remove Schedule</button>
            <?php
        }
    } else if ($start_datetime >= date('Y-m-d H:i:s')) {
        ?>
        <input type="hidden" value="appointment" name="ttype" id="ttype" />
        <button type="submit" class="btn btn-danger" id="btnfinal" onclick="
                    if (confirm('Are you sure you want to cancel this appointment? '))
                        return true;
                    else
                        return false;
                "><i class="fa fa-times"></i> Cancel Appointment</button>
        <?php
    }
    ?>
</div>

<!--
<div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success" id="btnfinal">Save</button>
        </div>

-->