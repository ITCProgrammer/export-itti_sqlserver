<?php
session_start();
include '../koneksi.php';

$qry = sqlsrv_query($con,"DELETE FROM db_qc.tbl_exim_detail WHERE id=".$_POST['id']."");
if ($qry) {
    $json_data = array(
        'kode' => 200,
    );
} else {
    $json_data = array(
        'kode' => 404,
    );
}

echo json_encode($json_data);
