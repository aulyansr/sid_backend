<?= $this->extend('pelayanandukcapil/layout/dashboard'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Permohonan Pelayanan</h1>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header border-bottom">
            <?= $this->include('pelayanandukcapil/partials/tabs', ['activeTab' => $activeTab]); ?>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped compact"  width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>NO PEND</th>
                            <th>JENIS DOC</th>
                            <th>TERMOHON</th>
                            <th>TANGGAL</th>
                            <th>CREATED BY</th>
                            <th>PROSES BY</th>
                            <th>STATUS</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; foreach ($progPel as $key): ?>
                           <?php $NOPEND  = str_replace("-", "/",  $key['NO_PEND2']);?>
                            <tr>
                                <td align="center"><?= $i++;?></td>
                                <td><?= $NOPEND; ?></td>
                                <td><?= $key['JENIS_DOC']; ?></td>
                                <td><?= $key['NAMA_TERMOHON']; ?></td>
                                <td><?= $key['TGL_PEND']; ?></td>
                                <td><?= $key['CREATED_BY']; ?></td>
                                <td><?= $key['PROSES_BY']; ?></td>
                                <td><?= $key['STATUS']; ?></td>
                                <td>
                                    <?php if (isset($key['FILE_URL']) && !empty($key['FILE_URL'])) {
                                       echo anchor_popup(
                                            site_url('admin/preview/' . urlencode($key['FILE_URL'])), // URL preview
                                            '<i class="fa fa-file"></i> file 1',                    // Teks atau konten anchor
                                            [
                                                'class' => 'btn btn-sm btn-primary',                    // Tambahkan kelas CSS
                                                'width' => '800',                                   // Lebar popup
                                                'height' => '600',                                  // Tinggi popup
                                                'resizable' => 'yes',                               // Dapat diubah ukurannya
                                                'scrollbars' => 'yes'                               // Aktifkan scrollbar
                                            ]
                                        );
                                    } else {
                                        echo "1. N/a";
                                    }?>
                                    
                                    <?php if (!empty($key['FILE_URL2'])) {
                                        echo anchor_popup(
                                            site_url('admin/preview/' . urlencode($key['FILE_URL2'])), // URL preview
                                            '<i class="fa fa-file"></i> file 2',                    // Teks atau konten anchor
                                            [
                                                'class' => 'btn btn-sm btn-primary',                    // Tambahkan kelas CSS
                                                'width' => '800',                                   // Lebar popup
                                                'height' => '600',                                  // Tinggi popup
                                                'resizable' => 'yes',                               // Dapat diubah ukurannya
                                                'scrollbars' => 'yes'                               // Aktifkan scrollbar
                                            ]
                                        );
                                    } else {
                                        echo "2. N/a";
                                    }?>
                                    <a href="ceklayanan/<?= $key['NO_PEND2']; ?>" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i>edit</a>
                                    
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