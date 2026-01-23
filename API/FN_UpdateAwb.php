<?php
session_start();
include '../koneksi.php';
if (isset($_POST['save']) == 'SAVE') {
    $ket = str_replace("'", "''", $_POST['ket']);
    $tglkhusus = $_POST['tgl_khusus'];
    $awb = str_replace("'", "''", $_POST['no_awb']);
    $tglawb = $_POST['tgl_awb'];
    $tglmkt = $_POST['tgl_mkt'];
    $qry = sqlsrv_query($con,"UPDATE db_qc.tbl_exim SET
	no_awb='$awb',
	tgl_awb='$tglawb',
	tgl_mkt='$tglmkt',
	tgl_khusus='$tglkhusus',
	ket_awb='$ket'
	WHERE listno='".$_POST['listno']."'
	");

    $json_data = array(
        "kode" => 200,
        "msg" => 'Data Berhasil di Update !'
    );
} else {
    $json_data = array(
        "kode" => 404,
        "msg" => 'Data gagal di Update !'
    );
}
echo json_encode($json_data);
