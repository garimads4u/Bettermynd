<!doctype html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Email</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
        <style>body{font-family:Open Sans;}h3{font-family:Open Sans;}table tr td{font-size:14px;font-family:Open Sans;}p{margin:0 0 5px;;font-family:Open Sans;}</style>
    </head>
    <body style="margin:0px; padding:0px; font-family: OpenSans, sans-serif; font-size:14px;">
        <table align="center" width="600">
            <tr style="background-color:#fff; display: block; margin-bottom: 20px; background-image:url(<?php echo ASSETS_URL; ?>images/mail_header.png); background-size:cover; ">
                <td colspan="2"  align="center" style="color:#fff; width:100%; display:block;">
                    <a href="<?php echo SITE_URL; ?>" style="text-decoration: none; color: #fff">
                        <img src="<?php echo ASSETS_URL; ?>images/mail_logo.png" alt="BetterMynd"/></a>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <?php echo $content; ?>
                </td>
            </tr>
            <tr style="padding-top:20px; margin-top:20px; border-top:1px solid #ccc; display:block; color:#6f6f6f;">
                <td style=" display:block; font-size:14px">
                    <strong>Best Regards,</strong><br/><?php echo SITE_NAME; ?> Customer Support<br/>Phone : 855-658-4832
                </td>
            </tr>
            <tr style="display: block; background:url(<?php echo ASSETS_URL; ?>images/mail_footer.jpg) repeat; height:40px; margin-top: 20px;">
                <td style="display:block" align="center">
                    <p style="font-size: 14px;text-align: center; margin: 10px; text-align: center; display: block; color: #fff;">Copyright Â© <?php echo date("Y") ?> <?php echo SITE_NAME; ?> Inc. All rights reserved - <a href="<?php echo SITE_URL; ?>" style="text-decoration: none; color: #fff"><?php echo SITE_NAME; ?>.com</a></p>
                </td>
            </tr>
        </table>
    </body>
</html>