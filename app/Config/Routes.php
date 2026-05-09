<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Routes d'authentification
$routes->get('/', 'AuthController::index');
$routes->post('auth/login', 'AuthController::login');
$routes->get('auth/logout', 'AuthController::logout');
$routes->get('auth/register', 'AuthController::register');
$routes->post('auth/signup', 'AuthController::signup');

// Routes du tableau de bord (protégées par le filtre auth)
$routes->group('dashboard', ['filter' => 'auth'], function($routes) {
    $routes->get('', 'DashboardController::index');
    $routes->get('stats', 'DashboardController::getStats');
    $routes->get('utilisateurs', 'DashboardController::utilisateurs');
    $routes->get('regimes', 'DashboardController::regimes');
    $routes->get('aliments', 'DashboardController::aliments');
});



