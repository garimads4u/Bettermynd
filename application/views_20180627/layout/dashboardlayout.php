<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<!-- Meta, title, CSS, favicons, etc. -->
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>BetterMynd |</title>

<!-- Bootstrap core CSS -->

<link href="<?php echo CSS_PATH."bootstrap.min.css";?>" rel="stylesheet">
<link href="<?php echo FONTS_PATH."css/font-awesome.min.css";?>" rel="stylesheet">
<link href="<?php echo CSS_PATH."animate.min.css";?>" rel="stylesheet">
<!-- Custom styling plus plugins -->
<link href="<?php echo CSS_PATH."custom.css";?>" rel="stylesheet">
<link href="<?php echo CSS_PATH."icheck/flat/blue.css";?>" rel="stylesheet">
<link href="<?php echo JS_PATH."datatables/jquery.dataTables.min.css";?>" rel="stylesheet" type="text/css" />

<!-- select2 -->
<link href="<?php echo CSS_PATH."select/select2.min.css";?>" rel="stylesheet">
<!-- switchery -->
<link rel="stylesheet" href="<?php echo CSS_PATH."switchery/switchery.min.css";?>" />
<script src="<?php echo JS_PATH."jquery.min.js";?>"></script>

<!--[if lt IE 9]>
        <script src="<?php echo JS_PATH;?>ie8-responsive-file-warning.js"></script>
        <![endif]-->

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
<script src="<?php echo JS_PATH."datatables/jquery.dataTables.min.js";?>"></script> 
<script src="<?php echo JS_PATH."datatables/dataTables.bootstrap.js";?>"></script> 
    	<script type="text/javascript" src="//cdn.datatables.net/buttons/1.1.2/js/buttons.flash.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
<script type="text/javascript" src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
<script type="text/javascript" src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/buttons/1.1.2/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/buttons/1.1.2/js/buttons.print.min.js "></script>
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
<script src="<?php echo JS_PATH."bootstrap.min.js";?>"></script> 
<script src="<?php echo JS_PATH."bootbox.min.js";?>"></script>
<!-- bootstrap progress js --> 
<script src="<?php echo JS_PATH."progressbar/bootstrap-progressbar.min.js";?>"></script> 
<script src="<?php echo JS_PATH."nicescroll/jquery.nicescroll.min.js";?>"></script> 
<!-- icheck --> 
<script src="<?php echo JS_PATH."js/icheck/icheck.min.js";?>"></script> 
<!-- switchery --> 
<script src="<?php echo JS_PATH."switchery/switchery.min.js";?>"></script> 
<script src="<?php echo JS_PATH."custom.js";?>"></script> 

<!-- Datatables--> 



<!-- pace --> 
<script src="<?php echo JS_PATH."moris/raphael-min.js";?>"></script> 
<script src="<?php echo JS_PATH."moris/morris.min.js";?>"></script> 
<script src="<?php echo JS_URL."jquery.formance.min.js";?>"></script>
<script src="<?php echo JS_URL."awesome_form.js";?>"></script>

<script type="text/javascript">
function isFutureDate(idate) {
    var today = new Date(<?php echo date('Y',time()); ?>, <?php echo date('m',time()); ?> - 1, <?php echo date('d',time()); ?>).getTime();
//                var today = new Date().getTime(),
            idate = idate.split("/");
    //alert(today);
    idate = new Date(idate[2], idate[0] - 1, idate[1]).getTime();
    return (today - idate) < 0 ? true : false;
}
</script>

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
<script type="text/javascript">
$(document).ready(function(e) {
    $(".noneditable").keydown(function(e) {
        return false;
    });
	$(".noneditable").mousedown(function(e) {
        return false;
    });
});
</script>

<!-- /footer content -->
</body>
</html>
