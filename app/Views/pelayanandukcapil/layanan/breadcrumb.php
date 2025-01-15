<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <!-- <li class="breadcrumb-item"><a href="#">Data Pemohon</a></li>
        <li class="breadcrumb-item"><a href="#">Detail Permohonan</a></li>
        <li class="breadcrumb-item"><a href="#">Upload Dokumen</a></li> -->
        <?php $uri = service('uri'); ?>
        <li class="breadcrumb-item <?= current_url() === site_url('admin/verifikasi-data-pemohon') ? 'active' : ''; ?>"><a href="<?= site_url('admin/verifikasi-data-pemohon');?>">Data Pemohon</a></li>
        <li class="breadcrumb-item <?= current_url() === site_url('admin/verifikasi-detail-permohonan') ? 'active' : ''; ?>"><a href="<?= site_url('admin/verifikasi-detail-permohonan');?>">Detail Permohonan</a></li>
        <li class="breadcrumb-item <?= current_url() === site_url('admin/verifikasi-upload-dokumen') ? 'active' : ''; ?>"><a href="<?= site_url('admin/verifikasi-upload-dokumen');?>">Upload Dokumen</a></li>
        <li class="breadcrumb-item <?= ($uri->getSegment(2) === 'verifikasi-layanan') ? 'active' : ''; ?>"> <a href="<?= site_url('admin/verifikasi-layanan');?>">Verifikasi</a></li>
        <!-- <li class="breadcrumb-item" aria-current="page">Finish</li> -->
    </ol>
</nav>