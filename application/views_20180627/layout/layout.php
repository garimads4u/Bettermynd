<!DOCTYPE html>

<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

        <!-- Meta, title, CSS, favicons, etc. -->

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Favicon -->

        <link rel="apple-touch-icon" sizes="57x57" href="<?php echo IMAGES_URL; ?>favicon/apple-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="<?php echo IMAGES_URL; ?>favicon/apple-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="<?php echo IMAGES_URL; ?>favicon/apple-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="<?php echo IMAGES_URL; ?>favicon/apple-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="<?php echo IMAGES_URL; ?>favicon/apple-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="<?php echo IMAGES_URL; ?>favicon/apple-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="<?php echo IMAGES_URL; ?>favicon/apple-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="<?php echo IMAGES_URL; ?>favicon/apple-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="<?php echo IMAGES_URL; ?>favicon/apple-icon-180x180.png">
        <link rel="icon" type="image/png" sizes="192x192"  href="<?php echo IMAGES_URL; ?>favicon/android-icon-192x192.png">
        <link rel="icon" type="image/png" sizes="32x32" href="<?php echo IMAGES_URL; ?>favicon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="96x96" href="<?php echo IMAGES_URL; ?>favicon/favicon-96x96.png">
        <link rel="icon" type="image/png" sizes="16x16" href="<?php echo IMAGES_URL; ?>favicon/favicon-16x16.png">
        <link rel="manifest" href="<?php echo IMAGES_URL; ?>favicon/manifest.json">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="<?php echo IMAGES_URL; ?>favicon/ms-icon-144x144.png">
        <meta name="theme-color" content="#ffffff">
        <title><?php echo SITE_NAME; ?></title>

        <!-- Bootstrap core CSS -->

        <link href="<?php echo CSS_URL . "bootstrap.min.css"; ?>" rel="stylesheet">
        <link href="<?php echo FONTS_URL . "css/font-awesome.min.css"; ?>" rel="stylesheet">
        <link href="<?php echo CSS_URL . "animate.min.css"; ?>" rel="stylesheet">

        <!-- Custom styling plus plugins -->
        <link href="<?php echo CSS_URL . "responsive.css"; ?>" rel="stylesheet">
        <link href="<?php echo CSS_URL . "custom.css"; ?>" rel="stylesheet">
        <link href="<?php echo CSS_URL . "icheck/flat/blue.css"; ?>" rel="stylesheet">
        <link href="<?php echo CSS_URL . "brandize-custom.css"; ?>" rel="stylesheet">
        <script src="<?php echo JS_URL . "jquery.min.js"; ?>" ></script>
        <link href="<?php echo CSS_URL; ?>jquery.qtip.min.css" rel="stylesheet" type="text/css" />
        <link href="//cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/build/css/bootstrap-datetimepicker.css" rel="stylesheet">

        <!--[if lt IE 9]>

        <script src="../assets/js/ie8-responsive-file-warning.js"></script>

        <![endif]-->

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->

        <!--[if lt IE 9]>

          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>

          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>

        <![endif]-->

        <script>

            var SITE_URL = "<?php echo SITE_URL; ?>";

        </script>
        <?php
        if (isset($company_profile_details) && !empty($company_profile_details) && strlen($company_profile_details['details']['company_logo1_color1']) > 0) {
            ?>
            <style type="text/css">
                .btn-primary {
                    background-color:<?php echo $company_profile_details['details']['company_logo1_color1'];
            ?> !important;
                    border-color:<?php echo $company_profile_details['details']['company_logo1_color1'];
            ?> !important;
                }
                .label-primary {
                    background-color:<?php echo $company_profile_details['details']['company_logo1_color1'];
            ?> !important;
                    border-color:<?php echo $company_profile_details['details']['company_logo1_color1'];
            ?> !important;
                }
                .icheckbox_flat-blue.checked {
                    background-color:<?php echo $company_profile_details['details']['company_logo1_color1'];
            ?> !important;
                }
                .iradio_flat-blue.checked {
                    background-color:<?php echo $company_profile_details['details']['company_logo1_color1'];
            ?> !important;
                }
                .paginate_button.active a {
                    background-color:<?php echo $company_profile_details['details']['company_logo1_color1'];
            ?> !important;
                    border-color:<?php echo $company_profile_details['details']['company_logo1_color1'];
            ?> !important;
                }
            </style>
            <?php
        } else {
            ?>
            <style type="text/css">
                .icheckbox_flat-blue.checked {
                    background-color:#55acee !important;
                }
                .iradio_flat-blue.checked {
                    background-color:#55acee !important;
                }
            </style>
            <?php
        }
        $add_script = 1;
        if ($this->ion_auth->logged_in() && $this->ion_auth->user()->row()->user_type == 1) {
            $add_script = 0;
        }

        if ($add_script == 1) {
            ?>

            <script type="text/javascript">
                window.heap = window.heap || [], heap.load = function (e, t) {
                    window.heap.appid = e, window.heap.config = t = t || {};
                    var r = t.forceSSL || "https:" === document.location.protocol, a = document.createElement("script");
                    a.type = "text/javascript", a.async = !0, a.src = (r ? "https:" : "http:") + "//cdn.heapanalytics.com/js/heap-" + e + ".js";
                    var n = document.getElementsByTagName("script")[0];
                    n.parentNode.insertBefore(a, n);
                    for (var o = function (e) {
                        return function () {
                            heap.push([e].concat(Array.prototype.slice.call(arguments, 0)))
                        }
                    }, p = ["addEventProperties", "addUserProperties", "clearEventProperties", "identify", "removeEventProperty", "setEventProperties", "track", "unsetEventProperty"], c = 0; c < p.length; c++)
                        heap[p[c]] = o(p[c])
                };
                heap.load("2197708629");
            </script>
        <?php } ?>
    </head>

    <body class="login_body">
        <noscript>
        <meta http-equiv="refresh" content="0.0;url=<?php echo base_url('index/nojs'); ?>">

        <style>#wrapper { display:none; }</style>
        </noscript>
        <div id="wrapper">
            <div  class="form">
                <section class="login_content"> <?php echo isset($content_for_layout_header) ? $content_for_layout_header : ''; ?> <?php echo isset($content_for_layout_middle) ? $content_for_layout_middle : ''; ?>
                    <div class="clearfix"> <br />
                        <br />
                        <div>


                        </div>
                    </div>

                    <!-- form -->

                </section>

                <!-- content -->

            </div>
        </div>
        <?php echo isset($content_for_layout_footer) ? $content_for_layout_footer : ''; ?>
        <script src="<?php echo JS_URL . "bootbox.min.js"; ?>"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>
        <script src="<?php echo JS_URL . "bootstrap-datetimepicker.min.js"; ?>"></script>
        <script src="<?php echo JS_URL . "jquery.inputmask.bundle.js"; ?>"></script>
        <script type="text/javascript">
                $(document).ready(function (e) {
                    $(".noneditable").keydown(function (e) {
                        if ((e.key).toLowerCase() == 'tab')
                            return true;

                        return false;
                    });
                    $(".noneditable").mousedown(function (e) {
                        return false;
                    });
                    $("input[type='text']").change(function (e) {
                        var val = $(this).val();
                        $(this).val($.trim(val));
                    });
                });
        </script>
    </body>
</html>
