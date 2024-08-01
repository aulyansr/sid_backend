<?= $this->extend('layout/dashboard'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800 text-center"><?= isset($artikel) ? 'Update Artikel' : 'Form Artikel'; ?></h1>
    <form action="<?= isset($artikel) ? '/admin/artikel/update/' . esc($artikel['id']) : '/admin/artikel/store'; ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field(); ?>
        <div class="row justify-content-center">
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-header">Foto Artikel</div>
                    <div class="card-body">
                        <input id="inputGambar" name="gambar" type="file" class="dropify" accept="image/*" data-default-file="<?= base_url(esc($artikel['gambar'])) ?>">
                        <!-- Additional images -->
                        <div class="my-3">
                            <div class="mb-4">
                                <input id="inputGambar1" name="gambar1" type="file" class="dropify" accept="image/*" data-default-file="<?= isset($artikel['gambar1']) ? base_url(esc($artikel['gambar1'])) : ''; ?>">
                            </div>
                            <div class="mb-4">
                                <input id="inputGambar2" name="gambar2" type="file" class="dropify" accept="image/*" data-default-file="<?= isset($artikel['gambar2']) ? base_url(esc($artikel['gambar2'])) : ''; ?>">
                            </div>
                            <div class="mb-4">
                                <input id="inputGambar3" name="gambar3" type="file" class="dropify" accept="image/*" data-default-file="<?= isset($artikel['gambar3']) ? base_url(esc($artikel['gambar3'])) : ''; ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-8">
                <div class="card mb-4">
                    <div class="card-header">Detail Artikel</div>
                    <div class="card-body">
                        <div class="row gx-3 mb-3">
                            <!-- Form Group (judul) -->
                            <div class="col-md-12 mb-3">
                                <label class="small mb-1" for="inputJudul">Judul Artikel</label>
                                <input class="form-control" id="inputJudul" name="judul" type="text" placeholder="Judul Artikel" value="<?= esc($artikel['judul'] ?? old('judul')); ?>" required>
                            </div>
                            <!-- Form Group (isi) -->
                            <div class="col-md-12 mb-3">
                                <label class="small mb-1" for="inputIsi">Isi Artikel</label>
                                <textarea class="form-control" id="editor" name="isi" rows="4" placeholder="Isi Artikel"><?= esc($artikel['isi'] ?? old('isi')); ?></textarea>
                            </div>
                            <!-- Form Group (kategori) -->
                            <div class="col-md-6 mb-3">
                                <label class="small mb-1" for="inputKategori">Kategori</label>
                                <select class="form-control" id="inputKategori" name="id_kategori" required>
                                    <?php foreach ($kategoris as $kategori) : ?>
                                        <option value="<?= esc($kategori['id']); ?>" <?= (isset($artikel) && $artikel['id_kategori'] == $kategori['id']) ? 'selected' : ''; ?>>
                                            <?= esc($kategori['kategori']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <!-- Form Group (headline) -->
                            <div class="col-md-6 mb-3">
                                <label class="small mb-1" for="inputHeadline">Headline</label>
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="inputHeadline" name="headline" value="1" <?= (isset($artikel['headline']) && $artikel['headline'] == 1) ? 'checked' : ''; ?>>
                                    <label class="custom-control-label" for="inputHeadline">
                                        Set Sebagai Headline
                                    </label>
                                </div>
                            </div>


                            <!-- Form Group (dokumen) -->
                            <div class="col-md-6 mb-3">
                                <label class="small mb-1" for="inputDokumen">Dokumen</label>
                                <input class="form-control" id="inputDokumen" name="dokumen" type="text" placeholder="Dokumen" value="<?= esc($artikel['dokumen'] ?? old('dokumen')); ?>">
                            </div>
                            <!-- Form Group (link_dokumen) -->
                            <div class="col-md-6 mb-3">
                                <label class="small mb-1" for="inputLinkDokumen">Link Dokumen</label>
                                <input class="form-control" id="inputLinkDokumen" name="link_dokumen" type="text" placeholder="Link Dokumen" value="<?= esc($artikel['link_dokumen'] ?? old('link_dokumen')); ?>">
                            </div>
                            <!-- Form Group (enabled) -->
                            <div class="col-md-6 mb-3">
                                <label class="small mb-1" for="inputEnabled">Enabled</label>
                                <select class="form-control" id="inputEnabled" name="enabled" required>
                                    <option value="1" <?= (isset($artikel) && $artikel['enabled'] == '1') ? 'selected' : ''; ?>>Yes</option>
                                    <option value="0" <?= (isset($artikel) && $artikel['enabled'] == '0') ? 'selected' : ''; ?>>No</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="small mb-1" for="tgl_upload">Tanggal Publish</label>
                                <input class="form-control" id="tgl_upload" name="tgl_upload" type="date" value="<?= esc(isset($artikel['tgl_upload']) ? strftime('%Y-%m-%d', strtotime($artikel['tgl_upload'])) : date('Y-m-d')); ?>">



                            </div>
                        </div>
                        <!-- Submit button -->
                        <input type="hidden" name="id_user" value="<?= auth()->user()->id; ?>">
                        <button class="btn btn-primary" type="submit">Simpan Artikel</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script>
    $('.dropify').dropify();
</script>
<!-- TinyMCE CDN -->
<script src="/assets/js/admin/vendor/tinymce/js/tinymce/tinymce.min.js" referrerpolicy="origin"></script>

<script>
    tinymce.init({
        selector: 'textarea#editor',
        plugins: 'lists link image media',
        toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
        menubar: false,
    });
</script>
<?= $this->endSection(); ?>