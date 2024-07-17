<?= $this->extend('layout/dashboard'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800 text-center">Form Pengguna</h1>
    <div class="row justify-content-center">

        <div class="col-xl-8">
            <!-- Account details card-->
            <div class="card mb-4">
                <div class="card-header">Detail Pengguna</div>
                <div class="card-body">
                    <form action="<?= site_url('/admin/users/store'); ?>" method="post">
                        <?= csrf_field(); ?>

                        <!-- Form Row-->
                        <div class="row gx-3 mb-3">
                            <!-- Form Group (full name) -->
                            <div class="col-md-12 mb-3">
                                <label class="small mb-1" for="inputFullName">Nama Lengkap</label>
                                <input class="form-control" id="inputFullName" name="full_name" type="text" placeholder="Nama Lengkap" value="<?= old('full_name'); ?>" required>
                            </div>
                            <!-- Form Group (username) -->
                            <div class="col-md-6 mb-3">
                                <label class="small mb-1" for="inputUsername">Username</label>
                                <input class="form-control" id="inputUsername" name="username" type="text" placeholder="Username" value="<?= old('username'); ?>" required>
                            </div>
                            <!-- Form Group (email) -->
                            <div class="col-md-6 mb-3">
                                <label class="small mb-1" for="inputEmail">Email</label>
                                <input class="form-control" id="inputEmail" name="email" type="email" placeholder="Email Address" value="<?= old('email'); ?>" required>
                            </div>

                            <div class="col-md-6">
                                <label class="small mb-1" for="inputPassword">Password</label>
                                <input class="form-control" id="inputPassword" name="password" type="password" placeholder="Password" required>
                            </div>
                            <!-- Form Group (password confirmation) -->
                            <div class="col-md-6">
                                <label class="small mb-1" for="inputPasswordConfirmation">Confirm Password</label>
                                <input class="form-control" id="inputPasswordConfirmation" name="password_confirmation" type="password" placeholder="Confirm Password" required>
                            </div>

                        </div>

                        <!-- Form Group (user group) -->
                        <div class="mb-3">
                            <label class="small mb-1" for="inputGroup">User Group</label>
                            <br>
                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                <?php foreach ($groups as $key => $group) : ?>
                                    <label class="btn btn-sm btn-outline-primary">
                                        <input type="radio" name="group" value="<?= esc($key); ?>" id="group_<?= esc($key); ?>" <?= old('group') == $key ? 'checked' : ''; ?>> <?= esc($group['title']); ?>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <!-- Submit button-->
                        <button class="btn btn-primary" type="submit">Tambah Pengguna</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>