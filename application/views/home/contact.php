<!-- Container -->
<div class="main-container">
    <div class="status-bar">
        <div class="status-bar1 text-center">
            <div class="container"> <div class="tg-sectiontitle white">
                    <h2><?php echo $pagedata->page_title; ?></h2>
                    <h3 class="white upercase">Get In Touch</h3>
                </div></div>
        </div>
    </div>
    <div class="contact">
        <div class="container">
            <ul class="breadcrumb">
                <li><a href="<?php echo SITE_URL; ?>">Home</a> </li>
                <li class="active"><?php echo $pagedata->page_title; ?></li>
            </ul>

            <div class="tg-sectionhead">
                <div class="page-header"><h1 class="title"><span><?php echo $pagedata->page_title; ?></span></h1></div>
                <div class="tg-section-heading"><?php echo html_entity_decode($pagedata->page_content); ?></div>
                <div class="row">
                    <div class="col-md-12">
                        <?php if (isset($error) && !empty($error)) {
                            ?>
                            <div class="alert alert-danger"><?php echo $error; ?><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></div>
                            <?php
                        }
                        ?>
                        <?php if (isset($message) && !empty($message)) {
                            ?>
                            <div class="alert alert-success"><?php echo $message; ?><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></div>
                            <?php
                        }
                        ?>
                    </div>
                    <div class="col-md-12">
                        <div class="tg-contact">
                            <h4>We are here for you.</h4>
                            <h2>Send us a message</h2>
                            <form class="field-contact" action="<?php echo base_url('home/contact'); ?>" method="post" id="contactFrm">
                                <div class="row">
                                    <div class="col-md-6"> <div class="form-group">

                                            <input type="text" class="form-control" id="exampleInputName" placeholder="Name" name="name">
                                        </div></div>
                                    <div class="col-md-6"> <div class="form-group">

                                            <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Email" name="email">
                                        </div></div>
                                    <div class="col-md-12"> <div class="form-group">

                                            <input type="text" class="form-control" id="exampleInputSubject" placeholder="Subject" name="subject">
                                        </div></div>
                                    <div class="col-md-12"> <div class="form-group">

                                            <textarea class="form-control" rows="2" name="message" placeholder="Message"></textarea>
                                        </div></div>
                                    <div class="col-md-12"><p class="text-center"><button type="submit" class="btn btn-more">Submit</button></p></div>

                                </div>
                            </form>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="media">
                                        <div class="media-left">
                                            <a href="#">
                                                <i class="fa fa-mobile" aria-hidden="true"></i>
                                            </a>
                                        </div>
                                        <div class="media-body text-left">
                                            <h4 class="media-heading">+1-202-813-0915</h4>
                                            info@bettermynd.com
                                        </div>
                                    </div>
                                </div>
                                <!--                            <div class="col-md-6">
                                                                <div class="media">
                                                                    <div class="media-left">
                                                                        <a href="#">
                                                                            <i class="fa fa-map-marker" aria-hidden="true"></i>
                                                                        </a>
                                                                    </div>
                                                                    <div class="media-body text-left">
                                                                        <h4 class="media-heading">34th Avenue</h4>
                                                                        New York, W2 3XE
                                                                    </div>
                                                                </div>
                                                            </div>-->
                                <div class="contact-social"><ul class="socail-frt text-left">
                                        <li class="fb"><a href="https://www.facebook.com/bettermynd"><i class="fa fa-facebook"></i></a></li>
                                        <li class="tw"><a href="https://twitter.com/bettermynd"><i class="fa fa-twitter"></i></a></li>
    <!--                                    <li class="ins"><a href=""><i class="fa fa-instagram"></i></a></li>
                                        <li class="you"><a href=""><i class="fa fa-youtube-play"></i></a></li>-->
                                    </ul></div></div>
                        </div>

                    </div>


<!--                    <div class="col-md-6"><div class="map-style"><iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d28463.38035355521!2d75.71993875524952!3d26.905953190515895!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x396db49e043a7acb%3A0xdad09ace57371810!2sVaishali+Nagar%2C+Jaipur%2C+Rajasthan+302021!5e0!3m2!1sen!2sin!4v1452232810389" frameborder="0" style="border:0;width:100%;height:500px;margin-bottom:40px;" allowfullscreen></iframe>
                        </div></div>-->
                </div>
            </div>
        </div>

    </div>



</div>

<script>
    $(document).ready(function () {
        $.validator.addMethod("email_valid", function (value, element) {
            var numericReg = /^([A-Za-z]{1})([A-Za-z0-9-_.]{1,100})([A-Za-z0-9])+\@([a-zA-Z0-9]+\.)+(([a-zA-Z]{2,4}))\w?$/;
            return numericReg.test(value);
        }, "Please Enter valid email address");

        $("#contactFrm").validate({
            rules: {
                name: {
                    required: true
                },
                email: {
                    required: true,
                    email_valid: true
                },
                subject: {
                    required: true
                },
                message: {
                    required: true
                },
            },
            messages: {
            },
            errorPlacement: function (error, element) {
                var my = "";
                var at = "";
                if ($(window).width() < 800) {
                    my = 'bottom right';
                    at = 'top right';
                } else {
                    my = 'bottom right';
                    at = 'top right';
                }
                if (!error.is(':empty')) {
                    $(element).not('.valid').qtip({
                        overwrite: false,
                        content: error,
                        show: 'focus',
                        hide: 'blur',
                        position: {
                            my: my,
                            at: at,
                            viewport: $(window),
                            adjust: {
                                x: 0,
                                y: 0
                            }
                        },
                        style: {
                            classes: 'qtip-custom qtip-shadow',
                            tip: {
                                height: 6,
                                width: 11
                            }
                        }
                    }).qtip('option', 'content.text', error);
                } else {
                    element.qtip('destroy');
                }
            },
            submitHandler: function (form) {
                $("#signup_btn").attr("disabled", true);
                $('select').removeAttr('disabled');
                form.submit();
            },
            success: "valid"
        });
    })
</script>