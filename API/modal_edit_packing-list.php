<?php
session_start();
include '../koneksi.php';
$id = $_GET["id"];
$listno = $_GET["listno"];
$sqldt = mysql_query("SELECT * FROM tbl_exim_detail WHERE id='$_GET[id]' LIMIT 1");
$row = mysql_fetch_array($sqldt);
?>
<div class="modal-content">
    <form method="post" enctype="multipart/form-data" name="form1" class="form-horizontal" id="form" style="border-bottom: solid #ddd 1px;">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Edit Data Packing-List</h4>
        </div>
        <div class="modal-body">
            <div class="col-lg-12">
                <div class="form-group">
                    <label for="" class="col-lg-2 control-label">No. Order / Proforma Invoice ⮞</label>
                    <div class="col-lg-10 input-group" style="margin-top: 2px;">
                        <input name="dono_edit" type="text" id="dono_edit" value="<?php echo $row['no_order']; ?>" class="form-control input-lg" />
                        <input type="hidden" name="id_edit" id="id_edit" value="<?php echo $_GET['id']; ?>" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-lg-2 control-label">No. PO ⮞</label>
                    <div class="col-lg-10 input-group">
                        <input name="no_po_edit" type="text" id="no_po_edit" value="<?php echo $row[no_po]; ?>" class="form-control input-sm" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-lg-2 control-label">Description ⮞</label>
                    <div class="col-lg-10 input-group">
                        <input name="desc1_edit" type="text" id="desc1_edit" value="<?php echo htmlspecialchars($row['deskripsi']); ?>" class="form-control input-sm" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-lg-2 control-label">Description 2 ⮞</label>
                    <div class="col-lg-10 input-group">
                        <textarea name="desc2_edit" id="desc2_edit" class="form-control input-sm"><?php echo $row['deskripsi2']; ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-lg-2 control-label">No. Item ⮞</label>
                    <div class="col-lg-10 input-group">
                        <input name="no_item_edit" type="text" id="no_item_edit" value="<?php echo $row['no_item']; ?>" class="form-control input-sm" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-lg-2 control-label">Color ⮞</label>
                    <div class="col-lg-10 input-group">
                        <input name="warna_edit" type="text" id="warna_edit" value="<?php echo $row['warna']; ?>" class="form-control input-sm" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-lg-2 control-label">Unit ⮞</label>
                    <div class="col-lg-10 input-group">
                        <input name="unit_edit" type="text" id="unit_edit" value="<?php echo $row[unit_price]; ?>" class="form-control input-sm" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-lg-2 control-label">Price By ⮞</label>
                    <div class="col-lg-10 input-group">
                        <select name="price_by_edit" id="price_by_edit" class="form-control input-sm">
                            <option value="KGS" <?php if ($row[price_by] == "KGS") {
                                                    echo "SELECTED";
                                                } ?>>KGS</option>
                            <option value="YDS" <?php if ($row[price_by] == "YDS") {
                                                    echo "SELECTED";
                                                } ?>>YDS</option>
                            <option value="PCS" <?php if ($row[price_by] == "PCS") {
                                                    echo "SELECTED";
                                                } ?>>PCS</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" id="SaveEditedPackingList" class="btn btn-info"><i class="fa fa-bookmark" aria-hidden="true"></i>
                SUBMIT CHANGE </button>
            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-window-close" aria-hidden="true"></i>
                CANCEL</button>
        </div>
    </form>
</div>
<script>
    $(function() {
        $('#SaveEditedPackingList').click(function() {
            $.ajax({
                dataType: "json",
                type: "POST",
                url: "API/Act_EditPackingList.php",
                data: {
                    dono: $('#dono_edit').val(),
                    id: $('#id_edit').val(),
                    no_po: $('#no_po_edit').val(),
                    desc1: $('#desc1_edit').val(),
                    desc2: $('#desc2_edit').val(),
                    no_item: $('#no_item_edit').val(),
                    warna: $('#warna_edit').val(),
                    unit: $('#unit_edit').val(),
                    price_by: $('#price_by_edit').find(':selected').val(),
                    update: "UPDATE",
                },
                success: function(response) {
                    if (response.kode == 200) {
                        toastr.success('berhasil update data !')
                        Generate_table_firstTab($('#listno_fabric').val())
                    } else {
                        toastr.error('Gagal Update !')
                    }
                },
                error: function() {
                    alert('Terjadi Error hubungi DIT')
                }
            });
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

            var tablee = $('#table_tab_2').DataTable({
                "processing": true,
                "serverSide": true,
                "responsive": true,
                "pageLength": 25,
                "order": [0, "desc"],
                "ajax": {
                    url: "API/Get_table_invoice_fabric.php",
                    type: "post",
                    data: {
                        listno: listno
                    },
                    error: function() {
                        $(".table_tab_2-error").html("");
                        $("#table_tab_2").append('<tbody class="table_tab_2-error"><tr><th colspan="3">Tidak ada data untuk ditampilkan</th></tr></tbody>');
                        $("#table_tab_2-error-proses").css("display", "none");
                    },
                },
            });

            Generate_table_secondTab(listno)
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

            var tablee = $('#table_tab_3').DataTable({
                "processing": true,
                "serverSide": true,
                "responsive": true,
                "pageLength": 25,
                "order": [0, "desc"],
                "ajax": {
                    url: "API/Get_table_invoice_fabric.php",
                    type: "post",
                    data: {
                        listno: listno
                    },
                    error: function() {
                        $(".table_tab_2-error").html("");
                        $("#table_tab_2").append('<tbody class="table_tab_2-error"><tr><th colspan="3">Tidak ada data untuk ditampilkan</th></tr></tbody>');
                        $("#table_tab_2-error-proses").css("display", "none");
                    },
                },
            });

            $('#Edit_packing-list').modal('hide');
        }
    })
</script>