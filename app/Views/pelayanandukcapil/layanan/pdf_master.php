<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Tanda Terima Permohonan Pelayanan Dokumen Kependudukan</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <style type="text/css">
    td { 
      font-family:Courier New;
      font-size:12px;
      padding:10px 5px;
      border-style:solid;
      border-width:1px;
      overflow:hidden;
      word-break:normal;
    }
    th {
      font-family:Courier New;
      font-size:14px;
      font-weight:normal;
      padding:10px 5px;
      border-style:solid;
      border-width:1px;
      overflow:hidden;
      word-break:normal;
    }
  </style>
</head>
<body>
<div class="wrapper">
  <!-- Main content -->
  <section class="invoice">
    <!-- title row -->
    <div class="row">
     
<table border=1 width="100%">
  <tr>
    <th colspan="3" align="center" height="60px">DINAS KEPENDUDUKAN DAN PENCATATAN SIPIL<br>KABUPATEN GUNUNGKIDUL<br></th>
    
  </tr>
  <tr>
    <td colspan=2 valign="top" width="75%" height="20px" align="center">DATA PEMOHON</td>
    
    <?php    
    $path = FCPATH . 'qrpelayanan.png';
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path);
    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
    ?>

    <td  rowspan="4" align="center" valign="top" width="25%" ><img style="width: 3cm" src="<?= $base64; ?>" />
          <hr style="margin-bottom:0px">
          <?php echo $master[0]['NO_PEND'];?><br>
          <?php echo $master[0]['TGL_PEND'];?><br><br><br>
          Dokumen dapat di ambil di <?php echo $master[0]['LOKASI_PENGAMBILAN'];?> <br>
          Tanggal : <?php echo $master[0]['DEADLINE'];?> </td>
  </tr>
  <tr style="font-size: 11pt">
    <td valign="top" width="3%" style="border-right-color: #fff;">NIK          <br>
      NAMA <br>
      ALAMAT
    </td>
    <td valign="top" width="57%" style="border-left-color: #fff;">:<?php echo $master[0]['NIK'];?><br>
          :<?php echo $master[0]['NAMA_PEMOHON'];?> <br>
          :<?php echo $master[0]['ALAMAT_PEMOHON'];?></td>
  </tr>
  <tr>
    <td  colspan="2" valign="top" width="60%" height="20px" align="center">JENIS PERMOHONAN</td>
    
  </tr>
  <tr>
    <td  colspan="2" height="150pt" align="left" valign="top">
     <?php foreach ($detail as $row) {
                
        ?>
         <?php echo  $row['NO'];?>.<?php echo  $row['JENIS_DOC'];?> - <?php echo  $row['NAMA_TERMOHON'];?> <br>
          
        <?php
      }
      ?>



    </td>
    <tr>
    
    <td  colspan=3 valign="top" height="20px" align="center">CATATAN</td>
  </tr>
  <tr>
    <td   colspan=3 height="55pt" align="left" valign="top"><p><?php echo $master[0]['CATATAN'];?></p></td>
  </tr>
  <tr>
    <td   colspan=3  align="center" valign="top" style="border-left-color: #fff; border-right-color: #fff; border-bottom-color: #fff; padding:5px 0px;">Untuk pemohon sebagai bukti pengambilan </td>
  </tr>

  
  
</table>

    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<!-- ./wrapper -->

