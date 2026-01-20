<?php
if($_POST){ 
	extract($_POST);
	$id = str_replace("'","''",$_POST['id']);
	$nama = str_replace("'","''",$_POST['nama']); 
	$alamat = str_replace("'","''",$_POST['alamat']);   
    $pic = str_replace("'","''",$_POST['pic']);
	$email = str_replace("'","''",$_POST['email']);
    $ket = str_replace("'","''",$_POST['ket']);
				$sqlupdate=sqlsrv_query($con,"UPDATE `tbl_exim_forwarder` SET 
				`nama`='$nama',
				`alamat`='$alamat',
				`pic`='$pic',
				`email`='$email',
				`keterangan`='$ket',
				`tgl_update`=now()
				WHERE `id`='$id' LIMIT 1");
				echo " <script>window.location='?p=Forwarder';</script>";
				
		}
		

?>
