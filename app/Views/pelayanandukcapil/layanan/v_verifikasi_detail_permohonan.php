<?= $this->extend('pelayanandukcapil/layout/dashboard'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Permohonan Pelayanan</h1>
    <!-- DataTales Example -->
    <div class="row">
        <!--start: card kiri -->
        <div class="card shadow mb-4 col-md-9">
            <div class="card-header border-bottom">
                <?= $this->include('pelayanandukcapil/partials/tabs', ['activeTab' => $activeTab]); ?>
            </div>


            <div class="card-body">
                <!-- <h6><i class="fa fa-users"></i> Data Pemohon</h6> -->
                <!-- start breadcrumb -->
                <?= $this->include('pelayanandukcapil/layanan/breadcrumb'); ?>
                <!-- start breadcrumb -->
                <form action="verifikasi-upload-dokumen" method="post">
                    <!-- <h6><i class="fa fa-file"></i> Jenis Dokumen</h6>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped compact" id="dynamic-table" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>KD Doc</th>
                                    <th>Jenis Doc</th>
                                    <th>Nama</th>
                                    <th>NIK</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td align="center"></td>
                                    <td></td>
                                    <td>
                                        <select class="form-control text-xs" id="exampleFormControl">
                                            <option>AKTA KELAHIRAN</option>
                                            <option>AKTA KEMATIAN</option>
                                            <option>KARTU TANDA PENDUDUK</option>
                                            <option>KARTU IDENTITAS ANAK</option>
                                            <option>PINDAH KELUAR</option>
                                            <option>PINDAH DATANG</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input class="form-control text-xs" id="exampleFormControlInput1" type="text" placeholder="">
                                    </td>
                                    <td>
                                        <input class="form-control text-xs" id="exampleFormControlInput1" type="text" placeholder="">
                                    </td>
                                    <td>
                                        <a href="#" class="btn btn-success btn-circle" onclick="addRow(event, this)">
                                            <i class="fas fa-plus"></i>
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div> -->


                    <div id="formDetailPermohonan" class="formDetailPermohonan">

                        <?php if (isset($permohonanData) && is_array($permohonanData)): ?>
                            <?php foreach ($permohonanData as $index => $data): ?>
                                <div class="mb-3">
                                    <label class="small mb-1" for="exampleFormControlInput1">JENIS DOKUMEN</label>
                                    <select class="form-control text" id="JENIS_DOC" name="JENIS_DOC[]">
                                        <option value="AKTA_LHR" <?= $data['JENIS_DOC'] == 'AKTA_LHR' ? 'selected' : '' ?>>AKTA KELAHIRAN</option>
                                        <option value="AKTA_KMT" <?= $data['JENIS_DOC'] == 'AKTA_KMT' ? 'selected' : '' ?>>AKTA KEMATIAN</option>
                                        <option value="KK" <?= $data['JENIS_DOC'] == 'KK' ? 'selected' : '' ?>>KARTU TANDA PENDUDUK</option>
                                        <option value="KTP" <?= $data['JENIS_DOC'] == 'KTP' ? 'selected' : '' ?>>KARTU IDENTITAS ANAK</option>
                                        <option value="PINDAH_K" <?= $data['JENIS_DOC'] == 'PINDAH_K' ? 'selected' : '' ?>>PINDAH KELUAR</option>
                                        <option value="PINDAH_M" <?= $data['JENIS_DOC'] == 'PINDAH_M' ? 'selected' : '' ?>>PINDAH DATANG</option>
                                    </select>

                                </div>
                                <div class="mb-3">
                                    <label class="small mb-1" for="NAMA_TERMOHON">NAMA TERMOHON</label>
                                    <input class="form-control" id="NAMA_TERMOHON" name="NAMA_TERMOHON[]" value="<?= esc($data['NAMA_TERMOHON']) ?>" required type="text" placeholder="NAMA TERMOHON">
                                </div>
                                <div class="mb-3">
                                    <label class="small mb-1" for="NIK_TERMOHON">NIK TERMOHON</label>
                                    <input class="form-control hanyaangka" id="NIK_TERMOHON" name="NIK_TERMOHON[]" value="<?= esc($data['NIK_TERMOHON']) ?>" required type="number" placeholder="NIK TERMOHON">
                                    <div id="nikCounter" style="color: black;">0/16</div>
                                </div>

                                <!-- Tombol hapus form -->
                                <div class="mb-3">
                                    <button type="button" class="btn btn-danger removeFormButton">
                                        <i class="fas fa-minus"></i> Hapus Permohonan
                                    </button>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="mb-3">
                                <label class="small mb-1" for="exampleFormControlInput1">JENIS DOKUMEN</label>
                                <select class="form-control text" id="JENIS_DOC" name="JENIS_DOC[]">
                                    <option value="AKTA_LHR">AKTA KELAHIRAN</option>
                                    <option value="AKTA_KMT">AKTA KEMATIAN</option>
                                    <option value="KK">KARTU TANDA PENDUDUK</option>
                                    <option value="KTP">KARTU IDENTITAS ANAK</option>
                                    <option value="PINDAH_K">PINDAH KELUAR</option>
                                    <option value="PINDAH_M">PINDAH DATANG</option>
                                </select>

                            </div>
                            <div class="mb-3">
                                <label class="small mb-1" for="NAMA_TERMOHON">NAMA TERMOHON</label>
                                <input class="form-control" id="NAMA_TERMOHON" name="NAMA_TERMOHON[]" value="<?= isset($NAMA_TERMOHON) ? $NAMA_TERMOHON : '' ?>" required type="text" placeholder="NAMA TERMOHON">
                            </div>
                            <div class="mb-3">
                                <label class="small mb-1" for="NIK_TERMOHON">NIK TERMOHON</label>
                                <input class="form-control hanyaangka" id="NIK_TERMOHON" name="NIK_TERMOHON[]" value="<?= isset($NIK_TERMOHON) ? $NIK_TERMOHON : '' ?>" required type="number" placeholder="NIK TERMOHON">
                                <div id="nikCounter" style="color: black;">0/16</div>


                            </div>
                            <!-- Tombol hapus form -->
                            <div class="mb-3">
                                <button type="button" class="btn btn-danger removeFormButton">
                                    <i class="fas fa-minus"></i> Hapus Permohonan
                                </button>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <button class="btn btn-success" id="tambahFormDetailPermohonan" type="button">
                            <i class="fas fa-plus"></i> Tambah Permohonan
                        </button>
                    </div>

                    <div class="d-flex justify-content-between">
                        <div>
                            <a href="<?= site_url('admin/verifikasi-data-pemohon'); ?>"><button class="btn btn-primary" type="button">
                                    <i class="fas fa-arrow-left"></i> kembali
                                </button></a>
                        </div>

                        <div>
                            <button class="btn btn-primary" type="submit" id="submitBtn" disabled>
                                <i class="fas fa-arrow-right"></i> lanjut
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- end card kiri -->
         <!-- star card kanan -->
         <?= $this->include('pelayanandukcapil/layanan/sidebar_permohonan_hariini'); ?>
        <!-- end card kanan -->
    </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<!-- Page level plugins -->
<script>
    // Define the JavaScript variable with the URL from PHP
    var newkategorid = '/admin/kategori/new';

    $(document).ready(function() {
        const table = $("#dataTable").DataTable({
            lengthChange: false,
            buttons: [{
                    text: `<i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp;Tambah Kategori Baru`,
                    className: "btn-sm",
                    action: function(e, dt, node, config) {
                        // Redirect to the new user path
                        window.location.href = newkategorid;
                    },
                },
                {
                    text: `<i class="fa fa-print" aria-hidden="true"></i>&nbsp;Cetak`,
                    className: "btn-sm",
                    split: ["csv", "pdf", "excel"],
                },
                {
                    text: `<i class="fa fa-filter" aria-hidden="true"></i>&nbsp;Preferensi Kolom`,
                    className: "btn-sm",
                    extend: "colvis",
                },
            ],
        });

        table.buttons().container().appendTo("#dataTable_wrapper .col-md-6:eq(0)");
    });
</script>
<script>
    $(document).ready(function() {
        tambahFormBaru();
        TombolHapus();
        validasiFormNik();
        eventNik();
        updateRemoveButtonVisibility();
    });

    function tambahFormBaru() {
        // Fungsi untuk menambahkan form baru
        $('#tambahFormDetailPermohonan').click(function() {
            // Duplikat form pertama dan reset nilai input di dalamnya
            var newForm = $('.formDetailPermohonan').first().clone();
            newForm.find('input, select').val(''); // Kosongkan nilai pada input baru

            // Tampilkan tombol hapus pada form yang baru dikloning
            newForm.find('.removeFormButton').show();

            // Tambahkan event listener untuk tombol hapus pada form baru
            newForm.find('.removeFormButton').click(function() {
                $(this).closest('.formDetailPermohonan').remove();
            });

            // Tambahkan form baru setelah form terakhir
            newForm.insertAfter('.formDetailPermohonan:last');

            updateRemoveButtonVisibility();
        });
    }

    function TombolHapus() {
        $('.removeFormButton').click(function() {
            $(this).closest('#formDetailPermohonan').remove();
        });
    }

    function updateRemoveButtonVisibility() {
        $('.formDetailPermohonan').each(function(index) {
            if (index === 0) {
                $(this).find('.removeFormButton').hide();
            } else {
                $(this).find('.removeFormButton').show();
            }
        });
    }


    function validasiFormNik() {
        var nik = $('.hanyaangka').val();
        $('#nikCounter').text(nik.length + '/16');
        $('#errorNIK').hide();
        if (nik.length < 16) {
            $('#errorNIK').text('NIK harus terdiri dari 16 angka.').show();
            $('#submitBtn').prop('disabled', true);
            return false;
        } else if (nik.length === 16 && /^[0-9]+$/.test(nik)) {
            $('#submitBtn').prop('disabled', false);
            return true;
        } else {
            $('#errorNIK').text('NIK hanya boleh berisi angka.').show();
            $('#submitBtn').prop('disabled', true);
            return false;
        }
    }

    function eventNik() {
        $('.hanyaangka').on('input', function() {
            var nik = $(this).val();
            if (nik.length > 16) {
                $(this).val(nik.substring(0, 16));
            }
            validasiFormNik();
        });

    }
</script>
<?= $this->endSection(); ?>