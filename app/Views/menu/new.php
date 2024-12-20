<?= $this->extend('layout/dashboard'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800 text-center">Form Menu</h1>
    <div class="row justify-content-center">
        <div class="col-xl-8">
            <!-- Menu details card -->
            <div class="card mb-4">
                <div class="card-header">Detail Menu</div>
                <div class="card-body">
                    <form action="<?= site_url('/admin/menu/store'); ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field(); ?>

                        <!-- Form Row -->
                        <div class="row gx-3 mb-3">
                            <!-- Form Group (nama) -->
                            <div class="col-md-12 mb-3">
                                <label class="small mb-1" for="inputNama">Nama</label>
                                <input class="form-control" id="inputNama" name="nama" type="text" placeholder="Nama Menu" value="<?= old('nama'); ?>" required>
                            </div>
                            <!-- Form Group (link) -->
                            <div class="col-md-12 mb-3 d-none">
                                <label class="small mb-1" for="inputLink">Link</label>
                                <input class="form-control" id="inputLink" name="link" type="text" placeholder="Link Menu" value="#">
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="small mb-1" for="inputEnabled">Ada SubMenu ?</label>
                                <select class="form-control" id="inputEnabled" name="link_tipe" required>
                                    <option value="1">Ada</option>
                                    <option value="0">Tidak</option>
                                </select>
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
                        <button class="btn btn-primary" type="submit">Add Menu</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>