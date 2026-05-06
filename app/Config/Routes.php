<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// $routes->get('/', 'Controller::Cont');


//Routes livres
$routes->get('/', 'Matiere::index');

$routes->get('/note/ajout', 'Matiere::ajouter');

$routes->post('/note/ajout', 'Bibliotheque::ajouternote');

$routes->get('/etudiants', 'Matiere::alletudiants');

$routes->get('/etudiants/detail/(:num)', 'Matiere::detail/$1');


