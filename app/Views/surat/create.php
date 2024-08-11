<?= $this->extend('layout/dashboard'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800 text-center">Formulir Cetak Surat</h1>
    <div class="row justify-content-center">
        <div class="col-xl-8">
            <!-- Surat details card -->
            <div class="card mb-4">
                <div class="card-header">Cetak Surat</div>
                <div class="card-body">
                    <form action="<?= site_url('admin/surat/store'); ?>" method="post">
                        <?= csrf_field(); ?>

                        <!-- Hidden field for jenis surat -->
                        <input type="hidden" name="jenis_surat" value="<?= esc($jenis_surat); ?>">

                        <!-- Form Group (nama_surat) -->
                        <div class="mb-3">
                            <label class="small mb-1" for="inputNomorSurat">Nama Surat</label>
                            <input class="form-control" id="inputNomorSurat" name="nomor_surat" type="text" placeholder="Nomor Surat" value="<?= old('nomor_surat'); ?>" required>
                        </div>

                        <!-- Form Group (nik) -->
                        <div class="mb-3">
                            <label class="small mb-1" for="inputNIK">NIK</label>
                            <input class="form-control" id="inputNIK" name="nik" type="text" placeholder="NIK" value="<?= old('nik'); ?>" required>
                        </div>

                        <!-- Form Group (nama) -->
                        <div class="mb-3">
                            <label class="small mb-1" for="inputNama">Nama</label>
                            <input class="form-control" id="inputNama" name="nama" type="text" placeholder="Nama" value="<?= old('nama'); ?>" required>
                        </div>



                        <!-- Form Group (keperluan) -->
                        <div class="mb-3">
                            <label class="small mb-1" for="inputKeperluan">Keperluan</label>
                            <input class="form-control" id="inputKeperluan" name="keperluan" type="text" placeholder="Keperluan" value="<?= old('keperluan'); ?>" required>
                        </div>

                        <!-- Submit button -->
                        <button class="btn btn-primary" type="submit">Cetak Surat</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>