<?= $this->extend('layout/dashboard'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800 text-center">Edit Kategori</h1>
    <div class="row justify-content-center">
        <div class="col-xl-8">
            <!-- Kategori details card -->
            <div class="card mb-4">
                <div class="card-header">Edit Kategori</div>
                <div class="card-body">
                    <form action="<?= site_url('admin/kategori/update/' . $kategori['id']); ?>" method="post">
                        <?= csrf_field(); ?>

                        <!-- Form Group (kategori) -->
                        <div class="mb-3">
                            <label class="small mb-1" for="inputKategori">Kategori</label>
                            <input class="form-control" id="inputKategori" name="kategori" type="text" placeholder="Nama Kategori" value="<?= old('kategori', $kategori['kategori']); ?>" required>
                        </div>
                        <!-- Form Group (tipe) -->
                        <div class="mb-3">
                            <label class="small mb-1" for="inputTipe">Tipe</label>
                            <input class="form-control" id="inputTipe" name="tipe" type="number" placeholder="Tipe" value="<?= old('tipe', $kategori['tipe']); ?>" required>
                        </div>
                        <!-- Form Group (urut) -->
                        <div class="mb-3">
                            <label class="small mb-1" for="inputUrut">Urutan</label>
                            <input class="form-control" id="inputUrut" name="urut" type="number" placeholder="Urutan" value="<?= old('urut', $kategori['urut']); ?>" required>
                        </div>
                        <!-- Form Group (enabled) -->
                        <div class="mb-3">
                            <label class="small mb-1" for="inputEnabled">Enabled</label>
                            <select class="form-control" id="inputEnabled" name="enabled" required>
                                <option value="1" <?= old('enabled', $kategori['enabled']) == '1' ? 'selected' : ''; ?>>Yes</option>
                                <option value="0" <?= old('enabled', $kategori['enabled']) == '0' ? 'selected' : ''; ?>>No</option>
                            </select>
                        </div>
                        <!-- Form Group (parrent) -->
                        <div class="mb-3">
                            <label class="small mb-1" for="inputParrent">Parent Menu</label>
                            <select class="form-control" id="inputParrent" name="parrent">
                                <option value="0">No Parent</option>
                                <?php foreach ($kategoris as $k) : ?>
                                    <option value="<?= esc($k['id']); ?>" <?= old('parrent', $kategori['parrent']) == $k['id'] ? 'selected' : ''; ?>>
                                        <?= esc($k['kategori']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Hidden input for ID -->
                        <input type="hidden" name="id" value="<?= esc($kategori['id']); ?>">

                        <!-- Submit button -->
                        <button class="btn btn-primary" type="submit">Update Kategori</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>