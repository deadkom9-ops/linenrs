<?php defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'auth/login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['dashboard'] = 'dashboard';

$route['dirtyrequests'] = 'dirtyrequests/index';
$route['dirtyrequests/create'] = 'dirtyrequests/create';
$route['dirtyrequests/show/(:num)'] = 'dirtyrequests/show/$1';
$route['dirtyrequests/take/(:num)'] = 'dirtyrequests/take/$1';
$route['dirtyrequests/approve/(:num)'] = 'dirtyrequests/approve/$1';
$route['dirtyrequests/reject/(:num)'] = 'dirtyrequests/reject/$1';
$route['dirtyrequests/delete/(:num)'] = 'dirtyrequests/delete/$1';


$route['cleanorders'] = 'cleanorders/index';
$route['cleanorders/create'] = 'cleanorders/create';
$route['cleanorders/show/(:num)'] = 'cleanorders/show/$1';
$route['cleanorders/approve/(:num)'] = 'cleanorders/approve/$1';
$route['cleanorders/reject/(:num)'] = 'cleanorders/reject/$1';
$route['cleanorders/deliver/(:num)'] = 'cleanorders/deliver/$1';
$route['cleanorders/delete/(:num)'] = 'cleanorders/delete/$1';


$route['damagereports'] = 'damagereports/index';
$route['damagereports/create'] = 'damagereports/create';
$route['damagereports/show/(:num)'] = 'damagereports/show/$1';
$route['damagereports/ack/(:num)'] = 'damagereports/ack/$1';
$route['damagereports/delete/(:num)'] = 'damagereports/delete/$1';

$route['washweights'] = 'washweights/index';
$route['washweights/create'] = 'washweights/create';
$route['washweights/edit/(:num)']   = 'washweights/edit/$1';
$route['washweights/delete/(:num)'] = 'washweights/delete/$1';
$route['washweights/proses/(:num)'] = 'washweights/proses/$1';


$route['units'] = 'units/index';
$route['units/create'] = 'units/create';
$route['units/edit/(:num)'] = 'units/edit/$1';
$route['units/delete/(:num)'] = 'units/delete/$1';

$route['linentypes'] = 'linentypes/index';
$route['linentypes/create'] = 'linentypes/create';
$route['linentypes/edit/(:num)'] = 'linentypes/edit/$1';
$route['linentypes/delete/(:num)'] = 'linentypes/delete/$1';

$route['shifts'] = 'shifts/index';
$route['shifts/create'] = 'shifts/create';
$route['shifts/edit/(:num)'] = 'shifts/edit/$1';
$route['shifts/delete/(:num)'] = 'shifts/delete/$1';
