<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title> | </title>

  <!-- Bootstrap core CSS -->

  <link href="<?php echo CSS_URL."bootstrap.min.css";?>" rel="stylesheet">

  <link href="<?php echo FONTS_URL."font-awesome.min.css";?>" rel="stylesheet">
  <link href="<?php echo CSS_URL."animate.min.css";?>" rel="stylesheet">

  <!-- Custom styling plus plugins -->
  <link href="<?php echo CSS_URL."custom.css";?>" rel="stylesheet">
  
  <link href="<?php echo CSS_URL."icheck/flat/blue.css";?>" rel="stylesheet">

  <script src="<?php echo JS_URL."jquery.min.js";?>"></script>

  <!--[if lt IE 9]>
        <script src="../assets/js/ie8-responsive-file-warning.js"></script>
        <![endif]-->

  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

</head>
<?php if(ENVIRONMENT != 'development'){ ?>
<body class="login_body">

<div class="container">
  
  
  <div class="mkd-page-not-found text-center">
				<h2 class="title_404">404</h2>
                <h2>
					Page you are looking for is not found				</h2>
				<p class="font18">
					The page you are looking for does not exist. It may have been moved, or removed altogether. <br>Perhaps you can return back to the site's homepage and see if you can find what you are looking for.				</p>
				<br><a class="btn btn-more" target="_self" href="http://medigroup.mikado-themes.com/">
		<span class="mkd-btn-text">Back to Home Page</span>
	
	</a>			</div><div class="reeor-con"><img src="images/404-error-icon.png" width="200"  alt=""/></div>
  </div>
   <div id="wrapper">
      <div class="img_404page">
          <div class="oops">Oops!</div>
          <div class="oops_txt">Something went wrong</div><br><br><img src="<?php echo IMAGES_URL."oops.png";?>" alt="oops"><br>
<br>

      <div class="register-buttons"><a href="<?php echo SITE_URL;?>" class="btn btn-primary">Go to our Homepage</a></div>
    </div>
    </div>
 
  <script src="<?php echo JS_URL."bootstrap.min.js";?>"></script>
   bootstrap progress js 
  <script src="<?php echo JS_URL."nicescroll/jquery.nicescroll.min.js";?>"></script>

   icheck 
  <script src="<?php echo JS_URL."icheck/icheck.min.js";?>"></script>
   Autocomplete 
  <script src="<?php echo JS_URL."custom.js";?>"></script>

</body>
<?php }else{ ?>
<body>
	<div id="container">
		<h1><?php echo $heading; ?></h1>
		<?php echo $message; ?>
	</div>
</body>
<?php } ?>
</html>
