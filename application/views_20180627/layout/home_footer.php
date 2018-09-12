<!-- FOOTER -->
<footer class="footer">
    <div class="footer1">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="ftr-logo"><img src="<?php echo SITE_URL; ?>assets/images/logo.png" alt=""/></div>
                    <p>BetterMynd is on a mission to improve the mental health of college students everywhere.
                    </p>
                </div>
                <div class="col-md-3">
                    <h4 >Learn More</h4>
                    <!--                        <h4 >Industries We Serve</h4>-->
                    <ul class="">
                        <li><a href="<?php echo SITE_URL; ?>aboutus"><i class="fa fa-angle-right"></i> About Us</a></li>
                        <li><a href="<?php echo SITE_URL; ?>services"><i class="fa fa-angle-right"></i> Services</a></li>
                        <!--   <li><a href=""><i class="fa fa-angle-right"></i> Pricing & Plans</a></li> -->
                        <li><a href="<?php echo SITE_URL; ?>contact"><i class="fa fa-angle-right"></i> Contact Us</a></li>
<!--                            <li><a href="javascript:void(0);"><i class="fa fa-angle-right"></i> Sitemap</a></li>-->
                    </ul>
                </div>
                <div class="col-md-3 ">
                    <h4 >About Better Mynd</h4>
                    <p>Through our network of providers and the power of teletherapy, BetterMynd is empowering college students to get the mental health care they need.
                    </p>
                </div>
                <div class="col-md-3">
                    <h4 class="blue">&nbsp;</h4>
                    <p><?php echo SITE_NAME; ?> is not an emergency service and should not be used by anyone experiencing a life-threatening or crisis situation. Instead, you should call 911 to get immediate assistance.</p>
                    <!-- <h4 class="blue">newsletter Subscribe</h4>-->
                    <!--<form>
                        <p>Enter your name and email to get newsletter updates.</p>
                        <div class="form-group">

                            <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter Name">
                        </div>
                        <div class="form-group">

                            <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Enter Email">
                        </div>


                        <button type="submit" class="btn btn-more">Submit</button>
                    </form>-->
                </div>


            </div>
        </div>
        <div class="footer-last">

            <div class="container">

                <span class="copy-text">© <?php echo date('Y'); ?> <?php echo SITE_NAME; ?>. All rights reserved.</span>
                <!--<ul class="socail-frt pull-right">
                    <li class="fb"><a href=""><i class="fa fa-facebook"></i></a></li>
                    <li class="tw"><a href=""><i class="fa fa-twitter"></i></a></li>
                    <li class="ins"><a href=""><i class="fa fa-instagram"></i></a></li>
                    <li class="you"><a href=""><i class="fa fa-youtube-play"></i></a></li>
                </ul>-->



            </div>
        </div>
    </div>
    <script type="text/javascript" src="https://cdn.ywxi.net/js/1.js" async></script>
</footer>

<!-- Bootstrap core JavaScript

    ================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="<?php echo JS_URL; ?>jquery-11.min.js"></script>
<script src="<?php echo JS_URL; ?>owl.carousel.min.js"></script>
<script src="<?php echo JS_URL; ?>bootstrap.min.js"></script>

<script src="<?php echo JS_URL; ?>wow.js"></script>


<script src="<?php echo JS_URL; ?>public.js"></script>
<script>
    wow = new WOW(
            {
                animateClass: 'animated',
                offset: 100,
                callback: function (box) {
                    console.log("WOW: animating <" + box.tagName.toLowerCase() + ">")
                }
            }
    );
    wow.init();
</script>

