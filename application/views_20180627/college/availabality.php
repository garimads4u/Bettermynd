<style type="text/css">

</style>
<div class="x_panel">
    <div class="x_content">
        <?php if (isset($error) && !empty($error)) {
            ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php
        }
        ?>
        <?php if (isset($message) && !empty($message)) {
            ?>
            <div class="alert alert-success"><?php echo $message; ?></div>
            <?php
        }
        ?>
        <div class="form-group">
            <label class="control-label">Provider : </label>
            <label class="control-label"><strong><?php echo ucwords($provider_data['first_name'] . " " . $provider_data['last_name']); ?></strong></label>
            <a href="<?php echo COLLEGE_URL; ?>provider">Change</a> </div>
        <div class="pull-left"><a  class="btn btn-primary" data-toggle="modal" data-target="#addAvailabality"><i class="fa fa-plus"></i>&nbsp;Add Availability</a></div>
        <div class="clearfix"><br/><br/><br/></div>
        <div class="card-box">
            <div id="calendars"></div>
        </div>
    </div>
</div>
<div id="addAvailabality" class="modal fade" role="dialog" data-backdrop="static">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" onclick="window.location.reload()">&times;</button>
                <h4 class="modal-title">Add Your Availability</h4>
            </div>
            <form action="<?php echo COLLEGE_URL; ?>saveavailabality" method="post" id="avail_form">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" id="provider_id" name="provider_id" value="<?php echo $provider_id; ?>" />
                        <label class="control-label">Start Date <span class="mandatory">*</span></label>
                        <div class='input-group date datetimepicke' style=" margin-bottom:0" id="start_date">
                            <input type="text" name="startdate" id="startdate" class="form-control noneditable"   />
                            <span class="input-group-addon"> <span class="glyphicon glyphicon-calendar"></span> </span> </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">End Date <span class="mandatory">*</span></label>
                        <div class='input-group date datetimepicke' style=" margin-bottom:0" id="end_date">
                            <input type="text" name="enddate" id="enddate" class="form-control noneditable"  />
                            <span class="input-group-addon"> <span class="glyphicon glyphicon-calendar"></span> </span> </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="form-group">
                        <label class="control-label">Time Slots <span class="mandatory">*</span></label>
                        <select class="form-control groups_dropdown" data-placeholder="Choose a Timeslot..." name="timeslot[]" id="timeslot" multiple="multiple">
                            <?php
                            if (isset($avail_times) && !empty($avail_times)) {
                                //echo $avail_times;
                                for ($i = 0; $i < count($avail_times); $i++) {
                                    $from = "";
                                    $to = "";
                                    $from = $avail_times[$i];
                                    if (isset($avail_times[$i + 1]) && !empty($avail_times[$i + 1])) {
                                        $to = $avail_times[$i + 1];
                                    } else {
                                        $to = $avail_times[0];
                                    }
                                    ?>
                                    <option value="<?php echo $from . '-' . $to; ?>"><?php echo $from; ?> - <?php echo $to; ?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" onclick="window.location.reload()">Close</button>
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!---->

<div id="updateModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Appointment Information</h4>
            </div>
            <form action="<?php echo COLLEGE_URL; ?>updateavailabality" method="post">
                <div id="target_body">

                </div>
            </form>
        </div>
    </div>
</div>
<!---->
<style>
    .fc-event{
        cursor: pointer;
    }
</style>
<script>
            function show_modal(avail_id, provider_id, slot_id, patient_id, app_id) {
            $.ajax({
            url: '<?php echo COLLEGE_URL . 'update_schedule' ?>',
                    data: 'avail_id=' + avail_id + "&provider_id=" + provider_id + "&slot_id=" + slot_id + "&patient_id=" + patient_id + "&app_id=" + app_id,
                    type: "POST",
                    success: function (data) {
                    $('#target_body').html(data);
                            $("#target_body .datetimepicker").datetimepicker({
                    format: 'MM/DD/YYYY',
                    });
                            $("#target_body .groups_dropdown").multiselect({nonSelectedText: 'Select A TimeSlot', numberDisplayed: 1})
                            $('#updateModal').modal('show');
                    },
                    error: function () {

                    }

            });
            }
    $(document).ready(function () {
    //		$(".groups_dropdown").chosen({});

    $('#calendars').fullCalendar({
    header: {
    left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
    },
            defaultDate:'<?php echo date('Y-m-d'); ?>',
            //			defaultDate: '2016-12-12',
            navLinks: true, // can click day/week names to navigate views
            selectable: false,
            selectHelper: true,
            editable: false,
            eventLimit: true, // allow "more" link when too many events
            timeFormat: 'h(:mm) a',
            eventClick: function (calEvent, jsEvent, view) {
            app_id = typeof calEvent.slot_id == 'undefined' ? 0 : calEvent.slot_id;
                    show_modal(calEvent.avail_id, calEvent.provider_id, calEvent.slot_id, calEvent.patient_id, app_id);
            },
            events: [
<?php
if (isset($schedules) && !empty($schedules)) {
    foreach ($schedules as $schedule) {

        $avail_check = $this->provider_model->get_slot_booking($schedule->provider_id, $schedule->avail_id);
        ?>
                    {
                    title: '<?php
        if ($avail_check) {
            echo "Booked";
        } else {
            echo "Available";
        }
        ?>',
                            start: '<?php echo $schedule->start_date . " " . $schedule->start_time; ?>',
                            end: '<?php echo $schedule->end_date . " " . $schedule->end_time; ?>',
                            avail_id:'<?php echo $schedule->avail_id; ?>',
                            provider_id:'<?php echo $schedule->provider_id; ?>',
        <?php
        if ($avail_check) {
            echo "className: 'bg-purple',slot_id: '" . $avail_check[0]['app_id'] . "',patient_id: '" . $avail_check[0]['patient_id'] . "'";
        }
        ?>
                    },
        <?php
    }
}
?>
            ]
    });
    });</script>



<script>
            $(function () {
            $('#start_date,#end_date').datetimepicker({
            useCurrent: false,
                    minDate: moment().add(1, 'days'),
                    format: 'MM/DD/YYYY'
            });
                    $('#start_date').datetimepicker().on('dp.change', function (e) {
            var incrementDay = moment(new Date(e.date));
                    //incrementDay.add(1, 'days');
                    $('#end_date').data('DateTimePicker').minDate(incrementDay);
                    $(this).data("DateTimePicker").hide();
            });
                    $('#end_date').datetimepicker().on('dp.change', function (e) {
            var decrementDay = moment(new Date(e.date));
                    //decrementDay.subtract(1, 'days');
                    $('#start_date').data('DateTimePicker').maxDate(decrementDay);
                    $(this).data("DateTimePicker").hide();
            });
            });
</script>