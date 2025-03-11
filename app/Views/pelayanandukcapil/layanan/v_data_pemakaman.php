<?= $this->extend('pelayanandukcapil/layout/dashboard'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Buku Pokok Pemakaman</h1>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header border-bottom">
            <?= $this->include('pelayanandukcapil/partials/tabs', ['activeTab' => $activeTab]); ?>
        </div>
        <div class="card-body">
            <a href="<?= site_url('admin/pemakaman/add');?>" class="btn btn-primary mb-3">Tambah</a>
            <div class="table-responsive">
            <table class="table table-bordered table-striped compact" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>NOMER</th>
                            <th>NIK</th>
                            <th>NAMA</th>
                            <th>TGL MENINGGAL</th>
                            <th>LOKASI</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; foreach ($dataPemakaman as $key): ?>
                            <tr>
                                <td align="center"><?= $i++;?></td>
                                <td><?= $key['NOMER']; ?></td>
                                <td><?= $key['NIK']; ?></td>
                                <td><?= $key['NAMA_LGKP']; ?></td>
                                <td><?= $key['TGL_MENINGGAL']; ?></td>
                                <td><?= $key['LOKASI_MAKAM']; ?></td>
                                <td>
                                    <a href="<?= site_url('admin/pemakaman/cetak/'.$key['NOMER']);?>" class="btn btn-sm btn-success"><i class="fa fa-print"></i> Cetak</a>
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

<!-- Page level custom scripts -->
<!-- <script src="/assets/js/admin/demo/datatables-pengguna.js"></script> -->

<script>
    // Define the JavaScript variable with the URL from PHP
    var newkategorid = '/admin/kategori/new';

    $(document).ready(function() {
        const table = $("#dataTable").DataTable({
            lengthChange: false,
            buttons: [{
                    text: `<i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp;Tambah Kategori Baru`,
                    className: "btn-sm",
                    action: function(e, dt, node, config) {
                        // Redirect to the new user path
                        window.location.href = newkategorid;
                    },
                },
                {
                    text: `<i class="fa fa-print" aria-hidden="true"></i>&nbsp;Cetak`,
                    className: "btn-sm",
                    split: ["csv", "pdf", "excel"],
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