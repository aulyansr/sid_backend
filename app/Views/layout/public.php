<!DOCTYPE html>
<html lang="en">
<?php
$kategoriModel = new \App\Models\KategoriModel();
$desa = new \App\Models\ConfigModel();
$menu = new \App\Models\MenuModel();

$categories = $kategoriModel->orderBy('urut', 'ASC')->findAll();
$desa = $desa->find(1);
$menus = $menu->where('tipe', 1)->findAll();



?>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title> <?= $desa['nama_desa']; ?></title>
    <link href="/assets/css/public/styles.css" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.png" />
    <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.29.0/feather.min.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.css" integrity="sha512-/zs32ZEJh+/EO2N1b0PEdoA10JkdC3zJ8L5FTiQu82LR9S/rOQNfQN7U59U9BC12swNeRAz3HSzIL2vpp4fv3w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>


<body>
    <div id="layoutDefault">
        <div id="layoutDefault_content">
            <main>
                <!-- Sub Navbar -->
                <nav class="d-none d-md-block bg-color-1">
                    <div class="container">
                        <ul class="nav justify-content-end nav-header-sub">
                            <?php foreach ($menus as $item) : ?>
                                <?php if ($item['link_tipe'] == 1) : ?>
                                    <li class="nav-item dropdown">
                                        <a class="nav-link link-light dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false"><?= $item['nama']; ?></a>
                                        <ul class="dropdown-menu">
                                            <?php
                                            $submenus = $menu->where('parrent', $item['id'])->findAll();
                                            ?>
                                            <?php foreach ($submenus as $submenu) : ?>
                                                <li><a class="dropdown-item" href="<?= $submenu['link']; ?>"><?= $submenu['nama']; ?></a></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </li>
                                <?php else : ?>
                                    <li class="nav-item"><a href="<?= $item['link']; ?>" class="nav-link link-light small"><?= $item['nama']; ?></a></li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </nav>

                <!-- Navbar-->
                <nav class="navbar navbar-marketing navbar-expand-lg bg-gray-500 navbar-light">
                    <div class="container px-5">

                        <div class="logo d-flex justify-content-center p-3">
                            <div class="logo">
                                <a href=" <?= base_url() ?> ">
                                    <img src="<?= base_url(esc($desa['logo'])); ?>" alt="Gunung Kidul" height="90">
                                </a>
                            </div>

                            <div class="ms-4 d-flex flex-column justify-content-end">
                                <h4 class="">Kalurahan <?= $desa['nama_desa']; ?></h4>
                                <p class="lh-1">
                                    <small class="lh-1">Kapanewon <?= $desa['nama_kecamatan']; ?></small><br>
                                    <small class="lh-1">Kabupaten <?= $desa['nama_kabupaten']; ?></small>
                                </p>
                            </div>
                        </div>

                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><i data-feather="menu"></i></button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav ms-auto me-lg-5">
                                <li class="nav-item"><a class="nav-link" href=" <?= base_url() ?> ">Beranda</a></li>

                                <?php foreach ($categories as $item) : ?>

                                    <li class="nav-item dropdown no-caret">
                                        <a class="nav-link dropdown-toggle" id="navbarDropdown<?= $item['id'] ?>" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <?= esc($item['kategori']) ?>
                                            <i class="fas fa-chevron-right dropdown-arrow"></i>
                                        </a>

                                        <div class="dropdown-menu dropdown-menu-end animated--fade-in-up" aria-labelledby="navbarDropdown<?= $item['id'] ?>">
                                            <?php
                                            $articleModel = new \App\Models\ArtikelModel();
                                            $articles = $articleModel->where('id_kategori', $item['id'])->findAll(); // Fetch all articles for this category
                                            $totalArticles = count($articles);

                                            ?>

                                            <?php foreach ($articles as $index => $article) : ?>
                                                <a class="dropdown-item py-3" href="<?= route_to('detail_article_path', $article['id']) ?>" target="_blank">
                                                    <div>
                                                        <div class="small text-gray-500"><?= date('d F Y', strtotime($article['tgl_upload'])) ?></div>
                                                        <?= esc($article['judul']) ?>
                                                    </div>
                                                </a>

                                                <?php if ($index < ($totalArticles - 1)) : ?>
                                                    <div class="dropdown-divider m-0"></div>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </div>
                                    </li>


                                <?php endforeach; ?>

                                <li class="nav-item dropdown d-block d-sm-block d-md-none">
                                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">Profile</a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#">Sejarah Desa</a></li>
                                        <li><a class="dropdown-item" href="#">Potensi Desa</a></li>
                                    </ul>
                                </li>
                                <li class="nav-item dropdown d-block d-sm-block d-md-none">
                                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">Pemerintahan Desa</a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#">Visi Dan Misi</a></li>
                                        <li><a class="dropdown-item" href="#">Pemerintah Desa</a></li>
                                    </ul>
                                </li>
                                <li class="nav-item d-block d-sm-block d-md-none"><a href="" class="nav-link small">Lembaga Masyarakat</a></li>
                                <li class="nav-item d-block d-sm-block d-md-none"><a href="" class="nav-link small">Data
                                        Desa</a></li>
                                <li class="nav-item d-block d-sm-block d-md-none"><a href="" class="nav-link small">Kontak</a></li>
                            </ul>
                            <a class="btn fw-500 ms-lg-4 btn-teal" href="#bx-search">
                                Pencarian
                                <i class="ms-2" data-feather="arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </nav>

                <section class="bg-light py-10">
                    <?php $this->renderSection('content'); ?>
                    <div class="svg-border-rounded text-dark">
                        <!-- Rounded SVG Border-->
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 144.54 17.34" preserveAspectRatio="none" fill="currentColor">
                            <path d="M144.54,17.34H0V0H144.54ZM0,0S32.36,17.34,72.27,17.34,144.54,0,144.54,0"></path>
                        </svg>
                    </div>
                </section>



            </main>
        </div>

        <div id="layoutDefault_footer">
            <footer class="footer pt-10 pb-5 mt-auto bg-dark footer-dark">
                <div class="container px-5">
                    <div class="row gx-5">
                        <div class="col-lg-3">
                            <div class="footer-brand">
                                <img src="<?= base_url(esc($desa['logo'])); ?>" class="w-20">
                            </div>
                            <div class="mb-3">
                                <p>Kalurahan <?= $desa['nama_desa']; ?></p>
                                <small><?= $desa['alamat_kantor']; ?></small><br />
                                <small>Kapanewon <?= $desa['nama_kecamatan']; ?>, Kabupaten <?= $desa['nama_kabupaten']; ?></small>
                            </div>
                            <div class="icon-list-social mb-5">
                                <a class="icon-list-social-link" href="#!"><i class="fab fa-instagram"></i></a>
                                <a class="icon-list-social-link" href="#!"><i class="fab fa-facebook"></i></a>
                                <a class="icon-list-social-link" href="#!"><i class="fab fa-twitter"></i></a>
                                <a class="icon-list-social-link" href="#!"><i class="fab fa-youtube"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-9">
                            <div class="row gx-5">
                                <div class="col-lg-4 col-md-6 mb-5 mb-lg-0">
                                    <div class="text-uppercase-expanded text-xs mb-4">
                                        Profil Desa
                                    </div>
                                    <ul class="list-unstyled mb-0">
                                        <li class="mb-2"><a href="single.html">Sejarah Desa</a></li>
                                        <li class="mb-2"><a href="single.html">Potensi Desa</a></li>
                                        <li class="mb-2"><a href="single.html">Visi Misi Desa</a></li>
                                        <li class="mb-2"><a href="single.html">Pemerintah Desa</a></li>
                                        <li class="mb-2"><a href="single.html">Lembaga Masyarakat</a></li>
                                        <li class="mb-2"><a href="single.html">Hubungi Kami</a></li>
                                    </ul>
                                </div>
                                <div class="col-lg-4 col-md-6 mb-5 mb-lg-0">
                                    <div class="text-uppercase-expanded text-xs mb-4">
                                        Data Desa
                                    </div>
                                    <ul class="list-unstyled mb-0">

                                        <li class="mb-2"><a href="/statistik/pendidikan-dalam-kk">Data Pendidikan</a></li>
                                        <li class="mb-2"><a href="/statistik/pekerjaan">Data Pekerjaan</a></li>
                                        <li class="mb-2"><a href="/statistik/kelompok-umur">Data Kelompok Umur</a></li>
                                        <li class="mb-2"><a href="/statistik/agama">Data Agama</a></li>
                                        <li class="mb-2"><a href="/statistik/jenis-kelamin">Data Jenis Kelamin</a></li>
                                    </ul>
                                </div>
                                <div class="col-lg-4 col-md-6 mb-5 mb-md-0">
                                    <div class="text-uppercase-expanded text-xs mb-4">
                                        Informasi Desa
                                    </div>
                                    <ul class="list-unstyled mb-0">
                                        <li class="mb-2"><a href="kategori.html">Berita Desa</a></li>
                                        <li class="mb-2"><a href="kategori.html">Produk Desa</a></li>
                                        <li class="mb-2"><a href="kategori.html">Agenda Desa</a></li>
                                        <li class="mb-2"><a href="kategori.html">Peraturan Desa</a></li>
                                        <li class="mb-2"><a href="kategori.html">Laporan Desa</a></li>
                                        <li class="mb-2"><a href="kategori.html">Panduan Layanan Desa</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="my-5" />
                    <div class="row gx-5 align-items-center">
                        <div class="col-md-6 small">
                            Copyright &copy;
                            <script>
                                document.write(new Date().getFullYear());
                            </script>. Sistem Informasi Desa (SID)
                            Kabupaten <?= $desa['nama_kabupaten']; ?>
                        </div>
                        <div class="col-md-6 text-md-end small">
                            <a href="privasi.html">Kebijakan Privasi</a>
                            &middot;
                            <a href="ketentuan.html">Syarat &amp; Ketentuan</a>
                            &middot;
                            <a href="tentang-sid.html">Tentang &amp; SID</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="/assets/js/public/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js" integrity="sha512-d9xgZrVZpmmQlfonhQUvTR7lMPtO7NkZMkA0ABN3PHCbKA5nqylQ/yWlFAyY6hYgdF1Qh6nYiuADWwKB4C2WSw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <?php $this->renderSection('script'); ?>
</body>

</html>