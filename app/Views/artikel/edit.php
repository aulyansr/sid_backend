<?= $this->extend('layout/dashboard'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800 text-center"><?= isset($artikel) ? 'Update Artikel' : 'Form Artikel'; ?></h1>
    <form action="<?= site_url(isset($artikel) ? '/admin/artikel/update/' . $artikel['id'] : '/admin/artikel/store'); ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field(); ?>
        <div class="row justify-content-center">
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-header">Foto Artikel</div>
                    <div class="card-body">

                        <input id="inputGambar" name="gambar" type="file" class="dropify" accept="image/*" data-default-file="<?= base_url(esc($artikel['gambar'])); ?>">
                        <!-- Additional images -->
                        <div class="my-3">
                            <?php if (isset($artikel)) : ?>
                                <?php if ($artikel['gambar1']) : ?>
                                    <img src="/<?= esc($artikel['gambar1']); ?>" alt="Current Gambar 1" width="100">
                                <?php endif; ?>
                                <input id="inputGambar1" name="gambar1" type="file" class="dropify" accept="image/*">

                                <?php if ($artikel['gambar2']) : ?>
                                    <img src="/<?= esc($artikel['gambar2']); ?>" alt="Current Gambar 2" width="100">
                                <?php endif; ?>
                                <input id="inputGambar2" name="gambar2" type="file" class="dropify" accept="image/*">

                                <?php if ($artikel['gambar3']) : ?>
                                    <img src="/<?= esc($artikel['gambar3']); ?>" alt="Current Gambar 3" width="100">
                                <?php endif; ?>
                                <input id="inputGambar3" name="gambar3" type="file" class="dropify" accept="image/*">
                            <?php else : ?>
                                <label class="small mb-1" for="inputGambar1">Gambar 1</label>
                                <input id="inputGambar1" name="gambar1" type="file" class="dropify" accept="image/*">
                                <label class="small mb-1" for="inputGambar2">Gambar 2</label>
                                <input id="inputGambar2" name="gambar2" type="file" class="dropify" accept="image/*">
                                <label class="small mb-1" for="inputGambar3">Gambar 3</label>
                                <input id="inputGambar3" name="gambar3" type="file" class="dropify" accept="image/*">
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-8">
                <div class="card mb-4">
                    <div class="card-header">Detail Artikel</div>
                    <div class="card-body">
                        <!-- Form Row -->
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
                                <input class="form-control" id="inputHeadline" name="headline" type="number" placeholder="Headline" value="<?= esc($artikel['headline'] ?? old('headline')); ?>">
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
                                <input class="form-control" id="tgl_upload" name="tgl_upload" type="date" value="<?= esc($artikel['tgl_upload'] ?? old('tgl_upload')); ?>">
                            </div>
                        </div>

                        <!-- Submit button -->
                        <input type="hidden" name="id_user" value="<?= auth()->user()->id; ?>"> <!-- Hidden field for user ID -->
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
        plugins: 'lists, link, image, media',
        toolbar: 'h1 h2 bold italic strikethrough blockquote bullist numlist backcolor | link image media | removeformat help',
        menubar: false,
    });
</script>
<?= $this->endSection(); ?>