<div class="row clearfix">
    <!--    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
            <div class="info-box bg-pink hover-expand-effect">
                <div class="icon1">
                    <i class="fa fa-wheelchair" aria-hidden="true"></i>
                </div>
                <div class="content">
                    <div class="text">Total Transaction</div>
                    <div class="number count-to" data-from="0" data-to="125" data-speed="15" data-fresh-interval="20"><?php //echo $total_transaction_amount;           ?></div>
                </div>
            </div>
        </div>-->
    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
        <div class="info-box bg-cyan hover-expand-effect">
            <div class="icon1">
                <i class="fa fa-calendar" aria-hidden="true"></i>
            </div>
            <div class="content">
                <div class="text">Total Provider</div>
                <div class="number count-to" data-from="0" data-to="257" data-speed="1000" data-fresh-interval="20"><?php echo $total_provider; ?></div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
        <div class="info-box bg-light-green hover-expand-effect">
            <div class="icon1">
                <i class="fa fa-video-camera" aria-hidden="true"></i>
            </div>
            <div class="content">
                <div class="text">Total Third Party</div>
                <div class="number count-to" data-from="0" data-to="243" data-speed="1000" data-fresh-interval="20"><?php echo $total_third_party; ?></div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
        <div class="info-box bg-orange hover-expand-effect">
            <div class="icon1">
                <i class="fa fa-user-plus" aria-hidden="true"></i>
            </div>
            <div class="content">
                <div class="text">Total Patients</div>
                <div class="number count-to" data-from="0" data-to="1225" data-speed="1000" data-fresh-interval="20"><?php echo $total_patient; ?></div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <!-- message to do list -->
    <div class="col-md-6 col-sm-6 col-xs-12 recentactivity latestmsg">
        <div class="x_panel">
            <div class="x_title">
                <h2>LAST TRANSACTION</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="table-responsive">
                    <table class="table table-hover dashboard-task-infos">
                        <thead>
                            <tr>
                                <th>PROVIDER</th>
                                <th>STUDENT</th>
                                <th>AMOUNT</th>
                                <th>TRANSACTION</th>
                                <th>FROM</th>
                                <th>TO</th>
<!--                            <th>Status</th>-->
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            if (isset($last_transactions) && !empty($last_transactions) && count($last_transactions) > 0) {
                                foreach ($last_transactions as $value) {
                                    echo "<tr>"
                                    . "<td>" . ucfirst($value->provider_name) . "</td>"
                                    . "<td>" . ucfirst($value->patient_name) . "</td>"
                                    . "<td>" . $value->amount . "</td>"
                                    . "<td>" . $value->transaction_no . "</td>"
                                    . "<td>" . show_dateTime($value->start_date . ' ' . $value->start_time) . "</td>"
                                    . "<td>" . show_dateTime($value->end_date . ' ' . $value->end_time) . "</td>"
//                              . "<td><a class='btn btn-primary btn-xs' href='#'><i class='fa fa-folder'></i>  </a><a class='btn btn-danger btn-xs' href='#'><i class='fa fa-trash-o'></i>  </a></td>"
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
    <!-- End to do list -->

    <!-- start of appointment widget -->
    <div class="col-md-6 col-sm-6 col-xs-12 recentactivity latestmsg">
        <div class="x_panel">
            <div class="x_title">
                <h2>UPCOMING APPOINTMENT</h2>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="table-responsive">
                    <table class="table table-hover dashboard-task-infos">
                        <thead>
                            <tr>
                                <th>PROVIDER</th>
                                <th>STUDENT</th>
                                <th>FROM</th>
                                <th>TO</th>
<!--                            <th>Status</th>-->
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            if (isset($upcoming_appointment) && !empty($upcoming_appointment) && count($upcoming_appointment) > 0) {
                                foreach ($upcoming_appointment as $value) {
                                    echo "<tr>"
                                    . "<td>" . ucfirst($value->provider_name) . "</td>"
                                    . "<td>" . ucfirst($value->patient_name) . "</td>"
                                    . "<td>" . show_dateTime($value->start_date . ' ' . $value->start_time) . "</td>"
                                    . "<td>" . show_dateTime($value->end_date . ' ' . $value->end_time) . "</td>"
//                              . "<td><a class='btn btn-primary btn-xs' href='#'><i class='fa fa-folder'></i>  </a><a class='btn btn-danger btn-xs' href='#'><i class='fa fa-trash-o'></i>  </a></td>"
                                    . "</tr>";

                                    $i++;
                                }
                            } else {
                                echo "<tr><td colspan='5' align='center'>No Record Found</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <?php if (isset($upcoming_appointment) && !empty($upcoming_appointment) && count($upcoming_appointment) > 0) { ?>
                    <div class="clearfix"></div>
                    <div class="text-right">
                        <a href="<?php echo COLLEGE_URL; ?>upcoming_appoinment" class="btn btn-primary">More</a>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <!-- end of weather widget -->
</div>