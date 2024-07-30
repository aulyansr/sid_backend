<?= $this->extend('layout/dashboard'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800 text-center">Form Setting Modul</h1>
    <div class="row justify-content-center">
        <div class="col-xl-8">
            <!-- Setting Modul details card -->
            <div class="card mb-4">
                <div class="card-header">Detail Setting Modul</div>
                <div class="card-body">
                    <form action="<?= site_url('/admin/setting_modul/store'); ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field(); ?>

                        <!-- Form Row -->
                        <div class="row gx-3 mb-3">
                            <!-- Form Group (modul) -->
                            <div class="col-md-12 mb-3">
                                <label class="small mb-1" for="inputModul">Modul</label>
                                <input class="form-control <?= isset($validation) && $validation->hasError('modul') ? 'is-invalid' : ''; ?>" id="inputModul" name="modul" type="text" placeholder="Nama Modul" value="<?= old('modul'); ?>" required>
                                <?php if (isset($validation) && $validation->hasError('modul')) : ?>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('modul'); ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Form Group (url) -->
                            <div class="col-md-12 mb-3">
                                <label class="small mb-1" for="inputUrl">URL</label>
                                <input class="form-control <?= isset($validation) && $validation->hasError('url') ? 'is-invalid' : ''; ?>" id="inputUrl" name="url" type="text" placeholder="URL Modul" value="<?= old('url'); ?>" required>
                                <?php if (isset($validation) && $validation->hasError('url')) : ?>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('url'); ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Form Group (aktif) -->
                            <div class="col-md-12 mb-3">
                                <label class="small mb-1" for="inputAktif">Aktif</label>
                                <select class="form-control <?= isset($validation) && $validation->hasError('aktif') ? 'is-invalid' : ''; ?>" id="inputAktif" name="aktif" required>
                                    <option value="1" <?= old('aktif') == '1' ? 'selected' : ''; ?>>Aktif</option>
                                    <option value="0" <?= old('aktif') == '0' ? 'selected' : ''; ?>>Non-Aktif</option>
                                </select>
                                <?php if (isset($validation) && $validation->hasError('aktif')) : ?>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('aktif'); ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Form Group (ikon) -->
                            <div class="col-md-12 mb-3">
                                <label class="small mb-1" for="inputIkon">Ikon</label>
                                <input class="form-control-file <?= isset($validation) && $validation->hasError('ikon') ? 'is-invalid' : ''; ?>" id="inputIkon" name="ikon" type="file" required>
                                <?php if (isset($validation) && $validation->hasError('ikon')) : ?>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('ikon'); ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Form Group (urut) -->
                            <div class="col-md-12 mb-3">
                                <label class="small mb-1" for="inputUrut">Urutan</label>
                                <input class="form-control <?= isset($validation) && $validation->hasError('urut') ? 'is-invalid' : ''; ?>" id="inputUrut" name="urut" type="number" placeholder="Urutan Modul" value="<?= old('urut'); ?>" required>
                                <?php if (isset($validation) && $validation->hasError('urut')) : ?>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('urut'); ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Form Group (level) -->
                            <div class="col-md-12 mb-3">
                                <label class="small mb-1" for="inputLevel">Level</label>
                                <select class="form-control <?= isset($validation) && $validation->hasError('level') ? 'is-invalid' : ''; ?>" id="inputLevel" name="level" required>
                                    <option value="0" <?= old('level') == '0' ? 'selected' : ''; ?>>0</option>
                                    <option value="1" <?= old('level') == '1' ? 'selected' : ''; ?>>1</option>
                                </select>
                                <?php if (isset($validation) && $validation->hasError('level')) : ?>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('level'); ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Form Group (hidden) -->
                            <div class="col-md-12 mb-3">
                                <label class="small mb-1" for="inputHidden">Hidden</label>
                                <select class="form-control <?= isset($validation) && $validation->hasError('hidden') ? 'is-invalid' : ''; ?>" id="inputHidden" name="hidden" required>
                                    <option value="0" <?= old('hidden') == '0' ? 'selected' : ''; ?>>No</option>
                                    <option value="1" <?= old('hidden') == '1' ? 'selected' : ''; ?>>Yes</option>
                                </select>
                                <?php if (isset($validation) && $validation->hasError('hidden')) : ?>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('hidden'); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Submit button -->
                        <button class="btn btn-primary" type="submit">Tambah Setting Modul</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>