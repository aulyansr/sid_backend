<?= $this->extend('layout/dashboard'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800 text-center">Form Gambar Gallery</h1>
    <form action="<?= site_url('/admin/gambar-gallery/store'); ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field(); ?>
        <div class="row justify-content-center">
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-header">Gambar</div>
                    <div class="card-body">
                        <input id="inputGambar" name="gambar" type="file" class="dropify" accept="image/*" required>
                    </div>
                </div>
            </div>
            <div class="col-xl-8">
                <!-- Account details card -->
                <div class="card mb-4">
                    <div class="card-header">Detail Gambar</div>
                    <div class="card-body">
                        <div class="row gx-3 mb-3">
                            <!-- Form Group (parrent) -->
                            <!-- <div class="col-md-6 mb-3">
                                <label class="small mb-1" for="inputParrent">Parrent</label>
                                <input class="form-control" id="inputParrent" name="parrent" type="number" placeholder="Parrent" value="<?= old('parrent'); ?>" required>
                            </div> -->
                            <!-- Form Group (nama) -->
                            <div class="col-md-12 mb-3">
                                <label class="small mb-1" for="inputNama">Nama</label>
                                <input class="form-control" id="inputNama" name="nama" type="text" placeholder="Nama" value="<?= old('nama'); ?>" required>
                            </div>
                            <!-- Form Group (tipe) -->


                            <input class="form-control d-none" id="inputTipe" name="tipe" type="hidden" placeholder="Tipe" value="0">

                            <!-- Form Group (enabled) -->
                            <div class="col-md-6 mb-3">
                                <label class="small mb-1" for="inputEnabled">Status</label>
                                <select class="form-control" id="inputEnabled" name="enabled" required>
                                    <option value="1" <?= old('enabled') == 1 ? 'selected' : ''; ?>>Active</option>
                                    <option value="0" <?= old('enabled') == 0 ? 'selected' : ''; ?>>Not Active</option>
                                </select>
                            </div>
                            <!-- Form Group (tgl_upload) -->
                            <div class="col-md-6 mb-3">
                                <label class="small mb-1" for="inputTglUpload">Tanggal Upload</label>
                                <input class="form-control" id="inputTglUpload" name="tgl_upload" type="datetime-local" value="<?= old('tgl_upload'); ?>" required>
                            </div>
                        </div>
                        <!-- Submit button -->
                        <button class="btn btn-primary" type="submit">Simpan Gambar Gallery</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script>
    $('.dropify').dropify();
</script>
<?= $this->endSection(); ?>