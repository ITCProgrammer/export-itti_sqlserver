<?php
if ($_POST) {
    extract($_POST);
    $id = $_POST['id'];
    $sts = $_POST['status'];
	$sql=mysqli_query($con,"SELECT * FROM tbl_exim_pim_detail WHERE `id`='$id'");
	$r=mysqli_fetch_array($sql);
	$idr=$r['id_pi'];
    $sqlupdate=mysqli_query($con,"UPDATE `tbl_exim_pim_detail` SET
				`status`='$sts'
				WHERE `id`='$id' LIMIT 1");
    echo " <script>window.location='?p=Detail-PI-Manual&id=$idr';</script>";
}