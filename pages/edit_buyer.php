<?php
if($_POST){ 
	extract($_POST);
	$id = str_replace("'","''",$_POST['id']);
	$nama = str_replace("'","''",$_POST['nama']); 
	$alamat = str_replace("'","''",$_POST['alamat']);   
    $negara = str_replace("'","''",$_POST['negara']);
	$kode = str_replace("'","''",$_POST['kode']);
    $ket = str_replace("'","''",$_POST['ket']);
				$sqlupdate=mysqli_query($con,"UPDATE `tbl_exim_buyer` SET 
				`nama`='$nama',
				`alamat`='$alamat',
				`negara`='$negara',
				`kode`='$kode',
				`keterangan`='$ket',
				`tgl_update`=now()
				WHERE `id`='$id' LIMIT 1");
				echo " <script>window.location='?p=Buyer';</script>";
				
		}
		

?>
