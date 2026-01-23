<?php
session_start();
include '../koneksi.php';

$datastk1 = sqlsrv_query($con,"UPDATE db_qc.detail_pergerakan_stok SET refno=NULL , lott = NULL , pack = NULL WHERE id ='".$_POST['pk']."'");

if ($datastk1) {
    $json_data = array(
        'kode' => 505,
        'msg' => 'Berhasil hapus data !'
    );
} else {
    $json_data = array(
        'kode' => 404,
        'msg' => 'Gagal hapus Data !'
    );
}

echo json_encode($json_data);
