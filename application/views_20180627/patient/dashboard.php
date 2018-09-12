<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?php if (isset($error) && !empty($error)) {
            ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
            <div class="clearfix"></div>
            <?php
        }
        if (isset($message) && !empty($message)) {
            ?>
            <div class="alert alert-success"><?php echo $message; ?></div>
            <div class="clearfix"></div>
            <?php
        }
        ?>
    </div>
    <!--    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
            <div class="info-box bg-pink hover-expand-effect">
                <div class="icon1">
                    <i class="fa fa-wheelchair" aria-hidden="true"></i>
                </div>
                <div class="content">
                    <div class="text">Total Transaction</div>
                    <div class="number count-to" data-from="0" data-to="125" data-speed="15" data-fresh-interval="20">$<?php //echo $total_transaction_amount;                                                                                                                                                                                                       ?></div>
                </div>
            </div>
        </div>-->
    <?php /* <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
      <div class="info-box bg-cyan hover-expand-effect">
      <div class="icon1">
      <i class="fa fa-calendar" aria-hidden="true"></i>
      </div>
      <div class="content">
      <div class="text">Total Appointments</div>
      <div class="number count-to" data-from="0" data-to="257" data-speed="1000" data-fresh-interval="20"><?php echo $total_appointment; ?></div>
      </div>
      </div>
      </div> */ ?>
    <!--    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
            <div class="info-box bg-light-green hover-expand-effect">
                <div class="icon1">
                    <i class="fa fa-video-camera" aria-hidden="true"></i>
                </div>
                <div class="content">
                    <div class="text">Total Video Calls</div>
                    <div class="number count-to" data-from="0" data-to="243" data-speed="1000" data-fresh-interval="20">243</div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
            <div class="info-box bg-orange hover-expand-effect">
                <div class="icon1">
                    <i class="fa fa-user-plus" aria-hidden="true"></i>
                </div>
                <div class="content">
                    <div class="text">NEW VISITORS</div>
                    <div class="number count-to" data-from="0" data-to="1225" data-speed="1000" data-fresh-interval="20">1225</div>
                </div>
            </div>
        </div>-->
</div>
<div class="row clearfix">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
            <div class="panel panel-primary">
                <div class="panel-heading" role="tab" id="headingOne">
                    <h4 class="panel-title">
                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseWelcome" aria-expanded="true" aria-controls="collapseOne">
                            Welcome to BetterMynd
                        </a>
                    </h4>
                </div>
                <div id="collapseWelcome" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                    <div class="panel-body">
                        <div class="row clearfix">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <?php echo $welcome_note; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row clearfix">


    <!-- message to do list -->
    <?php /* <div class="col-md-6 col-sm-6 col-xs-12 recentactivity latestmsg">
      <div class="x_panel">
      <div class="x_title">
      <h2>MY PROVIDERS</h2>

      <div class="clearfix"></div>
      </div>
      <div class="x_content">

      <div class="table-responsive">
      <table class="table table-hover dashboard-task-infos">
      <thead>
      <tr>
      <th>#</th>
      <th>NAME</th>
      <th>EMAIL</th>
      <th>STATUS</th>
      </tr>
      </thead>
      <tbody>
      <?php
      $i = 1;
      if (isset($own_provider) && !empty($own_provider) && count($own_provider) > 0) {
      foreach ($own_provider as $value) {

      echo "<tr>"
      . "<td>" . $i . "</td>"
      . "<td>" . ucfirst($value->first_name) . ' ' . ucfirst($value->last_name) . "</td>"
      . "<td><a href='mailto:" . $value->user_email . "'>" . $value->user_email . "</a></td>"
      . "<td><a class='btn btn-primary btn-xs' href='#'><i class='fa fa-folder'></i>  </a><a class='btn btn-danger btn-xs' href='#'><i class='fa fa-trash-o'></i>  </a></td>"
      . "</tr>";

      $i++;
      }
      } else {
      echo "<tr><td colspan='4' align='center'>No Record Found</td></tr>";
      }
      ?>

      </tbody>
      </table>
      </div>
      </div>
      </div>
      </div> */ ?>
    <!-- End to do list -->

    <!-- start of appointment widget -->
    <div class="col-md-12 col-sm-12 col-xs-12 recentactivity latestmsg">
        <div class="x_panel">
            <div class="x_title">
                <h2>UPCOMING APPOINTMENTS<span><strong> (Please refresh the page 15 minutes prior to your scheduled appointment time.)</strong></span></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="table-responsive">
                    <table class="table table-hover dashboard-task-infos">
                        <thead>
                            <tr>
                                <!--<th>#</th>-->
                                <th>PROVIDER NAME</th>
                                <th>EMAIL</th>
                                <th>DATE</th>
                                <th>TIME</th>
                                <th>MODIFY APPOINTMENT</th>
                                <th>LINK TO SESSION <i class="fa fa-info-circle" title="A link to your video-session will appear 15 minutes prior to your scheduled appointment time."></i>
                                </th>
                                <!--                                <th>Status</th>-->
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // prd($upcoming_appointment, 1);
                            $show_note_msg = 'NO';
                            $i = 1;
                            if (isset($upcoming_appointment) && !empty($upcoming_appointment) && count($upcoming_appointment) > 0) {
                                foreach ($upcoming_appointment as $value) {
                                    $start_datetime = $this->basic_model->change_utc_datetime($value->start_date . ' ' . $value->start_time);
                                    $end_datetime = $this->basic_model->change_utc_datetime($value->end_date . ' ' . $value->end_time);
                                    $session_link = '';
                                    if ($start_datetime >= date('Y-m-d H:i:s')) {
                                        $show_note_msg = 'YES';
                                    }
                                    if (date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . " + 15 minutes")) >= $start_datetime && date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . " - 15 minutes")) <= $start_datetime) {
                                        $session_link = "<a class='btn btn-info btn-xs' href='javascript:void(0)' onclick = 'show_modal(" . $value->avail_id . ", " . $value->provider_id . ", " . $value->avail_id . ", " . $value->patient_id . ", " . $value->status . ", " . $value->app_id . ")'>Begin Session</a>";
                                    }
                                    $edit_link = "<a class=' btn-warning btn-sm' href='javascript:void(0)' onclick = 'show_modal(" . $value->avail_id . ", " . $value->provider_id . ", " . $value->avail_id . ", " . $value->patient_id . ", " . $value->status . ", " . $value->app_id . ")' title = 'Modify Appointment'><i class='fa fa-pencil'></i></a>";
                                    echo "<tr>"
                                    //. "<td>" . $i . "</td>"
                                    . "<td>" . ucfirst($value->first_name) . ' ' . ucfirst($value->last_name) . "</td>"
                                    . "<td> <a href='mailto:" . $value->user_email . "'>" . $value->user_email . "</a></td>"
                                    . "<td>" . show_date($value->start_date . ' ' . $value->start_time) . "</td>"
                                    . "<td>" . show_time($value->start_date . ' ' . $value->start_time) . '-' . show_time($value->end_date . ' ' . $value->end_time) . "</td>"
                                    . "<td style='text-align: center;'>" . $edit_link . "</td>"
                                    . "<td style='text-align: center;'>$session_link</td>"
                                    . "</tr>";

                                    $i++;
                                }
                            } else {
                                echo "<tr><td colspan='6' align='center'>No Record Found</td></tr>";
                            }
                            ?>


                        </tbody>
                    </table>
                </div>
                <?php if ($show_note_msg == 'YES') { ?>
                    <div class="col-md-12">
                        <span class="red">*Please note: Any appointments canceled within 24-hours of the scheduled appointment time are not refundable.</span>
                    </div>
                <?php } ?>

                <div class="text-right">
                    <a href="<?php echo PATIENT_URL; ?>upcoming_appoinment" class="btn btn-primary">More</a>
                </div>
            </div>
        </div>
    </div>
    <!-- end of weather widget -->
