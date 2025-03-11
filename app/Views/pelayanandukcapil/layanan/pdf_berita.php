<?php

function tanggal_indo($tanggal, $cetak_hari = false)
{
	$hari = array ( 1 =>    'Senin',
				'Selasa',
				'Rabu',
				'Kamis',
				'Jumat',
				'Sabtu',
				'Minggu'
			);
			
	$bulan = array (1 =>   'Januari',
				'Februari',
				'Maret',
				'April',
				'Mei',
				'Juni',
				'Juli',
				'Agustus',
				'September',
				'Oktober',
				'November',
				'Desember'
			);
	$split 	  = explode('-', $tanggal);
	$tgl_indo = $split[0] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[2];
	
	if ($cetak_hari) {
		$num = date('N', strtotime($tanggal));
		return $hari[$num] . ', ' . $tgl_indo;
	}
	return $tgl_indo;
}
$tgl_meninggal = date_format(date_create($master['TGL_MENINGGAL']),"d-m-Y");
$tgl_entri = date_format(date_create($master['TGL_ENTRY']),"d-m-Y");
$tgl_lahir = date_format(date_create($master['TGL_LAHIR']),"d-m-Y");

// dd($tgl_lahir);

  ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Duka Cita Bupati</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="https://smart.gunungkidulkab.go.id/assets/admin-lte/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://smart.gunungkidulkab.go.id/assets/admin-lte/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://smart.gunungkidulkab.go.id/assets/admin-lte/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="https://smart.gunungkidulkab.go.id/assets/admin-lte/dist/css/AdminLTE.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <style type="text/css">

 td{font-family:"Times New Roman";font-size:12pt;padding:5px 5px;}
th{font-family:Arial;font-size:14px;font-weight:normal;padding:10px 5px;}
.wrapper{
z-index=-1;
}
#styledimg {
background-image: url(https://smart.gunungkidulkab.go.id/assets/image/ttd_bupati+cap.png);
background-repeat: no-repeat;
position: absolute;
  left: 180mm;
  top: 140mm;
  width:329px;
  height:248px;
  background-size: contain;
}
</style>
</head>
<body>
<div id="styledimg"></div>
<div class="wrapper">

  <!-- Main content -->
  <div class="row">

<!-- TABEL UNTUK HEADER -->


<table border="0" width="100%" >
<tr><td align="center"><br><br></td></tr>
      <tr><td align="center"><img src="https://smart.gunungkidulkab.go.id/assets/image/logo_kab_gunkid.png" alt="logo" style="width: 2cm"></td></tr>
      <tr><td align="center"><p class="kop-atas">PEMERINTAH KABUPATEN GUNUNGKIDUL</p></td></tr>
       <tr><td align="center"><p class="kop-atas">Mengucapkan</p></td></tr>
        <tr><td align="center"><p class="kop-atas">TURUT BERDUKA CITA</p></td></tr>
        <tr><td align="center"><p class="kop-atas">Atas Wafatnya :</p></td></tr>
        <tr><td align="center"><p class="kop-atas"></p></td></tr>
        <tr><td align="center"><p class="kop-atas"><?php echo $master['NAMA_LGKP'];?></p></td></tr>
        <tr><td align="center"><p class="kop-atas"><?php echo ucfirst(strtolower($master['TMPT_LAHIR']));?>, <?php echo tanggal_indo($tgl_lahir, false);?></p></td></tr>
        
        <tr><td align="center"><p class="kop-atas">Pada hari <?php echo tanggal_indo($tgl_meninggal, true);?>, di <?php echo $master['TMPT_MENINGGAL'];?></p></td></tr>
         <tr><td>&nbsp;</td></tr>
         <tr><td>&nbsp;</td></tr>
         <tr><td align="center"><p class="kop-atas">Semoga diampuni segala kesalahan dan diterima segala amal ibadahnya oleh Tuhan Yang Maha Esa,</p><br>
         <p>Serta bagi keluarga yang ditinggalkan diberi kekuatan dan keikhlasan, Aamiin</p></td></tr>
        
      
</table>

<table border=0 width="100%">
<tr><td width="50%">&nbsp;</td><td align="center"><br><br></td></tr>
 <tr><td width="50%">&nbsp;</td><td align="center">Wonosari, <?php echo tanggal_indo($tgl_entri, false);?></td></tr>
 <tr><td width="50%">&nbsp;</td><td align="center">BUPATI GUNUNGKIDUL</td></tr>
 <tr><td width="50%">&nbsp;</td><td align="center"><br><br><br></td></tr>
 <tr><td width="50%">&nbsp;</td><td align="center">SUNARYANTA</td></tr>
</table>
  <!-- /.content -->
</div>
</div>

<!-- ./wrapper -->
</body>
</html>
