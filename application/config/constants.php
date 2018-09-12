<?php

defined('BASEPATH') OR exit('No direct script access allowed');



/*

  |--------------------------------------------------------------------------

  | Display Debug backtrace

  |--------------------------------------------------------------------------

  |

  | If set to TRUE, a backtrace will be displayed along with php errors. If

  | error_reporting is disabled, the backtrace will not display, regardless

  | of this setting

  |

 */

defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);



/*

  |--------------------------------------------------------------------------

  | File and Directory Modes

  |--------------------------------------------------------------------------

  |

  | These prefs are used when checking and setting modes when working

  | with the file system.  The defaults are fine on servers with proper

  | security, but you may wish (or even need) to change the values in

  | certain environments (Apache running a separate process for each

  | user, PHP under CGI with Apache suEXEC, etc.).  Octal values should

  | always be used to set the mode correctly.

  |

 */

defined('FILE_READ_MODE') OR define('FILE_READ_MODE', 0644);

defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);

defined('DIR_READ_MODE') OR define('DIR_READ_MODE', 0755);

defined('DIR_WRITE_MODE') OR define('DIR_WRITE_MODE', 0755);



/*

  |--------------------------------------------------------------------------

  | File Stream Modes

  |--------------------------------------------------------------------------

  |

  | These modes are used when working with fopen()/popen()

  |

 */

defined('FOPEN_READ') OR define('FOPEN_READ', 'rb');

defined('FOPEN_READ_WRITE') OR define('FOPEN_READ_WRITE', 'r+b');

defined('FOPEN_WRITE_CREATE_DESTRUCTIVE') OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care

defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE') OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care

defined('FOPEN_WRITE_CREATE') OR define('FOPEN_WRITE_CREATE', 'ab');

defined('FOPEN_READ_WRITE_CREATE') OR define('FOPEN_READ_WRITE_CREATE', 'a+b');

defined('FOPEN_WRITE_CREATE_STRICT') OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');

defined('FOPEN_READ_WRITE_CREATE_STRICT') OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');



/*

  |--------------------------------------------------------------------------

  | Exit Status Codes

  |--------------------------------------------------------------------------

  |

  | Used to indicate the conditions under which the script is exit()ing.

  | While there is no universal standard for error codes, there are some

  | broad conventions.  Three such conventions are mentioned below, for

  | those who wish to make use of them.  The CodeIgniter defaults were

  | chosen for the least overlap with these conventions, while still

  | leaving room for others to be defined in future versions and user

  | applications.

  |

  | The three main conventions used for determining exit status codes

  | are as follows:

  |

  |    Standard C/C++ Library (stdlibc):

  |       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html

  |       (This link also contains other GNU-specific conventions)

  |    BSD sysexits.h:

  |       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits

  |    Bash scripting:

  |       http://tldp.org/LDP/abs/html/exitcodes.html

  |

 */

defined('EXIT_SUCCESS') OR define('EXIT_SUCCESS', 0); // no errors

defined('EXIT_ERROR') OR define('EXIT_ERROR', 1); // generic error

defined('EXIT_CONFIG') OR define('EXIT_CONFIG', 3); // configuration error

defined('EXIT_UNKNOWN_FILE') OR define('EXIT_UNKNOWN_FILE', 4); // file not found

defined('EXIT_UNKNOWN_CLASS') OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class

defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member

defined('EXIT_USER_INPUT') OR define('EXIT_USER_INPUT', 7); // invalid user input

defined('EXIT_DATABASE') OR define('EXIT_DATABASE', 8); // database error

defined('EXIT__AUTO_MIN') OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code

defined('EXIT__AUTO_MAX') OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code



define('SITE_NAME', "BetterMynd");

define('CURRENCY_SYMBOL', "$");

define('SITE_URL', "https://" . $_SERVER['HTTP_HOST'] . "/");
define('WP_SITE_URL', "https://www.bettermynd.com/");

define('ASSETS_PATH', $_SERVER['DOCUMENT_ROOT'] . "/assets/");

define('MPDF_PATH', $_SERVER['DOCUMENT_ROOT'] . "/mpdf/");

define('ASSETS_URL', SITE_URL . "assets/");




define("AUTHORIZENET_LOG_FILE", "phplog");



define('DATE_FORMAT', "M d,Y");
define('DATE_INPUT_FORMAT', 'm/d/Y');

define('DATE_TIME_FORMAT', "M d,Y h:i A");
define('TIME_FORMAT', 'h:i A');


define('DATE_PICKER_FORMAT', "YYYY-MM-DD");

//



define('JS_URL', ASSETS_URL . "js/");

define('UPLOAD_URL', ASSETS_URL . "upload/");

define('IMAGES_URL', ASSETS_URL . "images/");

define('CSS_URL', ASSETS_URL . "css/");

define('FONTS_URL', ASSETS_URL . "fonts/");

