<?php
session_start();
include '../koneksi.php';

$sql = sqlsrv_query($con, "SELECT alamat FROM db_qc.tbl_exim_buyer WHERE nama='".$_POST['buyer']."' ");
$data = sqlsrv_fetch_array($sql);
echo json_encode($data);
