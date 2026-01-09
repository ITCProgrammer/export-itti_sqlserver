<?php
$Item		= isset($_POST['itm_exp']) ? $_POST['itm_exp'] : '';
$Berat		= isset($_POST['berat']) ? $_POST['berat'] : '';
$TglExp	    = isset($_POST['tgl_export']) ? $_POST['tgl_export'] : '';
$Bahan		= isset($_POST['bahan']) ? $_POST['bahan'] : '';
$Konversi	= isset($_POST['konversi']) ? $_POST['konversi'] : '';
$KO			= isset($_POST['no_ko']) ? $_POST['no_ko'] : '';
$Note	    = isset($_POST['note']) ? $_POST['note'] : '';

$sqlDCI = mysqli_query($con,"SELECT c.po,c.item,c.color,a.no_pi,b.no_invoice,a.kg,a.panjang,a.satuan,a.pcs,a.id FROM tbl_exim_cim_detail a 
INNER JOIN tbl_exim_cim b ON b.id=a.id_cim
LEFT JOIN tbl_exim_pim_detail c ON a.id_pimd=c.id
WHERE a.id_cim='".$_GET['DCI']."' AND a.id='".$_GET['id']."' ORDER BY a.id ASC");
$rDCI = mysqli_fetch_array($sqlDCI);
$po = str_replace("'", "''", $rDCI['po']);

$qrybclkt = mysqli_query($con,"SELECT sum(bb_terpakai) as pakai FROM tbl_exim_pengembalian WHERE id_cimd='".$_GET['id']."'");
$rBCLKT = mysqli_fetch_array($qrybclkt);
$sisa = $data['berat'] - $rBCLKT['pakai'];
$sqlInv = mysqli_query($con,"SELECT * FROM tbl_exim_cim WHERE id='".$_GET['id']."' LIMIT 1");
$dInv = mysqli_fetch_array($sqlInv);
$sqlCek = mysqli_query($con,"SELECT * FROM tbl_exim_pengembalian WHERE id='".$_GET['idk']."'");
$Cek = mysqli_num_rows($sqlCek);
$rCek = mysqli_fetch_array($sqlCek);

if ($Bahan != "") {
	$idksng = " ";
} else {
	$idksng = " AND TM.dbo.StockMovement.ID='' ";
}
$qry = sqlsrv_query($conn,"select 
CAST([ProductNumber] AS VARCHAR(8000)) AS ProductNumber,
sum(TM.dbo.stockmovementdetails.weight) as berat,
count(TM.dbo.stockmovementdetails.weight) as qty,
sum(TM.dbo.stockmovementdetails.Quantity) as qty1
from (TM.dbo.StockMovement
LEFT join TM.dbo.stockmovementdetails on TM.dbo.StockMovement.ID=TM.dbo.stockmovementdetails.StockmovementID)
LEFT join TM.dbo.ProductProp on TM.dbo.ProductProp.ID=dbo.stockmovementdetails.ProductPropID
LEFT join TM.dbo.ProductMaster on TM.dbo.ProductMaster.ID=TM.dbo.stockmovementdetails.ProductID
where (TM.dbo.ProductMaster.ProductNumber LIKE '%-_' or TM.dbo.ProductMaster.ProductNumber LIKE '%-__') 
and ( TM.dbo.ProductMaster.ProductNumber='$Bahan' or TM.dbo.ProductMaster.ProductNumber LIKE '$Bahan%' ) AND 
	TM.dbo.StockMovement.transactionstatus='1' and 
	TM.dbo.StockMovement.transactiontype='4' and WID='11' and NOT FromToID=84 and TM.dbo.stockmovementdetails.Quantity > 0  $idksng group by	
	TM.dbo.ProductMaster.ProductNumber");
$data = sqlsrv_fetch_array($qry,SQLSRV_FETCH_ASSOC);
$qry1 = sqlsrv_query($conn,"SELECT CAST(c.Note as Varchar(200)) as note,c.PONumber FROM SalesOrders a
INNER JOIN SODetails b ON a.ID=b.SOID
INNER JOIN SODetailsAdditional c ON b.ID=c.SODID
WHERE a.SONumber='".$rDCI['no_pi']."' AND c.PONumber='$po'");
$data1 = sqlsrv_fetch_array($qry1,SQLSRV_FETCH_ASSOC);

?>
<div class="box box-info table-responsive">
	<form class="form-horizontal" action="" method="post" enctype="multipart/form-data" name="form1">
		<div class="box-header with-border">
			<h3 class="box-title">Form Tambah Pengembalian</h3>
			<div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
			</div>
		</div>
		<div class="box-body">
			<div class="form-group">
				<label for="itm_exp" class="col-sm-2 control-label">Item Export</label>
				<div class="col-sm-2">
					<input name="itm_exp" type="text" required="required" class="form-control" id="itm_exp" placeholder="Item Export" value="<?php if ($Item == "") {
																																					echo $rDCI['item'];
																																				} else {
																																					echo $Item;
																																				} ?>">
				</div>
				<div class="col-sm-2">
					<input name="warna" type="text" class="form-control" id="warna" placeholder="Color" value="<?php if ($Item == "") {
																										echo $rDCI['color'];
																												} ?>">
				</div>
				<div class="col-sm-2">
					<div class="input-group">
						<input name="berat" type="text" class="form-control" id="berat" value="<?php if ($Berat == "") {
																								echo $rDCI['kg'];
																								} else {
																									echo $Berat;
																								} ?>" placeholder="0.00" style="text-align: right;" autocomplete="off">
						<span class="input-group-addon">KGs</span>
					</div>
				</div>
				<div class="col-sm-2">
					<input name="no_ko" type="text" class="form-control" id="no_ko" value="<?php if ($Cek > 0) {
																								echo $rCek['ko'];
																							} else {
																								echo $KO;
																							} ?>" placeholder="No KO">
				</div>
				<div class="col-sm-2">
					<div class="input-group date">
						<div class="input-group-addon"> <i class="fa fa-calendar"></i> </div>
						<input type="text" name="tgl_export" class="form-control pull-right" id="datepicker" placeholder="Tgl Export" autocomplete="off" value="<?php echo $TglExp; ?>" required />
					</div>
				</div>
			</div>
			<?php
			if ($Cek > 0) {
				$BHN = $rCek['bahan_baku'];
			} else {
				$BHN = $Bahan;
			}
			if ($Cek > 0) {
				$KNV = $rCek['konversi'];
			} else {
				$KNV = $Konversi;
			}
			$qryBK = mysqli_query($con,"SELECT a.no_pend,a.tgl_pend,a.kurs,b.kd_benang_fs,b.tarif,b.no_urut,b.amount,b.qty,ROUND(b.amount/b.qty,2) as price,( ROUND( b.amount / b.qty, 2 ) * a.kurs * b.tarif ) AS bm 
			from tbl_exim_import a INNER JOIN tbl_exim_import_detail b ON a.id=b.id_import
			WHERE b.kd_benang_in='$BHN'");
			$rBK = mysqli_fetch_array($qryBK);
			$qryKONV = mysqli_query($con,"SELECT * FROM tk_konv_imp_temp WHERE SUBSTR(KD_KONV_EKS,12,20)='$Item' and KD_KONV_IMP='".$rBK['kd_benang_fs']."' AND SUBSTR(KD_KONV_EKS,1,10)='$KNV' LIMIT 1");
			$rKON = mysqli_fetch_array($qryKONV);
			?>
			<div class="form-group">
				<label for="bahan" class="col-sm-2 control-label">Bahan Baku</label>
				<div class="col-sm-2">
					<div class="input-group">
						<input name="bahan" type="text" required="required" class="form-control" id="bahan" placeholder="Bahan Baku" value="<?php if ($Cek > 0) {
																																				echo $rCek['bahan_baku'];
																																			} else {
																																				echo $Bahan;
																																			} ?>">
						<span class="input-group-btn">
							<button type="submit" class="btn btn-default" name="cek"><span class="fa fa-search"></span></button>
						</span>
					</div>

				</div>
				<div class="col-sm-2">
					<input name="kd_fs" type="text" class="form-control" id="kd_fs" value="<?php echo $rBK['kd_benang_fs']; ?>" placeholder="Kode FS">
				</div>
				<div class="col-sm-1">
					<input name="no_pib" type="text" class="form-control" id="no_pib" value="<?php echo $rBK['no_pend']; ?>" placeholder="No. Pend PIB">
				</div>
				<div class="col-sm-1">
					<input name="urutan" type="text" class="form-control" id="urutan" value="<?php echo $rBK['no_urut']; ?>" placeholder="Urutan">
				</div>
				<div class="col-sm-2">
					<input name="stk_pakai" type="text" class="form-control" id="stk_pakai" value="<?php echo round($data['berat'], 4); ?>" placeholder="STK Pakai" style="text-align: right;">
				</div>
				<div class="col-sm-2">
					<input name="stk_sisa" type="text" class="form-control" id="stk_sisa" value="<?php if ($BHN != "") {
																										echo round($sisa, 4);
																									} ?>" placeholder="STK Sisa" style="text-align: right;">
				</div>
			</div>
			<div class="form-group">
				<label for="konversi" class="col-sm-2 control-label">Konversi</label>
				<div class="col-sm-2">
					<div class="input-group">
						<select name="konversi" class="form-control select2">
							<option value=""></option>
							<?php $qryKON = mysqli_query($con,"SELECT a.ID_KONV, a.KD_KONV_EKS 
FROM
	tk_konv_eks_temp a
INNER JOIN tk_konv_imp_temp b ON a.KD_KONV_EKS=b.KD_KONV_EKS	
WHERE
	a.KD_KONV_EKS LIKE '%".$rDCI['item']."'
AND b.KD_KONV_IMP='".$rBK['kd_benang_fs']."'	
ORDER BY
	a.ID_KONV DESC");
							while ($rKONV = mysqli_fetch_array($qryKON)) { ?>
								<option value="<?php echo $rKONV['ID_KONV']; ?>" <?php if ($Konversi == $rKONV['ID_KONV']) {
																					echo "SELECTED";
																				} ?>><?php echo $rKONV['ID_KONV']; ?></option>
							<?php } ?>
						</select>
						<span class="input-group-btn">
							<button type="submit" class="btn btn-default" name="cek"><span class="fa fa-search"></span></button>
						</span>
					</div>
				</div>
				<?php $bbpakai = $rDCI['kg'] * $rKON['NIL_KOEFISIEN'];
				$bbkandung = $bbpakai * $rKON['NIL_KANDUNG'] / 100; ?>
				<div class="col-sm-1">
					<input name="koef" type="text" class="form-control" id="koef" value="<?php echo $rKON['NIL_KOEFISIEN']; ?>" placeholder="KOEF" style="text-align: right;">
				</div>
				<div class="col-sm-1">
					<input name="kandung" type="text" class="form-control" id="kandung" value="<?php echo $rKON['NIL_KANDUNG']; ?>" placeholder="TKNDNG" style="text-align: right;">
				</div>
				<div class="col-sm-1">
					<input name="waste" type="text" class="form-control" id="waste" value="<?php echo $rKON['NIL_WASTE']; ?>" placeholder="WASTE" style="text-align: right;">
				</div>
				<div class="col-sm-1">
					<input name="bb_pakai" type="text" class="form-control" id="bb_pakai" value="<?php echo round($bbpakai, 4); ?>" placeholder="BB PAKAI" style="text-align: right;">
				</div>
				<div class="col-sm-1">
					<input name="bb_tkdng" type="text" class="form-control" id="bb_tkdng" value="<?php echo round($bbkandung, 4); ?>" placeholder="BB TKDNG" style="text-align: right;">
				</div>
				<div class="col-sm-1">
					<input name="price" type="text" class="form-control" id="price" value="<?php echo $rBK['price']; ?>" placeholder="PRICE" style="text-align: right;">
				</div>
				<div class="col-sm-1">
					<input name="kurs" type="text" class="form-control" id="kurs" value="<?php echo $rBK['kurs']; ?>" placeholder="KURS" style="text-align: right;">
				</div>
				<div class="col-sm-1">
					<input name="bm" type="text" class="form-control" id="bm" value="<?php echo $rBK['tarif']; ?>" placeholder="BM" style="text-align: right;">
				</div>
			</div>
			<div class="form-group">
				<label for="nilai_kembali" class="col-sm-2 control-label">Nilai Pengembalian</label>
				<div class="col-sm-2">
					<?php $kembali = round(round($bbkandung, 4) * $rBK['price'] * $rBK['kurs'] * round($rBK['tarif'] / 100, 2), 4);	?>
					<input name="nilai_kembali" type="text" class="form-control" id="nilai_kembali" value="<?php if ($Cek > 0) {
																												echo $rCek['nilai'];
																											} else {
																												echo $kembali;
																											} ?>" placeholder="0" style="text-align: right;">
				</div>
				<div class="col-sm-2">
					<select name="sts" class="form-control">
						<option value="Ajukan" <?Php if ($rCek['sts'] == "Ajukan") {
													echo "SELECTED";
												} ?>>Ajukan</option>
						<option value="Tidak diajukan" <?Php if ($rCek['sts'] == "Tidak diajukan") {
															echo "SELECTED";
														} ?>>Tidak diajukan</option>
						<option value="Non-KITE" <?Php if ($rCek['sts'] == "Non-KITE") {
														echo "SELECTED";
													} ?>>Non-KITE</option>
					</select>
				</div>
				<div class="col-sm-2">
					<?php
					// hitung hari dan jam	 
					$awal  = strtotime($rBK['tgl_pend']);
					$akhir = strtotime($TglExp);
					$diff  = ($akhir - $awal);
					$tmenit = round($diff / (60), 2);
					$tjam  = round($diff / (60 * 60), 2);
					$hari  = round($tjam / 24);
					if ($akhir != "") {
						if ($hari <= 0) { ?>
							<span class="label label-danger">Warning: Export Mendahului Import <?php echo $rBK['tgl_pend']; ?></span>
						<?php } else if ($hari <= 20) { ?>
							<span class="label label-warning">Warning: Export Terlalu Cepat (<?php echo $hari; ?> Hari)</span>
						<?php } else if ($hari > 360) { ?>
							<span class="label label-danger">Warning: BB Expired (<?php echo $hari; ?> Hari)</span>
						<?php } ?>
						<?php if (($data['berat'] < $bbpakai) or ($sisa < $bbpakai)) { ?>
							<span class="label label-danger">Warning: Stok Tidak Cukup</span>
						<?php } ?>
					<?php } ?>
				</div>

			</div>
			<div class="form-group">
				<label for="note" class="col-sm-2 control-label">Note</label>
				<div class="col-sm-3">
					<textarea name="note" rows="5" class="form-control"><?php if ($Cek > 0) {
																			echo $rCek['note'];
																		} else {
																			echo $Note;
																		} ?></textarea>
				</div>
				<div class="col-sm-5">
					<textarea name="komkt" rows="5" class="form-control" id="komkt" placeholder="KO Marketing" value=""><?php echo $data1['note']; ?></textarea>
				</div>
			</div>
		</div>
		<div class="box-footer">

			<div class="col-sm-2">
				<button type="submit" class="btn btn-block btn-social btn-linkedin" name="save" style="width: 80%">Simpan <i class="fa fa-save"></i></button>
			</div>

			<button type="button" class="btn btn-default pull-right" name="save" Onclick="window.location='?p=Form-Detail-CI-Manual&id=<?php echo $_GET['DCI']; ?>'">Kembali <i class="fa fa-cycle"></i></button>
		</div>
		<!-- /.box-footer -->


	</form>
