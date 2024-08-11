<?= $this->extend('layout/dashboard'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid">

    <div class="card">
        <div class="card-header border-bottom">
            <ul class="nav nav-tabs card-header-tabs" id="cardTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="card-cetak-surat-tab" href="#card-cetak-surat" data-toggle="tab" role="tab" aria-controls="card-cetak-surat" aria-selected="true">Cetak Surat</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="card-surat-keluar-tab" href="#card-surat-keluar" data-toggle="tab" role="tab" aria-controls="card-surat-keluar" aria-selected="false">Surat Keluar</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="card-panduan-tab" href="#card-panduan" data-toggle="tab" role="tab" aria-controls="card-panduan" aria-selected="false">Panduan</a>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content" id="cardTabContent">
                <div class="tab-pane fade show active" id="card-cetak-surat" role="tabpanel" aria-labelledby="card-cetak-surat-tab">
                    <!-- Files -->
                    <div class="row">
                        <!-- File -->
                        <div class="col-xl-2 col-md-4 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                KETERANGAN</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">01
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="far fa-file-pdf fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-2 col-md-4 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                PENGANTAR SKCK</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">03
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="far fa-file-pdf fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
                <div class="tab-pane fade" id="card-surat-keluar" role="tabpanel" aria-labelledby="card-surat-keluar-tab">
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Manajemen Surat Keluar
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped compact" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Aksi</th>
                                            <th>Username</th>
                                            <th>Nama</th>
                                            <th>Group</th>
                                            <th>Last Login</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>Aksi</th>
                                            <th>Username</th>
                                            <th>Nama</th>
                                            <th>Group</th>
                                            <th>Last Login</th>
                                        </tr>
                                    </tfoot>
                                    <tr>
                                        <td align="center" width="2">1</td>

                                        <td>
                                            <div class="uibutton-group">
                                                <a href="https://desangunut.gunungkidulkab.go.id/analisis_master/form/1/0/11" class="btn btn-sm btn-warning" title="Ubah Data"><i class="fa fa-edit"></i>
                                                    Ubah</a>
                                                <a href="https://desangunut.gunungkidulkab.go.id/analisis_master/form/1/0/11" class="btn btn-sm btn-danger" title="Ubah Data"><i class="fa fa-trash"></i>
                                                    Hapus</a>

                                                <a href="https://desangunut.gunungkidulkab.go.id/analisis_master/form/1/0/11" class="btn btn-sm btn-secondary" title="Ubah Data"><i class="fa fa-lock"></i>
                                                </a>
                                            </div>
                                        </td>
                                        <td>ajekss</td>
                                        <td>Ajeks</td>
                                        <td>Administrator</td>
                                        <td>02 November 2021</td>
                                    </tr>
                                    <tr>
                                        <td align="center" width="2">2</td>

                                        <td>
                                            <div class="uibutton-group">
                                                <a href="https://desangunut.gunungkidulkab.go.id/analisis_master/form/1/0/11" class="btn btn-sm btn-warning" title="Ubah Data"><i class="fa fa-edit"></i>
                                                    Ubah</a>
                                                <a href="https://desangunut.gunungkidulkab.go.id/analisis_master/form/1/0/11" class="btn btn-sm btn-danger" title="Ubah Data"><i class="fa fa-trash"></i>
                                                    Hapus</a>

                                                <a href="https://desangunut.gunungkidulkab.go.id/analisis_master/form/1/0/11" class="btn btn-sm btn-secondary" title="Ubah Data"><i class="fa fa-lock"></i>
                                                </a>
                                            </div>
                                        </td>
                                        <td>aminto</td>
                                        <td>Aminto Sudarso</td>
                                        <td>Administrator</td>
                                        <td>25 November 2023</td>
                                    </tr>
                                    <tr>
                                        <td align="center" width="2">3</td>

                                        <td>
                                            <div class="uibutton-group">
                                                <a href="https://desangunut.gunungkidulkab.go.id/analisis_master/form/1/0/11" class="btn btn-sm btn-warning" title="Ubah Data"><i class="fa fa-edit"></i>
                                                    Ubah</a>
                                                <a href="https://desangunut.gunungkidulkab.go.id/analisis_master/form/1/0/11" class="btn btn-sm btn-danger" title="Ubah Data"><i class="fa fa-trash"></i>
                                                    Hapus</a>

                                                <a href="https://desangunut.gunungkidulkab.go.id/analisis_master/form/1/0/11" class="btn btn-sm btn-secondary" title="Ubah Data"><i class="fa fa-lock"></i>
                                                </a>
                                            </div>
                                        </td>
                                        <td>Desi</td>
                                        <td></td>
                                        <td>Operator</td>
                                        <td>13 November 2022</td>
                                    </tr>
                                    <tr>
                                        <td align="center" width="2">4</td>

                                        <td>
                                            <div class="uibutton-group">
                                                <a href="https://desangunut.gunungkidulkab.go.id/analisis_master/form/1/0/11" class="btn btn-sm btn-warning" title="Ubah Data"><i class="fa fa-edit"></i>
                                                    Ubah</a>
                                                <a href="https://desangunut.gunungkidulkab.go.id/analisis_master/form/1/0/11" class="btn btn-sm btn-danger" title="Ubah Data"><i class="fa fa-trash"></i>
                                                    Hapus</a>

                                                <a href="https://desangunut.gunungkidulkab.go.id/analisis_master/form/1/0/11" class="btn btn-sm btn-secondary" title="Ubah Data"><i class="fa fa-lock"></i>
                                                </a>
                                            </div>
                                        </td>
                                        <td>dinkes</td>
                                        <td>Pemantauan</td>
                                        <td>Operator IKS</td>
                                        <td>23 Maret 2020</td>
                                    </tr>
                                    <tr>
                                        <td align="center" width="2">5</td>

                                        <td>
                                            <div class="uibutton-group">
                                                <a href="https://desangunut.gunungkidulkab.go.id/analisis_master/form/1/0/11" class="btn btn-sm btn-warning" title="Ubah Data"><i class="fa fa-edit"></i>
                                                    Ubah</a>
                                                <a href="https://desangunut.gunungkidulkab.go.id/analisis_master/form/1/0/11" class="btn btn-sm btn-danger" title="Ubah Data"><i class="fa fa-trash"></i>
                                                    Hapus</a>

                                                <a href="https://desangunut.gunungkidulkab.go.id/analisis_master/form/1/0/11" class="btn btn-sm btn-secondary" title="Ubah Data"><i class="fa fa-lock"></i>
                                                </a>
                                            </div>
                                        </td>
                                        <td>djunian</td>
                                        <td>Djunian</td>
                                        <td>Administrator</td>
                                        <td>10 Desember 2023</td>
                                    </tr>
                                    <tr>
                                        <td align="center" width="2">6</td>

                                        <td>
                                            <div class="uibutton-group">
                                                <a href="https://desangunut.gunungkidulkab.go.id/analisis_master/form/1/0/11" class="btn btn-sm btn-warning" title="Ubah Data"><i class="fa fa-edit"></i>
                                                    Ubah</a>
                                                <a href="https://desangunut.gunungkidulkab.go.id/analisis_master/form/1/0/11" class="btn btn-sm btn-danger" title="Ubah Data"><i class="fa fa-trash"></i>
                                                    Hapus</a>

                                                <a href="https://desangunut.gunungkidulkab.go.id/analisis_master/form/1/0/11" class="btn btn-sm btn-secondary" title="Ubah Data"><i class="fa fa-lock"></i>
                                                </a>
                                            </div>
                                        </td>
                                        <td>hanung</td>
                                        <td>Hanung</td>
                                        <td>Administrator</td>
                                        <td>04 Desember 2023</td>
                                    </tr>
                                    <tr>
                                        <td align="center" width="2">7</td>

                                        <td>
                                            <div class="uibutton-group">
                                                <a href="https://desangunut.gunungkidulkab.go.id/analisis_master/form/1/0/11" class="btn btn-sm btn-warning" title="Ubah Data"><i class="fa fa-edit"></i>
                                                    Ubah</a>
                                                <a href="https://desangunut.gunungkidulkab.go.id/analisis_master/form/1/0/11" class="btn btn-sm btn-danger" title="Ubah Data"><i class="fa fa-trash"></i>
                                                    Hapus</a>

                                                <a href="https://desangunut.gunungkidulkab.go.id/analisis_master/form/1/0/11" class="btn btn-sm btn-secondary" title="Ubah Data"><i class="fa fa-lock"></i>
                                                </a>
                                            </div>
                                        </td>
                                        <td>iks_dinkesgk01</td>
                                        <td>Veronika R</td>
                                        <td>Operator IKS</td>
                                        <td>28 Februari 2023</td>
                                    </tr>
                                    <tr>
                                        <td align="center" width="2">8</td>

                                        <td>
                                            <div class="uibutton-group">
                                                <a href="https://desangunut.gunungkidulkab.go.id/analisis_master/form/1/0/11" class="btn btn-sm btn-warning" title="Ubah Data"><i class="fa fa-edit"></i>
                                                    Ubah</a>
                                                <a href="https://desangunut.gunungkidulkab.go.id/analisis_master/form/1/0/11" class="btn btn-sm btn-danger" title="Ubah Data"><i class="fa fa-trash"></i>
                                                    Hapus</a>

                                                <a href="https://desangunut.gunungkidulkab.go.id/analisis_master/form/1/0/11" class="btn btn-sm btn-secondary" title="Ubah Data"><i class="fa fa-lock"></i>
                                                </a>
                                            </div>
                                        </td>
                                        <td>iks_dinkesgk02</td>
                                        <td>Operator Puskesmas 02</td>
                                        <td>Operator IKS</td>
                                        <td>00 0000</td>
                                    </tr>
                                    <tr>
                                        <td align="center" width="2">9</td>

                                        <td>
                                            <div class="uibutton-group">
                                                <a href="https://desangunut.gunungkidulkab.go.id/analisis_master/form/1/0/11" class="btn btn-sm btn-warning" title="Ubah Data"><i class="fa fa-edit"></i>
                                                    Ubah</a>
                                                <a href="https://desangunut.gunungkidulkab.go.id/analisis_master/form/1/0/11" class="btn btn-sm btn-danger" title="Ubah Data"><i class="fa fa-trash"></i>
                                                    Hapus</a>

                                                <a href="https://desangunut.gunungkidulkab.go.id/analisis_master/form/1/0/11" class="btn btn-sm btn-secondary" title="Ubah Data"><i class="fa fa-lock"></i>
                                                </a>
                                            </div>
                                        </td>
                                        <td>iks_dinkesgk03</td>
                                        <td>Operator Puskesmas 03</td>
                                        <td>Operator IKS</td>
                                        <td>00 0000</td>
                                    </tr>
                                    <tr>
                                        <td align="center" width="2">10</td>

                                        <td>
                                            <div class="uibutton-group">
                                                <a href="https://desangunut.gunungkidulkab.go.id/analisis_master/form/1/0/11" class="btn btn-sm btn-warning" title="Ubah Data"><i class="fa fa-edit"></i>
                                                    Ubah</a>
                                                <a href="https://desangunut.gunungkidulkab.go.id/analisis_master/form/1/0/11" class="btn btn-sm btn-danger" title="Ubah Data"><i class="fa fa-trash"></i>
                                                    Hapus</a>

                                                <a href="https://desangunut.gunungkidulkab.go.id/analisis_master/form/1/0/11" class="btn btn-sm btn-secondary" title="Ubah Data"><i class="fa fa-lock"></i>
                                                </a>
                                            </div>
                                        </td>
                                        <td>iks_dinkesgk04</td>
                                        <td>Operator Puskesmas 04</td>
                                        <td>Operator IKS</td>
                                        <td>00 0000</td>
                                    </tr>
                                    <tr>
                                        <td align="center" width="2">11</td>

                                        <td>
                                            <div class="uibutton-group">
                                                <a href="https://desangunut.gunungkidulkab.go.id/analisis_master/form/1/0/11" class="btn btn-sm btn-warning" title="Ubah Data"><i class="fa fa-edit"></i>
                                                    Ubah</a>
                                                <a href="https://desangunut.gunungkidulkab.go.id/analisis_master/form/1/0/11" class="btn btn-sm btn-danger" title="Ubah Data"><i class="fa fa-trash"></i>
                                                    Hapus</a>

                                                <a href="https://desangunut.gunungkidulkab.go.id/analisis_master/form/1/0/11" class="btn btn-sm btn-secondary" title="Ubah Data"><i class="fa fa-lock"></i>
                                                </a>
                                            </div>
                                        </td>
                                        <td>iks_dinkesgk05</td>
                                        <td>Operator Puskesmas 05</td>
                                        <td>Operator IKS</td>
                                        <td>08 Juli 2019</td>
                                    </tr>
                                    <tr>
                                        <td align="center" width="2">12</td>

                                        <td>
                                            <div class="uibutton-group">
                                                <a href="https://desangunut.gunungkidulkab.go.id/analisis_master/form/1/0/11" class="btn btn-sm btn-warning" title="Ubah Data"><i class="fa fa-edit"></i>
                                                    Ubah</a>
                                                <a href="https://desangunut.gunungkidulkab.go.id/analisis_master/form/1/0/11" class="btn btn-sm btn-danger" title="Ubah Data"><i class="fa fa-trash"></i>
                                                    Hapus</a>

                                                <a href="https://desangunut.gunungkidulkab.go.id/analisis_master/form/1/0/11" class="btn btn-sm btn-secondary" title="Ubah Data"><i class="fa fa-lock"></i>
                                                </a>
                                            </div>
                                        </td>
                                        <td>iks_dinkesgk06</td>
                                        <td>Operator Puskesmas 06</td>
                                        <td>Operator IKS</td>
                                        <td>00 0000</td>
                                    </tr>
                                    <tr>
                                        <td align="center" width="2">13</td>

                                        <td>
                                            <div class="uibutton-group">
                                                <a href="https://desangunut.gunungkidulkab.go.id/analisis_master/form/1/0/11" class="btn btn-sm btn-warning" title="Ubah Data"><i class="fa fa-edit"></i>
                                                    Ubah</a>
                                                <a href="https://desangunut.gunungkidulkab.go.id/analisis_master/form/1/0/11" class="btn btn-sm btn-danger" title="Ubah Data"><i class="fa fa-trash"></i>
                                                    Hapus</a>

                                                <a href="https://desangunut.gunungkidulkab.go.id/analisis_master/form/1/0/11" class="btn btn-sm btn-secondary" title="Ubah Data"><i class="fa fa-lock"></i>
                                                </a>
                                            </div>
                                        </td>
                                        <td>iks_dinkesgk07</td>
                                        <td>Operator Puskesmas 07</td>
                                        <td>Operator IKS</td>
                                        <td>31 Oktober 2021</td>
                                    </tr>
                                    <tr>
                                        <td align="center" width="2">14</td>

                                        <td>
                                            <div class="uibutton-group">
                                                <a href="https://desangunut.gunungkidulkab.go.id/analisis_master/form/1/0/11" class="btn btn-sm btn-warning" title="Ubah Data"><i class="fa fa-edit"></i>
                                                    Ubah</a>
                                                <a href="https://desangunut.gunungkidulkab.go.id/analisis_master/form/1/0/11" class="btn btn-sm btn-danger" title="Ubah Data"><i class="fa fa-trash"></i>
                                                    Hapus</a>

                                                <a href="https://desangunut.gunungkidulkab.go.id/analisis_master/form/1/0/11" class="btn btn-sm btn-secondary" title="Ubah Data"><i class="fa fa-lock"></i>
                                                </a>
                                            </div>
                                        </td>
                                        <td>iks_dinkesgk08</td>
                                        <td>Operator Puskesmas 08</td>
                                        <td>Operator IKS</td>
                                        <td>00 0000</td>
                                    </tr>
                                    <tr>
                                        <td align="center" width="2">15</td>

                                        <td>
                                            <div class="uibutton-group">
                                                <a href="https://desangunut.gunungkidulkab.go.id/analisis_master/form/1/0/11" class="btn btn-sm btn-warning" title="Ubah Data"><i class="fa fa-edit"></i>
                                                    Ubah</a>
                                                <a href="https://desangunut.gunungkidulkab.go.id/analisis_master/form/1/0/11" class="btn btn-sm btn-danger" title="Ubah Data"><i class="fa fa-trash"></i>
                                                    Hapus</a>

                                                <a href="https://desangunut.gunungkidulkab.go.id/analisis_master/form/1/0/11" class="btn btn-sm btn-secondary" title="Ubah Data"><i class="fa fa-lock"></i>
                                                </a>
                                            </div>
                                        </td>
                                        <td>iks_dinkesgk09</td>
                                        <td>Operator Puskesmas 09</td>
                                        <td>Operator IKS</td>
                                        <td>00 0000</td>
                                    </tr>
                                    <tr>
                                        <td align="center" width="2">16</td>

                                        <td>
                                            <div class="uibutton-group">
                                                <a href="https://desangunut.gunungkidulkab.go.id/analisis_master/form/1/0/11" class="btn btn-sm btn-warning" title="Ubah Data"><i class="fa fa-edit"></i>
                                                    Ubah</a>
                                                <a href="https://desangunut.gunungkidulkab.go.id/analisis_master/form/1/0/11" class="btn btn-sm btn-danger" title="Ubah Data"><i class="fa fa-trash"></i>
                                                    Hapus</a>

                                                <a href="https://desangunut.gunungkidulkab.go.id/analisis_master/form/1/0/11" class="btn btn-sm btn-secondary" title="Ubah Data"><i class="fa fa-lock"></i>
                                                </a>
                                            </div>
                                        </td>
                                        <td>iks_dinkesgk10</td>
                                        <td>Operator Puskesmas 10</td>
                                        <td>Operator IKS</td>
                                        <td>00 0000</td>
                                    </tr>
                                    <tr>
                                        <td align="center" width="2">17</td>

                                        <td>
                                            <div class="uibutton-group">
                                                <a href="https://desangunut.gunungkidulkab.go.id/analisis_master/form/1/0/11" class="btn btn-sm btn-warning" title="Ubah Data"><i class="fa fa-edit"></i>
                                                    Ubah</a>
                                                <a href="https://desangunut.gunungkidulkab.go.id/analisis_master/form/1/0/11" class="btn btn-sm btn-danger" title="Ubah Data"><i class="fa fa-trash"></i>
                                                    Hapus</a>

                                                <a href="https://desangunut.gunungkidulkab.go.id/analisis_master/form/1/0/11" class="btn btn-sm btn-secondary" title="Ubah Data"><i class="fa fa-lock"></i>
                                                </a>
                                            </div>
                                        </td>
                                        <td>Jey</td>
                                        <td></td>
                                        <td>Operator</td>
                                        <td>02 November 2023</td>
                                    </tr>
                                    <tr>
                                        <td align="center" width="2">18</td>

                                        <td>
                                            <div class="uibutton-group">
                                                <a href="https://desangunut.gunungkidulkab.go.id/analisis_master/form/1/0/11" class="btn btn-sm btn-warning" title="Ubah Data"><i class="fa fa-edit"></i>
                                                    Ubah</a>
                                                <a href="https://desangunut.gunungkidulkab.go.id/analisis_master/form/1/0/11" class="btn btn-sm btn-danger" title="Ubah Data"><i class="fa fa-trash"></i>
                                                    Hapus</a>

                                                <a href="https://desangunut.gunungkidulkab.go.id/analisis_master/form/1/0/11" class="btn btn-sm btn-secondary" title="Ubah Data"><i class="fa fa-lock"></i>
                                                </a>
                                            </div>
                                        </td>
                                        <td>KKN</td>
                                        <td></td>
                                        <td>Redaksi</td>
                                        <td>21 Agustus 2023</td>
                                    </tr>
                                    <tr>
                                        <td align="center" width="2">19</td>

                                        <td>
                                            <div class="uibutton-group">
                                                <a href="https://desangunut.gunungkidulkab.go.id/analisis_master/form/1/0/11" class="btn btn-sm btn-warning" title="Ubah Data"><i class="fa fa-edit"></i>
                                                    Ubah</a>
                                                <a href="https://desangunut.gunungkidulkab.go.id/analisis_master/form/1/0/11" class="btn btn-sm btn-danger" title="Ubah Data"><i class="fa fa-trash"></i>
                                                    Hapus</a>

                                                <a href="https://desangunut.gunungkidulkab.go.id/analisis_master/form/1/0/11" class="btn btn-sm btn-secondary" title="Ubah Data"><i class="fa fa-lock"></i>
                                                </a>
                                            </div>
                                        </td>
                                        <td>KKNkernen</td>
                                        <td></td>
                                        <td>Kontributor</td>
                                        <td>00 0000</td>
                                    </tr>
                                    <tr>
                                        <td align="center" width="2">20</td>

                                        <td>
                                            <div class="uibutton-group">
                                                <a href="https://desangunut.gunungkidulkab.go.id/analisis_master/form/1/0/11" class="btn btn-sm btn-warning" title="Ubah Data"><i class="fa fa-edit"></i>
                                                    Ubah</a>
                                                <a href="https://desangunut.gunungkidulkab.go.id/analisis_master/form/1/0/11" class="btn btn-sm btn-danger" title="Ubah Data"><i class="fa fa-trash"></i>
                                                    Hapus</a>

                                                <a href="https://desangunut.gunungkidulkab.go.id/analisis_master/form/1/0/11" class="btn btn-sm btn-secondary" title="Ubah Data"><i class="fa fa-lock"></i>
                                                </a>
                                            </div>
                                        </td>
                                        <td>KKNlor</td>
                                        <td></td>
                                        <td>Redaksi</td>
                                        <td>19 Maret 2023</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="card-panduan" role="tabpanel" aria-labelledby="card-panduan-tab">
                    <h5>Panduan Pembuatan Surat Administrasi Kependudukan</h5>
                    <p>Salah satu fungsi aplikasi Sistem Informasi Desa (SID) adalah untuk
                        mengoptimalkan pelayanan administrasi publik berbasis data. Pelayanan
                        administrasi publik yang bisa dilakukan dengan aplikasi SID meliputi
                        pelayanan olah data dan pelayanan olah dokumen/surat. Pelayanan olah data
                        dapat dilakukan dengan memanfaatkan fungsi-fungsi statistik yang dapat
                        dimanfaatkan untuk laporan dan rujukan pengambilan keputusan. Pelayanan olah
                        dokumen bisa dilakukan dari data yang telah diolah dan/atau dari pengelolaan
                        administrasi surat-menyurat.</p>
                    <p>Aplikasi SID menghimpun seluruh data penduduk desa, sehingga bisa digunakan
                        untuk data dasar pembuatan surat administrasi kependudukan. Pelayanan
                        administrasi persuratan itu dapat dikelola oleh pemerintah desa di kantor
                        pemerintah desa masing-masing. Tata cara pemanfaatan module cetak surat
                        aplikasi SID dalam alur pelayanan publik di kantor desa secara garis besar
                        dapat dilakukan dengan urutan sebagai berikut:</p>
                    <ol>
                        <li>Penduduk pemohon surat datang dengan membawa kartu identitas diri (KTP
                            atau Kartu Keluarga/KK) dan diterima oleh staf pemerintah desa yang
                            bertugas dalam pelayanan.</li>
                        <li>Pastikan keberadaan dan status penduduk tersebut dalam database SID di
                            Module "Penduduk". Gunakan fasilitas "Cari" dengan mengisikan nama atau
                            NIK penduduk tersebut. Jika ada perubahan status, perbarui saat itu juga
                            berdasarkan laporan penduduk yang bersangkutan. Jika penduduk tersebut
                            belum terdaftar dalam database, masukkan data penduduk yang bersangkutan
                            ke dalam SID merujuk pada dokumen kependudukan yang dimilikinya (wajib
                            disertai dengan dokumen pendukung lainnya bagi penduduk
                            pendatang/tinggal sementara). Jika data penduduk tersebut sudah
                            tersimpan dalam SID, pembuatan surat dapat dilakukan.</li>
                        <li>Klik module "Cetak Surat" untuk memulai pembuatan surat.</li>
                        <li>Klik salah satu jenis surat yang akan dibuat, sesuaikan dengan jenis
                            urusan yang diajukan oleh penduduk pemohon surat. Jika jenis surat yang
                            dimohonkan tidak tersedia dalam daftar surat di SID, gunakan jenis surat
                            terakhir yang berjudul "Ubah Sesuaikan".</li>
                        <li>Isikan NIK / Nama, nomor surat, keterangan, dan hal lainnya sesuai kolom
                            isian pada jenis surat yang dibuat.</li>
                        <li>Pilih nama dan jabatan kepala desa atau perangkat desa yang berwenang
                            melakukan pengesahan atas nama kepala desa.</li>
                        <li>Setelah semua kolom terisi dengan benar, surat bisa langsung dicetak
                            dengan klik tombol "Cetak" di bagian kanan bawah, atau bisa diedit lebih
                            lanjut ke versi doc. dengan klik "Export Doc" di bagian kanan bawah.
                        </li>
                        <li>Surat dapat dicetak dua eksemplar, 1 eks. untuk penduduk pemohon surat
                            dan 1 eks. untuk arsip pemerintah desa.</li>
                        <li>Setiap jenis surat yang tercetak akan tersimpan data lognya di Menu
                            "Surat Keluar"</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<!-- Page level plugins -->
<script src="/assets/js/admin/vendors/datatables/DataTables-1.13.8/js/jquery.dataTables.min.js"></script>
<script src="/assets/js/admin/vendors/datatables/DataTables-1.13.8/js/dataTables.bootstrap4.min.js"></script>

<!-- Data table plugins -->
<script src="/assets/js/admin/vendors/datatables/extensions/JSZip-3.10.1/jszip.min.js"></script>
<script src="/assets/js/admin/vendors/datatables/extensions/pdfmake-0.2.7/pdfmake.min.js"></script>
<script src="/assets/js/admin/vendors/datatables/extensions/pdfmake-0.2.7/vfs_fonts.js"></script>
<script src="/assets/js/admin/vendors/datatables/extensions/Buttons-2.4.2/js/dataTables.buttons.min.js"></script>
<script src="/assets/js/admin/vendors/datatables/extensions/Buttons-2.4.2/js/buttons.bootstrap4.min.js"></script>
<script src="/assets/js/admin/vendors/datatables/extensions/Buttons-2.4.2/js/buttons.colVis.min.js"></script>
<script src="/assets/js/admin/vendors/datatables/extensions/Buttons-2.4.2/js/buttons.html5.min.js"></script>
<script src="/assets/js/admin/vendors/datatables/extensions/Buttons-2.4.2/js/buttons.print.min.js"></script>

<!-- Page level custom scripts -->
<script>
    $(document).ready(function() {
        const table = $("#dataTable").DataTable({
            lengthChange: false,
            buttons: [{
                    text: `<i class="fa fa-print" aria-hidden="true"></i>&nbsp;Cetak`,
                    className: "btn-sm",
                    extend: 'collection',
                    buttons: ['csv', 'pdf', 'excel']
                },
                {
                    text: `<i class="fa fa-filter" aria-hidden="true"></i>&nbsp;Preferensi Kolom`,
                    className: "btn-sm",
                    extend: 'colvis'
                }
            ],
        });

        table.buttons().container().appendTo("#dataTable_wrapper .col-md-6:eq(0)");
    });
</script>
<?= $this->endSection(); ?>