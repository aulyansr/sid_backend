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
                        <input type="text" class="form-control hanyaangka" id="NIK" data-maxlength="16" data-minlength="16" name="NIK" placeholder="NIK" value="<?= isset($NIK) ? $NIK : '' ?>" required aria-label="NIK" aria-describedby="basic-addon2">
                        <div id="NIKCounter" style="color: black;">0/16</div>
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

<script>
    $(document).ready(function () {
        $('#submitsatu').prop('disabled', true); // Disable button awalnya
        
        // VALIDASI NIK HANYA BOLEH 16 KARAKTER
        $('#NIK').on('input', function () {
            let noValue = $(this).val();
            
            // Hanya angka diperbolehkan
            let cleanedValue = noValue.replace(/\D/g, ''); 
            // Batasi maksimal 10 angka
            if (cleanedValue.length > 16) {
                cleanedValue = cleanedValue.substring(0, 16);
            }
            $(this).val(cleanedValue);
            
            // Hitung panjang karakter
            let length = cleanedValue.length;
            $('#NIKCounter').text(length + "/16");
            
            // Validasi panjang 10 digit
            if (length === 16) {
                $('#errorNIK').text('');
                $('#submitsatu').prop('disabled', false);
            } else {
                $('#errorNIK').text('NIK harus berisi 16 angka.');
                $('#submitsatu').prop('disabled', true);
            }
        });

        // VALIDASI NO HP MAKSIMAL 20 KARAKTER
        $('#NO_HP').on('input', function () {
            let noValue = $(this).val();
            
            // Hanya angka diperbolehkan
            let cleanedValue = noValue.replace(/\D/g, ''); 
            // Batasi maksimal 10 angka
            if (cleanedValue.length > 20) {
                cleanedValue = cleanedValue.substring(0, 20);
            }
            $(this).val(cleanedValue);
            
            // Hitung panjang karakter
            // let length = cleanedValue.length;
            // $('#NIKCounter').text(length + "/16");
            
            // Validasi panjang 10 digit
            // if (length === ) {
            //     $('#errorNIK').text('');
            //     $('#submitsatu').prop('disabled', false);
            // } else {
            //     $('#errorNIK').text('NIK harus berisi 16 angka.');
            //     $('#submitsatu').prop('disabled', true);
            // }
        });
    });
</script>
<?= $this->endSection(); ?>