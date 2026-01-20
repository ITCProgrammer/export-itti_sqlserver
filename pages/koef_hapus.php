<?php
    $modal_id=$_GET['id'];
    $modal1=sqlsrv_query($con,"DELETE FROM tk_konv_hdr_temp WHERE ID_KONV='$modal_id' ");			
			sqlsrv_query($con,"DELETE FROM tk_konv_imp_temp WHERE KD_KONV_EKS like '$modal_id%'");
			sqlsrv_query($con,"DELETE FROM tk_konv_eks_temp WHERE ID_KONV = '$modal_id'");
			
    if ($modal1) {
        echo "<script>window.location='?p=Import-Konversi';</script>";
    } else {
        echo "<script>alert('Gagal Hapus');window.location='?p=Import-Konversi';</script>";
    }
