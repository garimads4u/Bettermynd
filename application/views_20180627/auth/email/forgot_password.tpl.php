<?php /*?><html>
<body>
	<h1><?php echo sprintf(lang('email_forgot_password_heading'), $identity);?></h1>
	<p><?php echo sprintf(lang('email_forgot_password_subheading'), anchor('auth/reset_password/'. $forgotten_password_code, lang('email_forgot_password_link')));?></p>
</body>
</html><?php */?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome to Brandize</title>
</head>

<body style="background:#edf0f5; font-family:Arial, Helvetica, sans-serif;font-size:15px !important;color:#5c5c5c;">
<div style="width:70%; margin:60px auto 0"><div style=" border-bottom:1px solid #cccccc">
<h1 style="text-align:center; margin:-20px 0;"><img src="<?php echo ASSETS_URL;?>images/logo-brandize-center.png" /></h1></div>
<h2 style="font-size:34px; text-align:center; font-weight:bold; color:#525252; padding:20px 0">Forgot Password</h2>
<div style=" background:#fff; border-radius:5px; padding:25px; border:1px solid #cccccc">
<h3 style="color:#333; font-size:18px;  margin:5px 0;padding:5px 0">Dear <?php echo $identity;?> </h3>
<p style="padding:10px 0; font-size:14px;margin:0">There was recently a request to change the password for your account.</p>
    <p>If you requested this password change, please click on the following link to reset your password:</p><br />
    <p><a href="<?php echo SITE_URL."reset_password/".$forgotten_password_code;?>"><?php echo SITE_URL."reset_password/".$forgotten_password_code;?></a></p>
    
    
    <p>If clicking the link does not work, please copy and paste the URL into your browser instead.</p>
    <p>If you did not make this request, you can ignore this message and your password will remain same.</p>

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
