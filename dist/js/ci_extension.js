$(document).ready(function () {
    $('a[data-target="#Modal_Ci"]').click(function () {
        Clear_Form()
    })
    // debuger
    // $("#Modal_Ci").modal('show');
    $("#table_ci").dataTable({
        // "searching": false,
        "lengthChange": false,
        "pageLength": 5,
    });
    $('#act_listno').click(function () {
        if ($("#listno").val() == '') {
            toastr.error("Packing List required !")
        } else {
            $.ajax({
                dataType: "json",
                type: "POST",
                url: "API/get_data_fromTbl_exim.php",
                data: {
                    listno: $('#listno').val()
                },
                success: function (response) {
                    if (response.msg == 0) {
                        toastr.error(`Data Untuk Nomer list ${$('#listno').val()} Tidak di temukan !`);
                    } else {
                        $('#nm_messrs option').each(function () {
                            if ($(this).html() == response.data.nm_messrs) {
                                $(this).attr('selected', true)
                            }
                        });
                        $('#alt_messrs').val(response.data.alt_messrs.replace(/(<([^>]+)>)/ig, ""))
                        $('#nm_consgne option').each(function () {
                            if ($(this).html() == response.data.nm_consign) {
                                $(this).attr('selected', true)
                            }
                        });
                        $('#alt_consgne').val(response.data.alt_consign.replace(/(<([^>]+)>)/ig, ""))

                        if (response.data.tgl == '') {
                            $('#tgl1').val(today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate())
                        } else {
                            $('#tgl1').val(response.data.tgl)
                        }
                        $('#fasilitas option').each(function () {
                            if ($(this).html() == response.data.fasilitas) {
                                $(this).attr('selected', true)
                            }
                        });
                        $('#shipmnt option').each(function () {
                            if ($(this).html() == response.data.shipment_by) {
                                $(this).attr('selected', true)
                            }
                        });
                        $('#payment option').each(function () {
                            if ($(this).html() == response.data.payment) {
                                $(this).attr('selected', true)
                            }
                        });
                        $('#no_lc').val(response.data.no_lc)
                        $('#tgl2').val(response.data.tgl_lc)
                        $('#incoterm option').each(function () {
                            if ($(this).html() == response.data.incoterm) {
                                $(this).attr('selected', true)
                            }
                        });
                        $('#nm_trans').val(response.data.v_f_c_nm)
                        $('#connecting').val(response.data.connecting)
                        $('#tgl3').val(response.data.tgl_c)
                        $('#tgl4').val(response.data.tgl_s_f)
                        $('#tgl5').val(response.data.tgl_eta)
                        if (response.data.f_country == '') {
                            $('#f_country').val(`TG. PRIOK -JAKARTA, INDONESIA / JAKARTA, INDONESIA`)
                        } else {
                            $('#f_country').val(response.data.f_country)
                        }
                        $('#t_country').val(response.data.t_country)
                        $('#left_a').val(response.data.l_area.toUpperCase())
                        $('#right_a').val(response.data.r_area.toUpperCase())
                        $('#forwarder').val(response.data.forwarder)
                        $('#f_atn').val(response.data.f_atn)
                        $('#no_si option').each(function () {
                            if ($(this).html() == response.data.no_si) {
                                $(this).attr('selected', true)
                            }
                        });
                        $('#tgl6').val(response.data.tgl_si)
                        $('#status1 option').each(function () {
                            if ($(this).html() == response.data.status1) {
                                $(this).attr('selected', true)
                            }
                        });
                        $('#status2').val(response.data.status2)
                        $('#author').val(response.data.author.toUpperCase());
                        $('#r_si').val(response.data.r_si.replace(/(<([^>]+)>)/ig, ""))
                        if (response.data.s_mark == '') {
                            $('#shipping').val(`REMARKS: CERTIFIED BY CONTROL UNION ACCORDING TO THE ORGANIC EXCHANGE BLENDED STANDARD`)
                        } else {
                            $('#shipping').val(response.data.s_mark.replace(/(<([^>]+)>)/ig, ""))
                        }
                        if (response.data.s_charge == '') {
                            $('#s_charge').val(`0`)
                        } else {
                            $('#s_charge').val(response.data.r_si.replace(/(<([^>]+)>)/ig, ""))
                        }
                        $('#no_bl').val(response.data.no_bl)
                        $('#no_container').val(response.data.no_cont)
                        // tab 2

                        $('.nav.nav-tabs').find('li:eq(1)').show()
                        $('.nav.nav-tabs').find('li:eq(2)').show()
                        $("#id_fabric").val(response.data.id)
                        $("#id_flat").val(response.data.id)
                        $('#listno_fabric').val(`${$('#listno').val()}`)

                        Generate_table_firstTab($('#listno').val())
                        Generate_table_secondTab($('#listno').val())
                    }
                },
                error: function () {
                    alert("Error, Hubungi DIT team!");
                }
            });
        }
    })

    function Generate_table_firstTab(listno) {
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

        let tablee = $('#table_tab_2').DataTable({
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

    function Generate_table_secondTab(listno) {
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

        let tablee = $('#table_tab_3').DataTable({
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
    ////////////////////////////////////// CLEAR
    const Author = $('#author').val();

    $('#clear-form').click(function () {
        Clear_Form()
    })

    function Clear_Form() {
        $('input').val('');
        $('select').find(':selected').prop('selected', false)
        $('textarea').val('');

        $('#f_country').val(`TG. PRIOK -JAKARTA, INDONESIA / JAKARTA, INDONESIA`)
        $('#shipping').val("REMARKS: CERTIFIED BY CONTROL UNION ACCORDING TO THE ORGANIC EXCHANGE BLENDED STANDARD")
        $('#desc2_fabric').val(`KNITT FABRIC MADE WITH 0% ORGANICALLY COTTON`)
        $('#jns_fabric').val("KNITTED FABRIC")
        $('#jns_flat').val("FLAT KNIT")
        $('.nav.nav-tabs').find('li:eq(1)').hide()
        $('.nav.nav-tabs').find('li:eq(2)').hide()
        $('#author').val(Author)

        $(".nav.nav-tabs").find("li:eq(0)").addClass("active")
        $(".nav.nav-tabs").find("li:eq(1)").removeClass("active")
        $(".nav.nav-tabs").find("li:eq(2)").removeClass("active")

        $('#DetailCI_2').removeClass("in active")
        $('#DetailCI_1').removeClass("in active")
        $('#formCI').addClass("in active")
    }

    $('[data-toggle="tooltip"]').tooltip();

    /////////////////////////////// Change buyer
    $('#nm_messrs').on('change', function () {
        if ($(this).val() == '') {
            $('#alt_messrs').val('')
        } else {
            $.ajax({
                dataType: "json",
                type: "POST",
                url: "API/get_alamat_buyer.php",
                data: {
                    buyer: $(this).val()
                },
                success: function (response) {
                    $('#alt_messrs').val(response.alamat.replace(/(<([^>]+)>)/ig, ""))
                },
                error: function () {
                    alert("Error, Hubungi DIT team!");
                }
            });
        }
    })

    $('#nm_consgne').on('change', function () {
        if ($(this).val() == '') {
            $('#alt_consgne').val('')
        } else {
            $.ajax({
                dataType: "json",
                type: "POST",
                url: "API/get_alamat_buyer.php",
                data: {
                    buyer: $(this).val()
                },
                success: function (response) {
                    $('#alt_consgne').val(response.alamat.replace(/(<([^>]+)>)/ig, ""))
                },
                error: function () {
                    alert("Error, Hubungi DIT team!");
                }
            });
        }
    })

    // validation
    let form1 = $('#form_add_ci');
    let error1 = $('.alert-danger', form1);

    form1.validate({
        errorElement: 'span',
        errorClass: 'help-block help-block-error text-sm',
        // focusInvalid: false,
        ignore: "",
        rules: {
            listno: {
                required: true,
            },
        },
        // messege error-------------------------------------------------
        messages: {
            listno: {
                required: "<p class='text-center'>This field is required !<p>"
            },
        },

        invalidHandler: function (event, validator) {
            error1.show();
        },

        errorPlacement: function (error, element) {
            let cont = $(element).parent('.input-group');
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
            error1.hide();
        }
    });
    $.validator.setDefaults({
        debug: true,
        success: 'valid'
    });

    $('#insertForm').click(function (e) {
        e.preventDefault();
        if ($("#form_add_ci").valid()) {
            InsertOrUpdate_tbl_exim(
                $('#listno').val(),
                $('#nm_messrs').find(':selected').val(),
                $('#alt_messrs').val(),
                $('#nm_consgne').find(':selected').val(),
                $('#alt_consgne').val(),
                $('#tgl1').val(),
                $('#fasilitas').find(':selected').val(),
                $('#shipmnt').find(':selected').val(),
                $('#payment').find(':selected').val(),
                $('#no_lc').val(),
                $('#tgl2').val(),
                $('#incoterm').find(':selected').val(),
                $('#nm_trans').val(),
                $('#connecting').val(),
                $('#tgl3').val(),
                $('#tgl4').val(),
                $('#tgl5').val(),
                $('#f_country').val(),
                $('#t_country').val(),
                $('#left_a').val(),
                $('#right_a').val(),
                $('#forwarder').val(),
                $('#f_atn').val(),
                $('#no_si').find(':selected').val(),
                $('#tgl6').val(),
                $('#status1').find(':selected').val(),
                $('#status2').val(),
                $('#author').val(),
                $('#r_si').val(),
                $('#shipping').val(),
                $('#s_charge').val(),
                $('#no_bl').val(),
                $('#no_container').val()

            )
        }
    });

    function InsertOrUpdate_tbl_exim(listno, nm_messrs, alt_messrs, nm_consgne, alt_consgne, tgl1, fasilitas, shipmnt, payment, no_lc, tgl2, incoterm, nm_trans, connecting, tgl3, tgl4, tgl5, f_country, t_country, left_a, right_a, forwarder, f_atn, no_si, tgl6, status1, status2, author, r_si, shipping, s_charge, no_bl, no_container) {
        $.ajax({
            dataType: "json",
            type: "POST",
            url: "API/InsertOrUpdate_tbl_exim.php",
            data: {
                listno: listno,
                nm_messrs: nm_messrs,
                alt_messrs: alt_messrs,
                nm_consgne: nm_consgne,
                alt_consgne: alt_consgne,
                tgl1: tgl1,
                fasilitas: fasilitas,
                shipmnt: shipmnt,
                payment: payment,
                no_lc: no_lc,
                tgl2: tgl2,
                incoterm: incoterm,
                nm_trans: nm_trans,
                connecting: connecting,
                tgl3: tgl3,
                tgl4: tgl4,
                tgl5: tgl5,
                f_country: f_country,
                t_country: t_country,
                left_a: left_a,
                right_a: right_a,
                forwarder: forwarder,
                f_atn: f_atn,
                no_si: no_si,
                tgl6: tgl6,
                status1: status1,
                status2: status2,
                author: author,
                r_si: r_si,
                shipping: shipping,
                s_charge: s_charge,
                no_bl: no_bl,
                no_container: no_container
            },
            success: function (response) {
                if (response.kode == 505) {
                    toastr.success(response.msg)
                    $("#Modal_Ci").modal('hide');
                    Clear_Form()
                } else {
                    toastr.error(response.msg)
                }
            },
            error: function () {
                alert("Error, Hubungi DIT team!");
            }
        });
    }

    $(document).on('click', '.detail-weight', function (e) {
        let listno = $(this).attr('data-listno');
        let pk = $(this).attr('data-pk');

        $.ajax({
            url: "API/modal_Detail_Invc.php",
            type: "GET",
            data: {
                listno: listno,
                pk: pk
            },
            success: function (ajaxData) {
                $("#ModalInvoiceDetail").html(ajaxData);
                $("#PrntInvoiceDetail").modal('show');
            }
        });
    });

    $(document).on('click', '.DltDtlInvc', function (e) {
        let pk = $(this).attr('data-pk');
        let element = $(this).parent()

        let conf = confirm('are you sure to delete this row ?')
        if (conf) {
            $.ajax({
                url: "API/Hapus_Packing_List.php",
                type: "POST",
                data: {
                    pk: pk
                },
                success: function (response) {
                    let obj = jQuery.parseJSON(response);
                    if (obj.kode == 505) {
                        element.parent().remove()

                        toastr.success(obj.msg)
                    } else {
                        toastr.error(obj.msg)
                    }
                },
                error: function () {
                    alert('Hubungi DIT team !')
                }
            });
        } else {
            console.log('batal delete !')
        }
    })

    $(document).on('click', '.act_packinglist', function (e) {
        let listno = $(this).attr('data-listno');
        let dono = $(this).attr('data-dono');
        let id = $(this).attr('data-id');
        let po = $(this).attr('data-po');
        let item = $(this).attr('data-item');
        let warna = $(this).attr('data-warna');

        $.ajax({
            url: "API/modal_packing-list.php",
            type: "GET",
            data: {
                listno: listno,
                dono: dono,
                id: id,
                nopo: po,
                noitem: item,
                warna: warna
            },
            success: function (ajaxData) {
                $("#Bodypacking-list").html(ajaxData);
                $("#packing-list").modal('show');
            }
        });
    })

    $(document).on('click', '.invoice_detail_edit', function () {
        let listno = $(this).attr('data-listno');
        let id = $(this).attr('data-id');

        $.ajax({
            url: "API/modal_edit_packing-list.php",
            type: "GET",
            data: {
                listno: listno,
                id: id
            },
            success: function (ajaxData) {
                $("#Edit_Bodypacking-list").html(ajaxData);
                $("#Edit_packing-list").modal('show');
            }
        });
    })

    $(document).on('click', '.delete_detail', function () {
        let listno = $(this).attr('data-listno');
        let id = $(this).attr('data-id');

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.value == true) {
                $.ajax({
                    url: "API/delete_packing-list.php",
                    dataType: "json",
                    type: "POST",
                    data: {
                        listno: listno,
                        id: id
                    },
                    success: function (response) {
                        if (response.kode == 200) {
                            toastr.success('berhasil Hapus Data !')

                            Generate_table_firstTab($('#listno').val())
                            Generate_table_secondTab($('#listno').val())
                        } else {
                            toastr.error('Terjadi Kesalahan Pada System !')
                        }
                    },
                    error: function () {
                        alert('Terjadi kesalahan Hubungi DIT')
                    }
                });
            };
        })
    })


    $(document).on('click', ".cetak_ci", function (e) {
        let m = $(this).attr("id");
        $.ajax({
            url: "API/print-temp-ci.php",
            type: "GET",
            data: {
                id: m,
            },
            success: function (ajaxData) {
                $("#PrintCI").html(ajaxData);
                $("#PrintCI").modal('show', {
                    backdrop: 'true'
                });
            }
        });
    });
    $(document).on('click', ".cetak_pl", function (e) {
        let m = $(this).attr("id");
        $.ajax({
            url: "API/print-temp-pl.php",
            type: "GET",
            data: {
                id: m,
            },
            success: function (ajaxData) {
                $("#PrintPL").html(ajaxData);
                $("#PrintPL").modal('show', {
                    backdrop: 'true'
                });
            }
        });
    });
    $(document).on("click", ".cetak_sa", function (e) {
        let m = $(this).attr("id");
        $.ajax({
            url: "API/print-temp-sa.php",
            type: "GET",
            data: {
                id: m,
            },
            success: function (ajaxData) {
                $("#PrintSA").html(ajaxData);
                $("#PrintSA").modal('show', {
                    backdrop: 'true'
                });
            }
        });
    });
    $(document).on('click', ".cetak_si", function (e) {
        let m = $(this).attr("id");
        $.ajax({
            url: "API/print-temp-si.php",
            type: "GET",
            data: {
                id: m,
            },
            success: function (ajaxData) {
                $("#PrintSI").html(ajaxData);
                $("#PrintSI").modal('show', {
                    backdrop: 'true'
                });
            }
        });
    });

    $(document).on('click', '.invoice_detail', function () {
        let listno = $(this).attr('data-listno');
        $.ajax({
            dataType: "json",
            type: "POST",
            url: "API/get_data_fromTbl_exim.php",
            data: {
                listno: listno
            },
            success: function (response) {
                if (response.msg == 0) {
                    toastr.error(`Data Untuk Nomer list ${listno} Tidak di temukan !`);
                } else {
                    $('#listno').val(listno)
                    $('#nm_messrs option').each(function () {
                        if ($(this).html() == response.data.nm_messrs) {
                            $(this).attr('selected', true)
                        }
                    });
                    $('#alt_messrs').val(response.data.alt_messrs.replace(/(<([^>]+)>)/ig, ""))
                    $('#nm_consgne option').each(function () {
                        if ($(this).html() == response.data.nm_consign) {
                            $(this).attr('selected', true)
                        }
                    });
                    $('#alt_consgne').val(response.data.alt_consign.replace(/(<([^>]+)>)/ig, ""))

                    if (response.data.tgl == '') {
                        $('#tgl1').val(today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate())
                    } else {
                        $('#tgl1').val(response.data.tgl)
                    }
                    $('#fasilitas option').each(function () {
                        if ($(this).html() == response.data.fasilitas) {
                            $(this).attr('selected', true)
                        }
                    });
                    $('#shipmnt option').each(function () {
                        if ($(this).html() == response.data.shipment_by) {
                            $(this).attr('selected', true)
                        }
                    });
                    $('#payment option').each(function () {
                        if ($(this).html() == response.data.payment) {
                            $(this).attr('selected', true)
                        }
                    });
                    $('#no_lc').val(response.data.no_lc)
                    $('#tgl2').val(response.data.tgl_lc)
                    $('#incoterm option').each(function () {
                        if ($(this).html() == response.data.incoterm) {
                            $(this).attr('selected', true)
                        }
                    });
                    $('#nm_trans').val(response.data.v_f_c_nm)
                    $('#connecting').val(response.data.connecting)
                    $('#tgl3').val(response.data.tgl_c)
                    $('#tgl4').val(response.data.tgl_s_f)
                    $('#tgl5').val(response.data.tgl_eta)
                    if (response.data.f_country == '') {
                        $('#f_country').val(`TG. PRIOK -JAKARTA, INDONESIA / JAKARTA, INDONESIA`)
                    } else {
                        $('#f_country').val(response.data.f_country)
                    }
                    $('#t_country').val(response.data.t_country)
                    $('#left_a').val(response.data.l_area.toUpperCase())
                    $('#right_a').val(response.data.r_area.toUpperCase())
                    $('#forwarder').val(response.data.forwarder)
                    $('#f_atn').val(response.data.f_atn)
                    $('#no_si option').each(function () {
                        if ($(this).html() == response.data.no_si) {
                            $(this).attr('selected', true)
                        }
                    });
                    $('#tgl6').val(response.data.tgl_si)
                    $('#status1 option').each(function () {
                        if ($(this).html() == response.data.status1) {
                            $(this).attr('selected', true)
                        }
                    });
                    $('#status2').val(response.data.status2)
                    $('#author').val(response.data.author.toUpperCase());
                    $('#r_si').val(response.data.r_si.replace(/(<([^>]+)>)/ig, ""))
                    if (response.data.s_mark == '') {
                        $('#shipping').val(`REMARKS: CERTIFIED BY CONTROL UNION ACCORDING TO THE ORGANIC EXCHANGE BLENDED STANDARD`)
                    } else {
                        $('#shipping').val(response.data.s_mark.replace(/(<([^>]+)>)/ig, ""))
                    }
                    if (response.data.s_charge == '') {
                        $('#s_charge').val(`0`)
                    } else {
                        $('#s_charge').val(response.data.r_si.replace(/(<([^>]+)>)/ig, ""))
                    }
                    $('#no_bl').val(response.data.no_bl)
                    $('#no_container').val(response.data.no_cont)
                    // tab 2

                    $('.nav.nav-tabs').find('li:eq(1)').show()
                    $('.nav.nav-tabs').find('li:eq(2)').show()
                    $("#id_fabric").val(response.data.id)
                    $("#id_flat").val(response.data.id)
                    $('#listno_fabric').val(`${listno}`)

                    Generate_table_firstTab(listno)
                    Generate_table_secondTab(listno)

                    $(".nav.nav-tabs").find("li:eq(0)").removeClass("active")
                    $(".nav.nav-tabs").find("li:eq(1)").addClass("active")
                    $(".nav.nav-tabs").find("li:eq(2)").removeClass("active")

                    $('#DetailCI_1').addClass("in active")
                    $('#formCI').removeClass("in active")

                    $("#Modal_Ci").modal("show");
                }
            },
            error: function () {
                alert("Error, Hubungi DIT team!");
            }
        });

    })

    $(document).on('click', '.tambah-peb', function () {
        let listno = $(this).attr('data-listno');

        $.ajax({
            url: "API/Modal_tambah-peb.php",
            type: "GET",
            data: {
                listno: listno,
            },
            success: function (ajaxData) {
                $("#Body_tambah_peb").html(ajaxData);
                $("#Modal_tambah_peb").modal('show', {
                    backdrop: 'true'
                });
            }
        });
    })

    $(document).on('click', '.tambah-awb', function () {
        let listno = $(this).attr('data-listno');

        $.ajax({
            url: "API/Modal_tambah_awb.php",
            type: "GET",
            data: {
                listno: listno,
            },
            success: function (ajaxData) {
                $("#Body_tambah_awb").html(ajaxData);
                $("#Modal_tambah_awb").modal('show', {
                    backdrop: 'true'
                });
            }
        });
    })

    $(document).on('click', '.pilih-sa', function () {
        let listno = $(this).attr('no');
        let id = $(this).attr('pk');

        $.ajax({
            url: "API/Modal_pilih_sa.php",
            type: "GET",
            data: {
                listno: listno,
                id: id
            },
            success: function (ajaxData) {
                $("#Body_pilih_sa").html(ajaxData);
                $("#Modal_pilih_sa").modal('show', {
                    backdrop: 'true'
                });
            }
        });
    })

    $(document).on('click', '.tambah-bl', function () {
        let listno = $(this).attr('data-listno');

        $.ajax({
            url: "API/Modal_tambah_bl.php",
            type: "GET",
            data: {
                listno: listno,
            },
            success: function (ajaxData) {
                $("#Body_tambah_bl").html(ajaxData);
                $("#Modal_tambah_bl").modal('show', {
                    backdrop: 'true'
                });
            }
        });
    })

})