<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'Landing/index';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;


$route['register'] = "Landing/register";
$route['login'] = "Landing/login";
$route['logout'] = "Landing/logout";
$route['inscripcion'] = "Landing/inscripcion";
$route['sala/(:num)'] = "Landing/detalleSala/$1";
$route['success/(:num)'] = "Landing/success/$1";
$route['failure/(:any)'] = "Landing/failure/$1";
$route['sala/(:num)/success'] = "Landing/detalleSala/$1/success";
$route['sala/(:num)/failure'] = "Landing/detalleSala/$1/failure";
$route['suplente/(:num)'] = "Landing/suplente/$1";

$route['changePassword'] = "Landing/changePassword";

$route['gracias'] = "Landing/gracias";

$route['misPartidos'] = "Sala/misPartidos";
$route['misPartidos/(:num)'] = "Sala/misPartidos/$1";

$route['salaListingFiltered'] = "Landing/salaListingFiltered";

$route['queEs'] = "Landing/queEs";
$route['puntos'] = "Landing/puntos";

$route['contact'] = "Landing/contact";

$route['deBaja'] = "Landing/deBaja";
$route['deBaja/(:num)'] = "Landing/deBaja/$1";

$route['failure'] = "Landing/failure";


