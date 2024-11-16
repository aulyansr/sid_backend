<ul class="nav nav-tabs card-header-tabs" id="cardTab" role="tablist">
    <li class="nav-item">
        <a class="nav-link <?= ($activeTab == 'settings') ? 'active' : '' ?>" id="card-artikel-tab" href="/admin/analisis_master/<?= $analisis_master['id'] ?>/kategori-indikators">PENGATURAN ANALISIS</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?= ($activeTab == 'input') ? 'active' : '' ?>" id="card-menu-statis-tab" href="/admin/analisis_master/<?= $analisis_master['id'] ?>/subjects">INPUT DATA ANALISIS</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?= ($activeTab == 'report') ? 'active' : '' ?>" id="card-menu-dinamis-tab" href="/admin/analisis_master/<?= $analisis_master['id'] ?>/laporan">LAPORAN ANALISIS</a>
    </li>
</ul>