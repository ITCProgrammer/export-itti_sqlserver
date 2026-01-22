<?php
$ganti = $_POST['template'];
?>
<?php
$sql = "SELECT TOP 1 
    detail_kite.id AS kd,
    detail_kite.sisa,
    detail_kite.grade,
    detail_kite.nokkKite,
    detail_kite.no_roll,
    detail_kite.net_wight,
    detail_kite.yard_,
    detail_kite.satuan,
    tbl_kite.no_warna,
    tbl_kite.warna,
    tbl_kite.no_lot,
    tbl_kite.pelanggan
FROM db_qc.tbl_kite
INNER JOIN db_qc.detail_kite ON db_qc.tbl_kite.nokk = db_qc.detail_kite.nokkKite 
WHERE tbl_kite.no_order = '" . $_GET['bon'] . "'
ORDER BY detail_kite.nokkkite ASC, detail_kite.no_roll ASC";
$data = sqlsrv_query($con, $sql);

$sqlrd = "SELECT TOP 1 *
FROM db_qc.tbl_kite
INNER JOIN db_qc.detail_kite ON db_qc.tbl_kite.nokk = db_qc.detail_kite.nokkKite where tbl_kite.nokk='" . $_GET['kkno'] . "'";

$datard = sqlsrv_query($con, $sqlrd);
$rd2 = sqlsrv_fetch_array($datard, SQLSRV_FETCH_ASSOC);
$slgn = sqlsrv_query($con, "SELECT 
    detail_kite.id AS kd,
    detail_kite.sisa,
    detail_kite.grade,
    detail_kite.nokkKite,
    detail_kite.no_roll,
    detail_kite.net_wight,
    detail_kite.yard_,
    tbl_kite.no_warna,
    tbl_kite.warna,
    tbl_kite.no_lot,
    tbl_kite.pelanggan
FROM db_qc.tbl_kite
INNER JOIN db_qc.detail_kite ON db_qc.tbl_kite.nokk = detail_kite.nokkKite 
WHERE tbl_kite.nokk = '" . $_GET['kkno'] . "'
ORDER BY detail_kite.nokkkite, detail_kite.no_roll ASC;");
$rg = sqlsrv_fetch_array($slgn);
if ($_GET['bon'] != "") {
	$noWhere = " ";
} else {
	$noWhere = " AND tbl_kite.id='' ";
}
?>
<form class="form-horizontal" action="" method="post" enctype="multipart/form-data" name="form1">
	<div class="box box-info">
		<div class="box-header with-border">
			<h3 class="box-title">Data Pas Qty</h3>
			<div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
			</div>
		</div>
		<?php
		$sql11 = sqlsrv_query($con, " SELECT * FROM db_qc.tbl_exim_pim ");
		$r11 = sqlsrv_fetch_array($sql11);

		?>
		<div class="box-body">
			<div class="col-md-6">
				<div class="form-group">
					<label for="nokk" class="col-sm-3 control-label">No Order</label>
					<div class="col-sm-4">
						<input name="order" type="text" id="order" class="form-control" onchange="window.location='index1.php?p=Data-Pas-Qty&amp;order='+this.value" value="<?php echo $_GET['order']; ?>" size="30" />
					</div>
				</div>
				<div class="form-group">
					<label for="nokk" class="col-sm-3 control-label">No KK</label>
					<div class="col-sm-4">
						<?php if ($_GET['order'] == "") { ?>
							<input name="nokk" type="text" id="nokk" class="form-control" onchange="window.location='index1.php?p=Data-Pas-Qty&amp;nokk='+this.value" value="<?php echo $_GET['nokk']; ?>" size="20" />
						<?php } else { ?>
							<select name="nokk" id="nokk" class="form-control select2" onchange="window.location='index1.php?p=Data-Pas-Qty&amp;order=<?php echo $_GET['order']; ?>&amp;nokk='+this.value">
								<option value="">Pilih</option>
								<?php
								$order = str_replace("'", "''", $_GET['order']);
								if ($order != "") {
									$where = " db_qc.tbl_kite.no_order = '" . $_GET['order'] . "' ";
								} else {
									$where = "tbl_kite.id='' ";
								}
								$sqlkk = sqlsrv_query($con, "SELECT trim(nokk) as nokk
FROM db_qc.tbl_kite
WHERE $where GROUP BY nokk");
								while ($rkk = sqlsrv_fetch_array($sqlkk)) { ?>
									<option value="<?php echo $rkk['nokk']; ?>" <?php if ($rkk['nokk'] == $_GET['nokk']) {
																					echo "selected";
																				} ?>><?php echo $rkk['nokk']; ?></option>
								<?php  } ?>

							</select>
						<?php } ?>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="payment" class="col-sm-3 control-label">Templete</label>
					<div class="col-sm-2">
						<select name="template" id="template" class="form-control">
							<option value="1" <?php if ($ganti == "1") {
													echo "SELECTED";
												} ?>>1</option>
							<option value="2" <?php if ($ganti == "2") {
													echo "SELECTED";
												} ?>>2</option>
							<option value="3" <?php if ($ganti == "3") {
													echo "SELECTED";
												} ?>>3</option>
						</select>
					</div>
					<div class="col-sm-2"><input type="submit" name="ganti" id="ganti" value="ganti" class="btn btn-default pull-right" /></div>
				</div>
			</div>


		</div>
		<!-- /.box-footer -->
	</div>
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header with-border">
					<h3 class="box-title">Detail Data</h3>
				</div>
				<div class="box-body">
					<?php if ($_POST['template'] == "" or $_POST['template'] == "1") { ?>
						<?php
						$snkk1 = sqlsrv_query($con, "SELECT count(*) as roll,sum(net_wight) as berat,sum(yard_) as yard FROM db_qc.tbl_tembakqty a 
INNER JOIN db_qc.detail_tembakqty b ON a.id=b.id_kite WHERE nokkkite='" . $_GET['nokk'] . "'");
						$rowkk1 = sqlsrv_fetch_array($snkk1);
						?>
						*<b> Total Roll <?php echo $rowkk1['roll']; ?> ,Total Berat <?php echo number_format($rowkk1['berat'], '2'); ?> Kg, Total Yard <?php echo number_format($rowkk1['yard'], '2'); ?></b><br><br>
						<table id="example5" class="table table-bordered table-hover table-striped" width="100%">
							<thead class="bg-green">
								<tr>
									<th>
										<div align="center">LOT</div>
									</th>
									<th>
										<div align="center">PACK NO</div>
									</th>
									<th>
										<div align="center">BALES NO</div>
									</th>
									<th>
										<div align="center">KGS</div>
									</th>
									<th>
										<div align="center">YDS</div>
									</th>
									<th>
										<div align="center">PCS</div>
									</th>
									<th>
										<div align="center">UKURAN (FLATKNIT)</div>
									</th>
									<th>
										<div align="center">GW</div>
									</th>
									<th>
										<div align="center">KET(EXTRA QTY)</div>
									</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$datacek = sqlsrv_query($con, "SELECT * FROM db_qc.tbl_tembakqty a 
INNER JOIN db_qc.detail_tembakqty b ON a.id=b.id_kite WHERE  nokkkite='" . $_GET['nokk'] . "' ORDER BY no_roll ASC");
								$no = 1;
								$n = 1;
								$c = 0;
								while ($rowd = sqlsrv_fetch_array($datacek)) {

									$bgcolor = ($c++ & 1) ? '#33CCFF' : '#FFCC99';
									if ($rowd['jns_pack'] == "Rolls") {
										$gw = 0.6;
									} else {
										$gw = 0.2;
									}
								?>
									<tr>
										<td align="center"><?PHP echo $rowd['no_lot']; ?></td>
										<td align="center"><?PHP if ($rowd['jns_pack'] == "Rolls") {
																echo $rowd['no_roll'];
															} else {
																echo "-";
															} ?></td>
										<td align="center"><?PHP if ($rowd['jns_pack'] == "Bales") {
																echo $rowd['no_roll'];
															} else {
																echo "-";
															} ?></td>
										<td align="right"><?PHP echo number_format($rowd['net_wight'], '2', '.', ','); ?></td>
										<td align="right"><?PHP echo number_format($rowd['yard_'], '2', '.', ','); ?></td>
										<td align="center"><?PHP if ($rowd['netto'] == "") {
																echo "-";
															} else {
																echo $rowd['netto'];
															} ?></td>
										<td align="center"><?PHP if ($rowd['ukuran'] == "") {
																echo "-";
															} else {
																echo $rowd['ukuran'] . "CM";
															} ?></td>
										<td align="right"><?PHP if ($rowd['net_wight'] == "") {
																echo "-";
															} else {
																echo number_format($rowd['net_wight'] + $gw, '2', '.', ',');
															} ?></td>
										<td align="right"><?PHP
															if ($rowd['sisa'] == "FOC") {
																echo $rowd['sisa'];
															} else {
																echo "-";
															} ?></td>
									</tr>

								<?php
									$totkgs = $totkgs + $rowd['net_wight'];
									$totyds = $totyds + $rowd['yard_'];
									$no++;
								} ?>
							</tbody>
							<tfoot>
								<tr>
									<td align="center"><strong>Total</strong></td>
									<td align="center"><b><?php echo $no - 1; ?> Roll</b></td>
									<td align="right">&nbsp;</td>
									<td align="right"><b><?php echo number_format($totkgs, '2'); ?> Kgs</b></td>
									<td align="right"><b><?php echo number_format($totyds, '2'); ?> Yds</b></td>
									<td align="center">&nbsp;</td>
									<td align="center">&nbsp;</td>
									<td align="center">&nbsp;</td>
									<td align="center">&nbsp;</td>
								</tr>
								<tfoot>
						</table>
					<?php } else if ($_POST['template'] == "2") { ?>
						<?php
						$snkk1 = sqlsrv_query($con, "SELECT 
							COUNT(*) AS roll,
							SUM(b.net_wight) AS berat,
							SUM(b.yard_) AS yard 
						FROM db_qc.tbl_tembakqty a 
						INNER JOIN db_qc.detail_tembakqty b ON a.id = b.id_kite 
						WHERE a.nokk = '" . $_GET['nokk'] . "'");
						$rowkk1 = sqlsrv_fetch_array($snkk1, SQLSRV_FETCH_ASSOC);
						?>
						*<b> Total Roll <?php echo $rowkk1['roll']; ?> ,Total Berat <?php echo number_format($rowkk1['berat'], '2'); ?> Kg, Total Yard <?php echo number_format($rowkk1['yard'], '2'); ?></b><br><br>
						<table id="example5" class="table table-bordered table-hover table-striped" width="100%">
							<thead class="bg-purple">
								<tr>
									<th>
										<div align="center">LOT NO.</div>
									</th>
									<th>
										<div align="center">C/No</div>
									</th>
									<th>
										<div align="center">Qty</div>
									</th>
									<th>
										<div align="center">FOC</div>
									</th>
									<th>
										<div align="center">Yard</div>
									</th>
									<th>
										<div align="center">WeiKg</div>
									</th>
									<th>
										<div align="center">Meter</div>
									</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$datacek = sqlsrv_query($con, "SELECT * FROM db_qc.tbl_tembakqty a 
								INNER JOIN db_qc.detail_tembakqty b ON a.id=b.id_kite WHERE  nokkkite='" . $_GET['nokk'] . "' ORDER BY no_roll ASC");
								$no = 1;
								$n = 1;
								$c = 0;
								while ($rowd = sqlsrv_fetch_array($datacek)) {

									$bgcolor = ($c++ & 1) ? '#33CCFF' : '#FFCC99';
									if ($rowd['jns_pack'] == "Rolls") {
										$gw = 0.6;
									} else {
										$gw = 0.2;
									}
								?>
									<tr>
										<td align="center"><?PHP echo $rowd['no_lot']; ?></td>
										<td align="center"><?PHP if ($rowd['jns_pack'] == "Rolls") {
																echo $rowd['no_roll'];
															} else {
																echo "-";
															} ?></td>
										<td align="right"><?PHP echo number_format($rowd['net_wight'], '2', '.', ','); ?></td>
										<td align="right"><?PHP
															if ($rowd['sisa'] == "FOC") {
																echo $rowd['sisa'];
															} else {
																echo "-";
															} ?></td>
										<td align="right"><?PHP echo number_format($rowd['yard_'], '2', '.', ','); ?></td>
										<td align="right"><?PHP if ($rowd['net_wight'] == "") {
																echo "-";
															} else {
																echo number_format($rowd['net_wight'] + $gw, '2', '.', ',');
															} ?></td>
										<td align="right"><?PHP echo number_format($rowd['yard_'] * 0.9144, '2', '.', ','); ?></td>
									</tr>

								<?php
									$totkgs = $totkgs + $rowd['net_wight'];
									$totyds = $totyds + $rowd['yard_'];
									$no++;
								} ?>
							</tbody>
							<tfoot>
								<tr>
									<td align="center"><strong>Total</strong></td>
									<td align="center"><b><?php echo $no - 1; ?> Roll</b></td>
									<td align="right"><b><?php echo number_format($totkgs, '2'); ?> Kgs</b></td>
									<td align="center">&nbsp;</td>
									<td align="right"><b><?php echo number_format($totyds, '2'); ?> Yds</b></td>
									<td align="center">&nbsp;</td>
									<td align="center">&nbsp;</td>
								</tr>
							</tfoot>
						</table>
					<?php } else if ($_POST['template'] == "3") { ?>
						<?php
						$snkk1 = sqlsrv_query($con, "SELECT count(*) as roll,sum(net_wight) as berat,sum(yard_) as yard FROM db_qc.tbl_tembakqty a 
INNER JOIN db_qc.detail_tembakqty b ON a.id=b.id_kite WHERE nokkkite='" . $_GET['nokk'] . "'");
						$rowkk1 = sqlsrv_fetch_array($snkk1);
						?>
						*<b> Total Roll <?php echo $rowkk1['roll']; ?> ,Total Berat <?php echo number_format($rowkk1['berat'], '2'); ?> Kg, Total Yard <?php echo number_format($rowkk1['yard'], '2'); ?></b><br><br>
						<table id="example5" class="table table-bordered table-hover table-striped" width="100%">
							<thead class="bg-red">
								<tr>
									<th>
										<div align="center">LOT</div>
									</th>
									<th>
										<div align="center">PACK NO</div>
									</th>
									<th>
										<div align="center">BALES NO</div>
									</th>
									<th>
										<div align="center">KGS</div>
									</th>
									<th>
										<div align="center">YDS</div>
									</th>
									<th>
										<div align="center">METER</div>
									</th>
									<th>
										<div align="center">UKURAN (FLATKNIT)</div>
									</th>
									<th>
										<div align="center">GW</div>
									</th>
									<th>
										<div align="center">KET(EXTRA QTY)</div>
									</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$datacek = sqlsrv_query($con, "SELECT * FROM db_qc.tbl_tembakqty a 
INNER JOIN db_qc.detail_tembakqty b ON a.id=b.id_kite WHERE  nokkkite='" . $_GET['nokk'] . "' ORDER BY no_roll ASC");
								$no = 1;
								$n = 1;
								$c = 0;
								while ($rowd = sqlsrv_fetch_array($datacek)) {

									$bgcolor = ($c++ & 1) ? '#33CCFF' : '#FFCC99';
									if ($rowd['jns_pack'] == "Rolls") {
										$gw = 0.6;
									} else {
										$gw = 0.2;
									}
								?>

									<tr>
										<td align="center"><?PHP echo $rowd['no_lot']; ?></td>
										<td align="center"><?PHP if ($rowd['jns_pack'] == "Rolls") {
																echo $rowd['no_roll'];
															} else {
																echo "-";
															} ?></td>
										<td align="center"><?PHP if ($rowd['jns_pack'] == "Bales") {
																echo $rowd['no_roll'];
															} else {
																echo "-";
															} ?></td>
										<td align="right"><?PHP echo number_format($rowd['net_wight'], '2', '.', ','); ?></td>
										<td align="right"><?PHP echo number_format($rowd['yard_'], '2', '.', ','); ?></td>
										<td align="right"><?PHP echo number_format($rowd['yard_'] * 0.9144, '2', '.', ','); ?></td>
										<td align="center"><?PHP if ($rowd['ukuran'] == "") {
																echo "-";
															} else {
																echo $rowd['ukuran'] . "CM";
															} ?></td>
										<td align="right"><?PHP if ($rowd['net_wight'] == "") {
																echo "-";
															} else {
																echo number_format($rowd['net_wight'] + $gw, '2', '.', ',');
															} ?></td>
										<td align="right"><?PHP
															if ($rowd['sisa'] == "FOC") {
																echo $rowd['sisa'];
															} else {
																echo "-";
															} ?></td>
									</tr>

								<?php
									$totkgs = $totkgs + $rowd['net_wight'];
									$totyds = $totyds + $rowd['yard_'];
									$no++;
								} ?>
							</tbody>
							<tfoot>
								<tr>
									<td align="center"><strong>Total</strong></td>
									<td align="center"><b><?php echo $no - 1; ?> Roll</b></td>
									<td align="right">&nbsp;</td>
									<td align="right"><b><?php echo number_format($totkgs, '2'); ?> Kgs</b></td>
									<td align="right"><b><?php echo number_format($totyds, '2'); ?> Yds</b></td>
									<td align="center">&nbsp;</td>
									<td align="center">&nbsp;</td>
									<td align="center">&nbsp;</td>
									<td align="center">&nbsp;</td>
								</tr>
							</tfoot>
						</table>
					<?php } ?>

					<div id="PeriksaEdit" class="modal fade modal-3d-slit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

					</div>

				</div>
			</div>
		</div>
	</div>
</form>
<!-- Modal Popup untuk delete-->
<div class="modal fade" id="delJadwal" tabindex="-1">
	<div class="modal-dialog modal-sm">
		<div class="modal-content" style="margin-top:100px;">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" style="text-align:center;">Are you sure to delete this information ?</h4>
			</div>

			<div class="modal-footer" style="margin:0px; border-top:0px; text-align:center;">
				<a href="#" class="btn btn-danger" id="delJadwal_link">Delete</a>
				<button type="button" class="btn btn-success" data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>
<?php
// $qry4 = sqlsrv_query($conn, "
// 	SELECT
// 	jo.DocumentNo,
// 	so.PONumber,
//     SODA.PONumber as POADD,	
// 	ISNULL(pmp.ProductCode,pm.hangerno) AS ProductCode,
// 	pm.Color,
// 	pm.ColorNo,
// 	SOD.UnitPrice,
// 	UD.UnitName,
// 	so.SONumber,
// 	SOD.Weight,
// 	SOD.QuantityToOrder
// FROM
// 	SODetails SOD
// LEFT JOIN db_qc.SalesOrders so ON SOD.SOID = so.ID
// LEFT JOIN db_qc.SODetailsAdditional SODA ON SODA.SODID=SOD.ID
// LEFT JOIN db_qc.UnitDescription UD ON UD.id = SOD.UnitID
// LEFT JOIN db_qc.JobOrders jo ON jo.SOID = so.ID
// LEFT JOIN db_qc.Partners p ON p.ID = so.CustomerID
// LEFT JOIN db_qc.ProductMaster pm ON pm.ID = SOD.ProductID
// LEFT JOIN db_qc.ProductPartner pmp ON sod.ProductID = pmp.ProductID
// AND so.BuyerID = pmp.PartnerID
// WHERE
// 	so.SONumber LIKE '" . $_GET['pi'] . "'
// ORDER BY
// 	SOD.ID ASC"); 
?>
<?php

if (isset($_POST['save'])) {
	$qry1 = sqlsrv_query($con, "INSERT INTO db_qc.tbl_exim_pim SET
		no_pi='" . $_POST['no_pi'] . "',
		bon_order='" . $_POST['bon_order'] . "',
		buyer='" . $_POST['buyer'] . "',
		messr='" . $_POST['messr'] . "',
		consignee='" . $_POST['consignee'] . "',
		destination='" . $_POST['dest'] . "',
		payment='" . $_POST['payment'] . "',
		incoterm='" . $_POST['incoterm'] . "',
		sales_assistant='" . $_POST['sales'] . "',
		delivery='" . $_POST['tgl_delivery'] . "',
		author='" . $_POST['author'] . "',
		tgl_terima='" . $_POST['tgl_terima'] . "',
		tgl_update=now()
		");
	$cekPI = sqlsrv_query($con, "SELECT id FROM db_qc.tbl_exim_pim WHERE no_pi='" . $_POST['no_pi'] . "' ORDER BY id DESC ");
	$rcekPI = sqlsrv_fetch_array($cekPI);

	$po = "";
	$per = "";
	$kg = "0";
	$yd = "0";
	$pc = "0";
	while ($r1 = sqlsrv_fetch_array($qry4, SQLSRV_FETCH_ASSOC)) {
		if ($r1['POADD'] == "") {
			$po = str_replace("'", "''", $r1['PONumber']);
		} else {
			$po = str_replace("'", "''", $r1['POADD']);
		}
		$sqlHS1 = sqlsrv_query($con, "SELECT hs_code FROM db_qc.tbl_exim_code WHERE no_item='" . $r1['ProductCode'] . "' LIMIT 1");
		$rHS1 = sqlsrv_fetch_array($sqlHS1);
		if ($r1['UnitName'] == "yard") {
			$per = "yd";
		} elseif ($r1['UnitName'] == "kg") {
			$per = "kg";
		} elseif ($r1['UnitName'] == "pc") {
			$per = "pc";
		}
		if ($r1['UnitName'] == "kg") {
			$kg = $r1['QuantityToOrder'];
		} else {
			$kg = round($r1['Weight']);
		}
		if ($r1['UnitName'] == "yard") {
			$yd = $r1['QuantityToOrder'];
		}
		$qry1 = sqlsrv_query($con, "INSERT INTO db_qc.tbl_exim_pim_detail SET
		id_pi='" . $rcekPI['id'] . "',
		po='$po',
		item='" . $r1['ProductCode'] . "',
		color='" . $r1['Color'] . "',
		hs_code='" . $rHS1['hs_code'] . "',
		price='" . $r1['UnitPrice'] . "',
		per='$per',
		kg='$kg',
		yd='$yd',
		pcs='$pc'
		");
	}
	if ($qry1) {
		//echo "<script>alert('Data Tersimpan');</script>";
		//echo "<script>window.location.href='?p=Form-Pemeriksaan&no_mesin=$_GET[no_mesin]';</script>";
		echo "<script>swal({
  title: 'Data Tersimpan',
  text: 'Klik Ok untuk melanjutkan',
  type: 'success',
  }).then((result) => {
  if (result.value) {
    window.location.href='?p=Proforma-Invoice-Manual';
  }
});</script>";
	} else {
		echo "There's been a problem: " . mysql_error();
	}
}

?>
<script type="text/javascript">
	function confirm_del_jdwl(delete_url) {
		$('#delJadwal').modal('show', {
			backdrop: 'static'
		});
		document.getElementById('delJadwal_link').setAttribute('href', delete_url);
	}
</script>