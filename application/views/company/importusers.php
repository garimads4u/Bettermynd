<?php
if(isset($csvpath) && strlen($csvpath)>0){
	
	 $handle = fopen($_FILES['importedcsv']['tmp_name'], "r");
         
 if (isset($user_company_id) && $user_company_id > 0) {
$c=0;
				  while (($data = fgetcsv($handle, 1500, ",")) !== FALSE) {
					  if(!$c || $c=="0"){
						 if($data[0] != "username")
						 {
							 $this->session->set_flashdata('error',"Error, 'username' column is missing.");
							redirect(COMPANY_URL."users");
							exit;
						 }
						  if($data[1] != "email")
						 {
							 $this->session->set_flashdata('error',"Error, 'user_email' column is missing.");
							redirect(COMPANY_URL."users");
							exit;
						 }
						 if($data[4] != "mobile phone")
						 {
							 $this->session->set_flashdata('error',"Error, 'mobile_phone' column is missing.");
							redirect(COMPANY_URL."users");
							exit;
						 }
						 if($data[6] != "state")
						 {
							 $this->session->set_flashdata('error',"Error, 'state' column is missing.");
							redirect(COMPANY_URL."users");
							exit;
						 }
						 if($data[7] != "zip code")
						 {
							 $this->session->set_flashdata('error',"Error, 'state' column is missing.");
							redirect(COMPANY_URL."users");
							exit;
						 }
						 if($data[2] != "fullname")
						 {
							 $this->session->set_flashdata('error',"Error, 'account_holder_name' column is missing.");
							redirect(COMPANY_URL."users");
							exit;
						 }
					  }
					 $dataarray[$c]['username']=$data[0];
					 $dataarray[$c]['user_email']=$data[1];
					 
					 $dataarray[$c]['user_company_id']=$user_company_id;
					 $dataarray[$c]['user_status']='0';
					 
					 $dataarray[$c]['user_createdon']=time();
					 $dataarray[$c]['user_role']='3';
					 
					 $dataarray[$c]['office_phone']=$data[3];
					 $dataarray[$c]['mobile_phone']=$data[4];
					 
					 $dataarray[$c]['address']=$data[5];
					 $dataarray[$c]['state']=$data[6];
					 
					 $dataarray[$c]['zipcode']=$data[7];
					 $dataarray[$c]['website']=$data[8];

					 
					 $dataarray[$c]['fax_number']=$data[9];
					 $dataarray[$c]['biography']=$data[10];
					 
					 $dataarray[$c]['fb_url']=$data[11];
					 $dataarray[$c]['twitter_url']=$data[12];
					 
					 $dataarray[$c]['linkedin_url']=$data[13];
					 $dataarray[$c]['youtube_url']=$data[14];
					 
					 $dataarray[$c]['account_holder_name']=$data[2];
					 
					$c++;				 
				  }
	
	if(count($dataarray)>1){
	$count=0;
?>

<div class="x_panel">
  <div class="x_content text-right"> <a href="<?php echo COMPANY_URL.'users';?>" class="btn btn-primary"><i class="fa fa-arrow-left"></i>&nbsp;Back to Users</a> </div>
</div>
<div class="clearfix"></div>
<div class="x_panel">
  <div class="x_content">
    <div class="progress hide" id="progress">
      <div class="progress-bar" id="progressbar" role="progressbar" aria-valuenow="00" aria-valuemin="0" aria-valuemax="100" > <span id="progress_bar"></span> </div>
    </div>
    <div class="clear"></div>
    <script type="text/javascript">
				 if($("#progress").hasClass("hide")){
					 $("#progress").removeClass("hide");
					 $("#progressbar").attr("aria-valuemax","<?php echo count($dataarray);?>");
				 }
				 </script>
    <table id="importingtable" class="table table-striped table-bordered">
      <thead>
        <tr>
          <th>Import Status</th>
        </tr>
      </thead>
      <tbody>
        <?php
	foreach($dataarray as $data){
			if($count>0){
				
				if((strlen($data['username'])>0) && strlen($data['user_email'])>0){
				
				$check=$this->basic_model->checkIfValid($data['username'],$data['user_email']);
				if($check=="ok"){
					$check = $this->basic_model->checkIfUserExists($data['username'],$data['user_email']);
					if($check==2){
								$result=$this->basic_model->import_user($data);
								if(isset($result) && $result>0){
									$this->basic_model->resend_activation_bulk($result);
									?>
        <tr>
          <td><p style="color:green !important;"><?php echo $data['username']." Imported Successfully.";?></p></td>
        </tr>
        <?php
										$ccd=(($count/(count($dataarray)-1))*100)."%";
									?>
        <script type="text/javascript">
					$("#progress_bar").text('<?php echo $count."/".(count($dataarray)-1)." Processed.";?>');                            $("#progressbar").css("width","<?php echo $ccd;?>");
                            </script>
        <?php
									
								}
					}
					else{
						?>
        <tr>
          <td><p style="color:red !important;"><?php echo $data['username']." Already Exists.";?></p></td>
        </tr>
        <?php
									$ccd=(($count/(count($dataarray)-1))*100)."%";
									?>
        <script type="text/javascript">
					$("#progress_bar").text('<?php echo $count."/".(count($dataarray)-1)." Processed.";?>');
                            $("#progressbar").css("width","<?php echo $ccd;?>");
                            </script>
        <?php
									
					}
				}
				else{
					?>
        <tr>
          <td><p style="color:red !important;"><?php echo "Error in importing ".$data['username']." - ".$check;?></p></td>
        </tr>
        <?php
										$ccd=(($count/(count($dataarray)-1))*100)."%";
									?>
        <script type="text/javascript">
					$("#progress_bar").text('<?php echo $count."/".(count($dataarray)-1)." Processed.";?>');                            $("#progressbar").css("width","<?php echo $ccd;?>");
                            </script>
        <?php
									
				}
				}

			}
			else{
				if(($data['username']  != "username") || ($data['user_email']  != "email")){
					$this->session->set_flashdata("error","Invalid csv file");
					redirect(COMPANY_URL."users");
					}
			}
	$count++;
	}
	?>
      </tbody>
    </table>
    <script type="text/javascript">
					$(document).ready(function() {
	$('#importingtable').DataTable( {
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
  </div>
</div>
<?php
	}
	
 }
}
	 ?>
