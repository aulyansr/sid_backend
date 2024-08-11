<?= $this->extend('layout/dashboard'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Admin Web - Komentar</h1>
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
                            <th>ID Artikel</th>
                            <th>Owner</th>
                            <th>Email</th>
                            <th>Komentar</th>
                            <th>Tanggal Upload</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Aksi</th>
                            <th>ID Artikel</th>
                            <th>Owner</th>
                            <th>Email</th>
                            <th>Komentar</th>
                            <th>Tanggal Upload</th>
                            <th>Status</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php foreach ($komentars as $index => $komentar) : ?>
                            <tr>
                                <td align="center"><?= $index + 1; ?></td>
                                <td>
                                    <div class="btn-group">
                                        <a href="<?= site_url('/admin/komentar/edit/' . esc($komentar['id'])); ?>" class="btn btn-sm btn-warning" title="Ubah Data">
                                            <i class="fa fa-edit"></i> Ubah
                                        </a>
                                        <a href="<?= site_url('/admin/komentar/delete/' . esc($komentar['id'])); ?>" class="btn btn-sm btn-danger" title="Hapus Data" onclick="return confirm('Apakah Anda yakin ingin menghapus komentar ini?');">
                                            <i class="fa fa-trash"></i> Hapus
                                        </a>
                                        <a href="<?= site_url('/artikel/' . esc($komentar['id_artikel'])); ?>" class="btn btn-sm btn-secondary" title="Lihat Artikel">
                                            <i class="fa fa-eye"></i> Lihat Artikel
                                        </a>
                                        <?php if ($komentar['enabled']) : ?>
                                            <a href="<?= site_url('/admin/komentar/disable/' . esc($komentar['id'])); ?>" class="btn btn-sm btn-secondary" title="Disable Komentar">
                                                <i class="fa fa-ban"></i> Disable
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td><?= esc($komentar['id_artikel']); ?></td>
                                <td><?= esc($komentar['owner']); ?></td>
                                <td><?= esc($komentar['email']); ?></td>
                                <td><?= esc($komentar['komentar']); ?></td>
                                <td><?= esc($komentar['tgl_upload']); ?></td>
                                <td><?= esc($komentar['enabled'] == 1 ? 'Enabled' : 'Disabled'); ?></td>
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
<script>
    $(document).ready(function() {
        const table = $("#dataTable").DataTable({
            lengthChange: false,
            buttons: [{
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