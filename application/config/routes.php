<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

//$route['api/(:any)'] = 'api/action/$1';
$route['api/(:any)/(:any)'] = 'api/action/$1/$2';

