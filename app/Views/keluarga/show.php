<?= $this->extend('layout/dashboard'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800 text-center">Detail Keluarga</h1>

    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card">
                <div class="card-body">

                    <!-- Family Details -->
                    <div class="card-header">Detail Keluarga</div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Nomor KK -->
                            <div class="col-md-6 mb-3">
                                <label class="small mb-1" for="no_kk">Nomor KK</label>
                                <input class="form-control" id="no_kk" type="text" value="<?= esc($keluarga['no_kk']); ?>" readonly>
                            </div>

                            <!-- NIK Kepala Keluarga -->
                            <div class="col-md-6 mb-3">
                                <label class="small mb-1" for="nik_kepala">NIK Kepala Keluarga</label>
                                <input class="form-control" id="nik_kepala" type="text" value="<?= esc($kepalaKeluarga['nik']); ?>" readonly>
                            </div>

                            <!-- Nama Kepala Keluarga -->
                            <div class="col-md-12 mb-3">
                                <label class="small mb-1" for="nama_kepala">Nama Kepala Keluarga</label>
                                <input class="form-control" id="nama_kepala" type="text" value="<?= esc($kepalaKeluarga['nama']); ?>" readonly>
                            </div>
                        </div>
                    </div>

                    <!-- Family Member List -->
                    <div class="card-header">Anggota Keluarga</div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>NIK</th>
                                    <th>Alamat Sekarang</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Pendidikan</th>
                                    <th>Hubungan dalam Keluarga</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($anggota_keluarga)) : ?>
                                    <?php foreach ($anggota_keluarga as $anggota) : ?>
                                        <tr>
                                            <td><?= esc($anggota['nama']); ?></td>
                                            <td><?= esc($anggota['nik']); ?></td>
                                            <td><?= esc($anggota['alamat_sekarang']); ?></td>
                                            <td><?= esc($anggota['sex_nama']); ?></td>
                                            <td><?= esc($anggota['pendidikan_nama']); ?></td>
                                            <td><?= esc($anggota['hubungan_nama']); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="6" class="text-center">No family members found.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                        <a href="<?= base_url('admin/keluarga/' . $keluarga['id'] . '/edit') ?>" class="btn btn-info">
                            Ubah / Tambah Penduduk
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>