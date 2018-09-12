<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="sections-head">Manage Payout</div>
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
    <div class="">
    <div class="x_panel">
       
        <div class="col-md-6">
             <h4>Pending Payouts</h4>
            <table class="table table-striped table-bordered payout_tbl">
                <thead>
                      <tr>
                        <th>#</th>
                        <th>Month</th>
                        <th>View</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                   <?php
                    $j = 1;
                    foreach ($pending_payouts as $key => $value) {
                        $month = date("m", strtotime($value));
                        $year = date("Y", strtotime($value));
                        $str = $month . '-' . $year;
                        echo "<tr><td>" . $j++ . "</td><td>" . date('F Y', strtotime($value)) . "</td><td><a href='".SADMIN_URL."commissionlist/" . $str . "'>View</a></td><td class=\"text-center\"> <a title='Click to generate' href='".SADMIN_URL.'commision/'.$str."'><i class='fa fa-area-chart' style='color:red'></i></a>  <a title='Click to Approve' href='".SADMIN_URL.'/approvedpayout/' . $key . "'><i class='fa fa-ban' style='color:red'></i></a></td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
        
         <div class="col-md-6">
             <h4>Paid Payouts</h4>
            <table  class="table table-striped table-bordered payout_tbl">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Month</th>
                        <th>View</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                           if(count($paid_payouts)>0)
                           {
							   $j=1;
                         foreach($paid_payouts as $paid){
                              $month=date("m",strtotime($paid->generate_date));
                                     $year=date("Y",strtotime($paid->generate_date));
                                     $str=$month.'-'.$year;
                        echo "<tr><td  class=\"text-center\">".$j++."</td><td>". date('F Y', strtotime($paid->generate_date)). "</td><td><a href='".SADMIN_URL."commissionlist/" . $str . "'>View</a></td><td class=\"text-center\"><i class='fa fa-check-circle' style='color:green'></i></td></tr>";      
                         }
                           }
                           else
                           {
                         echo "<tr><td colspan='5'>No Paid Payouts in Record</td></tr>";            
                           }
                        ?>
                </tbody>
            </table>
        </div>
    </div>
    </div>

</div>
<script>

    $(document).ready(function () {
        $('.payout_tbl').DataTable({
            "sDom": '<"row view-filter"<"col-sm-12"<"pull-left"l><"pull-right"f><"clearfix">>>t<"row view-pager"<"col-sm-12"<"text-center"ip>>>',
            'fnDrawCallback' : function(e) {
                $('input.flat').iCheck({
                 radioClass: 'iradio_flat-blue'
                });
        
             },
            "ordering": false,
            "bFilter": false,
            "bInfo":false,
            "bLengthChange": false,
            "pagingType" :"simple_numbers"
           
        });
        
        
    });
</script>