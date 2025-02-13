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
                <nav aria-label="breadcrumb">
                <?php $uri = service('uri'); ?>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Progres Pelayanan</a></li>
                        <li class="breadcrumb-item breadcrumb-item <?= ($uri->getSegment(2) === 'ceklayanan') ? 'active' : ''; ?>"><a href="#">Edit</a></li>
                        <!-- <li class="breadcrumb-item active" aria-current="page">Edit</li> -->
                    </ol>
                </nav>
                <!-- start breadcrumb -->
                <form action="<?= site_url('admin/simpan-cek-verifikasi-layanan');?>" method="post" enctype='multipart/form-data'>
                
                <?php foreach ($dtGetVerifDetail as $key => $value): ?>
                    <div class="mb-3">
                        <!-- Flexbox untuk Label dan Radio Buttons -->
                        <div class="d-flex align-items-center justify-content-between">
                            <!-- Label dengan ikon -->
                            <label class="mb-0 d-flex align-items-center font-weight-bold text-primary">
                                <i class="fa fa-file mr-2"></i>  <?= $value['JENIS_DOC'];?> / <?= $value['NAMA_TERMOHON'];?>
                            </label>
                            <!-- Radio Buttons -->
                            <input class="form-check-input" type="hidden" name="vrf[<?= $key;?>][status]" id="status-diterima-" value="1">  
                            <!-- <div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="vrf[<?= $key;?>][status]" id="status-diterima-" value="1" checked>
                                    <label class="form-check-label" for="status-diterima-">Diterima</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="vrf[<?= $key;?>][status]" id="status-ditolak-" value="-1">
                                    <label class="form-check-label" for="status-ditolak-">Ditolak</label>
                                </div>
                            </div> -->
                        </div>
                        <!-- Input teks -->
                        <div class="mt-2">
                            <input type="text" class="form-control" id="input-keterangan-" value="<?= $value['KET'];?>" name="vrf[<?= $key;?>][ket]" placeholder="Masukkan keterangan">
                            <input name="NO_PEND"  class="no_pend form-control input-sm " type="hidden" value="<?= $value['NO_PEND'];?>" placeholder="Keterangan">
                            <input name="vrf[<?= $key;?>][no_urut]"  class="no_urut form-control input-sm " type="hidden" value="<?= $value['NO'];?>" placeholder="Keterangan">
                            <input name="vrf[<?= $key;?>][no_hp]"  class="no_hp form-control input-sm " type="hidden" value="<?= $dtGetVerifMaster['CONTACT_PEMOHON'];?>" placeholder="hp">
                        </div>
                    </div>
                <?php endforeach; ?>
                    <div class="mb-3">
                    <label class="medium mb-1 font-weight-bold text-primary" for="exampleFormControlInput1">TGL RENCANA PENGAMBILAN</label>
                    <!-- <input class="form-control" id="exampleFormControlInput1" id="datepicker" type="date" placeholder="TGL RENCANA PENGAMBILAN"> -->
                        <input type="text" class="form-control" id="datepicker" name="TGL_RENCANA_PENGAMBILAN" value="<?= $dtGetVerifMaster['TGL_PENGAMBILAN'];?>" required placeholder="Pilih tanggal">
                    </div>
                    <div class="mb-3">
                        <label class="medium mb-1 font-weight-bold text-primary" for="exampleFormControlInput1">Lokasi Pengambilan di: <?= $dtGetVerifMaster['NAMA_LOKASI'];?></label>
                        <select class="form-control" id="LOKASI_PENGAMBILAN" name="LOKASI_PENGAMBILAN">
                            <option value='<?= $dtGetVerifMaster['KD_PENGAMBILAN'];?>'>Ubah Lokasi Pengambilan</option>
                            <option value='00' <?= $dtGetVerifMaster['KD_PENGAMBILAN'] == '00' ? 'selected' : '' ?>>Mall Pelayanan Publik</option>
                            <option value='19' <?= $dtGetVerifMaster['KD_PENGAMBILAN'] == '19' ? 'selected' : '' ?>>Dinas Dukcapil Gunungkidul</option>
                            <option value='20' <?= $dtGetVerifMaster['KD_PENGAMBILAN'] == '20' ? 'selected' : '' ?>>Anjungan Dukcapil Mandiri</option>
                            <option value='1' <?= $dtGetVerifMaster['KD_PENGAMBILAN'] == '1' ? 'selected' : '' ?>>Kapanewon Wonosari</option>
                            <option value='2' <?= $dtGetVerifMaster['KD_PENGAMBILAN'] == '2' ? 'selected' : '' ?>>Kapanewon Nglipar</option>
                            <option value='3' <?= $dtGetVerifMaster['KD_PENGAMBILAN'] == '3' ? 'selected' : '' ?>>Kapanewon Playen</option>
                            <option value='4' <?= $dtGetVerifMaster['KD_PENGAMBILAN'] == '4' ? 'selected' : '' ?>>Kapanewon Patuk</option>
                            <option value='5' <?= $dtGetVerifMaster['KD_PENGAMBILAN'] == '5' ? 'selected' : '' ?>>Kapanewon Paliyan</option>
                            <option value='6' <?= $dtGetVerifMaster['KD_PENGAMBILAN'] == '6' ? 'selected' : '' ?>>Kapanewon Panggang</option>
                            <option value='7' <?= $dtGetVerifMaster['KD_PENGAMBILAN'] == '7' ? 'selected' : '' ?>>Kapanewon Tepus</option>
                            <option value='8' <?= $dtGetVerifMaster['KD_PENGAMBILAN'] == '8' ? 'selected' : '' ?>>Kapanewon Semanu</option>
                            <option value='9' <?= $dtGetVerifMaster['KD_PENGAMBILAN'] == '9' ? 'selected' : '' ?>>Kapanewon Karangmojo</option>
                            <option value='10' <?= $dtGetVerifMaster['KD_PENGAMBILAN'] == '10' ? 'selected' : '' ?>>Kapanewon Ponjong</option>
                            <option value='11' <?= $dtGetVerifMaster['KD_PENGAMBILAN'] == '11' ? 'selected' : '' ?>>Kapanewon Rongkop</option>
                            <option value='12' <?= $dtGetVerifMaster['KD_PENGAMBILAN'] == '12' ? 'selected' : '' ?>>Kapanewon Semin</option>
                            <option value='13' <?= $dtGetVerifMaster['KD_PENGAMBILAN'] == '13' ? 'selected' : '' ?>>Kapanewon Ngawen</option>
                            <option value='14' <?= $dtGetVerifMaster['KD_PENGAMBILAN'] == '14' ? 'selected' : '' ?>>Kapanewon Gedangsari</option>
                            <option value='15' <?= $dtGetVerifMaster['KD_PENGAMBILAN'] == '15' ? 'selected' : '' ?>>Kapanewon Saptosari</option>
                            <option value='16' <?= $dtGetVerifMaster['KD_PENGAMBILAN'] == '16' ? 'selected' : '' ?>>Kapanewon Girisubo</option>
                            <option value='17' <?= $dtGetVerifMaster['KD_PENGAMBILAN'] == '17' ? 'selected' : '' ?>>Kapanewon Tanjungsari</option>
                            <option value='18' <?= $dtGetVerifMaster['KD_PENGAMBILAN'] == '18' ? 'selected' : '' ?>>Kapanewon Purwosari</option>
                        </select>
                    </div>


                    <div class="mb-3">
                        <div class="mb-3">
                            <div class="d-flex align-items-center justify-content-between">
                                <label class="medium mb-1 font-weight-bold text-primary" for="fileUpload1">UPLOAD PERSYARATAN</label>

                                <?php 
                                    $fileurlsatu = str_replace("/", "-", $dtGetVerifMaster['FILE_URL']);
                                    if (isset($fileurlsatu) && !empty($fileurlsatu)) {
                                       echo anchor_popup(
                                            site_url('admin/preview/' . urlencode($fileurlsatu)), // URL preview
                                            '<i class="fa fa-eye"></i> preview 1',                    // Teks atau konten anchor
                                            [
                                                'class' => 'btn btn-sm btn-primary',                    // Tambahkan kelas CSS
                                                'width' => '800',                                   // Lebar popup
                                                'height' => '600',                                  // Tinggi popup
                                                'resizable' => 'yes',                               // Dapat diubah ukurannya
                                                'scrollbars' => 'yes'                               // Aktifkan scrollbar
                                            ]
                                        );
                                    } else {
                                        echo "1. N/a";
                                    }?>
                                
                            </div>
                            <!-- <div class="mt-2">
                                <input type="file" id="fileUpload1" name="fileUpload1" class="form-control" placeholder="file upload" aria-label="file upload" accept=".pdf" onchange="previewFile(event, 'previewContainer1', 'fileName1')">
                            </div> -->
                        </div>
                        <!-- Preview Container -->
                        <div id="previewContainer1" class="preview-container" style="display: none;">
                            <span id="fileName1"></span>
                            <button type="button" class="btn btn-sm btn-danger" onclick="removeFile('fileUpload1', 'previewContainer1', 'fileName1')">Hapus</button>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="mb-3">
                            <div class="d-flex align-items-center justify-content-between">
                                <label class="medium mb-1 font-weight-bold text-primary" for="fileUpload2">UPLOAD PERSYARATAN TAMBAHAN</label>
                                <?php 
                                    $fileurldua = str_replace("/", "-", $dtGetVerifMaster['FILE_URL2']);
                                    if (isset($fileurldua) && !empty($fileurldua)) {
                                       echo anchor_popup(
                                            site_url('admin/preview/' . urlencode($fileurldua)), // URL preview
                                            '<i class="fa fa-eye"></i> preview 2',                                       // Teks atau konten anchor
                                            [
                                                'class' => 'btn btn-sm btn-primary',                    // Tambahkan kelas CSS
                                                'width' => '800',                                   // Lebar popup
                                                'height' => '600',                                  // Tinggi popup
                                                'resizable' => 'yes',                               // Dapat diubah ukurannya
                                                'scrollbars' => 'yes'                               // Aktifkan scrollbar
                                            ]
                                        );
                                    } else {
                                        echo "2. N/a";
                                    }?>
                            </div>
                            <!-- <div class="mt-2">
                                <input type="file" id="fileUpload2" name="fileUpload2" class="form-control" placeholder="file upload" aria-label="file upload" accept=".pdf" onchange="previewFile(event, 'previewContainer2', 'fileName2')">
                            </div> -->
                        </div>
                        <!-- Preview Container -->
                        <div id="previewContainer2" class="preview-container" style="display: none;">
                            <span id="fileName2"></span>
                            <button type="button" class="btn btn-sm btn-danger" onclick="removeFile('fileUpload2', 'previewContainer2', 'fileName2')">Hapus</button>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="small mb-1" for="exampleFormControlInput1">CATATAN</label>
                        <textarea class="form-control" id="CATATAN" name="CATATAN" placeholder="CATATAN"><?= isset($CATATAN) ? $CATATAN : '' ?><?= $dtGetVerifMaster['CATATAN'];?></textarea>
                        <!-- <input type="text" class="form-control" placeholder="catatan"  aria-label="text" aria-describedby="basic-addon2"> -->
                    </div>

                    <div class="d-flex justify-content-end">
                        <div>
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-check"></i> simpan
                            </button>
                        </div>
                    </div>

                </form>
            </div>
            <!-- end card body 1 -->
        </div>
        <!-- end card kiri -->
         <!-- star card kanan -->
         <div class="card shadow mb-3 col-md-3">
            <div class="card-header border-bottom">
                Verifikasi Layanan
            </div>
            <div class="card-body">
                <form>
                <h4 class="text-center font-weight-bold text-primary"><?= $dtGetVerifMaster['NO_PEND'] ;?></h4>
                <h4 class="text-center font-weight-bold text-primary"><?= $dtGetVerifMaster['NAMA_PEMOHON']; ?></h4>
                <p class="text-center font-weight-bold text-primary"><?= $dtGetVerifMaster['ALAMAT_PEMOHON']; ?></p>
                <ul class="list-group list-group-unbordered">
                    <li class="small list-group-item">
                    <b>Tgl Masuk</b> <a class=""><?= $dtGetVerifMaster['TGL_PENDAFTARAN']; ?></a>
                    </li>
                </ul>
                </form>
            </div>
        </div>
        <!-- end card kanan -->
    </div>
</div>

<?= $this->endSection(); ?>