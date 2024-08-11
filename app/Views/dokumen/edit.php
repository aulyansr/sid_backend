<?= $this->extend('layout/dashboard'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800 text-center">Edit Dokumen</h1>
    <form action="<?= site_url('/admin/dokumen/update/' . $dokumen['id']); ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field(); ?>
        <div class="row justify-content-center">
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-header">Upload Dokumen</div>
                    <div class="card-body">
                        <label class="small mb-1" for="inputSatuan">File Dokumen</label>
                        <input id="inputSatuan" name="satuan" type="file" class="dropify" accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt" data-default-file="<?= base_url($dokumen['satuan']); ?>">
                        <small class="text-muted">Current file: <?= basename($dokumen['satuan']); ?></small>
                    </div>
                </div>
            </div>
            <div class="col-xl-8">
                <!-- Dokumen details card -->
                <div class="card mb-4">
                    <div class="card-header">Detail Dokumen</div>
                    <div class="card-body">
                        <!-- Form Row -->
                        <div class="row gx-3 mb-3">
                            <!-- Form Group (nama) -->
                            <div class="col-md-12 mb-3">
                                <label class="small mb-1" for="inputNama">Nama Dokumen</label>
                                <input class="form-control" id="inputNama" name="nama" type="text" placeholder="Nama Dokumen" value="<?= esc(old('nama', $dokumen['nama'])); ?>" required>
                            </div>

                            <!-- Form Group (enabled) -->
                            <div class="col-md-6 mb-3">
                                <label class="small mb-1" for="inputEnabled">Enabled</label>
                                <select class="form-control" id="inputEnabled" name="enabled" required>
                                    <option value="1" <?= old('enabled', $dokumen['enabled']) == '1' ? 'selected' : ''; ?>>Yes</option>
                                    <option value="0" <?= old('enabled', $dokumen['enabled']) == '0' ? 'selected' : ''; ?>>No</option>
                                </select>
                            </div>

                            <!-- Form Group (tgl_upload) -->
                            <div class="col-md-6 mb-3">
                                <label class="small mb-1" for="tgl_upload">Tanggal Upload</label>
                                <input class="form-control" id="tgl_upload" name="tgl_upload" type="date" value="<?= esc(old('tgl_upload', date('Y-m-d', strtotime($dokumen['tgl_upload'])))); ?>">
                            </div>


                        </div>

                        <!-- Submit button -->

                        <button class="btn btn-primary" type="submit">Update Dokumen</button>
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