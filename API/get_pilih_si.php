<?php
session_start();
include '../koneksi.php';

if ($_POST['no'] != "") {
    $where = " no_si='".$_POST['no']."' ";
} else {
    $where = " id='".$_POST['id']."' ";
}
$sqlcek = sqlsrv_query($con,"SELECT * FROM tbl_exim_si WHERE $where LIMIT 1");
$row = sqlsrv_fetch_array($sqlcek);
$count = sqlsrv_num_rows($sqlcek);

if ($count > 0) {
    $data = array(
        'kode' => 200,
        'data' => $row
    );
} else {
    $data = array(
        'kode' => 505,
        'data' => ''
    );
}

echo json_encode($data);
