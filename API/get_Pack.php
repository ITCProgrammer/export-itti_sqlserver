<?php
session_start();
include '../koneksi.php';

$sql = sqlsrv_query($con, "SELECT DISTINCT 
    TRIM(no_mc) AS no_mc, 
    nokk
FROM db_qc.tbl_kite
WHERE no_order = '" . $_POST['no_order'] . "' 
  AND no_po LIKE '" . $_POST['no_po'] . "' 
  AND no_item = '" . $_POST['no_item'] . "' 
  AND warna = '" . $_POST['warna'] . "' 
  AND no_lot = '" . $_POST['no_lot'] . "'");

$data = sqlsrv_fetch_array($sql);
$count = sqlsrv_num_rows($sql);


$sqlN = sqlsrv_query($con, "SELECT
    refno,
    COUNT(refno) AS rol,
    SUM(weight) AS qty
FROM
    db_qc.detail_pergerakan_stok
WHERE
    nokk = '" . $data['nokk'] . "' 
    AND refno IS NOT NULL  
GROUP BY
    refno");

$note = sqlsrv_fetch_array($sqlN);

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
