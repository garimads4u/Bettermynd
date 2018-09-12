<div class="col-md-3 left_col">
    <div class="scroll-view">
        <div class="navbar nav_title"> <a href="<?php echo THIRD_PARTY_URL; ?>" class="site_title"><img src="<?php echo ASSETS_URL; ?>images/logo-bettermynd-left.png" width="176" height="52"  alt=""/><img src="<?php echo ASSETS_URL; ?>images/1mob-view.png" class="logo-short"  alt=""/></a> </div>
        <!-- menu prile quick info -->
        <div class="profile">
            <div class="profile_pic"> 
                <a href="<?php echo THIRD_PARTY_URL . "view_profile" ?>">
                    <?php if (isset($sidebar_data) && isset($sidebar_data['profile_photo']) && strlen($sidebar_data['profile_photo']) > 0) {
                        ?>
                        <img src="<?php echo IMAGE_VIEW_URL; ?>?image=/<?php echo $sidebar_data['profile_photo']; ?>&width=150&height=150&cropratio=1:1&doc_root=<?php echo urlencode(PROFILE_FILE_UPLOAD_PATH); ?>" class="img-circle profile_img"/>
                        <?php
                    } else {
                        ?>
                        <img src="<?php echo DEFAULT_PROFILE_PIC; ?>" alt="..." class="img-circle profile_img"> 
                    <?php } ?>
                </a>
            </div>
            <div class="profile_info">
                <a href="<?php echo THIRD_PARTY_URL . "view_profile" ?>">
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
                </a>
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
                    <?php if (isset($_SESSION['from_admin']) && $_SESSION['from_admin'] == "1") {
                        ?>
                        <li ><a href="<?php echo THIRD_PARTY_URL; ?>redirecttoadmin"><i class="fa fa-hand-o-left"></i><span> Back To Super Admin</span></a></li>
                        <?php
                    }
                    ?>
                    <li class="<?php echo (isset($sidebar_data['is_active']) && $sidebar_data['is_active'] == "dashboard" ? 'current-page' : ''); ?>"><a href="<?php echo THIRD_PARTY_URL; ?>dashboard" ><i class="fa fa-tachometer"></i> <span>Dashboard</span></a></li>
                    <li class="<?php echo (isset($sidebar_data['is_active']) && $sidebar_data['is_active'] == "availability" ? 'current-page' : ''); ?>"><a href="<?php echo THIRD_PARTY_URL; ?>availability" ><i class="fa fa-calendar"></i> <span>Availability</span></a></li>
                    <li class="<?php echo (isset($sidebar_data['is_active']) && $sidebar_data['is_active'] == "manage_profile" ? 'current-page' : ''); ?>"><a href="<?php echo THIRD_PARTY_URL; ?>manage_profile" ><i class="fa fa-user"></i> <span> Manage Profile</span></a></li>
                    <li class="<?php echo (isset($sidebar_data['is_active']) && $sidebar_data['is_active'] == "change_password" ? 'current-page' : ''); ?>"><a href="<?php echo THIRD_PARTY_URL; ?>change_password" ><i class="fa fa-key"></i> <span>Change Password</span></a></li>
                    
                </ul>
            </div>
          <!--  <div class="menu_section">
                <a href="#"><h3>Account Settings</h3></a>
            </div>-->

        </div>
        <!-- /sidebar menu --> 
    </div>
</div>