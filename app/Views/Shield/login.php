<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title> SID</title>
    <link href="/assets/css/public/styles.css" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.png" />
    <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.29.0/feather.min.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.css" integrity="sha512-/zs32ZEJh+/EO2N1b0PEdoA10JkdC3zJ8L5FTiQu82LR9S/rOQNfQN7U59U9BC12swNeRAz3HSzIL2vpp4fv3w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<?php
$kategoriModel = new \App\Models\KategoriModel();
$desa = new \App\Models\ConfigModel();
$menu = new \App\Models\MenuModel();

$categories = $kategoriModel->orderBy('urut', 'ASC')->findAll();
$desa = $desa->find(1);
$menus = $menu->where('tipe', 1)->findAll();



?>

<body>
    <div id="layoutDefault">
        <div id="layoutDefault_content">
            <main>
                <div class="container d-flex justify-content-center p-5">
                    <div class="card col-12 col-md-5 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title mb-5"><?= lang('Auth.login') ?></h5>

                            <?php if (session()->has('error')): ?>
                                <div class="alert alert-danger">
                                    Unable to log you in. Please check your credentials.
                                </div>
                            <?php endif; ?>


                            <form action="<?= url_to('login') ?>" method="post">
                                <?= csrf_field() ?>

                                <!-- Email -->
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="floatingEmailInput" name="username" inputmode="email" autocomplete="email" placeholder="<?= lang('Auth.email') ?>" value="<?= old('email') ?>" required>
                                    <label for="floatingEmailInput"><?= lang('Auth.username') ?></label>
                                </div>

                                <!-- Password -->
                                <div class="form-floating mb-3">
                                    <input type="password" class="form-control" id="floatingPasswordInput" name="password" inputmode="text" autocomplete="current-password" placeholder="<?= lang('Auth.password') ?>" required>
                                    <label for="floatingPasswordInput"><?= lang('Auth.password') ?></label>
                                </div>

                                <!-- Remember me -->
                                <?php if (setting('Auth.sessionConfig')['allowRemembering']) : ?>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="checkbox" name="remember" class="form-check-input" <?php if (old('remember')) : ?> checked<?php endif ?>>
                                            <?= lang('Auth.rememberMe') ?>
                                        </label>
                                    </div>
                                <?php endif; ?>

                                <div class="d-grid col-12 col-md-8 mx-auto m-3">
                                    <button type="submit" class="btn btn-primary btn-block"><?= lang('Auth.login') ?></button>
                                </div>



                            </form>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="/assets/js/public/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js" integrity="sha512-d9xgZrVZpmmQlfonhQUvTR7lMPtO7NkZMkA0ABN3PHCbKA5nqylQ/yWlFAyY6hYgdF1Qh6nYiuADWwKB4C2WSw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <?php $this->renderSection('script'); ?>
</body>

</html>