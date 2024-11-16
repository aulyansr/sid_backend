<?= $this->extend('layout/dashboard'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Pengaturan Analisis - <?= $analisis_master['nama'] ?></h1>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header border-bottom">
            <?= $this->include('partials/analisis_tabs', ['activeTab' => $activeTab]); ?>
        </div>
        <div class="card-body">
            <div class="row">

                <div class="col-md-2">
                    <?= $this->include('partials/side_tabs', ['activeSideTab' => $activeSideTab]); ?>
                </div>
                <div class="col-md-9">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped compact" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Aksi</th>
                                    <th>Nama</th>

                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>Aksi</th>
                                    <th>Nama</th>

                                </tr>
                            </tfoot>
                            <tbody>
                                <?php foreach ($analisisCategories as $index => $analisis) : ?>
                                    <tr>
                                        <td align="center"><?= $index + 1; ?></td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="<?= site_url('/admin/kategori_indikators/' . esc($analisis['id']) . '/edit'); ?>" class="btn btn-sm btn-warning" title="Ubah Data">
                                                    <i class="fa fa-edit"></i> Ubah
                                                </a>
                                                <a href="<?= site_url('/admin/kategori_indikators/delete/' . esc($analisis['id'])); ?>" class="btn btn-sm btn-danger" title="Hapus Data" onclick="return confirm('Apakah Anda yakin ingin menghapus analisis ini?');">
                                                    <i class="fa fa-trash"></i> Hapus
                                                </a>

                                            </div>
                                        </td>
                                        <td><?= esc($analisis['kategori']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
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

<!-- Page level custom scripts -->
<script>
    $(document).ready(function() {
        const table = $("#dataTable").DataTable({
            lengthChange: false,
            buttons: [{
                    text: `<i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp;Tambah Analisis Baru`,
                    className: "btn-sm",
                    action: function(e, dt, node, config) {
                        window.location.href = '/admin/analisis_master/<?= esc($analisis['id']); ?>/kategori_indikators/new';
                    },
                },
                {
                    text: `<i class="fa fa-print" aria-hidden="true"></i>&nbsp;Cetak`,
                    className: "btn-sm",
                    extend: 'collection',
                    buttons: ['csv', 'pdf', 'excel']
                },
                {
                    text: `<i class="fa fa-filter" aria-hidden="true"></i>&nbsp;Preferensi Kolom`,
                    className: "btn-sm",
                    extend: 'colvis'
                }
            ],
        });

        table.buttons().container().appendTo("#dataTable_wrapper .col-md-6:eq(0)");
    });
</script>
<?= $this->endSection(); ?>