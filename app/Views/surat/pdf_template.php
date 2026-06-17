<?php
$field = static fn(array $data, string $key, string $default = '-') => esc($data[$key] ?? $default);
$jenisSurat = strtoupper(str_replace('_', ' ', (string) ($surat['jenis_surat'] ?? 'surat')));
?>
<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            line-height: 1.55;
            color: #111;
        }

        .kop {
            text-align: center;
            border-bottom: 3px double #111;
            padding-bottom: 10px;
            margin-bottom: 28px;
        }

        .kop h1,
        .kop h2,
        .kop p {
            margin: 0;
        }

        .kop h1 {
            font-size: 17px;
            text-transform: uppercase;
        }

        .kop h2 {
            font-size: 16px;
            text-transform: uppercase;
        }

        .title {
            text-align: center;
            margin-bottom: 22px;
        }

        .title h3 {
            display: inline-block;
            margin: 0 0 4px;
            border-bottom: 1px solid #111;
            font-size: 15px;
            text-transform: uppercase;
        }

        table.detail {
            width: 100%;
            border-collapse: collapse;
            margin: 12px 0 18px;
        }

        table.detail td {
            padding: 3px 0;
            vertical-align: top;
        }

        table.detail td:first-child {
            width: 155px;
        }

        table.detail td:nth-child(2) {
            width: 14px;
            text-align: center;
        }

        .content {
            text-align: justify;
        }

        .signature {
            width: 260px;
            margin-left: auto;
            margin-top: 42px;
            text-align: center;
        }

        .signature .name {
            margin-top: 70px;
            font-weight: bold;
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="kop">
        <h1>PEMERINTAH KABUPATEN <?= $field($desa, 'nama_kabupaten', '') ?></h1>
        <h2>KECAMATAN <?= $field($desa, 'nama_kecamatan', '') ?></h2>
        <h2>DESA <?= $field($desa, 'nama_desa', '') ?></h2>
        <p><?= $field($desa, 'alamat_kantor', '') ?></p>
        <p>Email: <?= $field($desa, 'email_desa', '-') ?></p>
    </div>

    <div class="title">
        <h3><?= esc($jenisSurat) ?></h3>
        <div>Nomor: <?= $field($surat, 'nomor_surat') ?></div>
    </div>

    <div class="content">
        <p>Yang bertanda tangan di bawah ini, Kepala Desa <?= $field($desa, 'nama_desa') ?> Kecamatan <?= $field($desa, 'nama_kecamatan') ?> Kabupaten <?= $field($desa, 'nama_kabupaten') ?>, menerangkan bahwa:</p>

        <table class="detail">
            <tr>
                <td>Nama</td>
                <td>:</td>
                <td><?= $field($penduduk, 'nama') ?></td>
            </tr>
            <tr>
                <td>NIK</td>
                <td>:</td>
                <td><?= $field($penduduk, 'nik', $surat['nik'] ?? '-') ?></td>
            </tr>
            <tr>
                <td>Tempat/Tanggal Lahir</td>
                <td>:</td>
                <td><?= $field($penduduk, 'tempatlahir') ?>, <?= $field($penduduk, 'tanggallahir') ?></td>
            </tr>
            <tr>
                <td>Jenis Kelamin</td>
                <td>:</td>
                <td><?= $field($penduduk, 'sex_nama') ?></td>
            </tr>
            <tr>
                <td>Agama</td>
                <td>:</td>
                <td><?= $field($penduduk, 'agama_nama') ?></td>
            </tr>
            <tr>
                <td>Status Perkawinan</td>
                <td>:</td>
                <td><?= $field($penduduk, 'kawin_nama') ?></td>
            </tr>
            <tr>
                <td>Pekerjaan</td>
                <td>:</td>
                <td><?= $field($penduduk, 'pekerjaan_nama') ?></td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>:</td>
                <td><?= $field($penduduk, 'alamat_sekarang') ?></td>
            </tr>
        </table>

        <p>Surat ini dibuat untuk keperluan: <strong><?= $field($surat, 'keperluan') ?></strong>.</p>
        <p>Demikian surat keterangan ini dibuat dengan sebenarnya untuk dipergunakan sebagaimana mestinya.</p>
    </div>

    <div class="signature">
        <div><?= $field($desa, 'nama_desa') ?>, <?= esc($tanggal ?? date('d-m-Y')) ?></div>
        <div>Kepala Desa <?= $field($desa, 'nama_desa') ?></div>
        <div class="name"><?= $field($desa, 'nama_kepala_desa') ?></div>
    </div>
</body>

</html>
