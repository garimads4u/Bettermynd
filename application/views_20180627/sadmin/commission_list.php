<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="sections-head">Commision</div>
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
            <table id="commissionlist" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Email Address</th>
                        <th>Paypal Email</th>
                        <th>Registered On</th>
                        <th>Commissionable Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($result) && count($result) > 0) {
                        $i=0;
                        foreach ($result as $value) {
                            echo "<tr>"
                            . "<td>" . ++$i . "</td>"
                            . "<td>" . $value->user_email . "</td>"
                            . "<td>" . (isset($value->paypal_email) && $value->paypal_email!="" ? $value->paypal_email : '-') . "</td>"
                            . "<td>" . date(DATE_FORMAT,  $value->user_createdon) . "</td>"
                            . "<td><a href='".SADMIN_URL."commissiondetail/".$value->sponsor."/".$list."'>" .CURRENCY_SYMBOL.' '. $value->commision_amt . "</a></td>"
                            . "</tr>";
                        }
                    }
                    ?>

                </tbody>
            </table>
        </div>
    </div>

</div>

<script type="text/javascript">
                                       $(document).ready(function() {
       $('#commissionlist').DataTable( {
         dom: 'Bfrtip',
               buttons: [
          {  extend:'excel',
                        className:"btn btn-primary",
                        text:"Export to Excel",
                        id:"brnexportexcel"
                  }
       ],
	
       } );
} );
</script> 