<?= $this->extend('layout/dashboard'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800 text-center">Form Keluarga</h1>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="<?= isset($keluarga) ? base_url('admin/keluarga/' . $keluarga['id']) : base_url('admin/keluarga') ?>" method="post">
                        <input type="hidden" name="_method" value="PUT">
                        <!-- Form Header -->
                        <div class="card-header">Detail keluarga</div>
                        <div class="card-body">
                            <!-- Form Row for No KK and NIK Kepala -->
                            <div class="row gx-3 mb-3">
                                <!-- Form Group (No KK) -->
                                <div class="col-md-12 mb-3">
                                    <label class="small mb-1" for="inputKK">Nomor KK</label>
                                    <input class="form-control" id="inputKK" name="no_kk" type="text" placeholder="No KK" value="<?= old('no_kk', isset($keluarga) ? esc($keluarga['no_kk']) : 'xx'); ?>" required>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label class="small mb-1 d-block" for="inputNIK">NIK Kepala Keluarga</label>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <select class="form-control" id="nik" name="nik_kepala" required>
                                                <option value="">Pilih Penduduk</option>
                                                <?php if (isset($keluarga)): ?>
                                                    <option value="<?= esc($kepala_keluarga['nik']); ?>" selected><?= esc($kepala_keluarga['nik']) . ' - ' . esc($kepala_keluarga['nama']); ?></option>
                                                <?php endif; ?>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <a href="/admin/penduduk/new" class="btn btn-sm btn-primary" target="_blank">
                                                Tambah Penduduk
                                            </a>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- Anggota Keluarga Section -->
                        <div class="card-header">Anggota Keluarga</div>
                        <div class="card-body">
                            <!-- Family Member List -->
                            <div id="anggota-list">
                                <!-- Populate existing family members -->
                                <?php if (isset($anggota_keluarga) && is_array($anggota_keluarga)): ?>
                                    <?php foreach ($anggota_keluarga as $index => $anggota): ?>
                                        <div class="row pb-5 mb-3 align-items-center" data-index="<?= $index; ?>" style="border-bottom:1px solid gray">
                                            <div class="col-md-6">
                                                <label class="small mb-1" for="inputHubungan">NIK Anggota</label>
                                                <select class="form-control nik-anggota" name="anggota_keluarga[<?= $index; ?>][nik]" required>
                                                    <option value="<?= esc($anggota['nik']); ?>" selected><?= esc($anggota['nik']) . ' - ' . esc($anggota['nama']); ?></option>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="small mb-1" for="inputHubungan">Hubungan dalam Keluarga</label>
                                                <select class="form-control select2" name="anggota_keluarga[<?= $index; ?>][kk_level]" required>
                                                    <?php foreach ($hubunganList as $hubungan): ?>
                                                        <option value="<?= esc($hubungan['id']); ?>" <?= $anggota['kk_level'] == $hubungan['id'] ? 'selected' : ''; ?>><?= esc($hubungan['nama']); ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <button type="button" class="btn btn-danger remove-anggota">Hapus</button>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>

                            <!-- Button to Add Family Member -->
                            <button type="button" id="add-anggota-button" class="btn btn-success mt-2">Tambah Anggota Keluarga</button>
                        </div>

                        <!-- Submit Button -->
                        <button class="btn btn-primary mt-4" type="submit"><?= isset($keluarga) ? 'Update keluarga' : 'Buat keluarga'; ?></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script>
    // Initialize select2 for Kepala Keluarga
    $('#nik').select2({
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

    // Event handler for adding new family members
    $('#add-anggota-button').on('click', function() {
        var anggotaIndex = $('#anggota-list .row').length;
        var hubunganOptions = `<?php foreach ($hubunganList as $hubungan): ?>
                                <option value="<?= esc($hubungan['id']); ?>"><?= esc($hubungan['nama']); ?></option>
                            <?php endforeach; ?>`;

        var newAnggota = `
        <div class="row pb-5 mb-3 align-items-center" data-index="` + anggotaIndex + `" style="border-bottom:1px solid gray">
            <div class="col-md-6">
                <label class="small mb-1" for="inputHubungan">NIK Anggota</label>
                <select class="form-control nik-anggota" name="anggota_keluarga[` + anggotaIndex + `][nik]" required>
                    <option value="">Pilih Penduduk</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="small mb-1" for="inputHubungan">Hubungan dalam Keluarga</label>
                <select class="form-control select2" name="anggota_keluarga[` + anggotaIndex + `][kk_level]" required>
                    <option value="">Pilih Hubungan</option>
                    ` + hubunganOptions + `
                </select>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger remove-anggota">Hapus</button>
            </div>
        </div>`;

        $('#anggota-list').append(newAnggota);
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

    // Event handler for removing family members
    $(document).on('click', '.remove-anggota', function() {
        $(this).closest('.row').remove();
    });
</script>
<?= $this->endSection(); ?>