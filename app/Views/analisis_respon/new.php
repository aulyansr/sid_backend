<?= $this->extend('layout/dashboard'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800 text-center">Form Pendataan
        <?= esc($analisis_master['nama']); ?>
    </h1>
    <form action="<?= site_url('/admin/analisis-respon'); ?>" method="post">
        <?= csrf_field(); ?>
        <input type="hidden" name="id_master" value="<?= esc($id_master); ?>">
        <input type="hidden" name="id_subject" value="<?= esc($subject); ?>">
        <input type="hidden" name="id_periode" value="<?= esc($periode['id']); ?>">

        <div class="row justify-content-center">
            <div class="col-xl-9">
                <div class="card mb-4">
                    <div class="card-header">Form Pendataan
                        <?= esc($analisis_master['nama']); ?>
                    </div>
                    <div class="card-body">
                        <div class="row my-3 justify-content-center">
                            <?php foreach ($analisisCategories as $category): ?>
                                <div class="col-md-12">
                                    <h2 class="mt-3 mb-3">
                                        <?= esc($category['kategori']); ?>
                                    </h2>
                                    <hr style="border: 1px solid #e6e6e6">
                                </div>
                                <?php
                                $indikator_items = $indikators->where('id_kategori', $category['id'])->findAll();
                                ?>

                                <?php foreach ($indikator_items as $indikator): ?>
                                    <div class="col-md-12">
                                        <div class="d-block pb-2 pt-2" style="border-bottom:1px solid">
                                            <div class="row g-3 align-items-center">
                                                <div class="col-6">
                                                    <div class="d-flex align-items-start">
                                                        <div class="mr-2">
                                                            <h5>
                                                                <?= esc($indikator['nomor']); ?>
                                                            </h5>
                                                        </div>
                                                        <h5>
                                                            <?= esc($indikator['pertanyaan']); ?>
                                                        </h5>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <?php if ($indikator['id_tipe'] == 1): ?>
                                                        <input class="form-control mb-2" name="id_indikator[]"
                                                            value="<?= esc($indikator['id']); ?>" type="hidden">
                                                        <select class="form-control parameterSelect" id="inputRW<?= esc($indikator['id']); ?>"
                                                            name="parameter[<?= esc($indikator['id']); ?>]" required>
                                                            <option value="">Pilih Jawaban</option>
                                                            <?php
                                                            $parameter_items = $parameters->where('id_indikator', $indikator['id'])->findAll();
                                                            ?>
                                                            <?php foreach ($parameter_items as $parameter): ?>
                                                                <option value="<?= esc($parameter['id']); ?>" data-nilai="<?= $parameter['nilai']; ?>">
                                                                    <?= esc($parameter['jawaban']); ?>
                                                                </option>
                                                            <?php endforeach; ?>

                                                        </select>
                                                    <?php endif; ?>

                                                    <?php if ($indikator['id_tipe'] == 2): ?>
                                                        <input type="hidden" class="form-control mb-2" name="id_indikator[]"
                                                            value="<?= esc($indikator['id']); ?>" required>

                                                        <div class="form-group">
                                                            <?php
                                                            $parameter_items = $parameters->where('id_indikator', $indikator['id'])->findAll();
                                                            ?>
                                                            <?php foreach ($parameter_items as $parameter): ?>
                                                                <div class="form-check">
                                                                    <input type="checkbox" class="form-check-input parameterCheckbox"
                                                                        id="parameter<?= esc($parameter['id']); ?>"
                                                                        name="parameter[<?= esc($indikator['id']); ?>][]"
                                                                        value="<?= esc($parameter['id']); ?>"

                                                                        data-nilai="<?= esc($parameter['nilai'])  ?>"
                                                                        data-id="<?= esc($parameter['id']); ?>"
                                                                        onchange="updateTotalScore()">
                                                                    <label class="form-check-label" for="parameter<?= esc($parameter['id']); ?>">
                                                                        <?= esc($parameter['jawaban']); ?>
                                                                    </label>
                                                                </div>
                                                            <?php endforeach; ?>

                                                        </div>
                                                    <?php endif; ?>
                                                    <?php if ($indikator['id_tipe'] == 3): ?>
                                                        <input class="form-control" id="jawaban" name="jawaban" type="number">
                                                    <?php endif; ?>
                                                    <?php if ($indikator['id_tipe'] == 4): ?>
                                                        <input class="form-control" id="jawaban" name="jawaban" type="text">
                                                    <?php endif; ?>
                                                    <?php if ($indikator['id_tipe'] == 5): ?>
                                                        <input class="form-control" id="jawaban" name="jawaban" type="date">
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endforeach; ?>
                        </div>

                        <input id="total_score" name="total_score" class="form-control" value="0" readonly type="hidden">
                        <button class="btn btn-primary" type="submit">
                            <?= isset($analisisRespon) ? 'Update Klasifikasi' : 'Tambah Klasifikasi'; ?>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Function to update the total score
        function updateTotalScore() {
            let totalScore = 0;

            // Loop through each select element and add the selected value's 'data-nilai'
            document.querySelectorAll('select[id^="inputRW"]').forEach(function(selectElement) {
                var selectedOption = selectElement.options[selectElement.selectedIndex];
                var nilai = selectedOption.getAttribute('data-nilai');
                if (nilai) {
                    totalScore += parseInt(nilai, 10); // Add the nilai value to the total score
                }
            });

            // Loop through each checkbox and add the 'data-nilai' of checked boxes
            document.querySelectorAll('.parameterCheckbox:checked').forEach(function(checkbox) {
                var nilai = checkbox.getAttribute('data-nilai');
                if (nilai) {
                    totalScore += parseInt(nilai, 10); // Add the nilai value to the total score
                }
            });

            // Update the total score input field
            document.getElementById('total_score').value = totalScore;
        }

        // Attach event listeners to select elements
        document.querySelectorAll('select[id^="inputRW"]').forEach(function(selectElement) {
            selectElement.addEventListener('change', updateTotalScore);
        });

        // Attach event listeners to checkboxes
        document.querySelectorAll('.parameterCheckbox').forEach(function(checkbox) {
            checkbox.addEventListener('change', updateTotalScore);
        });

        // Initial call to update the total score in case any defaults are already selected
        updateTotalScore();
    });
</script>
<?= $this->endSection(); ?>
