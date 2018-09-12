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
        <div class="pull-left"><a  class="btn btn-primary" data-toggle="modal" data-target="#addAvailabality"><i class="fa fa-plus"></i>&nbsp;Add Availability </a></div>
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
            <script type="text/javascript">
                $(function(){
                $("#avail_form").validate({
                rules: {
                startdate: {
                required: true
                },
                        enddate: {
                        required: true
                        }
                },
                        errorPlacement: function (error, element) {
                        var my = "";
                                var at = "";
                                if ($(window).width() < 800) {
                        my = 'bottom right';
                                at = 'top right';
                        } else {
                        my = 'bottom right';
                                at = 'top right';
                        }
                        if (!error.is(':empty')) {
                        $(element).not('.valid').qtip({
                        overwrite: false,
                                content: error,
                                show: 'focus',
                                hide: 'blur',
                                position: {
                                my: my,
                                        at: at,
                                        viewport: $(window),
                                        adjust: {
                                        x: 0,
                                                y: 0
                                        }
                                },
                                style: {
                                classes: 'qtip-custom qtip-shadow',
                                        tip: {
                                        height: 6,
                                                width: 11
                                        }
                                }
                        }).qtip('option', 'content.text', error);
                        } else {
                        element.qtip('destroy');
                        }
                        },
                        success: "valid"
                });
                })
            </script>
            <div class="modal-header">
                <!--<button type="button" class="close" data-dismiss="modal">&times;</button>-->
                <button type="button" class="close" onclick="window.location.reload()">&times;</button>
                <h4 class="modal-title">Add Your Availability</h4>
            </div>
            <form action="<?php echo PROVIDER_URL; ?>saveavailabality" method="post" id="avail_form">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" id="provider_id" name="provider_id" value="<?php echo $provider_id; ?>" />
                        <label class="control-label">Start Date & Time <span class="mandatory">*</span></label>
                        <div class='input-group date datetimepicker' style=" margin-bottom:0">
                            <input type="text" name="startdate" id="startdate" class="form-control noneditable required"   />
                            <span class="input-group-addon"> <span class="glyphicon glyphicon-calendar"></span> </span> </div>
                    </div>
                    <!-- <div class="form-group">
                      <label class="control-label">Start Time</label>
                      <div class='input-group date' style=" margin-bottom:0">
                        <input type="text" name="start_time" id="start_time" class="form-control noneditable"  />
                        <span class="input-group-addon"> <span class="glyphicon glyphicon-calendar"></span> </span> </div>
                    </div>  -->
                    <div class="form-group">
                        <label class="control-label">End Date & Time <span class="mandatory">*</span></label>
                        <div class='input-group date' style=" margin-bottom:0px;width:100%;">
                            <input type="text" name="enddate" id="enddate" class="form-control noneditable required"  />
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="form-group" style="display:none;">
                        <label class="control-label">Time Slots</label>
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
                                    <option value="<?php echo $from; ?>"><?php echo $from; ?> - <?php echo $to; ?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default"  onclick="window.location.reload()">Close</button>
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
            <form action="<?php echo PROVIDER_URL; ?>updateavailabality" method="post" id="availablity_frm">
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
<script type="text/javascript">
            function show_modal(avail_id, provider_id, slot_id, patient_id, app_status, app_id) {
            $.ajax({
            url: '<?php echo PROVIDER_URL . 'update_schedule' ?>',
                    data: 'avail_id=' + avail_id + "&provider_id=" + provider_id + "&slot_id=" + slot_id + "&patient_id=" + patient_id + "&app_id=" + app_id + "&app_status=" + app_status,
                    type: "POST",
                    success: function (data) {
                    $('#target_body').html(data);
                            $("#target_body .datetimepicker").datetimepicker({
                    /* format: 'MM/DD/YYYY', */
                    });
                            $("#target_body .groups_dropdown").multiselect({nonSelectedText:'Select A TimeSlot', numberDisplayed:1})
                            $('#updateModal').modal('show');
                    },
                    error: function () {

                    }

            });
            }
    $(document).ready(function() {
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
            app_id = typeof calEvent.slot_id == 'undefined'?0:calEvent.slot_id;
                    status = typeof calEvent.status == 'undefined'?'':calEvent.status;
                    show_modal(calEvent.avail_id, calEvent.provider_id, calEvent.slot_id, calEvent.patient_id, status, app_id);
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
            echo "className: 'bg-purple',slot_id: '" . $avail_check[0]['app_id'] . "',patient_id: '" . $avail_check[0]['patient_id'] . "',status: '" . $avail_check[0]['status'] . "'";
        }
        ?>
                    },
        <?php
    }
}
?>
            ]
    });
    });
            $(document).ready(function(e) {
    $("#avail_form .datetimepicker").datetimepicker({
    minDate:new Date(<?php echo date('Y'); ?>, <?php echo date('m') - 1; ?>, <?php echo date('d') + 1; ?>),
            /* format: 'MM/DD/YYYY' */
            stepping:15,
            sideBySide: true,
            useCurrent: false,
            showClose: true,
            toolbarPlacement: 'bottom',
            tooltips: {
            close: 'Close'
            }
    });
            $('#startdate').val('');
            $(".datetimepicker").on("dp.change", function (e) {
    d = new Date(e.date);
            d.setTime(d.getTime() + 45 * 60000);
            time = d.toLocaleString('en-US', { hour: 'numeric', minute:'numeric', hour12: true });
            datStr = (d.getMonth() + 1) + '/' + d.getDate() + '/' + d.getFullYear();
            FinalStr = datStr + ' ' + time.toString("hh:mm tt");
            $("#enddate").val(FinalStr);
            $("#enddate").addClass('valid').removeClass('error');
            $("#startdate").addClass('valid').removeClass('error');
    });
    });

</script>
