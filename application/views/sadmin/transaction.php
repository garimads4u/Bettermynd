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
    <div class="row">
        <form action="" method="post">
            <div class="col-md-3 col-sm-3 col-xs-12">
                <div class="form-group">
                    <label for="start_date">Start Date<span class="mandatory">*</span></label>
                    <div class='input-group date datetimepicker' style=" margin-bottom:0" id="transaction_start">
                        <?php echo form_input($start_date); ?>
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12">
                <div class="form-group">
                    <label for="end_date">End Date<span class="mandatory">*</span></label>
                    <div class='input-group date datetimepicker' style=" margin-bottom:0" id="transaction_end">
                        <?php echo form_input($end_date); ?>
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12">
                <div class="form-group">
                    <label>&nbsp;</label>
                    <div class='input-group' style=" margin-bottom:0">
                        <button type="submit" class="btn btn-success">Search</button>
                        <a href="<?php echo SADMIN_URL . 'transactions'; ?>" class="btn btn-info">Reset</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="x_panel">
        <div class="x_content">
            <table id="datatable" class="table table-striped table-bordered">

                <thead>
                    <tr>
                        <th>Provider</th>
                        <?php /* <th>Email</th>
                          <th>Student Name</th>
                          <th>Student's College</th> */ ?>
                        <th>Appointment Date</th>
                        <th>Appointment Time</th>
                        <th>Total Charges</th>
                        <th>Total Paid Charges</th>
                        <th>Total Refunds</th>
                        <th>Provider Total Amount</th>
                        <th>BetterMynd Total Amount</th>
                        <th>Created On</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($transaction) && !empty($transaction) && count($transaction) > 0) {
                        foreach ($transaction as $value) {

                            $locationStr = '';
                            $url = SADMIN_URL . 'transactions/' . $value->user_id;
                            echo "<tr>"
                            . "<td><a href='{$url}'>" . ucfirst($value->first_name) . ' ' . ucfirst($value->last_name) . "</a></td>"
                            // . "<td><a href='mailto:" . $value->user_email . "'>" . $value->user_email . "</a></td>"
                            //. "<td>" . ucfirst($value->student_first_name) . ' ' . ucfirst($value->student_last_name) . "</td>"
                            //. "<td>" . ucfirst($value->college_name) . "</td>"
                            . "<td>" . show_date($value->start_date . ' ' . $value->start_time) . "</td>"
                            . "<td>" . show_time($value->start_date . ' ' . $value->start_time) . "</td>"
                            . "<td>$" . $value->total_charges . "</td>"
                            . "<td>$" . $value->total_paid_charges . "</td>"
                            . "<td>$" . $value->total_refunds . "</td>"
                            . "<td>$" . $value->balance . "</td>"
                            . "<td>$" . $value->balance_bm . "</td>"
                            . "<td>" . show_date($value->date_created) . "</td>"
                            . "</tr>";
                        }
                    }
                    ?>

                </tbody>
            </table>
        </div>
    </div>

</div>

<script>
    $(function () {
        $('#transaction_start,#transaction_end').datetimepicker({
            useCurrent: false,
            //maxDate: moment(),
            format: 'MM/DD/YYYY'
        });
        $('#transaction_start').datetimepicker().on('dp.change', function (e) {
            var incrementDay = moment(new Date(e.date));
            //incrementDay.add(1, 'days');
            $('#transaction_end').data('DateTimePicker').minDate(incrementDay);
            $(this).data("DateTimePicker").hide();
        });
        $('#transaction_end').datetimepicker().on('dp.change', function (e) {
            var decrementDay = moment(new Date(e.date));
            //decrementDay.subtract(1, 'days');
            $('#transaction_start').data('DateTimePicker').maxDate(decrementDay);
            $(this).data("DateTimePicker").hide();
        });
    });
</script>