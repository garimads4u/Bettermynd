<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>pdf invoice</title>
<style>

	body{
	color: #777;
    background: #fff;
    padding-top: 8px;
    font-family: Arial, sans-serif;
    font-size: 11px;
    font-weight: 400;
    line-height: 1.771;
	    overflow-x: hidden;
		    margin: 0;
	}
	*, *:before, *:after {
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
}
#page-wrap { width: 800px; margin: 0 auto; }
.content {
    padding-right: 15px;
    padding-left: 15px;
    margin-right: auto;
    margin-left: auto;
}
	address {
    margin-bottom: 20px;
    font-style: normal;
    line-height: 1.42857143;
}
.pull-right {
    float: right;
}
.pull-left {
    float: left;
}
.row:after, .row:before {
    display: table;
    content: " ";
    clear: both;
}
.row {
    margin-right: -15px;
    margin-left: -15px;
}
.col-xs-1, .col-xs-10, .col-xs-11, .col-xs-12, .col-xs-2, .col-xs-3, .col-xs-4, .col-xs-5, .col-xs-6, .col-xs-7, .col-xs-8, .col-xs-9 {
    float: left;
	    position: relative;
    min-height: 1px;
    padding-right: 15px;
    padding-left: 15px;
}
.col-xs-12 { width: 100%} 
.col-xs-11 { width: 91.66666667% }
.col-xs-10 { width: 83.33333333% }
.col-xs-9 { width: 75% }
.col-xs-8 {	width: 66.66666667%}
.col-xs-7 {	width: 58.33333333%}
.col-xs-6 {	width: 50%}
.col-xs-5 {	width: 41.66666667%}
.col-xs-4 {	width: 33.33333333%}
.col-xs-3 {	width: 25%}
.col-xs-2 {	width: 16.66666667%}
.col-xs-1 {	width: 8.33333333%}
.lead {    margin-bottom: 20px;
    font-size: 20px;
    font-weight: 300;
    line-height: 1.4;
}

    body{margin-left:2em; margin-right:2em;}
    .page{
    height:947px;
    padding-top:5px;
    page-break-after : always;   
    font-family: Arial, Helvetica, sans-serif;
    position:relative;
   border-bottom:1px solid #000;

  }
  
table { 
		width: 100%; 
		border-collapse: collapse; 
	}
	/* Zebra striping */
	.table thead tr:nth-of-type(even) { 
		background: #eee; 
	}
   
.table thead tr th {
    border-bottom: 2px solid #ddd;
    vertical-align: bottom;
	color: #6a6c6f;
    padding: 14px 8px;
	border-top: 1px solid #ddd;
	text-align: left;
}

.table tbody tr td{
    padding: 8px;
}
.table tbody tr td, .table tbody tr th{
    border-top: 1px solid #ddd;
    line-height: 1.52857;
    vertical-align: top;
}
.invoice-col{width:250px; float:left; padding:10px 15px; margin:15px; line-height:28px; }
.invoice-col address{line-height:28px; }
.total_box{float:right; width:290px;}
.date_right{ font-size:14px; text-align:right}
</style>
</head>
<body>
<?php
$total = $invoice_data['total_amount_after_discount'];
?>

