<?php
    $modal_id=$_GET['id'];
    $modal1=sqlsrv_query($con,"DELETE FROM db_qc.tbl_exim_forwarder WHERE id='$modal_id' ");
    if ($modal1) {
        echo "<script>window.location='?p=Forwarder';</script>";
    } else {
        echo "<script>alert('Gagal Hapus');window.location='?p=Forwarder';</script>";
    }
