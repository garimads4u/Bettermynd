<!-- Header -->
<header class="header headerContainerWrapper">
    <div class="container">
        <div class="row">
            <div class="col-sm-4">

                <h1 class="logo">
                    <a title="BetterMynd" href="<?php echo SITE_URL; ?>">
                        <img alt="BetterMynd" class="larg-log" src="<?php echo IMAGES_URL; ?>logo.png">
                    </a>
                </h1>
            </div>
            <div class="col-sm-8">
                <!--Menu HTML Code-->
                <nav class="navbar navbar-default">
                    <div class="container-fluid padd0">
                        <!-- Brand and toggle get grouped for better mobile display -->
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                        </div>

                        <!-- Collect the nav links, forms, and other content for toggling -->

                        <div class="collapse navbar-collapse padd0" id="bs-example-navbar-collapse-1">
                            <ul class="nav navbar-nav">
                                <li><a href="<?php echo SITE_URL; ?>">Home</a></li>
                                <li><a href="<?php echo SITE_URL; ?>aboutus">About us</a></li>
                                <li><a href="<?php echo SITE_URL; ?>services">Services</a></li>
                                <!-- <li><a href="#">Pricing</a></li>
                                   <li><a href="#">Appointments</a></li> -->
                                <li><a href="<?php echo SITE_URL; ?>contact">Contact us</a></li>
                            </ul>
                            <div class="btn-header pull-right dropdown">
                                <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] > 0) { ?>

                                    <?php if ($_SESSION['user_type'] == '4') { ?>
                                        <a class="btn btn-login" href="<?php echo PATIENT_URL . "dashboard"; ?>">My Account</a>
                                    <?php } else if ($_SESSION['user_type'] == '2') { ?>
                                        <a class="btn btn-login" href="<?php echo COLLEGE_URL . "dashboard"; ?>">My Account</a>
                                    <?php } else if ($_SESSION['user_type'] == '3') { ?>
                                        <a class="btn btn-login" href="<?php echo PROVIDER_URL . "dashboard"; ?>">My Account</a>
                                    <?php } else if ($_SESSION['user_type'] == '5') { ?>
                                        <a class="btn btn-login" href="<?php echo THIRD_PARTY_URL . "dashboard"; ?>">My Account</a>
                                    <?php } else if ($_SESSION['user_type'] == '1') { ?>
                                        <a class="btn btn-login" href="<?php echo SADMIN_URL . "dashboard"; ?>">My Account</a>
                                    <?php } else { ?>
                                        <a class="btn btn-login" href="<?php echo SITE_URL; ?>">My Account</a>
                                    <?php } ?>

                                <?php } else { ?>

                                    <a href="<?php echo SITE_URL; ?>login" class="btn btn-login">Log in</a>
                                    <button data-toggle="dropdown" type="submit" class="btn btn-register ">Register <b class="caret"></b></button>
                                    <ul aria-labelledby="dLabel" class="dropdown-menu">

                                        <li><a href="<?php echo SITE_URL; ?>signup/patient">College Student</a></li><li role="separator" class="divider"></li>
                                        <li><a href="<?php echo SITE_URL; ?>signup/provider">College Counselor</a></li><li role="separator" class="divider"></li>
                                        <li><a href="<?php echo SITE_URL; ?>signup/third_party">Third-Party Counselor</a></li>
                                        <!--                                    <li role="separator" class="divider"></li>
                                                                            <li><a href="<?php echo SITE_URL; ?>signup/college">College</a></li>-->

                                    </ul>

                                <?php } ?>
                            </div>
                        </div><!-- /.navbar-collapse -->
                    </div><!-- /.container-fluid -->
                </nav>
                <!--Menu HTML Code-->
            </div>
        </div>
        <div class="clr"></div>
    </div>
</div>
</header>
<div class="clear"></div>