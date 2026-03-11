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
|	https://codeigniter.com/userguide3/general/routing.html
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
$route['default_controller'] = 'Login';

$route['login'] = 'login/index';
$route['register'] = 'login/register';
$route['sign-up'] = 'login/sign_up';
$route['logout'] = 'login/logout';
$route['dashboard'] = 'dashboard/index';
$route['profile'] = 'profile/index';
$route['profile/update'] = 'profile/update';
$route['category'] = 'category/index';
$route['category/store'] = 'category/store';
$route['category/edit/(:num)'] = 'category/edit/$1';
$route['category/update/(:num)'] = 'category/update/$1';
$route['category/delete/(:num)'] = 'category/delete/$1';
$route['product'] = 'product/index';
$route['product/add'] = 'product/add';
$route['product/store'] = 'product/store';
$route['product/edit/(:num)'] = 'product/edit/$1';
$route['product/update/(:num)'] = 'product/update/$1';
$route['product/delete/(:num)'] = 'product/delete/$1';
$route['sales'] = 'sales/index';
$route['sales/add'] = 'sales/add';
$route['sales/store'] = 'sales/store';
$route['sales/customer-lookup'] = 'sales/customer_lookup';
$route['sales/download/(:num)'] = 'sales/download/$1';
$route['whatsapp-connect'] = 'sales/whatsapp_connect';

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
