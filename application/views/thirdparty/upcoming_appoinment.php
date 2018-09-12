<div class="row">
    <!-- start of appointment widget -->
    <div class="col-md-12 col-sm-12 col-xs-12 recentactivity latestmsg">
        <div class="x_panel">
            <div class="x_title">
                <!--<h2>UPCOMING APPOINTMENTS<span><strong> (Please refresh the page 15 minutes prior to your scheduled appointment time.)</strong></span></h2>-->

                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="table-responsive" style="overflow-x: hidden;">
                    <table class="table table-hover dashboard-task-infos" id="datatable_no_search">
                        <thead>
                            <tr>
                                <!--<th>#</th>-->
                                <th>Student's Name</th>
                                <th>Email</th>
                                <th>College</th>
                                <th>DATE</th>
                                <th>TIME</th>
                                <th class="no_sorting">MODIFY APPOINTMENT</th>
                                <th class="no_sorting">LINK TO SESSION <i class="fa fa-info-circle" title="A link to your video-session will appear 15 minutes prior to your scheduled appointment time."></i></th>
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

            </div>
        </div>
    </div>
    <!-- end of weather widget -->
    <!-- start of past appointment widget -->
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