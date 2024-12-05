<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title> SID</title>
    <link href="/assets/css/public/styles.css" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.png" />
    <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.29.0/feather.min.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.css" integrity="sha512-/zs32ZEJh+/EO2N1b0PEdoA10JkdC3zJ8L5FTiQu82LR9S/rOQNfQN7U59U9BC12swNeRAz3HSzIL2vpp4fv3w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<?php
$kategoriModel = new \App\Models\KategoriModel();
$desa = new \App\Models\ConfigModel();
$menu = new \App\Models\MenuModel();

$categories = $kategoriModel->orderBy('urut', 'ASC')->findAll();
$desa = $desa->find(1);
$menus = $menu->where('tipe', 1)->findAll();



?>

<body>
    <div id="layoutDefault">
        <div id="layoutDefault_content">
            <main>
                <div class="container">
                    <!-- Sub Navbar -->

                    <div class="text-center" style="margin-top:25vh">
                        <h1 class="mb-5">
                            Pilih Desa
                        </h1>
                        <div class="row g-4 justify-content-center mb-5">
                            <?php foreach ($villages as $index => $village): ?>


                                <div class="col-md-4">
                                    <a href="/<?= $village['permalink']; ?>">
                                        <div class="card">
                                            <div class="card-body">
                                                <h2>
                                                    <?= $village['nama_desa']; ?>
                                                </h2>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

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