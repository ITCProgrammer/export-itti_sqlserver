<?php
session_start();
include "koneksi.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Data Commercial Invoice</title>
</head>
<?php
$Thn  = isset($_POST['thn']) ? $_POST['thn'] : '';
if ($Thn != "") {
  $Thn1 = $Thn;
} else {
  $Thn1 = date('Y');
}
?>
<style>
  td.details-control {
    background: url('bower_components/DataTable/img/details_open.png') no-repeat center center;
    cursor: pointer;
  }

  tr.shown td.details-control {
    background: url('bower_components/DataTable/img/details_close.png') no-repeat center center;
  }

  th {
    font-size: 10pt;
  }

  td {
    font-size: 10pt;
  }

  .table_ci td,
  .table_ci th {
    border: 0.1px solid #ddd;
  }

  .table_ci th {
    color: black;
    background: #4CAF50;
  }

  .table_ci tr:hover {
    background-color: rgb(151, 170, 212);
  }

  .table_ci>thead>tr>td {
    border: 1px solid #ddd;
  }

  .modal-body {
    height: 80vh;
    overflow-y: auto;
  }

  .input-xs {
    height: 22px !important;
    padding: 2px 5px;
    font-size: 12px;
    line-height: 1.5;
    border-radius: 3px;
  }

  .input-group-xs>.form-control,
  .input-group-xs>.input-group-addon,
  .input-group-xs>.input-group-btn>.btn {
    height: 22px;
    padding: 1px 5px;
    font-size: 12px;
    line-height: 1.5;
  }
</style>

