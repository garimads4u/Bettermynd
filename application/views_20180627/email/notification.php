<div class="col-md-12 col-sm-12 col-xs-12">
<style>#notification_list .mail_list{border-bottom:0px; margin-bottom:0px;} #notification_list .mail_list p{ margin-bottom:0px; }</style>
  <!-- Tab panes -->
<div class="x_panel">
            <div class="x_content">
                    <div class="row">
                    <div class="col-sm-12">
                   <?php if(isset($notification) && !empty($notification) && count($notification)>0){ ?>
                        
                
                 <table id="notification_list" class="table table-striped table-bordered">
        <thead>
          <tr>
            <th><h2>System Notification</h2></th>
          </tr>
        </thead>
                
                  <tbody>   
    <?php 
      			 foreach($notification as $val){  
                         $n_u_id = $this->encrypt->encode($val->id);
                         $n_u_id = str_replace(array('+', '/', '='), array('-', '_', '~'), $n_u_id)
                                 ?><tr><td>
                  <div class="mail_list">
                      <h3><small><?php echo date("m/d/Y h:i A",strtotime($val->added));?></small></h3>
                      <p>
                          <?php if($val->read_status==1) {?>
                          <a href="<?php echo TEMPLATE_URL.$val->url.'/'.$n_u_id; ?>" style="text-decoration: none;"><?php echo $val->notification_msg; ?></a>
                          <?php }else{ ?>
                          <strong><a href="<?php echo TEMPLATE_URL.$val->url.'/'.$n_u_id; ?>" style="text-decoration: none;"><?php echo $val->notification_msg; ?></a></strong>
                          <?php }?>
                      </a>
                      </p>
                       </div></td></tr>
                    <?php   } ?>
                  </tbody>
      </table>             
                              
                    <?php }else{ ?>
                        <table class="table table-striped table-bordered"><tr><td>   
                    <div class="col-sm-12 col-md-offset-5">                        
                        No record found.
                    </div> </td></tr></table> 
                <?php } ?>
                </div> 
                </div>
                <!-- /CONTENT MAIL --> 
              </div>
            </div>
</div>
<script language="javascript">
 $(document).ready(function () {
                $('#notification_list').dataTable({
				 "aoColumns": [
            { "asSorting": [ "desc", "asc" ] }, //first sort desc, then asc
        ]
				});
 });
</script>