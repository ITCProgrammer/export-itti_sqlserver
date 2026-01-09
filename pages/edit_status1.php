<?php
if ($_POST) {
    extract($_POST);
    $id = mysql_real_escape_string($_POST['id']);
    $sts = mysql_real_escape_string($_POST['status']);
	$sql=mysql_query("SELECT * FROM tbl_exim_pim_detail WHERE `id`='$id'");
	$r=mysql_fetch_array($sql);
	$idr=$r[id_pi];
    $sqlupdate=mysql_query("UPDATE `tbl_exim_pim_detail` SET
				`status`='$sts'
				WHERE `id`='$id' LIMIT 1");
    echo " <script>window.location='?p=PI-Detail-Manual';</script>";
}