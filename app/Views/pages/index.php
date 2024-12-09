<?= $this->extend('layout/public'); ?>


<?= $this->section('content'); ?>
<?php

use CodeIgniter\I18n\Time;
?>
<?= \Config\Services::helper('url'); ?>
<div class="container px-5">
    <!-- carousel -->
    <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <?php foreach ($headline as $index => $i) : ?>
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="<?= $index ?>" class="<?= $index === 0 ? 'active' : ''; ?>" aria-current="true" aria-label="Slide 1"></button>
            <?php endforeach; ?>

        </div>
        <div class="carousel-inner">
            <?php foreach ($headline as $index => $headline) : ?>
                <div class="carousel-item <?= $index === 0 ? 'active' : ''; ?>">

                    <div class="card-body p-0">
                        <div class="row g-0">
                            <div class="col-lg-6 p-5 bg-white">

                                <a class="badge badge-marketing bg-primary-soft rounded-pill text-primary mb-3" href="<?= route_to('detail_category_path', $headline['id_kategori']) ?>"><?= $headline['kategori_name']; ?></a>
                                <a class="text-dark" href="<?= session()->get('desa_permalink') ?> / <?= route_to('detail_article_path', $headline['id']); ?>">
                                    <h1>
                                        <?= $headline['judul']; ?>
                                    </h1>
                                </a>
                                <p>
                                    <?= esc(substr(strip_tags($headline['isi']), 0, 250)) . (strlen($headline['isi']) > 250 ? '...' : ''); ?>
                                </p>
                                <div class="flex-text align-self-center d-flex justify-content-between">
                                    <a class="text-arrow-icon small" href="<?= route_to('detail_article_path', $headline['id']); ?>">
                                        Selengkapnya
                                        <i data-feather="arrow-right"></i>
                                    </a>
                                    <small><?= Time::parse($headline['tgl_upload'])->humanize(); ?></small>
                                </div>
                            </div>
                            <div class="col-lg-6 align-self-stretch bg-img-cover d-none d-lg-flex" style="
                                background-image: url('  <?= $headline['gambar']; ?>');
                              "></div>
                        </div>
                    </div>
                </div>

            <?php endforeach; ?>

        </div>

    </div>

    <hr class="mb-4" />

    <!-- main row -->
    <div class="row gx-5">
        <!-- list artikel -->
        <div class="col-lg-7 col-xl-8">
            <?php foreach ($artikels as $index => $artikel) : ?>
                <div class="d-flex">
                    <div class="flex-grow-1">
                        <a class="text-dark" href="/<?= $village['permalink']; ?>/<?= route_to('detail_article_path', $artikel['id']); ?>">
                            <h5 class="mt-0">
                                <?= $artikel['judul']; ?>
                            </h5>
                        </a>
                        <p>
                            <?= esc(substr(strip_tags($artikel['isi']), 0, 250)) . (strlen($artikel['isi']) > 250 ? '...' : ''); ?>
                        </p>
                        <p class="timestamps text-sm">
                            <small><?= Time::parse($artikel['tgl_upload'])->humanize(); ?></small>

                        </p>
                        <a class="text-arrow-icon small" href="<?= $village['permalink']; ?><?= route_to('detail_article_path', $artikel['id']); ?>">
                            Selengkapnya
                            <i data-feather="arrow-right"></i>
                        </a>
                    </div>
                    <div class="flex-shrink-0 ms-4">
                        <?php
                        $originalImagePath = esc($artikel['gambar']);
                        $thumbnailImagePath = str_replace(basename($originalImagePath), 'thumb_' . basename($originalImagePath), $originalImagePath);
                        ?>
                        <img class="rounded mx-auto d-block" src="<?= base_url($thumbnailImagePath); ?>" alt="<?= $artikel['judul']; ?>" />
                    </div>
                </div>
                <?php if ($index < count($artikels) - 1) : ?>
                    <hr class="my-4" />
                <?php endif; ?>

            <?php endforeach; ?>
        </div>

        <!-- right side -->
        <div class="col-lg-5 col-xl-4 right-side">
            <div class="card statistik-kunjungan mb-4">
                <div class="card-body">
                    <h6>Galeri</h6>
                    <hr />
                    <div class="mb-5">
                        <?php if (!empty($gallery) && isset($gallery[0])) : ?>
                            <a class="card lift h-100" href="/<?= $village['permalink']; ?>/gallery/<?= $gallery[0]['id'] ?>">
                                <div class="card-flag card-flag-dark card-flag-top-right card-flag-lg">
                                    <?php
                                    $fotoModel = new \App\Models\GambarGalleryModel();
                                    $fotos = $fotoModel->where('parrent', $gallery[0]['id'])->where('desa_id', $village['id'])->findAll(); // Fetch all images for this gallery
                                    $total = count($fotos);
                                    ?>
                                    <?= $total; ?> Foto
                                </div>

                                <img class="card-img-top" src="<?= base_url($gallery[0]['gambar']); ?>" alt="..." />
                                <div class="card-body p-3">
                                    <div class="card-title small mb-0"><?= esc($gallery[0]['nama']); ?></div>
                                    <div class="text-xs text-gray-500"><?= Time::parse($gallery[0]['tgl_upload'])->humanize(); ?></div>
                                </div>
                            </a>
                        <?php else : ?>
                            <!-- Optionally, you can add some fallback content here -->
                            <p>No gallery items available.</p>
                        <?php endif; ?>

                    </div>
                    <a class="text-arrow-icon small align-right" href="/<?= $village['permalink']; ?>/gallery">
                        Selengkapnya
                        <i data-feather="arrow-right"></i>
                    </a>
                </div>
            </div>

            <!-- Komentar Terkini -->
            <div class="card komentar-terkini">
                <div class="card-body">
                    <h6>Komentar Terkini</h6>
                    <hr />
                    <?php if (!empty($comments) && is_array($comments)) : ?>
                        <?php foreach ($comments as $comment) : ?>
                            <div class="d-flex mb-4">
                                <div class="avatar avatar-lg">
                                    <img class="avatar-img" src="https://placehold.co/600x600?text=<?= esc($comment['owner'][0]); ?>" />
                                </div>
                                <div class="ms-3">
                                    <a class="text-dark" href="<?= route_to('detail_article_path', $comment['id_artikel']); ?>">
                                        <h6 class="mb-1">
                                            <?= esc($comment['komentar']); ?>
                                        </h6>
                                    </a>
                                    <div class="small text-gray-500">
                                        by
                                        <a class="text-gray-500" href="#!"><?= esc($comment['owner'][0]); ?></a>
                                    </div>
                                </div>
                            </div>

                        <?php endforeach; ?>
                    <?php else : ?>
                        <p>Belum ada komentar.</p>
                    <?php endif; ?>


                </div>
            </div>

            <!-- Statistik Kunjungan -->
            <div class="card statistik-kunjungan mt-4">
                <div class="card-body">
                    <h6>Statistik Kunjungan</h6>
                    <hr />
                    <div class="d-flex mb-4">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th scope="row">Hari ini</th>
                                    <td>2000</td>
                                </tr>
                                <tr>
                                    <th scope="row">Kemarin</th>
                                    <td>100</td>
                                </tr>
                                <tr>
                                    <th scope="row">Pengunjung</th>
                                    <td colspan="2">12000</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <hr class="my-4" />

    <!-- Kategori 1,2,3 -->
    <div class="row gx-5 mb-5">
        <?php $kategoriModel = new \App\Models\KategoriModel();
        $categories = $kategoriModel->orderBy('urut', 'ASC')->findAll(3);
        ?>
        <?php foreach ($categories as $item) : ?>
            <div class="col-lg-4">
                <h6><?= $item['kategori']; ?></h6>
                <hr class="my-4" />
                <?php
                $articleModel = new \App\Models\ArtikelModel();
                $articles = $articleModel->where('desa_id', $village['id'])->where('id_kategori', $item['id'])->findAll(); // Fetch all articles for this category
                ?>
                <?php foreach ($articles as $article) : ?>
                    <a class="text-dark mb-4" href=" <?= route_to('detail_article_path', $article['id']) ?>">
                        <small><?= Time::parse($article['tgl_upload'])->humanize(); ?></small>
                        <h6>
                            <?= $article['judul']; ?>
                        </h6>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>

    </div>

    <!-- pencarian -->
    <?= view('partials/search') ?>

</div>

<?= $this->endSection(); ?>