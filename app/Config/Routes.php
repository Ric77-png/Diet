<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'AuthController::login');
$routes->get('/login', 'AuthController::login');
$routes->post('/login', 'AuthController::attemptLogin');
$routes->get('/logout', 'AuthController::logout');

// CRUD Régimes
$routes->group('admin/regimes', ['filter' => 'auth'], function($routes) {
    $routes->get('/', 'RegimeController::index');
    $routes->get('create', 'RegimeController::create');
    $routes->post('store', 'RegimeController::store');
    $routes->get('edit/(:num)', 'RegimeController::edit/$1');
    $routes->post('update/(:num)', 'RegimeController::update/$1');
    $routes->delete('delete/(:num)', 'RegimeController::delete/$1');
});

// CRUD Activités
$routes->group('admin/activites', ['filter' => 'auth'], function($routes) {
    $routes->get('/', 'ActiviteController::index');
    $routes->get('create', 'ActiviteController::create');
    $routes->post('store', 'ActiviteController::store');
    $routes->get('edit/(:num)', 'ActiviteController::edit/$1');
    $routes->post('update/(:num)', 'ActiviteController::update/$1');
    $routes->delete('delete/(:num)', 'ActiviteController::delete/$1');
});

// CRUD Paramètres
$routes->group('admin/parametres', ['filter' => 'auth'], function($routes) {
    $routes->get('/', 'ParametreController::index');
    $routes->post('update/(:any)', 'ParametreController::update/$1');
});

// Wallet et Gold
$routes->post('wallet/validate-code', 'WalletController::validateCode');
$routes->get('wallet/balance', 'WalletController::getBalance');
$routes->get('gold/subscribe', 'GoldController::subscribe');
$routes->post('gold/purchase', 'GoldController::purchase');