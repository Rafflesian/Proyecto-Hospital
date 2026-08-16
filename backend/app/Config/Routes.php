<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');

/** Personas */
$routes->get('api/personas/(:num)', 'CPersona::get_persona/$1');
$routes->get('api/personas', 'CPersona::get_personas');
$routes->put('api/personas', 'CPersona::insert_persona');
$routes->patch('api/personas', 'CPersona::update_persona');

$routes->options('api/personas', static function () {
    return service('response')->setStatusCode(204);
});

/** Informes */
$routes->get('api/informes/(:num)', 'CInforme::get_informe/$1');
$routes->get('api/informes/persona/(:num)', 'CInforme::get_informe_persona/$1');
$routes->put('api/informes', 'CInforme::insert_informe');
$routes->patch('api/informes', 'CInforme::update_informe');

$routes->options('api/informes', static function () {
    return service('response')->setStatusCode(204);
});