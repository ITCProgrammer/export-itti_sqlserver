<?php
session_start();
include '../koneksi.php';
?>
<div class="modal-content">
    <form method="post" enctype="multipart/form-data" action="pages/post_add_si.php" class="form-horizontal">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
            <div class="col-md-12">
                <?php

                function no_urut()
                {
                    date_default_timezone_set("Asia/Jakarta");
                    $format = date("ym");
                    $sql = mysql_query("SELECT `no_sa` FROM `tbl_exim_sa` WHERE substr(`no_sa`,1,4) like '" . $format . "%' ORDER BY `no_sa` DESC LIMIT 1 ") or die(mysql_error());
                    $d = mysql_num_rows($sql);
                    if ($d > 0) {
                        $r = mysql_fetch_array($sql);
                        $d = $r['no_sa'];
                        $str = substr($d, 4, 3);
                        $Urut = (int)$str;
                    } else {
                        $Urut = 0;
                    }
                    $Urut = $Urut + 1;
                    $Nol = "";
                    $nilai = 3 - strlen($Urut);
                    for ($i = 1; $i <= $nilai; $i++) {
                        $Nol = $Nol . "0";
                    }
                    $nipbr = $format . $Nol . $Urut;
                    return $nipbr;
                }
                $nou = no_urut();


                $sqlcek = mysql_query("SELECT COUNT(*) as jml FROM tbl_exim WHERE listno='$_GET[no]'");
                $cek = mysql_fetch_array($sqlcek);
                if ($_GET[no] != "") {
                    if ($cek[jml] == "0") {
                        echo "<script>alert('Invoice: $_GET[no] not found!');window.location='?p=tambah-sa&no=';</script>";
                    }
                }
                $sqlcek = mysql_query("SELECT * FROM tbl_exim_si WHERE no_si='$_GET[si]' LIMIT 1");
                $row = mysql_fetch_array($sqlcek);
                ?>

                <table width="100%" border="0" class="table">
                    <tr>
                        <th colspan="6">ADD SHIPMENT ADVICE</th>
                    </tr>
                    <tr>
                        <td width="18%">No Urut</td>
                        <td width="1%">:</td>
                        <td width="81%" colspan="4"><input class="form-control input-sm" name="no_sa" type="text" id="no_sa" required value="<?php echo $nou; ?>" readonly />
                            <input type="hidden" name="no" id="no" value="<?php echo $_GET['no'] ?>">
                        </td>
                    </tr>
                    <tr>
                        <td>No CI</td>
                        <td>:</td>
                        <td colspan="4"><input class="form-control input-sm" type="text" name="no_ci" id="no_ci" value="<?php echo strtoupper($_GET['ci']); ?>" readonly /></td>
                    </tr>
                    <tr>
                        <td>Ambil Data SI</td>
                        <td>&nbsp;</td>
                        <td colspan="4"><select class="form-control input-xs" name="no_si" id="no_si" data-ci="<?php echo $_GET['ci']; ?>">
                                <option value="">Pilih</option>
                                <?php $qrysi = mysql_query("SELECT * FROM tbl_exim_si");
                                while ($rsi = mysql_fetch_assoc($qrysi)) { ?>
                                    <option value="<?php echo $rsi[no_si]; ?>" <?php if ($_GET[si] == $rsi[no_si]) {
                                                                                    echo "SELECTED";
                                                                                } ?>><?php echo $rsi[no_si]; ?></option>
                                <?php } ?>
                            </select></td>
                    </tr>
                    <tr>
                        <td>Attn</td>
                        <td>:</td>
                        <td colspan="4"><input class="form-control input-sm" name="attn" type="text" id="attn" value="IMPORT DEPARTEMENT" size="50" /></td>
                    </tr>
                    <tr>
                        <td valign="top">Tgl SA</td>
                        <td valign="top">:</td>
                        <td colspan="4" valign="top"><input class="form-control input-sm datepicker" name="tgl_si" type="text" id="tgl_si" />
                        </td>
                    </tr>
                    <tr>
                        <td valign="top">Invoice Value(USD)</td>
                        <td valign="top">:</td>
                        <td colspan="4" valign="top"><input class="form-control input-sm" name="inv_value" type="text" id="inv_value" size="10" /></td>
                    </tr>
                    <tr>
                        <td valign="top">Merchandise</td>
                        <td valign="top">:</td>
                        <td colspan="4" valign="top"><input class="form-control input-sm" name="merchandise" type="text" id="merchandise" value="<?php echo $row[descr]; ?>" size="60" /></td>
                    </tr>

                    <tr>
                        <td valign="top">Qty</td>
                        <td valign="top">:</td>
                        <td colspan="4" valign="top"><input class="form-control input-sm" name="qty" type="text" id="qty" value="<?php echo $row[nw]; ?>" size="10" /></td>
                    </tr>
                    <tr>
                        <td valign="top">Package</td>
                        <td valign="top">:</td>
                        <td colspan="4" valign="top"><input class="form-control input-sm" name="package" type="text" id="package" value="<?php echo $row[meas]; ?>" size="10" /> <input class="form-control input-sm" name="author" type="hidden" id="author" readonly="readonly" value="<?php echo strtoupper($_SESSION['usernm1']); ?>" tabindex="26" /></td>
                    </tr>
                    <tr>
                        <td colspan="6" valign="top">&nbsp;</td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" id="save" name="save" value="save" class="btn btn-info"><i class="fa fa-bookmark" aria-hidden="true"></i>
                SUBMIT CHANGE </button>
            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-window-close" aria-hidden="true"></i>
                CANCEL</button>
        </div>
    </form>
</div>
<script>
    $(function() {
        $('.datepicker').datepicker({
            autoclose: true,
            format: 'yyyy-mm-dd',
            todayHighlight: true,
        })
    })

    $(document).on('change', '#no_si', function() {
        let ci = $(this).attr('data-ci')
        let si = $(this).find(':selected').val()

        $.ajax({
            dataType: "json",
            type: "POST",
            url: "API/Get_data_si.php",
            data: {
                ci: ci,
                si: si
            },
            success: function(response) {
                if (response.kode == 200) {
                    $('#merchandise').val(response.descr)
                    $('#qty').val(response.nw)
                    $('#package').val(response.meas)
                } else {
                    toastr.error('data not found !')
                }
            },
            error: function() {
                alert("Error, Hubungi DIT team!");
            }
        });
    })
</script>