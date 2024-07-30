<?= $this->extend('layout/dashboard'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800 text-center">Form Menu</h1>
    <div class="row justify-content-center">
        <div class="col-xl-8">
            <!-- Menu details card -->
            <div class="card mb-4">
                <div class="card-header">Detail Menu</div>
                <div class="card-body">
                    <form action="<?= site_url('/admin/menu/store'); ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field(); ?>

                        <!-- Form Row -->
                        <div class="row gx-3 mb-3">
                            <!-- Form Group (nama) -->
                            <div class="col-md-12 mb-3">
                                <label class="small mb-1" for="inputNama">Nama</label>
                                <input class="form-control" id="inputNama" name="nama" type="text" placeholder="Nama Menu" value="<?= old('nama'); ?>" required>
                            </div>
                            <!-- Form Group (link) -->
                            <div class="col-md-12 mb-3">
                                <label class="small mb-1" for="inputLink">Link</label>
                                <input class="form-control" id="inputLink" name="link" type="text" placeholder="Link Menu" value="<?= old('link'); ?>" required>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="small mb-1" for="inputTipe">Tipe</label>
                                <input class="form-control" id="inputTipe" name="tipe" type="text" placeholder="Tipe" value="<?= old('tipe'); ?>" required>
                            </div>

                            <!-- Form Group (parrent) -->
                            <div class="col-md-12 mb-3">
                                <label class="small mb-1" for="inputParrent">Parent Menu</label>
                                <select class="form-control" id="inputParrent" name="parrent">
                                    <option value="">No Parent</option>
                                    <?php foreach ($menus as $m) : ?>
                                        <option value="<?= esc($m['id']); ?>" <?= old('parrent') == $m['id'] ? 'selected' : ''; ?>>
                                            <?= esc($m['nama']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <!-- Form Group (link_tipe) -->
                            <div class="col-md-12 mb-3">
                                <label class="small mb-1" for="inputLinkTipe">Link Type</label>
                                <select class="form-control" id="inputLinkTipe" name="link_tipe" required>
                                    <option value="0" <?= old('link_tipe') == '0' ? 'selected' : ''; ?>>Type 0</option>
                                    <option value="1" <?= old('link_tipe') == '1' ? 'selected' : ''; ?>>Type 1</option>
                                </select>
                            </div>
                            <!-- Form Group (enabled) -->
                            <div class="col-md-12 mb-3">
                                <label class="small mb-1" for="inputEnabled">Enabled</label>
                                <select class="form-control" id="inputEnabled" name="enabled" required>
                                    <option value="1" <?= old('enabled') == '1' ? 'selected' : ''; ?>>Enabled</option>
                                    <option value="0" <?= old('enabled') == '0' ? 'selected' : ''; ?>>Disabled</option>
                                </select>
                            </div>
                        </div>

                        <!-- Submit button -->
                        <button class="btn btn-primary" type="submit">Add Menu</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>