<body>
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="container-fluid with-border">
          <h4 class="box-title text-center" style="border-bottom: solid #ddd 1px;"><strong> Data Commercial Invoice </strong></h4>
          <form method="post" enctype="multipart/form-data" name="form1" class="form-horizontal" id="form1" style="border-bottom: solid #ddd 1px;">
            <div class="form-group">
              <label for="" class="col-lg-1 control-label" style="text-align:left;">FILTER :</label>
              <div class="col-sm-1">
                <select name="thn" id="thn" class="form-control input-sm">
                  <option value="">-Pilih-</option>
                  <?php
                  $thn_skr = date('Y');
                  for ($x = $thn_skr; $x >= 2016; $x--) {
                  ?>
                    <option value="<?php echo $x ?>" <?php if ($Thn != "") {
                                                        if ($x == $Thn) {
                                                          echo "SELECTED";
                                                        }
                                                      } else {
                                                        if ($x == $thn_skr) {
                                                          echo "SELECTED";
                                                        }
                                                      } ?>><?php echo $x ?></option>
                  <?php
                  }
                  ?>
                </select>
              </div>
              <button type="submit" class="btn btn-success btn-sm" name="cari"><i class="fa fa-search"></i> Cari</button>
              <!-- /.input group -->
              <a style="margin-right: 15px;" href="#" data-toggle="modal" data-target="#Modal_Ci" class="btn btn-primary pull-right btn-sm"><span class="fa fa-plus-circle"></span>
                Commercial Invoice</a>
            </div>
          </form>
        </div>
        <div class="container-fluid table-responsive">
          <br />
          <table id="table_ci" class="table table-sm display compact table_ci" style="width: 100%;">
            <thead>
              <tr>
                <th>#</th>
                <th> Commercial_Invoice</th>
                <th>NO SI</th>
                <th>Consignee</th>
                <th>Payment</th>
                <th>Term</th>
                <th>To</th>
                <th>Ship By</th>
                <th>Qty</th>
                <th>Amount</th>
                <th>Fasilitas</th>
                <th>Forwarder</th>
                <th>Status</th>
                <th>Next</th>
                <th>Author</th>
                <th>Print</th>
              </tr>
            </thead>
            <tbody>
              <?php
              if (empty($Thn1)) {
                $sql = sqlsrv_query($con, "SELECT TOP 500 * FROM db_qc.tbl_exim ORDER BY id DESC");
              } else {
                $sql = sqlsrv_query($con, "SELECT * FROM db_qc.tbl_exim WHERE YEAR(tgl)='$Thn1' ORDER BY id DESC");
              }
              if ($sql === false) {
                die(print_r(sqlsrv_errors(), true));
              }
              $no = 1;
              while ($rowd = sqlsrv_fetch_array($sql, SQLSRV_FETCH_ASSOC)) {
                $qrypl = sqlsrv_query($con, "SELECT count(*) jml
                                      FROM db_qc.detail_pergerakan_stok a
                                      INNER JOIN db_qc.tmp_detail_kite b ON b.id=a.id_detail_kj
                                      INNER JOIN db_qc.tbl_kite c ON c.id=b.id_kite
                                      WHERE refno='" . $rowd['listno'] . "'");
                $cpl = sqlsrv_fetch_array($qrypl, SQLSRV_FETCH_ASSOC);

                $sqldt1 = sqlsrv_query($con, " SELECT 
                                            SUM(a.weight) AS kgs,
                                            SUM(a.yard_) AS yds,
                                            SUM(b.netto) AS pcs,
                                            b.ukuran,
                                            c.user_packing,
                                            c.warna
                                        FROM db_qc.detail_pergerakan_stok a
                                        INNER JOIN db_qc.tmp_detail_kite b ON b.id = a.id_detail_kj
                                        INNER JOIN db_qc.tbl_kite c ON c.id = b.id_kite
                                        WHERE a.refno='" . $rowd['listno'] . "' 
                                        GROUP BY 
                                            b.ukuran, 
                                            c.user_packing, 
                                            c.warna;");
                $r1 = sqlsrv_fetch_array($sqldt1, SQLSRV_FETCH_ASSOC);
                if ($r1 === false) {
                  die(print_r(sqlsrv_errors(), true));
                }
                $sqlsi = sqlsrv_query($con, "SELECT * FROM db_qc.tbl_exim_si WHERE no_si='" . $rowd['no_si'] . "'");
                $r2 = sqlsrv_fetch_array($sqlsi, SQLSRV_FETCH_ASSOC);
              ?>
                <tr>
                  <td style="vertical-align: middle;" align="center"><?php echo $no; ?></td>
                  <td style="vertical-align: middle;" align="center" style="color: black;">
                    <?php echo $rowd['listno']; ?><br />
                    <div class="btn-group-vertical">
                      <!-- action 1 -->
                      <a style="color: black;" href="javascript:void(0)" title="[Input Packing List]" data-listno="<?php echo $rowd['listno']; ?>" class="btn btn-xs btn-info invoice_detail">
                        <?php if ($cpl['jml'] > 0) { ?>
                          • Packing List <img src="dist/img/xpl.png" width="16" height="16" alt="" />
                        <?php } else { ?>
                          • Packing List <img src="dist/img/xpldisable.png" width="16" height="16" alt="" />
                        <?php } ?>
                      </a>
                      <!-- action 2 -->
                      <a style="color: black;" href="javascript:void(0)" data-listno="<?php echo $rowd['listno']; ?>" title="[Input Pengiriman Barang]" class="btn btn-xs btn-danger tambah-peb">
                        <?php if ($rowd['no_peb'] != "") { ?>
                          • Pengiriman <img src="dist/img/xpeb.png" width="16" height="16" alt="" />
                        <?php } else { ?>
                          • Pengiriman <img src="dist/img/xpebdisable.png" width="16" height="16" alt="" />
                        <?php } ?>
                      </a>
                      <!-- action 3 -->
                      <a style="color: black;" href="javascript:void(0)" data-listno=<?php echo $rowd['listno']; ?> title="[Input Pengembalian B/L]" class="btn btn-xs btn-warning tambah-bl">
                        <?php if ($rowd['no_tagihan'] != "") { ?>
                          • Tagihan <img src="dist/img/xbl.png" width="16" height="16" alt="" />
                        <?php } else { ?>
                          • Tagihan <img src="dist/img/xbldisable.png" width="16" height="16" alt="" />
                        <?php } ?>
                      </a>
                      <!-- action 4 -->
                      <a style="color: black;" href="#" data-listno="<?php echo $rowd['listno']; ?>" title="[Input Pengiriman Dokumen]" class="btn btn-xs btn-primary tambah-awb">
                        <?php if ($rowd['no_awb'] != "") { ?>
                          • <i class="fa fa-truck fa-flip-horizontal" aria-hidden="true"></i> Dokumen <img src="dist/img/xdoc.png" width="16" height="16" alt="" />
                        <?php } else { ?>
                          • <i class="fa fa-truck fa-flip-horizontal" aria-hidden="true"></i> Dokumen <img src="dist/img/xdocdisable.png" width="16" height="16" alt="" /><?php } ?>
                      </a>
                      <!-- action 5 -->
                      <a style="color: black;" href="#" title="[Input Shipment Advice]" no="<?php echo $rowd['listno']; ?>" pk="<?php echo $rowd['no_sa']; ?>" class="btn btn-xs btn-success pilih-sa">
                        <?php if ($rowd['no_sa'] != "") { ?>
                          Shipment Advice <img src="dist/img/xsa.png" width="16" height="16" alt="" />
                        <?php } else { ?>
                          Shipment Advice <img src="dist/img/xsadisable.png" width="16" height="16" alt="" /><?php } ?>
                      </a>
                    </div>
                  </td>
                  <td style="vertical-align: middle;" align="center"><?php if ($rowd['no_si'] != "") {
                                                                        echo $rowd['no_si'];
                                                                      } else { ?><a href="#" data-listno="<?php echo $rowd['listno']; ?>" class="tambah_si"><span class="label label-success">BUAT SI</span></a> <a href="#" data-no="<?php echo $rowd['no_si']; ?>" data-pk='<?php echo $rowd['id']; ?>' title="[Input Shipping Instruction]" class="pilih_si"><span class="label label-primary">PILIH SI</span></a><?php } ?></td>
                  <td style="vertical-align: middle;"><?php echo strtoupper($rowd['nm_consign']); ?></td>
                  <td style="vertical-align: middle;"><?php echo strtoupper($rowd['payment']); ?></td>
                  <td style="vertical-align: middle;"><?php echo strtoupper($rowd['incoterm']); ?></td>
                  <td style="vertical-align: middle;"><?php echo strtoupper($rowd['t_country']); ?></td>
                  <td style="vertical-align: middle;"><?php echo strtoupper($rowd['shipment_by']) . "<br> ETD:" . ($r2['etd'] ? $r2['etd']->format('Y-m-d') : null) . "<br> ETA:" . ($r2['eta'] ? $r2['eta']->format('Y-m-d') : null); ?></td>
                  <td style="vertical-align: middle;"><?php if ($r1['kgs'] != "") {
                                                        echo $r1['kgs'];
                                                      } else {
                                                        echo "-";
                                                      } ?></td>
                  <td style="vertical-align: middle;"><?php
                                                      $amout = 0;
                                                      $amt = 0;
                                                      $sqldt = sqlsrv_query($con, "SELECT * FROM db_qc.tbl_exim_detail WHERE id_list='" . $rowd['id'] . "'");
                                                      while ($dt = sqlsrv_fetch_array($sqldt)) {
                                                        $sqldt1 = sqlsrv_query($con, " SELECT 
                                                            SUM(a.weight) AS kgs,
                                                            SUM(a.yard_) AS yds,
                                                            SUM(b.netto) AS pcs,
                                                            b.ukuran,
                                                            c.user_packing,
                                                            c.warna
                                                        FROM db_qc.detail_pergerakan_stok a
                                                        INNER JOIN db_qc.tmp_detail_kite b ON b.id = a.id_detail_kj
                                                        INNER JOIN db_qc.tbl_kite c ON c.id = b.id_kite
                                                        WHERE a.refno = '" . $rowd['listno'] . "'
                                                          AND a.lott = '" . $dt['id'] . "'
                                                        GROUP BY 
                                                            b.ukuran, 
                                                            c.user_packing, 
                                                            c.warna;");
                                                        $dt1 = sqlsrv_fetch_array($sqldt1);

                                                        if ($dt['price_by'] == "KGS") {
                                                          $amout = round($dt1['kgs'] * $dt['unit_price'], 2);
                                                        } else if ($dt['price_by'] == "YDS") {
                                                          $amout = round($dt1['yds'] * $dt['unit_price'], 2);
                                                        } else if ($dt['price_by'] == "PCS") {
                                                          $amout = round($dt1['pcs'] * $dt['unit_price'], 2);
                                                        } else {
                                                          $amout = 0;
                                                        }
                                                        $amt = $amt + $amout;
                                                      }
                                                      if ($amt > 0) {
                                                        echo number_format($amt, 2);
                                                      } else {
                                                        echo "-";
                                                      }
                                                      ?></td>
                  <td style="vertical-align: middle;" align="center"><?php echo $rowd['fasilitas']; ?></td>
                  <td style="vertical-align: middle;"><?php echo strtoupper($r2['forwarder']); ?></td>
                  <td style="vertical-align: middle;" align="center"><?php
                                                                      $sqlcek = sqlsrv_query($con, "SELECT a.id,b.id_list FROM db_qc.tbl_exim a
                                                              LEFT JOIN db_qc.tbl_exim_detail b ON a.id=b.id_list
                                                              WHERE listno='" . $rowd['listno'] . "'");
                                                                      $ck = sqlsrv_fetch_array($sqlcek);
                                                                      if ($ck['id_list'] != "") {
                                                                        if ($rowd['no_sa'] != "") {
                                                                          echo "<span class='label label-warning'>BUAT SA</span>";
                                                                        } else {
                                                                          if ($rowd['no_awb'] != "") {
                                                                            echo "<span class='label label-danger'>KIRIM DOKUMEN</span>";
                                                                          } else {
                                                                            if ($rowd['no_tagihan'] != "") {
                                                                              echo "<span class='label label-primary'>AMBIL B/L</span>";
                                                                            } else {
                                                                              if ($rowd['no_peb'] != "") {
                                                                                echo "PENGIRIMAN CARGO";
                                                                              } else {
                                                                                if ($rowd['no_si'] != "") {
                                                                                  echo "<span class='label label-success'>BUAT SI</span>";
                                                                                } else {
                                                                                  if ($cpl['jml'] > 0) {
                                                                                    echo "<span class='label bg-navy'>BUAT PACKING LIST</span>";
                                                                                  } else {
                                                                                    echo "<span class='label bg-gray'>BUAT DETAIL INVOICE</span>";
                                                                                  }
                                                                                }
                                                                              }
                                                                            }
                                                                          }
                                                                        }
                                                                      } else
		                                  if ($ck['id'] != "") {
                                                                        echo "<span class='label bg-purple'>BUAT INVOICE</span>";
                                                                      } else {
                                                                        echo "<span class='label bg-fuchsia'>BUAT PI</span>";
                                                                      }
                                                                      ?></td>
                  <td style="vertical-align: middle;" align="center"><?php
                                                                      $sqlcek = sqlsrv_query($con, "SELECT a.id,b.id_list FROM db_qc.tbl_exim a
                                                              LEFT JOIN db_qc.tbl_exim_detail b ON a.id=b.id_list
                                                              WHERE listno='" . $rowd['listno'] . "'");
                                                                      $ck = sqlsrv_fetch_array($sqlcek);
                                                                      if ($ck['id_list'] != "") {
                                                                        if ($rowd['no_sa'] != "") {
                                                                          echo "<span class='label bg-fuchsia'>ARSIP</span>";
                                                                        } else {
                                                                          if ($rowd['no_awb'] != "") {
                                                                            echo "<a href='#' class='add-sa' ci='" . $rowd['listno'] . "'>BUAT SA</a>";
                                                                          } else {
                                                                            if ($rowd['no_tagihan'] != "") {
                                                                              echo "<a href='#' class='label label-danger'>KIRIM DOKUMEN</a>";
                                                                            } else {
                                                                              if ($rowd['no_peb'] != "") {
                                                                                echo "<a href='#' class='label label-black'>AMBIL B/L</a>";
                                                                              } else {
                                                                                if ($rowd['no_si'] != "") {
                                                                                  echo "<a href='#' class='label label-info'>PENGIRIMAN CARGO</a>";
                                                                                } else {
                                                                                  if ($cpl['jml'] > 0) {
                                                                                    echo "<span class='label label-success'>BUAT SI</span>";
                                                                                  } else {
                                                                                    echo "<a href='#' class='label label-success'>BUAT PACKING LIST</a>";
                                                                                  }
                                                                                }
                                                                              }
                                                                            }
                                                                          }
                                                                        }
                                                                      } else
                                      if ($ck['id'] != "") {
                                                                        echo "<a href='#'><span class='label bg-gray'>BUAT DETAIL INVOICE</span></a>";
                                                                      } else {
                                                                        echo "<span class='label bg-purple'>BUAT INVOICE</span>";
                                                                      }
                                                                      ?></td>
                  <td style="vertical-align: middle;" align="center"><?php echo strtoupper($rowd['author']); ?></td>
                  <td style="vertical-align: middle;" align="center">
                    <a href="#" title="[Cetak Invoice]" class="btn btn-xs cetak_ci" id="<?php echo $rowd['listno']; ?>"><img src="dist/img/postdateicon.png" alt="delete" width="16" height="16" /></a>
                    <br />
                    <a href="#" title="[Cetak Packing List]" class="btn btn-xs cetak_pl" id="<?php echo $rowd['listno']; ?>"><img src="dist/img/postediticon.png" alt="delete" width="16" height="16" /></a>
                    <br />
                    <a href="#" title="[Cetak SA]" class="btn btn-xs cetak_sa" id="<?php echo $rowd['id']; ?>"><img src="dist/img/posttagicon.png" alt="delete" width="16" height="16" /></a>
                    <br />
                    <a href="#" title="[Cetak SI]" class="btn btn-xs cetak_si" id="<?php echo $rowd['no_si']; ?>"><img src="dist/img/postemailicon.png" alt="delete" width="16" height="16" /></a>
                  </td>
                </tr>
              <?php $no++;
              } ?>
            </tbody>
            <tfoot class="bg-red">
            </tfoot>
          </table>
        </div>
      </div>
    </div>
  </div>
  <!-- ///////////////////////////////////////////// MODAL ADD COMMERCIAL INVOICE ////////////////////////////////////////////// -->
  <div class="modal fade" id="Modal_Ci" data-backdrop="static" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog" style="width:96%">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#formCI"><i class="fa fa-barcode" aria-hidden="true"></i> Form Commercial Invoice</a></li>
            <li style="display: none;"><a data-toggle="tab" href="#DetailCI_1"><i class="fa fa-fw fa-plus"></i> Detail Invoice (FABRIC)</a></li>
            <li style="display: none;"><a data-toggle="tab" href="#DetailCI_2"><i class="fa fa-fw fa-plus"></i> Detail Invoice (FLAT)</a></li>
          </ul>
        </div>
        <div class="tab-content">
          <!-- TAB 1 -->
          <div id="formCI" class="tab-pane fade in active">
            <form action="#" method="post" id="form_add_ci" class="form-horizontal">
              <div class="modal-body">
                <div class="row">
                  <!-- ///////////////////////////////////////////////////////////////// KIRI -->
                  <div class="container-fluid col-lg-6" style="border-right: solid #D2D6DE 1px;">
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-2 control-label">Packing List ⮞</label>
                      <div class="col-lg-5 input-group">
                        <input type="text" name="listno" id="listno" class="form-control" placeholder="No Packing list" value="EPT020/ITTI/01/18" autocomplete="on">
                        <span class="input-group-btn">
                          <button id="act_listno" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="Generate Data Packing list" type="button"><i class="fa fa-fw fa-search"></i></button>
                          <button class="btn" style="background-color: #FFFFFF;" type="button">&nbsp;&nbsp;&nbsp;&nbsp;</button>
                          <button class="btn btn-danger" id="clear-form" data-toggle="tooltip" data-placement="bottom" title="Clear Data Before" type="button"><i class="fa fa-repeat"></i></button>
                        </span>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-2 control-label">Name MESSRS ⮞</label>
                      <div class="col-lg-9 input-group">
                        <select type="text" name="nm_messrs" id="nm_messrs" class="form-control" style="width: 100%;">
                          <option value="">-Pilih-</option>
                          <?php $qrymes = sqlsrv_query($con, "SELECT * FROM db_qc.tbl_exim_buyer ORDER BY nama ASC");
                          while ($rmes = sqlsrv_fetch_assoc($qrymes)) { ?>
                            <option value="<?php echo strtoupper($rmes['nama']); ?>" <?php if ($_GET['mess'] != "") {
                                                                                        if ($_GET['mess'] == $rmes['nama']) {
                                                                                          echo "SELECTED";
                                                                                        }
                                                                                      } else {
                                                                                        if ($row['nm_messrs'] == $rmes['nama']) {
                                                                                          echo "SELECTED";
                                                                                        }
                                                                                      } ?>><?php echo $rmes['nama']; ?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="" class="col-lg-2 control-label">Address MESSRS ⮞</label>
                      <div class="col-lg-9 input-group">
                        <textarea class="form-control input-sm" name="alt_messrs" id="alt_messrs" cols="30" rows="3"></textarea>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="" class="col-lg-2 control-label input-sm">Name Consignee ⮞</label>
                      <div class="col-lg-9 input-group">
                        <select class="form-control" name="nm_consgne" id="nm_consgne" style="width: 100%;">
                          <option value="">-Pilih-</option>
                          <?php $qrycon = sqlsrv_query($con, "SELECT * FROM db_qc.tbl_exim_buyer ORDER BY nama ASC");
                          while ($rcon = sqlsrv_fetch_assoc($qrycon)) { ?>
                            <option value="<?php echo strtoupper($rcon['nama']); ?>"
                              <?php if ($_GET['cons'] != "") {
                                if ($_GET['cons'] == $rcon['nama']) {
                                  echo "SELECTED";
                                }
                              } else {
                                if ($row['nm_consign'] == $rcon['nama']) {
                                  echo "SELECTED";
                                }
                              } ?>><?php echo strtoupper($rcon['nama']); ?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="" class="col-lg-2 control-label"><small> Address Consignee ⮞</small></label>
                      <div class="col-lg-9 input-group">
                        <textarea class="form-control input-sm" name="alt_consgne" id="alt_consgne" cols="30" rows="3"></textarea>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="" class="col-lg-2 control-label">Dated ⮞</label>
                      <div class="col-lg-9 input-group">
                        <input class="form-control input-sm datepicker" name="tgl1" id="tgl1" />
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="" class="col-lg-2 control-label">Fasilitas ⮞</label>
                      <div class="col-lg-9 input-group">
                        <select name="fasilitas" id="fasilitas" class="form-control input-sm">
                          <option value="UMUM" <?php if ($row['fasilitas'] == "UMUM") {
                                                  echo "selected";
                                                } ?>>UMUM</option>
                          <option value="KITE" <?php if ($row['fasilitas'] == "KITE") {
                                                  echo "selected";
                                                } ?>>KITE</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="" class="col-lg-2 control-label">Shipment By ⮞</label>
                      <div class="col-lg-9 input-group">
                        <select name="shipmnt" id="shipmnt" class="form-control input-sm">
                          <option value="SEA" <?php if ($row['shipment_by'] == "SEA") {
                                                echo "SELECTED";
                                              } ?>>SEA</option>
                          <option value="AIR" <?php if ($row['shipment_by'] == "AIR") {
                                                echo "SELECTED";
                                              } ?>>AIR</option>
                          <option value="COURIER" <?php if ($row['shipment_by'] == "COURIER") {
                                                    echo "SELECTED";
                                                  } ?>>COURIER</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="" class="col-lg-2 control-label">Payment ⮞</label>
                      <div class="col-lg-9 input-group">
                        <select name="payment" id="payment" class="form-control input-sm" style="width: 100%;">
                          <option value="L/C" <?php if ($row['payment'] == "L/C") {
                                                echo "SELECTED";
                                              } ?>>L/C</option>
                          <option value="T/T" <?php if ($row['payment'] == "T/T") {
                                                echo "SELECTED";
                                              } ?>>T/T</option>
                          <option value="D/P" <?php if ($row['payment'] == "D/P") {
                                                echo "SELECTED";
                                              } ?>>D/P</option>
                          <option value="FOC" <?php if ($row['payment'] == "FOC") {
                                                echo "SELECTED";
                                              } ?>>FOC</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="" class="col-lg-2 control-label">No. L/C ⮞</label>
                      <div class="col-lg-9 input-group">
                        <input type="text" name="no_lc" id="no_lc" class="form-control input-sm">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="" class="col-lg-2 control-label">Date L/C ⮞</label>
                      <div class="col-lg-9 input-group" style="border-bottom: solid #bfbfbf 1px; padding-bottom: 15px;">
                        <input type="text" name="tgl2" id="tgl2" class="form-control input-sm datepicker">
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="" class="col-lg-2 control-label">Incoterm ⮞</label>
                      <div class="col-lg-9 input-group">
                        <select name="incoterm" id="incoterm" tabindex="10" class="form-control" style="width: 100%">
                          <option value="">-Pilih-</option>
                          <option value="FOB" <?php if ($row['incoterm'] == "FOB") {
                                                echo "SELECTED";
                                              } ?>>FOB</option>
                          <option value="CNF" <?php if ($row['incoterm'] == "CNF") {
                                                echo "SELECTED";
                                              } ?>>CNF</option>
                          <option value="CIF" <?php if ($row['incoterm'] == "CIF") {
                                                echo "SELECTED";
                                              } ?>>CIF</option>
                          <option value="DDU" <?php if ($row['incoterm'] == "DDU") {
                                                echo "SELECTED";
                                              } ?>>DDU</option>
                          <option value="DDP" <?php if ($row['incoterm'] == "DDP") {
                                                echo "SELECTED";
                                              } ?>>DDP</option>
                          <option value="EXWORK" <?php if ($row['incoterm'] == "EXWORK") {
                                                    echo "SELECTED";
                                                  } ?>>EXWORK</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="" class="col-lg-2 control-label input-sm"><small>Vessel/Flight/Courier⮞</small></label>
                      <div class="col-lg-9 input-group" style="border-bottom: solid #bfbfbf 1px; padding-bottom: 15px;">
                        <input class="form-control input-sm" name="nm_trans" type="text" id="nm_trans" value="<?php if ($_GET['listno'] != "") {
                                                                                                                echo $row['v_f_c_nm'];
                                                                                                              } ?>" size="40" tabindex="11" />
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="" class="col-lg-2 control-label">Connecting ⮞</label>
                      <div class="col-lg-9 input-group" style="border-bottom: solid #bfbfbf 1px; padding-bottom: 15px;">
                        <input class="form-control input-sm" name="connecting" type="text" id="connecting" value="<?php if ($_GET['listno'] != "") {
                                                                                                                    echo $row['connecting'];
                                                                                                                  } ?>" size="35" tabindex="12" />
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="" class="col-lg-2 control-label">Connecting Date ⮞</label>
                      <div class="col-lg-9 input-group">
                        <input type="text" name="tgl3" id="tgl3" type="text" class="form-control input-sm datepicker">
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="" class="col-lg-2 control-label input-sm"><small>Sailing/Flight Date⮞</small></label>
                      <div class="col-lg-9 input-group">
                        <input name="tgl4" type="text" id="tgl4" class="form-control input-sm datepicker">
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="" class="col-lg-2 control-label">ETA ⮞</label>
                      <div class="col-lg-9 input-group input-group">
                        <input name="tgl5" id="tgl5" type="text" class="form-control input-sm datepicker">
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                      </div>
                    </div>
                  </div>
                  <!-- ////////////////////////////////////////////////////// KANAN -->
                  <div class="container-fluid col-lg-6">
                    <div class="form-group">
                      <label for="" class="col-lg-2 control-label">From Country ⮞</label>
                      <div class="col-lg-9 input-group">
                        <input name="f_country" type="text" id="f_country" class="form-control input-sm" value="<?php if ($row['f_country'] != "") {
                                                                                                                  echo strtoupper($row['f_country']);
                                                                                                                } else {
                                                                                                                  echo "TG. PRIOK -JAKARTA, INDONESIA / JAKARTA, INDONESIA";
                                                                                                                } ?>" size="60" tabindex="16" />
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="" class="col-lg-2 control-label">To Country ⮞</label>
                      <div class="col-lg-9 input-group">
                        <input name="t_country" type="text" id="t_country" class="form-control input-sm" value="<?php if ($_GET['listno'] != "") {
                                                                                                                  echo $row['t_country'];
                                                                                                                } ?>" size="40" tabindex="17" />
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="" class="col-lg-2 control-label">Left Area ⮞</label>
                      <div class="col-lg-9 input-group">
                        <textarea name="left_a" id="left_a" class="form-control input-sm" cols="30" rows="2"><?php if ($_GET['listno'] != "") {
                                                                                                                echo strip_tags(strtoupper($row['l_area']));
                                                                                                              } ?></textarea>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="" class="col-lg-2 control-label">Right Area ⮞</label>
                      <div class="col-lg-9 input-group">
                        <textarea class="form-control input-sm" name="right_a" id="right_a" cols="60" rows="2" tabindex="19"><?php if ($row['r_area'] != "") {
                                                                                                                                echo strip_tags($row['r_area']);
                                                                                                                              } else { //echo "NOTE : CLIENT RESPONSIBLE FOR ALL BANK CHARGE"; } 
                                                                                                                              ?></textarea>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="" class="col-lg-2 control-label">Forwarder ⮞</label>
                      <div class="col-lg-9 input-group">
                        <input name="forwarder" type="text" id="forwarder" class="form-control input-sm" tabindex="20" value="<?php if ($_GET['listno'] != "") {
                                                                                                                                  echo $row['forwarder'];
                                                                                                                                } ?>" readonly="readonly" />
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="" class="col-lg-2 control-label">Forwarder Atn ⮞</label>
                      <div class="col-lg-9 input-group">
                        <input name="f_atn" class="form-control input-sm" type="text" id="f_atn" tabindex="21" value="<?php if ($_GET['listno'] != "") {
                                                                                                                                  echo $row['f_atn'];
                                                                                                                                } ?>" readonly="readonly" />
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="" class="col-lg-2 control-label">No. SI ⮞</label>
                      <div class="col-lg-9 input-group">
                        <select class="form-control input-sm" name="no_si" id="no_si">
                          <option value="">Pilih</option>
                          <?php $qrysi = sqlsrv_query($con, "SELECT * FROM db_qc.tbl_exim_si");
                                                                                                                                while ($rsi = sqlsrv_fetch_assoc($qrysi)) { ?>
                            <option value="<?php echo $rsi['no_si']; ?>" <?php if ($row['no_si'] == $rsi['no_si']) {
                                                                                                                                    echo "SELECTED";
                                                                                                                                  } ?>><?php echo $rsi['no_si']; ?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="" class="col-lg-2 control-label">Date SI ⮞</label>
                      <div class="col-lg-9 input-group">
                        <input class="form-control input-sm" name="tgl6" type="text" id="tgl6" value="<?php if ($_GET['listno'] != "") {
                                                                                                                                  echo $row['tgl_si'];
                                                                                                                                } ?>" readonly="readonly" />
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="" class="col-lg-2 control-label">Status ⮞</label>
                      <div class="col-lg-9 input-group">
                        <select name="status1" id="status1" tabindex="24" disabled="disabled" class="form-control input-sm">
                          <option value="">-Pilih-</option>
                          <option value="FCL" <?php if ($row['status1'] == "FCL") {
                                                                                                                                  echo "SELECTED";
                                                                                                                                } ?>>FCL</option>
                          <option value="LCL" <?php if ($row['status1'] == "LCL") {
                                                                                                                                  echo "SELECTED";
                                                                                                                                } ?>>LCL</option>
                          <option value="BY AIR" <?php if ($row['status1'] == "BY AIR") {
                                                                                                                                  echo "SELECTED";
                                                                                                                                } ?>>BY AIR</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="" class="col-lg-2 control-label">Status 2 ⮞</label>
                      <div class="col-lg-9 input-group">
                        <textarea name="status2" id="status2" class="form-control input-sm" cols="60" rows="2" readonly="readonly" id="status2" tabindex="25"><?php if ($_GET['listno'] != "") {
                                                                                                                                                                echo $row['status2'];
                                                                                                                                                              } ?></textarea>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="" class="col-lg-2 control-label">Author ⮞</label>
                      <div class="col-lg-9 input-group">
                        <input name="author" type="text" id="author" class="form-control input-sm" readonly="readonly" value="<?php if ($row['author'] != "") {
                                                                                                                                  echo $row['author'];
                                                                                                                                } else {
                                                                                                                                  echo ucwords($_SESSION['usernm1']);
                                                                                                                                } ?>" tabindex="26" />
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="" class="col-lg-2 control-label">Remarks SI ⮞</label>
                      <div class="col-lg-9 input-group">
                        <textarea name="r_si" cols="60" rows="3" readonly="readonly" class="form-control" id="r_si" tabindex="27"><?php if ($row['r_si'] != "") {
                                                                                                                                    echo strip_tags($row['r_si']);
                                                                                                                                  } ?></textarea>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="" class="col-lg-2 control-label">Shipping Mark ⮞</label>
                      <div class="col-lg-9 input-group">
                        <textarea name="shipping" class="form-control input-sm" id="shipping" cols="60" rows="3" tabindex="28"><?php if ($_GET['listno'] != "" and $row['s_mark'] != "") {
                                                                                                                                  echo strip_tags($row['s_mark']);
                                                                                                                                } else {
                                                                                                                                  echo "REMARKS: CERTIFIED BY CONTROL UNION ACCORDING TO THE ORGANIC EXCHANGE BLENDED STANDARD";
                                                                                                                                } ?></textarea>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="" class="col-lg-2 control-label">Surcharge ⮞</label>
                      <div class="col-lg-9 input-group">
                        <input class="form-control input-sm" name="s_charge" type="text" id="s_charge" value="<?php if ($_GET['listno'] != "") {
                                                                                                                                  echo $row['s_charge'];
                                                                                                                                } else {
                                                                                                                                  echo "0";
                                                                                                                                } ?>" size="10" tabindex="29" />
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="" class="col-lg-2 control-label">No. B/L ⮞</label>
                      <div class="col-lg-9 input-group">
                        <input name="no_bl" class="form-control input-sm" type="text" id="no_bl" tabindex="30" value="<?php if ($_GET['listno'] != "") {
                                                                                                                                  echo $row['no_bl'];
                                                                                                                                } ?>" size="35" readonly="readonly" />
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="" class="col-lg-2 control-label">No Container ⮞</label>
                      <div class="col-lg-9 input-group">
                        <textarea name="no_container" cols="60" rows="3" class="form-control input-sm" readonly="readonly" id="no_container" tabindex="31"><?php if ($_GET['listno'] != "") {
                                                                                                                                                              echo $row['no_cont'];
                                                                                                                                                            } ?></textarea>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="container" style="padding: 10px; border-top: solid #D2D6DE 1px;">
                  <div class="col-lg-6">
                    <button type="button" id="insertForm" data-toggle="tooltip" data-placement="bottom" title="Submit Form" class="btn btn-info btn-block">Submit Form</button>
                  </div>
                  <div class="col-lg-6">
                    <button type="button" class="btn btn-danger btn-block" data-toggle="tooltip" data-placement="top" title="Click for hide Pop-up" data-dismiss="modal">Close Pop-up</button>
                  </div>
                </div>
              </div>
            </form>
          </div>
          <!-- TAB 2 -->
          <div id="DetailCI_1" class="tab-pane fade">
            <div class="modal-body">
              <div class="row">
                <form action="#" method="post" id="form_detail_fabric" class="form-horizontal">
                  <input type="hidden" id="id_fabric" name="id_fabric" required>
                  <div class="container-fluid col-lg-4" style="border-right: solid #D2D6DE 1px;">
                    <div class="form-group">
                      <label for="" class="col-lg-4 control-label input-xs">No Invoice ▶</label>
                      <div class="col-lg-5 input-group">
                        <input class="form-control input-xs" type="text" name="listno_fabric" id="listno_fabric" readonly="true" />
                        <span class="input-group-btn">
                          <button type="button" class="btn btn-xs btn-default"><i class="fa fa-file-code-o" aria-hidden="true"></i></button>
                        </span>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="" class="col-lg-4 control-label input-xs">Type Of Fabric ▶</label>
                      <div class="col-lg-6 input-group">
                        <input class="form-control input-xs" type="text" name="jns_fabric" id="jns_fabric" readonly="true" value="KNITTED FABRIC" />
                        <span class="input-group-btn">
                          <button type="button" class="btn btn-default btn-xs"><i class="fa fa-info" aria-hidden="true"></i></button>
                        </span>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="" class="col-lg-4 control-label input-xs">No.Order/Proforma Invoice</label>
                      <div class="col-lg-7 input-group">
                        <input class="form-control input-xs" name="dono_fabric" type="text" id="dono_fabric" required />
                        <span class="input-group-btn">
                          <button class="btn btn-warning input-xs" id="act_order_fabric" data-toggle="tooltip" data-placement="top" title="Generate Order" type="button"><i class="fa fa-download"></i></button>
                        </span>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="" class="col-lg-4 control-label input-xs">Nomor PO ▶</label>
                      <div class="col-lg-7 input-group">
                        <select class="form-control input-xs" name="no_po_fabric" id="no_po_fabric">
                          <option value="" selected disabled>-PILIH-</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="" class="col-lg-4 control-label input-xs">No. Item ▶</label>
                      <div class="col-lg-7 input-group">
                        <select class="form-control input-xs" name="no_item_fabric" id="no_item_fabric">
                          <option value="" selected disabled>-PILIH-</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="container-fluid col-lg-4" style="border-right: solid #D2D6DE 1px;">
                    <div class="form-group">
                      <label for="" class="col-lg-2 control-label input-xs">Warna ▶</label>
                      <div class="col-lg-9 input-group">
                        <select class="form-control input-xs" name="warna" id="warna">
                          <option value="" selected disabled>-PILIH-</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="" class="col-lg-2 control-label input-xs">Description ▶</label>
                      <div class="col-lg-9 input-group" style="margin-left: 5px;">
                        <textarea class="form-control input-sm" rows="2" type="text" name="desc1_fabric" id="desc1_fabric" required></textarea>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="" class="col-lg-2 control-label input-xs">Price By ▶</label>
                      <div class="col-lg-9 input-group" style="margin-left: 5px;">
                        <select name="price_by_fabric" id="price_by_fabric" class="form-control input-xs">
                          <option value="KGS">KGS</option>
                          <option value="YDS">YDS</option>
                          <option value="PCS">PCS</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="" class="col-lg-2 control-label input-xs">PI Detail ▶</label>
                      <div class="col-lg-9 input-group" style="margin-left: 5px;">
                        <select name="id_pi_fabric" id="id_pi_fabric" class="form-control input-xs">
                          <option value="" selected disabled>-PILIH-</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="container-fluid col-lg-4" style="border-right: solid #D2D6DE 1px;">
                    <div class="form-group">
                      <label for="" class="col-lg-2 control-label input-xs">Unit Price ▶</label>
                      <div class="col-lg-9 input-group" style="margin-left: 5px;">
                        <input name="unit_fabric" type="text" id="unit_fabric" class="form-control input-xs">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="" class="col-lg-2 control-label input-xs">Description 2 ▶</label>
                      <div class="col-lg-9 input-group" style="margin-left: 5px;">
                        <textarea name="desc2_fabric" id="desc2_fabric" rows="2" class="form-control input-sm">KNITT FABRIC MADE WITH 0% ORGANICALLY COTTON</textarea>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="" class="col-lg-2 control-label input-xs">Style ▶</label>
                      <div class="col-lg-9 input-group" style="margin-left: 5px;">
                        <select name="style_fabric" id="style_fabric" class="form-control input-xs">
                          <option value=""></option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="" class="col-lg-2 control-label input-xs">Weight ▶</label>
                      <div class="col-lg-9 input-group" style="margin-left: 5px;">
                        <input type="text" name="weight_fabric" id="weight_fabric" class="form-control input-xs">
                      </div>
                    </div>
                  </div>
                </form>
              </div>
              <div class="row">
                <div class="container-fluid">
                  <div class="col-lg-4">
                    <button type="button" id="act_form_fabric" class="btn btn-info btn-sm" style="color: black;"><strong>
                        <span class="fa fa-save"></span>
                        Save Detail
                      </strong>
                    </button>
                    <a class="btn btn-danger btn-sm" id="print_invoice"><strong>
                        <span class="fa fa-print"></span>
                        Print Invoice
                      </strong>
                    </a>
                    <a class="btn btn-success btn-sm" style="color: black;" id="exportToExcel"><strong>
                        <span class="fa fa-file-excel-o" aria-hidden="true"></span>
                        Export to Excel
                      </strong>
                    </a>
                  </div>
                  <div class="col-lg-4">
                    <h4 class="text-center"><strong>Details Proforma Invoice</strong></h4>
                  </div>
                  <div class="col-lg-4"></div>
                </div>
                <div class="container-fluid" style="border-top: solid #D2D6DE 1px;" id="PlaceTableTab2">
                </div>
              </div>
            </div>
            <div class="container">
              <div class="col-lg-12 text-center center-block" style="padding: 10px; border-top: solid #D2D6DE 1px;">
                <button type="button" class="btn btn-danger text-center" data-toggle="tooltip" data-placement="top" title="Click for hide Pop-up" data-dismiss="modal">Close Pop-up</button>
              </div>
            </div>
          </div>
          <!-- TAB 3 -->
          <div id="DetailCI_2" class="tab-pane fade">
            <div class="modal-body">
              <div class="row">
                <form action="#" method="post" id="form_detail_flat" class="form-horizontal">
                  <input type="hidden" id="id_flat" name="id_flat" required>
                  <div class="col-lg-5" style="border-right: solid #D2D6DE 1px;">
                    <div class="form-group">
                      <label for="" class="col-lg-2 control-label input-sm">Type Of Fabric ▶</label>
                      <div class="col-lg-9 input-group">
                        <input name="jns_flat" type="text" id="jns_flat" class="form-control input-sm" value="FLAT KNIT" readonly>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="" class="col-lg-2 control-label input-sm">No.Order/Proforma Invoice ▶</label>
                      <div class="col-lg-9 input-group">
                        <input name="dono_flat" type="text" id="dono_flat" class="form-control input-sm">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="" class="col-lg-2 control-label input-sm">No PO ▶</label>
                      <div class="col-lg-9 input-group">
                        <input name="no_po_flat" type="text" id="no_po_flat" class="form-control input-sm">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="" class="col-lg-2 control-label input-sm">Description ▶</label>
                      <div class="col-lg-9 input-group">
                        <textarea name="desc_flat" type="text" id="desc_flat" class="form-control input-sm" rows="3"></textarea>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-5" style="border-right: solid #D2D6DE 1px;">
                    <div class="form-group">
                      <label for="" class="col-lg-2 control-label input-sm">Description 2 ▶</label>
                      <div class="col-lg-9 input-group">
                        <textarea name="desc2_flat" type="text" id="desc2_flat" class="form-control input-sm" rows="2"></textarea>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="" class="col-lg-2 control-label input-xs">No. Item ▶</label>
                      <div class="col-lg-9 input-group">
                        <input name="no_item_flat" type="text" id="no_item_flat" class="form-control input-xs">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="" class="col-lg-2 control-label input-xs">Color ▶</label>
                      <div class="col-lg-9 input-group">
                        <input name="warna_flat" type="text" id="warna_flat" class="form-control input-xs">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="" class="col-lg-2 control-label input-xs">Unit Price ▶</label>
                      <div class="col-lg-9 input-group">
                        <input name="unit_flat" type="text" id="unit_flat" class="form-control input-xs">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="" class="col-lg-2 control-label input-xs">Unit Price ▶</label>
                      <div class="col-lg-9 input-group">
                        <select name="price_by_flat" type="text" id="price_by_flat" class="form-control input-xs">
                          <option value="KGS">KGS</option>
                          <option value="YDS">YDS</option>
                          <option value="PCS">PCS</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-2">
                    <button type="button" id="act_form_flat" class="btn btn-info center-block btn-block text-black"><strong><i class="fa fa-hdd-o" aria-hidden="true"></i>
                        Save Detail</strong></button>
                    <br />
                    <div class="btn-group-vertical center-block">
                      <button id="print_invoice_flat" type="button" class="btn btn-danger"><strong><i class="fa fa-print" aria-hidden="true"></i>
                          Print Detail</strong></button>
                      <button id="exportToExcel_flat" type="button" class="btn btn-success"><strong><i class="fa fa-file-excel-o" aria-hidden="true"></i>
                          Export To Excel</strong></button>
                    </div>
                  </div>
                </form>
              </div>
              <div class="row">
                <div class="container-fluid">
                  <div class="row">
                    <div class="container-fluid" style="border-top: solid #D2D6DE 1px;" id="zona_table_tab2">
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="container">
              <div class="col-lg-12 text-center center-block" style="padding: 10px; border-top: solid #D2D6DE 1px;">
                <button type="button" class="btn btn-danger text-center" data-toggle="tooltip" data-placement="top" title="Click for hide Pop-up" data-dismiss="modal">Close Pop-up</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>

  <!-- ///////////////////////////////////////////// END MODAL COMMERCIAL INVOICE ////////////////////////////////////////////// -->
  <div class="modal fade modal-super-scaled" id="PrntInvoiceDetail" data-backdrop="static" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog" style="width:70%" id="ModalInvoiceDetail">
    </div>
  </div>
  <div class="modal fade modal-super-scaled" id="packing-list" data-backdrop="static" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog" style="width:70%" id="Bodypacking-list">
    </div>
  </div>
  <div class="modal fade modal-super-scaled" id="Edit_packing-list" data-backdrop="static" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog" style="width:70%" id="Edit_Bodypacking-list">
    </div>
  </div>
  <!-- MODAL ACTION PRINT -->
  <div id="PrintCI" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>
  <div id="PrintPL" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>
  <div id="PrintSA" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>
  <div id="PrintSI" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>
  <!-- MODAL ACTION INPUT -->
  <div class="modal fade" id="Modal_tambah_peb" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" id="Body_tambah_peb">
    </div>
  </div>
  <div class="modal fade" id="Modal_tambah_awb" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" id="Body_tambah_awb">
    </div>
  </div>
  <div class="modal fade" id="Modal_pilih_sa" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" id="Body_pilih_sa">
    </div>
  </div>
  <div class="modal fade" id="Modal_tambah_bl" data-backdrop="static">
    <div class="modal-dialog" id="Body_tambah_bl" style="width:80%">
    </div>
  </div>
  <div class="modal fade" id="Modal_tambah_si" data-backdrop="static">
    <div class="modal-dialog" id="Body_tambah_si" style="width:60%">
    </div>
  </div>
  <div class="modal fade" id="Modal_add_sa" data-backdrop="static">
    <div class="modal-dialog" id="Body_add_sa" style="width:60%">
    </div>
  </div>
<?php } ?>
</body>

</html>
<script src="dist/js/ci_extension.js"></script>
<script src="dist/js/ci_extension-tabTwo.js"></script>
<script src="dist/js/ci_extension-tabthree.js"></script>