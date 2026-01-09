<?php
session_start();
include '../koneksi.php';
$sqldt = mysqli_query($con,"SELECT * FROM tbl_exim_sa WHERE no_sa='".$_POST['id']."'");
$count = mysqli_num_rows($sqldt);
$data = mysqli_fetch_array($sqldt);

if ($data['author'] != "") {
    $author =  $data['author'];
} else {
    $author = ucwords($_SESSION['usernmEX']);
}

if ($count > 0) {
    $fetch = array(
        'kode' => 200,
        'attn' => $data['attn'],
        'tgl' => $data['tgl'],
        'inv_value' => $data['inv_value'],
        'merchandise' => $data['merchandise'],
        'author' => $author
    );
} else {
    $fetch = array(
        'kode' => 404,
        'attn' => $data['attn'],
        'tgl' => $data['tgl'],
        'inv_value' => $data['inv_value'],
        'merchandise' => $data['merchandise'],
        'author' => $author
    );
}

echo json_encode($fetch);
