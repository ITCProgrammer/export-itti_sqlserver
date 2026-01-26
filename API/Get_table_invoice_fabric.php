<?php
session_start();
include '../koneksi.php';
$requestData = $_REQUEST;
$sqlFid = sqlsrv_query($con,"SELECT TOP 1 id FROM db_qc.tbl_exim WHERE listno = '".$requestData['listno']."' ");
$dataId = sqlsrv_fetch_array($sqlFid);
$columns = array(0 => 'no_order', 1 => 'no_po', 2 => 'no_item', 3 => 'style', 4 => 'warna', 5 => 'unit_price', 6 => 'weight', 8 => 'price_by', 9 => 'kgs', 10 => 'yds', 11 => 'pcs', 12 => 'kgs_foc', 13 => 'action');
$sql = "SELECT * FROM db_qc.tbl_exim_detail WHERE id_list = '".$dataId['id']."' ";
$query = sqlsrv_query($con, $sql) or die("data_server.php: get dataku");
$totalData = sqlsrv_num_rows($query);
$totalFiltered = $totalData;
if (!empty($requestData['search']['value'])) {
    $sql .= " AND (no_order LIKE '%" . $requestData['search']['value'] . "%' ";
    $sql .= " or no_po LIKE '%" . $requestData['search']['value'] . "%' ";
    $sql .= " or no_item LIKE '%" . $requestData['search']['value'] . "%' ";
    $sql .= " or warna LIKE '%" . $requestData['search']['value'] . "%' ";
    $sql .= " or unit_price LIKE '%" . $requestData['search']['value'] . "%' ";
    $sql .= " or weight LIKE '%" . $requestData['search']['value'] . "%' ";
    $sql .= " or price_by LIKE '%" . $requestData['search']['value'] . "%') ";
}
$query = sqlsrv_query($con,$sql) or die("data_server.php: get dataku1");
$totalFiltered = sqlsrv_num_rows($query);
// $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "  " . $requestData['order'][0]['dir'] . "  LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";
$sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "  " . $requestData['order'][0]['dir'] . " ";
$sql .= " OFFSET " . $requestData['start'] . " ROWS ";
$sql .= " FETCH NEXT " . $requestData['length'] . " ROWS ONLY ";
$query = sqlsrv_query($con,$sql) or die("data_server.php: get dataku2");

$data = array();
$no = 1;
while ($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
    $nestedData = array();
    $sql_KYP = sqlsrv_query($con,"SELECT 
        SUM(CASE WHEN a.sisa = 'FOC' THEN 0 ELSE a.weight END) AS kgs, 
        SUM(CASE WHEN a.sisa = 'FOC' THEN 0 ELSE a.yard_ END) AS yds,
        SUM(CASE WHEN a.sisa = 'FOC' THEN 0 ELSE b.netto END) AS pcs,
        SUM(CASE WHEN a.sisa = 'FOC' THEN a.weight ELSE 0 END) AS kgs_foc, 
        b.ukuran, 
        c.user_packing, 
        c.warna
    FROM db_qc.detail_pergerakan_stok a
    INNER JOIN db_qc.tmp_detail_kite b ON b.id = a.id_detail_kj
    INNER JOIN db_qc.tbl_kite c ON c.id = b.id_kite  
    WHERE 
        a.refno = '".$requestData['listno']."' 
        AND a.lott = '".$row['id']."'
    GROUP BY 
        b.ukuran, 
        c.warna, 
        c.user_packing ");
    $row_kyp = sqlsrv_fetch_array($sql_KYP, SQLSRV_FETCH_ASSOC);
    if ($row['price_by'] == "KGS") {
        $amount_us =  number_format($row_kyp['kgs'] * $row['unit_price'], 2);
    } else if ($row['price_by'] == "YDS") {
        $amount_us =  number_format($row_kyp['yds'] * $row['unit_price'], 2);
    } else if ($row['price_by'] == "PCS") {
        $amount_us =  number_format($row_kyp['pcs'] * $row['unit_price'], 2);
    } else {
        $amount_us =  "0";
    }
    $nestedData[] = $no++;
    $nestedData[] = $row["no_order"];
    $nestedData[] = $row["no_po"];
    $nestedData[] = $row["no_item"];
    $nestedData[] = $row["style"];
    $nestedData[] = $row["warna"];
    $nestedData[] = $row["unit_price"];
    $nestedData[] = $row['weight'];
    $nestedData[] = $row["price_by"];
    $nestedData[] = '<a href="javascript:void(0)" data-listno="' . $requestData['listno'] . '" data-pk="' . $row['id'] . '" class="detail-weight" title="[Details]">' . $row_kyp["kgs"] . '</a>';
    $nestedData[] = $row_kyp["yds"];
    $nestedData[] = $row_kyp["pcs"];
    $nestedData[] = $row_kyp["kgs_foc"];
    $nestedData[] = $amount_us;
    $jl = strlen($row['no_order']);
    $do = substr($row['no_order'], 1, $jl);
    $nestedData[] = "<div class='btn-group'>" .
        "<a href='javascript:void(0)' class='btn btn-info btn-xs act_packinglist'" . "data-listno='" . $requestData['listno'] . "' " . "data-dono='3" . $do . "'" . "data-id='" . $row['id'] . "'" . "data-po='" . $row['no_po'] . "'" . "data-item='" . $row['no_item'] . "'" . "data-warna='" . $row['warna'] . "'" . "title='[Packing-List]'><i class='fa fa-calendar'></i></a>" .
        "<a href='javascript:void(0)' class='btn btn-warning btn-xs invoice_detail_edit' data-listno='" . $requestData['listno'] . "' data-id='" . $row['id'] . "'><i class='fa fa-pencil'></i></a>" .
        "<a href='javascript:void(0)' class='btn btn-danger btn-xs delete_detail'  data-listno='" . $requestData['listno'] . "' data-id='" . $row['id'] . "'><i class='fa fa-trash'></i></a>" .
        "</div>";
    $data[] = $nestedData;
}
$json_data = array(
    "draw"            => intval($requestData['draw']),
    "recordsTotal"    => intval($totalData),
    "recordsFiltered" => intval($totalFiltered),
    "data"            => $data
);
echo json_encode($json_data);
