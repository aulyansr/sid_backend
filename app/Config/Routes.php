<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
service('auth')->routes($routes);

$routes->get('/', 'Page::index');
$routes->get('page/index', 'Page::index');
$routes->get('admin', 'Dashboard::index', ['filter' => 'session']);

$routes->get('artikel', 'Page::articles', ['as' => 'articles_path']);
$routes->get('artikel/(:num)', 'ArtikelController::show/$1', ['as' => 'detail_article_path']);


$routes->get('kategori', 'Page::categories', ['as' => 'categories_path']);
$routes->get('kategori/(:segment)', 'KategoriController::show/$1', ['as' => 'detail_category_path']);


$routes->get('kategori', 'Page::categories');
$routes->get('kategori/(:num)', 'KategoriController::show/$1');



$routes->post('komentar/store', 'KomentarController::store');

$routes->group('(:segment)/', function ($routes) {
    $routes->get('', 'Page::desa/$1');
    $routes->get('artikel/(:num)', 'ArtikelController::show/$2');
    $routes->get('artikel-kategori/(:num)', 'Page::page_category/$1/$2');
    $routes->get('search-articles', 'Page::search', ['as' => 'search_articles_path']);
    $routes->get('gallery', 'Page::galleries');
    $routes->get('gallery/(:num)', 'GambarGalleryController::show/$1/$2');



    $routes->get('statistik/pendidikan-dalam-kk', 'Page::statistik_pendidikan_kk/$1');
    $routes->get('statistik/pendidikan-ditempuh', 'Page::statistik_pendidikan_ditempuh/$1');
    $routes->get('statistik/pekerjaan', 'Page::statistik_pekerjaan/$1');
    $routes->get('statistik/agama', 'Page::statistik_agama/$1');
    $routes->get('statistik/kelompok-umur', 'Page::statistik_kelompok_umur/$1');
    $routes->get('statistik/jenis-kelamin', 'Page::statistik_jenis_kelamin/$1');
});

$routes->group('(:segment)/admin', function ($routes) {

    $routes->get('', 'Dashboard::index/$1');
    $routes->get('dashboard', 'Dashboard::index/$1');

    $routes->get('artikel', 'ArtikelController::index');

    $routes->get('analisis_master', 'AnalisisMaster::index', ['filter' => 'permission:kelurahan.access']);


    $routes->get('penduduk', 'Penduduk::index/$1');


    $routes->group('analisis_master', function ($routes) {
        $routes->get('(:num)/kategori-indikators', 'AnalisisKategoriIndikator::index/$2');
    });


    $routes->get('program', 'ProgramController::index');

    $routes->get('surat', 'SuratController::index');
});


