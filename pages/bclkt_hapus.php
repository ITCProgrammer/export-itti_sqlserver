<?php
    $modal_id=$_GET['id'];
    $modal1=mysql_query("DELETE FROM `tbl_exim_bclkt` WHERE id='$modal_id' ");
    if ($modal1) {
        echo "<script>window.location='?p=Data-BCLKT';</script>";
    } else {
        echo "<script>alert('Gagal Hapus');window.location='?p=Data-BCLKT';</script>";
    }
