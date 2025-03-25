<?= $this->extend('layout/dashboard'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800 text-center"><?= isset($analisisKategori) ? 'Edit Analisis Kategori' : 'Tambah Analisis Kategori'; ?> x</h1>
    <form action="<?= site_url('/admin/analisis-kategori'); ?>" method="post">
        
        <input type="hidden" name="id_master" value="<?= esc($id_master); ?>">
        <input type="hidden" name="kategori_kode" value="<?= old('nama', isset($analisisKategori) ? $analisisKategori->kategori_kode : ''); ?>">
        <div class="row justify-content-center">
            <div class="col-xl-6">
                <!-- Account details card -->
                <div class="card mb-4">
                    <div class="card-header">Form Analisis Kategori</div>
                    <div class="card-body">


                        <!-- Form Row -->
                        <div class="row gx-3 mb-3 justify-content-centers">
                            <!-- Form Group (analisis name) -->
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label class="small mb-1" for="inputAnalisisName"> Nama Kategori/Variabel</label>
                                    <input class="form-control" id="inputAnalisisName" name="kategori" type="text" placeholder="Nama Analisis" value="<?= old('nama', isset($analisisKategori) ? $analisisKategori->kategori : ''); ?>" required>
                                </div>
                            </div>
                            <hr>
                        </div>
                        <!-- Submit button -->

                        <button class="btn btn-primary" type="submit"><?= isset($analisisKategori) ? 'Update Analisis' : 'Tambah Analisis'; ?></button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<?= $this->endSection(); ?>


<?= $this->section('script'); ?>

<?= $this->endSection(); ?>
