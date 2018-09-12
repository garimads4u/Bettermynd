<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/*
  | -------------------------------------------------------------------------
  | URI ROUTING
  | -------------------------------------------------------------------------
  | This file lets you re-map URI requests to specific controller functions.
  |
  | Typically there is a one-to-one relationship between a URL string
  | and its corresponding controller class/method. The segments in a
  | URL normally follow this pattern:
  |
  |	example.com/class/method/id/
  |
  | In some instances, however, you may want to remap this relationship
  | so that a different class/function is called than the one
  | corresponding to the URL.
  |
  | Please see the user guide for complete details:
  |
  |	https://codeigniter.com/user_guide/general/routing.html
  |
  | -------------------------------------------------------------------------
  | RESERVED ROUTES
  | -------------------------------------------------------------------------
  |
  | There are three reserved routes:
  |
  |	$route['default_controller'] = 'welcome';
  |
  | This route indicates which controller class should be loaded if the
  | URI contains no data. In the above example, the "welcome" class
  | would be loaded.
  |
  |	$route['404_override'] = 'errors/page_missing';
  |
  | This route will tell the Router which controller/method to use if those
  | provided in the URL cannot be matched to a valid route.
  |
  |	$route['translate_uri_dashes'] = FALSE;
  |
  | This is not exactly a route, but allows you to automatically route
  | controller and method names that contain dashes. '-' isn't a valid
  | class or method name character, so it requires translation.
  | When you set this option to TRUE, it will replace ALL dashes in the
  | controller and method URI segments.
  |
  | Examples:	my-controller/index	-> my_controller/index
  |		my-controller/my-method	-> my_controller/my_method
 */

//$route['default_controller'] = 'home';
$route['default_controller'] = 'index';
$route['404_override'] = 'index/notfound';
$route['checklogin'] = 'index/checklogin';
$route['login'] = 'index/index';
$route['signup'] = 'index/signup';
$route['create_user'] = 'index/create_user';
$route['forgot_password'] = 'index/forgot_password';

$route['profile/(:any)'] = 'profile/profile';
$route['aboutus'] = 'home/aboutus';
$route['contact'] = 'home/contact';
$route['services'] = 'home/services';


$route['signup/patient'] = 'index/signup';
$route['signup/provider'] = 'index/provider_signup';
$route['create_provider_user'] = 'index/create_provider_user';
$route['signup/third_party'] = 'index/third_party_signup';
$route['create_third_party_user'] = 'index/create_third_party_user';
$route['signup/college'] = 'index/college_signup';
$route['create_college_user'] = 'index/create_college_user';

$route['checkout'] = 'index/checkout';

$route['activate/(:any)/(:any)'] = 'index/activate';
$route['update_password'] = 'index/update_password';
$route['change_password'] = 'index/change_password';


$route['reset_password/(:any)'] = 'index/reset_password';
$route['update_password_forgot/(:any)'] = 'index/update_password_forgot';
$route['provider/manage_profile'] = 'provider/manage_profile';
$route['manage_provider_profile'] = 'provider/manage_provider_profile';


/* $route['signup'] = 'index';
  $route['create_user'] = 'index';

  $route['forgot_password'] = 'index';
  $route['change_password'] = 'index';
  $route['logout'] = 'index';
  $route['checkout'] = 'index';
  $route['affiliateprogram'] = 'index';
  $route['affiliatereg'] = 'index';

  $route['coupon_code_validation/(:any)/(:any)/(:any)'] = 'index';

  $route['update_password/(:any)'] = 'index';
  $route['update_user_password/(:any)'] = 'index';
  $route['activate/(:any)/(:any)'] = 'index';
  $route['reset_password/(:any)'] = 'index';
  $route['user_update_password/(:any)'] = 'index';
  $route['username_availablity'] = 'index';
  $route['redirection'] = 'index'; */

$route['translate_uri_dashes'] = FALSE;
