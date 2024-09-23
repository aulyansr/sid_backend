<?= $this->extend('layout/dashboard'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800 text-center">Form RW</h1>

    <div class="card">

        <div class="card-body">
            <form action="<?= base_url('admin/wilayah') ?>" method="post">
                <input type="hidden" name="parent" value="<?= $cluster['id']; ?>">
                <div class="card-header">Detail Wilayah</div>
                <div class="card-body">
                    <!-- Form Row -->
                    <div class="row gx-3 mb-3">
                        <!-- Form Group (full name) -->

                        <div class="col-md-6 mb-3">
                            <label class="small mb-1" for="inputNama">Nama Rw</label>
                            <input class="form-control" id="inputNama" name="rw" type="text" placeholder="Nama Wilayah" value="<?= old('pamong_nama', isset($pamong) ? esc($pamong['pamong_nama']) : ''); ?>" required>
                        </div>

                        <!-- Form Group (NIP) -->
                        <div class="col-md-6 mb-3">
                            <label class="small mb-1" for="id_kepala">NIK / Nama Kepala RW</label>
                            <select class="form-control" id="id_kepala" name="id_kepala" required>
                                <option value="">Pilih Kepala</option>
                            </select>
                        </div>
                    </div>

                    <!-- Submit button -->
                    <button class="btn btn-primary" type="submit"><?= isset($pamong) ? 'Update Pengurus' : 'Create Pengurus'; ?></button>
                </div>

            </form>

        </div>
    </div>


</div>
<?= $this->endSection(); ?>
<?= $this->section('script'); ?>
<script>
    $(document).ready(function() {
        $('#id_kepala').select2({
            ajax: {
                url: '<?= base_url('admin/ajax/pamong/search'); ?>',
                dataType: 'json',
                delay: 250,
                processResults: function(data) {
                    return {
                        results: data.map(function(item) {
                            return {
                                id: item.pamong_id, // ID from desa_pamong
                                text: item.pamong_nip + ' - ' + item.pamong_nama // Display NIK and nama
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