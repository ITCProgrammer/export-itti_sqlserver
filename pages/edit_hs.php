<?php
session_start();
include "../koneksi.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') { 
	$id  = isset($_POST['id']) ? (int) $_POST['id'] : 0;
	$itm = isset($_POST['item']) ? trim($_POST['item']) : '';
	$sts = isset($_POST['sts']) ? trim($_POST['sts']) : '';
	$ket = isset($_POST['ket']) ? trim($_POST['ket']) : '';
	$hs  = isset($_POST['hscode']) ? trim($_POST['hscode']) : '';

	$sql = "UPDATE db_qc.tbl_exim_code 
	        SET no_item = ?, sts = ?, ket = ?, hs_code = ?, tgl_update = GETDATE()
	        WHERE id = ?";
	$params = [$itm, $sts, $ket, $hs, $id];

	$q = sqlsrv_query($con, $sql, $params);
	if ($q === false) {
		die(print_r(sqlsrv_errors(), true));
	}

	echo "<script>window.location='?p=HS-Code';</script>";
	exit;
}
?>
