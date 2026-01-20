<?php
    $modal_id=$_GET['id'];
    $modal1=sqlsrv_query($con,"DELETE FROM tbl_exim_cim WHERE id='$modal_id' ");
    if ($modal1) {
        echo "<script>window.location='?p=Commercial-Invoice-Manual';</script>";
    } else {
        echo "<script>alert('Gagal Hapus');window.location='?p=Commercial-Invoice-Manual';</script>";
    }
