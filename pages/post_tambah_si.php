<?php
session_start();
include '../koneksi.php';
if (isset($_POST['save'])) {
    $nosi = str_replace("'", "''", $_POST['no_si']);
    $tgl_si = $_POST[tgl_si];
    $forwarder = str_replace("'", "''", $_POST['forwarder']);
    $pic = str_replace("'", "''", $_POST['pic']);
    $email = str_replace("'", "''", $_POST['email']);
    $deskripsi = str_replace("'", "''", $_POST['deskripsi']);
    $status = $_POST['status'];
    $gw = $_POST['gw'];
    $nw = $_POST['nw'];
    $meas = $_POST['meas'];
    $vassel = $_POST['vassel'];
    $etd = $_POST['etd'];
    $eta = $_POST['eta'];
    $connecting = $_POST['connecting'];
    $etdconn = $_POST['etd_con'];
    $dest = $_POST['destinasi'];
    $freight = $_POST['freight'];
    $remark = nl2br(htmlspecialchars($_POST['remark']));
    $author = $_POST['author'];
    $fasilitas = $_POST['fasilitas'];
    $warehouse = $_POST['warehouse'];
    $author = $_POST['author'];
    $qry = mysql_query("INSERT INTO tbl_exim_si SET
	`no_si`='$nosi',
	`tgl_si`='$tgl_si',
	`forwarder`='$forwarder',
	`pic`='$pic',
	`email`='$email',
	`descr`='$deskripsi',
	`status`='$status',
	`gw`='$gw',
	`nw`='$nw',
	`meas`='$meas',
	`vessel`='$vassel',
	`etd`='$etd',
	`eta`='$eta',
	`connecting`='$connecting',
	`etd_conn`='$etdconn',
	`freight`='$freight',
	`remark`='$remark',
	`destinasi`='$dest',
	`fasilitas`='$fasilitas',
	`warehouse`='$warehouse',
	`author`='$author',
	`tgl_update`=now()
	");
    $sqlsi = mysql_query("UPDATE tbl_exim SET
	no_si='$_POST[no_si]' WHERE listno='$_POST[no_inv]'");
    if ($qry) {
        echo "<script>alert('Data has been saved!');window.location='../index1.php?p=commercial-invoice';</script>";
    }
}
