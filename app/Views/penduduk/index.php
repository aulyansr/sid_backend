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
                                        <div class="uibutton-group">

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