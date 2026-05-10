<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ========== ROUTES PUBLIQUES ==========
$routes->group('', ['filter' => 'guest'], function($routes) {
    $routes->get('/', 'AuthController::login');
    $routes->get('/login', 'AuthController::login');
    $routes->post('/login', 'AuthController::attemptLogin');
    $routes->get('/register', 'AuthController::register');
    $routes->post('/register/personal', 'AuthController::storePersonal');
    $routes->get('/register/health', 'AuthController::healthForm');
    $routes->post('/register/health', 'AuthController::storeHealth');
    $routes->get('/register-client', 'AuthController::registerClient');
    $routes->post('/register-client', 'AuthController::processRegisterClient');
    $routes->post('/check-email', 'AuthController::checkEmail');
});

// ========== ROUTES PROTÉGÉES ==========
$routes->group('', ['filter' => 'auth'], function($routes) {
    $routes->get('/logout', 'AuthController::logout');
    $routes->get('/admin', 'AdminController::index');
    
    // CRUD Clients
    $routes->group('admin/clients', function($routes) {
        $routes->get('/', 'ClientController::index');
        $routes->get('view/(:num)', 'ClientController::view/$1');
        $routes->delete('delete/(:num)', 'ClientController::delete/$1');
    });
    
    // CRUD Régimes
    $routes->group('admin/regimes', function($routes) {
        $routes->get('/', 'RegimeController::index');
        $routes->get('create', 'RegimeController::create');
        $routes->post('store', 'RegimeController::store');
        $routes->get('edit/(:num)', 'RegimeController::edit/$1');
        $routes->post('update/(:num)', 'RegimeController::update/$1');
        $routes->delete('delete/(:num)', 'RegimeController::delete/$1');
    });
    
    // CRUD Activités
    $routes->group('admin/activites', function($routes) {
        $routes->get('/', 'ActiviteController::index');
        $routes->get('create', 'ActiviteController::create');
        $routes->post('store', 'ActiviteController::store');
        $routes->get('edit/(:num)', 'ActiviteController::edit/$1');
        $routes->post('update/(:num)', 'ActiviteController::update/$1');
        $routes->delete('delete/(:num)', 'ActiviteController::delete/$1');
    });
    
    // CRUD Paramètres
    $routes->group('admin/parametres', function($routes) {
        $routes->get('/', 'ParametreController::index');
        $routes->post('update/(:any)', 'ParametreController::update/$1');
    });
    
    // Gestion des codes Gold (ADMIN)
    $routes->group('admin/gold', function($routes) {
        $routes->get('/', 'GoldController::manageCodes');
        $routes->get('codes-and-purchases', 'GoldController::codesAndPurchases');
        $routes->post('generate', 'GoldController::generateCode');
        $routes->post('delete', 'GoldController::deleteCode');
        $routes->post('assign', 'GoldController::assignToClient');
        $routes->post('send-code-to-client', 'GoldController::sendCodeToClient');
    });
    
    // Achats Gold en attente (ADMIN)
    $routes->group('admin/gold-purchases', function($routes) {
        $routes->get('/', 'GoldController::managePurchases');
        $routes->post('assign', 'GoldController::assignCodeToPurchase');
    });
    
    // Routes clients
    $routes->get('/client', 'ClientController::dashboard');
    $routes->get('/client/dashboard', 'ClientController::dashboard');
    $routes->get('/client/regimes', 'ClientController::regimes');
    $routes->get('/client/activites', 'ClientController::activites');
    $routes->get('/client/wallet', 'ClientController::wallet');
    $routes->get('/client/notifications', 'NotificationController::index');
    
    // Notifications
    $routes->post('notifications/mark-as-read/(:num)', 'NotificationController::markAsRead/$1');
    $routes->get('notifications/unread-count', 'NotificationController::getUnreadCount');
    
    // Wallet et Gold
    $routes->post('wallet/validate-code', 'WalletController::validateCode');
    $routes->post('wallet/recharge', 'WalletController::recharge');
    $routes->post('wallet/buy-gold', 'WalletController::buyGold');
    $routes->get('wallet/balance', 'WalletController::getBalance');
    $routes->get('gold/subscribe', 'GoldController::subscribe');
    $routes->post('gold/validate-code', 'GoldController::validateCode');
});