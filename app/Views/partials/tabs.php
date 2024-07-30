<ul class="nav nav-tabs card-header-tabs" id="cardTab" role="tablist">
    <li class="nav-item">
        <a class="nav-link <?= ($activeTab == 'artikel') ? 'active' : '' ?>" id="card-artikel-tab" href="/admin/artikel">Artikel</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?= ($activeTab == 'menu-statis') ? 'active' : '' ?>" id="card-menu-statis-tab" href="/admin/menu">Menu Statis</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?= ($activeTab == 'kategori') ? 'active' : '' ?>" id="card-menu-dinamis-tab" href="/admin/kategori">Menu Dinamis / Kategori</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?= ($activeTab == 'komentar') ? 'active' : '' ?>" id="card-komentar-tab" href="/admin/komentar">Komentar</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?= ($activeTab == 'gallery') ? 'active' : '' ?>" id="card-gallery-tab" href="/admin/gallery">Gallery</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?= ($activeTab == 'dokumen') ? 'active' : '' ?>" id="card-dokumen-tab" href="/admin/dokumen">Dokumen</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?= ($activeTab == 'media-sosial') ? 'active' : '' ?>" id="card-media-sosial-tab" href="/admin/media_sosial" role="tab">Media Sosial</a>
    </li>
</ul>