<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="sections-head">Company List</div>
     <div id="infoMessage"><?php if(isset($message)) { 
        ?><p class="alert alert-success text-left"><?php
        echo $message; 
        ?></p><?php
    } ?></div>
    <div id="infoMessage">
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
                        <th>#</th>
                        <th>Transaction Number</th>
                        <th>Transaction Date</th>
                        <th>Sub Total</th>
                        <th>Discount</th>
                        <th>Description</th>
                        <th>Package</th>
                        <!--<th>Actions</th>-->
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($result) && count($result) > 0) {
                        $i=1;
                        foreach ($result as $value) {
                            echo "<tr>"
                            . "<td>" . $i++ . "</td>"
                            . "<td>" . $value->transaction_number . "</td>"
                            . "<td>" . date(DATE_FORMAT, strtotime($value->transaction_date)) . "</td>"
                            . "<td>" .CURRENCY_SYMBOL. $value->sub_total . "</td>"
                            . "<td>" . $value->discount_percentage . " %</td>"
                            . "<td>" . $value->transaction_description . "</td>"
                            . "<td>" . ucwords(strtolower($value->package_mode)) . "</td>"
//                            . "<td><a href='".COMPANY_URL."export_invoice/".$value->transaction_number."'><i class='fa fa-file-pdf-o' aria-hidden='true'></i></a></td>"
                            . "</tr>";
                        }
                    }
                    ?>

                </tbody>
            </table>
        </div>
    </div>

</div>