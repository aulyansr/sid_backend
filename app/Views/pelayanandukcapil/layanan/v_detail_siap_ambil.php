<?= $this->extend('pelayanandukcapil/layout/dashboard'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Permohonan Pelayanan</h1>
    
    <!-- DataTales Example -->
    <div class="row">
        <!--start: card kiri -->
        <div class="card shadow mb-4 col-md-12">
            <div class="card-header border-bottom">
                <?= $this->include('pelayanandukcapil/partials/tabs', ['activeTab' => $activeTab]); ?>
            </div>


            <div class="card-body">
                <!-- <h6><i class="fa fa-users"></i> Data Pemohon</h6> -->
                <!-- start breadcrumb -->
                <?php $uri = service('uri'); ?>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Siap Ambil</a></li>
                        <li class="breadcrumb-item <?= ($uri->getSegment(2) === 'detail-siap-ambil') ? 'active' : ''; ?>"><a href="#">Detail</a></li>
                    </ol>
                </nav>
                <!-- start breadcrumb -->
                <form action="<?= site_url('admin/simpan-cek-verifikasi-layanan');?>" method="post" enctype='multipart/form-data'>
                
               
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped compact" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>NO</th>
                                    <th>NAMA TERMOHON</th>
                                    <th>JENIS DOC</th>
                                    <th>NO DOC</th>
                                    <th>STATUS</th>
                                    <th>KETERANGAN</th>
                                </tr>
                            </thead>
                            <!-- <tfoot>
                                <tr>
                                    <th>NO</th>
                                    <th>NAMA TERMOHON</th>
                                    <th>JENIS DOC</th>
                                    <th>NO DOC</th>
                                    <th>STATUS</th>
                                    <th>KETERANGAN</th>
                                </tr>
                            </tfoot> -->
                            <tbody>
                                <?php foreach ($dtCekSiapAmbil as $key => $value): ?>
                                    <tr>
                                        <td align="center">#</td>
                                        <td><?= $value['NAMA_TERMOHON'];?></td>
                                        <td><?= $value['JENIS_DOC'];?></td>
                                        <td><?= $value['NO_DOC'];?></td>
                                        <td><?= $value['STATUS'];?></td>
                                        <td><?= $value['KET_AMBIL'];?></td>


                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    

                    <div class="d-flex justify-content-end">
                        <div>
                        <a href="javascript:history.back()" class="btn btn-primary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>

                        </div>
                    </div>

                </form>
            </div>
            <!-- end card body 1 -->
        </div>
        <!-- end card kiri -->
         <!-- star card kanan -->
         <!-- <div class="card shadow mb-3 col-md-3">
            <div class="card-header border-bottom">
                Verifikasi Layanan
            </div>
            <div class="card-body">
               
            </div>
        </div> -->
        <!-- end card kanan -->
    </div>
</div>

<?= $this->endSection(); ?>