define('DEFAULT_LOGO', IMAGES_URL . "logo-brandize-center.png");

define('DEFAULT_USER_PIC', "no-image.png");

define('DEFAULT_PROFILE_PIC', IMAGES_URL . "no-image.png");

define('RTF_EDIOTR', ASSETS_URL . "ckeditor/");

define('RTF_EDITOR', ASSETS_URL . "wysiwyg/");





define('DB_PREFIX', "bm_");

define('USERS', 'users');

define('COLLEGE', 'college');

define('TRANSACTIONS', 'appointment_transaction');

define('APPOINTMENTS_ZOOM_INFO', 'appointments_zoom_info');

define('APPOINTMENTS', 'appointments');

define('USERS_ROLE', 'user_roles');

define('STATES', 'states');
define('WELCOME_NOTES', 'welcome_notes');

define('MAIL_TEMPLATES', 'mail_templates');
define('CMS_PAGES', 'cms_pages');

define('USER_COMPANY', 'user_company');

define('COMPANY_BULLETS', 'company_bullets');
define('AVAILABALITY', 'provider_availablity');
define('LOGIN_LOG', 'login_logs');


define('MST_ICONS', 'mst_icons');

define('LOGIN_STATS', 'login_stats');

define('GROUPS', 'mst_groups');

define('USER_GROUPS', 'user_groups');

define('SITE_SETTINGS', 'site_settings');

define('TIMEZONES', 'timezones');

define('PERSONALIZE_TEMPLATE', 'personalize_templates');

define('TEMPLATE_HISTORY', 'template_history');

define('SUPPORT_VIDEOS', 'support_videos');

define('SPECIALITY', 'speciality');

define('PROVIDER_PROFILE', 'provider_profile');

define('THIRD_PARTY_PROFILE', 'thirdparty_profile');

define('TIMEZONE', 'timezone');

define('MST_ETHNICITY', 'mst_ethnicity');

define('COUNSELING_CERTIFICATE', 'thirdparty_counseling_certifications');

define('MALPRACTICE_CERTIFICATE', 'thirdparty_malpractice_insurance_certifications');

// Template Table Definations



define('TEMPLATES', 'mst_templates');

define('TEMPLATE_GROUPS', 'template_groups');

define('TEMPLATE_ELEMENTS', 'template_elements');

define('TEMPLATE_COMPANY_ELEMENTS', 'template_company_elements');

define('TEMPLATE_SETTINGS', 'template_settings');

define('TEMPLATE_SECTIONS', 'template_sections');





define('THEMES', 'mst_themes');

define('THEME_SIZES', 'mst_theme_sizes');

define('TEMPLATE_TYPES', 'mst_template_types');

define('SIZES', 'mst_sizes');

define('ELEMENT_TYPES', 'mst_element_types');



define('DATA_POINTS', 'mst_data_points');

define('THEME_ELEMENTS', 'theme_elements');

define('TEMPLATE_DATA_POINTS', 'template_data_points');

define('EMAIL_URL', SITE_URL . "email/");

define('EMAIL', 'bm_mst_mail');

define('EMAIL_MANAGE', 'bm_mst_mail_manage');

define('NOTIFICATION', 'bm_notification');

define('NOTIFICATION_USER', 'bm_notification_user');

define('NOTIFICATION_URL', SITE_URL . "email/notification/");

define('MAX_VIDEO_WIDTH', 200);




// Template Table Definations Ends
// Authorize.net Credentials

define('AUTHORIZE_LOGIN_ID', "9AFggW36g");

define('AUTHORIZE_TRANSACTION_KEY', "3s66qE9k892Bj9VF");

define('AUTHORIZE_API_URL', "https://test.authorize.net/gateway/transact.dll");

define('AUTHORIZE_API_RECURRING_URL', "https://apitest.authorize.net/xml/v1/request.api");

// Authorize.net Credentials Ends









define('MAIN_SITE_URL', SITE_URL);

define('SADMIN_URL', SITE_URL . "sadmin/");

define('COLLEGE_URL', SITE_URL . "college/");

define('USER_URL', SITE_URL . "user/");

define('AFFILIATE_URL', SITE_URL . "affiliate/");

define('TEMPLATE_URL', SITE_URL . "template/");

define('TEMPLATES_URL', SITE_URL . "template/");

define('ADMIN_URL', SITE_URL . "admin/");

define("IMAGE_VIEW_URL", MAIN_SITE_URL . "image.php");

define('FILE_UPLOAD_PATH', ASSETS_PATH . 'upload/');

define('FFMPEG_PATH', FILE_UPLOAD_PATH . "/ffmpeg");

define('VIDEO_UPLOAD_PATH', FILE_UPLOAD_PATH . "videos/");

define('VIDEO_UPLOAD_URL', ASSETS_URL . "videos/");


define('PROVIDER_URL', SITE_URL . "provider/");

define('PROFILE_FILE_UPLOAD_PATH', ASSETS_PATH . "profile_images");

