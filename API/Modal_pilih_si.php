<?php
session_start();
include '../koneksi.php';
if ($_GET[no] != "") {
    $where = " no_si='$_GET[no]' ";
} else {
    $where = " id='$_GET[id]' ";
}
$sqlcek = mysql_query("SELECT * FROM tbl_exim_si WHERE $where LIMIT 1");
$row = mysql_fetch_array($sqlcek);
?>
<div class="modal-content">
    <form method="post" enctype="multipart/form-data" action="pages/post_pilih_si.php" class="form-horizontal">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
            <div class="col-md-12">
                <table width="100%" border="0" class="table">
                    <tr>
                        <th colspan="6">DETAIL SHIPPING INSTRUCTION</th>
                    </tr>
                    <tr>
                        <td width="236">No SI</td>
                        <td width="3">:</td>
                        <td width="938" colspan="4"><select class="form-control input-sm" name="no_si" id="no_si" data-pk="<?php echo $_GET[id]; ?>">
                                <option value="">Pilih</option>
                                <?php $qrysi = mysql_query("SELECT * FROM tbl_exim_si");
                                while ($rsi = mysql_fetch_assoc($qrysi)) { ?>
                                    <option value="<?php echo $rsi[no_si]; ?>" <?php if ($row[no_si] == $rsi[no_si]) {
                                                                                    echo "SELECTED";
                                                                                } ?>><?php echo $rsi[no_si]; ?></option>
                                <?php } ?>
                            </select>
                            <input type="hidden" name="id" id="id" value="<?php echo $_GET['id']; ?>">
                        </td>
                    </tr>
                    <tr>
                        <td valign="top">Forwarder</td>
                        <td valign="top">:</td>
                        <td colspan="4" valign="top"><select class="form-control input-sm" name="forwarder" disabled="disabled" id="forwarder">
                                <option value="">Pilih</option>
                                <?php $qry_forwarder = mysql_query("SELECT * FROM tbl_exim_forwarder");
                                while ($rowf = mysql_fetch_assoc($qry_forwarder)) { ?>
                                    <option value="<?php echo $rowf[nama]; ?>" <?php if ($_GET[fwd] != "") {
                                                                                    if ($_GET[fwd] == $rowf[nama]) {
                                                                                        echo "SELECTED";
                                                                                    }
                                                                                } else {
                                                                                    if ($row[forwarder] == $rowf[nama]) {
                                                                                        echo "SELECTED";
                                                                                    }
                                                                                } ?>><?php echo $rowf[nama]; ?></option>
                                <?php } ?>
                            </select></td>
                    </tr>
                    <?php
                    $qryfwd = mysql_query("SELECT * FROM tbl_exim_forwarder WHERE `nama`='$_GET[fwd]' limit 1");
                    $rf = mysql_fetch_assoc($qryfwd);
                    ?>
                    <tr>
                        <td valign="top">PIC</td>
                        <td valign="top">:</td>
                        <td colspan="4" valign="top"><input class="form-control input-sm" name="pic" type="text" disabled="disabled" id="pic" value="<?php if ($rf[pic] != "") {
                                                                                                                                                            echo $rf[pic];
                                                                                                                                                        } else {
                                                                                                                                                            echo $row[pic];
                                                                                                                                                        } ?>" /></td>
                    </tr>
                    <tr>
                        <td valign="top">Email</td>
                        <td valign="top">:</td>
                        <td colspan="4" valign="top"><input class="form-control input-sm" name="email" type="email" disabled="disabled" id="email" value="<?php if ($rf[email] != "") {
                                                                                                                                                                echo $rf[email];
                                                                                                                                                            } else {
                                                                                                                                                                echo $row[email];
                                                                                                                                                            } ?>" size="35" /></td>
                    </tr>
                    <tr>
                        <td valign="top">Tgl SI</td>
                        <td valign="top">:</td>
                        <td colspan="4" valign="top"><input class="form-control input-sm" name="tgl_si" type="text" disabled="disabled" id="tgl_si" tabindex="1" onclick="if(self.gfPop)gfPop.fPopCalendar(document.form1.tgl_si);return false;" value="<?php echo $row[tgl_si]; ?>" size="10" />
                        </td>
                    </tr>
                    <tr>
                        <td valign="top">Desc</td>
                        <td valign="top">:</td>
                        <td colspan="4" valign="top"><textarea class="form-control input-sm" name="deskripsi" cols="45" rows="3" disabled="disabled" id="deskripsi"><?php echo $row[descr]; ?></textarea></td>
                    </tr>
                    <tr>
                        <td valign="top">Status</td>
                        <td valign="top">:</td>
                        <td colspan="4" valign="top"><select class="form-control input-sm" name="status" disabled="disabled" id="status">
                                <option>Pilih</option>
                                <option value="-" <?php if ($row[status] == "-") {
                                                        echo "SELECTED";
                                                    } ?>>-</option>
                                <option value="LCL" <?php if ($row[status] == "LCL") {
                                                        echo "SELECTED";
                                                    } ?>>LCL</option>
                                <option value="FCL" <?php if ($row[status] == "FCL") {
                                                        echo "SELECTED";
                                                    } ?>>FCL</option>
                            </select></td>
                    </tr>
                    <tr>
                        <td valign="top">GW</td>
                        <td valign="top">:</td>
                        <td colspan="4" valign="top"><input class="form-control input-sm" name="gw" type="text" disabled="disabled" id="gw" value="<?php echo $row[gw]; ?>" size="10" /></td>
                    </tr>
                    <tr>
                        <td valign="top">NW</td>
                        <td valign="top">:</td>
                        <td colspan="4" valign="top"><input class="form-control input-sm" name="nw" type="text" disabled="disabled" id="nw" value="<?php echo $row[nw]; ?>" size="10" /></td>
                    </tr>
                    <tr>
                        <td valign="top">Meas</td>
                        <td valign="top">:</td>
                        <td colspan="4" valign="top"><input class="form-control input-sm" name="meas" type="text" disabled="disabled" id="meas" value="<?php echo $row[meas]; ?>" size="10" /></td>
                    </tr>
                    <tr>
                        <td valign="top">Vassel Name</td>
                        <td valign="top">:</td>
                        <td colspan="4" valign="top"><input class="form-control input-sm" name="vassel" type="text" disabled="disabled" id="vassel" value="<?php echo $row[vessel]; ?>" size="30" /></td>
                    </tr>
                    <tr>
                        <td valign="top">ETD</td>
                        <td valign="top">:</td>
                        <td colspan="4" valign="top"><input class="form-control input-sm" name="etd" type="text" disabled="disabled" id="etd" tabindex="1" onclick="if(self.gfPop)gfPop.fPopCalendar(document.form1.etd);return false;" value="<?php echo $row[etd]; ?>" size="10" />
                        </td>
                    </tr>
                    <tr>
                        <td valign="top">ETA</td>
                        <td valign="top">:</td>
                        <td colspan="4" valign="top"><input class="form-control input-sm" name="eta" type="text" disabled="disabled" id="eta" tabindex="1" onclick="if(self.gfPop)gfPop.fPopCalendar(document.form1.eta);return false;" value="<?php echo $row[eta]; ?>" size="10" />
                        </td>
                    </tr>
                    <tr>
                        <td valign="top">Connecting</td>
                        <td valign="top">:</td>
                        <td colspan="4" valign="top"><input class="form-control input-sm" name="connecting" type="text" disabled="disabled" id="connecting" value="<?php echo $row[connecting]; ?>" size="10" /></td>
                    </tr>
                    <tr>
                        <td valign="top">ETD Connecting</td>
                        <td valign="top">:</td>
                        <td colspan="4" valign="top"><input class="form-control input-sm" name="etd_con" type="text" disabled="disabled" id="etd_conn" tabindex="1" onclick="if(self.gfPop)gfPop.fPopCalendar(document.form1.etd_con);return false;" value="<?php echo $row[etd_conn]; ?>" size="10" />
                        </td>
                    </tr>
                    <tr>
                        <td valign="top">Destination</td>
                        <td valign="top">:</td>
                        <td colspan="4" valign="top"><input class="form-control input-sm" name="destinasi" type="text" disabled="disabled" id="destinasi" value="<?php echo $row[destinasi]; ?>" size="10" /></td>
                    </tr>
                    <tr>
                        <td valign="top">Freight</td>
                        <td valign="top">:</td>
                        <td colspan="4" valign="top"><select class="form-control input-sm" name="freight" disabled="disabled" id="freight">
                                <option>Pilih</option>
                                <option>Pilih</option>
                                <option value="PREPAID" <?php if ($row[freight] == "PREPAID") {
                                                            echo "SELECTED";
                                                        } ?>>PREPAID</option>
                                <option value="COLLECT" <?php if ($row[freight] == "COLLECT") {
                                                            echo "SELECTED";
                                                        } ?>>COLLECT</option>
                            </select></td>
                    </tr>
                    <tr>
                        <td valign="top">Remark</td>
                        <td valign="top">:</td>
                        <td colspan="4" valign="top"><textarea class="form-control input-sm" name="remark" cols="60" rows="5" disabled="disabled" id="remark" tabindex="27"><?php if ($row[remark] != "") {
                                                                                                                                                                                echo $row[remark];
                                                                                                                                                                            } else {
                                                                                                                                                                                echo "1. Please proceed the P.E and P.E.B for us accordingly
2. The goods will send to your ware house on 
3. Please send the D/O";
                                                                                                                                                                            } ?>
      </textarea></td>
                    </tr>
                    <tr>
                        <td valign="top">Fasilitas</td>
                        <td valign="top">:</td>
                        <td colspan="4" valign="top"><select class="form-control input-sm" name="fasilitas" disabled="disabled" id="fasilitas">
                                <option value="UMUM" <?php if ($row[fasilitas] == "UMUM") {
                                                            echo "SELECTED";
                                                        } ?>>UMUM</option>
                                <option value="KITE" <?php if ($row[fasilitas] == "KITE") {
                                                            echo "SELECTED";
                                                        } ?>>KITE</option>
                            </select></td>
                    </tr>
                    <tr>
                        <td valign="top">Warehouse</td>
                        <td valign="top">:</td>
                        <td colspan="4" valign="top"><textarea class="form-control input-sm" name="warehouse" cols="45" rows="3" disabled="disabled" id="warehouse"><?php echo $row[warehouse]; ?></textarea></td>
                    </tr>
                    <tr>
                        <td valign="top">Author</td>
                        <td valign="top">:</td>
                        <td colspan="4" valign="top"><input class="form-control input-sm" name="author" type="text" disabled="disabled" id="author" tabindex="26" value="<?php if ($row[author] != "") {
                                                                                                                                                                                echo $row['author'];
                                                                                                                                                                            } else {
                                                                                                                                                                                echo ucwords($_SESSION['usernm1']);
                                                                                                                                                                            } ?>" readonly="readonly" /></td>
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
        let id = $(this).attr('data-pk');
        let no = $(this).find(':selected').val()

        $.ajax({
            dataType: "json",
            type: "POST",
            url: "API/get_pilih_si.php",
            data: {
                id: id,
                no: no
            },
            success: function(response) {
                if (response.kode == 200) {
                    console.log(response.data)
                    $('#forwarder option').each(function() {
                        if ($(this).html() == response.data.no_si) {
                            $(this).attr('selected', true)
                        }
                    });
                    $('#pic').val(response.data.pic)
                    $('#email').val(response.data.email)
                    $('#tgl_si').val(response.data.tgl_si)
                    $('#deskripsi').val(response.data.descr)
                    $('#status option').each(function() {
                        if ($(this).html() == response.data.status) {
                            $(this).attr('selected', true)
                        }
                    });
                    $('#gw').val(response.data.gw)
                    $('#nw').val(response.data.nw)
                    $('#meas').val(response.data.meas)
                    $('#vassel').val(response.data.vassel)
                    $('#etd').val(response.data.etd)
                    $('#eta').val(response.data.eta)
                    $('#connecting').val(response.data.connecting)
                    $('#etd_conn').val(response.data.etd_conn)
                    $('#destinasi').val(response.data.destinasi)
                    $('#freight option').each(function() {
                        if ($(this).html() == response.data.freight) {
                            $(this).attr('selected', true)
                        }
                    });
                    $('#fasilitas option').each(function() {
                        if ($(this).html() == response.data.fasilitas) {
                            $(this).attr('selected', true)
                        }
                    });
                    $('#remark').val(response.data.remark)
                    $('#warehouse').val(response.data.warehouse)
                    $('#author').val(response.data.author)
                } else {
                    toastr.error('data tidak ditemukan !')
                }
            },
            error: function() {
                alert("Error, Hubungi DIT team!");
            }
        });
    })
</script>