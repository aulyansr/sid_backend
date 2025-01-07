<?= $this->extend('layout/dashboard'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">keluarga</h1>
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
                            <th>KK</th>
                            <th>NIK Kepala</th>
                            <th>Kepala Keluarga</th>
                            <th>Jumlah Anggota</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Aksi</th>
                            <th>KK</th>
                            <th>NIK Kepala</th>
                            <th>Nama Kepala</th>
                            <th>Jumlah Anggota</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php foreach ($keluargas as $index => $keluarga) : ?>
                            <tr>
                                <td align="center"><?= $index + 1; ?></td>
                                <td>
                                    <form action="<?= base_url('admin/keluarga/' . esc($keluarga['id'])); ?>" method="post" style="">
                                        <div class="btn-group">
                                            <a href="/admin/keluarga/<?= esc($keluarga['id']); ?>" class="btn btn-sm btn-primary" title="Ubah Data">
                                                <i class="fa fa fa-eye"></i> Rincian
                                            </a>

                                            <a href="/admin/keluarga/<?= esc($keluarga['id']); ?>/edit" class="btn btn-sm btn-warning" title="Ubah Data">
                                                <i class="fa fa-edit"></i> Ubah
                                            </a>

                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" class="btn btn-sm btn-danger" title="Hapus Data" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                <i class="fa fa-trash"></i> Hapus
                                            </button>

                                        </div>
                                    </form>
                                </td>
                                <td><?= esc($keluarga['no_kk']); ?></td>
                                <td><?= esc($keluarga['nik_kepala']); ?></td>
                                <td><?= esc($keluarga['nama_kepala']); ?></td>
                                <td>
                                    <?= esc($keluarga['jumlah_anggota']); ?>
                                </td>

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
    var newkeluargaPath = '/admin/keluarga/new';

    $(document).ready(function() {
        const table = $("#dataTable").DataTable({
            lengthChange: false,
            buttons: [{
                    text: `<i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp;Tambah Keluarga Baru`,
                    className: "btn-sm",
                    action: function(e, dt, node, config) {
                        window.location.href = newkeluargaPath;
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