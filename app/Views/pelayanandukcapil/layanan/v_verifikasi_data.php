<?= $this->extend('pelayanandukcapil/layout/dashboard'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Permohonan Pelayanan</h1>
    <!-- DataTales Example -->
    <div class="row">
        <!--start: card kiri -->
        <div class="card shadow mb-4 col-md-9">
            <div class="card-header border-bottom">
                <?= $this->include('pelayanandukcapil/partials/tabs', ['activeTab' => $activeTab]); ?>
            </div>
            

            <div class="card-body">
            <!-- <h6><i class="fa fa-users"></i> Data Pemohon</h6> -->
            <!-- start breadcrumb -->
               <?= $this->include('pelayanandukcapil/layanan/breadcrumb'); ?>
            <!-- start breadcrumb -->
                <form action="verifikasi-detail-permohonan" method="post">
                    <div class="mb-3">
                        <!-- kode kapanewon wonosari value="1"-->
                        <input type="text" class="form-control" id="KAPANEWON" name="KAPANEWON" value="1" placeholder="KAPANEWON"  aria-label="KAPANEWON" aria-describedby="basic-addon2">
                    </div> 
                    <!-- kode kalurahan wonosari value="2001"-->
                    <div class="mb-3">
                        <input type="text" class="form-control" id="KALURAHAN" name="KALURAHAN" value="2001" placeholder="KALURAHAN"  aria-label="KALURAHAN" aria-describedby="basic-addon2">
                    </div> 

                    <div class="mb-3">
                        <label class="small mb-1" for="NIK">NIK</label>
                        <input type="text" class="form-control hanyaangka" name="NIK" placeholder="NIK" value="<?= isset($NIK) ? $NIK : '' ?>" required aria-label="NIK" aria-describedby="basic-addon2">
                        <!-- <div class="input-group-append">
                            <button id="getBio" class="btn btn-success" type="button"> Cari..</button>
                        </div> -->
                    </div>

                    <div class="mb-3">
                        <label class="small mb-1" for="NAMA_PEMOHON">NAMA PEMOHON</label>
                        <input class="form-control" id="NAMA_PEMOHON" type="text" name="NAMA_PEMOHON" value="<?= isset($NAMA_PEMOHON) ? $NAMA_PEMOHON : '' ?>" required placeholder="NAMA PEMOHON">
                    </div>
                    <div class="mb-3">
                        <label class="small mb-1" for="ALAMAT">ALAMAT</label>
                        <!-- <input class="form-control" id="exampleFormControlInput1" type="text" placeholder="ALAMAT"> -->
                        <textarea class="form-control" id="ALAMAT" name="ALAMAT" placeholder="ALAMAT" required><?= isset($ALAMAT) ? $ALAMAT : '' ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="small mb-1" for="NO_HP">NO HP</label>
                        <input class="form-control hanyaangka" id="NO_HP" type="text" name="NO_HP" value="<?= isset($NO_HP) ? $NO_HP : '' ?>" required placeholder="isi dengan NO HP valid">
                    </div>
                    <div class="mb-3">
                        <label class="small mb-1" for="EMAIL_TERMOHON">EMAIL TERMOHON</label>
                        <input class="form-control" id="EMAIL_TERMOHON" type="email" name="EMAIL_TERMOHON" value="<?= isset($EMAIL_TERMOHON) ? $EMAIL_TERMOHON : '' ?>" required placeholder="EMAIL TERMOHON">
                    </div>
                    <div class="mb-3">
                        <label class="small mb-1" for="exampleFormControlInput1">TGL RENCANA PENGAMBILAN</label>
                        <!-- <input class="form-control" id="exampleFormControlInput1" id="datepicker" type="date" placeholder="TGL RENCANA PENGAMBILAN"> -->
                        <input type="text" class="form-control" id="datepicker" name="TGL_RENCANA_PENGAMBILAN" value="<?= isset($TGL_RENCANA_PENGAMBILAN) ? $TGL_RENCANA_PENGAMBILAN : '' ?>" required placeholder="Pilih tanggal">
                    </div>

                    <div class="d-flex justify-content-end">
                        <div>
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-arrow-right"></i> lanjut
                            </button>
                        </div>
                    </div>
                    <!-- end -->

                </form>
            </div>
        </div>
        <!-- end card kiri -->
        <!-- star card kanan -->
        <div class="card shadow mb-3 col-md-3">
            <div class="card-header border-bottom">
                Permohonan Hari ini
            </div>
            <div class="card-body">
                <form>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped compact" width="100%" cellspacing="0">
                            <tbody>
                                <tr>
                                    <td>
                                        <a class="btn btn-success btn-sm text-xs" data-title="Print" target="_blank" href="https://sid-dev.gunungkidulkab.go.id/verifikasi/cetak/0000-00-10-0000"><i class="fa fa-print"></i>&nbsp;00187/17/10/2024</a>
                                    </td>
                                    <td class="text-xs">JOHN DOE</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </div>
        <!-- end card kanan -->
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