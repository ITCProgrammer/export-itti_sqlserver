<?php
session_start();
include "../../koneksi.php";
?>
<style>
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

    .table-list1 th {
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
        display: none;
    }
</style>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>PRINT COMMERCIAL INVOICE</title>
    <link rel="icon" type="image/png" href="images/icon.png">
</head>

<body>
    <?php
    function convert_number_to_words($number)
    {

        $hyphen      = ' ';
        $conjunction = ' ';
        $separator   = ' ';
        $negative    = 'negative ';
        $decimal     = ' and ';
        $cent         = ' cents only';
        $dictionary  = array(
            0                   => 'zero',
            1                   => 'one',
            2                   => 'two',
            3                   => 'three',
            4                   => 'four',
            5                   => 'five',
            6                   => 'six',
            7                   => 'seven',
            8                   => 'eight',
            9                   => 'nine',
            10                  => 'ten',
            11                  => 'eleven',
            12                  => 'twelve',
            13                  => 'thirteen',
            14                  => 'fourteen',
            15                  => 'fifteen',
            16                  => 'sixteen',
            17                  => 'seventeen',
            18                  => 'eighteen',
            19                  => 'nineteen',
            20                  => 'twenty',
            30                  => 'thirty',
            40                  => 'fourty',
            50                  => 'fifty',
            60                  => 'sixty',
            70                  => 'seventy',
            80                  => 'eighty',
            90                  => 'ninety',
            100                 => 'hundred',
            1000                => 'thousand',
            1000000             => 'million',
            1000000000          => 'billion',
            1000000000000       => 'trillion',
            1000000000000000    => 'quadrillion',
            1000000000000000000 => 'quintillion'
        );

        if (!is_numeric($number)) {
            return false;
        }

        if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
            // overflow
            trigger_error(
                'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
                E_USER_WARNING
            );
            return false;
        }

        if ($number < 0) {
            return $negative . convert_number_to_words(abs($number));
        }

        $string = $fraction = null;

        if (strpos($number, '.') !== false) {
            list($number, $fraction) = explode('.', $number);
        }

        switch (true) {
            case $number < 21:
                $string = $dictionary[$number];
                break;
            case $number < 100:
                $tens   = ((int) ($number / 10)) * 10;
                $units  = $number % 10;
                $string = $dictionary[$tens];
                if ($units) {
                    $string .= $hyphen . $dictionary[$units];
                }
                break;
            case $number < 1000:
                $hundreds  = $number / 100;
                $remainder = $number % 100;
                $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
                if ($remainder) {
                    $string .= $conjunction . convert_number_to_words($remainder);
                }
                break;
            default:
                $baseUnit = pow(1000, floor(log($number, 1000)));
                $numBaseUnits = (int) ($number / $baseUnit);
                $remainder = $number % $baseUnit;
                $string = convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
                if ($remainder) {
                    $string .= $remainder < 100 ? $conjunction : $separator;
                    $string .= convert_number_to_words($remainder);
                }
                break;
        }

        if (null !== $fraction && is_numeric($fraction)) {
            $string .= $decimal;
            $string .= convert_number_to_words($fraction) . $cent;
        }

        return $string;
    }
    //echo strtoupper(convert_number_to_words(123.92));
    ?>

    <?php
    $sql = mysql_query("SELECT * FROM tbl_exim WHERE listno='$_GET[listno]'");
    $r = mysql_fetch_array($sql);
    $sql3 = mysql_query("SELECT * FROM tbl_exim_si WHERE no_si='$r[no_si]'");
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
                                <font size="+2">COMMERCIAL INVOICE</font>
                            </th>
                        </tr>
                        <tr>
                            <th colspan="4">
                                <font size="+1">NO. : <?PHP echo $_GET[listno]; ?></font>
                            </th>
                        </tr>
                        <tr>
                            <td colspan="2"><strong>TO MESSRS :</strong></td>
                            <td colspan="2" align="right">DATE : <?php echo date('d-M-y', strtotime($r[tgl])); ?></td>
                        </tr>
                        <tr>
                            <td colspan="2"><strong><?php echo $r[nm_messrs]; ?></strong></td>
                            <td colspan="2">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="2"><strong><?php echo $r[alt_messrs]; ?></strong></td>
                            <td width="16%">&nbsp;</td>
                            <td width="33%">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="2">&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="2"><strong>CONSIGNEE :</strong></td>
                            <td colspan="2">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="2"><strong><?php echo $r[nm_consign]; ?></strong></td>
                            <td colspan="2">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="2"><strong><?php echo $r[alt_consign]; ?></strong></td>
                            <td colspan="2">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="2">&nbsp;</td>
                            <td colspan="2">&nbsp;</td>
                        </tr>
                        <tr>
                            <td width="19%"><?php if ($r[shipment_by] == "SEA") {
                                                echo "VESSEL";
                                            } else if ($r[shipment_by] == "AIR") {
                                                echo "FLIGHT";
                                            } else if ($r[shipment_by] == "COURIER") {
                                                echo "COURIER";
                                            } ?> NAME</td>
                            <td width="32%">: <?php if ($r[shipment_by] == "SEA") {
                                                    echo $r3[vessel];
                                                } else if ($r[shipment_by] == "COURIER") {
                                                    if ($r[v_f_c_nm] != "") {
                                                        echo $r[v_f_c_nm];
                                                    } else {
                                                        echo $r3[vessel];
                                                    }
                                                } else {
                                                    echo $r[v_f_c_nm];
                                                } ?></td>
                            <td colspan="2">&nbsp;</td>
                        </tr>
                        <tr>
                            <td><?php if ($r[shipment_by] == "SEA") {
                                    echo "SAILING";
                                } else if ($r[shipment_by] == "AIR") {
                                    echo "FLIGHT";
                                } else if ($r[shipment_by] == "COURIER") {
                                    echo "FLIGHT";
                                } ?> DATE</td>
                            <td>: <?php echo  date('d.m.y', strtotime($r[tgl_s_f])); ?></td>
                            <td colspan="2">&nbsp;</td>
                        </tr>
                        <tr>
                            <td>FROM</td>
                            <td>: <?php echo $r[f_country]; ?></td>
                            <td colspan="2">TO : <?php echo strtoupper($r[t_country]); ?></td>
                        </tr>
                        <tr>
                            <td width="16%">TERM OF PAYMENT </td>
                            <td width="33%">: <?php echo $r[payment]; ?></td>
                            <td colspan="2" rowspan="4" align="left" valign="top"> <?php echo $r[r_area]; ?><br />
                                COUNTRY OF ORIGIN: INDONESIA</td>
                        </tr>
                        <tr>
                            <td><?php if ($r[payment] == "L/C") { ?>L/C NO. <?php } ?></td>
                            <td><?php if ($r[payment] == "L/C") { ?>: <?php echo $r[no_lc]; ?><?php } ?></td>
                        </tr>
                        <tr>
                            <td valign="top"><?php if ($r[payment] == "L/C") { ?>
                                    L/C DATE
                                <?php } ?></td>
                            <td valign="top"><?php if ($r[payment] == "L/C") { ?>
                                    :<?php echo date('d.m.y', strtotime($r[tgl_lc])); ?>
                                <?php } ?></td>
                        </tr>
                        <tr>
                            <td colspan="2" rowspan="2"><?php echo strtoupper($r[l_area]); ?></td>
                        </tr>
                        <tr>
                            <td colspan="2">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="2">&nbsp;</td>
                            <td colspan="2">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="2">PRICES ARE IN US DOLLAR <?php echo $r[incoterm]; ?> <?php if ($r[incoterm] == "FOB") {
                                                                                                    echo "JAKARTA, INDONESIA";
                                                                                                } else if ($r[incoterm] == "EXWORK") {
                                                                                                    echo "";
                                                                                                } else {
                                                                                                    echo $r[t_country];
                                                                                                } ?></td>
                            <td colspan="2">&nbsp;</td>
                        </tr>
                    </table>
                    <table width="100%" border="0" class="table-list1" style="width:7.8in">
                        <tr align="center">
                            <th width="21" rowspan="2" valign="middle" scope="col">NO</th>
                            <th width="136" rowspan="2" valign="middle" scope="col">PO NO</th>
                            <th width="363" rowspan="2" valign="middle" scope="col">DESCRIPTION</th>
                            <th width="45" rowspan="2" valign="middle" scope="col">COLOR</th>
                            <th width="38" rowspan="2" valign="middle" scope="col">UNIT PRICE</th>
                            <th colspan="2" scope="col">QTY</th>
                            <th width="57" rowspan="2" valign="middle" scope="col">AMOUNT US$</th>
                        </tr>
                        <tr align="center">
                            <th width="28">KGS</th>
                            <th width="27">YDS</th>
                        </tr>
                        <?PHP $sql1 = mysql_query(" SELECT b.* FROM tbl_exim a
INNER JOIN tbl_exim_detail b ON a.id=b.id_list
WHERE a.listno='$_GET[listno]'
GROUP BY b.no_po ORDER BY id ASC");
                        $no = 1;
                        $kgs = 0;
                        $yds = 0;
                        $pcs = 0;
                        $amount = 0;
                        while ($r1 = mysql_fetch_array($sql1)) {

                        ?>
                            <tr>
                                <td align="center" valign="middle" style="border-bottom:0px #000000 solid;
	border-top:0px #000000 solid;">&nbsp;</td>
                                <td align="center" valign="middle" style="border-bottom:0px #000000 solid;
	border-top:0px #000000 solid;">&nbsp;</td>
                                <td style="border-bottom:0px #000000 solid;
	border-top:0px #000000 solid;">&nbsp;</td>
                                <td align="center" valign="middle" style="border-bottom:0px #000000 solid;
	border-top:0px #000000 solid;">&nbsp;</td>
                                <td align="center" valign="middle" style="border-bottom:0px #000000 solid;
	border-top:0px #000000 solid;">&nbsp;</td>
                                <td align="center" valign="middle" style="border-bottom:0px #000000 solid;
	border-top:0px #000000 solid;">&nbsp;</td>
                                <td align="center" valign="middle" style="border-bottom:0px #000000 solid;
	border-top:0px #000000 solid;">&nbsp;</td>
                                <td align="right" valign="middle" style="border-bottom:0px #000000 solid;
	border-top:0px #000000 solid;">&nbsp;</td>
                            </tr>
                            <tr valign="top">
                                <td align="center" style="border-bottom:0px #000000 solid;
	border-top:0px #000000 solid;"><?php echo $no; ?></td>
                                <td align="center" style="border-bottom:0px #000000 solid;
	border-top:0px #000000 solid;"><?php echo $r1[no_po]; ?></td>
                                <td style="border-bottom:0px #000000 solid;
	border-top:0px #000000 solid;
	border-left:1px #000000 solid;
	border-right:1px #000000 solid;"><?php echo "PI NO.: " . $r1[no_order] . "<br>" . $r1[no_item] . " " . $r1[deskripsi]; ?></td>
                                <td align="center" style="border-bottom:0px #000000 solid;
	border-top:0px #000000 solid;
	border-left:1px #000000 solid;
	border-right:1px #000000 solid;">&nbsp;</td>
                                <td align="center" style="border-bottom:0px #000000 solid;
	border-top:0px #000000 solid;
	border-left:1px #000000 solid;
	border-right:1px #000000 solid;">&nbsp;</td>
                                <td align="center" style="border-bottom:0px #000000 solid;
	border-top:0px #000000 solid;
	border-left:1px #000000 solid;
	border-right:1px #000000 solid;">&nbsp;</td>
                                <td align="center" style="border-bottom:0px #000000 solid;
	border-top:0px #000000 solid;
	border-left:1px #000000 solid;
	border-right:1px #000000 solid;">&nbsp;</td>
                                <td align="right" style="border-bottom:0px #000000 solid;
	border-top:0px #000000 solid;
	border-left:1px #000000 solid;
	border-right:1px #000000 solid;">&nbsp;</td>
                            </tr>
                            <?php
                            $sqldt1 = mysql_query("SELECT sum(if(a.sisa='FOC',a.weight,a.weight)) as kgs,sum(if(a.sisa='FOC',a.yard_,a.yard_))as yds,sum(if(a.sisa='FOC',b.netto,b.netto))as pcs,sum(if(a.sisa='FOC',a.weight,0)) as kgs_foc,sum(if(a.sisa='FOC',a.yard_,0))as yds_foc,b.ukuran,c.user_packing ,c.warna,d.unit_price,d.price_by
FROM detail_pergerakan_stok a
INNER JOIN tmp_detail_kite b ON b.id=a.id_detail_kj
INNER JOIN tbl_kite c ON c.id=b.id_kite
INNER JOIN tbl_exim_detail d ON a.lott=d.id
WHERE refno='$_GET[listno]' AND c.no_po='$r1[no_po]' AND NOT ISNULL(a.lott)
GROUP BY b.ukuran,c.warna
ORDER BY a.lott ASC");
                            while ($r2 = mysql_fetch_array($sqldt1)) {
                            ?>
                                <tr valign="middle">
                                    <td align="center" style="border-bottom:0px #000000 solid;
	border-top:0px #000000 solid;">&nbsp;</td>
                                    <td align="center" style="border-bottom:0px #000000 solid;
	border-top:0px #000000 solid;">&nbsp;</td>
                                    <td style="border-bottom:0px #000000 solid;
	border-top:0px #000000 solid;
	border-left:1px #000000 solid;
	border-right:1px #000000 solid;">&nbsp;</td>
                                    <td align="center" style="border-bottom:0px #000000 solid;
	border-top:0px #000000 solid;"><?php echo $r2[warna]; ?></td>
                                    <td align="center" style="border-bottom:0px #000000 solid;
	border-top:0px #000000 solid;"><?php
                                    echo $r2[unit_price]; ?></td>
                                    <td align="center" style="border-bottom:0px #000000 solid;
	border-top:0px #000000 solid;"><?php
                                    if ($r2[kgs] != "") {
                                        echo number_format($r2[kgs], 2);
                                    } else {
                                        echo "-";
                                    } ?></td>
                                    <td align="center" style="border-bottom:0px #000000 solid;
	border-top:0px #000000 solid;"><?php if ($r2[yds] != "") {
                                        echo number_format($r2[yds], 2);
                                    } else {
                                        echo "-";
                                    } ?></td>
                                    <td align="right" style="border-bottom:0px #000000 solid;
	border-top:0px #000000 solid;"><?php if ($r2[price_by] == "KGS") {
                                        $am = round($r2[kgs] * $r2[unit_price], 2);
                                        echo number_format($am, 2);
                                    } else if ($r2[price_by] == "YDS") {
                                        $am = $r2[yds] * $r2[unit_price];
                                        echo number_format($am, 2);
                                    } else if ($r2[price_by] == "PCS") {
                                        $am = $r2[pcs] * $r2[unit_price];
                                        echo number_format($am, 2);
                                    } else {
                                        echo "0";
                                    }
                                    $amt = $amt + $am;
                                    $kgs = number_format($r2[kgs] + $kgs, 2, ".", "");
                                    $yds = number_format($r2[yds] + $yds, 2, ".", "");
                                    $pcs = $r2[pcs] + $pcs; ?></td>
                                </tr>
                        <?php
                            }
                            $no++;
                        } ?>
                        <tr>
                            <td align="center" valign="middle" style="border-bottom:0px #000000 solid;
	border-top:0px #000000 solid;">&nbsp;</td>
                            <td align="center" valign="middle" style="border-bottom:0px #000000 solid;
	border-top:0px #000000 solid;">&nbsp;</td>
                            <td style="border-bottom:0px #000000 solid;
	border-top:0px #000000 solid;">&nbsp;</td>
                            <td align="center" valign="middle" style="border-bottom:0px #000000 solid;
	border-top:0px #000000 solid;">&nbsp;</td>
                            <td align="center" valign="middle" style="border-bottom:0px #000000 solid;
	border-top:0px #000000 solid;">&nbsp;</td>
                            <td align="center" valign="middle" style="border-bottom:0px #000000 solid;
	border-top:0px #000000 solid;">&nbsp;</td>
                            <td align="center" valign="middle" style="border-bottom:0px #000000 solid;
	border-top:0px #000000 solid;">&nbsp;</td>
                            <td align="right" valign="middle" style="border-bottom:0px #000000 solid;
	border-top:0px #000000 solid;">&nbsp;</td>
                        </tr>
                        <tr>
                            <td align="center" valign="middle" style="border-bottom:0px #000000 solid;
	border-top:0px #000000 solid;">&nbsp;</td>
                            <td align="center" valign="middle" style="border-bottom:0px #000000 solid;
	border-top:0px #000000 solid;">&nbsp;</td>
                            <td style="border-bottom:0px #000000 solid;
	border-top:0px #000000 solid;">&nbsp;</td>
                            <td align="center" valign="middle" style="border-bottom:0px #000000 solid;
	border-top:0px #000000 solid;">&nbsp;</td>
                            <td align="center" valign="middle" style="border-bottom:0px #000000 solid;
	border-top:0px #000000 solid;">&nbsp;</td>
                            <td align="center" valign="middle" style="border-bottom:0px #000000 solid;
	border-top:0px #000000 solid;">&nbsp;</td>
                            <td align="center" valign="middle" style="border-bottom:0px #000000 solid;
	border-top:0px #000000 solid;">&nbsp;</td>
                            <td align="right" valign="middle" style="border-bottom:0px #000000 solid;
	border-top:0px #000000 solid;">&nbsp;</td>
                        </tr>
                        <tr>
                            <td align="center" valign="middle" style="border-bottom:0px #000000 solid;
	border-top:0px #000000 solid;">&nbsp;</td>
                            <td align="center" valign="middle" style="border-bottom:0px #000000 solid;
	border-top:0px #000000 solid;">&nbsp;</td>
                            <td style="border-bottom:0px #000000 solid;
	border-top:0px #000000 solid;">SURCHARGE</td>
                            <td align="center" valign="middle" style="border-bottom:0px #000000 solid;
	border-top:0px #000000 solid;">&nbsp;</td>
                            <td align="center" valign="middle" style="border-bottom:0px #000000 solid;
	border-top:0px #000000 solid;">&nbsp;</td>
                            <td align="center" valign="middle" style="border-bottom:0px #000000 solid;
	border-top:0px #000000 solid;">&nbsp;</td>
                            <td align="center" valign="middle" style="border-bottom:0px #000000 solid;
	border-top:0px #000000 solid;">&nbsp;</td>
                            <td align="right" valign="middle" style="border-bottom:0px #000000 solid;
	border-top:0px #000000 solid;"><?php if ($r[s_charge] != "") {
                                        echo number_format($r[s_charge], 2, ".", "");
                                    } else {
                                        echo "0";
                                    } ?></td>
                        </tr>
                        <tr>
                            <td align="center" valign="middle" style="border-bottom:0px #000000 solid;
	border-top:0px #000000 solid;">&nbsp;</td>
                            <td align="center" valign="middle" style="border-bottom:0px #000000 solid;
	border-top:0px #000000 solid;">&nbsp;</td>
                            <td style="border-bottom:0px #000000 solid;
	border-top:0px #000000 solid;">&nbsp;</td>
                            <td align="center" valign="middle" style="border-bottom:0px #000000 solid;
	border-top:0px #000000 solid;">&nbsp;</td>
                            <td align="center" valign="middle" style="border-bottom:0px #000000 solid;
	border-top:0px #000000 solid;">&nbsp;</td>
                            <td align="center" valign="middle" style="border-bottom:0px #000000 solid;
	border-top:0px #000000 solid;">&nbsp;</td>
                            <td align="center" valign="middle" style="border-bottom:0px #000000 solid;
	border-top:0px #000000 solid;">&nbsp;</td>
                            <td align="right" valign="middle" style="border-bottom:0px #000000 solid;
	border-top:0px #000000 solid;">&nbsp;</td>
                        </tr>

                        <tr>
                            <td align="center" valign="middle">&nbsp;</td>
                            <td align="center" valign="middle">&nbsp;</td>
                            <td>&nbsp;</td>
                            <td colspan="2" align="center" valign="middle">AMOUNT</td>
                            <td align="center" valign="middle"><?php if ($kgs > 0) {
                                                                    echo number_format($kgs, 2);
                                                                } else {
                                                                    echo "-";
                                                                } ?></td>
                            <td align="center" valign="middle"><?php if ($yds > 0) {
                                                                    echo number_format($yds, 2);
                                                                } else {
                                                                    echo "-";
                                                                } ?></td>
                            <td align="right" valign="middle"><?php echo number_format($amt + $r[s_charge], 2); ?></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SAYS USD <?php echo strtoupper(convert_number_to_words(number_format($amt + $r[s_charge], 2, ".", ""))); ?>
    <p>&nbsp;</p>
    <div align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php if ($r[payment] == "FOC") {
                                                                                                                                                        echo "NO COMMERCIAL VALUE, VALUE FOR CUSTOM PURPUSE ONLY";
                                                                                                                                                    } ?></div>
    <div align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;PT. INDO TAICHEN TEXTILE INDUSTY</div>
    <p>&nbsp;</p>
    <div>&nbsp;</div>
    <div align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;AUTHORIZED SIGNATORY</div>


</body>
<script>
    window.onkeydown = function(event) {
        if (event.keyCode == 27) {
            window.close();
        }
    };
</script>

</html>