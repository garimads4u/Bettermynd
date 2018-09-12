<div class="col-md-3 left_col">
    <div class="scroll-view">
        <div class="navbar nav_title"> <a href="<?php echo SADMIN_URL; ?>" class="site_title"><img src="<?php echo ASSETS_URL; ?>images/logo-bettermynd-left.png" width="176" height="52"  alt=""/><img src="<?php echo ASSETS_URL; ?>images/1mob-view.png" class="logo-short"  alt=""/></a> </div>


        <!-- menu prile quick info -->
        <div class="profile">
            <div class="profile_pic">
                <?php if (isset($sidebar_data) && isset($sidebar_data['profile_photo']) && strlen($sidebar_data['profile_photo']) > 0) {
                    ?>
                    <img src="<?php echo IMAGE_VIEW_URL; ?>?image=/<?php echo $sidebar_data['profile_photo']; ?>&width=150&height=150&cropratio=1:1&doc_root=<?php echo urlencode(ASSETS_PATH . "profile_images/"); ?>" class="img-circle profile_img"/>
                    <?php
                } else {
                    ?>
                    <img src="<?php echo DEFAULT_PROFILE_PIC; ?>" alt="..." class="img-circle profile_img">
                <?php } ?></div>
            <div class="profile_info">
                <h2>
                    <?php
                    if (isset($sidebar_data) && isset($sidebar_data['username'])) {
                       $full_name = explode(' ', $sidebar_data['username']);
                            if (isset($full_name) && count($full_name) > 0) {
                                $fname = substr($full_name[0], 0, 10);
                                $lname = substr($full_name[1], 0, 10);
                                $name = ucwords((strlen($full_name[0]) > 10 ? $fname . '...' : $fname) . ' ' . (strlen($full_name[1]) > 10 ? $lname . '...' : $lname));
                            }
                            else{
                                $name = $sidebar_data['username'];
                            }
                            echo $name;
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


            </div>
        </div>
        <!-- /menu prile quick info -->
        <!-- sidebar menu -->
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">

          <div class="menu_section">
            <ul class="nav side-menu">
                <li class="<?php echo (isset($sidebar_data['is_active']) && $sidebar_data['is_active']=="dashboard" ? 'current-page' :'');?>"> <a href="<?php echo SADMIN_URL;?>dashboard" ><i class="fa fa-tachometer"></i> <span>Dashboard</span></a></li>
                <li class="<?php echo (isset($sidebar_data['is_active']) && $sidebar_data['is_active']=="college" ? 'current-page' :'');?>"><a href="<?php echo SADMIN_URL;?>college" ><i class="fa fa-building"></i><span>Manage Colleges</span></a></li>
                <li class="<?php echo (isset($sidebar_data['is_active']) && $sidebar_data['is_active']=="counselors" ? 'current-page' :'');?>"><a href="<?php echo SADMIN_URL;?>counselors" ><i class="fa fa-binoculars"></i><span>Manage Counselors</span></a></li>
                <li class="<?php echo (isset($sidebar_data['is_active']) && $sidebar_data['is_active']=="students" ? 'current-page' :'');?>"><a href="<?php echo SADMIN_URL;?>students" ><i class="fa fa-graduation-cap"></i><span>Manage Students</span></a></li>

                <li class="<?php echo (isset($sidebar_data['is_active']) && $sidebar_data['is_active']=="transactions" ? 'current-page' :'');?>"><a href="<?php echo SADMIN_URL;?>transactions" ><i class="fa fa-money"></i><span>Transactions</span></a></li>

                 <li class="<?php echo (isset($sidebar_data['is_active']) && $sidebar_data['is_active']=="mailtemplates" ? 'current-page' :'');?>"><a href="<?php echo SADMIN_URL;?>mailtemplates" ><i class="fa fa-envelope-o"></i> <span>Mail Templates</span></a></li>
                   <li class="<?php echo (isset($sidebar_data['is_active']) && $sidebar_data['is_active']=="cmspages" ? 'current-page' :'');?>"><a href="<?php echo SADMIN_URL;?>cmspages" ><i class="fa fa-pencil-square-o"></i> <span>CMS Pages</span></a></li>
                   <li class="<?php echo (isset($sidebar_data['is_active']) && $sidebar_data['is_active']=="welcome" ? 'current-page' :'');?>"><a href="<?php echo SADMIN_URL;?>welcome" ><i class="fa fa-pencil-square-o"></i> <span>Welcome Note</span></a></li>
                   <li class="<?php echo (isset($sidebar_data['is_active']) && $sidebar_data['is_active'] == "manage_profile" ? 'current-page' : ''); ?>"><a href="<?php echo SADMIN_URL; ?>manage_profile" ><i class="fa fa-user"></i> <span>Manage Profile</span></a></li>
                     <li class="<?php echo (isset($sidebar_data['is_active']) && $sidebar_data['is_active']=="changepassword" ? 'current-page' :'');?>"><a href="<?php echo SADMIN_URL;?>changepassword" ><i class="fa fa-key"></i> <span>Change Password</span></a></li>

            </ul>

        <!-- /sidebar menu -->
    </div>
</div></div></div>