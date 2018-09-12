
<div class="col-md-3 left_col">
  <div class="scroll-view">
    <div class="navbar nav_title">
	<a href="<?php echo ADMIN_URL;?>" class="site_title">

      <?php

		 if(isset($sidebar_data) && isset($sidebar_data['logo'])){
		?>
      <img src="<?php echo ASSETS_URL."logo/".$sidebar_data['logo'];?>" width="176" height="52"  alt=""/>
      <img src="<?php echo ASSETS_URL."logo/".$sidebar_data['logo'];?>" width="41" height="42" class="logo-short"  alt=""/>
      <?php
		}else{
		?>
      <img src="<?php echo IMAGES_URL;?>logo-bettermynd-left.png" width="176" height="52"  alt="" />
       <img src="<?php echo ASSETS_URL;?>images/logo-short.png" width="41" height="42" class="logo-short"  alt=""/>
      <?php
		}
?>
       </a> </div>
    <div class="clearfix"></div>

    <!-- menu prile quick info -->
    <div class="profile">
      <div class="profile_pic">
        <?php if (isset($sidebar_data) && isset($sidebar_data['profile_photo']) && strlen($sidebar_data['profile_photo'])>0) {
                  ?>
        <img src="<?php echo IMAGE_VIEW_URL;?>?image=/<?php echo $sidebar_data['profile_photo'];?>&width=150&height=150&cropratio=1:1&doc_root=<?php echo urlencode(FILE_UPLOAD_PATH."upload/");?>" class="img-circle profile_img"/>
        <?php
              } else {
              ?>
        <img src="<?php echo DEFAULT_PROFILE_PIC;?>" alt="..." class="img-circle profile_img">
        <?php } ?>
      </div>
      <div class="profile_info">
        <h2>
          <?php
                if (isset($sidebar_data) && isset($sidebar_data['username'])) {
                    echo $sidebar_data['username'];
                }
                ?>
        </h2>
        <span>
        <?php
                if (isset($sidebar_data) && isset($sidebar_data['role_name'])) {
                    echo $sidebar_data['role_name'];
                }
                ?>
        </span>
        <p><img src="<?php echo ASSETS_URL;?>images/profile_music.png" width="108" height="18"  alt=""/></p>
        <div class="profile_count"> <span><strong><?php echo isset($_SESSION['total_logins']) ? $this->session->userdata('total_logins') :'0';?></strong>Logins</span><span><strong>0</strong>Created</span><span><strong>0</strong>Sent</span> </div>
      </div>
    </div>
    <!-- /menu prile quick info -->
    <!-- sidebar menu -->
    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
      <div class="menu_section">
        <ul class="nav side-menu">
          <?php if(isset($_SESSION['from_admin']) && $_SESSION['from_admin']=="1"){
					?>
          <li ><a href="<?php echo SADMIN_URL;?>redirecttoadmin"> Back To Super Admin</a></li>
          <?php
				}
				?>
          <li class="<?php echo (isset($sidebar_data['is_active']) && $sidebar_data['is_active']=="dashboard" ? 'current-page' :'');?>"><a href="<?php echo ADMIN_URL;?>dashboard"> 0Dashboard</a></li>
          <li class="<?php echo (isset($sidebar_data['is_active']) && $sidebar_data['is_active']=="invoices" ? 'current-page' :'');?>"><a href="<?php echo ADMIN_URL;?>invoices"> Invoices</a></li>
          <li class="<?php echo (isset($sidebar_data['is_active']) && $sidebar_data['is_active']=="profile" ? 'current-page' :'');?>"><a href="<?php echo ADMIN_URL;?>profile"> My Profile</a></li>
          <li class="<?php echo (isset($sidebar_data['is_active']) && $sidebar_data['is_active']=="message" ? 'current-page' :'');?>"><a href="<?php echo ADMIN_URL;?>message"> Messages</a></li>
          <!--<li class="<?php echo (isset($sidebar_data['is_active']) && $sidebar_data['is_active']=="changepassword" ? 'current-page' :'');?>"><a href="<?php echo ADMIN_URL;?>changepassword"> Change Password</a></li>-->
          <li class="<?php echo (isset($sidebar_data['is_active']) && $sidebar_data['is_active']=="users" ? 'current-page' :'');?>"><a href="<?php echo ADMIN_URL;?>users"> Users</a></li>
             <li class="<?php echo (isset($sidebar_data['is_active']) && $sidebar_data['is_active'] == "customtemplate" ? 'current-page' : ''); ?>"><a href="<?php echo COMPANY_URL; ?>createtemplate"> Create Templates</a></li>
          <li class="<?php echo (isset($sidebar_data['is_active']) && $sidebar_data['is_active']=="template" ? 'current-page' :'');?>"><a href="<?php echo ADMIN_URL;?>template"> Templates</a></li>
          <li class="<?php echo (isset($sidebar_data['is_active']) && $sidebar_data['is_active']=="email" ? 'current-page' :'');?>"><a href="<?php echo EMAIL_URL;?>inbox"> Messages</a></li>
        </ul>
      </div>
      <div class="menu_section">
        <a href="<?php echo ADMIN_URL;?>changepassword"><h3>Account Settings</h3></a>
      </div>
      <div class="footer_logo"><img src="<?php echo IMAGES_URL;?>powered.jpg" width="114" height="38"  alt=""/></div>
    </div>
    <!-- /sidebar menu -->
  </div>
</div>
