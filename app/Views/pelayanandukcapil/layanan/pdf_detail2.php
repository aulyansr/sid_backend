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
    <td colspan=2 valign="top" width="50%" height="20px" align="center">DATA PEMOHON</td>
    <td valign="top" width="50%" height="20px" align="center">CHECKLIST</td>
  </tr>
  <tr>
    <td valign="top" width="8%" style="border-right-color: #fff;">
      NOMOR <br>
      TANGGAL<br>
      NIK   <br>
      NAMA <br>
      ALAMAT <br>
      NO TELP <br>
      PENGAMBILAN<br>
      TANGGAL PENGAMBILAN
    </td>
    <td valign="top" height="120pt" width="52%" style="border-left-color: #fff;">
          <b>:<?php echo $master[0]['NO_PEND'];?></b><br>
          <b>:<?php echo $master[0]['TGL_PEND'];?></b><br>
          <b>:<?php echo $master[0]['NIK'];?></b><br>
          <b>:<?php echo $master[0]['NAMA_PEMOHON'];?></b> <br>
          <b>:<?php echo $master[0]['ALAMAT_PEMOHON'];?></b><br>
          <b>:<?php echo $master[0]['CONTACT_PEMOHON'];?></b><br>
          <b>:<?php echo $master[0]['LOKASI_PENGAMBILAN'];?></b><br>
          <b>:<?php echo $master[0]['DEADLINE'];?></b></td>
    <td valign="top">
     <?php $KET = '';
	  foreach ($detail as $row) {
           $status = ($row['STATUS']==1) ? ' ' : '-' ;
		   
			$KET .= $row['JENIS_DOC'].'-'.$row['KET'].'['.$row['NO_DOC'].']<br>';

        ?>
          [<?php echo $status ?>] [ ] <?php echo  $row['JENIS_DOC'];?> - <?php echo  $row['NAMA_TERMOHON'];?><br>
         
          
      
<?php
      }
      ?>


    </td>
  </tr>
  <tr>
    <td colspan="3" valign="top" width="100%" height="20px" align="center">CATATAN PERMOHONAN<br></td>
  </tr>
  <tr>
    <td colspan="3" valign="top" width="100%" height="130pt" align="left">[CATATAN PENDAFTARAN] <br>
    <p><?php echo $KET;?></p>
  <p><?php echo $master[0]['CATATAN'];?></p></td>
  </tr>
  <tr>
    <td colspan="3" valign="top" width="100%" height="70pt" align="left">[CATATAN OPERATOR/SPV]</td>
  </tr>
  </table>
  <table width="100%">
  
  <tr>
    <td   colspan=3  align="center" valign="top" style="border-left-color: #fff; border-right-color: #fff; border-bottom-color: #fff; padding:5px 0px;"><?php echo $master[0]['PROSES_BY'];?> - Untuk Loket Pengambilan di <?php echo $master[0]['LOKASI_PENGAMBILAN'];?></td>
  </tr>
</table>
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<!-- ./wrapper -->
</body>
</html>
