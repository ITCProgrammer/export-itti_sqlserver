<?php
session_start();
include '../koneksi.php';
$sqldt = mysqli_query($con,"SELECT * FROM tbl_exim_sa WHERE no_sa='".$_GET['id']."'");
$data = mysqli_fetch_array($sqldt);
?>
<div class="modal-content">
    <form method="post" enctype="multipart/form-data" name="form_pilih_sa" id="awb_form_tambah" class="form-horizontal">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">SHIPMENT ADVICE</h4>
        </div>
        <div class="modal-body">
            <div class="col-md-12">
                <div class="form-group" style="border-bottom: solid #ddd 1px">
                    <label for="" class="col-lg-2 control-label input-sm">No. LIST:</label>
                    <div class="col-lg-9 input-group">
                        <input type="text" name="no" id="no" value="<?php echo  $_GET['listno'] ?>" class="form-control input-sm" readonly>
                    </div>
                </div>
                <div class="form-group" style="border-bottom: solid #ddd 1px; background-color: #fcf7b8;">
                    <label for="" class="col-lg-2 control-label input-sm">No. Urut:</label>
                    <div class="col-lg-9 input-group">
                        <select name="no_sa" id="no_sa" class="form-control input-sm">
                            <option selected value="">Pilih</option>
                            <?php $qrysi = mysql_query("SELECT * FROM tbl_exim_sa");
                            while ($rsi = mysql_fetch_assoc($qrysi)) { ?>
                                <option value="<?php echo $rsi['no_sa']; ?>" <?php if ($data['no_sa'] == $rsi['no_sa']) {
                                                                                    echo "SELECTED";
                                                                                } ?>><?php echo $rsi['no_sa']; ?></option>
                            <?php } ?>
                        </select>
                        <span class="text-black text-sm">Pilih , Untuk men-generate data di form</span>
                    </div>
                </div>
                <div class="form-group" style="border-bottom: solid #ddd 1px">
                    <label for="" class="col-lg-2 control-label input-sm">Attn:</label>
                    <div class="col-lg-9 input-group">
                        <input name="attn" type="text" readonly id="attn" value="<?php echo $data['attn']; ?>" class="form-control input-sm" />
                    </div>
                </div>
                <div class="form-group" style="border-bottom: solid #ddd 1px">
                    <label for="" class="col-lg-2 control-label input-sm">Tgl SA:</label>
                    <div class="col-lg-9 input-group">
                        <input name="tgl_si" type="text" readonly="true" id="tgl_si" value="<?php echo $data['tgl']; ?>" class="form-control input-sm" />
                    </div>
                </div>
                <div class="form-group" style="border-bottom: solid #ddd 1px">
                    <label for="" class="col-lg-2 control-label input-sm">Invoice Value:</label>
                    <div class="col-lg-9 input-group">
                        <input name="inv_value" type="text" readonly="true" id="inv_value" value="<?php echo $data['inv_value']; ?>" class="form-control input-sm" />
                    </div>
                </div>
                <div class="form-group" style="border-bottom: solid #ddd 1px">
                    <label for="" class="col-lg-2 control-label input-sm">Merchandise:</label>
                    <div class="col-lg-9 input-group">
                        <input name="merchandise" type="text" readonly="true" id="merchandise" value="<?php echo $data['merchandise']; ?>" class="form-control input-sm" />
                    </div>
                </div>
                <div class="form-group" style="border-bottom: solid #ddd 1px">
                    <label for="" class="col-lg-2 control-label input-sm">Author:</label>
                    <div class="col-lg-9 input-group">
                        <input name="author" class="form-control input-sm" type="text" disabled="disabled" id="author" tabindex="26" value="<?php if ($data['author'] != "") { echo $data['author']; } else {echo ucwords($_SESSION['usernmEX']);} ?>" readonly="readonly" />
                    </div>
                </div>

            </div>
        </div>
        <div class="modal-footer">
            <button type="button" id="act_pilih_sa" class="btn btn-info"><i class="fa fa-bookmark" aria-hidden="true"></i>
                SUBMIT CHANGE </button>
            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-window-close" aria-hidden="true"></i>
                CANCEL</button>
        </div>
    </form>
</div>
<script>
    $(function() {
        $(document).on('change', '#no_sa', function() {
            let id = $(this).find(':selected').val();
            $.ajax({
                dataType: "json",
                type: "POST",
                url: "API/Get_data_sa.php",
                data: {
                    id: id
                },
                success: function(response) {
                    if (response.kode == 200) {
                        $('#attn').val(response.attn);
                        $('#tgl_si').val(response.tgl);
                        $('#inv_value').val(response.inv_value);
                        $('#merchandise').val(response.merchandise);
                        $('#author').val(response.author);
                    } else {
                        toastr.error('data not found !')
                    }
                },
                error: function() {
                    alert("Error, Hubungi DIT team!");
                }
            });
        })

        $('#act_pilih_sa').click(function() {
            if ($('#no_sa').find(':selected').val() == '') {
                toastr.error('Please Select No. Urut !')
            } else {
                $.ajax({
                    dataType: "json",
                    type: "POST",
                    url: "API/Insert_data_sa.php",
                    data: {
                        id: $('#no_sa').find(':selected').val(),
                        no: $('#no').val(),
                        save: 'save'
                    },
                    success: function(response) {
                        if (response.kode == 200) {
                            $('#Modal_pilih_sa').modal('hide');
                            toastr.success('data berhasil terinput');

                            location.reload();
                        } else {
                            toastr.error('data not found !')
                        }
                    },
                    error: function() {
                        alert("Error, Hubungi DIT team!");
                    }
                });
            }

        })
    })
</script>