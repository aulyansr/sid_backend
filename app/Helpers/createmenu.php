<?php
// Helper function to save articles and menus
private function saveArticlesAndMenus(array $articles, $desa, $parentId, $defaultImagePath)
{
    foreach ($articles as $title => $content) {
        $this->db->table('artikel')->insert([
            'judul'      => $title,
            'isi'        => $content,
            'gambar'     => $defaultImagePath,
            'enabled'    => 1,
            'tgl_upload' => date('Y-m-d H:i:s'),
            'id_kategori'=> 1,
            'headline'   => 1,
            'desa_id'    => $desa['id'],
            'id_user'    => 1,
        ]);

        $articleId = $this->db->insertID();

        $this->db->table('menu')->insert([
            'nama'      => $title,
            'link'      => base_url($desa['permalink'] . '/artikel/' . $articleId),
            'link_tipe' => 0,
            'tipe'      => 0,
            'enabled'   => 1,
            'desa_id'   => $desa['id'],
            'parrent'   => $parentId,
        ]);
    }
}

// Helper function to save a menu and associated articles
private function saveMenuWithArticles($menuName, array $articles, $desa, $defaultImagePath)
{
    $this->db->table('menu')->insert([
        'nama'      => $menuName,
        'link'      => '#',
        'tipe'      => 1,
        'link_tipe' => 1,
        'enabled'   => 1,
        'desa_id'   => $desa['id'],
    ]);

    $menuId = $this->db->insertID();

    $this->saveArticlesAndMenus($articles, $desa, $menuId, $defaultImagePath);
}