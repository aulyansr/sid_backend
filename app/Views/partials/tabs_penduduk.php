<ul class="nav nav-tabs card-header-tabs" id="cardTab" role="tablist">
    <li class="nav-item">
        <a class="nav-link <?= ($activeTab == 'wilayah') ? 'active' : '' ?>" id="card-artikel-tab" href="/admin/wilayah">Wilayah Administratif</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?= ($activeTab == 'keluarga') ? 'active' : '' ?>" id="card-menu-statis-tab" href="/admin/keluarga">Keluarga</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?= ($activeTab == 'penduduk') ? 'active' : '' ?>" id="card-menu-dinamis-tab" href="/admin/penduduk">Penduduk</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?= ($activeTab == 'rtm') ? 'active' : '' ?>" id="card-komentar-tab" href="/admin/rumah-tangga">Rumah Tangga</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?= ($activeTab == 'kelompok') ? 'active' : '' ?>" id="card-gambar-gallery-tab" href="/admin/kelompok">Kelompok</a>
    </li>

</ul>