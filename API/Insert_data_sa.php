<?php
session_start();
include '../koneksi.php';
if (isset($_POST['save']) == 'save') {
    mysql_query("UPDATE tbl_exim SET
	            `no_sa`='$_POST[id]'
	            WHERE listno='$_POST[no]' ");
    mysql_query("UPDATE tbl_exim_sa SET
	                    `no_ci`='$_POST[no]'
	                    WHERE no_sa='$_POST[id]' ");
    $data = array(
        'kode' => 200,
        'msg' => 'data berhasil di input !'
    );
} else {
    $data = array(
        'kode' => 404,
        'msg' => 'data gagal di input !'
    );
}

echo json_encode($data);
