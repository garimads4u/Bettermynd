<?php
if(isset($csvpath) && strlen($csvpath)>0){
	
	 $handle = fopen($_FILES['importedcsv']['tmp_name'], "r");
 if (isset($user_company_id) && $user_company_id > 0) {
$c=0;
				  while (($data = fgetcsv($handle, 1500, ",")) !== FALSE) {
				if($c==0){
					if(isset($data[0]) && isset($data[1]) && isset($data[2]) && isset($data[3]) && isset($data[4]) && isset($data[5]) && isset($data[6]) && isset($data[7]) && isset($data[8]) && isset($data[9]) && isset($data[10]) && isset($data[11]) && isset($data[12]) && isset($data[13]) && isset($data[14]))
					{
						if(($data[0] != "username") || ($data[1] != "email")){
							$this->session->set_flashdata("error","Invalid CSV File");
						redirect(ADMIN_URL."users");
							}
						
					}
					else{
						$this->session->set_flashdata("error","Invalid CSV File");
						redirect(ADMIN_URL."users");
						
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
    <table cellpadding="0" cellspacing="0" class="table table-bordered" id="importingtable">
    <thead>
    <tr>
    <th>#</th>
    	<th>Result</th>
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
									
									?>
      <tr>
      <td><?php echo $count+1;?></td>
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
            <td><?php echo $count+1;?></td>
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
      <td><?php echo $count+1;?></td>
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
	$("#importingtable").DataTable();
	</script>
  </div>
</div>
<?php
	}
	
 }
}
	 ?>
