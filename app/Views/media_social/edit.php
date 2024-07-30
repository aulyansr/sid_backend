<?= $this->extend('layout/dashboard'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800 text-center">Edit Media Sosial</h1>
    <div class="row justify-content-center">
        <div class="col-xl-8">
            <!-- Media Sosial details card -->
            <div class="card mb-4">
                <div class="card-header">Detail Media Sosial</div>
                <div class="card-body">
                    <form action="<?= site_url('/admin/media_sosial/update/' . $medsos['id']); ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field(); ?>

                        <!-- Form Row -->
                        <div class="row gx-3 mb-3">
                            <!-- Form Group (nama) -->
                            <div class="col-md-12 mb-3">
                                <label class="small mb-1" for="inputNama">Nama</label>
                                <input class="form-control" id="inputNama" name="nama" type="text" placeholder="Nama Media Sosial" value="<?= old('nama', $medsos['nama']); ?>" required>
                            </div>
                            <!-- Form Group (link) -->
                            <div class="col-md-12 mb-3">
                                <label class="small mb-1" for="inputLink">Link</label>
                                <input class="form-control" id="inputLink" name="link" type="text" placeholder="Link Media Sosial" value="<?= old('link', $medsos['link']); ?>" required>
                            </div>
                            <!-- Form Group (gambar) -->
                            <div class="col-md-12 mb-3">
                                <label class="small mb-1" for="inputGambar">Gambar</label>
                                <?php if ($medsos['gambar']) : ?>
                                    <div class="mb-2">
                                        <img src="<?= base_url($medsos['gambar']); ?>" alt="Current Image" class="img-thumbnail" style="max-width: 200px;">
                                    </div>
                                <?php endif; ?>
                                <input class="form-control-file" id="inputGambar" name="gambar" type="file">
                                <small class="form-text text-muted">Leave blank if you don't want to change the image.</small>
                            </div>
                        </div>

                        <!-- Form Group (enabled) -->
                        <div class="mb-3">
                            <label class="small mb-1" for="inputEnabled">Enabled</label>
                            <select class="form-control" id="inputEnabled" name="enabled" required>
                                <option value="1" <?= old('enabled', $medsos['enabled']) == '1' ? 'selected' : ''; ?>>Enabled</option>
                                <option value="0" <?= old('enabled', $medsos['enabled']) == '0' ? 'selected' : ''; ?>>Disabled</option>
                            </select>
                        </div>

                        <!-- Submit button -->
                        <button class="btn btn-primary" type="submit">Update Media Sosial</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>