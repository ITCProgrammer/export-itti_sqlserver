<?php
session_start();
include '../koneksi.php';
$sqlcek = sqlsrv_query($con,"SELECT * FROM tbl_exim WHERE listno='".$_GET['listno']."' LIMIT 1");
$rcek = sqlsrv_fetch_array($sqlcek);
?>
<div class="modal-content">
    <form method="post" enctype="multipart/form-data" name="form_act_peb" id="form_act_peb" class="form-horizontal">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">ADD PENGIRIMAN BARANG</h4>
        </div>
        <div class="modal-body">
            <div class="col-md-12">
                <div class="form-group" style="border-bottom: solid #ddd 1px">
                    <label for="" class="col-lg-2 control-label input-sm">No. LIST ⮞</label>
                    <div class="col-lg-9 input-group">
                        <input type="text" name="no" id="no" value="<?php echo  $_GET['listno'] ?>" class="form-control input-sm" readonly>
                    </div>
                </div>
                <div class="form-group" style="border-bottom: solid #ddd 1px">
                    <label for="" class="col-lg-2 control-label input-sm">No. PEB ⮞</label>
                    <div class="col-lg-9 input-group">
                        <input name="no_peb" class="form-control input-sm" type="text" id="no_peb" value="<?php echo $rcek['no_peb']; ?>" />
                        <input type="hidden" name="no" id="no" value="<?php echo  $_GET['listno'] ?>">
                    </div>
                </div>
                <div class="form-group" style="border-bottom: solid #ddd 1px">
                    <label for="" class="col-lg-2 control-label input-sm">Tanggal PEB ⮞</label>
                    <div class="col-lg-9 input-group">
                        <input name="tgl_peb" type="text" class="form-control input-sm datepicker" required id="tgl_peb" value="<?php echo $rcek['tgl_peb']; ?>" />
                    </div>
                </div>
                <div class="form-group" style="border-bottom: solid #ddd 1px">
                    <label for="" class="col-lg-2 control-label input-sm">NPE ⮞</label>
                    <div class="col-lg-9 input-group">
                        <input class="form-control input-sm" name="npe" type="text" id="npe" value="<?php echo $rcek['npe']; ?>" />
                    </div>
                </div>
                <div class="form-group" style="border-bottom: solid #ddd 1px">
                    <label for="" class="col-lg-2 control-label input-sm">No Surat Jalan ⮞</label>
                    <div class="col-lg-9 input-group">
                        <input name="no_sj" type="text" id="no_sj" required class="form-control input-sm" value="<?php echo $rcek['no_sj']; ?>" />
                    </div>
                </div>
                <div class="form-group" style="border-bottom: solid #ddd 1px">
                    <label for="" class="col-lg-2 control-label input-sm">Tgl Surat Jalan ⮞</label>
                    <div class="col-lg-9 input-group">
                        <input name="tgl_sj" type="text" id="tgl_sj" required value="<?php echo $rcek['tgl_sj']; ?>" class="form-control datepicker input-sm" />
                    </div>
                </div>
                <div class="form-group" style="border-bottom: solid #ddd 1px">
                    <label for="" class="col-lg-2 control-label input-sm">No Container ⮞</label>
                    <div class="col-lg-9 input-group">
                        <textarea name="no_container1" class="form-control" id="no_container1" cols="45" rows="3"><?php echo $rcek['no_cont']; ?></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" id="ActEditPeb" class="btn btn-info"><i class="fa fa-bookmark" aria-hidden="true"></i>
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
        let form1 = $('#form_act_peb');
        let error1 = $('.alert-danger', form1);

        form1.validate({
            errorElement: 'span',
            errorClass: 'help-block help-block-error text-sm text-center',
            // focusInvalid: false,
            ignore: "",
            rules: {
                no_peb: {
                    required: true,
                },
            },
            // messege error-------------------------------------------------
            messages: {
                no_peb: {
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

        $('#ActEditPeb').click(function(e) {
            e.preventDefault();
            if ($("#form_act_peb").valid()) {
                FN_UpdateFeb(
                    $('#no').val(),
                    $('#no_peb').val(),
                    $('#tgl_peb').val(),
                    $('#npe').val(),
                    $('#no_sj').val(),
                    $('#tgl_sj').val(),
                    $('#no_container1').val()
                )
            }
        });

        function FN_UpdateFeb(no, no_peb, tgl_peb, npe, no_sj, tgl_sj, no_container) {
            $.ajax({
                dataType: "json",
                type: "POST",
                url: "API/FN_UpdateFeb.php",
                data: {
                    no: no,
                    no_peb: no_peb,
                    tgl_peb: tgl_peb,
                    npe: npe,
                    no_sj: no_sj,
                    tgl_sj: tgl_sj,
                    no_container: no_container,
                    save: 'save',
                },
                success: function(response) {
                    if (response.kode == 200) {
                        toastr.success(response.msg)
                        $("#Modal_tambah_peb").modal('hide');
                        location.reload();
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