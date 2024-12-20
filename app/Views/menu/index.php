<?= $this->extend('layout/dashboard'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Admin Web</h1>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header border-bottom">
            <?= $this->include('partials/tabs', ['activeTab' => $activeTab]); ?>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped compact" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Aksi</th>

                            <th>Nama</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Aksi</th>

                            <th>Nama</th>
                            <th>Status</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php foreach ($menus as $index => $menu) : ?>
                            <tr>
                                <td align="center"><?= $index + 1; ?></td>
                                <td>
                                    <div class="uibutton-group">
                                        <?php if ($menu['link_tipe'] == 0): ?>
                                            <?php
                                            // Split the link by '/' and get the last part as article ID
                                            $parts = explode('/', $menu['link']);
                                            $articleId = end($parts);
                                            ?>
                                            <a href="/admin/artikel/edit/<?= esc($articleId); ?>" class="btn btn-sm btn-secondary" title="Ubah Data">
                                                <i class="fa fa-eye"></i> Lihat
                                            </a>
                                        <?php else: ?>
                                            <a href="<?= site_url('admin/menu/' . esc($menu['id'])); ?>" class="btn btn-sm btn-secondary" title="Lihat Data">
                                                <i class="fa fa-eye"></i> Lihat
                                            </a>
                                        <?php endif; ?>
                                        <a href="/admin/menu/edit/<?= esc($menu['id']); ?>" class="btn btn-sm btn-warning" title="Ubah Data">
                                            <i class="fa fa-edit"></i> Ubah
                                        </a>

                                        <!-- Delete button -->
                                        <a href="/admin/menu/delete/<?= esc($menu['id']); ?>"
                                            class="btn btn-sm btn-danger"
                                            title="Hapus Data"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                            <i class="fa fa-trash"></i> Hapus
                                        </a>
                                    </div>
                                </td>

                                <td><?= esc($menu['nama']); ?></td>

                                <td>
                                    <?php if ($menu['enabled']) : ?>
                                        <span class="badge badge-success">Active</span>
                                    <?php else : ?>
                                        <span class="badge badge-danger">Not Active</span>
                                    <?php endif; ?>
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
    var newmenud = '/admin/menu/new/';


    $(document).ready(function() {
        const table = $("#dataTable").DataTable({
            lengthChange: false,
            buttons: [{
                    text: `<i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp;Tambah Menu Baru`,
                    className: "btn-sm",
                    action: function(e, dt, node, config) {
                        // Redirect to the new user path
                        window.location.href = newmenud;
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