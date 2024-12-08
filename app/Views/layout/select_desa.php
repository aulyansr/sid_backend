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

<body>
    <div id="layoutDefault">
        <div id="layoutDefault_content">
            <main>
                <div class="container">
                    <!-- Sub Navbar -->

                    <div class="text-center" style="margin-top:25vh">
                        <h1 class="mb-5">
                            Pilih Desa
                        </h1>
                        <div class="row g-4 justify-content-center mb-5">
                            <?php foreach ($villages as $index => $village): ?>


                                <div class="col-md-4">
                                    <a href="/<?= $village['permalink']; ?>">
                                        <div class="card">
                                            <div class="card-body">
                                                <h2>
                                                    <?= $village['nama_desa']; ?>
                                                </h2>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

            </main>
        </div>

        <div id="layoutDefault_footer">
            <footer class="footer pt-5 pb-5 mt-auto bg-dark footer-dark">
                <div class="container px-5">

                    <div class="row gx-5 align-items-center">
                        <div class="col-md-6 small">
                            Copyright &copy;
                            <script>
                                document.write(new Date().getFullYear());
                            </script>. Sistem Informasi Desa (SID)

                        </div>
                        <div class="col-md-6 text-md-end small">
                            <a href="privasi.html">Kebijakan Privasi</a>
                            &middot;
                            <a href="ketentuan.html">Syarat &amp; Ketentuan</a>
                            &middot;
                            <a href="tentang-sid.html">Tentang &amp; SID</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="/assets/js/public/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js" integrity="sha512-d9xgZrVZpmmQlfonhQUvTR7lMPtO7NkZMkA0ABN3PHCbKA5nqylQ/yWlFAyY6hYgdF1Qh6nYiuADWwKB4C2WSw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <?php $this->renderSection('script'); ?>
</body>

</html>