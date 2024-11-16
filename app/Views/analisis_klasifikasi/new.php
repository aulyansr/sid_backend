<?= $this->extend('layout/dashboard'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800 text-center"><?= isset($analisisKlasifikasi) ? 'Edit Analisis Klasifikasi' : 'Tambah Analisis Klasifikasi'; ?></h1>
    <form action="<?= isset($analisisKlasifikasi) ? site_url('/admin/analisis-klasifikasi') : site_url('/admin/analisis-klasifikasi'); ?>" method="post">
        <?= csrf_field(); ?>
        <input type="hidden" name="id_master" value="<?= esc($id_master); ?>">

        <div class="row justify-content-center">
            <div class="col-xl-6">
                <!-- Account details card -->
                <div class="card mb-4">
                    <div class="card-header">Form Analisis Klasifikasi</div>
                    <div class="card-body">

                        <!-- Form Row -->
                        <div class="row mb-3 justify-content-center">
                            <!-- Form Group (analisis klasifikasi name) -->
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label class="small mb-1" for="inputAnalisisKlasifikasiName"> Nama Klasifikasi</label>
                                    <input class="form-control" id="inputAnalisisKlasifikasiName" name="nama" type="text" placeholder="Nama Klasifikasi" value="<?= old('nama_klasifikasi', isset($analisisKlasifikasi) ? $analisisKlasifikasi['nama_klasifikasi'] : ''); ?>" required>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label class="small mb-1" for="inputAnalisisKategori">Nilai Minimal</label>
                                    <input class="form-control" id="inputAnalisisKlasifikasiName" name="minval" type="text" value="<?= old('nama_klasifikasi', isset($analisisKlasifikasi) ? $analisisKlasifikasi['minval'] : ''); ?>" required>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label class="small mb-1" for="inputAnalisisKategori">Nilai Maksimal</label>
                                    <input class="form-control" id="inputAnalisisKlasifikasiName" name="maxval" type="text" value="<?= old('nama_klasifikasi', isset($analisisKlasifikasi) ? $analisisKlasifikasi['maxval'] : ''); ?>" required>
                                </div>
                            </div>


                            <hr>
                        </div>
                        <!-- Submit button -->
                        <button class="btn btn-primary" type="submit"><?= isset($analisisKlasifikasi) ? 'Update Klasifikasi' : 'Tambah Klasifikasi'; ?></button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<?= $this->endSection(); ?>


<?= $this->section('script'); ?>

<?= $this->endSection(); ?>