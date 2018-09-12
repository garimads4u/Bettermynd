<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="sections-head">Company List</div>
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
                        <th>Mobile Phone</th>
                        <th>Zip Code</th>
                         <th>Coupon Used</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($company_list) && !empty($company_list) && count($company_list) > 0) {
                        foreach ($company_list as $value) {
                            if ($value->user_status == 1) {
                                $checked = "checked='checked'";
                            } else {
                                $checked = "";
                            }
                            $locationStr = '';
                            if(isset($value->state) && !empty($value->state)) 
                            {
                                $locationStr = $value->state.' ';                                
                            }
                            if(isset($value->zipcode) && !empty($value->zipcode)) 
                            {
                                 $locationStr = $value->zipcode;    
                            }
                            echo "<tr>"
                            . "<td>" . $value->username . "</td>"
                            . "<td><a href='mailto:".$value->user_email."'>" . $value->user_email . "</a></td>"
                            . "<td class='nowrap'>" . $value->mobile_phone . "</td>"
                            . "<td>" .$locationStr. "</td>"
							. "<td>" .$this->basic_model->if_coupon_used($value->user_id). "</td>"
                            . "<td> <label class='switch-lbl'> <input type='checkbox' " . $checked . " id='u_id_".$value->user_id."' name='status_".$value->user_id."' data-status='".$value->user_status."' class='js-switch user_status' value='$value->user_id' /> </label></td>"
                            . "<td><a href='".SADMIN_URL."userprofile/".$value->user_id."' class='label label-danger'>EDIT</a> <a href='".SADMIN_URL."company_transaction/".base64_encode($value->user_id)."' class='label label-success'>Transaction</a>&nbsp;<a href='".SADMIN_URL."redirecttocompany/".base64_encode($value->user_id)."' class='label logincompany label-success'>Login</a> </td>"
                            . "</tr>";
                        }
                    }
                    ?>

                </tbody>
            </table>
        </div>
    </div>

</div>