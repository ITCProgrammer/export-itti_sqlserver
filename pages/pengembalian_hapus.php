<?php
    $modal_id=$_GET['id'];
	$dci=$_GET['DCI'];
	$idp=$_GET['idp'];
    $modal1=sqlsrv_query($con,"DELETE FROM tbl_exim_pengembalian WHERE id='$modal_id' ");
    if ($modal1) {
        echo "<script>window.location='?p=Form-Tambah-Pengembalian&DCI=$dci&id=$idp';</script>";
    } else {
        echo "<script>alert('Gagal Hapus');window.location='?p=Form-Tambah-Pengembalian&DCI=$dci&id=$idp';</script>";
    }
