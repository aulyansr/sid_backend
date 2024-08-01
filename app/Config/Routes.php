<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
service('auth')->routes($routes);

$routes->get('/', 'Page::index');
$routes->get('page/index', 'Page::index');
$routes->get('admin', 'Dashboard::index', ['filter' => 'session']);
$routes->get(
    'artikel',
    'Page::articles',
    ['as' => 'articles_path']
);
$routes->get(
    'artikel/(:segment)',
    'ArtikelController::show/$1',
    ['as' => 'detail_article_path']
);
$routes->get(
    'kategori',
    'Page::categories',
    ['as' => 'categories_path']
);
$routes->get(
    'gallery/(:segment)',
    'GambarGalleryController::show/$1',
    ['as' => 'detail_gallery_path']
);
$routes->get(
    'gallery/',
    'Page::galleries',
    ['as' => 'galleries_path']
);

$routes->group('admin', ['filter' => 'session'],  function ($routes) {

    $routes->get('dashboard', 'Dashboard::index');
    $routes->group('', ['filter' => 'group:superadmin'], function ($routes) {
        $routes->get('users', 'UserController::index', ['as' => 'users_path']);
        $routes->get('users/new', 'UserController::new', ['as' => 'new_users_path']);
        $routes->post('users/store', 'UserController::store');
        $routes->get('users/edit/(:segment)', 'UserController::edit/$1', ['as' => 'edit_user_path']);
        $routes->post('users/update', 'UserController::update');
        $routes->get('users/delete/(:segment)', 'UserController::delete/$1', ['as' => 'delete_user_path']);
    });

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

    $routes->get('kategori', 'KategoriController::index');
    $routes->get('kategori/new', 'KategoriController::new');
    $routes->post('kategori/store', 'KategoriController::store');
    $routes->get('kategori/edit/(:segment)', 'KategoriController::edit/$1');
    $routes->post('kategori/update/(:segment)', 'KategoriController::update/$1');
    $routes->get('kategori/delete/(:segment)', 'KategoriController::delete/$1');

    $routes->get('artikel', 'ArtikelController::index');
    $routes->get('artikel/new', 'ArtikelController::new');
    $routes->post('artikel/store', 'ArtikelController::store');

    $routes->get('artikel/edit/(:segment)', 'ArtikelController::edit/$1');
    $routes->post('artikel/update/(:segment)', 'ArtikelController::update/$1');
    $routes->get('artikel/delete/(:segment)', 'ArtikelController::delete/$1');

    $routes->get('gambar-gallery', 'GambarGalleryController::index');
    $routes->get('gambar-gallery/(:num)', 'GambarGalleryController::view/$1');
    $routes->get('gambar-gallery/new', 'GambarGalleryController::new');
    $routes->get('gambar-gallery/add-image/', 'GambarGalleryController::add_image');
    $routes->post('gambar-gallery/store', 'GambarGalleryController::store');
    $routes->get('gambar-gallery/edit/(:num)', 'GambarGalleryController::edit/$1');
    $routes->post('gambar-gallery/update/(:num)', 'GambarGalleryController::update/$1');
    $routes->get('gambar-gallery/delete/(:num)', 'GambarGalleryController::delete/$1');



    // $routes->get('Article', 'Article::index');
});
