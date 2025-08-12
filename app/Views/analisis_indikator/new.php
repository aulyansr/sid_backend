<?= $this->extend('layout/dashboard'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid"> x
    <h1 class="h3 mb-2 text-gray-800 text-center"><?= isset($analisisIndikator) ? 'Edit Analisis Indikatator' : 'Tambah Analisis Indikatator'; ?></h1>
    <form action="<?= isset($analisisIndikator) ? site_url('/admin/analisis-indikators') : site_url('/admin/analisis-indikators'); ?>" method="post">
        <?= csrf_field(); ?>
        <input type="hidden" name="id_master" value="<?= esc($id_master); ?>">
        <input type="hidden" name="is_statistik" value="<?= old('is_statistik', isset($analisisIndikator) ? $analisisIndikator->is_statistik : '1'); ?>">
        <div class="row justify-content-center">
            <div class="col-xxl-6">
                <!-- Account details card -->
                <div class="card mb-4">
                    <div class="card-header">Form Analisis Indikatator</div>
                    <div class="card-body">

                        <div class="mb-3">
                            <label class="small mb-1" for="inputGroup">User Group</label>
                            <br>
                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                <?php foreach ($question_type as $value => $label) : ?>
                                    <label class="btn btn-sm btn-outline-primary">
                                        <input type="radio" name="id_tipe" value="<?= esc($value); ?>" id="fitur_pembobotan_<?= esc($value); ?>" <?= (old('fitur_pembobotan', isset($analisisIndikator) ? $analisisIndikator['fitur_pembobotan'] : '') == $value) ? 'checked' : ''; ?>> <?= esc($label); ?>
                                    </label>
                                <?php endforeach; ?>

                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-group">
                                <label class="small mb-1" for="inputNomor">Kode Pertanyaan</label>
                                <input class="form-control" id="inputNomor" name="nomor" type="number" placeholder="Kode Pertanyaan" value="<?= old('nomor', isset($analisisIndikator) ? $analisisIndikator->nomor : ''); ?>" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-group">
                                <label class="small mb-1" for="inputPertanyaan">Pertanyaan</label>
                                <textarea rows="5" class="form-control" id="inputPertanyaan" name="pertanyaan" type="text" placeholder="Pertanyaan" value="<?= old('pertanyaan', isset($analisisIndikator) ? $analisisIndikator->pertanyaan : ''); ?>" required></textarea>

                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-group">
                                <label class="small mb-1" for="inputbobot">Bobot</label>
                                <input class="form-control" id="inputbobot" name="bobot" type="text" placeholder="Kode Pertanyaan" value="<?= old('bobot', isset($analisisIndikator) ? $analisisIndikator->bobot : '1'); ?>" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="small mb-1" for="act_analisis">Aksi Analisis</label>
                            <br>
                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                <?php foreach ($act_anlisis as $value => $label) : ?>
                                    <label class="btn btn-sm btn-outline-primary">
                                        <input type="radio" name="act_analisis" value="<?= esc($value); ?>" id="act_analisis_<?= esc($value); ?>" <?= (old('act_analisis', isset($analisis) ? $analisis->act_analisis : '') == $value) ? 'checked' : ''; ?>> <?= esc($label); ?>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="small mb-1 d-block" for="inputStatus">Kategori Indikator</label>
                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                <?php foreach ($indikator_categories as $category): ?>
                                    <label class="btn btn-outline-primary <?= old('id_kategori', isset($analisisIndikator) ? esc($analisisIndikator['id_kategori']) : '') == $category['id'] ? 'active' : ''; ?>">
                                        <input type="radio" name="id_kategori" value="<?= esc($category['id']); ?>" <?= old('id_kategori', isset($analisisIndikator) ? esc($analisisIndikator['id_kategori']) : '') == $category['id'] ? 'checked' : ''; ?>>
                                        <?= $category['kategori'] ?>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="small mb-1" for="is_required">Wajib Diisi</label>
                            <br>
                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                <?php foreach ($required as $value => $label) : ?>
                                    <label class="btn btn-sm btn-outline-primary">
                                        <input type="radio" name="is_required" value="<?= esc($value); ?>" id="is_required_<?= esc($value); ?>" <?= (old('is_required', isset($analisisIndikator) ? $analisisIndikator->required : '') == $value) ? 'checked' : ''; ?>> <?= esc($label); ?>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="small mb-1" for="is_publik">Publikasi Indikator</label>
                            <br>
                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                <?php foreach ($required as $value => $label) : ?>
                                    <label class="btn btn-sm btn-outline-primary">
                                        <input type="radio" name="is_publik" value="<?= esc($value); ?>" id="is_publik_<?= esc($value); ?>" <?= (old('is_publik', isset($analisisIndikator) ? $analisisIndikator->is_publik : '') == $value) ? 'checked' : ''; ?>> <?= esc($label); ?>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <!-- Submit button -->

                        <button class="btn btn-primary" type="submit"><?= isset($analisisIndikator) ? 'Update Analisis' : 'Tambah Analisis'; ?></button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<?= $this->endSection(); ?>


<?= $this->section('script'); ?>

<?= $this->endSection(); ?>
