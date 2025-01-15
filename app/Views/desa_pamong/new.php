<?= $this->extend('layout/dashboard'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800 text-center">Form Pengurus</h1>

    <div class="card">

        <div class="card-body">
            <form action="<?= isset($pamong) ? base_url('admin/pengurus/update/' . $pamong['pamong_id']) : base_url('admin/pengurus') ?>" method="post">

                <div class="card-header">Detail Pengurus</div>
                <div class="card-body">
                    <!-- Form Row -->
                    <div class="row gx-3 mb-3">
                        <!-- Form Group (full name) -->
                        <div class="col-md-6 mb-3">
                            <label class="small mb-1" for="inputNama">Nama Petugas</label>
                            <input class="form-control" id="inputNama" name="pamong_nama" type="text" placeholder="Nama Pamong" value="<?= old('pamong_nama', isset($pamong) ? esc($pamong['pamong_nama']) : ''); ?>" required>
                        </div>

                        <!-- Form Group (NIP) -->
                        <div class="col-md-6 mb-3">
                            <label class="small mb-1" for="inputNIP">NIP</label>
                            <input class="form-control" id="inputNIP" name="pamong_nip" type="text" placeholder="NIP" value="<?= old('pamong_nip', isset($pamong) ? esc($pamong['pamong_nip']) : ''); ?>" required>
                        </div>

                        <!-- Form Group (NIK) -->
                        <div class="col-md-6 mb-3">
                            <label class="small mb-1" for="inputNIK">NIK</label>
                            <input class="form-control" id="inputNIK" name="pamong_nik" type="text" placeholder="NIK" value="<?= old('pamong_nik', isset($pamong) ? esc($pamong['pamong_nik']) : ''); ?>" required>
                        </div>

                        <!-- Form Group (jabatan) -->
                        <div class="col-md-6 mb-3">
                            <label class="small mb-1" for="inputJabatan">Jabatan</label>
                            <input class="form-control" id="inputJabatan" name="jabatan" type="text" placeholder="Jabatan" value="<?= old('jabatan', isset($pamong) ? esc($pamong['jabatan']) : ''); ?>" required>
                        </div>

                        <!-- Form Group (status) -->
                        <div class="col-md-6 mb-3">
                            <label class="small mb-1 d-block">Status</label>
                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                <label class="btn btn-outline-primary <?= isset($pamong) && esc($pamong['pamong_status']) == '1' ? 'active' : ''; ?>">
                                    <input type="radio" name="pamong_status" value="1" <?= old('pamong_status', isset($pamong) ? esc($pamong['pamong_status']) : '') == '1' ? 'checked' : ''; ?>> Aktif
                                </label>
                                <label class="btn btn-outline-primary <?= isset($pamong) && esc($pamong['pamong_status']) == '2' ? 'active' : ''; ?>">
                                    <input type="radio" name="pamong_status" value="2" <?= old('pamong_status', isset($pamong) ? esc($pamong['pamong_status']) : '') == '2' ? 'checked' : ''; ?>> Tidak Aktif
                                </label>
                            </div>
                        </div>


                        <!-- Form Group (tanggal terdaftar) -->
                        <div class="col-md-6 mb-3" style="display: none;">
                            <label class="small mb-1" for="inputTglTerdaftar">Tanggal Terdaftar</label>
                            <input class="form-control" id="inputTglTerdaftar" name="pamong_tgl_terdaftar" type="date" value="<?= old('pamong_tgl_terdaftar', date('Y-m-d')); ?>" required>
                        </div>

                        <?php if (auth()->user()->inGroup('superadmin')): ?>

                            <div class="col-md-12 mb-3">
                                <label class="small mb-1" for="inputDesa">Nama Desa</label>
                                <select class="form-control select2" id="inputDesa" name="desa_id">
                                    <option value="">Pilih Desa</option>
                                    <?php foreach ($list_desa as $desa): ?>
                                        <option value="<?= esc($desa['id']); ?>" <?= (old('id', isset($desa) ? esc($desa['id']) : '') == esc($desa['id'])) ? 'selected' : ''; ?>>
                                            <?= esc($desa['nama_desa']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                        <?php else: ?>

                            <input type="hidden" name="desa_id" value="<?= auth()->user()->desa_id; ?>">

                        <?php endif; ?>

                    </div>

                    <!-- Submit button -->
                    <button class="btn btn-primary" type="submit"><?= isset($pamong) ? 'Update Pengurus' : 'Create Pengurus'; ?></button>
                </div>

            </form>

        </div>
    </div>


</div>
<?= $this->endSection(); ?>
<?= $this->section('script'); ?>
<script>
    $('.dropify').dropify();
</script>
<?= $this->endSection(); ?>