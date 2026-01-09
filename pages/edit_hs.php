<?php
if($_POST){ 
	extract($_POST);
	$id = str_replace("'","''",$_POST['id']);
	$itm = str_replace("'","''",$_POST['item']);   
    $sts = str_replace("'","''",$_POST['sts']); 
    $ket = str_replace("'","''",$_POST['ket']);
				$sqlupdate=mysqli_query($con,"UPDATE `tbl_exim_code` SET 
				`no_item`='$itm',
				`sts`='$sts',
				`ket`='$ket',
				`tgl_update`=now()
				WHERE `id`='$id' LIMIT 1");
				echo " <script>window.location='?p=HS-Code';</script>";
				
		}
		

?>
