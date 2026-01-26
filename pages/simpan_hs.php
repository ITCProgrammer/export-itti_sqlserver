<?php
session_start();
include "../koneksi.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	// Trim and sanitize input
	$hs  = isset($_POST['hscode']) ? trim($_POST['hscode']) : '';
	$itm = isset($_POST['item'])   ? trim($_POST['item'])   : '';
	$sts = isset($_POST['sts'])    ? trim($_POST['sts'])    : '';
	$ket = isset($_POST['ket'])    ? trim($_POST['ket'])    : '';

	$sql = "INSERT INTO db_qc.tbl_exim_code (hs_code, no_item, sts, ket, tgl_update)
	        VALUES (?, ?, ?, ?, GETDATE())";
	$params = [$hs, $itm, $sts, $ket];

	$q = sqlsrv_query($con, $sql, $params);
	if ($q === false) {
		// Show a friendly error and stop if insert fails
		die(print_r(sqlsrv_errors(), true));
	}

	echo "<script>window.location='?p=HS-Code';</script>";
	exit;
}
?>
