<?php
session_start();
include '../koneksi.php';

$sql = mysqli_query($con,"SELECT trim(no_mc) as no_mc,nokk
FROM `tbl_kite`
WHERE `tbl_kite`.`no_order` = '".$_POST['no_order']."' 
AND `tbl_kite`.`no_po` like '".$_POST['no_po']."' 
AND `tbl_kite`.`no_item` = '".$_POST['no_item']."' 
AND `tbl_kite`.`warna` = '".$_POST['warna']."' 
AND `tbl_kite`.`no_lot` = '".$_POST['no_lot']."'
GROUP BY no_mc");

$data = mysql_fetch_array($sql);
$count = mysql_num_rows($sql);


$sqlN = mysqli_query($con,"SELECT
    refno,
    count(refno) AS rol,
    sum(weight) AS qty
FROM
    detail_pergerakan_stok
WHERE
    nokk = '".$data['nokk']."' and not ISNULL(refno)
GROUP BY
    refno");

$note = mysql_fetch_array($sqlN);

if ($count > 0) {
    $res = array(
        "code"             => 505,
        "no_mc"            => $data['no_mc'],
        "nokk"             => $data['nokk'],
        "note"             => "<strong>Sudah diambil Oleh: <font color=red>" . $note['refno'] . " || " . $note['rol'] . " || " . $note['qty'] . "</font></strong>"
    );
} else {
    $res = array(
        "code"             => 404,
        "no_mc"            => '',
        "nokk"            => '',
        "note"             => ""
    );
}

echo json_encode($res);
