<?php
session_start();
include '../koneksi.php';
$sqlcek = mysqli_query($con,"SELECT * FROM tbl_exim_si WHERE no_si='".$_POST['si']."' LIMIT 1");
$row = mysqli_fetch_array($sqlcek);
$count = mysqli_num_rows($sqlcek);

if ($count > 0) {
    $fetch = array(
        'kode' => 200,
        'descr' => $row['descr'],
        'nw' => $row['nw'],
        'meas' => $row['meas'],
    );
} else {
    $fetch = array(
        'kode' => 404,
        'data' => ''
    );
}

echo json_encode($fetch);
