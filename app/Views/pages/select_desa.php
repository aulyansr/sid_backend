<?= $this->extend('layout/select_desa'); ?>

<?= $this->section('content'); ?>
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
<?= $this->endSection(); ?>