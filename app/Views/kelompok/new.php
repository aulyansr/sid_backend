<?= $this->extend('layout/dashboard'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800 text-center">Form Kelompok</h1>
    <div class="row justify-content-center">
        <div class="col-xl-8">
            <!-- Kelompok Master & Details Card -->
            <form action="<?= site_url('/admin/kelompok'); ?>" method="post" enctype="multipart/form-data">
                <div class="card mb-4">
                    <div class="card-header">Kelompok Details</div>
                    <div class="card-body">

                        <?= csrf_field(); ?>

                        <!-- Kelompok Master Selection -->
                        <div class="form-group mb-3">
                            <label for="inputIdMaster">Kelompok Master</label>
                            <select class="form-control" id="inputIdMaster" name="id_master" required>
                                <option value="">Pilih Kelompok Master</option>
                                <?php foreach ($kelompokMasters as $kelompokMaster): ?>
                                    <option value="<?= $kelompokMaster['id']; ?>"><?= $kelompokMaster['kelompok']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Ketua Selection -->
                        <div class="form-group mb-3">
                            <label for="inputIdKetua">Ketua</label>
                            <select class="form-control" id="inputIdKetua" name="id_ketua" required>
                                <option value="">Pilih Ketua</option>
                            </select>
                        </div>

                        <!-- Kelompok Kode -->
                        <div class="form-group mb-3">
                            <label for="inputKode">Kode</label>
                            <input class="form-control" id="inputKode" name="kode" type="text" placeholder="Kode Kelompok" value="<?= old('kode'); ?>" required maxlength="16">
                        </div>

                        <!-- Kelompok Nama -->
                        <div class="form-group mb-3">
                            <label for="inputNama">Nama</label>
                            <input class="form-control" id="inputNama" name="nama" type="text" placeholder="Nama Kelompok" value="<?= old('nama'); ?>" required maxlength="50">
                        </div>

                        <!-- Kelompok Keterangan -->
                        <div class="form-group mb-3">
                            <label for="inputKeterangan">Keterangan</label>
                            <textarea class="form-control" id="inputKeterangan" name="keterangan" placeholder="Keterangan Kelompok" required maxlength="100"><?= old('keterangan'); ?></textarea>
                        </div>



                    </div>
                </div>

                <?php if (auth()->user()->inGroup('superadmin')): ?>

                    <div class="col-md-12 mb-3">
                        <label class="small mb-1" for="inputDesa">Nama Desa</label>
                        <select class="form-control select2" id="inputDesa" name="desa_id">
                            <option value="">Pilih Desa</option>
                            <?php foreach ($list_desa as $desa): ?>
                                <option value="<?= esc($desa['id']); ?>" <?= (old('id', isset($desa) ? esc($desa['id']) : '') == esc($desa['id'])) ? 'selected' : ''; ?>>
                                    <?= esc($desa['nama_desa']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                <?php else: ?>

                    <input type="hidden" name="desa_id" value="<?= auth()->user()->desa_id; ?>">

                <?php endif; ?>

                <!-- Anggota Keluarga Card -->
                <div class="card mb-4">
                    <div class="card-header">Anggota Keluarga</div>
                    <div class="card-body">
                        <!-- Family Member List -->
                        <div id="anggota-list"></div>

                        <!-- Button to Add Family Member -->
                        <button type="button" id="add-anggota-button" class="btn btn-success mt-2">Tambah Anggota Keluarga</button>
                        <div class="mt-3">
                            <!-- Submit Button -->
                            <button class="btn btn-primary" type="submit">Simpan Kelompok</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script>
    // Select2 for Ketua (Leader)
    $('#inputIdKetua').select2({
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
    });

    // Add Family Member Functionality
    $('#add-anggota-button').on('click', function() {
        var anggotaIndex = $('#anggota-list .row').length; // Track number of family members

        var newAnggota = `
            <div class="row pb-3 align-items-center" data-index="` + anggotaIndex + `" style="border-bottom: 1px solid #ccc;">
                <div class="col-md-6 mb-2">
                    <label for="inputAnggotaNik">NIK Anggota</label>
                    <select class="form-control nik-anggota" name="anggota_kelompok[` + anggotaIndex + `][nik]" required>
                        <option value="">Pilih Penduduk</option>
                    </select>
                </div>
                <div class="col-md-2 mb-2">
                    <button type="button" class="btn btn-danger remove-anggota">Hapus</button>
                </div>
            </div>`;

        // Append new family member input to list
        $('#anggota-list').append(newAnggota);

        // Initialize Select2 for new family member
        $('.nik-anggota').last().select2({
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
        });
    });

    // Remove Family Member
    $(document).on('click', '.remove-anggota', function() {
        $(this).closest('.row').remove();
    });
</script>
<?= $this->endSection(); ?>