<?php

if (!function_exists('getAdminUrl')) {
    /**
     * Generate the admin URL based on the session's desa_permalink_admin value and the given path.
     *
     * @param string $path
     * @return string
     */
    function getAdminUrl(string $path): string
    {
        $session = session();
        $desaPermalink = $session->get('desa_permalink_admin');

        if ($desaPermalink) {
            return '/' . $desaPermalink . '/admin/' . $path;
        }

        return '/admin/' . $path;
    }
}
