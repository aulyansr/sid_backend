<?= $this->extend('layout/dashboard'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800 text-center">Form Pengguna</h1>
    <form action="<?= site_url('/admin/users/update'); ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field(); ?>
        <div class="row justify-content-center">
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-header">Foto Pengguna</div>
                    <div class="card-body">
                        <?php if ($user->foto) : ?>
                            <input id="inputFoto" name="foto" type="file" class="dropify" accept="image/*" data-default-file="<?= base_url(esc($user->foto)); ?>">
                        <?php else : ?>
                            <input id="inputFoto" name="foto" type="file" class="dropify" accept="image/*">
                        <?php endif; ?>
                    </div>

                </div>
            </div>
            <div class="col-xl-8">
                <!-- Account details card -->
                <div class="card mb-4">
                    <div class="card-header">Detail Pengguna</div>
                    <div class="card-body">
                        <!-- Hidden field for user ID -->
                        <input type="hidden" name="id" value="<?= esc($user->id); ?>">

                        <!-- Form Row -->
                        <div class="row gx-3 mb-3">
                            <!-- Form Group (full name) -->
                            <div class="col-md-6 mb-3">
                                <label class="small mb-1" for="inputFullName">Nama Lengkap</label>
                                <input class="form-control" id="inputFullName" name="nama" type="text" placeholder="Nama Lengkap" value="<?= old('nama', $user->nama); ?>" required>
                            </div>
                            <!-- Form Group (username) -->
                            <div class="col-md-6 mb-3">
                                <label class="small mb-1" for="inputUsername">Username</label>
                                <input class="form-control" id="inputUsername" name="username" type="text" placeholder="Username" value="<?= old('username', $user->username); ?>" required>
                            </div>
                            <!-- Form Group (email) -->
                            <div class="col-md-6 mb-3">
                                <label class="small mb-1" for="inputEmail">Email</label>
                                <input class="form-control" id="inputEmail" name="email" type="email" placeholder="Email Address" value="<?= old('email', $user->email); ?>" required>
                            </div>

                            <!-- Form Group (phone) -->
                            <div class="col-md-6 mb-3">
                                <label class="small mb-1" for="inputPhone">Phone</label>
                                <input class="form-control" id="inputPhone" name="phone" type="text" placeholder="Phone Number" value="<?= old('phone', $user->phone); ?>">
                            </div>


                            <!-- Form Group (password) -->
                            <div class="col-md-6 mb-3">
                                <label class="small mb-1" for="inputPassword">Password</label>
                                <input class="form-control" id="inputPassword" name="password" type="password" placeholder="Password">
                            </div>
                            <!-- Form Group (password confirmation) -->
                            <div class="col-md-6 mb-3">
                                <label class="small mb-1" for="inputPasswordConfirmation">Confirm Password</label>
                                <input class="form-control" id="inputPasswordConfirmation" name="password_confirmation" type="password" placeholder="Confirm Password">
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="small mb-1" for="inputdesa">Pilih Desa</label>
                                <select class="form-control select2" id="inputdesa" name="desa_id">
                                    <option value="">Pilih</option>
                                    <?php foreach ($desaList as $desa): ?>
                                        <option value="<?= esc($desa['id']); ?>" <?= (old('desa_id', isset($user) ? esc($user->desa_id) : '') == esc($desa['id'])) ? 'selected' : ''; ?>>
                                            <?= esc($desa['nama_desa']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                        </div>

                        <!-- Form Group (user group) -->
                        <div class="mb-3">
                            <label class="small mb-1" for="inputGroup">User Group</label>
                            <br>
                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                <?php foreach ($groups as $key => $group): ?>
                                    <?php if ($key !== 'superadmin') :     // Sembunyikan superadmin 
                                    ?>
                                        <label class="btn btn-sm btn-outline-primary">
                                            <input type="radio" name="group" value="<?= esc($key); ?>" id="group_<?= esc($key); ?>">
                                            <?php
                                            // Ubah label sesuai dengan kondisi
                                            if ($key === 'op_desa') {
                                                echo 'operator_web';
                                            } elseif ($key === 'op_kabupaten') {
                                                echo 'operator_layanan';
                                            } else {
                                                echo esc($group['title']);
                                            }
                                            ?>
                                        </label>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>


                            <!-- Submit button -->
                            <button class="btn btn-primary" type="submit">Update Pengguna</button>

                        </div>
                    </div>
                </div>
            </div>
    </form>
</div>
<?= $this->endSection(); ?>
<?= $this->section('script'); ?>
<script>
    $('.dropify').dropify();
</script>
<?= $this->endSection(); ?>