<?= $this->extend('layout/public'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid px-5">
    <div class="container px-5">
        <div class="row gx-5 justify-content-center">
            <div class="col-xl-6 col-lg-8 col-md-10 text-center py-5">
                <h2><?= $gambar_gallery['nama']; ?></h2>
                <p class="lead text-gray-500 mb-5">
                    Galeri yang berisi foto dan video untuk Album <?= $gambar_gallery['nama']; ?>
                </p>
            </div>
        </div>
    </div>
    <div class="row gx-5 mb-5">
        <?php foreach ($images as $index => $img) : ?>
            <div class="col-md-6 mb-5">
                <a class="card card-portfolio h-100" href="#!">
                    <img class="card-img-top" src="<?= base_url($img['gambar']); ?>" alt="..." />
                    <div class="card-body">
                        <div class="card-title"><?= $img['nama']; ?></div>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>

    </div>

    <!-- view more -->
    <!-- <div class="d-flex justify-content-center mt-5">
        <a class="text-arrow-icon small" href="#!">
            Lihat lebih
            <i data-feather="arrow-right"></i>
        </a>
    </div> -->
</div>

<?= $this->endSection(); ?>