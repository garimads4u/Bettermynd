<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="sections-head">Site Logs</div>
     <div id="infoMessage"><?php if(isset($message)) { 
        ?><p class="alert alert-success text-left"><?php
        echo $message; 
        ?></p><?php
    } ?>
        <?php if(isset($error)) { 
        ?><p class="alert alert-danger text-left"><?php
        echo $error; 
        ?></p><?php
    } ?>
    </div>
    <div class="x_panel">
        <div class="x_content">
            <table id="datatable" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Email</th>
                        <th>IP Address</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($site_logs) && count($site_logs) > 0) {
                        foreach ($site_logs as $value) {
                            echo "<tr>"
                            . "<td>" . $value->username . "</td>"
                            . "<td><a href='mailto:".$value->user_email."'>" . $value->user_email . "</a></td>"
                            . "<td>" . $value->user_ip_address . "</td>"
                            . "</tr>";
                        }
                    }
                    ?>

                </tbody>
            </table>
        </div>
    </div>

</div>