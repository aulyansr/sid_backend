<div class="pencarian card mb-n5 z-1" id="bx-search">
    <div class="card-body p-5">
        <div class="row gx-5 align-items-center">
            <div class="col-lg-6">
                <h4>Temukan informasi yang anda inginkan!</h4>
                <p class="lead text-gray-500 mb-0">
                    Temukan informasi berupa berita, artikel, pengumuman, atau jenis informasi
                    lainnya dengan pencarian berikut ini
                </p>
            </div>
            <div class="col-lg-6">
                <form action="<?= base_url($village['permalink'] . '/search-articles'); ?>" method="get">
                    <div class="input-group mb-2">
                        <input class="form-control form-control-solid" type="text" name="query" placeholder="Masukkan kata kunci pencarian" aria-label="Recipient's username" aria-describedby="button-addon2" />
                        <button class="btn btn-primary" id="button-addon2" type="submit">
                            Cari
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>