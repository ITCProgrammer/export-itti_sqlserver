<?php
session_start();
include '../koneksi.php';
if (isset($_POST['save']) == 'save') {
    $peb = str_replace("'", "''", $_POST['no_peb']);
    $tglpeb = $_POST['tgl_peb'];
    $npe = $_POST['npe'];
    $sj = str_replace("'", "''", $_POST['no_sj']);
    $tglsj = $_POST['tgl_sj'];
    $no_cont = str_replace("'", "''", $_POST['no_container']);
    $wh = $_POST['werehouse'];

    mysqli_query($con,"UPDATE tbl_exim SET
	`no_peb`='$peb',
	`tgl_peb`='$tglpeb',
	`npe`='$npe',
	`no_sj`='$sj',
	`tgl_sj`='$tglsj',
	`no_cont`='$no_cont'
	WHERE listno='".$_POST['no']."'");

    $json_data = array(
        "kode" => 200,
        "msg" => 'Data Berhasil di Update !'
    );
} else {
    $json_data = array(
        "kode" => 404,
        "msg" => 'Data gagal di Update !'
    );
}
echo json_encode($json_data);