</div>
<div class="row clearfix" style="display:none;">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
            <div class="panel panel-primary">
                <div class="panel-heading" role="tab" id="headingOne">
                    <h4 class="panel-title">
                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Notifications
                        </a>
                    </h4>
                </div>
                <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                    <div class="panel-body">
                        <div class="row clearfix">
                            <div class="col-md-12 col-sm-12 col-xs-12">

                                <table id="datatable_notification" class="table table-hover dashboard-task-infos">
                                    <thead>
                                        <tr>
                                            <th>Messages</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        if (isset($flashmessages) && !empty($flashmessages) && count($flashmessages) > 0) {
                                            foreach ($flashmessages as $value) {
                                                echo "<tr>"
                                                . "<td>" . ucfirst($value->message) . "</td>"
                                                . "</tr>";
                                            }
                                        } else {
                                            echo "<tr><td colspan='2' align='center'>No Record Found</td></tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12 recentactivity latestmsg">
        <div class="x_panel">

            <div class="x_content">
                <div class="">
                    <a class='btn btn-info btn-xs' href='<?php echo base_url('patient/bookanappointment'); ?>'>BOOK A NEW APPOINTMENT</a>
                </div>

                <div class="card-box">
                    <div id="calendars"></div>
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
                    <form action="<?php echo PATIENT_URL; ?>updateavailabality" method="post">
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
            function show_modal(avail_id, provider_id, slot_id, patient_id, app_status, app_id){
            $.ajax({
            url: '<?php echo PATIENT_URL . 'update_schedule' ?>',
                    data: 'avail_id=' + avail_id + "&provider_id=" + provider_id + "&slot_id=" + slot_id + "&patient_id=" + patient_id + "&app_status=" + app_status + "&app_id=" + app_id,
                    type: "POST",
                    success: function (data) {
                    $('#target_body').html(data);
                            $("#target_body .datetimepicker").datetimepicker({
                    format: 'MM/DD/YYYY',
                    });
                            $("#target_body .groups_dropdown").multiselect({nonSelectedText:'Select A TimeSlot', numberDisplayed:1})
                            $('#updateModal').modal('show');
                    },
                    error: function () {

                    }

            });
            }
            $(document).ready(function() {

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
                    show_modal(calEvent.avail_id, calEvent.provider_id, calEvent.slot_id, calEvent.patient_id, calEvent.app_status, calEvent.app_id);
                    },
                    events: [
<?php
if (isset($appointments) && !empty($appointments)) {
    foreach ($appointments as $schedule) {
        ?>
                            {
                            title: 'Appointment',
                                    start: '<?php echo date('Y-m-d H:i:s', strtotime($schedule['start_date'] . " " . $schedule['start_time'])); ?>',
                                    end: '<?php echo date('Y-m-d H:i:s', strtotime($schedule['end_date'] . " " . $schedule['end_time'])); ?>', avail_id:'<?php echo $schedule['avail_id']; ?>',
                                    provider_id:'<?php echo $schedule['provider_id']; ?>',
                                    patient_id:'<?php echo $schedule['patient_id']; ?>',
                                    slot_id:'<?php echo $schedule['avail_id']; ?>',
                                    app_id:'<?php echo $schedule['app_id']; ?>',
                                    app_status:'<?php echo $schedule['status']; ?>',
        <?php
        $avail_check = $schedule['status'];
        if ($avail_check == 2) {
            echo "className: 'bg-red'";
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

        </script>
    </div>
</div>