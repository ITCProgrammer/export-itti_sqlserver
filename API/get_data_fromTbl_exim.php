<?php
session_start();
include '../koneksi.php';

$sql = sqlsrv_query($con, "SELECT id, listno, tgl, nm_messrs, alt_messrs, nm_consign, alt_consign, shipment_by, payment, no_lc, tgl_lc, f_country, t_country, l_area, r_area, forwarder, f_atn, no_si,
                    tgl_si, status1, status2, incoterm, v_f_c_nm, connecting, tgl_c, tgl_s_f, tgl_eta, author, r_si, s_mark, s_charge, no_bl, no_cont, fasilitas, no_peb, tgl_peb, tgl_sj, no_sj, npe, tgl_khusus, no_awb, tgl_mkt, ket_awb, tgl_awb, no_sa, no_tagihan, jml_tagihan, no_tagihan1, jml_tagihan1, no_tagihan2, jml_tagihan2, no_tagihan3, jml_tagihan3, no_tagihan4, jml_tagihan4
                    FROM db_qc.tbl_exim 
                    WHERE listno='" . $_POST['listno'] . "' ");
$data = sqlsrv_fetch_array($sql);
$count = sqlsrv_num_rows($sql);

if ($count > 0) {
    $json_data = array(
        "data"            => $data,
        "msg"             => 1
    );
} else {
    $json_data = array(
        "data"            => $data,
        "msg"             => 0
    );
}
//----------------------------------------------------------------------------------
// echo "<script>console.log('".json_encode($json_data)."'));</script>";
echo json_encode($json_data);