<div id="page-wrap">
<div class="content">
			<!-- title row -->
			<div class="row">
			  <div class="col-xs-12">
			  <table>
				<tr><td><h1><img src="<?php echo IMAGES_URL;?>logo_png.png"></h1></td>
				<td class="date_right">Date:  <?php echo date(DATE_FORMAT, strtotime($invoice_data['transaction_date'])); ?></td>
				</tr>
			  </table>
						
			  </div>
			  <!-- /.col -->
			</div>
			<table>
				<tr><td colspan="3">&nbsp;</td></tr>
				<tr><td><div class="invoice-col" style="line-height:55pt; ">
				From
				<address>
                            <strong>Marketing Technologists</strong>
                            <br>4759 LAKEMONT BLVD SE, STE C-4 #360
                            <br>Bellevue, WA 98006
                            <br>Phone: 206-940-3648
                            <br>Email: support@brandize.com
                        </address>
			  </div></td>
				<td><div class="invoice-col" style="line-height:55pt;">
				To
				 <address>
                            <strong><?php echo isset($invoice_data['account_holder_name']) && $invoice_data['account_holder_name']!="" ? $invoice_data['account_holder_name'] : ''; ?></strong>
                            <?php echo isset($invoice_data['address']) && $invoice_data['address']!="" ? '<br>'.$invoice_data['address'] :''; ?>
                            <?php echo isset($invoice_data['state']) && $invoice_data['state']!="" ? '<br>'.$invoice_data['state'] :''; ?> <?php echo isset($invoice_data['zipcode']) && $invoice_data['zipcode']!="" ? '<br>'.$invoice_data['zipcode'] :''; ?>
                            <br>Phone: <?php echo isset($invoice_data['mobile_phone']) && $invoice_data['mobile_phone']!="" ? $invoice_data['mobile_phone'] :''; ?>
                            <br>Email: <?php echo isset($invoice_data['user_email']) && $invoice_data['user_email']!="" ? $invoice_data['user_email'] : ''; ?>
                        </address>
			  </div></td>
				<td><div class="invoice-col" style="line-height:55pt;">
					<b>Invoice #<?php echo  $invoice_data['transaction_invoice_number']; ?></b>
				<br>
				<b>Transaction ID:</b>  <?php echo isset($invoice_data['transaction_number']) && $invoice_data['transaction_number'] !="" ? $invoice_data['transaction_number'] : ''; ?>
				<br>
				<b>Payment Due:</b> <?php echo date(DATE_FORMAT, strtotime($invoice_data['subscription_end_date'])); ?>
				
			  </div></td>
				</tr>
				<tr><td colspan="3">&nbsp;</td></tr></table>
			
			<!-- Table row -->
			<div class="row">
			  <div class="col-xs-12">
				<table class="table">
				  <thead>
					<tr >
					  <th style="padding:14px 10px;text-align:left;">Sr.No</th>
					  <th style="padding:14px 10px;text-align:left;">Product</th>
					  <th style="padding:14px 10px;text-align:right;">Total</th>
					</tr>
				  </thead>
				  <tbody>
					<tr style="background-color: #f9f9f9;">
					  <td>1</td>
					  <td><?php echo $invoice_data['transaction_description']; ?></td>
					  <td align='right'><?php echo CURRENCY_SYMBOL.number_format(($invoice_data['total_amount_after_discount']),2); ?></td>
					</tr>
					
					
				  </tbody>
				</table>
			  </div>
			  <!-- /.col -->
			</div>

		  <!-- /.col -->
			  <div class="total_box">
				<p class="lead text-right">Order Summary</p>
			<div class="table-responsive">
				  <table class="table">
					<tbody>
					  <tr>
						<th style="width:50%;text-align:right !important; vertical-align:middle">Sub Total</th>
						<td align='right'><?php echo CURRENCY_SYMBOL. number_format($invoice_data['sub_total'],2); ?></td>
					  </tr>
                                           <?php if(isset($invoice_data['discount_percentage']) && $invoice_data['discount_percentage'] > 0 ) { ?>
                                 <tr>
                                    <th style="width:50%;text-align:right !important; vertical-align:middle" >Discount ( - <?php echo $invoice_data['discount_percentage'];?>%) </th>
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
                                    <th style="width:50%;text-align:right !important; vertical-align:middle" >Sub Total</th>
                                    <td align='right'><?php echo isset($invoice_data['total_amount_after_discount']) && $invoice_data['total_amount_after_discount'] != "" ? CURRENCY_SYMBOL.number_format($invoice_data['total_amount_after_discount'],2) : CURRENCY_SYMBOL . '0.00'; ?></td>
                                </tr>
                                <tr>
                                    <th style="width:50%;text-align:right !important; vertical-align:middle" >Tax @ <?php echo number_format($invoice_data['tax'],2); ?>% </th>
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
                                    <th style="width:50%;text-align:right !important; vertical-align:middle" > Grand Total</th>
                                    <td align='right'>$<?php echo number_format($total,2); ?></td>
                                </tr>
					</tbody>
				  </table>
				</div>
			  </div>
			  <!-- /.col -->

		  </div>
</div>
</body>
</html>
