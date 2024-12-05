<?= $this->extend('layout/dashboard'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Penduduk</h1>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">

        <div class="card-header border-bottom">
            <?= $this->include('partials/tabs_penduduk', ['activeTab' => $activeTab]); ?>
        </div>
        <div class="card-body">
            <div class="row mb-5 align-items-center">
                <div class="col-auto">
                    <p class="mb-0">Filter</p>
                </div>
                <div class="col-10">
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#sdhkx">SDHK</button>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#agama">AGAMA</button>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#pendidikankk">PENDIDIKAN KK</button>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#pendidikansdg">PENDIDIKAN SEDANG</button>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#pekerjaan">PEKERJAAN</button>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#stskwn">STATUS KAWIN</button>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#wn">WARGA NEGARA</button>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#goldar">Golongan Darah</button>

                    </div>
                    <div class="modal fade" id="sdhkx" tabindex="-1" aria-labelledby="sdhkxLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="sdhkxLabel">Filter Berdasarkan SDHK</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form method="get" action="<?= session()->get('desa_permalink_admin') ? '/' . session()->get('desa_permalink_admin') . '/admin/penduduk' : '/admin/penduduk'; ?>">
                                    <div class="modal-body">

                                        <div class="form-check">
                                            <div class="row">
                                                <?php foreach ($hubunganList as $hubungan): ?>
                                                    <div class="col-6">
                                                        <input class="form-check-input" name="sdk[]" type="checkbox" value="<?= htmlspecialchars($hubungan['id']) ?>" id="checkbox-<?= htmlspecialchars($hubungan['id']) ?>">
                                                        <label class="form-check-label" for="checkbox-<?= htmlspecialchars($hubungan['id']) ?>">
                                                            <?= htmlspecialchars($hubungan['nama']) ?>
                                                        </label>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Cari</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="agama" tabindex="-1" aria-labelledby="agamaLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="agamaLabel">Filter Berdasarkan Agama</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form method="get" action="<?= session()->get('desa_permalink_admin') ? '/' . session()->get('desa_permalink_admin') . '/admin/penduduk' : '/admin/penduduk'; ?>">
                                    <div class="modal-body">

                                        <div class="form-check">
                                            <div class="row">
                                                <?php foreach ($agamaList as $agama): ?>
                                                    <div class="col-6">
                                                        <input class="form-check-input" name="agama[]" type="checkbox" value="<?= htmlspecialchars($agama['id']) ?>" id="checkbox-agama-<?= htmlspecialchars($agama['id']) ?>">
                                                        <label class="form-check-label" for="checkbox-agama-<?= htmlspecialchars($agama['id']) ?>">
                                                            <?= htmlspecialchars($agama['nama']) ?>
                                                        </label>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Cari</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="pendidikankk" tabindex="-1" aria-labelledby="pendidikankkLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="pendidikankkLabel">Filter Berdasarkan pendidikan KK</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form method="get" action="<?= session()->get('desa_permalink_admin') ? '/' . session()->get('desa_permalink_admin') . '/admin/penduduk' : '/admin/penduduk'; ?>">
                                    <div class="modal-body">

                                        <div class="form-check">
                                            <div class="row">
                                                <?php foreach ($pendidikanList as $pendidikankk): ?>
                                                    <div class="col-6">
                                                        <input class="form-check-input" name="pendidikankk[]" type="checkbox" value="<?= htmlspecialchars(string: $pendidikankk['id']) ?>" id="checkbox-pendidikan-<?= htmlspecialchars($pendidikankk['id']) ?>">
                                                        <label class="form-check-label" for="checkbox-pendidikan-<?= htmlspecialchars($pendidikankk['id']) ?>">
                                                            <?= htmlspecialchars($pendidikankk['nama']) ?>
                                                        </label>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Cari</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="pendidikansdg" tabindex="-1" aria-labelledby="pendidikankksdgLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="pendidikankksdgLabel">Filter Berdasarkan Pendidikan Sedang</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form method="get" action="<?= session()->get('desa_permalink_admin') ? '/' . session()->get('desa_permalink_admin') . '/admin/penduduk' : '/admin/penduduk'; ?>">
                                    <div class="modal-body">

                                        <div class="form-check">
                                            <div class="row">
                                                <?php foreach ($pendidikanList as $pendidikankksdg): ?>
                                                    <div class="col-6">
                                                        <input class="form-check-input" name="pendidikansdg[]" type="checkbox" value="<?= htmlspecialchars(string: $pendidikankksdg['id']) ?>" id="checkbox-pendidikansdg-<?= htmlspecialchars($pendidikankksdg['id']) ?>">
                                                        <label class="form-check-label" for="checkbox-pendidikansdg-<?= htmlspecialchars($pendidikankksdg['id']) ?>">
                                                            <?= htmlspecialchars($pendidikankksdg['nama']) ?>
                                                        </label>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Cari</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="pekerjaan" tabindex="-1" aria-labelledby="pendidikankksdgLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="pendidikankksdgLabel">Filter Berdasarkan Pendidikan Sedang</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form method="get" action="<?= session()->get('desa_permalink_admin') ? '/' . session()->get('desa_permalink_admin') . '/admin/penduduk' : '/admin/penduduk'; ?>">
                                    <div class="modal-body">

                                        <div class="form-check">
                                            <div class="row">
                                                <?php foreach ($pekerjaanList as $pekerjaan): ?>
                                                    <div class="col-6">
                                                        <input class="form-check-input" name="pekerjaan[]" type="checkbox" value="<?= htmlspecialchars(string: $pekerjaan['id']) ?>" id="checkbox-pekerjaan-<?= htmlspecialchars($pekerjaan['id']) ?>">
                                                        <label class="form-check-label" for="checkbox-pekerjaan-<?= htmlspecialchars($pekerjaan['id']) ?>">
                                                            <?= htmlspecialchars($pekerjaan['nama']) ?>
                                                        </label>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Cari</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="stskwn" tabindex="-1" aria-labelledby="pendidikankksdgLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="pendidikankksdgLabel">Filter Berdasarkan Pendidikan Sedang</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form method="get" action="<?= session()->get('desa_permalink_admin') ? '/' . session()->get('desa_permalink_admin') . '/admin/penduduk' : '/admin/penduduk'; ?>">
                                    <div class="modal-body">

                                        <div class="form-check">
                                            <div class="row">
                                                <?php foreach ($kawinList as $stskwn): ?>
                                                    <div class="col-6">
                                                        <input class="form-check-input" name="stskwn[]" type="checkbox" value="<?= htmlspecialchars(string: $stskwn['id']) ?>" id="checkbox-stskwn-<?= htmlspecialchars($stskwn['id']) ?>">
                                                        <label class="form-check-label" for="checkbox-stskwn-<?= htmlspecialchars($stskwn['id']) ?>">
                                                            <?= htmlspecialchars($stskwn['nama']) ?>
                                                        </label>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Cari</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="wn" tabindex="-1" aria-labelledby="pendidikankksdgLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="pendidikankksdgLabel">Filter Berdasarkan Warga Negara</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form method="get" action="<?= session()->get('desa_permalink_admin') ? '/' . session()->get('desa_permalink_admin') . '/admin/penduduk' : '/admin/penduduk'; ?>">
                                    <div class="modal-body">

                                        <div class="form-check">
                                            <div class="row">
                                                <?php foreach ($warganegaraList as $wn): ?>
                                                    <div class="col-6">
                                                        <input class="form-check-input" name="wn[]" type="checkbox" value="<?= htmlspecialchars(string: $wn['id']) ?>" id="checkbox-wn-<?= htmlspecialchars($wn['id']) ?>">
                                                        <label class="form-check-label" for="checkbox-wn-<?= htmlspecialchars($wn['id']) ?>">
                                                            <?= htmlspecialchars($wn['nama']) ?>
                                                        </label>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Cari</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="goldar" tabindex="-1" aria-labelledby="pendidikankksdgLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="pendidikankksdgLabel">Filter Berdasarkan Warga Negara</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form method="get" action="<?= session()->get('desa_permalink_admin') ? '/' . session()->get('desa_permalink_admin') . '/admin/penduduk' : '/admin/penduduk'; ?>">
                                    <div class="modal-body">

                                        <div class="form-check">
                                            <div class="row">
                                                <?php foreach ($golongandarahList as $goldar): ?>
                                                    <div class="col-6">
                                                        <input class="form-check-input"
                                                            name="goldar[]"
                                                            type="checkbox"
                                                            value="<?= htmlspecialchars($goldar['id']) ?>"
                                                            id="checkbox-goldar-<?= htmlspecialchars($goldar['id']) ?>"
                                                            <?= in_array($goldar['id'], $request->getGet('goldar') ?? []) ? 'checked' : '' ?>>
                                                        <label class="form-check-label" for="checkbox-goldar-<?= htmlspecialchars($goldar['id']) ?>">
                                                            <?= htmlspecialchars($goldar['nama']) ?>
                                                        </label>
                                                    </div>
                                                <?php endforeach; ?>


                                            </div>
                                        </div>


                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Cari</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped compact" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Aksi</th>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>L/P</th>
                            <th>Umur</th>
                            <th>Tanggal Lahir</th>
                            <th>Pendidikan dalam KK</th>
                            <th>Pekerjaan</th>
                            <th>Status Kawin</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Aksi</th>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>L/P</th>
                            <th>Umur</th>
                            <th>Tanggal Lahir</th>
                            <th>Pendidikan dalam KK</th>
                            <th>Pekerjaan</th>
                            <th>Status Kawin</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php foreach ($penduduks as $index => $penduduk) : ?>
                            <tr>
                                <td align="center"><?= $index + 1; ?></td>
                                <td>
                                    <form action="<?= base_url('admin/penduduk/' . esc($penduduk['id'])); ?>" method="post" style="">
                                        <div class="btn-group">
                                            <a href="/admin/penduduk/<?= esc($penduduk['id']); ?>" class="btn btn-sm btn-primary" title="Ubah Data">
                                                <i class="fa fa fa-eye"></i> Rincian
                                            </a>

                                            <a href="/admin/penduduk/<?= esc($penduduk['id']); ?>/edit" class="btn btn-sm btn-warning" title="Ubah Data">
                                                <i class="fa fa-edit"></i> Ubah
                                            </a>

                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" class="btn btn-sm btn-danger" title="Hapus Data" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                <i class="fa fa-trash"></i> Hapus
                                            </button>

                                        </div>
                                    </form>
                                </td>
                                <td><?= esc($penduduk['nik']); ?></td>
                                <td><?= esc($penduduk['nama']); ?></td>
                                <td><?= esc($penduduk['sex'] == '1' ? 'L' : 'P'); ?></td>
                                <td>
                                    <?php
                                    $tanggalLahir = esc($penduduk['tanggallahir']);
                                    $dob = new DateTime($tanggalLahir);
                                    $today = new DateTime();
                                    $age = $today->diff($dob)->y;
                                    echo $age;
                                    ?>
                                </td>
                                <td><?= esc($penduduk['tanggallahir']); ?></td>
                                <td><?= esc($penduduk['pendidikan_nama']); ?></td>
                                <td><?= esc($penduduk['pekerjaan_nama']); ?></td>
                                <td><?= esc($penduduk['kawin_nama']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<!-- Page level plugins -->
<script src="/assets/js/admin/vendors/datatables/DataTables-1.13.8/js/jquery.dataTables.min.js"></script>
<script src="/assets/js/admin/vendors/datatables/DataTables-1.13.8/js/dataTables.bootstrap4.min.js"></script>

<!-- Data table plugins -->
<script src="/assets/js/admin/vendors/datatables/extensions/JSZip-3.10.1/jszip.min.js"></script>
<script src="/assets/js/admin/vendors/datatables/extensions/pdfmake-0.2.7/pdfmake.min.js"></script>
<script src="/assets/js/admin/vendors/datatables/extensions/pdfmake-0.2.7/vfs_fonts.js"></script>
<script src="/assets/js/admin/vendors/datatables/extensions/Buttons-2.4.2/js/dataTables.buttons.min.js"></script>
<script src="/assets/js/admin/vendors/datatables/extensions/Buttons-2.4.2/js/buttons.bootstrap4.min.js"></script>
<script src="/assets/js/admin/vendors/datatables/extensions/Buttons-2.4.2/js/buttons.colVis.min.js"></script>
<script src="/assets/js/admin/vendors/datatables/extensions/Buttons-2.4.2/js/buttons.html5.min.js"></script>
<script src="/assets/js/admin/vendors/datatables/extensions/Buttons-2.4.2/js/buttons.print.min.js"></script>

<script>
    var newPendudukPath = '/admin/penduduk/new';

    $(document).ready(function() {
        const table = $("#dataTable").DataTable({
            lengthChange: false,
            buttons: [{
                    text: `<i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp;Tambah Penduduk Baru`,
                    className: "btn-sm",
                    action: function(e, dt, node, config) {
                        window.location.href = newPendudukPath;
                    },
                },
                {
                    text: `<i class="fa fa-print" aria-hidden="true"></i>&nbsp;Cetak`,
                    className: "btn-sm",
                    extend: "print",
                },
                {
                    text: `<i class="fa fa-filter" aria-hidden="true"></i>&nbsp;Preferensi Kolom`,
                    className: "btn-sm",
                    extend: "colvis",
                },
            ],
        });

        table.buttons().container().appendTo("#dataTable_wrapper .col-md-6:eq(0)");
    });
</script>
<?= $this->endSection(); ?>