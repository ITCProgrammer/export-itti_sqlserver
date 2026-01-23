<?php
session_start();
include '../koneksi.php';

$dono = strtoupper($_POST[dono]);
$po = str_replace("'", "''", $_POST[po]);
$style = str_replace("'", "''", $_POST[style]);
$desc1 = str_replace("'", "''", $_POST[desc1]);
$desc2 = str_replace("'", "''", $_POST[desc2]);
$sql = sqlsrv_query("INSERT INTO db_qc.tbl_exim_detail SET
	id_list='$_POST[id]',
	id_pid='$_POST[id_pi]',
	no_order='$dono',
	no_po='$po',
	no_item='$_POST[no_item]',
	deskripsi='$desc1',
	deskripsi2='$desc2',
	style='$style',
	weight='$_POST[weight]',
	warna='$_POST[warna]',
	unit_price='$_POST[unit]',
	price_by='$_POST[price_by]',
    tgl_update=GETDATE()");

if ($sql) {
    $json_data = array(
        'kode' => 505,
        'msg' => 'Berhasil insert data !'
    );
} else {
    $json_data = array(
        'kode' => 404,
        'msg' => 'Gagal insert Data !'
    );
}

echo json_encode($json_data);
