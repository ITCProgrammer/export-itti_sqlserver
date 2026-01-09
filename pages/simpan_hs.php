<?php
if($_POST){ 
	extract($_POST);
	$id = str_replace("'","''",$_POST['id']); 
	$hs = str_replace("'","''",$_POST['hscode']); 
	$itm = str_replace("'","''",$_POST['item']);   
    $sts = str_replace("'","''",$_POST['sts']); 
    $ket = str_replace("'","''",$_POST['ket']);
	$sqlupdate=mysqli_query($con,"INSERT INTO `tbl_exim_code` SET 
				`hs_code`='$hs', 
				`no_item`='$itm',
				`sts`='$sts',
				`ket`='$ket',
				`tgl_update`=now()
				");
				echo " <script>window.location='?p=HS-Code';</script>";
				
		
		}
		

?>