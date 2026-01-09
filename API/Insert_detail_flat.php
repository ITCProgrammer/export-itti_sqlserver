<?php
session_start();
include '../koneksi.php';

$po = str_replace("'", "''", $_POST[no_po]);
$desc1 = str_replace("'", "''", $_POST[desc1]);
$desc2 = str_replace("'", "''", $_POST[desc2]);
$sql = mysql_query("INSERT INTO `tbl_exim_detail` SET
	`id_list`='$_POST[id]',
	`no_order`='$_POST[dono]',
	`no_po`='$po',
	`no_item`='$_POST[item]',
	`deskripsi`='$desc1',
	`deskripsi2`='$desc2',
	`warna`='$_POST[warna]',
	`unit_price`='$_POST[unit]',
	`price_by`='$_POST[price_by]',
	`tgl_update`=now()");

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
