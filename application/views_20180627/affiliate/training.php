<?php $images=array("jpeg",'jpg','png','gif');?>
<div class="col-md-12 col-sm-12 col-xs-12">
<div class="x_panel">
        <div class="x_content">
     <?php 
//     prd($steps,1);
     if(isset($steps) && count($steps)>0){ ?>
        <div class="row">
          <div class="col-sm-12 trainingDetails">
            
            
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                <?php
                $i=0;
                foreach($steps as $step){
                 ?>
              <div class="panel panel-default">
                  <div class="panel-heading" role="tab" id="step<?php echo $step['tstep_id'] ?>">
                  <h4 class="panel-title">
                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $step['tstep_id'] ?>" aria-expanded="true" aria-controls="collapse<?php echo $step['tstep_id'] ?>">
                      <?php echo $step['ts_title']; ?>
                    </a>
                  </h4>
                </div>
                  
                <div id="collapse<?php echo $step['tstep_id'] ?>" class="panel-collapse collapse <?php echo ($i==0)?'in':""; ?>" role="tabpanel" aria-labelledby="step<?php echo $step['tstep_id'] ?>">
                  <div class="panel-body">
                       <?php echo html_entity_decode($step['ts_description']);                       
                       if(isset($step['content']) && !empty($step['content'])){ 
                       ?>                                            
                      <div class="row">
                        <div class="col-sm-6">
                          <label>Attachments</label>                    
                        </div>
                      </div> <div class='row'>                    
                              <?php    
                               $j=0;
                      foreach($step['content'] as $content){
                          
                          $ext = pathinfo(FILE_UPLOAD_PATH.'training/'.$content['ts_mediapath'], PATHINFO_EXTENSION);                          
                          if(in_array($ext,$images)){
                              echo '<div class="col-sm-1">
                                    <div class="baner-1">
                                      <a class="downlod-link" target="_blank" href="'.FILE_UPLOAD_URL.'training/'.$content['ts_mediapath'].'"><span class="dLink"><i class="fa fa-download"></i></span></a>
                                    </div>
                                    </div>';
                          }  elseif($ext=='pdf') {
                              $pdfshow=FILE_UPLOAD_URL.'training/'.$content['ts_mediapath'];
                                   echo '<div class="col-sm-1">
                                    <div class="baner-1">                                    
                                        <a class="downlod-link" target="_blank" href="'.FILE_UPLOAD_URL.'training/'.$content['ts_mediapath'].'"><span class="dLink"><i class="fa fa-download"></i></span></a>
                                    </div>
                                    </div>';
                          }elseif($ext=='zip' || $ext=='rar') {
                              echo '<div class="col-sm-1">
                                    <div class="baner-1">                                    
                                        <a class="downlod-link" target="_blank" href="'.FILE_UPLOAD_URL.'training/'.$content['ts_mediapath'].'"><span class="dLink"><i class="fa fa-download"></i></span></a>
                                    </div>
                                    </div>';
                          }elseif($ext=='doc' || $ext=='docx' || $ext=='rtf') {
                              echo '<div class="col-sm-1">
                                    <div class="baner-1">                                    
                                        <a class="downlod-link" target="_blank" href="'.FILE_UPLOAD_URL.'training/'.$content['ts_mediapath'].'"><span class="dLink"><i class="fa fa-download"></i></span></a>
                                    </div>
                                    </div>';
                          }else{
                              echo '<div class="col-sm-1">
                                    <div class="baner-1">                                    
                                        <a class="downlod-link" target="_blank" href="'.FILE_UPLOAD_URL.'training/'.$content['ts_mediapath'].'"><span class="dLink"><i class="fa fa-download"></i></span><img src="'.IMAGES_URL.'document.png" width="50"></a>
                                    </div>
                                    </div>';
                          }
                    
                          $j++;
                      }
                      
                    ?>
                      </div>
                      <?php
                      }
                    ?>
                  </div>
                </div>
              </div>                    
               <?php 
               $i++;
                }
                ?>            
            </div>
          </div>
        </div>
        <?php
        }
        else {
                ?>
                <div class="alert alert-danger">Sorry No Training Material Available yet.</div>
                <?php
            }
         ?>
</div>
</div>
</div>