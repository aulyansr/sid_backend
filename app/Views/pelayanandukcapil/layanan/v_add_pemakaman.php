<?= $this->extend('pelayanandukcapil/layout/dashboard'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Entri Data Buku Pokok Pemakaman</h1>
    <!-- DataTales Example -->
    <div class="row">
        <!--start: card kiri -->
        <div class="card shadow mb-4 col-md-12">
            <div class="card-header border-bottom">
                <?= $this->include('pelayanandukcapil/partials/tabs', ['activeTab' => $activeTab]); ?>
            </div>
            

            <div class="card-body">
            <!-- <h6><i class="fa fa-users"></i> Data Pemohon</h6> -->
            <!-- start breadcrumb -->
               <?= $this->include('pelayanandukcapil/layanan/breadcrumb'); ?>
            <!-- start breadcrumb -->
                <form action="simpan" method="post">
                    <div class="mb-3">
                        <label class="small mb-1" for="NIK">NIK</label>
                        <input type="text" class="form-control hanyaangka" id="NIK" data-maxlength="16" data-minlength="16" name="NIK" placeholder="NIK" value="<?= isset($NIK) ? $NIK : '' ?>" required aria-label="NIK" aria-describedby="basic-addon2">
                        <div id="NIKCounter" style="color: black;">0/16</div>
                        <!-- <div class="input-group-append">
                            <button id="getBio" class="btn btn-success" type="button"> Cari..</button>
                        </div> -->
                    </div>

                    <div class="mb-3">
                        <label class="small mb-1" for="NAMA MENINGGAL">NAMA MENINGGAL</label>
                        <input class="form-control" id="NAMA_MENINGGAL" type="text" name="NAMA_MENINGGAL" value="<?= isset($NAMA_MENINGGAL) ? $NAMA_MENINGGAL : '' ?>" required placeholder="NAMA MENINGGAL">
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="small mb-1" for="TEMPAT LAHIR">TEMPAT LAHIR</label>
                                <!-- <input class="form-control" id="exampleFormControlInput1" type="text" placeholder="ALAMAT"> -->
                                <input class="form-control" id="TEMPAT_LAHIR" type="text" name="TEMPAT_LAHIR" value="<?= isset($TEMPAT_LAHIR) ? $TEMPAT_LAHIR : '' ?>" required placeholder="TEMPAT LAHIR">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="small mb-1" for="TGL_LAHIR">TGL LAHIR</label>
                                <input class="form-control" id="TGL_LAHIR" type="date" maxlength="12" name="TGL_LAHIR" value="<?= isset($TGL_LAHIR) ? $TGL_LAHIR : '' ?>" required placeholder="TGL LAHIR">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="small mb-1" for="TEMPAT_MENINGGAL">TEMPAT MENINGGAL</label>
                                <input class="form-control" id="TEMPAT_MENINGGAL" type="text" name="TEMPAT_MENINGGAL" value="<?= isset($TEMPAT_MENINGGAL) ? $TEMPAT_MENINGGAL : '' ?>" required placeholder="TEMPAT MENINGGAL">
                            </div>  
                        </div>  
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="small mb-1" for="TGL_MENINGGAL">TGL MENINGGAL</label>
                                <input class="form-control" id="TGL_MENINGGAL" type="date" name="TGL_MENINGGAL" value="<?= isset($TGL_MENINGGAL) ? $TGL_MENINGGAL : '' ?>" required placeholder="TGL MENINGGAL">
                            </div> 
                        </div> 
                    </div> 
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="small mb-1" for="TGL_PEMAKAMAN">TGL PEMAKAMAN</label>
                                <input class="form-control" id="TGL_PEMAKAMAN" type="date" name="TGL_PEMAKAMAN" value="<?= isset($TGL_PEMAKAMAN) ? $TGL_PEMAKAMAN : '' ?>" required placeholder="TGL PEMAKAMAN">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="small mb-1" for="LOKASI_MAKAM">LOKASI MAKAM</label>
                                <input class="form-control" id="LOKASI_MAKAM" type="text" name="LOKASI_MAKAM" value="<?= isset($LOKASI_MAKAM) ? $LOKASI_MAKAM : '' ?>" required placeholder="LOKASI MAKAM">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="small mb-1" for="NIK_PELAPOR">NIK PELAPOR</label>
                        <input class="form-control hanyaangka" id="NIK_PELAPOR" type="text" name="NIK_PELAPOR" value="<?= isset($NIK_PELAPOR) ? $NIK_PELAPOR : '' ?>" required placeholder="NIK PELAPOR">
                        <div id="NIK2Counter" style="color: black;">0/16</div>
                    </div>
                    <div class="mb-3">
                        <label class="small mb-1" for="NAMA_PELAPOR">NAMA PELAPOR</label>
                        <input class="form-control" id="NAMA_PELAPOR" type="text" name="NAMA_PELAPOR" value="<?= isset($NAMA_PELAPOR) ? $NAMA_PELAPOR : '' ?>" required placeholder="NAMA PELAPOR">
                    </div>
                    <div class="mb-3">
                        <label class="small mb-1" for="NAMA_KELUARGA">NAMA KELUARGA</label>
                        <input class="form-control" id="NAMA_KELUARGA" type="text" name="NAMA_KELUARGA" value="<?= isset($NAMA_KELUARGA) ? $NAMA_KELUARGA : '' ?>" required placeholder="NAMA KELUARGA">
                    </div>
                    <div class="mb-3">
                        <label class="small mb-1" for="NO_HP">NO HP</label>
                        <input class="form-control" id="NO_HP" type="text" name="NO_HP" value="<?= isset($NO_HP) ? $NO_HP : '' ?>" required placeholder="NO HP">
                    </div>
                    <div class="mb-3">
                        <label class="small mb-1" for="KETERANGAN">KETERANGAN</label>
                        <input class="form-control" id="KETERANGAN" type="text" name="KETERANGAN" value="<?= isset($KETERANGAN) ? $KETERANGAN : '' ?>" required placeholder="KETERANGAN">
                    </div>

                    <div class="d-flex justify-content-end">
                        <div>
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-save"></i> Submit
                            </button>
                        </div>
                    </div>
                    <!-- end -->

                </form>
            </div>
        </div>
        <!-- end card kiri -->
    </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<!-- Page level plugins -->

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
        
                
        // VALIDASI NIK HANYA BOLEH 16 KARAKTER
        $('#NIK_PELAPOR').on('input', function () {
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
            $('#NIK2Counter').text(length + "/16");
            
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