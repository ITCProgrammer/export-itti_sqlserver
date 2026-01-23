<?php
session_start();
include '../koneksi.php';

$po = str_replace("'", "''", $_POST['no_po']);
$desc1 = str_replace("'", "''", $_POST['desc1']);
$desc2 = str_replace("'", "''", $_POST['desc2']);
$sql = sqlsrv_query($con, "INSERT INTO db_qc.tbl_exim_detail (
		id_list, 
		no_order, 
		no_po, 
		no_item, 
		deskripsi, 
		deskripsi2, 
		warna, 
		unit_price, 
		price_by, 
		tgl_update
	)
	VALUES (
		'$_POST[id]', 
		'$_POST[dono]', 
		'$po', 
		'$_POST[item]', 
		'$desc1', 
		'$desc2', 
		'$_POST[warna]', 
		'$_POST[unit]', 
		'$_POST[price_by]', 
		GETDATE()
	)");

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
