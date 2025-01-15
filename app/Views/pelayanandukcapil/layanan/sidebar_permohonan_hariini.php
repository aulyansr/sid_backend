<div class="card shadow mb-3 col-md-3">
            <div class="card-header border-bottom">
                Permohonan Hari ini
            </div>
            <div class="card-body">
                <form>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped compact" width="100%" cellspacing="0">
                            <tbody>
                            <?php foreach ($permHarIn as $key): ?>
                                <tr>
                                    <td>
                                        <a class="btn btn-success btn-sm text-xs" data-title="Print" target="_blank" href="<?= site_url('admin/verifikasi-cetak/');?><?= $key['NOMER']; ?>"><i class="fa fa-print"></i>&nbsp;<?= $key['NO_PEND']; ?></a>
                                    </td>
                                    <td class="text-xs"><?= $key['NAMA_PEMOHON']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </div>