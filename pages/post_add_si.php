<?php
session_start();
include "../koneksi.php";
if (isset($_POST['save'])) {
    $tgl = $_POST['tgl_si'];
    $shipper = nl2br(htmlspecialchars(str_replace("'", "''", $_POST['shipper'])));
    $attn = str_replace("'", "''", $_POST['attn']);
    $value = $_POST['inv_value'];
    $merchandise = str_replace("'", "''", $_POST['merchandise']);
    $ci = strtoupper($_POST[no_ci]);
    $qry = mysql_query("INSERT INTO tbl_exim_sa SET
                        `attn`='$attn',
                        `no_ci`='$ci',
                        `tgl`='$tgl',
                        `inv_value`='$value',
                        `merchandise`='$merchandise',
                        `shipper`='$shipper',
                        `no_sa`='$_POST[no_sa]',
                        `author`='$_POST[author]',
                        `tgl_update`=now()
                        ") or die("Gagal simpan");
    $qry1 = mysql_query("UPDATE tbl_exim SET
                        `no_sa`='$_POST[no_sa]'
                        WHERE listno='$_GET[no]'
                        ") or die("Gagal ubah");
    if ($qry) {
        $qry = mysql_query("UPDATE tbl_exim SET
                        `no_sa`='$_POST[no_sa]'
                        WHERE listno='$_POST[no_ci]'
                        ") or die("Gagal ubah");

        echo "<script>alert('Data has been Saved!');window.location='../index1.php?p=commercial-invoice';</script>";
    }
}
