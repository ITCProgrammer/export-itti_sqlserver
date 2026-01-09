<?php
session_start();
include '../koneksi.php';
$sqlcek = mysql_query("SELECT * FROM tbl_exim WHERE listno='$_GET[listno]' LIMIT 1");
$rcek = mysql_fetch_array($sqlcek);
?>
<div class="modal-content">
    <form method="post" enctype="multipart/form-data" name="awb_form_tambah" id="awb_form_tambah" class="form-horizontal">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">ADD PENGIRIMAN DOKUMEN</h4>
        </div>
        <div class="modal-body">
            <div class="col-md-12">
                <div class="form-group" style="border-bottom: solid #ddd 1px">
                    <label for="" class="col-lg-3 control-label input-sm">No. LIST ⮞</label>
                    <div class="col-lg-9 input-group">
                        <input type="text" name="no" id="no" value="<?php echo  $_GET['listno'] ?>" class="form-control input-sm" readonly>
                    </div>
                </div>
                <div class="form-group" style="border-bottom: solid #ddd 1px">
                    <label for="" class="col-lg-3 control-label input-sm">Terima Dokumen Khusus ⮞</label>
                    <div class="col-lg-9 input-group">
                        <input name="tgl_khusus" type="text" id="tgl_khusus" value="<?php echo $rcek['tgl_khusus']; ?>" required="true" class="form-control input-sm datepicker" />
                    </div>
                </div>
                <div class="form-group" style="border-bottom: solid #ddd 1px">
                    <label for="" class="col-lg-3 control-label input-sm">No AWB ⮞</label>
                    <div class="col-lg-9 input-group">
                        <input name="no_awb" type="text" id="no_awb" required="true" value="<?php echo $rcek['no_awb']; ?>" class="form-control input-sm" />
                    </div>
                </div>
                <div class="form-group" style="border-bottom: solid #ddd 1px">
                    <label for="" class="col-lg-3 control-label input-sm">Tgl AWB ⮞</label>
                    <div class="col-lg-9 input-group">
                        <input name="tgl_awb" type="text" id="tgl_awb" required="true" value="<?php echo $rcek['tgl_awb']; ?>" class="form-control input-sm datepicker" />
                    </div>
                </div>
                <div class="form-group" style="border-bottom: solid #ddd 1px">
                    <label for="" class="col-lg-3 control-label input-sm">Ke Marketing ⮞</label>
                    <div class="col-lg-9 input-group">
                        <input name="tgl_mkt" type="text" id="tgl_mkt" required="true" value="<?php echo $rcek['tgl_mkt']; ?>" class="form-control input-sm datepicker" />
                    </div>
                </div>
                <div class="form-group" style="border-bottom: solid #ddd 1px">
                    <label for="" class="col-lg-3 control-label input-sm">Keterangan ⮞</label>
                    <div class="col-lg-9 input-group">
                        <textarea name="ket_awb" cols="45" rows="3" class="form-control" id="ket_awb"><?php echo $rcek[ket_awb]; ?></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" id="act_tambah_awb" class="btn btn-info"><i class="fa fa-bookmark" aria-hidden="true"></i>
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

        // validation
        let form_awb = $('#awb_form_tambah');
        let error1 = $('.alert-danger', form_awb);

        form_awb.validate({
            errorElement: 'span',
            errorClass: 'help-block help-block-error text-sm text-center',
            // focusInvalid: false,
            ignore: "",
            rules: {
                no: {
                    required: true,
                },
            },
            // messege error-------------------------------------------------
            messages: {
                no: {
                    required: "<p class='text-center'>This field is required !<p>"
                },
            },

            invalidHandler: function(event, validator) {
                error1.show();
            },

            errorPlacement: function(error, element) {
                let cont = $(element).parent('.input-group');
                if (cont.length > 0) {
                    cont.after(error);
                } else {
                    element.after(error);
                }
            },

            highlight: function(element) {

                $(element)
                    .closest('.form-group').addClass(
                        'has-error');
            },

            unhighlight: function(element) {
                $(element)
                    .closest('.form-group').removeClass(
                        'has-error');
            },

            submitHandler: function(form) {
                error1.hide();
            }
        });
        $.validator.setDefaults({
            debug: true,
            success: 'valid'
        });

        $('#act_tambah_awb').click(function(e) {
            e.preventDefault();
            if ($("#awb_form_tambah").valid()) {
                FN_UpdateAwb(
                    $('#no').val(),
                    $('#tgl_khusus').val(),
                    $('#no_awb').val(),
                    $('#tgl_awb').val(),
                    $('#tgl_mkt').val(),
                    $('#ket_awb').val()
                )
            }
        });

        function FN_UpdateAwb(no, tgl_khusus, no_awb, tgl_awb, tgl_mkt, ket_awb) {
            $.ajax({
                dataType: "json",
                type: "POST",
                url: "API/FN_UpdateAwb.php",
                data: {
                    listno: no,
                    tgl_khusus: tgl_khusus,
                    no_awb: no_awb,
                    tgl_awb: tgl_awb,
                    tgl_mkt: tgl_mkt,
                    ket: ket_awb,
                    save: 'SAVE',
                },
                success: function(response) {
                    if (response.kode == 200) {
                        toastr.success(response.msg)
                        $("#Modal_tambah_awb").modal('hide');
                        location.reload()
                    } else {
                        toastr.error(response.msg)
                    }
                },
                error: function() {
                    alert("Error, Hubungi DIT team!");
                }
            });
        }


    })
</script>