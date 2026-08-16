<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');

/** Personas */
$routes->get('api/personas', 'CPersona::get_personas');
$routes->put('api/personas', 'CPersona::insert_persona');

/** Informes */
$routes->put('api/informes', 'CInformes::insert_informe');