<?php
    $modal_id=$_GET['id'];
    $modal1=sqlsrv_query($con,"DELETE FROM `tbl_exim_buyer` WHERE id='$modal_id' ");
    if ($modal1) {
        echo "<script>window.location='?p=Buyer';</script>";
    } else {
        echo "<script>alert('Gagal Hapus');window.location='?p=Buyer';</script>";
    }
