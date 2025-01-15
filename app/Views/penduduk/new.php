<?= $this->extend('layout/dashboard'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800 text-center">Form Penduduk</h1>
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card">

                <div class="card-body">
                    <form action="<?= isset($penduduk) ? base_url('admin/penduduk/' . $penduduk['id']) : base_url('admin/penduduk') ?>" method="post">

                        <div class="card-header">Detail Penduduk</div>
                        <div class="card-body">
                            <!-- Form Row -->
                            <div class="row gx-3 mb-3">
                                <!-- Form Group (Nama) -->
                                <div class="col-md-12 mb-3">
                                    <label class="small mb-1" for="inputNama">Nama Lengkap</label>
                                    <input class="form-control" id="inputNama" name="nama" type="text" placeholder="Nama Lengkap" value="<?= old('penduduk_nama', isset($penduduk) ? esc($penduduk['penduduk_nama']) : ''); ?>" required>
                                </div>

                                <!-- Form Group (NIK) -->
                                <div class="col-md-12 mb-3">
                                    <label class="small mb-1" for="inputNIK">NIK</label>
                                    <input class="form-control" id="inputNIK" name="nik" type="text" placeholder="NIK" value="<?= old('penduduk_nik', isset($penduduk) ? esc($penduduk['penduduk_nik']) : ''); ?>" required>
                                </div>



                                <!-- Form Group (Nomor RTS) -->
                                <div class="col-md-12 mb-3">
                                    <label class="small mb-1" for="inputRTS">Akta Kelahiran</label>
                                    <input class="form-control" id="inputRTS" name="akta_lahir" type="text" placeholder="Nomor Akta Kelahiran" value="<?= old('penduduk_rts', isset($penduduk) ? esc($penduduk['penduduk_rts']) : ''); ?>">
                                </div>

                                <!-- Form Group (Gender) -->

                                <div class="col-md-12 mb-3">
                                    <label class="small mb-1 d-block">Jenis Kelamin</label>
                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                        <?php foreach ($sexList as $sex): ?>
                                            <label class="btn btn-outline-primary <?= old('sex', isset($penduduk) ? esc($penduduk['sex']) : '') == $sex['nama'] ? 'active' : ''; ?>">
                                                <input type="radio" name="sex" value="<?= esc($sex['id']); ?>" <?= old('sex', isset($penduduk) ? esc($penduduk['sex']) : '') == $sex['nama'] ? 'checked' : ''; ?>>
                                                <?= ($sex['nama']); ?>
                                            </label>
                                        <?php endforeach; ?>
                                    </div>
                                </div>


                                <div class="col-md-6 mb-3">
                                    <label class="small mb-1" for="tempatlahir">Tempat Lahir</label>
                                    <input class="form-control" id="tempatlahir" name="tempatlahir" type="text" placeholder="Tempat Lahir" value="<?= old('tempatlahir', isset($penduduk) ? esc($penduduk['tempatlahir']) : ''); ?>" required>
                                </div>

                                <!-- Form Group (Tanggal Lahir) -->
                                <div class="col-md-6 mb-3">
                                    <label class="small mb-1" for="inputTglLahir">Tanggal Lahir</label>
                                    <input class="form-control" id="inputTglLahir" name="tanggallahir" type="date" value="<?= old('tanggallahir', isset($penduduk) ? esc($penduduk['tanggallahir']) : ''); ?>" required>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label class="small mb-1" for="inputAgama">Agama</label>
                                    <select class="form-control select2" id="inputAgama" name="agama_id">
                                        <option value="">Pilih Agama</option>
                                        <?php foreach ($agamaList as $agama): ?>
                                            <option value="<?= esc($agama['id']); ?>" <?= (old('agama_id', isset($penduduk) ? esc($penduduk['agama_id']) : '') == esc($agama['id'])) ? 'selected' : ''; ?>>
                                                <?= esc($agama['nama']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label class="small mb-1" for="inputPendidikan">Pendidikan dalam KK</label>
                                    <select class="form-control select2" id="inputPendidikan" name="pendidikan_kk_id">
                                        <option value="">Pilih Pendidikan</option>
                                        <?php foreach ($pendidikanList as $pendidikan): ?>
                                            <option value="<?= esc($pendidikan['id']); ?>" <?= (old('pendidikan_kk_id', isset($penduduk) ? esc($penduduk['pendidikan_kk_id']) : '') == esc($pendidikan['id'])) ? 'selected' : ''; ?>>
                                                <?= esc($pendidikan['nama']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label class="small mb-1" for="inputPendidikan">Pendidikan sedang ditempuh</label>
                                    <select class="form-control select2" id="inputPendidikan" name="pendidikan_sedang_id">
                                        <option value="">Pilih Pendidikan</option>
                                        <?php foreach ($pendidikanList as $pendidikan): ?>
                                            <option value="<?= esc($pendidikan['id']); ?>" <?= (old('pendidikan_sedang_id', isset($penduduk) ? esc($penduduk['pendidikan_sedang_id']) : '') == esc($pendidikan['id'])) ? 'selected' : ''; ?>>
                                                <?= esc($pendidikan['nama']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label class="small mb-1" for="inputpekerjaan_id">Pekerjaan</label>
                                    <select class="form-control select2" id="inputpekerjaan_id" name="pekerjaan_id">
                                        <option value="">Pilih Pekerjaan</option>
                                        <?php foreach ($pekerjaanList as $pekerjaan): ?>
                                            <option value="<?= esc($pekerjaan['id']); ?>" <?= (old('pekerjaan_id', isset($penduduk) ? esc($penduduk['pekerjaan_id']) : '') == esc($pekerjaan['id'])) ? 'selected' : ''; ?>>
                                                <?= esc($pekerjaan['nama']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label class="small mb-1" for="inputstatus_kawin">Status Kawin</label>
                                    <select class="form-control select2" id="inputstatus_kawin" name="status_kawin">
                                        <option value="">Pilih Status Kawin</option>
                                        <?php foreach ($kawinList as $kawin): ?>
                                            <option value="<?= esc($kawin['id']); ?>" <?= (old('kawin_id', isset($penduduk) ? esc($penduduk['kawin_id']) : '') == esc($kawin['id'])) ? 'selected' : ''; ?>>
                                                <?= esc($kawin['nama']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label class="small mb-1" for="inputHubungan">Hubungan dalam Keluarga</label>
                                    <select class="form-control select2" id="inputHubungan" name="kk_level">
                                        <option value="">Pilih Hubungan</option>
                                        <?php foreach ($hubunganList as $hubungan): ?>
                                            <option value="<?= esc($hubungan['id']); ?>" <?= (old('kk_level', isset($penduduk) ? esc($penduduk['kk_level']) : '') == esc($hubungan['id'])) ? 'selected' : ''; ?>>
                                                <?= esc($hubungan['nama']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <!-- Form Group (Warganegara) -->
                                <div class="col-md-12 mb-3">
                                    <label class="small mb-1" for="inputWarganegara">Warganegara</label>
                                    <select class="form-control select2" id="inputWarganegara" name="warganegara_id">
                                        <option value="">Pilih Warga Negara</option>
                                        <?php foreach ($warganegaraList as $warganegara): ?>
                                            <option value="<?= esc($warganegara['id']); ?>" <?= (old('warganegara_id', isset($penduduk) ? esc($penduduk['warganegara_id']) : '') == esc($warganegara['id'])) ? 'selected' : ''; ?>>
                                                <?= esc($warganegara['nama']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <!-- Form Group (Dokumen Paspor) -->
                                <div class="col-md-12 mb-3">
                                    <label class="small mb-1" for="inputPaspor">Dokumen Paspor</label>
                                    <input class="form-control" id="inputPaspor" name="dokumen_pasport" type="text" placeholder="Dokumen Paspor" value="<?= old('dokumen_paspor', isset($penduduk) ? esc($penduduk['dokumen_paspor']) : ''); ?>">
                                </div>

                                <!-- Form Group (Dokumen KITAS) -->
                                <div class="col-md-12 mb-3">
                                    <label class="small mb-1" for="inputKitas">Dokumen KITAS</label>
                                    <input class="form-control" id="inputKitas" name="dokumen_kitas" type="text" placeholder="Dokumen KITAS" value="<?= old('dokumen_kitas', isset($penduduk) ? esc($penduduk['dokumen_kitas']) : ''); ?>">
                                </div>

                                <!-- Form Group (NIK Ayah) -->
                                <div class="col-md-12 mb-3">
                                    <label class="small mb-1" for="inputNikAyah">NIK Ayah</label>
                                    <input class="form-control" id="inputNikAyah" name="ayah_nik" type="text" placeholder="NIK Ayah" value="<?= old('nik_ayah', isset($penduduk) ? esc($penduduk['nik_ayah']) : ''); ?>">
                                </div>

                                <!-- Form Group (Nama Ayah) -->
                                <div class="col-md-12 mb-3">
                                    <label class="small mb-1" for="inputNamaAyah">Nama Ayah</label>
                                    <input class="form-control" id="inputNamaAyah" name="nama_ayah" type="text" placeholder="Nama Ayah" value="<?= old('nama_ayah', isset($penduduk) ? esc($penduduk['nama_ayah']) : ''); ?>">
                                </div>

                                <!-- Form Group (NIK Ibu) -->
                                <div class="col-md-12 mb-3">
                                    <label class="small mb-1" for="inputNikIbu">NIK Ibu</label>
                                    <input class="form-control" id="inputNikIbu" name="ibu_nik" type="text" placeholder="NIK Ibu" value="<?= old('nik_ibu', isset($penduduk) ? esc($penduduk['nik_ibu']) : ''); ?>">
                                </div>


                                <!-- Form Group (Nama Ibu) -->
                                <div class="col-md-12 mb-3">
                                    <label class="small mb-1" for="inputNamaIbu">Nama Ibu</label>
                                    <input class="form-control" id="inputNamaIbu" name="nama_ibu" type="text" placeholder="Nama Ibu" value="<?= old('nama_ibu', isset($penduduk) ? esc($penduduk['nama_ibu']) : ''); ?>">
                                </div>



                                <!-- Form Group (Status) -->
                                <div class="col-md-12 mb-3">
                                    <label class="small mb-1 d-block" for="inputStatus">Status</label>
                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                        <?php foreach ($statusList as $status): ?>
                                            <label class="btn btn-outline-primary <?= old('sex', isset($penduduk) ? esc($penduduk['status']) : '') == $status['nama'] ? 'active' : ''; ?>">
                                                <input type="radio" name="status" value="<?= esc($status['id']); ?>" <?= old('status', isset($penduduk) ? esc($penduduk['status']) : '') == $status['nama'] ? 'checked' : ''; ?>>
                                                <?= $status['nama'] ?>
                                            </label>
                                        <?php endforeach; ?>
                                    </div>
                                </div>

                                <!-- Form Group (Alamat Sebelumnya) -->
                                <div class="col-md-12 mb-3">
                                    <label class="small mb-1" for="inputAlamatSebelumnya">Alamat Sebelumnya</label>
                                    <input class="form-control" id="inputAlamatSebelumnya" name="alamat_sebelumnya" type="text" placeholder="Alamat Sebelumnya" value="<?= old('alamat_sebelumnya', isset($penduduk) ? esc($penduduk['alamat_sebelumnya']) : ''); ?>">
                                </div>

                                <!-- Form Group (Alamat Sekarang) -->
                                <div class="col-md-12 mb-3">
                                    <label class="small mb-1" for="inputAlamatSekarang">Alamat Sekarang</label>
                                    <input class="form-control" id="inputAlamatSekarang" name="alamat_sekarang" type="text" placeholder="Alamat Sekarang" value="<?= old('alamat_sekarang', isset($penduduk) ? esc($penduduk['alamat_sekarang']) : ''); ?>">
                                </div>

                                <!-- Form Group (Cacat) -->
                                <div class="col-md-12 mb-3">
                                    <label class="small mb-1" for="inputCacat">Cacat</label>

                                    <select class="form-control select2" id="inputPendidikan" name="cacat_id">
                                        <option value="">Pilih </option>
                                        <?php foreach ($cacatList as $cacat): ?>
                                            <option value="<?= esc($cacat['id']); ?>" <?= (old('cacat_id', isset($penduduk) ? esc($penduduk['cacat_id']) : '') == esc($cacat['id'])) ? 'selected' : ''; ?>>
                                                <?= esc($cacat['nama']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>

                                </div>

                                <div class="col-md-12 mb-3">
                                    <label class="small mb-1 d-block">Status Kehamilan</label>
                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">

                                        <label class="btn btn-outline-primary <?= old('hamil', isset($penduduk) ? esc($penduduk['hamil']) : 'Tidak Hamil') == 'Tidak Hamil' ? 'active' : ''; ?>">
                                            <input type="radio" name="hamil" value="1" <?= old('hamil', isset($penduduk) ? esc($penduduk['hamil']) : 'Tidak Hamil') == 'Tidak Hamil' ? 'checked' : ''; ?>>
                                            Tidak Hamil
                                        </label>

                                        <label class="btn btn-outline-primary <?= old('hamil', isset($penduduk) ? esc($penduduk['hamil']) : 'Tidak Hamil') == 'Hamil' ? 'active' : ''; ?>">
                                            <input type="radio" name="hamil" value="2" <?= old('hamil', isset($penduduk) ? esc($penduduk['hamil']) : 'Tidak Hamil') == 'Hamil' ? 'checked' : ''; ?>>
                                            Hamil
                                        </label>

                                    </div>
                                </div>




                                <!-- Form Group (Lokasi Penduduk) -->
                                <div class="col-md-12 mb-3">
                                    <label class="small mb-1" for="inputLokasiPenduduk">Lokasi Penduduk</label>
                                    <input class="form-control" id="inputLokasiPenduduk" name="lokasi_penduduk" type="text" placeholder="Lokasi Penduduk" value="<?= old('lokasi_penduduk', isset($penduduk) ? esc($penduduk['lokasi_penduduk']) : ''); ?>">
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


                                <!-- Form Group (Dusun) -->
                                <div class="col-md-12 mb-3">
                                    <label class="small mb-1" for="inputDusun">Dusun</label>
                                    <select class="form-control" id="inputDusun" name="penduduk_dusun" required>
                                        <option value="">Pilih Dusun</option>
                                        <?php foreach ($dusunList as $dusun): ?>
                                            <option value="<?= esc($dusun['id']); ?>">
                                                <?= esc($dusun['dusun']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <!-- Form Group (RW) -->
                                <div class="col-md-12 mb-3">
                                    <label class="small mb-1" for="inputRW">RW</label>
                                    <select class="form-control" id="inputRW" name="penduduk_rw" required disabled>
                                        <option value="">Pilih RW</option>
                                    </select>
                                </div>

                                <!-- Form Group (RT) -->
                                <div class="col-md-12 mb-3">
                                    <label class="small mb-1" for="inputRT">RT</label>
                                    <select class="form-control" id="inputRT" name="id_cluster" required disabled>
                                        <option value="">Pilih RT</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Submit button -->
                            <button class="btn btn-primary" type="submit"><?= isset($penduduk) ? 'Update Penduduk' : 'Tambah Penduduk'; ?></button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>


</div>
<?= $this->endSection(); ?>
<?= $this->section('script'); ?>
<script>
    $('.dropify').dropify();
</script>

<script>
    document.getElementById('inputDusun').addEventListener('change', function() {
        const dusunId = this.value;
        const rwSelect = document.getElementById('inputRW');
        const rtSelect = document.getElementById('inputRT');

        // Clear existing options
        rwSelect.innerHTML = '<option value="">Pilih RW</option>';
        rtSelect.innerHTML = '<option value="">Pilih RT</option>';
        rtSelect.disabled = true; // Disable RT until RW is selected

        if (dusunId) {
            fetch(`/admin/ajax/getRW/${dusunId}`)
                .then(response => response.json())
                .then(data => {
                    data.forEach(rw => {
                        rwSelect.innerHTML += `<option value="${rw.id}">${rw.rw}</option>`;
                    });
                    rwSelect.disabled = false; // Enable RW select
                });
        } else {
            rwSelect.disabled = true; // Disable RW if no Dusun is selected
        }
    });

    document.getElementById('inputRW').addEventListener('change', function() {
        const rwId = this.value;
        const rtSelect = document.getElementById('inputRT');

        // Clear existing options
        rtSelect.innerHTML = '<option value="">Pilih RT</option>';
        rtSelect.disabled = true; // Disable RT until RW is selected

        if (rwId) {
            fetch(`/admin/ajax/getRT/${rwId}`)
                .then(response => response.json())
                .then(data => {
                    data.forEach(rt => {
                        rtSelect.innerHTML += `<option value="${rt.id}">${rt.rt}</option>`;
                    });
                    rtSelect.disabled = false; // Enable RT select
                });
        } else {
            rtSelect.disabled = true; // Disable RT if no RW is selected
        }
    });
</script>
<?= $this->endSection(); ?>