<?php
session_start();
include '../koneksi.php';

$dono = strtoupper($_POST['dono']);
$po = str_replace("'", "''", $_POST[po]);
$style = str_replace("'", "''", $_POST[style]);
$desc1 = str_replace("'", "''", $_POST[desc1]);
$desc2 = str_replace("'", "''", $_POST[desc2]);
$sql = sqlsrv_query($con, "INSERT INTO db_qc.tbl_exim_detail (
    id_list, 
    id_pid, 
    no_order, 
    no_po, 
    no_item, 
    deskripsi, 
    deskripsi2, 
    style, 
    weight, 
    warna, 
    unit_price, 
    price_by, 
    tgl_update
) 
VALUES (
    '$_POST[id]', 
    '$_POST[id_pi]', 
    '$dono', 
    '$po', 
    '$_POST[no_item]', 
    '$desc1', 
    '$desc2', 
    '$style', 
    '$_POST[weight]', 
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
