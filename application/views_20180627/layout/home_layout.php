<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="keywords" content="">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="shortcut icon" href="favicon.ico">
        <title>BetterMynd</title>
        <!--Google Wb Font-->
        <link href="https://fonts.googleapis.com/css?family=Lato:100,100i,300,300i,400,400i,700,700i,900,900i" rel="stylesheet">
        <link type="text/css" href="<?php echo CSS_URL; ?>bootstrap.min.css" rel="stylesheet">
        <link type="text/css" href="<?php echo CSS_URL; ?>custom-style.css" rel="stylesheet">

        <link href="<?php echo CSS_URL . "responsive.css"; ?>" rel="stylesheet">
        <link href="<?php echo CSS_URL; ?>animate.css" rel="stylesheet" type="text/css">
        <link href="<?php echo CSS_URL; ?>owl.carousel.css" rel="stylesheet" type="text/css">
        <!-- Bootstrap core CSS -->
        <link href="<?php echo CSS_URL; ?>font-awesome.min.css" rel="stylesheet">
        <!-- Just for debugging purposes. Don't actually copy this line! -->
        <!--[if lt IE 9]><script src="<?php echo JS_URL; ?>ie8-responsive-file-warning.js"></script><![endif]-->
        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
              <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
              <script src="https://oss.maxcdn.com/libs/respond.<?php echo JS_URL; ?>1.4.2/respond.min.js"></script>
              <link href="<?php echo CSS_URL; ?>ie8.css" rel="stylesheet">
            <![endif]-->
        <!--[if lt IE 8]>
              <link href="<?php echo CSS_URL; ?>ie7.css" rel="stylesheet">
            <![endif]-->
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

        <script src="<?php echo JS_URL . "jquery.min.js"; ?>"></script>

        <link href="<?php echo CSS_URL; ?>jquery.qtip.min.css" rel="stylesheet" type="text/css" />

        <?php
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
    <body>

        <?php echo isset($content_for_layout_header) ? $content_for_layout_header : ''; ?>

        <?php echo isset($content_for_layout_middle) ? $content_for_layout_middle : ''; ?>

        <?php echo isset($content_for_layout_footer) ? $content_for_layout_footer : ''; ?>

        <script type="text/javascript" src="<?php echo JS_URL . "jquery.validate.js"; ?>"></script>
        <script src="<?php echo JS_URL; ?>qtip/jquery.qtip.min.js" type="text/javascript"></script>


    </body>
</html>