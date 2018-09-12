<div class="col-md-12 col-sm-12 col-xs-12">
  <div class="sections-head">INVOICES</div>
  <div class="infoMessage"><?php if(isset($error) && strlen($error)>0){ echo $message;}
  if(isset($message) && strlen($message)>0){
      echo $message;
  }
  ?></div>  
  <div class="x_panel">
    <div class="x_content">
      <table id="datatable" class="table table-striped table-bordered">
        <thead>
          <tr>
            <th>#</th>
             <th>Transaction Number</th>
                        <th>Transaction Date</th>
                        <th>Total (<?php echo CURRENCY_SYMBOL;?>)</th>
                        <!--<th>Description</th>-->
                        <th>Package</th>
                        <th>Subscription End Date</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
<?php
                    if (isset($invoices) && count($invoices) > 0) {
                        $i=1;
                        foreach ($invoices as $value) {
                              $subTotal = trim($value->sub_total);
                            if(isset($value->discount_percentage) && $value->discount_percentage > 0)
                            {
                                $discountFigure = ($subTotal * $value->discount_percentage) / 100;
                                $amount = $subTotal - $discountFigure;
                            }else{
                                $amount = $subTotal;
                            }
                             if(isset($value->tax) && $value->tax > 0 ) {
                                 $taxFigure = ($amount * $value->tax) / 100;                                 
                                 $amount = $amount + $taxFigure;
                            }
                            echo "<tr>"
                            . "<td>" . $i++ . "</td>"
                            . "<td>" . $value->transaction_number . "</td>"
                            . "<td>" . date(DATE_FORMAT, strtotime($value->transaction_date)) . "</td>"
                            . "<td>" . CURRENCY_SYMBOL.number_format($amount,2) . "</td>"
//                            . "<td>" . $value->transaction_description . "</td>"
                            . "<td>" . ucwords(strtolower($value->package_mode)) . "</td>"
                            . "<td>" . date(DATE_FORMAT,  strtotime($value->subscription_end_date)) . "</td>"
                            . "<td><a href='".USER_URL."export_invoice/".$value->transaction_number."' class='label label-success'>View</a></td>"
                            . "</tr>";
                        }
                    }
                    ?>
        </tbody>
      </table>
    </div>
  </div>
  <div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog"> 
      
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Invoice</h4>
        </div>
        <div class="modal-body" id="invoice_body"> </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>  
</div>