</div>
<div class="row">
	<div class="col-xs-12">
		<div class="box table-responsive">
			<div class="box-header with-border">

			</div>
			<div class="box-body">
				<?php $qry3 = mysqli_query($con,"SELECT * FROM tbl_exim_pengembalian WHERE id_cimd='".$_GET['id']."'"); ?>
				<table id="example2" class="table table-bordered table-hover table-striped" width="100%">
					<thead class="bg-green">
						<tr>
							<th width="108">
								<div align="center">No.</div>
							</th>
							<th width="237">
								<div align="center">Bahan Baku</div>
							</th>
							<th width="228">
								<div align="center">
									<div align="center">Kode Fasilitas</div>
							</th>
							<th width="182">
								<div align="center">No Pend PIB</div>
							</th>
							<th width="205">
								<div align="center">Urutan</div>
							</th>
							<th width="67">
								<div align="center">Waste</div>
							</th>
							<th width="58">
								<div align="center">Terpakai</div>
							</th>
							<th width="75">
								<div align="center"> Terkandung</div>
							</th>
							<th width="81">
								<div align="center">Pengembalian</div>
							</th>
							<th width="81">Status</th>
							<th width="81">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$c = 1;
						$no = 1;
						while ($r = mysqli_fetch_array($qry3)) {
							$bgcolor = ($c++ & 1) ? '#33CCFF' : '#FFCC99';
						?>
							<tr bgcolor="<?php echo $bgcolor; ?>">
								<td align="center"><?php echo $no; ?></td>
								<td align="center"><?php echo $r['bahan_baku']; ?></td>
								<td align="center"><?php echo $r['kode_fs']; ?></td>
								<td align="center"><?php echo $r['no_pend_pib']; ?></td>
								<td align="center"><?php echo $r['urutan']; ?></td>
								<td><?php echo $r['waste']; ?></td>
								<td><?php echo $r['bb_terpakai']; ?></td>
								<td><?php echo $r['bb_kandung']; ?></td>
								<td align="right"><?php echo number_format($r['nilai'], "2", ".", ","); ?></td>
								<td align="center"><?php if ($r['sts'] == "Ajukan") { ?><span class="label label-success"><?php echo $r['sts']; ?></span><?php } else if ($r['sts'] == "Non-KITE") { ?><span class="label label-primary"><?php echo $r['sts']; ?></span><?php } else { ?><span class="label label-danger"><?php echo $r['sts']; ?></span><?php } ?></td>
								<td align="center">
									<div class="btn-group"><a href="#" class="btn btn-xs btn-danger" onclick="confirm_delete('?p=pengembalian_hapus&id=<?php echo $r['id']; ?>&DCI=<?php echo $_GET['DCI']; ?>&idp=<?php echo $_GET['id']; ?>');"><i class="fa fa-trash"></i> </a><a href="index1.php?p=Form-Tambah-Pengembalian&DCI=<?php echo $_GET['DCI']; ?>&id=<?php echo $_GET['id']; ?>&idk=<?php echo $r['id']; ?>" class="btn btn-xs btn-info"><i class="fa fa-level-up"></i> </a></div>
								</td>
							</tr>
						<?php
							$no++;
						} ?>
					</tbody>

				</table>

			</div>
		</div>
	</div>
