<?php
session_start();
include "../koneksi.php";
if (isset($_POST['save'])) {
    $bl = str_replace("'", "''", $_POST['bl_no']);
    $etd = $_POST['etd'];
    $eta = $_POST['eta'];
    $connc = str_replace("'", "''", $_POST['connecting']);
    $tgletd = $_POST['con_etd'];
    $notagihan = $_POST['no_tagihan'];
    $jmltagihan = $_POST['jml_tagihan'];
    $notagihan1 = $_POST['no_tagihan1'];
    $jmltagihan1 = $_POST['jml_tagihan1'];
    $notagihan2 = $_POST['no_tagihan2'];
    $jmltagihan2 = $_POST['jml_tagihan2'];
    $notagihan3 = $_POST['no_tagihan3'];
    $jmltagihan3 = $_POST['jml_tagihan3'];
    $notagihan4 = $_POST['no_tagihan4'];
    $jmltagihan4 = $_POST['jml_tagihan4'];
    $qry = mysql_query("UPDATE tbl_exim SET
	`no_bl`='$bl',
	`tgl_s_f`='$etd',
	`tgl_eta`='$eta',
	`connecting`='$connc',
	`tgl_c`='$tgletd',
	`no_tagihan`='$notagihan',
	`jml_tagihan`='$jmltagihan',
	`no_tagihan1`='$notagihan1',
	`jml_tagihan1`='$jmltagihan1',
	`no_tagihan2`='$notagihan2',
	`jml_tagihan2`='$jmltagihan2',
	`no_tagihan3`='$notagihan3',
	`jml_tagihan3`='$jmltagihan3',
	`no_tagihan4`='$notagihan4',
	`jml_tagihan4`='$jmltagihan4'
	WHERE listno='$_POST[listno]'
	");
    $qry1 = mysql_query("UPDATE tbl_exim_si SET etd='$etd',eta='$eta',etd_conn='$_POST[con_etd]',connecting='$connc' WHERE no_si='$_POST[no_si]'");
    if ($qry) {
        echo "<script>alert('Data has been updated!');window.location='../index1.php?p=Commercial-Invoice';</script>";
    }
}
