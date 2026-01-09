<?php
include "../../koneksi.php";
?>
<style>
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

    @media print {
        #nocetak {
            display: none;
        }
    }
</style>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>PRINT SHIPPING INSRUCTION</title>
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
    $sql = mysql_query("SELECT a.*,b.nm_consign,b.alt_consign,b.nm_messrs,b.alt_messrs,b.payment FROM tbl_exim_si a 
LEFT JOIN tbl_exim b ON a.no_si=b.no_si
WHERE a.no_si='$_GET[no]'");
    $r = mysql_fetch_array($sql);

    ?>
    <a href="print-si-nk-excel.php?no=<?PHP echo $_GET[no]; ?>&ket="><img src="../btn_print.png" width="20" height="22" alt="" id="nocetak" /></a>
    <table width="100%" border="0" class="noborder" style="width:7.8in;">
        <tbody>
            <tr>
                <td colspan="7" align="center">
                    <font size="+2">SHIPPING INSTUCTION</font>
                </td>
            </tr>
            <tr>
                <td width="102">&nbsp;</td>
                <td width="6">&nbsp;</td>
                <td width="331">&nbsp;</td>
                <td width="47">&nbsp;</td>
                <td width="83">&nbsp;</td>
                <td width="66">&nbsp;</td>
                <td width="84">&nbsp;</td>
            </tr>
            <tr>
                <td valign="top">TO</td>
                <td valign="top">:</td>
                <td colspan="2" valign="top"><?php echo $r[forwarder]; ?></td>
                <td align="right" valign="top">DATED :</td>
                <td colspan="2" align="left" valign="top"><?php echo date('d.m.Y', strtotime($r[tgl_si])); ?></td>
            </tr>
            <tr>
                <td valign="top">ATTN</td>
                <td valign="top">:</td>
                <td colspan="2" valign="top"><?php echo $r[pic]; ?></td>
                <td align="right" valign="top">REF :</td>
                <td colspan="2" align="left" valign="top"><?php echo $r[no_si]; ?></td>
            </tr>
            <tr>
                <td valign="top">FAX</td>
                <td valign="top">:</td>
                <td colspan="2" valign="top"><?php echo "-"; ?></td>
                <td align="right" valign="top">FROM :</td>
                <td colspan="2" align="left" valign="top"><?php echo $r[author]; ?></td>
            </tr>
            <tr>
                <td valign="top">&nbsp;</td>
                <td valign="top">&nbsp;</td>
                <td valign="top">&nbsp;</td>
                <td valign="top">&nbsp;</td>
                <td valign="top">&nbsp;</td>
                <td valign="top">&nbsp;</td>
                <td valign="top">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="7" valign="top">PLEASE PROVIDE US A SPACE AND ARRANGE THE SHIPMENT BY <?php if ($r[status] != "-") {
                                                                                                        echo "SEA";
                                                                                                    } else {
                                                                                                        echo "AIR";
                                                                                                    }; ?> WITH FOLLOWING DETAILS:</td>
            </tr>
            <tr>
                <td colspan="7" valign="top" height="8"></td>
            </tr>
            <tr>
                <td valign="top">SHIPPER</td>
                <td valign="top">:</td>
                <td colspan="3" valign="top">P.T. INDO TAICHEN TEXTILE INDUSTRY<br />
                    JL. GATOT SUBROTO KM. 3 JL. KALISABI UWUNG JAYA, CIBODAS,<br />
                    KOTA TANGERANG BANTEN 15138. P.O.BOX 487 - BANTEN - INDONESIA<br />
                    PHONE : (021)-5520920(HUNTING), FAX : (021)-5523763,55790329,5520035(ACC)</td>
                <td valign="top">&nbsp;</td>
                <td valign="top">&nbsp;</td>
            </tr>
            <tr>
                <td height="8" valign="top"></td>
                <td valign="top"></td>
                <td valign="top"></td>
                <td valign="top"></td>
                <td valign="top"></td>
                <td valign="top"></td>
                <td valign="top"></td>
            </tr>
            <tr>
                <td valign="top">CONSIGNEE</td>
                <td valign="top">:</td>
                <td colspan="3" valign="top"><?php echo $r[nm_consign]; ?><br />
                    <?php echo $r[alt_consign]; ?></td>
                <td valign="top">&nbsp;</td>
                <td valign="top">&nbsp;</td>
            </tr>
            <tr>
                <td height="8" valign="top"></td>
                <td valign="top"></td>
                <td valign="top"></td>
                <td valign="top"></td>
                <td valign="top"></td>
                <td valign="top"></td>
                <td valign="top"></td>
            </tr>
            <tr>
                <td valign="top">NOTIFY PARTY</td>
                <td valign="top">:</td>
                <td colspan="3" valign="top"><?php echo $r[nm_messrs]; ?><br />
                    <?php echo $r[alt_messrs]; ?></td>
                <td valign="top">&nbsp;</td>
                <td valign="top">&nbsp;</td>
            </tr>
            <tr>
                <td height="8" valign="top"></td>
                <td valign="top"></td>
                <td valign="top"></td>
                <td valign="top"></td>
                <td valign="top"></td>
                <td valign="top"></td>
                <td valign="top"></td>
            </tr>
            <tr>
                <td valign="top">DESC. OF GOODS</td>
                <td valign="top">:</td>
                <td valign="top"><?php echo $r[descr]; ?></td>
                <td valign="top">&nbsp;</td>
                <td valign="top">&nbsp;</td>
                <td valign="top">&nbsp;</td>
                <td valign="top">&nbsp;</td>
            </tr>
            <tr>
                <td height="8" valign="top"></td>
                <td valign="top"></td>
                <td valign="top"></td>
                <td valign="top"></td>
                <td valign="top"></td>
                <td valign="top"></td>
                <td valign="top"></td>
            </tr>
            <tr>
                <td valign="top">PAYMENT TERMS</td>
                <td valign="top">:</td>
                <td valign="top">BY <?php echo $r[payment]; ?></td>
                <td valign="top">&nbsp;</td>
                <td valign="top">&nbsp;</td>
                <td valign="top">&nbsp;</td>
                <td valign="top">&nbsp;</td>
            </tr>
            <tr>
                <td height="8" valign="top"></td>
                <td valign="top"></td>
                <td valign="top"></td>
                <td valign="top"></td>
                <td valign="top"></td>
                <td valign="top"></td>
                <td valign="top"></td>
            </tr>
            <tr>
                <td valign="top">MARKS &amp; NO.</td>
                <td valign="top">:</td>
                <td valign="top">PLEASE REFER TO PACKING LIST</td>
                <td valign="top">&nbsp;</td>
                <td valign="top">&nbsp;</td>
                <td valign="top">&nbsp;</td>
                <td valign="top">&nbsp;</td>
            </tr>
            <tr>
                <td height="8" valign="top"></td>
                <td valign="top"></td>
                <td valign="top"></td>
                <td valign="top"></td>
                <td valign="top"></td>
                <td valign="top"></td>
                <td valign="top"></td>
            </tr>
            <tr>
                <td valign="top">STATUS</td>
                <td valign="top">:</td>
                <td valign="top"><?php echo $r[status] . " " . $r[cmb]; ?></td>
                <td valign="top">&nbsp;</td>
                <td valign="top">&nbsp;</td>
                <td valign="top">&nbsp;</td>
                <td valign="top">&nbsp;</td>
            </tr>
            <tr>
                <td height="8" valign="top"></td>
                <td valign="top"></td>
                <td valign="top"></td>
                <td valign="top"></td>
                <td valign="top"></td>
                <td valign="top"></td>
                <td valign="top"></td>
            </tr>
            <tr>
                <td valign="top">GROSS WEIGHT</td>
                <td valign="top">:</td>
                <td valign="top"><?php echo number_format($r[gw], 2, ".", ","); ?> KGS</td>
                <td valign="top">&nbsp;</td>
                <td colspan="2" align="right" valign="top">NET WEIGHT </td>
                <td align="left" valign="top">: <?php echo number_format($r[nw], 2, ".", ","); ?> KGS</td>
            </tr>
            <tr>
                <td height="8" valign="top"></td>
                <td valign="top"></td>
                <td valign="top"></td>
                <td valign="top"></td>
                <td valign="top"></td>
                <td valign="top"></td>
                <td valign="top"></td>
            </tr>
            <tr>
                <td valign="top">MEASUREMENT</td>
                <td valign="top">:</td>
                <td valign="top"><?php echo $r[meas]; ?></td>
                <td valign="top">&nbsp;</td>
                <td valign="top">&nbsp;</td>
                <td valign="top">&nbsp;</td>
                <td valign="top">&nbsp;</td>
            </tr>
            <tr>
                <td height="8" valign="top"></td>
                <td valign="top"></td>
                <td valign="top"></td>
                <td valign="top"></td>
                <td valign="top"></td>
                <td valign="top"></td>
                <td valign="top"></td>
            </tr>
            <tr>
                <td valign="top">VESSEL NAME</td>
                <td valign="top">:</td>
                <td valign="top"><?php echo $r[vessel]; ?></td>
                <td valign="top">&nbsp;</td>
                <td valign="top">&nbsp;</td>
                <td valign="top">ETD JKT</td>
                <td valign="top">: <?php echo date('d.m.Y', strtotime($r[eta])); ?></td>
            </tr>
            <tr>
                <td height="8" valign="top"></td>
                <td valign="top"></td>
                <td valign="top"></td>
                <td valign="top"></td>
                <td valign="top"></td>
                <td valign="top"></td>
                <td valign="top"></td>
            </tr>
            <tr>
                <td valign="top">CONNECTING</td>
                <td valign="top">:</td>
                <td valign="top"><?php if ($r[connecting] != "") {
                                        echo $r[connecting];
                                    } else {
                                        echo "-";
                                    } ?></td>
                <td valign="top">&nbsp;</td>
                <td valign="top">&nbsp;</td>
                <td valign="top">ETD CON</td>
                <td valign="top">:
                    <?php if ($r[etd_conn] != "" and $r[etd_conn] != "0000-00-00") {
                        echo date('d.m.Y', strtotime($r[etd_conn]));
                    } else {
                        echo "-";
                    } ?></td>
            </tr>
            <tr>
                <td height="8" valign="top"></td>
                <td valign="top"></td>
                <td valign="top"></td>
                <td valign="top"></td>
                <td valign="top"></td>
                <td valign="top"></td>
                <td valign="top"></td>
            </tr>
            <tr>
                <td valign="top">DESTINATION</td>
                <td valign="top">:</td>
                <td valign="top"><?php echo $r[destinasi]; ?></td>
                <td valign="top">&nbsp;</td>
                <td valign="top">&nbsp;</td>
                <td valign="top">ETA DEST</td>
                <td valign="top">: <?php echo date('d.m.Y', strtotime($r[eta])); ?></td>
            </tr>
            <tr>
                <td height="8" valign="top"></td>
                <td valign="top"></td>
                <td valign="top"></td>
                <td valign="top"></td>
                <td valign="top"></td>
                <td valign="top"></td>
                <td valign="top"></td>
            </tr>
            <tr>
                <td valign="top">FREIGHT</td>
                <td valign="top">:</td>
                <td valign="top"><?php echo $r[freight]; ?></td>
                <td valign="top">&nbsp;</td>
                <td valign="top">&nbsp;</td>
                <td valign="top">&nbsp;</td>
                <td valign="top">&nbsp;</td>
            </tr>
            <tr>
                <td height="8" valign="top"></td>
                <td valign="top"></td>
                <td valign="top"></td>
                <td valign="top"></td>
                <td valign="top"></td>
                <td valign="top"></td>
                <td valign="top"></td>
            </tr>
            <tr>
                <td valign="top">REMARKS</td>
                <td valign="top">:</td>
                <td colspan="4" valign="top"><?php echo strtoupper($r[remark]); ?></td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td height="8" valign="top"></td>
                <td valign="top"></td>
                <td valign="top"></td>
                <td valign="top"></td>
                <td valign="top"></td>
                <td valign="top"></td>
                <td valign="top"></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td colspan="4">&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td colspan="4"># THANK'S FOR YOUR KIND ATTENTION AND ASSISTANCE #<br />
                    <?php
                    $sql1 = mysql_query("SELECT listno FROM tbl_exim WHERE no_si='$_GET[no]'");
                    $row = mysql_num_rows($sql1);
                    $no = 1;
                    while ($r1 = mysql_fetch_array($sql1)) {
                        if ($row != $no) {
                            $koma = ",";
                        } else {
                            $koma = "";
                        }
                        $no++;
                        echo $r1[listno] . $koma;
                    }
                    ?></td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td colspan="2" align="right">SINCERELY YOURS,</td>
            </tr>
        </tbody>
    </table>

</body>
<script>
    window.onkeydown = function(event) {
        if (event.keyCode == 27) {
            window.close();
        }
    };
</script>

</html>