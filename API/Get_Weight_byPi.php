<?php
session_start();
include '../koneksi.php';

$sqlpi1 = mysqli_query($con,"SELECT * FROM tbl_exim_pi_detail WHERE id='".$_POST['pi']."' ");
$rpi1 = mysqli_fetch_array($sqlpi1);
$count = mysqli_num_rows($sqlpi1);

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
