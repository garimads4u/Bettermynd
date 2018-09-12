<?php /*?><html>
<body>
	<h1><?php echo sprintf(lang('email_activate_heading'), $identity);?></h1>
	<p><?php echo sprintf(lang('email_activate_subheading'), anchor('auth/activate/'. $id .'/'. $activation, lang('email_activate_link')));?></p>
</body>
</html><?php */?>


<body style="background:#edf0f5; font-family:Arial, Helvetica, sans-serif;font-size:15px !important;color:#5c5c5c;">
<div style="width:70%; margin:60px auto 0"><div style=" border-bottom:1px solid #cccccc">
<h1 style="text-align:center; margin:-20px 0;"><img src="<?php echo ASSETS_URL;?>images/logo-brandize-center.png" /></h1></div>
<h2 style="font-size:34px; text-align:center; font-weight:bold; color:#525252; padding:20px 0">Welcome to Brandize</h2>
<div style=" background:#fff; border-radius:5px; padding:25px; border:1px solid #cccccc">
<h3 style="color:#333; font-size:18px;  margin:5px 0;padding:5px 0">Dear <?php echo $identity;?> </h3>
<p style="padding:10px 0; font-size:14px; margin:0">We are proud to welcome you as a Brandize Member, your Username is: <?php echo $identity;?> </p>
    <p>To activate your new Brandize Account, please click on below button </p><br />
    <p><a style="background:#8d258c; font-size:13px; font-weight:bold; text-decoration:none; border-radius:5px; color:#fff; padding:15px 20px; text-align:center" href="<?php echo SITE_URL."activate/".$id."/".$activation;?>">Verify Email Address</a></b> </p>
    <br />
    <p>This Confirmation Link can be clicked only once. If the link is not working, copy and paste the link in your browser:</p>
    <p><a href="<?php echo SITE_URL."activate/".$id."/".$activation;?>"><?php echo SITE_URL."activate/".$id."/".$activation;?></a></p>
    
    
    <p>Once again, thank you for joining our Brandize Community </p>
    
    <br /><br />
    <p style="font-size:14px; color:#5c5c5c;"><strong>Best Regards,</strong></p>
    <p style="font-size:14px; color:#5c5c5c;">Brandize Customer Support</p>
    <p style="font-size:14px; color:#5c5c5c;">Phone : 855-658-4832</p>
    <p style="font-size:14px; color:#5c5c5c;"><a href="https://brandize.com">https://brandize.com</a></p>
    

    
<p style="text-align:center; margin:0; padding:10px 0"></p>
</div>
<br />
<p style="text-align:center; margin:5px 0"><img width="100" src="<?php echo ASSETS_URL;?>images/logo-brandize-center.png" /></p>
<p style="text-align:center; font-size:14px; color:#5c5c5c; margin:0">&copy; Copyright 2016, All Rights Reserved - Brandize.com </p>
</div>
</body>
</html>
