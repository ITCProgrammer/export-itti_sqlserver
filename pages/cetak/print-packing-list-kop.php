<style>
    @media screen,
    print {
        table thead {
            display: table-header-group;
        }

        hr.style2 {
            border-top: 3px double #8c8b8b;
        }

        input {
            text-align: center;
            border: hidden;
        }

        body,
        td,
        th {
            /*font-family: Courier New, Courier, monospace; */
            font-family: sans-serif, Roman, serif;
        }

        body {
            margin: 0px auto 0px;
            padding: 3px;
            font-size: 12px;
            color: #333;
            width: 98%;
            background-position: top;
            background-color: #fff;
        }

        .table-list {
            clear: both;
            text-align: left;
            border-collapse: collapse;
            margin: 0px 0px 10px 0px;
            background: #fff;
        }

        .table-list td {
            color: #333;
            font-size: 12px;
            border-color: #fff;
            border-collapse: collapse;
            vertical-align: center;
            padding: 3px 5px;
            border-bottom: 1px #CCCCCC solid;
            border-left: 1px #CCCCCC solid;
            border-right: 1px #CCCCCC solid;


        }

        .table-list1 {
            clear: both;
            text-align: left;
            border-collapse: collapse;
            margin: 0px 0px 10px 0px;
            background: #fff;
        }

        .table-list1 td {
            color: #333;
            font-size: 12px;
            border-color: #fff;
            border-collapse: collapse;
            vertical-align: center;
            padding: 1px 2px;
            border-bottom: 1px #000000 solid;
            border-top: 1px #000000 solid;
            border-left: 1px #000000 solid;
            border-right: 1px #000000 solid;


        }

        .noborder {
            color: #333;
            font-size: 12px;
            border-color: #FFF;
            border-collapse: collapse;
            vertical-align: center;
            padding: 3px 5px;

        }

        #nocetak {
            border: hidden;
            font: normal;
            color: aliceblue;
        }

        .lingkaran {
            width: 100px;
            height: 100px;
            background-color: #f00;
            border-radius: 50%;
            overflow: hidden;
        }

        .rhomb {
            -webkit-box-sizing: content-box;
            -moz-box-sizing: content-box;
            box-sizing: content-box;
            width: 80px;
            height: 80px;
            margin: 3px 0 0 30px;
            border: none;
            font: normal 100%/normal Arial, Helvetica, sans-serif;
            color: rgba(0, 0, 0, 1);
            -o-text-overflow: clip;
            text-overflow: clip;
            background: #1abc9c;
            -webkit-transform: rotateZ(-45deg);
            transform: rotateZ(-45deg);
            -webkit-transform-origin: 0 100% 0deg;
            transform-origin: 0 100% 0deg;
        }
    }
</style>

