 <div class="d-block">
     <div class="d-block  my-2">
         <a href="<?= site_url('/admin/analisis_master/' . esc($analisis_master['id']) . '/kategori-indikators'); ?>" class="btn <?= ($activeSideTab == 'kategori') ? 'btn-primary' : 'btn-outline-primary' ?>  w-100 text-left">Kategori/Variabel</a>
     </div>
     <div class="d-block  my-2">
         <a href="<?= site_url('/admin/analisis_master/' . esc($analisis_master['id']) . '/analisis-indikators'); ?>" class="btn <?= ($activeSideTab == 'indikator') ? 'btn-primary' : 'btn-outline-primary' ?>  w-100 text-left">Indikator & Pertanyaan</a>
     </div>
     <div class="d-block  my-2">
         <a href="<?= site_url('/admin/analisis_master/' . esc($analisis_master['id']) . '/analisis-klasifikasi'); ?>" class="btn <?= ($activeSideTab == 'klasifikasi') ? 'btn-primary' : 'btn-outline-primary' ?>  w-100 text-left">Klasifikasi Analisis</a>
     </div>
     <div class="d-block  my-2">
         <a href="<?= site_url('/admin/analisis_master/' . esc($analisis_master['id']) . '/analisis-periode'); ?>" class="btn <?= ($activeSideTab == 'periode') ? 'btn-primary' : 'btn-outline-primary' ?>  w-100 text-left">Periode Analisis</a>
     </div>
 </div>