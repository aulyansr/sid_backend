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
                    <form action="<?= site_url('/admin/menu/update/' . esc($menu['id'])); ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field(); ?>
                        <!-- Form Row -->
                        <div class="row gx-3 mb-3">
                            <!-- Form Group (nama) -->
                            <div class="col-md-12 mb-3">
                                <label class="small mb-1" for="inputNama">Nama</label>
                                <input class="form-control" id="inputNama" name="nama" type="text" placeholder="Nama Menu" value="<?= old('nama', esc($menu['nama'])); ?>" required>
                            </div>
                            <!-- Form Group (link) -->
                            <div class="col-md-12 mb-3">
                                <label class="small mb-1" for="inputLink">Link</label>
                                <input class="form-control" id="inputLink" name="link" type="text" placeholder="Link Menu" value="<?= old('link', esc($menu['link'])); ?>" required>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="small mb-1" for="inputEnabled">Ada SubMenu ?</label>
                                <select class="form-control" id="inputEnabled" name="link_tipe" required>
                                    <option value="1" <?= old('enabled', $menu['link_tipe']) == '1' ? 'selected' : ''; ?>>Ada</option>
                                    <option value="0" <?= old('enabled', $menu['link_tipe']) == '0' ? 'selected' : ''; ?>>Tidak</option>
                                </select>
                            </div>

                            <!-- Form Group (enabled) -->
                            <div class="col-md-12 mb-3">
                                <label class="small mb-1" for="inputEnabled">Enabled</label>
                                <select class="form-control" id="inputEnabled" name="enabled" required>
                                    <option value="1" <?= old('enabled', $menu['enabled']) == '1' ? 'selected' : ''; ?>>Enabled</option>
                                    <option value="0" <?= old('enabled', $menu['enabled']) == '0' ? 'selected' : ''; ?>>Disabled</option>
                                </select>
                            </div>
                        </div>

                        <!-- Submit button -->
                        <button class="btn btn-primary" type="submit">Update Menu</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>