<?php
include "../../koneksi.php";
function Indonesia2Tgl($tanggal)
{
    $namaBln = array(
        "01" => "Januari", "02" => "Februari", "03" => "Maret", "04" => "April", "05" => "Mei", "06" => "Juni",
        "07" => "Juli", "08" => "Agustus", "09" => "September", "10" => "Oktober", "11" => "November", "12" => "Desember"
    );

    $tgl = substr($tanggal, 8, 2);
    $bln = substr($tanggal, 5, 2);
    $thn = substr($tanggal, 0, 4);
    $tanggal = "$tgl " . $namaBln[$bln] . " $thn";
    return $tanggal;
}
$qryt = mysql_query("SELECT  now() as tgl");
$dtgl = mysql_fetch_array($qryt);
$slq = mysql_query("SELECT
	*
FROM
	packing_list
LEFT JOIN detail_pergerakan_stok ON packing_list.listno = detail_pergerakan_stok.refno
LEFT JOIN tmp_detail_kite ON detail_pergerakan_stok.id_detail_kj = tmp_detail_kite.id
LEFT JOIN tbl_kite ON tbl_kite.id=tmp_detail_kite.id_kite
WHERE  `packing_list`.`listno`='$_GET[listno]'
GROUP BY detail_pergerakan_stok.nokk");
$rslq = mysql_fetch_array($slq);
?>


<title>PRINT-PACKING-LIST</title>
<?php
$sqlm = mysql_query("SELECT * FROM tbl_exim a
LEFT JOIN tbl_exim_detail b ON a.id=b.id_list
WHERE a.listno='$_GET[listno]'");
$rm = mysql_fetch_array($sqlm);
$sql3 = mysql_query("SELECT * FROM tbl_exim_si WHERE no_si='$rm[no_si]'");
$r3 = mysql_fetch_array($sql3);
?>
<table width="100%" border="0" style="width:7.8in;">
    <thead>
        <tr>
            <td>
                <table width="100%" border="0" cellpadding="0" class="noborder">
                    <tr>
                        <td width="8%"><img src="logoITC2.jpg" width="80" height="80" /></td>
                        <td width="83%" align="center">
                            <font size="5px"><strong>PT. INDO TAICHEN TEXTILE INDUSTRY</strong></font><br />
                            <strong>KNITTING, DYEING, FINISHING, PRINTING, YARN DYE</strong><br />
                            <font size="1px"><strong>OFFICE/FACTORY</strong> : JL. GATOT SUBROTO KM. 3 JL. KALISABI UWUNG JAYA, CIBODAS <br />
                                KOTA TANGERANG BANTEN 15138. P.O.BOX 487 - BANTEN - INDONESIA<br />
                                <strong>PHONE</strong> : ( 021 ) - 5520920(HUNTING), FAX : ( 021 ) - 5523763,55790329,5520035(ACC)<br />
                                E-MAIL: marketing@indotaichen.com Web-site: www.indotaichen.com
                            </font>
                        </td>
                        <td width="9%" style="text-align:right"><img src="sgs-union-organik-p.jpg" width="140" height="80" /></td>
                    </tr>
                </table>
                <hr class="style2">
            </td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <table width="100%" border="0" class="noborder" style="width:7.8in;">
                    <tr>
                        <th colspan="4" scope="col">
                            <font size="+2">PACKING LIST</font>
                        </th>
                    </tr>
                    <tr>
                        <th colspan="4">
                            <font size="+1">NO. : <?PHP echo $_GET[listno]; ?></font>
                        </th>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <div align="right">DATED : <?php echo date('d-M-y', strtotime($rm[tgl])); ?></div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">TO MESSRS :</td>
                        <td colspan="2">CONSIGNEE :</td>
                    </tr>
                    <tr>
                        <td colspan="2"><strong><?php echo $rm[nm_messrs]; ?></strong></td>
                        <td colspan="2"><strong><?php echo $rm[nm_consign]; ?></strong></td>
                    </tr>
                    <tr>
                        <td colspan="2"><?php echo $rm[alt_messrs]; ?></td>
                        <td colspan="2"><?php echo $rm[alt_consign]; ?></td>
                    </tr>
                    <tr>
                        <td colspan="2">&nbsp;</td>
                        <td colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                        <td width="18%"><?php if ($rm[shipment_by] == "SEA") {
                                            echo "VESSEL";
                                        } else if ($rm[shipment_by] == "AIR") {
                                            echo "FLIGHT";
                                        } else if ($rm[shipment_by] == "COURIER") {
                                            echo "COURIER";
                                        } ?>
                            NAME</td>
                        <td width="33%">:
                            <?php if ($rm[shipment_by] == "SEA") {
                                echo $r3[vessel];
                            } else if ($rm[shipment_by] == "COURIER") {
                                if ($rm[v_f_c_nm] != "") {
                                    echo $rm[v_f_c_nm];
                                } else {
                                    echo $r3[vessel];
                                }
                            } else {
                                echo $rm[v_f_c_nm];
                            } ?></td>
                        <td width="16%">TERM OF PAYMENT</td>
                        <td width="33%">:<?php echo $rm[payment]; ?></td>
                    </tr>
                    <tr>
                        <td><?php if ($r[shipment_by] == "SEA") {
                                echo "SAILING";
                            } else if ($r[shipment_by] == "AIR") {
                                echo "FLIGHT";
                            } else if ($r[shipment_by] == "COURIER") {
                                echo "FLIGHT";
                            } ?>
                            DATE</td>
                        <td>: <?php echo  date('d.m.y', strtotime($rm[tgl_s_f])); ?></td>
                        <td><?php if ($rm[payment] == "L/C") { ?>L/C NO. <?php } ?></td>
                        <td><?php if ($rm[payment] == "L/C") { ?>:<?php echo $rm[no_lc]; ?><?php } ?></td>
                    </tr>
                    <tr>
                        <td>FROM</td>
                        <td>: <?php echo $rm[f_country]; ?></td>
                        <td valign="top"><?php if ($rm[payment] == "L/C") { ?>
                                L/C DATE
                            <?php } ?></td>
                        <td valign="top"><?php if ($rm[payment] == "L/C") { ?>
                                :<?php echo date('d.m.y', strtotime($rm[tgl_lc])); ?>
                            <?php } ?></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td colspan="2">TO : <?php echo $rm[t_country]; ?></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="left" valign="top"><?php echo $rm[l_area]; ?></td>
                        <td colspan="2" valign="top"><?php echo $rm[r_area]; ?><br>
                            COUNTRY OF ORIGIN: INDONESIA</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td colspan="2">&nbsp;</td>
                    </tr>
                </table>
                <table width="100%" border="0" class="noborder" style="width:7.8in;">
                    <tr>
                        <td valign="top">

                            <!-- awal -->
                            <?php
                            if ($_GET['listno'] != '') {
                                $sql = "SELECT
	*
FROM
	packing_list
LEFT JOIN detail_pergerakan_stok ON packing_list.listno = detail_pergerakan_stok.refno
LEFT JOIN tmp_detail_kite ON detail_pergerakan_stok.id_detail_kj = tmp_detail_kite.id
LEFT JOIN tbl_kite ON tbl_kite.id=tmp_detail_kite.id_kite
WHERE  `packing_list`.`listno`='$_GET[listno]'
GROUP BY detail_pergerakan_stok.nokk
ORDER BY detail_pergerakan_stok.lott ASC";
                            }
                            $data = mysql_query($sql);
                            $jrow = mysql_num_rows($data);
                            $nb = 1;
                            $n = 1;
                            $c = 0;
                            while ($rowd = mysql_fetch_array($data)) { ?>
                                <?php
                                $po = str_replace("'", "''", $rowd[no_po]);
                                $sqljns = mssql_query("SELECT 
*
 FROM
   
(SELECT ROW_NUMBER() 
        OVER (ORDER BY processcontrolJO.SODID) AS Row, 
       description
    FROM 
Joborders 
left join processcontrolJO on processcontrolJO.joid = Joborders.id
left join salesorders on soid= salesorders.id
left join processcontrol on processcontrolJO.pcid = processcontrol.id
left join processcontrolbatches on processcontrolbatches.pcid = processcontrol.id
left join productmaster on productmaster.id= processcontrol.productid
left join productpartner on productpartner.productid= processcontrol.productid
where  productcode='$rowd[no_item]'
) AS EMP
WHERE Row = 2");
                                $rjns = mssql_fetch_array($sqljns);

                                $sqla = mysql_query("SELECT count(no_lot)as roll,sum(detail_pergerakan_stok.weight) as berat,sum(detail_pergerakan_stok.yard_) as panjang,detail_pergerakan_stok.satuan FROM packing_list 
LEFT JOIN detail_pergerakan_stok ON detail_pergerakan_stok.refno = packing_list.listno
LEFT JOIN tmp_detail_kite ON tmp_detail_kite.id = detail_pergerakan_stok.id_detail_kj
LEFT JOIN tbl_kite ON tbl_kite.id = tmp_detail_kite.id_kite
WHERE tbl_kite.no_lot='$rowd[no_lot]' and tbl_kite.no_warna='$rowd[no_warna]' and tbl_kite.no_po='$po' and tbl_kite.nokk='$rowd[nokk]'
AND detail_pergerakan_stok.refno='$rowd[listno]'
GROUP BY detail_pergerakan_stok.satuan ");
                                $jmldata = mysql_fetch_array($sqla);

                                $sqla1 = mysql_query("SELECT count(no_lot)as roll,sum(detail_pergerakan_stok.weight) as berat,sum(tmp_detail_kite.netto) as panjang,detail_pergerakan_stok.satuan FROM packing_list 
LEFT JOIN detail_pergerakan_stok ON detail_pergerakan_stok.refno = packing_list.listno
LEFT JOIN tmp_detail_kite ON tmp_detail_kite.id = detail_pergerakan_stok.id_detail_kj
LEFT JOIN tbl_kite ON tbl_kite.id = tmp_detail_kite.id_kite
WHERE tbl_kite.no_lot='$rowd[no_lot]' and tbl_kite.no_warna='$rowd[no_warna]' and tbl_kite.no_po='$po' and tbl_kite.nokk='$rowd[nokk]'
AND detail_pergerakan_stok.refno='$rowd[listno]'
GROUP BY detail_pergerakan_stok.satuan ");
                                $jmldata1 = mysql_fetch_array($sqla1);

                                $sqlb = mysql_query("SELECT * FROM packing_list 
LEFT JOIN detail_pergerakan_stok ON detail_pergerakan_stok.refno = packing_list.listno
LEFT JOIN tmp_detail_kite ON tmp_detail_kite.id = detail_pergerakan_stok.id_detail_kj
LEFT JOIN tbl_kite ON tbl_kite.id = tmp_detail_kite.id_kite
WHERE tbl_kite.no_lot='$rowd[no_lot]' and tbl_kite.no_warna='$rowd[no_warna]' and tbl_kite.no_po='$po' and tbl_kite.nokk='$rowd[nokk]'
AND detail_pergerakan_stok.refno='$rowd[listno]'
");

                                $jml = mysql_num_rows($sqlb);
                                $batas = ceil($jml / 2);
                                $lawal = $batas * 1 - $batas;
                                /* $ltgh=$batas*2-$batas; */
                                $lakhr = $batas * 2 - $batas;

                                //kolom 1
                                $sql1 = mysql_query("SELECT * FROM packing_list 
LEFT JOIN detail_pergerakan_stok ON detail_pergerakan_stok.refno = packing_list.listno
LEFT JOIN tmp_detail_kite ON tmp_detail_kite.id = detail_pergerakan_stok.id_detail_kj
LEFT JOIN tbl_kite ON tbl_kite.id = tmp_detail_kite.id_kite
WHERE tbl_kite.no_lot='$rowd[no_lot]' and tbl_kite.no_warna='$rowd[no_warna]' and tbl_kite.no_po='$po' and tbl_kite.nokk='$rowd[nokk]' 
AND detail_pergerakan_stok.refno='$rowd[listno]' 
order by detail_pergerakan_stok.no_roll asc LIMIT $lawal,$batas");

                                //kolom 2
                                $sql2 = mysql_query("SELECT * FROM packing_list 
LEFT JOIN detail_pergerakan_stok ON detail_pergerakan_stok.refno = packing_list.listno
LEFT JOIN tmp_detail_kite ON tmp_detail_kite.id = detail_pergerakan_stok.id_detail_kj
LEFT JOIN tbl_kite ON tbl_kite.id = tmp_detail_kite.id_kite
WHERE tbl_kite.no_lot='$rowd[no_lot]' and tbl_kite.no_warna='$rowd[no_warna]' and tbl_kite.no_po='$po' and tbl_kite.nokk='$rowd[nokk]'
AND detail_pergerakan_stok.refno='$rowd[listno]'
order by detail_pergerakan_stok.no_roll asc LIMIT $lakhr,$batas");
                                $row2 = mysql_num_rows($sql2);
                                //kolom 3
                                $sql3 = mysql_query("SELECT * FROM packing_list 
LEFT JOIN detail_pergerakan_stok ON detail_pergerakan_stok.refno = packing_list.listno
LEFT JOIN tmp_detail_kite ON tmp_detail_kite.id = detail_pergerakan_stok.id_detail_kj
LEFT JOIN tbl_kite ON tbl_kite.id = tmp_detail_kite.id_kite
WHERE tbl_kite.no_lot='$rowd[no_lot]' and tbl_kite.no_warna='$rowd[no_warna]' and tbl_kite.no_po='$po' and tbl_kite.nokk='$rowd[nokk]'
AND detail_pergerakan_stok.refno='$rowd[listno]'
order by detail_pergerakan_stok.no_roll asc LIMIT $lakhr,$batas");
                                $sqllist = mysql_query("SELECT * FROM tbl_exim_detail 
WHERE  warna='$rowd[warna]'");
                                $rm1 = mysql_fetch_array($sqllist);
                                if ($rowd['no_item'] != "") {
                                    $fbc = $rjns['description'];
                                } else {
                                    $fbc = $rowd['jenis_kain'];
                                }
                                ?> <?php echo $rowd['no_item'] . " " . $fbc . "&nbsp; &nbsp; &nbsp; &nbsp;" . number_format($rowd['lebar'], '0') . "'' X " . number_format($rowd['berat'], '0') . "Gr/M2"; ?><br>
                                <?php echo $rm1[deskripsi2]; ?>
                                <br />
                                <table width="100%" border="0" align="center" class="table-list1">
                                    <tr>
                                        <td colspan="2" valign="top">
                                            <table width="100%" border="0" class="noborder">
                                                <tr>
                                                    <td width="50%" style="border-right:0px #000000 solid;
             border-left:0px #000000 solid;
             border-top:0px #000000 solid;
             border-bottom:0px #000000 solid;">PO &nbsp; &nbsp; &nbsp; &nbsp;:
                                                        <?php if ($rowd['no_po'] != '') {
                                                            echo $rowd['no_po'];
                                                        } ?>
                                                        <br />
                                                        COLOR :
                                                        <?php if ($rowd['warna'] != '') {
                                                            echo $rowd['warna'];
                                                        } ?>
                                                        <br />
                                                    </td>
                                                    <td width="50%" valign="top" style="border-right:0px #000000 solid;
             border-left:0px #000000 solid;
             border-top:0px #000000 solid;
             border-bottom:0px #000000 solid;">PI NO. : <?php if ($rowd['no_order'] != '') {
                                                            echo $rowd['no_order'];
                                                        } ?><br>
                                                        LOT &nbsp; &nbsp; &nbsp;:
                                                        <?php if ($rowd['no_lot'] != '') {
                                                            echo $rowd['no_lot'];
                                                        } ?></td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr align="center" class="tombol">
                                        <td width="0" valign="top">
                                            <table width="100%" border="0">
                                                <tr align="center">
                                                    <td width="15%"><?php if ($rowd['pack'] == "ROLLS") {
                                                                        echo "ROLL NO";
                                                                    } else {
                                                                        echo "BALES NO";
                                                                    } ?></td>
                                                    <td>KGS</td>
                                                    <td><?php if ($rowd['satuan'] == "PCS") {
                                                            echo "PCS";
                                                        } else {
                                                            echo "YDS";
                                                        } ?></td>
                                                    <td>MEAS</td>
                                                    <td>GW</td>
                                                    <td>FOC</td>
                                                </tr>
                                                <?php
                                                $tgw1 = 0;
                                                $foc1 = 0;
                                                while ($row1 = mysql_fetch_array($sql1)) {


                                                ?>
                                                    <tr>
                                                        <td align="center"><?php if ($row1['no_roll'] != '') {
                                                                                echo $row1['no_roll'];
                                                                            } else {
                                                                                echo $rsvr['rollno'];
                                                                            } ?> <?php if ($row1['sisa'] == "FOC") {
                                                                                        $foc = $row1['sisa'];
                                                                                    } else {
                                                                                        $foc = "";
                                                                                    } ?></td>
                                                        <td align="center"><?php echo number_format($row1['weight'], '2', '.', ','); ?></td>
                                                        <td align="center"><?php if ($rowd['satuan'] == "PCS") {
                                                                                echo number_format($row1['netto'], '0');
                                                                            }
                                                                            if ($rowd['satuan'] == "Yard" or $rowd['satuan'] == "Meter") {
                                                                                echo  number_format($row1['yard_'], '2', '.', ',');
                                                                            } ?></td>
                                                        <td align="center"><?php if ($row1['ukuran'] != "") {
                                                                                echo str_replace(' ', '', str_replace('x', '*', $row1['ukuran'])) . "CM";
                                                                            } else {
                                                                                echo "-";
                                                                            } ?></td>
                                                        <td align="center"><?php if ($rowd['pack'] == "ROLLS") {
                                                                                echo number_format($row1['weight'] + 0.6, '2', '.', ',');
                                                                            } else {
                                                                                echo number_format($row1['weight'] + 0.2, '2', '.', ',');
                                                                            } ?></td>
                                                        <td align="center"><?php if ($row1[sisa] == "FOC") {
                                                                                echo number_format($row1['weight'], '2', '.', ',');
                                                                            } else {
                                                                                echo "-";
                                                                            } ?></td>
                                                    </tr>
                                                <?php
                                                    $totbruto = $totbruto + $row1['weight'];
                                                    $totyrd = $totyrd + $row1['yard_'];
                                                    $totroll = $totroll + 1;
                                                    if ($row1[sisa] == "FOC") {
                                                        $foc1 = $row1['weight'] + $foc1;
                                                    }
                                                    if ($rowd['pack'] == "ROLLS") {
                                                        $tgw1 = $tgw1 + ($row1['weight'] + 0.6);
                                                    } else {
                                                        $tgw1 = $tgw1 + ($row1['weight'] + 0.2);
                                                    }
                                                }  ?>
                                            </table>
                                        </td>
                                        <td valign="top">
                                            <table width="100%" border="0">
                                                <tr align="center">
                                                    <td width="15%"><?php if ($rowd['pack'] == "ROLLS") {
                                                                        echo "ROLL NO";
                                                                    } else {
                                                                        echo "BALES NO";
                                                                    } ?></td>
                                                    <td>KGS</td>
                                                    <td><?php if ($rowd['satuan'] == "PCS") {
                                                            echo "PCS";
                                                        } else {
                                                            echo "YDS";
                                                        } ?></td>
                                                    <td>MEAS</td>
                                                    <td>GW</td>
                                                    <td>FOC</td>
                                                </tr>
                                                <?php
                                                $tgw2 = 0;
                                                $foc2 = 0;
                                                while ($row2 = mysql_fetch_array($sql2)) {



                                                ?>
                                                    <tr>
                                                        <td align="center"><?php if ($row2['no_roll'] != '') {
                                                                                echo $row2['no_roll'];
                                                                            } ?></td>
                                                        <td align="center"><?php echo number_format($row2['weight'], '2', '.', ','); ?></td>
                                                        <td align="center"><?php if ($rowd['satuan'] == "PCS") {
                                                                                echo number_format($row2['netto'], '0');
                                                                            }
                                                                            if ($rowd['satuan'] == "Yard" or $rowd['satuan'] == "Meter") {
                                                                                echo  number_format($row2['yard_'], '2', '.', ',');
                                                                            } ?></td>
                                                        <td align="center"><?php if ($row2['ukuran'] != "") {
                                                                                echo str_replace(' ', '', str_replace('x', '*', $row2['ukuran'])) . "CM";
                                                                            } else {
                                                                                echo "-";
                                                                            } ?></td>
                                                        <td align="center"><?php if ($rowd['pack'] == "ROLLS") {
                                                                                echo number_format($row2['weight'] + 0.6, '2', '.', ',');
                                                                            } else {
                                                                                echo number_format($row2['weight'] + 0.2, '2', '.', ',');
                                                                            } ?></td>
                                                        <td align="center"><?php if ($row2[sisa] == "FOC") {
                                                                                echo number_format($row2['weight'], '2', '.', ',');
                                                                            } else {
                                                                                echo "-";
                                                                            } ?></td>
                                                    </tr>
                                                <?php
                                                    $totbruto = $totbruto + $row2['weight'];
                                                    $totyrd = $totyrd + $row2['yard_'];
                                                    $totroll = $totroll + 1;
                                                    if ($row2[sisa] == "FOC") {
                                                        $foc2 = $row2['weight'] + $foc2;
                                                    }
                                                    if ($rowd['pack'] == "ROLLS") {
                                                        $tgw2 = $tgw2 + ($row2['weight'] + 0.6);
                                                    } else {
                                                        $tgw2 = $tgw2 + ($row2['weight'] + 0.2);
                                                    }
                                                }  ?>
                                                <tr>
                                                    <td colspan="6" align="center" scope="col"><strong>SUBTOTAL</strong></td>
                                                </tr>
                                                <tr>
                                                    <td width="15%" align="center" scope="col"><strong>&nbsp;<?php echo $jmldata['roll']; ?>&nbsp;&nbsp;</strong></td>
                                                    <td width="18%" align="center" scope="col"><strong><?php echo number_format($jmldata['berat'], '2', '.', ','); ?></strong></td>
                                                    <td width="20%" align="center" scope="col"><strong>
                                                            <?php
                                                            if ($jmldata['satuan'] == "PCS") {
                                                                echo number_format($jmldata1['panjang'], '0', '.', ',');
                                                            }
                                                            if ($jmldata['satuan'] == "Yard" or $jmldata['satuan'] == "Meter") {
                                                                echo number_format($jmldata['panjang'], '2', '.', ',');
                                                            } ?>
                                                        </strong></td>
                                                    <td width="14%" align="center" scope="col"><strong>&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;</strong></td>
                                                    <td width="15%" align="center" scope="col"><strong>
                                                            <?php
                                                            echo number_format($tgw1 + $tgw2, '2', '.', ',');
                                                            ?>
                                                        </strong></td>
                                                    <td width="18%" align="center" scope="col"><strong>&nbsp;&nbsp;&nbsp;&nbsp;<?php if (($foc1 + $foc2) == 0) {
                                                                                                                                    echo "-";
                                                                                                                                } else {
                                                                                                                                    echo $foc1 + $foc2;
                                                                                                                                } ?>&nbsp;&nbsp;&nbsp;&nbsp;</strong></td>
                                                </tr>
                                            </table>
                                        </td>

                                    </tr>

                                </table>
                            <?php } ?>
                            <!-- akhir -->
                    <tr>
                        <td valign="top">
                            <?php
                            $sql3 = mysql_query("SELECT
	sum(c.netto) as pcs,sum(b.weight)as kgs, sum(b.yard_)as yds,
	sum(if(b.pack='ROLLS',1,0)) as rolls,sum(if(b.pack='BALES',1,0)) as bales,
	(sum(if(b.pack='ROLLS',b.weight+0.6,0)) + sum(if(b.pack='BALES',b.weight+0.2,0))) as gw,
	sum(if(b.sisa='FOC',b.weight,0)) as foc
FROM
	packing_list a
INNER JOIN detail_pergerakan_stok b ON a.listno = b.refno
INNER JOIN tmp_detail_kite c ON b.id_detail_kj = c.id
INNER JOIN tbl_kite d ON d.id=c.id_kite
WHERE  `a`.`listno`='$_GET[listno]'
");
                            $rgt = mysql_fetch_array($sql3);
                            ?>
                            <table width="100%" border="0" cellpadding="0" class="table-list1">
                                <tr style="text-align:center">
                                    <td rowspan="2">GRAND TOTAL</td>
                                    <td>ROLLS</td>
                                    <td>BALES</td>
                                    <td>NW(KGS)</td>
                                    <td>NW(YDS)</td>
                                    <td>PCS</td>
                                    <td>GW(KGS)</td>
                                    <td>FOC</td>
                                </tr>
                                <tr style="text-align:center">
                                    <td><?php if ($rgt[rolls] > 0) {
                                            echo $rgt[rolls];
                                        } else {
                                            echo "-";
                                        } ?></td>
                                    <td><?php if ($rgt[bales] > 0) {
                                            echo $rgt[bales];
                                        } else {
                                            echo "-";
                                        } ?></td>
                                    <td><?php if ($rgt[kgs] > 0) {
                                            echo $rgt[kgs];
                                        } else {
                                            echo "-";
                                        } ?></td>
                                    <td><?php if ($rgt[yds] > 0) {
                                            echo $rgt[yds];
                                        } else {
                                            echo "-";
                                        } ?></td>
                                    <td><?php if ($rgt[pcs]) {
                                            echo $rgt[pcs];
                                        } else {
                                            echo "-";
                                        } ?></td>
                                    <td><?php if ($rgt[gw] > 0) {
                                            echo $rgt[gw];
                                        } else {
                                            echo "-";
                                        } ?></td>
                                    <td><?php if ($rgt[foc] > 0) {
                                            echo $rgt[foc];
                                        } else {
                                            echo "-";
                                        } ?></td>
                                </tr>
                            </table>
                            <!--</td></tr>
</td></tr> -->
                </table>
                <table width="100%" border="0" class="noborder">
                    <tr>
                        <td width="333" scope="col">
                            <div align="left">SHIPPING MARK</div>
                        </td>
                        <td width="406" scope="col">
                            <div align="right">SIGNED BY,</div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" scope="col"><?php echo $rm[s_mark]; ?></td>
                    </tr>
                </table>
            </td>
        </tr>
    </tbody>
</table>
<script>
    window.onkeydown = function(event) {
        if (event.keyCode == 27) {
            window.close();
        }
    };
</script>