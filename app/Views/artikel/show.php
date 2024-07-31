<?= $this->extend('layout/public'); ?>

<?= $this->section('content'); ?>
<div class="container px-5">
    <div class="row gx-5 justify-content-center">
        <div class="col-lg-10 col-xl-8">
            <div class="single-post">
                <h1>
                    <?= $artikel['judul']; ?>
                </h1>

                <div class="d-flex align-items-center justify-content-between mb-5">
                    <div class="single-post-meta me-4">
                        <img class="single-post-meta-img" src="<?= base_url($user->foto); ?>" />
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

                <div class="single-post-text my-5">
                    <?= $artikel['isi']; ?>
                    <hr class="my-5" />
                    <div class="text-center">
                        <a class="btn btn-transparent-dark" href="page-blog-overview.html">Back to
                            Blog Overview</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>