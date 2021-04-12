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
$route['default_controller'] = 'vender';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['store/login'] = 'vender/store/login';
$route['store/signup'] = 'vender/store/signup';
$route['store/otp'] = 'vender/store/otp';
$route['store/dashboard'] = 'vender/store/dashboard';
$route['store/logout'] = 'vender/store/logout';
$route['store/forget'] = 'vender/store/forget';
$route['store/forget_password_otp'] = 'vender/store/forget_password_otp';
$route['store/create_password'] = 'vender/store/create_password';

$route['store/faq'] = 'vender/store/faq';
$route['store/about_us'] = 'vender/store/about_us';
$route['store/product'] = 'vender/store/product';
$route['store/addProduct'] = 'vender/store/addProduct';
$route['store/get_subcat'] = 'vender/store/get_subcat';
$route['store/update_profile'] = 'vender/store/update_profile';
$route['store/orders_request'] = 'vender/store/orders_request';
$route['store/ongoing_orders'] = 'vender/store/ongoing_orders';
$route['store/complete_orders'] = 'vender/store/complete_orders';
$route['store/change_password'] = 'vender/store/change_password';
$route['store/update_delivery_status'] = 'vender/store/update_delivery_status';
$route['store/view_request_orders_details/(:any)'] = 'vender/store/view_request_orders_details/$1';
$route['store/product_status/(:any)'] = 'vender/store/product_status/$1';
$route['store/delete_product/(:any)'] = 'vender/store/delete_product/$1';
$route['store/edit_product/(:any)'] = 'vender/store/edit_product/$1';
$route['store/product_image/(:any)'] = 'vender/store/product_image/$1';
$route['store/delete_product_image/(:any)'] = 'vender/store/delete_product_image/$1';
$route['store/add_more_img/(:any)'] = 'vender/store/add_more_img/$1';

$route['restaurant/login'] = 'vender/restaurant/login';
$route['restaurant/signup'] = 'vender/restaurant/signup';
$route['restaurant/otp'] = 'vender/restaurant/otp';
$route['restaurant/dashboard'] = 'vender/restaurant/dashboard';
$route['restaurant/logout'] = 'vender/restaurant/logout';
$route['restaurant/forget'] = 'vender/restaurant/forget';
$route['restaurant/change_password'] = 'vender/restaurant/change_password';

$route['restaurant/faq'] = 'vender/restaurant/faq';
$route['restaurant/about_us'] = 'vender/restaurant/about_us';
$route['restaurant/product'] = 'vender/restaurant/product';
$route['restaurant/update_profile'] = 'vender/restaurant/update_profile';
$route['restaurant/addProduct'] = 'vender/restaurant/addProduct';
$route['restaurant/item_status/(:any)'] = 'vender/restaurant/item_status/$1';
$route['restaurant/delete_item/(:any)'] = 'vender/restaurant/delete_item/$1';
$route['restaurant/item_image/(:any)'] = 'vender/restaurant/item_image/$1';
$route['restaurant/delete_item_image/(:any)'] = 'vender/restaurant/delete_item_image/$1';
$route['restaurant/edit_item/(:any)'] = 'vender/restaurant/edit_item/$1';
$route['restaurant/orders_request'] = 'vender/restaurant/orders_request';
$route['restaurant/ongoing_orders'] = 'vender/restaurant/ongoing_orders';
$route['restaurant/complete_orders'] = 'vender/restaurant/complete_orders';
$route['restaurant/update_delivery_status'] = 'vender/restaurant/update_delivery_status';
$route['restaurant/view_request_orders_details/(:any)'] = 'vender/restaurant/view_request_orders_details/$1';






$route['restaurant/forget_password_otp'] = 'vender/restaurant/forget_password_otp';
$route['restaurant/create_password'] = 'vender/restaurant/create_password';

$route['admin/dashboard'] = 'admin/admin/dashboard';
$route['admin/selected_product/(:any)'] = 'admin/product_requests/$1';
