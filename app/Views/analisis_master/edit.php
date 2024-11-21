<?= $this->extend('layout/dashboard'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800 text-center">
        <?                                                                      = isset($analisis) ? 'Edit Analisis Master' : 'Tambah Analisis Master'; ?>
    </h1>
    <form action = "<?= isset($analisis) ? site_url('/admin/analisis_master') : site_url('/admin/analisis_master'); ?>"
          method = "post">
          <?= csrf_field(); ?>
    <div  class  = "row justify-content-center">
         <div  class  = "col-xl-6">
                <!-- Account details card -->
                <div class="card mb-4">
                    <div class="card-header">Form Analisis Master</div>
                    <div class="card-body">
                        <!-- Hidden field for analisis ID if in edit mode -->
                        <?php if (isset($analisis)): ?>
                        <input type="hidden" name="id" value="<?= esc($analisis['id']); ?>">
                        <?php endif; ?>

                        <!-- Form Row -->
                        <div class="row gx-3 mb-3 justify-content-centers">
                            <!-- Form Group (analisis name) -->
                            <div   class       = "col-md-12 mb-3">
                            <div   class       = "form-group">
                            <label class       = "small mb-1" for  = "inputAnalisisName">Nama Analisis</label>
                            <input class       = "form-control" id = "inputAnalisisName" name = "nama" type = "text"
                                   placeholder = "Nama Analisis"
                                   value       = "<?= old('nama', isset($analisis) ? $analisis['nama'] : ''); ?>" required>
                                </div>
                            </div>
                            <!-- Form Group (description) -->
                            <div class="col-md-12 mb-3">
                                <label class="small mb-1" for="inputDescription">Deskripsi</label>
                                <textarea class="form-control" id="inputDescription" name="deskripsi"
                                    placeholder="Deskripsi">
                                    <?= old('deskripsi', isset($analisis) ? $analisis['deskripsi'] : ''); ?>
                                </textarea>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="small mb-1" for="inputchild">Analisis Terhubung</label>
                                <select class="form-control" id="inputchild" name="id_child">
                                    <?php   foreach ($children as $child)                                                     : ?>
                                    <option value="<?= esc($child['id']); ?>"
                                        <?= old('id_child') == $child['id'] ? 'selected': ''; ?>>
                                        <?= esc($child['nama']); ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>

                                <small> *) Kosongi jika tida ada analisis terhubung.</small>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="small mb-1" for="lock">Status Analisis</label>
                                <br>
                                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                    <?php foreach ($lockOptions as $value => $label) : ?>
                                    <label class="btn btn-sm btn-outline-primary">
                                        <input type="radio" name="lock" value="<?= esc($value); ?>"
                                            id="lock_<?= esc($value); ?>"
                                            <?= (old('lock', isset($analisis) ? $analisis['lock'] : '') == $value) ? 'checked' : ''; ?>>
                                        <?= esc($label); ?>
                                    </label>
                                    <?php endforeach; ?>
                                </div>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="small mb-1" for="subject">Subjek/Unit Analisis</label>
                                <br>
                                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                    <?php foreach ($subjects as $value => $label) : ?>
                                    <!-- Corrected to use $subjects directly -->
                                    <label class="btn btn-sm btn-outline-primary">
                                        <input type="radio" name="subjek_tipe" value="<?= esc($value); ?>"
                                            id="subject_tipe_<?= esc($value); ?>"
                                            <?= (old('subjek_tipe', isset($analisis) ? $analisis['subjek_tipe'] : '') == $value) ? 'checked' : ''; ?>>
                                        <?= esc($label); ?>
                                    </label>
                                    <?php endforeach; ?>
                                </div>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="small mb-1" for="prelist">Fitur Prelist</label>
                                <br>
                                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                    <?php foreach ($prelist as $value => $label) : ?>
                                    <!-- Use the $prelist array -->
                                    <label class="btn btn-sm btn-outline-primary">
                                        <input type="radio" name="fitur_prelist" value="<?= esc($value); ?>"
                                            id="prelist_<?= esc($value); ?>"
                                            <?= (old('fitur_prelist', isset($analisis) ? $analisis['fitur_prelist'] : '') == $value) ? 'checked' : ''; ?>>
                                        <?= esc($label); ?>
                                    </label>
                                    <?php endforeach; ?>
                                </div>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="small mb-1" for="fitur_pembobotan">Fitur Pembobotan</label>
                                <br>
                                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                    <?php foreach ($fitur_pembobotan as $value => $label) : ?>
                                    <!-- Use the $fitur_pembobotan array -->
                                    <label class="btn btn-sm btn-outline-primary">
                                        <input type="radio" name="fitur_pembobotan" value="<?= esc($value); ?>"
                                            id="fitur_pembobotan_<?= esc($value); ?>"
                                            <?= (old('fitur_pembobotan', isset($analisis) ? $analisis['fitur_pembobotan'] : '') == $value) ? 'checked' : ''; ?>>
                                        <?= esc($label); ?>
                                    </label>
                                    <?php endforeach; ?>
                                </div>
                            </div>


                            <div class="col-12 mb-3">
                                <hr class="w-100">
                                <p><b>Rumus Penilaian Analisis</b> <br>
                                    Sigma [Bobot (indikator) x Nilai (ukuran)] / "Bilangan Pembagi"</p>
                                <div class="form-group mb-3">
                                    <label class="small mb-2" for="inputpembagi">Bilangan Pembagi</label>
                                    <input class="form-control" id="inputpembagi" name="pembagi" type="text"
                                        value="<?= old('pembagi', isset($analisis) ? $analisis['pembagi'] : ''); ?>"
                                        required>
                                </div>
                                <p>*) untuk tanda koma "," gunakan tanda titik "." sebagai substitusinya.</p>
                                <hr class="w-100">
                            </div>




                            <hr>

                        </div>
                        <!-- Submit button -->
                        <button class="btn btn-primary"
                            type="submit"><?= isset($analisis) ? 'Update Analisis' : 'Tambah Analisis'; ?></button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<?= $this->endSection(); ?>


<?= $this->section('script'); ?>
<!-- TinyMCE CDN -->
<script src="/assets/js/admin/vendors/tinymce/js/tinymce/tinymce.min.js" referrerpolicy="origin"></script>

<script>
    tinymce.init({
        selector: 'textarea#inputDescription',
        plugins: 'lists, link, image, media',
        toolbar: 'h1 h2 bold italic strikethrough blockquote bullist numlist backcolor | link image media | removeformat help',
        menubar: false,
    });
</script>
<?= $this->endSection(); ?>