$routes->group('admin', ['filter' => 'session'],  function ($routes) {

    $routes->get('ajax/pamong/search', 'AjaxController::searchPamong');
    $routes->get('ajax/kk/search', 'AjaxController::search_kk');
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

    $routes->group('', ['filter' => 'permission:articles.access'], function ($routes) {
        $routes->get('artikel', 'ArtikelController::index');
        $routes->get('artikel/new', 'ArtikelController::new', ['filter' => 'permission:articles.create']);
        $routes->post('artikel/store', 'ArtikelController::store', ['filter' => 'permission:articles.create']);
        $routes->get('artikel/edit/(:segment)', 'ArtikelController::edit/$1', ['filter' => 'permission:articles.update']);
        $routes->post('artikel/update/(:segment)', 'ArtikelController::update/$1', ['filter' => 'permission:articles.update']);
        $routes->get('artikel/delete/(:segment)', 'ArtikelController::delete/$1', ['filter' => 'permission:articles.delete']);
    });


    $routes->group('', ['filter' => 'permission:galleries.access'], function ($routes) {
        $routes->get('gambar-gallery', 'GambarGalleryController::index');
        $routes->get('gambar-gallery/(:num)', 'GambarGalleryController::views/$1', ['filter' => 'permission:galleries.read']);
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
    $routes->resource('pengurus', ['controller' => 'DesaPamong', 'placeholder' => '(:num)', 'filter' => 'permission:kelurahan.access']);
    $routes->resource('wilayah', ['controller' => 'ClusterDesa', 'placeholder' => '(:num)', 'filter' => 'permission:kelurahan.access']);
    $routes->get('wilayah/add-rw/(:any)', 'ClusterDesa::new_rw/$1');
    $routes->get('wilayah/rw/(:any)', 'ClusterDesa::index_rw/$1');
    $routes->get('wilayah/add-rt/(:any)', 'ClusterDesa::new_rt/$1');
    $routes->resource('penduduk', ['controller' => 'Penduduk', 'placeholder' => '(:num)', 'filter' => 'permission:kelurahan.access']);
    $routes->resource('keluarga', ['controller' => 'Keluarga', 'placeholder' => '(:num)', 'filter' => 'permission:kelurahan.access']);
    $routes->resource('rumah-tangga', ['controller' => 'Rtm', 'placeholder' => '(:num)', 'filter' => 'permission:kelurahan.access']);
    $routes->post('rumah-tangga/create_rtm_kk', 'Rtm::create_rtm_kk');
    $routes->resource('kelompok', ['controller' => 'Kelompok', 'placeholder' => '(:num)', 'filter' => 'permission:kelurahan.access']);
    $routes->resource('master-kelompok', ['controller' => 'KelompokMaster', 'placeholder' => '(:num)', 'filter' => 'permission:kelurahan.access']);
    $routes->resource('kelompok', ['controller' => 'Kelompok', 'placeholder' => '(:num)', 'filter' => 'permission:kelurahan.access']);

    $routes->resource('analisis_master', ['controller' => 'AnalisisMaster', 'placeholder' => '(:num)', 'filter' => 'permission:kelurahan.access']);
    $routes->get('analisis_master/(:num)/subjects', 'AnalisisMaster::showSubjects/$1');
    $routes->get('analisis_master/(:num)/reports', 'AnalisisMaster::reports/$1');
    $routes->get('analisis_master/(:num)/input/(:any)', 'AnalisisRespon::new/$1/$2');
    $routes->get('analisis-respon/(:num)/reset/subject/(:num)', 'AnalisisRespon::reset/$1/$2');


    $routes->resource('kategori-indikators', ['controller' => 'analisisKategoriIndikator', 'placeholder' => '(:num)', 'filter' => 'permission:kelurahan.access']);
    $routes->get('analisis_master/(:num)/kategori-indikators', 'AnalisisKategoriIndikator::index/$1');
    $routes->get('analisis_master/(:num)/kategori-indikators/new', 'AnalisisKategoriIndikator::new/$1');
    $routes->post('analisis-kategori', 'AnalisisKategoriIndikator::create/$1');
    $routes->resource('analisis-kategori', ['controller' => 'AnalisisKategoriIndikator', 'placeholder' => '(:num)']);
    $routes->get('kategori-indikators/delete/(:num)', 'AnalisisKategoriIndikator::delete/$1');

    $routes->get('analisis_master/(:num)/analisis-indikators', 'AnalisisIndikator::index/$1');
    $routes->get('analisis_master/(:num)/analisis-indikators/new', 'AnalisisIndikator::new/$1');
    $routes->resource('analisis-indikators', ['controller' => 'AnalisisIndikator', 'placeholder' => '(:num)']);

    $routes->resource('analisis-parameter', ['controller' => 'AnalisisParameter', 'placeholder' => '(:num)']);

    $routes->get('analisis_master/(:num)/analisis-klasifikasi', 'AnalisisKlasifikasi::index/$1');
    $routes->get('analisis_master/(:num)/analisis-klasifikasi/new', 'AnalisisKlasifikasi::new/$1');
    $routes->resource('analisis-klasifikasi', ['controller' => 'AnalisisKlasifikasi', 'placeholder' => '(:num)']);

    $routes->resource('analisis-respon', ['controller' => 'AnalisisRespon', 'placeholder' => '(:num)']);

    $routes->get('analisis_master/(:num)/analisis-periode', 'AnalisisPeriode::index/$1');
    $routes->get('analisis_master/(:num)/analisis-periode/new', 'AnalisisPeriode::new/$1');
    $routes->resource('analisis-periode', ['controller' => 'AnalisisPeriode', 'placeholder' => '(:num)']);


    $routes->resource('program', ['controller' => 'ProgramController', 'placeholder' => '(:num)']);

    $routes->post('program/add-peserta', 'ProgramController::add_peserta/$1');

    $routes->get('desa', 'Desa::index');
    $routes->get('desa/create', 'Desa::create');
    $routes->post('desa/store', 'Desa::store');
    $routes->get('desa/edit/(:num)', 'Desa::edit/$1');
    $routes->post('desa/update/(:num)', 'Desa::update/$1');
    $routes->get('desa/delete/(:num)', 'Desa::delete/$1');

    $routes->get('kelurahan', 'Kelurahan::index');
    $routes->get('kelurahan/create', 'Kelurahan::create');
    $routes->post('kelurahan/store', 'Kelurahan::store');
    $routes->get('kelurahan/edit/(:num)', 'Kelurahan::edit/$1');
    $routes->post('kelurahan/update/(:num)', 'Kelurahan::update/$1');
    $routes->get('kelurahan/delete/(:num)', 'Kelurahan::delete/$1');






    $routes->get('verifikasi-data-pemohon', 'PelayananDukcapil::verifikasi_data');
    $routes->get('verifikasi-detail-permohonan', 'PelayananDukcapil::verifikasi_detail_permohonan');
    $routes->post('verifikasi-detail-permohonan', 'PelayananDukcapil::verifikasi_detail_permohonan');
    $routes->get('verifikasi-upload-dokumen', 'PelayananDukcapil::verifikasi_upload_dokumen');
    $routes->post('verifikasi-upload-dokumen', 'PelayananDukcapil::verifikasi_upload_dokumen');
    $routes->post('simpan-permohonan', 'PelayananDukcapil::store');
    $routes->get('progres-pelayanan', 'PelayananDukcapil::progres_pelayanan');
    $routes->get('siap-ambil', 'PelayananDukcapil::siap_ambil');
    $routes->get('rekap-layanan', 'PelayananDukcapil::rekap_layanan');

    $routes->get('layanandukcapil/new', 'PelayananDukcapil::new');
    $routes->post('layanandukcapil/store', 'PelayananDukcapil::store');
    $routes->post('layanandukcapil/upload', 'PelayananDukcapil::upload');
    $routes->post('layanandukcapil/push', 'PelayananDukcapil::push');
    $routes->get('layanandukcapil/edit/(:segment)', 'PelayananDukcapil::edit/$1');
    $routes->post('layanandukcapil/update/(:segment)', 'PelayananDukcapil::update/$1');
    $routes->get('layanandukcapil/delete/(:segment)', 'PelayananDukcapil::delete/$1');
});
