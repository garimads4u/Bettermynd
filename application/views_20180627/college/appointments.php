<div class="col-md-12 col-sm-12 col-xs-12">
    <div id="infoMessage">
        <?php if (isset($message)) { ?>
            <p class="alert alert-success text-left">
                <?php echo $message; ?>
            </p>
        <?php } ?>

        <?php if (isset($error)) { ?>
            <p class="alert alert-danger text-left">
                <?php echo $error; ?>
            </p>
        <?php } ?>
    </div>

    <div class="x_panel">
        <div class="x_content">
            <table id="datatable" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Student</th>
                        <th>Provider</th>
                        <th>Start Time</th>
                        <th>Created On</th>
                        <th>Status</th>
                        <th class="no_sorting">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($appointments_list) && !empty($appointments_list) && count($appointments_list) > 0) {
                        foreach ($appointments_list as $value) {
                            $start_datetime = $this->basic_model->change_utc_datetime($value->start_date . ' ' . $value->start_time);
                            $action = '';
                            if ($value->status == 2) {
                                $status = '<span class="label label-danger">Canceled</span>';
                                $action = '<a href="javascript:void(0)" class="btn btn-danger disabled">Canceled</a>';
                            } else {
                                if ($start_datetime >= date('Y-m-d H:i:s')) {
                                    $action = '<a href="javascript:void(0)" onclick="cancelappointment(\'' . base64_encode($value->app_id) . '\')" class="btn btn-danger">Cancel</a>';
                                }
                                $status = '<span class="label label-success">Confirmed</span>';
                            }

                            $locationStr = '';

                            echo "<tr>"
                            . "<td>" . $value->app_id . "</td>"
                            . "<td>" . ucfirst($value->patient_fname) . ' ' . ucfirst($value->patient_lname) . "</td>"
                            . "<td>" . ucfirst($value->provider_fname) . ' ' . ucfirst($value->provider_lname) . "</td>"
                            . "<td>" . show_dateTime($value->start_date . " " . $value->start_time) . "</td>"
                            . "<td>" . show_date($value->booked_on) . "</td>"
                            . "<td>" . $status . "</td>"
                            . "<td> " . $action . " </td>"
                            . "</tr>";
                        }
                    }
                    ?>

                </tbody>
            </table>
        </div>
    </div>

</div>

<form action="<?php echo COLLEGE_URL . 'cancelappointment'; ?>" id="cancelappfrm" method="post">
    <input type="hidden" name="appointment_id" id="appointment_id">
</form>
<script>
    function cancelappointment(appointment_id) {
        $('#appointment_id').val(appointment_id);
        $('#cancelappfrm').submit();
    }
</script>