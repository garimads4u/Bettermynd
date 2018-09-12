<div class="col-md-12 col-sm-12 col-xs-12">
    <div id="infoMessage"><?php if (isset($message)) {
   ?><p class="alert alert-success text-left"><?php
            echo $message;
            ?></p><?php }
        ?>
        <?php if (isset($error)) {
            ?><p class="alert alert-danger text-left"><?php
                echo $error;
                ?></p><?php }
            ?>
    </div>
    <div class="sections-head">Company</div>
    <div class="x_panel">
        <div class="x_content">
            <table id="datatable" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Company URL</th>
                        <th>Date Joined</th>
                        <th>Renewal Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($ref_company) && count($ref_company) > 0 && !empty($ref_company)) {
                        foreach ($ref_company as $value) {
                            echo "<tr>"
                            . "<td>" . $value->username . "</td>"
                            . "<td>" . $value->company_url . "</td>"
                            . "<td>" . date(DATE_FORMAT, ($value->user_createdon)) . "</td>"
                            . "<td>" . date(DATE_FORMAT, (strtotime($value->subscription_end_date))) . "</td>";
                            echo "</tr>";
                        }
                    }
                    ?>

                </tbody>
            </table>
        </div>
    </div>
    <div class="sections-head">Users</div>
    <div class="x_panel">
        <div class="x_content">
            <table id="datatable" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Company URL</th>
                        <th>Date Joined</th>
                        <th>Renewal Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($ref_user) && count($ref_user) > 0 && !empty($ref_user)) {
                        foreach ($ref_user as $value) {
                            echo "<tr>"
                            . "<td>" . $value->username . "</td>"
                            . "<td>" . $value->company_url . "</td>"
                            . "<td>" . date(DATE_FORMAT, ($value->user_createdon)) . "</td>"
                            . "<td>" . date(DATE_FORMAT, (strtotime($value->subscription_end_date))) . "</td>";
                            echo "</tr>";
                        }
                    }
                    ?>

                </tbody>
            </table>
        </div>
    </div>
</div>