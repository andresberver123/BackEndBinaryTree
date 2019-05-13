<?php
defined('BASEPATH') OR exit('No direct script access allowed');


$route['default_controller'] = 'addNodos';
$route['404_override'] = '';
$route['translate_uri_dashes'] = TRUE;


// Routes for nodos
$route['nodos']['get'] = 'nodos/index';
$route['nodos/(:num)']['get'] = 'nodos/find/$1';
$route['nodos']['post'] = 'nodos/index';
$route['nodos/(:num)']['put'] = 'nodos/index/$1';
$route['nodos/(:num)']['delete'] = 'nodos/index/$1';

