<?= $this->extend('layout/dashboard'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800 text-center">Form Desa</h1>

    <div class="card">
        <div class="card-body">
            <form action="<?= base_url('admin/desa/update/' . $desa['id']); ?>" method="post">


                <div class="card-header">Detail Desa</div>
                <div class="card-body">
                    <!-- Form Row -->
                    <div class="row gx-3 mb-3">
                        <!-- Form Group (Nama Desa) -->
                        <div class="col-md-6 mb-3">
                            <label class="small mb-1" for="inputNama">Nama Desa</label>
                            <input class="form-control" id="inputNama" name="nama_desa" type="text" placeholder="Nama Desa" value="<?= old('nama_desa', isset($desa) ? esc($desa['nama_desa']) : ''); ?>" required>
                        </div>
                            <label class="small mb-1" for="inputKode">Kode Desa</label>
                            <input class="form-control" id="inputKode" name="kode_desa" type="text" placeholder="Kode Desa" value="<?= old('kode_desa', isset($desa) ? esc($desa['kode_desa']) : ''); ?>" required>
                        </div>

                        <!-- Form Group (Permalink) -->
                        <div class="col-md-6 mb-3">
                            <label class="small mb-1" for="inputPermalink">Permalink</label>
                            <input class="form-control" id="inputPermalink" name="permalink" type="text" placeholder="Permalink" value="<?= old('permalink', isset($desa) ? esc($desa['permalink']) : ''); ?>" required>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="small mb-1" for="inputPermalink">Tema Warna</label>
                            <input type="color" id="themeColor" name="theme_color" value="<?= old('theme_color', isset($desa) ? esc($desa['theme_color']) : '#00ba94'); ?>">
                        </div>


                        <div class="col-md-6 mb-3">
                            <label class="small mb-1" for="inputDesa">Nama Kecamatan</label>
                            <select class="form-control select2" id="inputDesa" name="no_kecamatan">
                                <option value="">Pilih Kecamatan</option>
                                <?php foreach ($list_kecamatan as $kecamatan): ?>
                                    <option value="<?= esc($kecamatan['no_kecamatan']); ?>" <?= (old('no_kecamatan', isset($desa) ? esc($desa['no_kecamatan']) : '') == esc($kecamatan['no_kecamatan'])) ? 'selected' : ''; ?>>
                                        <?= esc($kecamatan['nama_kecamatan']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                    </div>

                    <!-- Submit button -->
                    <button class="btn btn-primary" type="submit"><?= isset($desa) ? 'Update Desa' : 'Create Desa'; ?></button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script>
    $(document).ready(function() {
        // If editing, pre-select the permalink
        <?php if (isset($desa)) : ?>
            $('#inputPermalink').val('<?= esc($desa['permalink']); ?>');
        <?php endif; ?>
    });
</script>
<?= $this->endSection(); ?>
