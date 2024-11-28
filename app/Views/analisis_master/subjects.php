<?= $this->extend('layout/dashboard'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid">

    <h1 class="h3 w-300 mb-2 text-gray-800"><?= $analisis_master['nama']; ?></h1>
    <h3 class="mb-2 fs-5 text-gray-800">Subject Analisis: <?= esc($subjects_types[$analisis_master['subjek_tipe']] ?? 'Penduduk'); ?></h3>
    <h3 class="h3 mb-2 text-gray-800">Subject Periode: <?= esc($periode['nama']); ?></h3>

    <div class="card shadow mb-4">

        <div class="card-header border-bottom">
            <?= $this->include('partials/analisis_tabs', ['activeSideTab' => 'reports']); ?>
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
                            <th>Status</th>
                            <th>Tanggal update</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Aksi</th>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>Status</th>
                            <th>Tanggal update</th>
                        </tr>
                    </tfoot>
                    <tbody>

                        <?php foreach ($subjects as $index => $subject) : ?>
                            <tr>
                                <td align="center"><?= $index + 1; ?></td>
                                <td>
                                    <?php if ($subject['status'] != 'mengisi') : ?>
                                        <a href="/admin/analisis_master/<?= $analisis_master['id'] ?>/input/<?= esc($subject['parameter_subject']); ?>" class="btn btn-warning btn-sm">Input</a>
                                    <?php endif; ?>
                                    <a href="/admin/analisis-respon/<?= $analisis_master['id'] ?>/reset/subject/<?= esc($subject['parameter_subject']); ?>" class="btn btn-danger btn-sm">Reset</a>
                                </td>
                                <td><?= esc($subject['parameter_subject']); ?></td>
                                <td><?= esc($subject['subject_nama']); ?></td>
                                <td><?= esc($subject['status']); ?></td>
                                <td><?= esc($subject['tanggal_update']); ?></td>
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

<script src="/assets/js/admin/vendors/datatables/DataTables-1.13.8/js/jquery.dataTables.min.js"></script>
<script src="/assets/js/admin/vendors/datatables/DataTables-1.13.8/js/dataTables.bootstrap4.min.js"></script>


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