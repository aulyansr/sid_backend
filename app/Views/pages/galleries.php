<?= $this->extend('layout/public'); ?>

<?= $this->section('content'); ?>

<div class="container px-5">
    <div class="row gx-5 justify-content-center">
        <div class="col-xl-6 col-lg-8 col-md-10 text-center py-5">
            <h2>Galeri Kalurahan Candirejo</h2>
            <p class="lead text-gray-500 mb-5">Album galeri Kalurahan Candirejo berisi dokumentasi
                hal-hal penting dan menarik lainnya untuk dibagikan ke publik</p>
        </div>
    </div>
</div>
<div class="container px-5">
    <div class="row gx-5">
        <?php foreach ($galleries as $index => $gallery) : ?>

            <div class="col-md-6 col-xl-4 mb-5">
                <a class="card post-preview lift h-100" href="<?= route_to('detail_gallery_path', $gallery['id']); ?>">
                    <img class="card-img-top" src="<?= $gallery['gambar']; ?>" alt="..." class="w-100" />
                    <div class="card-body">
                        <h5 class="card-title"><?= $gallery['nama']; ?></h5>
                        <p class="card-text">
                            <!-- Kegiatan penyemprotan Pestisida Di Padukunan Blembem -->
                        </p>
                    </div>
                    <div class="card-footer d-flex justify-content-between align-items-center">
                        <div class="post-preview-meta">
                            <img class="post-preview-meta-img" src="assets/img/illustrations/profiles/profile-2.png" />
                            <div class="post-preview-meta-details">
                                <div class="post-preview-meta-details-name">
                                    Budi Gunawan
                                </div>
                                <div class="post-preview-meta-details-date">
                                    3 hari yang lalu
                                </div>
                            </div>
                        </div>

                        <div class="items">
                            <small> <?php
                                    $fotoModel = new \App\Models\GambarGalleryModel();
                                    $fotos     = $fotoModel->where('parrent', $gallery['id'])->findAll();  // Fetch all articles for this category
                                    $total     = count($fotos);
                                    ?>
                                <?= $total; ?> Foto</small>
                        </div>
                    </div>
                </a>
            </div>

        <?php endforeach; ?>
    </div>
    <?= $pager->links('galleries', 'custom_pagination', 2) ?>
</div>

<?= $this->endSection(); ?>