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
    <div class="sections-head">Commission Detail</div>
    <div class="x_panel">
        <div class="x_content">
            <table id="datatable" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Commission Date</th>
                        <th>Commissionable Amount</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($payout_dates) && count($payout_dates) > 0 && !empty($payout_dates)) {
                        $i=0;
                        foreach ($payout_dates as $value) {
                            echo "<tr>"
                            . "<td>" . ++$i . "</td>"
                            . "<td>" . date('F Y',  strtotime($value->generate_date)) . "</td>"
                            . "<td>" .CURRENCY_SYMBOL.' '. $this->affiliate_model->get_commission_amount(date('m-Y',strtotime($value->generate_date))) . "</td>"
                            . "<td><a href='".AFFILIATE_URL.'commissiondetail/'.date('Y-m-d',  strtotime($value->generate_date))."' class='label logincompany label-success'>View</a></td>";
                            echo "</tr>";
                        }
                    }
                    ?>

                </tbody>
            </table>
        </div>
    </div>

</div>