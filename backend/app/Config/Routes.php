<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');

/** Personas */
$routes->get('api/personas/(:num)', 'CPersona::get_persona/$1');
$routes->get('api/personas', 'CPersona::get_personas');
$routes->put('api/personas', 'CPersona::insert_persona');
$routes->options('api/personas', static function () {
    return service('response')->setStatusCode(204);
});

/** Informes */
$routes->put('api/informes', 'CInformes::insert_informe');