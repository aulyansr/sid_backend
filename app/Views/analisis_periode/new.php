<?= $this->extend('layout/dashboard'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800 text-center"><?= isset($analisisPeriodeModel) ? 'Edit Analisis Kategori' : 'Tambah Analisis Kategori'; ?></h1>
    <form action="<?= isset($analisisPeriodeModel) ? site_url('/admin/analisis-periode') : site_url('/admin/analisis-periode'); ?>" method="post">
        <?= csrf_field(); ?>
        <input type="hidden" name="id_master" value="<?= esc($id_master); ?>">
        <div class="row justify-content-center">
            <div class="col-xxl-6">
                <!-- Account details card -->
                <div class="card mb-4">
                    <div class="card-header">Form Analisis Indikatator</div>
                    <div class="card-body">

                        <div class="mb-3">
                            <div class="form-group">
                                <label class="small mb-1" for="nama">Nama Periode</label>
                                <input class="form-control" id="nama" name="nama" type="text" placeholder="Nama Periode" value="<?= old('nomor', isset($analisisPeriodeModel) ? $analisisPeriodeModel['nama'] : ''); ?>" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="small mb-1" for="inputGroup">Periode Aktif</label>
                            <br>
                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                <?php foreach ($active_type as $value => $label) : ?>
                                    <label class="btn btn-sm btn-outline-primary">
                                        <input type="radio" name="aktif" value="<?= esc($value); ?>" id="aktif_<?= esc($value); ?>" <?= (old('aktif', isset($analisisPeriodeModel) ? $analisisPeriodeModel['aktif'] : '') == $value) ? 'checked' : ''; ?>> <?= esc($label); ?>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="small mb-1" for="inputGroup">Tahap Pendataan</label>
                            <br>
                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                <?php foreach ($state_type as $value => $label) : ?>
                                    <label class="btn btn-sm btn-outline-primary">
                                        <input type="radio" name="id_state" value="<?= esc($value); ?>" id="id_state_<?= esc($value); ?>" <?= (old('id_state', isset($analisisPeriodeModel) ? $analisisPeriodeModel['id_state'] : '') == $value) ? 'checked' : ''; ?>> <?= esc($label); ?>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-group">
                                <label class="small mb-1" for="tahun_pelaksanaan">Tahun Pelaksanaan</label>
                                <input class="form-control" id="tahun_pelaksanaan" name="tahun_pelaksanaan" type="number" value="<?= old('tahun_pelaksanaan', isset($analisisPeriodeModel) ? $analisisPeriodeModel['tahun_pelaksanaan'] : ''); ?>" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-group">
                                <label class="small mb-1" for="keterangan">Keterangan</label>
                                <textarea rows="5" class="form-control" id="keterangan" name="keterangan" type="text" value="<?= old('keterangan', isset($analisisPeriodeModel) ? $analisisPeriodeModel['keterangan'] : ''); ?>" required></textarea>

                            </div>
                        </div>


                        <!-- Submit button -->

                        <button class="btn btn-primary" type="submit"><?= isset($analisisPeriodeModel) ? 'Update Analisis' : 'Tambah Analisis'; ?></button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<?= $this->endSection(); ?>


<?= $this->section('script'); ?>

<?= $this->endSection(); ?>
