<?php
session_start();
include '../koneksi.php';

$sqlpo = sqlsrv_query($conn," SELECT CAST(d.[PONumber] AS VARCHAR(8000)) AS PONumber FROM SalesOrders a 
                    INNER JOIN SODetails b ON a.ID=b.SOID
                    INNER JOIN sodetailsadditional d ON d.sodid=b.id
                    INNER JOIN ProductMaster c ON c.ID=b.ProductID
                    INNER JOIN ProductPartner e ON e.productid=b.ProductID
                    WHERE a.SONumber='".$_POST['dono']."'
                    GROUP BY d.PONumber ");
$count = sqlsrv_num_rows($sqlpo,array(), array("Scrollable"=>"static"));


while ($val = sqlsrv_fetch_array($sqlpo,SQLSRV_FETCH_ASSOC)) {
    $items[] = $val['PONumber'];
}

if ($count > 0) {
    $json_data = array(
        "data"            => $items,
        "msg"             => 505
    );
} else {
    $json_data = array(
        "data"            => '',
        "msg"             => 404
    );
}
echo json_encode($json_data);
