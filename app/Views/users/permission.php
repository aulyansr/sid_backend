<?= $this->extend('layout/dashboard'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800 text-center">Form Pengguna</h1>
    <form action="<?= site_url('/admin/users/add-permission/' . $user->id); ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field(); ?>
        <div class="row justify-content-center">

            <div class="col-xl-8">
                <!-- Account details card -->
                <div class="card mb-4">
                    <div class="card-header">Izin Pengguna</div>
                    <div class="card-body">
                        <?php foreach ($permissions as $permissionKey => $permissionLabel): ?>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="permissions[]"
                                    id="permission_<?= $permissionKey; ?>" value="<?= $permissionKey; ?>"
                                    <?= $user->hasPermission($permissionKey) ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="permission_<?= $permissionKey; ?>">
                                    <?= $permissionLabel; ?>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Submit button -->
                    <button class="btn btn-primary" type="submit">Update Pengguna</button>

                </div>
            </div>
        </div>
</div>
</form>

<?= $this->endSection(); ?>
<?= $this->section('script'); ?>

<?= $this->endSection(); ?>