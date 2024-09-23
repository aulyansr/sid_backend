<?php

if (!function_exists('translate_sex')) {
    function translate_sex($sex)
    {
        switch ($sex) {
            case 1:
                return 'Laki-laki';
            case 2:
                return 'Perempuan';
            default:
                return 'Tidak Diketahui';
        }
    }
}
