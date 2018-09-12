<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title><?php echo $title;?> </title>

  <!-- Bootstrap core CSS -->

  <link href="<?php echo CSS_URL."bootstrap.min.css";?>" rel="stylesheet">

  <link href="<?php echo FONTS_URL."css/font-awesome.min.css";?>" rel="stylesheet">
  <link href="<?php echo CSS_URL."animate.min.css";?>" rel="stylesheet">

  <!-- Custom styling plus plugins -->
  <link href="<?php echo CSS_URL."custom.css";?>" rel="stylesheet">
  <link href="<?php echo CSS_URL."icheck/flat/blue.css";?>" rel="stylesheet">

  <script src="<?php echo JS_URL."jquery.min.js"; ?>" ></script>
  <link href="<?php echo CSS_URL; ?>jquery.qtip.min.css" rel="stylesheet" type="text/css" />
    
  <!--[if lt IE 9]>
        <script src="../assets/js/ie8-responsive-file-warning.js"></script>
        <![endif]-->

  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
<script>
var SITE_URL = "<?php echo SITE_URL;?>";
</script>
</head>

<body class="login_body">
   <div id="wrapper">
      <div id="<?php echo $div_form_id;?>" class="form">
        <section class="login_content">
        <?= isset($content_for_layout_header) ? $content_for_layout_header : ''; ?>
        <?= isset($content_for_layout_middle) ? $content_for_layout_middle : ''; ?>
          <div class="clearfix">
              <br />
              <br />
              <div>
                <p><img src="<?php echo IMAGES_URL."powered_logo.png";?>" width="168" height="59"  alt=""/></p>
              </div>
            </div>
          <!-- form -->
        </section>
        <!-- content -->
      </div>
    </div>
<?= isset($content_for_layout_footer) ? $content_for_layout_footer : ''; ?>

</body>
</html>
