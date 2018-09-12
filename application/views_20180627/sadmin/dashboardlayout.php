<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<!-- Meta, title, CSS, favicons, etc. -->
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Brandize |</title>
<!-- Favicon -->
<link rel="apple-touch-icon" sizes="57x57" href="<?php echo IMAGES_URL;?>favicon/apple-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="<?php echo IMAGES_URL;?>favicon/apple-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="<?php echo IMAGES_URL;?>favicon/apple-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="<?php echo IMAGES_URL;?>favicon/apple-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="<?php echo IMAGES_URL;?>favicon/apple-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="<?php echo IMAGES_URL;?>favicon/apple-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="<?php echo IMAGES_URL;?>favicon/apple-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="<?php echo IMAGES_URL;?>favicon/apple-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="<?php echo IMAGES_URL;?>favicon/apple-icon-180x180.png">
<link rel="icon" type="image/png" sizes="192x192"  href="<?php echo IMAGES_URL;?>favicon/android-icon-192x192.png">
<link rel="icon" type="image/png" sizes="32x32" href="<?php echo IMAGES_URL;?>favicon/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="96x96" href="<?php echo IMAGES_URL;?>favicon/favicon-96x96.png">
<link rel="icon" type="image/png" sizes="16x16" href="<?php echo IMAGES_URL;?>favicon/favicon-16x16.png">
<link rel="manifest" href="<?php echo IMAGES_URL;?>favicon/manifest.json">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="<?php echo IMAGES_URL;?>favicon/ms-icon-144x144.png">
<meta name="theme-color" content="#ffffff">

<!-- Bootstrap core CSS -->

<link href="<?php echo CSS_URL."bootstrap.min.css";?>" rel="stylesheet">
<link href="<?php echo FONTS_URL."css/font-awesome.min.css";?>" rel="stylesheet">
<link href="<?php echo CSS_URL."animate.min.css";?>" rel="stylesheet">
<!-- Custom styling plus plugins -->
<link href="<?php echo CSS_URL."custom.css";?>" rel="stylesheet">
<link href="<?php echo CSS_URL."icheck/flat/blue.css";?>" rel="stylesheet">
<link href="<?php echo JS_URL."datatables/jquery.dataTables.min.css";?>" rel="stylesheet" type="text/css" />

<!-- select2 -->
<link href="<?php echo CSS_URL."select/select2.min.css";?>" rel="stylesheet">
<!-- switchery -->
<link rel="stylesheet" href="<?php echo CSS_URL."switchery/switchery.min.css";?>" />
<script src="<?php echo JS_URL."jquery.min.js";?>"></script>

<!--[if lt IE 9]>
        <script src="<?php echo JS_URL;?>ie8-responsive-file-warning.js"></script>
        <![endif]-->

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

</head>

<body class="nav-md">
<div class="container body">
  <div class="main_container">
     <?= isset($content_for_layout_sidebar) ? $content_for_layout_sidebar : ''; ?>
    
    <!-- top navigation -->
       <?= isset($content_for_layout_header) ? $content_for_layout_header : ''; ?>
    <!-- /top navigation --> 
    
    <!-- page content -->
    <div class="right_col" role="main">
      <div class="row">
         <?= isset($content_for_layout_middle) ? $content_for_layout_middle : ''; ?>
      </div>
      
      <!-- footer content -->
      
     <?= isset($content_for_layout_footer) ? $content_for_layout_footer : ''; ?>

      <!-- /footer content --> 
    </div>
    <!-- /page content --> 
    
  </div>
</div>
<div id="custom_notifications" class="custom-notifications dsp_none">
  <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
  </ul>
  <div class="clearfix"></div>
  <div id="notif-group" class="tabbed_notifications"></div>
</div>
<script src="<?php echo JS_URL."bootstrap.min.js";?>"></script> 
<script src="<?php echo JS_URL."bootbox.min.js";?>"></script>
<!-- bootstrap progress js --> 
<script src="<?php echo JS_URL."progressbar/bootstrap-progressbar.min.js";?>"></script> 
<script src="<?php echo JS_URL."nicescroll/jquery.nicescroll.min.js";?>"></script> 
<!-- icheck --> 
<script src="<?php echo JS_URL."js/icheck/icheck.min.js";?>"></script> 
<!-- switchery --> 
<script src="<?php echo JS_URL."switchery/switchery.min.js";?>"></script> 
<script src="<?php echo JS_URL."custom.js";?>"></script> 

<!-- Datatables--> 
<script src="<?php echo JS_URL."datatables/jquery.dataTables.min.js";?>"></script> 
<script src="<?php echo JS_URL."datatables/dataTables.bootstrap.js";?>"></script> 

<!-- pace --> 
<script src="<?php echo JS_URL."moris/raphael-min.js";?>"></script> 
<script src="<?php echo JS_URL."moris/morris.min.js";?>"></script> 
<script type="text/javascript">
          $(document).ready(function() {
            $('#datatable, #datatable1').dataTable();
            $('#datatable-keytable').DataTable({
              keys: true
            });
            $('#datatable-responsive').DataTable();
            $('#datatable-scroller').DataTable({
              ajax: "js/datatables/json/scroller-demo.json",
              deferRender: true,
              scrollY: 380,
              scrollCollapse: true,
              scroller: true
            });
            var table = $('#datatable-fixed-header').DataTable({
              fixedHeader: true
            });

            var data = [
                  { y: '2004', a: 50},
                  { y: '2005', a: 65},
                  { y: '2006', a: 50},
                  { y: '2007', a: 75},
                  { y: '2008', a: 80},
                  { y: '2009', a: 90},
                  { y: '2010', a: 100},
                  { y: '2011', a: 115},
                  { y: '2012', a: 120},
                  { y: '2013', a: 145},
                  { y: '2014', a: 160}
                ],
                config = {
                  data: data,
                  xkey: 'y',
                  ykeys: ['a'],
                  labels: ['Total Income'],
                  fillOpacity: 0.6,
                  hideHover: 'auto',
                  behaveLikeLine: true,
                  resize: true,
                  pointFillColors:['#ffffff'],
                  pointStrokeColors: ['#55acee'],
                  lineColors:['#55acee']
              };
            config.element = 'morris-chart';
            Morris.Line(config);
          });
          
        $(document).on("click", ".logout", function(e) {
           bootbox.confirm("Are you sure you want to logout this session?", function(result) {
  			if(result==true){
				window.location="<?php echo SITE_URL;?>logout";
			}
});
        });
            </script> 

<!-- /footer content -->
</body>
</html>
