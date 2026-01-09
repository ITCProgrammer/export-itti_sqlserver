<?php
if($_POST){ 
	extract($_POST);
	$id = mysql_real_escape_string($_POST['id']);
	$urut = mysql_real_escape_string($_POST['urut']);   
    $bcklt = mysql_real_escape_string($_POST['bcklt']);
	$qry3=mysql_query("SELECT id_cim  FROM tbl_exim_cim_detail WHERE id='$id' ORDER BY id ASC");
	$rcek=mysql_fetch_array($qry3);
				$sqlupdate=mysql_query("UPDATE `tbl_exim_cim_detail` SET 
				`no_urut_peb`='$urut',
				`no_bclkt`='$bcklt'
				WHERE `id`='$id' LIMIT 1");
				echo " <script>window.location='?p=Detail-CI-KITE&id=$rcek[id_cim]';</script>";
				
		}
		

?>
