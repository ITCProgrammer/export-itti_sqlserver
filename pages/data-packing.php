<?php
$ganti = $_POST['template'];
// $qryKK=sqlsrv_query($conn,"select ID,DocumentNo from db_qc.ProcessControlBatches where DocumentNo='".$_GET['lot']."'");
// $rKK=sqlsrv_fetch_array($qryKK,SQLSRV_FETCH_ASSOC);
// $qryPos=sqlsrv_query($conn,"select TOP 1 p.*,d.DepartmentName from db_qc.PCCardPosition p left join
// Departments d on d.ID=p.DepartmentID
// where p.PCBID='".$rKK['ID']."' and status='1' order by p.Dated DESC");
// $rPos=sqlsrv_fetch_array($qryPos,SQLSRV_FETCH_ASSOC);
// $dtNote = $rPos['DepartmentName'];
?>
<?php
$sql = "SELECT DISTINCT
    d.id AS kd, d.sisa, d.grade, d.nokkKite, d.no_roll, 
    d.net_wight, d.yard_, d.satuan, t.no_warna, 
    t.warna, t.no_lot, t.pelanggan
FROM db_qc.tbl_kite t
INNER JOIN db_qc.detail_kite d ON t.nokk = d.nokkKite 
WHERE t.no_order = '" . $_GET['bon'] . "'
ORDER BY d.nokkKite ASC, d.no_roll ASC;";
$data = sqlsrv_query($con, $sql);
$sqlrd = "SELECT TOP 1 *
FROM db_qc.tbl_kite
INNER JOIN db_qc.detail_kite ON tbl_kite.nokk = detail_kite.nokkKite where  tbl_kite.nokk='" . $_GET['kkno'] . "' ";
$datard = sqlsrv_query($con, $sqlrd);
$rd2 = sqlsrv_fetch_array($datard);
$slgn = sqlsrv_query($con, "SELECT DISTINCT 
    d.id AS kd,
    d.sisa,
    d.grade,
    d.nokkKite,
    d.no_roll,
    d.net_wight, 
    d.yard_, 
    t.no_warna,
    t.warna,
    t.no_lot,
    t.pelanggan
FROM db_qc.tbl_kite t
INNER JOIN db_qc.detail_kite d ON t.nokk = d.nokkKite 
WHERE t.nokk = '" . $_GET['kkno'] . "'
ORDER BY d.nokkKite ASC, d.no_roll ASC ");
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
			<h3 class="box-title">Data Packing</h3>
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
					<label for="bon" class="col-sm-3 control-label">Bon Order</label>
					<div class="col-sm-4">
						<input name="bon" type="text" id="bon" class="form-control" onchange="window.location='index1.php?p=Data-Packing&amp;bon='+this.value" value="<?php echo $_GET['bon']; ?>" size="20" />
					</div>
				</div>

				<div class="form-group">
					<label for="byer" class="col-sm-3 control-label">Buyer</label>
					<div class="col-sm-6">
						<select name="byer" id="byer" class="form-control" onchange="window.location='index1.php?p=Data-Packing&amp;bon=<?php echo $_GET['bon']; ?>&amp;byer='+this.value">
							<option value="">PILIH</option>
							<?php
							$byr = str_replace("'", "''", $_GET['byer']);
							$sqllanggan = sqlsrv_query($con, "SELECT trim(pelanggan) as langgan
							FROM db_qc.tbl_kite
							WHERE tbl_kite.no_order = '" . $_GET['bon'] . "' $noWhere 
							GROUP BY pelanggan");
							while ($rp = sqlsrv_fetch_array($sqllanggan)) { ?>
								<option value="<?php echo urlencode($rp['langgan']); ?>" <?php if ($rp['langgan'] == $_GET['byer']) {
																								echo "selected";
																							} ?>><?php echo $rp['langgan']; ?></option>
							<?php  } ?>

						</select>
					</div>
				</div>
				<div class="form-group">
					<label for="nopo" class="col-sm-3 control-label">PO No.</label>
					<div class="col-sm-5">
						<select name="nopo" class="form-control" onchange="window.location='index1.php?p=Data-Packing&amp;bon=<?php echo $_GET['bon']; ?>&amp;byer=<?php echo $byr; ?>&amp;nopo='+this.value">
							<option value="">PILIH</option>
							<?php
							$sqlnopo = sqlsrv_query($con, "SELECT DISTINCT 
								TRIM(no_po) AS no_po, 
								nokk
							FROM db_qc.tbl_kite
							WHERE no_order = '" . $_GET['bon'] . "'
							AND tbl_kite.pelanggan like '%$byr%' $noWhere;");
							while ($rp = sqlsrv_fetch_array($sqlnopo)) { ?>
								<option value="<?php echo urlencode($rp['no_po']); ?>" <?php if ($rp['no_po'] == $_GET['nopo']) {
																							echo "selected";
																						} ?>><?php echo $rp['no_po']; ?></option>
							<?php  } ?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label for="itm" class="col-sm-3 control-label">Item</label>
					<div class="col-sm-5">
						<select name="itm" id="itm" class="form-control" onchange="window.location='index1.php?p=Data-Packing&amp;bon=<?php echo $_GET['bon']; ?>&amp;byer=<?php echo $byr; ?>&amp;nopo=<?php echo urlencode($_GET['nopo']); ?>&amp;itm='+this.value">
							<option value="">PILIH</option>
							<?php
							$sqlitm = sqlsrv_query($con, "SELECT trim(no_item) as itm
							FROM db_qc.tbl_kite
							WHERE tbl_kite.no_order = '" . $_GET['bon'] . "' AND tbl_kite.pelanggan like '%$byr%' AND tbl_kite.no_po like '%" . $_GET['nopo'] . "%' $noWhere 
							GROUP BY no_item");
							while ($rp = sqlsrv_fetch_array($sqlitm)) { ?>
								<option value="<?php echo $rp['itm']; ?>" <?php if ($rp['itm'] == $_GET['itm']) {
																				echo "selected";
																			} ?>><?php echo $rp['itm']; ?></option>
							<?php  } ?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label for="warna" class="col-sm-3 control-label">Warna</label>
					<div class="col-sm-6">
						<select name="warna" id="warna" class="form-control" onchange="window.location='index1.php?p=Data-Packing&amp;bon=<?php echo $_GET['bon']; ?>&amp;byer=<?php echo $_GET['byer']; ?>&amp;nopo=<?php echo urlencode($_GET['nopo']); ?>&amp;itm=<?php echo $_GET['itm']; ?>&amp;wrn='+this.value">
							<option value="">PILIH</option>
							<?php
							$sqlwrn = sqlsrv_query($con, "SELECT trim(warna) as wrn
							FROM db_qc.tbl_kite
							WHERE tbl_kite.no_order = '" . $_GET['bon'] . "' AND tbl_kite.pelanggan like '%$byr%' 
							AND tbl_kite.no_po like '%" . $_GET['nopo'] . "%' AND tbl_kite.no_item like '%" . $_GET['itm'] . "%' $noWhere
							GROUP BY warna");
							while ($rp = sqlsrv_fetch_array($sqlwrn)) { ?>
								<option value="<?php echo $rp['wrn']; ?>" <?php if ($rp['wrn'] == $_GET['wrn']) {
																				echo "selected";
																			} ?>><?php echo $rp['wrn']; ?></option>
							<?php  } ?>
						</select>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="lot" class="col-sm-3 control-label">Lot</label>
					<div class="col-sm-3">
						<select name="lot" id="lot" class="form-control" onchange="window.location='index1.php?p=Data-Packing&amp;bon=<?php echo $_GET['bon']; ?>&amp;byer=<?php echo $_GET['byer']; ?>&amp;nopo=<?php echo urlencode($_GET['nopo']); ?>&amp;itm=<?php echo $_GET['itm']; ?>&amp;wrn=<?php echo $_GET['wrn']; ?>&amp;lot='+this.value">
							<option value="">PILIH</option>
							<?php
							$sqllot = sqlsrv_query($con, " SELECT trim(no_lot) as lot,nokk
							FROM db_qc.tbl_kite
							WHERE tbl_kite.no_order = '" . $_GET['bon'] . "' AND tbl_kite.pelanggan = '$byr' 
							AND tbl_kite.no_po = '" . $_GET['nopo'] . "' AND tbl_kite.no_item = '" . $_GET['itm'] . "' AND tbl_kite.warna = '" . $_GET['wrn'] . "' $noWhere 
							ORDER BY no_lot ASC");
							while ($rp = sqlsrv_fetch_array($sqllot)) { ?>
								<option value="<?php echo $rp['nokk']; ?>" <?php if ($rp['nokk'] == $_GET['lot']) {
																				echo "selected";
																			} ?>><?php echo $rp['lot']; ?></option>
							<?php  } ?>
						</select>
					</div>
					<div class="col-sm-6">
						Posisi: <?php if ($dtNote == "KK Oke") {
									echo "<span class='label label-success'>" . $dtNote . "</span><br>";
								} else {
									echo "<span class='label label-danger'>" . $dtNote . "</span><br>";
								}
								if ($_GET['lot'] != "") {
									$qryckk = sqlsrv_query($con, "SELECT
										COUNT(b.sn) AS rol,
										SUM(b.weight) AS kg,
										CASE 
											WHEN a.typestatus = '2' THEN 'kain masuk' 
											ELSE 'kain keluar' 
										END AS ket,
										CONVERT(VARCHAR, a.tgl_update, 105) AS tgl 
									FROM
										db_qc.pergerakan_stok a
										INNER JOIN db_qc.detail_pergerakan_stok b ON a.id = b.id_stok 
									WHERE
										a.typestatus IN ('2', '3') 
										AND b.nokk = '" . $_GET['lot'] . "' 
									GROUP BY 
										a.id, 
										a.typestatus, 
										a.tgl_update");
									while ($rckk = sqlsrv_fetch_array($qryckk)) {
										if ($rckk['ket'] == "kain masuk") {
											$wrn1 = "label-primary";
										} else {
											$wrn1 = "label-danger";
										}
										echo "<span class='label $wrn1'>" . $rckk['ket'] . ": " . $rckk['rol'] . " Rol " . $rckk['kg'] . " kgs tgl: " . $rckk['tgl'] . "</span><br>";
									}
								}
								?>
					</div>
				</div>
				<?php
				$sqlpack = sqlsrv_query($con, "SELECT DISTINCT trim(no_mc) as no_mc, nokk
				FROM db_qc.tbl_kite
				WHERE tbl_kite.no_order = '" . $_GET['bon'] . "' 
				AND tbl_kite.pelanggan = '$byr' 
				AND tbl_kite.no_po like '%" . $_GET['nopo'] . "%' AND tbl_kite.no_item = '" . $_GET['itm'] . "' AND tbl_kite.warna = '" . $_GET['wrn'] . "' AND tbl_kite.nokk = '" . $_GET['lot'] . "' ");
				$pk = sqlsrv_fetch_array($sqlpack);
				//$sqltmpt=sqlsrv_query($con,"SELECT tempat from mutasi_kain where nokk='$pk[nokk]'");
				$sqltmpt = sqlsrv_query($con, "SELECT 
					STRING_AGG(lokasi, ', ') AS tempat
				FROM (
					SELECT DISTINCT lokasi 
					FROM db_qc.detail_pergerakan_stok 
					WHERE status = '1' AND nokk = '" . $pk['nokk'] . "'
				) AS sub");
				$tmpt = sqlsrv_fetch_array($sqltmpt);
				?>
				<div class="form-group">
					<label for="packing" class="col-sm-3 control-label">Packing</label>
					<div class="col-sm-2">
						<select name="packing" id="packing" class="form-control" onchange="window.location='index1.php?p=Data-Packing&amp;bon=<?php echo $_GET['bon']; ?>&amp;byer=<?php echo $_GET['byer']; ?>&amp;nopo=<?php echo urlencode($_GET['nopo']); ?>&amp;itm=<?php echo $_GET['itm']; ?>&amp;wrn=<?php echo $_GET['wrn']; ?>&amp;lot=<?php echo $_GET['lot']; ?>&amp;pk='+this.value">
							<option value="">PILIH</option>
							<option value="Rolls" <?php if ($_GET['pk'] == "Rolls") {
														echo "SELECTED";
													} ?>>Rolls</option>
							<option value="Bales" <?php if ($_GET['pk'] == "Bales") {
														echo "SELECTED";
													} ?>>Bales</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label for="gudang" class="col-sm-3 control-label">Gudang</label>
					<div class="col-sm-4">
						<input name="gudang" type="text" class="form-control" id="gudang" value="<?php echo $tmpt['tempat']; ?>" placeholder="Tempat">
					</div>
				</div>
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
						$snkk1 = sqlsrv_query($con, "SELECT
							count(b.weight) as roll,
							sum(b.weight) as berat,sum(b.yard_) as yard
						FROM
							db_qc.pergerakan_stok a 
						LEFT JOIN db_qc.detail_pergerakan_stok b ON a.id = b.id_stok
						LEFT JOIN db_qc.tbl_kite c ON b.nokk = c.nokk
						WHERE
							b.sisa !='FKTH' AND b.sisa !='TH' AND b.sisa !='FOC' AND a.typestatus='2'
						AND c.nokk='" . $pk['nokk'] . "'");
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
								$datacek = sqlsrv_query($con, "SELECT DISTINCT
									a.*, 
									b.id AS kd, 
									b.no_roll AS rolno,
									c.nokk -- Ditambahkan agar ORDER BY berfungsi
								FROM db_qc.pergerakan_stok a
								INNER JOIN db_qc.detail_pergerakan_stok b ON a.id = b.id_stok
								INNER JOIN db_qc.tmp_detail_kite d ON d.id = b.id_detail_kj
								INNER JOIN db_qc.tbl_kite c ON d.id_kite = c.id
								WHERE 
									b.sisa NOT IN ('FKTH', 'TH')
									AND a.typestatus = '2'
									AND b.nokk = '" . $pk['nokk'] . "'
									AND d.nokkKite <> ''
								ORDER BY 
									c.nokk,
									b.no_roll ASC");
								$no = 1;
								$n = 1;
								$c = 0;
								while ($rowd = sqlsrv_fetch_array($datacek)) {

									$bgcolor = ($c++ & 1) ? '#33CCFF' : '#FFCC99';
									if ($_GET['pk'] == "Rolls") {
										$gw = 0.6;
									} else {
										$gw = 0.2;
									}
								?>

									<tr>
										<td align="center"><?PHP echo $rowd['no_lot']; ?></td>
										<td align="center"><?PHP if ($_GET['pk'] == "Rolls") {
																echo $rowd['rolno'];
															} else {
																echo "-";
															} ?></td>
										<td align="center"><?PHP if ($_GET['pk'] == "Bales") {
																echo $rowd['rolno'];
															} else {
																echo "-";
															} ?></td>
										<td align="right"><?PHP echo number_format($rowd['weight'], '2', '.', ','); ?></td>
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
										<td align="right"><?PHP if ($rowd['weight'] == "") {
																echo "-";
															} else {
																echo number_format($rowd['weight'] + $gw, '2', '.', ',');
															} ?></td>
										<td align="right"><?PHP
															if ($rowd['sisa'] == "FOC") {
																echo $rowd['sisa'];
															} elseif ($rowd['sisa'] == "SISA" or $rowd['sisa'] == "FKSI") {
																echo "SISA";
															} elseif ($rowd['sisa'] == "BS") {
																echo "BS";
															} else {
																echo "-";
															} ?></td>
									</tr>

								<?php
									if ($rowd['sisa'] == "SISA" or $rowd['sisa'] == "FKSI" or $rowd['sisa'] == "FOC") {
										$kgs = "0";
										$yds = "0";
									} else {
										$kgs = $rowd['weight'];
										$yds = $rowd['yard_'];
									}
									$totkgs = $totkgs + $kgs;
									$totyds = $totyds + $yds;
									if ($rowd['sisa'] == "SISA" or $rowd['sisa'] == "FKSI") {
										$rol = "0";
									} else {
										$rol = "1";
									}
									$trol = $trol + $rol;
									$no++;
								} ?>
							</tbody>
							<tfoot>
								<tr>
									<td align="center"><strong>Total</strong></td>
									<td align="center"><b><?php echo $trol; ?> Roll</b></td>
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
							count(b.weight) as roll,
							sum(b.weight) as berat,sum(b.yard_) as yard
						FROM
							db_qc.pergerakan_stok a 
						LEFT JOIN db_qc.detail_pergerakan_stok b ON a.id = b.id_stok
						LEFT JOIN db_qc.tbl_kite c ON b.nokk = c.nokk
						WHERE
							b.sisa !='FKTH' AND b.sisa !='TH' AND b.sisa !='FOC' AND a.typestatus='2'
						AND c.nokk='" . $pk['nokk'] . "' ");
						$rowkk1 = sqlsrv_fetch_array($snkk1);
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
								$datacek = sqlsrv_query($con, "SELECT DISTINCT
									a.id AS id_pergerakan,
									a.typestatus,
									a.tgl_update,
									b.id AS kd, 
									b.no_roll AS rolno,
									b.sisa,
									b.nokk,
									c.nokk AS nokk_kite,
									d.nokkKite AS nokk_detail_kite
								FROM db_qc.pergerakan_stok a
								INNER JOIN db_qc.detail_pergerakan_stok b ON a.id = b.id_stok
								INNER JOIN db_qc.tmp_detail_kite d ON d.id = b.id_detail_kj
								INNER JOIN db_qc.tbl_kite c ON d.id_kite = c.id
								WHERE 
									b.sisa NOT IN ('FKTH', 'TH')
									AND a.typestatus = '2'
									AND b.nokk = '" . $pk['nokk'] . "'
									AND d.nokkKite <> ''
								ORDER BY 
									c.nokk,
									b.no_roll ASC");
								$no = 1;
								$n = 1;
								$c = 0;
								while ($rowd = sqlsrv_fetch_array($datacek)) {

									$bgcolor = ($c++ & 1) ? '#33CCFF' : '#FFCC99';
									if ($_GET['pk'] == "Rolls") {
										$gw = 0.6;
									} else {
										$gw = 0.2;
									}
								?>

									<tr>
										<td align="center"><?PHP echo $rowd['no_lot']; ?></td>
										<td align="center"><?PHP if ($_GET['pk'] == "Rolls") {
																echo $rowd['rolno'];
															} else {
																echo "-";
															} ?></td>
										<td align="right"><?PHP echo number_format($rowd['weight'], '2', '.', ','); ?></td>
										<td align="right"><?PHP
															if ($rowd['sisa'] == "FOC") {
																echo $rowd['sisa'];
															} elseif ($rowd['sisa'] == "SISA" or $rowd['sisa'] == "FKSI") {
																echo "SISA";
															} elseif ($rowd['sisa'] == "BS") {
																echo "BS";
															} else {
																echo "-";
															} ?></td>
										<td align="right"><?PHP echo number_format($rowd['yard_'], '2', '.', ','); ?></td>
										<td align="right"><?PHP if ($rowd['weight'] == "") {
																echo "-";
															} else {
																echo number_format($rowd['weight'] + $gw, '2', '.', ',');
															} ?></td>
										<td align="right"><?PHP echo number_format($rowd['yard_'] * 0.9144, '2', '.', ','); ?></td>
									</tr>

								<?php
									if ($rowd['sisa'] == "SISA" or $rowd['sisa'] == "FKSI" or $rowd['sisa'] == "FOC") {
										$kgs = "0";
										$yds = "0";
									} else {
										$kgs = $rowd['weight'];
										$yds = $rowd['yard_'];
									}
									$totkgs = $totkgs + $kgs;
									$totyds = $totyds + $yds;
									if ($rowd['sisa'] == "SISA" or $rowd['sisa'] == "FKSI") {
										$rol = "0";
									} else {
										$rol = "1";
									}
									$trol = $trol + $rol;
									$no++;
								} ?>
							</tbody>
							<tfoot>
								<tr>
									<td align="center"><strong>Total</strong></td>
									<td align="center"><b><?php echo $trol; ?> Roll</b></td>
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
						$snkk1 = sqlsrv_query($con, "SELECT
							count(b.weight) as roll,
							sum(b.weight) as berat,sum(b.yard_) as yard
						FROM
							db_qc.pergerakan_stok a 
						LEFT JOIN db_qc.detail_pergerakan_stok b ON a.id = b.id_stok
						LEFT JOIN db_qc.tbl_kite c ON b.nokk = c.nokk
						WHERE
							b.sisa !='FKTH' AND b.sisa !='TH' AND b.sisa !='FOC' AND a.typestatus='2'
						AND c.nokk='" . $pk['nokk'] . "'");
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
								$datacek = sqlsrv_query($con, "SELECT DISTINCT
									b.id AS kd, 
									b.no_roll AS rolno,
									a.typestatus,
									a.tgl_update,
									b.nokk,
									b.sisa,
									c.nokk AS nokk_kite,
									d.nokkKite
								FROM db_qc.pergerakan_stok a
								INNER JOIN db_qc.detail_pergerakan_stok b ON a.id = b.id_stok
								INNER JOIN db_qc.tmp_detail_kite d ON d.id = b.id_detail_kj
								INNER JOIN db_qc.tbl_kite c ON d.id_kite = c.id
								WHERE 
									b.sisa NOT IN ('FKTH', 'TH')
									AND a.typestatus = '2'
									AND b.nokk = '" . $pk['nokk'] . "'
									AND d.nokkKite <> ''
								ORDER BY 
									c.nokk,
									b.no_roll ASC;");
								$no = 1;
								$n = 1;
								$c = 0;
								while ($rowd = sqlsrv_fetch_array($datacek)) {

									$bgcolor = ($c++ & 1) ? '#33CCFF' : '#FFCC99';
									if ($_GET['pk'] == "Rolls") {
										$gw = 0.6;
									} else {
										$gw = 0.2;
									}
								?>

									<tr>
										<td align="center"><?PHP echo $rowd['no_lot']; ?></td>
										<td align="center"><?PHP if ($_GET['pk'] == "Rolls") {
																echo $rowd['rolno'];
															} else {
																echo "-";
															} ?></td>
										<td align="center"><?PHP if ($_GET['pk'] == "Bales") {
																echo $rowd['rolno'];
															} else {
																echo "-";
															} ?></td>
										<td align="right"><?PHP echo number_format($rowd['weight'], '2', '.', ','); ?></td>
										<td align="right"><?PHP echo number_format($rowd['yard_'], '2', '.', ','); ?></td>
										<td align="right"><?PHP echo number_format($rowd['yard_'] * 0.9144, '2', '.', ','); ?></td>
										<td align="center"><?PHP if ($rowd['ukuran'] == "") {
																echo "-";
															} else {
																echo $rowd['ukuran'] . "CM";
															} ?></td>
										<td align="right"><?PHP if ($rowd['weight'] == "") {
																echo "-";
															} else {
																echo number_format($rowd['weight'] + $gw, '2', '.', ',');
															} ?></td>
										<td align="right"><?PHP
															if ($rowd['sisa'] == "FOC") {
																echo $rowd['sisa'];
															} elseif ($rowd['sisa'] == "SISA" or $rowd['sisa'] == "FKSI") {
																echo "SISA";
															} elseif ($rowd['sisa'] == "BS") {
																echo "BS";
															} else {
																echo "-";
															} ?></td>
									</tr>

								<?php
									if ($rowd['sisa'] == "SISA" or $rowd['sisa'] == "FKSI" or $rowd['sisa'] == "FOC") {
										$kgs = "0";
										$yds = "0";
									} else {
										$kgs = $rowd['weight'];
										$yds = $rowd['yard_'];
									}
									$totkgs = $totkgs + $kgs;
									$totyds = $totyds + $yds;
									if ($rowd['sisa'] == "SISA" or $rowd['sisa'] == "FKSI") {
										$rol = "0";
									} else {
										$rol = "1";
									}
									$trol = $trol + $rol;
									$no++;
								} ?>
							</tbody>
							<tfoot>
								<tr>
									<td align="center"><strong>Total</strong></td>
									<td align="center"><b><?php echo $trol; ?> Roll</b></td>
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
// LEFT JOIN SalesOrders so ON SOD.SOID = so.ID
// LEFT JOIN SODetailsAdditional SODA ON SODA.SODID=SOD.ID
// LEFT JOIN UnitDescription UD ON UD.id = SOD.UnitID
// LEFT JOIN JobOrders jo ON jo.SOID = so.ID
// LEFT JOIN Partners p ON p.ID = so.CustomerID
// LEFT JOIN ProductMaster pm ON pm.ID = SOD.ProductID
// LEFT JOIN ProductPartner pmp ON sod.ProductID = pmp.ProductID
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