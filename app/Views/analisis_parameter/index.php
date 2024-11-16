<?= $this->extend('layout/dashboard'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Analisis Parameters</h1>
    <a href="<?= site_url('/admin/analisis_master/' . $analisis_master . '/analisis-indikators') ?>" class="btn btn-sm btn-warning mb-3">
        <i class="fa fa-plus-circle"></i> Kembali ke Analisis Indikator
    </a>
    <a href="<?= site_url('admin/analisis-parameter/new?id_indikator=' . request()->getGet('id_indikator')); ?>" class="btn btn-sm btn-primary mb-3">
        <i class="fa fa-plus-circle"></i> Add New
    </a>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped compact" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Actions</th>
                            <th>Kode Jawaban</th>
                            <th>Jawaban</th>
                            <th>Nilai</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Actions</th>
                            <th>Kode Jawaban</th>
                            <th>Jawaban</th>
                            <th>Nilai</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php foreach ($analisa_parameters as $index => $ap) : ?>
                            <tr>
                                <td align="center"><?= $index + 1; ?></td>
                                <td>
                                    <div class="btn-group">
                                        <a href="<?= site_url('/admin/analisis-parameter/' . esc($ap['id'] . '/edit')); ?>" class="btn btn-sm btn-warning" title="Edit">
                                            <i class="fa fa-edit"></i> Edit
                                        </a>
                                        <form action="<?= base_url('admin/analisis-parameter/' . esc($ap['id'])); ?>" method="post" style="display:inline;">
                                            <!-- Hidden input to simulate DELETE method -->
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" class="btn btn-sm btn-danger" title="Hapus Data" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                <i class="fa fa-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                                <td><?= esc($ap['kode_jawaban']); ?></td>
                                <td><?= esc($ap['jawaban']); ?></td>
                                <td><?= esc($ap['nilai']); ?></td>
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
<script>
    $(document).ready(function() {
        const table = $("#dataTable").DataTable({
            lengthChange: false,
            buttons: [{
                    text: `<i class="fa fa-plus-circle"></i>&nbsp;Add New`,
                    className: "btn-sm",
                    action: function(e, dt, node, config) {
                        window.location.href = '<?= site_url('analisis-parameter/create'); ?>';
                    },
                },
                {
                    text: `<i class="fa fa-print"></i>&nbsp;Print`,
                    className: "btn-sm",
                    extend: 'collection',
                    buttons: ['csv', 'pdf', 'excel']
                },
                {
                    text: `<i class="fa fa-filter"></i>&nbsp;Column Preferences`,
                    className: "btn-sm",
                    extend: 'colvis'
                }
            ],
        });

        table.buttons().container().appendTo("#dataTable_wrapper .col-md-6:eq(0)");
    });
</script>
<?= $this->endSection(); ?>