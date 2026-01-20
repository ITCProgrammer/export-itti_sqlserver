<?php
session_start();
include '../koneksi.php';

$sqldesc = sqlsrv_query($conn," SELECT d.PONumber,Description,CuttableWidth,c.Weight,Quantity,UnitPrice FROM SalesOrders a 
                        INNER JOIN SODetails b ON a.ID=b.SOID
                        INNER JOIN ProductMaster c ON c.ID=b.ProductID
                        INNER JOIN sodetailsadditional d ON d.sodid=b.id
                        INNER JOIN ProductPartner e ON e.productid=b.ProductID
                        WHERE a.SONumber='".$_POST['dono']."' AND e.ProductCode='".$_POST['item']."' AND  d.PONumber ='".$_POST['nopo']."' AND e.Color='".$_POST['warna']."' ");
$sqlpi = sqlsrv_query($con,"SELECT * FROM tbl_exim_pi_detail WHERE no_pi='".$_POST['dono']."' and no_item='".$_POST['item']."' and warna='".$_POST['warna']."' ");

$sqlpi1 = sqlsrv_query($con,"SELECT * FROM tbl_exim_pi_detail WHERE id='".$_GET['PI']."' ");
$rpi1 = sqlsrv_fetch_array($sqlpi1);


$count = mysql_num_rows($sqlpi);
$val = sqlsrv_fetch_array($sqldesc,SQLSRV_FETCH_ASSOC);

$data = array();
while ($row = sqlsrv_fetch_array($sqlpi)) {
    $pi['id'] = $row['id'];
    $pi['warna'] = $row['warna'];
    $pi['qty'] = $row['qty'];

    $data[] = $pi;
}

if ($count > 0) {
    $json_data = array(
        "UnitPrice"       => number_format($val['UnitPrice'], 3, ',', '.'),
        "data"            => $val['Description'] . " " . number_format($val['Weight'], '0') . "GR/M2 " . number_format($val['CuttableWidth'], '0') . '"',
        "row"             => $data,
        "msg"             => 505
    );
} else {
    $json_data = array(
        "data"            => '',
        "msg"             => 404
    );
}
echo json_encode($json_data);
