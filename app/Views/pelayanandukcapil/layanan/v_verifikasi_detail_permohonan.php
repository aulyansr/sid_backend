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
                <!-- <form action="verifikasi-upload-dokumen" method="post"> -->
                <!-- <form id="form-input-multiple"> -->
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="small mb-1" for="exampleFormControlInput1">JENIS DOKUMEN</label>
                                <select class="form-control text" id="JENIS_DOC" name="JENIS_DOC">
                                    <option value="AKTA_LHR">AKTA KELAHIRAN</option>
                                    <option value="AKTA_KMT">AKTA KEMATIAN</option>
                                    <option value="KK">KARTU TANDA PENDUDUK</option>
                                    <option value="KTP">KARTU IDENTITAS ANAK</option>
                                    <option value="PINDAH_K">PINDAH KELUAR</option>
                                    <option value="PINDAH_M">PINDAH DATANG</option>
                                </select>

                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="small mb-1" for="NAMA_TERMOHON">NAMA TERMOHON</label>
                                <input class="form-control" id="NAMA_TERMOHON" name="NAMA_TERMOHON" value="<?= isset($NAMA_TERMOHON) ? $NAMA_TERMOHON : '' ?>"  type="text" placeholder="NAMA TERMOHON">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="small mb-1" for="NIK_TERMOHON">NIK TERMOHON</label>
                                <input class="form-control hanyaangka" id="NIK_TERMOHON" name="NIK_TERMOHON" value="<?= isset($NIK_TERMOHON) ? $NIK_TERMOHON : '' ?>"  type="number" placeholder="NIK TERMOHON">
                                <div id="nikCounter" style="color: black;">0/16</div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-primary" type="submit" id="add-data">
                            <i class="fas fa-plus"></i> Add Data
                        </button>

                    <!-- <div class="mb-3">
                        <button class="btn btn-success" id="tambahFormDetailPermohonan" type="button">
                            <i class="fas fa-plus"></i> Tambah Permohonan
                        </button>
                    </div> -->

                   

                    <div class="table-responsive mt-4">
                        <table class="table table-bordered" id="temporary-table">
                            <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>JENIS DOKUMEN</th>
                                    <th>NAMA TERMOHON</th>
                                    <th>NIK TERMOHON</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data will be appended dynamically -->
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-between">
                        <div>
                            <a href="<?= site_url('admin/verifikasi-data-pemohon'); ?>"><button class="btn btn-primary" type="button">
                                    <i class="fas fa-arrow-left"></i> kembali
                                </button></a>
                        </div>

                        <div>
                            <button class="btn btn-primary" id="submitDetail">
                                <i class="fas fa-arrow-right"></i> lanjut
                            </button>
                        </div>
                    </div>
                <!-- </form> -->
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
        $('.hanyaangka').on('input', function () {
            var nik = $(this).val();

            // Hapus karakter non-angka
            nik = nik.replace(/\D/g, '');

            // Batasi panjang maksimal 16 karakter
            if (nik.length > 16) {
                nik = nik.substring(0, 16);
            }

            $(this).val(nik); // Set nilai input

            validasiFormNik(); // Panggil fungsi validasi
        });

    }


    // new metode simpan tabel temp
    $(document).ready(function () {
        let dataArray = []; // Temporary storage for data

          // Fungsi untuk mengecek apakah tabel memiliki data
        function checkTableData() {
            const hasData = $('#temporary-table tbody tr').length > 0;
            $('#submitDetail').prop('disabled', !hasData); // Aktifkan atau nonaktifkan tombol
        }

        // Cek tabel saat halaman dimuat
        checkTableData();

        // Add data to the temporary table
        $('#add-data').on('click', function () {
            const JENIS_DOC = $('#JENIS_DOC').val();
            const JENIS_DOCTEXT = $('#JENIS_DOC option:selected').text(); // Display value
            const NAMA_TERMOHON = $('#NAMA_TERMOHON').val();
            const NIK_TERMOHON = $('#NIK_TERMOHON').val();

            if (!/^\d{16}$/.test(NIK_TERMOHON)) {
                alert('NIK harus berupa angka dan memiliki tepat 16 karakter!');
                return; // Hentikan proses jika tidak valid
            }

            if (JENIS_DOC && NAMA_TERMOHON && NIK_TERMOHON) {
                const index = dataArray.length + 1;

                // Add data to the array
                dataArray.push({ JENIS_DOC, NAMA_TERMOHON, NIK_TERMOHON });

                // Append to table
                const row = `
                    <tr>
                        <td>${index}</td>
                        <td>${JENIS_DOCTEXT}</td>
                        <td>${NAMA_TERMOHON}</td>
                        <td>${NIK_TERMOHON}</td>
                        <td>
                            <button class="btn btn-danger btn-sm delete-row" data-index="${index - 1}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>`;
                $('#temporary-table tbody').append(row);

                // Clear input fields
                $('#JENIS_DOC').val('');
                $('#NAMA_TERMOHON').val('');
                $('#NIK_TERMOHON').val('');

                // Enable "Lanjut" button if data exists
                checkTableData();
            } else {
                alert('Harus diisi!');
            }
        });

        // Delete row from table and array
        $('body').on('click', '.delete-row', function () {
            const index = $(this).data('index');
            dataArray.splice(index, 1);

            // Rebuild table
            $('#temporary-table tbody').empty();
            dataArray.forEach((data, i) => {
                const row = `
                    <tr>
                        <td>${i + 1}</td>
                        <td>${data.JENIS_DOCTEXT}</td>
                        <td>${data.NAMA_TERMOHON}</td>
                        <td>${data.NIK_TERMOHON}</td>
                        <td>
                            <button class="btn btn-danger btn-sm delete-row" data-index="${i}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>`;
                $('#temporary-table tbody').append(row);
            });

            // Enable "Lanjut" button if data exists
            checkTableData();
        });

        // Function to check if the table has data
        function checkTableData() {
            const hasData = $('#temporary-table tbody tr').length > 0;
            $('#submitDetail').prop('disabled', !hasData); // Aktifkan atau nonaktifkan tombol
        }


        // Save all data and navigate to next tab
        $('#submitDetail').on('click', function () {
            // alert(dataArray.length);
            if (dataArray.length > 0) {
                $.ajax({
                    url: '<?= site_url('admin/upload-detail-permohonan') ?>',
                    method: 'POST',
                    data: { data: dataArray },
                    success: function (response) {
                        // alert(response.message);
                        dataArray = [];
                        $('#temporary-table tbody').empty();
                        window.location.href = '<?= site_url('admin/verifikasi-upload-dokumen') ?>';
                    },
                    error: function (xhr) {
                        alert('Error saving data');
                    }
                });
            } else {
                alert('Data harus diisi!');
            }
        });
    });
</script>

<?= $this->endSection(); ?>