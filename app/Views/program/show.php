<?= $this->extend('layout/dashboard'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800 text-center"><?= $programModel['nama']; ?></h1>

    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card">
                <div class="card-body">

                    <!-- Family Details -->
                    <div class="card-header">Detail Program</div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Nomor KK -->
                            <div class="col-md-6 mb-3">
                                <label class="small mb-1" for="no_kk">nama Propgram</label>
                                <p><?= esc($programModel['nama']); ?></p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="small mb-1" for="no_kk">Sasaran Peserta</label>
                                <p><?= esc($programModel['nama']); ?></p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="small mb-1" for="no_kk">nama Propgram</label>
                                <input class="form-control" id="no_kk" type="text" value="<?= esc($programModel['nama']); ?>" readonly>
                            </div>


                        </div>
                    </div>

                    <!-- Family Member List -->
                    <div class="card-header">Anggota Keluarga</div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>NIK</th>
                                    <th>Alamat Sekarang</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Pendidikan</th>
                                    <th>Hubungan dalam Keluarga</th>
                                </tr>
                            </thead>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>