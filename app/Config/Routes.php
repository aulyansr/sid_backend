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
    'kategori/(:segment)',
    'KategoriController::show/$1',
    ['as' => 'detail_category_path']
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
$routes->get('/search-articles', 'Page::search', ['as' => 'search_articles_path']);
$routes->post('/komentar/store', 'KomentarController::store');

$routes->group('admin', ['filter' => 'session'],  function ($routes) {

    $routes->get('ajax/pamong/search', 'AjaxController::searchPamong');
    $routes->get('ajax/penduduk/search', 'AjaxController::searchPenduduk');
    $routes->get('ajax/getRW/(:num)', 'AjaxController::getRW/$1');
    $routes->get('ajax/getRT/(:num)', 'AjaxController::getRT/$1');


    $routes->get('dashboard', 'Dashboard::index');

    $routes->get('users', 'UserController::index', ['as' => 'users_path', 'filter' => 'permission:users.access']);
    $routes->get('users/new', 'UserController::new', ['as' => 'new_users_path', 'filter' => 'permission:users.create']);
    $routes->post('users/store', 'UserController::store', ['filter' => 'permission:users.create']);
    $routes->get('users/edit/(:segment)', 'UserController::edit/$1', ['as' => 'edit_user_path', 'filter' => 'permission:users.update']);
    $routes->post('users/update', 'UserController::update', ['filter' => 'permission:users.update']);
    $routes->get('users/delete/(:segment)', 'UserController::delete/$1', ['as' => 'delete_user_path', 'filter' => 'permission:users.delete']);
    $routes->get('users/permissions/(:segment)', 'UserController::permission/$1', ['as' => 'user_permission_view', 'filter' => 'permission:users.permission']);
    $routes->post('users/add-permission/(:segment)', 'UserController::add_permission/$1', ['as' => 'user_permission_add', 'filter' => 'permission:users.permission']);

    $routes->get('config', 'ConfigController::index', [
        'as' => 'config_path',
        'filter' => 'permission:config.access'
    ]);

    $routes->get('config/new', 'ConfigController::new', [
        'as' => 'new_config_path',
        'filter' => 'permission:config.create'
    ]);

    $routes->post('config/store', 'ConfigController::store', [
        'filter' => 'permission:config.create'
    ]);

    $routes->get('config/edit/(:segment)', 'ConfigController::edit/$1', [
        'as' => 'edit_config_path',
        'filter' => 'permission:config.update'
    ]);

    $routes->post('config/update/(:segment)', 'ConfigController::update/$1', [
        'filter' => 'permission:config.update'
    ]);

    $routes->get('config/delete/(:segment)', 'ConfigController::delete/$1', [
        'as' => 'delete_config_path',
        'filter' => 'permission:config.delete'
    ]);;

    $routes->get('media_sosial', 'MediaSosialController::index');
    $routes->get('media_sosial/new', 'MediaSosialController::new');
    $routes->post('media_sosial/store', 'MediaSosialController::store');
    $routes->get('media_sosial/edit/(:segment)', 'MediaSosialController::edit/$1');
    $routes->post('media_sosial/update/(:segment)', 'MediaSosialController::update/$1');
    $routes->get('media_sosial/delete/(:segment)', 'MediaSosialController::delete/$1');

    // Routes for Menu
    $routes->group('', ['filter' => 'permission:menus.access'], function ($routes) {
        $routes->get('menu', 'MenuController::index');
        $routes->get('menu/new', 'MenuController::new', ['filter' => 'permission:menus.create']);
        $routes->post('menu/store', 'MenuController::store', ['filter' => 'permission:menus.create']);
        $routes->get('menu/(:num)', 'MenuController::show/$1', ['filter' => 'permission:menus.read']);
        $routes->get('menu/add/(:any)', 'MenuController::add_children/$1', ['filter' => 'permission:menus.create']);
        $routes->post('menu/store_children', 'MenuController::store_children', ['filter' => 'permission:menus.create']);
        $routes->get('menu/edit/(:segment)', 'MenuController::edit/$1', ['filter' => 'permission:menus.update']);
        $routes->post('menu/update/(:segment)', 'MenuController::update/$1', ['filter' => 'permission:menus.update']);
        $routes->get('menu/delete/(:segment)', 'MenuController::delete/$1', ['filter' => 'permission:menus.delete']);
    });

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
    // Routes for Articles
    $routes->group('', ['filter' => 'permission:articles.access'], function ($routes) {
        $routes->get('artikel', 'ArtikelController::index');
        $routes->get('artikel/new', 'ArtikelController::new', ['filter' => 'permission:articles.create']);
        $routes->post('artikel/store', 'ArtikelController::store', ['filter' => 'permission:articles.create']);
        $routes->get('artikel/edit/(:segment)', 'ArtikelController::edit/$1', ['filter' => 'permission:articles.update']);
        $routes->post('artikel/update/(:segment)', 'ArtikelController::update/$1', ['filter' => 'permission:articles.update']);
        $routes->get('artikel/delete/(:segment)', 'ArtikelController::delete/$1', ['filter' => 'permission:articles.delete']);
    });

    // Routes for Gallery
    $routes->group('', ['filter' => 'permission:galleries.access'], function ($routes) {
        $routes->get('gambar-gallery', 'GambarGalleryController::index');
        $routes->get('gambar-gallery/(:num)', 'GambarGalleryController::view/$1', ['filter' => 'permission:galleries.read']);
        $routes->get('gambar-gallery/new', 'GambarGalleryController::new', ['filter' => 'permission:galleries.create']);
        $routes->get('gambar-gallery/add-image', 'GambarGalleryController::add_image', ['filter' => 'permission:galleries.create']);
        $routes->post('gambar-gallery/store', 'GambarGalleryController::store', ['filter' => 'permission:galleries.create']);
        $routes->get('gambar-gallery/edit/(:num)', 'GambarGalleryController::edit/$1', ['filter' => 'permission:galleries.update']);
        $routes->post('gambar-gallery/update/(:num)', 'GambarGalleryController::update/$1', ['filter' => 'permission:galleries.update']);
        $routes->get('gambar-gallery/delete/(:num)', 'GambarGalleryController::delete/$1', ['filter' => 'permission:galleries.delete']);
    });


    $routes->get('dokumen', 'DokumenController::index');
    $routes->get('dokumen/new', 'DokumenController::new');
    $routes->post('dokumen/store', 'DokumenController::store');
    $routes->get('dokumen/edit/(:segment)', 'DokumenController::edit/$1');
    $routes->post('dokumen/update/(:segment)', 'DokumenController::update/$1');
    $routes->get('dokumen/delete/(:segment)', 'DokumenController::delete/$1');

    $routes->get('surat', 'SuratController::index');
    $routes->get('surat/create/(:any)', 'SuratController::create/$1');
    $routes->post('surat/store', 'SuratController::store');
    $routes->get('surat/export/(:num)/(:segment)', 'SuratController::export/$1/$2');
    $routes->get('surat/delete/(:segment)', 'SuratController::delete/$1');

    $routes->get('komentar', 'KomentarController::index');
    $routes->get('komentar/create', 'KomentarController::create');
    $routes->post('komentar/store', 'KomentarController::store');
    $routes->get('komentar/disable/(:num)', 'KomentarController::disable/$1', [
        'filter' => 'permission:comments.moderation'
    ]);
    $routes->get('komentar/delete/(:num)', 'KomentarController::delete/$1');



    $routes->resource('TwebSuratFormat');
    $routes->resource('pengurus', ['controller' => 'DesaPamong', 'placeholder' => '(:num)']);
    $routes->resource('wilayah', ['controller' => 'ClusterDesa', 'placeholder' => '(:num)']);
    $routes->get('wilayah/add-rw/(:any)', 'ClusterDesa::new_rw/$1');
    $routes->get('wilayah/rw/(:any)', 'ClusterDesa::index_rw/$1');
    $routes->get('wilayah/add-rt/(:any)', 'ClusterDesa::new_rt/$1');
    $routes->resource('penduduk', ['controller' => 'Penduduk', 'placeholder' => '(:num)']);
    $routes->resource('keluarga', ['controller' => 'Keluarga', 'placeholder' => '(:num)']);






    // $routes->get('Article', 'Article::index');
});
