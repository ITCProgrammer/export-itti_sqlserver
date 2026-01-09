<?php
session_start();
include '../koneksi.php';

if (isset($_POST['save'])) {
    $nosi = str_replace("'", "''", $_POST['no_si']);
    $qry = mysql_query("UPDATE tbl_exim SET
	`no_si`='$nosi'
	WHERE `id`='$_POST[id]'
	");
    if ($qry) {
        echo "<script>alert('Data has been updated!');window.location='../index1.php?p=commercial-invoice';</script>";
    }
}
