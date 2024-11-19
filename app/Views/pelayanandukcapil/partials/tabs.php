<ul class="nav nav-tabs card-header-tabs" id="cardTab" role="tablist">
    <li class="nav-item">
        <a class="nav-link <?= ($activeTab == 'verifikasi-data-pemohon') ? 'active' : '' ?>" id="card-pelayanan-verifikasi-data-tab" href="/admin/verifikasi-data-pemohon">Verifikasi Data</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?= ($activeTab == 'progres-pelayanan') ? 'active' : '' ?>" id="card-progres-pelayanan-tab" href="/admin/progres-pelayanan">Progres Pelayanan</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?= ($activeTab == 'siap-ambil') ? 'active' : '' ?>" id="card-siap-ambil-tab" href="/admin/siap-ambil">Siap Ambil</a>
    </li>
    <!-- <li class="nav-item">
        <a class="nav-link <?= ($activeTab == 'rekap-layanan') ? 'active' : '' ?>" id="card-rekap-layanan-tab" href="/admin/rekap-layanan">Rekap Layanan</a>
    </li> -->
</ul>