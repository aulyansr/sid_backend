<?= $this->extend('layout/public'); ?>
<?php


use CodeIgniter\I18n\Time;
?>
<?= $this->section('content'); ?>
<div class="container px-5">

    <!-- Breadcrumb -->
    <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="home.html">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Kategori</li>
        </ol>
    </nav>

    <hr class="mb-4" />
    <div class="row gx-5">
        <div class="col-lg-12">
            <?php if (!empty($articles)) : ?>
                <?php foreach ($articles as $index => $artikel) : ?>
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <a class="text-dark" href="<?= route_to('detail_article_path', $artikel['id']); ?>">
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
                            <a class="text-arrow-icon small" href="<?= route_to('detail_article_path', $artikel['id']); ?>">
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
                    <?php if ($index < count($articles) - 1) : ?>
                        <hr class="my-4" />
                    <?php endif; ?>

                <?php endforeach; ?>
                <hr class="my-4 d-lg-none" />
            <?php else: ?>
                <div class="my-5 py-5">
                    <p>No articles found.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- pagination -->

</div>

<?= $this->endSection(); ?>