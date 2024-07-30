<?= $this->extend('layout/dashboard'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800 text-center">Form Media Sosial</h1>
    <div class="row justify-content-center">
        <div class="col-xl-8">
            <!-- Media Sosial details card -->
            <div class="card mb-4">
                <div class="card-header">Detail Media Sosial</div>
                <div class="card-body">
                    <form action="<?= site_url('/admin/media_sosial/store'); ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field(); ?>

                        <!-- Form Row -->
                        <div class="row gx-3 mb-3">
                            <!-- Form Group (nama) -->
                            <div class="col-md-12 mb-3">
                                <label class="small mb-1" for="inputNama">Nama</label>
                                <input class="form-control" id="inputNama" name="nama" type="text" placeholder="Nama Media Sosial" value="<?= old('nama'); ?>" required>
                            </div>
                            <!-- Form Group (link) -->
                            <div class="col-md-12 mb-3">
                                <label class="small mb-1" for="inputLink">Link</label>
                                <input class="form-control" id="inputLink" name="link" type="text" placeholder="Link Media Sosial" value="<?= old('link'); ?>" required>
                            </div>
                            <!-- Form Group (gambar) -->
                            <div class="col-md-12 mb-3">
                                <label class="small mb-1" for="inputGambar">Gambar</label>
                                <input class="form-control-file" id="inputGambar" name="gambar" type="file" required>
                            </div>
                        </div>

                        <!-- Form Group (enabled) -->
                        <div class="mb-3">
                            <label class="small mb-1" for="inputEnabled">Enabled</label>
                            <select class="form-control" id="inputEnabled" name="enabled" required>
                                <option value="1" <?= old('enabled') == '1' ? 'selected' : ''; ?>>Enabled</option>
                                <option value="0" <?= old('enabled') == '0' ? 'selected' : ''; ?>>Disabled</option>
                            </select>
                        </div>

                        <!-- Submit button -->
                        <button class="btn btn-primary" type="submit">Tambah Media Sosial</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>