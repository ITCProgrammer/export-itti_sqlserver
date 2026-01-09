<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Proforma Invoice</title>
    <link rel="stylesheet" type="text/css" href="css/datatable.css" />
    <link rel="stylesheet" type="text/css" href="css/jquery-ui.css" />
    <script src="js/jquery.js" type="text/javascript"></script>
    <script src="js/jquery.dataTables.js" type="text/javascript"></script>
    <!-- Bootstrap -->
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css">
    <script type="text/javascript" src="bootstrap/js/jquery.js"></script>
    <script type="text/javascript" src="bootstrap/js/bootstrap.js"></script>
    <script>
        $(document).ready(function() {
            $('#datatables').dataTable({
                "sScrollY": "300px",
                "sScrollX": "100%",
                "bScrollCollapse": true,
                "bPaginate": false,
                "bJQueryUI": true
            });
        })
    </script>
</head>

<body>
    <?php
    $Thn    = isset($_POST['thn']) ? $_POST['thn'] : '';
    if ($Thn != "") {
        $Thn1 = $Thn;
    } else {
        $Thn1 = date('Y');
    }
    ?>
    <form id="form1" name="form1" method="post" action="">
        <table width="100%" border="0">
            <tbody>
                <tr>
                    <td width="4%">Tahun :
                        <label for="thn"></label>
                    </td>
                    <td width="7%"><select name="thn" id="thn" style="width: 100%;">
                            <option>Pilih</option>
                            <?php
                            $thn_skr = date('Y');
                            for ($x = $thn_skr; $x >= 2016; $x--) {
                            ?>
                                <option value="<?php echo $x ?>" <?php if ($Thn != "") {
                                                                        if ($x == $Thn) {
                                                                            echo "SELECTED";
                                                                        }
                                                                    } else {
                                                                        if ($x == $thn_skr) {
                                                                            echo "SELECTED";
                                                                        }
                                                                    } ?>><?php echo $x ?></option>
                            <?php
                            }
                            ?>
                        </select></td>
                    <td width="89%"><input type="submit" name="cari" id="cari" value="Cari" class="btn" /></td>
                </tr>
            </tbody>
        </table>
    </form>
    <p>
        <input type="button" name="add" id="add" value="ADD COMMERCIAL INVOICE" class="art-button" onclick="window.location='?p=invoice'" />
    </p>
    <table width="100%" border="0" id="datatables" class="display nowrap">
        <thead>
            <tr>
                <th width="2%" scope="col">NO</th>
                <th width="17%" scope="col">NO CI</th>
                <th width="11%" scope="col">NO SI</th>
                <th width="8%" scope="col">CONSIGNEE</th>
                <th width="7%" scope="col">PAYMENT</th>
                <th width="4%" scope="col">TERM</th>
                <th width="2%" scope="col">TO</th>
                <th width="4%" scope="col">SHIP BY</th>
                <th width="3%" scope="col">QTY</th>
                <th width="6%" scope="col">AMOUNT</th>
                <th width="7%" scope="col">FASILITAS</th>
                <th width="9%" scope="col">FORWARDER</th>
                <th width="5%" scope="col">STATUS</th>
                <th width="4%" scope="col">NEXT</th>
                <th width="6%" scope="col">AUTHOR</th>
                <th width="5%" scope="col">PRINT</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = mysql_query("SELECT * FROM tbl_exim WHERE DATE_FORMAT(tgl,'%Y')='$Thn1' ORDER BY id DESC");
            $no = 1;
            while ($rowd = mysql_fetch_array($sql)) {
                $qrypl = mysql_query("SELECT count(*) jml
FROM detail_pergerakan_stok a
INNER JOIN tmp_detail_kite b ON b.id=a.id_detail_kj
INNER JOIN tbl_kite c ON c.id=b.id_kite
WHERE refno='$rowd[listno]'");
                $cpl = mysql_fetch_array($qrypl);

                $sqldt1 = mysql_query(" SELECT sum(a.weight) as kgs,sum(a.yard_)as yds,sum(b.netto)as pcs,b.ukuran,c.user_packing ,c.warna
FROM detail_pergerakan_stok a
INNER JOIN tmp_detail_kite b ON b.id=a.id_detail_kj
INNER JOIN tbl_kite c ON c.id=b.id_kite
WHERE refno='$rowd[listno]' ");
                $r1 = mysql_fetch_array($sqldt1);
                $sqlsi = mysql_query("SELECT * FROM tbl_exim_si WHERE no_si='$rowd[no_si]'");
                $r2 = mysql_fetch_array($sqlsi);
            ?>
                <tr>
                    <td><?php echo $no; ?></td>
                    <td><?php echo $rowd[listno]; ?><br>
                        <a href="?p=invoice_detail&listno=<?php echo $rowd[listno]; ?>" target="_blank" title="[Input Packing List]"><?php if ($cpl[jml] > 0) { ?><img src="images/xpl.png" width="25" height="25" alt="" /><?php } else { ?><img src="images/xpldisable.png" width="25" height="25" alt="" /><?php } ?>
                        </a>

                        &nbsp;

                        <a href="?p=tambah-peb&no=<?php echo $rowd[listno]; ?>" title="[Input Pengiriman Barang]" target="_blank"><?php if ($rowd[no_peb] != "") { ?><img src="images/xpeb.png" width="25" height="25" alt="" /><?php } else { ?><img src="images/xpebdisable.png" width="25" height="25" alt="" /><?php } ?>
                        </a>

                        &nbsp;


                        <a href="?p=tambah-bl&no=<?php echo $rowd[listno]; ?>" title="[Input Pengembalian B/L]" target="_blank">
                            <?php if ($rowd[no_tagihan] != "") { ?>
                                <img src="images/xbl.png" width="25" height="25" alt="" />
                            <?php } else { ?>
                                <img src="images/xbldisable.png" width="25" height="25" alt="" />
                            <?php } ?>
                        </a>


                        <br />




                        <a href="?p=tambah-awb&no=<?php echo $rowd[listno]; ?>" title="[Input Pengiriman Dokumen]" target="_blank">
                            <?php if ($rowd[no_awb] != "") { ?>
                                <img src="images/xdoc.png" width="25" height="25" alt="" />
                            <?php } else { ?>
                                <img src="images/xdocdisable.png" width="25" height="25" alt="" />
                            <?php } ?>
                        </a>










                        &nbsp;<a href="?p=pilih-sa&no=<?php echo $rowd[listno]; ?>&id=<?php echo $rowd[no_sa]; ?>" title="[Input Shipment Advice]" target="_blank"><?php if ($rowd[no_sa] != "") { ?><img src="images/xsa.png" width="25" height="25" alt="" /><?php } else { ?><img src="images/xsadisable.png" width="25" height="25" alt="" /><?php } ?></a>
                    </td>
                    <td><?php if ($rowd[no_si] != "") {
                            echo $rowd[no_si];
                        } else { ?><a href="?p=tambah-si&ci=<?php echo $rowd[listno]; ?>" target="_blank">BUAT SI</a>|| <a href="?p=pilih-si&no=<?php echo $rowd[no_si]; ?>&id=<?php echo $rowd[id]; ?>" target="_blank" title="[Input Shipping Instruction]">PILIH SI</a><?php } ?></td>
                    <td><?php echo strtoupper($rowd[nm_consign]); ?></td>
                    <td><?php echo strtoupper($rowd[payment]); ?></td>
                    <td><?php echo strtoupper($rowd[incoterm]); ?></td>
                    <td><?php echo strtoupper($rowd[t_country]); ?></td>
                    <td><?php echo strtoupper($rowd[shipment_by]) . "<br> ETD:" . $r2[etd] . "<br> ETA:" . $r2[eta]; ?></td>
                    <td><?php if ($r1[kgs] != "") {
                            echo $r1[kgs];
                        } else {
                            echo "-";
                        } ?></td>
                    <td><?php
                        $amout = 0;
                        $amt = 0;
                        $sqldt = mysql_query("SELECT * FROM tbl_exim_detail WHERE id_list='$rowd[id]'");
                        while ($dt = mysql_fetch_array($sqldt)) {
                            $sqldt1 = mysql_query(" SELECT sum(a.weight) as kgs,sum(a.yard_)as yds,sum(b.netto)as pcs,b.ukuran,c.user_packing ,c.warna
FROM detail_pergerakan_stok a
INNER JOIN tmp_detail_kite b ON b.id=a.id_detail_kj
INNER JOIN tbl_kite c ON c.id=b.id_kite
WHERE refno='$rowd[listno]'  AND a.lott='$dt[id]'
GROUP BY b.ukuran,c.warna ");
                            $dt1 = mysql_fetch_array($sqldt1);

                            if ($dt[price_by] == "KGS") {
                                $amout = round($dt1[kgs] * $dt[unit_price], 2);
                            } else if ($dt[price_by] == "YDS") {
                                $amout = round($dt1[yds] * $dt[unit_price], 2);
                            } else if ($dt[price_by] == "PCS") {
                                $amout = round($dt1[pcs] * $dt[unit_price], 2);
                            } else {
                                $amout = 0;
                            }
                            $amt = $amt + $amout;
                        }
                        if ($amt > 0) {
                            echo number_format($amt, 2);
                        } else {
                            echo "-";
                        }
                        ?></td>
                    <td><?php echo strtoupper($rowd[fasilitas]); ?></td>
                    <td><?php echo strtoupper($r2[forwarder]); ?></td>
                    <td><?php
                        $sqlcek = mysql_query("SELECT a.id,b.id_list FROM tbl_exim a
LEFT JOIN tbl_exim_detail b ON a.id=b.id_list
WHERE listno='$rowd[listno]'");
                        $ck = mysql_fetch_array($sqlcek);
                        if ($ck[id_list] != "") {
                            if ($rowd[no_sa] != "") {
                                echo "BUAT SA";
                            } else {
                                if ($rowd[no_awb] != "") {
                                    echo "KIRIM DOKUMEN";
                                } else {
                                    if ($rowd[no_tagihan] != "") {
                                        echo "AMBIL B/L";
                                    } else {
                                        if ($rowd[no_peb] != "") {
                                            echo "PENGIRIMAN CARGO";
                                        } else {
                                            if ($rowd[no_si] != "") {
                                                echo "BUAT SI";
                                            } else {
                                                if ($cpl[jml] > 0) {
                                                    echo "BUAT PACKING LIST";
                                                } else {
                                                    echo "BUAT DETAIL INVOICE";
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        } else
		 if ($ck[id] != "") {
                            echo "BUAT INVOICE";
                        } else {
                            echo "BUAT PI";
                        }
                        ?></td>
                    <td><?php
                        $sqlcek = mysql_query("SELECT a.id,b.id_list FROM tbl_exim a
LEFT JOIN tbl_exim_detail b ON a.id=b.id_list
WHERE listno='$rowd[listno]'");
                        $ck = mysql_fetch_array($sqlcek);
                        if ($ck[id_list] != "") {
                            if ($rowd[no_sa] != "") {
                                echo "ARSIP";
                            } else {
                                if ($rowd[no_awb] != "") {
                                    echo "<a href='?p=add-sa&ci=$rowd[listno]' target='_blank'>BUAT SA</a>";
                                } else {
                                    if ($rowd[no_tagihan] != "") {
                                        echo "<a href='?p=tambah-awb&no=$rowd[listno]'>KIRIM DOKUMEN</a>";
                                    } else {
                                        if ($rowd[no_peb] != "") {
                                            echo "<a href='?p=tambah-bl&no=$rowd[listno]'>AMBIL B/L</a>";
                                        } else {
                                            if ($rowd[no_si] != "") {
                                                echo "<a href='?p=tambah-peb&no=$rowd[listno]'>PENGIRIMAN CARGO</a>";
                                            } else {
                                                if ($cpl[jml] > 0) {
                                                    echo "BUAT SI";
                                                } else {
                                                    echo "<a href='?p=invoice_detail&listno=$rowd[listno]'>BUAT PACKING LIST</a>";
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        } else
		 if ($ck[id] != "") {
                            echo "<a href='?p=invoice_detail&listno=$rowd[listno]'>BUAT DETAIL INVOICE</a>";
                        } else {
                            echo "BUAT INVOICE";
                        }
                        ?></td>
                    <td><?php echo strtoupper($rowd[author]); ?></td>
                    <td>
                        <a href="#" title="[Cetak Invoice]" class="cetak_ci" id="<?php echo $rowd['listno']; ?>"><img src="images/postdateicon.png" alt="delete" width="16" height="16" /></a>

                        &nbsp;&nbsp;

                        <a href="#" title="[Cetak Packing List]" class="cetak_pl" id="<?php echo $rowd['listno']; ?>"><img src="images/postediticon.png" alt="delete" width="16" height="16" /></a>

                        <br />

                        <a href="#" title="[Cetak SA]" class="cetak_sa" id="<?php echo $rowd['id']; ?>"><img src="images/posttagicon.png" alt="delete" width="16" height="16" /></a>

                        &nbsp;&nbsp;

                        <a href="#" title="[Cetak SI]" class="cetak_si" id="<?php echo $rowd['no_si']; ?>"><img src="images/postemailicon.png" alt="delete" width="16" height="16" /></a>
                    </td>
                </tr>
            <?php $no++;
            } ?>
        </tbody>

    </table>
    <div id="PrintCI" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    </div>
    <div id="PrintPL" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    </div>
    <div id="PrintSA" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    </div>
    <div id="PrintSI" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    </div>
</body>

</html>