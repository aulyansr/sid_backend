<?= $this->extend('layout/dashboard'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800 text-center">Form Kelompok Master</h1>
    <div class="row justify-content-center">
        <div class="col-xl-8">
            <!-- Kelompok Master details card -->
            <div class="card mb-4">
                <div class="card-header">Detail Kelompok Master</div>
                <div class="card-body">
                    <form action="<?= site_url('/admin/master-kelompok/' . $kelompokMaster['id']); ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field(); ?>
                        <input type="hidden" name="_method" value="PUT">

                        <!-- Form Row -->
                        <div class="row gx-3 mb-3">
                            <!-- Form Group (Kelompok) -->
                            <div class="col-md-12 mb-3">
                                <label class="small mb-1" for="inputKelompok">Kelompok</label>
                                <input class="form-control" id="inputKelompok" name="kelompok" type="text" placeholder="Nama Kelompok" value="<?= old('kelompok', $kelompokMaster['kelompok']); ?>" required>
                            </div>
                            <!-- Form Group (Deskripsi) -->
                            <div class="col-md-12 mb-3">
                                <label class="small mb-1" for="inputDeskripsi">Deskripsi</label>
                                <textarea class="form-control" id="inputDeskripsi" name="deskripsi" placeholder="Deskripsi Kelompok" required><?= old('deskripsi', $kelompokMaster['deskripsi']); ?></textarea>
                            </div>
                        </div>

                        <!-- Submit button -->
                        <button class="btn btn-primary" type="submit">Update Kelompok Master</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>