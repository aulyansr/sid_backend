<?php

declare(strict_types=1);

/**
 * This file is part of CodeIgniter Shield.
 *
 * (c) CodeIgniter Foundation <admin@codeigniter.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Config;

use CodeIgniter\Shield\Config\AuthGroups as ShieldAuthGroups;

class AuthGroups extends ShieldAuthGroups
{
    /**
     * --------------------------------------------------------------------
     * Default Group
     * --------------------------------------------------------------------
     * The group that a newly registered user is added to.
     */
    public string $defaultGroup = 'superadmin';

    /**
     * --------------------------------------------------------------------
     * Groups
     * --------------------------------------------------------------------
     * An associative array of the available groups in the system, where the keys
     * are the group names and the values are arrays of the group info.
     *
     * Whatever value you assign as the key will be used to refer to the group
     * when using functions such as:
     *      $user->addGroup('superadmin');
     *
     * @var array<string, array<string, string>>
     *
     * @see https://codeigniter4.github.io/shield/quick_start_guide/using_authorization/#change-available-groups for more info
     */
    public array $groups = [
        'superadmin' => [
            'title'       => 'Super Admin',
            'description' => 'Complete control of the site.',
        ],
        'admin' => [
            'title'       => 'Admin',
            'description' => 'Day to day administrators of the site.',
        ],
        'op_desa' => [
            'title'       => 'Operator Desa',
            'description' => 'Operator oleh Pejabat Desa',
        ],
        'op_kabupaten' => [
            'title'       => 'Operator Kabupaten',
            'description' => 'Operator oleh Pejabat Kabupaten',
        ],

    ];

    /**
     * --------------------------------------------------------------------
     * Permissions
     * --------------------------------------------------------------------
     * The available permissions in the system.
     *
     * If a permission is not listed here it cannot be used.
     */
    public array $permissions = [
        // CRUD operations for Users
        'users.access' => 'Akses User',
        'users.create' => 'Dapat membuat User',
        'users.read'   => 'Dapat melihat User',
        'users.update' => 'Dapat memperbarui User',
        'users.delete' => 'Dapat menghapus User',
        'users.permission' => 'Dapat mengatur izin User',

        // CRUD operations for Articles
        'articles.access' => 'Akses Artikel',
        'articles.create' => 'Dapat membuat Artikel',
        'articles.read'   => 'Dapat melihat Artikel',
        'articles.update' => 'Dapat memperbarui Artikel',
        'articles.delete' => 'Dapat menghapus Artikel',

        // CRUD operations for Gallery
        'galleries.access' => 'Akses Galeri',
        'galleries.create' => 'Dapat membuat Galeri',
        'galleries.read'   => 'Dapat melihat Galeri',
        'galleries.update' => 'Dapat memperbarui Galeri',
        'galleries.delete' => 'Dapat menghapus Galeri',

        // CRUD operations for Menus
        'menus.access' => 'Akses Menu',
        'menus.create' => 'Dapat membuat Menu',
        'menus.read'   => 'Dapat melihat Menu',
        'menus.update' => 'Dapat memperbarui Menu',
        'menus.delete' => 'Dapat menghapus Menu',

        'comments.moderation ' => 'Moderasi Komentar',
        'kelurahan.access'  => 'Akses Data kelurahan'
    ];


    /**
     * --------------------------------------------------------------------
     * Permissions Matrix
     * --------------------------------------------------------------------
     * Maps permissions to groups.
     *
     * This defines group-level permissions.
     */
    public array $matrix = [
        'superadmin' => [
            'articles.*',
            'galleries.*',
            'menus.*',
            'config.*',
            'users.*',
        ],


    ];
}
