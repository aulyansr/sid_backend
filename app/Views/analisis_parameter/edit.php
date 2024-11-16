<?= $this->extend('layout/dashboard'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800 text-center"><?= isset($analisisParameter) ? 'Edit Analisis Parameter' : 'Tambah Analisis Parameter'; ?></h1>
    <form action="<?= isset($analisisParameter) ? site_url('/admin/analisis-parameter') : site_url('/admin/analisis-parameter'); ?>" method="post">
        <?= csrf_field(); ?>
        <input type="hidden" id="idIndikator" name="id_indikator" type="number" value="<?= old('id_indikator', isset($analisisParameter) ? $analisisParameter['id_indikator'] : request()->getGet('indikator_id')); ?>">
        <div class="row justify-content-center">
            <div class="col-xl-6">
                <!-- Account details card -->
                <div class="card mb-4">
                    <div class="card-header">Form Analisis Parameter</div>
                    <div class="card-body">
                        <!-- Hidden field for analisis parameter ID if in edit mode -->
                        <?php if (isset($analisisParameter)) : ?>
                            <input type="hidden" name="id" value="<?= esc($analisisParameter['id']); ?>">
                        <?php endif; ?>


                        <!-- Kode Jawaban -->
                        <div class="col-md-12 mb-3">
                            <label class="small mb-1" for="kodeJawaban">Kode Jawaban</label>
                            <input class="form-control" id="kodeJawaban" name="kode_jawaban" type="number" placeholder="Kode Jawaban" value="<?= old('kode_jawaban', isset($analisisParameter) ? $analisisParameter['kode_jawaban'] : ''); ?>" required>
                        </div>

                        <!-- Asign -->
                        <div class="col-md-12 mb-3">
                            <label class="small mb-1" for="asign">Asign</label>
                            <select class="form-control" id="asign" name="asign" required>
                                <option value="1" <?= old('asign', isset($analisisParameter) ? $analisisParameter['asign'] : '') == 1 ? 'selected' : ''; ?>>Yes</option>
                                <option value="0" <?= old('asign', isset($analisisParameter) ? $analisisParameter['asign'] : '') == 0 ? 'selected' : ''; ?>>No</option>
                            </select>
                        </div>

                        <!-- Jawaban -->
                        <div class="col-md-12 mb-3">
                            <label class="small mb-1" for="jawaban">Jawaban</label>
                            <input class="form-control" id="jawaban" name="jawaban" type="text" placeholder="Jawaban" value="<?= old('jawaban', isset($analisisParameter) ? $analisisParameter['jawaban'] : ''); ?>" required>
                        </div>

                        <!-- Nilai -->
                        <div class="col-md-12 mb-3">
                            <label class="small mb-1" for="nilai">Nilai</label>
                            <input class="form-control" id="nilai" name="nilai" type="number" placeholder="Nilai" value="<?= old('nilai', isset($analisisParameter) ? $analisisParameter['nilai'] : ''); ?>" required>
                        </div>

                        <!-- Submit button -->
                        <button class="btn btn-primary" type="submit"><?= isset($analisisParameter) ? 'Update Parameter' : 'Tambah Parameter'; ?></button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script>
    // Custom JS if needed
</script>
<?= $this->endSection(); ?>