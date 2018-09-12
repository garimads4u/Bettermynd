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

    <div class="x_panel">
        <div class="x_content">
            <table id="datatable" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>PROVIDER</th>
                        <th>STUDENT</th>
                        <th>FROM</th>
                        <th>TO</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    if (isset($upcoming_appointment) && !empty($upcoming_appointment) && count($upcoming_appointment) > 0) {
                        foreach ($upcoming_appointment as $value) {
                            echo "<tr>"
                            //. "<td>" . $i . "</td>"
                            . "<td>" . ucfirst($value->provider_name) . "</td>"
                            . "<td>" . ucfirst($value->patient_name) . "</td>"
                            . "<td>" . show_date($value->start_date) . ' ' . show_time($value->start_time) . "</td>"
                            . "<td>" . show_date($value->end_date) . ' ' . show_time($value->end_time) . "</td>"
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
    </div>


</div>

