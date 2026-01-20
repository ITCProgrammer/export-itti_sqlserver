<?php
session_start();
include '../koneksi.php';

if ($_POST['submit'] == 'SAVE' && $_POST['pack'] != "") {
    $cari = sqlsrv_query($con,"Select `id` from `packing_list` where `listno`='".$_POST['no_list']."' limit 1");
    $cek = sqlsrv_num_rows($cari);
    $listno = $_POST['no_list'];
    $ket = "KAIN-EXPORT";
    if ($_POST['dono'] != '') {
        $cwhere2 .= $_POST['dono'];
    } else {
        $cwhere2 .= "null";
    }
    if ($_POST['nopo'] != '') {
        $po = urldecode($_POST['nopo']);
        $cwhere1 .= " AND `tbl_kite`.`no_po`='$po'";
    } else {
        $cwhere1 .= " ";
    }
    if ($_POST['noitem'] != '') {
        $cwhere10 .= " AND `tbl_kite`.`no_item`='".$_POST['noitem']."'";
    } else {
        $cwhere10 .= " ";
    }
    if ($_POST['warna'] != '') {
        $cwhere11 .= " AND `tbl_kite`.`warna`='".$_POST['warna']."'";
    } else {
        $cwhere11 .= " ";
    }
    if ($_POST['lot'] != '') {
        $cwhere12 .= " AND `tbl_kite`.`no_lot`='".$_POST['lot']."'";
    } else {
        $cwhere12 .= " ";
    }
    $qry = sqlsrv_query($con,"SELECT *, detail_pergerakan_stok.id AS kd
        FROM pergerakan_stok
        INNER JOIN detail_pergerakan_stok ON pergerakan_stok.id = detail_pergerakan_stok.id_stok
        INNER JOIN tmp_detail_kite ON tmp_detail_kite.id = detail_pergerakan_stok.id_detail_kj
        INNER JOIN tbl_kite ON tbl_kite.id = tmp_detail_kite.id_kite
        WHERE (detail_pergerakan_stok.sisa !='FKTH' 
                AND detail_pergerakan_stok.sisa !='TH' 
                AND detail_pergerakan_stok.sisa !='SISA' 
                AND typestatus='1'
                AND `tbl_kite`.`no_order`='" . $cwhere2 . "'
               )" . $cwhere1 . $cwhere10 . $cwhere11 . $cwhere12 . "
            GROUP BY tmp_detail_kite.id  
            ORDER BY `pergerakan_stok`.`typestatus`, `detail_pergerakan_stok`.`nokk`, `detail_pergerakan_stok`.`no_roll` ASC");
    $n = 0;
    while ($row = sqlsrv_fetch_array($qry)) {
        if ($_POST['check'][$n] != '') {
            $id_kite = $_POST['check'][$n];
            $sdata = sqlsrv_query($con,"select * from detail_pergerakan_stok where id='$id_kite'");
            $srow = sqlsrv_fetch_array($sdata);
            $cari1 = sqlsrv_query($con,"Select `id` from `packing_list` where `listno`='$listno' limit 1");
            $cek1 = sqlsrv_num_rows($cari1);
            if ($cek1 > 0) { // ubah data di detail_pergerakan stok
                sqlsrv_query($con,"UPDATE detail_pergerakan_stok SET refno='$listno',pack='".$_POST['pack']."',lott='".$_POST['id']."' WHERE id='$id_kite'");
                $json_data = array(
                    "kode"            => 200,
                    "msg"             => 'Save Successfully'
                );
            } else {
                //masuk ke packing_list
                $ip_num = $_SERVER['REMOTE_ADDR']; //untuk mendeteksi alamat IP
                $host_name = gethostbyaddr($_SERVER['REMOTE_ADDR']); //untuk mendeteksi computer name
                $userid    = $_SESSION['usernm1'];
                sqlsrv_query($con,"insert into `packing_list` 
                            (`listno`,`status`,ket,`ipaddress`,`userid`)
                            values
                            ('$listno','1','$ket','$ip_num','$userid')");
            }
            $json_data = array(
                "kode"            => 200,
                "msg"             => 'Save Successfully'
            );
            sqlsrv_query($con,"UPDATE detail_pergerakan_stok SET refno='$listno',pack='".$_POST['pack']."',lott='".$_POST['id']."' where id='$id_kite'") or die("Gagal1  $id_kite");
            $n++;
        } else {
            $n++;
        }
    }
} else {
    $json_data = array(
        "kode"            => 404,
        "msg"             => 'Action Failed'
    );
}
echo json_encode($json_data);
