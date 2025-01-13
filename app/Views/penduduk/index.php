<?= $this->extend('layout/dashboard'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Penduduk</h1>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">

        <div class="card-header border-bottom">
            <?= $this->include('partials/tabs_penduduk', ['activeTab' => $activeTab]); ?>
        </div>
        <div class="card-body">
            <div class="row mb-5 align-items-center">
                <div class="col-auto">
                    <p class="mb-0">Filter</p>
                </div>
                <div class="col-10">
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#sdhkx">SDHK</button>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#agamaModal">AGAMA</button>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#pendidikankkModal">PENDIDIKAN KK</button>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#pendidikansdgModal">PENDIDIKAN SEDANG</button>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#pekerjaanModal">PEKERJAAN</button>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#filterModalStatusKawin">STATUS KAWIN</button>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#wnModal">WARGA NEGARA</button>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#goldarModal">Golongan Darah</button>

                    </div>
                    <div class="modal fade" id="sdhkx" tabindex="-1" aria-labelledby="sdhkxLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="sdhkxLabel">Filter Berdasarkan SDHK</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form id="sdhkxfrm">
                                    <div class="modal-body">

                                        <div class="form-check">
                                            <div class="row">
                                                <?php foreach ($hubunganList as $hubungan): ?>
                                                    <div class="col-6">
                                                        <input class="form-check-input" name="sdk[]" type="checkbox" value="<?= htmlspecialchars($hubungan['id']) ?>" id="checkbox-<?= htmlspecialchars($hubungan['id']) ?>">
                                                        <label class="form-check-label" for="checkbox-<?= htmlspecialchars($hubungan['id']) ?>">
                                                            <?= htmlspecialchars($hubungan['nama']) ?>
                                                        </label>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="modal-footer">
                                        <button id="applySdkFilters" type="button" class="btn btn-primary">Cari</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="agamaModal" tabindex="-1" aria-labelledby="agamaLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="agamaLabel">Filter Berdasarkan Agama</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form id="filterFormAgama">
                                    <div class="modal-body">

                                        <div class="form-check">
                                            <div class="row">
                                                <?php foreach ($agamaList as $agama): ?>
                                                    <div class="col-6">
                                                        <input class="form-check-input" name="agama[]" type="checkbox" value="<?= htmlspecialchars($agama['id']) ?>" id="checkbox-agama-<?= htmlspecialchars($agama['id']) ?>">
                                                        <label class="form-check-label" for="checkbox-agama-<?= htmlspecialchars($agama['id']) ?>">
                                                            <?= htmlspecialchars($agama['nama']) ?>
                                                        </label>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary" id="applyAgamaFilters">Cari</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="pendidikankkModal" tabindex="-1" aria-labelledby="pendidikankkLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="pendidikankkLabel">Filter Berdasarkan pendidikan KK</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form id="frmpendidikankk">
                                    <div class="modal-body">

                                        <div class="form-check">
                                            <div class="row">
                                                <?php foreach ($pendidikanList as $pendidikankk): ?>
                                                    <div class="col-6">
                                                        <input class="form-check-input" name="pendidikankk[]" type="checkbox" value="<?= htmlspecialchars(string: $pendidikankk['id']) ?>" id="checkbox-pendidikan-<?= htmlspecialchars($pendidikankk['id']) ?>">
                                                        <label class="form-check-label" for="checkbox-pendidikan-<?= htmlspecialchars($pendidikankk['id']) ?>">
                                                            <?= htmlspecialchars($pendidikankk['nama']) ?>
                                                        </label>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="modal-footer">
                                        <button button type="button" class="btn btn-primary" id="applyPendidikankkFilters">Cari</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="pendidikansdgModal" tabindex="-1" aria-labelledby="pendidikankksdgLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="pendidikankksdgLabel">Filter Berdasarkan Pendidikan Sedang</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form id="frmpendidikansdg">
                                    <div class="modal-body">

                                        <div class="form-check">
                                            <div class="row">
                                                <?php foreach ($pendidikanList as $pendidikankksdg): ?>
                                                    <div class="col-6">
                                                        <input class="form-check-input" name="pendidikansdg[]" type="checkbox" value="<?= htmlspecialchars(string: $pendidikankksdg['id']) ?>" id="checkbox-pendidikansdg-<?= htmlspecialchars($pendidikankksdg['id']) ?>">
                                                        <label class="form-check-label" for="checkbox-pendidikansdg-<?= htmlspecialchars($pendidikankksdg['id']) ?>">
                                                            <?= htmlspecialchars($pendidikankksdg['nama']) ?>
                                                        </label>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="modal-footer">
                                        <button button type="button" class="btn btn-primary" id="applypendidikansdgFilters">Cari</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="pekerjaanModal" tabindex="-1" aria-labelledby="pendidikankksdgLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="pendidikankksdgLabel">Filter Berdasarkan Pendidikan Sedang</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form id="frmPekerjaan">
                                    <div class="modal-body">

                                        <div class="form-check">
                                            <div class="row">
                                                <?php foreach ($pekerjaanList as $pekerjaan): ?>
                                                    <div class="col-6">
                                                        <input class="form-check-input" name="pekerjaan[]" type="checkbox" value="<?= htmlspecialchars(string: $pekerjaan['id']) ?>" id="checkbox-pekerjaan-<?= htmlspecialchars($pekerjaan['id']) ?>">
                                                        <label class="form-check-label" for="checkbox-pekerjaan-<?= htmlspecialchars($pekerjaan['id']) ?>">
                                                            <?= htmlspecialchars($pekerjaan['nama']) ?>
                                                        </label>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary" id="applyPekerjaanFilters">Cari</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                    <!-- Filter Modal 1: Status Kawin -->
                    <div class="modal fade" id="filterModalStatusKawin" tabindex="-1" role="dialog" aria-labelledby="filterModalStatusKawinLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="filterModalStatusKawinLabel">Filter by Status Kawin</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form id="filterFormStatusKawin">
                                        <?php foreach ($kawinList as $kawin): ?>
                                            <div class="col-6">
                                                <input class="form-check-input" name="status_kawin[]" type="checkbox" value="<?= htmlspecialchars($kawin['id']) ?>" id="checkbox-<?= htmlspecialchars($kawin['id']) ?>">
                                                <label class="form-check-label" for="checkbox-<?= htmlspecialchars($kawin['id']) ?>">
                                                    <?= htmlspecialchars($kawin['nama']) ?>
                                                </label>
                                            </div>
                                        <?php endforeach; ?>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary" id="applyStatusKawinFilters">Apply Filter</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="wnModal" tabindex="-1" aria-labelledby="pendidikankksdgLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="pendidikankksdgLabel">Filter Berdasarkan Warga Negara</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form id="frmwn">
                                    <div class="modal-body">

                                        <div class="form-check">
                                            <div class="row">
                                                <?php foreach ($warganegaraList as $wn): ?>
                                                    <div class="col-6">
                                                        <input class="form-check-input" name="wn[]" type="checkbox" value="<?= htmlspecialchars(string: $wn['id']) ?>" id="checkbox-wn-<?= htmlspecialchars($wn['id']) ?>">
                                                        <label class="form-check-label" for="checkbox-wn-<?= htmlspecialchars($wn['id']) ?>">
                                                            <?= htmlspecialchars($wn['nama']) ?>
                                                        </label>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary" id="applyWNFilters">Cari</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="goldarModal" tabindex="-1" aria-labelledby="pendidikankksdgLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="pendidikankksdgLabel">Filter Berdasarkan Warga Negara</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form id="frmgoldar">
                                    <div class="modal-body">

                                        <div class="form-check">
                                            <div class="row">
                                                <?php foreach ($golongandarahList as $goldar): ?>
                                                    <div class="col-6">
                                                        <input class="form-check-input"
                                                            name="goldar[]"
                                                            type="checkbox"
                                                            value="<?= htmlspecialchars($goldar['id']) ?>"
                                                            id="checkbox-goldar-<?= htmlspecialchars($goldar['id']) ?>"
                                                            <?= in_array($goldar['id'], $request->getGet('goldar') ?? []) ? 'checked' : '' ?>>
                                                        <label class="form-check-label" for="checkbox-goldar-<?= htmlspecialchars($goldar['id']) ?>">
                                                            <?= htmlspecialchars($goldar['nama']) ?>
                                                        </label>
                                                    </div>
                                                <?php endforeach; ?>


                                            </div>
                                        </div>


                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary" id="applyGoldarFilters">Cari</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped compact" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Aksi</th>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>L/P</th>
                            <th>Umur</th>
                            <th>Tanggal Lahir</th>
                            <th>Pendidikan dalam KK</th>
                            <th>Pekerjaan</th>
                            <th>Status Kawin</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Aksi</th>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>L/P</th>
                            <th>Umur</th>
                            <th>Tanggal Lahir</th>
                            <th>Pendidikan dalam KK</th>
                            <th>Pekerjaan</th>
                            <th>Status Kawin</th>
                        </tr>
                    </tfoot>
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

<script>
    $(document).ready(function() {
        const table = $("#dataTable").DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '<?= base_url("admin/ajax/penduduk"); ?>',
                type: 'GET',
                data: function(d) {
                    // Get selected checkboxes for status_kawin filter
                    let statusKawinFilter = [];
                    $('input[name="status_kawin[]"]:checked').each(function() {
                        statusKawinFilter.push($(this).val());
                    });
                    d.status_kawin = statusKawinFilter;
                    let agamaFilter = [];
                    $('input[name="agama[]"]:checked').each(function() {
                        agamaFilter.push($(this).val());
                    });
                    d.agama = agamaFilter;
                    let sdkFilter = [];
                    $('input[name="sdk[]"]:checked').each(function() {
                        sdkFilter.push($(this).val());
                    });
                    d.sdk = sdkFilter;
                    let pendidikankk = [];
                    $('input[name="pendidikankk[]"]:checked').each(function() {
                        pendidikankk.push($(this).val());
                    });
                    d.pendidikankk = pendidikankk;

                    let pendidikansdg = [];
                    $('input[name="pendidikansdg[]"]:checked').each(function() {
                        pendidikansdg.push($(this).val());
                    });
                    d.pendidikansdg = pendidikansdg;

                    let pekerjaan = [];
                    $('input[name="pekerjaan[]"]:checked').each(function() {
                        pekerjaan.push($(this).val());
                    });
                    d.pekerjaan = pekerjaan;

                    let wn = [];
                    $('input[name="wn[]"]:checked').each(function() {
                        wn.push($(this).val());
                    });
                    d.wn = wn;

                    let goldar = [];
                    $('input[name="goldar[]"]:checked').each(function() {
                        goldar.push($(this).val());
                    });
                    d.goldar = goldar;
                }
            },
            columns: [{
                    data: 'no',
                    name: 'no'
                },
                {
                    data: 'id',
                    name: 'aksi',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        return `
                    <form action="/admin/penduduk/${row.id}" method="post">
                        <div class="btn-group">
                            <a href="/admin/penduduk/${row.id}" class="btn btn-sm btn-primary" title="Rincian">
                                <i class="fa fa-eye"></i> Rincian
                            </a>
                            <a href="/admin/penduduk/${row.id}/edit" class="btn btn-sm btn-warning" title="Ubah">
                                <i class="fa fa-edit"></i> Ubah
                            </a>
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" class="btn btn-sm btn-danger" title="Hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                <i class="fa fa-trash"></i> Hapus
                            </button>
                        </div>
                    </form>
                `;
                    }
                },
                {
                    data: 'nik',
                    name: 'nik'
                },
                {
                    data: 'nama',
                    name: 'nama'
                },
                {
                    data: 'sex',
                    name: 'sex',
                    render: function(data) {
                        return (data === '1' ? 'L' : 'P');
                    }
                },
                {
                    data: 'tanggallahir',
                    name: 'umur',
                    render: function(data) {
                        const dob = new Date(data);
                        const today = new Date();
                        const age = today.getFullYear() - dob.getFullYear();
                        return age;
                    }
                },
                {
                    data: 'tanggallahir',
                    name: 'tanggallahir'
                },
                {
                    data: 'pendidikan_nama',
                    name: 'pendidikan_nama'
                },
                {
                    data: 'pekerjaan_nama',
                    name: 'pekerjaan_nama'
                },
                {
                    data: 'kawin_nama',
                    name: 'kawin_nama'
                }
            ],
            lengthChange: false,
            buttons: [{
                    text: `<i class="fa fa-plus-circle"></i>&nbsp;Tambah Penduduk Baru`,
                    className: "btn-sm",
                    action: function() {
                        window.location.href = '/admin/penduduk/new';
                    }
                },
                {
                    text: `<i class="fa fa-print"></i>&nbsp;Cetak`,
                    extend: 'print',
                    className: "btn-sm"
                },
                {
                    text: `<i class="fa fa-filter"></i>&nbsp;Preferensi Kolom`,
                    extend: 'colvis',
                    className: "btn-sm"
                }
            ],
            dom: 'Bfrtip'
        });

        // Append DataTable buttons
        table.buttons().container().appendTo("#dataTable_wrapper .col-md-6:eq(0)");

        // Show the filter modal when the filter button is clicked
        $('#filterButtonStatusKawin').on('click', function() {
            $('#filterModalStatusKawin').modal('show');
        });

        // Apply selected filters and reload the table
        $('#applyStatusKawinFilters').on('click', function() {
            table.ajax.reload();
            $('#filterModalStatusKawin').modal('hide');
        });

        $('#applyAgamaFilters').on('click', function() {
            table.ajax.reload();
            $('#agamaModal').modal('hide');
        });

        $('#applySdkFilters').on('click', function() {
            table.ajax.reload();
            $('#sdhkx').modal('hide');
        });

        $('#applyPendidikankkFilters').on('click', function() {
            table.ajax.reload();
            $('#pendidikankkModal').modal('hide');
        });

        $('#applypendidikansdgFilters').on('click', function() {
            table.ajax.reload();
            $('#pendidikansdgModal').modal('hide');
        });

        $('#applyPekerjaanFilters').on('click', function() {
            table.ajax.reload();
            $('#pekerjaanModal').modal('hide');
        });

        $('#applyWNFilters').on('click', function() {
            table.ajax.reload();
            $('#wnModal').modal('hide');
        });

        $('#applyGoldarFilters').on('click', function() {
            table.ajax.reload();
            $('#goldarModal').modal('hide');
        });


    });
</script>

<?= $this->endSection(); ?>