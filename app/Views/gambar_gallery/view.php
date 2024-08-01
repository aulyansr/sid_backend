<?= $this->extend('layout/dashboard'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid">
    <div class="text-center mb-5">
        <h1 class="h3 mb-2 text-gray-800 text-center">Album <?= esc($gambar_gallery['nama']); ?></h1>

    </div>

    <div class="row mx-lg-n5 justify-content-center">
        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-body">
                    <img src="<?= base_url(esc($gambar_gallery['gambar'])); ?>" class="w-100">
                </div>
                <div class="card-footer">
                    <a href="<?= site_url('/admin/gambar-gallery/edit/' . esc($gambar_gallery['id'])); ?>" class="btn btn-secondary">Ubah</a>
                </div>
            </div>
        </div>
        <div class="col-12"></div>
        <?php foreach ($images as $img) : ?>
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <img src="<?= base_url(esc($img['gambar'])); ?>" class="w-100">
                        <h3>
                            <?= esc($img['nama']); ?>
                        </h3>
                        <div class="d-flex">
                            <a href="<?= site_url('/admin/gambar-gallery/edit/' . esc($img['id'])); ?>" class="btn btn-warning w-100 mr-1">Edit</a>
                            <a href="<?= site_url('/admin/gambar-gallery/delete/' . esc($img['id'])); ?>" class="btn btn-danger w-100">Hapus</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        <div class="col-md-4 mb-3">
            <div class="d-flex justify-content-center align-items-center" style="height: 100px; border: 1px dashed #000;">
                <a href="<?= site_url('/admin/gambar-gallery/add-image/?parrent_id=' . esc($gambar_gallery['id'])); ?>" class="btn btn-sm btn-success" title="Add Image">
                    <i class="fas fa-plus"></i> Add Image
                </a>

            </div>
        </div>
    </div>

</div>
<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script>
    $('.dropify').dropify();
</script>
<?= $this->endSection(); ?>