<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'admin';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['lab/login'] = 'lab/lab/login';
$route['lab/lab_timing'] = 'lab/lab/lab_timing';
$route['admin/dashboard'] = 'admin/admin/dashboard';
$route['admin/selected_product/(:any)'] = 'admin/product_requests/$1';
