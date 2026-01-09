$(document).ready(function () {
    $('#act_order_fabric').on('click', function () {
        if ($('#dono_fabric').val() == '') {
            toastr.error('No.Order/Proforma Invoice is required !')
        } else {
            $.ajax({
                dataType: "json",
                type: "POST",
                url: "API/get_NoPo_By_noOrder.php",
                data: {
                    dono: $('#dono_fabric').val()
                },
                success: function (response) {
                    if (response.msg == 505) {
                        $('#no_po_fabric').html('');
                        $('#no_po_fabric').append(`<option selected disabled value="">-PILIH-</option>`);
                        $.each(response.data, function (index, val) {
                            $('#no_po_fabric').append(`<option value="${val}"> ${val} </option>`)
                        });
                        toastr.success(`Nomor PO di temukan`)
                    } else {
                        toastr.error(`tidak ditemukan PO dari order ${$('#dono_fabric').val()}`)
                    }
                },
                error: function () {
                    alert("Error, Hubungi DIT team!" + "yana");
                }
            });
        }
    })

    $('#no_po_fabric').on('change', function () {
        $.ajax({
            dataType: "json",
            type: "POST",
            url: "API/get_NoItem_By_noPO.php",
            data: {
                dono: $('#dono_fabric').val(),
                nopo: $('#no_po_fabric').val()
            },
            success: function (response) {
                if (response.msg == 505) {
                    $('#no_item_fabric').html('');
                    $('#no_item_fabric').append(`<option selected disabled value="">-PILIH-</option>`);
                    $.each(response.data, function (index, val) {
                        $('#no_item_fabric').append(`<option value="${val}"> ${val} </option>`)
                    });
                    toastr.success(`Nomor Item di temukan`)
                } else {
                    toastr.error(`tidak ditemukan Item dari PO ${$('#no_po_fabric').val()}`)
                }
            },
            error: function () {
                alert("Error, Hubungi DIT team!");
            }
        });
    })

    $('#no_item_fabric').on('change', function () {
        $.ajax({
            dataType: "json",
            type: "POST",
            url: "API/get_Color_By_noItem.php",
            data: {
                dono: $('#dono_fabric').val(),
                nopo: $('#no_po_fabric').val(),
                item: $('#no_item_fabric').val()
            },
            success: function (response) {
                if (response.msg == 505) {
                    $('#style_fabric').html('');
                    $('#style_fabric').append(`<option selected disabled value="">-PILIH-</option>`);
                    $.each(response.warna, function (index, val) {
                        $('#style_fabric').append(`<option value="${val.style}"> ${val.style} </option>`)
                    });

                    $('#warna').html('');
                    $('#warna').append(`<option selected disabled value="">-PILIH-</option>`);
                    $.each(response.data, function (index, val) {
                        $('#warna').append(`<option value="${val}"> ${val} </option>`)
                    });


                    toastr.success(`warna di temukan`)
                } else {
                    toastr.error(`tidak ditemukan warna dari Item ${$('#no_po_fabric').val()}`)
                }
            },
            error: function () {
                alert("Error, Hubungi DIT team!");
            }
        });
    })

    $('#warna').on('change', function () {
        $.ajax({
            dataType: "json",
            type: "POST",
            url: "API/get_description_by_warna.php",
            data: {
                dono: $('#dono_fabric').val(),
                nopo: $('#no_po_fabric').val(),
                item: $('#no_item_fabric').val(),
                warna: $(this).val()
            }, //desc1_fabric
            success: function (response) {
                if (response.msg == 505) {
                    $('#desc1_fabric').val(response.data);
                    $('#unit_fabric').val(response.UnitPrice);
                    $('#id_pi_fabric').html('');
                    $('#id_pi_fabric').append(`<option selected disabled value="">-PILIH-</option>`);
                    $.each(response.row, function (index, val) {
                        $('#id_pi_fabric').append(`<option value="${val.id}"> ${val.warna} | ${val.qty} </option>`)
                    });
                    toastr.success(`warna di temukan`)
                } else {
                    toastr.error(`tidak ditemukan warna dari Item ${$('#no_po_fabric').val()}`)
                }
            },
            error: function () {
                alert("Error, Hubungi DIT team!");
            }
        });
    })

    $('#id_pi_fabric').on('change', function () {
        $.ajax({
            dataType: "json",
            type: "POST",
            url: "API/Get_Weight_byPi.php",
            data: {
                pi: $(this).find(':selected').val()
            },
            success: function (response) {
                if (response.msg == 505) {
                    $('#weight_fabric').val(response.data);
                    toastr.success(`Weight di temukan`)
                } else {
                    toastr.error(`Data Weight tidak ditemukan dari PI ${$(this).find(':selected').val()} !`)
                }
            }
        })
    })


    // validation
    var form2 = $('#form_detail_fabric');
    var error2 = $('.alert-danger', form2);

    form2.validate({
        errorElement: 'span',
        errorClass: 'help-block help-block-error text-sm text-center',
        // focusInvalid: false,
        ignore: "",
        rules: {
            listno: {
                required: true,
            },
            dono_fabric: {
                required: true
            },
            unit_fabric: {
                number: true,
                required: true
            },
            weight_fabric: {
                number: true,
                required: true
            }
        },
        // messege error-------------------------------------------------
        messages: {
            listno: {
                required: "<p class='text-center'>This field is required !<p>"
            },
            unit_fabric: {
                number: "Field ini harus berisi angka !"
            },
            weight_fabric: {
                number: "Field ini harus berisi angka !"
            },
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

    $('#act_form_fabric').click(function (e) {
        e.preventDefault();
        if ($("#form_detail_fabric").valid()) {
            Fn_Submit_detail_fabric(
                $('#id_fabric').val(),
                $('#id_pi_fabric').find("option:selected").val(),
                $('#dono_fabric').val(),
                $('#no_po_fabric').find("option:selected").val(),
                $('#no_item_fabric').find("option:selected").val(),
                $('#desc1_fabric').val(),
                $('#desc2_fabric').val(),
                $('#style_fabric').find("option:selected").val(),
                $('#weight_fabric').val(),
                $("#warna").find("option:selected").val(),
                $('#unit_fabric').val(),
                $('#price_by_fabric').find("option:selected").val(),
                $('#listno_fabric').val(),
                $('#jns_fabric').val(),
            )
        }
    });

    function Fn_Submit_detail_fabric(id, id_pi, dono, po, no_item, desc1, desc2, style, weight, warna, unit, price_by, listno, jns) {
        $.ajax({
            dataType: "json",
            type: "POST",
            url: "API/Insert_detail_fabric.php",
            data: {
                id: id,
                id_pi: id_pi,
                dono: dono,
                po: po,
                no_item: no_item,
                desc1: desc1,
                desc2: desc2,
                style: style,
                weight: weight,
                warna: warna,
                unit: unit,
                price_by: price_by,
                listno: listno,
                jns: jns
            },
            success: function (response) {
                if (response.kode == 505) {
                    toastr.success(response.msg)
                    $('#id_pi_fabric').find("option:selected").prop('selected', false)
                    $('#dono_fabric').val('')
                    $('#no_po_fabric').find("option:selected").prop('selected', false)
                    $('#no_item_fabric').find("option:selected").prop('selected', false)
                    $('#desc1_fabric').val('')
                    $('#desc2_fabric').val('')
                    $('#style_fabric').find("option:selected").prop('selected', false)
                    $('#weight_fabric').val('')
                    $("#warna").find("option:selected").prop('selected', false)
                    $('#unit_fabric').val('')
                    $('#price_by_fabric').find("option:selected").prop('selected', false)

                    Reload_table_fabric(listno)
                } else {
                    toastr.error(response.msg)
                }
            },
            error: function () {
                alert("Error, Hubungi DIT team!");
            }
        });
    }

    function Reload_table_fabric(listno) {
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

        Reload_table_flatt(listno)
    }

    function Reload_table_flatt(listno) {
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

    }

    $("#print_invoice").click(function () {
        var url_print = `pages/print-invoice.php?listno=${$('#listno').val()}`;
        window.open(url_print, '', 'width=800, height=600');
    })

    $('#exportToExcel').click(function () {
        window.location = `pages/print-invoice-excel.php?listno=${$('#listno').val()}`;
    })

})