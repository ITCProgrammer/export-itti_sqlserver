<?php
session_start();
include '../koneksi.php';

$sqlcolor = sqlsrv_query($conn," SELECT e.Color FROM SalesOrders a
                        INNER JOIN SODetails b ON a.ID=b.SOID
                        INNER JOIN sodetailsadditional d ON d.sodid=b.id
                        INNER JOIN ProductMaster c ON c.ID=b.ProductID
                        INNER JOIN ProductPartner e ON e.productid=b.ProductID
                        WHERE a.SONumber='".$_POST['dono']."' AND e.ProductCode='".$_POST['item']."' AND d.PONumber='".$_POST['nopo']."' 
                        GROUP BY e.Color ");
$sqlwarna = sqlsrv_query($conn,"SELECT e.Color,SUBSTRING(f.RefNo, CHARINDEX('S#', f.RefNo),100) as style FROM SalesOrders a 
                        INNER JOIN SODetails b ON a.ID=b.SOID
                        INNER JOIN SODetailsAdditional f ON f.SODID=b.ID
                        INNER JOIN ProductMaster c ON c.ID=b.ProductID
                        INNER JOIN ProductPartner e ON e.productid=b.ProductID
                        WHERE a.SONumber='".$_POST['dono']."' AND e.ProductCode='".$_POST['item']."' AND f.PONumber='".$_POST['nopo']."' GROUP BY e.Color,f.RefNo ",array(), array("Scrollable"=>"static"));


$count = sqlsrv_num_rows($sqlcolor,array(), array("Scrollable"=>"static"));

$warna = array();
while ($w = sqlsrv_fetch_array($sqlwarna,SQLSRV_FETCH_ASSOC)) {
    $nested['style'] = $w['style'];

    $warna[] = $nested;
}

while ($val = sqlsrv_fetch_array($sqlcolor,SQLSRV_FETCH_ASSOC)) {
    $color[] = $val['Color'];
}

if ($count > 0) {
    $json_data = array(
        "warna"           => $warna,
        "data"            => $color,
        "msg"             => 505
    );
} else {
    $json_data = array(
        "warna"           => '',
        "data"            => '',
        "msg"             => 404
    );
}
echo json_encode($json_data);
