<?php
session_start();
include '../koneksi.php';

$sqldt = sqlsrv_query($con, "SELECT * FROM db_qc.tbl_exim WHERE listno='$_POST[listno]'");
$row = mysql_fetch_array($sqldt);
if ($row['id'] != "") {
    if ($_SESSION['level'] == "SPV" or $_SESSION['level'] == "Manager" or $row['author'] == ucwords($_SESSION['usernm1'])) {
        $alt_messrs    = nl2br(htmlspecialchars(str_replace("'", "''", $_POST['alt_messrs'])));
        $alt_consgne = nl2br(htmlspecialchars(str_replace("'", "''", $_POST['alt_consgne'])));
        $r_si =    nl2br(htmlspecialchars(str_replace("'", "''", $_POST['r_si'])));
        $shipping =    nl2br(htmlspecialchars(str_replace("'", "''", $_POST['shipping'])));
        $sql = sqlsrv_query($con, " UPDATE db_qc.tbl_exim SET
                    tgl='$_POST[tgl1]',
                    fasilitas='$_POST[fasilitas]',
                    nm_messrs='$_POST[nm_messrs]',
                    alt_messrs='$alt_messrs',
                    nm_consign='$_POST[nm_consgne]',
                    alt_consign='$alt_consgne',
                    shipment_by='$_POST[shipmnt]',
                    payment='$_POST[payment]',
                    no_lc='$_POST[no_lc]',
                    tgl_lc='$_POST[tgl2]',
                    f_country='$_POST[f_country]',
                    t_country='$_POST[t_country]',
                    l_area='$_POST[left_a]',
                    r_area='$_POST[right_a]',
                    forwarder='$_POST[forwarder]',
                    f_atn='$_POST[f_atn]',
                    no_si='$_POST[no_si]',
                    tgl_si='$_POST[tgl6]',
                    status1='$_POST[status1]',
                    status2='$_POST[status2]',
                    incoterm='$_POST[incoterm]',
                    v_f_c_nm='$_POST[nm_trans]',
                    connecting='$_POST[connecting]',
                    tgl_c='$_POST[tgl3]',
                    tgl_s_f='$_POST[tgl4]',
                    tgl_eta='$_POST[tgl5]',
                    author='$_POST[author]',
                    r_si='$r_si',
                    s_mark='$shipping',
                    s_charge='$_POST[s_charge]',
                    no_bl='$_POST[no_bl]',
                    no_cont='$_POST[no_container]'
                    WHERE listno='$_POST[listno]' ");
        if ($sql) {
            $json_data = array(
                'kode' => 505,
                'msg' => 'Berhasil update data !'
            );
        } else {
            $json_data = array(
                'kode' => 404,
                'msg' => 'Gagal Update Data !'
            );
        }
    } else {
        $json_data = array(
            'kode' => 404,
            'msg' => 'Gagal User level anda tidak di izinkan !'
        );
    }
} else {
    $alt_messrs    = nl2br(htmlspecialchars(str_replace("'", "''", $_POST['alt_messrs'])));
    $alt_consgne = nl2br(htmlspecialchars(str_replace("'", "''", $_POST['alt_consgne'])));
    $r_si =    nl2br(htmlspecialchars(str_replace("'", "''", $_POST['r_si'])));
    $shipping =    nl2br(htmlspecialchars(str_replace("'", "''", $_POST['shipping'])));
    // $sql = sqlsrv_query(" INSERT INTO db_qc.tbl_exim SET
    //             listno='$_POST[listno]',
    //             tgl='$_POST[tgl1]',
    //             fasilitas='$_POST[fasilitas]',
    //             nm_messrs='$_POST[nm_messrs]',
    //             alt_messrs='$alt_messrs',
    //             nm_consign='$_POST[nm_consgne]',
    //             alt_consign='$alt_consgne',
    //             shipment_by='$_POST[shipmnt]',
    //             payment='$_POST[payment]',
    //             no_lc='$_POST[no_lc]',
    //             tgl_lc='$_POST[tgl2]',
    //             f_country='$_POST[f_country]',
    //             t_country='$_POST[t_country]',
    //             l_area='$_POST[left_a]',
    //             r_area='$_POST[right_a]',
    //             forwarder='$_POST[forwarder]',
    //             f_atn='$_POST[f_atn]',
    //             no_si='$_POST[no_si]',
    //             tgl_si='$_POST[tgl6]',
    //             status1='$_POST[status1]',
    //             status2='$_POST[status2]',
    //             incoterm='$_POST[incoterm]',
    //             v_f_c_nm='$_POST[nm_trans]',
    //             connecting='$_POST[connecting]',
    //             tgl_c='$_POST[tgl3]',
    //             tgl_s_f='$_POST[tgl4]',
    //             tgl_eta='$_POST[tgl5]',
    //             author='$_POST[author]',
    //             r_si='$r_si',
    //             s_mark='$shipping',
    //             s_charge='$_POST[s_charge]',
    //             no_bl='$_POST[no_bl]',
    //             no_cont='$_POST[no_container]'");    // siapa yg bikin insert begini ???

    $sql = sqlsrv_query($con, "INSERT INTO db_qc.tbl_exim (
        listno, tgl, fasilitas, nm_messrs, alt_messrs, 
        nm_consign, alt_consign, shipment_by, payment, no_lc, 
        tgl_lc, f_country, t_country, l_area, r_area, 
        forwarder, f_atn, no_si, tgl_si, status1, 
        status2, incoterm, v_f_c_nm, connecting, tgl_c, 
        tgl_s_f, tgl_eta, author, r_si, s_mark, 
        s_charge, no_bl, no_cont
    )
    VALUES (
        '$_POST[listno]', '$_POST[tgl1]', '$_POST[fasilitas]', '$_POST[nm_messrs]', '$alt_messrs', 
        '$_POST[nm_consgne]', '$alt_consgne', '$_POST[shipmnt]', '$_POST[payment]', '$_POST[no_lc]', 
        '$_POST[tgl2]', '$_POST[f_country]', '$_POST[t_country]', '$_POST[left_a]', '$_POST[right_a]', 
        '$_POST[forwarder]', '$_POST[f_atn]', '$_POST[no_si]', '$_POST[tgl6]', '$_POST[status1]', 
        '$_POST[status2]', '$_POST[incoterm]', '$_POST[nm_trans]', '$_POST[connecting]', '$_POST[tgl3]', 
        '$_POST[tgl4]', '$_POST[tgl5]', '$_POST[author]', '$r_si', '$shipping', 
        '$_POST[s_charge]', '$_POST[no_bl]', '$_POST[no_container]' ");

    if ($sql) {
        $json_data = array(
            'kode' => 505,
            'msg' => 'Berhasil Insert data !'
        );
    } else {
        $json_data = array(
            'kode' => 404,
            'msg' => 'Gagal Insert Data !'
        );
    }
}

echo json_encode($json_data);
