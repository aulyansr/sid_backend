<?= $this->extend('layout/dashboard'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Setting Modul</h1>
    <!-- DataTables Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Manajemen Setting Modul</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped compact" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Aksi</th>
                            <th>Modul</th>
                            <th>URL</th>
                            <th>Ikon</th>
                            <th>Urut</th>
                            <th>Level</th>
                            <th>Hidden</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Aksi</th>
                            <th>Modul</th>
                            <th>URL</th>
                            <th>Ikon</th>
                            <th>Urut</th>
                            <th>Level</th>
                            <th>Hidden</th>
                            <th>Status</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php foreach ($setting_moduls as $index => $modul) : ?>
                            <tr>
                                <td align="center"><?= $index + 1; ?></td>
                                <td>
                                    <div class="uibutton-group">
                                        <a href="/admin/setting_modul/edit/<?= esc($modul['id']); ?>" class="btn btn-sm btn-warning" title="Ubah Data">
                                            <i class="fa fa-edit"></i> Ubah
                                        </a>
                                        <a href="/admin/setting_modul/delete/<?= esc($modul['id']); ?>" class="btn btn-sm btn-danger" title="Hapus Data">
                                            <i class="fa fa-trash"></i> Hapus
                                        </a>
                                    </div>
                                </td>
                                <td><img src="/<?= esc($modul['ikon']); ?>" alt="" style="width:200px"> </td>
                                <td><?= esc($modul['modul']); ?></td>
                                <td><?= esc($modul['url']); ?></td>

                                <td align="center"><?= esc($modul['urut']); ?></td>
                                <td align="center"><?= esc($modul['level']); ?></td>
                                <td align="center">
                                    <?php if ($modul['hidden']) : ?>
                                        <span class="badge badge-danger">Hidden</span>
                                    <?php else : ?>
                                        <span class="badge badge-success">Visible</span>
                                    <?php endif; ?>
                                </td>
                                <td align="center">
                                    <?php if ($modul['aktif']) : ?>
                                        <span class="badge badge-success">Active</span>
                                    <?php else : ?>
                                        <span class="badge badge-danger">Inactive</span>
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
<script src="/assets/js/admin/vendor/datatables/DataTables-1.13.8/js/jquery.dataTables.min.js"></script>
<script src="/assets/js/admin/vendor/datatables/DataTables-1.13.8/js/dataTables.bootstrap4.min.js"></script>

<!-- Data table plugins -->
<script src="/assets/js/admin/vendor/datatables/extensions/JSZip-3.10.1/jszip.min.js"></script>
<script src="/assets/js/admin/vendor/datatables/extensions/pdfmake-0.2.7/pdfmake.min.js"></script>
<script src="/assets/js/admin/vendor/datatables/extensions/pdfmake-0.2.7/vfs_fonts.js"></script>
<script src="/assets/js/admin/vendor/datatables/extensions/Buttons-2.4.2/js/dataTables.buttons.min.js"></script>
<script src="/assets/js/admin/vendor/datatables/extensions/Buttons-2.4.2/js/buttons.bootstrap4.min.js"></script>
<script src="/assets/js/admin/vendor/datatables/extensions/Buttons-2.4.2/js/buttons.colVis.min.js"></script>
<script src="/assets/js/admin/vendor/datatables/extensions/Buttons-2.4.2/js/buttons.html5.min.js"></script>
<script src="/assets/js/admin/vendor/datatables/extensions/Buttons-2.4.2/js/buttons.print.min.js"></script>

<script>
    var newUserPath = '/admin/setting_modul/new';

    $(document).ready(function() {
        const table = $("#dataTable").DataTable({
            lengthChange: false,
            buttons: [{
                    text: `<i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp;Tambah Modul Baru`,
                    className: "btn-sm",
                    action: function(e, dt, node, config) {
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