</div>
<!-- Modal Popup untuk delete-->
<div class="modal fade" id="delDetail" tabindex="-1">
	<div class="modal-dialog modal-sm">
		<div class="modal-content" style="margin-top:100px;">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" style="text-align:center;">Are you sure to delete this information ?</h4>
			</div>

			<div class="modal-footer" style="margin:0px; border-top:0px; text-align:center;">
				<a href="#" class="btn btn-danger" id="delete_link">Delete</a>
				<button type="button" class="btn btn-success" data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>
<?php

if (isset($_POST['save'])) {
	$note = str_replace("'", "''", $_POST['note']);
	$note1 = str_replace("'", "''", $_POST['komkt']);
	$qry1 = mysqli_query($con,"INSERT INTO tbl_exim_pengembalian SET
		id_cimd='".$_GET['id']."',
		ko='".$_POST['no_ko']."',
		ko_mk='$note1',
		itm_eks='".$_POST['itm_exp']."',
		qty_eks='".$_POST['berat']."',
		bahan_baku='".$_POST['bahan']."',
		kode_fs='".$_POST['kd_fs']."',
		no_pend_pib='".$_POST['no_pib']."',
		urutan='".$_POST['urutan']."',
		stok_terpakai='".$_POST['stk_pakai']."',
		sisa_stok='".$_POST['stk_sisa']."',
		konversi='".$_POST['konversi']."',
		koef='".$_POST['koef']."',
		terkandung='".$_POST['kandung']."',
		bb_terpakai='".$_POST['bb_pakai']."',
		bb_kandung='".$_POST['bb_tkdng']."',
		waste='".$_POST['waste']."',
		price='".$_POST['price']."',
		kurs='".$_POST['kurs']."',
		bm='".$_POST['bm']."',
		nilai='".$_POST['nilai_kembali']."',
		note='$note',
		sts='".$_POST['sts']."',
		tgl_buat=now(),
		tgl_update=now()
		");

	if ($qry1) {
		//echo "<script>alert('Data Tersimpan');</script>";
		//echo "<script>window.location.href='?p=Form-Pemeriksaan&no_mesin=$_GET[no_mesin]';</script>";
		echo "<script>swal({
  title: 'Data Tersimpan',
  text: 'Klik Ok untuk melanjutkan',
  type: 'success',
  }).then((result) => {
  if (result.value) {
    window.location.href='?p=Form-Tambah-Pengembalian&DCI=".$_GET['DCI']."&id=".$_GET['id']."';
  }
});</script>";
	} else {
		echo "There's been a problem: " . mysql_error();
	}
}

?>
<script type="text/javascript">
	function confirm_delete(delete_url) {
		$('#delDetail').modal('show', {
			backdrop: 'static'
		});
		document.getElementById('delete_link').setAttribute('href', delete_url);
	}
</script>