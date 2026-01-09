<?php
    $modal_id=$_GET['id'];
    $modal1=mysql_query("DELETE FROM tbl_exim_sa WHERE id='$modal_id' ");
    if ($modal1) {
        echo "<script>window.location='?p=Shipment-Advice';</script>";
    } else {
        echo "<script>alert('Gagal Hapus');window.location='?p=Shipment-Advice';</script>";
    }
