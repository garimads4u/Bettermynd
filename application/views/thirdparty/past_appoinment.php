<div class="row">
    <!-- start of appointment widget -->
    <div class="col-md-12 col-sm-12 col-xs-12 recentactivity latestmsg">
        <div class="x_panel"> 
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

            </div>
        </div>
    </div>
    <!-- end of weather widget -->
    <!-- start of past appointment widget -->
</div>
