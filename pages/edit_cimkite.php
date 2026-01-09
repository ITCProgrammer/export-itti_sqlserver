<?php
if($_POST){ 
	extract($_POST);
	$id = mysql_real_escape_string($_POST['id']);
	$lhpre = mysql_real_escape_string($_POST['no_lhpre']);	
	$tgl=mysql_real_escape_string($_POST['tgl_lhpre']);
	if($tgl!=""){
		$stgl=" `tgl_lhpre`='$tgl', ";
	}else{ $stgl=" `tgl_lhpre`=null, ";}
				$sqlupdate=mysql_query("UPDATE `tbl_exim_cim` SET 
				$stgl
				`no_lhpre`='$lhpre'				
				WHERE `id`='$id' LIMIT 1");
				echo " <script>window.location='?p=PEB-Kite';</script>";
				
		}
		

?>
