<?php
session_start();
include '../koneksi.php';

if ($_POST['update'] == 'UPDATE') {
    $dono = strtoupper($_POST['dono']);
    $po = str_replace("'", "''", $_POST['no_po']);
    $desc1 = str_replace("'", "''", $_POST['desc1']);
    $desc2 = str_replace("'", "''", $_POST['desc2']);
    sqlsrv_query($con,"UPDATE db_qc.tbl_exim_detail SET 
                no_order='$dono',
                no_po='$po',
                no_item='".$_POST['no_item']."',
                deskripsi='$desc1',
                deskripsi2='$desc2',
                warna='".$_POST['warna']."',
                unit_price='".$_POST['unit']."',
                price_by='".$_POST['price_by']."',
                tgl_update=now()
                WHERE id='".$_POST['id']."'
                ");
    $json_data = array(
        "kode" => 200,
        "msg" => "Success, data berhasil di update !"
    );
}

echo json_encode($json_data);
