<?= $this->extend('layout/public'); ?>

<?= $this->section('content'); ?>
<div class="container px-5">
    <div class="row gx-5 justify-content-center">
        <div class="col-lg-10 col-xl-8">
            <a class="badge badge-marketing bg-primary-soft rounded-pill text-primary mb-3" href="<?= route_to('detail_category_path', $kategori['id']) ?>"><?= $kategori['kategori']; ?></a>
            <div class="single-post">
                <h1>
                    <?= $artikel['judul']; ?>
                </h1>

                <div class="d-flex align-items-center justify-content-between mb-5">
                    <div class="single-post-meta me-4">
                        <img class="single-post-meta-img" src="<?= base_url($user->foto ?? 'assets/img/illustrations/profiles/profile-3.png'); ?>" />
                        <div class="single-post-meta-details">
                            <div class="single-post-meta-details-name">

                                <?= $user->full_name ?>
                            </div>
                            <div class="single-post-meta-details-date">
                                <?= $artikel['tgl_upload']->humanize(); ?>
                            </div>
                        </div>
                    </div>
                    <div class="single-post-meta-links">
                        <a href="#!"><i class="fab fa-twitter fa-fw"></i></a>
                        <a href="#!"><i class="fab fa-facebook-f fa-fw"></i></a>
                        <a href="#!"><i class="fas fa-bookmark fa-fw"></i></a>
                    </div>
                </div>

                <img class="img-fluid mb-2 rounded" src="<?= base_url($artikel['gambar']); ?>" />

                <div class="single-post-text my-5">
                    <?= $artikel['isi']; ?>

                    <div class="row">
                        <?php if (!empty($artikel['gambar1'])): ?>
                            <div class="col-md-6">
                                <img class="img-fluid mb-4 rounded" src="<?= base_url($artikel['gambar1']); ?>" />
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($artikel['gambar2'])): ?>
                            <div class="col-md-6">
                                <img class="img-fluid mb-4 rounded" src="<?= base_url($artikel['gambar2']); ?>" />
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($artikel['gambar3'])): ?>
                            <div class="col-md-6">
                                <img class="img-fluid mb-4 rounded" src="<?= base_url($artikel['gambar3']); ?>" />
                            </div>
                        <?php endif; ?>
                    </div>



                    <?php if (!empty($artikel['link_dokumen']) && !empty($artikel['dokumen'])): ?>
                        <p>Dokumen:</p>
                        <a href="<?= $artikel['link_dokumen']; ?>"><?= htmlspecialchars($artikel['dokumen']); ?></a>
                    <?php endif; ?>

                    <hr class="my-5" />
                    <div class="text-center">
                        <a class="btn btn-transparent-dark" href="<?= base_url(); ?>">
                            Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>

<?= dd($artikel); ?>