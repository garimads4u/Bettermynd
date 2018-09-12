<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title><?php echo SITE_NAME ;?> | URL NOT FOUND </title>

  <!-- Bootstrap core CSS -->

  <link href="<?php echo CSS_URL."bootstrap.min.css";?>" rel="stylesheet">

  <link href="<?php echo FONTS_URL."font-awesome.min.css";?>" rel="stylesheet">
  <link href="<?php echo CSS_URL."animate.min.css";?>" rel="stylesheet">

  <!-- Custom styling plus plugins -->
  <link href="<?php echo CSS_URL."custom.css";?>" rel="stylesheet">
  <link href="<?php echo CSS_URL."icheck/flat/blue.css";?>" rel="stylesheet">


  <!--[if lt IE 9]>
        <script src="../assets/js/ie8-responsive-file-warning.js"></script>
        <![endif]-->

  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

</head>
<style>
    .alert-danger::before {
        content: "";
    }
    .alert-danger {
        padding : 15px 15px 15px 17px;
    }
</style>
<body class="login_body">
   <div id="wrapper">
      <div class="img_404page">
         <?php /*?> <img src="<?php echo IMAGES_URL."logo-brandize-center.png";?>" width="176" height="52"  alt=""/><?php */?><br><br>
         <!--<img src="<?php echo IMAGES_URL."/nojs.png";?>">-->
         <span style="font-size: 200px; text-decoration: line-through;color:white;">JS</span>
      </div>
       <div class="register-buttons"><span class="alert alert-danger">For full functionality of this site it is necessary to enable JavaScript. Here are the <a href="http://www.enable-javascript.com/"  target="_blank">
 instructions how to enable JavaScript in your web browser</a>. </span></div>
       <br>
      <div class="register-buttons"><a href="<?php echo SITE_URL;?>" class="btn btn-success">Go to home page </a></div>
      <!--<div class="text-center" style="font-size:14px;color:#cc0000;">This page needs JavaScript activated to work. </div>-->
    </div>
 
  
</body>
</html>
