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
                        <th>Provider's Name</th>
                        <th>Provider's Email</th>
<!--                        <th>Transaction Number</th>-->
                        <th>Amount</th>
                        <th>Paid Amount</th>
                        <th>Discount Amount</th>
                        <th>Status</th>
                        <th>Appointment Status</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Created On</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
//                    prd($transaction, 1);
                    if (isset($transaction) && !empty($transaction) && count($transaction) > 0) {
                        foreach ($transaction as $value) {
                            if (isset($value['refund'])) {
                                $value = $value['refund'];
                                $status = "Refunded";
                            } else {
                                $value = $value['charge'];
                                $status = "Paid";
                            }
                            if (isset($value->app_status) && $value->app_status == '1') {
                                $app_status = "Confirmed";
                            } else if (isset($value->app_status) && $value->app_status == '2') {
                                $app_status = "Cancelled";
                            }
                            /* if ($value->payent_status == 1) {
                              $status = "Paid";
                              } else {
                              $status = "UnPaid";
                              } */

                            $locationStr = '';

                            echo "<tr>"
                            . "<td>" . ucfirst($value->first_name) . ' ' . ucfirst($value->last_name) . "</td>"
                            . "<td><a href='mailto:" . $value->user_email . "'>" . $value->user_email . "</a></td>"
                            . "<!--<td>" . $value->transaction_no . "</td>-->"
                            . "<td>" . $value->amount . "</td>"
                            . "<td>" . $value->remain_session_cost . "</td>"
                            . "<td>" . $value->discount_amount . "</td>"
                            . "<td>" . $status . "</td>"
                            . "<td>" . $app_status . "</td>"
                            . "<td>" . show_date($value->start_date . ' ' . $value->start_time) . "</td>"
                            . "<td>" . show_time($value->start_date . ' ' . $value->start_time) . "</td>"
                            . "<td>" . show_dateTime($value->date_created) . "</td>"
                            . "</tr>";
                        }
                    }
                    ?>

                </tbody>
            </table>
        </div>
    </div>

</div>

