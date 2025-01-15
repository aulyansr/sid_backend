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
                <form action="simpan-permohonan" method="post" enctype='multipart/form-data'>
                    <div class="mb-3">
                        <label class="small mb-1" for="exampleFormControlInput1">LOKASI PENGAMBILAN</label>
                        <select class="form-control" id="LOKASI_PENGAMBILAN" name="LOKASI_PENGAMBILAN">
                            <option value='00' <?= $LOKASI_PENGAMBILAN == '00' ? 'selected' : '' ?>>Mall Pelayanan Publik</option>
                            <option value='19' <?= $LOKASI_PENGAMBILAN == '19' ? 'selected' : '' ?>>Dinas Dukcapil Gunungkidul</option>
                            <option value='20' <?= $LOKASI_PENGAMBILAN == '20' ? 'selected' : '' ?>>Anjungan Dukcapil Mandiri</option>
                            <option value='1' <?= $LOKASI_PENGAMBILAN == '1' ? 'selected' : '' ?>>Kapanewon Wonosari</option>
                            <option value='2' <?= $LOKASI_PENGAMBILAN == '2' ? 'selected' : '' ?>>Kapanewon Nglipar</option>
                            <option value='3' <?= $LOKASI_PENGAMBILAN == '3' ? 'selected' : '' ?>>Kapanewon Playen</option>
                            <option value='4' <?= $LOKASI_PENGAMBILAN == '4' ? 'selected' : '' ?>>Kapanewon Patuk</option>
                            <option value='5' <?= $LOKASI_PENGAMBILAN == '5' ? 'selected' : '' ?>>Kapanewon Paliyan</option>
                            <option value='6' <?= $LOKASI_PENGAMBILAN == '6' ? 'selected' : '' ?>>Kapanewon Panggang</option>
                            <option value='7' <?= $LOKASI_PENGAMBILAN == '7' ? 'selected' : '' ?>>Kapanewon Tepus</option>
                            <option value='8' <?= $LOKASI_PENGAMBILAN == '8' ? 'selected' : '' ?>>Kapanewon Semanu</option>
                            <option value='9' <?= $LOKASI_PENGAMBILAN == '9' ? 'selected' : '' ?>>Kapanewon Karangmojo</option>
                            <option value='10' <?= $LOKASI_PENGAMBILAN == '10' ? 'selected' : '' ?>>Kapanewon Ponjong</option>
                            <option value='11' <?= $LOKASI_PENGAMBILAN == '11' ? 'selected' : '' ?>>Kapanewon Rongkop</option>
                            <option value='12' <?= $LOKASI_PENGAMBILAN == '12' ? 'selected' : '' ?>>Kapanewon Semin</option>
                            <option value='13' <?= $LOKASI_PENGAMBILAN == '13' ? 'selected' : '' ?>>Kapanewon Ngawen</option>
                            <option value='14' <?= $LOKASI_PENGAMBILAN == '14' ? 'selected' : '' ?>>Kapanewon Gedangsari</option>
                            <option value='15' <?= $LOKASI_PENGAMBILAN == '15' ? 'selected' : '' ?>>Kapanewon Saptosari</option>
                            <option value='16' <?= $LOKASI_PENGAMBILAN == '16' ? 'selected' : '' ?>>Kapanewon Girisubo</option>
                            <option value='17' <?= $LOKASI_PENGAMBILAN == '17' ? 'selected' : '' ?>>Kapanewon Tanjungsari</option>
                            <option value='18' <?= $LOKASI_PENGAMBILAN == '18' ? 'selected' : '' ?>>Kapanewon Purwosari</option>
                        </select>
                    </div>


                    <div class="mb-3">
                        <div class="mb-3">
                            <label class="small mb-1" for="fileUpload1">UPLOAD PERSYARATAN</label>
                            <input type="file" id="fileUpload1" name="fileUpload1" class="form-control" placeholder="file upload" aria-label="file upload" accept=".pdf" onchange="previewFile(event, 'previewContainer1', 'fileName1')" required>
                        </div>
                        <!-- Preview Container -->
                        <div id="previewContainer1" class="preview-container" style="display: none;">
                            <span id="fileName1"></span>
                            <button type="button" class="btn btn-sm btn-danger" onclick="removeFile('fileUpload1', 'previewContainer1', 'fileName1')">Hapus</button>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="mb-3">
                            <label class="small mb-1" for="fileUpload2">UPLOAD PERSYARATAN TAMBAHAN</label>
                            <input type="file" id="fileUpload2" name="fileUpload2" class="form-control" placeholder="file upload" aria-label="file upload" accept=".pdf" onchange="previewFile(event, 'previewContainer2', 'fileName2')">
                        </div>
                        <!-- Preview Container -->
                        <div id="previewContainer2" class="preview-container" style="display: none;">
                            <span id="fileName2"></span>
                            <button type="button" class="btn btn-sm btn-danger" onclick="removeFile('fileUpload2', 'previewContainer2', 'fileName2')">Hapus</button>
                        </div>
                    </div>

                    <!-- <div class="mb-3">
                        <label class="small mb-1" for="exampleFormControlInput1">CATATAN</label>
                        <textarea class="form-control" id="CATATAN" name="CATATAN" placeholder="CATATAN" required><?= isset($CATATAN) ? $CATATAN : '' ?></textarea> -->
                        <!-- <input type="text" class="form-control" placeholder="catatan"  aria-label="text" aria-describedby="basic-addon2"> -->
                    <!-- </div> -->

                    <div class="d-flex justify-content-between">
                        <div>
                            <a href="<?= site_url('admin/verifikasi-detail-permohonan'); ?>"><button class="btn btn-primary" type="button">
                                    <i class="fas fa-arrow-left"></i> kembali
                                </button></a>
                        </div>

                        <div>
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-arrow-right"></i> simpan
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
        <!-- end card kiri -->
         <!-- star card kanan -->
         <?= $this->include('pelayanandukcapil/layanan/sidebar_permohonan_hariini'); ?>
        <!-- end card kanan -->
    </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('script'); ?>

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