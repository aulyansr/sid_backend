<?= $this->extend('layout/dashboard'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800 text-center">Form Konfigurasi</h1>
    <form action="<?= site_url('/admin/config/update'); ?>/<?= $config['id']; ?>" method="post" enctype="multipart/form-data">

        <?= csrf_field(); ?>
        <div class="row justify-content-center">
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-header">Logo Konfigurasi</div>
                    <div class="card-body">
                        <?php if ($config['logo']) : ?>
                            <input id="inputLogo" name="logo" type="file" class="dropify" accept="image/*" data-default-file="<?= base_url(esc($config['logo'])); ?>">
                        <?php else : ?>
                            <input id="inputLogo" name="logo" type="file" class="dropify" accept="image/*">
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="col-xl-8">
                <!-- Config details card -->
                <div class="card mb-4">
                    <div class="card-header">Detail Konfigurasi</div>
                    <div class="card-body">
                        <!-- Hidden field for config ID -->
                        <input type="hidden" name="id" value="<?= esc($config['id']); ?>">

                        <!-- Form Row -->
                        <div class="row gx-3 mb-3">
                            <!-- Form Group (desa name) -->
                            <div class="col-md-6 mb-3">
                                <label class="small mb-1" for="inputNamaDesa">Nama Desa</label>
                                <input class="form-control" id="inputNamaDesa" name="nama_desa" type="text" placeholder="Nama Desa" value="<?= old('nama_desa', $config['nama_desa']); ?>" required>
                            </div>
                            <!-- Form Group (desa code) -->
                            <div class="col-md-6 mb-3">
                                <label class="small mb-1" for="inputKodeDesa">Kode Desa</label>
                                <input class="form-control" id="inputKodeDesa" name="kode_desa" type="text" placeholder="Kode Desa" value="<?= old('kode_desa', $config['kode_desa']); ?>" required>
                            </div>
                            <!-- Form Group (kepala desa name) -->
                            <div class="col-md-6 mb-3">
                                <label class="small mb-1" for="inputNamaKepalaDesa">Nama Kepala Desa</label>
                                <input class="form-control" id="inputNamaKepalaDesa" name="nama_kepala_desa" type="text" placeholder="Nama Kepala Desa" value="<?= old('nama_kepala_desa', $config['nama_kepala_desa']); ?>">
                            </div>

                            <!-- Form Group (kepala desa NIP) -->
                            <div class="col-md-6 mb-3">
                                <label class="small mb-1" for="inputNipKepalaDesa">NIP Kepala Desa</label>
                                <input class="form-control" id="inputNipKepalaDesa" name="nip_kepala_desa" type="text" placeholder="NIP Kepala Desa" value="<?= old('nip_kepala_desa', $config['nip_kepala_desa']); ?>">
                            </div>

                            <!-- Form Group (postal code) -->
                            <div class="col-md-6 mb-3">
                                <label class="small mb-1" for="inputKodePos">Kode Pos</label>
                                <input class="form-control" id="inputKodePos" name="kode_pos" type="text" placeholder="Kode Pos" value="<?= old('kode_pos', $config['kode_pos']); ?>">
                            </div>

                            <!-- Form Group (email desa) -->
                            <div class="col-md-6 mb-3">
                                <label class="small mb-1" for="inputEmailDesa">Email Desa</label>
                                <input class="form-control" id="inputEmailDesa" name="email_desa" type="email" placeholder="Email Desa" value="<?= old('email_desa', $config['email_desa']); ?>">
                            </div>

                            <!-- Form Group (kecamatan name) -->
                            <div class="col-md-6 mb-3">
                                <label class="small mb-1" for="inputNamaKecamatan">Nama Kecamatan</label>
                                <input class="form-control" id="inputNamaKecamatan" name="nama_kecamatan" type="text" placeholder="Nama Kecamatan" value="<?= old('nama_kecamatan', $config['nama_kecamatan']); ?>">
                            </div>

                            <!-- Form Group (kecamatan code) -->
                            <div class="col-md-6 mb-3">
                                <label class="small mb-1" for="inputKodeKecamatan">Kode Kecamatan</label>
                                <input class="form-control" id="inputKodeKecamatan" name="kode_kecamatan" type="text" placeholder="Kode Kecamatan" value="<?= old('kode_kecamatan', $config['kode_kecamatan']); ?>">
                            </div>

                            <!-- Form Group (camat name) -->
                            <div class="col-md-6 mb-3">
                                <label class="small mb-1" for="inputNamaKepalaCamat">Nama Kepala Camat</label>
                                <input class="form-control" id="inputNamaKepalaCamat" name="nama_kepala_camat" type="text" placeholder="Nama Kepala Camat" value="<?= old('nama_kepala_camat', $config['nama_kepala_camat']); ?>">
                            </div>

                            <!-- Form Group (camat NIP) -->
                            <div class="col-md-6 mb-3">
                                <label class="small mb-1" for="inputNipKepalaCamat">NIP Kepala Camat</label>
                                <input class="form-control" id="inputNipKepalaCamat" name="nip_kepala_camat" type="text" placeholder="NIP Kepala Camat" value="<?= old('nip_kepala_camat', $config['nip_kepala_camat']); ?>">
                            </div>

                            <!-- Form Group (kabupaten name) -->
                            <div class="col-md-6 mb-3">
                                <label class="small mb-1" for="inputNamaKabupaten">Nama Kabupaten</label>
                                <input class="form-control" id="inputNamaKabupaten" name="nama_kabupaten" type="text" placeholder="Nama Kabupaten" value="<?= old('nama_kabupaten', $config['nama_kabupaten']); ?>">
                            </div>

                            <!-- Form Group (kabupaten code) -->
                            <div class="col-md-6 mb-3">
                                <label class="small mb-1" for="inputKodeKabupaten">Kode Kabupaten</label>
                                <input class="form-control" id="inputKodeKabupaten" name="kode_kabupaten" type="text" placeholder="Kode Kabupaten" value="<?= old('kode_kabupaten', $config['kode_kabupaten']); ?>">
                            </div>

                            <!-- Form Group (propinsi name) -->
                            <div class="col-md-6 mb-3">
                                <label class="small mb-1" for="inputNamaPropinsi">Nama Propinsi</label>
                                <input class="form-control" id="inputNamaPropinsi" name="nama_propinsi" type="text" placeholder="Nama Propinsi" value="<?= old('nama_propinsi', $config['nama_propinsi']); ?>">
                            </div>

                            <!-- Form Group (propinsi code) -->
                            <div class="col-md-6 mb-3">
                                <label class="small mb-1" for="inputKodePropinsi">Kode Propinsi</label>
                                <input class="form-control" id="inputKodePropinsi" name="kode_propinsi" type="text" placeholder="Kode Propinsi" value="<?= old('kode_propinsi', $config['kode_propinsi']); ?>">
                            </div>

                            <!-- Form Group (lat) -->
                            <div class="col-md-6 mb-3">
                                <label class="small mb-1" for="inputLat">Latitude</label>
                                <input class="form-control" id="inputLat" name="lat" type="text" placeholder="Latitude" value="<?= old('lat', $config['lat']); ?>">
                            </div>

                            <!-- Form Group (lng) -->
                            <div class="col-md-6 mb-3">
                                <label class="small mb-1" for="inputLng">Longitude</label>
                                <input class="form-control" id="inputLng" name="lng" type="text" placeholder="Longitude" value="<?= old('lng', $config['lng']); ?>">
                            </div>

                            <!-- Form Group (zoom) -->
                            <div class="col-md-6 mb-3">
                                <label class="small mb-1" for="inputZoom">Zoom</label>
                                <input class="form-control" id="inputZoom" name="zoom" type="text" placeholder="Zoom" value="<?= old('zoom', $config['zoom']); ?>">
                            </div>

                            <!-- Form Group (map type) -->
                            <div class="col-md-6 mb-3">
                                <label class="small mb-1" for="inputMapType">Map Type</label>
                                <input class="form-control" id="inputMapType" name="map_tipe" type="text" placeholder="Map Type" value="<?= old('map_tipe', $config['map_tipe']); ?>">
                            </div>

                            <!-- Form Group (path) -->
                            <div class="col-md-6 mb-3">
                                <label class="small mb-1" for="inputPath">Path</label>
                                <input class="form-control" id="inputPath" name="path" type="text" placeholder="Path" value="<?= old('path', $config['path']); ?>">
                            </div>

                            <!-- Form Group (gapi key) -->
                            <div class="col-md-6 mb-3">
                                <label class="small mb-1" for="inputGapiKey">Google API Key</label>
                                <input class="form-control" id="inputGapiKey" name="gapi_key" type="text" placeholder="Google API Key" value="<?= old('gapi_key', $config['gapi_key']); ?>">
                            </div>

                            <!-- Form Group (office address) -->
                            <div class="col-md-12 mb-3">
                                <label class="small mb-1" for="inputAlamatKantor">Alamat Kantor</label>
                                <input class="form-control" id="inputAlamatKantor" name="alamat_kantor" type="text" placeholder="Alamat Kantor" value="<?= old('alamat_kantor', $config['alamat_kantor']); ?>">
                            </div>

                            <!-- Form Group (Google Analytics) -->
                            <div class="col-md-6 mb-3">
                                <label class="small mb-1" for="inputGAnalytic">Google Analytics</label>
                                <input class="form-control" id="inputGAnalytic" name="g_analytic" type="text" placeholder="Google Analytics" value="<?= old('g_analytic', $config['g_analytic']); ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="small mb-1" for="inputGAnalytic">Google Analytics</label>
                                <input class="form-control" id="inputGAnalytic" name="regid" type="text" placeholder="Google Analytics" value="<?= old('regid', $config['regid']); ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="small mb-1" for="inputGAnalytic">Google Analytics</label>
                                <input class="form-control" id="inputGAnalytic" name="macid" type="text" placeholder="Google Analytics" value="<?= old('macid', $config['macid']); ?>">
                            </div>
                        </div>

                        <!-- Submit button -->
                        <button class="btn btn-primary" type="submit">Update Konfigurasi</button>

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
<?= $this->endSection(); ?>