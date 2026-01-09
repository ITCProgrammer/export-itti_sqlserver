<?php
    $modal_id=$_GET['id'];
    $modal1=mysqli_query($con,"DELETE FROM `tbl_exim_code` WHERE id='$modal_id' ");
    if ($modal1) {
        echo "<script>window.location='?p=HS-Code';</script>";
    } else {
        echo "<script>alert('Gagal Hapus');window.location='?p=HS-Code';</script>";
    }
