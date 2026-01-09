<?php
    $modal_id=$_GET['id'];
	$ci=$_GET['ci'];
    $modal1=mysql_query("DELETE FROM tbl_exim_cim_detail WHERE id='$modal_id' ");
    if ($modal1) {
        echo "<script>window.location='?p=Form-Detail-CI-Manual&id=$ci';</script>";
    } else {
        echo "<script>alert('Gagal Hapus');window.location='?p=Form-Detail-CI-Manual&id=$ci';</script>";
    }
