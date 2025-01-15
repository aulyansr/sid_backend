<?= $this->extend('layout/dashboard'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800 text-center">Formulir Cetak Surat</h1>
    <div class="row justify-content-center">
        <div class="col-xl-8">
            <!-- Surat details card -->
            <div class="card mb-4">
                <div class="card-header">Cetak Surat</div>
                <div class="card-body">
                    <form action="<?= site_url('admin/surat/store'); ?>" method="post">
                        <?= csrf_field(); ?>

                        <!-- Hidden field for jenis surat -->
                        <input type="hidden" name="jenis_surat" value="<?= esc($jenis_surat); ?>">

                        <!-- Form Group (nama_surat) -->
                        <div class="mb-3">
                            <label class="small mb-1" for="inputNomorSurat">Nomor Surat</label>
                            <input class="form-control" id="inputNomorSurat" name="nomor_surat" type="text" placeholder="Nomor Surat" value="<?= old('nomor_surat'); ?>" required>
                        </div>

                        <!-- Form Group (nik) -->
                        <div class="mb-3">
                            <label class="small mb-1" for="inputNIK">NIK</label>
                            <select class="form-control" id="nik" name="nik" required>
                                <option value="">Pilih Penduduk</option>
                            </select>
                        </div>



                        <!-- Form Group (keperluan) -->
                        <div class="mb-3">
                            <label class="small mb-1" for="inputKeperluan">Keperluan</label>
                            <input class="form-control" id="inputKeperluan" name="keperluan" type="text" placeholder="Keperluan" value="<?= old('keperluan'); ?>" required>
                        </div>

                        <?php if (auth()->user()->inGroup('superadmin')): ?>

                            <div class=" mb-3">
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

                        <!-- Submit button -->
                        <button class="btn btn-primary" type="submit">Cetak Surat</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>
<?= $this->section('script'); ?>
<script>
    $(document).ready(function() {
        $('#nik').select2({
            ajax: {
                url: '<?= base_url('admin/ajax/penduduk/search'); ?>',
                dataType: 'json',
                delay: 250,
                processResults: function(data) {
                    return {
                        results: data.map(function(item) {
                            return {
                                id: item.nik, // ID from penduduk
                                text: item.nik + ' - ' + item.nama // Display NIK and nama
                            };
                        })
                    };
                },
                cache: true
            },
            minimumInputLength: 1 // Minimum characters to trigger search
        });
    });
</script>
<?= $this->endSection(); ?>