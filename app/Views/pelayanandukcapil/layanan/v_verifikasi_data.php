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
                        <input type="hidden" class="form-control" id="KAPANEWON" name="KAPANEWON" value="1" placeholder="KAPANEWON"  aria-label="KAPANEWON" aria-describedby="basic-addon2">
                    </div> 
                    <!-- kode kalurahan wonosari value="2001"-->
                    <div class="mb-3">
                        <input type="hidden" class="form-control" id="KALURAHAN" name="KALURAHAN" value="2001" placeholder="KALURAHAN"  aria-label="KALURAHAN" aria-describedby="basic-addon2">
                    </div> 

                    <div class="mb-3">
                        <label class="small mb-1" for="NIK">NIK</label>
                        <input type="text" class="form-control hanyaangka" data-maxlength="16" data-minlength="16" name="NIK" placeholder="NIK" value="<?= isset($NIK) ? $NIK : '' ?>" required aria-label="NIK" aria-describedby="basic-addon2">
                        <div id="nikCounter" style="color: black;">0/16</div>
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
                        <input class="form-control" id="EMAIL_TERMOHON" type="text" name="EMAIL_TERMOHON" value="<?= isset($EMAIL_TERMOHON) ? $EMAIL_TERMOHON : '' ?>" required placeholder="EMAIL TERMOHON">
                    </div>
                    <!-- <div class="mb-3">
                        <label class="small mb-1" for="exampleFormControlInput1">TGL RENCANA PENGAMBILAN</label> -->
                        <!-- <input class="form-control" id="exampleFormControlInput1" id="datepicker" type="date" placeholder="TGL RENCANA PENGAMBILAN"> -->
                        <!-- <input type="text" class="form-control" id="datepicker" name="TGL_RENCANA_PENGAMBILAN" value="<?= isset($TGL_RENCANA_PENGAMBILAN) ? $TGL_RENCANA_PENGAMBILAN : '' ?>" required placeholder="Pilih tanggal">
                    </div> -->

                    <div class="d-flex justify-content-end">
                        <div>
                            <button class="btn btn-primary" type="submit" id="submitsatu">
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
        <?= $this->include('pelayanandukcapil/layanan/sidebar_permohonan_hariini'); ?>
        <!-- end card kanan -->
    </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<!-- Page level plugins -->
<script src="/assets/js/admin/vendors/datatables/DataTables-1.13.8/js/jquery.dataTables.min.js"></script>
<script src="/assets/js/admin/vendors/datatables/DataTables-1.13.8/js/dataTables.bootstrap4.min.js"></script>

<!-- Page level custom scripts -->
<!-- <script src="/assets/js/admin/demo/datatables-pengguna.js"></script> -->

<script>
    // Define the JavaScript variable with the URL from PHP
    var newkategorid = '/admin/kategori/new';

    $(document).ready(function() {
        validasiFormNik();
        eventNik();
    });


    function validasiFormNik() {
        var nik = $('.hanyaangka').val();
        // alert(nik);
        $('#nikCounter').text(nik.length + '/16');
        $('#errorNIK').hide();
        if (nik.length < 16) {
            $('#errorNIK').text('NIK harus terdiri dari 16 angka.').show();
            $('#submitBtn').prop('disabled', true);
            return false;
        } else if (nik.length === 16 && /^[0-9]+$/.test(nik)) {
            $('#submitBtn').prop('disabled', false);
            return true;
        } else {
            $('#errorNIK').text('NIK hanya boleh berisi angka.').show();
            $('#submitBtn').prop('disabled', true);
            return false;
        }
    }

    $('#submitsatu').on('click', function () {
        if (!/^\d{16}$/.test(NIK)) {
                alert('NIK harus berupa angka dan memiliki tepat 16 karakter!');
                return; // Hentikan proses jika tidak valid
            }
    });

    function eventNik() {
        // $('.hanyaangka').on('input', function() {
        //     var nik = $(this).val();
        //     if (nik.length > 16 && nik.length < 16) {
        //         $(this).val(nik.substring(0, 16));
        //     }
        //     validasiFormNik();
        // });
        $('.hanyaangka').on('input', function () {
            var nik = $(this).val();

            // Hapus karakter non-angka
            nik = nik.replace(/\D/g, '');

            // Batasi panjang maksimal 16 karakter
            if (nik.length > 16) {
                nik = nik.substring(0, 16);
            }

            $(this).val(nik); // Set nilai input

            validasiFormNik(); // Panggil fungsi validasi
        });

    }
</script>
<?= $this->endSection(); ?>