<?php
session_start();
include '../koneksi.php';
$qryfwd = mysqli_query($con,"SELECT * FROM tbl_exim_forwarder WHERE `nama`='".$_POST['fwd']."' limit 1");
$rf = mysqli_fetch_assoc($qryfwd);
$count = mysqli_num_rows($qryfwd);

if ($count > 0) {
    $data = array(
        'kode' => '200',
        'data' => $rf
    );
} else {
    $data = array(
        'kode' => '505',
        'data' => ''
    );
}

echo json_encode($data);
