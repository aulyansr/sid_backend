<?= $this->extend('layout/dashboard'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800 text-center">Form kelurahan</h1>

    <div class="card">
        <div class="card-body">
            <form action="<?= base_url('admin/kelurahan/update/' . $kelurahan['id']); ?>" method="post">


                <div class="card-header">Detail kelurahan</div>
                <div class="card-body">
                    <!-- Form Row -->
                    <div class="row gx-3 mb-3">
                        <!-- Form Group (Nama kelurahan) -->
                        <div class="col-md-6 mb-3">
                            <label class="small mb-1" for="inputNama">Nama kelurahan</label>
                            <input class="form-control" id="inputNama" name="nama_kelurahan" type="text" placeholder="Nama kelurahan" value="<?= old('nama_kelurahan', isset($kelurahan) ? esc($kelurahan['nama_kelurahan']) : ''); ?>" required>
                        </div>

                        <!-- Form Group (Permalink) -->
                        <div class="col-md-6 mb-3">
                            <label class="small mb-1" for="inputDesa">Nama Desa</label>
                            <select class="form-control select2" id="inputDesa" name="no_kec">
                                <option value="">Pilih Desa</option>
                                <?php foreach ($villages as $desa): ?>
                                    <option value="<?= esc($desa['id']); ?>" <?= (old('no_kec', isset($kelurahan) ? esc($kelurahan['no_kec']) : '') == esc($desa['id'])) ? 'selected' : ''; ?>>
                                        <?= esc($desa['nama_desa']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                    </div>

                    <!-- Submit button -->
                    <button class="btn btn-primary" type="submit"><?= isset($kelurahan) ? 'Update kelurahan' : 'Create kelurahan'; ?></button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>

<?= $this->section('script'); ?>

<?= $this->endSection(); ?>