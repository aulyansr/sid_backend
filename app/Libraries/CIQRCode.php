<?php

namespace App\Libraries;

// Load library phpqrcode
require_once APPPATH . 'Libraries/phpqrcode.php'; //saya ubah di server dari \ ke /
class CIQRCode
{
    public function generate($params = [])
    {
        // Validasi parameter
        $data = $params['data'] ?? 'No data provided';
        $level = $params['level'] ?? 'L'; // Tingkat error correction (L, M, Q, H)
        $size = $params['size'] ?? 4;     // Ukuran QR Code
        $savename = $params['savename'] ?? ''; // Lokasi penyimpanan

        if (!empty($savename)) {
            // Simpan QR Code ke file
            \QRcode::png($data, $savename, $level, $size);
        } else {
            // Tampilkan QR Code langsung di browser
            \QRcode::png($data, null, $level, $size);
        }
    }
}
