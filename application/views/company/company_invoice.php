<?php
$total = $invoice_data['total_amount_after_discount'];
?>
<div class="col-sm-12">    
    <h2 class="page-heading">Invoice</h2>
    <div class="x_panel">
        <div class="x_content">

            <section class="content"><!-- title row -->
                <div class="row">
                    <div class="col-xs-12">
                        <h1>
                            <img src="<?php echo IMAGES_URL; ?>logo_png.png" border="0" alt="<?php echo SITE_NAME; ?>"  />
                            <small class="pull-right invoice_date">Date: <?php echo date(DATE_FORMAT, strtotime($invoice_data['transaction_date'])); ?></small>
                        </h1>
                    </div>
                    <!-- /.col -->
                </div>
                <div class="clearfix">&nbsp;</div>
                <!-- info row -->
                <div class="row">
                    <div class="col-sm-4 col-xs-6 invoice-col">
                        From
                        <address>
                            <strong>Marketing Technologists</strong>
                            <br>4759 LAKEMONT BLVD SE, STE C-4 #360
                            <br>Bellevue, WA 98006
                            <br>Phone: 206-940-3648
                            <br>Email: support@brandize.com
                        </address>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-4 col-xs-6 invoice-col">
                        To
                        <address>
                            <strong><?php echo isset($invoice_data['account_holder_name']) && $invoice_data['account_holder_name']!="" ? $invoice_data['account_holder_name'] : ''; ?></strong>
                            <?php echo isset($invoice_data['address']) && $invoice_data['address']!="" ? '<br>'.$invoice_data['address'] :''; ?>
                            <?php echo isset($invoice_data['state']) && $invoice_data['state']!="" ? '<br>'.$invoice_data['state'] :''; ?> <?php echo isset($invoice_data['zipcode']) && $invoice_data['zipcode']!="" ? '<br>'.$invoice_data['zipcode'] :''; ?>
                            <br>Phone: <?php echo isset($invoice_data['mobile_phone']) && $invoice_data['mobile_phone']!="" ? $invoice_data['mobile_phone'] :''; ?>
                            <br>Email: <?php echo isset($invoice_data['user_email']) && $invoice_data['user_email']!="" ? $invoice_data['user_email'] : ''; ?>
                        </address>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-4 col-xs-12 mar-top8 invoice-col">
                        <b>Invoice #<?php echo isset($invoice_data['transaction_invoice_number']) && $invoice_data['transaction_invoice_number'] !="" ? $invoice_data['transaction_invoice_number'] : ''; ?></b>
                        <br>
                        <b>Transaction ID:</b>  <?php echo isset($invoice_data['transaction_number']) && $invoice_data['transaction_number'] !="" ? $invoice_data['transaction_number'] : ''; ?>
                        <br>
                        <b>Payment Due:</b> <?php echo date(DATE_FORMAT, strtotime($invoice_data['subscription_end_date'])); ?>

                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
                <!-- Table row -->
                <div class="row">
                    <div class="col-xs-12 table">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Sr.No</th>
                                    <th style="width: 77%">Product</th>
                                    <th style="text-align: right">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td><?php echo $invoice_data['transaction_description']; ?></td>


                                    <td style="text-align: right"><?php echo CURRENCY_SYMBOL . number_format($invoice_data['sub_total'],2); ?></td>
                                </tr>


                            </tbody>
                        </table>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
                <div class="row">
                    <!-- accepted payments column -->
                    <div class="col-xs-6 col-sm-8 invoice_total">
                        &nbsp;
                    </div>
                    <!-- /.col -->
                    <div class="col-xs-6 col-sm-4 invoice_total">
                        <p class="lead">Order Summary</p>
                        <div class="table-responsive">
                            <table class="table" >
                                <tbody>
                                <th style="width:50%;" >Sub Total</th>
                                <td align='right'>$<?php echo number_format($invoice_data['sub_total'],2); ?></td>
                                </tr>
                                <?php if(isset($invoice_data['discount_percentage']) && $invoice_data['discount_percentage'] > 0 ) { ?>
                                 <tr>
                                    <th style="width:50%;" >Discount ( - <?php echo $invoice_data['discount_percentage'];?>%) </th>
                                    <td align='right'><?php
                                    $GrandTotal = $invoice_data['sub_total'];
                                    $discountFigure = ($GrandTotal * $invoice_data['discount_percentage']) / 100;
                                    echo "- ".CURRENCY_SYMBOL . number_format($discountFigure,2); 
                                    ?>
                                    </td>
                                </tr>
                                <?php } ?>
                                
                                <?php if(isset($invoice_data['tax']) && $invoice_data['tax'] > 0 ) { ?>
                                <tr>
                                    <th style="width:50%;" >Sub Total</th>
                                    <td align='right'><?php echo isset($invoice_data['total_amount_after_discount']) && $invoice_data['total_amount_after_discount'] != "" ? CURRENCY_SYMBOL.number_format($invoice_data['total_amount_after_discount'],2) : CURRENCY_SYMBOL . '0.00'; ?></td>
                                </tr>
                                <tr>
                                    <th style="width:50%;" >Tax @ <?php echo number_format($invoice_data['tax'],2); ?>% </th>
                                    <?php
                                     $taxFigure = ($total * $invoice_data['tax']) / 100;                                 
                                    $total = $total + $taxFigure;
                                    ?>
                                    <td align='right'><?php echo CURRENCY_SYMBOL.number_format($taxFigure,2); ?></td>
                                </tr>
                                
                                <?php
                                   
                                } ?>
                                <!--
                                <tr>
                                      <th>Shipping:</th>
                                      <td>N/A</td>
                                </tr>
                                -->
                                <tr>
                                    <th style="width:50%;"  >Total</th>
                                    <td align='right'>$<?php echo number_format($total,2); ?></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- /.col -->
                </div>
                <div class="row no-print">
                    <div class="col-xs-12">
<!--                        <button class="btn btn-default" onclick="window.print();"><i class="fa fa-print"></i> Print</button>-->
 <a href="<?php echo COMPANY_URL . 'download_invoice/' . $transaction_id; ?>" class="btn btn-primary pull-right" style="margin-right: 5px;"><i class="fa fa-download"></i> Download as PDF</a>
  <a href="<?php echo COMPANY_URL . 'invoices';?>" class="btn btn-primary pull-right" style="margin-right: 5px;"><i class="fa fa-arrow-left"></i> Back To List</a>
                       
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>