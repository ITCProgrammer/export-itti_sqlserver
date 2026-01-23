<?php
session_start();
include '../koneksi.php';
?>

<div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Packing-List</h4>
    </div>
    <div class="modal-body">
        <div class="row">
            <form method="post" enctype="multipart/form-data" name="form1" class="form-horizontal" id="form1" style="border-bottom: solid #ddd 1px;">
                <div class="container-fluid">
                    <div class="col-lg-5">
                        <div class="form-group">
                            <label for="" class="col-lg-2 control-label input-xs">No. ORDER ▶</label>
                            <div class="col-lg-6 input-group">
                                <input class="form-control input-xs" type="text" name="dono_list" id="dono_list" value="<?php echo $_GET['dono']; ?>" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-lg-2 control-label input-xs">No. PO ▶</label>
                            <div class="col-lg-6 input-group">
                                <select class="form-control input-xs" type="text" name="nopo_list" id="nopo_list">
                                    <?php $sqlnopo = sqlsrv_query($con, "SELECT DISTINCT 
                                                        TRIM(no_po) AS no_po
                                                    FROM db_qc.tbl_kite
                                                    WHERE no_order = '$_GET[dono]'
                                                    ORDER BY no_po ASC;"); ?>
                                    <?php while ($rp = sqlsrv_fetch_array($sqlnopo, SQLSRV_FETCH_ASSOC)) { ?>
                                        <option value="<?php echo urlencode($rp['no_po']); ?>" <?php if ($_GET['nopo'] == $rp['no_po']) {
                                                                                                    echo "SELECTED";
                                                                                                } ?>><?php echo str_replace("'", "''", $rp['no_po']); ?>
                                        </option>
                                    <?php  } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-lg-2 control-label input-xs">No. ITEM ▶</label>
                            <div class="col-lg-6 input-group">
                                <select class="form-control input-xs" type="text" name="noitem_list" id="noitem_list">
                                    <option value=""></option>
                                    <?php $sqlnoitem = sqlsrv_query($con, "SELECT TRIM(no_item) AS no_item
                                                        FROM db_qc.tbl_kite
                                                        WHERE no_order = '$_GET[dono]' 
                                                        AND no_po = '$_GET[nopo]'
                                                        GROUP BY no_item ");
                                    while ($rp = sqlsrv_fetch_array($sqlnoitem, SQLSRV_FETCH_ASSOC)) { ?>
                                        <option value="<?php echo str_replace("'", "''", $rp['no_item']); ?>" <?php if ($rp['no_item'] == $_GET['noitem']) {
                                                                                                                    echo "SELECTED";
                                                                                                                } ?>><?php echo str_replace("'", "''", $rp['no_item']); ?></option>
                                    <?php  } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-lg-2 control-label input-xs">COLOR ▶</label>
                            <div class="col-lg-6 input-group">
                                <select class="form-control input-xs" type="text" name="warna_list" id="warna_list">
                                    <option value=""></option>
                                    <?php $sqlwarna = sqlsrv_query($con, "SELECT TRIM(warna) as warna
                                                            FROM db_qc.tbl_kite
                                                            WHERE db_qc.tbl_kite.no_order = '$_GET[dono]' AND tbl_kite.no_po = '$_GET[nopo]' AND  tbl_kite.no_item = '$_GET[noitem]'
                                                            GROUP BY warna ");
                                    while ($rp = sqlsrv_fetch_array($sqlwarna, SQLSRV_FETCH_ASSOC)) { ?>
                                        <option value="<?php echo str_replace("'", "''", $rp['warna']); ?>" <?php if ($rp['warna'] == $_GET['warna']) {
                                                                                                                echo "SELECTED";
                                                                                                            } ?>><?php echo str_replace("'", "''", $rp['warna']); ?></option>
                                    <?php  } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="form-group">
                            <label for="" class="col-lg-2 control-label input-xs">LOT ▶</label>
                            <div class="col-lg-6 input-group">
                                <select class="form-control input-xs" type="text" name="lot_list" id="lot_list">
                                    <option selected value=""></option>
                                    <?php $sqllot = sqlsrv_query($con, "SELECT LTRIM(RTRIM(no_lot)) AS no_lot 
                                                    FROM db_qc.tbl_kite
                                                    WHERE no_order = '$_GET[dono]' 
                                                    AND no_po = '$_GET[nopo]' 
                                                    AND no_item = '$_GET[noitem]' 
                                                    AND warna = '$_GET[warna]'
                                                    GROUP BY no_lot ");
                                    while ($rp = sqlsrv_fetch_array($sqllot, SQLSRV_FETCH_ASSOC)) { ?>
                                        <option value="<?php echo str_replace("'", "''", $rp['no_lot']); ?>" <?php if ($rp['no_lot'] == $_GET['lot']) {
                                                                                                                    echo "SELECTED";
                                                                                                                } ?>><?php echo str_replace("'", "''", $rp['no_lot']); ?></option>
                                    <?php  } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-lg-2 control-label input-xs">PACK ▶</label>
                            <div class="col-lg-6 input-group">
                                <select class="form-control input-xs" type="text" name="pack_list" id="pack_list">
                                    <option value=""></option>
                                    <option value="ROLLS">ROLLS</option>
                                    <option value="BALES">BALES</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-lg-2 control-label input-xs">No. LIST ▶</label>
                            <div class="col-lg-6 input-group">
                                <input class="form-control input-xs" type="text" name="listno_list" id="listno_list" value="<?php echo $_GET['listno']; ?>" readonly />
                                <input type="hidden" name="id_list" id="id_list" value="<?php $_GET['id'] ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-lg-1 control-label input-xs">NOTE :</label>
                            <div class="col-lg-10 input-group">
                                <label class="control-label input-xs" id="note_F">

                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="row">
            <div class="container-fluid">
                <div class="col-lg-10">
                    <br />
                    <table width="100%" class="table table-sm table-bordered table-striped">
                        <thead>

                            <tr class="alert-info">
                                <th scope="col">WH</th>
                                <th scope="col">LOT</th>
                                <th scope="col">KGS</th>
                                <th scope="col">YDS</th>
                                <th scope="col">PCS</th>
                                <th scope="col">FOC</th>
                                <th scope="col">PACK</th>
                            </tr>

                        </thead>
                        <tbody>
                            <?php
                            if ($_GET['dono'] != '') {
                                $cwhere2 .= $_GET['dono'];
                            } else {
                                $cwhere2 .= "null";
                            }
                            if ($_GET['nopo'] != '') {
                                $cwhere1 .= " AND tbl_kite.no_po='$_GET[nopo]'";
                            } else {
                                $cwhere1 .= " ";
                            }
                            if ($_GET['noitem'] != '') {
                                $cwhere10 .= " AND tbl_kite.no_item='$_GET[noitem]'";
                            } else {
                                $cwhere10 .= " ";
                            }
                            if ($_GET['warna'] != '') {
                                $cwhere11 .= " AND tbl_kite.warna='$_GET[warna]'";
                            } else {
                                $cwhere11 .= " ";
                            }

                            $datasum = sqlsrv_query($con, "SELECT
                                tbl_kite.no_lot,
                                MAX(tbl_kite.nokk) AS nokk,
                                SUM(CASE WHEN detail_pergerakan_stok.sisa <> 'FOC' THEN detail_pergerakan_stok.weight ELSE 0 END) AS kgs,
                                SUM(CASE WHEN detail_pergerakan_stok.sisa <> 'FOC' THEN detail_pergerakan_stok.yard_ ELSE 0 END) AS yds,
                                SUM(tmp_detail_kite.netto) AS pcs,
                                MAX(detail_pergerakan_stok.pack) AS pack, 
                                COUNT(detail_pergerakan_stok.weight) AS jml_pack,
                                SUM(CASE WHEN detail_pergerakan_stok.sisa = 'FOC' THEN detail_pergerakan_stok.weight ELSE 0 END) AS foc
                            FROM
                                db_qc.pergerakan_stok
                            INNER JOIN db_qc.detail_pergerakan_stok ON pergerakan_stok.id = detail_pergerakan_stok.id_stok
                            INNER JOIN db_qc.tmp_detail_kite ON tmp_detail_kite.id = detail_pergerakan_stok.id_detail_kj
                            INNER JOIN db_qc.tbl_kite ON tbl_kite.id = tmp_detail_kite.id_kite
                            WHERE
                                detail_pergerakan_stok.sisa NOT IN ('FKTH', 'TH', 'SISA') 
                                AND pergerakan_stok.typestatus = '1'
                                AND tbl_kite.no_order = '" . $cwhere2 . "'
                                " . $cwhere1 . $cwhere10 . $cwhere11 . $cwhere12 . "
                            GROUP BY 
                                tbl_kite.no_lot
                            ORDER BY 
                                MAX(pergerakan_stok.typestatus), 
                                MAX(detail_pergerakan_stok.nokk), 
                                MAX(detail_pergerakan_stok.no_roll) ASC;");

                            while ($rdata = sqlsrv_fetch_array($datasum, SQLSRV_FETCH_ASSOC)) {
                                $mySql = sqlsrv_query($con, "SELECT tempat, catatan 
                                        FROM db_qc.mutasi_kain 
                                        WHERE nokk = '$rdata[nokk]' 
                                        AND tempat <> '' 
                                        AND tempat IS NOT NULL 
                                        ORDER BY id DESC;");
                                $myBlk = sqlsrv_fetch_array($mySql, SQLSRV_FETCH_ASSOC);
                                $mySql1 = sqlsrv_query($con, "SELECT
                                    MAX(a.blok) AS blok, 
                                    b.sisa,
                                    b.nokk
                                FROM
                                    db_qc.pergerakan_stok a
                                INNER JOIN db_qc.detail_pergerakan_stok b ON a.id = b.id_stok
                                WHERE
                                    a.typestatus IN ('1', '2')
                                    AND b.transtatus IS NOT NULL 
                                    AND b.transtatus IN ('1', '0') 
                                    AND b.nokk = '$rdata[nokk]'
                                GROUP BY
                                    b.nokk, 
                                    b.sisa
                                ORDER BY
                                    MAX(a.tgl_update), 
                                    MAX(a.id); ");
                                $myBlk1 = sqlsrv_fetch_array($mySql1, SQLSRV_FETCH_ASSOC);
                            ?>
                                <tr align="center">
                                    <td><?php
                                        if ($myBlk['tempat'] != "") {
                                            echo $myBlk['tempat'];
                                        } else if ($myBlk1['blok'] != "") {
                                            echo $myBlk1['blok'];
                                        } else {
                                            echo "N/A";
                                        }
                                        ?></td>
                                    <td><?php echo $rdata['no_lot']; ?></td>
                                    <td><?php if ($rdata['kgs'] > 0) {
                                            echo $rdata['kgs'];
                                        } else {
                                            echo "-";
                                        } ?></td>
                                    <td><?php if ($rdata['yds'] > 0) {
                                            echo $rdata['yds'];
                                        } else {
                                            echo "-";
                                        } ?> </td>
                                    <td><?php if ($rdata['pcs'] > 0) {
                                            echo $rdata['pcs'];
                                        } else {
                                            echo "-";
                                        } ?> </td>
                                    <td><?php if ($rdata['foc'] > 0) {
                                            echo $rdata['foc'];
                                        } else {
                                            echo "-";
                                        } ?></td>
                                    <td><?php echo $rdata['jml_pack']; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="container-fluid">
                <div class="col-lg-10">
                    <h5 class="text-center">Details Data</h5>
                    <table width="100%" border="1" class="table table-bordered" id="table-checkbox">
                        <thead>
                            <tr class="bg-primary">
                                <th width="163" scope="col">Nokk</th>
                                <th width="75" scope="col">LOT</th>
                                <th width="77" scope="col">No Roll</th>
                                <th width="77" scope="col">Netto (KG)</th>
                                <th width="77" scope="col">Yard</th>
                                <th width="77" scope="col">MEAS</th>
                                <th width="77" scope="col">PCS</th>
                                <th width="60" scope="col">
                                    <input type="checkbox" name="allbox" class="check-th" value="check" />
                                    Check ALL
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            $datacek = sqlsrv_query($con, "SELECT 
                                tmp_detail_kite.id, 
                                MIN(detail_pergerakan_stok.id) AS kd, 
                                MAX(pergerakan_stok.typestatus) AS typestatus,
                                MAX(detail_pergerakan_stok.nokk) AS nokk,
                                MAX(detail_pergerakan_stok.no_roll) AS no_roll
                            FROM db_qc.pergerakan_stok
                            INNER JOIN db_qc.detail_pergerakan_stok ON pergerakan_stok.id = detail_pergerakan_stok.id_stok
                            INNER JOIN db_qc.tmp_detail_kite ON tmp_detail_kite.id = detail_pergerakan_stok.id_detail_kj
                            INNER JOIN db_qc.tbl_kite ON tbl_kite.id = tmp_detail_kite.id_kite
                            WHERE 
                                detail_pergerakan_stok.sisa NOT IN ('FKTH', 'TH', 'SISA') 
                                AND pergerakan_stok.typestatus = '1'
                                AND tbl_kite.no_order = '" . $cwhere2 . "'
                                " . $cwhere1 . $cwhere10 . $cwhere11 . $cwhere12 . " 
                            GROUP BY 
                                tmp_detail_kite.id
                            ORDER BY 
                                MAX(pergerakan_stok.typestatus), 
                                MAX(detail_pergerakan_stok.nokk), 
                                MAX(detail_pergerakan_stok.no_roll) ASC ");
                            $no = 1;
                            $n = 1;
                            $c = 0;
                            while ($rowd = sqlsrv_fetch_array($datacek, SQLSRV_FETCH_ASSOC)) {
                                $cek = sqlsrv_query($con, "select * from db_qc.detail_pergerakan_stok 
		                                                 where id='$rowd[kd]' and refno!=''");
                                $crow = sqlsrv_fetch_array($cek, SQLSRV_FETCH_ASSOC);
                                if ($_SESSION['password'] == 'user') {
                                    $crow = 0;
                                }
                                if ($crow > 0) {
                                } else {
                            ?>

                                    <tr>
                                        <td align="center"><?PHP echo $rowd['nokk']; ?></td>
                                        <td align="center"><?PHP echo $rowd['no_lot']; ?></td>
                                        <td align="center"><?PHP echo $rowd['no_roll']; ?></td>
                                        <td align="center"><?PHP echo number_format($rowd['weight'], '2', '.', ','); ?></td>
                                        <td align="center"><?PHP echo $rowd['yard_']; ?></td>
                                        <td align="center"><?PHP echo $rowd['ukuran']; ?></td>
                                        <td align="center"><?PHP echo $rowd['netto']; ?></td>
                                        <td align="center"><input type="hidden" value="<?php echo number_format($rowd['weight'], '2', '.', ','); ?>" size="6" name="amount"><input type="hidden" value="<?php echo number_format($rowd['yard_'], '2', '.', ','); ?>" size="6" name="amount2"><?php
                                                                                                                                                                                                                                                                                                echo '<input type="checkbox" class="check-td" name="check[' . $n . ']" value="' . $rowd['kd'] . '"';
                                                                                                                                                                                                                                                                                                $n++;
                                                                                                                                                                                                                                                                                                ?>
                                        </td>
                                    </tr>
                            <?php
                                    $totalyard = $totalyard + $rowd['yard_'];
                                    $totalqty = $totalqty + $rowd['weight'];
                                    $no++;
                                }
                            } ?>
                        </tbody>
                        <p align="right">
                            <font color="red">
                                <b>Total Yard : <?php echo $totalyard; ?></b><br />
                                <b>Total Qty : <?php echo $totalqty; ?></b> <br />
                                <b>Total Panjang yang di ceklist: <label id="result_label"><span id="total2" style="color:red">0</span></label></b><br />
                                <b>Total Qty yang di ceklist: <label id="result_label"><span id="total" style="color:red">0</span></label></b>
                                <p><button class="btn btn-primary btn-sm pull-right" id="exesecution"><i class="fa fa-save"></i> Save</button></p>
                            </font>
                        </p>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <!-- <button type="button" id="SavePackingList" class="btn btn-info">Save</button> -->
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
    </div>
</div>

<script>
    $(function() {
        $('#lot_list').on('change', function() {
            let no_order = $('#dono_list').val();
            let no_po = $('#nopo_list').val();
            let no_item = $('#noitem_list').val();
            let warna = $('#warna_list').val();
            let no_lot = $('#lot_list').val();

            // if (no_order == '' || no_po == '' || no_item == '' || warna == '' || no_lot == '') {
            //     toastr.error('No. Order, PO , Warna, Item, LOT Wajib terisi !')
            // } else {
            $.ajax({
                dataType: "json",
                type: "POST",
                url: "API/get_Pack.php",
                data: {
                    no_order: no_order,
                    no_po: no_po,
                    no_item: no_item,
                    warna: warna,
                    no_lot: no_lot,
                },
                success: function(response) {
                    // console.log(response);
                    $('#pack_list option').each(function() {
                        if ($(this).val().substr(0, 1) == response.no_mc.substr(0, 1)) {
                            $(this).attr('selected', true)
                        }
                    });
                    $('#note_F').html(response.note)

                },
                error: function() {
                    alert("Error, Hubungi DIT team!");
                }
            });
            // }
        })


        // Count Yard & Netto checked
        $(document).on('click', '.check-th', function() {
            if ($(this).prop("checked") == true) {
                // $('#table-checkbox tbody tr').each(function() {
                //     $(this).find('td:eq(7) input').prop("checked", true)
                // })
                let panjang = 0;
                let qty = 0;
                $('#table-checkbox tbody tr').each(function() {
                    let tr = $(this);
                    $(this).find('td:eq(7) input').prop("checked", true)
                    if ($(this).find("td:eq(7) input:checkbox").prop("checked") == true) {
                        panjang += parseFloat(tr.find("td:eq(4)").html());
                        qty += parseFloat(tr.find("td:eq(3)").html());
                    } else {
                        console.log(false)
                    }
                })
                $("#total2").html(panjang);
                $("#total").html(qty);
            } else {
                $('#table-checkbox tbody tr').each(function() {
                    $(this).find('td:eq(7) input').prop("checked", false)
                })
                $("#total2").html(0);
                $("#total").html(0);
            }
        })

        $(document).on("click", ".check-td", function() {
            let panjang = 0;
            let qty = 0;
            $('#table-checkbox tbody tr').each(function() {
                let tr = $(this);
                if ($(this).find("td:eq(7) input:checkbox").prop("checked") == true) {
                    panjang += parseFloat(tr.find("td:eq(4)").html());
                    qty += parseFloat(tr.find("td:eq(3)").html());
                } else {
                    console.log(false)
                }
            })
            $("#total2").html(panjang);
            $("#total").html(qty);
        })

        $('#exesecution').click(function() {
            roam = new Array()
            $('.check-td').each(function() {
                if ($(this).prop("checked") == true) {
                    roam.push($(this).val())
                } else {
                    console.log($(this).val())
                }
            })

            if (roam.length == 0) {
                alert("Data has not been checklist");
            } else {
                if ($('#dono_list').val() == '') {
                    alert("No order required !");
                } else {
                    if ($('#pack_list').find(':selected').length < 1 || $('#pack_list').find(':selected').val() == "") {
                        alert("Please Select one of option Pack !");
                    } else {
                        $.ajax({
                            dataType: "json",
                            type: "POST",
                            url: "API/action_Mdl_pckList.php",
                            data: {
                                pack: $('#pack_list').find(':selected').val(),
                                no_list: $('#listno_list').val(),
                                dono: $('#dono_list').val(),
                                noitem: $('#noitem_list').find('option:selected').val(),
                                warna: $('#warna_list').find('option:selected').val(),
                                lot: $('#lot_list').find('option:selected').val(),
                                check: roam,
                                id: $('#id_list').val(),
                                submit: "SAVE"
                            },
                            success: function(response) {
                                if (response.kode == 200) {
                                    $('#packing-list').modal('hide')
                                    toastr.success(response.msg)
                                } else {
                                    toastr.error(response.msg)
                                }
                            },
                            error: function() {
                                alert("Error, Hubungi DIT team!");
                            }
                        });
                    }
                }

            }


        })


    })
</script>