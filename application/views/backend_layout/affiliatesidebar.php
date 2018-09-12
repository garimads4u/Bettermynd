<div class="col-md-3 left_col">
    <div class="scroll-view">
        <div class="navbar nav_title"> <a href="<?php echo COMPANY_URL; ?>" class="site_title"><img src="<?php echo ASSETS_URL; ?>images/logo-bettermynd-left.png" width="176" height="52"  alt=""/><img src="<?php echo ASSETS_URL; ?>images/logo-short.png" width="41" height="42" class="logo-short"  alt=""/></a> </div>
        <div class="clearfix"></div>

        <!-- menu prile quick info -->
        <div class="profile">
            <div class="profile_pic">
                <?php if (isset($sidebar_data) && isset($sidebar_data['profile_photo']) && strlen($sidebar_data['profile_photo']) > 0) {
                    ?>
                    <img src="<?php echo IMAGE_VIEW_URL; ?>?image=/<?php echo $sidebar_data['profile_photo']; ?>&width=150&height=150&cropratio=1:1&doc_root=<?php echo urlencode(FILE_UPLOAD_PATH . "upload/"); ?>" class="img-circle profile_img"/>
                    <?php
                } else {
                    ?>
                    <img src="<?php echo DEFAULT_PROFILE_PIC; ?>" alt="..." class="img-circle profile_img">
                <?php } ?></div>
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
                <?php /* ?> <p><img src="<?php echo ASSETS_URL;?>images/profile_music.png" width="108" height="18"  alt=""/></p><?php */ ?>
                <?php /* ?> <div class="profile_count"> <span><strong>260</strong>Logins</span><span><strong>104</strong>Created</span><span><strong>200</strong>Sent</span> </div><?php */ ?>
            </div>
        </div>
        <!-- /menu prile quick info -->
        <!-- sidebar menu -->
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
                <ul class="nav side-menu">
                    <li class="<?php echo (isset($sidebar_data['is_active']) && $sidebar_data['is_active'] == "dashboard" ? 'current-page' : ''); ?>"><a href="<?php echo AFFILIATE_URL; ?>dashboard"> Dashboard</a></li>
                    <li class="<?php echo (isset($sidebar_data['is_active']) && $sidebar_data['is_active'] == "profile" ? 'current-page' : ''); ?>"><a href="<?php echo AFFILIATE_URL; ?>profile"> My Profile</a></li>
                    <!--<li class="<?php echo (isset($sidebar_data['is_active']) && $sidebar_data['is_active'] == "changepassword" ? 'current-page' : ''); ?>"><a href="<?php echo AFFILIATE_URL; ?>changepassword"> Change Password</a></li>-->
                    <li class="hide <?php echo (isset($sidebar_data['is_active']) && $sidebar_data['is_active'] == "referrels" ? 'current-page' : ''); ?>"><a href="<?php echo AFFILIATE_URL; ?>referrels"> Referral</a></li>
                    <li class="<?php echo (isset($sidebar_data['is_active']) && $sidebar_data['is_active'] == "commission" ? 'current-page' : ''); ?>"><a href="<?php echo AFFILIATE_URL; ?>commission"> Commission Summary</a></li>
                    <li class="<?php echo (isset($sidebar_data['is_active']) && $sidebar_data['is_active'] == "training" ? 'current-page' : ''); ?>"><a href="<?php echo AFFILIATE_URL; ?>training"> Training</a></li>
                </ul>
            </div>
            <div class="menu_section">
                <a href="<?php echo AFFILIATE_URL; ?>changepassword"><h3>Account Settings</h3></a>
            </div>
            <div class="footer_logo"><img src="<?php echo IMAGES_URL; ?>powered.jpg" width="114" height="38"  alt=""/></div>
        </div>
        <!-- /sidebar menu -->
    </div>
</div>