<div class="col-md-12 col-sm-12 col-xs-12">
    <div id="infoMessage">
        <?php
        if (isset($message)) {
            if (strpos($message, 'alert-success') !== false) {
                echo $message;
            } else {
                ?>
                <p class="alert alert-success text-left">
                    <?php echo $message; ?>
                </p>
                <?php
            }
        }
        ?>

        <?php
        if (isset($error)) {
            if (strpos($error, 'alert-danger') !== false) {
                echo $error;
            } else {
                ?>
                <p class="alert alert-danger text-left">
                    <?php echo $error; ?>
                </p>
                <?php
            }
        }
        ?>
    </div>

    <div class="row">
        <form action="" method="post">
            <div class="col-md-3 col-sm-3 col-xs-12">
                <div class="form-group">
                    <label for="start_date">Login Date<span class="mandatory">*</span></label>
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
                    <label for="end_date">Logout Date<span class="mandatory"></span></label>
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
                        <a href="<?php echo SADMIN_URL . 'login_logs/' . $user_role . '/' . $user_id; ?>" class="btn btn-info">Reset</a>
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
                        <th>S.No</th>
                        <th>Logged In On</th>
                        <th>Logged out On</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($results) && !empty($results) && count($results) > 0) {
                        foreach ($results as $key => $value) {
                            ?>
                            <tr>
                                <td><?= ($key + 1) ?></td>
                                <td> <?= show_dateTime($value->loggedin_on) ?></td>
                                <td> <?= show_dateTime($value->loggedout_on) ?></td>
                            </tr>
                            <?php
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
