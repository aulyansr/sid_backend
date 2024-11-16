<?= $this->extend('layout/dashboard'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800 text-center"><?= isset($programModel) ? 'Edit Program Bantuan' : 'Tambah Program Bantuan'; ?></h1>
    <form action="<?= isset($programModel) ? site_url('/admin/program/' . $programModel['id']) : site_url('/admin/program'); ?>" method="post">
        <?= csrf_field(); ?>

        <!-- Using _method for PUT when updating -->
        <?php if (isset($programModel)) : ?>
            <input type="hidden" name="_method" value="PUT">
            <input type="hidden" name="id" value="<?= esc($programModel['id']); ?>">
        <?php endif; ?>

        <!-- Hidden fields for userID and status -->
        <input type="hidden" name="userID" value="<?= esc(isset($programModel) ? $programModel['userID'] : auth()->user()->id); ?>">
        <input type="hidden" name="status" value="1">

        <div class="row justify-content-center">
            <div class="col-xl-6">
                <!-- Account details card -->
                <div class="card mb-4">
                    <div class="card-header">Form Program</div>
                    <div class="card-body">

                        <!-- Form Row -->
                        <div class="row mb-3 justify-content-center">

                            <!-- Target -->
                            <div class="col-md-12 mb-3">
                                <label class="small mb-1" for="inputSasaran">Sasaran</label>
                                <select class="form-control select2" id="inputSasaran" name="sasaran" required>
                                    <option value="">Pilih Sasaran</option>
                                    <?php foreach ($targets as $value => $label) : ?>
                                        <option value="<?= esc($value); ?>"
                                            <?= (old('sasaran', isset($programModel) ? esc($programModel['sasaran']) : '') == esc($value)) ? 'selected' : ''; ?>>
                                            <?= esc($label); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- Program name -->
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label class="small mb-1" for="inputProgramName"> Nama Program</label>
                                    <input class="form-control" id="inputProgramName" name="nama" type="text" placeholder="Nama Program" value="<?= old('nama', isset($programModel) ? esc($programModel['nama']) : ''); ?>" required>
                                </div>
                            </div>

                            <!-- Program description -->
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label class="small mb-1" for="inputProgramDescription"> Deskripsi Program</label>
                                    <textarea class="form-control" id="inputProgramDescription" name="ndesc" placeholder="Deskripsi Program" rows="4" required><?= old('ndesc', isset($programModel) ? esc($programModel['ndesc']) : ''); ?></textarea>
                                </div>
                            </div>

                            <!-- Start Date -->
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label class="small mb-1" for="inputStartDate"> Tanggal Mulai</label>
                                    <input class="form-control" id="inputStartDate" name="sdate" type="datetime-local" value="<?= old('sdate', isset($programModel) ? esc($programModel['sdate']) : ''); ?>" required>
                                </div>
                            </div>

                            <!-- End Date -->
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label class="small mb-1" for="inputEndDate"> Tanggal Selesai</label>
                                    <input class="form-control" id="inputEndDate" name="edate" type="datetime-local" value="<?= old('edate', isset($programModel) ? esc($programModel['edate']) : ''); ?>" required>
                                </div>
                            </div>

                            <!-- Pelaksana -->
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label class="small mb-1" for="inputPelaksana"> Pelaksana</label>
                                    <input class="form-control" id="inputPelaksana" name="pelaksana" type="text" value="<?= old('pelaksana', isset($programModel) ? esc($programModel['pelaksana']) : ''); ?>" required>
                                </div>
                            </div>

                            <!-- Sumber Dana -->
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label class="small mb-1" for="inputSumberDana"> Sumber Dana</label>
                                    <select class="form-control" id="inputSumberDana" name="id_sumber_dana" required>
                                        <option value="1" <?= (isset($programModel) && $programModel['id_sumber_dana'] == 1) ? 'selected' : ''; ?>>APBKal</option>
                                        <option value="2" <?= (isset($programModel) && $programModel['id_sumber_dana'] == 2) ? 'selected' : ''; ?>>APBD KAB</option>
                                        <option value="3" <?= (isset($programModel) && $programModel['id_sumber_dana'] == 3) ? 'selected' : ''; ?>>APBD PROV</option>
                                        <option value="4" <?= (isset($programModel) && $programModel['id_sumber_dana'] == 4) ? 'selected' : ''; ?>>APBN</option>
                                        <option value="5" <?= (isset($programModel) && $programModel['id_sumber_dana'] == 5) ? 'selected' : ''; ?>>Swasta</option>
                                        <option value="7" <?= (isset($programModel) && $programModel['id_sumber_dana'] == 7) ? 'selected' : ''; ?>>CSR</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- Submit button -->
                        <button class="btn btn-primary" type="submit"><?= isset($programModel) ? 'Update Program' : 'Tambah Program'; ?></button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<!-- Add any custom scripts if needed -->
<?= $this->endSection(); ?>