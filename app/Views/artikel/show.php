<?= $this->extend('layout/public'); ?>

     <?= $this->section('content'); ?>
<div class = "container px-5">
<div class = "row gx-5 justify-content-center">
<div class = "col-lg-10 col-xl-8">
<a   class = "badge badge-marketing bg-primary-soft rounded-pill text-primary mb-3" href = "<?= route_to('detail_category_path', $kategori['id']) ?>"><? = $kategori['kategori']; ?></a>
<div class = "single-post">
                <h1>
                    <?= $artikel['judul']; ?>
                </h1>

                <div class = "d-flex align-items-center justify-content-between mb-5">
                <div class = "single-post-meta me-4">
                <img class = "single-post-meta-img" src = "<?= base_url($user->foto ?? 'assets/img/illustrations/profiles/profile-3.png'); ?>" />
                <div class = "single-post-meta-details">
                <div class = "single-post-meta-details-name">

                                <?= $user->full_name ?>
                            </div>
                            <div class = "single-post-meta-details-date">
                                 <?= $artikel['tgl_upload']->humanize(); ?>
                            </div>
                        </div>
                    </div>
                    <div class = "single-post-meta-links">
                    <a   href  = "#!"><i class = "fab fa-twitter fa-fw"></i></a>
                    <a   href  = "#!"><i class = "fab fa-facebook-f fa-fw"></i></a>
                    <a   href  = "#!"><i class = "fas fa-bookmark fa-fw"></i></a>
                    </div>
                </div>

                <img class = "img-fluid mb-2 rounded" src = "<?= base_url($artikel['gambar']); ?>" />

                <div class = "single-post-text my-5">
                     <?= $artikel['isi']; ?>

                    <div class = "row">
                        <?php if (!empty($artikel['gambar1'])): ?>
                            <div class = "col-md-6">
                            <img class = "img-fluid mb-4 rounded" src = "<?= base_url($artikel['gambar1']); ?>" />
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($artikel['gambar2'])): ?>
                            <div class = "col-md-6">
                            <img class = "img-fluid mb-4 rounded" src = "<?= base_url($artikel['gambar2']); ?>" />
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($artikel['gambar3'])): ?>
                            <div class = "col-md-6">
                            <img class = "img-fluid mb-4 rounded" src = "<?= base_url($artikel['gambar3']); ?>" />
                            </div>
                        <?php endif; ?>
                    </div>



                    <?php if (!empty($artikel['link_dokumen']) && !empty($artikel['dokumen'])): ?>
                          <p>Dokumen                                                          : </p>
                        <a href = "<?= $artikel['link_dokumen']; ?>"><? = htmlspecialchars($artikel['dokumen']); ?></a>
                    <?php endif; ?>

                    <hr  class = "my-5" />
                    <div class = "text-center">
                    <a   class = "btn btn-transparent-dark" href = "<?= base_url(); ?>">
                            Kembali
                        </a>
                    </div>
                </div>
            </div>
            <h2>Komentar</h2>
            <?php if (!empty($comments) && is_array($comments)): ?>
            <?php foreach ($comments as $comment)              : ?>
                    <div class = "card mb-3">
                    <div class = "card-body">
                    <div class = "row">
                    <div class = "col-1">
                    <img src   = "https://placehold.co/600x600?text=<?= esc($comment['owner'][0]); ?>" alt = "<?= esc($comment['owner']); ?>" class = "w-100" style = "border-radius: 50%;">
                                </div>
                                <div      class = "col-8">
                                <h4       class = "mb-0"><?= esc($comment['owner']); ?></h4>
                                          <p><?= esc($comment['komentar']); ?></p>
                                <small><i class = "fa-regular fa-clock"></i> <?= esc($comment['tgl_upload']); ?></small>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Belum ada komentar.</p>
            <?php endif; ?>

            <hr class = "my-5" />
            <h2>Tulis Komentar</h2>
            <form  class = "form-floating" action = "/komentar/store" method = "post">
                   <?= csrf_field(); ?>
            <div   class = "form-floating mb-3">
            <input type  = "text" class           = "form-control" id        = "floatingInputName" placeholder = "nama" name = "owner">
            <label for   = "floatingInput">
                Nama
            </label>
                </div>
                <div   class = "form-floating mb-3">
                <input type  = "email" class = "form-control" id = "floatingInput" placeholder = "name@example.com" name = "email">
                    <label for="floatingInput">Email address</label>
                </div>
                <div class="form-floating mb-3">
                    <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea" name="komentar" style="height: 100px"></textarea>
                    <label for="floatingTextarea">Komentar</label>
                </div>
                <input type="hidden" name="id_artikel" value="<?= esc($artikel['id']); ?>">
                <button class="btn btn-primary" type="submit">Kirim</button>

            </form>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>