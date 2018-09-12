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
                        <a href="<?php echo SADMIN_URL . 'transactions' . '/' . $provider_id; ?>" class="btn btn-info">Reset</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="x_panel">
        <div class="x_content" style="overflow: auto">
            <table id="table" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Student Name</th>
                        <th>Student's College</th>
                        <th>Transaction No.</th>
                        <th>Appointment ID</th>
                        <th>Date/Time</th>
                        <th>Transaction Type</th>
                        <th>Amount</th>
                        <th>Discount Amount</th>
                        <th>Paid Amount</th>
                        <th>Provider Amount</th>
                        <th>BetterMynd  Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($transaction) && !empty($transaction) && count($transaction) > 0) {
                        foreach ($transaction as $key => $value) {
                            $locationStr = '';
                            $class = strtolower($value->transaction_type) == 'refund' ? 'danger' : 'success';
                            echo "<tr class='{$class}'>"
                            . "<td>" . ucfirst($value->student_first_name) . ' ' . ucfirst($value->student_last_name) . "</td>"
                            . "<td>" . ucfirst($value->college_name) . "</td>"
                            . "<td>" . $value->transaction_no . "</td>"
                            . "<td>" . $value->appointment_id . "</td>"
                            . "<td>" . show_dateTime($value->start_date . ' ' . $value->start_time) . "</td>"
                            . "<td>" . $value->transaction_type . "</td>"
                            . "<td>$" . $value->amount . "</td>"
                            . '<td>' . (($value->discount_amount && $value->discount_amount > 0) ? '<a href="javascript:void(0)"  data-toggle="modal" data-target="#id_' . $key . '">$' . $value->discount_amount : '') . '</a>
                                <div id="id_' . $key . '" class="modal fade" role="dialog">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title">Discount Information</h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label class="control-label col-md-4"><strong>Transaction No.</strong></label>
                                                    <label class="control-label">' . $value->transaction_no . '</label>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-4"><strong>Coupon ID</strong></label>
                                                    <label class="control-label">' . $value->coupon_id . '</label>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-4"><strong>Coupon Type</strong></label>
                                                    <label class="control-label">' . ($value->coupon_coupon_type ? ucfirst($this->config->item('CouponType')[$value->coupon_coupon_type]) : '') . '</label>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-4"><strong>Off Amount</strong></label>
                                                    <label class="control-label">' . (($value->coupon_coupon_type == "A") ? "$" . floatval($value->coupon_amount_off) : floatval($value->coupon_percent_off) . '%' ) . '</label>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-4"><strong>Amount</strong></label>
                                                    <label class="control-label">$' . $value->amount . '</label>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-4"><strong>Discount Amount</strong></label>
                                                    <label class="control-label">$' . $value->discount_amount . '</label>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-4"><strong>Paid Amount</strong></label>
                                                    <label class="control-label">$' . $value->remain_session_cost . '</label>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-4"><strong>Provider Amount</strong></label>
                                                    <label class="control-label">$' . $value->amount_to_provider . '</label>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                              </div>
                                        </div>
                                    </div>
                                </div>
                            </td>'
                            . "<td>$" . $value->remain_session_cost . "</td>"
                            . "<td>$" . $value->amount_to_provider . "</td>"
                            . "<td>$" . $value->amount_to_bm . "</td>"
                            . "</tr>";
                        }
                    }
                    if (isset($gross_transaction) && !empty($gross_transaction) && count($gross_transaction) > 0) {
                        foreach ($gross_transaction as $value) {
                            echo "<tr>"
                            . "<td colspan='6'>Total</td>"
                            . "<td>$" . $value->gross_balance . "</td>"
                            . "<td>$" . $value->discount_amt . "</td>"
                            . "<td>$" . $value->paid_amt . "</td>"
                            . "<td>$" . $value->balance . "</td>"
                            . "<td>$" . $value->balance_bm . "</td>"
                            . "</tr>";
                        }
                    }
                    //prd($gross_transaction);
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
