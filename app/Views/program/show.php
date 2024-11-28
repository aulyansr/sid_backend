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
                                <p><?= esc($targets[$programModel['sasaran']]); ?></p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="small mb-1" for="no_kk">Pelakasan</label>
                                <p><?= esc($programModel['pelaksana']); ?></p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="small mb-1" for="no_kk">Masa Berlaku</label>
                                <p><?= esc($programModel['sdate']); ?> - <?= esc($programModel['edate']); ?></p>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="small mb-1" for="no_kk">Keterangan</label>
                                <p><?= esc($programModel['sdate']); ?> - <?= esc($programModel['edate']); ?></p>
                            </div>


                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            Tambah Peserta
                        </div>
                        <div class="card-body">
                            <form action="<?= site_url('/admin/program/add-peserta') ?>" method="post">
                                <input type="hidden" name="program_id" value="<?= esc($programModel['id']); ?>">
                                <input type="hidden" name="sasaran" value="<?= esc($programModel['sasaran']); ?>">
                                <input type="hidden" name="userID" value="<?= auth()->user()->id; ?>">
                                <div class="row">
                                    <div class="col-md-8">
                                        <select class="form-control" id="id_peserta" name="peserta" required>
                                            <option value="">Pilih Penduduk</option>
                                            <!-- Populate selected value -->
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <button class="btn btn-primary" type="submit">Update</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Family Member List -->
                    <div class="card-header">Peserta Program</div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Aksi</th>
                                    <th>Nama</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($participants as $penduduk) : ?>
                                    <tr>
                                        <td><a href="" class="btn btn-danger">Hapus</a></td>
                                        <td><?= esc($penduduk['penduduk_nama']) ?></td>
                                        <td><?= esc($penduduk['penduduk_alamat']) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script>
    $('#id_peserta').select2({
        ajax: {
            url: '<?= base_url('/admin/ajax/penduduk/search'); ?>',
            dataType: 'json',
            delay: 250,
            processResults: function(data) {
                return {
                    results: data.map(function(item) {
                        return {
                            id: item.nik,
                            text: item.nik + ' - ' + item.nama
                        };
                    })
                };
            },
            cache: true
        },
        minimumInputLength: 1
    }).on('select2:select', function(e) {
        var data = e.params.data; // Get the selected data
        $('#nama_kepala').val(data.text.split(' - ')[1]); // Set nama_kepala based on selected data
    });
</script>
<?= $this->endSection(); ?>