define('THIRD_PARTY_URL', SITE_URL . "thirdparty/");

define('PATIENT_URL', SITE_URL . "patient/");

define('MALPRACTICE_FILE_UPLOAD_PATH', ASSETS_PATH . "malpractice_certificates");

define('COUNSELING_FILE_UPLOAD_PATH', ASSETS_PATH . "counseling_certificates");

/* define('MAIL_HEADER', '<body style="background:#edf0f5; font-family:Arial, Helvetica, sans-serif;font-size:15px !important;color:#5c5c5c;">

  <div style="width:70%; margin:60px auto 0"><div style=" border-bottom:1px solid #cccccc">

  <h1 style="text-align:center; margin:-20px 0;">' . SITE_NAME . '</h1></div>'); */

define('MAIL_HEADER', '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title>Email</title><link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">  <style type="text/css">body{font-family:Open Sans;} h1, h3{font-family:Open Sans;}table tr td{font-size:14px;font-family:Open Sans;}p{margin:0 0 5px;;font-family:Open Sans;}</style></head>
    <body style="margin:0px; padding:0px; font-family: OpenSans, sans-serif; font-size:14px;">
    <table align="center" width="600">
    <tr style="display: block; background-size:cover;" bgcolor = "#196968">
        <td colspan="2"  align="center" style="color:#fff; width:100%; display:block;"><a href="' . WP_SITE_URL . '" style="text-decoration: none; color: #fff"><h1>' . SITE_NAME . '</h1></a></td>
    </tr>
    <tr><td colspan="2"><br/></td></tr><tr><td colspan="2">');

/* define('MAIL_FOOTER', '<br /><br /><p style="font-size:14px; color:#5c5c5c;"><strong>Best Regards,</strong></p><p style="font-size:14px; color:#5c5c5c;">' . SITE_NAME . ' Customer Support</p><p style="font-size:14px; color:#5c5c5c;">Phone : 855-658-4832</p><p style="font-size:14px; color:#5c5c5c;"><a href="' . SITE_URL . '">' . SITE_URL . '</a></p><p style="text-align:center; margin:0; padding:10px 0"></p></div><br /><p style="text-align:center; margin:5px 0"></p><p style="text-align:center; font-size:14px; color:#5c5c5c; margin:0">&copy; Copyright 2016, All Rights Reserved - ' . SITE_NAME . '.com </p></div></body></html>'); */

define('MAIL_FOOTER', '</td></tr><tr style="display:block; color:#6f6f6f;"><td style=" display:block; font-size:14px" colspan="2"><br/><hr><br/><strong>Best Regards,</strong><br/>The ' . SITE_NAME . ' Support Team<br/>Email : support@bettermynd.com<br/>Phone : (202)813-0915</td></tr><tr><td colspan="2"><br/></td></tr><tr style="display: block; height:40px;" bgcolor = "#196968"><td style="display:block" align="center" colspan="2"><p style="font-size: 14px;text-align: center; margin: 10px; text-align: center; display: block; color: #fff;">&copy; ' . date("Y") . ' ' . SITE_NAME . '. All rights reserved.</p></td></tr></table></body></html>');


define('TEMPLATE_TYPE_PRINT_ADS', '1'); // (1=>'Print Ads',2=>'Banner Ads',3=>'Video')

define('TEMPLATE_TYPE_BANNER_ADS', '2'); // (1=>'Print Ads',2=>'Banner Ads',3=>'Video')



define('EMAIL_UPLOAD_DIR', ASSETS_PATH . "upload/mailattachment/");



define('MST_PAYOUT', DB_PREFIX . 'mst_payout');
define('AFFILIATE_COMMISSION', DB_PREFIX . 'affiliate_commission');
define('AFFILIATE_TRAINING', DB_PREFIX . 'affiliate_trainings');
define('TRAINING_MEDIA', DB_PREFIX . 'training_content');
define('REFERRAL_STATS', DB_PREFIX . 'referral_stats');
define('FILE_UPLOAD_URL', ASSETS_URL . "upload/");

define('MEETING_DURATION', 45); //MEETING_DURATION in minutes
define('INSURANCE', 'insurance');
define('CONTACT_US_EMAIL', 'info@bettermynd.com');

define('DEFAULT_TIMEZONE', 'Eastern Standard Time');
define('DEFAULT_TIMEZONE_CODE', 'UTC');

/* * *******Start :: Client stripe test/live details ****** */
//define('STRIPE_PK', 'pk_test_P9lZg7usifh1YrwyJnhb9QCX');
//define('STRIPE_SK', 'sk_test_nVH1mduORBkmtguKC8AkNAmG');
define('STRIPE_PK', 'pk_live_yPy31Hn9sx5zr8BKJFhlkz2X');
define('STRIPE_SK', 'sk_live_UTdpB4w8zppai8pXJJHbYxtW');
/*********End  :: Client stripe test/live details *******/
