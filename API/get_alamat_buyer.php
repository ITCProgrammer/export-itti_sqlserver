<?php
session_start();
include '../koneksi.php';

$sql = mysqli_query($con,"SELECT alamat FROM `tbl_exim_buyer` WHERE `nama`='".$_POST['buyer']."'");
$data = mysqli_fetch_array($sql);
echo json_encode($data);
