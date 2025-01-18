<?php

if (!function_exists('lokasi_pengambilan')) {
    function lokasi_pengambilan($params)
    {
        $data = [
            '00' => 'Mall Pelayanan Publik',
            '19' => 'Dinas Dukcapil Gunungkidul',
            '1' => 'Kapanewon Wonosari',
            '2' => 'Kapanewon Nglipar',
            '3' => 'Kapanewon Playen',
            '4' => 'Kapanewon Patuk',
            '5' => 'Kapanewon Paliyan',
            '6' => 'Kapanewon Panggang',
            '7' => 'Kapanewon Tepus',
            '8' => 'Kapanewon Semanu',
            '9' => 'Kapanewon Karangmojo',
            '10' => 'Kapanewon Ponjong',
            '11' => 'Kapanewon Rongkop',
            '12' => 'Kapanewon Semin',
            '13' => 'Kapanewon Ngawen',
            '14' => 'Kapanewon Gedangsari',
            '15' => 'Kapanewon Saptosari',
            '16' => 'Kapanewon Girisubo',
            '17' => 'Kapanewon Tanjungsari',
            '18' => 'Kapanewon Purwosari',
        ];

        return $data[$params] ?? 'NULL';
    }
}