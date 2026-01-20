<?php
    $modal_id=$_GET['id'];
    $modal1=sqlsrv_query($con,"DELETE FROM tbl_exim_pim WHERE id='$modal_id' ");
	$modal2=sqlsrv_query($con,"DELETE FROM tbl_exim_pim_detail WHERE id_pi='$modal_id' ");
    if ($modal1) {
        echo "<script>window.location='?p=Proforma-Invoice-Manual';</script>";
    } else {
        echo "<script>alert('Gagal Hapus');window.location='?p=Proforma-Invoice-Manual';</script>";
    }
