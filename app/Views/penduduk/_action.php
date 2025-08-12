<div class="btn-group">
    <a href="<?= base_url('admin/penduduk/' . esc($penduduk['id'])); ?>" class="btn btn-sm btn-primary">
        <i class="fa fa-eye"></i> Rincian
    </a>
    <a href="<?= base_url('admin/penduduk/' . esc($penduduk['id']) . '/edit'); ?>" class="btn btn-sm btn-warning">
        <i class="fa fa-edit"></i> Ubah
    </a>
    <form action="<?= base_url('admin/penduduk/' . esc($penduduk['id'])); ?>" method="post" style="display:inline;">
        <input type="hidden" name="_method" value="DELETE">
        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
            <i class="fa fa-trash"></i> Hapus
        </button>
    </form>
</div>