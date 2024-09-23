<?= $this->extend('layout/dashboard'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800 text-center">Form Pengurus</h1>

    <div class="card">

        <div class="card-body">
            <form action="<?= base_url('admin/pengurus/' . $pamong['pamong_id'])  ?>" method="post">
                <input type="hidden" name="_method" value="PUT">

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
                                <label class="btn btn-outline-primary <?= (old('pamong_status', isset($pamong) ? esc($pamong['pamong_status']) : '') == '1') ? 'active' : ''; ?>">
                                    <input type="radio" name="pamong_status" value="1" <?= (old('pamong_status', isset($pamong) ? esc($pamong['pamong_status']) : '') == '1') ? 'checked' : ''; ?>> Aktif
                                </label>
                                <label class="btn btn-outline-primary <?= (old('pamong_status', isset($pamong) ? esc($pamong['pamong_status']) : '') == '2') ? 'active' : ''; ?>">
                                    <input type="radio" name="pamong_status" value="2" <?= (old('pamong_status', isset($pamong) ? esc($pamong['pamong_status']) : '') == '2') ? 'checked' : ''; ?>> Tidak Aktif
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Submit button -->
                    <button class="btn btn-primary" type="submit">Update Pengurus</button>
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