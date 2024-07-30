<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
service('auth')->routes($routes);

$routes->get('/', 'Page::index');
$routes->get('page/index', 'Page::index');
$routes->get('admin', 'Dashboard::index', ['filter' => 'session']);

$routes->group('admin', ['filter' => 'session'],  function ($routes) {

    $routes->get('dashboard', 'Dashboard::index');
    $routes->group('', ['filter' => 'group:superadmin'], function ($routes) {
        $routes->get('users', 'UserController::index', ['as' => 'users_path']);
        $routes->get('users/new', 'UserController::new', ['as' => 'new_users_path']);
        $routes->post('users/store', 'UserController::store');
        $routes->get('users/edit/(:segment)', 'UserController::edit/$1', ['as' => 'edit_user_path']);
        $routes->post('users/update', 'UserController::update');
        $routes->get('users/delete/(:segment)', 'UserController::delete/$1', ['as' => 'delete_user_path']);

        $routes->get('config', 'ConfigController::index', ['as' => 'config_path']);
        $routes->get('config/new', 'ConfigController::new', ['as' => 'new_config_path']);
        $routes->post('config/store', 'ConfigController::store');
        $routes->get('config/edit/(:segment)', 'ConfigController::edit/$1', ['as' => 'edit_config_path']);
        $routes->post('config/update/(:segment)', 'ConfigController::update/$1');
        $routes->get('config/delete/(:segment)', 'ConfigController::delete/$1', ['as' => 'delete_config_path']);

        $routes->get('media_sosial', 'MediaSosialController::index');
        $routes->get('media_sosial/new', 'MediaSosialController::new');
        $routes->post('media_sosial/store', 'MediaSosialController::store');
        $routes->get('media_sosial/edit/(:segment)', 'MediaSosialController::edit/$1');
        $routes->post('media_sosial/update/(:segment)', 'MediaSosialController::update/$1');
        $routes->get('media_sosial/delete/(:segment)', 'MediaSosialController::delete/$1');

        $routes->get('menu', 'MenuController::index');
        $routes->get('menu/new', 'MenuController::new');
        $routes->post('menu/store', 'MenuController::store');
        $routes->get('menu/edit/(:segment)', 'MenuController::edit/$1');
        $routes->post('menu/update/(:segment)', 'MenuController::update/$1');
        $routes->get('menu/delete/(:segment)', 'MenuController::delete/$1');

        $routes->get('setting_modul', 'SettingModulController::index');
        $routes->get('setting_modul/new', 'SettingModulController::new');
        $routes->post('setting_modul/store', 'SettingModulController::store');
        $routes->get('setting_modul/edit/(:segment)', 'SettingModulController::edit/$1');
        $routes->post('setting_modul/update/(:segment)', 'SettingModulController::update/$1');
        $routes->get('setting_modul/delete/(:segment)', 'SettingModulController::delete/$1');
    });
    // $routes->get('Article', 'Article::index');
});
