$(function () {
    var formFlat = $('#form_detail_flat');
    var error2 = $('.alert-danger', formFlat);

    formFlat.validate({
        errorElement: 'span',
        errorClass: 'help-block help-block-error text-sm text-center',
        // focusInvalid: false,
        ignore: "",
        rules: {
            dono_flat: {
                required: true,
            },
            no_po_flat: {
                required: true
            },
            no_item_flat: {
                required: true
            },
            warna_flat: {
                required: true
            },
            unit_flat: {
                required: true
            },
        },
        // messege error-------------------------------------------------
        messages: {

        },

        invalidHandler: function (event, validator) {
            error2.show();
        },

        errorPlacement: function (error, element) {
            var cont = $(element).parent('.input-group');
            if (cont.length > 0) {
                cont.after(error);
            } else {
                element.after(error);
            }
        },

        highlight: function (element) {

            $(element)
                .closest('.form-group').addClass(
                    'has-error');
        },

        unhighlight: function (element) {
            $(element)
                .closest('.form-group').removeClass(
                    'has-error');
        },

        submitHandler: function (form) {
            error2.hide();
        }
    });
    $.validator.setDefaults({
        debug: true,
        success: 'valid'
    });

    $('#act_form_flat').click(function (e) {
        e.preventDefault();
        if ($("#form_detail_flat").valid()) {
            Fn_Submit_detail_flat(
                $("#id_flat").val(),
                $("#dono_flat").val(),
                $("#no_po_flat").val(),
                $("#no_item_flat").val(),
                $("#desc_flat").val(),
                $("#desc2_flat").val(),
                $("#warna_flat").val(),
                $("#unit_flat").val(),
                $("#price_by_flat").find("option:selected").val(),
            )
        }
    });

    function Fn_Submit_detail_flat(id, dono, no_po, item, desc1, desc2, warna, unit, price_by) {
        $.ajax({
            dataType: "json",
            type: "POST",
            url: "API/Insert_detail_flat.php",
            data: {
                id: id,
                dono: dono,
                no_po: no_po,
                item: item,
                desc1: desc1,
                desc2: desc2,
                warna: warna,
                unit: unit,
                price_by: price_by
            },
            success: function (response) {
                if (response.kode == 505) {
                    toastr.success(response.msg)
                    $("#dono_flat").val('')
                    $("#no_po_flat").val('')
                    $("#no_item_flat").val('')
                    $("#desc_flat").val('')
                    $("#desc2_flat").val('')
                    $("#warna_flat").val('')
                    $("#unit_flat").val('')
                    $("#price_by_flat").find("option:selected").prop('selected', false)

                    Reload_table_flat($('#listno_fabric').val())
                } else {
                    toastr.error(response.msg)
                }
            },
            error: function () {
                alert("Error, Hubungi DIT team!");
            }
        });
    }

    function Reload_table_flat(listno) {
        const ComponentTable = `<br /><table id="table_tab_3" class="table table-sm display compact table_ci" style="width: 100%; margin-top: 5px;">
                                    <thead>
                                    <tr>
                                        <th style="vertical-align: middle;" rowspan="2" class="text-center">No</th>
                                        <th style="vertical-align: middle;" rowspan="2" class="text-center">No Order</th>
                                        <th style="vertical-align: middle;" rowspan="2" class="text-center">PO NO.</th>
                                        <th style="vertical-align: middle;" rowspan="2" class="text-center">Item NO.</th>
                                        <th style="vertical-align: middle;" rowspan="2" class="text-center">Style</th>
                                        <th style="vertical-align: middle;" rowspan="2" class="text-center">COLOR</th>
                                        <th style="vertical-align: middle;" rowspan="2" class="text-center">UNIT PRICE</th>
                                        <th style="vertical-align: middle;" rowspan="2" class="text-center">Weight</th>
                                        <th style="vertical-align: middle;" rowspan="2" class="text-center">PRICE BY</th>
                                        <th style="vertical-align: middle;" colspan="4" class="text-center">QTY</th>
                                        <th style="vertical-align: middle;" rowspan="2" class="text-center">AMOUNT US$</th>
                                        <th style="vertical-align: middle;" rowspan="2" class="text-center">ACTION</th>
                                    </tr>
                                    <tr>
                                        <th class="text-center">KGS</th>
                                        <th class="text-center">YDS</th>
                                        <th class="text-center">PCS</th>
                                        <th class="text-center">FOC</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr></tr>
                                    </tbody>
                                </table>`;
        $('#zona_table_tab2').empty();
        $('#zona_table_tab2').html(ComponentTable);

        $('#table_tab_3').DataTable({
            "processing": true,
            "serverSide": true,
            "responsive": true,
            "pageLength": 10,
            "order": [0, "desc"],
            "ajax": {
                url: "API/Get_table_invoice_fabric.php",
                type: "post",
                data: {
                    listno: listno
                },
                error: function () {
                    $(".table_tab_2-error").html("");
                    $("#table_tab_2").append('<tbody class="table_tab_2-error"><tr><th colspan="3">Tidak ada data untuk ditampilkan</th></tr></tbody>');
                    $("#table_tab_2-error-proses").css("display", "none");
                },
            },
        });

        Generate_table_firstTabb(listno)
    }

    function Generate_table_firstTabb(listno) {
        const ComponentTable = `<br /><table id="table_tab_2" class="table table-sm display compact table_ci" style="width: 100%; margin-top: 5px;">
                                <thead>
                                <tr>
                                    <th style="vertical-align: middle;" rowspan="2" class="text-center">No</th>
                                    <th style="vertical-align: middle;" rowspan="2" class="text-center">No Order</th>
                                    <th style="vertical-align: middle;" rowspan="2" class="text-center">PO NO.</th>
                                    <th style="vertical-align: middle;" rowspan="2" class="text-center">Item NO.</th>
                                    <th style="vertical-align: middle;" rowspan="2" class="text-center">Style</th>
                                    <th style="vertical-align: middle;" rowspan="2" class="text-center">COLOR</th>
                                    <th style="vertical-align: middle;" rowspan="2" class="text-center">UNIT PRICE</th>
                                    <th style="vertical-align: middle;" rowspan="2" class="text-center">Weight</th>
                                    <th style="vertical-align: middle;" rowspan="2" class="text-center">PRICE BY</th>
                                    <th style="vertical-align: middle;" colspan="4" class="text-center">QTY</th>
                                    <th style="vertical-align: middle;" rowspan="2" class="text-center">AMOUNT US$</th>
                                    <th style="vertical-align: middle;" rowspan="2" class="text-center">ACTION</th>
                                </tr>
                                <tr>
                                    <th class="text-center">KGS</th>
                                    <th class="text-center">YDS</th>
                                    <th class="text-center">PCS</th>
                                    <th class="text-center">FOC</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr></tr>
                                </tbody>
                            </table>`;
        $('#PlaceTableTab2').empty();
        $('#PlaceTableTab2').html(ComponentTable);

        var tablee = $('#table_tab_2').DataTable({
            "processing": true,
            "serverSide": true,
            "responsive": true,
            "pageLength": 10,
            "order": [0, "desc"],
            "ajax": {
                url: "API/Get_table_invoice_fabric.php",
                type: "post",
                data: {
                    listno: listno
                },
                error: function () {
                    $(".table_tab_2-error").html("");
                    $("#table_tab_2").append('<tbody class="table_tab_2-error"><tr><th colspan="3">Tidak ada data untuk ditampilkan</th></tr></tbody>');
                    $("#table_tab_2-error-proses").css("display", "none");
                },
            },
        });
    }

    $("#print_invoice_flat").click(function () {
        var url_print = `pages/print-invoice.php?listno=${$('#listno').val()}`;
        window.open(url_print, '', 'width=800, height=600');
    })

    $('#exportToExcel_flat').click(function () {
        window.location = `pages/print-invoice-excel.php?listno=${$('#listno').val()}`;
    })
})