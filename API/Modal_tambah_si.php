<?php
session_start();
include '../koneksi.php';

function no_urut()
{
    date_default_timezone_set("Asia/Jakarta");
    $format = "/ITC/EXP/" . date("Y");
    $sql = mysql_query("SELECT `no_si` FROM `tbl_exim_si` WHERE substr(`no_si`,4,14) like '" . $format . "%' ORDER BY `no_si` DESC LIMIT 1 ") or die(mysql_error());
    $d = mysql_num_rows($sql);
    if ($d > 0) {
        $r = mysql_fetch_array($sql);
        $d = $r['no_si'];
        $str = substr($d, 0, 3);
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
    $nipbr = $Nol . $Urut . $format;
    return $nipbr;
}
$nou = no_urut();
?>
<div class="modal-content">
    <form method="post" enctype="multipart/form-data" action="pages/post_tambah_si.php" class="form-horizontal">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title text-center"></h4>
        </div>
        <div class="modal-body">
            <div class="col-md-12">
                <?php
                $today    = mysql_fetch_array(mysql_query("SELECT DATE_FORMAT(now(),'%Y-%m-%d') AS tgl"));
                ?>
                <table width="100%" border="0" class="table">
                    <tr>
                        <th colspan="6">ADD SHIPPING INSTRUCTION</th>
                    </tr>
                    <tr>
                        <td>No Invoice</td>
                        <td>:</td>
                        <td colspan="4">
                            <input class="form-control input-sm" type="text" name="no_inv" id="no_inv" readonly value="<?php echo $_GET[ci]; ?>" />
                        </td>
                    </tr>
                    <tr>
                        <td width="236">No SI</td>
                        <td width="3">:</td>
                        <td width="938" colspan="4"><input class="form-control input-sm" name="no_si" type="text" id="no_si" required value="<?php echo $nou; ?>" /> </td>
                    </tr>
                    <tr>
                        <td valign="top">Forwarder</td>
                        <td valign="top">:</td>
                        <td colspan="4" valign="top"><select class="form-control input-sm" name="forwarder" id="forwarder">
                                <option value="">Pilih</option>
                                <?php $qry_forwarder = mysql_query("SELECT * FROM tbl_exim_forwarder ORDER BY nama ASC");
                                while ($rowf = mysql_fetch_assoc($qry_forwarder)) { ?>
                                    <option value="<?php echo $rowf[nama]; ?>" <?php if ($_GET[fwd] == $rowf[nama]) {
                                                                                    echo "SELECTED";
                                                                                } ?>><?php echo $rowf[nama]; ?></option>
                                <?php } ?>
                            </select></td>
                    </tr>
                    <tr>
                        <td valign="top">PIC</td>
                        <td valign="top">:</td>
                        <td colspan="4" valign="top"><input class="form-control input-sm" name="pic" type="text" id="pic" /></td>
                    </tr>
                    <tr>
                        <td valign="top">Email</td>
                        <td valign="top">:</td>
                        <td colspan="4" valign="top"><input class="form-control input-sm" name="email" type="email" id="email" /></td>
                    </tr>
                    <tr>
                        <td valign="top">Tgl SI</td>
                        <td valign="top">:</td>
                        <td colspan="4" valign="top"><input class="form-control input-sm datepicker" name="tgl_si" type="text" id="tgl_si" value="<?php echo $today[tgl]; ?>" size="10" />
                        </td>
                    </tr>
                    <tr>
                        <td valign="top">Desc</td>
                        <td valign="top">:</td>
                        <td colspan="4" valign="top"><textarea class="form-control input-sm" name="deskripsi" id="deskripsi" cols="45" rows="3"></textarea></td>
                    </tr>
                    <tr>
                        <td valign="top">Status</td>
                        <td valign="top">:</td>
                        <td colspan="4" valign="top">
                            <div class="form-group">
                                <div class="col-md-5">
                                    <select class="form-control input-sm" name="status" id="status">
                                        <option>Pilih</option>
                                        <option value="-">-</option>
                                        <option value="LCL">LCL</option>
                                        <option value="FCL">FCL</option>
                                    </select>
                                </div>
                                <div class="col-md-5">
                                    <input class="form-control input-sm" name="cmb" type="text" id="cmb" size="10" />
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top">GW</td>
                        <td valign="top">:</td>
                        <td colspan="4" valign="top"><input class="form-control input-sm" name="gw" type="text" id="gw" size="10" /></td>
                    </tr>
                    <tr>
                        <td valign="top">NW</td>
                        <td valign="top">:</td>
                        <td colspan="4" valign="top"><input class="form-control input-sm" name="nw" type="text" id="nw" size="10" /></td>
                    </tr>
                    <tr>
                        <td valign="top">Package</td>
                        <td valign="top">:</td>
                        <td colspan="4" valign="top"><input class="form-control input-sm" name="meas" type="text" id="meas" size="10" /></td>
                    </tr>
                    <tr>
                        <td valign="top">Vassel Name</td>
                        <td valign="top">:</td>
                        <td colspan="4" valign="top"><input class="form-control input-sm" name="vassel" type="text" id="vassel" size="30" /></td>
                    </tr>
                    <tr>
                        <td valign="top">ETD</td>
                        <td valign="top">:</td>
                        <td colspan="4" valign="top"><input class="form-control input-sm datepicker" name="etd" type="text" id="etd" size="10" />
                        </td>
                    </tr>
                    <tr>
                        <td valign="top">ETA</td>
                        <td valign="top">:</td>
                        <td colspan="4" valign="top"><input class="form-control input-sm date-picker" name="eta" type="text" id="eta" />
                        </td>
                    </tr>
                    <tr>
                        <td valign="top">Connecting</td>
                        <td valign="top">:</td>
                        <td colspan="4" valign="top"><input class="form-control input-sm" name="connecting" type="text" id="connecting" size="10" /></td>
                    </tr>
                    <tr>
                        <td valign="top">ETD Connecting</td>
                        <td valign="top">:</td>
                        <td colspan="4" valign="top"><input class="form-control input-sm datepicker" name="etd_con" type="text" id="etd_con" />
                        </td>
                    </tr>
                    <tr>
                        <td valign="top">Destination</td>
                        <td valign="top">:</td>
                        <td colspan="4" valign="top"><input class="form-control input-sm" name="destinasi" type="text" id="kode8" size="10" /></td>
                    </tr>
                    <tr>
                        <td valign="top">Freight</td>
                        <td valign="top">:</td>
                        <td colspan="4" valign="top"><select class="form-control input-sm" name="freight" id="freihgt">
                                <option value="">Pilih</option>
                                <option value="PREPAID">PREPAID</option>
                                <option value="COLLECT">COLLECT</option>
                            </select></td>
                    </tr>
                    <tr>
                        <td valign="top">Remark</td>
                        <td valign="top">:</td>
                        <td colspan="4" valign="top"><textarea class="form-control input-sm" name="remark" id="remark" cols="60" rows="5" tabindex="27"><?php if ($row[r_si] != "") {
                                                                                                                                                            echo $row[r_si];
                                                                                                                                                        } else {
                                                                                                                                                            echo "1. Please proceed the P.E and P.E.B for us accordingly
2. The goods will send to your ware house on 
3. Please send the D/O";
                                                                                                                                                        } ?></textarea></td>
                    </tr>
                    <tr>
                        <td valign="top">Fasilitas</td>
                        <td valign="top">:</td>
                        <td colspan="4" valign="top"><select class="form-control input-sm" name="fasilitas" id="fasilitas">
                                <option value="UMUM">UMUM</option>
                                <option value="KITE">KITE</option>
                            </select></td>
                    </tr>
                    <tr>
                        <td valign="top">Warehouse</td>
                        <td valign="top">:</td>
                        <td colspan="4" valign="top"><textarea class="form-control input-sm" name="warehouse" id="warehouse" cols="45" rows="3"></textarea></td>
                    </tr>
                    <tr>
                        <td valign="top">Author</td>
                        <td valign="top">:</td>
                        <td colspan="4" valign="top"><input class="form-control input-sm" name="author" type="text" id="author" readonly="readonly" value="<?php if ($row[author] != "") {
                                                                                                                                                                echo $row['author'];
                                                                                                                                                            } else {
                                                                                                                                                                echo strtoupper($_SESSION['usernm1']);
                                                                                                                                                            } ?>" tabindex="26" /></td>
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

        $(document).on('change', '#forwarder', function() {
            let ci = $('#no_inv').val();
            let fwd = $(this).find(':selected').val();

            $.ajax({
                dataType: "json",
                type: "POST",
                url: "API/get_data_forwarder.php",
                data: {
                    ci: ci,
                    fwd: fwd
                },
                success: function(response) {
                    if (response.kode == 200) {
                        $('#pic').val(response.data.pic)
                        $('#email').val(response.data.email)
                    } else {
                        toastr.error('data tidak ditemukan !')
                    }
                },
                error: function() {
                    alert("Error, Hubungi DIT team!");
                }
            });
        })
    })
</script>