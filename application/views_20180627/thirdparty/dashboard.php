
<div class="row clearfix">
    <!--    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
            <div class="info-box bg-pink hover-expand-effect">
                <div class="icon1">
                    <i class="fa fa-wheelchair" aria-hidden="true"></i>
                </div>
                <div class="content">
                    <div class="text">Total Transaction</div>
                    <div class="number count-to" data-from="0" data-to="125" data-speed="15" data-fresh-interval="20">$<?php //echo $total_transaction_amount;                                                                                    ?></div>
                </div>
            </div>
        </div>-->
    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
        <div class="info-box bg-cyan hover-expand-effect">
            <div class="icon1">
                <i class="fa fa-angle-right" aria-hidden="true"></i>
            </div>
            <div class="content">
                <div class="text">Upcoming Appointments</div>
                <div class="number count-to" data-from="0" data-to="257" data-speed="1000" data-fresh-interval="20"><?php echo $total_upcomming_appointment; ?></div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
        <div class="info-box bg-light-green hover-expand-effect">
            <div class="icon1">
                <i class="fa fa-video-camera" aria-hidden="true"></i>
            </div>
            <div class="content">
                <div class="text">Total Patients</div>
                <div class="number count-to" data-from="0" data-to="243" data-speed="1000" data-fresh-interval="20"><?php echo $total_patient; ?></div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
        <div class="info-box bg-cyan hover-expand-effect">
            <div class="icon1">
                <i class="fa fa-calendar" aria-hidden="true"></i>
            </div>
            <div class="content">
                <div class="text">Total Appointments</div>
                <div class="number count-to" data-from="0" data-to="257" data-speed="1000" data-fresh-interval="20"><?php echo $total_appointment; ?></div>
            </div>
        </div>
    </div>
    <!--    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
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
<div class="row">

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
                                <th>Student's Name</th>
                                <th>Email</th>
                                <th>College</th>
                                <th>DATE</th>
                                <th>TIME</th>
                                <th>MODIFY APPOINTMENT</th>
                                <th>LINK TO SESSION <i class="fa fa-info-circle" title="A link to your video-session will appear 15 minutes prior to your scheduled appointment time."></i></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            if (isset($upcoming_appointment) && !empty($upcoming_appointment) && count($upcoming_appointment) > 0) {
                                foreach ($upcoming_appointment as $value) {
                                    $start_datetime = $this->basic_model->change_utc_datetime($value->start_date . ' ' . $value->start_time);
                                    $end_datetime = $this->basic_model->change_utc_datetime($value->end_date . ' ' . $value->end_time);
                                    $session_link = '';
                                    if (date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . " + 15 minutes")) >= $start_datetime && date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . " - 15 minutes")) <= $start_datetime) {
                                        $session_link = "<a class='btn btn-info btn-xs' href='javascript:void(0)' onclick = 'show_modal(" . $value->avail_id . ", " . $value->provider_id . ", " . $value->avail_id . ", " . $value->patient_id . ", " . $value->status . ", " . $value->app_id . ")'>Begin Session</a>";
                                    }
                                    $edit_link = "<a class=' btn-warning btn-sm' href='javascript:void(0)' onclick = 'show_modal(" . $value->avail_id . ", " . $value->provider_id . ", " . $value->avail_id . ", " . $value->patient_id . ", " . $value->status . ", " . $value->app_id . ")' title = 'Modify Appointment'><i class='fa fa-pencil'></i></a>";
                                    echo "<tr>"
                                    //. "<td>" . $i . "</td>"
                                    . "<td>" . ucfirst($value->first_name) . ' ' . ucfirst($value->last_name) . "</td>"
                                    . "<td>" . $value->user_email . "</td>"
                                    . "<td>" . $value->college_name . "</td>"
                                    . "<td>" . show_date($value->start_date . ' ' . $value->start_time) . "</td>"
                                    . "<td>" . show_time($value->start_date . ' ' . $value->start_time) . '-' . show_time($value->start_date . ' ' . $value->end_time) . "</td>"
                                    . "<td>" . $edit_link . "</td>"
                                    . "<td>$session_link </td>"
                                    . "</tr>";

                                    $i++;
                                }
                            } else {
                                echo "<tr><td colspan='7' align='center'>No Record Found</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <?php if (isset($upcoming_appointment) && !empty($upcoming_appointment) && count($upcoming_appointment) > 0) { ?>
                    <div class="clearfix"></div>
                    <div class="text-right">
                        <a href="<?php echo THIRD_PARTY_URL; ?>upcoming_appoinment" class="btn btn-primary">More</a>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <!-- end of weather widget -->
    <!-- start of past appointment widget -->
    <div class="col-md-12 col-sm-12 col-xs-12 recentactivity latestmsg">
        <div class="x_panel">
            <div class="x_title">
                <h2>PAST APPOINTMENTS</h2>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="table-responsive">
                    <table class="table table-hover dashboard-task-infos">
                        <thead>
                            <tr>
                                <!--<th>#</th>-->
                                <th>Student's Name</th>
                                <th>Email</th>
                                <th>College</th>
                                <th>DATE</th>
                                <th>TIME</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            if (isset($past_appointment) && !empty($past_appointment) && count($past_appointment) > 0) {
                                foreach ($past_appointment as $value) {

                                    echo "<tr>"
                                    //. "<td>" . $i . "</td>"
                                    . "<td>" . ucfirst($value->first_name) . ' ' . ucfirst($value->last_name) . "</td>"
                                    . "<td>" . $value->user_email . "</td>"
                                    . "<td>" . $value->college_name . "</td>"
                                    . "<td>" . show_date($value->start_date . ' ' . $value->start_time) . "</td>"
                                    . "<td>" . show_time($value->start_date . ' ' . $value->start_time) . '-' . show_time($value->start_date . ' ' . $value->end_time) . "</td>"
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
                <?php if (isset($past_appointment) && !empty($past_appointment) && count($past_appointment) > 0) { ?>
                    <div class="clearfix"></div>
                    <div class="text-right">
                        <a href="<?php echo THIRD_PARTY_URL; ?>past_appoinment" class="btn btn-primary">More</a>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <!-- end of weather widget -->

    <!-- message to do list -->
    <?php /* <div class="col-md-12 col-sm-12 col-xs-12 recentactivity latestmsg">
      <div class="x_panel">
      <div class="x_title">
      <h2>MY PATIENTS</h2>

      <div class="clearfix"></div>
      </div>
      <div class="x_content">

      <div class="table-responsive">
      <table class="table table-hover dashboard-task-infos">
      <thead>
      <tr>
      <th>#</th>
      <th>Name</th>
      <th>Email</th>
      <!--<th>Status</th>-->
      </tr>
      </thead>
      <tbody>
      <?php
      $i = 1;
      if (isset($our_patient) && !empty($our_patient) && count($our_patient) > 0) {
      foreach ($our_patient as $value) {

      echo "<tr>"
      . "<td>" . $i . "</td>"
      . "<td>" . ucfirst($value->first_name) . ' ' . ucfirst($value->last_name) . "</td>"
      . "<td><a href='mailto:" . $value->user_email . "'>" . $value->user_email . "</a></td>"
      //. "<td><a class='btn btn-primary btn-xs' href='#'><i class='fa fa-folder'></i>  </a><a class='btn btn-danger btn-xs' href='#'><i class='fa fa-trash-o'></i>  </a></td>"
      . "</tr>";

      $i++;
      }
      } else {
      echo "<tr><td colspan='3' align='center'>No Record Found</td></tr>";
      }
      ?>
      </tbody>
      </table>
      </div>
      </div>
      </div>
      </div> */ ?>
    <!-- End to do list -->

</div>

<div id="updateModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Appointment Information</h4>
            </div>
            <form action="<?php echo THIRD_PARTY_URL; ?>updateavailabality" method="post">
                <div id="target_body">

                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function show_modal(avail_id, provider_id, slot_id, patient_id, app_status, app_id) {
        $.ajax({
            url: '<?php echo THIRD_PARTY_URL . 'update_schedule' ?>',
            data: 'avail_id=' + avail_id + "&provider_id=" + provider_id + "&slot_id=" + slot_id + "&patient_id=" + patient_id + "&app_id=" + app_id + "&app_status=" + app_status,
            type: "POST",
            success: function (data) {
                $('#target_body').html(data);
                $("#target_body .datetimepicker").datetimepicker({
                    /* format: 'MM/DD/YYYY', */
                });
                $("#target_body .groups_dropdown").multiselect({nonSelectedText: 'Select A TimeSlot', numberDisplayed: 1})
                $('#updateModal').modal('show');

            },
            error: function () {

            }

        });
    }

</script>