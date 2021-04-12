<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'admin';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// $route['store/login'] = 'vender/store/login';
// // $route['store/signup'] = 'vender/store/signup';
// // $route['store/otp'] = 'vender/store/otp';
// // $route['store/dashboard'] = 'vender/store/dashboard';
// // $route['store/logout'] = 'vender/store/logout';
// // $route['store/forget'] = 'vender/store/forget';
// // $route['store/forget_password_otp'] = 'vender/store/forget_password_otp';
// // $route['store/create_password'] = 'vender/store/create_password';

// // $route['store/faq'] = 'vender/store/faq';
// // $route['store/about_us'] = 'vender/store/about_us';
// // $route['store/product'] = 'vender/store/product';
// // $route['store/addProduct'] = 'vender/store/addProduct';
// // $route['store/get_subcat'] = 'vender/store/get_subcat';
// // $route['store/update_profile'] = 'vender/store/update_profile';
// // $route['store/orders_request'] = 'vender/store/orders_request';
// // $route['store/ongoing_orders'] = 'vender/store/ongoing_orders';
// // $route['store/complete_orders'] = 'vender/store/complete_orders';
// // $route['store/change_password'] = 'vender/store/change_password';
// // $route['store/update_delivery_status'] = 'vender/store/update_delivery_status';
// // $route['store/view_request_orders_details/(:any)'] = 'vender/store/view_request_orders_details/$1';
// // $route['store/product_status/(:any)'] = 'vender/store/product_status/$1';
// // $route['store/delete_product/(:any)'] = 'vender/store/delete_product/$1';
// // $route['store/edit_product/(:any)'] = 'vender/store/edit_product/$1';
// // $route['store/product_image/(:any)'] = 'vender/store/product_image/$1';
// // $route['store/delete_product_image/(:any)'] = 'vender/store/delete_product_image/$1';
// // $route['store/add_more_img/(:any)'] = 'vender/store/add_more_img/$1';

// $route['lab/login'] = 'vender/lab/login';
// $route['lab/signup'] = 'vender/lab/signup';
// $route['lab/otp'] = 'vender/lab/otp';
// $route['lab/dashboard'] = 'vender/lab/dashboard';
// $route['lab/logout'] = 'vender/lab/logout';
// $route['lab/forget'] = 'vender/lab/forget';
// $route['lab/change_password'] = 'vender/lab/change_password';

// $route['lab/faq'] = 'vender/lab/faq';
// $route['lab/about_us'] = 'vender/lab/about_us';
// $route['lab/product'] = 'vender/lab/product';
// $route['lab/update_profile'] = 'vender/lab/update_profile';
// $route['lab/addProduct'] = 'vender/lab/addProduct';
// $route['lab/item_status/(:any)'] = 'vender/lab/item_status/$1';
// $route['lab/delete_item/(:any)'] = 'vender/lab/delete_item/$1';
// $route['lab/item_image/(:any)'] = 'vender/lab/item_image/$1';
// $route['lab/delete_item_image/(:any)'] = 'vender/lab/delete_item_image/$1';
// $route['lab/edit_item/(:any)'] = 'vender/lab/edit_item/$1';
// $route['lab/orders_request'] = 'vender/lab/orders_request';
// $route['lab/ongoing_orders'] = 'vender/lab/ongoing_orders';
// $route['lab/complete_orders'] = 'vender/lab/complete_orders';
// $route['lab/update_delivery_status'] = 'vender/lab/update_delivery_status';
// $route['lab/view_request_orders_details/(:any)'] = 'vender/lab/view_request_orders_details/$1';






// $route['lab/forget_password_otp'] = 'vender/lab/forget_password_otp';
// $route['lab/create_password'] = 'vender/lab/create_password';

$route['admin/dashboard'] = 'admin/admin/dashboard';
$route['admin/selected_product/(:any)'] = 'admin/product_requests/$1';
