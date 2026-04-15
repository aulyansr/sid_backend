<?= $this->extend('layout/dashboard'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800 text-center">Detail Penduduk</h1>
    <div class="row justify-content-center mb-3">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th>Nama</th>
                                <td><?= esc($penduduk['nama']); ?></td>
                            </tr>
                            <tr>
                                <th>Akta Lahir</th>
                                <td><?= esc($penduduk['akta_lahir']); ?></td>
                            </tr>
                            <tr>
                                <th>Padukuhan</th>
                                <td><?= isset($dusun) ? esc($dusun['dusun']) : 'Dusun tidak ditemukan'; ?></td>
                            </tr>
                            <tr>
                                <th>RT / RW</th>
                                <td>
    <?= isset($wilayah['rt']) ? esc($wilayah['rt']) : 'RT tidak ditemukan'; ?> / 
    <?= isset($rw) ? esc($rw['rw']) : 'RW tidak ditemukan'; ?>
</td>
                            </tr>
                            <tr>
                                <th>Jenis Kelamin</th>
                                <td><?= esc($penduduk['sex_nama']); ?></td>
                            </tr>
                            <tr>
                                <th>Tempat / Tanggal Lahir</th>
                                <td><?= esc($penduduk['tempatlahir']); ?> / <?= date('d-m-Y', strtotime($penduduk['tanggallahir'])); ?></td>
                            </tr>
                            <tr>
                                <th>Agama</th>
                                <td><?= esc($penduduk['agama_nama']); ?></td>
                            </tr>
                            <tr>
                                <th>Pendidikan dalam KK</th>
                                <td><?= esc($penduduk['pendidikan_kk_nama'] ?? 'Tidak ada data'); ?></td>
                            </tr>
                            <tr>
                                <th>Pendidikan sedang ditempuh</th>
                                <td><?= esc($penduduk['pendidikan_sdg_nama'] ?? 'Tidak ada data'); ?></td>
                            </tr>
                            <tr>
                                <th>Pekerjaan</th>
                                <td><?= esc($penduduk['pekerjaan_nama'] ?? 'Tidak ada data'); ?></td>
                            </tr>
                            <tr>
                                <th>Status Kawin</th>
                                <td><?= esc($penduduk['kawin_nama'] ?? 'Tidak ada data'); ?></td>
                            </tr>
                            <tr>
                                <th>Warga Negara</th>
                                <td><?= esc($penduduk['warganegara_nama'] ?? 'Tidak ada data'); ?></td>
                            </tr>
                            <tr>
                                <th>Golongan Darah</th>
                                <td><?= esc($penduduk['golongan_darah_nama'] ?? 'Tidak ada data'); ?></td>
                            </tr>
                            <tr>
                                <th>Dokumen Paspor</th>
                                <td><?= esc($penduduk['dokumen_pasport'] ?? 'Tidak ada data'); ?></td>
                            </tr>
                            <tr>
                                <th>Dokumen KITAS</th>
                                <td><?= esc($penduduk['dokumen_kitas'] ?? 'Tidak ada data'); ?></td>
                            </tr>
                            <tr>
                                <th>Alamat Sebelumnya</th>
                                <td><?= esc($penduduk['alamat_sebelumnya'] ?? 'Tidak ada data'); ?></td>
                            </tr>
                            <tr>
                                <th>Alamat Sekarang</th>
                                <td><?= esc($penduduk['alamat_sekarang'] ?? 'Tidak ada data'); ?></td>
                            </tr>
                            <tr>
                                <th>Akta Perkawinan</th>
                                <td><?= esc($penduduk['akta_perkawinan'] ?? 'Tidak ada data'); ?></td>
                            </tr>
                            <tr>
                                <th>Tanggal Perkawinan</th>
                                <td><?= $penduduk['tanggalperkawinan'] ? date('d-m-Y', strtotime($penduduk['tanggalperkawinan'])) : 'Tidak ada data'; ?></td>
                            </tr>
                            <tr>
                                <th>Akta Perceraian</th>
                                <td><?= esc($penduduk['akta_perceraian'] ?? 'Tidak ada data'); ?></td>
                            </tr>
                            <tr>
                                <th>Tanggal Perceraian</th>
                                <td><?= $penduduk['tanggalperceraian'] ? date('d-m-Y', strtotime($penduduk['tanggalperceraian'])) : 'Tidak ada data'; ?></td>
                            </tr>
                            <tr>
                                <th>Disabilitas</th>
                                <td><?= esc($penduduk['cacat_nama'] ?? 'Tidak ada data'); ?></td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td><?= esc($penduduk['status_nama'] ?? 'Tidak ada data'); ?></td>
                            </tr>
                            <tr>
                                <th>NIK Ayah</th>
                                <td><?= esc($penduduk['ayah_nik']); ?></td>
                            </tr>
                            <tr>
                                <th>Nama Ayah</th>
                                <td><?= esc($penduduk['nama_ayah']); ?></td>
                            </tr>
                            <tr>
                                <th>NIK Ibu</th>
                                <td><?= esc($penduduk['ibu_nik']); ?></td>
                            </tr>
                            <tr>
                                <th>Nama Ibu</th>
                                <td><?= esc($penduduk['nama_ibu']); ?></td>
                            </tr>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
    <h2 class="h3 mb-2 text-gray-800 text-center">DOKUMEN / KELENGKAPAN PENDUDUK</h2>
    <div class="row justify-content-center mb-3">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered table-striped compact" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Aksi</th>
                                <th>Jenis Surat</th>
                                <th>Nama</th>
                                <th>Keperluan</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Aksi</th>
                                <th>Nama Surat</th>
                                <th>Nama</th>
                                <th>User</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php foreach ($surat_keluar as $surat) : ?>
                                <tr>
                                    <td>
                                        <a href="<?= site_url('admin/surat/export/' . $surat['id'] . '/' . 'word'); ?>" class="btn btn-primary">Ekspor ke Word</a>
                                        <a href="<?= site_url('/admin/surat/delete/' . esc($surat['id'])); ?>" class="btn btn-sm btn-danger" title="Hapus Data" onclick="return confirm('Apakah Anda yakin ingin menghapus surat ini?');">
                                            <i class="fa fa-trash"></i> Hapus
                                        </a>
                                    </td>
                                    <td><?= esc($surat['jenis_surat']) ?></td>
                                    <td><?= esc($surat['nama']) ?></td>
                                    <td><?= esc($surat['keperluan']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>
