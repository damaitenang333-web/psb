<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
// Route Publik
$routes->get('/', 'Home::index');

$routes->get('dashboard', 'HomeController::dashboard', ['filter' => 'session']);

// Route khusus Calon Santri (harus login & role santri)
$routes->group('santri', ['filter' => 'group:santri'], static function ($routes) {
    $routes->get('dashboard', 'SantriController::index');
    $routes->get('formulir', 'SantriController::formulir');
    $routes->post('simpan', 'SantriController::simpan');
    $routes->get('profile', 'SantriController::profile');
    $routes->post('update-profile', 'SantriController::updateProfile');
    
});

$routes->group('admin', ['filter' => 'group:admin'], static function ($routes) {
    // Dashboard Admin
    $routes->get('dashboard', 'Admin\DashboardController::index');

    // Kelola Pendaftaran
    $routes->group('pendaftaran', static function ($routes) {
        $routes->get('/', 'Admin\PendaftaranController::index');
        $routes->get('detail/(:num)', 'Admin\PendaftaranController::detail/$1');
        $routes->post('update-status/(:num)', 'Admin\PendaftaranController::updateStatus/$1');
        $routes->get('cetak/(:num)', 'Admin\PendaftaranController::cetak/$1');
    });

    // Kelola Blog
    $routes->group('blog', static function ($routes) {
        $routes->get('posts', 'Admin\BlogController::index');
        $routes->get('posts/create', 'Admin\BlogController::create');
        $routes->post('posts/store', 'Admin\BlogController::store');
        $routes->get('posts/edit/(:num)', 'Admin\BlogController::edit/$1');
        $routes->post('posts/update/(:num)', 'Admin\BlogController::update/$1');
        $routes->delete('posts/delete/(:num)', 'Admin\BlogController::delete/$1');
        
        // Categories
        $routes->get('categories', 'Admin\CategoryController::index');
    });
});

service('auth')->routes($routes);
