<?= $this->extend('layout/dashboard'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800 text-center"> <?= $kelompok['nama']; ?></h1>

    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card">
                <div class="card-body">

                    <!-- Family Details -->
                    <div class="card-header">Detail Kelompok</div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Nomor KK -->
                            <div class="col-md-6 mb-3">
                                <label class="small mb-1" for="no_kk">Kode Kelompok</label>
                                <input class="form-control" id="no_kk" type="text" value="<?= esc($kelompok['kode']); ?>" readonly>
                            </div>

                            <!-- NIK Kepala kelompok -->
                            <div class="col-md-6 mb-3">
                                <label class="small mb-1" for="nik_kepala">NIK Kepala kelompok</label>
                                <input class="form-control" id="nik_kepala" type="text" value="<?= esc($kepalakelompok['nik']); ?>" readonly>
                            </div>

                            <!-- Nama Kepala kelompok -->
                            <div class="col-md-12 mb-3">
                                <label class="small mb-1" for="nama_kepala">Nama Kepala kelompok</label>
                                <input class="form-control" id="nama_kepala" type="text" value="<?= esc($kepalakelompok['nama']); ?>" readonly>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="small mb-1" for="nama_kepala">Jenis kelompok</label>
                                <input class="form-control" id="nama_kepala" type="text" value="<?= esc($kelompokMaster['kelompok']); ?>" readonly>
                            </div>
                        </div>
                    </div>

                    <!-- Family Member List -->
                    <div class="card-header">Anggota kelompok</div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>NIK</th>
                                    <th>Alamat Sekarang</th>

                                    <th>Hubungan dalam kelompok</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($anggota_kelompok)) : ?>
                                    <?php foreach ($anggota_kelompok as $anggota) : ?>
                                        <tr>
                                            <td><?= esc($anggota['nama']); ?></td>
                                            <td><?= esc($anggota['nik']); ?></td>
                                            <td><?= esc($anggota['alamat_sekarang']); ?></td>


                                            <td>Anggota</td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="6" class="text-center">No family members found.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                        <a href="<?= base_url('admin/kelompok/' . $kelompok['id'] . '/edit') ?>" class="btn btn-info">
                            Ubah / Tambah Anggota
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>