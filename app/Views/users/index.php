<?= $this->extend('layout/dashboard'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Pengguna</h1>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Manajemen Pengguna</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped compact" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Aksi</th>
                            <th>Username</th>
                            <th>Nama</th>
                            <th>Group</th>
                            <th>Last Login</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Aksi</th>
                            <th>Username</th>
                            <th>Nama</th>
                            <th>Group</th>
                            <th>Last Login</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php foreach ($users as $index => $user) : ?>
                            <tr>
                                <td align="center"><?= $index + 1; ?></td>
                                <td>
                                    <div class="uibutton-group">
                                        <a href="/admin/users/edit/<?= esc($user->id); ?>" class="btn btn-sm btn-warning" title="Ubah Data">
                                            <i class="fa fa-edit"></i> Ubah
                                        </a>
                                        <a href="/admin/users/delete/<?= esc($user->id); ?>" class="btn btn-sm btn-danger" title="Hapus Data">
                                            <i class="fa fa-trash"></i> Hapus
                                        </a>
                                        <a href="/admin/users/view/<?= esc($user->id); ?>" class="btn btn-sm btn-secondary" title="Lihat Data">
                                            <i class="fa fa-lock"></i>
                                        </a>
                                    </div>
                                </td>
                                <td><?= esc($user->username); ?></td>
                                <td><?= esc($user->nama); ?></td>
                                <td>
                                    <?php if (method_exists($user, 'getGroups')) : ?>
                                        <?php
                                        $groups = $user->getGroups();
                                        if (is_array($groups)) {
                                            echo implode(', ', array_map('esc', $groups)); // Convert array to comma-separated string with escaping
                                        } else {
                                            echo esc($groups); // If it's not an array, just escape the value
                                        }
                                        ?>
                                    <?php else : ?>
                                        Tidak ada grup
                                    <?php endif; ?>
                                </td>
                                <td><?= esc($user->last_login); ?></td>
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
    var newUserPath = '/admin/users/new';

    $(document).ready(function() {
        const table = $("#dataTable").DataTable({
            lengthChange: false,
            buttons: [{
                    text: `<i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp;Tambah Pengguna Baru`,
                    className: "btn-sm",
                    action: function(e, dt, node, config) {
                        // Redirect to the new user path
                        window.location.href = newUserPath;
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