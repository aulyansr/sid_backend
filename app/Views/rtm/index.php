<?= $this->extend('layout/dashboard'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Rumah Tangga</h1>

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
                            <th>No RTM</th>
                            <th>NIK Kepala</th>
                            <th>Kepala Keluarga</th>
                            <th>Jumlah Anggota</th>
                            <th>Status RTM</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Aksi</th>
                            <th>No RTM</th>
                            <th>NIK Kepala</th>
                            <th>Kepala Keluarga</th>
                            <th>Jumlah Anggota</th>
                            <th>Status RTM</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php foreach ($rtms as $index => $rtm) : ?>
                            <tr>
                                <td align="center"><?= $index + 1; ?></td>
                                <td>
                                    <form action="<?= base_url('admin/rumah-tangga/' . esc($rtm['id'])); ?>" method="post">
                                        <div class="btn-group">
                                            <a href="/admin/rumah-tangga/<?= esc($rtm['id']); ?>" class="btn btn-sm btn-primary" title="Ubah Data">
                                                <i class="fa fa fa-eye"></i> Rincian
                                            </a>
                                            <a href="/admin/rumah-tangga/<?= esc($rtm['id']); ?>/edit" class="btn btn-sm btn-warning" title="Ubah Data">
                                                <i class="fa fa-edit"></i> Ubah
                                            </a>

                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" class="btn btn-sm btn-danger" title="Hapus Data" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                <i class="fa fa-trash"></i> Hapus
                                            </button>
                                        </div>
                                    </form>
                                </td>
                                <td><?= esc($rtm['id']); ?></td>
                                <td><?= esc($rtm['nik_kepala']); ?></td>
                                <td><?= esc($rtm['nama_kepala']); ?></td>
                                <td><?= esc($rtm['jumlah_anggota']); ?></td>
                                <td></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Adding New RTM -->
<div class="modal fade" id="addRTMModal" tabindex="-1" role="dialog" aria-labelledby="addRTMModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="<?= base_url('admin/rumah-tangga/create_rtm_kk') ?>" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="addRTMModalLabel">Tambah RTM Berdasarkan No KK</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="no_kk">No KK</label>
                        <select class="form-control" id="no_kk" name="no_kk" required style="width: 100%;">
                            <option value="">Pilih No KK</option>
                        </select>
                    </div>
                    <p>
                        Silakan cari Nomor KK dari data Keluarga yang sudah terinput.
                        Kepala Keluarga yang dipilih otomatis berstatus sebagai Kepala Rumah Tangga baru tersebut.
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>



<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script src="/assets/js/admin/vendors/datatables/DataTables-1.13.8/js/jquery.dataTables.min.js"></script>
<script src="/assets/js/admin/vendors/datatables/DataTables-1.13.8/js/dataTables.bootstrap4.min.js"></script>

<!-- Data table plugins -->
<script src="/assets/js/admin/vendors/datatables/extensions/JSZip-3.10.1/jszip.min.js"></script>
<script src="/assets/js/admin/vendors/datatables/extensions/pdfmake-0.2.7/pdfmake.min.js"></script>
<script src="/assets/js/admin/vendors/datatables/extensions/Buttons-2.4.2/js/dataTables.buttons.min.js"></script>
<script src="/assets/js/admin/vendors/datatables/extensions/Buttons-2.4.2/js/buttons.bootstrap4.min.js"></script>
<script src="/assets/js/admin/vendors/datatables/extensions/Buttons-2.4.2/js/buttons.colVis.min.js"></script>
<script src="/assets/js/admin/vendors/datatables/extensions/Buttons-2.4.2/js/buttons.print.min.js"></script>

<script>
    var newRTMPath = '/admin/rumah-tangga/new';

    $(document).ready(function() {
        const table = $("#dataTable").DataTable({
            lengthChange: false,
            buttons: [{
                    text: `<i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp;Tambah RTM Baru`,
                    className: "btn-sm",
                    action: function(e, dt, node, config) {
                        window.location.href = newRTMPath;
                    },
                }, {
                    text: `<i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp;Tambah RTM dari KK`,
                    className: "btn-sm",
                    action: function(e, dt, node, config) {
                        $('#addRTMModal').modal('show');
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

<script>
    // Initialize select2 for no_kk with AJAX
    $('#addRTMModal').on('shown.bs.modal', function() {
        $('#no_kk').select2({
            placeholder: 'Pilih No KK',
            dropdownParent: $('#addRTMModal'),
            ajax: {
                url: '<?= base_url('/admin/ajax/kk/search'); ?>', // This is the route to search KK
                dataType: 'json',
                delay: 250,
                processResults: function(data) {
                    return {
                        results: data.map(function(item) {
                            return {
                                id: item.id, // The KK number as the id
                                text: item.text // Display KK number, NIK Kepala, and Nama
                            };
                        })
                    };
                },
                cache: true
            },
            minimumInputLength: 1
        });


    });
</script>
<?= $this->endSection(); ?>