<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="sections-head">Commision Detail</div>
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
        <div class="x_content" id='source'>
         <a id="backbtn" class="btn btn-primary" href="<?php echo $backurl;?>"><i class="fa fa-arrow-left"></i> Back</a>
        </div>
            <table id="commissiondetail" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>User id</th>
                        <th>User Type</th>
                        <th>Percentage</th>
                        <th>Net Amount</th>
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
                            . "<td>" . $value->username . "</td>"
                            . "<td>" . $value->user_roles_name . "</td>"
                            . "<td>" . $value->percentage . " %</td>"
                            . "<td>" .CURRENCY_SYMBOL.' '. $value->net_amount . "</td>"
                            . "<td>" .CURRENCY_SYMBOL.' '. $value->commision_amount . "</td>"
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
     
	$('#commissiondetail').DataTable({
          dom: 'Bfrtip',
		buttons: [
           {  extend:'excel',
			 className:"btn btn-primary",
			 text:"Export to Excel",
			 id:"brnexportexcel"
		   }
        ],
	
        });
          
} );
				</script> 