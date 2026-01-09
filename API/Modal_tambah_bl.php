<?php
session_start();
include '../koneksi.php';
ini_set("error_reporting",1);
$sqlcek = mysqli_query($con,"SELECT * FROM tbl_exim WHERE listno='".$_GET['listno']."' LIMIT 1");
$rcek = mysqli_fetch_array($sqlcek);
?>
<div class="modal-content">
    <form method="post" enctype="multipart/form-data" action="pages/post_insert.php" class="form-horizontal">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title text-center">ADD PENGEMBALIAN B/L</h4>
        </div>
        <div class="modal-body">
            <div class="col-md-12">
                <table width="100%" border="0" class="table table-sm table-bordered">
                    <tr>
                        <td align="right" style="width: 100px;">No List</td>
                        <td>:</td>
                        <td colspan="5">
                            <h5><?php echo $_GET['listno'] ?></h5>
                            <input type="hidden" value="<?php echo $_GET['listno'] ?>" name="listno">
                        </td>
                    </tr>
                    <tr>
                        <td align="right" style="width: 100px;">No SI</td>
                        <td>:</td>
                        <td colspan="5"><input class="form-control input-sm" name="no_si" type="text" id="no_si" value="<?php echo $rcek['no_si']; ?>" readonly /></td>
                    </tr>
                    <tr>
                        <td align="right" style="width: 100px;" width="236">No B/L</td>
                        <td width="3">:</td>
                        <td colspan="5"><input class="form-control input-sm" name="bl_no" type="text" id="bl_no" value="<?php echo $rcek['no_bl']; ?>" /></td>
                    </tr>
                    <tr>
                        <td align="right" style="width: 100px;" valign="top">ETD</td>
                        <td valign="top">:</td>
                        <td colspan="5" valign="top"><input class="form-control input-sm datepicker" name="etd" type="text" id="etd" tabindex="1" size="10" value="<?php echo $rcek['tgl_s_f']; ?>" />
                        </td>
                    </tr>
                    <tr>
                        <td align="right" style="width: 100px;" valign="top">ETA</td>
                        <td valign="top">:</td>
                        <td colspan="5" valign="top"><input class="form-control input-sm datepicker" value="<?php echo $rcek['tgl_eta']; ?>" name="eta" type="text" id="eta" tabindex="1" size="10" />
                        </td>
                    </tr>
                    <tr>
                        <td align="right" style="width: 100px;" valign="top">Con</td>
                        <td valign="top">:</td>
                        <td colspan="5" valign="top"><input class="form-control input-sm" name="connecting" type="text" id="connecting" value="<?php echo $rcek['connecting']; ?>" /></td>
                    </tr>
                    <tr>
                        <td align="right" style="width: 100px;" valign="top">Con ETD</td>
                        <td valign="top">:</td>
                        <td colspan="5" valign="top"><input class="form-control input-sm datepicker" value="<?php echo $rcek['tgl_c']; ?>" name="con_etd" type="text" id="con_etd" tabindex="1" size="10" />
                        </td>
                    </tr>
                    <tr>
                        <td align="right" style="width: 100px;" valign="top">No Tagihan</td>
                        <td valign="top">:</td>
                        <td width="174" valign="top" rowspan="2">
                            <input class="form-control input-sm" name="no_tagihan" type="text" placeholder="Tagihan 01" id="no_tagihan" value="<?php echo $rcek['no_tagihan']; ?>" />
                            <input class="form-control input-sm" name="jml_tagihan" type="text" placeholder="Tagihan 01" id="jml_tagihan" value="<?php echo $rcek['jml_tagihan']; ?>" size="10" />
                        </td>
                        <td width="167" valign="top" rowspan="2">
                            <input class="form-control input-sm" name="no_tagihan1" type="text" placeholder="Tagihan 02" id="no_tagihan1" value="<?php echo $rcek['no_tagihan1']; ?>" />
                            <input class="form-control input-sm" name="jml_tagihan1" type="text" placeholder="Tagihan 02" id="jml_tagihan1" value="<?php echo $rcek['jml_tagihan1']; ?>" size="10" />
                        </td>
                        <td width="187" valign="top" rowspan="2">
                            <input class="form-control input-sm" name="no_tagihan2" type="text" placeholder="Tagihan 03" id="no_tagihan2" value="<?php echo $rcek['no_tagihan2']; ?>" />
                            <input class="form-control input-sm" name="jml_tagihan2" type="text" placeholder="Tagihan 03" id="jml_tagihan2" value="<?php echo $rcek['jml_tagihan2']; ?>" size="10" />
                        </td>
                        <td width="182" valign="top" rowspan="2">
                            <input class="form-control input-sm" name="no_tagihan3" type="text" placeholder="tagihan 04" id="no_tagihan3" value="<?php echo $rcek['no_tagihan3']; ?>" />
                            <input class="form-control input-sm" name="jml_tagihan3" type="text" placeholder="tagihan 04" id="jml_tagihan3" value="<?php echo $rcek['jml_tagihan3']; ?>" size="10" />
                        </td>
                        <td width="223" valign="top" rowspan="2">
                            <input class="form-control input-sm" name="no_tagihan4" type="text" placeholder="tagihan 05" id="no_tagihan4" value="<?php echo $rcek['no_tagihan4']; ?>" />
                            <input class="form-control input-sm" name="jml_tagihan4" type="text" placeholder="tagihan 05" id="jml_tagihan4" value="<?php echo $rcek['jml_tagihan4']; ?>" size="10" />
                        </td>
                        <td width="223" valign="top" rowspan="2">
                            <input disabled placeholder="field disabled" class="form-control input-sm" name="no_tagihan5" type="text" id="no_tagihan5" value="<?php echo $rcek['no_tagihan5']; ?>" />
                            <input disabled placeholder="field disabled" class="form-control input-sm" name="jml_tagihan5" type="text" id="jml_tagihan5" value="<?php echo $rcek['jml_tagihan5']; ?>" size="10" />
                        </td>
                        <td width="223" valign="top" rowspan="2">
                            <input disabled placeholder="field disabled" class="form-control input-sm" name="no_tagihan6" type="text" id="no_tagihan6" value="<?php echo $rcek['no_tagihan6']; ?>" />
                            <input disabled placeholder="field disabled" class="form-control input-sm" name="jml_tagihan6" type="text" id="jml_tagihan6" value="<?php echo $rcek['jml_tagihan6']; ?>" size="10" />
                        </td>
                    </tr>
                    <tr>
                        <td align="right" style="width: 100px;" valign="top">Jumlah Tagihan</td>
                        <td valign="top">:</td>
                    </tr>
                    <tr>
                        <td colspan="7" valign="top">&nbsp;</td>
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
</script>