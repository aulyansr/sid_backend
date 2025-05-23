<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SID | Kalurahan Tawarsari</title>

    <!-- Custom fonts for this template-->
    <link href="/assets/css/admin/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- dropify -->
    <link href="https://cdn.jsdelivr.net/npm/dropify@0.2.2/dist/css/dropify.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <link href="/assets/css/admin/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="/assets/css/admin/sb-admin-2.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="./img/gkk.png" type="image/x-icon">

</head>

<?php

$desa = new \App\Models\ConfigModel();
$desa = $desa->find(1);




?>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/admin">
                <div class="sidebar-brand-icon">
                    <!-- <i class="fas fa-laugh-wink"></i> -->
                    <img src="<?= base_url(esc($desa['logo'])); ?>" height="50px" alt="Logo Gunungkidul">
                </div>
                <div class="mx-3 text-sm align-left">
                    <small>SID Gunungkidul</small>
                    <br />
                    <?php if (session()->get('nama_villages')): ?>
                        <small> Desa <?= session()->get('nama_villages'); ?> </small>
                    <?php endif; ?>
                </div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="/admin">
                    <i class="fas fa-fw fa-home"></i>
                    <span>Beranda</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">


            <!-- Heading -->
            <div class="sidebar-heading">
                Data
            </div>

            <!-- Nav Item - Tables -->
            <?php if (auth()->user()->can('kelurahan.access') ||  (auth()->user()->inGroup('superadmin') || auth()->user()->inGroup('admin'))) : ?>

                <li class="nav-item">
                    <a class="nav-link" href="<?php echo getAdminUrl('penduduk');  ?>">
                        <i class="fas fa-fw fa-users"></i>
                        <span>Data Penduduk</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="/admin/verifikasi-data-pemohon">
                        <i class="fas fa-fw fa-users"></i>
                        <span>Verifikasi Data</span>
                        <span>Layanan kependudukan</span>
                    </a>
                </li>
            <?php endif; ?>

            <!-- Nav Item - Tables -->
            <li class="nav-item">
                <a class="nav-link" href="<?php echo getAdminUrl('analisis_master');  ?>">
                    <i class="fas fa-fw fa-chart-bar"></i>
                    <span>Statistik & Analisis
                    </span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="<?php echo getAdminUrl('program');  ?>">
                    <i class="fas fa-fw fa-hands-helping"></i>
                    <span>Program Bantuan</span></a>
            </li>

            <?php if (auth()->user()->can('articles.access')) : ?>

                <div class="sidebar-heading">
                    ARTIKEL & BERITA
                </div>


                <!-- Nav Item - Tables -->
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo getAdminUrl('artikel');  ?>">
                        <i class="fas fa-fw fa-user-lock"></i>
                        <span>
                            Kelola Artikel
                        </span>
                    </a>
                </li>
            <?php endif; ?>

            <?php if (auth()->user()->can('kelurahan.access')) : ?>
                <div class="sidebar-heading">
                    PERSURATAN
                </div>


                <!-- Nav Item - Tables -->
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo getAdminUrl('surat');  ?>">
                        <i class="fas fa-fw fa-print"></i>
                        <span>Cetak Surat</span></a>
                </li>

            <?php endif; ?>

            <!-- Nav Item - Tables -->

            <?php if (auth()->user()->inGroup('superadmin') || auth()->user()->inGroup('admin')) : ?>
                <div class="sidebar-heading">
                    Setting
                </div>


                <!-- Nav Item - Tables -->
                <li class="nav-item">
                    <a class="nav-link" href="<?= route_to('users_path') ?>">
                        <i class="fas fa-fw fa-id-card"></i>
                        <span>Manajemen Pengguna</span></a>
                </li>

                <!-- Nav Item - Tables -->

            <?php endif; ?>

            <?php if (auth()->user()->inGroup('superadmin')) : ?>
                <li class="nav-item">
                    <a class="nav-link" href="/admin/desa">
                        <i class="fas fa-cogs fa-sm fa-fw"></i>

                        <span>Konfigurasi  Desa</span></a>
                </li>



                <li class="nav-item">
                    <a class="nav-link" href="/admin/pengurus">
                        <i class="fas fa-user-shield"></i>

                        <span>Konfigurasi  Pemerintahan</span></a>
                </li>


            <?php endif; ?>




            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

            <!-- Sidebar Message -->
            <!-- <div class="sidebar-card d-none d-lg-flex">
                <img class="sidebar-card-illustration mb-2" src="/assets/img/undraw_rocket.svg" alt="...">
                <p class="text-center mb-2"><strong>SB Admin Pro</strong> is packed with premium features, components,
                    and more!</p>
                <a class="btn btn-success btn-sm" href="https://startbootstrap.com/theme/sb-admin-pro">Upgrade to
                    Pro!</a>
            </div> -->

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Search -->
                    <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search" method="get" action="<?php echo session()->get('desa_permalink_admin') ? '/' . session()->get('desa_permalink_admin') . '/admin/penduduk' : '/admin/penduduk'; ?>">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Masukkan kata kunci.." aria-label="Search" aria-describedby="basic-addon2" name="search">
                            <div class=" input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <!-- Nav Item - Alerts -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw"></i>
                                <!-- Counter - Alerts -->
                                <!-- <span class="badge badge-danger badge-counter">3+</span> -->
                            </a>
                            <!-- Dropdown - Alerts -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header">
                                    Notifikasi
                                </h6>
                                <!-- <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-success">
                                            <i class="fas fa-exclamation text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">2 November 2023 13:14</div>
                                        Akses anda telah dipulihkan. Hubungi admin jika terdapat kendala
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-warning">
                                            <i class="fas fa-exclamation text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">2 November 2023 13:14</div>
                                        Perhatian! Mohon update password anda karena ada akses mencurigakan
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-success">
                                            <i class="fas fa-exclamation text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">2 November 2023 13:14</div>
                                        Template surat baru telah dirilis
                                    </div>
                                </a>
                                <a class="dropdown-item text-center small text-gray-500" href="#">Lihat semua</a> -->
                            </div>
                        </li>

                        <!-- Nav Item - Messages -->
                        <li class="nav-item dropdown no-arrow mx-1 d-none">
                            <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-envelope fa-fw"></i>
                                <!-- Counter - Messages -->
                                <span class="badge badge-danger badge-counter">7</span>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="messagesDropdown">
                                <h6 class="dropdown-header">
                                    Pesan
                                </h6>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="/assets/img/undraw_profile_1.svg" alt="...">
                                    </div>
                                    <div class="font-weight-bold">
                                        <div class="text-truncate">Selamat siang. Apa bisa bantu carikan data penduduk untuk..</div>
                                        <div class="small text-gray-500">Joko Widodo</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="/assets/img/undraw_profile_1.svg" alt="...">
                                    </div>
                                    <div class="font-weight-bold">
                                        <div class="text-truncate">Cara mencetak dokumen bagaimana ya?</div>
                                        <div class="small text-gray-500">Gunawan Muhammad</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="/assets/img/undraw_profile_1.svg" alt="...">
                                    </div>
                                    <div class="font-weight-bold">
                                        <div class="text-truncate">Apakah ada template surat untuk pindah KK?</div>
                                        <div class="small text-gray-500">Budi Gunawan</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="/assets/img/undraw_profile_1.svg" alt="...">
                                    </div>
                                    <div class="font-weight-bold">
                                        <div class="text-truncate">Apakah ada template surat untuk pindah KK?</div>
                                        <div class="small text-gray-500">Budi Gunawan</div>
                                    </div>
                                </a>
                                <a class="dropdown-item text-center small text-gray-500" href="#">Lihat Semua</a>
                            </div>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                                    <?= isset(auth()->user()->nama) ? esc(auth()->user()->nama) : '-' ?>
                                </span>

                                <img class="img-profile rounded-circle" src="<?= isset(auth()->user()->foto) && !empty(auth()->user()->foto) ? base_url(esc(auth()->user()->foto)) : '/assets/img/undraw_profile.svg' ?>" alt="Profile Image">

                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="/admin/users/edit/<?= isset(auth()->user()->id) ? esc(auth()->user()->id) : '-' ?>">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profil
                                </a>
                                <a class="dropdown-item" href="/admin/users/edit/<?= isset(auth()->user()->id) ? esc(auth()->user()->id) : '-' ?>">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Pengaturan Akun
                                </a>

                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <?php if (session('error') !== null) : ?>
                        <div class="alert alert-danger" role="alert"><?= print_r(session('error')) ?></div>
                    <?php elseif (session('errors') !== null) : ?>
                        <div class="alert alert-danger" role="alert">
                            <?php if (is_array(session('errors'))) : ?>
                                <?php foreach (session('errors') as $error) : ?>
                                    <?= $error ?>
                                    <br>
                                <?php endforeach ?>
                            <?php else : ?>
                                <?= session('errors') ?>
                            <?php endif ?>
                        </div>
                    <?php endif ?>

                    <?php if (session('message') !== null) : ?>
                        <div class="alert alert-success" role="alert"><?= session('message') ?></div>
                    <?php endif ?>

                    <?php $this->renderSection('content'); ?>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; 2024. Sistem Informasi Desa (SID) Kabupaten Gunungkidul</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Anda yakin?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Pilih "Logout" untuk mengakhiri sesi anda..</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="/logout">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="/assets/js/admin/vendors/jquery/jquery.min.js"></script>
    <script src="/assets/js/admin/vendors/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="/assets/js/admin/vendors/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="/assets/js/admin/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="/assets/js/admin/vendors/chart.js/Chart.min.js"></script>
    <!-- dropify -->
    <script src=" https://cdn.jsdelivr.net/npm/dropify@0.2.2/dist/js/dropify.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>


    <?php $this->renderSection('script'); ?>


    <!-- Page level custom scripts -->

</body>

</html>
