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

    #nocetak {
        display: none;
    }
</style>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>PRINT SHIPMENT ADVICE</title>
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
    $sql = mysql_query("SELECT *,DATE_FORMAT(now(),'%Y-%m-%d') as skrg FROM tbl_exim WHERE id='$_GET[id]'");
    $r = mysql_fetch_array($sql);
    $sql1 = mysql_query("SELECT * FROM tbl_exim_si WHERE no_si='$r[no_si]'");
    $r1 = mysql_fetch_array($sql1);
    $sql2 = mysql_query("SELECT * FROM tbl_exim_sa WHERE no_sa='$r[no_sa]'");
    $r2 = mysql_fetch_array($sql2);
    ?>
    <table width="100%" border="0" class="noborder" style="width:7.8in;">
        <tbody>
            <tr>
                <td height="103" colspan="7" align="center">
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
            <tr>
                <td colspan="7" align="center">
                    <font size="+2">SHIPMENT ADVICE</font>
                </td>
            </tr>
            <tr>
                <td width="106">&nbsp;</td>
                <td width="3">&nbsp;</td>
                <td width="269">&nbsp;</td>
                <td width="85">&nbsp;</td>
                <td width="85">&nbsp;</td>
                <td width="85">&nbsp;</td>
                <td width="86">&nbsp;</td>
            </tr>
            <tr>
                <td valign="top">FAX TO</td>
                <td valign="top">:</td>
                <td colspan="3" valign="top"><?php echo $r[nm_messrs]; ?></td>
                <td colspan="2" valign="top">DATED :
                    <?php if ($r2[tgl] != "") {
                        echo date('d.m.Y', strtotime($r2[tgl]));
                    } ?></td>
            </tr>
            <tr height="8">
                <td valign="top"></td>
                <td valign="top"></td>
                <td colspan="5" valign="top"></td>
            </tr>
            <tr>
                <td valign="top">ATTN</td>
                <td valign="top">:</td>
                <td colspan="5" valign="top"><?php echo strtoupper($r2[attn]); ?></td>
            </tr>
            <tr height="8">
                <td valign="top"></td>
                <td valign="top"></td>
                <td colspan="5" valign="top"></td>
            </tr>
            <tr>
                <td valign="top">L/C NO.</td>
                <td valign="top">:</td>
                <td colspan="3" valign="top"><?php if ($r[no_lc] != "") {
                                                    echo $r[no_lc];
                                                } else {
                                                    echo "-";
                                                } ?></td>
                <td colspan="2" valign="top">DATED ISSUE :
                    <?php if ($r[tgl_lc] != "0000-00-00") {
                        echo date('d.m.Y', strtotime($r[tgl_lc]));
                    } else {
                        echo "-";
                    } ?></td>
            </tr>
            <tr height="8">
                <td valign="top"></td>
                <td valign="top"></td>
                <td colspan="5" valign="top"></td>
            </tr>
            <tr>
                <td valign="top">SHIPPER</td>
                <td valign="top">:</td>
                <td colspan="5" valign="top">PT. INDO TAICHEN TEXTILE INDUSTRY<br />
                    JL. GATOT SUBROTO KM. 3 JL. KALISABI UWUNG JAYA, CIBODAS<br />
                    KOTA TANGERANG BANTEN 15138. P.O.BOX 487 - BANTEN - INDONESIA<br />
                    PHONE : ( 021 ) - 5520920(HUNTING), FAX : ( 021 ) - 5523763,55790329,5520035(ACC)</td>
            </tr>
            <tr height="8">
                <td valign="top"></td>
                <td valign="top"></td>
                <td colspan="5" valign="top"></td>
            </tr>
            <tr>
                <td valign="top">CONSIGNEE</td>
                <td valign="top">:</td>
                <td colspan="5" valign="top"><?php echo $r[nm_consign]; ?><br />
                    <?php echo $r[alt_consign]; ?></td>
            </tr>
            <tr height="8">
                <td valign="top"></td>
                <td valign="top"></td>
                <td colspan="5" valign="top"></td>
            </tr>
            <tr>
                <td valign="top">INVOICE VALUE</td>
                <td valign="top">:</td>
                <td colspan="5" valign="top">USD. <?php echo number_format($r2[inv_value], 2, ".", ","); ?></td>
            </tr>
            <tr height="8">
                <td valign="top"></td>
                <td valign="top"></td>
                <td colspan="5" valign="top"></td>
            </tr>
            <tr>
                <td valign="top">INVOICE NO</td>
                <td valign="top">:</td>
                <td colspan="3" valign="top"><?php echo strtoupper($r[listno]); ?></td>
                <td valign="top">&nbsp;</td>
                <td valign="top">&nbsp;</td>
            </tr>
            <tr height="8">
                <td valign="top"></td>
                <td valign="top"></td>
                <td colspan="5" valign="top"></td>
            </tr>
            <tr>
                <td valign="top">PACKAGES</td>
                <td valign="top">:</td>
                <td colspan="3" valign="top"><?php echo $r1[meas]; ?></td>
                <td colspan="2" valign="top">NW : <?php echo number_format($r1[nw], 2); ?> KG(S)</td>
            </tr>
            <tr height="8">
                <td valign="top"></td>
                <td valign="top"></td>
                <td colspan="5" valign="top"></td>
            </tr>
            <tr>
                <td valign="top">MERCHANDISE</td>
                <td valign="top">:</td>
                <td colspan="5" valign="top"><?php echo $r1[descr]; ?></td>
            </tr>
            <tr height="8">
                <td valign="top"></td>
                <td valign="top"></td>
                <td colspan="5" valign="top"></td>
            </tr>
            <tr>
                <td valign="top">SHIPMENT FROM</td>
                <td valign="top">:</td>
                <td colspan="5" valign="top"><?php echo $r[f_country]; ?> &nbsp;&nbsp; TO : <?php echo $r[t_country]; ?></td>
            </tr>
            <tr height="8">
                <td valign="top"></td>
                <td valign="top"></td>
                <td colspan="5" valign="top"></td>
            </tr>
            <tr>
                <td valign="top">VESSEL NAME</td>
                <td valign="top">:</td>
                <td colspan="5" valign="top"><?php echo $r1[vessel]; ?></td>
            </tr>
            <tr height="8">
                <td valign="top"></td>
                <td valign="top"></td>
                <td colspan="5" valign="top"></td>
            </tr>
            <tr>
                <td valign="top">CONNECTING</td>
                <td valign="top">:</td>
                <td colspan="5" valign="top"><?php if ($r1[connecting] != "") {
                                                    echo $r1[connecting];
                                                } else {
                                                    echo "-";
                                                } ?></td>
            </tr>
            <tr height="8">
                <td valign="top"></td>
                <td valign="top"></td>
                <td colspan="5" valign="top"></td>
            </tr>
            <tr>
                <td valign="top">ETD JKT</td>
                <td valign="top">:</td>
                <td colspan="5" valign="top"><?php echo date('d.m.Y', strtotime($r1[etd])); ?></td>
            </tr>
            <tr height="8">
                <td valign="top"></td>
                <td valign="top"></td>
                <td colspan="5" valign="top"></td>
            </tr>
            <tr>
                <td valign="top">ETA DEST</td>
                <td valign="top">:</td>
                <td colspan="5" valign="top"><?php echo date('d.m.Y', strtotime($r1[eta])); ?></td>
            </tr>
            <tr height="8">
                <td valign="top"></td>
                <td valign="top"></td>
                <td colspan="5" valign="top"></td>
            </tr>
            <tr>
                <td valign="top">B/L NO</td>
                <td valign="top">:</td>
                <td colspan="5" valign="top"><?php echo $r[no_bl]; ?></td>
            </tr>
            <tr height="8">
                <td valign="top"></td>
                <td valign="top"></td>
                <td colspan="5" valign="top"></td>
            </tr>
            <tr>
                <td valign="top">CONTAINER NO</td>
                <td valign="top">:</td>
                <td colspan="5" valign="top"><?php echo $r[no_cont]; ?></td>
            </tr>
            <tr height="8">
                <td valign="top"></td>
                <td valign="top"></td>
                <td colspan="5" valign="top"></td>
            </tr>
            <tr>
                <td colspan="7" valign="top">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="7">VERY FAITHFULLY YOUR'S</td>
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