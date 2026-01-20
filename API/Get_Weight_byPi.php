<?php
session_start();
include '../koneksi.php';

$sqlpi1 = sqlsrv_query($con,"SELECT * FROM tbl_exim_pi_detail WHERE id='".$_POST['pi']."' ");
$rpi1 = sqlsrv_fetch_array($sqlpi1);
$count = sqlsrv_num_rows($sqlpi1);

if ($count > 0) {
    $json_data = array(
        "data"            => $rpi1['qty'],
        "msg"             => 505
    );
} else {
    $json_data = array(
        "data"            => '',
        "msg"             => 404
    );
}
echo json_encode($json_data);
